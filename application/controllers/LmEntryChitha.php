<?php

class LmEntryChitha extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('lmEntryChithaModel/LmEntryChithaModel');
    }

    public function menulm() {
		//$db=  $this->session->userdata('db');
        // s
        // var_dump($this->session->all_userdata());
        $lm_code = $this->session->userdata('user_code');
        //$lm_code = 'M117';
        // $this->session->set_userdata($lm_code);
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');

        $location = $this->db->query("Select * from    lm_code where lm_code='$lm_code' and dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no'")->row();
        $locationinfo = $this->db->query("select * from    location where dist_code='$location->dist_code' and subdiv_code='$location->subdiv_code' and cir_code='$location->cir_code' and mouza_pargona_code ='$location->mouza_pargona_code' and lot_no ='$location->lot_no' and vill_townprt_code != '00000'")->result();
        $dist_name = $this->db->query("select loc_name from    location where dist_code='$location->dist_code' and subdiv_code='00' and cir_code='00' and mouza_pargona_code ='00' and lot_no ='00' and vill_townprt_code = '00000'")->row();
        $subdiv_name = $this->db->query("select loc_name from    location where dist_code='$location->dist_code' and subdiv_code='$location->subdiv_code' and cir_code='00' and mouza_pargona_code ='00' and lot_no ='00' and vill_townprt_code = '00000'")->row();
        $circle_name = $this->db->query("select loc_name from    location where dist_code='$location->dist_code' and subdiv_code='$location->subdiv_code' and cir_code='$location->cir_code' and mouza_pargona_code ='00' and lot_no ='00' and vill_townprt_code = '00000'")->row();
        $mouza_name = $this->db->query("select loc_name from    location where dist_code='$location->dist_code' and subdiv_code='$location->subdiv_code' and cir_code='$location->cir_code' and mouza_pargona_code ='$location->mouza_pargona_code' and lot_no ='00' and vill_townprt_code = '00000'")->row();
        $lot_name = $this->db->query("select loc_name from    location where dist_code='$location->dist_code' and subdiv_code='$location->subdiv_code' and cir_code='$location->cir_code' and mouza_pargona_code ='$location->mouza_pargona_code' and lot_no ='$location->lot_no' and vill_townprt_code = '00000'")->row();

        $villageinfo['name'] = array(
            'distname' => $dist_name->loc_name,
            'sub_divname' => $subdiv_name->loc_name,
            'cir_codename' => $circle_name->loc_name,
            'mouza_codename' => $mouza_name->loc_name,
            'lot_noname' => $lot_name->loc_name,
        );
        //var_dump($villageinfo);
        $villageinfo['loc'] = array(
            'dist' => $location->dist_code,
            'sub_div' => $location->subdiv_code,
            'cir_code' => $location->cir_code,
            'mouza_code' => $location->mouza_pargona_code,
            'lot_no' => $location->lot_no,
        );
        $this->session->set_userdata($villageinfo['loc']);
        $this->session->set_userdata($villageinfo['name']);
        // var_dump($locationinfo);   
        $villageinfo['lmVillageinfo'] = $locationinfo;

        //$this->load->view('LmEntryChithaView/location_selection', $villageinfo);
        // $this->load->view('LmEntryChithaView/location_selection'villageinfo);
        //$this->load->view('footer');


        $villageinfo['_view'] = 'LmEntryChithaView/location_selection';
        $this->load->view('layouts/main',$villageinfo);
    }

    public function locationSelection() {
		$db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('header');
        //echo 'bonny';
        // $vill_code = $this->input->post('vill_code');

        if (isset($_POST['backButton'])) {
            $vill_code = $this->input->post('vill_code');
        } else {
            $vill_code = $this->input->post('vill_code');
        }
        // echo $vill_code;
        $village = array(
            'vill_code' => $vill_code
        );
        $this->session->set_userdata($village);
        $vill_code = $this->session->userdata('vill_code');
        // echo 'vcode'. $vill_codett ;
        // print_r($this->session->all_userdata());
        $dist_code = $this->session->userdata('dist');
        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        // echo $lot_no;     
//if($vill_code == ""){
        //$vill_code = $this->session->userdata('vill_code');  
//}


        $locationinfoDag = $this->db->query("select dag_no FROM  chitha_basic WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' Order BY length(dag_no)")->result();
        //$sql="select loc_name FROM location WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code'";
        //echo $sql;
        $villagename = $this->db->query("select loc_name FROM  location WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code'")->row();
        //   $pattano = $this->db->query("select patta_no FROM chitha_basic WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$locationinfoDag->dag_no'")->row();
        //  echo "select loc_name FROM location WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code'";       
        //var_dump($villagename);
        //var_dump($locationinfoDag);
        $daginfo['lmDaginfo'] = $locationinfoDag;
        $daginfo['villname'] = array(
            'villname' => $villagename->loc_name,
        );
        $this->session->set_userdata($daginfo['villname']);
        // $this->session->set_userdata($daginfo['lmDaginfo']);
        // var_dump($daginfo);
        // $this->load->view('LmEntryChithaView/selectDagLm', $daginfo);
        // $this->load->view('footer');


        $daginfo['_view'] = 'LmEntryChithaView/selectDagLm';
        $this->load->view('layouts/main',$daginfo);
		
    }

    public function menuforSelectingOption() {
		
		$db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('header');
        if (isset($_POST['submit']) == 'submit') {
            $Dag_no = $this->input->post('Dag_no');
            $dagno = array(
                'dagnum' => $Dag_no
            );
            $this->session->set_userdata($dagno);
        } else {
            $Dag_no = $this->session->userdata('dagnum');
        }

        //nov4 2016

        $dist_code = $this->session->userdata('dist');
        //echo $dist_code;
        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');

        $Dag_no = $this->session->userdata('dagnum');

        // mcorp
        $sql = "Select * from    chitha_mcrop WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' "
                . "and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'";
        
        $data['rowMcrop'] = $this->db->query($sql)->num_rows();
        //var_dump($data);


        //
        //non crop

        $sql = "Select * from    chitha_noncrop WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' "
                . "and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'";
        $data['rownoncrop'] = $this->db->query($sql)->num_rows();

        //
        //chitha fruit
        $sql = "Select * from    chitha_fruit WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' "
                . "and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'";
        $data['rowfruit'] = $this->db->query($sql)->num_rows();

        //
        //chitha archeo

        $sql = "Select * from    chitha_acho_hist WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' "
                . "and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'";
        $data['rowacho'] = $this->db->query($sql)->num_rows();


        //
        // lotmondol
        $sql = "Select * from    chitha_rmk_lmnote WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' "
                . "and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'";
        $data['rowlmnote'] = $this->db->query($sql)->num_rows();

        //
        //enchro

        $sql = "Select * from    chitha_rmk_encro WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' "
                . "and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'";
        $data['rowencro'] = $this->db->query($sql)->num_rows();

        //

        $pattainfo = $this->db->query("select patta_no,patta_type_code,land_class_code,dag_area_b,dag_area_k,dag_area_lc,dag_revenue,dag_local_tax FROM chitha_basic WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'")->row();
        //echo "select patta_no,patta_type_code FROM chitha_basic WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' ";
        $pattatype_code = $pattainfo->patta_type_code;
        $this->session->set_userdata($pattatype_code);
        $basic_details_bigha = $pattainfo->dag_area_b;
        $basic_details_katha = $pattainfo->dag_area_k;
        $basic_details_lessa = $pattainfo->dag_area_lc;
        $total_lessa_basic = $this->utilityclass->Total_Lessa($basic_details_bigha, $basic_details_katha, $basic_details_lessa);
        $total_lessa = array('totlessa' => $total_lessa_basic);
        $this->session->set_userdata($total_lessa);
        // $tot_lessa=  $this->session->userdata('totlessa');
        $this->session->userdata('totlessa');
        //var_dump($this->session->all_userdata());
        $patta_type_info = $this->db->query("select patta_type,type_code FROM  patta_code WHERE type_code='$pattainfo->patta_type_code'")->row();
        $patta_type_info_dd = $this->db->query("select patta_type,type_code FROM  patta_code")->result();
        $landclass = $this->db->query("select land_type FROM  landclass_code WHERE class_code='$pattainfo->land_class_code'")->row();
        //var_dump($landclass);
        $land_class_dd = $this->db->query("select class_code,land_type FROM landclass_code")->result();
        $pattainfo123['pattatyps'] = array(
            'patta_no' => trim($pattainfo->patta_no),
            'land_class_code' => $pattainfo->land_class_code,
            'dag_area_b' => $pattainfo->dag_area_b,
            'dag_area_k' => $pattainfo->dag_area_k,
            'dag_area_lc' => $pattainfo->dag_area_lc,
            'dag_revenue' => $pattainfo->dag_revenue,
            'dag_local_tax' => $pattainfo->dag_local_tax,
            'pattatype' => $patta_type_info->patta_type,
            'pattatype_code' => $patta_type_info->type_code,
            'land_type' => $landclass->land_type,
            'vill_code' => $vill_code
        );

        $this->session->set_userdata($pattainfo123['pattatyps']);
        //nov4
        //  $Dag_no = trim();
        //var_dump($this->session->all_userdata());
        // $this->load->view('LmEntryChithaView/menu_for_lm', $data);
        // $this->load->view('footer');

        $data['_view'] = 'LmEntryChithaView/menu_for_lm';
        $this->load->view('layouts/main',$data);
    }

    public function getPattano() {
		//$db=  $this->session->userdata('db');
        // var_dump($this->session->all_userdata());
        // $this->load->helper('html');
        // $this->load->view('header');
        // $Dag_no = $this->input->post('Dag_no');
        //  echo $Dag_no;
        //   $dagno = array(
        //  'dagnum' => $Dag_no
        // );
        //  $this->session->set_userdata($dagno);

        $dist_code = $this->session->userdata('dist');
        //echo $dist_code;
        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');

        $Dag_no = $this->session->userdata('dagnum');

        $pattainfo = $this->db->query("select patta_no,patta_type_code,land_class_code,dag_area_b,dag_area_k,dag_area_lc,dag_revenue,dag_local_tax FROM  chitha_basic WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'")->row();
        //echo "select patta_no,patta_type_code FROM chitha_basic WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' ";
        $pattatype_code = $pattainfo->patta_type_code;
       // echo $pattatype_code;
        $this->session->set_userdata($pattatype_code);
        $basic_details_bigha = $pattainfo->dag_area_b;
        $basic_details_katha = $pattainfo->dag_area_k;
        $basic_details_lessa = $pattainfo->dag_area_lc;
        $total_lessa_basic = $this->utilityclass->Total_Lessa($basic_details_bigha, $basic_details_katha, $basic_details_lessa);
        $total_lessa = array('totlessa' => $total_lessa_basic);
        $this->session->set_userdata($total_lessa);
        // $tot_lessa=  $this->session->userdata('totlessa');
        $this->session->userdata('totlessa');
        //var_dump($this->session->all_userdata());
        $patta_type_info = $this->db->query("select patta_type,type_code FROM  patta_code WHERE type_code='$pattainfo->patta_type_code'")->row();
        $patta_type_info_dd = $this->db->query("select patta_type,type_code FROM  patta_code")->result();
        $landclass = $this->db->query("select land_type FROM  landclass_code WHERE class_code='$pattainfo->land_class_code'")->row();
        //var_dump($landclass);
        $land_class_dd = $this->db->query("select class_code,land_type FROM  landclass_code")->result();
        $pattainfo123['pattatyps'] = array(
            'patta_no' => trim($pattainfo->patta_no),
            'land_class_code' => $pattainfo->land_class_code,
            'dag_area_b' => $pattainfo->dag_area_b,
            'dag_area_k' => $pattainfo->dag_area_k,
            'dag_area_lc' => $pattainfo->dag_area_lc,
            'dag_revenue' => $pattainfo->dag_revenue,
            'dag_local_tax' => $pattainfo->dag_local_tax,
            'pattatype' => $patta_type_info->patta_type,
            'pattatype_code' => $patta_type_info->type_code,
            'land_type' => $landclass->land_type,
            'vill_code' => $vill_code
        );

        $this->session->set_userdata($pattainfo123['pattatyps']);
        //$pno = $this->session->userdata('patta_no');
        //$bno = $this->session->userdata('dag_area_b');
        //$pattainfo['patta_info']=$pattainfo;
        $pattainfo123['pattatyp_info'] = $patta_type_info_dd;
        $pattainfo123['landclass_info'] = $land_class_dd;
        //$pattainfo123['landclass']= $landclass;
        //newly modified
        //  $cron_num_query = $this->db->query("select max(cron_no) AS cron from    change_chitha_basic where dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'")->row();
        //  $cron_num = $cron_num_query->cron;
//        if (isset($_POST['submit_crop'])) {
//            $olddagno = $this->input->post('olddagno');
//            $direct_paying = $this->input->post('s');
//            $dagno = $this->input->post('dagno');
//            $dagrev = $this->input->post('dagrev');
//            $pattatype = $this->input->post('pattatype');
//            $daglocal = $this->input->post('daglocal');
//            $pattano = $this->input->post('pattano');
//            $northdesc = $this->input->post('northdesc');
//            $grantno = $this->input->post('grantno');
//            $southdesc = $this->input->post('southdesc');
//            $land_code = $this->input->post('land_code');
//            $eastdesc = $this->input->post('eastdesc');
//            $dag_area_are = $this->input->post('dag_area_are');
//            $westdesc = $this->input->post('westdesc');
//            $bigha = $this->input->post('bigha');
//            $northdesc_dag = $this->input->post('northdesc_dag');
//            $katha = $this->input->post('katha');
//            $southdesc_dag = $this->input->post('southdesc_dag');
//            $chatak = $this->input->post('chatak');
//            $eastdesc_dag = $this->input->post('eastdesc_dag');
//            $ganda = $this->input->post('ganda');
//            $westdesc_dag = $this->input->post('westdesc_dag');
//            $krantik = $this->input->post('krantik');
//            $dag_no_map = "";
//            $dag_nlrg_no="";
//            $dp_flag_yn="";
//            $date = date('Y-m-d');
//            $operation = 'M';
//            $status="";
//            $old_patta_no='';
//            $dag_name="";
//            $dag_dept_name="";
//            
//            
//              $lm_code = $this->session->userdata('user_code');
//            $cron_no = $cron_num + 1;
//            $this->db->query("INSERT INTO change_chitha_basic(
//            dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, 
//            vill_townprt_code, old_dag_no, dag_no, cron_no, patta_type_code, 
//            patta_no, land_class_code, dag_area_b, dag_area_k, dag_area_lc, 
//            dag_area_g, dag_area_kr, dag_revenue, dag_local_tax, 
//            dag_n_desc, dag_s_desc, dag_e_desc, dag_w_desc, dag_n_dag_no, 
//            dag_s_dag_no, dag_e_dag_no, dag_w_dag_no, dag_nlrg_no, dp_flag_yn, 
//            user_code, date_entry, operation, status, old_patta_no, dag_name, 
//            dag_dept_name)
//    VALUES ('$dist_code', '$subdiv_code', '$cir_code', '$mouza_code', '$lot_no', 
//           '$vill_code', '$olddagno', '$Dag_no', '$cron_no', '$pattatype_code', 
//            '$pattano', '$land_code', '$bigha', '$katha', '$chatak', 
//            '$ganda', '$krantik', '$dagrev', '$daglocal','$northdesc','$southdesc','$eastdesc','$westdesc', 
//            '$northdesc_dag', '$southdesc_dag', '$eastdesc_dag', '$westdesc_dag', '$dag_nlrg_no','$dp_flag_yn','$lm_code','$date','$operation','$status','$old_patta_no','$dag_name','$dag_dept_name''')");
//        
//
//  $sql = "select * from    change_chitha_basic where  dist_code='$dist_code' "
//                    . "and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code'"
//                    . " and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' "
//                    . " ORDER BY cron_no DESC LIMIT 1";
//
//            $Changebasic = $this->db->query($sql)->row();
//            $this->db->query("update chitha_basic set land_class_code ='$Changebasic->land_class_code',dag_area_b='$Changebasic->dag_area_b',dag_area_k='$Changebasic->dag_area_k',dag_area_lc='$Changebasic->dag_area_lc',dag_area_g='$Changebasic->dag_area_g',dag_area_kr='$Changebasic->dag_area_kr',dag_area_are='$dag_area_are',dag_revenue='$Changebasic->dag_revenue',dag_local_tax='$Changebasic->dag_local_tax',dag_no_map='$Changebasic->dag_no_map',dag_n_desc='$Changebasic->dag_n_desc',dag_s_desc='$Changebasic->dag_s_desc',dag_e_desc='$Changebasic->dag_e_desc',dag_w_desc='$Changebasic->dag_w_desc',dag_n_dag_no='$Changebasic->dag_n_dag_no' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no");
//            echo 'inserted in chitha basic';
//             redirect(base_url() . 'index.php/LmEntryChitha/cropname');
//        }
//newly modified ends
        // $this->load->view('LmEntryChithaView/basic_details', $pattainfo123);
        // $this->load->view('footer');

        $pattainfo123['_view'] = 'LmEntryChithaView/basic_details';
        $this->load->view('layouts/main',$pattainfo123);
    }

    //newly added function

    // public function add_basic_info() {

    //     echo "<script>";
    //     echo "  alert('Data Modified Successfully ')";
    //     echo"</script>";
    //     echo json_encode("Error:MAINTENANCE#2500001-Plz Contact System Admin");
    //     die;
	// 	$db=  $this->session->userdata('db');
    //     $dist_code = $this->session->userdata('dist');
    //     //echo $dist_code;
    //     $subdiv_code = $this->session->userdata('sub_div');
    //     $cir_code = $this->session->userdata('cir_code');
    //     $mouza_code = $this->session->userdata('mouza_code');
    //     $lot_no = $this->session->userdata('lot_no');
    //     $vill_code = $this->session->userdata('vill_code');
    //     // $Dag_no = trim($this->input->post('dagno'));
    //     $pattatype_code = $this->session->userdata('pattatype_code');

    //     $Dag_no = ($this->session->userdata('dagnum'));
    //   //  echo $Dag_no;
    //     if (isset($_POST['submit_crop'])) {
    //         $cron_num_query = $this->db->query("select max(cron_no) AS cron from    change_chitha_basic where dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'")->row();
    //         $cron_num = $cron_num_query->cron;
    //         $cron_no = $cron_num + 1;
    //         $olddagno = $this->input->post('olddagno');
    //         $direct_paying = $this->input->post('s');
    //         $dagno = trim($this->input->post('dagno'));
    //         $dagrev = $this->input->post('dagrev');
    //         $pattatype = $this->input->post('pattatype');
    //         $daglocal = $this->input->post('daglocal');
    //         $pattano = trim($this->input->post('pattano'));
    //         $northdesc = $this->input->post('northdesc');
    //         $grantno = $this->input->post('grantno');
    //         $southdesc = $this->input->post('southdesc');
    //         $land_code = $this->input->post('land_code');
    //         $eastdesc = $this->input->post('eastdesc');
    //         $dag_area_are = $this->input->post('dag_area_are');
    //         $westdesc = $this->input->post('westdesc');
    //         $bigha = $this->input->post('bigha');
    //         $northdesc_dag = $this->input->post('northdesc_dag');
    //         $katha = $this->input->post('katha');
    //         $southdesc_dag = $this->input->post('southdesc_dag');
    //         $chatak = $this->input->post('chatak');
    //         $eastdesc_dag = $this->input->post('eastdesc_dag');
    //         $ganda = $this->input->post('ganda');
    //         $westdesc_dag = $this->input->post('westdesc_dag');
    //         $krantik = $this->input->post('krantik');
    //         $dag_no_map = "";
    //         $dag_nlrg_no = "";
    //        // $dp_flag_yn = "";
    //         $date = date('Y-m-d');
    //         $operation = 'M';
    //         $status = "";
    //         $old_patta_no = '';
    //         $dag_name = "";
    //         $dag_dept_name = "";


    //         $lm_code = $this->session->userdata('user_code');

    //         $this->db->query("INSERT INTO change_chitha_basic(
    //         dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, 
    //         vill_townprt_code, old_dag_no, dag_no, cron_no, patta_type_code, 
    //         patta_no, land_class_code, dag_area_b, dag_area_k, dag_area_lc, 
    //         dag_area_g, dag_area_kr, dag_revenue, dag_local_tax, 
    //         dag_n_desc, dag_s_desc, dag_e_desc, dag_w_desc, dag_n_dag_no, 
    //         dag_s_dag_no, dag_e_dag_no, dag_w_dag_no, dag_nlrg_no, dp_flag_yn, 
    //         user_code, date_entry, operation, status, old_patta_no, dag_name, 
    //         dag_dept_name)
    // VALUES ('$dist_code', '$subdiv_code', '$cir_code', '$mouza_code', '$lot_no', 
    //        '$vill_code', '$olddagno', '$dagno', '$cron_no', '$pattatype_code', 
    //         '$pattano', '$land_code', '$bigha', '$katha', '$chatak', 
    //         '$ganda', '$krantik', '$dagrev', '$daglocal','$northdesc','$southdesc','$eastdesc','$westdesc', 
    //         '$northdesc_dag', '$southdesc_dag', '$eastdesc_dag', '$westdesc_dag', '$dag_nlrg_no','$direct_paying','$lm_code','$date','$operation','$status','$old_patta_no','$dag_name','$dag_dept_name')");


    //         $sql = "select * from    change_chitha_basic where  dist_code='$dist_code' "
    //                 . "and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code'"
    //                 . " and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$dagno' "
    //                 . " ORDER BY cron_no DESC LIMIT 1";

    //         $Changebasic = $this->db->query($sql)->row();
    //         $this->db->query("update chitha_basic set land_class_code ='$Changebasic->land_class_code',dp_flag_yn='$Changebasic->dp_flag_yn'  where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$dagno' and patta_type_code='$pattatype_code' and TRIM(patta_no)='$pattano'");
    //         //  echo   " update chitha_basic set land_class_code ='$Changebasic->land_class_code' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$dagno' and patta_type_code='$pattatype_code' and patta_no='$pattano'";
    //         // . "dag_area_b='$Changebasic->dag_area_b',dag_area_k='$Changebasic->dag_area_k',dag_area_lc='$Changebasic->dag_area_lc',dag_area_g='$Changebasic->dag_area_g',dag_area_kr='$Changebasic->dag_area_kr',dag_area_are='$dag_area_are',dag_revenue='$Changebasic->dag_revenue',dag_local_tax='$Changebasic->dag_local_tax',dag_no_map='$Changebasic->dag_no_map',dag_n_desc='$Changebasic->dag_n_desc',dag_s_desc='$Changebasic->dag_s_desc',dag_e_desc='$Changebasic->dag_e_desc',dag_w_desc='$Changebasic->dag_w_desc',dag_n_dag_no='$Changebasic->dag_n_dag_no',dag_s_dag_no='$Changebasic->dag_s_dag_no',dag_e_dag_no='$Changebasic->dag_e_dag_no',dag_w_dag_no='$Changebasic->dag_w_dag_no' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' patta_type_code='$pattatype_code' and patta_no='$pattano'");
    //         //echo 'inserted in chitha basic';
    //         echo "<script>";
    //         echo "  alert('Data Modified Successfully ')";
    //         echo"</script>";
    //         //   redirect(base_url() . 'index.php/LmEntryChitha/getPattano');

    //         $this->getPattano();
    //     }
    // }

    //newly added function


    public function cropname() {
		$db=  $this->session->userdata('db');
        // print_r($this->session->all_userdata());
        // $this->load->helper('html');
        // $this->load->view('header');

        $dist_code = $this->session->userdata('dist');
        //echo $dist_code;
        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $Dag_no = $this->session->userdata('dagnum');
        $cropinfo_dd = $this->db->query("select * FROM  chitha_mcrop AS mcp INNER Join crop_code AS cc ON mcp.crop_code = cc.crop_code WHERE mcp.dist_code='$dist_code' and mcp.subdiv_code = '$subdiv_code' and mcp.cir_code='$cir_code' and mcp.mouza_pargona_code = '$mouza_code' and mcp.lot_no = '$lot_no' and mcp.vill_townprt_code='$vill_code' and mcp.dag_no='$Dag_no'")->result();
       // echo "select * FROM chitha_mcrop AS mcp INNER Join crop_code AS cc ON mcp.crop_code = cc.crop_code WHERE mcp.dist_code='$dist_code' and mcp.subdiv_code = '$subdiv_code' and mcp.cir_code='$cir_code' and mcp.mouza_pargona_code = '$mouza_code' and mcp.lot_no = '$lot_no' and mcp.vill_townprt_code='$vill_code' and mcp.dag_no='$Dag_no'";
        // echo "select * FROM chitha_mcrop AS mcp INNER Join crop_code AS cc ON mcp.crop_code = cc.crop_code WHERE mcp.dist_code='$dist_code' and mcp.subdiv_code = '$subdiv_code' and mcp.cir_code='$cir_code' and mcp.mouza_pargona_code = '$mouza_code' and mcp.lot_no = '$lot_no' and mcp.vill_townprt_code='$vill_code' and mcp.dag_no='$Dag_no'";
        //$counted_crpinf = count($cropinfo_dd);


        $croptyp['cropinfo'] = $cropinfo_dd;
       // $this->load->view('LmEntryChithaView/selectCropName', $croptyp);

        //$this->load->view('footer');
		$croptyp['_view'] = 'LmEntryChithaView/selectCropName';
        $this->load->view('layouts/main',$croptyp);
    }

    public function showAndAddcrp() {
		$db=  $this->session->userdata('db');
        //  print_r($this->session->all_userdata());
        // $this->load->helper('html');
        // $this->load->view('header');

        $dist_code = $this->session->userdata('dist');
        //echo $dist_code;
        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $Dag_no = trim($this->session->userdata('dagnum'));
        $crop_sl_no = $this->input->post('crop_name');
       // $crop_sl_no = $this->input->post('crop_sl_no');
        //echo $crop_name;

        if (isset($_POST['show'])) {
            //$sl_no = $this->input->post('crop_name'); 
            $cropinfo = $this->db->query("select * FROM  chitha_mcrop AS mcp INNER Join crop_code AS cc ON mcp.crop_code = cc.crop_code  WHERE mcp.dist_code='$dist_code' and mcp.subdiv_code = '$subdiv_code' and mcp.cir_code='$cir_code' and mcp.mouza_pargona_code = '$mouza_code' and mcp.lot_no = '$lot_no' and mcp.vill_townprt_code='$vill_code' and mcp.dag_no='$Dag_no' and mcp.crop_sl_no='$crop_sl_no'")->row();
            // var_dump($cropinfo);
            // echo $cropinfo->crop_name; 
            $showCropdetails['cropinfo123'] = array(
                'crop_sl_no' => $cropinfo->crop_sl_no,
                'yearno' => $cropinfo->yearno,
                'crop_name' => $cropinfo->crop_name,
                'crop_code' => $cropinfo->crop_code,
                'crop_categ_code' => $cropinfo->crop_categ_code,
                'crop_season' => $cropinfo->crop_season,
                'crop_land_area_b' => $cropinfo->crop_land_area_b,
                'crop_land_area_k' => $cropinfo->crop_land_area_k,
                'crop_land_area_lc' => $cropinfo->crop_land_area_lc,
            );
            //from    here
            $showCropdetails['cropname'] = $cropinfo->crop_name;
            $showCropdetails['cropcode'] = $cropinfo->crop_code;
            $crop_name = $this->db->query("select * from    crop_code")->result();
            $showCropdetails['crpnme'] = $crop_name;
            //$cropinfo_dd11 = $this->db->query("select * FROM chitha_mcrop AS mcp INNER Join crop_code AS cc ON mcp.crop_code = cc.crop_code WHERE mcp.dist_code='$dist_code' and mcp.subdiv_code = '$subdiv_code' and mcp.cir_code='$cir_code' and mcp.mouza_pargona_code = '$mouza_code' and mcp.lot_no = '$lot_no' and mcp.vill_townprt_code='$vill_code' and mcp.dag_no='$Dag_no'")->result();
            //echo "select * FROM chitha_mcrop AS mcp INNER Join crop_code AS cc ON mcp.crop_code = cc.crop_code WHERE mcp.dist_code='$dist_code' and mcp.subdiv_code = '$subdiv_code' and mcp.cir_code='$cir_code' and mcp.mouza_pargona_code = '$mouza_code' and mcp.lot_no = '$lot_no' and mcp.vill_townprt_code='$vill_code' and mcp.dag_no='$Dag_no'";
            //$showCropdetails['cropinfo_dd']=$cropinfo_dd11;
// var_dump($crop_category_dd);
            // $showCropdetails['crop_category_info']=$crop_category_dd;
            $crop_season_dd = $this->db->query("select * from    crop_season where season_code='$cropinfo->crop_season'")->row();
            $showCropdetails['season'] = $crop_season_dd->crop_season;
            $showCropdetails['season_code'] = $crop_season_dd->season_code;
            $watersrc_dd = $this->db->query("select * from    source_water")->result();
            $showCropdetails['watersource'] = $watersrc_dd;

            $water_source = $this->db->query("select * from    source_water where water_source_code='$cropinfo->source_of_water'")->row();
            $showCropdetails['watersrc'] = $water_source->source;
            $showCropdetails['watersrc_code'] = $water_source->water_source_code;
            $crop = $this->db->query("select * from    crop_season")->result();
            $showCropdetails['ss'] = $crop;

            $crop_category_dd = $this->db->query("select * from    crop_category_code where crop_categ_code='$cropinfo->crop_categ_code'")->row();
            $showCropdetails['crpcateg'] = $crop_category_dd->crop_categ_desc;
            $showCropdetails['crpcateg_code'] = $crop_category_dd->crop_categ_code;
            $crp_categ_dd = $this->db->query("select * from    crop_category_code")->result();
            $showCropdetails['crop_category_info'] = $crp_categ_dd;

            //$this->load->view('LmEntryChithaView/showCropDetails', $showCropdetails);
			//$this->load->view('footer');
			$showCropdetails['_view'] = 'LmEntryChithaView/showCropDetails';
			$this->load->view('layouts/main',$showCropdetails);
			
        }
//         else {
//            echo'hi';
//        }


       // $this->load->view('footer');
    }

