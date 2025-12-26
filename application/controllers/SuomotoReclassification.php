    <?php
    class SuomotoReclassification extends CI_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->model('mutation/mutationmodel');
            $this->load->model('conversion/ASTofficeConversionModel');
            $this->load->model('conversion/COofficeConversionModel');
            $this->load->model('UtilsModel');
            $this->load->model('rtps/rtpsmodel');
            $this->load->helper(array('form', 'url'));
            $this->load->model('Suomotoreclass/SuomotoReclassModel');
            
            $this->load->model('basundhara/basundharamodel');
            $this->load->helper('file');
            $this->load->helper('download');
            $this->load->library('upload');
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


        public function LMlocationSelect() {
           
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');

            $user_code = $this->session->userdata('user_code');
            $this->session->set_userdata(array('end' => false));

            $data = $this->mutationmodel->getVillageCodeJSON($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
            $district['villages'] = $data;

            $district['base']= $this->config->item('base_url');

            $district['user'] = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code);

            //code for generating village uuid------------
            //$village_uuid = $this->utilityclass->getVillageUUID($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

            //code for generating zonal value--------------
           // $district['zonalValueOfDag'] = $this->utilityclass->getZonalValue($dist_code, $village_uuid, $dagapply->dag_no);

            $district['_view'] = 'SuomotoReclassification/SuomotolocationSelect';
            $this->load->view('layouts/main',$district);
        }



        function suomotoreclassPost(){

        $year_no = year_no;
        $lm_report1 = $this->input->POST('remark');
        $lm_report_suffix = $this->input->POST('remark_suffix');
        $lm_report = $lm_report1." - ".$lm_report_suffix;
        //var_dump($data);

        $dist_code = $this->input->POST('dist_code');
        $subdiv_code = $this->input->POST('subdiv_code');
        $cir_code = $this->input->POST('cir_code');
        $mouza_pargona_code = $this->input->POST('mouza_pargona_code');
        $lot_no = $this->input->POST('lot_no');
        $village_code = $this->input->POST('vill_townprt_code');

        $dag_no_int=$this->input->post('dag_no');


        $dag_area_b =$this->input->post('dag_area_b');
        $dag_area_k =$this->input->post('dag_area_k');
        $dag_area_lc =$this->input->post('dag_area_lc');
        $dag_area_g =$this->input->post('dag_area_g');

        $part_area_b = $this->input->post('part_bigha')==null?null:$this->input->post('part_bigha');
        $part_area_k = $this->input->post('part_katha')==null?null:$this->input->post('part_katha');
        $part_area_lc = $this->input->post('part_lessa')==null?null:$this->input->post('part_lessa');
        $part_area_g = $this->input->post('part_area_g')==null?null:$this->input->post('part_area_g');

        // var_dump($part_area_b);
        // exit;


        $land_code =$this->input->post('land_code');
        $land_type_present =$this->input->post('land_type_present');
        $P_land_rev =$this->input->post('P_land_rev');
        $p_local_tax =$this->input->post('p_local_tax');

        $is_ten = $this->input->post('is_ten');
        $is_part = $this->input->post('is_part');

        $sql=$this->db->query("select dag_no,patta_no,patta_type_code from chitha_basic where  "
      . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and  cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_No='$lot_no' "
      . "and vill_townprt_code='$village_code' and dag_no_int='$dag_no_int' ")->result();

        $dag_no=$sql[0]->dag_no;
        $patta_no=$sql[0]->patta_no;
        $patta_type_code=$sql[0]->patta_type_code;

        $pdars=$this->input->post('pdarname');
        $pdar_father=$this->input->post('pdarfname');
        $dpdarid=$this->input->post('chk_deleted_pattadar');
        //var_dump(count($dpdarid).'vvvv'.count($pdars));

        //var_dump($dpdarid);exit;

        foreach($pdars as $p){
            $pdarid=explode('__',$p);
            $pdar_id = $pdarid[0];
            $pdar_name= $pdarid[1];
            $pdar_father= $pdarid[2];
        }

        //var_dump($pdar_father);
       // exit;

        if(!empty($dpdarid)){
            

            if(count($dpdarid)==count($pdars)){
                // echo "<script>
                // alert('All pattdars can not be selected!!')
                // </script>";

                $this->session->set_flashdata('message',"All pattdars can not be selected for partial area partition!! ");

                redirect(base_url() . "index.php/SuomotoReclassification/LMlocationSelect");
            }
        }



        if(in_array($dist_code, json_decode(BARAK_VALLEY))){
            $dag_area_g = $dag_area_g==null?"0":$dag_area_g;
        }
        else{
            $dag_area_g = 0;
        }
        $this->db->trans_begin();
        $case_name=$this->rtpsmodel->genearteCaseName();
        if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Session time out. Please try Again"
            );
            echo json_encode($data);
            exit;
            die();
        }
        

        $seq_pet=year_no.'0';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteReclassPetitionNo();
        $case_no['case_no']=$case_name.$petition_no."/SU-RECL";

        $basic = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $village_code,
            'proposal_no' => $case_no['petition_no'],
            'dag_no' => $dag_no,
            'patta_no' => $patta_no,
            'patta_type_code' => $patta_type_code,
            'exist_land_class' => $land_code,
            'present_land_class' =>$land_type_present,
            'present_land_revenue' => 0,
            'present_land_localtax' => 0,
            'present_total_revenue' => 0,
            'new_landuse_year' => '',
            'dag_area_b' => $dag_area_b,
            'dag_area_k' => $dag_area_k,
            'dag_area_lc' => $dag_area_lc,
            'dag_area_g' => $dag_area_g,
            'dag_area_kr' => 0,

            'part_area_b' => $part_area_b,
            'part_area_k' => $part_area_k,
            'part_area_lc'=> $part_area_lc,
            'part_area_g' => $part_area_g,
            'part_area_kr'=> 0,

            'status' =>'C',

            
            //'proposed_land_class' => $data['firstParty'][0]->new_classification,
            'proposed_land_revenue' => $P_land_rev,
            'proposed_land_localtax' => $p_local_tax,
            //'revenue_diff' => $this->input->post('Rev_diff'),
            'lm_code' => $this->session->userdata('user_code'),
            'lm_yn' => 'Y',
            'lm_date' => date('Y-m-d G:i:s'),
            'case_no' => $case_no['case_no'],
            'year_no' => $year_no,
            //'self_declaration' => $dec,
            //'auth_type' => $auth_type,
            //'id_ref_no'=> $id_ref_no,
           // 'photo'=> $photo,
            //'pdar_id' => $chitha_pdar_id,
            'is_ten' => $is_ten,
            'is_part' => $is_part

        );

        $insTReclass = $this->db->insert('suomoto_reclass',$basic);
        //echo $this->db->last_query();
        if($insTReclass != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRRECLASS001: Insertion failed in suomoto_reclass for RTPS Case No '.$case_no['case_no']);
            $data = array(
                'error'=>"#ERRRECLASS001: Registration of Suomoto Reclassification failed for case no : ".$case_no['case_no']
            );
            echo json_encode($data);
            return false;
        }


        if($is_part=='Y'){

            if(!empty($dpdarid)){

            if(count($dpdarid)!=count($pdars)){

            foreach($dpdarid as $p){
            $pdarid=explode('__',$p);
            $pdar_id = $pdarid[0];
            $pdar_name= $pdarid[1];
            $pdar_father= $pdarid[2];


            $part_pattadar = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $village_code,
            'year_no' => date('Y'),
            'petition_no' => $case_no['petition_no'],
            'dag_no' => $dag_no,
            'patta_no' => $patta_no,
            'patta_type_code' => $patta_type_code,
            'pdar_id'=>$pdar_id,
            'pdar_cron_no' => 0,
            'pdar_name' => $pdar_name,
            'pdar_guardian'=>$pdar_father,
            'user_code'=> $this->session->userdata('user_code'),
            'date_entry' =>date('Y-m-d G:i:s'),
            'case_no' => $case_no['case_no'],

        );

        $insTPReclass = $this->db->insert('suomoto_part_pattadar',$part_pattadar);
        //echo $this->db->last_query();
        if($insTPReclass != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRRECLASS001: Insertion failed in suomoto_part_pattadar for RTPS Case No '.$case_no['case_no']);
            $data = array(
                'error'=>"#ERRRECLASS001: Registration of Suomoto Reclassification failed for case no : ".$case_no['case_no']
            );
            echo json_encode($data);
            return false;
        }
        }  
    }

            }

            else{

            foreach($pdars as $p){
            $pdarid=explode('__',$p);
            $pdar_id = $pdarid[0];
            $pdar_name= $pdarid[1];
            $pdar_father= $pdarid[2];


            $part_pattadar = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $village_code,
            'year_no' => date('Y'),
            'petition_no' => $case_no['petition_no'],
            'dag_no' => $dag_no,
            'patta_no' => $patta_no,
            'patta_type_code' => $patta_type_code,
            'pdar_id'=>$pdar_id,
            'pdar_cron_no' => 0,
            'pdar_name' => $pdar_name,
            'pdar_guardian'=>$pdar_father,
            'user_code'=> $this->session->userdata('user_code'),
            'date_entry' =>date('Y-m-d G:i:s'),
            'case_no' => $case_no['case_no'],

        );

        $insTPReclass = $this->db->insert('suomoto_part_pattadar',$part_pattadar);
        //echo $this->db->last_query();
        if($insTPReclass != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRRECLASS001: Insertion failed in suomoto_part_pattadar for RTPS Case No '.$case_no['case_no']);
            $data = array(
                'error'=>"#ERRRECLASS001: Registration of Suomoto Reclassification failed for case no : ".$case_no['case_no']
            );
            echo json_encode($data);
            return false;
        }
        }
        }


        }

        $notified_id=0;
        foreach($pdars as $p){

            $pdarid=explode('__',$p);
            $pdar_id = $pdarid[0];
            $pdar_name= $pdarid[1];
            $pdar_father= $pdarid[2];

            $suomoto_notified = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $village_code,
            'year_no' => year_no,
            'petition_no' => $case_no['petition_no'],
            'notified_id' => $notified_id++,
            'notified_name' => $pdar_name,
            // 'add1' => 'y',
            // 'add2' => 'z',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d G:i:s'),
            'operation' => 'E',
            'year_no' =>date('Y'),
            'case_no' => $case_no['case_no']

        );

        $insTNReclass = $this->db->insert('suomoto_notified',$suomoto_notified);
        //echo $this->db->last_query();
        if($insTNReclass != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRRECLASS001: Insertion failed in suomoto_notified for RTPS Case No '.$case_no['case_no']);
            $data = array(
                'error'=>"#ERRRECLASS001: Registration of Suomoto Reclassification failed for case no : ".$case_no['case_no']
            );
            echo json_encode($data);
            return false;
        }

        }
        

        
        
        $proID=$this->rtpsmodel->maxProceedingID($case_no['case_no']);
        $pro_array=array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'case_no'=>$case_no['case_no'],
            'proceeding_id'=>$proID,
            'status'=>'pending',
            'date_of_hearing'=>date('Y-m-d'),
            'co_order'=>$lm_report,
            'user_code'=>$this->session->userdata('user_code'),
            'date_entry'=>date('Y-m-d G:i:s'),
            'operation'=>'E',
            'ip' => $_SERVER['REMOTE_ADDR']
            );
        $insProceedRECLASS = $this->db->insert('petition_proceeding_dc_adc',$pro_array);
        if($insProceedRECLASS != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRRECLASS003: Insertion failed in petition_proceeding_dc_adc for RTPS Case No '.$case_no['case_no']);
            $data = array(
                'error'=>"#ERRRECLASS003: Registration of Reclassification failed for case no : ".$case_no['case_no']
            );
            echo json_encode($data);
            return false;
        }


        //////////////////////////////////
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            $data=array(
                'error'=>"Error in submitting. Please try Again"
            );
        }else
        {
            $this->db->trans_commit();
            //////////////POST To rtps/////////////////////

            $case_no=base64_encode($case_no['case_no']);

            redirect('SuomotoReclassification/downloadAcknowledgement/'.$case_no);
            
           // $this->DashboardReclass($case_no['case_no']);
            // $this->session->set_flashdata('message',"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no] ");
            // //////////////////////////////////
            // $data=array(
            //     'success'=>"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no]",
            //     'redirect_url'=>base_url().'index.php/home'
            // );
        }
        //echo json_encode($data);
    }



        public function LMConvertionType() {

            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $cir_code = $this->input->post('circle_code');
            $lot_no = $this->input->post('lot_no');
            $vill_code = $this->input->post('vill_code');
            $mouza_pargona_code = $this->input->post('mouza_code');

            $this->session->set_userdata(array('dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'lot_no' => $lot_no,
                'vill_code' => $vill_code,
                'mouza_pargona_code' => $mouza_pargona_code));


            $land_class_agri = "Select * from landclass_code where class_code_cat = '01'";
            $convertion['land_class_agri'] = $this->db->query($land_class_agri)->result();
            
            $land_class_non_agri = "Select * from landclass_code where class_code_cat = '02'";
            $convertion['land_class_non_agri'] = $this->db->query($land_class_non_agri)->result();

            $convertion['type'] = $this->mutationmodel->getConvertionPattaType();
            // $this->load->view('../views/header');
            // $this->load->view('../views/LandReclassification/LMlandclassregister', $convertion);
            // $this->load->view('../views/footer');
            $convertion['_view'] = 'SuomotoReclassification/LMlandclassregister';
            $this->load->view('layouts/main',$convertion);
        }

        public function getDagDetJSON($dag_no) {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_code = $this->session->userdata('vill_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');

            $data = $this->db->query("select * from chitha_basic join landclass_code on landclass_code.class_code=chitha_basic.land_class_code where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_code' and dag_no='$dag_no' and landclass_code.class_code_cat='02'");
            $landarea = $data->result();

            echo json_encode($landarea, JSON_UNESCAPED_UNICODE);
        }
        
        public function getDagDetJSONForBacklog($dag_no, $mouzaselect, $lotselect, $villageselect) {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');

            $data = $this->db->query("select * from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code = '$mouzaselect' and lot_no = '$lotselect' and vill_townprt_code = '$villageselect' and dag_no='$dag_no'");
            $landarea = $data->result();

            echo json_encode($landarea, JSON_UNESCAPED_UNICODE);
        }

        public function getPattaNameJSON($patta_code) {
            $data1 = $this->db->query("select * from patta_code where type_code = '$patta_code'");
            $data = $data1->result();
            $json = array();
            foreach ($data as $object) {
                $json[] = array('type_code' => $object->type_code, 'patta_type' => $object->patta_type);
            }
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
        }

        public function getLandClassNameJSON($land_class_code) {
            $data2 = $this->db->query("select * from landclass_code where class_code = '$land_class_code'");
            $data = $data2->result();
            $json1 = array();
            foreach ($data as $object) {
                $json1[] = array('class_code' => $object->class_code, 'land_type' => $object->land_type);
            }
            echo json_encode($json1, JSON_UNESCAPED_UNICODE);
        }

        public function saveReclasificationDetails() {
            $this->db->trans_begin();

            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_code = $this->session->userdata('vill_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $year_no = year_no;
            $define_date = define_date;
            $case_name=$this->basundharamodel->genearteCaseName();
           // $case_no['petition_no']=$petition_no=$this->basundharamodel->genearteReclassPetitionNo();
           // $case_no=$case_name.$petition_no."/RECLASS";


            $seq_pet=year_no.'0';
            $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteReclassPetitionNo();
            $case_no['case_no']=$case_no=$case_name.$petition_no."/RECLASS";
            
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
                'lm_code' => $this->session->userdata('user_code'),
                'lm_yn' => 'Y',
                'lm_date' => date('Y-m-d G:i:s'),
                'case_no' => $case_no,
                'year_no' => $year_no
            );
            //var_dump($t_reclassification);
            $this->db->insert('t_reclassification', $t_reclassification);

            $data['case_no'] = $case_no;

              
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo "Error Occured";
            } else {
                $this->db->trans_commit();
                $this->Dashboard($case_no);
                $data['_view'] = 'LandReclassification/test_first';
                $this->load->view('layouts/main',$data);
            }
        }
        
        public function getLandClassNameAgriJSON($land_class_code) {
            $data2 = $this->db->query("select * from landclass_code where class_code = '$land_class_code'");
            $data = $data2->result();
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }

        public function GoToRE() {
            $process = $this->input->get('pro');
             $user_desig = $this->session->userdata('user_desig_code');
            $user_code = $this->session->userdata('user_code');
            if ($process == '1') {
                $config['total_rows'] = $this->SuomotoReclassModel->countPendingLandReclassificationProposals();
                $cases['cases'] = $this->SuomotoReclassModel->getPendingLandReclassificationProposals()->result();
            } elseif ($process == '2') {
                $config['total_rows'] = $this->COofficeConversionModel->countGenerateTransmissionForDC();
                $cases['cases'] = $this->COofficeConversionModel->getPendingGenerateTransmissionForDC()->result();
            } elseif (($process == '3')&&($user_desig !='DC')) {
                $config['total_rows'] = $this->SuomotoReclassModel->countPendingLandReclassificationDC();
                $cases['cases'] = $this->SuomotoReclassModel->getPendingSuomotoReclassificationADC()->result();
            } 
            elseif (($process=='3')&&($user_desig =='DC')) {
            
                $config['total_rows'] = $this->SuomotoReclassModel->countPendingLandReclassificationDC();
                $cases['cases'] = $this->SuomotoReclassModel->getPendingSuomotoReclassificationDC()->result();
            }
            elseif ($process == '4') {
                $config['total_rows'] = $this->COofficeConversionModel->countApprovedLandReclassification();
                $cases['cases'] = $this->COofficeConversionModel->getApprovedLandReclassification()->result();
            } elseif ($process == '5') {
                $config['total_rows'] = $this->COofficeConversionModel->countGenerateTransmissionForCO();
                $cases['cases'] = $this->COofficeConversionModel->getPendingGenerateTransmissionForCO()->result();
            } elseif ($process == '6') {
                $config['total_rows'] = $this->COofficeConversionModel->countRevertedBackFromDC();
                $cases['cases'] = $this->COofficeConversionModel->getPendingRevertedBackFromDC()->result();
            } elseif ($process == '7') {
                $config['total_rows'] = $this->COofficeConversionModel->countJamaupdatereclass();
                $cases['cases'] = $this->COofficeConversionModel->getJamaupdatereclass()->result();
            } elseif ($process == '8') {
                $config['total_rows'] = $this->COofficeConversionModel->countRevertedPending();
                $cases['cases'] = $this->COofficeConversionModel->getRevertedPending()->result();
            }
            
             elseif ($process == '10') {
                 //echo "hello";
                $config['total_rows'] = $this->COofficeConversionModel->countRejectedCasesfromADC();
                $cases['cases'] = $this->COofficeConversionModel->getRejectedCasesfromADC()->result();
            }

             elseif ($process == '11') {
                $config['total_rows'] = $this->COofficeConversionModel->countRevertedBackFromDC();
                $cases['cases'] = $this->COofficeConversionModel->getPendingRevertedBackFromCO()->result();
            }
            $cases['process'] = $process;
            $cases['_view'] = 'SuomotoReclassification/Land_reclasification_cases';
            $this->load->view('layouts/main',$cases);
        }
        Public function FirstCoProcess() {
            $user_code = $this->session->userdata('user_code');
            $case_no = $this->input->GET('case_no');
            // $application_no=$this->input->GET('application_no');
            $proposal_no = $this->input->GET('proposal_no');
            $q = "select * from suomoto_reclass where case_no = '$case_no' and proposal_no = '$proposal_no' ";
            $details = $this->db->query($q)->row();
            // echo $this->db->last_query();

            // exit;
            
            $old_patta = $this->db->query("select * from patta_code where type_code = '$details->patta_type_code' ")->row();
            //$old_land_class = $this->db->query("select * from landclass_code where class_code = '$details->present_land_class' ")->row();
            //$proposed_land_class = $this->db->query("select * from landclass_code where class_code = '$details->proposed_land_class' ")->row();

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
                'co_name' => $co->username,
                'user_code' => $user_code
            ); 
            
            // $data['det'] = array(
            //     'patta_type' => $old_patta->patta_type,
            //     'old_land_class' => $old_land_class->land_type,
            //     'proposed_land_class' => $proposed_land_class->land_type,
            //     'proposed_land_class_code' => $details->proposed_land_class
            // );
            
            $all_land_class = "Select * from landclass_code";
            $data['land_class'] = $this->db->query($all_land_class)->result();

            $data['Pcases'] = $details;

            $lmnote="select * from petition_proceeding_dc_adc where case_no='$case_no' and user_code like 'M%' order by proceeding_id desc";
            $data['lmrmk']= $this->db->query($lmnote)->row();
            $data['sup_doc']=null;
            $data['sup_doc']=$this->db->query("SELECT * FROM supportive_document WHERE case_no=?", array($case_no))->result();

            $sql3="Select string_agg(pdar_name,', ') as pdar from suomoto_part_pattadar where case_no=? and dist_code=?";
            $data['part_pattadar']=$this->db->query($sql3,array($case_no,$details->dist_code))->result();

            $data['_view'] = 'SuomotoReclassification/FirstCoProcesssuomoto';
            $this->load->view('layouts/main',$data);
        }


        public function coProceeding() {

            $this->db->trans_begin();
            $proposal_no = $this->input->POST('proposal_no');
            $case_no = $this->input->POST('case_no');
            $co_report1 = $this->input->POST('remark');
            $co_report_suffix = $this->input->POST('remark_suffix');
            $co_report = $co_report1." - ".$co_report_suffix;

            $co_code = $this->session->userdata('user_code');
            $co_sign = 'Y';
            $co_date_entry = date('Y-m-d G:i:s');
            $this->db->query("UPDATE suomoto_reclass SET status='A',co_recommendation = '$co_report', co_recom_date = '$co_date_entry', co_yn = '$co_sign', "
                    . "co_date = '$co_date_entry' WHERE case_no = '$case_no' and proposal_no = '$proposal_no'");
   
            ///////////////For Proceeding///////////////////
            $q = "select * from suomoto_reclass where case_no = '$case_no' and proposal_no = '$proposal_no' ";
            $details = $this->db->query($q)->row();

            $proID=$this->maxProceedingID($case_no);
            $pro_array=array(
                'dist_code' => $details->dist_code,
                'subdiv_code' => $details->subdiv_code,
                'cir_code' => $details->cir_code,
                'case_no'=>$case_no,
                'proceeding_id'=>$proID,
                'status'=>'pending',
                'date_of_hearing'=>date('Y-m-d'),
                'co_order'=>$co_report,
                'user_code'=>$co_code,
                'date_entry'=>$co_date_entry,
                'operation'=>'E',
                'ip' => $_SERVER['REMOTE_ADDR']
                );
            $this->db->insert('petition_proceeding_dc_adc',$pro_array);
           // $this->UtilsModel->uploadFile($case_no);
            //////////////////////////////////
            $penUser='ADC';
            $rmrk='Report by CO';
            //$this->DashboardData($case_no,$penUser,$rmrk);
            ///////          
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo "Error Occured";
            }else {
                $this->db->trans_commit();
                $this->session->set_flashdata('message',"Circle Officer's Report on Reclassification Case no with case no $case_no ");
                // echo "string";die;
                //////////////////////////////////
                $data=array(
                    'success'=>"Circle Officer's Report on Reclassification Case no $case_no",
                    'redirect_url'=>base_url().'index.php/home'
                );
                //redirect(base_url() . "index.php/home");
                
            }
             echo json_encode($data);
        }


        public function adcProceeding() {

            $this->db->trans_begin();
            $proposal_no = $this->input->POST('proposal_no');
            $case_no = $this->input->POST('case_no');
            $adc_report1 = $this->input->POST('remark');
            $adc_report_suffix = $this->input->POST('remark_suffix');
            $adc_report = $adc_report1." - ".$adc_report_suffix;

            $adc_code = $this->session->userdata('user_code');
            $co_sign = 'Y';
            $co_date_entry = date('Y-m-d G:i:s');
            $next_hearing=$this->input->post('next_hearing_date');

            $this->db->query("UPDATE suomoto_reclass SET status='D', next_date_of_hearing='$next_hearing'
         WHERE case_no = '$case_no' and proposal_no = '$proposal_no'");
   
            ///////////////For Proceeding///////////////////
            $q = "select * from suomoto_reclass where case_no = '$case_no' and proposal_no = '$proposal_no' ";
            $details = $this->db->query($q)->row();

            $proID=$this->maxProceedingID($case_no);
            $pro_array=array(
                'dist_code' => $details->dist_code,
                'subdiv_code' => $details->subdiv_code,
                'cir_code' => $details->cir_code,
                'case_no'=>$case_no,
                'proceeding_id'=>$proID,
                'date_of_hearing'=>date('Y-m-d', strtotime($next_hearing)),
                'co_order'=>$adc_report,
                'user_code'=>$adc_code,
                'date_entry'=>date('Y-m-d G:i:s'),
                'operation'=>'E',
                'ip' => $_SERVER['REMOTE_ADDR']
                );
            $this->db->insert('petition_proceeding_dc_adc',$pro_array);
           // $this->UtilsModel->uploadFile($case_no);
            //////////////////////////////////
            $penUser='DC';
            $rmrk='Report by CO';
            //$this->DashboardData($case_no,$penUser,$rmrk);
            ///////          
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo "Error Occured";
            }

            else
                {
                    $this->db->trans_commit();
                    //////////////POST To rtps/////////////////////
                    
                   // $this->DashboardReclass($case_no['case_no']);
                    $this->session->set_flashdata('message',"ADC's report submitted case no $case_no ");
                    //////////////////////////////////
                    $data=array(
                        'success'=>"ADC's report submitted case no $case_no",
                        'redirect_url'=>base_url().'index.php/home'
                    );
                }
            echo json_encode($data);
        }

        public function dcProceeding() {

            $this->db->trans_begin();
            $proposal_no = $this->input->POST('proposal_no');
            $case_no = $this->input->POST('case_no');
            $payment_amount = $this->input->POST('payment_amount');
            // $adc_report1 = $this->input->POST('remark');
            // $adc_report_suffix = $this->input->POST('remark_suffix');
            // $adc_report = $adc_report1." - ".$adc_report_suffix;

            $dc_code = $this->session->userdata('user_code');
            $co_sign = 'Y';
            $co_date_entry = date('Y-m-d G:i:s');


           
   
            ///////////////For Proceeding///////////////////
            $q = "select * from suomoto_reclass where case_no = '$case_no' and proposal_no = '$proposal_no' ";
            $details = $this->db->query($q)->row();

           if($details->is_ten=='N'){
            $this->db->query("UPDATE suomoto_reclass SET status='B',payment_amount='$payment_amount',dc_yn='Y',dc_approval='Y' WHERE case_no = '$case_no' and proposal_no = '$proposal_no'");
           }

           else{
            $this->db->query("UPDATE suomoto_reclass SET status='R' WHERE case_no = '$case_no' and proposal_no = '$proposal_no'");
           }


            $proID=$this->maxProceedingID($case_no);
            $pro_array=array(
                'dist_code' => $details->dist_code,
                'subdiv_code' => $details->subdiv_code,
                'cir_code' => $details->cir_code,
                'case_no'=>$case_no,
                'proceeding_id'=>$proID,
                // 'date_of_hearing'=>$this->input->post('next_hearing_date'),
                'co_order'=>'DC report',
                'user_code'=>$dc_code,
                'date_entry'=>date('Y-m-d G:i:s'),
                'operation'=>'E',
                'ip' => $_SERVER['REMOTE_ADDR']
                );
            $this->db->insert('petition_proceeding_dc_adc',$pro_array);
           // $this->UtilsModel->uploadFile($case_no);
            //////////////////////////////////
            
            //$this->DashboardData($case_no,$penUser,$rmrk);
            ///////          
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo "Error Occured";
            }else {
                $this->db->trans_commit();
                $this->session->set_flashdata('message',"DC's Report on Reclassification Case no with case no $case_no ");
                // echo "string";die;
                //////////////////////////////////
                $data=array(
                    'success'=>"DC's Report on Reclassification Case no $case_no",
                    'redirect_url'=>base_url().'index.php/home'
                );
               // redirect(base_url() . "index.php/home");
                
            }
             echo json_encode($data);
        }

    Public function FirstADCProcess() {
            //var_dump($this->session->all_userdata());
            $user_code = $this->session->userdata('user_code');
            $case_no = $this->input->GET('case_no');
            $proposal_no = $this->input->GET('proposal_no');
            $q = "select * from suomoto_reclass where case_no = '$case_no' and proposal_no = '$proposal_no' ";
            $details = $this->db->query($q)->row();

            $dist_code = $this->utilityclass->getDistrictName($details->dist_code);
            $subdiv_code = $this->utilityclass->getSubDivName($details->dist_code, $details->subdiv_code);
            $cir_code = $this->utilityclass->getCircleName($details->dist_code, $details->subdiv_code, $details->cir_code);
            $mouza_pargona_code = $this->utilityclass->getMouzaName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code);
            $lot_no = $this->utilityclass->getLotName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no);
            $vill_townprt_code = $this->utilityclass->getVillageName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $details->vill_townprt_code);
            
            $adc = $this->utilityclass->getSelectedCOName($details->dist_code, '00', '00', $user_code);
            $username = $this->db->query("select user_code from loginuser_table where user_code like '%ADC%' ")->result();
            $usercodeadc='';
            foreach($username as $uc){
                if($uc->user_code==$user_code)
                    $usercodeadc = $user_code;
            }
            
            $data['location'] = array(
                'dist' => $dist_code,
                'sub' => $subdiv_code,
                'cir' => $cir_code,
                'mouza' => $mouza_pargona_code,
                'lot' => $lot_no,
                'vill' => $vill_townprt_code,
                'adc_name' => $adc->username,
                'uc'=>$usercodeadc
            );

            $data['Pcases'] = $details;

            $note="select * from petition_proceeding_dc_adc where case_no='$case_no' order by proceeding_id desc";
            $data['notes']= $this->db->query($note)->result();

            $sql3="Select string_agg(pdar_name,', ') as pdar from suomoto_part_pattadar where case_no=? and dist_code=?";
            $data['part_pattadar']=$this->db->query($sql3,array($case_no,$details->dist_code))->result();

            $data['_view'] = 'SuomotoReclassification/FirstADCProcessSuomoto';
            $this->load->view('layouts/main',$data);
        }

        Public function FirstDCProcess() {
            //var_dump($this->session->all_userdata());
            $user_code = $this->session->userdata('user_code');
            $case_no = $this->input->GET('case_no');
            $proposal_no = $this->input->GET('proposal_no');
            $q = "select * from suomoto_reclass where case_no = '$case_no' and proposal_no = '$proposal_no' ";
            $details = $this->db->query($q)->row();

            $dist_code = $this->utilityclass->getDistrictName($details->dist_code);
            $subdiv_code = $this->utilityclass->getSubDivName($details->dist_code, $details->subdiv_code);
            $cir_code = $this->utilityclass->getCircleName($details->dist_code, $details->subdiv_code, $details->cir_code);
            $mouza_pargona_code = $this->utilityclass->getMouzaName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code);
            $lot_no = $this->utilityclass->getLotName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no);
            $vill_townprt_code = $this->utilityclass->getVillageName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $details->vill_townprt_code);
            
            $adc = $this->utilityclass->getSelectedCOName($details->dist_code, '00', '00', $user_code);
            $username = $this->db->query("select user_code from loginuser_table where user_code like '%ADC%' ")->result();
            $usercodeadc='';
            foreach($username as $uc){
                if($uc->user_code==$user_code)
                    $usercodeadc = $user_code;
            }
            
            $data['location'] = array(
                'dist' => $dist_code,
                'sub' => $subdiv_code,
                'cir' => $cir_code,
                'mouza' => $mouza_pargona_code,
                'lot' => $lot_no,
                'vill' => $vill_townprt_code,
                'adc_name' => $adc->username,
                'uc'=>$usercodeadc
            );

            $data['Pcases'] = $details;

            $note="select * from petition_proceeding_dc_adc where case_no='$case_no' order by proceeding_id desc";
            $data['notes']= $this->db->query($note)->result();

             //code for generating village uuid------------
            $village_uuid = $this->utilityclass->getVillageUUID($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $details->vill_townprt_code);

            // var_dump($details->dag_no);
            // exit;

            //code for generating zonal value--------------
            $data['zonalValueOfDag'] = $this->utilityclass->getZonalValue($details->dist_code, $village_uuid, $details->dag_no);

            $data['_view'] = 'SuomotoReclassification/FirstDCProcessSuomoto';
            $this->load->view('layouts/main',$data);
        }

        public function forwardtodc(){
            $case_no = $this->input->GET('case_id');
            $proposal_no = $this->input->GET('proposal_no');
            $forwardtodc = $this->input->GET('forwarddc');
            $account = $this->input->GET('account');
            $application_no= $this->input->post('application_no');
            $this->db->trans_begin();
            $this->db->query("UPDATE t_reclassification SET forwardtodc = '$forwardtodc',account='$account' WHERE case_no = '$case_no' and proposal_no = '$proposal_no'");
               //////////
            $penUser='DC';
            $rmrk='Report by ADC';
            $this->DashboardData($case_no,$penUser,$rmrk);

            ///////

                if($application_no)
                {
                    $rtps=$this->rtpsmodel->checkRtpsService($application_no);
                    if($rtps=='RTPS'){
                        $apilink=RTPS_API_LINK;
                    }else{
                        $apilink=API_LINK;
                    }
                    $curl_handle = curl_init();
                    curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
                    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                        'application' => $application_no,
                        'dharitree' => $case_no,
                        'rmk' => 'forwared to DC',
                        'status' => 'M',
                        'task' => 'ADC',
                        'pen'=>'DC',
                        'penat'=>'DC office'
                    )));
                    $result = curl_exec($curl_handle);
                    if($result==true){
                        $this->db->trans_commit();
                    }else{
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message',"ADC's Report on Reclassification Case no with case no $case_no ");
                        redirect(base_url() . "index.php/home");
                    }
                }
                $this->db->trans_commit();
                $this->session->set_flashdata('message',"ADC's Report on Reclassification Case no with case no $case_no ");
                //////////////////////////////////
                $data=array(
                    'success'=>"ADC's Report on Reclassification Case no $case_no",
                    'redirect_url'=>base_url().'index.php/home'
                );
                redirect(base_url() . "index.php/home");
        }  
        public function forwardtoCO(){
             $case_no = $this->input->GET('case_id');
             $proposal_no = $this->input->GET('proposal_no');
             $forwardcofrom_adc = $this->input->GET('forwardcofrom_adc');
             //$account = $this->input->GET('account');
             $this->db->query("UPDATE t_reclassification SET forwardcofrom_adc = '$forwardcofrom_adc',account=null WHERE case_no = '$case_no' and proposal_no = '$proposal_no'");
            //echo"UPDATE t_reclassification SET forwardtodc = '$forwardtodc',account='$account' WHERE case_no = '$case_no' and proposal_no = '$proposal_no'";
            redirect(base_url() . "index.php/home");
        }
        public function revertToLm(){
            $case_no = $this->input->post('case_no');
            $proposal_no = $this->input->post('proposal_no');
            $application_no=$this->input->post('application_no');

            $co_report1 = $this->input->POST('co_report');
            $co_report_suffix = $this->input->POST('co_report_suffix');
            $co_report = $co_report1." - ".$co_report_suffix;
            //$co_report = str_replace("'", '', $co_report);
            $co_code = $this->session->userdata('user_code');
            $co_sign = 'Y';
            $co_date_entry = date('Y-m-d G:i:s');
             // $forwardcofrom_adc = $this->input->GET('forwardcofrom_adc');
             //$account = $this->input->GET('account');
            $this->db->trans_begin();
            $this->db->query("UPDATE t_reclassification SET status='M' WHERE case_no = '$case_no' and proposal_no = '$proposal_no'");
            //echo"UPDATE t_reclassification SET forwardtodc = '$forwardtodc',account='$account' WHERE case_no = '$case_no' and proposal_no = '$proposal_no'";

             /////////////ProCedding///////////////////////
            $sql="Select * from t_reclassification WHERE case_no = '$case_no' and proposal_no = '$proposal_no'";
            $tclass=$this->db->query($sql)->row();
            $prodId=$this->maxProceedingID($case_no);
            $pro_array=array(
                'dist_code' => $tclass->dist_code,
                'subdiv_code' => $tclass->subdiv_code,
                'cir_code' => $tclass->cir_code,
                'case_no'=>$case_no,
                'proceeding_id'=>$prodId,
                'status'=>'pending',
                'date_of_hearing'=>date('Y-m-d'),
                'co_order'=>$co_report,
                'user_code'=>$co_code,
                'date_entry'=>$co_date_entry,
                'operation'=>'E',
                'ip' => $_SERVER['REMOTE_ADDR']
            );
            $this->db->insert('petition_proceeding_dc_adc',$pro_array);
            $penUser='LM';
            $rmrk='Revert to LM by CO';
            $this->DashboardData($case_no,$penUser,$rmrk);

            if($application_no)
            {
                $rtps=$this->rtpsmodel->checkRtpsService($application_no);
                if($rtps=='RTPS'){
                    $apilink=RTPS_API_LINK;
                }else{
                    $apilink=API_LINK;
                }
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    'application' => $application_no,
                    'dharitree' => $case_no,
                    'rmk' => 'forwared to LM',
                    'status' => 'M',
                    'task' => 'CO',
                    'pen'=>'LM',
                    'penat'=>'Circle office'
                )));
                $result = curl_exec($curl_handle);
                if($result==true){
                    $this->db->trans_commit();
                }else{
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message',"Error in API Call");
                    redirect(base_url() . "index.php/home");
                }
            }
            $this->db->trans_commit();
            $this->session->set_flashdata('message',"Forwared to LM for correction of remark #$case_no ");
            redirect(base_url() . "index.php/home");
        }

        public function ResponseLM() {
            $user_code = $this->session->userdata('user_code');
            $case_no = $this->input->GET('case_no');
            $q = "select * from t_reclassification where case_no = '$case_no'";
            $details = $this->db->query($q)->row();

            $dist_code = $this->utilityclass->getDistrictName($details->dist_code);
            $subdiv_code = $this->utilityclass->getSubDivName($details->dist_code, $details->subdiv_code);
            $cir_code = $this->utilityclass->getCircleName($details->dist_code, $details->subdiv_code, $details->cir_code);
            $mouza_pargona_code = $this->utilityclass->getMouzaName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code);
            $lot_no = $this->utilityclass->getLotName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no);
            $vill_townprt_code = $this->utilityclass->getVillageName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $details->vill_townprt_code);
            
           // $co = $this->utilityclass->getSelectedCOName($details->dist_code, $details->subdiv_code, $details->cir_code, $user_code);
            $lm = $this->utilityclass->getDefinedMondalsName($details->dist_code, $details->subdiv_code, $details->cir_code,$details->mouza_pargona_code,$details->lot_no, $user_code);

            $data['location'] = array(
                'dist' => $dist_code,
                'sub' => $subdiv_code,
                'cir' => $cir_code,
                'mouza' => $mouza_pargona_code,
                'lot' => $lot_no,
                'vill' => $vill_townprt_code,
                //'co_name' => $co->username,
                'lm_name'=>$lm->lm_name

            );

            $old_patta = $this->db->query("select * from patta_code where type_code = '$details->patta_type_code' ")->row();
            $old_land_class = $this->db->query("select * from landclass_code where class_code = '$details->present_land_class' ")->row();
            $proposed_land_class = $this->db->query("select * from landclass_code where class_code = '$details->proposed_land_class' ")->row();

            $data['det'] = array(
                'patta_type' => $old_patta->patta_type,
                'old_land_class' => $old_land_class->land_type,
                'proposed_land_class' => $proposed_land_class->land_type,
                'proposed_land_class_code' => $details->present_land_class,
                'pp_code'=>$details->proposed_land_class
            );
            $all_land_class = "Select * from landclass_code";
            $data['land_class'] = $this->db->query($all_land_class)->result();
            $data['Pcases'] = $details;
            $lmnote="select * from petition_proceeding_dc_adc where case_no='$case_no' and user_code='$user_code' order by proceeding_id desc ";
            $data['lmrmk']= $this->db->query($lmnote)->row();

            $conote="select * from petition_proceeding_dc_adc where case_no='$case_no' and user_code like 'CO%' order by proceeding_id desc ";
            $data['cormk']= $this->db->query($conote)->row();
            $application_no="select * from basundhar_application where dharitree='$case_no' ";
            $data['app'] = $this->db->query($application_no)->row();

            $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
            if($basundhara){
                $rtps=$this->rtpsmodel->checkBasundharaService($case_no);
                if($rtps=='RTPS'){
                    $data['basundharaAttachment']=$this->rtpsmodel->searchBasundharaLink($case_no);
                    $data['basundharaApp']=$this->rtpsmodel->searchBasundharaLinkApp($case_no);
                }else{
                    $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
                    $data['basundharaApp']=$this->basundharamodel->searchBasundharaLinkApp($case_no);
                }
            }
            $data['_view'] = 'LandReclassification/response_lm';
            $this->load->view('layouts/main',$data);
        }
        public function SaveCoProcessLMRe() {
            $this->db->trans_begin();
            $proposal_no = $this->input->POST('proposal_no');
            $case_no = $this->input->POST('case_no');
            $co_report1 = $this->input->POST('co_report');
            $co_report_suffix = $this->input->POST('co_report_suffix');
            $co_report = $co_report1." - ".$co_report_suffix;
            $proposed_land_revenue = $this->input->post('P_land_rev');
            $proposed_land_localtax = $this->input->post('p_local_tax');
            $new_land_class = $this->input->post('new_land_class');
            $co_report=$c_p = str_replace("'", '', $co_report);

            $co_code = $this->session->userdata('user_code');
            $co_sign = 'Y';
            $co_date_entry = date('Y-m-d G:i:s');
            $sql="Select co_recommendation from t_reclassification WHERE case_no = '$case_no' and proposal_no = '$proposal_no'";
            $co_recomm_old=$this->db->query($sql)->row()->co_recommendation;
            $co_report=$co_recomm_old."<br>".$co_report;
            $this->db->query("UPDATE t_reclassification SET proposed_land_revenue = '$proposed_land_revenue', proposed_land_localtax = '$proposed_land_localtax',status='C',co_yn=null,proposed_land_class='$new_land_class' WHERE case_no = '$case_no' and proposal_no = '$proposal_no'");
            ////////////////////
            $sql="Select * from t_reclassification WHERE case_no = '$case_no' and proposal_no = '$proposal_no'";
            $tclass=$this->db->query($sql)->row();



            $prodId=$this->maxProceedingID($case_no);
            $proArray= array(
                'case_no' => $case_no,
                'proceeding_id' => $prodId,
                'user_code' => $this->session->userdata('user_code'),
                'status' => 'Pending',
                'co_order'=>$c_p,
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'dist_code' => $tclass->dist_code,
                'subdiv_code' => $tclass->subdiv_code,
                'cir_code' => $tclass->cir_code,
                'ip' => $_SERVER['REMOTE_ADDR']
                 );
            $this->db->insert('petition_proceeding_dc_adc',$proArray);
            $this->UtilsModel->uploadFile($case_no);
            ///////////////////
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo "Error Occured";
            } else {

                $application_no=$this->input->post('application_no');
                if($application_no)
                {
                        $rtps=$this->rtpsmodel->checkRtpsService($application_no);
                        if($rtps=='RTPS'){
                            $apilink=RTPS_API_LINK;
                        }else{
                            $apilink=API_LINK;
                        }
                        $curl_handle = curl_init();
                        curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
                        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
                        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                            'application' => $application_no,
                            'dharitree' => $case_no,
                            'rmk' => 'Re-report given by LM',
                            'status' => 'M',
                            'task' => 'LM',
                            'pen'=>'CO',
                            'penat'=>'Circle office'
                        )));
                        $result = curl_exec($curl_handle);
                        if($result==true){
                            $this->db->trans_commit();
                        }else{
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message',"Error in API Call");
                            redirect(base_url() . "index.php/home");
                        }
                }
                /////////////////////////
                $this->db->trans_commit();
                $penUser='CO';
                $rmrk='Re-report by LM';
                $this->DashboardData($case_no,$penUser,$rmrk);
                $this->session->set_flashdata('message',"LM's Report on Reclassification Case no # $case_no");
                redirect(base_url() . "index.php/home");
            }
        }
        
        
        public function SaveDCProcess() {

            $this->db->trans_begin();
            $revarted=$this->input->POST('revarted');
            $case_no = $this->input->POST('case_no');
            $proposal_no = $this->input->POST('proposal_no');
            $dc_report = $this->input->POST('dc_report');
            $dc_report = str_replace("'", '', $dc_report);
            
            $dc_code = $this->session->userdata('user_code');
            $dc_sign = 'Y';
            $dc_date_entry = date('Y-m-d G:i:s');
            
            if($revarted=='Y')
            {
                $this->db->query("UPDATE t_reclassification SET dc_approval = '$dc_report', dc_date = '$dc_date_entry' WHERE case_no = '$case_no' and proposal_no = '$proposal_no'");
                $this->session->set_flashdata('message',"Deputy Commissioner / Aditional Deputy Commissioner's Report on Reclassification Case no # $case_no Revarted Back To CO");
                redirect(base_url() . "index.php/home");
            }
            else
            {
                $this->db->query("UPDATE t_reclassification SET dc_approval = '$dc_report', dc_approval_date = '$dc_date_entry', dc_yn = '$dc_sign', dc_date = '$dc_date_entry' WHERE case_no = '$case_no' and proposal_no = '$proposal_no'");
            
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    echo "Error Occured";
                } else {
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message',"Deputy Commissioner / Aditional Deputy Commissioner's Report on Reclassification Case no # $case_no updated");
                    redirect(base_url() . "index.php/home");
                }
            }
        }

        public function ApprovedProposals() {
            $user_code = $this->session->userdata('user_code');
            $case_no = $this->input->GET('case_no');
            $q = "select * from t_reclassification where case_no = '$case_no'";
            $details = $this->db->query($q)->row();

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

            $old_patta = $this->db->query("select * from patta_code where type_code = '$details->patta_type_code' ")->row();
            $old_land_class = $this->db->query("select * from landclass_code where class_code = '$details->present_land_class' ")->row();
            $proposed_land_class = $this->db->query("select * from landclass_code where class_code = '$details->proposed_land_class' ")->row();
            $data['app']=null;
            $data['det'] = array(
                'patta_type' => $old_patta->patta_type,
                'old_land_class' => $old_land_class->land_type,
                'proposed_land_class' => $proposed_land_class->land_type,
                'proposed_land_class_code' => $details->present_land_class,
                'pp_code'=>$details->proposed_land_class
            );
            $all_land_class = "Select * from landclass_code";
            $data['land_class'] = $this->db->query($all_land_class)->result();
            $application_no="select * from basundhar_application where dharitree='$case_no' ";
            $data['app'] = $this->db->query($application_no)->row();
            $data['Pcases'] = $details;
            $data['sup_doc']=$this->db->query("SELECT * FROM supportive_document WHERE case_no=?", array($case_no))->result();
            // $this->load->helper('html');
            // $this->load->view('../views/header');
            // $this->load->view('../views/LandReclassification/ApprovedProposals', $data);
            // $this->load->view('../views/footer');

            $data['_view'] = 'LandReclassification/ApprovedProposals';
            $this->load->view('layouts/main',$data);
        }
        
        public function SaveCoProcessRee() {
            //var_dump($this->input->post());
            //exit();
            
            $proposal_no = $this->input->POST('proposal_no');
            $case_no = $this->input->POST('case_no');
            $co_report1 = $this->input->POST('co_report');
            $co_report_suffix = $this->input->POST('co_report_suffix');
            $co_report = $co_report1." - ".$co_report_suffix;
            $proposed_land_revenue = $this->input->post('P_land_rev');
            $proposed_land_localtax = $this->input->post('p_local_tax');
            $new_land_class = $this->input->post('new_land_class');
            $co_report=$c_p = str_replace("'", '', $co_report);

            $co_code = $this->session->userdata('user_code');
            $co_sign = 'Y';
            $co_date_entry = date('Y-m-d G:i:s');
            //////////////////////////////////
            // var_dump($_FILES['fileUpload']);
            // die;
            if(isset($_FILES['fileUpload']['name'])){
            $this->form_validation->set_rules('fileText[]', 'Document Details', 'trim|xss_clean|required');
            $fileCount = count($_FILES['fileUpload']['name']);
            // validation for file type and file size
            for($i = 0; $i < $fileCount; $i++)
            {
                if($_FILES['fileUpload']['name'][$i] && $_FILES['fileUpload']['size'][$i] && $_FILES['fileUpload']['tmp_name'][$i]){
                    $name = $_FILES['fileUpload']['name'][$i];
                    $size = $_FILES['fileUpload']['size'][$i];
                    $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                    $exp  = explode("/",$mime);
                    $ext  = $exp[1];
                        if($name != NULL)
                        {
                            if($ext == NULL)
                            {
                                // todo error show extension missing
                                $this->session->set_flashdata('message', "File Not Supported. Error Code(#FAPL001)");
                                redirect(base_url() . "index.php/home");
                            }
                            if(! in_array($ext, UPLOAD_TYPE_VALIDATION))
                            {
                                // todo error show file allow type not match
                                $this->session->set_flashdata('message', "File Not Supported (ONLY JPG/PNG/PDF). Error Code(#FAPL002)");
                                redirect(base_url() . "index.php/home");
                            }
                            if($size > UPLOAD_MAX_SIZE)
                            {
                                $this->session->set_flashdata('message', "Maximum 2MB file size. Error Code(#FAPL003)");
                                redirect(base_url() . "index.php/home");
                            }

                        }
                        else
                        {
                            $this->session->set_flashdata('message', "File name cann't be empty. Error Code(#FAPL004)");
                            redirect(base_url() . "index.php/home");
                        }
                    }
                    else{
                        $this->session->set_flashdata('message', "File is required. Error Code(#FAPL005)");
                        redirect(base_url() . "index.php/home");
                    }
                }
            }
            ///////////////////Insert attached file////////////////////////
            $this->db->trans_begin();
            $this->UtilsModel->uploadFile($case_no);
            $sql="Select co_recommendation from t_reclassification WHERE case_no = '$case_no' and proposal_no = '$proposal_no'";
            $co_recomm_old=$this->db->query($sql)->row()->co_recommendation;
            $co_report=$co_recomm_old."<br>".$co_report;
            $this->db->query("UPDATE t_reclassification SET co_recommendation = '$co_report', co_recom_date = '$co_date_entry', co_yn = '$co_sign', "
                    . "co_date = '$co_date_entry', proposed_land_revenue = '$proposed_land_revenue', proposed_land_localtax = '$proposed_land_localtax',"
                    . " proposed_land_class='$new_land_class', status='A' WHERE case_no = '$case_no' and proposal_no = '$proposal_no'");
            ////////////////////
            $sql="Select * from t_reclassification WHERE case_no = '$case_no' and proposal_no = '$proposal_no'";
            $tclass=$this->db->query($sql)->row();

            $prodId=$this->maxProceedingID($case_no);
            $proArray= array(
                'case_no' => $case_no,
                'proceeding_id' => $prodId,
                'user_code' => $this->session->userdata('user_code'),
                'status' => 'Pending',
                'co_order'=>$c_p,
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'dist_code' => $tclass->dist_code,
                'subdiv_code' => $tclass->subdiv_code,
                'cir_code' => $tclass->cir_code,
                'ip' => $_SERVER['REMOTE_ADDR']
                 );
            $this->db->insert('petition_proceeding_dc_adc',$proArray);

            ///////////////////
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo "Error Occured";
            } else {
                //$this->db->trans_commit();
                //////////////////////////
                $application_no=$this->input->post('application_no');
                if($application_no)
                {
                        $rtps=$this->rtpsmodel->checkRtpsService($application_no);
                        if($rtps=='RTPS'){
                            $apilink=RTPS_API_LINK;
                        }else{
                            $apilink=API_LINK;
                        }
                        $curl_handle = curl_init();
                        curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
                        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
                        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                            'application' => $application_no,
                            'dharitree' => $case_no,
                            'rmk' => 'Forwared to ADC',
                            'status' => 'M',
                            'task' => 'CO',
                            'pen'=>'ADC',
                            'penat'=>'DC office'
                        )));
                        $result = curl_exec($curl_handle);
                        if($result==true){
                            $this->db->trans_commit();
                        }else{
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message',"Error in API Call");
                            redirect(base_url() . "index.php/home");
                        }
                }
                /////////////////////////
                $this->db->trans_commit();
                $penUser='ADC';
                $rmrk='Re-report by CO';
                $this->DashboardData($case_no,$penUser,$rmrk);
                $this->session->set_flashdata('message',"Circle Officer's Report on Reclassification Case no # $case_no");
                redirect(base_url() . "index.php/home");
            }
        }
        function FinalProcessDC(){
            //var_dump($_POST);
            // echo 'asasas';die;
            $proposal_no = $this->input->POST('proposal_no');
            $case_no = $this->input->POST('case_no');
            $dc_report1 = $this->input->POST('dc_report');
            $dc_report_suffix = $this->input->POST('dc_report_suffix');
            $revarted = $this->input->POST('revarted');
            $dc_report = $dc_report1." - ".$dc_report_suffix;
            //echo $dc_report;
            $proposed_land_revenue = $this->input->post('P_land_rev');
            $proposed_land_localtax = $this->input->post('p_local_tax');
            $dc_report = str_replace("'", '', $dc_report);
            $dc_code = $this->session->userdata('user_code');
            $dc_sign = 'Y';
            $dc_date_entry = date('Y-m-d G:i:s');
            $this->db->trans_begin();
            $application_no=$this->input->POST('application_no');

            if($revarted=='F'){
                /////Final Order//////
                $status='Final';
            }elseif($revarted=='R'){
                ///////////Reject Order/////////////
                $status='Reject';
                $date_entry = date('Y-m-d');
                $this->db->query("UPDATE t_reclassification SET status = 'R', status_date = '$date_entry' WHERE case_no = '$case_no' and  proposal_no = '$proposal_no'");
                $penUser='NA';
                $rmrk='Rejected by DC';
                $this->DashboardDataReject($case_no,$penUser,$rmrk);  
                if($application_no)
                {
                    $rtps=$this->rtpsmodel->checkRtpsService($application_no);
                    if($rtps=='RTPS'){
                        $apilink=RTPS_API_LINK;
                    }else{
                        $apilink=API_LINK;
                    }
                    $curl_handle = curl_init();
                    curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
                    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                        'application' => $application_no,
                        'dharitree' => $case_no,
                        'rmk' => 'Rejected by DC',
                        'status' => 'R',
                        'task' => 'DC',
                        'pen'=>'N/A',
                        'penat'=>'DC office'
                    )));
                    $result = curl_exec($curl_handle);
                    if($result==true){
                        $this->db->trans_commit();
                    }else{
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message',"Error in API Call");
                        redirect(base_url() . "index.php/home");
                    }
                }
                $this->db->trans_commit();
                $this->session->set_flashdata('message',"Case has been rejected having case no $case_no ");
                redirect(base_url() . "index.php/home");    
            }elseif($revarted=='A'){
                ///////////Revert To ADC/////////////
                $status='Reject';
                $date_entry = date('Y-m-d');
                $this->db->query("UPDATE t_reclassification SET status = 'A', status_date = '$date_entry' WHERE case_no = '$case_no' and  proposal_no = '$proposal_no'");
                ///////
                $penUser='ADC';
                $rmrk='Reverted by DC';
                $this->DashboardData($case_no,$penUser,$rmrk);
                //////

                if($application_no)
                {
                    $rtps=$this->rtpsmodel->checkRtpsService($application_no);
                    if($rtps=='RTPS'){
                        $apilink=RTPS_API_LINK;
                    }else{
                        $apilink=API_LINK;
                    }
                    $curl_handle = curl_init();
                    curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
                    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                        'application' => $application_no,
                        'dharitree' => $case_no,
                        'rmk' => 'Reverted by DC',
                        'status' => 'M',
                        'task' => 'DC',
                        'pen'=>'ADC',
                        'penat'=>'DC office'
                    )));
                    $result = curl_exec($curl_handle);
                    if($result==true){
                        $this->db->trans_commit();
                    }else{
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message',"Error in API Call");
                        redirect(base_url() . "index.php/home");
                    }
                }
                $this->db->trans_commit();
                $this->session->set_flashdata('message',"Case has been reverted back by DC with case no $case_no ");
                // echo "string";die;
                //////////////////////////////////
                $data=array(
                    'success'=>"Case has been reverted having case no $case_no",
                    'redirect_url'=>base_url().'index.php/home'
                );
                redirect(base_url() . "index.php/home");
           
             echo json_encode($data);
                
                
            }else{

                /////////Revert To CO////////////
                $status='Pending';
                $date_entry = date('Y-m-d');
                $this->db->query("UPDATE t_reclassification SET status = 'C', status_date = '$date_entry' WHERE case_no = '$case_no' and  proposal_no = '$proposal_no'");

                 ///////
                $penUser='CO';
                $rmrk='Reverted by DC to CO';
                $this->DashboardData($case_no,$penUser,$rmrk);
                //////
                if($application_no)
                {
                    $rtps=$this->rtpsmodel->checkRtpsService($application_no);
                    if($rtps=='RTPS'){
                        $apilink=RTPS_API_LINK;
                    }else{
                        $apilink=API_LINK;
                    }
                    $curl_handle = curl_init();
                    curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
                    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                        'application' => $application_no,
                        'dharitree' => $case_no,
                        'rmk' => 'Reverted by DC',
                        'status' => 'M',
                        'task' => 'DC',
                        'pen'=>'CO',
                        'penat'=>'DC office'
                    )));
                    $result = curl_exec($curl_handle);
                    $result = curl_exec($curl_handle);
                    if($result==true){
                        $this->db->trans_commit();
                    }else{
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message',"Error in API Call");
                        redirect(base_url() . "index.php/home");
                    }
                }
                $this->db->trans_commit();
                $this->session->set_flashdata('message',"Case has been reverted back by DC with case no $case_no ");
                // echo "string";die;
                //////////////////////////////////
                $data=array(
                    'success'=>"Case has been reverted having case no $case_no",
                    'redirect_url'=>base_url().'index.php/home'
                );
                redirect(base_url() . "index.php/home");
           
             // echo json_encode($data);
                
            }
            /////////////ProCedding///////////////////////
            $sql="Select * from t_reclassification WHERE case_no = '$case_no' and proposal_no = '$proposal_no'";
            $tclass=$this->db->query($sql)->row();

            $prodId=$this->maxProceedingID($case_no);
            $proArray= array(
                'case_no' => $case_no,
                'proceeding_id' => $prodId,
                'user_code' => $this->session->userdata('user_code'),
                'status' => $status,
                'co_order'=>$dc_report,
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'dist_code' => $tclass->dist_code,
                'subdiv_code' => $tclass->subdiv_code,
                'cir_code' => $tclass->cir_code,
                'ip' => $_SERVER['REMOTE_ADDR']
                 );
            $this->db->insert('petition_proceeding_dc_adc',$proArray);
            if($status!='Final'){
                redirect(base_url() . "index.php/home");
                exit;
            }
            /////////////////////////
            //exit;
            $this->db->query("UPDATE t_reclassification SET dc_approval = '$dc_report', dc_approval_date = '$dc_date_entry', dc_yn = '$dc_sign', dc_date = '$dc_date_entry', "
                        . "proposed_land_revenue = '$proposed_land_revenue',proposed_land_localtax = '$proposed_land_localtax' WHERE case_no = '$case_no' and proposal_no = '$proposal_no'");
            //////////
            $penUser='DC';
            $rmrk='Approval by DC';
            $this->DashboardData($case_no,$penUser,$rmrk);
            ///////
            $q = "select * from t_reclassification where case_no = '$case_no' and proposal_no = '$proposal_no'";
            $details = $this->db->query($q)->row();
            $old_patta = $this->db->query("select * from patta_code where type_code = '$details->patta_type_code' ")->row();
            $old_land_class = $this->db->query("select * from landclass_code where class_code = '$details->present_land_class' ")->row();
            $proposed_land_class = $this->db->query("select * from landclass_code where class_code = '$details->proposed_land_class' ")->row();

            $data['det'] = array(
                'patta_type' => $old_patta->patta_type,
                'old_land_class' => $old_land_class->land_type,
                'proposed_land_class' => $proposed_land_class->land_type,
                'case_no' => $case_no,
                'proposal_no' => $proposal_no
            );

            $data['Pcases'] = $details;
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo "Error Occured";
            } else {
                if($application_no)
                {
                    $rtps=$this->rtpsmodel->checkRtpsService($application_no);
                    if($rtps=='RTPS'){
                        $apilink=RTPS_API_LINK;
                    }else{
                        $apilink=API_LINK;
                    }
                    $curl_handle = curl_init();
                    curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
                    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                        'application' => $application_no,
                        'dharitree' => $case_no,
                        'rmk' => 'Final order by DC',
                        'status' => 'F',
                        'task' => 'DC',
                        'pen'=>'Approved',
                        'penat'=>'Dc office'
                    )));
                    $result = curl_exec($curl_handle);
                    if($result==true){
                        $this->db->trans_commit();
                    }else{
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message',"Error in API CALL ");
                        redirect('/home');
                    }
                }
                $this->db->trans_commit();
                $this->session->set_flashdata('message',"Case has been Approved by DC with case no $case_no ");
                $data['_view'] = 'LandReclassification/Confirm';
                $this->load->view('layouts/main',$data);
            }
        }
        public function FinalProcess() {
            $revarted=$this->input->POST('revarted');
            $proposal_no = $this->input->POST('proposal_no');
            $case_no = $this->input->POST('case_no');
            $application_no = $this->input->POST('application_no');
            $dc_report1 = $this->input->POST('dc_report');
            $dc_report_suffix = $this->input->POST('dc_report_suffix');
            $dc_report = $dc_report1." - ".$dc_report_suffix;
            //echo $dc_report;
            $proposed_land_revenue = $this->input->post('P_land_rev');
            $proposed_land_localtax = $this->input->post('p_local_tax');
            $dc_report = str_replace("'", '', $dc_report);
            $this->db->trans_begin();
            $dc_code = $this->session->userdata('user_code');
            $dc_sign = 'Y';
            $dc_date_entry = date('Y-m-d G:i:s');
            //////////////////////////////
            $sql="Select * from t_reclassification WHERE case_no = '$case_no' and proposal_no = '$proposal_no'";
            $tclass=$this->db->query($sql)->row();

            $prodId=$this->maxProceedingID($case_no);
            $proArray= array(
                'case_no' => $case_no,
                'proceeding_id' => $prodId,
                'user_code' => $this->session->userdata('user_code'),
                'status' => 'Pending',
                'co_order'=>$dc_report,
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'dist_code' => $tclass->dist_code,
                'subdiv_code' => $tclass->subdiv_code,
                'cir_code' => $tclass->cir_code,
                'ip' => $_SERVER['REMOTE_ADDR']
                );
            $this->db->insert('petition_proceeding_dc_adc',$proArray);
            ////////////////////////////
            if($revarted=='Y'){
                $sql="Select adc_report from t_reclassification WHERE case_no = '$case_no' and proposal_no = '$proposal_no'";
                $adc_previous=$this->db->query($sql)->row()->adc_report;
                $dc_report = $dc_report ."<br>". $adc_previous  ;
                $this->db->query("UPDATE t_reclassification SET adc_report = '$dc_report',status='C'  WHERE case_no = '$case_no' and proposal_no = '$proposal_no'");
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    echo "Error Occured";
                } else {
                    $penUser='CO';
                    $rmrk='Reverted by ADC to CO';
                    $this->DashboardData($case_no,$penUser,$rmrk);
                    if($application_no)
                    {
                            $rtps=$this->rtpsmodel->checkRtpsService($application_no);
                            if($rtps=='RTPS'){
                                $apilink=RTPS_API_LINK;
                            }else{
                                $apilink=API_LINK;
                            }
                            $curl_handle = curl_init();
                            curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
                            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                            'application' => $application_no,
                            'dharitree' => $case_no,
                            'rmk' => 'forwared to CO',
                            'status' => 'M',
                            'task' => 'ADC',
                            'pen'=>'CO',
                            'penat'=>'DC office'
                            )));
                            $result = curl_exec($curl_handle);
                            if($result==true){
                                $this->db->trans_commit();
                            }else{
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('message',"Error in API CALL ");
                                redirect('/home');
                            }
                }
                $this->db->trans_commit();
                $this->session->set_flashdata('message',"ADC's Report on Reclassification Case no with case no $case_no ");
                redirect('/home');
            }
            }else{
                $sql="Select adc_report from t_reclassification WHERE case_no = '$case_no' and proposal_no = '$proposal_no'";
                $adc_previous=$this->db->query($sql)->row()->adc_report;
                $dc_report = $dc_report ."\n". $adc_previous  ;
                $this->db->query("UPDATE t_reclassification SET adc_report='$dc_report',status = 'D' WHERE case_no = '$case_no' and proposal_no = '$proposal_no'");
                $penUser='DC';
                $rmrk='Forward to DC';
                $this->DashboardData($case_no,$penUser,$rmrk);
                if($application_no)
                {
                    $rtps=$this->rtpsmodel->checkRtpsService($application_no);
                    if($rtps=='RTPS'){
                        $apilink=RTPS_API_LINK;
                    }else{
                        $apilink=API_LINK;
                    }
                    $curl_handle = curl_init();
                    curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
                    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    'application' => $application_no,
                    'dharitree' => $case_no,
                    'rmk' => 'forwared to DC',
                    'status' => 'M',
                    'task' => 'ADC',
                    'pen'=>'DC',
                    'penat'=>'DC office'
                    )));
                    $result = curl_exec($curl_handle);
                    if($result==true){
                        $this->db->trans_commit();
                    }else{
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message',"Error in API CALL ");
                        redirect('/home');
                    }
                }
                $this->db->trans_commit();
                $this->session->set_flashdata('message',"ADC's Report on Reclassification Case no with case no $case_no ");
            }
            redirect('/home');
        }
        
        public function reject(){
            $application_no=$this->input->post('application_no');
            $date_entry = date('Y-m-d');
            if($application_no)
                    {
                        $case_no=$this->input->post('case_no');
                        $proposal_no=$this->input->post('proposal_no');
                        $order=$this->input->post('order');
                        $this->db->query("UPDATE t_reclassification SET adc_report='$order',status = 'R', status_date = '$date_entry' WHERE case_no = '$case_no' and  proposal_no = '$proposal_no'");
                        $this->DashboardDataReject($case_no);
                        $this->basundharamodel->RejectOrder();
                    }
            else{
                $case_no = $this->input->GET('case_id');
                $proposal_no = $this->input->GET('proposal_no');
                $this->db->query("UPDATE t_reclassification SET status = 'R', status_date = '$date_entry' WHERE case_no = '$case_no' and  proposal_no = '$proposal_no'");
                $this->DashboardDataReject($case_no);
                }
            $this->session->set_flashdata('message',"# $case_no has been rejected.");
            redirect(base_url() . "index.php/home");
        }

           
        public function dcWaitLandReclassification() {
            $case_no = $this->input->GET('case_no');
            $proposal_no = $this->input->GET('proposal_no');            
            $this->db->query("UPDATE t_reclassification SET dc_approval = null, dc_approval_date = null, dc_yn = null, dc_date = null WHERE case_no = '$case_no' and proposal_no = '$proposal_no'");
            $this->session->set_flashdata('message',"Chitha Not Updated. # $case_no is not yet Processed.");
            redirect(base_url() . "index.php/home");
        }
        function maxProceedingID($case_no){
            $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from petition_proceeding_dc_adc where case_no='$case_no' ")->row()->c;
            if($proceeding_id==null){
                $proceeding_id=1;
            }
            return $proceeding_id;
        }
        function proceedingDetails(){
            $case_no=$this->input->get('case_id');
            $q="Select * from petition_proceeding_dc_adc where case_no='$case_no' ";
            $data['pb']=$this->db->query($q)->result();
            
            //$this->load->view('../views/header');
            $this->load->view('../views/LandReclassification/view_proceeding', $data);
            //$this->load->view('../views/footer');
        }

        function Dashboard($case_no)
        {
            $this->dbb = $this->load->database('dash', TRUE);

            $sql="select * from t_reclassification where case_no='$case_no' ";
            
            $type='RC';
            $data=$this->db->query($sql)->row_array();
            $base= array(
                        'dist_code'=> $data['dist_code'],
                          'subdiv_code' =>$data['subdiv_code'],
                          'cir_code'=>$data['cir_code'],
                          'mouza_pargona_code'=>$data['mouza_pargona_code'],
                          'lot_no'=>$data['lot_no'],
                          'vill_townprt_code'=>$data['vill_townprt_code'],
                          'case_no'=>$data['case_no'],
                          'date_of_reg'=>$data['lm_date'],
                          'dag_no'=>$data['dag_no'],
                          'patta_type_code' =>$data['patta_type_code'],
                          'patta_no' =>$data['patta_no'],
                          'status' =>'P',
                          'pending_with_user' =>'CO',
                          'case_type' =>$type,
                      );
                

                unset($base['dag_no']);
                unset($base['patta_type_code']);
                unset($base['patta_no']);

            $this->dbb->insert('dashboard_data',$base);
            $this->db->insert('dashboard_data',$base);


            $action= array(
                'case_no' => $case_no,
                'user_code' => $this->session->userdata('user_code'),
                'date_of_action_taken' => date("Y-m-d h:i:s"),
                'user_designation' => $this->session->userdata('user_desig_code'),
                'remark' => 'Registered By LM',
                'ip_address'=>$_SERVER['REMOTE_ADDR']
                 );
             $this->dbb->insert('dashboard_action',$action);
             $this->db->insert('dashboard_action',$action);

    }

    function DashboardData($case_no,$penUser,$rmrk){
                //////////////Update Dashboard Database///////////////////////
                        $this->dbb = $this->load->database('dash', TRUE);
                        $base=array(
                            'pending_with_user' => $penUser,
                            'date_of_update'=>date("Y-m-d h:i:s")
                        );
                        $this->dbb->where('case_no',$case_no);
                        $this->dbb->update('dashboard_data',$base);
                        $action= array(
                            'case_no' => $case_no,
                            'user_code' => $this->session->userdata('user_code'),
                            'date_of_action_taken' => date("Y-m-d h:i:s"),
                            'user_designation' => $this->session->userdata('user_desig_code'),
                            'remark' => $rmrk,
                            'ip_address'=>$_SERVER['REMOTE_ADDR']
                             );
                        $this->dbb->insert('dashboard_action',$action);
                        $this->db->insert('dashboard_action',$action);

                        $this->db->where('case_no',$case_no);
                        $this->db->update('dashboard_data',$base);
                    /////////////////////////////////////
            }

            function DashboardDataFinal($case_no){
                //////////////Update Dashboard Database///////////////////////
                            $this->dbb = $this->load->database('dash', TRUE);
                            $base=array(
                                'final_order_date' => date('Y-m-d'),
                                'pending_with_user'=>'NA',
                                'status'=>'F',
                                'remark'=>'Final Order Passed',
                                'date_of_update'=>date("Y-m-d h:i:s")
                            );
                            $this->dbb->where('case_no',$case_no);
                            $this->dbb->update('dashboard_data',$base);
                            $action= array(
                                'case_no' => $case_no,
                                'user_code' => $this->session->userdata('user_code'),
                                'date_of_action_taken' => date("Y-m-d h:i:s"),
                                'user_designation' => $this->session->userdata('user_desig_code'),
                                'remark' => 'Final Order Passed',
                                'ip_address'=>$_SERVER['REMOTE_ADDR']
                                 );
                            $this->dbb->insert('dashboard_action',$action);
                            $this->db->insert('dashboard_action',$action);
                             
                            $this->db->where('case_no',$case_no);
                            $this->db->update('dashboard_data',$base);
                    /////////////////////////////////////
            }

        function DashboardDataReject($case_no){
            $this->dbb = $this->load->database('dash', TRUE);
                    $base=array(
                                'final_order_date' => date('Y-m-d'),
                                'pending_with_user'=>'NA',
                                'status'=>'R',
                                'remark'=>'Case Rejected',
                                'date_of_update'=>date("Y-m-d h:i:s")
                    );
                    $this->dbb->where('case_no',$case_no);
                    $this->dbb->update('dashboard_data',$base);

                    $this->db->where('case_no',$case_no);
                    $this->db->update('dashboard_data',$base);

                    $action= array(
                        'case_no' => $case_no,
                        'user_code' => $this->session->userdata('user_code'),
                        'date_of_action_taken' => date("Y-m-d h:i:s"),
                        'user_designation' => $this->session->userdata('user_desig_code'),
                        'remark' => 'Rejected',
                        'ip_address'=>$_SERVER['REMOTE_ADDR']
                         );
                    $this->dbb->insert('dashboard_action',$action);
                    $this->db->insert('dashboard_action',$action);
                }




    public function pattanoDetails()
    {
      
        $data = [];
        $dis = $this->input->post('dis');
        $this->session->set_userdata('dist_code',$dis);
        $this->dbswitch();
        $subdiv = $this->input->post('subdiv');
        $cir = $this->input->post('cir');
        $mza = $this->input->post('mza');
        $lot = $this->input->post('lot');
        $vill=$this->input->post('vill');
    
        //$this->session->set_userdata('lot_no', $lot);
        $location=$dis.'_'.$subdiv.'_'.$cir.'_'.$mza.'_'.$lot.'_'.$vill;
        $formdata = $this->mutationmodel->getPattaNo($dis,$subdiv,$cir,$mza,$lot,$vill);
        foreach ($formdata as $value) {
            $data['test'] = $value;
        }
        $data['location']=$location;
       // echo json_encode($data['test']);
       echo json_encode($data);
    }


    public function areaDetails()
  {
    $data = [];
    $dis = $this->input->post('dis');
    $this->session->set_userdata('dist_code',$dis);
    $this->dbswitch();
    $subdiv = $this->input->post('subdiv');
    $cir = $this->input->post('cir');
    $mza = $this->input->post('mza');
    $lot = $this->input->post('lot');
    $vill=$this->input->post('vill');
    $dag_no=$this->input->post('dag');


    $area = $this->db->query("select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,land_class_code from chitha_basic where dist_code='$dis' and cir_code='$cir' and subdiv_code='$subdiv' and vill_townprt_code='$vill' and mouza_pargona_code='$mza' and lot_no='$lot' and dag_no_int='$dag_no'");


    $data = $area->result();
    $temp = $data[0]->land_class_code;

    $land_type=$this->db->query("Select land_type,class_code from landclass_code where class_code='$temp'");

    $land_type=$land_type->row();
    

    $land_type_present=$this->db->query("Select land_type,class_code from landclass_code where class_code!='$temp'");

    $land_type_present=$land_type_present->result();
    //var_dump($land_type_present);

    $json = array();
    foreach ($data as $object) {
      $json = array('bigha' => trim($object->dag_area_b), 'katha' => trim($object->dag_area_k), 'lessa' => trim($object->dag_area_lc), 'ganda' => trim($object->dag_area_g), 'kranti' => trim($object->dag_area_kr),  'land_type' =>$land_type->land_type,'land_type_present'=>$land_type_present, 'land_code' => $land_type->class_code);
    }
    echo json_encode($json);
  }

   public function pattadarDetails()
  {
    $data = [];
    $dis = $this->input->post('dis');
    $this->session->set_userdata('dist_code',$dis);
    $this->dbswitch();
    $subdiv = $this->input->post('subdiv');
    $cir = $this->input->post('cir');
    $mza = $this->input->post('mza');
    $lot = $this->input->post('lot');
    $vill=$this->input->post('vill');
    $dag_no_int=$this->input->post('dag');


    $f_query = "select patta_no, patta_type_code,dag_no from chitha_basic where dist_code=? and subdiv_code=?
                and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=?
                and dag_no_int=?";
    $patta_result = $this->db->query($f_query, array(
      $dis, $subdiv, $cir, $mza,
      $lot, $vill, $dag_no_int
    ))->result();
    //echo $this->db->last_query();
    log_message("error", "MPR: ********** patta_no query result=".count($patta_result));
    if (!count($patta_result)) {
      echo "";
      return;
    }
    $patta_no = $patta_result[0]->patta_no;
    $patta_type_code = $patta_result[0]->patta_type_code;
    $dag_no = $patta_result[0]->dag_no;

  
    $where="dist_code = ? 
      and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ?
      and vill_townprt_code = ? and patta_type_code = ? and patta_no= ?";

    $s_query="select cp.pdar_id,cp.pdar_name,cp.pdar_father from 
      (select pdar_id,pdar_name,pdar_father from chitha_pattadar where $where  )
      as cp 
      join (select pdar_id from chitha_dag_pattadar where $where and (p_flag != '1' or p_flag is null) and dag_no= ?) as cdp on cp.pdar_id = cdp.pdar_id ";

    $data = $this->db->query($s_query, array(
      $dis, $subdiv, $cir, $mza,
      $lot, $vill, $patta_type_code,trim($patta_no),$dis, $subdiv, $cir, $mza,
      $lot, $vill, $patta_type_code,trim($patta_no),$dag_no
    ))->result();

    if (!count($data)) {
      echo "";
      return;
    }
   echo json_encode($data);

    // $json = array();
    // foreach ($data as $object) {
    //   $json = array('pdar_id' => trim($object->pdar_id), 'pdar_name' => trim($object->pdar_name), 'pdar_father' => trim($object->pdar_father));
    // }
    // echo json_encode($json);
  }


  function downloadAcknowledgement($id){
        $id=base64_decode($id);
        $dist_code=$this->session->userdata('dist_code');
        $user_code=$this->session->userdata('user_code');
        // $this->dbb=$this->load->database('auth',true);
         // $sql="Select string_agg(notified_name,',') from suomoto_notified where case_no=? and dist_code=?";
        $sql="Select * from suomoto_notified where case_no=? and dist_code=?";
        $data=$this->db->query($sql,array($id,$dist_code));

        $sql2="Select * from suomoto_reclass where case_no=? and dist_code=?";
        $data2=$this->db->query($sql2,array($id,$dist_code));

        $sql3="Select string_agg(pdar_name,', ') as pdar from suomoto_part_pattadar where case_no=? and dist_code=?";
        $data3=$this->db->query($sql3,array($id,$dist_code));

        // echo $this->db->last_query();
        // var_dump($data);
        if($data->num_rows()==0){
            echo json_encode(array('Error Found ! No Data Found'));
            return;
        }
        $result=$data->result();
        $result2=$data2->row();
        $result3=$data3->result();
        //var_dump($result3);exit;
         ob_start();
        include 'vendor/mpdf/vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetWatermarkText('DHARITREE');
        $mpdf->showWatermarkText = true;
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->autoScriptToLang = true;
        // $mpdf->alpha = 0.1;
        $mpdf->autoLangToFont = true;
        $tr='';
      
        foreach($result as $nf){
              $tr .= $nf->notified_name.',' ;
          }

        $distname .= $this->utilityclass->getDistrictName($result[0]->dist_code);
        $cirname .= $this->utilityclass->getCircleName($result[0]->dist_code,$result[0]->subdiv_code,$result[0]->cir_code);
        $village .= $this->utilityclass->getVillageName($result[0]->dist_code, $result[0]->subdiv_code, $result[0]->cir_code, $result[0]->mouza_pargona_code, $result[0]->lot_no, $result[0]->vill_townprt_code);

            
        $html='';
        $html .='<h3 style="text-align: center"><u>APPLICATION INFORMATION</u></h3>';
        $html .='<p>ACKNOWLEDGEMENT No. :'.$result[0]->case_no.'</p>';
        
        
         // <td>'.$result[0]->notified_name.'</td>
       // var_dump($tr);
       // exit;

        $table='<table style="margin-top:100px">
            <tr>
                <td>Notifier List    :</td>
                <td>'.$tr.'</td>
            </tr>
            <tr>
                <td>District    :</td>
                <td>'.$distname.'</td>
            </tr>
            <tr>
                <td>Circle  :</td>
                <td>'.$cirname.'</td>
            </tr>
            <tr>
                <td>Village  :</td>
                <td>'.$village.'</td>
            </tr>
            
            
        </table>';

        if($result2->is_part=='Y'){
        

        $table2='<table style="margin-top:100px">
            <tr>
                <td>Total Area :</td>
                <td>'.$result2->dag_area_b.'B-'.$result2->dag_area_k.'K-'.$result2->dag_area_lc.'L</td>
            </tr>
            <tr>
                <td>Partition Information :</td>
                <td>'.$result2->part_area_b.'B-'.$result2->part_area_k.'K-'.$result2->part_area_lc.'L</td>
            </tr>
            <tr>
                <td>Petitioner :</td>
                <td>'.$result3[0]->pdar.'</td>
            </tr>
            
            
        </table>';
        }
        else{
            $table2 = '<table style="margin-top:100px">
            <tr>
                <td>Total Area :</td>
                <td>'.$result2->dag_area_b.'B-'.$result2->dag_area_k.'K-'.$result2->dag_area_lc.'L</td>
            </tr>
            </table>';
        }


        echo $html.=$table;
        echo $html.=$table2;


        echo $html.='<p style="margin-top:50px">Acknowledgement     :   Your application with acknowledgment No. '.$result[0]->case_no.' has been successfully received.</p>';
        echo $html.='<div style="margin-top:50px;margin-left:330px"><p style="text-align: center">Regards <br><br>
                                              Sd/- <br>
                        Director of Land Records & Surveys etc., Assam<br>
                               Rupnagar, Guwahati-32 </p></div>';
        // $html.=base64_decode($jsonobj->htmlString);  
        $mpdf->writeHTML($html);
        ob_end_clean();
        echo $b64Doc = chunk_split(base64_encode($mpdf->Output('test.pdf','I')));
    }

     public function getPendingReclassNoticeGeneration() {
        $this->load->library('pagination');
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            redirect(base_url() . "index.php/home");
        } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $this->config->load('pagination_config');
            $page_config = $this->config->item('pg');
            $page_config['base_url'] = base_url() . '/index.php/SuomotoReclassification/getPendingReclassNoticeGeneration';
            //$append = $this->base_query;
            $dist_code = $this->session->userdata('dist_code');
            
            $count_query = "SELECT count(*) as c from    suomoto_reclass where notice_generated_yn is null and status='D'  and dist_code='$dist_code' ";
            $page_config['total_rows'] = $this->db->query($count_query)->row()->c;

            $this->pagination->initialize($page_config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $query ="Select * from suomoto_reclass where notice_generated_yn is null and status='D'  and dist_code='$dist_code'  ";
            $data['cases'] = $this->db->query($query)->result();
        
            $data['_view'] = 'SuomotoReclassification/reclassnoticegeneration';
            $this->load->view('layouts/main',$data);
        }
    }

    public function issueNotice() {
    if ($this->input->server('REQUEST_METHOD') == 'POST') {
        //**************validation***************/
        $om_ain = [
            [
                'field' => 'case_no',
                'label' => 'Case-No',
                'rules' => 'required|callback_check_script|max_length[50]|trim|xss_clean'
            ],
            [
                'field' => 'mouza_pargona_code',
                'label' => 'Mouza Pargona Code',
                'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
            ],
            [
                'field' => 'lot_no',
                'label' => 'Lot-No',
                'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
            ],
            [
                'field' => 'vill_townprt_code',
                'label' => 'Village-Code',
                'rules' => 'required|callback_check_script|max_length[5]|trim|xss_clean'
            ],
        ];
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_rules($om_ain);
        if ($this->form_validation->run() == FALSE)
        {   
            $error_msg = array();
            foreach($om_ain as $rule){
                if (form_error($rule['field'])) {
                    array_push($error_msg, form_error($rule['field']));
                }
            }  
            $this->session->set_flashdata('validation_msg', $error_msg);
            redirect(base_url() . "index.php/home");
            exit;
        }
        //***************************************/
        $this->db->trans_begin();  
        $case_no = $this->input->post('case_no');
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');
        $append = $this->base_query;
        $query = "update  suomoto_reclass set notice_generated_yn='Y', notice_served_yn='Y', notice_generated_date='" . date('Y-m-d G:i:s') . "' "
                . "where case_no='$case_no' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' "
                . "and vill_townprt_code = '$vill_townprt_code' ";
        $this->db->query($query);
       
        if($this->db->affected_rows() <= 0)
        {
            log_message('error', "#SRCLSAIN001:".$this->db->last_query());
            $this->db->trans_rollback();
            
            $this->session->set_flashdata('message', "Error in Notice Generation. Error Code(#SRCLSAIN001)");
            redirect(base_url() . "index.php/home");
            exit;
        }


        $proID=$this->rtpsmodel->maxProceedingID($case_no);
        $pro_array=array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'case_no'=>$case_no,
            'proceeding_id'=>$proID,
            'status'=>'pending',
            'date_of_hearing'=>date('Y-m-d'),
            'co_order'=>'Notice Generated by BO',
            'user_code'=>$this->session->userdata('user_code'),
            'date_entry'=>date('Y-m-d G:i:s'),
            'operation'=>'E',
            'ip' => $_SERVER['REMOTE_ADDR']
            );
        $insProceedRECLASS = $this->db->insert('petition_proceeding_dc_adc',$pro_array);
        if($insProceedRECLASS != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRRECLASS003: Insertion failed in petition_proceeding_dc_adc for RTPS Case No '.$case_no);
            $data = array(
                'error'=>"#ERRRECLASS003: Notice Generation of Reclassification failed for case no : ".$case_no
            );
            echo json_encode($data);
            return false;
        }



        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message('error', "#SRCLSAIN002: transaction failed in table 'suomoto_reclass' with case-no :". $case_no);
            $this->session->set_flashdata('message', "Error in Notice Generation. Error Code(#SRCLSAIN002)");
            redirect(base_url() . "index.php/home");
            exit;
        }else{
            $this->db->trans_commit();
        }   
        
        /////
        $this->session->set_flashdata(array('message' => "Notice Generated for case no : $case_no"));
        
        
        redirect(base_url() . "index.php/home");
    } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
        $case_no = $this->input->get('case_no');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $year_no = year_no;
        $detailsQuery = "select * from suomoto_reclass
                where case_no = '$case_no' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'";
        
        $details = $this->db->query($detailsQuery)->row();
        $data['details'] = $details;

        $applicantQuery = "select * from    suomoto_part_pattadar where petition_no = $details->proposal_no and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' "
                . "and vill_townprt_code = '$vill_townprt_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and case_no='$case_no' ";
        $applicants = $this->db->query($applicantQuery)->result();
        $data['applicants'] = $applicants;
        
        $notifyPerson="Select * from    suomoto_notified where petition_no = $details->proposal_no and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' "
                . "and vill_townprt_code = '$vill_townprt_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
        $data['notifyname']= $this->db->query($notifyPerson)->result();
        
        //$data['pattadars'] = $pattadars;
        $data['case_no'] = $case_no;
        // $this->load->view('../views/header');
        // $this->load->view('../views/asstofficemutation/notice', $data);
        // $this->load->view('../views/footer');
        $dist_code = $this->session->userdata('dist_code');
        if(in_array($dist_code, json_decode(BARAK_VALLEY)))
        {
           $data['_view'] = 'SuomotoReclassification/reclassnotice_kar';
        }
        else{
            $data['_view'] = 'SuomotoReclassification/reclassnotice';
        }
        //$data['_view'] = 'asstofficemutation/notice';
        $this->load->view('layouts/main',$data);
    }
}


