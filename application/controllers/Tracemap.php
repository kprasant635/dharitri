    <?php
    class Tracemap extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model('mutation/mutationmodel');
            $this->load->model('misreport/MisModel');
            $this->load->model('APCancellation/APCancellationModel');
            $this->load->model('patta/pattamodel');
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('file');
            $this->load->helper('download');
            $this->load->model('basundhara/basundharamodel');
            $this->load->model('TraceMap/TraceMapModel');
            $this->load->model('rtps/RtpsModel');
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
    function index() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
            //$district['mouza'] = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
        $district['mouzalist'] = $this->MisModel->getMouzaList($dist_code, $subdiv_code, $cir_code);
        $district['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name
        );
        $district['patta'] = $this->APCancellationModel->getAllPatta();
        $this->form_validation->set_rules('mouza_code', 'Mouza Code', 'trim|required|numeric');
        $this->form_validation->set_rules('lot_no', 'Lot No', 'trim|required|numeric');
        $this->form_validation->set_rules('vill_code', 'Village Code', 'trim|required|numeric');
        $district['_view'] = 'tracemap/regform';
        $this->load->view('layouts/main',$district);
    }
    function tracemapRTPS(){
        $application_no = $this->input->get('app');
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
        $district['app']=$output->application;
        $district['pattaNo']=$this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$district['app']->dag_no);
        $district['firstParty']=$output->mutation;
        $district['document']=$output->documents;
        $district['query']=$output->query;
        $district['sro']=$output->sro;
        $district['user']=$this->RtpsModel->usersForOffice($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code);
        $district['_view'] = 'tracemap/regformrtps';
        $this->load->view('layouts/main',$district);
    }
    function traceAst(){
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $year_no = year_no;
        $define_date = define_date;
        $data['MisCases'] = $this->TraceMapModel->getMiscCasesAST($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['_view'] = 'tracemap/trace_ast';
        $this->load->view('layouts/main',$data);
    }
    function regformPost()
    {
        $patta_no = trim($this->input->post('patta_no'));
        $patta_type_code = $this->input->post('patta_type');
        $dag_no_int=$this->input->post('dag_no');
        $application_no=$_POST['application_no'];
            //////////////////
        $recordExist=$this->RtpsModel->checkExistDharitree($application_no);
        if($recordExist){               
            $json['error_a'][] = array('err_msg' => ' Case have been Registered Already. Please Check');
            echo json_encode($json);
            return;
        }
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
        $data['app']=$output->application;
        $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$data['app']->dag_no);
        $data['firstParty']=$output->mutation;
        $dist_code=$data['app']->dist_code;
        $this->db->trans_begin();
        $case_name=$this->RtpsModel->genearteCaseName();
        if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Seesion Out. Please try Again"
            );
            echo json_encode($data);
            exit;
            die();
        }
        $case_no['petition_no']=$petition_no=$this->RtpsModel->genearteTracemapPetitionNo();
        $case_no=$case_name.$petition_no."/TRMP";
        $userdata = array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'case_no' => $case_no,
            'patta_no' => $patta_no,
            'patta_type_code' => $patta_type_code,
            'submission_date' => date('Y-m-d G:i:s'),
            'status' => 'SK',
            'year_no'=>'2022',
            'user_code' => $this->session->userdata('user_code'),     
            'dag_no' => $data['app']->dag_no,
            'dag_area_b'=>$data['app']->area_b,
            'dag_area_k'=>$data['app']->area_k,
            'dag_area_lc'=>$data['app']->area_l,
            'dag_area_g'=>$data['app']->area_g,
            'dag_area_kr'=>$data['app']->area_kr,
            'mobile'=>$data['firstParty'][0]->pat_mobile_no,
            'ast_remarks'=>$this->input->post('astremark')
        );
        $tstatus1= $this->db->insert("trace_map", $userdata);
        if ($tstatus1 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error"," Cannot save trace_map #TM001 for dist: "
             .$dist_code.", case_no:".$case_no);
            $this->session->set_flashdata('message', ' Cannot save tracemap details #TM001!!');
            redirect(base_url() . "index.php/home/index");
            return;
        }
        foreach($data['firstParty'] as $pet){
            $applicant = array(
                'dist_code' => $data['app']->dist_code,
                'subdiv_code' =>$data['app']->subdiv_code,
                'cir_code' => $data['app']->cir_code,
                'pdar_id' => $pet->chitha_pdar_id,
                'case_no' => $case_no,
                'appl_name' => $pet->pat_name_ass,
                'father_name'=>$pet->pat_gurdian_name_ass,
                'submission_date' => date('Y-m-d G:i:s'),
                'user_code' => $this->session->userdata('user_code'),
                'operation' => 'E'
            );
            $tstatus2=$this->db->insert("trace_map_applicant", $applicant);
        }
        if ($tstatus2 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error"," Cannot save trace_map_applicant #TMA002 for dist: "
             .$dist_code.", case_no:".$case_no);
            $this->session->set_flashdata('message', ' Cannot save tracemap applicant #TMA002!!');
            redirect(base_url() . "index.php/home/index");
            return;
        }
        $basundhara=array(
            'dharitree'=>$case_no,
            'basundhara'=>$application_no,
            'date_reg'=>date('Y-m-d'),
            'reg_by'=>$this->session->userdata('user_code'),
            'app_status'=>'P',
            'pending_with'=>'CO'
        );
        $tstatus3=$this->db->insert('basundhar_application',$basundhara);
        if ($tstatus3 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error"," Cannot save basundhar_application #BAS001 for dist: "
             .$dist_code.", case_no:".$case_no);
            $this->session->set_flashdata('message', ' Cannot save basundhara data #BAS001!!');
            redirect(base_url() . "index.php/home/index");
            return;
        }
        $proceeding_id = $this->db->query("select count(proceeding_id)+1 as pid from trace_map_proceeding where case_no='$case_no' and dist_code='$dist_code'")->row()->pid;
        if ($proceeding_id == null) {
            $proceeding_id = 1;
        }
        $status='M';
        $userdata = array(
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'co_order' => $this->input->post('astremark'),
            'status' => $status,
            'user_code' =>  $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d'),
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no
        );
        $tstatus4 = $this->db->insert("trace_map_proceeding", $userdata);
        if ($tstatus4 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error"," Cannot save trace_map_proceeding #TMPP001 for dist: "
             .$dist_code.", case_no:".$case_no);
            $this->session->set_flashdata('message', ' Cannot save proceeding report #TMPP001!!');
            redirect(base_url() . "index.php/home/index");
            return;
        }
        $json=null;
        $no = explode('/', $case_no);
        $count = $this->db->query("SELECT count(case_no) AS count FROM supportive_document 
            WHERE case_no=?", array($case_no))->row()->count;
        $sl = $count+1;
        if($no[4]=='TRMP'){
            $folder = TRACE_MAP_BASE_DIR.$dist_code.UPLOAD_SEPARATOR;
            $petition_no = $no[3];
        }
        $file = $petition_no.date('Y').'_'.$sl;
        $_FILES['file']['type'] = $_FILES['up_noc']['type'];
        $_FILES['file']['tmp_name'] = $_FILES['up_noc']['tmp_name'];
        $_FILES['file']['error'] = $_FILES['up_noc']['error'];
        $_FILES['file']['size'] = $_FILES['up_noc']['size'];
        $ext = pathinfo($_FILES['up_noc']['name'], PATHINFO_EXTENSION);
        $_FILES['file']['name'] = $file.'.'.$ext;
        if(!file_exists($folder)){
            mkdir($folder, 0777, true);
            $path = $folder;
        }
        else {
            $path = $folder;   
        }
        $config = array(
            'upload_path' => $path,
            'allowed_types' => FILE_TYPE,
            'max_size' => MAX_SIZE,
        );
        $check_file_type = explode('|', FILE_TYPE);
        $checkFileExt = false;
        foreach ($check_file_type as $file_type) {
            if($ext == $file_type) {
                $checkFileExt = true;
                break;
            }
        }
        if(empty($_FILES['up_noc']['name']))
        {
            $json['error_a'][] = array('err_msg' => ' Map upload is mandatory in case of trace map service.');
        }
        else if(!$checkFileExt){
            $json['error_a'][] = array('err_msg' => ' File type should be in ' . FILE_TYPE . '. format only');
        }
        else if($_FILES['up_noc']['size'] > (MAX_SIZE * 1024) )
        {
            $json['error_a'][] = array('err_msg' => ' Larger file size selected.');
        }
        if($json !=null or $json !='' )
        {
            echo json_encode($json);
            return;
        }
        else
        {
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file')) 
            {
                $data = $this->upload->data();
                $img = [
                    'case_no' => $case_no,
                    'user_code' => $this->session->userdata('user_code'),
                    'file_name' => TRACE_MAP,
                    'fetch_file_name' => $file.$data['file_ext'],
                    'file_type' => $data['file_type'],
                    'file_path' => $path.$file.$data['file_ext'],
                    'date_entry' => date('Y-m-d h:i:s'),
                    'mut_type' => 'NA',
                ];
                $insUpload = $this->db->insert('supportive_document', $img);
                if($insUpload != 1 ){
                    $this->db->trans_rollback();
                    log_message('error', '#ERRORSD001: Uploading insertion failed in supportive_document for case no :'. $case_no);
                    $json = array(
                        'error_a'=>'#ERRORSD001: NOC upload failed for Case No ' . $case_no
                    );
                    echo json_encode($json);
                    return false;
                }
            }
        }
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            $data=array(
                'error'=>"Error in submitting. Please try Again"
            );
        }
        else
        {
            $this->db->trans_commit();
            $rmk='Registered Successfully';
            $status='M';
            $task='LM';
            $pen='SK';
            $case=$case_no;
            $this->RtpsModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);  
            $json['success'] = 'true';
            $json['case_no'] = $case_no;
            $json['redirect'] = base_url()."index.php/home/index";
            echo json_encode($json);
            return;
        }
    }
    function TraceMapCoFirst(){
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $define_date = define_date;
        $year_no = year_no;
        $mouza_pargona_code = '00';
        $lot_no = '00';
        $data['MisCasesF'] = $this->TraceMapModel->getMiscCasesF($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['_view'] = 'tracemap/trace_co_first';
        $this->load->view('layouts/main',$data);
    }
    function COstep1()
    {
        $user_code = $this->session->userdata('user_code');
        $dist_code=$this->session->userdata('dist_code');
        $subdiv_code=$this->session->userdata('subdiv_code');
        $cir_code=$this->session->userdata('cir_code');
        $case_array = array();
        $data['MisCases'] = $this->db->query("select tm.*,ba.basundhara from trace_map tm left join basundhar_application ba on ba.dharitree=tm.case_no where status='CO' and (not_fresh is null or not_fresh='') and dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code'")->result();
        $data['_view'] = 'tracemap/COStep1';
        $this->load->view('layouts/main',$data);
    }
    public function COStep2() {
        $case_no = $this->input->get('case_no');
        $data['miscCaseInfo'] = $this->TraceMapModel->Tracemap($case_no);
        $data['miscCaseappl'] = $this->TraceMapModel->tracemapApplicant($case_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $patta_type_code = $data['miscCaseInfo']->patta_type_code;
        $dag_no = $data['miscCaseInfo']->dag_no;
        $patta_no = $data['miscCaseInfo']->patta_no;
        $appl_name = $data['miscCaseInfo']->appl_name;
        $father_name = $data['miscCaseInfo']->father_name;
        $mobile = $data['miscCaseInfo']->mobile;
        $data['pattaType'] = $this->APCancellationModel->getPattaName($patta_type_code);
        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);
            //merge all the data
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);
        $data['basundharaAttachment']=$this->RtpsModel->searchBasundharaLink($case_no);
        $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
        $data['query']=$this->RtpsModel->QueryPost($basundharaExist);
        $application_no="select * from basundhar_application where dharitree='$case_no' ";
        $data['app'] = $this->db->query($application_no)->row();
        $data['basundharaAttachment']=$this->RtpsModel->searchBasundharaLink($case_no);
        $data['_view'] = 'tracemap/COStep2';
        $this->load->view('layouts/main',$data);
    }
    public function COStep2_save() {
        $case_no = $this->input->post('case_no');
        $date_entry = date('Y-m-d G:i:s');
        $data['miscCaseInfo'] = $this->TraceMapModel->Tracemap($case_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $user_code = $this->session->userdata('user_code');
        $co_order = addslashes($this->input->post('coremark'));
        $proceeding_id = $this->db->query("select count(proceeding_id)+1 as pid from trace_map_proceeding where case_no='$case_no' and dist_code='$dist_code'")->row()->pid;
        if ($proceeding_id == null) {
            $proceeding_id = 1;
        }
        $status='C';
        $userdata = array(
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'co_order' => $co_order,
            'status' => $status,
            'user_code' => $user_code,
            'date_entry' => $date_entry,
            'dist_code' => $dist_code,
            'cir_code' => $cir_code,
            'subdiv_code' => $subdiv_code,
            'mouza_pargona_code'=>'00',
            'lot_no'=>'00'
        );
        $this->db->trans_begin();
        $tstatus1 = $this->db->insert("trace_map_proceeding", $userdata);
        if ($tstatus1 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error"," Cannot save trace_map_proceeding #TMP002 for dist: "
             .$dist_code.", case_no:".$case_no);
            $this->session->set_flashdata('message', ' Cannot save proceeding report #TMP002!!');
            redirect(base_url() . "index.php/home/index");
            return;
        }
        $updateSqlBasic = "update  trace_map set  status='LM',not_fresh='Y',date_of_order='$date_entry' where case_no='$case_no'";
        $this->db->query($updateSqlBasic);
        if ($this->db->affected_rows() <=0)
        {
            $this->db->trans_rollback();
            log_message("error"," Cannot update status in trace_map #TM002 for dist: "
             .$dist_code.", case_no:".$case_no);
            $this->session->set_flashdata('message', ' Cannot update case status #TM002!!');
            redirect(base_url() . "index.php/home/index");
            return;
        }
        $this->db->trans_commit();
        $penUser='LM';
        $rmrk="CO submitted his report";
        $this->DashboardData($case_no,$penUser,$rmrk);
            //////////////////////
        $application_no = $this->input->POST('application_no');
        if($application_no){
         $rmk=$rmrk;
         $status='M';
         $task='CO';
         $pen='LM';
         $case=$case_no['case_no'];
         $this->RtpsModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
     }
                //////////////////
     $this->session->set_flashdata('message', 'First proceeding given by CO. Now LM will give report for the case: '.$case_no);
     redirect(base_url() . "index.php/home/index");
    }
    function TraceMapLmFirst(){
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $define_date = define_date;
        $year_no = year_no;
        $data['MisCasesR'] = $this->TraceMapModel->getTPCasesLMrevert($user_code, $dist_code, $subdiv_code, $cir_code,$mouza_pargona_code,$lot_no);
        $data['_view'] = 'tracemap/trace_lm_first';
        $this->load->view('layouts/main',$data);
    }
    function LMstep1()
    {
        $user_code = $this->session->userdata('user_code');
        $dist_code=$this->session->userdata('dist_code');
        $subdiv_code=$this->session->userdata('subdiv_code');
        $cir_code=$this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $case_array = array();
        $data['MisCases'] = $this->db->query("select tm.*,ba.basundhara from trace_map tm left join basundhar_application ba on ba.dharitree=tm.case_no where status='LM' and dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' ")->result();
        $data['_view'] = 'tracemap/LMStep1';
        $this->load->view('layouts/main',$data);
    }
    public function LMStep2() {
        $case_no = $this->input->get('case_no');
        $data['miscCaseInfo'] = $this->TraceMapModel->Tracemap($case_no);
        $data['miscCaseappl'] = $this->TraceMapModel->tracemapApplicant($case_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $patta_type_code = $data['miscCaseInfo']->patta_type_code;
        $dag_no = $data['miscCaseInfo']->dag_no;
        $patta_no = $data['miscCaseInfo']->patta_no;
        $appl_name = $data['miscCaseInfo']->appl_name;
        $father_name = $data['miscCaseInfo']->father_name;
        $mobile = $data['miscCaseInfo']->mobile;
        $data['pattaType'] = $this->APCancellationModel->getPattaName($patta_type_code);
            //load the MisModel
        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);
            //merge all the data
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);
        $data['basundharaAttachment']=$this->RtpsModel->searchBasundharaLink($case_no);
        $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
        $application_no="select * from basundhar_application where dharitree='$case_no' ";
        $data['app'] = $this->db->query($application_no)->row();
        $data['query']=$this->RtpsModel->QueryPost($basundharaExist);
        $data['_view'] = 'tracemap/LMStep2';
        $this->load->view('layouts/main',$data);
    }
    public function LMStep2_save() {
            //$db=  $this->session->userdata('db');
        $json=null;
        $case_no = $this->input->post('case_no');
        $no = explode('/', $case_no);
        $count = $this->db->query("SELECT count(case_no) AS count FROM supportive_document 
            WHERE case_no=?", array($case_no))->row()->count;
        $sl = $count+1;
            ////////////
        $date_entry = date('Y-m-d G:i:s');
        $data['miscCaseInfo'] = $this->TraceMapModel->Tracemap($case_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $user_code = $this->session->userdata('user_code');
        $co_order = addslashes($this->input->post('lmremark'));
            //$year_no = $data['miscCaseInfo']->year_no;
        $proceeding_id = $this->db->query("select count(proceeding_id)+1 as pid from trace_map_proceeding where case_no='$case_no' and dist_code='$dist_code'")->row()->pid;
        if ($proceeding_id == null) {
            $proceeding_id = 1;
        }
        $status='M';
        $userdata = array(
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'co_order' => $co_order,
            'status' => $status,
            'user_code' => $user_code,
            'date_entry' => $date_entry,
            'dist_code' => $dist_code,
            'cir_code' => $cir_code,
            'subdiv_code' => $subdiv_code,
            'mouza_pargona_code'=>$mouza_pargona_code,
            'lot_no'=>$lot_no
        );
        $this->db->trans_begin();
        if($no[4]=='TRMP'){
            $folder = TRACE_MAP_BASE_DIR.$dist_code.UPLOAD_SEPARATOR;
            $petition_no = $no[3];
        }
        $file = $petition_no.date('Y').'_'.$sl;
        $_FILES['file']['type'] = $_FILES['up_noc']['type'];
        $_FILES['file']['tmp_name'] = $_FILES['up_noc']['tmp_name'];
        $_FILES['file']['error'] = $_FILES['up_noc']['error'];
        $_FILES['file']['size'] = $_FILES['up_noc']['size'];
        $ext = pathinfo($_FILES['up_noc']['name'], PATHINFO_EXTENSION);
        $_FILES['file']['name'] = $file.'.'.$ext;
        if(!file_exists($folder)){
            mkdir($folder, 0777, true);
            $path = $folder;
        }
        else {
            $path = $folder;   
        }
        $config = array(
            'upload_path' => $path,
            'allowed_types' => FILE_TYPE,
            'max_size' => MAX_SIZE,
        );
        $check_file_type = explode('|', FILE_TYPE);
        $checkFileExt = false;
        foreach ($check_file_type as $file_type) {
            if($ext == $file_type) {
                $checkFileExt = true;
                break;
            }
        }
        if(empty($_FILES['up_noc']['name']))
        {
            $json['error_a'][] = array('err_msg' => ' Map upload is mandatory in case of trace map service.');
        }
        else if(!$checkFileExt){
            $json['error_a'][] = array('err_msg' => ' File type should be in ' . FILE_TYPE . '. format only');
        }
        else if($_FILES['up_noc']['size'] > (MAX_SIZE * 1024) )
        {
            $json['error_a'][] = array('err_msg' => ' Larger file size selected.');
        }
        if($json !=null or $json !='' )
        {
            echo json_encode($json);
            return;
        }
        else
        {
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file')) 
            {
                $data = $this->upload->data();
                $img = [
                    'case_no' => $case_no,
                    'user_code' => $user_code,
                    'file_name' => TRACE_MAP,
                    'fetch_file_name' => $file.$data['file_ext'],
                    'file_type' => $data['file_type'],
                    'file_path' => $path.$file.$data['file_ext'],
                    'date_entry' => date('Y-m-d h:i:s'),
                    'mut_type' => 'NA',
                ];
                $insUpload = $this->db->insert('supportive_document', $img);
                if($insUpload != 1 ){
                    $this->db->trans_rollback();
                    log_message('error', '#ERRORSD001: Uploading insertion failed in supportive_document for case no :'. $case_no);
                    $json = array(
                        'error_a'=>'#ERRORSD001: NOC upload failed for Case No ' . $case_no
                    );
                    echo json_encode($json);
                    return false;
                }
            }
        }
        $tstatus1 = $this->db->insert("trace_map_proceeding", $userdata);
        if ($tstatus1 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error"," Cannot save trace_map_proceeding #TMP003 for dist: "
             .$dist_code.", case_no:".$case_no);
            $json = array(
                'error_a'=>'Cannot save proceeding report #TMP003!!'
            );
            echo json_encode($json);
            return false;
        }
        $updateSqlBasic = "update  trace_map set  status='SK', date_of_order='$date_entry' where case_no='$case_no'";
        $this->db->query($updateSqlBasic);
        if ($this->db->affected_rows() <=0)
        {
            $this->db->trans_rollback();
            log_message("error"," Cannot update status in trace_map #TM003 for dist: "
             .$dist_code.", case_no:".$case_no);
            $json = array(
                'error_a'=>'Cannot save proceeding report #TM003!!'
            );
            echo json_encode($json);
            return false;
        }
        $this->db->trans_commit();        
            ///////////////////////////////////
        $penUser='SK';
        $rmrk="LM submitted his report";
        $this->DashboardData($case_no,$penUser,$rmrk);
            //////////////////////
        $application_no = $this->input->POST('application_no');
        if($application_no){
         $rmk='Forwarded to SK';
         $status='M';
         $task='LM';
         $pen='SK';
         $case=$case_no;
         $this->RtpsModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
     }
     $json['success'] = 'true';
     $json['case_no'] = $case_no;
     $json['redirect'] = base_url()."index.php/home/index";
     echo json_encode($json);
     return;
    }
    function lmRevert()
    {
        $user_code = $this->session->userdata('user_code');
        $dist_code=$this->session->userdata('dist_code');
        $subdiv_code=$this->session->userdata('subdiv_code');
        $cir_code=$this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $case_array = array();
        $data['MisCases'] = $this->db->query("select tm.*,ba.basundhara from trace_map tm left join basundhar_application ba on ba.dharitree=tm.case_no where revert='LM' and (status is null or status='') and dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' ")->result();
        $data['_view'] = 'tracemap/lm_revert';
        $this->load->view('layouts/main',$data);
    }
    public function LmRevertstep2() {
        $case_no = $this->input->get('case_no');
        $data['miscCaseInfo'] = $this->TraceMapModel->Tracemap($case_no);
        $data['miscCaseappl'] = $this->TraceMapModel->tracemapApplicant($case_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $patta_type_code = $data['miscCaseInfo']->patta_type_code;
        $dag_no = $data['miscCaseInfo']->dag_no;
        $patta_no = $data['miscCaseInfo']->patta_no;
        $appl_name = $data['miscCaseInfo']->appl_name;
        $father_name = $data['miscCaseInfo']->father_name;
        $mobile = $data['miscCaseInfo']->mobile;
        $data['pattaType'] = $this->APCancellationModel->getPattaName($patta_type_code);
            //load the MisModel
        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);
            //merge all the data
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);
        $lmremark="select * from trace_map_proceeding where case_no='$case_no' and user_code like 'M%' order by proceeding_id desc";
        $data['lmrmk']= $this->db->query($lmremark)->row();
        $coremark="select * from trace_map_proceeding where case_no='$case_no' and user_code like 'C%' and status='RVT' order by proceeding_id desc";
        $data['cormk']= $this->db->query($coremark)->row();
        $skremark="select * from trace_map_proceeding where case_no='$case_no' and user_code like 'S%' order by proceeding_id desc";
        $data['skrmk']= $this->db->query($skremark)->row();
        $data['basundharaAttachment']=$this->RtpsModel->searchBasundharaLink($case_no);
        $data['sup_doc']=$this->mutationmodel->getDocument($case_no);
        $application_no="select * from basundhar_application where dharitree='$case_no' ";
        $data['app'] = $this->db->query($application_no)->row();
        $data['_view'] = 'tracemap/lm_revert_step2';
        $this->load->view('layouts/main',$data);
    }
    function TraceMapSkFirst(){
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $headtitle = array(
            'title' => 'Home Page'
        );
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $define_date = define_date;
        $year_no = year_no;
        $data['MisCases'] = $this->TraceMapModel->getTPCasesSK($user_code, $dist_code, $subdiv_code, $cir_code);
        $data['_view'] = 'tracemap/trace_sk_first';
        $this->load->view('layouts/main',$data);
    }
    function SKstep1()
    {
        $user_code = $this->session->userdata('user_code');
        $dist_code=$this->session->userdata('dist_code');
        $subdiv_code=$this->session->userdata('subdiv_code');
        $cir_code=$this->session->userdata('cir_code');
        $case_array = array();
        $data['MisCases'] = $this->db->query("select tm.*,ba.basundhara from trace_map tm left join basundhar_application ba on ba.dharitree=tm.case_no where status='SK' and dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' ")->result();
        $data['_view'] = 'tracemap/SKStep1';
        $this->load->view('layouts/main',$data);
    }
    public function SKStep2() {
        $case_no = $this->input->get('case_no');
        $data['miscCaseInfo'] = $this->TraceMapModel->Tracemap($case_no);
        $data['miscCaseappl'] = $this->TraceMapModel->tracemapApplicant($case_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $patta_type_code = $data['miscCaseInfo']->patta_type_code;
        $dag_no = $data['miscCaseInfo']->dag_no;
        $patta_no = $data['miscCaseInfo']->patta_no;
        $appl_name = $data['miscCaseInfo']->appl_name;
        $father_name = $data['miscCaseInfo']->father_name;
        $mobile = $data['miscCaseInfo']->mobile;
        $data['pattaType'] = $this->APCancellationModel->getPattaName($patta_type_code);
            //load the MisModel
        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);
            //merge all the data
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);
        $data['basundharaAttachment']=$this->RtpsModel->searchBasundharaLink($case_no);
        $lmremark="select * from trace_map_proceeding where case_no='$case_no' and user_code like 'M%' order by proceeding_id desc";
        $data['lmrmk']= $this->db->query($lmremark)->row();
        $coremark="select * from trace_map_proceeding where case_no='$case_no' and user_code like 'C%' order by proceeding_id desc";
        $data['cormk']= $this->db->query($coremark)->row();
        $skremark="select * from trace_map_proceeding where case_no='$case_no' and user_code like 'S%' order by proceeding_id desc";
        $data['skrmk']= $this->db->query($skremark)->row();
        $data['sup_doc']=$this->mutationmodel->getDocument($case_no);
        $application_no="select * from basundhar_application where dharitree='$case_no' ";
        $data['app'] = $this->db->query($application_no)->row();
        $data['_view'] = 'tracemap/SKStep2';
        $this->load->view('layouts/main',$data);
    }
    public function SKStep2_save() {
        $case_no = $this->input->post('case_no');
        $date_entry = date('Y-m-d G:i:s');
        $data['miscCaseInfo'] = $this->TraceMapModel->Tracemap($case_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $user_code = $this->session->userdata('user_code');
        $skremarkval = [
            [
                'field' => 'skremark',
                'label' => 'Remark',
                'rules' => 'trim|required|xss_clean',
            ],
        ];
        $this->form_validation->set_rules($skremarkval);
        $this->form_validation->set_message('integer', 'This %s is not valid');
        if ($this->form_validation->run('skremarkval') == FALSE)
        {
            $this->form_validation->set_error_delimiters('', '');
            foreach($skremarkval as $rule){
                if (form_error($rule['field'])) {
                    $json['error1'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
                }
            }   
            $this->session->set_flashdata('message', 'SK Remark is mandatory');
            redirect(base_url() . "index.php/home/index");
            return;          
        }
        else{
            $proceeding_id = $this->db->query("select count(proceeding_id)+1 as pid from trace_map_proceeding where case_no='$case_no' and dist_code='$dist_code'")->row()->pid;
            if ($proceeding_id == null) {
                $proceeding_id = 1;
            }
            $status='S';
            $userdata = array(
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id,
                'co_order' => $this->input->post('skremark'),
                'status' => $status,
                'user_code' => $user_code,
                'date_entry' => $date_entry,
                'dist_code' => $dist_code,
                'cir_code' => $cir_code,
                'subdiv_code' => $subdiv_code,
                'mouza_pargona_code'=>'00',
                'lot_no'=>'00'
            );
            $this->db->trans_begin();
            $tstatus1 = $this->db->insert("trace_map_proceeding", $userdata);
            if ($tstatus1 != 1 )
            {
                $this->db->trans_rollback();
                log_message("error"," Cannot save trace_map_proceeding #TMP004 for dist: "
                 .$dist_code.", case_no:".$case_no);
                $this->session->set_flashdata('message', ' Cannot save proceeding report #TMP004!!');
                redirect(base_url() . "index.php/home/index");
                return;
            }
            $updateSqlBasic = "update  trace_map set  status='CO', date_of_order='$date_entry',not_fresh='Y' where case_no='$case_no'";
            $this->db->query($updateSqlBasic);
            if ($this->db->affected_rows() <=0)
            {
                $this->db->trans_rollback();
                log_message("error"," Cannot update status in trace_map #TM004 for dist: "
                 .$dist_code.", case_no:".$case_no);
                $this->session->set_flashdata('message', ' Cannot update case status #TM004!!');
                redirect(base_url() . "index.php/home/index");
                return;
            }
            ///////////////////////////////////
            $penUser='CO';
            $rmrk="SK submitted his report";
            $this->DashboardData($case_no,$penUser,$rmrk);
            //////////////////////
            $this->db->trans_commit();
            $application_no = $this->input->POST('application_no');
            if($application_no){
             $rmk='Forwarded to CO';
             $status='M';
             $task='SK';
             $pen='CO';
             $case=$case_no;
             $this->RtpsModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
         }
         $this->session->set_flashdata('message', 'SK report has been given for the case: '.$case_no);
         redirect(base_url() . "index.php/home/index");
     }
    }
    function COFinalorder()
    {
        $user_code = $this->session->userdata('user_code');
        $dist_code=$this->session->userdata('dist_code');
        $subdiv_code=$this->session->userdata('subdiv_code');
        $cir_code=$this->session->userdata('cir_code');
        $case_array = array();
        $data['MisCases'] = $this->db->query("select tm.*,ba.basundhara from trace_map tm left join basundhar_application ba on ba.dharitree=tm.case_no where status='CO' and not_fresh='Y' and dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code'")->result();
        $data['_view'] = 'tracemap/COFinalorder';
        $this->load->view('layouts/main',$data);
    }
    function COFinalOrderPass()
    {
        $case_no = $this->input->get('case_no');
        $data['miscCaseInfo'] = $this->TraceMapModel->Tracemap($case_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $data['miscCaseappl'] = $this->TraceMapModel->tracemapApplicant($case_no);
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $patta_type_code = $data['miscCaseInfo']->patta_type_code;
        $dag_no = $data['miscCaseInfo']->dag_no;
        $patta_no = $data['miscCaseInfo']->patta_no;
        $appl_name = $data['miscCaseInfo']->appl_name;
        $father_name = $data['miscCaseInfo']->father_name;
        $mobile = $data['miscCaseInfo']->mobile;
        $data['pattaType'] = $this->APCancellationModel->getPattaName($patta_type_code);
            //load the MisModel
        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);
            //merge all the data
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);
        $data['basundharaAttachment']=$this->RtpsModel->searchBasundharaLink($case_no);
        $lmremark="select * from trace_map_proceeding where case_no='$case_no' and user_code like 'M%' order by proceeding_id desc";
        $data['lmrmk']= $this->db->query($lmremark)->row();
        $skremark="select * from trace_map_proceeding where case_no='$case_no' and user_code like 'SK%' order by proceeding_id desc";
        $data['skrmk']= $this->db->query($skremark)->row();
        $coremark="select * from trace_map_proceeding where case_no='$case_no' and user_code like 'C%' and status='RVT' order by proceeding_id desc";
        $data['cormk']= $this->db->query($coremark)->row();
        $data['sup_doc']=$this->mutationmodel->getDocument($case_no);
        $application_no="select * from basundhar_application where dharitree='$case_no' ";
        $data['app'] = $this->db->query($application_no)->row();
        $data['_view'] = 'tracemap/Cofinalorderpass';
        $this->load->view('layouts/main',$data);
    }
    public function COFinalOrderPass_save() {
        $case_no = $this->input->post('case_no');
        $date_entry = date('Y-m-d G:i:s');
        $data['miscCaseInfo'] = $this->TraceMapModel->Tracemap($case_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $user_code = $this->session->userdata('user_code');
        $co_order = addslashes($this->input->post('fcoremark'));
        $proceeding_id = $this->db->query("select count(proceeding_id)+1 as pid from trace_map_proceeding where case_no='$case_no' and dist_code='$dist_code'")->row()->pid;
        if ($proceeding_id == null) {
            $proceeding_id = 1;
        }
        $status='C';
        $userdata = array(
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'co_order' => $co_order,
            'status' => $status,
            'user_code' => $user_code,
            'date_entry' => $date_entry,
            'dist_code' => $dist_code,
            'cir_code' => $cir_code,
            'subdiv_code' => $subdiv_code,
            'mouza_pargona_code'=>'00',
            'lot_no'=>'00'
        );
        $this->db->trans_begin();
        $tstatus1 = $this->db->insert("trace_map_proceeding", $userdata);
        if ($tstatus1 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error"," Cannot save trace_map_proceeding #TMP005 for dist: "
             .$dist_code.", case_no:".$case_no);
            $this->session->set_flashdata('message', ' Cannot save proceeding report #TMP005!!');
            redirect(base_url() . "index.php/home/index");
            return;
        }
        $updateSqlBasic = "update  trace_map set  status='F', date_of_order='$date_entry' where case_no='$case_no'";
        $this->db->query($updateSqlBasic);
        if ($this->db->affected_rows() <=0)
        {
            $this->db->trans_rollback();
            log_message("error"," Cannot update status in trace_map #TM005 for dist: "
             .$dist_code.", case_no:".$case_no);
            $this->session->set_flashdata('message', ' Cannot update case status #TM005!!');
            redirect(base_url() . "index.php/home/index");
            return;
        }
            ///////////////////////////////////
        $penUser='AST';
        $rmrk="CO gives final order";
        $this->DashboardData($case_no,$penUser,$rmrk);
            //////////////////////
        $application_no = $this->input->POST('application_no');
        $this->db->trans_commit();
        $application_no = $this->input->POST('application_no');
        if($application_no){
         $rmk='Forwarded to AST';
         $status='M';
         $task='CO';
         $pen='AST';
         $case=$case_no;
         $this->RtpsModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
     }
     $this->session->set_flashdata('message', 'Final order Passed By CO: '.$case_no.'Now Assistant will upload and deliver the Trace Map to Citizen');
     redirect(base_url() . "index.php/home/index");
    }
    function astDeliver()
    {
        $user_code = $this->session->userdata('user_code');
        $dist_code=$this->session->userdata('dist_code');
        $subdiv_code=$this->session->userdata('subdiv_code');
        $cir_code=$this->session->userdata('cir_code');
        $case_array = array();
        $data['MisCases'] = $this->db->query("select tm.*,ba.basundhara from trace_map tm left join basundhar_application ba on ba.dharitree=tm.case_no where status='F' and (not_fresh is not null or not_fresh!='') and (certi_status is null or certi_status='') and dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code'")->result();
        $data['_view'] = 'tracemap/ast_deliver';
        $this->load->view('layouts/main',$data);
    }
    function astDeliverCert()
    {
        $case_no = $this->input->get('case_no');
        $data['miscCaseInfo'] = $this->TraceMapModel->Tracemap($case_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $data['miscCaseappl'] = $this->TraceMapModel->tracemapApplicant($case_no);
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $patta_type_code = $data['miscCaseInfo']->patta_type_code;
        $dag_no = $data['miscCaseInfo']->dag_no;
        $patta_no = $data['miscCaseInfo']->patta_no;
        $appl_name = $data['miscCaseInfo']->appl_name;
        $father_name = $data['miscCaseInfo']->father_name;
        $mobile = $data['miscCaseInfo']->mobile;
        $data['pattaType'] = $this->APCancellationModel->getPattaName($patta_type_code);
            //load the MisModel
        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $cir_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $lotnodata = $this->MisModel->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code);
            //merge all the data
        $data['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotnodata, $villagedata);
        $data['basundharaAttachment']=$this->RtpsModel->searchBasundharaLink($case_no);
        $lmremark="select * from trace_map_proceeding where case_no='$case_no' and user_code like 'M%' order by proceeding_id desc";
        $data['lmrmk']= $this->db->query($lmremark)->row();
        $skremark="select * from trace_map_proceeding where case_no='$case_no' and user_code like 'SK%' order by proceeding_id desc";
        $data['skrmk']= $this->db->query($skremark)->row();
        $coremark="select * from trace_map_proceeding where case_no='$case_no' and user_code like 'CO%' order by proceeding_id desc";
        $data['cormk']= $this->db->query($coremark)->row();
        $data['sup_doc']=$this->mutationmodel->getDocument($case_no);
        $application_no="select * from basundhar_application where dharitree='$case_no' ";
        $data['app'] = $this->db->query($application_no)->row();
        $data['_view'] = 'tracemap/ast_deliver_cert';
        $this->load->view('layouts/main',$data);
    }
    function RejectOrder(){
        $application_no=$this->input->post('application_no');
        if($application_no)
        {
            $case_no=$this->input->post('case_no');
            $dist_code=$this->session->userdata('dist_code');
            $subdiv_code=$this->session->userdata('subdiv_code');
            $cir_code=$this->session->userdata('cir_code');
            $user_code=$this->session->userdata('user_code');
            $co_order = addslashes($this->input->post('coremark'));
            $data=array(
                'user_code'=>$user_code,
                'status'=>'R',
                'date_of_order'=>date('Y-m-d G:i:s')
            );
            $proceeding_id = $this->db->query("select count(proceeding_id)+1 as pid from trace_map_proceeding where case_no='$case_no' and dist_code='$dist_code'")->row()->pid;
            if ($proceeding_id == null) {
                $proceeding_id = 1;
            }
            $status='R';
            $userdata = array(
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id,
                'co_order' => $co_order,
                'status' => $status,
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d G:i:s'),
                'dist_code' => $dist_code,
                'cir_code' => $cir_code,
                'subdiv_code' => $subdiv_code,
                'mouza_pargona_code'=>'00',
                'lot_no'=>'00'
            );
            $this->db->trans_begin();
            $tstatus1 = $this->db->insert("trace_map_proceeding", $userdata);
            if ($tstatus1 != 1 )
            {
                $this->db->trans_rollback();
                log_message("error"," Cannot save trace_map_proceeding #TMP006 for dist: "
                 .$dist_code.", case_no:".$case_no);
                $this->session->set_flashdata('message', ' Cannot save proceeding report #TMP006!!');
                redirect(base_url() . "index.php/home/index");
                return;
            }
            $this->db->where('dist_code',$dist_code);
            $this->db->where('subdiv_code',$subdiv_code);
            $this->db->where('cir_code',$cir_code);
            $this->db->where('case_no',$case_no);
            $this->db->update("trace_map", $data); 
            $this->db->trans_commit();
            $application_no = $this->input->POST('application_no');
            if($application_no){
             $rmk='Rejected';
             $status='R';
             $task='CO';
             $pen='NA';
             $case=$case_no;
             $this->RtpsModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
         }
                //
     } else{
        $case_no=$this->input->post('case_no');
        $dist_code=$this->session->userdata('dist_code');
        $subdiv_code=$this->session->userdata('subdiv_code');
        $cir_code=$this->session->userdata('cir_code');
        $user_code=$this->session->userdata('user_code');
        $co_order = addslashes($this->input->post('coremark'));
        $data=array(
            'user_code'=>$user_code,
            'status'=>'R',
            'date_of_order'=>date('Y-m-d G:i:s')
        );
        $proceeding_id = $this->db->query("select count(proceeding_id)+1 as pid from trace_map_proceeding where case_no='$case_no' and dist_code='$dist_code'")->row()->pid;
        if ($proceeding_id == null) {
            $proceeding_id = 1;
        }
        $status='R';
        $userdata = array(
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'co_order' => $co_order,
            'status' => $status,
            'user_code' => $user_code,
            'date_entry' => date('Y-m-d G:i:s'),
            'dist_code' => $dist_code,
            'cir_code' => $cir_code,
            'subdiv_code' => $subdiv_code,
            'mouza_pargona_code'=>'00',
            'lot_no'=>'00'
        );
        $this->db->trans_begin();
        $tstatus1 = $this->db->insert("trace_map_proceeding", $userdata);
        if ($tstatus1 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error"," Cannot save trace_map_proceeding #TMP006 for dist: "
             .$dist_code.", case_no:".$case_no);
            $this->session->set_flashdata('message', ' Cannot save proceeding report #TMP006!!');
            redirect(base_url() . "index.php/home/index");
            return;
        }
        $this->db->where('dist_code',$dist_code);
        $this->db->where('subdiv_code',$subdiv_code);
        $this->db->where('cir_code',$cir_code);
        $this->db->where('case_no',$case_no);
        $this->db->update("trace_map", $data); 
        $this->db->trans_commit();
    }
    $this->session->set_flashdata('message', 'Application Rejected Successfully!!');
    redirect(base_url() . "index.php/home/index");
    }
    function revertToLm(){
        $application_no=$this->input->post('application_no');
            //$date_entry = date('Y-m-d');
        if($application_no)
        {
            $case_no=$this->input->post('case_no');
            $dist_code=$this->session->userdata('dist_code');
            $subdiv_code=$this->session->userdata('subdiv_code');
            $cir_code=$this->session->userdata('cir_code');
            $user_code=$this->session->userdata('user_code');
            $co_order=$this->input->post('coremark');
            $data=array(
                'user_code'=>$user_code,
                'revert'=>'LM',
                'date_of_order'=>date('Y-m-d G:i:s'),
                'status'=>''
            );
            $proceeding_id = $this->db->query("select count(proceeding_id)+1 as pid from trace_map_proceeding where case_no='$case_no' and dist_code='$dist_code'")->row()->pid;
            if ($proceeding_id == null) {
                $proceeding_id = 1;
            }
            $status='RVT';
            $userdata = array(
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id,
                'co_order' => $co_order,
                'status' => $status,
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d G:i:s'),
                'dist_code' => $dist_code,
                'cir_code' => $cir_code,
                'subdiv_code' => $subdiv_code,
                'mouza_pargona_code'=>'00',
                'lot_no'=>'00'
            );
            $this->db->trans_begin();
            $tstatus1 = $this->db->insert("trace_map_proceeding", $userdata);
            if ($tstatus1 != 1 )
            {
                $this->db->trans_rollback();
                log_message("error"," Cannot save trace_map_proceeding #TMPR001 for dist: "
                 .$dist_code.", case_no:".$case_no);
                $this->session->set_flashdata('message', ' Cannot save proceeding report #TMPR001!!');
                redirect(base_url() . "index.php/home/index");
                return;
            }
            $this->db->where('dist_code',$dist_code);
            $this->db->where('subdiv_code',$subdiv_code);
            $this->db->where('cir_code',$cir_code);
            $this->db->where('case_no',$case_no);
            $this->db->update("trace_map", $data); 
            $this->db->trans_commit();
            $application_no = $this->input->POST('application_no');
            if($application_no){
             $rmk='Reverted back to LM';
             $status='M';
             $task='CO';
             $pen='LM';
             $case=$case_no;
             $this->RtpsModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
         }
     } else{
        $case_no=$this->input->post('case_no');
        $dist_code=$this->session->userdata('dist_code');
        $subdiv_code=$this->session->userdata('subdiv_code');
        $cir_code=$this->session->userdata('cir_code');
        $user_code=$this->session->userdata('user_code');
        $co_order = addslashes($this->input->post('coremark'));
        $data=array(
            'user_code'=>$user_code,
            'revert'=>'LM',
            'date_of_order'=>date('Y-m-d G:i:s'),
            'status'=>''
        );
        $proceeding_id = $this->db->query("select count(proceeding_id)+1 as pid from trace_map_proceeding where case_no='$case_no' and dist_code='$dist_code'")->row()->pid;
        if ($proceeding_id == null) {
            $proceeding_id = 1;
        }
        $status='RVT';
        $userdata = array(
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'co_order' => $co_order,
            'status' => $status,
            'user_code' => $user_code,
            'date_entry' => date('Y-m-d G:i:s'),
            'dist_code' => $dist_code,
            'cir_code' => $cir_code,
            'subdiv_code' => $subdiv_code,
            'mouza_pargona_code'=>'00',
            'lot_no'=>'00'
        );
        $this->db->trans_begin();
        $tstatus1 = $this->db->insert("trace_map_proceeding", $userdata);
        if ($tstatus1 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error"," Cannot save trace_map_proceeding #TMPR001 for dist: "
             .$dist_code.", case_no:".$case_no);
            $this->session->set_flashdata('message', ' Cannot save proceeding report #TMPR001!!');
            redirect(base_url() . "index.php/home/index");
            return;
        }
        $this->db->where('dist_code',$dist_code);
        $this->db->where('subdiv_code',$subdiv_code);
        $this->db->where('cir_code',$cir_code);
        $this->db->where('case_no',$case_no);
        $this->db->update("trace_map", $data); 
        $this->db->trans_commit();
    }
    $this->session->set_flashdata('message', 'Application reverted back to LM Successfully!');
    redirect(base_url() . "index.php/home/index");
    }
    public function deliverCertAst() {
        $json=null;
        $case_no = $this->input->post('case_no');
        $no = explode('/', $case_no);
        $count = $this->db->query("SELECT count(case_no) AS count FROM supportive_document 
            WHERE case_no=?", array($case_no))->row()->count;
        $sl = $count+1;
            ////////////
        $date_entry = date('Y-m-d G:i:s');
        $data['miscCaseInfo'] = $this->TraceMapModel->Tracemap($case_no);
        $dist_code = $data['miscCaseInfo']->dist_code;
        $subdiv_code = $data['miscCaseInfo']->subdiv_code;
        $cir_code = $data['miscCaseInfo']->cir_code;
        $mouza_pargona_code = $data['miscCaseInfo']->mouza_pargona_code;
        $lot_no = $data['miscCaseInfo']->lot_no;
        $vill_code = $data['miscCaseInfo']->vill_townprt_code;
        $user_code = $this->session->userdata('user_code');
        $this->db->trans_begin();
        if($no[4]=='TRMP'){
            $folder = TRACE_MAP_BASE_DIR.$dist_code.UPLOAD_SEPARATOR;
            $petition_no = $no[3];
        }
        $file = $petition_no.date('Y').'_'.$sl;
        $_FILES['file']['type'] = $_FILES['up_noc']['type'];
        $_FILES['file']['tmp_name'] = $_FILES['up_noc']['tmp_name'];
        $_FILES['file']['error'] = $_FILES['up_noc']['error'];
        $_FILES['file']['size'] = $_FILES['up_noc']['size'];
        $ext = pathinfo($_FILES['up_noc']['name'], PATHINFO_EXTENSION);
        $_FILES['file']['name'] = $file.'.'.$ext;
        if(!file_exists($folder)){
            mkdir($folder, 0777, true);
            $path = $folder;
        }
        else {
            $path = $folder;   
        }
        $config = array(
            'upload_path' => $path,
            'allowed_types' => FILE_TYPE,
            'max_size' => MAX_SIZE,
        );
        $check_file_type = explode('|', FILE_TYPE);
        $checkFileExt = false;
        foreach ($check_file_type as $file_type) {
            if($ext == $file_type) {
                $checkFileExt = true;
                break;
            }
        }
        if(empty($_FILES['up_noc']['name']))
        {
            $json['error_a'][] = array('err_msg' => ' Map upload is mandatory in case of trace map service.');
        }
        else if(!$checkFileExt){
            $json['error_a'][] = array('err_msg' => ' File type should be in ' . FILE_TYPE . '. format only');
        }
        else if($_FILES['up_noc']['size'] > (MAX_SIZE * 1024) )
        {
            $json['error_a'][] = array('err_msg' => ' Larger file size selected.');
        }
        if($json !=null or $json!='' )
        {
            echo json_encode($json);
            return;
        }
        else
        {
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file')) 
            {
                $data = $this->upload->data();
                $img = [
                    'case_no' => $case_no,
                    'user_code' => $user_code,
                    'file_name' => TRACE_MAP,
                    'fetch_file_name' => $file.$data['file_ext'],
                    'file_type' => $data['file_type'],
                    'file_path' => $path.$file.$data['file_ext'],
                    'date_entry' => date('Y-m-d h:i:s'),
                    'mut_type' => 'NA',
                ];
                $insUpload = $this->db->insert('supportive_document', $img);
                if($insUpload != 1 ){
                    $this->db->trans_rollback();
                    log_message('error', '#ERRORSD002: Uploading insertion failed in supportive_document for case no :'. $case_no);
                    $json = array(
                        'error_a'=>'#ERRORSD002: NOC upload failed for Case No ' . $case_no
                    );
                    echo json_encode($json);
                    return false;
                }
                $file = file_get_contents($path.$file.$data['file_ext']);
                $file_upload = base64_encode($file);
            }
        }
        $penUser='NA';
        $rmrk="Assistant uploaded the certificate";
        $this->DashboardDataFinal($case_no);
            //////////////////////
        $application_no = $this->input->POST('application_no');
        if($application_no){
            $rmk='Uploads certificate';
            $status='F';
            $task='AST';
            $pen='NA';
            $case=$case_no;
            $encoded_file=$file_upload;
            $result= $this->RtpsModel->postApiDocBasundhara($application_no,$case,$rmk,$status,$task,$pen,$encoded_file);
            if($result->status==true || $result->status == 'true'){
                $updateSqlBasic = "update  trace_map set  status='F', date_of_order='$date_entry',certi_status='D' where case_no='$case_no'";
                $this->db->query($updateSqlBasic);
                if ($this->db->affected_rows() <=0)
                {
                    $this->db->trans_rollback();
                    log_message("error"," Cannot update status in trace_map #TM003 for dist: "
                     .$dist_code.", case_no:".$case_no);
                    $json = array(
                        'error_a'=>'Cannot save proceeding report #TM003!!'
                    );
                    echo json_encode($json);
                    return false;
                }
            }else{
                $json = array(
                    'error_a'=>'Error in Uploading. Please Try Again. Application No. ##" '.$case
                );
                echo json_encode($json);
                return false;
            }
        }
        $this->db->trans_commit();
        $json['success'] = 'true';
        $json['case_no'] = $case_no;
        $json['redirect'] = base_url()."index.php/home/index";
        echo json_encode($json);
        return;
    }
    function DashboardTracemap($case_no){
        $sql="Select * from trace_map  where case_no='$case_no' ";
        $data=$this->db->query($sql)->row_array();
        $type='TM';
        $base= array(
          'dist_code'=> $data['dist_code'],
          'subdiv_code' =>$data['subdiv_code'],
          'cir_code'=>$data['cir_code'],
          'mouza_pargona_code'=>$data['mouza_pargona_code'],
          'lot_no'=>$data['lot_no'],
          'vill_townprt_code'=>$data['vill_townprt_code'],
          'case_no'=>$data['case_no'],
          'date_of_reg'=>$data['submission_date'],
          'dag_no'=>$data['dag_no'],
          'patta_type_code' =>'NA',
          'patta_no' =>'NA',
          'status' =>'P',
          'pending_with_user' =>'CO',
          'case_type' =>$type,
          'date_of_insert'=>date("Y-m-d h:i:s")
      );
        unset($base['dag_no']);
        unset($base['patta_type_code']);
        unset($base['patta_no']);
        $this->db->insert('dashboard_data',$base);
        $action= array(
            'case_no' => $case_no,
            'user_code' => $this->session->userdata('user_code'),
            'date_of_action_taken' => date("Y-m-d h:i:s"),
            'user_designation' => $this->session->userdata('user_desig_code'),
            'remark' => 'Registered by AST',
            'ip_address'=>$this->utilityclass->get_client_ip()
        );
        $this->db->insert('dashboard_action',$action);
    }
    function DashboardData($case_no,$penUser,$rmrk){
            //////////////Update Dashboard Database///////////////////////
        $base=array(
            'pending_with_user' => $penUser,
            'date_of_update'=>date("Y-m-d h:i:s")
        );
        $this->db->where('case_no',$case_no);
        $this->db->update('dashboard_data',$base);
        $action= array(
            'case_no' => $case_no,
            'user_code' => $this->session->userdata('user_code'),
            'date_of_action_taken' => date("Y-m-d h:i:s"),
            'user_designation' => $this->session->userdata('user_desig_code'),
            'remark' => $rmrk,
            'ip_address'=>$this->utilityclass->get_client_ip()
        );
        $this->db->insert('dashboard_action',$action);
                /////////////////////////////////////
    }
    function DashboardDataFinal($case_no){
            //////////////Update Dashboard Database///////////////////////
        $base=array(
            'final_order_date' => date('Y-m-d'),
            'pending_with_user'=>'NA',
            'status'=>'F',
            'remark'=>'Final Order Passed',
            'date_of_update'=>date("Y-m-d h:i:s")
        );
        $action= array(
            'case_no' => $case_no,
            'user_code' => $this->session->userdata('user_code'),
            'date_of_action_taken' => date("Y-m-d h:i:s"),
            'user_designation' => $this->session->userdata('user_desig_code'),
            'remark' => 'uplaod',
            'ip_address'=>$this->utilityclass->get_client_ip()
        );
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
        $this->db->where('case_no',$case_no);
        $this->db->update('dashboard_data',$base);
        $action= array(
            'case_no' => $case_no,
            'user_code' => $this->session->userdata('user_code'),
            'date_of_action_taken' => date("Y-m-d h:i:s"),
            'user_designation' => $this->session->userdata('user_desig_code'),
            'remark' => $rmrk,
            'ip_address'=>$this->utilityclass->get_client_ip()
        );
        $this->db->insert('dashboard_action',$action);
    }
}