//     public function modify() {
// 		$db=  $this->session->userdata('db');
//         // $this->load->helper('html');
//         // $this->load->view('header');

//         $dist_code = $this->session->userdata('dist');
//         //echo $dist_code;
//         $subdiv_code = $this->session->userdata('sub_div');
//         $cir_code = $this->session->userdata('cir_code');
//         $mouza_code = $this->session->userdata('mouza_code');
//         $lot_no = $this->session->userdata('lot_no');
//         $vill_code = $this->session->userdata('vill_code');
//         $Dag_no = trim($this->session->userdata('dagnum'));
//         $sl_no = $this->input->post('crop_slno');
//         $yearno = $this->input->post('yearno');
//         $cropcode = $this->input->post('cropname');

//         $crop_code = array(
//             'crop_code' => $cropcode
//         );
//         //var_dump($crop_code);
//         $this->session->set_userdata($crop_code);

//         $cropCategoryCd = $this->input->post('crop_category');
//         $cropSeasonCd = $this->input->post('crp_season');
//         $watersrc_cd = $this->input->post('watersrc');
//         $bigha = $this->input->post('bigha');
//         $katha = $this->input->post('katha');
//         $lesa = $this->input->post('lesa');
//        //... $cron_num_query = $this->db->query("select max(cron_no) AS cron from    change_chitha_mcrop where dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and crop_code='$cropcode'")->row();
//         //  var_dump($cron_num_query);
//        //... $cron_num = $cron_num_query->cron;
//         if (isset($_POST['modify'])) {
//             $operation = 'M';
//             $userCd = $this->session->userdata('user_code');
//             //$userCd = 'M117';
//          //...   $cron_no = $cron_num + 1;
//             //         $cron_no_initial['cron'] =  $cron_no ;
//             //               $this->session->set_userdata($cron_no);
//             //     $this->session->userdata('cron');
//             $date_of_entry = date("Y-m-d");
//             $ganda = '0';
//             $kara = '0';
//             // $userCd =  $this->session->userdata('$lm_code');
//             //echo $bigha.'<br>'.$watersrc_cd;


//            //... $cronno = array(
//                 //...'crn' => $cron_no
//            //... );

//           //...  $this->session->set_userdata($cronno);
//            //... $cron_num = $this->session->userdata('crn');

//           //...  $this->db->query("insert into change_chitha_mcrop (dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,dag_no,cron_no,crop_sl_no,yearno,crop_code,crop_season,source_of_water,crop_land_area_b,crop_land_area_k,crop_land_area_lc,crop_land_area_g,crop_land_area_kr,user_code,date_entry,operation,crop_categ_code)values('$dist_code','$subdiv_code','$cir_code','$mouza_code','$lot_no','$vill_code','$Dag_no','$cron_num','$sl_no','$yearno','$cropcode','$cropSeasonCd','$watersrc_cd','$bigha','$katha','$lesa','$ganda','$kara','$userCd','$date_of_entry','$operation','$cropCategoryCd')");
//             //$maxcron_no =  $this->db->query("select max(cron_no) AS cron_no from    change_chitha_mcrop where  dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and crop_code='$cropcode'")->row;
//             //var_dump($maxcron_no);
// //echo "select max(cron_no) from    change_chitha_mcrop where  dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and crop_code='$cropcode'";   
// //          $cronnumMax['maxcron'] = $maxcron_no->cron_no;
// //         echo $cronnumMax;
//             //... $sql=$this->db->query("select * FROM chitha_mcrop AS mcp INNER Join crop_code AS cc ON mcp.crop_code = cc.crop_code WHERE mcp.dist_code='$dist_code' and mcp.subdiv_code = '$subdiv_code' and mcp.cir_code='$cir_code' and mcp.mouza_pargona_code = '$mouza_code' and mcp.lot_no = '$lot_no' and mcp.vill_townprt_code='$vill_code' and mcp.dag_no='$Dag_no'")->row();
//             //..... var_dump($sql);
//             //$Changemcrp = $this->db->query($sql)->row();
//             //...  $this->db->query("update chitha_mcrop set yearno='$sql->yearno',crop_code='$cropcode',crop_season='$sql->crop_season',source_of_water='$sql->source_of_water',crop_land_area_b='$sql->crop_land_area_b',crop_land_area_k='$sql->crop_land_area_k',crop_land_area_lc='$sql->crop_land_area_lc',user_code='$sql->user_code',date_entry='$sql->date_entry',operation='$sql->operation',crop_categ_code='$sql->crop_categ_code' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and crop_sl_no='$sl_no'");       
//             //... $this->db->query("update chitha_basic set jama_yn='n' WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'");


//             //...$sql = "select * from    change_chitha_mcrop where  dist_code='$dist_code' "
//                   //...  . "and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code'"
//                   //...  . " and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and crop_code='$cropcode'"
//                 //...    . " ORDER BY cron_no DESC LIMIT 1";

//            //... $Changemcrp = $this->db->query($sql)->row();
//             //  var_dump($Changemcrp);
//             $this->db->query("update chitha_mcrop set yearno='$yearno',crop_code='$cropcode',crop_season='$cropSeasonCd',source_of_water='$watersrc_cd',crop_land_area_b='$bigha',crop_land_area_k='$katha',crop_land_area_lc='$lesa',crop_categ_code='$cropCategoryCd' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and crop_sl_no='$sl_no'");
//             $this->db->query("update chitha_basic set jama_yn='n' WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'");


//             $Cropname = $this->db->query("select * from    crop_code where crop_code='$cropcode'")->row();
//             $showCropdetails['cropname'] = $Cropname->crop_name;
//             $showCropdetails['cropcode'] = $Cropname->crop_code;
//             $crop_name = $this->db->query("select * from    crop_code")->result();
//             $showCropdetails['crpnme'] = $crop_name;
//             $crop_category_dd = $this->db->query("select * from    crop_category_code where crop_categ_code='$cropCategoryCd'")->row();
//             $showCropdetails['crpcateg'] = $crop_category_dd->crop_categ_desc;
//             $showCropdetails['crpcateg_code'] = $crop_category_dd->crop_categ_code;
//             $crp_categ_dd = $this->db->query("select * from    crop_category_code")->result();
//             $showCropdetails['crop_category_info'] = $crp_categ_dd;
//             $crop_season_dd = $this->db->query("select * from    crop_season where season_code='$cropSeasonCd'")->row();
//             $showCropdetails['season'] = $crop_season_dd->crop_season;
//             $showCropdetails['season_code'] = $crop_season_dd->season_code;
//             $crop = $this->db->query("select * from    crop_season")->result();
//             $showCropdetails['ss'] = $crop;
//             $water_source = $this->db->query("select * from    source_water where water_source_code='$watersrc_cd'")->row();
//             $showCropdetails['watersrc'] = $water_source->source;
//             $showCropdetails['watersrc_code'] = $water_source->water_source_code;
//             $watersrc_dd = $this->db->query("select * from    source_water")->result();
//             $showCropdetails['watersource'] = $watersrc_dd;

