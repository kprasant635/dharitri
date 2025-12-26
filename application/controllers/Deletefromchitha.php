<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Deletefromchitha extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        // $this->load->library('controllerlist');
        $this->load->model('mutation/mutationmodel');
        ini_set('max_execution_time', 0);
        $this->load->model('mutation/mutationmodel');
        $this->load->model('conversion/ASTofficeConversionModel');
        $this->load->model('conversion/CoofficeConversionModel');
        $this->load->helper(array('form', 'url'));
    }

    // public function index() {
    // $this->load->helper('html');
    // $this->load->view('../views/header');
    // $data = $this->mutationmodel->getDistricts();
    // $dist_code = $this->session->userdata('dist_code');
    // $subdiv_code = $this->session->userdata('subdiv_code');
    // $cir_code = $this->session->userdata('cir_code');
    // $q="Select pb.dist_code,pb.subdiv_code,pb.cir_code,pb.mouza_pargona_code,pb.lot_no,pb.vill_townprt_code,pd.date_entry,pd.dag_no,pd.patta_no,pd.patta_type_code,pb.case_no,pb.mut_type from    petition_basic as pb join petition_dag_details as pd on pb.dist_code=pd.dist_code and pd.subdiv_code=pd.subdiv_code 
// and pb.cir_code=pd.cir_code where pb.status='P' and pb.order_passed is null and pb.dist_code='$dist_code' and pb.subdiv_code='$subdiv_code'  and pb.cir_code='$cir_code' and pb.petition_no=pd.petition_no ";
    // $op=$this->db->query($q)->result();
    // //var_dump($op);
    // $fq="Select fb.dist_code,fb.subdiv_code,fb.cir_code,fb.mouza_pargona_code,fb.lot_no,fb.vill_townprt_code,fd.date_entry,fd.dag_no,fd.patta_no,fd.patta_type_code,fb.case_no from    field_mut_basic as fb join  field_mut_dag_details as fd 
    // on fb.dist_code=fd.dist_code and fb.subdiv_code=fd.subdiv_code and fb.cir_code=fd.cir_code where fb.order_passed is null and fb.case_no=fd.case_no and fb.dist_code='$dist_code' and fb.subdiv_code='$subdiv_code' and fb.cir_code='$cir_code'  ";
    // $fp=$this->db->query($fq)->result();
    // // $fq="Select fb.dist_code,fb.subdiv_code,fb.cir_code,fb.mouza_pargona_code,fb.lot_no,fb.vill_townprt_code,fd.date_entry,fd.dag_no,fd.patta_no,fd.patta_type_code,fb.case_no from    field_mut_basic as fb join  field_mut_dag_details as fd 
    // // on fb.dist_code=fd.dist_code and fb.subdiv_code=fd.subdiv_code and fb.cir_code=fd.cir_code where fb.order_passed is null and fb.dist_code='$dist_code' and fb.subdiv_code='$subdiv_code' and fb.cir_code='$cir_code' ";
    // // $fp=$this->db->query($fq)->result();
    // $data['office']=array_merge($op,$fp);
    // $this->load->view('../views/delete/running', $data);
    // $this->load->view('../views/footer');
    // }
    // public function iindex() {
    // $this->load->helper('html');
    // $this->load->view('../views/header');
    // $data = $this->mutationmodel->getDistricts();
    // $dist_code = $this->session->userdata('dist_code');
    // $subdiv_code = $this->session->userdata('subdiv_code');
    // $cir_code = $this->session->userdata('cir_code');
    // $mouzas = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
    // $district['d'] = $dist_code;
    // $district['s'] = $subdiv_code;
    // $district['c'] = $cir_code;
    // $district['mouzas'] = $mouzas;
    // // $this->load->view('../views/delete/index', $district);
    // $this->load->view('../views/footer');
    // }
    // function action() {
    // $dist = "NLB";
    // $dist_code = $this->session->userdata('dist_code');
    // $subdiv_code = $this->session->userdata('subdiv_code');
    // $q = "Update location set dist_abbr='$dist' where dist_code!='00'  ";
    // $this->db->query($q);
    // $q = "select cir_code,subdiv_code,locname_eng from    location where cir_code!='00' and mouza_pargona_code='00'";
    // $result = $this->db->query($q)->result();
    // //var_dump($result);
    // foreach ($result as $r) {
    // //$q
    // $cir_name = substr($r->locname_eng, 0, 3);
    // $q = "Update location set cir_abbr='$cir_name' where cir_code='$r->cir_code' and subdiv_code='$r->subdiv_code' ";
    // $this->db->query($q);
    // }
    // }
    // function duplicate(){
    // for($i=1;$i<=10;$i++){
    // $q="INSERT INTO cert_application(
    // dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, 
    // vill_townprt_code, cert_type, appln_no, cert_no, year_no, fee_amount, 
    // patta_no, patta_type_code, pdar_id, appln_name, appln_guard, 
    // guard_reln)
    // VALUES ('14','02','02','02','01','10001','02','LH/$i/2017','GOL/KHU/LH/$i/2017','2017',20.00,'66','0201',2,'Duplicate Entry','Duplicate','f')";
    // //echo $this->db->query($q);
    // }
    // }
    // function landclassdata(){
    // $q="SElect class_code,land_type from    landclass_code";
    // $data=$this->db->query($q)->result();
    // foreach($data as $c){
    // $q="Select sum(dag_area_b) as b,sum(dag_area_k) as k,sum(dag_area_lc) as l from    chitha_basic where land_class_code='$c->class_code'";
    // $result=$this->db->query($q)->row();
    // $tlessa=$this->utilityclass->Total_Lessa($result->b,$result->k,$result->l);
    // $data=$this->utilityclass->Total_Bigha_Katha_Lessa($tlessa);
    // echo $c->land_type."<br>";
    // echo "<p>"."  Bigha-".$data[0]."  Katha  ".$data[1]."  Lessa  ".$data[2]."<p>";
    // echo "<br>";
    // }
    // }	
    // function pattadata(){
    // $q="SElect type_code,patta_type from    patta_code";
    // $data=$this->db->query($q)->result();
    // foreach($data as $c){
    // $q="Select sum(dag_area_b) as b,sum(dag_area_k) as k,sum(dag_area_lc) as l from    chitha_basic where patta_type_code='$c->type_code'";
    // $result=$this->db->query($q)->row();
    // $tlessa=$this->utilityclass->Total_Lessa($result->b,$result->k,$result->l);
    // $data=$this->utilityclass->Total_Bigha_Katha_Lessa($tlessa);
    // echo $c->patta_type."<br>";
    // echo "<p>"."  Bigha-".$data[0]."  Katha  ".$data[1]."  Lessa  ".$data[2]."<p>";
    // echo "<br>";
    // }
    // }
    function khatian(){
        $q="Select * from    chitha_tenant";
        $data=$this->db->query($q)->result();
        foreach($data as $d){
        $array=array(
        'id'=>$d->khatian_no,
        'dag_no'=>$d->dag_no,
        'dist_code'=>$d->dist_code,
        'subdiv_code'=>$d->subdiv_code,
        'cir_code'=>$d->cir_code,
        'mouza_pargona_code'=>$d->mouza_pargona_code,
        'lot_no'=>$d->lot_no,
        'vill_townprt_code'=>$d->vill_townprt_code,
        'length_posession'=>null,
        'paid_cash_kind'=>null,
        'payable_cash_kind'=>null,
        'tenant_status'=>null,
        'special_conditions'=>null,
        'remarks'=>null
        );
        $exists = $this->db->query("select count(*) as c from    khatian where dist_code='$d->dist_code' and subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code' and "
        . " mouza_pargona_code='$d->mouza_pargona_code' and lot_no='$d->lot_no' and vill_townprt_code='$d->vill_townprt_code' and id='$d->khatian_no' and dag_no='$d->dag_no' ")->row()->c;
        echo $exists;
        echo '<br>';
            if($exists==0){
                //$this->db->insert('khatian',$array);
            }
        }
    //var_dump($data);	
    }
    // function dispur(){
    // $j=3;
    // for($i=3268;$i<=3313;$i++){
    // $q="SElect case_no as c from    petition_basic where cir_code='06' and year_no='2018' and mut_type='03' and petition_no='$i' ";
    // $data=$this->db->query($q)->row();
    // if($data){
    // $j;
    // $case_no=$data->c;
    // $exp=explode("/",$case_no);
    // echo $newcase_no=$exp[0]."/".$exp[1]."/".$exp[2]."/".$j."/".$exp[4];
    // echo $result="Update petition_basic set case_no='$newcase_no' where case_no='$case_no' ";
    // $this->db->query($result);
    // echo "<br>";
    // $j++;
    // }
    // }
    //}
    // function dag_no(){
    // $i=1;
    // $q="SElect * from    chitha_basic where cir_code='04' and subdiv_code='01' and  mouza_pargona_code='04' and lot_no='09' and vill_townprt_code='10002'";
    // $data=$this->db->query($q)->result();
    // foreach($data as $row){
    // $row->dag_no_int;
    // if($row->dag_no_int==0){
    // echo $row->dag_no;
    // echo $dag_no_int=$row->dag_no."00";
    // echo "<br>";
    // echo $q="Update chitha_basic set dag_no_int='$dag_no_int' where cir_code='04' and subdiv_code='01' and  mouza_pargona_code='04' and lot_no='09' 
    // and vill_townprt_code='10002' and dag_no='$row->dag_no' and dag_no_int='0' ";
    // echo "<br>";
    // //$this->db->query($q);
    // $i++;
    // }
    // }
    // echo $i;	
    // }
    function all_tables() {
		 $db=  $this->session->userdata('db');
        $q = "SELECT table_name from    information_schema.tables where table_schema='public' ORDER BY table_name";
        $d = $this->db->query($q)->result();
        foreach ($d as $table) {
            $data['table'][$table->table_name] = $this->db->list_fields($table->table_name);
        }
        $this->load->view('../views/header');
        $this->load->view('../views/task/task', $data);
        $this->load->view('../views/footer');
    }

    function task_action() {
		 $db=  $this->session->userdata('db');
        //print_r($_POST);
        foreach ($_POST as $key => $value) {
            //$j=0;$l=0;
            $j = sizeof($value);
            for ($k = 0; $k < $j; $k++) {
                //echo $value[$k];
                $pk = "SELECT a.attname from      pg_index i JOIN   pg_attribute a ON a.attrelid = i.indrelid
                    AND a.attnum = ANY(i.indkey) WHERE  i.indrelid = '$value[$k]'::regclass
					AND i.indisprimary;";
                $result = $this->db->query($pk)->result();
                //var_dump($result);
                $l = sizeof($result);
                $result_query = "Select * from    $value[$k] where ";
                $result_query1 = "";
                for ($m = 0; $m < $l; $m++) {
                    //echo $result[$m];
                    $result_query1 = $result_query1 . $result[$m]->attname . "='' and ";
                    $final = $result_query . $result_query1;
                    //echo "<br>";
                }
                echo "<br>";
                echo $final;
                echo "<br>";
            }
        }
    }

    function delete_patta() {
		 $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $this->session->set_userdata(array('pattadar' => array()));
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
        //var_dump($district);
        $this->load->helper('html');
        $this->load->view('../views/header');
        $this->load->view('../views/delete/select_location_2', $district);
        $this->load->view('../views/footer');
    }

    function delete_all() {
		 $db=  $this->session->userdata('db');
        //var_dump($_POST);
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        $mouza_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');
        $patta_type = $this->input->post('patta_type');
        $patta_number = $this->input->post('patta_number');
        $delete_jama = "Delete from    jama_remark where dist_code='$dist_code' and subdiv_code='$subdiv_code' and 
		cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and 
		patta_type_code='$patta_type' and patta_no='$patta_number' ";
        $this->db->query($delete_jama);
        $delete_pattadar = "Delete from    jama_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and 
		cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and 
		patta_type_code='$patta_type' and patta_no='$patta_number' ";
        $this->db->query($delete_pattadar);
        $delete_dag = "Delete from    jama_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and 
		cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and 
		patta_type_code='$patta_type' and patta_no='$patta_number' ";
        $this->db->query($delete_dag);
        $delete_patta = "Delete from    jama_patta where dist_code='$dist_code' and subdiv_code='$subdiv_code' and 
		cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and 
		patta_type_code='$patta_type' and patta_no='$patta_number' ";
        $this->db->query($delete_patta);
        redirect(base_url() . 'index.php/Deletefromchitha/delete_patta');
    }

    function delete_a_patta() {
		 $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        //$this->session->set_userdata(array('pattadar' => array()));
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
        //var_dump($district);
        $this->load->helper('html');
        $this->load->view('../views/header');
        $this->load->view('../views/delete/select_location_22', $district);
        $this->load->view('../views/footer');
    }

    function delete_a_dag_action() {
		 $db=  $this->session->userdata('db');
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        $mouza_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');
        $patta_type = $this->input->post('patta_type');
        $patta_no = $this->input->post('patta_number');
        $dag_number = $this->input->post('dag_number');
        //var_dump($dag_number);
        foreach ($dag_number as $dag) {
            $sql = "Delete from    jama_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and 
		mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$patta_type'
		and patta_no='$patta_no' and dag_no='$dag' ";
            $this->db->query($sql);
            echo "Success Deletion of dag" . $dag;
            echo "<br>";
        }
        redirect("/home/");
    }

    function getdag($d, $s, $c, $m, $l, $v, $p, $pno) {
		 $db=  $this->session->userdata('db');
        $dag_no = $this->db->query("Select dag_no from    chitha_basic where dist_code='$d' and subdiv_code = '$s' and cir_code='$c' and "
                . "mouza_pargona_code = '$m' and lot_no = '$l' and vill_townprt_code='$v' and patta_type_code='$p' and patta_no='$pno' ");
        $data = $dag_no->result();
        $json = array();
        foreach ($data as $object) {
            $json[] = array('dag_no' => trim($object->dag_no));
        }
        echo json_encode($json);
    }

    public function getpattaTypebyname($d, $s, $c, $m, $l, $v, $p) {
		 $db=  $this->session->userdata('db');

        if ($p == 0000) {
            $pattano = $this->db->query("Select patta_no from    chitha_basic where dist_code='$d' and subdiv_code = '$s' and cir_code='$c' and "
                    . "mouza_pargona_code = '$m' and lot_no = '$l' and vill_townprt_code='$v' order by length(patta_no),patta_no"); //order by CAST(coalesce(patta_no, '0') AS varchar)");
        } else {
            $pattano = $this->db->query("Select patta_no from    chitha_basic where dist_code='$d' and subdiv_code = '$s' and cir_code='$c' and "
                    . "mouza_pargona_code = '$m' and lot_no = '$l' and vill_townprt_code='$v' and "
                    . "patta_type_code='$p' order by length(patta_no),patta_no"); //order by CAST(coalesce(patta_no, '0') AS varchar)");
        }

        $data = $pattano->result();
        $json = array();
        foreach ($data as $object) {
            $json[] = array('patta_no' => trim($object->patta_no));
        }
        echo json_encode($json);
    }

    function getAlldag($d, $s, $c, $m, $l, $v) {
		// $db=  $this->session->userdata('db');
        $dag_no = $this->db->query("Select dag_no,dag_no_int from    chitha_basic where dist_code='$d' and subdiv_code = '$s' and cir_code='$c' and "
                . "mouza_pargona_code = '$m' and lot_no = '$l' and vill_townprt_code='$v'  order by dag_no_int ");
        $data = $dag_no->result();
        $json = array();
        foreach ($data as $object) {
            $json[] = array('dag_no' => trim($object->dag_no));
        }
        echo json_encode($json);
    }

    function getJamadag($d, $s, $c, $m, $l, $v, $p, $pno) {
		 $db=  $this->session->userdata('db');
        $dag_no = $this->db->query("Select dag_no from    jama_dag where dist_code='$d' and subdiv_code = '$s' and cir_code='$c' and "
                . "mouza_pargona_code = '$m' and lot_no = '$l' and vill_townprt_code='$v' and patta_type_code='$p' and patta_no='$pno' ");
        $data = $dag_no->result();
        $json = array();
        foreach ($data as $object) {
            $json[] = array('dag_no' => trim($object->dag_no));
        }
        echo json_encode($json);
    }

    function getcase($d, $s, $c, $m, $l, $v, $cno) {
		 $db=  $this->session->userdata('db');
        if ($cno == '01') {
            $sql = "Select case_no from    t_chitha_rmk_ordbasic where dist_code='$d' and  subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$m' 
		and lot_no='$l' and vill_townprt_code='$v' ";
            //and (iscorrected_inco is null or iscorrected_inco='' )
        }
        if ($cno == '02') {
            $sql = "Select case_no from    t_chitha_col8_order where dist_code='$d' and  subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$m' 
		and lot_no='$l' and vill_townprt_code='$v' ";
            //and (iscorrected_inco is null or iscorrected_inco='' )
        }
        $data = $this->db->query($sql)->result();
        $json = array();
        foreach ($data as $object) {
            $json[] = array('case_no' => trim($object->case_no));
        }
        echo json_encode($json);
    }

    // function getloc(){
    // $cno=$_POST['ntype'];
    // $case_no=$_POST['case_no'];
    // if($cno==1){
    // $sql="Select * from    field_mut_basic where case_no='$case_no' ";
    // }
    // if($cno==2){
    // $sql="Select * from    petition_basic where case_no='$case_no' )";
    // }
    // $data = $this->db->query($sql)->result();
    // $json = array();
    // foreach ($data as $object) {
    // $json[] = array('subdiv_code' => $object->subdiv_code);
    // }
    // echo json_encode($json);
    // }
    function getloc() {
		 $db=  $this->session->userdata('db');
        $cno = $_POST['ntype'];
        $case_no = $_POST['case_no'];
        if ($cno == 1) {
            $sql = "Select * from    field_mut_basic where case_no='$case_no' ";
        }
        if ($cno == 2) {
            $sql = "Select * from    petition_basic where case_no='$case_no' ";
        }
        if ($cno == 3) {
            $sql = "Select * from    misc_case_basic where misc_case_no='$case_no' ";
        }
        if ($cno == 4) {
            $sql = "Select * from    t_reclassification where case_no='$case_no' ";
        }
        $data['data'] = $this->db->query($sql)->result();
        $this->load->view('../views/header');
        $this->load->view('../views/delete/c_location', $data);
        $this->load->view('../views/footer');
    }

    function delete_ttable() {
		 $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        //$this->session->set_userdata(array('pattadar' => array()));
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
        $this->load->helper('html');
        $this->load->view('../views/header');
        $this->load->view('../views/delete/delete_ttable', $district);
        $this->load->view('../views/footer');
        if (isset($_POST['ASTSTEP1Submit'])) {
            $type = $this->input->post('case_type');
            $case_no = $this->input->post('case_number');
            if ($type == '01') {
                $sql = "Delete from    t_chitha_rmk_ordbasic where case_no='$case_no' ";
                $this->db->query($sql);
                $sql = "Delete from    t_chitha_rmk_alongwith where ord_no='$case_no'";
                $this->db->query($sql);
                $sql = "Delete from    t_chitha_rmk_convorder where ord_no='$case_no'";
                $this->db->query($sql);
                $sql = "Delete from    t_chitha_rmk_infavor_of where ord_no='$case_no'";
                $this->db->query($sql);
                $sql = "Delete from    t_chitha_rmk_inplace_of where ord_no='$case_no'";
                $this->db->query($sql);
                $sql = "Delete from    t_chitha_rmk_onbehalf where ord_no='$case_no'";
                $this->db->query($sql);
            }
            if ($type == '02') {
                $sql = "SElect * from    t_chitha_col8_order where case_no='$case_no' ";
                $d = $this->db->query($sql)->row();
                $sql = "Delete from    t_chitha_col8_occup where subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code' and mouza_pargona_code='$d->mouza_pargona_code' 
				and lot_no='$d->lot_no' and vill_townprt_code='$d->vill_townprt_code' and petition_no='$d->petition_no' ";
                $this->db->query($sql);
                //echo "<br>";
                $sql = "Delete from    t_chitha_col8_inplace where subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code' and mouza_pargona_code='$d->mouza_pargona_code' 
				and lot_no='$d->lot_no' and vill_townprt_code='$d->vill_townprt_code' and petition_no='$d->petition_no' ";
                $this->db->query($sql);
                $sql = "delete from    t_chitha_col8_order where case_no='$case_no' ";
                $this->db->query($sql);
                //redirect("/home/");
            }
        }
    }

    function c_location() {
        $data['data'] = array();
        $this->load->view('../views/header');
        $this->load->view('../views/delete/c_location', $data);
        $this->load->view('../views/footer');
    }

    function showList() {
        $this->load->library('controllerlist'); // Load the library
        echo "<pre>";
        var_dump($this->controllerlist->getControllers());
    }

    function update_patta() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        //$this->session->set_userdata(array('pattadar' => array()));
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
        //var_dump($district);
        $this->load->helper('html');
        $this->load->view('../views/header');
        $this->load->view('../views/delete/update_patta', $district);
        $this->load->view('../views/footer');
    }

    function update_dag_patta() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        //$this->session->set_userdata(array('pattadar' => array()));
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
        //var_dump($district);
        $this->load->helper('html');
        $this->load->view('../views/header');
        $this->load->view('../views/delete/update_dag_patta', $district);
        $this->load->view('../views/footer');
    }

    function update_patta_action() {
        if (isset($_POST)) {
            //var_dump($_POST);
            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $circle_code = $this->input->post('circle_code');
            $mouza_code = $this->input->post('mouza_code');
            $lot_no = $this->input->post('lot_no');
            $vill_code = $this->input->post('vill_code');
            $patta_type = $this->input->post('patta_type');
            $patta_number = $this->input->post('patta_number');
            $dag_number = $this->input->post('dag_number');
            // if(($circle_code!=='05') and ($vill_code!=='20002') and ($lot_no!=='13')){
            // $this->session->set_flashdata('message',"This is for Only ১৩নং লাট  -লক্ষীপুৰ টাউন  Area"); 
            // redirect('/home');
            // }

            $q = "SElect dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,pdar_id,p_flag,dag_no,patta_no,patta_type_code from    chitha_dag_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and
				 mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$dag_number' and patta_no='$patta_number' and patta_type_code='$patta_type' ";
            $data['cdp'] = $this->db->query($q)->result();
            $q = "SElect pdar_id,pdar_name,pdar_father from    chitha_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and
				 mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_no='$patta_number' and patta_type_code='$patta_type' ";
            $data['cp'] = $this->db->query($q)->result();
            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/delete/update_patta_view', $data);
            $this->load->view('../views/footer');
        }
    }

    function update_dag_patta_action() {
        if (isset($_POST)) {
            //var_dump($_POST);
            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $circle_code = $this->input->post('circle_code');
            $mouza_code = $this->input->post('mouza_code');
            $lot_no = $this->input->post('lot_no');
            $vill_code = $this->input->post('vill_code');
            //$patta_type=$this->input->post('patta_type');
            //$patta_number=$this->input->post('patta_number');
            $dag_number = $this->input->post('dag_number');
            $q = "SElect dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,dag_no,pdar_id,vill_townprt_code,patta_no,patta_type_code from chitha_dag_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and
				 mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$dag_number' "; //and patta_no='$patta_number' and patta_type_code='$patta_type' ";
            $data['cdp'] = $cdp = $this->db->query($q)->row();
            //var_dump($data['cdp']);			
            //echo "<br>";			
            $q = "SElect pdar_id,pdar_name,pdar_father from chitha_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and
				 mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_no='$cdp->patta_no' and patta_type_code='$cdp->patta_type_code' ";
            $data['cp'] = $this->db->query($q)->result();
            $data['_view'] = 'delete/update_dag_patta_view';
            $this->load->view('layouts/main',$data);
        }
    }

    function update_to_patta() {

        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');
        $patta_type_code = $this->input->post('patta_type_code');
        $patta_no = $this->input->post('patta_no');
        $up_patta_no = $this->input->post('Update_patta');
        $dag_no = $this->input->post('dag_no');
        $user_code = $this->session->userdata('user_code');
        $date_entry = date('Y-m-d H:i:s');
        $where_cb = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            //'patta_type_code'=>$patta_type_code,		
            'patta_no' => $patta_no,
        );
        //var_dump($where_cb);
        $this->db->from('chitha_pattadar');
        $this->db->where($where_cb);
        $query = $this->db->get()->num_rows;
        //$query=0;
        if ($query !== 0) {
            $value = array('patta_no' => $up_patta_no, 'jama_yn' => 'n', 'user_code' => $user_code, 'date_entry' => $date_entry);
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
            // $this->db->where($where_cdp);
            // $this->db->update('chitha_basic', $value);
            $this->Chitha_basic_model->update_table("chitha_basic", $value, $where_cdp);

            $q = "Select pdar_id from    chitha_dag_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and
				 mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and patta_no='$patta_no' and dag_no='$dag_no'";
            $pdarid = $this->db->query($q)->result();
            foreach ($pdarid as $pid) {
                $where_exist = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'patta_type_code' => $patta_type_code,
                    'patta_no' => $up_patta_no,
                    'pdar_id' => $pid->pdar_id
                );
                $this->db->from('chitha_pattadar');
                $this->db->where($where_exist);
                $query = $this->db->get()->num_rows;
                if ($query == 0) {
                    $where_cbb = array(
                        'dist_code' => $dist_code,
                        'subdiv_code' => $subdiv_code,
                        'cir_code' => $cir_code,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'lot_no' => $lot_no,
                        'vill_townprt_code' => $vill_townprt_code,
                        'patta_type_code' => $patta_type_code,
                        'patta_no' => $patta_no,
                        'pdar_id' => $pid->pdar_id
                    );
                    // $this->db->where($where_cbb);
                    // $this->db->update('chitha_pattadar', $value);
                    $result = $this->Chitha_basic_model->update_table('chitha_pattadar', $value, $where_cbb);
                }
            }
            $this->db->where($where_cdp);
            // $this->db->update('chitha_dag_pattadar', $value);
            $this->Chitha_basic_model->update_table('chitha_dag_pattadar', $value, $where_cdp);
            //exit;
            redirect('home/');
        } else {
            show_error('Patta Not Exists');
        }
    }

    function update_new_dag_patta() {
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
        $up_patta_no = $this->input->post('Update_patta');
        $up_dag_no = $this->input->post('Update_dag');
        $case_no = trim($this->input->post('case_no'));
        $case_type = $this->input->post('case_type');
        if ($case_type == '01') {
            $q = "Select * from    chitha_col8_order where case_no='$case_no' "; // and map_partition is null ";
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
                $row['dag_no'] = $up_dag_no;
                $row['dag_no_int'] = $up_dag_no . "00";
                $row['patta_no'] = $up_patta_no;
                // $this->db->insert('chitha_basic', $row);
                $this->Chitha_basic_model->insert_table('chitha_basic',$row);


                $col8order_cron_no = $record->col8order_cron_no;
                $sql = "Update chitha_col8_occup set new_patta_no='$up_patta_no',new_dag_no='$up_dag_no' where col8order_cron_no='$col8order_cron_no' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
                $this->db->query($sql);
                $sql = "Update chitha_col8_order set new_dag_no='$up_dag_no' where col8order_cron_no='$col8order_cron_no' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and new_dag_no='$dag_no' ";
                $this->db->query($sql);
                $sql = "Update chitha_col8_order set dag_no='$up_dag_no' where col8order_cron_no='$col8order_cron_no' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and dag_no='$dag_no' ";
                $this->db->query($sql);
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
                $value = array('dag_no' => $up_dag_no, 'patta_no' => $up_patta_no);
                $this->db->where($where_cdp);
                // $this->db->update('chitha_dag_pattadar', $value);
                $this->Chitha_basic_model->update_table('chitha_dag_pattadar', $value, $where_cdp);
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
                $table = 'chitha_pattadar';
                $params = [
                    'patta_no' => $up_patta_no,
                ];
                $where = [
                    'dist_code'           => $dist_code,
                    'subdiv_code'         => $subdiv_code,
                    'cir_code'            => $cir_code,
                    'mouza_pargona_code'  => $mouza_pargona_code,
                    'lot_no'              => $lot_no,
                    'vill_townprt_code'   => $vill_townprt_code,
                    'patta_type_code'     => $patta_type_code,
                    'patta_no'            => $patta_no,
                ];
                $this->Chitha_basic_model->update_table($table, $params, $where);

            } else {
                show_error('May Dag Updated in  Bhunaksha!!');
            }
        }
        if ($case_type == '02') {
            $q = "Select * from    chitha_rmk_ordbasic where case_no='$case_no'  ";
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
                $row['dag_no'] = $up_dag_no;
                $row['dag_no_int'] = $up_dag_no . "00";
                $row['patta_no'] = $up_patta_no;
                // $this->db->insert('chitha_basic', $row);
                $this->Chitha_basic_model->insert_table('chitha_basic',$row);
                $value = array('dag_no' => $up_dag_no, 'patta_no' => $up_patta_no);
                $this->db->where($where_cdp);
                // $this->db->update('chitha_dag_pattadar', $value);
                $this->Chitha_basic_model->update_table('chitha_dag_pattadar', $value, $where_cdp);
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
                $table = 'chitha_pattadar';

                $params = [
                    'patta_no' => $up_patta_no,
                ];

                $where = [
                    'dist_code'           => $dist_code,
                    'subdiv_code'         => $subdiv_code,
                    'cir_code'            => $cir_code,
                    'mouza_pargona_code'  => $mouza_pargona_code,
                    'lot_no'              => $lot_no,
                    'vill_townprt_code'   => $vill_townprt_code,
                    'patta_type_code'     => $patta_type_code,
                    'patta_no'            => $patta_no,
                ];

                $this->Chitha_basic_model->update_table($table, $params, $where);



                //$value=array('dag_no'=>$up_dag_no,'dag_no_int'=>$up_dag_no."00",'patta_no'=>$up_patta_no);
                //$this->db->where($where_cdp);


                $rmk_type_hist_no = $record->rmk_type_hist_no;
                $sql = "Update chitha_rmk_infavor_of set new_patta_no='$up_patta_no',new_dag_no='$up_dag_no' where subdiv_code='$subdiv_code' and cir_code='$cir_code' and ord_no='$case_no' ";
                $this->db->query($sql);

                $sql = "Update chitha_rmk_ordbasic set new_dag_no='$up_dag_no' where ord_no='$case_no' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and new_dag_no='$dag_no' ";
                $this->db->query($sql);
                $sql = "Update chitha_rmk_ordbasic set dag_no='$up_dag_no' where ord_no='$case_no' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and dag_no='$dag_no' ";
                $this->db->query($sql);
                $sql = "Update chitha_rmk_gen set dag_no='$up_dag_no' where rmk_type_hist_no='$rmk_type_hist_no' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and rmk_type_code='01' and mouza_pargona_code='$record->mouza_pargona_code' and 
				lot_no='$record->lot_no' and vill_townprt_code='$record->vill_townprt_code' and (dag_no='$dag_no'  )		";
                $this->db->query($sql);
            } else {
                show_error('May Dag Updated in  Bhunaksha!!');
            }
        }
    }
	//"14";"01";"01";"06";"02";"10005"
    function backCDP() {
       ECHO  $q = "select * from chitha_dag_pattadar where dist_code='13' and subdiv_code='01' and cir_code='01' and mouza_pargona_code='01' and lot_no='01' and vill_townprt_code='10016' and patta_no='410' and pdar_id=22 ";
        $data = $this->db->query($q)->result();
        foreach ($data as $k => $val) {
            //unset($data[$k]->update_date_time_timestamp);
            //$data[$k]->case_no='GOL/DER/2017-18/68/OPART';
            $data[$k]->pdar_id = '24';
            // $data[$k]->patta_no='233';
            //$data[$k]->occupant_fmh_name='অভিভাৱক স্বামী-শ্ৰী খৰ্গেশ্বৰ বৰ্মন ';
            //$data[$k]->patta_type_code='0206';
            // $data[$k]->dag_no='213';
            // $data[$k]->date_entry='2023-05-03';
            // $data[$k]->user_code='M20';
            //echo $this->db->insert('chitha_dag_pattadar',$data[$k]);
            //echo "<br>";
           // var_dump($data[$k]);
        }
    }

	
	   function remarkgrant() {
         $q = "select * from users where dist_code='14' and cir_code='01' and subdiv_code = '01' and user_code='AS2'"; //'05','03','06','10022'
        $data = $this->db->query($q)->result();
        foreach ($data as $k => $val) {
            //unset($data[$k]->update_date_time_timestamp);
            //$data[$k]->case_no='GOL/DER/2017-18/68/OPART';
            $data[$k]->cir_code = '02';
            //$data[$k]->patta_no='1';
            //$data[$k]->occupant_fmh_name='অভিভাৱক স্বামী-শ্ৰী খৰ্গেশ্বৰ বৰ্মন ';
            //$data[$k]->patta_type_code='0206';
           // $data[$k]->dag_no='24';
           echo $this->db->insert('users',$data[$k]);
            //echo "<br>";
           // var_dump($data[$k]);
        }
    }
	
	
	
	
	
	
	
	
	
	
	
    function doul() {

        //$q="Update allotment_lm_note set sk_comment='$text',sk_code='SK1' where subdiv_code='02' and circle_code='02'   ";
        //$this->db->query($q);
        //$q="insert into chitha_pattadar_doul(select * from    chitha_pattadar)";
        //$data=$this->db->query($q)->result();
        //var_dump($q);
        // update chitha_pattadar_doul set year_no = '2017' where year_no = ''; 
        // insert into chitha_dag_pattadar_doul(select * from    chitha_dag_pattadar);
        // update chitha_dag_pattadar_doul set year_no = '2017' where year_no = '';
		
		//"14";"01";"01";"06";"05";"10002"
	
		
    }
    function forceInheritancePost(){
        //RTPS/MUTI/2022/355120
        //TIN/TIN/2022-23/32448/FMUT
        $application_no="RTPS/MUTI/2022/335829";//$_POST['application_no']; DHU/DHU/2021-22/34967/FMUT
        $case_name ='DIB/CHA/2022-23/';//DHU/GRP/2021-22/34930/FMUT,55343/FMUT,GOA/LAK/2022-23/55344/FMUT,GOA/LAK/2022-23/55353/FMUT,GOA/LAK/2022-23/55337/FMUT
        $case_no['petition_no']=$petition_no='33282';//1900fo
        // $patta_no = '';
        // $patta_type = '';
        $possession_yn = 'y';
       
        $lm_remark=' ';
        $reg_date='2022-12-09';
        $reg_year='2022';
        $isbasu_insert = '1';//whether 1 application no to be 1inserted in basundhar_application
        $isbasu_api = '0';//whether basundhara api to be called


        
        /////////////////////
        $url = RTPS_API_LINK."serviceResponse?application_no=" . $application_no ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        //var_dump($output);
        $data['app']=$output->application;
        $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$data['app']->dag_no);
        
        $data['firstParty']=$output->mutation;
        $data['secParty']=$output->applicants;
        $mut_area_b='0';
        $mut_area_k='0';
        $mut_area_l='0';
        
       
        // $case_no=$this->basundharamodel->genearteCaseNo('01');
        // $case_name=$this->basundharamodel->genearteCaseName();
        //  if(empty($case_name)){
        //     $data=array(
        //         'error'=>"Network Issue or Seesion Out. Please try Again"
        //     );
        //     echo json_encode($data);
        //     exit;
        //     die();
        // }
        // $case_no['petition_no']=$petition_no=$this->basundharamodel->genearteFieldPetitionNo();
        $case_no['case_no']=$case_name.$petition_no."/FMUT";
        //$case_no['case_no']='NAG/SAMK/2021-22/1057/FMUT';
        
        $this->db->trans_begin();

        $sql = "select * from field_mut_basic where case_no='".$case_no['case_no']."' limit 1";
        if ($this->db->query($sql)->num_rows() < 1)
        {
            $basic=array(
                'dist_code'=>$data['app']->dist_code,
                'subdiv_code'=>$data['app']->subdiv_code,
                'cir_code'=>$data['app']->cir_code,
                'mouza_pargona_code'=>$data['app']->mouza_code,
                'lot_no'=>$data['app']->lot_no,
                'vill_townprt_code'=>$data['app']->village_code,
                'user_code'=>$this->session->userdata('user_code'),
                'date_entry'=>$reg_date,
                'case_no'=>$case_no['case_no'],
                'trans_code'=>'01',
                'dispute_yn'=>0,
                'possession_yn'=>$possession_yn, //$this->input->post('possession'),
                'petition_no'=>$case_no['petition_no'],
                'year_no'=>$reg_year,
                'report_date'=>$reg_date,
                'mut_type'=>'01',                    
                'operation'=>'E',
                'user_code'=>$this->session->userdata('user_code')
            );
            var_dump($basic);
           echo $tstatus1 = $this->db->insert('field_mut_basic',$basic);

           echo "<br><br> *******************************";
            if ($tstatus1 != 1)
            {
                $this->db->trans_rollback();
                echo "Last Query: ".json_encode($this->db->last_query());
                echo "error field_mut_basic insert";
                return;
                die();
            }
        }
        //////Buyer Insert////////////
        $sql = "select * from field_mut_petitioner where case_no='".$case_no['case_no']."' limit 1";
        if ($this->db->query($sql)->num_rows() < 1)
        {
            $i=1;
            foreach($data['firstParty'] as $pet){
                $faddress=$this->address($pet->address);
                $buyerInsert = array(
                    'dist_code'=>$data['app']->dist_code,
                    'subdiv_code'=>$data['app']->subdiv_code,
                    'cir_code'=>$data['app']->cir_code,
                    'mouza_pargona_code'=>$data['app']->mouza_code,
                    'lot_no'=>$data['app']->lot_no,
                    'vill_townprt_code'=>$data['app']->village_code,
                    'user_code'=>$this->session->userdata('user_code'),
                    'date_entry'=>$reg_date,
                    'case_no'=>$case_no['case_no'],
                    'petition_no'=>$case_no['petition_no'],
                    'year_no'=>$reg_year,
                    'operation'=>'E',
                    'pet_name' => $pet->pat_name_ass,
                    'guard_name' => $pet->pat_gurdian_name_ass,
                    'guard_rel' =>$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->pat_gurdian_rel_id),/////////////
                    'pet_gender'=>$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->pat_gender),
                    //'add1' => $pet->address,
                    'add1' => $faddress[0],
                    'add2' => $faddress[1],
                    'pet_id' => $i++,
                    'pdar_mobile'=>$pet->pat_mobile_no,
                    'new_pet_name'=>'N'
                );
                var_dump($buyerInsert);
              echo $tstatus2 = $this->db->insert('field_mut_petitioner', $buyerInsert);
               echo "<br><br> *******************************";
               if ($tstatus2 != 1)
                {
                    $this->db->trans_rollback();
                    echo "Last Query: ".json_encode($this->db->last_query());
                    echo "error field_mut_petitioner insert";
                    return;
                    die();
                }
            }
        }
        ////////Seller Insert//////////
        $sql = "select * from field_mut_pattadar where case_no='".$case_no['case_no']."' limit 1";
        if ($this->db->query($sql)->num_rows() < 1)
        {
            foreach($data['secParty'] as $pet){
                $sellerInsert = array(
                    'dist_code'=>$data['app']->dist_code,
                    'subdiv_code'=>$data['app']->subdiv_code,
                    'cir_code'=>$data['app']->cir_code,
                    'mouza_pargona_code'=>$data['app']->mouza_code,
                    'lot_no'=>$data['app']->lot_no,
                    'vill_townprt_code'=>$data['app']->village_code,
                    'user_code'=>$this->session->userdata('user_code'),
                    'date_entry'=>$reg_date,
                    'case_no'=>$case_no['case_no'],
                    'petition_no'=>$case_no['petition_no'],
                    'year_no'=>$reg_year,
                    'operation'=>'E',
                    'dag_no'=>$data['app']->dag_no,
                    'patta_no'=>$data['pattaNo']->patta_no, //$this->input->post('patta_no') ,
                    'patta_type_code'  => $data['pattaNo']->patta_type_code, //$this->input->post('patta_type') ,
                    'pdar_id' => $pet->chitha_pdar_id,
                    'pdar_cron_no' => $pet->chitha_pdar_id,
                    'pdar_name' => $pet->name_ass,
                    'pdar_guardian'=>$pet->gurdian_name_ass,
                    'pdar_rel_guar' =>'u',//$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->gurdian_relation_id),/////////////
                    'pdar_gender'=>'m',//$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->gender),
                    'striked_out' =>1,/////for inheritance//////
                );
                var_dump($sellerInsert);
                echo $tstatus3 = $this->db->insert('field_mut_pattadar', $sellerInsert);
                 echo "<br><br> *******************************";
                if ($tstatus3 != 1)
                {
                    $this->db->trans_rollback();
                    echo "Last Query: ".json_encode($this->db->last_query());
                    echo "error field_mut_pattadar insert";
                    return;
                    die();
                }
            }
        }
        echo $sql = "select * from  field_mut_dag_details where case_no='".$case_no['case_no']."' limit 1";
        if ($this->db->query($sql)->num_rows() < 1)
        {
            $dagDetails=array(
                'dist_code'=>$data['app']->dist_code,
                'subdiv_code'=>$data['app']->subdiv_code,
                'cir_code'=>$data['app']->cir_code,
                'mouza_pargona_code'=>$data['app']->mouza_code,
                'lot_no'=>$data['app']->lot_no,
                'vill_townprt_code'=>$data['app']->village_code,
                'user_code'=>$this->session->userdata('user_code'),
                'date_entry'=>$reg_date,
                'case_no'=>$case_no['case_no'],
                'petition_no'=>$case_no['petition_no'],
                'year_no'=>$reg_year,
                'operation'=>'E',
                'dag_no'=>$data['app']->dag_no,
                'patta_no'=>$data['pattaNo']->patta_no,//$this->input->post('patta_no') ,
                'patta_type_code'  =>$data['pattaNo']->patta_type_code,//$this->input->post('patta_type') ,
                'm_dag_area_b'=>$mut_area_b,
                'm_dag_area_k' =>$mut_area_k,
                'm_dag_area_lc' =>$mut_area_l,
                'm_dag_area_g' =>0,
                'm_dag_area_kr' =>0,
                'dag_area_b' =>$data['pattaNo']->dag_area_b,
                'dag_area_k' =>$data['pattaNo']->dag_area_k,
                'dag_area_lc' =>$data['pattaNo']->dag_area_lc,  
                'dag_area_g' =>0,  
                'dag_area_kr' =>0 ,
                'remark' =>$lm_remark //addslashes(trim($_POST['remark']))
                );
            var_dump($dagDetails);
            echo $tstatus4 = $this->db->insert('field_mut_dag_details',$dagDetails);
            echo "<br><br> *******************************";
            if ($tstatus4 != 1)
            {
                $this->db->trans_rollback();
                echo "Last Query: ".json_encode($this->db->last_query());
                echo "error field_mut_dag_details insert";
                return;
                die();
            }
        }
        // $this->db->trans_rollback();
        // die();
        if ($isbasu_insert =='1')
        {
            $basundhara=array(
                'dharitree'=>$case_no['case_no'],
                'basundhara'=>$application_no,
                'date_reg'=>$reg_date,//date('Y-m-d'),
                'reg_by'=>$this->session->userdata('user_code'),
                'app_status'=>'P',
                'pending_with'=>'CO'
            );
            $tstatus5 = $this->db->insert('basundhar_application',$basundhara);
            if ($tstatus5 != 1)
            {
                $this->db->trans_rollback();
                echo "Last Query: ".json_encode($this->db->last_query());
                echo "error basundhar_application insert";
                return;
                die();
            }
        }

        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            $data=array(
                'error'=>"Error in submitting. Please try Again"
            );
        }else
        {
            $this->db->trans_commit();

            //////////////POST To basundhara/////////////////////
            if ($isbasu_api =='1')
            {
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, API_LINK."applicationStatusUpdate");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    'application' => $application_no,
                    'dharitree' => $case_no['case_no'],
                    'rmk' => 'all ok',
                    'status' => 'M',
                    'task' => 'LM',
                    'pen'=>'CO'
                )));
                
                
                $result = curl_exec($curl_handle);            
                $this->DashboardPartitionField($case_no['case_no']);
                $this->session->set_flashdata('message',"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no] ");
                //////////////////////////////////
                $data=array(
                    'success'=>"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no]",
                    'redirect_url'=>base_url().'index.php/home'
                );
            }
        }
        echo json_encode($data);
    }
    function allotmentForcePost(){
        $application_no="RTPS/ALOT/2022/371699";//$_POST['application_no']; DHU/DHU/2021-22/34967/FMUT
        $case_name ='CHA/SON/2022-23/';//DHU/GRP/2021-22/34930/FMUT,55343/FMUT,GOA/LAK/2022-23/55344/FMUT,GOA/LAK/2022-23/55353/FMUT,GOA/LAK/2022-23/55337/FMUT
        $case_no['petition_no']=$petition_no='1344';//1900fo
        $possession_yn = 'y';
       
        $lm_remark=' ';
        $reg_date='2022-11-28';
        $reg_year='2022';
        $isbasu_insert = '1';//whether 1 application no to be 1inserted in basundhar_application
        $isbasu_api = '0';//whether basundhara api to be called
        $url = RTPS_API_LINK."serviceResponse?application_no=" . $application_no ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        $data['app']=$output->application;
        //var_dump($data['app']);
        $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$data['app']->dag_no);
        $data['firstParty']=$output->mutation;
        $this->db->trans_begin();
        //$case_no=$this->rtpsmodel->generateAllomentcase('04');
        if(($data['app']->dist_code!=$this->session->userdata('dist_code')) || ($data['app']->subdiv_code!=$this->session->userdata('subdiv_code')) || ($data['app']->cir_code!=$this->session->userdata('cir_code')) )
        {
            $data=array(
                'error'=>"Please reload the page. Session might be Destroyed."
            );
            echo json_encode($data);
            return false;
            exit;
        }
        // $case_name=$this->rtpsmodel->genearteCaseName();
        // if(empty($case_name)){
        //     $data=array(
        //         'error'=>"Network Issue or Session Out. Please try Again"
        //     );
        //     echo json_encode($data);
        //     exit;
        //     die();
        // }
        //$case_no['petition_no']=$petition_no=$petition_no;
        $case_no['case_no']=$case_name.$petition_no."/ACPP";
        $allotment_basic = array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'circle_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'user_code'=>$this->session->userdata('user_code'),
            'year_no'=>date('Y'),
            'date_entry'=>$reg_date,
            'case_no'=>$case_no['case_no'],
            'allotment_under' => $data['firstParty'][0]->scheme_id,
            'petition_no' => $case_no['petition_no'],
            'original_alotee' => $data['firstParty'][0]->is_original,
            'name_of_allote' => $data['firstParty'][0]->allotee_name,
            'type_govt_land' => $data['firstParty'][0]->land_type,
        );
        $sql = "select * from  allotment_cert_basic where case_no='".$case_no['case_no']."' limit 1";
        if ($this->db->query($sql)->num_rows() ==0)
        {
        $insBasicACPP = $this->db->insert('allotment_cert_basic', $allotment_basic);
            if($insBasicACPP != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRACPP001: Insertion failed in allotment_cert_basic for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRACPP001: Registration of Land Allotment failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
        }
        $sql = "select * from  allotment_petitioner where case_no='".$case_no['case_no']."' limit 1";
        if($this->db->query($sql)->num_rows() ==0)
        {
            $alotid = 1;
            foreach ($data['firstParty'] as $mp) {
                $aadharNo = null;
                $panNo =null;
                if($mp->is_applicant == '1'){
                    $file =null;
                    if(!empty($output->selfDeclaration[0]->dec_details)){
                        $dec = $output->selfDeclaration[0]->dec_details;
                    }else{
                        $dec = null;
                    }
                    $auth_type = $mp->auth_type;
                    $id_ref_no = $mp->id_ref_no;
                    if($mp->auth_type=='AADHAAR'){
                        $uploadpath   = AADHAAR_UPLOAD_DIR;
                        $imagebase64  = $output->photo;
                        $file         = $uploadpath . $mp->id_ref_no . '.json';
                        file_put_contents($file, $imagebase64);
                        $aadharNo = $mp->id_ref_no;
                        $panNo = null;
                    }else if($mp->auth_type=='PAN'){
                        $aadharNo = null;
                        $panNo = $mp->id_ref_no;
                    }
                    $photo = $file;
                }else{
                    $dec= null;
                    $auth_type = null;
                    $id_ref_no = null;
                    $photo = null;
                }
                $allotment_petitioner = array(
                    'dist_code'=>$data['app']->dist_code,
                    'subdiv_code'=>$data['app']->subdiv_code,
                    'circle_code'=>$data['app']->cir_code,
                    'mouza_pargona_code'=>$data['app']->mouza_code,
                    'lot_no'=>$data['app']->lot_no,
                    'vill_townprt_code'=>$data['app']->village_code,
                    'case_no'=>$case_no['case_no'],
                    'year_no'=>date('Y'),
                    'alotee_id' => $alotid,
                    'alotee_name' => $mp->name_ass,
                    //'alotee_gender' => $mp->gender,
                    //'alotee_reln' => $mp->gurdian_relation_id,
                    'alotee_reln' =>$this->utilityclass->relationRevertBasu($data['app']->dist_code,$mp->gender),/////////////
                    'alotee_gender'=>$mp->gurdian_relation_id,//$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$mp->gurdian_relation_id),
                    'alotee_gurdian' => $mp->gurdian_name_ass,
                    'alotee_mobile' => $mp->mobile,
                    'date_entry' => $reg_date,
                    'self_declaration' => $dec,
                    'auth_type' => $auth_type,
                    'alotee_pan_card'=> $panNo,
                    'alotee_aadhar' => $aadharNo, 
                    'photo'=> $photo
                );

                echo $insPetACPP = $this->db->insert('allotment_petitioner', $allotment_petitioner);
                
                if($insPetACPP != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error',$this->db->last_query());
                    log_message('error', '#ERRACPP002: Insertion failed in allotment_petitioner for RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRACPP002: Registration of Land Allotment failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
                $alotid = $alotid + 1;
                }
        }
        

        ///////////// BARAK VALLEY CODE START HERE ////////////////
        $allotment_dag = array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'circle_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'case_no'=>$case_no['case_no'],
            'year_no'=>date('Y'),
            'dag_no' =>$data['app']->dag_no,
            'patta_no' =>$data['pattaNo']->patta_no,
            'patta_type_code'=>$data['pattaNo']->patta_type_code,
            'alot_area_b' => $data['app']->area_b,
            'alot_area_k' =>$data['app']->area_k,
            'alot_area_lc' => $data['app']->area_l,
            'alot_area_g' => $data['app']->area_g,
            'tot_area_b' => $data['pattaNo']->dag_area_b,
            'tot_area_k' => $data['pattaNo']->dag_area_k,
            'tot_area_lc' => $data['pattaNo']->dag_area_lc,
            'date_entry' => $reg_date
        );    
        ///////////// BARAK VALLEY CODE ENDS HERE ////////////////
        $sql = "select * from  allotment_pet_dag where case_no='".$case_no['case_no']."' limit 1";
        if($this->db->query($sql)->num_rows() ==0)
        {
            echo $insDagACPP = $this->db->insert('allotment_pet_dag', $allotment_dag);
            if($insDagACPP != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRACPP003: Insertion failed in allotment_pet_dag for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRACPP003: Registration of Land Allotment failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
        }
        $allotment_doc_details = array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'circle_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'case_no'=>$case_no['case_no'],
            'year_no'=>date('Y'),
            'certficate_no' => $data['firstParty'][0]->order_no,
            'date_of_issue' => $data['firstParty'][0]->order_date, //$cert_date,
            'name_of_certificate' => 'Basundhara Allotment',
            'date_of_entry' => date('Y-m-d H:i:s'),
            //'file_name' => $escaped
        );
        $sql = "select * from  allotment_doc_details where case_no='".$case_no['case_no']."' limit 1";
        if($this->db->query($sql)->num_rows() ==0)
        {
            echo $insDocACPP = $this->db->insert('allotment_doc_details', $allotment_doc_details);
            if($insDocACPP != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRACPP004: Insertion failed in allotment_doc_details for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRACPP004: Registration of Land Allotment failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
        }
        $basundhara=array(
            'dharitree'=>$case_no['case_no'],
            'basundhara'=>$application_no,
            'date_reg'=>$reg_date,
            'reg_by'=>$this->session->userdata('user_code'),
            'app_status'=>'P',
            'pending_with'=>'CO'
            );
        $insBasuACPP = $this->db->insert('basundhar_application',$basundhara);
        if($insBasuACPP != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRACPP005: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRACPP005: Registration of Land Allotment failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }
        
        if($this->db->trans_status()===FALSE){
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"Error in submitting. Please try Again"
                );
                echo json_encode($data);
                return;
        }else{
            $this->db->trans_commit();
            echo "success".$case_no['case_no'].$application_no;
        }

    }
    function address($full_address){
          //if less then 100
          if (strlen($full_address)<100) 
          {
            $address[0]= $full_address;
            $address[1] = null;
            return $address;    
          }
          //if more then 100 containing ',' or space separator
          $sub_address = substr($full_address,0,100);
          $pos = strrpos($sub_address,","); 
          if (!$pos)
          {
              $pos = strrpos($sub_address," "); 
          }
          
          $address[1] = substr($full_address,$pos+1,strlen($full_address));
          $address[0]= substr($full_address,0,$pos);            
          return $address;               
    }
	function forceConversionPost(){
        
        $application_no="RTPS/CONV/2022/359407";//$_POST['application_no']; DHU/DHU/2021-22/34967/FMUT
        $case_name ='LAK/KAD/2022-23/';//DHU/GRP/2021-22/34930/FMUT,55343/FMUT,GOA/LAK/2022-23/55344/FMUT,GOA/LAK/2022-23/55353/FMUT,GOA/LAK/2022-23/55337/FMUT
        $case_no['petition_no']=$petition_no='28241';//1900fo
        $possession_yn = 'y';
       
        $lm_remark=' ';
        $reg_date='2022-11-25';
        $reg_year='2022';
        $isbasu_insert = '1';//whether 1 application no to be 1inserted in basundhar_application
        $isbasu_api = '0';//whether basundhara api to be called
        //////////////////
        //echo "naaaa"; 
        //echo RTPS_API_LINK."serviceResponse?application_no=" . $application_no ;
        // $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        // var_dump($recordExist);
        // if($recordExist){
        //         $data=array(
        //             'error'=>"Case have been Registered Already. Please Check"
        //         );
        //         echo json_encode($data);
        //         exit;
        // }
        // echo "naaaa"; 
        /////////////////////
        //echo RTPS_API_LINK."serviceResponse?application_no=" . $application_no ;
        $url = RTPS_API_LINK."serviceResponse?application_no=" . $application_no ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        $data['app']=$output->application;
        //var_dump($data);
        $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$data['app']->dag_no);
        
        $data['firstParty']=$output->mutation;
        $data['secParty']=$output->applicants;
        //var_dump($data);
        $this->db->trans_begin();
        //$case_no=$this->rtpsmodel->genearteOfcCaseNo('01');
        if(($data['app']->dist_code!=$this->session->userdata('dist_code')) || ($data['app']->subdiv_code!=$this->session->userdata('subdiv_code')) || ($data['app']->cir_code!=$this->session->userdata('cir_code')) )
        {
            $data=array(
                'error'=>"Please reload the page. Session might be Destroyed."
            );
            echo json_encode($data);
            return false;
            exit;
        }
        //$case_name=$this->rtpsmodel->genearteCaseName();
        //  if(empty($case_name)){
        //     $data=array(
        //         'error'=>"Network Issue or Session Out. Please try Again"
        //     );
        //     echo json_encode($data);
        //     exit;
        //     die();
        // }
        //$case_no['petition_no']=$petition_no=$this->rtpsmodel->genearteOfficePetitionNo();
        $reg_user='M4';
        $case_no['case_no']=$case_name.$petition_no."/CONV";
        $basic=array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'mut_type'=>'01', /////mut type
            'trans_code'=>'F',/////////full
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>$reg_year,
            'date_entry' => $reg_date,                 
            'operation'=>'E',
            'user_code'=>$reg_user,
            'submission_date' => $reg_date,
            'add_off_name' => 'নন্দন নীলৎপল ভাগৱতী',
            'add_off_desig' =>'CO',
            'supported_doc' => 'Y',
            'operation' => 'E',
            'co_user_code' =>'CO9'
            ///////// 
        );
        $insBasicCONV = $this->db->insert('petition_basic',$basic);
        if($insBasicCONV != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRCONV001: Insertion failed in petition_basic for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRCONV001: Registration of AP TO PP CONVERSION failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }
        $fmd=array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'user_code'=>$reg_user,
            'date_entry'=>$reg_date,
            'case_no'=>$case_no['case_no'],
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>$reg_year,
            'operation'=>'E',
        );
        $fmd['dag_no']=$data['app']->dag_no;
        $fmd['patta_no']=$data['pattaNo']->patta_no;
        $fmd['patta_type_code']=$data['pattaNo']->patta_type_code;
        $fmd['m_dag_area_b']=$data['pattaNo']->dag_area_b;
        $fmd['m_dag_area_k']=$data['pattaNo']->dag_area_k;
        $fmd['m_dag_area_lc']=$data['pattaNo']->dag_area_lc;
        $fmd['dag_area_b']=$data['pattaNo']->dag_area_b;
        $fmd['dag_area_k']=$data['pattaNo']->dag_area_k;
        $fmd['dag_area_lc']=$data['pattaNo']->dag_area_lc;
        $fmd['m_dag_area_g']='0.00';
        $fmd['m_dag_area_kr']='0';
        $fmd['dag_area_g']='0';
        $fmd['dag_area_kr']='0';
        $fmd['revenue']=0;
        $insDagCONV = $this->db->insert('petition_dag_details',$fmd);
        if($insDagCONV != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRCONV002: Insertion failed in petition_dag_details for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRCONV002: Registration of AP TO PP CONVERSION failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }
        $i=1;
        foreach($data['firstParty'] as $part){
            $file = null;
            if($part->is_applicant == '1'){
                if(!empty($output->selfDeclaration[0]->dec_details)){
                    $dec = $output->selfDeclaration[0]->dec_details;
                }else{
                    $dec = null;
                }
                $auth_type = $part->auth_type;
                $id_ref_no = $part->id_ref_no;
                if($part->auth_type=='AADHAAR'){
                    $uploadpath   = AADHAAR_UPLOAD_DIR;
                    $imagebase64  = $output->photo;
                    $file         = $uploadpath . $part->id_ref_no . '.json';
                    file_put_contents($file, $imagebase64);
                }
                $photo = $file;
            }else{
                $dec= null;
                $auth_type = null;
                $id_ref_no = null;
                $photo = null;
            }
            $faddress=$this->address($part->address);   
            $petitioner=array(
                'dist_code'=>$data['app']->dist_code,
                'subdiv_code'=>$data['app']->subdiv_code,
                'cir_code'=>$data['app']->cir_code,
                'mouza_pargona_code'=>$data['app']->mouza_code,
                'lot_no'=>$data['app']->lot_no,
                'vill_townprt_code'=>$data['app']->village_code,
                'user_code'=>$reg_user,
                'date_entry'=>$reg_date,
                'case_no'=>$case_no['case_no'],
                'petition_no'=>$case_no['petition_no'],
                'operation'=>'E',
                'dag_no' =>$data['app']->dag_no,
                'patta_no' =>$data['pattaNo']->patta_no,
                'patta_type_code'=>$data['pattaNo']->patta_type_code,
                'year_no'=>$reg_year,
                'pdar_id' =>$part->chitha_pdar_id,
                'pdar_cron_no'=>$i++,
                'pdar_name' =>$part->name_ass,
                'pdar_guardian' =>$part->gurdian_name_ass,
                'pdar_rel_guar' =>$this->utilityclass->relationRevertBasu($data['app']->dist_code,$part->gurdian_relation_id),/////////////
                'pdar_gender'=>$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$part->gender),
                //'pdar_add1' => $part->address,
                'pdar_add1' => $faddress[0],
                'pdar_add2' => $faddress[1],
                'pdar_mobile' => $part->mobile,
                'self_declaration' => $dec,
                'auth_type' => $auth_type,
                'id_ref_no'=> $id_ref_no,
                'photo'=> $photo
            );
            $insPetCONV = $this->db->insert('petitioner_part',$petitioner);
            if($insPetCONV != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRCONV003: Insertion failed in petitioner_part for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRCONV003: Registration of AP TO PP CONVERSION failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
        }


        $basundhara=array(
            'dharitree'=>$case_no['case_no'],
            'basundhara'=>$application_no,
            'date_reg'=>$reg_date,
            'reg_by'=>$reg_user,
            'app_status'=>'P',
            'pending_with'=>'CO'
        );
        //////////UUID Insert/////////////
        $basundhara['uuid']=$this->utilityclass->getVillageUUID($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code);
        ///////////////////////
        $insBasuCONV = $this->db->insert('basundhar_application',$basundhara);
        if($insBasuCONV != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRCONV004: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRCONV004: Registration of AP TO PP CONVERSION failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            $data=array(
                'error'=>"Error in submitting. Please try Again"
            );
            echo json_encode($data);
            return;
        }
        //$this->db->trans_commit();
        $data=array(
                'success'=>"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no]",
            );
        echo json_encode($data);
    }
    function testNum(){
        echo $this->utilityclass->assToeng('২১৭(ক)');
        echo $this->utilityclass->cassnumfordags('211');
        echo $this->utilityclass->cassnum('২১৭(ক)');
    }
	
}
