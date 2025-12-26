<?php

ini_set('memory_limit', '-1');

class ReportController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ReportModel');
    }

    public function dbswitch($dist_code)
    {
        //$CI=&get_instance();
        if ($dist_code == "02") {
            $this->db = $this->load->database('dha3', true);
        } else if ($dist_code == "05") {
            $this->db = $this->load->database('dha1', true);
        } else if ($dist_code == "10") {
            $this->db = $this->load->database('dha24', true);
        } else if ($dist_code == "13") {
            $this->db = $this->load->database('dha2', true);
        } else if ($dist_code == "17") {
            $this->db = $this->load->database('dha4', true);
        } else if ($dist_code == "15") {
            $this->db = $this->load->database('dha5', true);
        } else if ($dist_code == "14") {
            $this->db = $this->load->database('dha6', true);
        } else if ($dist_code == "07") {
            $this->db = $this->load->database('dha7', true);
        } else if ($dist_code == "03") {
            $this->db = $this->load->database('dha8', true);
        } else if ($dist_code == "18") {
            $this->db = $this->load->database('dha9', true);
        } else if ($dist_code == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($dist_code == "24") {
            $this->db = $this->load->database('dha10', true);
        } else if ($dist_code == "06") {
            $this->db = $this->load->database('dha11', true);
        } else if ($dist_code == "11") {
            $this->db = $this->load->database('dha12', true);
        } else if ($dist_code == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($dist_code == "16") {
            $this->db = $this->load->database('dha14', true);
        } else if ($dist_code == "32") {
            $this->db = $this->load->database('dha15', true);
        } else if ($dist_code == "33") {
            $this->db = $this->load->database('dha16', true);
        } else if ($dist_code == "34") {
            $this->db = $this->load->database('dha17', true);
        } else if ($dist_code == "21") {
            $this->db = $this->load->database('dha18', true);
        } else if ($dist_code == "08") {
            $this->db = $this->load->database('dha19', true);
        } else if ($dist_code == "35") {
            $this->db = $this->load->database('dha20', true);
        } else if ($dist_code == "36") {
            $this->db = $this->load->database('dha21', true);
        } else if ($dist_code == "37") {
            $this->db = $this->load->database('dha22', true);
        } else if ($dist_code == "25") {
            $this->db = $this->load->database('dha23', true);
        } else if ($dist_code == "39") {
            $this->db = $this->load->database('dha39', true);
        } else if ($dist_code == "38") {
            $this->db = $this->load->database('dha25', true);
        }
    }

    public function index(){
        $data['_view'] = 'Report/index.php';
        $this->load->view('layouts/main',$data);
    }

    public function BariExport()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        // var_dump($this->session->userdata);die;
        $sql = "
            select  
            (select loc_name from location where dist_code=cbm.dist_code and	subdiv_code='00') as district_name, 
            (select loc_name from location where dist_code=cbm.dist_code and	subdiv_code=cbm.subdiv_code and	cir_code='00') as subdiv_name, 
            (select loc_name from location where dist_code=cbm.dist_code and	subdiv_code=cbm.subdiv_code and	cir_code=cbm.cir_code and	mouza_pargona_code='00') as circle_name, 
            (select loc_name from location where dist_code=cbm.dist_code and	subdiv_code=cbm.subdiv_code and	cir_code=cbm.cir_code and	mouza_pargona_code=cbm.mouza_pargona_code
            and lot_no='00') as mouza_name, 
            (select loc_name from location where dist_code=cbm.dist_code and	subdiv_code=cbm.subdiv_code and	cir_code=cbm.cir_code and	mouza_pargona_code=cbm.mouza_pargona_code
            and lot_no=cbm.lot_no and	vill_townprt_code='00000') as lot_no, 
            (select loc_name from location where dist_code=cbm.dist_code and	subdiv_code=cbm.subdiv_code and	cir_code=cbm.cir_code and	mouza_pargona_code=cbm.mouza_pargona_code
            and lot_no=cbm.lot_no and	vill_townprt_code=cbm.vill_townprt_code) as village_name, 
            cbm.dag_no, cpm.pdar_name, cpm.pdar_father
            from chitha_basic_mat_view cbm
            JOIN chitha_pattadars_mat_view cpm on 
            cbm.uuid = cpm.uuid and cbm.dag_no = cpm.dag_no
            where EXISTS (
                SELECT 1 FROM landclass_code lc
                WHERE lc.class_code = cbm.land_class_code AND (lc.land_type like 'বাৰী%' or lc.land_type like 'বাড়ী%') )
                AND uuid = '10000000003804'
            and cbm.rural_urban='R'
        ";


        
        $conditions = [];
        if (!empty($dist_code)) {
            $conditions[] = "cbm.dist_code = " . $this->db->escape($dist_code);
        }
        if (!empty($subdiv_code) && $subdiv_code !='00') {
            $conditions[] = "cbm.subdiv_code = " . $this->db->escape($subdiv_code);
        }
        if (!empty($cir_code) && $cir_code !='00') {
            $conditions[] = "cbm.cir_code = " . $this->db->escape($cir_code);
        }
        if (!empty($conditions)) {
            $sql .= " AND " . implode(" AND ", $conditions);
        }
        $data = $this->db->query($sql)->result_array();

        if (empty($data)) {
            $data[] = ['Message' => 'No Record Found'];
        }

        $time = date("d-M-Y-h-i-s-A");
        $file_name = $this->session->userdata('user_desig_code')."Village-Wise-Report(".$time.").xlsx";
        $this->load->model('UtilsModel');
        $this->UtilsModel->downloadExcelReport($file_name,$data);
        die;
    }



    public function pattadarReport(){
        set_time_limit(0);
        $sql=$this->ReportModel->PattadarSQL();
        $data['records'] = $this->db->query($sql)->result();
        $data['_view'] = 'Report/pattadarReport.php';
        $this->load->view('layouts/main',$data);
    }

    function PattadarDetails() {
        $uuid = $this->input->get('uuid');
        $sql = $this->ReportModel->PattadarDetailsSQL();
        $data['records'] = $this->db->query($sql, [$uuid, $uuid])->result();
        $data['uuid'] = $uuid;
        $data['_view'] = 'Report/pattadarDetailsReport.php';
        $this->load->view('layouts/main', $data);
    }


    public function downloadExcel(){
        $perm = $this->input->get('perm');
        $time = date("d-M-Y-h-i-s-A");
        $file_name = "Excel-Report-".$time.".xlsx";
        if($perm=="pattadar"){
            $sql=$this->ReportModel->PattadarSQL();
            $data = $this->db->query($sql)->result_array();
        }else if ($perm=="pattadar-details"){
            $uuid = $this->input->get('uuid');
            $sql = $this->ReportModel->PattadarDetailsSQL();
            $data=  $this->db->query($sql, [$uuid, $uuid])->result();
        }
        $this->load->model('UtilsModel');
        $this->UtilsModel->downloadExcelReport($file_name,$data);
    }

}