//             $showCropdetails['cropinfo123'] = array(
//                 'crop_sl_no' => $sl_no,
//                 'yearno' => $yearno,
//                 'crop_land_area_b' => $bigha,
//                 'crop_land_area_k' => $katha,
//                 'crop_land_area_lc' => $lesa,
//             );
//             //  $CronMax = $this->db->query("select max(cron_no) AS cron_no from    change_chitha_mcrop where  dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and crop_code='$cropcode'")->row();
//             //$Changemcrp = $this->db->query("select * from    change_chitha_mcrop where  dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and crop_code='$cropcode' and cron_no='$CronMax->cron_no'")->row();
// //             if($CronMax->cron_no == '1'){
// //               $this->db->query("insert into chitha_mcrop(dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,dag_no,crop_sl_no,yearno,crop_code,crop_season,source_of_water,crop_land_area_b,crop_land_area_k,crop_land_area_lc,crop_land_area_g,crop_land_area_kr,user_code,date_entry,operation,crop_categ_code)values('$dist_code','$subdiv_code','$cir_code','$mouza_code','$lot_no','$vill_code','$Dag_no','$Changemcrp->crop_sl_no','$Changemcrp->yearno','$cropcode','$Changemcrp->crop_season','$Changemcrp->source_of_water','$Changemcrp->crop_land_area_b','$Changemcrp->crop_land_area_k','$Changemcrp->crop_land_area_lc','$Changemcrp->crop_land_area_g','$Changemcrp->crop_land_area_kr','$Changemcrp->user_code','$Changemcrp->date_entry','$Changemcrp->operation','$Changemcrp->crop_categ_code')");      
// //             }
// //             else{
// //             $this->db->query("update chitha_mcrop set crop_sl_no='$Changemcrp->crop_sl_no' and yearno='$Changemcrp->yearno' and crop_season='$Changemcrp->crop_season' and source_of_water = '$Changemcrp->source_of_water' and  crop_land_area_b='$Changemcrp->crop_land_area_b' and crop_land_area_k='$Changemcrp->crop_land_area_k' and crop_land_area_lc='$Changemcrp->crop_land_area_lc' and crop_land_area_g='$Changemcrp->crop_land_area_g' and crop_land_area_kr='$Changemcrp->crop_land_area_kr' and user_code='$Changemcrp->user_code' and date_entry='$Changemcrp->date_entry' and operation='$Changemcrp->operation' and crop_categ_code='$Changemcrp->crop_categ_code' where dist_code ='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'");           
// //             }


//             $this->session->set_userdata($showCropdetails['cropinfo123']);
// //$sl_num = $this->session->userdata('crop_sl_no');
//             // $this->cropname();
//             // $this->cropname();
//             //  $this->cropname();
//             //  $this->load->view('LmEntryChithaView/showCropDetails', $showCropdetails);
//             $this->session->set_flashdata('message', 'Data Successfully Modified ');
//             redirect(base_url() . 'index.php/LmEntryChitha/cropname');
//         }
// //        } else {
// //
// //            $this->session->unset_userdata('crn');
// //        }

//         $this->load->view('footer');
//     }

//    public function SaveCropDetail(){
//        $dist_code = $this->session->userdata('dist');
//        //echo $dist_code;
//        $subdiv_code = $this->session->userdata('sub_div');
//        $cir_code = $this->session->userdata('cir_code');
//        $mouza_code = $this->session->userdata('mouza_code');
//        $lot_no = $this->session->userdata('lot_no');
//        $vill_code = $this->session->userdata('vill_code');
//        $Dag_no = $this->session->userdata('dagnum');
//        $cropcode = $this->session->userdata('crop_code');
//        
//        $sql="select * from    change_chitha_mcrop where  dist_code='$dist_code' "
//                 . "and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code'"
//                 . " and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and crop_code='$cropcode'"
//                . " ORDER BY cron_no DESC LIMIT 1";
//        
//         $Changemcrp = $this->db->query($sql)->row();
//       //  var_dump($Changemcrp);
//            $this->db->query("update chitha_mcrop set crop_sl_no='$Changemcrp->crop_sl_no',yearno='$Changemcrp->yearno',crop_code='$cropcode',crop_season='$Changemcrp->crop_season',source_of_water='$Changemcrp->source_of_water',crop_land_area_b='$Changemcrp->crop_land_area_b',crop_land_area_k='$Changemcrp->crop_land_area_k',crop_land_area_lc='$Changemcrp->crop_land_area_lc',user_code='$Changemcrp->user_code',date_entry='$Changemcrp->date_entry',operation='$Changemcrp->operation',crop_categ_code='$Changemcrp->crop_categ_code' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'");       
//            $this->db->query("update chitha_basic set jama_yn='n' WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'");
//         
//    }

    public function addcrop() {
		//$db=  $this->session->userdata('db');
        // // var_dump($this->session->all_userdata());
        // $this->load->helper('html');
        // $this->load->view('header');
        $dist_code = $this->session->userdata('dist');
        //echo $dist_code;
        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $Dag_no = $this->session->userdata('dagnum');

        $addcropinfo = $this->db->query("select max(crop_sl_no) As crop_sl_no FROM  chitha_mcrop WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'")->row();
        $slno = $addcropinfo->crop_sl_no;

        $slno_nxt = $slno + 1;
        $showCropdetails['cropslno'] = array(
            'crop_sl_no' => $slno_nxt
                //'bighano' => $this->session->userdata('dag_area_b')
        );

        $crop_name = $this->db->query("select * from    crop_code")->result();
        $showCropdetails['crpnme'] = $crop_name;
        $crp_categ_dd = $this->db->query("select * from    crop_category_code")->result();
        $showCropdetails['crop_category_info'] = $crp_categ_dd;
        $crop = $this->db->query("select * from    crop_season")->result();
        $showCropdetails['ss'] = $crop;
        $watersrc_dd = $this->db->query("select * from    source_water")->result();
        $showCropdetails['watersource'] = $watersrc_dd;
        // $this->load->view('LmEntryChithaView/addCropDetails', $showCropdetails);
        // $this->load->view('footer');

        $showCropdetails['_view'] = 'LmEntryChithaView/addCropDetails';
        $this->load->view('layouts/main',$showCropdetails);
    }

    public function addcropinfo() {
$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist');
        //echo $dist_code;
        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $Dag_no = $this->session->userdata('dagnum');
        $crop_slno = $this->input->post('crop_slno');
        $yearno = $this->input->post('yearno');
        $cropname = $this->input->post('cropname');
        $crop_category = $this->input->post('crop_category');
        $crp_season = $this->input->post('crp_season');
        $watersrc = $this->input->post('watersrc');
        $bigha = $this->input->post('bigha1');
        $katha = $this->input->post('katha');
        $lesa = $this->input->post('lesa');


        $operation = 'M';
        $userCd = $this->session->userdata('user_code');
        // $userCd = 'M117';
        $date_of_entry = date("Y-m-d");
        $ganda = '0.0000';
        $kara = '0';

        // $crop_codechk = $this->session->userdata('crop_code');

        $cropinfo_chk = $this->db->query("select * FROM  chitha_mcrop  WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and yearno='$yearno'")->row();
        $count_cropinfo = count($cropinfo_chk);
        if ($count_cropinfo != '0') {
            $crop_codechk = $cropinfo_chk->crop_code;

            if ($cropname == $crop_codechk) {
                echo 'plz insert a different crop in this year';
                redirect('LmEntryChitha/addcrop');

                exit;
            }
        }

        //copied from    above
        //$total_lessa=array('totlessa'=>$total_lessa_basic);
        // $this->session->set_userdata($total_lessa);
      $tot_lessa = $this->session->userdata('totlessa');
        //

        $total_lessa_basic_crop = $this->utilityclass->Total_Lessa($bigha, $katha, $lesa);


        if ($total_lessa_basic_crop <= $tot_lessa) {


           //.... $tot_lessa = $tot_lessa - $total_lessa_basic_crop;
           //.... $total_lessa_crop = array('totlessa' => $tot_lessa);
            //....$this->session->set_userdata($total_lessa_crop);

            //$subtracted_area = $this->session->userdata('remaing_area');
            $this->db->query("insert into chitha_mcrop(dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,dag_no,crop_sl_no,yearno,crop_code,crop_season,source_of_water,crop_land_area_b,crop_land_area_k,crop_land_area_lc,crop_land_area_g,crop_land_area_kr,user_code,date_entry,operation,crop_categ_code)values('$dist_code','$subdiv_code','$cir_code','$mouza_code','$lot_no','$vill_code','$Dag_no','$crop_slno','$yearno','$cropname','$crp_season','$watersrc','$bigha','$katha','$lesa','$ganda','$kara','$userCd','$date_of_entry','$operation','$crop_category')");
            $this->addcrop();

            //echo "insert into chitha_mcrop(dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,dag_no,crop_sl_no,yearno,crop_code,crop_season,source_of_water,crop_land_area_b,crop_land_area_k,crop_land_area_lc,crop_land_area_g,crop_land_area_kr,user_code,date_entry,operation,crop_categ_code)values('$dist_code','$subdiv_code','$cir_code','$mouza_code','$lot_no','$vill_code','$Dag_no','$crop_slno','$yearno','$cropname','$crp_season','$watersrc','$bigha','$katha','$lesa','4','6','$userCd','$date_of_entry','$operation','$crop_category'";
        } else {
            echo "<script>";
            echo "  alert('the inserted Land Area exceeds remaining area ')";
           echo"</script>";
            $this->addcrop();
       }
    }

    public function nextNonAgri() {
		$db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('header');
        $dist_code = $this->session->userdata('dist');
        //echo $dist_code;
        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $Dag_no = $this->session->userdata('dagnum');
        $noncrop_details = $this->db->query("select * FROM  chitha_noncrop AS ncp INNER Join used_noncrop_type AS ucp ON ncp.type_of_used_noncrop = ucp.used_noncrop_type_code  WHERE ncp.dist_code='$dist_code' and ncp.subdiv_code = '$subdiv_code' and ncp.cir_code='$cir_code' and ncp.mouza_pargona_code = '$mouza_code' and ncp.lot_no = '$lot_no' and ncp.vill_townprt_code='$vill_code' and ncp.dag_no='$Dag_no'")->result();




        $nonAgri['nonagridetails'] = $noncrop_details;

// echo "select * FROM chitha_noncrop AS ncp INNER Join used_noncrop_type AS ucp ON ncp.type_of_used_noncrop = ucp.used_noncrop_type_code  WHERE ncp.dist_code='$dist_code' and ncp.subdiv_code = '$subdiv_code' and ncp.cir_code='$cir_code' and ncp.mouza_pargona_code = '$mouza_code' and ncp.lot_no = '$lot_no' and ncp.vill_townprt_code='$vill_code' and ncp.dag_no='$Dag_no'";
        //$noncrop = $this->db->query("select * FROM chitha_noncrop AS ncp where ncp.dist_code='$dist_code' and ncp.subdiv_code = '$subdiv_code' and ncp.cir_code='$cir_code' and ncp.mouza_pargona_code = '$mouza_code' and ncp.lot_no = '$lot_no' and ncp.vill_townprt_code='$vill_code' and ncp.dag_no='$Dag_no'")->row();
        // $noncrop_dd = $this->db->query("select * FROM used_noncrop_type where used_noncrop_type_code ='$noncrop->type_of_used_noncrop'")->result();
        //$nonAgri['nonagriinfo'] = $noncrop_dd;

        //$this->load->view('LmEntryChithaView/selectNonAgriName', $nonAgri);
        //$this->load->view('footer');
		
		$nonAgri['_view'] = 'LmEntryChithaView/selectNonAgriName';
		$this->load->view('layouts/main',$nonAgri);
    }

    public function showAndmodifynonagri() {
		$db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('header');
        $dist_code = $this->session->userdata('dist');
        //echo $dist_code;
        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $Dag_no = $this->session->userdata('dagnum');
        $nonslno = $this->input->post('noncrop_name');
        //  echo   $noncropname;
        $noncrop_details = $this->db->query("select * FROM  chitha_noncrop AS ncp INNER Join used_noncrop_type AS ucp ON ncp.type_of_used_noncrop = ucp.used_noncrop_type_code  WHERE ncp.dist_code='$dist_code' and ncp.subdiv_code = '$subdiv_code' and ncp.cir_code='$cir_code' and ncp.mouza_pargona_code = '$mouza_code' and ncp.lot_no = '$lot_no' and ncp.vill_townprt_code='$vill_code' and ncp.dag_no='$Dag_no' and ncp.noncrop_use_id='$nonslno'")->row();
        $noncropname=$noncrop_details->type_of_used_noncrop;
//$nonAgri['nonagridetails'] = $noncrop_details;  
        $noncrop = $this->db->query("select * FROM  used_noncrop_type where used_noncrop_type_code = '$noncropname'")->row();
        $shownonagri['noncrpcode'] = $noncrop->used_noncrop_type_code;
        $shownonagri['noncrptyp'] = $noncrop->noncrop_type;

        $noncrop_dd = $this->db->query("select * FROM  used_noncrop_type")->result();
        $shownonagri['usednoncrp'] = $noncrop_dd;

        $shownonagri['nonAgri'] = array(
            'noncrop_id' => $noncrop_details->noncrop_use_id,
            'year' => $noncrop_details->yn,
            'bigha' => $noncrop_details->noncrop_land_area_b,
            'katha' => $noncrop_details->noncrop_land_area_k,
            'lesa' => $noncrop_details->noncrop_land_area_lc,
        );

        //$this->load->view('LmEntryChithaView/showmodifyNonagri', $shownonagri);

        //   redirect(base_url() . 'index.php/LmEntryChitha/cropname');
        //$this->load->view('footer');
		$shownonagri['_view'] = 'LmEntryChithaView/showmodifyNonagri';
		$this->load->view('layouts/main',$shownonagri);
		
    }

    public function modifynonAgr() {
		$db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('header');

        $dist_code = $this->session->userdata('dist');

        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $Dag_no = $this->session->userdata('dagnum');
        $noncropid = $this->input->post('noncrpid');
        $year = $this->input->post('year');
        $noncropname = $this->input->post('noncropname');
        $nonagricrop_code = array(
            'noncropname' => $noncropname
        );
        //var_dump($crop_code);
        $this->session->set_userdata($nonagricrop_code);
        $bigha = $this->input->post('bigha');
        $katha = $this->input->post('katha');
        $lesa = $this->input->post('lesa');

      //...  $cron_num_query = $this->db->query("select max(cron_no) AS cron from    change_chitha_noncrop ")->row();
        //  var_dump($cron_num_query);
     //...   $cron_num = $cron_num_query->cron;

        if (isset($_POST['modifynonAgri'])) {
            //$shownonagri['message']=array('message'=>"Data Successfully Modified ");
            $operation = 'M';
            $userCd = $this->session->userdata('user_code');
            //$userCd = 'M117';
//                           $cron_num_query = $this->db->query("select count(cron_no) AS cron from    change_chitha_noncrop where dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and type_of_used_noncrop='$noncropname' and yn='$year'")->row();
//        //  var_dump($cron_num_query);
//        $cron_num = $cron_num_query->cron;
          //...  $cron_no = $cron_num + 1;
            //         $cron_no_initial['cron'] =  $cron_no ;
            //               $this->session->set_userdata($cron_no);
            //     $this->session->userdata('cron');
            $date_of_entry = date("Y-m-d");
            // $userCd =  $this->session->userdata('$lm_code');
            //echo $bigha.'<br>'.$watersrc_cd;

            $ganda = '0';
            $kara = '0';
           //... $cronno = array(
               //... 'crn' => $cron_no
           //... );

          //...  $this->session->set_userdata($cronno);
          //...  $cron_num = $this->session->userdata('crn');

           //... $this->db->query("insert into change_chitha_noncrop (dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,dag_no,cron_no,noncrop_use_id,yn,type_of_used_noncrop,noncrop_land_area_b,noncrop_land_area_k,noncrop_land_area_lc,noncrop_land_area_g,noncrop_land_area_kr,user_code,date_entry,operation)values('$dist_code','$subdiv_code','$cir_code','$mouza_code','$lot_no','$vill_code','$Dag_no','$cron_no','$noncropid','$year','$noncropname','$bigha','$katha','$lesa','$ganda','$kara','$userCd','$date_of_entry','$operation')");


            $nonagricrop = $this->session->userdata('noncropname');
        //...    $sql = "select * from    change_chitha_noncrop where  dist_code='$dist_code' "
              //...      . "and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code'"
               //...     . " and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and type_of_used_noncrop='$nonagricrop'"
               //...     . " ORDER BY cron_no DESC LIMIT 1";

          //...  $Changenoncrp = $this->db->query($sql)->row();
            //  var_dump($Changemcrp);
            // $this->db->query("insert into chitha_noncrop(dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,dag_no,noncrop_use_id,yn,type_of_used_noncrop,noncrop_land_area_b,noncrop_land_area_k,noncrop_land_area_lc,noncrop_land_area_g,noncrop_land_area_kr,user_code,date_entry,operation)values('$dist_code','$subdiv_code','$cir_code','$mouza_code','$lot_no','$vill_code','$Dag_no','$Changenoncrp->noncrop_use_id','$Changenoncrp->yn','$Changenoncrp->type_of_used_noncrop','$Changenoncrp->noncrop_land_area_b','$Changenoncrp->noncrop_land_area_k','$Changenoncrp->noncrop_land_area_lc','$Changenoncrp->noncrop_land_area_g','$Changenoncrp->noncrop_land_area_kr','$Changenoncrp->user_code','$Changenoncrp->date_entry','$Changenoncrp->operation')");       


            $this->db->query("update chitha_noncrop set yn='$year',type_of_used_noncrop='$noncropname',noncrop_land_area_b='$bigha',noncrop_land_area_k='$katha',noncrop_land_area_lc='$lesa' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and noncrop_use_id='$noncropid'");



            $nonCropname = $this->db->query("select * from    used_noncrop_type where used_noncrop_type_code='$noncropname'")->row();
            $shownonagri['noncrpcode'] = $nonCropname->used_noncrop_type_code;
            $shownonagri['noncrptyp'] = $nonCropname->noncrop_type;
            $noncrop_name = $this->db->query("select * from    used_noncrop_type")->result();
            $shownonagri['usednoncrp'] = $noncrop_name;
            $shownonagri['nonAgri'] = array(
                'noncrop_id' => $noncropid,
                'year' => $year,
                'bigha' => $bigha,
                'katha' => $katha,
                'lesa' => $lesa,
            );
            $message = "Success";
            echo "<script type='text/javascript'>alert('$message');</script>";
            // $this->session->set->userdata($shownonagri['message']; 
            //$this->load->view('LmEntryChithaView/showmodifyNonagri', $shownonagri);
            //$this->load->view('footer');
			
			$shownonagri['_view'] = 'LmEntryChithaView/showmodifyNonagri';
			$this->load->view('layouts/main',$shownonagri);
        }
//        } else {
//
//            $this->session->unset_userdata('crn');
//            // $this->load->view('LmEntryChithaView/showmodifyNonagri');
//        }
    }

