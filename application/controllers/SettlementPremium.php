<?php
class SettlementPremium extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('patta/pattamodel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->model('basundhara/SettlementApiModel');
        $this->load->model('rtps/rtpsmodel');
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('SettlementModel/SettlementKhasModel');
        $this->load->model('SettlementModel/SettlementVgrModel');
        $this->load->model('UtilsModel');
        $this->dbswitch();


        if(HOLD_All_MB2_CASES_STATUS == 1)
        {
            if(strtotime(HOLD_All_MB2_CASES_DATE) < strtotime(date('Y-m-d H:i:s')))
            {
                $this->session->set_flashdata('message', " Processing of settlement MB 2.0 Cases has been stopped !");
                redirect(base_url() . "index.php/Home/index");
            }
        }
    }

    public function dbswitch()
    {
        //$CI=&get_instance();
        if ($this->session->userdata('dist_code') == "02") {
            $this->db = $this->load->database('dha3', true);
        } else if ($this->session->userdata('dist_code') == "05") {
            $this->db = $this->load->database('dha1', true);
        } else if ($this->session->userdata('dist_code') == "10") {
            $this->db = $this->load->database('dha24', true);
        } else if ($this->session->userdata('dist_code') == "13") {
            $this->db = $this->load->database('dha2', true);
        } else if ($this->session->userdata('dist_code') == "17") {
            $this->db = $this->load->database('dha4', true);
        } else if ($this->session->userdata('dist_code') == "15") {
            $this->db = $this->load->database('dha5', true);
        } else if ($this->session->userdata('dist_code') == "14") {
            $this->db = $this->load->database('dha6', true);
        } else if ($this->session->userdata('dist_code') == "07") {
            $this->db = $this->load->database('dha7', true);
        } else if ($this->session->userdata('dist_code') == "03") {
            $this->db = $this->load->database('dha8', true);
        } else if ($this->session->userdata('dist_code') == "18") {
            $this->db = $this->load->database('dha9', true);
        } else if ($this->session->userdata('dist_code') == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($this->session->userdata('dist_code') == "24") {
            $this->db = $this->load->database('dha10', true);
        } else if ($this->session->userdata('dist_code') == "06") {
            $this->db = $this->load->database('dha11', true);
        } else if ($this->session->userdata('dist_code') == "11") {
            $this->db = $this->load->database('dha12', true);
        } else if ($this->session->userdata('dist_code') == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($this->session->userdata('dist_code') == "16") {
            $this->db = $this->load->database('dha14', true);
        } else if ($this->session->userdata('dist_code') == "32") {
            $this->db = $this->load->database('dha15', true);
        } else if ($this->session->userdata('dist_code') == "33") {
            $this->db = $this->load->database('dha16', true);
        } else if ($this->session->userdata('dist_code') == "34") {
            $this->db = $this->load->database('dha17', true);
        } else if ($this->session->userdata('dist_code') == "21") {
            $this->db = $this->load->database('dha18', true);
        } else if ($this->session->userdata('dist_code') == "08") {
            $this->db = $this->load->database('dha19', true);
        } else if ($this->session->userdata('dist_code') == "35") {
            $this->db = $this->load->database('dha20', true);
        } else if ($this->session->userdata('dist_code') == "36") {
            $this->db = $this->load->database('dha21', true);
        } else if ($this->session->userdata('dist_code') == "37") {
            $this->db = $this->load->database('dha22', true);
        } else if ($this->session->userdata('dist_code') == "25") {
            $this->db = $this->load->database('dha23', true);
        } else if ($this->session->userdata('dist_code') == "39") {
            $this->db = $this->load->database('dha39', true);
        } else if ($this->session->userdata('dist_code') == "38") {
            $this->db = $this->load->database('dha25', true);
        }
    }

    public function viewLand()
    {
        // $GET['id']=1;
        $sql = "SELECT * FROM settlement_premium_land_type
      WHERE paid=1";

        $result = $this->db->query($sql)->result_array();
        // var_dump($result);
        // var_dump($result['plid']); die();


        $json = [];
        while($row = $result){
            $json[$row['0']['plid']] = $row['0']['land_type'];
        }
        // $json=$result;
        echo json_encode($json);
    }

    public function getLand($area)
    {

        $lands = $this->db->query("select * from settlement_premium_land_type where paid='$area' order by plid ");

        $data = $lands->result();
        $json = array();
        foreach ($data as $object) {
            $json[] = array('plid' => trim($object->plid), 'land_type' => trim($object->land_type));
        }
        //var_dump($json);
        echo json_encode($json);
    }

    public function getType($area)
    {

        $lands = $this->db->query("select * from settlement_premium_rate 
      where plid='$area' order by prid ");

        $data = $lands->result();
        $json = array();
        foreach ($data as $object) {
            $json[] = array('prid' => trim($object->prid), 'house_type' => trim($object->house_type));
        }
        //var_dump($json);
        echo json_encode($json);
    }

    public function getRate($prid)
    {

        $lands = $this->db->query("select prid,rate,rate_type,mb_land,max_land,approval from settlement_premium_rate 
        where prid='$prid' order by prid ");

        $data = $lands->result();
        $json = array();
        foreach ($data as $object) {
            $json[] = array('prid' => trim($object->prid), 'rate' => trim($object->rate), 'rate_type' => trim($object->rate_type), 'mb_land' => trim($object->mb_land), 'max_land' => trim($object->max_land), 'approval' => trim($object->approval));
        }
        //var_dump($json);
        echo json_encode($json);
    }

    public function getRateV2($prid)
    {

        $lands = $this->db->query("select prid,rate_v2 as rate,rate_type,mb_land,max_land,approval from settlement_premium_rate 
        where prid='$prid' order by prid ");

        $data = $lands->result();
        $json = array();
        foreach ($data as $object) {
            $json[] = array('prid' => trim($object->prid), 'rate' => trim($object->rate), 'rate_type' => trim($object->rate_type), 'mb_land' => trim($object->mb_land), 'max_land' => trim($object->max_land), 'approval' => trim($object->approval));
        }
        //var_dump($json);
        echo json_encode($json);
    }


}
