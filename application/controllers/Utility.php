<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
ini_set('max_execution_time', 0);

class Utility extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
        $this->load->model('conversion/ASTofficeConversionModel');
        $this->load->model('conversion/CoofficeConversionModel');
        $this->load->helper(array('form', 'url'));
        // $this->dbswitch();
        // $ip=$this->utilityclass->get_client_ip();
        // $client_ip=(explode(".",$ip));
        // if($client_ip[0] !='10' || $client_ip[1] !='177' || !($client_ip[2] =='15' || $client_ip[2] =='0' || $client_ip[2] =='48') ){
        //     show_error("You are Not Authorized","401",$heading="Error-401");
        //     return;
        // }
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

    public function getFlowIndex(){
        $user_desig_code = $this->session->userdata('user_desig_code');
        $process_flow = JUNK_DAG_FLOW;
        $key = array_search($user_desig_code, $process_flow);
        if ($key !== false) {
           return $key;
        } else {
            dd("user not authorized");
        }
    }
    public function misc_utilities() {
        // $this->load->view('../views/header');
        // $this->load->view('../views/utility/menu');
        // $this->load->view('../views/footer');
        $data['_view'] = 'utility/menu';
        $this->load->view('layouts/main',$data);
    }

    public function districtDetails() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        //$this->session->set_userdata(array('pattadar' => array()));
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
        //var_dump($district);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/utility/select_location', $district);
        // $this->load->view('../views/footer');
        $district['_view'] = 'utility/select_location';
        $this->load->view('layouts/main',$district);
    }

    public function get_all_junk_dags() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no             = $this->session->userdata('lot_no');

        $districtdata = $this->utilityclass->getDistrictName($dist_code);
        $subdivdata = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);

        $data['location'] = array(
            'dist_code' => $districtdata,
            'subdiv_code' => $subdivdata,
            'cir_code' => $circledata,
        );

        //$query1 = $this->db->query("select * from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' limit 100 ");
        //$query1 = $this->db->query("select * from chitha_basic where dag_no ~* '[^a-z0-9]' ");
        //// Flow Control/////
        $index = $this->getFlowIndex();
        if ($this->input->get('reverted') == 'true') {
            $sql = "
                SELECT *
                FROM chitha_basic cb
                JOIN junk_dag_modification_request jd
                    ON cb.dist_code = jd.dist_code
                    AND cb.subdiv_code = jd.subdiv_code
                    AND cb.cir_code = jd.cir_code
                    AND cb.mouza_pargona_code = jd.mouza_pargona_code
                    AND cb.lot_no = jd.lot_no
                    AND cb.vill_townprt_code = jd.vill_townprt_code
                    AND cb.dag_no = jd.dag_no
                WHERE cb.dist_code = ?
                AND TRIM(cb.dag_no) ~* '[^a-z0-9]'
                AND jd.status != 'completed'
                AND jd.forward_index = ?
            ";

            $params = [$dist_code, $index];

            if (!empty($subdiv_code)) {
                $sql .= " AND cb.subdiv_code = ?";
                $params[] = $subdiv_code;
            }
            if (!empty($cir_code)) {
                $sql .= " AND cb.cir_code = ?";
                $params[] = $cir_code;
            }
            if (!empty($mouza_pargona_code)) {
                $sql .= " AND cb.mouza_pargona_code = ?";
                $params[] = $mouza_pargona_code;
            }
            if (!empty($lot_no)) {
                $sql .= " AND cb.lot_no = ?";
                $params[] = $lot_no;
            }

            $query1 = $this->db->query($sql, $params);
            $data['reverted'] = 1;

        } else {

            if ($index == 0) {
                $data['button'] = 'Modify';

                $sql = "
                    SELECT cb.*
                    FROM chitha_basic cb
                    WHERE cb.dist_code = ?
                    AND cb.subdiv_code = ?
                    AND cb.cir_code = ?
                    AND cb.mouza_pargona_code = ?
                    AND cb.lot_no = ?
                    AND TRIM(cb.dag_no) ~* '[^a-z0-9]'
                    AND NOT EXISTS (
                            SELECT 1
                            FROM junk_dag_modification_request jd
                            WHERE jd.dist_code = cb.dist_code
                            AND jd.subdiv_code = cb.subdiv_code
                            AND jd.cir_code = cb.cir_code
                            AND jd.mouza_pargona_code = cb.mouza_pargona_code
                            AND jd.lot_no = cb.lot_no
                            AND jd.vill_townprt_code = cb.vill_townprt_code
                            AND jd.dag_no = cb.dag_no
                    )
                ";

                $query1 = $this->db->query($sql, [
                    $dist_code,
                    $subdiv_code,
                    $cir_code,
                    $mouza_pargona_code,
                    $lot_no
                ]);

            } else {
                $data['button'] = 'Process';

                $sql = "
                    SELECT *
                    FROM chitha_basic cb
                    JOIN junk_dag_modification_request jd
                        ON cb.dist_code = jd.dist_code
                        AND cb.subdiv_code = jd.subdiv_code
                        AND cb.cir_code = jd.cir_code
                        AND cb.mouza_pargona_code = jd.mouza_pargona_code
                        AND cb.lot_no = jd.lot_no
                        AND cb.vill_townprt_code = jd.vill_townprt_code
                        AND cb.dag_no = jd.dag_no
                    WHERE cb.dist_code = ?
                    AND TRIM(cb.dag_no) ~* '[^a-z0-9]'
                    AND jd.status != 'completed'
                    AND jd.forward_index = ?
                ";

                $params = [$dist_code, $index];

                if (!empty($subdiv_code)) {
                    $sql .= " AND cb.subdiv_code = ?";
                    $params[] = $subdiv_code;
                }
                if (!empty($cir_code)) {
                    $sql .= " AND cb.cir_code = ?";
                    $params[] = $cir_code;
                }

                $query1 = $this->db->query($sql, $params);
            }

            $data['reverted'] = 0;
        }

        $all_cases = $query1->result();

        // Prepare output array
        $main = [];
        foreach ($all_cases as $all_c) {

            $patta_query = "SELECT patta_type AS patta_name FROM patta_code WHERE type_code = ?";
            $patta_name = $this->db->query($patta_query, [$all_c->patta_type_code])->row()->patta_name ?? null;

            $main[] = [
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $all_c->mouza_pargona_code,
                'lot_no' => $all_c->lot_no,
                'vill_townprt_code' => $all_c->vill_townprt_code,
                'patta_no' => trim($all_c->patta_no),
                'old_dag_no' => $all_c->old_dag_no,
                'dag_no' => $all_c->dag_no,
                'dag_no_int' => $all_c->dag_no_int,
                'patta_name' => $patta_name,
                'patta_code' => $all_c->patta_type_code,
            ];
        }

        $data['junk'] = $main;

        //var_dump($data);
        // $this->load->view('../views/header');
        // $this->load->view('../views/utility/detailed_dags', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'utility/detailed_dags';
        $this->load->view('layouts/main',$data);
    }

    public function modifydagpatta() {
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $circle_code = $this->input->get('cir_code');
        $mouza_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_code = $this->input->get('village_code');

        $patta_no = $this->input->get('patta_no');
        $dag_no = $this->input->get('dag_no');
        $dag_no_int = $this->input->get('dag_no_int');

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
        );

        $get_patta_info = "select * from chitha_basic WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
            . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and TRIM(patta_no)='$patta_no' and dag_no = '$dag_no' and dag_no_int='$dag_no_int'";

        $get_patta_info = $this->db->query($get_patta_info)->result();

        $main = array();
        foreach ($get_patta_info as $all_c) {
            $patta_type = "select patta_type as patta_name from patta_code where type_code = '$all_c->patta_type_code' ";
            $patta_name = $this->db->query($patta_type)->row()->patta_name;

            $main[] = array
            (
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $circle_code,
                'mouza_pargona_code' => $all_c->mouza_pargona_code,
                'lot_no' => $all_c->lot_no,
                'vill_townprt_code' => $all_c->vill_townprt_code,
                'patta_no' => trim($all_c->patta_no),
                'patta_name' => $patta_name,
                'patta_code' => $all_c->patta_type_code,
            );
        }
        $data['junk'] = $main;
        // var_dump($data);
        // $this->load->view('../views/header');
        // $this->load->view('../views/utility/update_patta_no', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'utility/update_patta_no';
        $this->load->view('layouts/main',$data);
    }

    // public function update_patta_no($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $old_patta_no, $new_patta_no, $patta_code) {
    //     $old_patta_no = rawurldecode($old_patta_no);

    //     $check_in_patta_exist = "select count(*) as count from jama_patta WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
    //         . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and patta_no = '$new_patta_no' and patta_type_code = '$patta_code'";
    //     $check_in_patta_exist = $this->db->query($check_in_patta_exist)->row()->count;

    //     $check_in_chitha_exist = "select count(*) as count from chitha_basic WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
    //         . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and patta_no = '$new_patta_no' and patta_type_code = '$patta_code'";
    //     $check_in_chitha_exist = $this->db->query($check_in_chitha_exist)->row()->count;

    //     if (($check_in_patta_exist <= 0) && ($check_in_chitha_exist <= 0)) {
    //         $update_jama_dag = "update jama_dag set patta_no = '$new_patta_no' WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
    //             . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and patta_no = '$old_patta_no' and patta_type_code = '$patta_code'";
    //         $this->db->quert($update_jama_dag); //**********************

    //         $update_jama_patta = "update jama_patta set patta_no = '$new_patta_no' WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
    //             . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and patta_no = '$old_patta_no' and patta_type_code = '$patta_code'";
    //         $this->db->quert($update_jama_patta); //**********************

    //         $update_jama_pattadar = "update jama_pattadar set patta_no = '$new_patta_no' WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
    //             . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and patta_no = '$old_patta_no' and patta_type_code = '$patta_code'";
    //         $this->db->quert($update_jama_pattadar); //**********************

    //         $update_jama_remark = "update jama_remark set patta_no = '$new_patta_no' WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
    //             . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and patta_no = '$old_patta_no' and patta_type_code = '$patta_code'";
    //         $this->db->quert($update_jama_remark); //**********************

    //         $select_from_chitha = "select * from chitha_basic where dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
    //             . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and patta_no = '$old_patta_no' and patta_type_code = '$patta_code'";
    //         $select_from_chitha = $this->db->query($select_from_chitha)->result();

    //         foreach ($select_from_chitha as $from_chitha) {
    //             $dag_no = $from_chitha->dag_no;
    //             $update_chitha_pattadar = "update chitha_pattadar set patta_no = '$new_patta_no' where dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
    //                 . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and patta_no = '$old_patta_no' and "
    //                 . "patta_type_code = '$patta_code'";
    //             $this->db->quert($update_chitha_pattadar); //**********************

    //             $update_chitha_dag_pattadar = "update chitha_dag_pattadar set patta_no = '$new_patta_no' where dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
    //                 . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and patta_no = '$old_patta_no' and "
    //                 . "patta_type_code = '$patta_code' and dag_no = '$dag_no'";
    //             $this->db->quert($update_chitha_dag_pattadar); //**********************

    //             $update_chitha_rmk_convorder = "update chitha_rmk_convorder set patta_no = '$new_patta_no' where dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
    //                 . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and patta_no = '$old_patta_no' and "
    //                 . "patta_type_code = '$patta_code' and dag_no = '$dag_no'";
    //             $this->db->quert($update_chitha_rmk_convorder); //**********************

    //             $update_chitha_rmk_infavor_of = "update chitha_rmk_infavor_of set patta_no = '$new_patta_no' where dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
    //                 . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and patta_no = '$old_patta_no' and "
    //                 . "patta_type_code = '$patta_code' and dag_no = '$dag_no'";
    //             $this->db->quert($update_chitha_rmk_infavor_of); //**********************

    //             $update_chitha_rmk_reclassification = "update chitha_rmk_reclassification set patta_no = '$new_patta_no' where dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' "
    //                 . "and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and patta_no = '$old_patta_no' "
    //                 . "and patta_type_code = '$patta_code' and dag_no = '$dag_no'";
    //             $this->db->quert($update_chitha_rmk_reclassification); //**********************

    //             $update_chitha_rmk_allottee = "update chitha_rmk_allottee set patta_no = '$new_patta_no' where dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
    //                 . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and patta_no = '$old_patta_no' and "
    //                 . "dag_no = '$dag_no'";
    //             $this->db->quert($update_chitha_rmk_allottee); //**********************

    //             $update_chitha_rmk_gen = "update chitha_rmk_gen set patta_no = '$new_patta_no' where dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
    //                 . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and patta_no = '$old_patta_no' and "
    //                 . "dag_no = '$dag_no'";
    //             $this->db->quert($update_chitha_rmk_gen); //**********************

    //             $update_chitha_basic = "update chitha_basic set patta_no = '$new_patta_no' where dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
    //                 . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and patta_no = '$old_patta_no' and "
    //                 . "patta_type_code = '$patta_code' and dag_no = '$dag_no'";
    //             $this->db->quert($update_chitha_basic); //**********************
    //         }
    //         echo 1;
    //     } else {
    //         echo 0;
    //     }
    // }

    public function deletedagpatta() {
        $this->db->trans_begin();
        //var_dump($this->input->get());
        $dag_no = $this->input->get('dag_no');
        $patta_no = trim($this->input->get('patta_no'));
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $village_code = $this->input->get('village_code');

        $query = "select count(*) as c from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
            . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no' and TRIM(patta_no) = '$patta_no'";
        $result = $this->db->query($query)->row()->c;

        if ($result > 0) {
            $d6 = "Delete from chitha_fruit where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'"; // nai
            $this->db->query($d6);

            $d7 = "Delete from chitha_mcrop where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'"; // nai
            $this->db->query($d7);

            $d8 = "Delete from chitha_noncrop where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'"; //nai
            $this->db->query($d8);

            $d1 = "Delete from chitha_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and TRIM(patta_no) = '$patta_no'";
            $this->db->query($d1);

            $d2 = "Delete from chitha_col8_inplace where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'"; // nai
            $this->db->query($d2);

            $d3 = "Delete from chitha_col8_occup where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'"; // nai
            $this->db->query($d3);

            $d4 = "Delete from chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'"; // nai
            $this->db->query($d4);

            $d5 = "Delete from chitha_dag_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no' and TRIM(patta_no) = '$patta_no'"; // ase pdar id is 1 and 2
            $this->db->query($d5);



            $d9 = "Delete from chitha_pattadar_view where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no' and TRIM(patta_no) = '$patta_no'"; // nai
            $this->db->query($d9);

            $d10 = "Delete from chitha_subtenant where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'"; // nai
            $this->db->query($d10);

            $d11 = "Delete from chitha_tenant where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'"; // nai
            $this->db->query($d11);

            $d12 = "Delete from chitha_rmk_sknote where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'"; // nai
            $this->db->query($d12);

            $d13 = "Delete from chitha_rmk_reclassification where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no' and TRIM(patta_no) = '$patta_no'"; // nai
            $this->db->query($d13);

            $d14 = "Delete from chitha_rmk_ordbasic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'"; // nai
            $this->db->query($d14);

            $d15 = "Delete from chitha_rmk_onbehalf where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'"; // nai
            $this->db->query($d15);

            $d16 = "Delete from chitha_rmk_lmnote where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'"; // nai
            $this->db->query($d16);

            $d17 = "Delete from chitha_rmk_allottee where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'"; // nai
            $this->db->query($d17);

            $d18 = "Delete from chitha_rmk_alongwith where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'"; // nai
            $this->db->query($d18);

            $d19 = "Delete from chitha_rmk_convorder where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no' and TRIM(patta_no) = '$patta_no'"; // nai
            $this->db->query($d19);

            $d20 = "Delete from chitha_rmk_encro where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'"; // nai
            $this->db->query($d20);

            $d21 = "Delete from chitha_rmk_gen where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'"; // nai
            $this->db->query($d21);

            $d22 = "Delete from chitha_rmk_infavor_of where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no' and TRIM(patta_no) = '$patta_no'"; // nai
            $this->db->query($d22);

            $d23 = "Delete from chitha_rmk_inplace_of where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'"; // nai
            $this->db->query($d23);

            $d24 = "Delete from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no' and TRIM(patta_no) = '$patta_no'";
            $this->db->query($d24);

            //delete from jamabandi
            $d25 = "delete from Jama_Dag WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'";
            $this->db->query($d25);

            //Check if Dag No is in Field Mutation Tables
            $Field_Mut_dag_details = $this->db->query("select count(*) as xxx from Field_Mut_dag_details WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'")->row()->xxx;
            if ($Field_Mut_dag_details > 0) {
                $this->db->query("Delete from Field_Mut_dag_details WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
            }

            $Field_Mut_objection = $this->db->query("select count(*) as xxx from Field_Mut_objection WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mp_code='$mouza_pargona_code' and lot_no='$lot_no' and vt_code='$village_code' and dag_no = '$dag_no'")->row()->xxx;
            if ($Field_Mut_objection > 0) {
                $this->db->query("Delete from Field_Mut_objection WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mp_code='$mouza_pargona_code' and lot_no='$lot_no' and vt_code='$village_code' and dag_no = '$dag_no'");
            }
            $Field_Mut_pattadar = $this->db->query("select count(*) as xxx from Field_Mut_pattadar WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'")->row()->xxx;
            if ($Field_Mut_pattadar > 0) {
                $this->db->query("Delete from Field_Mut_pattadar WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
            }
            $Field_Part_petitioner = $this->db->query("select count(*) as xxx from Field_Part_petitioner WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'")->row()->xxx;
            if ($Field_Part_petitioner > 0) {
                $this->db->query("Delete from Field_Part_petitioner WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
            }
            //Check if Dag No is in office mutation tables
            $Petition_lm_note = $this->db->query("select count(*) as xxx from Petition_lm_note WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'")->row()->xxx;
            if ($Petition_lm_note > 0) {
                $this->db->query("Delete from Petition_lm_note WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
            }
            $petition_pattadar = $this->db->query("select count(*) as xxx from petition_pattadar WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'")->row()->xxx;
            if ($petition_pattadar > 0) {
                $this->db->query("Delete from petition_pattadar WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
            }
            $petitioner_part = $this->db->query("select count(*) as xxx from petitioner_part WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'")->row()->xxx;
            if ($petitioner_part > 0) {
                $this->db->query("Delete from petitioner_part WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
            }
            //Check if Dag No is in transactions
            $t_Chitha_col8_inplace = $this->db->query("select count(*) as xxx from t_Chitha_col8_inplace WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'")->row()->xxx;
            if ($t_Chitha_col8_inplace > 0) {
                $this->db->query("Delete from t_Chitha_col8_inplace WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
            }
            $t_Chitha_col8_Occup = $this->db->query("select count(*) as xxx from t_Chitha_col8_Occup WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'")->row()->xxx;
            if ($t_Chitha_col8_Occup > 0) {
                $this->db->query("Delete from t_Chitha_col8_Occup WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
            }
            $t_Chitha_col8_Order = $this->db->query("select count(*) as xxx from t_Chitha_col8_Order WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'")->row()->xxx;
            if ($t_Chitha_col8_Order > 0) {
                $this->db->query("Delete from t_Chitha_col8_Order WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
            }
            $t_Chitha_Rmk_allottee = $this->db->query("select count(*) as xxx from t_Chitha_Rmk_allottee WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'")->row()->xxx;
            if ($t_Chitha_Rmk_allottee > 0) {
                $this->db->query("Delete from t_Chitha_Rmk_allottee WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
            }
            $t_Chitha_Rmk_alongwith = $this->db->query("select count(*) as xxx from t_Chitha_Rmk_alongwith WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'")->row()->xxx;
            if ($t_Chitha_Rmk_alongwith > 0) {
                $this->db->query("Delete from t_Chitha_Rmk_alongwith WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
            }
            $t_Chitha_Rmk_convorder = $this->db->query("select count(*) as xxx from t_Chitha_Rmk_convorder WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'")->row()->xxx;
            if ($t_Chitha_Rmk_convorder > 0) {
                $this->db->query("Delete from t_Chitha_Rmk_convorder WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
            }
            $t_Chitha_Rmk_infavor_of = $this->db->query("select count(*) as xxx from t_Chitha_Rmk_infavor_of WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'")->row()->xxx;
            if ($t_Chitha_Rmk_infavor_of > 0) {
                $this->db->query("Delete from t_Chitha_Rmk_infavor_of WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
            }
            $t_Chitha_Rmk_inplace_of = $this->db->query("select count(*) as xxx from t_Chitha_Rmk_inplace_of WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'")->row()->xxx;
            if ($t_Chitha_Rmk_inplace_of > 0) {
                $this->db->query("Delete from t_Chitha_Rmk_inplace_of WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
            }
            $t_Chitha_Rmk_onbehalf = $this->db->query("select count(*) as xxx from t_Chitha_Rmk_onbehalf WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'")->row()->xxx;
            if ($t_Chitha_Rmk_onbehalf > 0) {
                $this->db->query("Delete from t_Chitha_Rmk_onbehalf WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
            }
            $t_Chitha_Rmk_Ordbasic = $this->db->query("select count(*) as xxx from t_Chitha_Rmk_Ordbasic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'")->row()->xxx;
            if ($t_Chitha_Rmk_Ordbasic > 0) {
                $this->db->query("Delete from t_Chitha_Rmk_Ordbasic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
            }
            $t_Chitha_Rmk_other_opp_party = $this->db->query("select count(*) as xxx from t_Chitha_Rmk_other_opp_party WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'")->row()->xxx;
            if ($t_Chitha_Rmk_other_opp_party > 0) {
                $this->db->query("Delete from t_Chitha_Rmk_other_opp_party WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
            }
            $t_reclassification = $this->db->query("select count(*) as xxx from t_reclassification WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'")->row()->xxx;
            if ($t_reclassification > 0) {
                $this->db->query("Delete from t_reclassification WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
            }
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo "Error Occured";
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', "Junk Data Deleted Successfully...");
            redirect(base_url() . "index.php/Utility/districtDetails ");
        }
    }

    public function districtselect() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $this->session->set_userdata(array('pattadar' => array()));
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
        //var_dump($district);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/utility/select_location_1', $district);
        // $this->load->view('../views/footer');
        $district['_view'] = 'utility/select_location_1';
        $this->load->view('layouts/main',$district);
    }


    public function delete_dags_info() {
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('circle_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');
        $mouza_pargona_code = $this->input->post('mouza_code');

        $locationData['loc'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'lot_no' => $lot_no,
            'vill_code' => $vill_code,
            'mouza_pargona_code' => $mouza_pargona_code
        );
        $this->session->set_userdata($locationData);

        $this->load->model('misreport/MisModel');

        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lotdata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);
        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata);

        $query1 = $this->db->query("select dag_no,dag_no_int from Chitha_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and "
            . " vill_townprt_code='$vill_code' and lot_no='$lot_no' order by dag_no_int");
        $all_cases['dags'] = $query1->result();

        $main = array_merge($maindata, $locationData, $all_cases);

        //var_dump($main);

        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/utility/delete_dags_info', $main);
        // $this->load->view('../views/footer');
        $main['_view'] = 'utility/delete_dags_info';
        $this->load->view('layouts/main',$main);
    }

//     public function chithadeletion() {
//         $this->db->trans_begin();
//         //var_dump($this->input->post());

//         $dist_code = $this->input->post('Dist_code');
//         $subdiv_code = $this->input->post('Subdiv_code');
//         $cir_code = $this->input->post('Cir_code');
//         $mouza_pargona_code = $this->input->post('Mouza_Pargona_code');
//         $lot_no = $this->input->post('lot_no');
//         $village_code = $this->input->post('Vill_townprt_code');
//         $Dagno_int = $this->input->post('Dagno_int');

//         $get_dag_no = "select dag_no as dag_no, patta_no as patta_no, patta_type_code as patta_type_code from chitha_basic where dist_code='$dist_code' "
//             . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//             . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no_int = '$Dagno_int'";

//         $get_dag_no = $this->db->query($get_dag_no)->row();
//         $dag_no = $get_dag_no->dag_no;
//         $patta_no = $get_dag_no->patta_no;
//         $patta_type_code = $get_dag_no->patta_type_code;

//         $chitha_basic = $this->input->post('chitha_basic');
//         $chitha_pattadar = $this->input->post('chitha_pattadar');
//         $chitha_occupant = $this->input->post('chitha_occupant');
//         $chitha_Tenant = $this->input->post('chitha_Tenant');
//         $chitha_subtenant = $this->input->post('chitha_subtenant');
//         $chitha_Mcrop = $this->input->post('chitha_Mcrop');
//         $chitha_Noncrop = $this->input->post('chitha_Noncrop');
//         $chitha_fruit = $this->input->post('chitha_fruit');
//         $lm_note = $this->input->post('lm_note');
//         $sk_note = $this->input->post('sk_note');
//         $encroacher = $this->input->post('encroacher');
//         $direct_paying = $this->input->post('direct_paying');
//         $conversion = $this->input->post('conversion');
//         $Allotment = $this->input->post('Allotment');
//         $Mutation = $this->input->post('Mutation');
//         $Partition = $this->input->post('Partition');
//         $others = $this->input->post('others');

//         $get_checklist_for_field_cases = $this->CoofficeConversionModel->get_checklist_for_field_cases($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $village_code, $dag_no);
//         $mssg1 = $get_checklist_for_field_cases;
//         $get_checklist_for_office_cases = $this->CoofficeConversionModel->get_checklist_for_office_cases($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $village_code, $dag_no);
//         $mssg2 = $get_checklist_for_office_cases;
//         $get_checklist_for_reclassification_cases = $this->CoofficeConversionModel->get_checklist_for_reclassification_cases($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $village_code, $dag_no, $Dagno_int);
//         $mssg3 = $get_checklist_for_reclassification_cases;


//         // Resetting Flags in Chitha_basic selected for Proper Jamabandi Updating .... will be used in most places.
//         $jamabandi_update = "update Chitha_basic set operation='M', jama_yn='n' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//             . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'";

//         if (($get_checklist_for_field_cases == '') && ($get_checklist_for_office_cases == '') && ($get_checklist_for_reclassification_cases == '')) {
//             if ($chitha_basic == '1') {
//                 $this->db->query("delete FROM t_Chitha_col8_inplace WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM t_Chitha_col8_Occup WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM t_Chitha_col8_Order WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM t_Chitha_Rmk_allottee WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM t_Chitha_Rmk_alongwith WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM t_Chitha_Rmk_convorder WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM t_Chitha_Rmk_infavor_of WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM t_Chitha_Rmk_inplace_of WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM t_Chitha_Rmk_onbehalf WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM t_Chitha_Rmk_Ordbasic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM t_Chitha_Rmk_other_opp_party WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM Chitha_col8_inplace WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM Chitha_col8_Occup WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM Chitha_col8_Order WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM Chitha_Dag_Pattadar WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM Chitha_Fruit WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM Chitha_MCrop WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM chitha_noncrop WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM Chitha_Rmk_allottee WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM Chitha_Rmk_alongwith WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM Chitha_Rmk_convorder WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM Chitha_Rmk_encro WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM Chitha_Rmk_gen WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM Chitha_Rmk_infavor_of WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM Chitha_Rmk_inplace_of WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM Chitha_rmk_lmnote WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM Chitha_Rmk_onbehalf WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM Chitha_Rmk_Ordbasic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM Chitha_Rmk_other_opp_party WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM Chitha_rmk_sknote WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM Chitha_Subtenant WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM Chitha_Tenant WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM Field_Mut_pattadar WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM Field_Part_petitioner WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM petition_pattadar WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM Petition_lm_note WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM petitioner_part WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM Field_Mut_dag_details WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM APt_Chitha_Rmk_Ordbasic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM APt_Chitha_Rmk_other WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM APCancel_petition_pattadar WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM APCancel_dag_details WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
// //                $this->db->query("delete FROM dag_details WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
// //                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 $this->db->query("delete FROM Chitha_Basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");

//                 // Check if same Patta no. & Patta Type exists (with different Dags)
//                 $check_if_exists = "select count(*) as c from Chitha_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and TRIM(patta_no)='$patta_no' and Patta_type_code='$patta_type_code'";
//                 $check_if_exists = $this->db->query($check_if_exists)->row()->c;

//                 If ($check_if_exists == 0) { // No such Patta no. & Patta Type! So delete it from Jamabandi
//                     $this->db->query("delete FROM jama_remark WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and TRIM(patta_no)='$patta_no' and Patta_type_code='$patta_type_code'");
//                     $this->db->query("delete FROM jama_pattadar WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and TRIM(patta_no)='$patta_no' and Patta_type_code='$patta_type_code'");
//                     $this->db->query("delete FROM jama_patta WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and TRIM(patta_no)='$patta_no' and Patta_type_code='$patta_type_code'");
//                     $this->db->query("delete FROM jama_dag WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no' and TRIM(patta_no)='$patta_no' and Patta_type_code='$patta_type_code'");
//                 } else {
//                     $this->db->query("update Chitha_basic set operation='M', jama_yn='n' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and "
//                         . "TRIM(patta_no)='$patta_no' and Patta_type_code='$patta_type_code'");
//                 }
//             } else {
//                 if ($chitha_pattadar == '1') {
//                     $this->db->query("delete from Chitha_dag_Pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and "
//                         . "TRIM(patta_no)='$patta_no' and Patta_type_code='$patta_type_code'");

//                     // delete from jama_pattadar
//                     $this->db->query("delete from jama_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and "
//                         . "TRIM(patta_no)='$patta_no' and Patta_type_code='$patta_type_code'");

//                     // This is part of col 8 rmk, so reset Chitha_basic flags for proper Jamabandi updating
//                     $this->db->query($jamabandi_update);
//                 }
//                 if ($chitha_occupant == '1') {
//                     $this->db->query("delete FROM Chitha_Col8_inplace WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");

//                     $this->db->query("delete FROM Chitha_Col8_Order WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");

//                     $this->db->query("delete FROM Chitha_Col8_Occup WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");

//                     // This is part of col 8 rmk, so reset Chitha_basic flags for proper Jamabandi updating
//                     $this->db->query($jamabandi_update);
//                 }
//                 if ($chitha_Tenant == '1') {
//                     // Not linked with Jamabandi
//                     $this->db->query("delete FROM Chitha_tenant WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 }
//                 if ($chitha_subtenant == '1') {
//                     // Not linked with Jamabandi
//                     $this->db->query("delete FROM Chitha_subtenant WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 }
//                 if ($chitha_Mcrop == '1') {
//                     // Not linked with Jamabandi
//                     $this->db->query("delete FROM Chitha_Mcrop WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 }
//                 if ($chitha_Noncrop == '1') {
//                     // Not linked with Jamabandi
//                     $this->db->query("delete FROM Chitha_Noncrop WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 }
//                 if ($chitha_fruit == '1') {
//                     // Not linked with Jamabandi
//                     $this->db->query("delete FROM Chitha_Fruit WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                 }
//                 if ($lm_note == '1') {
//                     $lm_note = "SELECT * FROM Chitha_rmk_lmnote WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'";
//                     $lm_note = $this->db->query($lm_note)->result();
//                     foreach ($lm_note as $note) {
//                         $this->db->query("Delete from chitha_rmk_gen where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                             . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'"
//                             . " and rmk_type_hist_no = '$note->rmk_type_hist_no'");
//                     }
//                     $this->db->query("delete FROM Chitha_rmk_lmnote WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                     // This is part of col 31 rmk, so reset Chitha_basic flags for proper Jamabandi updating
//                     $this->db->query($jamabandi_update);
//                 }
//                 if ($sk_note == '1') {
//                     $sk_note = "SELECT * FROM Chitha_rmk_sknote WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'";
//                     $sk_note = $this->db->query($sk_note)->result();
//                     foreach ($sk_note as $note) {
//                         $this->db->query("Delete from chitha_rmk_gen where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                             . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'"
//                             . " and rmk_type_hist_no = '$note->rmk_type_hist_no'");
//                     }
//                     $this->db->query("delete FROM Chitha_rmk_sknote WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                     // This is part of col 31 rmk, so reset Chitha_basic flags for proper Jamabandi updating
//                     $this->db->query($jamabandi_update);
//                 }
//                 if ($encroacher == '1') {
//                     $encrocher = "SELECT * FROM Chitha_rmk_encro WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'";
//                     $encrocher = $this->db->query($encrocher)->result();
//                     foreach ($encrocher as $note) {
//                         $this->db->query("Delete from chitha_rmk_gen where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                             . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'"
//                             . " and rmk_type_hist_no = '$note->rmk_type_hist_no'");
//                     }
//                     $this->db->query("delete FROM Chitha_rmk_encro WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                     // This is part of col 31 rmk, so reset Chitha_basic flags for proper Jamabandi updating
//                     $this->db->query($jamabandi_update);
//                 }
//                 if ($direct_paying == '1') {
//                     $this->db->query("delete FROM Chitha_rmk_gen WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no' and rmk_type_code = '05'");
//                     // This is part of col 31 rmk, so reset Chitha_basic flags for proper Jamabandi updating
//                     $this->db->query($jamabandi_update);
//                 }
//                 if ($conversion == '1') {
//                     $conversion = "SELECT * FROM Chitha_Rmk_Ordbasic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no' and Ord_type_code = '01'";
//                     $conversion = $this->db->query($conversion)->result();
//                     foreach ($conversion as $result) {
//                         $this->db->query("delete FROM Chitha_Rmk_convorder WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                             . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no' and rmk_type_hist_no = '$result->rmk_type_hist_no'");
//                         $this->db->query("delete FROM Chitha_Rmk_gen WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                             . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no' and rmk_type_hist_no = '$result->rmk_type_hist_no'");
//                     }
//                     $this->db->query("delete FROM Chitha_Rmk_Ordbasic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                     // This is part of col 31 rmk, so reset Chitha_basic flags for proper Jamabandi updating
//                     $this->db->query($jamabandi_update);
//                 }
//                 if ($Allotment == '1') {
//                     $allotment = "SELECT * FROM Chitha_Rmk_Ordbasic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no' and Ord_type_code = '02'";
//                     $allotment = $this->db->query($allotment)->result();
//                     foreach ($allotment as $result) {
//                         $this->db->query("delete FROM Chitha_Rmk_allottee WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                             . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no' and rmk_type_hist_no = '$result->rmk_type_hist_no'");
//                         $this->db->query("delete FROM Chitha_Rmk_gen WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                             . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no' and rmk_type_hist_no = '$result->rmk_type_hist_no'");
//                     }
//                     $this->db->query("delete FROM Chitha_Rmk_Ordbasic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                     // This is part of col 31 rmk, so reset Chitha_basic flags for proper Jamabandi updating
//                     $this->db->query($jamabandi_update);
//                 }
//                 if ($Mutation == '1') {
//                     $mutation = "SELECT * FROM Chitha_Rmk_Ordbasic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no' and Ord_type_code = '03'";
//                     $mutation = $this->db->query($mutation)->result();
//                     foreach ($mutation as $result) {
//                         $this->db->query("delete FROM Chitha_Rmk_infavor_of WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                             . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no' and rmk_type_hist_no = '$result->rmk_type_hist_no'");
//                         $this->db->query("delete FROM Chitha_Rmk_inplace_of WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                             . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no' and rmk_type_hist_no = '$result->rmk_type_hist_no'");
//                         $this->db->query("delete FROM Chitha_Rmk_onbehalf WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                             . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no' and rmk_type_hist_no = '$result->rmk_type_hist_no'");
//                         $this->db->query("delete FROM Chitha_Rmk_alongwith WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                             . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no' and rmk_type_hist_no = '$result->rmk_type_hist_no'");
//                         $this->db->query("delete FROM Chitha_Rmk_gen WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                             . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no' and rmk_type_hist_no = '$result->rmk_type_hist_no'");
//                     }
//                     $this->db->query("delete FROM Chitha_Rmk_Ordbasic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                     // This is part of col 31 rmk, so reset Chitha_basic flags for proper Jamabandi updating
//                     $this->db->query($jamabandi_update);
//                 }
//                 if ($Partition == '1') {
//                     $partition = "SELECT * FROM Chitha_Rmk_Ordbasic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no' and Ord_type_code = '04'";
//                     $partition = $this->db->query($partition)->result();
//                     foreach ($partition as $result) {
//                         $this->db->query("delete FROM Chitha_Rmk_infavor_of WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                             . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no' and rmk_type_hist_no = '$result->rmk_type_hist_no'");
//                         $this->db->query("delete FROM Chitha_Rmk_gen WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                             . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no' and rmk_type_hist_no = '$result->rmk_type_hist_no'");
//                     }
//                     $this->db->query("delete FROM Chitha_Rmk_Ordbasic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                     // This is part of col 31 rmk, so reset Chitha_basic flags for proper Jamabandi updating
//                     $this->db->query($jamabandi_update);
//                 }
//                 if ($others == '1') {
//                     $othrs = "SELECT * FROM Chitha_Rmk_Ordbasic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no' and Ord_type_code = '05'";
//                     $othrs = $this->db->query($othrs)->result();
//                     foreach ($othrs as $result) {
//                         $this->db->query("delete FROM Chitha_Rmk_other_opp_party WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                             . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no' and rmk_type_hist_no = '$result->rmk_type_hist_no'");
//                         $this->db->query("delete FROM Chitha_Rmk_gen WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                             . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no' and rmk_type_hist_no = '$result->rmk_type_hist_no'");
//                     }
//                     $this->db->query("delete FROM Chitha_Rmk_Ordbasic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
//                         . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag_no'");
//                     // This is part of col 31 rmk, so reset Chitha_basic flags for proper Jamabandi updating
//                     $this->db->query($jamabandi_update);
//                 }
//             }
//         }
//         $message['msg'] = array(
//             'dag_no' => $dag_no,
//             'patta_no' => trim($patta_no),
//             'dist_code' => $dist_code,
//             'subdiv_code' => $subdiv_code,
//             'cir_code' => $cir_code,
//             'mouza_pargona_code' => $mouza_pargona_code,
//             'lot_no' => $lot_no,
//             'vill_code' => $village_code,
//             'status' => $mssg1 . "" . $mssg2 . "" . $mssg3,
//         );
//         if ($this->db->trans_status() === FALSE) {
//             $this->db->trans_rollback();
//             echo "Error Occured";
//         } else {
//             $this->db->trans_commit();
//             // $this->load->helper('html');
//             // $this->load->view('../views/header');
//             // $this->load->view('../views/utility/chithadeletion', $message);
//             // $this->load->view('../views/footer');
//             $message['_view'] = 'utility/chithadeletion';
//             $this->load->view('layouts/main',$message);
//         }
//     }

    public function districtDetails_junk() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $this->session->set_userdata(array('pattadar' => array()));
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
        //var_dump($district);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/utility/select_location_2', $district);
        // $this->load->view('../views/footer');
        $district['_view'] = 'utility/select_location_2';
        $this->load->view('layouts/main',$district);
    }

    public function delete_patta_info() {
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('circle_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');
        $mouza_pargona_code = $this->input->post('mouza_code');


        $locationData['loc'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'lot_no' => $lot_no,
            'vill_code' => $vill_code,
            'mouza_pargona_code' => $mouza_pargona_code
        );
        $this->session->set_userdata($locationData);

        $this->load->model('misreport/MisModel');

        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lotdata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);
        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata);

        $query1 = $this->db->query("Select distinct(patta_no) as patta_no from jama_patta where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
            . "and vill_townprt_code='$vill_code' and lot_no='$lot_no' and TRIM(patta_no)!='' and TRIM(patta_no)!='.' order by patta_no asc");
        $all_cases['patta'] = $query1->result();

        $main = array_merge($maindata, $locationData, $all_cases);

        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/utility/delete_patta_info', $main);
        // $this->load->view('../views/footer');
        $main['_view'] = 'utility/delete_patta_info';
        $this->load->view('layouts/main',$main);
    }

    public function jamabandideletion() {
        //var_dump($this->input->post());
        $dist_code = $this->input->post('Dist_code');
        $subdiv_code = $this->input->post('Subdiv_code');
        $cir_code = $this->input->post('Cir_code');
        $mouza_pargona_code = $this->input->post('Mouza_Pargona_code');
        $lot_no = $this->input->post('lot_no');
        $village_code = $this->input->post('Vill_townprt_code');
        $patta_no = trim($this->input->post('patta_no'));

        $get_the_patta_type = "select distinct(patta_type_code) as patta_type_code, patta_no as patta_no from jama_patta where dist_code='$dist_code' and subdiv_code='$subdiv_code' "
            . "and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and TRIM(patta_no) = '$patta_no'";
        $get_the_patta_type = $this->db->query($get_the_patta_type)->result();

        foreach ($get_the_patta_type as $patta_type) {
            $get_dag_no = "select dag_no as dag_no from chitha_basic where dist_code='$dist_code' "
                . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and TRIM(patta_no) = '$patta_no' and patta_type_code='$patta_type->patta_type_code'";
            //echo $get_dag_no;
            $get_dag_no = $this->db->query($get_dag_no)->result();

            $data[] = array(
                'patta_no' => trim($patta_type->patta_no),
                'patta_type_code' => $patta_type->patta_type_code,
                //'patta_name' => $get_patta_name,
                'dag_no' => $get_dag_no,
            );
        }
        $message['details'] = $data;
        //var_dump($message);
        $message['msg'] = array(
            'patta_no' => $patta_no,
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_code' => $village_code,
            'status' => "",
        );
        //var_dump($message);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/utility/Showjamabandideletion', $message);
        // $this->load->view('../views/footer');
        $message['_view'] = 'utility/Showjamabandideletion';
        $this->load->view('layouts/main',$message);
    }

    // public function one_buy_dag_no_delete() {
    //     $this->db->trans_begin();
    //     //var_dump($this->input->post());
    //     $dist_code = $this->input->get('dist_code');
    //     $subdiv_code = $this->input->get('subdiv_code');
    //     $cir_code = $this->input->get('cir_code');
    //     $mouza_pargona_code = $this->input->get('mouza_pargona_code');
    //     $lot_no = $this->input->get('lot_no');
    //     $village_code = $this->input->get('village');
    //     $patta_no = trim($this->input->get('patta_no'));
    //     $patta_type = $this->input->get('patta_type');

    //     $get_dag_no = "select patta_no as patta_no, patta_type_code as patta_type_code from jama_patta where dist_code='$dist_code' "
    //         . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and "
    //         . "vill_townprt_code='$village_code' and TRIM(patta_no) = '$patta_no' and patta_type_code = '$patta_type' ";
    //     $get_dag_no = $this->db->query($get_dag_no)->result();
    //     //echo count($get_dag_no);
    //     if (count($get_dag_no) > 0) {
    //         foreach ($get_dag_no as $dag) {
    //             $this->db->query("delete FROM t_Chitha_col8_inplace WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM t_Chitha_col8_Occup WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM t_Chitha_col8_Order WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM t_Chitha_Rmk_allottee WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM t_Chitha_Rmk_alongwith WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM t_Chitha_Rmk_convorder WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM t_Chitha_Rmk_infavor_of WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM t_Chitha_Rmk_inplace_of WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM t_Chitha_Rmk_onbehalf WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM t_Chitha_Rmk_Ordbasic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM t_Chitha_Rmk_other_opp_party WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");

    //             $this->db->query("delete FROM t_reclassification WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");

    //             $this->db->query("delete FROM Chitha_col8_inplace WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM Chitha_col8_Occup WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM Chitha_col8_Order WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM Chitha_Dag_Pattadar WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM Chitha_Fruit WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM Chitha_MCrop WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM Chitha_Rmk_allottee WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM Chitha_Rmk_alongwith WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM Chitha_Rmk_convorder WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM Chitha_Rmk_encro WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM Chitha_Rmk_gen WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM Chitha_Rmk_infavor_of WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM Chitha_Rmk_inplace_of WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM Chitha_rmk_lmnote WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM Chitha_Rmk_onbehalf WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM Chitha_Rmk_Ordbasic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM Chitha_Rmk_other_opp_party WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM Chitha_rmk_sknote WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM Chitha_Subtenant WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM Chitha_Tenant WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM Field_Mut_pattadar WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM Field_Part_petitioner WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM petition_pattadar WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM Petition_lm_note WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM petitioner_part WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM Field_Mut_dag_details WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM APt_Chitha_Rmk_Ordbasic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM APt_Chitha_Rmk_other WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM APCancel_petition_pattadar WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM APCancel_dag_details WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             //          $this->db->query("delete FROM dag_details WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //             //                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM Chitha_Basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no'");
    //             $this->db->query("delete FROM jama_dag WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and dag_no = '$dag->dag_no' and TRIM(patta_no)=trim('$dag->patta_no') and Patta_type_code='$dag->patta_type_code'");

    //             $strsql="select patta_no from Chitha_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                 . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and TRIM(patta_no)=trim('$dag->patta_no') and Patta_type_code='$dag->patta_type_code'";
    //             $strsql=$this->db->query($strsql)->result();
    //             if(count($strsql)==0)
    //             {
    //                 $this->db->query("delete FROM jama_remark WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and TRIM(patta_no)=trim('$dag->patta_no') and Patta_type_code='$dag->patta_type_code'");
    //                 $this->db->query("delete FROM jama_pattadar WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and TRIM(patta_no)=trim('$dag->patta_no') and Patta_type_code='$dag->patta_type_code'");
    //                 $this->db->query("delete FROM jama_patta WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
    //                     . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$village_code' and TRIM(patta_no)=trim('$dag->patta_no') and Patta_type_code='$dag->patta_type_code'");

    //             }
    //         }
    //     }

    //     $message['msg'] = array(
    //         'patta_no' => $patta_no,
    //         'dist_code' => $dist_code,
    //         'subdiv_code' => $subdiv_code,
    //         'cir_code' => $cir_code,
    //         'mouza_pargona_code' => $mouza_pargona_code,
    //         'lot_no' => $lot_no,
    //         'vill_code' => $village_code,
    //         'status' => "",
    //     );
    //     if ($this->db->trans_status() === FALSE) {
    //         $this->db->trans_rollback();
    //         echo "Error Occured";
    //     } else {
    //         $this->db->trans_commit();
    //         // $this->load->helper('html');
    //         // $this->load->view('../views/header');
    //         // $this->load->view('../views/utility/PattaDeleteConfirm', $message);
    //         // $this->load->view('../views/footer');
    //         $message['_view'] = 'utility/PattaDeleteConfirm';
    //         $this->load->view('layouts/main',$message);
    //     }
    // }

    public function delete_half_donecase_o() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/utility/delete_half_donecase_o');
        // $this->load->view('../views/footer');
        $message['_view'] = 'utility/delete_half_donecase_o';
        $this->load->view('layouts/main',$message);
    }

    public function delete_half_done() {
        $message['case'] = $this->input->post('case_no');
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/utility/half_done_delete_report', $case_no);
        // $this->load->view('../views/footer');
        $message['_view'] = 'utility/half_done_delete_report';
        $this->load->view('layouts/main',$message);
//        select * from Petition_Basic where dist_code='" & Session("Dist_code") & "' and subdiv_code = '" & Session("Subdiv_code") & "' and cir_code = '" & Session("cir_code") & "' and mouza_pargona_code = '" & Session("mouza_pargona_code") & "' and lot_no = '" & Session("lot_no") & "' and vill_townprt_code = '" & Session("vill_townprt_code") & _
//'	    "' and case_no='" & case_no & "'"
//                
//                select * from Petition_Basic where case_no='" & case_no 
    }

    public function deletecase() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/utility/deletecase');
        // $this->load->view('../views/footer');
        $message['_view'] = 'utility/deletecase';
        $this->load->view('layouts/main',$message);
    }

    public function DeleteCaseFM_OM() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $case_no = $this->input->post('txtcaseno');
        $year = $this->input->post('txtyear');
        $type = $this->input->post('cmbcasetype');
        //var_dump($this->input->POST());
        // 2 is for Field Mutation/Partition and 3 is for Office Mutation/Partition
        if ($type == 2) {
            $fmutebasic = "select * from Field_Mut_Basic where case_no='$case_no' and year_no='$year' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
            $fieldbasic = $this->db->query($fmutebasic)->row();
            $all_cases = count($fieldbasic);
            if ($all_cases > 0) {
                $mrepdate = $fieldbasic->report_date;
                if ($fieldbasic->sk_flag == "Y") {
                    $mbysk = "Yes";
                } else {
                    $mbysk = "No";
                }
                if ($fieldbasic->order_passed == "Y") {
                    $mbyco = "Yes";
                    $mremarks = "Order Passed by Circle Officer. First Delete The Order FromCol8.";
                    $FLAG = 2;
                } else {
                    $mbyco = "No";
                    $mremarks = "Can Be Deleted";
                    $FLAG = 1;
                }
            } else {
                $this->session->set_flashdata('message', "All Input Data of Case No # $case_no for Field Mutation didn't match..");
                redirect(base_url() . "index.php/utility/deletecase");
            }
        } else {
            $petitionbasic = "select * from petition_Basic where case_no='$case_no' and year_no='$year' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
            $officebasic = $this->db->query($petitionbasic)->row();
            $all_cases = count($officebasic);
            if ($all_cases > 0) {
                $mrepdate = $officebasic->submission_date;
                if ($officebasic->sk_comment == "Y")
                    $mbysk = "Yes";
                else
                    $mbysk = "No";
                if ($officebasic->order_passed == "Y") {
                    $mbyco = "Yes";
                    $mremarks = "Order Passed by CircleOfficer. First Delete The Order FromCol31.";
                    $FLAG = 2;
                } else {
                    $mbyco = "No";
                    $mremarks = "Can Be Deleted";
                    $FLAG = 1;
                }
            } else {
                $this->session->set_flashdata('message', "All Input Data of Case No # $case_no for Office Mutation didn't match..");
                redirect(base_url() . "index.php/utility/deletecase");
            }
        }

        $data['results'] = array(
            'date' => date('d-m-Y', strtotime($mrepdate)),
            'sk_report' => $mbysk,
            'co_report' => $mbyco,
            'remark' => $mremarks,
            'flag' => $FLAG,
            'case_no' => $case_no,
            'year' => $year,
            'type' => $type
        );
        //var_dump($data);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/utility/deletecase1', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'utility/deletecase1';
        $this->load->view('layouts/main',$data);
    }

    public function DeleteCaseFM_OM_save() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $case_no = $this->input->post('case_no');
        $year = $this->input->post('year');
        $type = $this->input->post('type');
        //var_dump($this->input->POST());
        // 2 is for Field Mutation/Partition and 3 is for Office Mutation/Partition
        if ($type == 2) {//field mutation
            $query1 = $this->db->query("select * from Field_Mut_Basic where case_no='$case_no' and year_no='$year' and "
                . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and order_passed is NULL");
            $all_cases = $query1->result();
            //echo count($all_cases);
            //exit();
            if (count($all_cases) > 0) {
                $query1 = $this->db->query("delete from Field_Mut_Petitioner where case_no='$case_no' and year_no='$year' and dist_code='$dist_code' "
                    . "and subdiv_code='$subdiv_code' and cir_code='$cir_code'");
                $query2 = $this->db->query("delete from Field_Mut_Pattadar where case_no='$case_no' and year_no='$year' and dist_code='$dist_code' "
                    . "and subdiv_code='$subdiv_code' and cir_code='$cir_code'");
                $query3 = $this->db->query("delete from Field_Mut_Dag_Details where case_no='$case_no' and year_no='$year' and dist_code='$dist_code' "
                    . "and subdiv_code='$subdiv_code' and cir_code='$cir_code'");
                $query4 = $this->db->query("delete from Field_Part_Petitioner where case_no='$case_no' and year_no='$year' and dist_code='$dist_code' "
                    . "and subdiv_code='$subdiv_code' and cir_code='$cir_code'");
                $query5 = $this->db->query("delete from Field_Mut_Dag_Details where case_no='$case_no' and year_no='$year' and dist_code='$dist_code' "
                    . "and subdiv_code='$subdiv_code' and cir_code='$cir_code'");
                $query6 = $this->db->query("delete from Field_Mut_Basic where case_no='$case_no' and year_no='$year' and dist_code='$dist_code' "
                    . "and subdiv_code='$subdiv_code' and cir_code='$cir_code'");
                $this->session->set_flashdata('message', "Case No # $case_no for Field Mutation Deleted Successfully..");
            } else {
                $this->session->set_flashdata('message', "Case No # $case_no for Field Mutation Cannot be Found..");
            }
        } else {
            $query1 = $this->db->query("select * from petition_Basic where case_no='$case_no' and year_no='$year' and "
                . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and order_passed is NULL");
            $all_cases = $query1->result();
            //echo count($all_cases);
            if (count($all_cases) > 0) {
                foreach ($all_cases as $all_c) {
                    $query1 = $this->db->query("delete from Petition_byayprak where "
                        . "dist_code='$all_c->dist_code' and subdiv_code='$all_c->subdiv_code' and cir_code='$all_c->cir_code' and "
                        . "mouza_Pargona_code = '$all_c->mouza_pargona_code' and lot_no='$all_c->lot_no' and vill_townprt_code='$all_c->vill_townprt_code' and "
                        . "year_no='$all_c->year_no' and petition_no='$all_c->petition_no'");

                    $query2 = $this->db->query("delete from Petition_notified where "
                        . "dist_code='$all_c->dist_code' and subdiv_code='$all_c->subdiv_code' and cir_code='$all_c->cir_code' and "
                        . "mouza_Pargona_code = '$all_c->mouza_pargona_code' and lot_no='$all_c->lot_no' and vill_townprt_code='$all_c->vill_townprt_code' and "
                        . "year_no='$all_c->year_no' and petition_no='$all_c->petition_no'");

                    $query3 = $this->db->query("delete from Petition_lm_note where "
                        . "dist_code='$all_c->dist_code' and subdiv_code='$all_c->subdiv_code' and cir_code='$all_c->cir_code' and "
                        . "mouza_Pargona_code = '$all_c->mouza_pargona_code' and lot_no='$all_c->lot_no' and vill_townprt_code='$all_c->vill_townprt_code' and "
                        . "year_no='$all_c->year_no' and petition_no='$all_c->petition_no'");

                    $query4 = $this->db->query("delete from petition_pattadar where "
                        . "dist_code='$all_c->dist_code' and subdiv_code='$all_c->subdiv_code' and cir_code='$all_c->cir_code' and "
                        . "mouza_Pargona_code = '$all_c->mouza_pargona_code' and lot_no='$all_c->lot_no' and vill_townprt_code='$all_c->vill_townprt_code' and "
                        . "year_no='$all_c->year_no' and petition_no='$all_c->petition_no'");

                    $query5 = $this->db->query("delete from petitioner_part where "
                        . "dist_code='$all_c->dist_code' and subdiv_code='$all_c->subdiv_code' and cir_code='$all_c->cir_code' and "
                        . "mouza_Pargona_code = '$all_c->mouza_pargona_code' and lot_no='$all_c->lot_no' and vill_townprt_code='$all_c->vill_townprt_code' and "
                        . "year_no='$all_c->year_no' and petition_no='$all_c->petition_no'");

                    $query6 = $this->db->query("delete from petitioner where "
                        . "dist_code='$all_c->dist_code' and subdiv_code='$all_c->subdiv_code' and cir_code='$all_c->cir_code' and "
                        . "mouza_Pargona_code = '$all_c->mouza_pargona_code' and lot_no='$all_c->lot_no' and vill_townprt_code='$all_c->vill_townprt_code' and "
                        . "year_no='$all_c->year_no' and petition_no='$all_c->petition_no'");

                    $query7 = $this->db->query("delete from Petition_proceeding where case_no='$case_no'");
                }
                $query8 = $this->db->query("delete from petition_Basic where case_no='$case_no' and year_no='$year' and "
                    . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'");
                $this->session->set_flashdata('message', "Case No # $case_no for Office Mutation Deleted Successfully..");
            } else {
                $this->session->set_flashdata('message', "Case No # $case_no for Office Mutation Cannot be Found..");
            }
        }
        redirect(base_url() . "index.php/utility/deletecase");
    }

    public function deletecaseAllField() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $query1 = $this->db->query("select * from Field_Mut_Basic where dist_code='$dist_code' "
            . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and order_passed is NULL order by petition_no");
        $data['fmute'] = $query1->result();
        //var_dump($data);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/utility/deletecaseAllField', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'utility/deletecaseAllField';
        $this->load->view('layouts/main',$data);
    }

    public function DeleteCaseFM() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_code = $this->input->get('village');
        $case_no = $this->input->get('CaseNo');

//        echo "select * from Field_Mut_Basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
//                . "and mouza_Pargona_code = '$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'";
        // $query1 = $this->db->query("delete from Field_Mut_Petitioner where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
        // . "and mouza_Pargona_code = '$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'");
        // $query2 = $this->db->query("delete from Field_Mut_Pattadar where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
        // . "and mouza_Pargona_code = '$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'");
        // $query3 = $this->db->query("delete from Field_Mut_Dag_Details where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
        // . "and mouza_Pargona_code = '$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'");
        // $query4 = $this->db->query("delete from Field_Part_Petitioner where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
        // . "and mouza_Pargona_code = '$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'");
        // $query5 = $this->db->query("delete from Field_Mut_Dag_Details where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
        // . "and mouza_Pargona_code = '$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'");
        $date = date('Y-m-d');
        $userdesg = $this->session->userdata('user_desig_code');
        $usercode = $this->session->userdata('user_code');
        $dispose_reason = "Case Deleted by-" . $user_desig_code . "(" . $usercode . ")";
        $query6 = $this->db->query("Update Field_Mut_Basic set is_dispose='y',if_dispose_date='$date',dispose_reason='$dispose_reason' where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
            . "and mouza_Pargona_code = '$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'");

        $this->session->set_flashdata('message', "Case No # $case_no for Field Mutation Deleted Successfully..");
        redirect(base_url() . "index.php/utility/deletecaseAllField");
    }

    public function deletecaseAllOffice() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $query1 = $this->db->query("select * from Petition_Basic where dist_code='$dist_code' and status!='D' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and order_passed is NULL order by petition_no");
        $data['Omute'] = $query1->result();

        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/utility/deletecaseAllOffice', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'utility/deletecaseAllOffice';
        $this->load->view('layouts/main',$data);
    }

    public function DeleteCaseOM() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_code = $this->input->get('village');
        $case_no = $this->input->get('CaseNo');

        $query1 = $this->db->query("select * from petition_Basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
            . "and mouza_Pargona_code = '$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'");
        $all_cases = $query1->result();
        //var_dump($all_cases);
        // foreach ($all_cases as $all_c) {
        // $query1 = $this->db->query("delete from Petition_byayprak where "
        // . "dist_code='$all_c->dist_code' and subdiv_code='$all_c->subdiv_code' and cir_code='$all_c->cir_code' and "
        // . "mouza_Pargona_code = '$all_c->mouza_pargona_code' and lot_no='$all_c->lot_no' and vill_townprt_code='$all_c->vill_townprt_code' and "
        // . "year_no='$all_c->year_no' and petition_no='$all_c->petition_no'");
        // $query2 = $this->db->query("delete from Petition_notified where "
        // . "dist_code='$all_c->dist_code' and subdiv_code='$all_c->subdiv_code' and cir_code='$all_c->cir_code' and "
        // . "mouza_Pargona_code = '$all_c->mouza_pargona_code' and lot_no='$all_c->lot_no' and vill_townprt_code='$all_c->vill_townprt_code' and "
        // . "year_no='$all_c->year_no' and petition_no='$all_c->petition_no'");
        // $query3 = $this->db->query("delete from Petition_lm_note where "
        // . "dist_code='$all_c->dist_code' and subdiv_code='$all_c->subdiv_code' and cir_code='$all_c->cir_code' and "
        // . "mouza_Pargona_code = '$all_c->mouza_pargona_code' and lot_no='$all_c->lot_no' and vill_townprt_code='$all_c->vill_townprt_code' and "
        // . "year_no='$all_c->year_no' and petition_no='$all_c->petition_no'");
        // $query4 = $this->db->query("delete from petition_pattadar where "
        // . "dist_code='$all_c->dist_code' and subdiv_code='$all_c->subdiv_code' and cir_code='$all_c->cir_code' and "
        // . "mouza_Pargona_code = '$all_c->mouza_pargona_code' and lot_no='$all_c->lot_no' and vill_townprt_code='$all_c->vill_townprt_code' and "
        // . "year_no='$all_c->year_no' and petition_no='$all_c->petition_no'");
        // $query5 = $this->db->query("delete from petitioner_part where "
        // . "dist_code='$all_c->dist_code' and subdiv_code='$all_c->subdiv_code' and cir_code='$all_c->cir_code' and "
        // . "mouza_Pargona_code = '$all_c->mouza_pargona_code' and lot_no='$all_c->lot_no' and vill_townprt_code='$all_c->vill_townprt_code' and "
        // . "year_no='$all_c->year_no' and petition_no='$all_c->petition_no'");
        // $query6 = $this->db->query("delete from petitioner where "
        // . "dist_code='$all_c->dist_code' and subdiv_code='$all_c->subdiv_code' and cir_code='$all_c->cir_code' and "
        // . "mouza_Pargona_code = '$all_c->mouza_pargona_code' and lot_no='$all_c->lot_no' and vill_townprt_code='$all_c->vill_townprt_code' and "
        // . "year_no='$all_c->year_no' and petition_no='$all_c->petition_no'");
        // $query7 = $this->db->query("delete from Petition_proceeding where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'");
        // }
        $date = date('Y-m-d');
        $query8 = $this->db->query("Update petition_Basic set status='D',date_of_order='$date' where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
            . "and mouza_Pargona_code = '$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'");

        $this->session->set_flashdata('message', "Case No # $case_no for Office Mutation Deleted Successfully..");
        redirect(base_url() . "index.php/utility/deletecaseAllOffice");
    }

    public function select_location_pattadar() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/utility/select_location_pattadar');
        // $this->load->view('../views/footer');
        $data['_view'] = 'utility/select_location_pattadar';
        $this->load->view('layouts/main',$data);
    }

    public function searchpattano() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        //$this->session->set_userdata(array('pattadar' => array()));
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
        // $this->load->view('../views/utility/searchpattano', $district);
        // $this->load->view('../views/footer');
        $data['_view'] = 'utility/searchpattano';
        $this->load->view('layouts/main',$data);
    }

    public function PattadarwithPNo() {
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('circle_code');
        $pdarname = $this->input->post('pdarname');
        $father = $this->input->post('father');

        $query1 = $this->db->query("SELECT dist_code,subdiv_code,cir_code,lot_No,mouza_pargona_code,vill_townprt_code,pdar_name,pdar_father,patta_no,patta_type_code,pdar_id from Jama_Pattadar where Dist_code='" . $dist_code . "' and Subdiv_code='" . $subdiv_code . "' and cir_code='" . $cir_code . "' and pdar_name like '%" . $pdarname . "%' and Pdar_father like '%" . $father . "%'  order by Mouza_Pargona_code,Lot_No,Vill_townprt_code,Patta_No,Patta_type_code");
        $all_cases = $query1->result();

        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);
        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata);
        //var_dump($all_cases);
        $data = array();
        foreach ($all_cases as $all_c) {
            $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $all_c->mouza_pargona_code, $all_c->lot_no, $all_c->vill_townprt_code);

            $sqlstr = "select * from Chitha_Dag_Pattadar where dist_code='$all_c->dist_code' and subdiv_code='$all_c->subdiv_code' and cir_code='$all_c->cir_code' and mouza_Pargona_code = '$all_c->mouza_pargona_code' and lot_no='$all_c->lot_no' and vill_townprt_code='$all_c->vill_townprt_code' and TRIM(patta_no)=trim('$all_c->patta_no') and patta_type_code='$all_c->patta_type_code' and pdar_id='$all_c->pdar_id'";
            $strikeout = $this->db->query($sqlstr)->row();
            //var_dump($all);
            $sqq = "select * from Jama_Dag where dist_code='$all_c->dist_code' and subdiv_code='$all_c->subdiv_code' and cir_code='$all_c->cir_code' and mouza_Pargona_code = '$all_c->mouza_pargona_code' and lot_no='$all_c->lot_no' and vill_townprt_code='$all_c->vill_townprt_code' and TRIM(patta_no)=trim('$all_c->patta_no') and patta_type_code='$all_c->patta_type_code'";
            $dag_details = $this->db->query($sqq)->row();

            $sqqpt = "select patta_type from patta_code where type_code='$all_c->patta_type_code'";
            $patta_type_name = $this->db->query($sqqpt)->row();
            //var_dump($dag_details);
            $data[] = array
            (
                'dist_code' => $all_c->dist_code,
                'subdiv_code' => $all_c->subdiv_code,
                'cir_code' => $all_c->cir_code,
                'mouza_pargona_code' => $all_c->mouza_pargona_code,
                'lot_no' => $all_c->lot_no,
                'vill_townprt_code' => $villagedata,
                'patta_no' => trim($all_c->patta_no),
                'patta_type' => $patta_type_name->patta_type,
                'pattadarno' => $strikeout->pdar_id,
                'pattadar_name' => $all_c->pdar_name,
                'pattadar_father' => $all_c->pdar_father,
                'strikeout' => $strikeout->p_flag,
                'dag_area' => "Area : ( " . $dag_details->dag_area_b . "-" . $dag_details->dag_area_k . "-" . $dag_details->dag_area_lc . " )",
                'dag_no' => $dag_details->dag_no,
            );
        }
        $Pattadarnamedata['pbyname'] = $data;
        //var_dump($Pattadarnamedata);
        $main = array_merge($maindata, $Pattadarnamedata);
        //'Column 1: Lot No Column 2 : Village/Town Column 3: Pattadar ID Column 4: Pattadar Name Column 5: Pattadar Fahters Name Column 6: Patta No & Type
        //echo "SELECT dist_code,subdiv_code,cir_code,Lot_No,Mouza_Pargona_code,Vill_townprt_code,Pdar_name,Pdar_father,Patta_No,Patta_type_code,pdar_id from Jama_Pattadar where Dist_code='" & request.Form("dist_code")&"' and Subdiv_code='" & request.Form("Subdiv_code") & "' and cir_code='" & request.Form("cir_code") & "' and pdar_name like '" & PPName & "' and Pdar_father like '" & PFName & "'  order by Mouza_Pargona_code,Lot_No,Vill_townprt_code,Patta_No,Patta_type_code";
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/utility/PattadarwithPNo', $main);
        // $this->load->view('../views/footer');
        $main['_view'] = 'utility/PattadarwithPNo';
        $this->load->view('layouts/main',$main);

    }

    public function select_locationGovtLand() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        //$this->session->set_userdata(array('pattadar' => array()));
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
        // $this->load->view('../views/utility/select_locationGovtLand', $district);
        // $this->load->view('../views/footer');
        $district['_view'] = 'utility/select_locationGovtLand';
        $this->load->view('layouts/main',$district);
    }

    public function selectGovtLand() {
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('circle_code');
        $lot_no = $this->input->post('lot_no');
        $Mouza_Pargona_code = $this->input->post('mouza_code');

        $query1 = $this->db->query("SELECT distinct(vill_townprt_code) from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
            . " mouza_pargona_code='$Mouza_Pargona_code' and cir_code='$cir_code' and lot_no='$lot_no' and TRIM(patta_no)='0' order by Vill_townprt_code");

        //echo $query1;
        $all_cases = $query1->result();

        foreach ($all_cases as $all_c) {
            $sql = "select * from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "mouza_pargona_code='$Mouza_Pargona_code' and cir_code='$cir_code' and lot_no='$lot_no' and vill_townprt_code ='$all_c->vill_townprt_code' and TRIM(patta_no)='0'";
            $patta_and_type = $this->db->query($sql)->result();
            // $sql;
            //var_dump($patta_and_type);
            $data = array();
            foreach ($patta_and_type as $all_p) {
                $sqll = "select * from chitha_rmk_lmnote where dist_code='$dist_code' and subdiv_code='$subdiv_code'"
                    . "and mouza_pargona_code='$Mouza_Pargona_code' and cir_code='$cir_code' and lot_no='$lot_no' and vill_townprt_code ='$all_c->vill_townprt_code' and dag_no='$all_p->dag_no'";
                $LM_note = $this->db->query($sql)->result();

                $data[] = array
                (
                    'lmdata' => $LM_note
                );
            }
            $Govnamedata = array(
                'village' => $all_c->vill_townprt_code,
                'lm_note' => $data,
            );
        }
        $Govdata['lm'] = $Govnamedata;

//        $lndscenario = $this->db->query("select DISTINCT landclass_code.land_type AS type_of_land, landclass_code.class_code AS code from landclass_code INNER JOIN chitha_basic on "
//                . "chitha_basic.land_class_code = landclass_code.class_code and chitha_basic.dist_code ='$dist_code' and "
//                . "chitha_basic.subdiv_code='$subdiv_code' and chitha_basic.cir_code='$circle_code' and chitha_basic.mouza_pargona_code='$mouza_code' "
//                . "and chitha_basic.lot_no='$lot_no' and chitha_basic.vill_townprt_code='$vill_code' order by landclass_code.land_type");
//        //return $lndscenario->result();
//        $land = $lndscenario->result();
//        $arrData["data"] = array();
//        foreach($land as $land_type)
//        {
//            //echo $land_type->type_of_land;
//            $lndscenariocount = $this->db->query("select count(dag_no) AS total_dag from chitha_basic where dist_code ='$dist_code' and "
//                    . "subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no = '$lot_no' and "
//                    . "vill_townprt_code = '$vill_code' and land_class_code = '$land_type->code' ");
//            $t_count = $lndscenariocount->row();
//            //var_dump($t_count);
//            array_push($arrData["data"], array(
//                    "label" => $land_type->type_of_land,
//                    "value" => $t_count->total_dag
//                        )
//                );
//        }
//        return $arrData["data"];
        //var_dump($Govdata);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/utility/selectGovtLand', $Govdata);
        // $this->load->view('../views/footer');
        $Govdata['_view'] = 'utility/selectGovtLand';
        $this->load->view('layouts/main',$Govdata);
    }

    public function AutoJamaDistrict() {

        $session = $this->session->userdata('username');
        if ($session == 'lm') {
            $this->load->view('menu/menu1');
        } elseif ($session == 'sk') {
            $this->load->view('menu/menu2');
        } elseif ($session == 'oc') {
            $this->load->view('menu/menu3');
        }
        $this->load->model('mutation/mutationmodel');
        $this->load->helper('html');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouzas = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
        $district['d'] = $dist_code;
        $district['s'] = $subdiv_code;
        $district['c'] = $cir_code;
        $district['mouzas'] = $mouzas;
        //////////var_dump($mouzas);
        $data = $this->mutationmodel->getDistricts();
        $district['names'] = $data;

        // $this->load->helper('html');
        // $this->load->view('header');
        // $this->load->view('Utility/AutoJamaDistrict', $district);
        // $this->load->view('footer');
        $district['_view'] = 'utility/AutoJamaDistrict';
        $this->load->view('layouts/main',$district);
    }

    public function generateDagChitha() {
        // $this->load->helper('html');
        // $this->load->view('header');

        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        $mouza_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');

        $this->load->model('misreport/MisModel');

        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $lotdata = $this->MisModel->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata);

        $locationData = array('chitha_dist_code' => $dist_code, 'chitha_subdiv_code' => $subdiv_code, 'chitha_cir_code' => $circle_code, 'chitha_mouza_pargona_code' => $mouza_code, 'chitha_lot_no' => $lot_no, 'chitha_vill_code' => $vill_code,);

        $this->session->set_userdata('chitha_report',$locationData);

        $this->load->model('chitha/ChithaModel');
        $daginfo = $this->ChithaModel->getDagforchitha($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, 0);
        //var_dump ($daginfo);
        $daginformation['dagrange'] = $daginfo;

        $pattatype = $this->ChithaModel->pattatypeforchitha();
        $pattatypeinformation['pattatype'] = $pattatype;
        $chithadetailsmain = array_merge($daginformation, $pattatypeinformation, $maindata);
        ////var_dump($chithadetailsmain);

        // $this->load->view('Utility/report2', $chithadetailsmain);
        // $this->load->view('footer');
        $chithadetailsmain['_view'] = 'utility/report2';
        $this->load->view('layouts/main',$chithadetailsmain);
    }

    public function generateChitha() {

        if (isset($_GET['case_no'])) {
            $case_no = $this->input->get('case_no');
            if ($case_no == 0) {
                ////var_dump($this->session->all_userdata());
                $district_code = $this->session->userdata('dist_code');
                $subdivision_code = $this->session->userdata('subdiv_code');
                $circlecode = $this->session->userdata('cir_code');
                $mouzacode = $this->session->userdata('mouza_pargona_code');
                $lot_code = $this->session->userdata('lot_no');
                $village_code = $this->session->userdata('vill_code');
                $patta_code = $this->session->userdata('patta_type_code');
                $dag_no_lower = $this->session->userdata('dag_no');
                $dag_no_upper = $this->session->userdata('dag_no');
                $dag_no_lower = $dag_no_lower . '00';
                $dag_no_upper = $dag_no_upper . '00';
            } elseif ($case_no == 1) {
                //this is for land reclassification
                $proposal_no = $this->input->get('proposal_no');
                $t_reclassification = $this->db->query("Select * from t_reclassification where proposal_no = '$proposal_no'")->row();
                $district_code = $t_reclassification->dist_code;
                $subdivision_code = $t_reclassification->subdiv_code;
                $circlecode = $t_reclassification->cir_code;
                $mouzacode = $t_reclassification->mouza_pargona_code;
                $lot_code = $t_reclassification->lot_no;
                $village_code = $t_reclassification->vill_townprt_code;

                $patta_code = $t_reclassification->patta_type_code;
                $dag_no_lower = $t_reclassification->dag_no;
                $dag_no_upper = $t_reclassification->dag_no;
                $dag_no_lower = $dag_no_lower . '00';
                $dag_no_upper = $dag_no_upper . '00';
            } else {
                $petition_basic = $this->db->query("Select * from petition_basic where case_no = '$case_no'")->row();
                $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from petition_dag_details where dist_code='$petition_basic->dist_code' and" . " subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and " . "lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and " . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'")->row_array();

                $district_code = $petition_basic->dist_code;
                $subdivision_code = $petition_basic->subdiv_code;
                $circlecode = $petition_basic->cir_code;
                $mouzacode = $petition_basic->mouza_pargona_code;
                $lot_code = $petition_basic->lot_no;
                $village_code = $petition_basic->vill_townprt_code;

                $patta_code = $landdetails['patta_type_code'];
                $dag_no_lower = $landdetails['dag_no'];
                $dag_no_upper = $landdetails['dag_no'];
                $dag_no_lower = $dag_no_lower . '00';
                $dag_no_upper = $dag_no_upper . '00';
            }
        } else {
            $location = $this->utilityclass->getLocationFromSession();
            ////var_dump($location);
            $district_code = $this->session->userdata('chitha_dist_code');
            $subdivision_code = $this->session->userdata('chitha_subdiv_code');
            $circlecode = $this->session->userdata('chitha_cir_code');
            $mouzacode = $this->session->userdata('chitha_mouza_pargona_code');
            $lot_code = $this->session->userdata('chitha_lot_no');
            $village_code = $this->session->userdata('chitha_vill_code');

            $patta_code = $this->input->post('patta_code');
            $dag_no_lower = $this->input->post('dag_no_lower');
            $dag_no_upper = $this->input->post('dag_no_upper');
        }
        //echo $dag_no_lower." and patta code".$dag_no_upper;
        $dist_name = $this->utilityclass->getDistrictName($district_code);
        $subdiv_name = $this->utilityclass->getSubDivName($district_code, $subdivision_code);
        $cir_name = $this->utilityclass->getCircleName($district_code, $subdivision_code, $circlecode);
        $mouza_pargona_code_name = $this->utilityclass->getMouzaName($district_code, $subdivision_code, $circlecode, $mouzacode);
        $lot_no = $this->utilityclass->getLotName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code);
        $vill_townprt_code_name = $this->utilityclass->getVillageName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code);

        $data['location'] = array('dist' => $dist_name, 'sub' => $subdiv_name, 'cir' => $cir_name, 'mouza' => $mouza_pargona_code_name, 'lot' => $lot_no, 'vill' => $vill_townprt_code_name);
        //echo $dag_no_lower." ".$dag_no_upper;
        //$data['loc']=$location;
        // //var_dump($data);
        // $this->load->helper('html');

        // $this->load->view('header');

        //
        // echo  $patta_code.'<br>'.$dag_no_lower.'<br>'.$dag_no_upper;
        $secondSelection = array('patta_code' => $patta_code, 'dag_no_lower' => $dag_no_lower, 'dag_no_upper' => $dag_no_upper);
        //$maindataforchitha = array_merge($data,$secondSelection);
        $this->load->model('chitha/ChithaModel');
        $pattatype['chithaPattatypeinfo'] = $this->ChithaModel->getpattatype($patta_code);
        //var_dump($pattatype);
        $this->session->set_userdata(array('patta_type' => $pattatype['chithaPattatypeinfo'][0]->patta_type));
        if ($patta_code != '0000') {
            $chithainfo1['data'] = $this->ChithaModel->getchithaDetails123($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper, $patta_code);
            // echo'hiii';
            //var_dump($chithainfo1);
        } else {
            $chithainfo1['chithainfo'] = $this->ChithaModel->getchithaDetails2($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper);
        }

        $maindataforchitha = array_merge($data, $secondSelection, $chithainfo1, $pattatype);
        //var_dump ($maindataforchitha);
        //$content = $this->load->view('Utility/saveChithaReport', $maindataforchitha);
        /* $this->load->library('pdf');
          $this->pdf->load_view('chitha_report/saveChithaReport', $maindataforchitha,true);
          $this->pdf->render();
          $this->pdf->stream("welcome.pdf"); */
        //$this->load->view('footer');
        $maindataforchitha['_view'] = 'utility/saveChithaReport';
        $this->load->view('layouts/main',$maindataforchitha);
    }

    public function DeleteCol8Order() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/utility/Delete_message');
        // $this->load->view('../views/footer');
        $maindataforchitha['_view'] = 'utility/Delete_message';
        $this->load->view('layouts/main',$maindataforchitha);
    }

    public function DeleteCol31Order() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/utility/Delete_message');
        // $this->load->view('../views/footer');
        $maindataforchitha['_view'] = 'utility/Delete_message';
        $this->load->view('layouts/main',$maindataforchitha);
    }

    public function select_locationCol31() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/utility/select_locationCol31');
        // $this->load->view('../views/footer');
        $maindataforchitha['_view'] = 'utility/select_locationCol31';
        $this->load->view('layouts/main',$maindataforchitha);
    }

    public function select_locationCol31_SthalatLagat() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/utility/select_locationCol31_SthalatLagat');
        // $this->load->view('../views/footer');
        $maindataforchitha['_view'] = 'utility/select_locationCol31_SthalatLagat';
        $this->load->view('layouts/main',$maindataforchitha);
    }

    public function JamaWasilSingleLoc() {
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/utility/JamaWasilSingleLoc');
        // $this->load->view('../views/footer');
        $maindataforchitha['_view'] = 'utility/JamaWasilSingleLoc';
        $this->load->view('layouts/main',$maindataforchitha);
    }

    // public function JamaWasilLoc() {
    //     $this->load->helper('html');
    //     $this->load->view('../views/header');
    //     $this->load->view('../views/utility/JamaWasilLoc');
    //     $this->load->view('../views/footer');
    // }

    // public function PeriodicPattaLoc() {
    //     $this->load->helper('html');
    //     $this->load->view('../views/header');
    //     $this->load->view('../views/utility/PeriodicPattaLoc');
    //     $this->load->view('../views/footer');
    // }

    // public function PeriodicPattaLocAll() {
    //     $this->load->helper('html');
    //     $this->load->view('../views/header');
    //     $this->load->view('../views/utility/PeriodicPattaLocAll');
    //     $this->load->view('../views/footer');
    // }

    // public function districtDetails32() {
    //     //var_dump($this->session->userdata('dist_code'));
    //     $this->load->helper('html');
    //     $this->load->view('header');
    //     $this->load->view('chitha_report/report1new');
    //     $this->load->view('footer');
    // }

    public function generateDagChitha32() {
        // $this->load->helper('html');
        // $this->load->view('header');

        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        $mouza_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');

        $this->load->model('misreport/MisModel');

        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $lotdata = $this->MisModel->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata);

        $locationData = array('chitha_dist_code' => $dist_code, 'chitha_subdiv_code' => $subdiv_code, 'chitha_cir_code' => $circle_code, 'chitha_mouza_pargona_code' => $mouza_code, 'chitha_lot_no' => $lot_no, 'chitha_vill_code' => $vill_code,);

        $this->session->set_userdata($locationData);

        $this->load->model('chitha/ChithaModel');
        $daginfo = $this->ChithaModel->getDagforchitha($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, 0);
        //var_dump ($daginfo);
        $daginformation['dagrange'] = $daginfo;

        $pattatype = $this->ChithaModel->pattatypeforchitha();
        $pattatypeinformation['pattatype'] = $pattatype;
        $chithadetailsmain = array_merge($daginformation, $pattatypeinformation, $maindata);
        ////var_dump($chithadetailsmain);

        // $this->load->view('chitha_report/report2new', $chithadetailsmain);
        // $this->load->view('footer');
        $chithadetailsmain['_view'] = 'chitha_report/report2new';
        $this->load->view('layouts/main',$chithadetailsmain);
    }

    public function getDags($p) {
        $this->load->model('chitha/ChithaModel');

        $dist_code = $this->session->userdata('chitha_dist_code');
        $subdiv_code = $this->session->userdata('chitha_subdiv_code');
        $circle_code = $this->session->userdata('chitha_cir_code');
        $mouza_code = $this->session->userdata('chitha_mouza_pargona_code');
        $lot_no = $this->session->userdata('chitha_lot_no');
        $vill_code = $this->session->userdata('chitha_vill_code');

        $daginfo = $this->ChithaModel->getDagforchitha1111($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $p);
        $json = array();

        foreach ($daginfo as $d) {
            $json[] = array('dag' => $d->dag_no, 'dag_no_int' => $d->dag_no_int);
        }
        echo json_encode($json);
    }

    public function generateChithaCitizen() {
        $location = $this->utilityclass->getLocationFromSession();
        ////var_dump($location);
        $district_code = $this->session->userdata('dist_code');
        $subdivision_code = $this->session->userdata('subdiv_code');
        $circlecode = $this->session->userdata('cir_code');
        $mouzacode = $this->session->userdata('mouza_pargona_code');
        $lot_code = $this->session->userdata('lot_no');
        $village_code = $this->session->userdata('vill_townprt_code');
        $patta_code = $this->session->userdata('patta_type_code');
        $dag_no_lower = $this->input->post('dag_no') . "00";
        $dag_no_upper = $this->input->post('dag_no') . "00";

        $dist_name = $this->utilityclass->getDistrictName($district_code);
        $subdiv_name = $this->utilityclass->getSubDivName($district_code, $subdivision_code);
        $cir_name = $this->utilityclass->getCircleName($district_code, $subdivision_code, $circlecode);
        $mouza_pargona_code_name = $this->utilityclass->getMouzaName($district_code, $subdivision_code, $circlecode, $mouzacode);
        $lot_no = $this->utilityclass->getLotName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code);
        $vill_townprt_code_name = $this->utilityclass->getVillageName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code);

        $data['location'] = array('dist' => $dist_name, 'sub' => $subdiv_name, 'cir' => $cir_name, 'mouza' => $mouza_pargona_code_name, 'lot' => $lot_no, 'vill' => $vill_townprt_code_name);

        //$data['loc']=$location;
        //var_dump($data);
        // $this->load->helper('html');
        // $this->load->view('header');

        //
        // echo  $patta_code.'<br>'.$dag_no_lower.'<br>'.$dag_no_upper;
        $secondSelection = array('patta_code' => $patta_code, 'dag_no_lower' => $dag_no_lower, 'dag_no_upper' => $dag_no_upper);
        //$maindataforchitha = array_merge($data,$secondSelection);
        //var_dump($secondSelection);
        $this->load->model('chitha/ChithaModel');
        $pattatype['chithaPattatypeinfo'] = $this->ChithaModel->getpattatype($patta_code);
        //var_dump($pattatype);
        $this->session->set_userdata(array('patta_type' => $pattatype['chithaPattatypeinfo'][0]->patta_type));
        if ($patta_code != '0000') {
            $chithainfo1['data'] = $this->ChithaModel->getchithaDetails123($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper, $patta_code);
        } else {
            $chithainfo1['chithainfo'] = $this->ChithaModel->getchithaDetails2($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper);
        }
        $maindataforchitha = array_merge($data, $secondSelection, $chithainfo1, $pattatype);
        //  var_dump($data);
        // $this->load->view('chitha_report/saveChithaReport', $maindataforchitha);
        // $this->load->view('footer');
        $maindataforchitha['_view'] = 'chitha_report/saveChithaReport';
        $this->load->view('layouts/main',$maindataforchitha);
    }

    public function generateChithaRegistration() {
        $district_code = $_GET['distcode'];
        //$this->input->post('dist_code');
        $subdivision_code = $_GET['subdivcode'];
        //$this->input->post('subdiv_code');
        $circlecode = $_GET['circlecode'];
        //$this->input->post('cir_code');
        $mouzacode = $_GET['mousacode'];
        //$this->input->post('mouza_pargona_code');
        $lot_code = $_GET['lotno'];
        //$this->input->post('lot_no');
        $village_code = $_GET['villcode'];
        //$this->input->post('vill_code');
        $patta_code = $_GET['pattatype'];
        //$this->input->post('patta_type_code');
        $dag_no_lower = $_GET['dagno'] * 100;
        //$this->input->post('dag_no');
        $dag_no_upper = $_GET['dagno'] * 100;
        //$this->input->post('dag_no');

        $dist_name = $this->utilityclass->getDistrictName($district_code);
        $subdiv_name = $this->utilityclass->getSubDivName($district_code, $subdivision_code);
        $cir_name = $this->utilityclass->getCircleName($district_code, $subdivision_code, $circlecode);
        $mouza_pargona_code_name = $this->utilityclass->getMouzaName($district_code, $subdivision_code, $circlecode, $mouzacode);
        $lot_no = $this->utilityclass->getLotName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code);
        $vill_townprt_code_name = $this->utilityclass->getVillageName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code);

        $data['location'] = array('dist' => $dist_name, 'sub' => $subdiv_name, 'cir' => $cir_name, 'mouza' => $mouza_pargona_code_name, 'lot' => $lot_no, 'vill' => $vill_townprt_code_name);

        $secondSelection = array('patta_code' => $patta_code, 'dag_no_lower' => $dag_no_lower, 'dag_no_upper' => $dag_no_upper);

        $this->load->model('chitha/ChithaModel');

        $pattatype['chithaPattatypeinfo'] = $this->ChithaModel->getpattatype($patta_code);

        $this->session->set_userdata(array('patta_type' => $pattatype['chithaPattatypeinfo'][0]->patta_type));
        if ($patta_code != '0000') {
            $chithainfo1['data'] = $this->ChithaModel->getchithaDetails123($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper, $patta_code);
        } else {
            $chithainfo1['chithainfo'] = $this->ChithaModel->getchithaDetails2($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper);
        }

        $maindataforchitha = array_merge($data, $secondSelection, $chithainfo1, $pattatype);

        $content = $this->load->view('chitha_report/saveChithaReport', $maindataforchitha, true);

        header("Access-Control-Allow-Origin: *");

        echo json_encode(array('d' => $content));
    }

    public function getSubdivJson_wdb($distcode) {

        $data = $this->CoofficeConversionModel->getSubDivJSON_wdb($distcode);
        $json = array();
        foreach ($data as $object) {
            $json[] = array('loc_name' => $object->loc_name, 'subdiv_code' => $object->subdiv_code);
        }
        echo json_encode($json);
    }

    public function getCirCodeJson_wdb($distcode, $subdivcode) {
        $data = $this->CoofficeConversionModel->getCirCodeJSON_wdb($distcode, $subdivcode);
        $json = array();
        foreach ($data as $object) {
            $json[] = array('loc_name' => $object->loc_name, 'cir_code' => $object->cir_code);
        }
        echo json_encode($json);
    }

    public function getDagsbacklog($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $p, $patta_no) {
        $this->load->model('conversion/COofficeConversionModel');
        $daginfo = $this->COofficeConversionModel->getDagforchitha1111($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $p, $patta_no);

        $json = array();

        foreach ($daginfo as $d) {
            $json[] = array('dag' => $d->dag_no, 'dag_no_int' => $d->dag_no_int);
        }
        echo json_encode($json);
    }

    public function getLandAreaJSON($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $patta_type, $patta_no, $dag_no) {
        $data = $this->db->query(""
            . "Select dag_area_b,dag_area_k,dag_area_lc,dag_area_g  from Chitha_Basic where Dist_code='$dist_code' and Subdiv_code='$subdiv_code' and  patta_type_code='$patta_type' and TRIM(patta_no) = '$patta_no' and Cir_code='$circle_code' and Mouza_Pargona_code='$mouza_code' and Lot_No='$lot_no' "
            . "and Vill_townprt_code='$vill_code' and dag_no_int = '$dag_no'");
        $landarea = $data->result();
        echo json_encode($landarea);
    }

    public function backentry_utilities() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');

        $data['location'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no
        );

        // $this->load->view('../views/header');
        // $this->load->view('../views/backentry/menu', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'backentry/menu';
        $this->load->view('layouts/main',$data);
    }

    public function BackEntryLandConversion() {
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
        $query = "select lm_name,lm_code from lm_code where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
        $district['lmname'] = $this->db->query($query)->result();

        $query = "select username,user_code from users where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
            . " user_desig_code='SK'";
        $district['skname'] = $this->db->query($query)->result();

        $query = "select username,user_code from users where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
            . " user_desig_code='CO'";
        $district['coname'] = $this->db->query($query)->result();

        $query = "select type_code,patta_type from patta_code where conversion = 'y'";
        $district['pattatype'] = $this->db->query($query)->result();

        //var_dump($district);
        // $this->load->view('../views/backentry/BackEntryLandConversion', $district);
        // $this->load->view('../views/footer');
        $district['_view'] = 'backentry/BackEntryLandConversion';
        $this->load->view('layouts/main',$district);
    }

    function BackEntryLandConversionSubmit1() {

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $circle_code = $this->input->post('circle_code');
            $mouza_code = $this->input->post('mouza_code');
            $lot_no = $this->input->post('lot_no');
            $vill_code = $this->input->post('vill_code');
            $patta_code = $this->input->post('patta_code');
            $patta_no = trim($this->input->post('patta_no'));
            $dag_no_int = $this->input->post('dag_no');
            $PartialOrFull = $this->input->post('PartialOrFull');
            $year_no = $this->input->post('year_no');

            $dag_area_b = $this->input->post('dag_area_b');
            $dag_area_k = $this->input->post('dag_area_k');
            $dag_area_lc = $this->input->post('dag_area_lc');

            $m_dag_area_b_P = $this->input->post('m_dag_area_b_P');
            $m_dag_area_k_P = $this->input->post('m_dag_area_k_P');
            $m_dag_area_lc_P = $this->input->post('m_dag_area_lc_P');

            $l_dag_area_b_P = $this->input->post('l_dag_area_b_P'); //l_dag_area_b_P
            $l_dag_area_k_P = $this->input->post('l_dag_area_k_P'); //l_dag_area_k_P
            $l_dag_area_lc_P = $this->input->post('l_dag_area_lc_P');

            $m_dag_area_b = $this->input->post('m_dag_area_b');
            $m_dag_area_k = $this->input->post('m_dag_area_k');
            $m_dag_area_lc = $this->input->post('m_dag_area_lc');

            $case_no = $this->input->post('case_no');

            if (($l_dag_area_b_P == '0') and ( $l_dag_area_k_P == '0') and ( $l_dag_area_lc_P == '0')) {
                $PartialOrFull = 'Y';
            }


            $petition_no = $this->db->query("select max(petition_no) as petition_no from t_chitha_rmk_ordbasic where year_no = '$year_no' and petition_no is not null limit 1")->row()->petition_no;
            if ($petition_no == null) {
                $petition_no = 1;
            } else {
                $petition_no += 1;
            }
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
                'm_dag_area_b_P' => $m_dag_area_b_P,
                'm_dag_area_k_P' => $m_dag_area_k_P,
                'm_dag_area_lc_P' => $m_dag_area_lc_P,
                'l_dag_area_b_P' => $l_dag_area_b_P,
                'l_dag_area_k_P' => $l_dag_area_k_P,
                'l_dag_area_lc_P' => $l_dag_area_lc_P,
                'm_dag_area_b' => $m_dag_area_b,
                'm_dag_area_k' => $m_dag_area_k,
                'm_dag_area_lc' => $m_dag_area_lc,
                'case_no' => $case_no . "/CONV-BL",
                'pitition_no' => $pitition_no, // exploded on / of the case no
                'ord_date' => $order_date,
                'PartialOrFull' => $PartialOrFull,
                'year_no' => $year_no
            );
            $this->session->set_userdata($conversion_data_backdate);

            if ($PartialOrFull == 'Y') {
                $bigha = $m_dag_area_b;
                $kotha = $m_dag_area_k;
                $lessa = $m_dag_area_lc;
            } else {
                $bigha = $m_dag_area_b_P;
                $kotha = $m_dag_area_k_P;
                $lessa = $m_dag_area_lc_P;
            }

            $only_land_share = array(
                'bigha' => $bigha,
                'kotha' => $kotha,
                'lessa' => $lessa,
            );
            $this->session->set_userdata($only_land_share);
            redirect(base_url() . "index.php/Utility/BackEntryLandConversionRedirect1");
        }
    }

    public function BackEntryLandConversionRedirect1() {
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

        $PartialOrFull = $this->session->userdata('PartialOrFull');

        $patta_no = trim($this->session->userdata('patta_no'));
        $dag_no_int = $this->session->userdata('dag_no_int');
        $patta_type_code = $this->session->userdata('patta_type_code');

        $patta_name = $this->db->query("select patta_type from patta_code where type_code='$patta_type_code'")->row();

        $bigha = $this->session->userdata('bigha');
        $kotha = $this->session->userdata('kotha');
        $lessa = $this->session->userdata('lessa');

        $rev_and_tax = "Select * from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
            . "and mouza_pargona_code='$mouza_pargona_code' and dag_no_int='$dag_no_int' and TRIM(patta_no) = '$patta_no' "
            . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and patta_type_code= '$patta_type_code'";
        //echo $rev_and_tax;
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

        $check_dag_no = "Select dag_no from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
            . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' order by dag_no_int asc";
        //echo $check_dag_no;
        $data['check_dag_no'] = $this->db->query($check_dag_no)->result();

        $check_patta_no = "Select patta_no as patta_no from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
            . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and TRIM(patta_no)!='' and TRIM(patta_no)!='.' order by length(patta_no) asc";
        //echo $check_patta_no;
        $data['check_patta_no'] = $this->db->query($check_patta_no)->result();

        $sql = "Select dag_no from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
            . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and patta_type_code= '$patta_type_code'"; // and dag_no_int = '$dag_no_int'
        //echo $sql;

        $dag_no = $data['oldDag'] = $this->db->query($sql)->result();
        //var_dump($dag_no);
        $newDag = 0;
        foreach ($dag_no as $d) {
            $d = $d->dag_no;
            if ($newDag < $d) {
                $newDag = $d;
            }
        }

        $sqll = "Select patta_no from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
            . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and patta_type_code= '$patta_type_code'";
        $patta = $data['oldPatta'] = $this->db->query($sqll)->result();
        $newpatta = 0;
        foreach ($patta as $p) {
            $p = trim($p->patta_no);
            if ($newpatta < $p) {
                $newpatta = $p;
            }
        }

        $sqldag = "Select dag_no as c from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
            . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and patta_type_code= '$patta_type_code' and dag_no_int = '$dag_no_int'"; // and dag_no_int = '$dag_no_int'

        $actual_dag_no = $this->db->query($sqldag)->row()->c;
        //var_dump($actual_dag_no);

        $data['datas'] = array(
            'patta_no' => $patta_no,
            'patta_type' => $patta_name->patta_type,
            'bigha' => $bigha,
            'kotha' => $kotha,
            'lessa' => round($lessa, 2),
            'dag_no' => $dag_no_int,
            'new_dag' => $newDag + 1,
            'newpatta' => $newpatta + 1,
            'revenue' => $cal_new_rev,
            'local_tax' => $new_dag_local_tax,
            'PartialOrFull' => $PartialOrFull,
            'actual_dag_no' => $actual_dag_no
        );
        //var_dump($data);
        //$data['payment_type'] = $this->db->query("Select * from premium_chalan_receipt where code = '$type_of_premium'")->row();

        $data['type'] = $this->db->query("SELECT * FROM  patta_code")->result();

        $data['pattadar_details'] = $this->db->query("select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from chitha_pattadar p join 
            chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
            and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
            p.pdar_id = d.pdar_id and trim(p.patta_no) = trim(d.patta_no) where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
            and d.lot_no='$lot_no' and d.dag_no='$actual_dag_no' and trim(p.patta_no)='$patta_no' and d.p_flag!='1' and p.patta_type_code='$patta_type_code'")->result(); //

        $query1 = "select lm_name,lm_code from lm_code where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
            . " and lot_no='$lot_no'";
        $data['lmname'] = $this->db->query($query1)->result();

        $query2 = "select username,user_code from users where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
            . " user_desig_code='SK'";
        $data['skname'] = $this->db->query($query2)->result();

        $query3 = "select username,user_code from users where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
            . " user_desig_code='CO'";
        $data['coname'] = $this->db->query($query3)->result();

        $data['payment_type'] = $this->db->query("Select * from premium_chalan_receipt")->result();

        $this->load->model('patta/PattaModel');
        // $this->load->view('../views/header');
        // $this->load->view('../views/backentry/Give_conversion_final_order', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'backentry/Give_conversion_final_order';
        $this->load->view('layouts/main',$data);
    }

    public function FinalSaveTest() {
        $this->db->trans_begin();

        $data = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $lot_no = $this->session->userdata('lot_no');

        $case_no = $this->session->userdata('case_no');
        $year_no = $this->session->userdata('year_no');
        $pitition_no = $this->session->userdata('pitition_no');
        //$proceeding_id = $this->session->userdata('proceeding_id');

        $bigha = $this->session->userdata('bigha');
        $kotha = $this->session->userdata('kotha');
        $lessa = $this->session->userdata('lessa');

        $order_date = $this->session->userdata('ord_date');
        $patta_no = trim($this->session->userdata('patta_no'));
        $dag = $this->input->post('old_dag_no');
        $patta_type_code = $this->session->userdata('patta_type_code');

        $dag_no_int = $this->session->userdata('dag_no_int');
        $PartialOrFull = $this->session->userdata('PartialOrFull');

        $type_of_premium = $this->input->post('payment_type');
        $premium_reciept = $this->input->post('chalan_no');
        $premium_amount = $this->input->post('total_premium');
        if (($premium_amount == null) || ($premium_amount == "")) {
            $premium_amount = 0;
        }

        $new_patta_type = $this->input->post('new_patta_type');
        $sugg_patta_no = trim($this->input->post('sugg_patta_no'));
        $old_patta_no = trim($this->input->post('old_patta_no'));
        $sugg_dag_no = $this->input->post('sugg_dag_no');
        $old_dag_no = $this->input->post('old_dag_no');

        //$land_portion_status = $this->input->post('land_portion_status'); // N
        $revenue = $this->input->post('dag_revenue');
        $local_tax = $this->input->post('dag_local_tax');

        $lm_code = $this->input->post('lm_code');
        $lm_sign = $this->input->post('lmSign');
        $lm_sign_date = $this->input->post('lm_date');

        $sk_code = $this->input->post('sk_code');
        $sk_sign = $this->input->post('skSign');
        $sk_sign_date = $this->input->post('sk_date');

        $co_code = $this->input->post('co_code');
        $co_sign = $this->input->post('coSign');
        $co_order_date = $this->input->post('co_date');

        if ($this->session->userdata('PartialOrFull') == 'Y') {
            $type_of_conversion = 'F';
        } else {
            $type_of_conversion = 'P';
        }

        $chitha_rmk_ordbasic = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'dag_no' => $dag,
            'year_no' => $year_no,
            'petition_no' => $pitition_no,
            'ord_no' => $case_no,
            'ord_date' => $order_date,
            'ord_type_code' => '01',
            'case_no' => $case_no,
            'ord_on_gl_type' => '',
            'ord_passby_sign_yn' => 'Y',
            'ord_passby_desig' => 'CO', //coz this is the designation
            'ord_ref_let_no' => '',
            'lm_code' => $lm_code,
            'lm_sign_yn' => $lm_sign,
            'lm_sign_date' => $lm_sign_date,
            'sk_code' => $sk_code,
            'sk_sign_yn' => $sk_sign,
            'sk_sign_date' => $sk_sign_date,
            'co_code' => $co_code,
            'co_sign_yn' => $co_sign,
            'co_ord_date' => $co_order_date,
            'm_dag_area_b' => $bigha,
            'm_dag_area_k' => $kotha,
            'm_dag_area_lc' => $lessa, //
            'm_dag_area_g' => '0.0000',
            'm_dag_area_kr' => '0',
            'wrt_order1' => '',
            'wrt_order2' => '',
            'wrt_order3' => '',
            'wrt_order4' => '',
            'wrt_order5' => '',
            'ord_impli_flag' => '',
            //'ord_impli_date'=>'',
            'iscorrected_inco' => '',
            //'iscorrected_inco_date'=>'',
            'iscorrected_rkg_record' => '',
            //'iscorrected_rkg_date'=>'',
            'isdataposted_torkg_db' => '',
            'isorder_cancelled' => '',
            'ifyes_reason1' => '',
            'ifyes_reason2' => '',
            'ifyes_reason3' => '',
            'make_mdb' => $type_of_conversion, //full conversion or partial
            'new_dag_no' => $sugg_dag_no,
            'min_revenue' => $revenue
        );

        $pattadar_details = $this->db->query("Select * from chitha_dag_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
            . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and patta_type_code= '$patta_type_code' and dag_no = '$dag' and TRIM(patta_no) = '$patta_no'")->result();

        $i = 1;
        foreach ($pattadar_details as $p) {
            $pdar_id = $p->pdar_id;

            $query = "select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from chitha_pattadar p join 
                    chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
                    and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
                    p.pdar_id = d.pdar_id and TRIM(p.patta_no) = TRIM(d.patta_no) where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
                    p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' 
                    and d.lot_no='$lot_no' and d.dag_no='$dag' and TRIM(p.patta_no)='$patta_no' 
                    and p.patta_type_code='$patta_type_code' and p.pdar_id='$pdar_id' and d.p_flag!='1'";

            //echo $query;
            $data = $this->db->query($query)->result();
            //var_dump($data);
            $values = array();
            foreach ($data as $value) {

                $chitha_rmk_convorder = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'dag_no' => $dag,
                    'year_no' => $year_no,
                    'petition_no' => $pitition_no,
                    'ord_no' => $case_no,
                    'ord_date' => $order_date, //this date needs to be sorted out
                    'patta_type_code' => $patta_type_code,
                    'patta_no' => trim($patta_no),
                    'ord_onbehalf_id' => $i++, //auto increment id
                    'ord_onbehalf_of' => $value->pdar_name, //pattadar name
                    'premium' => $premium_amount,
                    'premi_chal_recpt' => $type_of_premium, //only 3 char
                    'premi_chal_recpt_no' => $premium_reciept,
                    'land_area_b' => $bigha,
                    'land_area_k' => $kotha,
                    'land_area_lc' => $lessa,
                    'land_area_g' => '0.0000',
                    'land_area_kr' => '0',
                    'new_patta_type' => $new_patta_type,
                    'new_patta_no' => trim($sugg_patta_no),
                    'new_dag_no' => $sugg_dag_no,
                    'pdar_id' => $pdar_id, //pattadar id
                    //'pdar_strike'=>$p->pdar_strike,
                    'ord_onbehalf_guard' => $value->pdar_father,
                );
                //var_dump($chitha_rmk_convorder);
                $this->db->insert('t_chitha_rmk_convorder', $chitha_rmk_convorder); //*******************
            }
        }
        //var_dump($chitha_rmk_ordbasic);
        $this->db->insert('t_chitha_rmk_ordbasic', $chitha_rmk_ordbasic); //*******************


        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo "Error Occured";
        } else {
            $this->db->trans_commit();
            redirect(base_url() . "index.php/Utility/select_full_or_partial");
        }
    }

    public function select_full_or_partial() {
        $case_no = $this->session->userdata('case_no');
        //$case_no = '123/2012-13/CONV-BL';
        $query = "select * from t_chitha_rmk_ordbasic where ord_no = '$case_no'";
        $result = $this->db->query($query)->row();
        if ($result->make_mdb == 'F') {
            // echo "full";
            redirect(base_url() . "index.php/Utility/updateChithaConversionForFullConversion");
        } else {
            // echo "partial";
            redirect(base_url() . "index.php/Utility/updateChithaConversionForPartialConversion");
        }
    }

    // public function updateChithaConversionForFullConversion() {
    //     $this->db->trans_begin();
    //     $case_no = $this->session->userdata('case_no');
    //     $dist_code = $this->session->userdata('dist_code');
    //     $subdiv_code = $this->session->userdata('subdiv_code');
    //     $cir_code = $this->session->userdata('cir_code');
    //     $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
    //     $vill_townprt_code = $this->session->userdata('vill_code');
    //     $lot_no = $this->session->userdata('lot_no');

    //     $query = "select * from t_chitha_rmk_ordbasic where ord_no = '$case_no' "
    //         . "and dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
    //         . "cir_code='$cir_code' and lot_no='$lot_no' and "
    //         . "vill_townprt_code='$vill_townprt_code' and mouza_pargona_code='$mouza_pargona_code'";
    //     $result = $this->db->query($query)->result();
    //     //var_dump($result);
    //     //echo "##########################################################";
    //     foreach ($result as $order) {
    //         $query_rmk_hist = "select max(rmk_type_hist_no) as c from chitha_rmk_convorder where "
    //             . "dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' and cir_code='$order->cir_code'"
    //             . " and lot_no='$order->lot_no' and mouza_pargona_code='$order->mouza_pargona_code' and "
    //             . " vill_townprt_code='$order->vill_townprt_code' and dag_no='$order->dag_no' ";
    //         //echo $query_rmk_hist;
    //         $rmk_hist_no = $this->db->query($query_rmk_hist)->row()->c;
    //         if ($rmk_hist_no == null) {
    //             $rmk_hist_no = 1;
    //         } else
    //             $rmk_hist_no += 1;

    //         $q = "select max(ord_cron_no)+1 as c1,max(rmk_type_hist_no)+1 as c2 from chitha_rmk_ordbasic where "
    //             . "dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' and cir_code='$order->cir_code'"
    //             . " and lot_no='$order->lot_no' and mouza_pargona_code='$order->mouza_pargona_code' and "
    //             . " vill_townprt_code='$order->vill_townprt_code' and dag_no='$order->dag_no' ";
    //         //echo $q;
    //         $ord_cron_no = $this->db->query($q)->row()->c1;
    //         if ($ord_cron_no == null) {
    //             $ord_cron_no = 1;
    //         } else {
    //             $ord_cron_no+=1;
    //         }

    //         $chitha_basic_update = FALSE;
    //         $query = "select * from t_chitha_rmk_convorder where ord_no='$order->ord_no' and iscorrected_inco is null ";
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

    //             $this->db->insert('chitha_rmk_convorder', $c); //**************************
    //             $d = date('Y-m-d');
    //             $update_conv_order_q = "update t_chitha_rmk_convorder set iscorrected_inco='Y',iscorrected_inco_date='$d' "
    //                 . " where ord_no='$order->ord_no'";
    //             $this->db->query($update_conv_order_q); //*********************

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
    //             //var_dump($data);
    //             $chech_existance = $this->db->query("select count(*) as c from chitha_pattadar where dist_code = '$ord->dist_code' and subdiv_code = '$ord->subdiv_code' and "
    //                 . "cir_code = '$ord->cir_code' and mouza_pargona_code = '$ord->mouza_pargona_code' "
    //                 . "and lot_no = '$ord->lot_no' and vill_townprt_code = '$ord->vill_townprt_code' and pdar_id = '$ord->pdar_id' "
    //                 . "and TRIM(patta_no) = trim('$ord->new_patta_no') and patta_type_code = '$ord->new_patta_type'")->row()->c;

    //             if ($chech_existance == 0) {
    //                 $this->db->insert('chitha_pattadar', $data); //*********************
    //             }

    //             $landArea_query = "select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr from chitha_basic"
    //                 . "  where dist_code='$ord->dist_code' and"
    //                 . " subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
    //                 . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
    //                 . " vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no'  "
    //                 . " and TRIM(patta_no)=trim('$ord->patta_no') and patta_type_code='$ord->patta_type_code'";

    //             if ($chitha_basic_update == FALSE) {
    //                 $user_code = $this->session->userdata('user_code');
    //                 $date_entry = date('Y-m-d G:i:s');
    //                 $new_revenue = $order->min_revenue;
    //                 $dag_local_tax = round($new_revenue / 4, 2);

    //                 $chitha_update = "update chitha_basic set patta_no=trim('$ord->new_patta_no'), old_patta_no=trim('$ord->patta_no'),"
    //                     . "dag_no='$ord->new_dag_no',patta_type_code='$ord->new_patta_type',"
    //                     . "user_code='$user_code', date_entry='$date_entry', operation='E',"
    //                     . "jama_yn=' ', dag_revenue = '$new_revenue', dag_local_tax = '$dag_local_tax' where dist_code='$ord->dist_code' and"
    //                     . " subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
    //                     . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
    //                     . " vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no'  "
    //                     . " and TRIM(patta_no)=trim('$ord->patta_no') and patta_type_code='$ord->patta_type_code'";

    //                 $this->db->query($chitha_update);  //*********************
    //                 $chitha_basic_update = TRUE;
    //             }

    //             $update_query = "update chitha_dag_pattadar set p_flag='1',operation='M' where "
    //                 . "dist_code='$ord->dist_code' and subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
    //                 . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
    //                 . " vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no' "
    //                 . " and pdar_id=$ord->pdar_id and patta_type_code='$ord->patta_type_code' and "
    //                 . "TRIM(patta_no)=trim('$ord->patta_no')";

    //             $this->db->query($update_query);  //*********************

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
    //                 'p_flag' => '0',
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
    //         //unset($order->patta_no);
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
    //         $order->operation = 'E';
    //         $order->date_entry = date('Y-m-d G:i:s');
    //         $order->area_left_b = 0;
    //         $order->area_left_k = 0;
    //         $order->area_left_lc = 0;
    //         $order->area_left_g = 0;
    //         $order->area_left_kr = 0;

    //         //var_dump($order);
    //         $get_patta_no = $this->db->query("select distinct(new_patta_no) as new_patta_no from t_chitha_rmk_convorder where ord_no='$order->ord_no'")->row()->new_patta_no;

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
    //         $this->db->insert('chitha_rmk_gen', $rmk_gen); //*********************
    //         $this->db->insert('chitha_rmk_ordbasic', $order); //*********************
    //         $d = date('Y-m-d');
    //         $update_q = "update t_chitha_rmk_ordbasic set iscorrected_inco='Y',iscorrected_inco_date='$d'"
    //             . " where ord_no='$order->ord_no' and dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' and cir_code='$order->cir_code' and lot_no='$order->lot_no' and vill_townprt_code='$order->vill_townprt_code' and mouza_pargona_code='$order->mouza_pargona_code'";
    //         $this->db->query($update_q); //*********************

    //         if ($this->db->trans_status() === FALSE) {
    //             $this->db->trans_rollback();
    //             echo "Error Occured";
    //         } else {
    //             $this->db->trans_commit();
    //             // $this->load->view('../views/header');
    //             // $this->load->view('../views/backentry/finalReport');
    //             // $this->load->view('../views/footer');
    //             $data['_view'] = 'backentry/finalReport';
    //             $this->load->view('layouts/main',$data);
    //         }
    //     }
    // }

    // public function updateChithaConversionForPartialConversion() {
    //     $this->db->trans_begin();
    //     $case_no = $this->session->userdata('case_no');
    //     $dist_code = $this->session->userdata('dist_code');
    //     $subdiv_code = $this->session->userdata('subdiv_code');
    //     $cir_code = $this->session->userdata('cir_code');
    //     $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
    //     $vill_townprt_code = $this->session->userdata('vill_code');
    //     $lot_no = $this->session->userdata('lot_no');


    //     $query = "select * from t_chitha_rmk_ordbasic where ord_no = '$case_no' and dist_code='$dist_code' and "
    //         . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and "
    //         . "vill_townprt_code='$vill_townprt_code' and mouza_pargona_code='$mouza_pargona_code'";
    //     $result = $this->db->query($query)->result();
    //     //var_dump($result);
    //     //echo "##########################################################";
    //     foreach ($result as $order) {

    //         $query_rmk_hist = "select max(rmk_type_hist_no) as c from chitha_rmk_convorder where "
    //             . "dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' and cir_code='$order->cir_code'"
    //             . " and lot_no='$order->lot_no' and mouza_pargona_code='$order->mouza_pargona_code' and "
    //             . " vill_townprt_code='$order->vill_townprt_code' and dag_no='$order->dag_no' ";
    //         $rmk_hist_no = $this->db->query($query_rmk_hist)->row()->c;
    //         if ($rmk_hist_no == null) {
    //             $rmk_hist_no = 1;
    //         } else
    //             $rmk_hist_no += 1;

    //         $q = "select max(ord_cron_no)+1 as c1,max(rmk_type_hist_no)+1 as c2 from chitha_rmk_ordbasic where "
    //             . "dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' and cir_code='$order->cir_code'"
    //             . " and lot_no='$order->lot_no' and mouza_pargona_code='$order->mouza_pargona_code' and "
    //             . " vill_townprt_code='$order->vill_townprt_code' and dag_no='$order->dag_no' ";

    //         $ord_cron_no = $this->db->query($q)->row()->c1;
    //         if ($ord_cron_no == null) {
    //             $ord_cron_no = 1;
    //         } else {
    //             $ord_cron_no+=1;
    //         }
    //         $chitha_basic_update = FALSE;
    //         $query = "select * from t_chitha_rmk_convorder where ord_no='$order->ord_no' and iscorrected_inco is null ";
    //         //echo $query;
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

    //             //var_dump($ord);
    //             $this->db->insert('chitha_rmk_convorder', $c); //**************************
    //             $d = date('Y-m-d');
    //             $update_conv_order_q = "update t_chitha_rmk_convorder set iscorrected_inco='Y',iscorrected_inco_date='$d' "
    //                 . " where ord_no='$order->ord_no'";
    //             $this->db->query($update_conv_order_q); //*********************

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
    //             //var_dump($data);
    //             $chech_existance = $this->db->query("select count(*) as c from chitha_pattadar where dist_code = '$ord->dist_code' and subdiv_code = '$ord->subdiv_code' and "
    //                 . "cir_code = '$ord->cir_code' and mouza_pargona_code = '$ord->mouza_pargona_code' "
    //                 . "and lot_no = '$ord->lot_no' and vill_townprt_code = '$ord->vill_townprt_code' and pdar_id = '$ord->pdar_id' "
    //                 . "and TRIM(patta_no) = trim('$ord->new_patta_no') and patta_type_code = '$ord->new_patta_type'")->row()->c;
    //             //echo $chech_existance;
    //             if ($chech_existance == 0) {
    //                 $this->db->insert('chitha_pattadar', $data); //*********************
    //             }

    //             $landArea_query = "select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,dag_revenue from chitha_basic"
    //                 . "  where dist_code='$ord->dist_code' and"
    //                 . " subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
    //                 . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
    //                 . " vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no'  "
    //                 . " and TRIM(patta_no)=trim('$ord->patta_no') and patta_type_code='$ord->patta_type_code'";
    //             //echo $landArea_query;
    //             $b = '0';
    //             $k = '0';
    //             $lc = '0';
    //             $g = '0.0';
    //             $kr = '0.0';
    //             //old land portion
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

    //             //$cal_new_rev =round($old_dag_revenue, 2);
    //             //$new_dag_local_tax =round($cal_new_rev/4, 2);
    //             //$cal_new_rev =round(($old_dag_revenue/$converted_to_lessa_old)*$remaining_lessa, 2);
    //             //$new_dag_local_tax =round($cal_new_rev/4, 2);

    //             if ($chitha_basic_update == FALSE) {
    //                 $chitha_update = "update chitha_basic set dag_area_b='$b',dag_area_k='$k',"
    //                     . " dag_area_lc='$lc',dag_area_g='$g',dag_area_kr='$kr',jama_yn='', dag_revenue = '0.0', dag_local_tax = '0.00'  where dist_code='$ord->dist_code' and"
    //                     . " subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
    //                     . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
    //                     . " vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no'  "
    //                     . " and TRIM(patta_no)=trim('$ord->patta_no') and patta_type_code='$ord->patta_type_code'";

    //                 //var_dump($chitha_update);
    //                 $this->db->query($chitha_update);  //*********************

    //                 $landclass_query = "select land_class_code from chitha_basic  where dist_code='$ord->dist_code' and"
    //                     . " subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
    //                     . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
    //                     . " vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no'  "
    //                     . " and TRIM(patta_no)=trim('$ord->patta_no') and patta_type_code='$ord->patta_type_code'";
    //                 //echo $landclass_query;
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
    //                 $this->db->insert('chitha_basic', $chitha_basic);  //*********************
    //                 $chitha_basic_update = TRUE;
    //             }
    //             if ($ord->pdar_strike == 'Y') {
    //                 $p_flag = '1';
    //             } else {
    //                 $p_flag = '0';
    //             }
    //             $update_query = "update chitha_dag_pattadar set p_flag='$p_flag',operation='M' where "
    //                 . "dist_code='$ord->dist_code' and subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
    //                 . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
    //                 . " vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no' "
    //                 . " and pdar_id='$ord->pdar_id' and patta_type_code='$ord->patta_type_code'";
    //             //echo $update_query;
    //             $this->db->query($update_query);  //*********************

    //             $dag_pattadar = array(
    //                 'dist_code' => $ord->dist_code,
    //                 'subdiv_code' => $ord->subdiv_code,
    //                 'cir_code' => $ord->cir_code,
    //                 'mouza_pargona_code' => $ord->mouza_pargona_code,
    //                 'lot_no' => $ord->lot_no,
    //                 'vill_townprt_code' => $ord->vill_townprt_code,
    //                 'pdar_id' => $ord->pdar_id,
    //                 'patta_no' => trim($ord->new_patta_no),
    //                 'dag_no' => trim($ord->new_dag_no),
    //                 'patta_type_code' => $ord->new_patta_type,
    //                 'dag_por_b' => $ord->land_area_b,
    //                 'dag_por_k' => $ord->land_area_k,
    //                 'dag_por_lc' => $ord->land_area_lc,
    //                 'dag_por_g' => 0.0,
    //                 'dag_por_kr' => 0,
    //                 'user_code' => $this->session->userdata('user_code'),
    //                 'date_entry' => date('Y-m-d G:i:s'),
    //                 'operation' => 'E',
    //                 'p_flag' => '0',
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
    //         //unset($order->patta_no);
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
    //         $order->operation = 'E';
    //         $order->date_entry = date('Y-m-d G:i:s');
    //         $order->area_left_b = 0;
    //         $order->area_left_k = 0;
    //         $order->area_left_lc = 0;
    //         $order->area_left_g = 0;
    //         $order->area_left_kr = 0;

    //         //var_dump($order);
    //         $get_new_patta_no = $this->db->query("select distinct(new_patta_no) as new_patta_no from t_chitha_rmk_convorder where ord_no='$order->ord_no'")->row()->new_patta_no;
    //         $get_old_patta_no = $this->db->query("select distinct(patta_no) as patta_no from t_chitha_rmk_convorder where ord_no='$order->ord_no'")->row()->patta_no;
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
    //         $this->db->insert('chitha_rmk_gen', $rmk_gen_for_old); //*********************
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
    //         $this->db->insert('chitha_rmk_gen', $rmk_gen_for_new); //*********************
    //         $this->db->insert('chitha_rmk_ordbasic', $order); //*********************
    //         unset($order->dag_no);
    //         $order->dag_no = $order->new_dag_no;
    //         $newDag = $order->new_dag_no;
    //         //var_dump($order);
    //         unset($order->new_dag_no);
    //         $this->db->insert('chitha_rmk_ordbasic', $order);
    //         $d = date('Y-m-d');
    //         $update_q = "update t_chitha_rmk_ordbasic set iscorrected_inco='Y',iscorrected_inco_date='$d'"
    //             . " where ord_no='$order->ord_no' and dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' and cir_code='$order->cir_code' and lot_no='$order->lot_no' and vill_townprt_code='$order->vill_townprt_code' and mouza_pargona_code='$order->mouza_pargona_code'";
    //         $this->db->query($update_q); //*********************


    //         if ($this->db->trans_status() === FALSE) {
    //             $this->db->trans_rollback();
    //             echo "Error Occured";
    //         } else {
    //             $this->db->trans_commit();
    //             // $this->load->view('../views/header');
    //             // $this->load->view('../views/backentry/finalReport');
    //             // $this->load->view('../views/footer');
    //             $data['_view'] = 'backentry/finalReport';
    //             $this->load->view('layouts/main',$data);
    //         }
    //     }
    // }

    public function BackEntryReclassification() {
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
        $query = "select lm_name,lm_code from lm_code where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
        //echo $query;
        $district['lmname'] = $this->db->query($query)->result();

        $query = "select username,user_code from users where dist_code='$dist_code' and user_desig_code like '%DC%' ";
        //echo $query;
        $district['dc_adc'] = $this->db->query($query)->result();

        $query = "select username,user_code from users where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
            . " user_desig_code='CO'";
        //echo $query;
        $district['coname'] = $this->db->query($query)->result();

        $land_class_agri = "Select * from landclass_code where class_code_cat = '01'";
        $district['land_class_agri'] = $this->db->query($land_class_agri)->result();

        $land_class_non_agri = "Select * from landclass_code where class_code_cat = '02'";
        $district['land_class_non_agri'] = $this->db->query($land_class_non_agri)->result();

        //var_dump($district);
        // $this->load->view('../views/backentry/BackEntryLandReclass', $district);
        // $this->load->view('../views/footer');
        $district['_view'] = 'backentry/BackEntryLandReclass';
        $this->load->view('layouts/main',$district);
    }

    public function BackEntryLandReclassificationSubmit1() {
        //var_dump($this->input->post());
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('circle_code');
        $mouza_pargona_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');
        $case_no = $this->input->post('case_no') . "/RECLASS-BL";

        $dag_no = $this->input->post('dag_no');
        $patta_no = trim($this->input->post('patta_no'));

        $this->db->trans_begin();

        $petition_no = $this->db->query("select max(proposal_no) as count from t_reclassification")->row()->count;
//        echo "select max(proposal_no) as count from t_reclassification where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and "
//                . "cir_code = '$cir_code' and date(lm_date) >='$define_date'";
        if ($petition_no == null) {
            $petition_no = 1;
        } else {
            $petition_no+=1;
        }


        $t_reclassification = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_code,
            'proposal_no' => $petition_no,
            'dag_no' => $this->input->post('dag_no'),
            'patta_no' => trim($this->input->post('patta_no')),
            'patta_type_code' => $this->input->post('patta_type'),
            'present_land_class' => $this->input->post('land_class'),
            'present_land_revenue' => $this->input->post('land_rev'),
            'present_land_localtax' => $this->input->post('loc_tax'),
            'present_total_revenue' => $this->input->post('tot_rev'),
            'new_landuse_year' => $this->input->post('new_landuse_year'),
            'dag_area_b' => $this->input->post('dag_area_b'),
            'dag_area_k' => $this->input->post('dag_area_k'),
            'dag_area_lc' => $this->input->post('dag_area_lc'),
            'dag_area_g' => $this->input->post('dag_area_g'),
            'dag_area_kr' => $this->input->post('dag_area_kr'),
            'proposed_land_class' => $this->input->post('new_land_class'),
            'proposed_land_revenue' => $this->input->post('P_land_rev'),
            'proposed_land_localtax' => $this->input->post('p_local_tax'),
            'revenue_diff' => $this->input->post('Rev_diff'),
            'lm_code' => $this->input->post('lm_code'),
            'lm_yn' => 'Y',
            'lm_date' => date('Y-m-d G:i:s'),
            'case_no' => $case_no,
            'co_yn' => $this->input->post('coSign'),
            'co_date' => $this->input->post('co_date'),
            'dc_yn' => $this->input->post('dcSign'),
            'dc_date' => $this->input->post('dc_date'),
            'dc_approval_date' => $this->input->post('dc_date'),
        );
        //var_dump($t_reclassification);
        $this->db->insert('t_reclassification', $t_reclassification);
        $q = "select * from t_reclassification where case_no = '$case_no' and proposal_no = '$petition_no'";
        //echo $q;
        $details = $this->db->query($q)->row();

        $old_patta = $this->db->query("select * from patta_code where type_code = '$details->patta_type_code' ")->row();
        $old_land_class = $this->db->query("select * from landclass_code where class_code = '$details->present_land_class' ")->row();
        $proposed_land_class = $this->db->query("select * from landclass_code where class_code = '$details->proposed_land_class' ")->row();

        $data['det'] = array(
            'patta_type' => $old_patta->patta_type,
            'old_land_class' => $old_land_class->land_type,
            'proposed_land_class' => $proposed_land_class->land_type,
            'case_no' => $case_no,
            'proposal_no' => $petition_no
        );

        $data['Pcases'] = $details;
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo "Error Occured";
        } else {
            $this->db->trans_commit();
            // $this->load->helper('html');
            // $this->load->view('../views/header');
            // $this->load->view('../views/backentry/BackEntryLandReclassConfirm', $data);
            // $this->load->view('../views/footer');
            $data['_view'] = 'backentry/BackEntryLandReclassConfirm';
            $this->load->view('layouts/main',$data);
        }
    }

    // public function SaveLandReclassification() {
    //     $co_chitha_updated_date = date('Y-m-d G:i:s');
    //     $case_no = $this->input->GET('case_no');
    //     $proposal_no = $this->input->GET('proposal_no');
    //     $user_code = $this->session->userdata('user_code');

    //     $this->db->trans_begin();

    //     $q = "select * from t_reclassification where case_no = '$case_no' and proposal_no = '$proposal_no'";
    //     $ord = $this->db->query($q)->row();

    //     $data['Pcases'] = $ord;

    //     $check = "Select * from chitha_rmk_reclassification where dist_code = '$ord->dist_code' and subdiv_code = '$ord->subdiv_code' and cir_code = '$ord->cir_code'"
    //         . "and mouza_pargona_code = '$ord->mouza_pargona_code' and vill_townprt_code = '$ord->vill_townprt_code' "
    //         . "and lot_no = '$ord->lot_no' and dag_no = '$ord->dag_no'";

    //     $check_presence = $this->db->query($check)->row();
    //     if ($check_presence == null) {
    //         $rmk_gen = array(
    //             'dist_code' => $ord->dist_code,
    //             'subdiv_code' => $ord->subdiv_code,
    //             'cir_code' => $ord->cir_code,
    //             'mouza_pargona_code' => $ord->mouza_pargona_code,
    //             'vill_townprt_code' => $ord->vill_townprt_code,
    //             'lot_no' => $ord->lot_no,
    //             'dag_no' => $ord->dag_no,
    //             'rmk_type_code' => '08',
    //             'rmk_type_hist_no' => '01',
    //             'user_code' => $user_code,
    //             'operation' => 'E',
    //             'date_entry' => date('Y-m-d G:i:s'),
    //             'jama_updated' => ' '
    //         );
    //         $this->db->insert('chitha_rmk_gen', $rmk_gen); //*********************
    //     } else {
    //         $chitha_rmk_reclassification_delete = "DELETE FROM chitha_rmk_reclassification where dist_code = '$ord->dist_code' and subdiv_code = '$ord->subdiv_code' and cir_code = '$ord->cir_code'"
    //             . "and mouza_pargona_code = '$ord->mouza_pargona_code' and vill_townprt_code = '$ord->vill_townprt_code' "
    //             . "and lot_no = '$ord->lot_no' and dag_no = '$ord->dag_no'";
    //         $this->db->query($chitha_rmk_reclassification_delete); //*********************
    //     }

    //     $chitha_rmk_reclassification = array(
    //         'dist_code' => $ord->dist_code,
    //         'subdiv_code' => $ord->subdiv_code,
    //         'cir_code' => $ord->cir_code,
    //         'mouza_pargona_code' => $ord->mouza_pargona_code,
    //         'lot_no' => $ord->lot_no,
    //         'vill_townprt_code' => $ord->vill_townprt_code,
    //         'proposal_no' => $proposal_no,
    //         'dag_no' => $ord->dag_no,
    //         'patta_no' => trim($ord->patta_no),
    //         'patta_type_code' => $ord->patta_type_code,
    //         'present_land_class' => $ord->present_land_class,
    //         'present_land_revenue' => $ord->present_land_revenue,
    //         'present_land_localtax' => $ord->present_land_localtax,
    //         'present_total_revenue' => $ord->present_total_revenue,
    //         'new_landuse_year' => $ord->new_landuse_year,
    //         'dag_area_b' => $ord->dag_area_b,
    //         'dag_area_k' => $ord->dag_area_k,
    //         'dag_area_lc' => $ord->dag_area_lc,
    //         'dag_area_g' => $ord->dag_area_g,
    //         'dag_area_kr' => $ord->dag_area_kr,
    //         'proposed_land_class' => $ord->proposed_land_class,
    //         'proposed_land_revenue' => $ord->proposed_land_revenue,
    //         'proposed_land_localtax' => $ord->proposed_land_localtax,
    //         'revenue_diff' => $ord->revenue_diff,
    //         'lm_code' => $ord->lm_code,
    //         'lm_yn' => $ord->lm_yn,
    //         'lm_date' => $ord->lm_date,
    //         'case_no' => $case_no,
    //         'co_recommendation' => $ord->co_recommendation,
    //         'co_recom_date' => $ord->co_recom_date,
    //         'co_yn' => $ord->co_yn,
    //         'co_date' => $ord->co_date,
    //         'dc_approval' => $ord->dc_approval,
    //         'dc_approval_date' => $ord->dc_approval_date,
    //         'dc_yn' => $ord->dc_yn,
    //         'dc_date' => $ord->dc_date,
    //         'rkg_chitha_updated_yn' => 'Y',
    //         'rkg_chitha_updated_date' => $co_chitha_updated_date,
    //         //'rkg_transmit_yn' => '',
    //         'co_chitha_updated_yn' => 'Y',
    //         'co_chitha_updated_date' => $co_chitha_updated_date
    //         //'make_mdb' => ord->,
    //     );
    //     //var_dump($chitha_rmk_reclassification);
    //     $this->db->insert('chitha_rmk_reclassification', $chitha_rmk_reclassification); //*********************


    //     $chitha_update = "update chitha_basic set land_class_code='$ord->proposed_land_class',dag_revenue='$ord->proposed_land_revenue',"
    //         . " dag_local_tax='$ord->proposed_land_localtax',jama_yn=' ' where dist_code='$ord->dist_code' and"
    //         . " subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
    //         . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
    //         . " vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no'  "
    //         . " and TRIM(patta_no)=trim('$ord->patta_no') and patta_type_code='$ord->patta_type_code'";

    //     $this->db->query($chitha_update);  //*********************


    //     $this->db->query("UPDATE t_reclassification SET co_chitha_updated_yn = 'Y', co_chitha_updated_date = '$co_chitha_updated_date',"
    //         . "rkg_chitha_updated_yn = 'Y', rkg_chitha_updated_date = '$co_chitha_updated_date' WHERE case_no = '$case_no' and  proposal_no = '$proposal_no'");

    //     if ($this->db->trans_status() === FALSE) {
    //         $this->db->trans_rollback();
    //         echo "Error Occured";
    //     } else {
    //         $this->db->trans_commit();
    //         // $this->load->helper('html');
    //         // $this->load->view('../views/header');
    //         // $this->load->view('../views/backentry/ReclassFinalReport', $data);
    //         // $this->load->view('../views/footer');
    //         $data['_view'] = 'backentry/ReclassFinalReport';
    //         $this->load->view('layouts/main',$data);
    //     }
    // }
    function modifyserial(){
        $this->load->model('mutation/mutationmodel');
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $circle_code = $this->input->post('circle_code');
            $mouza_pargona_code = $this->input->post('mouza_code');
            $lot_no = $this->input->post('lot_no');
            $vill_townprtcode = $this->input->post('vill_code');
            $patta_type_code = $this->input->post('patta_type_code');
            $patta_no = $this->input->post('patta_no');
            $location = array(
                'dist_code' => $dist_code, 'subdiv_code' => $subdiv_code,
                'cir_code' => $circle_code, 'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no, 'vill_code' => $vill_townprtcode,'patta_code'=>$patta_type_code,'patta_no'=>$patta_no
            );
            $this->session->set_userdata($location);
            //var_dump($location);
            redirect(base_url() . "index.php/utility/pattadarserial");
        } else {
            //$this->load->helper('html');
            //$this->load->view('../views/header');
            $data = $this->mutationmodel->getDistricts();
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $district['mouza'] = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
            $villages = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no);
            $district['d'] = $dist_code;
            $district['s'] = $subdiv_code;
            $district['c'] = $cir_code;
            $district['m'] = $mouza_code;
            $district['l'] = $lot_no;
            $district['village'] = $villages;

            $patta_types = $this->db->query("select type_code,patta_type from patta_code where jamabandi='y'")->result();
            $district['patta_types'] = $patta_types;
            //$this->load->view('../views/utility/index', $district);
            //$this->load->view('../views/footer');
            $district['_view'] = 'utility/index';
            $this->load->view('layouts/main',$district);
        }
    }
    function pattadarserial(){
        //var_dump($this->session->all_userdata());
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $patta_no = $this->session->userdata('patta_no');
        $patta_code = $this->session->userdata('patta_code');

        $sql = "SELECT *
                FROM jama_pattadar
                WHERE dist_code = ?
                AND subdiv_code = ?
                AND cir_code = ?
                AND mouza_pargona_code = ?
                AND lot_no = ?
                AND vill_townprt_code = ?
                AND patta_type_code = ?
                AND patta_no = ?
                ORDER BY CAST(pdar_id AS INTEGER)";

        $params = array(
            $dist_code,
            $subdiv_code,
            $cir_code,
            $mouza_code,
            $lot_no,
            $vill_code,
            $patta_code,
            $patta_no
        );

        $data['pdarlist'] = $this->db->query($sql, $params)->result();

        //var_dump($data);
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/utility/listofpattadar', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'utility/listofpattadar';
        $this->load->view('layouts/main',$data);

    }
    function updatepattadarsl(){
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $patta_no = $this->session->userdata('patta_no');
        $patta_code = $this->session->userdata('patta_code');
        $pdar_sl_no=$this->input->post('pdar_sl_no');
        //var_dump($pdar_sl_no);
        foreach($pdar_sl_no as $p=>$val){
            //	var_dump($val);
            $sql = "UPDATE jama_pattadar
                    SET pdar_sl_no = ?, entry_mode = 'P'
                    WHERE dist_code = ?
                    AND subdiv_code = ?
                    AND cir_code = ?
                    AND mouza_pargona_code = ?
                    AND lot_no = ?
                    AND vill_townprt_code = ?
                    AND patta_type_code = ?
                    AND patta_no = ?
                    AND pdar_id = ?";

            $params = array(
                $val[0],        // pdar_sl_no
                $dist_code,
                $subdiv_code,
                $cir_code,
                $mouza_code,
                $lot_no,
                $vill_code,
                $patta_code,
                $patta_no,
                $p              // pdar_id
            );

            $this->db->query($sql, $params);

        }
        redirect('/utility/pattadarserial');
    }
    // function dhemaji(){
    //     $sql="select * from jama_dag where subdiv_code='01' and cir_code='02' and mouza_pargona_code='01' and lot_no='08' and vill_townprt_code='10002' and patta_no='113'";
    //     $data=$this->db->query($sql)->row_array();
    //     $data['dag_no']='449';
    //      $data['patta_no']='101';
    //     $data['dag_class_code']='0104';
    //     $data['dag_area_b']='1';
    //     $data['dag_area_k']='1';
    //     $data['dag_area_lc']='0';
    //     $data['dag_revenue']='24.00';
    //     //$data['dag_localtax']=
    //     var_dump($data);
    //     echo $this->db->insert('jama_dag',$data);
    // }

}