//       public function SavenonagriCropDetail(){
//          
//        
//        $dist_code = $this->session->userdata('dist');
//        //echo $dist_code;
//        $subdiv_code = $this->session->userdata('sub_div');
//        $cir_code = $this->session->userdata('cir_code');
//        $mouza_code = $this->session->userdata('mouza_code');
//        $lot_no = $this->session->userdata('lot_no');
//        $vill_code = $this->session->userdata('vill_code');
//        $Dag_no = $this->session->userdata('dagnum');
//     
//        
//      
//           $nonagricrop = $this->session->userdata('noncropname');
//        $sql="select * from    change_chitha_noncrop where  dist_code='$dist_code' "
//                 . "and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code'"
//                 . " and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and type_of_used_noncrop='$nonagricrop'"
//                . " ORDER BY cron_no DESC LIMIT 1";
//        
//         $Changenoncrp = $this->db->query($sql)->row();
//       //  var_dump($Changemcrp);
//           // $this->db->query("insert into chitha_noncrop(dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,dag_no,noncrop_use_id,yn,type_of_used_noncrop,noncrop_land_area_b,noncrop_land_area_k,noncrop_land_area_lc,noncrop_land_area_g,noncrop_land_area_kr,user_code,date_entry,operation)values('$dist_code','$subdiv_code','$cir_code','$mouza_code','$lot_no','$vill_code','$Dag_no','$Changenoncrp->noncrop_use_id','$Changenoncrp->yn','$Changenoncrp->type_of_used_noncrop','$Changenoncrp->noncrop_land_area_b','$Changenoncrp->noncrop_land_area_k','$Changenoncrp->noncrop_land_area_lc','$Changenoncrp->noncrop_land_area_g','$Changenoncrp->noncrop_land_area_kr','$Changenoncrp->user_code','$Changenoncrp->date_entry','$Changenoncrp->operation')");       
//          
//            
//            $this->db->query("update chitha_noncrop set noncrop_use_id='$Changenoncrp->noncrop_use_id',yn='$Changenoncrp->yn',type_of_used_noncrop='$Changenoncrp->type_of_used_noncrop',noncrop_land_area_b='$Changenoncrp->noncrop_land_area_b',noncrop_land_area_k='$Changenoncrp->noncrop_land_area_k',noncrop_land_area_lc='$Changenoncrp->noncrop_land_area_lc',noncrop_land_area_g='$Changenoncrp->noncrop_land_area_g',noncrop_land_area_kr='$Changenoncrp->noncrop_land_area_kr',user_code='$Changenoncrp->user_code',date_entry='$Changenoncrp->date_entry',operation='$Changenoncrp->operation' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'");   
//     echo 'record has been saved';
//    
//         }
//         
    public function addnonagri() {
$db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('header');
        $dist_code = $this->session->userdata('dist');
        //echo $dist_code;
        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $Dag_no = $this->session->userdata('dagnum');

        $addnoncropinfo = $this->db->query("select max(noncrop_use_id) AS noncrop_use_id FROM  chitha_noncrop WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'")->row();
        //  echo "select max(noncrop_use_id) FROM chitha_noncrop WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'";
//var_dump($addnoncropinfo);
        $noncrpid = $addnoncropinfo->noncrop_use_id;

        $slno_nxt = ($noncrpid + 1);
        $shownonCropdetails['noncropslno'] = array(
            'noncrop_id' => $slno_nxt
        );

        $typeofusages = $this->db->query("select * from    used_noncrop_type")->result();
        $shownonCropdetails['typofusages'] = $typeofusages;

        //$this->load->view('LmEntryChithaView/addnonAgri', $shownonCropdetails);
        //$this->load->view('footer');
		
		$shownonCropdetails['_view'] = 'LmEntryChithaView/addnonAgri';
		$this->load->view('layouts/main',$shownonCropdetails);
    }

    public function addnonAgriinfo() {
$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist');
        //echo $dist_code;
        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $Dag_no = $this->session->userdata('dagnum');
        $noncrop_slno = $this->input->post('noncrop_slno');
        $yearno = $this->input->post('yearno');
        $typofusagesname = $this->input->post('typofusagesname');

        $bigha = $this->input->post('bigha1');
        $katha = $this->input->post('katha');
        $lesa = $this->input->post('lesa');
        $operation = 'M';
        $userCd = $this->session->userdata('user_code');
        // $userCd = 'M117';
        $date_of_entry = date("Y-m-d");

        $ganda = '0';
        $kara = '0';

        // $nonagrinamename = $this->session->userdata('noncropname');  
        $noncrop_check = $this->db->query("select * FROM  chitha_noncrop where dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and yn='$yearno'")->row();
        $count_nonagriChk = count($noncrop_check);
        if ($count_nonagriChk != '0') {
            $nonagrinamename = $noncrop_check->type_of_used_noncrop;


            if ($typofusagesname == $nonagrinamename) {
                echo'cannot insert same nonagri detail in the same year';
                redirect('LmEntryChitha/addnonagri');

                exit;
            }
        }

        //newly modified
        $tot_lessa = $this->session->userdata('totlessa');
        $total_lessa_basic_noncrop = $this->utilityclass->Total_Lessa($bigha, $katha, $lesa);


        if ($total_lessa_basic_noncrop <= $tot_lessa) {


           //.... $tot_lessa = $tot_lessa - $total_lessa_basic_noncrop;
           //.... $total_lessa_noncrop = array('totlessa' => $tot_lessa);
          //....  $this->session->set_userdata($total_lessa_noncrop);



            //newly modified


            $this->db->query("INSERT INTO chitha_noncrop(
            dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, 
            vill_townprt_code, dag_no, noncrop_use_id, yn, type_of_used_noncrop, 
            noncrop_land_area_b, noncrop_land_area_k, noncrop_land_area_lc, 
            noncrop_land_area_g, noncrop_land_area_kr, user_code, date_entry, 
            operation)
    VALUES ('$dist_code','$subdiv_code','$cir_code','$mouza_code','$lot_no', 
            '$vill_code','$Dag_no','$noncrop_slno','$yearno','$typofusagesname', 
            '$bigha','$katha','$lesa','$ganda','$kara', 
            '$userCd','$date_of_entry','$operation')");


            $this->addnonagri();
       } else {
            echo "<script>";
           echo "  alert('the inserted Land Area exceeds remaining area ')";
            echo"</script>";
            $this->addnonagri();
        }
    }

    public function nextfruitplantselect() {
		$db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('header');
        $dist_code = $this->session->userdata('dist');
        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $Dag_no = $this->session->userdata('dagnum');
        // imp*** $fruitinfo_dd = $this->db->query("select * FROM chitha_fruit AS f INNER Join fruit_tree_code AS fc ON f.fruit_plants_name = fc.fruit_code WHERE f.dist_code='$dist_code' and f.subdiv_code = '$subdiv_code' and f.cir_code='$cir_code' and f.mouza_pargona_code = '$mouza_code' and f.lot_no = '$lot_no' and f.vill_townprt_code='$vill_code' and f.dag_no='$Dag_no'")->result();
        $fruitinfo_dd = $this->db->query("select * FROM  chitha_fruit AS f INNER Join fruit_tree_code AS fc ON f.fruit_plants_name = fc.fruit_code WHERE f.dist_code='$dist_code' and f.subdiv_code = '$subdiv_code' and f.cir_code='$cir_code' and f.mouza_pargona_code = '$mouza_code' and f.lot_no = '$lot_no' and f.vill_townprt_code='$vill_code' and f.dag_no='$Dag_no'")->result();
        // echo "select * FROM chitha_fruit AS f INNER Join fruit_tree_code AS fc ON f.fruit_plants_name = fc.fruit_code WHERE f.dist_code='$dist_code' and f.subdiv_code = '$subdiv_code' and f.cir_code='$cir_code' and f.mouza_pargona_code = '$mouza_code' and f.lot_no = '$lot_no' and f.vill_townprt_code='$vill_code' and f.dag_no='$Dag_no'";
        // var_dump($fruitinfo_dd);
//      $fruitinfocounted = count($fruitinfo_dd);
//      if($fruitinfocounted <='0'){
//          
//      }
        $fruitinfo['frutinfo'] = $fruitinfo_dd;

        //$this->load->view('LmEntryChithaView/selectFruitPlantname', $fruitinfo);
        //$this->load->view('footer');
		
		$fruitinfo['_view'] = 'LmEntryChithaView/selectFruitPlantname';
		$this->load->view('layouts/main',$fruitinfo);
		
		
    }

    public function showfruitPlant() {
		$db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('header');
        $fruitid = $this->input->post('fruit_plant_name');
        $dist_code = $this->session->userdata('dist');
        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $Dag_no = $this->session->userdata('dagnum');
        $fruitinfo_dd = $this->db->query("select * FROM  chitha_fruit AS f INNER Join fruit_tree_code AS fc ON f.fruit_plants_name = fc.fruit_code WHERE f.dist_code='$dist_code' and f.subdiv_code = '$subdiv_code' and f.cir_code='$cir_code' and f.mouza_pargona_code = '$mouza_code' and f.lot_no = '$lot_no' and f.vill_townprt_code='$vill_code' and f.dag_no='$Dag_no' and f.fruit_plant_id='$fruitid'")->row();
        //var_dump($fruitinfo_dd);
        $fruitcode = $fruitinfo_dd->fruit_code;
        $fruitcd = $this->db->query("select * FROM  fruit_tree_code where fruit_code ='$fruitcode'")->row();
      //  var_dump($fruitcd);
        $shownfruitdetails['fruitcode'] = $fruitcd->fruit_code;
        $shownfruitdetails['fruitname'] = $fruitcd->fruit_name;

        $fruit_dd = $this->db->query("select * FROM  fruit_tree_code")->result();
        $shownfruitdetails['fruitlist'] = $fruit_dd;

        $shownfruitdetails['fruitdetails'] = array(
            'fruit_plant_id' => $fruitinfo_dd->fruit_plant_id,
            'no_of_plants' => $fruitinfo_dd->no_of_plants,
            'bigha' => $fruitinfo_dd->fruit_land_area_b,
            'katha' => $fruitinfo_dd->fruit_land_area_k,
            'lesa' => $fruitinfo_dd->fruit_land_area_lc,
        );


        //$this->load->view('LmEntryChithaView/EditFruitdetails', $shownfruitdetails);
        //$this->load->view('footer');
		
		$shownfruitdetails['_view'] = 'LmEntryChithaView/EditFruitdetails';
		$this->load->view('layouts/main',$shownfruitdetails);
    }

    public function modifyfruit() {
		$db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('header');

        $dist_code = $this->session->userdata('dist');

        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $Dag_no = $this->session->userdata('dagnum');
        $fruitid = $this->input->post('fruitid');
        $fruitname = $this->input->post('fruitname');
        $fruit_code = array(
            'fruitname' => $fruitname
        );

        $this->session->set_userdata($fruit_code);


        $numbrplant = $this->input->post('numbrplant');
        $bigha = $this->input->post('bigha');
        $katha = $this->input->post('katha');
        $lesa = $this->input->post('lesa');
       //... $cron_num_query = $this->db->query("select max(cron_no) AS cron from    change_chitha_fruit")->row();
        //  var_dump($cron_num_query);
      //...  $cron_num = $cron_num_query->cron;
        if (isset($_POST['modifyfruit'])) {
            $operation = 'M';
            $userCd = $this->session->userdata('user_code');
            // $userCd = 'M117';
          //...  $cron_no = $cron_num + 1;
            //         $cron_no_initial['cron'] =  $cron_no ;
            //               $this->session->set_userdata($cron_no);
            //     $this->session->userdata('cron');
            $date_of_entry = date("Y-m-d");
            $ganda = '0.0000';
            $kara = '0';
            // $userCd =  $this->session->userdata('$lm_code');
            //echo $bigha.'<br>'.$watersrc_cd;


           //... $cronno = array(
             //...   'crn' => $cron_no
           //... );

          //...  $this->session->set_userdata($cronno);
           //... $cron_num = $this->session->userdata('crn');

         //...   $this->db->query("insert into change_chitha_fruit (dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,dag_no,cron_no,fruit_plant_id,fruit_plants_name,no_of_plants,user_code,date_entry,operation,fruit_land_area_b,fruit_land_area_k,fruit_land_area_lc,fruit_land_area_g,fruit_land_area_kr)values('$dist_code','$subdiv_code','$cir_code','$mouza_code','$lot_no','$vill_code','$Dag_no','$cron_num','$fruitid','$fruitname','$numbrplant','$userCd','$date_of_entry','$operation','$bigha','$katha','$lesa','$ganda','$kara')");


          //...  $sql = "select * from    change_chitha_fruit where  dist_code='$dist_code' "
                //...    . "and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code'"
               //...     . " and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and fruit_plants_name='$fruitname'"
                //...    . " ORDER BY cron_no DESC LIMIT 1";

          //...  $Changefruit = $this->db->query($sql)->row();
            //  var_dump($Changemcrp);
            // $this->db->query("insert into chitha_noncrop(dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,dag_no,noncrop_use_id,yn,type_of_used_noncrop,noncrop_land_area_b,noncrop_land_area_k,noncrop_land_area_lc,noncrop_land_area_g,noncrop_land_area_kr,user_code,date_entry,operation)values('$dist_code','$subdiv_code','$cir_code','$mouza_code','$lot_no','$vill_code','$Dag_no','$Changenoncrp->noncrop_use_id','$Changenoncrp->yn','$Changenoncrp->type_of_used_noncrop','$Changenoncrp->noncrop_land_area_b','$Changenoncrp->noncrop_land_area_k','$Changenoncrp->noncrop_land_area_lc','$Changenoncrp->noncrop_land_area_g','$Changenoncrp->noncrop_land_area_kr','$Changenoncrp->user_code','$Changenoncrp->date_entry','$Changenoncrp->operation')");       


            $this->db->query("update chitha_fruit set fruit_plants_name='$fruitname',no_of_plants='$numbrplant',fruit_land_area_b='$bigha',fruit_land_area_k='$katha',fruit_land_area_lc='$lesa' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and fruit_plant_id='$fruitid'");



            $fruitcd = $this->db->query("select * FROM  fruit_tree_code where fruit_code ='$fruitname'")->row();
            $shownfruitdetails['fruitcode'] = $fruitcd->fruit_code;
            $shownfruitdetails['fruitname'] = $fruitcd->fruit_name;

            $fruit_dd = $this->db->query("select * FROM fruit_tree_code")->result();
            $shownfruitdetails['fruitlist'] = $fruit_dd;

            $shownfruitdetails['fruitdetails'] = array(
                'fruit_plant_id' => $fruitid,
                'no_of_plants' => $numbrplant,
                'bigha' => $bigha,
                'katha' => $katha,
                'lesa' => $lesa,
            );
            //$this->load->view('LmEntryChithaView/EditFruitdetails', $shownfruitdetails);
            //$this->load->view('footer');
			
			$shownfruitdetails['_view'] = 'LmEntryChithaView/EditFruitdetails';
			$this->load->view('layouts/main',$shownfruitdetails);
        } 
//        else {
//            $this->session->unset_userdata('crn');
//        }
    }

