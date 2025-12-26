<?php
class Rtps extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('patta/pattamodel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('relation/relationmodel');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->model('rtps/rtpsmodel');
        $this->load->model('basundhara/basundharamodel');
        $this->load->model('mutation/mutationmodel');
        $this->load->model('validation/AuthorizationModel');
        $this->load->model('validation/FormValidationModel');
        $this->load->model('UserModel');
        $this->load->model('PetitionProceedingModel');
        $this->load->model('legacyModel');
        $this->dbswitch();
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
    ///////////////////////////////////
    function api(){
            $dist_code=$_POST['dist_code'];
            $subdiv_code=$_POST['subdiv_code'];
            $cir_code=$_POST['cir_code'];
            $mouza_code=$_POST['mouza_code'];
            $lot_no=$_POST['lot_no'];
            $village_code=$_POST['village_code'];
            $dag_no=$_POST['dag_no'];
            $application_no=$_POST['application_no'];
            $patta_no=$_POST['patta_no'];
            $date_submission=$_POST['date_submission'];
            $applicant_id=$_POST['applicant_id'];
            $data=array(
                'dist_code'=>$dist_code,
                'subdiv_code'=>$subdiv_code,
                'cir_code'=>$cir_code,
                'mouza_code'=>$mouza_code,
                'lot_no'=>$lot_no,
                'village_code'=>$village_code,
                'application_no'=>$application_no,
                'applicant_id'=>$applicant_id,
                'dag_no'=>$dag_no,
                'patta_no'=>$patta_no,
                'date_submission'=>$date_submission
            );
            $this->db->insert('basundhara',$data);
    }
    ///////////////////////////////////
    function byserviceList(){
        $d=$this->session->userdata('dist_code');
        $s=$this->session->userdata('subdiv_code');
        $c=$this->session->userdata('cir_code');
        $m=$this->session->userdata('mouza_pargona_code');
        $l=$this->session->userdata('lot_no');
        $u=$this->session->userdata('user_desig_code');
        $url = RTPS_API_LINK."allRecords/$d/$s/$c/$m/$l/$u" ;
        $output = sendCurlRequest($url);
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); // setting 10 seconds 
        // curl_setopt($ch, CURLOPT_TIMEOUT, 30); // setting 30 seconds
        // $output = curl_exec($ch);
        // curl_close($ch);
        
        if(trim($output) == '' ){
            $district['output'] = [];
            $district['message'] = 'Server is busy. Please try again later.';
        }else{
            $district['output'] = json_decode($output);
        }

        $district['_view'] = 'rtps/byservicelist';
        $this->load->view('layouts/main',$district);
    }
    function request($service){
        //var_dump($_SESSION);
        //syntax validation
        if(!preg_match('/\d/', $service)){
            redirect(base_url('index.php/rtps/byserviceList'));
        }
        $this->load->model('rtps/rtpsmodel');
        $district['pending']=$this->rtpsmodel->allLmRequest($service);
        $district['_view'] = 'rtps/request';
        $this->load->view('layouts/main',$district);
    }
    //////////////////////////
    function requestCircleOrg($service){
        //var_dump($_SESSION);
        $this->load->model('rtps/rtpsmodel');
        $district['pending']=$this->rtpsmodel->allCORequest($service);
        $district['_view'] = 'rtps/circle_total_reg_detail';
        $this->load->view('layouts/main',$district);
    }
    //////////////////////////
    function mobileUpdationBasu(){
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
        $district['app']=$output->application;
        $district['selfDecData'] = null;
        $district['aadhaarData'] = null;
        $district['aadhaarPhoto'] = null;
        $aadharData = null;
        if(isset($output->selfDeclaration) && !empty($output->selfDeclaration)){
            $district['selfDecData'] = json_decode($output->selfDeclaration[0]->dec_details);
        }
        foreach ($output->mutation as $key => $value) {
            if($value->auth_type !=null || $value->auth_type!=' '){
                $aadharData = $value;
            }
            continue;
        }
        if(isset($aadharData) && !empty($aadharData)){
            $district['aadhaarData'] = $aadharData;
        }
        if(isset($output->photo) && $output->photo != null){
            $district['aadhaarPhoto'] = $output->photo;
        }
        $district['pattaNo']=$this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$district['app']->dag_no);        
        $district['firstParty']=$output->mutation;
        $district['secParty']=$output->applicants;
        $district['document']=$output->documents;
        $district['query']=$output->query;
        $district['query']=$output->query;
        if($this->session->userdata('user_desig_code')=='ADC' ){
            $district['_view'] = 'rtps/mobileupdation_inherit';
        }else{
           $district['_view'] = 'rtps/mobileupdation'; 
        }
        $this->load->view('layouts/main',$district);
    }
    function mobileUpdationBasuCO(){
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
        $district['secParty']=$output->applicants;
        $district['document']=$output->documents;
        $district['query']=$output->query;
        $district['query']=$output->query;
        if($this->session->userdata('user_desig_code')=='CO'){
            $district['_view'] = 'rtps/mobileupdation_inherit';
        }else{
            $district['_view'] = 'rtps/mobileupdation_view';
        }
        $this->load->view('layouts/main',$district);
    }
    function inheritanceBasu(){
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
        $district['app']=$output->application;
        $district['selfDecData'] = null;
        $district['aadhaarData'] = null;
        $district['aadhaarPhoto'] = null;
        $aadharData = null;
        if(isset($output->selfDeclaration) && !empty($output->selfDeclaration)){
            $district['selfDecData'] = json_decode($output->selfDeclaration[0]->dec_details);
        }
        foreach ($output->mutation as $key => $value) {
            if($value->auth_type !=null){
                $aadharData = $value;
            }
            continue;
        }
        if(isset($aadharData) && !empty($aadharData)){
            $district['aadhaarData'] = $aadharData;
        }
        if(isset($output->photo) && $output->photo != null){
            $district['aadhaarPhoto'] = $output->photo;
        }
        $district['pattaNo']=$this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$district['app']->dag_no);        
        $district['firstParty']=$output->mutation;
        $district['secParty']=$output->applicants;
        $district['document']=$output->documents;
        $district['query']=$output->query;
        $district['user']=$this->rtpsmodel->usersForOffice($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code);
        $district['mut_type']=$this->utilityclass->mutType('i');

        $district['nok_temp']= $this->mutationmodel->NokTempData($district['app']->application_no);
        $district['genders'] = $this->mutationmodel->getGenders();
        $district['relation'] = $this->relationmodel->getRelations();

        if(($district['app']->dist_code!=$this->session->userdata('dist_code')) || ($district['app']->subdiv_code!=$this->session->userdata('subdiv_code')) || ($district['app']->cir_code!=$this->session->userdata('cir_code')) )
        {
            redirect('/home');
        }
        $params = [
          'case_no'          => $application_no,
          'service_code'     => 1,
          'remarks'          => 'Mutation Inheritance',
          'accessed_entity'  => 'Aadhaar Name, DOB, Photo',
        ];
        $this->load->model('EkycLogModel');
        $log = $this->EkycLogModel->insertEkycAccessedBy($this->db, $params);

        if($this->session->userdata('user_desig_code')=='AST'){
            $district['_view'] = 'rtps/inheritance_ofc';
        }elseif($this->session->userdata('user_desig_code')=='CO' or $this->session->userdata('user_desig_code')=='ADC'){
            $district['_view'] = 'rtps/inheritance_co_revert';
        }else{
            $district['_view'] = 'rtps/inheritance';
        }


        ///////////////////////////////////////////// property chain code //////////////////////////////////////////
        if(ENABLED_BLOCKCHAIN == 1 && in_array($district['app']->dist_code,json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
            
            $this->load->model('propChain/PropChainModel');
            // checking if chitha data and property chain data mathches
            $checkPropAndChitha =  $this->PropChainModel->chainChithaUlpinCheckProcess($district['app']->dist_code,  $district['app']->subdiv_code, $district['app']->cir_code, $district['app']->mouza_code, $district['app']->lot_no, $district['app']->village_code, $district['pattaNo']->patta_no, $district['app']->dag_no, $district['pattaNo']->dag_area_b, $district['pattaNo']->dag_area_k, $district['pattaNo']->dag_area_lc, $district['pattaNo']->dag_area_g, $district['pattaNo']->patta_type_code);

            // var_dump($pattadars);
            $district['chithaPropChainCmpFlag'] = $checkPropAndChitha['chithaPropChainCmpFlag'];
            $district['compareFlagMsg'] = $checkPropAndChitha['compareFlagMsg'];
            $district['ulpinCheck'] = $checkPropAndChitha['ulpinCheck'];
            // hidden fields
            $district['ulpin_hidden'] = $checkPropAndChitha['ulpin_hidden'];
            $district['uplpin_msg_hidden'] = $checkPropAndChitha['uplpin_msg_hidden'];
            $district['compare_hidden'] = $checkPropAndChitha['compare_hidden'];
            $district['compare_msg_hidden'] = $checkPropAndChitha['compare_msg_hidden'];

            // bhunaksha area cmp
            $district['bhuChithaCmpStatus'] = $checkPropAndChitha['bhuChithaCmpStatus'];
            $district['bhuChithaCmpMsg'] = $checkPropAndChitha['bhuChithaCmpMsg'];
            $district['bhu_hidden'] = $checkPropAndChitha['bhu_hidden'];
            $district['bhu_compare_msg_hidden'] = $checkPropAndChitha['bhu_compare_msg_hidden'];
        }
        ////////////////END//////////////////////////////////


        $this->load->view('layouts/main',$district);
    }
    function deedBasu(){
        $application_no = $this->input->get('app');//'MB/MUTI/2021/24';//$this->input->get('applid');
        $url = RTPS_API_LINK."serviceResponse?application_no=" . $application_no ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);

        $district['app']=$output->application;
        $district['selfDecData'] = null;
        $district['aadhaarData'] = null;
        $district['aadhaarPhoto'] = null;
        $aadharData = null;
        if(isset($output->selfDeclaration) && !empty($output->selfDeclaration)){
            $district['selfDecData'] = json_decode($output->selfDeclaration[0]->dec_details);
        }
        foreach ($output->mutation as $key => $value) {
            if($value->auth_type !=null){
                $aadharData = $value;
            }
            continue;
        }
        if(isset($aadharData) && !empty($aadharData)){
            $district['aadhaarData'] = $aadharData;
        }
        if(isset($output->photo) && $output->photo != null){
            $district['aadhaarPhoto'] = $output->photo;
        }

        $district['pattaNo']=$this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$district['app']->dag_no);
        $district['firstParty']=$output->mutation;
        $district['secParty']=$output->applicants;
        $district['document']=$output->documents;
        $district['query']=$output->query;
        $district['sro']=$output->sro;
        $district['user']=$this->rtpsmodel->usersForOffice($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code);
        $district['mut_type']=$this->utilityclass->mutType('o');

        $district['nok_temp']= $this->mutationmodel->NokTempData($district['app']->application_no);
        $district['genders'] = $this->mutationmodel->getGenders();
        $district['relation'] = $this->relationmodel->getRelations();

        if(($district['app']->dist_code!=$this->session->userdata('dist_code')) || ($district['app']->subdiv_code!=$this->session->userdata('subdiv_code')) || ($district['app']->cir_code!=$this->session->userdata('cir_code')) )
        {
            redirect('/home');
        }
        if($this->session->userdata('user_desig_code')=='AST'){
            $district['_view'] = 'rtps/deed_ofc';
        }elseif($this->session->userdata('user_desig_code')=='LM'){
            $district['_view'] = 'rtps/deed';
        }else{
            $district['_view'] = 'rtps/deed_revert';
        }


        ///////////////////////////////////////////// property chain code //////////////////////////////////////////
        if(ENABLED_BLOCKCHAIN == 1 && in_array($district['app']->dist_code,json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
            
            $this->load->model('propChain/PropChainModel');
            // checking if chitha data and property chain data mathches
            $checkPropAndChitha =  $this->PropChainModel->chainChithaUlpinCheckProcess($district['app']->dist_code,  $district['app']->subdiv_code, $district['app']->cir_code, $district['app']->mouza_code, $district['app']->lot_no, $district['app']->village_code, $district['pattaNo']->patta_no, $district['app']->dag_no, $district['pattaNo']->dag_area_b, $district['pattaNo']->dag_area_k, $district['pattaNo']->dag_area_lc, $district['pattaNo']->dag_area_g, $district['pattaNo']->patta_type_code);

            // var_dump($pattadars);
            $district['chithaPropChainCmpFlag'] = $checkPropAndChitha['chithaPropChainCmpFlag'];
            $district['compareFlagMsg'] = $checkPropAndChitha['compareFlagMsg'];
            $district['ulpinCheck'] = $checkPropAndChitha['ulpinCheck'];
            // hidden fields
            $district['ulpin_hidden'] = $checkPropAndChitha['ulpin_hidden'];
            $district['uplpin_msg_hidden'] = $checkPropAndChitha['uplpin_msg_hidden'];
            $district['compare_hidden'] = $checkPropAndChitha['compare_hidden'];
            $district['compare_msg_hidden'] = $checkPropAndChitha['compare_msg_hidden'];

            // bhunaksha area cmp
            $district['bhuChithaCmpStatus'] = $checkPropAndChitha['bhuChithaCmpStatus'];
            $district['bhuChithaCmpMsg'] = $checkPropAndChitha['bhuChithaCmpMsg'];
            $district['bhu_hidden'] = $checkPropAndChitha['bhu_hidden'];
            $district['bhu_compare_msg_hidden'] = $checkPropAndChitha['bhu_compare_msg_hidden'];
        }
        ////////////////END//////////////////////////////////

        
        $this->load->view('layouts/main',$district);
    }

    // Added by Abhijit -- 2024-04-09
    public function deedBasuMultiDag(){
        $application_no = $this->input->get('app');//'MB/MUTI/2021/24';//$this->input->get('applid');
        $url = RTPS_API_LINK."serviceResponseMultiGen?application_no=" . $application_no ;
        $output = sendCurlRequest($url);
        $output = json_decode($output);
        
        $application = $output->application;
        // if(MULTI_DAG_MUTATION_DEED_ACTIVE != 1){
        //     $this->session->set_flashdata('message',"This service is inactive for now.");
        //     return redirect('/home');
        // }else{
        //     if($application->service_code != 27){
        //         return $this->deedBasu();
        //     }
        // }
        if($application->is_multidag != 'Y'){
            return $this->deedBasu();
        }
        
        $district['app'] = $application;
        $district['selfDecData'] = null;
        $district['aadhaarData'] = null;
        $district['aadhaarPhoto'] = null;
        $aadharData = null;
        if(isset($output->selfDeclaration) && !empty($output->selfDeclaration)){
            $district['selfDecData'] = json_decode($output->selfDeclaration[0]->dec_details);
        }
        foreach ($output->mutation as $key => $value) {
            if($value->auth_type !=null){
                $aadharData = $value;
            }
            continue;
        }
        if(isset($aadharData) && !empty($aadharData)){
            $district['aadhaarData'] = $aadharData;
        }
        if(isset($output->photo) && $output->photo != null){
            $district['aadhaarPhoto'] = $output->photo;
        }

        $dagArray = explode(',',$district['app']->dag_no);
        foreach ($dagArray as $key => $value) {
            $landArea = $this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$value); 
            $landArea->dag_no = $value;
            $dagArray[$key] = $landArea;
        } 
        $landAreaInfo = $dagArray; 
        
        $district['pattaNo']=$this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$district['app']->dag_no);
        
        $district['firstParty']=$output->mutation;
        $district['secParty']=$output->applicants;
        $district['document']=$output->documents;
        $district['landAreaInfo'] = $landAreaInfo;
        $district['query']=$output->query;
        $district['sro']=$output->sro;
        $district['user']=$this->rtpsmodel->usersForOffice($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code);
        $district['mut_type']=$this->utilityclass->mutType('o');
        if(($district['app']->dist_code!=$this->session->userdata('dist_code')) || ($district['app']->subdiv_code!=$this->session->userdata('subdiv_code')) || ($district['app']->cir_code!=$this->session->userdata('cir_code')) )
        {
            redirect('/home');
        }
        if($this->session->userdata('user_desig_code')=='AST'){
            $district['_view'] = 'rtps/multi-dag/deed_ofc';
        }elseif($this->session->userdata('user_desig_code')=='LM'){
            $district['_view'] = 'rtps/multi-dag/deed';
        }else{
            $district['_view'] = 'rtps/deed_revert';
        }

        ///////////////////////////////////////////// property chain code //////////////////////////////////////////
        if(ENABLED_BLOCKCHAIN == 1 && in_array($district['app']->dist_code,json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
            
            $this->load->model('propChain/PropChainModel');
            // checking if chitha data and property chain data mathches
            $checkPropAndChitha =  $this->PropChainModel->chainChithaUlpinCheckProcess($district['app']->dist_code,  $district['app']->subdiv_code, $district['app']->cir_code, $district['app']->mouza_code, $district['app']->lot_no, $district['app']->village_code, $district['pattaNo']->patta_no, $district['app']->dag_no, $district['pattaNo']->dag_area_b, $district['pattaNo']->dag_area_k, $district['pattaNo']->dag_area_lc, $district['pattaNo']->dag_area_g, $district['pattaNo']->patta_type_code);

            // var_dump($pattadars);
            $district['chithaPropChainCmpFlag'] = $checkPropAndChitha['chithaPropChainCmpFlag'];
            $district['compareFlagMsg'] = $checkPropAndChitha['compareFlagMsg'];
            $district['ulpinCheck'] = $checkPropAndChitha['ulpinCheck'];
            // hidden fields
            $district['ulpin_hidden'] = $checkPropAndChitha['ulpin_hidden'];
            $district['uplpin_msg_hidden'] = $checkPropAndChitha['uplpin_msg_hidden'];
            $district['compare_hidden'] = $checkPropAndChitha['compare_hidden'];
            $district['compare_msg_hidden'] = $checkPropAndChitha['compare_msg_hidden'];

            // bhunaksha area cmp
            $district['bhuChithaCmpStatus'] = $checkPropAndChitha['bhuChithaCmpStatus'];
            $district['bhuChithaCmpMsg'] = $checkPropAndChitha['bhuChithaCmpMsg'];
            $district['bhu_hidden'] = $checkPropAndChitha['bhu_hidden'];
            $district['bhu_compare_msg_hidden'] = $checkPropAndChitha['bhu_compare_msg_hidden'];
        }
        ////////////////END//////////////////////////////////

        
        $this->load->view('layouts/main',$district);
    }

    // Added by Abhijit -- 2024-04-10
    public function deedMultiDagPost(){
        //xss & security validation starts
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }
        $resp = checkRequestValidQuery($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }    
        if($errorMessageStr != ''){
            $data=array(
                'error' => $errorMessageStr
            );
            echo json_encode($data);
            return false;
            exit;
        }
        //xss & security validation ends 
        $application_no=$_POST['application_no'];
        //////////////////
        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
                $data=array(
                    'error'=>"Case have been Registered Already. Please Check"
                );
                echo json_encode($data);
                exit;
        }
        /////////////////////
        $url = RTPS_API_LINK."serviceResponseMultiGen?application_no=" . $application_no ;
        $output = sendCurlRequest($url);
        $output = json_decode($output);

        $application = $output->application;
        
        if(!$application){
            $data=array(
                'error' => "No such case found."
            );
            echo json_encode($data);
            exit;
        }
        // if(MULTI_DAG_MUTATION_DEED_ACTIVE != 1 || $application->service_code != 27){
        //     log_message('error', '#ERRMULDRTPSCSREG0001: MULTI_DAG_MUTATION_DEED_ACTIVE is inactive or service_code is not 27');
        //     $data=array(
        //         'error' => "#ERRMULDRTPSCSREG0001: Something went wrong. Please try again later."
        //     );
        //     echo json_encode($data);
        //     exit;
        // }
        
        if($application->is_multidag != 'Y'){
            log_message('error', '#ERRMULDRTPSCSREG0001: MULTI_DAG_MUTATION_DEED_ACTIVE is inactive or service_code is not 27');
            $data=array(
                'error' => "#ERRMULDRTPSCSREG0001: Something went wrong. Please try again later."
            );
            echo json_encode($data);
            exit;
            
        }

        $data['app'] = $application;
        $data['pattaNo'] = $this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$data['app']->dag_no);
        
        $data['firstParty'] = $output->mutation;
        $data['secParty'] = $secondParties = $output->applicants;
        $data['dag_wise_land_details'] = $output->dag_wise_land_details;

        // Inplace/Along with required validation Start
        $all_inplace_along_with_present = true;
        foreach($secondParties as $secondPartyIns){
            $field_name = $secondPartyIns->mutation_deed_id . '_' . $secondPartyIns->chitha_pdar_id;
            if(!isset($_POST[$field_name]) || $_POST[$field_name] == ''){
                $all_inplace_along_with_present = false;
                break;
            }
        }

        if(!$all_inplace_along_with_present){
            $data = array(
                'error' => "\"Implace/Along With\" field(s) is(are) required"
            );
            echo json_encode($data);
            exit;
        }
        
        // Inplace/Along with required validation End

        if(($data['app']->dist_code!=$this->session->userdata('dist_code')) || ($data['app']->subdiv_code!=$this->session->userdata('subdiv_code')) || ($data['app']->cir_code!=$this->session->userdata('cir_code')) || ($data['app']->mouza_code!=$this->session->userdata('mouza_pargona_code')) || ($data['app']->lot_no!=$this->session->userdata('lot_no')) )
        {
            $data=array(
                'error' => "Please reload the page. Session might be Destroyed."
            );
            echo json_encode($data);
            return false;

            exit;
        }

        //#START PLB--->
        $dist_code = $data['app']->dist_code;

        $deed_no = $data['secParty'][0]->deed_no;
        $deed_value = $data['secParty'][0]->deed_value;
        $deed_date = $data['secParty'][0]->deed_date;

        if(RTPS_FLAG != 1){
            $deed_no = $this->input->post('deed_no');
            $deed_value = $this->input->post('deed_value');
            $deed_date = $this->input->post('deed_date');
        }

        $this->db->trans_begin();
        //$case_no=$this->rtpsmodel->genearteCaseNo('01');

        $case_name=$this->rtpsmodel->genearteCaseName();
        if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Session Out. Please try Again"
            );
            echo json_encode($data);
            exit;
            die();
        }
        // $case_no['petition_no']=$petition_no=$this->rtpsmodel->genearteFieldPetitionNo();
        // $case_no['case_no']=$case_name.$petition_no."/FMUT";

        $seq_pet = year_no . '000';
        $case_no['petition_no'] = $petition_no = $seq_pet . $this->rtpsmodel->genearteFieldPetitionNo();
        $case_no['case_no'] = $case_name . $petition_no . "/FMUT";

        $basic = array(
            'dist_code' => $data['app']->dist_code,
            'subdiv_code' => $data['app']->subdiv_code,
            'cir_code' => $data['app']->cir_code,
            'mouza_pargona_code' => $data['app']->mouza_code,
            'lot_no' => $data['app']->lot_no,
            'vill_townprt_code' => $data['app']->village_code,
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d'),
            'case_no' => $case_no['case_no'],
            'trans_code' => $this->input->post('mut_type'),
            'dispute_yn' => 0,
            'possession_yn' => 'y',
            'petition_no' => $case_no['petition_no'],
            'year_no' => date('Y'),
            'report_date' => date('Y-m-d'),
            'mut_type' => '01',                    
            'operation' => 'E',
            'user_code' => $this->session->userdata('user_code'),
            'noc_no' => $data['secParty'][0]->noc_no,
            'noc_date' => $data['secParty'][0]->noc_date,
            'reg_deed_no' => $deed_no,
            'deed_value' => $deed_value,
            'reg_deed_date' => $deed_date,
            'is_multidag' => 'Y'
        );

        $insFieldBasicFMUTD = $this->db->insert('field_mut_basic',$basic);
        if($insFieldBasicFMUTD != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRFMUTMULD001: Insertion failed in field_mut_basic for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRFMUTMULD001: Registration of Field Mutation by Deed failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }
        //////Buyer Insert////////////
        $i=1;
        $remove_applicants = [];
        if(isset($_POST['remove_applicant']) && count($_POST['remove_applicant'])){
            $remove_applicants = $_POST['remove_applicant'];
        }

        foreach($data['firstParty'] as $key => $pet){
            $file = null;

            if(!in_array($key, $remove_applicants)){
                if($pet->is_applicant == '1'){
                    if(!empty($output->selfDeclaration[0]->dec_details)){
                        $dec = $output->selfDeclaration[0]->dec_details;
                    }else{
                        $dec = null;
                    }
                    $auth_type = $pet->auth_type;
                    $id_ref_no = $pet->id_ref_no;
                    if($pet->auth_type=='AADHAAR'){
                        $uploadpath   = AADHAAR_UPLOAD_DIR;
                        $imagebase64  = $output->photo;
                        $file         = $uploadpath . $pet->id_ref_no . '.json';
                        file_put_contents($file, $imagebase64);
                    }
                    $photo = $file;
                }else{
                    $dec= null;
                    $auth_type = null;
                    $id_ref_no = null;
                    $photo = null;
                }
                $faddress=$this->address($pet->address);
                $buyerInsert = array(
                    'dist_code' => $data['app']->dist_code,
                    'subdiv_code' => $data['app']->subdiv_code,
                    'cir_code' => $data['app']->cir_code,
                    'mouza_pargona_code' => $data['app']->mouza_code,
                    'lot_no' => $data['app']->lot_no,
                    'vill_townprt_code' => $data['app']->village_code,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d'),
                    'case_no' => $case_no['case_no'],
                    'petition_no' => $case_no['petition_no'],
                    'year_no' => date('Y'),
                    'operation' => 'E',
                    'pet_name' => $pet->pat_name_ass,
                    'guard_name' => $pet->pat_gurdian_name_ass,
                    'guard_rel' => $this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->pat_gurdian_rel_id),/////////////
                    'pet_gender'=> $this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->pat_gender),
                    //'add1' => $pet->address,
                    'add1' => $faddress[0],
                    'add2' => $faddress[1],
                    'pet_id' => $i++,
                    'pdar_mobile' => $pet->pat_mobile_no,
                    'new_pet_name' => $pet->chitha_pdar_id > 0 ? null : 'N',
                    'pdar_id' => $pet->chitha_pdar_id > 0 ? $pet->chitha_pdar_id : null,
                    'self_declaration' => $dec,
                    'auth_type' => $auth_type,
                    'id_ref_no'=> $id_ref_no,
                    'photo' => $photo,
                    'pdar_name_eng' => $pet->pat_name_eng,
                    'pdar_guard_eng' => $pet->pat_gurdian_name_eng,
    
                    'marital_status' => $pet->marital_status,
                    'applicant_occupation' => $pet->applicant_occupation,
                    'caste_category' => $pet->caste_category,
                    'tribe_category' => $pet->tribe_category ?? NULL,
                );
    
                $insFieldPetFMUTD = $this->db->insert('field_mut_petitioner', $buyerInsert);
                if($insFieldPetFMUTD != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRFMUTMULD002: Insertion failed in field_mut_petitioner for RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRFMUTMULD002: Registration of Field Mutation by Deed failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
            }
        }

        ////////Seller Insert//////////
        foreach($data['secParty'] as $pet){
            //////////////////////////////////
            $pattaDetails = $this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no, $data['app']->village_code, $pet->dag_no);

            if($pet->gurdian_name_ass == '' || $pet->gurdian_name_ass == null){
                $pet_father_name = $this->getGuardianName($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->village_code,$data['app']->lot_no,$pet->dag_no,$pattaDetails->patta_no,$pattaDetails->patta_type_code,$pet->chitha_pdar_id);
                if($pet_father_name->num_rows() <= 0){
                    $this->db->trans_rollback();
                    $data=array(
                        'error'=>"Error in submitting.Gurdian Name is Missing. Please try Again"
                    ); 
                    echo json_encode($data);
                    return;   
                }else{
                    $pet->gurdian_name_ass = trim($pet_father_name->row()->pdar_father);
                }

            }else{
                $pet->gurdian_name_ass=$pet->gurdian_name_ass;
            }
            ///////////////////////////
            $sellerInsert = array(
                'dist_code'             =>  $data['app']->dist_code,
                'subdiv_code'           =>  $data['app']->subdiv_code,
                'cir_code'              =>  $data['app']->cir_code,
                'mouza_pargona_code'    =>  $data['app']->mouza_code,
                'lot_no'                =>  $data['app']->lot_no,
                'vill_townprt_code'     =>  $data['app']->village_code,
                'user_code'             =>  $this->session->userdata('user_code'),
                'date_entry'            =>  date('Y-m-d'),
                'case_no'               =>  $case_no['case_no'],
                'petition_no'           =>  $case_no['petition_no'],
                'year_no'               =>  date('Y'),
                'operation'             =>  'E',
                'dag_no'                =>  $pet->dag_no,
                'patta_no'              =>  $pattaDetails->patta_no,
                'patta_type_code'       =>  $pattaDetails->patta_type_code,
                // 'patta_no'              =>  $this->input->post('patta_no') , // this field was hidden field
                // 'patta_type_code'       =>  $this->input->post('patta_type') , // this field was hidden field
                'pdar_id'               =>  $pet->chitha_pdar_id,
                'pdar_cron_no'          =>  $pet->chitha_pdar_id,
                'pdar_name'             =>  $pet->name_ass,
                'pdar_guardian'         =>  $pet->gurdian_name_ass,
                'striked_out'           =>  $this->input->post($pet->mutation_deed_id . '_' . $pet->chitha_pdar_id),/////for inheritance//////
                'pdar_rel_guar'         =>  'u',//$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->gurdian_relation_id),/////////////
                'pdar_gender'           =>  'm',//$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->gender),
            );
            //var_dump($sellerInsert);
            $insFieldMutPattaFMUTD = $this->db->insert('field_mut_pattadar', $sellerInsert);
            if($insFieldMutPattaFMUTD != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRFMUTMULD003: Insertion failed in field_mut_pattadar for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRFMUTMULD003: Registration of Field Mutation by Deed failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
        }

        // Insert dag details
        if(count($data['dag_wise_land_details'])){
            foreach($data['dag_wise_land_details'] as $dag_detail){
                $pattaDetails = $this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$dag_detail->dag_no);

                if(in_array($dist_code, json_decode(BARAK_VALLEY))){
                    $dag_area_g = $pattaDetails->dag_area_g == null ? "0" : $pattaDetails->dag_area_g;
                    $dag_area_kr = $pattaDetails->dag_area_kr == null ? "0" : $pattaDetails->dag_area_kr;
                }
                else{
                    $dag_area_g = 0;
                    $dag_area_kr = 0;
                }

                $dagDetails = array(
                                    'dist_code'           =>    $data['app']->dist_code,
                                    'subdiv_code'         =>    $data['app']->subdiv_code,
                                    'cir_code'            =>    $data['app']->cir_code,
                                    'mouza_pargona_code'  =>    $data['app']->mouza_code,
                                    'lot_no'              =>    $data['app']->lot_no,
                                    'vill_townprt_code'   =>    $data['app']->village_code,
                                    'user_code'           =>    $this->session->userdata('user_code'),
                                    'date_entry'          =>    date('Y-m-d'),
                                    'case_no'             =>    $case_no['case_no'],
                                    'petition_no'         =>    $case_no['petition_no'],
                                    'year_no'             =>    date('Y'),
                                    'operation'           =>    'E',
                                    'dag_no'              =>    $dag_detail->dag_no,
                                    'patta_no'            =>    $pattaDetails->patta_no,
                                    'patta_type_code'     =>    $pattaDetails->patta_type_code,
                                    // 'patta_no'            =>    $this->input->post('patta_no') ,
                                    // 'patta_type_code'     =>    $this->input->post('patta_type') ,
                                    'm_dag_area_b'        =>    RTPS_FLAG == 1 ? $dag_detail->area_b : $this->input->post('mut_area_b['. $dag_detail->dag_no .']'),
                                    'm_dag_area_k'        =>    RTPS_FLAG == 1 ? $dag_detail->area_k : $this->input->post('mut_area_k['. $dag_detail->dag_no .']'),
                                    'm_dag_area_lc'       =>    RTPS_FLAG == 1 ? $dag_detail->area_l : $this->input->post('mut_area_l['. $dag_detail->dag_no .']'),
                                    'm_dag_area_g'        =>    RTPS_FLAG == 1 ? $dag_detail->area_go : $this->input->post('mut_area_g['. $dag_detail->dag_no .']'),
                                    'm_dag_area_kr'       =>    RTPS_FLAG == 1 ? $dag_detail->area_ka : 0 ,
                                    // 'm_dag_area_b'        =>    $_POST['mut_area_b'],
                                    // 'm_dag_area_k'        =>    $_POST['mut_area_k'],
                                    // 'm_dag_area_lc'       =>    $_POST['mut_area_l'],
                                    // 'm_dag_area_g'        =>    $_POST['mut_area_g'],
                                    // 'm_dag_area_kr'       =>    0,
                                    'dag_area_b'          =>    $pattaDetails->dag_area_b,
                                    'dag_area_k'          =>    $pattaDetails->dag_area_k,
                                    'dag_area_lc'         =>    $pattaDetails->dag_area_lc,  
                                    'dag_area_g'          =>    $dag_area_g,
                                    'dag_area_kr'         =>    $dag_area_kr,
                                    'remark'              =>    addslashes(trim($this->input->post('remark'))),
                                    'deed_reg_no'         =>    $dag_detail->deed_no,
                                    'deed_date'           =>    $dag_detail->deed_date,
                                    'deed_value'          =>    $dag_detail->deed_value,
                                );

                $insFieldMutDagDetFMUTD = $this->db->insert('field_mut_dag_details',$dagDetails);
                if($insFieldMutDagDetFMUTD != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRFMUTMULD004: Insertion failed in field_mut_dag_details for RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRFMUTMULD004: Registration of Field Mutation by Deed failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
            }
        }
        
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
                    
                }
                else{
                    $data=array(
                        'error' => 'File is required'
                    );
                    echo json_encode($data);
                    return false;
                }
            }
        }
        ///////////////////Insert attached file////////////////////////
        if(isset($_FILES['fileUpload']['name'])){
            for($i = 0; $i < $fileCount; $i++)
            {
                $_FILES['file']['name'] = $_FILES['fileUpload']['name'][$i];
                $_FILES['file']['type'] = $_FILES['fileUpload']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['fileUpload']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['fileUpload']['error'][$i];
                $_FILES['file']['size'] = $_FILES['fileUpload']['size'][$i];
                $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                $exp  = explode("/",$mime);
                $onlyExtension  = $exp[1];
                $replaceCase=str_replace("/","-",$case_no['case_no']);
                $fileRename =  $replaceCase."-".time() . '.' . $onlyExtension;
                $config['upload_path']   = MANUAL_ATTACHMENT;
                $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                $config['max_size']  = ALLOWED_UPLOAD_FILE_SIZE;
                $config['file_name'] = $fileRename;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('file'))
                {
                    $document= array(
                        'case_no'   => $case_no['case_no'],
                        'file_name' => $_POST['fileText'][$i],
                        'user_code' => $this->session->userdata('user_code'),
                        // 'fetch_file_name' => $_FILES['file']['name'],
                        'fetch_file_name' => $_POST['fileText'][$i],
                        'file_type'  => $_FILES['file']['type'],
                        'file_path'  => MANUAL_ATTACHMENT . $fileRename,
                        'date_entry' => date('Y-m-d h:i:s'),
                        'mut_type'   => 'FM',
                    );
                    // save data in attachment file
                    $addMoreDocQuery = $this->db->insert('supportive_document',$document);
                    if($addMoreDocQuery != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRADDDOC0004: Insertion failed in supportive document RTPS Case No '.$case_no);
                        $data=array(
                            'error' => "#ERRADDDOC0004: Registration of Settlement failed for case no : ".$case_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }
                else
                {
                    $this->db->trans_rollback();
                    // todo error show
                    // redirect to respected route with error mgs
                    log_message('error', '#ERRADDDOC0005: Insertion failed in supportive document RTPS Case No '.$case_no);
                    $data=array(
                        'error' => "#ERRADDDOC0005: Registration of Settlement failed for case no : ".$case_no
                    );
                    echo json_encode($data);
                    return false;

                }
            }
        }
        

           $remark=addslashes(trim($this->input->post('remark')));

           $proInsert = $this->mutationmodel->proceeding_order($case_no['case_no'], $remark);


           if($proInsert==false || $proInsert===false)
            {
                log_message('error', "#FMUTMULDLM001:".$this->db->last_query());
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Updation failed(#FMUTMULDLM001)".$application_no);
                redirect(base_url() . "index.php/home");
            }

            $basundhara=array(
                'dharitree'=>$case_no['case_no'],
                'basundhara'=>$application_no,
                'date_reg'=>date('Y-m-d'),
                'reg_by'=>$this->session->userdata('user_code'),
                'app_status'=>'P',
                'pending_with'=>'CO'
            );

            //////////UUID Insert/////////////
            $basundhara['uuid']=$this->utilityclass->getVillageUUID($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code);
            ///////////////////////
            $insBasuFMUTD = $this->db->insert('basundhar_application',$basundhara);
            if($insBasuFMUTD != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRFMUTMULD005: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRFMUTMULD005: Registration of Field Mutation by Deed failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }

            $all_row_updated = $this->updateCaseIdForNok($application_no, $case_no['case_no']);
            if(!$all_row_updated){
                log_message('error', '#ERRFMUTMULDNOK001: Failed update nok for RTPS Case No '.$application_no . ' Last Query => ' . $this->db->last_query());
                $this->db->trans_rollback();
                $data = array(
                    'error'=>"#ERRFMUTMULDNOK001: Registration of Field Mutation by Deed failed for case no : ".$application_no
                );

                return response_json($data);
            }
            
            if($this->db->trans_status()==FALSE){
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"Error in submitting. Please try Again"
                );
                echo json_encode($data);
                return;
            }
            else
            {                
                //////////////POST To rtps/////////////////////
                $url = RTPS_API_LINK . "applicationStatusUpdate";
                $post_array = [
                                'application' => $application_no,
                                'dharitree' => $case_no['case_no'],
                                'rmk' => 'all ok',
                                'status' => 'M',
                                'task' => 'LM',
                                'pen'=>'CO'
                            ];

                $result = sendCurlRequest($url, 'POST', $post_array);

                if($result === true || $result=='true' || $result==1 || json_decode($result)=='true'|| json_decode($result)==true || json_decode($result)=='y' || $result=='y'){
                    $this->db->trans_commit();
                }else{
                    $data=array(
                        'error'=>"Error in submitting. Please try Again"
                    );
                    echo json_encode($data);
                    return;
                }

                $this->DashboardPartitionField($case_no['case_no']);
                $this->session->set_flashdata('message',"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no] ");
                //////////////////////////////////
                $data=array(
                    'success'=>"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no]",
                    'redirect_url'=>base_url().'index.php/home'
                );
            }
        echo json_encode($data);
    }

    protected function updateCaseIdForNok($rtps_case_id, $dharitree_case_id){
        $all_updated = true;
        $noks = $this->mutationmodel->NokTempData($rtps_case_id);
        $noks_count = count((array) $noks);
        $affected_row = 0;
        if($noks_count > 0){
            $this->db->where('case_id', $rtps_case_id)->update('nok_tmp', ['case_id' => $dharitree_case_id]);
            $affected_row = $this->db->affected_rows();
        }

        if($affected_row != $noks_count){
            $all_updated = false;
        }

        return $all_updated;
    }

    // public function addNokOld(){
    //     // $rtps_no = 
    //     if(isset($_POST['applicant_name']) && count($_POST['applicant_name'])){
    //         foreach($_POST['applicant_name'] as $key => $new_applicant){
    //             $faddress=$this->address($_POST['app_address'][$key]);
    //             $buyerInsert = array(
    //                 'dist_code' => $data['app']->dist_code,
    //                 'subdiv_code' => $data['app']->subdiv_code,
    //                 'cir_code' => $data['app']->cir_code,
    //                 'mouza_pargona_code' => $data['app']->mouza_code,
    //                 'lot_no' => $data['app']->lot_no,
    //                 'vill_townprt_code' => $data['app']->village_code,
    //                 'user_code' => $this->session->userdata('user_code'),
    //                 'date_entry' => date('Y-m-d'),
    //                 'case_no' => $case_no['case_no'],
    //                 'petition_no' => $case_no['petition_no'],
    //                 'year_no' => date('Y'),
    //                 'operation' => 'E',
    //                 'pet_name' => $_POST['applicant_name'][$key],
    //                 'guard_name' => $_POST['guardian_name'][$key],
    //                 'guard_rel' => $this->utilityclass->relationRevertBasu($data['app']->dist_code,$_POST['app_relation'][$key]),/////////////
    //                 'pet_gender'=> $this->utilityclass->gnderRevertBasu($data['app']->dist_code,$_POST['app_gender'][$key]),
    //                 //'add1' => $pet->address,
    //                 'add1' => $faddress[0],
    //                 'add2' => $faddress[1],
    //                 'pet_id' => $i++,
    //                 'pdar_mobile' => $_POST['app_mobile'][$key],
    //                 'new_pet_name' => 'N',
    //                 'pdar_id' => null,
    //                 'self_declaration' => null,
    //                 'auth_type' => null,
    //                 'id_ref_no'=> null,
    //                 'photo' => null,
    //                 'pdar_name_eng' => null,
    //                 'pdar_guard_eng' => null,
    
    //                 'marital_status' => $_POST['app_marital_status'][$key],
    //                 'applicant_occupation' => $_POST['app_occu'][$key],
    //                 'caste_category' => $_POST['app_caste'][$key],
    //                 'tribe_category' => $_POST['app_caste'][$key] == '6' ? null : $_POST['app_protected_class'][$key],
    //             );
    
    //             $insFieldPetFMUTD = $this->db->insert('field_mut_petitioner', $buyerInsert);
    //             if($insFieldPetFMUTD != 1)
    //             {
    //                 $this->db->trans_rollback();
    //                 log_message('error', '#ERRFMUTMULDNEW002: Insertion failed in field_mut_petitioner for RTPS Case No '.$application_no);
    //                 $data = array(
    //                     'error'=>"#ERRFMUTMULDNEW002: Registration of Field Mutation by Deed failed for case no : ".$application_no
    //                 );
    //                 echo json_encode($data);
    //                 return false;
    //             }
    //         }
    //     }
    // }

    public function addNok()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $FmLmReport = array(
                array(
                    'field' => 'dist_code',
                    'label' => 'Dist Code',
                    'rules' => 'trim|required|xss_clean',
                ),
                array(
                    'field' => 'case_id',
                    'label' => 'Case No',
                    'rules' => 'trim|required|xss_clean',
                ),
                array(
                    'field' => 'name_asm',
                    'label' => 'Applicant Name',
                    'rules' => 'trim|required|xss_clean',
                ),
                array(
                    'field' => 'gender',
                    'label' => 'Gender',
                    'rules' => 'trim|required|xss_clean',
                ),
                array(
                    'field' => 'dob',
                    'label' => 'Date of Birth',
                    'rules' => 'trim|required|xss_clean',
                ),
                array(
                    'field' => 'guardian_name_asm',
                    'label' => 'Guardian Name',
                    'rules' => 'trim|required|xss_clean',
                ),
                array(
                    'field' => 'relation',
                    'label' => 'Guardian Relation',
                    'rules' => 'trim|required|xss_clean',
                ),
                array(
                    'field' => 'address',
                    'label' => 'Address',
                    'rules' => 'trim|required|xss_clean',
                ),
                array(
                    'field' => 'caste_category',
                    'label' => 'Caste Category',
                    'rules' => 'trim|required|xss_clean',
                ),
                array(
                    'field' => 'applicant_occupation',
                    'label' => 'Occupation',
                    'rules' => 'trim|required|xss_clean',
                ),
                array(
                    'field' => 'marital_status',
                    'label' => 'Marital Status',
                    'rules' => 'trim|required|xss_clean',
                ),
            );

            $this->form_validation->set_rules($FmLmReport);
            $this->form_validation->set_message('integer', 'This %s is not valid');

            if ($this->form_validation->run() === FALSE) {
                $this->form_validation->set_error_delimiters('', '');
                foreach ($FmLmReport as $rule) {
                    if (form_error($rule['field'])) {
                        $validation['error'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
                    }
                }
                echo json_encode($validation);
                return;
            } else {
                $arr = $this->input->post();
                $dist_code = $arr['dist_code'];
                unset($arr['dist_code']);
                $arr['gender'] = $this->utilityclass->gnderRevertBasu($dist_code, $arr['gender']);
                $arr['relation'] = $this->utilityclass->relationRevertBasu($dist_code, $arr['relation']);
                if($arr['caste_category'] == 6){
                    $arr['tribe_category'] = NULL;
                }
                $validation['validation_success'] = "true";
                $arr['user_code']=$this->session->userdata('user_code');
                $arr['ip']=$this->utilityclass->get_client_ip();
                $validation['success'] = $this->mutationmodel->FmAddApplicant($arr);
                
                $noks = $this->mutationmodel->NokTempData($arr['case_id']);

                return response_json([
                                        'data' => $this->manageNoksData($noks),
                                        'success' => true,
                                        'message' => 'Applicant Inserted successfully'
                                    ]);
            }
        }
    }

    public function getNoks(){
        $caseId = $_POST['case_id']; 
        $noks = $this->mutationmodel->NokTempData($caseId);

        return response_json([
                                'data' => $this->manageNoksData($noks),
                                'success' => true,
                                'message' => 'Data fetched successfully'
                            ]);
    }

    private function manageNoksData($noks){
        foreach($noks as $key => $nok){
            $noks[$key]->gender_name = $this->utilityclass->gender($nok->gender);
            $noks[$key]->marital_status_name = $this->utilityclass->getMaritalStatusName($nok->marital_status);
            $noks[$key]->caste_category_name = $this->utilityclass->getCasteCategoryName($nok->caste_category);
            $noks[$key]->tribe_category_name = !empty($nok->tribe_category) ? $this->utilityclass->getTribeCategoryName($nok->tribe_category) : '';
        }

        return $noks;
    }

    /////////////////////
    public function deleteNok()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $case_id = $this->input->post('case_id');
            $row_id = $this->input->post('row_id');

            $delete_fm_record = $this->mutationmodel->DeleteNokTmpFMApp($row_id, $case_id);

            return response_json([
                'data' => [],
                'success' => true,
                'message' => 'Applicant deleted successfully'
            ]);
        }
    }

    function document($doc){
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."attachment");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'name' => $doc
        )));
        $result = curl_exec($curl_handle);
        $result = json_decode($result);
        $output=$result->raw_data;
        $content_type=$result->mime_type;
        $check=explode("/",$content_type);
        if($check[1]=='pdf'){
            $output=base64_decode($output);
            header('Content-type: application/pdf');
            echo $output;
        }else{
            echo '<img src="data:'.$content_type.';base64,'.$output.'" />';
        }
    }
    function partitionBasu(){
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
        $district['app']=$output->application;
        $district['selfDecData'] = null;
        $district['aadhaarData'] = null;
        $district['aadhaarPhoto'] = null;
        $aadharData = null;
        if(isset($output->selfDeclaration) && !empty($output->selfDeclaration)){
            $district['selfDecData'] = json_decode($output->selfDeclaration[0]->dec_details);
        }
        foreach ($output->mutation as $key => $value) {
            if($value->auth_type !=null){
                $aadharData = $value;
            }
            continue;
        }
        if(isset($aadharData) && !empty($aadharData)){
            $district['aadhaarData'] = $aadharData;
        }
        if(isset($output->photo) && $output->photo != null){
            $district['aadhaarPhoto'] = $output->photo;
        }
        $district['pattaNo']=$this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$district['app']->dag_no);
        //print_r($district['pattaNo']);
        $district['firstParty']=$output->mutation;
        $district['document']=$output->documents;
        $district['query']=$output->query;
        $district['query']=$output->query;
        $district['user']=$this->rtpsmodel->usersForOffice($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code);
        if(($district['app']->dist_code!=$this->session->userdata('dist_code')) || ($district['app']->subdiv_code!=$this->session->userdata('subdiv_code')) || ($district['app']->cir_code!=$this->session->userdata('cir_code')) )
        {
            redirect('/home');
        }
        if($this->session->userdata('user_desig_code')=='AST'){
            $district['_view'] = 'rtps/partition_basu_ofc';
        }elseif($this->session->userdata('user_desig_code')=='LM'){
           $district['_view'] = 'rtps/partition_basu';
        }else{
           $district['_view'] = 'rtps/partition_basu_revert';
        }


        ///////////////////////////////////////////// property chain code //////////////////////////////////////////
        if(ENABLED_BLOCKCHAIN == 1 && in_array($district['app']->dist_code,json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
            
            $this->load->model('propChain/PropChainModel');
            // checking if chitha data and property chain data mathches
            $checkPropAndChitha =  $this->PropChainModel->chainChithaUlpinCheckProcess($district['app']->dist_code,  $district['app']->subdiv_code, $district['app']->cir_code, $district['app']->mouza_code, $district['app']->lot_no, $district['app']->village_code, $district['pattaNo']->patta_no, $district['app']->dag_no, $district['pattaNo']->dag_area_b, $district['pattaNo']->dag_area_k, $district['pattaNo']->dag_area_lc, $district['pattaNo']->dag_area_g, $district['pattaNo']->patta_type_code);

            // var_dump($pattadars);
            $district['chithaPropChainCmpFlag'] = $checkPropAndChitha['chithaPropChainCmpFlag'];
            $district['compareFlagMsg'] = $checkPropAndChitha['compareFlagMsg'];
            $district['ulpinCheck'] = $checkPropAndChitha['ulpinCheck'];
            // hidden fields
            $district['ulpin_hidden'] = $checkPropAndChitha['ulpin_hidden'];
            $district['uplpin_msg_hidden'] = $checkPropAndChitha['uplpin_msg_hidden'];
            $district['compare_hidden'] = $checkPropAndChitha['compare_hidden'];
            $district['compare_msg_hidden'] = $checkPropAndChitha['compare_msg_hidden'];

            // bhunaksha area cmp
            $district['bhuChithaCmpStatus'] = $checkPropAndChitha['bhuChithaCmpStatus'];
            $district['bhuChithaCmpMsg'] = $checkPropAndChitha['bhuChithaCmpMsg'];
            $district['bhu_hidden'] = $checkPropAndChitha['bhu_hidden'];
            $district['bhu_compare_msg_hidden'] = $checkPropAndChitha['bhu_compare_msg_hidden'];
        }
        ////////////////END//////////////////////////////////


        $this->load->view('layouts/main',$district);
    }
    function allotmentBasu(){

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
        $district['app']=$output->application;
        $district['selfDecData'] = null;
        $district['aadhaarData'] = null;
        $district['aadhaarPhoto'] = null;
        $aadharData = null;
        if(isset($output->selfDeclaration) && !empty($output->selfDeclaration)){
            $district['selfDecData'] = json_decode($output->selfDeclaration[0]->dec_details);
        }
        foreach ($output->mutation as $key => $value) {
            if($value->auth_type !=null || $value->auth_type!=' '){
                $aadharData = $value;
            }
            continue;
        }
        if(isset($aadharData) && !empty($aadharData)){
            $district['aadhaarData'] = $aadharData;
        }
        if(isset($output->photo) && $output->photo != null){
            $district['aadhaarPhoto'] = $output->photo;
        }
        $district['pattaNo']=$this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$district['app']->dag_no);
        //var_dump($district['pattaNo']);
        $district['firstParty']=$output->mutation;
        $district['document']=$output->documents;
        $district['query']=$output->query;
        if(($district['app']->dist_code!=$this->session->userdata('dist_code')) || ($district['app']->subdiv_code!=$this->session->userdata('subdiv_code')) || ($district['app']->cir_code!=$this->session->userdata('cir_code')) )
        {
            redirect('/home');
        }

        ///////////////////////////////////////////// property chain code //////////////////////////////////////////
        if(ENABLED_BLOCKCHAIN == 1 && in_array($district['app']->dist_code,json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
            
            $this->load->model('propChain/PropChainModel');
            // checking if chitha data and property chain data mathches
            $checkPropAndChitha =  $this->PropChainModel->chainChithaUlpinCheckProcess($district['app']->dist_code,  $district['app']->subdiv_code, $district['app']->cir_code, $district['app']->mouza_code, $district['app']->lot_no, $district['app']->village_code, $district['pattaNo']->patta_no, $district['app']->dag_no, $district['pattaNo']->dag_area_b, $district['pattaNo']->dag_area_k, $district['pattaNo']->dag_area_lc, $district['pattaNo']->dag_area_g, $district['pattaNo']->patta_type_code);

            // var_dump($pattadars);
            $district['chithaPropChainCmpFlag'] = $checkPropAndChitha['chithaPropChainCmpFlag'];
            $district['compareFlagMsg'] = $checkPropAndChitha['compareFlagMsg'];
            $district['ulpinCheck'] = $checkPropAndChitha['ulpinCheck'];
            // hidden fields
            $district['ulpin_hidden'] = $checkPropAndChitha['ulpin_hidden'];
            $district['uplpin_msg_hidden'] = $checkPropAndChitha['uplpin_msg_hidden'];
            $district['compare_hidden'] = $checkPropAndChitha['compare_hidden'];
            $district['compare_msg_hidden'] = $checkPropAndChitha['compare_msg_hidden'];

            // bhunaksha area cmp
            $district['bhuChithaCmpStatus'] = $checkPropAndChitha['bhuChithaCmpStatus'];
            $district['bhuChithaCmpMsg'] = $checkPropAndChitha['bhuChithaCmpMsg'];
            $district['bhu_hidden'] = $checkPropAndChitha['bhu_hidden'];
            $district['bhu_compare_msg_hidden'] = $checkPropAndChitha['bhu_compare_msg_hidden'];
        }
        ////////////////END//////////////////////////////////

        
        if($this->session->userdata('user_desig_code')=='ADC' or $this->session->userdata('user_desig_code')=='CO' or $this->session->userdata('user_desig_code')=='CO'){

            $allowed = ['CO', 'ADC'];
            $user_desig_code = $this->session->userdata('user_desig_code');

            // Restrict access if not in allowed list
            if ( ! in_array($user_desig_code, $allowed)) {
                echo json_encode(['error' => 'Unauthorized access']);
                exit; // or die();
            }
            $district['_view'] = 'rtps/allotment_basu_revert';
        }else{
            $allowed = ['AST'];
            $user_desig_code = $this->session->userdata('user_desig_code');

            // Restrict access if not in allowed list
            if ( ! in_array($user_desig_code, $allowed)) {
                echo json_encode(['error' => 'Unauthorized access']);
                exit; // or die();
            }
           $district['_view'] = 'rtps/allotment_basu';
        }
        $this->load->view('layouts/main',$district);
    }
    function conversionBasu(){
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
        $district['app']=$output->application;
        $district['selfDecData'] = null;
        $district['aadhaarData'] = null;
        $district['aadhaarPhoto'] = null;
        $aadharData = null;
        if(isset($output->selfDeclaration) && !empty($output->selfDeclaration)){
            $district['selfDecData'] = json_decode($output->selfDeclaration[0]->dec_details);
        }
        //modified by hriday - 25-04-2024
        if(isset($output->mutation) && !empty($output->mutation)) {
            foreach ($output->mutation as $key => $value) {
                if(isset($value->auth_type) && $value->auth_type !=null){
                    $aadharData = $value;
                }
                continue;
            }
            // end modified
        }
        if(isset($aadharData) && !empty($aadharData)){
            $district['aadhaarData'] = $aadharData;
        }
        if(isset($output->photo) && $output->photo != null){
            $district['aadhaarPhoto'] = $output->photo;
        }
        $district['pattaNo']=$this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$district['app']->dag_no);
        //var_dump($district['pattaNo']);
        $district['firstParty']=$output->mutation;
        $district['document']=$output->documents;
        $district['query']=$output->query;
        $district['user']=$this->rtpsmodel->usersForOffice($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code);
        if(($district['app']->dist_code!=$this->session->userdata('dist_code')) || ($district['app']->subdiv_code!=$this->session->userdata('subdiv_code')) || ($district['app']->cir_code!=$this->session->userdata('cir_code')) )
        {
            redirect('/home');
        }



        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
            $this->load->model('propChain/PropChainModel');
             // checking if chitha data and property chain data mathches
            $checkPropAndChitha =  $this->PropChainModel->chainChithaUlpinCheckProcess($district['app']->dist_code,  $district['app']->subdiv_code, $district['app']->cir_code, $district['app']->mouza_code, $district['app']->lot_no, $district['app']->village_code, $district['pattaNo']->patta_no, $district['app']->dag_no, $district['pattaNo']->dag_area_b, $district['pattaNo']->dag_area_k, $district['pattaNo']->dag_area_lc, $district['pattaNo']->dag_area_g, $district['pattaNo']->patta_type_code);

            // var_dump($pattadars);
            $district['chithaPropChainCmpFlag'] = $checkPropAndChitha['chithaPropChainCmpFlag'];
            $district['compareFlagMsg'] = $checkPropAndChitha['compareFlagMsg'];
            $district['ulpinCheck'] = $checkPropAndChitha['ulpinCheck'];
            // hidden fields
            $district['ulpin_hidden'] = $checkPropAndChitha['ulpin_hidden'];
            $district['uplpin_msg_hidden'] = $checkPropAndChitha['uplpin_msg_hidden'];
            $district['compare_hidden'] = $checkPropAndChitha['compare_hidden'];
            $district['compare_msg_hidden'] = $checkPropAndChitha['compare_msg_hidden'];

            // bhunaksha area cmp
            $district['bhuChithaCmpStatus'] = $checkPropAndChitha['bhuChithaCmpStatus'];
            $district['bhuChithaCmpMsg'] = $checkPropAndChitha['bhuChithaCmpMsg'];
            $district['bhu_hidden'] = $checkPropAndChitha['bhu_hidden'];
            $district['bhu_compare_msg_hidden'] = $checkPropAndChitha['bhu_compare_msg_hidden'];
        }

        $params = [
          'case_no'          => $application_no,
          'service_code'     => 9,
          'remarks'          => 'Conversion',
          'accessed_entity'  => 'Aadhaar Name, DOB, Photo',
        ];
        $this->load->model('EkycLogModel');
        $log = $this->EkycLogModel->insertEkycAccessedBy($this->db, $params);



        if(($this->session->userdata('user_desig_code')=='CO') or ($this->session->userdata('user_desig_code')=='ADC')){
            $district['_view'] = 'rtps/conversion_basu_revert';
        }else{
            $district['_view'] = 'rtps/conversion_basu';
        }
        $this->load->view('layouts/main',$district);
    }
    /////////////Inheritance Post///////////
    function deedPost(){
        //xss & security validation starts
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }
        $resp = checkRequestValidQuery($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }    
        if($errorMessageStr != ''){
            $data=array(
                'error' => $errorMessageStr
            );
            echo json_encode($data);
            return false;
            exit;
        }
        //xss & security validation ends 
        $application_no=$_POST['application_no'];
        //////////////////
        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
                $data=array(
                    'error'=>"Case have been Registered Already. Please Check"
                );
                echo json_encode($data);
                exit;
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
        $data['secParty']=$output->applicants;

        //var_dump($data);
        if(($data['app']->dist_code!=$this->session->userdata('dist_code')) || ($data['app']->subdiv_code!=$this->session->userdata('subdiv_code')) || ($data['app']->cir_code!=$this->session->userdata('cir_code')) || ($data['app']->mouza_code!=$this->session->userdata('mouza_pargona_code')) || ($data['app']->lot_no!=$this->session->userdata('lot_no')) )
        {
            $data=array(
                'error'=>"Please reload the page. Session might be Destroyed."
            );
            echo json_encode($data);
            return false;

            exit;
        }

        //#START PLB--->
        $dist_code = $data['app']->dist_code;
        if(in_array($dist_code, json_decode(BARAK_VALLEY))){
            $dag_area_g = $data['pattaNo']->dag_area_g==null?"0":$data['pattaNo']->dag_area_g;
            $dag_area_kr = $data['pattaNo']->dag_area_kr==null?"0":$data['pattaNo']->dag_area_kr;
        }
        else{
            $dag_area_g = 0;
            $dag_area_kr = 0;
        }

        $this->db->trans_begin();
        //$case_no=$this->rtpsmodel->genearteCaseNo('01');

        $case_name=$this->rtpsmodel->genearteCaseName();
         if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Session Out. Please try Again"
            );
            echo json_encode($data);
            exit;
            die();
        }
        // $case_no['petition_no']=$petition_no=$this->rtpsmodel->genearteFieldPetitionNo();
        // $case_no['case_no']=$case_name.$petition_no."/FMUT";

        $seq_pet=year_no.'000';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteFieldPetitionNo();
        $case_no['case_no']=$case_name.$petition_no."/FMUT";

        $basic=array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'user_code'=>$this->session->userdata('user_code'),
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'trans_code'=>$this->input->post('mut_type'),
            'dispute_yn'=>0,
            'possession_yn'=>'y',
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'report_date'=>date('Y-m-d'),
            'mut_type'=>'01',                    
            'operation'=>'E',
            'user_code'=>$this->session->userdata('user_code'),
            'noc_no'=>$data['secParty'][0]->noc_no,
            'noc_date'=>$data['secParty'][0]->noc_date,
            'reg_deed_no' => $_POST['deed_no'],
            'deed_value' => $_POST['deed_value'],
            'reg_deed_date' => $_POST['deed_date']
        );
        $insFieldBasicFMUTD = $this->db->insert('field_mut_basic',$basic);
        if($insFieldBasicFMUTD != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRFMUTD001: Insertion failed in field_mut_basic for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRFMUTD001: Registration of Field Mutation by Deed failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }
        //////Buyer Insert////////////
        $i=1;
        foreach($data['firstParty'] as $pet){
            $file = null;
            if($pet->is_applicant == '1'){
                if(!empty($output->selfDeclaration[0]->dec_details)){
                    $dec = $output->selfDeclaration[0]->dec_details;
                }else{
                    $dec = null;
                }
                $auth_type = $pet->auth_type;
                $id_ref_no = $pet->id_ref_no;
                if($pet->auth_type=='AADHAAR'){
                    $uploadpath   = AADHAAR_UPLOAD_DIR;
                    $imagebase64  = $output->photo;
                    $file         = $uploadpath . $pet->id_ref_no . '.json';
                    file_put_contents($file, $imagebase64);
                }
                $photo = $file;
            }else{
                $dec= null;
                $auth_type = null;
                $id_ref_no = null;
                $photo = null;
            }
            $faddress=$this->address($pet->address);
            $buyerInsert = array(
                'dist_code'=>$data['app']->dist_code,
                'subdiv_code'=>$data['app']->subdiv_code,
                'cir_code'=>$data['app']->cir_code,
                'mouza_pargona_code'=>$data['app']->mouza_code,
                'lot_no'=>$data['app']->lot_no,
                'vill_townprt_code'=>$data['app']->village_code,
                'user_code'=>$this->session->userdata('user_code'),
                'date_entry'=>date('Y-m-d'),
                'case_no'=>$case_no['case_no'],
                'petition_no'=>$case_no['petition_no'],
                'year_no'=>date('Y'),
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
                'new_pet_name'=>$pet->chitha_pdar_id>0?null:'N',
                'pdar_id'=>$pet->chitha_pdar_id>0?$pet->chitha_pdar_id:null,
                'self_declaration' => $dec,
                'auth_type' => $auth_type,
                'id_ref_no'=> $id_ref_no,
                'photo'=> $photo,
                'pdar_name_eng'=>$pet->pat_name_eng,
                'pdar_guard_eng'=>$pet->pat_gurdian_name_eng,
            );
            $insFieldPetFMUTD = $this->db->insert('field_mut_petitioner', $buyerInsert);
            if($insFieldPetFMUTD != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRFMUTD002: Insertion failed in field_mut_petitioner for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRFMUTD002: Registration of Field Mutation by Deed failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
        }
        ////////Seller Insert//////////
        foreach($data['secParty'] as $pet){
            //////////////////////////////////
            if($pet->gurdian_name_ass == '' || $pet->gurdian_name_ass == null){
                $pet_father_name = $this->getGuardianName($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->village_code,$data['app']->lot_no,$data['app']->dag_no,$this->input->post('patta_no'),$this->input->post('patta_type'),$pet->chitha_pdar_id);
                if($pet_father_name->num_rows() <= 0){
                    $this->db->trans_rollback();
                    $data=array(
                        'error'=>"Error in submitting.Gurdian Name is Missing. Please try Again"
                    ); 
                    echo json_encode($data);
                    return;   
                }else{
                    $pet->gurdian_name_ass = trim($pet_father_name->row()->pdar_father);
                }

            }else{
                $pet->gurdian_name_ass=$pet->gurdian_name_ass;
            }
            ///////////////////////////
            $sellerInsert = array(
                'dist_code'=>$data['app']->dist_code,
                'subdiv_code'=>$data['app']->subdiv_code,
                'cir_code'=>$data['app']->cir_code,
                'mouza_pargona_code'=>$data['app']->mouza_code,
                'lot_no'=>$data['app']->lot_no,
                'vill_townprt_code'=>$data['app']->village_code,
                'user_code'=>$this->session->userdata('user_code'),
                'date_entry'=>date('Y-m-d'),
                'case_no'=>$case_no['case_no'],
                'petition_no'=>$case_no['petition_no'],
                'year_no'=>date('Y'),
                'operation'=>'E',
                'dag_no'=>$data['app']->dag_no,
                'patta_no'=>$this->input->post('patta_no') ,
                'patta_type_code'  => $this->input->post('patta_type') ,
                'pdar_id' => $pet->chitha_pdar_id,
                'pdar_cron_no' => $pet->chitha_pdar_id,
                'pdar_name' => $pet->name_ass,
                'pdar_guardian'=>$pet->gurdian_name_ass,
                'striked_out' =>$_POST[$pet->chitha_pdar_id],/////for inheritance//////
                'pdar_rel_guar' =>'u',//$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->gurdian_relation_id),/////////////
                'pdar_gender'=>'m',//$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->gender),
            );
            //var_dump($sellerInsert);
            $insFieldMutPattaFMUTD = $this->db->insert('field_mut_pattadar', $sellerInsert);
            if($insFieldMutPattaFMUTD != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRFMUTD003: Insertion failed in field_mut_pattadar for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRFMUTD003: Registration of Field Mutation by Deed failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
        }
        $dagDetails=array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'user_code'=>$this->session->userdata('user_code'),
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'operation'=>'E',
            'dag_no'=>$data['app']->dag_no,
            'patta_no'=>$this->input->post('patta_no') ,
            'patta_type_code'  => $this->input->post('patta_type') ,
            'm_dag_area_b'=>$_POST['mut_area_b'],
            'm_dag_area_k' =>$_POST['mut_area_k'],
            'm_dag_area_lc' =>$_POST['mut_area_l'],
            'm_dag_area_g' =>$_POST['mut_area_g'],
            'm_dag_area_kr' =>0,
            'dag_area_b' =>$data['pattaNo']->dag_area_b,
            'dag_area_k' =>$data['pattaNo']->dag_area_k,
            'dag_area_lc' =>$data['pattaNo']->dag_area_lc,  
            'dag_area_g' =>$dag_area_g,
            'dag_area_kr' =>$dag_area_kr,
            'remark' =>addslashes(trim($_POST['remark'])),
            'deed_reg_no'=>$_POST['deed_no'],
            'deed_date'=>$_POST['deed_date'],
            'deed_value'=>$_POST['deed_value'],
            );
            $insFieldMutDagDetFMUTD = $this->db->insert('field_mut_dag_details',$dagDetails);
            if($insFieldMutDagDetFMUTD != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRFMUTD004: Insertion failed in field_mut_dag_details for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRFMUTD004: Registration of Field Mutation by Deed failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }

           $remark=addslashes(trim($_POST['remark']));

           $proInsert = $this->mutationmodel->proceeding_order($case_no['case_no'],$remark);


           if($proInsert==false || $proInsert===false)
            {
                log_message('error', "#FMUTLM001:".$this->db->last_query());
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Updation failed(#FMUTLM001)".$application_no);
                redirect(base_url() . "index.php/home");
            }

            $basundhara=array(
                'dharitree'=>$case_no['case_no'],
                'basundhara'=>$application_no,
                'date_reg'=>date('Y-m-d'),
                'reg_by'=>$this->session->userdata('user_code'),
                'app_status'=>'P',
                'pending_with'=>'CO'
            );

            //////////UUID Insert/////////////
            $basundhara['uuid']=$this->utilityclass->getVillageUUID($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code);
            ///////////////////////
            $insBasuFMUTD = $this->db->insert('basundhar_application',$basundhara);
            if($insBasuFMUTD != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRFMUTD005: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRFMUTD005: Registration of Field Mutation by Deed failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }

            $all_row_updated = $this->updateCaseIdForNok($application_no, $case_no['case_no']);
            if(!$all_row_updated){
                log_message('error', '#ERRFMUTDNOK001: Failed update nok for RTPS Case No '.$application_no . ' Last Query => ' . $this->db->last_query());
                $this->db->trans_rollback();
                $data = array(
                    'error'=>"#ERRFMUTMULDNOK001: Registration of Field Mutation by Deed failed for case no : ".$application_no
                );

                return response_json($data);
            }
            
            if($this->db->trans_status()==FALSE){
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"Error in submitting. Please try Again"
                );
                echo json_encode($data);
                return;
            }
            else
            {                
                //////////////POST To rtps/////////////////////
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."applicationStatusUpdate");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    'application' => $application_no,
                    'dharitree' => $case_no['case_no'],
                    'rmk' => 'all ok',
                    'status' => 'M',
                    'task' => 'LM',
                    'pen'=>'CO'
                )));
                $result = curl_exec($curl_handle);
                 if($result===true || $result=='true' || $result==1 || json_decode($result)=='true'|| json_decode($result)==true || json_decode($result)=='y' || $result=='y'){
                    $this->db->trans_commit();
                }else{
                    $data=array(
                        'error'=>"Error in submitting. Please try Again"
                    );
                    echo json_encode($data);
                    return;
                }
                $this->DashboardPartitionField($case_no['case_no']);
                $this->session->set_flashdata('message',"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no] ");
                //////////////////////////////////
                $data=array(
                    'success'=>"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no]",
                    'redirect_url'=>base_url().'index.php/home'
                );
            }
        echo json_encode($data);
    }
    ///////////end//////////
    /////////////Inheritance Post///////////
    function inheritancePost(){
        //xss & security validation starts
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }
        $resp = checkRequestValidQuery($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }    
        if($errorMessageStr != ''){
            $data=array(
                'error' => $errorMessageStr
            );
            echo json_encode($data);
            return false;
            exit;
        }
        //xss & security validation ends 
        $application_no=$_POST['application_no'];
        $data=array(
            'error'=>"#ERR1944 : Access Denied..."
        );
        echo json_encode($data);
        exit;
        //////////////////
        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
                $data=array(
                    'error'=>"Case have been Registered Already. Please Check"
                );
                echo json_encode($data);
                exit;
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
        $data['secParty']=$output->applicants;
        if(($data['app']->dist_code!=$this->session->userdata('dist_code')) || ($data['app']->subdiv_code!=$this->session->userdata('subdiv_code')) || ($data['app']->cir_code!=$this->session->userdata('cir_code')) || ($data['app']->mouza_code!=$this->session->userdata('mouza_pargona_code')) || ($data['app']->lot_no!=$this->session->userdata('lot_no')) )
        {
            $data=array(
                'error'=>"Please reload the page. Session might be Destroyed."
            );
            echo json_encode($data);
            return false;
            exit;
        }

        $dist_code = $data['app']->dist_code;
        if(in_array($dist_code, json_decode(BARAK_VALLEY))){
            $dag_area_g = $data['pattaNo']->dag_area_g==null?"0":$data['pattaNo']->dag_area_g;
            $dag_area_kr = $data['pattaNo']->dag_area_kr==null?"0":$data['pattaNo']->dag_area_kr;
        }
        else{
            $dag_area_g = 0;
            $dag_area_kr = 0;
        }

        $this->db->trans_begin();
       // $case_no=$this->rtpsmodel->genearteCaseNo('01');

        $case_name=$this->rtpsmodel->genearteCaseName();
         if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Session Out. Please try Again"
            );
            echo json_encode($data);
            exit;
            die();
        }
        // $case_no['petition_no']=$petition_no=$this->rtpsmodel->genearteFieldPetitionNo();

        // $case_no['case_no']=$case_name.$petition_no."/FMUT";

        // Validate before state change starts (By Deep)
        // print_r($data['secParty']);
        $validate_in_db = isset($_SESSION['credentials']['dn']) ? $_SESSION['credentials']['dn'] : '';
        $validate_pattadar_data[]='';
        $validate_pattadar_data[0]=array(
            'dist_code' => $data['app']->dist_code,
            'subdiv_code' => $data['app']->subdiv_code,
            'cir_code' => $data['app']->cir_code,
            'mouza_code' => $data['app']->mouza_code,
            'lot_no' => $data['app']->lot_no,
            'village_code' => $data['app']->village_code,
            'dag_no' => $data['app']->dag_no,
            'patta_no' => trim($data['pattaNo']->patta_no),
            'patta_type_code' => $data['pattaNo']->patta_type_code,
            'chitha_pdar_id' => $data['secParty'][0]->chitha_pdar_id,          
        );

        $validate_chitha_location_data[]='';
        $validate_chitha_location_data[0]=array(
            $data['app']->dist_code,
            $data['app']->cir_code,
            $data['app']->subdiv_code,
            $data['app']->village_code,
            $data['app']->mouza_code,
            $data['app']->lot_no,
            $data['app']->dag_no,
        );
        // Vally wise area deferanciation (By Deep)
        $for_vally='';
        $validate_chitha_area_data_barak []='';
        $validate_chitha_area_data_bramha[] ='';
        
        $for_vally=in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY));
        if($for_vally==1) //Barak Valley 1
        {
            $validate_chitha_area_data_barak=array(
                'dag_area_b' => $_POST['mut_area_b'],
                'dag_area_k' => $_POST['mut_area_k'],
                'dag_area_lc' => $_POST['mut_area_l'],
                'dag_area_g' => $_POST['mut_area_g'],
                'dag_area_kr' =>0,
            );
        }
        else //Bramhaputra Valley !1
        {
            $validate_chitha_area_data_bramha=array(
                'area_b' => $_POST['mut_area_b'],
                'area_k' => $_POST['mut_area_k'],
                'area_l' => $_POST['mut_area_l'],
            );
        }
        $ret_val='';
        $ret_val = $this->pre_post_validate($validate_in_db,$validate_pattadar_data,$validate_chitha_location_data,$validate_chitha_area_data_barak,$validate_chitha_area_data_bramha,$application_no);
        if($ret_val!=1 and !empty($ret_val))
        {
            $data = array(
                'error'=>$ret_val.$application_no
            );
            echo json_encode($data);
            return false;
        }
        // Validate before state change ends (By Deep)

        $seq_pet=year_no.'000';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteFieldPetitionNo();
        $case_no['case_no']=$case_name.$petition_no."/FMUT";

        $basic=array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'user_code'=>$this->session->userdata('user_code'),
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'trans_code'=>$this->input->post('mut_type'),
            'dispute_yn'=>0,
            'possession_yn'=>$this->input->post('possession'),
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'report_date'=>date('Y-m-d'),
            'mut_type'=>'01',                    
            'operation'=>'E',
            'user_code'=>$this->session->userdata('user_code')
        );
        $insFieldBasicFMUTI = $this->db->insert('field_mut_basic',$basic);
        if($insFieldBasicFMUTI != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRFMUTI001: Insertion failed in field_mut_basic for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRFMUTI001: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }
        //////Buyer Insert////////////
        $i=1;
        $file = null;
        foreach($data['firstParty'] as $pet){
            if($pet->is_applicant == '1'){  
                if(!empty($output->selfDeclaration[0]->dec_details)){
                    $dec = $output->selfDeclaration[0]->dec_details;
                }else{
                    $dec = null;
                }
                $auth_type = $pet->auth_type;
                $id_ref_no = $pet->id_ref_no;
                if($pet->auth_type=='AADHAAR'){
                    $uploadpath   = AADHAAR_UPLOAD_DIR;
                    $imagebase64  = $output->photo;
                    $file         = $uploadpath . $pet->id_ref_no . '.json';
                    file_put_contents($file, $imagebase64);
                }
                $photo = $file;
            }else{
                $dec= null;
                $auth_type = null;
                $id_ref_no = null;
                $photo = null;
            }
            $faddress=$this->address($pet->address);
            $buyerInsert = array(
                'dist_code'=>$data['app']->dist_code,
                'subdiv_code'=>$data['app']->subdiv_code,
                'cir_code'=>$data['app']->cir_code,
                'mouza_pargona_code'=>$data['app']->mouza_code,
                'lot_no'=>$data['app']->lot_no,
                'vill_townprt_code'=>$data['app']->village_code,
                'user_code'=>$this->session->userdata('user_code'),
                'date_entry'=>date('Y-m-d'),
                'case_no'=>$case_no['case_no'],
                'petition_no'=>$case_no['petition_no'],
                'year_no'=>date('Y'),
                'operation'=>'E',
                'pet_name' => $pet->pat_name_ass,
                'guard_name' => $pet->pat_gurdian_name_ass,
                'guard_rel' =>$pet->pat_gurdian_rel_id <='-1' ? $this->utilityclass->relationRevertBasu($data['app']->dist_code,'7'):$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->pat_gurdian_rel_id),/////////////
                'pet_gender'=>$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->pat_gender),
                //'add1' => $pet->address,
                'add1' => $faddress[0],
                'add2' => $faddress[1],
                'pet_id' => $i++,
                'pdar_mobile'=>$pet->pat_mobile_no,
                'new_pet_name'=>$pet->chitha_pdar_id>0?null:'N',
                'pdar_id'=>$pet->chitha_pdar_id>0?$pet->chitha_pdar_id:null,
                'self_declaration' => $dec,
                'auth_type' => $auth_type,
                'id_ref_no'=> $id_ref_no,
                'photo'=> $photo,
                'pdar_name_eng'=>$pet->pat_name_eng,
                'pdar_guard_eng'=>$pet->pat_gurdian_name_eng,
            );
            $insFieldPetFMUTI = $this->db->insert('field_mut_petitioner', $buyerInsert);
            //log_message('error',$buyerInsert);
            if($insFieldPetFMUTI != 1)
            {
                log_message('error', '#ERRFMUTI002: Insertion failed in field_mut_petitioner for RTPS Case No '.
                    $application_no.$this->db->last_query());
                $this->db->trans_rollback();
                $data = array(
                    'error'=>"#ERRFMUTI002: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
        }
        ////////Seller Insert//////////
        foreach($data['secParty'] as $pet){
            //////////////////////////////////
            if($pet->gurdian_name_ass == '' || $pet->gurdian_name_ass == null){
                $pet_father_name = $this->getGuardianName($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->village_code,$data['app']->lot_no,$data['app']->dag_no,$this->input->post('patta_no'),$this->input->post('patta_type'),$pet->chitha_pdar_id);
                if($pet_father_name->num_rows() <= 0){
                    $this->db->trans_rollback();
                    $data=array(
                        'error'=>"Error in submitting.Gurdian Name is Missing. Please try Again"
                    ); 
                    echo json_encode($data);
                    return;   
                }else{
                    $pet->gurdian_name_ass = trim($pet_father_name->row()->pdar_father);
                }

            }else{
                $pet->gurdian_name_ass=$pet->gurdian_name_ass;
            }
            ///////////////////////////
            $sellerInsert = array(
                'dist_code'=>$data['app']->dist_code,
                'subdiv_code'=>$data['app']->subdiv_code,
                'cir_code'=>$data['app']->cir_code,
                'mouza_pargona_code'=>$data['app']->mouza_code,
                'lot_no'=>$data['app']->lot_no,
                'vill_townprt_code'=>$data['app']->village_code,
                'user_code'=>$this->session->userdata('user_code'),
                'date_entry'=>date('Y-m-d'),
                'case_no'=>$case_no['case_no'],
                'petition_no'=>$case_no['petition_no'],
                'year_no'=>date('Y'),
                'operation'=>'E',
                'dag_no'=>$data['app']->dag_no,
                'patta_no'=>$this->input->post('patta_no') ,
                'patta_type_code'  => $this->input->post('patta_type') ,
                'pdar_id' => $pet->chitha_pdar_id,
                'pdar_cron_no' => $pet->chitha_pdar_id,
                'pdar_name' => $pet->name_ass,
                'pdar_guardian'=>$pet->gurdian_name_ass,
                'pdar_rel_guar' =>'u',//$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->gurdian_relation_id),/////////////
                'pdar_gender'=>'m',//$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->gender),
                'striked_out' =>1,/////for inheritance//////
            );
            //var_dump($sellerInsert);
            $insFieldPattaFMUTI = $this->db->insert('field_mut_pattadar', $sellerInsert);
            if($insFieldPattaFMUTI != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRFMUTI003: Insertion failed in field_mut_pattadar for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRFMUTI003: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
        }


        $dagDetails=array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'user_code'=>$this->session->userdata('user_code'),
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'operation'=>'E',
            'dag_no'=>$data['app']->dag_no,
            'patta_no'=>$this->input->post('patta_no') ,
            'patta_type_code'  => $this->input->post('patta_type') ,
            'm_dag_area_b'=>$_POST['mut_area_b'],
            'm_dag_area_k' =>$_POST['mut_area_k'],
            'm_dag_area_lc' =>$_POST['mut_area_l'],
            'm_dag_area_g' =>$_POST['mut_area_g'],
            'm_dag_area_kr' =>0,
            'dag_area_b' =>$data['pattaNo']->dag_area_b,
            'dag_area_k' =>$data['pattaNo']->dag_area_k,
            'dag_area_lc' =>$data['pattaNo']->dag_area_lc,  
            'dag_area_g' =>$dag_area_g,  
            'dag_area_kr' =>$dag_area_kr,
            'remark' =>addslashes(trim($_POST['remark']))
            );
            $insFiledDagFMUTI = $this->db->insert('field_mut_dag_details',$dagDetails);
            if($insFiledDagFMUTI != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRFMUTI004: Insertion failed in field_mut_dag_details for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRFMUTI004: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }


            $basundhara=array(
                'dharitree'=>$case_no['case_no'],
                'basundhara'=>$application_no,
                'date_reg'=>date('Y-m-d'),
                'reg_by'=>$this->session->userdata('user_code'),
                'app_status'=>'P',
                'pending_with'=>'CO'
            );
            //////////UUID Insert/////////////
            $basundhara['uuid']=$this->utilityclass->getVillageUUID($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code);
            ///////////////////////
            $insBasuFMUTI = $this->db->insert('basundhar_application',$basundhara);
            if($insBasuFMUTI != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRFMUTI005: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRFMUTI005: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }

            $all_row_updated = $this->updateCaseIdForNok($application_no, $case_no['case_no']);
            if(!$all_row_updated){
                log_message('error', '#ERRFMUTMULDNOK001: Failed update nok for RTPS Case No '.$application_no . ' Last Query => ' . $this->db->last_query());
                $this->db->trans_rollback();
                $data = array(
                    'error'=>"#ERRFMUTMULDNOK001: Registration of Field Mutation by Deed failed for case no : ".$application_no
                );

                return response_json($data);
            }
            
            if($this->db->trans_status()==FALSE){
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"Error in submitting. Please try Again"
                );
                echo json_encode($data);
                return false;
            }else
        {
               
            //////////////POST To rtps/////////////////////
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."applicationStatusUpdate");
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
            ////////////////////////////////
             if($result===true || $result=='true' || $result==1 || json_decode($result)=='true'|| json_decode($result)==true || json_decode($result)=='y' || $result=='y'){
                $this->db->trans_commit();
            }else{
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"Error in submitting. Please try Again"
                );
                echo json_encode($data);
                return false;
            }            
            $this->DashboardPartitionField($case_no['case_no']);
            $this->session->set_flashdata('message',"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no] ");
            //////////////////////////////////
            $data=array(
                'success'=>"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no]",
                'redirect_url'=>base_url().'index.php/home'
            );
        }
        echo json_encode($data);
    }
    ///////////end//////////
    ///////////////Partitin Post//////////////////
    function partitionPost(){
        //xss & security validation starts
                $errorMessageStr = '';
                $resp = checkRequestSpecChar($_POST,array(),array(),array('remark' => true));
                if($resp['status'] == 'n'){
                    $errorMessageStr .= $resp['messages'];
                }
                $resp = checkRequestValidQuery($_POST,array(),array('remark' => true));
                if($resp['status'] == 'n'){
                    $errorMessageStr .= $resp['messages'];
                }    
                if($errorMessageStr != ''){
                    $data=array(
                        'error' => $errorMessageStr
                    );
                    echo json_encode($data);
                    return false;
                    exit;
                }
        //xss & security validation ends 
        $application_no=$_POST['application_no'];
        $data=array(
            'error'=>"#ERR2382: Access Denied"
        );
        echo json_encode($data);
        exit;
        //////////////////
        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
                $data=array(
                    'error'=>"Case have been Registered Already. Please Check"
                );
                echo json_encode($data);
                exit;
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

        if(($data['app']->dist_code!=$this->session->userdata('dist_code')) || ($data['app']->subdiv_code!=$this->session->userdata('subdiv_code')) || ($data['app']->cir_code!=$this->session->userdata('cir_code')) || ($data['app']->mouza_code!=$this->session->userdata('mouza_pargona_code')) || ($data['app']->lot_no!=$this->session->userdata('lot_no')) )
        {
            $data=array(
                'error'=>"Please reload the page. Session might be Destroyed."
            );
            echo json_encode($data);
            return false;
            exit;
        }
        $this->db->trans_begin();
        //$case_no=$this->rtpsmodel->genearteCaseNo('02');

        $case_name=$this->rtpsmodel->genearteCaseName();
         if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Session Out. Please try Again"
            );
            echo json_encode($data);
            exit;
            die();
        }
        // $case_no['petition_no']=$petition_no=$this->rtpsmodel->genearteFieldPetitionNo();

        // $case_no['case_no']=$case_name.$petition_no."/FPART";

        // Validate before state change starts (By Deep)
        $validate_in_db = $_SESSION['credentials']['dn'];
        $validate_pattadar_data[]='';
        $validate_pattadar_data[0]=array(
            'dist_code' => $data['app']->dist_code,
            'subdiv_code' => $data['app']->subdiv_code,
            'cir_code' => $data['app']->cir_code,
            'mouza_code' => $data['app']->mouza_code,
            'lot_no' => $data['app']->lot_no,
            'village_code' => $data['app']->village_code,
            'dag_no' => $data['app']->dag_no,
            'patta_no' => trim($data['pattaNo']->patta_no),
            'patta_type_code' => $data['pattaNo']->patta_type_code,
            'chitha_pdar_id' => $data['firstParty'][0]->chitha_pdar_id,          
        );

        $validate_chitha_location_data[]='';
        $validate_chitha_location_data[0]=array(
            $data['app']->dist_code,
            $data['app']->cir_code,
            $data['app']->subdiv_code,
            $data['app']->village_code,
            $data['app']->mouza_code,
            $data['app']->lot_no,
            $data['app']->dag_no,
        );
        // Vally wise area deferanciation (By Deep)
        $for_vally='';
        $validate_chitha_area_data_barak []='';
        $validate_chitha_area_data_bramha[] ='';
        
        $for_vally=in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY));
        if($for_vally==1) //Barak Valley 1
        {
            $validate_chitha_area_data_barak=array(
                'dag_area_b' => $data['firstParty'][0]->area_b,
                'dag_area_k' => $data['firstParty'][0]->area_k,
                'dag_area_lc' => $data['firstParty'][0]->area_l,
                'dag_area_g' => $data['firstParty'][0]->area_go,
                'dag_area_kr' =>$data['firstParty'][0]->area_ka,
            );
        }
        else //Bramhaputra Valley !1
        {
            $validate_chitha_area_data_bramha=array(
                'area_b' => $data['firstParty'][0]->area_b,
                'area_k' => $data['firstParty'][0]->area_k,
                'area_l' => $data['firstParty'][0]->area_l,
            );
        }
        $ret_val='';
        $ret_val = $this->pre_post_validate($validate_in_db,$validate_pattadar_data,$validate_chitha_location_data,$validate_chitha_area_data_barak,$validate_chitha_area_data_bramha,$application_no);
        
        if($ret_val!=1 and !empty($ret_val))
        {
            $check_error_msg = "#ERRFPART010: Applied area is more then chitha area. : <br>"; 
            if($ret_val == $check_error_msg  && $_POST['submit_with_more_area'] == '1'){
              //do nothing submit form  
            } else if($ret_val == $check_error_msg  && $_POST['submit_with_more_area'] == '0'){
                $data = array(
                    'error'=>'Applied area is more then chitha area. Please add Remark and Forward.'
                );
                echo json_encode($data);
                return false;
            } else if(strpos($ret_val, $check_error_msg) !== false && $_POST['submit_with_more_area'] == '0'){
                $new_error = str_replace($check_error_msg,'Applied area is more then chitha area. Please add Remark and Forward. <br>',$ret_val);
                $data = array(
                    'error'=>$new_error
                );
                echo json_encode($data);
                return false;
            } else {
                $data = array(
                    'error'=>$ret_val.$application_no
                );
                echo json_encode($data);
                return false;
            }
        }
        
        $validate_in_db = $_SESSION['credentials']['dn'];
        $validate_pattadar_data[]='';
    
        $validate_chitha_location_data[]='';
        $validate_chitha_location_data[0]=array(
            $data['app']->dist_code,
            $data['app']->cir_code,
            $data['app']->subdiv_code,
            $data['app']->village_code,
            $data['app']->mouza_code,
            $data['app']->lot_no,
            $data['app']->dag_no,
        );
        // Vally wise post area deferanciation (By Deep)
        $for_vally='';
        $validate_chitha_area_data_barak=null;
        $validate_chitha_area_data_bramha=null;
        
        $for_vally=in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY));
        if($for_vally==1) //Barak Valley 1
        {
            $mut_area_b = $_POST['mut_area_b'];
            $mut_area_k = $_POST['mut_area_k'];
            $mut_area_l = $_POST['mut_area_l'];
            $mut_area_g = $_POST['mut_area_g'];
            $validate_chitha_area_data_barak=array(
                'dag_area_b' => trim($mut_area_b),
                'dag_area_k' => trim($mut_area_k),
                'dag_area_lc' => trim($mut_area_l),
                'dag_area_g' => trim($mut_area_g),
                'dag_area_kr' => 0,
            );
        }
        else //Bramhaputra Valley !1
        {
            $mut_area_b = $_POST['mut_area_b'];
            $mut_area_k = $_POST['mut_area_k'];
            $mut_area_l = $_POST['mut_area_l'];
            $validate_chitha_area_data_bramha=array(
                'area_b' => trim($mut_area_b),
                'area_k' => trim($mut_area_k),
                'area_l' => trim($mut_area_l),
            );
        }
        $ret_val='';
        $ret_val = $this->pre_post_only_area_validate($validate_in_db,$validate_chitha_location_data, $validate_chitha_area_data_barak,$validate_chitha_area_data_bramha);
        if($ret_val!=1 and !empty($ret_val))
        {
            $check_error_msg = "#ERRFPART010: Applied area is more then available chitha area. Please update the area to proceed: <br>";
            if($ret_val == $check_error_msg  && $_POST['submit_with_more_area'] == '1'){
              //do nothing submit form  
            } else if($ret_val == $check_error_msg  && $_POST['submit_with_more_area'] == '0'){
                $data = array(
                    'error'=>'Applied area is more then chitha area. Please add Remark and Forward.'
                );
                echo json_encode($data);
                return false;
            } else if(strpos($ret_val, $check_error_msg) !== false && $_POST['submit_with_more_area'] == '0'){
                $new_error = str_replace($check_error_msg,'Applied area is more then chitha area. Please add Remark and Forward. <br>',$ret_val);
                $data = array(
                    'error'=>$new_error,
                    'info' =>'Wrong Area'
                );
                echo json_encode($data);
                return false;
            } else {
                $data = array(
                    'error'=>$ret_val.$application_no,
                    'info' =>'Wrong Area'
                );
                echo json_encode($data);
                return false;
            }
        }
        // Validate before state change ends (By Deep)
        
        $seq_pet=year_no.'000';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteFieldPetitionNo();
        $case_no['case_no']=$case_name.$petition_no."/FPART";

        $basic=array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'user_code'=>$this->session->userdata('user_code'),
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'trans_code'=>'01',
            'dispute_yn'=>0,
            'possession_yn'=>'y',
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'report_date'=>date('Y-m-d'),
            'mut_type'=>'02',                    
            'operation'=>'E',
        );
        $insBasicFPART = $this->db->insert('field_mut_basic', $basic);
        if($insBasicFPART != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRFPART001: Insertion failed in field_mut_basic for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRFPART001: Registration of Field Partition failed for case no : ".$application_no
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
            'user_code'=>$this->session->userdata('user_code'),
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'operation'=>'E',
        );
        $fmd['dag_no']=$data['app']->dag_no;
        $fmd['patta_no']=$data['pattaNo']->patta_no;
        $fmd['patta_type_code']=$data['pattaNo']->patta_type_code;
        $fmd['m_dag_area_b']=$_POST['mut_area_b'];
        $fmd['m_dag_area_k']=$_POST['mut_area_k'];
        $fmd['m_dag_area_lc']=$_POST['mut_area_l'];
        $fmd['dag_area_b']=$data['pattaNo']->dag_area_b;
        $fmd['dag_area_k']=$data['pattaNo']->dag_area_k;
        $fmd['dag_area_lc']=$data['pattaNo']->dag_area_lc;



        ///////////// BARAK VALLEY CODE START HERE ////////////////
        if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){ 
            $fmd['m_dag_area_g']=$_POST['mut_area_g'];
            $fmd['dag_area_g']=$data['pattaNo']->dag_area_g;

        }
        else {
            $fmd['m_dag_area_g']='0.00'; 
            $fmd['dag_area_g']='0';   
        }
        ///////////// BARAK VALLEY CODE END HERE ////////////////
        $fmd['m_dag_area_kr']='0';
        $fmd['dag_area_kr']='0';
        $fmd['remark'] =addslashes(trim($_POST['remark']));
        $insDagFPART = $this->db->insert('field_mut_dag_details',$fmd);
        if($insDagFPART != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRFPART002: Insertion failed in field_mut_dag_details for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRFPART002: Registration of Field Partition failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }

        $remark =addslashes(trim($_POST['remark']));

        $proInsert = $this->mutationmodel->proceeding_order($case_no['case_no'],$remark);


        if($proInsert==false || $proInsert===false)
        {
            log_message('error', "#FPARTLM001:".$this->db->last_query());
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "Updation failed(#FPARTTLM001)".$application_no);
            redirect(base_url() . "index.php/home");
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
            $petitioner=array(
                    'dist_code'=>$data['app']->dist_code,
                    'subdiv_code'=>$data['app']->subdiv_code,
                    'cir_code'=>$data['app']->cir_code,
                    'mouza_pargona_code'=>$data['app']->mouza_code,
                    'lot_no'=>$data['app']->lot_no,
                    'vill_townprt_code'=>$data['app']->village_code,
                    'user_code'=>$this->session->userdata('user_code'),
                    'date_entry'=>date('Y-m-d'),
                    'case_no'=>$case_no['case_no'],
                    'petition_no'=>$case_no['petition_no'],
                    'operation'=>'E',
                    'dag_no' =>$data['app']->dag_no,
                    'patta_no' =>$data['pattaNo']->patta_no,
                    'patta_type_code'=>$data['pattaNo']->patta_type_code,
                    'year_no'=>date('Y'),
                    'operation'=>'E',
                    'date_entry'=>date('Y-m-d'),
                    'pdar_id' =>$part->chitha_pdar_id,
                    'pdar_cron_no'=>$i++,
                    'pdar_name' =>$part->name_ass,
                    'pdar_guardian' =>$part->gurdian_name_ass,
                    // 'pdar_rel_guar' =>'f',
                    // 'pdar_gender'=>'m',
                    'pdar_rel_guar' =>$this->utilityclass->relationRevertBasu($data['app']->dist_code,$part->gurdian_relation_id),/////////////
                    'pdar_gender'=>$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$part->gender),
                    'pdar_dag_por_b' =>$part->area_b,
                    'pdar_dag_por_k' =>$part->area_k,
                    'pdar_dag_por_lc' =>$part->area_l,
                    'pdar_dag_por_g' =>$part->area_go,
                    'self_declaration' => $dec,
                    'auth_type' => $auth_type,
                    'id_ref_no'=> $id_ref_no,
                    'photo'=> $photo
                );
            $insPetFPART = $this->db->insert('field_part_petitioner',$petitioner);
            if($insPetFPART != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRFPART003: Insertion failed in field_part_petitioner for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRFPART003: Registration of Field Partition failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
        }

        $basundhara=array(
            'dharitree'=>$case_no['case_no'],
            'basundhara'=>$application_no,
            'date_reg'=>date('Y-m-d'),
            'reg_by'=>$this->session->userdata('user_code'),
            'app_status'=>'P',
            'pending_with'=>'CO'
            );
        //////////UUID Insert/////////////
        $basundhara['uuid']=$this->utilityclass->getVillageUUID($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code);
        ///////////////////////
        $insBasuFPART = $this->db->insert('basundhar_application',$basundhara);
        if($insBasuFPART != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRFPART004: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRFPART004: Registration of Field Partition failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }

        

        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            $data=array(
                'error'=>"Error in submitting. Please try Again"
            );
        }else
        {
            $this->db->trans_commit();
            //////////////POST To rtps/////////////////////
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."applicationStatusUpdate");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
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
        echo json_encode($data);
    }
    ///////////end partition post//////////////////

    /////////////////Office Inheritance Mutation/////////////////////////
    function inheritanceOfcPost(){
         //xss & security validation starts
         $errorMessageStr = '';
         // $resp = checkRequestSpecChar($_POST);
         // if($resp['status'] == 'n'){
         //     $errorMessageStr .= $resp['messages'];
         // }
         // $resp = checkRequestValidQuery($_POST);
         // if($resp['status'] == 'n'){
         //     $errorMessageStr .= $resp['messages'];
         // }    
         // if($errorMessageStr != ''){
         //     $data=array(
         //         'error' => $errorMessageStr
         //     );
         //     echo json_encode($data);
         //     return false;
         //     exit;
         // }
         //xss & security validation ends 
        $application_no=$_POST['application_no'];
        //////////////////
        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
                $data=array(
                    'error'=>"Case have been Registered Already. Please Check"
                );
                echo json_encode($data);
                exit;
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
        $data['secParty']=$output->applicants;
        //var_dump($data);
        $dist_code = $data['app']->dist_code;
        if(in_array($dist_code, json_decode(BARAK_VALLEY))){
            $dag_area_g = $data['pattaNo']->dag_area_g==null?"0":$data['pattaNo']->dag_area_g;
            $dag_area_kr = $data['pattaNo']->dag_area_kr==null?"0":$data['pattaNo']->dag_area_kr;
        }
        else{
            $dag_area_g = 0;
            $dag_area_kr = 0;
        }

        $this->db->trans_begin();
        //$case_no=$this->rtpsmodel->genearteOfcCaseNo('03');
        $case_name=$this->rtpsmodel->genearteCaseName();        
         if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Session Out. Please try Again"
            );
            echo json_encode($data);
            exit;
            die();
        }
        // $case_no['petition_no']=$petition_no=$this->rtpsmodel->genearteOfficePetitionNo();
        // $case_no['case_no']=$case_name.$petition_no."/OMUT";

        $seq_pet=year_no.'00';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteOfficePetitionNo();
        $case_no['case_no']=$case_name.$petition_no."/OMUT";

        $basic=array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'user_code'=>$this->session->userdata('user_code'),
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'mut_type'=>'03', /////mut type
            'trans_code'=>$this->input->post('mut_type'),/////////for inheritance
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'date_entry' => date('Y-m-d G:i:s'),                 
            'operation'=>'E',
            'user_code'=>$this->session->userdata('user_code'),
            'submission_date' => date('Y-m-d G:i:s'),
            'add_off_name' => $_POST['add_of_name'],
            ///////// 
        );
        $insPetBasic = $this->db->insert('petition_basic',$basic);
        if($insPetBasic != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERROMUTI001: Insertion failed in petition_basic RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERROMUTI001: Registration of Office Mutation by Inheritance failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }
        //////Buyer Insert////////////
        $i=1;
        $file = null;
        foreach($data['firstParty'] as $pet){
            //newly added aadhaar integration in dharitree---------10052023
            if($pet->is_applicant == '1'){  
                if(!empty($output->selfDeclaration[0]->dec_details)){
                    $dec = $output->selfDeclaration[0]->dec_details;
                }else{
                    $dec = null;
                }
                $auth_type = $pet->auth_type;
                $id_ref_no = $pet->id_ref_no;
                if($pet->auth_type =='AADHAAR'){
                    $uploadpath   = AADHAAR_UPLOAD_DIR;
                    $imagebase64  = $output->photo;
                    $file         = $uploadpath . $pet->id_ref_no . '.json';
                    file_put_contents($file, $imagebase64);
                }
                $photo = $file;
            }else{
                $dec= null;
                $auth_type = null;
                $id_ref_no = null;
                $photo = null;
            }
            //end code-------------------------


            $faddress=$this->address($pet->address);
            $buyerInsert = array(
                'dist_code'=>$data['app']->dist_code,
                'subdiv_code'=>$data['app']->subdiv_code,
                'cir_code'=>$data['app']->cir_code,
                'mouza_pargona_code'=>$data['app']->mouza_code,
                'lot_no'=>$data['app']->lot_no,
                'vill_townprt_code'=>$data['app']->village_code,
                'petition_no'=>$case_no['petition_no'],
                'year_no'=>date('Y'),
                'operation'=>'E',
                'pet_name' => $pet->pat_name_ass,
                'guard_name' => $pet->pat_gurdian_name_ass,
                'pdar_name_eng' => $pet->pat_name_eng,
                'pdar_guard_eng' => $pet->pat_gurdian_name_eng,
                // 'guard_rel' => 'f', //////////////////////to be update
                // 'pet_gender'=>$pet->pat_gender,
                'guard_rel' =>$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->pat_gurdian_rel_id),/////////////
                'pet_gender'=>$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->pat_gender),
                'pet_id' => $i++,
                //'add1' => $pet->address,
                'add1' => $faddress[0],
                'add2' => $faddress[1],
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'new_pattadar' => 'N',
                'pet_minor_dob' => date('Y-m-d G:i:s',strtotime($pet->dob)),
                'pdar_mobile' => $pet->pat_mobile_no,
                'applied_b' =>0,
                'applied_k' => 0,
                'applied_lc' => 0,
                'applied_g' => 0,
                'applied_kr' => 0,
                'self_declaration' => $dec,
                'auth_type'        => $auth_type,
                'id_ref_no'        => $id_ref_no,
                'photo'            => $photo,
            );
            $insPetitioner = $this->db->insert('petitioner', $buyerInsert);
            if($insPetitioner != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERROMUTI002: Insertion failed in petitioner for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERROMUTI002: Registration of Office Mutation by Inheritance failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
        }
        $cron_no=1;
        foreach($data['secParty'] as $pet){
            $sellerInsert = array(
                'dist_code'=>$data['app']->dist_code,
                'subdiv_code'=>$data['app']->subdiv_code,
                'cir_code'=>$data['app']->cir_code,
                'mouza_pargona_code'=>$data['app']->mouza_code,
                'lot_no'=>$data['app']->lot_no,
                'vill_townprt_code'=>$data['app']->village_code,
                'user_code'=>$this->session->userdata('user_code'),
                'petition_no'=>$case_no['petition_no'],
                'year_no'=>date('Y'),
                'operation'=>'E',
                'dag_no'=>$data['app']->dag_no,
                'patta_no'=>$this->input->post('patta_no') ,
                'patta_type_code'  => $this->input->post('patta_type') ,
                'pdar_id' => $pet->chitha_pdar_id,
                'pdar_cron_no' => $pet->chitha_pdar_id,
                'pdar_name' => $pet->name_ass,
                'pdar_guardian'=>$pet->gurdian_name_ass,
                'pdar_rel_guar' => 'f',
                'striked_out' =>1,/////for inheritance//////
                'dag_no' =>$data['app']->dag_no,
                'patta_no' => $_POST['patta_no'],
                'patta_type_code' => $_POST['patta_type'],
                'pdar_id' =>  $pet->chitha_pdar_id,
                'pdar_cron_no' => $cron_no++,
                'pdar_name' => $pet->name_ass,
                'pdar_guardian' => $pet->gurdian_name_ass,
                //'pdar_gender' => 'm',
                //'pdar_rel_guar' => 'f',
                'pdar_rel_guar' =>'u',//$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->gurdian_relation_id),/////////////
                // 'pet_gender'=>$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->gender),
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E'
            );
            $insPetPattadar = $this->db->insert('petition_pattadar', $sellerInsert);
            if($insPetPattadar != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERROMUTI003: Insertion failed in petition_pattadar for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERROMUTI003: Registration of Office Mutation by Inheritance failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
        }
        $dagDetails=array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'user_code'=>$this->session->userdata('user_code'),
            'date_entry'=>date('Y-m-d'),
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'operation'=>'E',
            'dag_no'=>$data['app']->dag_no,
            'patta_no'=>$this->input->post('patta_no') ,
            'patta_type_code'  => $this->input->post('patta_type') ,
            'm_dag_area_b'=>$_POST['mut_area_b'],
            'm_dag_area_k' =>$_POST['mut_area_k'],
            'm_dag_area_lc' =>$_POST['mut_area_l'],
            'm_dag_area_g' =>$_POST['mut_area_g'],
            'm_dag_area_kr' =>0,
            'dag_area_b' =>$data['pattaNo']->dag_area_b,
            'dag_area_k' =>$data['pattaNo']->dag_area_k,
            'dag_area_lc' =>$data['pattaNo']->dag_area_lc,  
            'dag_area_g' =>$dag_area_g,  
            'dag_area_kr' =>$dag_area_kr
            );
            $insPetDag = $this->db->insert('petition_dag_details',$dagDetails);
            if($insPetDag != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERROMUTI004: Insertion failed in petition_dag_details for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERROMUTI004: Registration of Office Mutation by Inheritance failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
            $basundhara=array(
                'dharitree'=>$case_no['case_no'],
                'basundhara'=>$application_no,
                'date_reg'=>date('Y-m-d'),
                'reg_by'=>$this->session->userdata('user_code'),
                'app_status'=>'P',
                'pending_with'=>'CO'
            );
            //////////UUID Insert/////////////
            $basundhara['uuid']=$this->utilityclass->getVillageUUID($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code);
            ///////////////////////
            $insBasu = $this->db->insert('basundhar_application',$basundhara);
            if($insBasu != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERROMUTI005: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERROMUTI005: Registration of Office Mutation by Inheritance failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
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
                //////////////POST To rtps/////////////////////
                $rmk='Forwarded to CO';
                $status='M';
                $task='AST';
                $pen='CO';
                $case=$case_no['case_no'];
                $this->rtpsmodel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                //////////////////
                
                $this->DashboardInheritance($case_no['case_no']);

                $this->session->set_flashdata('message',"Application Forwarded to Circle Officer Successfully with case no ".$case_no['case_no']);
                //////////////////////////////////
                $data=array(
                    'success'=>"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no]",
                    'redirect_url'=>base_url().'index.php/home'
                );
            }
            echo json_encode($data);
    }
    function deedofcPost(){
                //xss & security validation starts
                $errorMessageStr = '';
                $resp = checkRequestSpecChar($_POST);
                if($resp['status'] == 'n'){
                    $errorMessageStr .= $resp['messages'];
                }
                $resp = checkRequestValidQuery($_POST);
                if($resp['status'] == 'n'){
                    $errorMessageStr .= $resp['messages'];
                }    
                if($errorMessageStr != ''){
                    $data=array(
                        'error' => $errorMessageStr
                    );
                    echo json_encode($data);
                    return false;
                    exit;
                }
                //xss & security validation ends 
        $application_no=$_POST['application_no'];
        //////////////////
        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
                $data=array(
                    'error'=>"Case have been Registered Already. Please Check"
                );
                echo json_encode($data);
                exit;
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
        $data['secParty']=$output->applicants;
        //var_dump($data);
         $dist_code = $data['app']->dist_code;
        if(in_array($dist_code, json_decode(BARAK_VALLEY))){
            $dag_area_g = $data['pattaNo']->dag_area_g==null?"0":$data['pattaNo']->dag_area_g;
            $dag_area_kr = $data['pattaNo']->dag_area_kr==null?"0":$data['pattaNo']->dag_area_kr;
        }
        else{
            $dag_area_g = 0;
            $dag_area_kr = 0;
        }

        $this->db->trans_begin();
        //$case_no=$this->rtpsmodel->genearteOfcCaseNo('03');

        $case_name=$this->rtpsmodel->genearteCaseName();
         if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Session Out. Please try Again"
            );
            echo json_encode($data);
            exit;
            die();
        }
        // $case_no['petition_no']=$petition_no=$this->rtpsmodel->genearteOfficePetitionNo();
        // $case_no['case_no']=$case_name.$petition_no."/OMUT";

        $seq_pet=year_no.'00';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteOfficePetitionNo();
        $case_no['case_no']=$case_name.$petition_no."/OMUT";

        $basic=array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'user_code'=>$this->session->userdata('user_code'),
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'mut_type'=>'03', /////mut type
            'trans_code'=>$this->input->post('mut_type'),//////sale deed
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'date_entry' => date('Y-m-d G:i:s'),                 
            'operation'=>'E',
            'user_code'=>$this->session->userdata('user_code'),
            'submission_date' => date('Y-m-d G:i:s'),
            'add_off_name' => $_POST['add_of_name'],
            'noc_no'=>$data['secParty'][0]->noc_no,
            'noc_date'=>$data['secParty'][0]->noc_date,
            'deed_no' => $_POST['deed_no'],
            'deed_value' => $_POST['deed_value'],
            'deed_date' => $_POST['deed_date']
        );
        $insPetBasicOMUTD = $this->db->insert('petition_basic',$basic);
        //echo $this->db->last_query();return;
        if($insPetBasicOMUTD != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERROMUTD001: Insertion failed in petition_basic for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERROMUTD001: Registration of Office Mutation by Deed failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }

        //////Buyer Insert////////////
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
                'petition_no'=>$case_no['petition_no'],
                'year_no'=>date('Y'),
                'operation'=>'E',
                'pet_name' => $pet->pat_name_ass,
                'guard_name' => $pet->pat_gurdian_name_ass,
                'pdar_name_eng' => $pet->pat_name_eng,
                'pdar_guard_eng' => $pet->pat_gurdian_name_eng,
                // 'guard_rel' => 'f', //////////////////////to be update
                // 'pet_gender'=>$pet->pat_gender,
                'guard_rel' =>$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->pat_gurdian_rel_id),/////////////
                'pet_gender'=>$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->pat_gender),
                'pet_id' => $i++,
                //'add1' => $pet->address,
                'add1' => $faddress[0],
                'add2' => $faddress[1],
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'new_pattadar' => 'N',
                'pet_minor_dob' => date('Y-m-d G:i:s',strtotime($pet->dob)),
                'pdar_mobile' => $pet->pat_mobile_no,
                'applied_b' =>0,
                'applied_k' => 0,
                'applied_lc' => 0
            );
            $insPetitionerOMUTD = $this->db->insert('petitioner', $buyerInsert);
            if($insPetitionerOMUTD != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERROMUTD002: Insertion failed in petitioner RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERROMUTD002: Registration of Office Mutation by Deed failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
        }
        $cron_no=1;
        foreach($data['secParty'] as $pet){
            $sellerInsert = array(
                'dist_code'=>$data['app']->dist_code,
                'subdiv_code'=>$data['app']->subdiv_code,
                'cir_code'=>$data['app']->cir_code,
                'mouza_pargona_code'=>$data['app']->mouza_code,
                'lot_no'=>$data['app']->lot_no,
                'vill_townprt_code'=>$data['app']->village_code,
                'user_code'=>$this->session->userdata('user_code'),
                'petition_no'=>$case_no['petition_no'],
                'year_no'=>date('Y'),
                'operation'=>'E',
                'dag_no'=>$data['app']->dag_no,
                'patta_no'=>$this->input->post('patta_no') ,
                'patta_type_code'  => $this->input->post('patta_type') ,
                'pdar_id' => $pet->chitha_pdar_id,
                'pdar_cron_no' => $pet->chitha_pdar_id,
                'pdar_name' => $pet->name_ass,
                'pdar_guardian'=>$pet->gurdian_name_ass,
                'dag_no' =>$data['app']->dag_no,
                'patta_no' => $_POST['patta_no'],
                'patta_type_code' => $_POST['patta_type'],
                'pdar_id' =>  $pet->chitha_pdar_id,
                'pdar_cron_no' => $cron_no++,
                'pdar_name' => $pet->name_ass,
                'pdar_guardian' => $pet->gurdian_name_ass,
                //'pdar_rel_guar' => 'f',
                'pdar_rel_guar' =>'u',//$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->gurdian_relation_id),/////////////
                'pdar_gender'=>'m',//$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->gender),
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E'
            );
            $insPetPattadarOMUTD = $this->db->insert('petition_pattadar', $sellerInsert);
            if($insPetPattadarOMUTD != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERROMUTD003: Insertion failed in petition_pattadar for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERROMUTD003: Registration of Office Mutation by Deed failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
        }
        $dagDetails=array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'user_code'=>$this->session->userdata('user_code'),
            'date_entry'=>date('Y-m-d'),
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'operation'=>'E',
            'dag_no'=>$data['app']->dag_no,
            'patta_no'=>$this->input->post('patta_no') ,
            'patta_type_code'  => $this->input->post('patta_type') ,
            'm_dag_area_b'=>floor($_POST['mut_area_b']),
            'm_dag_area_k' =>$_POST['mut_area_k'],
            'm_dag_area_lc' =>$_POST['mut_area_l'],
            'm_dag_area_g' =>$_POST['mut_area_g'],
            'm_dag_area_kr' =>0,
            'dag_area_b' =>$data['pattaNo']->dag_area_b,
            'dag_area_k' =>$data['pattaNo']->dag_area_k,
            'dag_area_lc' =>$data['pattaNo']->dag_area_lc,  
            'dag_area_g' =>$dag_area_g,  
            'dag_area_kr' =>$dag_area_kr
            );
            $insPetDagOMUTD = $this->db->insert('petition_dag_details',$dagDetails);
            if($insPetDagOMUTD != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERROMUTD004: Insertion failed in petition_dag_details for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERROMUTD004: Registration of Office Mutation by Deed failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
           $basundhara=array(
                'dharitree'=>$case_no['case_no'],
                'basundhara'=>$application_no,
                'date_reg'=>date('Y-m-d'),
                'reg_by'=>$this->session->userdata('user_code'),
                'app_status'=>'P',
                'pending_with'=>'CO'
            );
            //////////UUID Insert/////////////
            $basundhara['uuid']=$this->utilityclass->getVillageUUID($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code);
            ///////////////////////
            $insBasuOMUTD = $this->db->insert('basundhar_application',$basundhara);
            if($insBasuOMUTD != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERROMUTD005: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERROMUTD005: Registration of Office Mutation by Deed failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
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
                //////////////POST To rtps/////////////////////
                $rmk='Forwarded to CO';
                $status='M';
                $task='AST';
                $pen='CO';
                $case=$case_no['case_no'];
                $this->rtpsmodel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                //////////////////
                
                $this->DashboardInheritance($case_no['case_no']);

                $this->session->set_flashdata('message',"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no] ");
                //////////////////////////////////
                $data=array(
                    'success'=>"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no]",
                    'redirect_url'=>base_url().'index.php/home'
                );
            }
        echo json_encode($data);
    }

    // Added by Abhijit -- 2024-04-22
    public function deedMultiDagOfcPost(){
        //xss & security validation starts
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }
        $resp = checkRequestValidQuery($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }    
        if($errorMessageStr != ''){
            $data=array(
                'error' => $errorMessageStr
            );
            echo json_encode($data);
            return false;
            exit;
        }
        //xss & security validation ends 

        $application_no=$_POST['application_no'];
        //////////////////
        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
                $data=array(
                    'error'=>"Case have been Registered Already. Please Check"
                );
                echo json_encode($data);
                exit;
        }
        /////////////////////
        $url = RTPS_API_LINK."serviceResponseMultiGen?application_no=" . $application_no ;
        $output = sendCurlRequest($url);
        $output = json_decode($output);
        $application = $output->application;
        if(!$application){
            $data=array(
                'error' => "No such case found."
            );
            echo json_encode($data);
            exit;
        }

        // if(MULTI_DAG_MUTATION_DEED_ACTIVE != 1 || $application->service_code != 27){
        //     log_message('error', '#ERRMULDRTPSCSREG0002: MULTI_DAG_MUTATION_DEED_ACTIVE is inactive or service_code is not 27');
        //     $data=array(
        //         'error' => "#ERRMULDRTPSCSREG0002: Something went wrong. Please try again later."
        //     );
        //     echo json_encode($data);
        //     exit;
            
        // }
        if($application->is_multidag != 'Y'){
            log_message('error', '#ERRMULDRTPSCSREG0002: MULTI_DAG_MUTATION_DEED_ACTIVE is inactive or service_code is not 27');
            $data=array(
                'error' => "#ERRMULDRTPSCSREG0002: Something went wrong. Please try again later."
            );
            echo json_encode($data);
            exit;
            
        }

        $data['app'] = $application;
        // $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$data['app']->dag_no);
        
        $data['firstParty']=$output->mutation;
        $data['secParty']=$output->applicants;
        $data['dag_wise_land_details'] = $output->dag_wise_land_details;
        //var_dump($data);
        $dist_code = $data['app']->dist_code;
        // if(in_array($dist_code, json_decode(BARAK_VALLEY))){
        //     $dag_area_g = $data['pattaNo']->dag_area_g==null?"0":$data['pattaNo']->dag_area_g;
        //     $dag_area_kr = $data['pattaNo']->dag_area_kr==null?"0":$data['pattaNo']->dag_area_kr;
        // }
        // else{
        //     $dag_area_g = 0;
        //     $dag_area_kr = 0;
        // }

        $this->db->trans_begin();
        //$case_no=$this->rtpsmodel->genearteOfcCaseNo('03');

        $case_name=$this->rtpsmodel->genearteCaseName();
        if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Session Out. Please try Again"
            );
            echo json_encode($data);
            exit;
            die();
        }
        // $case_no['petition_no']=$petition_no=$this->rtpsmodel->genearteOfficePetitionNo();
        // $case_no['case_no']=$case_name.$petition_no."/OMUT";

        $seq_pet=year_no.'00';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteOfficePetitionNo();
        $case_no['case_no']=$case_name.$petition_no."/OMUT";
        
        $deed_no = $data['secParty'][0]->deed_no;
        $deed_value = $data['secParty'][0]->deed_value;
        $deed_date = $data['secParty'][0]->deed_date;

        if(RTPS_FLAG != 1){
            $deed_no = $this->input->post('deed_no');
            $deed_value = $this->input->post('deed_value');
            $deed_date = $this->input->post('deed_date');
        }

        $basic=array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'user_code'=>$this->session->userdata('user_code'),
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'mut_type'=>'03', /////mut type
            'trans_code'=>$this->input->post('mut_type'),//////sale deed
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'date_entry' => date('Y-m-d G:i:s'),                 
            'operation'=>'E',
            'user_code'=>$this->session->userdata('user_code'),
            'submission_date' => date('Y-m-d G:i:s'),
            'add_off_name' => $_POST['add_of_name'],
            'noc_no'=>$data['secParty'][0]->noc_no,
            'noc_date'=>$data['secParty'][0]->noc_date,
            'deed_no' => $deed_no,
            'deed_value' => $deed_value,
            'deed_date' => $deed_date,
            'is_multidag' => 'Y'
        );
        $insPetBasicOMUTD = $this->db->insert('petition_basic',$basic);
        //echo $this->db->last_query();return;
        if($insPetBasicOMUTD != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERROMULMUTD001: Insertion failed in petition_basic for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERROMULMUTD001: Registration of Office Mutation by Deed failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }

        //////Buyer Insert////////////
        $i=1;
        $remove_applicants = [];
        if(isset($_POST['remove_applicant']) && count($_POST['remove_applicant'])){
            $remove_applicants = $_POST['remove_applicant'];
        }
        foreach($data['firstParty'] as $key => $pet){
            if(!in_array($key, $remove_applicants)){
                $faddress=$this->address($pet->address);
                $buyerInsert = array(
                    'dist_code'=>$data['app']->dist_code,
                    'subdiv_code'=>$data['app']->subdiv_code,
                    'cir_code'=>$data['app']->cir_code,
                    'mouza_pargona_code'=>$data['app']->mouza_code,
                    'lot_no'=>$data['app']->lot_no,
                    'vill_townprt_code'=>$data['app']->village_code,
                    'petition_no'=>$case_no['petition_no'],
                    'year_no'=>date('Y'),
                    'operation'=>'E',
                    'pet_name' => $pet->pat_name_ass,
                    'guard_name' => $pet->pat_gurdian_name_ass,
                    'pdar_name_eng' => $pet->pat_name_eng,
                    'pdar_guard_eng' => $pet->pat_gurdian_name_eng,
                    // 'guard_rel' => 'f', //////////////////////to be update
                    // 'pet_gender'=>$pet->pat_gender,
                    'guard_rel' =>$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->pat_gurdian_rel_id),/////////////
                    'pet_gender'=>$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->pat_gender),
                    'pet_id' => $i++,
                    //'add1' => $pet->address,
                    'add1' => $faddress[0],
                    'add2' => $faddress[1],
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'E',
                    'new_pattadar' => 'N',
                    'pet_minor_dob' => date('Y-m-d G:i:s',strtotime($pet->dob)),
                    'pdar_mobile' => $pet->pat_mobile_no,
                    'applied_b' =>0,
                    'applied_k' => 0,
                    'applied_lc' => 0,
    
                    'marital_status' => $pet->marital_status,
                    'applicant_occupation' => $pet->applicant_occupation,
                    'caste_category' => $pet->caste_category,
                    'tribe_category' => $pet->tribe_category ?? NULL,
                );
                $insPetitionerOMUTD = $this->db->insert('petitioner', $buyerInsert);
                if($insPetitionerOMUTD != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROMULMUTD002: Insertion failed in petitioner RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERROMULMUTD002: Registration of Office Mutation by Deed failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
            }
        }
        $cron_no=1;
        foreach($data['secParty'] as $pet){
            $pattaDetails = $this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no, $data['app']->village_code, $pet->dag_no);

            $sellerInsert = array(
                'dist_code'=>$data['app']->dist_code,
                'subdiv_code'=>$data['app']->subdiv_code,
                'cir_code'=>$data['app']->cir_code,
                'mouza_pargona_code'=>$data['app']->mouza_code,
                'lot_no'=>$data['app']->lot_no,
                'vill_townprt_code'=>$data['app']->village_code,
                'user_code'=>$this->session->userdata('user_code'),
                'petition_no'=>$case_no['petition_no'],
                'year_no'=>date('Y'),
                'operation'=>'E',
                'pdar_id' => $pet->chitha_pdar_id,
                // 'dag_no'=>$data['app']->dag_no,
                // 'pdar_cron_no' => $pet->chitha_pdar_id,
                // 'pdar_name' => $pet->name_ass,
                // 'pdar_guardian'=> $pet->gurdian_name_ass,
                'dag_no' => $pet->dag_no,
                'patta_no'              =>  $pattaDetails->patta_no,
                'patta_type_code'       =>  $pattaDetails->patta_type_code,
                // 'patta_no'=>$this->input->post('patta_no') ,
                // 'patta_type_code'  => $this->input->post('patta_type') ,
                'pdar_cron_no' => $cron_no++,
                'pdar_name' => $pet->name_ass,
                'pdar_guardian' => $pet->gurdian_name_ass,
                //'pdar_rel_guar' => 'f',
                'pdar_rel_guar' =>'u',//$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->gurdian_relation_id),/////////////
                'pdar_gender'=>'m',//$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->gender),
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E'
            );
            $insPetPattadarOMUTD = $this->db->insert('petition_pattadar', $sellerInsert);
            if($insPetPattadarOMUTD != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERROMULMUTD003: Insertion failed in petition_pattadar for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERROMULMUTD003: Registration of Office Mutation by Deed failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
        }

        if(count($data['dag_wise_land_details'])){
            foreach($data['dag_wise_land_details'] as $dag_detail){
                $pattaDetails = $this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$dag_detail->dag_no);
    
                if(in_array($dist_code, json_decode(BARAK_VALLEY))){
                    $dag_area_g = $pattaDetails->dag_area_g == null ? "0" : $pattaDetails->dag_area_g;
                    $dag_area_kr = $pattaDetails->dag_area_kr == null ? "0" : $pattaDetails->dag_area_kr;
                }
                else{
                    $dag_area_g = 0;
                    $dag_area_kr = 0;
                }

                $dagDetails=array(
                                    'dist_code'           => $data['app']->dist_code,
                                    'subdiv_code'         => $data['app']->subdiv_code,
                                    'cir_code'            => $data['app']->cir_code,
                                    'mouza_pargona_code'  => $data['app']->mouza_code,
                                    'lot_no'              => $data['app']->lot_no,
                                    'vill_townprt_code'   => $data['app']->village_code,
                                    'user_code'           => $this->session->userdata('user_code'),
                                    'date_entry'          => date('Y-m-d'),
                                    'petition_no'         => $case_no['petition_no'],
                                    'year_no'             => date('Y'),
                                    'operation'           => 'E',
                                    'dag_no'              =>    $dag_detail->dag_no,
                                    'patta_no'            =>    $pattaDetails->patta_no,
                                    'patta_type_code'     =>    $pattaDetails->patta_type_code,
                                    'm_dag_area_b'        =>    RTPS_FLAG == 1 ? $dag_detail->area_b : $this->input->post('mut_area_b['. $dag_detail->dag_no .']'),
                                    'm_dag_area_k'        =>    RTPS_FLAG == 1 ? $dag_detail->area_k : $this->input->post('mut_area_k['. $dag_detail->dag_no .']'),
                                    'm_dag_area_lc'       =>    RTPS_FLAG == 1 ? $dag_detail->area_l : $this->input->post('mut_area_l['. $dag_detail->dag_no .']'),
                                    'm_dag_area_g'        =>    RTPS_FLAG == 1 ? $dag_detail->area_go : $this->input->post('mut_area_g['. $dag_detail->dag_no .']'),
                                    'm_dag_area_kr'       =>    RTPS_FLAG == 1 ? $dag_detail->area_ka : 0 ,
                                    // 'm_dag_area_b'=>floor($_POST['mut_area_b']),
                                    // 'm_dag_area_k' =>$_POST['mut_area_k'],
                                    // 'm_dag_area_lc' =>$_POST['mut_area_l'],
                                    // 'm_dag_area_g' =>$_POST['mut_area_g'],
                                    // 'm_dag_area_kr' =>0,
                                    'dag_area_b'          =>    $pattaDetails->dag_area_b,
                                    'dag_area_k'          =>    $pattaDetails->dag_area_k,
                                    'dag_area_lc'         =>    $pattaDetails->dag_area_lc,  
                                    // 'dag_area_b'          => $data['pattaNo']->dag_area_b,
                                    // 'dag_area_k'          => $data['pattaNo']->dag_area_k,
                                    // 'dag_area_lc'         => $data['pattaNo']->dag_area_lc,  
                                    'dag_area_g'          => $dag_area_g,  
                                    'dag_area_kr'         => $dag_area_kr
                                );

                $insPetDagOMUTD = $this->db->insert('petition_dag_details',$dagDetails);
                if($insPetDagOMUTD != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROMULMUTD004: Insertion failed in petition_dag_details for RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERROMULMUTD004: Registration of Office Mutation by Deed failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
            }
        }

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
                    
                }
                else{
                    $data=array(
                        'error' => 'File is required'
                    );
                    echo json_encode($data);
                    return false;
                }
            }
        }
        ///////////////////Insert attached file////////////////////////
        if(isset($_FILES['fileUpload']['name'])){
            for($i = 0; $i < $fileCount; $i++)
            {
                $_FILES['file']['name'] = $_FILES['fileUpload']['name'][$i];
                $_FILES['file']['type'] = $_FILES['fileUpload']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['fileUpload']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['fileUpload']['error'][$i];
                $_FILES['file']['size'] = $_FILES['fileUpload']['size'][$i];
                $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                $exp  = explode("/",$mime);
                $onlyExtension  = $exp[1];
                $replaceCase=str_replace("/","-",$case_no['case_no']);
                $fileRename =  $replaceCase."-".time() . '.' . $onlyExtension;
                $config['upload_path']   = MANUAL_ATTACHMENT;
                $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                $config['max_size']  = ALLOWED_UPLOAD_FILE_SIZE;
                $config['file_name'] = $fileRename;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('file'))
                {
                    $document= array(
                        'case_no'   => $case_no['case_no'],
                        'file_name' => $_POST['fileText'][$i],
                        'user_code' => $this->session->userdata('user_code'),
                        // 'fetch_file_name' => $_FILES['file']['name'],
                        'fetch_file_name' => $_POST['fileText'][$i],
                        'file_type'  => $_FILES['file']['type'],
                        'file_path'  => MANUAL_ATTACHMENT . $fileRename,
                        'date_entry' => date('Y-m-d h:i:s'),
                        'mut_type'   => 'FM',
                    );
                    // save data in attachment file
                    $addMoreDocQuery = $this->db->insert('supportive_document',$document);
                    if($addMoreDocQuery != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRADDDOC0004: Insertion failed in supportive document RTPS Case No '.$case_no);
                        $data=array(
                            'error' => "#ERRADDDOC0004: Registration of Settlement failed for case no : ".$case_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }
                else
                {
                    $this->db->trans_rollback();
                    // todo error show
                    // redirect to respected route with error mgs
                    log_message('error', '#ERRADDDOC0005: Insertion failed in supportive document RTPS Case No '.$case_no);
                    $data=array(
                        'error' => "#ERRADDDOC0005: Registration of Settlement failed for case no : ".$case_no
                    );
                    echo json_encode($data);
                    return false;

                }
            }
        }

        $basundhara=array(
            'dharitree'=>$case_no['case_no'],
            'basundhara'=>$application_no,
            'date_reg'=>date('Y-m-d'),
            'reg_by'=>$this->session->userdata('user_code'),
            'app_status'=>'P',
            'pending_with'=>'CO'
        );
        //////////UUID Insert/////////////
        $basundhara['uuid']=$this->utilityclass->getVillageUUID($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code);
        ///////////////////////
        $insBasuOMUTD = $this->db->insert('basundhar_application',$basundhara);
        if($insBasuOMUTD != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERROMULMUTD004: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERROMULMUTD004: Registration of Office Mutation by Deed failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }

        $all_row_updated = $this->updateCaseIdForNok($application_no, $case_no['case_no']);
        if(!$all_row_updated){
            log_message('error', '#ERRFMUTMULDNOK002: Failed update nok for RTPS Case No '.$application_no . ' Last Query => ' . $this->db->last_query());
            $this->db->trans_rollback();
            $data = array(
                'error'=>"#ERRFMUTMULDNOK002: Registration of Field Mutation by Deed failed for case no : ".$application_no
            );

            return response_json($data);
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
            //////////////POST To rtps/////////////////////
            $rmk='Forwarded to CO';
            $status='M';
            $task='AST';
            $pen='CO';
            $case=$case_no['case_no'];
            $this->rtpsmodel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
            //////////////////
            
            $this->DashboardInheritance($case_no['case_no']);

            $this->session->set_flashdata('message',"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no] ");
            //////////////////////////////////
            $data=array(
                'success'=>"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no]",
                'redirect_url'=>base_url().'index.php/home'
            );
        }

        echo json_encode($data);
    }

    function partitionPostOfc(){
        //xss & security validation starts
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST,array(),array(),array('remark' => true));
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }
        $resp = checkRequestValidQuery($_POST,array(),array('remark' => true));
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }    
        if($errorMessageStr != ''){
            $data=array(
                'error' => $errorMessageStr
            );
            echo json_encode($data);
            return false;
            exit;
        }
        //xss & security validation ends 
        $application_no=$_POST['application_no'];
        //////////////////
        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
                $data=array(
                    'error'=>"Case have been Registered Already. Please Check"
                );
                echo json_encode($data);
                exit;
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
        $this->db->trans_begin();
        //$case_no=$this->rtpsmodel->genearteOfcCaseNo('04');

        $case_name=$this->rtpsmodel->genearteCaseName();
         if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Session Out. Please try Again"
            );
            echo json_encode($data);
            exit;
            die();
        }
        // $case_no['petition_no']=$petition_no=$this->rtpsmodel->genearteOfficePetitionNo();

        // $case_no['case_no']=$case_name.$petition_no."/OPART";

// Validate before state change starts (By Deep)
$validate_in_db = $_SESSION['credentials']['dn'];
$validate_pattadar_data[]='';
$validate_pattadar_data[0]=array(
    'dist_code' => $data['app']->dist_code,
    'subdiv_code' => $data['app']->subdiv_code,
    'cir_code' => $data['app']->cir_code,
    'mouza_code' => $data['app']->mouza_code,
    'lot_no' => $data['app']->lot_no,
    'village_code' => $data['app']->village_code,
    'dag_no' => $data['app']->dag_no,
    'patta_no' => trim($data['pattaNo']->patta_no),
    'patta_type_code' => $data['pattaNo']->patta_type_code,
    'chitha_pdar_id' => $data['firstParty'][0]->chitha_pdar_id,          
);
$validate_chitha_location_data[]='';
$validate_chitha_location_data[0]=array(
    $data['app']->dist_code,
    $data['app']->cir_code,
    $data['app']->subdiv_code,
    $data['app']->village_code,
    $data['app']->mouza_code,
    $data['app']->lot_no,
    $data['app']->dag_no,
);
// Vally wise area deferanciation (By Deep)
$for_vally='';
$validate_chitha_area_data_barak []='';
$validate_chitha_area_data_bramha[] ='';

$for_vally=in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY));
if($for_vally==1) //Barak Valley 1
{
    $validate_chitha_area_data_barak=array(
        'dag_area_b' => $data['firstParty'][0]->area_b,
        'dag_area_k' => $data['firstParty'][0]->area_k,
        'dag_area_lc' => $data['firstParty'][0]->area_l,
        'dag_area_g' => $data['firstParty'][0]->area_go,
        'dag_area_kr' =>$data['firstParty'][0]->area_ka,
    );
}
else //Bramhaputra Valley !1
{
    $validate_chitha_area_data_bramha=array(
        'area_b' => $data['firstParty'][0]->area_b,
        'area_k' => $data['firstParty'][0]->area_k,
        'area_l' => $data['firstParty'][0]->area_l,
    );
}
$ret_val='';
$ret_val = $this->pre_post_validate($validate_in_db,$validate_pattadar_data,$validate_chitha_location_data,$validate_chitha_area_data_barak,$validate_chitha_area_data_bramha,$application_no);
if($ret_val!=1 and !empty($ret_val))
{
    $data = array(
        'error'=>$ret_val.$application_no
    );
    echo json_encode($data);
    return false;
}
$validate_in_db = $_SESSION['credentials']['dn'];
$validate_pattadar_data[]='';

$validate_chitha_location_data[]='';
$validate_chitha_location_data[0]=array(
    $data['app']->dist_code,
    $data['app']->cir_code,
    $data['app']->subdiv_code,
    $data['app']->village_code,
    $data['app']->mouza_code,
    $data['app']->lot_no,
    $data['app']->dag_no,
);
// Vally wise post area deferanciation (By Deep)
$for_vally='';
$validate_chitha_area_data_barak=null;
$validate_chitha_area_data_bramha=null;

$for_vally=in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY));
if($for_vally==1) //Barak Valley 1
{
    $mut_area_b = $_POST['mut_area_b'];
    $mut_area_k = $_POST['mut_area_k'];
    $mut_area_l = $_POST['mut_area_l'];
    $mut_area_g = $_POST['mut_area_g'];
    $validate_chitha_area_data_barak=array(
        'dag_area_b' => trim($mut_area_b),
        'dag_area_k' => trim($mut_area_k),
        'dag_area_lc' => trim($mut_area_l),
        'dag_area_g' => trim($mut_area_g),
        'dag_area_kr' => 0,
    );
}
else //Bramhaputra Valley !1
{
    $mut_area_b = $_POST['mut_area_b'];
    $mut_area_k = $_POST['mut_area_k'];
    $mut_area_l = $_POST['mut_area_l'];
    $validate_chitha_area_data_bramha=array(
        'area_b' => trim($mut_area_b),
        'area_k' => trim($mut_area_k),
        'area_l' => trim($mut_area_l),
    );
}
$ret_val='';
$ret_val = $this->pre_post_only_area_validate($validate_in_db,$validate_chitha_location_data, $validate_chitha_area_data_barak,$validate_chitha_area_data_bramha);
if($ret_val!=1 and !empty($ret_val))
{
    $data = array(
        'error'=>$ret_val.$application_no,
        'info' =>'Wrong Area'
    );
    echo json_encode($data);
    return false;
}

// Validate before state change ends (By Deep)


        $seq_pet=year_no.'00';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteOfficePetitionNo();
        $case_no['case_no']=$case_name.$petition_no."/OPART";

        $basic=array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'user_code'=>$this->session->userdata('user_code'),
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'mut_type'=>'04',                    
            'operation'=>'E',
            'submission_date' => date('Y-m-d G:i:s'),
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'add_off_name' => $_POST['add_of_name'],
            'add_off_desig' => 'CO',
            'co_user_code' => $_POST['add_of_name'],
            'complete_partition_yn' => 'Y',
        );

        $insBasicOPART = $this->db->insert('petition_basic', $basic);
        if($insBasicOPART != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERROPART001: Insertion failed in petition_basic for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERROPART001: Registration of Office Partition failed for case no : ".$application_no
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
            'user_code'=>$this->session->userdata('user_code'),
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'operation'=>'E',
        );
        $fmd['dag_no']=$data['app']->dag_no;
        $fmd['patta_no']=$data['pattaNo']->patta_no;
        $fmd['patta_type_code']=$data['pattaNo']->patta_type_code;
        $fmd['m_dag_area_b']=$_POST['mut_area_b'];
        $fmd['m_dag_area_k']=$_POST['mut_area_k'];
        $fmd['m_dag_area_lc']=$_POST['mut_area_l'];
        $fmd['dag_area_b']=$data['pattaNo']->dag_area_b;
        $fmd['dag_area_k']=$data['pattaNo']->dag_area_k;
        $fmd['dag_area_lc']=$data['pattaNo']->dag_area_lc;
        ///////////// BARAK VALLEY CODE START HERE ////////////////
        if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){ 
            $fmd['m_dag_area_g']=$_POST['mut_area_g'];
            $fmd['dag_area_g']=$data['pattaNo']->dag_area_g;

        }
        else {
            $fmd['m_dag_area_g']='0.00'; 
            $fmd['dag_area_g']='0';   
        }
        ///////////// BARAK VALLEY CODE END HERE ////////////////
        $fmd['m_dag_area_kr']='0';
        $fmd['dag_area_kr']='0';
        $insDagOPART = $this->db->insert('petition_dag_details',$fmd);
        if($insDagOPART != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERROPART002: Insertion failed in petition_dag_details for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERROPART002: Registration of Office Partition failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }

        $i=1;
        foreach($data['firstParty'] as $part)
        {
            $petitioner=array(
                'dist_code'=>$data['app']->dist_code,
                'subdiv_code'=>$data['app']->subdiv_code,
                'cir_code'=>$data['app']->cir_code,
                'mouza_pargona_code'=>$data['app']->mouza_code,
                'lot_no'=>$data['app']->lot_no,
                'vill_townprt_code'=>$data['app']->village_code,
                'user_code'=>$this->session->userdata('user_code'),
                'date_entry'=>date('Y-m-d'),
                'case_no'=>$case_no['case_no'],
                'petition_no'=>$case_no['petition_no'],
                'operation'=>'E',
                'dag_no' =>$data['app']->dag_no,
                'patta_no' =>$data['pattaNo']->patta_no,
                'patta_type_code'=>$data['pattaNo']->patta_type_code,
                'year_no'=>date('Y'),
                'date_entry'=>date('Y-m-d'),

                'pdar_id' =>$part->chitha_pdar_id,
                'pdar_cron_no'=>$i++,
                'pdar_name' =>$part->name_ass,
                'pdar_guardian' =>$part->gurdian_name_ass,
                //'pdar_rel_guar' =>'f',/////////////
                //'pdar_gender'=>$part->gender,
                'pdar_rel_guar' =>$this->utilityclass->relationRevertBasu($data['app']->dist_code,$part->gender),/////////////
                'pdar_gender'=>$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$part->gurdian_relation_id),
                //'pdar_add1' => $part->address,
                // 'pdar_add1' => substr($part->address,0,90),
                // 'pdar_add2' => substr($part->address,90,150),
                'pdar_strike' => 'N',
                'is_converted_pattadar' => 'N',
                'pdar_mobile' => $part->mobile,
            );
            $insPetitionerOPART = $this->db->insert('petitioner_part',$petitioner);
            if($insPetitionerOPART != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERROPART003: Insertion failed in petitioner_part for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERROPART003: Registration of Office Partition failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
        }

        $basundhara=array(
            'dharitree'=>$case_no['case_no'],
            'basundhara'=>$application_no,
            'date_reg'=>date('Y-m-d'),
            'reg_by'=>$this->session->userdata('user_code'),
            'app_status'=>'P',
            'pending_with'=>'CO'
        );

        //////////UUID Insert/////////////
        $basundhara['uuid']=$this->utilityclass->getVillageUUID($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code);
        ///////////////////////
        $insBasuOPART = $this->db->insert('basundhar_application',$basundhara);
        if($insBasuOPART != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERROPART004: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERROPART004: Registration of Office Partition failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }

        $remark='Registered by Assistant';


        $proInsert = $this->mutationmodel->proceeding_order($case_no['case_no'],$remark);


        if($proInsert==false || $proInsert===false)
            {
                log_message('error', "#OPARTAST001:".$this->db->last_query());
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Updation failed(#OPARTAST001)".$application_no);
                redirect(base_url() . "index.php/home");
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

            $this->DashboardPartitionofc($case_no['case_no']);
            //////////////POST To rtps/////////////////////
            $rmk='Forwarded to CO';
            $status='M';
            $task='AST';
            $pen='CO';
            $case=$case_no['case_no'];
            $this->rtpsmodel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
            //////////////////
            $this->session->set_flashdata('message',"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no] ");
            //////////////////////////////////
            $data=array(
                'success'=>"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no]",
                'redirect_url'=>base_url().'index.php/home'
            );
        }
        echo json_encode($data);
    }
    //////Allotment Post////////
    function allotmentPost(){

        $allowed = ['AST'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }


        //xss & security validation starts
            $errorMessageStr = '';
            $resp = checkRequestSpecChar($_POST);
            if($resp['status'] == 'n'){
                $errorMessageStr .= $resp['messages'];
            }
            $resp = checkRequestValidQuery($_POST);
            if($resp['status'] == 'n'){
                $errorMessageStr .= $resp['messages'];
            }    
            if($errorMessageStr != ''){
                $data=array(
                    'error' => $errorMessageStr
                );
                echo json_encode($data);
                return false;
                exit;
            }
         //xss & security validation ends 
        $application_no=$_POST['application_no'];
        $data=array(
            'error'=>"#ERR4312 : Access Denied..."
        );
        echo json_encode($data);
        exit;
        //////////////////
        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
                $data=array(
                    'error'=>"Case have been Registered Already. Please Check"
                );
                echo json_encode($data);
                exit;
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
        $case_name=$this->rtpsmodel->genearteCaseName();
        if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Session Out. Please try Again"
            );
            echo json_encode($data);
            exit;
            die();
        }
        // $case_no['petition_no']=$petition_no=$this->rtpsmodel->genearteAlotPetitionNo();

        // $case_no['case_no']=$case_name.$petition_no."/ACPP";

        $seq_pet=year_no.'00';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteAlotPetitionNo();
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
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'allotment_under' => $data['firstParty'][0]->scheme_id,
            'petition_no' => $case_no['petition_no'],
            'original_alotee' => $data['firstParty'][0]->is_original,
            'name_of_allote' => $data['firstParty'][0]->allotee_name,
            'type_govt_land' => $data['firstParty'][0]->land_type,
        );
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
                'date_entry' => date('Y-m-d'),
                'self_declaration' => $dec,
                'auth_type' => $auth_type,
                'alotee_pan_card'=> $panNo,
                'alotee_aadhar' => $aadharNo, 
                'photo'=> $photo
            );

            $insPetACPP = $this->db->insert('allotment_petitioner', $allotment_petitioner);
            
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

        ///////////// BARAK VALLEY CODE START HERE ////////////////
        if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){ 
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
                'alot_area_b' => $_POST['mut_area_b'],
                'alot_area_k' =>$_POST['mut_area_k'],
                'alot_area_lc' => $_POST['mut_area_l'],
                'alot_area_g' => $_POST['mut_area_g'],
                'tot_area_b' => $data['pattaNo']->dag_area_b,
                'tot_area_k' => $data['pattaNo']->dag_area_k,
                'tot_area_lc' => $data['pattaNo']->dag_area_lc,
                'tot_area_g' => $data['pattaNo']->dag_area_g,
                'date_entry' => date('Y-m-d')
            );
        }
        else
        {
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
                'alot_area_b' => $_POST['mut_area_b'],
                'alot_area_k' =>$_POST['mut_area_k'],
                'alot_area_lc' => $_POST['mut_area_l'],
                'tot_area_b' => $data['pattaNo']->dag_area_b,
                'tot_area_k' => $data['pattaNo']->dag_area_k,
                'tot_area_lc' => $data['pattaNo']->dag_area_lc,
                'date_entry' => date('Y-m-d')
            );    
        }
        ///////////// BARAK VALLEY CODE ENDS HERE ////////////////
        $insDagACPP = $this->db->insert('allotment_pet_dag', $allotment_dag);
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
        $insDocACPP = $this->db->insert('allotment_doc_details', $allotment_doc_details);
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
        $basundhara=array(
            'dharitree'=>$case_no['case_no'],
            'basundhara'=>$application_no,
            'date_reg'=>date('Y-m-d'),
            'reg_by'=>$this->session->userdata('user_code'),
            'app_status'=>'P',
            'pending_with'=>'CO'
            );
        //////////UUID Insert/////////////
        $basundhara['uuid']=$this->utilityclass->getVillageUUID($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code);
        ///////////////////////
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
        }else
        {
        
            $this->DashboardAllot($case_no['case_no']);
            //////////////POST To rtps/////////////////////
            $rmk='Forwarded to CO';
            $status='M';
            $task='AST';
            $pen='CO';
            $case=$case_no['case_no'];
            $result=$this->rtpsmodel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
            if($result===true || $result=='true' || $result==1 || json_decode($result)=='true'|| json_decode($result)==true || json_decode($result)=='y' || $result=='y'){
                $this->db->trans_commit();
            }else{
                $data=array(
                    'error'=>"Error in submitting. Please try Again"
                );
                echo json_encode($data);
                return;
            }
            //////////////////
            $this->session->set_flashdata('message',"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no] ");
            //////////////////////////////////
            $data=array(
                'success'=>"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no]",
                'redirect_url'=>base_url().'index.php/home'
            );
        }
        echo json_encode($data);
    }
    /////////////////
    function conversionPost(){
        // if(!isset($_POST['application_no']) || $_POST['application_no']=='') {
        //     //ERRRTPSCONVAST0001
        //     log_message('error', 'Application No. is a required Parameter. Error: ERRRTPSCONVAST0001');
        //     $response = array(
        //         'responseType'=>1,
        //         'msg'=>'Application No. is a required Parameter',
        //         'errorCode'=>'ERRRTPSCONVAST0001',
        //         'data'=>array(
        //             'application_no'=>$_POST['application_no'],
        //             'redirectUrl'=>base_url('index.php/rtps/request/9')
        //         )
        //     );
        //     echo json_encode($response);
        //     exit;
        // }
        // if(!isset($_POST['add_of_name']) || $_POST['add_of_name']==''){
        //     //ERRRTPSCONVAST0002
        //     log_message('error', 'Required Parameters are empty. Error: ERRRTPSCONVAST0002');
        //     $response = array(
        //         'responseType'=>1,
        //         'msg'=>'Required Parameters are empty',
        //         'errorCode'=>'ERRRTPSCONVAST0002',
        //         'data'=>array(
        //             'application_no'=>$_POST['application_no'],
        //             'redirectUrl'=>base_url('index.php/rtps/conversionBasu?app='. $_POST['application_no'])
        //         )
        //     );
        //     echo json_encode($response);
        //     exit;
        // }
        $this->load->model('validation/AuthorizationModel');
        //form validation
        $formValidation = $this->FormValidationModel->formValidationForPost($_POST, [
            'application_no'=>'Application No.|required|application_no',
            'add_of_name'=>'Add of Name|required'
        ]);
        if($formValidation['status'] == 'n') {
            //ERRRTPSCONVAST0001
            log_message('error', 'Message: '. $formValidation['message'] .', Data: '. json_encode($formValidation['data']) .'. Error: ERRRTPSCONVAST0001');
            $response = array(
                'responseType'=>1,
                'msg'=>$formValidation['message'],
                'errorCode'=>'ERRRTPSCONVAST0001',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/rtps/request/9')
                )
            );
            echo json_encode($response);
            exit;
        }
        //check for Malicious
        $validquery = checkRequestValidQuery($_POST);
        if($validquery['status']=='n') {
            //ERRRTPSCONVAST0003
            log_message('error', $validquery['messages'] .'Error: ERRRTPSCONVAST0003');
            $response = array(
                'responseType'=>1,
                'msg'=>'Post parameters contain malicious characters.',
                'errorCode'=>'ERRRTPSCONVAST0003',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/rtps/request/9')
                )
            );
            echo json_encode($response);
            exit;
        }

        $checkSpclChar = checkRequestSpecChar($_POST);
        if($checkSpclChar['status']=='n') {
            //ERRRTPSCONVAST0004
            log_message('error', $checkSpclChar['messages'] .' Error: ERRRTPSCONVAST0004');
            $response = array(
                'responseType'=>1,
                'msg'=>'Input Parameter has illegal character',
                'errorCode'=>'ERRRTPSCONVAST0004',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/rtps/request/9')
                )
            );
            echo json_encode($response);
            exit;
        }
        
        //authorization
        $authorization = $this->AuthorizationModel->isAuthorized(101, 'AST', $_POST['application_no']);
        if($authorization['status']=='n') {
            //ERRRTPSCONVAST0006
            log_message('error', $authorization['messages'] .' Error: ERRRTPSCONVAST0006');
            $response = array(
                'responseType'=>1,
                'msg'=>$authorization['messages'],
                'errorCode'=>'ERRRTPSCONVAST0006',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/home')
                )
            );
            echo json_encode($response);
            exit;
        }

        //auth

        //authentication
        // $sessionData = $this->session->all_userdata();
        // if(empty($sessionData) || !$this->session->userdata('user_code')) {
        //     //ERRRTPSCONVAST0005
        //     log_message('error', 'User not authenticated. Error: ERRRTPSCONVAST0005');
        //     $response = array(
        //         'responseType'=>1,
        //         'msg'=>'User not authenticated',
        //         'errorCode'=>'ERRRTPSCONVAST0005',
        //         'data'=>array(
        //             'application_no'=>$_POST['application_no'],
        //             'redirectUrl'=>base_url('index.php/home')
        //         )
        //     );
        //     echo json_encode($response);
        //     exit;
        // }

        //authorization
        // $apiAuth = $this->checkApiAuth("serviceResponse?application_no=", $_POST['application_no']);
        // $api_dist_code = $apiAuth->application->dist_code;
        // $api_subdiv_code = $apiAuth->application->subdiv_code;
        // $api_cir_code = $apiAuth->application->cir_code;
        // if($api_dist_code!=$sessionData['dist_code'] || $api_subdiv_code!=$sessionData['subdiv_code'] || $api_cir_code!=$sessionData['cir_code']){
        //     //ERRRTPSCONVAST0006
        //     log_message('error', 'User not authorized. Error: ERRRTPSCONVAST0006');
        //     $response = array(
        //         'responseType'=>1,
        //         'msg'=>'User not authorized',
        //         'errorCode'=>'ERRRTPSCONVAST0006',
        //         'data'=>array(
        //             'application_no'=>$_POST['application_no'],
        //             'redirectUrl'=>base_url('index.php/home')
        //         )
        //     );
        //     echo json_encode($response);
        //     exit;
        // }

        $application_no=$_POST['application_no'];
        //////////////////
        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
            $response = array(
                'responseType'=>1,
                'msg'=>'Case have been Registered Already. Please Check',
                'errorCode'=>'ERRRTPSCONVAST0007',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/home')
                )
            );
            echo json_encode($response);
            exit;
                // $data=array(
                //     'error'=>"Case have been Registered Already. Please Check"
                // );
                // echo json_encode($data);
                // exit;
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
        $data['secParty']=$output->applicants;
        //var_dump($data);
        $this->db->trans_begin();
        //$case_no=$this->rtpsmodel->genearteOfcCaseNo('01');
        if(($data['app']->dist_code!=$this->session->userdata('dist_code')) || ($data['app']->subdiv_code!=$this->session->userdata('subdiv_code')) || ($data['app']->cir_code!=$this->session->userdata('cir_code')) )
        {
            $response = array(
                'responseType'=>1,
                'msg'=>'Please reload the page. Session might be Destroyed.',
                'errorCode'=>'ERRRTPSCONVAST0008',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/home')
                )
            );
            echo json_encode($response);
            exit;
            // $data=array(
            //     'error'=>"Please reload the page. Session might be Destroyed."
            // );
            // echo json_encode($data);
            // return false;
            // exit;
        }
        $case_name=$this->rtpsmodel->genearteCaseName();
         if(empty($case_name)){
            $response = array(
                'responseType'=>1,
                'msg'=>'Network Issue or Session Out. Please try Again',
                'errorCode'=>'ERRRTPSCONVAST0009',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/home')
                )
            );
            echo json_encode($response);
            exit;
            // $data=array(
            //     'error'=>"Network Issue or Session Out. Please try Again"
            // );
            // echo json_encode($data);
            // exit;
            // die();
        }
        // $case_no['petition_no']=$petition_no=$this->rtpsmodel->genearteOfficePetitionNo();

        // $case_no['case_no']=$case_name.$petition_no."/CONV";

        $seq_pet=year_no.'00';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteOfficePetitionNo();
        $case_no['case_no']=$case_name.$petition_no."/CONV";

        $basic=array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'user_code'=>$this->session->userdata('user_code'),
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'mut_type'=>'01', /////mut type
            'trans_code'=>'F',/////////full
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'date_entry' => date('Y-m-d G:i:s'),                 
            'operation'=>'E',
            'user_code'=>$this->session->userdata('user_code'),
            'submission_date' => date('Y-m-d G:i:s'),
            'add_off_name' => $_POST['add_of_name'],
            'add_off_desig' =>'CO',
            'supported_doc' => 'Y',
            'operation' => 'E',
            'co_user_code' =>$_POST['add_of_name']
            ///////// 
        );
        $insBasicCONV = $this->db->insert('petition_basic',$basic);
        if($insBasicCONV != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRCONV001: Insertion failed in petition_basic for RTPS Case No '.$application_no);
            $response = array(
                'responseType'=>1,
                'msg'=>"#ERRCONV001: Registration of AP TO PP CONVERSION failed for case no : ".$application_no,
                'errorCode'=>'ERRCONV001',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/home')
                )
            );
            echo json_encode($response);
            exit;
            // $data = array(
            //     'error'=>"#ERRCONV001: Registration of AP TO PP CONVERSION failed for case no : ".$application_no
            // );
            // echo json_encode($data);
            // return false;
        }
        $fmd=array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'user_code'=>$this->session->userdata('user_code'),
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
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
            $response = array(
                'responseType'=>1,
                'msg'=>"#ERRCONV002: Registration of AP TO PP CONVERSION failed for case no : ".$application_no,
                'errorCode'=>'ERRCONV002',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/home')
                )
            );
            echo json_encode($response);
            exit;
            // $data = array(
            //     'error'=>"#ERRCONV002: Registration of AP TO PP CONVERSION failed for case no : ".$application_no
            // );
            // echo json_encode($data);
            // return false;
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
                'user_code'=>$this->session->userdata('user_code'),
                'date_entry'=>date('Y-m-d'),
                'case_no'=>$case_no['case_no'],
                'petition_no'=>$case_no['petition_no'],
                'operation'=>'E',
                'dag_no' =>$data['app']->dag_no,
                'patta_no' =>$data['pattaNo']->patta_no,
                'patta_type_code'=>$data['pattaNo']->patta_type_code,
                'year_no'=>date('Y'),
                'date_entry'=>date('Y-m-d'),

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
                $response = array(
                    'responseType'=>1,
                    'msg'=>"#ERRCONV003: Registration of AP TO PP CONVERSION failed for case no : ".$application_no,
                    'errorCode'=>'ERRCONV003',
                    'data'=>array(
                        'application_no'=>$_POST['application_no'],
                        'redirectUrl'=>base_url('index.php/home')
                    )
                );
                echo json_encode($response);
                exit;
                // $data = array(
                //     'error'=>"#ERRCONV003: Registration of AP TO PP CONVERSION failed for case no : ".$application_no
                // );
                // echo json_encode($data);
                // return false;
            }
        }


        $basundhara=array(
            'dharitree'=>$case_no['case_no'],
            'basundhara'=>$application_no,
            'date_reg'=>date('Y-m-d'),
            'reg_by'=>$this->session->userdata('user_code'),
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
            $response = array(
                'responseType'=>1,
                'msg'=>"#ERRCONV004: Registration of AP TO PP CONVERSION failed for case no : ".$application_no,
                'errorCode'=>'ERRCONV004',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/home')
                )
            );
            echo json_encode($response);
            exit;
            // $data = array(
            //     'error'=>"#ERRCONV004: Registration of AP TO PP CONVERSION failed for case no : ".$application_no
            // );
            // echo json_encode($data);
            // return false;
        }


        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            $response = array(
                'responseType'=>1,
                'msg'=>"Error in submitting. Please try Again",
                'errorCode'=>'ERRRTPSCONVAST0010',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/home')
                )
            );
            echo json_encode($response);
            exit;
            // $data=array(
            //     'error'=>"Error in submitting. Please try Again"
            // );
            // echo json_encode($data);
            // return;
        }
        else
        {
            
            //////////////POST To rtps/////////////////////
            $rmk='Forwarded to CO';
            $status='M';
            $task='AST';
            $pen='CO';
            $case=$case_no['case_no'];
            $result=$this->rtpsmodel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
            if($result===true || $result=='true' || $result==1 || json_decode($result)=='true'|| json_decode($result)==true || json_decode($result)=='y' || $result=='y'){
                $this->db->trans_commit();
            }else{
                $response = array(
                    'responseType'=>1,
                    'msg'=>"Error in submitting. Please try Again",
                    'errorCode'=>'ERRRTPSCONVAST0011',
                    'data'=>array(
                        'application_no'=>$_POST['application_no'],
                        'redirectUrl'=>base_url('index.php/home')
                    )
                );
                echo json_encode($response);
                exit;
                // $data=array(
                //     'error'=>"Error in submitting. Please try Again"
                // );
                // echo json_encode($data);
                // return;
            }
            //////////////////
            $this->DashboardInheritance($case_no['case_no']);
            //////
            $this->session->set_flashdata('message',"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no] ");
            //////////////////////////////////
            $response = array(
                'responseType'=>2,
                'msg'=>"Application Forwarded to Circle Officer Successfully with case no ". $case_no['case_no'],
                'errorCode'=>'',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/home')
                )
            );
            echo json_encode($response);
            exit();
            // $data=array(
            //     'success'=>"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no]",
            //     'redirect_url'=>base_url().'index.php/home'
            // );
        }
        
    }
    function mbileUpdatePost(){
        $application_no=$_POST['application_no'];
        //////////////////
        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
                $data=array(
                    'error'=>"Case have been Registered Already. Please Check"
                );
                echo json_encode($data);
                exit;
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
        $this->db->trans_begin();
        $aadharNo = null;
        $panNo = null;
        $photo = null;
        if($data['firstParty'][0]->is_applicant == '1'){
            $file=null;
            if($data['firstParty'][0]->auth_type == 'AADHAAR'){
                $aadharNo = $data['firstParty'][0]->id_ref_no;
                $uploadpath   = AADHAAR_UPLOAD_DIR;
                $imagebase64  = $output->photo;
                $file         = $uploadpath . $data['firstParty'][0]->id_ref_no . '.json';
                file_put_contents($file, $imagebase64);
                $photo = $file;
            }else if($data['firstParty'][0]->auth_type == 'PAN'){
                $panNo = $data['firstParty'][0]->id_ref_no;
                $photo = null;
            }
        }
        $UpdateWhere=array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'patta_no'=>$data['pattaNo']->patta_no,
			'patta_type_code'=>$data['pattaNo']->patta_type_code,
            'pdar_id'=>$data['firstParty'][0]->chitha_pdar_id,

        );
        $updateMobile= array(
            'pdar_mobile' => $data['firstParty'][0]->new_mobile,
            'pdar_aadharno' => $aadharNo,
            'pdar_pan_no' => $panNo,
            'pdar_photo' => $photo
        );

        /// update chitha_pattadar
        // $this->db->update('chitha_pattadar', $updateMobile, $UpdateWhere);
        $result = $this->Chitha_basic_model->update_table('chitha_pattadar', $updateMobile, $UpdateWhere);
        if($result <= 0){
            $this->db->trans_rollback();
            log_message('error', '#ERRMCOR001: Updation failed in chitha_pattadar for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRMCOR001: Mobile number updation failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }

        /// update jama_pattadar
        $this->db->update('jama_pattadar', $updateMobile, $UpdateWhere);
        log_message('error',$this->db->last_query());
        if($this->db->affected_rows() <= 0){
            $this->db->trans_rollback();
            log_message('error', '#ERRMCOR002: Updation failed in jama_pattadar for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRMCOR002: Mobile number updation failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }

        /// insert in basundhar_application
        $basundhara=array(
            'dharitree'=>"DHAR/".$application_no,
            'basundhara'=>$application_no,
            'date_reg'=>date('Y-m-d'),
            'reg_by'=>$this->session->userdata('user_code'),
            'app_status'=>'F',
            'pending_with'=>'NA'
        );
        //////////UUID Insert/////////////
        $basundhara['uuid']=$this->utilityclass->getVillageUUID($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code);
        ///////////////////////
        $insBasuMCOR = $this->db->insert('basundhar_application',$basundhara);
        if($insBasuMCOR != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRMCOR003: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRMCOR003: Mobile number updation failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }


        if($this->db->trans_status()==FALSE){
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"Error in submitting. Please try Again"
                );
                return $data;
                exit;
        }
        else
        {            
            
            //////////////POST To rtps/////////////////////
            $rmk='Forwarded to CO';
            $status='F';
            $task='CO';
            $pen='NA';
            $case="DHAR/".$application_no;
            $result=$this->rtpsmodel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
            if($result==true){
                $this->db->trans_commit();
            }else{
                $data=array(
                    'error'=>"Error in submitting. Please try Again"
                );
                echo json_encode($data);
                return;
            }
            //////////////////
            $this->session->set_flashdata('message',"Records Updated Successfully ");
            //////////////////////////////////
            $data=array(
                'success'=>"Records Updated Successfully",
                'redirect_url'=>base_url().'index.php/home'
            );
        }
        echo json_encode($data);
    }
    /////////////////////////////////////
    // function RejectOrder(){
    //         $order=$_POST['order'];
    //         $application_no=$_POST['application_no'];
    //         $curl_handle = curl_init();
    //         curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."applicationStatusUpdate");
    //         curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
    //         curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
    //         curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
    //         curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
    //             'application' => $application_no,
    //             'dharitree' => 'NA',
    //             'rmk' => $order,
    //             'status' => 'R',
    //             'task' => $this->session->userdata('user_desig_code'),
    //             'pen'=>'NA'
    //         )));
    //         $result = curl_exec($curl_handle);
    //         $this->db->trans_commit();
    //         $this->session->set_flashdata('message',"Application Rejected by Mondal $application_no ");
    //         redirect('/home');
    // }
    /////////////////////////
    function queryRequest(){
            $order=$_POST['query'];
            $application_no=$_POST['application_no'];
            $d=$this->session->userdata('dist_code');
            $s=$this->session->userdata('subdiv_code');
            $c=$this->session->userdata('cir_code');
            $m=$this->session->userdata('mouza_pargona_code');
            $l=$this->session->userdata('lot_no');
            $code=$this->session->userdata('user_code');
            $desigcode=$this->session->userdata('user_desig_code');

            $errorMessageStr = '';
            $resp = checkRequestSpecChar($_POST);
            if($resp['status'] == 'n'){
                $errorMessageStr .= $resp['messages'];
            }

            $resp = checkRequestValidQuery($_POST);
            if($resp['status'] == 'n'){
                $errorMessageStr .= $resp['messages'];
            }

            if($errorMessageStr != ''){
                $this->session->set_flashdata('query_mdl_message', $errorMessageStr);
                return redirect($_SERVER['HTTP_REFERER']);
            }

            if($order == ''){
                $this->session->set_flashdata('query_mdl_message', 'Query Field is required');
                return redirect($_SERVER['HTTP_REFERER']);
            }

            if($desigcode=='LM'){
                $lm=$this->utilityclass->getDefinedMondalsName($d,$s,$c,$m,$l,$code);
                $user_nm=$lm->lm_name;
            }else{
                $lm=$this->utilityclass->getSelectedASOName($d,$s,$c,$code);
                $user_nm=$lm->username;
            }
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."queryInsert");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application' => $application_no,
                'query' =>  $order,
                'type' => '0',
                'query_from_officer'=>$desigcode,
                'query_from_office'=>'Circle Office'
            )));
            $result = curl_exec($curl_handle);          
            if($result=='true'  || $result==true){                
                $array=array(
                    'basundhara'=> $application_no,
                    'date_reg'=> date('Y-m-d'),
                    'reg_by'=> $desigcode,
                    'app_status'=> 'Q',
                    'pending_with'=>$this->session->userdata('user_desig_code')
                );
                //$this->db->insert('basundhar_application',$array);
                $this->session->set_flashdata('message',"Your Query has been sent to the user against application no $application_no ");
                redirect('/home');
            }else{
                $this->session->set_flashdata('message',"Failed !! A query might already been raised to the applicant against application no $application_no ");
                redirect('/home');
            }        
    }
    ////////////////Added by Pallabi/////////////////////
    function reclassBasu(){
        //$application_no = 'MB/RECLASS/2021/308';//'MB/MUTI/2021/24';//$this->input->get('applid');
        $application_no = trim($_GET['app']);
        $applicationNoValidate = applicationNumberValidation($application_no);
        if(count($applicationNoValidate)){
            show_error('error', $applicationNoValidate['message']);
            return;
            // $this->session->set_flashdata('message', $applicationNoValidate['message']);
            // redirect(base_url('index.php/home'));
        }

        $url = RTPS_API_LINK."serviceResponse?application_no=" . $application_no;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); // setting 10 seconds 
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); // setting 30 seconds
        $output = curl_exec($ch);
        curl_close($ch);

        if(trim($output) == ''){
            show_error('Page not found', 401, '401 Page Not Found');
            return;
        }
        $output = json_decode($output);
        //var_dump($output->application);
        $data['appNo']=$application_no;
        $district['app']=$output->application;
        $district['selfDecData'] = null;
        $district['aadhaarData'] = null;
        $district['aadhaarPhoto'] = null;
        $aadharData = null;
        if(isset($output->selfDeclaration) && !empty($output->selfDeclaration)){
            $district['selfDecData'] = json_decode($output->selfDeclaration[0]->dec_details);
        }
        foreach ($output->applicants as $key => $value) {
            if($value->auth_type !=null || $value->auth_type!=' '){
                $aadharData = $value;
            }
            continue;
        }
        if(isset($aadharData) && !empty($aadharData)){
            $district['aadhaarData'] = $aadharData;
        }
        if(isset($output->photo) && $output->photo != null){
            $district['aadhaarPhoto'] = $output->photo;
        }
        $district['pattaNo']=$this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$district['app']->dag_no);

        $user_code=$this->session->userdata('user_code');

        $district['lm'] = $this->utilityclass->getDefinedMondalsName($district['app']->dist_code,$district['app']->subdiv_code, $district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$user_code );
        //var_dump($district['lm']);
        //var_dump($district['pattaNo']);
        $district['firstParty']=$output->mutation;
        $district['secParty']=$output->applicants;
        $district['document']=$output->documents;
        $district['query']=$output->query;

        ///////////////////////////////////////////// property chain code //////////////////////////////////////////
        if(ENABLED_BLOCKCHAIN == 1 && in_array($district['app']->dist_code,json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {

            $this->load->model('propChain/PropChainModel');
            // checking if chitha data and property chain data mathches
            $checkPropAndChitha =  $this->PropChainModel->chainChithaUlpinCheckProcess($district['app']->dist_code,  $district['app']->subdiv_code, $district['app']->cir_code, $district['app']->mouza_code, $district['app']->lot_no, $district['app']->village_code, $district['pattaNo']->patta_no, $district['app']->dag_no, $district['pattaNo']->dag_area_b, $district['pattaNo']->dag_area_k, $district['pattaNo']->dag_area_lc, $district['pattaNo']->dag_area_g, $district['pattaNo']->patta_type_code);

            // var_dump($pattadars);
            $district['chithaPropChainCmpFlag'] = $checkPropAndChitha['chithaPropChainCmpFlag'];
            $district['compareFlagMsg'] = $checkPropAndChitha['compareFlagMsg'];
            $district['ulpinCheck'] = $checkPropAndChitha['ulpinCheck'];
            // hidden fields
            $district['ulpin_hidden'] = $checkPropAndChitha['ulpin_hidden'];
            $district['uplpin_msg_hidden'] = $checkPropAndChitha['uplpin_msg_hidden'];
            $district['compare_hidden'] = $checkPropAndChitha['compare_hidden'];
            $district['compare_msg_hidden'] = $checkPropAndChitha['compare_msg_hidden'];

            // bhunaksha area cmp
            $district['bhuChithaCmpStatus'] = $checkPropAndChitha['bhuChithaCmpStatus'];
            $district['bhuChithaCmpMsg'] = $checkPropAndChitha['bhuChithaCmpMsg'];
            $district['bhu_hidden'] = $checkPropAndChitha['bhu_hidden'];
            $district['bhu_compare_msg_hidden'] = $checkPropAndChitha['bhu_compare_msg_hidden'];
        }
        
        if($this->session->userdata('user_desig_code')=='ADC' or $this->session->userdata('user_desig_code')=='CO'){
            $district['_view'] = 'rtps/reclass_basu_inherit';
        }else{
            $district['_view'] = 'rtps/reclass_basu';
        }
        $this->load->view('layouts/main',$district);
    }
    function reclassPost(){
        $d_cd = $this->session->userdata('dist_code');
        $s_cd = $this->session->userdata('subdiv_code');
        $c_cd = $this->session->userdata('cir_code');
        $mouza_prg_cd = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $user_code = $this->session->userdata('user_code');

        if(!in_array($user_desig_code, ['LM'])){
            $data = [
                'error' => 'You are not authorized to perform this action'
            ];
            echo json_encode($data);
            exit;
        }
        $data=array(
            'error'=>"#ERR5482: Access Denied"
        );
        echo json_encode($data);
        exit;

        $P_land_rev = $this->input->post('P_land_rev');
        $co_report = $this->input->post('co_report');

        // Input Basic Validation Start
            $this->form_validation->set_rules('P_land_rev', 'Proposed land revenue', 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[1000000000]');
            $this->form_validation->set_rules('co_report', 'Report', 'required|max_length[1000]');

            if ($this->form_validation->run() == FALSE)
            {
                $json = array(
                    'P_land_rev' => form_error('P_land_rev'),
                    'co_report' => form_error('co_report'),
                );

                $data = [
                            'success' => false,
                            'errors' => $json
                        ];

                // echo json_encode($data);
                return $this->output
                        ->set_status_header('403')
                        ->set_content_type('application/json')
                        ->set_output(json_encode($data));        
            }
            
        // Input Basic Validation End

        $response = specialCharacterCheckingInInput($co_report, ['.', ',', '|', '-',':','।','\'','/'], 'Report');
        if($response['status'] == 'n'){
            $data = [
                        'success' => false,
                        'errors' => [
                            'co_report' => $response['message']
                        ]
                    ];

            return $this->output
                    ->set_status_header('403')
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));
        }

        $response = isValidQuery($co_report);
        if($response['status'] == 'n'){
            $data = [
                        'success' => false,
                        'errors' => [
                            'co_report' => 'MALECIOUS QUERY'
                        ]
                    ];

            return $this->output
                    ->set_status_header('403')
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));
        }

        $application_no = trim($_POST['application_no']);
        $applicationNoValidate = applicationNumberValidation($application_no);
        if(count($applicationNoValidate)){
            $data=array(
                'error'=> $applicationNoValidate['message']
            );
            echo json_encode($data);
            exit;
        }

        $response = isValidQuery($application_no);
        if($response['status'] == 'n'){
            $data = [
                        'success' => false,
                        'errors' => [
                            'application_no' => 'MALECIOUS QUERY'
                        ]
                    ];

            return $this->output
                    ->set_status_header('403')
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));
        }

        //////////////////
        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
            $data=array(
                'error'=>"Case have been Registered Already. Please Check"
            );
            echo json_encode($data);
            exit;
        }
        /////////////////////
        $url = RTPS_API_LINK."serviceResponse?application_no=" . $application_no ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); // setting 10 seconds 
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); // setting 30 seconds
        $output = curl_exec($ch);
        curl_close($ch);

        if(trim($output) == ''){
            $data=array(
                'error'=> "Application not found."
            );
            echo json_encode($data);
            exit;
        }
        
        $output = json_decode($output);

        $data['app']=$output->application;
        if($data['app']->dist_code != $d_cd || $data['app']->subdiv_code != $s_cd || $data['app']->cir_code != $c_cd || $data['app']->mouza_code != $mouza_prg_cd || $data['app']->lot_no != $lot_no){
            $data=array(
                'error'=> "You are not authorized to perform this action."
            );
            echo json_encode($data);
            exit;
        }

        $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$data['app']->dag_no);
        $data['lm'] = $this->utilityclass->getDefinedMondalsName($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no, $user_code );
        $p_local_tax = $P_land_rev/4;
        $p_local_tax = round($p_local_tax, 4);
        // echo $user_code;
        // echo "<pre>";
        // print_r($data['lm']);
        // exit;

        $data['firstParty']=$output->mutation;
        $data['secParty']=$output->applicants;
        
        $file = null;
        if(isset($data['secParty'][0]->chitha_pdar_id) && $data['secParty'][0]->chitha_pdar_id != null){
            $pdar_id = $data['secParty'][0]->chitha_pdar_id;
        }else{
            $pdar_id = null;
        }
        $chitha_pdar_id = null;
        if($data['secParty'][0]->is_applicant == '1'){
            if(!empty($output->selfDeclaration[0]->dec_details)){
                $dec = $output->selfDeclaration[0]->dec_details;
            }else{
                $dec = null;
            }
            $auth_type = $data['secParty'][0]->auth_type;
            $id_ref_no = $data['secParty'][0]->id_ref_no;
            if($data['secParty'][0]->auth_type=='AADHAAR'){
                $uploadpath   = AADHAAR_UPLOAD_DIR;
                $imagebase64  = $output->photo;
                $file         = $uploadpath . $data['secParty'][0]->id_ref_no . '.json';
                file_put_contents($file, $imagebase64);
                $chitha_pdar_id = $pdar_id;
            }else if($data['secParty'][0]->auth_type=='PAN'){
                $chitha_pdar_id = $pdar_id;
            }
            $photo = $file;
        }else{
            $dec= null;
            $auth_type = null;
            $id_ref_no = null;
            $photo = null;
        }
        $year_no = year_no;
        $co_report1 = $this->input->POST('co_report');
        if(in_array($d_cd, json_decode(BARAK_VALLEY))){
            $co_report_suffix = $data['lm']->lm_name . ", ভূমিলেখ্য সহায়ক, ";
        }else{
            $co_report_suffix = $data['lm']->lm_name . ", ভূমিলেখ্য সহায়ক, ";
        }

        $co_report = $co_report1." - ".$co_report_suffix;
        //var_dump($data);
        $dist_code = $data['app']->dist_code;
        if(in_array($dist_code, json_decode(BARAK_VALLEY))){
            $dag_area_g = $data['app']->area_g==null?"0":$data['app']->area_g;
            $dag_area_kr = $data['app']->area_kr==null?"0":$data['app']->area_kr;
        }
        else{
            $dag_area_g = 0;
            $dag_area_kr = 0;
        }
        $this->db->trans_begin();
       // $case_no=$this->rtpsmodel->genearteCaseNo('04');
        $case_name=$this->rtpsmodel->genearteCaseName();
         if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Session time out. Please try Again"
            );
            echo json_encode($data);
            exit;
            die();
        }
        // $case_no['petition_no']=$petition_no=$this->rtpsmodel->genearteReclassPetitionNo();
        // $case_no['case_no']=$case_name.$petition_no."/RECLASS";

        $seq_pet=year_no.'0';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteReclassPetitionNo();
        $case_no['case_no']=$case_name.$petition_no."/RECLASS";

        $basic = array(
            'dist_code' => $data['app']->dist_code,
            'subdiv_code' => $data['app']->subdiv_code,
            'cir_code' => $data['app']->cir_code,
            'mouza_pargona_code' => $data['app']->mouza_code,
            'lot_no' => $data['app']->lot_no,
            'vill_townprt_code' => $data['app']->village_code,
            'proposal_no' => $case_no['petition_no'],
            'dag_no' => $data['app']->dag_no,
            'patta_no' => $data['pattaNo']->patta_no,
            'patta_type_code' => $data['pattaNo']->patta_type_code,
            'present_land_class' => $data['firstParty'][0]->old_classification,
            'present_land_revenue' => $data['pattaNo']->dag_revenue,
            'present_land_localtax' =>$data['pattaNo']->dag_local_tax,
            'present_total_revenue' => $data['pattaNo']->sum,
            'new_landuse_year' => $data['firstParty'][0]->year_of_use,
            'dag_area_b' => $data['app']->area_b,
            'dag_area_k' => $data['app']->area_k,
            'dag_area_lc' => $data['app']->area_l,
            'dag_area_g' => $dag_area_g,
            'dag_area_kr' => $dag_area_kr,
            'proposed_land_class' => $data['firstParty'][0]->new_classification,
            'proposed_land_revenue' => $P_land_rev,
            'proposed_land_localtax' => $p_local_tax,
            'revenue_diff' => $this->input->post('Rev_diff'),
            'lm_code' => $user_code,
            'lm_yn' => 'Y',
            'lm_date' => date('Y-m-d G:i:s'),
            'case_no' => $case_no['case_no'],
            'year_no' => $year_no,
            'self_declaration' => $dec,
            'auth_type' => $auth_type,
            'id_ref_no'=> $id_ref_no,
            'photo'=> $photo,
            'pdar_id' => $chitha_pdar_id

        );

        $insTReclass = $this->db->insert('t_reclassification',$basic);
        if($insTReclass != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRRECLASS001: Insertion failed in t_reclassification for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRRECLASS001: Registration of Reclassification failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }
       
        $basundhara=array(
            'dharitree'=>$case_no['case_no'],
            'basundhara'=>$application_no,
            'date_reg'=>date('Y-m-d'),
            'reg_by'=> $user_code,
            'app_status'=>'P',
            'pending_with'=>'CO'
        );
        //////////UUID Insert/////////////
        $basundhara['uuid']=$this->utilityclass->getVillageUUID($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code);
        ///////////////////////
        $insBasuRECLASS = $this->db->insert('basundhar_application',$basundhara);
        if($insBasuRECLASS != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRRECLASS002: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRRECLASS002: Registration of Reclassification failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }


         ///////////////For Proceeding///////////////////
      
        // $co = $this->utilityclass->getDefinedMondalsName($data['app']->dist_code,$data['app']->subdiv_code, $data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no, $this->session->userdata('user_code'));
        
        // $data['location'] = array(
        //     'dist' => $dist_code,
        //     'sub' => $subdiv_code,
        //     'cir' => $cir_code,
        //     'mouza' => $mouza_pargona_code,
        //     'lot' => $lot_no,
        //     'vill' => $vill_townprt_code,
        //     'co_name' => $co->username
        // ); 

        $proID=$this->rtpsmodel->maxProceedingID($case_no['case_no']);
        $pro_array=array(
            'dist_code' => $data['app']->dist_code,
            'subdiv_code' => $data['app']->subdiv_code,
            'cir_code' => $data['app']->cir_code,
            'case_no'=>$case_no['case_no'],
            'proceeding_id'=>$proID,
            'status'=>'pending',
            'date_of_hearing'=>date('Y-m-d'),
            'co_order'=>$co_report,
            'user_code'=> $user_code,
            'date_entry'=>date('Y-m-d G:i:s'),
            'operation'=>'E',
            'ip' => $this->utilityclass->get_client_ip()
            );
        $insProceedRECLASS = $this->db->insert('petition_proceeding_dc_adc',$pro_array);
        if($insProceedRECLASS != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRRECLASS003: Insertion failed in petition_proceeding_dc_adc for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRRECLASS003: Registration of Reclassification failed for case no : ".$application_no
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
            //////////////POST To rtps/////////////////////
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."applicationStatusUpdate");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application' => $application_no,
                'dharitree' => $case_no['case_no'],
                'rmk' => 'Registered Successfully',
                'status' => 'M',
                'task' => 'LM',
                'pen'=>'CO',
                'penat'=>'Circle office'
            )));
            $result = curl_exec($curl_handle);
            
            $this->DashboardReclass($case_no['case_no']);
            if($result != true){
                $this->db->trans_rollback();
                log_message('error', '#ERRRECLASS004: Data not inserted in '. RTPS_API_LINK. ' applicationStatusUpdate for RTPS Case No '.$application_no);
                $data=array(
                    'error'=> "#ERRRECLASS004: Server error! Unable to forward the case to Circle Officer"
                );
            }else{

                $this->db->trans_commit();
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

    function areaCorrectionbasu(){

        $application_no = $_GET['app'];
        $url = RTPS_API_LINK."serviceResponse?application_no=" . $application_no ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        //var_dump($output->application);
        $data['appNo']=$application_no;
        $district['app']=$output->application;
        $district['selfDecData'] = null;
        $district['aadhaarData'] = null;
        $district['aadhaarPhoto'] = null;
        $aadharData = null;
        if(isset($output->selfDeclaration) && !empty($output->selfDeclaration)){
            $district['selfDecData'] = json_decode($output->selfDeclaration[0]->dec_details);
        }
        foreach ($output->mutation as $key => $value) {
            if($value->auth_type !=null || $value->auth_type!=' '){
                $aadharData = $value;
            }
            continue;
        }
        if(isset($aadharData) && !empty($aadharData)){
            $district['aadhaarData'] = $aadharData;
        }
        if(isset($output->photo) && $output->photo != null){
            $district['aadhaarPhoto'] = $output->photo;
        }
        $district['pattaNo']=$this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$district['app']->dag_no);
        //var_dump($district['pattaNo']);
        $district['firstParty']=$output->mutation;
        $district['secParty']=$output->applicants;
        $district['document']=$output->documents;

        $district['query']=$output->query;
        $district['query']=$output->query;


        $params = [
          'case_no'          => $application_no,
          'service_code'     => 7,
          'remarks'          => 'Area Correction',
          'accessed_entity'  => 'Aadhaar Name, DOB, Photo',
        ];
        $this->load->model('EkycLogModel');
        $log = $this->EkycLogModel->insertEkycAccessedBy($this->db, $params);


        if($this->session->userdata('user_desig_code')=='ADC' or $this->session->userdata('user_desig_code')=='CO'){
            $district['_view'] = 'rtps/areacorrection_inherit';
        }else{
            $district['_view'] = 'rtps/areacorrection';
        }
        $this->load->view('layouts/main',$district);
    }

    function areacorrectPost(){
        // XSS Validation START
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST,array(),array(),array('remark' => true));
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }

        $resp = checkRequestValidQuery($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }

        if($errorMessageStr != ''){
            $data = [
                'success' => false,
                'errors' => $errorMessageStr
            ];

            return response_json($data, '403');
            // return $this->output
            //         ->set_status_header('403')
            //         ->set_content_type('application/json')
            //         ->set_output(json_encode($data));
        }
        // XSS Validation END
        
        $user_desig_code = $this->session->userdata('user_desig_code');
        $user_code = $this->session->userdata('user_code');
        // BASIC Authorization START
        if(!in_array($user_desig_code, ['LM'])){
            $data = [
                'success' => false,
                'errors' => 'You are not authorized to perform this action.'
            ];

            return response_json($data, '403');
            // return $this->output
            //         ->set_status_header('403')
            //         ->set_content_type('application/json')
            //         ->set_output(json_encode($data));
        }
        // BASIC Authorization END

        $application_no=$_POST['application_no'];
        $patta_type = $this->input->post('patta_type');
        $patta_no = $this->input->post('patta_no');
        $dag_revenue = $this->input->post('dag_revenue');
        $dag_local_tax = $this->input->post('dag_local_tax');
        $land_class_code = $this->input->post('land_class_code');
        $remark = $this->input->post('remark');
        $P_land_rev = $this->input->post('P_land_rev');

        $p_local_tax = $P_land_rev/4;
        $p_local_tax = round($p_local_tax, 4);
        //////////////////
        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
                $data=array(
                    'error'=>"Case have been Registered Already. Please Check"
                );
                echo json_encode($data);
                exit;
        }
        /////////////////////
        $url = RTPS_API_LINK."serviceResponse?application_no=" . $application_no ;
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        // $output = curl_exec($ch);
        // curl_close($ch);
        $output = sendCurlRequest($url);
        $output = json_decode($output);
        $data['app']=$output->application;
        $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$data['app']->dag_no);
        
        $data['firstParty']=$output->mutation;

        $data['secParty']=$output->applicants;
        //var_dump($data);
        //#START PLB--->
        $dist_code = $data['app']->dist_code;
        if(in_array($dist_code, json_decode(BARAK_VALLEY))){
            $dag_area_g = $data['app']->area_g==null?"0":$data['app']->area_g;
            $dag_area_kr = $data['app']->area_kr==null?"0":$data['app']->area_kr;
        }
        else{
            $dag_area_g = 0;
            $dag_area_kr = 0;
        }

        $this->db->trans_begin();
        //$case_no=$this->rtpsmodel->genearteCaseNo('07');

        $case_name=$this->rtpsmodel->genearteCaseName();
         if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Session Out. Please try Again"
            );
            echo json_encode($data);
            exit;
            die();
        }
        // $case_no['petition_no']=$petition_no=$this->rtpsmodel->genearteLegacyPetitionNo();

        // $case_no['case_no']=$case_name.$petition_no."/LDU";

        $seq_pet=year_no.'00';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteLegacyPetitionNo();
        $case_no['case_no']=$case_name.$petition_no."/LDU";

        $file = null;
        if($data['firstParty'][0]->is_applicant == '1'){
            if(!empty($output->selfDeclaration[0]->dec_details)){
                $dec = $output->selfDeclaration[0]->dec_details;
            }else{
                $dec = null;
            }
            $auth_type = $data['firstParty'][0]->auth_type;
            $id_ref_no = $data['firstParty'][0]->id_ref_no;
            if($data['firstParty'][0]->auth_type=='AADHAAR'){
                $uploadpath   = AADHAAR_UPLOAD_DIR;
                $imagebase64  = $output->photo;
                $file         = $uploadpath . $data['firstParty'][0]->id_ref_no . '.json';
                file_put_contents($file, $imagebase64);
            }
            $photo = $file;
        }else{
            $dec= null;
            $auth_type = null;
            $id_ref_no = null;
            $photo = null;
        }
        $basic = array(
            'dist_code' => $data['app']->dist_code,
            'subdiv_code' => $data['app']->subdiv_code,
            'cir_code' => $data['app']->cir_code,
            'mouza_pargona_code' => $data['app']->mouza_code,
            'lot_no' => $data['app']->lot_no,
            'vill_townprt_code' => $data['app']->village_code,
            'proposal_no' => $case_no['petition_no'],
            'dag_no' => $data['app']->dag_no,
            'patta_no' => $patta_no ,
            'patta_type_code' => $patta_type,
            'present_land_class' => $land_class_code,
            'present_land_revenue' => $dag_revenue == null ? "0" : $dag_revenue,
            'present_land_localtax' => $dag_local_tax == null ? "0" : $dag_local_tax,
            'dag_area_b' => $data['app']->area_b,
            'dag_area_k' => $data['app']->area_k,
            'dag_area_lc' => $data['app']->area_l,
            'dag_area_g' => $dag_area_g,
            'dag_area_kr' =>$dag_area_kr,
            'suggested_dag_no' => '',
            'suggested_patta_no' => '',
            'suggested_patta_type' => '',
            'suggested_land_class' =>'',
            'suggested_land_rev' => $P_land_rev,
            'suggested_loc_tax' => $p_local_tax,
            'suggested_dag_area_b' => $data['firstParty'][0]->new_area_b,
            'suggested_dag_area_k' => $data['firstParty'][0]->new_area_k,
            'suggested_dag_area_lc' => $data['firstParty'][0]->new_area_l,
            'suggested_dag_area_g' => $data['firstParty'][0]->new_area_g==null?"0":$data['firstParty'][0]->new_area_g,
            'suggested_dag_area_kr' => $data['firstParty'][0]->new_area_kr==null?"0":$data['firstParty'][0]->new_area_kr,
            'lm_note' => $remark,
            'lm_code' => $user_code,
            'lm_date' => date('Y-m-d G:i:s'),
            'case_no' => $case_no['case_no'],
            'year_no' => date('Y'),
            'file_upload' => '',
            'status' => 'P',
            'rmk_line_no' => 'N/A',
            'suggested_pattadarstrike' => null,
            'p_flag' => '',
            'pdar_id'=> $data['firstParty'][0]->chitha_pdar_id,
            'self_declaration' => $dec,
            'auth_type' => $auth_type,
            'id_ref_no'=> $id_ref_no,
            'photo'=> $photo

        );

        $insTlegACOR = $this->db->insert('t_legacyupdation',$basic);
        if($insTlegACOR != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRACOR001: Insertion failed in t_legacyupdation for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRACOR001: Registration of Area Correction failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }

       
        $basundhara=array(
            'dharitree'=>$case_no['case_no'],
            'basundhara'=>$application_no,
            'date_reg'=>date('Y-m-d'),
            'reg_by'=> $user_code,
            'app_status'=>'P',
            'pending_with'=>'CO'
        );
        //////////UUID Insert/////////////
        $basundhara['uuid']=$this->utilityclass->getVillageUUID($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code);
        ///////////////////////
        $insBasuACOR = $this->db->insert('basundhar_application', $basundhara);
        if($insBasuACOR != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRACOR002: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRACOR002: Registration of Area Correction failed for case no : ".$application_no
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
        }else
        {
            
            //////////////POST To rtps/////////////////////
            $rtps_api_link = RTPS_API_LINK."applicationStatusUpdate";
            $rtps_api_param = [
                                'application' => $application_no,
                                'dharitree' => $case_no['case_no'],
                                'rmk' => 'Registered Successfully',
                                'status' => 'M',
                                'task' => 'LM',
                                'pen'=>'CO',
                                'penat'=>'Circle office'
                            ];
            $result = sendCurlRequest($rtps_api_link, 'POST', $rtps_api_param);
            // $curl_handle = curl_init();
            // curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."applicationStatusUpdate");
            // curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            // curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            // curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            // curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            //     'application' => $application_no,
            //     'dharitree' => $case_no['case_no'],
            //     'rmk' => 'Registered Successfully',
            //     'status' => 'M',
            //     'task' => 'LM',
            //     'pen'=>'CO',
            //     'penat'=>'Circle office'
            // )));
            // $result = curl_exec($curl_handle);
            if($result==true){
                $this->db->trans_commit();
            }else{
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"Error in submitting. Please try Again"
                );
                echo json_encode($data);
                return;
            }

            $condition = ['case_no' => $case_no['case_no']];
            $updated_tLegacyupdation = $this->legacyModel->get_row($condition);
            $change_request_string = $this->legacyModel->get_change_request_string($updated_tLegacyupdation);

            $log_data = [
                            'case_no' => $case_no['case_no'],
                            'proceeding_id' => $this->PetitionProceedingModel->getAutoIncrementalProceedingNo($case_no['case_no']),
                            'date_of_hearing' => date('Y-m-d H:i:s'),
                            'date_entry' => date('Y-m-d H:i:s'),
                            'co_order' => $remark . ' | '. $this->UserModel->get_user_identification(),
                            'additional_notes' => 'পৰিবৰ্তনৰ বাবে আবেদন: ' . $change_request_string . $this->UserModel->get_user_identification(),
                            'operation' => 'E',
                            'dist_code' => $data['app']->dist_code,
                            'subdiv_code' => $data['app']->subdiv_code,
                            'cir_code' => $data['app']->cir_code,
                            'status' => 'Final',
                            'user_code' => $user_code,
                            'ip' => $this->utilityclass->get_client_ip(),
                        ];

            $log_response = $this->PetitionProceedingModel->store_legacy_logs($log_data);

            if($log_response['success']){
                $this->db->trans_commit();

                $data=array(
                    'success' => "Application Forwarded to Circle Officer Successfully with case no $case_no[case_no]",
                    'redirect_url' => base_url().'index.php/home'
                );
            }else{
                $this->db->trans_rollback();

                $data=array(
                    'error'=> $log_response['message']
                );
                echo json_encode($data);
                return;
                
            }
            //////////////////////////////////
        }
        echo json_encode($data);
    }

    function nameCorrectionbasu(){

        if(!isset($_GET['app']) || $_GET['app']==''){
             //ERRRTPSNMECORRAST0000
             log_message('error', 'The query parameter is required. Error: ERRRTPSNMECORRAST0000');
            $this->session->set_flashdata('message', "The query parameter is required");
            redirect(base_url('index.php/rtps/request/6'));
        }
        $validApp = applicationNumberValidation($_GET['app']);
        if(!empty($validApp)) {
             //ERRRTPSNMECORRAST0001
             log_message('error', 'The query parameter contain special characters. Error: ERRRTPSNMECORRAST0001');
            $this->session->set_flashdata('message', "The query parameter contain special characters");
            redirect(base_url('index.php/rtps/request/6'));
        }

        $application_no = $_GET['app'];
        // $this->load->helper('custom_helper');
        $url = RTPS_API_LINK."serviceResponse?application_no=" . $application_no ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        $output = curl_exec($ch);
        curl_close($ch);
        if(trim($output)=="") {
            //ERRRTPSNMECORRAST0002
            log_message('error', 'API Error. Error: ERRRTPSNMECORRAST0002');
            $this->session->set_flashdata('message', "API Error");
            redirect(base_url('index.php/rtps/request/6'));
            die();
        }
        $output = json_decode($output);

        //var_dump($output->application);
        $data['appNo']=$application_no;
        $district['app']=$output->application;
        $district['firstPartyNew'] = $output->applicants;
        $district['selfDecData'] = null;
        $district['aadhaarData'] = null;
        $district['aadhaarPhoto'] = null;
        $aadharData = null;
        if(isset($output->selfDeclaration) && !empty($output->selfDeclaration)){
            $district['selfDecData'] = json_decode($output->selfDeclaration[0]->dec_details);
        }
        foreach ($output->applicants as $key => $value) {
            if($value->auth_type !=null){
                $aadharData = $value;
            }
            continue;
        }
        if(isset($aadharData) && !empty($aadharData)){
            $district['aadhaarData'] = $aadharData;
        }
        if(isset($output->photo) && $output->photo != null){
            $district['aadhaarPhoto'] = $output->photo;
        }
        $district['pattaNo']=$this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$district['app']->dag_no);
        // echo '<pre>';
        // var_dump($district['pattaNo']);
        // die();
        $district['firstParty']=$output->mutation;
        $district['secParty']=$output->applicants;
        $district['document']=$output->documents;
        $district['query']=$output->query;
        // $district['query']=$output->query;
        $district['user']=$this->rtpsmodel->usersForOffice($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code);
        if(($district['app']->dist_code!=$this->session->userdata('dist_code')) || ($district['app']->subdiv_code!=$this->session->userdata('subdiv_code')) || ($district['app']->cir_code!=$this->session->userdata('cir_code')) )
        {
            redirect('/home');
        }
        if($this->session->userdata('user_desig_code')=='ADC' or $this->session->userdata('user_desig_code')=='CO'){
            $district['_view'] = 'rtps/namecorrection_revert';
        }else{
            $district['_view'] = 'rtps/namecorrection';
        }

        ///////////////////////////////////////////// property chain code //////////////////////////////////////////
        if(ENABLED_BLOCKCHAIN == 1 && in_array($district['app']->dist_code,json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
            
            $this->load->model('propChain/PropChainModel');
            // checking if chitha data and property chain data mathches
            $checkPropAndChitha =  $this->PropChainModel->chainChithaUlpinCheckProcess($district['app']->dist_code,  $district['app']->subdiv_code, $district['app']->cir_code, $district['app']->mouza_code, $district['app']->lot_no, $district['app']->village_code, $district['pattaNo']->patta_no, $district['app']->dag_no, $district['pattaNo']->dag_area_b, $district['pattaNo']->dag_area_k, $district['pattaNo']->dag_area_lc, $district['pattaNo']->dag_area_g, $district['pattaNo']->patta_type_code);

            // var_dump($pattadars);
            $district['chithaPropChainCmpFlag'] = $checkPropAndChitha['chithaPropChainCmpFlag'];
            $district['compareFlagMsg'] = $checkPropAndChitha['compareFlagMsg'];
            $district['ulpinCheck'] = $checkPropAndChitha['ulpinCheck'];
            // hidden fields
            $district['ulpin_hidden'] = $checkPropAndChitha['ulpin_hidden'];
            $district['uplpin_msg_hidden'] = $checkPropAndChitha['uplpin_msg_hidden'];
            $district['compare_hidden'] = $checkPropAndChitha['compare_hidden'];
            $district['compare_msg_hidden'] = $checkPropAndChitha['compare_msg_hidden'];

            // bhunaksha area cmp
            $district['bhuChithaCmpStatus'] = $checkPropAndChitha['bhuChithaCmpStatus'];
            $district['bhuChithaCmpMsg'] = $checkPropAndChitha['bhuChithaCmpMsg'];
            $district['bhu_hidden'] = $checkPropAndChitha['bhu_hidden'];
            $district['bhu_compare_msg_hidden'] = $checkPropAndChitha['bhu_compare_msg_hidden'];
        }
        ////////////////END//////////////////////////////////
        
        $this->load->view('layouts/main',$district);
    }

    private function checkApiAuth($url, $ref_no) {
        $url = RTPS_API_LINK. $url . $ref_no ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        $output = curl_exec($ch);
        curl_close($ch);
        $jsonOut = json_decode($output);

        if(trim($output)=="" || empty($output) || $output==null) {
            return false;
        }
        else{
            return json_decode($output);
        }
        
    }

    function namecorrectPost(){
        
        //check for Malicious
        $validquery = checkRequestValidQuery($_POST);
        if($validquery['status']=='n') {
            //ERRRTPSNMECORRAST0017
            log_message('error', $validquery['messages'] .'Error: ERRRTPSNMECORRAST0017');
            $response = array(
                'responseType'=>1,
                'msg'=>'Post Parameters contain malicious characters.',
                'errorCode'=>'ERRRTPSNMECORRAST0017',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/rtps/request/6')
                )
            );
            echo json_encode($response);
            exit;
        }
        //syntax validation
        $validArr = applicationNumberValidation($_POST['application_no']);
        if(!empty($validArr)) {
            //ERRRTPSNMECORRAST0003
            log_message('error', 'Application No. Format is not valid. Error: ERRRTPSNMECORRAST0003');
            $response = array(
                'responseType'=>1,
                'msg'=>'Application No. Format is not valid',
                'errorCode'=>'ERRRTPSNMECORRAST0003',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/rtps/request/6')
                )
            );
            echo json_encode($response);
            exit;
        }
        if(!isset($_POST['application_no']) || $_POST['application_no']=='' || !isset($_POST['official']) || $_POST['official']=='') {
            //ERRRTPSNMECORRAST0004
            log_message('error', 'The required fields are empty. Error: ERRRTPSNMECORRAST0004');
            $response = array(
                'responseType'=>1,
                'msg'=>'The required fields are empty.',
                'errorCode'=>'ERRRTPSNMECORRAST0004',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/rtps/request/6')
                )
            );
            echo json_encode($response);
            exit;
        }
        //authorization
        $response = $this->AuthorizationModel->isAuthorized(101, 'AST', $_POST['application_no']);
        if($response['status']=='n') {
            //ERRRTPSNMECORRAST0005
            log_message('error', $response['messages'] .' Error: ERRRTPSNMECORRAST0005');
            $res = array(
                'responseType'=>1,
                'msg'=>$response['messages'],
                'errorCode'=>'ERRRTPSNMECORRAST0005',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/rtps/request/6')
                )
            );
            echo json_encode($res);
            exit;
        }

        //authentication
        // if(!$this->session->userdata('user_code')){
        //     //ERRRTPSNMECORRAST0005
        //     log_message('error', 'The user is not authenticated. Error: ERRRTPSNMECORRAST0005');
            // $response = array(
            //     'responseType'=>1,
            //     'msg'=>'The user is not authenticated.',
            //     'errorCode'=>'ERRRTPSNMECORRAST0005',
            //     'data'=>array(
            //         'application_no'=>$_POST['application_no'],
            //         'redirectUrl'=>base_url('index.php/rtps/nameCorrectionbasu?app='. $_POST['application_no'])
            //     )
            // );
            // echo json_encode($response);
            // exit;
        // }
        //authorization
        $apiAuth = $this->checkApiAuth("serviceResponse?application_no=", $_POST['application_no']);
        $api_dist_code = $apiAuth->application->dist_code;
        $api_subdiv_code = $apiAuth->application->subdiv_code;
        $api_cir_code = $apiAuth->application->cir_code;
        $api_mouza_code = $apiAuth->application->mouza_code;
        $api_lot_no = $apiAuth->application->lot_no;
        $api_village_code = $apiAuth->application->village_code;
        // $sessionData = $this->session->all_userdata();
        // if($api_dist_code!=$sessionData['dist_code'] || $api_subdiv_code!=$sessionData['subdiv_code'] || $api_cir_code!=$sessionData['cir_code']){
        //     //ERRRTPSNMECORRAST0006
        //     log_message('error', 'User not authorized. Error: ERRRTPSNMECORRAST0006');
        //     $response = array(
        //         'responseType'=>1,
        //         'msg'=>'User not authorized.',
        //         'errorCode'=>'ERRRTPSNMECORRAST0006',
        //         'data'=>array(
        //             'application_no'=>$_POST['application_no'],
        //             'redirectUrl'=>base_url('index.php/rtps/request/6')
        //         )
        //     );
        //     echo json_encode($response);
        //     exit;
        // }
        //COselect authorization
        $result = $this->rtpsmodel->nameCorrCoValidation($api_dist_code, $api_subdiv_code, $api_cir_code, $_POST['official']);
        if(empty($result)) {
            //ERRRTPSNMECORRAST0007
            log_message('error', 'The selected CO is not authorized. Error: ERRRTPSNMECORRAST0007');
            $response = array(
                'responseType'=>1,
                'msg'=>'The selected CO is not authorized.',
                'errorCode'=>'ERRRTPSNMECORRAST0007',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/rtps/nameCorrectionbasu?app='. $_POST['application_no'])
                )
            );
            echo json_encode($response);
            exit;
        }
        
        $application_no=$_POST['application_no'];
        //////////////////
        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
            //ERRRTPSNMECORRAST0008
            log_message('error', 'Case have been Registered Already. Please Check. Error: ERRRTPSNMECORRAST0008');
            $response = array(
                'responseType'=>1,
                'msg'=>'Case have been Registered Already. Please Check',
                'errorCode'=>'ERRRTPSNMECORRAST0008',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/rtps/request/6')
                )
            );
            echo json_encode($response);
            exit;
            // $data=array(
            //     'error'=>"Case have been Registered Already. Please Check"
            // );
            // echo json_encode($data);
            // return;
            // exit;
        }
        /////////////////////
        $url = RTPS_API_LINK."serviceResponse?application_no=" . $application_no ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);


        $data['app']=$output->application;

        //////////////checking before escalation//////////////
        $escStartDate = '2024-09-18';
        $escRegDate = date('Y-m-d',strtotime($data['app']->date_submission));
        if($escRegDate > $escStartDate)
        {
            log_message('error', 'Application No. in after escalation. Error: ERRESCNCOR6530');
            $response = array(
                'responseType'=>1,
                'msg'=>'#ERRAUTOREG : Case could not be registered',
                'errorCode'=>'ERRESCNCOR6530',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/rtps/request/6')
                )
            );
            echo json_encode($response);
            return;
            exit;
        }
        ///////////////END////////////////////////////////////

        $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$data['app']->dag_no);
        
        $data['firstParty']=$output->mutation;
        $data['secParty']=$output->applicants;

        //var_dump($data['secParty']);
        //var_dump($data);
        $this->db->trans_begin();
        //$case_no=$this->rtpsmodel->genearteCaseNo('06');
        if(($data['app']->dist_code!=$this->session->userdata('dist_code')) || ($data['app']->subdiv_code!=$this->session->userdata('subdiv_code')) || ($data['app']->cir_code!=$this->session->userdata('cir_code')) )
        {
            $this->db->trans_rollback();
            //ERRRTPSNMECORRAST0009
            log_message('error', 'Please reload the page. Session might be Destroyed. Error: ERRRTPSNMECORRAST0009');
            $response = array(
                'responseType'=>1,
                'msg'=>'Please reload the page. Session might be Destroyed.',
                'errorCode'=>'ERRRTPSNMECORRAST0009',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>''
                )
            );
            echo json_encode($response);
            exit;
            // $data=array(
            //     'error'=>"Please reload the page. Session might be Destroyed."
            // );
            // echo json_encode($data);
            // return false;
            // exit;
        }
        $case_name=$this->rtpsmodel->genearteCaseName();
        if(empty($case_name)){
            $this->db->trans_rollback();
            //ERRRTPSNMECORRAST0010
            log_message('error', 'Network Issue or Session Out. Please try Again. Error: ERRRTPSNMECORRAST0010');
            $response = array(
                'responseType'=>1,
                'msg'=>'Network Issue or Session Out. Please try Again',
                'errorCode'=>'ERRRTPSNMECORRAST0010',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>''
                )
            );
            echo json_encode($response);
            exit;
            // $data=array(
            //     'error'=>"Network Issue or Session Out. Please try Again"
            // );
            // echo json_encode($data);
            // return;
            // exit;
            // die();
        }
        // $case_no['petition_no']=$petition_no=$this->rtpsmodel->genearteMiscPetitionNo();
        // $case_no['case_no']=$case_name.$petition_no."/MiNC";

        $seq_pet=year_no.'00';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteMiscPetitionNo();
        $case_no['case_no']=$case_name.$petition_no."/MiNC";

        $userdata = array(
            'dist_code' => $data['app']->dist_code,
            'subdiv_code' => $data['app']->subdiv_code,
            'cir_code' => $data['app']->cir_code,
            'mouza_pargona_code' => $data['app']->mouza_code,
            'lot_no' => $data['app']->lot_no,
            'vill_townprt_code' => $data['app']->village_code,
            'year_no' => date('Y'),
            'misc_case_petition_no' => $case_no['petition_no'],
            'misc_case_no' => $case_no['case_no'],
            'misc_case_type' => '06',
            'patta_no' => $data['pattaNo']->patta_no,
            'patta_type_code' => $data['pattaNo']->patta_type_code,
            'submission_date' => date('Y-m-d G:i:s'),
            'supported_doc_yn' => 'Y',
            'supported_doc_code' => date('Y-m-d G:i:s'),
            'fresh_yn' => 'Y',
            'status' => 01,
            'operation' => 's',
            'proceeding_yn' => 'Y',
            'user_code' => $this->session->userdata('user_code'),
            'date_of_operation' => date('Y-m-d G:i:s'),
            'add_to_officer' => $this->input->post('official'),
            'dag_no' => $data['app']->dag_no
        );
                //var_dump($userdata);
        //$this->session->set_userdata($userdata);
        $insBasicMINC = $this->db->insert("misc_case_basic", $userdata);
        if($insBasicMINC != 1)
        {
            $this->db->trans_rollback();
            //ERRRTPSNMECORRAST0011
            log_message('error', 'Registration/Insertion of Name Correction failed for case no : '. $_POST['application_no'] .'. Error: ERRRTPSNMECORRAST0011');
            $response = array(
                'responseType'=>1,
                'msg'=>'Registration/Insertion of Name Correction failed for case no : '. $_POST['application_no'],
                'errorCode'=>'ERRRTPSNMECORRAST0011',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>''
                )
            );
            echo json_encode($response);
            exit;

            // log_message('error', '#ERRMINC001: Insertion failed in misc_case_basic for RTPS Case No '.$application_no);
            // $data = array(
            //     'error'=>"#ERRMINC001: Registration of Name Correction failed for case no : ".$application_no
            // );
            // echo json_encode($data);
            // return false;
        }
        $file = null;
        if($data['secParty'][0]->is_applicant == '1'){
            if(!empty($output->selfDeclaration[0]->dec_details)){
                $dec = $output->selfDeclaration[0]->dec_details;
            }else{
                $dec = null;
            }
            $auth_type = $data['secParty'][0]->auth_type;
            $id_ref_no = $data['secParty'][0]->id_ref_no;
            if($data['secParty'][0]->auth_type=='AADHAAR'){
                $uploadpath   = AADHAAR_UPLOAD_DIR;
                $imagebase64  = $output->photo;
                $file         = $uploadpath . $data['secParty'][0]->id_ref_no . '.json';
                file_put_contents($file, $imagebase64);
            }
            $photo = $file;
        }else{
            $dec= null;
            $auth_type = null;
            $id_ref_no = null;
            $photo = null;
        }
        $basic = array(
            'dist_code' => $data['app']->dist_code,
            'subdiv_code' => $data['app']->subdiv_code,
            'cir_code' => $data['app']->cir_code,
            'petition_pdar_id' =>  $data['secParty'][0]->chitha_pdar_id,
            'misc_case_no' => $case_no['case_no'],
            'petition_pdar_name_old' => $data['secParty'][0]->name_ass,
            'petition_pdar_name_new' => $data['firstParty'][0]->pat_name_ass,
            'submission_date' => date('Y-m-d G:i:s'),
            'user_code' => $this->session->userdata('user_code'),
            'operation' => 'E',
            'misc_case_petition_no' => $case_no['petition_no'],
            'self_declaration' => $dec,
            'auth_type' => $auth_type,
            'id_ref_no'=> $id_ref_no,
            'photo'=> $photo

        );
        $insFirstPartyMINC = $this->db->insert("misc_case_first_party", $basic);
        if($insFirstPartyMINC != 1)
        {
            $this->db->trans_rollback();
            //ERRRTPSNMECORRAST0012
            log_message('error', 'Registration of Name Correction failed for case no : '. $_POST['application_no'] .'. Error: ERRRTPSNMECORRAST0012');
            $response = array(
                'responseType'=>1,
                'msg'=>'Registration of Name Correction failed for case no : '. $_POST['application_no'],
                'errorCode'=>'ERRRTPSNMECORRAST0012',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>''
                )
            );
            echo json_encode($response);
            exit;

            // log_message('error', '#ERRMINC002: Insertion failed in misc_case_first_party for RTPS Case No '.$application_no);
            // $data = array(
            //     'error'=>"#ERRMINC002: Registration of Name Correction failed for case no : ".$application_no
            // );
            // echo json_encode($data);
            // return false;
        }
       
        $basundhara=array(
            'dharitree'=>$case_no['case_no'],
            'basundhara'=>$application_no,
            'date_reg'=>date('Y-m-d'),
            'reg_by'=>$this->session->userdata('user_code'),
            'app_status'=>'P',
            'pending_with'=>'CO'
        );
        //////////UUID Insert/////////////
        $basundhara['uuid']=$this->utilityclass->getVillageUUID($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code);
        ///////////////////////
        $insBasuMINC = $this->db->insert('basundhar_application',$basundhara);
        if($insBasuMINC != 1)
        {
            $this->db->trans_rollback();
            //ERRRTPSNMECORRAST0013
            log_message('error', 'Registration of Name Correction failed for case no : '. $_POST['application_no'] .'. Error: ERRRTPSNMECORRAST0013');
            $response = array(
                'responseType'=>1,
                'msg'=>'Registration of Name Correction failed for case no : '. $_POST['application_no'],
                'errorCode'=>'ERRRTPSNMECORRAST0013',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>''
                )
            );
            echo json_encode($response);
            exit;

            // log_message('error', '#ERRMINC003: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
            // $data = array(
            //     'error'=>"#ERRMINC003: Registration of Name Correction failed for case no : ".$application_no
            // );
            // echo json_encode($data);
            // return false;
        }

        $remark='Registered by Assistant';

        $proInsert = $this->mutationmodel->proceeding_order($case_no['case_no'],$remark);

        if($proInsert==false || $proInsert===false)
        {
            $this->db->trans_rollback();
            //ERRRTPSNMECORRAST0014
            log_message('error', 'Updation failed(ERRRTPSNMECORRAST0014) '. $_POST['application_no'] .'. Error: ERRRTPSNMECORRAST0014');
            $response = array(
                'responseType'=>1,
                'msg'=>'Updation failed(ERRRTPSNMECORRAST0014) '. $_POST['application_no'],
                'errorCode'=>'ERRRTPSNMECORRAST0014',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/home')
                )
            );
            echo json_encode($response);
            exit;
            
            // log_message('error', "#MISCAST001:".$this->db->last_query());
            // $this->db->trans_rollback();
            // $this->session->set_flashdata('message', "Updation failed(#MISCAST001)". $application_no);
            // redirect(base_url() . "index.php/home");
        }
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            //ERRRTPSNMECORRAST0015
            log_message('error', 'Error in submitting. Please try Again. Error: ERRRTPSNMECORRAST0015');
            $response = array(
                'responseType'=>1,
                'msg'=>'Error in submitting. Please try Again ',
                'errorCode'=>'ERRRTPSNMECORRAST0015',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>''
                )
            );
            echo json_encode($response);
            exit;


            // $data=array(
            //     'error'=>"Error in submitting. Please try Again"
            // );
            // echo json_encode($data);
            // return;
        }
        else
        {
            $this->db->trans_commit();
            //////////////POST To rtps/////////////////////
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."applicationStatusUpdate");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application' => $application_no,
                'dharitree' => $case_no['case_no'],
                'rmk' => 'Registered Successfully',
                'status' => 'M',
                'task' => 'AST',
                'pen'=>'CO',
                'penat'=>'Circle office'
            )));
            $result = curl_exec($curl_handle);
            if($result===true || $result=='true' || $result==1 || json_decode($result)=='true'|| json_decode($result)==true || json_decode($result)=='y' || $result=='y'){
                $this->db->trans_commit();
            }else{
                //ERRRTPSNMECORRAST0016
                log_message('error', 'Error in submitting. Please try Again. Error: ERRRTPSNMECORRAST0016');
                $response = array(
                    'responseType'=>1,
                    'msg'=>'Error in submitting. Please try Again ',
                    'errorCode'=>'ERRRTPSNMECORRAST0016',
                    'data'=>array(
                        'application_no'=>$_POST['application_no'],
                        'redirectUrl'=>''
                    )
                );
                echo json_encode($response);
                exit;

                // $data=array(
                //     'error'=>"Error in submitting. Please try Again"
                // );
                // echo json_encode($data);
                // return;
            }
            $this->DashboardNameCorrect($case_no['case_no']);
            $this->session->set_flashdata('message',"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no] ");
            //////////////////////////////////
            //success
            $response = array(
                'responseType'=>2,
                'msg'=>'Application Forwarded to Circle Officer Successfully with case no '. $case_no['case_no'],
                'errorCode'=>'',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/home')
                )
            );
            echo json_encode($response);
            exit;

            // $data=array(
            //     'success'=>"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no]",
            //     'redirect_url'=>base_url().'index.php/home'
            // );
        }
    }
    function nameCancelbasu(){
        if(!isset($_GET['app']) || $_GET['app']==''){
            //ERRRTPSNMECANCAST0000
            log_message('error', 'The query parameter is required. Error: ERRRTPSNMECANCAST0000');
            $this->session->set_flashdata('message', "The query parameter is required");
            redirect(base_url('index.php/rtps/request/8'));
        }
        $validApp = applicationNumberValidation($_GET['app']);
        if(!empty($validApp)) {
            //ERRRTPSNMECANCAST0001
            log_message('error', 'The query parameter contain special characters. Error: ERRRTPSNMECANCAST0001');
            $this->session->set_flashdata('message', "The query parameter contain special characters");
            redirect(base_url('index.php/rtps/request/8'));
        }
        $application_no = $_GET['app'];
        $url = RTPS_API_LINK."serviceResponse?application_no=" . $application_no ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        $output = curl_exec($ch);
        curl_close($ch);
        if(trim($output)=="") {
            //ERRRTPSNMECANCAST0002
            log_message('error', 'API Error. Error: ERRRTPSNMECANCAST0002');
            $this->session->set_flashdata('message', "API Error");
            redirect(base_url('index.php/rtps/request/8'));
            die();
        }
        $output = json_decode($output);
        //var_dump($output->application);
        $data['appNo']=$application_no;
        $district['app']=$output->application;
        $district['selfDecData'] = null;
        $district['aadhaarData'] = null;
        $district['aadhaarPhoto'] = null;
        $aadharData = null;
        if(isset($output->selfDeclaration) && !empty($output->selfDeclaration)){
            $district['selfDecData'] = json_decode($output->selfDeclaration[0]->dec_details);
        }
        foreach ($output->mutation as $key => $value) {
            if($value->auth_type !=null){
                $aadharData = $value;
            }
            continue;
        }
        if(isset($aadharData) && !empty($aadharData)){
            $district['aadhaarData'] = $aadharData;
        }
        if(isset($output->photo) && $output->photo != null){
            $district['aadhaarPhoto'] = $output->photo;
        }
        $district['pattaNo']=$this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$district['app']->dag_no);
        //var_dump($district['pattaNo']);
        $district['firstParty']=$output->mutation;
        $district['secParty']=$output->applicants;
        $district['document']=$output->documents;
        $district['query']=$output->query;
        // $district['query']=$output->query;
        
        $district['user']=$this->rtpsmodel->usersForOffice($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code);
        $this->form_validation->set_rules('official', 'Select Officer Name', 'required');
        if(($district['app']->dist_code!=$this->session->userdata('dist_code')) || ($district['app']->subdiv_code!=$this->session->userdata('subdiv_code')) || ($district['app']->cir_code!=$this->session->userdata('cir_code')) )
        {
            redirect('/home');
        }
        if($this->session->userdata('user_desig_code')=='ADC' or $this->session->userdata('user_desig_code')=='CO'){
            $district['_view'] = 'rtps/namecancel_revert';
        }else{
            $district['_view'] = 'rtps/namecancel';
        }

        ///////////////////////////////////////////// property chain code //////////////////////////////////////////
        if(ENABLED_BLOCKCHAIN == 1 && in_array($district['app']->dist_code,json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
            
            $this->load->model('propChain/PropChainModel');
            // checking if chitha data and property chain data mathches
            $checkPropAndChitha =  $this->PropChainModel->chainChithaUlpinCheckProcess($district['app']->dist_code,  $district['app']->subdiv_code, $district['app']->cir_code, $district['app']->mouza_code, $district['app']->lot_no, $district['app']->village_code, $district['pattaNo']->patta_no, $district['app']->dag_no, $district['pattaNo']->dag_area_b, $district['pattaNo']->dag_area_k, $district['pattaNo']->dag_area_lc, $district['pattaNo']->dag_area_g, $district['pattaNo']->patta_type_code);

            // var_dump($pattadars);
            $district['chithaPropChainCmpFlag'] = $checkPropAndChitha['chithaPropChainCmpFlag'];
            $district['compareFlagMsg'] = $checkPropAndChitha['compareFlagMsg'];
            $district['ulpinCheck'] = $checkPropAndChitha['ulpinCheck'];
            // hidden fields
            $district['ulpin_hidden'] = $checkPropAndChitha['ulpin_hidden'];
            $district['uplpin_msg_hidden'] = $checkPropAndChitha['uplpin_msg_hidden'];
            $district['compare_hidden'] = $checkPropAndChitha['compare_hidden'];
            $district['compare_msg_hidden'] = $checkPropAndChitha['compare_msg_hidden'];

            // bhunaksha area cmp
            $district['bhuChithaCmpStatus'] = $checkPropAndChitha['bhuChithaCmpStatus'];
            $district['bhuChithaCmpMsg'] = $checkPropAndChitha['bhuChithaCmpMsg'];
            $district['bhu_hidden'] = $checkPropAndChitha['bhu_hidden'];
            $district['bhu_compare_msg_hidden'] = $checkPropAndChitha['bhu_compare_msg_hidden'];
        }
        ////////////////END//////////////////////////////////
        
        $this->load->view('layouts/main',$district);
    }

    function namecancelPost(){
        //check for Malicious
        $validquery = checkRequestValidQuery($_POST);
        if($validquery['status']=='n') {
            //ERRRTPSNMECANCAST0022
            log_message('error', $validquery['messages'] .'Error: ERRRTPSNMECANCAST0022');
            $response = array(
                'responseType'=>1,
                'msg'=>'Post parameters contain malicious characters.',
                'errorCode'=>'ERRRTPSNMECANCAST0022',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/rtps/request/8')
                )
            );
            echo json_encode($response);
            exit;
        }
        if(!isset($_POST['application_no']) || $_POST['application_no']=='') {
            //ERRRTPSNMECANCAST0003
            log_message('error', 'Application No. is a required Parameter. Error: ERRRTPSNMECANCAST0003');
            $response = array(
                'responseType'=>1,
                'msg'=>'Application No. is a required Parameter',
                'errorCode'=>'ERRRTPSNMECANCAST0003',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/rtps/request/8')
                )
            );
            echo json_encode($response);
            exit;
        }
        if(!isset($_POST['official']) || !isset($_POST['remark']) || $_POST['official']=='' || $_POST['remark']=='') {
            //ERRRTPSNMECANCAST0004
            log_message('error', 'Required Parameters are empty. Error: ERRRTPSNMECANCAST0004');
            $response = array(
                'responseType'=>1,
                'msg'=>'Required Parameters are empty',
                'errorCode'=>'ERRRTPSNMECANCAST0004',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/rtps/nameCancelbasu?app='. $_POST['application_no'])
                )
            );
            echo json_encode($response);
            exit;
        }
        //syntax validation
        $validApp = applicationNumberValidation($_POST['application_no']);
        if(!empty($validApp)) {
            //ERRRTPSNMECANCAST0005
            log_message('error', 'Application No. contain illegal characters. Error: ERRRTPSNMECANCAST0005');
            $response = array(
                'responseType'=>1,
                'msg'=>'Application No. contain illegal characters',
                'errorCode'=>'ERRRTPSNMECANCAST0005',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/rtps/request/8')
                )
            );
            echo json_encode($response);
            exit;
        }
        $pattern = '/&[a-z]{3,5};/i';
        $validRemark = specialCharacterCheckingInInput(preg_replace($pattern, '', preg_replace('/\s+/', ' ', strip_tags($_POST['remark'], ['script']))), ['.', ',', '|', '-',':','।','\'','/', '(', ')' ,"’", '০', 'ত্‍', 'ৎ']);
        if($validRemark['status']=='n') {
            //ERRRTPSNMECANCAST0006
            log_message('error', 'Input parameters contain illegal characters. Error: ERRRTPSNMECANCAST0006');
            $response = array(
                'responseType'=>1,
                'msg'=>'Input parameters contain illegal characters',
                'errorCode'=>'ERRRTPSNMECANCAST0006',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/rtps/nameCancelbasu?app='. $_POST['application_no'])
                )
            );
            echo json_encode($response);
            exit;
        }

        $validOfficial =  specialCharacterCheckingInInput($_POST['official'], ['.']);
        if($validOfficial['status']=='n') {
            //ERRRTPSNMECANCAST0007
            log_message('error', 'Input parameters contain illegal characters. Error: ERRRTPSNMECANCAST0007');
            $response = array(
                'responseType'=>1,
                'msg'=>'Input parameters contain illegal characters',
                'errorCode'=>'ERRRTPSNMECANCAST0007',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/rtps/nameCancelbasu?app='. $_POST['application_no'])
                )
            );
            echo json_encode($response);
            exit;
        }
        //authorization
        $response = $this->AuthorizationModel->isAuthorized(101, 'AST', $_POST['application_no']);
        if($response['status']=='n') {
            //ERRRTPSNMECANCAST0008
            log_message('error', $response['messages'] .' Error: ERRRTPSNMECANCAST0008');
            $res = array(
                'responseType'=>1,
                'msg'=>$response['messages'],
                'errorCode'=>'ERRRTPSNMECANCAST0008',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/home')
                )
            );
            echo json_encode($res);
            exit;
        }
        //authentication
        // $sessionData = $this->session->all_userdata();
        // if(empty($sessionData) || !$this->session->userdata('user_code')) {
        //     //ERRRTPSNMECANCAST0008
        //     log_message('error', 'User not authenticated. Error: ERRRTPSNMECANCAST0008');
        //     $response = array(
        //         'responseType'=>1,
        //         'msg'=>'User not authenticated',
        //         'errorCode'=>'ERRRTPSNMECANCAST0008',
        //         'data'=>array(
        //             'application_no'=>$_POST['application_no'],
        //             'redirectUrl'=>base_url('index.php/home')
        //         )
        //     );
        //     echo json_encode($response);
        //     exit;
        // }

        //authorization
        $apiAuth = $this->checkApiAuth("serviceResponse?application_no=", $_POST['application_no']);
        $api_dist_code = $apiAuth->application->dist_code;
        $api_subdiv_code = $apiAuth->application->subdiv_code;
        $api_cir_code = $apiAuth->application->cir_code;
        // if($api_dist_code!=$sessionData['dist_code'] || $api_subdiv_code!=$sessionData['subdiv_code'] || $api_cir_code!=$sessionData['cir_code']){
        //     //ERRRTPSNMECANCAST0009
        //     log_message('error', 'User not authorized. Error: ERRRTPSNMECANCAST0009');
        //     $response = array(
        //         'responseType'=>1,
        //         'msg'=>'User not authorized',
        //         'errorCode'=>'ERRRTPSNMECANCAST0009',
        //         'data'=>array(
        //             'application_no'=>$_POST['application_no'],
        //             'redirectUrl'=>base_url('index.php/home')
        //         )
        //     );
        //     echo json_encode($response);
        //     exit;
        // }

        //COselect authorization
        $result = $this->rtpsmodel->nameCorrCoValidation($api_dist_code, $api_subdiv_code, $api_cir_code, $_POST['official']);
        if(empty($result) || $result['user_desig_code']!='CO') {
            //ERRRTPSNMECANCAST0010
            log_message('error', 'COSelected not authorized. Error: ERRRTPSNMECANCAST0010');
            $response = array(
                'responseType'=>1,
                'msg'=>'COSelected not authorized',
                'errorCode'=>'ERRRTPSNMECANCAST0010',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/rtps/nameCancelbasu?app='. $_POST['application_no'])
                )
            );
            echo json_encode($response);
            exit;
        }
        
        $application_no=$_POST['application_no'];
        //////////////////
        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
            //ERRRTPSNMECANCAST0011
            log_message('error', 'Case have been Registered Already. Please Check. Error: ERRRTPSNMECANCAST0011');
            $response = array(
                'responseType'=>1,
                'msg'=>'Case have been Registered Already. Please Check',
                'errorCode'=>'ERRRTPSNMECANCAST0011',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/rtps/nameCancelbasu?app='. $_POST['application_no'])
                )
            );
            echo json_encode($response);
            exit;
                // $data=array(
                //     'error'=>"Case have been Registered Already. Please Check"
                // );
                // echo json_encode($data);
                // exit;
        }
        /////////////////////
        $url = RTPS_API_LINK."serviceResponse?application_no=" . $application_no ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        $data['app']=$output->application;
        $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$data['app']->dag_no);
        
        $data['firstParty']=$output->mutation;
        $data['secParty']=$output->applicants;

        $district['query']=$output->query;
        $district['query']=$output->query;

        //var_dump($data['secParty']);
        //var_dump($data);
        if(($data['app']->dist_code!=$this->session->userdata('dist_code')) || ($data['app']->subdiv_code!=$this->session->userdata('subdiv_code')) || ($data['app']->cir_code!=$this->session->userdata('cir_code')) )
        {
            //ERRRTPSNMECANCAST0012
            log_message('error', 'Please reload the page. Session might be Destroyed. Error: ERRRTPSNMECANCAST0012');
            $response = array(
                'responseType'=>1,
                'msg'=>'Please reload the page. Session might be Destroyed.',
                'errorCode'=>'ERRRTPSNMECANCAST0012',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/rtps/nameCancelbasu?app='. $_POST['application_no'])
                )
            );
            echo json_encode($response);
            exit;
            // $data=array(
            //     'error'=>"Please reload the page. Session might be Destroyed."
            // );
            // echo json_encode($data);
            // return false;
            // exit;
        }
        $this->db->trans_begin();
        //$case_no=$this->rtpsmodel->genearteCaseNo('08');
        
        $case_name=$this->rtpsmodel->genearteCaseName();
         if(empty($case_name)){
            $this->db->trans_rollback();
            //ERRRTPSNMECANCAST0013
            log_message('error', 'Network Issue or Session Out. Please try Again. Error: ERRRTPSNMECANCAST0013');
            $response = array(
                'responseType'=>1,
                'msg'=>'Network Issue or Session Out. Please try Again',
                'errorCode'=>'ERRRTPSNMECANCAST0013',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/rtps/nameCancelbasu?app='. $_POST['application_no'])
                )
            );
            echo json_encode($response);
            exit;
        //     $data=array(
        //         'error'=>"Network Issue or Session Out. Please try Again"
        //     );
        //     echo json_encode($data);
        //     exit;
        //     die();
        }
        // $case_no['petition_no']=$petition_no=$this->rtpsmodel->genearteMiscPetitionNo();
        // $case_no['case_no']=$case_name.$petition_no."/MiND";

        $seq_pet=year_no.'00';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteMiscPetitionNo();
        $case_no['case_no']=$case_name.$petition_no."/MiND";

        $userdata = array(
            'dist_code' => $data['app']->dist_code,
            'subdiv_code' => $data['app']->subdiv_code,
            'cir_code' => $data['app']->cir_code,
            'mouza_pargona_code' => $data['app']->mouza_code,
            'lot_no' => $data['app']->lot_no,
            'vill_townprt_code' => $data['app']->village_code,
            'year_no' => date('Y'),
            'misc_case_petition_no' => $case_no['petition_no'],
            'misc_case_no' => $case_no['case_no'],
            'misc_case_type' => '07',
            'patta_no' => $data['pattaNo']->patta_no,
            'patta_type_code' => $data['pattaNo']->patta_type_code,
            'submission_date' => date('Y-m-d G:i:s'),
            'supported_doc_yn' => 'Y',
            'supported_doc_code' => date('Y-m-d G:i:s'),
            'fresh_yn' => 'Y',
            'status' => '01',
            'operation' => 'E',
            'proceeding_yn' => 'Y',
            'user_code' => $this->session->userdata('user_code'),
            'date_of_operation' => date('Y-m-d G:i:s'),
            'add_to_officer' => $this->input->post('official'),
            'dag_no' => $data['app']->dag_no
        );
                //var_dump($userdata);
        //$this->session->set_userdata($userdata);
        $insBasicNSTR = $this->db->insert("misc_case_basic", $userdata);
        if($insBasicNSTR != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRNSTR001: Insertion failed in misc_case_basic for RTPS Case No '.$application_no);
            //ERRRTPSNMECANCAST0014
            $response = array(
                'responseType'=>1,
                'msg'=>'Registration of Name Cancellation failed for case no : '. $application_no,
                'errorCode'=>'ERRRTPSNMECANCAST0014',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/rtps/nameCancelbasu?app='. $_POST['application_no'])
                )
            );
            echo json_encode($response);
            exit;
            // $data = array(
            //     'error'=>"#ERRNSTR001: Registration of Name Cancellation failed for case no : ".$application_no
            // );
            // echo json_encode($data);
            // return false;
        }
        
        if ( empty($data['firstParty'][0]))
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRNSTR005:  First Party Information missingfor RTPS Case No '.$application_no);
            //ERRRTPSNMECANCAST0015
            $response = array(
                'responseType'=>1,
                'msg'=>'First Party Information missing for case no : '. $application_no,
                'errorCode'=>'ERRRTPSNMECANCAST0015',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/rtps/nameCancelbasu?app='. $_POST['application_no'])
                )
            );
            echo json_encode($response);
            exit;
            // $data = array(
            //     'error'=>"#ERRNSTR005: First Party Information missing for case no : ".$application_no
            // );
            // echo json_encode($data);
            // return false;
        }
        //adding aadhaar information---------
        $file = null;
        if($data['firstParty'][0]->is_applicant == '1'){
            if(!empty($output->selfDeclaration[0]->dec_details)){
                $dec = $output->selfDeclaration[0]->dec_details;
            }else{
                $dec = null;
            }
            $auth_type = $data['firstParty'][0]->auth_type;
            $id_ref_no = $data['firstParty'][0]->id_ref_no;
            if($data['firstParty'][0]->auth_type=='AADHAAR'){
                $uploadpath   = AADHAAR_UPLOAD_DIR;
                $imagebase64  = $output->photo;
                $file         = $uploadpath . $data['firstParty'][0]->id_ref_no . '.json';
                file_put_contents($file, $imagebase64);
            }
            $photo = $file;
        }else{
            $dec= null;
            $auth_type = null;
            $id_ref_no = null;
            $photo = null;
        }
        $basic = array(
            'dist_code' => $data['app']->dist_code,
            'subdiv_code' => $data['app']->subdiv_code,
            'cir_code' => $data['app']->cir_code,
            'petition_pdar_id' =>  $data['firstParty'][0]->chitha_pdar_id,
            'misc_case_no' => $case_no['case_no'],
            'petition_pdar_name_old' => $data['firstParty'][0]->pat_name_ass,
            'submission_date' => date('Y-m-d G:i:s'),
            'user_code' => $this->session->userdata('user_code'),
            'operation' => 'E',
            'misc_case_petition_no' => $case_no['petition_no'],
            'self_declaration' => $dec,
            'auth_type' => $auth_type,
            'id_ref_no'=> $id_ref_no,
            'photo'=> $photo
        );
        $insFirstPartyNSTR = $this->db->insert("misc_case_first_party", $basic);
        if($insFirstPartyNSTR != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRNSTR002: Insertion failed in misc_case_first_party for RTPS Case No '.$application_no);
            //ERRRTPSNMECANCAST0016
            $response = array(
                'responseType'=>1,
                'msg'=>'Registration of Name Cancellation failed for case no : '. $application_no,
                'errorCode'=>'ERRRTPSNMECANCAST0016',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/rtps/nameCancelbasu?app='. $_POST['application_no'])
                )
            );
            echo json_encode($response);
            exit;
            // $data = array(
            //     'error'=>"#ERRNSTR002: Registration of Name Cancellation failed for case no : ".$application_no
            // );
            // echo json_encode($data);
            // return false;
        }
        if (empty($data['secParty']))
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRNSTR006:  Second Party Information missingfor RTPS Case No '.$application_no);
            //ERRRTPSNMECANCAST0017
            $response = array(
                'responseType'=>1,
                'msg'=>'Second Party Information missing for case no : '. $application_no,
                'errorCode'=>'ERRRTPSNMECANCAST0017',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/rtps/nameCancelbasu?app='. $_POST['application_no'])
                )
            );
            echo json_encode($response);
            exit;
            // $data = array(
            //     'error'=>"#ERRNSTR006: Second Party Information missing for case no : ".$application_no
            // );
            // echo json_encode($data);
            // return false;
        }
        foreach($data['secParty'] as $pet){
            $secondparty = array(
                'dist_code' => $data['app']->dist_code,
                'subdiv_code' =>$data['app']->subdiv_code,
                'cir_code' => $data['app']->cir_code,
                'opp_pdar_id' => $pet->chitha_pdar_id,
                'misc_case_no' => $case_no['case_no'],
                'opp_comment' => $this->input->post('remark'),
                'submission_date' => date('Y-m-d G:i:s'),
                'user_code' => $this->session->userdata('user_code'),
                'operation' => 'E'
            );
            // $insSecondPartyNSTR = $this->db->insert("misc_case_scnd_party", $secondparty);
            // if($insSecondPartyNSTR != 1)
            // {
            //     $this->db->trans_rollback();
            //     log_message('error', '#ERRNSTR003: Insertion failed in misc_case_scnd_party for RTPS Case No '.$application_no);
            //     $data = array(
            //         'error'=>"#ERRNSTR003: Registration of Name Cancellation failed for case no : ".$application_no
            //     );
            //     echo json_encode($data);
            //     return false;
            // }

            $check_secondparty= "select * from misc_case_scnd_party where misc_case_no=? and dist_code=? and subdiv_code=? and cir_code=? and opp_pdar_id=? ";
                    $check_secondparty_res = $this->db->query($check_secondparty, array($case_no['case_no'], $data['app']->dist_code,
                        $data['app']->subdiv_code, $data['app']->cir_code,$pet->chitha_pdar_id));

            if($check_secondparty_res->num_rows()==0)
            {
                $insSecondPartyNSTR = $this->db->insert("misc_case_scnd_party", $secondparty);//************
                if ($insSecondPartyNSTR == false) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRNSTR003: Insertion failed in misc_case_scnd_party for RTPS Case No '.$application_no);
                    //ERRRTPSNMECANCAST0018
                    $response = array(
                        'responseType'=>1,
                        'msg'=>'Registration of Name Cancellation failed for case no : '. $application_no,
                        'errorCode'=>'ERRRTPSNMECANCAST0018',
                        'data'=>array(
                            'application_no'=>$_POST['application_no'],
                            'redirectUrl'=>base_url('index.php/rtps/nameCancelbasu?app='. $_POST['application_no'])
                        )
                    );
                    echo json_encode($response);
                    exit;
                    // $data = array(
                    //     'error'=>"#ERRNSTR003: Registration of Name Cancellation failed for case no : ".$application_no
                    // );
                    // echo json_encode($data);
                    // return false;
                }

            } 
            else{
                continue;
            }
        }

       
        $basundhara=array(
            'dharitree'=>$case_no['case_no'],
            'basundhara'=>$application_no,
            'date_reg'=>date('Y-m-d'),
            'reg_by'=>$this->session->userdata('user_code'),
            'app_status'=>'P',
            'pending_with'=>'CO'
        );

        //////////UUID Insert/////////////
        $basundhara['uuid']=$this->utilityclass->getVillageUUID($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code);
        ///////////////////////
        $insBasuNSTR = $this->db->insert('basundhar_application',$basundhara);
        if($insBasuNSTR != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRNSTR004: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
             //ERRRTPSNMECANCAST0019
             $response = array(
                'responseType'=>1,
                'msg'=>'Registration of Name Cancellation failed for case no : '. $application_no,
                'errorCode'=>'ERRRTPSNMECANCAST0019',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/rtps/nameCancelbasu?app='. $_POST['application_no'])
                )
            );
            echo json_encode($response);
            exit;
            // $data = array(
            //     'error'=>"#ERRNSTR004: Registration of Name Cancellation failed for case no : ".$application_no
            // );
            // echo json_encode($data);
            // return false;
        }
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            //ERRRTPSNMECANCAST0020
            log_message('error', 'Error in submitting. Error: ERRRTPSNMECANCAST0020');
            $response = array(
                'responseType'=>1,
                'msg'=>'Error in submitting. Please try Again',
                'errorCode'=>'ERRRTPSNMECANCAST0020',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/rtps/nameCancelbasu?app='. $_POST['application_no'])
                )
            );
            echo json_encode($response);
            exit;
            // $data=array(
            //     'error'=>"Error in submitting. Please try Again"
            // );
            // echo json_encode($data);
            // return;
        }else
        {
            //////////////POST To rtps/////////////////////
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."applicationStatusUpdate");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application' => $application_no,
                'dharitree' => $case_no['case_no'],
                'rmk' => 'Registered Successfully',
                'status' => 'M',
                'task' => 'AST',
                'pen'=>'CO',
                'penat'=>'Circle office'
            )));
            $result = curl_exec($curl_handle);
             if($result===true || $result=='true' || $result==1 || json_decode($result)=='true'|| json_decode($result)==true || json_decode($result)=='y' || $result=='y'){
                $this->db->trans_commit();
            }else{
                $this->db->trans_rollback();
                //ERRRTPSNMECANCAST0021
                log_message('error', 'Error in submitting. Error: ERRRTPSNMECANCAST0021');
                $response = array(
                    'responseType'=>1,
                    'msg'=>'Error in submitting. Please try Again',
                    'errorCode'=>'ERRRTPSNMECANCAST0021',
                    'data'=>array(
                        'application_no'=>$_POST['application_no'],
                        'redirectUrl'=>base_url('index.php/rtps/nameCancelbasu?app='. $_POST['application_no'])
                    )
                );
                echo json_encode($response);
                exit;
                // $data=array(
                //     'error'=>"Error in submitting. Please try Again"
                // );
                // echo json_encode($data);
                // return;
            }
            $this->DashboardNameCancel($case_no['case_no']);
            $this->session->set_flashdata('message',"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no] ");
            //////////////////////////////////
            $response = array(
                'responseType'=>2,
                'msg'=>'Application Forwarded to Circle Officer Successfully with case no '. $case_no['case_no'],
                'errorCode'=>'',
                'data'=>array(
                    'application_no'=>$_POST['application_no'],
                    'redirectUrl'=>base_url('index.php/home')
                )
            );
            // $data=array(
            //     'success'=>"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no]",
            //     'redirect_url'=>base_url().'index.php/home'
            // );
        }
        echo json_encode($response);
    }

    function Apiswitch($rtps){
        if($rtps=='RTPS'){
                $apilink=RTPS_API_LINK;
            }
            else{
                $apilink=API_LINK;
            }
        return $apilink;
    }
    ////////////////////////
    function RejectOrder(){

            $order=$_POST['order'];
            $application_no=$_POST['application_no'];
            $rtps=$this->rtpsmodel->checkRtpsService($application_no);
            $apilink=$this->ApiSwitch($rtps);
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, $apilink."applicationStatusUpdate");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application' => $application_no,
                'dharitree' => 'NA',
                'rmk' => $order,
                'status' => 'R',
                'task' => $this->session->userdata('user_desig_code'),
                'pen'=>'NA'
            )));
            $result = curl_exec($curl_handle);
            $this->db->trans_commit();
            $this->session->set_flashdata('message',"Application Rejected : $application_no ");
            redirect('/home');
    }
    function circlewiseReport(){
       
        $this->load->model('ServicePlus/ServicePlusModel');
        // log_message('error','server2');
        $d=$this->session->userdata('dist_code');
        $s=$this->session->userdata('subdiv_code');
        $c=$this->session->userdata('cir_code');
         $this->session->unset_userdata('searchKeyword');
        $url = RTPS_API_LINK."cicleWiseRegisterCase/$d/$s/$c" ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $output = curl_exec($ch);
        // log_message('error',$output);
        
        curl_close($ch);
        $district['output'] = json_decode($output);
        $district['mutation']=$this->ServicePlusModel->total_mutation_cases();
        $district['partition']=$this->ServicePlusModel->total_partition_cases();
        $district['_view'] = 'rtps/circle_total_reg';
        $this->load->view('layouts/main',$district);
    }

    
    function apicheck(){
        $application_no='MB/MCOR/2021/24567';
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
        //var_dump($data);
    }
    function mobileManual(){
        ini_set('max_execution_time', '0');
        $url = RTPS_API_LINK."mobileCheck" ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        $data['app']=$output;
        foreach($output as $app){
            $data['pattaNo']=$this->utilityclass->getPattaTypeNo($app->dist_code,$app->subdiv_code,$app->cir_code,$app->mouza_code,$app->lot_no,$app->village_code,$app->dag_no);
            $UpdateWhere=array(
                'dist_code'=>$app->dist_code,
                'subdiv_code'=>$app->subdiv_code,
                'cir_code'=>$app->cir_code,
                'mouza_pargona_code'=>$app->mouza_code,
                'lot_no'=>$app->lot_no,
                'vill_townprt_code'=>$app->village_code,
                'patta_no'=>$data['pattaNo']->patta_no,
                'patta_type_code'=>$data['pattaNo']->patta_type_code,
                'pdar_id'=>$app->chitha_pdar_id 
            );
            $updateMobile= array('pdar_mobile' => $app->new_mobile );
            $this->session->set_userdata('dist_code',$app->dist_code);
            $this->dbswitch();
            // $this->db->update('chitha_pattadar', $updateMobile, $UpdateWhere);
            $this->Chitha_basic_model->update_table('chitha_pattadar', $updateMobile, $UpdateWhere);
            $this->db->update('jama_pattadar', $updateMobile, $UpdateWhere);
        } 
    }

    function deedBasuCO(){
        $application_no = $this->input->get('app');//'MB/MUTI/2021/24';//$this->input->get('applid');
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
        $district['secParty']=$output->applicants;
        $district['document']=$output->documents;
        $district['query']=$output->query;
        $district['user']=$this->rtpsmodel->usersForOffice($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code);
        if($this->session->userdata('user_desig_code')=='AST'){
            $district['_view'] = 'rtps/deed_ofc_co';
        }else{
            $district['_view'] = 'rtps/deed_co';
        }
        $this->load->view('layouts/main',$district);
    }


      function inheritanceBasuCO(){
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
        $district['secParty']=$output->applicants;
        $district['document']=$output->documents;
        $district['query']=$output->query;
        $district['query']=$output->query;
        $district['user']=$this->rtpsmodel->usersForOffice($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code);
        if($this->session->userdata('user_desig_code')=='AST'){
            $district['_view'] = 'rtps/inheritance_ofc_co';
        }elseif($this->session->userdata('user_desig_code')=='LM'){
            $district['_view'] = 'rtps/inheritance_co';
        }elseif($this->session->userdata('user_desig_code')=='ADC'){
            if($district['app']->allow_reapply=='Y'){
                $district['_view'] = 'rtps/inheritance_co';
            }else{
                $district['_view'] = 'rtps/inheritance_co_revert';
            }
        }
        else{
            $district['_view'] = 'rtps/inheritance_co';
        }
        $this->load->view('layouts/main',$district);
    }

    function partitionBasuCO(){
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
        $district['app']=$output->application;
        $district['pattaNo']=$this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$district['app']->dag_no);
        //var_dump($district['pattaNo']);
        $district['firstParty']=$output->mutation;
        $district['document']=$output->documents;
        $district['query']=$output->query;
        $district['query']=$output->query;
        $district['user']=$this->rtpsmodel->usersForOffice($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code);
        if($this->session->userdata('user_desig_code')=='AST'){
            $district['_view'] = 'rtps/partition_basu_ofc_co';
        }else{
           $district['_view'] = 'rtps/partition_basu_co';
        }
        $this->load->view('layouts/main',$district);
    }

    function allotmentBasuCO(){
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
        $district['app']=$output->application;
        $district['pattaNo']=$this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$district['app']->dag_no);
        //var_dump($district['pattaNo']);
        $district['firstParty']=$output->mutation;
        $district['document']=$output->documents;
        $district['query']=$output->query;
        $district['_view'] = 'rtps/allotment_basu_co';
        $this->load->view('layouts/main',$district);
    }

    function conversionBasuCO(){
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
        $district['app']=$output->application;
        $district['pattaNo']=$this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$district['app']->dag_no);
        //var_dump($district['pattaNo']);
        $district['firstParty']=$output->mutation;
        $district['document']=$output->documents;
        $district['query']=$output->query;
        $district['user']=$this->rtpsmodel->usersForOffice($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code);
        $district['_view'] = 'rtps/conversion_basu_co';
        $this->load->view('layouts/main',$district);
    }


    function reclassBasuCO(){
        //$application_no = 'MB/RECLASS/2021/308';//'MB/MUTI/2021/24';//$this->input->get('applid');
        $application_no = $_GET['app'];
        $url = RTPS_API_LINK."serviceResponse?application_no=" . $application_no ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        //var_dump($output->application);
        $data['appNo']=$application_no;
        $district['app']=$output->application;
        $district['pattaNo']=$this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$district['app']->dag_no);

        //var_dump($district['pattaNo']);
        $district['firstParty']=$output->mutation;
        $district['secParty']=$output->applicants;
        $district['document']=$output->documents;
        $district['query']=$output->query;
        $district['query']=$output->query;

        $district['_view'] = 'rtps/reclass_basu_co';
        $this->load->view('layouts/main',$district);
    }

     function nameCorrectionbasuCO(){

        $application_no = $_GET['app'];
        $url = RTPS_API_LINK."serviceResponse?application_no=" . $application_no ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        //var_dump($output->application);
        $data['appNo']=$application_no;
        $district['app']=$output->application;
        $district['pattaNo']=$this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$district['app']->dag_no);
        //var_dump($district['pattaNo']);
        $district['firstParty']=$output->mutation;
        $district['secParty']=$output->applicants;
        $district['document']=$output->documents;
        $district['query']=$output->query;
        $district['query']=$output->query;
        $q = $this->db->query("select * from  users where dist_code='".$district['app']->dist_code."' and subdiv_code='".$district['app']->subdiv_code."' and cir_code='".$district['app']->cir_code."' and user_desig_code='CO'");
       
        $c = $q->result();
        //var_dump($c);
        foreach ($c as $x) {
            //echo $x->user_code;
            $users = "Select user_code as user_c from  loginuser_table where user_code='" . $x->user_code . "' and dis_enb_option = 'E' and dist_code='".$district['app']->dist_code."' and subdiv_code='".$district['app']->subdiv_code."' and cir_code='".$district['app']->cir_code."' ";
            $select = $this->db->query($users)->row();

            if (@count($select) == '1') {
                $convertions[] = array(
                    'co_name' => $x->username,
                    'user_desig_code' => $x->user_desig_code,
                    'user_code' => $select->user_c
                );
                $district['user'] = $convertions;
            }
            //array_push($pattadar_d, $data2);
            //$convertion['user'] = $convertions;
        }
        $district['_view'] = 'rtps/namecorrection_co';
        $this->load->view('layouts/main',$district);
    }

    function areaCorrectionbasuCO(){

        $application_no = $_GET['app'];
        $url = RTPS_API_LINK."serviceResponse?application_no=" . $application_no ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        //var_dump($output->application);
        $data['appNo']=$application_no;
        $district['app']=$output->application;

        $district['pattaNo']=$this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$district['app']->dag_no);
        //var_dump($district['pattaNo']);
        $district['firstParty']=$output->mutation;
        $district['secParty']=$output->applicants;
        $district['document']=$output->documents;

        $district['query']=$output->query;
        $district['query']=$output->query;

        $district['_view'] = 'rtps/areacorrection_co';
        $this->load->view('layouts/main',$district);
    }


     function nameCancelbasuCO(){

        $application_no = $_GET['app'];
        $url = RTPS_API_LINK."serviceResponse?application_no=" . $application_no ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        //var_dump($output->application);
        $data['appNo']=$application_no;
        $district['app']=$output->application;


        $district['pattaNo']=$this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$district['app']->dag_no);
        //var_dump($district['pattaNo']);
        $district['firstParty']=$output->mutation;
        $district['secParty']=$output->applicants;
        $district['document']=$output->documents;

        $district['query']=$output->query;
        $district['query']=$output->query;

        $q = $this->db->query("select * from  users where dist_code='".$district['app']->dist_code."' and subdiv_code='".$district['app']->subdiv_code."' and cir_code='".$district['app']->cir_code."' and user_desig_code='CO'");
       
        $c = $q->result();
        //var_dump($c);
        foreach ($c as $x) {
            //echo $x->user_code;
            $users = "Select user_code as user_c from  loginuser_table where user_code='" . $x->user_code . "' and dis_enb_option = 'E' and dist_code='".$district['app']->dist_code."' and subdiv_code='".$district['app']->subdiv_code."' and cir_code='".$district['app']->cir_code."' ";
            $select = $this->db->query($users)->row();

            if (@count($select) == '1') {
                $convertions[] = array(
                    'co_name' => $x->username,
                    'user_desig_code' => $x->user_desig_code,
                    'user_code' => $select->user_c
                );
                $district['user'] = $convertions;
            }
            //array_push($pattadar_d, $data2);
            //$convertion['user'] = $convertions;
        }

         $this->form_validation->set_rules('official', 'Select Officer Name', 'required');

        $district['_view'] = 'rtps/namecancel_co';
        $this->load->view('layouts/main',$district);
    }

     function DashboardInheritance($case_no){
        $this->dbb = $this->load->database('dash', TRUE);
        $sql="Select pb.*,pd.dag_no,pd.patta_no,pd.patta_type_code from petition_basic pb join petition_dag_details pd on pb.dist_code=pd.dist_code and pb.subdiv_code=pd.subdiv_code and pb.cir_code=pd.cir_code and pb.mouza_pargona_code=pd.mouza_pargona_code and pb.lot_no=pd.lot_no and pb.vill_townprt_code=pd.vill_townprt_code and pb.year_no=pd.year_no and pb.petition_no=pd.petition_no 
            where  pb.case_no='$case_no' ";
        $data=$this->db->query($sql)->row_array();
        if($data['mut_type']=='03'){
            $type='OM';
        }elseif ($data['mut_type']=='01'){
             $type='CV';
        }
        elseif ($data['mut_type']=='04'){
             $type='OP';
        }
        $base= array(
              'dist_code'=> $data['dist_code'],
              'subdiv_code' =>$data['subdiv_code'],
              'cir_code'=>$data['cir_code'],
              'mouza_pargona_code'=>$data['mouza_pargona_code'],
              'lot_no'=>$data['lot_no'],
              'vill_townprt_code'=>$data['vill_townprt_code'],
              'case_no'=>$data['case_no'],
              'date_of_reg'=>$data['date_entry'],
              'dag_no'=>$data['dag_no'],
              'patta_type_code' =>$data['patta_type_code'],
              'patta_no' =>$data['patta_no'],
              'status' =>'P',
              'pending_with_user' =>'CO',
              'case_type' =>$type,
            );
        $this->dbb->insert('dashboard_data',$base);


            unset($base['dag_no']);
            unset($base['patta_type_code']);
            unset($base['patta_no']);

        $this->db->insert('dashboard_data',$base);

        
    }

function DashboardPartitionofc($case_no){
        $this->dbb = $this->load->database('dash', TRUE);
        $sql="Select pb.*,pd.dag_no,pd.patta_no,pd.patta_type_code from petition_basic pb join petition_dag_details pd on pb.dist_code=pd.dist_code and pb.subdiv_code=pd.subdiv_code and pb.cir_code=pd.cir_code and pb.mouza_pargona_code=pd.mouza_pargona_code and pb.lot_no=pd.lot_no and pb.vill_townprt_code=pd.vill_townprt_code and pb.year_no=pd.year_no and pb.petition_no=pd.petition_no 
            where  pb.case_no='$case_no' ";
        $data=$this->db->query($sql)->row_array();
        if($data['mut_type']=='04'){
            $type='OP';
        }else{
            
        }
        $base= array(
              'dist_code'=> $data['dist_code'],
              'subdiv_code' =>$data['subdiv_code'],
              'cir_code'=>$data['cir_code'],
              'mouza_pargona_code'=>$data['mouza_pargona_code'],
              'lot_no'=>$data['lot_no'],
              'vill_townprt_code'=>$data['vill_townprt_code'],
              'case_no'=>$data['case_no'],
              'date_of_reg'=>$data['date_entry'],
              'dag_no'=>$data['dag_no'],
              'patta_type_code' =>$data['patta_type_code'],
              'patta_no' =>$data['patta_no'],
              'status' =>'P',
              'pending_with_user' =>'CO',
              'case_type' =>$type,
            );
        $this->dbb->insert('dashboard_data',$base);


            unset($base['dag_no']);
            unset($base['patta_type_code']);
            unset($base['patta_no']);

        $this->db->insert('dashboard_data',$base);


        
    }

    function DashboardPartitionField($case_no){
        $this->dbb = $this->load->database('dash', TRUE);
        $sql="Select * from field_mut_basic fmb left join field_mut_dag_details fmd on fmb.case_no=fmd.case_no where fmb.case_no='$case_no' ";
        $data=$this->db->query($sql)->row_array();
        if($data['mut_type']=='01'){
            $type='FM';
        }else{
            $type='FP';
        }
        $base= array(
              'dist_code'=> $data['dist_code'],
              'subdiv_code' =>$data['subdiv_code'],
              'cir_code'=>$data['cir_code'],
              'mouza_pargona_code'=>$data['mouza_pargona_code'],
              'lot_no'=>$data['lot_no'],
              'vill_townprt_code'=>$data['vill_townprt_code'],
              'case_no'=>$data['case_no'],
              'date_of_reg'=>$data['date_entry'],
              'dag_no'=>$data['dag_no'],
              'patta_type_code' =>$data['patta_type_code'],
              'patta_no' =>$data['patta_no'],
              'status' =>'P',
              'pending_with_user' =>'SK',
              'case_type' =>$type,
            );
        
			unset($base['dag_no']);
            unset($base['patta_type_code']);
            unset($base['patta_no']);
            $this->db->insert('dashboard_data',$base);
            $this->dbb->insert('dashboard_data',$base);
            
    }
    /////////
    function DashboardAllot($case_no){
        $this->dbb = $this->load->database('dash', TRUE);
        $sql="Select pb.*,pd.patta_no,pd.patta_type_code,
pd.dag_no from allotment_cert_basic pb 
join allotment_pet_dag pd on pb.case_no=pd.case_no  where pb.settlement_typ is null and  pb.case_no='$case_no' ";
        $data=$this->db->query($sql)->row_array();
        $type='AC';
        $base= array(
              'dist_code'=> $data['dist_code'],
              'subdiv_code' =>$data['subdiv_code'],
              'cir_code'=>$data['circle_code'],
              'mouza_pargona_code'=>$data['mouza_pargona_code'],
              'lot_no'=>$data['lot_no'],
              'vill_townprt_code'=>$data['vill_townprt_code'],
              'case_no'=>$data['case_no'],
              'date_of_reg'=>$data['date_entry'],
              'dag_no'=>$data['dag_no'],
              'patta_type_code' =>'NA',
              'patta_no' =>'NA',
              'status' =>'P',
              'pending_with_user' =>'CO',
              'case_type' =>$type,
            );
        $this->dbb->insert('dashboard_data',$base);


            unset($base['dag_no']);
            unset($base['patta_type_code']);
            unset($base['patta_no']);

             $this->db->insert('dashboard_data',$base);


        }


    function DashboardReclass($case_no)
    {
        //$this->dbb = $this->load->database('dash', TRUE);

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
           // $this->db->insert('dashboard_data',$base);

            unset($base['dag_no']);
            unset($base['patta_type_code']);
            unset($base['patta_no']);

        $this->db->insert('dashboard_data',$base);

}

 ///////////////////////////////////
        function DashboardNameCorrect($case_no){
            $this->dbb = $this->load->database('dash', TRUE);
            $sql="Select pb.dist_code,pb.subdiv_code,pb.cir_code,pb.mouza_pargona_code,pb.lot_no,pb.lot_no,pb.vill_townprt_code,pb.misc_case_no 
as case_no,pb.dag_no,pb.patta_no,pb.patta_type_code,pd.petition_pdar_name_old as pet_name,pb.status,pb.submission_date as date_entry,pb.user_code,pb.lm_note_yn,pb.sk_note_yn,pb.add_to_officer as co_code,pb.next_date_of_hearing from misc_case_basic pb join misc_case_first_party pd on pb.misc_case_no=pd.misc_case_no  where pb.misc_case_no=? ";
            $data=$this->db->query($sql, array($case_no))->row_array();
            $type='MC';
            $base= array(
                  'dist_code'=> $data['dist_code'],
                  'subdiv_code' =>$data['subdiv_code'],
                  'cir_code'=>$data['cir_code'],
                  'mouza_pargona_code'=>$data['mouza_pargona_code'],
                  'lot_no'=>$data['lot_no'],
                  'vill_townprt_code'=>$data['vill_townprt_code'],
                  'case_no'=>$data['case_no'],
                  'date_of_reg'=>$data['date_entry'],
                  'dag_no'=>$data['dag_no'],
                  'patta_type_code' =>$data['patta_type_code'],
                  'patta_no' =>$data['patta_no'],
                  'status' =>'P',
                  'pending_with_user' =>'CO',
                  'case_type' =>$type,
                );
            $this->dbb->insert('dashboard_data',$base);

            unset($base['dag_no']);
            unset($base['patta_type_code']);
            unset($base['patta_no']);

             $this->db->insert('dashboard_data',$base);
            
            // $applicant= array(
            //     'case_no' => $data['case_no'],
            //     'applicant_name' => $data['pet_name'],
            //     'guardian_name' => 'NA',
            //     'gender' => 'NA' );
            // $this->dbb->insert('dashboard_applicant',$applicant);
            // $action= array(
            //     'case_no' =>$data['case_no'],
            //     'user_code' => $this->session->userdata('user_code'),
            //     'date_of_action_taken' => date('Y-m-d'),
            //     'user_designation' => $this->session->userdata('user_desig_code'),
            //     'remark' => 'Registered By Assistant',
            //      );
            //  $this->dbb->insert('dashboard_action',$action);
        }

            function DashboardNameCancel($case_no){
            $this->dbb = $this->load->database('dash', TRUE);
            $sql="Select pb.dist_code,pb.subdiv_code,pb.cir_code,pb.mouza_pargona_code,pb.lot_no,pb.lot_no,pb.vill_townprt_code,pb.misc_case_no 
as case_no,pb.dag_no,pb.patta_no,pb.patta_type_code,pd.petition_pdar_name_old as pet_name,pb.status,pb.submission_date as date_entry,pb.user_code,pb.lm_note_yn,pb.sk_note_yn,pb.add_to_officer as co_code,pb.next_date_of_hearing from misc_case_basic pb join misc_case_first_party pd on pb.misc_case_no=pd.misc_case_no  where pb.misc_case_no='$case_no' ";
            $data=$this->db->query($sql)->row_array();
            $type='MC';
            $base= array(
                  'dist_code'=> $data['dist_code'],
                  'subdiv_code' =>$data['subdiv_code'],
                  'cir_code'=>$data['cir_code'],
                  'mouza_pargona_code'=>$data['mouza_pargona_code'],
                  'lot_no'=>$data['lot_no'],
                  'vill_townprt_code'=>$data['vill_townprt_code'],
                  'case_no'=>$data['case_no'],
                  'date_of_reg'=>$data['date_entry'],
                  'dag_no'=>$data['dag_no'],
                  'patta_type_code' =>$data['patta_type_code'],
                  'patta_no' =>$data['patta_no'],
                  'status' =>'P',
                  'pending_with_user' =>'CO',
                  'case_type' =>$type,
                );
            $this->dbb->insert('dashboard_data',$base);

            unset($base['dag_no']);
            unset($base['patta_type_code']);
            unset($base['patta_no']);

             $this->db->insert('dashboard_data',$base);
             
            
        }

        ///////////////////////////

        function forceUpdate(){
            //////////////POST To rtps/////////////////////

            $data=array('MB/NCOR/2021/205520','MB/NCOR/2021/205182','MB/NCOR/2021/173375','MB/NCOR/2021/173350','MB/NCOR/2021/172741','MB/NCOR/2021/172701','MB/NCOR/2021/172656','MB/NCOR/2021/124860','MB/NCOR/2021/124847','MB/NCOR/2021/124829','MB/NCOR/2021/124570','MB/NCOR/2021/296104','MB/NCOR/2021/295984','MB/NCOR/2021/286400','MB/NCOR/2021/218554','MB/NCOR/2021/218391','MB/NCOR/2021/205658','MB/NCOR/2021/205607','MB/NCOR/2021/266432','MB/NCOR/2021/266383','MB/NCOR/2021/266238','MB/NCOR/2021/266162');
                $rmk='Order Passed';
                $status='F';
                $task='CO';
                $pen='NA';
                $case="";
            foreach($data as $pet){

                //$application_no= "MB/NCOR/2021/".$pet;
                $application_no=$pet;
                $this->rtpsmodel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
            }
            
            //////////////////
        }


    //     function duplicateUp(){
    //         $sql="ALTER TABLE basundhar_application add column duplicate integer DEFAULT 0 ";
    //         $this->db->query($sql);

    //         $sql="Select distinct(basundhara) as basu from basundhar_application where app_status='P' ";
    //         $result=$this->db->query($sql)->result_array();
    //         foreach($result as $r){
    //             //echo $r['basu'];
                
    //             $sql="Select dharitree from basundhar_application where basundhara='$r[basu]' and dharitree!='' ";
    //             $loop= $this->db->query($sql)->num_rows();
    //             $data=$this->db->query($sql)->result_array();
    //             //echo "<br>";
    //             if($loop>1){
    //                 $j=1;
    //                 // echo "<br><br>";
    //                 // echo $r['basu']."<br>";
    //                 // echo $loop;
    //                 // echo "<br>";
    //                 //echo json_encode($data);
                    
    //                 for($i=1;$i<$loop;$i++){
    //                      echo $j++."--";
    //                      $dharitree= ($data[$i]['dharitree']);
    //                      $basundhara=$r['basu'];
    //                      $newID="DUP_".$r['basu'];
    //                      $sql="Update basundhar_application set basundhara='$newID',duplicate='1' where dharitree='$dharitree' and basundhara='$basundhara'  ";
    //                      echo $this->db->query($sql);
    //                      echo "<br>";
    //                 }
    //             }
    //         }
    // }
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
      
        /////////////18-12-2021/////////////////////
        function adcRejectList(){
            //$data['case']=$this->rtpsmodel->adcRejectList();
            $curl_handle = curl_init();

            //$url="https://basundhara.assam.gov.in/demo/"."rest/getrejectapp";
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."getRejectedApplications");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, true);
            curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS,json_encode([
                'dist_code' => $this->session->userdata('dist_code'),
                'service_code'=>null,
                'required_response'=>'COUNT'
            ]));
            $data=curl_exec($curl_handle);
            $data= json_decode($data);
            if($data->responseType==2){
                $data->responseType;
                $store['output']=$data->data;
            }else{
                $store['output']=null;
            }
            $store['_view'] = 'rtps/rejectlist';
            $this->load->view('layouts/main',$store);
    }
    ////////////////////For CO//////////////////////////
    function pendingforApprove(){
            //$data['case']=$this->rtpsmodel->adcRejectList();
            $curl_handle = curl_init();
            //$url="https://basundhara.assam.gov.in/demo/"."rest/getrejectapp";
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."getADCAllowedApplicationsForCircle");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, true);
            curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS,json_encode([
                'dist_code' => $this->session->userdata('dist_code'),
                'subdiv_code'=>$this->session->userdata('subdiv_code'),
                'cir_code'=>$this->session->userdata('cir_code'),
                'service_code'=>null,
                'allow_reapply'=>'A',
                'required_response'=>'COUNT'
            ]));
            $data=curl_exec($curl_handle);
            $data= json_decode($data);
            if($data->responseType==2){
                $data->responseType;
                $store['output']=$data->data;
            }else{
                $store['output']=null;
            }
            $store['_view'] = 'rtps/reapprovelist';
            $this->load->view('layouts/main',$store);
    }
    function coview($s){
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."getADCAllowedApplicationsForCircle");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, true);
            curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS,json_encode([
                'dist_code' => $this->session->userdata('dist_code'),
                'subdiv_code'=>$this->session->userdata('subdiv_code'),
                'cir_code'=>$this->session->userdata('cir_code'),
                'service_code'=>$s,
                'required_response'=>'DATA'
            ]));
            $data=curl_exec($curl_handle);
            $data= json_decode($data);
            if($data->responseType==2){
                $data->responseType;
                $store['pending']=$data->data;
            }else{
                $store['pending']=null;
            }
            $store['_view'] = 'rtps/requestco';
            $this->load->view('layouts/main',$store);
    }
    ///////////////////////////////////////////////////////
    function adcview($s){
            //$data['case']=$this->rtpsmodel->adcRejectList();
            $curl_handle = curl_init();
            //$url="https://basundhara.assam.gov.in/demo/"."rest/getrejectapp";
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."getRejectedApplications");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, true);
            curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS,json_encode([
            'dist_code' => $this->session->userdata('dist_code'),
            'service_code'=>$s,
            'required_response'=>'DATA'
            ]));
            $data=curl_exec($curl_handle);
            $data= json_decode($data);
            if($data->responseType==2){
                $data->responseType;
                $store['pending']=$data->data;
            }else{
                $store['pending']=null;
            }
            $store['_view'] = 'rtps/requestadc';
            $this->load->view('layouts/main',$store);
    }
    ///////////////////////
    ///////////////////////
    function adcApproveReject(){
        $curl_handle = curl_init();
        if($this->session->userdata('user_desig_code')=='CO'){
            $allow_reapply=$_POST['allow_reapply']=='Y'?$_POST['allow_reapply']:$_POST['allow_reapply'];
        }else{
            $allow_reapply=$_POST['allow_reapply']=='Y'?'A':$_POST['allow_reapply'];
        }
        ////////////////////////////
        if($allow_reapply == 'E' && $this->session->userdata('user_desig_code')=='CO')
        {
            $this->db->trans_begin();

            $sql="Select dharitree from basundhar_application where basundhara=? and dharitree is not null";
            $dharitree_result=$this->db->query($sql,array(trim($_POST['case_no'])));

            if($dharitree_result->num_rows() <= 0)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERR001: Dharitree case not found in basundhar_application for Case No '.trim($_POST['case_no']));
                $data=array(
                    'error'=> '#ERR001: !!! Dharitree case not found'
                );
                echo json_encode($data);
                return;
            }

            $dharitree_case_no = $dharitree_result->row();

            $field_mut_basic_query = $this->db->query("select * from field_mut_basic where case_no=?",array($dharitree_case_no->dharitree));
            if($field_mut_basic_query->num_rows() <= 0)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERR002: Dharitree case not found in field_mut_basic for Case No '.trim($_POST['case_no']));
                $data=array(
                    'error'=> '#ERR002 !!! Error in Processing. Dharitree case not found',
                );
                echo json_encode($data);
                return;
            }
            $field_mut_basic_data = $field_mut_basic_query->row();
            $basundhara_data_updation = array(
                'ip'=> $this->input->ip_address(),
                'case_no'=> $dharitree_case_no->dharitree,
                'basundhara'=> trim($_POST['case_no']),
                'user_code'=>$this->session->userdata('user_code'),
                'date_entry'=>date('Y-m-d H:i:s'),
                'changes_data' => json_encode($field_mut_basic_data),
            );
            $insert_basundhara_data_updation = $this->db->insert('basundhara_data_updation',$basundhara_data_updation);
            if($insert_basundhara_data_updation != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERR003: Insertion failed in basundhara_data_updation for Case No '.trim($_POST['case_no']));
                $data=array(
                    'error'=> '#ERR003 !!! Data not updated',
                );
                echo json_encode($data);
                return;
            }

            $update = array(
                'order_passed'=>null,
                'date_of_order'=>null,
                'is_dispose'=> null,
                'if_dispose_date'=>null,
                'dispose_reason'=>null,
            );
            $this->db->where('case_no', $dharitree_case_no->dharitree);
            $field_mut_basic_update = $this->db->update('field_mut_basic', $update);

            if($field_mut_basic_update == false || $this->db->affected_rows() <= 0)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERR004: Updation failed in field_mut_basic for Case No '.trim($_POST['case_no']));
                $data=array(
                    'error'=> '#ERR004 !!! Error in Final Processing.',
                );
                echo json_encode($data);
                return;
            }

            if ($this->db->trans_status() == FALSE)
            {
                $this->db->trans_rollback();
                $data=array(
                    'error'=> 'Error !!!Not completed. Please try again',
                );
                echo json_encode($data);
                return;
            }
            else
            {
                    $this->db->trans_commit();
                    //$url="https://basundhara.assam.gov.in/demo/"."rest/updatereapply";
                    curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."updateAllowReapply");
                    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
                    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, true);
                    curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                    curl_setopt($curl_handle, CURLOPT_POSTFIELDS,json_encode([
                        'app_id' => $_POST['app_id'],
                        'allow_reapply'=>$allow_reapply,
                        'reapply_remark'=>$_POST['reapply_remark'],
                        'user_code'=>$this->session->userdata('user_code')
                    ]));
                    $data=curl_exec($curl_handle);
                    $data= json_decode($data);
                    if($data->responseType==2){
                        if($_POST['allow_reapply']=='Y'){
                            $response="Approved. User can re-apply the Application";
                        }else{
                            $response="Case Should be available under Field Mutation Process";
                        }
                        $data=array(
                            'success'=>$response,
                            'redirect_url'=>base_url().'index.php/home'
                        );
                    }else if($data->responseType==3){
                        $data=array(
                            'error'=>$data->error ."<b> Please reject the case </b>",
                            'redirect_url'=>base_url().'index.php/home'
                        );
                    }else{
                        $data=array(
                            'error'=>$data->validation,
                            'redirect_url'=>base_url().'index.php/home'
                        );
                    }
                    echo json_encode($data);
            }

        }
        else {
                //$url="https://basundhara.assam.gov.in/demo/"."rest/updatereapply";
                curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."updateAllowReapply");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, true);
                curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS,json_encode([
                    'app_id' => $_POST['app_id'],
                    'allow_reapply'=>$allow_reapply,
                    'reapply_remark'=>$_POST['reapply_remark'],
                    'user_code'=>$this->session->userdata('user_code')
                ]));
                $data=curl_exec($curl_handle);
                $data= json_decode($data);
                if($data->responseType==2){
                    if($_POST['allow_reapply']=='Y'){
                        $response="Approved. User can re-apply the Application";
                    }else{
                        $response="Rejected. User cann't re-apply the Application";
                    }
                    $data=array(
                        'success'=>$response,
                        'redirect_url'=>base_url().'index.php/home'
                    );
                }else if($data->responseType==3){
                    $data=array(
                        'error'=>$data->error ."<b> Please reject the case </b>",
                        'redirect_url'=>base_url().'index.php/home'
                    );
                }else{
                    $data=array(
                        'error'=>$data->validation,
                        'redirect_url'=>base_url().'index.php/home'
                    );
                }
                echo json_encode($data);
        }
        /////////////////////////////
        
    }
    ///////////////////////////// 
    function pushSro(){
        $dharitree=$this->input->get('c');
        $basundhara=$this->input->get('app');
        $result=$this->rtpsmodel->pushSro();
        if($result==true){
            $this->session->set_flashdata('message',"Application Sent to SRO Office");
            redirect('/home');
        }else{
        $this->session->set_flashdata('message',"Found Error. Please Try again");
            redirect('/home');  
        }    
    }
    ///////////////////////
    function adcApproveRejectOffice(){
        $curl_handle = curl_init();
        if($this->session->userdata('user_desig_code')=='CO'){
            $allow_reapply=$_POST['allow_reapply']=='Y'?$_POST['allow_reapply']:$_POST['allow_reapply'];
        }else{
            $allow_reapply=$_POST['allow_reapply']=='Y'?'A':$_POST['allow_reapply'];
        }
        ////////////////////////////
        if($allow_reapply == 'E' && $this->session->userdata('user_desig_code')=='CO')
        {
            $this->db->trans_begin();
            $sql="Select dharitree from basundhar_application where basundhara=? and dharitree is not null";
            $dharitree_result=$this->db->query($sql,array(trim($_POST['case_no'])));

            if($dharitree_result->num_rows() == 0)
            {
                $this->db->trans_rollback();
                $data=array(
                    'error'=> 'Error !!! Dharitree case not found'
                );
                echo json_encode($data);
                return;
            }
            $dharitree_case_no = $dharitree_result->row();
            $field_mut_basic_query = $this->db->query("select * from petition_basic where case_no=?",array($dharitree_case_no->dharitree));
            if($field_mut_basic_query->num_rows() == 0)
            {
                $this->db->trans_rollback();
                $data=array(
                    'error'=> 'Error !!! Error in Processing. Dharitree case not found',
                );
                echo json_encode($data);
                return;
            }
            $field_mut_basic_data = $field_mut_basic_query->row();
            $basundhara_data_updation = array(
                'ip'=> $this->input->ip_address(),
                'case_no'=> $dharitree_case_no->dharitree,
                'basundhara'=> trim($_POST['case_no']),
                'user_code'=>$this->session->userdata('user_code'),
                'date_entry'=>date('Y-m-d H:i:s'),
                'changes_data' => json_encode($field_mut_basic_data),
            );
            $insert_basundhara_data_updation = $this->db->insert('basundhara_data_updation',$basundhara_data_updation);
            if($insert_basundhara_data_updation == false)
            {
                $this->db->trans_rollback();
                $data=array(
                    'error'=> 'Error !!! Data not updated',
                );
                echo json_encode($data);
                return;
            }
            $update = array(
                'order_passed'=>null,
                'date_of_order'=>null,
                'status'=> 'P',
            );
            $this->db->where('case_no', $dharitree_case_no->dharitree);
            $field_mut_basic_update = $this->db->update('petition_basic', $update);
            if($field_mut_basic_update == false || $this->db->affected_rows() != 1)
            {
                $this->db->trans_rollback();
                $data=array(
                    'error'=> 'Error !!! Error in Final Processing.',
                );
                echo json_encode($data);
                return;
            }
            if ($this->db->trans_status() == FALSE)
            {
                $this->db->trans_rollback();
                $data=array(
                    'error'=> 'Error !!!Not completed. Please try again',
                );
                echo json_encode($data);
                return;
            }
            else
            {
                    $this->db->trans_commit();
                    //$url="https://basundhara.assam.gov.in/demo/"."rest/updatereapply";
                    curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."updateAllowReapply");
                    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
                    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, true);
                    curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                    curl_setopt($curl_handle, CURLOPT_POSTFIELDS,json_encode([
                        'app_id' => $_POST['app_id'],
                        'allow_reapply'=>$allow_reapply,
                        'reapply_remark'=>$_POST['reapply_remark'],
                        'user_code'=>$this->session->userdata('user_code')
                    ]));
                    $data=curl_exec($curl_handle);
                    $data= json_decode($data);
                    if($data->responseType==2){
                        if($_POST['allow_reapply']=='Y'){
                            $response="Approved. User can re-apply the Application";
                        }else{
                            $response="Case Should be available under Office Mutation Process First Proceeding or Second Proceeding ";
                        }
                        $data=array(
                            'success'=>$response,
                            'redirect_url'=>base_url().'index.php/home'
                        );
                    }else if($data->responseType==3){
                        $data=array(
                            'error'=>$data->error ."<b> Please reject the case </b>",
                            'redirect_url'=>base_url().'index.php/home'
                        );
                    }else{
                        $data=array(
                            'error'=>$data->validation,
                            'redirect_url'=>base_url().'index.php/home'
                        );
                    }
                    echo json_encode($data);
            }

        }
        else {
                //$url="https://basundhara.assam.gov.in/demo/"."rest/updatereapply";
                curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."updateAllowReapply");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, true);
                curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS,json_encode([
                    'app_id' => $_POST['app_id'],
                    'allow_reapply'=>$allow_reapply,
                    'reapply_remark'=>$_POST['reapply_remark'],
                    'user_code'=>$this->session->userdata('user_code')
                ]));
                $data=curl_exec($curl_handle);
                $data= json_decode($data);
                if($data->responseType==2){
                    if($_POST['allow_reapply']=='Y'){
                        $response="Approved. User can re-apply the Application";
                    }else{
                        $response="Rejected. User cann't re-apply the Application";
                    }
                    $data=array(
                        'success'=>$response,
                        'redirect_url'=>base_url().'index.php/home'
                    );
                }else if($data->responseType==3){
                    $data=array(
                        'error'=>$data->error ."<b> Please reject the case </b>",
                        'redirect_url'=>base_url().'index.php/home'
                    );
                }else{
                    $data=array(
                        'error'=>$data->validation,
                        'redirect_url'=>base_url().'index.php/home'
                    );
                }
                echo json_encode($data);
        }
        /////////////////////////////  
    }


    /////////////31-03-22

    function DashboardData($case_no,$penUser,$rmrk){
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
            'ip_address'=>$this->utilityclass->get_client_ip()
             );
        $this->dbb->insert('dashboard_action',$action);
        $this->db->insert('dashboard_action',$action);

        $this->db->where('case_no',$case_no);

        $this->db->update('dashboard_data',$base);
    }

    function DashboardDataFinal($case_no){
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
             );
        $this->dbb->insert('dashboard_action',$action);
        $this->db->where('case_no',$case_no);
        $this->db->update('dashboard_data',$base);
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
        $action= array(
            'case_no' => $case_no,
            'user_code' => $this->session->userdata('user_code'),
            'date_of_action_taken' => date("Y-m-d h:i:s"),
            'user_designation' => $this->session->userdata('user_desig_code'),
            'remark' => 'Rejected',
             );
        $this->dbb->insert('dashboard_action',$action);
    }


    function freshReportBackRTPS(){
       
        $this->db->trans_begin();

        $rmk=addslashes(trim($_POST['note_order']));
        $case_no=$_POST['case_no'];
        $revert_back=$this->session->userdata('user_desig_code');
        $user_code=$this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');

        if($revert_back=='LM'){
            $lmname=$this->utilityclass->getDefinedMondalsName($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$user_code);
            $rmk=$rmk ."   ভূমিলেখ্য সহায়ক : ".$lmname->lm_name;
            
            $update=array(
                'is_dispose'=>null,
                'user_code'=>$user_code,
                'is_dispose'=>null,
                'sk_note'=>null,
                'sk_note_date'=>null,
                'sk_flag'=>null
            );
            $remark=array('remark'=>$rmk);
            $task="LM";
        }else if($revert_back=='SK'){
           $skname=$this->utilityclass->getDefinedSKName($dist_code,$subdiv_code,$cir_code,$user_code);
           $rmk=$rmk . "   ভূমিলেখ্য পৰ্যবেক্ষক : " . $skname->username ;
           $update=array(
                'is_dispose'=>null,
                'sk_note'=>$rmk,
                'sk_note_date'=>date('Y-m-d'),
                'sk_flag'=>'y',
                'sk_id'=>$user_code
            );
           $task="SK";
        }

        $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
        if($basundharaExist){
            $this->basundharamodel->insertproceeding($case_no,$rmk);
            $this->db->where('case_no',$case_no);
            $this->db->update('field_mut_basic',$update);
            if($this->db->affected_rows() != 1){
                $this->db->trans_rollback();
                log_message("error","#FPART002 Updation failed in field_mut_basic");
                return false;
            }

            $this->db->trans_commit();
            //////////////POST To basundhara/////////////////////
            $application_no=$basundharaExist;
            $rmk='Case has successfully forwarded to CO';
            $status='M';
            $pen='CO';
            $case=$case_no;
            $this->basundharamodel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
            $this->DashboardData($case_no,$pen,$rmk);   
            $this->session->set_flashdata('message',"Case has been forwarded");
            $validation['final'] = 'true';
        }
        
        echo json_encode($validation);
        return;       
    }
    public function OfcMutationCOUpdateReport(){
        $rmk = addslashes(trim($_POST['note_order']));
        $case_no = $_POST['case_no'];
        $revert_back = $this->session->userdata('user_desig_code');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');        

        if($revert_back=='LM'){
            $lmname=$this->utilityclass->getDefinedMondalsName($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$user_code);
            $rmk=$rmk ."   ভূমিলেখ্য সহায়ক : ".$lmname->lm_name;
            $task="LM";
        }
        else if($revert_back=='SK'){
            $skname=$this->utilityclass->getDefinedSKName($dist_code,$subdiv_code,$cir_code,$user_code);
            $rmk=$rmk . "   ভূমিলেখ্য পৰ্যবেক্ষক : " . $skname->username ;
            $task="SK";
        }

        $basundharaExist = $this->basundharamodel->checkExistBasundhar($case_no);
        if($basundharaExist){
            $this->basundharamodel->insertproceeding($case_no,$rmk);
            $this->db->where('case_no',$case_no);
            $update = [
                'lm_note_yn' => 'Y',
                'lm_note_date' => date('Y-m-d h:i:s'),
                'is_pending' => '',
                'sk_comment' => null
            ];
            $this->db->update('petition_basic', $update);
            //////////////POST To basundhara/////////////////////
            $application_no=$basundharaExist;
            $rmk='Forwarded to CO';
            $status='M';
            $pen='CO';
            $case=$case_no;
            $this->basundharamodel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
            //////////////////
            $this->DashboardData($case_no,$pen,$rmk);    
            $this->session->set_flashdata('message',"Case have been forwarded");
            redirect('/home');
        }
    }

    public function revertReportOPartSubmitRTPS(){

        $mutatedLandValidation = [
            [
                'field' => 'note_order',
                'label' => 'Remarks',
                'rules' => 'trim|required|xss_clean',
            ]
        ];
        $validation= null;
        $this->form_validation->set_rules($mutatedLandValidation);
        if ($this->form_validation->run('mutatedLandValidation') == FALSE)
        {
            $this->form_validation->set_error_delimiters('', '');
            foreach($mutatedLandValidation as $rule){
            if (form_error($rule['field'])) {
                $validation['error'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
                }
            }             
        }
        else
        {
            $rmk = addslashes(trim($_POST['note_order']));
            $case_no = $this->input->post('case_no');
            $revert_back = $this->session->userdata('user_desig_code');
            $user_code = $this->session->userdata('user_code');
            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $cir_code = $this->input->post('cir_code');
            $mouza_pargona_code = $this->input->post('mouza_pargona_code');
            $lot_no = $this->input->post('lot_no');
            $petition_no = $this->input->post('petition_no');
            $dag_no = $this->input->post('dag_no');

            $this->db->trans_begin();

            $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);

            if($revert_back=='LM')
            {
                $lmname=$this->utilityclass->getDefinedMondalsName($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$user_code);
                $rmk=$rmk ."   ভূমিলেখ্য সহায়ক : ".$lmname->lm_name;
                $task="LM";

                //insert old data of petition_dag_details in basundhara
                $sql = "SELECT * FROM petition_dag_details WHERE petition_no=? 
                AND dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? 
                AND lot_no=? AND dag_no=?";
                $oldData = $this->db->query($sql, array($petition_no, $dist_code, 
                $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $dag_no))->result();

                if($basundhara){
                    $basuData=array(
                        'ip'=>$this->utilityclass->get_client_ip(),
                        'case_no' => $case_no,
                        'basundhara' => $basundhara,
                        'user_code' => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d H:i:s'),
                        'changes_data' => json_encode($oldData),
                    );
                    $basu_ins = $this->db->insert('basundhara_data_updation', $basuData);
                    if($basu_ins != 1){
                        $this->db->trans_rollback();
                        log_message("error","#OPART001 Insertion failed in basundhara_data_updation");
                        $validation=array(
                            'errorMsg'=>"#OPART001: Failed to forward the case"
                        );
                        echo json_encode($validation);
                        return false;
                    }
                }

                $data = array(
                    'lm_note_yn' => 'Y',
                    'lm_note_date' => date('Y-m-d h:i:s'),
                    'is_pending' => null,
                    'sk_comment' => null,
                );                
                $this->db->where('case_no', $case_no);
                $this->db->update('petition_basic', $data);    
                if($this->db->affected_rows() <= 0){
                    $this->db->trans_rollback();
                    log_message("error","#OPART005 Updation failed in petition_basic");
                    $validation=array(
                        'errorMsg'=>"#OPART005: Failed to forward the case"
                    );
                    echo json_encode($validation);
                    return false;
                }

                if($basundhara){
                    $this->db->trans_commit();
                    $this->basundharamodel->insertproceeding($case_no,$rmk);
                    //$this->db->where('case_no',$case_no);
                    $application_no=$basundhara;
                    $rmk='Reverted Case has Forwarded to CO';
                    $status='M';
                    $pen='CO';
                    $case=$case_no;
                    $this->basundharamodel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                    $this->DashboardData($case_no,$pen,$rmk);   
                    $this->session->set_flashdata('message',"Case has been forwarded");
                    $validation['final'] = 'true';
                }
            }
        }
        echo json_encode($validation);
        return;       
    }

    public function lm_submit_RTPS() 
    {
        $json = null;
        $case_no = $this->input->post('case');
        $lmReportValidation = [
            [
                'field' => 'p_bigha',
                'label' => 'Possesion Bigha',
                'rules' => 'trim|required|xss_clean|integer',
            ],
            [
                'field' => 'p_katha',
                'label' => 'Possesion Katha',
                'rules' => 'trim|required|xss_clean|integer',
            ],
            [
                'field' => 'p_lessa',
                'label' => 'Possesion Lessa',
                'rules' => 'trim|numeric|required|xss_clean|numeric',
            ],
            [
                'field' => 'exist_revenue',
                'label' => 'Existing TB Revenue',
                'rules' => 'trim|required|xss_clean|numeric',
            ],
            [
                'field' => 'exist_local_tax',
                'label' => 'Existing Local Tax',
                'rules' => 'trim|required|xss_clean|numeric',
            ],
            [
                'field' => 'revenue',
                'label' => 'Proposed Land Revenue',
                'rules' => 'trim|required|xss_clean|numeric',
            ],
            [
                'field' => 'local_tax',
                'label' => 'Proposed Local Tax',
                'rules' => 'trim|required|xss_clean|numeric',
            ],
            [
                'field' => 'lm_comment',
                'label' => 'LM Comment',
                'rules' => 'trim|required|xss_clean',
            ],
        ];
        $this->form_validation->set_rules($lmReportValidation);
        $this->form_validation->set_message('integer', 'This %s is not valid');
        if ($this->form_validation->run('lmReportValidation') == FALSE)
        {
            $this->form_validation->set_error_delimiters('', '');
            foreach($lmReportValidation as $rule){
            if (form_error($rule['field'])) {
                $json['error1'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
                }
            }             
        }
        else
        {
            $user_code = $this->session->userdata('user_code');
            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $cir_code = $this->input->post('cir_code');
            $mouza_pargona_code = $this->input->post('mouza_pargona_code');
            $vill_townprt_code = $this->input->post('vill_townprt_code');
            $lot_no = $this->input->post('lot_no');
            $old_dag = $this->input->post('old_dag');

            $tot_bigha = $this->input->post('tot_bigha');
            $tot_katha = $this->input->post('tot_katha');
            $tot_lessa = $this->input->post('tot_lessa');
            $p_bigha = $this->input->post('p_bigha');
            $p_katha = $this->input->post('p_katha');
            $p_lessa = $this->input->post('p_lessa');
            $new_dag = $this->input->post('new_dag');
            $new_patta = $this->input->post('new_patta');
            $revenue = $this->input->post('revenue');
            $local_tax = $this->input->post('local_tax');            
            $lm_comment = $this->input->post('lm_comment');
            $allotte_k = $this->input->post('allotte_k');
            $original_alotee = $this->input->post('original_alotee');
            $posession_y = $this->input->post('posession_y');
            $p_year = $this->input->post('p_year');
            $land_use = $this->input->post('land_use');
            $three_km = $this->input->post('three_km');
            $ten_km = $this->input->post('ten_km');
            $recorded_tenant = $this->input->post('allotte_rec');
            $old_rev = $this->input->post('exist_revenue');
            $old_lc = $this->input->post('exist_local_tax');
            $new_patta_type = $this->input->post('new_patta_type');
            $new_landcode = $this->input->post('new_landcode');
            $username = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code);
            $username = " ভূমিলেখ্য সহায়ক ------ " . $username->lm_name;
            $comment = $lm_comment . $username;
            $comment = addslashes($comment);

            $redirectURL = base_url()."index.php/Rtps/lmstep_one?case_no=".$case_no;

            $this->db->trans_begin();

            $q = "SELECT max(order_slno) AS id FROM allotment_lm_note WHERE 
            case_no='$case_no'";
            $slno = $this->db->query($q)->row()->id;
            if ($slno == 0) {
                $slno = 1;
            } else {
                $slno = $slno + 1;
            }
                
            $lmnote = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'circle_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'case_no' => $case_no,
                'year_no' => date('Y'),
                'certificate_ok_not' => $allotte_k,
                'original_alotee' => $original_alotee,
                'under_possesion' => $posession_y,
                'under_possesion_yr' => $p_year,
                'nature_land' => $land_use,
                'three_km_radius' => $three_km,
                'ten_km_radius' => $ten_km,
                'area_posession_b' => $p_bigha,
                'area_posession_k' => $p_katha,
                'area_posession_lc' => $p_lessa,
                't_area_posession_b' => $tot_bigha,
                't_area_posession_k' => $tot_katha,
                't_area_posession_lc' => $tot_lessa,
                'new_dag' => $new_dag,
                'new_patta' => $new_patta,
                'l_rev' => $revenue,
                'l_tax' => $local_tax,
                'date_entry' => date('Y-m-d'),
                'user_code' => $user_code,
                'lm_comment' => $comment,
                'order_slno' => $slno,
                'recorded_tenant' => $recorded_tenant,
                'old_rev' => $old_rev,
                'old_lc' => $old_lc,
                'patta_type_code' => $new_patta_type,
                'ladclass_code' => $new_landcode,
            );
            $alotmentLM = $this->db->insert('allotment_lm_note', $lmnote);
            if($alotmentLM != 1){
                $this->db->trans_rollback();
                log_message('error', '#ERRALOT004: Insertion failed in allotment_lm_note for case no '.$case_no);
                $json = [
                    'errorMessage'=>"#ERRALOT004: Updation failed on changing Dag for Case No ".$case_no
                ];
                echo json_encode($json);
                return false;
            }
            $update = array(
                'lm_code' => $user_code,
                'lm_note' => 'Y',
                'sk_note' => null,
                'lm_entry_date' => date('Y-m-d')
            );
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('circle_code', $cir_code);
            $this->db->where('case_no', $case_no);
            $this->db->update('allotment_cert_basic', $update);
            if($this->db->affected_rows() <= 0)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERR005: Updation failed in allotment_pet_dag for case no :'. $case_no);
                $json = [
                    'errorMessage'=>"#ERR005: Updation failed on changing Dag for Case No ".$case_no
                ];
                echo json_encode($json);
                return false;
            }

            $this->db->trans_commit();
            ///////
            $penUser='SK';
            $rmrk='Report given by LM';
            $this->DashboardData($case_no,$penUser,$rmrk);
            $rmk=$rmrk;
            $status='M';
            $task='LM';
            $pen='SK';
            $case=$case_no;
            $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
            //////

            $json['success'] = 'true';
            $json['case_no'] = $case_no;
            $json['redirect'] = base_url()."index.php/Allotment/lmpending";
        }
        echo json_encode($json);
        return;
    }
    function getGuardianName($d,$s,$c,$m,$v,$l,$dag,$pn,$ptype,$pid)
    {
        $q = $this->db->query("SELECT p.pdar_id, p.pdar_name, p.pdar_father 
                FROM chitha_pattadar p JOIN chitha_dag_pattadar d ON p.dist_code = d.dist_code 
                AND p.subdiv_code = d.subdiv_code AND p.cir_code = d.cir_code AND 
                p.lot_no = d.lot_no AND p.vill_townprt_code = d.vill_townprt_code AND 
                p.mouza_pargona_code = d.mouza_pargona_code AND p.pdar_id = d.pdar_id 
                WHERE p.dist_code='$d' AND 
                p.subdiv_code='$s' AND 
                p.cir_code='$c' AND 
                p.mouza_pargona_code='$m' AND
                p.vill_townprt_code='$v' AND 
                d.lot_no='$l' AND 
                d.dag_no='$dag' AND 
                TRIM(p.patta_no)='$pn' AND
                p.patta_type_code='$ptype' AND
                d.pdar_id='$pid' ");
                //d.pdar_id='$pid' AND d.p_flag!='1'");
        //echo $this->db->last_query();
        return $q;   
    }

    //#START PLB
     function rorJamabandi(){
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
       // var_dump($output);
        $district['app']=$output->application;
        $district['pattaInfo']=$output->mutation[0];
        $district['firstParty']=$output->applicants[0];
        $district['document']=$output->documents;
        $district['query']=$output->query;
      
        $district['user']=$this->basundharamodel->usersForOffice($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code);
        if(($district['app']->dist_code!=$this->session->userdata('dist_code')) || ($district['app']->subdiv_code!=$this->session->userdata('subdiv_code')) || ($district['app']->cir_code!=$this->session->userdata('cir_code')) )
        {
            redirect('/home');
        }
        $district['_view'] = 'rtps/register_ror_applicant';
        $this->load->view('layouts/main',$district);
    }


 function jamabandiPost(){
        $application_no=$_POST['application_no'];
        //////////////////
        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
                $data=array(
                    'error'=>"Case have been Registered Already. Please Check"
                );
                echo json_encode($data);
                exit;
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
        $data['pattaInfo']=$output->mutation[0];
        $data['firstParty']=$output->applicants[0];
        $data['document']=$output->documents;
        $data['query']=$output->query;
        //var_dump($data);
        if(($data['app']->dist_code!=$this->session->userdata('dist_code')) || ($data['app']->subdiv_code!=$this->session->userdata('subdiv_code')) || ($data['app']->cir_code!=$this->session->userdata('cir_code')) )
        {
            $data=array(
                'error'=>"Please reload the page. Session might be Destroyed."
            );
            echo json_encode($data);
            return false;
            exit;
        }
        $this->db->trans_begin();

        $case_name=$this->rtpsmodel->genearteCaseName();
        if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Session Out. Please try Again"
            );
            echo json_encode($data);
            exit;
            die();
        }
        $year_no = date('Y');
        $cert_type = '01';
        $cername = $this->utilityclass->getCertCode($cert_type);
       // $petition_no=$this->rtpsmodel->genearteCertPetitionNo();

        $seq_pet=year_no.'000';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteCertPetitionNo();


        $appln_no = $cername . "/" . $petition_no . "/" . $year_no;
        $data['cert_no']=$cert_no =$case_name.$petition_no."/".$cername;

        $insert = array(
            'dist_code' => $data['app']->dist_code,
            'subdiv_code' => $data['app']->subdiv_code,
            'cir_code' => $data['app']->cir_code,
            'mouza_pargona_code' => $data['app']->mouza_code,
            'lot_no' => $data['app']->lot_no,
            'vill_townprt_code' => $data['app']->village_code,
            'cert_type' =>'01',
            'appln_no' => $appln_no,
            'cert_no' => $cert_no,
            'year_no' => date('Y'),
            'fee_amount' => $this->input->post('cert_fees'),
            'patta_no' => $this->input->post('patta_no'),
            'patta_type_code' => $this->input->post('patta_type_code'),
            'pdar_id' => $this->input->post('pdar_id'),
            'appln_name' => $this->input->post('pdar_name'),
            'appln_guard' => $this->input->post('guard_name'),
            'guard_reln' => $this->utilityclass->relationRevertBasu($data['app']->dist_code,$data['firstParty']->pat_gurdian_rel_id),
            'apply_date' => $data['app']->date_submission,
            'next_due_date' => date('Y-m-d G:i:s'),
            'receipt_gen_yn' => 'Y',
            'status' => 'M',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d G:i:s'),
            'rev_yn' =>  $this->session->userdata('revenue'),
            'pdar_aadharno' => '',
            'pdar_mobile' => $this->input->post('mobile_no'),
            'pdar_pan' =>'',
            'mode_of_registration' => 'citizen',
            'application_ref_no' => '',
            'applid' => '',
        );
        //var_dump($insert);
        $insCertAppl=$this->db->insert('cert_application', $insert);

        if($insCertAppl != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRRORJ001: Insertion failed in cert_application for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRRORJ001: Registration of RoR-jamabandi failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
        $basundhara=array(
                'dharitree'=>$cert_no,
                'basundhara'=>$application_no,
                'date_reg'=>date('Y-m-d'),
                'reg_by'=>$this->session->userdata('user_code'),
                'app_status'=>'P',
                'pending_with'=>'CO'
            );
        //////////UUID Insert/////////////
        $basundhara['uuid']=$this->utilityclass->getVillageUUID($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code);
        ///////////////////////
        $insBasuROR = $this->db->insert('basundhar_application',$basundhara);

        if($insBasuROR != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRRORJ002: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRRORJ002: Registration of RoR-jamabandi by Deed failed for case no : ".$application_no
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
        else
            {                
                //////////////POST To rtps/////////////////////
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."applicationStatusUpdate");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    'application' => $application_no,
                    'dharitree' => $cert_no,
                    'rmk' => 'all ok',
                    'status' => 'M',
                    'task' => 'AST',
                    'pen'=>'LM'
                )));
                $result = curl_exec($curl_handle);
                if($result===true || $result=='true' || $result==1 || json_decode($result)=='true'|| json_decode($result)==true || json_decode($result)=='y' || $result=='y'){
                    $this->db->trans_commit();
                }else{
                    $data=array(
                        'error'=>"Error in submitting. Please try Again"
                    );
                    echo json_encode($data);
                    return;
                }
              //  $this->DashboardPartitionField($case_no['case_no']);
                $json['success'] = 'true';
                $json['case_no'] = $cert_no;
                $json['redirect'] = base_url()."index.php/home/index";
                echo json_encode($json);
                return;
            }
       
    }
    //#END PLB
    function jamabandiPostManual(){
        //SIB/NAZ/2022-23/166495/JB
        $application_no='RTPS/ROR/2022/233820';
        //////////////////
        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
                $data=array(
                    'error'=>"Case have been Registered Already. Please Check"
                );
                echo json_encode($data);
                exit;
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
        $data['pattaInfo']=$output->mutation[0];
        $data['firstParty']=$output->applicants[0];
        $data['document']=$output->documents;
        $data['query']=$output->query;
        //var_dump($data['pattaInfo']);
        if(($data['app']->dist_code!=$this->session->userdata('dist_code')) || ($data['app']->subdiv_code!=$this->session->userdata('subdiv_code')) || ($data['app']->cir_code!=$this->session->userdata('cir_code')) )
        {
            $data=array(
                'error'=>"Please reload the page. Session might be Destroyed."
            );
            echo json_encode($data);
            return false;
            exit;
        }
        $this->db->trans_begin();

        $case_name=$this->rtpsmodel->genearteCaseName();
        if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Session Out. Please try Again"
            );
            echo json_encode($data);
            exit;
            die();
        }
        $year_no = date('Y');
        $cert_type = '01';
        //$cername = $this->utilityclass->getCertCode($cert_type);
        $petition_no='166495';
        $appln_no = 'JB/166495/2022';
        $data['cert_no']=$cert_no ='SIB/NAZ/2022-23/166495/JB';

        $insert = array(
            'dist_code' => $data['app']->dist_code,
            'subdiv_code' => $data['app']->subdiv_code,
            'cir_code' => $data['app']->cir_code,
            'mouza_pargona_code' => $data['app']->mouza_code,
            'lot_no' => $data['app']->lot_no,
            'vill_townprt_code' => $data['app']->village_code,
            'cert_type' =>'01',
            'appln_no' => $appln_no,
            'cert_no' => $cert_no,
            'year_no' => date('Y'),
            'fee_amount' => '20.00',
            'patta_no' => '2',
            'patta_type_code' => '0201',
            'pdar_id' => 9,
            'appln_name' => 'সেখ আজিজুৰ  ৰহমান  ',
            'appln_guard' => 'পি- ঁ মেলিলুৰ  ',
            'guard_reln' => 'f',
            'apply_date' => '2022-10-15',
            'next_due_date' => date('Y-m-d G:i:s'),
            'receipt_gen_yn' => 'Y',
            'status' => 'M',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => '2022-10-15',
            'rev_yn' =>  'y',
            'pdar_aadharno' => '',
            'pdar_mobile' => '9957802263',
            'pdar_pan' =>null,
            'mode_of_registration' => 'citizen',
            'application_ref_no' => null,
            'applid' => null,
        );
        echo "<pre>";
        var_dump($insert);
      
        $insCertAppl=$this->db->insert('cert_application', $insert);

        if($insCertAppl != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRRORJ001: Insertion failed in cert_application for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRRORJ001: Registration of RoR-jamabandi failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
        $basundhara=array(
                'dharitree'=>$cert_no,
                'basundhara'=>$application_no,
                'date_reg'=>date('Y-m-d'),
                'reg_by'=>$this->session->userdata('user_code'),
                'app_status'=>'P',
                'pending_with'=>'CO'
            );
        //////////UUID Insert/////////////
        $basundhara['uuid']=$this->utilityclass->getVillageUUID($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code);
        ///////////////////////
        $insBasuROR = $this->db->insert('basundhar_application',$basundhara);

        if($insBasuROR != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRRORJ002: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRRORJ002: Registration of RoR-jamabandi by Deed failed for case no : ".$application_no
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
        }else{
            $this->db->trans_commit();
        }
    }

    public function viewPendingCasesAPI(){
            $service = $this->input->post('service_code');
            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $cir_code = $this->input->post('cir_code');
            $draw = intval($this->input->post('draw'));
            $start = intval($this->input->post('start'));
            $length = intval($this->input->post('length'));
            $order = $this->input->post('order');
            $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
            $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];
            $is_cat = $this->input->post('is_category');
            $is_rural = $this->input->post('rural');
            $pending_at = $this->input->post('pending_at');
            $pending_st = $this->input->post('pendingSts');
            $mouza_code = $this->input->post('mouza_code');
            $lot_no = $this->input->post('lot_no');
            $vill_mouza_code = $this->input->post('vill_mouza_code');
            $vill_lot_no = $this->input->post('vill_lot_no');
            $village_code = $this->input->post('village_code');
            //echo RTPS_API_LINK."viewPendingCasesByCircle/$dist_code/$subdiv_code/$cir_code/$service";
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."viewPendingCasesByCircle/$dist_code/$subdiv_code/$cir_code/$service");
            // curl_setopt($curl_handle, CURLOPT_URL, "http://localhost/rtpsmb2/Api/viewPendingCasesByCircle/$dist_code/$subdiv_code/$cir_code/$service");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'start'             => $start,
                'length'            => $length,
                'order'             => $order,
                'searchByCol_0'     => $searchByCol_0,
                'searchByCol_1'     => $searchByCol_1,
                'is_cat'            => $is_cat,
                // 'is_rural'          => $is_rural,
                'pending_at'        => $pending_at,
                'pending_st'        => $pending_st,
                'mouza_code'        => $mouza_code,
                'lot_no'            => $lot_no,
                'vill_mouza_code'   => $vill_mouza_code,
                'vill_lot_no'       => $vill_lot_no,
                'village_code'      => $village_code
            )));
            $result = curl_exec($curl_handle);
            $results = json_decode($result);
            // echo "<pre>";
            // var_dump($results);
            $service_type=null;
            if(isset($results)){
            $data_rows = $results->data_results;
                foreach($data_rows as $rows){
                    if($rows->service_code == '1'){
                        $view_link = '<a href='.base_url().'index.php/rtps/inheritanceBasuCO?app='.$rows->application_no.' class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View</a>';
                        if($rows->is_omut=='Y'){
                            $service_type='<kbd>Office Mutation</kbd>';
                        }
                    }else if($rows->service_code == '2'){
                        $view_link = '<a href='.base_url().'index.php/rtps/deedBasuCO?app='.$rows->application_no.' class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View</a>';
                        if($rows->is_omut=='Y'){
                            $service_type='<kbd>Office Mutation</kbd>';
                        }
                    }else if($rows->service_code == '5'){
                        $view_link = '<a href='.base_url().'index.php/rtps/allotmentBasuCO?app='.$rows->application_no.' class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View</a>';
                    }else if($rows->service_code == '3'){
                        $view_link = '<a href='.base_url().'index.php/rtps/partitionBasuCO?app='.$rows->application_no.' class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View</a>';
                        if($rows->is_omut=='Y'){
                            $service_type='<kbd>Office Partition</kbd>';
                        }
                    }else if($rows->service_code == '9'){
                        $view_link = '<a href='.base_url().'index.php/rtps/conversionBasuCO?app='.$rows->application_no.' class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View</a>';
                    }else if($rows->service_code == '4'){
                        $view_link = '<a href='.base_url().'index.php/rtps/reclassBasuCO?app='.$rows->application_no.' class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View</a>';
                    }else if($rows->service_code == '7'){
                        $view_link = '<a href='.base_url().'index.php/rtps/areaCorrectionbasuCO?app='.$rows->application_no.' class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View</a>';
                    }else if($rows->service_code == '6'){
                        $view_link = '<a href='.base_url().'index.php/rtps/nameCorrectionbasuCO?app='.$rows->application_no.' class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View</a>';
                    }else if($rows->service_code == '8'){
                        $view_link = '<a href='.base_url().'index.php/rtps/nameCancelbasuCO?app='.$rows->application_no.' class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View</a>';
                    }else if(($rows->service_code == '10') && ($rows->pending_with_officer=='CO')){
                        $view_link = '<a href='.base_url().'index.php/rtps/mobileUpdationBasu?app='.$rows->application_no.' class="btn btn-sm btn-primary"><i class="fa fa-arrow-right"></i> Forward</a>';
                    }else if(($rows->service_code == '10') && ($rows->pending_with_officer=='NA' || $rows->pending_with_officer=='Approved' || $rows->pending_with_officer=='F') && $rows->status=='F'){
                        $view_link = 'Order Passed';
                    }else{
                        $view_link = '--';
                    }

                    if (($rows->pending_with_officer=='NA' || $rows->pending_with_officer=='Approved' || $rows->pending_with_officer=='F') && $rows->status=='F')
                    {
                        $category = $rows->pending_with_officer." - Delivered";
                    }
                    else if ($rows->pending_with_officer =='NA' && $rows->status='R' )
                    {
                       $category = $rows->pending_with_officer." - Rejected"; 
                    }
                    else if($rows->status=='Q')
                    {
                        if($rows->pending_with_officer=='LM'){
                            $rows->pending_with_officer='LRA';
                        }
                        else if($rows->pending_with_officer=='SK'){
                            $rows->pending_with_officer='LRS';
                        }

                        else
                        {
                            $rows->pending_with_officer=$rows->pending_with_officer;
                        }

                        $category = $rows->pending_with_officer." - Query Sent";
                    } 
                    else 
                    {
                        if($rows->pending_with_officer=='LM'){
                            $rows->pending_with_officer='LRA';
                        }
                        else if($rows->pending_with_officer=='SK'){
                            $rows->pending_with_officer='LRS';
                        }

                        else
                        {
                            $rows->pending_with_officer=$rows->pending_with_officer;
                        }
                        
                        $category = $rows->pending_with_officer." - Pending"; 
                    }

                    $json[] = array(
                        '<span class="px-3"><strong>'.$rows->application_no.'</strong></span>',
                        $rows->date_submission,
                        $rows->service."<br>".$service_type,
                        $rows->rurban. " - ".$this->utilityclass->getVillageName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_code,$rows->lot_no,$rows->village_code),
                        $this->utilityclass->getMouzaName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_code). " - ".$this->utilityclass->getLotName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_code,$rows->lot_no),
                        $category,
                        $view_link,
                    );
                }
                $total_records = $results->total_records;
                $response = array(
                    'draw'              => $draw,
                    'recordsTotal'      => $total_records,
                    'recordsFiltered'   => $total_records,
                    'data'              => $json
                );
                echo json_encode($response);
            }else{
                $response = array();
                $response['sEcho']=0;
                $response['iTotalRecords']=0;
                $response['iTotalDisplayRecords']=0;
                $response['aaData']=[];
                echo json_encode($response);
            }
        }
    function requestCircle($service){
        //var_dump($_SESSION);
        $this->load->model('rtps/rtpsmodel');
        $d=$this->session->userdata('dist_code');
        $s=$this->session->userdata('subdiv_code');
        $c=$this->session->userdata('cir_code');
        $m=$this->session->userdata('mouza_pargona_code');
        $data['dist_code'] = $d;
        $data['subdiv_code'] = $s;
        $data['cir_code'] = $c;
        $data['service_code'] = $service;
        $apiData = $this->rtpsmodel->allVilageAndStatus($d,$s,$c,$service);
        $data['pending'] = $apiData->location;
        $villageList = array();
        foreach ($data['pending'] as $key => $value) {
            $villageList[$key]['village_code'] = $value->mouza_code."-".$value->lot_no."-".$value->village_code;
            $villageList[$key]['vill_name'] = $this->utilityclass->getVillageName($value->dist_code,$value->subdiv_code,$value->cir_code,$value->mouza_code,$value->lot_no,$value->village_code);
            $villageList[$key]['rurban'] = $value->is_urban == 'Y' ? 'Urban' : 'Rural';
         }
        $uniqueVillage = array_map("unserialize", array_unique(array_map("serialize", $villageList)));
        $data['villageList'] =  $uniqueVillage;
        $mouzaList = array();
        foreach ($data['pending'] as $key => $value) {
            $mouzaList[$key]['mouza_code'] = $value->mouza_code;
            $mouzaList[$key]['mouza_name'] = $this->utilityclass->getMouzaName($value->dist_code,$value->subdiv_code,$value->cir_code,$value->mouza_code);
            $mouzaList[$key]['lot_name'] = $this->utilityclass->getLotName($value->dist_code,$value->subdiv_code,$value->cir_code,$value->mouza_code,$value->lot_no);
            $mouzaList[$key]['lot_no'] = $value->lot_no;
         }
        $uniqueMouza = array_map("unserialize", array_unique(array_map("serialize", $mouzaList)));
        $data['mouzaList'] =  $uniqueMouza;
        $category = array();
        $data['pending'] = $apiData->status;
        foreach ($data['pending'] as $key => $value) {
            if (($value->pending_with_officer=='NA' || $value->pending_with_officer=='Approved' || $value->pending_with_officer=='F') && $value->status=='F')
            {
                $category[$key]['off'] = $value->pending_with_officer;
                $category[$key]['st'] = 'Delivered';
                $category[$key]['sts'] = 'F';

            }
            else if ($value->pending_with_officer =='NA' && $value->status='R')
            {
               $category[$key]['off'] = $value->pending_with_officer;
                $category[$key]['st'] = 'Rejected'; 
                $category[$key]['sts'] = 'R';
            }
            else if($value->status=='Q'){
                $category[$key]['off'] = $value->pending_with_officer;
                $category[$key]['st'] = 'Query Sent';
                $category[$key]['sts'] = 'Q';
            } 
            else {
                $category[$key]['off'] = $value->pending_with_officer;
                $category[$key]['st'] = 'Pending'; 
                $category[$key]['sts'] = null;
            }
         }
        $unique = array_map("unserialize", array_unique(array_map("serialize", $category)));
        $data['category'] =  $unique;
        $data['title'] = 'Application List';
        $data['_view'] = 'rtps/new_pagination';
        $this->load->view('layouts/main',$data);
    }

    function pre_post_validate($validate_in_db,$validate_pattadar_data,$validate_chitha_location_data,$validate_chitha_area_data_barak,$validate_chitha_area_data_bramha,$application_no)
    {      
            $pattadar_exists=$this->rtpsmodel->pre_post_validate_pattadar($validate_in_db,$validate_pattadar_data);
            $msg='';
            $location_data='';
            //echo $pattadar_exists;
           // $pattadar_exists=0;
            if($pattadar_exists==1)
                    {
                    // Do not do anything validation successfull, let it be.
                    }
                    else if( $pattadar_exists==0)
                    {
                        //log_message('error', "#ERRFPART006: Pattadar doesn't exist.".$application_no);
                        $msg =  $msg. "#ERRFPART006: Pattadar doesn't exist : <br>"; 
                    }
                    else if( $pattadar_exists==-1)
                    {
                        log_message('error', "#ERRFPART007: Unknown error occurred.".$application_no);
                        $msg =  $msg."#ERRFPART007: unknown error occurred : <br>";                  
                    }
                    else if( $pattadar_exists==-2)
                    {
                        log_message('error', "#ERRFPART008: Please check the pattadar exisitance validation inputs.".$application_no);
                        $msg =  $msg."#ERRFPART008: Please check the pattadar exisitance validation inputs : <br>";  
                    }
                    
                    if(!empty($validate_chitha_area_data_barak) and sizeof($validate_chitha_area_data_barak)>1)
                    {
                        $total_lessa='';
                        $location_data ='';
                        $total_applied_lessa='';
                        $location_data=$this->rtpsmodel->getChithaAreaPreValidation($validate_in_db,$validate_chitha_location_data[0]);
                        $total_applied_lessa = ( $validate_chitha_area_data_barak['dag_area_b'] * 6400) + ( $validate_chitha_area_data_barak['dag_area_k'] * 320) + ($validate_chitha_area_data_barak['dag_area_lc'] * 20) + $validate_chitha_area_data_barak['dag_area_g'];
                        $total_lessa =( $location_data['bigha'] * 6400) + ( $location_data['katha'] * 320) + ($location_data['lessa'] * 20) + $location_data['ganda'];
                        if(floor($total_applied_lessa)==0)
                        {
                            $msg =  $msg."#ERRFPART010: Applied area not specified correclty : <br>"; 
                        }
                        if(floor($total_applied_lessa) > floor($total_lessa))
                        {
                            //log_message('error', "#ERRFPART009: Applied area is more then chitha area.".$application_no);
                            $msg =  $msg."#ERRFPART009: Applied area is more then chitha area. : <br>";  
                        }
                        else
                        {
                            return 1;
                        }
                    }
                    if(!empty($validate_chitha_area_data_bramha) and sizeof($validate_chitha_area_data_bramha)>1)
                    {
                        $total_lessa='';
                        $location_data ='';
                        $total_applied_lessa='';
                        $location_data=$this->rtpsmodel->getChithaAreaPreValidation($validate_in_db,$validate_chitha_location_data[0]);
                        $total_applied_lessa =  ( $validate_chitha_area_data_bramha['area_b'] * 100) + ( $validate_chitha_area_data_bramha['area_k'] * 20) +  $validate_chitha_area_data_bramha['area_l'];                    
                        $total_lessa = ($location_data['bigha'] * 100) + ($location_data['katha'] * 20) + $location_data['lessa'];
                        if(floor($total_applied_lessa)==0)
                        {
                            $msg =  $msg."#ERRFPART010: Applied area not specified correclty : <br>"; 
                        }
                        if(floor($total_applied_lessa) > floor($total_lessa))
                        {
                            //log_message('error', "#ERRFPART009: Applied area is more then chitha area.".$application_no);
                            $msg =  $msg."#ERRFPART010: Applied area is more then chitha area. : <br>"; 
                        }
                        else
                        {
                            return 1;
                        }
                    }
                    
                    if(isset($msg))
                    {
                      return $msg;
                    }
                    else
                    {
                      return 1;
                    } 

    }

    
    function pre_post_only_area_validate($validate_in_db,$validate_chitha_location_data,$validate_chitha_area_data_barak,$validate_chitha_area_data_bramha)
    {     
            $msg='';
            $location_data='';        

                    if(!empty($validate_chitha_area_data_barak) )
                    {
                        $total_lessa='';
                        $location_data ='';
                        $total_applied_lessa='';
                        $location_data=$this->rtpsmodel->getChithaAreaPreValidation($validate_in_db,$validate_chitha_location_data[0]);
                        $total_applied_lessa = ( $validate_chitha_area_data_barak['dag_area_b'] * 6400) + ( $validate_chitha_area_data_barak['dag_area_k'] * 320) + ($validate_chitha_area_data_barak['dag_area_lc'] * 20) + $validate_chitha_area_data_barak['dag_area_g'];
                        $total_lessa =( $location_data['bigha'] * 6400) + ( $location_data['katha'] * 320) + ($location_data['lessa'] * 20) + $location_data['ganda'];
                        if(floor($total_applied_lessa) > floor($total_lessa))
                        {
                            //log_message('error', "#ERRFPART009: Applied area is more then chitha area.".$application_no);
                            $msg =  $msg."#ERRFPART009: Applied area is more then chitha area. . Please update the area to proceed: <br>";  
                        }
                        else
                        {
                            return 1;
                        }
                    }
                    if(!empty($validate_chitha_area_data_bramha) )
                    {
                        $total_lessa='';
                        $location_data ='';
                        $total_applied_lessa='';
                        $location_data=$this->rtpsmodel->getChithaAreaPreValidation($validate_in_db,$validate_chitha_location_data[0]);
                        $total_applied_lessa =  ( $validate_chitha_area_data_bramha['area_b'] * 100) + ( $validate_chitha_area_data_bramha['area_k'] * 20) +  $validate_chitha_area_data_bramha['area_l'];                    
                        $total_lessa = ($location_data['bigha'] * 100) + ($location_data['katha'] * 20) + $location_data['lessa'];

                        if(floor($total_applied_lessa) > floor($total_lessa))
                        {
                            //log_message('error', "#ERRFPART009: Applied area is more then chitha area.".$application_no);
                            $msg =  $msg."#ERRFPART010: Applied area is more then available chitha area. Please update the area to proceed: <br>"; 
                        }
                        else
                        {
                            return 1;
                        }
                    }
                    
                    if(isset($msg) and $msg!=1)
                    {
                      return $msg;
                    }
                    else
                    {
                      return 1;
                    } 

    }

    function inheritanceBasuMultiSingleGen(){
        if(MULTIGENERATION_ACTIVE == 1){
            $application_no = $this->input->get('app');
            $url = RTPS_API_LINK."serviceResponseMultiGen?application_no=" . $application_no ;
            $output = sendCurlRequest($url);
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, $url);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
            // $output = curl_exec($ch);
            // curl_close($ch);
            $output = json_decode($output);
            
            // echo "<pre>";
            // var_dump($output);
            // die;
            $district['app']=$output->application;
            $district['selfDecData'] = null;
            $district['aadhaarData'] = null;
            $district['aadhaarPhoto'] = null;
            $aadharData = null;
            if(isset($output->selfDeclaration) && !empty($output->selfDeclaration)){
                $district['selfDecData'] = json_decode($output->selfDeclaration[0]->dec_details);
            }
            foreach ($output->mutation as $key => $value) {
                if($value->auth_type !=null){
                    $aadharData = $value;
                }
                continue;
            }
            if(isset($aadharData) && !empty($aadharData)){
                $district['aadhaarData'] = $aadharData;
            }
            if(isset($output->photo) && $output->photo != null){
                $district['aadhaarPhoto'] = $output->photo;
            }
            // $district['app']->dag_no;die;
            $dagArray = explode(',',$district['app']->dag_no);
            // var_dump($dagArray);
            // die;
            foreach ($dagArray as $key => $value) {
                $landArea = $this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$value); 
                // var_dump($landArea);die;
                $landArea->dag_no = $value;
                $dagArray[$key] = $landArea;
            } 
            $district['landAreaInfo'] = $dagArray; 
            // echo "<pre>";
            // var_dump($district['landAreaInfo']);die;
            $district['firstParty']=$output->mutation;
            $district['other_properties']=$output->other_properties;
            $allApplicant = $output->allApplicant;
            
            $district['tree'] =null;
            $district['owner_pattadar'] =null;
            $district['generation_type'] = null;
            if($district['app']->is_multigeneration == "M"){
                $url1 = RTPS_API_LINK."treeApi?application_no=" . $application_no ;
                $treeOutput = sendCurlRequest($url1);
                // $chTree = curl_init();
                // curl_setopt($chTree, CURLOPT_URL, $url1);
                // curl_setopt($chTree, CURLOPT_RETURNTRANSFER, 1);
                // curl_setopt($chTree, CURLOPT_SSL_VERIFYPEER, FALSE);
                // curl_setopt($chTree, CURLOPT_SSL_VERIFYHOST,  2);
                // $treeOutput = curl_exec($chTree);
                // curl_close($chTree);
                $treeOutput = json_decode($treeOutput,true);
                if(!empty($treeOutput)){
                    $district['tree']=$treeOutput['tree'];
                    $district['owner_pattadar'] = $treeOutput['owner_pattadar'];
                    $district['generation_type'] = $treeOutput['generation_type'];
                }
                
            }
            $district['secParty']=$output->applicants;
            $district['document']=$output->documents;
            $district['query']=$output->query;
            $district['user']=$this->rtpsmodel->usersForOffice($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code);
            $district['mut_type']=$this->utilityclass->mutType('i');
            if(($district['app']->dist_code!=$this->session->userdata('dist_code')) || ($district['app']->subdiv_code!=$this->session->userdata('subdiv_code')) || ($district['app']->cir_code!=$this->session->userdata('cir_code')) )
            {
                redirect('/home');
            }
            if($this->session->userdata('user_desig_code')=='AST'){
                $district['_view'] = 'rtps/inheritance_ofc_multigen';
            }elseif($this->session->userdata('user_desig_code')=='CO' or $this->session->userdata('user_desig_code')=='ADC'){
                $district['_view'] = 'rtps/inheritance_co_revert_multigen';
            }else{
                $district['_view'] = 'rtps/inheritance_multigen';
            }

            // ///////////////////////////////////////////// property chain code //////////////////////////////////////////
            // if(count($dagArray) == 1)
            // {
            //     if(ENABLED_BLOCKCHAIN == 1 && in_array($district['app']->dist_code,json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
            //     {
                    
            //         $this->load->model('propChain/PropChainModel');
            //         // checking if chitha data and property chain data mathches
            //         $checkPropAndChitha =  $this->PropChainModel->chainChithaUlpinCheckProcess($district['app']->dist_code,  $district['app']->subdiv_code, $district['app']->cir_code, $district['app']->mouza_code, $district['app']->lot_no, $district['app']->village_code, $district['pattaNo']->patta_no, $district['app']->dag_no, $district['pattaNo']->dag_area_b, $district['pattaNo']->dag_area_k, $district['pattaNo']->dag_area_lc, $district['pattaNo']->dag_area_g, $district['pattaNo']->patta_type_code);

            //         // var_dump($pattadars);
            //         $district['chithaPropChainCmpFlag'] = $checkPropAndChitha['chithaPropChainCmpFlag'];
            //         $district['compareFlagMsg'] = $checkPropAndChitha['compareFlagMsg'];
            //         $district['ulpinCheck'] = $checkPropAndChitha['ulpinCheck'];
            //         // hidden fields
            //         $district['ulpin_hidden'] = $checkPropAndChitha['ulpin_hidden'];
            //         $district['uplpin_msg_hidden'] = $checkPropAndChitha['uplpin_msg_hidden'];
            //         $district['compare_hidden'] = $checkPropAndChitha['compare_hidden'];
            //         $district['compare_msg_hidden'] = $checkPropAndChitha['compare_msg_hidden'];

            //         // bhunaksha area cmp
            //         $district['bhuChithaCmpStatus'] = $checkPropAndChitha['bhuChithaCmpStatus'];
            //         $district['bhuChithaCmpMsg'] = $checkPropAndChitha['bhuChithaCmpMsg'];
            //         $district['bhu_hidden'] = $checkPropAndChitha['bhu_hidden'];
            //         $district['bhu_compare_msg_hidden'] = $checkPropAndChitha['bhu_compare_msg_hidden'];
            //     }

            // }
        
        $this->load->view('layouts/main',$district);
        }
        
    }

    ///Inheritance Single Generation Multiple or Single Dag post--------
    function inheritancePostSingleGeneration(){
        // $allow_lm_part = true;
        // if($allow_lm_part){
        //     $data = array(
        //         'error' => "#ERRORMULTIGEN8580 : Not Allowed..."
        //     );
        //     echo json_encode($data);
        //     exit;
        // }


        // XSS validation start
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }

        $resp = checkRequestValidQuery($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }

        if($errorMessageStr != ''){
            $data = array(
                'error' => $errorMessageStr
            );
            echo json_encode($data);
            exit;
        }
        // XSS validation end

        $mut_type = $this->input->post('mut_type');
        if($mut_type == ''){
            $data = array(
                'error' => 'Please select the transfer type'
            );
            echo json_encode($data);
            exit;
        }
        
        if(MULTIGENERATION_ACTIVE == 1){
            $application_no = $_POST['application_no'];
            //////////////////
            $recordExist = $this->rtpsmodel->checkExistDharitree($application_no);
            if($recordExist){
                    $data = array(
                        'error' => "Case have been Registered Already. Please Check"
                    );
                    echo json_encode($data);
                    exit;
            }
            /////////////////////
            $url = RTPS_API_LINK."serviceResponseMultiGen?application_no=" . $application_no ;
            $output = sendCurlRequest($url);
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, $url);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            //     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
            // $output = curl_exec($ch);
            // curl_close($ch);
            $output = json_decode($output);
            
            $data['app']=$output->application;
            $data['other_properties'] = $output->other_properties;
            $dagArray = explode(',',$data['app']->dag_no);
            foreach ($dagArray as $key => $value) {
                $landArea = $this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$value); 
                $landArea->dag_no = $value;
                $dagArray[$key] = $landArea;
            } 
            $data['landAreaInfo'] = $dagArray;
            $data['pattaNo']    = $data['app']->patta_no;
            $data['firstParty'] = $output->mutation;
            $data['secParty']   = $output->applicants;
            if(($data['app']->dist_code!=$this->session->userdata('dist_code')) || ($data['app']->subdiv_code!=$this->session->userdata('subdiv_code')) || ($data['app']->cir_code!=$this->session->userdata('cir_code')) || ($data['app']->mouza_code!=$this->session->userdata('mouza_pargona_code')) || ($data['app']->lot_no!=$this->session->userdata('lot_no')) )
            {
                $data=array(
                    'error'=>"Please reload the page. Session might be Destroyed."
                );
                echo json_encode($data);
                return false;
                exit;
            }

            $dist_code = $data['app']->dist_code;
            $this->db->trans_begin();
            //$case_no=$this->rtpsmodel->genearteCaseNo('01');
            $case_name=$this->rtpsmodel->genearteCaseName();
             if(empty($case_name)){
                $data = array(
                    'error' => "Network Issue or Session Out. Please try Again"
                );
                echo json_encode($data);
                exit;
                die();
            }
            // $case_no['petition_no']=$petition_no=$this->rtpsmodel->genearteFieldPetitionNo();

            // $case_no['case_no']=$case_name.$petition_no."/FMUT";

            $seq_pet = year_no.'00';
            $case_no['petition_no'] = $petition_no=$seq_pet.$this->rtpsmodel->genearteFieldPetitionNo();
            $case_no['case_no'] = $case_name.$petition_no."/FMUT";

            $basic = array(
                'dist_code'=>$data['app']->dist_code,
                'subdiv_code'=>$data['app']->subdiv_code,
                'cir_code'=>$data['app']->cir_code,
                'mouza_pargona_code'=>$data['app']->mouza_code,
                'lot_no'=>$data['app']->lot_no,
                'vill_townprt_code'=>$data['app']->village_code,
                'user_code'=>$this->session->userdata('user_code'),
                'date_entry'=>date('Y-m-d'),
                'case_no'=>$case_no['case_no'],
                'trans_code'=>$this->input->post('mut_type'),
                'dispute_yn'=>0,
                'possession_yn'=>$this->input->post('possession'),
                'petition_no'=>$case_no['petition_no'],
                'year_no'=>date('Y'),
                'report_date'=>date('Y-m-d'),
                'mut_type'=>'01',                    
                'operation'=>'E',
                'user_code'=>$this->session->userdata('user_code'),
                'is_multigeneration' => $data['app']->is_multigeneration,
            );
            $insFieldBasicFMUTI = $this->db->insert('field_mut_basic',$basic);
            if($insFieldBasicFMUTI != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRFMULMUTI001: Insertion failed in field_mut_basic for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRFMULMUTI001: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
            //////Buyer Insert////////////
            $i=1;
            $file = null;
            $onlyForMultiGenPDarId = null;
            foreach($data['firstParty'] as $pet){
                if($data['app']->is_multigeneration == "M"){
                    $onlyForMultiGenPDarId = $pet->pdar_id;
                }else{
                    $onlyForMultiGenPDarId = null;
                }
                
                if($pet->is_applicant == '1'){  
                    if(!empty($output->selfDeclaration[0]->dec_details)){
                        $dec = $output->selfDeclaration[0]->dec_details;
                    }else{
                        $dec = null;
                    }
                    $auth_type = $pet->auth_type;
                    $id_ref_no = $pet->id_ref_no;
                    if($pet->auth_type =='AADHAAR'){
                        $uploadpath   = AADHAAR_UPLOAD_DIR;
                        $imagebase64  = $output->photo;
                        $file         = $uploadpath . $pet->id_ref_no . '.json';
                        file_put_contents($file, $imagebase64);
                    }
                    $photo = $file;
                }else{
                    $dec= null;
                    $auth_type = null;
                    $id_ref_no = null;
                    $photo = null;
                }
                $faddress=$this->address($pet->address);
                $buyerInsert = array(
                    'dist_code'=>$data['app']->dist_code,
                    'subdiv_code'=>$data['app']->subdiv_code,
                    'cir_code'=>$data['app']->cir_code,
                    'mouza_pargona_code'=>$data['app']->mouza_code,
                    'lot_no'=>$data['app']->lot_no,
                    'vill_townprt_code'=>$data['app']->village_code,
                    'user_code'=>$this->session->userdata('user_code'),
                    'date_entry'=>date('Y-m-d'),
                    'case_no'=>$case_no['case_no'],
                    'petition_no'=>$case_no['petition_no'],
                    'year_no'=>date('Y'),
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
                    'new_pet_name'=>$pet->chitha_pdar_id>0?null:'N',
                    'pdar_id'=>$pet->chitha_pdar_id>0?$pet->chitha_pdar_id:$onlyForMultiGenPDarId,
                    'self_declaration' => $dec,
                    'auth_type' => $auth_type,
                    'id_ref_no'=> $id_ref_no,
                    'photo'              => $photo,
                    'pdar_name_eng'=>$pet->pat_name_eng,
                    'pdar_guard_eng'=>$pet->pat_gurdian_name_eng,
                    //newly added for maintating relation----------
                    'generation_type'    => $pet->gen,
                    'next_of_pdar_id' => $pet->next_of_pdar_id,
                    'marital_status' => $pet->marital_status,
                    'applicant_occupation' => $pet->applicant_occupation,
                    'caste_category' => $pet->caste_category,
                    'tribe_category' => $pet->tribe_category ?? NULL,
                );
                $insFieldPetFMUTI = $this->db->insert('field_mut_petitioner', $buyerInsert);
                if($insFieldPetFMUTI != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRFMUTI002: Insertion failed in field_mut_petitioner for RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRFMUTI002: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
            }
            ////////Seller Insert//////////
            foreach($data['secParty'] as $pet){
                //////////////////////////////////
                if($pet->gurdian_name_ass == '' || $pet->gurdian_name_ass == null){
                    $pet_father_name = $this->getGuardianName($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->village_code,$data['app']->lot_no,$pet->dag_no,$this->input->post('patta_no'),$this->input->post('patta_type'),$pet->chitha_pdar_id);
                    if($pet_father_name->num_rows() <= 0){
                        $this->db->trans_rollback();
                        $data=array(
                            'error'=>"Error in submitting.Gurdian Name is Missing. Please try Again"
                        ); 
                        echo json_encode($data);
                        return;   
                    }else{
                        $pet->gurdian_name_ass = trim($pet_father_name->row()->pdar_father);
                    }

                }else{
                    $pet->gurdian_name_ass=$pet->gurdian_name_ass;
                }
                ///////////////////////////
                $sellerInsert = array(
                    'dist_code'=>$data['app']->dist_code,
                    'subdiv_code'=>$data['app']->subdiv_code,
                    'cir_code'=>$data['app']->cir_code,
                    'mouza_pargona_code'=>$data['app']->mouza_code,
                    'lot_no'=>$data['app']->lot_no,
                    'vill_townprt_code'=>$data['app']->village_code,
                    'user_code'=>$this->session->userdata('user_code'),
                    'date_entry'=>date('Y-m-d'),
                    'case_no'=>$case_no['case_no'],
                    'petition_no'=>$case_no['petition_no'],
                    'year_no'=>date('Y'),
                    'operation'=>'E',
                    'dag_no'=>$pet->dag_no,
                    'patta_no'=>$this->input->post('patta_no') ,
                    'patta_type_code'  => $this->input->post('patta_type') ,
                    'pdar_id' => $pet->chitha_pdar_id,
                    'pdar_cron_no' => $pet->chitha_pdar_id,
                    'pdar_name' => $pet->name_ass,
                    'pdar_guardian'=>$pet->gurdian_name_ass,
                    'pdar_rel_guar' =>'u',//$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->gurdian_relation_id),/////////////
                    'pdar_gender'=>'m',//$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->gender),
                    'striked_out' =>1,/////for inheritance//////,
                    'generation_type'    => $pet->gen,
                );
                //var_dump($sellerInsert);
                $insFieldPattaFMUTI = $this->db->insert('field_mut_pattadar', $sellerInsert);
                if($insFieldPattaFMUTI != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRFMUTI003: Insertion failed in field_mut_pattadar for RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRFMUTI003: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
            }

            // Other Property Insertion
            if(count($data['other_properties'])){
                $other_properties = [];
                foreach($data['other_properties'] as $other_property_frm_rtps){
                    // $other_properties[] = [
                    $other_property = [
                        'case_no' => $case_no['case_no'],
                        'dist_code' => $other_property_frm_rtps->dist_code,
                        'subdiv_code' => $other_property_frm_rtps->subdiv_code,
                        'cir_code' => $other_property_frm_rtps->cir_code,
                        'mouza_pargona_code' => $other_property_frm_rtps->mouza_pargona_code,
                        'lot_no' => $other_property_frm_rtps->lot_no,
                        'vill_townprt_code' => $other_property_frm_rtps->vill_townprt_code,
                        'bigha' => $other_property_frm_rtps->bigha,
                        'katha' => $other_property_frm_rtps->katha,
                        'lessa' => $other_property_frm_rtps->lessa,
                        'chatak' => $other_property_frm_rtps->chatak,
                        'ganda' => $other_property_frm_rtps->ganda,
                        'kranti' => $other_property_frm_rtps->kranti,
                        'entry_date' => date('Y-m-d H:i:s'),
                        'is_rural' => $other_property_frm_rtps->is_rural,
                        'dag_no' => $other_property_frm_rtps->dag_no,
                        'patta_no' => $other_property_frm_rtps->patta_no,
                        'service_id' => $other_property_frm_rtps->service_id,
                        'identity_type' => NULL,
                        'identity_ref_no' => $other_property_frm_rtps->ref_no,
                        'applid' => $application_no,
                        'dist_name' => trim($other_property_frm_rtps->dist_name),
                        'cir_name' => trim($other_property_frm_rtps->cir_name),
                        'vill_name' => trim($other_property_frm_rtps->vill_name),
                        'applied_flag' => 1,
                        'entered_by' => $this->session->userdata('user_code'),
                        'enable_status' => 1,
                        'is_landless' => NULL,
                    ];

                    $this->db->insert('mut_additional_properties', $other_property); 
                    if ($this->db->affected_rows() <= 0)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRMUTADDLPROP0001: Insertion failed in mut_additional_properties for RTPS Case No '.$application_no . ' Last query => ' . $this->db->last_query());
                        $data = array(
                            'error'=> "#ERRMUTADDLPROP0001: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }

                // $this->db->insert_batch('mut_additional_properties', $other_properties); 

                // if ($this->db->affected_rows() <= 0)
                // {
                //     $this->db->trans_rollback();
                //     log_message('error', '#ERRMUTADDLPROP0001: Insertion failed in mut_additional_properties for RTPS Case No '.$application_no . ' Last query => ' . $this->db->last_query());
                //     $data = array(
                //         'error'=> "#ERRMUTADDLPROP0001: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                //     );
                //     echo json_encode($data);
                //     return false;
                // }
            }

            $applied_dag_list = $this->input->post('dag_no_list');
            $mut_area_b = $this->input->post('mut_area_b');
            $mut_area_k = $this->input->post('mut_area_k');
            $mut_area_l = $this->input->post('mut_area_l');
            $mut_area_g = $this->input->post('mut_area_g');
            for ($i=0; $i < count($applied_dag_list) ; $i++) { 

                $landArea = $this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$applied_dag_list[$i]); 


                if(in_array($dist_code, json_decode(BARAK_VALLEY))){
                    $dag_area_g = $landArea->dag_area_g==null?"0":$landArea->dag_area_g;
                    $dag_area_kr = $landArea->dag_area_kr==null?"0":$landArea->dag_area_kr;
                }else{
                    $dag_area_g = 0;
                    $dag_area_kr = 0;
                }
                $dagDetails=array(
                    'dist_code'=>$data['app']->dist_code,
                    'subdiv_code'=>$data['app']->subdiv_code,
                    'cir_code'=>$data['app']->cir_code,
                    'mouza_pargona_code'=>$data['app']->mouza_code,
                    'lot_no'=>$data['app']->lot_no,
                    'vill_townprt_code'=>$data['app']->village_code,
                    'user_code'=>$this->session->userdata('user_code'),
                    'date_entry'=>date('Y-m-d'),
                    'case_no'=>$case_no['case_no'],
                    'petition_no'=>$case_no['petition_no'],
                    'year_no'=>date('Y'),
                    'operation'=>'E',
                    'dag_no'=>$applied_dag_list[$i],
                    'patta_no'=>$this->input->post('patta_no'),
                    'patta_type_code'  => $this->input->post('patta_type'),
                    'm_dag_area_b' => $mut_area_b[$i],
                    'm_dag_area_k' => $mut_area_k[$i],
                    'm_dag_area_lc'=> $mut_area_l[$i],
                    'm_dag_area_g' => $mut_area_g[$i],
                    'm_dag_area_kr'=> 0,
                    'dag_area_b'   => $landArea->dag_area_b,
                    'dag_area_k'   => $landArea->dag_area_k,
                    'dag_area_lc'  => $landArea->dag_area_lc,  
                    'dag_area_g'   => $dag_area_g,  
                    'dag_area_kr'  => $dag_area_kr,
                    'remark' =>addslashes(trim($_POST['remark']))
                );
                $insFiledDagFMUTI = $this->db->insert('field_mut_dag_details',$dagDetails);
                if($insFiledDagFMUTI != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRFMUTI004: Insertion failed in field_mut_dag_details for RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRFMUTI004: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
            }

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
                        
                    }
                    else{
                        $data=array(
                            'error' => 'File is required'
                        );
                        echo json_encode($data);
                        return false;
                    }
                }
            }
            ///////////////////Insert attached file////////////////////////
            if(isset($_FILES['fileUpload']['name'])){
                for($i = 0; $i < $fileCount; $i++)
                {
                    $_FILES['file']['name'] = $_FILES['fileUpload']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['fileUpload']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['fileUpload']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['fileUpload']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['fileUpload']['size'][$i];
                    $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                    $exp  = explode("/",$mime);
                    $onlyExtension  = $exp[1];
                    $replaceCase=str_replace("/","-",$case_no['case_no']);
                    $fileRename =  $replaceCase."-".time() . '.' . $onlyExtension;
                    $config['upload_path']   = MANUAL_ATTACHMENT;
                    $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                    $config['max_size']  = ALLOWED_UPLOAD_FILE_SIZE;
                    $config['file_name'] = $fileRename;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file'))
                    {
                        $document= array(
                            'case_no'   => $case_no['case_no'],
                            'file_name' => $_POST['fileText'][$i],
                            'user_code' => $this->session->userdata('user_code'),
                            // 'fetch_file_name' => $_FILES['file']['name'],
                            'fetch_file_name' => $_POST['fileText'][$i],
                            'file_type'  => $_FILES['file']['type'],
                            'file_path'  => MANUAL_ATTACHMENT . $fileRename,
                            'date_entry' => date('Y-m-d h:i:s'),
                            'mut_type'   => 'FM',
                        );
                        // save data in attachment file
                        $addMoreDocQuery = $this->db->insert('supportive_document',$document);
                        if($addMoreDocQuery != 1)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRADDDOC0006: Insertion failed in supportive document RTPS Case No '.$case_no['case_no']);
                            $data=array(
                                'error' => "#ERRADDDOC0006: Registration of Settlement failed for case no : ".$case_no['case_no']
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }
                    else
                    {
                        $this->db->trans_rollback();
                        // todo error show
                        // redirect to respected route with error mgs
                        log_message('error', '#ERRADDDOC0007: Insertion failed in supportive document RTPS Case No '.$case_no['case_no']);
                        $data=array(
                            'error' => "#ERRADDDOC0007: Registration of Settlement failed for case no : ".$case_no['case_no']
                        );
                        echo json_encode($data);
                        return false;
    
                    }
                }
            }
        

            $recordExistinFieldMutBasic=$this->rtpsmodel->checkExistCaseInFieldMutBasic($case_no['case_no']);
            if($recordExistinFieldMutBasic){
                $basundhara=array(
                    'dharitree'=>$case_no['case_no'],
                    'basundhara'=>$application_no,
                    'date_reg'=>date('Y-m-d'),
                    'reg_by'=>$this->session->userdata('user_code'),
                    'app_status'=>'P',
                    'pending_with'=>'CO'
                );
                $insBasuFMUTI = $this->db->insert('basundhar_application',$basundhara);
                if($insBasuFMUTI != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRFMUTI005: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRFMUTI005: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }  
            }
                
                
                if($this->db->trans_status()==FALSE){
                    $this->db->trans_rollback();
                    $data=array(
                        'error'=>"Error in submitting. Please try Again"
                    );
                    echo json_encode($data);
                    return false;
                }else{

                    $all_row_updated = $this->updateCaseIdForNok($application_no, $case_no['case_no']);
                    if(!$all_row_updated){
                        log_message('error', '#ERRFMUTSINGGENNOK001: Failed update nok for RTPS Case No '.$application_no . ' Last Query => ' . $this->db->last_query());
                        $this->db->trans_rollback();
                        $data = array(
                            'error'=>"#ERRFMUTSINGGENNOK001: Registration of Field Mutation by Deed failed for case no : ".$application_no
                        );

                        return response_json($data);
                    }
                       
                    //////////////POST To rtps/////////////////////
                    $url = RTPS_API_LINK."applicationStatusUpdate";
                    $post_array = [
                        'application' => $application_no,
                        'dharitree' => $case_no['case_no'],
                        'rmk' => 'all ok',
                        'status' => 'M',
                        'task' => 'LRA',
                        'pen'=>'CO'
                    ];
                    $result = sendCurlRequest($url, 'POST', $post_array);

                    // $curl_handle = curl_init();
                    // curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."applicationStatusUpdate");
                    // curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                    // curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                    // curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
                    // curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                    // curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    //     'application' => $application_no,
                    //     'dharitree' => $case_no['case_no'],
                    //     'rmk' => 'all ok',
                    //     'status' => 'M',
                    //     'task' => 'LM',
                    //     'pen'=>'CO'
                    // )));
                    // $result = curl_exec($curl_handle);
                    ////////////////////////////////
                     if($result===true || $result=='true' || $result==1 || json_decode($result)=='true'|| json_decode($result)==true || json_decode($result)=='y' || $result=='y'){
                        $this->db->trans_commit();
                    }else{
                        $this->db->trans_rollback();
                        $data=array(
                            'error'=>"Error in submitting. Please try Again"
                        );
                        echo json_encode($data);
                        return false;
                    }            
                    $this->DashboardPartitionField($case_no['case_no']);
                    $this->session->set_flashdata('message',"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no] ");
                    //////////////////////////////////
                    $data=array(
                        'success'=>"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no]",
                        'redirect_url'=>base_url().'index.php/home'
                    );
                }
            echo json_encode($data);
        }
    }
    ///end------------

    ///Inheritance multigeneration post--------
    function inheritancePostMultiGeneration(){


        // $allow_lm_part = 1;
        // if($allow_lm_part == 1){
        //     $data = array(
        //         'error' => "#ERRORMULTIGEN9059 : Not Allowed..."
        //     );
        //     echo json_encode($data);
        //     exit;
        // }


        // XSS validation start
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }

        $resp = checkRequestValidQuery($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }

        if($errorMessageStr != ''){
            $data = array(
                'error' => $errorMessageStr
            );
            echo json_encode($data);
            exit;
        }
        // XSS validation end

        if(MULTIGENERATION_ACTIVE == 1){
            $application_no=$_POST['application_no'];
            //////////////////
            $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
            if($recordExist){
                    $data=array(
                        'error'=>"Case have been Registered Already. Please Check"
                    );
                    echo json_encode($data);
                    exit;
            }
            /////////////////////
            $url = RTPS_API_LINK."serviceResponseMultiGen?application_no=" . $application_no ;
            $output = sendCurlRequest($url);
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, $url);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            //     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
            // $output = curl_exec($ch);
            // curl_close($ch);
            $output = json_decode($output);
            $data['app']=$output->application;
            $data['other_properties'] = $output->other_properties;
            $dagArray = explode(',',$data['app']->dag_no);
            foreach ($dagArray as $key => $value) {
                $landArea = $this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$value); 
                $landArea->dag_no = $value;
                $dagArray[$key] = $landArea;
            } 
            $data['landAreaInfo'] = $dagArray;
            $data['pattaNo']    = $data['app']->patta_no;
            $data['firstParty'] = $output->mutation;
            $data['secParty']   = $output->applicants;
            if(($data['app']->dist_code!=$this->session->userdata('dist_code')) || ($data['app']->subdiv_code!=$this->session->userdata('subdiv_code')) || ($data['app']->cir_code!=$this->session->userdata('cir_code')) || ($data['app']->mouza_code!=$this->session->userdata('mouza_pargona_code')) || ($data['app']->lot_no!=$this->session->userdata('lot_no')) )
            {
                $data=array(
                    'error'=>"Please reload the page. Session might be Destroyed."
                );
                echo json_encode($data);
                return false;
                exit;
            }

            $dist_code = $data['app']->dist_code;
            $this->db->trans_begin();
            //$case_no=$this->rtpsmodel->genearteCaseNo('01');
            $case_name=$this->rtpsmodel->genearteCaseName();
             if(empty($case_name)){
                $data=array(
                    'error'=>"Network Issue or Session Out. Please try Again"
                );
                echo json_encode($data);
                exit;
                die();
            }
            // $case_no['petition_no']=$petition_no=$this->rtpsmodel->genearteFieldPetitionNo();

            // $case_no['case_no']=$case_name.$petition_no."/FMUT";

            $seq_pet = year_no.'00';
            $case_no['petition_no'] = $petition_no=$seq_pet.$this->rtpsmodel->genearteFieldPetitionNo();
            $case_no['case_no'] = $case_name.$petition_no."/FMUT";
            
            $basic=array(
                'dist_code'=>$data['app']->dist_code,
                'subdiv_code'=>$data['app']->subdiv_code,
                'cir_code'=>$data['app']->cir_code,
                'mouza_pargona_code'=>$data['app']->mouza_code,
                'lot_no'=>$data['app']->lot_no,
                'vill_townprt_code'=>$data['app']->village_code,
                'user_code'=>$this->session->userdata('user_code'),
                'date_entry'=>date('Y-m-d'),
                'case_no'=>$case_no['case_no'],
                'trans_code'=>$this->input->post('mut_type'),
                'dispute_yn'=>0,
                'possession_yn'=>$this->input->post('possession'),
                'petition_no'=>$case_no['petition_no'],
                'year_no'=>date('Y'),
                'report_date'=>date('Y-m-d'),
                'mut_type'=>'01',                    
                'operation'=>'E',
                'user_code'=>$this->session->userdata('user_code'),
                'is_multigeneration' => $data['app']->is_multigeneration,

            );
            $insFieldBasicFMUTI = $this->db->insert('field_mut_basic',$basic);
            if($insFieldBasicFMUTI != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRFMUTI001: Insertion failed in field_mut_basic for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRFMUTI001: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
            //////Buyer Insert////////////
            $i=1;
            $file = null;
            foreach($data['firstParty'] as $pet){
                if($pet->is_applicant == '1'){  
                    if(!empty($output->selfDeclaration[0]->dec_details)){
                        $dec = $output->selfDeclaration[0]->dec_details;
                    }else{
                        $dec = null;
                    }
                    $auth_type = $pet->auth_type;
                    $id_ref_no = $pet->id_ref_no;
                    if($pet->auth_type =='AADHAAR'){
                        $uploadpath   = AADHAAR_UPLOAD_DIR;
                        $imagebase64  = $output->photo;
                        $file         = $uploadpath . $pet->id_ref_no . '.json';
                        file_put_contents($file, $imagebase64);
                    }
                    $photo = $file;
                }else{
                    $dec= null;
                    $auth_type = null;
                    $id_ref_no = null;
                    $photo = null;
                }
                $faddress=$this->address($pet->address);
                $buyerInsert = array(
                    'dist_code'=>$data['app']->dist_code,
                    'subdiv_code'=>$data['app']->subdiv_code,
                    'cir_code'=>$data['app']->cir_code,
                    'mouza_pargona_code'=>$data['app']->mouza_code,
                    'lot_no'=>$data['app']->lot_no,
                    'vill_townprt_code'=>$data['app']->village_code,
                    'user_code'=>$this->session->userdata('user_code'),
                    'date_entry'=>date('Y-m-d'),
                    'case_no'=>$case_no['case_no'],
                    'petition_no'=>$case_no['petition_no'],
                    'year_no'=>date('Y'),
                    'operation'=>'E',
                    'pet_name' => $pet->pat_name_ass,
                    'guard_name' => $pet->pat_gurdian_name_ass,
                    'guard_rel' =>$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->pat_gurdian_rel_id),/////////////
                    'pet_gender'=>$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->pat_gender),
                    //'add1' => $pet->address,
                    'add1' => $faddress[0],
                    'add2' => $faddress[1],
                    // 'pet_id' => $i++,
                    'pet_id' => $pet->pdar_id_multigen,
                    'pdar_mobile'=>$pet->pat_mobile_no,
                    'new_pet_name'=>$pet->chitha_pdar_id>0?null:'N',
                    'pdar_id'=>$pet->chitha_pdar_id>0?$pet->chitha_pdar_id:null,
                    'self_declaration' => $dec,
                    'auth_type' => $auth_type,
                    'id_ref_no'=> $id_ref_no,
                    'photo'=> $photo,
                    'pdar_name_eng'=>$pet->pat_name_eng,
                    'pdar_guard_eng'=>$pet->pat_gurdian_name_eng,
                    'generation_type'    => $pet->gen,
                    'next_of_pdar_id' => $pet->next_of_pdar_id,
                    //newly added for maintating relation----------
                    'marital_status' => $pet->marital_status,
                    'applicant_occupation' => $pet->applicant_occupation,
                    'caste_category' => $pet->caste_category,
                    'tribe_category' => $pet->tribe_category ?? NULL,
                );
                $insFieldPetFMUTI = $this->db->insert('field_mut_petitioner', $buyerInsert);
                if($insFieldPetFMUTI != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRFMUTI002: Insertion failed in field_mut_petitioner for RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRFMUTI002: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
            }
            ////////Seller Insert//////////
            foreach($data['secParty'] as $pet){
                //////////////////////////////////
                if($pet->gurdian_name_ass == '' || $pet->gurdian_name_ass == null){
                    $pet_father_name = $this->getGuardianName($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->village_code,$data['app']->lot_no,$pet->dag_no,$this->input->post('patta_no'),$this->input->post('patta_type'),$pet->chitha_pdar_id);
                    if($pet_father_name->num_rows() <= 0){
                        $this->db->trans_rollback();
                        $data=array(
                            'error'=>"Error in submitting.Gurdian Name is Missing. Please try Again"
                        ); 
                        echo json_encode($data);
                        return;   
                    }else{
                        $pet->gurdian_name_ass = trim($pet_father_name->row()->pdar_father);
                    }

                }else{
                    $pet->gurdian_name_ass=$pet->gurdian_name_ass;
                }
                ///////////////////////////
                $sellerInsert = array(
                    'dist_code'=>$data['app']->dist_code,
                    'subdiv_code'=>$data['app']->subdiv_code,
                    'cir_code'=>$data['app']->cir_code,
                    'mouza_pargona_code'=>$data['app']->mouza_code,
                    'lot_no'=>$data['app']->lot_no,
                    'vill_townprt_code'=>$data['app']->village_code,
                    'user_code'=>$this->session->userdata('user_code'),
                    'date_entry'=>date('Y-m-d'),
                    'case_no'=>$case_no['case_no'],
                    'petition_no'=>$case_no['petition_no'],
                    'year_no'=>date('Y'),
                    'operation'=>'E',
                    'dag_no'=>$pet->dag_no,
                    'patta_no'=>$this->input->post('patta_no') ,
                    'patta_type_code'  => $this->input->post('patta_type') ,
                    'pdar_id' => $pet->chitha_pdar_id,
                    'pdar_cron_no' => $pet->chitha_pdar_id,
                    'pdar_name' => $pet->name_ass,
                    'pdar_guardian'=>$pet->gurdian_name_ass,
                    'pdar_rel_guar' =>'u',//$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->gurdian_relation_id),/////////////
                    'pdar_gender'=>'m',//$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->gender),
                    'striked_out' =>1,/////for inheritance//////
                    'generation_type' => $pet->gen
                );
                //var_dump($sellerInsert);
                $insFieldPattaFMUTI = $this->db->insert('field_mut_pattadar', $sellerInsert);
                if($insFieldPattaFMUTI != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRFMUTI003: Insertion failed in field_mut_pattadar for RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRFMUTI003: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
            }

            // Other Property Insertion
            if(count($data['other_properties'])){
                $other_properties = [];
                foreach($data['other_properties'] as $other_property_frm_rtps){
                    // $other_properties[] = [
                    $other_property = [
                        'case_no' => $case_no['case_no'],
                        'dist_code' => $other_property_frm_rtps->dist_code,
                        'subdiv_code' => $other_property_frm_rtps->subdiv_code,
                        'cir_code' => $other_property_frm_rtps->cir_code,
                        'mouza_pargona_code' => $other_property_frm_rtps->mouza_pargona_code,
                        'lot_no' => $other_property_frm_rtps->lot_no,
                        'vill_townprt_code' => $other_property_frm_rtps->vill_townprt_code,
                        'bigha' => $other_property_frm_rtps->bigha,
                        'katha' => $other_property_frm_rtps->katha,
                        'lessa' => $other_property_frm_rtps->lessa,
                        'chatak' => $other_property_frm_rtps->chatak,
                        'ganda' => $other_property_frm_rtps->ganda,
                        'kranti' => $other_property_frm_rtps->kranti,
                        'entry_date' => date('Y-m-d H:i:s'),
                        'is_rural' => $other_property_frm_rtps->is_rural,
                        'dag_no' => $other_property_frm_rtps->dag_no,
                        'patta_no' => $other_property_frm_rtps->patta_no,
                        'service_id' => $other_property_frm_rtps->service_id,
                        'identity_type' => NULL,
                        'identity_ref_no' => $other_property_frm_rtps->ref_no,
                        'applid' => $application_no,
                        'dist_name' => trim($other_property_frm_rtps->dist_name),
                        'cir_name' => trim($other_property_frm_rtps->cir_name),
                        'vill_name' => trim($other_property_frm_rtps->vill_name),
                        'applied_flag' => 1,
                        'entered_by' => $this->session->userdata('user_code'),
                        'enable_status' => 1,
                        'is_landless' => NULL,
                    ];

                    $this->db->insert('mut_additional_properties', $other_property); 
                    if ($this->db->affected_rows() <= 0)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRMUTADDLPROP0002: Insertion failed in mut_additional_properties for RTPS Case No '.$application_no . ' Last query => ' . $this->db->last_query());
                        $data = array(
                            'error'=> "#ERRMUTADDLPROP0002: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }

                // $this->db->insert_batch('mut_additional_properties', $other_properties); 

                // if ($this->db->affected_rows() <= 0)
                // {
                //     $this->db->trans_rollback();
                //     log_message('error', '#ERRMUTADDLPROP0001: Insertion failed in mut_additional_properties for RTPS Case No '.$application_no . ' Last query => ' . $this->db->last_query());
                //     $data = array(
                //         'error'=> "#ERRMUTADDLPROP0001: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                //     );
                //     echo json_encode($data);
                //     return false;
                // }
            }

            foreach ($dagArray as $key => $value) {
                if(in_array($dist_code, json_decode(BARAK_VALLEY))){
                    $dag_area_g = $value->dag_area_g==null?"0":$value->dag_area_g;
                    $dag_area_kr = $value->dag_area_kr==null?"0":$value->dag_area_kr;
                }else{
                    $dag_area_g = 0;
                    $dag_area_kr = 0;
                }
                $dagDetails=array(
                    'dist_code'=>$data['app']->dist_code,
                    'subdiv_code'=>$data['app']->subdiv_code,
                    'cir_code'=>$data['app']->cir_code,
                    'mouza_pargona_code'=>$data['app']->mouza_code,
                    'lot_no'=>$data['app']->lot_no,
                    'vill_townprt_code'=>$data['app']->village_code,
                    'user_code'=>$this->session->userdata('user_code'),
                    'date_entry'=>date('Y-m-d'),
                    'case_no'=>$case_no['case_no'],
                    'petition_no'=>$case_no['petition_no'],
                    'year_no'=>date('Y'),
                    'operation'=>'E',
                    'dag_no'=>$value->dag_no,
                    'patta_no'=>$this->input->post('patta_no'),
                    'patta_type_code'  => $this->input->post('patta_type'),
                    // 'm_dag_area_b' => $_POST['mut_area_b'],
                    // 'm_dag_area_k' => $_POST['mut_area_k'],
                    // 'm_dag_area_lc'=> $_POST['mut_area_l'],
                    // 'm_dag_area_g' => $_POST['mut_area_g'],
                    'm_dag_area_b' => $value->dag_area_b,
                    'm_dag_area_k' => $value->dag_area_k,
                    'm_dag_area_lc'=> $value->dag_area_lc,
                    'm_dag_area_g' => $value->dag_area_g,
                    'm_dag_area_kr'=> 0,
                    'dag_area_b'   => $value->dag_area_b,
                    'dag_area_k'   => $value->dag_area_k,
                    'dag_area_lc'  => $value->dag_area_lc,  
                    'dag_area_g'   => $dag_area_g,  
                    'dag_area_kr'  => $dag_area_kr,
                    'remark' =>addslashes(trim($_POST['remark']))
                    );
                $insFiledDagFMUTI = $this->db->insert('field_mut_dag_details',$dagDetails);
                if($insFiledDagFMUTI != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRFMUTI004: Insertion failed in field_mut_dag_details for RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRFMUTI004: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
            }

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
                        
                    }
                    else{
                        $data=array(
                            'error' => 'File is required'
                        );
                        echo json_encode($data);
                        return false;
                    }
                }
            }
            ///////////////////Insert attached file////////////////////////
            if(isset($_FILES['fileUpload']['name'])){
                for($i = 0; $i < $fileCount; $i++)
                {
                    $_FILES['file']['name'] = $_FILES['fileUpload']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['fileUpload']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['fileUpload']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['fileUpload']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['fileUpload']['size'][$i];
                    $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                    $exp  = explode("/",$mime);
                    $onlyExtension  = $exp[1];
                    $replaceCase=str_replace("/","-",$case_no['case_no']);
                    $fileRename =  $replaceCase."-".time() . '.' . $onlyExtension;
                    $config['upload_path']   = MANUAL_ATTACHMENT;
                    $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                    $config['max_size']  = ALLOWED_UPLOAD_FILE_SIZE;
                    $config['file_name'] = $fileRename;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file'))
                    {
                        $document= array(
                            'case_no'   => $case_no['case_no'],
                            'file_name' => $_POST['fileText'][$i],
                            'user_code' => $this->session->userdata('user_code'),
                            // 'fetch_file_name' => $_FILES['file']['name'],
                            'fetch_file_name' => $_POST['fileText'][$i],
                            'file_type'  => $_FILES['file']['type'],
                            'file_path'  => MANUAL_ATTACHMENT . $fileRename,
                            'date_entry' => date('Y-m-d h:i:s'),
                            'mut_type'   => 'FM',
                        );
                        // save data in attachment file
                        $addMoreDocQuery = $this->db->insert('supportive_document',$document);
                        if($addMoreDocQuery != 1)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRADDDOC0008: Insertion failed in supportive document RTPS Case No '.$case_no['case_no']);
                            $data=array(
                                'error' => "#ERRADDDOC0008: Registration of Settlement failed for case no : ".$case_no['case_no']
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }
                    else
                    {
                        $this->db->trans_rollback();
                        // todo error show
                        // redirect to respected route with error mgs
                        log_message('error', '#ERRADDDOC0005: Insertion failed in supportive document RTPS Case No '.$case_no['case_no']);
                        $data=array(
                            'error' => "#ERRADDDOC0005: Registration of Settlement failed for case no : ".$case_no['case_no']
                        );
                        echo json_encode($data);
                        return false;
    
                    }
                }
            }

                $basundhara=array(
                    'dharitree'=>$case_no['case_no'],
                    'basundhara'=>$application_no,
                    'date_reg'=>date('Y-m-d'),
                    'reg_by'=>$this->session->userdata('user_code'),
                    'app_status'=>'P',
                    'pending_with'=>'CO'
                );
                $insBasuFMUTI = $this->db->insert('basundhar_application',$basundhara);
                if($insBasuFMUTI != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRFMUTI005: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRFMUTI005: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
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
                    return false;
                }else{
                       
                    //////////////POST To rtps/////////////////////
                    $url = RTPS_API_LINK."applicationStatusUpdate";
                    $post_array = [
                        'application' => $application_no,
                        'dharitree' => $case_no['case_no'],
                        'rmk' => 'all ok',
                        'status' => 'M',
                        'task' => 'LM',
                        'pen'=>'CO'
                    ];
                    $result = sendCurlRequest($url, 'POST', $post_array);
                    // $curl_handle = curl_init();
                    // curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."applicationStatusUpdate");
                    // curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                    // curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                    // curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
                    // curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                    // curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    //     'application' => $application_no,
                    //     'dharitree' => $case_no['case_no'],
                    //     'rmk' => 'all ok',
                    //     'status' => 'M',
                    //     'task' => 'LM',
                    //     'pen'=>'CO'
                    // )));
                    // $result = curl_exec($curl_handle);
                    ////////////////////////////////
                     if($result===true || $result=='true' || $result==1 || json_decode($result)=='true'|| json_decode($result)==true || json_decode($result)=='y' || $result=='y'){
                        $this->db->trans_commit();
                    }else{
                        $this->db->trans_rollback();
                        $data=array(
                            'error'=>"Error in submitting. Please try Again"
                        );
                        echo json_encode($data);
                        return false;
                    }            
                    $this->DashboardPartitionField($case_no['case_no']);
                    $this->session->set_flashdata('message',"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no] ");
                    //////////////////////////////////
                    $data=array(
                        'success'=>"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no]",
                        'redirect_url'=>base_url().'index.php/home'
                    );
                }
            echo json_encode($data);
        }
    }
    ///end------------

    /////////////////Office Inheritance Mutation/////////////////////////
    function inheritancePostOfficeSingleGeneration(){
        // XSS validation start
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }

        $resp = checkRequestValidQuery($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }

        if($errorMessageStr != ''){
            $data = array(
                'error' => $errorMessageStr
            );
            echo json_encode($data);
            exit;
        }
        // XSS validation end

        if(MULTIGENERATION_ACTIVE == 1){
            $application_no=$_POST['application_no'];
            //////////////////
            $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
            if($recordExist){
                    $data=array(
                        'error'=>"Case have been Registered Already. Please Check"
                    );
                    echo json_encode($data);
                    exit;
            }
            /////////////////////
            $url = RTPS_API_LINK."serviceResponseMultiGen?application_no=" . $application_no ;
            $output = sendCurlRequest($url);
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, $url);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            //     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
            // $output = curl_exec($ch);
            // curl_close($ch);
            $output = json_decode($output);
            $data['app']=$output->application;
            $data['other_properties'] = $output->other_properties;

            $dagArray = explode(',',$data['app']->dag_no);
            foreach ($dagArray as $key => $value) {
                $landArea = $this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$value); 
                $landArea->dag_no = $value;
                $dagArray[$key] = $landArea;
            } 
            $data['landAreaInfo'] = $dagArray;
            $data['pattaNo']    = $data['app']->patta_no;




            // $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$data['app']->dag_no);
            
            $data['firstParty']=$output->mutation;
            $data['secParty']=$output->applicants;
            //var_dump($data);
            $dist_code = $data['app']->dist_code;
            // if(in_array($dist_code, json_decode(BARAK_VALLEY))){
            //     $dag_area_g = $data['pattaNo']->dag_area_g==null?"0":$data['pattaNo']->dag_area_g;
            //     $dag_area_kr = $data['pattaNo']->dag_area_kr==null?"0":$data['pattaNo']->dag_area_kr;
            // }
            // else{
            //     $dag_area_g = 0;
            //     $dag_area_kr = 0;
            // }

            $this->db->trans_begin();
            //$case_no=$this->rtpsmodel->genearteOfcCaseNo('03');
            $case_name=$this->rtpsmodel->genearteCaseName();        
             if(empty($case_name)){
                $data=array(
                    'error'=>"Network Issue or Session Out. Please try Again"
                );
                echo json_encode($data);
                exit;
                die();
            }
            // $case_no['petition_no']=$petition_no=$this->rtpsmodel->genearteOfficePetitionNo();
            // $case_no['case_no']=$case_name.$petition_no."/OMUT";

            $seq_pet=year_no.'00';
            $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteOfficePetitionNo();
            $case_no['case_no']=$case_name.$petition_no."/OMUT";


            $basic=array(
                'dist_code'         =>$data['app']->dist_code,
                'subdiv_code'       =>$data['app']->subdiv_code,
                'cir_code'          =>$data['app']->cir_code,
                'mouza_pargona_code'=>$data['app']->mouza_code,
                'lot_no'            =>$data['app']->lot_no,
                'vill_townprt_code' =>$data['app']->village_code,
                'user_code'         =>$this->session->userdata('user_code'),
                'date_entry'        =>date('Y-m-d'),
                'case_no'           =>$case_no['case_no'],
                'mut_type'          =>'03', /////mut type
                'trans_code'        =>'01',/////////for inheritance
                'petition_no'       =>$case_no['petition_no'],
                'year_no'           =>date('Y'),
                'date_entry'        => date('Y-m-d G:i:s'),                 
                'operation'         =>'E',
                'user_code'         =>$this->session->userdata('user_code'),
                'submission_date'   => date('Y-m-d G:i:s'),
                'add_off_name'      => $_POST['add_of_name'],
                'is_multigeneration'=> $data['app']->is_multigeneration,
                ///////// 
            );
            $insPetBasic = $this->db->insert('petition_basic',$basic);
            if($insPetBasic != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERROMUTIS001: Insertion failed in petition_basic RTPS Case No '.$application_no . ' Last Query => ' . $this->db->last_query());
                $data = array(
                    'error'=>"#ERROMUTIS001: Registration of Office Mutation by Inheritance failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
            //////Buyer Insert////////////
            $i=1;
            foreach($data['firstParty'] as $pet){

                if($pet->is_applicant == '1'){  
                    if(!empty($output->selfDeclaration[0]->dec_details)){
                        $dec = $output->selfDeclaration[0]->dec_details;
                    }else{
                        $dec = null;
                    }
                    $auth_type = $pet->auth_type;
                    $id_ref_no = $pet->id_ref_no;
                    if($pet->auth_type =='AADHAAR'){
                        $uploadpath   = AADHAAR_UPLOAD_DIR;
                        $imagebase64  = $output->photo;
                        $file         = $uploadpath . $pet->id_ref_no . '.json';
                        file_put_contents($file, $imagebase64);
                    }
                    $photo = $file;
                }else{
                    $dec= null;
                    $auth_type = null;
                    $id_ref_no = null;
                    $photo = null;
                }


                $faddress=$this->address($pet->address);
                $buyerInsert = array(
                    'dist_code'         =>$data['app']->dist_code,
                    'subdiv_code'       =>$data['app']->subdiv_code,
                    'cir_code'          =>$data['app']->cir_code,
                    'mouza_pargona_code'=>$data['app']->mouza_code,
                    'lot_no'            =>$data['app']->lot_no,
                    'vill_townprt_code' =>$data['app']->village_code,
                    'petition_no'       =>$case_no['petition_no'],
                    'year_no'           =>date('Y'),
                    'operation'         =>'E',
                    'pet_name'          => $pet->pat_name_ass,
                    'guard_name'        => $pet->pat_gurdian_name_ass,
                    'pdar_name_eng'     => $pet->pat_name_eng,
                    'pdar_guard_eng'    => $pet->pat_gurdian_name_eng,
                    // 'guard_rel' => 'f', //////////////////////to be update
                    // 'pet_gender'=>$pet->pat_gender,
                    'guard_rel'         =>$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->pat_gurdian_rel_id),/////////////
                    'pet_gender'        =>$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->pat_gender),
                    'pet_id'            => $i++,
                    //'add1' => $pet->address,
                    'add1'              => $faddress[0],
                    'add2'              => $faddress[1],
                    'user_code'         => $this->session->userdata('user_code'),
                    'date_entry'        => date('Y-m-d G:i:s'),
                    'operation'         => 'E',
                    'new_pattadar'      => 'N',
                    'pet_minor_dob'     => date('Y-m-d G:i:s',strtotime($pet->dob)),
                    'pdar_mobile'       => $pet->pat_mobile_no,
                    'applied_b'         =>0,
                    'applied_k'         => 0,
                    'applied_lc'        => 0,
                    'applied_g'         => 0,
                    'applied_kr'        => 0,
                    'self_declaration' => $dec,
                    'auth_type'        => $auth_type,
                    'id_ref_no'        => $id_ref_no,
                    'photo'            => $photo,
                    //newly added for maintating relation----------
                    'generation_type'    => $pet->gen,
                    // Added by Abhijit -- 2024-02-29
                    'pdar_id'          => $pet->pdar_id,
                    'next_of_pdar_id'  => $pet->next_of_pdar_id,
                    'marital_status' => $pet->marital_status,
                    'applicant_occupation' => $pet->applicant_occupation,
                    'caste_category' => $pet->caste_category,
                    'tribe_category' => $pet->tribe_category ?? NULL,
                );
                $insPetitioner = $this->db->insert('petitioner', $buyerInsert);
                if($insPetitioner != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROMUTIS002: Insertion failed in petitioner for RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERROMUTIS002: Registration of Office Mutation by Inheritance failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
            }
            $cron_no=1;
            foreach($data['secParty'] as $pet){
                $sellerInsert = array(
                    'dist_code'         =>$data['app']->dist_code,
                    'subdiv_code'       =>$data['app']->subdiv_code,
                    'cir_code'          =>$data['app']->cir_code,
                    'mouza_pargona_code'=>$data['app']->mouza_code,
                    'lot_no'            =>$data['app']->lot_no,
                    'vill_townprt_code' =>$data['app']->village_code,
                    'user_code'         =>$this->session->userdata('user_code'),
                    'petition_no'       =>$case_no['petition_no'],
                    'year_no'           =>date('Y'),
                    'operation'         =>'E',
                    'dag_no'            =>$pet->dag_no,
                    'patta_no'          =>$this->input->post('patta_no') ,
                    'patta_type_code'   => $this->input->post('patta_type') ,
                    'pdar_id'           => $pet->chitha_pdar_id,
                    'pdar_cron_no'      => $pet->chitha_pdar_id,
                    'pdar_name'         => $pet->name_ass,
                    'pdar_guardian'     =>$pet->gurdian_name_ass,
                    'pdar_rel_guar'     => 'f',
                    'striked_out'       =>1,/////for inheritance//////
                    'patta_no'          => $_POST['patta_no'],
                    'patta_type_code'   => $_POST['patta_type'],
                    'pdar_id'           =>  $pet->chitha_pdar_id,
                    'pdar_cron_no'      => $cron_no++,
                    'pdar_name'         => $pet->name_ass,
                    'pdar_guardian'     => $pet->gurdian_name_ass,
                    //'pdar_gender' => 'm',
                    //'pdar_rel_guar' => 'f',
                    'pdar_rel_guar'     =>'u',//$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->gurdian_relation_id),/////////////
                    // 'pet_gender'=>$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->gender),
                    'date_entry'        => date('Y-m-d G:i:s'),
                    'operation'         => 'E',
                    'generation_type'   => $pet->gen
                );
                $insPetPattadar = $this->db->insert('petition_pattadar', $sellerInsert);
                if($insPetPattadar != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROMUTIS003: Insertion failed in petition_pattadar for RTPS Case No '.$application_no  . ' Last Query => ' . $this->db->last_query());
                    $data = array(
                        'error'=>"#ERROMUTIS003: Registration of Office Mutation by Inheritance failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
            }

            // Other Property Insertion
            if(count($data['other_properties'])){
                $other_properties = [];
                foreach($data['other_properties'] as $other_property_frm_rtps){
                    // $other_properties[] = [
                    $other_property = [
                        'case_no' => $case_no['case_no'],
                        'dist_code' => $other_property_frm_rtps->dist_code,
                        'subdiv_code' => $other_property_frm_rtps->subdiv_code,
                        'cir_code' => $other_property_frm_rtps->cir_code,
                        'mouza_pargona_code' => $other_property_frm_rtps->mouza_pargona_code,
                        'lot_no' => $other_property_frm_rtps->lot_no,
                        'vill_townprt_code' => $other_property_frm_rtps->vill_townprt_code,
                        'bigha' => $other_property_frm_rtps->bigha,
                        'katha' => $other_property_frm_rtps->katha,
                        'lessa' => $other_property_frm_rtps->lessa,
                        'chatak' => $other_property_frm_rtps->chatak,
                        'ganda' => $other_property_frm_rtps->ganda,
                        'kranti' => $other_property_frm_rtps->kranti,
                        'entry_date' => date('Y-m-d H:i:s'),
                        'is_rural' => $other_property_frm_rtps->is_rural,
                        'dag_no' => $other_property_frm_rtps->dag_no,
                        'patta_no' => $other_property_frm_rtps->patta_no,
                        'service_id' => $other_property_frm_rtps->service_id,
                        'identity_type' => NULL,
                        'identity_ref_no' => $other_property_frm_rtps->ref_no,
                        'applid' => $application_no,
                        'dist_name' => trim($other_property_frm_rtps->dist_name),
                        'cir_name' => trim($other_property_frm_rtps->cir_name),
                        'vill_name' => trim($other_property_frm_rtps->vill_name),
                        'applied_flag' => 1,
                        'entered_by' => $this->session->userdata('user_code'),
                        'enable_status' => 1,
                        'is_landless' => NULL,
                    ];

                    $this->db->insert('mut_additional_properties', $other_property); 
                    if ($this->db->affected_rows() <= 0)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRMUTADDLPROP0003: Insertion failed in mut_additional_properties for RTPS Case No '.$application_no . ' Last query => ' . $this->db->last_query());
                        $data = array(
                            'error'=> "#ERRMUTADDLPROP0003: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }

                // $this->db->insert_batch('mut_additional_properties', $other_properties); 

                // if ($this->db->affected_rows() <= 0)
                // {
                //     $this->db->trans_rollback();
                //     log_message('error', '#ERRMUTADDLPROP0001: Insertion failed in mut_additional_properties for RTPS Case No '.$application_no . ' Last query => ' . $this->db->last_query());
                //     $data = array(
                //         'error'=> "#ERRMUTADDLPROP0001: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                //     );
                //     echo json_encode($data);
                //     return false;
                // }
            }



            $applied_dag_list = $this->input->post('dag_no_list');
            $mut_area_b       = $this->input->post('mut_area_b');
            $mut_area_k       = $this->input->post('mut_area_k');
            $mut_area_l       = $this->input->post('mut_area_l');
            $mut_area_g       = $this->input->post('mut_area_g');
            for ($i=0; $i < count($applied_dag_list) ; $i++) { 


                $landArea = $this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$applied_dag_list[$i]); 


                if(in_array($dist_code, json_decode(BARAK_VALLEY))){
                    $dag_area_g = $landArea->dag_area_g==null?"0":$landArea->dag_area_g;
                    $dag_area_kr = $landArea->dag_area_kr==null?"0":$landArea->dag_area_kr;
                }else{
                    $dag_area_g = 0;
                    $dag_area_kr = 0;
                }


                $dagDetails=array(
                    'dist_code'     =>$data['app']->dist_code,
                    'subdiv_code'   =>$data['app']->subdiv_code,
                    'cir_code'      =>$data['app']->cir_code,
                    'mouza_pargona_code'=>$data['app']->mouza_code,
                    'lot_no'        =>$data['app']->lot_no,
                    'vill_townprt_code'=>$data['app']->village_code,
                    'user_code'     =>$this->session->userdata('user_code'),
                    'date_entry'    =>date('Y-m-d'),
                    'petition_no'   =>$case_no['petition_no'],
                    'year_no'       =>date('Y'),
                    'operation'     =>'E',
                    'dag_no'        =>$applied_dag_list[$i],
                    'patta_no'      =>$this->input->post('patta_no') ,
                    'patta_type_code'  => $this->input->post('patta_type') ,
                    'm_dag_area_b' => $mut_area_b[$i],
                    'm_dag_area_k' => $mut_area_k[$i],
                    'm_dag_area_lc'=> $mut_area_l[$i],
                    'm_dag_area_g' => $mut_area_g[$i],
                    'm_dag_area_kr'=> 0,
                    'dag_area_b'   => $landArea->dag_area_b,
                    'dag_area_k'   => $landArea->dag_area_k,
                    'dag_area_lc'  => $landArea->dag_area_lc,  
                    'dag_area_g'   => $dag_area_g,  
                    'dag_area_kr'  => $dag_area_kr,
                    );
                $insPetDag = $this->db->insert('petition_dag_details',$dagDetails);
                if($insPetDag != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROMUTIS004: Insertion failed in petition_dag_details for RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERROMUTIS004: Registration of Office Mutation by Inheritance failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
            }

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
                        
                    }
                    else{
                        $this->db->trans_rollback();
                        $data=array(
                            'error' => 'File is required'
                        );
                        echo json_encode($data);
                        return false;
                    }
                }
            }

            ///////////////////Insert attached file////////////////////////
            if(isset($_FILES['fileUpload']['name'])){
                for($i = 0; $i < $fileCount; $i++)
                {
                    $_FILES['file']['name'] = $_FILES['fileUpload']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['fileUpload']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['fileUpload']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['fileUpload']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['fileUpload']['size'][$i];
                    $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                    $exp  = explode("/",$mime);
                    $onlyExtension  = $exp[1];
                    $replaceCase=str_replace("/","-",$case_no['case_no']);
                    $fileRename =  $replaceCase."-".time() . '.' . $onlyExtension;
                    $config['upload_path']   = MANUAL_ATTACHMENT;
                    $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                    $config['max_size']  = ALLOWED_UPLOAD_FILE_SIZE;
                    $config['file_name'] = $fileRename;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file'))
                    {
                        $document= array(
                            'case_no'   => $case_no['case_no'],
                            'file_name' => $_POST['fileText'][$i],
                            'user_code' => $this->session->userdata('user_code'),
                            // 'fetch_file_name' => $_FILES['file']['name'],
                            'fetch_file_name' => $_POST['fileText'][$i],
                            'file_type'  => $_FILES['file']['type'],
                            'file_path'  => MANUAL_ATTACHMENT . $fileRename,
                            'date_entry' => date('Y-m-d h:i:s'),
                            'mut_type'   => 'FM',
                        );
                        // save data in attachment file
                        $addMoreDocQuery = $this->db->insert('supportive_document',$document);
                        if($addMoreDocQuery != 1)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRADDDOC00012: Insertion failed in supportive document RTPS Case No '.$case_no['case_no']);
                            $data=array(
                                'error' => "#ERRADDDOC00012: Registration of Settlement failed for case no : ".$case_no['case_no']
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }
                    else
                    {
                        $this->db->trans_rollback();
                        // todo error show
                        // redirect to respected route with error mgs
                        log_message('error', '#ERRADDDOC0009: Insertion failed in supportive document RTPS Case No '.$case_no['case_no']);
                        $data=array(
                            'error' => "#ERRADDDOC0009: Registration of Settlement failed for case no : ".$case_no['case_no']
                        );
                        echo json_encode($data);
                        return false;
    
                    }
                }
            }
                $basundhara=array(
                    'dharitree'     =>$case_no['case_no'],
                    'basundhara'    =>$application_no,
                    'date_reg'      =>date('Y-m-d'),
                    'reg_by'        =>$this->session->userdata('user_code'),
                    'app_status'    =>'P',
                    'pending_with'  =>'CO'
                );
                $insBasu = $this->db->insert('basundhar_application',$basundhara);
                if($insBasu != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROMUTIS005: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERROMUTIS005: Registration of Office Mutation by Inheritance failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
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
                    //////////////POST To rtps/////////////////////
                    $rmk   ='Forwarded to CO';
                    $status='M';
                    $task='AST';
                    $pen='CO';
                    $case=$case_no['case_no'];
                    $this->rtpsmodel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                    //////////////////
                    
                    $this->DashboardInheritance($case_no['case_no']);

                    $this->session->set_flashdata('message',"Application Forwarded to Circle Officer Successfully with case no ".$case_no['case_no']);
                    //////////////////////////////////
                    $data=array(
                        'success'=>"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no]",
                        'redirect_url'=>base_url().'index.php/home'
                    );
                }
            echo json_encode($data);
        }
    }
    /////////////////Office Inheritance Mutation/////////////////////////

    function inheritancePostOfficeMultiGeneration(){
        // XSS validation start
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }

        $resp = checkRequestValidQuery($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }

        if($errorMessageStr != ''){
            $data = array(
                'error' => $errorMessageStr
            );
            echo json_encode($data);
            exit;
        }
        // XSS validation end

        $application_no=$_POST['application_no'];
        //////////////////
        $recordExist=$this->rtpsmodel->checkExistDharitree($application_no);
        if($recordExist){
                $data=array(
                    'error' => "Case have been Registered Already. Please Check"
                );
                echo json_encode($data);
                exit;
        }
        /////////////////////
        $url = RTPS_API_LINK."serviceResponseMultiGen?application_no=" . $application_no ;
        $output = sendCurlRequest($url);
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        //     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        // $output = curl_exec($ch);
        // curl_close($ch);
        $output = json_decode($output);
        $data['app']=$output->application;
        $data['other_properties'] = $output->other_properties;

        $dagArray = explode(',',$data['app']->dag_no);
        foreach ($dagArray as $key => $value) {
            $landArea = $this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$value); 
            $landArea->dag_no = $value;
            $dagArray[$key] = $landArea;
        } 
        $data['landAreaInfo'] = $dagArray;
        $data['pattaNo']    = $data['app']->patta_no;


        
        


        // $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$data['app']->dag_no);
        
        $data['firstParty']=$output->mutation;
        $data['secParty']=$output->applicants;
        //var_dump($data);
        $dist_code = $data['app']->dist_code;
        if(in_array($dist_code, json_decode(BARAK_VALLEY))){
            $dag_area_g = $data['pattaNo']->dag_area_g==null?"0":$data['pattaNo']->dag_area_g;
            $dag_area_kr = $data['pattaNo']->dag_area_kr==null?"0":$data['pattaNo']->dag_area_kr;
        }
        else{
            $dag_area_g = 0;
            $dag_area_kr = 0;
        }

        $this->db->trans_begin();
        //$case_no=$this->rtpsmodel->genearteOfcCaseNo('03');
        $case_name=$this->rtpsmodel->genearteCaseName();        
         if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Session Out. Please try Again"
            );
            echo json_encode($data);
            exit;
            die();
        }
        // $case_no['petition_no']=$petition_no=$this->rtpsmodel->genearteOfficePetitionNo();
        // $case_no['case_no']=$case_name.$petition_no."/OMUT";
        $seq_pet=year_no.'00';
        $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteOfficePetitionNo();
        $case_no['case_no']=$case_name.$petition_no."/OMUT";
        $basic=array(
            'dist_code'=>$data['app']->dist_code,
            'subdiv_code'=>$data['app']->subdiv_code,
            'cir_code'=>$data['app']->cir_code,
            'mouza_pargona_code'=>$data['app']->mouza_code,
            'lot_no'=>$data['app']->lot_no,
            'vill_townprt_code'=>$data['app']->village_code,
            'user_code'=>$this->session->userdata('user_code'),
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'mut_type'=>'03', /////mut type
            'trans_code'=>'01',/////////for inheritance
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'date_entry' => date('Y-m-d G:i:s'),                 
            'operation'=>'E',
            'user_code'=>$this->session->userdata('user_code'),
            'submission_date' => date('Y-m-d G:i:s'),
            'add_off_name' => $_POST['add_of_name'],
            'is_multigeneration' => $data['app']->is_multigeneration,
            ///////// 
        );
        $insPetBasic = $this->db->insert('petition_basic',$basic);
        if($insPetBasic != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERROMUTIM001: Insertion failed in petition_basic RTPS Case No '.$application_no . ' Last Query => ' . $this->db->last_query());
            $data = array(
                'error'=>"#ERROMUTIM001: Registration of Office Mutation by Inheritance failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }
        //////Buyer Insert////////////
        $i=1;
        foreach($data['firstParty'] as $pet){
            if($pet->is_applicant == '1'){  
                if(!empty($output->selfDeclaration[0]->dec_details)){
                    $dec = $output->selfDeclaration[0]->dec_details;
                }else{
                    $dec = null;
                }
                $auth_type = $pet->auth_type;
                $id_ref_no = $pet->id_ref_no;
                if($pet->auth_type =='AADHAAR'){
                    $uploadpath   = AADHAAR_UPLOAD_DIR;
                    $imagebase64  = $output->photo;
                    $file         = $uploadpath . $pet->id_ref_no . '.json';
                    file_put_contents($file, $imagebase64);
                }
                $photo = $file;
            }else{
                $dec= null;
                $auth_type = null;
                $id_ref_no = null;
                $photo = null;
            }

            $faddress=$this->address($pet->address);
            $buyerInsert = array(
                'dist_code'=>$data['app']->dist_code,
                'subdiv_code'=>$data['app']->subdiv_code,
                'cir_code'=>$data['app']->cir_code,
                'mouza_pargona_code'=>$data['app']->mouza_code,
                'lot_no'=>$data['app']->lot_no,
                'vill_townprt_code'=>$data['app']->village_code,
                'petition_no'=>$case_no['petition_no'],
                'year_no'=>date('Y'),
                'operation'=>'E',
                'pet_name' => $pet->pat_name_ass,
                'guard_name' => $pet->pat_gurdian_name_ass,
                'pdar_name_eng' => $pet->pat_name_eng,
                'pdar_guard_eng' => $pet->pat_gurdian_name_eng,
                // 'guard_rel' => 'f', //////////////////////to be update
                // 'pet_gender'=>$pet->pat_gender,
                'guard_rel' =>$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->pat_gurdian_rel_id),/////////////
                'pet_gender'=>$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->pat_gender),
                'pet_id' => $i++,
                //'add1' => $pet->address,
                'add1' => $faddress[0],
                'add2' => $faddress[1],
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'new_pattadar' => 'N',
                'pet_minor_dob' => date('Y-m-d G:i:s',strtotime($pet->dob)),
                'pdar_mobile' => $pet->pat_mobile_no,
                'applied_b' =>0,
                'applied_k' => 0,
                'applied_lc' => 0,
                'applied_g' => 0,
                'applied_kr' => 0,
                'self_declaration' => $dec,
                'auth_type'        => $auth_type,
                'id_ref_no'        => $id_ref_no,
                'photo'            => $photo,
                //newly added for maintating relation----------
                'generation_type'  => $pet->gen,
                'pdar_id'          => $pet->pdar_id,
                'next_of_pdar_id'  => $pet->next_of_pdar_id,
                // Added by Abhijit -- 2024-02-29
                'marital_status' => $pet->marital_status,
                'applicant_occupation' => $pet->applicant_occupation,
                'caste_category' => $pet->caste_category,
                'tribe_category' => $pet->tribe_category ?? NULL,
            );
            $insPetitioner = $this->db->insert('petitioner', $buyerInsert);
            if($insPetitioner != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERROMUTIM002: Insertion failed in petitioner for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERROMUTIM002: Registration of Office Mutation by Inheritance failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
        }
        $cron_no=1;
        foreach($data['secParty'] as $pet){
            $sellerInsert = array(
                'dist_code'=>$data['app']->dist_code,
                'subdiv_code'=>$data['app']->subdiv_code,
                'cir_code'=>$data['app']->cir_code,
                'mouza_pargona_code'=>$data['app']->mouza_code,
                'lot_no'=>$data['app']->lot_no,
                'vill_townprt_code'=>$data['app']->village_code,
                'user_code'=>$this->session->userdata('user_code'),
                'petition_no'=>$case_no['petition_no'],
                'year_no'=>date('Y'),
                'operation'=>'E',
                'dag_no'=>$pet->dag_no,
                'patta_no'=>$this->input->post('patta_no') ,
                'patta_type_code'  => $this->input->post('patta_type') ,
                'pdar_id' => $pet->chitha_pdar_id,
                'pdar_cron_no' => $pet->chitha_pdar_id,
                'pdar_name' => $pet->name_ass,
                'pdar_guardian'=>$pet->gurdian_name_ass,
                'pdar_rel_guar' => 'f',
                'striked_out' =>1,/////for inheritance//////
                
                'patta_no' => $_POST['patta_no'],
                'patta_type_code' => $_POST['patta_type'],
                'pdar_id' =>  $pet->chitha_pdar_id,
                'pdar_cron_no' => $cron_no++,
                'pdar_name' => $pet->name_ass,
                'pdar_guardian' => $pet->gurdian_name_ass,
                //'pdar_gender' => 'm',
                //'pdar_rel_guar' => 'f',
                'pdar_rel_guar' =>'u',//$this->utilityclass->relationRevertBasu($data['app']->dist_code,$pet->gurdian_relation_id),/////////////
                // 'pet_gender'=>$this->utilityclass->gnderRevertBasu($data['app']->dist_code,$pet->gender),
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'generation_type'    => $pet->gen
            );
            $insPetPattadar = $this->db->insert('petition_pattadar', $sellerInsert);
            if($insPetPattadar != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERROMUTIM003: Insertion failed in petition_pattadar for RTPS Case No '.$application_no . ' Last Query => ' . $this->db->last_query());
                $data = array(
                    'error'=>"#ERROMUTIM003: Registration of Office Mutation by Inheritance failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
        }

        // Other Property Insertion
        if(count($data['other_properties'])){
            $other_properties = [];
            foreach($data['other_properties'] as $other_property_frm_rtps){
                // $other_properties[] = [
                $other_property = [
                    'case_no' => $case_no['case_no'],
                    'dist_code' => $other_property_frm_rtps->dist_code,
                    'subdiv_code' => $other_property_frm_rtps->subdiv_code,
                    'cir_code' => $other_property_frm_rtps->cir_code,
                    'mouza_pargona_code' => $other_property_frm_rtps->mouza_pargona_code,
                    'lot_no' => $other_property_frm_rtps->lot_no,
                    'vill_townprt_code' => $other_property_frm_rtps->vill_townprt_code,
                    'bigha' => $other_property_frm_rtps->bigha,
                    'katha' => $other_property_frm_rtps->katha,
                    'lessa' => $other_property_frm_rtps->lessa,
                    'chatak' => $other_property_frm_rtps->chatak,
                    'ganda' => $other_property_frm_rtps->ganda,
                    'kranti' => $other_property_frm_rtps->kranti,
                    'entry_date' => date('Y-m-d H:i:s'),
                    'is_rural' => $other_property_frm_rtps->is_rural,
                    'dag_no' => $other_property_frm_rtps->dag_no,
                    'patta_no' => $other_property_frm_rtps->patta_no,
                    'service_id' => $other_property_frm_rtps->service_id,
                    'identity_type' => NULL,
                    'identity_ref_no' => $other_property_frm_rtps->ref_no,
                    'applid' => $application_no,
                    'dist_name' => trim($other_property_frm_rtps->dist_name),
                    'cir_name' => trim($other_property_frm_rtps->cir_name),
                    'vill_name' => trim($other_property_frm_rtps->vill_name),
                    'applied_flag' => 1,
                    'entered_by' => $this->session->userdata('user_code'),
                    'enable_status' => 1,
                    'is_landless' => NULL,
                ];

                $this->db->insert('mut_additional_properties', $other_property); 
                if ($this->db->affected_rows() <= 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRMUTADDLPROP0004: Insertion failed in mut_additional_properties for RTPS Case No '.$application_no . ' Last query => ' . $this->db->last_query());
                    $data = array(
                        'error'=> "#ERRMUTADDLPROP0004: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
            }

            // $this->db->insert_batch('mut_additional_properties', $other_properties); 

            // if ($this->db->affected_rows() <= 0)
            // {
            //     $this->db->trans_rollback();
            //     log_message('error', '#ERRMUTADDLPROP0001: Insertion failed in mut_additional_properties for RTPS Case No '.$application_no . ' Last query => ' . $this->db->last_query());
            //     $data = array(
            //         'error'=> "#ERRMUTADDLPROP0001: Registration of Field Mutation by Inheritance failed for case no : ".$application_no
            //     );
            //     echo json_encode($data);
            //     return false;
            // }
        }

        $applied_dag_list = $this->input->post('dag_no_list');
        $mut_area_b = $this->input->post('mut_area_b');
        $mut_area_k = $this->input->post('mut_area_k');
        $mut_area_l = $this->input->post('mut_area_l');
        $mut_area_g = $this->input->post('mut_area_g');
        for ($i=0; $i < count($applied_dag_list) ; $i++) { 


            $landArea = $this->utilityclass->getPattaTypeNo($data['app']->dist_code,$data['app']->subdiv_code,$data['app']->cir_code,$data['app']->mouza_code,$data['app']->lot_no,$data['app']->village_code,$applied_dag_list[$i]); 


            if(in_array($dist_code, json_decode(BARAK_VALLEY))){
                $dag_area_g = $landArea->dag_area_g==null?"0":$landArea->dag_area_g;
                $dag_area_kr = $landArea->dag_area_kr==null?"0":$landArea->dag_area_kr;
            }else{
                $dag_area_g = 0;
                $dag_area_kr = 0;
            }


            $dagDetails=array(
                'dist_code'=>$data['app']->dist_code,
                'subdiv_code'=>$data['app']->subdiv_code,
                'cir_code'=>$data['app']->cir_code,
                'mouza_pargona_code'=>$data['app']->mouza_code,
                'lot_no'=>$data['app']->lot_no,
                'vill_townprt_code'=>$data['app']->village_code,
                'user_code'=>$this->session->userdata('user_code'),
                'date_entry'=>date('Y-m-d'),
                'petition_no'=>$case_no['petition_no'],
                'year_no'=>date('Y'),
                'operation'=>'E',
                'dag_no'=>$applied_dag_list[$i],
                'patta_no'=>$this->input->post('patta_no') ,
                'patta_type_code'  => $this->input->post('patta_type') ,
                'm_dag_area_b' => $mut_area_b[$i],
                'm_dag_area_k' => $mut_area_k[$i],
                'm_dag_area_lc'=> $mut_area_l[$i],
                'm_dag_area_g' => $mut_area_g[$i],
                'm_dag_area_kr'=> 0,
                'dag_area_b'   => $landArea->dag_area_b,
                'dag_area_k'   => $landArea->dag_area_k,
                'dag_area_lc'  => $landArea->dag_area_lc,  
                'dag_area_g'   => $dag_area_g,  
                'dag_area_kr'  => $dag_area_kr,
                );
            $insPetDag = $this->db->insert('petition_dag_details',$dagDetails);
            if($insPetDag != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERROMUTIM004: Insertion failed in petition_dag_details for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERROMUTIM004: Registration of Office Mutation by Inheritance failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
        }

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
                    
                }
                else{
                    $this->db->trans_rollback();
                    $data=array(
                        'error' => 'File is required'
                    );
                    echo json_encode($data);
                    return false;
                }
            }
        }

        ///////////////////Insert attached file////////////////////////
        if(isset($_FILES['fileUpload']['name'])){
            for($i = 0; $i < $fileCount; $i++)
            {
                $_FILES['file']['name'] = $_FILES['fileUpload']['name'][$i];
                $_FILES['file']['type'] = $_FILES['fileUpload']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['fileUpload']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['fileUpload']['error'][$i];
                $_FILES['file']['size'] = $_FILES['fileUpload']['size'][$i];
                $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                $exp  = explode("/",$mime);
                $onlyExtension  = $exp[1];
                $replaceCase=str_replace("/","-",$case_no['case_no']);
                $fileRename =  $replaceCase."-".time() . '.' . $onlyExtension;
                $config['upload_path']   = MANUAL_ATTACHMENT;
                $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                $config['max_size']  = ALLOWED_UPLOAD_FILE_SIZE;
                $config['file_name'] = $fileRename;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('file'))
                {
                    $document= array(
                        'case_no'   => $case_no['case_no'],
                        'file_name' => $_POST['fileText'][$i],
                        'user_code' => $this->session->userdata('user_code'),
                        // 'fetch_file_name' => $_FILES['file']['name'],
                        'fetch_file_name' => $_POST['fileText'][$i],
                        'file_type'  => $_FILES['file']['type'],
                        'file_path'  => MANUAL_ATTACHMENT . $fileRename,
                        'date_entry' => date('Y-m-d h:i:s'),
                        'mut_type'   => 'FM',
                    );
                    // save data in attachment file
                    $addMoreDocQuery = $this->db->insert('supportive_document',$document);
                    if($addMoreDocQuery != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRADDDOC00010: Insertion failed in supportive document RTPS Case No '.$case_no['case_no']);
                        $data=array(
                            'error' => "#ERRADDDOC00010: Registration of Settlement failed for case no : ".$case_no['case_no']
                        );
                        echo json_encode($data);
                        return false;
                    }
                }
                else
                {
                    $this->db->trans_rollback();
                    // todo error show
                    // redirect to respected route with error mgs
                    log_message('error', '#ERRADDDOC00011: Insertion failed in supportive document RTPS Case No '.$case_no['case_no']);
                    $data=array(
                        'error' => "#ERRADDDOC00011: Registration of Settlement failed for case no : ".$case_no['case_no']
                    );
                    echo json_encode($data);
                    return false;

                }
            }
        }
            $basundhara=array(
                'dharitree'=>$case_no['case_no'],
                'basundhara'=>$application_no,
                'date_reg'=>date('Y-m-d'),
                'reg_by'=>$this->session->userdata('user_code'),
                'app_status'=>'P',
                'pending_with'=>'CO'
            );
            $insBasu = $this->db->insert('basundhar_application',$basundhara);
            if($insBasu != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERROMUTIM005: Insertion failed in basundhar_application for RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERROMUTIM005: Registration of Office Mutation by Inheritance failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
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
                //////////////POST To rtps/////////////////////
                $rmk='Forwarded to CO';
                $status='M';
                $task='AST';
                $pen='CO';
                $case=$case_no['case_no'];
                $this->rtpsmodel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                //////////////////
                
                $this->DashboardInheritance($case_no['case_no']);

                $this->session->set_flashdata('message',"Application Forwarded to Circle Officer Successfully with case no ".$case_no['case_no']);
                //////////////////////////////////
                $data=array(
                    'success'=>"Application Forwarded to Circle Officer Successfully with case no $case_no[case_no]",
                    'redirect_url'=>base_url().'index.php/home'
                );
            }
            echo json_encode($data);
    } 

    function inheritanceBasuMultiSingleGenEscalationV1(){
        if(MULTIGENERATION_ACTIVE == 1 && ESCALATION_ENABLE == 1){
            $application_no = $this->input->get('app');
            $url = RTPS_API_LINK."serviceResponseMultiGen?application_no=" . $application_no ;
            $output = sendCurlRequest($url);
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, $url);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
            // $output = curl_exec($ch);
            // curl_close($ch);
            $output = json_decode($output);
            
            // echo "<pre>";
            // var_dump($output);
            // die;
            $district['app']=$output->application;
            $district['selfDecData'] = null;
            $district['aadhaarData'] = null;
            $district['aadhaarPhoto'] = null;
            $aadharData = null;
            if(isset($output->selfDeclaration) && !empty($output->selfDeclaration)){
                $district['selfDecData'] = json_decode($output->selfDeclaration[0]->dec_details);
            }
            foreach ($output->mutation as $key => $value) {
                if($value->auth_type !=null){
                    $aadharData = $value;
                }
                continue;
            }
            if(isset($aadharData) && !empty($aadharData)){
                $district['aadhaarData'] = $aadharData;
            }
            if(isset($output->photo) && $output->photo != null){
                $district['aadhaarPhoto'] = $output->photo;
            }
            // $district['app']->dag_no;die;
            $dagArray = explode(',',$district['app']->dag_no);
            // var_dump($dagArray);
            // die;
            foreach ($dagArray as $key => $value) {
                $landArea = $this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$value); 
                // var_dump($landArea);die;
                $landArea->dag_no = $value;
                $dagArray[$key] = $landArea;
            } 
            $district['landAreaInfo'] = $dagArray; 
            // echo "<pre>";
            // var_dump($district['landAreaInfo']);die;
            $district['firstParty']=$output->mutation;
            $district['other_properties']=$output->other_properties;
            $allApplicant = $output->allApplicant;
            
            $district['tree'] =null;
            $district['owner_pattadar'] =null;
            $district['generation_type'] = null;
            if($district['app']->is_multigeneration == "M"){
                $url1 = RTPS_API_LINK."treeApi?application_no=" . $application_no ;
                $treeOutput = sendCurlRequest($url1);
                // $chTree = curl_init();
                // curl_setopt($chTree, CURLOPT_URL, $url1);
                // curl_setopt($chTree, CURLOPT_RETURNTRANSFER, 1);
                // curl_setopt($chTree, CURLOPT_SSL_VERIFYPEER, FALSE);
                // curl_setopt($chTree, CURLOPT_SSL_VERIFYHOST,  2);
                // $treeOutput = curl_exec($chTree);
                // curl_close($chTree);
                $treeOutput = json_decode($treeOutput,true);
                if(!empty($treeOutput)){
                    $district['tree']=$treeOutput['tree'];
                    $district['owner_pattadar'] = $treeOutput['owner_pattadar'];
                    $district['generation_type'] = $treeOutput['generation_type'];
                }
                
            }
            $district['secParty']=$output->applicants;
            $district['document']=$output->documents;
            $district['query']=$output->query;
            $district['user']=$this->rtpsmodel->usersForOffice($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code);
            $district['mut_type']=$this->utilityclass->mutType('i');
            if(($district['app']->dist_code!=$this->session->userdata('dist_code')) || ($district['app']->subdiv_code!=$this->session->userdata('subdiv_code')) || ($district['app']->cir_code!=$this->session->userdata('cir_code')) )
            {
                redirect('/home');
            }
            if($this->session->userdata('user_desig_code')=='AST'){
                $district['_view'] = 'rtps/inheritance_ofc_multigen';
            }elseif($this->session->userdata('user_desig_code')=='CO' or $this->session->userdata('user_desig_code')=='ADC'){
                $district['_view'] = 'rtps/inheritance_co_revert_multigen';
            }else{
                $district['_view'] = 'rtps/inheritance_multigen_for_escalation';
            }

            // ///////////////////////////////////////////// property chain code //////////////////////////////////////////
            // if(count($dagArray) == 1)
            // {
            //     if(ENABLED_BLOCKCHAIN == 1 && in_array($district['app']->dist_code,json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
            //     {
                    
            //         $this->load->model('propChain/PropChainModel');
            //         // checking if chitha data and property chain data mathches
            //         $checkPropAndChitha =  $this->PropChainModel->chainChithaUlpinCheckProcess($district['app']->dist_code,  $district['app']->subdiv_code, $district['app']->cir_code, $district['app']->mouza_code, $district['app']->lot_no, $district['app']->village_code, $district['pattaNo']->patta_no, $district['app']->dag_no, $district['pattaNo']->dag_area_b, $district['pattaNo']->dag_area_k, $district['pattaNo']->dag_area_lc, $district['pattaNo']->dag_area_g, $district['pattaNo']->patta_type_code);

            //         // var_dump($pattadars);
            //         $district['chithaPropChainCmpFlag'] = $checkPropAndChitha['chithaPropChainCmpFlag'];
            //         $district['compareFlagMsg'] = $checkPropAndChitha['compareFlagMsg'];
            //         $district['ulpinCheck'] = $checkPropAndChitha['ulpinCheck'];
            //         // hidden fields
            //         $district['ulpin_hidden'] = $checkPropAndChitha['ulpin_hidden'];
            //         $district['uplpin_msg_hidden'] = $checkPropAndChitha['uplpin_msg_hidden'];
            //         $district['compare_hidden'] = $checkPropAndChitha['compare_hidden'];
            //         $district['compare_msg_hidden'] = $checkPropAndChitha['compare_msg_hidden'];

            //         // bhunaksha area cmp
            //         $district['bhuChithaCmpStatus'] = $checkPropAndChitha['bhuChithaCmpStatus'];
            //         $district['bhuChithaCmpMsg'] = $checkPropAndChitha['bhuChithaCmpMsg'];
            //         $district['bhu_hidden'] = $checkPropAndChitha['bhu_hidden'];
            //         $district['bhu_compare_msg_hidden'] = $checkPropAndChitha['bhu_compare_msg_hidden'];
            //     }

            // }
        
        $this->load->view('layouts/main',$district);
        }
        
    } 

    function ins_list()
    {
        $d=$this->session->userdata('dist_code');
        $s=$this->session->userdata('subdiv_code');
        $c=$this->session->userdata('cir_code');
        $data['dist_code'] = $d;
        $data['subdiv_code'] = $s;
        $data['cir_code'] = $c;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://basundhara.assam.gov.in/rtpsmb/ApiMbThree/ins_list_co_download/$d/$s/$c");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $output = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($output);
        if(empty($data))
        {
            echo json_encode(array("NO DATA FOUND"));
            die;
        }
        // var_dump($data);
        $this->load->model('UtilsModel');
        $this->UtilsModel->downloadExcelReport($file_name,$data);
    }

    function dlr_list()
    {
        $d=$this->session->userdata('dist_code');
        $s=$this->session->userdata('subdiv_code');
        $c=$this->session->userdata('cir_code');
        $data['dist_code'] = $d;
        $data['subdiv_code'] = $s;
        $data['cir_code'] = $c;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://basundhara.assam.gov.in/rtpsmb/ApiMbThree/dlr_forward_list_co_download/$d/$s/$c");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $output = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($output);
        if(empty($data))
        {
            echo json_encode(array("NO DATA FOUND"));
            die;
        }
        // var_dump($data);
        $this->load->model('UtilsModel');
        $this->UtilsModel->downloadExcelReport($file_name,$data);
    }

}