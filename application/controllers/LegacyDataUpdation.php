<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LegacyDataUpdation extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
        $this->load->model('conversion/ASTofficeConversionModel');
        $this->load->model('conversion/COofficeConversionModel');
        $this->load->helper(array('form', 'url'));
        $this->load->model('basundhara/basundharamodel');
        $this->load->model('PetitionProceedingModel');
        $this->load->model('legacyModel');
        $this->load->model('rtps/rtpsmodel');
        $this->load->model('chitha/ChithaModel');
        $this->load->model('UserModel');
        $this->load->model('AgriStackCaseHistory');
        if (ENABLED_BLOCKCHAIN == 1) {
            $this->load->model('propChain/PropChainModel');
            $this->load->model('propChain/PropChainCommonModel');
        }
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
        }
    }

    public function Updation()
    {
        $db = $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        // Use parameterized queries to avoid SQL injection
        $data['remark'] = $this->db->query(
            "SELECT COUNT(id) AS r 
            FROM edit_jama_remark 
            WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? AND status = 'P'",
            [$dist_code, $subdiv_code, $cir_code]
        )->row();

        $data['pattadar'] = $this->db->query(
            "SELECT COUNT(id) AS p 
            FROM edit_jama_pattadar 
            WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? 
            AND status = 'P' 
            AND (entry_mode = 'O' OR entry_mode = 'J')",
            [$dist_code, $subdiv_code, $cir_code]
        )->row();

        $data['dag'] = $this->db->query(
            "SELECT COUNT(id) AS d 
            FROM edit_jama_dag 
            WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? AND status = 'P'",
            [$dist_code, $subdiv_code, $cir_code]
        )->row();

        $data['legacy_data_update_fp'] = $this->db->query(
            "SELECT COUNT(*) AS c 
            FROM t_legacyupdation 
            WHERE co_yn IS NULL 
            AND dc_yn IS NULL 
            AND status = 'P' 
            AND dist_code = ? 
            AND subdiv_code = ? 
            AND cir_code = ?",
            [$dist_code, $subdiv_code, $cir_code]
        )->row();

        $data['legacy_data_update_dc'] = $this->db->query(
            "SELECT COUNT(*) AS f 
            FROM t_legacyupdation 
            WHERE co_yn IS NOT NULL 
            AND dc_yn IS NULL 
            AND status = 'P' 
            AND dist_code = ?",
            [$dist_code]
        )->row();

        $data['_view'] = 'LegacyDataUpdation/updationmenu';
        $this->load->view('layouts/main', $data);
    }


    public function LMlocationSelect()
    {
        $db =  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $this->session->set_userdata(array('end' => false));

        $data = $this->mutationmodel->getVillageCodeJSON($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $data['villages'] = $data;

        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/LegacyDataUpdation/LMlocationSelect', $district);
        // $this->load->view('../views/footer');
        $data['_view'] = 'LegacyDataUpdation/LMlocationSelect';
        $this->load->view('layouts/main', $data);
    }

    public function LMConvertionType()
    {
        $db =  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('circle_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');
        $mouza_pargona_code = $this->input->post('mouza_code');

        $errorMessageStr = '';

        if (empty($vill_code)) {
            $errorMessageStr .= 'Village is required';
        }
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

        if (!in_array($user_desig_code, ['LM'])) {
            $this->session->set_flashdata('message', 'You are not authorized to perform this action.');
            return redirect($_SERVER['HTTP_REFERER']);
        }

        $this->session->set_userdata(array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'lot_no' => $lot_no,
            'vill_code' => $vill_code,
            'mouza_pargona_code' => $mouza_pargona_code
        ));


        $land_class = "Select * from    landclass_code";
        $data['land_class'] = $this->db->query($land_class)->result();

        $patta_code = "Select * from    patta_code";
        $data['patta_code'] = $this->db->query($patta_code)->result();

        //$data['striked_pattadar']="select chitha_pattadar.pdar_name from    chitha_pattadar inner join chitha_dag_pattadar on chitha_dag_pattadar.dist_code=chitha_pattadar.dist_code and chitha_dag_pattadar.subdiv_code=chitha_pattadar.subdiv_code and chitha_dag_pattadar.cir_code=chitha_pattadar.cir_code and chitha_dag_pattadar.mouza_pargona_code=chitha_pattadar.mouza_pargona_code and chitha_dag_pattadar.lot_no=chitha_pattadar.lot_no and chitha_dag_pattadar.vill_townprt_code=chitha_pattadar.vill_townprt_code and chitha_dag_pattadar.pdar_id=chitha_pattadar.pdar_id and chitha_dag_pattadar.patta_no=chitha_pattadar.patta_no and chitha_dag_pattadar.dag_no='213'";

        //echo "select chitha_pattadar.pdar_name from    chitha_pattadar inner join on chitha_dag_pattadar.dist_code=chitha_pattadar.dist_code and chitha_dag_pattadar.subdiv_code=chitha_pattadar.subdiv_code and chitha_dag_pattadar.cir_code_code=chitha_pattadar.cir_code and chitha_dag_pattadar.mouza_pargona_code=chitha_pattadar.mouza_pargona_code and chitha_dag_pattadar.lot_code=chitha_pattadar.lot_code and chitha_dag_pattadar.vill_townprt_code=chitha_pattadar.vill_townprt_code and chitha_dag_pattadar.pdar_id=chitha_pattadar.pdar_id and chitha_dag_pattadar.patta_no=chitha_pattadar.patta_no ";


        //$data['type'] = $this->mutationmodel->getConvertionPattaType();
        //$data['legacy_code'] = $this->db->query("Select case_code,pro_name_ass from    master_legacy_correction_code")->result();

        $data['lm_name'] = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code);

        // $this->load->view('../views/header');
        // $this->load->view('../views/LegacyDataUpdation/Legacyregister', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'LegacyDataUpdation/Legacyregister';
        $this->load->view('layouts/main', $data);
    }

    public function getDagDetJSON()
    {
        $errorMessageStr = '';
        $dag_no = $this->input->post('dag_no', TRUE);
        $resp = checkRequestSpecChar(['dag_no' => $dag_no]);
        if ($resp['status'] == 'n') {
            $errorMessageStr .= $resp['messages'];
        }

        $resp = checkRequestValidQuery(['dag_no' => $dag_no]);
        if ($resp['status'] == 'n') {
            $errorMessageStr .= $resp['messages'];
        }

        if ($errorMessageStr != '') {
            $data = [
                'success' => false,
                'errors' => $errorMessageStr
            ];

            return $this->output
                ->set_status_header('403')
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
        }

        $dag_no = urldecode($dag_no);
        $db = $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');

        // ✅ Use parameterized query to prevent SQL injection
        $sql = "SELECT * 
                FROM chitha_basic 
                WHERE dist_code = ? 
                AND subdiv_code = ? 
                AND cir_code = ? 
                AND mouza_pargona_code = ? 
                AND lot_no = ? 
                AND vill_townprt_code = ? 
                AND dag_no = ?";

        $params = [
            $dist_code,
            $subdiv_code,
            $cir_code,
            $mouza_pargona_code,
            $lot_no,
            $vill_code,
            $dag_no
        ];

        $data = $this->db->query($sql, $params);
        $landarea = $data->result();

        if ($landarea) {
            echo json_encode($landarea);
        } else {
            $data = [
                'success' => false,
                'errors' => "No data found with this DAG No"
            ];

            return $this->output
                ->set_status_header('403')
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
        }
    }


    public function existPattaNo($patta_no, $patta_type_code)
    {
        $db = $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');

        // ✅ Use parameterized query instead of variable interpolation
        $sql = "
            SELECT dag_no 
            FROM chitha_basic p 
            WHERE p.dist_code = ? 
            AND p.subdiv_code = ? 
            AND p.cir_code = ? 
            AND p.mouza_pargona_code = ? 
            AND p.vill_townprt_code = ? 
            AND p.lot_no = ? 
            AND TRIM(p.patta_no) = ? 
            AND p.patta_type_code = ?";

        $params = [
            $dist_code,
            $subdiv_code,
            $cir_code,
            $mouza_pargona_code,
            $vill_code,
            $lot_no,
            $patta_no,
            $patta_type_code
        ];

        $data = $this->db->query($sql, $params)->result();

        // ✅ Build Assamese message string
        $string = '';
        $comma1 = ' এই ' . $patta_no . ' নং পট্টাত আগৰ পৰাই ';
        $comma2 = ' নং দাগ অন্তর্ভূক্ত হৈ আছে ।';

        foreach ($data as $key => $value) {
            if ($key != 0) {
                $comma1 = ', ';
            }
            $string .= $comma1 . $value->dag_no;
        }

        if (!empty($string)) {
            $string .= $comma2;
        }

        $exist = ['val' => $string];
        echo json_encode($exist);
    }


    //    public function existPattaNo($p,$pp) {
    //        $dist_code = $this->session->userdata('dist_code');
    //        $subdiv_code = $this->session->userdata('subdiv_code');
    //        $cir_code = $this->session->userdata('cir_code');
    //        $lot_no = $this->session->userdata('lot_no');
    //        $vill_code = $this->session->userdata('vill_code');
    //        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
    //    
    //        $data = $this->db->query("select count(patta_no) as c from    jama_patta where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' 
    //    and  mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and 
    //    vill_townprt_code = '$vill_code' and patta_no='$p' and patta_type_code='$pp' ");
    //        $val = $data->row()->c;
    //    $exist=array('val'=>$val);
    //        echo json_encode($exist);
    //    }

    public function getDagDetJSONForBacklog($dag_no, $mouzaselect, $lotselect, $villageselect)
    {
        $db =  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $data = $this->db->query("select * from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "mouza_pargona_code = '$mouzaselect' and lot_no = '$lotselect' and vill_townprt_code = '$villageselect' and dag_no='$dag_no'");
        $landarea = $data->result();

        echo json_encode($landarea);
    }

    public function getPattaNameJSON()
    {
        $db = $this->session->userdata('db');
        $patta_code = $this->input->post('patta_code', TRUE);
        // ✅ Use parameterized query instead of string interpolation
        $sql = "SELECT * FROM patta_code WHERE type_code = ?";
        $data1 = $this->db->query($sql, [$patta_code]);
        $data = $data1->result();

        $json = [];
        foreach ($data as $object) {
            $json[] = [
                'type_code'   => $object->type_code,
                'patta_type'  => $object->patta_type,
                'mutation'    => $object->mutation
            ];
        }

        echo json_encode($json);
    }


    public function getLandClassNameJSON()
    {
        $db = $this->session->userdata('db');
        $land_class_code = $this->input->post('land_class_code', TRUE);
        // ✅ Use parameterized query to prevent SQL injection
        $sql = "SELECT * FROM landclass_code WHERE class_code = ?";
        $data2 = $this->db->query($sql, [$land_class_code]);
        $data = $data2->result();

        $json1 = [];
        foreach ($data as $object) {
            $json1[] = [
                'class_code' => $object->class_code,
                'land_type'  => $object->land_type
            ];
        }

        echo json_encode($json1);
    }


    public function getRemarksJSON()
    {
        $db = $this->session->userdata('db');
        $patta_no   = $this->input->post('patta_no', TRUE);
        $patta_type_code = $this->input->post('patta_code', TRUE);
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');

        $session_case_no = $this->session->userdata('accessible_case_no');

        if (!empty($session_case_no)) {
            // LDU => From CO, ADC, DC => this value ($session_case_no) will be set to get subdiv_code/cir_code/lot_no/vill_code
            $condition = ['case_no' => $session_case_no];
            $t_legacyupdation = $this->legacyModel->get_row($condition);
            $subdiv_code = $t_legacyupdation->subdiv_code;
            $cir_code = $t_legacyupdation->cir_code;
            $lot_no = $t_legacyupdation->lot_no;
            $vill_code = $t_legacyupdation->vill_townprt_code;
            $mouza_pargona_code = $t_legacyupdation->mouza_pargona_code;
        }

        // ✅ Parameterized SQL query
        $sql = "SELECT * 
                FROM jama_remark 
                WHERE dist_code = ? 
                AND subdiv_code = ? 
                AND cir_code = ? 
                AND mouza_pargona_code = ? 
                AND lot_no = ? 
                AND vill_townprt_code = ? 
                AND patta_no = ? 
                AND patta_type_code = ?";

        $params = [
            $dist_code,
            $subdiv_code,
            $cir_code,
            $mouza_pargona_code,
            $lot_no,
            $vill_code,
            $patta_no,
            $patta_type_code
        ];

        $data = $this->db->query($sql, $params);
        $landarea = $data->result();

        echo json_encode($landarea);
    }


    public function getPattadarJSON()
    {
        $db = $this->session->userdata('db');
        $dag_no     = $this->input->post('dag_no', TRUE);
        $patta_no   = $this->input->post('patta_no', TRUE);
        $patta_type_code = $this->input->post('patta_code', TRUE);
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');

        // ✅ Secure parameterized query
        $sql = "
            SELECT 
                chitha_pattadar.pdar_name,
                chitha_dag_pattadar.pdar_id,
                chitha_dag_pattadar.p_flag
            FROM chitha_pattadar
            INNER JOIN chitha_dag_pattadar 
                ON chitha_dag_pattadar.dist_code = chitha_pattadar.dist_code
                AND chitha_dag_pattadar.subdiv_code = chitha_pattadar.subdiv_code
                AND chitha_dag_pattadar.cir_code = chitha_pattadar.cir_code
                AND chitha_dag_pattadar.mouza_pargona_code = chitha_pattadar.mouza_pargona_code
                AND chitha_dag_pattadar.lot_no = chitha_pattadar.lot_no
                AND chitha_dag_pattadar.vill_townprt_code = chitha_pattadar.vill_townprt_code
                AND chitha_dag_pattadar.pdar_id = chitha_pattadar.pdar_id
                AND chitha_dag_pattadar.patta_no = chitha_pattadar.patta_no
                AND chitha_dag_pattadar.patta_type_code = chitha_pattadar.patta_type_code
            WHERE chitha_dag_pattadar.dag_no = ?
            AND chitha_dag_pattadar.patta_no = ?
            AND chitha_dag_pattadar.patta_type_code = ?";

        // Pass parameters safely
        $params = [$dag_no, $patta_no, $patta_type_code];

        $data = $this->db->query($sql, $params);
        $pattadar_strike = $data->result();

        echo json_encode($pattadar_strike);
    }







    public function chech_dagJSON($new_dag_no)
    {
        $db =  $this->session->userdata('db');

        $check_dag = $this->db->query("Select count(*) as cd from    chitha_basic where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and "
            . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code' and dag_no = '$new_dag_no'")->row()->cd;

        //if $check_dag is 1 then the dag exist
        echo json_encode($check_dag);
    }

    public function saveLegacyDataDetails()
    {
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        if (!in_array($user_desig_code, ['LM'])) {
            $this->session->set_flashdata('message', 'You are not authorized to perform this action.');
            // return redirect($_SERVER['HTTP_REFERER']);
            return redirect(base_url('/index.php/LegacyDataUpdation/LMlocationSelect'));
        }

        if (empty($this->input->post('dagno'))) {
            $this->session->set_flashdata('message', "<strong class='text-dark'>Errors in \"Land Proposed for Legacy Data Modification / Updations Form\"</strong>Dag number is required.");
            return redirect(base_url('/index.php/LegacyDataUpdation/LMlocationSelect'));
        }

        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST, [], ['dagno' => 'Dag number']);
        if ($resp['status'] == 'n') {
            $errorMessageStr .= $resp['messages'];
        }

        $resp = checkRequestValidQuery($_POST, [], ['dagno' => 'Dag number']);
        if ($resp['status'] == 'n') {
            $errorMessageStr .= $resp['messages'];
        }

        if ($errorMessageStr != '') {
            $this->session->set_flashdata('message', "<strong class='text-dark'>Errors in \"Land Proposed for Legacy Data Modification / Updations Form\"</strong>" . $errorMessageStr);
            // return redirect($_SERVER['HTTP_REFERER']);
            return redirect(base_url('/index.php/LegacyDataUpdation/LMlocationSelect'));
        }

        $db =  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        // if($this->input->post('patta_no')=='0' && !($this->session->userdata('dist_code')=='11' && $this->session->userdata('subdiv_code')=='01' && $this->session->userdata('cir_code')=='01' && $this->session->userdata('mouza_pargona_code')=='03' && $this->session->userdata('lot_no')=='05' && $this->session->userdata('vill_code')=='10007'))
        //     redirect('/home');
        // if()
        $this->db->trans_begin();
        // $dir = UPLOAD_BASE ."LDUDocs";
        $dir = LDU_DOCS_BASE_DIR;
        if (is_dir($dir) === false) {
            mkdir($dir, 0777, true);
        }
        // $config['upload_path'] = UPLOAD_BASE .'LDUDocs/';
        $config['upload_path'] = LDU_DOCS_BASE_DIR . UPLOAD_SEPARATOR;
        // $config['allowed_types'] = 'gif|jpg|png|pdf';
        $config['allowed_types'] = 'gif|jpg|png|pdf|jpeg|JPEG|PNG|PDF|JPG';
        $config['encrypt_name'] = TRUE;
        $config['detect_mime'] = TRUE;
        $config['mod_mime_fix'] = TRUE;
        $this->load->library('upload', $config);

        $file_upload = $_FILES['file_upload']['name'];
        $file_name = '';
        if ($file_upload !== "") {
            $this->upload->do_upload('file_upload');
            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];
        }
        $remark = $this->input->post('remark');
        $rmk_line_no = "";
        if ($remark) {
            foreach ($remark as $key => $val) {
                if ($rmk_line_no != 0) {
                    $rmk_line_no = $rmk_line_no . "," . $val;
                } else {
                    $rmk_line_no = $val;
                }
            }
        }

        if (in_array($dist_code, json_decode(BARAK_VALLEY))) {
            $suggested_dag_area_g = $this->input->post('suggested_dag_area_g') == null ? "0" : $this->input->post('suggested_dag_area_g');
            $suggested_dag_area_kr = $this->input->post('suggested_dag_area_kr') == null ? "0" : $this->input->post('suggested_dag_area_kr');
        } else {
            $suggested_dag_area_g = 0;
            $suggested_dag_area_kr = 0;
        }

        // $case_name=$this->basundharamodel->genearteCaseName();
        // $case_no['petition_no']=$petition_no=$this->basundharamodel->genearteLegacyPetitionNo();
        // $case_no=$case_name.$petition_no."/LDU";

        $case_name = $this->rtpsmodel->genearteCaseName();

        $seq_pet = year_no . '00';
        $case_no['petition_no'] = $petition_no = $seq_pet . $this->rtpsmodel->genearteLegacyPetitionNo();
        $case_no = $case_name . $petition_no . "/LDU";



        $lm_note = addslashes($this->input->post('lm_note')) . "<br>" . $this->input->post('lm_note_suffix');

        $shift = $this->input->post('suggested_striked'); //var_dump($shift);
        // $shift=$_POST['suggested_striked'];//var_dump($shift);
        $pflag = $pid = $pname = NULL;
        if (isset($shift) && !empty($shift)) {
            $pflag = substr($shift[0], 0, 1);
            //print_r (explode("_",$shift[0]));
            $temp = explode("_", $shift[0]);
            $pflag = $temp[0];
            $pid = $temp[1];
            $pname = $temp[2];
        }

        $dagno = $this->input->post('dagno');
        $patta_no = $this->input->post('patta_no');
        $patta_type = $this->input->post('patta_type');
        $land_class = $this->input->post('land_class');
        $land_rev = $this->input->post('land_rev');
        $loc_tax = $this->input->post('loc_tax');
        $dag_area_b = $this->input->post('dag_area_b');
        $dag_area_k = $this->input->post('dag_area_k');
        $dag_area_lc = $this->input->post('dag_area_lc');
        $dag_area_g = $this->input->post('dag_area_g');
        $dag_area_kr = $this->input->post('dag_area_kr');
        $suggested_dag_no = $this->input->post('suggested_dag_no');
        $suggested_patta_no = $this->input->post('suggested_patta_no');
        $suggested_patta_type = $this->input->post('suggested_patta_type');
        $suggested_land_class = $this->input->post('suggested_land_class');
        $suggested_land_rev = $this->input->post('suggested_land_rev');
        $suggested_loc_tax = $this->input->post('suggested_loc_tax');
        $suggested_dag_area_b = $this->input->post('suggested_dag_area_b');
        $suggested_dag_area_k = $this->input->post('suggested_dag_area_k');
        $suggested_dag_area_lc = $this->input->post('suggested_dag_area_lc');


        //print_r($strike_p);
        $year_no = year_no;

        $t_legacyupdation = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_code,
            'proposal_no' => $petition_no,
            'case_no' => $case_no,
            'dag_no' => $dagno,
            'patta_no' => trim($patta_no),
            'patta_type_code' => $patta_type,
            'present_land_class' => $land_class,
            'present_land_revenue' => $land_rev,
            'present_land_localtax' => $loc_tax,
            'dag_area_b' => $dag_area_b,
            'dag_area_k' => $dag_area_k,
            'dag_area_lc' => $dag_area_lc,
            'dag_area_g' => $dag_area_g,
            'dag_area_kr' => $dag_area_kr,
            'suggested_dag_no' => $suggested_dag_no,
            'suggested_patta_no' => $suggested_patta_no,
            'suggested_patta_type' => $suggested_patta_type,
            'suggested_land_class' => $suggested_land_class,
            'suggested_land_rev' => $suggested_land_rev,
            'suggested_loc_tax' => $suggested_loc_tax,
            'suggested_dag_area_b' => $suggested_dag_area_b,
            'suggested_dag_area_k' => $suggested_dag_area_k,
            'suggested_dag_area_lc' => $suggested_dag_area_lc,
            'suggested_dag_area_g' => $suggested_dag_area_g,
            'suggested_dag_area_kr' => $suggested_dag_area_kr,
            'lm_note' => $lm_note,
            'lm_code' => $user_code,
            'lm_date' => date('Y-m-d G:i:s'),
            'year_no' => $year_no,
            'file_upload' => $file_name,
            'status' => 'P',
            'rmk_line_no' => $rmk_line_no,
            'suggested_pattadarstrike' => $pname,
            'p_flag' => $pflag,
            'pdar_id' => $pid
        );
        //var_dump($t_legacyupdation);


        $this->db->insert('t_legacyupdation', $t_legacyupdation);

        $data['case_no'] = $case_no;
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message('error', '#ERRLGCYUPDLM00001: Modification cannot be done for ' . $case_no . '. Query: ' . $this->db->last_query());
            $this->session->set_flashdata('message', '#ERRLGCYUPDLM00001: Sorry...Modification Cannot be Done here !! Please Contact Help Desk !!');
            redirect(base_url() . "index.php/home");
            echo "Error Occured";
        } else {
            $condition = ['case_no' => $case_no];
            $Pcases = $this->legacyModel->get_row($condition);
            $change_request_string = $this->legacyModel->get_change_request_string($Pcases);
            $log_note = addslashes($this->input->post('lm_note')) . ' |' . "<br>" . $this->input->post('lm_note_suffix');
            $log_data = [
                'case_no' => $case_no,
                'proceeding_id' => $this->PetitionProceedingModel->getAutoIncrementalProceedingNo($case_no),
                'date_of_hearing' => date('Y-m-d H:i:s'),
                'date_entry' => date('Y-m-d H:i:s'),
                'co_order' => $log_note,
                'additional_notes' => 'পৰিবৰ্তনৰ বাবে আবেদন: ' . $change_request_string . $this->UserModel->get_user_identification(),
                'operation' => 'E',
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'status' => 'Final',
                'user_code' => $user_code,
                'ip' => $this->utilityclass->get_client_ip(),
            ];
            $log_response = $this->PetitionProceedingModel->store_legacy_logs($log_data);

            if ($log_response['success']) {
                $this->db->trans_commit();

                $data['_view'] = 'LegacyDataUpdation/Registered';
                $this->load->view('layouts/main', $data);
            } else {
                $this->db->trans_rollback();

                $this->session->set_flashdata('message', $log_response['message']);
                return redirect(base_url('/index.php/LegacyDataUpdation/LMlocationSelect'));
            }
            // $this->db->trans_commit();
            // $this->load->view('../views/header');
            // $this->load->view('../views/LegacyDataUpdation/Registered', $data);
            // $this->load->view('../views/footer');

            //  $data['_view'] = 'LegacyDataUpdation/Registered';
            //  $this->load->view('layouts/main',$data);
        }
    }

    public function GoToRE()
    {
        $this->load->library('pagination');
        $db =  $this->session->userdata('db');
        $process = $this->input->get('pro');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
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
        $config['per_page'] = 10;
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
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $page = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $cases['searchKeyword'] = $this->session->userdata('searchKeyword');
        if ($process == '1') {
            // Base URL setup
            $config['base_url'] = base_url('index.php/LegacyDataUpdation/GoToRE?pro=1');

            // Parameterized count query
            $count_query = "
                SELECT COUNT(*) AS count
                FROM t_legacyupdation
                WHERE status = 'P'
                AND co_yn IS NULL
                AND dc_yn IS NULL
                AND dist_code = ?
                AND subdiv_code = ?
                AND cir_code = ?
            ";
            $config['total_rows'] = $this->db->query($count_query, [$dist_code, $subdiv_code, $cir_code])->row()->count;

            // Parameterized select query
            $case_query = "
                SELECT fmb.*, ba.basundhara
                FROM t_legacyupdation fmb
                LEFT JOIN basundhar_application ba ON fmb.case_no = ba.dharitree
                WHERE fmb.status = 'P'
                AND fmb.co_yn IS NULL
                AND fmb.dc_yn IS NULL
                AND fmb.dist_code = ?
                AND fmb.subdiv_code = ?
                AND fmb.cir_code = ?
                ORDER BY fmb.proposal_no ASC
            ";

            $cases['cases'] = $this->db->query($case_query, [$dist_code, $subdiv_code, $cir_code])->result();
            $cases['links'] = $this->pagination->create_links();

        } elseif ($process == '2') {
            $config['base_url'] = base_url() . 'index.php/LegacyDataUpdation/GoToRE?pro=2';
            $config['total_rows'] = $this->legacyModel->getCountPendingLegacyCasesForAdcDc();
            // $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $this->pagination->initialize($config);
            $cases['links'] = $this->pagination->create_links();
            $cases['cases'] = $this->legacyModel->getPendingLegacyCasesForAdcDc($config["per_page"], $page, $searchKeyword);
            // $q = "select count(*) as count from    t_legacyupdation where status = 'P' and co_yn is not null and dc_yn is null and dist_code='$dist_code'";
            // $config['total_rows'] = $this->db->query($q)->row()->count;
            // $q = "select *,ba.basundhara from t_legacyupdation fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where status = 'P' and co_yn is not null and dc_yn is null and dist_code='$dist_code' ORDER BY proposal_no asc";
            // $cases['cases'] = $this->db->query($q)->result();
        } elseif ($process == '3') {
            if ($user_desig_code != 'LM') {
                $this->session->set_flashdata('message', 'You are not authorized to perform this action.');
                return redirect($_SERVER['HTTP_REFERER']);
            }
            // Revert Case for LM
            $config['base_url'] = base_url() . 'index.php/LegacyDataUpdation/GoToRE?pro=3';
            $config['total_rows'] = $this->legacyModel->getCountRevertLegacyCasesForLm();
            // $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $this->pagination->initialize($config);
            $cases['links'] = $this->pagination->create_links();
            $cases['cases'] = $this->legacyModel->getRevertPendingLegacyCasesForLm($config["per_page"], $page, $searchKeyword);
            // $q = "select count(*) as count from t_legacyupdation where status = 'P' and lm_note is null and co_yn is null and dc_yn is null and dist_code=?";
            // $config['total_rows'] = $this->db->query($q, array($dist_code))->row()->count;
            // $q = "select *,ba.basundhara from t_legacyupdation fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where status = 'P' and fmb.lm_note is null and co_yn is null and dc_yn is null and dist_code=? ORDER BY proposal_no asc";
            // $cases['cases'] = $this->db->query($q, array($dist_code))->result();
        }
        $cases['process'] = $process;
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/LegacyDataUpdation/Legacy_cases', $cases);
        // $this->load->view('../views/footer');
        $cases['_view'] = 'LegacyDataUpdation/Legacy_cases';
        $this->load->view('layouts/main', $cases);
    }

    public function LmRevertProcess()
    {
        $db =  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');
        $_GET['case_no'] = dec_param($this->input->get('case_no'), 'case_no');
        if ($_GET['case_no'] == null) {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }
        $case_no = $_GET['case_no'];
        $proposal_no = $this->input->GET('proposal_no');
        $q = "select * from t_legacyupdation where case_no = ? and proposal_no = ? and lm_note is null ";
        $details = $data['details'] = $this->db->query($q, array($case_no, $proposal_no))->row();

        $old_patta = $this->db->query("select * from    patta_code where type_code = '$details->patta_type_code' ")->row();
        $old_land_class = $this->db->query("select * from    landclass_code where class_code = '$details->present_land_class' ")->row();

        $dist_code = $this->utilityclass->getDistrictName($details->dist_code);
        $subdiv_code = $this->utilityclass->getSubDivName($details->dist_code, $details->subdiv_code);
        $cir_code = $this->utilityclass->getCircleName($details->dist_code, $details->subdiv_code, $details->cir_code);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code);
        $lot_no = $this->utilityclass->getLotName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no);
        $vill_townprt_code = $this->utilityclass->getVillageName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $details->vill_townprt_code);


        $co = $this->utilityclass->getSelectedCOName($details->dist_code, $details->subdiv_code, $details->cir_code, $user_code);
        $data['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code,
            'co_name' => $this->ChithaModel->lmName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $user_code)
        );

        if ($details->suggested_patta_no != null) {
            $q = "select dag_no as dag_no from chitha_basic p where p.dist_code=? and p.subdiv_code=? and p.cir_code=? and
                p.mouza_pargona_code=? and p.vill_townprt_code=? 
                and p.lot_no=? and TRIM(p.patta_no)=? and p.patta_type_code=?  ";
            $datas = $this->db->query($q, array($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->vill_townprt_code, $details->lot_no, $details->suggested_patta_no, $details->patta_type_code))->result();
            $string = '';
            $comma1 = ' অই ' . $details->suggested_patta_no . ' নং পট্টাত আগৰ পৰাই ';
            $comma2 = ' নং দাগ অন্তৰভূক্ত সই আছে ।';
            foreach ($datas as $key => $value) {
                if ($key != '0') {
                    $comma1 = ", ";
                }

                $string = $string . $comma1 . $value->dag_no;
            }

            if (!empty($string)) {
                $string = $string . $comma2;
            }
            $data['patta_remarks'] = $string;
        }
        //var_dump($data);

        $land_class = "Select * from    landclass_code";
        $data['land_class'] = $this->db->query($land_class)->result();

        $patta_code = "Select * from    patta_code";
        $data['patta_code'] = $this->db->query($patta_code)->result();

        if ($details->suggested_patta_type) {
            $new_patta = $this->db->query("select * from    patta_code where type_code =? ", array($details->suggested_patta_type))->row();
            $data['new_patta_type'] = $new_patta->patta_type;
        }

        if ($details->suggested_land_class) {
            $new_land_class = $this->db->query("select * from    landclass_code where class_code = ? ", array($details->suggested_land_class))->row();
            $data['new_land_class'] = $new_land_class->land_type;
        }

        $data['det'] = array(
            'patta_type' => $old_patta->patta_type,
            'old_land_class' => $old_land_class->land_type
        );

        $data['Pcases'] = $details;

        $data['dc_adc'] = $this->db->query("Select users.username as username, users.user_desig_code as user_desig_code, loginuser_table.user_code as user_code from    users, "
            . "loginuser_table where users.dist_code = loginuser_table.dist_code and users.user_code = loginuser_table.user_code and users.user_desig_code like '%DC' and "
            . "loginuser_table.dist_code=? and loginuser_table.subdiv_code='00' and loginuser_table.cir_code='00' and loginuser_table.dis_enb_option = 'E' and loginuser_table.priv = 'adm'", array($details->dist_code))->result();


        $application_no = "select * from basundhar_application where dharitree='$case_no' ";
        $data['app'] = $this->db->query($application_no)->row();
        $data['basundharaAttachment'] = array();
        $basundhara = $this->basundharamodel->checkExistBasundhar($case_no);
        if ($basundhara) {
            $rtps = $this->rtpsmodel->checkBasundharaService($case_no);
            if ($rtps == 'RTPS') {
                $data['basundharaAttachment'] = $this->rtpsmodel->searchBasundharaLink($case_no);
            } else {
                $data['basundharaAttachment'] = $this->basundharamodel->searchBasundharaLink($case_no);
            }
        }

        //////////////////////////////////////////////////////////////// Property Chain Code //////////////////////////////////////////////

        if (ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'), json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))) {

            $this->load->model('propChain/PropChainModel');
            // echo "<pre>";
            // var_dump($data['Petitioner']);
            // die;
            // var_dump($propData['dist_code']);

            $data['propChainEnableFlag'] = $this->PropChainCommonModel->isLocationEnable($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $details->vill_townprt_code);

            $land_area = $this->PropChainModel->getLandArea($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $details->vill_townprt_code, $details->patta_no, $details->dag_no);

            $checkPropAndChithaAndUlpn = $this->PropChainModel->chainChithaUlpinCheckProcess($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $details->vill_townprt_code, $details->patta_no, $details->dag_no, $land_area->dag_area_b, $land_area->dag_area_k, $land_area->dag_area_lc, $land_area->dag_area_g, $details->patta_type_code);

            // update flag only if ulpin found

            if ($checkPropAndChithaAndUlpn['ulpinCheck'] == 1 && ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'Y' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'NE')) {
                $this->PropChainModel->updateCmpFlag($case_no, $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag']);
                // if mismatch case get the view mismatch case button
                if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N')
                    $data['viewMisMatchBtn'] =  $this->PropChainModel->getMismatchBtn($case_no, $details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $details->vill_townprt_code, $details->patta_no, $details->dag_no, $land_area->dag_area_b, $land_area->dag_area_k, $land_area->dag_area_lc, $land_area->dag_area_g, $details->patta_type_code);
            }

            $data['ulpinCheck'] = $checkPropAndChithaAndUlpn['ulpinCheck'];
            $data['ulpinMsg'] = $checkPropAndChithaAndUlpn['ulpinMsg'];

            if ($data['ulpinCheck'] == 1) {
                $data['ulpin'] = $checkPropAndChithaAndUlpn['ulpin'];
                if (isset($data['old_ulpin']))
                    $data['old_ulpin'] = $checkPropAndChithaAndUlpn['old_ulpin'];
                else
                    $data['old_ulpin'] = "";
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

        $this->session->set_userdata('accessible_case_no', $details->case_no);

        $data['_view'] = 'LegacyDataUpdation/LmRevertProcess';
        $this->load->view('layouts/main', $data);
    }

    public function SaveLmRevertProcess()
    {
        $user_desig_code = $this->session->userdata('user_desig_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');

        if (!in_array($user_desig_code, ['LM'])) {
            $this->session->set_flashdata('message', 'You are not authorized to perform this action.');
            return redirect($_SERVER['HTTP_REFERER']);
        }

        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST, [], [], ['sugested_patta_type' => true, 'final_report' => true]);
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

        $remark = $this->input->post('remark');
        $rmk_line_no = "";
        if ($remark) {
            foreach ($remark as $key => $val) {
                if ($rmk_line_no != 0) {
                    $rmk_line_no = $rmk_line_no . "," . $val;
                } else {
                    $rmk_line_no = $val;
                }
            }
        }

        $suggested_dag_no = $this->input->post('suggested_dag_no');
        $suggested_patta_no = $this->input->post('suggested_patta_no');
        $suggested_patta_type = $this->input->post('suggested_patta_type');
        $suggested_land_class = $this->input->post('suggested_land_class');
        $suggested_land_rev = $this->input->post('sugested_land_rev');
        $suggested_loc_tax = $this->input->post('sugested_local_tax');
        $suggested_striked = $this->input->post('suggested_striked');
        $suggested_dag_area_b = $this->input->post('suggested_dag_area_b');
        $suggested_dag_area_k = $this->input->post('suggested_dag_area_k');
        $suggested_dag_area_lc = $this->input->post('suggested_dag_area_lc');
        $suggested_dag_area_g = $this->input->post('suggested_dag_area_g');

        $db =  $this->session->userdata('db');
        $proposal_no = $this->input->POST('proposal_no');
        $case_no = $this->input->POST('case_no');
        $lm_report = $this->input->POST('final_report');
        $lm_signature = $this->UserModel->get_user_identification();
        $lm_report = str_replace("'", '', $lm_report);

        $application_no = $this->input->POST('application_no');
        $lm_code = $this->session->userdata('user_code');

        $condition = ['case_no' => $case_no, 'dist_code' => $dist_code, 'subdiv_code' => $subdiv_code, 'cir_code' => $cir_code, 'mouza_pargona_code' => $mouza_pargona_code, 'lot_no' => $lot_no];
        $tLegacyupdation = $this->legacyModel->get_row($condition);

        if (!$tLegacyupdation) {
            $this->session->set_flashdata('message', 'No such case found or this case doesn\'t belong to you.');
            return redirect($_SERVER['HTTP_REFERER']);
        }

        if ($tLegacyupdation->lm_note) {
            $this->session->set_flashdata('message', 'This case has already passed on from your side.');
            return redirect($_SERVER['HTTP_REFERER']);
        }

        $co_date_entry = date('Y-m-d G:i:s');

        $this->db->trans_begin();

        $update_data = [
            'lm_note' => $lm_report . ' - ' . $lm_signature,
            'lm_date' => $co_date_entry,
            'lm_code' => $lm_code,
        ];

        if (!empty($suggested_dag_no)) {
            $update_data = $update_data + ['suggested_dag_no' => $suggested_dag_no];
        }

        if (!empty($suggested_patta_no)) {
            $update_data = $update_data + ['suggested_patta_no' => $suggested_patta_no, 'rmk_line_no' => $rmk_line_no];
        }

        if (!empty($suggested_patta_type)) {
            $update_data = $update_data + ['suggested_patta_type' => $suggested_patta_type];
        }

        if (!empty($suggested_land_class)) {
            $update_data = $update_data + ['suggested_land_class' => $suggested_land_class];
        }

        if (!empty($suggested_land_rev)) {
            $update_data = $update_data + ['suggested_land_rev' => $suggested_land_rev];
        }

        if (!empty($suggested_loc_tax)) {
            $update_data = $update_data + ['suggested_loc_tax' => $suggested_loc_tax];
        }

        if (!empty($suggested_dag_area_b)) {
            $update_data = $update_data + ['suggested_dag_area_b' => $suggested_dag_area_b];
        }

        if (!empty($suggested_dag_area_k)) {
            $update_data = $update_data + ['suggested_dag_area_k' => $suggested_dag_area_k];
        }

        if (!empty($suggested_dag_area_lc)) {
            $update_data = $update_data + ['suggested_dag_area_lc' => $suggested_dag_area_lc];
        }

        if (!empty($suggested_dag_area_g)) {
            $update_data = $update_data + ['suggested_dag_area_g' => $suggested_dag_area_g];
        }

        $this->db->update('t_legacyupdation', $update_data, array('case_no' => $case_no, 'proposal_no' => $proposal_no));

        if ($application_no) {
            $rtps = $this->rtpsmodel->checkRtpsService($application_no);
            if ($rtps == 'RTPS') {
                $apilink = RTPS_API_LINK;
            } else {
                $apilink = API_LINK;
            }

            $api_param = [
                'application' => $application_no,
                'dharitree' => $case_no,
                'rmk' => 'forwared to CO',
                'status' => 'M',
                'task' => 'LM',
                'pen' => 'CO',
                'penat' => 'CO office'
            ];

            $result = sendCurlRequest($apilink, 'POST', $api_param);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message('error', '#ERRLGCYUPCO00002: Something went wrong. QUERY: ' . $this->db->last_query());
            $this->session->set_flashdata('message', "#ERRLGCYUPCO00002: Something went wrong. Please try again later.");
            return redirect($_SERVER['HTTP_REFERER']);
            // echo "Error Occured";
        }

        $condition = ['case_no' => $case_no];
        $updated_tLegacyupdation = $this->legacyModel->get_row($condition);
        $change_request_string = $this->legacyModel->get_change_request_string($updated_tLegacyupdation);

        $log_data = [
            'case_no' => $case_no,
            'proceeding_id' => $this->PetitionProceedingModel->getAutoIncrementalProceedingNo($case_no),
            'date_of_hearing' => date('Y-m-d H:i:s'),
            'date_entry' => date('Y-m-d H:i:s'),
            'co_order' => $lm_report . ' | ' . $this->UserModel->get_user_identification(),
            'additional_notes' => 'পৰিবৰ্তনৰ বাবে আবেদন: ' . $change_request_string . $this->UserModel->get_user_identification(),
            'operation' => 'E',
            'dist_code' => $updated_tLegacyupdation->dist_code,
            'subdiv_code' => $updated_tLegacyupdation->subdiv_code,
            'cir_code' => $updated_tLegacyupdation->cir_code,
            'status' => 'Final',
            'user_code' => $lm_code,
            'ip' => $this->utilityclass->get_client_ip(),
        ];

        $log_response = $this->PetitionProceedingModel->store_legacy_logs($log_data);

        if ($log_response['success']) {
            $this->db->trans_commit();

            $this->session->set_flashdata('message', "Legacy data Updation Case no # $case_no Forwarded to CO after verification.");

            redirect(base_url() . "index.php/home");
        } else {
            $this->db->trans_rollback();

            $this->session->set_flashdata('message', $log_response['message']);
            return redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function FirstCoProcess()
    {
        $db =  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');
        $_GET['case_no'] = dec_param($this->input->get('case_no'), 'case_no');
        if ($_GET['case_no'] == null) {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }
        $case_no = $_GET['case_no'];
        $proposal_no = $this->input->GET('proposal_no');

        $sql = "SELECT * FROM t_legacyupdation WHERE case_no = ? AND proposal_no = ?";
        $details = $data['details'] = $this->db->query($sql, [$case_no, $proposal_no])->row();


        $old_patta = $this->db
            ->query("SELECT * FROM patta_code WHERE type_code = ?", [$details->patta_type_code])
            ->row();

        $old_land_class = $this->db
            ->query("SELECT * FROM landclass_code WHERE class_code = ?", [$details->present_land_class])
            ->row();


        $dist_code = $this->utilityclass->getDistrictName($details->dist_code);
        $subdiv_code = $this->utilityclass->getSubDivName($details->dist_code, $details->subdiv_code);
        $cir_code = $this->utilityclass->getCircleName($details->dist_code, $details->subdiv_code, $details->cir_code);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code);
        $lot_no = $this->utilityclass->getLotName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no);
        $vill_townprt_code = $this->utilityclass->getVillageName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $details->vill_townprt_code);

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

        if ($details->suggested_patta_no != null) {
            $q = "SELECT dag_no AS dag_no 
                    FROM chitha_basic p 
                    WHERE p.dist_code = ? 
                        AND p.subdiv_code = ? 
                        AND p.cir_code = ? 
                        AND p.mouza_pargona_code = ? 
                        AND p.vill_townprt_code = ? 
                        AND p.lot_no = ? 
                        AND TRIM(p.patta_no) = ? 
                        AND p.patta_type_code = ?";

                $datas = $this->db->query($q, [
                    $details->dist_code,
                    $details->subdiv_code,
                    $details->cir_code,
                    $details->mouza_pargona_code,
                    $details->vill_townprt_code,
                    $details->lot_no,
                    $details->suggested_patta_no,
                    $details->patta_type_code
                ])->result();

            $string = '';
            $comma1 = ' অই ' . $details->suggested_patta_no . ' নং পট্টাত আগৰ পৰাই ';
            $comma2 = ' নং দাগ অন্তৰভূক্ত সই আছে ।';
            foreach ($datas as $key => $value) {
                if ($key != '0') {
                    $comma1 = ", ";
                }

                $string = $string . $comma1 . $value->dag_no;
            }

            if (!empty($string)) {
                $string = $string . $comma2;
            }
            $data['patta_remarks'] = $string;
        }
        //var_dump($data);

        if ($details->suggested_patta_type) {
            $new_patta = $this->db
                ->query("SELECT * FROM patta_code WHERE type_code = ?", [$details->suggested_patta_type])
                ->row();
            $data['new_patta_type'] = $new_patta ? $new_patta->patta_type : null;
        }

        if ($details->suggested_land_class) {
            $new_land_class = $this->db
                ->query("SELECT * FROM landclass_code WHERE class_code = ?", [$details->suggested_land_class])
                ->row();
            $data['new_land_class'] = $new_land_class ? $new_land_class->land_type : null;
        }


        $data['det'] = array(
            'patta_type' => $old_patta->patta_type,
            'old_land_class' => $old_land_class->land_type
        );

        $data['Pcases'] = $details;

        $data['dc_adc'] = $this->db->query(
            "SELECT 
                users.username AS username, 
                users.user_desig_code AS user_desig_code, 
                loginuser_table.user_code AS user_code 
            FROM users
            INNER JOIN loginuser_table 
                ON users.dist_code = loginuser_table.dist_code 
                AND users.user_code = loginuser_table.user_code
            WHERE 
                users.user_desig_code LIKE '%DC' 
                AND loginuser_table.dist_code = ? 
                AND loginuser_table.subdiv_code = '00' 
                AND loginuser_table.cir_code = '00' 
                AND loginuser_table.dis_enb_option = 'E' 
                AND loginuser_table.priv = 'adm'",
            [$details->dist_code]
        )->result();

        $data['app'] = $this->db
            ->query("SELECT * FROM basundhar_application WHERE dharitree = ?", [$case_no])
            ->row();

        $data['basundharaAttachment'] = array();
        $basundhara = $this->basundharamodel->checkExistBasundhar($case_no);
        if ($basundhara) {
            $rtps = $this->rtpsmodel->checkBasundharaService($case_no);
            if ($rtps == 'RTPS') {
                $data['basundharaAttachment'] = $this->rtpsmodel->searchBasundharaLink($case_no);
            } else {
                $data['basundharaAttachment'] = $this->basundharamodel->searchBasundharaLink($case_no);
            }
        }
        //var_dump($data['app']);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/LegacyDataUpdation/FirstCoProcess', $data);
        // $this->load->view('../views/footer');



        //////////////////////////////////////////////////////////////// Property Chain Code //////////////////////////////////////////////

        if (ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'), json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))) {

            $this->load->model('propChain/PropChainModel');
            // echo "<pre>";
            // var_dump($data['Petitioner']);
            // die;
            // var_dump($propData['dist_code']);

            $data['propChainEnableFlag'] = $this->PropChainCommonModel->isLocationEnable($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $details->vill_townprt_code);

            $land_area = $this->PropChainModel->getLandArea($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $details->vill_townprt_code, $details->patta_no, $details->dag_no);

            $checkPropAndChithaAndUlpn = $this->PropChainModel->chainChithaUlpinCheckProcess($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $details->vill_townprt_code, $details->patta_no, $details->dag_no, $land_area->dag_area_b, $land_area->dag_area_k, $land_area->dag_area_lc, $land_area->dag_area_g, $details->patta_type_code);

            // update flag only if ulpin found

            if ($checkPropAndChithaAndUlpn['ulpinCheck'] == 1 && ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'Y' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'NE')) {
                $this->PropChainModel->updateCmpFlag($case_no, $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag']);
                // if mismatch case get the view mismatch case button
                if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N')
                    $data['viewMisMatchBtn'] =  $this->PropChainModel->getMismatchBtn($case_no, $details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $details->vill_townprt_code, $details->patta_no, $details->dag_no, $land_area->dag_area_b, $land_area->dag_area_k, $land_area->dag_area_lc, $land_area->dag_area_g, $details->patta_type_code);
            }

            $data['ulpinCheck'] = $checkPropAndChithaAndUlpn['ulpinCheck'];
            $data['ulpinMsg'] = $checkPropAndChithaAndUlpn['ulpinMsg'];

            if ($data['ulpinCheck'] == 1) {
                $data['ulpin'] = $checkPropAndChithaAndUlpn['ulpin'];
                if (isset($data['old_ulpin']))
                    $data['old_ulpin'] = $checkPropAndChithaAndUlpn['old_ulpin'];
                else
                    $data['old_ulpin'] = "";
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

        $this->session->set_userdata('accessible_case_no', $details->case_no);

        $data['_view'] = 'LegacyDataUpdation/FirstCoProcess';
        $this->load->view('layouts/main', $data);
    }

    public function SaveCoProcess()
    {
        // dd("here");
        $user_desig_code = $this->session->userdata('user_desig_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        if (!in_array($user_desig_code, ['CO'])) {
            $this->session->set_flashdata('message', 'You are not authorized to perform this action.');
            return redirect($_SERVER['HTTP_REFERER']);
        }

        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST, [], [], ['sugested_patta_type' => true, 'final_report' => true]);
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

        $db =  $this->session->userdata('db');
        $proposal_no = $this->input->POST('proposal_no');
        $case_no = $this->input->POST('case_no');
        $co_report = $this->input->POST('co_report');

        $condition = ['case_no' => $case_no, 'dist_code' => $dist_code, 'subdiv_code' => $subdiv_code, 'cir_code' => $cir_code];
        $tLegacyupdation = $this->legacyModel->get_row($condition);

        if (!$tLegacyupdation) {
            $this->session->set_flashdata('message', 'No such case found or this case doesn\'t belong to you.');
            return redirect($_SERVER['HTTP_REFERER']);
        }

        if (!$tLegacyupdation->lm_note) {
            $this->session->set_flashdata('message', 'This case is on the responsible Lot Mondal\'s side');
            return redirect($_SERVER['HTTP_REFERER']);
        }

        if ($tLegacyupdation->co_yn) {
            $this->session->set_flashdata('message', 'You have already forwarded/passed this case.');
            return redirect($_SERVER['HTTP_REFERER']);
        }


        // $co_report1 = $this->input->POST('co_report');
        // $co_report_suffix = $this->input->POST('designation_suffix');
        // $co_report = $co_report1 . " - " . $co_report_suffix;
        $co_report = str_replace("'", '', $co_report);

        $application_no = $this->input->POST('application_no');
        if (!empty($application_no)) {
            $basundhara = $this->basundharamodel->checkExistBasundhar($case_no);
            if (!$basundhara) {
                $this->session->set_flashdata('message', 'No such case found. Please try again later.');
                return redirect($_SERVER['HTTP_REFERER']);
            }
        }

        // $final_report = $this->input->POST('final_report') . " - " . $co_report_suffix;
        $final_report = $this->input->POST('final_report');
        $co_signature = $this->UserModel->get_user_identification();
        $final_report = str_replace("'", '', $final_report);

        $co_code = $this->session->userdata('user_code');
        $designation = $this->session->userdata('user_desig_code');
        $co_sign = 'Y';
        $co_date_entry = date('Y-m-d G:i:s');

        $order_type = $this->input->POST('order_type');
        $co_array = array(
            'order' => $co_report,
            'case_no' => $case_no,
            'proposal_no' => $proposal_no,
            'final_report' => $final_report . ' - ' . $co_signature,
            'designation' => $designation,
            'application_no' => $application_no,
            'report_without_suffix' => $final_report,
        );
        $this->session->set_userdata('co_array', $co_array);

        $this->db->trans_begin();

        if ($order_type == 'forward_to_dc') {
            $dc_adc_code = $this->input->POST('dc_code');
            // $this->db->query("UPDATE t_legacyupdation SET co_yn = 'Y', co_note = '$co_report', co_orddate = '$co_date_entry', co_code = '$co_code', dc_adc_code = '$dc_adc_code' "
            //         . "WHERE case_no = '$case_no' and proposal_no = '$proposal_no'");

            $update_data = [
                'co_yn' => 'Y',
                // 'co_note' => $co_report,
                'co_note' => $final_report . ' - ' . $co_signature,
                'co_orddate' => $co_date_entry,
                'co_code' => $co_code,
                'dc_adc_code' => $dc_adc_code,
            ];

            $this->db->update('t_legacyupdation', $update_data, array('case_no' => $case_no, 'proposal_no' => $proposal_no));

            // $this->session->set_flashdata('message', "Legacy data Updation Case no # $case_no Forwarded to DC/ADC after verification.");
            // redirect(base_url() . "index.php/home");

            if ($application_no) {
                $rtps = $this->rtpsmodel->checkRtpsService($application_no);
                if ($rtps == 'RTPS') {
                    $apilink = RTPS_API_LINK;
                } else {
                    $apilink = API_LINK;
                }

                $api_param = [
                    'application' => $application_no,
                    'dharitree' => $case_no,
                    'rmk' => 'forwared to DC',
                    'status' => 'M',
                    'task' => 'CO',
                    'pen' => 'DC',
                    'penat' => 'DC office'
                ];

                $result = sendCurlRequest($apilink, 'POST', $api_param);
                // $curl_handle = curl_init();
                // curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
                // curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                // curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                // curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                // curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 10); // setting 10 seconds 
                // curl_setopt($curl_handle, CURLOPT_TIMEOUT, 30); // setting 30 seconds
                // curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                //     'application' => $application_no,
                //     'dharitree' => $case_no,
                //     'rmk' => 'forwared to DC',
                //     'status' => 'M',
                //     'task' => 'CO',
                //     'pen'=>'DC',
                //     'penat'=>'DC office'
                // )));
                // $result = curl_exec($curl_handle);
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                log_message('error', '#ERRLGCYUPCO00001: Something went wrong. QUERY: ' . $this->db->last_query());
                $this->session->set_flashdata('message', "#ERRLGCYUPCO00001: Something went wrong. Please try again later.");
                return redirect($_SERVER['HTTP_REFERER']);
                // echo "Error Occured";
            }

            // $condition = ['case_no' => $case_no];
            // $updated_tLegacyupdation = $this->legacyModel->get_row($condition);
            $change_request_string = $this->legacyModel->get_change_request_string($tLegacyupdation);

            $log_data = [
                'case_no' => $case_no,
                'proceeding_id' => $this->PetitionProceedingModel->getAutoIncrementalProceedingNo($case_no),
                'date_of_hearing' => date('Y-m-d H:i:s'),
                'date_entry' => date('Y-m-d H:i:s'),
                'co_order' => $final_report . ' | ' . $this->UserModel->get_user_identification(),
                'additional_notes' => 'পৰিবৰ্তনৰ বাবে আবেদন: ' . $change_request_string . $this->UserModel->get_user_identification(),
                'operation' => 'E',
                'dist_code' => $tLegacyupdation->dist_code,
                'subdiv_code' => $tLegacyupdation->subdiv_code,
                'cir_code' => $tLegacyupdation->cir_code,
                'status' => 'Final',
                'user_code' => $co_code,
                'ip' => $this->utilityclass->get_client_ip(),
            ];

            $log_response = $this->PetitionProceedingModel->store_legacy_logs($log_data);

            if ($log_response['success']) {
                $this->db->trans_commit();

                $this->session->set_flashdata('message', "Legacy data Updation Case no # $case_no Forwarded to DC/ADC after verification.");

                redirect(base_url() . "index.php/home");
            } else {
                $this->db->trans_rollback();

                $this->session->set_flashdata('message', $log_response['message']);
                return redirect($_SERVER['HTTP_REFERER']);
            }
            // $this->db->trans_commit();
            // $this->session->set_flashdata('message', "Legacy data Updation Case no # $case_no Forwarded to DC/ADC after verification.");
            // echo "string";die;
            //////////////////////////////////
            // $data=array(
            //     'success'=>"ADC's Report on Reclassification Case no $case_no",
            //     'redirect_url'=>base_url().'index.php/home'
            // );
            // redirect(base_url() . "index.php/home");

            // echo json_encode($data);

        } elseif ($order_type == 'reject') {

            redirect(base_url() . "index.php/LegacyDataUpdation/reject");
        } else {
            // Pass final order By CO for RTPS case
            if (!$basundhara) {
                $this->session->set_flashdata('message', 'You can\'t "Pass order" for this case. Forward to ADC/DC.');
                return redirect($_SERVER['HTTP_REFERER']);
            }

            $db = $this->session->userdata('db');

            if (ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'), json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))) {

                // edit for property chain
                $ulpin = $this->input->post('ulpin', true);
                $old_ulpin = $this->input->post('old_ulpin', true);
                if ($old_ulpin == null)
                    $old_ulpin = "";
                $ulpinCheckFlag = $this->input->post('ulpinCheckFlag');
                $compareCheckFlag = $this->input->post('compareCheckFlag');

                //   redirect(base_url() . "index.php/LegacyDataUpdation/AutoUpdation?ulpin=" . $ulpin . "&old_ulpin=" . $old_ulpin. "&ulpinCheckFlag=".$ulpinCheckFlag. "&compareCheckFlag=".$compareCheckFlag);  

                $this->AutoUpdation($db, $co_array, $co_signature, $ulpin, $old_ulpin, $ulpinCheckFlag, $compareCheckFlag);
            } else {
                // redirect(base_url() . "index.php/LegacyDataUpdation/AutoUpdation");
                $this->AutoUpdation($db, $co_array, $co_signature);
            }
        }
    }

    public function FirstDCProcess()
    {
        $db =  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');

        $_GET['case_no'] = dec_param($this->input->get('case_no'), 'case_no');
        if ($_GET['case_no'] == null) {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }
        $case_no = $_GET['case_no'];
        $proposal_no = $this->input->GET('proposal_no');
        $q = "SELECT * 
            FROM t_legacyupdation 
            WHERE case_no = ? 
            AND proposal_no = ?";
            
        $details = $data['details'] = $this->db->query($q, [$case_no, $proposal_no])->row();


        $old_patta = $this->db
            ->query("SELECT * FROM patta_code WHERE type_code = ?", [$details->patta_type_code])
            ->row();

        $old_land_class = $this->db
            ->query("SELECT * FROM landclass_code WHERE class_code = ?", [$details->present_land_class])
            ->row();

        $designation = $this->db
            ->query("SELECT * FROM master_user_designation WHERE user_desig_code = ?", [$user_desig_code])
            ->row();


        $dist_code = $this->utilityclass->getDistrictName($details->dist_code);
        $subdiv_code = $this->utilityclass->getSubDivName($details->dist_code, $details->subdiv_code);
        $cir_code = $this->utilityclass->getCircleName($details->dist_code, $details->subdiv_code, $details->cir_code);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code);
        $lot_no = $this->utilityclass->getLotName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no);
        $vill_townprt_code = $this->utilityclass->getVillageName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $details->vill_townprt_code);

        $dc_name = $this->utilityclass->dcname($details->dist_code, $user_code);
        $data['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code,
            'dc_name' => $dc_name,
            'designation' => $designation->user_desig_as
        );

        if ($details->suggested_patta_no != null) {
            $q = "SELECT dag_no AS dag_no 
                FROM chitha_basic p 
                WHERE p.dist_code = ? 
                    AND p.subdiv_code = ? 
                    AND p.cir_code = ? 
                    AND p.mouza_pargona_code = ? 
                    AND p.vill_townprt_code = ? 
                    AND p.lot_no = ? 
                    AND TRIM(p.patta_no) = ? 
                    AND p.patta_type_code = ?";

            $datas = $this->db->query($q, [
                $details->dist_code,
                $details->subdiv_code,
                $details->cir_code,
                $details->mouza_pargona_code,
                $details->vill_townprt_code,
                $details->lot_no,
                $details->suggested_patta_no,
                $details->patta_type_code
            ])->result();

            $string = '';
            $comma1 = ' অই ' . $details->suggested_patta_no . ' নং পট্টাত আগৰ পৰাই ';
            $comma2 = ' নং দাগ অন্তৰভূক্ত সই আছে ।';
            foreach ($datas as $key => $value) {
                if ($key != '0') {
                    $comma1 = ", ";
                }

                $string = $string . $comma1 . $value->dag_no;
            }

            if (!empty($string)) {
                $string = $string . $comma2;
            }
            $data['patta_remarks'] = $string;
        }

        $data['new_patta_type'] = $data['new_land_class'] = NULL;
        if (!empty($details->suggested_patta_type)) {
            $new_patta = $this->db
                ->query("SELECT * FROM patta_code WHERE type_code = ?", [$details->suggested_patta_type])
                ->row();

            if ($new_patta) {
                $data['new_patta_type'] = $new_patta->patta_type;
            }
        }

        if (!empty($details->suggested_land_class)) {
            $new_land_class = $this->db
                ->query("SELECT * FROM landclass_code WHERE class_code = ?", [$details->suggested_land_class])
                ->row();

            if ($new_land_class) {
                $data['new_land_class'] = $new_land_class->land_type;
            }
        }


        $data['det'] = array(
            'patta_type' => $old_patta->patta_type,
            'old_land_class' => $old_land_class->land_type
        );

        $data['Pcases'] = $details;

        //////////////////////////////////////////////////////////////// Property Chain Code //////////////////////////////////////////////

        if (ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'), json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))) {

            $this->load->model('propChain/PropChainModel');
            // echo "<pre>";
            // var_dump($data['Petitioner']);
            // die;
            // var_dump($propData['dist_code']);

            $data['propChainEnableFlag'] = $this->PropChainCommonModel->isLocationEnable($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $details->vill_townprt_code);

            $land_area = $this->PropChainModel->getLandArea($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $details->vill_townprt_code, $details->patta_no, $details->dag_no);

            $checkPropAndChithaAndUlpn = $this->PropChainModel->chainChithaUlpinCheckProcess($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $details->vill_townprt_code, $details->patta_no, $details->dag_no, $land_area->dag_area_b, $land_area->dag_area_k, $land_area->dag_area_lc, $land_area->dag_area_g, $details->patta_type_code);

            // update flag only if ulpin found

            if ($checkPropAndChithaAndUlpn['ulpinCheck'] == 1 && ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'Y' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'NE')) {
                $this->PropChainModel->updateCmpFlag($case_no, $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag']);
                // if mismatch case get the view mismatch case button
                if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N')
                    $data['viewMisMatchBtn'] =  $this->PropChainModel->getMismatchBtn($case_no, $details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $details->vill_townprt_code, $details->patta_no, $details->dag_no, $land_area->dag_area_b, $land_area->dag_area_k, $land_area->dag_area_lc, $land_area->dag_area_g, $details->patta_type_code);
            }

            $data['ulpinCheck'] = $checkPropAndChithaAndUlpn['ulpinCheck'];
            $data['ulpinMsg'] = $checkPropAndChithaAndUlpn['ulpinMsg'];

            if ($data['ulpinCheck'] == 1) {
                $data['ulpin'] = $checkPropAndChithaAndUlpn['ulpin'];
                if (isset($data['old_ulpin']))
                    $data['old_ulpin'] = $checkPropAndChithaAndUlpn['old_ulpin'];
                else
                    $data['old_ulpin'] = "";
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

        $this->session->set_userdata('accessible_case_no', $details->case_no);

        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/LegacyDataUpdation/FirstDCProcess', $data);
        // $this->load->view('../views/footer');
        $application_no = "select * from basundhar_application where dharitree='$case_no' ";
        $data['app'] = $this->db->query($application_no)->row();
        $data['basundharaAttachment'] = array();
        $basundhara = $this->basundharamodel->checkExistBasundhar($case_no);
        if ($basundhara) {
            $rtps = $this->rtpsmodel->checkBasundharaService($case_no);
            if ($rtps == 'RTPS') {
                $data['basundharaAttachment'] = $this->rtpsmodel->searchBasundharaLink($case_no);
            } else {
                $data['basundharaAttachment'] = $this->basundharamodel->searchBasundharaLink($case_no);
            }
        }
        $data['_view'] = 'LegacyDataUpdation/FirstDCProcess';
        $this->load->view('layouts/main', $data);
    }

    public function SaveDcProcess()
    {
        $user_desig_code = $this->session->userdata('user_desig_code');
        $dist_code = $this->session->userdata('dist_code');

        if (!in_array($user_desig_code, ['ADC', 'DC'])) {
            $this->session->set_flashdata('message', 'You are not authorized to perform this action.');
            return redirect($_SERVER['HTTP_REFERER']);
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
            $this->session->set_flashdata('message', $errorMessageStr);
            return redirect($_SERVER['HTTP_REFERER']);
        }

        $db =  $this->session->userdata('db');
        $proposal_no = $this->input->POST('proposal_no');
        $case_no = $this->input->POST('case_no');
        $dc_report1 = $this->input->POST('dc_report');
        $dc_report_suffix = $this->input->POST('designation_suffix');
        $dc_report = $dc_report1 . " - " . $dc_report_suffix;
        $dc_report = str_replace("'", '', $dc_report);

        $condition = ['case_no' => $case_no, 'dist_code' => $dist_code];
        $tLegacyupdation = $this->legacyModel->get_row($condition);

        if (!$tLegacyupdation) {
            $this->session->set_flashdata('message', 'No such case found or this case does not belong to you.');
            return redirect($_SERVER['HTTP_REFERER']);
        }

        if ($tLegacyupdation->status == 'F') {
            $this->session->set_flashdata('message', 'This case is already passed');
            return redirect($_SERVER['HTTP_REFERER']);
        }

        if (!$tLegacyupdation->co_yn) {
            $this->session->set_flashdata('message', 'This case is not on your side');
            return redirect($_SERVER['HTTP_REFERER']);
        }

        if ($tLegacyupdation->dc_yn) {
            $this->session->set_flashdata('message', 'You have already forwarded this case.');
            return redirect($_SERVER['HTTP_REFERER']);
        }

        $dc_adc_signature = $this->UserModel->get_user_identification();
        // $final_report = $this->input->POST('final_report') . " - " . $dc_report_suffix;
        $final_report = $this->input->POST('final_report');
        $final_report = str_replace("'", '', $final_report);

        $dc_code = $this->session->userdata('user_code');
        $designation = $this->session->userdata('user_desig_code');
        $dc_sign = 'Y';
        $dc_date_entry = date('Y-m-d G:i:s');

        $order_type = $this->input->POST('order_type');

        $co_array = array(
            'order' => $dc_report,
            'case_no' => $case_no,
            'proposal_no' => $proposal_no,
            'final_report' => $final_report . ' - ' . $dc_adc_signature,
            'designation' => $designation,
            'report_without_suffix' => $final_report
        );
        $this->session->set_userdata('co_array', $co_array);

        if ($order_type == 'reject') {
            redirect(base_url() . "index.php/LegacyDataUpdation/Reject");
        } else {
            $db = $this->session->userdata('db');
            if (ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'), json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))) {
                $ulpin = $this->input->post('ulpin', true);
                $old_ulpin = $this->input->post('old_ulpin', true);
                $ulpinCheckFlag = $this->input->post('ulpinCheckFlag');
                $compareCheckFlag = $this->input->post('compareCheckFlag');

                return $this->AutoUpdation($db, $co_array, $dc_adc_signature, $ulpin, $old_ulpin, $ulpinCheckFlag, $compareCheckFlag);

                //   redirect(base_url() . "index.php/LegacyDataUpdation/AutoUpdation?ulpin=" . $ulpin . "&old_ulpin=" . $old_ulpin. "&ulpinCheckFlag=".$ulpinCheckFlag. "&compareCheckFlag=".$compareCheckFlag);  
            } else {
                //echo "SERVER-120".$dist_code.$case_no;
                $this->AgriStackCaseHistory->CreateLog($dist_code, $case_no);
                // $this->AgriStackCaseHistory->CreateLogFile($dist_code, $case_no);
                return $this->AutoUpdation($db, $co_array, $dc_adc_signature);
                // redirect(base_url() . "index.php/LegacyDataUpdation/AutoUpdation");
            }
        }
    }

    public function revertCase()
    {
        $user_desig_code = $this->session->userdata('user_desig_code');
        $user_code = $this->session->userdata('user_code');
        if (!in_array($user_desig_code, ['CO', 'ADC', 'DC'])) {
            return response_json([
                'responseType' => 1,
                'errors' => [],
                'message' => 'You are not authorized to perform this action.',
            ], '403');
        }

        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST, [], [], ['remark' => true]);
        if ($resp['status'] == 'n') {
            $errorMessageStr .= $resp['messages'];
        }

        $resp = checkRequestValidQuery($_POST);
        if ($resp['status'] == 'n') {
            $errorMessageStr .= $resp['messages'];
        }

        if ($errorMessageStr != '') {
            return response_json([
                'responseType' => 1,
                'errors' => [],
                'message' => $errorMessageStr,
            ], '403');
        }

        $case_no = $this->input->post('case_no');
        $revert_remarks = $this->input->post('remark');
        if (empty($revert_remarks)) {
            return response_json([
                'responseType' => 1,
                'errors' => [],
                'message' => 'The remark field is required',
            ], '403');
        }
        if (empty($case_no)) {
            return response_json([
                'responseType' => 1,
                'errors' => [],
                'message' => 'Unable to get the case no',
            ], '403');
        }

        if ($tLegacyupdation = $this->db->where('case_no', $case_no)->get('t_legacyupdation')->row()) {

            $api_param = [
                'dharitree' => $case_no,
                'status' => 'M',
                'task' => $user_desig_code // CO, ADC, DC
            ];

            if (!$tLegacyupdation->co_yn && !$tLegacyupdation->dc_yn && $tLegacyupdation->lm_note) {
                // Revert To LM

                $update_data = [
                    'lm_note' => NULL,
                    // 'co_yn' => NULL,
                ];

                $api_param = $api_param + [
                    'rmk' => 'Reverted to LM by CO',
                    'pen' => 'LM',
                    'penat' => 'LM office'
                ];
            } elseif ($tLegacyupdation->co_yn && !$tLegacyupdation->dc_yn) {
                // Revert to CO From ADC or DC
                $update_data = [
                    'co_note' => NULL,
                    'co_yn' => NULL,
                ];

                $api_param = $api_param + [
                    'rmk' => 'Reverted to CO by ' . $user_desig_code,
                    'pen' => 'CO',
                    'penat' => 'CO office'
                ];
            } else {
                return response_json([
                    'responseType' => 1,
                    'errors' => [],
                    'message' => 'Case has already been reverted or passed',
                ], '403');
            }

            $this->db->trans_begin();
            $response = $this->legacyModel->revert($tLegacyupdation, $update_data, $api_param);
            if ($response['success']) {
                $log_data = [
                    'case_no' => $case_no,
                    'proceeding_id' => $this->PetitionProceedingModel->getAutoIncrementalProceedingNo($case_no),
                    'date_of_hearing' => date('Y-m-d H:i:s'),
                    'date_entry' => date('Y-m-d H:i:s'),
                    'co_order' => "Revert: " . $revert_remarks . ' | ' . $this->UserModel->get_user_identification(),
                    'operation' => 'E',
                    'dist_code' => $tLegacyupdation->dist_code,
                    'subdiv_code' => $tLegacyupdation->subdiv_code,
                    'cir_code' => $tLegacyupdation->cir_code,
                    'status' => 'Final',
                    'user_code' => $user_code,
                    'ip' => $this->utilityclass->get_client_ip(),
                ];

                $log_response = $this->PetitionProceedingModel->store_legacy_logs($log_data);

                if ($log_response['success']) {
                    $this->db->trans_commit();

                    return response_json([
                        'responseType' => 2,
                        'data' => [],
                        'redirectUrl' => base_url('index.php/Home/index'),
                        'message' => $response['message']
                    ], 200);
                } else {
                    $this->db->trans_rollback();

                    return response_json([
                        'responseType' => 1,
                        'errors' => [],
                        'message' => $log_response['message']
                    ], 403);
                }
            } else {
                $this->db->trans_rollback();

                $data = [
                    'responseType' => 1,
                    'errors' => [],
                    'message' => $response['message']
                ];

                return response_json($data, '403');
            }
        } else {
            $data = [
                'responseType' => 1,
                'errors' => [],
                'message' => 'No such case found'
            ];

            return response_json($data, '403');
        }
    }

    public function getLogs()
    {
        $case_no = $this->input->post('case_no');

        if (!empty($case_no)) {
            // $case_no = 'KAM/UTT/2016-17/510/OPART';
            $conditions = ['case_no' => $case_no];
            $data['case_no'] = $case_no;
            $data['logs'] = $this->PetitionProceedingModel->get_rows_array($conditions);
            $html = $this->load->view('LegacyDataUpdation/history', $data, TRUE);

            return response_json([
                'responseType' => 2,
                'data' => [
                    'html' => $html,
                ],
                'message' => 'Data fetched successfully'
            ]);
        } else {
            return response_json([
                'responseType' => 1,
                'errors' => [],
                'message' => 'Unable to get the case no to fetch the logs.',
            ], 403);
        }
    }

    public function AutoUpdation($db, $co_array, $signature, $ulpin = NULL, $old_ulpin = NULL, $ulpinCheckFlag = NULL, $compareCheckFlag = NULL)
    {
        // $db=  $this->session->userdata('db');
        // $proposal_no = $this->session->userdata['co_array']['proposal_no'];
        // $case_no = $this->session->userdata['co_array']['case_no'];
        // $finalcoorder = $this->session->userdata['co_array']['order'];
        // $final_report = $this->session->userdata['co_array']['final_report'];
        // $designation = $this->session->userdata['co_array']['designation'];
        $proposal_no = $co_array['proposal_no'];
        $case_no = $co_array['case_no'];
        $finalcoorder = $co_array['order'];
        $final_report = $co_array['final_report'];
        $designation = $co_array['designation'];
        $report_without_suffix = $co_array['report_without_suffix'];
        $date_entry = date('Y-m-d');

        $q = "select * from t_legacyupdation where case_no =? and proposal_no =? ";
        $data = $this->db->query($q, array($case_no, $proposal_no))->row();

        if ($data->auth_type == 'AADHAAR') {
            $aadharNo = $data->id_ref_no;
            $panNo = null;
            // $photo = $data->photo;
            $photo = NULL;
        } else if ($data->auth_type == 'PAN') {
            $panNo = $data->id_ref_no;
            $aadharNo = null;
            $photo = null;
        } else {
            $panNo = null;
            $aadharNo = null;
            $photo = null;
        }
        if ($data->auth_type != null || $data->auth_type == 'AADHAAR' || $data->auth_type == 'PAN') {
            // $chithaUpdates = "UPDATE chitha_pattadar SET 
            // pdar_aadharno = '$aadharNo',pdar_pan_no='$panNo',pdar_photo='$photo'
            // WHERE TRIM(patta_no)=trim(?) AND pdar_id=? AND dist_code=? AND 
            // subdiv_code=? AND cir_code=? AND lot_no=? AND mouza_pargona_code=? AND
            // vill_townprt_code=? and pdar_id =? and patta_type_code = ?";
            // $this->db->query($chithaUpdates, array($data->patta_no, $data->pdar_id, $data->dist_code, 
            // $data->subdiv_code, $data->cir_code, $data->lot_no, $data->mouza_pargona_code, 
            // $data->vill_townprt_code,$data->pdar_id,$data->patta_type_code)); 

            $table = 'chitha_pattadar';

            $params = [
                'pdar_aadharno' => $aadharNo,
                'pdar_pan_no'   => $panNo,
                'pdar_photo'    => $photo,
                'f1_case_no'      => $case_no
            ];

            $where = [
                'patta_no'           => trim($data->patta_no),  // matches TRIM()
                'pdar_id'            => $data->pdar_id,
                'dist_code'          => $data->dist_code,
                'subdiv_code'        => $data->subdiv_code,
                'cir_code'           => $data->cir_code,
                'lot_no'             => $data->lot_no,
                'mouza_pargona_code' => $data->mouza_pargona_code,
                'vill_townprt_code'  => $data->vill_townprt_code,
                'patta_type_code'    => $data->patta_type_code,
            ];

            $result_cp = $this->Chitha_basic_model->update_table($table, $params, $where);

            if ($result_cp <= 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRAREACOR001: Updation failed in chitha_pattadar for case no : ' . $this->db->last_query());
                $this->session->set_flashdata('message', "#ERRAREACOR001: Final submission failed for case no : " . $case_no);
                redirect(base_url() . "index.php/home");
                echo "Error Occured";
                return false;
            }
        }


        //==========check dag pending in blockchain or not=================
        if (ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'), json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))) {
            $checkVal = $this->PropChainCommonModel->checkDagExistsInPropChainInPending($data->dist_code, $data->subdiv_code, $data->cir_code, $data->mouza_pargona_code, $data->lot_no, $data->vill_townprt_code, $data->dag_no);
            if ($checkVal === false) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERRORBLOCCHAIN6166 : You cannot procced as dag no is pending for property chain update...");
                redirect(base_url() . "index.php/home");
            }
        }
        ///=============end CODE=====================

        //#START PLB 
        // if (($data->suggested_dag_area_b != '') && ($data->suggested_dag_area_k != '') && ($data->suggested_dag_area_lc != '') && ($data->suggested_dag_area_g != '')) {
        //     $this->FinalupdateLandArea($data->case_no, $data->proposal_no);
        // }
        if (in_array($data->dist_code, json_decode(BARAK_VALLEY))) {
            if (($data->suggested_dag_area_b != '') && ($data->suggested_dag_area_k != '') && ($data->suggested_dag_area_lc != '') && ($data->suggested_dag_area_g != '')) {
                $this->AgriStackCaseHistory->CreateLog($data->dist_code, $data->case_no);
                $this->FinalupdateLandArea($data->case_no, $data->proposal_no);
                //////// edit for property chain //////
                $chain_bigha = $data->suggested_dag_area_b;
                $chain_katha = $data->suggested_dag_area_k;
                $chain_lessa = $data->suggested_dag_area_lc;
                if ($data->suggested_dag_area_g == null || $data->suggested_dag_area_g == '')
                    $chain_ganda = 0;
                else
                    $chain_ganda = $data->suggested_dag_area_g;
            } else {
                $chain_bigha = $data->dag_area_b;
                $chain_katha = $data->dag_area_k;
                $chain_lessa = $data->dag_area_lc;
                $chain_ganda = $data->dag_area_g;
            }
        } else {
            if (($data->suggested_dag_area_b != '') && ($data->suggested_dag_area_k != '') && ($data->suggested_dag_area_lc != '')) {
                $this->AgriStackCaseHistory->CreateLog($data->dist_code, $data->case_no);
                $this->FinalupdateLandArea($data->case_no, $data->proposal_no);
                //////// edit for property chain //////
                $chain_bigha = $data->suggested_dag_area_b;
                $chain_katha = $data->suggested_dag_area_k;
                $chain_lessa = $data->suggested_dag_area_lc;
                if ($data->suggested_dag_area_g == null || $data->suggested_dag_area_g == '')
                    $chain_ganda = 0;
                else
                    $chain_ganda = $data->suggested_dag_area_g;
            } else {
                $chain_bigha = $data->dag_area_b;
                $chain_katha = $data->dag_area_k;
                $chain_lessa = $data->dag_area_lc;
                $chain_ganda = $data->dag_area_g;
            }
        }
        //#END PLB

        if (($data->suggested_land_class != '0') and ($data->suggested_land_class != '')) {
            $this->AgriStackCaseHistory->CreateLog($data->dist_code, $data->case_no);
            $this->FinalupdateLandClass($data->case_no, $data->proposal_no);

            //////// edit for property chain //////
            $land_class_code = $data->suggested_land_class;
        } else
            $land_class_code = $data->present_land_class;
        ///////////////////////////////////////////// 


        if ($data->suggested_land_rev != '') {
            $this->FinalupdatelandRev($data->case_no, $data->proposal_no);

            //////// edit for property chain //////
            $land_revenue = $data->suggested_land_rev;
        } else
            $land_revenue = $data->present_land_revenue;
        ///////////////////////////////////////////// 

        if ($data->suggested_loc_tax != '') {
            $this->FinalupdateLocalTax($data->case_no, $data->proposal_no);

            //////// edit for property chain //////
            $local_tax = $data->suggested_loc_tax;
        } else
            $local_tax = $data->present_land_localtax;
        ///////////////////////////////////////////// 

        // If requesting for suggested_patta_type & suggested_patta_no both
        if (!in_array($data->suggested_patta_type, ['0', '']) && !in_array($data->suggested_patta_no, ['0', ''])) {
            $this->AgriStackCaseHistory->CreateLogFile($data->dist_code, $data->case_no);
            $this->AgriStackCaseHistory->CreateLog($data->dist_code, $data->case_no);
            $this->FinalupdatePattaNoNdPattaType($data->case_no, $data->proposal_no);
            $patta_type_code = $data->suggested_patta_type;
        } else {
            if (($data->suggested_patta_type != '0') and ($data->suggested_patta_type != '')) {
                $this->AgriStackCaseHistory->CreateLogFile($data->dist_code, $data->case_no);
                $this->FinalupdatePattaType($data->case_no, $data->proposal_no);
                $this->AgriStackCaseHistory->CreateLog($data->dist_code, $data->case_no);
                // $this->FinalupdatePattaNo($data->case_no, $data->proposal_no);

                //////// edit for property chain //////
                $patta_type_code = $data->suggested_patta_type;
            } else {
                $patta_type_code = $data->patta_type_code;
            }

            if (($data->suggested_patta_no != '0') and ($data->suggested_patta_no != '')) {
                $this->AgriStackCaseHistory->CreateLogFile($data->dist_code, $data->case_no);
                $this->FinalupdatePattaNo($data->case_no, $data->proposal_no);
                $this->AgriStackCaseHistory->CreateLog($data->dist_code, $data->case_no);
            }
        }

        // Old process ###########
        // if (($data->suggested_patta_type != '0') and ($data->suggested_patta_type != '')) {
        //     $this->FinalupdatePattaType($data->case_no, $data->proposal_no);
        //     // $this->FinalupdatePattaNo($data->case_no, $data->proposal_no);

        //     //////// edit for property chain //////
        //     $patta_type_code = $data->suggested_patta_type;
        // } else
        //     $patta_type_code = $data->patta_type_code;

        ///////////////////////////////////////////// 

        // if (($data->pdar_id != '0') || ($data->p_flag != null)) {
        //     //$this->FinalupdatePattaType($data->case_no, $data->proposal_no);
        //     $this->FinalupdatePdar($data->dist_code, $data->subdiv_code, $data->cir_code, $data->mouza_pargona_code, $data->lot_no, $data->vill_townprt_code, $data->case_no, $data->proposal_no, $data->dag_no, $data->patta_no, $data->patta_type_code);
        // }

        // Old process ###########
        // if (($data->suggested_patta_no != '0') and ($data->suggested_patta_no != '')) {
        //     $this->FinalupdatePattaNo($data->case_no, $data->proposal_no);
        // }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message('error', '#ERRAUTOUPDT0001: Query ' . $this->db->last_query());
            $this->session->set_flashdata('message', '#ERRAUTOUPDT0001: Sorry...Modification Cannot be Done here !! Please Contact Help Desk !!');
            redirect(base_url() . "index.php/home");
            echo "Error Occured";
        } else {

            $condition = ['case_no' => $case_no];
            $tLegacyupdation = $this->legacyModel->get_row($condition);
            $change_request_string = $this->legacyModel->get_change_request_string($tLegacyupdation);

            $log_data = [
                'case_no' => $case_no,
                'proceeding_id' => $this->PetitionProceedingModel->getAutoIncrementalProceedingNo($case_no),
                'date_of_hearing' => date('Y-m-d H:i:s'),
                'date_entry' => date('Y-m-d H:i:s'),
                'co_order' => $report_without_suffix . ' | ' . $signature,
                'additional_notes' => 'পৰিবৰ্তনৰ বাবে আবেদন: ' . $change_request_string . $signature,
                'operation' => 'E',
                'dist_code' => $tLegacyupdation->dist_code,
                'subdiv_code' => $tLegacyupdation->subdiv_code,
                'cir_code' => $tLegacyupdation->cir_code,
                'status' => 'Final',
                'user_code' => $designation,
                'ip' => $this->utilityclass->get_client_ip(),
            ];

            $log_response = $this->PetitionProceedingModel->store_legacy_logs($log_data);

            if (!$log_response['success']) {
                $this->db->trans_rollback();

                $this->session->set_flashdata('message', $log_response['message']);
                return redirect($_SERVER['HTTP_REFERER']);
            } else {
            }

            ////////////////////////////////////////////////////////////////////////////////////// property chain code ///////////////////////////////////////////////////////////////////////////////////

            $save_chain_data = true;
            if (ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'), json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))) {
                // $ulpinFlag = $this->input->get('ulpinCheckFlag');
                // $compareFlag = $this->input->get('compareCheckFlag');
                $ulpinFlag = $ulpinCheckFlag;
                $compareFlag = $compareCheckFlag;
                //var_dump($compareFlag);exit;



                if ($compareFlag == 'Y' && $ulpinFlag == 1) {

                    //////////////////////////////////////////////////////////////////////////////
                    if (($data->suggested_patta_no != '0') and ($data->suggested_patta_no != '')) {
                        $patta_no = $data->suggested_patta_no;
                    } else {
                        $patta_no = $data->patta_no;
                    }
                    //////////////////////////////////////////////////////////////////////////////
                    $dag_no = $data->dag_no;
                    // $ulpin= $this->input->get('ulpin');
                    // $old_ulpin = $this->input->get('old_ulpin');
                    $ulpin = $ulpin;
                    $old_ulpin = $old_ulpin;

                    if ($old_ulpin == null)
                        $old_ulpin = "";

                    $property_signature = "base64 encoded signature";
                    $property_signer_key = "base64 encoded public key";

                    $office_code = $this->session->userdata('cir_code');
                    $user_code = $this->session->userdata('user_code');

                    $location_id = $data->dist_code . $data->subdiv_code . $data->cir_code . $data->mouza_pargona_code . $data->lot_no . $data->vill_townprt_code;

                    $certmnemonic = CERTMNEMONIC_LEGACY;

                    $property_id = $this->blockchainutilityclass->generatePropertyId(LOC_TYPE_RURAL, $data->vill_townprt_code, $patta_no, $data->dag_no, $ulpin);



                    $pattadar_details = $this->PropChainModel->getPattadars($data->dist_code, $data->subdiv_code, $data->cir_code, $data->mouza_pargona_code, $data->lot_no, $data->vill_townprt_code, $patta_no, $dag_no);

                    // since below parameters are not applicable sent empty string
                    $new_patta_no = $new_dag_no = $old_revenue = $old_local_tax = $old_land_class = $new_bigha = $new_katha = $new_lessa = $new_ganda = "";
                    // 
                    $update_params = array(
                        'pattadar_details' => $pattadar_details,
                        'location_id' => $location_id,
                        'property_id' => $property_id,
                        'reference_id' => $case_no,
                        'dag_no' => $dag_no,
                        'patta_no' => $patta_no,
                        'patta_type_code' => $patta_type_code,
                        'land_class_code' => $land_class_code,
                        'bigha_chain' => $chain_bigha,
                        'katha_chain' => $chain_katha,
                        'lessa_chain' => $chain_lessa,
                        'ganda_chain' => $chain_ganda,
                        'certmnemonic' => $certmnemonic,
                        'property_signature' => $property_signature,
                        'property_signer_key' => $property_signer_key,
                        'office_code' => $office_code,
                        'user_code' => $user_code,
                        'ulpin' => $ulpin,
                        'old_ulpin' => $old_ulpin,
                        'revenue' => $land_revenue,
                        'local_tax' => $local_tax,
                        'new_patta_no' => $new_patta_no,
                        'new_dag_no' => $new_dag_no,
                        'old_revenue' => $old_revenue,
                        'old_local_tax' => $old_local_tax,
                        'old_land_class_code' => $old_land_class,
                        'new_bigha' => $new_bigha,
                        'new_katha' => $new_katha,
                        'new_lessa' => $new_lessa,
                        'new_ganda' => $new_ganda
                    );
                    $chain_update_data = $this->blockchainutilityclass->getUpdateChainArrayN((object)$update_params);
                    // echo "<pre>";
                    // var_dump($pattadar_details);
                    // die;
                    // $chain_update = $this->utilityclass->propertyChainUpdateApi($chain_update_data);
                    $save_chain_data = $this->PropChainModel->save_chain_data(json_encode($chain_update_data), $case_no);
                }
            }
            // var_dump($save_chain_data);exit;

            if ($save_chain_data) {
                $this->db->trans_commit();
                if ($designation == 'CO') {
                    //   $this->db->query("UPDATE t_legacyupdation SET status = 'F', status_date = '$date_entry',co_yn = 'Y', co_note = '$finalcoorder', co_orddate = '$date_entry', "
                    //           . "co_ordpass_note = '$final_report', co_ordpass_date = '$date_entry' WHERE case_no = '$case_no' and  proposal_no = '$proposal_no'");

                    $update_data = [
                        'status' => 'F',
                        'status_date' => $date_entry,
                        'co_yn' => 'Y',
                        'co_note' => $finalcoorder,
                        'co_orddate' => $date_entry,
                        'co_ordpass_note' => $final_report,
                        'co_ordpass_date' => $date_entry,
                        'chitha_remarks' => $change_request_string
                    ];

                    $this->db->update('t_legacyupdation', $update_data, array('case_no' => $case_no, 'proposal_no' => $proposal_no));
                } else {
                    // $this->db->query("UPDATE t_legacyupdation SET status = 'F', status_date = '$date_entry',dc_yn = 'Y', dc_adc_note = '$finalcoorder', dc_adc_orddate = '$date_entry', "
                    //         . "co_ordpass_note = '$final_report', co_ordpass_date = '$date_entry' WHERE case_no = '$case_no' and  proposal_no = '$proposal_no'");

                    $update_data = [
                        'status' => 'F',
                        'status_date' => $date_entry,
                        'dc_yn' => 'Y',
                        'dc_adc_note' => $finalcoorder,
                        'dc_adc_orddate' => $date_entry,
                        'co_ordpass_note' => $final_report,
                        'co_ordpass_date' => $date_entry,
                        'chitha_remarks' => $change_request_string
                    ];

                    $this->db->update('t_legacyupdation', $update_data, array('case_no' => $case_no, 'proposal_no' => $proposal_no));
                }

                if (ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'), json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))) {


                    if ($ulpinFlag == 1 && $compareFlag == 'Y') {
                        redirect(base_url() . 'index.php/PropChainReport/sendPropChain/' . urlencode(base64_encode($case_no)));
                    }
                }
            } else {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "*Legacy data Updation Failed.<br>*Property chain updation failed. Error Code: #CHAINSAVEERROR0001");
                log_message("error", "Data not saved in table prop_chain_sent_data. Error code: #CHAINSAVEERROR0001");
                redirect(base_url() . "index.php/home");
            }




            //            $this->load->helper('html');
            //            $this->load->view('../views/header');
            //            $this->load->view('../views/LegacyDataUpdation/UpdateJamabandi', $data);
            //            $this->load->view('../views/footer');
            $this->session->set_flashdata('message', "Legacy data Updation Complete. Update Jamabandi Using the Maintenance Menu.");
            redirect(base_url() . "index.php/home");
        }
    }

    function FinalupdateLandArea($case_no, $proposal_no)
    {
        // dd("here");
        $db =  $this->session->userdata('db');
        $this->AgriStackCaseHistory->CreateLogFile($this->session->userdata('dist_code'), $case_no);
        $q = "select * from    t_legacyupdation where case_no = '$case_no' and proposal_no = '$proposal_no' ";
        $data = $this->db->query($q)->row();

        // $basundhara = $this->db->query("select basundhara from basundhar_application where dharitree='$case_no' ")->row()->basundhara;

        $user_code = $this->session->userdata('user_code');

        $dag_area_b = $data->suggested_dag_area_b;
        $dag_area_k = $data->suggested_dag_area_k;
        $dag_area_lc = $data->suggested_dag_area_lc;
        $dag_area_g = $data->suggested_dag_area_g;
        $update = array(
            'dag_area_b' => $dag_area_b,
            'dag_area_k' => $dag_area_k,
            'dag_area_lc' => $dag_area_lc,
            'dag_area_g' => $dag_area_g
        );
        $where = array(
            'dist_code' => $data->dist_code,
            'subdiv_code' => $data->subdiv_code,
            'cir_code' => $data->cir_code,
            'mouza_pargona_code' => $data->mouza_pargona_code,
            'lot_no' => $data->lot_no,
            'vill_townprt_code' => $data->vill_townprt_code,
            'dag_no' => $data->dag_no,
            'patta_no' => $data->patta_no,
        );
        $this->db->trans_begin();
        // $this->db->where($where);
        // $this->db->update('chitha_basic', $update);
        $this->Chitha_basic_model->update_table("chitha_basic", $update, $where);
        // echo $this->db->last_query();die;
        $this->db->where($where);
        $this->db->update('jama_dag', $update);

        
        // $whereord = array(
        //     'dist_code' => $data->dist_code,
        //     'subdiv_code' => $data->subdiv_code,
        //     'cir_code' => $data->cir_code,
        //     'mouza_pargona_code' => $data->mouza_pargona_code,
        //     'lot_no' => $data->lot_no,
        //     'vill_townprt_code' => $data->vill_townprt_code,
        //     'dag_no' => $data->dag_no,
        // );
        // $updateord = array(
        //     'm_dag_area_b' => $dag_area_b,
        //     'm_dag_area_k' => $dag_area_k,
        //     'm_dag_area_lc' => $dag_area_lc,
        //     'm_dag_area_g' => $dag_area_g,
        // );
        // $this->db->where($whereord);
        // $this->db->update('chitha_rmk_ordbasic', $updateord);

        // $updateconvord = array(
        //     'land_area_b' => $dag_area_b,
        //     'land_area_k' => $dag_area_k,
        //     'land_area_lc' => $dag_area_lc,
        //     'land_area_g' => $dag_area_g
        // );
        // $this->db->where($whereord);
        // $this->db->update('chitha_rmk_convorder', $updateconvord);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message('error', '#ERRFNLUPDTLNDARA0001: Query ' . $this->db->last_query());
            $this->session->set_flashdata('message', '#ERRFNLUPDTLNDARA0001: Sorry...Modification Cannot be Done here !! Please Contact Help Desk !!');
            redirect(base_url() . "index.php/home");
            echo "Error Occured";
        } else {
            $this->db->trans_commit();

            if ($basundhara) {
                $rtps = $this->rtpsmodel->checkRtpsService($basundhara);
                if ($rtps == 'RTPS') {
                    $apilink = RTPS_API_LINK;
                } else {
                    $apilink = API_LINK;
                }
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, $apilink . "applicationStatusUpdate");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    'application' => $basundhara,
                    'dharitree' => $case_no,
                    'rmk' => 'Approved',
                    'status' => 'F',
                    'task' => 'CO',
                    'pen' => 'NA',
                    'penat' => 'Circle office'
                )));
                $result = curl_exec($curl_handle);
            }
        }
    }

    function FinalupdateLandClass($case_no, $proposal_no)
    {
        $db =  $this->session->userdata('db');
        $this->AgriStackCaseHistory->CreateLogFile($this->session->userdata('dist_code'), $case_no);
        $user_code = $this->session->userdata('user_code');

        $q = "select * from    t_legacyupdation where case_no = '$case_no' and proposal_no = '$proposal_no' ";
        $data = $this->db->query($q)->row();

        $update = array(
            'land_class_code' => $data->suggested_land_class,
        );
        $where = array(
            'dist_code' => $data->dist_code,
            'subdiv_code' => $data->subdiv_code,
            'cir_code' => $data->cir_code,
            'mouza_pargona_code' => $data->mouza_pargona_code,
            'lot_no' => $data->lot_no,
            'vill_townprt_code' => $data->vill_townprt_code,
            'dag_no' => $data->dag_no,
            'patta_no' => $data->patta_no,
        );

        $this->db->trans_begin();
        // $this->db->where($where);
        // $this->db->update('chitha_basic', $update);
        $this->Chitha_basic_model->update_table("chitha_basic", $update, $where);
        $jamaupdate = array(
            'dag_class_code' => $data->suggested_land_class,
        );
        $this->db->where($where);
        $this->db->update('jama_dag', $jamaupdate);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message('error', '#ERRLNDCLS0001: Query ' . $this->db->last_query());
            $this->session->set_flashdata('message', '#ERRLNDCLS0001: Sorry...Modification Cannot be Done here !! Please Contact Help Desk !!');
            redirect(base_url() . "index.php/home");
            echo "Error Occured";
        } else {
            $this->db->trans_commit();
        }
    }

    function FinalupdatelandRev($case_no, $proposal_no)
    {
        $db =  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');

        $q = "select * from    t_legacyupdation where case_no = '$case_no' and proposal_no = '$proposal_no' ";
        $data = $this->db->query($q)->row();

        $update = array(
            'dag_revenue' => $data->suggested_land_rev,
        );
        $where = array(
            'dist_code' => $data->dist_code,
            'subdiv_code' => $data->subdiv_code,
            'cir_code' => $data->cir_code,
            'mouza_pargona_code' => $data->mouza_pargona_code,
            'lot_no' => $data->lot_no,
            'vill_townprt_code' => $data->vill_townprt_code,
            'dag_no' => $data->dag_no,
            'patta_no' => $data->patta_no,
        );
        $this->db->trans_begin();

        // $this->db->where($where);
        // $this->db->update('chitha_basic', $update);
        $this->Chitha_basic_model->update_table("chitha_basic", $update, $where);
        $this->db->where($where);
        $this->db->update('jama_dag', $update);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message('error', '#ERRFNLUPD0001: Query ' . $this->db->last_query());
            $this->session->set_flashdata('message', '#ERRFNLUPD0001: Sorry...Modification Cannot be Done here !! Please Contact Help Desk !!');
            redirect(base_url() . "index.php/home");
            echo "Error Occured";
        } else {
            $this->db->trans_commit();
        }
    }

    function FinalupdateLocalTax($case_no, $proposal_no)
    {
        $db =  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');

        $q = "select * from    t_legacyupdation where case_no = '$case_no' and proposal_no = '$proposal_no' ";
        $data = $this->db->query($q)->row();

        $update = array(
            'dag_local_tax' => $data->suggested_loc_tax,
        );
        $where = array(
            'dist_code' => $data->dist_code,
            'subdiv_code' => $data->subdiv_code,
            'cir_code' => $data->cir_code,
            'mouza_pargona_code' => $data->mouza_pargona_code,
            'lot_no' => $data->lot_no,
            'vill_townprt_code' => $data->vill_townprt_code,
            'dag_no' => $data->dag_no,
            'patta_no' => $data->patta_no,
        );
        $this->db->trans_begin();

        // $this->db->where($where);
        // $this->db->update('chitha_basic', $update);
        $this->Chitha_basic_model->update_table("chitha_basic", $update, $where);
        $jamaupdate = array(
            'dag_localtax' => $data->suggested_loc_tax,
        );

        $this->db->where($where);
        $this->db->update('jama_dag', $jamaupdate);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message('error', '#ERRFNLUPDLCLTX0001: Query ' . $this->db->last_query());
            $this->session->set_flashdata('message', '#ERRFNLUPDLCLTX0001: Sorry...Modification Cannot be Done here !! Please Contact Help Desk !!');
            redirect(base_url() . "index.php/home");
            echo "Error Occured";
        } else {
            $this->db->trans_commit();
        }
    }

    private function FinalupdatePattaNoNdPattaType($case_no, $proposal_no)
    {
        $db =  $this->session->userdata('db');
        $pdar_id = null;
        $this->AgriStackCaseHistory->CreateLogFile($this->session->userdata('dist_code'), $case_no);
        $this->db->trans_begin();
        $user_code = $this->session->userdata('user_code');

        $q = "select * from    t_legacyupdation where case_no = '$case_no' and proposal_no = '$proposal_no' ";
        $data = $this->db->query($q)->row();

        $suggested_patta_no = $this->utilityclass->assToeng($data->suggested_patta_no);
        $suggested_patta_type_code = $data->suggested_patta_type;
        $patta_type_code = $data->patta_type_code;

        $update = array(
            'patta_type_code' => $data->suggested_patta_type,
        );

        $full_update = array(
            'patta_type_code' => $suggested_patta_type_code,
            'patta_no' => $suggested_patta_no,
            'jama_yn' => 'n'
        );

        $where = array(
            'dist_code' => $data->dist_code,
            'subdiv_code' => $data->subdiv_code,
            'cir_code' => $data->cir_code,
            'mouza_pargona_code' => $data->mouza_pargona_code,
            'lot_no' => $data->lot_no,
            'vill_townprt_code' => $data->vill_townprt_code,
            'dag_no' => $data->dag_no,
            'patta_no' => $data->patta_no,
            'patta_type_code' => $data->patta_type_code,
        );

        $jamaupdate = array(
            'patta_type_code' => $suggested_patta_type_code,
            'patta_no' => $suggested_patta_no
            // 'patta_no' => $data->suggested_patta_no
        );

        $where_j = array(
            'dist_code' => $data->dist_code,
            'subdiv_code' => $data->subdiv_code,
            'cir_code' => $data->cir_code,
            'mouza_pargona_code' => $data->mouza_pargona_code,
            'lot_no' => $data->lot_no,
            'vill_townprt_code' => $data->vill_townprt_code,
            'patta_no' => $data->patta_no,
            'patta_type_code' => $data->patta_type_code,
        );

        // $this->db->where($where);
        // $this->db->update('chitha_basic', $full_update);
        $this->Chitha_basic_model->update_table("chitha_basic", $full_update, $where);
        $this->db->where($where);
        $this->db->update('chitha_rmk_infavor_of', $update);
        $this->db->where($where);
        $this->db->update('chitha_rmk_reclassification', $update);
        $this->db->where($where);
        $this->db->update('backlog_orders', $update);

        $whereord = array(
            'dist_code' => $data->dist_code,
            'subdiv_code' => $data->subdiv_code,
            'cir_code' => $data->cir_code,
            'mouza_pargona_code' => $data->mouza_pargona_code,
            'lot_no' => $data->lot_no,
            'vill_townprt_code' => $data->vill_townprt_code,
            'dag_no' => $data->dag_no,
        );
        $updateconvord = array(
            'new_patta_type' => $data->suggested_patta_type,
        );
        $this->db->where($whereord);
        $this->db->update('chitha_rmk_convorder', $updateconvord);


        $pattadar_chitha_side = "Select * from chitha_dag_pattadar where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' "
            . "and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and "
            . "patta_type_code='$patta_type_code' and trim(patta_no)=trim('$data->patta_no') and dag_no = trim('$data->dag_no') ";
        $pattadar_chitha = $this->db->query($pattadar_chitha_side)->result();

        ////////////////For Pattadar ID///////////////////////
        $pdar_in_jama = "Select max(cast(pdar_id as int)) as c from jama_pattadar where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' "
            . "and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and "
            . "patta_type_code='$suggested_patta_type_code' and trim(patta_no)=trim('$suggested_patta_no')";
        $pattadar_in_jama = $this->db->query($pdar_in_jama)->row()->c;
        $pdar_in_chitha = "Select max(cast(pdar_id as int)) as c from chitha_pattadar where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' "
            . "and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and "
            . "patta_type_code='$suggested_patta_type_code' and trim(patta_no)=trim('$suggested_patta_no')";
        $pattadar_in_chitha = $this->db->query($pdar_in_chitha)->row()->c;

        if ($pattadar_in_chitha != null || $pattadar_in_jama != null) {
            if ($pattadar_in_chitha > $pattadar_in_jama) {
                $pdar_id_query = "select max(cast(pdar_id as int))+1 as pdar_id from chitha_pattadar  where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' "
                    . "and cir_code = '$data->cir_code' and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and "
                    . "vill_townprt_code = '$data->vill_townprt_code' and patta_type_code='$suggested_patta_type_code' and trim(patta_no)=trim('$suggested_patta_no')";
            } else {
                $pdar_id_query = "select max(cast(pdar_id as int))+1 as pdar_id from jama_pattadar  where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' "
                    . "and cir_code = '$data->cir_code' and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and "
                    . "vill_townprt_code = '$data->vill_townprt_code' and patta_type_code='$suggested_patta_type_code' and trim(patta_no)=trim('$suggested_patta_no')";
            }
            $pdar_id = $this->db->query($pdar_id_query)->row()->pdar_id;
        }
        //////////////End PattaDar Id////////////////////
        $index = 0;
        foreach ($pattadar_chitha as $cpd) {
            //var_dump($cpd);
            /*---------------- Getting New Pattadar ID ----------------------------------*/
            if ($pdar_id == null && $index == 0) {
                $pdar_id = 1;
                $index++;
            } else if ($index == 1) {
                $pdar_id++;
            } else {
                $pdar_id = $pdar_id;
                $index++;
            }
            /*---------------- Getting New Pattadar ID ----------------------------------*/
            $pdar_exist_in_other_dag = "Select count(*) as count from  chitha_dag_pattadar WHERE dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' "
                . "and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and "
                . "patta_type_code='$patta_type_code' and trim(patta_no)=trim('$data->patta_no') 
                and pdar_id = '$cpd->pdar_id' and dag_no = trim('$data->dag_no') ";
            $result = $this->db->query($pdar_exist_in_other_dag)->row()->count;

            if ($result > '1') {
                $pattadar_names = "Select * from chitha_pattadar WHERE dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' "
                    . "and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and "
                    . "patta_type_code='$patta_type_code' and trim(patta_no)=trim('$data->patta_no') and pdar_id = '$cpd->pdar_id' ";
                $pattadar_insert_again = $this->db->query($pattadar_names)->row();
                // pattadars name has to be newly inserted in chitha_pattadar.
                $chitha_pattadar = array(
                    'dist_code' => $data->dist_code,
                    'subdiv_code' => $data->subdiv_code,
                    'cir_code' => $data->cir_code,
                    'mouza_pargona_code' => $data->mouza_pargona_code,
                    'lot_no' => $data->lot_no,
                    'vill_townprt_code' => $data->vill_townprt_code,
                    'pdar_id' => $pdar_id,
                    'patta_no' => trim($suggested_patta_no),
                    'patta_type_code' => $suggested_patta_type_code,
                    'pdar_name' => $pattadar_insert_again->pdar_name,
                    'pdar_father' => $pattadar_insert_again->pdar_father,
                    'pdar_add1' => $pattadar_insert_again->pdar_add1,
                    'pdar_add2' => $pattadar_insert_again->pdar_add2,
                    'pdar_add3' => "",
                    'user_code' => $cpd->user_code,
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => $cpd->operation,
                    'jama_yn' => 'n', //$cpd->jama_yn,
                    'pdar_guard_reln' => $pattadar_insert_again->pdar_guard_reln,
                    'new_pdar_name' => $pattadar_insert_again->new_pdar_name,
                    'f1_case_no'      => $case_no
                );
                // $this->db->insert('chitha_pattadar', $chitha_pattadar);
                $this->Chitha_basic_model->insert_table('chitha_pattadar', $chitha_pattadar);
            } else {
                // $update_chitha_pattadar = "Update chitha_pattadar set patta_no = '$suggested_patta_no', patta_type_code = '$suggested_patta_type_code', pdar_id = '$pdar_id', jama_yn = 'n' where dist_code = '$data->dist_code' and "
                //     . "subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' and mouza_pargona_code = '$data->mouza_pargona_code' and "
                //     . "lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and patta_type_code='$patta_type_code' and trim(patta_no)=trim('$data->patta_no') and pdar_id = '$cpd->pdar_id' ";
                // $this->db->query($update_chitha_pattadar);

                $table = 'chitha_pattadar';

                $params = [
                    'patta_no'        => $suggested_patta_no,
                    'patta_type_code' => $suggested_patta_type_code,
                    'pdar_id'         => $pdar_id,
                    'jama_yn'         => 'n',
                    'f1_case_no'      => $case_no
                ];

                $where = [
                    'dist_code'          => $data->dist_code,
                    'subdiv_code'        => $data->subdiv_code,
                    'cir_code'           => $data->cir_code,
                    'mouza_pargona_code' => $data->mouza_pargona_code,
                    'lot_no'             => $data->lot_no,
                    'vill_townprt_code'  => $data->vill_townprt_code,
                    'patta_type_code'    => $patta_type_code,
                    'patta_no'           => trim($data->patta_no), // Handles TRIM in SQL
                    'pdar_id'            => $cpd->pdar_id,
                ];

                // Call the model update method
                $this->Chitha_basic_model->update_table($table, $params, $where);
            }
            // pattadars details has to be updated in chitha_dag_pattadar.
            $update_chitha_dag_pattadar = "Update chitha_dag_pattadar set patta_no = '$suggested_patta_no', patta_type_code = '$suggested_patta_type_code', pdar_id = '$pdar_id', jama_yn = '' "
                . "where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' and mouza_pargona_code = '$data->mouza_pargona_code' "
                . "and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and patta_type_code='$patta_type_code' and "
                . "trim(patta_no)=trim('$data->patta_no') and dag_no = '$data->dag_no'  and pdar_id = '$cpd->pdar_id' ";
            $this->db->query($update_chitha_dag_pattadar);
        }


        $where_j = array(
            'dist_code' => $data->dist_code,
            'subdiv_code' => $data->subdiv_code,
            'cir_code' => $data->cir_code,
            'mouza_pargona_code' => $data->mouza_pargona_code,
            'lot_no' => $data->lot_no,
            'vill_townprt_code' => $data->vill_townprt_code,
            'patta_no' => $data->patta_no,
            'patta_type_code' => $data->patta_type_code
        );

        $jama_patta_exist = "Select count(*) as c from    jama_patta WHERE dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' "
            . "and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and "
            . "patta_type_code='$data->suggested_patta_type' and patta_no=trim('$data->patta_no')";
        $exist = $this->db->query($jama_patta_exist)->row()->c;
        if ($exist == 0) {
            $this->db->where($where_j);
            $this->db->update('jama_patta', $jamaupdate);
        }


        $delete_old_dag_from_jama = "Delete from jama_dag where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' "
            . "and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and "
            . "patta_type_code='$patta_type_code' and trim(patta_no)=trim('$data->patta_no') and dag_no = '$data->dag_no'";
        $this->db->query($delete_old_dag_from_jama);
        log_message('error', 'LDUJM_PTNO03: Case No: ' . $case_no . ' | Last Query => ' . $this->db->last_query());

        $delete_old_dag_pattadar_from_jama = "Delete from jama_pattadar where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' "
            . "and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and "
            . "patta_type_code='$patta_type_code' and trim(patta_no)=trim('$data->patta_no') ";
        $this->db->query($delete_old_dag_pattadar_from_jama);
        log_message('error', 'LDUJM_PTNO04: Case No: ' . $case_no . ' | Last Query => ' . $this->db->last_query());

        if ($data->rmk_line_no) {
            $rmk_line_id = explode(",", $data->rmk_line_no);

            for ($i = 0; $i < sizeof($rmk_line_id); $i++) {
                $remark_query = "select max(cast(rmk_line_no as int))+1 as rmk_line_no from    jama_remark  where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' "
                    . "and cir_code = '$data->cir_code' and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and "
                    . "vill_townprt_code = '$data->vill_townprt_code' and patta_type_code='$suggested_patta_type_code' and trim(patta_no)=trim('$suggested_patta_no')";
                $rmk_line_no = $this->db->query($remark_query)->row()->rmk_line_no;

                if ($rmk_line_no == null) {
                    $rmk_line_no = 1;
                }

                $update_jama_new = "Update jama_remark set patta_no = '$suggested_patta_no',patta_type_code = '$suggested_patta_type_code',rmk_line_no = '$rmk_line_no' "
                    . "where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' "
                    . "and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and "
                    . "patta_type_code='$patta_type_code' and trim(patta_no)=trim('$data->patta_no') and rmk_line_no = '$rmk_line_id[$i]' ";
                $this->db->query($update_jama_new);
            }
            log_message('error', '#IF_BLOCK_jamaremark: Query ' . $this->db->last_query());
        } else {
            $this->db->where($where_j);
            $this->db->update('jama_remark', $jamaupdate);
            log_message('error', '#ELSE_jamaremark: Query ' . $this->db->last_query());
        }



        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message('error', '#ERRNEWFNLUPDPTTYPE0001-2: Query ' . $this->db->last_query());
            $this->session->set_flashdata('message', '#ERRFNLUPDPTTYPE0001-2: Sorry...Modification Cannot be Done here !! Please Contact Help Desk !!');
            redirect(base_url() . "index.php/home");
            echo "Error Occured";
        } else {
            $this->db->trans_commit();
        }
    }

    public function FinalupdatePattaType($case_no, $proposal_no)
    {
        $user_code = $this->session->userdata('user_code');
        // Fetch case data
        $q    = "SELECT * FROM t_legacyupdation WHERE case_no = ? AND proposal_no = ?";
        $data = $this->db->query($q, [$case_no, $proposal_no])->row();

        if (!$data) {
            log_message('error', "FinalupdatePattaType: No record found for case_no {$case_no} / proposal_no {$proposal_no}");
            return false;
        }

        // Prepare update arrays
        $update = [
            'patta_type_code' => $data->suggested_patta_type,
        ];
        $jamaupdate = [
            'patta_type_code' => $data->suggested_patta_type,
        ];

        // Base WHERE conditions
        $where_common = [
            'dist_code'         => $data->dist_code,
            'subdiv_code'       => $data->subdiv_code,
            'cir_code'          => $data->cir_code,
            'mouza_pargona_code' => $data->mouza_pargona_code,
            'lot_no'            => $data->lot_no,
            'vill_townprt_code' => $data->vill_townprt_code,
        ];

        // WHEREs per table
        $where_chitha_dag_pattadar = array_merge($where_common, [
            'dag_no'           => $data->dag_no,
            'patta_no'         => $data->patta_no,
            'patta_type_code'  => $data->patta_type_code,
        ]);
        $where_jama_dag = $where_chitha_dag_pattadar;
        $where_jama_patta = array_merge($where_common, [
            'patta_no'         => $data->patta_no,
            'patta_type_code'  => $data->patta_type_code,
        ]);

        // Allowed patta types (flatten array)
        $sqlPattaTypeAllowed = "SELECT type_code FROM patta_code WHERE jamabandi='n'";
        $patta_array         = array_column(
            $this->db->query($sqlPattaTypeAllowed)->result_array(),
            'type_code'
        );

        $this->db->trans_begin();

        // If suggested_patta_no is empty AND patta type is not allowed for jama
        if (
            $data->suggested_patta_no == '' &&
            !in_array($data->suggested_patta_type, $patta_array)
        ) {
            $sql = "SELECT * FROM chitha_dag_pattadar 
                    WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? 
                      AND mouza_pargona_code = ? AND lot_no = ? AND vill_townprt_code = ? 
                      AND patta_type_code = ? AND patta_no = TRIM(?) AND dag_no = ?";
            $pattadar = $this->db->query($sql, [
                $data->dist_code,
                $data->subdiv_code,
                $data->cir_code,
                $data->mouza_pargona_code,
                $data->lot_no,
                $data->vill_townprt_code,
                $data->patta_type_code,
                $data->patta_no,
                $data->dag_no
            ])->result();

            foreach ($pattadar as $pp) {
                $where_c = array_merge($where_common, [
                    'pdar_id'         => $pp->pdar_id,
                    'patta_no'        => $data->patta_no,
                    'patta_type_code' => $data->suggested_patta_type
                ]);

                // Check if new record exists in chitha_pattadar
                $exists_in_chitha_pattadar = $this->db->where($where_c)->get('chitha_pattadar')->row();

                if (!$exists_in_chitha_pattadar) {
                    // Fetch old pattadar data
                    $where_exists = array_merge($where_common, [
                        'pdar_id'         => $pp->pdar_id,
                        'patta_no'        => $data->patta_no,
                        'patta_type_code' => $data->patta_type_code
                    ]);
                    $exists_data = $this->db->where($where_exists)->get('chitha_pattadar');
                    if ($exists_data->num_rows() <= 0) {
                        continue;
                    }
                    $exists_chitha_pattadar_data = $exists_data->row();

                    // Insert new pattadar entry
                    $insert_array = array_merge($where_common, [
                        'pdar_id'     => $pp->pdar_id,
                        'pdar_name'   => $exists_chitha_pattadar_data->pdar_name,
                        'pdar_father' => $exists_chitha_pattadar_data->pdar_father,
                        'user_code'   => $user_code,
                        'date_entry'  => date('Y-m-d H:i:s'),
                        'operation'   => 'E',
                        'jama_yn'     => 'n',
                        'created_on'  => date('Y-m-d H:i:s'),
                        'updated_on'  => date('Y-m-d H:i:s'),
                        'patta_no'    => $data->patta_no,
                        'patta_type_code' => $data->suggested_patta_type,
                        'f1_case_no'  => $data->case_no
                    ]);

                    if (!$this->Chitha_basic_model->insert_table('chitha_pattadar', $insert_array)) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRFINSCHITPTTDR0001 => Case no: ' . $data->case_no . ' Last_query => ' . $this->db->last_query());
                        $this->session->set_flashdata('message', '#ERRFINSCHITPTTDR0001: Sorry...Modification Cannot be Done here !! Please Contact Help Desk !!');
                        redirect(base_url() . "index.php/home");
                        return false;
                    }
                } else {
                    // Update existing pattadar
                    $params = [
                        'jama_yn'     => 'n',
                        'f1_case_no'  => $case_no
                    ];
                    if (!$this->Chitha_basic_model->update_table('chitha_pattadar', $params, $where_chitha_dag_pattadar)) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRFINSCHITPTTDR000145 => Case no: ' . $data->case_no);
                        $this->session->set_flashdata('message', '#ERRFINSCHITPTTDR0002-2: Sorry...Modification Cannot be Done here !! Please Contact Help Desk !!');
                        redirect(base_url() . "index.php/home");
                        return false;
                    }
                }

                // Update jama tables if needed
                $jama_patta_exist = "SELECT COUNT(*) AS c FROM jama_patta 
                                     WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? 
                                       AND mouza_pargona_code = ? AND lot_no = ? AND vill_townprt_code = ? 
                                       AND patta_type_code = ? AND patta_no = TRIM(?)";
                $exist = $this->db->query($jama_patta_exist, [
                    $data->dist_code,
                    $data->subdiv_code,
                    $data->cir_code,
                    $data->mouza_pargona_code,
                    $data->lot_no,
                    $data->vill_townprt_code,
                    $data->suggested_patta_type,
                    $data->patta_no
                ])->row()->c;

                if ($exist == 0) {
                    $this->db->where($where_jama_dag)->update('jama_dag', $jamaupdate);
                    $this->db->where($where_jama_patta)->update('jama_patta', $jamaupdate);
                }

                // Update jama_pattadar
                if (!$this->db->where($where_c)->update('jama_pattadar', $update)) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRFINSCHITPTTDR000122 => Case no: ' . $data->case_no);
                    $this->session->set_flashdata('message', '#ERRFINSCHITPTTDR0002-2: Sorry...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    redirect(base_url() . "index.php/home");
                    return false;
                }
            }

            // Final update for chitha_dag_pattadar
            $update['jama_yn'] = 'n';
            if (!$this->Chitha_basic_model->update_table('chitha_dag_pattadar', $update, $where_chitha_dag_pattadar)) {
                $this->db->trans_rollback();
                log_message('error', '#ERRFINSCHITPTTDR000111 => Case no: ' . $data->case_no);
                $this->session->set_flashdata('message', '#ERRFINSCHITPTTDR0002-2: Sorry...Modification Cannot be Done here !! Please Contact Help Desk !!');
                redirect(base_url() . "index.php/home");
                return false;
            }
        }

        // Update chitha_basic
        if (!$this->Chitha_basic_model->update_table("chitha_basic", $update, $where_chitha_dag_pattadar)) {
            $this->db->trans_rollback();
            log_message('error', '#ERRFINSCHITPTTDR000555 => Case no: ' . $data->case_no);
            $this->session->set_flashdata('message', '#ERRFINSCHITPTTDR000555: Sorry...Modification Cannot be Done here !! Please Contact Help Desk !!');
            redirect(base_url() . "index.php/home");
            return false;
        }

        // Remove jama_yn if patta_type is in allowed list
        if (in_array($data->suggested_patta_type, $patta_array)) {
            unset($update['jama_yn']);
        }

        // Commit or rollback
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message('error', '#ERRFNLUPDPTTYPE0001-1: Query ' . $this->db->last_query());
            $this->session->set_flashdata('message', '#ERRFNLUPDPTTYPE0001-1: Sorry...Modification Cannot be Done here !! Please Contact Help Desk !!');
            redirect(base_url() . "index.php/home");
        } else {
            $this->db->trans_commit();
        }
    }

    function FinalupdatePdar($distcode, $subdiv, $circode, $mouza, $lot, $villcode, $case_no, $proposal_no, $dag_no, $patta_no, $patta_type_code)
    {
        $db =  $this->session->userdata('db');
        $this->db->trans_begin();
        $user_code = $this->session->userdata('user_code');
        $q = "select * from    t_legacyupdation where dist_code='$distcode' and subdiv_code='$subdiv' and cir_code='$circode' and mouza_pargona_code='$mouza' and lot_no='$lot' and vill_townprt_code='$villcode' and case_no = '$case_no' and proposal_no = '$proposal_no' and dag_no ='$dag_no' and patta_no='$patta_no' and patta_type_code='$patta_type_code' ";

        $data = $this->db->query($q)->row();
        $pflag = $data->p_flag;
        $pid = $data->pdar_id;
        if ($pid != '') {
            $q2 = "select chitha_pattadar.pdar_name,chitha_dag_pattadar.pdar_id,chitha_dag_pattadar.p_flag from    chitha_pattadar inner join chitha_dag_pattadar on chitha_dag_pattadar.dist_code=chitha_pattadar.dist_code and chitha_dag_pattadar.subdiv_code=chitha_pattadar.subdiv_code and chitha_dag_pattadar.cir_code=chitha_pattadar.cir_code and chitha_dag_pattadar.mouza_pargona_code=chitha_pattadar.mouza_pargona_code and chitha_dag_pattadar.lot_no=chitha_pattadar.lot_no and chitha_dag_pattadar.vill_townprt_code=chitha_pattadar.vill_townprt_code and chitha_dag_pattadar.pdar_id=chitha_pattadar.pdar_id and chitha_dag_pattadar.patta_no=chitha_pattadar.patta_no and chitha_dag_pattadar.patta_type_code=chitha_pattadar.patta_type_code and chitha_dag_pattadar.dag_no='$dag_no' and chitha_dag_pattadar.patta_no='$patta_no' and chitha_dag_pattadar.patta_type_code='$patta_type_code' and chitha_dag_pattadar.pdar_id='$pid'";
            //echo $q2;


            $data2 = $this->db->query($q2)->row();
            $pflagold = $data2->p_flag;
            if ($pflagold == '0') {
                $pflag = '1';
                //   $q3 = "update chitha_dag_pattadar set p_flag='$pflag' where dist_code='$distcode' and subdiv_code='$subdiv' and cir_code='$circode' and mouza_pargona_code='$mouza' and lot_no='$lot' and vill_townprt_code='$villcode' and patta_no='$patta_no' and patta_type_code='$patta_type_code' and dag_no='$dag_no' and pdar_id='$pid'";

                //    $this->db->query($q3);

                $table = 'chitha_dag_pattadar';
                $params = [
                    'p_flag' => $pflag,
                ];
                $where = [
                    'dist_code'          => $distcode,
                    'subdiv_code'        => $subdiv,
                    'cir_code'           => $circode,
                    'mouza_pargona_code' => $mouza,
                    'lot_no'             => $lot,
                    'vill_townprt_code'  => $villcode,
                    'patta_no'           => $patta_no,
                    'patta_type_code'    => $patta_type_code,
                    'dag_no'             => $dag_no,
                    'pdar_id'            => $pid,
                ];
                $result = $this->Chitha_basic_model->update_table($table, $params, $where);


                $q4 = "update jama_pattadar set p_flag='$pflag' where dist_code='$distcode' and subdiv_code='$subdiv' and cir_code='$circode' and mouza_pargona_code='$mouza' and lot_no='$lot' and vill_townprt_code='$villcode' and patta_no='$patta_no' and patta_type_code='$patta_type_code' and pdar_id='$pid' ";
                $this->db->query($q4);
            } elseif ($pflagold == '1') {

                $pflag = '0';
                //   $q3 = "update chitha_dag_pattadar set p_flag='$pflag' where dist_code='$distcode' and subdiv_code='$subdiv' and cir_code='$circode' and mouza_pargona_code='$mouza' and lot_no='$lot' and vill_townprt_code='$villcode' and patta_no='$patta_no' and patta_type_code='$patta_type_code' and dag_no='$dag_no' and pdar_id='$pid'";
                //    $this->db->query($q3);

                $table = 'chitha_dag_pattadar';
                $params = [
                    'p_flag' => $pflag,
                ];
                $where = [
                    'dist_code'          => $distcode,
                    'subdiv_code'        => $subdiv,
                    'cir_code'           => $circode,
                    'mouza_pargona_code' => $mouza,
                    'lot_no'             => $lot,
                    'vill_townprt_code'  => $villcode,
                    'patta_no'           => $patta_no,
                    'patta_type_code'    => $patta_type_code,
                    'dag_no'             => $dag_no,
                    'pdar_id'            => $pid,
                ];

                // Example usage:
                $result = $this->Chitha_basic_model->update_table($table, $params, $where);



                $q4 = "update jama_pattadar set p_flag='$pflag' where dist_code='$distcode' and subdiv_code='$subdiv' and cir_code='$circode' and mouza_pargona_code='$mouza' and lot_no='$lot' and vill_townprt_code='$villcode' and patta_no='$patta_no' and patta_type_code='$patta_type_code' and pdar_id='$pid' ";

                $this->db->query($q4);
            }
        }
    }
    function FinalupdatePattaNo($case_no, $proposal_no)
    {
        $db =  $this->session->userdata('db');
        $this->AgriStackCaseHistory->CreateLogFile($this->session->userdata('dist_code'), $case_no);
        $pdar_id = null;
        $this->db->trans_begin();
        $user_code = $this->session->userdata('user_code');

        $q = "select * from  t_legacyupdation where case_no = '$case_no' and proposal_no = '$proposal_no' ";
        $data = $this->db->query($q)->row();


        $where = array(
            'dist_code' => $data->dist_code,
            'subdiv_code' => $data->subdiv_code,
            'cir_code' => $data->cir_code,
            'mouza_pargona_code' => $data->mouza_pargona_code,
            'lot_no' => $data->lot_no,
            'vill_townprt_code' => $data->vill_townprt_code,
            'dag_no' => $data->dag_no,
            'patta_no' => $data->patta_no,
            'patta_type_code' => $data->patta_type_code,
        );
        $suggested_patta_no = $this->utilityclass->assToeng($data->suggested_patta_no);
        $patta_type_code = $data->patta_type_code;

        if ($data->suggested_patta_type != '0') {
            $suggested_patta_type_code = $data->suggested_patta_type;
        } else {
            $suggested_patta_type_code = $patta_type_code;
        }

        $pattadar_chitha_side = "Select * from chitha_dag_pattadar where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' "
            . "and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and "
            . "patta_type_code='$patta_type_code' and trim(patta_no)=trim('$data->patta_no') and dag_no = trim('$data->dag_no') ";
        $pattadar_chitha = $this->db->query($pattadar_chitha_side)->result();
        //var_dump($pattadar_chitha);

        ////////////////For Pattadar ID///////////////////////
        $pdar_in_jama = "Select max(cast(pdar_id as int)) as c from jama_pattadar where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' "
            . "and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and "
            . "patta_type_code='$suggested_patta_type_code' and trim(patta_no)=trim('$suggested_patta_no')";
        $pattadar_in_jama = $this->db->query($pdar_in_jama)->row()->c;
        $pdar_in_chitha = "Select max(cast(pdar_id as int)) as c from chitha_pattadar where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' "
            . "and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and "
            . "patta_type_code='$suggested_patta_type_code' and trim(patta_no)=trim('$suggested_patta_no')";
        $pattadar_in_chitha = $this->db->query($pdar_in_chitha)->row()->c;

        if ($pattadar_in_chitha != null || $pattadar_in_jama != null) {
            if ($pattadar_in_chitha > $pattadar_in_jama) {
                $pdar_id_query = "select max(cast(pdar_id as int))+1 as pdar_id from chitha_pattadar  where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' "
                    . "and cir_code = '$data->cir_code' and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and "
                    . "vill_townprt_code = '$data->vill_townprt_code' and patta_type_code='$suggested_patta_type_code' and trim(patta_no)=trim('$suggested_patta_no')";
            } else {
                $pdar_id_query = "select max(cast(pdar_id as int))+1 as pdar_id from jama_pattadar  where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' "
                    . "and cir_code = '$data->cir_code' and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and "
                    . "vill_townprt_code = '$data->vill_townprt_code' and patta_type_code='$suggested_patta_type_code' and trim(patta_no)=trim('$suggested_patta_no')";
            }
            $pdar_id = $this->db->query($pdar_id_query)->row()->pdar_id;
        }
        //////////////End PattaDar Id////////////////////
        $index = 0;
        foreach ($pattadar_chitha as $cpd) {
            //var_dump($cpd);
            /*---------------- Getting New Pattadar ID ----------------------------------*/
            if ($pdar_id == null && $index == 0) {
                $pdar_id = 1;
                $index++;
            } else if ($index == 1) {
                $pdar_id++;
            } else {
                $pdar_id = $pdar_id;
                $index++;
            }
            /*---------------- Getting New Pattadar ID ----------------------------------*/
            $pdar_exist_in_other_dag = "Select count(*) as count from  chitha_dag_pattadar WHERE dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' "
                . "and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and "
                . "patta_type_code='$patta_type_code' and trim(patta_no)=trim('$data->patta_no') 
                    and pdar_id = '$cpd->pdar_id' and dag_no = trim('$data->dag_no') ";
            $result = $this->db->query($pdar_exist_in_other_dag)->row()->count;

            if ($result > '1') {
                $pattadar_names = "Select * from chitha_pattadar WHERE dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' "
                    . "and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and "
                    . "patta_type_code='$patta_type_code' and trim(patta_no)=trim('$data->patta_no') and pdar_id = '$cpd->pdar_id' ";
                $pattadar_insert_again = $this->db->query($pattadar_names)->row();
                // pattadars name has to be newly inserted in chitha_pattadar.
                $chitha_pattadar = array(
                    'dist_code' => $data->dist_code,
                    'subdiv_code' => $data->subdiv_code,
                    'cir_code' => $data->cir_code,
                    'mouza_pargona_code' => $data->mouza_pargona_code,
                    'lot_no' => $data->lot_no,
                    'vill_townprt_code' => $data->vill_townprt_code,
                    'pdar_id' => $pdar_id,
                    'patta_no' => trim($suggested_patta_no),
                    'patta_type_code' => $suggested_patta_type_code,
                    'pdar_name' => $pattadar_insert_again->pdar_name,
                    'pdar_father' => $pattadar_insert_again->pdar_father,
                    'pdar_add1' => $pattadar_insert_again->pdar_add1,
                    'pdar_add2' => $pattadar_insert_again->pdar_add2,
                    'pdar_add3' => "",
                    'user_code' => $cpd->user_code,
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => $cpd->operation,
                    'jama_yn' => 'n', //$cpd->jama_yn,
                    'pdar_guard_reln' => $pattadar_insert_again->pdar_guard_reln,
                    'new_pdar_name' => $pattadar_insert_again->new_pdar_name,
                );
                //    $this->db->insert('chitha_pattadar', $chitha_pattadar);
                $chitha_pattadar['f1_case_no'] = $case_no;
                $this->Chitha_basic_model->insert_table('chitha_pattadar', $chitha_pattadar);
            } else {
                //   $update_chitha_pattadar = "Update chitha_pattadar set patta_no = '$suggested_patta_no', patta_type_code = '$suggested_patta_type_code', pdar_id = '$pdar_id', jama_yn = 'n' where dist_code = '$data->dist_code' and "
                //       . "subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' and mouza_pargona_code = '$data->mouza_pargona_code' and "
                //       . "lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and patta_type_code='$patta_type_code' and trim(patta_no)=trim('$data->patta_no') and pdar_id = '$cpd->pdar_id' ";
                //   $this->db->query($update_chitha_pattadar);
                $table = 'chitha_pattadar';

                $params = [
                    'patta_no'        => $suggested_patta_no,
                    'patta_type_code' => $suggested_patta_type_code,
                    'pdar_id'         => $pdar_id,
                    'jama_yn'         => 'n',
                    'f1_case_no'      => $case_no
                ];

                $where = [
                    'dist_code'          => $data->dist_code,
                    'subdiv_code'        => $data->subdiv_code,
                    'cir_code'           => $data->cir_code,
                    'mouza_pargona_code' => $data->mouza_pargona_code,
                    'lot_no'             => $data->lot_no,
                    'vill_townprt_code'  => $data->vill_townprt_code,
                    'patta_type_code'    => $patta_type_code,
                    'patta_no'           => trim($data->patta_no), // matching TRIM()
                    'pdar_id'            => $cpd->pdar_id,
                ];

                // Perform the update using model method
                $this->Chitha_basic_model->update_table($table, $params, $where);
            }
            // pattadars details has to be updated in chitha_dag_pattadar.
            $update_chitha_dag_pattadar = "Update chitha_dag_pattadar set patta_no = '$suggested_patta_no', patta_type_code = '$suggested_patta_type_code', pdar_id = '$pdar_id', jama_yn = '' "
                . "where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' and mouza_pargona_code = '$data->mouza_pargona_code' "
                . "and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and patta_type_code='$patta_type_code' and "
                . "trim(patta_no)=trim('$data->patta_no') and dag_no = '$data->dag_no'  and pdar_id = '$cpd->pdar_id' ";
            $this->db->query($update_chitha_dag_pattadar);
        }

        // $update_chitha_basic = "Update chitha_basic set patta_no = '$suggested_patta_no', patta_type_code = '$suggested_patta_type_code', jama_yn = '' "
        //             . "where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' and mouza_pargona_code = '$data->mouza_pargona_code' "
        //             . "and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and patta_type_code='$suggested_patta_type_code' and "
        //             . "trim(patta_no)=trim('$data->patta_no') and dag_no = '$data->dag_no' ";
        // $this->db->query($update_chitha_basic);

        $table = 'chitha_basic';

        $params = [
            'patta_no'         => $suggested_patta_no,
            'patta_type_code'  => $suggested_patta_type_code,
            'jama_yn'          => '',
        ];

        $where = [
            'dist_code'          => $data->dist_code,
            'subdiv_code'        => $data->subdiv_code,
            'cir_code'           => $data->cir_code,
            'mouza_pargona_code' => $data->mouza_pargona_code,
            'lot_no'             => $data->lot_no,
            'vill_townprt_code'  => $data->vill_townprt_code,
            'patta_type_code'    => $suggested_patta_type_code,
            'patta_no'           => trim($data->patta_no),
            'dag_no'             => $data->dag_no,
        ];

        // Execute the update using your model method
        $result = $this->Chitha_basic_model->update_table($table, $params, $where);


        log_message('error', 'LST_QRY => ' . $this->db->last_query());

        // $update_jama_old = "Update chitha_basic set jama_yn = '' where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' "
        //         . "and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and "
        //         . "patta_type_code='$suggested_patta_type_code' and trim(patta_no)=trim('$data->patta_no') ";
        // $this->db->query($update_jama_old);

        $table = 'chitha_basic';

        $params = [
            'jama_yn' => '',
        ];

        $where = [
            'dist_code'          => $data->dist_code,
            'subdiv_code'        => $data->subdiv_code,
            'cir_code'           => $data->cir_code,
            'mouza_pargona_code' => $data->mouza_pargona_code,
            'lot_no'             => $data->lot_no,
            'vill_townprt_code'  => $data->vill_townprt_code,
            'patta_type_code'    => $suggested_patta_type_code,
            'patta_no'           => trim($data->patta_no), // Equivalent to SQL TRIM()
        ];

        // Perform the update using your model
        $result = $this->Chitha_basic_model->update_table($table, $params, $where);


        /*
        $update_chitha_basic = "Update chitha_basic set patta_no = '$suggested_patta_no', patta_type_code = '$suggested_patta_type_code', jama_yn = '' "
                    . "where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' and mouza_pargona_code = '$data->mouza_pargona_code' "
                    . "and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and patta_type_code='$patta_type_code' and "
                    . "trim(patta_no)=trim('$data->patta_no') and dag_no = '$data->dag_no' ";
        $this->db->query($update_chitha_basic);
        
        log_message('error', 'LST_QRY => ' . $this->db->last_query());
        
        $update_jama_old = "Update chitha_basic set jama_yn = '' where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' "
                . "and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and "
                . "patta_type_code='$patta_type_code' and trim(patta_no)=trim('$data->patta_no') ";
        $this->db->query($update_jama_old);
        */

        // $update_jama_new = "Update chitha_basic set jama_yn = '' where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' "
        //         . "and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and "
        //         . "patta_type_code='$suggested_patta_type_code' and trim(patta_no)=trim('$suggested_patta_no') ";
        // $this->db->query($update_jama_new);

        $table = 'chitha_basic';

        $params = [
            'jama_yn' => '',
        ];

        $where = [
            'dist_code'          => $data->dist_code,
            'subdiv_code'        => $data->subdiv_code,
            'cir_code'           => $data->cir_code,
            'mouza_pargona_code' => $data->mouza_pargona_code,
            'lot_no'             => $data->lot_no,
            'vill_townprt_code'  => $data->vill_townprt_code,
            'patta_type_code'    => $suggested_patta_type_code,
            'patta_no'           => trim($suggested_patta_no), // PHP trim to match SQL TRIM()
        ];

        // Execute update using your model
        $result = $this->Chitha_basic_model->update_table($table, $params, $where);


        $delete_old_dag_from_jama = "Delete from jama_dag where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' "
            . "and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and "
            . "patta_type_code='$patta_type_code' and trim(patta_no)=trim('$data->patta_no') and dag_no = '$data->dag_no'";
        $this->db->query($delete_old_dag_from_jama);
        log_message('error', 'LDUJM_PTNO01: Case No: ' . $case_no . ' | Last Query => ' . $this->db->last_query());

        $delete_old_dag_pattadar_from_jama = "Delete from jama_pattadar where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' "
            . "and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and "
            . "patta_type_code='$patta_type_code' and trim(patta_no)=trim('$data->patta_no') ";
        $this->db->query($delete_old_dag_pattadar_from_jama);
        log_message('error', 'LDUJM_PTNO02: Case No: ' . $case_no . ' | Last Query => ' . $this->db->last_query());

        if ($data->rmk_line_no) {
            $rmk_line_id = explode(",", $data->rmk_line_no);

            for ($i = 0; $i < sizeof($rmk_line_id); $i++) {
                $remark_query = "select max(cast(rmk_line_no as int))+1 as rmk_line_no from    jama_remark  where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' "
                    . "and cir_code = '$data->cir_code' and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and "
                    . "vill_townprt_code = '$data->vill_townprt_code' and patta_type_code='$suggested_patta_type_code' and trim(patta_no)=trim('$suggested_patta_no')";
                $rmk_line_no = $this->db->query($remark_query)->row()->rmk_line_no;

                if ($rmk_line_no == null) {
                    $rmk_line_no = 1;
                }

                $update_jama_new = "Update jama_remark set patta_no = '$suggested_patta_no',patta_type_code = '$suggested_patta_type_code',rmk_line_no = '$rmk_line_no' "
                    . "where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' "
                    . "and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and "
                    . "patta_type_code='$patta_type_code' and trim(patta_no)=trim('$data->patta_no') and rmk_line_no = '$rmk_line_id[$i]' ";
                $this->db->query($update_jama_new);
            }
        }
    }


    //   function FinalupdatePattaNo($case_no, $proposal_no) {
    // $db=  $this->session->userdata('db');
    //       $this->db->trans_begin();
    //       $user_code = $this->session->userdata('user_code');

    //       $q = "select * from    t_legacyupdation where case_no = '$case_no' and proposal_no = '$proposal_no' ";
    //       $data = $this->db->query($q)->row();


    //       $where = array(
    //           'dist_code' => $data->dist_code,
    //           'subdiv_code' => $data->subdiv_code,
    //           'cir_code' => $data->cir_code,
    //           'mouza_pargona_code' => $data->mouza_pargona_code,
    //           'lot_no' => $data->lot_no,
    //           'vill_townprt_code' => $data->vill_townprt_code,
    //           'dag_no' => $data->dag_no,
    //           'patta_no' => $data->patta_no,
    //           'patta_type_code' => $data->patta_type_code,
    //       );

    //       $patta_type_code = $data->patta_type_code;

    //       if ($data->suggested_patta_type != '0') {
    //           $suggested_patta_type_code = $data->suggested_patta_type;            
    //       } else {
    //           $suggested_patta_type_code = $patta_type_code;
    //       }

    //       $pattadar_chitha_side = "Select * from chitha_dag_pattadar where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' "
    //               . "and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and "
    //               . "patta_type_code='$patta_type_code' and patta_no=trim('$data->patta_no') and dag_no = trim('$data->dag_no') ";
    //       $pattadar_chitha = $this->db->query($pattadar_chitha_side)->result();

    //       foreach ($pattadar_chitha as $cpd) {
    //               /*---------------- Getting New Pattadar ID ----------------------------------*/
    //               $pdar_in_jama = "Select max(cast(pdar_id as int)) as c from    jama_pattadar where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' "
    //                       . "and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and "
    //                       . "patta_type_code='$suggested_patta_type_code' and patta_no=trim('$data->suggested_patta_no')";
    //               $pattadar_in_jama = $this->db->query($pdar_in_jama)->row()->c;


    //               $pdar_in_chitha = "Select max(cast(pdar_id as int)) as c from    Chitha_pattadar where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' "
    //                       . "and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and "
    //                       . "patta_type_code='$suggested_patta_type_code' and patta_no=trim('$data->suggested_patta_no')";
    //               $pattadar_in_chitha = $this->db->query($pdar_in_chitha)->row()->c;

    //               if($pattadar_in_chitha > $pattadar_in_jama){
    //                       $pdar_id_query = "select max(cast(pdar_id as int))+1 as pdar_id from    chitha_pattadar  where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' "
    //                               . "and cir_code = '$data->cir_code' and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and "
    //                               . "vill_townprt_code = '$data->vill_townprt_code' and patta_type_code='$suggested_patta_type_code' and patta_no=trim('$data->suggested_patta_no')";
    //               } else {
    //                       $pdar_id_query = "select max(cast(pdar_id as int))+1 as pdar_id from    jama_pattadar  where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' "
    //                               . "and cir_code = '$data->cir_code' and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and "
    //                               . "vill_townprt_code = '$data->vill_townprt_code' and patta_type_code='$suggested_patta_type_code' and patta_no=trim('$data->suggested_patta_no')";
    //               }
    //               $pdar_id = $this->db->query($pdar_id_query)->row()->pdar_id;

    //               if($pdar_id == null){
    //                   $pdar_id = 1;
    //               }
    //               /*---------------- Getting New Pattadar ID ----------------------------------*/
    //               $pdar_exist_in_other_dag = "Select count(*) as count from    Chitha_dag_pattadar WHERE dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' "
    //                   . "and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and "
    //                   . "patta_type_code='$patta_type_code' and patta_no=trim('$data->patta_no') and pdar_id = '$cpd->pdar_id' ";
    //               $result = $this->db->query($pdar_exist_in_other_dag)->row()->count;

    //               if ($result > '1') {
    //                   $pattadar_names = "Select * from    Chitha_pattadar WHERE dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' "
    //                   . "and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and "
    //                   . "patta_type_code='$patta_type_code' and patta_no=trim('$data->patta_no') and pdar_id = '$cpd->pdar_id' ";
    //                   $pattadar_insert_again = $this->db->query($pattadar_names)->row();
    //                   // pattadars name has to be newly inserted in chitha_pattadar.
    //                   $chitha_pattadar = array(
    //                       'dist_code' => $data->dist_code,
    //                       'subdiv_code' => $data->subdiv_code,
    //                       'cir_code' => $data->cir_code,
    //                       'mouza_pargona_code' => $data->mouza_pargona_code,
    //                       'lot_no' => $data->lot_no,
    //                       'vill_townprt_code' => $data->vill_townprt_code,
    //                       'pdar_id' => $pdar_id,
    //                       'patta_no' => trim($data->suggested_patta_no),
    //                       'patta_type_code' => $suggested_patta_type_code,
    //                       'pdar_name' => $pattadar_insert_again->pdar_name,
    //                       'pdar_father' => $pattadar_insert_again->pdar_father,
    //                       'pdar_add1' => $pattadar_insert_again->pdar_add1,
    //                       'pdar_add2' => $pattadar_insert_again->pdar_add2,
    //                       'pdar_add3' => "",
    //                       'user_code' => $cpd->user_code,
    //                       'date_entry' => date('Y-m-d G:i:s'),
    //                       'operation' => $cpd->operation,
    //                       'jama_yn' => '',//$cpd->jama_yn,
    //                       'pdar_guard_reln' => $pattadar_insert_again->pdar_guard_reln,
    //                       'new_pdar_name' => $pattadar_insert_again->new_pdar_name
    //                   );
    //                   //var_dump($chitha_pattadar);
    //                   $this->db->insert('chitha_pattadar', $chitha_pattadar);
    //               } else {
    //                 $update_chitha_pattadar = "Update chitha_pattadar set patta_no = '$data->suggested_patta_no', patta_type_code = '$suggested_patta_type_code', pdar_id = '$pdar_id', jama_yn = '' where dist_code = '$data->dist_code' and "
    //                     . "subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' and mouza_pargona_code = '$data->mouza_pargona_code' and "
    //                     . "lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and patta_type_code='$patta_type_code' and patta_no=trim('$data->patta_no') and pdar_id = '$cpd->pdar_id' ";
    //                 $this->db->query($update_chitha_pattadar);
    //               }
    //               // pattadars details has to be updated in chitha_dag_pattadar.
    //               $update_chitha_dag_pattadar = "Update chitha_dag_pattadar set patta_no = '$data->suggested_patta_no', patta_type_code = '$suggested_patta_type_code', pdar_id = '$pdar_id', jama_yn = '' "
    //                   . "where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' and mouza_pargona_code = '$data->mouza_pargona_code' "
    //                   . "and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and patta_type_code='$patta_type_code' and "
    //                   . "patta_no=trim('$data->patta_no') and dag_no = '$data->dag_no'  and pdar_id = '$cpd->pdar_id' ";
    //               $this->db->query($update_chitha_dag_pattadar);
    //       }

    //       $update_chitha_basic = "Update chitha_basic set patta_no = '$data->suggested_patta_no', patta_type_code = '$suggested_patta_type_code', jama_yn = '' "
    //                   . "where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' and mouza_pargona_code = '$data->mouza_pargona_code' "
    //                   . "and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and patta_type_code='$patta_type_code' and "
    //                   . "patta_no=trim('$data->patta_no') and dag_no = '$data->dag_no' ";
    //       $this->db->query($update_chitha_basic);

    //       $update_jama_old = "Update chitha_basic set jama_yn = '' where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' "
    //               . "and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and "
    //               . "patta_type_code='$patta_type_code' and patta_no=trim('$data->patta_no') ";
    //       $this->db->query($update_jama_old);

    //       $update_jama_new = "Update chitha_basic set jama_yn = '' where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' "
    //               . "and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and "
    //               . "patta_type_code='$suggested_patta_type_code' and patta_no=trim('$data->suggested_patta_no') ";
    //       $this->db->query($update_jama_new);

    //       $delete_old_dag_from_jama = "Delete from jama_dag where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' "
    //               . "and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and "
    //               . "patta_type_code='$patta_type_code' and patta_no=trim('$data->patta_no') and dag_no = '$data->dag_no'";
    //       $this->db->query($delete_old_dag_from_jama); 

    //       $delete_old_dag_pattadar_from_jama = "Delete from jama_pattadar where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' "
    //               . "and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and "
    //               . "patta_type_code='$patta_type_code' and patta_no=trim('$data->patta_no') ";
    //       $this->db->query($delete_old_dag_pattadar_from_jama); 

    //       if($data->rmk_line_no){
    //           $rmk_line_id = explode(",",$data->rmk_line_no);

    //           for ($i = 0; $i < sizeof($rmk_line_id); $i++) {
    //               $remark_query = "select max(cast(rmk_line_no as int))+1 as rmk_line_no from    jama_remark  where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' "
    //                               . "and cir_code = '$data->cir_code' and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and "
    //                               . "vill_townprt_code = '$data->vill_townprt_code' and patta_type_code='$suggested_patta_type_code' and patta_no=trim('$data->suggested_patta_no')";
    //              // $rmk_line_no = $this->db->query($remark_query)->row()->rmk_line_no;

    //               if($rmk_line_no == null){
    //                   $rmk_line_no = 1;
    //               }

    //               $update_jama_new = "Update jama_remark set patta_no = '$data->suggested_patta_no',patta_type_code = '$suggested_patta_type_code',rmk_line_no = '$rmk_line_no' "
    //                       . "where dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' "
    //                       . "and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no' and vill_townprt_code = '$data->vill_townprt_code' and "
    //                       . "patta_type_code='$patta_type_code' and patta_no=trim('$data->patta_no') and rmk_line_no = '$rmk_line_id[$i]' ";
    //              // $this->db->query($update_jama_new);
    //           }
    //       }
    //   }

    //   public function Reject() {
    // $db=  $this->session->userdata('db');
    //       $user_code = $this->session->userdata('user_code');

    //       $proposal_no = $this->session->userdata['co_array']['proposal_no'];
    //       $case_no = $this->session->userdata['co_array']['case_no'];
    //       $finalcoorder = $this->session->userdata['co_array']['order'];
    //       $final_report = $this->session->userdata['co_array']['final_report'];
    //       $user_desig_code = $this->session->userdata['co_array']['designation'];
    //       $date_entry = date('Y-m-d');

    //       if ($user_desig_code == 'CO') {
    //           $this->db->query("UPDATE t_legacyupdation SET status = 'R', status_date = '$date_entry',co_yn = 'Y', co_note = '$finalcoorder', co_orddate = '$date_entry', "
    //                   . "co_code = '$user_code' WHERE case_no = '$case_no' and  proposal_no = '$proposal_no'");
    //       } else {
    //           $this->db->query("UPDATE t_legacyupdation SET status = 'R', status_date = '$date_entry',dc_yn = 'Y', dc_adc_note = '$finalcoorder', dc_adc_orddate = '$date_entry', "
    //                   . "dc_adc_code = '$user_code' WHERE case_no = '$case_no' and  proposal_no = '$proposal_no'");
    //       }
    //       $this->session->set_flashdata('message', "# $case_no has been rejected.");
    //       redirect(base_url() . "index.php/home");
    //   }

    public function Reject()
    {

        $db =  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');
        $date_entry = date('Y-m-d');
        $proposal_no = $this->session->userdata['co_array']['proposal_no'];
        $case_no = $this->session->userdata['co_array']['case_no'];
        $finalcoorder = $this->session->userdata['co_array']['order'];
        $final_report = $this->session->userdata['co_array']['final_report'];
        $user_desig_code = $this->session->userdata['co_array']['designation'];

        $application_no = $this->session->userdata['co_array']['application_no'];
        // var_dump($application_no);
        // exit;

        if ($application_no) {
            $order = 'Rejected';
            $_POST['application_no'] = $application_no;
            $_POST['order'] = $order;
            if ($user_desig_code == 'CO') {
                $this->db->query("UPDATE t_legacyupdation SET status = 'R', status_date = '$date_entry',co_yn = 'Y', co_note = '$finalcoorder', co_orddate = '$date_entry', "
                    . "co_code = '$user_code' WHERE case_no = '$case_no' and  proposal_no = '$proposal_no'");
            } else {
                $this->db->query("UPDATE t_legacyupdation SET status = 'R', status_date = '$date_entry',dc_yn = 'Y', dc_adc_note = '$finalcoorder', dc_adc_orddate = '$date_entry', "
                    . "dc_adc_code = '$user_code' WHERE case_no = '$case_no' and  proposal_no = '$proposal_no'");
            }

            $this->basundharamodel->RejectOrder();
        } else {


            if ($user_desig_code == 'CO') {
                $this->db->query("UPDATE t_legacyupdation SET status = 'R', status_date = '$date_entry',co_yn = 'Y', co_note = '$finalcoorder', co_orddate = '$date_entry', "
                    . "co_code = '$user_code' WHERE case_no = '$case_no' and  proposal_no = '$proposal_no'");
            } else {
                $this->db->query("UPDATE t_legacyupdation SET status = 'R', status_date = '$date_entry',dc_yn = 'Y', dc_adc_note = '$finalcoorder', dc_adc_orddate = '$date_entry', "
                    . "dc_adc_code = '$user_code' WHERE case_no = '$case_no' and  proposal_no = '$proposal_no'");
            }
        }
        $this->session->set_flashdata('message', "# $case_no has been rejected.");
        redirect(base_url() . "index.php/home");
    }

    public function getFlowIndex()
    {
        $user_desig_code = $this->session->userdata('user_desig_code');
        $process_flow = JUNK_DAG_FLOW;
        $key = array_search($user_desig_code, $process_flow);
        if ($key !== false) {
            return $key;
        } else {
            dd("user not authorized");
        }
    }
    public function getCaseNo()
    {
        $case_name = $this->genearteCaseName();
        if (empty($case_name)) {
            $data = array(
                'error' => "Network Issue or Seesion Out. Please try Again"
            );
            echo json_encode($data);
            exit;
            die();
        }
        $serial_no = $this->genearteGovNameChangeNo();
        $case_no = $case_name . $serial_no . "/JDM";
        return $case_no;
    }
    function genearteCaseName()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $financialyeardate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('y') : date('Y') . "-" . date('y', strtotime('+1 year'));
        $q = "Select dist_abbr,cir_abbr from location where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code!='00' ";
        $abbrname = $this->db->query($q)->row();
        if ($abbrname) {
            $cir_dist_name = $abbrname->dist_abbr . "/" . $abbrname->cir_abbr;
            $case_no = $cir_dist_name . "/" . $financialyeardate . "/";
            return $case_no;
        }
        return false;
    }
    function genearteGovNameChangeNo()
    {
        $petition_no = $this->db->query("select nextval('junk_dag_modification_request_id_seq') as count ")->row()->count;
        return $petition_no;
    }

    function modifydagpatta()
    {
        $db = $this->session->userdata('db');
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $circle_code = $this->input->get('cir_code');
        $mouza_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_code = $this->input->get('village_code');
        $dag_number = trim($this->input->get('dag_no'));
        $patta_number = trim($this->input->get('patta_no'));
        $patta_type = $this->input->get('patta_code');

        // 🔹 chitha_basic
        $sql_basic = "
            SELECT *
            FROM chitha_basic
            WHERE dist_code = ? 
            AND subdiv_code = ? 
            AND cir_code = ? 
            AND mouza_pargona_code = ?
            AND lot_no = ? 
            AND vill_townprt_code = ? 
            AND TRIM(dag_no) = ? 
            AND TRIM(patta_no) = ? 
            AND patta_type_code = ?
        ";
        $data['basic_details'] = $this->db->query($sql_basic, [
            $dist_code, $subdiv_code, $circle_code, $mouza_code,
            $lot_no, $vill_code, $dag_number, $patta_number, $patta_type
        ])->row();

        // 🔹 chitha_dag_pattadar
        $sql_cdp = "
            SELECT pdar_id, p_flag, dag_no, patta_no, patta_type_code
            FROM chitha_dag_pattadar
            WHERE dist_code = ? 
            AND subdiv_code = ? 
            AND cir_code = ? 
            AND mouza_pargona_code = ? 
            AND lot_no = ? 
            AND vill_townprt_code = ? 
            AND TRIM(dag_no) = ? 
            AND TRIM(patta_no) = ? 
            AND patta_type_code = ?
        ";
        $data['cdp'] = $this->db->query($sql_cdp, [
            $dist_code, $subdiv_code, $circle_code, $mouza_code,
            $lot_no, $vill_code, $dag_number, $patta_number, $patta_type
        ])->result();

        // 🔹 chitha_pattadar
        $sql_cp = "
            SELECT dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, 
                pdar_id, pdar_name, pdar_father
            FROM chitha_pattadar
            WHERE dist_code = ? 
            AND subdiv_code = ? 
            AND cir_code = ? 
            AND mouza_pargona_code = ? 
            AND lot_no = ? 
            AND vill_townprt_code = ? 
            AND TRIM(patta_no) = ? 
            AND patta_type_code = ?
        ";
        $data['cp'] = $this->db->query($sql_cp, [
            $dist_code, $subdiv_code, $circle_code, $mouza_code,
            $lot_no, $vill_code, $patta_number, $patta_type
        ])->result();

        // 🔹 patta type name
        $patta_type_name = $this->db
            ->query("SELECT patta_type AS patta_name FROM patta_code WHERE type_code = ?", [$patta_type])
            ->row()->patta_name ?? 'NA';

        // 🔹 land class name
        $land_class_name = $this->db
            ->query("SELECT land_type AS class_name FROM landclass_code WHERE class_code = ?", [$data['basic_details']->land_class_code])
            ->row()->class_name ?? 'NA';

        // 🔹 location data
        $districtdata = $this->utilityclass->getDistrictName($dist_code);
        $subdivdata = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $lotdata = $this->utilityclass->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
        $villagedata = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);

        /////// Flow Control ////////
        $index = $this->getFlowIndex();

        // 🔹 junk_dag_modification_request
        $app_sql = "
            SELECT * 
            FROM junk_dag_modification_request
            WHERE dist_code = ?
            AND subdiv_code = ?
            AND cir_code = ?
            AND mouza_pargona_code = ?
            AND lot_no = ?
            AND vill_townprt_code = ?
            AND TRIM(dag_no) = ?
            AND TRIM(patta_no) = ?
        ";
        $application = $this->db->query($app_sql, [
            $dist_code, $subdiv_code, $circle_code, $mouza_code,
            $lot_no, $vill_code, $dag_number, $patta_number
        ])->row();

        $data['update_dag'] = $application->update_dag ?? 'NA';
        $case_no = $application->case_no ?? 'NA';
        $data['case_no'] = $case_no;
        $data['reverted'] = isset($application->status) && $application->status == 'reverted' ? 1 : 0;

        // 🔹 supportive documents
        $document_sql = "SELECT * FROM supportive_document WHERE case_no = ?";
        $data['documents'] = $this->db->query($document_sql, [$case_no])->result();

        // 🔹 remarks
        $remark_sql = "SELECT * FROM petition_proceeding WHERE case_no = ? ORDER BY proceeding_id";
        $data['remarks'] = $this->db->query($remark_sql, [$case_no])->result();

        // 🔹 Button Name Logic
        if ($index == 0) {
            if (isset($application->status) && $application->status == 'reverted') {
                $data['button_name'] = 'Forward';
            } else {
                $data['button_name'] = 'Apply';
                $data['case_no'] = $this->getCaseNo();
            }
        } elseif ($index == count(JUNK_DAG_FLOW) - 1) {
            $data['button_name'] = 'Approve';
        } else {
            $data['button_name'] = 'Forward';
        }

        // 🔹 Location and extra info
        $data['location'] = [
            'dist_code' => $districtdata,
            'subdiv_code' => $subdivdata,
            'cir_code' => $circledata,
            'mouza_pargona_code' => $mouzadata,
            'lot_no' => $lotdata,
            'vill_townprt_code' => $villagedata,
            'patta_name' => $patta_type_name,
            'land_class_name' => $land_class_name,
        ];

        $data['index'] = $index;
        $data['_view'] = 'LegacyDataUpdation/updatedagno';

        $this->load->view('layouts/main', $data);
    }


    function revertMethod(){
        $this->db->trans_begin();
        // Get max proceeding_id
        $this->db->select_max('proceeding_id');
        $this->db->where('case_no', $this->input->post('app_id', true));
        $query = $this->db->get('petition_proceeding');
        $row = $query->row();
        $max_proceeding_id = $row ? $row->proceeding_id : 0;
        $p_pro = [
            "case_no"            => $this->input->post('app_id', true),
            "proceeding_id"      => $max_proceeding_id + 1,
            "co_order"           => $this->input->post('remarks', true),
            "note_on_order"      => 'NA',
            "status"             => '0',
            "user_code"          => $this->session->userdata('user_code'),
            "date_entry"         => date('Y-m-d H:i:s'),
            "operation"          => 'E',
            "dist_code"          => $this->input->post('dist_code', true),
            "subdiv_code"        => $this->input->post('subdiv_code', true),
            "cir_code"           => $this->input->post('cir_code', true),
            "user_desig_code"    => $this->session->userdata('user_desig_code'),
            "mouza_pargona_code" => $this->input->post('mouza_pargona_code', true),
            "lot_no"             => $this->input->post('lot_no', true),
            "task"               => 'Revert'
        ];
        // Insert into petition_proceeding
        $this->db->insert('petition_proceeding', $p_pro);
        /////////////////// End ///////////////
        $index = $this->getFlowIndex();
        $data = [
                'forward_index'     => $index - 1,
                'status'            => 'reverted'
            ];
        $where = [
            'dag_no'            => $this->input->post('dag_no', true),
            'patta_no'          => $this->input->post('patta_no', true),
            'update_dag'        => $this->input->post('Update_dag', true),
            'dist_code'         => $this->input->post('dist_code', true),
            'subdiv_code'       => $this->input->post('subdiv_code', true),
            'cir_code'          => $this->input->post('cir_code', true),
            'mouza_pargona_code' => $this->input->post('mouza_pargona_code', true),
            'lot_no'            => $this->input->post('lot_no', true),
            'vill_townprt_code' => $this->input->post('vill_townprt_code', true),
            'patta_type_code'   => $this->input->post('patta_type_code', true),
        ];
        $this->db->where($where);
        $this->db->update('junk_dag_modification_request', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', 'Sorry...Modification Cannot be Done here !! Please Contact Help Desk !!');
            redirect(base_url() . "index.php/home");
        } else {
            $this->db->trans_complete();
            $this->session->set_flashdata('message', "Reverted . Thank You !!");
            redirect(base_url() . "index.php/home");
            exit;
        }
    }
    function updatedagno()
    {
       
        $db =  $this->session->userdata('db');
        if ($_POST) {
            if($this->input->post('button')=='revert'){
                $this->revertMethod();
            }
            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $cir_code = $this->input->post('cir_code');
            $mouza_pargona_code = $this->input->post('mouza_pargona_code');
            $lot_no = $this->input->post('lot_no');
            $vill_townprt_code = $this->input->post('vill_townprt_code');
            $dag_no = trim($this->input->post('dag_no'));
            $patta_no = trim($this->input->post('patta_no'));
            $patta_type_code = $this->input->post('patta_type_code');
            $update_dag = trim($this->input->post('Update_dag'));

            if(!$update_dag){
                $this->session->set_flashdata('message', 'Error');
                redirect(base_url() . "index.php/home");
            }
            $where_cb = array(
                'dist_code'         => $dist_code,
                'subdiv_code'       => $subdiv_code,
                'cir_code'          => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no'            => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
            );

            //////////// validation ///////////
            $this->db->from('chitha_basic cb');
            $this->db->where("TRIM(cb.dag_no) =", trim($dag_no));
            $this->db->where("TRIM(cb.patta_no) =", trim($patta_no));
            $this->db->where($where_cb);
            $row = $this->db->get()->row(); // only one row

            if ($row) {
                if (!preg_match("/[^a-z0-9]/i", $row->dag_no)) {
                    $this->session->set_flashdata('message', 'Error');
                    redirect(base_url() . "index.php/home");
                }
            }

            $this->db->from('chitha_basic');
            $this->db->where('trim(dag_no)', $update_dag);
            $this->db->where($where_cb);
            $query = $this->db->get()->num_rows();
            if ($query == 0) {
                $this->db->trans_begin();

                $where_cb = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code
                );
                $this->db->from('junk_dag_modification_request');
                $this->db->where('trim(dag_no)', $dag_no);
                $this->db->where('trim(update_dag)', $update_dag);
                $this->db->where($where_cb);
                $data = $this->db->get();
                $jdmrecord = $data->row();
                // dd($jdmrecord);
                $index = $this->getFlowIndex();
                if (!empty($jdmrecord) && $index == 0 && $jdmrecord->status != 'reverted') {
                    $this->db->trans_rollback();
                    log_message('error', "DAG Generate...ERRO01" . $this->db->last_query());
                    $this->session->set_flashdata('message', 'Sorry(ERRO01)...Already Applied For Dag No !! Please Contact Help Desk !!');
                    redirect(base_url() . "index.php/home");
                }

                ///////////////// Remarks ////////////

                // Get max proceeding_id
                $this->db->select_max('proceeding_id');
                $this->db->where('case_no', $this->input->post('app_id', true));
                $query = $this->db->get('petition_proceeding');
                $row = $query->row();
                $max_proceeding_id = $row ? $row->proceeding_id : 0;

                $p_pro = [
                    "case_no"            => $this->input->post('app_id', true),
                    "proceeding_id"      => $max_proceeding_id + 1,
                    "co_order"           => $this->input->post('remarks', true),
                    "note_on_order"      => 'NA',
                    "status"             => '0',
                    "user_code"          => $this->session->userdata('user_code'),
                    "date_entry"         => date('Y-m-d H:i:s'),
                    "operation"          => 'E',
                    "dist_code"          => $this->input->post('dist_code', true),
                    "subdiv_code"        => $this->input->post('subdiv_code', true),
                    "cir_code"           => $this->input->post('cir_code', true),
                    "user_desig_code"    => $this->session->userdata('user_desig_code'),
                    "mouza_pargona_code" => $this->input->post('mouza_pargona_code', true),
                    "lot_no"             => $this->input->post('lot_no', true),
                    "task"               => 'Forward'
                ];

                // Insert into petition_proceeding
                $this->db->insert('petition_proceeding', $p_pro);

                /////////////////// End ///////////////

                
                if ($index == 0 && empty($jdmrecord)) {
                    $data = [
                        'dag_no'            => $this->input->post('dag_no', true),
                        'patta_no'          => $this->input->post('patta_no', true),
                        'update_dag'        => $this->input->post('Update_dag', true),
                        'dist_code'         => $this->input->post('dist_code', true),
                        'subdiv_code'       => $this->input->post('subdiv_code', true),
                        'cir_code'          => $this->input->post('cir_code', true),
                        'mouza_pargona_code' => $this->input->post('mouza_pargona_code', true),
                        'lot_no'            => $this->input->post('lot_no', true),
                        'vill_townprt_code' => $this->input->post('vill_townprt_code', true),
                        'patta_type_code'   => $this->input->post('patta_type_code', true),
                        'created_by'        => $this->session->userdata('user_code'),
                        'created_at'        => date('Y-m-d H:i:s'),
                        'forward_index'     => $index + 1,
                        'status'            => 'initiated',
                        'case_no'           => $this->input->post('app_id', true),
                    ];
                    $this->db->insert('junk_dag_modification_request', $data);
                    if ($this->db->affected_rows() < 0) {
                        $this->db->trans_rollback();
                        log_message('error', "DAG Generate...ERR3775" . $this->db->last_query());
                        $this->session->set_flashdata('message', 'Sorry(ERR3775)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                        redirect(base_url() . "index.php/home");
                    }
                    $this->db->trans_complete();
                    $this->session->set_flashdata('message', "Forwarded Suceessfully . Thank You !!");
                    redirect(base_url() . "index.php/home");
                    exit;
                } else if ($index == count(JUNK_DAG_FLOW) - 1) {
                    $data = [
                        'forward_index'     => $index + 1,
                        'status'            => 'completed'
                    ];
                } else {
                    $data = [
                        'forward_index'     => $index + 1,
                        'status'            => 'forwarded'
                    ];
                }

                $where = [
                    'dag_no'            => $this->input->post('dag_no', true),
                    'patta_no'          => $this->input->post('patta_no', true),
                    'update_dag'        => $this->input->post('Update_dag', true),
                    'dist_code'         => $this->input->post('dist_code', true),
                    'subdiv_code'       => $this->input->post('subdiv_code', true),
                    'cir_code'          => $this->input->post('cir_code', true),
                    'mouza_pargona_code' => $this->input->post('mouza_pargona_code', true),
                    'lot_no'            => $this->input->post('lot_no', true),
                    'vill_townprt_code' => $this->input->post('vill_townprt_code', true),
                    'patta_type_code'   => $this->input->post('patta_type_code', true),
                ];

                $this->db->where($where);
                $this->db->update('junk_dag_modification_request', $data);

                if ($this->db->affected_rows() < 0) {
                    $this->db->trans_rollback();
                    log_message('error', "DAG Generate...ERR3812" . $this->db->last_query());
                    $this->session->set_flashdata('message', 'Sorry(ERR3812)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    redirect(base_url() . "index.php/home");
                }

                if ($index != count(JUNK_DAG_FLOW) - 1) {
                    $this->db->trans_complete();
                    $this->session->set_flashdata('message', "Forwarded Suceessfully . Thank You !!");
                    redirect(base_url() . "index.php/home");
                    exit;
                }

                $where_cb = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                );
                $this->db->from('chitha_basic');
                $this->db->where('trim(dag_no)', $dag_no);
                $this->db->where($where_cb);
                $data = $this->db->get();
                $record = $data->row();
                if (empty($record)) {
                    $this->db->trans_rollback();
                    log_message('error', "DAG Generate...ERRO01" . $this->db->last_query());
                    $this->session->set_flashdata('message', 'Sorry(ERRO01)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    redirect(base_url() . "index.php/home");
                }


                $record->dag_no = $update_dag;
                $record->dag_no_int = $update_dag . "00";
                $record->date_entry = date('Y-m-d H:i:s');
                $record->user_code = $this->session->userdata('user_code');
                $record->jama_yn = 'n';
                // $this->db->insert('chitha_basic', $record);
                $this->Chitha_basic_model->insert_table('chitha_basic', $record);
                if ($this->db->affected_rows() != 1) {
                    $this->db->trans_rollback();
                    log_message('error', "DAG Generate...ERRO11" . $this->db->last_query());
                    $this->session->set_flashdata('message', 'Sorry(ERRO11)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    redirect(base_url() . "index.php/home");
                }
                $val = $this->db->affected_rows();
                if ($val == 1) {
                    $updateArray = array(
                        'dag_no' => $update_dag
                    );
                    // $where = array(
                    //     'dist_code' => $dist_code,
                    //     'subdiv_code' => $subdiv_code,
                    //     'cir_code' => $cir_code,
                    //     'mouza_pargona_code' => $mouza_pargona_code,
                    //     'lot_no' => $lot_no,
                    //     'vill_townprt_code' => $vill_townprt_code,
                    // );
                    // $this->db->where($where);
                    // $this->db->where('trim(dag_no)', $dag_no);
                    // $this->db->update('chitha_dag_pattadar', $updateArray);
                    $table = 'chitha_dag_pattadar';
                    $params = ['dag_no' => $update_dag];
                    $where2 = [
                        'dist_code' => $dist_code,
                        'subdiv_code' => $subdiv_code,
                        'cir_code' => $cir_code,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'lot_no' => $lot_no,
                        'vill_townprt_code' => $vill_townprt_code,
                        'dag_no' => $dag_no
                    ];
                    // $dag_no_trim = $dag_no;
                    $this->Chitha_basic_model->update_table($table, $params, $where2);
                    // echo $this->db->last_query();die;
                    if ($this->db->affected_rows() < 0) {
                        $this->db->trans_rollback();
                        log_message('error', "DAG Generate...ERRO12" . $this->db->last_query());
                        $this->session->set_flashdata('message', 'Sorry(ERRO12)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                        redirect(base_url() . "index.php/home");
                    }
                    
                    $tables = [
                        'chitha_col8_inplace',
                        'chitha_col8_occup',
                        'chitha_col8_order',
                        'chitha_fruit',
                        'chitha_mcrop',
                        'chitha_noncrop',
                        'chitha_rmk_allottee',
                        'chitha_rmk_alongwith',
                        'chitha_rmk_convorder',
                        'chitha_rmk_encro',
                        'chitha_rmk_gen',
                        'chitha_rmk_infavor_of',
                        'chitha_rmk_inplace_of',
                        'chitha_rmk_lmnote',
                        'chitha_rmk_onbehalf',
                        'chitha_rmk_ordbasic',
                        'chitha_rmk_other_opp_party',
                        'chitha_rmk_sknote',
                        'chitha_rmk_reclassification',
                        'chitha_subtenant',
                        'chitha_tenant',
                        'backlog_orders',
                        'jama_dag',
                        'field_mut_dag_details',
                        'petition_dag_details',
                        'petition_pattadar',
                        't_chitha_rmk_ordbasic',
                        't_chitha_rmk_alongwith',
                        'petition_lm_note',
                        't_chitha_rmk_infavor_of'
                    ];
                    foreach ($tables as $t) {
                        $ind_where =[
                            'dist_code'         => $dist_code,
                            'subdiv_code'       => $subdiv_code,
                            'cir_code'          => $cir_code,
                            'mouza_pargona_code' => $mouza_pargona_code,
                            'lot_no'            => $lot_no,
                            'vill_townprt_code' => $vill_townprt_code
                        ];
                        $this->db->select('*')
                            ->from($t)
                            ->where($ind_where)
                            ->where("TRIM(dag_no) =", trim($dag_no));
                        $query = $this->db->get();
                        if ($query !== false && $query->num_rows() > 0) {
                            
                            $this->db->where($ind_where);
                            $this->db->where('trim(dag_no)', $dag_no);
                            $this->db->update($t, $updateArray);
                            // dd($this->db->last_query());
                            if ($this->db->affected_rows() < 0) {
                                $this->db->trans_rollback();
                                log_message('error', "DAG Generate...ERRO13" . $this->db->last_query());
                                $this->session->set_flashdata('message', 'Sorry(ERRO13)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                                redirect(base_url() . "index.php/home");
                            }
                        }
                    }
                    // dd('here');
                    // $query = $this->db->query("Select FROM  chitha_col8_inplace WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and trim(dag_no) = '$dag_no' ");
                    // if ($query->num_rows()) {
                    //     $this->db->where($where);
                    //     $this->db->where('trim(dag_no)', $dag_no);
                    //     $this->db->update('chitha_col8_inplace', $updateArray);
                    //     if($this->db->affected_rows()<0)
                    //     {
                    //         $this->db->trans_rollback();
                    //         log_message('error',"DAG Generate...ERRO13".$this->db->last_query());
                    //         $this->session->set_flashdata('message', 'Sorry(ERRO13)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    //         redirect(base_url() . "index.php/home");
                    //     }
                    // }
                    // $query = $this->db->query("Select * FROM  chitha_col8_occup WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and trim(dag_no) = '$dag_no' ");
                    // if ($query->num_rows()) {
                    //     $this->db->where($where);
                    //     $this->db->where('trim(dag_no)', $dag_no);
                    //     $this->db->update('chitha_col8_occup', $updateArray);
                    //     if($this->db->affected_rows()<0)
                    //     {
                    //         $this->db->trans_rollback();
                    //         log_message('error',"DAG Generate...ERRO14".$this->db->last_query());
                    //         $this->session->set_flashdata('message', 'Sorry(ERRO14)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    //         redirect(base_url() . "index.php/home");
                    //     }
                    // }
                    // $query = $this->db->query("Select * FROM  chitha_col8_order WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and trim(dag_no) = '$dag_no' ");
                    // if ($query->num_rows()) {
                    //     $this->db->where($where);
                    //     $this->db->where('trim(dag_no)', $dag_no);
                    //     $this->db->update('chitha_col8_order', $updateArray);
                    //     if($this->db->affected_rows()<0)
                    //     {
                    //         $this->db->trans_rollback();
                    //         log_message('error',"DAG Generate...ERRO15".$this->db->last_query());
                    //         $this->session->set_flashdata('message', 'Sorry(ERRO15)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    //         redirect(base_url() . "index.php/home");
                    //     }
                    // }
                    // $query = $this->db->query("Select * FROM  chitha_fruit WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and trim(dag_no) = '$dag_no' ");
                    // if ($query->num_rows()) {
                    //     $this->db->where($where);
                    //     $this->db->where('trim(dag_no)', $dag_no);
                    //     $this->db->update('chitha_fruit', $updateArray);
                    //     if($this->db->affected_rows()<0)
                    //     {
                    //         $this->db->trans_rollback();
                    //         log_message('error',"DAG Generate...ERRO16".$this->db->last_query());
                    //         $this->session->set_flashdata('message', 'Sorry(ERRO16)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    //         redirect(base_url() . "index.php/home");
                    //     }
                    // }
                    // $query = $this->db->query("Select * FROM  chitha_mcrop WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and trim(dag_no) = '$dag_no' ");
                    // if ($query->num_rows()) {
                    //     //echo $query->num_rows();
                    //     $this->db->where($where);
                    //     $this->db->where('trim(dag_no)', $dag_no);
                    //     $this->db->update('chitha_mcrop', $updateArray);
                    //     if($this->db->affected_rows()<0)
                    //     {
                    //         $this->db->trans_rollback();
                    //         log_message('error',"DAG Generate...ERRO17".$this->db->last_query());
                    //         $this->session->set_flashdata('message', 'Sorry(ERRO17)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    //         redirect(base_url() . "index.php/home");
                    //     }
                    // }
                    // $query = $this->db->query("Select * FROM  chitha_noncrop WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and trim(dag_no) = '$dag_no' ");
                    // if ($query->num_rows()) {
                    //     //echo $query->num_rows();
                    //     $this->db->where($where);
                    //     $this->db->where('trim(dag_no)', $dag_no);
                    //     $this->db->update('chitha_noncrop', $updateArray);
                    //     if($this->db->affected_rows()<0)
                    //     {
                    //         $this->db->trans_rollback();
                    //         log_message('error',"DAG Generate...ERRO18".$this->db->last_query());
                    //         $this->session->set_flashdata('message', 'Sorry(ERRO18)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    //         redirect(base_url() . "index.php/home");
                    //     }
                    // }
                    // $query = $this->db->query("Select * FROM  chitha_rmk_allottee WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and trim(dag_no) = '$dag_no' ");
                    // if ($query->num_rows()) {
                    //     //echo $query->num_rows();
                    //     $this->db->where($where);
                    //     $this->db->where('trim(dag_no)', $dag_no);
                    //     $this->db->update('chitha_rmk_allottee', $updateArray);
                    //     if($this->db->affected_rows()<0)
                    //     {
                    //         $this->db->trans_rollback();
                    //         log_message('error',"DAG Generate...ERRO19".$this->db->last_query());
                    //         $this->session->set_flashdata('message', 'Sorry(ERRO19)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    //         redirect(base_url() . "index.php/home");
                    //     }
                    // }
                    // $query = $this->db->query("Select * FROM  chitha_rmk_alongwith WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and trim(dag_no) = '$dag_no' ");
                    // if ($query->num_rows()) {
                    //     //echo $query->num_rows();
                    //     $this->db->where($where);
                    //     $this->db->where('trim(dag_no)', $dag_no);
                    //     $this->db->update('chitha_rmk_alongwith', $updateArray);
                    //     if($this->db->affected_rows()<0)
                    //     {
                    //         $this->db->trans_rollback();
                    //         log_message('error',"DAG Generate...ERRO20".$this->db->last_query());
                    //         $this->session->set_flashdata('message', 'Sorry(ERRO20)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    //         redirect(base_url() . "index.php/home");
                    //     }
                    // }
                    // $query = $this->db->query("Select * FROM  chitha_rmk_convorder WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and trim(dag_no) = '$dag_no' ");
                    // if ($query->num_rows()) {
                    //     //echo $query->num_rows();
                    //     $this->db->where($where);
                    //     $this->db->where('trim(dag_no)', $dag_no);
                    //     $this->db->update('chitha_rmk_convorder', $updateArray);
                    //     if($this->db->affected_rows()<0)
                    //     {
                    //         $this->db->trans_rollback();
                    //         log_message('error',"DAG Generate...ERRO21".$this->db->last_query());
                    //         $this->session->set_flashdata('message', 'Sorry(ERRO21)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    //         redirect(base_url() . "index.php/home");
                    //     }
                    // }
                    // $query = $this->db->query("Select * FROM  chitha_rmk_encro WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and trim(dag_no) = '$dag_no' ");
                    // if ($query->num_rows()) {
                    //     //echo $query->num_rows();
                    //     $this->db->where($where);
                    //     $this->db->where('trim(dag_no)', $dag_no);
                    //     $this->db->update('chitha_rmk_encro', $updateArray);
                    //     if($this->db->affected_rows()<0)
                    //     {
                    //         $this->db->trans_rollback();
                    //         log_message('error',"DAG Generate...ERRO22".$this->db->last_query());
                    //         $this->session->set_flashdata('message', 'Sorry(ERRO22)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    //         redirect(base_url() . "index.php/home");
                    //     }
                    // }
                    // $query = $this->db->query("Select * FROM  chitha_rmk_gen WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and trim(dag_no) = '$dag_no' ");
                    // if ($query->num_rows()) {
                    //     //echo $query->num_rows();
                    //     $this->db->where($where);
                    //     $this->db->where('trim(dag_no)', $dag_no);
                    //     $this->db->update('chitha_rmk_gen', $updateArray);
                    //     if($this->db->affected_rows()<0)
                    //     {
                    //         $this->db->trans_rollback();
                    //         log_message('error',"DAG Generate...ERRO23".$this->db->last_query());
                    //         $this->session->set_flashdata('message', 'Sorry(ERRO23)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    //         redirect(base_url() . "index.php/home");
                    //     }
                    // }
                    // $query = $this->db->query("Select * FROM  chitha_rmk_infavor_of WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and trim(dag_no) = '$dag_no' ");
                    // if ($query->num_rows()) {
                    //     //echo $query->num_rows();
                    //     $this->db->where($where);
                    //     $this->db->where('trim(dag_no)', $dag_no);
                    //     $this->db->update('chitha_rmk_infavor_of', $updateArray);
                    //     if($this->db->affected_rows()<0)
                    //     {
                    //         $this->db->trans_rollback();
                    //         log_message('error',"DAG Generate...ERRO24".$this->db->last_query());
                    //         $this->session->set_flashdata('message', 'Sorry(ERRO24)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    //         redirect(base_url() . "index.php/home");
                    //     }
                    // }


                    // $query = $this->db->query("Select * FROM  chitha_rmk_inplace_of WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and trim(dag_no) = '$dag_no' ");
                    // if ($query->num_rows()) {
                    //     //echo $query->num_rows();
                    //     $this->db->where($where);
                    //     $this->db->where('trim(dag_no)', $dag_no);
                    //     $this->db->update('chitha_rmk_inplace_of', $updateArray);
                    //     if($this->db->affected_rows()<0)
                    //     {
                    //         $this->db->trans_rollback();
                    //         log_message('error',"DAG Generate...ERRO25".$this->db->last_query());
                    //         $this->session->set_flashdata('message', 'Sorry(ERRO25)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    //         redirect(base_url() . "index.php/home");
                    //     }
                    // }
                    // $query = $this->db->query("Select * FROM  chitha_rmk_lmnote WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and trim(dag_no) = '$dag_no' ");
                    // if ($query->num_rows()) {
                    //     //echo $query->num_rows();
                    //     $this->db->where($where);
                    //     $this->db->where('trim(dag_no)', $dag_no);
                    //     $this->db->update('chitha_rmk_lmnote', $updateArray);
                    //     if($this->db->affected_rows()<0)
                    //     {
                    //         $this->db->trans_rollback();
                    //         log_message('error',"DAG Generate...ERRO26".$this->db->last_query());
                    //         $this->session->set_flashdata('message', 'Sorry(ERRO26)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    //         redirect(base_url() . "index.php/home");
                    //     }
                    // }
                    // $query = $this->db->query("Select * FROM  chitha_rmk_onbehalf WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and trim(dag_no) = '$dag_no' ");
                    // if ($query->num_rows()) {
                    //     //echo $query->num_rows();
                    //     $this->db->where($where);
                    //     $this->db->where('trim(dag_no)', $dag_no);
                    //     $this->db->update('chitha_rmk_onbehalf', $updateArray);
                    //     if($this->db->affected_rows()<0)
                    //     {
                    //         $this->db->trans_rollback();
                    //         log_message('error',"DAG Generate...ERRO27".$this->db->last_query());
                    //         $this->session->set_flashdata('message', 'Sorry(ERRO27)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    //         redirect(base_url() . "index.php/home");
                    //     }
                    // }
                    // $query = $this->db->query("Select * FROM  chitha_rmk_ordbasic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and trim(dag_no) = '$dag_no' ");
                    // if ($query->num_rows()) {
                    //     //echo $query->num_rows();
                    //     $this->db->where($where);
                    //     $this->db->where('trim(dag_no)', $dag_no);
                    //     $this->db->update('chitha_rmk_ordbasic', $updateArray);
                    //     if($this->db->affected_rows()<0)
                    //     {
                    //         $this->db->trans_rollback();
                    //         log_message('error',"DAG Generate...ERRO28".$this->db->last_query());
                    //         $this->session->set_flashdata('message', 'Sorry(ERRO28)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    //         redirect(base_url() . "index.php/home");
                    //     }
                    // }
                    // $query = $this->db->query("Select * FROM  chitha_rmk_other_opp_party WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and trim(dag_no) = '$dag_no' ");
                    // if ($query->num_rows()) {
                    //     //echo $query->num_rows();
                    //     $this->db->where($where);
                    //     $this->db->where('trim(dag_no)', $dag_no);
                    //     $this->db->update('chitha_rmk_other_opp_party', $updateArray);
                    //     if($this->db->affected_rows()<0)
                    //     {
                    //         $this->db->trans_rollback();
                    //         log_message('error',"DAG Generate...ERRO29".$this->db->last_query());
                    //         $this->session->set_flashdata('message', 'Sorry(ERRO29)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    //         redirect(base_url() . "index.php/home");
                    //     }
                    // }
                    // $query = $this->db->query("Select * FROM  chitha_rmk_sknote WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and trim(dag_no) = '$dag_no' ");
                    // if ($query->num_rows()) {
                    //     //echo $query->num_rows();
                    //     $this->db->where($where);
                    //     $this->db->where('trim(dag_no)', $dag_no);
                    //     $this->db->update('chitha_rmk_sknote', $updateArray);
                    //     if($this->db->affected_rows()<0)
                    //     {
                    //         $this->db->trans_rollback();
                    //         log_message('error',"DAG Generate...ERRO30".$this->db->last_query());
                    //         $this->session->set_flashdata('message', 'Sorry(ERRO30)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    //         redirect(base_url() . "index.php/home");
                    //     }
                    // }
                    // $query = $this->db->query("Select * FROM  chitha_rmk_reclassification WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and trim(dag_no) = '$dag_no' ");
                    // if ($query->num_rows()) {
                    //     //echo $query->num_rows();
                    //     $this->db->where($where);
                    //     $this->db->where('trim(dag_no)', $dag_no);
                    //     $this->db->update('chitha_rmk_reclassification', $updateArray);
                    //     if($this->db->affected_rows()<0)
                    //     {
                    //         $this->db->trans_rollback();
                    //         log_message('error',"DAG Generate...ERRO31".$this->db->last_query());
                    //         $this->session->set_flashdata('message', 'Sorry(ERRO31)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    //         redirect(base_url() . "index.php/home");
                    //     }
                    // }
                    // $query = $this->db->query("Select * FROM  chitha_subtenant WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and trim(dag_no) = '$dag_no' ");
                    // if ($query->num_rows()) {
                    //     //echo $query->num_rows();
                    //     $this->db->where($where);
                    //     $this->db->where('trim(dag_no)', $dag_no);
                    //     $this->db->update('chitha_subtenant', $updateArray);
                    //     if($this->db->affected_rows()<0)
                    //     {
                    //         $this->db->trans_rollback();
                    //         log_message('error',"DAG Generate...ERRO32".$this->db->last_query());
                    //         $this->session->set_flashdata('message', 'Sorry(ERRO32)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    //         redirect(base_url() . "index.php/home");
                    //     }
                    // }
                    // $query = $this->db->query("Select * FROM  chitha_tenant WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and trim(dag_no) = '$dag_no' ");
                    // if ($query->num_rows()) {
                    //     //echo $query->num_rows();
                    //     $this->db->where($where);
                    //     $this->db->where('trim(dag_no)', $dag_no);
                    //     $this->db->update('chitha_tenant', $updateArray);
                    //     if($this->db->affected_rows()<0)
                    //     {
                    //         $this->db->trans_rollback();
                    //         log_message('error',"DAG Generate...ERRO33".$this->db->last_query());
                    //         $this->session->set_flashdata('message', 'Sorry(ERRO33)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    //         redirect(base_url() . "index.php/home");
                    //     }
                    // }
                    // $query = $this->db->query("Select * FROM  backlog_orders WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and trim(dag_no) = '$dag_no' ");
                    // if ($query->num_rows()) {
                    //     //echo $query->num_rows();
                    //     $this->db->where($where);
                    //     $this->db->where('trim(dag_no)', $dag_no);
                    //     $this->db->update('backlog_orders', $updateArray);
                    //     if($this->db->affected_rows()<0)
                    //     {
                    //         $this->db->trans_rollback();
                    //         log_message('error',"DAG Generate...ERRO34".$this->db->last_query());
                    //         $this->session->set_flashdata('message', 'Sorry(ERRO34)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    //         redirect(base_url() . "index.php/home");
                    //     }
                    // }
                    // $query = $this->db->query("Select * FROM  jama_dag WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and trim(dag_no) = '$dag_no' ");

                    // if ($query->num_rows()) {
                    //     //echo $query->num_rows();
                    //     $this->db->where($where);
                    //     $this->db->where('trim(dag_no)', $dag_no);
                    //     $this->db->update('jama_dag', $updateArray);
                    //     if($this->db->affected_rows()<0)
                    //     {
                    //         $this->db->trans_rollback();
                    //         log_message('error',"DAG Generate...ERRO35".$this->db->last_query());
                    //         $this->session->set_flashdata('message', 'Sorry(ERRO35)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    //         redirect(base_url() . "index.php/home");
                    //     }

                    // }


                    // // dd($this->db);
                    // $query = $this->db->query("Select * FROM  field_mut_dag_details WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and trim(dag_no) = '$dag_no' ");
                    // // echo $this->db->last_query();die;
                    // if ($query->num_rows()) {
                    //     //echo $query->num_rows();
                    //     $this->db->where($where);
                    //     $this->db->where('trim(dag_no)', $dag_no);
                    //     $this->db->update('field_mut_dag_details', $updateArray);
                    //     if($this->db->affected_rows()<0)
                    //     {
                    //         $this->db->trans_rollback();
                    //         log_message('error',"DAG Generate...ERRO37".$this->db->last_query());
                    //         $this->session->set_flashdata('message', 'Sorry(ERRO37)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    //         redirect(base_url() . "index.php/home");
                    //     }
                    // }
                    // $query = $this->db->query("Select * FROM  petition_dag_details WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and trim(dag_no) = '$dag_no' ");
                    // //echo $query->num_rows();
                    // if ($query->num_rows()) {
                    //     //echo $query->num_rows();
                    //     $this->db->where($where);
                    //     $this->db->where('trim(dag_no)', $dag_no);
                    //     $this->db->update('petition_dag_details', $updateArray);
                    //     if($this->db->affected_rows()<0)
                    //     {
                    //         $this->db->trans_rollback();
                    //         log_message('error',"DAG Generate...ERRO38".$this->db->last_query());
                    //         $this->session->set_flashdata('message', 'Sorry(ERRO38)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    //         redirect(base_url() . "index.php/home");
                    //     }
                    // }
                    // $query = $this->db->query("Select * FROM  petition_pattadar WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and trim(dag_no) = '$dag_no' ");
                    // //echo $query->num_rows();
                    // if ($query->num_rows()) {
                    //     //echo $query->num_rows();
                    //     $this->db->where($where);
                    //     $this->db->where('trim(dag_no)', $dag_no);
                    //     $this->db->update('petition_pattadar', $updateArray);
                    //     if($this->db->affected_rows()<0)
                    //     {
                    //         $this->db->trans_rollback();
                    //         log_message('error',"DAG Generate...ERRO38".$this->db->last_query());
                    //         $this->session->set_flashdata('message', 'Sorry(ERRO38)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    //         redirect(base_url() . "index.php/home");
                    //     }
                    // }
                    // $query = $this->db->query("Select * FROM  t_chitha_rmk_ordbasic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and trim(dag_no) = '$dag_no' ");
                    // //echo $query->num_rows();
                    // if ($query->num_rows()) {
                    //     //echo $query->num_rows();
                    //     $this->db->where($where);
                    //     $this->db->where('trim(dag_no)', $dag_no);
                    //     $this->db->update('t_chitha_rmk_ordbasic', $updateArray);
                    //     if($this->db->affected_rows()<0)
                    //     {
                    //         $this->db->trans_rollback();
                    //         log_message('error',"DAG Generate...ERRO38".$this->db->last_query());
                    //         $this->session->set_flashdata('message', 'Sorry(ERRO38)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    //         redirect(base_url() . "index.php/home");
                    //     }
                    // }
                    // $query = $this->db->query("Select * FROM  t_chitha_rmk_alongwith WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and trim(dag_no) = '$dag_no' ");
                    // //echo $query->num_rows();
                    // if ($query->num_rows()) {
                    //     //echo $query->num_rows();
                    //     $this->db->where($where);
                    //     $this->db->where('trim(dag_no)', $dag_no);
                    //     $this->db->update('t_chitha_rmk_alongwith', $updateArray);
                    //     if($this->db->affected_rows()<0)
                    //     {
                    //         $this->db->trans_rollback();
                    //         log_message('error',"DAG Generate...ERRO38".$this->db->last_query());
                    //         $this->session->set_flashdata('message', 'Sorry(ERRO38)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    //         redirect(base_url() . "index.php/home");
                    //     }
                    // }
                    // $query = $this->db->query("Select * FROM  petition_lm_note WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and trim(dag_no) = '$dag_no' ");
                    // //echo $query->num_rows();
                    // if ($query->num_rows()) {
                    //     //echo $query->num_rows();
                    //     $this->db->where($where);
                    //     $this->db->where('trim(dag_no)', $dag_no);
                    //     $this->db->update('petition_lm_note', $updateArray);
                    //     if($this->db->affected_rows()<0)
                    //     {
                    //         $this->db->trans_rollback();
                    //         log_message('error',"DAG Generate...ERRO38".$this->db->last_query());
                    //         $this->session->set_flashdata('message', 'Sorry(ERRO38)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    //         redirect(base_url() . "index.php/home");
                    //     }
                    // }
                    // $query = $this->db->query("Select * FROM  t_chitha_rmk_infavor_of WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and trim(dag_no) = '$dag_no' ");
                    // //echo $query->num_rows();
                    // if ($query->num_rows()) {
                    //     //echo $query->num_rows();
                    //     $this->db->where($where);
                    //     $this->db->where('trim(dag_no)', $dag_no);
                    //     $this->db->update('t_chitha_rmk_infavor_of', $updateArray);
                    //     if($this->db->affected_rows()<0)
                    //     {
                    //         $this->db->trans_rollback();
                    //         log_message('error',"DAG Generate...ERRO38".$this->db->last_query());
                    //         $this->session->set_flashdata('message', 'Sorry(ERRO38)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    //         redirect(base_url() . "index.php/home");
                    //     }
                    // }
                    
                    $this->db->where([
                        'dist_code'          => $dist_code,
                        'subdiv_code'        => $subdiv_code,
                        'cir_code'           => $cir_code,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'lot_no'             => $lot_no,
                        'vill_townprt_code'  => $vill_townprt_code
                    ]);
                    $this->db->where("TRIM(dag_no) =", trim($dag_no));
                    $this->db->delete('chitha_basic');
                    // var_dump($this->db) ; die;
                    if ($this->db->affected_rows() == 0) {
                        // dd($this->db->last_query());
                        $this->db->trans_rollback();
                        log_message('error', "DAG Generate...ERRO36" . $this->db->last_query());
                        $this->session->set_flashdata('message', 'Sorry(ERRO36)...Modification Cannot be Done here !! Please Contact Help Desk !!');
                        redirect(base_url() . "index.php/home");
                    }
                } else {
                    $this->db->trans_rollback();
                    log_message('error', "DAG Generate...ERRO37" . $this->db->last_query());
                    $this->session->set_flashdata('message', "Please write this issue to help desk person. Thank You !!");
                    redirect(base_url() . "index.php/home");
                }
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', 'Sorry...Modification Cannot be Done here !! Please Contact Help Desk !!');
                    redirect(base_url() . "index.php/home");
                } else {
                    $this->db->trans_complete();
                    $this->session->set_flashdata('message', "Dag Number Suceessfully Updated . Thank You !!");
                    redirect(base_url() . "index.php/home");
                    exit;
                }
            } else {
                $this->session->set_flashdata('message', "This Dag No. $update_dag already exists! Please try again with different dag no. ");
                redirect(base_url() . "index.php/home");
                exit;
            }
        }
    }

    function ReportLm()
    {
        // $this->load->helper('html');
        // $this->load->view('header');
        // $this->load->view('LegacyDataUpdation/locationselect');
        // $this->load->view('footer');
        $data['_view'] = 'LegacyDataUpdation/locationselect';
        $this->load->view('layouts/main', $data);
    }

    function GenerateReport()
    {
        $db =  $this->session->userdata('db');
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        $mouza_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');

        $dist_code_name = $this->utilityclass->getDistrictName($dist_code);
        $subdiv_code_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_code_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouza_pargona_code_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $lot_no_name = $this->utilityclass->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
        $vill_townprt_code_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);

        $cases['location'] = array(
            'dist' => $dist_code_name,
            'sub' => $subdiv_code_name,
            'cir' => $cir_code_name,
            'mouza' => $mouza_pargona_code_name,
            'lot' => $lot_no_name,
            'vill' => $vill_townprt_code_name
        );

        $sql = "SELECT * 
                FROM t_legacyupdation 
                WHERE status = 'F'
                AND dist_code = ?
                AND subdiv_code = ?
                AND cir_code = ?
                AND mouza_pargona_code = ?
                AND lot_no = ?
                AND vill_townprt_code = ?
                ORDER BY proposal_no ASC";

        $params = array(
            $dist_code,
            $subdiv_code,
            $circle_code,
            $mouza_code,
            $lot_no,
            $vill_code
        );

        $cases['cases'] = $this->db->query($sql, $params)->result();


        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/LegacyDataUpdation/GenerateReport', $cases);
        // $this->load->view('../views/footer');
        $cases['_view'] = 'LegacyDataUpdation/GenerateReport';
        $this->load->view('layouts/main', $cases);
    }

    function ReportCo()
    {
        $db =  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $circle_code = $this->session->userdata('cir_code');

        $dist_code_name = $this->utilityclass->getDistrictName($dist_code);
        $subdiv_code_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_code_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $circle_code);
        $cases['location'] = array(
            'dist' => $dist_code_name,
            'sub' => $subdiv_code_name,
            'cir' => $cir_code_name
        );
        $q = "select * from t_legacyupdation where status = 'F' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' ORDER BY proposal_no asc";
        $data['cases'] = $this->db->query($q)->result();

        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/LegacyDataUpdation/GenerateReportCo', $cases);
        // $this->load->view('../views/footer');
        $data['_view'] = 'LegacyDataUpdation/GenerateReportCo';
        $this->load->view('layouts/main', $data);
    }

    public function generateChitha()
    {
        $db =  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $district_code = $this->input->get('dist_code');
        $subdivision_code = $this->input->get('subdiv_code');
        $circlecode = $this->input->get('cir_code');
        $mouzacode = $this->input->get('mouza_pargona_code');
        $lot_code = $this->input->get('lot_no');
        $village_code = $this->input->get('vill_townprt_code');
        $patta_code = $this->input->get('patta_type');
        $dag_no_lower = $this->input->get('dag_no');
        $dag_no_upper = $this->input->get('dag_no');
        $year_no = date('Y');
        $current_year = date('Y');
        $dag_no_lower = $dag_no_lower . '00';
        $dag_no_upper = $dag_no_upper . '00';

        $dist_name = $this->utilityclass->getDistrictName($district_code);
        $subdiv_name = $this->utilityclass->getSubDivName($district_code, $subdivision_code);
        $cir_name = $this->utilityclass->getCircleName($district_code, $subdivision_code, $circlecode);
        $mouza_pargona_code_name = $this->utilityclass->getMouzaName($district_code, $subdivision_code, $circlecode, $mouzacode);
        $lot_no = $this->utilityclass->getLotLocationName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code);
        $vill_townprt_code_name = $this->utilityclass->getVillageName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code);

        $data['location'] = array('dist' => $dist_name, 'sub' => $subdiv_name, 'cir' => $cir_name, 'mouza' => $mouza_pargona_code_name, 'lot' => $lot_no, 'vill' => $vill_townprt_code_name);
        $data['year_no'] = $year_no;

        $secondSelection = array('patta_code' => $patta_code, 'dag_no_lower' => $dag_no_lower, 'dag_no_upper' => $dag_no_upper);

        $this->load->model('chitha/ChithaModel');
        $pattatype['chithaPattatypeinfo'] = $this->ChithaModel->getpattatype($patta_code);
        $this->session->set_userdata(array('patta_type' => $pattatype['chithaPattatypeinfo'][0]->patta_type));

        if ($year_no == $current_year) {
            if ($patta_code != '0000') {
                $chithainfo1['data'] = $this->ChithaModel->getchithaDetails123($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper, $patta_code);
            } else {
                $chithainfo1['data'] = $this->ChithaModel->getchithaDetailsALL($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper);
            }
        } else {
            if ($patta_code != '0000') {
                $chithainfo1['data'] = $this->ChithaModel->getchithaDetails123Test($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper, $patta_code, $year_no);
            } else {
                $chithainfo1['data'] = $this->ChithaModel->getchithaDetailsALLTest($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper, $year_no);
            }
        }

        $maindataforchitha = array_merge($data, $secondSelection, $chithainfo1, $pattatype);
        //$this->load->helper('html');
        //$this->load->view('header');
        if ($year_no == $current_year) {
            //$content = $this->load->view('chitha_report/saveChithaReport', $maindataforchitha);
            $maindataforchitha['_view'] = 'chitha_report/saveChithaReport';
            $this->load->view('layouts/main', $maindataforchitha);
        } else {
            $maindataforchitha['_view'] = 'chitha_report/ChithaReport';
            $this->load->view('layouts/main', $maindataforchitha);
            // $content = $this->load->view('chitha_report/ChithaReport', $maindataforchitha);
        }
        //$this->load->view('footer');
    }

    public function saveJamabandiByPattano()
    {
        $db =  $this->session->userdata('db');
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $circle_code = $this->input->get('cir_code');
        $mouza_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_code = $this->input->get('vill_townprt_code');
        $pattatypeCode = $this->input->get('patta_type');
        $patta_no = trim($this->input->get('patta_no'));
        $main = array();
        $jamainfo = array();

        $pattatype = array(
            'patta_type' => $pattatypeCode,
            'patta_no' => $patta_no
        );
        $this->session->set_userdata($pattatype);
        $this->load->model('misreport/MisModel');

        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $lotdata = $this->MisModel->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
        $pattatypename = $this->MisModel->getpattatypeNameforJamabandi($pattatypeCode);

        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata, $pattatypename);
        $maindata['pattainfo'] = $pattatype;

        $pno = trim($patta_no);
        $main['daginfo'] = array();

        $get_patta_info = "select count(*) as count from    jama_patta WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
            . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno'";

        $get_patta_info = $this->db->query($get_patta_info)->row()->count;

        $pdar_alignment = '0'; //serialize by id
        if ($get_patta_info != "") {
            $query = "select jd.dag_no,jd.dag_revenue,jd.dag_localtax,jd.dag_area_b,jd.dag_area_k,jd.dag_area_lc,lcd.land_type,lcd.class_code_cat from    "
                . "jama_dag as jd  JOIN  landclass_code as lcd ON jd.dag_class_code=lcd.class_code WHERE jd.dist_code='$dist_code' and jd.subdiv_code = '$subdiv_code' and jd.cir_code='$circle_code' and "
                . "jd.mouza_pargona_code = '$mouza_code' and jd.lot_no = '$lot_no' and jd.vill_townprt_code='$vill_code' and "
                . "jd.patta_type_code='$pattatypeCode' and TRIM(jd.patta_no)='$pno' order by dag_no";

            $main['daginfo'] = $this->db->query($query)->result();
            $daginfo_counted = count($main['daginfo']);

            $main['sort_pdar_by'] = $pdar_alignment;
            if ($daginfo_counted != "") {
                if ($pdar_alignment == '0') {
                    $query = "select pdar_sl_no,patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc "
                        . "from    jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                        . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
                        . "patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno' order by length(pdar_id), pdar_id";
                }
                if ($pdar_alignment == '1') {
                    $query = "select pdar_sl_no,patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc "
                        . "from    jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                        . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
                        . "patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno' order by pdar_sl_no asc";
                }
                $main['pattadarinf'] = $this->db->query($query)->result();
            } else {
                //If dag and patta for old patta does not exist.
                $main['pattadarinf'] = null;
                $main['daginfo'] = null;
            }
            $query = "select patta_no,remark,rmk_line_no from    jama_remark WHERE "
                . "dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and "
                . "vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and "
                . "TRIM(patta_no)='$pno' order by rmk_line_no ";
            $main['remarkinf'] = $this->db->query($query)->result();

            $query = "select old_patta_no from    jama_patta WHERE "
                . "dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and "
                . "vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and "
                . "TRIM(patta_no)='$pno' ";
            $main['oldpno'] = $this->db->query($query)->result();

            $main = array_merge($maindata, $main);

            // $this->load->helper('html');
            // $this->load->view('header');
            // $this->load->view('jamabandi/save_jamabandi_by_entering_a_pattano', $main);
            $main['_view'] = 'jamabandi/save_jamabandi_by_entering_a_pattano';
            $this->load->view('layouts/main', $main);
        } else {
            //echo 'no jamabandi found';
            // $this->load->helper('html');
            // $this->load->view('header');
            // $this->load->view('jamabandi/no_jamabandi');
            $data['_view'] = 'jamabandi/no_jamabandi';
            $this->load->view('layouts/main', $data);
        }
        //$this->load->view('footer');
    }

    ///// 27-04-22 //// area correction report in basundhara ADC reject list


    function areaCorrReport()
    {

        $case_no = $this->input->get('app');
        $sql = "Select dharitree from basundhar_application where basundhara='$case_no' ";
        $dh = $this->db->query($sql)->row()->dharitree;

        if ($dh) {
            // $dharitree = $data->row()->dharitree;
            $data['comments_co'] = $this->db->query("SELECT * FROM t_legacyupdation 
           WHERE case_no='$dh' AND co_code like 'CO%'")->result();

            $data['comments_lm'] = $this->db->query("SELECT * FROM t_legacyupdation 
          WHERE case_no='$dh' AND lm_code like 'M%'")->result();
        }
        $this->load->view('LegacyDataUpdation/viewRejectReportACOR', $data);
    }
    //////////////////
    public function coLegacy()
    {

        $this->load->library('pagination');
        $db =  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
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
        // $this->load->model('legacyModel');
        $cases['searchKeyword'] = $this->session->userdata('searchKeyword');
        $config['base_url'] = base_url() . 'index.php/LegacyDataUpdation/coLegacy';
        $config['total_rows'] = $this->legacyModel->getCountPendingLegacyCases();
        $config['per_page'] = 10;
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
        $cases['cases'] = $this->legacyModel->getPendingLegacyCases($config["per_page"], $page, $searchKeyword);
        $cases['_view'] = 'LegacyDataUpdation/Legacy_cases';
        $this->load->view('layouts/main', $cases);
    }
    function searchFile()
    {
        $this->load->model('basundhara/basundharamodel');
        $cases['basundharaAttachment'] = $cases['sup_doc'] = null;
        $user_desig_code = $this->session->userdata('user_desig_code');
        if ($user_desig_code != 'CO') {
            echo json_encode('You are Not Authorised');
            return;
        }
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $case_no = $this->input->post('case_no');
            $sql = "Select * from basundhar_application where dharitree=? ";
            $data = $this->db->query($sql, $case_no);
            if ($data->num_rows() > 0) {
                $rtps = $data->row()->basundhara;
                $cases['basundharaAttachment'] = $this->basundharamodel->searchBasundharaLink($case_no);
            }
            $data1 = $this->db->query("SELECT * FROM supportive_document WHERE case_no=?", array($case_no));
            if ($data1->num_rows() > 0) {
                $cases['sup_doc'] = $data1->result();
            }

            $cases['_view'] = 'LegacyDataUpdation/searchFile';
            $this->load->view('layouts/main', $cases);
        } else {
            $cases['_view'] = 'LegacyDataUpdation/searchFile';
            $this->load->view('layouts/main', $cases);
        }
    }
}