//    public function SaveFruitDetail() {
//       
//        $dist_code = $this->session->userdata('dist');
//        //echo $dist_code;
//        $subdiv_code = $this->session->userdata('sub_div');
//        $cir_code = $this->session->userdata('cir_code');
//        $mouza_code = $this->session->userdata('mouza_code');
//        $lot_no = $this->session->userdata('lot_no');
//        $vill_code = $this->session->userdata('vill_code');
//        $Dag_no = $this->session->userdata('dagnum');   
//          $frtcd = $this->session->userdata('fruitname');
//     $sql="select * from    change_chitha_fruit where  dist_code='$dist_code' "
//                 . "and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code'"
//                 . " and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and fruit_plants_name='$frtcd'"
//                . " ORDER BY cron_no DESC LIMIT 1";
//        
//         $Changefruit = $this->db->query($sql)->row();
//       //  var_dump($Changemcrp);
//           // $this->db->query("insert into chitha_noncrop(dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,dag_no,noncrop_use_id,yn,type_of_used_noncrop,noncrop_land_area_b,noncrop_land_area_k,noncrop_land_area_lc,noncrop_land_area_g,noncrop_land_area_kr,user_code,date_entry,operation)values('$dist_code','$subdiv_code','$cir_code','$mouza_code','$lot_no','$vill_code','$Dag_no','$Changenoncrp->noncrop_use_id','$Changenoncrp->yn','$Changenoncrp->type_of_used_noncrop','$Changenoncrp->noncrop_land_area_b','$Changenoncrp->noncrop_land_area_k','$Changenoncrp->noncrop_land_area_lc','$Changenoncrp->noncrop_land_area_g','$Changenoncrp->noncrop_land_area_kr','$Changenoncrp->user_code','$Changenoncrp->date_entry','$Changenoncrp->operation')");       
//          
//            
//            $this->db->query("update chitha_fruit set fruit_plants_name='$Changefruit->fruit_plants_name',no_of_plants='$Changefruit->no_of_plants',user_code='$Changefruit->user_code',date_entry='$Changefruit->date_entry',operation='$Changefruit->operation',fruit_land_area_b='$Changefruit->fruit_land_area_b',fruit_land_area_k='$Changefruit->fruit_land_area_k',fruit_land_area_lc='$Changefruit->fruit_land_area_lc' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and fruit_plant_id='$Changefruit->fruit_plant_id'");   
//     echo 'record has been saved';
//        
//    }
//    

    public function addfruit() {
$db=  $this->session->userdata('db');

        // $this->load->helper('html');
        // $this->load->view('header');
        $dist_code = $this->session->userdata('dist');
        //echo $dist_code;
        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $Dag_no = $this->session->userdata('dagnum');

        $addfruitinfo = $this->db->query("select max(fruit_plant_id) AS fruit_plant_id from    chitha_fruit AS fruit_plant_id WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'")->row();
        // echo "select max(fruit_plant_id) AS fruit_plant_id from    chitha_fruit WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'";
//$addfruitinfo = $this->db->query("select max(fruit_plant_id) AS fruit_plant_id'")->row();
// var_dump($addfruitinfo);
        //echo "select max(fruit_plant_id) AS fruit_plant_id FROM chitha_fruit WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'";
        //var_dump($addnoncropinfo);
        $fruitid = $addfruitinfo->fruit_plant_id;

        $slno_nxt = ($fruitid + 1);
        $showfruitdetails['fruitslno'] = array(
            'fruit_id' => $slno_nxt
        );

        $fruit_dd = $this->db->query("select * FROM  fruit_tree_code")->result();
        $showfruitdetails['fruitlist'] = $fruit_dd;

        //$this->load->view('LmEntryChithaView/addFruitdetails', $showfruitdetails);
        //$this->load->view('footer');
		$showfruitdetails['_view'] = 'LmEntryChithaView/addFruitdetails';
		$this->load->view('layouts/main',$showfruitdetails);
    }

    public function addfruitinfo() {
		$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist');
        //echo $dist_code;
        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $Dag_no = $this->session->userdata('dagnum');
        $fruitid = $this->input->post('fruitid');
        $fruitname = $this->input->post('fruitname');
        $numbrplant = $this->input->post('numbrplant');
        $bigha = $this->input->post('bigha1');
        $katha = $this->input->post('katha');
        $lesa = $this->input->post('lesa');
        $operation = 'M';
        $userCd = $this->session->userdata('user_code');
        // $userCd = 'M117';
        $date_of_entry = date("Y-m-d");
        $land_area_g = '0';
        $land_area_kr = '0';

        //newly modified
        $tot_lessa = $this->session->userdata('totlessa');
        $total_lessa_basic_fruit = $this->utilityclass->Total_Lessa($bigha, $katha, $lesa);


        if ($total_lessa_basic_fruit <= $tot_lessa) {


        //....    $tot_lessa = $tot_lessa - $total_lessa_basic_fruit;
         //....   $total_lessa_frut = array('totlessa' => $tot_lessa);
         //....   $this->session->set_userdata($total_lessa_frut);



            //newly modified




            $this->db->query("INSERT INTO chitha_fruit(
            dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, 
            vill_townprt_code, dag_no, fruit_plant_id, fruit_plants_name, 
            no_of_plants, user_code, date_entry, operation, fruit_land_area_b, 
            fruit_land_area_k, fruit_land_area_lc, fruit_land_area_g, fruit_land_area_kr)
    VALUES ('$dist_code','$subdiv_code','$cir_code','$mouza_code','$lot_no','$vill_code','$Dag_no','$fruitid','$fruitname','$numbrplant','$userCd','$date_of_entry','$operation','$bigha','$katha','$lesa','$land_area_g','$land_area_kr')");
            //echo'inserted';
            $this->addfruit();
     } else {
           echo "<script>";
           echo "  alert('the inserted Land Area exceeds remaining area ')";
           echo"</script>";
            $this->addfruit();
        }
    }

    public function nextarcheoname() {
$db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('header');
        $dist_code = $this->session->userdata('dist');
        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $Dag_no = $this->session->userdata('dagnum');
        $ARCHEOinfo_dd = $this->db->query("select * FROM  chitha_acho_hist AS AH INNER Join archeo_hist_site_code AS AHC ON AH.archeo_hist_code = AHC.archeo_hist_code WHERE AH.dist_code='$dist_code' and AH.subdiv_code = '$subdiv_code' and AH.cir_code='$cir_code' and AH.mouza_pargona_code = '$mouza_code' and AH.lot_no = '$lot_no' and AH.vill_townprt_code='$vill_code' and AH.dag_no='$Dag_no'")->result();
        // echo "select * FROM chitha_fruit AS f INNER Join fruit_tree_code AS fc ON f.fruit_plants_name = fc.fruit_code WHERE f.dist_code='$dist_code' and f.subdiv_code = '$subdiv_code' and f.cir_code='$cir_code' and f.mouza_pargona_code = '$mouza_code' and f.lot_no = '$lot_no' and f.vill_townprt_code='$vill_code' and f.dag_no='$Dag_no'";
        // var_dump($fruitinfo_dd);
        $archeodetails['archeoinfo'] = $ARCHEOinfo_dd;

        //$this->load->view('LmEntryChithaView/selectArcheological', $archeodetails);
        //$this->load->view('footer');
		$archeodetails['_view'] = 'LmEntryChithaView/selectArcheological';
		$this->load->view('layouts/main',$archeodetails);
    }

    public function showarcheoinfo() {
		$db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('header');
        $aslno = $this->input->post('place_name');

        $dist_code = $this->session->userdata('dist');
        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $Dag_no = $this->session->userdata('dagnum');
        $ARCHEOinfo_dd = $this->db->query("select * FROM  chitha_acho_hist AS AH INNER Join archeo_hist_site_code AS AHC ON AH.archeo_hist_code = AHC.archeo_hist_code WHERE AH.dist_code='$dist_code' and AH.subdiv_code = '$subdiv_code' and AH.cir_code='$cir_code' and AH.mouza_pargona_code = '$mouza_code' and AH.lot_no = '$lot_no' and AH.vill_townprt_code='$vill_code' and AH.dag_no='$Dag_no' and AH.archeo_sl_no='$aslno'")->row();
      $placename= $ARCHEOinfo_dd->archeo_hist_code;
        
        $archeohistcd = $this->db->query("select * FROM  archeo_hist_site_code where archeo_hist_code ='$placename'")->row();

        $showarcheoinfo['archeo_hist_code'] = $archeohistcd->archeo_hist_code;
        $showarcheoinfo['archeo_hist_desc'] = $archeohistcd->archeo_hist_desc;
        $archeosite_dd = $this->db->query("select * FROM  archeo_hist_site_code")->result();
        $showarcheoinfo['placenamelist'] = $archeosite_dd;

        $showarcheoinfo['archeodetails'] = array(
            'archeo_sl_no' => $ARCHEOinfo_dd->archeo_sl_no,
            'archeo_hist_site_desc' => $ARCHEOinfo_dd->archeo_hist_site_desc,
            'bigha' => $ARCHEOinfo_dd->hist_land_area_b,
            'katha' => $ARCHEOinfo_dd->hist_land_area_k,
            'lesa' => $ARCHEOinfo_dd->hist_land_area_lc,
        );




        //$this->load->view('LmEntryChithaView/EditArcheological', $showarcheoinfo);
        //$this->load->view('footer');
		$showarcheoinfo['_view'] = 'LmEntryChithaView/EditArcheological';
		$this->load->view('layouts/main',$showarcheoinfo);
    }

    public function archeomodify() {
		$db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('header');

        $dist_code = $this->session->userdata('dist');

        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $Dag_no = $this->session->userdata('dagnum');
        $historicalid = $this->input->post('historicalid');
        $placename = $this->input->post('placename');
        $placename_code = array(
            'placename' => $placename
        );

        $this->session->set_userdata($placename_code);



        $placedesc = $this->input->post('placedescript');
        $bigha = $this->input->post('bigha');
        $katha = $this->input->post('katha');
        $lesa = $this->input->post('lesa');
       //... $cron_num_query = $this->db->query("select max(cron_no) AS cron from    change_chitha_acho_hist")->row();
        //  var_dump($cron_num_query);
     //...   $cron_num = $cron_num_query->cron;

        if (isset($_POST['modifyarcheo'])) {
            $operation = 'M';
            $userCd = $this->session->userdata('user_code');
            //$userCd = 'M117';
          //...  $cron_no = $cron_num + 1;
            //         $cron_no_initial['cron'] =  $cron_no ;
            //               $this->session->set_userdata($cron_no);
            //     $this->session->userdata('cron');
            $date_of_entry = date("Y-m-d");
            // $userCd =  $this->session->userdata('$lm_code');
            //echo $bigha.'<br>'.$watersrc_cd;
            $ganda = '0';
            $kara = '0';

           //... $cronno = array(
             //...   'crn' => $cron_no
           //... );

         //...   $this->session->set_userdata($cronno);
         //...   $cron_num = $this->session->userdata('crn');

          //...  $this->db->query("INSERT INTO change_chitha_acho_hist(
         //...   dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, 
       //...     vill_townprt_code, dag_no, cron_no, archeo_sl_no, archeo_hist_code, 
          //...  archeo_hist_site_desc, hist_land_area_b, hist_land_area_k, hist_land_area_lc,hist_land_area_g,hist_land_area_kr 
          //...   ,user_code, date_entry, operation)
   //... VALUES ('$dist_code','$subdiv_code','$cir_code','$mouza_code','$lot_no','$vill_code','$Dag_no','$cron_num','$historicalid','$placename','$placedesc','$bigha','$katha','$lesa','$ganda','$kara','$userCd','$date_of_entry','$operation')");


          //...  $sql = "select * from    change_chitha_acho_hist where  dist_code='$dist_code' "
                 //...   . "and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code'"
                   //... . " and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and archeo_hist_code='$placename'"
                  //...  . " ORDER BY cron_no DESC LIMIT 1";

          //...  $ChangeArcheo = $this->db->query($sql)->row();
            //var_dump($ChangeArcheo);
            // $this->db->query("insert into chitha_noncrop(dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,dag_no,noncrop_use_id,yn,type_of_used_noncrop,noncrop_land_area_b,noncrop_land_area_k,noncrop_land_area_lc,noncrop_land_area_g,noncrop_land_area_kr,user_code,date_entry,operation)values('$dist_code','$subdiv_code','$cir_code','$mouza_code','$lot_no','$vill_code','$Dag_no','$Changenoncrp->noncrop_use_id','$Changenoncrp->yn','$Changenoncrp->type_of_used_noncrop','$Changenoncrp->noncrop_land_area_b','$Changenoncrp->noncrop_land_area_k','$Changenoncrp->noncrop_land_area_lc','$Changenoncrp->noncrop_land_area_g','$Changenoncrp->noncrop_land_area_kr','$Changenoncrp->user_code','$Changenoncrp->date_entry','$Changenoncrp->operation')");       


            $this->db->query("update chitha_acho_hist set archeo_hist_code='$placename',archeo_hist_site_desc='$placedesc',hist_land_area_b='$bigha',hist_land_area_k='$katha',hist_land_area_lc='$lesa' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and archeo_sl_no='$historicalid'");
            //echo 'record has been saved';




            $archeohistcd = $this->db->query("select * FROM  archeo_hist_site_code where archeo_hist_code ='$placename'")->row();

            $showarcheoinfo['archeo_hist_code'] = $archeohistcd->archeo_hist_code;
            $showarcheoinfo['archeo_hist_desc'] = $archeohistcd->archeo_hist_desc;
            $archeosite_dd = $this->db->query("select * FROM  archeo_hist_site_code")->result();
            $showarcheoinfo['placenamelist'] = $archeosite_dd;


            $showarcheoinfo['archeodetails'] = array(
                'archeo_sl_no' => $historicalid,
                'archeo_hist_site_desc' => $placedesc,
                'bigha' => $bigha,
                'katha' => $katha,
                'lesa' => $lesa,
            );

            //$this->load->view('LmEntryChithaView/EditArcheological', $showarcheoinfo);
            //$this->load->view('footer');
			$showarcheoinfo['_view'] = 'LmEntryChithaView/EditArcheological';
			$this->load->view('layouts/main',$showarcheoinfo);
			
        } 
        
//        else {
//            $this->session->unset_userdata('crn');
//        }
    }

//   public function SaveArcheoDetail() {
//       
//        $dist_code = $this->session->userdata('dist');
//        //echo $dist_code;
//        $subdiv_code = $this->session->userdata('sub_div');
//        $cir_code = $this->session->userdata('cir_code');
//        $mouza_code = $this->session->userdata('mouza_code');
//        $lot_no = $this->session->userdata('lot_no');
//        $vill_code = $this->session->userdata('vill_code');
//        $Dag_no = $this->session->userdata('dagnum');   
//        $placecd = $this->session->userdata('placename');
//      
//          
//          
//            $sql="select * from    change_chitha_acho_hist where  dist_code='$dist_code' "
//                 . "and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code'"
//                 . " and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and archeo_hist_code='$placecd'"
//                . " ORDER BY cron_no DESC LIMIT 1";
//        
//         $ChangeArcheo = $this->db->query($sql)->row();
//       //  var_dump($Changemcrp);
//           // $this->db->query("insert into chitha_noncrop(dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,dag_no,noncrop_use_id,yn,type_of_used_noncrop,noncrop_land_area_b,noncrop_land_area_k,noncrop_land_area_lc,noncrop_land_area_g,noncrop_land_area_kr,user_code,date_entry,operation)values('$dist_code','$subdiv_code','$cir_code','$mouza_code','$lot_no','$vill_code','$Dag_no','$Changenoncrp->noncrop_use_id','$Changenoncrp->yn','$Changenoncrp->type_of_used_noncrop','$Changenoncrp->noncrop_land_area_b','$Changenoncrp->noncrop_land_area_k','$Changenoncrp->noncrop_land_area_lc','$Changenoncrp->noncrop_land_area_g','$Changenoncrp->noncrop_land_area_kr','$Changenoncrp->user_code','$Changenoncrp->date_entry','$Changenoncrp->operation')");       
//          
//            
//            $this->db->query("update chitha_acho_hist set archeo_sl_no='$ChangeArcheo->archeo_sl_no',archeo_hist_code='$ChangeArcheo->archeo_hist_code',archeo_hist_site_desc='$ChangeArcheo->archeo_hist_site_desc',hist_land_area_b='$ChangeArcheo->hist_land_area_b',hist_land_area_k='$ChangeArcheo->hist_land_area_k',hist_land_area_lc='$ChangeArcheo->hist_land_area_lc',hist_land_area_g='$ChangeArcheo->hist_land_area_g',hist_land_area_kr='$ChangeArcheo->hist_land_area_kr',user_code='$ChangeArcheo->user_code',date_entry='$ChangeArcheo->date_entry',operation='$ChangeArcheo->operation' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'");   
//     echo 'record has been saved';
//        
//    } 

    public function addarcheo() {
		$db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('header');
        $dist_code = $this->session->userdata('dist');
        //echo $dist_code;
        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $Dag_no = $this->session->userdata('dagnum');

        $addarcheoinfo = $this->db->query("select max(archeo_sl_no) AS archeo_sl_no FROM  chitha_acho_hist WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'")->row();
        // var_dump($addfruitinfo);
        //echo "select max(fruit_plant_id) AS fruit_plant_id FROM chitha_fruit WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'";
        //var_dump($addnoncropinfo);
        $archeoid = $addarcheoinfo->archeo_sl_no;

        $slno_nxt = $archeoid + 1;
        $showarcheoinfo['Archeoslno'] = array(
            'archeo_id' => $slno_nxt
        );

        $archeosite_dd = $this->db->query("select * FROM archeo_hist_site_code")->result();
        $showarcheoinfo['placenamelist'] = $archeosite_dd;

        //$this->load->view('LmEntryChithaView/addArcheodetails', $showarcheoinfo);
        //$this->load->view('footer');
		$showarcheoinfo['_view'] = 'LmEntryChithaView/addArcheodetails';
		$this->load->view('layouts/main',$showarcheoinfo);
    }

    public function submitarcheo() {
$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist');
        //echo $dist_code;
        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $Dag_no = $this->session->userdata('dagnum');
        $historicalid = $this->input->post('historicalid');
        $placename = $this->input->post('placename');
        $placedescript = $this->input->post('placedescript');
        $bigha = $this->input->post('bigha1');
        $katha = $this->input->post('katha');
        $lesa = $this->input->post('lesa');
        $operation = 'M';
        $userCd = $this->session->userdata('user_code');
        // $userCd = 'M117';
        $date_of_entry = date("Y-m-d");
        $land_area_g = '0';
        $land_area_kr = '0';

        //newly modified
        $tot_lessa = $this->session->userdata('totlessa');
        $total_lessa_basic_archo = $this->utilityclass->Total_Lessa($bigha, $katha, $lesa);


       if ($total_lessa_basic_archo <= $tot_lessa) {


          //....  $tot_lessa = $tot_lessa - $total_lessa_basic_archo;
          //....  $total_lessa_archo = array('totlessa' => $tot_lessa);
            //....$this->session->set_userdata($total_lessa_archo);



            //newly modified


            $this->db->query("INSERT INTO chitha_acho_hist(
            dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, 
            vill_townprt_code, dag_no, archeo_sl_no, archeo_hist_code, archeo_hist_site_desc, 
            hist_land_area_b, hist_land_area_k, hist_land_area_lc, hist_land_area_g, 
            hist_land_area_kr, user_code, date_entry, operation)
    VALUES ('$dist_code','$subdiv_code','$cir_code','$mouza_code','$lot_no','$vill_code','$Dag_no','$historicalid','$placename','$placedescript','$bigha','$katha','$lesa','$land_area_g','$land_area_kr','$userCd','$date_of_entry','$operation')");


            $this->addarcheo();
        } else {
           echo "<script>";
            echo "  alert('the inserted Land Area exceeds remaining area ')";
           echo"</script>";
            $this->addarcheo();
        }
    }

    public function nextLmselectOption() {
		$db=  $this->session->userdata('db');
        $this->load->helper('html');

        $this->menuforSelectingOption();
        // $this->load->view('LmEntryChithaView/selectLmEncroOption');
    }

    public function LMnote() {
		$db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('header');

        $dist_code = $this->session->userdata('dist');
        //echo $dist_code;
        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $Dag_no = $this->session->userdata('dagnum');

        // $lmnote_dd = $this->db->query("select * FROM chitha_rmk_lmnote  WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'")->result();
        //echo "select * FROM chitha_rmk_lmnote  WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'";
        $lmnote_dd = $this->db->query("select * FROM  chitha_rmk_lmnote  WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'")->result();
        //var_dump($lmnote_dd);
        $result_lineno = count($lmnote_dd);
        // echo  $result_lineno;
        if ($result_lineno <= '0') {

            $msgStr = "<script>alert('there are no records');</script>";
            print $msgStr;
        } else {
            $msgStr = "<script>alert('there are  $result_lineno LM notes corresponding to dag number $Dag_no ');</script>";
            print $msgStr;
        }
        // echo "there are  $result_lineno LM notes corresponding to $Dag_no dag ";
        $data['lminfo'] = $lmnote_dd;
		$data['_view'] = 'LmEntryChithaView/selectRmkLineno';
		$this->load->view('layouts/main',$data);
        		
    }

    public function showlmnoteInfo() {
		$db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('header');
        $lmnote = $this->input->post('lmnote');
        // echo $lmnote;
        $codeArr = explode("-", $lmnote);
        $histno = $codeArr[0];
        $lineno = $codeArr[1];

        $dist_code = $this->session->userdata('dist');
        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $Dag_no = $this->session->userdata('dagnum');

        $lmnoteDETAILS = $this->db->query("select * FROM  chitha_rmk_lmnote WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and rmk_type_hist_no='$histno' and lm_note_lno='$lineno'")->row();
        //echo "select * FROM chitha_rmk_lmnote WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and rmk_type_hist_no='$histno' and lm_note_lno='$lineno'"; 
        $result = count($lmnoteDETAILS);

        if ($result <= '0') {
            $lminfos['lmrecords'] = array(
                'cronno' => '',
                'histno' => '',
                'lineno' => '',
                'lm_note' => '',
                'dateentry' => '',
                'lm_code' => '',
                'lm_sign' => '',
                'co_approval' => '',
                'lm_name' => '',
                'result' => $result
            );
        } else {
            $lm_code = $this->session->userdata('user_code');
            $lmname = $this->db->query("select * FROM  lm_code where lm_code ='$lm_code'")->row();
            // $lmname = $this->db->query("select * FROM lm_code where lm_code ='$lmnoteDETAILS->lm_code'")->row(); 
            //echo "select * FROM lm_code where lm_code ='$lmnoteDETAILS->lm_code'";

            $lmname_counted = count($lmname);

            if ($lmname_counted != '0') {
                $lmname = $lmname->lm_name;
            } else {
                $lmname = 'null';
            }
            $lminfos['lmrecords'] = array(
                'cronno' => $lmnoteDETAILS->lm_note_cron_no,
                'histno' => $lmnoteDETAILS->rmk_type_hist_no,
                'lineno' => $lmnoteDETAILS->lm_note_lno,
                'lm_note' => $lmnoteDETAILS->lm_note,
                'dateentry' => $lmnoteDETAILS->date_entry,
                'lm_code' => $lmnoteDETAILS->lm_code,
                'lm_sign' => $lmnoteDETAILS->lm_sign,
                'co_approval' => $lmnoteDETAILS->co_approval,
                'lm_name' => $lmname,
                'result' => $result
            );
        }

        $lmdetailss = $this->db->query("Select * from    lm_code")->result();
        $lminfos['lm_detail'] = $lmdetailss;
        //$this->load->view('LmEntryChithaView/lmnotedetails', $lminfos);
        //$this->load->view('footer');
		$lminfos['_view'] = 'LmEntryChithaView/lmnotedetails';
		$this->load->view('layouts/main',$lminfos);
    }

