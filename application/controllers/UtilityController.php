<?php
class UtilityController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
        $this->load->model('jamabandi/JamabandiModel');
    }
    public function SelectLocationForSthalatLagat() {
        $this->load->helper('html');
        $this->load->view('header');
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
        $district['patta'] = $this->JamabandiModel->getPattaType();
        $this->load->view('utility/select_location_for_SthalatLagat', $district);
        $this->load->view('footer');
    }
    public function urbanRuralLocation(){
        $sql="Select loc_name,vill_townprt_code from location  ";
        $district['list']=$this->db->query($sql)->result_array();
        $district['_view'] = 'utility/locationRuralUrban';
        $this->load->view('layouts/main',$district);
    }
    public function urbanRuralUpdate(){
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->input->post('circle_code');
        $mouza_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        $sql="Select loc_name,vill_townprt_code,dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,rural_urban from location where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code!='00000' ";
        $district['list']=$this->db->query($sql)->result_array();
        $district['_view'] = 'utility/ruralurban';
        $this->load->view('layouts/main',$district);
    }
    function urbanRuralpost(){
        $dist_code=$this->input->post('dist_code');
        $subdiv_code=$this->input->post('subdiv_code');
        $cir_code=$this->input->post('cir_code');
        $mouza_pargona_code=$this->input->post('mouza_pargona_code');
        $lot_no=$this->input->post('lot_no');
        $vill_townprt_code=$this->input->post('vill_townprt_code');
        $village=$this->input->post('village');
        for($i=0;$i<sizeof($village);$i++){
            $village[$i];
            $vill_townprt_code[$i];
            $sql="Update location set rural_urban='$village[$i]' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code[$i]' ";
            $this->db->query($sql);
        }
        redirect('/home');
    }
    function Proinsert(){
        //////////////////////////////
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        //$case_no="MET/DIS/2021-22/48039/OMUT";
        $sql="select case_no,next_date_of_hearing,dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,add_off_name from petition_basic where next_date_of_hearing is not null and status='P' and mut_type='03' and case_no not in (select case_no from petition_proceeding )";
        $data=$this->db->query($sql)->result_array();
        //var_dump($data);
        if($data){
            foreach($data as $r){
                $pid =1;// $this->db->query($q)->row();
                $next_date_input=$r['next_date_of_hearing'];
                //আবেদনকাৰীয়ে বেলতলা মৌজা ৰ নৰকাসুৰ গাৱৰ মাটিত নামজাৰী বিচাৰিছে |
                $mouza=$this->utilityclass->getMouzaName($r['dist_code'],$r['subdiv_code'],$r['cir_code'],$r['mouza_pargona_code']);
                $vill=$this->utilityclass->getVillageName($r['dist_code'],$r['subdiv_code'],$r['cir_code'],$r['mouza_pargona_code'],$r['lot_no'],$r['vill_townprt_code']);
                $COorder = "আবেদনকাৰীৰ নামজাৰী আৱেদন চোৱা হল ।আবেদনকাৰীয়ে $mouza মৌজা ৰ $vill গাৱৰ মাটিত নামজাৰী বিচাৰিছে | ভূমিলেখ্য সহায়ক আৰু ভূমিলেখ্য পৰ্যবেক্ষক ই চৰজমিন কৰি দখল আৰু বিবাদ সম্পৰ্কে বিতং প্রতিবেদন দাখিল কৰিব |$next_date_input তাৰিখ শুনানি আৰু আপত্তি দাখিলৰ বাবে ধাৰ্য্য হ'ল । ";
                //$find = 'dateName';
                $COorder = addslashes($COorder);
                $values = array(
                    'case_no' => $r['case_no'],
                    'proceeding_id' => $pid,
                    'date_of_hearing' => $next_date_input,
                    'co_order' => $COorder,
                    'next_date_of_hearing' => $next_date_input,
                    'status' => 'Pending',
                    'user_code' => $r['add_off_name'],
                    'date_entry' =>$next_date_input ,
                    'operation' => 'E',
                    'dist_code' => $r['dist_code'],
                    'subdiv_code' => $r['subdiv_code'],
                    'cir_code' => $r['cir_code']
                );
                ///var_dump($values);
                echo "<br>";
                $this->db->insert("petition_proceeding", $values);
            }
        }else{
            echo "No Data left";
        }

    }
}
