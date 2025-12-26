<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MiscController extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function getFieldMutationPetitions($d, $s, $c, $m, $l, $v) {
		$db=  $this->session->userdata('db');
        $query = "select * from    t_chitha_col8_order where"
                . " dist_code='$d' and cir_code='$c' and subdiv_code='$s' and mouza_pargona_code='$m' and"
                . " lot_no='$l' and vill_townprt_code='$v' and iscorrected_inco is null";


        $data = $this->db->query($query)->result();
        $json = array();
        foreach ($data as $d) {
            $json[] = array('petition' => $d->petition_no, 'dag' => $d->dag_no);
        }
        echo json_encode($json);
    }
    
    public function getPataType($pn) {
		$db=  $this->session->userdata('db');
        $location = $this->utilityclass->getLocationFromSession();
        $d = $location['dist_code'];
        $s = $location['subdiv_code'];
        $c = $location['cir_code'];
        $l = $location['lot_no'];
        $m = $location['mouza_pargona_code'];
        $v = $location['vill_townprt_code'];
        $query = "select type_code,patta_type from    patta_code where type_code in (select patta_type_code from    chitha_basic 
                    where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and
                    mouza_pargona_code='$m' and lot_no='$l' and vill_townprt_code='$v' and TRIM(patta_no)=trim('$pn'))";
       
        if (sizeof($this->db->query($query)->row()) == 0) {
            $json = array(
                'status' => FALSE
            );
            echo json_encode($json);
        } else {
            $json= array();
            $result = $this->db->query($query)->result();
            foreach ($result as $r) {
                $json[] = array(
                    'patta_type' => $this->db->query($query)->row()->patta_type,
                    'patta_code' => $this->db->query($query)->row()->type_code,
                    'status' => TRUE
                );
            }
            echo json_encode($json);
        }
    }

    public function dagExists($dag_no) {
		$db=  $this->session->userdata('db');
        $location = $this->utilityclass->getLocationFromSession();
        $d = $location['dist_code'];
        $s = $location['subdiv_code'];
        $c = $location['cir_code'];
        $l = $location['lot_no'];
        $m = $location['mouza_pargona_code'];
        $v = $location['vill_townprt_code'];
        $patta_no = trim($this->session->userdata('patta_no'));
        $query = "select *  from    chitha_basic 
                    where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and
                    mouza_pargona_code='$m' and lot_no='$l' and vill_townprt_code='$v' "
                . " and TRIM(patta_no)='$patta_no' and dag_no='$dag_no'";

        $count = $this->db->query($query)->row();

        if (sizeof($count) == 1) {
            $json = array(
                'status' => TRUE,
                'bigha' => $count->dag_area_b,
                'katha' => $count->dag_area_k,
                'lessa' => $count->dag_area_lc,
            );
            echo json_encode($json);
        } else {
            $json = array(
                'status' => FALSE
            );
            echo json_encode($json);
        }
    }

}
