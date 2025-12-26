<?php

class JunkDagDelete extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'Language'));
        $this->load->library('form_validation');
        echo json_encode("Bad Request");
        return;
        $this->dbswitch();
    }

    public function dbswitch()
    {
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
        }
    }

    //////////////////08.04.20222//////////////////
    public function dagLocation()
    {
        $this->dbswitch();
        if(!in_array($this->session->userdata('user_desig_code'), ['LM'])){
            $this->session->set_flashdata('message', 'You are not authorized to perform this action.');
            return redirect($_SERVER['HTTP_REFERER']);
        }
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $this->session->set_userdata(array('end' => false));
        $data['villages'] = $this->getVillageCodeJSON($dist_code, $subdiv_code,
            $cir_code, $mouza_pargona_code, $lot_no);
        $data['patta_type'] = $this->db->query("Select type_code,patta_type from patta_code order by type_code asc")->result();
        $data['_view'] = 'JunkDagDelete/DagSelectionForm';
        $this->load->view('layouts/main', $data);
    }

    ///////get villages//////////
    public function getVillageCodeJSON($distCode, $subdivcode, $circode, $mouzacode, $lotno)
    {
        $this->dbswitch();
        $district = $this->db->query("select distinct loc_name,vill_townprt_code from   location where "
            . "dist_code =?  and "
            . " subdiv_code=? and cir_code=? and mouza_pargona_code=? and "
            . " vill_townprt_code!='00000' and lot_no=?",
            array($distCode, $subdivcode, $circode, $mouzacode, $lotno));

        return $district->result();
    }

    ////////////get dags/////////////////
    public function getDags($p, $v)
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $circle_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $v;

        if ($p == 0000) {
            $daginfo = $this->getDagforchithaAll($dist_code,
                $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
        } else {
            $daginfo = $this->getDagforchitha1111($dist_code,
                $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $p);
        }

        $json = array();

        foreach ($daginfo as $d) {
            $json[] = array('dag' => $d->dag_no, 'dag_no_int' => $d->dag_no_int);
        }
        echo json_encode($json);
    }

    public function getDagforchithaAll($district_code, $subdivision_code,
                                       $circle_code, $mouza_code, $lot_code, $village_code)
    {
        $q = "Select dag_no, dag_no_int from Chitha_Basic where Dist_code='$district_code' 
            and Subdiv_code='$subdivision_code' and "
            . "Cir_code='$circle_code' and Mouza_Pargona_code='$mouza_code' and Lot_No='$lot_code' "
            . "and Vill_townprt_code='$village_code' order by CAST(coalesce(dag_no_int, '0') AS numeric)";

        $district = $this->db->query($q);

        return $district->result();
    }

    public function getDagforchitha1111($district_code, $subdivision_code, $circle_code,
                                        $mouza_code, $lot_code, $village_code, $p)
    {
        $q = ""
            . "Select dag_no, dag_no_int from   Chitha_Basic where "
            . "Dist_code='$district_code' and Subdiv_code='$subdivision_code' and  patta_type_code='$p' and "
            . "Cir_code='$circle_code' and Mouza_Pargona_code='$mouza_code' and Lot_No='$lot_code' "
            . "and Vill_townprt_code='$village_code' order by CAST(coalesce(dag_no_int, '0') AS numeric)";

        $district = $this->db->query($q);

        return $district->result();
    }

    ////////////// view dag details /////////////////////////
    function viewdagdetails()
    {
        $db = $this->session->userdata('db');
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('cir_code');
        $mouza_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');
        $dag_number = $this->input->post('dag_no');
        $patta_type = $this->input->post('patta_type');

        $data['basic_details'] = null;
        if ($patta_type == '0000') {
            $q = "select * from chitha_basic where dist_code=? and subdiv_code=? 
                and cir_code=? and mouza_pargona_code=? "
                . "and lot_no=? and vill_townprt_code=? and dag_no=?";

            $q_result = $this->db->query($q, array($dist_code, $subdiv_code,
                $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
            if ($q_result->num_rows() > 0) {
                $data['basic_details'] = $q_result->row();
                $patta_number = $q_result->row()->patta_no;
                $patta_type = $q_result->row()->patta_type_code;
            }
            else {
                $this->session->set_flashdata('message', "Dag No not found in Chitha.");
                redirect(base_url() . "index.php/home");
            }
        } else {
            $q = "select * from chitha_basic where dist_code=? and subdiv_code=? 
                and cir_code=? and mouza_pargona_code=? "
                . "and lot_no=? and vill_townprt_code=? and dag_no=?
                and patta_type_code=? ";

            $q_result = $this->db->query($q, array($dist_code, $subdiv_code,
                $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number, $patta_type));
            if ($q_result->num_rows() > 0) {
                $data['basic_details'] = $q_result->row();
                $patta_number = $q_result->row()->patta_no;
            }else {
                $this->session->set_flashdata('message', "Dag No not found in Chitha.");
                redirect(base_url() . "index.php/home");
            }
        }

        /////////chitha_basic//////////
        $data['chitha_basic'] = null;
        $q21 = "select * from chitha_basic where 
            dist_code=? and subdiv_code=? and "
            . "cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? "
            . "and patta_no=? and patta_type_code=? ";

        $q21_result = $this->db->query($q21, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number, $patta_number, $patta_type));
        if ($q21_result->num_rows() > 0) {
            $data['chitha_basic'] = $q21_result->result();
        }

        /////////chitha_dag_pattadar//////////
        $data['cdp'] = null;
        $q1 = "select pdar_id,p_flag,dag_no,patta_no,patta_type_code from chitha_dag_pattadar where 
            dist_code=? and subdiv_code=? and "
            . "cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? "
            . "and patta_no=? and patta_type_code=? ";

        $q1_result = $this->db->query($q1, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number, $patta_number, $patta_type));
        if ($q1_result->num_rows() > 0) {
            $data['cdp'] = $q1_result->result();
        }

        ///////chitha_pattadar/////////////
        $data['cp'] = null;
        $q2 = "select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,pdar_id,pdar_name,pdar_father from chitha_pattadar where 
            dist_code=? and subdiv_code=? and cir_code=? 
            and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? "
            . "and patta_no=? and patta_type_code=? ";
        $q2_result = $this->db->query($q2, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $patta_number, $patta_type));
        if ($q2_result->num_rows() > 0) {
            $data['cp'] = $q2_result->result();
        }

        ////////////chitha_rmk_ordbasic////////
        $data['chitha_rmk_ordbasic'] = null;
        $q3 = "select ord_no,ord_date from chitha_rmk_ordbasic where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q3_result = $this->db->query($q3, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));

        if ($q3_result->num_rows() > 0) {
            $data['chitha_rmk_ordbasic'] = $q3_result->result();
        }

        ////////////chitha_col8_order////////
        $data['chitha_col8_order'] = null;
        $q4 = "select * from chitha_col8_order where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q4_result = $this->db->query($q4, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));

        if ($q4_result->num_rows() > 0) {
            $data['chitha_col8_order'] = $q4_result->result();
        }

        ////////////chitha_col8_inplace////////
        $data['chitha_col8_inplace'] = null;
        $q5 = "select * from chitha_col8_inplace where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q5_result = $this->db->query($q5, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q5_result->num_rows() > 0) {
            $data['chitha_col8_inplace'] = $q5_result->result();
        }

        ////////////chitha_col8_occup////////
        $data['chitha_col8_occup'] = null;
        $q6 = "select * from chitha_col8_occup where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q6_result = $this->db->query($q6, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q6_result->num_rows() > 0) {
            $data['chitha_col8_occup'] = $q6_result->result();
        }

        ////////////chitha_rmk_allottee////////
        $data['chitha_rmk_allottee'] = null;
        $q7 = "select * from chitha_rmk_allottee where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q7_result = $this->db->query($q7, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q7_result->num_rows() > 0) {
            $data['chitha_rmk_allottee'] = $q7_result->result();
        }

        ////////////chitha_rmk_alongwith////////
        $data['chitha_rmk_alongwith'] = null;
        $q8 = "select * from chitha_rmk_alongwith where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q8_result = $this->db->query($q8, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q8_result->num_rows() > 0) {
            $data['chitha_rmk_alongwith'] = $q8_result->result();
        }

        ////////////chitha_rmk_convorder////////
        $data['chitha_rmk_convorder'] = null;
        $q9 = "select * from chitha_rmk_convorder where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q9_result = $this->db->query($q9, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q9_result->num_rows() > 0) {
            $data['chitha_rmk_convorder'] = $q9_result->result();
        }

        ////////////chitha_rmk_encro////////
        $data['chitha_rmk_encro'] = null;
        $q10 = "select * from chitha_rmk_encro where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q10_result = $this->db->query($q10, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q10_result->num_rows() > 0) {
            $data['chitha_rmk_encro'] = $q10_result->result();
        }

        ////////////chitha_rmk_gen////////
        $data['chitha_rmk_gen'] = null;
        $q11 = "select * from chitha_rmk_gen where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q11_result = $this->db->query($q11, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q11_result->num_rows() > 0) {
            $data['chitha_rmk_gen'] = $q11_result->result();
        }

        ////////////chitha_rmk_infavor_of////////
        $data['chitha_rmk_infavor_of'] = null;
        $q12 = "select * from chitha_rmk_infavor_of where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q12_result = $this->db->query($q12, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q12_result->num_rows() > 0) {
            $data['chitha_rmk_infavor_of'] = $q12_result->result();
        }

        ////////////chitha_rmk_inplace_of////////
        $data['chitha_rmk_inplace_of'] = null;
        $q13 = "select * from chitha_rmk_inplace_of where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q13_result = $this->db->query($q13, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q13_result->num_rows() > 0) {
            $data['chitha_rmk_inplace_of'] = $q13_result->result();
        }

        ////////////chitha_rmk_lmnote////////
        $data['chitha_rmk_lmnote'] = null;
        $q14 = "select * from chitha_rmk_lmnote where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q14_result = $this->db->query($q14, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q14_result->num_rows() > 0) {
            $data['chitha_rmk_lmnote'] = $q14_result->result();
        }

        ////////////chitha_rmk_onbehalf////////
        $data['chitha_rmk_onbehalf'] = null;
        $q15 = "select * from chitha_rmk_onbehalf where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q15_result = $this->db->query($q15, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q15_result->num_rows() > 0) {
            $data['chitha_rmk_onbehalf'] = $q15_result->result();
        }

        ////////////chitha_rmk_other_opp_party////////
        $data['chitha_rmk_other_opp_party'] = null;
        $q16 = "select * from chitha_rmk_other_opp_party where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q16_result = $this->db->query($q16, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q16_result->num_rows() > 0) {
            $data['chitha_rmk_other_opp_party'] = $q16_result->result();
        }

        ////////////chitha_rmk_reclassification////////
        $data['chitha_rmk_reclassification'] = null;
        $q17 = "select * from chitha_rmk_reclassification where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q17_result = $this->db->query($q17, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q17_result->num_rows() > 0) {
            $data['chitha_rmk_reclassification'] = $q17_result->result();
        }

        $patta_type_name = $this->db->query("Select patta_type as patta_name from    patta_code where type_code = '$patta_type'")->row()->patta_name;
        $land_class_name = $this->db->query("Select land_type as class_name from    landclass_code where class_code = '" . $data['basic_details']->land_class_code . "'")->row()->class_name;

        $districtdata = $this->utilityclass->getDistrictName($dist_code);
        $subdivdata = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $lotdata = $this->utilityclass->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
        $villagedata = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);

        $data['location'] = array(
            'dist_code' => $districtdata,
            'subdiv_code' => $subdivdata,
            'cir_code' => $circledata,
            'mouza_pargona_code' => $mouzadata,
            'lot_no' => $lotdata,
            'vill_townprt_code' => $villagedata,
            'patta_name' => $patta_type_name,
            'land_class_name' => $land_class_name,
        );
        $data['_view'] = 'JunkDagDelete/ViewJunkDagDetails';
        $this->load->view('layouts/main', $data);
    }

    ///////////// CHECK DISTRICT CODE CALL BACK FUNCTION///////////
    public function DistrictCode_check($dist_code)
    {
        $location = $this->utilityclass->getLocationFromSession();
        if ($location['dist_code'] == $dist_code) {
            return TRUE;
        } else {
            $this->form_validation->set_message('DistrictCode_check', 'This %s is invalid');
            return FALSE;
        }
    }

    ///////////////////////CHECK VILLAGE CODE CALL BACK FUNCTION///////////////
    public function VillCode_check()
    {
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_townprt_code');

        $villages_code_check = $this->db->query("select vill_townprt_code from location where 
            dist_code =?  and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and  lot_no=? and vill_townprt_code=?",
            array($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $vill_code));
        if ($villages_code_check->num_rows() == 1) {
            return TRUE;
        } else {
            $this->form_validation->set_message('VillCode_check', 'This %s is invalid');
            return FALSE;
        }
    }

    function deleteDagSubmitByLM()
    {
        $this->load->model('basundhara/basundharamodel');
        $case_name = $this->basundharamodel->genearteCaseName();
        $case_no['petition_no'] = $petition_no = $this->basundharamodel->genearteLegacyPetitionNo();
        $case_no = $case_name . $petition_no . "/JDD";

        $user_dist_code = $this->session->userdata('dist_code');

        $validation = array();
        $validate = array(
            array(
                'field' => 'dist_code',
                'label' => 'জিলা',
                'rules' => 'trim|required|integer|xss_clean|callback_DistrictCode_check',
            ),
            array(
                'field' => 'subdiv_code',
                'label' => 'মহকুমা',
                'rules' => 'trim|required|integer|xss_clean',
            ),
            array(
                'field' => 'cir_code',
                'label' => 'চক্র',
                'rules' => 'trim|required|integer|xss_clean',
            ),
            array(
                'field' => 'mouza_pargona_code',
                'label' => 'মৌজা',
                'rules' => 'trim|required|integer|xss_clean'
            ),
            array(
                'field' => 'lot_no',
                'label' => 'লাট',
                'rules' => 'trim|required|integer|xss_clean'
            ),
            array(
                'field' => 'vill_townprt_code',
                'label' => 'গাওঁ / চহৰ',
                'rules' => 'trim|required|integer|xss_clean|callback_VillCode_check'
            ),
            array(
                'field' => 'lm_note',
                'label' => 'LM Remark',
                'rules' => 'trim|required|xss_clean'
            ),
        );
        $this->form_validation->set_rules($validate);
        $this->form_validation->set_message('integer', 'This %s is not valid');
        $validation = null;
        if ($this->form_validation->run() === FALSE) {
            $this->form_validation->set_error_delimiters('', '');
            foreach ($validate as $rule) {
                if (form_error($rule['field'])) {
                    $validation['error'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
                }
            }
            echo json_encode($validation);
            return;
        }
        
        $lm_note = $this->input->post('lm_note');
        $dist_code = $this->input->post('dist_code');
        $_FILES['file']['type'] = $_FILES['file_upload']['type'];
        $_FILES['file']['tmp_name'] = $_FILES['file_upload']['tmp_name'];
        $_FILES['file']['error'] = $_FILES['file_upload']['error'];
        $_FILES['file']['size'] = $_FILES['file_upload']['size'];
        $ext = pathinfo($_FILES['file_upload']['name'], PATHINFO_EXTENSION);
        if ($_FILES['file']['size'] > MAX_FILE_SIZE) {
            $validation['error'][] = array('field' => 'file_upload',
                'message' => $_FILES['file_upload']['name'] . ' The file you are attempting to upload is larger than the permitted size.');
            $validation['suceess'] = false;
            echo json_encode($validation);
            return;
        }
        $FILES_TYPE_VALIDATION_ARR = explode('|', FILE_TYPE);
        $checkFileExt = false;
        foreach ($FILES_TYPE_VALIDATION_ARR as $file_type) {
            if ($ext == $file_type) {
                $checkFileExt = true;
                break;
            }
        }

        if (!$checkFileExt) {
            $validation['error'][] = array('field' => 'file_upload',
                'message' => $_FILES['file_upload']['name'] . ' Only allowed types ' . FILE_TYPE . '.');
            $validation['suceess'] = false;
            echo json_encode($validation);
            return;
        }

        // $upload_dir = UPLOAD_BASE ."JDDDocs";
        $upload_dir = JUNK_DAGS_DELETE_BASE_DIR;
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        // $config['upload_path'] = UPLOAD_BASE .'JDDDocs/';
        $config['upload_path'] = JUNK_DAGS_DELETE_BASE_DIR.UPLOAD_SEPARATOR;
        $config['allowed_types'] = FILE_TYPE;
        $config['encrypt_name'] = TRUE;
        $config['detect_mime'] = TRUE;
        $config['mod_mime_fix'] = TRUE;
        $config['max_size'] = MAX_FILE_SIZE;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        $this->db->trans_begin();
        $file_upload = $_FILES['file_upload']['name'];
        $file_name = '';
        if ($file_upload !== "") {
            $upload = $this->upload->do_upload('file_upload');
            if($upload != true)
            {
                $this->db->trans_rollback();
                log_message("error", "#JDD1003 File Upload Failed.
                             for dist_code:" . $dist_code . ", generated case no: " . $case_no);
                $validation['validation_suceess'] = true;
                $validation['insert'] = false;
                echo json_encode($validation);
                return;
            }
            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];
        }

        $t_legacyupdation = array(
            'dist_code' => $this->input->post('dist_code'),
            'subdiv_code' => $this->input->post('subdiv_code'),
            'cir_code' => $this->input->post('cir_code'),
            'mouza_pargona_code' => $this->input->post('mouza_pargona_code'),
            'lot_no' => $this->input->post('lot_no'),
            'vill_townprt_code' => $this->input->post('vill_townprt_code'),
            'proposal_no' => $petition_no,
            'case_no' => $case_no,
            'dag_no' => $this->input->post('dag_no'),
            'patta_no' => trim($this->input->post('patta_no')),
            'patta_type_code' => $this->input->post('patta_type_code'),
            'present_land_class' => $this->input->post('land_class'),
            'present_land_revenue' => $this->input->post('land_rev'),
            'present_land_localtax' => $this->input->post('loc_tax'),
            'dag_area_b' => $this->input->post('dag_area_b'),
            'dag_area_k' => $this->input->post('dag_area_k'),
            'dag_area_lc' => $this->input->post('dag_area_lc'),
            'dag_area_g' => round($this->input->post('dag_area_g')),
            'dag_area_kr' => round($this->input->post('dag_area_kr')),
            'suggested_dag_no' => '',
            'suggested_patta_no' => '',
            'suggested_patta_type' => '',
            'suggested_land_class' => '',
            'lm_note' => $lm_note,
            'lm_code' => $this->session->userdata('user_code'),
            'lm_date' => date('Y-m-d G:i:s'),
            'year_no' => year_no,
            'file_upload' => $file_name,
            'status' => '1', //////1 dag delete pending // 2 pass order ////// 0 reject
        );

        $data = $this->db->insert('t_legacyupdation', $t_legacyupdation);
        if ($data == true) {
            if ($this->db->trans_status() == FALSE) {
                $this->db->trans_rollback();
                log_message("error", "#JDD1001 Transaction Failed.
                             for dist_code:" . $dist_code . ", generated case no: " . $case_no);
                $validation['validation_suceess'] = true;
                $validation['insert'] = false;
                echo json_encode($validation);
                return;
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Junk Dag Deletion Case no: ".$case_no.". Successfully Forwarded to Circle Officer.");
                $validation['validation_suceess'] = true;
                $validation['insert'] = true;
                $validation['case_no'] = $case_no;
                echo json_encode($validation);
                return;
            }
        } else {
            $this->db->trans_rollback();
            log_message("error", "#JDD1002 Data cannot be inserted into t_legacyupdation.
                             for dist_code:" . $dist_code . ", generated case no: " . $case_no);
            $validation['validation_suceess'] = true;
            $validation['insert'] = false;
            echo json_encode($validation);
            return;
        }
    }

    function coPendingJDD()
    {
        if(!in_array($this->session->userdata('user_desig_code'), ['CO'])){
            $this->session->set_flashdata('message', 'You are not authorized to perform this action.');
            return redirect($_SERVER['HTTP_REFERER']);
        }
        $db=  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $q = "select * from t_legacyupdation where status =? 
            and co_yn is null and dc_yn is null and dist_code=? and subdiv_code=? and
            cir_code=? ORDER BY proposal_no asc";
        $cases['cases'] = $this->db->query($q,array('1',$dist_code,$subdiv_code,$cir_code))->result();
        $cases['_view'] = 'JunkDagDelete/PendingJunkCases';
        $this->load->view('layouts/main',$cases);
    }

    Public function CoProcess() {
        $db=  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');
        $case_no = $this->input->GET('case_no');
        $proposal_no = $this->input->GET('proposal_no');
        $q = "select * from t_legacyupdation where case_no =? and proposal_no =? and status=? and co_yn is null";
        $result = $this->db->query($q,array($case_no,$proposal_no,'1'));

        if($result->num_rows() == 0)
        {
            $this->session->set_flashdata('message', "Please check case no. Error Code(#JDD1017)");
            redirect(base_url() . "index.php/home");
        }else{
            $details = $data['details'] = $result->row();
        }

        $dist_code = $this->utilityclass->getDistrictName($details->dist_code);
        $subdiv_code = $this->utilityclass->getSubDivName($details->dist_code, $details->subdiv_code);
        $cir_code = $this->utilityclass->getCircleName($details->dist_code, $details->subdiv_code, $details->cir_code);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($details->dist_code, $details->subdiv_code,
            $details->cir_code, $details->mouza_pargona_code);
        $lot_no = $this->utilityclass->getLotName($details->dist_code, $details->subdiv_code,
            $details->cir_code, $details->mouza_pargona_code, $details->lot_no);
        $vill_townprt_code = $this->utilityclass->getVillageName($details->dist_code,
            $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $details->vill_townprt_code);

        $co = $this->utilityclass->getSelectedCOName($details->dist_code, $details->subdiv_code, $details->cir_code, $user_code);
        $data['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code,
            'co_name' => $co->username
        );

        $data['Pcases'] = $details;

        $data['dc_adc'] = $this->db->query("Select users.username as username, users.user_desig_code as user_desig_code, 
            loginuser_table.user_code as user_code from    users, "
            . "loginuser_table where users.dist_code = loginuser_table.dist_code 
            and users.user_code = loginuser_table.user_code and users.user_desig_code like '%ADC' and "
            . "loginuser_table.dist_code='$details->dist_code' and loginuser_table.subdiv_code='00' 
            and loginuser_table.cir_code='00' and loginuser_table.dis_enb_option = 'E' and loginuser_table.priv = 'adm'")->result();


        $dist_code = $details->dist_code;
        $subdiv_code = $details->subdiv_code;
        $circle_code = $details->cir_code;
        $mouza_code = $details->mouza_pargona_code;
        $lot_no = $details->lot_no;
        $vill_code = $details->vill_townprt_code;
        $dag_number = $details->dag_no;
        $patta_number = $details->patta_no;
        $patta_type = $details->patta_type_code;
        /////////chitha_basic//////////
        $data['chitha_basic'] = null;
        $q21 = "select * from chitha_basic where 
            dist_code=? and subdiv_code=? and "
            . "cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? "
            . "and patta_no=? and patta_type_code=? ";

        $q21_result = $this->db->query($q21, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number, $patta_number, $patta_type));
        if ($q21_result->num_rows() > 0) {
            $data['chitha_basic'] = $q21_result->result();
        }

        /////////chitha_dag_pattadar//////////
        $data['cdp'] = null;
        $q1 = "select pdar_id,p_flag,dag_no,patta_no,patta_type_code from chitha_dag_pattadar where 
            dist_code=? and subdiv_code=? and "
            . "cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? "
            . "and patta_no=? and patta_type_code=? ";

        $q1_result = $this->db->query($q1, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number, $patta_number, $patta_type));
        if ($q1_result->num_rows() > 0) {
            $data['cdp'] = $q1_result->result();
        }

        ///////chitha_pattadar/////////////
        $data['cp'] = null;
        $q2 = "select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,pdar_id,pdar_name,pdar_father from chitha_pattadar where 
            dist_code=? and subdiv_code=? and cir_code=? 
            and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? "
            . "and patta_no=? and patta_type_code=? ";
        $q2_result = $this->db->query($q2, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $patta_number, $patta_type));
        if ($q2_result->num_rows() > 0) {
            $data['cp'] = $q2_result->result();
        }

        ////////////chitha_rmk_ordbasic////////
        $data['chitha_rmk_ordbasic'] = null;
        $q3 = "select ord_no,ord_date from chitha_rmk_ordbasic where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q3_result = $this->db->query($q3, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));

        if ($q3_result->num_rows() > 0) {
            $data['chitha_rmk_ordbasic'] = $q3_result->result();
        }

        ////////////chitha_col8_order////////
        $data['chitha_col8_order'] = null;
        $q4 = "select * from chitha_col8_order where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q4_result = $this->db->query($q4, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));

        if ($q4_result->num_rows() > 0) {
            $data['chitha_col8_order'] = $q4_result->result();
        }

        ////////////chitha_col8_inplace////////
        $data['chitha_col8_inplace'] = null;
        $q5 = "select * from chitha_col8_inplace where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q5_result = $this->db->query($q5, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q5_result->num_rows() > 0) {
            $data['chitha_col8_inplace'] = $q5_result->result();
        }

        ////////////chitha_col8_occup////////
        $data['chitha_col8_occup'] = null;
        $q6 = "select * from chitha_col8_occup where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q6_result = $this->db->query($q6, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q6_result->num_rows() > 0) {
            $data['chitha_col8_occup'] = $q6_result->result();
        }

        ////////////chitha_rmk_allottee////////
        $data['chitha_rmk_allottee'] = null;
        $q7 = "select * from chitha_rmk_allottee where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q7_result = $this->db->query($q7, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q7_result->num_rows() > 0) {
            $data['chitha_rmk_allottee'] = $q7_result->result();
        }

        ////////////chitha_rmk_alongwith////////
        $data['chitha_rmk_alongwith'] = null;
        $q8 = "select * from chitha_rmk_alongwith where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q8_result = $this->db->query($q8, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q8_result->num_rows() > 0) {
            $data['chitha_rmk_alongwith'] = $q8_result->result();
        }

        ////////////chitha_rmk_convorder////////
        $data['chitha_rmk_convorder'] = null;
        $q9 = "select * from chitha_rmk_convorder where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q9_result = $this->db->query($q9, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q9_result->num_rows() > 0) {
            $data['chitha_rmk_convorder'] = $q9_result->result();
        }

        ////////////chitha_rmk_encro////////
        $data['chitha_rmk_encro'] = null;
        $q10 = "select * from chitha_rmk_encro where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q10_result = $this->db->query($q10, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q10_result->num_rows() > 0) {
            $data['chitha_rmk_encro'] = $q10_result->result();
        }

        ////////////chitha_rmk_gen////////
        $data['chitha_rmk_gen'] = null;
        $q11 = "select * from chitha_rmk_gen where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q11_result = $this->db->query($q11, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q11_result->num_rows() > 0) {
            $data['chitha_rmk_gen'] = $q11_result->result();
        }

        ////////////chitha_rmk_infavor_of////////
        $data['chitha_rmk_infavor_of'] = null;
        $q12 = "select * from chitha_rmk_infavor_of where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q12_result = $this->db->query($q12, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q12_result->num_rows() > 0) {
            $data['chitha_rmk_infavor_of'] = $q12_result->result();
        }

        ////////////chitha_rmk_inplace_of////////
        $data['chitha_rmk_inplace_of'] = null;
        $q13 = "select * from chitha_rmk_inplace_of where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q13_result = $this->db->query($q13, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q13_result->num_rows() > 0) {
            $data['chitha_rmk_inplace_of'] = $q13_result->result();
        }

        ////////////chitha_rmk_lmnote////////
        $data['chitha_rmk_lmnote'] = null;
        $q14 = "select * from chitha_rmk_lmnote where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q14_result = $this->db->query($q14, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q14_result->num_rows() > 0) {
            $data['chitha_rmk_lmnote'] = $q14_result->result();
        }

        ////////////chitha_rmk_onbehalf////////
        $data['chitha_rmk_onbehalf'] = null;
        $q15 = "select * from chitha_rmk_onbehalf where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q15_result = $this->db->query($q15, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q15_result->num_rows() > 0) {
            $data['chitha_rmk_onbehalf'] = $q15_result->result();
        }

        ////////////chitha_rmk_other_opp_party////////
        $data['chitha_rmk_other_opp_party'] = null;
        $q16 = "select * from chitha_rmk_other_opp_party where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q16_result = $this->db->query($q16, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q16_result->num_rows() > 0) {
            $data['chitha_rmk_other_opp_party'] = $q16_result->result();
        }

        ////////////chitha_rmk_reclassification////////
        $data['chitha_rmk_reclassification'] = null;
        $q17 = "select * from chitha_rmk_reclassification where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q17_result = $this->db->query($q17, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q17_result->num_rows() > 0) {
            $data['chitha_rmk_reclassification'] = $q17_result->result();
        }

        $data['_view'] = 'JunkDagDelete/CoProcess';
        $this->load->view('layouts/main',$data);
    }

    /////////save co process//////////////////////
    public function SaveCoProcess() {
        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $proposal_no = $this->input->POST('proposal_no');
        $case_no = $this->input->POST('case_no');
        $final_report = $this->input->POST('final_report');
        $reject_report = $this->input->POST('reject_report');
        $co_code = $this->session->userdata('user_code');
        $co_date_entry = date('Y-m-d G:i:s');

        $order_type = $this->input->POST('order_type');

        $json = array();
        $json['validation_suceess'] = null;
        $json['update'] = null;
        $json['msg'] = null;

        $validate = array(
            array(
                'field' => 'case_no',
                'label' => 'Case No',
                'rules' => 'trim|required|callback_Case_check',
            ),
            array(
                'field' => 'proposal_no',
                'label' => 'Proposal No',
                'rules' => 'trim|required|callback_Case_check',
            ),
            array(
                'field' => 'order_type',
                'label' => 'Order Type',
                'rules' => 'trim|required|xss_clean'
            ),
        );

        if($this->input->post('order_type') == 'forward_to_dc')
        {
            $arr = array(
                'field' => 'final_report',
                'label' => 'Circle Officer(s) Note',
                'rules' => 'trim|required|xss_clean'
            );
            array_push($validate,$arr);

            $arr1 = array(
                'field' => 'dc_code',
                'label' => 'DC/ADC',
                'rules' => 'trim|required|xss_clean',
            );
            array_push($validate,$arr1);
        }
        elseif($this->input->post('order_type') == 'reject')
        {
            $arr = array(
                'field' => 'reject_report',
                'label' => 'Circle Officer(s) Note',
                'rules' => 'trim|required|xss_clean'
            );
            array_push($validate,$arr);
        }


        $this->form_validation->set_rules($validate);
        if ($this->form_validation->run() === FALSE) {
            $this->form_validation->set_error_delimiters('', '');
            foreach ($validate as $rule) {
                if (form_error($rule['field'])) {
                    $json['error'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
                }
            }
            echo json_encode($json);
            return;
        }

        if ($order_type == 'forward_to_dc') {
            $dc_adc_code = $this->input->POST('dc_code');
            $update = $this->db->query("UPDATE t_legacyupdation SET co_yn = 'Y', co_note = '$final_report', 
                co_orddate = '$co_date_entry', co_code = '$co_code', dc_adc_code = '$dc_adc_code' "
                . "WHERE case_no = '$case_no' and proposal_no = '$proposal_no'");

            if($this->db->affected_rows() != 1)
            {
                log_message("error", "#JDD1011 Data cannot be updated (t_legacyupdation)
                             for dist_code:" . $dist_code . ", case no: " . $case_no);

                $this->session->set_flashdata('message', "Order Not Successful. Error Code(#JDD1011)");
                $json['validation_suceess'] = true;
                $json['update'] = false;
                $json['msg'] = "Order Not Successful. Error Code(#JDD1011)";
                echo json_encode($json);
                return;
            }
            $this->session->set_flashdata('message', "Junk Dag Deletion Case no: ".$case_no." Forwarded to DC/ADC after verification.");
            $json['validation_suceess'] = true;
            $json['update'] = true;
            $json['msg'] = "Junk Dag Deletion Case no: ".$case_no." Forwarded to DC/ADC after verification.";
            echo json_encode($json);
            return;

        } elseif ($order_type == 'reject') {
            $update = $this->db->query("UPDATE t_legacyupdation SET status = '0', status_date = '$co_date_entry',
                co_yn = 'Y', co_note = '$reject_report', co_orddate = '$co_date_entry', "
                . "co_code = '$co_code' WHERE case_no = '$case_no' and  proposal_no = '$proposal_no'");

            if($this->db->affected_rows() != 1)
            {
                log_message("error", "#JDD1012 Data cannot be updated (t_legacyupdation)
                             for dist_code:" . $dist_code . ", case no: " . $case_no);
                $this->session->set_flashdata('message', "Order Not Successful. Error Code(#JDD1012)");
                $json['validation_suceess'] = true;
                $json['update'] = false;
                $json['msg'] = "Order Not Successful. Error Code (#JDD1012).";
                echo json_encode($json);
                return;
            }
            $this->session->set_flashdata('message', "Junk Dag Deletion Case no: ".$case_no." Successfully Rejected.");
            $json['validation_suceess'] = true;
            $json['update'] = true;
            $json['msg'] = "Junk Dag Deletion Case no: ".$case_no." Successfully Rejected.";
            echo json_encode($json);
            return;
        }
    }


    //////////DC / ADC PENDING //////////////
    function dcadcPendingJDD()
    {
        if(!in_array($this->session->userdata('user_desig_code'), ['DC','ADC'])){
            $this->session->set_flashdata('message', 'You are not authorized to perform this action.');
            return redirect($_SERVER['HTTP_REFERER']);
        }
        $db=  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $q = "select * from t_legacyupdation where status =? 
            and co_yn=? and dc_yn is null and dist_code=? ORDER BY proposal_no asc";
        $cases['cases'] = $this->db->query($q,array('1','Y',$dist_code))->result();

        $cases['_view'] = 'JunkDagDelete/PendingJunkCases';
        $this->load->view('layouts/main',$cases);
    }

    ////////////// DC / ADC View ////////
    function DcAdcProcess()
    {
        $db=  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');
        $case_no = $this->input->GET('case_no');
        $proposal_no = $this->input->GET('proposal_no');

        $q = "select * from t_legacyupdation where case_no =? and proposal_no =? and co_yn=? and status=?";
        $result = $this->db->query($q,array($case_no,$proposal_no,'Y','1'));

        if($result->num_rows() == 0)
        {
            $this->session->set_flashdata('message', "Please check case no. Error Code(#JDD1017)");
            redirect(base_url() . "index.php/home");
        }else{
            $details = $data['details'] = $result->row();
        }

        $dist_code = $this->utilityclass->getDistrictName($details->dist_code);
        $subdiv_code = $this->utilityclass->getSubDivName($details->dist_code, $details->subdiv_code);
        $cir_code = $this->utilityclass->getCircleName($details->dist_code, $details->subdiv_code, $details->cir_code);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($details->dist_code, $details->subdiv_code,
            $details->cir_code, $details->mouza_pargona_code);
        $lot_no = $this->utilityclass->getLotName($details->dist_code, $details->subdiv_code,
            $details->cir_code, $details->mouza_pargona_code, $details->lot_no);
        $vill_townprt_code = $this->utilityclass->getVillageName($details->dist_code,
            $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $details->vill_townprt_code);

        $dc_adc = $this->db->query("select username,user_code from users where dist_code=? and  user_code=?",array($details->dist_code,$user_code))->row();
        $data['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code,
            'dc_adc_name' => $dc_adc->username
        );

        $data['Pcases'] = $details;

        $data['dc_adc'] = $this->db->query("Select users.username as username, users.user_desig_code as user_desig_code, loginuser_table.user_code as user_code from    users, "
            . "loginuser_table where users.dist_code = loginuser_table.dist_code and users.user_code = loginuser_table.user_code and users.user_desig_code like '%DC' and "
            . "loginuser_table.dist_code='$details->dist_code' and loginuser_table.subdiv_code='00' and loginuser_table.cir_code='00' and loginuser_table.dis_enb_option = 'E' and loginuser_table.priv = 'adm'")->result();

        $dist_code = $details->dist_code;
        $subdiv_code = $details->subdiv_code;
        $circle_code = $details->cir_code;
        $mouza_code = $details->mouza_pargona_code;
        $lot_no = $details->lot_no;
        $vill_code = $details->vill_townprt_code;
        $dag_number = $details->dag_no;
        $patta_number = $details->patta_no;
        $patta_type = $details->patta_type_code;
        /////////chitha_basic//////////
        $data['chitha_basic'] = null;
        $q21 = "select * from chitha_basic where 
            dist_code=? and subdiv_code=? and "
            . "cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? "
            . "and patta_no=? and patta_type_code=? ";

        $q21_result = $this->db->query($q21, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number, $patta_number, $patta_type));
        if ($q21_result->num_rows() > 0) {
            $data['chitha_basic'] = $q21_result->result();
        }

        /////////chitha_dag_pattadar//////////
        $data['cdp'] = null;
        $q1 = "select pdar_id,p_flag,dag_no,patta_no,patta_type_code from chitha_dag_pattadar where 
            dist_code=? and subdiv_code=? and "
            . "cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? "
            . "and patta_no=? and patta_type_code=? ";

        $q1_result = $this->db->query($q1, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number, $patta_number, $patta_type));
        if ($q1_result->num_rows() > 0) {
            $data['cdp'] = $q1_result->result();
        }

        ///////chitha_pattadar/////////////
        $data['cp'] = null;
        $q2 = "select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,pdar_id,pdar_name,pdar_father from chitha_pattadar where 
            dist_code=? and subdiv_code=? and cir_code=? 
            and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? "
            . "and patta_no=? and patta_type_code=? ";
        $q2_result = $this->db->query($q2, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $patta_number, $patta_type));
        if ($q2_result->num_rows() > 0) {
            $data['cp'] = $q2_result->result();
        }

        ////////////chitha_rmk_ordbasic////////
        $data['chitha_rmk_ordbasic'] = null;
        $q3 = "select ord_no,ord_date from chitha_rmk_ordbasic where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q3_result = $this->db->query($q3, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));

        if ($q3_result->num_rows() > 0) {
            $data['chitha_rmk_ordbasic'] = $q3_result->result();
        }

        ////////////chitha_col8_order////////
        $data['chitha_col8_order'] = null;
        $q4 = "select * from chitha_col8_order where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q4_result = $this->db->query($q4, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));

        if ($q4_result->num_rows() > 0) {
            $data['chitha_col8_order'] = $q4_result->result();
        }

        ////////////chitha_col8_inplace////////
        $data['chitha_col8_inplace'] = null;
        $q5 = "select * from chitha_col8_inplace where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q5_result = $this->db->query($q5, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q5_result->num_rows() > 0) {
            $data['chitha_col8_inplace'] = $q5_result->result();
        }

        ////////////chitha_col8_occup////////
        $data['chitha_col8_occup'] = null;
        $q6 = "select * from chitha_col8_occup where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q6_result = $this->db->query($q6, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q6_result->num_rows() > 0) {
            $data['chitha_col8_occup'] = $q6_result->result();
        }

        ////////////chitha_rmk_allottee////////
        $data['chitha_rmk_allottee'] = null;
        $q7 = "select * from chitha_rmk_allottee where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q7_result = $this->db->query($q7, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q7_result->num_rows() > 0) {
            $data['chitha_rmk_allottee'] = $q7_result->result();
        }

        ////////////chitha_rmk_alongwith////////
        $data['chitha_rmk_alongwith'] = null;
        $q8 = "select * from chitha_rmk_alongwith where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q8_result = $this->db->query($q8, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q8_result->num_rows() > 0) {
            $data['chitha_rmk_alongwith'] = $q8_result->result();
        }

        ////////////chitha_rmk_convorder////////
        $data['chitha_rmk_convorder'] = null;
        $q9 = "select * from chitha_rmk_convorder where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q9_result = $this->db->query($q9, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q9_result->num_rows() > 0) {
            $data['chitha_rmk_convorder'] = $q9_result->result();
        }

        ////////////chitha_rmk_encro////////
        $data['chitha_rmk_encro'] = null;
        $q10 = "select * from chitha_rmk_encro where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q10_result = $this->db->query($q10, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q10_result->num_rows() > 0) {
            $data['chitha_rmk_encro'] = $q10_result->result();
        }

        ////////////chitha_rmk_gen////////
        $data['chitha_rmk_gen'] = null;
        $q11 = "select * from chitha_rmk_gen where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q11_result = $this->db->query($q11, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q11_result->num_rows() > 0) {
            $data['chitha_rmk_gen'] = $q11_result->result();
        }

        ////////////chitha_rmk_infavor_of////////
        $data['chitha_rmk_infavor_of'] = null;
        $q12 = "select * from chitha_rmk_infavor_of where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q12_result = $this->db->query($q12, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q12_result->num_rows() > 0) {
            $data['chitha_rmk_infavor_of'] = $q12_result->result();
        }

        ////////////chitha_rmk_inplace_of////////
        $data['chitha_rmk_inplace_of'] = null;
        $q13 = "select * from chitha_rmk_inplace_of where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q13_result = $this->db->query($q13, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q13_result->num_rows() > 0) {
            $data['chitha_rmk_inplace_of'] = $q13_result->result();
        }

        ////////////chitha_rmk_lmnote////////
        $data['chitha_rmk_lmnote'] = null;
        $q14 = "select * from chitha_rmk_lmnote where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q14_result = $this->db->query($q14, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q14_result->num_rows() > 0) {
            $data['chitha_rmk_lmnote'] = $q14_result->result();
        }

        ////////////chitha_rmk_onbehalf////////
        $data['chitha_rmk_onbehalf'] = null;
        $q15 = "select * from chitha_rmk_onbehalf where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q15_result = $this->db->query($q15, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q15_result->num_rows() > 0) {
            $data['chitha_rmk_onbehalf'] = $q15_result->result();
        }

        ////////////chitha_rmk_other_opp_party////////
        $data['chitha_rmk_other_opp_party'] = null;
        $q16 = "select * from chitha_rmk_other_opp_party where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q16_result = $this->db->query($q16, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q16_result->num_rows() > 0) {
            $data['chitha_rmk_other_opp_party'] = $q16_result->result();
        }

        ////////////chitha_rmk_reclassification////////
        $data['chitha_rmk_reclassification'] = null;
        $q17 = "select * from chitha_rmk_reclassification where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q17_result = $this->db->query($q17, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        if ($q17_result->num_rows() > 0) {
            $data['chitha_rmk_reclassification'] = $q17_result->result();
        }

        $data['_view'] = 'JunkDagDelete/DcAdcProcess';
        $this->load->view('layouts/main',$data);
    }

    ///////////ADC/DC ORDER PASS //////////
    // public function SaveDCProcess() {
    //     $db=  $this->session->userdata('db');
    //     $dist_code = $this->session->userdata('dist_code');
    //     $proposal_no = $this->input->POST('proposal_no');
    //     $case_no = $this->input->POST('case_no');
    //     $final_report = $this->input->POST('final_report');
    //     $reject_report = $this->input->POST('reject_report');
    //     $dc_code = $this->session->userdata('user_code');
    //     $dc_date_entry = date('Y-m-d G:i:s');
    //     $order_type = $this->input->POST('order_type');

    //     $validate = array(
    //         array(
    //             'field' => 'case_no',
    //             'label' => 'Case No',
    //             'rules' => 'trim|required|callback_Case_check',
    //         ),
    //         array(
    //             'field' => 'proposal_no',
    //             'label' => 'Proposal No',
    //             'rules' => 'trim|required|callback_Case_check',
    //         ),
    //         array(
    //             'field' => 'order_type',
    //             'label' => 'Order Type',
    //             'rules' => 'trim|required|xss_clean'
    //         ),
    //     );

    //     if($this->input->post('order_type') == 'final_order')
    //     {
    //         $arr = array(
    //             'field' => 'final_report',
    //             'label' => 'DC/ADC Note',
    //             'rules' => 'trim|required|xss_clean'
    //         );
    //         array_push($validate,$arr);
    //     }
    //     elseif($this->input->post('order_type') == 'reject')
    //     {
    //         $arr = array(
    //             'field' => 'reject_report',
    //             'label' => 'DC/ADC Note',
    //             'rules' => 'trim|required|xss_clean'
    //         );
    //         array_push($validate,$arr);
    //     }

    //     $json = null;
    //     $this->form_validation->set_rules($validate);
    //     if ($this->form_validation->run() === FALSE) {
    //         $this->form_validation->set_error_delimiters('', '');
    //         foreach ($validate as $rule) {
    //             if (form_error($rule['field'])) {
    //                 $json .= '<li>'.form_error($rule['field']). '</li>';
    //             }
    //         }
    //         $this->session->set_flashdata('message', $json);
    //         redirect($_SERVER['HTTP_REFERER']);
    //         return;
    //     }

    //     $case = $this->db->query("select * from t_legacyupdation where case_no =? 
    //         and proposal_no =? and co_yn=? and status=?",
    //     array($case_no,$proposal_no,'Y','1'));
    //     if($case->num_rows() == 0)
    //     {
    //         $this->session->set_flashdata('message', "Please check case no. Error Code (#JDD1016)");
    //         redirect(base_url() . "index.php/home");
    //     }

    //     $this->db->trans_begin();
    //     if ($order_type == 'final_order') {
    //         $update = $this->db->query("UPDATE t_legacyupdation SET dc_yn = 'Y',status = '2', dc_adc_note = '$final_report', 
    //             dc_adc_orddate = '$dc_date_entry', dc_adc_code = '$dc_code' "
    //             . "WHERE case_no = '$case_no' and proposal_no = '$proposal_no'");

    //         if($this->db->affected_rows() != 1)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1015 Data cannot be updated (t_legacyupdation)
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Order Not Successful. Error Code (#JDD1015)");
    //             redirect(base_url() . "index.php/home");
    //         }

    //     } elseif ($order_type == 'reject') {
    //         $update = $this->db->query("UPDATE t_legacyupdation SET dc_yn = 'Y', status = '0', status_date = '$dc_date_entry',
    //             dc_adc_note = '$reject_report', dc_adc_orddate = '$dc_date_entry', "
    //             . "dc_adc_code = '$dc_code' WHERE case_no = '$case_no' and  proposal_no = '$proposal_no'");

    //         if($this->db->affected_rows() != 1)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1016 Data cannot be updated (t_legacyupdation)
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Order Not Successful. Error Code (#JDD1016).");
    //             redirect(base_url() . "index.php/home");
    //         }
    //         $this->db->trans_commit();
    //         $this->session->set_flashdata('message', "Junk Dag Deletion Case no: ".$case_no.". Successfully Rejected.");
    //         redirect(base_url() . "index.php/home");
    //         return;
    //     }

    //     $dist_code = $case->row()->dist_code;
    //     $subdiv_code = $case->row()->subdiv_code;
    //     $circle_code = $case->row()->cir_code;
    //     $mouza_code = $case->row()->mouza_pargona_code;
    //     $lot_no = $case->row()->lot_no;
    //     $vill_code = $case->row()->vill_townprt_code;
    //     $dag_number = $case->row()->dag_no;
    //     $patta_number = $case->row()->patta_no;
    //     $patta_type = $case->row()->patta_type_code;

    //     ////////////chitha_rmk_ordbasic////////
    //     $q3 = "select count(*) as c from chitha_rmk_ordbasic where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q3_result = $this->db->query($q3, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q3_result->row()->c > 0) {
    //         $this->db->delete('chitha_rmk_ordbasic',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));

    //         if($this->db->affected_rows() != $q3_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1054 Delete failed, Unable to delete data from chitha_rmk_ordbasic
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code(#JDD1054)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////t_chitha_rmk_ordbasic////////
    //     $q53 = "select count(*) as c from t_chitha_rmk_ordbasic where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q53_result = $this->db->query($q53, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));

    //     if ($q53_result->row()->c > 0) {
    //         $this->db->delete('t_chitha_rmk_ordbasic',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q53_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1081 Delete failed, Unable to delete data from t_chitha_rmk_ordbasic
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1081)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }


    //     ////////////chitha_col8_inplace////////
    //     $q5 = "select count(*) as c from chitha_col8_inplace where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q5_result = $this->db->query($q5, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q5_result->row()->c > 0) {
    //         $this->db->delete('chitha_col8_inplace',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q5_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1056 Delete failed, Unable to delete data from chitha_col8_inplace
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code(#JDD1056)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////t_chitha_col8_inplace////////
    //     $q55 = "select count(*) as c from t_chitha_col8_inplace where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q55_result = $this->db->query($q55, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q55_result->row()->c > 0) {
    //         $this->db->delete('t_chitha_col8_inplace',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q55_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1071 Delete failed, Unable to delete data from t_chitha_col8_inplace
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1071)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////chitha_col8_occup////////
    //     $q6 = "select count(*) as c from chitha_col8_occup where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q6_result = $this->db->query($q6, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q6_result->row()->c > 0) {
    //         $this->db->delete('chitha_col8_occup',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q6_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1057 Delete failed, Unable to delete data from chitha_col8_occup
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code(#JDD1057)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////t_chitha_col8_occup////////
    //     $q56 = "select count(*) as c from t_chitha_col8_occup where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q56_result = $this->db->query($q56, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q56_result->row()->c > 0) {
    //         $this->db->delete('t_chitha_col8_occup',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q56_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1073 Delete failed, Unable to delete data from t_chitha_col8_occup
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1073)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////chitha_col8_order////////
    //     $q4 = "select count(*) as c from chitha_col8_order where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q4_result = $this->db->query($q4, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));

    //     if ($q4_result->row()->c > 0) {
    //         $this->db->delete('chitha_col8_order',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));

    //         if($this->db->affected_rows() != $q4_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1055 Delete failed, Unable to delete data from chitha_col8_order
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code(#JDD1055)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////t_chitha_col8_order////////
    //     $q54 = "select count(*) as c from t_chitha_col8_order where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q54_result = $this->db->query($q54, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));

    //     if ($q54_result->row()->c > 0) {
    //         $this->db->delete('t_chitha_col8_order',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q54_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1070 Delete failed, Unable to delete data from t_chitha_col8_order
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1070)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////chitha_rmk_allottee////////
    //     $q7 = "select count(*) as c from chitha_rmk_allottee where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q7_result = $this->db->query($q7, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q7_result->row()->c > 0) {
    //         $this->db->delete('chitha_rmk_allottee',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q7_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1058 Delete failed, Unable to delete data from chitha_rmk_allottee
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code(#JDD1058)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////t_chitha_rmk_allottee////////
    //     $q57 = "select count(*) as c from t_chitha_rmk_allottee where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q57_result = $this->db->query($q57, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q57_result->row()->c > 0) {
    //         $this->db->delete('t_chitha_rmk_allottee',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q57_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1074 Delete failed, Unable to delete data from t_chitha_rmk_allottee
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1074)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////chitha_rmk_alongwith////////
    //     $q8 = "select count(*) as c from chitha_rmk_alongwith where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q8_result = $this->db->query($q8, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q8_result->row()->c > 0) {
    //         $this->db->delete('chitha_rmk_alongwith',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q8_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1059 Delete failed, Unable to delete data from chitha_rmk_alongwith
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code(#JDD1059)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////t_chitha_rmk_alongwith////////
    //     $q58 = "select count(*) as c from t_chitha_rmk_alongwith where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q58_result = $this->db->query($q58, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q58_result->row()->c > 0) {
    //         $this->db->delete('t_chitha_rmk_alongwith',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q58_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1075 Delete failed, Unable to delete data from t_chitha_rmk_alongwith
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1075)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////chitha_rmk_convorder////////
    //     $q9 = "select count(*) as c from chitha_rmk_convorder where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q9_result = $this->db->query($q9, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q9_result->row()->c > 0) {
    //         $this->db->delete('chitha_rmk_convorder',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q9_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1060 Delete failed, Unable to delete data from chitha_rmk_convorder
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1060)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////t_chitha_rmk_convorder////////
    //     $q59 = "select count(*) as c from t_chitha_rmk_convorder where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q59_result = $this->db->query($q59, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q59_result->row()->c > 0) {
    //         $this->db->delete('t_chitha_rmk_convorder',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q59_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1076 Delete failed, Unable to delete data from t_chitha_rmk_convorder
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1076)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////chitha_rmk_encro////////
    //     $q10 = "select count(*) as c from chitha_rmk_encro where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q10_result = $this->db->query($q10, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q10_result->row()->c > 0) {
    //         $this->db->delete('chitha_rmk_encro',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q10_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1061 Delete failed, Unable to delete data from chitha_rmk_encro
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1061)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////chitha_rmk_gen////////
    //     $q11 = "select count(*) as c from chitha_rmk_gen where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q11_result = $this->db->query($q11, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q11_result->row()->c > 0) {
    //         $this->db->delete('chitha_rmk_gen',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q11_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1062 Delete failed, Unable to delete data from chitha_rmk_gen
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1062)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////chitha_rmk_infavor_of////////
    //     $q12 = "select count(*) as c from chitha_rmk_infavor_of where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q12_result = $this->db->query($q12, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q12_result->row()->c > 0) {
    //         $this->db->delete('chitha_rmk_infavor_of',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q12_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1063 Delete failed, Unable to delete data from chitha_rmk_infavor_of
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1063)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////t_chitha_rmk_infavor_of////////
    //     $q512 = "select count(*) as c from t_chitha_rmk_infavor_of where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q512_result = $this->db->query($q512, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q512_result->row()->c > 0) {
    //         $this->db->delete('t_chitha_rmk_infavor_of',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q512_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1077 Delete failed, Unable to delete data from t_chitha_rmk_infavor_of
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1077)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////chitha_rmk_inplace_of////////
    //     $q13 = "select count(*) as c from chitha_rmk_inplace_of where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q13_result = $this->db->query($q13, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q13_result->row()->c > 0) {
    //         $this->db->delete('chitha_rmk_inplace_of',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q13_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1064 Delete failed, Unable to delete data from chitha_rmk_inplace_of
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1064)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////t_chitha_rmk_inplace_of////////
    //     $q513 = "select count(*) as c from t_chitha_rmk_inplace_of where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q513_result = $this->db->query($q513, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q513_result->row()->c > 0) {
    //         $this->db->delete('t_chitha_rmk_inplace_of',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q513_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1078 Delete failed, Unable to delete data from t_chitha_rmk_inplace_of
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1078)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////chitha_rmk_lmnote////////
    //     $q14 = "select count(*) as c from chitha_rmk_lmnote where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q14_result = $this->db->query($q14, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q14_result->row()->c > 0) {
    //         $this->db->delete('chitha_rmk_lmnote',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q14_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1065 Delete failed, Unable to delete data from chitha_rmk_lmnote
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1065)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////chitha_rmk_onbehalf////////
    //     $q15 = "select count(*) as c from chitha_rmk_onbehalf where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q15_result = $this->db->query($q15, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q15_result->row()->c > 0) {
    //         $this->db->delete('chitha_rmk_onbehalf',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q15_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1066 Delete failed, Unable to delete data from chitha_rmk_onbehalf
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1066)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////t_chitha_rmk_onbehalf////////
    //     $q515 = "select count(*) as c from t_chitha_rmk_onbehalf where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q515_result = $this->db->query($q515, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q515_result->row()->c > 0) {
    //         $this->db->delete('t_chitha_rmk_onbehalf',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q515_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1079 Delete failed, Unable to delete data from t_chitha_rmk_onbehalf
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1079)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////chitha_rmk_other_opp_party////////
    //     $q16 = "select count(*) as c from chitha_rmk_other_opp_party where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q16_result = $this->db->query($q16, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q16_result->row()->c > 0) {
    //         $this->db->delete('chitha_rmk_other_opp_party',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q16_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1067 Delete failed, Unable to delete data from chitha_rmk_other_opp_party
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1067)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////t_chitha_rmk_other_opp_party////////
    //     $q516 = "select count(*) as c from t_chitha_rmk_other_opp_party where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q516_result = $this->db->query($q516, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q516_result->row()->c > 0) {
    //         $this->db->delete('t_chitha_rmk_other_opp_party',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q516_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1080 Delete failed, Unable to delete data from t_chitha_rmk_other_opp_party
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1080)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////chitha_rmk_reclassification////////
    //     $q17 = "select count(*) as c from chitha_rmk_reclassification where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q17_result = $this->db->query($q17, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q17_result->row()->c > 0) {
    //         $this->db->delete('chitha_rmk_reclassification',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q17_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1068 Delete failed, Unable to delete data from chitha_rmk_reclassification
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1068)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////t_reclassification////////
    //     $q517 = "select count(*) as c from t_reclassification where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q517_result = $this->db->query($q517, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q517_result->row()->c > 0) {
    //         $this->db->delete('t_reclassification',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q517_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1083 Delete failed, Unable to delete data from t_reclassification
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1083)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////chitha_tenant////////
    //     $q31 = "select count(*) as c from chitha_tenant where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q31_result = $this->db->query($q31, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q31_result->row()->c > 0) {
    //         $this->db->delete('chitha_tenant',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q31_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1081 Delete failed, Unable to delete data from chitha_tenant
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1081)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////chitha_subtenant////////
    //     $q32 = "select count(*) as c from chitha_subtenant where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q32_result = $this->db->query($q32, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q32_result->row()->c > 0) {
    //         $this->db->delete('chitha_subtenant',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q32_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1082 Delete failed, Unable to delete data from chitha_subtenant
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1082)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////jama_dag////////
    //     $q33 = "select count(*) as c from jama_dag where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q33_result = $this->db->query($q33, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q33_result->row()->c > 0) {
    //         $this->db->delete('jama_dag',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q33_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1083 Delete failed, Unable to delete data from jama_dag
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1083)");
    //             redirect(base_url() . "index.php/home");
    //         }

    //         //////////check multiple dag////////
    //         $q34 = "select count(*) as c from jama_dag where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? 
    //         and dag_no !=? and patta_no=? and patta_type_code=?";
    //         $q34_result = $this->db->query($q34, array($dist_code, $subdiv_code,
    //             $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number, $patta_number,$patta_type));
    //         if ($q34_result->row()->c == 0) {
    //             ///////Delete jama_patta///////////
    //             $q35 = "select count(*) as c from jama_patta where 
    //                 dist_code=? and subdiv_code=? and cir_code=? and 
    //                 mouza_pargona_code=? and lot_no=? and vill_townprt_code=? 
    //                 and patta_no=? and patta_type_code=?";
    //             $q35_result = $this->db->query($q35, array($dist_code, $subdiv_code,
    //                         $circle_code, $mouza_code, $lot_no, $vill_code,
    //                         $patta_number,$patta_type));
    //             if ($q35_result->row()->c > 0) {
    //                 $this->db->delete('jama_patta',
    //                     array('dist_code' => $dist_code,
    //                         'subdiv_code' => $subdiv_code,
    //                         'cir_code' => $circle_code,
    //                         'mouza_pargona_code' => $mouza_code,
    //                         'lot_no' => $lot_no,
    //                         'vill_townprt_code' => $vill_code,
    //                         'patta_no' => $patta_number,
    //                         'patta_type_code' => $patta_type));
    //                 if ($this->db->affected_rows() != $q35_result->row()->c) {
    //                     $this->db->trans_rollback();
    //                     log_message("error", "#JDD1084 Delete failed, Unable to delete data from jama_patta
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //                     $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1084)");
    //                     redirect(base_url() . "index.php/home");
    //                 }
    //             }

    //             ///////Delete jama_pattadar///////////
    //             $q36 = "select count(*) as c from jama_pattadar where 
    //                 dist_code=? and subdiv_code=? and cir_code=? and 
    //                 mouza_pargona_code=? and lot_no=? and vill_townprt_code=? 
    //                 and patta_no=? and patta_type_code=?";
    //             $q36_result = $this->db->query($q36, array($dist_code, $subdiv_code,
    //                 $circle_code, $mouza_code, $lot_no, $vill_code, $patta_number,$patta_type));
    //             if ($q36_result->row()->c > 0) {
    //                 $this->db->delete('jama_pattadar',
    //                     array('dist_code' => $dist_code,
    //                         'subdiv_code' => $subdiv_code,
    //                         'cir_code' => $circle_code,
    //                         'mouza_pargona_code' => $mouza_code,
    //                         'lot_no' => $lot_no,
    //                         'vill_townprt_code' => $vill_code,
    //                         'patta_no' => $patta_number,
    //                         'patta_type_code' => $patta_type));
    //                 if ($this->db->affected_rows() != $q36_result->row()->c) {
    //                     $this->db->trans_rollback();
    //                     log_message("error", "#JDD1085 Delete failed, Unable to delete data from jama_pattadar
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //                     $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1085)");
    //                     redirect(base_url() . "index.php/home");
    //                 }
    //             }

    //             ///////Delete jama_remark///////////
    //             $q37 = "select count(*) as c from jama_remark where 
    //                 dist_code=? and subdiv_code=? and cir_code=? and 
    //                 mouza_pargona_code=? and lot_no=? and vill_townprt_code=? 
    //                 and patta_no=? and patta_type_code=?";
    //             $q37_result = $this->db->query($q37, array($dist_code, $subdiv_code,
    //                 $circle_code, $mouza_code, $lot_no, $vill_code, $patta_number,$patta_type));
    //             if ($q37_result->row()->c > 0) {
    //                 $this->db->delete('jama_remark',
    //                     array('dist_code' => $dist_code,
    //                         'subdiv_code' => $subdiv_code,
    //                         'cir_code' => $circle_code,
    //                         'mouza_pargona_code' => $mouza_code,
    //                         'lot_no' => $lot_no,
    //                         'vill_townprt_code' => $vill_code,
    //                         'patta_no' => $patta_number,
    //                         'patta_type_code' => $patta_type));
    //                 if ($this->db->affected_rows() != $q37_result->row()->c) {
    //                     $this->db->trans_rollback();
    //                     log_message("error", "#JDD1086 Delete failed, Unable to delete data from jama_remark
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //                     $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1086)");
    //                     redirect(base_url() . "index.php/home");
    //                 }
    //             }
    //         }
    //     }

    //     ////////////apcancel_dag_details////////
    //     $q41 = "select count(*) as c from apcancel_dag_details where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q41_result = $this->db->query($q41, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q41_result->row()->c > 0) {
    //         $this->db->delete('apcancel_dag_details',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q41_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1121 Delete failed, Unable to delete data from apcancel_dag_details
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1121)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////apcancel_petition_pattadar////////
    //     $q42 = "select count(*) as c from apcancel_petition_pattadar where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q42_result = $this->db->query($q42, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q42_result->row()->c > 0) {
    //         $this->db->delete('apcancel_petition_pattadar',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q42_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1122 Delete failed, Unable to delete data from apcancel_petition_pattadar
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1122)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////apt_chitha_rmk_ordbasic////////
    //     $q43 = "select count(*) as c from apt_chitha_rmk_ordbasic where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q43_result = $this->db->query($q43, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q43_result->row()->c > 0) {
    //         $this->db->delete('apt_chitha_rmk_ordbasic',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q43_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1123 Delete failed, Unable to delete data from apt_chitha_rmk_ordbasic
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1123)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////apt_chitha_rmk_other////////
    //     $q44 = "select count(*) as c from apt_chitha_rmk_other where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q44_result = $this->db->query($q44, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q44_result->row()->c > 0) {
    //         $this->db->delete('apt_chitha_rmk_other',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q44_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1124 Delete failed, Unable to delete data from apt_chitha_rmk_other
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1124)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////chitha_fruit////////
    //     $q45 = "select count(*) as c from chitha_fruit where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q45_result = $this->db->query($q45, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q45_result->row()->c > 0) {
    //         $this->db->delete('chitha_fruit',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q45_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1125 Delete failed, Unable to delete data from chitha_fruit
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1125)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////chitha_noncrop////////
    //     $q46 = "select count(*) as c from chitha_noncrop where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q46_result = $this->db->query($q46, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q46_result->row()->c > 0) {
    //         $this->db->delete('chitha_noncrop',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q46_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1126 Delete failed, Unable to delete data from chitha_noncrop
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1126)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////chitha_rmk_sknote////////
    //     $q47 = "select count(*) as c from chitha_rmk_sknote where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q47_result = $this->db->query($q47, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q47_result->row()->c > 0) {
    //         $this->db->delete('chitha_rmk_sknote',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q47_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1127 Delete failed, Unable to delete data from chitha_rmk_sknote
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1127)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////field_part_petitioner////////
    //     $q48 = "select count(*) as c from field_part_petitioner where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q48_result = $this->db->query($q48, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q48_result->row()->c > 0) {
    //         $this->db->delete('field_part_petitioner',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q48_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1128 Delete failed, Unable to delete data from field_part_petitioner
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1128)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////petitioner_part////////
    //     $q49 = "select count(*) as c from petitioner_part where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q49_result = $this->db->query($q49, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q49_result->row()->c > 0) {
    //         $this->db->delete('petitioner_part',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q49_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1129 Delete failed, Unable to delete data from petitioner_part
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1129)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////petition_dag_details////////
    //     $q50 = "select count(*) as c from petition_dag_details where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q50_result = $this->db->query($q50, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q50_result->row()->c > 0) {
    //         $this->db->delete('petition_dag_details',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q50_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1130 Delete failed, Unable to delete data from petition_dag_details
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1130)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////petition_lm_note////////
    //     $q51 = "select count(*) as c from petition_lm_note where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q51_result = $this->db->query($q51, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q51_result->row()->c > 0) {
    //         $this->db->delete('petition_lm_note',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q51_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1131 Delete failed, Unable to delete data from petition_lm_note
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1131)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////petition_pattadar////////
    //     $q52 = "select count(*) as c from petition_pattadar where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q52_result = $this->db->query($q52, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q52_result->row()->c > 0) {
    //         $this->db->delete('petition_pattadar',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q52_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1132 Delete failed, Unable to delete data from petition_pattadar
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1132)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ////////////petition_pattadar////////
    //     $q52 = "select count(*) as c from petition_pattadar where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
    //     $q52_result = $this->db->query($q52, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
    //     if ($q52_result->row()->c > 0) {
    //         $this->db->delete('petition_pattadar',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number));
    //         if($this->db->affected_rows() != $q52_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1132 Delete failed, Unable to delete data from petition_pattadar
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code (#JDD1132)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     /////////chitha_dag_pattadar//////////
    //     $q1 = "select count(*) as c from chitha_dag_pattadar where 
    //         dist_code=? and subdiv_code=? and "
    //         . "cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? "
    //         . "and patta_no=? and patta_type_code=? ";

    //     $q1_result = $this->db->query($q1, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number, $patta_number, $patta_type));
    //     if ($q1_result->row()->c > 0) {
    //         $this->db->delete('chitha_dag_pattadar',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number,
    //                 'patta_no' => $patta_number,
    //                 'patta_type_code' => $patta_type));
        
    //         if($this->db->affected_rows() != $q1_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1052 Delete failed, Unable to delete data from chitha_dag_pattadar
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code(#JDD1052)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     }

    //     ///////chitha_pattadar/////////////
    //      $q55 = "select count(*) as c from chitha_basic where 
    //         dist_code=? and subdiv_code=? and cir_code=? and 
    //         mouza_pargona_code=? and lot_no=? and vill_townprt_code=? 
    //         and dag_no !=? and patta_no=? and patta_type_code=?";
    //         $q55_result = $this->db->query($q55, array($dist_code, $subdiv_code,
    //             $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number, $patta_number,$patta_type));
    //         if ($q55_result->row()->c == 0) {
    //             $q2 = "select count(*) as c from chitha_pattadar where 
    //                     dist_code=? and subdiv_code=? and cir_code=? 
    //                     and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? "
    //                     . "and patta_no=? and patta_type_code=? ";
    //             $q2_result = $this->db->query($q2, array($dist_code, $subdiv_code,
    //                 $circle_code, $mouza_code, $lot_no, $vill_code, $patta_number, $patta_type));
    //             if ($q2_result->row()->c > 0) {
    //                 $this->db->delete('chitha_pattadar',
    //                     array('dist_code' => $dist_code,
    //                         'subdiv_code' => $subdiv_code,
    //                         'cir_code' => $circle_code,
    //                         'mouza_pargona_code' => $mouza_code,
    //                         'lot_no' => $lot_no,
    //                         'vill_townprt_code' => $vill_code,
    //                         'patta_no' => $patta_number,
    //                         'patta_type_code' => $patta_type));
    //                 if($this->db->affected_rows() != $q2_result->row()->c)
    //                 {
    //                     $this->db->trans_rollback();
    //                     log_message("error", "#JDD1053 Delete failed, Unable to delete data from chitha_pattadar
    //                                  for dist_code:" . $dist_code . ", case no: " . $case_no);
    //                     $this->session->set_flashdata('message', "Unable to delete data from database. Error Code(#JDD1053)");
    //                     redirect(base_url() . "index.php/home");
    //                 }
    //             }
    //         }

        

    //     /////////chitha_basic//////////
    //     $q21 = "select count(*) as c from chitha_basic where 
    //         dist_code=? and subdiv_code=? and "
    //         . "cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? "
    //         . "and patta_no=? and patta_type_code=? ";

    //     $q21_result = $this->db->query($q21, array($dist_code, $subdiv_code,
    //         $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number, $patta_number, $patta_type));
    //     if ($q21_result->row()->c > 0) {
    //         $this->db->delete('chitha_basic',
    //             array('dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $circle_code,
    //                 'mouza_pargona_code' => $mouza_code,
    //                 'lot_no' => $lot_no,
    //                 'vill_townprt_code' => $vill_code,
    //                 'dag_no' => $dag_number,
    //                 'patta_no' => $patta_number,
    //                 'patta_type_code' => $patta_type));
        
    //         if($this->db->affected_rows() != $q21_result->row()->c)
    //         {
    //             $this->db->trans_rollback();
    //             log_message("error", "#JDD1051 Delete failed, Unable to delete data from chitha_basic
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //             $this->session->set_flashdata('message', "Unable to delete data from database. Error Code(#JDD1051)");
    //             redirect(base_url() . "index.php/home");
    //         }
    //     } else {
    //         $this->db->trans_rollback();
    //         log_message("error", "#JDD1090 Delete failed, Data not found in chitha_basic
    //                          for dist_code:" . $dist_code . ", case no: " . $case_no);
    //         $this->session->set_flashdata('message', "Data not found in Chitha. Error Code(#JDD1090)");
    //         redirect(base_url() . "index.php/home");
    //     }

    //     if ($this->db->trans_status() == FALSE) {
    //         $this->db->trans_rollback();
    //         log_message("error", "#JDD1084 Transaction Failed.
    //                          for dist_code:" . $dist_code . ", generated case no: " . $case_no);
    //         $this->session->set_flashdata('message', "Transaction Failed. Error Code (#JDD1084)");
    //         redirect(base_url() . "index.php/home");
    //     } else {
    //         $this->db->trans_commit();
    //         $this->session->set_flashdata('message', "Order Successfully Passed with Case no: ".$case_no);
    //         redirect(base_url() . "index.php/home");
    //     }
    // }
    /////////////////////Dag No. Modify/////////////////////////////
    function updateDagPatta() {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $this->load->model('mutation/mutationmodel');
        //$this->session->set_userdata(array('pattadar' => array()));
        if($dist_code!='11' || $cir_code!='01' || $subdiv_code!='01'){
            echo json_encode(array('SORRY ! You are not allowed'));
            return;
        }
        $q = "SElect * from    patta_code";
        $district['patta'] = $this->db->query($q)->result();
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
        $district['_view'] = 'delete/update_dag_patta';
        $this->load->view('layouts/main',$district);
    }
    function updateNewDagPatta() 
    {
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');
        $patta_type_code = $this->input->post('patta_type_code');
        $patta_no = $this->input->post('patta_no');
        $dag_no = $this->input->post('dag_no');
        ///////
        $up_patta_no = trim($this->input->post('update_patta'));
        $up_dag_no = trim($this->input->post('update_dag'));
        $case_no = trim($this->input->post('case_no'));
        if($case_no==null){
            show_error("Case No required ");
            die;
        }
        /////////Sql For Dag Exists///////////////////
        $sql="Select * from chitha_basic where dag_no=? and dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and  vill_townprt_code=?";
        $data=$this->db->query($sql,array($up_dag_no,$dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code))->num_rows();
        if($data>=1){
            log_message('error','DAGCHANGE###'.$this->db->last_query());
            show_error("Dag no $up_dag_no you have entered already exists ! Please Type Correct Dag No. ");
            die;
        }
        //////////////////For field Case///////////////////////
        $q = "Select * from    chitha_col8_order where case_no='$case_no' "; // and map_partition is null ";
        $record = $this->db->query($q)->row();
        $numRows = $this->db->query($q)->num_rows();
        if ($numRows == 2) 
        {
                //var_dump($record);
                $where_cdp = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'patta_type_code' => $patta_type_code,
                    'dag_no' => $dag_no,
                    'patta_no' => $patta_no,
                );
                $val = $this->db->get_where('chitha_basic', $where_cdp);
                $row = $val->row_array();
                $deleted_data=array(
                    'deleted_data'=>json_encode($row),
                    'delete_table_name' =>'chitha_basic',
                    'dharitree_case_no'=>$case_no,
                    //'refence_letter_id'=>'BY CO'
                );
                $this->db->insert('deleted_data_requested',$deleted_data);
                if($this->db->affected_rows()!=1){
                    log_message('error',$this->db->last_query());
                    $this->db->trans_rollback();
                    show_error("Error In Processing. Please try Again !");
                    return;
                }
                $row['dag_no'] = $up_dag_no;
                $row['dag_no_int'] = $up_dag_no . "00";
                //$row['patta_no'] = $up_patta_no;
                $row['date_entry'] = date('Y-m-d H:i:s');
                $row['user_code'] = $this->session->userdata('user_code');
                $this->db->trans_begin();
                // $this->db->insert('chitha_basic', $row);
                $this->Chitha_basic_model->insert_table('chitha_basic',$row);
                if($this->db->affected_rows()!=1){
                    log_message('error',$this->db->last_query());
                    $this->db->trans_rollback();
                    show_error("Error In Processing. Please try Again !");
                    die;
                }

                $col8order_cron_no = $record->col8order_cron_no;
                $sql = "Update chitha_col8_occup set new_dag_no='$up_dag_no' where col8order_cron_no='$col8order_cron_no' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and new_dag_no='$dag_no' ";
                $this->db->query($sql);
                if($this->db->affected_rows()!=1){
                    log_message('error',$this->db->last_query());
                    $this->db->trans_rollback();
                    show_error("Error In Processing. Please try Again !");
                    die;
                }
                $sql = "Update chitha_col8_order set new_dag_no='$up_dag_no' where col8order_cron_no='$col8order_cron_no' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and new_dag_no='$dag_no' ";
                $this->db->query($sql);
                if($this->db->affected_rows()!=1){
                    log_message('error',$this->db->last_query());
                    $this->db->trans_rollback();
                    show_error("Error In Processing. Please try Again !");
                    die;
                }
                $sql = "Update chitha_col8_order set dag_no='$up_dag_no' where col8order_cron_no='$col8order_cron_no' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and dag_no='$dag_no' ";
                $this->db->query($sql);
                if($this->db->affected_rows()!=1){
                    log_message('error',$this->db->last_query());
                    $this->db->trans_rollback();
                    show_error("Error In Processing. Please try Again !");
                    die;
                }
                $value = array('dag_no' => $up_dag_no, 'dag_no_int' => $up_dag_no . "00", 'patta_no' => $up_patta_no);
                $where_cdp = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'patta_type_code' => $patta_type_code,
                    'dag_no' => $dag_no,
                    'patta_no' => $patta_no,
                );
                //$this->db->where($where_cdp);
                //$this->db->update('chitha_basic',$value);
                $value = array('dag_no' => $up_dag_no);
                // $this->db->where($where_cdp);
                // $this->db->update('chitha_dag_pattadar', $value);
                $this->Chitha_basic_model->update_table('chitha_dag_pattadar', $value, $where_cdp);
                if($this->db->affected_rows()==0){
                    log_message('error',$this->db->last_query());
                    $this->db->trans_rollback();
                    show_error("Error In Processing. Please try Again !");
                    die;
                }
                $this->db->where($where_cdp);
                $this->db->delete('chitha_basic');
                if($this->db->affected_rows()==0){
                    log_message('error',$this->db->last_query());
                    $this->db->trans_rollback();
                    show_error("Error In Processing. Please try Again !");
                    die;
                }
                if($this->db->trans_status()===FALSE){
                    $this->db->trans_rollback();
                    show_error("Error In Processing. Please try Again !");
                    die; 
                }
                $this->db->trans_commit();
                redirect('JunkDagDelete/updateDagPatta');
                // $value = array('patta_no' => $up_patta_no);
                // $where_cdp = array(
                //     'dist_code' => $dist_code,
                //     'subdiv_code' => $subdiv_code,
                //     'cir_code' => $cir_code,
                //     'mouza_pargona_code' => $mouza_pargona_code,
                //     'lot_no' => $lot_no,
                //     'vill_townprt_code' => $vill_townprt_code,
                //     'patta_type_code' => $patta_type_code,
                //     'patta_no' => $patta_no,
                // );
                // //var_dump($where_cdp);
                // $this->db->where($where_cdp);
                // $this->db->update('chitha_pattadar', $value);
        } 
        ////////////End Field Start Office/////////////////
        $q = "Select * from chitha_rmk_ordbasic where case_no='$case_no'  ";
        $record = $this->db->query($q)->row();
        $numRows = $this->db->query($q)->num_rows();
        if ($numRows == 2) {
            //var_dump($record);
            $where_cdp = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'patta_type_code' => $patta_type_code,
                'dag_no' => $dag_no,
                'patta_no' => $patta_no,
            );
            $val = $this->db->get_where('chitha_basic', $where_cdp);
            $row = $val->row_array();
            $deleted_data=array(
                    'deleted_data'=>json_encode($row),
                    'delete_table_name' =>'chitha_basic',
                    'dharitree_case_no'=>$case_no,
                    //'refence_letter_id'=>'BY CO'
            );
            $this->db->insert('deleted_data_requested',$deleted_data);
            if($this->db->affected_rows()!=1){
                log_message('error',$this->db->last_query());
                $this->db->trans_rollback();
                show_error("Error In Processing. Please try Again !");
                return;
            }
            $row['dag_no'] = $up_dag_no;
            $row['dag_no_int'] = $up_dag_no . "00";
            //$row['patta_no'] = $up_patta_no;
            $row['date_entry'] = date('Y-m-d H:i:s');
            $row['user_code'] = $this->session->userdata('user_code');
            // $this->db->insert('chitha_basic', $row);
            $this->Chitha_basic_model->insert_table('chitha_basic',$row);
            if($this->db->affected_rows()!=1){
                    log_message('error',$this->db->last_query());
                    $this->db->trans_rollback();
                    show_error("Error In Processing. Please try Again !");
                    return;
            }
            $value = array('dag_no' => $up_dag_no);
            $this->db->where($where_cdp);
            // $this->db->update('chitha_dag_pattadar', $value);
            $this->Chitha_basic_model->update_table('chitha_dag_pattadar', $value, $where_cdp);
            if($this->db->affected_rows()==0){
                    log_message('error',$this->db->last_query());
                    $this->db->trans_rollback();
                    show_error("Error In Processing. Please try Again !");
                    die;
            }
            // $value = array('patta_no' => $up_patta_no);
            // $where_cdp = array(
            //     'dist_code' => $dist_code,
            //     'subdiv_code' => $subdiv_code,
            //     'cir_code' => $cir_code,
            //     'mouza_pargona_code' => $mouza_pargona_code,
            //     'lot_no' => $lot_no,
            //     'vill_townprt_code' => $vill_townprt_code,
            //     'patta_type_code' => $patta_type_code,
            //     'patta_no' => $patta_no,
            // );
            // $this->db->where($where_cdp);
            // $this->db->update('chitha_pattadar', $value);
            // if($this->db->affected_rows()==0){
            //         log_message('error',$this->db->last_query());
            //         $this->db->trans_rollback();
            //         show_error("Error In Processing. Please try Again !");
            //         die;
            // }
            //$value=array('dag_no'=>$up_dag_no,'dag_no_int'=>$up_dag_no."00",'patta_no'=>$up_patta_no);
            //$this->db->where($where_cdp);


            $rmk_type_hist_no = $record->rmk_type_hist_no;
            $sql = "Update chitha_rmk_infavor_of set new_dag_no='$up_dag_no' where subdiv_code='$subdiv_code' and cir_code='$cir_code' and ord_no='$case_no' ";
            $this->db->query($sql);
            if($this->db->affected_rows()==0){
                    log_message('error',$this->db->last_query());
                    $this->db->trans_rollback();
                    show_error("Error In Processing. Please try Again !");
                    die;
            }
            $sql = "Update chitha_rmk_ordbasic set new_dag_no='$up_dag_no' where ord_no='$case_no' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and new_dag_no='$dag_no' ";
            $this->db->query($sql);
            if($this->db->affected_rows()==0){
                    log_message('error',$this->db->last_query());
                    $this->db->trans_rollback();
                    show_error("Error In Processing. Please try Again !");
                    die;
            }
            $sql = "Update chitha_rmk_ordbasic set dag_no='$up_dag_no' where ord_no='$case_no' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and dag_no='$dag_no' ";
            $this->db->query($sql);
            if($this->db->affected_rows()==0){
                    log_message('error',$this->db->last_query());
                    $this->db->trans_rollback();
                    show_error("Error In Processing. Please try Again !");
                    die;
            }
            $sql = "Update chitha_rmk_gen set dag_no='$up_dag_no' where rmk_type_hist_no='$rmk_type_hist_no' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and rmk_type_code='01' and mouza_pargona_code='$record->mouza_pargona_code' and 
            lot_no='$record->lot_no' and vill_townprt_code='$record->vill_townprt_code' and (dag_no='$dag_no'  )        ";
            $this->db->query($sql);
            if($this->db->affected_rows()==0){
                    log_message('error',$this->db->last_query());
                    $this->db->trans_rollback();
                    show_error("Error In Processing. Please try Again !");
                    die;
            }
            $this->db->where($where_cdp);
            $this->db->delete('chitha_basic');
            if($this->db->affected_rows()==0){
                log_message('error',$this->db->last_query());
                $this->db->trans_rollback();
                show_error("Error In Processing. Please try Again !");
                die;
            }
            if($this->db->trans_status()===FALSE){
                $this->db->trans_rollback();
                show_error("Error In Processing. Please try Again !");
                die; 
            }
            $this->db->trans_commit();
            redirect('JunkDagDelete/updateDagPatta');
        }
    }
}