public function getPendingNoticeGeneration() {
        $this->load->library('pagination');
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            redirect(base_url() . "index.php/home");
        } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $this->config->load('pagination_config');
            $page_config = $this->config->item('pg');
            $page_config['base_url'] = base_url() . '/index.php/officemutation/getPendingNoticeGeneration';
            $append = $this->base_query;
            
            $count_query = "SELECT count(*) as c from    Petition_basic where not_fresh='Y' and mut_type='03' and notice_generated_yn is null and $append ";
            $page_config['total_rows'] = $this->db->query($count_query)->row()->c;

            $this->pagination->initialize($page_config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $query ="Select *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree  where fmb.not_fresh='Y' and notice_generated_yn is null and fmb.mut_type='03' and fmb.status='P' and $append  order by submission_date desc  ";
            $data['cases'] = $this->db->query($query)->result();
            // $this->load->helper('html');
            // $this->load->view('../views/header');
            // $this->load->view('../views/asstofficemutation/noticegeneration', $data);
            // $this->load->view('../views/footer');
            $data['_view'] = 'asstofficemutation/noticegeneration';
            $this->load->view('layouts/main',$data);
        }
    }


    public function getPendingreclassactionTakenReport() {
        $db=  $this->session->userdata('db');
        
        $query = "Select * from suomoto_reclass WHERE  status='D' and notice_generated_yn is not null and notice_served_yn is not null and not_fresh is null ";
        $cases = $this->db->query($query)->result();
        $data['cases'] = $cases;
        
        $data['_view'] = 'SuomotoReclassification/reclassactiontakenreport';
        $this->load->view('layouts/main',$data);
    }


    public function reclasswriteNote() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $_POST['proceeding_id_n'] = $_POST['proceeding_id'][0]; 
            $_POST['note_n'] = $_POST['note'][1]; 
            //**************validation***************/
            $om_act = [
                [
                    'field' => 'case_no',
                    'label' => 'Case-No',
                    'rules' => 'required|callback_check_script|max_length[50]|trim|xss_clean'
                ],
                [
                    'field' => 'proceeding_id_n',
                    'label' => 'Proceeding Id',
                    'rules' => 'required|integer|less_than_equal_to[32,766]|greater_than_equal_to[0]'
                ],
                [
                    'field' => 'note_n',
                    'label' => 'Note',
                    'rules' => 'required|callback_check_script|trim|xss_clean'
                ],
            ];
            $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
            $this->form_validation->set_rules($om_act);
            if ($this->form_validation->run() == FALSE)
            {   
                $error_msg = array();
                foreach($om_act as $rule){
                    if (form_error($rule['field'])) {
                        array_push($error_msg, form_error($rule['field']));
                    }
                }  
                $this->session->set_flashdata('validation_msg', $error_msg);
                redirect(base_url() . "index.php/home");
                exit;
            }
            //***************************************/
            $this->db->trans_begin();  
            $notes = $this->input->post('note');
            $case_no = $this->input->post('case_no');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code'); // $location['subdiv_code'];
            $cir_code = $this->session->userdata('cir_code'); // $location['cir_code'];
            foreach ($notes as $key => $value) {
                echo $key . "=>" . $value;
                $user_code = $this->session->userdata('user_code');
                $query = "update  petition_proceeding_dc_adc set note_on_order='$value' where case_no='$case_no' and dist_code='$dist_code'  and proceeding_id=$key";
                $this->db->query($query);
                // echo $this->db->last_query();
                // exit;
                if($this->db->affected_rows() <= 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', "#OMAAT003: Updation failed in table 'petition_proceeding_dc_adc' with case-no :". $case_no);
                    $this->session->set_flashdata('message', "Error in Action Taken Report Generation. Error Code(#OMAAT003)");
                    redirect(base_url() . "index.php/home");
                    exit;
                }
                $query = "update  suomoto_reclass set not_fresh='Y' where case_no='$case_no'";
                $this->db->query($query);
                if($this->db->affected_rows() <= 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', "#OMAAT001: Updation failed in table 'petition_basic' with case-no :". $case_no);
                    $this->session->set_flashdata('message', "Error in Action Taken Report Generation. Error Code(#OMAAT001)");
                    redirect(base_url() . "index.php/home");
                    exit;
                }
                if($this->db->trans_status()==FALSE){
                    $this->db->trans_rollback();
                    log_message('error', "#OMAAT002: transaction failed in table 'petition_basic','petition_proceeding' with case-no :". $case_no);
                    $this->session->set_flashdata('message', "Error in Action Taken Report Generation. Error Code(#OMAAT002)");
                    redirect(base_url() . "index.php/home");
                    exit;
                }else{
                    $this->db->trans_commit();
                }  
                
                /////
                
            }
            $this->session->set_flashdata(array('message' => "Action taken report given for case no $case_no"));
                redirect(base_url() . "index.php/home");
        } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $dist_code = $this->input->get('dist_code');
            $subdiv_code = $this->input->get('subdiv_code'); 
            $cir_code = $this->input->get('cir_code'); 
            $mouza_pargona_code = $this->input->get('mouza_pargona_code');
            $lot_no = $this->input->get('lot_no');
            $vill_townprt_code = $this->input->get('vill_townprt_code');
            $case_no = $this->input->get('case_no');
            $data['case_no'] = $case_no;
            $dist_code_name = $this->utilityclass->getDistrictName($dist_code);
            $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,next_date_of_hearing,lm_date as date_entry,proposal_no "
                    . "from    suomoto_reclass where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    . "mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'")->row_array();
            
            $query = "select * from    petition_proceeding_dc_adc where case_no='$case_no' and dist_code='$dist_code' ";
            $details = $this->db->query($query)->result();
            $data['details'] = $details;
            
            $query1 = "select * from    suomoto_reclass where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
            $petition_basic = $this->db->query($query1)->row();
            //var_dump($petition_basic);
            $data['location'] = array(
                'dist' => $dist_code_name,
                'sub' => $subdiv_code,
                'cir' => $cir_code,
                'mouza' => $mouza_pargona_code,
                'lot' => $lot_no,
                'vill' => $vill_townprt_code,
                'case_no' => $case_no,
                'date' => $location['date_entry'],
               // 'add_to' => $location['add_off_name'],
                'case_no' => $case_no,
                'date_of_hearing' => $location['next_date_of_hearing'],
               // 'application_ref_no' => $petition_basic->application_ref_no,
            );
            $data['_view'] = 'SuomotoReclassification/reclasswritenote';
            $this->load->view('layouts/main',$data);
        }
    }


     public function reclasPayment() {
        $db=  $this->session->userdata('db');
        
        $query = "Select * from suomoto_reclass WHERE  status='B' and notice_generated_yn is not null and notice_served_yn is not null and not_fresh is not null and pay_notice_generated_yn is null ";
        $cases = $this->db->query($query)->result();
        $data['cases'] = $cases;
        
        $data['_view'] = 'SuomotoReclassification/reclasspayment';
        $this->load->view('layouts/main',$data);
    }


    public function paymentNotice() {
    if ($this->input->server('REQUEST_METHOD') == 'POST') {
        //**************validation***************/
        $om_ain = [
            [
                'field' => 'case_no',
                'label' => 'Case-No',
                'rules' => 'required|callback_check_script|max_length[50]|trim|xss_clean'
            ],
            [
                'field' => 'mouza_pargona_code',
                'label' => 'Mouza Pargona Code',
                'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
            ],
            [
                'field' => 'lot_no',
                'label' => 'Lot-No',
                'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
            ],
            [
                'field' => 'vill_townprt_code',
                'label' => 'Village-Code',
                'rules' => 'required|callback_check_script|max_length[5]|trim|xss_clean'
            ],
        ];
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_rules($om_ain);
        if ($this->form_validation->run() == FALSE)
        {   
            $error_msg = array();
            foreach($om_ain as $rule){
                if (form_error($rule['field'])) {
                    array_push($error_msg, form_error($rule['field']));
                }
            }  
            $this->session->set_flashdata('validation_msg', $error_msg);
            redirect(base_url() . "index.php/home");
            exit;
        }
        //***************************************/
        $this->db->trans_begin();  
        $case_no = $this->input->post('case_no');
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');
       // $append = $this->base_query;

        $detailsQuery = "select * from suomoto_reclass
                where case_no = '$case_no' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'";
        
        $details = $this->db->query($detailsQuery)->row();
        $data['details'] = $details;

        $query = "update  suomoto_reclass set pay_notice_generated_yn='Y' where case_no='$case_no' and dist_code='$details->dist_code' and subdiv_code='$details->subdiv_code' and cir_code='$details->cir_code' and mouza_pargona_code = '$details->mouza_pargona_code' and lot_no = '$details->lot_no' "
                . "and vill_townprt_code = '$details->vill_townprt_code' ";
        $this->db->query($query);
       
        if($this->db->affected_rows() <= 0)
        {
            log_message('error', "#SRCLSAIN001:".$this->db->last_query());
            $this->db->trans_rollback();
            
            $this->session->set_flashdata('message', "Error in Notice Generation. Error Code(#SRCLSAIN001)");
            redirect(base_url() . "index.php/home");
            exit;
        }


        $proID=$this->rtpsmodel->maxProceedingID($case_no);
        $pro_array=array(
            'dist_code' => $details->dist_code,
            'subdiv_code' => $details->subdiv_code,
            'cir_code' => $details->cir_code,
            'case_no'=>$case_no,
            'proceeding_id'=>$proID,
            'status'=>'pending',
            'date_of_hearing'=>date('Y-m-d'),
            'co_order'=>'Notice Generated by BO',
            'user_code'=>$this->session->userdata('user_code'),
            'date_entry'=>date('Y-m-d G:i:s'),
            'operation'=>'E',
            'ip' => $_SERVER['REMOTE_ADDR']
            );
        $insProceedRECLASS = $this->db->insert('petition_proceeding_dc_adc',$pro_array);
        if($insProceedRECLASS != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRRECLASS003: Insertion failed in petition_proceeding_dc_adc for RTPS Case No '.$case_no);
            $data = array(
                'error'=>"#ERRRECLASS003: Notice Generation of Reclassification failed for case no : ".$case_no
            );
            echo json_encode($data);
            return false;
        }


        $payment_array=array(
            'dist_code' => $details->dist_code,
            'subdiv_code' => $details->subdiv_code,
            'cir_code' => $details->cir_code,
            'case_no'=>$case_no,
            'entry_date' =>date('Y-m-d'),
            'status' => 'A',
            'amount' => $details->payment_amount
            );
        $insPayRECLASS = $this->db->insert('epayment_suomoto',$payment_array);
        // echo $this->db->last_query();
        if($insPayRECLASS != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRRECLASS003: Insertion failed in epayment_suomoto for Case No '.$case_no);
            $data = array(
                'error'=>"#ERRRECLASS003: Payment Notice Generation of Reclassification failed for case no : ".$case_no
            );
            echo json_encode($data);
            return false;
        }



        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message('error', "#SRCLSAIN002: transaction failed in table 'suomoto_reclass' with case-no :". $case_no);
            $this->session->set_flashdata('message', "Error in Notice Generation. Error Code(#SRCLSAIN002)");
            redirect(base_url() . "index.php/home");
            exit;
        }else{
            $this->db->trans_commit();
        }   
        
        /////
        $this->session->set_flashdata(array('message' => "Payment Notice Generated for case no : $case_no"));
        
        
        redirect(base_url() . "index.php/home");
    } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
        $case_no = $this->input->get('case_no');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $year_no = year_no;
        $detailsQuery = "select * from suomoto_reclass
                where case_no = '$case_no' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_townprt_code'";
        
        $details = $this->db->query($detailsQuery)->row();
        $data['details'] = $details;

        $applicantQuery = "select * from    suomoto_part_pattadar where petition_no = $details->proposal_no and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' "
                . "and vill_townprt_code = '$vill_townprt_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and case_no='$case_no' ";
        $applicants = $this->db->query($applicantQuery)->result();
        $data['applicants'] = $applicants;
        
        $notifyPerson="Select * from    suomoto_notified where petition_no = $details->proposal_no and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' "
                . "and vill_townprt_code = '$vill_townprt_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
        $data['notifyname']= $this->db->query($notifyPerson)->result();


        
        
        //$data['pattadars'] = $pattadars;
        $data['case_no'] = $case_no;
        // $this->load->view('../views/header');
        // $this->load->view('../views/asstofficemutation/notice', $data);
        // $this->load->view('../views/footer');
        $dist_code = $this->session->userdata('dist_code');
        if(in_array($dist_code, json_decode(BARAK_VALLEY)))
        {
           $data['_view'] = 'SuomotoReclassification/paymentnotice_kar';
        }
        else{
            $data['_view'] = 'SuomotoReclassification/paymentnotice';
        }
        //$data['_view'] = 'asstofficemutation/notice';
        $this->load->view('layouts/main',$data);
    }
}

    
    function updateChitha() {
        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $data['cases'] = $this->db->query("Select * from suomoto_reclass where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and dc_yn is not null and co_chitha_updated_yn is null and lm_code is not null")->result();
    
        $data['_view'] = 'SuomotoReclassification/pendingcofinallist';
        $this->load->view('layouts/main',$data);
    }


    Public function Finalcoorder() {
            $user_code = $this->session->userdata('user_code');
            $case_no = $this->input->GET('case_no');
            //$proposal_no = $this->input->GET('proposal_no');
            $q = "select * from suomoto_reclass where case_no = '$case_no'";
            $details = $this->db->query($q)->row();
            // echo $this->db->last_query();

            // exit;
            
            $old_patta = $this->db->query("select * from patta_code where type_code = '$details->patta_type_code' ")->row();
            //$old_land_class = $this->db->query("select * from landclass_code where class_code = '$details->present_land_class' ")->row();
            //$proposed_land_class = $this->db->query("select * from landclass_code where class_code = '$details->proposed_land_class' ")->row();

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
                'co_name' => $co->username,
                'user_code' => $user_code
            ); 
            
            // $data['det'] = array(
            //     'patta_type' => $old_patta->patta_type,
            //     'old_land_class' => $old_land_class->land_type,
            //     'proposed_land_class' => $proposed_land_class->land_type,
            //     'proposed_land_class_code' => $details->proposed_land_class
            // );
            
            $all_land_class = "Select * from landclass_code";
            $data['land_class'] = $this->db->query($all_land_class)->result();

            $data['Pcases'] = $details;

            $lmnote="select * from petition_proceeding_dc_adc where case_no='$case_no'  order by proceeding_id asc";
            $data['lmrmk']= $this->db->query($lmnote)->result();
            $data['sup_doc']=null;
            $data['sup_doc']=$this->db->query("SELECT * FROM supportive_document WHERE case_no=?", array($case_no))->result();

            $sql3="Select string_agg(pdar_name,', ') as pdar from suomoto_part_pattadar where case_no=? and dist_code=?";
            $data['part_pattadar']=$this->db->query($sql3,array($case_no,$details->dist_code))->result();


            $data['_view'] = 'SuomotoReclassification/FinalCoProcesssuomoto';
            $this->load->view('layouts/main',$data);
        }


    

    public function SaveLandReclassification() {
            $co_chitha_updated_date = date('Y-m-d G:i:s');
            $case_no = $this->input->post('case_no');
            //$proposal_no = $this->input->post('proposal_no');
            $user_code = $this->session->userdata('user_code');
            // var_dump($case_no);
           
            $this->db->trans_begin();
            $q = "select * from suomoto_reclass where case_no = '$case_no'";
            $ord = $this->db->query($q)->row();
            $proposal_no = $ord->proposal_no;
            $q1 = "select * from suomoto_reclass where dist_code = '$ord->dist_code' and subdiv_code = '$ord->subdiv_code' and cir_code = '$ord->cir_code'"
                     . "and mouza_pargona_code = '$ord->mouza_pargona_code' and vill_townprt_code = '$ord->vill_townprt_code' "
                     . "and lot_no = '$ord->lot_no' and dag_no = '$ord->dag_no' ";
            $t_result = $this->db->query($q1)->result();
            $data['Pcases'] = $ord;
            $check = "Select * from chitha_rmk_reclassification where dist_code = '$ord->dist_code' and subdiv_code = '$ord->subdiv_code' and cir_code = '$ord->cir_code'"
                     . "and mouza_pargona_code = '$ord->mouza_pargona_code' and vill_townprt_code = '$ord->vill_townprt_code' "
                     . "and lot_no = '$ord->lot_no' and dag_no = '$ord->dag_no' ";
            $check_presence = $this->db->query($check)->result();
            $counted = count($check_presence);
            $lineNo = "select max(rmk_line_no)+1 as max from jama_remark where dist_code='$ord->dist_code' and"
                    . " subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code' and mouza_pargona_code='$ord->mouza_pargona_code' and "
                    . "  lot_no='$ord->lot_no' and vill_townprt_code='$ord->vill_townprt_code' and patta_type_code='$ord->patta_type_code' and "
                    . " TRIM(patta_no)=trim('$ord->patta_no')";

            $line_no = $this->db->query($lineNo)->row()->max;
            if ($line_no == null) {
                $line_no = 1;
            }
            $remark31="";
            ///////////////////
            $rmk_type_hist_no=null;
            $q = "SELECT count(*) as c FROM chitha_rmk_gen where dist_code = '$ord->dist_code' and subdiv_code = '$ord->subdiv_code' and cir_code = '$ord->cir_code'"
                 . "and mouza_pargona_code = '$ord->mouza_pargona_code' and vill_townprt_code = '$ord->vill_townprt_code' "
                 . "and lot_no = '$ord->lot_no' and dag_no = '$ord->dag_no'";               
            $rmk_type_hist_no = $this->db->query($q)->row()->c;
            if($rmk_type_hist_no==null)
                $rmk_type_hist_no=1;
            else
                $rmk_type_hist_no=$rmk_type_hist_no+1;
            ///////////////////
            if ($check_presence == null) {
                $rmk_gen = array(
                    'dist_code'=>$ord->dist_code,
                    'subdiv_code'=>$ord->subdiv_code,
                    'cir_code'=>$ord->cir_code,
                    'mouza_pargona_code'=>$ord->mouza_pargona_code,
                    'vill_townprt_code'=>$ord->vill_townprt_code,
                    'lot_no'=>$ord->lot_no,
                    'dag_no'=>$ord->dag_no,
                    'rmk_type_code'=>'08',
                    'rmk_type_hist_no'=>$rmk_type_hist_no,
                    'user_code'=>$user_code,
                    'operation'=>'E',
                    'date_entry'=>date('Y-m-d G:i:s'),
                    'jama_updated'=>null,
                    'patta_no'=>trim($ord->patta_no)
                );
                //var_dump($rmk_gen);
                $tstatus1=$this->db->insert('chitha_rmk_gen',$rmk_gen); //*********************
                if ($tstatus1 != 1 )
                {
                   $this->db->trans_rollback();
                   log_message('error',$this->db->last_query());
                   $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#RECLASS001)");
                   redirect(base_url() . "index.php/home");
                }
            }   
            $remark31 .= "<u class='text-danger'>হুকুম নং : ".$rmk_type_hist_no." </u><br>";
            $remark31 .=  $case_no;
           // $remark31 .= " শ্রেণী সংশোধনীকৰণ প্রস্তাব  " . $user_code. " মহোদয়ে  " . date('Y-m-d G:i:s');
            $remark31 .= " শ্রেণী সংশোধনীকৰণ প্রস্তাব  উপায়ুক্ত মহোদয়ে  " . date('Y-m-d G:i:s');
            $remark31 .= "  তাৰিখে দিয়া অনুমোদন মৰ্মে  " . $ord->patta_no;
            $remark31 .= "  নং পট্টাৰ  " . $ord->dag_no . "  নং দাগৰ শ্রেণী  " . $this->utilityclass->getLandClassCode($ord->exist_land_class) . "'ৰ  পৰা  " . $this->utilityclass->getLandClassCode($ord->present_land_class);
            $remark31 .= "  লৈ পৰিবৰ্তন কৰা হ'ল । ";
            $remarkData = array(
                    'dist_code' => $ord->dist_code,
                    'subdiv_code' => $ord->subdiv_code,
                    'cir_code' => $ord->cir_code,
                    'mouza_pargona_code' => $ord->mouza_pargona_code,
                    'lot_no' => $ord->lot_no,
                    'vill_townprt_code' => $ord->vill_townprt_code,
                    'patta_no' => $ord->patta_no,
                    'patta_type_code' => $ord->patta_type_code,
                    'rmk_line_no' => $line_no++,
                    'remark' => $remark31,
                    'user_code' => $user_code,
                    'entry_date' => date('Y-m-d'),
                    'entry_mode' => 'U'
            );
            $tstatus2=$this->db->insert('jama_remark', $remarkData);
            //.......................
            if ($tstatus2 != 1 )
            {
               $this->db->trans_rollback();
               log_message('error',$this->db->last_query());
               $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#RECLASS002)");
               redirect(base_url() . "index.php/home");
            }
            $q3 = "SELECT * FROM chitha_rmk_reclassification where dist_code = '$ord->dist_code' and subdiv_code = '$ord->subdiv_code' and cir_code = '$ord->cir_code'"
                 . "and mouza_pargona_code = '$ord->mouza_pargona_code' and vill_townprt_code = '$ord->vill_townprt_code' "
                 . "and lot_no = '$ord->lot_no' and dag_no = '$ord->dag_no' and proposal_no='$proposal_no'";        
            $rmkexist = $this->db->query($q3)->num_rows(); 
            //echo $this->db->last_query();
            //$rmkexisted =   count($rmkexist);
            if ($rmkexist==0) {
                $chitha_rmk_reclassification = array(
                    'dist_code' => $ord->dist_code,
                    'subdiv_code' => $ord->subdiv_code,
                    'cir_code' => $ord->cir_code,
                    'mouza_pargona_code' => $ord->mouza_pargona_code,
                    'lot_no' => $ord->lot_no,
                    'vill_townprt_code' => $ord->vill_townprt_code,
                    'proposal_no' => $proposal_no,
                    'dag_no' => $ord->dag_no,
                    'patta_no' => trim($ord->patta_no),
                    'patta_type_code' => $ord->patta_type_code,
                    'present_land_class' => $ord->exist_land_class,
                    //'present_land_revenue' => $ord->present_land_revenue,
                    //'present_land_localtax' => $ord->present_land_localtax,
                    //'present_total_revenue' => $ord->present_total_revenue,
                    //'new_landuse_year' => $ord->new_landuse_year,
                    'dag_area_b' => $ord->dag_area_b,
                    'dag_area_k' => $ord->dag_area_k,
                    'dag_area_lc' => $ord->dag_area_lc,
                    'dag_area_g' => $ord->dag_area_g,
                    'dag_area_kr' => $ord->dag_area_kr,
                    'proposed_land_class' => $ord->present_land_class,
                    //'proposed_land_revenue' => $ord->proposed_land_revenue,
                    //'proposed_land_localtax' => $ord->proposed_land_localtax,
                   // 'revenue_diff' => $ord->revenue_diff,
                    'lm_code' => $ord->lm_code,
                    'lm_yn' => $ord->lm_yn,
                    'lm_date' => $ord->lm_date,
                    'case_no' => $case_no,
                    'co_recommendation' => $ord->co_recommendation,
                    'co_recom_date' => $ord->co_recom_date,
                    'co_yn' => $ord->co_yn,
                    'co_date' => $ord->co_date,
                    'dc_approval'  => $ord->dc_approval,
                   // 'dc_approval_date' => $ord->dc_approval_date,
                    'dc_yn' => $ord->dc_yn,
                    'dc_date' => $ord->dc_date,
                    'rkg_chitha_updated_yn' => 'Y',
                    'rkg_chitha_updated_date'  => $co_chitha_updated_date,
                    //'rkg_transmit_yn' => '',
                    'co_chitha_updated_yn' => 'Y',
                    'co_chitha_updated_date'  => $co_chitha_updated_date,
                    //'make_mdb' => ord->,
                    // 'self_declaration' => $ord->self_declaration,
                    // 'id_ref_no' => $ord->id_ref_no,
                    // 'auth_type' => $ord->auth_type,
                    // 'photo' => $ord->photo

                );
                //var_dump($chitha_rmk_reclassification);
              $tstatus3=$this->db->insert('chitha_rmk_reclassification', $chitha_rmk_reclassification);  
              if ($tstatus3 != 1 )
                {
                   $this->db->trans_rollback();
                   log_message('error',$this->db->last_query());
                   $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#RECLASS002)");
                   redirect(base_url() . "index.php/home");
                }
            }
            $jama_dag = "update jama_dag set dag_class_code='$ord->present_land_class' where dist_code='$ord->dist_code' and"
                    . " subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
                    . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
                    . " vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no'  "
                    . " and TRIM(patta_no)=trim('$ord->patta_no') and patta_type_code='$ord->patta_type_code'";
            $tstatus4=$this->db->query($jama_dag);
            if ($tstatus4 != 1 )
            {
               $this->db->trans_rollback();
               log_message('error',$this->db->last_query());
               $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#RECLASS004)");
               redirect(base_url() . "index.php/home");
            }       
            // $chitha_update = "update chitha_basic set land_class_code='$ord->present_land_class',jama_yn=' ' where dist_code='$ord->dist_code' and"
            //         . " subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
            //         . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
            //         . " vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no'  "
            //         . " and TRIM(patta_no)=trim('$ord->patta_no') and patta_type_code='$ord->patta_type_code'";
            // $tstatus5=$this->db->query($chitha_update);  //*********************
            $table = 'chitha_basic';
            $params = [
                'land_class_code' => $ord->present_land_class,
                'jama_yn'         => ' ',
            ];
            $where = [
                'dist_code'          => $ord->dist_code,
                'subdiv_code'        => $ord->subdiv_code,
                'cir_code'           => $ord->cir_code,
                'lot_no'             => $ord->lot_no,
                'mouza_pargona_code' => $ord->mouza_pargona_code,
                'vill_townprt_code'  => $ord->vill_townprt_code,
                'dag_no'             => $ord->dag_no,
                'patta_no'           => trim($ord->patta_no),  // TRIM equivalent
                'patta_type_code'    => $ord->patta_type_code,
            ];
            $tstatus5 = $this->Chitha_basic_model->update_table($table, $params, $where);

            if ($tstatus5 != 1 )
            {
               $this->db->trans_rollback();
               log_message('error',$this->db->last_query());
               $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#RECLASS005)");
               redirect(base_url() . "index.php/home");
            }
            //chitha pattadar aadhar updation --------------
            
           // log_message('error',$auth_type);
            log_message('error',$ord->patta_no);
            log_message('error',$ord->patta_type_code);
            //log_message('error',$ref_no);
           // log_message('error',$photo);
            log_message('error',$ord->pdar_id);
            $pdar_id_aadhar = $ord->pdar_id;
            
            $this->db->query("UPDATE suomoto_reclass SET co_chitha_updated_yn = 'Y', co_chitha_updated_date = '$co_chitha_updated_date',"
                    . "rkg_chitha_updated_yn = 'Y', rkg_chitha_updated_date = '$co_chitha_updated_date',status='F' WHERE case_no = '$case_no' and  proposal_no = '$proposal_no'");
            if ($this->db->affected_rows()!= 1 )
            {
               $this->db->trans_rollback();
               log_message('error',$this->db->last_query());
               $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#RECLASS006)");
               redirect(base_url() . "index.php/home");
            }
            ////////
           // $this->DashboardDataFinal($case_no);
            //////
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo "Error Occured";
            } 

            else {
                $this->db->trans_commit();
                $this->session->set_flashdata('message',"Circle Officer's Report on Reclassification Case no with case no $case_no ");
                // echo "string";die;
                //////////////////////////////////
                $data=array(
                    'success'=>"Circle Officer's Report on Reclassification Case no $case_no",
                    'redirect_url'=>base_url().'index.php/home'
                );
                //redirect(base_url() . "index.php/home");
                
            }
             echo json_encode($data);
        } 

        public function reclasPaymentConfirm() {
        $db=  $this->session->userdata('db');
        
        $query = "Select * from suomoto_reclass WHERE  status='B' and notice_generated_yn is not null and notice_served_yn is not null and not_fresh is not null and pay_notice_generated_yn is not null ";
        $cases = $this->db->query($query)->result();
        $data['cases'] = $cases;
        
        $data['_view'] = 'SuomotoReclassification/reclasspaymentConfirm';
        $this->load->view('layouts/main',$data);
        }


        Public function paymentConfirm() {
            $user_code = $this->session->userdata('user_code');
            $case_no = $this->input->GET('case_no');
            //$proposal_no = $this->input->GET('proposal_no');
            $q = "select sr.*,es.* from suomoto_reclass sr join epayment_suomoto es on sr.case_no=es.case_no where sr.case_no = '$case_no' and sr.pay_notice_generated_yn is not null ";
            $data['details']=$details = $this->db->query($q)->row();


            $dist_code = $this->utilityclass->getDistrictName($details->dist_code);
            $subdiv_code = $this->utilityclass->getSubDivName($details->dist_code, $details->subdiv_code);
            $cir_code = $this->utilityclass->getCircleName($details->dist_code, $details->subdiv_code, $details->cir_code);
            $mouza_pargona_code = $this->utilityclass->getMouzaName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code);
            $lot_no = $this->utilityclass->getLotName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no);
            $vill_townprt_code = $this->utilityclass->getVillageName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no, $details->vill_townprt_code);
            $data['location'] = array(
                'dist' => $dist_code,
                'sub' => $subdiv_code,
                'cir' => $cir_code,
                'mouza' => $mouza_pargona_code,
                'lot' => $lot_no,
                'vill' => $vill_townprt_code,
            ); 



            $data['_view'] = 'SuomotoReclassification/paymentconfirm_bo';
            $this->load->view('layouts/main',$data);
        }


    function getPaymentReclass()
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);     
        $error=array();
        $dist_code=$jsonArray['dist_code']; 
        if(isset($jsonArray['dist_code']) && $jsonArray['dist_code'] == '' || !isset($jsonArray['dist_code'])){
            echo json_encode(array('responseType' => 1,'message' => 'distcode is required'));
            return;
        }
        $this->dbswitch($dist_code);

        $case_no=$jsonArray['case_no']; 

        if(isset($jsonArray['case_no']) && $jsonArray['case_no'] == '' || !isset($jsonArray['case_no'])){
            echo json_encode(array('responseType' => 1,'message' => 'distcode is required'));
            return;
        }

        $sql = "select * from suomoto_reclass where case_no='$case_no' ";
        $query = $this->db->query($sql);
        $num_rows = $query->num_rows();
        if($num_rows != 1){
            echo json_encode(array('responseType' => 1,'message' => 'Case No is not valid!!'));
            return;
        }

        else{

        $reclass_data = $query->row();
       // var_dump($reclass_data->case_no);exit;

        $sql_payment = "select sr.dist_code,sr.subdiv_code,sr.cir_code,sr.mouza_pargona_code,sr.lot_no,sr.vill_townprt_code,es.* from suomoto_reclass 
            sr join epayment_suomoto es on sr.case_no=es.case_no where sr.case_no = '$reclass_data->case_no' and sr.pay_notice_generated_yn is not null and es.status='A' ";



        $query2 = $this->db->query($sql_payment);
        $num_rows = $query2->num_rows();
        if($num_rows != 1){
            echo json_encode(array('responseType' => 1,'message' => 'Payment is not initiated yet!!'));
            return;
        }

        else{
         $payment_data = $query2->row();

         echo json_encode(array(
            'responseType' => 2,
            'data'=>$payment_data,
            'message' => 'Payment is Validated!!'
         ));
        }

        }
    }

    function paymentConfirmP()
    {
        $this->session->set_flashdata('success', 'Payment confirmed successfully!');
        redirect('SuomotoReclassification/reclasPaymentConfirm');
    }



}
