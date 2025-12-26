<?php

ini_set('memory_limit', '-1');

class JamabandiControllerBondita extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('jamabandi/JamabandiModel');
        $this->load->model('mutation/mutationmodel');
    }

    public function menu() {
        // $this->load->helper('html');
        // $this->load->view('header');
        // $this->load->view('jamabandi/menu_for_jamabandi_generation');
        // $this->load->view('footer');
		$main['_view'] = 'jamabandi/menu_for_jamabandi_generation';
        $this->load->view('layouts/main',$main);
    }
    
    // Generation multiple patta jamabandi report
    public function districtDetails() {
		//$this->dbswitch();
        // $this->load->helper('html');
        // $this->load->view('header');

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
        $district['patta_no'] = $this->JamabandiModel->getPattano();
        //$this->load->view('jamabandi/select_district_by_selecting_a_pattano', $district);
        //$this->load->view('footer');

        $district['_view'] = 'jamabandi/select_district_by_selecting_a_pattano';
        $this->load->view('layouts/main',$district);
    }
    
    public function saveJamabandiByPattano() {
		//$this->dbswitch();
        //jama by selecting pattano begins here
        $main = array();
        $jamainfo = array();
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        $mouza_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');

        $pattatypeCode = $this->input->post('patta_type');
        $pdar_alignment = $this->input->post('pdaralign');
        $patta_no_lower = trim($this->input->post('patta_no_lower'));
        $patta_no_upper = trim($this->input->post('patta_no_upper'));
        
        $pattatype = array(
            'patta_type' => $pattatypeCode,
        );
        $this->load->model('misreport/MisModel');

        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $lotdata = $this->MisModel->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
        $pattatypename = $this->MisModel->getpattatypeNameforJamabandi($pattatypeCode);
        
        $main['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata, $pattatypename);
        $main['pattainfoPtyp'] = $pattatype;
        
        $main['daginfo'] = array();
        
        $get_patta_info = "select * from    jama_patta WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' "
                . "and patta_no >='$patta_no_lower' order by length(patta_no),patta_no";
        
//        $get_patta_info = "select * from    jama_patta WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
//                . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' "
//                . "and nullif(patta_no, '')::int >='$patta_no_lower' and nullif(patta_no, '')::int <='$patta_no_upper'";
        
        $pattainfo= $this->db->query($get_patta_info)->result();
//        if ($this->db->simple_query($get_patta_info))
//        {
//            $pattainfo= $this->db->query($get_patta_info)->result();
//        }
//        else
//        {
//            //send to a different page for junk patta updation. This is when the query fails.
//            $this->session->set_flashdata('message', "This Patta Type Consists Of Junk Patta. Please Update all necessary Patta numbers.");
//            redirect(base_url() . "index.php/utility/modifydagpatta/$pattatypeCode/$dist_code/$subdiv_code/$circle_code/$mouza_code/$lot_no/$vill_code");
//        }
        
        $pattainfocounted = count($pattainfo);
        
        if ($pattainfocounted != "") {
            $main['pattainfo'][] = $pattainfo;
            $count = 1;
            
            foreach ($pattainfo as $patta_no) {
                $pno = trim($patta_no->patta_no);
                $main['details'][$pno] = array();
                
                $query = "select jd.dag_no,jd.dag_revenue,jd.dag_localtax,jd.dag_area_b,jd.dag_area_k,jd.dag_area_lc,jd.dag_area_g,lcd.land_type,lcd.class_code_cat from    "
                        . "jama_dag as jd  JOIN   landclass_code as lcd ON jd.dag_class_code=lcd.class_code WHERE jd.dist_code='$dist_code' and jd.subdiv_code = '$subdiv_code' and jd.cir_code='$circle_code' and "
                        . "jd.mouza_pargona_code = '$mouza_code' and jd.lot_no = '$lot_no' and jd.vill_townprt_code='$vill_code' and "
                        . "jd.patta_type_code='$pattatypeCode' and TRIM(jd.patta_no)=trim('$patta_no->patta_no') order by length(jd.dag_no)";

                $main['details'][$pno]['daginfo'] = $this->db->query($query)->result();
                
                if($main['details'][$pno]['daginfo'] != null){
                    $query = "select patta_no, pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc,pdar_land_g  "
                            . "from    jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                            . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
                            . "patta_type_code='$pattatypeCode' and TRIM(patta_no)=trim('$patta_no->patta_no')  order by length(pdar_id), pdar_id ";

                    $main['details'][$pno]['pattadarinf'] = $this->db->query($query)->result();
                } else {
                    $main['details'][$pno]['pattadarinf']=null;
                }

                $query = "select patta_no,remark,rmk_line_no from    jama_remark WHERE "
                        . "dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                        . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and "
                        . "vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and "
                        . "TRIM(patta_no)=trim('$patta_no->patta_no') order by rmk_line_no";

                $main['details'][$pno]['remarkinf'] = $this->db->query($query)->result();

                $query = "select old_patta_no from    jama_patta WHERE "
                        . "dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                        . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and "
                        . "vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and "
                        . "TRIM(patta_no)='$pno' ";
                $main['details'][$pno]['oldpattano'] = $this->db->query($query)->result();
            }
            if ($count == 1) {
                $count++;
            }
            //var_dump($main);
            // $this->load->helper('html');
            // $this->load->view('header');
            // $this->load->view('jamabandi/save_jamabandi_by_selecting_pattano', $main);

            $dist_code = $this->session->userdata('dist_code');
            if(in_array($dist_code, json_decode(BARAK_VALLEY)))
            {
            $main['_view'] = 'jamabandi/save_jamabandi_by_selecting_pattano_kar';
            }
            else{
            $main['_view'] = 'jamabandi/save_jamabandi_by_selecting_pattano';

            }

            $this->load->view('layouts/main',$main);
        } else {
            //echo 'no jamabandi found';
            // $this->load->helper('html');
            // $this->load->view('header');
            // $this->load->view('jamabandi/no_jamabandi');

            $data['_view'] = 'jamabandi/no_jamabandi';
            $this->load->view('layouts/main',$data);
        } 
        //$this->load->view('footer');
    }

    public function districtDetails_r() {
		//$this->dbswitch();
        // $this->load->helper('html');
        // $this->load->view('header');

       

        $dist_code = $this->session->userdata('dist_code');
        //echo  $dist_code;
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
        $district['patta_no'] = $this->JamabandiModel->getPattano();
        // $this->load->view('jamabandi/select_district_by_selecting_a_pattano_r', $district);
        // $this->load->view('footer');


        $district['_view'] = 'jamabandi/select_district_by_selecting_a_pattano_r';
        $this->load->view('layouts/main',$district);
    }

    public function districtDetailsForEnteringPattano_r() {
		//$this->dbswitch();
        // $this->load->helper('html');
        // $this->load->view('header');

        $dist_code = $this->session->userdata('dist_code');
        //echo  $dist_code;
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
        $district['patta_no'] = $this->JamabandiModel->getPattano();
        // $this->load->view('jamabandi/select_district_by_entering_a_pattano_r', $district);
        // $this->load->view('footer');

        $district['_view'] = 'jamabandi/select_district_by_entering_a_pattano_r';
        $this->load->view('layouts/main',$district);
    }

    public function districtDetailsBYselectingPattatype_r() {
		//$this->dbswitch();
        // $this->load->helper('html');
        // $this->load->view('header');

        $dist_code = $this->session->userdata('dist_code');
        //echo  $dist_code;
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
        $district['patta_no'] = $this->JamabandiModel->getPattano();
        // $this->load->view('jamabandi/select_district_by_pattatype_r', $district);
        // $this->load->view('footer');

        $district['_view'] = 'jamabandi/select_district_by_pattatype_r';
        $this->load->view('layouts/main',$district);
    }

    

    public function districtDetailsForEnteringPattano() {
		$db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('header');

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
        // $this->load->view('jamabandi/select_district_by_entering_a_pattano', $district);
        // $this->load->view('footer');
		$district['_view'] = 'jamabandi/select_district_by_entering_a_pattano';
        $this->load->view('layouts/main',$district);
    }

    public function districtDetailsBYselectingPattatype() {
		//$this->dbswitch();
        //$this->load->helper('html');
       // $this->load->view('header');

        $district['patta'] = $this->JamabandiModel->getPattaType();
        
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

        //$this->load->view('jamabandi/select_district_by_pattatype', $district);

        $district['_view'] = 'jamabandi/select_district_by_pattatype';
        $this->load->view('layouts/main',$district);

        //$this->load->view('footer');
    }

    public function districtDetailsBYpattadarname() {
		//$this->dbswitch();
        // $this->load->helper('html');
        // $this->load->view('header');

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

        // $this->load->view('jamabandi/select_district_pattadarname', $district);
        // $this->load->view('footer');

        $district['_view'] = 'jamabandi/select_district_pattadarname';
        $this->load->view('layouts/main',$district);
    }

    public function getpattaTypebyname($d, $s, $c, $m, $l, $v, $p) {
		//$this->dbswitch();
        if($d=='' || $s=='' || $c=='' || $m=='' || $l=='' || $v=='' || $p=='') {
            $json[]=array('error'=>'Empty Input');
            echo json_encode($json);
            exit;
        }
        if(!preg_match('/^[0-9]*$/', $d) || !preg_match('/^[0-9]*$/', $s) || !preg_match('/^[0-9]*$/', $c) || !preg_match('/^[0-9]*$/', $m) || !preg_match('/^[0-9]*$/', $l) || !preg_match('/^[0-9]*$/', $v) || !preg_match('/^[0-9]*$/', $p)) {
            $json[]=array('error'=>'Invalid Input Request');
            echo json_encode($json);
            exit;
        }
        //authentication
        $sessionData = $this->session->all_userdata();
        if(empty($sessionData)) {
            $json[]=array('error'=>'User not Authenticated!');
            echo json_encode($json);
            exit;
        }
        if($p == 0000)
        {
            $pattano = $this->db->query("Select patta_no from jama_patta where dist_code=? and subdiv_code = ? and cir_code=? and "
                . "mouza_pargona_code = ? and lot_no = ? and vill_townprt_code=? order by length(patta_no),patta_no", array($d, $s, $c, $m, $l, $v));//order by CAST(coalesce(patta_no, '0') AS varchar)");
        }
        else
        {
            $pattano = $this->db->query("Select patta_no from jama_patta where dist_code=? and subdiv_code = ? and cir_code=? and "
                . "mouza_pargona_code = ? and lot_no = ? and vill_townprt_code=? and "
                . "patta_type_code=? order by length(patta_no),patta_no", array($d, $s, $c, $m, $l, $v, $p));//order by CAST(coalesce(patta_no, '0') AS varchar)");
        }
        
        $data = $pattano->result();
        $json = array();
        foreach ($data as $object) {
            $json[] = array('patta_no' => trim($object->patta_no));
        }
        echo json_encode($json);
    }

    public function saveJamabandiByPattano_old() {
		//$this->dbswitch();
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        $mouza_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');

        $pattatypeCode = $this->input->post('patta_type');

        $patta_no = trim($this->input->post('patta_no'));

        $pattatype = array(
            'patta_type' => $pattatypeCode,
            'patta_no' => $patta_no
        );


        $this->load->model('misreport/MisModel');

        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $lotdata = $this->MisModel->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
        $pattatypename = $this->MisModel->getpattatypeNameforJamabandi($pattatypeCode);
        //$maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata, $pattaArray);

        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata, $pattatypename);
        $maindata['pattainfo'] = $pattatype;
        
        $this->load->model('jamabandi/JamabandiModel');

        $Jama_bandi_info['jamabandiInfo'] = $this->JamabandiModel->getpattadarinfo($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $patta_no, $pattatypeCode);

        $main = array_merge($maindata, $Jama_bandi_info);

        // $this->load->helper('html');
        // $this->load->view('header');
        // $this->load->view('jamabandi/save_jamabandi_by_selecting_pattano', $main);
        // $this->load->view('footer');


        $main['_view'] = 'jamabandi/save_jamabandi_by_selecting_pattano';
        $this->load->view('layouts/main',$main);
    }

    