//    public function modifylmnote() {
//        $this->load->helper('html');
//        $this->load->view('header');
//
//        $dist_code = $this->session->userdata('dist');
//        $subdiv_code = $this->session->userdata('sub_div');
//        $cir_code = $this->session->userdata('cir_code');
//        $mouza_code = $this->session->userdata('mouza_code');
//        $lot_no = $this->session->userdata('lot_no');
//        $vill_code = $this->session->userdata('vill_code');
//        $Dag_no = $this->session->userdata('dagnum');
//        $lmNOtecron = $this->input->post('lmNOtecron');
//        $lmnotecronNumbr = array(
//            'lmNOtecron' => $lmNOtecron
//        );
//        $this->session->set_userdata($lmnotecronNumbr);
//
//        $lmNotelinenum = $this->input->post('lmNotelinenum');
//
//        $lmNotelineno = array(
//            'lmNotelinenum' => $lmNotelinenum
//        );
//
//        $this->session->set_userdata($lmNotelineno);
//
//
//
//
//        $lmNotehistnum = $this->input->post('lmNotehistnum');
//        $historynum = array(
//            'lmNotehistnum' => $lmNotehistnum
//        );
//
//        $this->session->set_userdata($historynum);
//
//        $lmNOte = $this->input->post('lmNOte');
//       // $lmNOteDate = $this->input->post('lmNOteDate');
//		
//		$lmNOteDate = date('Y-m-d',strtotime($this->input->post('lmNOteDate')));
//        $lmname = $this->input->post('lmname');
//        $lmsign = $this->input->post('s');
//        $approval = $this->input->post('f');
//
//       // $cron_num_query = $this->db->query("select max(cron_no) AS cron from    change_chitha_rmk_lmnote")->row();
//        //  var_dump($cron_num_query);
//        //$cron_num = $cron_num_query->cron;
//
//        if (isset($_POST['modifylmnote'])) {
//            $operation = 'M';
//            $userCd = $this->session->userdata('user_code');
//            //$userCd = 'M117';
//          //  $cron_no = $cron_num + 1;
//            //         $cron_no_initial['cron'] =  $cron_no ;
//            //               $this->session->set_userdata($cron_no);
//            //     $this->session->userdata('cron');
//            $date_of_entry = date("Y-m-d");
//            // $userCd =  $this->session->userdata('$lm_code');
//            //echo $bigha.'<br>'.$watersrc_cd;
//
//
////            $cronno = array(
////                'crn' => $cron_no
////            );
//            
//          //  $hist_no = $Dag_no + 1;
//
//          //  $this->session->set_userdata($cronno);
//           // $cron_num = $this->session->userdata('crn');
////            $this->db->query("INSERT INTO change_chitha_rmk_lmnote(
////            dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, 
////            vill_townprt_code, dag_no, cron_no, lm_note_cron_no, rmk_type_hist_no, 
////            lm_note_lno, lm_note, lm_note_date, lm_code, lm_sign, co_approval, 
////            user_code, date_entry, operation)
////    VALUES ('$dist_code','$subdiv_code','$cir_code','$mouza_code','$lot_no','$vill_code','$Dag_no','$cron_num','$lmNOtecron','$lmNotehistnum','$lmNotelinenum','$lmNOte','$lmNOteDate','$lmname','$lmsign','$approval','$userCd','$date_of_entry','$operation')");
////
////            $sql = "select * from    change_chitha_rmk_lmnote where  dist_code='$dist_code' "
////                    . "and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code'"
////                    . " and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and rmk_type_hist_no='$lmNotehistnum' and lm_note_lno='$lmNotelinenum'"
////                    . " ORDER BY cron_no DESC LIMIT 1";
////
////            $ChangeRMKlmnote = $this->db->query($sql)->row();
//            // var_dump($ChangeRMKlmnote);
//            //$this->db->query("insert into chitha_noncrop(dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,dag_no,noncrop_use_id,yn,type_of_used_noncrop,noncrop_land_area_b,noncrop_land_area_k,noncrop_land_area_lc,noncrop_land_area_g,noncrop_land_area_kr,user_code,date_entry,operation)values('$dist_code','$subdiv_code','$cir_code','$mouza_code','$lot_no','$vill_code','$Dag_no','$Changenoncrp->noncrop_use_id','$Changenoncrp->yn','$Changenoncrp->type_of_used_noncrop','$Changenoncrp->noncrop_land_area_b','$Changenoncrp->noncrop_land_area_k','$Changenoncrp->noncrop_land_area_lc','$Changenoncrp->noncrop_land_area_g','$Changenoncrp->noncrop_land_area_kr','$Changenoncrp->user_code','$Changenoncrp->date_entry','$Changenoncrp->operation')");       
//
//            $lmCd = $this->session->userdata('user_code');
//
//
////            $this->db->query("update chitha_rmk_lmnote set lm_note='$ChangeRMKlmnote->lm_note',lm_note_date='$ChangeRMKlmnote->lm_note_date',lm_code='$ChangeRMKlmnote->lm_code',lm_sign='$ChangeRMKlmnote->lm_sign',co_approval='$ChangeRMKlmnote->co_approval' 
////	 where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and rmk_type_hist_no='$lmNotehistnum' and lm_note_lno='$lmNotelinenum' and lm_note_cron_no='$lmNOtecron'");
// 
//            
//            $this->db->query("update chitha_rmk_lmnote set lm_note='$lmNOte',lm_note_date='$lmNOteDate',lm_code='$lmname',lm_sign='$lmsign',co_approval='$approval'
//	 where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and rmk_type_hist_no='$lmNotehistnum' and lm_note_lno='$lmNotelinenum' and lm_note_cron_no='$lmNOtecron'");
//
//
//
//            //echo "update chitha_rmk_lmnote set lm_note='$ChangeRMKlmnote->lm_note',lm_note_date='$ChangeRMKlmnote->lm_note_date',lm_code='$ChangeRMKlmnote->lm_code',lm_sign='$ChangeRMKlmnote->lm_sign',co_approval='$ChangeRMKlmnote->co_approval' 
//            // where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and rmk_type_hist_no='$lmNotehistnum' and lm_note_lno='$lmNotelinenum' and lm_note_cron_no='$lmNOtecron'";
//            $lmname = $this->db->query("select * FROM lm_code WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and lm_code='$lmCd'")->row();
//            // echo "select * FROM lm_code WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and lm_code='$lmCd'"; 
//            // $countlm = count($lmname);
//            // if($countlm != 0){
//            //  }
//            $lminfos['name'] = $lmname->lm_name;
//            $lminfos['code'] = $lmname->lm_code;
//            $lmname_dd = $this->db->query("select * FROM lm_code where dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and lm_code='$lmname->lm_code'")->result();
//            $lminfos['lm_nme'] = $lmname_dd;
//            $lminfos['lmrecords'] = array(
//                'cronno' => $lmNOtecron,
//                'histno' => $lmNotehistnum,
//                'lineno' => $lmNotelinenum,
//                'lm_note' => $lmNOte,
//                'dateentry' => $lmNOteDate,
//                'lm_code' => $lmname,
//                'lm_sign' => $lmsign,
//                'co_approval' => $approval,
//            );
//
//
//            $this->load->view('LmEntryChithaView/lmnotedetails', $lminfos);
//            $this->load->view('footer');
//        } else {
//            $this->session->unset_userdata('crn');
//        }
//    }
//    
    
    
    
    
    
    
    
    
    
       public function modifylmnote() {
		   $db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('header');

        $dist_code = $this->session->userdata('dist');
        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $Dag_no = $this->session->userdata('dagnum');
        $lmNOtecron = $this->input->post('lmNOtecron');
        $lmnotecronNumbr = array(
            'lmNOtecron' => $lmNOtecron
        );
        $this->session->set_userdata($lmnotecronNumbr);

        $lmNotelinenum = $this->input->post('lmNotelinenum');

        $lmNotelineno = array(
            'lmNotelinenum' => $lmNotelinenum
        );

        $this->session->set_userdata($lmNotelineno);




        $lmNotehistnum = $this->input->post('lmNotehistnum');
        $historynum = array(
            'lmNotehistnum' => $lmNotehistnum
        );

        $this->session->set_userdata($historynum);

        $lmNOte = $this->input->post('lmNOte');
       // $lmNOteDate = $this->input->post('lmNOteDate');
		
		$lmNOteDate = date('Y-m-d',strtotime($this->input->post('lmNOteDate')));
        $lmname = $this->input->post('lmname');
        $lmsign = $this->input->post('s');
        $approval = $this->input->post('f');

       // ...$cron_num_query = $this->db->query("select max(cron_no) AS cron from    change_chitha_rmk_lmnote")->row();
        //  var_dump($cron_num_query);
       //... $cron_num = $cron_num_query->cron;

        if (isset($_POST['modifylmnote'])) {
            $operation = 'M';
            $userCd = $this->session->userdata('user_code');
            //$userCd = 'M117';
          //...  $cron_no = $cron_num + 1;
            //         $cron_no_initial['cron'] =  $cron_no ;
            //               $this->session->set_userdata($cron_no);
            //     $this->session->userdata('cron');
            $date_of_entry = date("Y-m-d");
            // $userCd =  $this->session->userdata('$lm_code');
            //echo $bigha.'<br>'.$watersrc_cd;


           //... $cronno = array(
            //...    'crn' => $cron_no
           //... );
            
          //...  $hist_no = $Dag_no + 1;

          //...  $this->session->set_userdata($cronno);
          //...  $cron_num = $this->session->userdata('crn');
           //... $this->db->query("INSERT INTO change_chitha_rmk_lmnote(
          //...  dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, 
           //... vill_townprt_code, dag_no, cron_no, lm_note_cron_no, rmk_type_hist_no, 
           //... lm_note_lno, lm_note, lm_note_date, lm_code, lm_sign, co_approval, 
           //... user_code, date_entry, operation)
   //... VALUES ('$dist_code','$subdiv_code','$cir_code','$mouza_code','$lot_no','$vill_code','$Dag_no','$cron_num','$lmNOtecron','$lmNotehistnum','$lmNotelinenum','$lmNOte','$lmNOteDate','$lmname','$lmsign','$approval','$userCd','$date_of_entry','$operation')");

           //... $sql = "select * from    change_chitha_rmk_lmnote where  dist_code='$dist_code' "
                //...    . "and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code'"
                 //...   . " and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and rmk_type_hist_no='$lmNotehistnum' and lm_note_lno='$lmNotelinenum'"
                   //... . " ORDER BY cron_no DESC LIMIT 1";

           //... $ChangeRMKlmnote = $this->db->query($sql)->row();
            // var_dump($ChangeRMKlmnote);
            //$this->db->query("insert into chitha_noncrop(dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,dag_no,noncrop_use_id,yn,type_of_used_noncrop,noncrop_land_area_b,noncrop_land_area_k,noncrop_land_area_lc,noncrop_land_area_g,noncrop_land_area_kr,user_code,date_entry,operation)values('$dist_code','$subdiv_code','$cir_code','$mouza_code','$lot_no','$vill_code','$Dag_no','$Changenoncrp->noncrop_use_id','$Changenoncrp->yn','$Changenoncrp->type_of_used_noncrop','$Changenoncrp->noncrop_land_area_b','$Changenoncrp->noncrop_land_area_k','$Changenoncrp->noncrop_land_area_lc','$Changenoncrp->noncrop_land_area_g','$Changenoncrp->noncrop_land_area_kr','$Changenoncrp->user_code','$Changenoncrp->date_entry','$Changenoncrp->operation')");       

            $lmCd = $this->session->userdata('user_code');


          //..  $this->db->query("update chitha_rmk_lmnote set lm_note='$ChangeRMKlmnote->lm_note',lm_note_date='$ChangeRMKlmnote->lm_note_date',lm_code='$ChangeRMKlmnote->lm_code',lm_sign='$ChangeRMKlmnote->lm_sign',co_approval='$ChangeRMKlmnote->co_approval' 
	//.. where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and rmk_type_hist_no='$lmNotehistnum' and lm_note_lno='$lmNotelinenum' and lm_note_cron_no='$lmNOtecron'");
 
            
            $this->db->query("update chitha_rmk_lmnote set lm_note='$lmNOte',lm_note_date='$lmNOteDate',lm_code='$lmname',lm_sign='$lmsign',co_approval='$approval',rmk_type_hist_no='$lmNotehistnum'
	 where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and rmk_type_hist_no='$lmNotehistnum' and lm_note_lno='$lmNotelinenum' and lm_note_cron_no='$lmNOtecron'");



            //echo "update chitha_rmk_lmnote set lm_note='$ChangeRMKlmnote->lm_note',lm_note_date='$ChangeRMKlmnote->lm_note_date',lm_code='$ChangeRMKlmnote->lm_code',lm_sign='$ChangeRMKlmnote->lm_sign',co_approval='$ChangeRMKlmnote->co_approval' 
            // where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and rmk_type_hist_no='$lmNotehistnum' and lm_note_lno='$lmNotelinenum' and lm_note_cron_no='$lmNOtecron'";
            $lmname = $this->db->query("select * FROM  lm_code WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and lm_code='$lmCd'")->row();
            // echo "select * FROM lm_code WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and lm_code='$lmCd'"; 
            // $countlm = count($lmname);
            // if($countlm != 0){
            //  }
            $lminfos['name'] = $lmname->lm_name;
            $lminfos['code'] = $lmname->lm_code;
            $lmname_dd = $this->db->query("select * FROM  lm_code where dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and lm_code='$lmname->lm_code'")->result();
            $lminfos['lm_nme'] = $lmname_dd;
            $lminfos['lmrecords'] = array(
                'cronno' => $lmNOtecron,
                'histno' => $lmNotehistnum,
                'lineno' => $lmNotelinenum,
                'lm_note' => $lmNOte,
                'dateentry' => $lmNOteDate,
                'lm_code' => $lmname,
                'lm_sign' => $lmsign,
                'co_approval' => $approval,
            );


            //$this->load->view('LmEntryChithaView/lmnotedetails', $lminfos);
            //$this->load->view('footer');
			$lminfos['_view'] = 'LmEntryChithaView/lmnotedetails';
			$this->load->view('layouts/main',$lminfos);
        } 
        
        //...else {
           //... $this->session->unset_userdata('crn');
      //...  }
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

// public function savelmnote() {
//     
//        $dist_code = $this->session->userdata('dist');
//        //echo $dist_code;
//        $subdiv_code = $this->session->userdata('sub_div');
//        $cir_code = $this->session->userdata('cir_code');
//        $mouza_code = $this->session->userdata('mouza_code');
//        $lot_no = $this->session->userdata('lot_no');
//        $vill_code = $this->session->userdata('vill_code');
//        $Dag_no = $this->session->userdata('dagnum'); 
//         $lmNotelinenum = $this->session->userdata('lmNotelinenum'); 
//           $lmNotehistnum = $this->session->userdata('lmNotehistnum');
//           
//           
//              $sql="select * from    change_chitha_rmk_lmnote where  dist_code='$dist_code' "
//                 . "and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code'"
//                 . " and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and rmk_type_hist_no='$lmNotehistnum' and lm_note_lno='$lmNotelinenum'"
//                . " ORDER BY cron_no DESC LIMIT 1";
//        
//         $ChangeRMKlmnote = $this->db->query($sql)->row();
//        // var_dump($ChangeRMKlmnote);
//           //$this->db->query("insert into chitha_noncrop(dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,dag_no,noncrop_use_id,yn,type_of_used_noncrop,noncrop_land_area_b,noncrop_land_area_k,noncrop_land_area_lc,noncrop_land_area_g,noncrop_land_area_kr,user_code,date_entry,operation)values('$dist_code','$subdiv_code','$cir_code','$mouza_code','$lot_no','$vill_code','$Dag_no','$Changenoncrp->noncrop_use_id','$Changenoncrp->yn','$Changenoncrp->type_of_used_noncrop','$Changenoncrp->noncrop_land_area_b','$Changenoncrp->noncrop_land_area_k','$Changenoncrp->noncrop_land_area_lc','$Changenoncrp->noncrop_land_area_g','$Changenoncrp->noncrop_land_area_kr','$Changenoncrp->user_code','$Changenoncrp->date_entry','$Changenoncrp->operation')");       
//          
//            
//     $this->db->query("update chitha_rmk_lmnote set lm_note_cron_no='$ChangeRMKlmnote->lm_note_cron_no',rmk_type_hist_no='$ChangeRMKlmnote->rmk_type_hist_no',lm_note_lno='$ChangeRMKlmnote->lm_note_lno',lm_note='$ChangeRMKlmnote->lm_note',lm_note_date='$ChangeRMKlmnote->lm_note_date',lm_code='$ChangeRMKlmnote->lm_code',lm_sign='$ChangeRMKlmnote->lm_sign',co_approval='$ChangeRMKlmnote->co_approval',user_code='$ChangeRMKlmnote->user_code',date_entry='$ChangeRMKlmnote->date_entry',operation='$ChangeRMKlmnote->operation' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and rmk_type_hist_no='$lmNotehistnum' and lm_note_lno='$lmNotelinenum'");   
//   //echo "update chitha_rmk_lmnote set lm_note_cron_no='$ChangeRMKlmnote->lm_note_cron_no',rmk_type_hist_no='$ChangeRMKlmnote->rmk_type_hist_no',lm_note_lno='$ChangeRMKlmnote->lm_note_lno',lm_note='$ChangeRMKlmnote->lm_note',lm_note_date='$ChangeRMKlmnote->lm_note_date',lm_code='$ChangeRMKlmnote->lm_code',lm_sign='$ChangeRMKlmnote->lm_sign',co_approval='$ChangeRMKlmnote->co_approval',user_code='$ChangeRMKlmnote->user_code',date_entry='$ChangeRMKlmnote->date_entry',operation='$ChangeRMKlmnote->operation' where dist_code='12' and subdiv_code='01' and cir_code='06' and mouza_pargona_code='01' and lot_no='01' and vill_townprt_code='10002' and dag_no='39' and rmk_type_hist_no='$lmNotehistnum' and lm_note_lno='$lmNotelinenum'";
//     
//     
// }

    public function addnewline() {
		$db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('header');
        //$lmNotecronnum=1;
        //$lmNotelinenum=1;
        //$lmNotehistnum=1;
        $dist_code = $this->session->userdata('dist');
        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $Dag_no = $this->session->userdata('dagnum');
        $lmname = $this->input->post('lmname');
        $maxNotecron = $this->db->query("select max(lm_note_cron_no) FROM  chitha_rmk_lmnote WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and lm_code='$lmname'")->row();
        //select max(lm_note_cron_no),max(rmk_type_hist_no),max(lm_note_lno) from    chitha_rmk_lmnote
        // $lmNotecronnum = $this->session->userdata('lmNOtecron');
        $lmNotecronnumCount = count($maxNotecron);

        $lmNotecronnum = $lmNotecronnumCount + 1;
        //echo $lmNotecronnum;
        $maxnote_line = $this->db->query("select max(lm_note_lno) FROM  chitha_rmk_lmnote WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and lm_code='$lmname'")->row();
        //  $lmNotelinenum = $this->session->userdata('lmNotelinenum'); 
        $lmNotelinenumCount = count($maxnote_line);
        $lmNotelinenum = $lmNotelinenumCount + 1;
        //echo   $lmNotelinenum;
        $maxnote_histno = $this->db->query("select max(rmk_type_hist_no) FROM  chitha_rmk_lmnote WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and lm_code='$lmname'")->row();
        //$lmNotehistnum = $this->session->userdata('lmNotehistnum');
        $lmNotehistnumCounted = count($maxnote_histno);
        $lmNotehistnum = $lmNotehistnumCounted + 1;
        $addnewlinelm['newnote'] = array(
            'lmNotecronnum' => $lmNotecronnum,
            'lmNotelinenum' => $lmNotelinenum,
            'lmNotehistnum' => $lmNotehistnum
        );

        //$lmNOtecron = $this->input->post('lmNOtecron');
        // $lmNotelinenum = $this->input->post('lmNotelinenum');
        //$lmNotehistnum = $this->input->post('lmNotehistnum');
//            $lmNOte = $this->input->post('lmNOte');
//             $w = $this->input->post('w');
//              $lmNOteDate = $this->input->post('lmNOteDate');
//               $lmname = $this->input->post('lmname'); 
//               $s = $this->input->post('s');
//                 $f = $this->input->post('f'); 
//                    $operation = 'E';
//            $userCd = 'M117';
//               $date_of_entry = date("Y-m-d");    


        $lmnoteDETAILS = $this->db->query("select * FROM  chitha_rmk_lmnote WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'")->row();
        $lm_code = $this->session->userdata('user_code');
        $lmname_dd = $this->db->query("select * FROM lm_code WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and lm_code='$lm_code'")->result();
        // $lmname_dd = $this->db->query("select * FROM lm_code WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and lm_code='$lmnoteDETAILS->lm_code'")->result(); 
        $addnewlinelm['lm_nme'] = $lmname_dd;


        //$this->load->view('LmEntryChithaView/addNewlinelmNote', $addnewlinelm);
        //$this->load->view('footer');
		$addnewlinelm['_view'] = 'LmEntryChithaView/addNewlinelmNote';
		$this->load->view('layouts/main',$addnewlinelm);
    }

    public function addlmnote() {
$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist');
        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $Dag_no = $this->session->userdata('dagnum');
        $lmNOte = $this->input->post('lmNOte');
        $lmNOtecron = $this->input->post('lmNOtecron');
        $lmNotelinenum = $this->input->post('lmNotelinenum');
        $lmNotehistnum = $this->input->post('lmNotehistnum');
        $w = $this->input->post('w');
       // $lmNOteDate = $this->input->post('lmNOteDate');
		 $lmNOteDate = date('Y-m-d',strtotime($this->input->post('lmNOteDate')));
		
        $lmname = $this->input->post('lmname');
        $s = $this->input->post('s');
        $f = $this->input->post('f');
        $operation = 'E';
        $userCd = $this->session->userdata('user_code');
        //$userCd = 'M117';
        $date_of_entry = date("Y-m-d");

        $this->db->query("INSERT INTO chitha_rmk_lmnote(
            dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, 
            vill_townprt_code, dag_no, lm_note_cron_no, rmk_type_hist_no, 
            lm_note_lno, lm_note, lm_note_date, lm_code, lm_sign, co_approval, 
            user_code, date_entry, operation) VALUES ('$dist_code','$subdiv_code','$cir_code','$mouza_code','$lot_no', 
            '$vill_code','$Dag_no','$lmNOtecron','$lmNotehistnum', 
            '$lmNotelinenum','$lmNOte','$lmNOteDate','$lmname','$s','$f', 
            '$userCd','$date_of_entry','$operation')");
//        echo "INSERT INTO chitha_rmk_lmnote(
//            dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, 
//            vill_townprt_code, dag_no, lm_note_cron_no, rmk_type_hist_no, 
//            lm_note_lno, lm_note, lm_note_date, lm_code, lm_sign, co_approval, 
//            user_code, date_entry, operation) VALUES ($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no, 
//            $vill_code,$Dag_no,$lmNOtecron,$lmNotehistnum, 
//            $lmNotelinenum,$lmNOte,$lmNOteDate,$lmname,$s,$f, 
//            $userCd,$date_of_entry,$operation)";
//        $this->db->query("UPDATE chitha_rmk_lmnote
//   SET  lm_note='$lmNOte', lm_note_date='$lmNOteDate', lm_code='$lmname', lm_sign='$s',co_approval='$f'
// WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and lm_note_cron_no='$lmNOtecron' and rmk_type_hist_no='$lmNotehistnum' and lm_note_lno='$lmNotelinenum'");
//    echo"UPDATE chitha_rmk_lmnote
//   SET  lm_note='$lmNOte', lm_note_date='$lmNOteDate', lm_code='$lmname', lm_sign='$s',co_approval='$f'
// WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and lm_note_cron_no='$lmNOtecron' and rmk_type_hist_no='$lmNotehistnum' and lm_note_lno='$lmNotelinenum'";  
//        
        redirect(base_url() . 'index.php/LmEntryChitha/nextLmselectOption');
    }

    public function addAlmnote() {
		$db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('header');

        $dist_code = $this->session->userdata('dist');
        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $Dag_no = $this->session->userdata('dagnum');
        $histnodetails = $this->db->query("select Max(rmk_type_hist_no) As rmk_type_hist_no from    chitha_rmk_gen WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'")->row();
        //echo "select Max(rmk_type_hist_no) As rmk_type_hist_no from    chitha_rmk_gen WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'";
        $histno = $histnodetails->rmk_type_hist_no;
        // echo  $histno;
        $hist_nxt = $histno + 1;


        $showhistno['Histslno'] = array(
            'histno_id' => $hist_nxt
        );

        $remarktype_dd = $this->db->query("select * from    chitha_rmk_gen AS RG INNER JOIN rmk_content_type RC ON RG.rmk_type_code=RC.type_code where RG.dist_code='$dist_code' and RG.subdiv_code = '$subdiv_code' and RG.cir_code='$cir_code' and RG.mouza_pargona_code = '$mouza_code' and RG.lot_no = '$lot_no' and RG.vill_townprt_code='$vill_code' and RG.dag_no='$Dag_no' ")->result();

        $showhistno['rmktype'] = $remarktype_dd;

        //$this->load->view('LmEntryChithaView/selectRemarktyp', $showhistno);
        //$this->load->view('footer');
		$showhistno['_view'] = 'LmEntryChithaView/selectRemarktyp';
		$this->load->view('layouts/main',$showhistno);
    }

    public function wantToenterlmnote() {
$db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('header');
        $dist_code = $this->session->userdata('dist');
        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $Dag_no = $this->session->userdata('dagnum');
        $histnumbr = $this->input->post('histnumbr');
        $rmktyp = $this->input->post('rmktyp');
        // $lmnoteDETAILS = $this->db->query("select * FROM chitha_rmk_lmnote WHERE dist_code='12' and subdiv_code = '01' and cir_code='06' and mouza_pargona_code = '01' and lot_no = '01' and vill_townprt_code='10001' and dag_no='119' and rmk_type_hist_no='$histnumbr'")->row();
        $lmnoteDETAILS = $this->db->query("select max(lm_note_cron_no) as lm_note_cron_no,max(lm_note_lno) as lm_note_lno  FROM chitha_rmk_lmnote WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'")->row();
        $lmnoteDETAILS_counted = count($lmnoteDETAILS);
        if ($lmnoteDETAILS_counted > '0') {

            $lmnoteCron_numbr = $lmnoteDETAILS->lm_note_cron_no;
            $lmnote_line_number = $lmnoteDETAILS->lm_note_lno;
            $lmnote_line_number_incr = ($lmnote_line_number + 1);
            $lmnoteCron_numb_incre = ($lmnoteCron_numbr + 1);
            $lminfos['newnote'] = array(
                'lmNotecronnum' => $lmnoteCron_numb_incre,
                'lmNotehistnum' => $histnumbr,
                'lmNotelinenum' => $lmnote_line_number_incr,
            );
        } else {
            $lminfos['newnote'] = array(
                'lmNotecronnum' => '1',
                'lmNotehistnum' => $histnumbr,
                'lmNotelinenum' => '1',
            );
        }
        $lm_code = $this->session->userdata('user_code');
        $lmname_dd = $this->db->query("select * FROM  lm_code WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and lm_code='$lm_code'")->result();
        // $lmname_dd = $this->db->query("select * FROM lm_code WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and lm_code='$lmnoteDETAILS->lm_code'")->result(); 
        $lminfos['lm_nme'] = $lmname_dd;
        //$this->load->view('LmEntryChithaView/addNewlinelmNote', $lminfos);
        //$this->load->view('footer');
		$lminfos['_view'] = 'LmEntryChithaView/addNewlinelmNote';
		$this->load->view('layouts/main',$lminfos);
    }

    public function Encrocherdetails() {
$db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('header');
        $dist_code = $this->session->userdata('dist');
        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $Dag_no = $this->session->userdata('dagnum');
        $EncroDETAILS = $this->db->query("select * FROM  chitha_rmk_encro WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'")->result();
        //$EncroDETAILS = $this->db->query("select * FROM chitha_rmk_encro WHERE dist_code='12' and subdiv_code = '01' and cir_code='06' and mouza_pargona_code = '01' and lot_no = '01' and vill_townprt_code='10001' and dag_no='119'")->result();
        $encroinfos['encrodetails'] = $EncroDETAILS;


        // $EncroDETAILS_dd = $this->db->query("select * FROM chitha_rmk_encro WHERE dist_code='12' and subdiv_code = '01' and cir_code='06' and mouza_pargona_code = '01' and lot_no = '01' and vill_townprt_code='10001' and dag_no='119'")->result();
        //  $encroinfos['encroID'] =     $EncroDETAILS_dd;


        //$this->load->view('LmEntryChithaView/selectEncroId', $encroinfos);
        //$this->load->view('footer');
		$encroinfos['_view'] = 'LmEntryChithaView/selectEncroId';
		$this->load->view('layouts/main',$encroinfos);
    }

    public function Editencroacher() {
		$db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('header');
        $dist_code = $this->session->userdata('dist');
        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $Dag_no = $this->session->userdata('dagnum');

        $encroidnme = $this->input->post('encroid');
        // echo $lmnote;

        $codeArr = explode("-", $encroidnme);

        $encroid = $codeArr[0];
        $encroname = $codeArr[1];


        $EncroDETAILS = $this->db->query("select * FROM  chitha_rmk_encro WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and encro_id='$encroid' and encro_name='$encroname'")->row();
        $encroinfos['encroguardian'] = $EncroDETAILS->encro_guardian;
        $encroinfos['bigha'] = $EncroDETAILS->encro_land_b;
        $encroinfos['katha'] = $EncroDETAILS->encro_land_k;
        $encroinfos['lesa'] = $EncroDETAILS->encro_land_lc;
        $encroinfos['hist_no'] = $EncroDETAILS->rmk_type_hist_no;
        $encroinfos['encro_addr'] = $EncroDETAILS->encro_add;
        $encroinfos['date'] = $EncroDETAILS->encro_evic_date;
		$encroinfos['encro_since'] = $EncroDETAILS->encro_since;
        $co_approval = $EncroDETAILS->co_approval;
        $class_code = $EncroDETAILS->encro_class_code;
        $encro_since = $EncroDETAILS->encro_since;
        $ganda = $EncroDETAILS->encro_land_g;
        $kara = $EncroDETAILS->encro_land_kr;
        $otherinfo = $EncroDETAILS->encro_other_info;
        $fine = $EncroDETAILS->encro_fine;
        $epr_no = $EncroDETAILS->epr_no;
        $coapproval = array(
            'co_approval' => $co_approval,
            'class_code' => $class_code,
            'encro_since' => $encro_since,
            'ganda' => $ganda,
            'kara' => $kara,
            'otherinfo' => $otherinfo,
            'fine' => $fine,
            'epr_no' => $epr_no
        );
        $this->session->set_userdata($coapproval);

        $encroinfos['name'] = $encroname;
        $encroinfos['encroid'] = $encroid;
        $landused = $this->db->query("select * FROM  encro_land_used_for WHERE code='$EncroDETAILS->encro_land_used_for'")->row();
        $encroinfos['landused'] = $landused->used_for;
        $encroinfos['cd'] = $landused->code;
        $landused_dd = $this->db->query("select * FROM  encro_land_used_for")->result();
        $encroinfos['landused_dd'] = $landused_dd;
        $encrorel = $this->db->query("select * FROM  master_guard_rel WHERE guard_rel='$EncroDETAILS->encro_guar_relation'")->row();
        $encroinfos['rel'] = $encrorel->guard_rel_desc_as;
        $encroinfos['relcode'] = $encrorel->guard_rel;
        $encrorel_dd = $this->db->query("select * FROM  master_guard_rel")->result();
        $encroinfos['relinfo'] = $encrorel_dd;

        $landNature = $this->db->query("select * FROM  ord_on_gl_type_code WHERE type_code='$EncroDETAILS->nature_land_code'")->row();
        $encroinfos['typeCd'] = $landNature->type_code;
        $encroinfos['type'] = $landNature->type;
        $land_Nature_dd = $this->db->query("select * FROM  ord_on_gl_type_code")->result();
        $encroinfos['landNatureinfo'] = $land_Nature_dd;

        //$this->load->view('LmEntryChithaView/editencrocherdetails', $encroinfos);
        //$this->load->view('footer');
		$encroinfos['_view'] = 'LmEntryChithaView/editencrocherdetails';
		$this->load->view('layouts/main',$encroinfos);
    }

    
        public function encromodify() {
			
			$db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('header');
        $dist_code = $this->session->userdata('dist');
        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $Dag_no = $this->session->userdata('dagnum');
        $co_approval = $this->session->userdata('co_approval');
       // $class_code = $this->session->userdata('class_code');
       // $encro_since = $this->session->userdata('encro_since');
        $ganda = $this->session->userdata('ganda');
        $kara = $this->session->userdata('kara');
        $otherinfo = $this->session->userdata('otherinfo');
        $fine = $this->session->userdata('fine');
        $epr_no = $this->session->userdata('epr_no');
        $encroid = $this->input->post('encroid');
        $encro_since = date('Y-m-d',strtotime($this->input->post('encroachersince')));
        $RmktypHistno = $this->input->post('RmktypHistno');
        
        $landusedfor = $this->input->post('landusedfor');
        $encroname = $this->input->post('encroacherName');
        $bigha = $this->input->post('bigha');
        $guardnme = $this->input->post('guardnme');
        $katha = $this->input->post('katha');
        $rel = $this->input->post('rel');
        $lesa = $this->input->post('lesa');
        $add = $this->input->post('add');
        $evi = $this->input->post('evi');
        $natureland = $this->input->post('natureland');
        $date =date('Y-m-d',strtotime($this->input->post('date'))); 

      //...  $cron_num_query = $this->db->query("select max(cron_no) AS cron from    change_chitha_rmk_encro")->row();
        //  var_dump($cron_num_query);
       //... $cron_num = $cron_num_query->cron;

        if (isset($_POST['modifyenco'])) {
            $operation = 'M';
            $userCd = $this->session->userdata('user_code');
            
            //$userCd = 'M117';
           //... $cron_no = $cron_num + 1;
            //         $cron_no_initial['cron'] =  $cron_no ;
            //               $this->session->set_userdata($cron_no);
            //     $this->session->userdata('cron');
            $date_of_entry = date("Y-m-d");
            //  echo  $date_of_entry;
            // $userCd =  $this->session->userdata('$lm_code');
            //echo $bigha.'<br>'.$watersrc_cd;


          //...  $cronno = array(
              //...  'crn' => $cron_no
           //... );

           //... $this->session->set_userdata($cronno);
           //... $cron_num = $this->session->userdata('crn');
//            $this->db->query("INSERT INTO change_chitha_rmk_encro(
//            dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, 
//            vill_townprt_code, dag_no, cron_no, rmk_type_hist_no, co_approval, 
//            encro_id, encro_name, encro_guardian, encro_guar_relation, encro_add, 
//            encro_class_code, nature_land_code, encro_since, encro_land_b, 
//            encro_land_k, encro_land_lc, encro_land_g, encro_land_kr, encro_land_used_for, 
//            encro_other_info, encro_fine, encro_evicted_yn, encro_evic_date, 
//            epr_no, user_code, date_entry, operation)
//    VALUES ('$dist_code','$subdiv_code','$cir_code','$mouza_code','$lot_no', 
//            '$vill_code','$Dag_no','$cron_no','$RmktypHistno','$co_approval', 
//            '$encroid','$encroname','$guardnme','$rel','$add', 
//            '$class_code','$natureland','$encro_since','$bigha', 
//            '$katha','$lesa','$ganda','$kara','$landusedfor', 
//            '$otherinfo','$fine','$evi','$date', 
//            '$epr_no','$userCd','$date_of_entry','$operation')");
            
            
          //...  $this->db->query("INSERT INTO change_chitha_rmk_encro( dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, dag_no,cron_no, rmk_type_hist_no, co_approval, encro_id, encro_since,encro_name, encro_guardian, encro_guar_relation, encro_add,  nature_land_code, encro_land_b, encro_land_k, encro_land_lc,encro_land_g, encro_land_used_for, encro_evicted_yn, encro_evic_date, user_code, date_entry, operation) 
  //...  VALUES ('$dist_code','$subdiv_code','$cir_code','$mouza_code','$lot_no','$vill_code','$Dag_no','$cron_no','$RmktypHistno','$co_approval','$encroid','$encro_since','$encroname','$guardnme','$rel','$add','$natureland','$bigha','$katha','$lesa','$ganda','$landusedfor','$evi','$date','$userCd','$date_of_entry','$operation')");
     
            

          //...  $sql = "select * from    change_chitha_rmk_encro where  dist_code='$dist_code' "
                   //... . "and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code'"
                    //.... " and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and encro_id='$encroid' and encro_name='$encroname'"
                   //... . " ORDER BY cron_no DESC LIMIT 1";

          //...  $ChangeRMKEncro = $this->db->query($sql)->row();
            // var_dump($ChangeRMKlmnote);
            //$this->db->query("insert into chitha_noncrop(dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,dag_no,noncrop_use_id,yn,type_of_used_noncrop,noncrop_land_area_b,noncrop_land_area_k,noncrop_land_area_lc,noncrop_land_area_g,noncrop_land_area_kr,user_code,date_entry,operation)values('$dist_code','$subdiv_code','$cir_code','$mouza_code','$lot_no','$vill_code','$Dag_no','$Changenoncrp->noncrop_use_id','$Changenoncrp->yn','$Changenoncrp->type_of_used_noncrop','$Changenoncrp->noncrop_land_area_b','$Changenoncrp->noncrop_land_area_k','$Changenoncrp->noncrop_land_area_lc','$Changenoncrp->noncrop_land_area_g','$Changenoncrp->noncrop_land_area_kr','$Changenoncrp->user_code','$Changenoncrp->date_entry','$Changenoncrp->operation')");       


            $this->db->query("update chitha_rmk_encro set  encro_since='$encro_since',encro_name='$encroname', encro_guardian='$guardnme', encro_guar_relation='$rel', 
       encro_add='$add', nature_land_code='$natureland',encro_land_b='$bigha', encro_land_k='$katha', encro_land_lc='$lesa',encro_land_used_for='$landusedfor', 
       encro_evicted_yn='$evi', encro_evic_date='$date' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and encro_id='$encroid'  and  rmk_type_hist_no='$RmktypHistno'");
            //echo "update chitha_rmk_lmnote set lm_note_cron_no='$ChangeRMKlmnote->lm_note_cron_no',rmk_type_hist_no='$ChangeRMKlmnote->rmk_type_hist_no',lm_note_lno='$ChangeRMKlmnote->lm_note_lno',lm_note='$ChangeRMKlmnote->lm_note',lm_note_date='$ChangeRMKlmnote->lm_note_date',lm_code='$ChangeRMKlmnote->lm_code',lm_sign='$ChangeRMKlmnote->lm_sign',co_approval='$ChangeRMKlmnote->co_approval',user_code='$ChangeRMKlmnote->user_code',date_entry='$ChangeRMKlmnote->date_entry',operation='$ChangeRMKlmnote->operation' where dist_code='12' and subdiv_code='01' and cir_code='06' and mouza_pargona_code='01' and lot_no='01' and vill_townprt_code='10002' and dag_no='39' and rmk_type_hist_no='$lmNotehistnum' and lm_note_lno='$lmNotelinenum'";
            //$EncroDETAILS = $this->db->query("select * FROM change_chitha_rmk_encro WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = 'lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and encro_id='$encroid' and encro_name='$encroname'")->row();
            $encroinfos['encroguardian'] = $guardnme;
            $encroinfos['bigha'] = $bigha;
            $encroinfos['katha'] = $katha;
            $encroinfos['lesa'] = $lesa;
            $encroinfos['hist_no'] = $RmktypHistno;
            $encroinfos['encro_addr'] = $add;
            $encroinfos['date'] = $date;
             $encroinfos['encro_since'] = $encro_since;
//        $co_approval = $EncroDETAILS->co_approval;
//        $class_code = $EncroDETAILS->encro_class_code;
//        $encro_since = $EncroDETAILS->encro_since;
//        $ganda = $EncroDETAILS->encro_land_g;
//        $kara = $EncroDETAILS->encro_land_kr;
//        $otherinfo = $EncroDETAILS->encro_other_info;
//        $fine = $EncroDETAILS->encro_fine;
//        $epr_no = $EncroDETAILS->epr_no;
            $encroinfos['name'] = $encroname;
            $encroinfos['encroid'] = $encroid;
            $encrodetail = array(
                'Ename' => $encroname,
                'Eid' => $encroid
            );

            $this->session->set_userdata($encrodetail);

            $landused = $this->db->query("select * FROM  encro_land_used_for WHERE code='$landusedfor'")->row();
            $encroinfos['landused'] = $landused->used_for;
            $encroinfos['cd'] = $landused->code;
            $landused_dd = $this->db->query("select * FROM  encro_land_used_for")->result();
            $encroinfos['landused_dd'] = $landused_dd;
            $encrorel = $this->db->query("select * FROM  master_guard_rel WHERE guard_rel='$rel'")->row();
            $encroinfos['rel'] = $encrorel->guard_rel_desc_as;
            $encroinfos['relcode'] = $encrorel->guard_rel;
            $encrorel_dd = $this->db->query("select * FROM  master_guard_rel")->result();
            $encroinfos['relinfo'] = $encrorel_dd;

            $landNature = $this->db->query("select * FROM  ord_on_gl_type_code WHERE type_code='$natureland'")->row();
            $encroinfos['typeCd'] = $landNature->type_code;
            $encroinfos['type'] = $landNature->type;
            $land_Nature_dd = $this->db->query("select * FROM  ord_on_gl_type_code")->result();
            $encroinfos['landNatureinfo'] = $land_Nature_dd;

            //$this->load->view('LmEntryChithaView/editencrocherdetails', $encroinfos);
            //$this->load->view('footer');
			$encroinfos['_view'] = 'LmEntryChithaView/editencrocherdetails';
			$this->load->view('layouts/main',$encroinfos);
        } 
        
        //...else {
            //...$this->session->unset_userdata('crn');
       //... }
        
        // $this->menuforSelectingOption();
    }

// 
//    public function savEncro(){
//        
//     
//        $dist_code = $this->session->userdata('dist');
//        //echo $dist_code;
//        $subdiv_code = $this->session->userdata('sub_div');
//        $cir_code = $this->session->userdata('cir_code');
//        $mouza_code = $this->session->userdata('mouza_code');
//        $lot_no = $this->session->userdata('lot_no');
//        $vill_code = $this->session->userdata('vill_code');
//        $Dag_no = $this->session->userdata('dagnum'); 
//         $encroname = $this->session->userdata('Ename'); 
//         $encroid = $this->session->userdata('Eid');
//           // $encroid = $this->input->post('encroid'); 
//                 // $encroname = $this->input->post('encroacherName');
//              $sql="select * from    change_chitha_rmk_encro where  dist_code='$dist_code' "
//                 . "and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code'"
//                 . " and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and encro_id='$encroid' and encro_name='$encroname'"
//                . " ORDER BY cron_no DESC LIMIT 1";
//        
//         $ChangeRMKEncro = $this->db->query($sql)->row();
//        // var_dump($ChangeRMKlmnote);
//           //$this->db->query("insert into chitha_noncrop(dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,dag_no,noncrop_use_id,yn,type_of_used_noncrop,noncrop_land_area_b,noncrop_land_area_k,noncrop_land_area_lc,noncrop_land_area_g,noncrop_land_area_kr,user_code,date_entry,operation)values('$dist_code','$subdiv_code','$cir_code','$mouza_code','$lot_no','$vill_code','$Dag_no','$Changenoncrp->noncrop_use_id','$Changenoncrp->yn','$Changenoncrp->type_of_used_noncrop','$Changenoncrp->noncrop_land_area_b','$Changenoncrp->noncrop_land_area_k','$Changenoncrp->noncrop_land_area_lc','$Changenoncrp->noncrop_land_area_g','$Changenoncrp->noncrop_land_area_kr','$Changenoncrp->user_code','$Changenoncrp->date_entry','$Changenoncrp->operation')");       
//          
//            
//     $this->db->query("update chitha_rmk_encro set rmk_type_hist_no='$ChangeRMKEncro->rmk_type_hist_no', 
//       co_approval='$ChangeRMKEncro->co_approval', encro_id='$ChangeRMKEncro->encro_id', encro_name='$ChangeRMKEncro->encro_name', encro_guardian='$ChangeRMKEncro->encro_guardian', encro_guar_relation='$ChangeRMKEncro->encro_guar_relation', 
//       encro_add='$ChangeRMKEncro->encro_add', encro_class_code='$ChangeRMKEncro->encro_class_code', nature_land_code='$ChangeRMKEncro->nature_land_code', encro_since='$ChangeRMKEncro->encro_since', 
//       encro_land_b='$ChangeRMKEncro->encro_land_b', encro_land_k='$ChangeRMKEncro->encro_land_k', encro_land_lc='$ChangeRMKEncro->encro_land_lc', encro_land_g='$ChangeRMKEncro->encro_land_g', 
//       encro_land_kr='$ChangeRMKEncro->encro_land_kr', encro_land_used_for='$ChangeRMKEncro->encro_land_used_for', encro_other_info='$ChangeRMKEncro->encro_other_info', encro_fine='$ChangeRMKEncro->encro_fine', 
//       encro_evicted_yn='$ChangeRMKEncro->encro_evicted_yn', encro_evic_date='$ChangeRMKEncro->encro_evic_date', epr_no='$ChangeRMKEncro->epr_no', user_code='$ChangeRMKEncro->user_code', 
//       date_entry='$ChangeRMKEncro->date_entry', operation='$ChangeRMKEncro->operation' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and encro_id='$encroid' and encro_name='$encroname'");   
//   //echo "update chitha_rmk_lmnote set lm_note_cron_no='$ChangeRMKlmnote->lm_note_cron_no',rmk_type_hist_no='$ChangeRMKlmnote->rmk_type_hist_no',lm_note_lno='$ChangeRMKlmnote->lm_note_lno',lm_note='$ChangeRMKlmnote->lm_note',lm_note_date='$ChangeRMKlmnote->lm_note_date',lm_code='$ChangeRMKlmnote->lm_code',lm_sign='$ChangeRMKlmnote->lm_sign',co_approval='$ChangeRMKlmnote->co_approval',user_code='$ChangeRMKlmnote->user_code',date_entry='$ChangeRMKlmnote->date_entry',operation='$ChangeRMKlmnote->operation' where dist_code='12' and subdiv_code='01' and cir_code='06' and mouza_pargona_code='01' and lot_no='01' and vill_townprt_code='10002' and dag_no='39' and rmk_type_hist_no='$lmNotehistnum' and lm_note_lno='$lmNotelinenum'";
//     
//        
//        
//    }
    public function addEncro() {
		$db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('header');

        $dist_code = $this->session->userdata('dist');
        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $Dag_no = $this->session->userdata('dagnum');
        $histnodetails = $this->db->query("select Max(rmk_type_hist_no) As rmk_type_hist_no from    chitha_rmk_gen WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'")->row();
        // echo "select Max(rmk_type_hist_no) As rmk_type_hist_no from    chitha_rmk_gen WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no'";  

        $histno = $histnodetails->rmk_type_hist_no;

        $hist_nxt = $histno + 1;


        $showhistno['Histslno'] = array(
            'histno_id' => $hist_nxt
        );

        $histnosession = array(
            'histno_id' => $hist_nxt
        );
        $this->session->set_userdata($histnosession);


        $remarktype_dd = $this->db->query("select * from    chitha_rmk_gen AS RG INNER JOIN rmk_content_type RC ON RG.rmk_type_code=RC.type_code where RG.dist_code='$dist_code' and RG.subdiv_code = '$subdiv_code' and RG.cir_code='$cir_code' and RG.mouza_pargona_code = '$mouza_code' and RG.lot_no = '$lot_no' and RG.vill_townprt_code='$vill_code' and RG.dag_no='$Dag_no' ")->result();

        $showhistno['rmktype'] = $remarktype_dd;

        //$this->load->view('LmEntryChithaView/selectRemarktypEncro', $showhistno);
        //$this->load->view('footer');
		$showhistno['_view'] = 'LmEntryChithaView/selectRemarktypEncro';
		$this->load->view('layouts/main',$showhistno);
    }

    public function wantToenterEncrodetails() {
		$db=  $this->session->userdata('db');
        // $this->load->helper('html');
        // $this->load->view('header');
        $dist_code = $this->session->userdata('dist');
        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $Dag_no = $this->session->userdata('dagnum');
        $histnumbr = $this->input->post('histnumbr');
        $rmktyp = $this->input->post('rmktyp');

        $encroinfos['hist_no'] = $histnumbr;
        $EncroDETAILS = $this->db->query("select * FROM  chitha_rmk_encro WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and rmk_type_hist_no='$histnumbr'")->row();
        $result = count($EncroDETAILS);
        if ($result <= '0') {
            $relation = '';
        } else {
            $relation = $EncroDETAILS->encro_guar_relation;
        }
//      echo "select * FROM chitha_rmk_encro WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and rmk_type_hist_no='$histnumbr'";
        $EncroDETAILS1 = $this->db->query("select max(encro_id) AS encro_id FROM  chitha_rmk_encro WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and dag_no='$Dag_no' and rmk_type_hist_no='$histnumbr'")->row();
        $encroinfos['encroid'] = $EncroDETAILS1->encro_id;
		 $encroinfos['encroid'] = ($EncroDETAILS1->encro_id + 1);
        if ($EncroDETAILS1->encro_id == "") {
            $encroinfos['encroid'] = ($EncroDETAILS1->encro_id + 1);
        }

//      $co_approval = $EncroDETAILS->co_approval;
//        $class_code = $EncroDETAILS->encro_class_code;
//        $encro_since = $EncroDETAILS->encro_since;
//        $ganda = $EncroDETAILS->encro_land_g;
//        $kara = $EncroDETAILS->encro_land_kr;
//        $otherinfo = $EncroDETAILS->encro_other_info;
//        $fine = $EncroDETAILS->encro_fine;
//        $epr_no = $EncroDETAILS->epr_no;
//        $coapproval=array(
//            'co_approval' => $co_approval,
//            'class_code' => $class_code,
//            'encro_since' => $encro_since,
//            'ganda' => $ganda,
//            'kara' => $kara,
//            'otherinfo' => $otherinfo,
//            'fine' => $fine,
//            'epr_no' => $epr_no
//        );
//                  $this->session->set_userdata($coapproval); 

        $landused_dd = $this->db->query("select * FROM encro_land_used_for")->result();
        $encroinfos['landused_dd'] = $landused_dd;
        $encrorel = $this->db->query("select * FROM  master_guard_rel WHERE guard_rel='$relation'")->row();
        $encroinfos['rel'] = $encrorel->guard_rel_desc_as;
        $encroinfos['relcode'] = $encrorel->guard_rel;
        $encrorel_dd = $this->db->query("select * FROM  master_guard_rel")->result();
        $encroinfos['relinfo'] = $encrorel_dd;


        $land_Nature_dd = $this->db->query("select * FROM  ord_on_gl_type_code")->result();
        $encroinfos['landNatureinfo'] = $land_Nature_dd;


        //$this->load->view('LmEntryChithaView/enterEncrodetails', $encroinfos);
        //$this->load->view('footer');
		$encroinfos['_view'] = 'LmEntryChithaView/enterEncrodetails';
		$this->load->view('layouts/main',$encroinfos);
    }

     public function encroinsert() {
$db=  $this->session->userdata('db');
 
        $dist_code = $this->session->userdata('dist');
        $subdiv_code = $this->session->userdata('sub_div');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $Dag_no = $this->session->userdata('dagnum');
        $encroid = $this->input->post('encroid');
         //$encro_since = $this->input->post('encroachersince');
		 $encro_since = date('Y-m-d',strtotime($this->input->post('encroachersince')));
        $RmktypHistno = $this->input->post('RmktypHistno');
        $landusedfor = $this->input->post('landusedfor');
        $encroacherName = $this->input->post('encroacherName');
        $bigha = $this->input->post('bigha');
        $guardnme = $this->input->post('guardnme');
        $katha = $this->input->post('katha');
        $rel = $this->input->post('rel');
        $lesa = $this->input->post('lesa');
        $add = $this->input->post('add');
        $evi = $this->input->post('evi');
        $natureland = $this->input->post('natureland');
       
        $co_approval = $this->session->userdata('co_approval');
        //echo $co_approval;
        $class_code = $this->session->userdata('class_code');
       // $encro_since = $this->session->userdata('encro_since');
        //echo  $encro_since;
        $ganda = '0';
        $kara = $this->session->userdata('kara');
        $otherinfo = $this->session->userdata('otherinfo');
        $fine = $this->session->userdata('fine');
        $epr_no = $this->session->userdata('epr_no');
        // echo $RmktypHistno;
        // $hist_nxt = $RmktypHistno + 1;
        $operation = 'M';
        $userCd = $this->session->userdata('user_code');
        //$userCd = 'M117';
        date_default_timezone_set("Asia/Kolkata");
        $date1 = $this->input->post('date');
        $date = date('Y-m-d', strtotime($date1));

        $date_of_entry123 = date("Y-m-d");
     
            $this->db->query("INSERT INTO chitha_rmk_encro( dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, dag_no, rmk_type_hist_no, co_approval, encro_id, encro_since, encro_name, encro_guardian, encro_guar_relation, encro_add,  nature_land_code, encro_land_b, encro_land_k, encro_land_lc,encro_land_g, encro_land_used_for, encro_evicted_yn, encro_evic_date, user_code, date_entry, operation) 
    VALUES ('$dist_code','$subdiv_code','$cir_code','$mouza_code','$lot_no','$vill_code','$Dag_no','$RmktypHistno','$co_approval','$encroid','$encro_since','$encroacherName','$guardnme','$rel','$add','$natureland','$bigha','$katha','$lesa','$ganda','$landusedfor','$evi','$date','$userCd','$date_of_entry123','$operation')");
     
	 //echo "data inserted";
	 // echo "<script>"; echo "  alert('Data inserted Successfully ')"; echo"</script>";
	   redirect(base_url() . 'index.php/LmEntryChitha/nextLmselectOption');
	 
            echo "<script>"; echo "  alert('Data inserted Successfully ')"; echo"</script>";
			 // exit;
          // $this->wantToenterEncrodetails();
    } 


}

?>                                                    