<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
ini_set('memory_limit', '-1');
set_time_limit(0);

class CompositeService extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->model('mutation/mutationmodel');
        $this->user_code = $this->session->userdata('user_code');
        $location = $this->utilityclass->getLocationfromSession();
        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];
        $define_date = define_date;
        $year_no = year_no;
        $this->load->model('basundhara/basundharamodel');
        $this->load->model('rtps/rtpsmodel');
        $this->load->model('AgriStackCaseHistory');

        if(ENABLED_BLOCKCHAIN == 1)
            {
                $this->load->model('propChain/PropChainModel');
                $this->load->model('propChain/PropChainCommonModel');
            }
    }

    public function dbswitch()
    {
        $CI =& get_instance();
        if ($this->session->userdata('dist_code') == "02") {
            $this->db = $CI->load->database('dha3', TRUE);
        } else if ($this->session->userdata('dist_code') == "05") {
            $this->db = $CI->load->database('dha1', TRUE);
        } else if ($this->session->userdata('dist_code') == "10") {
            $this->db = $CI->load->database('dha24', TRUE);
        } else if ($this->session->userdata('dist_code') == "13") {
            $this->db = $CI->load->database('dha2', TRUE);
        } else if ($this->session->userdata('dist_code') == "17") {
            $this->db = $CI->load->database('dha4', TRUE);
        } else if ($this->session->userdata('dist_code') == "15") {
            $this->db = $CI->load->database('dha5', TRUE);
        } else if ($this->session->userdata('dist_code') == "14") {
            $this->db = $CI->load->database('dha6', TRUE);
        } else if ($this->session->userdata('dist_code') == "07") {
            $this->db = $CI->load->database('dha7', TRUE);
        } else if ($this->session->userdata('dist_code') == "03") {
            $this->db = $CI->load->database('dha8', TRUE);
        } else if ($this->session->userdata('dist_code') == "18") {
            $this->db = $CI->load->database('dha9', TRUE);
        } else if ($this->session->userdata('dist_code') == "12") {
            $this->db = $CI->load->database('dha13', TRUE);
        } else if ($this->session->userdata('dist_code') == "24") {
            $this->db = $CI->load->database('dha10', TRUE);
        } else if ($this->session->userdata('dist_code') == "06") {
            $this->db = $CI->load->database('dha11', TRUE);
        } else if ($this->session->userdata('dist_code') == "11") {
            $this->db = $CI->load->database('dha12', TRUE);
        } else if ($this->session->userdata('dist_code') == "12") {
            $this->db = $CI->load->database('dha13', TRUE);
        } else if ($this->session->userdata('dist_code') == "16") {
            $this->db = $CI->load->database('dha14', TRUE);
        } else if ($this->session->userdata('dist_code') == "32") {
            $this->db = $CI->load->database('dha15', TRUE);
        } else if ($this->session->userdata('dist_code') == "33") {
            $this->db = $CI->load->database('dha16', TRUE);
        } else if ($this->session->userdata('dist_code') == "34") {
            $this->db = $CI->load->database('dha17', TRUE);
        } else if ($this->session->userdata('dist_code') == "21") {
            $this->db = $CI->load->database('dha18', TRUE);
        } else if ($this->session->userdata('dist_code') == "08") {
            $this->db = $CI->load->database('dha19', TRUE);
        } else if ($this->session->userdata('dist_code') == "35") {
            $this->db = $CI->load->database('dha20', TRUE);
        } else if ($this->session->userdata('dist_code') == "36") {
            $this->db = $CI->load->database('dha21', TRUE);
        } else if ($this->session->userdata('dist_code') == "37") {
            $this->db = $CI->load->database('dha22', TRUE);
        } else if ($this->session->userdata('dist_code') == "25") {
            $this->db = $CI->load->database('dha23', TRUE);
        } else if ($this->session->userdata('dist_code') == "39") {
            $this->db = $CI->load->database('dha39', TRUE);
        }
    }

    public function getPendingCases()
    {
        $user_desig_code = $this->session->userdata('user_desig_code');
        if(!in_array($user_desig_code, ['AST'])){
            show_error('You are not authorized to perform this action.');
        }
        $location = $this->utilityclass->getLocationfromSession();
        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];
        $sql = "select l.*, p.* from landsale l left join petition_basic p on l.appno=p.noc_no where l.distcode=? and 
            l.subcode=? and l.circode=? and l.compserv=? 
            and l.noticeserv IS NULL  and l.boallowed!=? and l.hearingdt is not null";
        $res = $this->db->query($sql, array($dist_code, $subdiv_code, $cir_code, 'Y','Y','Reject'));
        //echo $this->db->last_query();
        $data['cases'] = array();
        if ($res->num_rows() > 0) {
            $data['cases'] = $res->result();
        }
        //var_dump($data);return;
        $data['_view'] = 'CompositeService/Pendingcases';
        $this->load->view('layouts/main', $data);
    }

    public function viewPendingCase()
    {
        $user_desig_code = $this->session->userdata('user_desig_code');
        if(!in_array($user_desig_code, ['AST'])){
            show_error('You are not authorized to perform this action.');
        }

        $location = $this->utilityclass->getLocationfromSession();
        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];
        // $case_no = $this->input->get('noc_no');

        $case_no = $_GET['case_no'] = dec_param($this->input->get('noc_no'), 'case_no');
        if($_GET['case_no'] == null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }

        $sql20 = "select * from landsale where appno=? and distcode=? and 
            subcode=? and circode=? and compserv=? and  noticeserv IS NULL and boallowed!=? and hearingdt is not null";
        $res20 = $this->db->query($sql20, array($case_no, $dist_code, $subdiv_code, $cir_code, 'Y','Reject'));

        if ($res20->num_rows() == 0) {
            $this->session->set_flashdata("message", "Please check NOC case no.: " . $case_no);
            redirect(base_url() . "index.php/home");
        }

        $sql = "select * from seller where distcode=? and 
            subcode=? and circode=? and appno=?";
        $res = $this->db->query($sql, array($dist_code, $subdiv_code, $cir_code, $case_no));
        $location = null;
        if ($res->num_rows() > 0) {
            $location = $res->row();
        }
        $mouza_code = $location->mouzacode;
        $lot_no = $location->lotno;
        $vill_code = $location->villcode;

        $districtdata = $this->utilityclass->getDistrictName($dist_code);
        $subdivdata = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouzadata = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_code);
        $lotdata = $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no);
        $villagedata = $this->utilityclass->getVillageName($dist_code, $subdiv_code,
            $cir_code, $mouza_code, $lot_no, $vill_code);

        $data['location'] = array(
            'dist_code' => $districtdata,
            'subdiv_code' => $subdivdata,
            'cir_code' => $circledata,
            'mouza_pargona_code' => $mouzadata,
            'lot_no' => $lotdata,
            'vill_townprt_code' => $villagedata,
        );

        if ($res20->num_rows() > 0) {
            $noc_case = $res20->row();
            $petition_basic = new stdClass();
            $petition_basic->dist_code = $dist_code;
            $petition_basic->subdiv_code = $subdiv_code;
            $petition_basic->cir_code = $cir_code;
            $petition_basic->mouza_pargona_code = $mouza_code;
            $petition_basic->lot_no = $lot_no;
            $petition_basic->vill_townprt_code = $vill_code;
            $petition_basic->case_no = $case_no;
            $petition_basic->submission_date = $noc_case->appdate;
            $petition_basic->mut_type = '03';
            if ($noc_case->transtype == "Sale") {
                $petition_basic->trans_code = '03';
            } elseif ($noc_case->transtype == "Gift") {
                $petition_basic->trans_code = '04';
            } elseif ($noc_case->transtype == "Mortgage") {
                $petition_basic->trans_code = '08';
            } else {
                $petition_basic->trans_code = '10';
            }

            $petition_basic->add_off_name = null;
            $petition_basic->user_code = $this->session->userdata('user_code');
            $petition_basic->date_entry = $noc_case->appdate;
            $petition_basic->operation = 'E';
            $petition_basic->noc_no = $noc_case->appno;
            $petition_basic->noc_date = $noc_case->appdate;
            $petition_basic->not_fresh = 'Y';
            $petition_basic->status = 'P';
            $petition_basic->next_date_of_hearing = $noc_case->hearingdt;
        }

        $sql4 = "select * from landschedule where appno=? and distcode=? and 
            subcode=? and circode=?";
        $res4 = $this->db->query($sql4, array($case_no, $dist_code, $subdiv_code, $cir_code));

        $dags = array();
        if ($res4->num_rows() > 0) {
            $lands = $res4->result();
            foreach ($lands as $key => $d) {
                $bigha = $d->bigha;
                $katha = $d->katha;
                $lessa = $d->lessa;

                 if(in_array($dist_code, json_decode(BARAK_VALLEY))){
                    $ganda = $d->ganda;
                    $land_area = $this->getLandAreaBarak($bigha, $katha, $lessa,$ganda);

                 }

                 else{
                    $land_area = $this->getLandArea($bigha, $katha, $lessa);
                 }
                

                $array1 = (object)array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'm_dag_area_b' => $land_area['bigha_r'],
                    'm_dag_area_k' => $land_area['katha_r'],
                    'm_dag_area_lc' => $land_area['lessa_r'],
                    'm_dag_area_g' => $land_area['ganda_r'],
                    'm_dag_area_kr' => '0',
                    'patta_no' => trim($d->pattano),
                    'patta_type_code' => $d->pattatype,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'E',
                    'dag_no' => $d->dagno,
                );
                array_push($dags, $array1);
            }
        }

        $sql2 = "select * from buyer where appno=?";
        $res2 = $this->db->query($sql2, array($case_no));

        $petitioners = array();
        if ($res2->num_rows() > 0) {
            $buyers = $res2->result();
            foreach ($buyers as $key => $buyer) {
                if ($buyer->gender == 'Male') {
                    $gender = 'M';
                } elseif ($buyer->gender == 'Female') {
                    $gender = 'F';
                } else {
                    $gender = 'O';
                }
                $array = (object)array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'guard_name' => $buyer->bfnameas,
                    'guard_rel' => 'f',
                    'pet_name' => $buyer->bnameas,
                    'add1' => $buyer->pehouse,
                    'add2' => $buyer->pelocality,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'E',
                    'new_pattadar' => 'N',
                    'pet_gender' => $gender,
                    'pet_mother' => $buyer->bmnameas,
                    'pet_minor_yn' => 'N',
                    'pdar_mobile' => $buyer->mobno,
                    'applied_b' => 0,
                    'applied_k' => 0,
                    'applied_lc' => 0,
                );
                array_push($petitioners, $array);
            }
        }

        $sql5 = "select * from sellerchitha where appno=? and distcode=? and 
            subcode=? and circode=?";
        $res5 = $this->db->query($sql5, array($case_no, $dist_code, $subdiv_code, $cir_code));
        $pattadars = array();
        if ($res5->num_rows() > 0) {
            $sellers = $res5->result();
            foreach ($sellers as $key => $p) {
                $sql6 = "select * from seller 
                where appno=? and distcode=? and 
                subcode=? and circode=?";
                $res6 = $this->db->query($sql6, array($case_no, $dist_code,
                    $subdiv_code, $cir_code));
                $pdar_add1=$pdar_add2 = null;
                $gender = null;
                if ($res6->num_rows() > 0) {
                    $pdar_add1 = $res6->row()->pehouse ;
                    $pdar_add2 = $res6->row()->pelocality ;

                    if ($res6->row()->gender == 'Male') {
                        $gender = 'M';
                    } elseif ($res6->row()->gender == 'Female') {
                        $gender = 'F';
                    } else {
                        $gender = 'O';
                    }
                }

                $array2 = (object)array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $p->dagno,
                    'patta_no' => $p->pattano,
                    'patta_type_code' => $p->pattatype,
                    'pdar_id' => $p->pattadarid,
                    'pdar_name' => $p->pattadarnm,
                    'pdar_gender' => $gender,
                    'pdar_guardian' => $p->pattardarfnm,
                    'pdar_mobile' => $res6->row()->mobno,
                    'pdar_rel_guar' => 'f',
                    'striked_out' => $p->inplaceof_alongwith,
                    'pdar_add1' => $pdar_add1,
                    'pdar_add2' => $pdar_add2,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'E',
                );
                array_push($pattadars, $array2);
            }
        }

        $sql31 = "select u.user_code,u.username,u.user_desig_code from users u RIGHT JOIN 
            loginuser_table l ON u.dist_code=l.dist_code 
            and u.subdiv_code=l.subdiv_code and u.cir_code=l.cir_code 
            and u.user_code=l.user_code 
            where u.dist_code=? and u.subdiv_code=? and u.cir_code=? 
            and u.user_desig_code=? and l.dis_enb_option=?";
        $res31 = $this->db->query($sql31, array($dist_code,
            $subdiv_code, $cir_code, 'CO', 'E'));
        $data['co_code'] = array();
        if ($res31->num_rows() > 0) {
            $data['co_code'] = $res31->result();
        }
        $data['noc_case'] = $noc_case;
        $data['case'] = $petition_basic;
        $data['dag_details'] = $dags;
        $data['petitioners'] = $petitioners;
        $data['pattadars'] = $pattadars;

        $data['_view'] = 'CompositeService/viewPendingCase';
        $this->load->view('layouts/main', $data);
    }

    ////// getLandAreaCalculate ////////
    function getLandArea($b, $k, $l)
    {
        $total_lessa = ($b * 100) + ($k * 20) + $l;

        $bigha_r = floor($total_lessa / 100);
        $katha_r = floor(($total_lessa - $bigha_r * 100) / 20);
        $lessa_r = number_format($total_lessa - ($bigha_r * 100) - ($katha_r * 20), 2);

        $data = array(
            'bigha_r' => $bigha_r,
            'katha_r' => $katha_r,
            'lessa_r' => $lessa_r,
            'ganda_r' => 0,
        );
        return $data;
    }

     function getLandAreaBarak($b, $k, $l, $g)
    {
        $total_lessa = ($b * 6400) + ($k * 320) + ($l * 20) + $g;

        $bigha_r = floor($total_lessa / 6400);
        $katha_r = floor(($total_lessa - $bigha_r * 6400) / 320);
        $lessa_r = floor(($total_lessa - $bigha_r * 6400 - $katha_r * 320)/20);
        $ganda_r = $total_lessa - $bigha_r * 6400.0 - $katha_r * 320.0 - $lessa_r * 20.0;

        $data = array(
            'bigha_r' => $bigha_r,
            'katha_r' => $katha_r,
            'lessa_r' => $lessa_r,
            'ganda_r' => $ganda_r,
        );
        return $data;
    }


    /////////Case Registered By AST///////////
    function RegisterByAST()
    {
        try {
            // XSS Validation START
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
                // $this->session->set_flashdata('message', $errorMessageStr);
                // return redirect($_SERVER['HTTP_REFERER']);
                $data = [
                    'success' => false,
                    'errors' => $errorMessageStr
                ];

                return $this->output
                        ->set_status_header('403')
                        ->set_content_type('application/json')
                        ->set_output(json_encode($data)); 
            }
            // XSS Validation END
            $user_desig_code = $this->session->userdata('user_desig_code');
            if(!in_array($user_desig_code, ['AST'])){
                $data = [
                    'success' => false,
                    'errors' => 'You are not authorized to perform this action.'
                ];

                return $this->output
                        ->set_status_header('403')
                        ->set_content_type('application/json')
                        ->set_output(json_encode($data));
            }

            $location = $this->utilityclass->getLocationfromSession();
            $dist_code = $location['dist_code'];
            $subdiv_code = $location['subdiv_code'];
            $cir_code = $location['cir_code'];
            $noc_no = $this->input->post('noc_no');

            $sql20 = "select * from petition_basic where noc_no=? and dist_code=? and
                subdiv_code=? and cir_code=? and comp_serv_yn=?";
            $res20 = $this->db->query($sql20, array($noc_no, $dist_code, $subdiv_code, $cir_code, 'Y'));
            if ($res20->num_rows() > 0) {
                $data = array(
                    'msg' => "Already registered with NOC case no.: " . $noc_no . " (##AUTOM0009)",
                    'error' => true,
                    'url' => 0,
                );
                log_message("error", "##AUTOM0009. Already registered with NOC case no " . $noc_no . "
                                    for dist_code: " . $dist_code);
                echo json_encode($data);
                return;
            }

            $sql = "select * from seller where distcode=? and 
            subcode=? and circode=? and appno=?";
            $res = $this->db->query($sql, array($dist_code, $subdiv_code, $cir_code, $noc_no));
            $location = null;
            if ($res->num_rows() > 0) {
                $location = $res->row();
            }

            $mouza_code = $location->mouzacode;
            $lot_no = $location->lotno;
            $vill_code = $location->villcode;

            $this->db->trans_begin();
            $year_no = date('Y');
            $case_name = $this->basundharamodel->genearteCaseName();

            $seq_pet=year_no.'00';
            $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteOfficePetitionNo();

           // $case_no['petition_no'] = $petition_no = $this->basundharamodel->genearteOfficePetitionNo();

            $case_no = $case_name . $petition_no . "/OMUTC";
            $noc_case = null;

            $sql3 = "select * from landsale where distcode=? and 
            subcode=? and circode=? and appno=? and compserv=? 
            and noticeserv IS NULL and boallowed!=? and hearingdt is not null";
            $res3 = $this->db->query($sql3, array($dist_code,
                $subdiv_code, $cir_code, $noc_no, 'Y','Reject'));

            if ($res3->num_rows() > 0) {
                $noc_case = $res3->row();
                if ($noc_case->transtype == "Sale") {
                    $trans_code = '03';
                } elseif ($noc_case->transtype == "Gift") {
                    $trans_code = '04';
                } elseif ($noc_case->transtype == "Mortgage") {
                    $trans_code = '08';
                } else {
                    $trans_code = '10';
                }
                $co_code_id = $this->input->post('co_code');
                $sql31 = "select u.user_code from users u RIGHT JOIN 
                loginuser_table l ON u.dist_code=l.dist_code 
                and u.subdiv_code=l.subdiv_code and u.cir_code=l.cir_code 
                and u.user_code=l.user_code 
                where u.dist_code=? and u.subdiv_code=? and u.cir_code=? 
                and u.user_desig_code=? and l.dis_enb_option=? and l.user_code=?";
                $res31 = $this->db->query($sql31, array($dist_code,
                    $subdiv_code, $cir_code, 'CO', 'E', $co_code_id));
                $co_code = null;

                if ($res31->num_rows() > 0) {
                    $co_code = $res31->row()->user_code;
                } else {
                    $data = array(
                        'msg' => "Circle Officer not found. (##AUTOM0010)",
                        'error' => true,
                        'url' => 0,
                    );
                    log_message("error", "##AUTOM0010. Circle Officer 
                            not found with NOC case no " . $noc_no . "
                            for dist_code: " . $dist_code);
                    echo json_encode($data);
                    return;
                }

                if ($noc_case->deedno == null) {
                    $deed_no = null;
                    $deed_value = null;
                    $deed_date = null;
                } else {
                    $deed_no = $noc_case->deedno;
                    $deed_value = "1000";
                    $deed_date = date('Y-m-d', strtotime(date('Y-m-d G:i:s')));
                }

                $petition_basic = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'year_no' => $year_no,
                    'petition_no' => $petition_no,
                    'case_no' => $case_no,
                    'submission_date' => date('Y-m-d G:i:s'),
                    'mut_type' => '03',
                    'trans_code' => $trans_code,
                    'add_off_name' => $co_code,
                    'add_off_desig' => 'CO',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'E',
                    'deed_no' => $deed_no,
                    'deed_value' => $deed_value,
                    'deed_date' => $deed_date,
                    'noc_no' => $noc_case->appno,
                    'noc_date' => $noc_case->appdate,
                    'not_fresh' => 'Y',
                    'status' => 'P',
                    'lm_note_yn' => 'Y',
                    'lm_note_date' => date('Y-m-d G:i:s'),
                    'sk_comment' => 'Y',
                    'next_date_of_hearing' => $noc_case->hearingdt,
                    'comp_serv_yn' => 'Y',
                );

                $insert_pb = $this->db->insert("petition_basic", $petition_basic); //************
                if ($insert_pb == false) {
                    $this->db->trans_rollback();
                    $data = array(
                        'msg' => "Case Cannot Be Registered. Unable to save data. [##AUTOM0001]",
                        'error' => true,
                        'url' => 0,
                    );
                    log_message("error", "##AUTOM0001. Unable to save data into 
                        petition_basic for case no.: " . $case_no . ". dist_code: " . $dist_code);
                    echo json_encode($data);
                    return;
                }
            } else {
                $this->db->trans_rollback();
                $data = array(
                    'msg' => "Case Cannot Be Registered. Data not found. [##AUTOM0015]",
                    'error' => true,
                    'url' => 0,
                );
                log_message("error", "##AUTOM0015. Data not found in landsale 
                        for case no.: " . $case_no . ". dist_code: " . $dist_code);
                echo json_encode($data);
                return;
            }

            $sql4 = "select * from landschedule where appno=? and distcode=? and 
            subcode=? and circode=?";
            $res4 = $this->db->query($sql4, array($noc_no, $dist_code, $subdiv_code, $cir_code));

            if ($res4->num_rows() > 0) {
                $lands = $res4->result();
                $note_no = 1;
                foreach ($lands as $key => $d) {
                    $bigha = $d->bigha;
                    $katha = $d->katha;
                    $lessa = $d->lessa;

                   if(in_array($dist_code, json_decode(BARAK_VALLEY))){
                    $ganda = $d->ganda;
                    $land_area = $this->getLandAreaBarak($bigha, $katha, $lessa,$ganda);

                    }

                    else{
                    $land_area = $this->getLandArea($bigha, $katha, $lessa);
                    }

                    $dags_data = array(
                        'dist_code' => $dist_code,
                        'subdiv_code' => $subdiv_code,
                        'cir_code' => $cir_code,
                        'mouza_pargona_code' => $mouza_code,
                        'lot_no' => $lot_no,
                        'vill_townprt_code' => $vill_code,
                        'year_no' => $year_no,
                        'petition_no' => $petition_no,
                        'm_dag_area_b' => $land_area['bigha_r'],
                        'm_dag_area_k' => $land_area['katha_r'],
                        'm_dag_area_lc' => $land_area['lessa_r'],
                        'm_dag_area_g' => $land_area['ganda_r'],
                        'm_dag_area_kr' => '0',
                        'patta_no' => trim($d->pattano),
                        'patta_type_code' => $d->pattatype,
                        'user_code' => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d G:i:s'),
                        'operation' => 'E',
                        'dag_no' => $d->dagno,
                        'case_no' => $case_no
                    );

                    $check_land_details= "select * from chitha_basic where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and trim(dag_no)=? and trim(patta_no)=? and patta_type_code=?";
                    $check_land_details_res = $this->db->query($check_land_details, array($dist_code,
                        $subdiv_code, $cir_code,$mouza_code,$lot_no,$vill_code,$d->dagno,$d->pattano,$d->pattatype));
                    

                    if($check_land_details_res->num_rows()==1){

                    $insert_dag_details = $this->db->insert("petition_dag_details", $dags_data);//************
                    if ($insert_dag_details == false) {
                        $this->db->trans_rollback();
                        $data = array(
                            'msg' => "Case Cannot Be Registered. Unable to save data. [##AUTOM0003]",
                            'error' => true,
                            'url' => 0,
                        );
                        log_message("error", "##AUTOM0003. Unable to save data into 
                        petition_dag_details for case no.: " . $case_no . ". dist_code: " . $dist_code);
                        echo json_encode($data);
                        return;
                    }
                    }
                    else{

                        $this->db->trans_rollback();
                        $data = array(
                            'msg' => "Case Cannot Be Registered. Contact technical team. [##AUTOMSNF002]",
                            'error' => true,
                            'url' => 0,
                        );
                        log_message("error", "##AUTOMSNF002. Data mismatch in landschedule and chitha for case no.: " . $noc_no.json_encode($this->db->last_query()));
                        echo json_encode($data);
                        return;

                    }
                    
                    $sql20 = "select * from lmreport where appno=? and slno='1'";
                    $res20 = $this->db->query($sql20, array($noc_no));

                    if ($res20->num_rows() > 0) {
                        $noc_lm_code = null;
                        $sql50 = "select user_code from loginuser_table where nocuser=? and dist_code=? and 
                            subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=?";
                        $res50 = $this->db->query($sql50, array($noc_case->lmcode, $dist_code,
                            $subdiv_code, $cir_code, $mouza_code, $lot_no));
                        if ($res50->num_rows() > 0) {
                            $noc_lm_code = $res50->row()->user_code;
                        }
                        $lm_note = $res20->row()->remarks;
                        $lm_note_date = $res20->row()->repdate;
                        $lm_note_data = array(
                            'dist_code' => $dist_code,
                            'subdiv_code' => $subdiv_code,
                            'cir_code' => $cir_code,
                            'mouza_pargona_code' => $mouza_code,
                            'lot_no' => $lot_no,
                            'vill_townprt_code' => $vill_code,
                            'year_no' => $year_no,
                            'petition_no' => $petition_no,
                            'dag_no' => $d->dagno,
                            'note_no' => $note_no++,
                            'mut_b' => $land_area['bigha_r'],
                            'mut_k' => $land_area['katha_r'],
                            'mut_lc' => $land_area['lessa_r'],
                            'mut_g' => $land_area['ganda_r'],
                            'mut_kr' => '0',
                            'trans_code' => $trans_code,
                            'report_on_possession' => $lm_note,
                            'user_code' => $this->session->userdata('user_code'),
                            'date_entry' => date('Y-m-d G:i:s'),
                            'operation' => 'E',
                            'lm_sign_yn' => 'Y',
                            'lm_code' => $noc_lm_code,
                            'lm_sign_date' => date('Y-m-d', strtotime($lm_note_date)),
                            'sk_sign_yn' => 'Y',
                            'sk_note' => 'NA',
                            'case_no' => $case_no
                        );
                        $insert_lm_note = $this->db->insert("petition_lm_note", $lm_note_data);//************
                        if ($insert_lm_note == false) {
                            $this->db->trans_rollback();
                            $data = array(
                                'msg' => "Case Cannot Be Registered. Unable to save data. [##AUTOM0066]",
                                'error' => true,
                                'url' => 0,
                            );
                            log_message("error", "##AUTOM0066. Unable to save data into 
                        petition_lm_note for case no.: " . $case_no . ". dist_code: " . $dist_code);
                            echo json_encode($data);
                            return;
                        }
                    }
                }
            } else {
                $this->db->trans_rollback();
                $data = array(
                    'msg' => "Case Cannot Be Registered. Data not found. [##AUTOM0016]",
                    'error' => true,
                    'url' => 0,
                );
                log_message("error", "##AUTOM0016. Data not found in landschedule 
                        for case no.: " . $case_no . ". dist_code: " . $dist_code);
                echo json_encode($data);
                return;
            }

            $sql2 = "select * from buyer where appno=?";
            $res2 = $this->db->query($sql2, array($noc_no));

            $i = 1;
            if ($res2->num_rows() > 0) {
                $buyers = $res2->result();
                foreach ($buyers as $key => $buyer) {
                    if ($buyer->gender == 'Male') {
                        $gender = 'M';
                    } elseif ($buyer->gender == 'Female') {
                        $gender = 'F';
                    } else {
                        $gender = 'O';
                    }

                    if ($buyer->is_token == 'Y') {
                        $auth_type = 'AADHAAR';
                        $id_ref_no = $buyer->ekyc_token;
                    } 
                    elseif ($buyer->is_pan_verified == 'Y') {
                       $auth_type = 'PAN';
                       $id_ref_no = $buyer->pan;
                    }
                    else {
                        $auth_type = null;
                        $id_ref_no = null;
                    }


                    $petitioner_data = array(
                        'dist_code' => $dist_code,
                        'subdiv_code' => $subdiv_code,
                        'cir_code' => $cir_code,
                        'mouza_pargona_code' => $mouza_code,
                        'lot_no' => $lot_no,
                        'vill_townprt_code' => $vill_code,
                        'year_no' => $year_no,
                        'petition_no' => $petition_no,
                        'pet_id' => $i++,
                        'guard_name' => $buyer->bfnameas,
                        'guard_rel' => 'f',
                        'pet_name' => $buyer->bnameas,
                        'add1' => $buyer->pehouse,
                        'add2' => $buyer->pelocality,
                        'user_code' => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d G:i:s'),
                        'operation' => 'E',
                        'new_pattadar' => 'N',
                        'pet_gender' => $gender,
                        'pet_mother' => $buyer->bmnameas,
                        'pet_minor_yn' => 'N',
                        'pdar_mobile' => $buyer->mobno,
                        'applied_b' => round($buyer->tbigha),
                        'applied_k' => round($buyer->tkatha),
                        'applied_lc' => $buyer->tlessa,
                        'case_no' => $case_no,
                        'pdar_name_eng' => $buyer->bname,
                        'pdar_guard_eng' => $buyer->bfname,
                        'auth_type'  => $auth_type,
                        'id_ref_no' => $id_ref_no
                    );
                    $insert_petitioner = $this->db->insert("petitioner", $petitioner_data); //************
                    if ($insert_petitioner == false) {
                        $this->db->trans_rollback();
                        $data = array(
                            'msg' => "Case Cannot Be Registered. Unable to save data. [##AUTOM0002]",
                            'error' => true,
                            'url' => 0,
                        );
                        log_message("error", "##AUTOM0002. Unable to save data into 
                        petitioner for case no.: " . $case_no . ". dist_code: " . $dist_code);
                        echo json_encode($data);
                        return;
                    }
                }
            } else {
                $this->db->trans_rollback();
                $data = array(
                    'msg' => "Case Cannot Be Registered. Data not found. [##AUTOM0017]",
                    'error' => true,
                    'url' => 0,
                );
                log_message("error", "##AUTOM0017. Data not found in buyer 
                        for case no.: " . $case_no . ". dist_code: " . $dist_code);
                echo json_encode($data);
                return;
            }

            // $sql5 = "select * from sellerchitha where appno=? and distcode=? and 
            // subcode=? and circode=?";
            // $res5 = $this->db->query($sql5, array($noc_no, $dist_code, $subdiv_code, $cir_code));


            $sql5 = "select * from sellerchitha sc join seller s on sc.appno=s.appno and sc.pattadarid=cast(s.pattadar as integer) and sc.dagno=s.dagno and sc.pattano=s.pattano where sc.appno=? and sc.distcode=? and 
            sc.subcode=? and sc.circode=?";

            $res5 = $this->db->query($sql5, array($noc_no, $dist_code, $subdiv_code, $cir_code));
        
            if($res5->num_rows() <= 0){
                $this->db->trans_rollback();
                $data = array(
                    'msg' => "Case Cannot Be Registered. Contact technical team. [##AUTOMSNF001]",
                    'error' => true,
                    'url' => 0,
                );
                log_message("error", "##AUTOMSNF001. Data mismatch in sellerchitha and seller for case no.: " . $noc_no.json_encode($this->db->last_query()));
                echo json_encode($data);
                return;

            }

            $cron_no = 1;
            if ($res5->num_rows() > 0) {
                $sellers = $res5->result();

                foreach ($sellers as $key => $p) {
                    $sql6 = "select * from seller 
                where appno=? and distcode=? and 
                subcode=? and circode=? ";
                    $res6 = $this->db->query($sql6, array($noc_no, $dist_code,
                        $subdiv_code, $cir_code));
                    $pdar_add1 =$pdar_add2 = null;
                    $gender = null;
                    if ($res6->num_rows() > 0) {
                        $pdar_add1 = $res6->row()->pehouse;
                        $pdar_add2 = $res6->row()->pelocality ;
                        if ($res6->row()->gender == 'Male') {
                            $gender = 'M';
                        } elseif ($res6->row()->gender == 'Female') {
                            $gender = 'F';
                        } else {
                            $gender = 'O';
                        }
                    }
                    $striked_out = null;
                    if ($p->inplaceof_alongwith == 'i') {
                        $striked_out = '1';
                    } else {
                        $striked_out = '0';
                    }
                    $pattadar_data = array(
                        'dist_code' => $dist_code,
                        'subdiv_code' => $subdiv_code,
                        'cir_code' => $cir_code,
                        'mouza_pargona_code' => $mouza_code,
                        'lot_no' => $lot_no,
                        'vill_townprt_code' => $vill_code,
                        'year_no' => $year_no,
                        'petition_no' => $petition_no,
                        'dag_no' => $p->dagno,
                        'patta_no' => $p->pattano,
                        'patta_type_code' => $p->pattatype,
                        'pdar_id' => $p->pattadarid,
                        'pdar_cron_no' => $cron_no++,
                        'pdar_name' => $p->pattadarnm,
                        'pdar_gender' => $gender,
                        'pdar_guardian' => $p->pattardarfnm,
                        'pdar_rel_guar' => 'f',
                        'striked_out' => $striked_out,
                        'pdar_add1' => $pdar_add1,
                        'pdar_add2' => $pdar_add2,
                        'user_code' => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d G:i:s'),
                        'operation' => 'E',
                        'case_no' => $case_no,
                        'pdar_mobile' =>$res6->row()->mobno,
                    );
                    // $insert_pp = $this->db->insert("petition_pattadar", $pattadar_data);//************
                    // if ($insert_pp == false) {
                    //     $this->db->trans_rollback();
                    //     $data = array(
                    //         'msg' => "Case Cannot Be Registered. Unable to save data. [##AUTOM0003]",
                    //         'error' => true,
                    //         'url' => 0,
                    //     );
                    //     log_message("error", "##AUTOM0003. Unable to save data into 
                    //     petition_pattadar for case no.: " . $case_no . ".  dist_code: " . $dist_code);
                    //     echo json_encode($data);
                    //     return;
                    // }

                    $check_seller= "select * from petition_pattadar where case_no=? and dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? and patta_no=? and pdar_id=? and patta_type_code=?";
                    $check_seller_res = $this->db->query($check_seller, array($case_no, $dist_code,
                        $subdiv_code, $cir_code,$mouza_code,$lot_no,$vill_code,$p->dagno,$p->pattano,$p->pattadarid,$p->pattatype));

                    if($check_seller_res->num_rows()==0)
                    {

                    $insert_pp = $this->db->insert("petition_pattadar", $pattadar_data);//************
                      if ($insert_pp == false) {
                        $this->db->trans_rollback();
                        $data = array(
                            'msg' => "Case Cannot Be Registered. Unable to save data. [##AUTOM0003]",
                            'error' => true,
                            'url' => 0,
                        );
                        log_message("error", "##AUTOM0003. Unable to save data into 
                        petition_pattadar for case no.: " . $case_no . ".  dist_code: " . $dist_code);
                        echo json_encode($data);
                        return;
                        }

                    }
                    else{
                        continue;
                    }
                }
            } else {
                $this->db->trans_rollback();
                $data = array(
                    'msg' => "Case Cannot Be Registered. Seller not found. [##AUTOM0018]",
                    'error' => true,
                    'url' => 0,
                );
                log_message("error", "##AUTOM0018. Data not found in sellerchitha for case no.: " . $case_no . ". 
                        dist_code: " . $dist_code);
                echo json_encode($data);
                return;
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $data = array(
                    'msg' => "Case Cannot Be Registered. Transaction is failed. [##AUTOM0004]",
                    'error' => true,
                    'url' => 0,
                );
                log_message("error", "##AUTOM0004. Trans_status is failed. case no.: " . $case_no . " 
                for dist_code: " . $dist_code);
                echo json_encode($data);
                return;
            } else {
                $DashboardResult = $this->Dashboard($case_no, $res3->row()->hearingdt);
                if ($DashboardResult['error'] == true) {
                    $this->db->trans_rollback();
                    echo json_encode($DashboardResult);
                    return;
                }
                /////composite_service
                $comp_array5 = [
                    'case_no' => $case_no,
                    'user_code' => $this->user_code,
                    'status' => 'P',
                    'remark' => 'Registered by AST',
                    'entry_date' => date('Y-m-d'),
                ];
                $data5 = $this->db->insert('composite_service', $comp_array5);
                if ($data5 != 1) {
                    $this->db->trans_rollback();
                    log_message("error", " #COMPTABLE004 Unable to insert into composite_service 
                        district: " . $dist_code . ", case no: " . $case_no);
                    $array = array(
                        'error' => true,
                        'redirect_url' => 0,
                        'msg' => "#COMPTABLE004 Unable to update data.",
                    );
                    echo json_encode($array);
                    return;
                }

                $this->db->trans_commit();
                $this->session->set_flashdata("message", "New Case with case no.: " . $case_no . " Registered !!");
                $case_no = enc_param('case_no', $case_no, 600);
                $data = array(
                    'msg' => "New Case with case no " . $case_no . " Registered !!",
                    'error' => false,
                    'url' => "?case_no=" . $case_no . "&dist_code=" . $dist_code . "&subdiv_code=" . $subdiv_code . "&cir_code=" . $cir_code . "&mouza_pargona_code=" . $mouza_code . "&lot_no=" . $lot_no . "&vill_townprt_code=" . $vill_code,
                );
                echo json_encode($data);
                return;
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message("error", "##AUTOM0012. Exception Error. case no " . $case_no . "
            for dist_code: " . $dist_code);
            $data = array(
                'msg' => "Case Cannot Be Registered. Exception Error. [##AUTOM0012]",
                'error' => true,
                'url' => 0,
            );
            echo json_encode($data);
            return;
        }
    }

    ///////////////Dashboard Data Insert////////////
    function Dashboard($case_no, $hearing_date)
    {
        $sql = "Select pb.*,pd.dag_no,pd.patta_no,pd.patta_type_code from 
            petition_basic pb join petition_dag_details pd on pb.dist_code=pd.dist_code 
            and pb.subdiv_code=pd.subdiv_code and pb.cir_code=pd.cir_code 
            and pb.mouza_pargona_code=pd.mouza_pargona_code and pb.lot_no=pd.lot_no 
            and pb.vill_townprt_code=pd.vill_townprt_code and pb.year_no=pd.year_no
            and pb.petition_no=pd.petition_no 
            where  pb.mut_type=? and pb.case_no=? ";
        $res1 = $this->db->query($sql, array('03', $case_no));
        if ($res1->num_rows() == 0) {
            $data = array(
                'msg' => "Case Cannot Be Registered. Data not found. [##AUTOM0006]",
                'error' => true,
                'url' => 0,
            );
            log_message("error", "##AUTOM0006. Data not found in 
            petition_basic or petition_dag_details. Case no. $case_no");
            return $data;
        }
        $data = $res1->row_array();
        $pb = $res1->row();
        if ($data['mut_type'] == '03') {
            $type = 'OM';
        }
        $dist_code = $data['dist_code'];
        $subdiv_code = $data['subdiv_code'];
        $cir_code = $data['cir_code'];
        $mouza_pargona_code = $data['mouza_pargona_code'];
        $lot_no = $data['lot_no'];
        $vill_townprt_code = $data['vill_townprt_code'];
        $base = array(
            'dist_code' => $data['dist_code'],
            'subdiv_code' => $data['subdiv_code'],
            'cir_code' => $data['cir_code'],
            'mouza_pargona_code' => $data['mouza_pargona_code'],
            'lot_no' => $data['lot_no'],
            'vill_townprt_code' => $data['vill_townprt_code'],
            'case_no' => $data['case_no'],
            'date_of_reg' => $data['date_entry'],
            'status' => 'P',
            'pending_with_user' => 'CO',
            'case_type' => $type,
            'date_of_insert' => date("Y-m-d h:i:s")
        );

        $insert_dashboard_data2 = $this->db->insert('dashboard_data', $base);
        if ($insert_dashboard_data2 == false) {
            $data = array(
                'msg' => "Case Cannot Be Registered. Unable to save data. [##AUTOM0007]",
                'error' => true,
                'url' => 0,
            );
            log_message("error", "##AUTOM0007. Unable to save data into 
                        dashboard_data (db). case no. $case_no");
            return $data;
        }


        $ip=$this->utilityclass->checkIp($this->utilityclass->get_client_ip());
        if ($ip == true){
            log_message('error', '##ERR_ACRSIP0001: Access denied for this action. IP ' . $this->utilityclass->get_client_ip() . ' is Restricted.');
            return [
                        'msg' => "##ERR_ACRSIP0001: Access denied for this action.",
                        'error' => true,
                        'url' => 0,
                    ];
        }

        $action = array(
            'case_no' => $case_no,
            'user_code' => $this->session->userdata('user_code'),
            'date_of_action_taken' => date("Y-m-d h:i:s"),
            'user_designation' => $this->session->userdata('user_desig_code'),
            'ip_address' => $this->utilityclass->get_client_ip(),
            'remark' => 'Registered By Assistant'
        );
        $dashboard_action3 = $this->db->insert('dashboard_action', $action);
        if ($dashboard_action3 == false) {
            $data = array(
                'msg' => "Case Cannot Be Registered. Unable to save data. [##AUTOM0008]",
                'error' => true,
                'url' => 0,
            );
            log_message("error", "##AUTOM0008. Unable to save data into 
                        dashboard_action (db). case no. $case_no");
            return $data;
        }
        $co_note = null;
        $sql20 = "select * from circlereport where appno=? and distcode=? and 
                    subcode=? and circode=? and slno='1'";
        $res20 = $this->db->query($sql20, array($pb->noc_no, $dist_code, $subdiv_code, $cir_code));
        if ($res20->num_rows() > 0) {
            $co_note = $res20->row()->conote;
        }
        $proceeding = array(
            'case_no' => $case_no,
            'proceeding_id' => 1,
            'date_of_hearing' => $hearing_date,
            'co_order' => $co_note,
            'next_date_of_hearing' => $hearing_date,
            'status' => '0',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date("Y-m-d h:i:s"),
            'operation' => 'E',
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'ip' => $this->utilityclass->get_client_ip(),
        );
        $proceeding1 = $this->db->insert('petition_proceeding', $proceeding);
        if ($proceeding1 == false) {
            $data = array(
                'msg' => "Case Cannot Be Registered. Unable to save data. [##AUTOM0018]",
                'error' => true,
                'url' => 0,
            );
            log_message("error", "##AUTOM0018. Unable to save data into 
                        petition_proceeding. case no. $case_no");
            return $data;
        }
        $data = array(
            'msg' => "ok",
            'error' => false,
            'url' => 0,
        );
        return $data;
    }

    //////// issueNotice view///////////
    function issueNotice()
    {
        $user_desig_code = $this->session->userdata('user_desig_code');
        if(!in_array($user_desig_code, ['AST'])){
            show_error('You are not authorized to perform this action.');
        }

        //$case_no = $this->input->get('case_no');
        if ($this->input->server('REQUEST_METHOD') == 'GET')
          {
            $_GET['case_no'] = dec_param($this->input->get('case_no'), 'case_no');
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

        $location = $this->utilityclass->getLocationfromSession();
        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];

        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $year_no = year_no;

        $detailsQuery = "select * from petition_basic where 
            case_no =? and dist_code =? 
            and subdiv_code =? and cir_code =? 
            and mouza_pargona_code =? and lot_no =? "
            . "and vill_townprt_code =? and comp_serv_yn=?";

        $data['details'] = null;
        $details = $this->db->query($detailsQuery, array($case_no, $dist_code,
            $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code,'Y'));
        if ($details->num_rows() > 0) {
            $data['details'] = $details->row();
        }
        $data['landsale'] = null;
        $landsalesql = "select automut from landsale where 
        appno =? and distcode =? 
        and subcode =? and circode =? and compserv=? and hearingdt is not null";

        $landsaleres = $this->db->query($landsalesql, array($details->row()->noc_no, $dist_code,
            $subdiv_code, $cir_code,'Y'));
        if ($details->num_rows() > 0) {
            $data['landsale'] = $landsaleres->row();
        }
        $data['dags'] = array();
        $dagQuery = "select * from petition_dag_details where 
            petition_no =? and dist_code =? 
            and subdiv_code =? and cir_code =?
            and mouza_pargona_code =? and lot_no =? "
            . "and vill_townprt_code =? and case_no =?";
        $dags = $this->db->query($dagQuery, array($details->row()->petition_no,
            $dist_code, $subdiv_code, $cir_code,
            $mouza_pargona_code, $lot_no, $vill_townprt_code, $case_no));
        if ($dags->num_rows() > 0) {
            $data['dags'] = $dags->result();
        }

        $data['applicants'] = array();
        $applicantQuery = "select * from petitioner where 
            petition_no =? and dist_code =? and subdiv_code =? 
            and cir_code =? and mouza_pargona_code =? and lot_no =? "
            . "and vill_townprt_code =? and case_no =? ";
        $applicants = $this->db->query($applicantQuery, array($details->row()->petition_no,
            $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code,
            $lot_no, $vill_townprt_code, $case_no));
        if ($applicants->num_rows() > 0) {
            $data['applicants'] = $applicants->result();
        }

        $data['pattadars'] = array();
        $pattadarQuery = "select * from petition_pattadar where 
            petition_no =? and dist_code =? 
            and subdiv_code =? and cir_code =? and mouza_pargona_code =? 
            and lot_no =? and vill_townprt_code =? and case_no =?";
        $pattadars = $this->db->query($pattadarQuery, array($details->row()->petition_no,
            $dist_code, $subdiv_code, $cir_code,
            $mouza_pargona_code, $lot_no,
            $vill_townprt_code, $case_no));
        if ($pattadars->num_rows() > 0) {
            $data['pattadars'] = $pattadars->result();
        }

        $data['notifyname'] = array();
        $notifyPerson = "Select * from petition_notified where 
            petition_no =? and dist_code =? 
            and subdiv_code =? and cir_code =? and mouza_pargona_code =? 
            and lot_no =? and vill_townprt_code =?";
        $notifyResult = $this->db->query($notifyPerson, array($details->row()->petition_no,
            $dist_code, $subdiv_code, $cir_code,
            $mouza_pargona_code, $lot_no, $vill_townprt_code));
        if ($notifyResult->num_rows() > 0) {
            $data['notifyname'] = $notifyResult->result();
        }

        $data['case_no'] = $case_no;
        if(in_array($dist_code, json_decode(BARAK_VALLEY))){
            $data['_view'] = 'CompositeService/issueNotice_kar';
        }
        else
        {
            $data['_view'] = 'CompositeService/issueNotice';
        }
        $this->load->view('layouts/main', $data);
    }

    ////submit issueNotice /
    public function issueNoticeSuccess()
    {
        // XSS Validation START
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
            // return redirect($_SERVER['HTTP_REFERER']);
            return redirect(base_url('index.php/CompositeService/compServiceOldNotice'));
        }
        // XSS Validation END
        $user_desig_code = $this->session->userdata('user_desig_code');
        if(!in_array($user_desig_code, ['AST'])){
            $this->session->set_flashdata('message', 'You are not authorized to perform this action.');
            return redirect(base_url('index.php/CompositeService/compServiceOldNotice'));
        }

        $db = $this->session->userdata('db');
        $this->db->trans_begin();
        $case_no = $this->input->post('case_no');
        $location = $this->utilityclass->getLocationfromSession();
        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');
        $hearing_date = $this->input->post('hearing_date');

        $query = "update petition_basic set notice_generated_yn=?,
            notice_generated_date='" . date('Y-m-d G:i:s') . "',
            notice_served_yn=?, proceeding_yn=?, note_action_yn=?,
            next_date_of_hearing=? where case_no=? and dist_code =? 
            and subdiv_code =? and cir_code =? 
            and mouza_pargona_code =? and lot_no =? "
            . "and vill_townprt_code =? and comp_serv_yn=? and status!=?";
        $this->db->query($query, array('Y', 'Y', '1', 'Y', $hearing_date,$case_no, $dist_code, $subdiv_code,
            $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, 'Y', 'F'));

        if ($this->db->affected_rows() != 1) {
            $this->db->trans_rollback();
            $this->session->set_flashdata(array('message' => "Error: [##AUTOM0013]. Notice Generation 
            Failed for Case No : $case_no"));
            log_message("error", "##AUTOM0013. Notice Generation 
            Failed for Case No :" . $case_no);
            redirect(base_url() . "index.php/home");
        }
        $penUser = 'CO';
        $rmrk = 'Notice Generated By Assistant';
        $dashboard = $this->DashboardData($case_no, $penUser, $rmrk);
        if ($dashboard['error'] == true) {
            $this->db->trans_rollback();
            $this->session->set_flashdata(array('message' => $dashboard['msg']));
            redirect(base_url() . "index.php/home");
        }
        $sql2 = "select noc_no from petition_basic where
                case_no=? and dist_code=? and subdiv_code=? and cir_code=?";
        $res2 = $this->db->query($sql2, array($case_no, $dist_code, $subdiv_code, $cir_code));
        if ($res2->num_rows() == 1) {
            $sql3 = "update landsale set noticeserv=?, noticeservdt=? where 
                 appno=? and distcode=? and subcode=? and circode=?";
            $this->db->query($sql3, array('Y', date("Y-m-d"),
                $res2->row()->noc_no, $dist_code, $subdiv_code, $cir_code));

            if ($this->db->affected_rows() != 1) {
                $this->db->trans_rollback();
                log_message("error", "##AUTOM0022. Unable to update data 
                in landsale (NOC) for case no.: " . $case_no . " 
                for dist_code: " . $dist_code);
                $this->session->set_flashdata(array('message' => "Unable to update data. [##AUTOM0022]"));
                redirect(base_url() . "index.php/home");
            }
        }else{
                $this->db->trans_rollback();
                log_message("error", "##AUTOM1022. Unable to Find data 
                in Petition Basic for case no.: " . $case_no . " 
                for dist_code: " . $dist_code);
                $this->session->set_flashdata(array('message' => "Unable to Find data. [##AUTOM1022]"));
                redirect(base_url() . "index.php/home");
        }
        $note_on_order = 'As per the fixed time period the notice has been served automatically.';
        $user_code = $this->session->userdata('user_code');
        $ip = $this->utilityclass->get_client_ip();

        $query = "update petition_proceeding set note_on_order=?,
                user_code=?, ip=? where case_no=? and dist_code=? "
            . "and subdiv_code=? and cir_code=? and proceeding_id=?";
        $this->db->query($query, array($note_on_order, $user_code,$ip, $case_no, $dist_code, $subdiv_code, $cir_code, '1'));
        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message("error", "##AUTOM0020. Unable to update data
                in petition_proceeding for case no.: " . $case_no . "
                for dist_code: " . $dist_code . 'Last Query => ' . $this->db->last_query());
            $this->session->set_flashdata(array('message' => "Unable to update data. [##AUTOM0020]"));
            redirect(base_url() . "index.php/home");
        }
        /////composite_service
        $comp_array5 = [
            'case_no' => $case_no,
            'user_code' => $this->user_code,
            'status' => 'P',
            'remark' => 'Notice Generated by AST',
            'entry_date' => date('Y-m-d'),
        ];
        $data5 = $this->db->insert('composite_service', $comp_array5);
        if ($data5 != 1) {
            $this->db->trans_rollback();
            log_message("error", " #COMPTABLE005 Unable to insert into composite_service 
                        district: " . $dist_code . ", case no: " . $case_no);
            $array = array(
                'error' => true,
                'redirect_url' => 0,
                'msg' => "#COMPTABLE005 Unable to update data.",
            );
            echo json_encode($array);
            return;
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message("error", "##AUTOM0013.Trans_status is failed. case no.: " . $case_no . " 
                for dist_code: " . $dist_code);
            $this->session->set_flashdata(array('message' => "Notice generate failed. [##AUTOM0013]"));
            redirect(base_url() . "index.php/home");
        } else {
            $this->db->trans_commit();
            // $this->session->set_flashdata(array('message' => "Notice Generated for case no : $case_no"));
            // redirect(base_url() . "index.php/home");
            $this->session->set_flashdata(array('success_message' => "Notice Generated for case no : $case_no"));
            
            $case_no = enc_param('case_no', $case_no, 600);
            $request_params = "?case_no=$case_no&dist_code=$dist_code&subdiv_code=$subdiv_code&cir_code=$cir_code&mouza_pargona_code=$mouza_pargona_code&lot_no=$lot_no&vill_townprt_code=$vill_townprt_code";
            return redirect(base_url('index.php/CompositeService/issueNotice'.$request_params));
            // return redirect($_SERVER['HTTP_REFERER']);
        }
    }

    function DashboardData($case_no, $penUser, $rmrk)
    {
        //////////////Update Dashboard Database///////////////////////
        $base = array(
            'pending_with_user' => $penUser,
            'date_of_update' => date("Y-m-d h:i:s")
        );
        $this->db->where('case_no', $case_no);
        $this->db->update('dashboard_data', $base);
        if ($this->db->affected_rows() == 0) {
            log_message("error", "##AUTOM0014. Unable to 
            update data into dashboard_data for Case No: " . $case_no);

            $array = array(
                "error" => true,
                "msg" => "Error: [##AUTOM0014].Unable to update data into dashboard_data for Case No : $case_no",
            );
            return $array;
        }

        $ip=$this->utilityclass->checkIp($this->utilityclass->get_client_ip());
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
        $insert_dash = $this->db->insert('dashboard_action', $action);
        if ($insert_dash == false) {
            log_message("error", "##AUTOM0015. Unable to 
            save data into dashboard_action Case No: " . $case_no);
            $array = array(
                "error" => true,
                "msg" => "Error: [##AUTOM0015].Unable to save data into dashboard_action for Case No : $case_no",
            );
            return $array;
        }
        $array = array(
            "error" => false,
            "msg" => "ok",
        );
        return $array;
    }

    ////// Pending Cases for Action Taken ///
    public function getPendingCasesForActionTaken()
    {
        $location = $this->utilityclass->getLocationfromSession();
        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];
        $sql = "select * from petition_basic where dist_code=? and 
            subdiv_code=? and cir_code=? and noc_no is not null  and notice_served_yn is null
            and note_action_yn is null and notice_generated_yn=?";
        $res = $this->db->query($sql, array($dist_code, $subdiv_code, $cir_code, 'Y'));
        $data['cases'] = array();
        if ($res->num_rows() > 0) {
            $data['cases'] = $res->result();
        }

        $data['_view'] = 'CompositeService/PendingcasesForActionTaken';
        $this->load->view('layouts/main', $data);
    }

    ////// Action Taken by AST///
    public function actionTakenByAST()
    {
        $db = $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $case_no = $this->input->get('case_no');
        $data['case_no'] = $case_no;
        $dist_code_name = $this->utilityclass->getDistrictName($dist_code);
        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,
            mouza_pargona_code,date_entry,add_off_name,next_date_of_hearing,petition_no "
            . "from petition_basic where case_no='$case_no' and dist_code='$dist_code' 
            and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' 
            and vill_townprt_code = '$vill_townprt_code'")->row_array();

        $query = "select * from petition_proceeding where case_no='$case_no' 
            and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
        $details = $this->db->query($query)->result();
        $data['details'] = $details;

        $query1 = "select * from  petition_basic where case_no='$case_no' 
            and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
        $petition_basic = $this->db->query($query1)->row();

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
            'date_of_hearing' => $location['next_date_of_hearing'],
            'application_ref_no' => $petition_basic->application_ref_no,
        );
        $data['_view'] = 'CompositeService/ActionTakenByAST';
        $this->load->view('layouts/main', $data);
    }

    ////// Submit Action Taken by AST///
    function submitActionTakenByAST()
    {
        $this->db->trans_begin();
        $db = $this->session->userdata('db');
        $notes = $this->input->post('note');
        $case_no = $this->input->post('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $ip=$this->utilityclass->get_client_ip();

        foreach ($notes as $key => $value) {
            $user_code = $this->session->userdata('user_code');
            $query = "update petition_proceeding set note_on_order=?,
                user_code=?,ip=? where case_no=? and dist_code=? "
                . "and subdiv_code=? and cir_code=? and proceeding_id=?";
            $this->db->query($query, array($value, $user_code, $ip, $case_no, $dist_code, $subdiv_code, $cir_code, $key));
            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message("error", "##AUTOM00020. Unable to update data
                    in petition_proceeding for case no.: " . $case_no . "
                    for dist_code: " . $dist_code . 'Last Query => ' . $this->db->last_query());
                $this->session->set_flashdata(array('message' => "Unable to update data. [##AUTOM00020]"));
                redirect(base_url() . "index.php/home");
            }

            $query1 = "update petition_basic set notice_served_yn=?, proceeding_yn=?, note_action_yn=? where 
                     case_no=? and dist_code=? and subdiv_code=? and cir_code=?";
            $this->db->query($query1, array('Y', '1', 'Y', $case_no, $dist_code, $subdiv_code, $cir_code));

            if ($this->db->affected_rows() != 1) {
                $this->db->trans_rollback();
                log_message("error", "##AUTOM0019. Unable to update data 
                in petition_basic for case no.: " . $case_no . " 
                for dist_code: " . $dist_code);
                $this->session->set_flashdata(array('message' => "Unable to update data. [##AUTOM0019]"));
                redirect(base_url() . "index.php/home");
            }

            $penUser = 'CO';
            $rmrk = 'Action taken report given by Assistant';
            $dashboard = $this->DashboardData($case_no, $penUser, $rmrk);
            if ($dashboard['error'] == true) {
                $this->db->trans_rollback();
                $this->session->set_flashdata(array('message' => $dashboard['msg']));
                redirect(base_url() . "index.php/home");
            }

            $sql2 = "select noc_no from petition_basic where
                    case_no=? and dist_code=? and subdiv_code=? and cir_code=?";
            $res2 = $this->db->query($sql2, array($case_no, $dist_code, $subdiv_code, $cir_code));
            if ($res2->num_rows() == 1) {
                $sql3 = "update landsale set noticeserv=?, noticeservdt=?, coreturn=?,coretdate=? where 
                     appno=? and distcode=? and subcode=? and circode=?";
                $this->db->query($sql3, array('Y', date("Y-m-d"), 'Y', date("Y-m-d"),
                    $res2->row()->noc_no, $dist_code, $subdiv_code, $cir_code));

                if ($this->db->affected_rows() != 1) {
                    $this->db->trans_rollback();
                    log_message("error", "##AUTOM0022. Unable to update data 
                    in landsale (NOC) for case no.: " . $case_no . " 
                    for dist_code: " . $dist_code);
                    $this->session->set_flashdata(array('message' => "Unable to update data. [##AUTOM0022]"));
                    redirect(base_url() . "index.php/home");
                }
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                log_message("error", "##AUTOM0021. Trans_status is failed. Case no.: " . $case_no . " 
                for dist_code: " . $dist_code);
                $this->session->set_flashdata(array('message' => "Action taken report failed. [##AUTOM0021]"));
                redirect(base_url() . "index.php/home");
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata(array('message' => "Action taken report given for case no $case_no"));
                redirect(base_url() . "index.php/home");
            }
        }
    }

    /////get pending cases for CO
    public function getPendingCasesCO()
    {
        $user_desig_code = $this->session->userdata('user_desig_code');
        if(!in_array($user_desig_code, ['CO'])){
            show_error('You are not authorized to perform this action.');
        }
        
        $location = $this->utilityclass->getLocationfromSession();
        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];
        $sql = "select l.*, p.* from landsale l left join petition_basic p on l.appno=p.noc_no where 
        p.dist_code=? and p.subdiv_code=? and p.cir_code=? and
        p.noc_no is not null and p.order_passed is null and p.co_chitha_corrected_yn is null
        and p.notice_served_yn=? and (p.status=? or p.status=?) 
        and p.add_off_name=? and p.comp_serv_yn=? and l.boallowed!=?";
        $res = $this->db->query($sql, array($dist_code, $subdiv_code, $cir_code,
            'Y', 'P', 'H', $this->session->userdata('user_code'),'Y','Reject'));
        $data['cases'] = array();

        if ($res->num_rows() > 0) {
            $data['cases'] = $res->result();

            foreach ($data['cases'] as $key => $r) {
                $data['cases'][$key]->lapsed = null;
                $datetime1 = new DateTime();
                $datetime2 = new DateTime(date('d-m-Y', strtotime($r->next_date_of_hearing)));
                $interval = $datetime1->diff($datetime2);
                $days = $interval->format('%R%a');
                if ($r->status == 'P' || $r->status == 'H') {
                    if ($days <= -1) {
                        $data['cases'][$key]->lapsed = abs($days);
                    }
                }
            }
        }
        $data['_view'] = 'CompositeService/PendingcasesForCO';
        $this->load->view('layouts/main', $data);
    }

    function OmutCoProceeding()
    {
        $db = $this->session->userdata('db');
        // $this->getDeedDetails();
        $this->load->model("PetitionBasic_Model");
        $location = $this->utilityclass->getLocationfromSession();
        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];
        $define_date = define_date;
        $user_code = $this->session->userdata("user_code");

        // if(in_array($dist_code,json_decode(NGDRS_DIST)))
        // {
            
        // $srodata=$this->getNgdrsdeedLHAPI($dist_code,$subdiv_code,$cir_code);
        // }

        $this->base_query = "fmb.dist_code = '$dist_code' and fmb.subdiv_code = '$subdiv_code' and fmb.cir_code = '$cir_code' and add_off_name='$user_code' and comp_serv_yn='Y'";

        $clause = $this->base_query . " and fmb.noc_no is not null and l.boallowed!='Reject' and fmb.order_passed is null and fmb.co_chitha_corrected_yn is null and fmb.notice_served_yn='Y' and (fmb.status='P' or fmb.status='H')";
        $fetch_data = $this->PetitionBasic_Model->make_datatables_com($clause);

        $data = array();
        foreach ($fetch_data as $r) {
            $mouza_pargona_code = $this->utilityclass->getMouzaName($r->dist_code, $r->subdiv_code, $r->cir_code, $r->mouza_pargona_code);
            $lot_no = $this->utilityclass->getLotName($r->dist_code, $r->subdiv_code, $r->cir_code, $r->mouza_pargona_code, $r->lot_no);
            $vill_townprt_code = $this->utilityclass->getVillageName($r->dist_code, $r->subdiv_code, $r->cir_code, $r->mouza_pargona_code, $r->lot_no, $r->vill_townprt_code);

            $location = "Mouza : " . $mouza_pargona_code . "<br> Lot No.: " . $lot_no . "<br> Vill Name: " . $vill_townprt_code;

            $entry_date = "<p class='text-success'> <i class='fa fa-calendar'></i> " . date('M jS, Y', strtotime($r->date_entry)) . "</p>";

            $datetime1 = new DateTime();
            $datetime2 = new DateTime(date('d-m-Y', strtotime($r->next_date_of_hearing)));
            $interval = $datetime1->diff($datetime2);
            $days = $interval->format('%R%a');
            $status = '';
            if ($r->status == 'P' || $r->status == 'H') {
                if ($days <= -1) {
                    $status = "<p class=\"text-danger small regular blink_me\"><i class=\"fa fa-exclamation-circle\" aria-hidden=\"true\"></i>" . " Lapsed by " . abs($days) . " days ago" . "</p>";
                }
            }
            if ($r->status == 'H') {
                $status = $status. "<br><p class=\"small bold\"><i class=\"fa fa-stop-circle\" aria-hidden=\"true\"></i>" . " Auto Mutation Stoped by CO </p>";
            }

            $sql1 = "select date_of_deed from sro_note where 
                    nocno=? and dist_code=? and subdiv_code=? 
                    and cir_code=? and mouza_pargona_code=? and 
                    lot_no=? and vill_townprt_code=?";
            $res1 = $this->db->query($sql1,array($r->noc_no,$r->dist_code,
                $r->subdiv_code, $r->cir_code, $r->mouza_pargona_code,
                $r->lot_no, $r->vill_townprt_code));
            $deed_date = null;
            $mutation_date = null;
            if($res1->num_rows() > 0)
            {
                $deed_date = strtotime($res1->row()->date_of_deed);
                $deed_auto_mutation_date = date('d/m/Y', strtotime(AUTOMUTATION_DEED_PERIOD, $deed_date));
                $notice_generated_date = strtotime($r->notice_generated_date);
                $notice_auto_mutation_date = date('d/m/Y', strtotime(AUTOMUTATION_NOTICE_PERIOD,$notice_generated_date));

                $mutation_date = $deed_auto_mutation_date>$notice_auto_mutation_date?$deed_auto_mutation_date:$notice_auto_mutation_date;
            }

            $status = $status . "<p class='text-success'> <i class='fa fa-calendar'></i> Hearing Date : " . date('d/m/Y', strtotime($r->next_date_of_hearing)) . "</p>";
           if ($r->nocupload=='Y' and $r->appissuedt!=null) {
                $status = $status. "<p class=\"small bold\"><i class=\"fa fa-file-pdf-o\" aria-hidden=\"true\"></i>" . " NOC issued. </p>";
            }
            else{
                $status = $status. "<p class=\"small bold\"><i class=\"fa fa-exclamation-circle\" aria-hidden=\"true\"></i>" . " NOC not issued. </p>";
            }
            if($deed_date == null)
            {
                $status = $status. "<p class=\"small bold\"><i class=\"fa fa-exclamation-circle\" aria-hidden=\"true\"></i>" . " Probably Deed has not been registered/Uploaded in e-Panjeeyan/NGDRS. </p>";
            }elseif($r->status == 'P') {
                $status = $status . "<p class='text-danger'> <i class='fa fa-calendar'></i> Auto Mutation Date : " . $mutation_date . "</p>";
            }

            if ($r->lm_note_yn == '' or $r->lm_note_yn == null) {
                $status = $status . "<p class='text-primary'> <i class='fa fa-exclamation-triangle red'></i> মন্ডলে প্ৰতিবেদন দিয়া নাই </p>";
            }
            if ($r->notice_generated_yn == '' or $r->notice_generated_yn == null) {
                $status = $status . "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> সহায়কৰ ঘোষনা জাৰী অপ্ৰাপ্ত</p>";
            }
            if ($r->sk_comment == '' or $r->sk_comment == null) {
                $status = $status . "<p class='text-info'> <i class='fa fa-exclamation-triangle red'></i> পৰ্য্যবেশক কাননগোৰ মন্তব্য অপ্ৰাপ্ত</p>";
            }
            if ($r->proceeding_yn == '') {
                $status = $status . "<p class='text-info'> <i class='fa fa-exclamation-triangle red'></i> সহায়কৰ মন্তব্য অপ্ৰাপ্ত</p>";
            }
            if ($r->lm_note_yn == 'Y' and $r->notice_generated_yn == 'Y' and $r->proceeding_yn == '1') {
                $link1 = base_url() . "index.php/CompositeService/finalOrderPass?case_no=" . enc_param('case_no', $r->case_no, 600) . "&dist_code=" . $r->dist_code . "&subdiv_code=" . $r->subdiv_code . "&cir_code=" . $r->cir_code . "&mouza_pargona_code=" . $r->mouza_pargona_code . "&lot_no=" . $r->lot_no . "&vill_townprt_code=" . $r->vill_townprt_code;
                $status = $status . '<a class="btn btn btn-success" href="' . $link1 . '">View Details</a>&nbsp&nbsp';

                if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                { 

                    // property chain code
                    $status = $status . ' <button type="button" data-toggle="modal" data-target="#myModal" case_no="' . $r->case_no . '" dist_code="' . $r->dist_code . '" subdiv_code="' . $r->subdiv_code . '" cir_code="' . $r->cir_code . '" mouza_pargona_code="' . $r->mouza_pargona_code . '" lot_no="' . $r->lot_no . '" vill_townprt_code="' . $r->vill_townprt_code . '" class="chainReportC btn btn-primary" style="margin: 2px;">View Property Chain</button>';
                }
            }

            if ($r->nocupload=='Y' and $r->appissuedt!=null and $deed_date == null) 
            {

                $link1 = base_url() . "index.php/CompositeService/getSronotebyNOC?noc_no=" . $r->noc_no;
                $status = $status . '<a class="btn btn btn-info" href="' . $link1 . '">Verify Deed</a>&nbsp&nbsp';
            }

            if ($r->noc_no) {
                $noc_no = "<br><span class='small font-italic red'>NOC No. :" . $r->noc_no . "</span>";
            } else {
                $noc_no = null;
            }
            $sub_array = array();
            $sub_array[] = $r->case_no . $noc_no;
            $sub_array[] = $location;
            $sub_array[] = $entry_date;
            $sub_array[] = $status;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $this->PetitionBasic_Model->get_all_data($clause),
            "recordsFiltered" => $this->PetitionBasic_Model->get_filtered_data($clause),
            "data" => $data
        );
        echo json_encode($output);
    }

    ///////get deed details/////
    public function getDeedDetails()
    {
        $db = $this->session->userdata('db');
        $location = $this->utilityclass->getLocationfromSession();
        $dis = $location['dist_code'];
        $sub = $location['subdiv_code'];
        $cir_code = $location['cir_code'];
        //WT
        $status='0';
        $algorithm = 'HS256';
        $secret = 'D2E6857E5A9F835042FB6232CF08418437F13D15637DEAE4BFF236587B49AEA1';
        $time = time();
        $leeway = 60; // seconds
        $ttl = 60; // seconds
        $claims = array('dist' => $dis, 'sub' => $sub, 'cir' => $cir_code, 'status' => '0', 'iss' => 'ilrms');
        // test that the functions are working
        $token = $this->utilityclass->generateToken($claims, $time, $ttl, $algorithm, $secret);
        ///////END WT
        //$url = SRO_SERVICE."getsronote?val=" . $token;
        $url = SRO_SERVICE."getsronote?dist=$dis&sub=$sub&cir=$cir_code&status=$status";
        //echo $url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $output = json_decode($output);

        if ($output != null) {
            foreach ($output as $d) {
                if(isset($d->deed_no_actual)){
                     $deed_no_actual = $d->deed_no_actual;
                }
                else{
                    $deed_no_actual=null;
                }
               
                $data = array(
                    'dist_code' => $d->distCode,
                    'subdiv_code' => $d->subdivCode,
                    'cir_code' => $d->cirCode,
                    'mouza_pargona_code' => $d->mouzaPargonaCode,
                    'lot_no' => $d->lotNo,
                    'vill_townprt_code' => $d->villTownprtCode,
                    'dag_no' => $d->dagNo,
                    'deed_type' => $d->deedType,
                    'patta_type_code' => $d->pattaTypeCode,
                    'patta_no' => trim($d->pattaNo),
                    'dag_area_b' => $d->dagAreaB,
                    'dag_area_k' => $d->dagAreaK,
                    'dag_area_lc' => $d->dagAreaLc,
                    'dag_area_g' => $d->dagAreaG,
                    'dag_area_kr' => $d->dagAreaKr,
                    'reg_to_name' => $d->regToName,
                    'reg_from_name' => $d->regFromName,
                    'name_of_sro' => $d->nameOfSro,
                    'deed_no' => $d->deedNo,
                    'deed_value' => $d->deedValue,
                    'date_of_deed' => date('Y-m-d', strtotime($d->dateOfDeed)),
                    'user_code' => $this->session->userdata('user_code'),
                    'operation' => 'E',
                    'status' => 0,
                    'sro_code' => $d->sroCode,
                    'update_date' => date('Y-m-d G:i:s'),
                    'nocno' => $d->nocno,
                    'deed_no_actual' => $deed_no_actual
                );
                $deedNo = $d->deedNo;
                $count = $this->db->query("select count(deed_no) as c from  sro_note where
                deed_no='$deedNo' and dist_code='$d->distCode'
                and subdiv_code='$d->subdivCode' and cir_code='$d->cirCode' and sro_code='$d->sroCode' ")->row()->c;

                if ($count == 0) {
                    $data1 = $this->db->insert('sro_note', $data);

                    $claims = array('dist' => $d->distCode, 'sro' => $d->sroCode, 'deedno' => $d->deedNo, 'iss' => 'ilrms');
                    // test that the functions are working
                    $updatetoken = $this->utilityclass->generateToken($claims, $time, $ttl, $algorithm, $secret);
                    //$url = SRO_SERVICE."updatesronote?val=" . $updatetoken;
                    $url = SRO_SERVICE."updatesronote?dist=$dis&sro=$d->sroCode&deedno=$d->deedNo";
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $output = curl_exec($ch);
                    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);
                }
            }
        }
    }

    ///////// CO FINAL VIEW PAGE///////
    public function finalOrderPass()
    {
        $user_desig_code = $this->session->userdata('user_desig_code');
        if(!in_array($user_desig_code, ['CO'])){
            show_error('You are not authorized for this action.');
        }

        //$case_no = $this->input->get('case_no');

        $case_no = $_GET['case_no'] = dec_param($this->input->get('case_no'), 'case_no');
        if($_GET['case_no'] == null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;
        $append = "dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and date(date_entry) >='$define_date'";
        $appenq = "dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'";

        $petition_basic_data = $this->db->query("SELECT * FROM petition_basic pb WHERE 
            pb.case_no=? AND pb.dist_code=? AND 
            pb.subdiv_code=? AND pb.cir_code=? and 
            pb.order_passed is null and (pb.status=? or pb.status=?) and pb.comp_serv_yn=?",
            array($case_no, $dist_code, $subdiv_code, $cir_code, 'P', 'H','Y'));
        if ($petition_basic_data->num_rows() == 1) {
            $details['data'] = $petition_basic_data->row();
            $pb = $petition_basic_data->row();
        } else {
            $this->session->set_flashdata(array('message' => "Error: [##COMS0001]. Data not found
             for Case No : $case_no"));
            log_message("error", "##COMS0001. Data not found in 
            petition_basic for Case No :" . $case_no);
            redirect(base_url() . "index.php/home");
        }
        $details['hold_reason'] = null;
        if ($pb->status == 'H') {
            $sql8 = $this->db->query("select remark,entry_date from composite_service where 
                        case_no=? and status=? ORDER BY id desc", array($pb->case_no, 'H'));
            if ($sql8->num_rows() > 0) {
                $details['hold_reason'] = $sql8->row()->remark;
                $details['hold_date'] = $sql8->row()->entry_date;
            }
        }


        if(($pb->dist_code!=$dist_code) || ($pb->subdiv_code!=$subdiv_code) ||($pb->cir_code!=$cir_code))
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }

        /////get sro details//
        $details['deed'] = null;
        $details['deed_no'] = null;
        $details['deed_value'] = null;
        $details['deed_date'] = null;
        $sro_data = $this->db->query("SELECT * FROM sro_note WHERE 
            nocno=? AND dist_code=? AND 
            subdiv_code=? AND cir_code=? and mouza_pargona_code=? and lot_no=?
            and vill_townprt_code=?",
            array($pb->noc_no, $pb->dist_code, $pb->subdiv_code, $pb->cir_code,
                $pb->mouza_pargona_code, $pb->lot_no, $pb->vill_townprt_code));


        if ($sro_data->num_rows() > 0) {
            $details['deed'] = 'Y';
            $details['sro'] = $sro_data->result();
            // $details['sro_code'] = $sro->sro_code;
            // $details['deed_no'] = $sro->deed_no;
            // $details['deed_value'] = $sro->deed_value;
            // $details['deed_date'] = date('Y-m-d', strtotime($sro->date_of_deed));
        }

        $noc_data = $this->db->query("SELECT * FROM landsale WHERE 
            appno=? AND distcode=? AND 
            subcode=? AND circode=?",
            array($pb->noc_no, $pb->dist_code, $pb->subdiv_code, $pb->cir_code));

        if ($noc_data->num_rows() > 0) {
            $details['noc_data'] = $noc_data->row();
        }

        $doc1_id=$this->db->query("SELECT id,doc_flag,file_name FROM supportive_document WHERE doc_flag='1' and case_no=? order by id desc", array($case_no));
        if($doc1_id->num_rows() > 0)
        {
             $details['doc1_id']=$doc1_id->row();
        }

        $doc2_id=$this->db->query("SELECT id,doc_flag,file_name FROM supportive_document WHERE doc_flag='2' and case_no=? order by id desc", array($case_no));
        if($doc2_id->num_rows() > 0)
        {
             $details['doc2_id']=$doc2_id->row();
        }

        $petition_dag_details_data = $this->db->query("SELECT * FROM petition_dag_details pb WHERE 
            pb.case_no=? and pb.petition_no=? AND pb.dist_code=? AND 
            pb.subdiv_code=? AND pb.cir_code=?",
            array($case_no, $petition_basic_data->row()->petition_no, $dist_code, $subdiv_code, $cir_code));
        if ($petition_dag_details_data->num_rows() > 0) {
            $details['dags'] = $petition_dag_details_data->result();
            foreach ($details['dags'] as $key => $d) {
                $sql2 = "select dag_area_b, dag_area_k,round(dag_area_lc,2) as dag_area_lc,dag_area_g,dag_area_kr from chitha_basic
                    where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and 
                    lot_no=? and vill_townprt_code=? and dag_no=? and patta_no=? and patta_type_code=?";
                $res2 = $this->db->query($sql2, array($d->dist_code, $d->subdiv_code, $d->cir_code,
                    $d->mouza_pargona_code, $d->lot_no, $d->vill_townprt_code, $d->dag_no, $d->patta_no,
                    $d->patta_type_code));

                $details['chitha_basic_data'] = $res2->num_rows();



                if ($res2->num_rows() == 1) {
                    $details['dags'][$key]->c_bigha = $res2->row()->dag_area_b;
                    $details['dags'][$key]->c_katha = $res2->row()->dag_area_k;
                    $details['dags'][$key]->c_lessa = $res2->row()->dag_area_lc;
                    $details['dags'][$key]->c_ganda = $res2->row()->dag_area_g;
                    $details['dags'][$key]->c_kranti = $res2->row()->dag_area_kr;
                } 

                
                // else {
                //     $this->session->set_flashdata(array('message' => "Error: [##COMS0003]. Data not found
                //      for Case No : $case_no"));
                //     log_message("error", "##COMS0003. Data not found in
                //     chitha_basic for Case No :" . $case_no);
                //     redirect(base_url() . "index.php/home");
                // }
            }

        } else {
            $this->session->set_flashdata(array('message' => "Error: [##COMS0002]. Data not found
             for Case No : $case_no"));
            log_message("error", "##COMS0002. Data not found in 
            petition_dag_details for Case No :" . $case_no);
            redirect(base_url() . "index.php/home");
        }

        $dates = $this->db->query("SELECT lm_code, lm_sign_yn, sk_sign_yn,sk_note_date,
            lm_sign_date FROM 
            petition_lm_note WHERE $appenq AND 
            petition_no = ? and mouza_pargona_code = ? and lot_no = ? ", array($pb->petition_no,$pb->mouza_pargona_code,$pb->lot_no))->row();

        $details['sk_note_date'] = $dates->sk_note_date;
        $details['lm_note_date'] = $dates->lm_sign_date;
        $details['lm_sign_yn'] = $dates->lm_sign_yn;
        $details['sk_sign_yn'] = $dates->sk_sign_yn;
        $details['lm_code'] = $dates->lm_code;
        $details['user_code'] = 'NA';
        $details['case_no'] = $case_no;


        //////////////////////////////////////////////////////////////////////////////
        $petition_no_q = "SELECT petition_no, trans_code, deed_no, deed_value, sub_reg_office,
          submission_date, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no,
          vill_townprt_code FROM petition_basic WHERE case_no=? and $append ";
        $petition_no = $this->db->query($petition_no_q, array($case_no))->row()->petition_no;
        $trans_code = $this->db->query($petition_no_q, array($case_no))->row()->trans_code;
        $sub_reg_office = $this->db->query($petition_no_q, array($case_no))->row()->sub_reg_office;
        $submission_date = $this->db->query($petition_no_q, array($case_no))->row()->submission_date;

        $details['trans_code'] = $trans_code;
        $details['sub_reg_office'] = $sub_reg_office;
        $details['submission_date'] = $submission_date;

        $applicants = "SELECT * FROM petitioner WHERE petition_no=? AND case_no=? AND $append order by pet_id";
        $details['applicants'] = $details['petitioner'] = $this->db->query($applicants, array($petition_no,$case_no))->result();

        $details['relation'] = $this->db->query("SELECT * FROM master_guard_rel")->result();
        $details['genders'] = $this->db->query("SELECT * FROM master_gender")->result();

        $pattadars = "SELECT * FROM petition_pattadar WHERE petition_no=? AND case_no=? and $append";
        $details['pattadars'] = $this->db->query($pattadars, array($petition_no,$case_no))->result();

        $sql20 = "select * from landsale where appno=? and distcode=? and 
            subcode=? and circode=? and compserv=?";
        $details['noc_case'] = $this->db->query($sql20, array($pb->noc_no, $dist_code,
            $subdiv_code, $cir_code, 'Y'))->row();


        $mutation_no="select case_no from petition_basic where noc_no=? and status in('F') union select case_no from field_mut_basic where noc_no=? and (order_passed='Y' or order_passed='y') ";

        $details['mutation_no']=$this->db->query($mutation_no, array($pb->noc_no,$pb->noc_no))->result();



        ///////////////////////////////////////////////////////////////////// property chain code ////////////////////////////////////////////////////////////////////////////
        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {

            $details['propChainEnableFlag'] = $this->PropChainCommonModel->isLocationEnable($details['data']->dist_code, $details['data']->subdiv_code, $details['data']->cir_code, $details['data']->mouza_pargona_code, $details['data']->lot_no, $details['data']->vill_townprt_code);


            $details['dags'] = $petition_dag_details_data->result();
            foreach ($details['dags'] as $key => $d)
            {
                $land_area = $this->PropChainModel->getLandArea($d->dist_code, $d->subdiv_code, $d->cir_code, $d->mouza_pargona_code, $d->lot_no, $d->vill_townprt_code, $d->patta_no, $d->dag_no);

                $chainChithaCheck[] = $this->PropChainModel->chainChithaUlpinCheckProcess($d->dist_code, $d->subdiv_code, $d->cir_code, $d->mouza_pargona_code, $d->lot_no, $d->vill_townprt_code, $d->patta_no, $d->dag_no, $land_area->dag_area_b, $land_area->dag_area_k, $land_area->dag_area_lc, $land_area->dag_area_g, $details['pattadars'][0]->patta_type_code);
                $chainChithaCheck[$key]['dist_code'] = $d->dist_code;
                $chainChithaCheck[$key]['subdiv_code'] = $d->subdiv_code;
                $chainChithaCheck[$key]['cir_code'] = $d->cir_code;
                $chainChithaCheck[$key]['mouza_pargona_code'] = $d->mouza_pargona_code;
                $chainChithaCheck[$key]['lot_no'] = $d->lot_no;
                $chainChithaCheck[$key]['vill_townprt_code'] = $d->vill_townprt_code;
                $chainChithaCheck[$key]['case_no'] = $d->case_no;
                $chainChithaCheck[$key]['dag_no'] = $d->dag_no;
                $chainChithaCheck[$key]['patta_no'] = $d->patta_no;
                $chainChithaCheck[$key]['dag_area_b'] = $land_area->dag_area_b;
                $chainChithaCheck[$key]['dag_area_k'] = $land_area->dag_area_k;
                $chainChithaCheck[$key]['dag_area_lc'] = $land_area->dag_area_lc;
                $chainChithaCheck[$key]['dag_area_g'] = $land_area->dag_area_g;
                $chainChithaCheck[$key]['patta_type_code'] = $details['pattadars'][0]->patta_type_code;

            }



            // echo "<pre>";
            // var_dump($chainChithaCheck);
            // die;

             // if($alreadyGISCodeExist  == null)
                    // {
                    //     $gisCode = $this->blockchainutilityclass->generateGisCode($dag->dist_code, $dag->subdiv_code, $dag->cir_code, $dag->mouza_pargona_code, $dag->lot_no, $dag->vill_townprt_code);
                    //     $alreadyGISCodeExist = $gisCode;
                    // }
            $ulpinValue = 1;
            $ulpinMsg = "Ulpin found for the property.";
            $chithaPropChainCmpFlag = 'Y';
            $compareFlagMsg = "Chitha and Property Chain Data Matching exists";
            $createPropChainBtnList = array();
            $bhuChithaCmpStatus =1; 
            $bhuChithaCmpMsg = 'Chitha area and bhunaksha area matching.';
            $mismatchBtnList = array();
            $bhun_cmp_msg = array();
            foreach ($chainChithaCheck as $key => $value) {
                if($value['ulpinCheck'] == 0)
                {
                    $ulpinValue = 0;
                    $ulpinMsg = $value['ulpinMsg'];
                }

                if($value['chithaPropChainCmpFlag'] == 'NE' || $value['chithaPropChainCmpFlag'] == 'N')
                {
                    $chithaPropChainCmpFlag = 'NE';
                    $compareFlagMsg = $value['compareFlagMsg'];

                    $createPropChainBtnList[] = $value['createPropChainBtn'];
                }

                if($value['bhuChithaCmpStatus'] == 0)
                {
                    $bhuChithaCmpStatus = 0;
                    $bhuChithaCmpMsg = $value['bhuChithaCmpMsg'];
                }

                if ($value['chithaPropChainCmpFlag'] == 'N' || $value['chithaPropChainCmpFlag'] == 'NE') {
                    $this->PropChainModel->updateCmpFlag($value['case_no'], $value['chithaPropChainCmpFlag']);
                    // get view mismatch case button
                    if ($value['chithaPropChainCmpFlag'] == 'N') 
                    {
                        $mismatchBtnList[] = $this->PropChainModel->getMismatchBtn($value['case_no'], $value['dist_code'], $value['subdiv_code'], $value['cir_code'], $value['mouza_pargona_code'], $value['lot_no'], $value['vill_townprt_code'], $value['patta_no'], $value['dag_no'], $value['dag_area_b'], $value['dag_area_k'], $value['dag_area_lc'], $value['dag_area_g'], $value['patta_type_code']);
                    }
                }
                // var_dump($value['bhun_cmp_msg']);
                $bhun_cmp_msg[] = $value['bhun_cmp_msg'];
                $bhuChithaCmpStatus = $value['bhuChithaCmpStatus']; 
                // var_dump($bhuChithaCmpStatus);
                // die;
                // die;
                /////////////// edit for bhunaksha and chitha area comparision///////////////////
                // $get_bhu_cmp_status = explode('_', $value['bhu_chitha_area_cmp_status']);
                // var_dump($get_bhu_cmp_status);

                // $data['bhuChithaCmpStatus'] = $get_bhu_cmp_status[0];
                // if ($get_bhu_cmp_status[0] == 0)
                //     $bhun_cmp_msg =  $data['bhuChithaCmpMsg'] = $get_bhu_cmp_status[1] . ". Bhunaksha area: " . $get_bhu_cmp_status[2] . ", Chitha area: " . $get_bhu_cmp_status[3];
                // else
                //     $bhun_cmp_msg = $data['bhuChithaCmpMsg'] = $get_bhu_cmp_status[1] . ". Bhunaksha area: " . $get_bhu_cmp_status[2] . ", Chitha area: " . $get_bhu_cmp_status[3];
                // var_dump($data['bhuChithaCmpMsg']);
                // die;
                /////////////////////////////////////////////////////////////////////////////////


            }
            $bhun_cmp_msg = implode(',',$bhun_cmp_msg);
            



            $details['ulpinCheck'] = $ulpinValue;
            $details['ulpinMsg'] = $ulpinMsg;
            $details['revenue'] = '0.00';
            $details['local_tax'] = '0.00';
            $details['old_ulpin'] = '';
            $details['ulpin'] ='';

            // if ($details['ulpinCheck'] == 1) {
            //     $details['ulpin'] = $chainChithaCheck['ulpin'];
            //     if (isset($chainChithaCheck['old_ulpin']))
            //         $details['old_ulpin'] = $chainChithaCheck['old_ulpin'];
            //     else
            //         $details['old_ulpin'] = "";
            // }

            $details['chithaPropChainCmpFlag'] = $chithaPropChainCmpFlag;
            $details['compareFlagMsg'] = $compareFlagMsg;


            $details['createPropChainBtn'] = $createPropChainBtnList;
            $details['mismatchBtn'] = $mismatchBtnList;

            // hidden fields
            // $details['ulpin_hidden'] = $chainChithaCheck['ulpin_hidden'];
            // $details['uplpin_msg_hidden'] = $chainChithaCheck['uplpin_msg_hidden'];
            // $details['compare_hidden'] = $chainChithaCheck['compare_hidden'];
            // $details['compare_msg_hidden'] = $chainChithaCheck['compare_msg_hidden'];
            // $details['encoded_case_no'] = urlencode(base64_encode($case_no));
            // $details['bhuCompareFlag'] = $chainChithaCheck['bhu_hidden'];
            // $details['bhuCompareMsg'] = $chainChithaCheck['bhu_compare_msg_hidden'];

            $details['ulpin_hidden'] = "<input type='hidden' name='ulpinFlag' id='ulpinFlag' value='$ulpinValue'>";
            $details['uplpin_msg_hidden'] = "<input type='hidden' name='ulpinMsg' id='ulpinMsg' value='$ulpinMsg'>";
            $details['compare_hidden'] = "<input type='hidden' name='compareFlag' id='compareFlag' value='$chithaPropChainCmpFlag'>";
            $details['compare_msg_hidden'] = "<input type='hidden' name='compareMsg' id='compareMsg' value='$compareFlagMsg'>";
            $details['encoded_case_no'] =urlencode(base64_encode($case_no));


             // bhunaksha area cmp
             $details['bhuChithaCmpStatus'] = $bhuChithaCmpStatus;
             $details['bhuChithaCmpMsg'] = $bhuChithaCmpMsg;
             $details['bhu_hidden'] = "<input type='hidden' name='bhuCompareFlag' id='bhuCompareFlag' value='$bhuChithaCmpStatus'>";
             $details['bhu_compare_msg_hidden'] = "<input type='hidden' name='bhuCompareMsg' id='bhuCompareMsg' value='$bhun_cmp_msg'>";


        }

        $details['_view'] = 'CompositeService/finalOrderPassCO';
        $this->load->view('layouts/main', $details);

    }

    /////process handler//
    public function processHandler($arr)
    {
        return $this->db->insert('composite_service', $arr);
    }

    ////CO PASS FINAL SUBMIT//////
    public function finalOrderOfcMutationPassCO()
    {
        // XSS Validation START
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST, [], [], ['co_order' => true]);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }
        
        $resp = checkRequestValidQuery($_POST, [], ['co_order' => true]);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }
        
        if($errorMessageStr != ''){
            // $this->session->set_flashdata('message', $errorMessageStr);
            // return redirect($_SERVER['HTTP_REFERER']);
            $data = [
                'success' => false,
                'errors' => $errorMessageStr
            ];

            return $this->output
                    ->set_status_header('403')
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data)); 
        }

        // XSS Validation END
        $user_desig_code = $this->session->userdata('user_desig_code');
        if(!in_array($user_desig_code, ['CO'])){
            // $this->session->set_flashdata('message', 'You are not authorized to perform this action.');
            // redirect($_SERVER['HTTP_REFERER']);
            $data = [
                'success' => false,
                'errors' => 'You are not authorized to perform this action.'
            ];

            return $this->output
                    ->set_status_header('403')
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));
        }

        // $case_no = $this->input->post('case_no');
        $case_no = dec_param($this->input->post('case_no'), 'case_no');
        $dist_code = $this->input->post('dist_code');
        $this->AgriStackCaseHistory->CreateLogFile($dist_code, $case_no);
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');
        $date = date('Y-m-d');
        

        $input_order = $this->input->post('order');

        $lm_code = $this->input->post('lm_code');
       
        if($lm_code==null)
        {
             $lm_code_new = $this->input->post('lm_code_assign');
             if($lm_code_new == null)
             {
                //$this->db->trans_rollback();
                $array = array(
                    'error' => true,
                    'msg' => "Kindly Select LRA name.",
                );
                echo json_encode($array);
                return;
             }

             $update_pet_lm = "update petition_lm_note set lm_code=? where case_no=? and
                dist_code =? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and
                lot_no=? and vill_townprt_code=?";
                $this->db->query($update_pet_lm, array($lm_code_new, $case_no, $dist_code, $subdiv_code, $cir_code,
                    $mouza_pargona_code, $lot_no, $vill_townprt_code));
                if ($this->db->affected_rows() != 1) {
                    //$this->db->trans_rollback();
                    log_message("error", " #OMCS036 Unable to update in petition_lm_note
                            district: " . $dist_code . ", case no: " . $case_no);
                    $array = array(
                        'error' => true,
                        'redirect_url' => 0,
                        'msg' => "#OMCS090 Unable to update data.",
                    );
                    echo json_encode($array);
                    return;
                }


        }

        $this->db->trans_begin();

        if ($input_order == 'H') {
            $holding_reason = $this->input->post('holding_reason');

            if ($holding_reason == null || $holding_reason == '') {
                $this->db->trans_rollback();
                $array = array(
                    'error' => true,
                    'msg' => "Reason of stop auto mutation field is required.",
                );
                echo json_encode($array);
                return;
            }
            $comp_array = [
                'case_no' => $case_no,
                'user_code' => $this->user_code,
                'status' => $input_order,
                'remark' => $holding_reason,
                'entry_date' => date('Y-m-d'),
            ];
            $data = $this->processHandler($comp_array);
            if ($data != 1) {
                $this->db->trans_rollback();
                log_message("error", " #COMPTABLE001 Unable to insert into composite_service 
                        case no: " . $case_no);
                $array = array(
                    'error' => true,
                    'redirect_url' => 0,
                    'msg' => "#COMPTABLE001 Unable to update data.",
                );
                echo json_encode($array);
                return;
            } else {
                $update_pet = "update petition_basic set status=? where case_no=? and
                dist_code =? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and
                lot_no=? and vill_townprt_code=? and status!=? and comp_serv_yn=?";
                $this->db->query($update_pet, array('H', $case_no, $dist_code, $subdiv_code, $cir_code,
                    $mouza_pargona_code, $lot_no, $vill_townprt_code, 'F', 'Y'));
                if ($this->db->affected_rows() != 1) {
                    $this->db->trans_rollback();
                    log_message("error", " #OMCS036 Unable to update in petition_basic
                            district: " . $dist_code . ", case no: " . $case_no);
                    $array = array(
                        'error' => true,
                        'redirect_url' => 0,
                        'msg' => "#OMCS036 Unable to update data.",
                    );
                    echo json_encode($array);
                    return;
                }
                $this->db->trans_commit();
                $this->session->set_flashdata(array('message' => "Order Stoped for Mutation Case # $case_no "));

                $array = array(
                    'error' => false,
                    'msg' => "Order Stoped for Mutation Case # $case_no ",
                );
                echo json_encode($array);
                return;
            }
        } else if ($input_order != 'P' && $input_order != 'H') {
            $this->db->trans_rollback();
            $array = array(
                'error' => true,
                'redirect_url' => 0,
                'msg' => "Reason of stop automutation field is required.",
            );
            echo json_encode($array);
            return;
        }
        $year_no = year_no;
        $value = $this->input->post();

        //get detail from petition_basic
        $pet_basic_data = $this->db->query("SELECT * FROM petition_basic WHERE case_no=? and 
            dist_code =? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and 
            lot_no=? and vill_townprt_code=? and (status=? or status=?) and comp_serv_yn=?",
            array($case_no, $dist_code, $subdiv_code, $cir_code,
                $mouza_pargona_code, $lot_no, $vill_townprt_code, 'P', 'H', 'Y'));

        // echo $this->db->last_query();exit;
        if ($pet_basic_data->num_rows() > 0) {
            $pet_basic = $pet_basic_data->row();
            $petition_no = $pet_basic->petition_no;
        } else {
            $this->db->trans_rollback();
            log_message("error", " #OMCS001 could not find petition_basic 
                        district: " . $dist_code . ", case no: " . $case_no);
            $array = array(
                'error' => true,
                'redirect_url' => 0,
                'msg' => "#OMCS001 could not find case details.",
            );
            $this->db->trans_rollback();
            echo json_encode($array);
            return;
        }

        /////get sro details//
        $deed_no = null;
        $deed_value = null;
        $deed_date = null;
        $sro_data = $this->db->query("SELECT * FROM sro_note WHERE 
            nocno=? AND dist_code=? AND 
            subdiv_code=? AND cir_code=? and mouza_pargona_code=? and lot_no=?
            and vill_townprt_code=?",
            array($pet_basic->noc_no, $dist_code, $subdiv_code, $cir_code,
                $mouza_pargona_code, $lot_no, $vill_townprt_code));

        if ($sro_data->num_rows() > 0) {
            $sro = $sro_data->row();
            $deed_no = $sro->deed_no;
            $deed_value = $sro->deed_value;
            $deed_date = date('Y-m-d', strtotime($sro->date_of_deed));
        }else{
            $this->db->trans_rollback();
            log_message("error", " #OMCSSRO001 could not find SRO 
                        district: " . $dist_code . ", case no: " . $case_no);
            $array = array(
                'error' => true,
                'redirect_url' => 0,
                'msg' => "#OMCSSRO001 Deed No Not found.",
            );
            echo json_encode($array);
            return;
        }

        $proceeding_id = $this->db->query("SELECT max(proceeding_id)+1 AS pid FROM
         petition_proceeding WHERE case_no=? AND dist_code=? 
         and subdiv_code=? and cir_code=?",
            array($case_no, $dist_code, $subdiv_code, $cir_code))->row()->pid;
        if ($proceeding_id == null) {
            $proceeding_id = 1;
        }

        $data = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => date('Y-m-d h:i:s'),
            'co_order' => addslashes($this->input->post('co_order')),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'status' => 'final',
            'user_code' => $this->user_code,
            'dist_code' => $dist_code,
            'cir_code' => $cir_code,
            'subdiv_code' => $subdiv_code,
            'operation' => 'E',
            'date_entry' => date('Y-m-d G:i:s'),
            'ip' => $this->utilityclass->get_client_ip(),
        ];
        $pet_proceed = $this->db->insert('petition_proceeding', $data);
        if ($pet_proceed != 1) {
            $this->db->trans_rollback();
            log_message("error", " #OMCS002 could not insert petition_proceeding  
                        district: " . $dist_code . ", petition_no: " . $petition_no);
            $array = array(
                'error' => true,
                'redirect_url' => 0,
                'msg' => "#OMCS002 Unable to insert data.",
            );
            $this->db->trans_rollback();
            echo json_encode($array);
            return;
        }

        $locationData = [
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'year_no' => date('Y'),
            'petition_no' => $petition_no,
        ];

        //get detail from petitioner & petition_dag_details
        $sql2 = "select distinct on (petition_no,dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,dag_no,patta_no) *  from petition_dag_details WHERE 
            petition_no=? AND dist_code=? and subdiv_code=? and 
            cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=?";
        $res2 = $this->db->query($sql2,
            array($petition_no, $dist_code, $subdiv_code,
                $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code));
        if ($res2->num_rows() <= 0) {
            log_message("error", " #OMCS003 could not find petition_dag_details 
                        district: " . $dist_code . ", case no: " . $case_no);
            $array = array(
                'error' => true,
                'redirect_url' => 0,
                'msg' => "#OMCS003 could not find dag details.",
            );
            $this->db->trans_rollback();
            echo json_encode($array);
            return;
        }
        $dags = $res2->result();

        // var_dump($dags);exit;


        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {

            $this->load->model('propChain/PropChainCommonModel');
            if(sizeof($dags)>1)

            {

                foreach($dags as $dag)
                {
                   
                    $block_status=$this->PropChainCommonModel->checkDagExistsInPropChain($dag->dist_code,$dag->subdiv_code,
                    $dag->cir_code,$dag->mouza_pargona_code,$dag->lot_no,$dag->vill_townprt_code,$dag->dag_no);

                    if($block_status==false)
                    {

                        log_message("error", " #OMCPCS001 Final order cannot be passed for some of the given Dag is not in Property chain!!: " . $dag->dist_code . ", case no: " . $case_no);
                        $array = array(
                            'error' => true,
                            'redirect_url' => 0,
                            'msg' => "#OMCPCS001 Final order cannot be passed for some of the given Dag is not in Property chain!!",
                        );
                        $this->db->trans_rollback();
                        echo json_encode($array);
                        return;
                    }

                }

            }
        }

        // var_dump($block_status);exit;


        $sql1 = "select * from petitioner WHERE 
            petition_no=? AND dist_code=? and subdiv_code=? and 
            cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and case_no =?";
        $res1 = $this->db->query($sql1,
            array($petition_no, $dist_code, $subdiv_code,
                $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $case_no));
        if ($res1->num_rows() <= 0) {
            log_message("error", " #OMCS004 could not find petitioner 
                        district: " . $dist_code . ", case no: " . $case_no);
            $array = array(
                'error' => true,
                'redirect_url' => 0,
                'msg' => "#OMCS004 could not find petitioner details.",
            );
            $this->db->trans_rollback();
            echo json_encode($array);
            return;
        }
        $petitioner = $res1->result();
        //insertion in t_chitha_rmk_infavor_of
        foreach ($dags as $dag) {
            foreach ($petitioner as $data) {
                $t_chitha_rmk_infavor_of = null;
                if ($dag->revenue == null) {
                    $revenue = 0;
                } else {
                    $revenue = $dag->revenue;
                }

                if(isset($data->auth_type) && $data->auth_type != null){
                    $auth_type = $data->auth_type;
                    $id_ref_no = $data->id_ref_no;
                }else{
                    $auth_type = null;
                    $id_ref_no = null;
                }


                $t_chitha_rmk_infavor_of = [
                    'dag_no' => $dag->dag_no,
                    'patta_type_code' => $dag->patta_type_code,
                    'patta_no' => $dag->patta_no,
                    'ord_no' => $case_no,
                    'ord_date' => date('Y-m-d G:i:s'),
                    'infavor_of_id' => $data->pet_id,
                    'infavor_of_name' => $data->pet_name,
                    'infavor_of_guardian' => $data->guard_name,
                    'infav_of_guar_relation' => $data->guard_rel,
                    'infavor_of_add1' => $data->add1,
                    'infavor_of_add2' => $data->add2,
                    'by_right_of' => $pet_basic->trans_code,
                    'land_area_b' => '0',
                    'land_area_k' => '0',
                    'land_area_lc' => '0',
                    'land_area_g' => '0',
                    'land_area_kr' => '0',
                    'revenue' => $revenue,
                    'reg_deal_no' => $deed_no,
                    'reg_date' => date('Y-m-d', strtotime($deed_date)),
                    'infavor_of_gender' => $data->pet_gender,
                    'infavor_of_minor_yn' => $data->pet_minor_yn,
                    'infavor_of_minor_dob' => $data->pet_minor_dob,
                    'infavor_of_mother' => $data->pet_mother,
                    'new_pattadar' => $data->new_pattadar,
                    'pdar_name_eng' => $data->pdar_name_eng,
                    'pdar_guard_eng' => $data->pdar_guard_eng,
                    'auth_type'        => $auth_type,
                    'id_ref_no'        => $id_ref_no,
                ];
                $tchitha_infavorof = array_merge($t_chitha_rmk_infavor_of, $locationData);

                $ins_tchitha_infavour = $this->db->insert("t_chitha_rmk_infavor_of", $tchitha_infavorof);
                if ($ins_tchitha_infavour != 1) {
                    $this->db->trans_rollback();
                    log_message("error", " #OMCS005 could not insert t_chitha_rmk_infavour_of 
                    district: " . $dist_code . ", petition_no: " . $petition_no);
                    $array = array(
                        'error' => true,
                        'redirect_url' => 0,
                        'msg' => "#OMCS005 Unable to insert data.",
                    );
                    echo json_encode($array);
                    return;
                }
            }
        }

        //get detail from petition_pattadar
        $query3 = "SELECT distinct on (petition_no,dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,patta_no, dag_no,pdar_id) * FROM petition_pattadar WHERE 
            petition_no=? AND dist_code=? and subdiv_code=? and 
            cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? ";
        $pet_pattadar = $this->db->query($query3,
            array($petition_no, $dist_code, $subdiv_code,
                $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code));
        if ($pet_pattadar->num_rows() <= 0) {
            $this->db->trans_rollback();
            log_message("error", " #OMCS006 could not find petition_pattadar  
                  district: " . $dist_code . ", petition_no: " . $petition_no);
            $array = array(
                'error' => true,
                'redirect_url' => 0,
                'msg' => "#OMCS006 could not find pattadar details.",
            );
            echo json_encode($array);
            return;
        }
        $pet_pattadar = $pet_pattadar->result();

        //insertion in inplace & alongwith
        foreach ($pet_pattadar as $inall) {
            $inplace_alongwith = $inall->striked_out;
            $table = (($inplace_alongwith == 1) ? 't_chitha_rmk_inplace_of' : 't_chitha_rmk_alongwith');

            if ($inplace_alongwith == 1) //insertion in inplace chitha
            {
                $insertInplaceAlong = [
                    'ord_no' => $case_no,
                    'dag_no' => $inall->dag_no,
                    'ord_date' => $date,
                    'inplace_of_id' => $inall->pdar_id,
                    'pdar_id' => $inall->pdar_id,
                    'inplace_of_name' => $inall->pdar_name,
                    'inplace_of_guardian' => $inall->pdar_guardian,
                    'inplace_of_relation' => $inall->pdar_rel_guar,
                    'strike_out' => '1'
                ];
            } else if ($inplace_alongwith == 0 || $inplace_alongwith == '') //insertion in alongwith chitha
            {
                $insertInplaceAlong = [
                    'ord_no' => $case_no,
                    'dag_no' => $inall->dag_no,
                    'ord_date' => $date,
                    'alongwith_id' => $inall->pdar_id,
                    'alongwith_name' => $inall->pdar_name,
                    'alongwith_guardian' => $inall->pdar_guardian,
                    'alongwith_rel_gur' => $inall->pdar_rel_guar,
                    'pdar_id' => $inall->pdar_id
                ];
            }
            $tchitha_inplaceof_tmp = array_merge($insertInplaceAlong, $locationData);
            $ins_inplace = $this->db->insert($table, $tchitha_inplaceof_tmp);

            if ($ins_inplace != 1) {
                $this->db->trans_rollback();
                log_message("error", " #OMCS007 could not insert " . $table
                    . "district: " . $dist_code . ", petition_no: " . $petition_no);
                $array = array(
                    'error' => true,
                    'redirect_url' => 0,
                    'msg' => "#OMCS007 Unable to insert data.",
                );
                echo json_encode($array);
                return;
            }

        } //end of foreach //insertion in inplace & alongwith

        foreach ($dags as $dag) {
            //calculation for remaining land starts here
            $total_mutation_b = 0;
            $total_mutation_k = 0;
            $total_mutation_lc = 0;
            $total_mutation_g = 0;
            $total_mutation_kr = 0;

            $c_dag_area_b = 0;
            $c_dag_area_k = 0;
            $c_dag_area_lc = 0;

            $total_mutation_b = $dag->m_dag_area_b;
            $total_mutation_k = $dag->m_dag_area_k;
            $total_mutation_lc = $dag->m_dag_area_lc;
            $total_mutation_g = $dag->m_dag_area_g==null?0:$dag->m_dag_area_g;

            $sql4 = "select dag_area_b,dag_area_k,round(dag_area_lc,2) as dag_area_lc,dag_area_g,dag_area_kr from chitha_basic where 
            dist_code=? and subdiv_code=? and 
            cir_code=? and mouza_pargona_code=? and lot_no=?
             and vill_townprt_code=? and dag_no=? and patta_no=? and patta_type_code=?";
            $res4 = $this->db->query($sql4, array($dist_code, $subdiv_code,
                $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code,
                $dag->dag_no, $dag->patta_no, $dag->patta_type_code));
            if ($res4->num_rows() <= 0) {
                $this->db->trans_rollback();
                log_message("error", " #OMCS008 could not find dag in chitha_basic  
                  district: " . $dist_code . ", petition_no: " . $petition_no);
                $array = array(
                    'error' => true,
                    'redirect_url' => 0,
                    'msg' => "#OMCS008 could not find Chitha details.",
                );
                echo json_encode($array);
                return;
            }
            $res4Row=$res4->row();
            $c_dag_area_b = $res4Row->dag_area_b;
            $c_dag_area_k = $res4Row->dag_area_k;
            $c_dag_area_lc = $res4Row->dag_area_lc;
            $c_dag_area_g = $res4Row->dag_area_g==null?0:$res4Row->dag_area_g;
            $c_dag_area_kr = $res4Row->dag_area_kr==null?0:$res4Row->dag_area_kr;


            if(in_array($dist_code, json_decode(BARAK_VALLEY))){

            $mutated = $total_mutation_b * 6400 + $total_mutation_k * 320 + $total_mutation_lc *20 + $total_mutation_g;
            $chitha = $c_dag_area_b * 6400 + $c_dag_area_k * 320 + $c_dag_area_lc *20 + $c_dag_area_g;
            $rem = $chitha - $mutated;
            }

            else{
            $mutated = $total_mutation_b * 100 + $total_mutation_k * 20 + $total_mutation_lc;
            $chitha = $c_dag_area_b * 100 + $c_dag_area_k * 20 + $c_dag_area_lc;
            $rem = $chitha - $mutated;
            }

            if ($mutated > $chitha) {
                $this->db->trans_rollback();
                log_message("error", " #OMCS031 mutated area can not be more than chitha  
                  district: " . $dist_code . ", petition_no: " . $petition_no);
                $array = array(
                    'error' => true,
                    'redirect_url' => 0,
                    'msg' => "#OMCS031 Mutated area can not be more than chitha area.",
                );
                echo json_encode($array);
                return;
            }

            if(in_array($dist_code, json_decode(BARAK_VALLEY)))
            {
            $bigha_r = floor($rem / 6400.0);
            $katha_r = floor(($rem - $bigha_r * 6400.0) / 320.0);
            $lessa_r = floor(($rem - $bigha_r * 6400 - $katha_r * 320)/20);
            $ganda_r = $rem - $bigha_r * 6400.0 - $katha_r * 320.0 - $lessa_r * 20.0;

            }

            else{

            $bigha_r = floor($rem / 100.0);
            $katha_r = floor(($rem - $bigha_r * 100.0) / 20.0);
            $lessa_r = $rem - $bigha_r * 100.0 - $katha_r * 20.0;
            $ganda_r= 0;
            }
            //calculation for remaining land ends here

            //insertion in t_chitha_rmk_ordbasic
            $order_basic = [
                'ord_no' => $case_no,
                'dag_no' => $dag->dag_no,
                'ord_date' => date('Y-m-d H:i:s'),
                'ord_type_code' => '03',
                'case_no' => $case_no,
                'ord_passby_sign_yn' => 'Y',
                'ord_passby_desig' => 'CO',
                'lm_code' => $value['lm_code'],
                'lm_sign_yn' => 'Y',
                'lm_sign_date' => date('Y-m-d'),
                'sk_code' => $value['sk_code'],
                'sk_sign_yn' => 'Y',
                'sk_sign_date' => date('Y-m-d'),
                'co_code' => $value['co_code'],
                'co_sign_yn' => 'Y',
                'co_ord_date' => date('Y-m-d'),
                'm_dag_area_b' => $total_mutation_b,
                'm_dag_area_k' => $total_mutation_k,
                'm_dag_area_lc' => $total_mutation_lc,
                'm_dag_area_g' => $total_mutation_g,
                'm_dag_area_kr' => $total_mutation_kr,
                'area_left_b' => $bigha_r,
                'area_left_k' => $katha_r,
                'area_left_lc' => $lessa_r,
                'area_left_g' => $ganda_r,//$c_dag_area_g - $total_mutation_g,
                'area_left_kr' => 0,//$c_dag_area_kr - $total_mutation_kr,
                'min_revenue' => 0.0,
                'noc_no' => $pet_basic->noc_no,
                'noc_date' => $pet_basic->noc_date,
            ];

            $chithaBasic = array_merge($order_basic, $locationData);
            $ins_basic = $this->db->insert("t_chitha_rmk_ordbasic", $chithaBasic);

            if ($ins_basic != 1) {
                $this->db->trans_rollback();
                log_message("error", " #OMCS009 could not insert t_chitha_rmk_ordbasic 
                        district: " . $dist_code . ", petition_no: " . $petition_no);
                $array = array(
                    'error' => true,
                    'redirect_url' => 0,
                    'msg' => "#OMCS009 Unable in insert data.",
                );
                echo json_encode($array);
                return;
            }
        }

        $autoUpdate = null;
        $autoUpdate = $this->autoUpdateOfc($dist_code, $subdiv_code, $cir_code,
            $lot_no, $vill_townprt_code,
            $mouza_pargona_code, $petition_no, $case_no);
        if ($autoUpdate['error'] != false || $autoUpdate == null) {
            $this->db->trans_rollback();
            $array = array(
                'error' => true,
                'redirect_url' => 0,
                'msg' => $autoUpdate['msg'],
            );
            echo json_encode($array);
            return;
        }

        $update = "UPDATE petition_basic SET order_passed=?,date_of_order=?,
        co_chitha_corrected_yn=?, co_chitha_corrected_date=?, status =?, deed_no=?, 
        deed_value=?, deed_date=? WHERE
        case_no=? and dist_code =? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and 
            lot_no=? and vill_townprt_code=? and status = ?";
        $this->db->query($update,
            array('Y', date('Y-m-d G:i:s'), 'Y', date('Y-m-d G:i:s'), 'F', $deed_no, $deed_value,
                $deed_date, $case_no, $dist_code, $subdiv_code, $cir_code,
                $mouza_pargona_code, $lot_no, $vill_townprt_code,'P'));
        if ($this->db->affected_rows() != 1) {
            $this->db->trans_rollback();
            log_message("error", " #OMCS025 could not update into petition_basic
                       district: " . $dist_code . ", petition_no: " . $petition_no);
            $array = array(
                'error' => true,
                'redirect_url' => 0,
                'msg' => "#OMCS025 Unable to update data. (OMUT)",
            );
            echo json_encode($array);
            return;
        }

        //////////////update noc table (landsale)////////
        $land_sale_update = "UPDATE landsale SET mutcomp=?,mutcompdt=? WHERE
        appno=? and distcode =? and subcode=? and circode=? and compserv=?";
        $this->db->query($land_sale_update,
            array('Y',date('Y-m-d'),$pet_basic->noc_no,$dist_code,$subdiv_code,$cir_code,'Y'));
        if($this->db->affected_rows() != 1)
        {
            $this->db->trans_rollback();
            log_message("error"," #OMCS032 could not update in landsale
                       district: ".$dist_code.", noc no: ". $pet_basic->noc_no);
            $array = array(
                'error' => true,
                'redirect_url' => 0,
                'msg' => "#OMCS032 Unable to update data.",
            );
            echo json_encode($array);
            return;
        }

        if ($deed_no != 0 or $deed_no != null) {
            $update_sro = "update sro_note set status='3' where 
                deed_no='$deed_no' and dist_code='$dist_code' and 
                subdiv_code='$subdiv_code' and cir_code='$cir_code' and 
                mouza_pargona_code='$mouza_pargona_code' and 
                lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' ";
            $this->db->query($update_sro);
            if ($this->db->affected_rows() <= 0) {
                $this->db->trans_rollback();
                log_message("error", " #OMCS023 Unable to update into sro_note
                       district: " . $dist_code . ", petition_no: " . $petition_no);
                $array = array(
                    'error' => true,
                    'redirect_url' => 0,
                    'msg' => "#OMCS023 Unable to update data.",
                );
                echo json_encode($array);
                return;
            }
        }

        $sql6 = "select DISTINCT ON (patta_no, patta_type_code) patta_no, patta_type_code from petition_dag_details where
            petition_no=? and dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=?
            and lot_no=? and vill_townprt_code=? and case_no =?";
        $res6 = $this->db->query($sql6, array($petition_no, $dist_code,
            $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $case_no))->result();

        $jama = null;
        foreach ($res6 as $patta) {
            $this->load->model('jamabandi/jamabandiAutoUpdateModel');
            $jamaUpdate = $this->jamabandiAutoUpdateModel->updateJamabandi($patta->patta_no, 
                    $patta->patta_type_code, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, 
                    $lot_no, $vill_townprt_code, $case_no);
            if($jamaUpdate != 1){
               $this->db->trans_rollback();
                log_message("error", " #OMCS022 Unable to update Jamabandi
                       district: " . $dist_code . ", petition_no: " . $petition_no);
                $array = array(
                    'error' => true,
                    'msg' => "#OMCS022 Unable to update Jamabandi.",
                );
                echo json_encode($array);
                return;   
            }
            //autoupdate jamabandi ends here    


            // $jama = $this->JamaBandiStep3($patta->patta_no, $patta->patta_type_code,
            //     $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code,
            //     $lot_no, $vill_townprt_code);
            // if ($jama['error'] != false || $jama == null) {
            //     $this->db->trans_rollback();
            //     log_message("error", " #OMCS022 Unable to update Jamabandi
            //            district: " . $dist_code . ", petition_no: " . $petition_no);
            //     $array = array(
            //         'error' => true,
            //         'msg' => "#OMCS022 Unable to update Jamabandi.",
            //     );
            //     echo json_encode($array);
            //     return;
            // }
        }

        $comp_array3 = [
            'case_no' => $case_no,
            'user_code' => $this->user_code,
            'status' => 'F',
            'remark' => 'Order Passed',
            'entry_date' => date('Y-m-d'),
        ];
        $data4 = $this->db->insert('composite_service', $comp_array3);
        if ($data4 != 1) {
            $this->db->trans_rollback();
            log_message("error", " #COMPTABLE003 Unable to insert into composite_service 
                        district: " . $dist_code . ", case no: " . $case_no);
            $array = array(
                'error' => true,
                'redirect_url' => 0,
                'msg' => "#COMPTABLE003 Unable to update data.",
            );
            echo json_encode($array);
            return;
        }

        //if ($autoUpdate['error'] == false && $jama['error'] == false) {
        if ($autoUpdate['error'] == false && $jamaUpdate ==1) {
            $partion_save = null;
            $this->DashboardDataFinal($case_no);

            $sql20 = "select * from landsale where appno=? and distcode=? and 
            subcode=? and circode=?";
            $noc_landsale = $this->db->query($sql20, array($pet_basic->noc_no,
                $dist_code, $subdiv_code, $cir_code))->row();

            $save_chain_data = true;

            ////////////////////////////////////////////////////////////////////////// propoerty chain code///////////////////////////////////////////////////////////////////
            if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
            { 
                $chain_send_data_arr= array();
                

                // $alreadyGISCodeExist  = null;
                foreach ($dags as $dag)
                {
                   
                    
                    $ulpinArray = $this->PropChainModel->getUlpin($dag->dist_code, $dag->subdiv_code, $dag->cir_code, $dag->mouza_pargona_code, $dag->lot_no, $dag->vill_townprt_code, $dag->patta_no, $dag->dag_no);

                    // var_dump($checkUlpin->ulpin);echo

                    if($ulpinArray->ulpin==null || $ulpinArray->ulpin=='')
                    {
                        log_message("error", " #OMCPCS002 Final order cannot be passed for one of the given Dag as it is in Property chain!!: " . $dag->dist_code . ", case no: " . $case_no);
                        $array = array(
                            'error' => true,
                            'redirect_url' => 0,
                            'msg' => "#OMCPCS002 Final order cannot be passed for one of the given Dag as it is not available in Property chain!!",
                        );
                        $this->db->trans_rollback();
                        echo json_encode($array);
                        return;
                    }

                    $dagRevenue = $this->PropChainModel->getDagRevenue($dag->dist_code, $dag->subdiv_code, $dag->cir_code, $dag->mouza_pargona_code, $dag->lot_no, $dag->vill_townprt_code, $dag->patta_no, $dag->dag_no);

                    $ulpinFlag = $this->input->post('ulpinCheckFlag');
                    $compareFlag = $this->input->post('compareCheckFlag');
                    


                    if($compareFlag == 'Y' && $ulpinFlag ==1)
                    {  


                        // $ulpin = $this->input->post('ulpin', true);
                        // $old_ulpin = $this->input->post('old_ulpin', true);
                        // $revenue = $this->input->post('chain_revenue', true);
                        // $local_tax = $this->input->post('chain_local_tax', true);


                        $old_ulpin = $ulpinArray->old_ulpin;
                        $ulpin = $ulpinArray->ulpin;
                        $revenue = $dagRevenue->dag_revenue;
                        $local_tax = $dagRevenue->dag_local_tax;   


                        
                        

                        if (!isset($old_ulpin)) {
                            $old_ulpin = "";
                        }

                        $type = LOC_TYPE_RURAL;
                        $patta_no = $dag->patta_no;
                        $dag_no = $dag->dag_no;
                        $patta_type_code = $dag->patta_type_code;

                        $location_id = $this->blockchainutilityclass->generateLocId($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

                        $property_id = $this->blockchainutilityclass->generatePropertyId($type, $vill_townprt_code, $patta_no, $dag_no, $ulpin);

                        $reference_id = $case_no;
                        $certmnemonic = CERTMNEMONIC_MUT;
                        $property_signature = "base64 encoded signature";
                        $property_signer_key = "base64 encoded public key";
                        $office_code = $this->session->userdata('cir_code');
                        $user_code = $this->session->userdata('user_code');

                        $land_class_code = $this->PropChainModel->getLandClassCode($dist_code, $subdiv_code,  $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no);

                        $pattadar_details = $this->PropChainModel->getPattadars($dist_code, $subdiv_code,  $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no);

                        // since this is mutation and below paramaters are not applicable send the values as empty string
                        $new_patta_no = $new_dag_no = $old_revenue = $old_local_tax = $old_land_class_code = $new_bigha = $new_katha = $new_lessa = $new_ganda = "";


                        $sql4 = "select dag_area_b,dag_area_k,round(dag_area_lc,2) as dag_area_lc,dag_area_g,dag_area_kr from chitha_basic where 
                        dist_code=? and subdiv_code=? and 
                        cir_code=? and mouza_pargona_code=? and lot_no=?
                         and vill_townprt_code=? and dag_no=? and patta_no=? and patta_type_code=?";
                     
                        $chithaAreaBC = $this->db->query($sql4, array($dist_code, $subdiv_code,
                            $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code,
                            $dag_no, $patta_no, $patta_type_code));
                        
                        $areaBChain=$chithaAreaBC->row();
                        $c_dag_area_b = $areaBChain->dag_area_b;
                        $c_dag_area_k = $areaBChain->dag_area_k;
                        $c_dag_area_lc = $areaBChain->dag_area_lc;
                        $c_dag_area_g = $areaBChain->dag_area_g==null?0:$areaBChain->dag_area_g;
                        $c_dag_area_kr = $areaBChain->dag_area_kr==null?0:$areaBChain->dag_area_kr;


                        $update_params = array(
                            'pattadar_details' => $pattadar_details,
                            'location_id' => $location_id,
                            'property_id' => $property_id,
                            'reference_id' => $reference_id,
                            'dag_no' => $dag_no,
                            'patta_no' => $patta_no,
                            'patta_type_code' => $patta_type_code,
                            'land_class_code' => $land_class_code,
                            'bigha_chain' => $c_dag_area_b,
                            'katha_chain' => $c_dag_area_k,
                            'lessa_chain' => $c_dag_area_lc,
                            'ganda_chain' => $c_dag_area_g,
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

                        $chain_send_data = $this->blockchainutilityclass->getUpdateChainArrayN((object)$update_params);

                        $chain_send_data_arr[]= $chain_send_data;

                        // echo "<pre></pre>";
                        // $send_chain_api = $this->utilityclass->propertyChainUpdateApi($chain_send_data);
                        // $save_chain_data = $this->PropChainModel->save_chain_data(json_encode($chain_send_data), $case_no);

                    }
                }
                // echo "<pre>";
                // var_dump($chain_send_data_arr);
                // die;

                $total_no_prop_dags=sizeof($chain_send_data_arr);
                $total_no_of_prp_saved = array();
                foreach($chain_send_data_arr as $chain_send_data){
                    $save_chain_data = $this->PropChainModel->save_chain_data(json_encode($chain_send_data), $case_no);

                    $total_no_of_prp_saved[] = $save_chain_data;

                }
                // 
                // echo "<pre>";
                // var_dump($total_no_of_prp_saved);
                // $this->db->trans_rollback();
                // exit;
                if(in_array(false,$total_no_of_prp_saved))
                {
                    log_message("error", " #OMCPCS003 Final order cannot be passed for one of the given Dag as it is in Property chain!!");
                        $array = array(
                            'error' => true,
                            'redirect_url' => 0,
                            'msg' => "#OMCPCS003 Final order cannot be passed for one of the given Dag as it is not available in Property chain!!",
                        );
                        $this->db->trans_rollback();
                        echo json_encode($array);
                        return;
                }



            }




            if ($noc_landsale->automut == 'P') {
                ////partition case register
                $partion_save = $this->savePartionCase($case_no,
                    $dist_code, $subdiv_code, $cir_code,
                    $mouza_pargona_code, $lot_no,
                    $vill_townprt_code, $autoUpdate['new_pattadar']);

                if ($partion_save['error'] != false || $partion_save == null) {
                    $this->db->trans_rollback();
                    $array = array(
                        'error' => true,
                        'msg' => $partion_save['msg'],
                    );
                    echo json_encode($array);
                    return;
                }
                

                 /////////////////////////property chain code ///////////////////////////////
                if ($save_chain_data) {

                $this->db->trans_commit();
                $this->session->set_flashdata(array('message' => "Order Passed for Mutation Case # $case_no <br> Successfully Registered Partition Case : $partion_save[case_no]"));
                $this->session->set_flashdata(array('message2' => "Chitha and Jamabandi Updated for Case # $case_no "));

                $array = array(
                    'error' => false,
                    'msg' => "Order Passed for Case # $case_no 
                            <br> Chitha and Jamabandi Updated for Case # $case_no 
                            <br> Successfully Register Partition Case : $partion_save[case_no] ",
                );
                echo json_encode($array);
                return;
                }

                elseif (!$save_chain_data) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error occured. Case No $case_no Not Passed. Error Code: #CHAINSAVEERROR0001");
                    log_message("error", "Data not saved in table prop_chain_sent_data. Error code: #CHAINSAVEERROR0001");

                    $array = array(
                        'error' => true,
                        'msg' => "#CHAINSAVEERROR0001 Error in final process",
                    );
                    echo json_encode($array);
                    return;
                } else {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error occured. Property Chain updation for Case No $case_no Not Successfull.");

                    $array = array(
                        'error' => true,
                        'msg' => "#OMCS031 Error in final process",
                    );
                    echo json_encode($array);
                    return;
                }
            } 
            else {

                if ($save_chain_data) {

                $this->db->trans_commit();
                $this->AgriStackCaseHistory->CreateLog($dist_code,$case_no);
                $this->session->set_flashdata(array('message' => "Order Passed for Mutation Case # $case_no "));
                $this->session->set_flashdata(array('message2' => "Chitha and Jamabandi Updated for Case # $case_no "));

                $array = array(
                    'error' => false,
                    'msg' => "Order Passed for Case # $case_no 
                            <br> Chitha and Jamabandi Updated for Case # $case_no ",
                );
                echo json_encode($array);
                return;
            }

            }

        } else {
            $this->db->trans_rollback();
            log_message("error", " #OMCS024 Error in final process
                   district: " . $dist_code . ", petition_no: " . $petition_no);
            $array = array(
                'error' => true,
                'msg' => "#OMCS024 Error in final process.",
            );
            echo json_encode($array);
            return;
        }
    }

    public function autoUpdateOfc($dist_code, $subdiv_code, $cir_code,
                                  $lot_no, $vill_code, $mouza_pargona_code, $petition_no, $case_no)
    {
        $locationData = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_code,
            'mouza_pargona_code' => $mouza_pargona_code,
        );


        $sql5 = "select DISTINCT ON (patta_no, patta_type_code) patta_no, patta_type_code from petition_dag_details where "
            . "petition_no=? and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
            . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and mouza_pargona_code='$mouza_pargona_code' and case_no =?";
        $res5 = $this->db->query($sql5, array($petition_no,$case_no));
        if ($res5->num_rows() <= 0) {
            $this->db->trans_rollback();
            log_message("error", " #OMCS028 could not find petition_dag_details 
                           district: " . $dist_code . ", petition_no: " . $petition_no . " dag no " . $dag->dag_no);
            $array = array(
                'error' => true,
                'msg' => "#OMCS028 could not find data.",
            );
            return $array;
        }

        $pattas = $res5->result();

        $new_pattadar_array = null;
        foreach ($pattas as $patta) {
            $sql7 = "select distinct on (petition_no,dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,dag_no) *  from petition_dag_details where "
                . "petition_no=? and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
                . " lot_no='$lot_no' and vill_townprt_code='$vill_code' 
                and mouza_pargona_code='$mouza_pargona_code' and patta_no=? and patta_type_code=? and case_no =?";
            $res7 = $this->db->query($sql7, array($petition_no, $patta->patta_no, $patta->patta_type_code,$case_no));

            $dags = $res7->result();

            $pdar_id_array = null;

            foreach ($dags as $dag) {
                $record_count = 0;
                $patta_no = "";
                $q = "select max(ord_cron_no)+1 as c1,max(rmk_type_hist_no)+1 as c2 from chitha_rmk_ordbasic where"
                    . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
                    . " lot_no='$lot_no' and vill_townprt_code='$vill_code' 
                and mouza_pargona_code='$mouza_pargona_code' and dag_no=?";

                $ord_cron_no = $this->db->query($q, array($dag->dag_no))->row()->c1;
                $q = "select max(rmk_type_hist_no)+1 as c2 from chitha_rmk_gen where"
                    . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
                    . " lot_no='$lot_no' and vill_townprt_code='$vill_code' 
                and mouza_pargona_code='$mouza_pargona_code' and dag_no=?";
                $rmk_type_hist_no = $this->db->query($q, array($dag->dag_no))->row()->c2;

                if ($ord_cron_no == null) {
                    $ord_cron_no = 1;
                }
                if ($rmk_type_hist_no == null) {
                    $rmk_type_hist_no = 1;
                }

                $order_query = "select * from t_chitha_rmk_ordbasic where "
                    . " ord_no=? and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
                    . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and 
                ord_type_code='03' and mouza_pargona_code='$mouza_pargona_code' 
                and dag_no='$dag->dag_no' and iscorrected_inco is null ";
                $orders = $this->db->query($order_query, array($dag->case_no));

                if ($orders->num_rows() <= 0) {
                    $this->db->trans_rollback();
                    log_message("error", " #OMCS010 could not find t_chitha_rmk_ordbasic 
                           district: " . $dist_code . ", petition_no: " . $petition_no . " dag no " . $dag->dag_no);
                    $array = array(
                        'error' => true,
                        'msg' => "#OMCS010 could not find data.",
                    );
                    return $array;
                }

                $orders = $orders->result();

                foreach ($orders as $order) {
                    //copy alongwith information from    transaction to chitha
                    $record_count++;

                    $alongwith_q = "select * from t_chitha_rmk_alongwith where ord_no=?
                    and dag_no=?";
                    $alongwith_d = $this->db->query($alongwith_q,
                        array($order->ord_no, $dag->dag_no));
                    $alongwith_d_count = $alongwith_d->num_rows();


                    $inplace_q = "select * from t_chitha_rmk_inplace_of where ord_no=?
                    and dag_no=?";
                    $inplace_d = $this->db->query($inplace_q,
                        array($order->ord_no, $dag->dag_no));
                    $inplace_d_count = $inplace_d->num_rows();

                    if ($alongwith_d_count <= 0 && $inplace_d_count <= 0) {
                        $this->db->trans_rollback();
                        log_message("error", " #OMCS011 inplace/alongwith data not found 
                        district: " . $dist_code . ", petition_no: " . $petition_no . " dag no" . $dag->dag_no);
                        $array = array(
                            'error' => true,
                            'msg' => "#OMCS011 could not find data.",
                        );
                        return $array;
                    }
                    $alongwith_d = $alongwith_d->result();
                    $inplace_d = $inplace_d->result();

                    foreach ($alongwith_d as $along) {
                        $ord_cron_no = $ord_cron_no;
                        unset($along->year_no);
                        unset($along->petition_no);
                        unset($along->iscorrected_inco);
                        unset($along->iscorrected_inco_date);
                        unset($along->iscorrected_rkg_record);
                        unset($along->iscorrected_rkg_date);
                        unset($along->make_mdb);
                        $along->rmk_type_hist_no = $rmk_type_hist_no;
                        $along->ord_cron_no = $ord_cron_no;
                        $along->user_code = $this->user_code;
                        $along->operation = 'E';
                        $along->date_entry = date('Y-m-d G:i:s');
                        $tstatus1 = $this->db->insert("chitha_rmk_alongwith", $along); //*****************
                        if ($tstatus1 != 1) {
                            $this->db->trans_rollback();
                            log_message("error", " #OMCS012 could not insert t_chitha_rmk_alongwith
                           district: " . $dist_code . ", petition_no: " . $petition_no . " dag no" . $dag->dag_no);
                            $array = array(
                                'error' => true,
                                'msg' => "#OMCS012 Unable to insert data.",
                            );
                            return $array;
                        }
                    }

                    foreach ($inplace_d as $inplace) {
                        $petition_no = $inplace->petition_no;
                        $ord_cron_no = $ord_cron_no;
                        unset($inplace->year_no);
                        unset($inplace->petition_no);
                        unset($inplace->iscorrected_inco);
                        unset($inplace->iscorrected_inco_date);
                        unset($inplace->iscorrected_rkg_record);
                        unset($inplace->iscorrected_rkg_date);
                        unset($inplace->make_mdb);

                        $inplace->rmk_type_hist_no = $rmk_type_hist_no;
                        $inplace->ord_cron_no = $ord_cron_no;
                        $inplace->user_code = $this->user_code;
                        $inplace->operation = 'E';
                        $inplace->date_entry = date('Y-m-d G:i:s');

                        $tstatus2 = $this->db->insert("chitha_rmk_inplace_of", $inplace); //**************
                        if ($tstatus2 != 1) {
                            $this->db->trans_rollback();
                            log_message("error", " #OMCS013 could not insert chitha_rmk_inplace_of
                           district: " . $dist_code . ", petition_no: " . $petition_no . " dag no" . $dag->dag_no);
                            $array = array(
                                'error' => true,
                                'msg' => "#OMCS013 Unable to insert data.",
                            );
                            return $array;
                        }

//                    $details = $this->db->query("select * from petition_dag_details where petition_no=$petition_no and $this->base_query")->row();

                        // $update_query = "update chitha_dag_pattadar set p_flag='1' where "
                        //     . " dist_code ='$inplace->dist_code' and subdiv_code='$inplace->subdiv_code' and "
                        //     . " cir_code ='$inplace->cir_code' and mouza_pargona_code='$inplace->mouza_pargona_code' and"
                        //     . " lot_no='$inplace->lot_no' and vill_townprt_code='$inplace->vill_townprt_code' and"
                        //     . " TRIM(patta_no)=trim('$dag->patta_no') and
                        //     dag_no='$dag->dag_no' and patta_type_code='$dag->patta_type_code' "
                        //     . " and pdar_id=$inplace->pdar_id ";


                        // $patta_no = trim($dag->patta_no);
                        // $this->db->query($update_query);
                        $table = 'chitha_dag_pattadar';

                        $params = [
                            'p_flag' => '1',
                        ];

                        $where = [
                            'dist_code'          => $inplace->dist_code,
                            'subdiv_code'        => $inplace->subdiv_code,
                            'cir_code'           => $inplace->cir_code,
                            'mouza_pargona_code' => $inplace->mouza_pargona_code,
                            'lot_no'             => $inplace->lot_no,
                            'vill_townprt_code'  => $inplace->vill_townprt_code,
                            'patta_no'           => trim($dag->patta_no),
                            'dag_no'             => $dag->dag_no,
                            'patta_type_code'    => $dag->patta_type_code,
                            'pdar_id'            => $inplace->pdar_id,
                        ];

                        $result = $this->Chitha_basic_model->update_table($table, $params, $where);


                        if ($result <= 0) {
                            $this->db->trans_rollback();
                            log_message("error", " #OMCS014 could not update chitha_dag_pattadar
                           district: " . $dist_code . ", petition_no: " . $petition_no . " dag no " . $dag->dag_no);
                            $array = array(
                                'error' => true,
                                'msg' => "#OMCS014 Unable to update data.",
                            );
                            return $array;
                        }
                    }

                    $infavour_q = "select * from t_chitha_rmk_infavor_of where ord_no=?
                    and dag_no=? and patta_no=? and patta_type_code=?";
                    $infavour_d = $this->db->query($infavour_q,
                        array($order->ord_no, $dag->dag_no, $dag->patta_no, $dag->patta_type_code));

                    if ($infavour_d == null || $infavour_d->num_rows() <= 0) {
                        $this->db->trans_rollback();
                        log_message("error", " #OMCS015 could not find data in t_chitha_rmk_infavor_of
                        district: " . $dist_code . ", petition_no: " . $petition_no . " dag no" . $dag->dag_no);
                        $array = array(
                            'error' => true,
                            'msg' => "#OMCS015 could not find data.",
                        );
                        return $array;
                    }
                    $infavour_d = $infavour_d->result();
                    foreach ($infavour_d as $infavour) {
                        $infavour->user_code = $this->user_code;
                        $infavour->operation = 'E';
                        $infavour->rmk_type_hist_no = $rmk_type_hist_no;
                        $infavour->ord_cron_no = $ord_cron_no;
                        $infavour->date_entry = date('Y-m-d G:i:s');
                        unset($infavour->year_no);
                        unset($infavour->petition_no);
                        unset($infavour->iscorrected_inco);
                        unset($infavour->iscorrected_inco_date);
                        unset($infavour->iscorrected_rkg_record);
                        unset($infavour->iscorrected_rkg_date);
                        unset($infavour->make_mdb);
                        unset($infavour->pdar_id);
                        unset($infavour->revenue);
                        unset($infavour->infavor_is_copdar);
                        $new_pattadar = $infavour->new_pattadar;
                        unset($infavour->new_pattadar);

                        $cstatus6 = $this->db->insert("chitha_rmk_infavor_of", $infavour);

                        if ($cstatus6 != 1) {
                            $this->db->trans_rollback();
                            log_message("error", " #OMCS026 could not insert chitha_rmk_infavor_of
                           district: " . $dist_code . ", petition_no: " . $petition_no . " patta no " . $infavour->patta_no);
                            $array = array(
                                'error' => true,
                                'msg' => "#OMCS026 Unable to insert data.",
                            );
                            return $array;
                        }
                    }
                    if ($pdar_id_array == null) {
                        foreach ($infavour_d as $infavour) {
                            //$newObj = clone $infavour;
                            $pattadar = array();
                            $pattadar = array_merge($pattadar, $locationData);
                            unset($pattadar['application_no']);
                            ////////////////////////////////
                            $is_pdar_id_set=null;
                            $org_patta_type_code=$infavour->patta_type_code;
                            $org_patta_no=$infavour->patta_no;
                            if($is_pdar_id_set==FALSE){
                                  $pattadars_in_chitha_pattadar = $this->db->query("select max(pdar_id::int)+1 as cp from chitha_pattadar where dist_code='$dist_code' and "
                                    . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
                                    . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$org_patta_type_code' and TRIM(patta_no)=trim('$org_patta_no')")->row()->cp;

                                  $pattadars_in_jama_pattadar = $this->db->query("select max(pdar_id::int)+1 as jp from jama_pattadar where dist_code='$dist_code' and "
                                   . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
                                   . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$org_patta_type_code' and TRIM(patta_no)=trim('$org_patta_no')")->row()->jp;
                                  $pattadars_in_chithaDag_pattadar = $this->db->query("select max(pdar_id::int)+1 as dp from chitha_dag_pattadar where dist_code='$dist_code' and "
                                   . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
                                   . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$org_patta_type_code' and TRIM(patta_no)=trim('$org_patta_no') and dag_no='$dag->dag_no'")->row()->dp;
                                  if($pattadars_in_chitha_pattadar > $pattadars_in_jama_pattadar){
                                    if($pattadars_in_chithaDag_pattadar>$pattadars_in_chitha_pattadar){
                                        $pdar_id= $pattadars_in_chithaDag_pattadar;
                                    }else{
                                        $pdar_id= $pattadars_in_chitha_pattadar;
                                    }
                                }elseif($pattadars_in_chithaDag_pattadar > $pattadars_in_jama_pattadar){
                                    $pdar_id= $pattadars_in_chithaDag_pattadar;
                                }else{
                                    $pdar_id= $pattadars_in_jama_pattadar;
                                }
                                if ($pdar_id == null) {
                                    $pdar_id = 1;
                                }
                                $is_pdar_id_set=TRUE;
                            }else{
                              $pdar_id = $pdar_id+1;
                            }
                            ////////////////////////////////

                            $flagAadhaar = null;
                            $flagPan = null;
                            if($infavour->auth_type == 'AADHAAR'){
                                $pdar_aadharno = $infavour->id_ref_no;
                                $flagAadhaar = $infavour->id_ref_no;
                                $flagPan = null;
                            }else if($infavour->auth_type == 'PAN'){
                                $pdar_pan_no = $infavour->id_ref_no;
                                $flagAadhaar = null;
                                $flagPan = $infavour->id_ref_no;
                            }
                            else{
                                $pdar_pan_no = null;
                                $flagAadhaar = null;
                                $flagPan = null;
                            }

                            ///////////////////////////////

                            $other_data = array(
                                'pdar_id' => $pdar_id,
                                'patta_no' => trim($infavour->patta_no),
                                'patta_type_code' => $infavour->patta_type_code,
                                'pdar_name' => $infavour->infavor_of_name,
                                'pdar_father' => $infavour->infavor_of_guardian,
                                'pdar_add1' => $infavour->infavor_of_add1,
                                'pdar_add2' => $infavour->infavor_of_add2,
                                'pdar_add3' => "",
                                'user_code' => $this->user_code,
                                'date_entry' => date('Y-m-d G:i:s'),
                                'operation' => 'E',
                                'jama_yn' => 'n',
                                'pdar_guard_reln' => $infavour->infav_of_guar_relation,
                                'pdar_gender' => $infavour->infavor_of_gender,
                                'new_pdar_name' => $new_pattadar,
                                'pdar_name_eng' => $infavour->pdar_name_eng,
                                'pdar_guard_eng' => $infavour->pdar_guard_eng,
                                'pdar_aadharno' => $flagAadhaar,
                                'pdar_pan_no'   => $flagPan,
                            );
                            $patta_no = trim($dag->patta_no);
                            $pattadar = array_merge($pattadar, $other_data);
                            // $tstatus4 = $this->db->insert("chitha_pattadar", $pattadar);
                            $pattadar['f1_case_no']=$case_no;
                            $tstatus4 = $this->Chitha_basic_model->insert_table('chitha_pattadar',$pattadar);
                            if ($tstatus4 != 1) {
                                $this->db->trans_rollback();
                                log_message("error", " #OMCS016 could not insert chitha_pattadar
                           district: " . $dist_code . ", petition_no: " . $petition_no . " patta no " . $infavour->patta_no);
                                $array = array(
                                    'error' => true,
                                    'msg' => "#OMCS016 Unable to insert data.",
                                );
                                return $array;
                            }
                            $dag_pattadar = array();
                            $dag_pattadar = array_merge($dag_pattadar, $locationData);
                            unset($dag_pattadar['application_no']);

                            $dag_pattadar_other = array(
                                'pdar_id' => $pdar_id,
                                'patta_no' => trim($infavour->patta_no),
                                'patta_type_code' => $infavour->patta_type_code,
                                'dag_por_b' => $infavour->land_area_b,
                                'dag_por_k' => $infavour->land_area_k,
                                'dag_por_lc' => $infavour->land_area_lc,
                                'dag_por_g' => $infavour->land_area_g,
                                'dag_por_kr' => $infavour->land_area_kr,
                                'user_code' => $this->user_code,
                                'date_entry' => date('Y-m-d G:i:s'),
                                'operation' => 'E',
                                'jama_yn' => 'n',
                                'dag_no' => $infavour->dag_no,
                                'p_flag' => 0,
                            );
                            $dag_pattadar = array_merge($dag_pattadar, $dag_pattadar_other);
                            // $tstatus5 = $this->db->insert("chitha_dag_pattadar", $dag_pattadar);
                            $tstatus5 = $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$dag_pattadar);
                            if ($tstatus5 != 1) {
                                $this->db->trans_rollback();
                                log_message("error", " #OMCS017 could not insert chitha_dag_pattadar
                           district: " . $dist_code . ", petition_no: " . $petition_no . " dag no" . $dag->dag_no);
                                $array = array(
                                    'error' => true,
                                    'msg' => "#OMCS017 Unable to insert data.",
                                );
                                return $array;
                            }

                            // $q = "update chitha_basic set jama_yn=null where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                            //     . "cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and "
                            //     . "lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$infavour->dag_no' and TRIM(patta_no)=trim('$infavour->patta_no')";

                            // $this->db->query($q);

                            $table = 'chitha_basic';

                            $params = [
                                'jama_yn' => null,
                            ];

                            $where = [
                                'dist_code'          => $dist_code,
                                'subdiv_code'        => $subdiv_code,
                                'cir_code'           => $cir_code,
                                'mouza_pargona_code' => $mouza_pargona_code,
                                'lot_no'             => $lot_no,
                                'vill_townprt_code'  => $vill_code,
                                'dag_no'             => $infavour->dag_no,
                                'patta_no'           => trim($infavour->patta_no),  // PHP trim to mimic SQL TRIM()
                            ];

                            // Then call your update method:
                            $result1 = $this->Chitha_basic_model->update_table($table, $params, $where);

                            if ($result1 <= 0) {
                                $this->db->trans_rollback();
                                log_message("error", " #OMCS017 could not update chitha_basic
                           district: " . $dist_code . ", petition_no: " . $petition_no . " dag no" . $dag->dag_no);
                                $array = array(
                                    'error' => true,
                                    'msg' => "#OMCS017 Unable to update data.",
                                );
                                return $array;
                            }
                            $pdar_id_array[] = $pdar_id;
                            $new_pattadar_array[] = (object)array(
                                'dag_no' => $infavour->dag_no,
                                'pdar_id' => $pdar_id,
                                'patta_no' => $infavour->patta_no,
                                'patta_type_code' => $infavour->patta_type_code,
                            );
                        }
                    } else {
                        $i = 0;
                        foreach ($infavour_d as $infavour) {
                            //$newObj = clone $infavour;
                            $pattadar = array();
                            $pattadar = array_merge($pattadar, $locationData);
                            unset($pattadar['application_no']);
                            $pdar_id = $pdar_id_array[$i];
                            $dag_pattadar = array();
                            $dag_pattadar = array_merge($dag_pattadar, $locationData);
                            unset($dag_pattadar['application_no']);

                            $dag_pattadar_other = array(
                                'pdar_id' => $pdar_id,
                                'patta_no' => trim($infavour->patta_no),
                                'patta_type_code' => $infavour->patta_type_code,
                                'dag_por_b' => $infavour->land_area_b,
                                'dag_por_k' => $infavour->land_area_k,
                                'dag_por_lc' => $infavour->land_area_lc,
                                'dag_por_g' => $infavour->land_area_g,
                                'dag_por_kr' => $infavour->land_area_kr,
                                'user_code' => $this->user_code,
                                'date_entry' => date('Y-m-d G:i:s'),
                                'operation' => 'E',
                                'jama_yn' => 'n',
                                'dag_no' => $infavour->dag_no,
                                'p_flag' => 0,
                            );
                            $dag_pattadar = array_merge($dag_pattadar, $dag_pattadar_other);
                            // $tstatus5 = $this->db->insert("chitha_dag_pattadar", $dag_pattadar);
                            $tstatus5 = $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$dag_pattadar);
                            if ($tstatus5 != 1) {
                                $this->db->trans_rollback();
                                log_message("error", " #OMCS017 could not insert chitha_dag_pattadar
                           district: " . $dist_code . ", petition_no: " . $petition_no . " dag no" . $dag->dag_no);
                                $array = array(
                                    'error' => true,
                                    'msg' => "#OMCS017 Unable to insert data.",
                                );
                                return $array;
                            }

                            // $q = "update chitha_basic set jama_yn=null where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                            //     . "cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and "
                            //     . "lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$infavour->dag_no' and TRIM(patta_no)=trim('$infavour->patta_no')";

                            // $this->db->query($q);

                            $table = 'chitha_basic';

                            $params = [
                                'jama_yn' => null,
                            ];

                            $where = [
                                'dist_code'          => $dist_code,
                                'subdiv_code'        => $subdiv_code,
                                'cir_code'           => $cir_code,
                                'mouza_pargona_code' => $mouza_pargona_code,
                                'lot_no'             => $lot_no,
                                'vill_townprt_code'  => $vill_code,
                                'dag_no'             => $infavour->dag_no,
                                'patta_no'           => trim($infavour->patta_no), // PHP trim to match TRIM() in SQL
                            ];

                            // Then call your model update method:
                            $result2 = $this->Chitha_basic_model->update_table($table, $params, $where);

                            if ($result2 <= 0) {
                                $this->db->trans_rollback();
                                log_message("error", " #OMCS017 could not update chitha_basic
                           district: " . $dist_code . ", petition_no: " . $petition_no . " dag no" . $dag->dag_no);
                                $array = array(
                                    'error' => true,
                                    'msg' => "#OMCS017 Unable to update data.",
                                );
                                return $array;
                            }
                            $i++;
                        }
                    }
                    $order->user_code = $this->user_code;
                    $order->date_entry = date('Y-m-d G:i:s');
                    $order->operation = 'E';
                    $order->user_code = $this->user_code;
                    unset($order->year_no);
                    unset($order->petition_no);
                    unset($order->year_no);
                    unset($order->iscorrected_inco);
                    unset($order->iscorrected_inco_date);
                    unset($order->iscorrected_rkg_record);
                    unset($order->iscorrected_rkg_date);
                    unset($order->isdataposted_torkg_db);
                    unset($order->isorder_cancelled);
                    unset($order->ifyes_reason1);
                    unset($order->ifyes_reason2);
                    unset($order->ifyes_reason3);
                    unset($order->ifyes_reason4);
                    unset($order->make_mdb);
                    unset($order->min_revenue);
                    unset($order->make_mdb);
                    $rmk_gen = array(
                        'dag_no' => $dag->dag_no,
                        'rmk_type_code' => '01',
                        'rmk_type_hist_no' => $rmk_type_hist_no,
                        'user_code' => $this->user_code,
                        'date_entry' => date('Y-m-d G:i:s'),
                        'operation' => 'E',
                        'jama_updated' => 'N',
                        'patta_no' => trim($patta_no)
                    );
                    $rmk_gen = array_merge($locationData, $rmk_gen);
                    unset($rmk_gen['application_no']);

                    $tstatus6 = $this->db->insert("chitha_rmk_gen", $rmk_gen);
                    if ($tstatus6 != 1) {
                        $this->db->trans_rollback();
                        log_message("error", " #OMCS018 could not insert chitha_rmk_gen
                        district: " . $dist_code . ", petition_no: " . $petition_no . " dag no" . $dag->dag_no);
                        $array = array(
                            'error' => true,
                            'msg' => "#OMCS018 Unable to insert data.",
                        );
                        return $array;
                    }

                    $order->ord_cron_no = $ord_cron_no;
                    $order->rmk_type_hist_no = $rmk_type_hist_no;

                    $tstatus7 = $this->db->insert("chitha_rmk_ordbasic", $order);
                    if ($tstatus7 != 1) {
                        $this->db->trans_rollback();
                        log_message("error", " #OMCS019 could not insert chitha_rmk_ordbasic
                        district: " . $dist_code . ", petition_no: " . $petition_no . " dag no" . $dag->dag_no);
                        $array = array(
                            'error' => true,
                            'msg' => "#OMCS019 Unable to insert data.",
                        );
                        return $array;
                    }

                    $q = "update t_chitha_rmk_ordbasic set iscorrected_inco='Y' where ord_no='$order->ord_no'
                    and dag_no='$dag->dag_no'";
                    $this->db->query($q);
                    if ($this->db->affected_rows() <= 0) {
                        $this->db->trans_rollback();
                        log_message("error", " #OMCS020 could not update t_chitha_rmk_ordbasic
                        district: " . $dist_code . ", petition_no: " . $petition_no . " dag no" . $dag->dag_no);
                        $array = array(
                            'error' => true,
                            'msg' => "#OMCS020 Unable to update data.",
                        );
                        return $array;
                    }
                    $rmk_type_hist_no++;
                }
            }
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message("error", " #OMCS021 Transaction Error
                        district: " . $dist_code . ", petition_no: " . $petition_no);
            $array = array(
                'error' => true,
                'msg' => "#OMCS021 Transaction Error.",
            );
            return $array;
        } else {
            $array = array(
                'error' => false,
                'msg' => "OK",
                'new_pattadar' => $new_pattadar_array,
            );
            return $array;
        }
    }
    function DashboardDataFinal($case_no)
    {
        //////////////Update Dashboard Database///////////////////////
        $base = array(
            'final_order_date' => date('Y-m-d'),
            'pending_with_user' => 'NA',
            'status' => 'F',
            'remark' => 'Final Order Passed',
            'date_of_update' => date("Y-m-d h:i:s")
        );
        $this->db->where('case_no', $case_no);
        $this->db->update('dashboard_data', $base);

        $ip=$this->utilityclass->checkIp($this->utilityclass->get_client_ip());
        if ($ip == true)
        return;

        $action = array(
            'case_no' => $case_no,
            'user_code' => $this->session->userdata('user_code'),
            'date_of_action_taken' => date("Y-m-d h:i:s"),
            'user_designation' => $this->session->userdata('user_desig_code'),
            'remark' => 'Final Order Passed',
            'ip_address' => $this->utilityclass->get_client_ip()
        );
        $this->db->insert('dashboard_action', $action);
        /////////////////////////////////////
    }

    ///jamabandi update///
    public function JamaBandiStep3($patta_no, $patta_type, $dis_code, $s, $c, $m, $l, $v)
    {
        $get_old_patta_type_code = '';
        $dist_code = $dis_code;
        $subdiv_code = $s;
        $circle_code = $c;
        $mouza_code = $m;
        $lot_no = $l;
        $vill_code = $v;

        $query_dags = "select * from chitha_basic where TRIM(chitha_basic.patta_no)='$patta_no' and patta_type_code='$patta_type'"
            . " and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
            . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'  "
            . " and  (lower(jama_yn)!='y' or jama_yn is null)";


        $dags = $this->db->query($query_dags)->result();
        $pendingMap = false;
        $defined = define_date;
        foreach ($dags as $d) {
            //This part is to check for mutation cases.
            $queryCheck = "select count(*) as c from chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'  "
                . "and dag_no='$d->dag_no' and map_partition is null and order_type_code='02' and date(co_ord_date)>='$defined'";

            $hasPending = $this->db->query($queryCheck)->row()->c;
            if ($hasPending) {
                $pendingMap = true;
                $pedingDag = $d->dag_no;
                break;
            }
        }

        foreach ($dags as $d) {
            //This part is to check for partition cases if map pending.
            $queryCheck = "select count(*) as c from chitha_rmk_ordbasic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'  "
                . "and dag_no='$d->dag_no' and map_partition='P'";

            $hasPending = $this->db->query($queryCheck)->row()->c;
            if ($hasPending) {
                $pendingMap = true;
                $pedingDag = $d->dag_no;
                break;
            }
        }

        $query = "select * from chitha_basic where TRIM(chitha_basic.patta_no)='$patta_no' and patta_type_code='$patta_type'"
            . " and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
            . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' "
            . " and (lower(jama_yn)!='y' or jama_yn is null)";

        $data = $this->db->query($query)->result();

        $countDag = 1;

        foreach ($data as $d) {
            $data = array(
                'dist_code' => $d->dist_code,
                'subdiv_code' => $d->subdiv_code,
                'cir_code' => $d->cir_code,
                'mouza_pargona_code' => $d->mouza_pargona_code,
                'lot_no' => $d->lot_no,
                'vill_townprt_code' => $d->vill_townprt_code,
                'patta_no' => trim($d->patta_no),
                'old_patta_no' => $d->old_patta_no,
                'patta_type_code' => $d->patta_type_code,
                'user_code' => $d->user_code,
                'entry_date' => $d->date_entry,
                //'dag_class_code' => $d->land_class_code,
                'entry_mode' => 'U'
            );

            unset($data['dag_class_code']);
            //Checks if new patta exists or not
            $q = "select count(*) as count from jama_patta where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' "
                . " and patta_type_code='$d->patta_type_code' and TRIM(patta_no)=trim('$d->patta_no')";

            $count = $this->db->query($q)->row()->count;

            if ($count == 0) {
                $jama_patta = $this->db->insert('jama_patta', $data); //.......................
                if ($jama_patta != 1) {
                    $this->db->trans_rollback();
                    log_message("error", " #OMCSJ0001 Unable to insert into jama_patta
                           district: " . $dist_code . ", patta no: " . $d->patta_no . " patta code " . $d->patta_type_code);
                    $array = array(
                        'error' => true,
                        'msg' => "#OMCSJ0001 Unable to insert data.",
                    );
                    return $array;
                }
            }
            ///////////
            $entry_date = date('Y-m-d');
            $g = "Update jama_patta set entry_date='$entry_date' where dist_code='$dist_code' 
                and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' "
                . " and patta_type_code='$d->patta_type_code' and TRIM(patta_no)=trim('$d->patta_no')";
            $this->db->query($g);
            ///////////////
        }

        $query_dags = "select * from chitha_basic where TRIM(chitha_basic.patta_no)='$patta_no' and patta_type_code='$patta_type'"
            . " and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
            . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'  "
            . " and  (lower(jama_yn)!='y' or jama_yn is null)";

        $dags = $this->db->query($query_dags)->result();

        foreach ($dags as $d) {
            $old_patta_no = $d->old_patta_no;
            $d->dag_class_code = $d->land_class_code;

            unset($d->old_dag_no);
            unset($d->dag_no_int);
            unset($d->land_class_code);
            unset($d->dag_area_are);
            unset($d->dag_local_tax);
            unset($d->dag_no_map);
            unset($d->dag_n_dag_no);
            unset($d->dag_e_dag_no);
            unset($d->dag_s_dag_no);
            unset($d->dag_e_dag_no);
            unset($d->dag_w_dag_no);
            unset($d->dp_flag_yn);
            unset($d->dag_w_dag_no);

            $d->entry_date = $d->date_entry;

            unset($d->date_entry);
            unset($d->operation);
            unset($d->jama_yn);
            unset($d->status);
            unset($d->old_patta_no);
            unset($d->dag_name);
            unset($d->dag_dept_name);
            unset($d->old_patta_no);
            unset($d->old_patta_no);
            unset($d->old_patta_no);
            unset($d->old_patta_no);
            unset($d->old_patta_no);

            $d->entry_mode = 'U';

            $qe = "select count(*) as count from jama_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                . " cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and"
                . " vill_townprt_code='$vill_code' and dag_no='$d->dag_no' and TRIM(patta_no) =trim('$d->patta_no') and"
                . " patta_type_code='$d->patta_type_code'";

            $count = $this->db->query($qe)->row()->count;

            if ($count == 0) {
                //Inserts if new patta & new dag does not exists
                $jama_dag = $this->db->insert('jama_dag', $d); //.......................
                if ($jama_dag != 1) {
                    $this->db->trans_rollback();
                    log_message("error", " #OMCSJ0002 Unable to insert into jama_dag
                           district: " . $dist_code . ", patta no: " . $d->patta_no . " patta code " . $d->patta_type_code);
                    $array = array(
                        'error' => true,
                        'msg' => "#OMCSJ0002 Unable to insert data.",
                    );
                    return $array;
                }
                //Checks if old patta & new dag exists(basically done because of full partition and full conversion)
                $check = "select count(*) as count from jama_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                    . " cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and"
                    . " vill_townprt_code='$vill_code' and dag_no='$d->dag_no' and TRIM(patta_no) = trim('$old_patta_no')";

                $check_existance = $this->db->query($check)->row()->count;
                if ($check_existance == '1') {
                    //before deleting get the old_patta_type_code from inserting remarks in the old patta
                    $get_old_patta_type_code = "select patta_type_code as patta_type_code from jama_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                        . " cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and"
                        . " vill_townprt_code='$vill_code' and dag_no='$d->dag_no' and TRIM(patta_no) = trim('$old_patta_no')";
                    $get_old_patta_type_code = $this->db->query($get_old_patta_type_code)->row()->patta_type_code;

                    //Delete old patta & dag that exists(basically done because of full partition and full conversion)
                    $delete = "Delete from jama_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                        . " cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and"
                        . " vill_townprt_code='$vill_code' and dag_no='$d->dag_no' and TRIM(patta_no) = trim('$old_patta_no')";

                    $this->db->query($delete); //.......................
                }
            } else {
                if ($d->dag_revenue == null) {
                    $d->dag_revenue = 5;
                }
                $query = "update jama_dag set dag_class_code='$d->dag_class_code', dag_area_b='$d->dag_area_b', dag_area_k='$d->dag_area_k' ,dag_area_lc='$d->dag_area_lc',dag_revenue='$d->dag_revenue' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                    . " cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and"
                    . " dag_no='$d->dag_no' and TRIM(patta_no) =trim('$d->patta_no') and patta_type_code='$d->patta_type_code'";

                $this->db->query($query); //.......................
            }

            $g = "select * from jama_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                . " cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and"
                . " vill_townprt_code='$vill_code' and dag_no='$d->dag_no' and TRIM(patta_no) =trim('$d->patta_no') and patta_type_code='$d->patta_type_code'";

            //This part is to check for mutation case Orders.
            $q = "select * from chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$d->dag_no' and"
                . " (lower(jama_updated)!='y' or jama_updated is null)";

            /* start of generating remarks for col8 related orders */
            $col8Remark = $this->getCol8Remark($patta_no, $dist_code, $subdiv_code,
                $circle_code, $mouza_code, $lot_no, $vill_code, $d->dag_no);

            $remarkText = $this->generate8Remark($d->dag_no, $col8Remark);

            /* end of generating remarks for col8 related orders */

            /* Inserting remarks of all col8 orders */
            $lineNo = "select max(rmk_line_no)+1 as max from jama_remark where dist_code='$dist_code' and"
                . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
                . "  lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$d->patta_type_code' and "
                . " TRIM(patta_no)='$patta_no'";

            $line_no = $this->db->query($lineNo)->row()->max;

            if ($line_no == null) {
                $line_no = 1;
            }
            if ($remarkText != null) {
                for ($j = 0; $j < sizeof($remarkText); $j++) {

                    $remarkData = array(
                        'dist_code' => $dist_code,
                        'subdiv_code' => $subdiv_code,
                        'cir_code' => $circle_code,
                        'mouza_pargona_code' => $mouza_code,
                        'lot_no' => $lot_no,
                        'vill_townprt_code' => $vill_code,
                        'patta_no' => $patta_no,
                        'patta_type_code' => $patta_type,
                        'rmk_line_no' => $line_no++,
                        'remark' => $remarkText[$j],
                        'user_code' => $d->user_code,
                        'entry_date' => date('Y-m-d'),
                        'entry_mode' => 'U'
                    );
                    if ($remarkText != null) {
                        $jama_remark = $this->db->insert('jama_remark', $remarkData); //.......................
                        if ($jama_remark != 1) {
                            $this->db->trans_rollback();
                            log_message("error", " #OMCSJ0003 Unable to insert into jama_remark
                           district: " . $dist_code . ", patta no: " . $d->patta_no . " patta code " . $d->patta_type_code);
                            $array = array(
                                'error' => true,
                                'msg' => "#OMCSJ0003 Unable to insert data.",
                            );
                            return $array;
                        }
                    }
                }
                /* end of inserting new remarks of all col8 orders */
            }


            /* start of generating remarks for col31 related orders */
            $col31Remark = $this->getCol31($patta_no, $dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $d->dag_no);

            $remark3c = $this->generateCol31Remark($d->dag_no, $col31Remark);

            /* end of generating remarks for col31 related orders */

            /* start of inserting new remarks of all col31 orders in old patta */
            if ($get_old_patta_type_code) {
                $update_patta_no = $old_patta_no;
                $update_patta_type_code = $get_old_patta_type_code;

                $lineNoq = "select max(rmk_line_no)+1 as max from jama_remark where dist_code='$dist_code' and"
                    . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
                    . "  lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$update_patta_type_code' and "
                    . " TRIM(patta_no)='$update_patta_no'";

                $line_no1 = $this->db->query($lineNoq)->row()->max;

                if ($line_no1 == null) {
                    $line_no1 = 1;
                }

                $remarkData = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'patta_no' => $update_patta_no,
                    'patta_type_code' => $update_patta_type_code,
                    'rmk_line_no' => $line_no1++,
                    'remark' => $remark3c,
                    'user_code' => $d->user_code,
                    'entry_date' => date('Y-m-d'),
                    'entry_mode' => 'U'
                );
                $jama_remark1 = $this->db->insert('jama_remark', $remarkData); //.......................
                if ($jama_remark1 != 1) {
                    $this->db->trans_rollback();
                    log_message("error", " #OMCSJ0004 Unable to insert into jama_remark
                           district: " . $dist_code . ", patta no: " . $d->patta_no . " patta code " . $d->patta_type_code);
                    $array = array(
                        'error' => true,
                        'msg' => "#OMCSJ0004 Unable to insert data.",
                    );
                    return $array;
                }
            }
            $lineNoq = "select max(rmk_line_no)+1 as max from jama_remark where dist_code='$dist_code' and"
                . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
                . "  lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$d->patta_type_code' and "
                . " TRIM(patta_no)='$patta_no'";
            $lineNoq . "<br>";
            $line_no1 = $this->db->query($lineNo)->row()->max;
            if ($line_no1 == null) {
                $line_no1 = 1;
            }
            $remarkData = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $circle_code,
                'mouza_pargona_code' => $mouza_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_code,
                'patta_no' => $patta_no,
                'patta_type_code' => $patta_type,
                'rmk_line_no' => $line_no1++,
                'remark' => $remark3c,
                'user_code' => $d->user_code,
                'entry_date' => date('Y-m-d'),
                'entry_mode' => 'U'
            );
            if ($remark3c != null) {
                $jama_remark2 = $this->db->insert('jama_remark', $remarkData); //.......................
                if ($jama_remark2 != 1) {
                    $this->db->trans_rollback();
                    log_message("error", " #OMCSJ0005 Unable to insert into jama_remark
                           district: " . $dist_code . ", patta no: " . $d->patta_no . " patta code " . $d->patta_type_code);
                    $array = array(
                        'error' => true,
                        'msg' => "#OMCSJ0005 Unable to insert data.",
                    );
                    return $array;
                }
            }
            $orders = $this->db->query($q)->result();
        }
        $query_pattadars = "select * from chitha_pattadar as cp where"
            . " cp.dist_code='$dist_code' and cp.subdiv_code='$subdiv_code' and cp.cir_code='$circle_code' and"
            . " cp.mouza_pargona_code='$mouza_code' and cp.lot_no='$lot_no' and cp.vill_townprt_code='$vill_code'  "
            . " and TRIM(cp.patta_no)='$patta_no' and cp.patta_type_code='$patta_type' and "
            . "  (lower(cp.jama_yn)!='y' or lower(cp.jama_yn)!='y')";

        $deleteQuery = "delete from jama_pattadar cp where "
            . " cp.dist_code='$dist_code' and cp.subdiv_code='$subdiv_code' and cp.cir_code='$circle_code' and"
            . " cp.mouza_pargona_code='$mouza_code' and cp.lot_no='$lot_no' and cp.vill_townprt_code='$vill_code'  "
            . " and TRIM(cp.patta_no)=trim('$patta_no') and cp.patta_type_code='$patta_type' and entry_mode='U' and pdar_id not in "
            . " (select pdar_id from chitha_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' "
            . " and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' "
            . " TRIM(patta_no)=trim('$patta_no') and patta_type_code='$patta_type' ) ";

        $pattadars = $this->db->query($query_pattadars)->result();
        foreach ($pattadars as $p) {
            $pflag = 0;
            $pdar_id = $p->pdar_id;
            $p->pdar_name = str_replace("'", "", $p->pdar_name);
            $p->pdar_father = str_replace("'", "", $p->pdar_father);
            $update_name_in_jama = "Update jama_pattadar set pdar_name='$p->pdar_name',pdar_father='$p->pdar_father' where dist_code='$p->dist_code' and subdiv_code='$p->subdiv_code' and 
            cir_code='$p->cir_code' and lot_no='$p->lot_no' and vill_townprt_code='$p->vill_townprt_code' and 
            mouza_pargona_code='$p->mouza_pargona_code' and TRIM(patta_no)=trim('$p->patta_no') and patta_type_code='$p->patta_type_code' and pdar_id='$p->pdar_id' ";

            $this->db->query($update_name_in_jama);

            $count_q = "select count(*) as count from chitha_dag_pattadar where dist_code='$dist_code' and"
                . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
                . "  lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$d->patta_type_code' and "
                . " TRIM(patta_no)='$patta_no' and pdar_id=$pdar_id and p_flag='1'";

            $p_flagCount = $this->db->query($count_q)->row()->count;

            $count_dag_q = "select count(*) as count from chitha_dag_pattadar where dist_code='$dist_code' and"
                . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
                . "  lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$d->patta_type_code' and "
                . " TRIM(patta_no)='$patta_no' and pdar_id = $pdar_id";

            $count_dag_q;

            $dag_presentCount = $this->db->query($count_dag_q)->row()->count;


            $p->pdar_land_b = 0;
            $p->pdar_land_k = 0;
            $p->pdar_land_lc = 0;
            $p->pdar_land_g = 0;
            $p->pdar_land_kr = 0;

            if ($p_flagCount == $dag_presentCount) {
                $p->p_flag = '1';
            } else {
                $p->p_flag = '0';
            }

            $p->entry_date = $p->date_entry;
            $p->entry_mode = 'U';
            $p->pdar_id = $p->pdar_id;
            //$p->pdar_father=$p->pdar_father;
            unset($p->dag_por_b);
            unset($p->dag_por_k);
            unset($p->dag_por_lc);
            unset($p->dag_por_g);
            unset($p->dag_por_kr);
            unset($p->date_entry);
            unset($p->operation);
            unset($p->jama_yn);
            unset($p->pdar_guard_reln);
            unset($p->f1_case_no);
            unset($p->f2_case_no);
            unset($p->o1_case_no);
            unset($p->o2_case_no);
            unset($p->dag_no);
            $query = "select count(*) as count from jama_pattadar where dist_code='$p->dist_code' and subdiv_code='$p->subdiv_code' and 
            cir_code='$p->cir_code' and lot_no='$p->lot_no' and vill_townprt_code='$p->vill_townprt_code' and 
            mouza_pargona_code='$p->mouza_pargona_code' and TRIM(patta_no)=trim('$p->patta_no') and patta_type_code='$p->patta_type_code' and pdar_id='$p->pdar_id'";

            $pdar_id_query = "select max(cast (pdar_id as int)) as new_pdar_id from jama_pattadar where dist_code='$p->dist_code' and subdiv_code='$p->subdiv_code' and 
            cir_code='$p->cir_code' and lot_no='$p->lot_no' and vill_townprt_code='$p->vill_townprt_code' and 
            mouza_pargona_code='$p->mouza_pargona_code' and TRIM(patta_no)=trim('$p->patta_no') and patta_type_code='$p->patta_type_code' ";
            $pdar_id_new = $this->db->query($pdar_id_query)->row()->new_pdar_id;
            if ($pdar_id_new == null) {
                $pdar_id_new = 1;
            } else {
                $pdar_id_new += 1;
            }
            $count = $this->db->query($query)->row()->count;
            if ($count == 0) {
                $jama_pattadar = $this->db->insert('jama_pattadar', $p); //......................
                if ($jama_pattadar != 1) {
                    $this->db->trans_rollback();
                    log_message("error", " #OMCSJ0006 Unable to insert into jama_pattadar
                           district: " . $dist_code . ", patta no: " . $d->patta_no . " patta code " . $d->patta_type_code);
                    $array = array(
                        'error' => true,
                        'msg' => "#OMCSJ0006 Unable to insert data.",
                    );
                    return $array;
                }
            }
            $count++;
        }
        $query_pattadars_pflag = "select * from chitha_dag_pattadar as cp where"
            . " cp.dist_code='$dist_code' and cp.subdiv_code='$subdiv_code' and cp.cir_code='$circle_code' and"
            . " cp.mouza_pargona_code='$mouza_code' and cp.lot_no='$lot_no' and cp.vill_townprt_code='$vill_code'  "
            . " and TRIM(cp.patta_no)='$patta_no' and cp.patta_type_code='$patta_type' ";
        $toRemove = $this->db->query($query_pattadars_pflag)->result();
        foreach ($toRemove as $remove) {
            $this->db->query("update jama_pattadar cp set p_flag='$remove->p_flag' where "
                . " cp.dist_code='$dist_code' and cp.subdiv_code='$subdiv_code' and cp.cir_code='$circle_code' and"
                . " cp.mouza_pargona_code='$mouza_code' and cp.lot_no='$lot_no' and cp.vill_townprt_code='$vill_code'  "
                . " and TRIM(cp.patta_no)='$patta_no' and cp.patta_type_code='$patta_type' and pdar_id = '$remove->pdar_id' ");
        }

        // $update_chitha = "update chitha_basic set jama_yn='y' where " .
        //     " TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type'"
        //     . " and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
        //     . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'  "
        //     . "";

        $table = 'chitha_basic';

        $params = [
            'jama_yn' => 'y',
        ];

        $where = [
            'patta_no'           => trim($patta_no),         // TRIM in SQL → trim in PHP
            'patta_type_code'    => $patta_type,
            'dist_code'          => $dist_code,
            'subdiv_code'        => $subdiv_code,
            'cir_code'           => $circle_code,
            'mouza_pargona_code' => $mouza_code,
            'lot_no'             => $lot_no,
            'vill_townprt_code'  => $vill_code,
        ];

        // Call your model update method
        $result3 = $this->Chitha_basic_model->update_table($table, $params, $where);


        // $this->db->query($update_chitha); //..............................
        if ($result3 <= 0) {
            $this->db->trans_rollback();
            log_message("error", " #OMCSJ0007 Unable to update into chitha_basic
                           district: " . $dist_code . ", patta no: " . $d->patta_no . " patta code " . $d->patta_type_code);
            $array = array(
                'error' => true,
                'msg' => "#OMCSJ0007 Unable to update data.",
            );
            return $array;
        }
        // $update_pattadar = "update chitha_pattadar set jama_yn='y' where " .
        //     " TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type'"
        //     . " and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
        //     . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'  "
        //     . "";
        // $this->db->query($update_pattadar); //..............................
        $table = 'chitha_pattadar';
        $params = [
            'jama_yn' => 'y',
        ];

        $where = [
            'patta_no'           => trim($patta_no), // equivalent to TRIM(patta_no) in SQL
            'patta_type_code'    => $patta_type,
            'dist_code'          => $dist_code,
            'subdiv_code'        => $subdiv_code,
            'cir_code'           => $circle_code,
            'mouza_pargona_code' => $mouza_code,
            'lot_no'             => $lot_no,
            'vill_townprt_code'  => $vill_code,
        ];

        // Call the update method
        $chitha_pattadar = $this->Chitha_basic_model->update_table($table, $params, $where);

        if ($chitha_pattadar <= 0) {
            $this->db->trans_rollback();
            log_message("error", " #OMCSJ0008 Unable to update into chitha_pattadar
                           district: " . $dist_code . ", patta no: " . $d->patta_no . " patta code " . $d->patta_type_code);
            $array = array(
                'error' => true,
                'msg' => "#OMCSJ0008 Unable to update data.",
            );
            return $array;
        }

        // $update_dag_pattadar = "update chitha_dag_pattadar set jama_yn='y' where " .
        //     " TRIM(patta_no)='$patta_no' and patta_type_code='$patta_type'"
        //     . " and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
        //     . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'  "
        //     . "";
        // $this->db->query($update_dag_pattadar); //..............................
        $table = 'chitha_dag_pattadar';

        $params = [
            'jama_yn' => 'y',
        ];

        $where = [
            'patta_no'        => trim($patta_no),
            'patta_type_code' => $patta_type,
            'dist_code'       => $dist_code,
            'subdiv_code'     => $subdiv_code,
            'cir_code'        => $circle_code,
            'mouza_pargona_code' => $mouza_code,
            'lot_no'          => $lot_no,
            'vill_townprt_code' => $vill_code,
        ];

        $update_dag_pattadar  = $this->Chitha_basic_model->update_table($table, $params, $where);

        if ($update_dag_pattadar <= 0) {
            $this->db->trans_rollback();
            log_message("error", " #OMCSJ0009 Unable to update into chitha_dag_pattadar
                           district: " . $dist_code . ", patta no: " . $d->patta_no . " patta code " . $d->patta_type_code);
            $array = array(
                'error' => true,
                'msg' => "#OMCSJ0009 Unable to update data.",
            );
            return $array;
        }
        $array = array(
            'error' => false,
            'msg' => "ok",
        );
        return $array;
    }

    public function getCol8Remark($patta_no, $district_code,
                                  $subdivision_code, $circlecode, $mouzacode,
                                  $lot_code, $village_code, $dag_no)
    {

        $data1[$dag_no] = array();
        $innerquery4 = "select col8order_cron_no,order_type_code,nature_trans_code,mut_land_area_b,mut_land_area_k,mut_land_area_lc,"
            . "ord.user_code,rajah_adalat,lm_code,case_no,co_ord_date,deed_reg_no,deed_value,deed_date,ord.operation,ord.co_code from "
            . "Chitha_col8_order ord,chitha_basic cb where ord.dist_code=cb.dist_code and ord.subdiv_code=cb.subdiv_code and "
            . "cb.cir_code=ord.cir_code and cb.mouza_pargona_code=ord.mouza_pargona_code and cb.lot_no=ord.lot_no and "
            . "cb.vill_townprt_code=ord.vill_townprt_code and cb.dag_no=ord.dag_no and TRIM(cb.patta_no)='$patta_no' and "
            . "ord.dist_code='$district_code' and ord.subdiv_code='$subdivision_code' and ord.cir_code='$circlecode' and "
            . "ord.mouza_pargona_code='$mouzacode' and  ord.lot_no='$lot_code' and ord.vill_townprt_code='$village_code' and "
            . "(ord.dag_no='$dag_no' or ord.new_dag_no='$dag_no') and (lower(ord.jama_updated)!='y' or ord.jama_updated is null)";
        $innerdata4 = $this->db->query($innerquery4)->result();

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
            $operation = $col8OrderDetails->operation;
            $co_code = $col8OrderDetails->co_code;

            $inplace_of_name = "";
            $inplaceof_alongwith = "";
            $occupant_name = "";
            $occupant_fmh_name = "";
            $occupant_fmh_flag = "";
            $new_patta_no = "";
            $new_dag_no = "";
            $old_dag = "";
            $hus_wife = "";
            $nature_trans_desc = "";
            $lm_name = "";
            $objection = "";
            $applicant = "";
            $innerquery5 = "select order_type from master_field_mut_type where order_type_code = '$order_type_code'";
            $innerdata5 = $this->db->query($innerquery5)->row();
            $ordertype = $innerdata5->order_type;
            $innerquery6 = "select inplace_of_name,inplaceof_alongwith from chitha_col8_inplace where dist_code='$district_code' and"
                . " subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and"
                . " lot_no='$lot_code' and vill_townprt_code='$village_code' and Dag_no='$dag_no' and Col8Order_cron_no='$col8order_cron_no'"
                . " ORDER BY inplace_of_id";
            $innerdata6 = $this->db->query($innerquery6)->result();
            $inplace_data = array();
            $innerquery7 = "select trans_desc_as from nature_trans_code where trans_code = '$nature_trans_code'";
            $nature_trans_desc = $this->db->query($innerquery7)->row()->trans_desc_as;
            foreach ($innerdata6 as $inplace) {
                $inplace_data[] = array(
                    'inplace_of_name' => $inplace->inplace_of_name,
                    'inplaceof_alongwith' => $inplace->inplaceof_alongwith,
                );
            }
            $occup_data = array();
            $innerquery8 = "select occupant_name,occupant_fmh_name,dag_no,occupant_fmh_flag,new_patta_no,new_dag_no,hus_wife from "
                . " chitha_col8_occup where dist_code='$district_code' "
                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
                . " and (dag_no='$dag_no' or new_dag_no='$dag_no') and Col8Order_cron_no='$col8order_cron_no' ORDER BY occupant_id";
            $innerdata8 = $this->db->query($innerquery8)->result();
            foreach ($innerdata8 as $occupant) {
                $occupant_name = $occupant->occupant_name;
                $occupant_fmh_name = $occupant->occupant_fmh_name;
                $occupant_fmh_flag = $occupant->occupant_fmh_flag;
                $new_patta_no = $occupant->new_patta_no;
                $new_dag_no = $occupant->new_dag_no;
                $old_dag = $occupant->dag_no;
                $hus_wife = $occupant->hus_wife;
                $innerquery9 = "select guard_rel_desc_as from master_guard_rel where guard_rel = '$occupant_fmh_flag'";
                $innerdata9 = $this->db->query($innerquery9)->result();
                $guard_rel_desc_as = "";
                foreach ($innerdata9 as $guard_rel) {
                    $guard_rel_desc_as = $guard_rel->guard_rel_desc_as;
                }
                $occup_data[] = array(
                    'occupant_name' => $occupant->occupant_name,
                    'occupant_fmh_name' => $occupant->occupant_fmh_name,
                    'occupant_fmh_flag' => $occupant->occupant_fmh_flag,
                    'new_patta_no' => $occupant->new_patta_no,
                    'new_dag_no' => $occupant->new_dag_no,
                    'old_dag' => $occupant->dag_no,
                    'hus_wife' => $occupant->hus_wife,
                    'guard_rel_desc_as' => $guard_rel_desc_as
                );
            }
            $innerquery10 = "select lm_name from lm_code  where dist_code='$district_code' "
                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code = '$lm_code' ";
            $innerdata10 = $this->db->query($innerquery10)->result();

            foreach ($innerdata10 as $lm) {
                $lm_name = $lm->lm_name;
            }
            $innerquery11 = "select username,status from users where dist_code='$district_code' "
                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code='$user_code'";
            $innerdata11 = $this->db->query($innerquery11)->result();
            foreach ($innerdata11 as $users) {
                $username = $users->username;
                $status = $users->status;
            }
            $innerquery12 = "select * from field_mut_objection where prev_fm_ca_no='$case_no' and obj_flag is not null and chitha_correct_yn='1' and jama_yn='0' ";
            $innerdata12 = $this->db->query($innerquery12)->result();
            $innerquery13 = "select * from field_mut_petitioner where case_no='$case_no' ";
            $innerdata13 = $this->db->query($innerquery13)->result();
            if ($order_type_code == '01') {
                $innerquery14 = " select deed_reg_no,deed_value,deed_date from chitha_col8_order
                      where Order_type_code='$order_type_code' and case_no='$case_no' ";
                $innerdata14 = $this->db->query($innerquery14)->result();
                foreach ($innerdata14 as $deedinf) {
                    $deed_reg_no = $deedinf->deed_reg_no;
                    $deed_value = $deedinf->deed_value;
                    $deed_date = $deedinf->deed_date;
                }
            }
            if ($order_type_code == '03') {
                $innerquery14 = "select * from field_mut_objection where objection_case_no='$case_no' and 
                obj_flag is not null and chitha_correct_yn='1' and jama_yn='0' ";
                $objection = $this->db->query($innerquery14)->result();
                foreach ($objection as $obj) {
                    $q = "select col8order_cron_no,dag_no from chitha_col8_order where case_no='$obj->prev_fm_ca_no' ";
                    $col8_cronNo = $this->db->query($q)->row();
                    $q = "select occupant_name from chitha_col8_occup where dist_code='$district_code' "
                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                        . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and 
                                col8order_cron_no='$col8_cronNo->col8order_cron_no' and dag_no='$col8_cronNo->dag_no'  ";
                    $result = $this->db->query($q)->result();
                    $fname = " ";
                    foreach ($result as $name) {
                        $fname = $fname . $name->occupant_name . ",";
                    }
                    $objection53[] = array(
                        'strikeoutObjection' => $fname,
                        'applicant' => $obj->obj_name,
                        'regist_date' => $obj->regist_date,
                        'submission_date' => $obj->submission_date,
                        'submission_date' => $obj->submission_date,
                        'case_no' => $obj->objection_case_no,
                        'prev_fm_ca_no' => $obj->prev_fm_ca_no,
                        'dag_no' => $obj->dag_no,
                    );
                }
            }

            $co_name = "select username from users where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code='$co_code'";
            $co_name = $this->db->query($co_name)->result();
            foreach ($co_name as $co) {
                $co_username = $co->username;
            }

            $data1[$dag_no]['col8'][] = array(
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
                'objection' => $objection53,
                'operation' => $operation,
                'co_name' => $co_username
            );
            $q = "update chitha_col8_order set jama_updated='y' where dist_code='$district_code' "
                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and"
                . " vill_townprt_code='$village_code' and (dag_no='$dag_no') and col8order_cron_no='$col8order_cron_no'";
            $this->db->query($q); //..............................
        }
        return $data1;
    }

    public function generate8Remark($dag_no, $chithainf)
    {
        $index = 1;
        $remAll = array();

        if (sizeof($chithainf[$dag_no]) > 0) {
            foreach ($chithainf[$dag_no]['col8'] as $clmn8) {
                //var_dump($clmn8);
                $remarkCreate = "";
                $co_order_date1 = $clmn8['co_ord_date'];
                $case_no = $clmn8['case_no'];
                $col8order_cron_no = $clmn8['col8order_cron_no'];
                $order_type = $clmn8['order_type'];
                $co_order_date = strtotime($co_order_date1);
                $formatDate = date("d/m/Y", $co_order_date);
                $order_type_code = $clmn8['order_type_code'];
                $nature_trans_code = $clmn8['nature_trans_code'];
                $mut_land_area_b = $clmn8['mut_land_area_b'];
                $mut_land_area_k = $clmn8['mut_land_area_k'];
                $mut_land_area_lc = $clmn8['mut_land_area_lc'];
                $remarkCreate = "চক্ৰ বিষয়াৰ <br>" . $formatDate . " তাৰিখৰ ";
                if ($order_type_code == "01") {
                    if ($mut_land_area_b != '0') {
                        $bigha = $mut_land_area_b . ' বিঘা ';
                    } else {
                        $bigha = "";
                    }
                    if ($mut_land_area_k != '0') {
                        $katha = $mut_land_area_k . ' কঠা ';
                    } else {
                        $katha = "";
                    }
                    if ($mut_land_area_lc != '0') {
                        $lesa = $mut_land_area_lc . ' লেছা ';
                    } else {
                        $lesa = "";
                    }
                } else if ($order_type_code == "02") {
                    if ($mut_land_area_b != '0') {
                        $bigha = $mut_land_area_b . ' বিঘা ';
                    } else {
                        $bigha = "";
                    }
                    if ($mut_land_area_k != '0') {
                        $katha = $mut_land_area_k . ' কঠা ';
                    } else {
                        $katha = "";
                    }
                    if ($mut_land_area_lc != '0') {
                        $lesa = $mut_land_area_lc . ' লেছা ';
                    } else {
                        $lesa = "";
                    }
                }
                //var_dump($clmn8['objection']);
                foreach ($clmn8['objection'] as $obj53) {
                    $strikeoutObjection = $obj53['strikeoutObjection'];
                    $applicant = $obj53['applicant'];
                    $dagNo = $obj53['dag_no'];
                    $reg_date = date('d/m/Y', strtotime($obj53['regist_date']));
                    $submission_date = date('d/m/Y', strtotime($obj53['submission_date']));
                    $oldcase_no = $obj53['prev_fm_ca_no'];
                }
                $remarkCreate .= $order_type . ' নং ' . $case_no . '-ৰ ' . ' হুকুমমৰ্মে ';
                if ($order_type_code != '03') {
                    $remarkCreate .= $clmn8['occup'][0]['old_dag'] . '  নং  দাগৰ ' . $bigha . $katha . $lesa . ' মাটি  ';
                }
                if ($order_type_code == "01") {
                    $remarkCreate .= " " . $this->utilityclass->getTransferType($clmn8['nature_trans_code']) . " ";
                }
                if ($order_type_code == "03") {
                    $remarkCreate .= $dagNo . ' নং  দাগৰ ' . $applicant . " য়ে দিয়া চিঠি অভিযোগ সাপেক্ষে  ";
                    $remarkCreate .= $oldcase_no . " নং " . date('d-m-y', strtotime($submission_date)) . " তাৰিখৰ হুকুম নাকচ কৰা হয় আৰু " . $strikeoutObjection . " নাম  কৰ্তন কৰা  হয়  । ";
                }
                foreach ($clmn8['inplace'] as $in) {
                    $remarkCreate .= $in['inplace_of_name'] . " ৰ ";
                    switch ($in['inplaceof_alongwith']) {
                        case 'i':
                            $remarkCreate .= " স্হলত ";
                            break;
                        case 'a':
                            $remarkCreate .= " লগত  ";
                            break;
                    }
                }
                $count = 0;
                $howmany = sizeof($clmn8['occup']) - 1;
                foreach ($clmn8['occup'] as $in) {
                    $r = "";
                    switch ($in['occupant_fmh_flag']) {
                        case 'm':
                            $r = " মাতৃ ";
                            break;
                        case 'f':
                            $r = " পিতৃ ";
                            break;
                        case 'h':
                            $r = " পতি ";
                            break;
                        case 'w':
                            $r = " পত্নী ";
                            break;
                        case 'a':
                            $r = " অধ্যক্ষ মাতা ";
                            break;
                        default:
                            $r = " অভিভাৱক ";
                    }
                    $remarkCreate .= $in['occupant_name'] . " ($r " . $in['occupant_fmh_name'] . ")";
                    if ($count < sizeof($clmn8['occup']) - 1) {
                        $remarkCreate .= " আৰু ";
                        $count++;
                    }
                }

                if ($clmn8['order_type_code'] == '01') {
                    $remarkCreate .= " নামত নামজাৰী কৰা হ’ল |<br>";
                } else if ($clmn8['order_type_code'] == '02') {
                    $remarkCreate .= " ৰ নামত " . $clmn8['occup'][0]['new_dag_no'] . " নং দাগ আৰু " . $clmn8['occup'][0]['new_patta_no'] . " নং ম্যাদী পট্টা  কৰা হল । <br>";
                }

                if (($clmn8['rajah'] != 0) || ($clmn8['rajah'] == 'y')) {
                    $remarkCreate .= "<p><span style='color:blue'>( ৰাজহ আদলত )</span></p>";
                }
                if ($clmn8['order_type_code'] != '03') {
                    $remarkCreate .= "Registration Deed No:" . $clmn8['deed_reg_no'] . "<br>";

                    $remarkCreate .= "Deed Value:" . $clmn8['deed_value'] . "<br>";

                    $interval = date_diff(date_create('01-01-1970'), date_create($clmn8['deed_date']));

                    if ($interval->days > 0)
                        $remarkCreate .= "Deed Date:" . date('d-m-y', strtotime($clmn8['deed_date'])) . ") ";

                    $remarkCreate .= "<p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u>($clmn8[lm_name])</p>";
                }
                $remarkCreate .= "<p><u class='text-danger'>চক্ৰ বিষয়া :</u>($clmn8[username])</p>";
                if ($clmn8['order_type_code'] == '01' and $clmn8['operation'] == 'B') {
                    $remarkCreate .= "লাঃ মঃৰ প্ৰতিবেদনৰ ভিত্তিত উপৰোক্ত বকেয়া নামজাৰী ও নথি সংশোধন অনুমোদন / নাকচ কৰা হ’ল ।  ";
                    $remarkCreate .= "<br><u class='text-danger'> চঃ বিঃ –  " . $clmn8['co_name'] . "</u>";
                } elseif ($clmn8['order_type_code'] == '02' and $clmn8['operation'] == 'B') {
                    $remarkCreate .= " ভূমিলেখ্য সহায়কৰ প্ৰতিবেদনৰ ভিত্তিত উপৰোক্ত আপোচ বাটোৱাৰা ও নথি সংশোধন কৰা হ’ল ।   ";
                    $remarkCreate .= "<br><u class='text-danger'> চঃ বিঃ –  " . $clmn8['co_name'] . "</u>";
                }
                $remAll[] = $remarkCreate;
            }
            //var_dump($remAll);
            //exit;
            return $remAll;
        }
    }

    public function getCol31($patta_no, $district_code,
                             $subdivision_code, $circlecode, $mouzacode,
                             $lot_code, $village_code, $dag_no)
    {
        $data[] = array();
        $innerquery26 = "select  dag_no,rmk_type_code,rmk_type_hist_no from chitha_rmk_gen where  "
            . "dist_code='$district_code' "
            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and"
            . " (dag_no ='$dag_no') and (lower(jama_updated)!='y' or jama_updated is null)  order by rmk_type_hist_no";

        $innerdata26 = $this->db->query($innerquery26)->result();

        foreach ($innerdata26 as $rmkGen) {
            $dagnoRemarkgen = $rmkGen->dag_no;
            $rmk_type_code = $rmkGen->rmk_type_code;
            $rmk_type_hist_no = $rmkGen->rmk_type_hist_no;

            //remark type 01 is for all office case হুকুম
            if ($rmk_type_code == "01") {
                $innerquery27 = " select dag_no,ord_date,ord_no,case_no,ord_passby_desig,lm_code,co_code,ord_type_code,"
                    . " ord_ref_let_no,co_ord_date,new_dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,user_code,operation  "
                    . " from chitha_rmk_ordbasic where  dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code'"
                    . " and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no' order by ord_cron_no ";

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
                    $ord_type_code = $chitharmk_ord_basic->ord_type_code;
                    $ord_ref_let_no = $chitharmk_ord_basic->ord_ref_let_no;
                    $co_ord_date = $chitharmk_ord_basic->co_ord_date;
                    $new_dag_no = $chitharmk_ord_basic->new_dag_no;
                    $m_dag_area_b = $chitharmk_ord_basic->m_dag_area_b;
                    $m_dag_area_k = $chitharmk_ord_basic->m_dag_area_k;
                    $m_dag_area_lc = $chitharmk_ord_basic->m_dag_area_lc;

                    $get_designation = $this->db->query("select user_desig_as as designation from master_user_designation "
                        . "where user_desig_code = '$ord_passby_desig'")->row()->designation;

                    //Order type 01 is for Conversion case(ম্যাদীকৰণ)
                    if ($ord_type_code == '01') {
                        $innerquery28 = " select patta_no,patta_type_code FROM chitha_rmk_convorder where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
                            . "and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and "
                            . "rmk_type_hist_no='$rmk_type_hist_no' ";

                        $innerdata28 = $this->db->query($innerquery28)->result();

                        $patta_no = "";
                        $patta_type_code = "";
                        $patta_type = "";
                        $premium = "";
                        $premi_chal_recpt_no = "";
                        $premi_chal_recpt = "";
                        $dag_no = "";
                        $new_patta_no = "";
                        $new_dag_no = "";
                        $ord_onbehalf_of = "";
                        $land_area_b = "";
                        $land_area_k = "";
                        $land_area_lc = "";
                        $username = "";
                        $lm_name = "";
                        $dag_no = "";
                        $new_patta_no = "";
                        $new_dag_no = "";
                        $ord_onbehalf_of = "";
                        $chalan_name = "";

                        foreach ($innerdata28 as $rmkconvorder) {
                            $patta_no = trim($rmkconvorder->patta_no);
                            $patta_type_code = $rmkconvorder->patta_type_code;

                            $innerquery29 = "select patta_type from patta_code where type_code=' $patta_type_code' ";
                            $innerdata29 = $this->db->query($innerquery29)->result();

                            foreach ($innerdata29 as $pattatype) {
                                $patta_type = $pattatype->patta_type;
                            }
                        }

                        if ($ord_type_code === '01') {
                            $innerquery30 = "select  distinct premium as premium,premi_chal_recpt_no "
                                . "FROM chitha_rmk_convorder where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and "
                                . "vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') "
                                . "and rmk_type_hist_no='$rmk_type_hist_no' and premium is not null"; // group by premi_chal_recpt_no";
                            //echo $innerquery30;
                        } else {
                            $innerquery30 = "select  distinct sum(premium) as premium,premi_chal_recpt_no "
                                . "FROM chitha_rmk_convorder where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and "
                                . "vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') "
                                . "and rmk_type_hist_no='$rmk_type_hist_no' and premium is not null group by premi_chal_recpt_no";
                        }
                        $innerdata30 = $this->db->query($innerquery30)->result();

                        foreach ($innerdata30 as $premiuminfo) {
                            $premium = $premiuminfo->premium;
                            $premi_chal_recpt_no = $premiuminfo->premi_chal_recpt_no;
                            //$premi_chal_recpt = $premiuminfo->premium;

                            $innerquery31 = "select chalan_name from premium_chalan_receipt where code='$premi_chal_recpt'";
                            $innerdata31 = $this->db->query($innerquery31)->result();

                            foreach ($innerdata31 as $premiumchalanrecpt) {
                                $chalan_name = $premiumchalanrecpt->chalan_name;
                            }
                        }

                        $innerquery32 = "select dag_no,new_patta_no,new_dag_no,ord_onbehalf_of FROM Chitha_rmk_Convorder where"
                            . " dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code'"
                            . " and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and "
                            . " rmk_type_hist_no='$rmk_type_hist_no'  ";

                        $innerdata32 = $this->db->query($innerquery32)->result();

                        $applicants = array();

                        foreach ($innerdata32 as $rmk_conv) {
                            $dag_no = $rmk_conv->dag_no;
                            $new_patta_no = $rmk_conv->new_patta_no;
                            $new_dag_no = $rmk_conv->new_dag_no;
                            $ord_onbehalf_of = $rmk_conv->ord_onbehalf_of;

                            if ($ord_type_code === '01') {
                                $innerquery33 = "select land_area_b as land_area_b,land_area_k as land_area_k,land_area_lc as "
                                    . "land_area_lc from chitha_rmk_convorder where dist_code='$district_code' "
                                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
                                    . "and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";
                            } else {
                                $innerquery33 = "select sum(land_area_b) as land_area_b,sum(land_area_k) as land_area_k,sum(land_area_lc) as "
                                    . "land_area_lc from chitha_rmk_convorder where dist_code='$district_code' "
                                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
                                    . "and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";
                            }
                            $innerdata33 = $this->db->query($innerquery33)->result();

                            foreach ($innerdata33 as $bklconvorder) {
                                $land_area_b = $bklconvorder->land_area_b;
                                $land_area_k = $bklconvorder->land_area_k;
                                $land_area_lc = $bklconvorder->land_area_lc;
                            }

                            $applicants[] = array(
                                'app_name' => $ord_onbehalf_of,
                                'dag_no' => $dag_no,
                                'new_dag_no' => $new_dag_no,
                                'new_patta_no' => $new_patta_no,
                            );
                        }

                        $innerquery34 = "select lm_name FROM lm_code where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";

                        $innerdata34 = $this->db->query($innerquery34)->result();

                        foreach ($innerdata34 as $lminfo) {
                            $lm_name = $lminfo->lm_name;
                        }

                        if (($ord_passby_desig == 'DC') || ($ord_passby_desig == 'ADC')) {
                            $innerquery35 = " select username,status FROM users where dist_code='$district_code' "
                                . " and subdiv_code='00' and cir_code='00' and user_code ='$co_code'";
                        } else {
                            $innerquery35 = " select username,status FROM users where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";
                        }
                        $innerdata35 = $this->db->query($innerquery35)->result();

                        foreach ($innerdata35 as $userinfo) {
                            $username = $userinfo->username;
                        }

                        $data[] = array(
                            'patta_no' => "$patta_no",
                            'patta_type_code' => "$patta_type_code",
                            'patta_type' => "$patta_type",
                            'premium' => "$premium",
                            'premi_chal_recpt_no' => "$premi_chal_recpt_no",
                            'premi_chal_recpt' => "$premi_chal_recpt",
                            'dag_no' => "$dag_no",
                            'new_patta_no' => "$new_patta_no",
                            'new_dag_no' => "$new_dag_no",
                            'ord_onbehalf_of' => $applicants,
                            'land_area_b' => "$land_area_b",
                            'land_area_k' => "$land_area_k",
                            'land_area_lc' => "$land_area_lc",
                            'username' => "$username",
                            'lm_name' => "$lm_name",
                            'dag_no' => "$dag_no",
                            'new_patta_no' => "$new_patta_no",
                            'new_dag_no' => "$new_dag_no",
                            'chalan_name' => "$chalan_name",
                            'remark_type_code' => $rmk_type_code,
                            'ord_type_code' => '01',
                            'ord_no' => $ord_no,
                            'case_no' => $case_no,
                            'order_date' => $order_date,
                            'co_code' => $co_code,
                            'ord_passby_desig' => $get_designation
                        );

                        $remove = "select dag_no as old_dag_no,patta_type_code as old_patta_type,patta_no as old_patta_no FROM chitha_rmk_convorder where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' 
                        and (dag_no ='$dag_no' or new_dag_no='$dag_no') and rmk_type_hist_no='$rmk_type_hist_no'";

                        $remove = $this->db->query($remove)->row();

                        // now delete the old from the jama_dag and jama_patta // removing the pattader needs to be checked again
                        $delete2 = "delete from jama_dag where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
                            . " and patta_type_code='$remove->old_patta_type' and TRIM(patta_no)=trim('$remove->old_patta_no') and dag_no='$remove->old_dag_no'";

                        $this->db->query($delete2); //***************************

                        $check = "select count(*) as c from jama_dag where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
                            . " and patta_type_code='$remove->old_patta_type' and TRIM(patta_no)=trim('$remove->old_patta_no')";
                        $check = $this->db->query($check)->row()->c;


                        if ($check == '0') {
                            $delete1 = "delete from jama_patta where dist_code='$district_code' "
                                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
                                . " and patta_type_code='$remove->old_patta_type' and TRIM(patta_no)=trim('$remove->old_patta_no')";

                            //$this->db->query($delete1); //***************************
                        }
                    }

                    //Order type 02 is for Allotment case(আবন্টন)
                    if ($ord_type_code == "02") {
                        $innerquery36 = "select ord_date,dag_no,ord_ref_let_no,allottee_name,allottee_land_code,allottee_land_b,allottee_land_k,allottee_land_lc from chitha_rmk_allottee  where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen' and new_dag_no='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";


                        $innerdata36 = $this->db->query($innerquery36)->result();

                        $ord_date = "";
                        $dag_no = "";
                        $ord_ref_let_no = "";
                        $allottee_name = "";
                        $allottee_land_code = "";
                        $allottee_land_b = "";
                        $allottee_land_k = "";
                        $allottee_land_lc = "";
                        $type = "";
                        $lm_name = "";
                        $status = "";

                        foreach ($innerdata36 as $allotee) {
                            $ord_date = $allotee->ord_date;
                            $dag_no = $allotee->dag_no;
                            $ord_ref_let_no = $allotee->ord_ref_let_no;
                            $allottee_name = $allotee->allottee_name;
                            $allottee_land_code = $allotee->allottee_land_code;
                            $allottee_land_b = $allotee->allottee_land_b;
                            $allottee_land_k = $allotee->allottee_land_k;
                            $allottee_land_lc = $allotee->allottee_land_lc;

                            $innerquery37 = "select  type from  ord_on_gl_type_code where type_code='$allottee_land_code'";
                            $innerdata37 = $this->db->query($innerquery37)->result();

                            foreach ($innerdata37 as $ord_on_typ) {
                                $type = $ord_on_typ->type;
                            }
                        }


                        $innerquery38 = "select lm_name FROM lm_code where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";

                        $innerdata38 = $this->db->query($innerquery38)->result();

                        foreach ($innerdata38 as $lminfo) {
                            $lm_name = $lminfo->lm_name;
                        }

                        $innerquery39 = " select username,status FROM users where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";

                        $innerdata39 = $this->db->query($innerquery39)->result();

                        foreach ($innerdata39 as $userinfo) {
                            $username = $userinfo->username;
                        }

                        $data[] = array(
                            'ord_date' => $ord_date,
                            'dag_no' => $dag_no,
                            'ord_ref_let_no' => $ord_ref_let_no,
                            'allottee_name' => $allottee_name,
                            'allottee_land_code' => $allottee_land_code,
                            'allottee_land_b' => $allottee_land_b,
                            'allottee_land_k' => $allottee_land_k,
                            'allottee_land_lc' => $allottee_land_lc,
                            'username' => $username,
                            'status' => $status,
                            'lm_name' => $lm_name
                        );
                    }

                    //Order type 03 is for Office Mutation case(নামজাৰী)
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
                        //var_dump($inplaceofarray);
                        $innerquery42 = "select by_right_of,infavor_of_corrected_name,infavor_of_name,reg_deal_no,reg_date,new_dag_no,"
                            . " new_patta_no  from chitha_rmk_infavor_of where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and "
                            . " vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' "
                            . " and rmk_type_hist_no='$rmk_type_hist_no'"
                            . " and ord_no= '$ord_no' ";

                        $innerdata42 = $this->db->query($innerquery42)->result();

                        $infav = array();

                        foreach ($innerdata42 as $infav_of) {
                            $by_right_of = $infav_of->by_right_of;
                            $infavor_of_corrected_name = $infav_of->infavor_of_corrected_name;
                            $infavor_of_name = $infav_of->infavor_of_name;
                            $reg_deal_no = $infav_of->reg_deal_no;
                            $reg_date = $infav_of->reg_date;
                            $new_dag_no = $infav_of->new_dag_no;
                            $new_patta_no = $infav_of->new_patta_no;

                            $infav[] = array(
                                'infavor_of_corrected_name' => $infav_of->infavor_of_corrected_name,
                                'infavor_of_name' => $infav_of->infavor_of_name
                            );
                        }
                        //var_dump($infav);
                        $innerquery43 = "select lm_name FROM lm_code where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";

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

                        $innerquery45 = "select m_dag_area_b,m_dag_area_k,m_dag_area_lc from chitha_rmk_ordbasic "
                            . " where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and ord_no='$ord_no'";

                        $m_area = $this->db->query($innerquery45)->row();

                        $m_area_b = $m_area->m_dag_area_b;
                        $m_area_k = $m_area->m_dag_area_k;
                        $m_area_lc = $m_area->m_dag_area_lc;

                        $co_name = "select username from users where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code='$user_code'";
                        $co_name = $this->db->query($co_name)->result();
                        foreach ($co_name as $co) {
                            $co_username = $co->username;
                        }

                        $data[] = array(
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
                        //var_dump($data);
                        //exit();
                    }

                    //Order type 04 is for Office Partition case(বাটোৱাৰা)
                    if ($ord_type_code == "04") {
                        $innerquery45 = "select by_right_of,dag_no,infavor_of_corrected_name,infavor_of_name,reg_deal_no,reg_date,new_dag_no,new_patta_no  from chitha_rmk_infavor_of where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no' and ord_no= '$ord_no' ";

                        $innerdata45 = $this->db->query($innerquery45)->result();

                        $by_right_of = "";
                        $infavor_of_corrected_name = "";
                        $infavor_of_name = "";
                        $reg_deal_no = "";
                        $reg_date = "";
                        $old_dag = "";
                        $new_dag_no = "";
                        $new_patta_no = "";

                        $infav = array();

                        foreach ($innerdata45 as $infav_of) {
                            $by_right_of = $infav_of->by_right_of;
                            $infavor_of_corrected_name = $infav_of->infavor_of_corrected_name;
                            $infavor_of_name = $infav_of->infavor_of_name;
                            $reg_deal_no = $infav_of->reg_deal_no;
                            $reg_date = $infav_of->reg_date;
                            $old_dag = $infav_of->dag_no;
                            $new_dag_no = $infav_of->new_dag_no;
                            $new_patta_no = $infav_of->new_patta_no;

                            $infav[] = array(
                                'infavor_of_corrected_name' => $infav_of->infavor_of_corrected_name,
                                'infavor_of_name' => $infav_of->infavor_of_name
                            );
                        }

                        $innerquery46 = "select lm_name FROM lm_code where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";

                        $innerdata46 = $this->db->query($innerquery46)->result();

                        $lm_name = "";

                        foreach ($innerdata46 as $lminfo) {
                            $lm_name = $lminfo->lm_name;
                        }

                        $innerquery47 = "select username,status FROM users where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";

                        $innerdata47 = $this->db->query($innerquery47)->result();

                        $username = "";
                        $status = "";

                        foreach ($innerdata47 as $userinfo) {
                            $username = $userinfo->username;
                            $status = $userinfo->status;
                        }

                        $data[] = array(
                            'by_right_of' => $by_right_of,
                            'infav' => $infav,
                            'reg_deal_no' => $reg_deal_no,
                            'reg_date' => $reg_date,
                            'new_dag_no' => $new_dag_no,
                            'new_patta_no' => $new_patta_no,
                            'old_dag' => $old_dag,
                            'username' => $username,
                            'status' => $status,
                            'lm_name' => $lm_name,
                            'remark_type_code' => $rmk_type_code,
                            'ord_type_code' => $ord_type_code,
                            'ord_no' => $ord_no,
                            'case_no' => $case_no,
                            'order_date' => $order_date,
                            'co_code' => $co_code,
                            'bigha' => $m_dag_area_b,
                            'katha' => $m_dag_area_k,
                            'lessa' => $m_dag_area_lc
                        );
                    }

                    //Order type 05 is for Other Party case(অন্যান্য)
                    if ($ord_type_code == "05") {
                        $innerquery48 = "select name_for,name_for_land_b,name_for_land_k,name_for_land_lc,case_type_code from chitha_rmk_other_opp_party where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen'  and rmk_type_hist_no='$rmk_type_hist_no'";

                        $name_for = "";
                        $name_for_land_b = "";
                        $name_for_land_k = "";
                        $name_for_land_lc = "";
                        $case_type_code = "";
                        $case_type_name = "";
                        $lm_name = "";
                        $username = "";
                        $status = "";

                        $innerdata48 = $this->db->query($innerquery48)->result();

                        foreach ($innerdata48 as $opp_party) {
                            $name_for = $opp_party->name_for;
                            $name_for_land_b = $opp_party->name_for_land_b;
                            $name_for_land_k = $opp_party->name_for_land_k;
                            $name_for_land_lc = $opp_party->name_for_land_lc;
                            $case_type_code = $opp_party->case_type_code;

                            $innerquery49 = "select case_type_name from case_type_code where case_type_code='$case_type_code'";

                            $innerdata49 = $this->db->query($innerquery49)->result();

                            foreach ($innerdata49 as $casename) {
                                $case_type_name = $casename->case_type_name;
                            }
                        }

                        $innerquery50 = "select lm_name FROM lm_code where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";

                        $innerdata50 = $this->db->query($innerquery50)->result();

                        foreach ($innerdata50 as $lminfo) {
                            $lm_name = $lminfo->lm_name;
                        }

                        $innerquery51 = " select username,status FROM users where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";

                        $innerdata51 = $this->db->query($innerquery51)->result();

                        foreach ($innerdata51 as $userinfo) {
                            $username = $userinfo->username;
                            $status = $userinfo->status;
                        }

                        $data[] = array(
                            'name_for' => $name_for,
                            'name_for_land_b' => $name_for_land_b,
                            'name_for_land_k' => $name_for_land_k,
                            'name_for_land_lc' => $name_for_land_lc,
                            'case_type_code' => $case_type_code,
                            'case_type_name' => $case_type_name,
                            'username' => $username,
                            'status' => $status,
                            'lmname' => $lm_name,
                            'remark_type_code' => $rmk_type_code,
                            'order_type_code' => $ord_type_code,
                        );
                    }

                    //Order type 06 is for Name Correction case(নাম সংশোধন)
                    if ($ord_type_code == "06") {
                        $innerdata52 = "";
                        $by_right_of = "";
                        $infavor_of_corrected_name = "";
                        $infavor_of_name = "";
                        $reg_deal_no = "";
                        $reg_date = "";
                        $dag_no = "";
                        $new_patta_no = "";
                        $innerquery52 = "select by_right_of,infavor_of_corrected_name,infavor_of_name,reg_deal_no,reg_date,new_dag_no,new_patta_no,ord_date,ord_no,user_code,dag_no  from chitha_rmk_infavor_of where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no' and ord_no= '$ord_no' ";

                        $innerdata52 = $this->db->query($innerquery52)->result();


                        foreach ($innerdata52 as $infav_of) {
                            $by_right_of = $infav_of->by_right_of;
                            $infavor_of_corrected_name = $infav_of->infavor_of_corrected_name;
                            $infavor_of_name = $infav_of->infavor_of_name;
                            $reg_deal_no = $infav_of->reg_deal_no;
                            $reg_date = $infav_of->reg_date;
                            $order_type_code = $infav_of->by_right_of;
                            $dag_no = $infav_of->dag_no;
                            $new_patta_no = $infav_of->new_patta_no;
                            $ord_date = $infav_of->ord_date;
                            $ord_no = $infav_of->ord_no;
                            $co_code = $infav_of->user_code;
                        } //infav query bracket

                        $innerquery54 = "select username,status FROM users where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";

                        $innerdata54 = $this->db->query($innerquery54)->result();

                        $username = "";
                        $status = "";

                        foreach ($innerdata54 as $userinfo) {
                            $username = $userinfo->username;
                            $status = $userinfo->status;
                        }

                        $data[] = array(
                            'by_right_of' => $by_right_of,
                            'infavor_of_corrected_name' => $infavor_of_corrected_name,
                            'infavor_of_name' => $infavor_of_name,
                            'reg_deal_no' => $reg_deal_no,
                            'reg_date' => $reg_date,
                            'dag_no' => $dag_no,
                            'new_patta_no' => $new_patta_no,
                            'username' => $username,
                            'status' => $status,
                            'remark_type_code' => $rmk_type_code,
                            'ord_type_code' => $ord_type_code,
                            'order_date' => $ord_date,
                            'ord_no' => $ord_no,
                        );
                        //var_dump($data);
                        //exit;
                        $q = "update chitha_rmk_gen set jama_updated ='y' where  "
                            . "dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and"
                            . " (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no' ";

                        //$this->db->query($q);
                    }

                    //Order type 07 is for Name Cancellation case(নাম কৰ্ত্তন)
                    if ($ord_type_code == "07") {
                        $innerquery55 = "select * from chitha_rmk_infavor_of where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' and ord_no= '$ord_no' ";

                        $innerdata55 = $this->db->query($innerquery55)->result();

                        $infavor_of_name = "";
                        $name_delete = '';
                        $dag_no = "";

                        foreach ($innerdata55 as $infav_of) {
                            $infavor_of_name = $infav_of->infavor_of_name;
                            $co_code = $infav_of->user_code;
                            $ord_date = $infav_of->ord_date;
                            $dag_no = $infav_of->dag_no;
                        } //infav query bracket

                        $ordparty = "Select name_for from chitha_rmk_other_opp_party where  dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' " .
                            " and (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  and ord_no= '$ord_no' ";

                        $innerdata59 = $this->db->query($ordparty)->result();

                        foreach ($innerdata59 as $ordparty) {
                            $name_delete = $ordparty->name_for;
                        } //infav query bracket

                        $innerquery53 = "select lm_name FROM LM_code where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                            . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code'  ";

                        $innerdata53 = $this->db->query($innerquery53)->result();

                        $lm_name = "";

                        foreach ($innerdata53 as $lminfo) {
                            $lm_name = $lminfo->lm_name;
                        }

                        $innerquery54 = "select username,status FROM users where dist_code='$district_code' "
                            . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";

                        $innerdata54 = $this->db->query($innerquery54)->result();

                        $username = "";
                        $status = "";

                        foreach ($innerdata54 as $userinfo) {
                            $username = $userinfo->username;
                            $status = $userinfo->status;
                        }

                        $data[] = array(
                            'order_no' => $ord_no,
                            'name_delete' => $name_delete,
                            'infavor_of_name' => $infavor_of_name,
                            'username' => $username,
                            'dag_no' => $dag_no,
                            'status' => $status,
                            'lmname' => $lm_name,
                            'remark_type_code' => $rmk_type_code,
                            'ord_type_code' => $ord_type_code,
                            'username' => $username,
                            'orderdate' => $ord_date
                        );
                    }
                }
            }

            //remark type 02 is for মণ্ডলৰ টোকা
            if ($rmk_type_code == '02') {
                $innerquery56 = "select  lm_note,lm_note_date,lm_code FROM chitha_rmk_lmnote where dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                    . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' ORDER BY LM_note_cron_no  ";

                $innerdata56 = $this->db->query($innerquery56)->result();

                foreach ($innerdata as $lmnote) {
                    $lm_note = $lmnote->lm_note;
                    $lm_note_date = $lmnote->lm_note_date;
                    $lm_code = $lmnote->lm_code;
                }
            }

            //remark type 03 is for কাননগুহৰ টোকা
            if ($rmk_type_code == '03') {
                $innerquery57 = "SELECT sk_note,sk_note_date FROM chitha_rmk_sknote where  dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                    . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' ORDER BY SK_note_cron_no ";

                $innerdata57 = $this->db->query($innerquery57)->result();

                foreach ($innerdata57 as $sknoteinf) {
                    $sk_note = $sknoteinf->sk_note;
                    $sk_note_date = $sknoteinf->sk_note_date;
                }
            }

            //remark type 04 is for বেদখলকাৰীৰ বিৱৰণ
            if ($rmk_type_code == '04') {
                $innerquery58 = "SELECT encro_evicted_yn,encro_name FROM chitha_rmk_encro where dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                    . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' ";

                $innerdata58 = $this->db->query($innerquery58)->result();

                foreach ($innerdata58 as $encro) {
                    $encro_evicted_yn = $encro->encro_evicted_yn;
                    $encro_name = $encro->encro_name;
                }
            }

            //remark type 08 is for land Reclassification
            if ($rmk_type_code == '08') {

                // $check = $this->db->query("SELECT count(*) as c FROM t_reclassification where dist_code='$district_code' "
                //                 . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                //                 . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and co_chitha_updated_yn = 'Y' and rkg_chitha_updated_yn = 'Y' ")->row()->c;

                // if ($check <= '0') {
                //     $innerquery59 = "SELECT * FROM chitha_rmk_reclassification where dist_code='$district_code' "
                //             . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                //             . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' ";
                // } else {
                //     $innerquery59 = "SELECT * FROM t_reclassification where dist_code='$district_code' "
                //             . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                //             . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' ";
                // }
                $innerquery59 = "SELECT * FROM chitha_rmk_reclassification where dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                    . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen'";

                $get_user_designation = "Select user_code as order_designation from chitha_rmk_gen where dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen'";

                $str = $this->db->query($get_user_designation)->row()->order_designation;

                $order_designation = preg_replace('#\d.*$#', '', $str);

                $get_designation_name = $this->db->query("Select user_desig_as as user_desig_as from master_user_designation where user_desig_code = '$order_designation'")->row()->user_desig_as;


                $innerdata59 = $this->db->query($innerquery59)->result();

                foreach ($innerdata59 as $encro) {
                    $reclass_case_no = $encro->case_no;
                    $present_land_class = $encro->present_land_class;
                    $proposed_land_class = $encro->proposed_land_class;
                    $dag = $encro->dag_no;
                    $patta = trim($encro->patta_no);
                    $orderpass = $encro->co_chitha_updated_date;
                    $present_land_class = $encro->present_land_class;
                }

                $data[] = array(
                    'reclass_case_no' => $reclass_case_no,
                    'present_land_class' => $present_land_class,
                    'proposed_land_class' => $proposed_land_class,
                    'remark_type_code' => $rmk_type_code,
                    'ord_type_code' => '00',
                    'dag_no' => $dag_no,
                    'patta_no' => $patta,
                    'date' => $orderpass,
                    'presentclass' => $present_land_class,
                    'order_passed_designation' => $get_designation_name,
                );
            }

            //remark type 10 is Allotments
            if ($rmk_type_code == '10') {
                $innerquery59 = "SELECT * FROM chitha_rmk_allottee where dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                    . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' ";

                $innerdata59 = $this->db->query($innerquery59)->result();

                $q = "Select lm_code,user_code as co_code from chitha_rmk_ordbasic WHERE dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                    . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' ";
                $lmco = $this->db->query($q)->row();

                $lm_name = $this->utilityclass->getDefinedMondalsName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $lmco->lm_code);
                $username = $this->utilityclass->getSelectedCOName($district_code, $subdivision_code, $circlecode, $lmco->co_code);

                foreach ($innerdata59 as $encro) {
                    $case_no = $encro->ord_no;
                    $ord_date = $encro->ord_date;
                    $patta_no = $encro->patta_no;
                    $old_dag = $encro->old_dag;
                    $dag_no = $encro->dag_no;
                    $rmk_type_hist_no = $encro->rmk_type_hist_no;
                    $b = $encro->allottee_land_b;
                    $k = $encro->allottee_land_k;
                    $lc = $encro->allottee_land_lc;
                    $doulyear = year_no;
                }

                $data[] = array(
                    'case_no' => $case_no,
                    'ord_date' => $ord_date,
                    'patta_no' => $patta_no,
                    'remark_type_code' => $rmk_type_code,
                    'ord_type_code' => '10',
                    'old_dag' => $old_dag,
                    'dag_no' => $dag_no,
                    'historyno' => $rmk_type_hist_no,
                    'bigha' => $b,
                    'katha' => $k,
                    'lesaa' => $lc,
                    'doulyear' => $doulyear,
                    'username' => $username->username,
                    'lm_name' => $lm_name->lm_name,
                );
            }

            // Modified on 19/06/2020 for settlement process

            if (($rmk_type_code == '11') or ($rmk_type_code == '12')) {
                $innerquery59 = "SELECT * FROM chitha_rmk_allottee where dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                    . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' ";

                $innerdata59 = $this->db->query($innerquery59)->result();

                $q = "Select lm_code,co_code,ord_no from chitha_rmk_ordbasic WHERE dist_code='$district_code' "
                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and "
                    . " lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' ";
                $lmco = $this->db->query($q)->row();

                $lm_name = $this->utilityclass->getDefinedMondalsName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $lmco->lm_code);
                $username = $this->utilityclass->getSelectedCOName($district_code, $subdivision_code, $circlecode, $lmco->co_code);

                $premiumquery = "select premium from allotment_pet_dag where case_no='$lmco->ord_no'";

                //echo "select premium from allotment_pet_dag where case_no='$lmco->ord_no'";

                $premiumdata = $this->db->query($premiumquery)->row();

                $premiumdata->premium;


                foreach ($innerdata59 as $encro) {
                    $case_no = $encro->ord_no;
                    $ord_date = $encro->ord_date;
                    $patta_no = $encro->patta_no;
                    $old_dag = $encro->old_dag;
                    $dag_no = $encro->dag_no;
                    $rmk_type_hist_no = $encro->rmk_type_hist_no;
                    $b = $encro->allottee_land_b;
                    $k = $encro->allottee_land_k;
                    $lc = $encro->allottee_land_lc;
                    $doulyear = $encro->doul_year;
                }


                $data[] = array(
                    'case_no' => $case_no,
                    'ord_date' => $ord_date,
                    'patta_no' => $patta_no,
                    'remark_type_code' => $rmk_type_code,
                    'ord_type_code' => '10',
                    'old_dag' => $old_dag,
                    'dag_no' => $dag_no,
                    'historyno' => $rmk_type_hist_no,
                    'bigha' => $b,
                    'katha' => $k,
                    'lesaa' => $lc,
                    'doulyear' => $doulyear,
                    'username' => $username->username,
                    'lm_name' => $lm_name->lm_name,
                    'premium' => $premiumdata->premium,
                );
            }


            // End Modified on 19/06/2020 for settlement process

            $q = "update chitha_rmk_gen set jama_updated ='y' where  "
                . "dist_code='$district_code' "
                . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
                . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and"
                . " (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no' ";

            $this->db->query($q); //..............................
        }
        //var_dump($data);
        return $data;
    }

    public function generateCol31Remark($dag_no, $q)
    {
        $count = 1;
        $remark31 = "";
        $order_count = 1;

        if (sizeof($q) > 1) {
            $r = $q[1];

            //remark type 01 is for all office case হুকুম   and Order type 03 is for Office Mutation case(নামজাৰী)
            if (($r['remark_type_code'] == '01') && ($r['ord_type_code'] == '03')) {

                $remark31 .= "<u class='text-danger'>হুকুম নং: " . $order_count++ . "<br></u>";

                $remark31 .= "চক্ৰ বিষয়া'ৰ ";
                $remark31 .= date('d-m-Y', strtotime($r['order_date'])) . " ";
                $order_type = $r['ord_type_code'] . " ";
                $remark31 .= $this->utilityclass->getOfficeMutType($order_type) . " নং  ";
                $remark31 .= $r['ord_no'] . " -ৰ হুকুমমৰ্মে   $dag_no  দাগৰ ";
                if ($r['by_right_of'] == '11') {
                    $remark31 .= " অংশৰ জমিত ";
                } else {
                    $remark31 .= $r['bigha'] . " বিঘা ";
                    $remark31 .= $r['katha'] . " কঠা ";
                    $remark31 .= $r['lessa'] . " লেছা মাটি ";
                }
                $remark31 .= $this->utilityclass->getTransferType($r['by_right_of']) . "  ";
                $count = 0;


                $howmany = sizeof($r['alongwith_name']) - 1;
                foreach ($r['alongwith_name'] as $al) {
                    $remark31 .= $al['alongwithname'];
                    if ($count < (sizeof($r['alongwith_name']) - 2)) {
                        $remark31 .= " , ";
                    } elseif ($count == (sizeof($r['alongwith_name']) - 2)) {
                        $count;
                        $remark31 .= " আৰু ";
                    } else {
                        $remark31 .= " ";
                    }
                    $count++;
                }
                if (sizeof($r['alongwith_name']) != '0') {
                    $remark31 .= " ৰ লগত ";
                }
                $count = 0;

                $howmany = sizeof($r['inplace_of_name']) - 1;
                if ($howmany >= 0) {
                    foreach ($r['inplace_of_name'] as $al) {
                        $remark31 .= $al['inplace_of_name'];
                        if ($count < sizeof($r['inplace_of_name']) - 1) {
                            $remark31 .= " আৰু ";
                            $count++;
                        }
                    }
                    $remark31 .= " ৰ  স্হলত ";
                }

                $count = 0;
                $howmany = sizeof($r['infav']) - 1;

                foreach ($r['infav'] as $in) {
                    $remark31 .= $in['infavor_of_name'];
                    if ($count < sizeof($r['infav']) - 1) {
                        $remark31 .= " আৰু ";
                        $count++;
                    }
                }
                if ($r['ord_type_code'] == '03') {
                    $remark31 .= " ৰ নামত নামজাৰী কৰা হ’ল | <br>";
                }
                $remark31 .= "<p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u>(" . $r['lm_name'] . ")</p>";
                $remark31 .= "<p><u class='text-danger'>চক্ৰ বিষয়া :</u>(" . $r['username'] . ")</p>";
                $remark31 .= "<p>Reg No (" . $r['reg_deal_no'] . ")</p>";
                if ($r['reg_date'] != "") {
                    $remark31 .= "Reg Date (" . $this->utilityclass->cassnum(date('d-m-Y', strtotime($r['reg_date']))) . ")";
                    //$remark31 .= "<p>Reg Date (" . date('d-m-Y', strtotime($r['reg_date'])) . ")</p>";
                }
                if ($r['operation'] == 'B') {
                    $remark31 .= "ভূমিলেখ্য সহায়কৰ প্ৰতিবেদনৰ ভিত্তিত উপৰোক্ত বকেয়া নামজাৰী ও নথি সংশোধন অনুমোদন / নাকচ কৰা হ’ল ।  ";
                    $remark31 .= "<br><u class='text-danger'> চঃ বিঃ –  " . $r['co_name'] . "</u>";
                }
                return $remark31;
            }

            //Order type 01 is for Conversion case(ম্যাদীকৰণ)
            if ($r['ord_type_code'] == '01') {
                $remark31 .= "<u class='text-danger'>হুকুম নং: " . $order_count++ . "</u><br>";
                $remark31 .= $r['ord_passby_desig'] . "'ৰ <br>";
                $remark31 .= $r['ord_no'] . "  নং  ";
                $order_type = $r['ord_type_code'] . " ";
                $remark31 .= $this->utilityclass->getOfficeMutType($order_type) . " গোচৰৰ  ";
                $remark31 .= date('d-m-Y', strtotime($r['order_date'])) . " তাৰিখৰ হুকুমমৰ্মে ";
                $remark31 .= $r['patta_no'] . " নং একচনা পট্টাৰ " . $r['dag_no'] . " নং দাগৰ  " . $r['premium'] . " টকা প্ৰিমিয়ামত ";
                $count = 0;
                $howmany = sizeof($r['ord_onbehalf_of']) - 1;
                foreach ($r['ord_onbehalf_of'] as $in) {
                    $remark31 .= $in['app_name'];
                    if ($count < sizeof($r['ord_onbehalf_of']) - 1) {
                        echo " আৰু ";
                        $count++;
                    }
                }
                $remark31 .= " 'ৰ পৰা আদায় হোৱাত ";
                $count = 0;
                $howmany = sizeof($r['ord_onbehalf_of']) - 1;
                foreach ($r['ord_onbehalf_of'] as $in) {
                    $remark31 .= $in['app_name'];
                    if ($count < sizeof($r['ord_onbehalf_of']) - 1) {
                        $remark31 .= " আৰু ";
                        $count++;
                    }
                }
                $remark31 .= " 'ৰ নামত ";
                if (($r['land_area_b'] != '0') || ($r['land_area_k'] != '0') || ($r['land_area_lc']) != '0') {
                    $remark31 .= $r['land_area_b'] . " বিঘা  " . $r['land_area_k'] . " কঠা  " . $r['land_area_lc'] . " লেছা " . "মাটি  পৃঠক ";
                } else {

                }

                $remark31 .= $r['new_patta_no'] . " নং পট্টা আৰু " . $r['new_dag_no'] . " নং দাগে ম্যাদীকৰণ কৰা হ'ল | <br>";
                $remark31 .= "<p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u> (" . $r['lm_name'] . " </p>";
                $remark31 .= "<p><u class='text-danger'>চক্ৰ বিষয়া :</u> (" . $r['username'] . "</p>";
                return $remark31;
            }

            //remark type 01 is for all office case হুকুম   and Order type 04 is for Office Partition case(বাটোৱাৰা)
            if (($r['remark_type_code'] == '01') && ($r['ord_type_code'] == '04')) {
                $remark31 .= "<u class='text-danger'>হুকুম নং: " . $order_count++ . "</u><br>";
                $remark31 .= "চক্ৰ বিষয়া'ৰ  <br>";
                $remark31 .= date('d-m-Y', strtotime($r['order_date']));
                $remark31 .= " তাৰিখৰ ";

                $order_type = $r['ord_type_code'] . " ";
                $this->utilityclass->getOfficeMutType($order_type) . " নং  ";

                $dag_no = $r['old_dag'];

                $remark31 .= $r['ord_no'] . " -ৰ হুকুমমৰ্মে  $dag_no দাগৰ ";
                $remark31 .= $r['bigha'] . " বিঘা ";
                $remark31 .= $r['katha'] . " কঠা ";
                $remark31 .= $r['lessa'] . " লেছা মাটি   ";

                $count = 0;

                $howmany = sizeof($r['infav']) - 1;
                foreach ($r['infav'] as $in) {
                    $remark31 .= $in['infavor_of_name'];
                    if ($count < sizeof($r['infav']) - 1) {
                        $remark31 .= " আৰু ";
                        $count++;
                    }
                }

                $remark31 .= " নামত " . $r['new_patta_no'] . " নং পট্টা আৰু " . $r['new_dag_no'] . " দাগ কৰা হল |";
                $remark31 .= "<p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u> (" . $r['lm_name'] . ")</p>";
                $remark31 .= "<p><u class='text-danger'>চক্ৰ বিষয়া :</u> (" . $r['username'] . ")</p>";
                if ($r['operation'] == 'B') {
                    $remark31 .= "ভূমিলেখ্য সহায়কৰ প্ৰতিবেদনৰ ভিত্তিত উপৰোক্ত বাটোৱাৰা ও নথি সংশোধন কৰা হ’ল ।  ";
                    $remark31 .= "<br><u class='text-danger'> চঃ বিঃ –  " . $r['co_name'] . "</u>";
                }
                return $remark31;
            }

            //remark type 08 is for land Reclassification
            if (($r['remark_type_code'] == '08') && ($r['ord_type_code'] == '00')) {

                $remark31 .= "<u class='text-danger'>হুকুম নং :</u><br>";
                $remark31 .= $r['reclass_case_no'];
                $remark31 .= " শ্রেণী সংশোধনীকৰণ প্রস্তাব  " . $r['order_passed_designation'] . " মহোদয়ে  " . $r['date'];
                $remark31 .= "  তাৰিখে দিয়া অনুমোদন মৰ্মে  " . $r['patta_no'];
                $remark31 .= "  নং পট্টাৰ  " . $r['dag_no'] . "  নং দাগৰ শ্রেণী  " . $this->utilityclass->getLandClassCode($r['presentclass']) . "'ৰ  পৰা  " . $this->utilityclass->getLandClassCode($r['proposed_land_class']);
                $remark31 .= "  লৈ পৰিবৰ্তন কৰা হ'ল । ";

                return $remark31;
            }

            //Order type 06 is for Name Correction case(নাম সংশোধন)
            if ($r['ord_type_code'] == '06') {
                $remark31 .= "<u class='text-danger'>হুকুম নং: " . $order_count++ . "</u><br>";
                $remark31 .= "চক্ৰ বিষয়া'ৰ  <br>";
                $remark31 .= date('d-m-Y', strtotime($r['order_date']));
                $remark31 .= " তাৰিখৰ ";

                $order_type = $r['ord_type_code'] . " ";

                $this->utilityclass->getOfficeMutType($order_type) . " নং  ";

                $remark31 .= $r['ord_no'] . " -ৰ হুকুম মৰ্মে " . $r['dag_no'] . " দাগৰ ";

                $count = 0;
                $remark31 .= $r['infavor_of_name'] . " ৰ  নাম   " . $r['infavor_of_corrected_name'] . "  কৰা হল |";
                $remark31 .= "<p><u class='text-danger'>চক্ৰ বিষয়া :</u> (" . $r['username'] . ")</p>";
                //echo $remark31;
                return $remark31;
            }

            //remark type 01 is for all office case হুকুম   and Order type 07 is for Name Cancellation case(নাম কৰ্ত্তন)
            if (($r['remark_type_code'] == '01') && ($r['ord_type_code'] == '07')) {

                $remark31 .= "<u class='text-danger'>হুকুম নং: " . $order_count++ . "</u><br>";
                $remark31 .= "চক্ৰ বিষয়া'ৰ  <br>";
                $remark31 .= date('d-m-Y', strtotime($r['orderdate']));
                $remark31 .= " তাৰিখৰ ";

                $order_type = $r['ord_type_code'] . " ";

                $this->utilityclass->getOfficeMutType($order_type) . " নং  ";

                $remark31 .= $r['order_no'] . " -ৰ হুকুম মৰ্মে  " . $r['dag_no'] . "  দাগৰ পটাদাৰ ";
                $count = 0;
                $remark31 .= $r['infavor_of_name'] . "  ৰ আবেদন মৰ্মে পটাদাৰ   " . $r['name_delete'] . " ৰ নাম কৰ্তন কৰা হল |";
                $remark31 .= "<p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u> (" . $r['lmname'] . ")</p>";
                $remark31 .= "<p><u class='text-danger'>চক্ৰ বিষয়া :</u> (" . $r['username'] . ")</p>";

                return $remark31;
            }

            //remark type 10 is Allotments
            if (($r['remark_type_code'] == '10') and ($r['ord_type_code'] == '10')) {
                $remark31 .= "<u class='text-danger'>হুকুম নং :</u>" . $r['historyno'] . "<br>";
                $remark31 .= "উপায়ুক্ত মহোদয়ৰ  ";
                $remark31 .= $r['case_no'];
                $remark31 .= " নং আৱন্টন বন্দৱস্তী গোচৰৰ  " . date('d-m-Y', strtotime($r['ord_date']));
                $remark31 .= " ইং তাৰিখৰ হুকুম মতে চৰকাৰী  " . $r['old_dag'] . "নং দাগৰ " . $r[bigha] . " বিঘা " . $r[katha] . " কঠা  " . $r[lesaa] . "  লেছা মাটিৰ " . $r[dag_no] . " নং দাগ আৰু " . $r[patta_no] . " নং নতুন  ম্যাদী পট্টা ভূক্ত কৰা হল । " . $r[doulyear] . " চনত দৌল ভূক্ত হব । ";
                $remark31 .= " ২০১৯ চনৰ নতুন ভূমিনিতিৰ ১৪.১৩ নং দফা অনুসৰি নতুনকৈ পট্টন হোৱা এই জমী পট্টনৰ তাৰিখৰ পৰা ১৫ বছৰলৈ হস্তান্তৰ কৰিব নোৱাৰিব । ";
                $remark31 .= "<p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u> (" . $r['lm_name'] . ")</p>";
                $remark31 .= "<p><u class='text-danger'>চক্ৰ বিষয়া :</u> (" . $r['username'] . ")</p>";
                return $remark31;
            }

            // Modified on 19/06/2020 STPP

            if (($r['remark_type_code'] == '11') and ($r['ord_type_code'] == '10')) {

                $case_no = $r['case_no'];


                $allotment_certificate123 = $this->db->query("Select * from allotment_doc_details where case_no='$case_no'")->row();
                //var_dump($allotment_certificate123);

                $dag_details = $this->db->query("Select * from allotment_pet_dag where case_no='$case_no'")->row();


                $q = "Select * from allotment_petitioner where case_no='$case_no' ";

                $applicant = $this->db->query($q)->row();


                $remark31 .= "<u class='text-danger'>হুকুম নং :</u>" . $r['historyno'] . "<br>";
                $remark31 .= "অসম চৰকাৰৰ  " . date('d/m/Y', strtotime($allotment_certificate123->govt_date_of_issue)) . "ইং তাৰিখৰ" . $allotment_certificate123->govtcertificate_no . "নং চিঠি আৰু কামৰূপ জিলাৰ উপায়ুক্ত মহোদয়ৰ" . date('d/m/Y', strtotime($allotment_certificate123->date_of_issue)) . " ইং তাৰিখৰ" . $allotment_certificate123->certficate_no . "নং চিঠিৰ অনুমোদন ক্ৰমে ও চক্ৰ বিষয়া মহোদয়ৰ" . date("d/m/Y") . " ইং তাৰিখৰ" . $case_no . "  নং গোচৰৰ নিদেৰ্শ মৰ্মে" . $dag_details->dag_no . " নং দাগৰ জমিৰ " . $dag_details->alot_area_b . " বিঘা" . $dag_details->alot_area_k . "কঠা" . $dag_details->alot_area_lc . " লেছা  মাটি " . $dag_details->premium . "টকা প্ৰিমিয়াম আদায় ক্রমে" . $applicant->alotee_name . "পিতা" . $applicant->alotee_gurdian . "নামত  নতুন" . $r[dag_no] . "নং দাগ আৰু নতুন" . $r[patta_no] . "নং খেৰাজ ম্যাদী পট্টা ভুক্ত কৰা হল।";


                return $remark31;


                //$case_no=$r['case_no'];


                //$premium123 ="select premium from allotment_pet_dag where case_no='$case_no'"
                //$premiumdata= $this->db->query($premium123)->row->premium;


                /*  $innerquery5911 = "select ord_no FROM chitha_rmk_allottee where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                  . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$d->dag_no' ";


                $innerdata5911 = $this->db->query($innerquery5911)->row(); */

                /*    $qcomment = "Select lm_comment from allotment_lm_note where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                      . " circle_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and"
                      . " vill_townprt_code='$vill_code' and case_no='$innerdata5911->ord_no' ";






                 $innerdatacomment = $this->db->query($qcomment)->row();

                   $comment= $innerdatacomment->lm_comment; */


                /*  $remark31 .= "<u class='text-danger'>হুকুম নং :</u>" . $r['historyno'] . "<br>";
                  $remark31 .= "উপায়ুক্ত মহোদয়ৰ  ";
                  $remark31 .= $r['case_no'];
                  $remark31 .= " নং আৱন্টন বন্দৱস্তী গোচৰৰ  " . date('d-m-Y', strtotime($r['ord_date']));
                  $remark31 .= " ইং তাৰিখৰ হুকুম মতে চৰকাৰী  " . $r['old_dag'] . "নং দাগৰ " . $r[bigha] . " বিঘা " . $r[katha] . " কঠা  " . $r[lesaa] . "  লেছা মাটিৰ ".$r[premium]."  টকা প্ৰিমিয়াম আদায় ক্রমে  ". $r[dag_no] . "   নং দাগ আৰু  " . $r[patta_no] . "  নং নতুন  ম্যাদী পট্টা ভূক্ত কৰা হল । " . $r[doulyear] . " চনত দৌল ভূক্ত হব । ";
                  $remark31 .= "<p><u class='text-danger'>লাট মণ্ডল:</u> (" . $r['lm_name'] . ")</p>";
                  $remark31 .= "<p><u class='text-danger'>চক্ৰ বিষয়া :</u> (" . $r['username'] . ")</p>";
                  //$remark31 .= $comment;
                  return $remark31; */
            }


            if (($r['remark_type_code'] == '12') and ($r['ord_type_code'] == '10')) {


                /*   $innerquery5911 = "select ord_no FROM chitha_rmk_allottee where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and"
                   . " mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$d->dag_no' ";


                 $innerdata5911 = $this->db->query($innerquery5911)->row(); */

                /*  $qcomment = "Select lm_comment from allotment_lm_note where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                    . " circle_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and"
                    . " vill_townprt_code='$vill_code' and case_no='$innerdata5911->ord_no' ";






               $innerdatacomment = $this->db->query($qcomment)->row();

                 $comment= $innerdatacomment->lm_comment; */


                $remark31 .= "<u class='text-danger'>হুকুম নং :</u>" . $r['historyno'] . "<br>";
                $remark31 .= "উপায়ুক্ত মহোদয়ৰ  ";
                $remark31 .= $r['case_no'];
                $remark31 .= " নং আৱন্টন বন্দৱস্তী গোচৰৰ  " . date('d-m-Y', strtotime($r['ord_date']));
                $remark31 .= " ইং তাৰিখৰ হুকুম মতে চৰকাৰী  " . $r['old_dag'] . "নং দাগৰ " . $r[bigha] . " বিঘা " . $r[katha] . " কঠা  " . $r[lesaa] . "  লেছা মাটিৰ " . $r[premium] . "  টকা প্ৰিমিয়াম আদায় ক্রমে   " . $r[dag_no] . " নং দাগ আৰু " . $r[patta_no] . " নং নতুন  ম্যাদী পট্টা ভূক্ত কৰা হল । " . year_no . " চনত দৌল ভূক্ত হব । ";
                $remark31 .= " ২০১৯ চনৰ নতুন ভূমিনিতিৰ ১৪.১৩ নং দফা অনুসৰি নতুনকৈ পট্টন হোৱা এই জমিন পট্টনৰ তাৰিখৰ     পৰা ১৫ বছৰলৈ হস্তান্তৰ কৰিব নোৱাৰিব ।";
                $remark31 .= "<p><u class='text-danger'>ভূমিলেখ্য সহায়ক :</u> (" . $r['lm_name'] . ")</p>";
                $remark31 .= "<p><u class='text-danger'>চক্ৰ বিষয়া :</u> (" . $r['username'] . ")</p>";
                //$remark31 .= $comment;
                return $remark31;
            }


            // End


//            echo $remark31;
        }
    }

    ///end jamabandi update////

    public function savePartionCase($case_no,
                                    $dist_code, $subdiv_code, $cir_code,
                                    $mouza_pargona_code, $lot_no,
                                    $vill_townprt_code, $new_pattadar)
    {
        $sqlp1 = "select * from petition_basic where 
        case_no=? and dist_code=? and subdiv_code=? and 
        cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=?";
        $pb_p = $this->db->query($sqlp1, array($case_no,
            $dist_code, $subdiv_code, $cir_code,
            $mouza_pargona_code, $lot_no, $vill_townprt_code))->row();

        $user_code = $this->session->userdata('user_code');
        $year = year_no;
        $define_date = define_date;

        $sqlp2 = "select * from petition_dag_details where 
        case_no=? and petition_no=? and  dist_code=? and subdiv_code=? and 
        cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=?";
        $p_dags = $this->db->query($sqlp2, array($case_no, $pb_p->petition_no,
            $dist_code, $subdiv_code, $cir_code,
            $mouza_pargona_code, $lot_no, $vill_townprt_code))->result();

        $all_case_no = null;
        foreach ($p_dags as $dag_p) {
            $case_name_p = null;
            $petition_no_p = null;
            $petition_no_p = null;
            $case_name_p = $this->basundharamodel->genearteCaseName();
            $seq_pet=year_no.'00';
            //$petition_no_p = $this->basundharamodel->genearteOfficePetitionNo();
            $petition_no_p=$seq_pet.$this->rtpsmodel->genearteOfficePetitionNo();
            $case_no_p = $case_name_p . $petition_no_p . "/OPARTC";

            $all_case_no .= "#" . $case_no_p . ", ";

            $add_off_name = $user_code;
            $add_off_desig = 'CO';
            $petition_basic = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'year_no' => $pb_p->year_no,
                'petition_no' => $petition_no_p,
                'case_no' => $case_no_p,
                'submission_date' => date('Y-m-d G:i:s'),
                'mut_type' => '04',
                'add_off_name' => $add_off_name,
                'add_off_desig' => $add_off_desig,
                'supported_doc' => '',
                'complete_partition_yn' => 'Y', ////aniba ase
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'co_user_code' => $add_off_name,
                'noc_no' => $pb_p->noc_no,
                'noc_date' => $pb_p->noc_date,
                'comp_serv_yn' => 'Y',
                'status' => 'P',
                'deed_no'=> $pb_p->deed_no,
                'deed_value'=> $pb_p->deed_value,
                'deed_date'=> $pb_p->deed_date,
            );
            $pet_b_p = $this->db->insert("petition_basic", $petition_basic);

            if ($pet_b_p != 1) {
                $this->db->trans_rollback();
                log_message("error", " #OPART0001 Unable to save data into petition_basic
               district: " . $dist_code . ", petition_no: " . $petition_no_p);
                $array = array(
                    'error' => true,
                    'msg' => " #OPART0001 Unable to save data.",
                );
                return $array;
            }
            $sqlp3 = "SELECT dag_revenue FROM chitha_basic where 
            dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code =?
            and lot_no =? and vill_townprt_code =? and patta_no=? 
            and patta_type_code=? and dag_no=?";
            $chitha_data = $this->db->query($sqlp3, array($dist_code, $subdiv_code, $cir_code,
                $mouza_pargona_code, $lot_no, $vill_townprt_code,
                $dag_p->patta_no, $dag_p->patta_type_code, $dag_p->dag_no))->row();

            $dags_data = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'year_no' => $pb_p->year_no,
                'petition_no' => $petition_no_p,
                'm_dag_area_b' => $dag_p->m_dag_area_b,
                'm_dag_area_k' => $dag_p->m_dag_area_k,
                'm_dag_area_lc' => $dag_p->m_dag_area_lc,
                'm_dag_area_g' => '0',//$dag_p->m_dag_area_g,
                'm_dag_area_kr' => '0',
                'patta_no' => trim($dag_p->patta_no),
                'patta_type_code' => $dag_p->patta_type_code,
                'revenue' => '0',
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'dag_no' => $dag_p->dag_no,
                'case_no' => $case_no_p
            );
            $pet_d_d = $this->db->insert("petition_dag_details", $dags_data);
            if ($pet_d_d != 1) {
                $this->db->trans_rollback();
                log_message("error", " #OPART0002 Unable to save data into petition_dag_details
               district: " . $dist_code . ", petition_no: " . $petition_no_p);
                $array = array(
                    'error' => true,
                    'msg' => " #OPART0002 Unable to save data.",
                );
                return $array;
            }

            $cron_no = 1;
            foreach ($new_pattadar as $p) {
                $sqlp4 = "select c.* from chitha_pattadar c left join chitha_dag_pattadar cd
                on c.pdar_id=cd.pdar_id where c.dist_code=? and c.subdiv_code=? and 
                c.cir_code=? and c.mouza_pargona_code=? and c.lot_no=? and c.vill_townprt_code=?
                and c.patta_no=? and c.patta_type_code=? and c.pdar_id=? and cd.dist_code=? and
                cd.subdiv_code=? and 
                cd.cir_code=? and cd.mouza_pargona_code=? and cd.lot_no=? and cd.vill_townprt_code=?
                and cd.patta_no=? and cd.patta_type_code=? and cd.pdar_id=? and cd.dag_no=?";

                $pattadar_new = $this->db->query($sqlp4, array($dist_code, $subdiv_code, $cir_code,
                    $mouza_pargona_code, $lot_no, $vill_townprt_code,
                    $p->patta_no, $p->patta_type_code, $p->pdar_id, $dist_code, $subdiv_code, $cir_code,
                    $mouza_pargona_code, $lot_no, $vill_townprt_code,
                    $p->patta_no, $p->patta_type_code, $p->pdar_id, $p->dag_no));
                if ($pattadar_new->num_rows() != 1) {
                    $this->db->trans_rollback();
                    log_message("error", " #OPART0003 New Pattadar not found in chitha_pattadar
                            district: " . $dist_code . ", petition_no: " . $petition_no_p);
                    $array = array(
                        'error' => true,
                        'msg' => " #OPART0003 Unable to save data.",
                    );
                    return $array;
                }
                $new_pdar = $pattadar_new->row();

                $other_data = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'year_no' => $pb_p->year_no,
                    'petition_no' => $petition_no_p,
                    'dag_no' => $dag_p->dag_no,
                    'patta_no' => $dag_p->patta_no,
                    'patta_type_code' => $dag_p->patta_type_code,
                    'pdar_id' => $p->pdar_id,
                    'pdar_cron_no' => $cron_no++,
                    'pdar_name' => $new_pdar->pdar_name,
                    'pdar_guardian' => $new_pdar->pdar_father,
                    'pdar_rel_guar' => $new_pdar->pdar_guard_reln,
                    'pdar_add1' => $new_pdar->pdar_add1,
                    'pdar_add2' => $new_pdar->pdar_add2,
                    'pdar_strike' => 'N',
                    'user_code' => $user_code,
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'E',
                    'is_converted_pattadar' => 'N',
                    'pdar_gender' => $new_pdar->pdar_gender,
                    'pdar_mother' => $new_pdar->pdar_mother,
                    'pdar_aadharno' => $new_pdar->pdar_aadharno,
                    'pdar_mobile' => $new_pdar->pdar_mobile,
                    'pdar_nrcno' => $new_pdar->pdar_nrcno,
                    'case_no' => $case_no_p
                );
                $pet_p = $this->db->insert("petitioner_part", $other_data);
                if ($pet_p != 1) {
                    $this->db->trans_rollback();
                    log_message("error", " #OPART0004 Unable to save data into petitioner_part
               district: " . $dist_code . ", petition_no: " . $petition_no_p);
                    $array = array(
                        'error' => true,
                        'msg' => " #OPART0004 Unable to save data.",
                    );
                    return $array;
                }
            }

            /////composite_service
            $comp_array5 = [
                'case_no' => $case_no_p,
                'user_code' => $user_code,
                'status' => 'P',
                'remark' => 'Registered by CO',
                'entry_date' => date('Y-m-d'),
            ];
            $process = $this->processHandler($comp_array5);
            if ($process != 1) {
                $this->db->trans_rollback();
                log_message("error", " #OPART0007 Unable to save data into composite_service
               district: " . $dist_code . ", case no: " . $case_no_p);
                $array = array(
                    'error' => true,
                    'msg' => " #OPART0007 Unable to save data.",
                );
                return $array;
            }
        }

        $array = array(
            'error' => false,
            'msg' => "OK",
            'case_no' => $all_case_no,
        );
        return $array;
    }

    ////////Regenerate Notice////
    function compServiceOldNotice() {
        $user_desig_code = $this->session->userdata('user_desig_code');
        if(!in_array($user_desig_code, ['AST'])){
            show_error('You are not authorized to perform this action.');
        }
        $this->load->helper('html');
        $data['_view'] = 'CompositeService/CompServiceOldNotice';
        $this->load->view('layouts/main',$data);
    }

    function compServiceRegenerateNotice() {
        // XSS Validation START
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
        // XSS Validation END
        $user_desig_code = $this->session->userdata('user_desig_code');
        if(!in_array($user_desig_code, ['AST'])){
            $this->session->set_flashdata('message', 'You are not authorized to perform this action.');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $case_no = trim($_POST['case_no']);
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;

        $detailsQuery = "select * from petition_basic where 
        case_no =? and dist_code =? 
        and subdiv_code =? and cir_code =?
        and status!=? and comp_serv_yn=?";

        $data['details'] = $data['landsale']= null;
        $details = $this->db->query($detailsQuery, array($case_no, $dist_code,
            $subdiv_code, $cir_code,'F','Y'));
        if ($details->num_rows() > 0) {
            $data['details'] = $details->row();
            $sql10 = "select hearingdt,automut from landsale where 
                    appno=? and distcode=? and subcode=? and circode=?
                    and hearingdt is not null";
            $res10 = $this->db->query($sql10,array($data['details']->noc_no,$dist_code,
                $subdiv_code,$cir_code));
            if($res10->num_rows()>0)
            {
                $data['details']->next_date_of_hearing = $res10->row()->hearingdt;
                $data['landsale'] = $res10->row();
            }else{
                $this->session->set_flashdata('message', 'Case number not Found.');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }else{
            $this->session->set_flashdata('message', 'Case number not Found / Final order have been passed .');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $mouza_pargona_code = $data['details']->mouza_pargona_code;
        $lot_no = $data['details']->lot_no;
        $vill_townprt_code = $data['details']->vill_townprt_code;

        $data['dags'] = array();
        $dagQuery = "select * from petition_dag_details where 
        petition_no =? and dist_code =? 
        and subdiv_code =? and cir_code =?
        and mouza_pargona_code =? and lot_no =? "
            . "and vill_townprt_code =? and case_no =?";
        $dags = $this->db->query($dagQuery, array($details->row()->petition_no,
            $dist_code, $subdiv_code, $cir_code,
            $mouza_pargona_code, $lot_no, $vill_townprt_code, $case_no));
        if ($dags->num_rows() > 0) {
            $data['dags'] = $dags->result();
        }

        $data['applicants'] = array();
        $applicantQuery = "select * from petitioner where 
        petition_no =? and dist_code =? and subdiv_code =? 
        and cir_code =? and mouza_pargona_code =? and lot_no =? "
            . "and vill_townprt_code =? and case_no =?";
        $applicants = $this->db->query($applicantQuery, array($details->row()->petition_no,
            $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code,
            $lot_no, $vill_townprt_code, $case_no));
        if ($applicants->num_rows() > 0) {
            $data['applicants'] = $applicants->result();
        }

        $data['pattadars'] = array();
        $pattadarQuery = "select * from petition_pattadar where 
        petition_no =? and dist_code =? 
        and subdiv_code =? and cir_code =? and mouza_pargona_code =? 
        and lot_no =? and vill_townprt_code =? and case_no =?";
        $pattadars = $this->db->query($pattadarQuery, array($details->row()->petition_no,
            $dist_code, $subdiv_code, $cir_code,
            $mouza_pargona_code, $lot_no,
            $vill_townprt_code, $case_no));
        if ($pattadars->num_rows() > 0) {
            $data['pattadars'] = $pattadars->result();
        }

        $data['notifyname'] = array();
        $notifyPerson = "Select * from petition_notified where 
        petition_no =? and dist_code =? 
        and subdiv_code =? and cir_code =? and mouza_pargona_code =? 
        and lot_no =? and vill_townprt_code =?";
        $notifyResult = $this->db->query($notifyPerson, array($details->row()->petition_no,
            $dist_code, $subdiv_code, $cir_code,
            $mouza_pargona_code, $lot_no, $vill_townprt_code));
        if ($notifyResult->num_rows() > 0) {
            $data['notifyname'] = $notifyResult->result();
        }

        $data['case_no'] = $case_no;
        if(in_array($dist_code, json_decode(BARAK_VALLEY))){
            $data['_view'] = 'CompositeService/issueNotice_kar';
        }
        else
        {
            $data['_view'] = 'CompositeService/issueNotice';
        }
        
        $this->load->view('layouts/main', $data);
    }

    /////case search
    function compServiceCaseSearch() {
        $this->load->helper('html');
        $data['_view'] = 'CompositeService/CompServiceCaseSearch';
        $this->load->view('layouts/main',$data);
    }

    function compServiceCaseView()
    {
        $case_no = trim($_POST['case_no']);
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        if($_POST['type'] == 'C')
        {
            $sql1 = "Select * from petition_basic where 
                case_no=? and dist_code=? and subdiv_code=? and cir_code=?
                and comp_serv_yn =? and mut_type=?";
            $res1 = $this->db->query($sql1,
                array($case_no,$dist_code,$subdiv_code,
                    $cir_code,'Y','03'));

            if($res1->num_rows()<=0)
            {
                $this->session->set_flashdata('message', 'Case number not Found.');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }elseif($_POST['type'] == 'D'){
            $sql1 = "Select * from petition_basic where 
                deed_no=? and dist_code=? and subdiv_code=? and cir_code=?
                and comp_serv_yn =? and mut_type=?";
            $res1 = $this->db->query($sql1,
                array($case_no,$dist_code,$subdiv_code,
                    $cir_code,'Y','03'));

            if($res1->num_rows()<=0)
            {
                $this->session->set_flashdata('message', 'Deed number not Found.');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }elseif($_POST['type'] == 'N'){
            $sql1 = "Select * from petition_basic where 
                noc_no=? and dist_code=? and subdiv_code=? and cir_code=?
                and comp_serv_yn =? and mut_type=?";
            $res1 = $this->db->query($sql1,
                array($case_no,$dist_code,$subdiv_code,
                    $cir_code,'Y','03'));

            if($res1->num_rows()<=0)
            {
                $this->session->set_flashdata('message', 'NOC number not Found.');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }

        $data['pb'] = $res1->row();
        $sql2 = "Select * from petition_basic where 
                noc_no=? and dist_code=? and subdiv_code=? and cir_code=?
                and comp_serv_yn =? and mut_type=?";
        $res2 = $this->db->query($sql2,
            array($data['pb']->noc_no,$dist_code,$subdiv_code,
                $cir_code,'Y','04'));

        $data['part_cases'] = array();
        if($res2->num_rows()>0)
        {
            $data['part_cases'] = $res2->result();
        }

        $data['hold_reason'] = null;
        $data['rejected_reason'] = null;
        if ($data['pb']->status == 'H') {
            $sql8 = $this->db->query("select remark from composite_service where 
                        case_no=? and status=? ORDER BY id desc", array($data['pb']->case_no, 'H'));
            if ($sql8->num_rows() > 0) {
                $data['hold_reason'] = $sql8->row()->remark;
            }
        } elseif($data['pb']->status == 'D') {
            $sql8 = $this->db->query("select remark from composite_service where 
                        case_no=? and status=? ORDER BY id desc", array($data['pb']->case_no, 'D'));
            if ($sql8->num_rows() > 0) {
                $data['rejected_reason'] = $sql8->row()->remark;
            }
        }

        $dates = $this->db->query("SELECT lm_code, lm_sign_yn, sk_sign_yn,sk_note_date,
            lm_sign_date, lm_code FROM 
            petition_lm_note WHERE dist_code=? and 
            subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? AND 
            petition_no = ?", array($dist_code,$subdiv_code,
            $cir_code,$data['pb']->mouza_pargona_code,
            $data['pb']->lot_no,$data['pb']->vill_townprt_code,
            $data['pb']->petition_no))->row();

        $data['sk_note_date'] = $dates->sk_note_date;
        $data['lm_note_date'] = $dates->lm_sign_date;
        $data['lm_sign_yn'] = $dates->lm_sign_yn;
        $data['sk_sign_yn'] = $dates->sk_sign_yn;
        $data['lm_code'] = $dates->lm_code;
        $data['user_code'] = 'NA';

        $sql20 = "select * from landsale where appno=? and distcode=? and 
            subcode=? and circode=? and compserv=?";
        $data['noc_case'] = $this->db->query($sql20, array($data['pb']->noc_no, $dist_code,
            $subdiv_code, $cir_code, 'Y'))->row();

        $this->load->helper('html');
        $data['_view'] = 'CompositeService/CompServiceCaseView';
        $this->load->view('layouts/main',$data);
    }

    //////////
    public function getPendingCasesCOFinal()
    {
        $user_desig_code = $this->session->userdata('user_desig_code');
        if(!in_array($user_desig_code, ['CO'])){
            show_error('You are not authorized to perform this action.');
        }
        $location = $this->utilityclass->getLocationfromSession();
        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];
        $sql = "select distinct on (noc_no) *,sn.nocno from petition_basic p left join sro_note sn on p.noc_no=sn.nocno and p.dist_code=sn.dist_code and p.subdiv_code=sn.subdiv_code and p.cir_code=sn.cir_code and p.mouza_pargona_code=sn.mouza_pargona_code and p.lot_no=sn.lot_no and p.vill_townprt_code=sn.vill_townprt_code where 
        p.dist_code=? and p.subdiv_code=? and p.cir_code=? and
        sn.nocno is not null and p.noc_no is not null and order_passed is null and co_chitha_corrected_yn is null
        and notice_served_yn=? and (p.status=? or p.status=?) 
        and add_off_name=? and comp_serv_yn=?";
        $res = $this->db->query($sql, array($dist_code, $subdiv_code, $cir_code,
            'Y', 'P', 'H', $this->session->userdata('user_code'),'Y'));
        $data['cases'] = array();
       //echo $this->db->last_query();

        if ($res->num_rows() > 0) {
            $data['cases'] = $res->result();

            foreach ($data['cases'] as $key => $r) {
                $data['cases'][$key]->lapsed = null;
                $datetime1 = new DateTime();
                $datetime2 = new DateTime(date('d-m-Y', strtotime($r->next_date_of_hearing)));
                $interval = $datetime1->diff($datetime2);
                $days = $interval->format('%R%a');
                if ($r->status == 'P' || $r->status == 'H') {
                    if ($days <= -1) {
                        $data['cases'][$key]->lapsed = abs($days);
                    }
                }
            }
        }
        $data['_view'] = 'CompositeService/PendingcasesForCO_final';
        $this->load->view('layouts/main', $data);
    }
function OmutCoProceedingFinal()
    {
        $db = $this->session->userdata('db');
        // $this->getDeedDetails();
        $this->load->model("PetitionBasic_Model");
        $location = $this->utilityclass->getLocationfromSession();
        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];
        $define_date = define_date;
        $user_code = $this->session->userdata("user_code");

        // if(in_array($dist_code,json_decode(NGDRS_DIST)))
        // {
            
	//    $srodata=$this->getNgdrsdeedLHAPI($dist_code,$subdiv_code,$cir_code);
        // }
        
        $this->base_query = "p.dist_code = '$dist_code' and p.subdiv_code = '$subdiv_code' and p.cir_code = '$cir_code' and add_off_name='$user_code' and comp_serv_yn='Y'";

        $clause = $this->base_query . " and p.noc_no is not null and sn.nocno is not null and l.boallowed!='Reject' and order_passed is null and co_chitha_corrected_yn is null and notice_served_yn='Y' and (p.status='P' or p.status='H')";
        $fetch_data = $this->PetitionBasic_Model->make_datatables_com_final($clause);
        // var_dump($fetch_data);
        // exit;

        $data = array();
        foreach ($fetch_data as $r) {
            $mouza_pargona_code = $this->utilityclass->getMouzaName($r->dist_code, $r->subdiv_code, $r->cir_code, $r->mouza_pargona_code);
            $lot_no = $this->utilityclass->getLotName($r->dist_code, $r->subdiv_code, $r->cir_code, $r->mouza_pargona_code, $r->lot_no);
            $vill_townprt_code = $this->utilityclass->getVillageName($r->dist_code, $r->subdiv_code, $r->cir_code, $r->mouza_pargona_code, $r->lot_no, $r->vill_townprt_code);

            $location = "Mouza : " . $mouza_pargona_code . "<br> Lot No.: " . $lot_no . "<br> Vill Name: " . $vill_townprt_code;

            $entry_date = "<p class='text-success'> <i class='fa fa-calendar'></i> " . date('M jS, Y', strtotime($r->date_entry)) . "</p>";

            $datetime1 = new DateTime();
            $datetime2 = new DateTime(date('d-m-Y', strtotime($r->next_date_of_hearing)));
            $interval = $datetime1->diff($datetime2);
            $days = $interval->format('%R%a');
            $status = '';
            if ($r->status == 'P' || $r->status == 'H') {
                if ($days <= -1) {
                    $status = "<p class=\"text-danger small regular blink_me\"><i class=\"fa fa-exclamation-circle\" aria-hidden=\"true\"></i>" . " Lapsed by " . abs($days) . " days ago" . "</p>";
                }
            }
            if ($r->status == 'H') {
                $status = $status. "<br><p class=\"small bold\"><i class=\"fa fa-stop-circle\" aria-hidden=\"true\"></i>" . " Auto Mutation Stoped by CO </p>";
            }

            $sql1 = "select date_of_deed from sro_note where 
                    nocno=? and dist_code=? and subdiv_code=? 
                    and cir_code=? and mouza_pargona_code=? and 
                    lot_no=? and vill_townprt_code=?";
            $res1 = $this->db->query($sql1,array($r->noc_no,$r->dist_code,
                $r->subdiv_code, $r->cir_code, $r->mouza_pargona_code,
                $r->lot_no, $r->vill_townprt_code));
            $deed_date = null;
            $mutation_date = null;
            if($res1->num_rows() > 0)
            {
                $deed_date = strtotime($res1->row()->date_of_deed);
                $deed_auto_mutation_date = date('d/m/Y', strtotime(AUTOMUTATION_DEED_PERIOD, $deed_date));
                $notice_generated_date = strtotime($r->notice_generated_date);
                $notice_auto_mutation_date = date('d/m/Y', strtotime(AUTOMUTATION_NOTICE_PERIOD,$notice_generated_date));

                $mutation_date = $deed_auto_mutation_date>$notice_auto_mutation_date?$deed_auto_mutation_date:$notice_auto_mutation_date;
            }

            $status = $status . "<p class='text-success'> <i class='fa fa-calendar'></i> Hearing Date : " . date('d/m/Y', strtotime($r->next_date_of_hearing)) . "</p>";
            if($deed_date == null)
            {
                $status = $status. "<p class=\"small bold\"><i class=\"fa fa-exclamation-circle\" aria-hidden=\"true\"></i>" . " Deed not found. </p>";
            }elseif($r->status == 'P') {
                $status = $status . "<p class='text-danger'> <i class='fa fa-calendar'></i> Auto Mutation Date : " . $mutation_date . "</p>";
            }

            if ($r->lm_note_yn == '' or $r->lm_note_yn == null) {
                $status = $status . "<p class='text-primary'> <i class='fa fa-exclamation-triangle red'></i> মন্ডলে প্ৰতিবেদন দিয়া নাই </p>";
            }
            if ($r->notice_generated_yn == '' or $r->notice_generated_yn == null) {
                $status = $status . "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> সহায়কৰ ঘোষনা জাৰী অপ্ৰাপ্ত</p>";
            }
            if ($r->sk_comment == '' or $r->sk_comment == null) {
                $status = $status . "<p class='text-info'> <i class='fa fa-exclamation-triangle red'></i> পৰ্য্যবেশক কাননগোৰ মন্তব্য অপ্ৰাপ্ত</p>";
            }
            if ($r->proceeding_yn == '') {
                $status = $status . "<p class='text-info'> <i class='fa fa-exclamation-triangle red'></i> সহায়কৰ মন্তব্য অপ্ৰাপ্ত</p>";
            }
            if ($r->lm_note_yn == 'Y' and $r->notice_generated_yn == 'Y' and $r->proceeding_yn == '1') {
                $link1 = base_url() . "index.php/CompositeService/finalOrderPass?case_no=" . enc_param('case_no', $r->case_no, 600) . "&dist_code=" . $r->dist_code . "&subdiv_code=" . $r->subdiv_code . "&cir_code=" . $r->cir_code . "&mouza_pargona_code=" . $r->mouza_pargona_code . "&lot_no=" . $r->lot_no . "&vill_townprt_code=" . $r->vill_townprt_code;
                $status = $status . '<a class="btn btn btn-success" href="' . $link1 . '">Write Report</a>&nbsp&nbsp';

                if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                { 

                // property chain code
                    $status = $status . ' <button type="button" data-toggle="modal" data-target="#myModal" case_no="' . $r->case_no . '" dist_code="' . $r->dist_code . '" subdiv_code="' . $r->subdiv_code . '" cir_code="' . $r->cir_code . '" mouza_pargona_code="' . $r->mouza_pargona_code . '" lot_no="' . $r->lot_no . '" vill_townprt_code="' . $r->vill_townprt_code . '" class="chainReportC btn btn-primary" style="margin: 2px;">View Property Chain</button>';
                }
            }

            if ($r->noc_no) {
                $noc_no = "<br><span class='small font-italic red'>NOC No. :" . $r->noc_no . "</span>";
            } else {
                $noc_no = null;
            }
            $sub_array = array();
            $sub_array[] = $r->case_no . $noc_no;
            $sub_array[] = $location;
            $sub_array[] = $entry_date;
            $sub_array[] = $status;
            $data[] = $sub_array;
        }
        //var_dump($data);
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $this->PetitionBasic_Model->get_all_data_final($clause),
            "recordsFiltered" => $this->PetitionBasic_Model->get_filtered_data_final($clause),
            "data" => $data
        );
        echo json_encode($output);
    }

    /////////////280323////////
    function sendCO()
    {
        $user_desig_code = $this->session->userdata('user_desig_code');
        if(!in_array($user_desig_code, ['AST'])){
            show_error('error', 'You are not authorized to perform this action.');
        }
        $appno = $this->input->get('appno');
        $dist_code = $this->input->get('distcode');
        $subcode = $this->input->get('subcode');
        $circode = $this->input->get('circode');
        $hearingdt = $this->input->get('hearingdt');

        $this->db->trans_begin();

        $insert_hearing = array(
        'appno'=>$appno,
        'distcode'=>$dist_code,
        'subcode'=>$subcode,
        'circode' =>$circode,
        'prev_hearingdt'=>$hearingdt,
        'date_of_action'=>date('Y-m-d G:i:s')
        );

        $insert_hearing = $this->db->insert("previous_hearing_date", $insert_hearing); //************
        if ($insert_hearing != 1) {
            $this->db->trans_rollback();
            log_message("error", "#AUTOMH001, Error in insert previous_hearing_date table with query- ". json_encode($this->db->last_query()));
            $this->session->set_flashdata('message', "Case cannot be forwarded to CO(#AUTOMH001)");
            redirect(base_url() . "index.php/home");
        }

        $update_noc = array(
            'hearingdt' => null,
            'changebuyer'=>'Y'
        );
        $this->db->where('distcode', $dist_code);
        $this->db->where('appno', $appno);
        $this->db->update('landsale', $update_noc);
        if($this->db->affected_rows() != 1){
        $this->db->trans_rollback();
        log_message("error"," #ERRALT003: Updation failed in allotment_cert_basic 
            for case no: ". $appno);            
        $this->session->set_flashdata('message',"#ERRALT003: Final Submission failed 
            for case no : ".$appno);
        redirect(base_url() . 'index.php/home');
        return false;    
        }

        $this->db->trans_commit();
        $this->session->set_flashdata('message', "Case $appno is forwarded to Circle Officer for new hearing date.");
        redirect(base_url() . 'index.php/home');
    }


    //////////
    public function uploadSupportiveDocs()
    {
        // XSS Validation START
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
            // $this->session->set_flashdata('message', $errorMessageStr);
            // return redirect($_SERVER['HTTP_REFERER']);
            $data = [
                'success' => false,
                'errors' => $errorMessageStr
            ];

            return $this->output
                    ->set_status_header('403')
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data)); 
        }
        // XSS Validation END
        $user_desig_code = $this->session->userdata('user_desig_code');
        if(!in_array($user_desig_code, ['CO'])){
            $data = [
                'success' => false,
                'errors' => 'You are not authorized to perform this action.'
            ];

            return $this->output
                    ->set_status_header('403')
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));
        }

        $val = $this->input->post();
        $case_no = $val['case_no'];
        $flag = $val['flag'];
        $dist_code = $this->session->userdata('dist_code');//$val['dist_code'];
        $doc1 = isset($val['doc1']) ? $val['doc1'] : '';
        $doc2 = isset($val['doc2']) ? $val['doc2'] : '';

        $val = explode('/',$case_no);
        $petition_no = $val[3];        

        if($val[4]=='OMUTC'){
            $folder = COMPOSITE_BASE_DIR . $dist_code . UPLOAD_SEPARATOR;
            $petition_no = $this->db->query("SELECT petition_no FROM petition_basic WHERE case_no=? ", array($case_no))->row()->petition_no;
        }
        if ($petition_no == null || $petition_no == '' || empty($petition_no))
        {
            $validation['img_upload'] = false;
            echo json_encode($validation);
            return;
        }

        $name = (($flag==1)?'doc1_file':(($flag==2)?'doc2_file':'null'));
        $sl = (($flag==1)?'1':(($flag==2)?'2':'3'));
        $file_name = (($flag==1)?$doc1:(($flag==2)?$doc2:$doc3));
        

        $ext = pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION);
        $_FILES[$name]['name'] = $petition_no.'_'.$sl.'.'.$ext;

        if(!file_exists($folder)){
            mkdir($folder, 0777, true);
            $path = $folder;
        }
        else {
            $path = $folder;   
        } 
        //echo $path;       
        $config = [
            'upload_path' => $path,
            'allowed_types' => FILE_TYPE,
            'max_size' => MAX_SIZE,
        ];
        $FILES_TYPE_VALIDATION_ARR = explode('|', FILE_TYPE);
        $checkFileExt = false;
        foreach ($FILES_TYPE_VALIDATION_ARR as $file_type) {
            if($ext == $file_type) {
                $checkFileExt = true;
                break;
            }
        }
        $validation=null;
        //log_message('error',json_encode($_FILES[$name]['size']));
        if(!$checkFileExt){
            $validation['error'][] = array('message' => ' Only allowed types ' . FILE_TYPE . '.');
        }
        else if($_FILES[$name]['size'] > (MAX_SIZE * 1024) )
        {
            $validation['error'][] = array('message' => ' Larger file size selected.');
        }
        else
        {   
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            $count = $this->db->query("SELECT * FROM supportive_document WHERE case_no=? AND user_code=? and doc_flag= ? ",array($case_no, $this->user_code,$flag))->num_rows();
           // var_dump($count);
           //  exit;

            if($count == 0)
            {
                if ($this->upload->do_upload($name)) 
                {
                    $up = $this->upload->data();
                    $img = [
                        'case_no' => $case_no,
                        'file_name' => $file_name,
                        'user_code' => $this->user_code,
                        'fetch_file_name' => $petition_no.'_'.$sl.$up['file_ext'],
                        'file_type' => $up['file_type'],
                        'file_path' => $path.$petition_no.'_'.$sl.$up['file_ext'],
                        'date_entry' => date('Y-m-d h:i:s'),
                        'mut_type' => FIELD_MUT_TYPE,
                        'doc_flag'=>$flag
                    ];
                    $ins = $this->db->insert('supportive_document', $img);
                    if($ins == true)
                    {
                        $id=$this->db->query("SELECT * FROM supportive_document WHERE case_no=? AND file_name=?", array($case_no, $file_name))->row()->id;
                        $validation['img_upload'] = true;
                        $validation['flag_set'] = $flag;
                        $validation['doc_id'] = $id;
                        $validation['filename'] = $file_name;
                    }
                    else
                    {
                        $validation['img_upload'] = false;
                    }
                }//end do upload
                else{
                    $validation['img_upload'] = false;
                }
            }// end count if

            else { //overwrite previous one

                $file = $this->db->query("SELECT * FROM supportive_document WHERE case_no=? and doc_flag= ?", array($case_no,$flag))->row()->file_path;
                // echo $file;
                // exit;
                unlink($file);
                if ($this->upload->do_upload($name)) 
                {
                    $up = $this->upload->data();
                    $overwrite = [
                        'fetch_file_name' => $petition_no.'_'.$sl.$up['file_ext'],
                        'file_type' => $up['file_type'],
                        'file_path' => $path.$petition_no.'_'.$sl.$up['file_ext'],
                        'date_entry' => date('Y-m-d h:i:s'),
                        'mut_type' => FIELD_MUT_TYPE,
                        'file_name'=>$file_name
                    ];
                    $this->db->where(['case_no'=>$case_no, 'doc_flag'=>$flag, 'user_code'=>$this->user_code]);
                    $this->db->update('supportive_document', $overwrite);
                    if($this->db->affected_rows() != 1)//if no updation made
                    {
                        $validation['img_upload'] = false;   
                    }
                    else
                    {
                        $id=$this->db->query("SELECT * FROM supportive_document WHERE case_no=? AND doc_flag=?", array($case_no, $flag))->row()->id;
                        $validation['img_upload'] = true;
                        $validation['flag_set'] = $flag;
                        $validation['doc_id'] = $id;
                        $validation['filename'] = $file_name;
                    }
                }
            }
        }
        echo json_encode($validation);        
    }

    public function removeSupportiveDocs()
    {
        // XSS Validation START
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
            // $this->session->set_flashdata('message', $errorMessageStr);
            // return redirect($_SERVER['HTTP_REFERER']);
            $data = [
                'success' => false,
                'errors' => $errorMessageStr
            ];

            return $this->output
                    ->set_status_header('403')
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data)); 
        }
        // XSS Validation END
        $user_desig_code = $this->session->userdata('user_desig_code');
        if(!in_array($user_desig_code, ['CO'])){
            $data = [
                'success' => false,
                'errors' => 'You are not authorized to perform this action.'
            ];

            return $this->output
                    ->set_status_header('403')
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));
        }
        
        $dist_code = $this->session->userdata('dist_code');
        $case_no = $this->input->post('case_no');
        $flag = $this->input->post('flag');
        $doc1 = $this->input->post('doc1');
        $doc2 = $this->input->post('doc2');
        $val = explode('/',$case_no);

        $petition_no = $val[3];   

        $getFileDetails = $this->db->query("SELECT id, fetch_file_name, file_path,file_name FROM supportive_document WHERE case_no=? and doc_flag=?", array($case_no,$flag))->row(); 
       
        // var_dump($getFileDetails[0]->file_name);
        // exit; 
        if($getFileDetails) { 
            $file_name = (($flag==1)?$getFileDetails->file_name:(($flag==2)?$getFileDetails->file_name:NOK_CONSENT));

            $getFile = $this->db->query("SELECT id, fetch_file_name, file_path FROM supportive_document WHERE case_no=? AND file_name=?", array($case_no, $file_name))->row();
            $file_path=$getFile->file_path;
            $delete = $this->db->query("DELETE FROM supportive_document WHERE id=?", array($getFile->id));

            if($delete == true) {
                unlink($file_path);
                $validation['flag'] = $flag;
            }
        }
        else{
            $file_name = (($flag==1)?$doc1:(($flag==2)?$doc2:NOK_CONSENT));

            $getFile = $this->db->query("SELECT id, fetch_file_name, file_path FROM supportive_document WHERE case_no=? AND file_name=?", array($case_no, $file_name))->row();
            $delete = $this->db->query("DELETE FROM supportive_document WHERE id=?", array($getFile->id));

            if($delete == true) {
                unlink($getFile->file_path);
                $validation['flag'] = $flag;
            }
        }
        echo json_encode($validation);
    }


    //////dispose without reject///

    function rejectCO()
    {
        $appno = $this->input->post('noc_no');
        $case_no=$this->input->post('case_no');
        $mutation=$this->input->post('mutation');
        $co_report=$this->input->post('co_report');
        $dist_code=$this->input->post('dist_code');
        $subdiv_code=$this->input->post('subdiv_code');
        $cir_code=$this->input->post('cir_code');
        // var_dump($mutation);
        // exit;

        $co_report=$co_report." [";
       
         foreach($mutation as $pet){
            $co_report=$co_report.$pet.",";
         }

        $co_report=$co_report."]";

       $this->form_validation->set_rules('co_report', 'Remark', 'trim|required');
       // $this->form_validation->set_rules('mutation', 'Checkbox', 'trim|required');

        if($this->form_validation->run()==false)
       {
            $text=str_ireplace('<\/p>','',validation_errors());
            $text=str_ireplace('<p>','',$text);
            $text=str_ireplace('</p>','',$text);
            echo json_encode(array('msg'=>$text, 'st'=>0));
            return;
       }

        else{

        $this->db->trans_begin();

        $proceeding_id = $this->db->query("select count(proceeding_id)+1 as pid from    petition_proceeding where case_no='$case_no'")->row()->pid;
        if ($proceeding_id == null) {
            $proceeding_id = 1;
        }
     
        $proceeding = array(
            'case_no' => $case_no,
            'proceeding_id' =>  $proceeding_id,
            'date_of_hearing' => date("Y-m-d h:i:s"),
            'co_order' => $co_report,
            'next_date_of_hearing' => null,
            'status' => '0',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date("Y-m-d h:i:s"),
            'operation' => 'E',
            'dist_code' => $dist_code,
            'subdiv_code' =>$subdiv_code,
            'cir_code' => $cir_code,
            'ip' => $this->utilityclass->get_client_ip(),
        );
        $proceeding1 = $this->db->insert('petition_proceeding', $proceeding);
        if ($proceeding1 == false) {
            $data = array(
                'msg' => "Case Cannot Be Registered. Unable to save data. [##AUTOM001222]",
                'error' => true,
                'url' => 0,
            );
            log_message("error", "##AUTOM001222. Unable to save data into 
                        petition_proceeding. case no. $case_no");
            return $data;
        }


        $update_pb = array(
            'status' => 'D',
            'order_passed' => 'Y',
            'remarks' =>'Case has been successfully disposed',
            'date_of_order' => date("Y-m-d h:i:s"),
        );

        $this->db->where('dist_code', $dist_code);
        $this->db->where('case_no', $case_no);
        $this->db->update('petition_basic', $update_pb);
        if($this->db->affected_rows() != 1){
        $this->db->trans_rollback();
        log_message("error"," #ERRALT0000: Updation failed in petition_basic 
            for case no: ". $case_no);            
        $this->session->set_flashdata('message',"#ERRALT0000: Final Submission failed 
            for case no : ".$case_no);
        redirect(base_url() . 'index.php/home');
        return false;    
        }

        $update_ls = array(
            'dispwithoutam' => 'Y',
            'mutcomp' => 'Y', 
            'mutcompdt' => date('Y-m-d')
        );

        $this->db->where('distcode', $dist_code);
        $this->db->where('appno', $appno);
        $this->db->update('landsale', $update_ls);
        if($this->db->affected_rows() != 1){
        $this->db->trans_rollback();
        log_message("error"," #ERRALT00001: Updation failed in landsale
            for case no: ". $appno);            
        $this->session->set_flashdata('message',"#ERRALT00001: Final Submission failed 
            for case no : ".$appno);
        redirect(base_url() . 'index.php/home');
        return false;    
        }

        

        $this->db->trans_commit();
        //$this->db->trans_rollback();
        $this->session->set_flashdata('message', "Case $case_no is disposed.");
        redirect(base_url() . 'index.php/home');
    }
}


    ///////NGDRS API/////////
    function getNgdrsdeedLHAPI($dist_code,$subdiv_code,$cir_code)
    {

        $document_registration_date=array();
        $thisTime = strtotime("2024-02-13");
        $endTime = strtotime(date('Y-m-d'));
        while($thisTime < $endTime)
        {
            $thisDate = date('Y-m-d', $thisTime);
            $document_registration_date[] = $thisDate;

            $thisTime = strtotime('+1 day', $thisTime); // increment for loop
        }
        // var_dump($document_registration_date);exit;


        /////////API//////////
       // SRO_SERVICE."//
            $url = NGDRS_SRO_NOTE."dharNgdrsApi.php";
            $post_array = [
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'document_registration_date' => json_encode($document_registration_date),
            ];

            $result = sendCurlRequest($url, 'POST', $post_array);
            $result = json_decode($result);

            if($result!=null){
                foreach($result as $res){
                    $res=json_decode($res);
                    if(!isset($res->Alert)){

                    foreach($res as $d)
                    {
                    $data = array(
                    'dist_code' => $d->dist_code,
                    'subdiv_code' => $d->subdiv_code,
                    'cir_code' => $d->cir_code,
                    'mouza_pargona_code' => $d->mouza_pargona_code,
                    'lot_no' => $d->lot_no,
                    'vill_townprt_code' => $d->vill_townprt_code,
                    'dag_no' => $d->dag_no,
                    'deed_type' => $d->deed_type,
                    'patta_type_code' => $d->pattatype,
                    'patta_no' => trim($d->patta_no),
                    'dag_area_b' => intval($d->dag_area_b),
                    'dag_area_k' => $d->dag_area_k,
                    'dag_area_lc' => $d->dag_area_lc,
                    'dag_area_g' => $d->ganda,
                    'dag_area_kr' => 0,
                    'reg_to_name' => $d->partydetails->reg_to_name,
                    'reg_from_name' => $d->partydetails->reg_from_name,
                    'name_of_sro' => $d->name_of_sro,
                    'deed_no' => $d->deed_no,
                    'deed_value' => $d->deed_value,
                    'date_of_deed' => date('Y-m-d H:i:sP', strtotime($d->date_of_deed)),
                    'user_code' => $this->session->userdata('user_code'),
                    'operation' => 'E',
                    'status' => 0,
                    'sro_code' => $d->sro_code,
                    'update_date' => date('Y-m-d G:i:s'),
                    'nocno' => $d->nocno,
                    'ngdrs'=>'Y'
                );
                
                $deedNo = $d->deed_no;
                $count = $this->db->query("select count(deed_no) as c from  sro_note where
                deed_no='$deedNo' and dist_code='$d->dist_code'
                and subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code' and sro_code='$d->sro_code' ")->row()->c;

                if ($count == 0) {
                    $data1 = $this->db->insert('sro_note', $data);
            
                }
            }
        }
        }
        }
    }


    public function getSronotebyNOC()
    {

        $noc_no = $this->input->get('noc_no');
        // var_dump($noc_no);exit;
    
        $params = array(
            'noc_no' => $noc_no,
        );
                /////////API//////////
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, "https://landhub.assam.gov.in/nocApi/dhar_ngdrs/getsronote_noc.php");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query($params));
        log_message('error', 'A1: calling ngdrs api with params: '.json_encode($params));
        $result = curl_exec($curl_handle);
        if (curl_errno($curl_handle)) 
        {
            $error_msg = curl_error($curl_handle);
            log_message('error',"#ERROR4319===getNGDRSDeedDetails for date--".date('Y-m-d')."--".json_encode($error_msg));
        }
        $result = json_decode($result);
        log_message('error','A2: response data from ngdrs: '.json_encode($result));
        // var_dump($result->Alert);exit;

        if(!isset($result->Alert))
        {
            $dis = $result[0]->dist_code;
            $sub = $result[0]->subdiv_code;
            $cir = $result[0]->cir_code;
            $sro = $result[0]->sro_code;


            $user_code_row = $this->db->query("select user_code as c from loginuser_table where 
                                     dist_code='$dis'
                                     and subdiv_code='$sub' and cir_code='$cir'
                                     and user_code like 'CO%' and dis_enb_option='E' ");
            //var_dump($user_code->row()->c);
            $user_code = $user_code_row->row()->c;

            $data = array(
                'dist_code' => $result[0]->dist_code,
                'subdiv_code' => $result[0]->subdiv_code,
                'cir_code' => $result[0]->cir_code,
                'mouza_pargona_code' => $result[0]->mouza_pargona_code,
                'lot_no' => $result[0]->lot_no,
                'vill_townprt_code' => $result[0]->vill_townprt_code,
                'dag_no' => $result[0]->dag_no,
                'deed_type' => $result[0]->deed_type,
                'patta_type_code' => $result[0]->pattatype,
                'patta_no' => trim($result[0]->patta_no),
                'dag_area_b' => intval($result[0]->dag_area_b),
                'dag_area_k' => $result[0]->dag_area_k,
                'dag_area_lc' => $result[0]->dag_area_lc,
                'dag_area_g' => $result[0]->ganda,
                'dag_area_kr' => 0,
                'reg_to_name' => $result[0]->partydetails->reg_to_name,
                'reg_from_name' => $result[0]->partydetails->reg_from_name,
                'name_of_sro' => $result[0]->name_of_sro,
                'deed_no' => $result[0]->deed_no,
                'deed_value' => $result[0]->deed_value,
                'date_of_deed' => date('Y-m-d H:i:sP', strtotime($result[0]->date_of_deed)),
                'user_code' => $user_code,
                'operation' => 'E',
                'status' => 0,
                'sro_code' => $result[0]->sro_code,
                'update_date' => date('Y-m-d G:i:s'),
                'nocno' => $result[0]->nocno,
                'ngdrs'=>'Y'
            );
                
            $deedNo = $result[0]->deed_no;
            $nocNo = $result[0]->nocno;
             //////////NEWLY ADDED---APDCL-GMC-030225//////////
            if(isset($result[0]->utility) || count($result[0]->utility)>0)
            {
              $utility = 'Y';
              $utility_json = json_encode($result[0]->utility);
            }
            else
            {
              $utility = null;
              $utility_json = null;
            }
            $data['utility']=$utility;
            $data['utility_json']=$utility_json;
            /////////ENDED///////////
            ////in the insert array of sro_note ///
            $count = $this->db->query("select count(deed_no) as c from  sro_note where
                nocno='$nocNo' and dist_code='$dis'
                and subdiv_code='$sub' and cir_code='$cir' and sro_code='$sro' ")->row()->c;

            if ($count == 0) 
            {
                $data1 = $this->db->insert('sro_note', $data);
                //////////////NEWLY ADDED---APDCL-GMC-030225/////////////////
                $primary=[
                    'dist_code' => $result[0]->dist_code,
                    'subdiv_code' => $result[0]->subdiv_code,
                    'cir_code' => $result[0]->cir_code,
                    'mouza_pargona_code' => $result[0]->mouza_pargona_code,
                    'lot_no' => $result[0]->lot_no,
                    'vill_townprt_code' => $result[0]->vill_townprt_code,
                    'deed_no'=>$result[0]->deed_no,
                    'nocno' => $result[0]->nocno,
                ];
                if (isset($result[0]->utility) && is_array($result[0]->utility)) 
                {
                foreach($result[0]->utility as $cons)
                {
                    $consumer=[
                        'consumer_no'=>$cons->consumer_no,
                        'holding_no' => $cons->holding_no,
                        'patta_type_code'=>$cons->patta_type_code,
                        'unique_vill_code'=>$cons->unique_vill_code,
                        'date_of_update'=>date('Y-m-d G:i:s'),
                        'dag_no'=>$cons->dag,
                        'patta_no'=>$cons->patta_no,
                    ];
                    $base=array_merge($primary,$consumer);
                    if (isset($cons->buyers) && is_array($cons->buyers)) {
                             foreach($cons->buyers as $buyer)
                              {
                                  $data_util1 = array(
                                    'name'=>$buyer->name,
                                    'ngdrs_id'=>$buyer->ngdrs_id,
                                    'mobile'=>$buyer->mobile,
                                    'guard_name' => $buyer->father_name,
                                    'consumer_type'=>'B',
                                  );
                                  $data1 = $this->db->insert('sronote_apdcl_gmc', array_merge($base,$data_util1));
                                  if($data1 != 1)
                                  {
                                    $this->db->trans_rollback();  
                                    log_message("error"," #APDCLGMC001 could not insert sronote_apdcl_gmc deed_no: ".$d->deed_no);
                                    return;
                                  }
                              }
                          }
                          if (isset($cons->sellers) && is_array($cons->sellers)) {
                              foreach($cons->sellers as $seller)
                              {
                                  $data_util2 = array(
                                    'name'=>$seller->name,
                                    'ngdrs_id'=>$seller->ngdrs_id,
                                    'mobile'=>$seller->mobile,
                                    'consumer_type'=>'S',
                                  );
                                  $data2 = $this->db->insert('sronote_apdcl_gmc', array_merge($base,$data_util2));
                                  if($data2 != 1)
                                  {
                                    $this->db->trans_rollback();  
                                    log_message("error"," #APDCLGMC002 could not insert sronote_apdcl_gmc deed_no: ".$d->deed_no);
                                    return;
                                  }
                              }
                          }
                    }
                }
                ///////////////END 030225////////////////
                $params = array(
                        'application_no' => $deedNo,
                        'nocno' => $nocNo
                    );
                log_message('error', 'A000:'.json_encode($params));
                /////////API//////////

                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, "https://landhub.assam.gov.in/nocApi/dhar_ngdrs/dharNgdrsUpdateSroNoteApi.php");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query($params));

                $result = curl_exec($curl_handle);
                $result = json_decode(json_decode($result));

                log_message('error','A01:API Data'.json_encode($result));
                // log_message('error','A111:API Data'.json_encode($result->status)); die;
                //////////// API CALL LOG: END/////////////

                if($result!=null && $result->status=='true')
                {
                    log_message('error','A11:updated Data'.json_encode($nocNo));
                }
            
            }
            $this->session->set_flashdata("message", "Deed is pulled for NOC.: " . $noc_no);redirect(base_url() . "index.php/CompositeService/getPendingCasesCO");
        }

        else if($result->Alert=='Record Not found')
        {
           $this->session->set_flashdata("message", "Deed is not Delivered for NOC.: " . $noc_no);
            redirect(base_url() . "index.php/CompositeService/getPendingCasesCO");
        }

        else
        {
           $this->session->set_flashdata("message", "Deed is not found for NOC.: " . $noc_no);
            redirect(base_url() . "index.php/CompositeService/getPendingCasesCO");
        }
    }


    public function getSronotebyNOC_ajax()
    {
        $noc_no = $this->input->post('noc_no');
        //var_dump($noc_no);exit;
    
        $params = array(
            'noc_no' => $noc_no,
        );
                /////////API//////////
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, "https://landhub.assam.gov.in/nocApi/dhar_ngdrs/getsronote_noc.php");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query($params));
        log_message('error', 'A1: calling ngdrs api with params: '.json_encode($params));
        $result = curl_exec($curl_handle);
        if (curl_errno($curl_handle)) 
        {
            $error_msg = curl_error($curl_handle);
            log_message('error',"#ERROR4319===getNGDRSDeedDetails for date--".date('Y-m-d')."--".json_encode($error_msg));
        }
        $result = json_decode($result);
        log_message('error','A2: response data from ngdrs: '.json_encode($result));
         //var_dump($result);exit;

        if(!isset($result->Alert))
        {
            $dis = $result[0]->dist_code;
            $sub = $result[0]->subdiv_code;
            $cir = $result[0]->cir_code;
            $sro = $result[0]->sro_code;


            $user_code_row = $this->db->query("select user_code as c from loginuser_table where 
                                     dist_code='$dis'
                                     and subdiv_code='$sub' and cir_code='$cir'
                                     and user_code like 'CO%' and dis_enb_option='E' ");
           
            
            //var_dump($user_code->row()->c);
            $user_code = $user_code_row->row()->c;

            $data = array(
                'dist_code' => $result[0]->dist_code,
                'subdiv_code' => $result[0]->subdiv_code,
                'cir_code' => $result[0]->cir_code,
                'mouza_pargona_code' => $result[0]->mouza_pargona_code,
                'lot_no' => $result[0]->lot_no,
                'vill_townprt_code' => $result[0]->vill_townprt_code,
                'dag_no' => $result[0]->dag_no,
                'deed_type' => $result[0]->deed_type,
                'patta_type_code' => $result[0]->pattatype,
                'patta_no' => trim($result[0]->patta_no),
                'dag_area_b' => intval($result[0]->dag_area_b),
                'dag_area_k' => $result[0]->dag_area_k,
                'dag_area_lc' => $result[0]->dag_area_lc,
                'dag_area_g' => $result[0]->ganda,
                'dag_area_kr' => 0,
                'reg_to_name' => $result[0]->partydetails->reg_to_name,
                'reg_from_name' => $result[0]->partydetails->reg_from_name,
                'name_of_sro' => $result[0]->name_of_sro,
                'deed_no' => $result[0]->deed_no,
                'deed_value' => $result[0]->deed_value,
                'date_of_deed' => date('Y-m-d H:i:sP', strtotime($result[0]->date_of_deed)),
                'user_code' => $user_code,
                'operation' => 'E',
                'status' => 0,
                'sro_code' => $result[0]->sro_code,
                'update_date' => date('Y-m-d G:i:s'),
                'nocno' => $result[0]->nocno,
                'ngdrs'=>'Y'
            );
                
            $deedNo = $result[0]->deed_no;
            $nocNo = $result[0]->nocno;
            //////////NEWLY ADDED---APDCL-GMC-030225//////////
            if(isset($result[0]->utility) || count($result[0]->utility)>0)
            {
              $utility = 'Y';
              $utility_json = json_encode($result[0]->utility);
            }
            else
            {
              $utility = null;
              $utility_json = null;
            }
            $data['utility']=$utility;
            $data['utility_json']=$utility_json;
            /////////ENDED///////////
            $count = $this->db->query("select count(deed_no) as c from  sro_note where
                nocno='$nocNo' and dist_code='$dis'
                and subdiv_code='$sub' and cir_code='$cir' and sro_code='$sro' ")->row()->c;

            if ($count == 0) 
            {
                $data1 = $this->db->insert('sro_note', $data);
                //////////////NEWLY ADDED---APDCL-GMC-030225/////////////////
                $primary=[
                    'dist_code' => $result[0]->dist_code,
                    'subdiv_code' => $result[0]->subdiv_code,
                    'cir_code' => $result[0]->cir_code,
                    'mouza_pargona_code' => $result[0]->mouza_pargona_code,
                    'lot_no' => $result[0]->lot_no,
                    'vill_townprt_code' => $result[0]->vill_townprt_code,
                    'deed_no'=>$result[0]->deed_no,
                    'nocno' => $result[0]->nocno,
                ];
                if (isset($result[0]->utility) && is_array($result[0]->utility)) 
                {
                foreach($result[0]->utility as $cons)
                {
                    $consumer=[
                        'consumer_no'=>$cons->consumer_no,
                        'holding_no' => $cons->holding_no,
                        'patta_type_code'=>$cons->patta_type_code,
                        'unique_vill_code'=>$cons->unique_vill_code,
                        'date_of_update'=>date('Y-m-d G:i:s'),
                        'dag_no'=>$cons->dag,
                        'patta_no'=>$cons->patta_no,
                    ];
                    $base=array_merge($primary,$consumer);
                    if (isset($cons->buyers) && is_array($cons->buyers)) {
                             foreach($cons->buyers as $buyer)
                              {
                                  $data_util1 = array(
                                    'name'=>$buyer->name,
                                    'ngdrs_id'=>$buyer->ngdrs_id,
                                    'mobile'=>$buyer->mobile,
                                    'guard_name' => $buyer->father_name,
                                    'consumer_type'=>'B',
                                  );
                                  $data1 = $this->db->insert('sronote_apdcl_gmc', array_merge($base,$data_util1));
                                  if($data1 != 1)
                                  {
                                    $this->db->trans_rollback();  
                                    log_message("error"," #APDCLGMC001 could not insert sronote_apdcl_gmc deed_no: ".$d->deed_no);
                                    return;
                                  }
                              }
                          }
                          if (isset($cons->sellers) && is_array($cons->sellers)) {
                              foreach($cons->sellers as $seller)
                              {
                                  $data_util2 = array(
                                    'name'=>$seller->name,
                                    'ngdrs_id'=>$seller->ngdrs_id,
                                    'mobile'=>$seller->mobile,
                                    'consumer_type'=>'S',
                                  );
                                  $data2 = $this->db->insert('sronote_apdcl_gmc', array_merge($base,$data_util2));
                                  if($data2 != 1)
                                  {
                                    $this->db->trans_rollback();  
                                    log_message("error"," #APDCLGMC002 could not insert sronote_apdcl_gmc deed_no: ".$d->deed_no);
                                    return;
                                  }
                              }
                          }
                    }
                }
                ///////////////END 030225////////////////
                $params = array(
                        'application_no' => $deedNo,
                        'nocno' => $nocNo
                    );
                log_message('error', 'A000:'.json_encode($params));
                /////////API//////////

                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, "https://landhub.assam.gov.in/nocApi/dhar_ngdrs/dharNgdrsUpdateSroNoteApi.php");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query($params));

                $result = curl_exec($curl_handle);
                $result = json_decode(json_decode($result));

                log_message('error','A01:API Data'.json_encode($result));
                log_message('error','A111:API Data'.json_encode($result->status)); die;
                ////////// API CALL LOG: END/////////////

                if($result!=null && $result->status=='true')
                {
                    log_message('error','A11:updated Data'.json_encode($nocNo));
                }
            
            }

            $data = array(
                    'msg' => "Deed has been successfully pulled for NOC no.: " . $noc_no . " (##AUTOSRO0002)",
                    'suceess' => true,
                    'url' => 0,
                );
                log_message("error", "Deed has been successfully pulled for NOC no.: " . $noc_no);
                echo json_encode($data);
                return;

        }

        else if($result->Alert=='Record Not found')
        {
           $data = array(
                    'msg' => "Deed is not Delivered for NOC no.: " . $noc_no . " (##AUTOSRO0001)",
                    'error' => true,
                    'url' => 0,
                );
                log_message("error", "Deed is not Delivered for NOC no.: " . $noc_no);
                echo json_encode($data);
                return;
        }

        else
        {
            $data = array(
                    'msg' => "Deed is not found for NOC no.: " . $noc_no . " (##AUTOSRO0003)",
                    'error' => true,
                    'url' => 0,
                );
                log_message("error", "Deed is not found for NOC no.: " . $noc_no);
                echo json_encode($data);
                return;
            
        }
    }


     //****update settlement_applicant*** */
    public function updateInplaceAlongwithData()
    {
        // var_dump($_POST);exit;

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');

        $case_no = $this->input->post('case_no');
        $selected = $this->input->post('selected');
        $dag_no = $this->input->post('dag_no');
        $pdar_id = $this->input->post('pdar_id');
        // $selected_prop_name = $this->input->post('selectedClassText');

        $this->form_validation->set_error_delimiters('', '');
        // $this->form_validation->set_rules('applicant_d_id', 'Applicant ID', 'trim|required');
        $this->form_validation->set_rules('case_no', 'Case no', 'trim|required');

        if ($this->form_validation->run() == false) {
            $data = array(
                'responseType' => 0,
                'msg' => "#COMPDAGS00011:" . validation_errors() . "#case_no : " . $case_no,
            );
            echo json_encode($data);
            return false;
        }

        $this->db->trans_begin();



        $petition_no = $this->db->select()
            ->where('case_no', $case_no)
            ->get('petition_basic')->row()->petition_no;

        $basic = $this->db->select()
        ->where('case_no', $case_no)
        ->get('petition_basic')
        ->row();

        $row = $this->db->select()
        ->where('case_no', $case_no)
        ->where('dag_no', $dag_no)
        ->where('pdar_id', $pdar_id)
        ->where('petition_no', $petition_no)
        ->get('petition_pattadar')
        ->row();

        $prev_strike_out = $row ? $row->striked_out : null;
        $pdar_name = $row ? $row->pdar_name : null;

        $updateArr = [
                    'striked_out'      => $selected,
                ];
                $this->db->where('case_no', $case_no);
                $this->db->where('dag_no', $dag_no);
                $this->db->where('pdar_id', $pdar_id);
                $this->db->where('petition_no', $petition_no);
                $this->db->update('petition_pattadar', $updateArr);

                if ($this->db->affected_rows() == 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO0004280: Failed to update');
                    $data = [
                        'responseType' => 0,
                        'msg' => '#ERRCO0004280: Failed to update. Kindly contact system administrator',
                    ];
                    echo json_encode($data);
                    return false;
                }

        //////proceeding start//////
        $proceeding_id = $this->db->query("SELECT max(proceeding_id)+1 AS pid FROM
         petition_proceeding WHERE case_no=? AND dist_code=? 
         and subdiv_code=? and cir_code=?",
            array($case_no, $dist_code, $subdiv_code, $cir_code))->row()->pid;
        if ($proceeding_id == null) {
            $proceeding_id = 1;
        }

      

        if ($prev_strike_out == '1' && $selected == '0') {
            $co_order = "CO changed petitioner information from Inplace to Alongwith of-".$pdar_name;
        }

        else if ($prev_strike_out == '0' && $selected == '1') {
            $co_order = "CO changed petitioner information from Alongwith to Inplace of-".$pdar_name;
        }

        else
        {
            $co_order = "CO changed petitioner Alongwith/Inplace information of -".$pdar_name;
        }

        $data = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => date('Y-m-d h:i:s'),
            'co_order' => $co_order,
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'status' => '0',
            'user_code' => $user_code,
            'dist_code' => $dist_code,
            'cir_code' => $cir_code,
            'subdiv_code' => $subdiv_code,
            'operation' => 'E',
            'date_entry' => date('Y-m-d G:i:s'),
            'ip' => $this->utilityclass->get_client_ip(),
        ];
        $pet_proceed = $this->db->insert('petition_proceeding', $data);
        if ($pet_proceed != 1) {
            $this->db->trans_rollback();
            log_message("error", " #OMCS002 could not insert petition_proceeding  
                        district: " . $dist_code . ", petition_no: " . $petition_no);
            $array = array(
                'error' => true,
                'redirect_url' => 0,
                'msg' => "#OMCS002 Unable to insert data.",
            );
            $this->db->trans_rollback();
            echo json_encode($array);
            return;
        }
        ///////////////////////////


            $this->db->trans_commit();
            /**** if data intserted successfully*/
            $data = array(
                'responseType' => 2,
                //'appnData' => $applicantDetailsArr,
                'msg' => "Inplace/Alongwith information updated successfully...",
            );
            echo json_encode($data);
    }

}
