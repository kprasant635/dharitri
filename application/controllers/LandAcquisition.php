<?php

class LandAcquisition extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
        $this->load->model('patta/pattamodel');
        $this->load->library('form_validation');
    }

    function register() {
		 $db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouza = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lot = $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $district['vill'] = $this->mutationmodel->getVillageCodeJSON($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);

        $district['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name,
            'mouza_name' => $mouza,
            'mouza_code' => $mouza_pargona_code,
            'lot_no' => $lot,
            'lot_code' => $lot_no,
        );
        
        $query = "select type_code,patta_type from    patta_code where mutation='a' ";
        $district['pattatype'] = $this->db->query($query)->result();

        $this->load->helper('html');
        $this->load->view('../views/header');
        $this->load->view('../views/LandAcquisition/register', $district);
        $this->load->view('../views/footer');
    }
    
    public function officername($designation,$distcode,$subdivcode,$circode) {
		 $db=  $this->session->userdata('db');
        if($designation == 'CO'){
            $users = $this->db->query("Select distinct(users.username) as username, users.user_desig_code as user_desig_code, loginuser_table.user_code as user_code from    users,"
                    . "loginuser_table where users.dist_code = loginuser_table.dist_code and users.user_code = loginuser_table.user_code and users.user_desig_code = '$designation' "
                    . "and users.dist_code='$distcode' and users.subdiv_code='$subdivcode' and users.cir_code='$circode'");
        }
        
        if ($designation == 'DC'){
            $users = $this->db->query("Select distinct(users.username) as username, users.user_desig_code as user_desig_code, loginuser_table.user_code as user_code from    users,"
                    . "loginuser_table where users.dist_code = loginuser_table.dist_code and users.user_code = loginuser_table.user_code and users.user_desig_code = '$designation' "
                    . "and users.dist_code='$distcode'");
        }
        
        if ($designation == 'ADC'){
            $users = $this->db->query("Select distinct(users.username) as username, users.user_desig_code as user_desig_code, loginuser_table.user_code as user_code from    users,"
                    . "loginuser_table where users.dist_code = loginuser_table.dist_code and users.user_code = loginuser_table.user_code and users.user_desig_code = '$designation' "
                    . "and users.dist_code='$distcode'");
        }
        $data = $users->result();
        $json = array();
        //var_dump($data);
        foreach ($data as $object) {
            $json[] = array('username' => $object->username);
        }
        echo json_encode($json);
    }
    
    function report() {
		 $db=  $this->session->userdata('db');
        //var_dump($this->input->post());
        $this->db->trans_begin();
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('circle_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');
        $mouza_pargona_code = $this->input->post('mouza_code');
        
        $q="Select dist_abbr,cir_abbr from    location where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code!='00' ";
        $abbrname=$this->db->query($q)->row();
        $cir_dist_name=$abbrname->dist_abbr."/".$abbrname->cir_abbr;
        
        $year_no = year_no;
        $define_date = define_date;
        $date_entry = date('Y-m-d G:i:s');
		
        $petition_no = $this->db->query("select max(petition_no) as count from    land_acquisition_basic where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' "
                . "and cir_code = '$cir_code' ")->row()->count;
        
        if ($petition_no == null) {
            $petition_no = 1;
        } else {
            $petition_no+=1;
        }
        $petition_no_case = $this->db->query("select count(petition_no) as petition_no from    land_acquisition_basic where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' "
                . "and cir_code = '$cir_code' and date(date_entry) >='$define_date' and year_no='$year_no'")->row()->petition_no;
        
        $petition_no_case = $petition_no_case + 1;
        $financialyeardate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('y') : date('Y') . "-" . date('y', strtotime('+1 year'));

        $check_status = TRUE;

        while($check_status == TRUE){
                $case_no = $cir_dist_name."/".$financialyeardate."/".$petition_no_case."/LA";
                $check_existance = $this->db->query("select count(*) as c from    petition_basic where case_no='$case_no'")->row()->c;
                if($check_existance<='0'){
                        $case_no = $cir_dist_name."/".$financialyeardate."/".$petition_no_case."/LA";
                        $check_status = FALSE;
                }
                else{
                        $petition_no_case = $petition_no_case+1;
                }
        }
                
        $petition_basic = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_code,
            'year_no' => $year_no,
            'petition_no' => $petition_no,
            'case_no' => $case_no,
            'submission_date' => $this->input->post('order_date'),
            'add_off_name' => $this->input->post('officername'),
            'add_off_desig' => $this->input->post('designation'),
            'supported_doc' => 'Y',
            'document' => $this->input->post('file_upload'),
            'remarks' => $this->input->post('note_on_action'),
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => $date_entry,
            'operation' => 'E',
            'status' => 'P',
            //'co_user_code' => $add_of_co_code,
        );
        //var_dump($petition_basic);
        $this->db->insert('land_acquisition_basic', $petition_basic);//**********************
        $dag_no_int = $this->input->post('dag_no');
        $patta_type_code = $this->input->post('patta_type');
        $patta_no = $this->input->post('patta_no');
        $get_dag_no = $this->db->query("Select dag_no as dag_no from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code = '$mouza_pargona_code' "
                . "and lot_no = '$lot_no' and vill_townprt_code = '$vill_code' and dag_no_int = '$dag_no_int' and patta_no = '$patta_no' and patta_type_code = '$patta_type_code' ")->row()->dag_no;
        
        $dags_data = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_code,
            'year_no' => $year_no,
            'petition_no' => $petition_no,
            'm_dag_area_b' => $this->input->post('m_dag_area_b'),
            'm_dag_area_k' => $this->input->post('m_dag_area_k'),
            'm_dag_area_lc' => $this->input->post('m_dag_area_lc'),
            'dag_area_b' => $this->input->post('dag_area_b'),
            'dag_area_k' => $this->input->post('dag_area_k'),
            'dag_area_lc' => $this->input->post('dag_area_lc'),
            'patta_no' => trim($this->input->post('patta_no')),
            'patta_type_code' => $this->input->post('patta_type'),
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' =>$date_entry,
            'operation' => 'E',
            'dag_no' => $get_dag_no,
        );
        //var_dump($dags_data); 
        $this->db->insert('land_acquisition_dag_details', $dags_data);//**********************
        //exit();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', "Land Acquisition Case $case_no Successfully Submitted !!");
            redirect('/home/');
        }
    }

    function copending() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $q = "Select * from    land_acquisition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  status = 'P' ";
        $data['land_acquisition'] = $this->db->query($q)->result();
        //var_dump($data);
        $this->load->helper('html');
        $this->load->view('../views/header');
        $this->load->view('../views/LandAcquisition/copending', $data);
        $this->load->view('../views/footer');
    }
    
    public function FinalOOrder() {
        $data = array();
        $case_no = $this->input->get('case_no');
        $dist_code1 = $this->session->userdata('dist_code');
        $subdiv_code1 = $this->session->userdata('subdiv_code');
        $cir_code1 = $this->session->userdata('cir_code');
        $mouza_pargona_code1 = $this->input->get('mouza_pargona_code');
        $lot_no1 = $this->input->get('lot_no');
        $vill_townprt_code1 = $this->input->get('vill_townprt_code');
        $mutation_type = $this->input->get('mut_type');

        $case_details = $this->db->query("select * from    land_acquisition_basic d where d.case_no='$case_no' and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and "
                . "cir_code='$cir_code1' and mouza_pargona_code = '$mouza_pargona_code1' and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1'")->result();
        $data['case_details'] = $case_details;
        
        $petition_no = $case_details[0]->petition_no;

        $details = array(
            'case_no' => $case_details[0]->case_no, 'petition_no' => $case_details[0]->petition_no
        );
        $this->session->set_userdata($details);

        $dag_details = $this->db->query("select * from    land_acquisition_dag_details d where d.petition_no='$petition_no' and dist_code='$dist_code1' and subdiv_code='$subdiv_code1' and cir_code='$cir_code1' "
                        . "and mouza_pargona_code = '$mouza_pargona_code1' and lot_no = '$lot_no1' and vill_townprt_code = '$vill_townprt_code1'")->result();
        $data['dag_details'] = $dag_details;
        
       
        $data['case_no'] = $case_no;
        $data['dist_code'] = $dist_code1;
        $data['subdiv_code'] = $subdiv_code1;
        $data['cir_code'] = $cir_code1;
        $data['mouza_pargona_code'] = $mouza_pargona_code1;
        $data['lot_no'] = $lot_no1;
        $data['vill_townprt_code'] = $vill_townprt_code1;

        $dist_code = $this->utilityclass->getDistrictName($dist_code1);
        $subdiv_code = $this->utilityclass->getSubDivName($dist_code1, $subdiv_code1);
        $cir_code = $this->utilityclass->getCircleName($dist_code1, $subdiv_code1, $cir_code1);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($dist_code1, $subdiv_code1, $cir_code1, $mouza_pargona_code1);
        $lot_no = $this->utilityclass->getLotName($dist_code1, $subdiv_code1, $cir_code1, $mouza_pargona_code1, $lot_no1);
        $vill_townprt_code = $this->utilityclass->getVillageName($dist_code1, $subdiv_code1, $cir_code1, $mouza_pargona_code1, $lot_no1, $vill_townprt_code1);
        $data['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code
        );
        
        $patt_type = $this->mutationmodel->getGovtPattaType();
        $data['govt_patta_type'] = $patt_type;
        //var_dump($data);
        $this->load->helper('html');
        $this->load->view('../views/header');
        $this->load->view('../views/LandAcquisition/CaseDetails', $data);
        $this->load->view('../views/footer');
    }
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    

    function dagexist($d, $s, $c, $m, $l, $v, $nd) {
        $q = "Select count(*) as c from    chitha_basic where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$m' and 
				lot_no='$l' and vill_townprt_code='$v' and dag_no='$nd' ";
        $data = $this->db->query($q)->row()->c;
        if ($data) {
            $dag = 1;
            $msg = 'Dag Number exist';
        } else {
            $dag = 0;
            $msg = 'Success';
        }
        $json = array(
            'exist' => $dag,
            'msg' => $msg
        );
        echo json_encode($json);
    }

    

    function Update() {
        
        $petition_no = $this->session->userdata('petition_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $case_no = $this->session->userdata('case_no');
        
        $govt_land_dag = trim($this->input->post('new_dag_no'));
        $govt_land_type = trim($this->input->post('new_land_class'));
        $govt_patta_type = trim($this->input->post('new_patta_type'));
        $new_patta_no = trim($this->input->post('new_patta_no'));
        
        $q = "Select * from    land_acquisition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and case_no='$case_no' and petition_no='$petition_no' ";
        $row = $this->db->query($q)->result();
        
        foreach ($row as $data){
            $update = "Update land_acquisition_dag_details set govt_land_dag = '$govt_land_dag',govt_land_type='$govt_land_type',govt_patta_type='$govt_patta_type' where "
                    . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$data->mouza_pargona_code' and "
                    . "lot_no='$data->lot_no' and vill_townprt_code='$data->vill_townprt_code' and petition_no='$petition_no' ";//and case_no='$case_no' 
            $this->db->query($update);
        }
        $this->db->trans_begin();
        $chitha_update = $this->AutoUpdate($data->dist_code, $data->subdiv_code, $data->cir_code, $data->mouza_pargona_code, $data->lot_no, $data->vill_townprt_code, $data->petition_no, $data->case_no);
        
        if ($this->db->trans_status() == FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata("message", "Case Cannot Be Passed. Contact Help Desk with Location Details");
            redirect(base_url() . "index.php/home");
        } else {
            $this->db->trans_commit();
            $jama_update = $this->AutoJamabandi($data->dist_code, $data->subdiv_code, $data->cir_code, $data->mouza_pargona_code, $data->lot_no, $data->vill_townprt_code, $data->petition_no, $data->case_no);
            //$this->session->set_flashdata("message", "Land Acquisition Case " . $case_no . " Passed Successfully.");
            //redirect(base_url() . "index.php/home");
        }
        
    }

    // we will not do multiple cause for multiple we will have to have multiple order which is difficult
    public function AutoUpdate($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $petition_no, $case_no) {

        $dag_details = "select * from    land_acquisition_dag_details where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and petition_no='$petition_no'";
        $result = $this->db->query($dag_details)->result();
        
        //$this->db->trans_begin();
        $chitha_basic_update = 0;
        foreach ($result as $d) {
            $landclasscode = $d->govt_land_type; // should be  শ্ৰেণী নাই 
            $new_patta_no = '0'; // govt patta should be always 0
            $new_patta_type = $d->govt_patta_type; 
            $new_dag_no = TRIM($d->govt_land_dag);
            
            // for chitha update and insert
            if ($chitha_basic_update == 0) {
                $chitha_basic = array(
                    'dist_code' => $d->dist_code,
                    'subdiv_code' => $d->subdiv_code,
                    'cir_code' => $d->cir_code,
                    'mouza_pargona_code' => $d->mouza_pargona_code,
                    'lot_no' => $d->lot_no,
                    'vill_townprt_code' => $d->vill_townprt_code,
                    'old_dag_no' => $d->dag_no,
                    'dag_no' => $new_dag_no,
                    'dag_no_int' => $new_dag_no.'00',
                    'patta_type_code' => $new_patta_type,
                    'patta_no' =>  $new_patta_no,
                    'land_class_code' => $landclasscode,
                    'dag_area_b' => $d->m_dag_area_b,
                    'dag_area_k' => $d->m_dag_area_k,
                    'dag_area_lc' => $d->m_dag_area_lc,
                    'dag_area_g' => 0.0,
                    'dag_area_kr' => 0,
                    'dag_revenue' => 0.00,
                    'dag_local_tax' => 0.00,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'B',
                    'jama_yn' => 'n',
                    'old_patta_no' => trim($d->patta_no)
                );
                
                if ($d->dag_no == $d->govt_land_dag) {
                    //echo "this is when the whole portion of that land is taken by the govt.<br>";
                    $chitha_update = "update chitha_basic set patta_no='$new_patta_no',jama_yn='n',land_class_code='$landclasscode',dag_area_b='$d->m_dag_area_b',"
                            . "dag_area_k='$d->m_dag_area_k',dag_area_lc='$d->m_dag_area_lc',dag_revenue = '0.00',dag_local_tax ='0.00' where dist_code='$d->dist_code' and "
                            . "subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code' and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
                            . "vill_townprt_code='$d->vill_townprt_code' and dag_no='$d->dag_no' and TRIM(patta_no)=trim('$d->patta_no') and patta_type_code='$d->patta_type_code'";
                    
                    echo $chitha_update;
                    //$this->db->query($chitha_update);
                } else {
                    //echo "this is when the new entry in chitha.<br>";
                    //var_dump($chitha_basic);
                    // $this->db->insert('chitha_basic', $chitha_basic);
                    $this->Chitha_basic_model->insert_table('chitha_basic',$chitha_basic);
                    
                    $landArea_query = "select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,dag_revenue,dag_local_tax from    chitha_basic where dist_code='$d->dist_code' and "
                            . "subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code' and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
                            . "vill_townprt_code='$d->vill_townprt_code' and dag_no='$d->dag_no' and TRIM(patta_no)=trim('$d->patta_no') and patta_type_code='$d->patta_type_code'";
                
                    $sourceB = $this->db->query($landArea_query)->row()->dag_area_b;
                    $sourceK = $this->db->query($landArea_query)->row()->dag_area_k;
                    $sourceL = $this->db->query($landArea_query)->row()->dag_area_lc;
                    $sourceRev = $this->db->query($landArea_query)->row()->dag_revenue;
                    $sourceLTax = $this->db->query($landArea_query)->row()->dag_local_tax;
                    $sourceLessa = $sourceB * 100 + $sourceK * 20 + $sourceL;
                    $targetLessa = $d->m_dag_area_b * 100 + $d->m_dag_area_k * 20 + $d->m_dag_area_lc;
                    $remLessa = $sourceLessa - $targetLessa;
                    $new_revenue = ($sourceRev / $sourceLessa) * $remLessa;
                    $new_local_tax = ($new_revenue / 4);
                    $b = floor($remLessa / 100.0);
                    $k = ($remLessa - $b * 100.0) / 20.0; //0
                    $k = floor($k);
                    $lc = ($remLessa - $b * 100.0 - $k * 20.0);
                    $g = 0.0;
                    $kr = 0.0;
                    $dag_no_int = $d->dag_no . "00";
                    
                    //echo "this is when updating the old dag in chitha.<br><br>";
                    $chitha_update = "update chitha_basic set dag_area_b='$b',dag_area_k='$k', dag_area_lc='$lc',dag_area_g='$g',dag_area_kr='$kr',dag_revenue='$new_revenue',"
                            . "dag_local_tax='$new_local_tax',jama_yn='n'  where dist_code='$d->dist_code' and subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code' and lot_no='$d->lot_no' "
                            . "and mouza_pargona_code='$d->mouza_pargona_code' and vill_townprt_code='$d->vill_townprt_code' and dag_no='$d->dag_no' and dag_no_int=$dag_no_int "
                            . "and TRIM(patta_no)=trim('$d->patta_no') and patta_type_code='$d->patta_type_code'";
                    
                    //echo $chitha_update;
                    $this->db->query($chitha_update);
                    
                }
                $chitha_basic_update = 1;
            }
            // end chitha update and insert
            
            //pattadar chitha update and insert
            $q = "select pdar_id as pdar_id from    chitha_pattadar  where dist_code='$d->dist_code' and subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code' "
                    . "and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and vill_townprt_code='$d->vill_townprt_code' and TRIM(patta_no)=trim('$new_patta_no') "
                    . "and patta_type_code='$new_patta_type' ";
            $pdar_id = $this->db->query($q)->row()->pdar_id;
            
            $remarks = $this->db->query("select remarks as rmk from    land_acquisition_basic where  dist_code='$d->dist_code' and subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code' "
                    . "and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and vill_townprt_code='$d->vill_townprt_code' and petition_no='$petition_no' and "
                    . "case_no = '$case_no' ")->row()->rmk;
             
            $backlogorder = array(
                'dist_code' => $d->dist_code,
                'subdiv_code' => $d->subdiv_code,
                'cir_code' => $d->cir_code,
                'mouza_pargona_code' => $d->mouza_pargona_code,
                'lot_no' => $d->lot_no,
                'vill_townprt_code' => $d->vill_townprt_code,
                'patta_no' => trim($new_patta_no),
                'dag_no' => $new_dag_no,
                'patta_type_code' => $new_patta_type,
                'dag_no_int' => $new_dag_no.'00',
                'remark' => $remarks,
                'category' => '2',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d G:i:s'),
            );
            
            if (($d->dag_no == $d->govt_land_dag)) {
                
                $delete_chitha_dag_pattadar = "select * chitha_dag_pattadar where dist_code='$d->dist_code' and subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code' and "
                        . "lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and vill_townprt_code='$d->vill_townprt_code' and dag_no='$d->dag_no' "
                        . "and TRIM(patta_no)=trim('$d->patta_no') and patta_type_code='$d->patta_type_code' and pdar_id!='$pdar_id'";
                echo $delete_chitha_dag_pattadar;
                //echo $this->db->query($delete_chitha_dag_pattadar);
                
                $check = "select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln,d.p_flag from    chitha_pattadar p join 
            chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
            and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
            p.pdar_id = d.pdar_id and trim(p.patta_no) = trim(d.patta_no) where p.dist_code='$d->dist_code' and p.subdiv_code='$d->subdiv_code' and p.cir_code='$d->cir_code' and
            p.mouza_pargona_code='$d->mouza_pargona_code' and p.vill_townprt_code='$d->vill_townprt_code' 
            and d.lot_no='$d->lot_no' and d.dag_no='$d->dag_no' and trim(p.patta_no)='$d->patta_no' and p.patta_type_code='$d->patta_type_code'";
                
                $exist = $this->db->query($q)->row();
                if ($exist == null) {
                    $delete_chitha_pattadar = "select * chitha_dag_pattadar where dist_code='$d->dist_code' and subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code' and "
                        . "lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and vill_townprt_code='$d->vill_townprt_code' and dag_no='$d->dag_no' "
                        . "and TRIM(patta_no)=trim('$d->patta_no') and patta_type_code='$d->patta_type_code' and pdar_id ='$pdar_id'";
                    echo $delete_chitha_pattadar;
                    //echo $this->db->query($delete_chitha_pattadar);
                }
                
               
                
            } else {
                $dag_pattadar = array(
                    'dist_code' => $d->dist_code,
                    'subdiv_code' => $d->subdiv_code,
                    'cir_code' => $d->cir_code,
                    'mouza_pargona_code' => $d->mouza_pargona_code,
                    'lot_no' => $d->lot_no,
                    'vill_townprt_code' => $d->vill_townprt_code,
                    'pdar_id' => $pdar_id,
                    'patta_no' => trim($new_patta_no),
                    'dag_no' => $new_dag_no,
                    'patta_type_code' => $new_patta_type,
                    'dag_por_b' => $d->m_dag_area_b,
                    'dag_por_k' => $d->m_dag_area_k,
                    'dag_por_lc' => $d->m_dag_area_lc,
                    'dag_por_g' => 0.0,
                    'dag_por_kr' => 0,
                    'pdar_land_revenue' => 0.00,
                    'pdar_land_localtax' => 0.00,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'B',
                    'p_flag' => '0',
                    'jama_yn' => 'n'
                );
                //var_dump($dag_pattadar);
                // $this->db->insert('chitha_dag_pattadar', $dag_pattadar);
                $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$dag_pattadar);
                
                //var_dump($backlogorder);
                $this->db->insert('backlog_orders', $backlogorder);
            }
            
            $backlogorder['patta_no'] = trim($d->patta_no);
             $backlogorder['dag_no'] = $d->dag_no;
             $backlogorder['patta_type_code'] = $d->patta_type_code;
             $backlogorder['dag_no_int'] = $d->dag_no.'00';
             
             //var_dump($backlogorder);
             $this->db->insert('backlog_orders', $backlogorder);
             
             
            
        }
        return;
    }

    public function AutoJamabandi($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $petition_no, $case_no) {
        
        $dag_details = "select * from    land_acquisition_dag_details where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and petition_no='$petition_no'";
        $result = $this->db->query($dag_details)->result();
       
        $location = array(
            'd' => $dist_code,
            's' => $subdiv_code,
            'c' => $cir_code,
            'm' => $mouza_pargona_code,
            'l' => $lot_no,
            'v' => $vill_code
        );

        $this->session->set_userdata(array('loc' => $location));
        $parra_no_new = '0';
        $new_patta_type = $result[0]->govt_patta_type;
        //echo $new_patta_type;
        redirect(base_url() . "index.php/JamaBandi/step3/$parra_no_new/$new_patta_type");
        //$this->step3(trim($parra_no_new), $new_patta_type);
        
    }
    
    function corejectorder() {
        $tp = $this->input->get('type');
        $p = $this->input->get('p');
        $c = $this->input->get('case');
        if ($tp == 2) {
            $d = date('Y-m-d');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $update_q = "update t_chitha_rmk_ordbasic set iscorrected_inco='Y',iscorrected_inco_date='$d'"
                    . " where ord_no='$c' and petition_no='$p' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
            $this->db->query($update_q);
            $update_q = "update t_chitha_rmk_infavor_of set iscorrected_inco='Y',iscorrected_inco_date='$d'"
                    . " where ord_no='$c' and petition_no='$p' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
            $this->db->query($update_q);
            redirect('/home');
        } elseif ($tp == 1) {
            $d = date('Y-m-d');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $update_q = "update t_chitha_col8_order set iscorrected_inco='Y',iscorrected_inco_date='$d'"
                    . " where case_no='$c' and petition_no='$p' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
            $this->db->query($update_q);

            redirect('/home');
        }
    }

}