//    public function saveJamabandiByEnteringPattano_old() {
//        $dist_code = $this->input->post('dist_code');
//        $subdiv_code = $this->input->post('subdiv_code');
//        $circle_code = $this->input->post('circle_code');
//        $mouza_code = $this->input->post('mouza_code');
//        $lot_no = $this->input->post('lot_no');
//        $vill_code = $this->input->post('vill_code');
//
//        $pattatypeCode = $this->input->post('patta_type');
//
//        $patta_no = trim($this->input->post('patta_no'));
//
//        $pattatype = array(
//            'patta_type' => $pattatypeCode,
//            'patta_no' => $patta_no
//        );
//
//
//        $this->load->model('misreport/MisModel');
//
//        $districtdata = $this->MisModel->getDistrictName($dist_code);
//        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
//        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
//        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
//        $lotdata = $this->MisModel->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
//        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
//        //$pattatypename = $this->MisModel->getpattatypeNameforJamabandi($pattatypeCode);
//
//        $this->load->model('misreport/MisReportModelBondita');
//        $pattatypename = $this->MisReportModelBondita->getpattatypeNameforJamabandi($pattatypeCode);
//        //$maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata, $pattaArray);
//
//        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata, $pattatypename);
//        $maindata['pattainfo'] = $pattatype;
//        // print_r($maindata['namedata']);
//
//
//        $this->load->model('jamabandi/JamabandiModel');
//
//        $Jama_bandi_info['jamabandiInfo'] = $this->JamabandiModel->getpattadarinfo($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $patta_no, $pattatypeCode);
//        //var_dump($Jama_bandi_info['jamabandiInfo']);
//        //$bigha= $Jama_bandi_info->bigha;
//        //echo $bigha;
//        // $Jama_remark_info['remarkInfo'] = $this->JamabandiModel->getRemarkinfo($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $patta_no, $pattatypeCode);
//        $main = array_merge($maindata, $Jama_bandi_info);
//        //var_dump($main);
//        $this->load->helper('html');
//        $this->load->view('header');
//        $this->load->view('jamabandi/save_jamabandi_by_entering_a_pattano', $main);
//        $this->load->view('footer');
//    }

    public function dbswitch(){       
     $CI=&get_instance();
     if($this->session->userdata('dist_code') == "02"){
        $this->db=$CI->load->database('dha3', TRUE);    
     } else if($this->session->userdata('dist_code') == "05"){
        $this->db=$CI->load->database('dha1', TRUE);    
      } else if($this->session->userdata('dist_code') == "10"){
        $this->db=$CI->load->database('dha24', TRUE);       
     } else if($this->session->userdata('dist_code') == "13"){
        $this->db=$CI->load->database('dha2', TRUE);    
     }  else if($this->session->userdata('dist_code') == "17"){
        $this->db=$CI->load->database('dha4', TRUE);    
     }  else if($this->session->userdata('dist_code') == "15"){
        $this->db=$CI->load->database('dha5', TRUE);    
     }  else if($this->session->userdata('dist_code') == "14"){
        $this->db=$CI->load->database('dha6', TRUE);    
     }  else if($this->session->userdata('dist_code') == "07"){
        $this->db=$CI->load->database('dha7', TRUE);    
     }  else if($this->session->userdata('dist_code') == "03"){
        $this->db=$CI->load->database('dha8', TRUE);    
     }  else if($this->session->userdata('dist_code') == "18"){
        $this->db=$CI->load->database('dha9', TRUE);    
     }  else if($this->session->userdata('dist_code') == "12"){
        $this->db=$CI->load->database('dha13', TRUE);   
     }  else if($this->session->userdata('dist_code') == "24"){
        $this->db=$CI->load->database('dha10', TRUE);   
     }  else if($this->session->userdata('dist_code') == "06"){
        $this->db=$CI->load->database('dha11', TRUE);   
     }  else if($this->session->userdata('dist_code') == "11"){
        $this->db=$CI->load->database('dha12', TRUE);   
     }  else if($this->session->userdata('dist_code') == "12"){
        $this->db=$CI->load->database('dha13', TRUE);   
     }  else if($this->session->userdata('dist_code') == "16"){
        $this->db=$CI->load->database('dha14', TRUE);   
     }  else if($this->session->userdata('dist_code') == "32"){
        $this->db=$CI->load->database('dha15', TRUE);   
     }  else if($this->session->userdata('dist_code') == "33"){
        $this->db=$CI->load->database('dha16', TRUE);   
     }  else if($this->session->userdata('dist_code') == "34"){
        $this->db=$CI->load->database('dha17', TRUE);   
     }  else if($this->session->userdata('dist_code') == "21"){
        $this->db=$CI->load->database('dha18', TRUE);   
     }  else if($this->session->userdata('dist_code') == "08"){
        $this->db=$CI->load->database('dha19', TRUE);   
     }  else if($this->session->userdata('dist_code') == "35"){
        $this->db=$CI->load->database('dha20', TRUE);   
     }  else if($this->session->userdata('dist_code') == "36"){
        $this->db=$CI->load->database('dha21', TRUE);   
     }  else if($this->session->userdata('dist_code') == "37"){
        $this->db=$CI->load->database('dha22', TRUE);   
     }  else if($this->session->userdata('dist_code') == "25"){
        $this->db=$CI->load->database('dha23', TRUE);   
     }                                                                                                                                                                                                              
}

    public function saveJamabandiByEnteringPattano() {
        
        //xss and sqlinjection validation starts here by deep
        $errorMessageStr = '';
        $message = NULL;
            $resp = checkRequestSpecChar($_POST);
            if($resp['status'] == 'n'){
                $errorMessageStr .= $resp['messages'];
            }

            $resp = checkRequestValidQuery($_POST);
            if($resp['status'] == 'n'){
                $errorMessageStr .= $resp['messages'];
            }
            if($errorMessageStr != ''){
                $message = $errorMessageStr;
                $main['message'] = $message;
                $main['_view'] = 'jamabandi/no_jamabandi';
                $this->load->view('layouts/main',$main);
           }
        //xss and sqlinjection validation starts here by deep  
		//$this->dbswitch();
        //display jama by entering pattano new beigns here
        $main = array();
        $jamainfo = array();
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        $mouza_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');

        $pattatypeCode = $this->input->post('patta_type');
        $pdar_alignment = $this->input->post('pdaralign');
        $patta_no = trim($this->input->post('patta_no'));

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
        $get_patta_info="select jp.patta_no from jama_patta jp join jama_dag jd on
                jp.dist_code=jd.dist_code and jp.subdiv_code=jd.subdiv_code and jp.cir_code=jd.cir_code
                and jp.mouza_pargona_code=jd.mouza_pargona_code and jp.lot_no=jd.lot_no and jp.vill_townprt_code=jd.vill_townprt_code
                and jp.patta_no=jd.patta_no and jp.patta_type_code=jd.patta_type_code
         WHERE jd.dist_code='$dist_code' and jd.subdiv_code = '$subdiv_code' and jd.cir_code='$circle_code' and "
                . "jd.mouza_pargona_code = '$mouza_code' and jd.lot_no = '$lot_no' and jd.vill_townprt_code='$vill_code' and "
                . "jd.patta_type_code='$pattatypeCode' and jd.patta_no='$patta_no'";
        // $get_patta_info = "select count(*) as count from    jama_patta WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
        //         . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno'";
        $get_patta_info= $this->db->query($get_patta_info);
        if($get_patta_info->num_rows()> 0){
            $query = "select jd.dag_no,jd.dag_revenue,jd.dag_localtax,jd.dag_area_b,jd.dag_area_k,jd.dag_area_lc,jd.dag_area_g,lcd.land_type,lcd.class_code_cat from    "
                . "jama_dag as jd  JOIN   landclass_code as lcd ON jd.dag_class_code=lcd.class_code WHERE jd.dist_code='$dist_code' and jd.subdiv_code = '$subdiv_code' and jd.cir_code='$circle_code' and "
                . "jd.mouza_pargona_code = '$mouza_code' and jd.lot_no = '$lot_no' and jd.vill_townprt_code='$vill_code' and "
                . "jd.patta_type_code='$pattatypeCode' and TRIM(jd.patta_no)='$pno' order by length(dag_no)";
        
            $main['daginfo'] = $this->db->query($query)->result();
            $daginfo_counted = count($main['daginfo']);
            
            $main['sort_pdar_by']=$pdar_alignment;
            if ($daginfo_counted != "") {
                if ($pdar_alignment == '0') {
                    $query = "select pdar_sl_no,patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc,pdar_land_g "
                            . "from    jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                            . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
                            . "patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno' order by length(pdar_id), pdar_id";
                    $q = $this->db->query($query)->result();
                    
                    $q1 = array();
                    
                }
                if ($pdar_alignment == '1') {
                    $query = "select pdar_sl_no,patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc,pdar_land_g "
                            . "from    jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                            . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
                            . "patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno' and pdar_sl_no > 0 order by pdar_sl_no asc";
                    $q = $this->db->query($query)->result();
                    
                    $query1 = "select pdar_sl_no,patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc,pdar_land_g "
                            . "from    jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                            . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
                            . "patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno' and (pdar_sl_no = 0 or pdar_sl_no is null) order by cast(pdar_id as integer) asc";
                    
                    $q1 = $this->db->query($query1)->result();
                }
                $main['pattadarinf'] = array_merge($q,$q1);
            } else { 
                //If dag and patta for old patta does not exist.
                $main['pattadarinf'] = null;
                $main['daginfo'] = null;
            }
            $query = "select patta_no,remark,rmk_line_no,entry_mode,user_code,dist_code,subdiv_code,cir_code,entry_date from    jama_remark WHERE "
                    . "dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                    . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and "
                    . "vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and "
                    . "TRIM(patta_no)='$pno' order by rmk_line_no ";
            $main['remarkinf'] = $this->db->query($query)->result();
			//var_dump($main['remarkinf']);

            $query = "select old_patta_no,entry_date from    jama_patta WHERE "
                    . "dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                    . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and "
                    . "vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and "
                    . "TRIM(patta_no)='$pno' ";
            $main['oldpno'] = $this->db->query($query)->result();

            $main = array_merge($maindata, $main);

            // $this->load->helper('html');
            // $this->load->view('header');
            // $this->load->view('jamabandi/save_jamabandi_by_entering_a_pattano', $main);
            $dist_code = $this->session->userdata('dist_code');
            if(in_array($dist_code, json_decode(BARAK_VALLEY)))
            {
			$main['_view'] = 'jamabandi/save_jamabandi_by_entering_a_pattano_kar';
            }
            else{
            $main['_view'] = 'jamabandi/save_jamabandi_by_entering_a_pattano';
            }
			$this->load->view('layouts/main',$main);
        } else {
            //echo 'no jamabandi found';
            // $this->load->helper('html');
            // $this->load->view('header');
            //$this->load->view('jamabandi/no_jamabandi');
			$main['_view'] = 'jamabandi/no_jamabandi';
			$this->load->view('layouts/main',$main);
        } 
        //$this->load->view('footer');
    }

    public function displayjamabandiByPattatypeold() {
		//$this->dbswitch();
        $main = array();
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        $mouza_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');

        $pattatypeCode = $this->input->post('patta_type');

        // $patta_no = $this->input->post('patta_no');

        $pattatype = array(
            'patta_type' => $pattatypeCode,
                //'patta_no' => $patta_no
        );


        $this->load->model('misreport/MisModel');

        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $lotdata = $this->MisModel->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
        $pattatypename = $this->MisModel->getpattatypeNameforJamabandi($pattatypeCode);
        //$maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata, $pattaArray);

        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata, $pattatypename);
        $maindata['pattainfo'] = $pattatype;
        // print_r($maindata['namedata']);


        $this->load->model('jamabandi/JamabandiModel');
        $Jama_bandi_info['jamabandiInfo'] = $this->JamabandiModel->getjamainfoPattatype($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $pattatypeCode);
        // print_r($Jama_bandi_info['jamabandiInfo']);
        //$bigha= $Jama_bandi_info->bigha;
        //echo $bigha;
        // $Jama_remark_info['remarkInfo'] = $this->JamabandiModel->getRemarkinfo($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $patta_no, $pattatypeCode);
        $main = array_merge($maindata, $Jama_bandi_info);
        // $this->load->helper('html');
        // $this->load->view('header');
        // $this->load->view('jamabandi/saveJamabandibyPattatype', $main);
        // $this->load->view('footer');

        $main['_view'] = 'jamabandi/saveJamabandibyPattatype';
        $this->load->view('layouts/main',$main);

    }

    public function displayjamabandiByPattatype() {
		//$this->dbswitch();
        $main = array();
        $jamainfo = array();
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        $mouza_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');

        $pattatypeCode = $this->input->post('patta_type');

        $pattatype = array(
            'patta_type' => $pattatypeCode,
        );
        
        $this->load->model('misreport/MisModel');

        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $lotdata = $this->MisModel->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
        $pattatypename = $this->MisModel->getpattatypeNameforJamabandi($pattatypeCode);
        
        $main['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata, $pattatypename);
        $main['pattainfoPtyp'] = $pattatype;
        
        $query = "select jp.patta_no from    jama_patta jp join jama_dag jd on
                jp.dist_code=jd.dist_code and jp.subdiv_code=jd.subdiv_code and jp.cir_code=jd.cir_code
                and jp.mouza_pargona_code=jd.mouza_pargona_code and jp.lot_no=jd.lot_no and jp.vill_townprt_code=jd.vill_townprt_code
                and jp.patta_no=jd.patta_no and jp.patta_type_code=jd.patta_type_code
         WHERE jd.dist_code='$dist_code' and jd.subdiv_code = '$subdiv_code' and jd.cir_code='$circle_code' and "
                . "jd.mouza_pargona_code = '$mouza_code' and jd.lot_no = '$lot_no' and jd.vill_townprt_code='$vill_code' and "
                . "jd.patta_type_code='$pattatypeCode' and jd.patta_no!='' ";//order by CAST(coalesce(patta_no, '0') AS numeric)
        $pattainfo = $this->db->query($query)->result();
        if($pattainfo) {
            $main['pattainfo'][] = $pattainfo;
            $count = 1;
            foreach ($pattainfo as $patta_no) {
                $pno = trim($patta_no->patta_no);
                $main['details'][$pno] = array();
                
                $query = "select jd.dag_no,jd.dag_revenue,jd.dag_localtax,jd.dag_area_b,jd.dag_area_k,jd.dag_area_lc,jd.dag_area_g,lcd.land_type,lcd.class_code_cat from    "
                        . "jama_dag as jd  JOIN  landclass_code as lcd ON jd.dag_class_code=lcd.class_code
                         WHERE jd.dist_code='$dist_code' and jd.subdiv_code = '$subdiv_code' and jd.cir_code='$circle_code' and "
                        . "jd.mouza_pargona_code = '$mouza_code' and jd.lot_no = '$lot_no' and jd.vill_townprt_code='$vill_code' and "
                        . "jd.patta_type_code='$pattatypeCode' and TRIM(jd.patta_no)=trim('$patta_no->patta_no') order by length(jd.dag_no)";
                if($this->db->query($query)->num_rows()==0){
                    $main['details'][$pno]['daginfo'] = null;
                    $main['details'][$pno]['pattadarinf']=null;
                    continue;
                }
                $main['details'][$pno]['daginfo'] = $this->db->query($query)->result();
                if($main['details'][$pno]['daginfo'] != null){
                    $query = "select patta_no, pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc,pdar_land_g  "
                            . "from    jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                            . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
                            . "patta_type_code='$pattatypeCode' and TRIM(patta_no)=trim('$patta_no->patta_no')  order by length(pdar_id), pdar_id ";

                    $main['details'][$pno]['pattadarinf'] = $this->db->query($query)->result();
                } else {
                    $main['details'][$pno]['pattadarinf']=null;
                }

                $query = "select patta_no,remark,rmk_line_no from    jama_remark WHERE "
                        . "dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                        . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and "
                        . "vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and "
                        . "TRIM(patta_no)=trim('$patta_no->patta_no') order by rmk_line_no";

                $main['details'][$pno]['remarkinf'] = $this->db->query($query)->result();

                $query = "select old_patta_no from    jama_patta WHERE "
                        . "dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                        . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and "
                        . "vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and "
                        . "TRIM(patta_no)='$pno' ";
                $main['details'][$pno]['oldpattano'] = $this->db->query($query)->result();
            }
            if ($count == 1) {
                $count++;
            }
            // $this->load->helper('html');
            // $this->load->view('header');
            // $this->load->view('jamabandi/savePattatype', $main);
            $dist_code = $this->session->userdata('dist_code');
            if(in_array($dist_code, json_decode(BARAK_VALLEY)))
            {
            $main['_view'] = 'jamabandi/savePattatype_kar';
            }
            else{
              $main['_view'] = 'jamabandi/savePattatype';   
            }

            $this->load->view('layouts/main',$main);

        } else {
            //echo "no jamabandi found";
            // $this->load->helper('html');
            // $this->load->view('header');
            // $this->load->view('jamabandi/no_jamabandi');

            $data['_view'] = 'jamabandi/no_jamabandi';
            $this->load->view('layouts/main',$data);
        }
       // $this->load->view('footer');
    }

    public function displayjamabandiByPattadarname() {
        //$this->dbswitch();
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $circle_code = $this->input->post('circle_code');
        $mouza_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');

        $pattadar_name = trim(mysql_real_escape_string($this->input->post('pattadar_name')));

        // $patta_no = $this->input->post('patta_no');

        $pattadarname = array(
            //'patta_type' => $pattatypeCode,
            'pattadarname' => $pattadar_name
        );


        $this->load->model('misreport/MisModel');

        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $lotdata = $this->MisModel->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
        //$pattatypename = $this->MisModel->getpattatypeNameforJamabandi($pattatypeCode);
        //  $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata, $pattaArray);

        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata);
        $maindata['pattadarinfo'] = $pattadarname;
        //print_r($maindata['namedata']);


        $this->load->model('jamabandi/JamabandiModel');
        $Jama_bandi_info['jamabandiInfo'] = $this->JamabandiModel->getjamainfoPattadarname($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $pattadar_name);
        //print_r($Jama_bandi_info['jamabandiInfo']);
        //$bigha= $Jama_bandi_info->bigha;
        //echo $bigha;
        // $Jama_remark_info['remarkInfo'] = $this->JamabandiModel->getRemarkinfo($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $patta_no, $pattatypeCode);
        $main = array_merge($maindata, $Jama_bandi_info);
        // $this->load->helper('html');
        // $this->load->view('header');
        // $this->load->view('jamabandi/saveJamabandibypattadarname', $main);
        // $this->load->view('footer');

        $main['_view'] = 'jamabandi/saveJamabandibypattadarname';
        $this->load->view('layouts/main',$main);

    }

    public function getpattaJSONJamabandi($distCode, $subdivcode, $circode, $mouzacode, $lotno, $villagecode, $patta_code) {
		//$this->dbswitch();

        $data = $this->mutationmodel->getPattanoJSON($distCode, $subdivcode, $circode, $mouzacode, $lotno, $villagecode, $patta_code);
        $json = array();

        foreach ($data as $object) {
            $json[] = array('patta_no' => trim($object->patta_no));
        }
        echo json_encode($json);
    }
	public function getpattaTypebynameGrant($d, $s, $c, $m, $l, $v, $p) {
		//$this->dbswitch();
        
        if($p == 0000)
        {
            $pattano = $this->db->query("Select distinct(patta_no) from    chitha_basic where dist_code='$d' and subdiv_code = '$s' and cir_code='$c' and "
                . "mouza_pargona_code = '$m' and lot_no = '$l' and vill_townprt_code='$v' order by length(patta_no),patta_no");//order by CAST(coalesce(patta_no, '0') AS varchar)");
        }
        else
        {
			
           $pattano = $this->db->query("Select distinct(patta_no) from    chitha_basic where dist_code='$d' and subdiv_code = '$s' and cir_code='$c' and "
                . "mouza_pargona_code = '$m' and lot_no = '$l' and vill_townprt_code='$v' and "
                . "patta_type_code='$p' ");
       
		}
        
        $data = $pattano->result();
		
        $json = array();
        foreach ($data as $object) {
            $json[] = array('patta_no' => trim($object->patta_no));
        }
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }

}