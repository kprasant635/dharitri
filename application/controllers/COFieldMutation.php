<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class COFieldMutation extends CI_Controller
{

    var $user_code;
    var $base_query;
    var $base_query1;
    var $db;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('mutation/cofieldmutationmodel');
        $this->user_code = $this->session->userdata('user_code');
        $this->load->model('basundhara/basundharamodel');
        $this->load->model('TransactionModel');
        $this->load->model('mutation/mutationmodel');
        $this->load->model('jamabandi/jamabandiAutoUpdateModel');
        $this->load->model('rtps/rtpsmodel');
        $this->load->model('mutation/mutationmodel');
        $this->load->model('AgriStackCaseHistory');
        if (!$this->input->is_ajax_request()) {
            //$this->load->view('../views/header');
        }
        if (ENABLED_BLOCKCHAIN == 1) {
            $this->load->model('propChain/PropChainModel');
            $this->load->model('propChain/PropChainCommonModel');
        }

        if (ESCALATION_ENABLE == 1) {
            $this->load->model('AutoEscalationmodel');
            $this->load->model('Escalationmodel');
        }

        if (MULTIGENERATION_ACTIVE == 1) {
            $this->load->model('ChithaUpdateForMutationModel');
        }

        $location = $this->utilityclass->getLocationFromSession();
        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];
        $db = $this->session->userdata('db');

        $year_no = year_no;
        $this->base_query = "dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and  cir_code = '$cir_code' ";
        $this->base_query1 = "dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and  cir_code = '$cir_code' ";
    }
    public function dbswitch()
    {
        //$CI=&get_instance();
        if ($this->session->userdata('dist_code') == "02") {
            $this->db = $this->load->database('dha3', TRUE);
        } else if ($this->session->userdata('dist_code') == "05") {
            $this->db = $this->load->database('dha1', TRUE);
        } else if ($this->session->userdata('dist_code') == "10") {
            $this->db = $this->load->database('dha24', TRUE);
        } else if ($this->session->userdata('dist_code') == "13") {
            $this->db = $this->load->database('dha2', TRUE);
        } else if ($this->session->userdata('dist_code') == "17") {
            $this->db = $this->load->database('dha4', TRUE);
        } else if ($this->session->userdata('dist_code') == "15") {
            $this->db = $this->load->database('dha5', TRUE);
        } else if ($this->session->userdata('dist_code') == "14") {
            $this->db = $this->load->database('dha6', TRUE);
        } else if ($this->session->userdata('dist_code') == "07") {
            $this->db = $this->load->database('dha7', TRUE);
        } else if ($this->session->userdata('dist_code') == "03") {
            $this->db = $this->load->database('dha8', TRUE);
        } else if ($this->session->userdata('dist_code') == "18") {
            $this->db = $this->load->database('dha9', TRUE);
        } else if ($this->session->userdata('dist_code') == "12") {
            $this->db = $this->load->database('dha13', TRUE);
        } else if ($this->session->userdata('dist_code') == "24") {
            $this->db = $this->load->database('dha10', TRUE);
        } else if ($this->session->userdata('dist_code') == "06") {
            $this->db = $this->load->database('dha11', TRUE);
        } else if ($this->session->userdata('dist_code') == "11") {
            $this->db = $this->load->database('dha12', TRUE);
        } else if ($this->session->userdata('dist_code') == "12") {
            $this->db = $this->load->database('dha13', TRUE);
        } else if ($this->session->userdata('dist_code') == "16") {
            $this->db = $this->load->database('dha14', TRUE);
        } else if ($this->session->userdata('dist_code') == "32") {
            $this->db = $this->load->database('dha15', TRUE);
        } else if ($this->session->userdata('dist_code') == "33") {
            $this->db = $this->load->database('dha16', TRUE);
        } else if ($this->session->userdata('dist_code') == "34") {
            $this->db = $this->load->database('dha17', TRUE);
        } else if ($this->session->userdata('dist_code') == "21") {
            $this->db = $this->load->database('dha18', TRUE);
        } else if ($this->session->userdata('dist_code') == "08") {
            $this->db = $this->load->database('dha19', TRUE);
        } else if ($this->session->userdata('dist_code') == "35") {
            $this->db = $this->load->database('dha20', TRUE);
        } else if ($this->session->userdata('dist_code') == "36") {
            $this->db = $this->load->database('dha21', TRUE);
        } else if ($this->session->userdata('dist_code') == "37") {
            $this->db = $this->load->database('dha22', TRUE);
        } else if ($this->session->userdata('dist_code') == "25") {
            $this->db = $this->load->database('dha23', TRUE);
        } else if ($this->session->userdata('dist_code') == "39") {
            $this->db = $this->load->database('dha39', TRUE);
        }
    }

    public function index()
    {
        $db = $this->session->userdata('db');
        $this->load->helper('html');
        $this->load->view('skmutation/index');
        $this->load->view('../views/footer');
    }

    public function getPendingFMCases_before_pagination()
    {
        $db = $this->session->userdata('db');
        $append = $this->base_query1;
        $cases['cases'] = $this->cofieldmutationmodel->getPendingFMCases()->result();

        $case_array = array();
        foreach ($cases['cases'] as $c) {
            $q = $this->db->query("select count(consent) from copattadar_consent where case_no='$c->case_no' and consent='n' and " . $append)->row();
            $c->consent = $q->count;
            array_push($case_array, $c);
        }
        $cases['cases'] = $case_array;
        // $this->load->view('../views/comutation/casesfm', $cases);
        // $this->load->view('../views/footer');
        $cases['_view'] = 'comutation/casesfm';
        $this->load->view('layouts/main', $cases);
    }

    // public function getPendingFMCasesold()
    // {
    //     //xss & security validation starts
    //     $errorMessageStr = '';
    //     $resp = checkRequestSpecChar($_POST);


    //     if ($resp['status'] == 'n') {
    //         $errorMessageStr .= $resp['messages'];
    //     }
    //     $resp = checkRequestValidQuery($_POST);
    //     if ($resp['status'] == 'n') {
    //         $errorMessageStr .= $resp['messages'];
    //     }
    //     if ($errorMessageStr != '') {
    //         $this->session->set_flashdata('message', $errorMessageStr);
    //         return redirect($_SERVER['HTTP_REFERER']);
    //     }
    //     //xss & security validation ends         
    //     $this->load->library('pagination');
    //     $db = $this->session->userdata('db');
    //     $append = $this->base_query1;

    //     $case_array = array();
    //     $searchKeyword = null;
    //     if ($this->input->post('submitSearch')) {
    //         $inputKeywords = $this->input->post('searchKeyword');
    //         $searchKeyword = strip_tags($inputKeywords);
    //         if (!empty($searchKeyword)) {
    //             $this->session->set_userdata('searchKeyword', $searchKeyword);
    //         } else {
    //             $this->session->unset_userdata('searchKeyword');
    //         }
    //     } elseif ($this->input->post('submitSearchReset')) {
    //         $this->session->unset_userdata('searchKeyword');
    //     }

    //     $cases['searchKeyword'] = $this->session->userdata('searchKeyword');
    //     $config['base_url'] = base_url() . 'index.php/cofieldmutation/getPendingFMCases';
    //     $config['total_rows'] = $this->cofieldmutationmodel->count_getPendingFMCases();
    //     $config['per_page'] = 50;
    //     $config['uri_segment'] = 3;
    //     $config['full_tag_open'] = '<ul class="pagination">';
    //     $config['full_tag_close'] = '</ul>';
    //     $config['first_link'] = 'First';
    //     $config['last_link'] = 'Last';
    //     $config['first_tag_open'] = '<li>';
    //     $config['first_tag_close'] = '</li>';
    //     $config['prev_link'] = '&laquo';
    //     $config['prev_tag_open'] = '<li class="prev">';
    //     $config['prev_tag_close'] = '</li>';
    //     $config['next_link'] = '&raquo';
    //     $config['next_tag_open'] = '<li>';
    //     $config['next_tag_close'] = '</li>';
    //     $config['last_tag_open'] = '<li>';
    //     $config['last_tag_close'] = '</li>';
    //     $config['cur_tag_open'] = '<li class="active"><a href="#">';
    //     $config['cur_tag_close'] = '</a></li>';
    //     $config['num_tag_open'] = '<li>';
    //     $config['num_tag_close'] = '</li>';
    //     $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
    //     $this->pagination->initialize($config);
    //     $cases['links'] = $this->pagination->create_links();
    //     $cases['cases'] = $this->cofieldmutationmodel->getPendingFMCases($config["per_page"], $page, $searchKeyword);
    //     $cases['_view'] = 'comutation/casesfm';
    //     $this->load->view('layouts/main', $cases);
    // }




    //Prasant optimize
    public function getPendingFMCases()
    {

        $errorMessageStr = '';

        $resp = checkRequestSpecChar($_POST);
        if ($resp['status'] === 'n') {
            $errorMessageStr .= $resp['messages'];
        }

        $resp = checkRequestValidQuery($_POST);
        if ($resp['status'] === 'n') {
            $errorMessageStr .= $resp['messages'];
        }

        if ($errorMessageStr !== '') {
            $this->session->set_flashdata('message', $errorMessageStr);
            return redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->library('pagination');


        $searchKeyword = null;

        if ($this->input->post('submitSearch')) {
            $searchKeyword = trim(strip_tags($this->input->post('searchKeyword')));
            $this->session->set_userdata('searchKeyword', $searchKeyword);
        }

        if ($this->input->post('submitSearchReset')) {
            $this->session->unset_userdata('searchKeyword');
        }



        $searchKeyword = $this->session->userdata('searchKeyword');


        // ---------------- Pagination ----------------
        $perPage = 5;
        $page = ($this->uri->segment(3)) ? (int) $this->uri->segment(3) : 0;

       

        $config = [
            'base_url' => base_url('index.php/cofieldmutation/getPendingFMCases'),
            'total_rows' => $this->cofieldmutationmodel->count_getPendingFMCases(),
            'per_page' => $perPage,
            'uri_segment' => 3,
            'reuse_query_string' => TRUE,

            // ===== Pagination HTML =====
            'full_tag_open' => '<nav aria-label="Page navigation"><ul class="pagination justify-content-center pagination-sm">',
            'full_tag_close' => '</ul></nav>',

            'first_link' => '⏮ First',
            'first_tag_open' => '<li class="page-item">',
            'first_tag_close' => '</li>',

            'last_link' => 'Last ⏭',
            'last_tag_open' => '<li class="page-item">',
            'last_tag_close' => '</li>',

            'prev_link' => '&lsaquo;',
            'prev_tag_open' => '<li class="page-item">',
            'prev_tag_close' => '</li>',

            'next_link' => '&rsaquo;',
            'next_tag_open' => '<li class="page-item">',
            'next_tag_close' => '</li>',

            'cur_tag_open' => '<li class="page-item active"><a class="page-link" href="#">',
            'cur_tag_close' => '</a></li>',

            'num_tag_open' => '<li class="page-item">',
            'num_tag_close' => '</li>',

            'attributes' => ['class' => 'page-link'],
        ];


        $this->pagination->initialize($config);

        // ---------------- Data ----------------
        $cases = [];
        $cases['searchKeyword'] = $searchKeyword;
        $cases['links'] = $this->pagination->create_links();
        $cases['cases'] = $this->cofieldmutationmodel->getPendingFMCases($config["per_page"], $page, $searchKeyword);

        $cases['_view'] = 'comutation/casesfm';
        $this->load->view('layouts/main', $cases);

    }

    public function getPendingPartitionCases_before_pagination()
    {
        $db = $this->session->userdata('db');
        $append = $this->base_query1;
        $cases['cases'] = $this->cofieldmutationmodel->getPendingPartitionCases()->result();
        $case_array = array();

        foreach ($cases['cases'] as $c) {
            $q = $this->db->query("select count(consent) from   copattadar_consent where case_no='$c->case_no' and consent='n' and " . $append)->row();
            $c->consent = $q->count;
            array_push($case_array, $c);
        }
        $cases['cases'] = $case_array;
        // $this->load->view('../views/comutation/cases', $cases);
        // $this->load->view('../views/footer');
        $cases['_view'] = 'comutation/cases';
        $this->load->view('layouts/main', $cases);
    }


    public function viewcasedetails()
    {
        $db = $this->session->userdata('db');
        // $case_no = $this->input->get('case_no');
        $_GET['case_no'] = dec_param($this->input->get('case_no'), 'case_no');
        if ($_GET['case_no'] == null) {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
        $lot_no1 = $this->input->get('lot_no');
        $vill_townprt_code1 = $this->input->get('vill_townprt_code');

        $q = "select * from   field_mut_dag_details d,patta_code p where d.case_no='$case_no' and d.patta_type_code=p.type_code and $this->base_query1 "
            . "and mouza_pargona_code = '$mouza_pargona_code1' and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1'";

        $dag_details = $this->db->query("select * from   field_mut_dag_details d,patta_code p where d.case_no='$case_no' and d.patta_type_code=p.type_code "
            . "and $this->base_query1 and mouza_pargona_code = '$mouza_pargona_code1' and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1'")->result();
        $data['case_no'] = $case_no;
        $data['dist_code'] = $dist_code;
        $data['subdiv_code'] = $subdiv_code;
        $data['cir_code'] = $cir_code;
        $data['mouza_pargona_code'] = $mouza_pargona_code1;
        $data['lot_no'] = $lot_no1;
        $data['vill_townprt_code'] = $vill_townprt_code1;
        $data['dag_details'] = $dag_details;
        $data['basuCase'] = null;
        $data['basuCase'] = $basundharaExist = $this->basundharamodel->checkExistBasundhar($case_no);
        if ($basundharaExist) {
            $data['query'] = null;
            $data['basundharaAttachment'] = $this->basundharamodel->searchBasundharaLink($case_no);
            $data['sup_doc'] = $this->db->query("SELECT * FROM supportive_document WHERE case_no=?", array($case_no))->result();
            $data['query'] = $this->basundharamodel->QueryPost($basundharaExist);
        }
        $data['_view'] = 'comutation/casedetails';
        $this->load->view('layouts/main', $data);
    }

    public function coorder()
    {
        $db = $this->session->userdata('db');

        $case_no = $this->input->get('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
        $lot_no1 = $this->input->get('lot_no');
        $vill_townprt_code1 = $this->input->get('vill_townprt_code');


        $q = "select * from   field_mut_basic mb,lm_code where case_no='$case_no' and mb.user_code = lm_code.lm_code and mb.dist_code = lm_code.dist_code and "
            . "mb.subdiv_code = lm_code.subdiv_code and mb.cir_code = lm_code.cir_code and mb.mouza_pargona_code = lm_code.mouza_pargona_code and "
            . "mb.lot_no = lm_code.lot_no and mb.dist_code = '$dist_code' and mb.subdiv_code = '$subdiv_code' and mb.cir_code = '$cir_code' and "
            . "mb.mouza_pargona_code='$mouza_pargona_code1' and mb.lot_no='$lot_no1' and mb.vill_townprt_code='$vill_townprt_code1' ";
        $data['details'] = $this->db->query($q)->row();


        // $q = "select * from   field_mut_dag_details where case_no='$case_no' and mouza_pargona_code = '$mouza_pargona_code1' and "
        //         . "lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1' and $this->base_query1 ";
        // $data['remark'] = $this->db->query($q)->row();
        $query = "Select remark,date(date_entry) as date_entry from (
                Select remark,date_entry from field_mut_dag_details where case_no='$case_no' union 
                SElect co_order as remark,date_entry from petition_proceeding  where case_no='$case_no' and user_code like 'M%' )
                 as t order by date_entry desc limit 1";
        $data['remark'] = $this->db->query($query)->row();


        $data['case_no'] = $case_no;
        $data['dist_code'] = $dist_code;
        $data['subdiv_code'] = $subdiv_code;
        $data['cir_code'] = $cir_code;
        $data['mouza_pargona_code'] = $mouza_pargona_code1;
        $data['lot_no'] = $lot_no1;
        $data['vill_townprt_code'] = $vill_townprt_code1;

        // $this->load->helper('html');
        //$this->load->view('../views/comutation/coorderform', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'comutation/coorderform';
        $this->load->view('layouts/main', $data);
    }

    public function savecoorderNew()
    {
        $db = $this->session->userdata('db');
        $case_no = $this->input->post('case_no');
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');

        $mut_type = $this->db->query("select mut_type from   field_mut_basic where case_no='$case_no' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no'"
            . " and vill_townprt_code='$vill_townprt_code' and $this->base_query1")->row()->mut_type;
        $offset = 0;
        $count = $this->db->query("select count(*) as count from   field_mut_dag_details where case_no='$case_no' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no'"
            . " and vill_townprt_code='$vill_townprt_code' and $this->base_query1")->row()->count;
        //echo $count;
        for ($i = 0; $i < $count; $i++) {

            $data1 = $this->db->query("select * from   field_mut_dag_details where case_no='$case_no' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no'"
                . " and vill_townprt_code='$vill_townprt_code' and $this->base_query1 offset $offset limit 1")->row();
            $array1 = array();
            foreach ($data1 as $key => $value) {
                $array1[$key] = $value;
            }
            $array1['lm_note_date'] = $array1['date_entry'];

            unset($array1['m_dag_area_b']);
            unset($array1['m_dag_area_k']);
            unset($array1['m_dag_area_lc']);
            unset($array1['m_dag_area_g']);
            unset($array1['m_dag_area_kr']);
            unset($array1['dag_area_b']);
            unset($array1['dag_area_k']);
            unset($array1['dag_area_lc']);
            unset($array1['dag_area_g']);
            unset($array1['dag_area_kr']);
            unset($array1['patta_no']);
            unset($array1['patta_type_code']);
            unset($array1['user_code']);
            unset($array1['date_entry']);
            unset($array1['operation']);
            unset($array1['obj_flag']);
            unset($array1['up_flag']);
            unset($array1['up_date']);
            unset($array1['land_valuation']);
            unset($array1['remark']);
            unset($array1['trans_code']);

            $data2 = $this->db->query("select rajah_adalat,mut_type,trans_code,sk_id,min_revenue from   field_mut_basic where case_no='$case_no' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and $this->base_query1")->row();
            $array2 = array();
            foreach ($data2 as $key => $value) {
                $array2[$key] = $value;
            }

            $data4 = array();

            foreach ($_POST as $k => $v) {
                $data4[$k] = $v;
            }

            $sk_code = $data2->sk_id;
            $order_type_code = $data2->mut_type;

            unset($array2['trans_code']);
            unset($array2['sk_id']);
            unset($array2['mut_type']);
            $data3 = array(
                'mut_land_area_b' => $data1->m_dag_area_b,
                'mut_land_area_k' => $data1->m_dag_area_k,
                'mut_land_area_lc' => $data1->m_dag_area_lc,
                'mut_land_area_g' => $data1->m_dag_area_g,
                'mut_land_area_kr' => $data1->m_dag_area_kr,
                'land_area_left_b' => ($data1->dag_area_b - $data1->m_dag_area_b),
                'land_area_left_k' => ($data1->dag_area_k - $data1->m_dag_area_k),
                'land_area_left_lc' => ($data1->dag_area_lc - $data1->m_dag_area_lc),
                'land_area_left_g' => ($data1->dag_area_g - $data1->m_dag_area_g),
                'land_area_left_kr' => ($data1->dag_area_kr - $data1->m_dag_area_kr),
                'rajah_adalat' => $data2->rajah_adalat,
                'nature_trans_code' => $data2->trans_code,
                'min_revenue' => $data2->min_revenue,
                'sk_code' => $sk_code,
                'order_type_code' => $order_type_code,
                'case_no' => $case_no,
            );

            $final_data = array_merge($data3, $array1, $array2, $data4);

            $final_data['co_ord_date'] = date('Y-m-d', strtotime($final_data['co_ord_date']));
            if (!$this->session->userdata('final_order')) {
                $this->session->set_userdata('final_order', array());
                $fd = $this->session->userdata('final_data');
                $fd[] = $final_data;
                $this->session->set_userdata('final_order', $fd);
            } else {
                $appdet = $this->session->userdata('final_order');
                $appdet[] = $final_data;
                $this->session->set_userdata('final_order', $appdet);
            }
            $offset++;
        }
        if ($mut_type == '01') {
            redirect(base_url() . "index.php/cofieldmutation/saveoccupant?case_no=" . $case_no . "&dist_code=" . $dist_code . "&subdiv_code=" . $subdiv_code . "&cir_code=" . $cir_code . "&mouza_pargona_code=" . $mouza_pargona_code . "&lot_no=" . $lot_no . "&vill_townprt_code=" . $vill_townprt_code);
        } else if ($mut_type == '02') {
            redirect(base_url() . "index.php/cofieldmutation/saveOccupantPartitionNew?case_no=" . $case_no . "&dist_code=" . $dist_code . "&subdiv_code=" . $subdiv_code . "&cir_code=" . $cir_code . "&mouza_pargona_code=" . $mouza_pargona_code . "&lot_no=" . $lot_no . "&vill_townprt_code=" . $vill_townprt_code);
        }
    }

    public function saveOccupantPartitionNew()
    {
        $db = $this->session->userdata('db');
        $case_no = $this->input->get('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
        $lot_no1 = $this->input->get('lot_no');
        $vill_townprt_code1 = $this->input->get('vill_townprt_code');

        $data['case_no'] = $case_no;
        $basic_details = $this->db->query("select * from   field_mut_basic where case_no='$case_no' and mouza_pargona_code='$mouza_pargona_code1' and "
            . "lot_no='$lot_no1' and vill_townprt_code='$vill_townprt_code1' and $this->base_query1")->row();
        $data['revenue'] = $basic_details->min_revenue;
        $data['local_tax'] = $basic_details->min_revenue / 4;

        $dagapply = $this->db->query("select * from   field_mut_dag_details where case_no='$case_no' and mouza_pargona_code='$mouza_pargona_code1' and "
            . "lot_no='$lot_no1' and vill_townprt_code='$vill_townprt_code1' and $this->base_query1")->row();
        $data['dagapply'] = $dagapply;
        $patta_type_code = $dagapply->patta_type_code;
        $data['patta_type'] = $this->db->query("select patta_type as patta_type from   patta_code where type_code = '$dagapply->patta_type_code'")->row()->patta_type;

        $data['petitioner'] = $this->db->query("select * from   field_part_petitioner where case_no='$case_no' and mouza_pargona_code='$mouza_pargona_code1' and "
            . "lot_no='$lot_no1' and vill_townprt_code='$vill_townprt_code1' and $this->base_query1")->result();

        $q = "select dag_no from   chitha_basic where dist_code = '$basic_details->dist_code' and subdiv_code='$basic_details->subdiv_code' and "
            . "cir_code = '$basic_details->cir_code' and mouza_pargona_code='$basic_details->mouza_pargona_code' and lot_no='$basic_details->lot_no' "
            . "and vill_townprt_code = '$basic_details->vill_townprt_code' order by dag_no_int desc";

        $dag_nos = $this->db->query($q)->row();

        $notinsql = "Select type_code from   patta_code where mutation='a' ";
        $patta_nos = $this->db->query("select patta_no from   chitha_basic where dist_code = '$basic_details->dist_code' and subdiv_code='$basic_details->subdiv_code' "
            . "and cir_code = '$basic_details->cir_code' and mouza_pargona_code='$basic_details->mouza_pargona_code' and lot_no='$basic_details->lot_no' and "
            . "vill_townprt_code = '$basic_details->vill_townprt_code' and patta_type_code='$dagapply->patta_type_code' and  (patta_type_code in ($notinsql)) ")->result();

        $patta_all = $this->db->query("select distinct(patta_no) as patta_no from   chitha_basic where dist_code = '$basic_details->dist_code' and "
            . "subdiv_code='$basic_details->subdiv_code' and cir_code = '$basic_details->cir_code' and mouza_pargona_code='$basic_details->mouza_pargona_code' and "
            . "lot_no='$basic_details->lot_no' and vill_townprt_code = '$basic_details->vill_townprt_code' and TRIM(patta_no)!='' and TRIM(patta_no)!='.' "
            . "and (patta_type_code in ($notinsql)) and patta_type_code='$patta_type_code' order by patta_no")->result();

        $dag_nos_all = $this->db->query("select dag_no from   chitha_basic where dist_code = '$basic_details->dist_code' and subdiv_code='$basic_details->subdiv_code' and "
            . "cir_code = '$basic_details->cir_code' and mouza_pargona_code='$basic_details->mouza_pargona_code' and lot_no='$basic_details->lot_no' and "
            . "vill_townprt_code = '$basic_details->vill_townprt_code' order by dag_no_int")->result();


        $pattas = array();

        foreach ($patta_nos as $p) {
            $pattas[] = (int) (trim($p->patta_no));
        }

        $new_dag = $dag_nos->dag_no + 1;
        $new_patta = max($pattas) + 1;

        $q = "select max(new_dag_no) as t_max_dag,max(new_patta_no) as t_max_patta from   t_chitha_col8_occup where dist_code = '$basic_details->dist_code'"
            . " and subdiv_code='$basic_details->subdiv_code' and cir_code = '$basic_details->cir_code'"
            . " and mouza_pargona_code='$basic_details->mouza_pargona_code'"
            . " and lot_no='$basic_details->lot_no' and vill_townprt_code = '$basic_details->vill_townprt_code' and new_dag_no!='' and trim(new_patta_no)!='' ";
        $t_max_dp = $this->db->query($q)->row();
        //var_dump($t_max_dp);
        $t_max_dag = $t_max_dp->t_max_dag;
        $t_max_patta = $t_max_dp->t_max_patta;
        if ($new_dag <= $t_max_dag) {
            $new_dag = $new_dag + 1;
        }
        if ($new_patta <= $t_max_patta) {
            $new_patta = $new_patta + 1;
        }
        $data['new_dag'] = $new_dag;
        $data['new_patta'] = $new_patta;
        $data['dags_all'] = $dag_nos_all;
        $data['patta_all'] = $patta_all;

        $q = "select count(*) from   chitha_pattadar p join chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and "
            . "p.cir_code = d.cir_code and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code "
            . "and p.pdar_id = d.pdar_id where p.dist_code='$basic_details->dist_code' and p.subdiv_code='$basic_details->subdiv_code' and p.cir_code='$basic_details->cir_code' "
            . "and p.mouza_pargona_code='$basic_details->mouza_pargona_code' and p.vill_townprt_code='$basic_details->vill_townprt_code' and d.lot_no='$basic_details->lot_no' "
            . "and d.dag_no='$dagapply->dag_no' and TRIM(p.patta_no)=trim('$dagapply->patta_no') and p.patta_type_code='$dagapply->patta_type_code' and d.p_flag != '1' "
            . "and p.pdar_id not in (select pdar_id from   field_part_petitioner where case_no='$case_no')";
        $data['check'] = $this->db->query($q)->result();
        // for checking if its full dag partition.
        /////////////////22-04-2022//////////////////////
        $data['areaFromChitha'] = $areaFromChitha = $this->db->query("select dag_area_b,dag_area_k,dag_area_lc,dag_area_g from   chitha_basic where dist_code = '$basic_details->dist_code' and subdiv_code='$basic_details->subdiv_code' and "
            . "cir_code = '$basic_details->cir_code' and mouza_pargona_code='$basic_details->mouza_pargona_code' and lot_no='$basic_details->lot_no' and "
            . "vill_townprt_code = '$basic_details->vill_townprt_code' and dag_no= '$dagapply->dag_no' ")->row();
        //////////////////////////////////////
        // for checking if its full dag partition.
        $applied_lessa = $this->utilityclass->Total_Lessa($dagapply->m_dag_area_b, $dagapply->m_dag_area_k, $dagapply->m_dag_area_lc);
        $original_lessa = $this->utilityclass->Total_Lessa($areaFromChitha->dag_area_b, $areaFromChitha->dag_area_k, $areaFromChitha->dag_area_lc);
        if ($applied_lessa == $original_lessa) {
            $data['land_area_check'] = '0';
        } else {
            $data['land_area_check'] = '1';
        }
        $data['check'][0]->count;
        //if all pattadars are not selected and full area is selected then not allowed     
        // if (($data['check'][0]->count != '0') && ($data['land_area_check'] == '0')) {
        //     //$this->db->trans_rollback();
        //     $this->session->set_flashdata('message', "For Full Land area all pattadar(s) should be selected!");
        //     redirect(base_url() . "index.php/home");
        //     return;
        // }
        //if single owner is selected and partial land area is selected then not allowed
        if (($data['check'][0]->count == '0') && ($data['land_area_check'] != '0')) {
            //$this->db->trans_rollback();
            $this->session->set_flashdata('message', "For all selected pattadars  of the dag with partial area partition is not allowed");
            redirect(base_url() . "index.php/home");
            return;
        }
        $data['_view'] = 'comutation/occupantdetailspartitionNew';
        $this->load->view('layouts/main', $data);
    }

    public function chech_dag_patta_exist($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $new_dag_no, $new_patta_no, $new_patta_type)
    {
        $db = $this->session->userdata('db');
        $check_dag = $this->db->query("Select count(*) as cd from   chitha_basic where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and "
            . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code' and patta_no = '$new_patta_no' and patta_type_code = '$new_patta_type'")->row()->cd;

        //if $check_dag is 1 then the dag exist
        echo json_encode($check_dag);
    }

    // public function saveOccupantPartitionOrder_old(){
    //     $db=  $this->session->userdata('db');
    //     $this->db->trans_begin();
    //     $dist_code = $this->session->userdata('dist_code');
    //     $cir_code = $this->session->userdata('cir_code');
    //     $subdiv_code = $this->session->userdata('subdiv_code');
    //     $mouza_pargona_code1 = $this->input->post('mouza_pargona_code');
    //     $lot_no1 = $this->input->post('lot_no');
    //     $vill_townprt_code1 = $this->input->post('vill_townprt_code');

    //     $case_no = $this->input->post('case_no');
    //     $new_dag = $this->input->post('sugg_dag_no');
    //     $new_patta = $this->input->post('sugg_patta_no');
    //     $bigha = $this->input->post('bigha_applied');
    //     $katha = $this->input->post('katha_applied');
    //     $lessa= $this->input->post('lessa_applied');
    //     $date=date('Y-m-d');
    //     $occup_query = "select mp.dist_code,mp.subdiv_code,mp.cir_code,mp.mouza_pargona_code,mp.lot_no,mp.vill_townprt_code,"
    //             . "mp.pdar_id,mp.year_no,mp.petition_no,mp.pdar_add1,mp.pdar_add2,mp.pdar_name,mp.pdar_guardian,mp.pdar_rel_guar,"
    //             . "dd.patta_no,dd.patta_type_code,mp.pdar_dag_por_b,mp.pdar_dag_por_k,mp.pdar_dag_por_lc,dd.dag_no from   "
    //             . "field_part_petitioner mp,field_mut_dag_details dd where mp.cir_code=dd.cir_code and mp.case_no = dd.case_no "
    //             . "and mp.case_no='$case_no' and mp.cir_code ='$cir_code' and mp.subdiv_code='$subdiv_code' and mp.mouza_pargona_code = '$mouza_pargona_code1' "
    //             . "and mp.lot_no = '$lot_no1' and mp.vill_townprt_code = '$vill_townprt_code1' limit 1";

    //     $petitioner_save = $this->db->query($occup_query)->row();

    //     // $q = "update field_mut_basic set order_passed='y',date_of_order='$date' where case_no='$case_no' and mouza_pargona_code = '$mouza_pargona_code1' "
    //     //         . "and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1' and $this->base_query1";
    //     // $this->db->query($q); //****************************

    //     $occup_data = "select * from   field_part_petitioner where case_no='$case_no' and mouza_pargona_code = '$mouza_pargona_code1' "
    //             . "and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1' and $this->base_query";
    //     $occup_data = $this->db->query($occup_data)->result();

    //     $get_mut_type = $this->db->query("Select mut_type as mut_type from   field_mut_basic where case_no='$case_no' and mouza_pargona_code = '$mouza_pargona_code1' "
    //             . "and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1' and $this->base_query")->row()->mut_type;
    //     if($get_mut_type == '02')
    //     {
    //         $new_pattadar = 'N';
    //         $sql="Select patta_type_code,dag_no from field_mut_dag_details where case_no='$case_no' ";
    //         $dd=$this->db->query($sql)->row();
    //         $pp_code=$dd->patta_type_code;
    //         $old=$dd->dag_no;
    //         $sql="Select count(*) as d from chitha_basic where mouza_pargona_code = '$mouza_pargona_code1' "
    //             . "and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1' and $this->base_query and dag_no='$new_dag' and dag_no!='$old' ";
    //         $count=$this->db->query($sql)->row()->d;
    //         if($count>0){                
    //             $this->db->trans_rollback();
    //             $this->session->set_flashdata('message', "The Dag no you have given already exist ! Please re-verify the dag no again");
    //             redirect(base_url() . "index.php/home");
    //             return;
    //         }
    //         $sql="Select count(*) as c from chitha_pattadar where mouza_pargona_code = '$mouza_pargona_code1' "
    //             . "and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1' and $this->base_query and patta_no='$new_patta' and patta_type_code='$pp_code' ";           
    //         $count=$this->db->query($sql)->row()->c;
    //         if($count>0){                
    //             $this->db->trans_rollback();
    //             $this->session->set_flashdata('message', "The patta no you have selected already exist pattadar !");
    //             redirect(base_url() . "index.php/home");
    //             return;
    //         }
    //     }
    //     else
    //     {
    //         $new_pattadar = '';
    //     }
    //     if($occup_data==null){
    //         $this->db->trans_rollback();
    //         $this->session->set_flashdata('message', "Petitioner Data not found");
    //         redirect(base_url() . "index.php/home");
    //     }
    //     //var_dump($occup_data);
    //     foreach ($occup_data as $occup) {
    //         //var_dump($occup);
    //         $t_chitha_col8_occup = array(
    //             'dist_code'=>$occup->dist_code, 
    //             'subdiv_code'=>$occup->subdiv_code,
    //             'cir_code'=>$occup->cir_code,
    //             'mouza_pargona_code'=>$occup->mouza_pargona_code,
    //             'lot_no'=>$occup->lot_no, 
    //             'vill_townprt_code'=>$occup->vill_townprt_code, 
    //             'dag_no'=>$occup->dag_no,//$new_dag, //should be the new dag
    //             'year_no'=>$occup->year_no, 
    //             'petition_no'=>$occup->petition_no, 
    //             'occupant_id'=>$occup->pdar_cron_no, 
    //             'patta_type_code'=>$occup->patta_type_code,
    //             'patta_no'=>$occup->patta_no,//$new_patta,  //should be the new patta no
    //             'pdar_id'=>$occup->pdar_id, 
    //             'occupant_name'=>$occup->pdar_name, 
    //             'occupant_fmh_name'=>$occup->pdar_guardian, 
    //             'occupant_fmh_flag'=>$occup->pdar_rel_guar, 
    //             'occupant_add1'=>$occup->pdar_add1, 
    //             'occupant_add2'=>$occup->pdar_add2, 
    //             'land_area_b'=>$occup->pdar_dag_por_b, 
    //             'land_area_k'=>$occup->pdar_dag_por_k, 
    //             'land_area_lc'=>$occup->pdar_dag_por_lc, 
    //             'land_area_g'=>'0', 
    //             'land_area_kr'=>'0', 
    //             'old_patta_no'=>$occup->patta_no, 
    //             'new_patta_no'=>$new_patta, 
    //             'old_dag_no'=>$occup->dag_no, 
    //             'new_dag_no'=>$new_dag,  
    //             'new_pattadar'=>$new_pattadar, 
    //         );
    //         //var_dump($t_chitha_col8_occup);
    //         $tstatus1 = $this->db->insert("t_chitha_col8_occup", $t_chitha_col8_occup); //****************************
    //         if ($tstatus1 != 1 )
    //         {
    //            $this->db->trans_rollback();
    //            $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#FP001)");
    //            redirect(base_url() . "index.php/home");
    //         }
    //         // ////////////Set Patta For JamaUpdation 14/10/2020/////////////////
    //         $patta_no=$new_patta;
    //         $patta_type_code=$occup->patta_type_code;
    //         // ////////////////////////////
    //     }
    //     $final_data = $this->session->userdata('final_order');

    //     foreach ($final_data as $fd) {
    //         unset($fd['sugg_pno']);
    //         unset($fd['not_consistent']);
    //         $fd['mut_land_area_b']=$bigha;
    //         $fd['mut_land_area_k']=$katha;
    //         $fd['mut_land_area_lc']=$lessa;
    //         //var_dump($fd);
    //         $tstatus2=$this->db->insert("t_chitha_col8_order", $fd); //****************************
    //         if ($tstatus2 != 1 )
    //         {
    //            $this->db->trans_rollback();
    //            $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#FP002)");
    //            redirect(base_url() . "index.php/home");
    //         }
    //     }
    //     $dist_code = $petitioner_save->dist_code;
    //     $subdiv_code = $petitioner_save->subdiv_code;
    //     $cir_code = $petitioner_save->cir_code;
    //     $mouza_pargona_code = $petitioner_save->mouza_pargona_code;
    //     $lot_no = $petitioner_save->lot_no;
    //     $vill_townprt_code = $petitioner_save->vill_townprt_code;
    //     $dag_no = $petitioner_save->dag_no;
    //     $petition_no = $petitioner_save->petition_no;

    //     if ($this->db->trans_status() === FALSE) {
    //         $this->db->trans_rollback();
    //         $db_debug = $this->db->db_debug;
    //         $this->db->db_debug = TRUE;
    //         //echo $this->db->_error_message();
    //         $this->db->db_debug = $db_debug;
    //         $url="<a href='cofieldmutation/pendingmaps' class='text-success'>Kindly Click Here to Remove Temporary Data </a>";
    //         $this->session->set_flashdata("message", "Order Cannot be passed. Error Code [T-TABLE_HAS_DATA] . Contact help desk with case no. $url");
    //         redirect(base_url() . "index.php/home");
    //         return;
    //     } else {
    //         $this->session->set_flashdata("message", "Order passed. Case Pending with mandal for parition Map Correction");
    //         $this->db->trans_commit();
    //     }

    //     if($occup->dag_no == $new_dag)
    //     {
    //         $ok = $this->autoUpdate_fulldag($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $petition_no, $dag_no);
    //     }
    //     else
    //     {
    //         $ok = $this->autoUpdate($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $petition_no, $dag_no);
    //     }

    //     if ($ok) {

    //         //////////
    //         $this->DashboardDataFinal($case_no);
    //         ///////
    //         $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
    //         if($basundhara){
    //             $rmk='Order passed';
    //             $status='F';
    //             $task='CO';
    //             $pen='NA';
    //             $case=$case_no;
    //             $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
    //         }           
    //         //////////////////////////////////
    //         $this->session->set_flashdata('message', "Order for Case No $case_no Successfully Saved.");
    //         $this->session->set_flashdata('message', "Chitha Has Been Updated");
    //         //////////////JamaBandi Update///////////////////
    //         $location = array(
    //                 'd'=> $dist_code,
    //                 's' => $subdiv_code,
    //                 'c' => $cir_code,
    //                 'm' => $mouza_pargona_code,
    //                 'l' => $lot_no,
    //                 'v' => $vill_townprt_code,
    //             );
    //         //var_dump($location);
    //         $this->session->set_userdata(array('loc' => $location));
    //         // echo $patta_no."-".$patta_type_code;
    //         // exit;
    //         $popUpmsg="<h4>Order for Case No $case_no Successfully Saved.Chitha has been Updated !!! Updating JamaBandi Now<h4>";
    //         $msgggg= "<script type='text/javascript'>alert(' " .$popUpmsg ." ');</script>";
    //         //echo $msgggg;

    //         redirect('JamaBandi/step3/' .$patta_no .'/'. $patta_type_code);
    //         //redirect(base_url() . "index.php/home");
    //     } else {
    //         $this->session->set_flashdata('message', "Chitha Could not be updated for case no $case_no.Contact Helpdesk with case no");
    //         redirect(base_url() . "index.php/home");
    //     }
    // }

    public function saveCOOrder()
    {
        $db = $this->session->userdata('db');
        $case_no = $this->input->post('case_no');
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');

        $mut_type = $this->db->query("select mut_type from   field_mut_basic where case_no='$case_no' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no'"
            . " and vill_townprt_code='$vill_townprt_code' and $this->base_query1")->row()->mut_type;
        $offset = 0;
        $count = $this->db->query("select count(*) as count from   field_mut_dag_details where case_no='$case_no' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no'"
            . " and vill_townprt_code='$vill_townprt_code' and $this->base_query1")->row()->count;
        //echo $count;
        for ($i = 0; $i < $count; $i++) {

            $data1 = $this->db->query("select * from   field_mut_dag_details where case_no='$case_no' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no'"
                . " and vill_townprt_code='$vill_townprt_code' and $this->base_query1 offset $offset limit 1")->row();
            $array1 = array();
            foreach ($data1 as $key => $value) {
                $array1[$key] = $value;
            }
            $array1['lm_note_date'] = $array1['date_entry'];

            unset($array1['m_dag_area_b']);
            unset($array1['m_dag_area_k']);
            unset($array1['m_dag_area_lc']);
            unset($array1['m_dag_area_g']);
            unset($array1['m_dag_area_kr']);
            unset($array1['dag_area_b']);
            unset($array1['dag_area_k']);
            unset($array1['dag_area_lc']);
            unset($array1['dag_area_g']);
            unset($array1['dag_area_kr']);
            unset($array1['patta_no']);
            unset($array1['patta_type_code']);
            unset($array1['user_code']);
            unset($array1['date_entry']);
            unset($array1['operation']);
            unset($array1['obj_flag']);
            unset($array1['up_flag']);
            unset($array1['up_date']);
            unset($array1['land_valuation']);
            unset($array1['remark']);
            unset($array1['trans_code']);

            $data2 = $this->db->query("select rajah_adalat,mut_type,trans_code,sk_id,min_revenue"
                . " from   field_mut_basic where case_no='$case_no' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no'"
                . " and vill_townprt_code='$vill_townprt_code' and $this->base_query1")->row();
            $array2 = array();
            foreach ($data2 as $key => $value) {
                $array2[$key] = $value;
            }

            $data4 = array();

            foreach ($_POST as $k => $v) {
                $data4[$k] = $v;
            }

            $sk_code = $data2->sk_id;
            $order_type_code = $data2->mut_type;

            unset($array2['trans_code']);
            unset($array2['sk_id']);
            unset($array2['mut_type']);
            $data3 = array(
                'mut_land_area_b' => $data1->m_dag_area_b,
                'mut_land_area_k' => $data1->m_dag_area_k,
                'mut_land_area_lc' => $data1->m_dag_area_lc,
                'mut_land_area_g' => $data1->m_dag_area_g,
                'mut_land_area_kr' => $data1->m_dag_area_kr,
                'land_area_left_b' => ($data1->dag_area_b - $data1->m_dag_area_b),
                'land_area_left_k' => ($data1->dag_area_k - $data1->m_dag_area_k),
                'land_area_left_lc' => ($data1->dag_area_lc - $data1->m_dag_area_lc),
                'land_area_left_g' => ($data1->dag_area_g - $data1->m_dag_area_g),
                'land_area_left_kr' => ($data1->dag_area_kr - $data1->m_dag_area_kr),
                'rajah_adalat' => $data2->rajah_adalat,
                'nature_trans_code' => $data2->trans_code,
                'min_revenue' => $data2->min_revenue,
                'sk_code' => $sk_code,
                'order_type_code' => $order_type_code,
                'case_no' => $case_no,
            );

            $final_data = array_merge($data3, $array1, $array2, $data4);

            $final_data['co_ord_date'] = date('Y-m-d', strtotime($final_data['co_ord_date']));
            if (!$this->session->userdata('final_order')) {
                $this->session->set_userdata('final_order', array());
                $fd = $this->session->userdata('final_data');
                $fd[] = $final_data;
                $this->session->set_userdata('final_order', $fd);
            } else {
                $appdet = $this->session->userdata('final_order');
                $appdet[] = $final_data;
                $this->session->set_userdata('final_order', $appdet);
            }
            $offset++;
        }
        // var_dump($this->session->userdata('final_order'));
        if ($mut_type == '01') {
            redirect(base_url() . "index.php/cofieldmutation/saveoccupant?case_no=" . $case_no . "&dist_code=" . $dist_code . "&subdiv_code=" . $subdiv_code . "&cir_code=" . $cir_code . "&mouza_pargona_code=" . $mouza_pargona_code . "&lot_no=" . $lot_no . "&vill_townprt_code=" . $vill_townprt_code);
        } else if ($mut_type == '02') {
            redirect(base_url() . "index.php/cofieldmutation/saveOccupantPartitionNew?case_no=" . $case_no . "&dist_code=" . $dist_code . "&subdiv_code=" . $subdiv_code . "&cir_code=" . $cir_code . "&mouza_pargona_code=" . $mouza_pargona_code . "&lot_no=" . $lot_no . "&vill_townprt_code=" . $vill_townprt_code);
        }
    }

    public function saveOccupant()
    {
        $db = $this->session->userdata('db');
        $case_no = $this->input->get('case_no');
        $cir_code = $this->session->userdata('cir_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = array();
            $data['case_no'] = $this->input->post('case_no');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code1 = $this->input->post('mouza_pargona_code');
            $lot_no1 = $this->input->post('lot_no');
            $vill_townprt_code1 = $this->input->post('vill_townprt_code');

            $data['dist_code'] = $dist_code;
            $data['subdiv_code'] = $subdiv_code;
            $data['cir_code'] = $cir_code;
            $data['mouza_pargona_code'] = $mouza_pargona_code1;
            $data['lot_no'] = $lot_no1;
            $data['vill_townprt_code'] = $vill_townprt_code1;
            if ($this->input->post('occupant_id') != null) {
                $occupant_id = $this->input->post('occupant_id');
                $pdar_id = $this->input->post('pdar_id');
                $q = "select * from   field_mut_petitioner where case_no='$data[case_no]' and mouza_pargona_code='$mouza_pargona_code1' and "
                    . "lot_no='$lot_no1' and vill_townprt_code='$vill_townprt_code1' and pet_id=$occupant_id and $this->base_query1";

                $occup_query = "select mp.new_pet_name,mp.dist_code,mp.subdiv_code,mp.cir_code,mp.mouza_pargona_code,mp.lot_no,mp.vill_townprt_code,"
                    . "mp.year_no,mp.petition_no,mp.add1,mp.add2,mp.pet_name,mp.guard_name,mp.guard_rel,dd.patta_no,dd.patta_type_code,mp.applied_b,"
                    . "mp.applied_k,mp.applied_lc,dd.dag_no from   field_mut_petitioner mp,field_mut_dag_details dd where mp.case_no = dd.case_no and "
                    . "mp.case_no='$data[case_no]' and mp.pet_id=$occupant_id and mp.cir_code ='$cir_code' and mp.subdiv_code='$subdiv_code' and "
                    . "mp.cir_code=dd.cir_code and mp.subdiv_code=dd.subdiv_code and mp.mouza_pargona_code='$mouza_pargona_code1' and "
                    . "mp.lot_no='$lot_no1' and mp.vill_townprt_code='$vill_townprt_code1' and mp.mouza_pargona_code=dd.mouza_pargona_code and mp.lot_no=dd.lot_no and "
                    . "mp.vill_townprt_code=dd.vill_townprt_code";

                $petitioner_save = $this->db->query($occup_query)->row();
                $dist_code = $petitioner_save->dist_code;
                $subdiv_code = $petitioner_save->subdiv_code;
                $cir_code = $petitioner_save->cir_code;
                $lot_no = $petitioner_save->lot_no;
                $mouza_pargona_code = $petitioner_save->mouza_pargona_code;
                $vill_townprt_code = $petitioner_save->vill_townprt_code;
                $patta_no = trim($petitioner_save->patta_no);
                $patta_type = $petitioner_save->patta_type_code;

                $revenue = $this->db->query("select min_revenue from   field_mut_basic where case_no='$data[case_no]' and mouza_pargona_code='$mouza_pargona_code' and "
                    . "lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and $this->base_query1")->row()->min_revenue;


                foreach ($_POST as $k => $v) {
                    $array1[$k] = $v;
                }

                $array2 = array();
                foreach ($petitioner_save as $k => $v) {
                    $array2[$k] = $v;
                }
                $final = array_merge($array1, $array2);
                $final['land_area_g'] = 0.00;
                $final['land_area_kr'] = 0.00;
                $final['occupant_add3'] = 'unknown';
                $final['revenue'] = $revenue;
                if ($final['new_pet_name'] == 'N') {
                    $final['new_pattadar'] = 'N';
                }

                unset($final['new_pet_name']);
                unset($final['pet_name']);
                unset($final['case_no']);
                unset($final['add1']);
                unset($final['add2']);
                unset($final['guard_name']);
                unset($final['guard_rel']);
                unset($final['applied_b']);
                unset($final['applied_k']);
                unset($final['applied_lc']);

                $dags = $this->db->query("select dag_no from   field_mut_dag_details where case_no='$data[case_no]' and mouza_pargona_code='$mouza_pargona_code' and "
                    . "lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and $this->base_query1")->result();

                foreach ($dags as $d) {
                    $final['dag_no'] = $d->dag_no;
                    if (!empty($final['pdar_id'])) {
                        $e = "select count(*) as count from   chitha_dag_pattadar where dist_code='$dist_code' and "
                            . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
                            . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and TRIM(patta_no)=trim('$patta_no') and"
                            . " patta_type_code='$patta_type' and dag_no='$d->dag_no' and pdar_id=$final[pdar_id]";
                        if (!$this->session->userdata('occup_data')) {
                            $this->session->set_userdata('occup_data', array());
                            $occup_data = $this->session->userdata('occup_data');
                            $occup_data[] = $final;
                            $this->session->set_userdata('occup_data', $occup_data);
                        } else {
                            $occup_data = $this->session->userdata('occup_data');
                            $occup_data[] = $final;
                            $this->session->set_userdata('occup_data', $occup_data);
                        }

                        $q = "select count(*) as count from   chitha_pattadar where dist_code='$dist_code' and "
                            . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
                            . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and TRIM(patta_no)=trim('$patta_no') and"
                            . " patta_type_code='$patta_type' and dag_no='$d->dag_no' and pdar_id=$final[pdar_id]";
                    } else {
                        $e = "select count(*) as count from   chitha_dag_pattadar where dist_code='$dist_code' and "
                            . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
                            . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and TRIM(patta_no)=trim('$patta_no') and"
                            . " patta_type_code='$patta_type' and dag_no='$d->dag_no'";

                        $final['new_pattadar'] = 'N';

                        if (!$this->session->userdata('occup_data')) {
                            $this->session->set_userdata('occup_data', array());
                            $occup_data = $this->session->userdata('occup_data');
                            $occup_data[] = $final;
                            $this->session->set_userdata('occup_data', $occup_data);
                        } else {
                            $occup_data = $this->session->userdata('occup_data');
                            $occup_data[] = $final;
                            $this->session->set_userdata('occup_data', $occup_data);
                        }
                    }
                }
                $data['occupant_id'] = ((int) $this->input->post('occupant_id') + 1);
                $data['pdar_id'] = ((int) $this->input->post('pdar_id') + 1);
            } else {
                $data['occupant_id'] = 1;
                $data['pdar_id'] = 1;
            }


            $qnext = "select * from   field_mut_petitioner where case_no='$data[case_no]' and mouza_pargona_code='$mouza_pargona_code' and "
                . "lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and pet_id=$data[occupant_id] and $this->base_query1";


            $petitioner = $this->db->query("select * from   field_mut_petitioner where case_no='$data[case_no]' and mouza_pargona_code='$mouza_pargona_code' and "
                . "lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and pet_id=$data[occupant_id] and $this->base_query1")->row();

            $data['petitioner'] = $petitioner;
            $revenue = $this->db->query("select min_revenue from   field_mut_basic where case_no='$data[case_no]' and mouza_pargona_code='$mouza_pargona_code' and "
                . "lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and $this->base_query1")->row();
            $data['revenue'] = $revenue;

            if (sizeof($petitioner) >= 1) {
                // $this->load->helper('html');
                // $this->load->view('../views/comutation/occupantdetails', $data);
                // $this->load->view('../views/footer');
                $data['_view'] = 'comutation/occupantdetails';
                $this->load->view('layouts/main', $data);
            } else {
                redirect(base_url() . "index.php/cofieldmutation/saveinplaceof?case_no=" . $data['case_no'] . "&dist_code=" . $dist_code . "&subdiv_code=" . $subdiv_code . "&cir_code=" . $cir_code . "&mouza_pargona_code=" . $mouza_pargona_code . "&lot_no=" . $lot_no . "&vill_townprt_code=" . $vill_townprt_code);
            }
        } else {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
            $lot_no1 = $this->input->get('lot_no');
            $vill_townprt_code1 = $this->input->get('vill_townprt_code');

            $data['occupant_id'] = 1;
            $data['case_no'] = $case_no;
            $data['dist_code'] = $dist_code;
            $data['subdiv_code'] = $subdiv_code;
            $data['cir_code'] = $cir_code;
            $data['mouza_pargona_code'] = $mouza_pargona_code1;
            $data['lot_no'] = $lot_no1;
            $data['vill_townprt_code'] = $vill_townprt_code1;
            $q = $this->db->query("select * from   field_mut_dag_details where case_no='$case_no' and mouza_pargona_code='$mouza_pargona_code1' and "
                . "lot_no='$lot_no1' and vill_townprt_code='$vill_townprt_code1' and $this->base_query")->row();

            //checking the pattadars in jama_pattadar and chitha pattadar and also in chitha_dag_pattadars.
            $pattadars_in_chitha_pattadar = $this->db->query("select max(pdar_id) as cp from   chitha_pattadar where dist_code='$q->dist_code' and "
                . " subdiv_code='$q->subdiv_code' and cir_code='$q->cir_code' and mouza_pargona_code='$q->mouza_pargona_code' and"
                . " lot_no='$q->lot_no' and vill_townprt_code='$q->vill_townprt_code' and TRIM(patta_no)=trim('$q->patta_no')")->row()->cp;

            $pattadars_in_jama_pattadar = $this->db->query("select max(pdar_id) as jp from   jama_pattadar where dist_code='$q->dist_code' and "
                . " subdiv_code='$q->subdiv_code' and cir_code='$q->cir_code' and mouza_pargona_code='$q->mouza_pargona_code' and"
                . " lot_no='$q->lot_no' and vill_townprt_code='$q->vill_townprt_code' and TRIM(patta_no)=trim('$q->patta_no')")->row()->jp;

            // for mutation
            if ($pattadars_in_chitha_pattadar >= $pattadars_in_jama_pattadar) {
                $pdar_id = $this->db->query("select max(cast(pdar_id as int))+1 as pdar_id from   chitha_pattadar where dist_code='$q->dist_code' and "
                    . " subdiv_code='$q->subdiv_code' and cir_code='$q->cir_code' and mouza_pargona_code='$q->mouza_pargona_code' and"
                    . " lot_no='$q->lot_no' and vill_townprt_code='$q->vill_townprt_code' and TRIM(patta_no)=trim('$q->patta_no')")->row()->pdar_id;
            } else {
                $pdar_id = $this->db->query("select max(cast(pdar_id as int))+1 as pdar_id from   jama_pattadar where dist_code='$q->dist_code' and "
                    . " subdiv_code='$q->subdiv_code' and cir_code='$q->cir_code' and mouza_pargona_code='$q->mouza_pargona_code' and"
                    . " lot_no='$q->lot_no' and vill_townprt_code='$q->vill_townprt_code' and TRIM(patta_no)=trim('$q->patta_no')")->row()->pdar_id;
            }

            if ($pdar_id == null) {
                $pdar_id = 1;
            }

            $pattadars_in_chitha_dag_pattadar = $this->db->query("select max(pdar_id) as cdp from   chitha_dag_pattadar where dist_code='$q->dist_code' and "
                . " subdiv_code='$q->subdiv_code' and cir_code='$q->cir_code' and mouza_pargona_code='$q->mouza_pargona_code' and"
                . " lot_no='$q->lot_no' and vill_townprt_code='$q->vill_townprt_code' and TRIM(patta_no)=trim('$q->patta_no')")->row()->cdp;

            if ($pdar_id <= $pattadars_in_chitha_dag_pattadar) {
                $pdar_id = $pattadars_in_chitha_dag_pattadar + 1;
            }

            $data['pdar_id'] = $pdar_id;

            $petitioner = $this->db->query("select * from   field_mut_petitioner where case_no='$case_no' and mouza_pargona_code='$mouza_pargona_code1' and "
                . "lot_no='$lot_no1' and vill_townprt_code='$vill_townprt_code1' and $this->base_query and pet_id=$data[occupant_id]")->row();
            $revenue = $this->db->query("select min_revenue from   field_mut_basic where case_no='$case_no' and mouza_pargona_code='$mouza_pargona_code1' and "
                . "lot_no='$lot_no1' and vill_townprt_code='$vill_townprt_code1' and $this->base_query1")->row();
            $data['revenue'] = $revenue;
            $data['petitioner'] = $petitioner;
            // $this->load->helper('html');
            // $this->load->view('../views/comutation/occupantdetails', $data);
            // $this->load->view('../views/footer');
            $data['_view'] = 'comutation/occupantdetails';
            $this->load->view('layouts/main', $data);
        }
    }

    public function saveOccupantPartition()
    {
        $db = $this->session->userdata('db');
        $case_no = $this->input->get('case_no');
        $cir_code = $this->session->userdata('cir_code');
        $subdiv_code = $this->session->userdata('subdiv_code');


        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = array();
            $data['case_no'] = $this->input->post('case_no');
            if ((isset($_POST['new_dag_no'])) && (isset($_POST['new_dag_no']))) {
                $data['new_dag'] = $_POST['new_dag_no'];
                $data['new_patta'] = trim($_POST['new_patta_no']);
            }
            if ($this->input->post('occupant_id') != null) {
                $occupant_id = $this->input->post('occupant_id');
                $q = "select * from   field_part_petitioner"
                    . " where case_no='$data[case_no]'  and $this->base_query  and pet_id=$occupant_id";
                $occup_query = "select mp.dist_code,mp.subdiv_code,mp.cir_code,mp.mouza_pargona_code,mp.lot_no,mp.vill_townprt_code,mp.pdar_id,mp.year_no,
                    mp.petition_no,mp.pdar_add1,mp.pdar_add2,mp.pdar_name,mp.pdar_guardian,
                    mp.pdar_rel_guar,dd.patta_no,dd.patta_type_code,mp.pdar_dag_por_b,mp.pdar_dag_por_k,mp.pdar_dag_por_lc,dd.dag_no
                    from   field_part_petitioner mp,field_mut_dag_details dd where mp.cir_code=dd.cir_code and 
                    mp.case_no = dd.case_no and mp.case_no='$data[case_no]' and mp.cir_code ='$cir_code' and mp.subdiv_code='$subdiv_code' limit 1 offset $occupant_id-1";

                $petitioner_save = $this->db->query($occup_query)->row();

                $revenue = $this->db->query("select min_revenue from   field_mut_basic where case_no='$data[case_no]' and $this->base_query1")->row()->min_revenue;


                foreach ($_POST as $k => $v) {
                    $array1[$k] = $v;
                }

                $array2 = array();
                foreach ($petitioner_save as $k => $v) {
                    $array2[$k] = $v;
                }
                $final = array_merge($array1, $array2);
                $final['land_area_g'] = 0.00;
                $final['land_area_kr'] = 0.00;
                $final['occupant_add3'] = 'unknown';
                $final['revenue'] = $revenue;
                $final['new_pattadar'] = 'N';

                unset($final['pet_name']);
                unset($final['case_no']);
                unset($final['add1']);
                unset($final['add2']);
                unset($final['guard_name']);
                unset($final['guard_rel']);
                unset($final['applied_b']);
                unset($final['applied_k']);
                unset($final['applied_lc']);
                unset($final['pdar_add1']);
                unset($final['pdar_add2']);
                unset($final['pdar_name']);
                unset($final['pdar_guardian']);
                unset($final['pdar_rel_guar']);
                unset($final['pdar_dag_por_b']);
                unset($final['pdar_dag_por_k']);
                unset($final['pdar_dag_por_lc']);
                unset($final['not_consistent']);
                //////////var_dump($final);
                if (!$this->session->userdata('occup_data')) {
                    $this->session->set_userdata('occup_data', array());
                    $occup_data = $this->session->userdata('occup_data');
                    $occup_data[] = $final;
                    $this->session->set_userdata('occup_data', $occup_data);
                    // var_dump($occup_data);
                } else {
                    $occup_data = $this->session->userdata('occup_data');
                    $occup_data[] = $final;
                    $this->session->set_userdata('occup_data', $occup_data);
                    // var_dump($occup_data);
                }
                //$this->db->insert('t_chitha_col8_occup', $final);
                $data['occupant_id'] = ((int) $this->input->post('occupant_id') + 1);
            } else {
                $data['occupant_id'] = 1;
            }

            $q = "select * from   field_part_petitioner "
                . " where case_no='$data[case_no]' and $this->base_query1 limit 1 offset $data[occupant_id] ";
            $petitioner = $this->db->query("select * from   field_part_petitioner "
                . " where case_no='$data[case_no]' and $this->base_query1 limit 1 offset $data[occupant_id]-1 ")->row();

            $data['petitioner'] = $petitioner;
            $q = "select * from   field_mut_dag_details where case_no='$case_no' and $this->base_query1";
            $dagapply = $this->db->query("$q")->row();
            $data['dagapply'] = $dagapply;
            //var_dump($dagapply);
            $revenue = $this->db->query("select min_revenue from   field_mut_basic where case_no='$data[case_no]' and $this->base_query1")->row();

            $data['revenue'] = $revenue;
            //////////var_dump($revenue);
            if (sizeof($petitioner) >= 1) {
                $this->load->helper('html');
                $q = "select * from   field_mut_dag_details where case_no='$data[case_no]' and $this->base_query1";
                //echo $q;
                $dagapply = $this->db->query($q)->row();
                $data['dagapply'] = $dagapply;
                $dag_nos_all = $this->db->query("select dag_no  from   chitha_basic where dist_code = '$petitioner->dist_code'"
                    . " and subdiv_code='$petitioner->subdiv_code' and cir_code = '$petitioner->cir_code'"
                    . " and mouza_pargona_code='$petitioner->mouza_pargona_code'"
                    . " and lot_no='$petitioner->lot_no' and vill_townprt_code = '$petitioner->vill_townprt_code' order by dag_no_int")->result();
                $data['dags_all'] = $dag_nos_all;

                $this->load->view('../views/comutation/occupantdetailspartition', $data);
                $this->load->view('../views/footer');
            } else {
                $this->db->trans_begin();
                $case_no = $this->input->post('case_no');
                $q = "update field_mut_basic set order_passed='y' , date_of_order='date(Y-m-d)'"
                    . " where case_no='$case_no' and $this->base_query1";

                $this->DashboardDataFinal($case_no);

                $this->db->query($q);

                $occup_data = $this->session->userdata('occup_data');

                foreach ($occup_data as $occup) {

                    $this->db->insert("t_chitha_col8_occup", $occup);
                }
                $final_data = $this->session->userdata('final_order');

                foreach ($final_data as $fd) {
                    unset($fd['sugg_pno']);
                    //var_dump($fd);
                    $this->db->insert("t_chitha_col8_order", $fd);
                }
                // //exit;
                //$this->db->insert('t_chitha_col8_order', $this->session->userdata('final_order'));
                $dist_code = $petitioner_save->dist_code;
                $subdiv_code = $petitioner_save->subdiv_code;
                $cir_code = $petitioner_save->cir_code;
                $mouza_pargona_code = $petitioner_save->mouza_pargona_code;
                $lot_no = $petitioner_save->lot_no;
                $vill_townprt_code = $petitioner_save->vill_townprt_code;
                $dag_no = $petitioner_save->dag_no;
                $petition_no = $petitioner_save->petition_no;
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $db_debug = $this->db->db_debug;
                    $this->db->db_debug = TRUE;
                    //echo $this->db->_error_message();
                    $this->db->db_debug = $db_debug;
                    $this->session->set_flashdata("message", "Order Cannot be passed. Error Code [T-TABLE_HAS_DATA] . Contact help desk with case no.");
                    redirect(base_url() . "index.php/home");
                    return;
                } else {
                    $this->session->set_flashdata("message", "Order passed. Case Pending with mandal for parition");
                    $this->db->trans_commit();
                    redirect(base_url() . "index.php/home");
                }
                $ok = $this->autoUpdate($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $petition_no, $dag_no);
                //////////////////////////
                $basundhara = $this->basundharamodel->checkExistBasundhar($case_no);
                if ($basundhara) {
                    $rmk = 'Order passed';
                    $status = 'F';
                    $task = 'CO';
                    $pen = 'NA';
                    $case = $case_no;
                    $this->basundharamodel->postApiBasundharaSec($case, $rmk, $status, $task, $pen);
                }
                /////////////////////////
                if ($ok) {
                    $this->session->set_flashdata('message', "Order for Case No $case_no Successfully Saved.");
                    $this->session->set_flashdata('message', "Chitha Has Been Updated");
                    redirect(base_url() . "index.php/home");
                } else {
                    $this->session->set_flashdata('message', "Chitha Could not be updated for case no $case_no.Contact Helpdesk with case no");
                    redirect(base_url() . "index.php/home");
                }
            }
        } else {
            $data['occupant_id'] = 1;
            $data['case_no'] = $case_no;
            $petitioner = $this->db->query("select * from   field_part_petitioner "
                . " where case_no='$case_no' and $this->base_query1 ")->row();
            $revenue = $this->db->query("select min_revenue from   field_mut_basic where case_no='$case_no' and $this->base_query1")->row();
            $data['revenue'] = $revenue;
            $dagapply = $this->db->query("select * from   field_mut_dag_details where case_no='$case_no' and $this->base_query1")->row();
            $data['dagapply'] = $dagapply;
            $patta_type_code = $dagapply->patta_type_code;
            //            /////////var_dump($petitioner);
            $data['petitioner'] = $petitioner;
            $q = "select dag_no from   chitha_basic where dist_code = '$petitioner->dist_code'"
                . " and subdiv_code='$petitioner->subdiv_code' and cir_code = '$petitioner->cir_code'"
                . " and mouza_pargona_code='$petitioner->mouza_pargona_code'"
                . " and lot_no='$petitioner->lot_no' and vill_townprt_code = '$petitioner->vill_townprt_code'"
                . " order by dag_no_int desc";

            $dag_nos = $this->db->query($q)->row();

            $notinsql = "Select type_code from   patta_code where mutation='a' ";
            $patta_nos = $this->db->query("select patta_no from   chitha_basic where dist_code = '$petitioner->dist_code'"
                . " and subdiv_code='$petitioner->subdiv_code' and cir_code = '$petitioner->cir_code'"
                . " and mouza_pargona_code='$petitioner->mouza_pargona_code'"
                . " and lot_no='$petitioner->lot_no' and vill_townprt_code = '$petitioner->vill_townprt_code' and patta_type_code='$dagapply->patta_type_code' and  (patta_type_code in ($notinsql)) ")->result();


            $patta_all = $this->db->query("select distinct cast(patta_no as varchar) as patta_no from   chitha_basic where dist_code = '$petitioner->dist_code'"
                . " and subdiv_code='$petitioner->subdiv_code' and cir_code = '$petitioner->cir_code'"
                . " and mouza_pargona_code='$petitioner->mouza_pargona_code'"
                . " and lot_no='$petitioner->lot_no' and vill_townprt_code = '$petitioner->vill_townprt_code' and   TRIM(patta_no)!='' and TRIM(patta_no)!='.' and (patta_type_code in ($notinsql)) and patta_type_code='$patta_type_code' order by patta_no desc ")->result();

            $q = "select dag_no from   chitha_basic where dist_code = '$petitioner->dist_code'"
                . " and subdiv_code='$petitioner->subdiv_code' and cir_code = '$petitioner->cir_code'"
                . " and mouza_pargona_code='$petitioner->mouza_pargona_code'"
                . " and lot_no='$petitioner->lot_no' and vill_townprt_code = '$petitioner->vill_townprt_code' order by dag_no";

            $dag_nos_all = $this->db->query("select dag_no  from   chitha_basic where dist_code = '$petitioner->dist_code'"
                . " and subdiv_code='$petitioner->subdiv_code' and cir_code = '$petitioner->cir_code'"
                . " and mouza_pargona_code='$petitioner->mouza_pargona_code'"
                . " and lot_no='$petitioner->lot_no' and vill_townprt_code = '$petitioner->vill_townprt_code' order by dag_no_int")->result();
            $pattas = array();

            foreach ($patta_nos as $p) {
                $pattas[] = (int) (trim($p->patta_no));
            }
            $new_dag = $dag_nos->dag_no + 1;
            $new_patta = max($pattas) + 1;

            $q = "select max(new_dag_no) as t_max_dag,max(new_patta_no) as t_max_patta from   t_chitha_col8_occup where dist_code = '$petitioner->dist_code'"
                . " and subdiv_code='$petitioner->subdiv_code' and cir_code = '$petitioner->cir_code'"
                . " and mouza_pargona_code='$petitioner->mouza_pargona_code'"
                . " and lot_no='$petitioner->lot_no' and vill_townprt_code = '$petitioner->vill_townprt_code' and new_dag_no!='' and trim(new_patta_no)!='' ";
            $t_max_dp = $this->db->query($q)->row();
            //var_dump($t_max_dp);
            $t_max_dag = $t_max_dp->t_max_dag;
            $t_max_patta = $t_max_dp->t_max_patta;
            if ($new_dag <= $t_max_dag) {
                $new_dag = $new_dag + 1;
            }
            if ($new_patta <= $t_max_patta) {
                $new_patta = $new_patta + 1;
            }
            $data['new_dag'] = $new_dag;
            $data['new_patta'] = $new_patta;
            $data['dags_all'] = $dag_nos_all;
            $data['patta_all'] = $patta_all;
            $this->load->helper('html');

            $this->load->view('../views/comutation/occupantdetailspartition', $data);
            $this->load->view('../views/footer');
        }
    }

    public function saveInPlaceOf()
    {
        $db = $this->session->userdata('db');
        $case_no = $this->input->get('case_no');

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            if ($this->input->post('alongwith_id') != null) {

                $alongwith_id = $this->input->post('alongwith_id');
                $case_no = $this->input->post('case_no');
                $dist_code = $this->session->userdata('dist_code');
                $subdiv_code = $this->session->userdata('subdiv_code');
                $cir_code = $this->session->userdata('cir_code');
                $mouza_pargona_code1 = $this->input->post('mouza_pargona_code');
                $lot_no1 = $this->input->post('lot_no');
                $vill_townprt_code1 = $this->input->post('vill_townprt_code');

                $offset = $alongwith_id - 1;

                $pattadar_save = $this->db->query("select * from   field_mut_pattadar where case_no='$case_no' and mouza_pargona_code='$mouza_pargona_code1' and "
                    . "lot_no='$lot_no1' and vill_townprt_code='$vill_townprt_code1' and $this->base_query1 limit 1 offset $offset")->row();

                $dag_details = $this->db->query("select * from   field_mut_dag_details where case_no='$case_no' and mouza_pargona_code='$mouza_pargona_code1' and "
                    . "lot_no='$lot_no1' and vill_townprt_code='$vill_townprt_code1' and $this->base_query1 limit 1")->row();


                $land_area_b = $dag_details->dag_area_b - $dag_details->m_dag_area_b;
                $land_area_k = $dag_details->dag_area_k - $dag_details->m_dag_area_k;
                $land_area_lc = $dag_details->dag_area_lc - $dag_details->m_dag_area_lc;
                $land_area_g = $dag_details->dag_area_g - $dag_details->m_dag_area_g;
                $land_area_kr = $dag_details->dag_area_kr - $dag_details->m_dag_area_kr;

                $array1 = array();

                foreach ($pattadar_save as $key => $value) {
                    $array1[$key] = $value;
                }

                $array1['fmute_strike_out'] = $array1['striked_out'];
                unset($array1['striked_out']);
                unset($array1['pdar_cron_no']);
                unset($array1['pdar_name']);
                unset($array1['pdar_guardian']);
                unset($array1['pdar_add1']);
                unset($array1['pdar_rel_guar']);
                unset($array1['pdar_add2']);
                unset($array1['user_code']);
                unset($array1['date_entry']);
                unset($array1['operation']);
                unset($array1['case_no']);
                unset($array1['patta_no']);
                unset($array1['patta_type_code']);
                $final = array();
                $extra = array(
                    'inplace_of_id' => $alongwith_id,
                    'inplace_of_name' => $this->input->post('inplace_of_name'),
                    'land_area_b' => $land_area_b,
                    'land_area_k' => $land_area_k,
                    'land_area_lc' => $land_area_lc,
                    'land_area_g' => $land_area_g,
                    'land_area_kr' => $land_area_kr,
                );
                //var_dump($extra);
                $final = array_merge($array1, $extra);
                $final['inplace_of_gender'] = $final['pdar_gender'];
                $final['inplace_of_minor_yn'] = $final['pdar_minor_yn'];
                $final['inplace_of_minor_dob'] = $final['pdar_minor_dob'];
                $final['inplace_of_mother'] = $final['pdar_mother'];

                unset($final['pdar_gender']);
                unset($final['pdar_minor_yn']);
                unset($final['pdar_minor_dob']);
                unset($final['pdar_mother']);
                unset($final['not_consistent']);
                //var_dump($final);

                if (!$this->session->userdata('inplaceof')) {
                    $this->session->set_userdata('inplaceof', array());
                    $inplaceof = $this->session->userdata('inplaceof');
                    $inplaceof[] = $final;
                    $this->session->set_userdata('inplaceof', $inplaceof);
                } else {
                    $inplaceof = $this->session->userdata('inplaceof');
                    $inplaceof[] = $final;
                    $this->session->set_userdata('inplaceof', $inplaceof);
                }

                $data['alongwith_id'] = $alongwith_id + 1;

                $pattadar = $this->db->query("select * from   field_mut_pattadar where case_no='$case_no' and mouza_pargona_code='$mouza_pargona_code1' and "
                    . "lot_no='$lot_no1' and vill_townprt_code='$vill_townprt_code1' and $this->base_query1 limit 1 offset $alongwith_id")->row();

                $data['pattadar'] = $pattadar;
                $data['case_no'] = $case_no;
                $data['dist_code'] = $dist_code;
                $data['subdiv_code'] = $subdiv_code;
                $data['cir_code'] = $cir_code;
                $data['mouza_pargona_code'] = $mouza_pargona_code1;
                $data['lot_no'] = $lot_no1;
                $data['vill_townprt_code'] = $vill_townprt_code1;

                if (sizeof($pattadar) >= 1) {
                    // $this->load->helper('html');
                    // $this->load->view('../views/comutation/inplaceof', $data);
                    // $this->load->view('../views/footer');
                    $data['_view'] = 'comutation/inplaceof';
                    $this->load->view('layouts/main', $data);
                } else {
                    $all_data = $this->session->all_userdata();
                    $this->db->trans_start();

                    foreach ($inplaceof as $inplace) {
                        unset($inplace['sugg_pno']);
                        $key = array(
                            'dist_code' => $inplace['dist_code'],
                            'subdiv_code' => $inplace['subdiv_code'],
                            'cir_code' => $inplace['cir_code'],
                            'mouza_pargona_code' => $inplace['mouza_pargona_code'],
                            'lot_no' => $inplace['lot_no'],
                            'vill_townprt_code' => $inplace['vill_townprt_code'],
                            'dag_no' => $inplace['dag_no'],
                            'year_no' => $inplace['year_no'],
                            'petition_no' => $inplace['petition_no'],
                            'inplace_of_id' => $inplace['inplace_of_id'],
                        );

                        $queryCheck = "select count(*) as c from   t_chitha_col8_inplace where dist_code='$inplace[dist_code]' and subdiv_code='$inplace[subdiv_code]' and "
                            . "cir_code='$inplace[cir_code]' and mouza_pargona_code='$inplace[mouza_pargona_code]' and lot_no='$inplace[lot_no]' and "
                            . "vill_townprt_code='$inplace[vill_townprt_code]' and dag_no='$inplace[dag_no]' and year_no='$inplace[year_no]' and "
                            . "inplace_of_id='$inplace[inplace_of_id]' and petition_no=$inplace[petition_no] ";
                        $count = $this->db->query($queryCheck)->row()->c;

                        if ($count <= 0) {
                            //var_dump($inplace);
                            $this->db->insert("t_chitha_col8_inplace", $inplace);//************************************************************************************************ insert query
                        }
                    }

                    $occup_data = $all_data['occup_data'];
                    //var_dump($occup_data);
                    unset($all_data['sugg_pno']);

                    foreach ($occup_data as $occup) {
                        $key = array(
                            'dist_code' => $occup['dist_code'],
                            'subdiv_code' => $occup['subdiv_code'],
                            'cir_code' => $occup['cir_code'],
                            'mouza_pargona_code' => $occup['mouza_pargona_code'],
                            'lot_no' => $occup['lot_no'],
                            'vill_townprt_code' => $occup['vill_townprt_code'],
                            'dag_no' => $occup['dag_no'],
                            'year_no' => $occup['year_no'],
                            'petition_no' => $occup['petition_no'],
                            'occupant_id' => $occup['occupant_id'],
                        );
                        $queryCheck = "select count(*) as c from   t_chitha_col8_occup where dist_code='$occup[dist_code]' and subdiv_code='$occup[subdiv_code]' and cir_code='$occup[cir_code]' and "
                            . " mouza_pargona_code='$occup[mouza_pargona_code]' and lot_no='$occup[lot_no]' and vill_townprt_code='$occup[vill_townprt_code]' and dag_no='$occup[dag_no]' and year_no='$occup[year_no]' and "
                            . " occupant_id='$occup[occupant_id]' and petition_no=$inplace[petition_no] ";
                        $count = $this->db->query($queryCheck)->row()->c;
                        ///////////JamaBandi Update Variable Declare///////////////////
                        $patta_no = $occup['patta_no'];
                        $patta_type_code = $occup['patta_type_code'];
                        /////////////////////////////
                        if ($count <= 0) {
                            //var_dump($occup);
                            $this->db->insert("t_chitha_col8_occup", $occup);//************************************************************************************************ insert query
                        }
                    }

                    $final_data = $all_data['final_order'];

                    unset($all_data['sugg_pno']);
                    unset($final_data[0]['not_consistent']);
                    foreach ($final_data as $fd) {
                        unset($fd['not_consistent']);
                        unset($fd['sugg_pno']);
                        $key = array(
                            'dist_code' => $fd['dist_code'],
                            'subdiv_code' => $fd['subdiv_code'],
                            'cir_code' => $fd['cir_code'],
                            'mouza_pargona_code' => $occup['mouza_pargona_code'],
                            'lot_no' => $fd['lot_no'],
                            'vill_townprt_code' => $occup['vill_townprt_code'],
                            'dag_no' => $fd['dag_no'],
                            'year_no' => $fd['year_no'],
                            'petition_no' => $fd['petition_no'],
                        );
                        $queryCheck = "select count(*) as c from   t_chitha_col8_order where dist_code='$fd[dist_code]' and subdiv_code='$fd[subdiv_code]' and "
                            . "cir_code='$fd[cir_code]' and mouza_pargona_code='$fd[mouza_pargona_code]' and lot_no='$fd[lot_no]' and "
                            . "vill_townprt_code='$fd[vill_townprt_code]' and dag_no='$fd[dag_no]' and year_no='$occup[year_no]' and petition_no=$fd[petition_no] ";
                        $count = $this->db->query($queryCheck)->row()->c;

                        if ($count <= 0) {
                            //var_dump($fd);
                            $this->db->insert("t_chitha_col8_order", $fd);//************************************************************************************************ insert query
                        }
                    }

                    $order_date = date('Y-m-d');
                    $q = "update field_mut_basic set order_passed='y',date_of_order='$order_date' where case_no='$case_no' and mouza_pargona_code='$mouza_pargona_code1' and "
                        . "lot_no='$lot_no1' and vill_townprt_code='$vill_townprt_code1' and $this->base_query1";
                    $this->db->query($q);//************************************************************************************************ insert query

                    $q = "select * from   field_mut_basic where case_no='$case_no' and mouza_pargona_code='$mouza_pargona_code1' and "
                        . "lot_no='$lot_no1' and vill_townprt_code='$vill_townprt_code1' and $this->base_query1";
                    $data = $this->db->query($q)->row();

                    $dist_code = $data->dist_code;
                    $subdiv_code = $data->subdiv_code;
                    $cir_code = $data->cir_code;
                    $mouza_pargona_code = $data->mouza_pargona_code;
                    $lot_no = $data->lot_no;
                    $vill_code = $data->vill_townprt_code;
                    $petition_no = $data->petition_no;

                    $dag_no = $this->db->query("select dag_no from   field_mut_dag_details where case_no='$case_no' and mouza_pargona_code='$mouza_pargona_code1' and "
                        . "lot_no='$lot_no1' and vill_townprt_code='$vill_townprt_code1' and $this->base_query1")->result();

                    if ($this->db->trans_status() == FALSE) {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Could Not Pass Order. Error Code [T_TABLE_HAS_DATA].Contact Helpdesk with case no, or delete case through utility.");
                        redirect(base_url() . "index.php/home");
                        return false;
                    }
                    foreach ($dag_no as $d) {
                        $ok = $this->autoUpdate($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $petition_no, $d->dag_no);
                    }
                    if ($ok) {
                        //////
                        $this->DashboardDataFinal($case_no);
                        $basundhara = $this->basundharamodel->checkExistBasundhar($case_no);
                        if ($basundhara) {
                            $rmk = 'Order passed';
                            $status = 'F';
                            $task = 'CO';
                            $pen = 'NA';
                            $case = $case_no;
                            $this->basundharamodel->postApiBasundharaSec($case, $rmk, $status, $task, $pen);
                        }
                        /////
                        $this->session->set_flashdata('message', "Order for Case No $case_no Successfully Saved.");
                        $this->session->set_flashdata('message2', "Chitha Has Been Updated");
                        //////////////JamaBandi Update///////////////////
                        $location = array(
                            'd' => $this->input->post('dist_code'),
                            's' => $this->input->post('subdiv_code'),
                            'c' => $this->input->post('cir_code'),
                            'm' => $this->input->post('mouza_pargona_code'),
                            'l' => $this->input->post('lot_no'),
                            'v' => $this->input->post('vill_townprt_code'),
                        );
                        $this->session->set_userdata('case_no', $case_no);
                        $this->session->set_userdata(array('loc' => $location));
                        $this->session->set_userdata('patta_no', $patta_no);
                        $this->session->set_userdata('patta_type_code', $patta_type_code);
                        //$popUpmsg="<h4>Order for Case No $case_no Successfully Saved.Chitha has been Updated !!! Updating JamaBandi Now<h4>";
                        //$msgggg= "<script type='text/javascript'>alert(' " .$popUpmsg ." ');</script>";
                        //echo $msgggg;
                        //redirect('JamaBandi/JamaBandiPopUp/');

                        redirect('JamaBandi/step3/' . $patta_no . '/' . $patta_type_code);
                        //////////////////////////////
                    } else {
                        $this->session->set_flashdata('message', "Order for Case No $case_no Not Successfull. Contact Helpdesk with case no, or delete case through utility.");

                        redirect(base_url() . "index.php/home");
                    }
                    redirect(base_url() . "index.php/home");
                }
            }
        } else {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
            $lot_no1 = $this->input->get('lot_no');
            $vill_townprt_code1 = $this->input->get('vill_townprt_code');
            $data['dist_code'] = $dist_code;
            $data['subdiv_code'] = $subdiv_code;
            $data['cir_code'] = $cir_code;
            $data['mouza_pargona_code'] = $mouza_pargona_code1;
            $data['lot_no'] = $lot_no1;
            $data['vill_townprt_code'] = $vill_townprt_code1;

            $alongwith_id = 1;
            $data['alongwith_id'] = $alongwith_id;
            $q = "select * from   field_mut_pattadar where case_no='$case_no' and mouza_pargona_code='$mouza_pargona_code1' and "
                . "lot_no='$lot_no1' and vill_townprt_code='$vill_townprt_code1' and $this->base_query1 limit 1 offset $alongwith_id";

            $pattadar = $this->db->query("select * from   field_mut_pattadar where case_no='$case_no'  and mouza_pargona_code='$mouza_pargona_code1' and "
                . "lot_no='$lot_no1' and vill_townprt_code='$vill_townprt_code1' and  $this->base_query1 limit 1 offset $alongwith_id-1")->row();

            $data['pattadar'] = $pattadar;
            $data['case_no'] = $case_no;
            //var_dump($data['pattadar']);
            // $this->load->helper('html');
            // $this->load->view('../views/comutation/inplaceof', $data);
            // $this->load->view('../views/footer');
            $data['_view'] = 'comutation/inplaceof';
            $this->load->view('layouts/main', $data);
        }
    }

    public function autoUpdate($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $petition_no, $dag_no)
    {
        $this->db->trans_begin();
        $db = $this->session->userdata('db');
        $locationData = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'lot_no' => $lot_no,
            'vill_code' => $vill_code,
            'mouza_pargona_code' => $mouza_pargona_code,
        );

        $year_no = year_no;

        $col8order_cron_no = $this->db->query("select max(col8order_cron_no)+1 as cron_no from   chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
            . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and dag_no='$dag_no'")->row()->cron_no;
        if ($col8order_cron_no == null) {
            $col8order_cron_no = 1;
        }

        $t_order_data_query = "select * from   t_chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and "
            . "mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and petition_no=$petition_no and dag_no='$dag_no'";// and iscorrected_inco is null";
        $t_data_order = $this->db->query($t_order_data_query)->result();
        $case_no = null;
        foreach ($t_data_order as $ord) {
            $case_no = $ord->case_no;
            $data_order = array();
            foreach ($ord as $key => $value) {
                $data[$key] = $value;
            }
            $data['col8order_cron_no'] = $col8order_cron_no;
            $data['user_code'] = $this->user_code;
            $data['date_entry'] = date('Y-m-d G:i:s');
            $data['operation'] = date('E');
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
            $this->db->insert("chitha_col8_order", $data); //************************************************************************************************ insert query

            $update_query = "update t_chitha_col8_order  set iscorrected_inco='Y',iscorrected_inco_date='$corrected' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and petition_no=$petition_no and "
                . "dag_no='$dag_no' and iscorrected_inco is null";
            $this->db->query($update_query); //************************************************************************************************ insert query

            $t_inplace_query = "select * from   t_chitha_col8_inplace where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and "
                . "mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and dag_no='$dag_no' and iscorrected_inco is null";
            $t_inplace_data = $this->db->query($t_inplace_query)->result();

            $t_occup_query = "select * from   t_chitha_col8_occup where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and "
                . "mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and petition_no=$petition_no and dag_no='$dag_no'";// and iscorrected_inco is null";
            $t_occup_data = $this->db->query($t_occup_query)->result();

            $chitha_basic_update = FALSE;
            // occupants details starts here
            foreach ($t_occup_data as $occ) {

                // $sql = "update chitha_basic set jama_yn=null where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' and "
                //         . "mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' and dag_no='$occ->dag_no' "
                //         . "and TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' ";
                // $this->db->query($sql); //************************************************************************************************ insert query
                $table = 'chitha_basic';

                $params = [
                    'jama_yn' => null,
                ];

                $where = [
                    'dist_code' => $occ->dist_code,
                    'subdiv_code' => $occ->subdiv_code,
                    'cir_code' => $occ->cir_code,
                    'mouza_pargona_code' => $occ->mouza_pargona_code,
                    'lot_no' => $occ->lot_no,
                    'vill_townprt_code' => $occ->vill_townprt_code,
                    'dag_no' => $occ->dag_no,
                    // Since the SQL uses TRIM() around patta_no, trim here in PHP
                    'patta_no' => trim($occ->patta_no),
                    'patta_type_code' => $occ->patta_type_code,
                ];

                // Then call the update method in your model, e.g.:
                $result_cb = $this->Chitha_basic_model->update_table($table, $params, $where);


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
                $data['user_code'] = $this->user_code;
                $data['date_entry'] = date('Y-m-d G:i:s');
                $data['operation'] = date('E');
                $occupData = $data;
                //var_dump($data);

                $this->db->insert("chitha_col8_occup", $data); //************************************************************************************************ insert query

                $dag_pattadar = array();
                $chitha_pattadar = array();

                $pdar_id = $occ->pdar_id;

                if ($ord->order_type_code == '02') {
                    // Order Type Code 02 iIs For Field Partition. and 01 is For Field Mutation
                    $pdar_id = $this->db->query("select max(cast(pdar_id as int))+1 as pdar_id from   chitha_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                        . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and "
                        . "TRIM(patta_no)=trim('$occ->new_patta_no')")->row()->pdar_id;
                }

                if ($pdar_id == null) {
                    $pdar_id = 1;
                }
                //echo $pdar_id;
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

                $dag_pattadar['user_code'] = $this->user_code;
                $dag_pattadar['date_entry'] = date('Y-m-d G:i:s');
                $dag_pattadar['operation'] = date('E');

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
                $chitha_pattadar['pdar_add3'] = $occ->occupant_add3;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_guard_reln'] = $occ->occupant_fmh_flag;
                $chitha_pattadar['user_code'] = $this->user_code;
                $chitha_pattadar['date_entry'] = date('Y-m-d G:i:s');
                $chitha_pattadar['operation'] = date('E');
                $chitha_pattadar['jama_yn'] = 'N';


                $chitha_basic_query = "select land_class_code from   chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' "
                    . "and mouza_pargona_code='$mouza_pargona_code' and TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' and dag_no='$dag_no'";
                $result = $this->db->query($chitha_basic_query)->row();

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
                $chitha_basic['user_code'] = $this->user_code;
                $chitha_basic['date_entry'] = date('Y-m-d G:i:s');
                $chitha_basic['land_class_code'] = $result->land_class_code;

                if ($ord->order_type_code == '02') {
                    $old_dag = $dag_no;
                    $chitha_basic['dag_no'] = $occ->new_dag_no;
                    $chitha_basic['dag_no_int'] = $occ->new_dag_no . '00';
                    $chitha_basic['old_dag_no '] = $dag_no;
                    $old_patta = trim($occ->old_patta_no);
                    $chitha_basic['patta_no'] = trim($occ->new_patta_no);

                    $q = "update chitha_col8_order set new_dag_no='$occ->new_dag_no' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                        . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and col8order_cron_no=$col8order_cron_no and dag_no='$dag_no' ";
                    $this->db->query($q); //************************************************************************************************ insert query
                } else {
                    $chitha_basic['dag_no'] = $dag_no;

                    $q = "select dag_no_int as dag_no_int from   chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                        . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$occ->patta_type_code' and "
                        . "TRIM(patta_no)=trim('$occ->patta_no')";
                    $dag_no_int = $this->db->query($q)->row()->dag_no_int;

                    $chitha_basic['dag_no_int'] = $dag_no_int;
                    $chitha_basic['patta_no'] = trim($occ->patta_no);
                }

                $chitha_basic['patta_type_code'] = $occ->patta_type_code;
                $chitha_basic['operation'] = "E";
                //var_dump($dag_pattadar);

                $corrected = date('Y-m-d G:i:s');
                if ((!$chitha_basic_update) && ($ord->order_type_code == '02')) {
                    // This Block Is For Field Partition
                    $chitha_basic_update = TRUE;
                    $sql = "select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,dag_revenue from   chitha_basic where dist_code='$occ->dist_code' and "
                        . "subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' and mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and "
                        . "vill_townprt_code='$occ->vill_townprt_code' and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' ";
                    $data = $this->db->query($sql)->row();

                    $chitha_basic['dag_revenue'] = $ord->min_revenue * (($ord->mut_land_area_b * 100 + $ord->mut_land_area_k * 20 + $ord->mut_land_area_lc) / 100.0);
                    $chitha_basic['dag_local_tax'] = $chitha_basic['dag_revenue'] / 4.0;

                    // $this->db->insert("chitha_basic", $chitha_basic); //************************************************************************************************ insert query
                    $this->Chitha_basic_model->insert_table('chitha_basic', $chitha_basic);
                    $dataNew['dag_no'] = $chitha_basic['dag_no'];
                    $this->db->insert("chitha_col8_order", $dataNew); //************************************************************************************************ insert query

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
                    // $sql = "update chitha_basic set jama_yn=null,dag_revenue=$dag_revenue_updates,dag_local_tax=$dag_local_tax_update,dag_area_b=$left_b,dag_area_k=$left_k,"
                    //         . "dag_area_lc=$left_lc,dag_area_g=$left_g,dag_area_kr=$left_kr,date_entry='$d',operation='M' where dist_code='$occ->dist_code' and "
                    //         . "subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' and mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and "
                    //         . "vill_townprt_code='$occ->vill_townprt_code' and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' ";
                    // $this->db->query($sql); //************************************************************************************************ insert query

                    $table = 'chitha_basic';

                    $params = [
                        'jama_yn' => null,
                        'dag_revenue' => $dag_revenue_updates,
                        'dag_local_tax' => $dag_local_tax_update,
                        'dag_area_b' => $left_b,
                        'dag_area_k' => $left_k,
                        'dag_area_lc' => $left_lc,
                        'dag_area_g' => $left_g,
                        'dag_area_kr' => $left_kr,
                        'date_entry' => $d,        // assuming $d is properly formatted date string
                        'operation' => 'M',
                    ];

                    $where = [
                        'dist_code' => $occ->dist_code,
                        'subdiv_code' => $occ->subdiv_code,
                        'cir_code' => $occ->cir_code,
                        'mouza_pargona_code' => $occ->mouza_pargona_code,
                        'lot_no' => $occ->lot_no,
                        'vill_townprt_code' => $occ->vill_townprt_code,
                        'dag_no' => $occ->dag_no,
                        // To mimic TRIM in SQL, trim in PHP
                        'patta_no' => trim($occ->patta_no),
                        'patta_type_code' => $occ->patta_type_code,
                    ];

                    // Call your model update function
                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                }

                $p_id = $dag_pattadar['pdar_id'];

                if ($ord->order_type_code == '02') {
                    // This Block Is For Field Partition
                    $q = "select count(*) as count from   chitha_dag_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' "
                        . "and mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' and dag_no='$occ->dag_no' "
                        . "and TRIM(patta_no)=trim('$occ->new_patta_no') and patta_type_code='$occ->patta_type_code' and pdar_id='$p_id'";
                    $cDagPattadarExists = $this->db->query($q)->row()->count;

                    $q = "select count(*) as count from   chitha_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                        . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                        . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                        . " and TRIM(patta_no)=trim('$occ->new_patta_no') and"
                        . " patta_type_code='$occ->patta_type_code' and pdar_id='$p_id'";
                    $cPattadarExists = $this->db->query($q)->row()->count;
                } else {
                    // This Block Is For Field Mutation
                    $q = "select count(*) as count from   chitha_dag_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' "
                        . "and mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' and dag_no='$occ->dag_no' "
                        . "and TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' and pdar_id='$p_id'";
                    $cDagPattadarExists = $this->db->query($q)->row()->count;

                    $q = "select count(*) as count from   chitha_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' and "
                        . "mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' and "
                        . "TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' and pdar_id='$p_id'";
                    $cPattadarExists = $this->db->query($q)->row()->count;
                }
                //var_dump($dag_pattadar);
                $occ->new_pattadar; // for partition it will always be new pattadar
                if (($occ->new_pattadar == 'N')) {
                    //var_dump($dag_pattadar);
                    //var_dump($chitha_pattadar);
                    // $this->db->insert("chitha_dag_pattadar", $dag_pattadar);//************************************************************************************************ insert query
                    $this->Chitha_basic_model->insert_table('chitha_dag_pattadar', $dag_pattadar);
                    if (($cPattadarExists == 0)) {
                        $chitha_pattadar['f1_case_no'] = $case_no;

                        // $this->db->insert("chitha_pattadar", $chitha_pattadar);//************************************************************************************************ insert query
                        $this->Chitha_basic_model->insert_table('chitha_pattadar', $chitha_pattadar);
                    }
                }
                $today = date('Y-m-d');
                $t_occup_query = "update t_chitha_col8_occup set iscorrected_inco='Y',iscorrected_inco_date='$corrected',order_passed='Y' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                    . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                    . "vill_townprt_code='$vill_code' and petition_no=$petition_no and dag_no='$dag_no' ";
                $this->db->query($t_occup_query);//************************************************************************************************ insert query
            }
            // occupants details ends here
            if ($ord->order_type_code == '02') {
                foreach ($t_occup_data as $occup) {
                    // $sql = "update chitha_dag_pattadar set p_flag='1' where   dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and dag_no='$dag_no' and pdar_id=$occup->pdar_id";
                    // $this->db->query($sql);//************************************************************************************************ insert query
                    $table = 'chitha_dag_pattadar';

                    $params = [
                        'p_flag' => '1',
                    ];

                    $where = [
                        'dist_code' => $dist_code,
                        'subdiv_code' => $subdiv_code,
                        'cir_code' => $cir_code,
                        'lot_no' => $lot_no,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'vill_townprt_code' => $vill_code,
                        'dag_no' => $dag_no,
                        'pdar_id' => $occup->pdar_id,
                    ];

                    $this->Chitha_basic_model->update_table($table, $params, $where);

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

                    $queryCheck = "select count(*) as c from   chitha_col8_inplace where dist_code='$data[dist_code]' and subdiv_code='$data[subdiv_code]' and cir_code='$data[cir_code]' and "
                        . " mouza_pargona_code='$data[mouza_pargona_code]' and lot_no='$data[lot_no]' and vill_townprt_code='$data[vill_townprt_code]' and dag_no='$data[dag_no]' and "
                        . "col8order_cron_no='$data[col8order_cron_no]' and inplace_of_id='$data[inplace_of_id]' ";
                    $count = $this->db->query($queryCheck)->row()->c;
                    if ($count <= 0)
                        $this->db->insert("chitha_col8_inplace", $data);//************************************************************************************************ insert query

                    $p_flag = '0';
                    if ($inplace->fmute_strike_out == '1')
                        $p_flag = '1';
                    $corrected = date('Y-m-d G:i:s');
                    // $update_query = "update chitha_dag_pattadar  set p_flag='$p_flag',date_entry='$corrected' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and dag_no='$dag_no' and pdar_id=$inplace->pdar_id";

                    // $this->db->query($update_query);//************************************************************************************************ insert query
                    $table = 'chitha_dag_pattadar';

                    $params = [
                        'p_flag' => $p_flag,
                        'date_entry' => $corrected,
                    ];

                    $where = [
                        'dist_code' => $dist_code,
                        'subdiv_code' => $subdiv_code,
                        'cir_code' => $cir_code,
                        'lot_no' => $lot_no,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'vill_townprt_code' => $vill_code,
                        'dag_no' => $dag_no,
                        'pdar_id' => $inplace->pdar_id,
                    ];

                    $this->Chitha_basic_model->update_table($table, $params, $where);

                    $t_inplace_query = "update t_chitha_col8_inplace set iscorrected_inco='Y',iscorrected_inco_date='$corrected',order_passed='Y' where dist_code='$dist_code' and "
                        . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' "
                        . "and dag_no='$dag_no'";
                    $this->db->query($t_inplace_query);//************************************************************************************************ insert query
                    $date_of_order = date('Y-m-d');
                    $order_update_query = "update field_mut_basic set order_passed='Y',date_of_order='$date_of_order' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                        . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                        . "vill_townprt_code='$vill_code' and petition_no=$petition_no";
                    $this->db->query($order_update_query);//************************************************************************************************ insert query
                }
            }
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            $date_of_order = date('Y-m-d');
            $order_update_query = "update field_mut_basic set order_passed='Y',date_of_order='$date_of_order' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                . "vill_townprt_code='$vill_code' and petition_no='$petition_no'";
            $this->db->query($order_update_query);
            return true;
        }
    }


    // 
    public function getLMReport()
    {
        $db = $this->session->userdata('db');
        $case_no = $this->input->get('case_no');
        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];
        $location = $this->db->get_where("field_mut_basic", array('case_no' => $case_no, 'dist_code' => $dist_code, 'cir_code' => $cir_code, 'subdiv_code' => $subdiv_code))->row();

        $patta = $this->db->get_where("field_mut_pattadar", array('case_no' => $case_no, 'dist_code' => $dist_code, 'cir_code' => $cir_code, 'subdiv_code' => $subdiv_code))->row();
        $petitioner = $this->db->get_where("field_mut_petitioner", array('case_no' => $case_no, 'dist_code' => $dist_code, 'cir_code' => $cir_code, 'subdiv_code' => $subdiv_code))->result();
        $dag_details = $this->db->get_where("field_mut_dag_details", array('case_no' => $case_no, 'dist_code' => $dist_code, 'cir_code' => $cir_code, 'subdiv_code' => $subdiv_code))->row();
        $allpattadar = $this->db->get_where("field_mut_pattadar", array('case_no' => $case_no, 'dist_code' => $dist_code, 'cir_code' => $cir_code, 'subdiv_code' => $subdiv_code))->result();

        $dist_code = $this->utilityclass->getDistrictName($location->dist_code);
        $subdiv_code = $this->utilityclass->getSubDivName($location->dist_code, $location->subdiv_code);
        $cir_code = $this->utilityclass->getCircleName($location->dist_code, $location->subdiv_code, $location->cir_code);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($location->dist_code, $location->subdiv_code, $location->cir_code, $location->mouza_pargona_code);
        $lot_no = $this->utilityclass->getLotName($location->dist_code, $location->subdiv_code, $location->cir_code, $location->mouza_pargona_code, $location->lot_no);
        $vill_townprt_code = $this->utilityclass->getVillageName($location->dist_code, $location->subdiv_code, $location->cir_code, $location->mouza_pargona_code, $location->lot_no, $location->vill_townprt_code);
        $transcode = $this->utilityclass->getTransferType($location->trans_code);

        $patta_type_code = $patta->patta_type_code;
        $patta_type = $this->db->get_where("patta_code", array('type_code' => $patta_type_code))->row()->patta_type;

        $locations = array(
            'd' => $dist_code,
            'sd' => $subdiv_code,
            'c' => $cir_code,
            'm' => $mouza_pargona_code,
            'l' => $lot_no,
            'v' => $vill_townprt_code,
            'trans_code' => $transcode,
            'deedno' => $location->reg_deed_no,
            'possession' => $location->possession_yn,
            'dispute' => $location->dispute_yn
        );

        $pattainfo = array(
            'p' => $patta_type
        );

        $data['location'] = $locations;
        $data['pattadar'] = $location;
        $data['patta'] = $pattainfo;
        $data['case_no'] = $case_no;
        $data['petitioner'] = $petitioner;
        $data['dag'] = $dag_details;
        $data['allpattadar'] = $allpattadar;

        // $this->load->helper('html');

        // $this->load->view('../views/comutation/lmreport', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'comutation/lmreport';
        $this->load->view('layouts/main', $data);

    }

    public function getSkNote()
    {
        // $db=  $this->session->userdata('db');
        $append = $this->base_query;
        $case_no = $this->input->get('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $cir_code = $this->session->userdata('cir_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
        $lot_no1 = $this->input->get('lot_no');
        $vill_townprt_code1 = $this->input->get('vill_townprt_code');

        $data['sknote'] = $this->cofieldmutationmodel->getSkNote($case_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code1, $lot_no1, $vill_townprt_code1);

        $data['case_no'] = $case_no;
        $location = $this->db->get_where("field_mut_basic", array('case_no' => $case_no, 'cir_code' => $cir_code, 'dist_code' => $dist_code, 'subdiv_code' => $subdiv_code))->row();
        $dist_code = $this->utilityclass->getDistrictName($location->dist_code);
        $subdiv_code = $this->utilityclass->getSubDivName($location->dist_code, $location->subdiv_code);
        $cir_code = $this->utilityclass->getCircleName($location->dist_code, $location->subdiv_code, $location->cir_code);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($location->dist_code, $location->subdiv_code, $location->cir_code, $location->mouza_pargona_code);
        $lot_no = $this->utilityclass->getLotName($location->dist_code, $location->subdiv_code, $location->cir_code, $location->mouza_pargona_code, $location->lot_no);
        $vill_townprt_code = $this->utilityclass->getVillageName($location->dist_code, $location->subdiv_code, $location->cir_code, $location->mouza_pargona_code, $location->lot_no, $location->vill_townprt_code);

        //$transcode = $this->utilityclass->getTransferType($location->trans_code);

        $locations = array(
            'd' => $dist_code,
            'sd' => $subdiv_code,
            'c' => $cir_code,
            'm' => $mouza_pargona_code,
            'l' => $lot_no,
            'v' => $vill_townprt_code,
            'deedno' => $location->reg_deed_no,
            'possession' => $location->possession_yn,
            'dispute' => $location->dispute_yn,
            'report_date' => $location->sk_note_date
        );

        $data['location'] = $locations;
        $this->load->view('../views/comutation/sknote', $data);

        // $data['_view'] = 'comutation/sknote';
        // $this->load->view('layouts/main',$data);
    }

    public function requestFreshReport($case_no)
    {
        $db = $this->session->userdata('db');
        $data = array(
            'co_flag_for_fresh_mut' => 'y',
            'co_flag_date' => date('Y-m-d G:i:s')
        );
        $this->db->where('case_no', $case_no);
        $this->db->update($data);
    }

    public function saveReport()
    {
        $db = $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $case_no = $this->input->post('case_no');
            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $cir_code = $this->input->post('cir_code');
            $mouza_pargona_code = $this->input->post('mouza_pargona_code');
            $lot_no = $this->input->post('lot_no');
            $vill_townprt_code = $this->input->post('vill_townprt_code');

            $data = array(
                'dispose_reason' => addslashes($this->input->post('sk_note')),
                'is_dispose' => 'Y',
                'if_dispose_date' => date('Y-m-d'),
                'order_passed' => 'Y'
            );

            $this->db->where('case_no', $case_no);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('mouza_pargona_code', $mouza_pargona_code);
            $this->db->where('lot_no', $lot_no);
            $this->db->where('vill_townprt_code', $vill_townprt_code);
            $this->db->update("field_mut_basic", $data);
            ////////////////action///////
            $this->DashboardDataReject($case_no);
            //////////////////////
            $basundharaExist = $this->basundharamodel->checkExistBasundhar($case_no);
            if ($basundharaExist) {
                $rmk = addslashes($this->input->post('sk_note'));
                $status = 'R';
                $task = 'CO';
                $pen = 'NA';
                $case = $case_no;
                $this->basundharamodel->postApiBasundharaSec($case, $rmk, $status, $task, $pen);
            }
            /////////////////////
            $this->session->set_flashdata('message', 'Case' . $case_no . ' Successfully Rejected.');
            redirect(base_url() . "index.php/home");
        } else {
            $case_no = $this->input->get('case_no');
            $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
            $lot_no1 = $this->input->get('lot_no');
            $vill_townprt_code1 = $this->input->get('vill_townprt_code');

            $data['case_no'] = $case_no;
            $dag_no = $this->db->get_where("field_mut_dag_details", array(
                'case_no' => $case_no,
                'cir_code' => $cir_code,
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'mouza_pargona_code' => $mouza_pargona_code1,
                'lot_no' => $lot_no1,
                'vill_townprt_code' => $vill_townprt_code1
            ))->result();
            $data['dag_no'] = $dag_no;
            $data['dist_code'] = $dist_code;
            $data['subdiv_code'] = $subdiv_code;
            $data['cir_code'] = $cir_code;
            $data['mouza_pargona_code'] = $mouza_pargona_code1;
            $data['lot_no'] = $lot_no1;
            $data['vill_townprt_code'] = $vill_townprt_code1;

            // $this->load->helper('html');
            // $this->load->view('../views/comutation/skreport', $data);


        }
        $data['_view'] = 'comutation/skreport';
        $this->load->view('layouts/main', $data);

    }

    public function updateChitha()
    {
        $db = $this->session->userdata('db');
        $locationdata = $this->showLocation();
    }

    public function autoUpdate_fulldag($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $petition_no, $dag_no)
    {

        $locationData = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'lot_no' => $lot_no,
            'vill_code' => $vill_code,
            'mouza_pargona_code' => $mouza_pargona_code,
        );

        $year_no = year_no;

        $col8order_cron_no = $this->db->query("select max(col8order_cron_no)+1 as cron_no from   chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
            . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
            . "vill_townprt_code='$vill_code' and dag_no='$dag_no'")->row()->cron_no;
        //echo "select max(col8order_cron_no)+1 as cron_no from   chitha_col8_order";

        if ($col8order_cron_no == null) {
            $col8order_cron_no = 1;
        }
        $t_order_data_query = "select * from   t_chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
            . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
            . "vill_townprt_code='$vill_code' and petition_no=$petition_no and dag_no='$dag_no' and iscorrected_inco is null";
        //echo $t_order_data_query;

        $t_data_order = $this->db->query($t_order_data_query);

        if ($t_data_order == null || $t_data_order->num_rows() <= 0) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "FPTCO007: Unable to pass order !");
            log_message("error", "#FPTCO007 No detail available in t_chitha_col8_order for dist:" . $dist_code . ", petition no: " . $petition_no);
            redirect(base_url() . "index.php/home");
            return;
        }

        $t_data_order = $t_data_order->result();
        $case_no = null;
        foreach ($t_data_order as $ord) {
            $case_no = $ord->case_no;
            $data_order = array();
            foreach ($ord as $key => $value) {
                $data[$key] = $value;
            }
            //var_dump($data);
            $data['col8order_cron_no'] = $col8order_cron_no;
            $data['user_code'] = $this->user_code;
            $data['date_entry'] = date('Y-m-d G:i:s');
            $data['operation'] = date('E');
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
            $tstatus11 = $this->db->insert("chitha_col8_order", $data); //*************************

            if ($tstatus11 != 1) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "FPCC008: Unable to pass order !");
                log_message("error", "#FPCC008 Insertion failed in chitha_col8_order for dist: " . $dist_code . ", petition no: " . $petition_no);
                redirect(base_url() . "index.php/home");
                return;
            }

            $update_query = "update t_chitha_col8_order  set iscorrected_inco='Y',iscorrected_inco_date='$corrected' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                . "vill_townprt_code='$vill_code' and petition_no=$petition_no and  dag_no='$dag_no' and iscorrected_inco is null";
            $this->db->query($update_query); //************************

            if ($this->db->affected_rows() <= 0) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "FPTCC009: Unable to pass order !");
                log_message("error", "#FPTCC009 Updation failed in t_chitha_col8_order for dist: " . $dist_code . ", petition no: " . $petition_no);
                redirect(base_url() . "index.php/home");
                return;
            }


            $t_inplace_query = "select * from   t_chitha_col8_inplace where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                . "vill_townprt_code='$vill_code' and dag_no='$dag_no' and iscorrected_inco is null";

            $t_inplace_data = $this->db->query($t_inplace_query);
            if ($t_inplace_query == null || $t_inplace_query->num_rows() <= 0) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "FPTCC009: Unable to pass order !");
                log_message("error", "#FPCC009 Data not available in t_chitha_col8_inplace for dist:" . $dist_code . ", petition no: " . $petition_no);
                redirect(base_url() . "index.php/home");
                return;
            }
            $t_inplace_data = $this->db->query($t_inplace_query)->result();


            //var_dump($t_inplace_data);

            $t_occup_query = "select * from   t_chitha_col8_occup where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                . "vill_townprt_code='$vill_code' and petition_no=$petition_no and dag_no='$dag_no' "
                . " and iscorrected_inco is null";
            //echo $t_occup_query;

            $t_occup_data = $this->db->query($t_occup_query);
            if ($t_occup_data == null || $t_occup_data->num_rows() <= 0) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "FPTCC010: Unable to pass order !");
                log_message("error", "#FPTCC010 Data not available in t_chitha_col8_occup for dist:" . $dist_code . ", petition no: " . $petition_no);
                redirect(base_url() . "index.php/home");
                return;
            }
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
                    'jama_yn' => null,
                    'patta_no' => $occ->new_patta_no,
                    'old_patta_no' => $occ->patta_no,
                ];

                $where = [
                    'dist_code' => $occ->dist_code,
                    'subdiv_code' => $occ->subdiv_code,
                    'cir_code' => $occ->cir_code,
                    'mouza_pargona_code' => $occ->mouza_pargona_code,
                    'lot_no' => $occ->lot_no,
                    'vill_townprt_code' => $occ->vill_townprt_code,
                    'dag_no' => $occ->dag_no,
                    'patta_no' => trim($occ->patta_no),  // trimming in PHP to replicate TRIM in SQL
                    'patta_type_code' => $occ->patta_type_code,
                ];

                // Then call the update method in your model:
                $result = $this->Chitha_basic_model->update_table($table, $params, $where);


                if ($result <= 0) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "FPCB011: Unable to pass order !");
                    log_message("error", "#FPCB011 Updation failed in chitha_basic for dist: " . $dist_code . ", petition no: " . $petition_no);
                    redirect(base_url() . "index.php/home");
                    return;
                }


                //$this->db->trans_begin();
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
                $data['user_code'] = $this->user_code;
                $data['date_entry'] = date('Y-m-d G:i:s');
                $data['operation'] = date('E');
                $occupData = $data;
                //var_dump($data);
                $tstatus12 = $this->db->insert("chitha_col8_occup", $data); // ******************

                if ($tstatus12 != 1) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "FPCCO012: Unable to pass order !");
                    log_message("error", "#FPCCO012 Insertion failed in chitha_col8_occup for dist:" . $dist_code . ", petition no: " . $petition_no);
                    redirect(base_url() . "index.php/home");
                    return;
                }

                $dag_pattadar = array();
                $chitha_pattadar = array();

                $pdar_id = null;

                if ($ord->order_type_code == '02') {
                    $pdar_id = $this->db->query("select max(cast(pdar_id as int))+1 as pdar_id from   chitha_pattadar where dist_code='$dist_code' and "
                        . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and"
                        . " mouza_pargona_code='$mouza_pargona_code' and "
                        . " vill_townprt_code='$vill_code' and TRIM(patta_no)=trim('$occ->patta_no')  "
                        . " ")->row()->pdar_id;

                } else {

                    $pdar_id = $this->db->query("select max(cast(pdar_id as int))+1 as pdar_id from   chitha_pattadar where dist_code='$dist_code' and "
                        . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and"
                        . " mouza_pargona_code='$mouza_pargona_code' and "
                        . " vill_townprt_code='$vill_code' and TRIM(patta_no)=trim('$occ->patta_no')  "
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
                    $dag_pattadar['pdar_id'] = $occ->pdar_id;
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

                $dag_pattadar['user_code'] = $this->user_code;
                $dag_pattadar['date_entry'] = date('Y-m-d G:i:s');
                $dag_pattadar['operation'] = date('E');

                $chitha_pattadar['dist_code'] = $dist_code;
                $chitha_pattadar['subdiv_code'] = $subdiv_code;
                $chitha_pattadar['cir_code'] = $cir_code;
                $chitha_pattadar['lot_no'] = $lot_no;
                $chitha_pattadar['mouza_pargona_code'] = $mouza_pargona_code;
                $chitha_pattadar['vill_townprt_code'] = $vill_code;

                $chitha_pattadar['pdar_id'] = $occ->pdar_id;
                $chitha_pattadar['new_pdar_name'] = $occ->new_pattadar;
                $chitha_pattadar['patta_type_code'] = $occ->patta_type_code;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_father'] = $occ->occupant_fmh_name;
                $chitha_pattadar['pdar_add1'] = $occ->occupant_add1;
                $chitha_pattadar['pdar_add2'] = $occ->occupant_add2;
                $chitha_pattadar['pdar_add3'] = $occ->occupant_add3;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_guard_reln'] = $occ->occupant_fmh_flag;
                $chitha_pattadar['user_code'] = $this->user_code;
                $chitha_pattadar['date_entry'] = date('Y-m-d G:i:s');
                $chitha_pattadar['operation'] = date('E');
                $chitha_pattadar['jama_yn'] = 'N';
                //var_dump($chitha_pattadar);
                //var_dump($dag_pattadar);
                $chitha_basic_query = "select land_class_code from   chitha_basic "
                    . "where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                    . " cir_code='$cir_code' and lot_no='$lot_no' and"
                    . " mouza_pargona_code='$mouza_pargona_code' and TRIM(patta_no)=trim('$occ->new_patta_no') and"
                    . " patta_type_code='$occ->patta_type_code' and dag_no='$dag_no'";
                //echo($chitha_basic_query);
                $result = $this->db->query($chitha_basic_query);
                if ($result == null || $result->num_rows() <= 0) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "FPLCCO013: Unable to pass order !");
                    log_message("error", "#FPLCCO013 Data not available in land_class_code for dist:" . $dist_code . ", petition no: " . $petition_no);
                    redirect(base_url() . "index.php/home");
                    return;
                }
                $result = $result->row();
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
                $chitha_basic['user_code'] = $this->user_code;
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
                    if ($this->db->affected_rows() <= 0) {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "FPCCO014: Unable to pass order !");
                        log_message("error", "#FPCCO014 Updation failed in chitha_col8_order for dist:" . $dist_code . ", petition no: " . $petition_no);
                        redirect(base_url() . "index.php/home");
                        return;
                    }


                } else {
                    $chitha_basic['dag_no'] = $dag_no;

                    $q = "select dag_no_int as dag_no_int from   chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'" .
                        " and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$occ->patta_type_code' and TRIM(patta_no)=trim('$occ->patta_no')";

                    $dag_no_int = $this->db->query($q)->row()->dag_no_int;

                    $chitha_basic['dag_no_int'] = $dag_no_int;
                    $chitha_basic['patta_no'] = trim($occ->patta_no);
                }
                $chitha_basic['patta_type_code'] = $occ->patta_type_code;

                $chitha_basic['operation'] = "E";
                //var_dump($chitha_basic);
                //var_dump($dag_pattadar);
                $corrected = date('Y-m-d G:i:s');
                if ((!$chitha_basic_update) && ($ord->order_type_code == '02')) {

                    $chitha_basic_update = TRUE;
                    // $update_for_old_jama="Update chitha_basic set jama_yn=null where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                    //         . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                    //         . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                    //         . " and TRIM(patta_no)=trim('$occ->patta_no') and"
                    //         . " patta_type_code='$occ->patta_type_code' ";

                    // $this->db->query($update_for_old_jama); //*******************

                    $table = 'chitha_basic';

                    $params = [
                        'jama_yn' => null,
                    ];

                    $where = [
                        'dist_code' => $occ->dist_code,
                        'subdiv_code' => $occ->subdiv_code,
                        'cir_code' => $occ->cir_code,
                        'mouza_pargona_code' => $occ->mouza_pargona_code,
                        'lot_no' => $occ->lot_no,
                        'vill_townprt_code' => $occ->vill_townprt_code,
                        // Use PHP trim here to replicate SQL TRIM in condition
                        'patta_no' => trim($occ->patta_no),
                        'patta_type_code' => $occ->patta_type_code,
                    ];

                    // Then call the update method on your model:
                    $result0 = $this->Chitha_basic_model->update_table($table, $params, $where);

                    if ($result0 <= 0) {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "FPCBO015: Unable to pass order !");
                        log_message("error", "#FPCBO015 Failed to update jama_yn=null in chitha_basic for dist:" . $dist_code . ", petition no: " . $petition_no);
                        redirect(base_url() . "index.php/home");
                        return;
                    }

                    $sql = "select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,dag_revenue from chitha_basic where"
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
                        'jama_yn' => null,
                        'dag_revenue' => $dag_revenue_updates,
                        'dag_local_tax' => $dag_local_tax_update,
                        'dag_area_b' => $ord->mut_land_area_b,
                        'dag_area_k' => $ord->mut_land_area_k,
                        'dag_area_lc' => $ord->mut_land_area_lc,
                        'dag_area_g' => $left_g,
                        'dag_area_kr' => $left_kr,
                        'date_entry' => $d,  // Assuming $d is a formatted date string
                        'operation' => 'M',
                    ];

                    $where = [
                        'dist_code' => $occ->dist_code,
                        'subdiv_code' => $occ->subdiv_code,
                        'cir_code' => $occ->cir_code,
                        'mouza_pargona_code' => $occ->mouza_pargona_code,
                        'lot_no' => $occ->lot_no,
                        'vill_townprt_code' => $occ->vill_townprt_code,
                        'dag_no' => $occ->dag_no,
                        'patta_no' => trim($occ->new_patta_no),  // Trim in PHP to mimic SQL TRIM()
                        'patta_type_code' => $occ->patta_type_code,
                    ];

                    // Then call your model update method
                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                    if ($result <= 0) {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "FPCBO016: Unable to pass order !");
                        log_message("error", "#FPCBO016 Failed to update jama_yn=null in chitha_basic for dist:" . $dist_code . ", petition no: " . $petition_no);
                        redirect(base_url() . "index.php/home");
                        return;
                    }
                }
                $p_id = $occ->pdar_id;
                $q = "select count(*) as count from   chitha_dag_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                    . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                    . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                    . " and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->patta_no') and"
                    . " patta_type_code='$occ->patta_type_code'";// and pdar_id=$p_id";
                //echo $q;
                $cDagPattadarExists = $this->db->query($q)->row()->count;

                $q = "select count(*) as count from   chitha_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                    . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                    . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                    . " and TRIM(patta_no)=trim('$occ->new_patta_no') and"
                    . " patta_type_code='$occ->patta_type_code' and pdar_id=$p_id";
                //echo $q;
                $cPattadarExists = $this->db->query($q)->row()->count;

                $occ->new_pattadar;

                //update chitha_dag_pattadar
                // $update_pattadar = "Update chitha_dag_pattadar set patta_no='$occ->new_patta_no', p_flag = null,jama_yn='n' where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                //         . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                //         . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                //         . " and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->patta_no') and"
                //         . " patta_type_code='$occ->patta_type_code'";
                // //echo $update_pattadar;
                // $this->db->query($update_pattadar); //*******************
                $table = 'chitha_dag_pattadar';

                $params = [
                    'patta_no' => $occ->new_patta_no,
                    'p_flag' => null,
                    'jama_yn' => 'n',
                ];

                $where = [
                    'dist_code' => $occ->dist_code,
                    'subdiv_code' => $occ->subdiv_code,
                    'cir_code' => $occ->cir_code,
                    'mouza_pargona_code' => $occ->mouza_pargona_code,
                    'lot_no' => $occ->lot_no,
                    'vill_townprt_code' => $occ->vill_townprt_code,
                    'dag_no' => $occ->dag_no,
                    'patta_no' => trim($occ->patta_no),
                    'patta_type_code' => $occ->patta_type_code,
                ];

                $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                //insert in chitha_pattadar
                if ($result <= 0) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "FPCDP017: Unable to pass order !");
                    log_message("error", "#FPCDP017 Updation failed in chitha_dag_pattadar for dist:" . $dist_code . ", petition no: " . $petition_no);
                    redirect(base_url() . "index.php/home");
                    return;
                }

                if ($cPattadarExists == 0) {
                    $chitha_pattadar['f1_case_no'] = $case_no;

                    //var_dump ($chitha_pattadar);
                    // $this->db->insert("chitha_pattadar", $chitha_pattadar); // ********************
                    $this->Chitha_basic_model->insert_table('chitha_pattadar', $chitha_pattadar);
                }
                // exit;
                $today = date('Y-m-d');
                $t_occup_query = "update t_chitha_col8_occup set iscorrected_inco='Y',iscorrected_inco_date='$corrected',order_passed='Y' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                    . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                    . "vill_townprt_code='$vill_code' and petition_no=$petition_no and dag_no='$dag_no' ";
                $this->db->query($t_occup_query); // ********************
                if ($this->db->affected_rows() <= 0) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "FPTCC018: Unable to pass order !");
                    log_message("error", "#FPTCC018 Failed to update iscorrected_inco in t_chitha_col8_occup for dist:" . $dist_code . ", petition no: " . $petition_no);
                    redirect(base_url() . "index.php/home");
                    return;
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

                    $queryCheck = "select count(*) as c from   chitha_col8_inplace where dist_code='$data[dist_code]' and subdiv_code='$data[subdiv_code]' and cir_code='$data[cir_code]' and "
                        . " mouza_pargona_code='$data[mouza_pargona_code]' and lot_no='$data[lot_no]' and vill_townprt_code='$data[vill_townprt_code]' and dag_no='$data[dag_no]' and col8order_cron_no='$data[col8order_cron_no]' and "
                        . " inplace_of_id='$data[inplace_of_id]' ";
                    $count = $this->db->query($queryCheck)->row()->c;
                    if ($count <= 0)
                        //var_dump($data);
                        $this->db->insert("chitha_col8_inplace", $data);

                    $p_flag = '0';
                    if ($inplace->fmute_strike_out == '1')
                        $p_flag = '1';

                    // $update_query = "update chitha_dag_pattadar  set p_flag='$p_flag',jama_yn='n' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                    //         . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                    //         . "vill_townprt_code='$vill_code' and dag_no='$dag_no' and pdar_id=$inplace->pdar_id";
                    // //echo $update_query;
                    // $this->db->query($update_query);

                    $table = 'chitha_dag_pattadar';

                    $params = [
                        'p_flag' => $p_flag,
                        'jama_yn' => 'n',
                    ];

                    $where = [
                        'dist_code' => $dist_code,
                        'subdiv_code' => $subdiv_code,
                        'cir_code' => $cir_code,
                        'lot_no' => $lot_no,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'vill_townprt_code' => $vill_code,
                        'dag_no' => $dag_no,
                        'pdar_id' => $inplace->pdar_id,
                    ];

                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                    if ($result <= 0) {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "FPCDP019: Unable to pass order !");
                        log_message("error", "#FPCDP019 Failed to update p_flag in chitha_dag_pattadar for dist:" . $dist_code . ", petition no: " . $petition_no);
                        redirect(base_url() . "index.php/home");
                        return;
                    }
                    $corrected = date('Y-m-d G:i:s');
                    $t_inplace_query = "update t_chitha_col8_inplace set iscorrected_inco='Y',iscorrected_inco_date='$corrected',order_passed='Y' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                        . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                        . "vill_townprt_code='$vill_code' and dag_no='$dag_no'";
                    $this->db->query($t_inplace_query);
                    if ($this->db->affected_rows() <= 0) {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "FPTCC020: Unable to pass order !");
                        log_message("error", "#FPTCC020 Failed to update iscorrected_inco in t_chitha_col8_inplace for dist:" . $dist_code . ", petition no: " . $petition_no);
                        redirect(base_url() . "index.php/home");
                        return;
                    }

                    $order_update_query = "update field_mut_basic set order_passed='Y' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                        . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                        . "vill_townprt_code='$vill_code' and petition_no=$petition_no";
                    $this->db->query($order_update_query);
                    if ($this->db->affected_rows() <= 0) {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "FPTMB021: Unable to pass order !");
                        log_message("error", "#FPTMB021 Failed to update order_passed in field_mut_basic for dist:" . $dist_code . ", petition no: " . $petition_no);
                        redirect(base_url() . "index.php/home");
                        return;
                    }

                }
            }
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            $order_update_query = "update field_mut_basic set order_passed='Y' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                . "vill_townprt_code='$vill_code' and petition_no='$petition_no'";
            $this->db->query($order_update_query);

            //$this->session->set_flashdata('message', 'Chitha Updated Successfully. Please Update Jambandi Now. Update Old Patta First then update New Patta');
            //redirect(base_url()."index.php/home/index");

            return true;
        }
    }



    public function freshLmReport()
    {
        $db = $this->session->userdata('db');
        $case_no = $this->input->get('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
        $lot_no1 = $this->input->get('lot_no');
        $vill_townprt_code1 = $this->input->get('vill_townprt_code');

        $query = "update field_mut_basic set co_flag_for_fresh_mut='Y' where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
            . "cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code1' and lot_no='$lot_no1' and vill_townprt_code='$vill_townprt_code1' ";
        $this->db->query($query);
    }

    public function updatePattadar($cron_no)
    {

    }

    public function updateChithaForMutation()
    {

    }

    public function updateChithaForPartition()
    {

    }

    //  public function pendingmaps() {
    // $db=  $this->session->userdata('db');
    //      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //      } else {

    //          $dist_code = $this->session->userdata('dist_code');
    //          $subdiv_code = $this->session->userdata('subdiv_code');
    //          $cir_code = $this->session->userdata('cir_code');
    //          $lot_no = $this->session->userdata('lot_no');
    //          $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
    //           echo "SELECT * FROM t_chitha_col8_order WHERE map_partition is null and order_type_code='02' and "
    //            . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
    //            . " and  $this->base_query "
    //            . " order by petition_no"; 
    //          $cases = $this->db->query("SELECT * FROM t_chitha_col8_order WHERE map_partition ='N' and order_type_code='02' and "
    //                          . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and iscorrected_inco is null "
    //                          . " and  $this->base_query "
    //                          . " order by petition_no ")->result();


    //          $data['cases'] = $cases;

    //          //$this->load->view('menu/menu4');
    //         // $this->load->view('../views/comutation/pendingmaps', $data);

    //          $data['_view'] = 'comutation/pendingmaps';
    //          $this->load->view('layouts/main',$data);
    //      }
    //  }
    public function pendingmaps()
    {
        $db = $this->session->userdata('db');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        } else {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $lot_no = $this->session->userdata('lot_no');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $cases = $this->db->query("SELECT * , ba.basundhara from t_chitha_col8_order fmb left join basundhar_application ba on fmb.case_no=ba.dharitree
                    join field_mut_basic bb on fmb.case_no=bb.case_no
                 WHERE fmb.co_ord_date>='2021-09-01'  and fmb.order_type_code='02' and fmb.dist_code='$dist_code' and fmb.subdiv_code='$subdiv_code' and fmb.cir_code='$cir_code'  and fmb.iscorrected_inco is null and bb.is_dispose is null "

                . " order by fmb.petition_no ")->result();
            $data['cases'] = $cases;
            $data['_view'] = 'comutation/pendingmaps';
            $this->load->view('layouts/main', $data);
        }
    }
    /////////Modified 07/02/2022///////////
    function updatePartition_order()
    {
        $case_no = $this->input->get('case_no');
        $user_code = $this->session->userdata('user_code');
        $sql = "select * from  t_chitha_col8_order where case_no='$case_no' ";
        $d = $this->db->query($sql)->row();
        $sql = "Delete from t_chitha_col8_occup where subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code' and mouza_pargona_code='$d->mouza_pargona_code' 
            and lot_no='$d->lot_no' and vill_townprt_code='$d->vill_townprt_code' and petition_no='$d->petition_no' ";
        $this->db->query($sql);
        $sql = "Delete from  t_chitha_col8_inplace where subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code' and mouza_pargona_code='$d->mouza_pargona_code' 
            and lot_no='$d->lot_no' and vill_townprt_code='$d->vill_townprt_code' and petition_no='$d->petition_no' ";
        $this->db->query($sql);
        $sql = "delete from t_chitha_col8_order where case_no='$case_no' ";
        $this->db->query($sql);
        redirect('cofieldmutation/getPendingpartitionCases');
    }

    function DashboardData($case_no, $penUser, $rmrk)
    {
        //////////////Update Dashboard Database///////////////////////
        $this->dbb = $this->load->database('dash', TRUE);
        $base = array(
            'pending_with_user' => $penUser
        );
        $this->dbb->where('case_no', $case_no);
        $this->dbb->update('dashboard_data', $base);

        $this->db->where('case_no', $case_no);
        $this->db->update('dashboard_data', $base);


        $ip = $this->utilityclass->checkIp($this->utilityclass->get_client_ip());
        if ($ip == true)
            return;

        $action = array(
            'case_no' => $case_no,
            'user_code' => $this->session->userdata('user_code'),
            'date_of_action_taken' => date("Y-m-d h:i:s"),
            'user_designation' => $this->session->userdata('user_desig_code'),
            'remark' => $rmrk,
            'ip_address' => $this->utilityclass->get_client_ip()
        );
        $this->dbb->insert('dashboard_action', $action);
        $this->db->insert('dashboard_action', $action);
        /////////////////////////////////////
    }

    function DashboardDataFinal($case_no)
    {
        //////////////Update Dashboard Database///////////////////////
        $this->dbb = $this->load->database('dash', TRUE);
        $base = array(
            'final_order_date' => date('Y-m-d'),
            'pending_with_user' => 'NA',
            'status' => 'F',
            'remark' => 'Final Order Passed',
            'date_of_update' => date("Y-m-d h:i:s")
        );
        $this->dbb->where('case_no', $case_no);
        $this->dbb->update('dashboard_data', $base);

        $this->db->where('case_no', $case_no);
        $this->db->update('dashboard_data', $base);

        $ip = $this->utilityclass->checkIp($this->utilityclass->get_client_ip());
        if ($ip == true)
            return;

        $action = array(
            'case_no' => $case_no,
            'user_code' => $this->session->userdata('user_code'),
            'date_of_action_taken' => date("Y-m-d h:i:s"),
            'user_designation' => $this->session->userdata('user_desig_code'),
            'ip_address' => $this->utilityclass->get_client_ip(),
            'remark' => 'Final Order Passed'
        );
        $this->dbb->insert('dashboard_action', $action);
        $this->db->insert('dashboard_action', $action);
        /////////////////////////////////////
    }

    function DashboardDataReject($case_no)
    {
        $this->dbb = $this->load->database('dash', TRUE);
        $base = array(
            'final_order_date' => date('Y-m-d'),
            'pending_with_user' => 'NA',
            'status' => 'R',
            'remark' => 'Case Rejected',
            'date_of_update' => date("Y-m-d h:i:s")
        );
        $this->dbb->where('case_no', $case_no);
        $this->dbb->update('dashboard_data', $base);
        $this->db->where('case_no', $case_no);
        $this->db->update('dashboard_data', $base);

        $ip = $this->utilityclass->checkIp($this->utilityclass->get_client_ip());
        if ($ip == true)
            return;

        $action = array(
            'case_no' => $case_no,
            'user_code' => $this->session->userdata('user_code'),
            'date_of_action_taken' => date("Y-m-d h:i:s"),
            'user_designation' => $this->session->userdata('user_desig_code'),
            'remark' => 'Case Rejected',
            'ip_address' => $this->utilityclass->get_client_ip()
        );
        $this->dbb->insert('dashboard_action', $action);
        $this->db->insert('dashboard_action', $action);
    }
    //////////////New Design//////////////////////
    function basundharaUpdateArea($case_no)
    {
        $basundhara = $this->basundharamodel->checkExistBasundhar($case_no);
        if ($basundhara) {
            $sql = "Select * from field_mut_dag_details where case_no = '$case_no'";
            $fmd = $this->db->query($sql)->row_array();
            $data = array(
                'ip' => $this->utilityclass->get_client_ip(),
                'case_no' => $case_no,
                'basundhara' => $basundhara,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d H:i:s'),
                'changes_data' => json_encode($fmd),
            );
            $this->db->insert('basundhara_data_updation', $data);
        }
    }
    function updateDeedDetails($case_no)
    {
        $basundhara = $this->basundharamodel->checkExistBasundhar($case_no);
        if ($basundhara) {
            $sql = "Select * from field_mut_basic where case_no = '$case_no'";
            $fmd = $this->db->query($sql)->row_array();
            $data = array(
                'ip' => $this->utilityclass->get_client_ip(),
                'case_no' => $case_no,
                'basundhara' => $basundhara,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d H:i:s'),
                'changes_data' => json_encode($fmd),
            );
            $this->db->insert('basundhara_data_updation', $data);
        }
    }
    //////////////////////////////////////////////////
    // function onePage(){
    //     $case_no = $this->input->get('case_no');
    //     $dist_code = $this->session->userdata('dist_code');
    //     $subdiv_code = $this->session->userdata('subdiv_code');
    //     $cir_code = $this->session->userdata('cir_code');
    //     $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
    //     $lot_no1 = $this->input->get('lot_no');
    //     $vill_townprt_code1 = $this->input->get('vill_townprt_code');

    //     $sql="Select * from field_mut_basic where case_no = '$case_no'";
    //     $data['fmb']=$this->db->query($sql)->row_array();
    //     $sql="Select * from field_mut_petitioner where case_no = '$case_no'";
    //     $data['applicant']=$this->db->query($sql)->result_array();
    //     $sql="Select *,CASE
    //       WHEN striked_out='1' then 'Inplace Of'
    //       when striked_out='0' then 'Alongwith'
    //       END AS inplace from field_mut_pattadar where case_no = '$case_no'";
    //     $data['seller']=$this->db->query($sql)->result_array();
    //     $sql="Select * from field_mut_dag_details where case_no = '$case_no'";
    //     $data['fmd']=$this->db->query($sql)->result_array();
    //     $data['basuCase']=null;
    //     $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
    //     if($basundharaExist){
    //         $data['query']=null;
    //         $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
    //         $data['query']=$this->basundharamodel->QueryPost($basundharaExist);
    //         $data['sro']=$this->basundharamodel->SroPost($basundharaExist);
    //     }

    //     //$this->load->view('../views/header');
    //     // $this->load->view('../views/comutation/newpage', $data);
    //     // $this->load->view('../views/footer');

    //      $data['_view'] = 'comutation/newpage';
    //     $this->load->view('layouts/main',$data);
    // }
    function onePage()
    {
        $_GET['case_no'] = dec_param($this->input->get('case_no'), 'case_no');
        
        if ($_GET['case_no'] == null) {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }
        $case_no = $this->input->get('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
        $lot_no1 = $this->input->get('lot_no');
        $vill_townprt_code1 = $this->input->get('vill_townprt_code');
        ///////////////////////////////////
        
        $attchedCo = $this->basundharamodel->attachedCO();
        
        if ($attchedCo == 'A') {
            echo json_encode('Sorry !! You are not Authorized to pass the order as Attached CO !!');
            return;
        }
        ///////////////////////////////////
        $sql = "Select * from field_mut_basic where case_no = ?";
        $data['fmb'] = $fmb = $this->db->query($sql, $case_no)->row_array();
        $sql = "Select * from field_mut_petitioner where case_no = ?";
        $data['applicant'] = $this->db->query($sql, $case_no)->result_array();
        // var_dump($case_no);die;

        //  print_r($data['fmb']['lm_note']);
        // exit;

        if ($data['fmb']['lm_note'] == null) {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }

        if (($data['fmb']['dist_code'] != $dist_code) || ($data['fmb']['subdiv_code'] != $subdiv_code) || ($data['fmb']['cir_code'] != $cir_code) || ($data['fmb']['mouza_pargona_code'] != $mouza_pargona_code1) || ($data['fmb']['vill_townprt_code'] != $vill_townprt_code1)) {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }



        $sql = "Select *,CASE
              WHEN striked_out='1' then 'Inplace Of'
              when striked_out='0' then 'Alongwith'
              END AS inplace from field_mut_pattadar where case_no = '$case_no'";
        $data['seller'] = $this->db->query($sql)->result_array();
        $sql = "Select * from field_mut_dag_details where case_no = '$case_no'";
        $data['fmd'] = $this->db->query($sql)->result_array();
        /////////////14-03-2022/////////////////////////
        $sql = "Select remark from (
            Select remark,date_entry from field_mut_dag_details where case_no='$case_no' 
            union 
            SElect co_order as remark,date_entry from petition_proceeding  where case_no='$case_no' and user_code like 'M%' ) as t order by date_entry desc";
        $data['lm_remark'] = $this->db->query($sql)->row()->remark;
        ////////end////////
        $sql = "Select * from sro_push_history where case_no='$case_no'";
        $data['sro_history'] = $this->db->query($sql)->result_array();
        ////////////////
        $sql = "Select * from nok_tmp where case_id='$case_no'";
        $data['tempNok'] = $this->db->query($sql)->result_array();
        //var_dump($data['tempNok']);
        ////////////////
        $data['basuCase'] = null;
        $data['app'] = $rtps = null;
        $data['basuCase'] = $basundharaExist = $this->basundharamodel->checkExistBasundhar($case_no);
        if ($basundharaExist) {
            $data['sup_doc'] = $this->db->query("SELECT * FROM supportive_document WHERE case_no=?", array($case_no))->result();
            $data['query'] = null;
            $data['rtps'] = $rtps = $this->rtpsmodel->checkBasundharaService($case_no);
            if ($rtps == 'RTPS') {
                $url = RTPS_API_LINK . "serviceResponse?application_no=" . $basundharaExist;
                $data['basundharaAttachment'] = $this->rtpsmodel->searchBasundharaLink($case_no);
            } else {
                $url = API_LINK . "serviceResponse?application_no=" . $basundharaExist;
                $data['basundharaAttachment'] = $this->basundharamodel->searchBasundharaLink($case_no);
            }
            //var_dump($data['basundharaAttachment']);
            $data['query'] = $this->basundharamodel->QueryPost($basundharaExist);
            $data['sro'] = $this->basundharamodel->SroPost($basundharaExist);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            $output = curl_exec($ch);
            curl_close($ch);
            $output = json_decode($output);
            if ($output) {
                $data['apps'] = $output->application;
                $firstParty = $output->mutation;
                $engName = "N/A";
                foreach ($firstParty as $key => $value) {
                    if ($value->auth_type != null) {
                        $engName = $value->pat_name_eng;
                    }
                    continue;
                }
            }
        }
        foreach ($data['applicant'] as $key1 => $value1) {
            if ($value1['auth_type'] != null) {
                if (isset($engName) && $engName != null) {
                    $data['applicant'][$key1]['engName'] = $engName;
                }
            }
            continue;
        }


        //////////////////////////////////////////////////////////////// Property Chain Code //////////////////////////////////////////////
        // echo "<pre>";
        // var_dump($data['fmb']);
        if (ENABLED_BLOCKCHAIN == 1 && in_array($dist_code, json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))) {

            $dist_code = $fmb['dist_code'];
            $subdiv_code = $fmb['subdiv_code'];
            $cir_code = $fmb['cir_code'];
            $mouza_pargona_code = $fmb['mouza_pargona_code'];
            $lot_no = $fmb['lot_no'];
            $vill_townprt_code = $fmb['vill_townprt_code'];


            $data['propChainEnableFlag'] = $this->PropChainCommonModel->isLocationEnable($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

            foreach ($data['fmd'] as $propData) {
                // var_dump($propData['patta_no']);

                $checkPropAndChithaAndUlpn = $this->PropChainModel->chainChithaUlpinCheckProcess($propData['dist_code'], $propData['subdiv_code'], $propData['cir_code'], $propData['mouza_pargona_code'], $propData['lot_no'], $propData['vill_townprt_code'], $propData['patta_no'], $propData['dag_no'], $propData['dag_area_b'], $propData['dag_area_k'], $propData['dag_area_lc'], $propData['dag_area_g'], $propData['patta_type_code']);
            }
            // update flag in field_mut_basic only if ulpin found
            if ($checkPropAndChithaAndUlpn['ulpinCheck'] == 1 && ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'Y' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'NE')) {
                $this->PropChainModel->updateCmpFlag($case_no, $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag']);
                // if mismatch case get the view mismatch case button
                if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N') {
                    $data['viewMisMatchBtn'] = $this->PropChainModel->getMismatchBtn($case_no, $propData['dist_code'], $propData['subdiv_code'], $propData['cir_code'], $propData['mouza_pargona_code'], $propData['lot_no'], $propData['vill_townprt_code'], $propData['patta_no'], $propData['dag_no'], $propData['dag_area_b'], $propData['dag_area_k'], $propData['dag_area_lc'], $propData['dag_area_g'], $propData['patta_type_code']);
                }
            }

            $data['ulpinCheck'] = $checkPropAndChithaAndUlpn['ulpinCheck'];
            $data['ulpinMsg'] = $checkPropAndChithaAndUlpn['ulpinMsg'];

            if ($data['ulpinCheck'] == 1) {
                $data['ulpin'] = $checkPropAndChithaAndUlpn['ulpin'];
                if (isset($data['old_ulpin'])) {
                    $data['old_ulpin'] = $checkPropAndChithaAndUlpn['old_ulpin'];
                } else {
                    $data['old_ulpin'] = "";
                }
            }

            // if property does not exists get create asset button
            if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'NE') {
                $data['createPropChainBtn'] = $checkPropAndChithaAndUlpn['createPropChainBtn'];
            }
            $data['chithaPropChainCmpFlag'] = $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'];
            $data['compareFlagMsg'] = $checkPropAndChithaAndUlpn['compareFlagMsg'];
            $data['revenue'] = $checkPropAndChithaAndUlpn['revenue'];
            $data['local_tax'] = $checkPropAndChithaAndUlpn['local_tax'];
            // hidden fields
            $data['ulpin_hidden'] = $checkPropAndChithaAndUlpn['ulpin_hidden'];
            $data['uplpin_msg_hidden'] = $checkPropAndChithaAndUlpn['uplpin_msg_hidden'];
            $data['compare_hidden'] = $checkPropAndChithaAndUlpn['compare_hidden'];
            $data['compare_msg_hidden'] = $checkPropAndChithaAndUlpn['compare_msg_hidden'];

            // bhunaksha area cmp
            $data['bhuChithaCmpStatus'] = $checkPropAndChithaAndUlpn['bhuChithaCmpStatus'];
            $data['bhuChithaCmpMsg'] = $checkPropAndChithaAndUlpn['bhuChithaCmpMsg'];
            $data['bhu_hidden'] = $checkPropAndChithaAndUlpn['bhu_hidden'];
            $data['bhu_compare_msg_hidden'] = $checkPropAndChithaAndUlpn['bhu_compare_msg_hidden'];
        }

        //ESCALATED CASES REMARK ENTRY FORM==============
        if (ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE == 1 && $fmb['es_flag'] == 1 && $fmb['out_of_esc'] == 0) {
            $remainingTime = $this->Escalationmodel->calculateRemainingTime($case_no, $this->session->userdata('user_desig_code'));
            $data['remainingTime'] = $remainingTime;
            $escRemarkData = $this->Escalationmodel->getEscalationRemarkDetails($case_no, $this->session->userdata('user_desig_code'), $this->session->userdata('user_code'));
            if (isset($escRemarkData) && !empty($escRemarkData)) {
                $data['escRemarkData'] = $escRemarkData;
            }
        }
        ///END REMARKS/////////

        $basundharaExist = $this->basundharamodel->checkExistBasundhar($case_no);
        $serviceType = explode('/', $basundharaExist);
        $service_code = 1;
        $remarks = 'Field Mutation Inheritance';
        $restriction = false;
        if ($serviceType[1] == 'MUTD') {

            $service_code = 2;
            $remarks = 'Field Mutation Deed';
            $test = $dist_code . '_' . $subdiv_code . '_' . $cir_code . '_' . $mouza_pargona_code1 . '_' . $lot_no1 . '_' . $vill_townprt_code1;

            if ((in_array($dist_code, json_decode(DISTRICTS_TO_PREVENT_THE_CASE_PASS)) || in_array($test, json_decode(LOCATIONS_TO_PREVENT_THE_CASE_PASS)))) {
                $restriction = true;
            }
        }
        $data['restriction'] = $restriction;
        $params = [
            'case_no' => $case_no,
            'service_code' => $service_code,
            'remarks' => 'Field Mutation Inheritance',
            'accessed_entity' => 'Aadhaar Name',
        ];
        $this->load->model('EkycLogModel');
        $log = $this->EkycLogModel->insertEkycAccessedBy($this->db, $params);

        // $uuid = $this->utilityclass->getUuid($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code1, $lot_no1, $vill_townprt_code1);


        $data['_view'] = 'comutation/newpage';
        $this->load->view('layouts/main', $data);
    }

    // Added by Abhijit -- 2024-04-17
    public function onePage_mutd()
    {
        // if(MULTI_DAG_MUTATION_DEED_ACTIVE != 1){
        //     return $this->onePage();
        // }

        $case_no = $this->input->get('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
        $lot_no1 = $this->input->get('lot_no');
        $vill_townprt_code1 = $this->input->get('vill_townprt_code');
        ///////////////////////////////////
        $attchedCo = $this->basundharamodel->attachedCO();
        if ($attchedCo == 'A') {
            echo json_encode('Sorry !! You are not Authorized to pass the order as Attached CO !!');
            return;
        }
        ///////////////////////////////////
        $sql = "Select * from field_mut_basic where case_no = '$case_no'";
        $data['fmb'] = $fmb = $this->db->query($sql)->row_array();

        if ($fmb['is_multidag'] != 'Y') {
            $this->session->set_flashdata('message', "This service is inactive for now.");
            return redirect('/home');
        }

        $sql = "Select * from field_mut_petitioner where case_no = '$case_no'";
        $data['applicant'] = $this->db->query($sql)->result_array();
        $sql = "Select *,CASE
              WHEN striked_out='1' then 'Inplace Of'
              when striked_out='0' then 'Alongwith'
              END AS inplace from field_mut_pattadar where case_no = '$case_no'";
        $data['seller'] = $this->db->query($sql)->result_array();
        $sql = "Select * from field_mut_dag_details where case_no = '$case_no'";
        $data['fmd'] = $this->db->query($sql)->result_array();

        /////////////14-03-2022/////////////////////////
        $sql = "Select remark from (
            Select remark,date_entry from field_mut_dag_details where case_no='$case_no' 
            union 
            SElect co_order as remark,date_entry from petition_proceeding  where case_no='$case_no' and user_code like 'M%' ) as t order by date_entry desc";
        $data['lm_remark'] = $this->db->query($sql)->row()->remark;
        ////////end////////
        ////////////////
        $sql = "Select * from nok_tmp where case_id='$case_no'";
        $data['tempNok'] = $this->db->query($sql)->result_array();
        //var_dump($data['tempNok']);
        ////////////////
        $data['basuCase'] = null;
        $data['app'] = $rtps = null;
        $data['basuCase'] = $basundharaExist = $this->basundharamodel->checkExistBasundhar($case_no);
        if ($basundharaExist) {
            $data['sup_doc'] = $this->db->query("SELECT * FROM supportive_document WHERE case_no=?", array($case_no))->result();
            $data['query'] = null;
            $data['rtps'] = $rtps = $this->rtpsmodel->checkBasundharaService($case_no);
            if ($rtps == 'RTPS') {
                $url = RTPS_API_LINK . "serviceResponseMultiGen?application_no=" . $basundharaExist;
                $data['basundharaAttachment'] = $this->rtpsmodel->searchBasundharaLink($case_no);
            } else {
                $url = API_LINK . "serviceResponseMultiGen?application_no=" . $basundharaExist;
                $data['basundharaAttachment'] = $this->basundharamodel->searchBasundharaLink($case_no);
            }
            //var_dump($data['basundharaAttachment']);
            $data['query'] = $this->basundharamodel->QueryPost($basundharaExist);
            $data['sro'] = $this->basundharamodel->SroPost($basundharaExist);

            $output = sendCurlRequest($url);
            $output = json_decode($output);

            if ($output) {
                $data['apps'] = $output->application;
                $firstParty = $output->mutation;
                $engName = "N/A";
                foreach ($firstParty as $key => $value) {
                    if ($value->auth_type != null) {
                        $engName = $value->pat_name_eng;
                    }
                    continue;
                }
            }
        }
        foreach ($data['applicant'] as $key1 => $value1) {
            if ($value1['auth_type'] != null) {
                if (isset($engName) && $engName != null) {
                    $data['applicant'][$key1]['engName'] = $engName;
                }
            }
            continue;
        }


        //////////////////////////////////////////////////////////////// Property Chain Code //////////////////////////////////////////////
        // echo "<pre>";
        // var_dump($data['fmb']);
        if (ENABLED_BLOCKCHAIN == 1 && in_array($dist_code, json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))) {

            $dist_code = $fmb['dist_code'];
            $subdiv_code = $fmb['subdiv_code'];
            $cir_code = $fmb['cir_code'];
            $mouza_pargona_code = $fmb['mouza_pargona_code'];
            $lot_no = $fmb['lot_no'];
            $vill_townprt_code = $fmb['vill_townprt_code'];


            $data['propChainEnableFlag'] = $this->PropChainCommonModel->isLocationEnable($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

            foreach ($data['fmd'] as $propData) {
                // var_dump($propData['patta_no']);

                $checkPropAndChithaAndUlpn = $this->PropChainModel->chainChithaUlpinCheckProcess($propData['dist_code'], $propData['subdiv_code'], $propData['cir_code'], $propData['mouza_pargona_code'], $propData['lot_no'], $propData['vill_townprt_code'], $propData['patta_no'], $propData['dag_no'], $propData['dag_area_b'], $propData['dag_area_k'], $propData['dag_area_lc'], $propData['dag_area_g'], $propData['patta_type_code']);
            }
            // update flag in field_mut_basic only if ulpin found
            if ($checkPropAndChithaAndUlpn['ulpinCheck'] == 1 && ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'Y' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'NE')) {
                $this->PropChainModel->updateCmpFlag($case_no, $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag']);
                // if mismatch case get the view mismatch case button
                if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N') {
                    $data['viewMisMatchBtn'] = $this->PropChainModel->getMismatchBtn($case_no, $propData['dist_code'], $propData['subdiv_code'], $propData['cir_code'], $propData['mouza_pargona_code'], $propData['lot_no'], $propData['vill_townprt_code'], $propData['patta_no'], $propData['dag_no'], $propData['dag_area_b'], $propData['dag_area_k'], $propData['dag_area_lc'], $propData['dag_area_g'], $propData['patta_type_code']);
                }
            }

            $data['ulpinCheck'] = $checkPropAndChithaAndUlpn['ulpinCheck'];
            $data['ulpinMsg'] = $checkPropAndChithaAndUlpn['ulpinMsg'];

            if ($data['ulpinCheck'] == 1) {
                $data['ulpin'] = $checkPropAndChithaAndUlpn['ulpin'];
                if (isset($data['old_ulpin'])) {
                    $data['old_ulpin'] = $checkPropAndChithaAndUlpn['old_ulpin'];
                } else {
                    $data['old_ulpin'] = "";
                }
            }

            // if property does not exists get create asset button
            if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'NE') {
                $data['createPropChainBtn'] = $checkPropAndChithaAndUlpn['createPropChainBtn'];
            }
            $data['chithaPropChainCmpFlag'] = $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'];
            $data['compareFlagMsg'] = $checkPropAndChithaAndUlpn['compareFlagMsg'];
            $data['revenue'] = $checkPropAndChithaAndUlpn['revenue'];
            $data['local_tax'] = $checkPropAndChithaAndUlpn['local_tax'];
            // hidden fields
            $data['ulpin_hidden'] = $checkPropAndChithaAndUlpn['ulpin_hidden'];
            $data['uplpin_msg_hidden'] = $checkPropAndChithaAndUlpn['uplpin_msg_hidden'];
            $data['compare_hidden'] = $checkPropAndChithaAndUlpn['compare_hidden'];
            $data['compare_msg_hidden'] = $checkPropAndChithaAndUlpn['compare_msg_hidden'];

            // bhunaksha area cmp
            $data['bhuChithaCmpStatus'] = $checkPropAndChithaAndUlpn['bhuChithaCmpStatus'];
            $data['bhuChithaCmpMsg'] = $checkPropAndChithaAndUlpn['bhuChithaCmpMsg'];
            $data['bhu_hidden'] = $checkPropAndChithaAndUlpn['bhu_hidden'];
            $data['bhu_compare_msg_hidden'] = $checkPropAndChithaAndUlpn['bhu_compare_msg_hidden'];
        }


        $data['_view'] = 'comutation/multidag-newpage';
        $this->load->view('layouts/main', $data);
    }

    ///////////////////////////////////////
    ///////////////////////////////////////
    function revertback()
    {
        $_GET['case_no'] = dec_param($this->input->get('case_no'), 'case_no');
        if ($_GET['case_no'] == null) {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }
        $case_no = $this->input->get('case_no');
        //escalation implementation================
        $es_flag_data = $this->db->query("select es_flag,out_of_esc from  field_mut_basic where "
            . " case_no='$case_no'")->row();
        $flag = false;
        $remaining_days_CO = '';
        if ($es_flag_data->es_flag == 1 && ESCALATION_ENABLE == 1 && $es_flag_data->out_of_esc == 0) {
            //remaining Days of LM ============
            $escalatedRowDetailsAgainstPetitionno = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($case_no);
            if (empty($escalatedRowDetailsAgainstPetitionno) || $escalatedRowDetailsAgainstPetitionno == null) {
                log_message("error", "#ESC3641, transaction-error in method 'COFieldMutation/revertback' with case-no :" . $case_no);
                $this->session->set_flashdata('message', "Something went wrong.FMUT- Error Code(#ESC3641)");
                redirect(base_url() . "index.php/home");
            }
            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
            $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
            $remaining_days_LM = $this->Escalationmodel->getRemainingDays($previousCompletedDaysLM, $originalAllocation);

            //remaining days of CO==============
            $originalAllocationCO = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            $remaining_days_CO = $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO, $originalAllocationCO);
            if ($remaining_days_LM == 0) {
                $flag = true;
            } else {
                $flag = false;
            }
        }
        $data['es_flag'] = $es_flag_data->es_flag;
        $data['out_of_esc'] = $es_flag_data->out_of_esc;
        $data['flag'] = $flag;
        $data['remainingDaysCO'] = $remaining_days_CO;



        $data['_view'] = 'comutation/revertback';
        $this->load->view('layouts/main', $data);
    }
    function revertBackLS()
    {
        //xss & security validation starts
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST);
        if ($resp['status'] == 'n') {
            $errorMessageStr .= $resp['messages'];
        }

        $resp = checkRequestValidQuery($_POST);
        if ($resp['status'] == 'n') {
            $errorMessageStr .= $resp['messages'];
        }
        if ($errorMessageStr != '') {
            $this->session->set_flashdata('message', $errorMessageStr);
            return redirect($_SERVER['HTTP_REFERER']);
        }
        //xss & security validation ends
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        /////////////
        $rmk = addslashes(trim($_POST['co_order']));
        $coname = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $user_code);
        $rmk = $rmk . "  চক্র বিষয়া : " . $coname->username;
        $case_no = $_POST['case_no'];
        $revert_back = $_POST['revert_back'];
        if ($revert_back == 'L') {
            $update = array(
                'is_dispose' => 'L',
            );
            $pen = "LM";
        } else if ($revert_back == 'S') {
            $update = array(
                'is_dispose' => 'S',
                'sk_note' => null,
                'sk_note_date' => null,
                'sk_flag' => null,
                'sk_id' => null
            );
            $pen = "SK";
        }
        $basundharaExist = $this->basundharamodel->checkExistBasundhar($case_no);
        if ($basundharaExist) {
            $this->basundharamodel->insertproceeding($case_no, $rmk);
            $this->db->where('case_no', $case_no);
            $this->db->update('field_mut_basic', $update);

            //ESCALATION CODE INTEGRATION================SANMRI

            $query1 = $this->db->query("SELECT es_flag,mouza_pargona_code,lot_no,out_of_esc FROM field_mut_basic WHERE case_no=?", array($case_no))->row();
            $user_code = $this->session->userdata('user_code');
            $executionDate = $this->input->post('executionDate');
            if ($query1->es_flag == 1 && ESCALATION_ENABLE == 1 && $query1->out_of_esc == 0) {
                $allocation_days = null;
                if ($this->input->post('allocate_day') != null) {
                    $allocation_days = $this->input->post('allocate_day');
                }
                $serviceType = explode('/', $basundharaExist);
                $service_code = 1;
                if ($serviceType[1] == 'MUTD') {
                    $service_code = 2;
                }
                $escalationUpdateStatus = $this->Escalationmodel->escalationCORevertToLM($service_code, $executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code, $query1->mouza_pargona_code, $query1->lot_no, $allocation_days);
                log_message("error", "#ESC3721, transaction-error-STATUS======" . json_encode($escalationUpdateStatus));

                if ($escalationUpdateStatus['responseType'] == 0) {

                    log_message("error", "#ESC3721, transaction-error in method 'COFieldMutation/revertBackLS' with case-no :" . $case_no);
                    $this->session->set_flashdata('message', "Something went wrong.FMUT- Error Code(#ESC3721)");
                    redirect(base_url() . "index.php/home");
                }
            }



            //////////////POST To basundhara/////////////////////
            $application_no = $basundharaExist;
            $rmk = 'Reverted back to ' . $pen;
            $status = 'M';
            $task = 'CO';
            $case = $case_no;
            $this->basundharamodel->postApiBasundhara($application_no, $case, $rmk, $status, $task, $pen);
            //////////////////

            $this->DashboardData($case_no, $pen, $rmk);
        }
        $this->session->set_flashdata('message', "Case have been Reverted");
        redirect('/home');
    }
    //////////////////////////////
    function nokApprove()
    {
        $success = null;
        $request = $_POST['co_status'];

        $redirect_url = base_url() . 'index.php/cofieldmutation/getPendingFMCases';
        $case_no = $_POST['case_no'];
        $field_mut_basic = $this->db->where('case_no', $case_no)->get('field_mut_basic')->row();
        if ($request == '1') {
            ////////Approve//////////
            $co_code = $this->session->userdata('user_code');
            $co_approve_date = date('Y-m-d H:i:s');
            $sql = "Update nok_tmp set co_code='$co_code', co_approve_date='$co_approve_date',approve_reject=1 where case_id='$case_no' ";
            $this->db->query($sql);
            $success = "NOK Application Approved. Please wait for 7 days for Objection rasied by the Applicant";
            $basundharaExist = $this->basundharamodel->checkExistBasundhar($case_no);
            if ($basundharaExist) {
                $sql = "Select * from nok_tmp where case_id='$case_no' and approve_reject=1 ";
                //$sql="Select * from nok_tmp where case_id='$case_no'  ";
                $pushData = $this->db->query($sql)->result_array();
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, API_LINK . "postNok");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, json_encode(array(
                    'data' => $pushData,
                    'basundhara' => $basundharaExist
                )));
                $data = curl_exec($curl_handle);
                //return json_decode($data);
            }

        } else if ($request == '0') {
            /////////Revert to LM/////////////
            $sql = "Update field_mut_basic set is_dispose='L' where case_no='$case_no' ";
            $this->db->query($sql);
            $success = "NOK Application Revert back to LM. ";
            $redirect_url = base_url() . "index.php/COFieldMutation/revertback?case_no=" . $case_no . "&dist_code=" . $field_mut_basic->dist_code . "&subdiv_code=" . $field_mut_basic->subdiv_code . "&cir_code=" . $field_mut_basic->cir_code . "&mouza_pargona_code=" . $field_mut_basic->mouza_pargona_code . "&lot_no=" . $field_mut_basic->lot_no . "&vill_townprt_code=" . $field_mut_basic->vill_townprt_code;
        } else if ($request == '2') {
            ///////Cancel/////////
            $sql = "Update nok_tmp set co_code='$co_code', co_approve_date='$co_approve_date',approve_reject='2' where case_id='$case_no' ";
            $this->db->query($sql);
            $success = "NOK Application Rejected. ";
        }
        if ($success) {
            $data = array(
                'success' => $success,
                'redirect_url' => $redirect_url
                // 'redirect_url'=>base_url().'index.php/cofieldmutation/getPendingFMCases'
            );
        } else {
            $data = array(
                'error' => "Error in submitting. Please try Again"
            );
        }
        echo json_encode($data);
    }


    ////////////START MPR:///////////////

    /* This is for passing field mutation case final button submission for basundhara cases */
    function passOrderNew()
    {

        //xss & security validation starts
        $user_desig_code = $this->session->userdata('user_desig_code');
        $allowed = array('CO');
        if (!in_array($user_desig_code, $allowed)) {
            echo "USER-NOT-AUTHORISED";
            die; // Valid
        }
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST);
        if ($resp['status'] == 'n') {
            $errorMessageStr .= $resp['messages'];
        }
        $resp = checkRequestValidQuery($_POST);
        if ($resp['status'] == 'n') {
            $errorMessageStr .= $resp['messages'];
        }
        if ($errorMessageStr != '') {
            $this->session->set_flashdata('message_extra', $errorMessageStr);
            return redirect($_SERVER['HTTP_REFERER']);
        }
        //xss & security validation ends 
        $case_no = $this->input->post('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $this->AgriStackCaseHistory->CreateLogFile($dist_code, $case_no);
        $original_inhabitants = $this->input->post('original_inhabitants') ?? null;
        $is_passable = $this->utilityclass->isTheCasePassable($case_no, 'FMUT', $original_inhabitants);
        // var_dump($is_passable);die;
        if (!$is_passable['success']) {
            $this->session->set_flashdata('message_extra', $is_passable['message']);
            return redirect($_SERVER['HTTP_REFERER']);
        }


        $caseInfoEsc = $this->db->query("SELECT * FROM field_mut_basic WHERE case_no=?", array($case_no))->row();

        $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if (!in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        if (($caseInfoEsc->dist_code != $this->session->userdata('dist_code')) || ($caseInfoEsc->subdiv_code != $this->session->userdata('subdiv_code')) || ($caseInfoEsc->cir_code != $this->session->userdata('cir_code'))) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        if ($caseInfoEsc->lm_note == null) {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }


        if ($caseInfoEsc->es_flag == 1 && ESCALATION_ENABLE == 1) {
            $executionDate = date('Y-m-d- H-i-s');
            $user_code = $this->session->userdata('user_code');
            $user_desig_code = $this->session->userdata('user_desig_code');
            $escalationUpdateTimeFrame = $this->Escalationmodel->escalationUpdateTimeFrame(
                $executionDate,
                $dist_code,
                $case_no,
                $user_code,
                $user_desig_code,
                'FMUT'
            );
            log_message("error", "#ESC4048, transaction-error-STATUS======" . json_encode($escalationUpdateTimeFrame));
            if ($escalationUpdateTimeFrame['responseType'] == 1) {
                log_message("error", "#ESC4051, transaction-error in method 'cofieldmutation/passOrderNew' with case-no :" . $case_no);
                $this->session->set_flashdata('message', "Something went wrong.ACPP- Error Code(#ESC4051)");
                redirect(base_url() . "index.php/home");
                return;
            }
            ////////////////////END////////////////////////////
        }


        $this->db->trans_begin();
        //added for multigeneration----------
        if (MULTIGENERATION_ACTIVE == 1) {
            $checkMultigen = "Select is_multigeneration from field_mut_basic where case_no = ?";
            $multigenFlag = $this->db->query($checkMultigen, array($case_no))->row()->is_multigeneration;

            if ($multigenFlag == 'S' || $multigenFlag == 'M') {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERRORMULTIGEN3784 : Pass order not allowed...");
                redirect(base_url() . "index.php/home");
            }
        }
        //end--------



        //==========check dag pending in blockchain or not=================
        if (ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'), json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))) {
            $this->load->model('TransactionModel');
            $this->load->model('propChain/PropChainCommonModel');
            $dag_details = $this->TransactionModel->find_all_against_id('field_mut_dag_details', 'case_no', $case_no);
            foreach ($dag_details as $key => $value) {
                $checkVal = $this->PropChainCommonModel->checkDagExistsInPropChainInPending($value->dist_code, $value->subdiv_code, $value->cir_code, $value->mouza_pargona_code, $value->lot_no, $value->vill_townprt_code, $value->dag_no);
                if ($checkVal === false) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "#ERRORBLOCCHAIN3731 : You cannot procced as dag no is pending for property chain update...");
                    redirect(base_url() . "index.php/home");
                }
            }

        }
        ///=============end CODE=====================




        $sql = "Select * from field_mut_dag_details where case_no = '$case_no'";
        $fmd = $this->db->query($sql)->result_array();


        foreach ($_POST['pattadar_id'] as $key => $val) {
            $inplace = $_POST['inplace_alongwith'][$key];
            if ($inplace == '5555') {
                $this->db->trans_rollback();
                log_message('error', '#ERRFMINPLACEALONGWITH : Inplace-Alongwith Not Selected against the Second party');
                $this->session->set_flashdata('message', "#ERRFMINPLACEALONGWITH : Inplace-Alongwith Not Selected against the Second party");
                redirect(base_url() . "index.php/home");

            }



            $sql = "Update field_mut_pattadar set striked_out='$inplace' where pdar_id='$val' and case_no='$case_no' ";
            $this->db->query($sql);

            if ($this->db->affected_rows() <= 0) {
                log_message('error', 'VALIDATION-ERROR-MUTATION#0002');
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Could not update pattadar status. Error Code(#FMP001)");
                redirect(base_url() . "index.php/home");
                return;
            }
        }

        $this->basundharaUpdateArea($case_no);
        $applied_b = $this->input->post('applied_b');
        $applied_k = $this->input->post('applied_k');
        $applied_lc = $this->input->post('applied_lc');
        $applied_g = $this->input->post('applied_g') == null ? "0" : $this->input->post('applied_g');
        $applied_kr = $this->input->post('applied_kr') == null ? "0" : $this->input->post('applied_kr');
        $transcode = $this->input->post('trans_code');

        if (in_array($transcode, ['11', '01', '02'])) {
            $applied_b = $applied_k = $applied_lc = $applied_g = $applied_kr = 0;
        }

        $sql = "Update field_mut_dag_details set m_dag_area_b='$applied_b', m_dag_area_k='$applied_k' , m_dag_area_lc='$applied_lc',m_dag_area_g='$applied_g' where case_no = '$case_no' ";
        $this->db->query($sql);
        if ($this->db->affected_rows() <= 0) {
            log_message('error', 'VALIDATION-ERROR-MUTATION#0003');
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "Could not update area details. Error Code(#FMDD001)");
            redirect(base_url() . "index.php/home");
            return;
        }


        if ($transcode == '03') {
            $reg_deed_no = $this->input->post('reg_deed_no');
            $is_valid_deed_no = isValidDeedNo($reg_deed_no);
            if (!$is_valid_deed_no['success']) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', $is_valid_deed_no['message']);
                redirect(base_url() . "index.php/home");
                return;
            }

            $reg_deed_date = $this->input->post('reg_deed_date');
            $deed_value = $this->input->post('deed_value');
            $this->updateDeedDetails($case_no);
            $sql = "Update field_mut_basic set reg_deed_no='$reg_deed_no', deed_value='$deed_value' , reg_deed_date='$reg_deed_date' where case_no = '$case_no' ";
            $this->db->query($sql);
            if ($this->db->affected_rows() <= 0) {
                log_message('error', 'VALIDATION-ERROR-MUTATION#0004');
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Could not update deed details. Error Code(#FMB001)");
                redirect(base_url() . "index.php/home");
                return;
            }

            $sql2 = "Update field_mut_dag_details set deed_reg_no='$reg_deed_no', deed_value='$deed_value' , deed_date='$reg_deed_date' where case_no = '$case_no' ";
            $this->db->query($sql2);
            if ($this->db->affected_rows() <= 0) {
                log_message('error', 'VALIDATION-ERROR-MUTATION#0005');
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Could not update deed details. Error Code(#FMB00012)");
                redirect(base_url() . "index.php/home");
                return;
            }
        }
        ////////////////////

        $sql_mut_basic = "Select * from field_mut_basic where case_no = '$case_no'";

        $sql = "Select * from nok_tmp where case_id='$case_no' and approve_reject=1 ";
        $approce_nok = $this->db->query($sql)->result();

        if ($approce_nok) {

            $sql = "Select * from field_mut_petitioner where case_no='$case_no' order by pet_id desc  ";
            $already_insert = $this->db->query($sql)->row();
            if ($already_insert == '' || $already_insert == null) {
                $already_insert = $this->db->query($sql_mut_basic)->row();
                $pid = 1;
            } else {
                $pid = $already_insert->pet_id + 1;
            }

            foreach ($approce_nok as $apnok) {
                $buyerInsert = array(
                    'dist_code' => $already_insert->dist_code,
                    'subdiv_code' => $already_insert->subdiv_code,
                    'cir_code' => $already_insert->cir_code,
                    'mouza_pargona_code' => $already_insert->mouza_pargona_code,
                    'lot_no' => $already_insert->lot_no,
                    'vill_townprt_code' => $already_insert->vill_townprt_code,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d'),
                    'case_no' => $case_no,
                    'petition_no' => $already_insert->petition_no,
                    'year_no' => $already_insert->year_no,
                    'operation' => 'E',
                    'pet_name' => $apnok->name_asm,
                    'guard_name' => $apnok->guardian_name_asm,
                    'guard_rel' => $apnok->relation,/////////////
                    'pet_gender' => $apnok->gender,
                    //'add1' => $pet->address,
                    'add1' => $apnok->address,
                    'pet_id' => $pid++,
                    'new_pet_name' => 'N'
                );
                //var_dump($buyerInsert);
                $nokstatus = $this->db->insert('field_mut_petitioner', $buyerInsert);
                if ($nokstatus != 1) {
                    log_message('error', 'VALIDATION-ERROR-MUTATION#0006');
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "New NOK Could not be added. Error Code(#FNOK001)");
                    redirect(base_url() . "index.php/home");
                }
                $update = "Update nok_tmp set approve_reject=2 where case_id='$case_no' and serial_id=$apnok->serial_id ";
                $this->db->query($update);
                //echo $this->db->last_query();
            }
        }
        //////////////////////////////////
        if (isset($_FILES['fileUpload']['name'])) {
            $this->form_validation->set_rules('fileText[]', 'Document Details', 'trim|xss_clean|required');
            $fileCount = count($_FILES['fileUpload']['name']);
            // validation for file type and file size
            for ($i = 0; $i < $fileCount; $i++) {
                if ($_FILES['fileUpload']['name'][$i] && $_FILES['fileUpload']['size'][$i] && $_FILES['fileUpload']['tmp_name'][$i]) {
                    $name = $_FILES['fileUpload']['name'][$i];
                    $size = $_FILES['fileUpload']['size'][$i];
                    $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                    $exp = explode("/", $mime);
                    $ext = $exp[1];
                    if ($name != NULL) {
                        if ($ext == NULL) {
                            // todo error show extension missing
                            log_message('error', 'VALIDATION-ERROR-MUTATION#0007');
                            $this->session->set_flashdata('message', "File Not Supported. Error Code(#FAPL001)");
                            redirect(base_url() . "index.php/home");
                        }
                        if (!in_array($ext, UPLOAD_TYPE_VALIDATION)) {
                            // todo error show file allow type not match
                            log_message('error', 'VALIDATION-ERROR-MUTATION#0008');
                            $this->session->set_flashdata('message', "File Not Supported (ONLY JPG/PNG/PDF). Error Code(#FAPL002)");
                            redirect(base_url() . "index.php/home");
                        }
                        if ($size > UPLOAD_MAX_SIZE) {
                            log_message('error', 'VALIDATION-ERROR-MUTATION#0009');
                            $this->session->set_flashdata('message', "Maximum 2MB file size. Error Code(#FAPL003)");
                            redirect(base_url() . "index.php/home");
                        }
                    } else {
                        log_message('error', 'VALIDATION-ERROR-MUTATION#00010');
                        $this->session->set_flashdata('message', "File name cann't be empty. Error Code(#FAPL004)");
                        redirect(base_url() . "index.php/home");
                    }
                } else {
                    log_message('error', 'VALIDATION-ERROR-MUTATION#0011');
                    $this->session->set_flashdata('message', "File is required. Error Code(#FAPL005)");
                    redirect(base_url() . "index.php/home");
                }
            }
        }
        ///////////////////Insert attached file////////////////////////
        if (isset($_FILES['fileUpload']['name'])) {
            for ($i = 0; $i < $fileCount; $i++) {
                $_FILES['file']['name'] = $_FILES['fileUpload']['name'][$i];
                $_FILES['file']['type'] = $_FILES['fileUpload']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['fileUpload']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['fileUpload']['error'][$i];
                $_FILES['file']['size'] = $_FILES['fileUpload']['size'][$i];
                $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                $exp = explode("/", $mime);
                $onlyExtension = $exp[1];
                $replaceCase = str_replace("/", "-", $case_no);
                $fileRename = $replaceCase . "-" . time() . '.' . $onlyExtension;
                $config['upload_path'] = MANUAL_ATTACHMENT;
                $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                $config['max_size'] = UPLOAD_MAX_SIZE;
                ;
                $config['file_name'] = $fileRename;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('file')) {
                    $document = array(
                        'case_no' => $case_no,
                        'file_name' => $_POST['fileText'][$i],
                        'user_code' => $this->session->userdata('user_code'),
                        // 'fetch_file_name' => $_FILES['file']['name'],
                        'fetch_file_name' => $_POST['fileText'][$i],
                        'file_type' => $_FILES['file']['type'],
                        'file_path' => MANUAL_ATTACHMENT . $fileRename,
                        'date_entry' => date('Y-m-d h:i:s'),
                        'mut_type' => 'FM',
                    );
                    // save data in attachment file
                    $addMoreDocQuery = $this->db->insert('supportive_document', $document);
                    if ($addMoreDocQuery != 1) {
                        log_message('error', 'VALIDATION-ERROR-MUTATION#0012');
                        $this->db->trans_rollback();
                        log_message('error', '#ERRADDDOC0001: Insertion failed in supportive document RTPS Case No ' . $case_no);
                        $this->session->set_flashdata('error_data', "#ERRADDDOC0001: Registration of Settlement failed for case no : " . $case_no);
                        redirect(base_url() . "index.php/home");
                        return false;
                    }
                } else {
                    $this->db->trans_rollback();
                    // todo error show
                    // redirect to respected route with error mgs
                    log_message('error', '#ERRADDDOC0001: Insertion failed in supportive document RTPS Case No ' . $case_no);
                    $this->session->set_flashdata('error_data', "#ERRADDDOC0001: Registration of Settlement failed for case no : " . $case_no);
                    redirect(base_url() . "index.php/home");
                    return false;
                }
            }
        }
        //////////////////////////////////////////
        try {
            // $this->db->trans_begin();
            // $sql="Select * from field_mut_basic where case_no = '$case_no'";
            // $fmb=$this->db->query($sql)->row_array();
            $fmb = $this->db->query($sql_mut_basic)->row_array();
            $sql = "Select * from field_mut_dag_details where case_no = '$case_no'";
            $fmd = $this->db->query($sql)->result_array();
            foreach ($fmd as $dag) {
                $dag_no[] = array("dag_no" => $dag['dag_no'], "petition_no" => $dag['petition_no'], "case_no" => $dag['case_no']);
                $patta_type_code = $dag['patta_type_code'];
                $patta_no = $dag['patta_no'];
                //////////Max Pattadar ID/////////////////
                $pattadars_in_chitha_pattadar = $this->db->query("select max(pdar_id::int)+1 as cp from chitha_pattadar where dist_code='$fmb[dist_code]' and "
                    . " subdiv_code='$fmb[subdiv_code]' and cir_code='$fmb[cir_code]' and mouza_pargona_code='$fmb[mouza_pargona_code]' and"
                    . " lot_no='$fmb[lot_no]' and vill_townprt_code='$fmb[vill_townprt_code]' and patta_type_code='$patta_type_code' and TRIM(patta_no)=trim('$dag[patta_no]')")->row()->cp;

                $pattadars_in_jama_pattadar = $this->db->query("select max(pdar_id::int)+1 as jp from jama_pattadar where dist_code='$fmb[dist_code]' and "
                    . " subdiv_code='$fmb[subdiv_code]' and cir_code='$fmb[cir_code]' and mouza_pargona_code='$fmb[mouza_pargona_code]' and"
                    . " lot_no='$fmb[lot_no]' and vill_townprt_code='$fmb[vill_townprt_code]' and patta_type_code='$patta_type_code' and TRIM(patta_no)=trim('$dag[patta_no]')")->row()->jp;
                $pattadars_in_chithaDag_pattadar = $this->db->query("select max(pdar_id::int)+1 as dp from chitha_dag_pattadar where dist_code='$fmb[dist_code]' and "
                    . " subdiv_code='$fmb[subdiv_code]' and cir_code='$fmb[cir_code]' and mouza_pargona_code='$fmb[mouza_pargona_code]' and"
                    . " lot_no='$fmb[lot_no]' and vill_townprt_code='$fmb[vill_townprt_code]' and patta_type_code='$patta_type_code' and TRIM(patta_no)=trim('$dag[patta_no]') and dag_no='$dag[dag_no]'")->row()->dp;
                if ($pattadars_in_chitha_pattadar > $pattadars_in_jama_pattadar) {
                    if ($pattadars_in_chithaDag_pattadar > $pattadars_in_chitha_pattadar) {
                        $pdar_id = $pattadars_in_chithaDag_pattadar;
                    } else {
                        $pdar_id = $pattadars_in_chitha_pattadar;
                    }
                } elseif ($pattadars_in_chithaDag_pattadar > $pattadars_in_jama_pattadar) {
                    $pdar_id = $pattadars_in_chithaDag_pattadar;
                } else {
                    $pdar_id = $pattadars_in_jama_pattadar;
                }
                if ($pdar_id === null) {
                    $pdar_id = 1;
                }
                ///////////////////////////
                $tchithacol8order = array(
                    'dist_code' => $fmb['dist_code'],
                    'subdiv_code' => $fmb['subdiv_code'],
                    'cir_code' => $fmb['cir_code'],
                    'mouza_pargona_code' => $fmb['mouza_pargona_code'],
                    'lot_no' => $fmb['lot_no'],
                    'vill_townprt_code' => $fmb['vill_townprt_code'],
                    'dag_no' => $dag['dag_no'],
                    'year_no' => date('Y'),
                    'petition_no' => $fmb['petition_no'],
                    'order_pass_yn' => 'y',
                    'order_type_code' => $fmb['mut_type'],
                    'nature_trans_code' => $fmb['trans_code'],
                    'lm_code' => $fmb['user_code'],
                    'lm_sign_yn' => 'y',
                    'lm_note_date' => $fmb['date_entry'],
                    'co_code' => $this->session->userdata('user_code'),
                    'co_sign_yn' => 'y',
                    'co_ord_date' => date('Y-m-d'),
                    'date_of_order' => date('Y-m-d'),
                    'mut_land_area_b' => $dag['m_dag_area_b'],
                    'mut_land_area_k' => $dag['m_dag_area_k'],
                    'mut_land_area_lc' => $dag['m_dag_area_lc'],
                    'mut_land_area_g' => $dag['m_dag_area_g'],
                    'mut_land_area_kr' => $dag['m_dag_area_kr'],
                    'land_area_left_b' => 0,
                    'land_area_left_k' => 0,
                    'land_area_left_lc' => 0,
                    'land_area_left_g' => 0,
                    'land_area_left_kr' => 0,
                    'rajah_adalat' => $fmb['rajah_adalat'],
                    'deed_reg_no' => $fmb['reg_deed_no'],
                    'deed_value' => $fmb['deed_value'],
                    'deed_date' => $fmb['reg_deed_date'],
                    'sk_code' => $fmb['sk_id'],
                    'sk_sign_yn' => $fmb['sk_id'] != null ? 'y' : '',
                    'sk_note_date' => $fmb['sk_note_date'],
                    'case_no' => $fmb['case_no'],
                    'min_revenue' => '15.00',
                    'noc_no' => $fmb['noc_no'],
                    'noc_date' => $fmb['noc_date'],
                );
                //var_dump($tchithacol8order);
                $tstatus1 = $this->db->insert('t_chitha_col8_order', $tchithacol8order);
                if ($tstatus1 != 1) {
                    log_message('error', 'VALIDATION-ERROR-MUTATION#0013');
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Order for Case No $case_no Not Successfull. Error Code(#F001)");
                    redirect(base_url() . "index.php/home");
                }
                //////////End t chitha/////////////
                $i = 1;
                $sql = "Select * from field_mut_petitioner where case_no = '$case_no'";

                if ($this->db->query($sql)->num_rows() == 0) {
                    log_message('error', 'VALIDATION-ERROR-MUTATION#0013');
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "First party information not found. Error Code(#FAPL001)");
                    redirect(base_url() . "index.php/home");
                }

                $applicant = $this->db->query($sql)->result_array();
                foreach ($applicant as $fmp) {
                    $dec = null;
                    if (isset($fmp['self_declaration']) && $fmp['self_declaration'] != null) {
                        $dec = $fmp['self_declaration'];
                    }
                    if ($fmp['auth_type'] != null) {
                        //if($fmp['auth_type']=='AADHAAR' && $fmp['photo'] == null){
                        //    $this->db->trans_rollback();
                        //    log_message('error', '#ERRFMUTI005:Aadhaar Photo fetching error');
                        //    redirect(base_url() . "index.php/home");
                        //}
                        $auth_type = $fmp['auth_type'];
                        $id_ref_no = $fmp['id_ref_no'];
                        $photo = null;
                    } else {
                        $auth_type = null;
                        $id_ref_no = null;
                        $photo = null;
                    }
                    $tchithacol8occ = array(
                        'dist_code' => $fmb['dist_code'],
                        'subdiv_code' => $fmb['subdiv_code'],
                        'cir_code' => $fmb['cir_code'],
                        'mouza_pargona_code' => $fmb['mouza_pargona_code'],
                        'lot_no' => $fmb['lot_no'],
                        'vill_townprt_code' => $fmb['vill_townprt_code'],
                        'dag_no' => $dag['dag_no'],
                        'year_no' => date('Y'),
                        'petition_no' => $fmb['petition_no'],
                        'occupant_id' => $i++,
                        'patta_type_code' => $dag['patta_type_code'],
                        'patta_no' => $dag['patta_no'],
                        'pdar_id' => $fmp['pdar_id'] == null ? $pdar_id++ : $fmp['pdar_id'],
                        'occupant_name' => $fmp['pet_name'],
                        'occupant_fmh_name' => $fmp['guard_name'],
                        'occupant_fmh_flag' => $fmp['guard_rel'],
                        'occupant_add1' => $fmp['add1'],
                        'occupant_add2' => $fmp['add2'],
                        'land_area_b' => $dag['m_dag_area_b'] == null ? 0 : $dag['m_dag_area_b'],
                        'land_area_k' => $dag['m_dag_area_k'] == null ? 0 : $dag['m_dag_area_k'],
                        'land_area_lc' => $dag['m_dag_area_lc'] == null ? 0 : $dag['m_dag_area_lc'],
                        'land_area_g' => $dag['m_dag_area_g'] == null ? 0 : $dag['m_dag_area_g'],
                        'land_area_kr' => $dag['m_dag_area_kr'] == null ? 0 : $dag['m_dag_area_kr'],
                        'order_passed' => 'y',
                        'new_pattadar' => $fmp['new_pet_name'],
                        'hus_wife' => $fmp['hus_wife'],
                        'occup_gender' => $fmp['pet_gender'],
                        'occup_minor_yn' => $fmp['pet_minor_yn'],
                        'occup_minor_dob' => $fmp['pet_minor_dob'],
                        'occup_mother' => $fmp['pet_mother'],
                        'self_declaration' => $dec,
                        'auth_type' => $auth_type,
                        'id_ref_no' => $id_ref_no,
                        'photo' => $photo,
                        'pdar_name_eng' => $fmp['pdar_name_eng'],
                        'pdar_guard_eng' => $fmp['pdar_guard_eng']
                    );
                    //var_dump($tchithacol8occ);
                    $tstatus2 = $this->db->insert('t_chitha_col8_occup', $tchithacol8occ);
                    if ($tstatus2 != 1) {
                        log_message('error', 'VALIDATION-ERROR-MUTATION#0014');
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Order for Case No $case_no Not Successfull. Error Code(#F002)");
                        redirect(base_url() . "index.php/home");
                    }
                }
                /////////End Petitioner/////////////////
            }
            ////////End Dag Loop//////////// $sql="Select *,CASE
            $j = 1;
            $sql = "Select * from field_mut_pattadar where case_no = '$case_no'";

            if ($this->db->query($sql)->num_rows() == 0) {
                log_message('error', 'VALIDATION-ERROR-MUTATION#0015');
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Second party information not found. Error Code(#FPAT001)");
                redirect(base_url() . "index.php/home");
            }

            $seller = $this->db->query($sql)->result_array();
            foreach ($seller as $inplace) {
                //var_dump($inplace);
                $t_chitha_col8_inplace = array(
                    'dist_code' => $fmb['dist_code'],
                    'subdiv_code' => $fmb['subdiv_code'],
                    'cir_code' => $fmb['cir_code'],
                    'mouza_pargona_code' => $fmb['mouza_pargona_code'],
                    'lot_no' => $fmb['lot_no'],
                    'vill_townprt_code' => $fmb['vill_townprt_code'],
                    'dag_no' => $dag['dag_no'],
                    'year_no' => date('Y'),
                    'petition_no' => $fmb['petition_no'],
                    'pdar_id' => $inplace['pdar_id'],
                    'inplace_of_id' => $j++,
                    'inplace_of_name' => $inplace['pdar_name'],
                    'land_area_b' => 0,
                    'land_area_k' => 0,
                    'land_area_lc' => 0,
                    'land_area_g' => 0,
                    'land_area_kr' => 0,
                    'order_passed' => 'y',
                    //'date_of_order' =>date('Y-m-d'),
                    'fmute_strike_out' => $inplace['striked_out'],
                    'inplace_of_gender' => $inplace['pdar_gender'],
                    'inplace_of_minor_yn' => $inplace['pdar_minor_yn'],
                    'inplace_of_minor_dob' => $inplace['pdar_minor_dob'],
                    'inplace_of_father' => $inplace['pdar_guardian'],
                    'inplace_of_mother' => $inplace['pdar_mother'],
                );
                $tstatus3 = $this->db->insert('t_chitha_col8_inplace', $t_chitha_col8_inplace);
                if ($tstatus3 != 1) {
                    log_message('error', 'VALIDATION-ERROR-MUTATION#0016');
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Order for Case No $case_no Not Successfull. Error Code(#F003)");
                    redirect(base_url() . "index.php/home");
                }
            }

            //$this->db->trans_commit();

            foreach ($dag_no as $d) {
                $ok = $this->autoUpdateForField($fmb['dist_code'], $fmb['subdiv_code'], $fmb['cir_code'], $fmb['mouza_pargona_code'], $fmb['lot_no'], $fmb['vill_townprt_code'], $d['petition_no'], $d['dag_no']);
                // $ok = $this->autoUpdate($fmb['dist_code'], $fmb['subdiv_code'], $fmb['cir_code'], $fmb['mouza_pargona_code'], $fmb['lot_no'], $fmb['vill_townprt_code'], $d['petition_no'], $d['dag_no']);            
                if ($ok == false) {
                    log_message('error', 'VALIDATION-ERROR-MUTATION#0017');
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Order for Case No $case_no Not Successfull. Error Code(#F004). The applied dag or patta might have changed or the pattadar is no longer available in the applied dag. Kindly check chitha");
                    redirect(base_url() . "index.php/home");
                    return;
                }
                $order_date = date('Y-m-d');
                $q = "update field_mut_basic set order_passed='y',date_of_order='$order_date' where case_no='$d[case_no]' ";
                $this->db->query($q);
                if ($this->db->affected_rows() <= 0) {
                    log_message('error', 'VALIDATION-ERROR-MUTATION#0018');
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Order for Case No $case_no Not Successfull. Error Code(#FMBFINAL001)");
                    redirect(base_url() . "index.php/home");
                }
                $q = "update t_chitha_col8_order set order_passed='y',date_of_order='$order_date' where case_no='$d[case_no]' ";
                $this->db->query($q);
                if ($this->db->affected_rows() <= 0) {
                    log_message('error', 'VALIDATION-ERROR-MUTATION#0019');
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Order for Case No $case_no Not Successfull. Error Code(#FMBFINAL002)");
                    redirect(base_url() . "index.php/home");
                }
            }

            $rmrk = 'CO order';

            $proInsert = $this->mutationmodel->proceeding_order($case_no, $rmrk);


            if ($proInsert == false || $proInsert === false) {
                log_message('error', "#OMUTCOFM001:" . $this->db->last_query());
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Updation failed(#OMUTCOFM001)" . $case_no);
                redirect(base_url() . "index.php/home");
            }


            //ESCALATION ==============
            $es_flag_data = $this->db->query("select es_flag,out_of_esc from  field_mut_basic where case_no=?", array($case_no))->row();
            if (ESCALATION_ENABLE == 1 && $es_flag_data->es_flag == 1 && ESCALATION_REMARK_ENABLE == 1 && $es_flag_data->out_of_esc == 0) {

                $responseEsc = $this->Escalationmodel->escalationRemarkCheckandUpdate($case_no, $this->input->post('esc_remark'), $this->session->userdata('user_desig_code'));
                if ($responseEsc['responseType'] == 1) {
                    $this->db->trans_rollback();
                    $data = array(
                        'error' => "#ERROR00111 : Error in submitting in escalation remarks. Please try Again"
                    );
                    echo json_encode($data);
                    return false;
                }

            }
            ///END+==================



            if ($ok) {
                //ESCALATION CODE INTEGRATION================SANMRI
                $dist_code = $this->session->userdata('dist_code');
                $subdiv_code = $this->session->userdata('subdiv_code');
                $cir_code = $this->session->userdata('cir_code');
                $query1 = $this->db->query(
                    "SELECT es_flag,out_of_esc FROM field_mut_basic WHERE case_no=?",
                    array($case_no)
                )->row();
                $user_code = $this->session->userdata('user_code');
                $executionDate = $this->input->post('executionDate');
                if ($query1->es_flag == 1 && ESCALATION_ENABLE == 1 && $query1->out_of_esc == 0) {
                    $basundhara = $this->basundharamodel->checkExistBasundhar($case_no);
                    $service_code = 1;
                    $serviceType = explode('/', $basundhara);
                    if ($serviceType[1] == 'MUTD') {
                        $service_code = 2;
                    }
                    $escalationUpdateStatus = $this->Escalationmodel->escalationFinalOrderCOFmut($service_code, $executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code);
                    log_message("error", "#ESC4335, Escalation-transaction-error-STATUS======" . json_encode($escalationUpdateStatus));
                    if ($escalationUpdateStatus['responseType'] == 0) {
                        $this->db->trans_rollback();
                        log_message("error", "#ESC4335, transaction-error in method 'cofieldmutation/finalorderCO' with case-no :" . $case_no);
                        $this->session->set_flashdata('message', "Something went wrong. Error Code(#ESC4335)");
                        redirect(base_url() . "index.php/home");
                    }
                }
                ///////////////END ESCALATION//////////////

                ///////////////////////////////////////////////////////////////////////////
                //////////////////////Property chain code /////////////////////////////////
                ///////////////////////////////////////////////////////////////////////////
                $save_chain_data = true;
                if (ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'), json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))) {
                    $ulpinFlag = $this->input->post('ulpinCheckFlag');
                    $compareFlag = $this->input->post('compareCheckFlag');


                    if ($compareFlag == 'Y' && $ulpinFlag == 1) {
                        $ulpin = $this->input->post('ulpin', true);
                        $revenue = $this->input->post('chain_revenue', true);
                        $local_tax = $this->input->post('chain_local_tax', true);
                        $old_ulpin = $this->input->post('old_ulpin', true);

                        if (!isset($old_ulpin)) {
                            $old_ulpin = "";
                        }

                        $type = LOC_TYPE_RURAL;
                        $dist_code = $fmb['dist_code'];
                        $subdiv_code = $fmb['subdiv_code'];
                        $mouza_code = $fmb['mouza_pargona_code'];
                        $circle_code = $fmb['cir_code'];
                        $lot_no = $fmb['lot_no'];
                        $village_code = $fmb['vill_townprt_code'];
                        $patta_no = $dag['patta_no'];
                        $dag_no = $dag['dag_no'];

                        $location_id = $dist_code . $subdiv_code . $circle_code . $mouza_code . $lot_no . $village_code;

                        $property_id = $this->blockchainutilityclass->generatePropertyId($type, $village_code, $patta_no, $dag_no, $ulpin);

                        $reference_id = $case_no;
                        $certmnemonic = CERTMNEMONIC_MUT;
                        $property_signature = "base64 encoded signature";
                        $property_signer_key = "base64 encoded public key";
                        $office_code = $this->session->userdata('cir_code');
                        $user_code = $this->session->userdata('user_code');

                        $patta_type_code = $dag['patta_type_code'];

                        $land_area = $this->PropChainModel->getLandArea($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $village_code, $patta_no, $dag_no);

                        $bigha_chain = $land_area->dag_area_b;
                        $katha_chain = $land_area->dag_area_k;
                        $lessa_chain = $land_area->dag_area_lc;
                        $ganda_chain = $land_area->dag_area_g;

                        $land_class_code_query = "select land_class_code from chitha_basic where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and patta_no=? and dag_no=?";

                        $land_class_code = $this->db->query($land_class_code_query, array($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $village_code, $patta_no, $dag_no))->row()->land_class_code;

                        $pattadar_details = $this->PropChainModel->getPattadars($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $village_code, $patta_no, $dag_no);

                        // since this is mutation and below paramaters are not applicable send the values as empty string
                        $new_patta_no = $new_dag_no = $old_revenue = $old_local_tax = $old_land_class_code = $new_bigha = $new_katha = $new_lessa = $new_ganda = "";

                        $update_params = array(
                            'pattadar_details' => $pattadar_details,
                            'location_id' => $location_id,
                            'property_id' => $property_id,
                            'reference_id' => $reference_id,
                            'dag_no' => $dag_no,
                            'patta_no' => $patta_no,
                            'patta_type_code' => $patta_type_code,
                            'land_class_code' => $land_class_code,
                            'bigha_chain' => $bigha_chain,
                            'katha_chain' => $katha_chain,
                            'lessa_chain' => $lessa_chain,
                            'ganda_chain' => $ganda_chain,
                            'certmnemonic' => $certmnemonic,
                            'property_signature' => $property_signature,
                            'property_signer_key' => $property_signer_key,
                            'office_code' => $office_code,
                            'user_code' => $user_code,
                            'ulpin' => $ulpin,
                            'old_ulpin' => $old_ulpin,
                            'revenue' => $revenue,
                            'local_tax' => $local_tax,
                            'new_patta_no' => $new_patta_no,
                            'new_dag_no' => $new_dag_no,
                            'old_revenue' => $old_revenue,
                            'old_local_tax' => $old_local_tax,
                            'old_land_class_code' => $old_land_class_code,
                            'new_bigha' => $new_bigha,
                            'new_katha' => $new_katha,
                            'new_lessa' => $new_lessa,
                            'new_ganda' => $new_ganda
                        );


                        $chain_send_data = $this->blockchainutilityclass->getUpdateChainArrayN((object) $update_params);


                        $save_chain_data = $this->PropChainModel->save_chain_data(json_encode($chain_send_data), $case_no);
                    }
                }

                if ($save_chain_data) {

                    $this->db->trans_commit();
                    $this->AgriStackCaseHistory->CreateLog($dist_code, $case_no);
                    /////////////////////Basundhara Status Update/////////////////////////////
                    $basundhara = $this->basundharamodel->checkExistBasundhar($case_no);
                    if ($basundhara) {
                        $rmk = 'Order passed';
                        $status = 'F';
                        $task = 'CO';
                        $pen = 'NA';
                        $case = $case_no;
                        $rtps = $this->rtpsmodel->checkBasundharaService($case_no);
                        if ($rtps == 'RTPS') {
                            $this->rtpsmodel->postApiBasundharaSec($case, $rmk, $status, $task, $pen);
                        } else {
                            $this->basundharamodel->postApiBasundharaSec($case, $rmk, $status, $task, $pen);
                        }
                    }
                    /////////////////////////////////////////////////
                    $this->session->set_flashdata('message', "Order for Case No $case_no Successfully Saved.");
                    $this->session->set_flashdata('message2', "Chitha Has Been Updated");
                    //////////////JamaBandi Update///////////////////
                    $location = array(
                        'd' => $fmb['dist_code'],
                        's' => $fmb['subdiv_code'],
                        'c' => $fmb['cir_code'],
                        'm' => $fmb['mouza_pargona_code'],
                        'l' => $fmb['lot_no'],
                        'v' => $fmb['vill_townprt_code'],
                    );
                    $this->session->set_userdata(array('loc' => $location));
                    $popUpmsg = "<h4>Order for Case No $case_no Successfully Saved.Chitha has been Updated !!! Updating JamaBandi Now<h4>";
                    $msgggg = "<script type='text/javascript'>alert(' " . $popUpmsg . " ');</script>";

                    if (ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'), json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))) {
                        if ($ulpinFlag == 1 && $compareFlag == 'Y') {
                            redirect('JamaBandi/step3/' . $patta_no . '/' . $patta_type_code . '/' . urlencode(base64_encode($case_no)));
                        }


                    }
                    redirect('JamaBandi/step3/' . $patta_no . '/' . $patta_type_code);
                    //////////////////////////////
                } else {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Order for Case No $case_no Not Successfull. Contact Helpdesk with case no, or delete case through utility.");
                    redirect(base_url() . "index.php/home");
                }
            } else {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERRORPROP0987 :  Order for Case No $case_no Not Successfull. Contact Helpdesk with case no, or delete case through utility.");
                redirect(base_url() . "index.php/home");
            }
            ////////////Main Table Update//////////////////
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
        }
    }

    /* This is for Chitha Updation from T_TABLES for field mutation and partial dag partition case final button submission */
    public function autoUpdateForField($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $petition_no, $dag_no)
    {
        //$db=  $this->session->userdata('db');
        $locationData = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'lot_no' => $lot_no,
            'vill_code' => $vill_code,
            'mouza_pargona_code' => $mouza_pargona_code,
        );
        $generation_pdar_id = false;
        $year_no = year_no;

        $col8order_cron_no = $this->db->query("select max(col8order_cron_no)+1 as cron_no from   chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
            . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and dag_no='$dag_no'")->row()->cron_no;
        if ($col8order_cron_no == null) {
            $col8order_cron_no = 1;
        }

        $t_order_data_query = "select * from   t_chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and "
            . "mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and petition_no=$petition_no and dag_no='$dag_no'";// and iscorrected_inco is null";
        $t_data_order = $this->db->query($t_order_data_query);
        if ($t_data_order == null || $t_data_order->num_rows() <= 0) {
            log_message('error', 'VALIDATION-ERROR-MUTATION-UPDATE#0001');
            $this->db->trans_rollback();
            log_message("error", "#ERR001 No data found in t_chitha_col8_order with district: " . $dist_code . ", petition_no: " . $petition_no);
            return false;
        }
        $t_data_order = $t_data_order->result();
        $case_no = null;
        foreach ($t_data_order as $ord) {
            $case_no = $ord->case_no;
            $data_order = array();
            foreach ($ord as $key => $value) {
                $data[$key] = $value;
            }
            $data['col8order_cron_no'] = $col8order_cron_no;
            $data['user_code'] = $this->user_code;
            $data['date_entry'] = date('Y-m-d G:i:s');
            $data['operation'] = date('E');
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
            $tstatus1 = $this->db->insert("chitha_col8_order", $data); //************************************************************************************************ insert query
            if ($tstatus1 != 1) {
                log_message('error', 'VALIDATION-ERROR-MUTATION-UPDATE#0002');
                $this->db->trans_rollback();
                log_message("error", " #ERR002 could not insert chitha_col8_order with district: " . $dist_code . ", petition_no: " . $petition_no);
                return false;
            }

            //Checking for occupents
            $t_occup_query = "select * from   t_chitha_col8_occup where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and "
                . "mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and petition_no=$petition_no and dag_no='$dag_no'";// and iscorrected_inco is null";
            $t_occup_data = $this->db->query($t_occup_query);
            if ($t_occup_data == null || $t_occup_data->num_rows() <= 0) {
                log_message('error', 'VALIDATION-ERROR-MUTATION-UPDATE#0003');
                $this->db->trans_rollback();
                log_message("error", "#ERR003 No data found in t_chitha_col8_occup with district: " . $dist_code . ", petition_no: " . $petition_no);
                return false;
            }
            $t_occup_data = $t_occup_data->result();

            //updating t_chitha_col8_order iscorrected_inco status
            $update_query = "update t_chitha_col8_order  set iscorrected_inco='Y',iscorrected_inco_date='$corrected' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and petition_no=$petition_no and "
                . "dag_no='$dag_no' and iscorrected_inco is null";
            $this->db->query($update_query); //********************************************************************************************* insert query
            if ($this->db->affected_rows() <= 0) {
                log_message('error', 'VALIDATION-ERROR-MUTATION-UPDATE#0004');
                $this->db->trans_rollback();
                log_message("error", "#ERR004 Could not update iscorrected_inco in t_chitha_col8_order with district: " . $dist_code . ", petition_no: " . $petition_no);
                return false;
            }

            $chitha_basic_update = FALSE;
            // occupants details starts here
            foreach ($t_occup_data as $occ) {

                // $sql = "update chitha_basic set jama_yn=null where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' and "
                //         . "mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' and dag_no='$occ->dag_no' "
                //         . "and TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' ";
                // $this->db->query($sql); //************************************************************************************************ update query

                $table = 'chitha_basic';

                $params = [
                    'jama_yn' => null,
                ];

                $where = [
                    'dist_code' => $occ->dist_code,
                    'subdiv_code' => $occ->subdiv_code,
                    'cir_code' => $occ->cir_code,
                    'mouza_pargona_code' => $occ->mouza_pargona_code,
                    'lot_no' => $occ->lot_no,
                    'vill_townprt_code' => $occ->vill_townprt_code,
                    'dag_no' => $occ->dag_no,
                    'patta_no' => trim($occ->patta_no),  // PHP trim to mimic SQL TRIM()
                    'patta_type_code' => $occ->patta_type_code,
                ];

                // Call your model update method:
                $result0 = $this->Chitha_basic_model->update_table($table, $params, $where);

                if ($result0 <= 0) {
                    log_message('error', 'VALIDATION-ERROR-MUTATION-UPDATE#0005');
                    $this->db->trans_rollback();
                    log_message("error", "#ERR005 Could not update jama_yn in chitha_basic with district: " . $dist_code . ", petition_no: " . $petition_no);
                    return false;
                }

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
                $data['user_code'] = $this->user_code;
                $data['date_entry'] = date('Y-m-d G:i:s');
                $data['operation'] = date('E');
                $occupData = $data;
                //var_dump($data);

                $tstatus2 = $this->db->insert("chitha_col8_occup", $data); //************************************************************************************************ insert query
                if ($tstatus2 != 1) {
                    log_message('error', 'VALIDATION-ERROR-MUTATION-UPDATE#0006');
                    $this->db->trans_rollback();
                    log_message("error", "#ERR006 Could not insert in chitha_col8_occup with district: " . $dist_code . ", petition_no: " . $petition_no);
                    return false;
                }

                $dag_pattadar = array();
                $chitha_pattadar = array();

                $pdar_id = $occ->pdar_id;

                if ($ord->order_type_code == '02') {
                    // Order Type Code 02 iIs For Field Partition. and 01 is For Field Mutation
                    $pdar_id = $this->db->query("select max(cast(pdar_id as int))+1 as pdar_id from   chitha_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                        . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and "
                        . "TRIM(patta_no)=trim('$occ->new_patta_no')")->row()->pdar_id;
                }

                if ($pdar_id == null) {
                    $pdar_id = 1;
                }
                //echo $pdar_id;
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
                // if(MULTIGENERATION_ACTIVE==1){
                //     if($generation_pdar_id==false){
                //         $pattadars_in_chitha_pattadar = $this->db->query("select max(pdar_id::int)+1 as cp from chitha_pattadar where dist_code='$dist_code' and "
                //             . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
                //             . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$occ->patta_type_code' and TRIM(patta_no)=trim('$occ->patta_no')")->row()->cp;
                //         log_message('error','09--'.$this->db->last_query());
                //         $pattadars_in_jama_pattadar = $this->db->query("select max(pdar_id::int)+1 as jp from jama_pattadar where dist_code='$dist_code' and "
                //                 . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
                //                 . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$occ->patta_type_code' and TRIM(patta_no)=trim('$occ->patta_no')")->row()->jp;
                //         log_message('error','010--'.$this->db->last_query());
                //         $pattadars_in_chithaDag_pattadar = $this->db->query("select max(pdar_id::int)+1 as dp from chitha_dag_pattadar where dist_code='$dist_code' and "
                //                 . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
                //                 . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$occ->patta_type_code' and TRIM(patta_no)=trim('$occ->patta_no') and dag_no='$occ->dag_no'")->row()->dp;
                //         log_message('error','011--'.$this->db->last_query());
                //         if($pattadars_in_chitha_pattadar > $pattadars_in_jama_pattadar){
                //             if($pattadars_in_chithaDag_pattadar>$pattadars_in_chitha_pattadar){
                //                 $mgen_pdar_id= $pattadars_in_chithaDag_pattadar;
                //             }else{
                //                 $mgen_pdar_id= $pattadars_in_chitha_pattadar;
                //             }
                //         }elseif($pattadars_in_chithaDag_pattadar > $pattadars_in_jama_pattadar){
                //             $mgen_pdar_id= $pattadars_in_chithaDag_pattadar;
                //         }else{
                //             $mgen_pdar_id= $pattadars_in_jama_pattadar;
                //         }
                //         if($mgen_pdar_id=== null){
                //             $mgen_pdar_id=1;
                //         }
                //         $generation_pdar_id=true;
                //     }
                //     else{
                //         $mgen_pdar_id = $mgen_pdar_id+ 1;
                //     }
                //     $dag_pattadar['pdar_id']=$mgen_pdar_id;
                //     $pdar_id = $mgen_pdar_id;
                // }
                // log_message('error','pdar_id-----'.json_encode($mgen_pdar_id));

                if ($ord->order_type_code == '02') {
                    $dag_pattadar['patta_no'] = trim($occ->new_patta_no);
                    $chitha_pattadar['patta_no'] = trim($occ->new_patta_no);
                } else {
                    $dag_pattadar['patta_no'] = trim($occ->patta_no);
                    $chitha_pattadar['patta_no'] = trim($occ->patta_no);
                }
                $dag_pattadar['p_flag'] = '0';
                // if(MULTIGENERATION_ACTIVE==1)
                // {
                //     $dag_pattadar['p_flag'] = $occ->pdar_strike;
                // }

                $dag_pattadar['patta_type_code'] = $occ->patta_type_code;
                $dag_pattadar['dag_por_b'] = $occ->land_area_b;
                $dag_pattadar['dag_por_k'] = $occ->land_area_k;
                $dag_pattadar['dag_por_lc'] = $occ->land_area_lc;
                $dag_pattadar['dag_por_g'] = $occ->land_area_g;
                $dag_pattadar['dag_por_kr'] = $occ->land_area_kr;

                $dag_pattadar['user_code'] = $this->user_code;
                $dag_pattadar['date_entry'] = date('Y-m-d G:i:s');
                $dag_pattadar['operation'] = date('E');

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
                $chitha_pattadar['pdar_add3'] = $occ->occupant_add3;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_guard_reln'] = $occ->occupant_fmh_flag;
                $chitha_pattadar['user_code'] = $this->user_code;
                $chitha_pattadar['date_entry'] = date('Y-m-d G:i:s');
                $chitha_pattadar['operation'] = date('E');
                $chitha_pattadar['jama_yn'] = 'N';
                //////////////////////////
                $chitha_pattadar['pdar_name_eng'] = $occ->pdar_name_eng;
                $chitha_pattadar['pdar_guard_eng'] = $occ->pdar_guard_eng;
                //newly added aadhaar details to chitha pattadar----
                $flagAadhaar = null;
                $flagPan = null;
                if ($occ->auth_type == 'AADHAAR') {
                    $chitha_pattadar['pdar_aadharno'] = $occ->id_ref_no;
                    $flagAadhaar = $occ->id_ref_no;
                    $flagPan = null;
                } else if ($occ->auth_type == 'PAN') {
                    $chitha_pattadar['pdar_pan_no'] = $occ->id_ref_no;
                    $flagAadhaar = null;
                    $flagPan = $occ->id_ref_no;
                }

                $chitha_pattadar['pdar_photo'] = $occ->photo;
                //end-----------


                $chitha_basic_query = "select land_class_code from   chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' "
                    . "and mouza_pargona_code='$mouza_pargona_code' and TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' and dag_no='$dag_no'";
                $result = $this->db->query($chitha_basic_query)->row();

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
                $chitha_basic['user_code'] = $this->user_code;
                $chitha_basic['date_entry'] = date('Y-m-d G:i:s');
                $chitha_basic['land_class_code'] = $result->land_class_code;

                //Partition to new dag
                if ($ord->order_type_code == '02') {
                    $old_dag = $dag_no;
                    $chitha_basic['dag_no'] = $occ->new_dag_no;
                    $chitha_basic['dag_no_int'] = $occ->new_dag_no . '00';
                    $chitha_basic['old_dag_no '] = $dag_no;
                    $old_patta = trim($occ->old_patta_no);
                    $chitha_basic['patta_no'] = trim($occ->new_patta_no);

                    $q = "update chitha_col8_order set new_dag_no='$occ->new_dag_no' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                        . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and col8order_cron_no=$col8order_cron_no and dag_no='$dag_no' ";
                    $this->db->query($q); //************************************************************************************************ update query
                    if ($this->db->affected_rows() <= 0) {
                        log_message('error', 'VALIDATION-ERROR-MUTATION-UPDATE#0007');
                        $this->db->trans_rollback();
                        log_message("error", "#ERR007 Could not update new_dag_no in chitha_col8_order with district: " . $dist_code . ", petition_no: " . $petition_no);
                        return false;
                    }
                } else {
                    $chitha_basic['dag_no'] = $dag_no;

                    $q = "select dag_no_int as dag_no_int from   chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                        . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$occ->patta_type_code' and "
                        . "TRIM(patta_no)=trim('$occ->patta_no')";
                    $dag_no_int = $this->db->query($q)->row()->dag_no_int;

                    $chitha_basic['dag_no_int'] = $dag_no_int;
                    $chitha_basic['patta_no'] = trim($occ->patta_no);
                }

                $chitha_basic['patta_type_code'] = $occ->patta_type_code;
                $chitha_basic['operation'] = "E";
                //var_dump($dag_pattadar);

                $corrected = date('Y-m-d G:i:s');
                if ((!$chitha_basic_update) && ($ord->order_type_code == '02')) {
                    // This Block Is For Field Partition
                    $chitha_basic_update = TRUE;
                    $sql = "select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,dag_revenue from   chitha_basic where dist_code='$occ->dist_code' and "
                        . "subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' and mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and "
                        . "vill_townprt_code='$occ->vill_townprt_code' and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' ";
                    $data = $this->db->query($sql)->row();

                    ////// BARAK VALLEY CODE START ////////////
                    if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                        $chitha_basic['dag_revenue'] = $ord->min_revenue * (($ord->mut_land_area_b * 6400 + $ord->mut_land_area_k * 320 + $ord->mut_land_area_lc * 20 + $ord->mut_land_area_g) / 6400.0);

                    } else {
                        $chitha_basic['dag_revenue'] = $ord->min_revenue * (($ord->mut_land_area_b * 100 + $ord->mut_land_area_k * 20 + $ord->mut_land_area_lc) / 100.0);
                    }


                    $chitha_basic['dag_local_tax'] = $chitha_basic['dag_revenue'] / 4.0;

                    // $tstatus_ch = $this->db->insert("chitha_basic", $chitha_basic); //************************************************************************************************ insert query
                    $tstatus_ch = $this->Chitha_basic_model->insert_table('chitha_basic', $chitha_basic);
                    if ($tstatus_ch != 1) {
                        $this->db->trans_rollback();
                        log_message("error", "#ERR008 Could not insert in chitha_basic with district: " . $dist_code . ", petition_no: " . $petition_no);
                        return false;
                    }


                    $dataNew['dag_no'] = $chitha_basic['dag_no'];
                    $tstatus_ord = $this->db->insert("chitha_col8_order", $dataNew); //************************************************************************************************ insert query
                    if ($tstatus_ord != 1) {
                        log_message('error', 'VALIDATION-ERROR-MUTATION-UPDATE#0008');
                        $this->db->trans_rollback();
                        log_message("error", "#ERR009 Could not insert in chitha_col8_order with district: " . $dist_code . ", petition_no: " . $petition_no);
                        return false;
                    }

                    ////// BARAK VALLEY CODE START ////////////
                    if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {

                        $sourcelessa = $data->dag_area_b * 6400 + $data->dag_area_k * 320 + $data->dag_area_lc * 20 + $data->dag_area_g;
                        $mutationlessa = $ord->mut_land_area_b * 6400 + $ord->mut_land_area_k * 320 + $ord->mut_land_area_lc * 20 + $ord->mut_land_area_g;
                        $remaining_lessa = $sourcelessa - $mutationlessa;
                        $left_b = floor($remaining_lessa / 6400);
                        $left_k = floor(($remaining_lessa - $left_b * 6400) / 320);
                        $left_lc = floor(($remaining_lessa - $left_b * 6400 - $left_k * 320) / 20);
                        $left_g = $remaining_lessa - $left_b * 6400 - $left_k * 320 - $left_lc * 20;
                        $left_kr = 0;
                    } else {
                        $sourcelessa = $data->dag_area_b * 100 + $data->dag_area_k * 20 + $data->dag_area_lc;
                        $mutationlessa = $ord->mut_land_area_b * 100 + $ord->mut_land_area_k * 20 + $ord->mut_land_area_lc;
                        $remaining_lessa = $sourcelessa - $mutationlessa;

                        $left_b = floor($remaining_lessa / 100);
                        $left_k = floor(($remaining_lessa - $left_b * 100) / 20);
                        $left_lc = $remaining_lessa - $left_b * 100 - $left_k * 20;
                        $left_g = 0;
                        $left_kr = 0;
                    }


                    $d = date('Y-m-d G:i:s');

                    $dag_revenue_updates = $data->dag_revenue;

                    if ($dag_revenue_updates == null) {
                        $dag_revenue_updates = 0;
                    }
                    $dag_local_tax_update = $dag_revenue_updates / 4;
                    // $sql = "update chitha_basic set jama_yn=null,dag_revenue=$dag_revenue_updates,dag_local_tax=$dag_local_tax_update,dag_area_b=$left_b,dag_area_k=$left_k,"
                    //         . "dag_area_lc=$left_lc,dag_area_g=$left_g,dag_area_kr=$left_kr,date_entry='$d',operation='M' where dist_code='$occ->dist_code' and "
                    //         . "subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' and mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and "
                    //         . "vill_townprt_code='$occ->vill_townprt_code' and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' ";
                    // $this->db->query($sql); //************************************************************************************************ update query
                    $table = 'chitha_basic';

                    $params = [
                        'jama_yn' => null,
                        'dag_revenue' => $dag_revenue_updates,
                        'dag_local_tax' => $dag_local_tax_update,
                        'dag_area_b' => $left_b,
                        'dag_area_k' => $left_k,
                        'dag_area_lc' => $left_lc,
                        'dag_area_g' => $left_g,
                        'dag_area_kr' => $left_kr,
                        'date_entry' => $d,         // Assuming $d is a formatted date string
                        'operation' => 'M',
                    ];

                    $where = [
                        'dist_code' => $occ->dist_code,
                        'subdiv_code' => $occ->subdiv_code,
                        'cir_code' => $occ->cir_code,
                        'mouza_pargona_code' => $occ->mouza_pargona_code,
                        'lot_no' => $occ->lot_no,
                        'vill_townprt_code' => $occ->vill_townprt_code,
                        'dag_no' => $occ->dag_no,
                        'patta_no' => trim($occ->patta_no),  // PHP trim to mimic SQL TRIM()
                        'patta_type_code' => $occ->patta_type_code,
                    ];

                    // Call your update method:
                    $result1 = $this->Chitha_basic_model->update_table($table, $params, $where);

                    if ($result1 <= 0) {
                        log_message('error', 'VALIDATION-ERROR-MUTATION-UPDATE#0009');
                        $this->db->trans_rollback();
                        log_message("error", "#ERR010 Could not update  jama_yn=null in chitha_basic with district: " . $dist_code . ", petition_no: " . $petition_no);
                        return false;
                    }
                }

                $p_id = $dag_pattadar['pdar_id'];

                if ($ord->order_type_code == '02') {
                    // This Block Is For Field Partition
                    $q = "select count(*) as count from   chitha_dag_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' "
                        . "and mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' and dag_no='$occ->dag_no' "
                        . "and TRIM(patta_no)=trim('$occ->new_patta_no') and patta_type_code='$occ->patta_type_code' and pdar_id='$p_id'";
                    $cDagPattadarExists = $this->db->query($q)->row()->count;

                    $q = "select count(*) as count from   chitha_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                        . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                        . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                        . " and TRIM(patta_no)=trim('$occ->new_patta_no') and"
                        . " patta_type_code='$occ->patta_type_code' and pdar_id='$p_id'";
                    $cPattadarExists = $this->db->query($q)->row()->count;
                } else {
                    // This Block Is For Field Mutation
                    $q = "select count(*) as count from   chitha_dag_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' "
                        . "and mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' and dag_no='$occ->dag_no' "
                        . "and TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' and pdar_id='$p_id'";
                    $cDagPattadarExists = $this->db->query($q)->row()->count;

                    $q = "select count(*) as count from   chitha_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' and "
                        . "mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' and "
                        . "TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' and pdar_id='$p_id'";
                    $cPattadarExists = $this->db->query($q)->row()->count;
                }
                //var_dump($dag_pattadar);
                $occ->new_pattadar; // for partition it will always be new pattadar
                if (($occ->new_pattadar != 'N') && $occ->auth_type != null) {
                    $p_id = $occ->pdar_id;
                    // $query = "update chitha_pattadar set pdar_aadharno = '$flagAadhaar',pdar_pan_no = '$flagPan', pdar_photo ='$photo' where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' and "
                    //         . "mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' and "
                    //         . "TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' and pdar_id='$p_id'";
                    // $this->db->query($query);

                    $table = 'chitha_pattadar';

                    $params = [
                        'pdar_aadharno' => $flagAadhaar,
                        'pdar_pan_no' => $flagPan,
                        'pdar_photo' => $photo,
                    ];

                    $where = [
                        'dist_code' => $occ->dist_code,
                        'subdiv_code' => $occ->subdiv_code,
                        'cir_code' => $occ->cir_code,
                        'mouza_pargona_code' => $occ->mouza_pargona_code,
                        'lot_no' => $occ->lot_no,
                        'vill_townprt_code' => $occ->vill_townprt_code,
                        'patta_no' => trim($occ->patta_no), // Equivalent to TRIM() in SQL
                        'patta_type_code' => $occ->patta_type_code,
                        'pdar_id' => $p_id,
                    ];

                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                    if ($this->db->affected_rows() <= 0) {
                        log_message('error', $this->db->last_query());
                        log_message('error', 'VALIDATION-ERROR-MUTATION-UPDATE#00010');
                        $this->db->trans_rollback();
                        log_message("error", "#ERR013 Could not update aadhaar details in chitha_pattadar with district: " . $dist_code
                            . ", petition_no: " . $petition_no);
                        return false;
                    }
                }

                if (($occ->new_pattadar == 'N')) {
                    //var_dump($dag_pattadar);
                    //var_dump($chitha_pattadar);
                    // $tstatus3 = $this->db->insert("chitha_dag_pattadar", $dag_pattadar);//************************************************* insert query
                    $tstatus3 = $this->Chitha_basic_model->insert_table('chitha_dag_pattadar', $dag_pattadar);
                    if ($tstatus3 != 1) {
                        log_message('error', 'VALIDATION-ERROR-MUTATION-UPDATE#00011');
                        $this->db->trans_rollback();
                        log_message("error", "#ERR011 Could not insert in  chitha_dag_pattadar with district: " . $dist_code . ", petition_no: " . $petition_no);
                        return false;
                    }
                    if (($cPattadarExists == 0)) {
                        $chitha_pattadar['f1_case_no'] = $case_no;

                        // $tstatus4 = $this->db->insert("chitha_pattadar", $chitha_pattadar);//************************************************************************************************ insert query
                        $tstatus4 = $this->Chitha_basic_model->insert_table('chitha_pattadar', $chitha_pattadar);
                        if ($tstatus4 != 1) {
                            log_message('error', 'VALIDATION-ERROR-MUTATION-UPDATE#00012');
                            $this->db->trans_rollback();
                            log_message("error", "#ERR012 Could not insert in  chitha_pattadar with district: " . $dist_code . ", petition_no: " . $petition_no);
                            return false;
                        }
                    }
                }
                $today = date('Y-m-d');
                $t_occup_query = "update t_chitha_col8_occup set iscorrected_inco='Y',iscorrected_inco_date='$corrected',order_passed='Y' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                    . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                    . "vill_townprt_code='$vill_code' and petition_no=$petition_no and dag_no='$dag_no' ";
                $this->db->query($t_occup_query);//*********************************************************************************** update query
                if ($this->db->affected_rows() <= 0) {
                    log_message('error', 'VALIDATION-ERROR-MUTATION-UPDATE#00013');
                    $this->db->trans_rollback();
                    log_message("error", "#ERR013 Could not update iscorrected_inco in t_chitha_col8_occup with district: " . $dist_code
                        . ", petition_no: " . $petition_no);
                    return false;
                }
            }
            // occupants details ends here

            if ($ord->order_type_code == '02') {
                foreach ($t_occup_data as $occup) {
                    // $sql = "update chitha_dag_pattadar set p_flag='1' where   dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and dag_no='$dag_no' and pdar_id=$occup->pdar_id";
                    // $this->db->query($sql);//************************************************************************************************ update query
                    $table = 'chitha_dag_pattadar';

                    $params = [
                        'p_flag' => '1',
                    ];

                    $where = [
                        'dist_code' => $dist_code,
                        'subdiv_code' => $subdiv_code,
                        'cir_code' => $cir_code,
                        'lot_no' => $lot_no,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'vill_townprt_code' => $vill_code,
                        'dag_no' => $dag_no,
                        'pdar_id' => $occup->pdar_id,
                    ];

                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);


                    if ($result <= 0) {
                        log_message('error', 'VALIDATION-ERROR-MUTATION-UPDATE#00014');
                        $this->db->trans_rollback();
                        log_message("error", "#ERR014 Could not update p_flag in chitha_dag_pattadar with district: " . $dist_code
                            . ", petition_no: " . $petition_no);
                        return false;
                    }
                }
            }

            if (($ord->order_type_code == '01') || ($ord->order_type_code == '02')) {

                $t_inplace_query = "select * from   t_chitha_col8_inplace where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and "
                    . "mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and dag_no='$dag_no' and iscorrected_inco is null";
                $t_inplace_data = $this->db->query($t_inplace_query);

                if (($ord->order_type_code == '01') && ($t_inplace_data == null || $t_inplace_data->num_rows() <= 0)) {
                    log_message('error', 'VALIDATION-ERROR-MUTATION-UPDATE#00015');
                    $this->db->trans_rollback();
                    log_message("error", "#ERR015 Could not find data in t_chitha_col8_inplace with district: "
                        . $dist_code . ", petition_no: " . $petition_no);
                    return false;
                }
                $t_inplace_data = $t_inplace_data->result();

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

                    $queryCheck = "select count(*) as c from   chitha_col8_inplace where dist_code='$data[dist_code]' and subdiv_code='$data[subdiv_code]' and cir_code='$data[cir_code]' and "
                        . " mouza_pargona_code='$data[mouza_pargona_code]' and lot_no='$data[lot_no]' and vill_townprt_code='$data[vill_townprt_code]' and dag_no='$data[dag_no]' and "
                        . "col8order_cron_no='$data[col8order_cron_no]' and inplace_of_id='$data[inplace_of_id]' ";
                    $count = $this->db->query($queryCheck)->row()->c;
                    if ($count <= 0) {
                        $tstatus5 = $this->db->insert("chitha_col8_inplace", $data);//********************************************** insert query
                        if ($tstatus5 != 1) {
                            log_message('error', 'VALIDATION-ERROR-MUTATION-UPDATE#00016');
                            $this->db->trans_rollback();
                            log_message("error", "#ERR016 Could not insert in chitha_col8_inplace with district: " . $dist_code
                                . ", petition_no: " . $petition_no);
                            return false;
                        }
                    }

                    $p_flag = '0';
                    if ($inplace->fmute_strike_out == '1')
                        $p_flag = '1';
                    $corrected = date('Y-m-d G:i:s');
                    // $update_query = "update chitha_dag_pattadar  set p_flag='$p_flag',date_entry='$corrected' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and dag_no='$dag_no' and pdar_id=$inplace->pdar_id";

                    // $this->db->query($update_query);//************************************************************************************ update query
                    $table = 'chitha_dag_pattadar';

                    $params = [
                        'p_flag' => $p_flag,
                        'date_entry' => $corrected,
                    ];

                    $where = [
                        'dist_code' => $dist_code,
                        'subdiv_code' => $subdiv_code,
                        'cir_code' => $cir_code,
                        'lot_no' => $lot_no,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'vill_townprt_code' => $vill_code,
                        'dag_no' => $dag_no,
                        'pdar_id' => $inplace->pdar_id,
                    ];

                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);


                    if ($result <= 0) {
                        log_message('error', 'VALIDATION-ERROR-MUTATION-UPDATE#00017');
                        $this->db->trans_rollback();
                        log_message("error", "#ERR017 Could not update p_flag in chitha_dag_pattadar with district: " . $dist_code
                            . ", petition_no: " . $petition_no);
                        return false;
                    }

                    $t_inplace_query = "update t_chitha_col8_inplace set iscorrected_inco='Y',iscorrected_inco_date='$corrected',order_passed='Y' where dist_code='$dist_code' and "
                        . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' "
                        . "and dag_no='$dag_no'";
                    $this->db->query($t_inplace_query);//*********************************************************************************** update query
                    if ($this->db->affected_rows() <= 0) {
                        log_message('error', 'VALIDATION-ERROR-MUTATION-UPDATE#00018');
                        $this->db->trans_rollback();
                        log_message("error", "#ERR018 Could not update iscorrected_inco in t_chitha_col8_inplace with district: " . $dist_code
                            . ", petition_no: " . $petition_no);
                        return false;
                    }

                    $date_of_order = date('Y-m-d');
                    $order_update_query = "update field_mut_basic set order_passed='Y',date_of_order='$date_of_order' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                        . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                        . "vill_townprt_code='$vill_code' and petition_no=$petition_no";
                    $this->db->query($order_update_query);//***************************************************************** update query
                    if ($this->db->affected_rows() <= 0) {
                        log_message('error', 'VALIDATION-ERROR-MUTATION-UPDATE#00019');
                        $this->db->trans_rollback();
                        log_message("error", " #ERR019 Could not update order_passed in field_mut_basic with district: " . $dist_code
                            . ", petition_no: " . $petition_no);
                        return false;
                    }
                }
            }
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message("error", "#ERR020 Could not complet autoUpdate for chitha with district: " . $dist_code
                . ", petition_no: " . $petition_no);
            return false;
        }
        return true;
    }

    /* This is for passing field partition case final button submission */
    // public function saveOccupantPartitionOrder()
    // {
    //     $db=  $this->session->userdata('db');
    //     $this->db->trans_begin();
    //     $dist_code = $this->session->userdata('dist_code');
    //     $cir_code = $this->session->userdata('cir_code');
    //     $subdiv_code = $this->session->userdata('subdiv_code');
    //     $mouza_pargona_code1 = $this->input->post('mouza_pargona_code');
    //     $lot_no1 = $this->input->post('lot_no');
    //     $vill_townprt_code1 = $this->input->post('vill_townprt_code');

    //     $case_no = $this->input->post('case_no');
    //     $new_dag = $this->input->post('sugg_dag_no');
    //     $new_patta = $this->input->post('sugg_patta_no');
    //     $dag_revenue=$this->input->post('dag_revenue');
    //     $dag_local_tax=$this->input->post('dag_local_tax');
    //     $bigha = $this->input->post('bigha_applied');
    //     $katha = $this->input->post('katha_applied');
    //     $lessa= $this->input->post('lessa_applied');
    //     $date=date('Y-m-d');
    //     $occup_query = "select mp.dist_code,mp.subdiv_code,mp.cir_code,mp.mouza_pargona_code,mp.lot_no,mp.vill_townprt_code,"
    //             . "mp.pdar_id,mp.year_no,mp.petition_no,mp.pdar_add1,mp.pdar_add2,mp.pdar_name,mp.pdar_guardian,mp.pdar_rel_guar,"
    //             . "dd.patta_no,dd.patta_type_code,mp.pdar_dag_por_b,mp.pdar_dag_por_k,mp.pdar_dag_por_lc,dd.dag_no from   "
    //             . "field_part_petitioner mp,field_mut_dag_details dd where mp.cir_code=dd.cir_code and mp.case_no = dd.case_no "
    //             . "and mp.case_no='$case_no' and mp.cir_code ='$cir_code' and mp.subdiv_code='$subdiv_code' and mp.mouza_pargona_code = '$mouza_pargona_code1' "
    //             . "and mp.lot_no = '$lot_no1' and mp.vill_townprt_code = '$vill_townprt_code1' limit 1";

    //     $petitioner_save = $this->db->query($occup_query);
    //     if ($petitioner_save == null || $petitioner_save->num_rows()<=0)
    //     {
    //         $this->db->trans_rollback();
    //         $this->session->set_flashdata('message', "Could not get petitioner details. Error Code(#FPPET001)");
    //         log_message("error","#ERR001 Nill petition from field_part_petitioner for dist:".$dist_code.", case: ". $case_no);
    //         redirect(base_url() . "index.php/home");
    //         return;        
    //     }
    //     $petitioner_save = $petitioner_save->row();
    //     $occup_data = "select * from   field_part_petitioner where case_no='$case_no' and mouza_pargona_code = '$mouza_pargona_code1' "
    //             . "and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1' and $this->base_query";
    //     $occup_data = $this->db->query($occup_data);
    //     if ($occup_data == null || $occup_data->num_rows()<=0)
    //     {
    //         $this->db->trans_rollback();
    //         $this->session->set_flashdata('message', "Could not get petitioner details. Error Code(#FPPET002)");
    //         log_message("error","#ERR002 Nill petition from field_part_petitioner for dist:".$dist_code.", case: ". $case_no);
    //         redirect(base_url() . "index.php/home");
    //         return;                
    //     }
    //     $occup_data = $occup_data->result();

    //     $get_mut_type = $this->db->query("Select mut_type as mut_type from   field_mut_basic where case_no='$case_no' and mouza_pargona_code = '$mouza_pargona_code1' "
    //             . "and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1' and $this->base_query")->row()->mut_type;

    //     //Field Partition
    //     if($get_mut_type == '02')
    //     {
    //         $new_pattadar = 'N';
    //         $sql="Select patta_type_code,dag_no from field_mut_dag_details where case_no='$case_no' ";
    //         $dd=$this->db->query($sql);
    //         if ($dd == null || $dd->num_rows()<=0)
    //         {
    //             $this->db->trans_rollback();
    //             $this->session->set_flashdata('message', "Could not get petitioner details. Error Code(#FPMDD001)");
    //             log_message("error","#ERR003 Nill petition from field_mut_dag_details for dist:".$dist_code.", case: ". $case_no);
    //             redirect(base_url() . "index.php/home");
    //             return;                
    //         }
    //         $dd=$dd->row();

    //         $pp_code=$dd->patta_type_code;
    //         $old=$dd->dag_no;
    //         $sql="Select count(*) as d from chitha_basic where mouza_pargona_code = '$mouza_pargona_code1' "
    //             . "and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1' and $this->base_query and dag_no='$new_dag' and dag_no!='$old' ";
    //         $count=$this->db->query($sql)->row()->d;
    //         if($count != null && $count>0){                
    //             $this->db->trans_rollback();
    //             $this->session->set_flashdata('message', "The Dag no you have given already exist ! Please re-verify the dag no 
    //                 again (#FPCB001)");
    //             log_message("error","#ERR004 Nill petition from chitha_basic for dist:".$dist_code.", case: ". $case_no);
    //             redirect(base_url() . "index.php/home");
    //             return;
    //         }
    //         $sql="Select count(*) as c from chitha_pattadar where mouza_pargona_code = '$mouza_pargona_code1' "
    //             . "and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1' and $this->base_query and patta_no='$new_patta' and patta_type_code='$pp_code' ";           
    //         $count=$this->db->query($sql)->row()->c;
    //         if($count != null && $count>0){                
    //             $this->db->trans_rollback();
    //             $this->session->set_flashdata('message', "The patta no you have selected already exist pattadar !");
    //             log_message("error","#ERR004 Nill petition from field_part_petitioner for dist:".$dist_code.", case: ". $case_no);
    //             redirect(base_url() . "index.php/home");
    //             return;
    //         }
    //     }
    //     else
    //     {
    //         $new_pattadar = '';
    //     }

    //     //var_dump($occup_data);
    //     foreach ($occup_data as $occup) {
    //         //var_dump($occup);
    //         $t_chitha_col8_occup = array(
    //             'dist_code'=>$occup->dist_code, 
    //             'subdiv_code'=>$occup->subdiv_code,
    //             'cir_code'=>$occup->cir_code,
    //             'mouza_pargona_code'=>$occup->mouza_pargona_code,
    //             'lot_no'=>$occup->lot_no, 
    //             'vill_townprt_code'=>$occup->vill_townprt_code, 
    //             'dag_no'=>$occup->dag_no,//$new_dag, //should be the new dag
    //             'year_no'=>$occup->year_no, 
    //             'petition_no'=>$occup->petition_no, 
    //             'occupant_id'=>$occup->pdar_cron_no, 
    //             'patta_type_code'=>$occup->patta_type_code,
    //             'patta_no'=>$occup->patta_no,//$new_patta,  //should be the new patta no
    //             'pdar_id'=>$occup->pdar_id, 
    //             'occupant_name'=>$occup->pdar_name, 
    //             'occupant_fmh_name'=>$occup->pdar_guardian, 
    //             'occupant_fmh_flag'=>$occup->pdar_rel_guar, 
    //             'occupant_add1'=>$occup->pdar_add1, 
    //             'occupant_add2'=>$occup->pdar_add2, 
    //             'land_area_b'=>$occup->pdar_dag_por_b, 
    //             'land_area_k'=>$occup->pdar_dag_por_k, 
    //             'land_area_lc'=>$occup->pdar_dag_por_lc, 
    //             'land_area_g'=>'0', 
    //             'land_area_kr'=>'0', 
    //             'old_patta_no'=>$occup->patta_no, 
    //             'new_patta_no'=>$new_patta, 
    //             'old_dag_no'=>$occup->dag_no, 
    //             'new_dag_no'=>$new_dag,  
    //             'new_pattadar'=>$new_pattadar,
    //             'revenue'=> $dag_revenue
    //         );
    //         //var_dump($t_chitha_col8_occup);
    //         $tstatus1 = $this->db->insert("t_chitha_col8_occup", $t_chitha_col8_occup); //****************************
    //         if ($tstatus1 != 1 )
    //         {
    //            $this->db->trans_rollback();
    //            $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#FPTCCOC001)");
    //            log_message("error","#FPTCCOC001 Nill petition from t_chitha_col8_occup for dist:"
    //                        .$dist_code.", case: ". $case_no);
    //            redirect(base_url() . "index.php/home");
    //         }
    //         // ////////////Set Patta For JamaUpdation 14/10/2020/////////////////
    //         $patta_no=$new_patta;
    //         $patta_type_code=$occup->patta_type_code;
    //         // ////////////////////////////
    //     }
    //     //TO BE CLARIFIED
    //     $final_data = $this->session->userdata('final_order');

    //     if($final_data==null || $final_data==''){
    //         $this->db->trans_rollback();
    //         $this->session->set_flashdata('message', "Please verify the Dag no and Patta no that you have selected !");
    //         log_message("error","#ERR005 Empty final data for dist:".$dist_code.", case: ". $case_no);
    //         redirect(base_url() . "index.php/home");
    //         return;
    //     }

    //     foreach ($final_data as $fd) {
    //         if ($fd['case_no'] != $case_no)
    //         {
    //            $this->db->trans_rollback();
    //            $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#FPTCDUPO001)");
    //            log_message("error","#FPTCDUPO001 unable to insert into t_chitha_col8_order for dist:"
    //                     .$dist_code.", case: ". $case_no);
    //            redirect(base_url() . "index.php/home");
    //            return;
    //         }
    //         unset($fd['sugg_pno']);
    //         unset($fd['not_consistent']);
    //         $fd['mut_land_area_b']=$bigha;
    //         $fd['mut_land_area_k']=$katha;
    //         $fd['mut_land_area_lc']=$lessa;
    //         $fd['min_revenue']=$dag_revenue;
    //         //var_dump($fd);
    //         $tstatus2=$this->db->insert("t_chitha_col8_order", $fd); //****************************
    //         if ($tstatus2 != 1 )
    //         {
    //            $this->db->trans_rollback();
    //            $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#FPTCO002)");
    //            log_message("error","#FPTCO002 unable to insert into t_chitha_col8_order for dist:"
    //                     .$dist_code.", case: ". $case_no);
    //            redirect(base_url() . "index.php/home");
    //            return;
    //         }
    //     }
    //     $dist_code = $petitioner_save->dist_code;
    //     $subdiv_code = $petitioner_save->subdiv_code;
    //     $cir_code = $petitioner_save->cir_code;
    //     $mouza_pargona_code = $petitioner_save->mouza_pargona_code;
    //     $lot_no = $petitioner_save->lot_no;
    //     $vill_townprt_code = $petitioner_save->vill_townprt_code;
    //     $dag_no = $petitioner_save->dag_no;
    //     $petition_no = $petitioner_save->petition_no;

    //     if ($this->db->trans_status() === FALSE) {
    //         $this->db->trans_rollback();
    //         $db_debug = $this->db->db_debug;
    //         $this->db->db_debug = TRUE;
    //         //echo $this->db->_error_message();
    //         $this->db->db_debug = $db_debug;
    //         $url="<a href='cofieldmutation/pendingmaps' class='text-success'>Kindly Click Here to Remove Temporary Data </a>";
    //         $this->session->set_flashdata("message", "Order Cannot be passed. Error Code [T-TABLE_HAS_DATA] . Contact help desk with case no. $url");
    //         redirect(base_url() . "index.php/home");
    //         return;
    //     } else {
    //         $this->session->set_flashdata("message", "Order passed. Case Pending with mandal for parition Map Correction");           
    //     }

    //     if($occup->dag_no == $new_dag)
    //     {
    //         $ok = $this->autoUpdate_fulldag_field($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $petition_no, $dag_no);
    //     }
    //     else
    //     {
    //         $ok = $this->autoUpdateForField($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $petition_no, $dag_no);
    //         if ($ok != true)
    //         {
    //            $this->db->trans_rollback();
    //            $this->session->set_flashdata('message', "Chitha Could not be updated. Please try Again. Error Code(#FPFINAL001)");
    //            log_message("error","##FPFINAL001 unable to update chitha from autoUpdate dist:"
    //                     .$dist_code.", case: ". $case_no);
    //            redirect(base_url() . "index.php/home");
    //            return;                
    //         }
    //         $order_date = date('Y-m-d');
    //         $q = "update field_mut_basic set order_passed='y',date_of_order='$order_date' where 
    //              case_no='$case_no' ";
    //         $this->db->query($q);
    //         if ($this->db->affected_rows() <=0)
    //         {
    //            $this->db->trans_rollback();
    //            $this->session->set_flashdata('message', "Chitha Could not be updated. Please try Again. Error Code(#FPFINAL002)");
    //            log_message("error","##FPFINAL002 unable to update chitha from autoUpdate dist:"
    //                     .$dist_code.", case: ". $case_no);
    //            redirect(base_url() . "index.php/home");
    //            return;                   
    //         }

    //         $q = "update t_chitha_col8_order set order_passed='y',date_of_order='$order_date'
    //               where case_no='$case_no' ";
    //         $this->db->query($q);
    //         if ($this->db->affected_rows() <=0)
    //         {
    //            $this->db->trans_rollback();
    //            $this->session->set_flashdata('message', "Chitha Could not be updated. Please try Again. Error Code(#FPFINAL003)");
    //            log_message("error","##FPFINAL003 unable to update chitha from autoUpdate dist:"
    //                     .$dist_code.", case: ". $case_no);
    //            redirect(base_url() . "index.php/home");
    //            return;                   
    //         }
    //     }

    //     if ($ok) {
    //         $this->db->trans_commit();
    //         //////////
    //         $this->DashboardDataFinal($case_no);
    //         ///////
    //         $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
    //         if($basundhara){
    //             $rmk='Order passed';
    //             $status='F';
    //             $task='CO';
    //             $pen='NA';
    //             $case=$case_no;
    //             $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
    //         }           
    //         //////////////////////////////////
    //         $this->session->set_flashdata('message', "Order for Case No $case_no Successfully Saved.");
    //         $this->session->set_flashdata('message', "Chitha Has Been Updated");
    //         //////////////JamaBandi Update///////////////////
    //         $location = array(
    //                 'd'=> $dist_code,
    //                 's' => $subdiv_code,
    //                 'c' => $cir_code,
    //                 'm' => $mouza_pargona_code,
    //                 'l' => $lot_no,
    //                 'v' => $vill_townprt_code,
    //             );
    //         //var_dump($location);
    //         $this->session->set_userdata(array('loc' => $location));
    //         // echo $patta_no."-".$patta_type_code;
    //         // exit;
    //         $popUpmsg="<h4>Order for Case No $case_no Successfully Saved.Chitha has been Updated !!! Updating JamaBandi Now<h4>";
    //         $msgggg= "<script type='text/javascript'>alert(' " .$popUpmsg ." ');</script>";
    //         //echo $msgggg;

    //         redirect('JamaBandi/step3/' .$patta_no .'/'. $patta_type_code);
    //         //redirect(base_url() . "index.php/home");
    //     } else {
    //         $this->db->trans_rollback();
    //         $this->session->set_flashdata('message', "Chitha Could not be updated for case no $case_no.Contact Helpdesk with case no");
    //         redirect(base_url() . "index.php/home");
    //     }
    // } 
    public function saveOccupantPartitionOrder()
    {
        $db = $this->session->userdata('db');
        $this->db->trans_begin();
        $dist_code = $this->session->userdata('dist_code');
        $cir_code = $this->session->userdata('cir_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $mouza_pargona_code1 = $this->input->post('mouza_pargona_code');
        $lot_no1 = $this->input->post('lot_no');
        $vill_townprt_code1 = $this->input->post('vill_townprt_code');

        $case_no = $this->input->post('case_no');
        $new_dag = $this->input->post('sugg_dag_no');
        $new_patta = $this->input->post('sugg_patta_no');
        $dag_revenue = $this->input->post('dag_revenue');
        $dag_local_tax = $this->input->post('dag_local_tax');
        $bigha = $this->input->post('bigha_applied');
        $katha = $this->input->post('katha_applied');
        $lessa = $this->input->post('lessa_applied');
        $date = date('Y-m-d');
        $occup_query = "select mp.dist_code,mp.subdiv_code,mp.cir_code,mp.mouza_pargona_code,mp.lot_no,mp.vill_townprt_code,"
            . "mp.pdar_id,mp.year_no,mp.petition_no,mp.pdar_add1,mp.pdar_add2,mp.pdar_name,mp.pdar_guardian,mp.pdar_rel_guar,"
            . "dd.patta_no,dd.patta_type_code,mp.pdar_dag_por_b,mp.pdar_dag_por_k,mp.pdar_dag_por_lc,dd.dag_no from   "
            . "field_part_petitioner mp,field_mut_dag_details dd where mp.cir_code=dd.cir_code and mp.case_no = dd.case_no "
            . "and mp.case_no='$case_no' and mp.cir_code ='$cir_code' and mp.subdiv_code='$subdiv_code' and mp.mouza_pargona_code = '$mouza_pargona_code1' "
            . "and mp.lot_no = '$lot_no1' and mp.vill_townprt_code = '$vill_townprt_code1' limit 1";

        $petitioner_save = $this->db->query($occup_query);
        if ($petitioner_save == null || $petitioner_save->num_rows() <= 0) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "Could not get petitioner details. Error Code(#FPPET001)");
            log_message("error", "#ERR001 Nill petition from field_part_petitioner for dist:" . $dist_code . ", case: " . $case_no);
            redirect(base_url() . "index.php/home");
            return;
        }
        $petitioner_save = $petitioner_save->row();
        $occup_data = "select * from   field_part_petitioner where case_no='$case_no' and mouza_pargona_code = '$mouza_pargona_code1' "
            . "and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1' and $this->base_query";
        $occup_data = $this->db->query($occup_data);
        if ($occup_data == null || $occup_data->num_rows() <= 0) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "Could not get petitioner details. Error Code(#FPPET002)");
            log_message("error", "#ERR002 Nill petition from field_part_petitioner for dist:" . $dist_code . ", case: " . $case_no);
            redirect(base_url() . "index.php/home");
            return;
        }
        $occup_data = $occup_data->result();

        $get_mut_type = $this->db->query("Select mut_type as mut_type from   field_mut_basic where case_no='$case_no' and mouza_pargona_code = '$mouza_pargona_code1' "
            . "and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1' and $this->base_query")->row()->mut_type;

        //Field Partition
        if ($get_mut_type == '02') {
            $new_pattadar = 'N';
            $sql = "Select patta_type_code,dag_no from field_mut_dag_details where case_no='$case_no' ";
            $dd = $this->db->query($sql);
            if ($dd == null || $dd->num_rows() <= 0) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Could not get petitioner details. Error Code(#FPMDD001)");
                log_message("error", "#ERR003 Nill petition from field_mut_dag_details for dist:" . $dist_code . ", case: " . $case_no);
                redirect(base_url() . "index.php/home");
                return;
            }
            $dd = $dd->row();

            $pp_code = $dd->patta_type_code;
            $old = $dd->dag_no;
            $sql = "Select count(*) as d from chitha_basic where mouza_pargona_code = '$mouza_pargona_code1' "
                . "and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1' and $this->base_query and dag_no='$new_dag' and dag_no!='$old' ";
            $count = $this->db->query($sql)->row()->d;
            if ($count != null && $count > 0) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "The Dag no you have given already exist ! Please re-verify the dag no 
                        again (#FPCB001)");
                log_message("error", "#ERR004 Nill petition from chitha_basic for dist:" . $dist_code . ", case: " . $case_no);
                redirect(base_url() . "index.php/home");
                return;
            }
            $sql = "Select count(*) as c from chitha_pattadar where mouza_pargona_code = '$mouza_pargona_code1' "
                . "and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1' and $this->base_query and patta_no='$new_patta' and patta_type_code='$pp_code' ";
            $count = $this->db->query($sql)->row()->c;
            if ($count != null && $count > 0) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "The patta no you have selected already exist pattadar !");
                log_message("error", "#ERR004 Nill petition from field_part_petitioner for dist:" . $dist_code . ", case: " . $case_no);
                redirect(base_url() . "index.php/home");
                return;
            }
        } else {
            $new_pattadar = '';
        }

        //var_dump($occup_data);
        foreach ($occup_data as $occup) {
            //var_dump($occup);
            $t_chitha_col8_occup = array(
                'dist_code' => $occup->dist_code,
                'subdiv_code' => $occup->subdiv_code,
                'cir_code' => $occup->cir_code,
                'mouza_pargona_code' => $occup->mouza_pargona_code,
                'lot_no' => $occup->lot_no,
                'vill_townprt_code' => $occup->vill_townprt_code,
                'dag_no' => $occup->dag_no,//$new_dag, //should be the new dag
                'year_no' => $occup->year_no,
                'petition_no' => $occup->petition_no,
                'occupant_id' => $occup->pdar_cron_no,
                'patta_type_code' => $occup->patta_type_code,
                'patta_no' => $occup->patta_no,//$new_patta,  //should be the new patta no
                'pdar_id' => $occup->pdar_id,
                'occupant_name' => $occup->pdar_name,
                'occupant_fmh_name' => $occup->pdar_guardian,
                'occupant_fmh_flag' => $occup->pdar_rel_guar,
                'occupant_add1' => $occup->pdar_add1,
                'occupant_add2' => $occup->pdar_add2,
                'land_area_b' => $occup->pdar_dag_por_b,
                'land_area_k' => $occup->pdar_dag_por_k,
                'land_area_lc' => $occup->pdar_dag_por_lc,
                'land_area_g' => '0',
                'land_area_kr' => '0',
                'old_patta_no' => $occup->patta_no,
                'new_patta_no' => $new_patta,
                'old_dag_no' => $occup->dag_no,
                'new_dag_no' => $new_dag,
                'new_pattadar' => $new_pattadar,
                'revenue' => $dag_revenue
            );
            //var_dump($t_chitha_col8_occup);
            $tstatus1 = $this->db->insert("t_chitha_col8_occup", $t_chitha_col8_occup); //****************************
            if ($tstatus1 != 1) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#FPTCCOC001)");
                log_message("error", "#FPTCCOC001 Nill petition from t_chitha_col8_occup for dist:"
                    . $dist_code . ", case: " . $case_no);
                redirect(base_url() . "index.php/home");
            }
            // ////////////Set Patta For JamaUpdation 14/10/2020/////////////////
            $patta_no = $new_patta;
            $patta_type_code = $occup->patta_type_code;
            // ////////////////////////////
        }
        //TO BE CLARIFIED
        $final_data = $this->session->userdata('final_order');

        if ($final_data == null || $final_data == '') {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "Please verify the Dag no and Patta no that you have selected !");
            log_message("error", "#ERR005 Empty final data for dist:" . $dist_code . ", case: " . $case_no);
            redirect(base_url() . "index.php/home");
            return;
        }

        foreach ($final_data as $fd) {
            if ($fd['case_no'] != $case_no) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#FPTCDUPO001)");
                log_message("error", "#FPTCDUPO001 unable to insert into t_chitha_col8_order for dist:"
                    . $dist_code . ", case: " . $case_no);
                redirect(base_url() . "index.php/home");
                return;
            }
            unset($fd['sugg_pno']);
            unset($fd['not_consistent']);
            $fd['mut_land_area_b'] = $bigha;
            $fd['mut_land_area_k'] = $katha;
            $fd['mut_land_area_lc'] = $lessa;
            $fd['min_revenue'] = $dag_revenue;
            //var_dump($fd);
            $tstatus2 = $this->db->insert("t_chitha_col8_order", $fd); //****************************
            if ($tstatus2 != 1) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#FPTCO002)");
                log_message("error", "#FPTCO002 unable to insert into t_chitha_col8_order for dist:"
                    . $dist_code . ", case: " . $case_no);
                redirect(base_url() . "index.php/home");
                return;
            }
        }
        $dist_code = $petitioner_save->dist_code;
        $subdiv_code = $petitioner_save->subdiv_code;
        $cir_code = $petitioner_save->cir_code;
        $mouza_pargona_code = $petitioner_save->mouza_pargona_code;
        $lot_no = $petitioner_save->lot_no;
        $vill_townprt_code = $petitioner_save->vill_townprt_code;
        $dag_no = $petitioner_save->dag_no;
        $petition_no = $petitioner_save->petition_no;

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $db_debug = $this->db->db_debug;
            $this->db->db_debug = TRUE;
            //echo $this->db->_error_message();
            $this->db->db_debug = $db_debug;
            $url = "<a href='cofieldmutation/pendingmaps' class='text-success'>Kindly Click Here to Remove Temporary Data </a>";
            $this->session->set_flashdata("message", "Order Cannot be passed. Error Code [T-TABLE_HAS_DATA] . Contact help desk with case no. $url");
            redirect(base_url() . "index.php/home");
            return;
        } else {
            $this->session->set_flashdata("message", "Order passed. Case Pending with mandal for parition Map Correction");
        }

        if ($occup->dag_no == $new_dag) {
            $ok = $this->autoUpdate_fulldag_field($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $petition_no, $dag_no);
            $this->jamabandiAutoUpdateModel->jamaCheckToDeleteorNot(
                $dist_code,
                $subdiv_code,
                $cir_code,
                $mouza_pargona_code,
                $lot_no,
                $vill_townprt_code,
                $occup->dag_no,
                $this->input->post('old_patta'),
                $this->input->post('patta_code')
            );
        } else {
            $ok = $this->autoUpdateForField($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $petition_no, $dag_no);
            if ($ok != true) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Chitha Could not be updated. Please try Again. Error Code(#FPFINAL001)");
                log_message("error", "##FPFINAL001 unable to update chitha from autoUpdate dist:"
                    . $dist_code . ", case: " . $case_no);
                redirect(base_url() . "index.php/home");
                return;
            }

            $order_date = date('Y-m-d');
            $q = "update field_mut_basic set order_passed='y',date_of_order='$order_date' where 
                     case_no='$case_no' ";
            $this->db->query($q);
            if ($this->db->affected_rows() <= 0) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Chitha Could not be updated. Please try Again. Error Code(#FPFINAL002)");
                log_message("error", "##FPFINAL002 unable to update chitha from autoUpdate dist:"
                    . $dist_code . ", case: " . $case_no);
                redirect(base_url() . "index.php/home");
                return;
            }

            $q = "update t_chitha_col8_order set order_passed='y',date_of_order='$order_date'
                      where case_no='$case_no' ";
            $this->db->query($q);
            if ($this->db->affected_rows() <= 0) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Chitha Could not be updated. Please try Again. Error Code(#FPFINAL003)");
                log_message("error", "##FPFINAL003 unable to update chitha from autoUpdate dist:"
                    . $dist_code . ", case: " . $case_no);
                redirect(base_url() . "index.php/home");
                return;
            }
        }

        if ($ok) {

            //autoupdate jamabandi starts here for old patta
            $this->db->trans_commit();
            $this->load->model('jamabandi/jamabandiAutoUpdateModel');
            //if($occup->dag_no != $new_dag){
            //echo $this->input->post('old_patta');
            //echo $this->input->post('patta_code');
            $jamaUpdate = $this->jamabandiAutoUpdateModel->updateJamabandi(
                $this->input->post('old_patta'),
                $this->input->post('patta_code'),
                $dist_code,
                $subdiv_code,
                $cir_code,
                $mouza_pargona_code,
                $lot_no,
                $vill_townprt_code,
                $case_no
            );

            // echo $patta_no;
            // die;
            //}

            // if($jamaUpdate != 1){
            //     $this->db->trans_rollback();
            //     log_message("error"," #NDAUC008: Issue occured in updating Jamabandi for case no: ". $misc_case_no);            
            //     $this->session->set_flashdata('message',"#NDAUC008: Final Submission failed for case no : ".$misc_case_no);
            //     redirect(base_url() . "index.php/home");
            //     return false;    
            // }
            //autoupdate jamabandi ends here

            //////////
            $this->DashboardDataFinal($case_no);
            ///////
            $basundhara = $this->basundharamodel->checkExistBasundhar($case_no);
            if ($basundhara) {
                $rmk = 'Order passed';
                $status = 'F';
                $task = 'CO';
                $pen = 'NA';
                $case = $case_no;
                $this->basundharamodel->postApiBasundharaSec($case, $rmk, $status, $task, $pen);
            }

            //////////////////////////////////
            $this->session->set_flashdata('message', "Order for Case No $case_no Successfully Saved.");
            $this->session->set_flashdata('message', "Chitha Has Been Updated");
            //////////////JamaBandi Update///////////////////
            $location = array(
                'd' => $dist_code,
                's' => $subdiv_code,
                'c' => $cir_code,
                'm' => $mouza_pargona_code,
                'l' => $lot_no,
                'v' => $vill_townprt_code,
            );
            //var_dump($location);
            $this->session->set_userdata(array('loc' => $location));
            // echo $patta_no."-".$patta_type_code;
            // exit;
            $popUpmsg = "<h4>Order for Case No $case_no Successfully Saved.Chitha has been Updated !!! Updating JamaBandi Now<h4>";
            $msgggg = "<script type='text/javascript'>alert(' " . $popUpmsg . " ');</script>";
            //echo $msgggg;

            redirect('JamaBandi/step3/' . $patta_no . '/' . $patta_type_code);
            //redirect(base_url() . "index.php/home");
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "Chitha Could not be updated for case no $case_no.Contact Helpdesk with case no");
            redirect(base_url() . "index.php/home");
        }
    }

    /* This is for Chitha Updation from T_TABLES for full dag partition case final button submission */
    public function autoUpdate_fulldag_field(
        $dist_code,
        $subdiv_code,
        $cir_code,
        $mouza_pargona_code,
        $lot_no,
        $vill_code,
        $petition_no,
        $dag_no
    ) {

        $locationData = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'lot_no' => $lot_no,
            'vill_code' => $vill_code,
            'mouza_pargona_code' => $mouza_pargona_code,
        );

        $year_no = year_no;
        $col8order_cron_no = $this->db->query("select max(col8order_cron_no)+1 as cron_no from   chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
            . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
            . "vill_townprt_code='$vill_code' and dag_no='$dag_no'")->row()->cron_no;
        //echo "select max(col8order_cron_no)+1 as cron_no from   chitha_col8_order";           
        if ($col8order_cron_no == null) {
            $col8order_cron_no = 1;
        }
        $t_order_data_query = "select * from   t_chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
            . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
            . "vill_townprt_code='$vill_code' and petition_no=$petition_no and dag_no='$dag_no' and iscorrected_inco is null";
        //echo $t_order_data_query;           
        $t_data_order = $this->db->query($t_order_data_query);
        if ($t_data_order == null || $t_data_order->num_rows() <= 0) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "FPTCO007: Unable to pass order !");
            log_message("error", "#FPTCO007 No detail available in t_chitha_col8_order for dist:" . $dist_code . ", petition no: " . $petition_no);
            redirect(base_url() . "index.php/home");
            return;
        }

        $t_data_order = $t_data_order->result();
        $i = 1;
        $case_no = null;
        foreach ($t_data_order as $ord) {
            $case_no = $ord->case_no;
            log_message("error", "MPR:****************************: count=" . $i++);
            $data_order = array();
            foreach ($ord as $key => $value) {
                $data[$key] = $value;
            }
            //var_dump($data);
            $data['col8order_cron_no'] = $col8order_cron_no;
            $data['user_code'] = $this->user_code;
            $data['date_entry'] = date('Y-m-d G:i:s');
            $data['operation'] = date('E');
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
            $tstatus11 = $this->db->insert("chitha_col8_order", $data); //*************************

            if ($tstatus11 != 1) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "FPCC008: Unable to pass order !");
                log_message("error", "#FPCC008 Insertion failed in chitha_col8_order for dist: "
                    . $dist_code . ", petition no: " . $petition_no);
                redirect(base_url() . "index.php/home");
                return;
            }

            $update_query = "update t_chitha_col8_order  set iscorrected_inco='Y',iscorrected_inco_date='$corrected' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                . "vill_townprt_code='$vill_code' and petition_no=$petition_no and  dag_no='$dag_no' and iscorrected_inco is null";
            $this->db->query($update_query); //************************

            if ($this->db->affected_rows() <= 0) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "FPTCC009: Unable to pass order !");
                log_message("error", "#FPTCC009 Updation failed in t_chitha_col8_order for dist: " . $dist_code . ", petition no: " . $petition_no);
                redirect(base_url() . "index.php/home");
                return;
            }

            $t_occup_query = "select * from   t_chitha_col8_occup where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                . "vill_townprt_code='$vill_code' and petition_no=$petition_no and dag_no='$dag_no' "
                . " and iscorrected_inco is null";
            //echo $t_occup_query;

            $t_occup_data = $this->db->query($t_occup_query);
            if ($t_occup_data == null || $t_occup_data->num_rows() <= 0) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "FPTCC010: Unable to pass order !");
                log_message("error", "#FPTCC010 Data not available in t_chitha_col8_occup for dist:" . $dist_code . ", petition no: " . $petition_no);
                redirect(base_url() . "index.php/home");
                return;
            }
            $chitha_update = 0;
            $t_occup_data = $t_occup_data->result();
            //var_dump($t_occup_data);

            $chitha_basic_update = FALSE;
            foreach ($t_occup_data as $occ) {
                //var_dump($occ);
                if ($chitha_update == 0) {
                    // $sql = "update chitha_basic set jama_yn=null, patta_no = '$occ->new_patta_no', old_patta_no = '$occ->patta_no'"
                    //         . " where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                    //         . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                    //         . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                    //         . " and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->patta_no') and"
                    //         . " patta_type_code='$occ->patta_type_code' ";

                    // $this->db->query($sql); //****************
                    $table = 'chitha_basic';

                    $params = [
                        'jama_yn' => null,
                        'patta_no' => $occ->new_patta_no,
                        'old_patta_no' => $occ->patta_no,
                    ];

                    $where = [
                        'dist_code' => $occ->dist_code,
                        'subdiv_code' => $occ->subdiv_code,
                        'cir_code' => $occ->cir_code,
                        'mouza_pargona_code' => $occ->mouza_pargona_code,
                        'lot_no' => $occ->lot_no,
                        'vill_townprt_code' => $occ->vill_townprt_code,
                        'dag_no' => $occ->dag_no,
                        'patta_no' => trim($occ->patta_no),  // trim to mimic SQL TRIM()
                        'patta_type_code' => $occ->patta_type_code,
                    ];

                    // Then call your model update method:
                    $result3 = $this->Chitha_basic_model->update_table($table, $params, $where);

                    //log_message("error","MPR: AFFECTED ROWS: ".$this->db->affected_rows());
                    if ($result3 <= 0) {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "FPCB011: Unable to pass order !");
                        log_message("error", "#FPCB011 Updation failed in chitha_basic for dist: " . $dist_code . ", petition no: " . $petition_no . " Query:" . $this->db->affected_rows());
                        redirect(base_url() . "index.php/home");
                        return;
                    }
                    $chitha_update = 1;
                }

                //$this->db->trans_begin();
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
                $data['user_code'] = $this->user_code;
                $data['date_entry'] = date('Y-m-d G:i:s');
                $data['operation'] = date('E');
                $occupData = $data;
                //var_dump($data);
                $tstatus12 = $this->db->insert("chitha_col8_occup", $data); // ******************

                if ($tstatus12 != 1) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "FPCCO012: Unable to pass order !");
                    log_message("error", "#FPCCO012 Insertion failed in chitha_col8_occup for dist:" . $dist_code . ", petition no: " . $petition_no);
                    redirect(base_url() . "index.php/home");
                    return;
                }

                $dag_pattadar = array();
                $chitha_pattadar = array();

                $pdar_id = null;

                if ($ord->order_type_code == '02') {
                    $pdar_id = $this->db->query("select max(cast(pdar_id as int))+1 as pdar_id from   chitha_pattadar where dist_code='$dist_code' and "
                        . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and"
                        . " mouza_pargona_code='$mouza_pargona_code' and "
                        . " vill_townprt_code='$vill_code' and TRIM(patta_no)=trim('$occ->patta_no')  "
                        . " ")->row()->pdar_id;

                } else {

                    $pdar_id = $this->db->query("select max(cast(pdar_id as int))+1 as pdar_id from   chitha_pattadar where dist_code='$dist_code' and "
                        . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and"
                        . " mouza_pargona_code='$mouza_pargona_code' and "
                        . " vill_townprt_code='$vill_code' and TRIM(patta_no)=trim('$occ->patta_no')  "
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
                    $dag_pattadar['pdar_id'] = $occ->pdar_id;
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

                $dag_pattadar['user_code'] = $this->user_code;
                $dag_pattadar['date_entry'] = date('Y-m-d G:i:s');
                $dag_pattadar['operation'] = date('E');

                $chitha_pattadar['dist_code'] = $dist_code;
                $chitha_pattadar['subdiv_code'] = $subdiv_code;
                $chitha_pattadar['cir_code'] = $cir_code;
                $chitha_pattadar['lot_no'] = $lot_no;
                $chitha_pattadar['mouza_pargona_code'] = $mouza_pargona_code;
                $chitha_pattadar['vill_townprt_code'] = $vill_code;

                $chitha_pattadar['pdar_id'] = $occ->pdar_id;
                $chitha_pattadar['new_pdar_name'] = $occ->new_pattadar;
                $chitha_pattadar['patta_type_code'] = $occ->patta_type_code;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_father'] = $occ->occupant_fmh_name;
                $chitha_pattadar['pdar_add1'] = $occ->occupant_add1;
                $chitha_pattadar['pdar_add2'] = $occ->occupant_add2;
                $chitha_pattadar['pdar_add3'] = $occ->occupant_add3;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_guard_reln'] = $occ->occupant_fmh_flag;
                $chitha_pattadar['user_code'] = $this->user_code;
                $chitha_pattadar['date_entry'] = date('Y-m-d G:i:s');
                $chitha_pattadar['operation'] = date('E');
                $chitha_pattadar['jama_yn'] = 'N';
                //var_dump($chitha_pattadar);
                //var_dump($dag_pattadar);
                $chitha_basic_query = "select land_class_code from   chitha_basic "
                    . "where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                    . " cir_code='$cir_code' and lot_no='$lot_no' and"
                    . " mouza_pargona_code='$mouza_pargona_code' and TRIM(patta_no)=trim('$occ->new_patta_no') and"
                    . " patta_type_code='$occ->patta_type_code' and dag_no='$dag_no'";
                //echo($chitha_basic_query);
                $result = $this->db->query($chitha_basic_query);
                if ($result == null || $result->num_rows() <= 0) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "FPLCCO013: Unable to pass order !");
                    log_message("error", "#FPLCCO013 Data not available in land_class_code for dist:"
                        . $dist_code . ", petition no: " . $petition_no);
                    redirect(base_url() . "index.php/home");
                    return;
                }
                $result = $result->row();
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
                $chitha_basic['user_code'] = $this->user_code;
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
                    if ($this->db->affected_rows() <= 0) {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "FPCCO014: Unable to pass order !");
                        log_message("error", "#FPCCO014 Updation failed in chitha_col8_order for dist:"
                            . $dist_code . ", petition no: " . $petition_no);
                        redirect(base_url() . "index.php/home");
                        return;
                    }


                } else {
                    $chitha_basic['dag_no'] = $dag_no;

                    $q = "select dag_no_int as dag_no_int from   chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'" .
                        " and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$occ->patta_type_code' and TRIM(patta_no)=trim('$occ->patta_no')";

                    $dag_no_int = $this->db->query($q)->row()->dag_no_int;

                    $chitha_basic['dag_no_int'] = $dag_no_int;
                    $chitha_basic['patta_no'] = trim($occ->patta_no);
                }
                $chitha_basic['patta_type_code'] = $occ->patta_type_code;

                $chitha_basic['operation'] = "E";
                //var_dump($chitha_basic);
                //var_dump($dag_pattadar);
                $corrected = date('Y-m-d G:i:s');
                if ((!$chitha_basic_update) && ($ord->order_type_code == '02')) {

                    $chitha_basic_update = TRUE;
                    // $update_for_old_jama="Update chitha_basic set jama_yn=null where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                    //         . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                    //         . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                    //         . " and TRIM(patta_no)=trim('$occ->patta_no') and"
                    //         . " patta_type_code='$occ->patta_type_code' ";

                    // $this->db->query($update_for_old_jama); //*******************
                    // if($this->db->affected_rows() <= 0 )
                    // {
                    //     $this->db->trans_rollback();
                    //     $this->session->set_flashdata('message', "FPCBO015: Unable to pass order !");
                    //     log_message("error","#FPCBO015 Failed to update jama_yn=null in chitha_basic for dist:"
                    //                 .$dist_code.", petition no: ". $petition_no);
                    //     redirect(base_url() . "index.php/home");
                    //     return;
                    // }

                    $sql = "select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,dag_revenue from chitha_basic where"
                        . "  dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                        . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                        . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                        . " and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->new_patta_no') and"
                        . " patta_type_code='$occ->patta_type_code' ";
                    //echo $sql;
                    $data = $this->db->query($sql)->row();

                    if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {

                        $chitha_basic['dag_revenue'] = $ord->min_revenue * (($ord->mut_land_area_b * 6400 + $ord->mut_land_area_k * 320 + $ord->mut_land_area_lc * 20 + $ord->mut_land_area_g) / 6400.0);
                        $chitha_basic['dag_local_tax'] = $chitha_basic['dag_revenue'] / 4.0;
                        //$this->db->insert('chitha_basic', $chitha_basic); //********************************* not required

                        $dataNew['dag_no'] = $chitha_basic['dag_no'];

                        $sourcelessa = $data->dag_area_b * 6400 + $data->dag_area_k * 320 + $data->dag_area_lc * 20 + $data->dag_area_g;
                        $mutationlessa = $ord->mut_land_area_b * 6400 + $ord->mut_land_area_k * 320 + $ord->mut_land_area_lc * 20 + $ord->mut_land_area_g;
                        $sourcelessa;
                        $mutationlessa;
                        $remaining_lessa = $sourcelessa - $mutationlessa;


                        $left_b = floor($remaining_lessa / 6400);
                        $left_k = floor(($remaining_lessa - $left_b * 6400) / 320);
                        $left_lc = floor(($remaining_lessa - $left_b * 6400 - $left_k * 320) / 20);
                        $left_g = $remaining_lessa - $left_b * 6400 - $left_k * 320 - $left_lc * 20;
                        $left_kr = 0;
                    } else {
                        $chitha_basic['dag_revenue'] = $ord->min_revenue * (($ord->mut_land_area_b * 100 + $ord->mut_land_area_k * 20 + $ord->mut_land_area_lc) / 100.0);
                        $chitha_basic['dag_local_tax'] = $chitha_basic['dag_revenue'] / 4.0;
                        //$this->db->insert('chitha_basic', $chitha_basic); //********************************* not required

                        $dataNew['dag_no'] = $chitha_basic['dag_no'];

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
                    }
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
                    //$this->db->last_query();
                    $table = 'chitha_basic';

                    $params = [
                        'jama_yn' => null,
                        'dag_revenue' => $dag_revenue_updates,
                        'dag_local_tax' => $dag_local_tax_update,
                        'dag_area_b' => $ord->mut_land_area_b,
                        'dag_area_k' => $ord->mut_land_area_k,
                        'dag_area_lc' => $ord->mut_land_area_lc,
                        'dag_area_g' => $left_g,
                        'dag_area_kr' => $left_kr,
                        'date_entry' => $d,
                        'operation' => 'M',
                    ];

                    $where = [
                        'dist_code' => $occ->dist_code,
                        'subdiv_code' => $occ->subdiv_code,
                        'cir_code' => $occ->cir_code,
                        'mouza_pargona_code' => $occ->mouza_pargona_code,
                        'lot_no' => $occ->lot_no,
                        'vill_townprt_code' => $occ->vill_townprt_code,
                        'dag_no' => $occ->dag_no,
                        'patta_no' => trim($occ->new_patta_no),  // Trim here to mimic SQL TRIM()
                        'patta_type_code' => $occ->patta_type_code,
                    ];

                    // Call your model's update method
                    $result4 = $this->Chitha_basic_model->update_table($table, $params, $where);


                    if ($result4 <= 0) {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "FPCBO016: Unable to pass order !");
                        log_message("error", "#FPCBO016 Failed to update jama_yn=null in chitha_basic for dist:"
                            . $dist_code . ", petition no: " . $petition_no);
                        redirect(base_url() . "index.php/home");
                        return;
                    }
                }
                $p_id = $occ->pdar_id;
                $q = "select count(*) as count from   chitha_dag_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                    . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                    . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                    . " and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->patta_no') and"
                    . " patta_type_code='$occ->patta_type_code'";// and pdar_id=$p_id";
                //echo $q;
                $cDagPattadarExists = $this->db->query($q)->row()->count;

                $q = "select count(*) as count from   chitha_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                    . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                    . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                    . " and TRIM(patta_no)=trim('$occ->new_patta_no') and"
                    . " patta_type_code='$occ->patta_type_code' and pdar_id=$p_id";
                //echo $q;
                $cPattadarExists = $this->db->query($q)->row()->count;

                $occ->new_pattadar;

                //update chitha_dag_pattadar
                // $update_pattadar = "Update chitha_dag_pattadar set patta_no='$occ->new_patta_no', p_flag = null,jama_yn='n' where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                //         . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                //         . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                //         . " and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->patta_no') and"
                //         . " patta_type_code='$occ->patta_type_code' and pdar_id=$p_id ";
                // //echo $update_pattadar;
                // $this->db->query($update_pattadar); //*******************
                //insert in chitha_pattadar

                $table = 'chitha_dag_pattadar';

                $params = [
                    'patta_no' => $occ->new_patta_no,
                    'p_flag' => null,
                    'jama_yn' => 'n',
                ];

                $where = [
                    'dist_code' => $occ->dist_code,
                    'subdiv_code' => $occ->subdiv_code,
                    'cir_code' => $occ->cir_code,
                    'mouza_pargona_code' => $occ->mouza_pargona_code,
                    'lot_no' => $occ->lot_no,
                    'vill_townprt_code' => $occ->vill_townprt_code,
                    'dag_no' => $occ->dag_no,
                    'patta_no' => trim($occ->patta_no),
                    'patta_type_code' => $occ->patta_type_code,
                    'pdar_id' => $p_id,
                ];

                $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                if ($result <= 0) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "FPCDP017: Unable to pass order !");
                    log_message("error", "#FPCDP017 Updation failed in chitha_dag_pattadar for dist:"
                        . $dist_code . ", petition no: " . $petition_no);
                    redirect(base_url() . "index.php/home");
                    return;
                }

                if ($cPattadarExists == 0) {
                    $chitha_pattadar['f1_case_no'] = $case_no;
                    //var_dump ($chitha_pattadar);
                    // $tstatus_pat = $this->db->insert("chitha_pattadar", $chitha_pattadar); // ********************
                    $tstatus_pat = $this->Chitha_basic_model->insert_table('chitha_pattadar', $chitha_pattadar);
                    if ($tstatus_pat != 1) {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "#FPCP0017: Unable to pass order !");
                        log_message("error", "#FPCP0017 Failed to insert chitha_pattadar for dist:"
                            . $dist_code . ", petition no: " . $petition_no);
                        redirect(base_url() . "index.php/home");
                        return;
                    }
                }
                // exit;
                $today = date('Y-m-d');
                $t_occup_query = "update t_chitha_col8_occup set iscorrected_inco='Y',iscorrected_inco_date='$corrected',order_passed='Y' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                    . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                    . "vill_townprt_code='$vill_code' and petition_no=$petition_no and dag_no='$dag_no' ";
                $this->db->query($t_occup_query); // ********************
                if ($this->db->affected_rows() <= 0) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "FPTCC018: Unable to pass order !");
                    log_message("error", "#FPTCC018 Failed to update iscorrected_inco in t_chitha_col8_occup for dist:"
                        . $dist_code . ", petition no: " . $petition_no);
                    redirect(base_url() . "index.php/home");
                    return;
                }
            }

            // if (($ord->order_type_code == '01') || ($ord->order_type_code == '02')) {
            //     foreach ($t_inplace_data as $inplace) {
            //         $data = array();

            //         foreach ($inplace as $key => $value) {
            //             $data[$key] = $value;
            //         }
            //         unset($data['occupant_id']);
            //         unset($data['year_no']);
            //         unset($data['petition_no']);
            //         unset($data['occupant_name']);
            //         unset($data['occupant_fmh_name']);
            //         unset($data['occupant_fmh_flag']);
            //         unset($data['occupant_add1']);
            //         unset($data['occupant_add2']);
            //         unset($data['occupant_add3']);
            //         unset($data['old_patta_no']);
            //         unset($data['new_patta_no']);
            //         unset($data['old_dag_no']);
            //         unset($data['patta_type_code']);
            //         unset($data['patta_no']);
            //         unset($data['pdar_id']);
            //         unset($data['iscorrected_inco']);
            //         unset($data['iscorrected_inco_date']);
            //         unset($data['isdataposted_torkg_db']);
            //         unset($data['iscorrected_rkg_record']);
            //         unset($data['new_dag_no']);
            //         unset($data['order_passed']);
            //         unset($data['date_of_order']);
            //         unset($data['make_mdb']);
            //         unset($data['iscorrected_rkg_date']);
            //         unset($data['revenue']);
            //         unset($data['new_pattadar']);
            //         unset($data['hus_wife']);
            //         unset($data['revenue']);


            //         if ($data['fmute_strike_out'] == '1') {
            //             $data['inplaceof_alongwith'] = 'i';
            //         } else {
            //             $data['inplaceof_alongwith'] = 'a';
            //         }
            //         unset($data['fmute_strike_out']);
            //         $data['col8order_cron_no'] = $col8order_cron_no;
            //         $data['user_code'] = $this->user_code;
            //         $data['date_entry'] = date('Y-m-d G:i:s');
            //         $data['operation'] = date('E');
            //         // var_dump($data);
            //         $key = array(
            //             'dist_code' => $data['dist_code'],
            //             'subdiv_code' => $data['subdiv_code'],
            //             'cir_code' => $data['cir_code'],
            //             'mouza_pargona_code' => $data['mouza_pargona_code'],
            //             'lot_no' => $data['lot_no'],
            //             'vill_townprt_code' => $data['vill_townprt_code'],
            //             'dag_no' => $data['dag_no'],
            //             'col8order_cron_no' => $data['col8order_cron_no'],
            //             'inplace_of_id' => $data['inplace_of_id'],
            //         );

            //         $queryCheck = "select count(*) as c from   chitha_col8_inplace where dist_code='$data[dist_code]' and subdiv_code='$data[subdiv_code]' and cir_code='$data[cir_code]' and "
            //                 . " mouza_pargona_code='$data[mouza_pargona_code]' and lot_no='$data[lot_no]' and vill_townprt_code='$data[vill_townprt_code]' and dag_no='$data[dag_no]' and col8order_cron_no='$data[col8order_cron_no]' and "
            //                 . " inplace_of_id='$data[inplace_of_id]' ";
            //         $count = $this->db->query($queryCheck)->row()->c;
            //         if ($count <= 0)
            //         {
            //             //var_dump($data);
            //             $tstatus_in =$this->db->insert("chitha_col8_inplace", $data);
            //             if($tstatus_in != 1 )
            //             {
            //                 $this->db->trans_rollback();
            //                 $this->session->set_flashdata('message', "FPCCIN001: Unable to pass order !");
            //                 log_message("error","#FPCCIN001 Failed to insert chitha_col8_inplace for dist:"
            //                         .$dist_code.", petition no: ". $petition_no);
            //                 redirect(base_url() . "index.php/home");
            //                 return;
            //             }
            //         }

            //         $p_flag = '0';
            //         if ($inplace->fmute_strike_out == '1')
            //             $p_flag = '1';

            //         $update_query = "update chitha_dag_pattadar  set p_flag='$p_flag',jama_yn='n' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
            //                 . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
            //                 . "vill_townprt_code='$vill_code' and dag_no='$dag_no' and pdar_id=$inplace->pdar_id";
            //         //echo $update_query;
            //         $this->db->query($update_query);
            //         if($this->db->affected_rows() <= 0 )
            //         {
            //             $this->db->trans_rollback();
            //             $this->session->set_flashdata('message', "FPCDP019: Unable to pass order !");
            //             log_message("error","#FPCDP019 Failed to update p_flag in chitha_dag_pattadar for dist:".$dist_code.", petition no: ". $petition_no);
            //             redirect(base_url() . "index.php/home");
            //             return;
            //         }
            //         $corrected = date('Y-m-d G:i:s');
            //         $t_inplace_query = "update t_chitha_col8_inplace set iscorrected_inco='Y',iscorrected_inco_date='$corrected',order_passed='Y' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
            //                 . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
            //                 . "vill_townprt_code='$vill_code' and dag_no='$dag_no'";
            //         $this->db->query($t_inplace_query);
            //         if($this->db->affected_rows() <=0 )
            //         {
            //             $this->db->trans_rollback();
            //             $this->session->set_flashdata('message', "FPTCC020: Unable to pass order !");
            //             log_message("error","#FPTCC020 Failed to update iscorrected_inco in t_chitha_col8_inplace for dist:".$dist_code.", petition no: ". $petition_no);
            //             redirect(base_url() . "index.php/home");
            //             return;
            //         }

            //         $order_update_query = "update field_mut_basic set order_passed='Y' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
            //                 . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
            //                 . "vill_townprt_code='$vill_code' and petition_no=$petition_no";
            //         $this->db->query($order_update_query);
            //         if($this->db->affected_rows() <=0 )
            //         {
            //             $this->db->trans_rollback();
            //             $this->session->set_flashdata('message', "FPTMB021: Unable to pass order !");
            //             log_message("error","#FPTMB021 Failed to update order_passed in field_mut_basic for dist:".$dist_code.", petition no: ". $petition_no);
            //             redirect(base_url() . "index.php/home");
            //             return;
            //         }

            //     }
            // }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            //$this->db->trans_commit();
            $order_update_query = "update field_mut_basic set order_passed='Y' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                . "vill_townprt_code='$vill_code' and petition_no='$petition_no'";
            $this->db->query($order_update_query);
            if ($this->db->affected_rows() <= 0) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "FPFINAL001: Unable to pass order !");
                log_message("error", "#FPFINAL001 Failed to update order_passed in field_mut_basic for dist:"
                    . $dist_code . ", petition no: " . $petition_no);
                redirect(base_url() . "index.php/home");
                return;
            }
            return true;
        }
    }

    ////////////END MPR: /////////////////
    public function getPendingPartitionCases()
    {

        $this->load->library('pagination');
        $db = $this->session->userdata('db');
        $append = $this->base_query1;
        $case_array = array();
        $searchKeyword = null;
        if ($this->input->post('submitSearch')) {
            $inputKeywords = $this->input->post('searchKeyword');
            $searchKeyword = strip_tags($inputKeywords);
            if (!empty($searchKeyword)) {
                $this->session->set_userdata('searchKeyword', $searchKeyword);
            } else {
                $this->session->unset_userdata('searchKeyword');
            }
        } elseif ($this->input->post('submitSearchReset')) {
            $this->session->unset_userdata('searchKeyword');
        }

        $cases['searchKeyword'] = $this->session->userdata('searchKeyword');
        $config['base_url'] = base_url() . 'index.php/cofieldmutation/getPendingPartitionCases';
        $config['total_rows'] = $this->cofieldmutationmodel->count_getPendingFPCases();
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
        $cases['cases'] = $this->cofieldmutationmodel->getPendingFPCases($config["per_page"], $page, $searchKeyword);
        foreach ($cases['cases'] as $rows) {

            // log_message("error","#6155: ==========".json_encode($rows));
            if ($rows->es_flag == '1' && ESCALATION_ENABLE == 1 && $rows->out_of_esc == 0) {

                $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
                // log_message('error', '#6159: Escalation details : '.json_encode($escRow));

                if (!empty($escRow) && $escRow != null) {

                    $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));
                    // log_message('error', '#6165: Escalation details : '.json_encode($escData)); 

                    if (!empty($escData) && $escData != null) {
                        $rows->escalation_date = $escData->escalation_date;
                        $rows->escalation_zone = $escData->escalation_zone;
                        $rows->assigned_date = $escData->assigned_date;
                    } else {
                        $rows->escalation_date = 'NA';
                        $rows->escalation_zone = 'NA';
                    }
                } else {
                    $rows->escalation_date = 'NA';
                    $rows->escalation_zone = 'NA';
                }
            } else {
                $rows->escalation_date = 'NA';
                $rows->escalation_zone = 'NA';
            }

            $link = base_url() . "index.php/cofieldmutation/write_report_lm?case_no=" . enc_param('case_no', $rows->case_no, 600) . "&dist_code=" . $rows->dist_code . "&subdiv_code=" . $rows->subdiv_code . "&cir_code=" . $rows->cir_code . "&mouza_pargona_code=" . $rows->mouza_pargona_code . "&lot_no=" . $rows->lot_no . "&vill_townprt_code=" . $rows->vill_townprt_code;

            if (ESCALATION_ENABLE == 1 && $rows->is_escalated == 1) {
                $button = "Escalated to Upper Officer";
            } else {
                $button = "<a href=" . $link . " class='btn btn-success'>" . $this->lang->line("write_report") . "</a>";
            }

            $mouza_lot = $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code) . "-" . $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no);
            $e = $rows->basundhara;
            $json[] = array(

                $rows->escalation_zone,
                $rows->escalation_date,

                $rows->case_no . "<br><span class='small font-italic red'>" . $e . "</span>",
                $mouza_lot,
                $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),
                date('M jS, Y', strtotime($rows->date_entry)),
                $button
            );
        }

        $cases['_view'] = 'comutation/cases';
        $this->load->view('layouts/main', $cases);
    }

    //added for escalation on 14-11-2023
    public function getPendingFieldMutationCases()
    {
        $this->dbswitch();
        $append = $this->base_query;
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $villageListNew = array();
        $villageList = $this->mutationmodel->getAllDistinctVillageListLotWise($append, $mouza_pargona_code, $lot_no);
        foreach ($villageList as $key => $value) {
            $villageListNew[$key]['village_code'] = $value->mouza_pargona_code . "-" . $value->lot_no . "-" . $value->vill_townprt_code;
            $villageListNew[$key]['vill_name'] = $this->utilityclass->getVillageName($value->dist_code, $value->subdiv_code, $value->cir_code, $value->mouza_pargona_code, $value->lot_no, $value->vill_townprt_code);
        }

        $uniqueVillage = array_map("unserialize", array_unique(array_map("serialize", $villageListNew)));
        $data['villageListNew'] = $uniqueVillage;

        $newMouzaList = array();
        foreach ($villageList as $key => $value) {
            $newMouzaList[$key]['mouza_code'] = $value->mouza_pargona_code;
            $newMouzaList[$key]['mouza_name'] = $this->utilityclass->getMouzaName($value->dist_code, $value->subdiv_code, $value->cir_code, $value->mouza_pargona_code);
            $newMouzaList[$key]['lot_name'] = $this->utilityclass->getLotName($value->dist_code, $value->subdiv_code, $value->cir_code, $value->mouza_pargona_code, $value->lot_no);
            $newMouzaList[$key]['lot_no'] = $value->lot_no;
        }

        $uniqueMouzaList = array_map("unserialize", array_unique(array_map("serialize", $newMouzaList)));
        $data['newMouzaList'] = $uniqueMouzaList;


        // $resume_query = "SELECT * from Petition_basic WHERE  status='F' AND comp_serv_yn is null and order_passed is null and ".$append."  order by date_entry desc";
        // $data['resume'] = $this->db->query($resume_query)->result();
        $data['_view'] = 'comutation/fieldmutcases';
        $this->load->view('layouts/main', $data);
    }




    //created for getting all the pending list at LM login circle wise---------
    public function getPendingFieldCaseLMend()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $draw = intval($this->input->post('draw'));
        $searchByCol_0 = $this->input->post('columns')[2]['search']['value'];
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        $mouza_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_mouza_code = $this->input->post('vill_mouza_code');
        $vill_lot_no = $this->input->post('vill_lot_no');
        $village_code = $this->input->post('village_code');
        $zone_status = $this->input->post('zone_status');
        // $define_date = define_date;

        if ($zone_status != null || $zone_status != '') {
            $results = $this->Escalationmodel->getPendingFieldMutCaseLMend($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $mouza_code, $lot_no, $vill_mouza_code, $vill_lot_no, $village_code, $searchByCol_0, $zone_status);
        } else {
            $results = $this->mutationmodel->getPendingFieldMutCaseLMend($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $mouza_code, $lot_no, $vill_mouza_code, $vill_lot_no, $village_code, $searchByCol_0);
        }


        // echo $this->db->last_query();

        if (isset($results)) {
            $data_rows = $results['data_results'];
            $total_records = $results['total_records'];

            if ($total_records > 0) {
                foreach ($data_rows as $rows) {

                    // var_dump($rows->es_flag); die;
                    // log_message("error","UTPAL001: ==========".json_encode($rows));
                    if ($rows->es_flag == '1' && ESCALATION_ENABLE == 1) {

                        $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
                        // echo $this->db->last_query();
                        // log_message('error', '#6233: Escalation details : '.json_encode($escRow));
                        if (!empty($escRow) && $escRow != null) {

                            $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->lm_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));

                            // log_message('error', '#6228: Escalation details : '.json_encode($escData)); 
                            if (!empty($escData) && $escData != null) {
                                $rows->escalation_date = $escData->escalation_date;
                                $rows->escalation_zone = $escData->escalation_zone;
                                $rows->assigned_date = $escData->assigned_date;
                            } else {
                                $rows->escalation_date = 'NA';
                                $rows->escalation_zone = 'NA';
                            }
                        } else {
                            $rows->escalation_date = 'NA';
                            $rows->escalation_zone = 'NA';
                        }
                    } else {
                        $rows->escalation_date = 'NA';
                        $rows->escalation_zone = 'NA';
                    }
                    if ($rows->is_multigeneration == 'M' || $rows->is_multigeneration == 'S') {
                        //showing from API=====
                        $link = base_url() . "index.php/rtps/inheritanceBasuMultiSingleGenEscalationV1?app=" . $rows->basundhara;
                    } else {
                        //showing from database========
                        $link = base_url() . "index.php/cofieldmutation/write_report_lm?case_no=" . enc_param('case_no', $rows->case_no, 600) . "&dist_code=" . $rows->dist_code . "&subdiv_code=" . $rows->subdiv_code . "&cir_code=" . $rows->cir_code . "&mouza_pargona_code=" . $rows->mouza_pargona_code . "&lot_no=" . $rows->lot_no . "&vill_townprt_code=" . $rows->vill_townprt_code;
                    }


                    if (ESCALATION_ENABLE == 1 && $rows->is_escalated == 1) {
                        $button = "Escalated to Upper Officer";
                    } else {
                        $button = "<a href=" . $link . " class='btn btn-success'>" . $this->lang->line("write_report") . "</a>";
                    }


                    $mouza_lot = $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code) . "-" . $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no);
                    $e = $rows->basundhara;
                    $json[] = array(

                        $rows->escalation_zone,
                        $rows->escalation_date,

                        $rows->case_no . "<br><span class='small font-italic red'>" . $e . "</span>",
                        $mouza_lot,
                        $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),
                        date('M jS, Y', strtotime($rows->date_entry)),
                        $button
                    );
                }
            } else {
                $json = "";
            }

            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json
            );
            echo json_encode($response);
        } else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }

    public function write_report_lm()
    {
        $_GET['case_no'] = dec_param($this->input->get('case_no'), 'case_no');
        if ($_GET['case_no'] == null) {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }
        $case_no = $this->input->get('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
        $lot_no1 = $this->input->get('lot_no');
        $vill_townprt_code1 = $this->input->get('vill_townprt_code');
        $data['case_no'] = $case_no;
        $sql = "Select * from field_mut_basic where case_no = '$case_no'";
        $data['fmb'] = $this->db->query($sql)->row_array();

        $sql = "Select * from field_mut_petitioner where case_no = '$case_no'";
        $data['applicant'] = $this->db->query($sql)->result_array();

        $sql11 = "Select * from field_mut_petitioner where case_no = ? and auth_type is not null";
        $petitioner = $this->db->query($sql11, array($case_no))->result();

        // echo $this->db->last_query();
        // exit;

        $data['selfDecData'] = json_decode($petitioner[0]->self_declaration);

        if ($petitioner[0]->auth_type != null) {
            $statusAadhar = "<i class='fa fa-check'></i> " . $petitioner[0]->auth_type . " Verified";
            $engName = $petitioner[0]->pdar_name_eng;
        } else {
            $statusAadhar = 'N/A';
            $engName = null;
        }
        $data['status'] = $statusAadhar;
        $data['engName'] = $engName;



        $application_no_sql = "select * from basundhar_application where dharitree='$case_no' ";
        $data['application'] = $this->db->query($application_no_sql)->row();

        $serviceType = explode('/', $data['application']->basundhara);
        $service_code = 1;

        if ($serviceType[1] == 'MUTD') {
            $service_code = '2';
        }

        $data['base64_decoded_adhar_file'] = "";

        if (!empty($petitioner) && $petitioner != null && trim($petitioner[0]->auth_type) == 'AADHAAR'):

            $adhar_photo_link = $petitioner[0]->photo;
            if ($adhar_photo_link == null) {
                $url = RTPS_API_LINK . "getApplicantPhoto";
                $arrayData = array(
                    'application_no' => $data['application']->basundhara,
                );
                //*****API call again for aadhar photo missing */
                $aadhaarPhotoReCall = $this->utilityclass->curlPost($url, $arrayData);


                if ($aadhaarPhotoReCall != 'n') {
                    $aadhaarPhotoDetails = json_decode($aadhaarPhotoReCall);
                    $aadhar_path = AADHAAR_UPLOAD_DIR . $petitioner[0]->id_ref_no . '.json';
                    $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file!");
                    $aadhaar_encoded_file = $aadhaarPhotoDetails->path;
                    fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                    fclose($aadhaar_file_to_write_base64);
                    $idRefNo = $petitioner[0]->id_ref_no;
                    $query = "update field_mut_petitioner set photo = '$aadhar_path' where case_no='$case_no' and id_ref_no = '$idRefNo' and auth_type is not null";
                    $this->db->query($query);

                    $adhar_photo_link = $aadhar_path;

                } else {
                    echo json_encode(array('ERROR885784: API Response fail!'));
                    return false;
                }


            }
            //**********reopening the updated file */
            // echo $adhar_photo_link;
            // exit;
            $open_adhar_file = fopen($adhar_photo_link, "r");
            $read_adhar_file = fread($open_adhar_file, filesize($adhar_photo_link));
            fclose($open_adhar_file);
            // decoding the base64 encoding file variable
            if (AADHAAR_DOC_ENV == 'PROD') {
                $data['base64_decoded_adhar_file'] = "<img src = data:" . $this->decodeBase64($read_adhar_file) . ";base64," . $read_adhar_file . " class='img-thumbnail mrl' alt='Aadhaar Photo' width='170' height='200'>";
            } else {
                $data['base64_decoded_adhar_file'] = "<img src ='' alt='local-test' class='img-thumbnail mrl' alt='Aadhaar Photo' width='170' height='200'>";
            }
        endif;
        $sql = "Select *,CASE
              WHEN striked_out='1' then 'Inplace Of'
              when striked_out='0' then 'Alongwith'
              END AS inplace from field_mut_pattadar where case_no = '$case_no'";
        $data['seller'] = $this->db->query($sql)->result_array();
        $sql = "Select * from field_mut_dag_details where case_no = '$case_no'";
        $data['fmd'] = $this->db->query($sql)->result_array();
        /////////////14-03-2022/////////////////////////
        $sql = "Select remark from (
            Select remark,date_entry from field_mut_dag_details where case_no='$case_no' 
            union 
            SElect co_order as remark,date_entry from petition_proceeding  where case_no='$case_no' and user_code like 'M%' ) as t order by date_entry desc";
        $data['lm_remark'] = $this->db->query($sql)->row()->remark;
        ////////end////////
        ////////////////
        $sql = "Select * from nok_tmp where case_id='$case_no'";
        $data['tempNok'] = $this->db->query($sql)->result_array();
        //var_dump($data['tempNok']);
        ////////////////
        $data['mut_type'] = $this->utilityclass->mutType('i');

        $data['basuCase'] = null;
        $data['app'] = $rtps = null;
        $data['basuCase'] = $basundharaExist = $this->basundharamodel->checkExistBasundhar($case_no);
        $trans_type_arr = explode('/', $basundharaExist);
        if ($trans_type_arr[1] == 'MUTD') {
            $data['mut_type'] = $this->utilityclass->mutType('o');
        }
        if ($basundharaExist) {
            $data['sup_doc'] = $this->db->query("SELECT * FROM supportive_document WHERE case_no=?", array($case_no))->result();
            $data['query'] = null;
            $data['rtps'] = $rtps = $this->rtpsmodel->checkBasundharaService($case_no);
            if ($rtps == 'RTPS') {
                $url = RTPS_API_LINK . "serviceResponse?application_no=" . $basundharaExist;
                $data['basundharaAttachment'] = $this->rtpsmodel->searchBasundharaLink($case_no);
            } else {
                $url = API_LINK . "serviceResponse?application_no=" . $basundharaExist;
                $data['basundharaAttachment'] = $this->basundharamodel->searchBasundharaLink($case_no);
            }
            //var_dump($data['basundharaAttachment']);
            $data['query'] = $this->basundharamodel->QueryPost($basundharaExist);
            $data['sro'] = $this->basundharamodel->SroPost($basundharaExist);

        }

        //ESCALATED CASES REMARK ENTRY FORM==============
        if (ESCALATION_ENABLE == 1 && $data['fmb']['es_flag'] == 1 && ESCALATION_REMARK_ENABLE == 1 && $data['fmb']['out_of_esc'] == 0) {
            $remainingTime = $this->Escalationmodel->calculateRemainingTime($case_no, $this->session->userdata('user_desig_code'));
            $data['remainingTime'] = $remainingTime;
            $escRemarkData = $this->Escalationmodel->getEscalationRemarkDetails($case_no, $this->session->userdata('user_desig_code'), $this->session->userdata('user_code'));
            if (isset($escRemarkData) && !empty($escRemarkData)) {
                $data['escRemarkData'] = $escRemarkData;
            }
        }
        ///END REMARKS/////////

        if ($service_code == 2) {
            $params = [
                'case_no' => $case_no,
                'service_code' => $service_code,
                'remarks' => 'Field Mutation Deed',
                'accessed_entity' => 'Aadhaar Name, Photo',
            ];
            $this->load->model('EkycLogModel');
            $log = $this->EkycLogModel->insertEkycAccessedBy($this->db, $params);

            $data['_view'] = 'comutation/write_report_lm_mutd';
        } else {
            $params = [
                'case_no' => $case_no,
                'service_code' => $service_code,
                'remarks' => 'Field Mutation',
                'accessed_entity' => 'Aadhaar Name, Photo',
            ];
            $this->load->model('EkycLogModel');
            $log = $this->EkycLogModel->insertEkycAccessedBy($this->db, $params);

            $data['_view'] = 'comutation/write_report_lm';
        }

        $this->load->view('layouts/main', $data);
    }

    public function decodeBase64($encoded_string)
    {
        $file_data = base64_decode($encoded_string);
        $file = finfo_open();
        $mime_type = finfo_buffer($file, $file_data, FILEINFO_MIME_TYPE);
        $file_type = explode('/', $mime_type)[0];
        $extension = explode('/', $mime_type)[1];
        log_message("error", "No error occured" . json_encode($mime_type));
        return $mime_type;
    }

    public function inheritancePost()
    {

        $this->db->trans_begin();
        $trans_code = $this->input->post('trans_code');
        $application_no = $this->input->post('application_no');
        $mut_type = $this->input->post('mut_type');
        $possession = $this->input->post('possession');
        $remark = $this->input->post('remark');

        $queryForBasundhara = "select * from basundhar_application where basundhara = ?";
        $dataDhar = $this->db->query($queryForBasundhara, array($application_no))->row();

        if (empty($dataDhar) || $dataDhar == null) {
            $this->db->trans_rollback();
            $data = array(
                'error' => "#ERROR006833 : Error in submitting in remarks. Please try Again"
            );
            echo json_encode($data);
            return false;
        }


        $case_no = $dataDhar->dharitree;
        $tablename21 = "basundhar_application";
        $dataUpdate21 = array('reg_by' => $this->session->userdata('user_code'));
        $where21 = array('dharitree' => $case_no);

        $updateStatus21 = $this->TransactionModel->update_multiple_condition($tablename21, $where21, $dataUpdate21);
        if ($updateStatus21 <= 0) {
            $this->db->trans_rollback();
            $data = array(
                'error' => "#ERROR007235 : Error in updation"
            );
            echo json_encode($data);
            return false;
        }



        $case_no = $dataDhar->dharitree;
        $tablename = "field_mut_dag_details";
        $dataUpdate = array('remark' => $remark, 'user_code' => $this->session->userdata('user_code'));
        $where = array('case_no' => $case_no);

        $updateStatus = $this->TransactionModel->update_multiple_condition($tablename, $where, $dataUpdate);
        if ($updateStatus <= 0) {
            $this->db->trans_rollback();
            $data = array(
                'error' => "#ERROR00111 : Error in submitting in remarks. Please try Again"
            );
            echo json_encode($data);
            return false;
        }


        //ESCALATION ==============
        $es_flag_data = $this->db->query("select es_flag,out_of_esc from  field_mut_basic where case_no=?", array($case_no))->row();
        if (ESCALATION_ENABLE == 1 && $es_flag_data->es_flag == 1 && ESCALATION_REMARK_ENABLE == 1 && $es_flag_data->out_of_esc == 0) {

            $responseEsc = $this->Escalationmodel->escalationRemarkCheckandUpdate($case_no, $this->input->post('esc_remark'), $this->session->userdata('user_desig_code'));
            log_message('error', '#ERRESCREMARK111 : Error in submitting in escalation remarks. Please try Again');
            if ($responseEsc['responseType'] == 1) {
                $this->db->trans_rollback();
                $data = array(
                    'error' => "#ERRESCREMARK111 : Error in submitting in escalation remarks. Please try Again"
                );
                echo json_encode($data);
                return false;
            }

        }
        ///END+==================




        $tablename1 = "field_mut_basic";
        $dataUpdate1 = array(
            'possession_yn' => $possession,
            'trans_code' => $mut_type,
            'lm_note' => 'Y',
            'lm_note_date' => date('Y-m-d H:i:s'),
            'user_code' => $this->session->userdata('user_code')
        );
        $where1 = array('case_no' => $case_no);

        $updateStatus1 = $this->TransactionModel->update_multiple_condition($tablename1, $where1, $dataUpdate1);


        if ($updateStatus1 <= 0) {
            $this->db->trans_rollback();
            $data = array(
                'error' => "#ERROR001112 : Error in submitting in field_mut_basic. Please try Again"
            );
            echo json_encode($data);
            return false;
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data = array(
                'error' => "#ERROR001113 : Error in submitting. Please try Again"
            );
            echo json_encode($data);
            return false;
        } else {

            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $executionDate = $this->input->post('executionDate');
            //ESCALATION CODE INTEGRATION================SANMRI
            $es_flag_data = $this->db->query("select es_flag,out_of_esc from  field_mut_basic where case_no='$case_no'")->row();
            if ($es_flag_data->es_flag == 1 && ESCALATION_ENABLE == 1 && $es_flag_data->out_of_esc == 0) {

                $user_code = $this->session->userdata('user_code');
                $serviceType = explode('/', $dataDhar->basundhara);
                $service_code = 1;
                if ($serviceType[1] == 'MUTD') {
                    $service_code = 2;
                }
                $escalationUpdateStatus = $this->Escalationmodel->escalationLMFieldMutReport($service_code, $executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code);

                log_message("error", "#ESC002, transaction-error-STATUS======" . json_encode($escalationUpdateStatus));

                if ($escalationUpdateStatus['responseType'] == 0) {
                    $this->db->trans_rollback();
                    log_message("error", "#ESC002, transaction-error in method 'cofieldmutation/write_report_lm' with case-no :" . $case_no);
                    $this->session->set_flashdata('message', "Something went wrong. Error Code(#ESC002)");
                    redirect(base_url() . "index.php/home");
                }
            }
            //////////////POST To rtps/////////////////////

            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK . "applicationStatusUpdate");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application' => $dataDhar->basundhara,
                'dharitree' => $case_no,
                'rmk' => 'all ok',
                'status' => 'M',
                'task' => 'LM',
                'pen' => 'CO'
            )));
            $result = curl_exec($curl_handle);
            ////////////////////////////////
            if ($result === true || $result == 'true' || $result == 1 || json_decode($result) == 'true' || json_decode($result) == true || json_decode($result) == 'y' || $result == 'y') {


                $this->db->trans_commit();
            } else {
                $this->db->trans_rollback();
                $data = array(
                    'error' => "Error in submitting. Please try Again"
                );
                echo json_encode($data);
                return false;
            }
            // $this->DashboardPartitionField($case_no);
            $this->session->set_flashdata('message', "Application Forwarded to Circle Officer Successfully with case no $case_no ");
            //////////////////////////////////
            $data = array(
                'success' => "Application Forwarded to Circle Officer Successfully with case no $case_no",
                'redirect_url' => base_url() . 'index.php/home'
            );
        }

        echo json_encode($data);
    }

    public function deedPost()
    {

        $this->db->trans_begin();
        $trans_code = $this->input->post('trans_code');
        $application_no = $this->input->post('application_no');
        $mut_type = $this->input->post('mut_type');
        $possession = $this->input->post('possession');
        $remark = $this->input->post('remark');

        $queryForBasundhara = "select * from basundhar_application where basundhara = ?";
        $dataDhar = $this->db->query($queryForBasundhara, array($application_no))->row();

        if (empty($dataDhar) || $dataDhar == null) {
            $this->db->trans_rollback();
            $data = array(
                'error' => "#ERROR006833 : Error in submitting in remarks. Please try Again"
            );
            echo json_encode($data);
            return false;
        }


        $case_no = $dataDhar->dharitree;
        $tablename31 = "basundhar_application";
        $dataUpdate31 = array('reg_by' => $this->session->userdata('user_code'));
        $where31 = array('dharitree' => $case_no);

        $updateStatus31 = $this->TransactionModel->update_multiple_condition($tablename31, $where31, $dataUpdate31);
        if ($updateStatus31 <= 0) {
            $this->db->trans_rollback();
            $data = array(
                'error' => "#ERROR007397 : Error in updation"
            );
            echo json_encode($data);
            return false;
        }



        $case_no = $dataDhar->dharitree;
        $tablename = "field_mut_dag_details";
        $dataUpdate = array('remark' => $remark, 'user_code' => $this->session->userdata('user_code'));
        $where = array('case_no' => $case_no);

        $updateStatus = $this->TransactionModel->update_multiple_condition($tablename, $where, $dataUpdate);
        if ($updateStatus <= 0) {
            $this->db->trans_rollback();
            $data = array(
                'error' => "#ERROR00111 : Error in submitting in remarks. Please try Again"
            );
            echo json_encode($data);
            return false;
        }


        //ESCALATION ==============
        $es_flag_data = $this->db->query("select es_flag,out_of_esc from  field_mut_basic where case_no=?", array($case_no))->row();
        if (ESCALATION_ENABLE == 1 && $es_flag_data->es_flag == 1 && ESCALATION_REMARK_ENABLE == 1 && $es_flag_data->out_of_esc == 0) {

            $responseEsc = $this->Escalationmodel->escalationRemarkCheckandUpdate($case_no, $this->input->post('esc_remark'), $this->session->userdata('user_desig_code'));
            log_message('error', '#ERRESCREMARK111 : Error in submitting in escalation remarks. Please try Again' . json_encode($responseEsc));
            if ($responseEsc['responseType'] == 1) {
                $this->db->trans_rollback();
                $data = array(
                    'error' => "#ERRESCREMARK111 : Error in submitting in escalation remarks. Please try Again"
                );
                echo json_encode($data);
                return false;
            }

        }
        ///END+==================

        // var_dump($_POST['stk']);
        // die;
        $pattadarslist = $this->db->query("select * from  field_mut_pattadar where case_no=?", array($case_no))->result();
        foreach ($pattadarslist as $pet_data) {
            $tablename_pattadar = "field_mut_pattadar";
            foreach ($_POST['stk'] as $key => $value) {
                log_message('error', 'key=============' . $key);
                log_message('error', 'val=============' . $value);
                log_message('error', 'val=============' . $pet_data->pdar_id);
                if ($key == $pet_data->pdar_id) {
                    $dataUpdate_pattadar = array(
                        'striked_out' => $value,
                        'user_code' => $this->session->userdata('user_code')
                    );
                    $where_pattadar = array('case_no' => $case_no, 'pdar_id' => $key);
                    $updateStatus_pattadar = $this->TransactionModel->update_multiple_condition($tablename_pattadar, $where_pattadar, $dataUpdate_pattadar);

                    log_message('error', '#ERRPRfield_mut_pattadar==========' . json_encode($this->db->last_query()));
                    if ($updateStatus_pattadar <= 0) {
                        $this->db->trans_rollback();
                        $data = array(
                            'error' => "#ERROR007427 : Error in submitting in field_mut_pattadar. Please try Again"
                        );
                        echo json_encode($data);
                        return false;
                    }
                }

            }
        }


        $tablename1 = "field_mut_basic";
        $dataUpdate1 = array(
            'possession_yn' => $possession,
            'trans_code' => $mut_type,
            'lm_note' => 'Y',
            'lm_note_date' => date('Y-m-d H:i:s'),
            'user_code' => $this->session->userdata('user_code')
        );
        $where1 = array('case_no' => $case_no);

        $updateStatus1 = $this->TransactionModel->update_multiple_condition($tablename1, $where1, $dataUpdate1);


        if ($updateStatus1 <= 0) {
            $this->db->trans_rollback();
            $data = array(
                'error' => "#ERROR001112 : Error in submitting in field_mut_basic. Please try Again"
            );
            echo json_encode($data);
            return false;
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data = array(
                'error' => "#ERROR001113 : Error in submitting. Please try Again"
            );
            echo json_encode($data);
            return false;
        } else {

            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $executionDate = $this->input->post('executionDate');
            //ESCALATION CODE INTEGRATION================SANMRI
            $es_flag_data = $this->db->query("select es_flag,out_of_esc from  field_mut_basic where "
                . " case_no='$case_no'")->row();
            if ($es_flag_data->es_flag == 1 && ESCALATION_ENABLE == 1 && $es_flag_data->out_of_esc == 0) {

                $user_code = $this->session->userdata('user_code');
                $serviceType = explode('/', $dataDhar->basundhara);
                $service_code = 1;
                if ($serviceType[1] == 'MUTD') {
                    $service_code = 2;
                }
                $escalationUpdateStatus = $this->Escalationmodel->escalationLMFieldMutReport($service_code, $executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code);

                log_message("error", "#ESC002, transaction-error-STATUS======" . json_encode($escalationUpdateStatus));

                if ($escalationUpdateStatus['responseType'] == 0) {
                    $this->db->trans_rollback();
                    log_message("error", "#ESC002, transaction-error in method 'cofieldmutation/write_report_lm' with case-no :" . $case_no);
                    $this->session->set_flashdata('message', "Something went wrong. Error Code(#ESC002)");
                    redirect(base_url() . "index.php/home");
                }
            }
            ///////////////END ESCALATION//////////////

            //////////////POST To rtps/////////////////////
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK . "applicationStatusUpdate");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application' => $dataDhar->basundhara,
                'dharitree' => $case_no,
                'rmk' => 'all ok',
                'status' => 'M',
                'task' => 'LM',
                'pen' => 'CO'
            )));
            $result = curl_exec($curl_handle);
            ////////////////////////////////
            if ($result === true || $result == 'true' || $result == 1 || json_decode($result) == 'true' || json_decode($result) == true || json_decode($result) == 'y' || $result == 'y') {

                $this->db->trans_commit();
            } else {
                $this->db->trans_rollback();
                $data = array(
                    'error' => "Error in submitting. Please try Again"
                );
                echo json_encode($data);
                return false;
            }
            // $this->DashboardPartitionField($case_no);
            $this->session->set_flashdata('message', "Application Forwarded to Circle Officer Successfully with case no $case_no ");
            //////////////////////////////////
            $data = array(
                'success' => "Application Forwarded to Circle Officer Successfully with case no $case_no",
                'redirect_url' => base_url() . 'index.php/home'
            );
        }

        echo json_encode($data);
    }


    function DashboardPartitionField($case_no)
    {
        $this->dbb = $this->load->database('dash', TRUE);
        $sql = "Select * from field_mut_basic fmb left join field_mut_dag_details fmd on fmb.case_no=fmd.case_no where fmb.case_no='$case_no' ";
        $data = $this->db->query($sql)->row_array();
        if ($data['mut_type'] == '01') {
            $type = 'FM';
        } else {
            $type = 'FP';
        }
        $base = array(
            'dist_code' => $data['dist_code'],
            'subdiv_code' => $data['subdiv_code'],
            'cir_code' => $data['cir_code'],
            'mouza_pargona_code' => $data['mouza_pargona_code'],
            'lot_no' => $data['lot_no'],
            'vill_townprt_code' => $data['vill_townprt_code'],
            'case_no' => $data['case_no'],
            'date_of_reg' => $data['date_entry'],
            'dag_no' => $data['dag_no'],
            'patta_type_code' => $data['patta_type_code'],
            'patta_no' => $data['patta_no'],
            'status' => 'P',
            'pending_with_user' => 'SK',
            'case_type' => $type,
        );

        unset($base['dag_no']);
        unset($base['patta_type_code']);
        unset($base['patta_no']);
        $this->db->insert('dashboard_data', $base);
        $this->dbb->insert('dashboard_data', $base);

    }


    public function getPendingPartitionCasesLMend()
    {
        $this->dbswitch();

        $append = $this->base_query;
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $villageListNew = array();
        $villageList = $this->mutationmodel->getAllDistinctVillageListLotWisePartition($append, $mouza_pargona_code, $lot_no);
        foreach ($villageList as $key => $value) {
            $villageListNew[$key]['village_code'] = $value->mouza_pargona_code . "-" . $value->lot_no . "-" . $value->vill_townprt_code;
            $villageListNew[$key]['vill_name'] = $this->utilityclass->getVillageName($value->dist_code, $value->subdiv_code, $value->cir_code, $value->mouza_pargona_code, $value->lot_no, $value->vill_townprt_code);
        }
        $uniqueVillage = array_map("unserialize", array_unique(array_map("serialize", $villageListNew)));
        $data['villageListNew'] = $uniqueVillage;

        $newMouzaList = array();
        foreach ($villageList as $key => $value) {
            $newMouzaList[$key]['mouza_code'] = $value->mouza_pargona_code;
            $newMouzaList[$key]['mouza_name'] = $this->utilityclass->getMouzaName($value->dist_code, $value->subdiv_code, $value->cir_code, $value->mouza_pargona_code);
            $newMouzaList[$key]['lot_name'] = $this->utilityclass->getLotName($value->dist_code, $value->subdiv_code, $value->cir_code, $value->mouza_pargona_code, $value->lot_no);
            $newMouzaList[$key]['lot_no'] = $value->lot_no;
        }

        $uniqueMouzaList = array_map("unserialize", array_unique(array_map("serialize", $newMouzaList)));
        $data['newMouzaList'] = $uniqueMouzaList;


        $data['_view'] = 'partition/fieldpartitioncases';
        $this->load->view('layouts/main', $data);
    }


    //created for getting all the pending list at LM login circle wise---------
    public function getPendingPartitionCasesLMendListOLD()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $draw = intval($this->input->post('draw'));
        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        $mouza_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_mouza_code = $this->input->post('vill_mouza_code');
        $vill_lot_no = $this->input->post('vill_lot_no');
        $village_code = $this->input->post('village_code');
        $zone_status = $this->input->post('zone_status');
        // $define_date = define_date;

        if ($zone_status != null || $zone_status != '') {
            $results = $this->Escalationmodel->getPendingFieldPartitionCaseLMendList($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $mouza_code, $lot_no, $vill_mouza_code, $vill_lot_no, $village_code, $searchByCol_0, $zone_status);
        } else {
            $results = $this->mutationmodel->getPendingFieldPartitionCaseLMendList($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $mouza_code, $lot_no, $vill_mouza_code, $vill_lot_no, $village_code, $searchByCol_0);
        }

        if (isset($results)) {
            $data_rows = $results['data_results'];
            $total_records = $results['total_records'];

            // echo "<pre>";
            // var_dump($data_rows); die;
            // var_dump($total_records); die;

            if ($total_records > 0) {
                foreach ($data_rows as $rows) {

                    // var_dump($rows->es_flag); die;

                    // log_message("error","UTPAL001: ==========".json_encode($rows));
                    if ($rows->es_flag == 1) {

                        $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);

                        // log_message('error', '#6233: Escalation details : '.json_encode($escRow));

                        $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->lm_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));
                        if (!empty($escData) && $escData != null) {
                            // log_message('error', '#6228: Escalation details : '.json_encode($escData)); 

                            $rows->escalation_date = $escData->escalation_date;
                            $rows->escalation_zone = $escData->escalation_zone;
                            $rows->assigned_date = $escData->assigned_date;
                        } else {
                            $rows->escalation_date = 'NA';
                            $rows->escalation_zone = 'NA';
                        }

                    } else {
                        $rows->escalation_date = 'NA';
                        $rows->escalation_zone = 'NA';
                    }

                    $link = base_url() . "index.php/cofieldmutation/write_report_lm_part?case_no=" . $rows->case_no . "&dist_code=" . $rows->dist_code . "&subdiv_code=" . $rows->subdiv_code . "&cir_code=" . $rows->cir_code . "&mouza_pargona_code=" . $rows->mouza_pargona_code . "&lot_no=" . $rows->lot_no . "&vill_townprt_code=" . $rows->vill_townprt_code;
                    $button = "<a href=" . $link . " class='btn btn-success'>" . $this->lang->line("write_report") . "</a>";
                    $mouza_lot = $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code) . "-" . $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no);
                    $e = $rows->basundhara;
                    $json[] = array(

                        $rows->escalation_zone,
                        $rows->escalation_date,

                        $rows->case_no . "<br><span class='small font-italic red'>" . $e . "</span>",
                        $mouza_lot,
                        $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),
                        date('M jS, Y', strtotime($rows->date_entry)),
                        $button
                    );
                }
            } else {
                $json = "";
            }

            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json
            );
            echo json_encode($response);
        } else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }


    public function getPendingPartitionCasesLMendList()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $draw = intval($this->input->post('draw'));
        $searchByCol_0 = $this->input->post('columns')[2]['search']['value'];
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        $mouza_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_mouza_code = $this->input->post('vill_mouza_code');
        $vill_lot_no = $this->input->post('vill_lot_no');
        $village_code = $this->input->post('village_code');
        $zone_status = $this->input->post('zone_status');
        // $define_date = define_date;

        if ($zone_status != null || $zone_status != '') {
            $results = $this->Escalationmodel->getPendingFieldPartitionCaseLMendList($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $mouza_code, $lot_no, $vill_mouza_code, $vill_lot_no, $village_code, $searchByCol_0, $zone_status);
        } else {
            $results = $this->mutationmodel->getPendingFieldPartitionCaseLMendList($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $mouza_code, $lot_no, $vill_mouza_code, $vill_lot_no, $village_code, $searchByCol_0);
        }

        if (isset($results)) {
            $data_rows = $results['data_results'];
            $total_records = $results['total_records'];

            if ($total_records > 0) {
                foreach ($data_rows as $rows) {

                    $link = base_url() . "index.php/cofieldmutation/write_report_lm_part?case_no=" . enc_param('case_no', $rows->case_no, 600) . "&dist_code=" . $rows->dist_code . "&subdiv_code=" . $rows->subdiv_code . "&cir_code=" . $rows->cir_code . "&mouza_pargona_code=" . $rows->mouza_pargona_code . "&lot_no=" . $rows->lot_no . "&vill_townprt_code=" . $rows->vill_townprt_code;

                    // log_message("error","6657: ==========".json_encode($rows));

                    if ($rows->es_flag == 1 && ESCALATION_ENABLE == 1 && $rows->out_of_esc == 0) {

                        $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
                        // log_message('error', '#6233: Escalation details : '.json_encode($escRow));

                        if (!empty($escRow) && $escRow != null) {
                            $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->lm_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));
                            if (!empty($escData) && $escData != null) {
                                // log_message('error', '#6228: Escalation details : '.json_encode($escData)); 

                                $rows->escalation_date = $escData->escalation_date;
                                $rows->escalation_zone = $escData->escalation_zone;
                                $rows->assigned_date = $escData->assigned_date;
                            } else {
                                $rows->escalation_date = 'NA';
                                $rows->escalation_zone = 'NA';
                            }
                        } else {
                            $rows->escalation_date = 'NA';
                            $rows->escalation_zone = 'NA';
                        }
                    } else {
                        $rows->escalation_date = 'NA';
                        $rows->escalation_zone = 'NA';
                    }
                    if (ESCALATION_ENABLE == 1 && $rows->is_escalated == 1) {
                        $button = "Escalated to Appellate Authority";
                    } else {
                        $button = "<a href=" . $link . " class='btn btn-success'>" . $this->lang->line("write_report") . "</a>";
                    }

                    $mouza_lot = $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code) . "-" . $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no);
                    $e = $rows->basundhara;
                    $json[] = array(

                        $rows->escalation_zone,
                        $rows->escalation_date,

                        $rows->case_no . "<br><span class='small font-italic red'>" . $e . "</span>",
                        $mouza_lot,
                        $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),
                        date('M jS, Y', strtotime($rows->date_entry)),
                        $button
                    );
                }
            } else {
                $json = "";
            }

            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json
            );
            echo json_encode($response);
        } else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }

    public function write_report_lm_part()
    {
        $_GET['case_no'] = dec_param($this->input->get('case_no'), 'case_no');
        if ($_GET['case_no'] == null) {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }
        $case_no = $this->input->get('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
        $lot_no1 = $this->input->get('lot_no');
        $vill_townprt_code1 = $this->input->get('vill_townprt_code');
        $data['case_no'] = $case_no;
        $sql = "Select * from field_mut_basic where case_no = '$case_no'";
        $data['fmb'] = $this->db->query($sql)->row_array();
        $sql = "Select * from field_part_petitioner where case_no = '$case_no'";
        $data['applicant'] = $this->db->query($sql)->result();

        $sql11 = "Select * from field_part_petitioner where case_no = ? and auth_type is not null";
        $petitioner = $this->db->query($sql11, array($case_no))->result();
        $data['selfDecData'] = null;
        $data['base64_decoded_adhar_file'] = "";
        if (!empty($petitioner) && $petitioner != null) {
            $data['selfDecData'] = json_decode($petitioner[0]->self_declaration);
            $aadhaarData = json_decode($petitioner[0]->applicant_info);


            if ($petitioner[0]->auth_type != null) {
                $statusAadhar = "<i class='fa fa-check'></i> " . $petitioner[0]->auth_type . " Verified";
                $engName = $aadhaarData->pat_name_eng;
            } else {
                $statusAadhar = 'N/A';
                $engName = null;
            }
            $data['status'] = $statusAadhar;
            $data['engName'] = $engName;



            $application_no_sql = "select * from basundhar_application where dharitree='$case_no' ";
            $data['application'] = $this->db->query($application_no_sql)->row();


            if (!empty($petitioner) && $petitioner != null && trim($petitioner[0]->auth_type) == 'AADHAAR'):

                $adhar_photo_link = $petitioner[0]->photo;
                if ($adhar_photo_link == null) {
                    $url = RTPS_API_LINK . "getApplicantPhoto";
                    $arrayData = array(
                        'application_no' => $data['application']->basundhara,
                    );
                    //*****API call again for aadhar photo missing */
                    $aadhaarPhotoReCall = $this->utilityclass->curlPost($url, $arrayData);
                    if ($aadhaarPhotoReCall != 'n') {
                        $aadhaarPhotoDetails = json_decode($aadhaarPhotoReCall);
                        $aadhar_path = AADHAAR_UPLOAD_DIR . $petitioner[0]->id_ref_no . '.json';
                        $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file11111!");
                        $aadhaar_encoded_file = $aadhaarPhotoDetails->path;
                        fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                        fclose($aadhaar_file_to_write_base64);

                        $query = "update field_part_petitioner set photo = ? where case_no=? and id_ref_no = ? and auth_type is not null";
                        $this->db->query($query, array($aadhar_path, $case_no, $petitioner[0]->id_ref_no));

                        $adhar_photo_link = $aadhar_path;

                    } else {
                        echo json_encode(array('ERROR885784: API Response fail!'));
                        return false;
                    }


                }
                //**********reopening the updated file */
                $open_adhar_file = fopen($adhar_photo_link, "r") or die("Unable to open file!");
                $read_adhar_file = fread($open_adhar_file, filesize($adhar_photo_link));
                fclose($open_adhar_file);
                // decoding the base64 encoding file variable
                $data['base64_decoded_adhar_file'] = "<img src = data:" . $this->decodeBase64($read_adhar_file) . ";base64," . $read_adhar_file . " class='img-thumbnail mrl' alt='Aadhaar Photo' width='170' height='200'>";


            endif;
        }



        $sql = "Select *,CASE
              WHEN striked_out='1' then 'Inplace Of'
              when striked_out='0' then 'Alongwith'
              END AS inplace from field_mut_pattadar where case_no = '$case_no'";
        $data['seller'] = $this->db->query($sql)->result_array();
        $sql = "Select * from field_mut_dag_details where case_no = '$case_no'";
        $data['fmd'] = $this->db->query($sql)->result();
        /////////////14-03-2022/////////////////////////
        $sql = "Select remark from (
            Select remark,date_entry from field_mut_dag_details where case_no='$case_no' 
            union 
            SElect co_order as remark,date_entry from petition_proceeding  where case_no='$case_no' and user_code like 'M%' ) as t order by date_entry desc";
        $data['lm_remark'] = $this->db->query($sql)->row()->remark;
        ////////end////////
        ////////////////
        $sql = "Select * from nok_tmp where case_id='$case_no'";
        $data['tempNok'] = $this->db->query($sql)->result_array();
        //var_dump($data['tempNok']);
        ////////////////
        $data['mut_type'] = $this->utilityclass->mutType('i');

        $data['basuCase'] = null;
        $data['app'] = $rtps = null;
        $data['basuCase'] = $basundharaExist = $this->basundharamodel->checkExistBasundhar($case_no);

        if ($basundharaExist) {
            $data['sup_doc'] = $this->db->query("SELECT * FROM supportive_document WHERE case_no=?", array($case_no))->result();
            $data['query'] = null;
            $data['rtps'] = $rtps = $this->rtpsmodel->checkBasundharaService($case_no);
            if ($rtps == 'RTPS') {
                $url = RTPS_API_LINK . "serviceResponse?application_no=" . $basundharaExist;
                $data['basundharaAttachment'] = $this->rtpsmodel->searchBasundharaLink($case_no);
            } else {
                $url = API_LINK . "serviceResponse?application_no=" . $basundharaExist;
                $data['basundharaAttachment'] = $this->basundharamodel->searchBasundharaLink($case_no);
            }
            //var_dump($data['basundharaAttachment']);
            $data['query'] = $this->basundharamodel->QueryPost($basundharaExist);
            $data['sro'] = $this->basundharamodel->SroPost($basundharaExist);

        }

        //ESCALATED CASES REMARK ENTRY FORM==============
        if (ESCALATION_ENABLE == 1 && $data['fmb']['es_flag'] == 1 && ESCALATION_REMARK_ENABLE == 1 && $data['fmb']['out_of_esc'] == 0) {
            $remainingTime = $this->Escalationmodel->calculateRemainingTime($case_no, $this->session->userdata('user_desig_code'));
            $data['remainingTime'] = $remainingTime;
            $escRemarkData = $this->Escalationmodel->getEscalationRemarkDetails($case_no, $this->session->userdata('user_desig_code'), $this->session->userdata('user_code'));
            if (isset($escRemarkData) && !empty($escRemarkData)) {
                $data['escRemarkData'] = $escRemarkData;
            }
        }
        ///END REMARKS/////////

        $params = [
            'case_no' => $case_no,
            'service_code' => 3,
            'remarks' => 'Field Partition',
            'accessed_entity' => 'Aadhaar Name, Photo',
        ];
        $this->load->model('EkycLogModel');
        $log = $this->EkycLogModel->insertEkycAccessedBy($this->db, $params);

        $data['_view'] = 'comutation/write_report_lm_part';
        $this->load->view('layouts/main', $data);
    }

    public function partitionPost()
    {

        $this->db->trans_begin();
        $case_no = $this->input->post('case_no');
        $remark = $this->input->post('remark');
        $queryForBasundhara = "select * from basundhar_application where dharitree = ?";
        $dataDhar = $this->db->query($queryForBasundhara, array($case_no))->row();

        $tablename = "field_mut_dag_details";
        $dataUpdate = array(
            'remark' => $remark,
            'user_code' => $this->session->userdata('user_code')
        );
        $where = array('case_no' => $case_no);

        $updateStatus = $this->TransactionModel->update_multiple_condition($tablename, $where, $dataUpdate);
        if ($updateStatus <= 0) {
            $this->db->trans_rollback();
            $data = array(
                'error' => "#ERROR0021631 : Error in submitting in remarks. Please try Again"
            );
            echo json_encode($data);
            return false;
        }
        $tablename1 = "field_mut_basic";
        $dataUpdate1 = array(
            'lm_note' => 'Y',
            'lm_note_date' => date('Y-m-d H:i:s'),
            'user_code' => $this->session->userdata('user_code')
        );
        $where1 = array('case_no' => $case_no);

        $updateStatus1 = $this->TransactionModel->update_multiple_condition($tablename1, $where1, $dataUpdate1);


        if ($updateStatus1 <= 0) {
            $this->db->trans_rollback();
            $data = array(
                'error' => "#ERROR0021632 : Error in submitting in field_mut_basic. Please try Again"
            );
            echo json_encode($data);
            return false;
        }

        //ESCALATION ==============
        $es_flag_data = $this->db->query("select es_flag,out_of_esc from  field_mut_basic where case_no=?", array($case_no))->row();
        if (ESCALATION_ENABLE == 1 && $es_flag_data->es_flag == 1 && ESCALATION_REMARK_ENABLE == 1 && $es_flag_data->out_of_esc == 0) {

            $responseEsc = $this->Escalationmodel->escalationRemarkCheckandUpdate($case_no, $this->input->post('esc_remark'), $this->session->userdata('user_desig_code'));
            log_message('error', '#ERRESCREMARK001113 : Error in submitting in escalation remarks. Please try Again');
            if ($responseEsc['responseType'] == 1) {
                $this->db->trans_rollback();
                $data = array(
                    'error' => "#ERRESCREMARK001113 : Error in submitting in escalation remarks. Please try Again"
                );
                echo json_encode($data);
                return false;
            }

        }
        ///END+==================



        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data = array(
                'error' => "#ERROR0021633 : Error in submitting. Please try Again"
            );
            echo json_encode($data);
            return false;
        } else {


            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $executionDate = $this->input->post('executionDate');
            //ESCALATION CODE INTEGRATION================SANMRI
            $es_flag_data = $this->db->query("select es_flag,out_of_esc from  field_mut_basic where case_no='$case_no'")->row();

            if ($es_flag_data->es_flag == 1 && ESCALATION_ENABLE == 1 && $es_flag_data->out_of_esc == 0) {
                $user_code = $this->session->userdata('user_code');
                $escalationUpdateStatus = $this->Escalationmodel->escalationLMPartFieldReport($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code);
                // var_dump($escalationUpdateStatus);die;
                log_message("error", "#ESC7392, transaction-error-STATUS======" . json_encode($escalationUpdateStatus));

                if ($escalationUpdateStatus['responseType'] == 0) {
                    $this->db->trans_rollback();
                    log_message("error", "#ESC7392, transaction-error in method 'cofieldmutation/write_report_lm_part' with case-no :" . $case_no);
                    $this->session->set_flashdata('message', "Something went wrong. Error Code(#ESC7392)");
                    redirect(base_url() . "index.php/home");
                }
                ///////////////END ESCALATION//////////////
            }

            //////////////POST To rtps/////////////////////
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK . "applicationStatusUpdate");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application' => $dataDhar->basundhara,
                'dharitree' => $case_no,
                'rmk' => 'all ok',
                'status' => 'M',
                'task' => 'LM',
                'pen' => 'CO'
            )));
            $result = curl_exec($curl_handle);
            log_message('error', 'FIELDMUTLRA==API==CALL==RESPONSE==' . json_encode($result));

            ////////////////////////////////
            if ($result === true || $result == 'true' || $result == 1 || json_decode($result) == 'true' || json_decode($result) == true || json_decode($result) == 'y' || $result == 'y') {





                $this->db->trans_commit();
            } else {
                $this->db->trans_rollback();
                $data = array(
                    'error' => "Error in submitting. Please try Again"
                );
                echo json_encode($data);
                return false;
            }
            $this->session->set_flashdata('message', "Application Forwarded to Circle Officer Successfully with case no $case_no ");
            //////////////////////////////////
            $data = array(
                'success' => "Application Forwarded to Circle Officer Successfully with case no $case_no",
                'redirect_url' => base_url() . 'index.php/home'
            );
        }

        echo json_encode($data);
    }


    public function revertbackNew()
    {

        $_GET['case_no'] = dec_param($this->input->get('case_no'), 'case_no');
        if ($_GET['case_no'] == null) {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }
        $case_no = $this->input->get('case_no');

        //escalation implementation================
        $es_flag_data = $this->db->query("select es_flag,out_of_esc from  field_mut_basic where "
            . " case_no='$case_no'")->row();
        $flag = false;
        $remaining_days_CO = '';
        if ($es_flag_data->es_flag == 1 && ESCALATION_ENABLE == 1 && $es_flag_data->out_of_esc == 0) {
            //remaining Days of LM ============
            $escalatedRowDetailsAgainstPetitionno = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($case_no);
            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
            $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
            $remaining_days_LM = $this->Escalationmodel->getRemainingDays($previousCompletedDaysLM, $originalAllocation);

            //remaining days of CO==============
            $originalAllocationCO = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            $remaining_days_CO = $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO, $originalAllocationCO);
            if ($remaining_days_LM == 0) {
                $flag = true;
            } else {
                $flag = false;
            }
        }
        $data['es_flag'] = $es_flag_data->es_flag;
        $data['out_of_esc'] = $es_flag_data->out_of_esc;
        $data['flag'] = $flag;
        $data['remainingDaysCO'] = $remaining_days_CO;



        $data['_view'] = 'comutation/revertbackNew';
        $this->load->view('layouts/main', $data);
    }


    public function revertBackLSNew()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        /////////////
        $rmk = addslashes(trim($_POST['co_order']));
        $coname = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $user_code);
        $rmk = $rmk . "  চক্র বিষয়া : " . $coname->username;
        $case_no = $_POST['case_no'];
        $revert_back = $_POST['revert_back'];
        if ($revert_back == 'L') {
            $update = array(
                'is_dispose' => 'L',
            );
            $pen = "LM";
        } else if ($revert_back == 'S') {
            $update = array(
                'is_dispose' => 'S',
                'sk_note' => null,
                'sk_note_date' => null,
                'sk_flag' => null,
                'sk_id' => null
            );
            $pen = "SK";
        }
        $basundharaExist = $this->basundharamodel->checkExistBasundhar($case_no);
        if ($basundharaExist) {
            $this->basundharamodel->insertproceeding($case_no, $rmk);
            $this->db->where('case_no', $case_no);
            $this->db->update('field_mut_basic', $update);

            //ESCALATION CODE INTEGRATION================SANMRI
            $this->db->trans_begin();
            $query1 = $this->db->query("SELECT es_flag,mouza_pargona_code,lot_no,out_of_esc FROM field_mut_basic WHERE case_no=?", array($case_no))->row();
            $user_code = $this->session->userdata('user_code');
            $executionDate = $this->input->post('executionDate');
            if ($query1->es_flag == 1 && ESCALATION_ENABLE == 1 && $query1->out_of_esc == 0) {
                $allocation_days = null;
                if ($this->input->post('allocate_day') != null) {
                    $allocation_days = $this->input->post('allocate_day');
                }
                $escalationUpdateStatus = $this->Escalationmodel->escalationCORevertToLMFPART($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code, $query1->mouza_pargona_code, $query1->lot_no, $allocation_days);
                log_message("error", "#ESC7503, transaction-error-STATUS======" . json_encode($escalationUpdateStatus));

                if ($escalationUpdateStatus['responseType'] == 0) {
                    $this->db->trans_rollback();
                    log_message("error", "#ESC7503, transaction-error in method 'COFieldMutation/revertBackLS' with case-no :" . $case_no);
                    $this->session->set_flashdata('message', "Something went wrong.FPART- Error Code(#ESC7503)");
                    redirect(base_url() . "index.php/home");
                }
            }

            $this->db->trans_commit();



            //////////////POST To basundhara/////////////////////
            $application_no = $basundharaExist;
            $rmk = 'Reverted back to ' . $pen;
            $status = 'M';
            $task = 'CO';
            $case = $case_no;
            $this->basundharamodel->postApiBasundhara($application_no, $case, $rmk, $status, $task, $pen);
            //////////////////
            $this->DashboardData($case_no, $pen, $rmk);
        }
        $this->session->set_flashdata('message', "Case have been Reverted");
        redirect('/home');
    }

    function mutationInheritanceProfileEscalation()
    {
        $case_no = $this->input->get('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
        $lot_no1 = $this->input->get('lot_no');
        $vill_townprt_code1 = $this->input->get('vill_townprt_code');

        ///////////////////////////////////
        $attchedCo = $this->basundharamodel->attachedCO();
        // die;
        if ($attchedCo == 'A') {
            echo json_encode('Sorry !! You are not Authorized to pass the order as Attached CO !!');
            return;
        }
        ///////////////////////////////////
        $sql = "Select * from field_mut_basic where case_no = ?";
        $data['fmb'] = $this->db->query($sql, array($case_no))->row_array();
        $sql = "Select * from field_mut_petitioner where case_no = ?";
        $data['applicant'] = $this->db->query($sql, array($case_no))->result_array();
        $data['other_properties'] = $this->db->where('case_no', $case_no)->get('mut_additional_properties')->result();

        $genType = null;
        if ($data['fmb']['is_multigeneration'] == "M") {
            $genType = "Multi Generation";
        } else {
            $genType = "Single Generation";
        }
        $data['mutation_type_single_multi'] = $genType;
        if ($data['fmb']['is_multigeneration'] == "M") {
            foreach ($data['applicant'] as $key => $value) {
                if ($value['generation_type'] == "P" || $value['generation_type'] == "A") {
                    $sql = "select pet_name as name from field_mut_petitioner where pdar_id = $value[next_of_pdar_id]";
                    if ($this->db->query($sql)->num_rows() > 0) {
                        $data['applicant'][$key]['child_of'] = $this->db->query($sql)->row()->name;
                        // $data['applicant'][$key]['child_of'] = $this->db->query($sql,array($value['next_of_pdar_id']))->row()->name;
                    } else {
                        $data['applicant'][$key]['child_of'] = "Owner Dag Pattadar";
                    }

                    // log_message('error',$this->db->last_query());
                } else {
                    $data['applicant'][$key]['child_of'] = "Owner Dag Pattadar";
                }
            }
        }


        $sql = "Select *,CASE
              WHEN striked_out='1' then 'Inplace Of'
              when striked_out='0' then 'Alongwith'
              END AS inplace from field_mut_pattadar where case_no = ?";
        $data['seller'] = $this->db->query($sql, array($case_no))->result_array();
        $sql = "Select * from field_mut_dag_details where case_no = ?";
        $data['fmd'] = $this->db->query($sql, array($case_no))->result_array();
        /////////////14-03-2022/////////////////////////
        $sql = "Select remark from (
            Select remark,date_entry from field_mut_dag_details where case_no=? 
            union 
            SElect co_order as remark,date_entry from petition_proceeding  where case_no='$case_no' and user_code like 'M%' ) as t order by date_entry desc";
        $data['lm_remark'] = $this->db->query($sql, array($case_no))->row()->remark;
        ////////end////////
        ////////////////
        $sql = "Select * from nok_tmp where case_id=?";
        $data['tempNok'] = $this->db->query($sql, array($case_no))->result_array();
        //var_dump($data['tempNok']);
        ////////////////
        $data['basuCase'] = null;
        $data['app'] = $rtps = null;
        $data['basuCase'] = $basundharaExist = $this->basundharamodel->checkExistBasundhar($case_no);
        if ($basundharaExist) {
            $data['sup_doc'] = $this->db->query("SELECT * FROM supportive_document WHERE case_no=?", array($case_no))->result();
            $data['query'] = null;
            $data['rtps'] = $rtps = $this->rtpsmodel->checkBasundharaService($case_no);
            if ($rtps == 'RTPS') {
                $url = RTPS_API_LINK . "serviceResponse?application_no=" . $basundharaExist;
                $data['basundharaAttachment'] = $this->rtpsmodel->searchBasundharaLink($case_no);
            } else {
                $url = API_LINK . "serviceResponse?application_no=" . $basundharaExist;
                $data['basundharaAttachment'] = $this->basundharamodel->searchBasundharaLink($case_no);
            }
            //var_dump($data['basundharaAttachment']);
            $data['query'] = $this->basundharamodel->QueryPost($basundharaExist);
            $data['sro'] = $this->basundharamodel->SroPost($basundharaExist);
            $output = sendCurlRequest($url);
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, $url);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
            // $output = curl_exec($ch);
            // curl_close($ch);
            $output = json_decode($output);
            if ($output) {
                $data['apps'] = $output->application;
                $firstParty = $output->mutation;
                $engName = "N/A";
                foreach ($firstParty as $key => $value) {
                    if ($value->auth_type != null) {
                        $engName = $value->pat_name_eng;
                    }
                    continue;
                }
            }
        }
        foreach ($data['applicant'] as $key1 => $value1) {
            if ($value1['auth_type'] != null) {
                if (isset($engName) && $engName != null) {
                    $data['applicant'][$key1]['engName'] = $engName;
                } else {
                    $data['applicant'][$key1]['engName'] = null;
                }
            }
            continue;
        }



        //////////////////////////////////////////////////////////////// Property Chain Code //////////////////////////////////////////////
        // echo "<pre>";
        // var_dump($data['fmb']);
        if (ENABLED_BLOCKCHAIN == 1 && in_array($dist_code, json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))) {

            $dist_code = $fmb['dist_code'];
            $subdiv_code = $fmb['subdiv_code'];
            $cir_code = $fmb['cir_code'];
            $mouza_pargona_code = $fmb['mouza_pargona_code'];
            $lot_no = $fmb['lot_no'];
            $vill_townprt_code = $fmb['vill_townprt_code'];


            $data['propChainEnableFlag'] = $this->PropChainCommonModel->isLocationEnable($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

            foreach ($data['fmd'] as $propData) {
                // var_dump($propData['patta_no']);

                $checkPropAndChithaAndUlpn = $this->PropChainModel->chainChithaUlpinCheckProcess($propData['dist_code'], $propData['subdiv_code'], $propData['cir_code'], $propData['mouza_pargona_code'], $propData['lot_no'], $propData['vill_townprt_code'], $propData['patta_no'], $propData['dag_no'], $propData['dag_area_b'], $propData['dag_area_k'], $propData['dag_area_lc'], $propData['dag_area_g'], $propData['patta_type_code']);
            }
            // update flag in field_mut_basic only if ulpin found
            if ($checkPropAndChithaAndUlpn['ulpinCheck'] == 1 && ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'Y' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'NE')) {
                $this->PropChainModel->updateCmpFlag($case_no, $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag']);
                // if mismatch case get the view mismatch case button
                if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N') {
                    $data['viewMisMatchBtn'] = $this->PropChainModel->getMismatchBtn($case_no, $propData['dist_code'], $propData['subdiv_code'], $propData['cir_code'], $propData['mouza_pargona_code'], $propData['lot_no'], $propData['vill_townprt_code'], $propData['patta_no'], $propData['dag_no'], $propData['dag_area_b'], $propData['dag_area_k'], $propData['dag_area_lc'], $propData['dag_area_g'], $propData['patta_type_code']);
                }
            }

            $data['ulpinCheck'] = $checkPropAndChithaAndUlpn['ulpinCheck'];
            $data['ulpinMsg'] = $checkPropAndChithaAndUlpn['ulpinMsg'];

            if ($data['ulpinCheck'] == 1) {
                $data['ulpin'] = $checkPropAndChithaAndUlpn['ulpin'];
                if (isset($data['old_ulpin'])) {
                    $data['old_ulpin'] = $checkPropAndChithaAndUlpn['old_ulpin'];
                } else {
                    $data['old_ulpin'] = "";
                }
            }

            // if property does not exists get create asset button
            if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'NE') {
                $data['createPropChainBtn'] = $checkPropAndChithaAndUlpn['createPropChainBtn'];
            }
            $data['chithaPropChainCmpFlag'] = $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'];
            $data['compareFlagMsg'] = $checkPropAndChithaAndUlpn['compareFlagMsg'];
            $data['revenue'] = $checkPropAndChithaAndUlpn['revenue'];
            $data['local_tax'] = $checkPropAndChithaAndUlpn['local_tax'];
            // hidden fields
            $data['ulpin_hidden'] = $checkPropAndChithaAndUlpn['ulpin_hidden'];
            $data['uplpin_msg_hidden'] = $checkPropAndChithaAndUlpn['uplpin_msg_hidden'];
            $data['compare_hidden'] = $checkPropAndChithaAndUlpn['compare_hidden'];
            $data['compare_msg_hidden'] = $checkPropAndChithaAndUlpn['compare_msg_hidden'];

            // bhunaksha area cmp
            $data['bhuChithaCmpStatus'] = $checkPropAndChithaAndUlpn['bhuChithaCmpStatus'];
            $data['bhuChithaCmpMsg'] = $checkPropAndChithaAndUlpn['bhuChithaCmpMsg'];
            $data['bhu_hidden'] = $checkPropAndChithaAndUlpn['bhu_hidden'];
            $data['bhu_compare_msg_hidden'] = $checkPropAndChithaAndUlpn['bhu_compare_msg_hidden'];
        }


        //tree view for CO end----------
        $data['owner_pattadar'] = null;
        $tree['tree'] = null;
        $tree['generation_type'] = null;

        if ($data['fmb']['is_multigeneration'] == "M") {
            $tree = $this->cofieldmutationmodel->fetchTreeData($case_no);
            $data['owner_pattadar'] = $tree['owner_pattadar'];
            $data['tree'] = $tree['tree'];
            $data['generation_type'] = $tree['generation_type'];
        }
        //
        $data['_view'] = 'comutation/multigenerationProfile';
        $this->load->view('layouts/main', $data);
    }

    /* This is for passing field mutation case final button submission for basundhara cases */
    function passOrderofMultiGeneration()
    {

        // $this->session->set_flashdata('message', "#ERRORMULTIGEN6580 : Final order Pass Mechanism Coming Soon...");
        // redirect(base_url() . "index.php/home");    
        //xss & security validation starts
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST);
        if ($resp['status'] == 'n') {
            $errorMessageStr .= $resp['messages'];
        }
        $resp = checkRequestValidQuery($_POST);
        if ($resp['status'] == 'n') {
            $errorMessageStr .= $resp['messages'];
        }
        if ($errorMessageStr != '') {
            $this->session->set_flashdata('message_extra', $errorMessageStr);
            return redirect($_SERVER['HTTP_REFERER']);
        }
        //xss & security validation ends 

        $case_no = $this->input->post('case_no');

        $this->db->trans_begin();


        //==========check dag pending in blockchain or not=================
        if (ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'), json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))) {
            $this->load->model('TransactionModel');
            $this->load->model('propChain/PropChainCommonModel');
            $dag_details = $this->TransactionModel->find_all_against_id('field_mut_dag_details', 'case_no', $case_no);
            if (sizeof($dag_details) > 1) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERRORBLOCCHAIN7817 : Multiple Dag Mutation with Blockchain not allowed...");
                redirect(base_url() . "index.php/home");
            }
            foreach ($dag_details as $key => $value) {
                $checkVal = $this->PropChainCommonModel->checkDagExistsInPropChainInPending($value->dist_code, $value->subdiv_code, $value->cir_code, $value->mouza_pargona_code, $value->lot_no, $value->vill_townprt_code, $value->dag_no);
                if ($checkVal === false) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "#ERRORBLOCCHAIN6607 : You cannot procced as dag no is pending for property chain update...");
                    redirect(base_url() . "index.php/home");
                }
            }

        }
        ///=============end CODE=====================

        foreach ($_POST['pattadar_id'] as $key => $val) {
            $inplace = $_POST['inplace_alongwith'][$key];
            $sql = "Update field_mut_pattadar set striked_out='$inplace' where pdar_id='$val' and case_no='$case_no' ";
            $this->db->query($sql);

            if ($this->db->affected_rows() <= 0) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Could not update pattadar status. Error Code(#FMP001)");
                redirect(base_url() . "index.php/home");
                return;
            }
        }
        //check for dag data updation------------
        $this->basundharaUpdateArea($case_no);
        $dag_no_update = $this->input->post('dag_no_update');
        $applied_b = $this->input->post('applied_b');
        $applied_k = $this->input->post('applied_k');
        $applied_lc = $this->input->post('applied_lc');
        $applied_g = $this->input->post('applied_g') == null ? "0" : $this->input->post('applied_g');
        $applied_kr = $this->input->post('applied_kr') == null ? "0" : $this->input->post('applied_kr');
        for ($i = 0; $i < count($dag_no_update); $i++) {
            $applied_g = $applied_g[$i] == null ? "0" : $applied_g[$i];
            $sql = "Update field_mut_dag_details set m_dag_area_b='$applied_b[$i]', m_dag_area_k='$applied_k[$i]' , m_dag_area_lc='$applied_lc[$i]',m_dag_area_g='$applied_g' where case_no = '$case_no' ";
            $this->db->query($sql);
            if ($this->db->affected_rows() <= 0) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Could not update area details. Error Code(#FMDD001)");
                redirect(base_url() . "index.php/home");
                return;
            }
        }


        $transcode = $this->input->post('trans_code');

        if ($transcode == '03') {
            $reg_deed_no = $this->input->post('reg_deed_no');
            $is_valid_deed_no = isValidDeedNo($reg_deed_no);
            if (!$is_valid_deed_no['success']) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', $is_valid_deed_no['message']);
                redirect(base_url() . "index.php/home");
                return;
            }
            $reg_deed_date = $this->input->post('reg_deed_date');
            $deed_value = $this->input->post('deed_value');
            $this->updateDeedDetails($case_no);
            $sql = "Update field_mut_basic set reg_deed_no='$reg_deed_no', deed_value='$deed_value' , reg_deed_date='$reg_deed_date' where case_no = '$case_no' ";
            $this->db->query($sql);
            if ($this->db->affected_rows() <= 0) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Could not update deed details. Error Code(#FMB001)");
                redirect(base_url() . "index.php/home");
                return;
            }

            $sql2 = "Update field_mut_dag_details set deed_reg_no='$reg_deed_no', deed_value='$deed_value' , deed_date='$reg_deed_date' where case_no = '$case_no' ";
            $this->db->query($sql2);
            if ($this->db->affected_rows() <= 0) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Could not update deed details. Error Code(#FMB00012)");
                redirect(base_url() . "index.php/home");
                return;
            }
        }
        ////////////////////

        $sql_mut_basic = "Select * from field_mut_basic where case_no = '$case_no'";

        $sql = "Select * from nok_tmp where case_id='$case_no' and approve_reject=1 ";
        $approce_nok = $this->db->query($sql)->result();

        if ($approce_nok) {

            $sql = "Select * from field_mut_petitioner where case_no='$case_no' order by pet_id desc  ";
            $already_insert = $this->db->query($sql)->row();
            if ($already_insert == '' || $already_insert == null) {
                $already_insert = $this->db->query($sql_mut_basic)->row();
                $pid = 1;
            } else {
                $pid = $already_insert->pet_id + 1;
            }

            foreach ($approce_nok as $apnok) {
                $buyerInsert = array(
                    'dist_code' => $already_insert->dist_code,
                    'subdiv_code' => $already_insert->subdiv_code,
                    'cir_code' => $already_insert->cir_code,
                    'mouza_pargona_code' => $already_insert->mouza_pargona_code,
                    'lot_no' => $already_insert->lot_no,
                    'vill_townprt_code' => $already_insert->vill_townprt_code,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d'),
                    'case_no' => $case_no,
                    'petition_no' => $already_insert->petition_no,
                    'year_no' => $already_insert->year_no,
                    'operation' => 'E',
                    'pet_name' => $apnok->name_asm,
                    'guard_name' => $apnok->guardian_name_asm,
                    'guard_rel' => $apnok->relation,/////////////
                    'pet_gender' => $apnok->gender,
                    //'add1' => $pet->address,
                    'add1' => $apnok->address,
                    'pet_id' => $pid++,
                    'new_pet_name' => 'N'
                );
                //var_dump($buyerInsert);
                $nokstatus = $this->db->insert('field_mut_petitioner', $buyerInsert);
                if ($nokstatus != 1) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "New NOK Could not be added. Error Code(#FNOK001)");
                    redirect(base_url() . "index.php/home");
                }
                $update = "Update nok_tmp set approve_reject=2 where case_id='$case_no' and serial_id=$apnok->serial_id ";
                $this->db->query($update);
                //echo $this->db->last_query();
            }
        }

        //////////////////////////////////
        if (isset($_FILES['fileUpload']['name'])) {
            $this->form_validation->set_rules('fileText[]', 'Document Details', 'trim|xss_clean|required');
            $fileCount = count($_FILES['fileUpload']['name']);
            // validation for file type and file size
            for ($i = 0; $i < $fileCount; $i++) {
                if ($_FILES['fileUpload']['name'][$i] && $_FILES['fileUpload']['size'][$i] && $_FILES['fileUpload']['tmp_name'][$i]) {
                    $name = $_FILES['fileUpload']['name'][$i];
                    $size = $_FILES['fileUpload']['size'][$i];
                    $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                    $exp = explode("/", $mime);
                    $ext = $exp[1];
                    if ($name != NULL) {
                        if ($ext == NULL) {
                            // todo error show extension missing
                            $this->session->set_flashdata('message', "File Not Supported. Error Code(#FAPL001)");
                            redirect(base_url() . "index.php/home");
                        }
                        if (!in_array($ext, UPLOAD_TYPE_VALIDATION)) {
                            // todo error show file allow type not match
                            $this->session->set_flashdata('message', "File Not Supported (ONLY JPG/PNG/PDF). Error Code(#FAPL002)");
                            redirect(base_url() . "index.php/home");
                        }
                        if ($size > UPLOAD_MAX_SIZE) {
                            $this->session->set_flashdata('message', "Maximum 2MB file size. Error Code(#FAPL003)");
                            redirect(base_url() . "index.php/home");
                        }
                    } else {
                        $this->session->set_flashdata('message', "File name cann't be empty. Error Code(#FAPL004)");
                        redirect(base_url() . "index.php/home");
                    }
                } else {
                    $this->session->set_flashdata('message', "File is required. Error Code(#FAPL005)");
                    redirect(base_url() . "index.php/home");
                }
            }
        }
        ///////////////////Insert attached file////////////////////////
        if (isset($_FILES['fileUpload']['name'])) {
            for ($i = 0; $i < $fileCount; $i++) {
                $_FILES['file']['name'] = $_FILES['fileUpload']['name'][$i];
                $_FILES['file']['type'] = $_FILES['fileUpload']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['fileUpload']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['fileUpload']['error'][$i];
                $_FILES['file']['size'] = $_FILES['fileUpload']['size'][$i];
                $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                $exp = explode("/", $mime);
                $onlyExtension = $exp[1];
                $replaceCase = str_replace("/", "-", $case_no);
                $fileRename = $replaceCase . "-" . time() . '.' . $onlyExtension;
                $config['upload_path'] = MANUAL_ATTACHMENT;
                $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                $config['max_size'] = UPLOAD_MAX_SIZE;
                ;
                $config['file_name'] = $fileRename;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('file')) {
                    $document = array(
                        'case_no' => $case_no,
                        'file_name' => $_POST['fileText'][$i],
                        'user_code' => $this->session->userdata('user_code'),
                        // 'fetch_file_name' => $_FILES['file']['name'],
                        'fetch_file_name' => $_POST['fileText'][$i],
                        'file_type' => $_FILES['file']['type'],
                        'file_path' => MANUAL_ATTACHMENT . $fileRename,
                        'date_entry' => date('Y-m-d h:i:s'),
                        'mut_type' => 'FM',
                    );
                    // save data in attachment file
                    $addMoreDocQuery = $this->db->insert('supportive_document', $document);
                    if ($addMoreDocQuery != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRADDDOC0001: Insertion failed in supportive document RTPS Case No ' . $case_no);
                        $this->session->set_flashdata('error_data', "#ERRADDDOC0001: Registration of Settlement failed for case no : " . $case_no);
                        redirect(base_url() . "index.php/home");
                        return false;
                    }
                } else {
                    $this->db->trans_rollback();
                    // todo error show
                    // redirect to respected route with error mgs
                    log_message('error', '#ERRADDDOC0001: Insertion failed in supportive document RTPS Case No ' . $case_no);
                    $this->session->set_flashdata('error_data', "#ERRADDDOC0001: Registration of Settlement failed for case no : " . $case_no);
                    redirect(base_url() . "index.php/home");
                    return false;
                }
            }
        }
        //////////////////////////////////////////

        /////////////////////
        try {
            // $this->db->trans_begin();
            // $sql="Select * from field_mut_basic where case_no = '$case_no'";
            // $fmb=$this->db->query($sql)->row_array();
            $fmb = $this->db->query($sql_mut_basic)->row_array();
            $sql = "Select * from field_mut_dag_details where case_no = '$case_no'";
            $fmd = $this->db->query($sql)->result_array();
            foreach ($fmd as $dag) {
                $dag_no[] = array("dag_no" => $dag['dag_no'], "petition_no" => $dag['petition_no'], "case_no" => $dag['case_no']);
                $patta_type_code = $dag['patta_type_code'];
                $patta_no = $dag['patta_no'];
                //////////Max Pattadar ID/////////////////
                $pattadars_in_chitha_pattadar = $this->db->query("select max(pdar_id::int)+1 as cp from chitha_pattadar where dist_code='$fmb[dist_code]' and "
                    . " subdiv_code='$fmb[subdiv_code]' and cir_code='$fmb[cir_code]' and mouza_pargona_code='$fmb[mouza_pargona_code]' and"
                    . " lot_no='$fmb[lot_no]' and vill_townprt_code='$fmb[vill_townprt_code]' and patta_type_code='$patta_type_code' and TRIM(patta_no)=trim('$dag[patta_no]')")->row()->cp;

                $pattadars_in_jama_pattadar = $this->db->query("select max(pdar_id::int)+1 as jp from jama_pattadar where dist_code='$fmb[dist_code]' and "
                    . " subdiv_code='$fmb[subdiv_code]' and cir_code='$fmb[cir_code]' and mouza_pargona_code='$fmb[mouza_pargona_code]' and"
                    . " lot_no='$fmb[lot_no]' and vill_townprt_code='$fmb[vill_townprt_code]' and patta_type_code='$patta_type_code' and TRIM(patta_no)=trim('$dag[patta_no]')")->row()->jp;
                $pattadars_in_chithaDag_pattadar = $this->db->query("select max(pdar_id::int)+1 as dp from chitha_dag_pattadar where dist_code='$fmb[dist_code]' and "
                    . " subdiv_code='$fmb[subdiv_code]' and cir_code='$fmb[cir_code]' and mouza_pargona_code='$fmb[mouza_pargona_code]' and"
                    . " lot_no='$fmb[lot_no]' and vill_townprt_code='$fmb[vill_townprt_code]' and patta_type_code='$patta_type_code' and TRIM(patta_no)=trim('$dag[patta_no]') and dag_no='$dag[dag_no]'")->row()->dp;
                if ($pattadars_in_chitha_pattadar > $pattadars_in_jama_pattadar) {
                    if ($pattadars_in_chithaDag_pattadar > $pattadars_in_chitha_pattadar) {
                        $pdar_id = $pattadars_in_chithaDag_pattadar;
                    } else {
                        $pdar_id = $pattadars_in_chitha_pattadar;
                    }
                } elseif ($pattadars_in_chithaDag_pattadar > $pattadars_in_jama_pattadar) {
                    $pdar_id = $pattadars_in_chithaDag_pattadar;
                } else {
                    $pdar_id = $pattadars_in_jama_pattadar;
                }
                if ($pdar_id === null) {
                    $pdar_id = 1;
                }

                ///////////////////////////
                $tchithacol8order = array(
                    'dist_code' => $fmb['dist_code'],
                    'subdiv_code' => $fmb['subdiv_code'],
                    'cir_code' => $fmb['cir_code'],
                    'mouza_pargona_code' => $fmb['mouza_pargona_code'],
                    'lot_no' => $fmb['lot_no'],
                    'vill_townprt_code' => $fmb['vill_townprt_code'],
                    'dag_no' => $dag['dag_no'],
                    'year_no' => date('Y'),
                    'petition_no' => $fmb['petition_no'],
                    'order_pass_yn' => 'y',
                    'order_type_code' => $fmb['mut_type'],
                    'nature_trans_code' => $fmb['trans_code'],
                    'lm_code' => $fmb['user_code'],
                    'lm_sign_yn' => 'y',
                    'lm_note_date' => $fmb['date_entry'],
                    'co_code' => $this->session->userdata('user_code'),
                    'co_sign_yn' => 'y',
                    'co_ord_date' => date('Y-m-d'),
                    'date_of_order' => date('Y-m-d'),
                    'mut_land_area_b' => $dag['m_dag_area_b'],
                    'mut_land_area_k' => $dag['m_dag_area_k'],
                    'mut_land_area_lc' => $dag['m_dag_area_lc'],
                    'mut_land_area_g' => $dag['m_dag_area_g'],
                    'mut_land_area_kr' => $dag['m_dag_area_kr'],
                    'land_area_left_b' => 0,
                    'land_area_left_k' => 0,
                    'land_area_left_lc' => 0,
                    'land_area_left_g' => 0,
                    'land_area_left_kr' => 0,
                    'rajah_adalat' => $fmb['rajah_adalat'],
                    'deed_reg_no' => $fmb['reg_deed_no'],
                    'deed_value' => $fmb['deed_value'],
                    'deed_date' => $fmb['reg_deed_date'],
                    'sk_code' => $fmb['sk_id'],
                    'sk_sign_yn' => $fmb['sk_id'] != null ? 'y' : '',
                    'sk_note_date' => $fmb['sk_note_date'],
                    'case_no' => $fmb['case_no'],
                    'min_revenue' => '10.00',
                    'noc_no' => $fmb['noc_no'],
                    'noc_date' => $fmb['noc_date'],
                );
                //var_dump($tchithacol8order);
                $tstatus1 = $this->db->insert('t_chitha_col8_order', $tchithacol8order);
                if ($tstatus1 != 1) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Order for Case No $case_no Not Successfull. Error Code(#F001)");
                    redirect(base_url() . "index.php/home");
                }
                //////////End t chitha/////////////
                $i = 1;
                $sql = "Select * from field_mut_petitioner where case_no = '$case_no' order by pet_id asc";

                if ($this->db->query($sql)->num_rows() == 0) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "First party information not found. Error Code(#FAPL001)");
                    redirect(base_url() . "index.php/home");
                }

                $applicant = $this->db->query($sql)->result_array();
                foreach ($applicant as $fmp) {
                    $dec = null;
                    if (isset($fmp['self_declaration']) && $fmp['self_declaration'] != null) {
                        $dec = $fmp['self_declaration'];
                    }
                    if ($fmp['auth_type'] != null) {
                        // if($fmp['auth_type']=='AADHAAR' && $fmp['photo'] == null){
                        //     $this->db->trans_rollback();
                        //     log_message('error', '#ERRFMUTI005:Aadhaar Photo fetching error');
                        //     redirect(base_url() . "index.php/home");
                        // }
                        $auth_type = $fmp['auth_type'];
                        $id_ref_no = $fmp['id_ref_no'];
                        $photo = null;
                    } else {
                        $auth_type = null;
                        $id_ref_no = null;
                        $photo = null;
                    }
                    $strikeForce = 0;
                    //checking for GP and P as there have NOK or not-----
                    // if found then striking out otherwise not----------
                    if ($fmp['generation_type'] == 'GP' || $fmp['generation_type'] == 'P') {
                        // $sqlStrikeForce="Select * from field_mut_petitioner where case_no = '$case_no' and next_of_pdar_id='$fmp[pdar_id]'";
                        $sqlStrikeForce = "Select * from field_mut_petitioner where case_no = '$case_no' and next_of_pdar_id='$fmp[pet_id]'";
                        if ($this->db->query($sqlStrikeForce)->num_rows() == 0) {
                            $strikeForce = 0;
                        } else {
                            $strikeForce = 1;
                        }
                    }



                    $tchithacol8occ = array(
                        'dist_code' => $fmb['dist_code'],
                        'subdiv_code' => $fmb['subdiv_code'],
                        'cir_code' => $fmb['cir_code'],
                        'mouza_pargona_code' => $fmb['mouza_pargona_code'],
                        'lot_no' => $fmb['lot_no'],
                        'vill_townprt_code' => $fmb['vill_townprt_code'],
                        'dag_no' => $dag['dag_no'],
                        'year_no' => date('Y'),
                        'petition_no' => $fmb['petition_no'],
                        'occupant_id' => $i++,
                        'patta_type_code' => $dag['patta_type_code'],
                        'patta_no' => $dag['patta_no'],
                        'pdar_id' => $fmp['pdar_id'] == null ? $pdar_id++ : $fmp['pdar_id'],
                        'occupant_name' => $fmp['pet_name'],
                        'occupant_fmh_name' => $fmp['guard_name'],
                        'occupant_fmh_flag' => $fmp['guard_rel'],
                        'occupant_add1' => $fmp['add1'],
                        'occupant_add2' => $fmp['add2'],
                        'land_area_b' => $dag['m_dag_area_b'] == null ? 0 : $dag['m_dag_area_b'],
                        'land_area_k' => $dag['m_dag_area_k'] == null ? 0 : $dag['m_dag_area_k'],
                        'land_area_lc' => $dag['m_dag_area_lc'] == null ? 0 : $dag['m_dag_area_lc'],
                        'land_area_g' => $dag['m_dag_area_g'] == null ? 0 : $dag['m_dag_area_g'],
                        'land_area_kr' => $dag['m_dag_area_kr'] == null ? 0 : $dag['m_dag_area_kr'],
                        'order_passed' => 'y',
                        'new_pattadar' => $fmp['new_pet_name'],
                        'hus_wife' => $fmp['hus_wife'],
                        'occup_gender' => $fmp['pet_gender'],
                        'occup_minor_yn' => $fmp['pet_minor_yn'],
                        'occup_minor_dob' => $fmp['pet_minor_dob'],
                        'occup_mother' => $fmp['pet_mother'],
                        'self_declaration' => $dec,
                        'auth_type' => $auth_type,
                        'id_ref_no' => $id_ref_no,
                        'photo' => $photo,
                        // 'pdar_strike' => ($fmp['generation_type']=='GP' || $fmp['generation_type']=='P') ? '1':'0'
                        /*
                        'pdar_strike' => $strikeForce,
                        'generation_type' => $fmp['generation_type'],
                        'rel_pdar_id' =>$fmp['pdar_id'],
                        'next_of_pdar_id' => $fmp['next_of_pdar_id']
                        */

                    );

                    if (!empty($fmp['generation_type'])) {
                        $tchithacol8occ = $tchithacol8occ + [
                            'pdar_strike' => $strikeForce,
                            'generation_type' => $fmp['generation_type'],
                            'rel_pdar_id' => $fmp['pet_id'],
                            'next_of_pdar_id' => $fmp['next_of_pdar_id']
                        ];
                    }


                    //var_dump($tchithacol8occ);
                    $tstatus2 = $this->db->insert('t_chitha_col8_occup', $tchithacol8occ);
                    if ($tstatus2 != 1) {
                        $this->db->trans_rollback();
                        log_message('error', $this->db->last_query());
                        $this->session->set_flashdata('message', "Order for Case No $case_no Not Successfull. Error Code(#F002)");
                        redirect(base_url() . "index.php/home");
                    }
                }
                /////////End Petitioner/////////////////
            }
            ////////End Dag Loop//////////// $sql="Select *,CASE
            $j = 1;
            $sql = "Select * from field_mut_pattadar where case_no = '$case_no'";

            if ($this->db->query($sql)->num_rows() == 0) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Second party information not found. Error Code(#FPAT001)");
                redirect(base_url() . "index.php/home");
            }

            $seller = $this->db->query($sql)->result_array();
            foreach ($seller as $inplace) {
                //var_dump($inplace);
                $t_chitha_col8_inplace = array(
                    'dist_code' => $fmb['dist_code'],
                    'subdiv_code' => $fmb['subdiv_code'],
                    'cir_code' => $fmb['cir_code'],
                    'mouza_pargona_code' => $fmb['mouza_pargona_code'],
                    'lot_no' => $fmb['lot_no'],
                    'vill_townprt_code' => $fmb['vill_townprt_code'],
                    'dag_no' => $inplace['dag_no'],
                    'year_no' => date('Y'),
                    'petition_no' => $fmb['petition_no'],
                    'pdar_id' => $inplace['pdar_id'],
                    'inplace_of_id' => $j++,
                    'inplace_of_name' => $inplace['pdar_name'],
                    'land_area_b' => 0,
                    'land_area_k' => 0,
                    'land_area_lc' => 0,
                    'land_area_g' => 0,
                    'land_area_kr' => 0,
                    'order_passed' => 'y',
                    //'date_of_order' =>date('Y-m-d'),
                    'fmute_strike_out' => trim($inplace['striked_out']),
                    'inplace_of_gender' => $inplace['pdar_gender'],
                    'inplace_of_minor_yn' => $inplace['pdar_minor_yn'],
                    'inplace_of_minor_dob' => $inplace['pdar_minor_dob'],
                    'inplace_of_father' => $inplace['pdar_guardian'],
                    'inplace_of_mother' => $inplace['pdar_mother'],
                );
                $tstatus3 = $this->db->insert('t_chitha_col8_inplace', $t_chitha_col8_inplace);
                if ($tstatus3 != 1) {
                    $this->db->trans_rollback();
                    log_message('error', 't_chitha_col8_inplace##Insert' . $this->db->last_query());
                    $this->session->set_flashdata('message', "Order for Case No $case_no Not Successfull. Error Code(#F003)");
                    redirect(base_url() . "index.php/home");
                }
            }

            //$this->db->trans_commit();
            $globalPdarID = false;
            foreach ($dag_no as $d) {

                $updateParams = array(
                    'dist_code' => $fmb['dist_code'],
                    'subdiv_code' => $fmb['subdiv_code'],
                    'cir_code' => $fmb['cir_code'],
                    'mouza_pargona_code' => $fmb['mouza_pargona_code'],
                    'lot_no' => $fmb['lot_no'],
                    'vill_townprt_code' => $fmb['vill_townprt_code'],
                    'petition_no' => $d['petition_no'],
                    'dag_no' => $d['dag_no'],
                    'is_multigeneration' => $fmb['is_multigeneration'],

                );
                $response = $this->ChithaUpdateForMutationModel->ChithaUpdateForField($updateParams, $globalPdarID, $globalPdarIDss);
                if ($response['responseType'] == 1) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Order for Case No $case_no Not Successfull. Error Code(#F004). The applied dag or patta might have changed or the pattadar is no longer available in the applied dag. Kindly check chitha");
                    redirect(base_url() . "index.php/home");
                    return;
                }
                if ($response['responseType'] == 2) {
                    $globalPdarID = true;
                    $globalPdarIDss = $response['globalPdarID'];
                    // if($response['globalPdarID'] != 1)
                    // {
                    //     $globalPdarIDss = $response['globalPdarID']-1;
                    // }
                    // else
                    // {
                    //     $globalPdarIDss = $response['globalPdarID'];
                    // }
                    $globalPdarIDss = $globalPdarIDss;
                }
                $order_date = date('Y-m-d');
                $q = "update field_mut_basic set order_passed='y',date_of_order='$order_date' where case_no='$d[case_no]' ";
                $this->db->query($q);
                if ($this->db->affected_rows() <= 0) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Order for Case No $case_no Not Successfull. Error Code(#FMBFINAL001)");
                    redirect(base_url() . "index.php/home");
                }
                $q = "update t_chitha_col8_order set order_passed='y',date_of_order='$order_date' where case_no='$d[case_no]' ";
                $this->db->query($q);
                if ($this->db->affected_rows() <= 0) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Order for Case No $case_no Not Successfull. Error Code(#FMBFINAL002)");
                    redirect(base_url() . "index.php/home");
                }
            }


            $rmrk = 'CO order';
            $proInsert = $this->mutationmodel->proceeding_order($case_no, $rmrk);
            if ($proInsert == false || $proInsert === false) {
                log_message('error', "#OMUTCOFM001:" . $this->db->last_query());
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Updation failed(#OMUTCOFM001)" . $case_no);
                redirect(base_url() . "index.php/home");
            }
            if ($response['responseType'] == 2) {


                //ESCALATION ==============
                $es_flag = $this->db->query("select es_flag from  field_mut_basic where case_no=?", array($case_no))->row()->es_flag;
                if (ESCALATION_ENABLE == 1 && $es_flag == 1 && ESCALATION_REMARK_ENABLE == 1) {

                    $responseEsc = $this->Escalationmodel->escalationRemarkCheckandUpdate($case_no, $this->input->post('esc_remark'), $this->session->userdata('user_desig_code'));
                    if ($responseEsc['responseType'] == 1) {
                        $this->db->trans_rollback();
                        $data = array(
                            'error' => "#ERROR00111 : Error in submitting in escalation remarks. Please try Again"
                        );
                        echo json_encode($data);
                        return false;
                    }

                }
                ///END+==================



                //ESCALATION CODE INTEGRATION================SANMRI
                $dist_code = $this->session->userdata('dist_code');
                $subdiv_code = $this->session->userdata('subdiv_code');
                $cir_code = $this->session->userdata('cir_code');
                $query1 = $this->db->query(
                    "SELECT es_flag FROM field_mut_basic WHERE case_no=?",
                    array($case_no)
                )->row();
                $user_code = $this->session->userdata('user_code');
                $executionDate = $this->input->post('executionDate');
                if ($query1->es_flag == 1 && ESCALATION_ENABLE == 1) {
                    $basundhara = $this->basundharamodel->checkExistBasundhar($case_no);
                    $service_code = 1;
                    $serviceType = explode('/', $basundhara);
                    if ($serviceType[1] == 'MUTD') {
                        $service_code = 2;
                    }

                    $escalationUpdateStatus = $this->Escalationmodel->escalationFinalOrderCOFmut($service_code, $executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code);
                    log_message("error", "#ESC4335, Escalation-transaction-error-STATUS======" . json_encode($escalationUpdateStatus));
                    if ($escalationUpdateStatus['responseType'] == 0) {
                        $this->db->trans_rollback();
                        log_message("error", "#ESC4335, transaction-error in method 'cofieldmutation/finalorderCO' with case-no :" . $case_no);
                        $this->session->set_flashdata('message', "Something went wrong. Error Code(#ESC4335)");
                        redirect(base_url() . "index.php/home");
                    }
                }
                ///////////////////////////////////////////////////////////////////////////
                //////////////////////Property chain code /////////////////////////////////
                ///////////////////////////////////////////////////////////////////////////
                $save_chain_data = true;
                if (ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'), json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))) {
                    $ulpinFlag = $this->input->post('ulpinCheckFlag');
                    $compareFlag = $this->input->post('compareCheckFlag');


                    if ($compareFlag == 'Y' && $ulpinFlag == 1) {
                        $ulpin = $this->input->post('ulpin', true);
                        $revenue = $this->input->post('chain_revenue', true);
                        $local_tax = $this->input->post('chain_local_tax', true);
                        $old_ulpin = $this->input->post('old_ulpin', true);

                        if (!isset($old_ulpin)) {
                            $old_ulpin = "";
                        }

                        $type = LOC_TYPE_RURAL;
                        $dist_code = $fmb['dist_code'];
                        $subdiv_code = $fmb['subdiv_code'];
                        $mouza_code = $fmb['mouza_pargona_code'];
                        $circle_code = $fmb['cir_code'];
                        $lot_no = $fmb['lot_no'];
                        $village_code = $fmb['vill_townprt_code'];
                        $patta_no = $dag['patta_no'];
                        $dag_no = $dag['dag_no'];

                        $location_id = $dist_code . $subdiv_code . $circle_code . $mouza_code . $lot_no . $village_code;

                        $property_id = $this->blockchainutilityclass->generatePropertyId($type, $village_code, $patta_no, $dag_no, $ulpin);

                        $reference_id = $case_no;
                        $certmnemonic = CERTMNEMONIC_MUT;
                        $property_signature = "base64 encoded signature";
                        $property_signer_key = "base64 encoded public key";
                        $office_code = $this->session->userdata('cir_code');
                        $user_code = $this->session->userdata('user_code');

                        $patta_type_code = $dag['patta_type_code'];

                        $land_area = $this->PropChainModel->getLandArea($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $village_code, $patta_no, $dag_no);

                        $bigha_chain = $land_area->dag_area_b;
                        $katha_chain = $land_area->dag_area_k;
                        $lessa_chain = $land_area->dag_area_lc;
                        $ganda_chain = $land_area->dag_area_g;

                        $land_class_code_query = "select land_class_code from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and patta_no='$patta_no' and dag_no='$dag_no'";

                        $land_class_code = $this->db->query($land_class_code_query)->row()->land_class_code;

                        $pattadar_details = $this->PropChainModel->getPattadars($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $village_code, $patta_no, $dag_no);

                        // since this is mutation and below paramaters are not applicable send the values as empty string
                        $new_patta_no = $new_dag_no = $old_revenue = $old_local_tax = $old_land_class_code = $new_bigha = $new_katha = $new_lessa = $new_ganda = "";

                        $update_params = array(
                            'pattadar_details' => $pattadar_details,
                            'location_id' => $location_id,
                            'property_id' => $property_id,
                            'reference_id' => $reference_id,
                            'dag_no' => $dag_no,
                            'patta_no' => $patta_no,
                            'patta_type_code' => $patta_type_code,
                            'land_class_code' => $land_class_code,
                            'bigha_chain' => $bigha_chain,
                            'katha_chain' => $katha_chain,
                            'lessa_chain' => $lessa_chain,
                            'ganda_chain' => $ganda_chain,
                            'certmnemonic' => $certmnemonic,
                            'property_signature' => $property_signature,
                            'property_signer_key' => $property_signer_key,
                            'office_code' => $office_code,
                            'user_code' => $user_code,
                            'ulpin' => $ulpin,
                            'old_ulpin' => $old_ulpin,
                            'revenue' => $revenue,
                            'local_tax' => $local_tax,
                            'new_patta_no' => $new_patta_no,
                            'new_dag_no' => $new_dag_no,
                            'old_revenue' => $old_revenue,
                            'old_local_tax' => $old_local_tax,
                            'old_land_class_code' => $old_land_class_code,
                            'new_bigha' => $new_bigha,
                            'new_katha' => $new_katha,
                            'new_lessa' => $new_lessa,
                            'new_ganda' => $new_ganda
                        );


                        $chain_send_data = $this->blockchainutilityclass->getUpdateChainArrayN((object) $update_params);


                        $save_chain_data = $this->PropChainModel->save_chain_data(json_encode($chain_send_data), $case_no);
                    }
                }

                if ($save_chain_data) {
                    $this->db->trans_commit();
                    // $this->db->trans_rollback();
                    /////////////////////Basundhara Status Update/////////////////////////////
                    $basundhara = $this->basundharamodel->checkExistBasundhar($case_no);
                    if ($basundhara) {
                        $rmk = 'Order passed';
                        $status = 'F';
                        $task = 'CO';
                        $pen = 'NA';
                        $case = $case_no;
                        $rtps = $this->rtpsmodel->checkBasundharaService($case_no);
                        if ($rtps == 'RTPS') {
                            $this->rtpsmodel->postApiBasundharaSec($case, $rmk, $status, $task, $pen);
                        } else {
                            $this->basundharamodel->postApiBasundharaSec($case, $rmk, $status, $task, $pen);
                        }
                    }
                    /////////////////////////////////////////////////
                    $this->session->set_flashdata('message', "Order for Case No $case_no Successfully Saved.");
                    $this->session->set_flashdata('message2', "Chitha Has Been Updated");
                    //////////////JamaBandi Update///////////////////
                    $location = array(
                        'd' => $fmb['dist_code'],
                        's' => $fmb['subdiv_code'],
                        'c' => $fmb['cir_code'],
                        'm' => $fmb['mouza_pargona_code'],
                        'l' => $fmb['lot_no'],
                        'v' => $fmb['vill_townprt_code'],
                    );
                    $this->session->set_userdata(array('loc' => $location));
                    $popUpmsg = "<h4>Order for Case No $case_no Successfully Saved.Chitha has been Updated !!! Updating JamaBandi Now<h4>";
                    $msgggg = "<script type='text/javascript'>alert(' " . $popUpmsg . " ');</script>";
                    //echo $msgggg;
                    // redirect('JamaBandi/step3/' .$patta_no .'/'. $patta_type_code);

                    if (ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'), json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))) {
                        if ($ulpinFlag == 1 && $compareFlag == 'Y') {
                            redirect('JamaBandi/step3/' . $patta_no . '/' . $patta_type_code . '/' . urlencode(base64_encode($case_no)));
                        }


                    }
                    redirect('JamaBandi/step3/' . $patta_no . '/' . $patta_type_code);
                    //////////////////////////////
                } else {
                    $this->session->set_flashdata('message', "Order for Case No $case_no Not Successfull. Contact Helpdesk with case no, or delete case through utility.");
                    redirect(base_url() . "index.php/home");
                }

            } else {
                $this->session->set_flashdata('message', "#ERRORPROP7257 :  Order for Case No $case_no Not Successfull. Contact Helpdesk with case no, or delete case through utility.");
                redirect(base_url() . "index.php/home");
            }

            ////////////Main Table Update//////////////////
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
        }
    }

    // Added by Abhijit -- 2024-04-30
    public function passOrderofMultiDag()
    {
        // $this->session->set_flashdata('message', "#ERRORMULTIGEN6580 : Final order Pass Mechanism Coming Soon...");
        // redirect(base_url() . "index.php/home");    
        //xss & security validation starts
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST);
        if ($resp['status'] == 'n') {
            $errorMessageStr .= $resp['messages'];
        }
        $resp = checkRequestValidQuery($_POST);
        if ($resp['status'] == 'n') {
            $errorMessageStr .= $resp['messages'];
        }
        if ($errorMessageStr != '') {
            $this->session->set_flashdata('message_extra', $errorMessageStr);
            return redirect($_SERVER['HTTP_REFERER']);
        }
        //xss & security validation ends 

        $case_no = $this->input->post('case_no');

        $is_passable = $this->utilityclass->isTheCasePassable($case_no, 'FMUT');
        if (!$is_passable['success']) {
            $this->session->set_flashdata('message_extra', $is_passable['message']);
            return redirect($_SERVER['HTTP_REFERER']);
        }

        $sql_mut_basic = "select * from field_mut_basic where case_no = ?";
        $application = $this->db->query($sql_mut_basic, array($case_no))->row();
        if (!$application) {
            $this->session->set_flashdata('message_extra', 'No such case found');
            return redirect($_SERVER['HTTP_REFERER']);
        }

        if ($application->is_multidag != 'Y') {
            $this->session->set_flashdata('message_extra', 'This service is inactive for now.');
            return redirect($_SERVER['HTTP_REFERER']);
        }


        $this->db->trans_begin();


        //==========check dag pending in blockchain or not=================
        if (ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'), json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))) {
            $this->load->model('TransactionModel');
            $this->load->model('propChain/PropChainCommonModel');
            $dag_details = $this->TransactionModel->find_all_against_id('field_mut_dag_details', 'case_no', $case_no);
            foreach ($dag_details as $key => $value) {
                $checkVal = $this->PropChainCommonModel->checkDagExistsInPropChainInPending($value->dist_code, $value->subdiv_code, $value->cir_code, $value->mouza_pargona_code, $value->lot_no, $value->vill_townprt_code, $value->dag_no);
                if ($checkVal === false) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "#ERRORBLOCCHAIN6607 : You cannot procced as dag no is pending for property chain update...");
                    redirect(base_url() . "index.php/home");
                }
            }

        }
        ///=============end CODE=====================

        $sql = "Select * from field_mut_dag_details where case_no = '$case_no'";
        $fmd = $this->db->query($sql)->result_array();

        foreach ($_POST['pattadar_id'] as $key => $val) {
            $inplace = $_POST['inplace_alongwith'][$key];
            $seller_dag = $_POST['seller_dag'][$key];
            $sql = "Update field_mut_pattadar set striked_out=? where pdar_id=? and case_no=? and dag_no=? ";
            $this->db->query($sql, array($inplace, $val, $case_no, $seller_dag));

            if ($this->db->affected_rows() <= 0) {
                $this->db->trans_rollback();
                log_message('error', '#MULDFMP001: Last Query => ' . $this->db->last_query());
                $this->session->set_flashdata('message', "Could not update pattadar status. Error Code(#MULDFMP001)");
                redirect(base_url() . "index.php/home");
                return;
            }
        }
        //check for dag data updation------------
        $this->basundharaUpdateArea($case_no);
        $dag_no_update = $this->input->post('dag_no_update');
        $applied_b = $this->input->post('applied_b');
        $applied_k = $this->input->post('applied_k');
        $applied_lc = $this->input->post('applied_lc');
        $applied_g = $this->input->post('applied_g') == null ? "0" : $this->input->post('applied_g');
        $applied_kr = $this->input->post('applied_kr') == null ? "0" : $this->input->post('applied_kr');

        for ($i = 0; $i < count($dag_no_update); $i++) {
            if (!isset($applied_g[$i]) || $applied_g[$i] == null) {
                $applied_g = "0";
            }

            // $applied_g=$applied_g[$i]==null?"0":$applied_g[$i];
            $sql = "Update field_mut_dag_details set m_dag_area_b='$applied_b[$i]', m_dag_area_k='$applied_k[$i]' , m_dag_area_lc='$applied_lc[$i]',m_dag_area_g='$applied_g' where case_no = '$case_no' and dag_no = '$dag_no_update[$i]'";
            $this->db->query($sql);
            if ($this->db->affected_rows() <= 0) {
                $this->db->trans_rollback();
                log_message('error', '#MULDFMDD001: Last Query => ' . $this->db->last_query());
                $this->session->set_flashdata('message', "Could not update area details. Error Code(#MULDFMDD001)");
                redirect(base_url() . "index.php/home");
                return;
            }
        }


        $transcode = $this->input->post('trans_code');

        if ($transcode == '03') {
            $reg_deed_no = $this->input->post('reg_deed_no');
            $is_valid_deed_no = isValidDeedNo($reg_deed_no);
            if (!$is_valid_deed_no['success']) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', $is_valid_deed_no['message']);
                redirect(base_url() . "index.php/home");
                return;
            }
            $reg_deed_date = $this->input->post('reg_deed_date');
            $deed_value = $this->input->post('deed_value');
            $this->updateDeedDetails($case_no);
            $sql = "Update field_mut_basic set reg_deed_no='$reg_deed_no', deed_value='$deed_value' , reg_deed_date='$reg_deed_date' where case_no = '$case_no' ";
            $this->db->query($sql);
            if ($this->db->affected_rows() <= 0) {
                $this->db->trans_rollback();
                log_message('error', '#MULDFMB001: Last Query => ' . $this->db->last_query());
                $this->session->set_flashdata('message', "Could not update deed details. Error Code(#MULDFMB001)");
                redirect(base_url() . "index.php/home");
                return;
            }

            $sql2 = "Update field_mut_dag_details set deed_reg_no='$reg_deed_no', deed_value='$deed_value' , deed_date='$reg_deed_date' where case_no = '$case_no' ";
            $this->db->query($sql2);
            if ($this->db->affected_rows() <= 0) {
                $this->db->trans_rollback();
                log_message('error', '#MULDFMB00012: Last Query => ' . $this->db->last_query());
                $this->session->set_flashdata('message', "Could not update deed details. Error Code(#MULDFMB00012)");
                redirect(base_url() . "index.php/home");
                return;
            }
        }
        ////////////////////

        $sql_mut_basic = "Select * from field_mut_basic where case_no = '$case_no'";

        $sql = "Select * from nok_tmp where case_id='$case_no' and approve_reject=1 ";
        $approce_nok = $this->db->query($sql)->result();

        if ($approce_nok) {

            $sql = "Select * from field_mut_petitioner where case_no='$case_no' order by pet_id desc  ";
            $already_insert = $this->db->query($sql)->row();
            if ($already_insert == '' || $already_insert == null) {
                $already_insert = $this->db->query($sql_mut_basic)->row();
                $pid = 1;
            } else {
                $pid = $already_insert->pet_id + 1;
            }

            foreach ($approce_nok as $apnok) {
                $buyerInsert = array(
                    'dist_code' => $already_insert->dist_code,
                    'subdiv_code' => $already_insert->subdiv_code,
                    'cir_code' => $already_insert->cir_code,
                    'mouza_pargona_code' => $already_insert->mouza_pargona_code,
                    'lot_no' => $already_insert->lot_no,
                    'vill_townprt_code' => $already_insert->vill_townprt_code,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d'),
                    'case_no' => $case_no,
                    'petition_no' => $already_insert->petition_no,
                    'year_no' => $already_insert->year_no,
                    'operation' => 'E',
                    'pet_name' => $apnok->name_asm,
                    'guard_name' => $apnok->guardian_name_asm,
                    'guard_rel' => $apnok->relation,/////////////
                    'pet_gender' => $apnok->gender,
                    //'add1' => $pet->address,
                    'add1' => $apnok->address,
                    'pet_id' => $pid++,
                    'new_pet_name' => 'N',

                    'pdar_mobile' => $apnok->mobile,
                    'pdar_id' => null,
                    'self_declaration' => null,
                    'auth_type' => null,
                    'id_ref_no' => null,
                    'photo' => null,
                    'pdar_name_eng' => null,
                    'pdar_guard_eng' => null,

                    'marital_status' => $apnok->marital_status,
                    'applicant_occupation' => $apnok->applicant_occupation,
                    'caste_category' => $apnok->caste_category,
                    'tribe_category' => $apnok->tribe_category,
                );
                //var_dump($buyerInsert);
                $nokstatus = $this->db->insert('field_mut_petitioner', $buyerInsert);
                if ($nokstatus != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#MULDFNOK001: Last Query => ' . $this->db->last_query());
                    $this->session->set_flashdata('message', "New NOK Could not be added. Error Code(#MULDFNOK001)");
                    redirect(base_url() . "index.php/home");
                }
                $update = "Update nok_tmp set approve_reject=2 where case_id='$case_no' and serial_id=$apnok->serial_id ";
                $this->db->query($update);
                //echo $this->db->last_query();
            }
        }

        //////////////////////////////////
        if (isset($_FILES['fileUpload']['name'])) {
            $this->form_validation->set_rules('fileText[]', 'Document Details', 'trim|xss_clean|required');
            $fileCount = count($_FILES['fileUpload']['name']);
            // validation for file type and file size
            for ($i = 0; $i < $fileCount; $i++) {
                if ($_FILES['fileUpload']['name'][$i] && $_FILES['fileUpload']['size'][$i] && $_FILES['fileUpload']['tmp_name'][$i]) {
                    $name = $_FILES['fileUpload']['name'][$i];
                    $size = $_FILES['fileUpload']['size'][$i];
                    $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                    $exp = explode("/", $mime);
                    $ext = $exp[1];
                    if ($name != NULL) {
                        if ($ext == NULL) {
                            // todo error show extension missing
                            $this->session->set_flashdata('message', "File Not Supported. Error Code(#FAPL001)");
                            redirect(base_url() . "index.php/home");
                        }
                        if (!in_array($ext, UPLOAD_TYPE_VALIDATION)) {
                            // todo error show file allow type not match
                            $this->session->set_flashdata('message', "File Not Supported (ONLY JPG/PNG/PDF). Error Code(#FAPL002)");
                            redirect(base_url() . "index.php/home");
                        }
                        if ($size > UPLOAD_MAX_SIZE) {
                            $this->session->set_flashdata('message', "Maximum 2MB file size. Error Code(#FAPL003)");
                            redirect(base_url() . "index.php/home");
                        }
                    } else {
                        $this->session->set_flashdata('message', "File name cann't be empty. Error Code(#FAPL004)");
                        redirect(base_url() . "index.php/home");
                    }
                } else {
                    $this->session->set_flashdata('message', "File is required. Error Code(#FAPL005)");
                    redirect(base_url() . "index.php/home");
                }
            }
        }
        ///////////////////Insert attached file////////////////////////
        if (isset($_FILES['fileUpload']['name'])) {
            for ($i = 0; $i < $fileCount; $i++) {
                $_FILES['file']['name'] = $_FILES['fileUpload']['name'][$i];
                $_FILES['file']['type'] = $_FILES['fileUpload']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['fileUpload']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['fileUpload']['error'][$i];
                $_FILES['file']['size'] = $_FILES['fileUpload']['size'][$i];
                $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                $exp = explode("/", $mime);
                $onlyExtension = $exp[1];
                $replaceCase = str_replace("/", "-", $case_no);
                $fileRename = $replaceCase . "-" . time() . '.' . $onlyExtension;
                $config['upload_path'] = MANUAL_ATTACHMENT;
                $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                $config['max_size'] = UPLOAD_MAX_SIZE;
                $config['file_name'] = $fileRename;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('file')) {
                    $document = array(
                        'case_no' => $case_no,
                        'file_name' => $_POST['fileText'][$i],
                        'user_code' => $this->session->userdata('user_code'),
                        // 'fetch_file_name' => $_FILES['file']['name'],
                        'fetch_file_name' => $_POST['fileText'][$i],
                        'file_type' => $_FILES['file']['type'],
                        'file_path' => MANUAL_ATTACHMENT . $fileRename,
                        'date_entry' => date('Y-m-d h:i:s'),
                        'mut_type' => 'FM',
                    );
                    // save data in attachment file
                    $addMoreDocQuery = $this->db->insert('supportive_document', $document);
                    if ($addMoreDocQuery != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRMULDADDDOC0001: Insertion failed in supportive document RTPS Case No ' . $case_no);
                        $this->session->set_flashdata('error_data', "#ERRMULDADDDOC0001: Registration of Settlement failed for case no : " . $case_no);
                        redirect(base_url() . "index.php/home");
                        return false;
                    }
                } else {
                    $this->db->trans_rollback();
                    // todo error show
                    // redirect to respected route with error mgs
                    log_message('error', '#ERRMULDADDDOC0002: Insertion failed in supportive document RTPS Case No ' . $case_no);
                    $this->session->set_flashdata('error_data', "#ERRMULDADDDOC0002: Registration of Settlement failed for case no : " . $case_no);
                    redirect(base_url() . "index.php/home");
                    return false;
                }
            }
        }
        //////////////////////////////////////////

        /////////////////////
        try {
            // $this->db->trans_begin();
            // $sql="Select * from field_mut_basic where case_no = '$case_no'";
            // $fmb=$this->db->query($sql)->row_array();
            $fmb = $this->db->query($sql_mut_basic)->row_array();
            $sql = "Select * from field_mut_dag_details where case_no = '$case_no'";
            $fmd = $this->db->query($sql)->result_array();
            foreach ($fmd as $dag) {
                $dag_no[] = array("dag_no" => $dag['dag_no'], "petition_no" => $dag['petition_no'], "case_no" => $dag['case_no']);
                $patta_type_code = $dag['patta_type_code'];
                $patta_no = $dag['patta_no'];
                //////////Max Pattadar ID/////////////////
                $pattadars_in_chitha_pattadar = $this->db->query("select max(pdar_id::int)+1 as cp from chitha_pattadar where dist_code='$fmb[dist_code]' and "
                    . " subdiv_code='$fmb[subdiv_code]' and cir_code='$fmb[cir_code]' and mouza_pargona_code='$fmb[mouza_pargona_code]' and"
                    . " lot_no='$fmb[lot_no]' and vill_townprt_code='$fmb[vill_townprt_code]' and patta_type_code='$patta_type_code' and TRIM(patta_no)=trim('$dag[patta_no]')")->row()->cp;

                $pattadars_in_jama_pattadar = $this->db->query("select max(pdar_id::int)+1 as jp from jama_pattadar where dist_code='$fmb[dist_code]' and "
                    . " subdiv_code='$fmb[subdiv_code]' and cir_code='$fmb[cir_code]' and mouza_pargona_code='$fmb[mouza_pargona_code]' and"
                    . " lot_no='$fmb[lot_no]' and vill_townprt_code='$fmb[vill_townprt_code]' and patta_type_code='$patta_type_code' and TRIM(patta_no)=trim('$dag[patta_no]')")->row()->jp;
                $pattadars_in_chithaDag_pattadar = $this->db->query("select max(pdar_id::int)+1 as dp from chitha_dag_pattadar where dist_code='$fmb[dist_code]' and "
                    . " subdiv_code='$fmb[subdiv_code]' and cir_code='$fmb[cir_code]' and mouza_pargona_code='$fmb[mouza_pargona_code]' and"
                    . " lot_no='$fmb[lot_no]' and vill_townprt_code='$fmb[vill_townprt_code]' and patta_type_code='$patta_type_code' and TRIM(patta_no)=trim('$dag[patta_no]') and dag_no='$dag[dag_no]'")->row()->dp;
                if ($pattadars_in_chitha_pattadar > $pattadars_in_jama_pattadar) {
                    if ($pattadars_in_chithaDag_pattadar > $pattadars_in_chitha_pattadar) {
                        $pdar_id = $pattadars_in_chithaDag_pattadar;
                    } else {
                        $pdar_id = $pattadars_in_chitha_pattadar;
                    }
                } elseif ($pattadars_in_chithaDag_pattadar > $pattadars_in_jama_pattadar) {
                    $pdar_id = $pattadars_in_chithaDag_pattadar;
                } else {
                    $pdar_id = $pattadars_in_jama_pattadar;
                }
                if ($pdar_id === null) {
                    $pdar_id = 1;
                }

                ///////////////////////////
                $tchithacol8order = array(
                    'dist_code' => $fmb['dist_code'],
                    'subdiv_code' => $fmb['subdiv_code'],
                    'cir_code' => $fmb['cir_code'],
                    'mouza_pargona_code' => $fmb['mouza_pargona_code'],
                    'lot_no' => $fmb['lot_no'],
                    'vill_townprt_code' => $fmb['vill_townprt_code'],
                    'dag_no' => $dag['dag_no'],
                    'year_no' => date('Y'),
                    'petition_no' => $fmb['petition_no'],
                    'order_pass_yn' => 'y',
                    'order_type_code' => $fmb['mut_type'],
                    'nature_trans_code' => $fmb['trans_code'],
                    'lm_code' => $fmb['user_code'],
                    'lm_sign_yn' => 'y',
                    'lm_note_date' => $fmb['date_entry'],
                    'co_code' => $this->session->userdata('user_code'),
                    'co_sign_yn' => 'y',
                    'co_ord_date' => date('Y-m-d'),
                    'date_of_order' => date('Y-m-d'),
                    'mut_land_area_b' => $dag['m_dag_area_b'],
                    'mut_land_area_k' => $dag['m_dag_area_k'],
                    'mut_land_area_lc' => $dag['m_dag_area_lc'],
                    'mut_land_area_g' => $dag['m_dag_area_g'],
                    'mut_land_area_kr' => $dag['m_dag_area_kr'],
                    'land_area_left_b' => 0,
                    'land_area_left_k' => 0,
                    'land_area_left_lc' => 0,
                    'land_area_left_g' => 0,
                    'land_area_left_kr' => 0,
                    'rajah_adalat' => $fmb['rajah_adalat'],
                    'deed_reg_no' => $fmb['reg_deed_no'],
                    'deed_value' => $fmb['deed_value'],
                    'deed_date' => $fmb['reg_deed_date'],
                    'sk_code' => $fmb['sk_id'],
                    'sk_sign_yn' => $fmb['sk_id'] != null ? 'y' : '',
                    'sk_note_date' => $fmb['sk_note_date'],
                    'case_no' => $fmb['case_no'],
                    'min_revenue' => '10.00',
                    'noc_no' => $fmb['noc_no'],
                    'noc_date' => $fmb['noc_date'],
                );
                //var_dump($tchithacol8order);
                $tstatus1 = $this->db->insert('t_chitha_col8_order', $tchithacol8order);
                if ($tstatus1 != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#MULDF001: Last Query => ' . $this->db->last_query());
                    $this->session->set_flashdata('message', "Order for Case No $case_no Not Successfull. Error Code(#MULDF001)");
                    redirect(base_url() . "index.php/home");
                }
                //////////End t chitha/////////////
                $i = 1;
                $sql = "Select * from field_mut_petitioner where case_no = '$case_no'";

                if ($this->db->query($sql)->num_rows() == 0) {
                    $this->db->trans_rollback();
                    log_message('error', '#MULDFAPL001: Last Query => ' . $this->db->last_query());
                    $this->session->set_flashdata('message', "First party information not found. Error Code(#MULDFAPL001)");
                    redirect(base_url() . "index.php/home");
                }

                $applicant = $this->db->query($sql)->result_array();
                foreach ($applicant as $fmp) {
                    $dec = null;
                    if (isset($fmp['self_declaration']) && $fmp['self_declaration'] != null) {
                        $dec = $fmp['self_declaration'];
                    }
                    if ($fmp['auth_type'] != null) {
                        // if($fmp['auth_type']=='AADHAAR' && $fmp['photo'] == null){
                        //     $this->db->trans_rollback();
                        //     log_message('error', '#ERRFMUTI005:Aadhaar Photo fetching error');
                        //     redirect(base_url() . "index.php/home");
                        // }
                        $auth_type = $fmp['auth_type'];
                        $id_ref_no = $fmp['id_ref_no'];
                        $photo = null;
                    } else {
                        $auth_type = null;
                        $id_ref_no = null;
                        $photo = null;
                    }

                    $tchithacol8occ = array(
                        'dist_code' => $fmb['dist_code'],
                        'subdiv_code' => $fmb['subdiv_code'],
                        'cir_code' => $fmb['cir_code'],
                        'mouza_pargona_code' => $fmb['mouza_pargona_code'],
                        'lot_no' => $fmb['lot_no'],
                        'vill_townprt_code' => $fmb['vill_townprt_code'],
                        'dag_no' => $dag['dag_no'],
                        'year_no' => date('Y'),
                        'petition_no' => $fmb['petition_no'],
                        'occupant_id' => $i++,
                        'patta_type_code' => $dag['patta_type_code'],
                        'patta_no' => $dag['patta_no'],
                        'pdar_id' => $fmp['pdar_id'] == null ? $pdar_id++ : $fmp['pdar_id'],
                        'occupant_name' => $fmp['pet_name'],
                        'occupant_fmh_name' => $fmp['guard_name'],
                        'occupant_fmh_flag' => $fmp['guard_rel'],
                        'occupant_add1' => $fmp['add1'],
                        'occupant_add2' => $fmp['add2'],
                        'land_area_b' => $dag['m_dag_area_b'] == null ? 0 : $dag['m_dag_area_b'],
                        'land_area_k' => $dag['m_dag_area_k'] == null ? 0 : $dag['m_dag_area_k'],
                        'land_area_lc' => $dag['m_dag_area_lc'] == null ? 0 : $dag['m_dag_area_lc'],
                        'land_area_g' => $dag['m_dag_area_g'] == null ? 0 : $dag['m_dag_area_g'],
                        'land_area_kr' => $dag['m_dag_area_kr'] == null ? 0 : $dag['m_dag_area_kr'],
                        'order_passed' => 'y',
                        'new_pattadar' => $fmp['new_pet_name'],
                        'hus_wife' => $fmp['hus_wife'],
                        'occup_gender' => $fmp['pet_gender'],
                        'occup_minor_yn' => $fmp['pet_minor_yn'],
                        'occup_minor_dob' => $fmp['pet_minor_dob'],
                        'occup_mother' => $fmp['pet_mother'],
                        'self_declaration' => $dec,
                        'auth_type' => $auth_type,
                        'id_ref_no' => $id_ref_no,
                        'photo' => $photo,
                        'pdar_name_eng' => $fmp['pdar_name_eng'],
                        'pdar_guard_eng' => $fmp['pdar_guard_eng']
                    );

                    //var_dump($tchithacol8occ);
                    $tstatus2 = $this->db->insert('t_chitha_col8_occup', $tchithacol8occ);
                    if ($tstatus2 != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#MULDF002: Last Query => ' . $this->db->last_query());
                        $this->session->set_flashdata('message', "Order for Case No $case_no Not Successfull. Error Code(#MULDF002)");
                        redirect(base_url() . "index.php/home");
                    }
                }
                /////////End Petitioner/////////////////
            }
            ////////End Dag Loop//////////// $sql="Select *,CASE
            $j = 1;
            $sql = "Select * from field_mut_pattadar where case_no = '$case_no'";

            if ($this->db->query($sql)->num_rows() == 0) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Second party information not found. Error Code(#FPAT001)");
                redirect(base_url() . "index.php/home");
            }

            $seller = $this->db->query($sql)->result_array();
            foreach ($seller as $inplace) {
                //var_dump($inplace);
                $t_chitha_col8_inplace = array(
                    'dist_code' => $fmb['dist_code'],
                    'subdiv_code' => $fmb['subdiv_code'],
                    'cir_code' => $fmb['cir_code'],
                    'mouza_pargona_code' => $fmb['mouza_pargona_code'],
                    'lot_no' => $fmb['lot_no'],
                    'vill_townprt_code' => $fmb['vill_townprt_code'],
                    'dag_no' => $inplace['dag_no'],
                    'year_no' => date('Y'),
                    'petition_no' => $fmb['petition_no'],
                    'pdar_id' => $inplace['pdar_id'],
                    'inplace_of_id' => $j++,
                    'inplace_of_name' => $inplace['pdar_name'],
                    'land_area_b' => 0,
                    'land_area_k' => 0,
                    'land_area_lc' => 0,
                    'land_area_g' => 0,
                    'land_area_kr' => 0,
                    'order_passed' => 'y',
                    //'date_of_order' =>date('Y-m-d'),
                    'fmute_strike_out' => trim($inplace['striked_out']),
                    'inplace_of_gender' => $inplace['pdar_gender'],
                    'inplace_of_minor_yn' => $inplace['pdar_minor_yn'],
                    'inplace_of_minor_dob' => $inplace['pdar_minor_dob'],
                    'inplace_of_father' => $inplace['pdar_guardian'],
                    'inplace_of_mother' => $inplace['pdar_mother'],
                );
                $tstatus3 = $this->db->insert('t_chitha_col8_inplace', $t_chitha_col8_inplace);
                if ($tstatus3 != 1) {
                    $this->db->trans_rollback();
                    log_message('error', 't_chitha_col8_inplace##MULDF003 Insert' . $this->db->last_query());
                    $this->session->set_flashdata('message', "Order for Case No $case_no Not Successfull. Error Code(#MULDF003)");
                    redirect(base_url() . "index.php/home");
                }
            }

            //$this->db->trans_commit();

            foreach ($dag_no as $d) {

                $updateParams = array(
                    'dist_code' => $fmb['dist_code'],
                    'subdiv_code' => $fmb['subdiv_code'],
                    'cir_code' => $fmb['cir_code'],
                    'mouza_pargona_code' => $fmb['mouza_pargona_code'],
                    'lot_no' => $fmb['lot_no'],
                    'vill_townprt_code' => $fmb['vill_townprt_code'],
                    'petition_no' => $d['petition_no'],
                    'dag_no' => $d['dag_no'],
                    'is_multigeneration' => $fmb['is_multigeneration'],
                );
                $ok = $this->ChithaUpdateForMutationModel->ChithaUpdateForFieldForMultiDag($updateParams);
                if ($ok == false) {
                    $this->db->trans_rollback();
                    log_message('error', '#MULDF004: Last Query => ' . $this->db->last_query());

                    $this->session->set_flashdata('message', "Order for Case No $case_no Not Successfull. Error Code(#MULDF004). The applied dag or patta might have changed or the pattadar is no longer available in the applied dag. Kindly check chitha");
                    redirect(base_url() . "index.php/home");
                    return;
                }
                $order_date = date('Y-m-d');
                $q = "update field_mut_basic set order_passed='y',date_of_order='$order_date' where case_no='$d[case_no]' ";
                $this->db->query($q);
                if ($this->db->affected_rows() <= 0) {
                    $this->db->trans_rollback();
                    log_message('error', '#MULDFMBFINAL001: Last Query => ' . $this->db->last_query());

                    $this->session->set_flashdata('message', "Order for Case No $case_no Not Successfull. Error Code(#MULDFMBFINAL001)");
                    redirect(base_url() . "index.php/home");
                }
                $q = "update t_chitha_col8_order set order_passed='y',date_of_order='$order_date' where case_no='$d[case_no]' ";
                $this->db->query($q);
                if ($this->db->affected_rows() <= 0) {
                    $this->db->trans_rollback();
                    log_message('error', '#MULDFMBFINAL002: Last Query => ' . $this->db->last_query());

                    $this->session->set_flashdata('message', "Order for Case No $case_no Not Successfull. Error Code(#MULDFMBFINAL002)");
                    redirect(base_url() . "index.php/home");
                }
            }


            $rmrk = 'CO order';
            $proInsert = $this->mutationmodel->proceeding_order($case_no, $rmrk);
            if ($proInsert == false || $proInsert === false) {
                log_message('error', "#MULDOMUTCOFM001:" . $this->db->last_query());
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Updation failed(#MULDOMUTCOFM001)" . $case_no);
                redirect(base_url() . "index.php/home");
            }
            if ($ok) {


                //ESCALATION CODE INTEGRATION================SANMRI
                $dist_code = $this->session->userdata('dist_code');
                $subdiv_code = $this->session->userdata('subdiv_code');
                $cir_code = $this->session->userdata('cir_code');
                $query1 = $this->db->query(
                    "SELECT es_flag FROM field_mut_basic WHERE case_no=?",
                    array($case_no)
                )->row();
                $user_code = $this->session->userdata('user_code');
                $executionDate = $this->input->post('executionDate');
                if ($query1->es_flag == 1 && ESCALATION_ENABLE == 1) {
                    $escalationUpdateStatus = $this->Escalationmodel->escalationFinalOrderCOFmut($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code);
                    log_message("error", "#ESC4335, Escalation-transaction-error-STATUS======" . json_encode($escalationUpdateStatus));
                    if ($escalationUpdateStatus['responseType'] == 0) {
                        $this->db->trans_rollback();
                        log_message("error", "#ESC4335, transaction-error in method 'cofieldmutation/finalorderCO' with case-no :" . $case_no);
                        $this->session->set_flashdata('message', "Something went wrong. Error Code(#ESC4335)");
                        redirect(base_url() . "index.php/home");
                    }
                }

                ////////////END ESCALATION/////////////////////


                ///////////////////////////////////////////////////////////////////////////
                //////////////////////Property chain code /////////////////////////////////
                ///////////////////////////////////////////////////////////////////////////
                $save_chain_data = true;
                if (ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'), json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))) {
                    $ulpinFlag = $this->input->post('ulpinCheckFlag');
                    $compareFlag = $this->input->post('compareCheckFlag');


                    if ($compareFlag == 'Y' && $ulpinFlag == 1) {
                        $ulpin = $this->input->post('ulpin', true);
                        $revenue = $this->input->post('chain_revenue', true);
                        $local_tax = $this->input->post('chain_local_tax', true);
                        $old_ulpin = $this->input->post('old_ulpin', true);

                        if (!isset($old_ulpin)) {
                            $old_ulpin = "";
                        }

                        $type = LOC_TYPE_RURAL;
                        $dist_code = $fmb['dist_code'];
                        $subdiv_code = $fmb['subdiv_code'];
                        $mouza_code = $fmb['mouza_pargona_code'];
                        $circle_code = $fmb['cir_code'];
                        $lot_no = $fmb['lot_no'];
                        $village_code = $fmb['vill_townprt_code'];
                        $patta_no = $dag['patta_no'];
                        $dag_no = $dag['dag_no'];

                        $location_id = $dist_code . $subdiv_code . $circle_code . $mouza_code . $lot_no . $village_code;

                        $property_id = $this->blockchainutilityclass->generatePropertyId($type, $village_code, $patta_no, $dag_no, $ulpin);

                        $reference_id = $case_no;
                        $certmnemonic = CERTMNEMONIC_MUT;
                        $property_signature = "base64 encoded signature";
                        $property_signer_key = "base64 encoded public key";
                        $office_code = $this->session->userdata('cir_code');
                        $user_code = $this->session->userdata('user_code');

                        $patta_type_code = $dag['patta_type_code'];

                        $land_area = $this->PropChainModel->getLandArea($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $village_code, $patta_no, $dag_no);

                        $bigha_chain = $land_area->dag_area_b;
                        $katha_chain = $land_area->dag_area_k;
                        $lessa_chain = $land_area->dag_area_lc;
                        $ganda_chain = $land_area->dag_area_g;

                        $land_class_code_query = "select land_class_code from chitha_basic where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and patta_no=? and dag_no=?";

                        $land_class_code = $this->db->query($land_class_code_query, array($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $village_code, $patta_no, $dag_no))->row()->land_class_code;

                        $pattadar_details = $this->PropChainModel->getPattadars($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $village_code, $patta_no, $dag_no);

                        // since this is mutation and below paramaters are not applicable send the values as empty string
                        $new_patta_no = $new_dag_no = $old_revenue = $old_local_tax = $old_land_class_code = $new_bigha = $new_katha = $new_lessa = $new_ganda = "";

                        $update_params = array(
                            'pattadar_details' => $pattadar_details,
                            'location_id' => $location_id,
                            'property_id' => $property_id,
                            'reference_id' => $reference_id,
                            'dag_no' => $dag_no,
                            'patta_no' => $patta_no,
                            'patta_type_code' => $patta_type_code,
                            'land_class_code' => $land_class_code,
                            'bigha_chain' => $bigha_chain,
                            'katha_chain' => $katha_chain,
                            'lessa_chain' => $lessa_chain,
                            'ganda_chain' => $ganda_chain,
                            'certmnemonic' => $certmnemonic,
                            'property_signature' => $property_signature,
                            'property_signer_key' => $property_signer_key,
                            'office_code' => $office_code,
                            'user_code' => $user_code,
                            'ulpin' => $ulpin,
                            'old_ulpin' => $old_ulpin,
                            'revenue' => $revenue,
                            'local_tax' => $local_tax,
                            'new_patta_no' => $new_patta_no,
                            'new_dag_no' => $new_dag_no,
                            'old_revenue' => $old_revenue,
                            'old_local_tax' => $old_local_tax,
                            'old_land_class_code' => $old_land_class_code,
                            'new_bigha' => $new_bigha,
                            'new_katha' => $new_katha,
                            'new_lessa' => $new_lessa,
                            'new_ganda' => $new_ganda
                        );


                        $chain_send_data = $this->blockchainutilityclass->getUpdateChainArrayN((object) $update_params);


                        $save_chain_data = $this->PropChainModel->save_chain_data(json_encode($chain_send_data), $case_no);
                    }
                }

                if ($save_chain_data) {
                    $this->db->trans_commit();
                    /////////////////////Basundhara Status Update/////////////////////////////
                    $basundhara = $this->basundharamodel->checkExistBasundhar($case_no);
                    if ($basundhara) {
                        $rmk = 'Order passed';
                        $status = 'F';
                        $task = 'CO';
                        $pen = 'NA';
                        $case = $case_no;
                        $rtps = $this->rtpsmodel->checkBasundharaService($case_no);
                        if ($rtps == 'RTPS') {
                            $this->rtpsmodel->postApiBasundharaSec($case, $rmk, $status, $task, $pen);
                        } else {
                            $this->basundharamodel->postApiBasundharaSec($case, $rmk, $status, $task, $pen);
                        }
                    }
                    /////////////////////////////////////////////////
                    $this->session->set_flashdata('message', "Order for Case No $case_no Successfully Saved.");
                    $this->session->set_flashdata('message2', "Chitha Has Been Updated");
                    //////////////JamaBandi Update///////////////////
                    $location = array(
                        'd' => $fmb['dist_code'],
                        's' => $fmb['subdiv_code'],
                        'c' => $fmb['cir_code'],
                        'm' => $fmb['mouza_pargona_code'],
                        'l' => $fmb['lot_no'],
                        'v' => $fmb['vill_townprt_code'],
                    );
                    $this->session->set_userdata(array('loc' => $location));
                    $popUpmsg = "<h4>Order for Case No $case_no Successfully Saved.Chitha has been Updated !!! Updating JamaBandi Now<h4>";
                    $msgggg = "<script type='text/javascript'>alert(' " . $popUpmsg . " ');</script>";
                    //echo $msgggg;
                    // redirect('JamaBandi/step3/' .$patta_no .'/'. $patta_type_code);

                    if (ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'), json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))) {
                        if ($ulpinFlag == 1 && $compareFlag == 'Y') {
                            redirect('JamaBandi/step3/' . $patta_no . '/' . $patta_type_code . '/' . urlencode(base64_encode($case_no)));
                        }


                    }
                    redirect('JamaBandi/step3/' . $patta_no . '/' . $patta_type_code);
                    //////////////////////////////
                } else {
                    $this->session->set_flashdata('message', "Order for Case No $case_no Not Successfull. Contact Helpdesk with case no, or delete case through utility.");
                    redirect(base_url() . "index.php/home");
                }

            } else {
                $this->session->set_flashdata('message', "#ERRMULDORPROP7257 :  Order for Case No $case_no Not Successfull. Contact Helpdesk with case no, or delete case through utility.");
                redirect(base_url() . "index.php/home");
            }

            ////////////Main Table Update//////////////////
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', sprintf('%s : %s : DB transaction failed. Error no: %s, Error msg:%s, Last query: %s', __CLASS__, __FUNCTION__, $e->getCode(), $e->getMessage(), print_r($this->main_db->last_query(), TRUE)));
        }
    }

    function mutationInheritanceProfile()
    {
        $case_no = $this->input->get('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
        $lot_no1 = $this->input->get('lot_no');
        $vill_townprt_code1 = $this->input->get('vill_townprt_code');

        ///////////////////////////////////
        $attchedCo = $this->basundharamodel->attachedCO();
        // die;
        if ($attchedCo == 'A') {
            echo json_encode('Sorry !! You are not Authorized to pass the order as Attached CO !!');
            return;
        }
        ///////////////////////////////////
        $sql = "Select * from field_mut_basic where case_no = ?";
        $data['fmb'] = $this->db->query($sql, array($case_no))->row_array();
        $sql = "Select * from field_mut_petitioner where case_no = ?";
        $data['applicant'] = $this->db->query($sql, array($case_no))->result_array();
        $data['other_properties'] = $this->db->where('case_no', $case_no)->get('mut_additional_properties')->result();

        $genType = null;
        if ($data['fmb']['is_multigeneration'] == "M") {
            $genType = "Multi Generation";
        } else {
            $genType = "Single Generation";
        }
        $data['mutation_type_single_multi'] = $genType;
        if ($data['fmb']['is_multigeneration'] == "M") {
            foreach ($data['applicant'] as $key => $value) {
                if ($value['generation_type'] == "P" || $value['generation_type'] == "A") {
                    $sql = "select pet_name as name from field_mut_petitioner where case_no ='$case_no' and pet_id = $value[next_of_pdar_id]";
                    if ($this->db->query($sql)->num_rows() > 0) {
                        $data['applicant'][$key]['child_of'] = $this->db->query($sql)->row()->name;
                        // $data['applicant'][$key]['child_of'] = $this->db->query($sql,array($value['next_of_pdar_id']))->row()->name;
                    } else {
                        $data['applicant'][$key]['child_of'] = "Owner Dag Pattadar";
                    }

                    // log_message('error',$this->db->last_query());
                } else {
                    $data['applicant'][$key]['child_of'] = "Owner Dag Pattadar";
                }
            }
        }


        $sql = "Select *,CASE
              WHEN striked_out='1' then 'Inplace Of'
              when striked_out='0' then 'Alongwith'
              END AS inplace from field_mut_pattadar where case_no = ?";
        $data['seller'] = $this->db->query($sql, array($case_no))->result_array();
        $sql = "Select * from field_mut_dag_details where case_no = ?";
        $data['fmd'] = $this->db->query($sql, array($case_no))->result_array();
        /////////////14-03-2022/////////////////////////
        $sql = "Select remark from (
            Select remark,date_entry from field_mut_dag_details where case_no=? 
            union 
            SElect co_order as remark,date_entry from petition_proceeding  where case_no='$case_no' and user_code like 'M%' ) as t order by date_entry desc";
        $data['lm_remark'] = $this->db->query($sql, array($case_no))->row()->remark;
        ////////end////////
        ////////////////
        $sql = "Select * from nok_tmp where case_id=?";
        $data['tempNok'] = $this->db->query($sql, array($case_no))->result_array();
        //var_dump($data['tempNok']);
        ////////////////
        $data['basuCase'] = null;
        $data['app'] = $rtps = null;
        $data['basuCase'] = $basundharaExist = $this->basundharamodel->checkExistBasundhar($case_no);
        if ($basundharaExist) {
            $data['sup_doc'] = $this->db->query("SELECT * FROM supportive_document WHERE case_no=?", array($case_no))->result();
            $data['query'] = null;
            $data['rtps'] = $rtps = $this->rtpsmodel->checkBasundharaService($case_no);
            if ($rtps == 'RTPS') {
                $url = RTPS_API_LINK . "serviceResponse?application_no=" . $basundharaExist;
                $data['basundharaAttachment'] = $this->rtpsmodel->searchBasundharaLink($case_no);
            } else {
                $url = API_LINK . "serviceResponse?application_no=" . $basundharaExist;
                $data['basundharaAttachment'] = $this->basundharamodel->searchBasundharaLink($case_no);
            }
            //var_dump($data['basundharaAttachment']);
            $data['query'] = $this->basundharamodel->QueryPost($basundharaExist);
            $data['sro'] = $this->basundharamodel->SroPost($basundharaExist);
            $output = sendCurlRequest($url);
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, $url);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
            // $output = curl_exec($ch);
            // curl_close($ch);
            $output = json_decode($output);
            if ($output) {
                $data['apps'] = $output->application;
                $firstParty = $output->mutation;
                $engName = "N/A";
                foreach ($firstParty as $key => $value) {
                    if ($value->auth_type != null) {
                        $engName = $value->pat_name_eng;
                    }
                    continue;
                }
            }
        }
        foreach ($data['applicant'] as $key1 => $value1) {
            if ($value1['auth_type'] != null) {
                if (isset($engName) && $engName != null) {
                    $data['applicant'][$key1]['engName'] = $engName;
                } else {
                    $data['applicant'][$key1]['engName'] = null;
                }
            }
            continue;
        }



        //////////////////////////////////////////////////////////////// Property Chain Code //////////////////////////////////////////////
        // echo "<pre>";
        // var_dump($data['fmb']);
        if (ENABLED_BLOCKCHAIN == 1 && in_array($dist_code, json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))) {

            $dist_code = $fmb['dist_code'];
            $subdiv_code = $fmb['subdiv_code'];
            $cir_code = $fmb['cir_code'];
            $mouza_pargona_code = $fmb['mouza_pargona_code'];
            $lot_no = $fmb['lot_no'];
            $vill_townprt_code = $fmb['vill_townprt_code'];


            $data['propChainEnableFlag'] = $this->PropChainCommonModel->isLocationEnable($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

            foreach ($data['fmd'] as $propData) {
                // var_dump($propData['patta_no']);

                $checkPropAndChithaAndUlpn = $this->PropChainModel->chainChithaUlpinCheckProcess($propData['dist_code'], $propData['subdiv_code'], $propData['cir_code'], $propData['mouza_pargona_code'], $propData['lot_no'], $propData['vill_townprt_code'], $propData['patta_no'], $propData['dag_no'], $propData['dag_area_b'], $propData['dag_area_k'], $propData['dag_area_lc'], $propData['dag_area_g'], $propData['patta_type_code']);
            }
            // update flag in field_mut_basic only if ulpin found
            if ($checkPropAndChithaAndUlpn['ulpinCheck'] == 1 && ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'Y' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'NE')) {
                $this->PropChainModel->updateCmpFlag($case_no, $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag']);
                // if mismatch case get the view mismatch case button
                if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N') {
                    $data['viewMisMatchBtn'] = $this->PropChainModel->getMismatchBtn($case_no, $propData['dist_code'], $propData['subdiv_code'], $propData['cir_code'], $propData['mouza_pargona_code'], $propData['lot_no'], $propData['vill_townprt_code'], $propData['patta_no'], $propData['dag_no'], $propData['dag_area_b'], $propData['dag_area_k'], $propData['dag_area_lc'], $propData['dag_area_g'], $propData['patta_type_code']);
                }
            }

            $data['ulpinCheck'] = $checkPropAndChithaAndUlpn['ulpinCheck'];
            $data['ulpinMsg'] = $checkPropAndChithaAndUlpn['ulpinMsg'];

            if ($data['ulpinCheck'] == 1) {
                $data['ulpin'] = $checkPropAndChithaAndUlpn['ulpin'];
                if (isset($data['old_ulpin'])) {
                    $data['old_ulpin'] = $checkPropAndChithaAndUlpn['old_ulpin'];
                } else {
                    $data['old_ulpin'] = "";
                }
            }

            // if property does not exists get create asset button
            if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'NE') {
                $data['createPropChainBtn'] = $checkPropAndChithaAndUlpn['createPropChainBtn'];
            }
            $data['chithaPropChainCmpFlag'] = $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'];
            $data['compareFlagMsg'] = $checkPropAndChithaAndUlpn['compareFlagMsg'];
            $data['revenue'] = $checkPropAndChithaAndUlpn['revenue'];
            $data['local_tax'] = $checkPropAndChithaAndUlpn['local_tax'];
            // hidden fields
            $data['ulpin_hidden'] = $checkPropAndChithaAndUlpn['ulpin_hidden'];
            $data['uplpin_msg_hidden'] = $checkPropAndChithaAndUlpn['uplpin_msg_hidden'];
            $data['compare_hidden'] = $checkPropAndChithaAndUlpn['compare_hidden'];
            $data['compare_msg_hidden'] = $checkPropAndChithaAndUlpn['compare_msg_hidden'];

            // bhunaksha area cmp
            $data['bhuChithaCmpStatus'] = $checkPropAndChithaAndUlpn['bhuChithaCmpStatus'];
            $data['bhuChithaCmpMsg'] = $checkPropAndChithaAndUlpn['bhuChithaCmpMsg'];
            $data['bhu_hidden'] = $checkPropAndChithaAndUlpn['bhu_hidden'];
            $data['bhu_compare_msg_hidden'] = $checkPropAndChithaAndUlpn['bhu_compare_msg_hidden'];
        }


        //tree view for CO end----------
        $data['owner_pattadar'] = null;
        $tree['tree'] = null;
        $tree['generation_type'] = null;

        if ($data['fmb']['is_multigeneration'] == "M") {
            $tree = $this->cofieldmutationmodel->fetchTreeData($case_no);
            $data['owner_pattadar'] = $tree['owner_pattadar'];
            $data['tree'] = $tree['tree'];
            $data['generation_type'] = $tree['generation_type'];
        }
        //

        //ESCALATED CASES REMARK ENTRY FORM==============
        if (ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE == 1 && $data['fmb']->es_flag == 1) {
            $remainingTime = $this->Escalationmodel->calculateRemainingTime($case_no, $this->session->userdata('user_desig_code'));
            $data['remainingTime'] = $remainingTime;
            $escRemarkData = $this->Escalationmodel->getEscalationRemarkDetails($case_no, $this->session->userdata('user_desig_code'), $this->session->userdata('user_code'));
            if (isset($escRemarkData) && !empty($escRemarkData)) {
                $data['escRemarkData'] = $escRemarkData;
            }
        }
        ///END REMARKS/////////


        $data['_view'] = 'comutation/multigenerationProfile';
        $this->load->view('layouts/main', $data);
    }


    function pushSroNgdrs()
    {
        $dharitree = $this->input->get('case_no');
        $basundhara = $this->input->get('app');
        $this->db->trans_begin();
        $result = $this->cofieldmutationmodel->pushSroNgdrsApi();
        //var_dump($result);die;
        $result = json_decode($result);
        if ($result->status == 'success') {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', "Application Sent to SRO Office for Case no : " . $dharitree);
            redirect('cofieldmutation/getPendingFMCases');
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "Found Error. Please Try again");
            redirect('/home');
        }
    }
}
