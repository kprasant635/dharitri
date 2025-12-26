<?php
class Basundhara2 extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('patta/pattamodel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->model('basundhara/SettlementApiModel');
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('SettlementModel/SettlementTenantModel');
        $this->load->model('rtps/rtpsmodel');
        $this->load->model('SettlementModel/SettlementVgrModel');
        $this->load->model('UtilsModel');
        $this->load->helper(array('form', 'url'));
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
        } else if ($this->session->userdata('dist_code') == "39") {
            $this->db = $this->load->database('dha39', true);
        } else if ($this->session->userdata('dist_code') == "38") {
            $this->db = $this->load->database('dha25', true);
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
        $url = API_LINK_MB2."allRecords/$d/$s/$c/$m/$l/$u" ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $output = curl_exec($ch);
        curl_close($ch);
        $district['output'] = json_decode($output);
        $district['_view'] = 'basundhara/byservicelist';
        $this->load->view('layouts/main',$district);
    }

    function request($service){

        $curl_handle = curl_init();
        //curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."lmServicewiseRecords/$service/$dist_code/$subdiv_code/$cir_code/$mouza_pargona_code/$lot_no");

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getSelectListPagination/$service/$dist_code/$subdiv_code/$cir_code/$mouza_pargona_code/$lot_no");

        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array()));
        $result = curl_exec($curl_handle);
        $results = json_decode($result);

        $district['selectList'] = $results;

        $district['service'] = $service;
        $district['_view'] = 'basundhara/request';
        $this->load->view('layouts/main',$district);
    }


    //////////////////////////
    function requestCircleOrg($service){
        //var_dump($_SESSION);
        $this->load->model('basundhara/SettlementApiModel');
        $district['pending']=$this->SettlementApiModel->allCORequest($service);
        $district['_view'] = 'basundhara/circle_total_reg_detail';
        $this->load->view('layouts/main',$district);
    }
    //////////////////////////


    function Apiswitch($rtps){
        if($rtps=='RTPS'){
            $apilink=RTPS_API_LINK;
        }
        elseif($rtps=='MB'){
            $apilink=API_LINK_MB2;
        }
        else
        {
            $apilink='';
        }
        return $apilink;
    }


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
        if($desigcode=='LM'){
            $lm=$this->utilityclass->getDefinedMondalsName($d,$s,$c,$m,$l,$code);
            $user_nm=$lm->lm_name;
        }else{
            $lm=$this->utilityclass->getSelectedASOName($d,$s,$c,$code);
            $user_nm=$lm->username;
        }
        $data['rtps']=$rtps=$this->rtpsmodel->checkRtpsService($application_no);
        $apilink=$this->ApiSwitch($rtps);
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $apilink."queryInsert");
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
        $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
        $data= json_decode($result);
        if($httpcode!=200 || $data==null){
            $this->session->set_flashdata('message',"Error in query for Application No  $application_no ");
            redirect('/home');
        }
        if($data==true || $data=='true'){

            $this->session->set_flashdata('message',"Your Query has been sent to the user against application no $application_no ");
            redirect('/home');
        }else{
            $this->session->set_flashdata('message',"Error in query for Application No  $application_no ");
            redirect('/home');
        }

    }



    function apicheck(){
        $application_no='MB/MCOR/2021/24567';
        $url = API_LINK_MB2."serviceResponse?application_no=" . $application_no ;
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
    ///////////////////////////
    function requestCircle($service){
        //var_dump($_SESSION);
        $this->load->model('basundhara/SettlementApiModel');
        $this->load->library('pagination');
        $data = array();
        $this->perPage = 100;
        $service_code = $service;
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        // If search request submitted
        if($this->input->post('submitSearch')){
            $inputKeywords = $this->input->post('searchKeyword');
            $searchKeyword = strip_tags($inputKeywords);
            if(!empty($searchKeyword)){
                $this->session->set_userdata('searchKeyword',$searchKeyword);
                redirect(base_url().'index.php/basundhara/requestCircle/'.$service_code);
            }else{
                $this->session->unset_userdata('searchKeyword');
            }
        }elseif($this->input->post('submitSearchReset')){
            $this->session->unset_userdata('searchKeyword');
            redirect(base_url().'index.php/basundhara/requestCircle/'.$service_code);
        }
        $data['searchKeyword'] = $this->session->userdata('searchKeyword');
        // Get rows count
        $conditions['conditions'] = array(
            'is_draft'=>'N',
            'service_code' => $service_code,
            'dist_code'=> $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code'=> $cir_code
        );
        $conditions['searchKeyword'] = $data['searchKeyword'];
        $conditions['returnType']    = 'count';
        //$rowsCount = $this->MyapplicationsModel->getRows($conditions);
        $rowsCount = $this->SettlementApiModel->allCORequest1($conditions);

        // Pagination config
        $config['base_url']    = base_url().'index.php/basundhara/requestCircle/'.$service_code;
        $config['uri_segment'] = 4;
        $config['total_rows']  = $rowsCount;
        $config['per_page']    = $this->perPage;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        // Initialize pagination library
        $this->pagination->initialize($config);
        $page = $this->uri->segment(4);
        $offset = !$page?0:$page;
        $conditions[] = null;
        $conditions['returnType'] = '';
        $conditions['conditions'] = array(
            'is_draft'=>'N',
            'service_code' => $service_code,
            'dist_code'=> $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code'=> $cir_code
        );
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        $data['pending'] =  $this->SettlementApiModel->allCORequest1($conditions);
        $data['title'] = 'Application List';
        $data['_view'] = 'basundhara/new_pagination';
        $this->load->view('layouts/main',$data);
    }
    /////////////18-12-2021/////////////////////
    function adcRejectList(){
        //$data['case']=$this->SettlementApiModel->adcRejectList();
        $curl_handle = curl_init();

        //$url="https://basundhara.assam.gov.in/demo/"."rest/getrejectapp";
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getRejectedApplications");
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
        $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
        $data= json_decode($data);
        if($httpcode!=200 || $data==null || empty($data->responseType)){
            $data=array(
                'error'=>"<b> Error in API Calling </b>",
                'redirect_url'=>base_url().'index.php/home'
            );
            echo json_encode($data);
            return;
        }
        if($data->responseType==2){
            $data->responseType;
            $store['output']=$data->data;
        }else{
            $store['output']=null;
        }
        $store['_view'] = 'basundhara/rejectlist';
        $this->load->view('layouts/main',$store);
    }

    ////////////////////For CO//////////////////////////
    function pendingforApprove(){
        //$data['case']=$this->SettlementApiModel->adcRejectList();
        $curl_handle = curl_init();
        //$url="https://basundhara.assam.gov.in/demo/"."rest/getrejectapp";
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getADCAllowedApplicationsForCircle");
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
        $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
        $data= json_decode($data);
        if($httpcode!=200 || $data==null || empty($data->responseType)){
            $data=array(
                'error'=>"<b> Error in API Calling </b>",
                'redirect_url'=>base_url().'index.php/home'
            );
            echo json_encode($data);
            return;
        }
        if($data->responseType==2){
            $data->responseType;
            $store['output']=$data->data;
        }else{
            $store['output']=null;
        }
        $store['_view'] = 'basundhara/reapprovelist';
        $this->load->view('layouts/main',$store);
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

    function postApiManualPayment($case,$task){
        $sql="Select basundhara from  basundhar_application where dharitree='$case' ";
        $linkAvail=$this->db->query($sql)->num_rows();
        if($linkAvail>0)
        {
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."manualPayStatus");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application' => $basundhara,
                'query_from_officer'=>$this->session->userdata('user_code')
            )));
            return curl_exec($curl_handle);
        }
    }

    function check_script($str){
        if( strpos( trim(strtolower($str)), '<' ) !== false) {
            return FALSE;
        }

        if( strpos( trim(strtolower($str)), '>' ) !== false) {
            return FALSE;
        }

        if( strpos( trim(strtolower($str)), '<script>' ) !== false) {
            return FALSE;
        }
        if( strpos( trim(strtolower($str)), '</script>' ) !== false) {
            return FALSE;
        }
        return TRUE;
    }

    ////////////////////////// settlement start //////////////

    function settlementCases(){
        $d=$this->session->userdata('dist_code');
        $s=$this->session->userdata('subdiv_code');
        $c=$this->session->userdata('cir_code');
        $m=$this->session->userdata('mouza_pargona_code');
        $l=$this->session->userdata('lot_no');
        $u=$this->session->userdata('user_desig_code');
        $url = API_LINK_MB2."allSettlementCases/$d/$s/$c/$m/$l/$u" ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $output = curl_exec($ch);
        curl_close($ch);
        $district['output'] = json_decode($output);
        $district['_view'] = 'basundhara/settlement_servicelist';
        $this->load->view('layouts/main',$district);
    }
    ///////////////////////////////////
    function settlementBasu(){
        $application_no = $this->input->get('app');
        // $url = API_LINK_MB2."serviceResponse?application_no=" . $application_no ;
        $url = API_LINK_MB2."serviceResponseBasu?application_no=" . $application_no ;
        // var_dump($url); die();
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
        // var_dump($district['pattaNo']);die();
        // $district['firstParty']=$output->mutation;
        $district['secParty']=$output->applicants;
        $district['applicants']=$output->applicants;
        $district['document']=$output->documents;
        $district['query']=$output->query;
        $district['property']=$output->property;
        $district['settlements']=$output->settlements;
        $district['spouse']=$output->spouse;
        $district['aadhar']=$output->aadhar;
        $district['settlementsOne'] = $output->settlementsOne;
        $district['nextKin'] = $output->nextKin;

        /////fetch owner details//////
        // var_dump($district['pattaNo']->patta_type_code); die();
        $d=$district['app']->dist_code;
        $s=$district['app']->subdiv_code;
        $c=$district['app']->cir_code;
        $m=$district['app']->mouza_code;
        $l=$district['app']->lot_no;
        $v=$district['app']->village_code;
        $pno=$district['pattaNo']->patta_no;
        $pc=$district['pattaNo']->patta_type_code;

        foreach($output->settlements as $allapplicants){
            if($allapplicants->pdar_type=='O'){
                // var_dump($allapplicants->pdar_type);

                $query = "select pdar_name,pdar_father from chitha_pattadar where dist_code= '$d' and subdiv_code='$s' and "
                    . " cir_code='$c' and lot_no='$l' and mouza_pargona_code='$m' and "
                    . " vill_townprt_code='$v' and trim(patta_no)=trim('$pno') and patta_type_code='$pc' and pdar_id='$allapplicants->chitha_pdar_id' ";
                $owner = $this->db->query($query)->result();
                $district['owner'] = $owner;
                // var_dump($district['owner']);

                // $query = "select pdar_name,
                // pdar_father from chitha_pattadar where dist_code=? and subdiv_code=? and cir_code=? and lot_no=? and mouza_pargona_code=? and  vill_townprt_code=? and patta_no=? and patta_type_code=? and pdar_id=? ";
                // $owner = $this->db->query($query,$d,$s,$c,$l,$m,$v,$pno,$pc,$allapplicants->chitha_pdar_id);

            }
        }

        /////fetch owner details end//////


        // $district['selfDeclarationDetails'] = $output->selfDeclaration;
        foreach($output->selfDeclaration as $selfDec){
            $district['selfDeclarationDetails']=json_decode($selfDec->dec_details);
        }

        // var_dump($district['aadhar']); die();
        if($district['app']->service_code=='18' ){
            $district['_view'] = 'SettlementView/SettlementCultivatorsView';
        }
        elseif($district['app']->service_code=='16' ){
            $district['_view'] = 'SettlementView/SettlementKhasLandView';
        }
        elseif($district['app']->service_code=='13' ){
            $district['_view'] = 'SettlementView/SettlementTenantView';
        }
        elseif($district['app']->service_code=='14' ){
            //    $district['_view'] = 'basundhara/settlementap_updation';
            $district['_view'] = 'SettlementView/SettlementApTransferred';
        }
        elseif($district['app']->service_code=='15' ){
            $district['_view'] = 'SettlementView/SettlementTribalView';
        }
        $this->load->view('layouts/main',$district);
    }

    // Settlement AP CO view starts here
    public function settlementApCo(){
        $application_no = $this->input->get('app');
        // $url = API_LINK_MB2."serviceResponse?application_no=" . $application_no ;
        $url = API_LINK_MB2."serviceResponseBasu?application_no=" . $application_no ;
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
        $district['applicants']=$output->applicants;
        $district['document']=$output->documents;
        $district['query']=$output->query;
        $district['property']=$output->property;
        $district['settlements']=$output->settlements;
        $district['spouse']=$output->spouse;
        $district['aadhar']=$output->aadhar;
        $district['settlementsOne'] = $output->settlementsOne;
        // $district['selfDeclarationDetails'] = $output->selfDeclaration;
        foreach($output->selfDeclaration as $selfDec){
            $district['selfDeclarationDetails']=json_decode($selfDec->dec_details);
        }

        $district['_view'] = 'SettlementView/Co/SettlementApTransferred';
        $this->load->view('layouts/main',$district);
    }



    //////////////////////////
    function settlementTenantBasu(){
        $application_no = $this->input->get('app');
        $url = API_LINK_MB2."serviceResponse?application_no=" . $application_no ;
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
        if($this->session->userdata('user_desig_code')=='ADC' ){
            $district['_view'] = 'basundhara/mobileupdation_inherit';
        }else{
            $district['_view'] = 'basundhara/mobileupdation';
        }
        $this->load->view('layouts/main',$district);
    }
    //////////////////////////
    function settlementTribal(){
        $application_no = $this->input->get('app');
        $url = API_LINK_MB2."serviceResponse?application_no=" . $application_no ;
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
        if($this->session->userdata('user_desig_code')=='ADC' ){
            $district['_view'] = 'basundhara/mobileupdation_inherit';
        }else{
            $district['_view'] = 'basundhara/mobileupdation';
        }
        $this->load->view('layouts/main',$district);
    }

    ///settlement Ap Post start ////
    function settlementApPost(){

        $application_no=$this->input->post('application_no');
        // var_dump($application_no);
        // die();
        //////////////////
        $recordExist=$this->SettlementApiModel->checkExistDharitree($application_no);
        if($recordExist){
            $data=array(
                'error'=>"Case have been Registered Already. Please Check"
            );
            echo json_encode($data);
            exit;
        }

        /////////////////////
        $url = API_LINK_MB2."serviceResponseBasu?application_no=" . $application_no ;
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
        $data['settlements']=$output->settlements;
        $data['settlementsOne']=$output->settlementsOne;
        $data['property']=$output->property;
        $data['documents']=$output->documents;

        $this->db->trans_begin();

        $case_name=$this->SettlementApiModel->genearteCaseName();
        if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Seesion Out. Please try Again"
            );
            echo json_encode($data);
            exit;
            die();
        }
        $case_no['petition_no']=$petition_no=$this->SettlementApiModel->genearteSettlementPetitionNo();

        $case_no['case_no']=$case_name.$petition_no."/SETL";

        $basic=array(
            'dist_code'=>$this->input->post('dist_code'),
            'subdiv_code'=>$this->input->post('subdiv_code'),
            'cir_code'=>$this->input->post('cir_code'),
            'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
            'lot_no'=>$this->input->post('lot_no'),
            'vill_townprt_code'=>$this->input->post('vill_townprt_code'),
            'service_code'=>$this->input->post('service_code'),
            'ref_no'=>$this->input->post('ref_no'),
            'case_no'=>$case_no['case_no'],
            'trans_code'=>'F',/////////full
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'date_entry' => date('Y-m-d G:i:s'),
            'status'=>'W',
            'user_code'=>$this->session->userdata('user_code'),
            'lm_code' => $this->session->userdata('user_code'),
            'submission_date' => date('Y-m-d G:i:s'),
            'from_office' => 'LM',
            'pending_officer' => 'CO',
            'pending_office' => 'CO',
            // 'period_possession'=>$this->input->post('period_possession'),
            // 'occupation_applicant'=>$this->input->post('occupation_applicant'),
            'applid'=>$this->input->post('applid')
            /////////
        );

        $insSetBasic = $this->db->insert('settlement_basic',$basic);
        // echo $this->db->last_query(); die();
        if($insSetBasic != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRSET0001: Insertion failed in settlement_basic RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRSET0001: Registration of Settlement failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }
        ////settlement_dag_details insert start
        $fmd=array(
            'dist_code'=>$this->input->post('dist_code'),
            'subdiv_code'=>$this->input->post('subdiv_code'),
            'cir_code'=>$this->input->post('cir_code'),
            'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
            'lot_no'=>$this->input->post('lot_no'),
            'vill_townprt_code'=>$this->input->post('vill_townprt_code'),
            'user_code'=>$this->session->userdata('user_code'),
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'operation'=>'E',
            'new_land_class_code'=>$this->input->post('land_class_code'),
        );



        $fmd['dag_no']= $this->input->post('dag_no');
        $fmd['patta_no']=$this->input->post('patta_no');
        $fmd['patta_type_code']=$this->input->post('patta_type_code');
        $fmd['dag_area_b']=$this->input->post('dag_area_b');
        $fmd['dag_area_k']=$this->input->post('dag_area_k');
        $fmd['dag_area_lc']=$this->input->post('dag_area_lc');
        $fmd['dag_area_g']=$this->input->post('dag_area_g');
        $fmd['dag_area_kr']=$this->input->post('dag_area_kr');
        $fmd['s_dag_area_b']=$this->input->post('s_dag_area_b');
        $fmd['s_dag_area_k']=$this->input->post('s_dag_area_k');
        $fmd['s_dag_area_lc']=$this->input->post('s_dag_area_lc');
        $fmd['s_dag_area_g']=$this->input->post('s_dag_area_g');
        $fmd['s_dag_area_kr']=$this->input->post('s_dag_area_kr');
        $fmd['is_urban']=trim($this->input->post('is_urban'));
        $fmd['revenue']=0;
        $insSetDag = $this->db->insert('settlement_dag_details',$fmd);
        // echo $this->db->last_query(); die();
        if($insSetDag != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRSET0002: Insertion failed in settlement_dag_details RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRSET0002: Registration of Settlement failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }
        ////settlement_dag_details insert end

        ////settlement_applicant insert start
        $i=1;
        foreach($data['settlements'] as $setl){

            if($this->input->post('pdar_id'.$i)=="" || $this->input->post('pdar_id'.$i)==null || empty($this->input->post('pdar_id'.$i)))
            {
                $chitha_pdar_id=-1;
            }else{
                $chitha_pdar_id=$this->input->post('pdar_id'.$i);
            }

            if($this->input->post('pdar_type'.$i)=='O')
            {
                $inplace_alongwith =$this->input->post('inplace_alongwith');
            }else{
                $inplace_alongwith=null;
            }

            $applicant=array(
                'dist_code'=>$this->input->post('dist_code'),
                'subdiv_code'=>$this->input->post('subdiv_code'),
                'cir_code'=>$this->input->post('cir_code'),
                'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
                'lot_no'=>$this->input->post('lot_no'),
                'vill_townprt_code'=>$this->input->post('vill_townprt_code'),

                'user_code'=>$this->session->userdata('user_code'),
                'case_no'=>$case_no['case_no'],
                'petition_no'=>$case_no['petition_no'],
                'operation'=>'E',
                'dag_no' =>$this->input->post('dag_no'),
                'patta_no' =>$this->input->post('patta_no'),
                'patta_type_code'=>$this->input->post('patta_type_code'),
                'year_no'=>date('Y'),
                'date_entry'=>date('Y-m-d'),
                'pdar_id' =>$chitha_pdar_id,
                'pdar_cron_no'=>$i,
                'pdar_name' =>$this->input->post('pdar_name'.$i),
                'pdar_guardian' =>$this->input->post('pdar_guardian'.$i),

                'pdar_rel_guar' =>$this->input->post('pdar_rel_guar'.$i),
                'pdar_gender'=>$this->input->post('pdar_gender'.$i),
                // //'pdar_add1' => $part->address,
                'pdar_add1' => $this->input->post('pdar_add1'.$i),
                'pdar_add2' => $this->input->post('pdar_add2'.$i),
                'pdar_mobile' => $this->input->post('pdar_mobile'.$i),
                'i_area_b' => $this->input->post('i_area_b'.$i),
                'i_area_k' => $this->input->post('i_area_k'.$i),
                'i_area_lc' => $this->input->post('i_area_lc'.$i),
                'i_area_g' => $this->input->post('i_area_g'.$i),
                'i_area_kr' => $this->input->post('i_area_kr'.$i),
                'pdar_type' => $this->input->post('pdar_type'.$i),
                'inplace_alongwith' =>$inplace_alongwith,
            );
            $i++;

            $insSetApplicant = $this->db->insert('settlement_applicant',$applicant);


            if($insSetApplicant != 1)
            {
                // var_dump($insSetApplicant);
                // echo $this->db->last_query(); die();
                $this->db->trans_rollback();
                log_message('error', '#ERRSET0003: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRSET0003: Registration of Settlement failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }

        }

        ////settlement_applicant insert end

        ////supportive_document insert start
        // foreach($data['documents'] as $docs){
        //     $document=array(
        //         'case_no'=>$case_no['case_no'],
        //         'user_code'=>$this->session->userdata('user_code'),
        //         'file_name'=>$this->input->post('file_name'),
        //         'file_type'=>$this->input->post('file_type'),
        //         'file_path'=>$this->input->post('file_path'),
        //         'date_entry' => date('Y-m-d G:i:s'),
        //         'mut_type'=>$this->input->post('mut_type'),
        //         /////////
        //     );

        //     $insDoc = $this->db->insert('supportive_document',$document);;
        //     if($insDoc != 1)
        //     {
        //         $this->db->trans_rollback();
        //         log_message('error', '#ERRSET0004: Insertion failed in supportive_document RTPS Case No '.$application_no);
        //         $data = array(
        //             'error'=>"#ERRSET0004: Registration of Settlement failed for case no : ".$application_no
        //         );
        //         echo json_encode($data);
        //         return false;
        //     }
        // }
        ////supportive_document insert end

        ////settlement AP LM Report insert start

        ////////////////////file///////////////////////////
        // var_dump("in file"); die();
        header('content-type:application/json');
        $case_no=$case_no['case_no'];
        $documents_config = json_decode(SETTLEMENT_AP_FILES);
        $validations=[];
        $document_details=[];
        log_message("error","------------FILE validation STARTED------------- ");
        foreach($documents_config as $key=>$value){
            $return= $this->SettlementApiModel->fileManualValidation($value);

            if(!is_null($return)){
                $return['status']==1 ? $validations[]= $return['validation']: $document_details[]= $return['data'];
            }
        }
        log_message("error","------------FILE validation ENDED--------------- ");
        if(!empty($validations)){
            echo json_encode(array(
                'responseType' => 1,
                'validation' => $validations
            ));
            return;
        }
        // NOW STORE THE FILE
        // $application_id = $_POST['application_id'];
        $documents=[];
        log_message("error","------------FILE SAVE STARTED------------- ");
        foreach($document_details as $value){
            log_message("error","doc data".json_encode($value));
            // $file_new_name= RTPS_CODE.'_'.$application_id . '_'.SETTLEMENT_AP_TRANSFER_ID.'_'.$value['file_name'].'.'.$value['extension'];
            $file_new_name= $value['file_name'].'.'.$value['extension'];
            $app_doc = $this->db->select('id')->from('supportive_document')->where(
                array('case_no'=>$case_no,'file_name'=>$value['file_details'])
            )->get()->row();

            log_message("error","doc data".json_encode(empty($app_doc)));
            $document= array(
                'case_no' => $case_no,
                'file_name' => $value['file_details'],
                'user_code' => $this->session->userdata('user_code'),
                'fetch_file_name' => $file_new_name,
                'file_type' => $value['content_type'],
                'file_path' => UPLOAD_DIR.$file_new_name,
                'date_entry' => date('Y-m-d h:i:s'),
                'mut_type' => $this->input->post('service_code'),
            );
            // var_dump($document); die();
            if(empty($app_doc)){
                $status= $this->db->insert('supportive_document',$document);
                log_message("error","insert doc status:".json_encode($status));
                log_message("error","last query".json_encode($this->db->last_query()));
            }
            //else{
            //     log_message("error","update doc");
            //     $this->db->where('id',$app_doc->id)->update('supportive_document',$document);
            //     log_message("error","last query".json_encode($this->db->last_query()));
            // }
            log_message("error","doc data".json_encode($document));
            move_uploaded_file($_FILES[$value['file_name']]['tmp_name'], UPLOAD_DIR.$file_new_name);
        }
        if ($this->db->trans_status() === FALSE) {
            log_message("error","------------FILE SAVE ENDED WITH ERROR------------- ");
            $this->db->trans_rollback();
            echo json_encode(array(
                'responseType' => 3,
                'error' => 'Something Went wrong!!!'
            ));
            return;
        } else {
            log_message("error","------------FILE SAVE END------------- ");
            // echo json_encode(array(
            //     'responseType' => 2
            //     // 'application_id' => $application_id
            // ));
        }

        ///////////////////////////////////////////////

        $comment = addslashes($this->input->post('lm_remark'));
        $r_bigha = $this->input->post('reserved_bigha');
        $r_katha = $this->input->post('reserved_katha');
        $r_lessa = $this->input->post('reserved_lessa');
        $r_ganda = $this->input->post('reserved_ganda');
        $r_kranti = $this->input->post('reserved_kranti');

        $lmnote=array(
            'user_code'=>$this->session->userdata('user_code'),
            'chitha_verified'=>$this->input->post('chiitha_verified'),
            'vlb_verified'=>$this->input->post('vlb_verified'),
            'possession_verification'=>$this->input->post('possession_verified'),
            'ceiling_limit'=>$this->input->post('ceiling_limit'),
            'roadside_reservation'=>$this->input->post('roadside_reservation'),
            'zonal_valuation'=>$this->input->post('zonal_valuation'),
            // 'trace_map_copy'=>$this->input->post('trace_map_copy'),
            // 'chitha_copy'=>$this->input->post('chitha_copy'),
            'trace_map_copy'=>'NA',
            'chitha_copy'=>'NA',
            'lm_note'=>$comment,
            'date_entry'=>date('Y-m-d h:i:s'),
            'case_no'=>$case_no,
            'status'=>'W',
            'r_bigha'=>$r_bigha,
            'r_katha'=>$r_katha,
            'r_lessa'=>$r_lessa,
            'r_ganda'=>$r_ganda,
            'r_kranti'=>$r_kranti,
        );

        $insLmnote = $this->db->insert('settlement_ap_lmnote',$lmnote);
        if($insLmnote != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRSET0005: Insertion failed in settlement_ap_lmnote RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRSET0005: Registration of Settlement failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }
        //////proceeding start//////
        $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

        if($proceeding_id==null){
            $proceeding_id=1;
        }

        $insPetProceed = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'note_on_order' => $comment,
            'status' => 'W',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d h:i:s'),
            'operation' => 'E',
            'ip' => $this->utilityclass->get_client_ip(),
            'office_from' => 'LM',
            'office_to' => 'CO',
            'task' => 'LM note submitted'
        ];
        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

        // echo $this->db->last_query(); die();
        if($insertProceeding != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
            $json = [
                'errorMessage'=>"#ERRORPP: Failed to forward the case for Case No : ".$case_no
            ];
            echo json_encode($json);
            return false;
        }
        //////proceeding end//////

        ////settlement AP LM Report insert end

        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            $data=array(
                'error'=>"Error in submitting. Please try Again"
            );
        }else
        {
            $basundhara=array(
                'dharitree'=>$case_no,
                'basundhara'=>$application_no,
                'date_reg'=>date('Y-m-d'),
                'reg_by'=>$this->session->userdata('user_code'),
                'app_status'=>'M',
                'pending_with'=>'LM'
            );
            $this->db->insert('basundhar_application',$basundhara);

            //////////////POST To basundhara/////////////////////
            $rmk='Forwarded to CO';
            $status='W';
            $task='LM';
            $pen='CO';
            $case=$case_no;
            $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
            $rtps_status=json_decode($rtps_status);
            //var_dump($rtps_status);
            if(trim($rtps_status)!="y"){
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error #ERRAPP0011: Settlement Application not submitted case no # $case_no");
                redirect(base_url() . "index.php/home");
            }else{
                $this->db->trans_commit();
            }
            //////////////////
            // $this->DashboardInheritance($case_no['case_no']);
            //////
            //////////////////////////////////
            $this->session->set_flashdata('message', "Settlement Application Registered Successfully with case no # $case_no");
            redirect(base_url() . "index.php/home");

            // $data=array(
            //     'success'=>"Settlement Application Registered Successfully with case no $case_no[case_no]",
            //     'redirect_url'=>base_url().'index.php/home'
            // );
        }
        // echo json_encode($data);
    }
    ///settlement Ap post ebnd ////


    ///settlement Khas land post start ////
    function settlementKhasPost(){

        $application_no=$this->input->post('application_no');
        $recordExist=$this->SettlementApiModel->checkExistDharitree($application_no);
        if($recordExist){
            $data=array(
                'error'=>"Case have been Registered Already. Please Check"
            );
            echo json_encode($data);
            exit;
        }

        /////////////////////
        $url = API_LINK_MB2."serviceResponseBasu?application_no=" . $application_no ;
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
        $data['settlements']=$output->settlements;
        $data['settlementsOne']=$output->settlementsOne;
        $data['property']=$output->property;
        $data['documents']=$output->documents;

        $this->db->trans_begin();

        $case_name=$this->SettlementApiModel->genearteCaseName();
        if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Seesion Out. Please try Again"
            );
            echo json_encode($data);
            exit;
            die();
        }
        $case_no['petition_no']=$petition_no=$this->SettlementApiModel->genearteSettlementPetitionNo();

        $case_no['case_no']=$case_name.$petition_no."/SETL";

        $basic=array(
            'dist_code'=>$this->input->post('dist_code'),
            'subdiv_code'=>$this->input->post('subdiv_code'),
            'cir_code'=>$this->input->post('cir_code'),
            'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
            'lot_no'=>$this->input->post('lot_no'),
            'vill_townprt_code'=>$this->input->post('vill_townprt_code'),
            'service_code'=>$this->input->post('service_code'),
            'ref_no'=>$this->input->post('ref_no'),
            'case_no'=>$case_no['case_no'],
            'trans_code'=>'F',/////////full
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'date_entry' => date('Y-m-d G:i:s'),
            'status'=>'W',
            'user_code'=>$this->session->userdata('user_code'),
            'lm_code' => $this->session->userdata('user_code'),
            'submission_date' => date('Y-m-d G:i:s'),
            'from_office' => 'LM',
            'pending_officer' => 'CO',
            'pending_office' => 'CO',
            'period_possession'=>$this->input->post('period_possession'),
            'occupation_applicant'=>$this->input->post('occupation_applicant'),
            'applid'=>$this->input->post('applid')
            /////////
        );

        $insSetBasic = $this->db->insert('settlement_basic',$basic);
        if($insSetBasic != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRSET0001: Insertion failed in settlement_basic RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRSET0001: Registration of Settlement failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }
        ////settlement_dag_details insert start
        $fmd=array(
            'dist_code'=>$this->input->post('dist_code'),
            'subdiv_code'=>$this->input->post('subdiv_code'),
            'cir_code'=>$this->input->post('cir_code'),
            'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
            'lot_no'=>$this->input->post('lot_no'),
            'vill_townprt_code'=>$this->input->post('vill_townprt_code'),
            'user_code'=>$this->session->userdata('user_code'),
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'operation'=>'E',
        );



        $fmd['dag_no']= $this->input->post('dag_no');
        $fmd['patta_no']=$this->input->post('patta_no');
        $fmd['patta_type_code']=$this->input->post('patta_type_code');
        $fmd['dag_area_b']=$this->input->post('dag_area_b');
        $fmd['dag_area_k']=$this->input->post('dag_area_k');
        $fmd['dag_area_lc']=$this->input->post('dag_area_lc');
        $fmd['dag_area_g']=$this->input->post('dag_area_g');
        $fmd['dag_area_kr']=$this->input->post('dag_area_kr');
        $fmd['s_dag_area_b']=$this->input->post('s_dag_area_b');
        $fmd['s_dag_area_k']=$this->input->post('s_dag_area_k');
        $fmd['s_dag_area_lc']=$this->input->post('s_dag_area_lc');
        $fmd['s_dag_area_g']=$this->input->post('s_dag_area_g');
        $fmd['s_dag_area_kr']=$this->input->post('s_dag_area_kr');
        $fmd['is_urban']=trim($this->input->post('is_urban'));
        $fmd['revenue']=0;
        $insSetDag = $this->db->insert('settlement_dag_details',$fmd);
        // echo $this->db->last_query(); die();
        if($insSetDag != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRSET0002: Insertion failed in settlement_dag_details RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRSET0002: Registration of Settlement failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }
        ////settlement_dag_details insert end

        ////settlement_applicant insert start
        $i=1;
        foreach($data['settlements'] as $setl){

            if($this->input->post('pdar_id'.$i)=="" || $this->input->post('pdar_id'.$i)==null || empty($this->input->post('pdar_id'.$i)))
            {
                $chitha_pdar_id=-1;
            }else{
                $chitha_pdar_id=$this->input->post('pdar_id'.$i);
            }

            $applicant=array(
                'dist_code'=>$this->input->post('dist_code'),
                'subdiv_code'=>$this->input->post('subdiv_code'),
                'cir_code'=>$this->input->post('cir_code'),
                'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
                'lot_no'=>$this->input->post('lot_no'),
                'vill_townprt_code'=>$this->input->post('vill_townprt_code'),

                'user_code'=>$this->session->userdata('user_code'),
                'case_no'=>$case_no['case_no'],
                'petition_no'=>$case_no['petition_no'],
                'operation'=>'E',
                'dag_no' =>$this->input->post('dag_no'),
                'patta_no' =>$this->input->post('patta_no'),
                'patta_type_code'=>$this->input->post('patta_type_code'),
                'year_no'=>date('Y'),
                'date_entry'=>date('Y-m-d'),
                'pdar_id' =>$chitha_pdar_id,
                'pdar_cron_no'=>$i,
                'pdar_name' =>$this->input->post('pdar_name'.$i),
                'pdar_guardian' =>$this->input->post('pdar_guardian'.$i),

                'pdar_rel_guar' =>$this->input->post('pdar_rel_guar'.$i),
                'pdar_gender'=>$this->input->post('pdar_gender'.$i),
                // //'pdar_add1' => $part->address,
                'pdar_add1' => $this->input->post('pdar_add1'.$i),
                'pdar_add2' => $this->input->post('pdar_add2'.$i),
                'pdar_mobile' => $this->input->post('pdar_mobile'.$i),
                'i_area_b' => $this->input->post('i_area_b'.$i),
                'i_area_k' => $this->input->post('i_area_k'.$i),
                'i_area_lc' => $this->input->post('i_area_lc'.$i),
                'i_area_g' => $this->input->post('i_area_g'.$i),
                'i_area_kr' => $this->input->post('i_area_kr'.$i),
                'pdar_type' => $this->input->post('pdar_type'.$i),
            );
            $i++;

            $insSetApplicant = $this->db->insert('settlement_applicant',$applicant);

            if($insSetApplicant != 1)
            {
                // var_dump($insSetApplicant);
                // echo $this->db->last_query(); die();
                $this->db->trans_rollback();
                log_message('error', '#ERRSET0003: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRSET0003: Registration of Settlement failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }

        }


        ////settlement Khas Land LM Report insert start

        ////////////////////file///////////////////////////
        // var_dump("in file"); die();
        header('content-type:application/json');
        $case_no=$case_no['case_no'];
        $documents_config = json_decode(SETTLEMENT_KHAS_FILES);
        $validations=[];
        $document_details=[];
        log_message("error","------------FILE validation STARTED------------- ");
        foreach($documents_config as $key=>$value){
            $return= $this->SettlementApiModel->fileManualValidation($value);

            if(!is_null($return)){
                $return['status']==1 ? $validations[]= $return['validation']: $document_details[]= $return['data'];
            }
        }
        log_message("error","------------FILE validation ENDED--------------- ");
        if(!empty($validations)){
            echo json_encode(array(
                'responseType' => 1,
                'validation' => $validations
            ));
            return;
        }
        // NOW STORE THE FILE
        // $application_id = $_POST['application_id'];
        $documents=[];
        log_message("error","------------FILE SAVE STARTED------------- ");
        foreach($document_details as $value){
            log_message("error","doc data".json_encode($value));
            // $file_new_name= RTPS_CODE.'_'.$application_id . '_'.SETTLEMENT_AP_TRANSFER_ID.'_'.$value['file_name'].'.'.$value['extension'];
            $file_new_name= $value['file_name'].'.'.$value['extension'];
            $app_doc = $this->db->select('id')->from('supportive_document')->where(
                array('case_no'=>$case_no,'file_name'=>$value['file_details'])
            )->get()->row();

            log_message("error","doc data".json_encode(empty($app_doc)));
            $document= array(
                'case_no' => $case_no,
                'file_name' => $value['file_details'],
                'user_code' => $this->session->userdata('user_code'),
                'fetch_file_name' => $file_new_name,
                'file_type' => $value['content_type'],
                'file_path' => UPLOAD_DIR.$file_new_name,
                'date_entry' => date('Y-m-d h:i:s'),
                'mut_type' => $this->input->post('service_code'),
            );
            // var_dump($document); die();
            if(empty($app_doc)){
                $status= $this->db->insert('supportive_document',$document);
                log_message("error","insert doc status:".json_encode($status));
                log_message("error","last query".json_encode($this->db->last_query()));
            }
            //else{
            //     log_message("error","update doc");
            //     $this->db->where('id',$app_doc->id)->update('supportive_document',$document);
            //     log_message("error","last query".json_encode($this->db->last_query()));
            // }
            log_message("error","doc data".json_encode($document));
            move_uploaded_file($_FILES[$value['file_name']]['tmp_name'], UPLOAD_DIR.$file_new_name);
        }
        if ($this->db->trans_status() === FALSE) {
            log_message("error","------------FILE SAVE ENDED WITH ERROR------------- ");
            $this->db->trans_rollback();
            echo json_encode(array(
                'responseType' => 3,
                'error' => 'Something Went wrong!!!'
            ));
            return;
        } else {
            log_message("error","------------FILE SAVE END------------- ");
            // echo json_encode(array(
            //     'responseType' => 2
            //     // 'application_id' => $application_id
            // ));
        }

        ///////////////////////////////////////////////

        $comment = addslashes($this->input->post('lm_remark'));
        $r_bigha = $this->input->post('reserved_bigha');
        $r_katha = $this->input->post('reserved_katha');
        $r_lessa = $this->input->post('reserved_lessa');
        $r_ganda = $this->input->post('reserved_ganda');
        $r_kranti = $this->input->post('reserved_kranti');

        $lmnote=array(
            'user_code'=>$this->session->userdata('user_code'),
            'chitha_verified'=>$this->input->post('chiitha_verified'),
            'vlb_verified'=>$this->input->post('vlb_verified'),
            'possession_verification'=>$this->input->post('possession_verified'),
            'period_possession'=>$this->input->post('period_possession'),
            'nature_possession'=>$this->input->post('nature_possession'),
            'is_landless'=>$this->input->post('is_landless'),
            'land_falls'=>$this->input->post('land_falls'),
            'falls_und_gmc'=>$this->input->post('falls_und_gmc'),
            'roadside_reservation'=>$this->input->post('roadside_reservation'),
            'zonal_valuation'=>$this->input->post('zonal_valuation'),
            // 'trace_map_copy'=>$this->input->post('trace_map_copy'),
            // 'chitha_copy'=>$this->input->post('chitha_copy'),
            'trace_map_copy'=>'NA',
            'chitha_copy'=>'NA',
            'lm_note'=>$comment,
            'date_entry'=>date('Y-m-d h:i:s'),
            'case_no'=>$case_no,
            'status'=>'W',
            'r_bigha'=>$r_bigha,
            'r_katha'=>$r_katha,
            'r_lessa'=>$r_lessa,
            'r_ganda'=>$r_ganda,
            'r_kranti'=>$r_kranti,
            'total_bigha'=>$this->input->post('total_bigha'),
            'total_Katha'=>$this->input->post('total_Katha'),
            'total_lessa'=>$this->input->post('total_lessa'),
            'total_ganda'=>$this->input->post('total_ganda'),
            'total_kranti'=>$this->input->post('total_kranti'),
        );

        $insLmnote = $this->db->insert('settlement_ap_lmnote',$lmnote);
        if($insLmnote != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRSET0005: Insertion failed in settlement_ap_lmnote RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRSET0005: Registration of Settlement failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }
        //////proceeding start//////
        $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

        if($proceeding_id==null){
            $proceeding_id=1;
        }

        $insPetProceed = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'note_on_order' => $comment,
            'status' => 'W',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d h:i:s'),
            'operation' => 'E',
            'ip' => $this->utilityclass->get_client_ip(),
            'office_from' => 'LM',
            'office_to' => 'CO',
            'task' => 'LM note submitted'
        ];
        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

        // echo $this->db->last_query(); die();
        if($insertProceeding != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
            $json = [
                'errorMessage'=>"#ERRORPP: Failed to forward the case for Case No : ".$case_no
            ];
            echo json_encode($json);
            return false;
        }
        //////proceeding end//////

        ////settlement AP LM Report insert end

        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            $data=array(
                'error'=>"Error in submitting. Please try Again"
            );
        }else
        {
            $basundhara=array(
                'dharitree'=>$case_no,
                'basundhara'=>$application_no,
                'date_reg'=>date('Y-m-d'),
                'reg_by'=>$this->session->userdata('user_code'),
                'app_status'=>'M',
                'pending_with'=>'LM'
            );
            $this->db->insert('basundhar_application',$basundhara);


            //////////////POST To basundhara/////////////////////
            $rmk='Forwarded to CO';
            $status='M';
            $task='LM';
            $pen='CO';
            $case=$case_no;
            $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
            $rtps_status=json_decode($rtps_status);
            //var_dump($rtps_status);"
            if(trim($rtps_status)!="y"){
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error #ERRAPP0011: Settlement Application not submitted case no # $case_no");
                redirect(base_url() . "index.php/home");
            }else{
                $this->db->trans_commit();
            }

            //////////////////
            // $this->DashboardInheritance($case_no['case_no']);
            //////
            //////////////////////////////////
            $this->session->set_flashdata('message', "Settlement Application Registered Successfully with case no # $case_no");
            redirect(base_url() . "index.php/home");

            // $data=array(
            //     'success'=>"Settlement Application Registered Successfully with case no $case_no[case_no]",
            //     'redirect_url'=>base_url().'index.php/home'
            // );
        }
        // echo json_encode($data);
    }
    ///settlement Khas land post end ////

    ///settlement Tribal post start ////
    function settlementTribalPost(){

        $application_no=$this->input->post('application_no');
        $recordExist=$this->SettlementApiModel->checkExistDharitree($application_no);
        if($recordExist){
            $data=array(
                'error'=>"Case have been Registered Already. Please Check"
            );
            echo json_encode($data);
            exit;
        }

        /////////////////////
        $url = API_LINK_MB2."serviceResponseBasu?application_no=" . $application_no ;
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
        $data['settlements']=$output->settlements;
        $data['settlementsOne']=$output->settlementsOne;
        $data['property']=$output->property;
        $data['documents']=$output->documents;

        $this->db->trans_begin();

        $case_name=$this->SettlementApiModel->genearteCaseName();
        if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Seesion Out. Please try Again"
            );
            echo json_encode($data);
            exit;
            die();
        }
        $case_no['petition_no']=$petition_no=$this->SettlementApiModel->genearteSettlementPetitionNo();

        $case_no['case_no']=$case_name.$petition_no."/SETL";

        $basic=array(
            'dist_code'=>$this->input->post('dist_code'),
            'subdiv_code'=>$this->input->post('subdiv_code'),
            'cir_code'=>$this->input->post('cir_code'),
            'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
            'lot_no'=>$this->input->post('lot_no'),
            'vill_townprt_code'=>$this->input->post('vill_townprt_code'),
            'service_code'=>$this->input->post('service_code'),
            'ref_no'=>$this->input->post('ref_no'),
            'case_no'=>$case_no['case_no'],
            'trans_code'=>'F',/////////full
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'date_entry' => date('Y-m-d G:i:s'),
            'status'=>'W',
            'user_code'=>$this->session->userdata('user_code'),
            'lm_code' => $this->session->userdata('user_code'),
            'submission_date' => date('Y-m-d G:i:s'),
            'from_office' => 'LM',
            'pending_officer' => 'CO',
            'pending_office' => 'CO',
            'period_possession'=>$this->input->post('period_possession'),
            'occupation_applicant'=>$this->input->post('occupation_applicant'),
            'applid'=>$this->input->post('applid')
            /////////
        );

        $insSetBasic = $this->db->insert('settlement_basic',$basic);
        if($insSetBasic != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRSET0001: Insertion failed in settlement_basic RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRSET0001: Registration of Settlement failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }
        ////settlement_dag_details insert start
        $fmd=array(
            'dist_code'=>$this->input->post('dist_code'),
            'subdiv_code'=>$this->input->post('subdiv_code'),
            'cir_code'=>$this->input->post('cir_code'),
            'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
            'lot_no'=>$this->input->post('lot_no'),
            'vill_townprt_code'=>$this->input->post('vill_townprt_code'),
            'user_code'=>$this->session->userdata('user_code'),
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'operation'=>'E',
        );



        $fmd['dag_no']= $this->input->post('dag_no');
        $fmd['patta_no']=$this->input->post('patta_no');
        $fmd['patta_type_code']=$this->input->post('patta_type_code');
        $fmd['dag_area_b']=$this->input->post('dag_area_b');
        $fmd['dag_area_k']=$this->input->post('dag_area_k');
        $fmd['dag_area_lc']=$this->input->post('dag_area_lc');
        $fmd['dag_area_g']=$this->input->post('dag_area_g');
        $fmd['dag_area_kr']=$this->input->post('dag_area_kr');
        $fmd['s_dag_area_b']=$this->input->post('s_dag_area_b');
        $fmd['s_dag_area_k']=$this->input->post('s_dag_area_k');
        $fmd['s_dag_area_lc']=$this->input->post('s_dag_area_lc');
        $fmd['s_dag_area_g']=$this->input->post('s_dag_area_g');
        $fmd['s_dag_area_kr']=$this->input->post('s_dag_area_kr');
        $fmd['is_urban']=trim($this->input->post('is_urban'));
        $fmd['revenue']=0;
        $insSetDag = $this->db->insert('settlement_dag_details',$fmd);
        // echo $this->db->last_query(); die();
        if($insSetDag != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRSET0002: Insertion failed in settlement_dag_details RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRSET0002: Registration of Settlement failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }
        ////settlement_dag_details insert end

        ////settlement_applicant insert start
        $i=1;
        foreach($data['settlements'] as $setl){

            if($this->input->post('pdar_id'.$i)=="" || $this->input->post('pdar_id'.$i)==null || empty($this->input->post('pdar_id'.$i)))
            {
                $chitha_pdar_id=-1;
            }else{
                $chitha_pdar_id=$this->input->post('pdar_id'.$i);
            }

            $applicant=array(
                'dist_code'=>$this->input->post('dist_code'),
                'subdiv_code'=>$this->input->post('subdiv_code'),
                'cir_code'=>$this->input->post('cir_code'),
                'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
                'lot_no'=>$this->input->post('lot_no'),
                'vill_townprt_code'=>$this->input->post('vill_townprt_code'),

                'user_code'=>$this->session->userdata('user_code'),
                'case_no'=>$case_no['case_no'],
                'petition_no'=>$case_no['petition_no'],
                'operation'=>'E',
                'dag_no' =>$this->input->post('dag_no'),
                'patta_no' =>$this->input->post('patta_no'),
                'patta_type_code'=>$this->input->post('patta_type_code'),
                'year_no'=>date('Y'),
                'date_entry'=>date('Y-m-d'),
                'pdar_id' =>$chitha_pdar_id,
                'pdar_cron_no'=>$i,
                'pdar_name' =>$this->input->post('pdar_name'.$i),
                'pdar_guardian' =>$this->input->post('pdar_guardian'.$i),

                'pdar_rel_guar' =>$this->input->post('pdar_rel_guar'.$i),
                'pdar_gender'=>$this->input->post('pdar_gender'.$i),
                // //'pdar_add1' => $part->address,
                'pdar_add1' => $this->input->post('pdar_add1'.$i),
                'pdar_add2' => $this->input->post('pdar_add2'.$i),
                'pdar_mobile' => $this->input->post('pdar_mobile'.$i),
                'i_area_b' => $this->input->post('i_area_b'.$i),
                'i_area_k' => $this->input->post('i_area_k'.$i),
                'i_area_lc' => $this->input->post('i_area_lc'.$i),
                'i_area_g' => $this->input->post('i_area_g'.$i),
                'i_area_kr' => $this->input->post('i_area_kr'.$i),
                'pdar_type' => $this->input->post('pdar_type'.$i),
            );
            $i++;

            $insSetApplicant = $this->db->insert('settlement_applicant',$applicant);

            if($insSetApplicant != 1)
            {
                // var_dump($insSetApplicant);
                // echo $this->db->last_query(); die();
                $this->db->trans_rollback();
                log_message('error', '#ERRSET0003: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRSET0003: Registration of Settlement failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }

        }


        ////settlement tribal LM Report insert start

        ////////////////////file///////////////////////////
        // var_dump("in file"); die();
        header('content-type:application/json');
        $case_no=$case_no['case_no'];
        $documents_config = json_decode(SETTLEMENT_TRIBAL_FILES);
        $validations=[];
        $document_details=[];
        log_message("error","------------FILE validation STARTED------------- ");
        foreach($documents_config as $key=>$value){
            $return= $this->SettlementApiModel->fileManualValidation($value);

            if(!is_null($return)){
                $return['status']==1 ? $validations[]= $return['validation']: $document_details[]= $return['data'];
            }
        }
        log_message("error","------------FILE validation ENDED--------------- ");
        if(!empty($validations)){
            echo json_encode(array(
                'responseType' => 1,
                'validation' => $validations
            ));
            return;
        }
        // NOW STORE THE FILE
        // $application_id = $_POST['application_id'];
        $documents=[];
        log_message("error","------------FILE SAVE STARTED------------- ");
        foreach($document_details as $value){
            log_message("error","doc data".json_encode($value));
            // $file_new_name= RTPS_CODE.'_'.$application_id . '_'.SETTLEMENT_AP_TRANSFER_ID.'_'.$value['file_name'].'.'.$value['extension'];
            $file_new_name= $value['file_name'].'.'.$value['extension'];
            $app_doc = $this->db->select('id')->from('supportive_document')->where(
                array('case_no'=>$case_no,'file_name'=>$value['file_details'])
            )->get()->row();

            log_message("error","doc data".json_encode(empty($app_doc)));
            $document= array(
                'case_no' => $case_no,
                'file_name' => $value['file_details'],
                'user_code' => $this->session->userdata('user_code'),
                'fetch_file_name' => $file_new_name,
                'file_type' => $value['content_type'],
                'file_path' => UPLOAD_DIR.$file_new_name,
                'date_entry' => date('Y-m-d h:i:s'),
                'mut_type' => $this->input->post('service_code'),
            );
            // var_dump($document); die();
            if(empty($app_doc)){
                $status= $this->db->insert('supportive_document',$document);
                log_message("error","insert doc status:".json_encode($status));
                log_message("error","last query".json_encode($this->db->last_query()));
            }
            //else{
            //     log_message("error","update doc");
            //     $this->db->where('id',$app_doc->id)->update('supportive_document',$document);
            //     log_message("error","last query".json_encode($this->db->last_query()));
            // }
            log_message("error","doc data".json_encode($document));
            move_uploaded_file($_FILES[$value['file_name']]['tmp_name'], UPLOAD_DIR.$file_new_name);
        }
        if ($this->db->trans_status() === FALSE) {
            log_message("error","------------FILE SAVE ENDED WITH ERROR------------- ");
            $this->db->trans_rollback();
            echo json_encode(array(
                'responseType' => 3,
                'error' => 'Something Went wrong!!!'
            ));
            return;
        } else {
            log_message("error","------------FILE SAVE END------------- ");
            // echo json_encode(array(
            //     'responseType' => 2
            //     // 'application_id' => $application_id
            // ));
        }

        ///////////////////////////////////////////////

        $comment = addslashes($this->input->post('lm_remark'));
        $r_bigha = $this->input->post('reserved_bigha');
        $r_katha = $this->input->post('reserved_katha');
        $r_lessa = $this->input->post('reserved_lessa');
        $r_ganda = $this->input->post('reserved_ganda');
        $r_kranti = $this->input->post('reserved_kranti');

        $lmnote=array(
            'user_code'=>$this->session->userdata('user_code'),
            'chitha_verified'=>$this->input->post('chiitha_verified'),
            'vlb_verified'=>$this->input->post('vlb_verified'),
            'possession_verification'=>$this->input->post('possession_verified'),
            'period_possession'=>$this->input->post('period_possession'),
            'nature_possession'=>$this->input->post('nature_possession'),
            'applicant_occupation'=>$this->input->post('applicant_occupation'),
            'is_landless'=>$this->input->post('is_landless'),
            'land_falls'=>$this->input->post('land_falls'),
            'falls_und_gmc'=>$this->input->post('falls_und_gmc'),
            'roadside_reservation'=>$this->input->post('roadside_reservation'),
            'landed_property'=>$this->input->post('landed_property'),
            'is_st'=>$this->input->post('is_st'),
            'is_tribal_belt'=>$this->input->post('is_tribal_belt'),
            // 'trace_map_copy'=>$this->input->post('trace_map_copy'),
            // 'chitha_copy'=>$this->input->post('chitha_copy'),
            'trace_map_copy'=>'NA',
            'chitha_copy'=>'NA',
            'lm_note'=>$comment,
            'date_entry'=>date('Y-m-d h:i:s'),
            'case_no'=>$case_no,
            'status'=>'W',
            'r_bigha'=>$r_bigha,
            'r_katha'=>$r_katha,
            'r_lessa'=>$r_lessa,
            'r_ganda'=>$r_ganda,
            'r_kranti'=>$r_kranti,
            'total_bigha'=>$this->input->post('total_bigha'),
            'total_Katha'=>$this->input->post('total_Katha'),
            'total_lessa'=>$this->input->post('total_lessa'),
            'total_ganda'=>$this->input->post('total_ganda'),
            'total_kranti'=>$this->input->post('total_kranti'),
        );

        $insLmnote = $this->db->insert('settlement_ap_lmnote',$lmnote);
        if($insLmnote != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRSET0005: Insertion failed in settlement_ap_lmnote RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRSET0005: Registration of Settlement failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }
        //////proceeding start//////
        $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

        if($proceeding_id==null){
            $proceeding_id=1;
        }

        $insPetProceed = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'note_on_order' => $comment,
            'status' => 'W',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d h:i:s'),
            'operation' => 'E',
            'ip' => $this->utilityclass->get_client_ip(),
            'office_from' => 'LM',
            'office_to' => 'CO',
            'task' => 'LM note submitted'
        ];
        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

        // echo $this->db->last_query(); die();
        if($insertProceeding != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
            $json = [
                'errorMessage'=>"#ERRORPP: Failed to forward the case for Case No : ".$case_no
            ];
            echo json_encode($json);
            return false;
        }
        //////proceeding end//////

        ////settlement AP LM Report insert end

        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            $data=array(
                'error'=>"Error in submitting. Please try Again"
            );
        }else
        {
            $basundhara=array(
                'dharitree'=>$case_no,
                'basundhara'=>$application_no,
                'date_reg'=>date('Y-m-d'),
                'reg_by'=>$this->session->userdata('user_code'),
                'app_status'=>'M',
                'pending_with'=>'LM'
            );
            $this->db->insert('basundhar_application',$basundhara);


            //////////////POST To basundhara/////////////////////
            $rmk='Forwarded to CO';
            $status='W';
            $task='LM';
            $pen='CO';
            $case=$case_no;
            $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
            $rtps_status=json_decode($rtps_status);
            //var_dump($rtps_status);
            if(trim($rtps_status)!="y"){
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error #ERRAPP0011: Settlement Application not submitted case no # $case_no");
                redirect(base_url() . "index.php/home");
            }else{
                $this->db->trans_commit();
            }

            //////////////////
            // $this->DashboardInheritance($case_no['case_no']);
            //////
            //////////////////////////////////
            $this->session->set_flashdata('message', "Settlement Application Registered Successfully with case no # $case_no");
            redirect(base_url() . "index.php/home");

            // $data=array(
            //     'success'=>"Settlement Application Registered Successfully with case no $case_no[case_no]",
            //     'redirect_url'=>base_url().'index.php/home'
            // );
        }
        // echo json_encode($data);
    }
    ///settlement Tribal post end ////

    function settlementCasesCountDC(){
        $d=$this->session->userdata('dist_code');
        $this->session->unset_userdata('searchKeyword');
        $url = API_LINK_MB2."districtDashboard/$d" ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $output = curl_exec($ch);
        curl_close($ch);
        $district['output'] = json_decode($output);
        // var_dump($output);
        // exit;
        $district['_view'] = 'basundhara/settlement_cases_count_dc';
        $this->load->view('layouts/main',$district);
    }

    function settlementCasesCountCO(){
        $d=$this->session->userdata('dist_code');
        $s=$this->session->userdata('subdiv_code');
        $c=$this->session->userdata('cir_code');
        $this->session->unset_userdata('searchKeyword');
        $url = API_LINK_MB2."circleDashboard/$d/$s/$c" ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $output = curl_exec($ch);
        curl_close($ch);
        $district['output'] = json_decode($output);
        //var_dump($output);
        // exit;
        $district['_view'] = 'basundhara/settlement_cases_count_co';
        $this->load->view('layouts/main',$district);
    }

    function settlementApplication()
    {
        $application_no = $this->input->get('app');
        // $url = API_LINK_MB2."serviceResponse?application_no=" . $application_no ;
        //$url = API_LINK_MB2."serviceResponseBasu?application_no=" . $application_no ;
        $url = API_LINK_MB2."getAppDetails?application_no=" . $application_no ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        // echo "<pre>";
        // var_dump($output); die();
        $district['app']=$output->application;
        $district['pattaNo']=$this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$district['app']->dag_no);

        // var_dump($district['app']); die();

        $district['applicants']=$output->applicants;
        $district['document']=$output->documents;
        $district['query']=$output->query;
        $district['property']=$output->property;
        $district['settlements']=$output->settlements;
        $district['encroachers'] = $output->encroachers;
        $district['owners'] = $output->owners;
        $district['riotee_noks'] = $output->riotee_noks;
        $district['aadhar']=$output->aadhar;
        $district['nextKin'] = $output->nextKin;
        // get khatian number
        $d=$district['app']->dist_code;
        $s=$district['app']->subdiv_code;
        $c=$district['app']->cir_code;
        $m=$district['app']->mouza_code;
        $l=$district['app']->lot_no;
        $v=$district['app']->village_code;
        // $pno=$district['pattaNo']->patta_no;
        // $pc=$district['pattaNo']->patta_type_code;
        $dag = $district['app']->dag_no;

        $co_name = $this->db->query("Select users.username, loginuser_table.user_code, users.user_desig_code from  users, loginuser_table where users.dist_code = loginuser_table.dist_code "
            . "and users.user_code = loginuser_table.user_code and users.dist_code='$d' and "
            . "users.subdiv_code='$s' and users.cir_code='$c' and loginuser_table.dis_enb_option = 'E'")->result();

        $district['co_name'] = $co_name;

        $district['bhumi'] = $output->bhumi;

        if($this->utilityclass->checkUserAuthForCaseForLm($d,$s,$c,$m,$l) == false){
            $this->session->set_flashdata('message', "Unauthorized access for case no # ".$application_no);
            redirect(base_url() . "index.php/home");
        }

        $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE applid = ? AND file_name = ? ", array($application_no, GEO_TAG_PHOTO) );

        if($supportive_document_sql == true){
            if($supportive_document_sql->num_rows() > 0){
                $district['geo_tag_doc'] = $supportive_document_sql->result();
            }else{
                $district['geo_tag_doc_empty'] = "Geo tag photo yet to be uploaded.";
            }
        }


        // fetch riotee noks -js- 05-09-2022

        if($output->riotee_noks == true){
            $district['riotee_nok'] = $output->riotee_noks;
        }
        // $district['selfDeclarationDetails'] = $output->selfDeclaration;
        foreach($output->selfDeclaration as $selfDec){
            $district['selfDeclarationDetails']=json_decode($selfDec->dec_details);
        }


        // var_dump($district['aadhar']); die();
        if($district['app']->service_code=='18' ){
            //$vlb_encc=[];
            if($output->encroachers == true){
                $district['riotee'] = $output->encroachers;
                foreach($output->encroachers as $encroacher){
                    //echo "<pre>";
                    // var_dump($encroacher);
                    // exit;

                    $vlb_encroacher = $this->SettlementApModel->getEncroacherDetails($d, $s, $c, $m, $l, $v, $encroacher->dag_no);
                    $district['vlb_enc'] = $vlb_encroacher;

                    //    var_dump($district['vlb_enc']); die();
                    if($vlb_encroacher == true){
                        // getting the encroacher details
                        $vlb_encroacher_in_dag = $this->SettlementApModel->getEncroacherInDag($vlb_encroacher->id);
                        //var_dump($vlb_encroacher_in_dag); die();

                        $vlb_encc[] = $vlb_encroacher_in_dag;

                    }else{
                        $district['empty_err'] = "No Land Bank Details found!!";
                    }
                }
                $district['vlb_enc_details']=$vlb_encc;
            }


            $district['_view'] = 'SettlementView/SettlementCultivatorsView';
        }

        elseif($district['app']->service_code=='13' ){
            foreach($output->settlements as $settlements){
                if($settlements->khatian_no == true){
                    $district['khatian_no'] = $settlements->khatian_no;
                }
            }
            //    fetch encroachers -js- 05-09-2022
            if($output->encroachers == true){
                foreach($output->encroachers as $encroacher){
                    $khatian_no = $encroacher->khatian_no;
                    $query = "SELECT
                                    *
                                    FROM
                                        chitha_tenant
                                        WHERE
                                            subdiv_code='$s'
                                            AND
                                            cir_code='$c'
                                            AND
                                            lot_no='$l'
                                            AND
                                            mouza_pargona_code='$m'
                                            AND
                                            vill_townprt_code='$v'
                                            AND
                                            dag_no ='$encroacher->dag_no'
                                            AND
                                            khatian_no ='$encroacher->khatian_no'
                                            AND
                                            tenant_id = '$encroacher->riotee_id'";
                    $riotee = $this->db->query($query)->result();
                    $district['riotee'] = $riotee;
                }
            }
            $district['riotee_list'] = $this->SettlementTenantModel->getRioteeList($d,$s,$c,$m,$l,$v,$dag,$khatian_no);
            $district['_view'] = 'SettlementView/SettlementTenantView';
        }
        elseif($district['app']->service_code=='14' ){
            //    $district['_view'] = 'basundhara/settlementap_updation';
            $district['_view'] = 'SettlementView/SettlementApTransferred';
        }
        elseif($district['app']->service_code=='15' ){
            if($output->encroachers == true){
                $district['riotee'] = $output->encroachers;
                foreach($output->encroachers as $encroacher){
                    //echo "<pre>";
                    //var_dump($encroacher);

                    $vlb_encroacher = $this->SettlementApModel->getEncroacherDetails($d, $s, $c, $m, $l, $v, $encroacher->dag_no);
                    $district['vlb_enc'] = $vlb_encroacher;

                    if($vlb_encroacher == true){
                        // getting the encroacher details

                        $vlb_encroacher_in_dag = $this->SettlementApModel->getEncroacherInDag($vlb_encroacher->id);
                        //var_dump($vlb_encroacher_in_dag); die();

                        $vlb_encc[] = $vlb_encroacher_in_dag;
                    }else{
                        $district['empty_err'] = "No Land Bank Details found!!";
                    }
                }
                $district['vlb_enc_details']=$vlb_encc;
            }
            $district['_view'] = 'SettlementView/SettlementTribalView';
        }

        elseif($district['app']->service_code=='16' ){
            $vlb_encc=[];
            if($output->encroachers == true){
                $district['riotee'] = $output->encroachers;
                foreach($output->encroachers as $encroacher){
                    //echo "<pre>";
                    // var_dump($encroacher);

                    $vlb_encroacher = $this->SettlementApModel->getEncroacherDetails($d, $s, $c, $m, $l, $v, $encroacher->dag_no);

                    $district['vlb_enc'] = $vlb_encroacher;

                    if($vlb_encroacher == true){
                        // getting the encroacher details

                        $vlb_encroacher_in_dag = $this->SettlementApModel->getEncroacherInDag($vlb_encroacher->id);
                        //var_dump($vlb_encroacher_in_dag); die();

                        $vlb_encc[] = $vlb_encroacher_in_dag;

                    }else{
                        $district['empty_err'] = "No Land Bank Details found!!";
                    }
                }
                $district['vlb_enc_details']=$vlb_encc;
                // var_dump($district['vlb_enc_details']);
                // die();

            }

            $district['_view'] = 'SettlementView/SettlementKhasLandView';
        }

        elseif($district['app']->service_code=='17' ){
            $vlb_encc=[];
            if($output->encroachers == true){
                $district['riotee'] = $output->encroachers;
                foreach($output->encroachers as $encroacher){
                    //echo "<pre>";
                    // var_dump($encroacher);

                    $vlb_encroacher = $this->SettlementApModel->getEncroacherDetails($d, $s, $c, $m, $l, $v, $encroacher->dag_no);

                    $district['vlb_enc'] = $vlb_encroacher;

                    if($vlb_encroacher == true){
                        // getting the encroacher details
                        $vlb_encroacher_in_dag = $this->SettlementApModel->getEncroacherInDag($vlb_encroacher->id);
                        $vlb_encc[] = $vlb_encroacher_in_dag;

                    }else{
                        $district['empty_err'] = "No Land Bank Details found!!";
                    }
                }
                $district['vlb_enc_details']=$vlb_encc;

            }
            $district['villagelist']  = $this->SettlementVgrModel->getVillageList($d,$s,$c,$m,$l);
            $district['_view'] = 'SettlementView/SettlementVgrView';
        }
        $this->load->view('layouts/main',$district);
    }

    public function khatian() {
        $st = $this->input->get('st');
        $end = $this->input->get('end');
        $d = $this->input->get('dist');
        $s = $this->input->get('subdiv_code');
        $c = $this->input->get('cir_code');
        $m = $this->input->get('mouza_code');
        $l = $this->input->get('lot_no');
        $v = $this->input->get('village_code');
        // $st = $this->input->post('start');
        // $end = $this->input->post('end');
        $query = "select * from khatian as c where c.dist_code='$d' and c.subdiv_code='$s' and "
            . " c.cir_code='$c' and c.mouza_pargona_code='$m' and c.lot_no='$l' and c.vill_townprt_code='$v' and  c.id BETWEEN $st AND $end";
        //echo $query;
        $kts = $this->db->query($query)->result();
        $allData = array();
        foreach ($kts as $kt) {
            //var_dump($kt);
            $query = "select distinct on (tenant_name, tenants_father) * from chitha_tenant where dist_code='$d' and subdiv_code='$s' and "
                . " cir_code='$c' and mouza_pargona_code='$m' and lot_no='$l' and vill_townprt_code='$v' and khatian_no=$kt->id ";
            //echo $query;
            $allData[$kt->id][$kt->dag_no]['tenants'] = $this->db->query($query)->result();
            //var_dump($allData);
            $query = "select * from chitha_basic where dist_code='$d' and subdiv_code='$s' and "
                . " cir_code='$c' and mouza_pargona_code='$m' and lot_no='$l' and vill_townprt_code='$v' and dag_no='$kt->dag_no'";
            //echo $query;
            $allData[$kt->id][$kt->dag_no]['cb'] = $this->db->query($query)->result();
            $query = " select * from chitha_pattadar cp,chitha_dag_pattadar dp where TRIM(cp.patta_no)=TRIM(dp.patta_no) and cp.patta_type_code=dp.patta_type_code and"
                . " cp.dist_code=dp.dist_code and cp.subdiv_code=dp.subdiv_code and "
                . " cp.cir_code=dp.cir_code and cp.mouza_pargona_code=dp.mouza_pargona_code and cp.lot_no=dp.lot_no and "
                . "cp.vill_townprt_code =dp.vill_townprt_code and cp.pdar_id = dp.pdar_id and dp.dist_code='$d' and dp.subdiv_code='$s' and "
                . " dp.cir_code='$c' and dp.mouza_pargona_code='$m' and dp.lot_no='$l' and dp.vill_townprt_code='$v' and dp.dag_no='$kt->dag_no' and dp.p_flag!='1'"
                . "";
            $allData[$kt->id][$kt->dag_no]['pattadars'] = $this->db->query($query)->result();
            $query = "select * from khatian where dist_code='$d' and subdiv_code='$s' and "
                . " cir_code='$c' and mouza_pargona_code='$m' and lot_no='$l' and vill_townprt_code='$v'  and dag_no='$kt->dag_no'";
            // echo $query;
            $allData[$kt->id][$kt->dag_no]['khatians'] =$this->db->query($query)->result();
        }
        $data['all'] = $allData;
        $data['_view'] = 'khatian/khatian';
        $this->load->view('layouts/main',$data);
    }













    ///////////////////////////////  NEW WORK /////////////////////////////////////


    // settlement khas post new
    function settlementKhasPostNew()
    {
        $application_no = trim($this->input->post('application_no'));
        $distCode = trim($this->input->post('dist_code'));
        if($distCode == NULL)
        {
            redirect(base_url(). 'index.php/basundhara2/settlementCases');
        }
        if($application_no == NULL)
        {
            redirect(base_url(). 'index.php/basundhara2/settlementCases');
        }
        $this->load->library('form_validation');

        $this->form_validation->set_rules('service_code', 'Service Code', 'trim|required|is_natural');
        $this->form_validation->set_rules('lot_no', 'Lot Number', 'trim|required');
        $this->form_validation->set_rules('application_no', 'Application No', 'trim|required|min_length[2]');
        $this->form_validation->set_rules('ref_no', 'Application No', 'trim|required|min_length[10]');
        $this->form_validation->set_rules('is_urban', 'Is Urban', 'trim|required');
        $this->form_validation->set_rules('uuid', 'uuid', 'trim|required');
        $this->form_validation->set_rules('dist_name', 'District Name', 'trim|required');
        $this->form_validation->set_rules('dist_code', 'District Code', 'trim|required');
        $this->form_validation->set_rules('subdiv_name', 'Sub Division Name', 'trim|required');
        $this->form_validation->set_rules('subdiv_code', 'Sub Division Code', 'trim|required');
        $this->form_validation->set_rules('circle_name', 'Circle Name', 'trim|required');
        $this->form_validation->set_rules('cir_code', 'Circle Code', 'trim|required');
        $this->form_validation->set_rules('mouza_name', ' Mouza Name', 'trim|required');
        $this->form_validation->set_rules('mouza_pargona_code', 'Mouza Code ', 'trim|required');
        $this->form_validation->set_rules('village_name', 'Village Name ', 'trim|required');
        $this->form_validation->set_rules('vill_townprt_code', 'Village Code ', 'trim|required');
        $this->form_validation->set_rules('occupation_applicant', 'Schedule of the land and area under occupation', 'trim|required');
        $this->form_validation->set_rules('caste', 'Caste', 'trim|required');

        $this->form_validation->set_rules('chiitha_verified', 'Chitha Verified', 'trim|required');
        $this->form_validation->set_rules('vlb_verified', 'VLB Verified', 'trim|required');
        $this->form_validation->set_rules('bhumiputra_confirmation_lm', 'Bhumiputra Verified', 'trim|required');
        $this->form_validation->set_rules('whether_tribal', 'Whether Tribal', 'trim|required');
        $this->form_validation->set_rules('protected_class_lm', 'Protected Category', 'trim|required|is_natural|greater_than[0]');
        $this->form_validation->set_rules('landslide', ' Is Area Under cover landslide clone ', 'trim|required');
        $this->form_validation->set_rules('erosion', ' Is Land falls under erosion ', 'trim|required');
        $this->form_validation->set_rules('encroacher_exist_vlb', 'Is Encroacher Exists in VLB ?', 'trim|required');
        $this->form_validation->set_rules('possession_verified', 'Possession Verified', 'trim|required');
        $this->form_validation->set_rules('nature_possession', 'Nature of Possession', 'trim|required');
        $this->form_validation->set_rules('is_landless', '. Whether application is landless', 'trim|required');
        $this->form_validation->set_rules('land_falls', 'Whether the proposed land falls under', 'trim|required|is_natural|greater_than[0]');
        $this->form_validation->set_rules('falls_und_gmc', 'Falls Under GMC', 'trim|required');
        $this->form_validation->set_rules('roadside_comment_check', 'Roadside/Riverside Reservation', 'trim|required');
        $this->form_validation->set_rules('family_comment_check', ' Whether applicant family has occupied any land', 'trim|required');
        $this->form_validation->set_rules('zonal_valuation', 'Zonal Valuation', 'trim|required|numeric|greater_than[0]');
//        $this->form_validation->set_rules('field_report', 'Field Report', 'trim|required');
        $this->form_validation->set_rules('lm_remark', 'LM Remarks', 'trim|required');
        $this->form_validation->set_rules('lm_remark_text', 'LM Remarks (Text Area)', 'trim|required');
        $this->form_validation->set_rules('co_code', 'Select Circle Officer', 'trim|required');


        $url = API_LINK_MB2."getAppDetails?application_no=" . $application_no ;
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

        $district['applicants']=$output->applicants;
        $district['document']=$output->documents;
        $district['query']=$output->query;
        $district['property']=$output->property;
        $district['settlements']=$output->settlements;
        $district['encroachers'] = $output->encroachers;
        $district['owners'] = $output->owners;
        $district['riotee_noks'] = $output->riotee_noks;
        $district['aadhar']=$output->aadhar;
        $district['nextKin'] = $output->nextKin;

        $d=$district['app']->dist_code;
        $s=$district['app']->subdiv_code;
        $c=$district['app']->cir_code;
        $m=$district['app']->mouza_code;
        $l=$district['app']->lot_no;
        $v=$district['app']->village_code;
        $pno=$district['pattaNo']->patta_no;
        $pc=$district['pattaNo']->patta_type_code;
        $dag = $district['app']->dag_no;

        $roadside_comment_check=$this->input->post('roadside_comment_check');
        $family_comment_check=$this->input->post('family_comment_check');

        $totalDagAreaLessaValidation = 0;
        $totalAgrAreaLessaValidation = 0;
        $totalHomeAreaLessaValidation = 0;
        $appAreaMoreThanDagA = 0;
        $reserveMoreThanAppArea = 0;
        $familyMoreThanAppArea = 0;
        $fishAreaLessaValidation = 0;
        $totalRoadSideAreaLessaValidation = 0;
        $totalFamilyAreaLessaValidation = 0;
        $totalFishAreaLessaValidation = 0;

        foreach($district['encroachers'] as $dags)
        {
            // for barak valley
            if(in_array($distCode, json_decode(BARAK_VALLEY)))
            {
                $this->form_validation->set_rules('dag_no'.$dags->id, 'Dag Number', 'trim|required|is_natural');
                $this->form_validation->set_rules('patta_no'.$dags->id, 'Patta Number', 'trim|required|is_natural');
                $this->form_validation->set_rules('patta_type_code'.$dags->id, 'Patta Type Code', 'trim|required|is_natural');
                $this->form_validation->set_rules('land_type'.$dags->id, 'Land Type', 'trim|required|is_natural');
                $this->form_validation->set_rules('dag_area_b'.$dags->id, 'Total Land Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                $this->form_validation->set_rules('dag_area_k'.$dags->id, 'Total Land Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                $this->form_validation->set_rules('dag_area_lc'.$dags->id, 'Total Land Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('dag_area_g'.$dags->id, 'Total Land Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('dag_area_kr'.$dags->id, 'Total Land Area (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('mbigha'.$dags->id, 'Applied Homestead Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                $this->form_validation->set_rules('mkatha'.$dags->id, 'Applied Homestead Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                $this->form_validation->set_rules('mlessa'.$dags->id, 'Applied Homestead Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('mganda'.$dags->id, 'Applied Homestead Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('mkranti'.$dags->id, 'Applied Homestead Area (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('agri_bigha'.$dags->id, 'Applied Agricultural Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                $this->form_validation->set_rules('agri_katha'.$dags->id, 'Applied Agricultural Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                $this->form_validation->set_rules('agri_lessa'.$dags->id, 'Applied Agricultural Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('agri_ganda'.$dags->id, 'Applied Agricultural Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('agri_kranti'.$dags->id, 'Applied Agricultural Area (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('fbigha'.$dags->id, 'Applied Fishery Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                $this->form_validation->set_rules('fkatha'.$dags->id, 'Applied Fishery Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                $this->form_validation->set_rules('flessa'.$dags->id, 'Applied Fishery Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('fganda'.$dags->id, 'Applied Fishery Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('fkranti'.$dags->id, 'Applied Fishery Area (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'.$dags->id), 0);
                $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'.$dags->id), 0);
                $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'.$dags->id), 0);
                $gandaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_g'.$dags->id), 0);

                $bighaValidationHome = $this->UtilsModel->defaultValue($this->input->post('mbigha'.$dags->id), 0);
                $kathaValidationHome = $this->UtilsModel->defaultValue($this->input->post('mkatha'.$dags->id), 0);
                $lessaValidationHome = $this->UtilsModel->defaultValue($this->input->post('mlessa'.$dags->id), 0);
                $gandaValidationHome = $this->UtilsModel->defaultValue($this->input->post('mganda'.$dags->id), 0);

                $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_bigha'.$dags->id), 0);
                $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_katha'.$dags->id), 0);
                $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_lessa'.$dags->id), 0);
                $gandaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_ganda'.$dags->id), 0);

                $bighaValidationFish = $this->UtilsModel->defaultValue($this->input->post('fbigha'.$dags->id), 0);
                $kathaValidationFish = $this->UtilsModel->defaultValue($this->input->post('fkatha'.$dags->id), 0);
                $lessaValidationFish = $this->UtilsModel->defaultValue($this->input->post('flessa'.$dags->id), 0);
                $gandaValidationFish = $this->UtilsModel->defaultValue($this->input->post('fganda'.$dags->id), 0);

                $dagAreaLessaValidation  = ($bighaValidation * 6400) + ($kathaValidation * 320) + ($lessaValidation * 20) + $gandaValidation;
                $homeAreaLessaValidation = ($bighaValidationHome * 6400) + ($kathaValidationHome * 320) + ($lessaValidationHome * 20) + $gandaValidationHome;
                $agrAreaLessaValidation  = ($bighaValidationAgr * 6400) + ($kathaValidationAgr * 320) + ($lessaValidationAgr * 20) + $gandaValidationAgr;
                $fishAreaLessaValidation = ($bighaValidationFish * 6400) + ($kathaValidationFish * 320) + ($lessaValidationFish * 20) + $gandaValidationFish;

                if($dagAreaLessaValidation < $agrAreaLessaValidation + $homeAreaLessaValidation + $fishAreaLessaValidation)
                {
                    $appAreaMoreThanDagA = 1;
                }

                $totalDagAreaLessaValidation  += $dagAreaLessaValidation;
                $totalHomeAreaLessaValidation += $homeAreaLessaValidation;
                $totalAgrAreaLessaValidation  += $agrAreaLessaValidation;
                $totalFishAreaLessaValidation += $fishAreaLessaValidation;

                if($roadside_comment_check=='YES')
                {
                    $this->form_validation->set_rules('reserved_dag_road'.$dags->id, 'Reserved Dag', 'trim|required|is_natural');
                    $this->form_validation->set_rules('reserved_patta_road'.$dags->id, 'Reserved Patta ', 'trim|required|is_natural');
                    $this->form_validation->set_rules('reserved_bigha'.$dags->id, 'Reserved Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('reserved_katha'.$dags->id, 'Reserved Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                    $this->form_validation->set_rules('reserved_lessa'.$dags->id, 'Reserved Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('reserved_ganda'.$dags->id, 'Reserved Ganda', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('reserved_kranti'.$dags->id, 'Reserved Kranti', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $bighaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha'.$dags->id), 0);
                    $kathaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_katha'.$dags->id), 0);
                    $lessaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa'.$dags->id), 0);
                    $gandaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_ganda'.$dags->id), 0);

                    $roadSideAreaLessaValidation = ($bighaValidationRoadside * 6400) + ($kathaValidationRoadside * 320) + ($lessaValidationRoadside * 20) + $gandaValidationRoadside;

                    if($agrAreaLessaValidation + $homeAreaLessaValidation < $roadSideAreaLessaValidation)
                    {
                        $reserveMoreThanAppArea = 1;
                    }
                    $totalRoadSideAreaLessaValidation += $roadSideAreaLessaValidation;


                }
                if($family_comment_check=='YES')
                {
                    $this->form_validation->set_rules('reserved_dag_family'.$dags->id, 'Reserved Family Dag', 'trim|required|is_natural');
                    $this->form_validation->set_rules('reserved_patta_family'.$dags->id, 'Reserved Family Patta ', 'trim|required|is_natural');
                    $this->form_validation->set_rules('reserved_bigha_family'.$dags->id, 'Reserved Family Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('reserved_katha_family'.$dags->id, 'Reserved Family Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                    $this->form_validation->set_rules('reserved_lessa_family'.$dags->id, 'Reserved Family Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('reserved_ganda_family'.$dags->id, 'Reserved Family Ganda', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('reserved_kranti_family'.$dags->id, 'Reserved Family Kranti', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $bighaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha_family'.$dags->id), 0);
                    $kathaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_katha_family'.$dags->id), 0);
                    $lessaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa_family'.$dags->id), 0);
                    $gandaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_ganda_family'.$dags->id), 0);

                    $familyAreaLessaValidation = ($bighaValidationFamily * 6400) + ($kathaValidationFamily * 320) + ($lessaValidationFamily * 20) + $gandaValidationFamily;
                    if($agrAreaLessaValidation + $homeAreaLessaValidation < $familyAreaLessaValidation)
                    {
                        $familyMoreThanAppArea = 1;
                    }

                    $totalFamilyAreaLessaValidation += $familyAreaLessaValidation;
                }
            }
            else
            {
                $this->form_validation->set_rules('dag_no'.$dags->id, 'Dag Number', 'trim|required|is_natural');
                $this->form_validation->set_rules('patta_no'.$dags->id, 'Patta Number', 'trim|required|is_natural');
                $this->form_validation->set_rules('patta_type_code'.$dags->id, 'Patta Type Code', 'trim|required|is_natural');
                $this->form_validation->set_rules('dag_area_b'.$dags->id, 'Total Land Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                $this->form_validation->set_rules('dag_area_k'.$dags->id, 'Total Land Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                $this->form_validation->set_rules('dag_area_lc'.$dags->id, 'Total Land Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('mbigha'.$dags->id, 'Applied Homestead Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                $this->form_validation->set_rules('mkatha'.$dags->id, 'Applied Homestead Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                $this->form_validation->set_rules('mlessa'.$dags->id, 'Applied Homestead Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('agri_bigha'.$dags->id, 'Applied Agricultural Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                $this->form_validation->set_rules('agri_katha'.$dags->id, 'Applied Agricultural Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                $this->form_validation->set_rules('agri_lessa'.$dags->id, 'Applied Agricultural Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('fbigha'.$dags->id, 'Applied Fishery Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                $this->form_validation->set_rules('fkatha'.$dags->id, 'Applied Fishery Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                $this->form_validation->set_rules('flessa'.$dags->id, 'Applied Fishery Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('land_type'.$dags->id, 'Land Type', 'trim|required|is_natural');

                $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'.$dags->id), 0);
                $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'.$dags->id), 0);
                $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'.$dags->id), 0);

                $bighaValidationHome = $this->UtilsModel->defaultValue($this->input->post('mbigha'.$dags->id), 0);
                $kathaValidationHome = $this->UtilsModel->defaultValue($this->input->post('mkatha'.$dags->id), 0);
                $lessaValidationHome = $this->UtilsModel->defaultValue($this->input->post('mlessa'.$dags->id), 0);

                $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_bigha'.$dags->id), 0);
                $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_katha'.$dags->id), 0);
                $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_lessa'.$dags->id), 0);

                $bighaValidationFish = $this->UtilsModel->defaultValue($this->input->post('fbigha'.$dags->id), 0);
                $kathaValidationFish = $this->UtilsModel->defaultValue($this->input->post('fkatha'.$dags->id), 0);
                $lessaValidationFish = $this->UtilsModel->defaultValue($this->input->post('flessa'.$dags->id), 0);

                $dagAreaLessaValidation  = ($bighaValidation * 100) + ($kathaValidation * 20) + $lessaValidation;
                $homeAreaLessaValidation = ($bighaValidationHome * 100) + ($kathaValidationHome * 20) + $lessaValidationHome;
                $agrAreaLessaValidation  = ($bighaValidationAgr * 100) + ($kathaValidationAgr * 20) + $lessaValidationAgr;
                $fishAreaLessaValidation = ($bighaValidationFish * 100) + ($kathaValidationFish * 20) + $lessaValidationFish;

                if($dagAreaLessaValidation < $agrAreaLessaValidation + $homeAreaLessaValidation + $fishAreaLessaValidation)
                {
                    $appAreaMoreThanDagA = 1;
                }

                $totalDagAreaLessaValidation  += $dagAreaLessaValidation;
                $totalHomeAreaLessaValidation += $homeAreaLessaValidation;
                $totalAgrAreaLessaValidation  += $agrAreaLessaValidation;
                $totalFishAreaLessaValidation += $fishAreaLessaValidation;

                if($roadside_comment_check=='YES')
                {
                    $this->form_validation->set_rules('reserved_dag_road'.$dags->id, 'Reserved Dag', 'trim|required|is_natural');
                    $this->form_validation->set_rules('reserved_patta_road'.$dags->id, 'Reserved Patta ', 'trim|required|is_natural');
                    $this->form_validation->set_rules('reserved_bigha'.$dags->id, 'Reserved Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('reserved_katha'.$dags->id, 'Reserved Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                    $this->form_validation->set_rules('reserved_lessa'.$dags->id, 'Reserved Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $bighaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha'.$dags->id), 0);
                    $kathaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_katha'.$dags->id), 0);
                    $lessaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa'.$dags->id), 0);

                    $roadSideAreaLessaValidation = ($bighaValidationRoadside * 100) + ($kathaValidationRoadside * 20) + $lessaValidationRoadside ;

                    if($agrAreaLessaValidation + $homeAreaLessaValidation < $roadSideAreaLessaValidation)
                    {
                        $reserveMoreThanAppArea = 1;
                    }

                    $totalRoadSideAreaLessaValidation += $roadSideAreaLessaValidation;
                }

                if($family_comment_check=='YES')
                {
                    $this->form_validation->set_rules('reserved_dag_family'.$dags->id, 'Reserved Family Dag', 'trim|required|is_natural');
                    $this->form_validation->set_rules('reserved_patta_family'.$dags->id, 'Reserved Family Patta ', 'trim|required|is_natural');
                    $this->form_validation->set_rules('reserved_bigha_family'.$dags->id, 'Reserved Family Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('reserved_katha_family'.$dags->id, 'Reserved Family Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                    $this->form_validation->set_rules('reserved_lessa_family'.$dags->id, 'Reserved Family Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $bighaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha_family'.$dags->id), 0);
                    $kathaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_katha_family'.$dags->id), 0);
                    $lessaValidationFamily = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa_family'.$dags->id), 0);

                    $familyAreaLessaValidation = ($bighaValidationFamily * 100) + ($kathaValidationFamily * 20) + $lessaValidationFamily;

                    if($agrAreaLessaValidation + $homeAreaLessaValidation < $familyAreaLessaValidation)
                    {
                        $familyMoreThanAppArea = 1;
                    }

                    $totalFamilyAreaLessaValidation += $familyAreaLessaValidation;
                }
            }
        }

        $deleted_applicants = $this->input->post('deleted_applicant');
        $deleteAppCon = 0;
        $delApplicants = [];
        if($deleted_applicants != '' or $deleted_applicants != NULL)
        {
            $deleteAppCon = 1;
            $allSplitApplicants = (explode(",",$deleted_applicants));
            $delApplicants = [];
            foreach ($allSplitApplicants as $mm)
            {
                $splitApplicants = (explode("_",$mm));
                $delApplicants[] = $splitApplicants[0];
            }
        }

        if($deleteAppCon == 1)
        {
            foreach($district['applicants'] as $setl)
            {
                if(in_array($setl->id, $delApplicants))
                {
                    continue;
                }
                else
                {
                    $this->form_validation->set_rules('pdar_name'.$setl->id, 'Pattadar Name', 'trim|required|min_length[3]|max_length[70]');
                    $this->form_validation->set_rules('pdar_guardian'.$setl->id, 'Pattadar Guardian', 'trim|required|min_length[3]|max_length[70]');
                    $this->form_validation->set_rules('pdar_rel_guar'.$setl->id, 'Pattadar Guardian Relation', 'trim|required');
                    $this->form_validation->set_rules('pdar_gender'.$setl->id, 'Pattadar Gender ', 'trim|required');
                    $this->form_validation->set_rules('pdar_add1'.$setl->id, 'Pattadar Address 1', 'trim|required|min_length[3]|max_length[200]');
                    $this->form_validation->set_rules('pdar_add2'.$setl->id, 'Pattadar Address 2', 'trim|required|min_length[3]|max_length[200]');
                    $this->form_validation->set_rules('pdar_mobile'.$setl->id, 'Pattadar Mobile No.', 'trim|required|min_length[10]|max_length[10]');
                    $this->form_validation->set_rules('pdar_type'.$setl->id, 'Pattadar Type', 'trim|required');

                }
            }
        }
        else
        {
            foreach($district['applicants'] as $setl)
            {
                $this->form_validation->set_rules('pdar_name' . $setl->id, 'Pattadar Name', 'trim|required|min_length[3]|max_length[70]');
                $this->form_validation->set_rules('pdar_guardian' . $setl->id, 'Pattadar Guardian', 'trim|required|min_length[3]|max_length[70]');
                $this->form_validation->set_rules('pdar_rel_guar' . $setl->id, 'Pattadar Guardian Relation', 'trim|required');
                $this->form_validation->set_rules('pdar_gender' . $setl->id, 'Pattadar Gender ', 'trim|required');
                $this->form_validation->set_rules('pdar_add1' . $setl->id, 'Pattadar Address 1', 'trim|required|min_length[3]|max_length[200]');
                $this->form_validation->set_rules('pdar_add2' . $setl->id, 'Pattadar Address 2', 'trim|required|min_length[3]|max_length[200]');
                $this->form_validation->set_rules('pdar_mobile' . $setl->id, 'Pattadar Mobile No.', 'trim|required|min_length[10]|max_length[10]');
                $this->form_validation->set_rules('pdar_type' . $setl->id, 'Pattadar Type', 'trim|required');
            }
        }

        if($_POST['pdar_name2'] != '' OR $_POST['pdar_name2'] != NULL OR $_POST['pdar_guardian2'] != '' OR $_POST['pdar_guardian2']
            != NULL OR $_POST['pdar_rel_guar2'] != '' OR $_POST['pdar_rel_guar2'] != NULL
            OR $_POST['pdar_gender2'] != '' OR $_POST['pdar_gender2'] != NULL) {

            $this->form_validation->set_rules('pdar_name2[]', 'Pattadar Name', 'trim|required|min_length[3]|max_length[70]');
            $this->form_validation->set_rules('pdar_guardian2[]', 'Pattadar Guardian', 'trim|required|min_length[3]|max_length[70]');
            $this->form_validation->set_rules('pdar_rel_guar2[]', 'Pattadar Guardian Relation', 'trim|required');
            $this->form_validation->set_rules('pdar_gender2[]', 'Pattadar Gender ', 'trim|required');
            $this->form_validation->set_rules('pdar_add12[]', 'Pattadar Address 1', 'trim|required|min_length[3]|max_length[200]');
            $this->form_validation->set_rules('pdar_add22[]', 'Pattadar Address 2', 'trim|required|min_length[3]|max_length[200]');
            $this->form_validation->set_rules('pdar_mobile2[]', 'Pattadar Mobile No.', 'trim|required|min_length[10]|max_length[10]');

        }

        if($output->encroachers == true)
        {
            foreach($output->encroachers as $enc_applicant)
            {
                $this->form_validation->set_rules('enc_dag'.$enc_applicant->id, 'Encroachers Dag Nu.', 'trim|required|is_natural');
                $this->form_validation->set_rules('patta_no'.$enc_applicant->id, 'Encroachers Patta No.', 'trim|required|is_natural');
                $this->form_validation->set_rules('patta_type_code'.$enc_applicant->id, 'Encroachers Pattadar Type ', 'trim|required|is_natural');
                $this->form_validation->set_rules('period_possession'.$enc_applicant->id, 'Encroachers Period Possession', 'trim|required');
                $this->form_validation->set_rules('riotee_name'.$enc_applicant->id, 'Encroachers Name', 'trim|required|min_length[3]|max_length[70]');
                $this->form_validation->set_rules('riotee_guardian'.$enc_applicant->id, 'Encroachers  Guardian', 'trim|required|min_length[3]|max_length[70]');
                $this->form_validation->set_rules('enc_id'.$enc_applicant->id, 'Encroacher Id', 'trim|required|is_natural');
            }
        }

        if ($this->form_validation->run() == FALSE)
        {
            $errors = validation_errors();
            $this->session->set_flashdata('error',$errors);
            redirect(base_url(). 'index.php/basundhara2/settlementApplication?app='.$application_no);
        }
        else
        {
            if($reserveMoreThanAppArea == 1)
            {
                $this->session->set_flashdata('error','Total roadside reserved area should not be more than total applied area  !');
                redirect(base_url(). 'index.php/basundhara2/settlementApplication?app='.$application_no);
            }
            if($familyMoreThanAppArea == 1)
            {
                $this->session->set_flashdata('error','Total family reserved area should not be more than total applied area  !');
                redirect(base_url(). 'index.php/basundhara2/settlementApplication?app='.$application_no);
            }
            if($totalHomeAreaLessaValidation + $totalAgrAreaLessaValidation + $totalFishAreaLessaValidation == 0)
            {
                $this->session->set_flashdata('error','Total applied area should not be Zero !');
                redirect(base_url(). 'index.php/basundhara2/settlementApplication?app='.$application_no);
            }
            if($appAreaMoreThanDagA == 1)
            {
                $this->session->set_flashdata('error','Total applied area should not be more than total Dag Area !');
                redirect(base_url(). 'index.php/basundhara2/settlementApplication?app='.$application_no);
            }

            // for barak valley
            if(in_array($distCode, json_decode(BARAK_VALLEY)))
            {
                if(KHAS_MAX_HOMESTEAD * 6400 < $totalHomeAreaLessaValidation)
                {
                    $this->session->set_flashdata('error','Total applied Homestead area should not be more than '. KHAS_MAX_HOMESTEAD. ' Bigha !');
                    redirect(base_url(). 'index.php/basundhara2/settlementApplication?app='.$application_no);
                }
                if(KHAS_MAX_AGRICULTURE * 6400 < $totalAgrAreaLessaValidation)
                {
                    $this->session->set_flashdata('error','Total applied Agriculture area should not be more than '. KHAS_MAX_AGRICULTURE. ' Bigha !');
                    redirect(base_url(). 'index.php/basundhara2/settlementApplication?app='.$application_no);
                }
                if(FISHERY_MAX_AREA * 6400 < $totalFishAreaLessaValidation)
                {
                    $this->session->set_flashdata('error','Total applied Fishery area should not be more than '. FISHERY_MAX_AREA. ' Bigha !');
                    redirect(base_url(). 'index.php/basundhara2/settlementApplication?app='.$application_no);
                }
            }
            else
            {
                if(KHAS_MAX_HOMESTEAD * 100 < $totalHomeAreaLessaValidation)
                {
                    $this->session->set_flashdata('error','Total applied Homestead area should not be more than '. KHAS_MAX_HOMESTEAD. ' Bigha !');
                    redirect(base_url(). 'index.php/basundhara2/settlementApplication?app='.$application_no);
                }
                if(KHAS_MAX_AGRICULTURE * 100 < $totalAgrAreaLessaValidation)
                {
                    $this->session->set_flashdata('error','Total applied Agriculture area should not be more than '. KHAS_MAX_AGRICULTURE. ' Bigha !');
                    redirect(base_url(). 'index.php/basundhara2/settlementApplication?app='.$application_no);
                }
                if(FISHERY_MAX_AREA * 100 < $totalFishAreaLessaValidation)
                {
                    $this->session->set_flashdata('error','Total applied Fishery area should not be more than '. FISHERY_MAX_AREA. ' Bigha !');
                    redirect(base_url(). 'index.php/basundhara2/settlementApplication?app='.$application_no);
                }
            }

            $recordExist=$this->SettlementApiModel->checkExistDharitree($application_no);
            if($recordExist)
            {
                $data=array(
                    'error'=>"Case have been Registered Already. Please Check"
                );
                echo json_encode($data);
                die();
            }

            $this->db->trans_begin();

            $case_name=$this->SettlementApiModel->genearteCaseName();

            if(empty($case_name))
            {
                $data=array(
                    'error'=>"Network Issue or Session Out. Please try Again"
                );
                echo json_encode($data);
                die();

            }

            $case_no['petition_no']=$petition_no=$this->SettlementApiModel->genearteSettlementPetitionNo();

            $case_no['case_no']=$case_name.$petition_no."/".SETTLEMENT_KHAS_LAND;

            $pro_class = $this->input->post('protected_class');
            $protected_class_vr = ($pro_class==null || $pro_class=='' || $pro_class==0)?0:$this->input->post('protected_class');

            $basic=array(
                'dist_code'=>$this->input->post('dist_code'),
                'subdiv_code'=>$this->input->post('subdiv_code'),
                'cir_code'=>$this->input->post('cir_code'),
                'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
                'lot_no'=>$this->input->post('lot_no'),
                'vill_townprt_code'=>$this->input->post('vill_townprt_code'),
                'service_code'=>$this->input->post('service_code'),
                'ref_no'=>$this->input->post('ref_no'),
                'case_no'=>$case_no['case_no'],
                'trans_code'=>'F',/////////full
                'petition_no'=>$case_no['petition_no'],
                'year_no'=>date('Y'),
                'date_entry' => date('Y-m-d G:i:s'),
                'status'=>'W',
                'user_code'=>$this->session->userdata('user_code'),
                'lm_code' => $this->session->userdata('user_code'),
                'submission_date' => date('Y-m-d G:i:s'),
                'from_office' => 'LM',
                'pending_officer' => 'CO',
                'pending_office' => 'CO',
                'occupation_applicant'=>$this->input->post('occupation_applicant'),
                'applid'=>$this->input->post('applid'),
                'caste'=>$this->input->post('caste'),
                'uuid'=>$this->input->post('uuid'),
                'protected_class' => $protected_class_vr,
                'bhumiputra_confirmation'       => $this->input->post('bhumiputra_confirmation'),
                'bhumiputra_certificate_no'     => $this->input->post('bhumiputra_certificate_no'),
                'bhumiputra_certificate_type'   => $this->input->post('bhumiputra_certificate_type'),
                'co_code' => $this->input->post('co_code')
            );

            $insSetBasic = $this->db->insert('settlement_basic',$basic);
            // echo $this->db->last_query(); die();

            if($insSetBasic != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET00011: Insertion failed in settlement_basic RTPS Case No '.$application_no);

                $data = array(
                    'error'=>"#ERRSET00011: Registration of Settlement failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }

            ////settlement_dag_details insert start
            if($district['encroachers'] == false || empty($district['encroachers']) || $district['encroachers'] == ''){
                $this->db->trans_rollback();
                log_message('error', '#ERRSET004545: Insertion failed settlement_dag details empty RTPS Case No '.$application_no);

                $data = array(
                    'error'=>"#ERRSET004545: Registration of Settlement failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
            foreach($district['encroachers'] as $dags)
            {
                $fmd=array(
                    'dist_code'=>$this->input->post('dist_code'),
                    'subdiv_code'=>$this->input->post('subdiv_code'),
                    'cir_code'=>$this->input->post('cir_code'),
                    'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
                    'lot_no'=>$this->input->post('lot_no'),
                    'vill_townprt_code'=>$this->input->post('vill_townprt_code'),
                    'user_code'=>$this->session->userdata('user_code'),
                    'date_entry'=>date('Y-m-d'),
                    'case_no'=>$case_no['case_no'],
                    'petition_no'=>$case_no['petition_no'],
                    'year_no'=>date('Y'),
                    'operation'=>'E',
                );
                $fmd['dag_no']= $this->input->post('dag_no'.$dags->id);
                $fmd['patta_no']=$this->input->post('patta_no'.$dags->id);
                $fmd['patta_type_code']=$this->input->post('patta_type_code'.$dags->id);

                $fmd['dag_area_b']=$this->input->post('dag_area_b'.$dags->id);
                $fmd['dag_area_k']=$this->input->post('dag_area_k'.$dags->id);
                $fmd['dag_area_lc']=$this->input->post('dag_area_lc'.$dags->id);
                $fmd['dag_area_g']=$this->input->post('dag_area_g'.$dags->id);
                $fmd['dag_area_kr']=$this->input->post('dag_area_kr'.$dags->id);

                $fmd['home_b']=$this->input->post('mbigha'.$dags->id);
                $fmd['home_k']=$this->input->post('mkatha'.$dags->id);
                $fmd['home_lc']=$this->input->post('mlessa'.$dags->id);
                $fmd['home_g']=$this->input->post('mganda'.$dags->id);
                $fmd['home_kr']=$this->input->post('mkranti'.$dags->id);

                $fmd['agri_b']=$this->input->post('agri_bigha'.$dags->id);
                $fmd['agri_k']=$this->input->post('agri_katha'.$dags->id);
                $fmd['agri_lc']=$this->input->post('agri_lessa'.$dags->id);
                $fmd['agri_g']=$this->input->post('agri_ganda'.$dags->id);
                $fmd['agri_kr']=$this->input->post('agri_kranti'.$dags->id);

                $fmd['fbigha']=$this->UtilsModel->defaultValue($this->input->post('fbigha'.$dags->id),0);
                $fmd['fkatha']=$this->UtilsModel->defaultValue($this->input->post('fkatha'.$dags->id),0);
                $fmd['flessa']=$this->UtilsModel->defaultValue($this->input->post('flessa'.$dags->id),0);
                $fmd['fganda']=$this->UtilsModel->defaultValue($this->input->post('fganda'.$dags->id),0);
                $fmd['fkranti']=$this->UtilsModel->defaultValue($this->input->post('fkranti'.$dags->id),0);

                $fmd['s_dag_area_b']=$fmd['home_b']+$fmd['agri_b']+$fmd['fbigha'];
                $fmd['s_dag_area_k']=$fmd['home_k']+$fmd['agri_k']+$fmd['fkatha'];
                $fmd['s_dag_area_lc']=$fmd['home_lc']+$fmd['agri_lc']+$fmd['flessa'];
                $fmd['s_dag_area_g']=$fmd['home_g']+$fmd['agri_g']+$fmd['fganda'];
                $fmd['s_dag_area_kr']=$fmd['home_kr']+$fmd['agri_kr']+$fmd['fkranti'];

                $fmd['is_urban']=trim($this->input->post('is_urban'));
                $fmd['revenue']=0;
                $fmd['land_type']= $this->input->post('land_type'.$dags->id);
                $fmd['new_land_class_code']= $this->input->post('new_land_class_code'.$dags->id);


                $insSetDag = $this->db->insert('settlement_dag_details',$fmd);
//                 echo $this->db->last_query(); die();

                if($insSetDag != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET0002: Insertion failed in settlement_dag_details RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRSET0002: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }

            }

            $c_n = $case_no['case_no'];
            $sql = "SELECT pdar_cron_no FROM
                    settlement_applicant
                        WHERE
                            case_no = '$c_n'";
            $result = $this->db->query($sql);
            if($result->num_rows() > 0){
                $cron_no = (int)$result->row()->pdar_cron_no + 1;
            }else{
                $cron_no = 1;
            }
            foreach($district['applicants'] as $setl)
            {
                if($this->input->post('pdar_name'.$setl->id)!=0 || $this->input->post('pdar_name'.$setl->id)!="" || $this->input->post('pdar_name'.$setl->id)!="0")
                {
                    if($this->input->post('pdar_id'.$setl->id)=="" || $this->input->post('pdar_id'.$setl->id)==null || empty($this->input->post('pdar_id'.$setl->id)))
                    {
                        $chitha_pdar_id=-1;
                    }
                    else
                    {
                        $chitha_pdar_id=$this->input->post('pdar_id'.$setl->id);
                    }
                    if(in_array($setl->id, $delApplicants))
                    {
                        continue;
                    }
                    else
                    {
                        $applicant=array(
                            'dist_code'=>$this->input->post('dist_code'),
                            'subdiv_code'=>$this->input->post('subdiv_code'),
                            'cir_code'=>$this->input->post('cir_code'),
                            'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
                            'lot_no'=>$this->input->post('lot_no'),
                            'vill_townprt_code'=>$this->input->post('vill_townprt_code'),
                            'user_code'=>$this->session->userdata('user_code'),
                            'case_no'=>$case_no['case_no'],
                            'petition_no'=>$case_no['petition_no'],
                            'operation'=>'E',
                            'dag_no' =>$this->input->post('dag_no'),
                            'patta_no' =>$this->input->post('patta_no'),
                            'patta_type_code'=>$this->input->post('patta_type_code'),
                            'year_no'=>date('Y'),
                            'date_entry'=>date('Y-m-d'),
                            'pdar_id' =>$chitha_pdar_id,
                            'pdar_cron_no'=>(int) $cron_no++,
                            'pdar_name' =>$this->input->post('pdar_name'.$setl->id),
                            'pdar_guardian' =>$this->input->post('pdar_guardian'.$setl->id),
                            'pdar_rel_guar' =>$this->input->post('pdar_rel_guar'.$setl->id),
                            'pdar_gender'=>$this->input->post('pdar_gender'.$setl->id),
                            // //'pdar_add1' => $part->address,
                            'pdar_add1' => $this->input->post('pdar_add1'.$setl->id),
                            'pdar_add2' => $this->input->post('pdar_add2'.$setl->id),
                            'pdar_mobile' => $this->input->post('pdar_mobile'.$setl->id),
                            // 'i_area_b' => $this->input->post('i_area_b'.$setl->id),
                            // 'i_area_k' => $this->input->post('i_area_k'.$setl->id),
                            // 'i_area_lc' => $this->input->post('i_area_lc'.$setl->id),
                            // 'i_area_g' => $this->input->post('i_area_g'.$setl->id),
                            // 'i_area_kr' => $this->input->post('i_area_kr'.$setl->id),
                            'pdar_type' => $this->input->post('pdar_type'.$setl->id),
                            'is_applicant' => $setl->is_applicant,
                        );

                        $insSetApplicant = $this->db->insert('settlement_applicant',$applicant);
                        // echo $this->db->last_query(); die();

                        if($insSetApplicant != 1)
                        {
                            // var_dump($insSetApplicant);
                            // echo $this->db->last_query(); die();
                            $this->db->trans_rollback();
                            log_message('error', '#ERRSET0003: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                            $data = array(
                                'error'=>"#ERRSET0003: Registration of Settlement failed for case no : ".$application_no
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }
                }
            }

            /// new dynamic appliant add/////

            foreach($_POST['pdar_name2'] as $key =>$value)
            {
                $applicant2=array(
                    'dist_code'=>$this->input->post('dist_code'),
                    'subdiv_code'=>$this->input->post('subdiv_code'),
                    'cir_code'=>$this->input->post('cir_code'),
                    'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
                    'lot_no'=>$this->input->post('lot_no'),
                    'vill_townprt_code'=>$this->input->post('vill_townprt_code'),
                    'user_code'=>$this->session->userdata('user_code'),
                    'case_no'=>$case_no['case_no'],
                    'petition_no'=>$case_no['petition_no'],
                    'operation'=>'E',
                    'dag_no' =>$this->input->post('dag_no'),
                    'patta_no' =>$this->input->post('patta_no'),
                    'patta_type_code'=>$this->input->post('patta_type_code'),
                    'year_no'=>date('Y'),
                    'date_entry'=>date('Y-m-d'),
                    'pdar_id' =>-1,
                    'pdar_cron_no'=>(int) $cron_no++,
                    'pdar_name' =>$value,
                    'pdar_guardian' =>$_POST['pdar_guardian2'][$key],
                    'pdar_rel_guar' =>$_POST['pdar_rel_guar2'][$key],
                    'pdar_gender'=>$_POST['pdar_gender2'][$key],
                    'pdar_add1' => $_POST['pdar_add12'][$key],
                    'pdar_add2' => $_POST['pdar_add22'][$key],
                    'pdar_mobile' => $_POST['pdar_mobile2'][$key],
                    'pdar_type' => 'B',
                );

                $insSetApplicant2 = $this->db->insert('settlement_applicant',$applicant2);
                // echo $this->db->last_query(); die();

                if($insSetApplicant2 != 1)
                {
                    // var_dump($insSetApplicant);
                    // echo $this->db->last_query(); die();
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET00031: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRSET00031: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }

            }
            //// dynamic applicant add end ////


            $petition_no = $case_no['petition_no'];
            $case_no = $case_no['case_no'];

            // insertion of encroacher/riotee -md- 06-09-2022
            // fetch encroachers -md- 07-09-2022
            if($output->encroachers == true){
                // foreach($output->encroachers as $encroacher){
                //     $vlb_encroacher = $this->SettlementApModel->getEncroacherDetails($d, $s, $c, $m, $l, $v, $$encroacher->dag_no);
                //     $district['vlb_enc'] = $vlb_encroacher;

                //     if($vlb_encroacher == true){
                //         $vlb_encroacher_in_dag = $this->SettlementApModel->getEncroacherInDag($vlb_encroacher->id);
                //         $district['vlb_enc_details'] = $vlb_encroacher_in_dag;
                //     }else{
                //         $district['empty_err'] = "No Land Bank Details found!!";
                //     }
                // }

                // insert encroachers
                foreach($output->encroachers as $enc_applicant){
                    // $sql = "SELECT pdar_cron_no FROM
                    //                 settlement_applicant
                    //                     WHERE
                    //                         case_no = '$case_no'";
                    // $result = $this->db->query($sql)->row();


                    // $cron_no = (int)$result->pdar_cron_no + 1;

                    $encroacher_app=array(
                        'dist_code'=>$this->input->post('dist_code'),
                        'subdiv_code'=>$this->input->post('subdiv_code'),
                        'cir_code'=>$this->input->post('cir_code'),
                        'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
                        'lot_no'=>$this->input->post('lot_no'),
                        'vill_townprt_code'=>$this->input->post('vill_townprt_code'),

                        'user_code'=>$this->session->userdata('user_code'),
                        'case_no'=> $case_no,
                        'petition_no'=>$petition_no,
                        'operation'=>'E',
                        'dag_no' =>$this->input->post('enc_dag'.$enc_applicant->id),
                        'patta_no' =>$this->input->post('patta_no'.$enc_applicant->id),
                        'patta_type_code'=>$this->input->post('patta_type_code'.$enc_applicant->id),
                        'period_possession'=>$this->input->post('period_possession'.$enc_applicant->id),

                        // 'home_b'=>$this->input->post('mbigha'.$enc_applicant->id),
                        // 'home_k'=>$this->input->post('home_k'.$enc_applicant->id),
                        // 'home_lc'=>$this->input->post('home_lc'.$enc_applicant->id),
                        // 'home_g'=>$this->input->post('home_g'.$enc_applicant->id),
                        // 'home_kr'=>$this->input->post('home_kr'.$enc_applicant->id),

                        // 'agri_b'=>$this->input->post('agri_b'.$enc_applicant->id),
                        // 'agri_k'=>$this->input->post('agri_k'.$enc_applicant->id),
                        // 'agri_lc'=>$this->input->post('agri_lc'.$enc_applicant->id),
                        // 'agri_g'=>$this->input->post('agri_g'.$enc_applicant->id),
                        // 'agri_kr'=>$this->input->post('agri_kr'.$enc_applicant->id),

                        'year_no'=>date('Y'),
                        'date_entry'=>date('Y-m-d'),
                        'pdar_name' => $this->input->post('riotee_name'.$enc_applicant->id),
                        'pdar_guardian' => $this->input->post('riotee_guardian'.$enc_applicant->id),
                        'pdar_rel_guar' => '0',
                        'pdar_cron_no'=> (int) $cron_no++,
                        'pdar_id' => -1,
                        'pdar_type' => 'EN',
                        'enc_id' => $this->input->post('enc_id'.$enc_applicant->id)
                    );
                    $insSetEncroacher = $this->db->insert('settlement_applicant',$encroacher_app);
                    // echo $this->db->last_query();
                    // var_dump($insSetEncroacher); die();

                    if($insSetEncroacher != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET0003: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#ERRSET0003: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }

                }
            }

            ////settlement khas LM Report insert start

            ////////////////////file///////////////////////////

            // For uploading dag wise trace_map_copy
            foreach($district['encroachers'] as $dags_doc){
                $timestamp = date('mdYhis', time()).uniqid();

                // Trace Map copy upload
                $config['file_name']            = 'trace_map_copy'.$timestamp;
                $config['upload_path']          = UPLOAD_DIR;
                $config['allowed_types']        = 'pdf|jpg|png';
                $config['max_size']             = 2000;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ( ! $this->upload->do_upload('trace_map_copy'.$dags_doc->id))
                {
                    $error = array('error' => $this->upload->display_errors());
                    echo json_encode($error);
                    return false;
                }
                else
                {
                    $data = array('upload_data' => $this->upload->data());
                    $document= array(
                        'case_no' => $case_no,
                        'file_name' => 'Trace Map Copy',
                        'user_code' => $this->session->userdata('user_code'),
                        'fetch_file_name' => $data['upload_data']['orig_name'],
                        'file_type' => $data['upload_data']['file_type'],
                        'file_path' => $config['upload_path'].$data['upload_data']['orig_name'],
                        'date_entry' => date('Y-m-d h:i:s'),
                        'mut_type' => $this->input->post('service_code'),
                        'dag_no' => $this->input->post('dag_no_doc'.$dags_doc->id)
                    );

                    $insert_supportive_doc= $this->db->insert('supportive_document',$document);

                    if($insert_supportive_doc != 1){
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORPPSSGG: Insertion failed in supportive_document for case no :'. $case_no);
                        $json = [
                            'errorMessage'=>"#ERRORPPSSGG: Failed to forward the case for Case No : ".$case_no
                        ];
                        echo json_encode($json);
                        return false;
                    }
                }
            }

            $timestamp = date('mdYhis', time()).uniqid();
            // For uploading field report
            $config2['file_name']            = 'field_report'.$timestamp;
            $config2['upload_path']          = UPLOAD_DIR;
            $config2['allowed_types']        = 'pdf|jpg|png';
            $config2['max_size']             = 2000;

            $this->upload->initialize($config2);

            if ( ! $this->upload->do_upload('field_report'))
            {
                $error = array('error' => $this->upload->display_errors());

                var_dump($error);
                die;
            }
            else
            {
                $data = array('upload_data' => $this->upload->data());
                $document= array(
                    'case_no' => $case_no,
                    'file_name' => 'Field Report',
                    'user_code' => $this->session->userdata('user_code'),
                    'fetch_file_name' => $data['upload_data']['orig_name'],
                    'file_type' => $data['upload_data']['file_type'],
                    'file_path' => $config2['upload_path'].$data['upload_data']['orig_name'],
                    'date_entry' => date('Y-m-d h:i:s'),
                    'mut_type' => $this->input->post('service_code'),
                );

                $insert_supportive_doc= $this->db->insert('supportive_document',$document);

                if($insert_supportive_doc != 1){
                    $this->db->trans_rollback();
                    log_message('error', '#ERRORPPSSGGP: Insertion failed in supportive_document for case no :'. $case_no);
                    $json = [
                        'errorMessage'=>"#ERRORPPSSGGP: Failed to forward the case for Case No : ".$case_no
                    ];
                    echo json_encode($json);
                    return false;
                }
            }


            // UPDATING Geo Tag Photo case number in supportive document
            if(isset($district['geo_tag_doc'])){
                foreach($district['geo_tag_doc'] as $geo_tag_loop){
                    $geo_tag_array = array(
                        'case_no' => $case_no
                    );
                    $this->db->where('applid', $geo_tag_loop->applid);
                    $this->db->where('dag_no', $geo_tag_loop->dag_no);
                    $this->db->where('file_name', GEO_TAG_PHOTO);
                    $this->db->update('supportive_document', $geo_tag_array);

                    if($this->db->affected_rows() == 0 ){
                        $this->db->trans_rollback();
                        log_message('error', '#SETUP0001S: Updation failed in supportive_document basundhara Case No '.$geo_tag_loop->applid);
                        $data = array(
                            'error'=>"#SETUP0001S: Registration of Settlement failed for case no : ".$geo_tag_loop->applid
                        );
                        echo json_encode($data);
                        return false;
                    }
                }
            }

            ///////////////////////////////////////////////

            $comment = addslashes($this->input->post('lm_remark'));

            $pro_class_lm = $this->input->post('protected_class_lm');
            $protected_class_lm = ($pro_class_lm==null || $pro_class_lm=='' || $pro_class_lm==0)?0:$this->input->post('protected_class_lm');

            $lmnote=array(
                'user_code'=>$this->session->userdata('user_code'),
                'chitha_verified'=>$this->input->post('chiitha_verified'),
                'vlb_verified'=>$this->input->post('vlb_verified'),
                'is_tribal_belt' => $this->input->post('whether_tribal'),
                'possession_verification'=>$this->input->post('possession_verified'),
                'period_possession'=>date('Y-m-d'),
                'nature_possession'=>$this->input->post('nature_possession'),
                'is_landless'=>$this->input->post('is_landless'),
                'land_falls'=>$this->input->post('land_falls'),
                'falls_und_gmc'=>$this->input->post('falls_und_gmc'),
                'roadside_reservation'=>$this->input->post('roadside_reservation'),
                'zonal_valuation'=>$this->input->post('zonal_valuation'),
                // 'trace_map_copy'=>$this->input->post('trace_map_copy'),
                // 'chitha_copy'=>$this->input->post('chitha_copy'),
                'trace_map_copy'=>'NA',
                'chitha_copy'=>'NA',
                'lm_note'=>$comment,
                'lm_remark_text'=>$this->input->post('lm_remark_text'),
                'date_entry'=>date('Y-m-d h:i:s'),
                'case_no'=>$case_no,
                'status'=>'W',
                'total_bigha'=>$this->input->post('total_bigha'),
                'total_Katha'=>$this->input->post('total_Katha'),
                'total_lessa'=>$this->input->post('total_lessa'),
                'total_ganda'=>$this->input->post('total_ganda'),
                'total_kranti'=>$this->input->post('total_kranti'),
                'encroacher_exist_vlb' => $this->input->post('encroacher_exist_vlb'),
                'landslide'            => $this->input->post('landslide'),
                'erosion'            => $this->input->post('erosion'),
                'protected_class_lm' => $protected_class_lm,
                'bhumiputra_confirmation'   => $this->input->post('bhumiputra_confirmation_lm'),

            );

            $insLmnote = $this->db->insert('settlement_ap_lmnote',$lmnote);
            if($insLmnote != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET0005: Insertion failed in settlement_ap_lmnote RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRSET0005: Registration of Settlement failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }

            ///// road side reserve area start /////
            if($roadside_comment_check=='YES')
            {
                foreach($district['encroachers'] as $dags)
                {
                    $reservedarea=array(
                        'dist_code'=>$this->input->post('district_code'),
                        'subdiv_code'=>$this->input->post('sub_div_code'),
                        'cir_code'=>$this->input->post('circle_code'),
                        'mouza_pargona_code'=>$this->input->post('mouza_code'),
                        'lot_no'=>$this->input->post('lot_no'),
                        'vill_townprt_code'=>$this->input->post('select_village'),
                        'dag_no'=>$this->input->post('reserved_dag_road'.$dags->id),
                        'patta_no'=>$this->input->post('reserved_patta_road'.$dags->id),
                        'bigha'=>$this->input->post('reserved_bigha'.$dags->id),
                        'katha'=>$this->input->post('reserved_katha'.$dags->id),
                        'lessa'=>$this->input->post('reserved_lessa'.$dags->id),
                        'ganda'=>$this->input->post('reserved_ganda'.$dags->id),
                        'kranti'=>$this->input->post('reserved_kranti'.$dags->id),
                        'case_no'=>$case_no,
                        'applid'=>$this->input->post('applid'),
                        'lm_code'=>$this->session->userdata('user_code'),
                        'date_entry'=>date('Y-m-d h:i:s'),
                        'date_update'=>date('Y-m-d h:i:s'),
                        'type'=>'R'
                    );

                    $reserveData = $this->db->insert('settlement_reservation',$reservedarea);
                    // echo $this->db->last_query(); die();
                    if($reserveData != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET00052: Insertion failed in settlement_reservation RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#ERRSET00052: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }
            }

            if($family_comment_check=='YES')
            {
                foreach($district['encroachers'] as $dags)
                {
                    $reservedarea=array(
                        'dist_code'=>$this->input->post('district_code'),
                        'subdiv_code'=>$this->input->post('sub_div_code'),
                        'cir_code'=>$this->input->post('circle_code'),
                        'mouza_pargona_code'=>$this->input->post('mouza_code'),
                        'lot_no'=>$this->input->post('lot_no'),
                        'vill_townprt_code'=>$this->input->post('select_village'),
                        'dag_no'=>$this->input->post('reserved_dag_family'.$dags->id),
                        'patta_no'=>$this->input->post('reserved_patta_family'.$dags->id),
                        'bigha'=>$this->input->post('reserved_bigha_family'.$dags->id),
                        'katha'=>$this->input->post('reserved_katha_family'.$dags->id),
                        'lessa'=>$this->input->post('reserved_lessa_family'.$dags->id),
                        'ganda'=>$this->input->post('reserved_ganda_family'.$dags->id),
                        'kranti'=>$this->input->post('reserved_kranti_family'.$dags->id),
                        'case_no'=>$case_no,
                        'applid'=>$this->input->post('applid'),
                        'lm_code'=>$this->session->userdata('user_code'),
                        'date_entry'=>date('Y-m-d h:i:s'),
                        'date_update'=>date('Y-m-d h:i:s'),
                        'type'=>'F'
                    );

                    $reserveData = $this->db->insert('settlement_reservation',$reservedarea);
                    // echo $this->db->last_query(); die();
                    if($reserveData != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET00053: Insertion failed in settlement_reservation RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#ERRSET00053: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }
            }

            ///// family reserve area end //////

            ///// nominee add start /////

            if($output->nextKin == true){
                // foreach($output->nextKin as $nominee){
                foreach($_POST['kin_name'] as $key =>$value){
                    $nominee_data=array(
                        'case_no'=> $case_no,
                        'nominee_name' =>$_POST['kin_name'][$key],
                        'address' =>$_POST['kin_address'][$key],
                        'mobile_no' => $_POST['kin_contact_no'][$key],
                        'relation' => $_POST['kin_relation'][$key]
                    );
                    $insNominee = $this->db->insert('settlement_nominee',$nominee_data);
                    echo $this->db->last_query();
                    // var_dump($insSetEncroacher); die();

                    if($insNominee != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET00032: Insertion failed in settlement_nominee RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#ERRSET00032: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }

                }
            }


            ///// nominee end //////

            //////proceeding start//////
            $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

            if($proceeding_id==null){
                $proceeding_id=1;
            }

            $insPetProceed = [
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_on_order' => $comment,
                'status' => 'W',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'LM',
                'office_to' => 'CO',
                'task' => 'LM note submitted'
            ];
            $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

            // echo $this->db->last_query(); die();
            if($insertProceeding != 1){
                $this->db->trans_rollback();
                log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
                $json = [
                    'errorMessage'=>"#ERRORPP: Failed to forward the case for Case No : ".$case_no
                ];
                echo json_encode($json);
                return false;
            }
            //////proceeding end//////

            ////settlement Khas LM Report insert end

            if($this->db->trans_status()==FALSE){
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"Error in submitting. Please try Again"
                );
            }
            else
            {
                $basundhara=array(
                    'dharitree'=>$case_no,
                    'basundhara'=>$application_no,
                    'date_reg'=>date('Y-m-d'),
                    'reg_by'=>$this->session->userdata('user_code'),
                    'app_status'=>'M',
                    'pending_with'=>'LM'
                );
                $this->db->insert('basundhar_application',$basundhara);
                //////////////POST To basundhara/////////////////////
                $rmk='Forwarded to CO';
                $status='W';
                $task='LM';
                $pen='CO';
                $case=$case_no;
                $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                $rtps_status=json_decode($rtps_status);
                //var_dump($rtps_status);
                if(trim($rtps_status)!="y"){
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRAPP0011: Settlement Application not submitted case no # $case_no");
                    redirect(base_url() . "index.php/home");
                }else{
                    $this->db->trans_commit();
                }

                //////////////////
                // $this->DashboardInheritance($case_no['case_no']);
                //////
                //////////////////////////////////
                $this->session->set_flashdata('message', "Application Successfully Forwarded to Circle Office With Case No # $case_no");
                redirect(base_url() . "index.php/home");

                // $data=array(
                //     'success'=>"Settlement Application Registered Successfully with case no $case_no[case_no]",
                //     'redirect_url'=>base_url().'index.php/home'
                // );
            }
            // echo json_encode($data);
        }

    }


    // settlement Tenant application view
    function settlementTenantNew(){
        $application_no = $this->input->get('app');
        $url = API_LINK_MB2."getAppDetails?application_no=" . $application_no ;
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
        $district['applicants']=$output->applicants;
        $district['document']=$output->documents;
        $district['query']=$output->query;
        $district['property']=$output->property;

        $district['settlements']=$output->settlements;
        $district['encroachers'] = $output->encroachers;
        $district['owners'] = $output->owners;
        $district['riotee_noks'] = $output->riotee_noks;
        $district['aadhar']=$output->aadhar;
        $district['nextKin'] = $output->nextKin;
        $district['bhumi'] = $output->bhumi;
        // get khatian number
        $d=$district['app']->dist_code;
        $s=$district['app']->subdiv_code;
        $c=$district['app']->cir_code;
        $m=$district['app']->mouza_code;
        $l=$district['app']->lot_no;
        $v=$district['app']->village_code;
        $pno=$district['pattaNo']->patta_no;
        $pc=$district['pattaNo']->patta_type_code;
        $dag = $district['app']->dag_no;

        $co_name = $this->db->query("Select users.username, loginuser_table.user_code, users.user_desig_code from  users, loginuser_table where users.dist_code = loginuser_table.dist_code "
            . "and users.user_code = loginuser_table.user_code and users.dist_code='$d' and "
            . "users.subdiv_code='$s' and users.cir_code='$c' and loginuser_table.dis_enb_option = 'E'")->result();

        $district['co_name'] = $co_name;


        // check case and user auth
        if($this->utilityclass->checkUserAuthForCaseForLm($d,$s,$c,$m,$l) == false){
            $this->session->set_flashdata('message', "Unauthorized access for case no # ".$application_no);
            redirect(base_url() . "index.php/home");
        }

        // fetch owner details -js- 05-09-2022
        if($output->owners == true){
            foreach($output->owners as $allapplicants){
                $query = "SELECT
                                pdar_id,
                                pdar_name,
                                pdar_father,
                                $allapplicants->mobile as mobile
                                FROM
                                    chitha_pattadar
                                    WHERE
                                        dist_code= '$d'
                                        AND
                                        subdiv_code='$s'
                                        AND
                                        cir_code='$c'
                                        AND
                                        lot_no='$l'
                                        AND
                                        mouza_pargona_code='$m'
                                        AND
                                        vill_townprt_code='$v'
                                        AND
                                        trim(patta_no)=trim('$pno')
                                        AND
                                        patta_type_code='$pc'
                                        AND
                                        pdar_id='$allapplicants->chitha_pdar_id' ";
                $owner[] = $this->db->query($query)->result();
            }
            $district['owner'] = $owner;
        }

        // echo "<pre>";
        // var_dump(json_decode(SETTLEMENT_TENANT_FILES));
        // die;

        $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE applid = ? AND file_name = ? ", array($application_no, GEO_TAG_PHOTO) );

        if($supportive_document_sql == true){
            if($supportive_document_sql->num_rows() > 0){
                $district['geo_tag_doc'] = $supportive_document_sql->result();
            }else{
                $district['geo_tag_doc_empty'] = "Geo tag photo yet to be uploaded.";
            }
        }

        // fetch riotee noks -js- 05-09-2022
        if($output->riotee_noks == true){
            $district['riotee_nok'] = $output->riotee_noks;
        }
        // $district['selfDeclarationDetails'] = $output->selfDeclaration;
        foreach($output->selfDeclaration as $selfDec){
            $district['selfDeclarationDetails']=json_decode($selfDec->dec_details);
        }
        if($district['app']->service_code=='13' ){
            //    fetch riotee from chitha_tenant -js- 05-09-2022
            if($output->encroachers == true){
                foreach($output->encroachers as $encroacher){
                    // var_dump($encroacher);
                    $khatian_no = $encroacher->khatian_no;
                    $query = "SELECT
                                *
                                FROM
                                    chitha_tenant
                                    WHERE
                                        subdiv_code='$s'
                                        AND
                                        cir_code='$c'
                                        AND
                                        lot_no='$l'
                                        AND
                                        mouza_pargona_code='$m'
                                        AND
                                        vill_townprt_code='$v'
                                        AND
                                        dag_no ='$encroacher->dag_no'
                                        AND
                                        khatian_no ='$encroacher->khatian_no'
                                        AND
                                        tenant_id = '$encroacher->encroacher_id'";
                    $riotee[] = $this->db->query($query)->result();
                }
                $district['riotee'] = $riotee;
            }
            foreach($output->settlements as $settlements){
                if($settlements->khatian_no == true){
                    $district['khatian_no'] = $settlements->khatian_no;
                }
            }
            $district['riotee_list'] = $this->SettlementTenantModel->getRioteeList($d,$s,$c,$m,$l,$v,$dag,$khatian_no);
            $district['_view'] = 'SettlementView/SettlementTenantView';
        }
        $this->load->view('layouts/main',$district);
    }


    // settlement Tenant post
    public function settlementTenantPost()
    {
        $application_no = trim($this->input->post('application_no'));
        $distCode = trim($this->input->post('dist_code'));
        $deleted_applicants = $this->input->post('deleted_applicant');
        $deleteAppCon = 0;
        $delApplicants = [];
        if($deleted_applicants != '' or $deleted_applicants != NULL)
        {
            $deleteAppCon = 1;
            $allSplitApplicants = (explode(",",$deleted_applicants));
            $delApplicants = [];
            foreach ($allSplitApplicants as $mm)
            {
                $splitApplicants = (explode("_",$mm));
                $delApplicants[] = $splitApplicants[0];
            }
        }
        if($distCode == NULL)
        {
            redirect(base_url(). 'index.php/basundhara2/settlementCases');
        }
        if($application_no == NULL)
        {
            redirect(base_url(). 'index.php/basundhara2/settlementCases');
        }

        $this->load->library('form_validation');

        $this->form_validation->set_rules('service_code', 'Service Code', 'trim|required|is_natural');
        $this->form_validation->set_rules('lot_no', 'Lot Number', 'trim|required');
        $this->form_validation->set_rules('application_no', 'Application No', 'trim|required|min_length[2]');
        $this->form_validation->set_rules('ref_no', 'Application No', 'trim|required|min_length[10]');
        $this->form_validation->set_rules('is_urban', 'Is Urban', 'trim|required');
        $this->form_validation->set_rules('uuid', 'uuid', 'trim|required');
        $this->form_validation->set_rules('dist_name', 'District Name', 'trim|required');
        $this->form_validation->set_rules('dist_code', 'District Code', 'trim|required');
        $this->form_validation->set_rules('subdiv_name', 'Sub Division Name', 'trim|required');
        $this->form_validation->set_rules('subdiv_code', 'Sub Division Code', 'trim|required');
        $this->form_validation->set_rules('circle_name', 'Circle Name', 'trim|required');
        $this->form_validation->set_rules('cir_code', 'Circle Code', 'trim|required');
        $this->form_validation->set_rules('mouza_name', ' Mouza Name', 'trim|required');
        $this->form_validation->set_rules('mouza_pargona_code', 'Mouza Code ', 'trim|required');
        $this->form_validation->set_rules('village_name', 'Village Name ', 'trim|required');
        $this->form_validation->set_rules('vill_townprt_code', 'Village Code ', 'trim|required');

        $this->form_validation->set_rules('chiitha_verified', 'Chitha Verified', 'trim|required');
        $this->form_validation->set_rules('rk_verified', 'RK Verified', 'trim|required');
        $this->form_validation->set_rules('bhumiputra_confirmation_lm', 'Bhumiputra Verified', 'trim|required');
        $this->form_validation->set_rules('possession_verified', 'Possession Verified', 'trim|required');
        $this->form_validation->set_rules('protected_class_lm', 'Applicant falls under protected category', 'trim|required');
        $this->form_validation->set_rules('litigation', 'Proposed land is under litigation', 'trim|required');
        $this->form_validation->set_rules('is_tribal_belt', 'Under Tribal Belt/ Block', 'trim|required');
        $this->form_validation->set_rules('landslide', 'Area Under cover landslide prone', 'trim|required');
        $this->form_validation->set_rules('erosion', 'Land falls under erosion', 'trim|required');
        $this->form_validation->set_rules('total_bigha', 'Total Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
        $this->form_validation->set_rules('total_Katha', 'Total Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
        $this->form_validation->set_rules('total_lessa', 'Total Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
        $this->form_validation->set_rules('period_possession_lm', 'Period of Possession from Date', 'trim|required');
        $this->form_validation->set_rules('nature_possession', 'Nature of Possession', 'trim|required');
        $this->form_validation->set_rules('khajana_receipt', 'Check the land revenue details as fetch from the E-Khajana Database or check the Khajana receipt uploaded by applicant', 'trim|required');
        $this->form_validation->set_rules('lm_remark', 'LM Remarks', 'trim|required');
        $this->form_validation->set_rules('lm_remark_text', 'LM Remarks (Text Area)', 'trim|required');
        $this->form_validation->set_rules('co_code', 'Select Circle Officer', 'trim|required');

        //$this->form_validation->set_rules('aadhar_verified', 'Aadhaar verified', 'trim|required');
        $this->form_validation->set_rules('land_used_by_occupants', 'Purpose of the land used by the occupants', 'trim');
        $this->form_validation->set_rules('period_possession', 'Period of Possession from Date', 'trim|required');
        $this->form_validation->set_rules('occupation_applicant', 'Occupation or Profession of the applicant', 'trim|required');
        $this->form_validation->set_rules('caste', 'Caste', 'trim|required');

        $appAreaMoreThanDagA = 0;
        $lmEnterAreaMoreThanDagA = 0;

        // for barak valley
        if(in_array($distCode, json_decode(BARAK_VALLEY)))
        {
            $this->form_validation->set_rules('total_ganda', 'Total Land Area in Selected Dag (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
            $this->form_validation->set_rules('total_kranti', 'Total Land Area in Selected Dag (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
            $this->form_validation->set_rules('dag_area_b', 'Total Land Area in Selected Dag (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('dag_area_k', 'Total Land Area in Selected Dag (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
            $this->form_validation->set_rules('dag_area_lc', 'Total Land Area in Selected Dag (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
            $this->form_validation->set_rules('dag_area_g', 'Total Land Area in Selected Dag (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
            $this->form_validation->set_rules('dag_area_kr', 'Total Land Area in Selected Dag (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
            $this->form_validation->set_rules('s_dag_area_b', 'Total applied Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('s_dag_area_k', 'Total applied Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
            $this->form_validation->set_rules('s_dag_area_lc', 'Total applied Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
            $this->form_validation->set_rules('s_dag_area_g', 'Total applied Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
            $this->form_validation->set_rules('s_dag_area_kr', 'Total applied Area (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

            $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'), 0);
            $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'), 0);
            $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'), 0);
            $gandaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_g'), 0);

            $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_b'), 0);
            $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_k'), 0);
            $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_lc'), 0);
            $gandaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_g'), 0);

            $bighaValidationTotalLm = $this->UtilsModel->defaultValue($this->input->post('total_bigha'), 0);
            $kathaValidationTotalLm = $this->UtilsModel->defaultValue($this->input->post('total_Katha'), 0);
            $lessaValidationTotalLm = $this->UtilsModel->defaultValue($this->input->post('total_lessa'), 0);
            $gandaValidationTotalLm = $this->UtilsModel->defaultValue($this->input->post('total_ganda'), 0);

            $dagAreaLessaValidation = ($bighaValidation * 6400) + ($kathaValidation * 320) + ($lessaValidation * 20) + $gandaValidation;
            $agrAreaLessaValidation = ($bighaValidationAgr * 6400) + ($kathaValidationAgr * 320) + ($lessaValidationAgr * 20) + $gandaValidationAgr;
            $totalLmEnterAreaValidation = ($bighaValidationTotalLm * 6400) + ($kathaValidationTotalLm * 320) + ($lessaValidationTotalLm * 20) + $gandaValidationTotalLm;

            if($dagAreaLessaValidation < $agrAreaLessaValidation)
            {
                $appAreaMoreThanDagA = 1;
            }
            if($dagAreaLessaValidation < $totalLmEnterAreaValidation)
            {
                $lmEnterAreaMoreThanDagA = 1;
            }
        }
        else
        {
            $this->form_validation->set_rules('dag_area_b', 'Total Land Area in Selected Dag (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('dag_area_k', 'Total Land Area in Selected Dag (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
            $this->form_validation->set_rules('dag_area_lc', 'Total Land Area in Selected Dag (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
            $this->form_validation->set_rules('s_dag_area_b', 'Total applied Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
            $this->form_validation->set_rules('s_dag_area_k', 'Total applied Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
            $this->form_validation->set_rules('s_dag_area_lc', 'Total applied Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

            $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'), 0);
            $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'), 0);
            $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'), 0);

            $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_b'), 0);
            $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_k'), 0);
            $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('s_dag_area_lc'), 0);

            $bighaValidationTotalLm = $this->UtilsModel->defaultValue($this->input->post('total_bigha'), 0);
            $kathaValidationTotalLm = $this->UtilsModel->defaultValue($this->input->post('total_Katha'), 0);
            $lessaValidationTotalLm = $this->UtilsModel->defaultValue($this->input->post('total_lessa'), 0);

            $dagAreaLessaValidation = ($bighaValidation * 100) + ($kathaValidation * 20) + $lessaValidation;
            $agrAreaLessaValidation = ($bighaValidationAgr * 100) + ($kathaValidationAgr * 20) + $lessaValidationAgr;
            $totalLmEnterAreaValidation = ($bighaValidationTotalLm * 100) + ($kathaValidationTotalLm * 20) + $lessaValidationTotalLm;

            if($dagAreaLessaValidation < $agrAreaLessaValidation)
            {
                $appAreaMoreThanDagA = 1;
            }
            if($dagAreaLessaValidation < $totalLmEnterAreaValidation)
            {
                $lmEnterAreaMoreThanDagA = 1;
            }
        }

        /////////////////////
        $url = API_LINK_MB2 . "getAppDetails?application_no=" . $application_no;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        $district['app'] = $output->application;
        $district['pattaNo'] = $this->utilityclass->getPattaTypeNo($district['app']->dist_code, $district['app']->subdiv_code, $district['app']->cir_code, $district['app']->mouza_code, $district['app']->lot_no, $district['app']->village_code, $district['app']->dag_no);

        $district['applicants'] = $output->applicants;
        $district['document'] = $output->documents;
        $district['query'] = $output->query;
        $district['property'] = $output->property;
        $district['settlements'] = $output->settlements;
        $district['encroachers'] = $output->encroachers;
        $district['owners'] = $output->owners;
        $district['riotee_noks'] = $output->riotee_noks;
        $district['aadhar'] = $output->aadhar;
        $district['nextKin'] = $output->nextKin;

        $d = $district['app']->dist_code;
        $s = $district['app']->subdiv_code;
        $c = $district['app']->cir_code;
        $m = $district['app']->mouza_code;
        $l = $district['app']->lot_no;
        $v = $district['app']->village_code;
        $pno = $district['pattaNo']->patta_no;
        $pc = $district['pattaNo']->patta_type_code;
        $dag = $district['app']->dag_no;

        if($deleteAppCon == 1)
        {
            foreach($district['applicants'] as $setl)
            {
                if(in_array($setl->id, $delApplicants))
                {
                    continue;
                }
                else
                {
                    $this->form_validation->set_rules('pdar_name'.$setl->id, 'Pattadar Name', 'trim|required|min_length[3]|max_length[70]');
                    $this->form_validation->set_rules('pdar_guardian'.$setl->id, 'Pattadar Guardian', 'trim|required|min_length[3]|max_length[70]');
                    $this->form_validation->set_rules('pdar_rel_guar'.$setl->id, 'Pattadar Guardian Relation', 'trim|required');
                    $this->form_validation->set_rules('pdar_gender'.$setl->id, 'Pattadar Gender ', 'trim|required');
                    $this->form_validation->set_rules('pdar_add1'.$setl->id, 'Pattadar Address 1', 'trim|required|min_length[3]|max_length[200]');
                    $this->form_validation->set_rules('pdar_add2'.$setl->id, 'Pattadar Address 2', 'trim|required|min_length[3]|max_length[200]');
                    $this->form_validation->set_rules('pdar_mobile'.$setl->id, 'Pattadar Mobile No.', 'trim|required|min_length[10]|max_length[10]');
                    $this->form_validation->set_rules('pdar_type'.$setl->id, 'Pattadar Type', 'trim|required');
                }
            }
        }
        else
        {
            foreach($district['applicants'] as $setl)
            {
                $this->form_validation->set_rules('pdar_name' . $setl->id, 'Pattadar Name', 'trim|required|min_length[3]|max_length[70]');
                $this->form_validation->set_rules('pdar_guardian' . $setl->id, 'Pattadar Guardian', 'trim|required|min_length[3]|max_length[70]');
                $this->form_validation->set_rules('pdar_rel_guar' . $setl->id, 'Pattadar Guardian Relation', 'trim|required');
                $this->form_validation->set_rules('pdar_gender' . $setl->id, 'Pattadar Gender ', 'trim|required');
                $this->form_validation->set_rules('pdar_add1' . $setl->id, 'Pattadar Address 1', 'trim|required|min_length[3]|max_length[200]');
                $this->form_validation->set_rules('pdar_add2' . $setl->id, 'Pattadar Address 2', 'trim|required|min_length[3]|max_length[200]');
                $this->form_validation->set_rules('pdar_mobile' . $setl->id, 'Pattadar Mobile No.', 'trim|required|min_length[10]|max_length[10]');
                $this->form_validation->set_rules('pdar_type' . $setl->id, 'Pattadar Type', 'trim|required');
            }
        }
        if(isset($_POST['pdar_name2'])){
            if($_POST['pdar_name2'] != '' OR $_POST['pdar_name2'] != NULL OR $_POST['pdar_guardian2'] != '' OR $_POST['pdar_guardian2']
                != NULL OR $_POST['pdar_rel_guar2'] != '' OR $_POST['pdar_rel_guar2'] != NULL
                OR $_POST['pdar_gender2'] != '' OR $_POST['pdar_gender2'] != NULL)
            {
                $this->form_validation->set_rules('pdar_name2[]', 'Pattadar Name', 'trim|required|min_length[3]|max_length[70]');
                $this->form_validation->set_rules('pdar_guardian2[]', 'Pattadar Guardian', 'trim|required|min_length[3]|max_length[70]');
                $this->form_validation->set_rules('pdar_rel_guar2[]', 'Pattadar Guardian Relation', 'trim|required');
                $this->form_validation->set_rules('pdar_gender2[]', 'Pattadar Gender ', 'trim|required');
                $this->form_validation->set_rules('pdar_add12[]', 'Pattadar Address 1', 'trim|required|min_length[3]|max_length[200]');
                $this->form_validation->set_rules('pdar_add22[]', 'Pattadar Address 2', 'trim|required|min_length[3]|max_length[200]');
                $this->form_validation->set_rules('pdar_mobile2[]', 'Pattadar Mobile No.', 'trim|required|min_length[10]|max_length[10]');
            }
        }

        if($output->owners == true)
        {
            foreach($output->owners as $allapplicants)
            {
                $query = "SELECT  pdar_id, pdar_name, pdar_father,$allapplicants->mobile as mobile FROM chitha_pattadar WHERE  dist_code= '$d' 
                                        AND  subdiv_code='$s' AND cir_code='$c' AND lot_no='$l' AND mouza_pargona_code='$m' 
                                        AND vill_townprt_code='$v' AND trim(patta_no)=trim('$pno') AND patta_type_code='$pc'  AND pdar_id='$allapplicants->chitha_pdar_id' ";
                $owner[] = $this->db->query($query)->result();
            }
            foreach($owner as $owner_applicant)
            {
                $this->form_validation->set_rules('owners_name'.$owner_applicant[0]->pdar_id, 'Owners Name', 'trim|required|min_length[3]|max_length[70]');
                $this->form_validation->set_rules('owners_guardian'.$owner_applicant[0]->pdar_id, 'Owners Guardian', 'trim|required|min_length[3]|max_length[70]');
                // $this->form_validation->set_rules('owners_mobile_number'.$owner_applicant[0]->pdar_id, 'Owners Mobile No.', 'trim|required|min_length[10]|max_length[10]');
                $this->form_validation->set_rules('owners_in_place'.$owner_applicant[0]->pdar_id, 'Owners in Place', 'trim|required|min_length[1]');

            }
        }
        if($output->encroachers == true)
        {
            foreach($output->encroachers as $encroacher)
            {
                $query = "SELECT *  FROM chitha_tenant WHERE  subdiv_code='$s' AND cir_code='$c' AND lot_no='$l'
                                AND mouza_pargona_code='$m' AND vill_townprt_code='$v' AND 
                                dag_no ='$encroacher->dag_no'AND khatian_no ='$encroacher->khatian_no' AND tenant_id = '$encroacher->encroacher_id'";

                $riotee[] = $this->db->query($query)->result();
            }
            foreach($riotee as $enc_applicant)
            {
                $this->form_validation->set_rules('riotee_name'.$enc_applicant[0]->tenant_id, 'Riotee Name', 'trim|required|min_length[3]|max_length[70]');
                $this->form_validation->set_rules('riotee_guardian'.$enc_applicant[0]->tenant_id, 'Riotee Guardian', 'trim|required|min_length[3]|max_length[70]');
                $this->form_validation->set_rules('khatian_no'.$enc_applicant[0]->tenant_id, 'Riotee Id', 'trim|required|is_natural');
            }
        }
        if($output->riotee_noks == true)
        {
            $district['riotee_nok'] = $output->riotee_noks;
            foreach($district['riotee_nok'] as $riotee_nok)
            {
                $this->form_validation->set_rules('riotee_nok_name'.$riotee_nok->id, 'Riotee NOK Name', 'trim|required|min_length[3]|max_length[70]');
                $this->form_validation->set_rules('riotee_nok_guardian'.$riotee_nok->id, 'Riotee NOK Guardian', 'trim|required|min_length[3]|max_length[70]');
                $this->form_validation->set_rules('riotee_nok_relation'.$riotee_nok->id, 'Riotee NOK Id', 'trim|required|min_length[1]|max_length[6]');
                $this->form_validation->set_rules('riotee_nok_khatian_no'.$riotee_nok->id, 'Riotee NOK Id', 'trim|required|is_natural');
            }
        }
        if ($this->form_validation->run() == FALSE)
        {
            $errors = validation_errors();
            $this->session->set_flashdata('error',$errors);
            redirect(base_url(). 'index.php/basundhara2/settlementTenantNew?app='.$application_no);
        }
        else
        {

            if($agrAreaLessaValidation == 0)
            {
                $this->session->set_flashdata('error','Total applied area should not be Zero !');
                redirect(base_url(). 'index.php/basundhara2/settlementTenantNew?app='.$application_no);
            }
            if($lmEnterAreaMoreThanDagA == 1)
            {
                $this->session->set_flashdata('error','Possession of the land found during field visit should not be more than total dag area !');
                redirect(base_url(). 'index.php/basundhara2/settlementTenantNew?app='.$application_no);
            }
            if($appAreaMoreThanDagA == 1)
            {
                $this->session->set_flashdata('error','Total applied area should not be more than total Dag Area !');
                redirect(base_url(). 'index.php/basundhara2/settlementTenantNew?app='.$application_no);
            }
            $recordExist = $this->SettlementApiModel->checkExistDharitree($application_no);
            if ($recordExist) {
                $data = array(
                    'error' => "Case have been Registered Already. Please Check",
                );
                echo json_encode($data);
                exit;
            }

            $this->db->trans_begin();

            $case_name = $this->SettlementApiModel->genearteCaseName();
            if (empty($case_name)) {
                $data = array(
                    'error' => "Network Issue or Seesion Out. Please try Again",
                );
                echo json_encode($data);
                exit;
                die();
            }
            $case_no['petition_no'] = $petition_no = $this->SettlementApiModel->genearteSettlementPetitionNo();

            $case_no['case_no']=$case_name.$petition_no."/".SETTLEMENT_TENANT;

            $pro_class = $this->input->post('protected_class');
            $protected_class_vr = ($pro_class==null || $pro_class=='' || $pro_class==0)?0:$this->input->post('protected_class');


            $basic = array(
                'dist_code' => $this->input->post('dist_code'),
                'subdiv_code' => $this->input->post('subdiv_code'),
                'cir_code' => $this->input->post('cir_code'),
                'mouza_pargona_code' => $this->input->post('mouza_pargona_code'),
                'lot_no' => $this->input->post('lot_no'),
                'vill_townprt_code' => $this->input->post('vill_townprt_code'),
                'service_code' => $this->input->post('service_code'),
                'ref_no' => $this->input->post('ref_no'),
                'case_no' => $case_no['case_no'],
                'trans_code' => 'F', /////////full
                'petition_no' => $case_no['petition_no'],
                'year_no' => date('Y'),
                'date_entry' => date('Y-m-d G:i:s'),
                'status' => 'W',
                'user_code' => $this->session->userdata('user_code'),
                'lm_code' => $this->session->userdata('user_code'),
                'submission_date' => date('Y-m-d G:i:s'),
                'from_office' => 'LM',
                'pending_officer' => 'CO',
                'pending_office' => 'CO',
                'period_possession' => $this->input->post('period_possession'),
                'occupation_applicant' => $this->input->post('occupation_applicant'),
                'applid' => $this->input->post('applid'),
                'caste' => $this->input->post('caste'),
                'uuid' => $this->input->post('uuid'),
                'protected_class' => $protected_class_vr,
                'tribal_belt' => $this->input->post('tribal_belt'),
                'bhumiputra_confirmation'       => $this->input->post('bhumiputra_confirmation'),
                'bhumiputra_certificate_no'     => $this->input->post('bhumiputra_certificate_no'),
                'bhumiputra_certificate_type'   => $this->input->post('bhumiputra_certificate_type'),
                'co_code' => $this->input->post('co_code')
            );

            $insSetBasic = $this->db->insert('settlement_basic', $basic);

            if ($insSetBasic != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET0001: Insertion failed in settlement_basic RTPS Case No ' . $application_no);
                $data = array(
                    'error' => "#ERRSET0001: Registration of Settlement failed for case no : " . $application_no,
                );
                echo json_encode($data);
                return false;
            }
            ////settlement_dag_details insert start
            $fmd = array(
                'dist_code' => $this->input->post('dist_code'),
                'subdiv_code' => $this->input->post('subdiv_code'),
                'cir_code' => $this->input->post('cir_code'),
                'mouza_pargona_code' => $this->input->post('mouza_pargona_code'),
                'lot_no' => $this->input->post('lot_no'),
                'vill_townprt_code' => $this->input->post('vill_townprt_code'),
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d'),
                'case_no' => $case_no['case_no'],
                'petition_no' => $case_no['petition_no'],
                'year_no' => date('Y'),
                'operation' => 'E',
                'dag_no' => $this->input->post('dag_no'),
                'patta_no' => $this->input->post('patta_no'),
                'patta_type_code' => $this->input->post('patta_type_code'),
                'dag_area_b' => $this->input->post('dag_area_b'),
                'dag_area_k' => $this->input->post('dag_area_k'),
                'dag_area_lc' => $this->input->post('dag_area_lc'),
                'dag_area_g' => $this->input->post('dag_area_g'),
                'dag_area_kr' => $this->input->post('dag_area_kr'),
                's_dag_area_b' => $this->input->post('s_dag_area_b'),
                's_dag_area_k' => $this->input->post('s_dag_area_k'),
                's_dag_area_lc' => $this->input->post('s_dag_area_lc'),
                's_dag_area_g' => $this->input->post('s_dag_area_g'),
                's_dag_area_kr' => $this->input->post('s_dag_area_kr'),
                'is_urban' => trim($this->input->post('is_urban')),
                'revenue' => 0,
                'new_land_class_code'=>$district['pattaNo']->land_class_code,
            );
            $insSetDag = $this->db->insert('settlement_dag_details', $fmd);

            if ($insSetDag != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET0002: Insertion failed in settlement_dag_details RTPS Case No ' . $application_no);
                $data = array(
                    'error' => "#ERRSET0002: Registration of Settlement failed for case no : " . $application_no,
                );
                echo json_encode($data);
                return false;
            }

            $c_n = $case_no['case_no'];
            $sql = "SELECT pdar_cron_no FROM
                    settlement_applicant
                        WHERE
                            case_no = '$c_n'";
            $result = $this->db->query($sql);
            if($result->num_rows() > 0){
                $cron_no = (int)$result->row()->pdar_cron_no + 1;
            }else{
                $cron_no = 1;
            }


            // applicant add from API
            foreach ($district['applicants'] as $setl)
            {
                if ($this->input->post('pdar_id' . $setl->id) == "" || $this->input->post('pdar_id' . $setl->id) == null || empty($this->input->post('pdar_id' . $setl->id))) {
                    $chitha_pdar_id = -1;
                } else {
                    $chitha_pdar_id = $this->input->post('pdar_id' . $setl->id);
                }
                if(in_array($setl->id, $delApplicants))
                {
                    continue;
                }
                else
                {
                    $applicant = array(
                        'dist_code' => $this->input->post('dist_code'),
                        'subdiv_code' => $this->input->post('subdiv_code'),
                        'cir_code' => $this->input->post('cir_code'),
                        'mouza_pargona_code' => $this->input->post('mouza_pargona_code'),
                        'lot_no' => $this->input->post('lot_no'),
                        'vill_townprt_code' => $this->input->post('vill_townprt_code'),

                        'user_code' => $this->session->userdata('user_code'),
                        'case_no' => $case_no['case_no'],
                        'petition_no' => $case_no['petition_no'],
                        'operation' => 'E',
                        'dag_no' => $this->input->post('dag_no'),
                        'patta_no' => $this->input->post('patta_no'),
                        'patta_type_code' => $this->input->post('patta_type_code'),
                        'year_no' => date('Y'),
                        'date_entry' => date('Y-m-d'),
                        'pdar_id' => $chitha_pdar_id,
                        'pdar_cron_no' => (int)$cron_no++,
                        'pdar_name' => $this->input->post('pdar_name' . $setl->id),
                        'pdar_guardian' => $this->input->post('pdar_guardian' . $setl->id),

                        'pdar_rel_guar' => $this->input->post('pdar_rel_guar' . $setl->id),
                        'pdar_gender' => $this->input->post('pdar_gender' . $setl->id),
                        // //'pdar_add1' => $part->address,
                        'pdar_add1' => $this->input->post('pdar_add1' . $setl->id),
                        'pdar_add2' => $this->input->post('pdar_add2' . $setl->id),
                        'pdar_mobile' => $this->input->post('pdar_mobile' . $setl->id),
                        // 'i_area_b' => $this->input->post('i_area_b'.$setl->id),
                        // 'i_area_k' => $this->input->post('i_area_k'.$setl->id),
                        // 'i_area_lc' => $this->input->post('i_area_lc'.$setl->id),
                        // 'i_area_g' => $this->input->post('i_area_g'.$setl->id),
                        // 'i_area_kr' => $this->input->post('i_area_kr'.$setl->id),
                        'pdar_type' => $this->input->post('pdar_type' . $setl->id),
                        'is_applicant' => $setl->is_applicant,
                    );

                    $insSetApplicant = $this->db->insert('settlement_applicant', $applicant);

                    if ($insSetApplicant != 1) {
                        // var_dump($insSetApplicant);
                        // echo $this->db->last_query(); die();
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET0003: Insertion failed in settlement_applicant RTPS Case No ' . $application_no);
                        $data = array(
                            'error' => "#ERRSET0003: Registration of Settlement failed for case no : " . $application_no,
                        );
                        echo json_encode($data);
                        return false;
                    }
                }

            }

            ///  dynamic applicant add/////
            if(isset($_POST['pdar_name2'])){
                foreach($_POST['pdar_name2'] as $key =>$value)
                {
                    $applicant2=array(
                        'dist_code'=>$this->input->post('dist_code'),
                        'subdiv_code'=>$this->input->post('subdiv_code'),
                        'cir_code'=>$this->input->post('cir_code'),
                        'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
                        'lot_no'=>$this->input->post('lot_no'),
                        'vill_townprt_code'=>$this->input->post('vill_townprt_code'),
                        'user_code'=>$this->session->userdata('user_code'),
                        'case_no'=>$case_no['case_no'],
                        'petition_no'=>$case_no['petition_no'],
                        'operation'=>'E',
                        'dag_no' =>$this->input->post('dag_no'),
                        'patta_no' =>$this->input->post('patta_no'),
                        'patta_type_code'=>$this->input->post('patta_type_code'),
                        'year_no'=>date('Y'),
                        'date_entry'=>date('Y-m-d'),
                        'pdar_id' =>-1,
                        'pdar_cron_no'=>(int) $cron_no++,
                        'pdar_name' =>$value,
                        'pdar_guardian' =>$_POST['pdar_guardian2'][$key],
                        'pdar_rel_guar' =>$_POST['pdar_rel_guar2'][$key],
                        'pdar_gender'=>$_POST['pdar_gender2'][$key],
                        'pdar_add1' => $_POST['pdar_add12'][$key],
                        'pdar_add2' => $_POST['pdar_add22'][$key],
                        'pdar_mobile' => $_POST['pdar_mobile2'][$key],
                        'pdar_type' => 'B',
                    );

                    $insSetApplicant2 = $this->db->insert('settlement_applicant',$applicant2);
                    // echo $this->db->last_query(); die();

                    if($insSetApplicant2 != 1)
                    {
                        // var_dump($insSetApplicant);
                        // echo $this->db->last_query(); die();
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET00031: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#ERRSET00031: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }

                }
            }


            $petition_no = $case_no['petition_no'];
            $case_no = $case_no['case_no'];

            // insert owner -js -06-09-2022
            // fetch owner details -js- 06-09-2022
            if ($output->owners == true) {
                foreach ($owner as $owner_applicant) {
                    $applicant_owner = array(
                        'dist_code' => $this->input->post('dist_code'),
                        'subdiv_code' => $this->input->post('subdiv_code'),
                        'cir_code' => $this->input->post('cir_code'),
                        'mouza_pargona_code' => $this->input->post('mouza_pargona_code'),
                        'lot_no' => $this->input->post('lot_no'),
                        'vill_townprt_code' => $this->input->post('vill_townprt_code'),

                        'user_code' => $this->session->userdata('user_code'),
                        'case_no' => $case_no,
                        'petition_no' => $petition_no,
                        'operation' => 'E',
                        'dag_no' => $this->input->post('dag_no'),
                        'patta_no' => $this->input->post('patta_no'),
                        'patta_type_code' => $this->input->post('patta_type_code'),
                        'year_no' => date('Y'),
                        'date_entry' => date('Y-m-d'),
                        'pdar_name' => $this->input->post('owners_name' . $owner_applicant[0]->pdar_id),
                        'pdar_guardian' => $this->input->post('owners_guardian' . $owner_applicant[0]->pdar_id),
                        'pdar_mobile' => $this->input->post('owners_mobile_number' . $owner_applicant[0]->pdar_id),
                        'pdar_rel_guar' => '0',
                        'pdar_cron_no' => (int)$cron_no++,
                        'pdar_id' => $owner_applicant[0]->pdar_id,
                        'pdar_type' => 'O',
                        'inplace_alongwith' => $this->input->post('owners_in_place' . $owner_applicant[0]->pdar_id),
                    );

                    $insSetOwners = $this->db->insert('settlement_applicant', $applicant_owner);

                    if ($insSetOwners != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET0004: Insertion failed in settlement_applicant RTPS Case No ' . $application_no);
                        $data = array(
                            'error' => "#ERRSET0004: Registration of Settlement failed for case no : " . $application_no,
                        );
                        echo json_encode($data);
                        return false;
                    }

                }

            }

            // insertion of encroacher/riotee -js- 06-09-2022
            //    fetch encroachers -js- 05-09-2022
            if ($output->encroachers == true) {
                // insert riotee
                foreach ($riotee as $enc_applicant) {

                    $encroacher_app = array(
                        'dist_code' => $this->input->post('dist_code'),
                        'subdiv_code' => $this->input->post('subdiv_code'),
                        'cir_code' => $this->input->post('cir_code'),
                        'mouza_pargona_code' => $this->input->post('mouza_pargona_code'),
                        'lot_no' => $this->input->post('lot_no'),
                        'vill_townprt_code' => $this->input->post('vill_townprt_code'),

                        'user_code' => $this->session->userdata('user_code'),
                        'case_no' => $case_no,
                        'petition_no' => $petition_no,
                        'operation' => 'E',
                        'dag_no' => $this->input->post('dag_no'),
                        'patta_no' => $this->input->post('patta_no'),
                        'patta_type_code' => $this->input->post('patta_type_code'),
                        'year_no' => date('Y'),
                        'date_entry' => date('Y-m-d'),
                        'pdar_name' => $this->input->post('riotee_name' . $enc_applicant[0]->tenant_id),
                        'pdar_guardian' => $this->input->post('riotee_guardian' . $enc_applicant[0]->tenant_id),
                        'pdar_rel_guar' => '0',
                        'pdar_cron_no' => (int)$cron_no++,
                        'pdar_id' => -1,
                        'pdar_type' => 'EN',
                        'riotee_id' => $enc_applicant[0]->tenant_id,
                        'khatian_no' => $this->input->post('khatian_no' . $enc_applicant[0]->tenant_id),
                    );
                    $insSetEncroacher = $this->db->insert('settlement_applicant', $encroacher_app);

                    // echo $this->db->last_query();
                    // die;

                    if ($insSetEncroacher != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET0005: Insertion failed in settlement_applicant RTPS Case No ' . $application_no);
                        $data = array(
                            'error' => "#ERRSET0005: Registration of Settlement failed for case no : " . $application_no,
                        );
                        echo json_encode($data);
                        return false;
                    }

                }
            }

            // insertion of riotee's noks -js- 06-09-2022
            if ($output->riotee_noks == true) {
                $district['riotee_nok'] = $output->riotee_noks;
                foreach ($district['riotee_nok'] as $riotee_nok) {
                    $r_nok = array(
                        'dist_code' => $this->input->post('dist_code'),
                        'subdiv_code' => $this->input->post('subdiv_code'),
                        'cir_code' => $this->input->post('cir_code'),
                        'mouza_pargona_code' => $this->input->post('mouza_pargona_code'),
                        'lot_no' => $this->input->post('lot_no'),
                        'vill_townprt_code' => $this->input->post('vill_townprt_code'),

                        'user_code' => $this->session->userdata('user_code'),
                        'case_no' => $case_no,
                        'petition_no' => $petition_no,
                        'operation' => 'E',
                        'dag_no' => $this->input->post('dag_no'),
                        'patta_no' => $this->input->post('patta_no'),
                        'patta_type_code' => $this->input->post('patta_type_code'),
                        'year_no' => date('Y'),
                        'date_entry' => date('Y-m-d'),
                        'pdar_name' => $this->input->post('riotee_nok_name' . $riotee_nok->id),
                        'pdar_guardian' => $this->input->post('riotee_nok_guardian' . $riotee_nok->id),
                        'pdar_rel_guar' => '0',
                        'pdar_cron_no' => (int)$cron_no++,
                        'pdar_id' => -1,
                        'pdar_type' => $riotee_nok->pdar_type,
                        'riotee_id' => $riotee_nok->encroacher_id,
                        'khatian_no' => $this->input->post('riotee_nok_khatian_no' . $riotee_nok->id),
                    );
                    $insSetRiotee = $this->db->insert('settlement_applicant', $r_nok);

                    if ($insSetRiotee != 1) {
                        // var_dump($insSetApplicant);
                        // echo $this->db->last_query(); die();
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET0006: Insertion failed in settlement_applicant RTPS Case No ' . $application_no);
                        $data = array(
                            'error' => "#ERRSET0006: Registration of Settlement failed for case no : " . $application_no,
                        );
                        echo json_encode($data);
                        return false;
                    }

                }
            }

            ////settlement Tenant LM Report insert start

            ////////////////////file///////////////////////////

            // For uploading dag wise trace_map_copy
            foreach($district['encroachers'] as $dags_doc){
                $timestamp = date('mdYhis', time()).uniqid();

                // Trace Map copy upload
                $config['file_name']            = 'trace_map_copy'.$timestamp;
                $config['upload_path']          = UPLOAD_DIR;
                $config['allowed_types']        = 'pdf|jpg|png';
                $config['max_size']             = 2000;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ( ! $this->upload->do_upload('trace_map_copy'.$dags_doc->id))
                {
                    $error = array('error' => $this->upload->display_errors());
                    echo json_encode($error);
                    return false;
                }
                else
                {
                    $data = array('upload_data' => $this->upload->data());
                    $document= array(
                        'case_no' => $case_no,
                        'file_name' => 'Trace Map Copy',
                        'user_code' => $this->session->userdata('user_code'),
                        'fetch_file_name' => $data['upload_data']['orig_name'],
                        'file_type' => $data['upload_data']['file_type'],
                        'file_path' => $config['upload_path'].$data['upload_data']['orig_name'],
                        'date_entry' => date('Y-m-d h:i:s'),
                        'mut_type' => $this->input->post('service_code'),
                        'dag_no' => $this->input->post('dag_no_doc'.$dags_doc->id)
                    );

                    $insert_supportive_doc= $this->db->insert('supportive_document',$document);

                    if($insert_supportive_doc != 1){
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORPPSSGG: Insertion failed in supportive_document for case no :'. $case_no);
                        $json = [
                            'errorMessage'=>"#ERRORPPSSGG: Failed to forward the case for Case No : ".$case_no
                        ];
                        echo json_encode($json);
                        return false;
                    }
                }
            }

            $timestamp = date('mdYhis', time()).uniqid();
            // For uploading field report
            $config2['file_name']            = 'field_report'.$timestamp;
            $config2['upload_path']          = UPLOAD_DIR;
            $config2['allowed_types']        = 'pdf|jpg|png';
            $config2['max_size']             = 2000;

            $this->upload->initialize($config2);

            if ( ! $this->upload->do_upload('field_report'))
            {
                $error = array('error' => $this->upload->display_errors());

                var_dump($error);
                die;
            }
            else
            {
                $data = array('upload_data' => $this->upload->data());
                $document= array(
                    'case_no' => $case_no,
                    'file_name' => 'Field Report',
                    'user_code' => $this->session->userdata('user_code'),
                    'fetch_file_name' => $data['upload_data']['orig_name'],
                    'file_type' => $data['upload_data']['file_type'],
                    'file_path' => $config2['upload_path'].$data['upload_data']['orig_name'],
                    'date_entry' => date('Y-m-d h:i:s'),
                    'mut_type' => $this->input->post('service_code'),
                );

                $insert_supportive_doc= $this->db->insert('supportive_document',$document);

                if($insert_supportive_doc != 1){
                    $this->db->trans_rollback();
                    log_message('error', '#ERRORPPSSGGP: Insertion failed in supportive_document for case no :'. $case_no);
                    $json = [
                        'errorMessage'=>"#ERRORPPSSGGP: Failed to forward the case for Case No : ".$case_no
                    ];
                    echo json_encode($json);
                    return false;
                }
            }


            // UPDATING Geo Tag Photo case number in supportive document
            if(isset($district['geo_tag_doc'])){
                foreach($district['geo_tag_doc'] as $geo_tag_loop){
                    $geo_tag_array = array(
                        'case_no' => $case_no
                    );
                    $this->db->where('applid', $geo_tag_loop->applid);
                    $this->db->where('dag_no', $geo_tag_loop->dag_no);
                    $this->db->where('file_name', GEO_TAG_PHOTO);
                    $this->db->update('supportive_document', $geo_tag_array);

                    if($this->db->affected_rows() == 0 ){
                        $this->db->trans_rollback();
                        log_message('error', '#SETUP0001S: Updation failed in supportive_document basundhara Case No '.$geo_tag_loop->applid);
                        $data = array(
                            'error'=>"#SETUP0001S: Registration of Settlement failed for case no : ".$geo_tag_loop->applid
                        );
                        echo json_encode($data);
                        return false;
                    }
                }
            }

            ///////////////////////////////////////////////

            $comment = addslashes($this->input->post('lm_remark'));
            $lm_remark_text = $this->input->post('lm_remark_text');

            $pro_class_lm = $this->input->post('protected_class_lm');
            $protected_class_lm = ($pro_class_lm==null || $pro_class_lm=='' || $pro_class_lm==0)?0:$this->input->post('protected_class_lm');

            $lmnote = array(
                'user_code' => $this->session->userdata('user_code'),
                'chitha_verified' => $this->input->post('chiitha_verified'),
                // 'vlb_verified'=>$this->input->post('vlb_verified'),

                //'lm_riotee_id_change' => $this->input->post('riotee_id'),

                'possession_verification' => $this->input->post('possession_verified'),
                'period_possession' => $this->input->post('period_possession'),
                'nature_possession' => $this->input->post('nature_possession'),
                'is_landless' => $this->input->post('is_landless'),
                'land_falls' => $this->input->post('land_falls'),
                'falls_und_gmc' => $this->input->post('falls_und_gmc'),

                'trace_map_copy' => 'NA',
                'chitha_copy' => 'NA',
                'lm_note' => $comment,
                'lm_remark_text' => $lm_remark_text,
                'date_entry' => date('Y-m-d h:i:s'),
                'case_no' => $case_no,
                'status' => 'W',

                'total_bigha' => $this->input->post('total_bigha'),
                'total_Katha' => $this->input->post('total_Katha'),
                'total_lessa' => $this->input->post('total_lessa'),
                'total_ganda' => $this->input->post('total_ganda'),
                'total_kranti' => $this->input->post('total_kranti'),
                'land_used_by_occupants' => $this->input->post('land_used_by_occupants'),
                'e_khajana_receipt_check' => $this->input->post('khajana_receipt'),
                'rk_verified' => $this->input->post('rk_verified'),
                'protected_class_lm' => $protected_class_lm,
                'erosion' => $this->input->post('erosion'),
                'litigation' => $this->input->post('litigation'),
                'landslide' => $this->input->post('landslide'),
                'is_tribal_belt' => $this->input->post('is_tribal_belt'),
                'bhumiputra_confirmation'   => $this->input->post('bhumiputra_confirmation_lm'),
            );
            $insLmnote = $this->db->insert('settlement_ap_lmnote', $lmnote);
            if ($insLmnote != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET0007: Insertion failed in settlement_ap_lmnote RTPS Case No ' . $application_no);
                $data = array(
                    'error' => "#ERRSET0007: Registration of Settlement failed for case no : " . $application_no,
                );
                echo json_encode($data);
                return false;
            }
            //////proceeding start//////
            $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

            if ($proceeding_id == null) {
                $proceeding_id = 1;
            }

            $insPetProceed = [
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_on_order' => $lm_remark_text,
                'status' => 'W',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'LM',
                'office_to' => 'CO',
                'task' => $comment,
            ];
            $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

            if ($insertProceeding != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :' . $case_no);
                $json = [
                    'errorMessage' => "#ERRORPP: Failed to forward the case for Case No : " . $case_no,
                ];
                echo json_encode($json);
                return false;
            }
            //////proceeding end//////

            ////settlement Tenant LM Report insert end
            if ($this->db->trans_status() == false) {
                $this->db->trans_rollback();
                $data = array(
                    'error' => "Error in submitting. Please try Again",
                );
            } else {
                $basundhara = array(
                    'dharitree' => $case_no,
                    'basundhara' => $application_no,
                    'date_reg' => date('Y-m-d'),
                    'reg_by' => $this->session->userdata('user_code'),
                    'app_status' => 'W',
                    'pending_with' => 'LM',
                );
                $this->db->insert('basundhar_application', $basundhara);
                //////////////POST To basundhara/////////////////////
                $rmk = 'Forwarded to CO';
                $status = 'W';
                $task = 'LM';
                $pen = 'CO';
                $case = $case_no;
                $rtps_status = $this->SettlementApiModel->postApiBasundhara($application_no, $case, $rmk, $status, $task, $pen);
                $rtps_status = json_decode($rtps_status);
                // var_dump($rtps_status); die();
                if (trim($rtps_status)!="y") {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRAPP0011: Settlement Application not submitted case no # $case_no");
                    redirect(base_url() . "index.php/home");
                } else {
                    $this->db->trans_commit();
                }

                //////////////////
                // $this->DashboardInheritance($case_no['case_no']);
                //////
                //////////////////////////////////
                $this->session->set_flashdata('message', "Application Successfully Forwarded to Circle Office With Case No # $case_no");
                redirect(base_url() . "index.php/home");

                // $data=array(
                //     'success'=>"Settlement Application Registered Successfully with case no $case_no[case_no]",
                //     'redirect_url'=>base_url().'index.php/home'
                // );
            }
            // echo json_encode($data);
        }
    }



    // settlement TEA post
    function settlementTeaPostNew()
    {

        $this->load->library('form_validation');

        $application_no = trim($this->input->post('application_no'));
        $distCode = trim($this->input->post('dist_code'));
        if($distCode == NULL)
        {
            redirect(base_url(). 'index.php/basundhara2/settlementCases');
        }
        if($application_no == NULL)
        {
            redirect(base_url(). 'index.php/basundhara2/settlementCases');
        }

        $deleted_applicants = $this->input->post('deleted_applicant');
        $deleteAppCon = 0;
        $delApplicants = [];
        if($deleted_applicants != '' or $deleted_applicants != NULL)
        {
            $deleteAppCon = 1;
            $allSplitApplicants = (explode(",",$deleted_applicants));
            $delApplicants = [];
            foreach ($allSplitApplicants as $mm)
            {
                $splitApplicants = (explode("_",$mm));
                $delApplicants[] = $splitApplicants[0];
            }
        }

        $this->form_validation->set_rules('service_code', 'Service Code', 'trim|required|is_natural');
        $this->form_validation->set_rules('lot_no', 'Lot Number', 'trim|required');
        $this->form_validation->set_rules('application_no', 'Application No', 'trim|required|min_length[2]');
        $this->form_validation->set_rules('ref_no', 'Application No', 'trim|required|min_length[10]');
        $this->form_validation->set_rules('is_urban', 'Is Urban', 'trim|required');
        $this->form_validation->set_rules('dist_name', 'District Name', 'trim|required');
        $this->form_validation->set_rules('dist_code', 'District Code', 'trim|required');
        $this->form_validation->set_rules('subdiv_name', 'Sub Division Name', 'trim|required');
        $this->form_validation->set_rules('subdiv_code', 'Sub Division Code', 'trim|required');
        $this->form_validation->set_rules('circle_name', 'Circle Name', 'trim|required');
        $this->form_validation->set_rules('cir_code', 'Circle Code', 'trim|required');
        $this->form_validation->set_rules('mouza_name', ' Mouza Name', 'trim|required');
        $this->form_validation->set_rules('mouza_pargona_code', 'Mouza Code ', 'trim|required');
        $this->form_validation->set_rules('village_name', 'Village Name ', 'trim|required');
        $this->form_validation->set_rules('vill_townprt_code', 'Village Code ', 'trim|required');

        $this->form_validation->set_rules('chiitha_verified', 'Chitha Verified', 'trim|required');
        $this->form_validation->set_rules('vlb_verified', 'VLB Verified', 'trim|required');
        $this->form_validation->set_rules('bhumiputra_confirmation_lm', 'Bhumiputra Verified', 'trim|required');
        $this->form_validation->set_rules('possession_verified', 'Possession Verified', 'trim|required');
        $this->form_validation->set_rules('whether_tribal', 'Proposed land falls under Tribal Belt/ Block', 'trim|required');
        $this->form_validation->set_rules('protected_class_lm', 'Applicant falls under protected category', 'trim|required');
        $this->form_validation->set_rules('landslide', 'Is Area Under cover landslide prone ?', 'trim|required');
        $this->form_validation->set_rules('erosion', 'Land falls under erosion', 'trim|required');
        $this->form_validation->set_rules('litigation', 'Whether proposed land is under litigation', 'trim|required');
        $this->form_validation->set_rules('nature_possession', 'Nature of Possession', 'trim|required');
        $this->form_validation->set_rules('is_landless', '. Whether application is landless', 'trim|required');
        $this->form_validation->set_rules('landed_property', 'Landed property of the petitioner and his family', 'trim|required');
        $this->form_validation->set_rules('livelihood', 'The Applicant should undertake special cultivation', 'trim|required');
        $this->form_validation->set_rules('suitability', 'Suitability of proposed land for tea cultivation', 'trim|required');
        $this->form_validation->set_rules('admissible_area', 'Patta land of applicantÃ¢â‚¬â„¢s family', 'trim|required');
        $this->form_validation->set_rules('govt_allotted', 'Weather the applicant has been allotted govt land before', 'trim|required');
        $this->form_validation->set_rules('is_st', 'Whether the petitioner', 'trim|required');
        $this->form_validation->set_rules('is_indigenous', 'Whether the applicant is indigenous unemployed educated youth', 'trim|required');
        $this->form_validation->set_rules('is_reg_with_teaboard', 'Whether registered with Tea Board', 'trim|required');
        $this->form_validation->set_rules('land_falls', 'Whether the proposed land falls under', 'trim|required|is_natural|greater_than[0]');
        $this->form_validation->set_rules('falls_und_gmc', 'Falls Under GMC', 'trim|required');
        $this->form_validation->set_rules('roadside_comment_check', 'Specific comment on roadside', 'trim|required');
        $this->form_validation->set_rules('zonal_valuation', 'Zonal Valuation', 'trim|required|numeric|greater_than[0]');
        $this->form_validation->set_rules('lm_remark', 'LM Remarks', 'trim|required');
        $this->form_validation->set_rules('lm_remark_text', 'LM Remarks (Text Area)', 'trim|required');
        $this->form_validation->set_rules('co_code', 'Select Circle Officer', 'trim|required');

        $this->form_validation->set_rules('aadhar_verified', 'Aadhaar verified', 'trim|required');
        // $this->form_validation->set_rules('bhumiputra_confirmation', 'Bhumiputra Certificate/Ack verified', 'trim|required');
        $this->form_validation->set_rules('caste', 'Caste', 'trim|required');
        $this->form_validation->set_rules('under_bpl', 'Under BPL', 'trim|required');
        $this->form_validation->set_rules('tribal_belt_applicant', 'Land prayed for is within tribal belt/block', 'trim|required');
        $this->form_validation->set_rules('board_name', 'Board Name', 'trim|required');
        $this->form_validation->set_rules('occupation_applicant', 'Occupation or Profession of the Applicant', 'trim|required');


        /////////////////////
        $url = API_LINK_MB2."getAppDetails?application_no=" . $application_no ;
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
        $district['applicants']=$output->applicants;
        $district['document']=$output->documents;
        $district['query']=$output->query;
        $district['property']=$output->property;
        $district['settlements']=$output->settlements;
        $district['encroachers'] = $output->encroachers;
        $district['owners'] = $output->owners;
        $district['riotee_noks'] = $output->riotee_noks;
        $district['aadhar']=$output->aadhar;
        $district['nextKin'] = $output->nextKin;

        $d=$district['app']->dist_code;
        $s=$district['app']->subdiv_code;
        $c=$district['app']->cir_code;
        $m=$district['app']->mouza_code;
        $l=$district['app']->lot_no;
        $v=$district['app']->village_code;
        $pno=$district['pattaNo']->patta_no;
        $pc=$district['pattaNo']->patta_type_code;
        $dag = $district['app']->dag_no;

        $totalDagAreaLessaValidation  = 0;
        $totalAgrAreaLessaValidation  = 0;
        $appAreaMoreThanDagA = 0;
        $reserveMoreThanAppArea = 0;
        $totalRoadSideAreaLessaValidation = 0;
        foreach($district['encroachers'] as $dags)
        {
            // for barak valley
            if(in_array($distCode, json_decode(BARAK_VALLEY)))
            {
                $this->form_validation->set_rules('dag_no'.$dags->id, 'Dag Number', 'trim|required|is_natural');
                $this->form_validation->set_rules('patta_no'.$dags->id, 'Patta Number', 'trim|required|is_natural');
                $this->form_validation->set_rules('patta_type_code'.$dags->id, 'Patta Type Code', 'trim|required|is_natural');
                $this->form_validation->set_rules('land_type'.$dags->id, 'Land Type', 'trim|required|is_natural');

                $this->form_validation->set_rules('dag_area_b'.$dags->id, 'Total Land Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                $this->form_validation->set_rules('dag_area_k'.$dags->id, 'Total Land Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                $this->form_validation->set_rules('dag_area_lc'.$dags->id, 'Total Land Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('dag_area_g'.$dags->id, 'Total Land Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('dag_area_kr'.$dags->id, 'Total Land Area (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('mbigha'.$dags->id, 'Applied Homestead Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                $this->form_validation->set_rules('mkatha'.$dags->id, 'Applied Homestead Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                $this->form_validation->set_rules('mlessa'.$dags->id, 'Applied Homestead Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('mganda'.$dags->id, 'Applied Homestead Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('mkranti'.$dags->id, 'Applied Homestead Area (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('agri_bigha'.$dags->id, 'Applied Agricultural Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                $this->form_validation->set_rules('agri_katha'.$dags->id, 'Applied Agricultural Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                $this->form_validation->set_rules('agri_lessa'.$dags->id, 'Applied Agricultural Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('agri_ganda'.$dags->id, 'Applied Agricultural Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('agri_kranti'.$dags->id, 'Applied Agricultural Area (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'.$dags->id), 0);
                $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'.$dags->id), 0);
                $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'.$dags->id), 0);
                $gandaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_g'.$dags->id), 0);

                $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_bigha'.$dags->id), 0);
                $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_katha'.$dags->id), 0);
                $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_lessa'.$dags->id), 0);
                $gandaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_ganda'.$dags->id), 0);

                $dagAreaLessaValidation = ($bighaValidation * 6400) + ($kathaValidation * 320) + ($lessaValidation * 20) + $gandaValidation;
                $agrAreaLessaValidation = ($bighaValidationAgr * 6400) + ($kathaValidationAgr * 320) + ($lessaValidationAgr * 20) + $gandaValidationAgr;

                if($dagAreaLessaValidation < $agrAreaLessaValidation)
                {
                    $appAreaMoreThanDagA = 1;
                }

                $totalDagAreaLessaValidation += $dagAreaLessaValidation;
                $totalAgrAreaLessaValidation += $agrAreaLessaValidation;

                if($this->input->post('roadside_comment_check') == 'YES')
                {
                    $this->form_validation->set_rules('reserved_bigha'.$dags->id, 'Reserved Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('reserved_katha'.$dags->id, 'Reserved Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                    $this->form_validation->set_rules('reserved_lessa'.$dags->id, 'Reserved Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('reserved_ganda'.$dags->id, 'Reserved Ganda', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                    $this->form_validation->set_rules('reserved_kranti'.$dags->id, 'Reserved Kranti', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $bighaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha'.$dags->id), 0);
                    $kathaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_katha'.$dags->id), 0);
                    $lessaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa'.$dags->id), 0);
                    $gandaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_ganda'.$dags->id), 0);

                    $roadSideAreaLessaValidation = ($bighaValidationRoadside * 6400) + ($kathaValidationRoadside * 320) + ($lessaValidationRoadside * 20) + $gandaValidationRoadside;

                    if($dagAreaLessaValidation < $roadSideAreaLessaValidation)
                    {
                        $reserveMoreThanAppArea = 1;
                    }

                    $totalRoadSideAreaLessaValidation += $roadSideAreaLessaValidation;
                }
            }
            else
            {
                $this->form_validation->set_rules('dag_no'.$dags->id, 'Dag Number', 'trim|required|is_natural');
                $this->form_validation->set_rules('patta_no'.$dags->id, 'Patta Number', 'trim|required|is_natural');
                $this->form_validation->set_rules('patta_type_code'.$dags->id, 'Patta Type Code', 'trim|required|is_natural');
                $this->form_validation->set_rules('dag_area_b'.$dags->id, 'Total Land Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                $this->form_validation->set_rules('dag_area_k'.$dags->id, 'Total Land Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                $this->form_validation->set_rules('dag_area_lc'.$dags->id, 'Total Land Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('mbigha'.$dags->id, 'Applied Homestead Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                $this->form_validation->set_rules('mkatha'.$dags->id, 'Applied Homestead Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                $this->form_validation->set_rules('mlessa'.$dags->id, 'Applied Homestead Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('agri_bigha'.$dags->id, 'Applied Agricultural Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                $this->form_validation->set_rules('agri_katha'.$dags->id, 'Applied Agricultural Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                $this->form_validation->set_rules('agri_lessa'.$dags->id, 'Applied Agricultural Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
                $this->form_validation->set_rules('land_type'.$dags->id, 'Land Type', 'trim|required|is_natural');

                $bighaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_b'.$dags->id), 0);
                $kathaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_k'.$dags->id), 0);
                $lessaValidation = $this->UtilsModel->defaultValue($this->input->post('dag_area_lc'.$dags->id), 0);

                $bighaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_bigha'.$dags->id), 0);
                $kathaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_katha'.$dags->id), 0);
                $lessaValidationAgr = $this->UtilsModel->defaultValue($this->input->post('agri_lessa'.$dags->id), 0);

                $dagAreaLessaValidation = ($bighaValidation * 100) + ($kathaValidation * 20) + $lessaValidation;
                $agrAreaLessaValidation = ($bighaValidationAgr * 100) + ($kathaValidationAgr * 20) + $lessaValidationAgr;

                if($dagAreaLessaValidation < $agrAreaLessaValidation)
                {
                    $appAreaMoreThanDagA = 1;
                }

                $totalDagAreaLessaValidation += $dagAreaLessaValidation;
                $totalAgrAreaLessaValidation += $agrAreaLessaValidation;

                if($this->input->post('roadside_comment_check') == 'YES')
                {
                    $this->form_validation->set_rules('reserved_bigha'.$dags->id, 'Reserved Bigha', 'trim|required|is_natural|greater_than[-1]|xss_clean');
                    $this->form_validation->set_rules('reserved_katha'.$dags->id, 'Reserved Katha', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
                    $this->form_validation->set_rules('reserved_lessa'.$dags->id, 'Reserved Lessa', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

                    $bighaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_bigha'.$dags->id), 0);
                    $kathaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_katha'.$dags->id), 0);
                    $lessaValidationRoadside = $this->UtilsModel->defaultValue($this->input->post('reserved_lessa'.$dags->id), 0);

                    $roadSideAreaLessaValidation = ($bighaValidationRoadside * 100) + ($kathaValidationRoadside * 20) + $lessaValidationRoadside ;

                    if($dagAreaLessaValidation < $roadSideAreaLessaValidation)
                    {
                        $reserveMoreThanAppArea = 1;
                    }

                    $totalRoadSideAreaLessaValidation += $roadSideAreaLessaValidation;
                }
            }

        }

        if($deleteAppCon == 1)
        {
            foreach($district['applicants'] as $setl)
            {
                if(in_array($setl->id, $delApplicants))
                {
                    continue;
                }
                else
                {
                    $this->form_validation->set_rules('pdar_name'.$setl->id, 'Pattadar Name', 'trim|required|min_length[3]|max_length[70]');
                    $this->form_validation->set_rules('pdar_guardian'.$setl->id, 'Pattadar Guardian', 'trim|required|min_length[3]|max_length[70]');
                    $this->form_validation->set_rules('pdar_rel_guar'.$setl->id, 'Pattadar Guardian Relation', 'trim|required');
                    $this->form_validation->set_rules('pdar_gender'.$setl->id, 'Pattadar Gender ', 'trim|required');
                    $this->form_validation->set_rules('pdar_add1'.$setl->id, 'Pattadar Address 1', 'trim|required|min_length[3]|max_length[200]');
                    $this->form_validation->set_rules('pdar_add2'.$setl->id, 'Pattadar Address 2', 'trim|required|min_length[3]|max_length[200]');
                    $this->form_validation->set_rules('pdar_mobile'.$setl->id, 'Pattadar Mobile No.', 'trim|required|min_length[10]|max_length[10]');
                    $this->form_validation->set_rules('pdar_type'.$setl->id, 'Pattadar Type', 'trim|required');

                }
            }
        }
        else
        {
            foreach($district['applicants'] as $setl)
            {
                $this->form_validation->set_rules('pdar_name' . $setl->id, 'Pattadar Name', 'trim|required|min_length[3]|max_length[70]');
                $this->form_validation->set_rules('pdar_guardian' . $setl->id, 'Pattadar Guardian', 'trim|required|min_length[3]|max_length[70]');
                $this->form_validation->set_rules('pdar_rel_guar' . $setl->id, 'Pattadar Guardian Relation', 'trim|required');
                $this->form_validation->set_rules('pdar_gender' . $setl->id, 'Pattadar Gender ', 'trim|required');
                $this->form_validation->set_rules('pdar_add1' . $setl->id, 'Pattadar Address 1', 'trim|required|min_length[3]|max_length[200]');
                $this->form_validation->set_rules('pdar_add2' . $setl->id, 'Pattadar Address 2', 'trim|required|min_length[3]|max_length[200]');
                $this->form_validation->set_rules('pdar_mobile' . $setl->id, 'Pattadar Mobile No.', 'trim|required|min_length[10]|max_length[10]');
                $this->form_validation->set_rules('pdar_type' . $setl->id, 'Pattadar Type', 'trim|required');
            }
        }

        if(isset($_POST['pdar_name2'])){
            if($_POST['pdar_name2'] != '' OR $_POST['pdar_name2'] != NULL OR $_POST['pdar_guardian2'] != '' OR $_POST['pdar_guardian2']
                != NULL OR $_POST['pdar_rel_guar2'] != '' OR $_POST['pdar_rel_guar2'] != NULL
                OR $_POST['pdar_gender2'] != '' OR $_POST['pdar_gender2'] != NULL)
            {

                $this->form_validation->set_rules('pdar_name2[]', 'Pattadar Name', 'trim|required|min_length[3]|max_length[70]');
                $this->form_validation->set_rules('pdar_guardian2[]', 'Pattadar Guardian', 'trim|required|min_length[3]|max_length[70]');
                $this->form_validation->set_rules('pdar_rel_guar2[]', 'Pattadar Guardian Relation', 'trim|required');
                $this->form_validation->set_rules('pdar_gender2[]', 'Pattadar Gender ', 'trim|required');
                $this->form_validation->set_rules('pdar_add12[]', 'Pattadar Address 1', 'trim|required|min_length[3]|max_length[200]');
                $this->form_validation->set_rules('pdar_add22[]', 'Pattadar Address 2', 'trim|required|min_length[3]|max_length[200]');
                $this->form_validation->set_rules('pdar_mobile2[]', 'Pattadar Mobile No.', 'trim|required|min_length[10]|max_length[10]');
            }
        }

        if($output->encroachers == true)
        {
            foreach($output->encroachers as $enc_applicant)
            {
                $this->form_validation->set_rules('enc_dag'.$enc_applicant->id, 'Encroachers Dag Nu.', 'trim|required|is_natural');
                $this->form_validation->set_rules('patta_no'.$enc_applicant->id, 'Encroachers Patta No.', 'trim|required|is_natural');
                $this->form_validation->set_rules('patta_type_code'.$enc_applicant->id, 'Encroachers Pattadar Type ', 'trim|required|is_natural');
                $this->form_validation->set_rules('period_possession'.$enc_applicant->id, 'Encroachers Period Possession', 'trim|required');
                $this->form_validation->set_rules('riotee_name'.$enc_applicant->id, 'Encroachers Name', 'trim|required|min_length[3]|max_length[70]');
                $this->form_validation->set_rules('riotee_guardian'.$enc_applicant->id, 'Encroachers  Guardian', 'trim|required|min_length[3]|max_length[70]');
                $this->form_validation->set_rules('enc_id'.$enc_applicant->id, 'Encroacher Id', 'trim|required|is_natural');
            }
        }

        if ($this->form_validation->run() == FALSE)
        {
            $errors = validation_errors();
            $this->session->set_flashdata('error',$errors);
            redirect(base_url(). 'index.php/basundhara2/settlementApplication?app='.$application_no);

        }
        else
        {
            if($totalAgrAreaLessaValidation == 0)
            {
                $this->session->set_flashdata('error','Total applied area should not be Zero !');
                redirect(base_url(). 'index.php/basundhara2/settlementApplication?app='.$application_no);
            }
            if($reserveMoreThanAppArea == 1)
            {
                $this->session->set_flashdata('error','Total roadside reserved area should not be more than total applied area !');
                redirect(base_url(). 'index.php/basundhara2/settlementApplication?app='.$application_no);
            }
            if($appAreaMoreThanDagA == 1)
            {
                $this->session->set_flashdata('error','Total applied area should not be more than total Dag Area !');
                redirect(base_url(). 'index.php/basundhara2/settlementApplication?app='.$application_no);
            }

            if(CULTIVATION_MAX_APPLIED * 100 < $totalAgrAreaLessaValidation)
            {
                $this->session->set_flashdata('error','Total applied Agriculture area should not be more than '. CULTIVATION_MAX_APPLIED. ' Bigha !');
                redirect(base_url(). 'index.php/basundhara2/settlementApplication?app='.$application_no);
            }

            $recordExist=$this->SettlementApiModel->checkExistDharitree($application_no);
            if($recordExist)
            {
                $data=array(
                    'error'=>"Case have been Registered Already. Please Check"
                );
                echo json_encode($data);
                die();
            }

            $this->db->trans_begin();

            $case_name=$this->SettlementApiModel->genearteCaseName();
            if(empty($case_name))
            {

                $data=array(
                    'error'=>"Network Issue or Session Out. Please try Again"
                );
                echo json_encode($data);
                die();
            }
            $case_no['petition_no']=$petition_no=$this->SettlementApiModel->genearteSettlementPetitionNo();


            $case_no['case_no']=$case_name.$petition_no."/".SETTLEMENT_SPECIAL_CULTIVATORS;

            $pro_class = $this->input->post('protected_class');
            $protected_class_vr = ($pro_class==null || $pro_class=='' || $pro_class==0)?0:$this->input->post('protected_class');

            $basic=array(
                'dist_code'=>$this->input->post('dist_code'),
                'subdiv_code'=>$this->input->post('subdiv_code'),
                'cir_code'=>$this->input->post('cir_code'),
                'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
                'lot_no'=>$this->input->post('lot_no'),
                'vill_townprt_code'=>$this->input->post('vill_townprt_code'),
                'service_code'=>$this->input->post('service_code'),
                'ref_no'=>$this->input->post('ref_no'),
                'case_no'=>$case_no['case_no'],
                'trans_code'=>'F',/////////full
                'petition_no'=>$case_no['petition_no'],
                'year_no'=>date('Y'),
                'date_entry' => date('Y-m-d G:i:s'),
                'status'=>'W',
                'user_code'=>$this->session->userdata('user_code'),
                'lm_code' => $this->session->userdata('user_code'),
                'submission_date' => date('Y-m-d G:i:s'),
                'from_office' => 'LM',
                'pending_officer' => 'CO',
                'pending_office' => 'CO',
                'period_possession'=>date('Y-m-d'),
                'occupation_applicant'=>$this->input->post('occupation_applicant'),
                'applid'=>$this->input->post('applid'),
                'cult_board'=>$this->input->post('board_name'),
                'cultboard_reg_no'=>$this->input->post('board_registration_no'),
                'caste' => $this->input->post('caste'),
                'protected_class' => $protected_class_vr,
                'tribal_belt' => $this->input->post('tribal_belt_applicant'),
                'bhumiputra_confirmation'       => $this->input->post('bhumiputra_confirmation'),
                'bhumiputra_certificate_no'     => $this->input->post('bhumiputra_certificate_no'),
                'bhumiputra_certificate_type'   => $this->input->post('bhumiputra_certificate_type'),
                'co_code' => $this->input->post('co_code')
            );

            $insSetBasic = $this->db->insert('settlement_basic',$basic);


            if($insSetBasic != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET0001: Insertion failed in settlement_basic RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRSET0001: Registration of Settlement failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }

            ////settlement_dag_details insert start
            foreach($district['encroachers'] as $dags){
                $district['class']=$this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$this->input->post('dag_no'.$dags->id));
                $fmd=array(
                    'dist_code'=>$this->input->post('dist_code'),
                    'subdiv_code'=>$this->input->post('subdiv_code'),
                    'cir_code'=>$this->input->post('cir_code'),
                    'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
                    'lot_no'=>$this->input->post('lot_no'),
                    'vill_townprt_code'=>$this->input->post('vill_townprt_code'),
                    'user_code'=>$this->session->userdata('user_code'),
                    'date_entry'=>date('Y-m-d'),
                    'case_no'=>$case_no['case_no'],
                    'petition_no'=>$case_no['petition_no'],
                    'year_no'=>date('Y'),
                    'operation'=>'E',
                    'new_land_class_code'=>$district['class']->land_class_code,
                );

                $fmd['dag_no']= $this->input->post('dag_no'.$dags->id);
                $fmd['patta_no']=$this->input->post('patta_no'.$dags->id);
                $fmd['patta_type_code']=$this->input->post('patta_type_code'.$dags->id);

                $fmd['dag_area_b']=$this->input->post('dag_area_b'.$dags->id);
                $fmd['dag_area_k']=$this->input->post('dag_area_k'.$dags->id);
                $fmd['dag_area_lc']=$this->input->post('dag_area_lc'.$dags->id);
                $fmd['dag_area_g']=$this->input->post('dag_area_g'.$dags->id);
                $fmd['dag_area_kr']=$this->input->post('dag_area_kr'.$dags->id);


                $fmd['home_b']=$this->input->post('mbigha'.$dags->id);
                $fmd['home_k']=$this->input->post('mkatha'.$dags->id);
                $fmd['home_lc']=$this->input->post('mlessa'.$dags->id);
                $fmd['home_g']=$this->input->post('mganda'.$dags->id);
                $fmd['home_kr']=$this->input->post('mkranti'.$dags->id);

                $fmd['agri_b']=$this->input->post('agri_bigha'.$dags->id);
                $fmd['agri_k']=$this->input->post('agri_katha'.$dags->id);
                $fmd['agri_lc']=$this->input->post('agri_lessa'.$dags->id);
                $fmd['agri_g']=$this->input->post('agri_ganda'.$dags->id);
                $fmd['agri_kr']=$this->input->post('agri_kranti'.$dags->id);

                $fmd['s_dag_area_b']=$this->input->post('s_dag_area_b');
                $fmd['s_dag_area_k']=$this->input->post('s_dag_area_k');
                $fmd['s_dag_area_lc']=$this->input->post('s_dag_area_lc');
                $fmd['s_dag_area_g']=$this->input->post('s_dag_area_g');
                $fmd['s_dag_area_kr']=$this->input->post('s_dag_area_kr');

                $fmd['is_urban']=trim($this->input->post('is_urban'));
                $fmd['revenue']=0;
                $fmd['land_type']= $this->input->post('land_type'.$dags->id);
                $insSetDag = $this->db->insert('settlement_dag_details',$fmd);


                if($insSetDag != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET0002: Insertion failed in settlement_dag_details RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRSET0002: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
            }
            ////settlement_dag_details insert end

            ////settlement_applicant insert start

            // $petition_no = $case_no['petition_no'];
            $sql = "SELECT pdar_cron_no FROM
                    settlement_applicant
                        WHERE
                            case_no = '".$case_no['case_no']."'";
            $result = $this->db->query($sql);
            if($result->num_rows() > 0){
                $cron_no = (int)$result->row()->pdar_cron_no + 1;
            }else{
                $cron_no = 1;
            }



            //// API applicant add
            foreach($district['applicants'] as $setl)
            {
                if($this->input->post('pdar_id'.$setl->id)=="" || $this->input->post('pdar_id'.$setl->id)==null || empty($this->input->post('pdar_id'.$setl->id)))
                {
                    $chitha_pdar_id=-1;
                }else{
                    $chitha_pdar_id=$this->input->post('pdar_id'.$setl->id);
                }
                if(in_array($setl->id, $delApplicants))
                {
                    continue;
                }
                else {

                    $applicant = array(
                        'dist_code' => $this->input->post('dist_code'),
                        'subdiv_code' => $this->input->post('subdiv_code'),
                        'cir_code' => $this->input->post('cir_code'),
                        'mouza_pargona_code' => $this->input->post('mouza_pargona_code'),
                        'lot_no' => $this->input->post('lot_no'),
                        'vill_townprt_code' => $this->input->post('vill_townprt_code'),

                        'user_code' => $this->session->userdata('user_code'),
                        'case_no' => $case_no['case_no'],
                        'petition_no' => $case_no['petition_no'],
                        'operation' => 'E',
                        'dag_no' => $this->input->post('dag_no'),
                        'patta_no' => $this->input->post('patta_no'),
                        'patta_type_code' => $this->input->post('patta_type_code'),
                        'year_no' => date('Y'),
                        'date_entry' => date('Y-m-d'),
                        'pdar_id' => $chitha_pdar_id,
                        'pdar_cron_no' => (int)$cron_no++,
                        'pdar_name' => $this->input->post('pdar_name' . $setl->id),
                        'pdar_guardian' => $this->input->post('pdar_guardian' . $setl->id),

                        'pdar_rel_guar' => $this->input->post('pdar_rel_guar' . $setl->id),
                        'pdar_gender' => $this->input->post('pdar_gender' . $setl->id),
                        // //'pdar_add1' => $part->address,
                        'pdar_add1' => $this->input->post('pdar_add1' . $setl->id),
                        'pdar_add2' => $this->input->post('pdar_add2' . $setl->id),
                        'pdar_mobile' => $this->input->post('pdar_mobile' . $setl->id),
                        // 'i_area_b' => $this->input->post('i_area_b'.$setl->id),
                        // 'i_area_k' => $this->input->post('i_area_k'.$setl->id),
                        // 'i_area_lc' => $this->input->post('i_area_lc'.$setl->id),
                        // 'i_area_g' => $this->input->post('i_area_g'.$setl->id),
                        // 'i_area_kr' => $this->input->post('i_area_kr'.$setl->id),
                        'pdar_type' => $this->input->post('pdar_type' . $setl->id),
                        // 'caste' =>$this->input->post('cast_category'),
                        'bpl' => $this->input->post('under_bpl'),
                        'is_applicant' => $this->input->post('is_applicant'),
                    );

                    $insSetApplicant = $this->db->insert('settlement_applicant', $applicant);
                    //    echo $this->db->last_query(); die();

                    if ($insSetApplicant != 1) {
                        // var_dump($insSetApplicant);
                        // echo $this->db->last_query(); die();
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET0003: Insertion failed in settlement_applicant RTPS Case No ' . $application_no . "######" . $this->db->last_query());
                        $data = array(
                            'error' => "#ERRSET0003: Registration of Settlement failed for case no : " . $application_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }

            }


            /// new dynamic applicant add
            if(isset($_POST['pdar_name2'])){
                foreach($_POST['pdar_name2'] as $key =>$value)
                {
                    $applicant2=array(
                        'dist_code'=>$this->input->post('dist_code'),
                        'subdiv_code'=>$this->input->post('subdiv_code'),
                        'cir_code'=>$this->input->post('cir_code'),
                        'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
                        'lot_no'=>$this->input->post('lot_no'),
                        'vill_townprt_code'=>$this->input->post('vill_townprt_code'),
                        'user_code'=>$this->session->userdata('user_code'),
                        'case_no'=>$case_no['case_no'],
                        'petition_no'=>$case_no['petition_no'],
                        'operation'=>'E',
                        'dag_no' =>$this->input->post('dag_no'),
                        'patta_no' =>$this->input->post('patta_no'),
                        'patta_type_code'=>$this->input->post('patta_type_code'),
                        'year_no'=>date('Y'),
                        'date_entry'=>date('Y-m-d'),
                        'pdar_id' =>-1,
                        'pdar_cron_no'=>(int) $cron_no++,
                        'pdar_name' =>$value,
                        'pdar_guardian' =>$_POST['pdar_guardian2'][$key],
                        'pdar_rel_guar' =>$_POST['pdar_rel_guar2'][$key],
                        'pdar_gender'=>$_POST['pdar_gender2'][$key],
                        'pdar_add1' => $_POST['pdar_add12'][$key],
                        'pdar_add2' => $_POST['pdar_add22'][$key],
                        'pdar_mobile' => $_POST['pdar_mobile2'][$key],
                        'pdar_type' => 'B',
                    );

                    $insSetApplicant2 = $this->db->insert('settlement_applicant',$applicant2);
                    // echo $this->db->last_query(); die();

                    if($insSetApplicant2 != 1)
                    {
                        // var_dump($insSetApplicant);
                        // echo $this->db->last_query(); die();
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET00031: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#ERRSET00031: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }

                }
            }


            // fetch encroachers -md- 07-09-2022
            if($output->encroachers == true){
                // foreach($output->encroachers as $encroacher){
                //     $vlb_encroacher = $this->SettlementApModel->getEncroacherDetails($d, $s, $c, $m, $l, $v, $$encroacher->dag_no);
                //     $district['vlb_enc'] = $vlb_encroacher;

                //     if($vlb_encroacher == true){
                //         $vlb_encroacher_in_dag = $this->SettlementApModel->getEncroacherInDag($vlb_encroacher->id);
                //         $district['vlb_enc_details'] = $vlb_encroacher_in_dag;
                //     }else{
                //         $district['empty_err'] = "No Land Bank Details found!!";
                //     }
                // }

                // insert encroachers

                foreach($output->encroachers as $enc_applicant){


                    $encroacher_app=array(
                        'dist_code'=>$this->input->post('dist_code'),
                        'subdiv_code'=>$this->input->post('subdiv_code'),
                        'cir_code'=>$this->input->post('cir_code'),
                        'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
                        'lot_no'=>$this->input->post('lot_no'),
                        'vill_townprt_code'=>$this->input->post('vill_townprt_code'),

                        'user_code'=>$this->session->userdata('user_code'),
                        'case_no'=>$case_no['case_no'],
                        'petition_no'=>$case_no['petition_no'],
                        'operation'=>'E',
                        'dag_no' =>$this->input->post('enc_dag'.$enc_applicant->id),
                        'patta_no' =>$this->input->post('patta_no'.$enc_applicant->id),
                        'patta_type_code'=>$this->input->post('patta_type_code'.$enc_applicant->id),
                        'period_possession'=>$this->input->post('period_possession'.$enc_applicant->id),

                        // 'home_b'=>$this->input->post('mbigha'.$enc_applicant->id),
                        // 'home_k'=>$this->input->post('home_k'.$enc_applicant->id),
                        // 'home_lc'=>$this->input->post('home_lc'.$enc_applicant->id),
                        // 'home_g'=>$this->input->post('home_g'.$enc_applicant->id),
                        // 'home_kr'=>$this->input->post('home_kr'.$enc_applicant->id),

                        // 'agri_b'=>$this->input->post('agri_b'.$enc_applicant->id),
                        // 'agri_k'=>$this->input->post('agri_k'.$enc_applicant->id),
                        // 'agri_lc'=>$this->input->post('agri_lc'.$enc_applicant->id),
                        // 'agri_g'=>$this->input->post('agri_g'.$enc_applicant->id),
                        // 'agri_kr'=>$this->input->post('agri_kr'.$enc_applicant->id),

                        'year_no'=>date('Y'),
                        'date_entry'=>date('Y-m-d'),
                        'pdar_name' => $this->input->post('riotee_name'.$enc_applicant->id),
                        'pdar_guardian' => $this->input->post('riotee_guardian'.$enc_applicant->id),
                        'pdar_rel_guar' => '0',
                        'pdar_cron_no'=> (int) $cron_no++,
                        'pdar_id' => -1,
                        'pdar_type' => 'EN',
                        'enc_id' => $this->input->post('enc_id'.$enc_applicant->id)
                    );
                    $insSetEncroacher = $this->db->insert('settlement_applicant',$encroacher_app);
                    // echo $this->db->last_query();
                    // var_dump($insSetEncroacher); die();

                    if($insSetEncroacher != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET00031: Insertion failed in settlement_applicant RTPS Case No '.$application_no. "######".$this->db->last_query());
                        $data = array(
                            'error'=>"#ERRSET00031: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }

                }
            }

            ////settlement khas LM Report insert start

            ////////////////////file///////////////////////////

            // For uploading dag wise trace_map_copy
            foreach($district['encroachers'] as $dags_doc){
                $timestamp = date('mdYhis', time()).uniqid();

                // Trace Map copy upload
                $config['file_name']            = 'trace_map_copy'.$timestamp;
                $config['upload_path']          = UPLOAD_DIR;
                $config['allowed_types']        = 'pdf|jpg|png';
                $config['max_size']             = 2000;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ( ! $this->upload->do_upload('trace_map_copy'.$dags_doc->id))
                {
                    $error = array('error' => $this->upload->display_errors());
                    echo json_encode($error);
                    return false;
                }
                else
                {
                    $data = array('upload_data' => $this->upload->data());
                    $document= array(
                        'case_no' => $case_no['case_no'],
                        'file_name' => 'Trace Map Copy',
                        'user_code' => $this->session->userdata('user_code'),
                        'fetch_file_name' => $data['upload_data']['orig_name'],
                        'file_type' => $data['upload_data']['file_type'],
                        'file_path' => $config['upload_path'].$data['upload_data']['orig_name'],
                        'date_entry' => date('Y-m-d h:i:s'),
                        'mut_type' => $this->input->post('service_code'),
                        'dag_no' => $this->input->post('dag_no_doc'.$dags_doc->id)
                    );

                    $insert_supportive_doc= $this->db->insert('supportive_document',$document);

                    if($insert_supportive_doc != 1){
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORPPSSGG: Insertion failed in supportive_document for case no :'. $case_no['case_no']);
                        $json = [
                            'errorMessage'=>"#ERRORPPSSGG: Failed to forward the case for Case No : ".$case_no['case_no']
                        ];
                        echo json_encode($json);
                        return false;
                    }
                }
            }

            $timestamp = date('mdYhis', time()).uniqid();
            // For uploading field report
            $config2['file_name']            = 'field_report'.$timestamp;
            $config2['upload_path']          = UPLOAD_DIR;
            $config2['allowed_types']        = 'pdf|jpg|png';
            $config2['max_size']             = 2000;

            $this->upload->initialize($config2);

            if ( ! $this->upload->do_upload('field_report'))
            {
                $error = array('error' => $this->upload->display_errors());

                var_dump($error);
                die;
            }
            else
            {
                $data = array('upload_data' => $this->upload->data());
                $document= array(
                    'case_no' => $case_no['case_no'],
                    'file_name' => 'Field Report',
                    'user_code' => $this->session->userdata('user_code'),
                    'fetch_file_name' => $data['upload_data']['orig_name'],
                    'file_type' => $data['upload_data']['file_type'],
                    'file_path' => $config2['upload_path'].$data['upload_data']['orig_name'],
                    'date_entry' => date('Y-m-d h:i:s'),
                    'mut_type' => $this->input->post('service_code'),
                );

                $insert_supportive_doc= $this->db->insert('supportive_document',$document);

                if($insert_supportive_doc != 1){
                    $this->db->trans_rollback();
                    log_message('error', '#ERRORPPSSGGP: Insertion failed in supportive_document for case no :'. $case_no['case_no']);
                    $json = [
                        'errorMessage'=>"#ERRORPPSSGGP: Failed to forward the case for Case No : ".$case_no['case_no']
                    ];
                    echo json_encode($json);
                    return false;
                }
            }


            $timestamp = date('mdYhis', time()).uniqid();
            // For uploading LR staff report
            $config3['file_name']            = 'lr_remark'.$timestamp;
            $config3['upload_path']          = UPLOAD_DIR;
            $config3['allowed_types']        = 'pdf|jpg|png';
            $config3['max_size']             = 2000;

            $this->upload->initialize($config3);

            if ( ! $this->upload->do_upload('lr_remark'))
            {
                $error = array('error' => $this->upload->display_errors());

                var_dump($error);
                die;
            }
            else
            {
                $data = array('upload_data' => $this->upload->data());
                $document= array(
                    'case_no' => $case_no['case_no'],
                    'file_name' => LR_REPORT,
                    'user_code' => $this->session->userdata('user_code'),
                    'fetch_file_name' => $data['upload_data']['orig_name'],
                    'file_type' => $data['upload_data']['file_type'],
                    'file_path' => $config3['upload_path'].$data['upload_data']['orig_name'],
                    'date_entry' => date('Y-m-d h:i:s'),
                    'mut_type' => $this->input->post('service_code'),
                );

                $insert_supportive_doc= $this->db->insert('supportive_document',$document);

                if($insert_supportive_doc != 1){
                    $this->db->trans_rollback();
                    log_message('error', '#ERRORPPSSGGP: Insertion failed in supportive_document for case no :'. $case_no['case_no']);
                    $json = [
                        'errorMessage'=>"#ERRORPPSSGGP: Failed to forward the case for Case No : ".$case_no['case_no']
                    ];
                    echo json_encode($json);
                    return false;
                }
            }




            // UPDATING Geo Tag Photo case number in supportive document
            if(isset($district['geo_tag_doc'])){
                foreach($district['geo_tag_doc'] as $geo_tag_loop){
                    $geo_tag_array = array(
                        'case_no' => $case_no['case_no']
                    );
                    $this->db->where('applid', $geo_tag_loop->applid);
                    $this->db->where('dag_no', $geo_tag_loop->dag_no);
                    $this->db->where('file_name', GEO_TAG_PHOTO);
                    $this->db->update('supportive_document', $geo_tag_array);

                    if($this->db->affected_rows() == 0 ){
                        $this->db->trans_rollback();
                        log_message('error', '#SETUP0001S: Updation failed in supportive_document basundhara Case No '.$geo_tag_loop->applid);
                        $data = array(
                            'error'=>"#SETUP0001S: Registration of Settlement failed for case no : ".$geo_tag_loop->applid
                        );
                        echo json_encode($data);
                        return false;
                    }
                }
            }

            $comment = addslashes($this->input->post('lm_remark'));
            $r_bigha = $this->input->post('reserved_bigha');
            $r_katha = $this->input->post('reserved_katha');
            $r_lessa = $this->input->post('reserved_lessa');
            $r_ganda = $this->input->post('reserved_ganda');
            $r_kranti = $this->input->post('reserved_kranti');

            $roadside_comment_check=$this->input->post('roadside_comment_check');


            $pro_class_lm = $this->input->post('protected_class_lm');
            $protected_class_lm = ($pro_class_lm==null || $pro_class_lm=='' || $pro_class_lm==0)?0:$this->input->post('protected_class_lm');

            $lmnote=array(
                'user_code'=>$this->session->userdata('user_code'),
                'chitha_verified'=>$this->input->post('chiitha_verified'),
                'vlb_verified'=>$this->input->post('vlb_verified'),
                'possession_verification'=>$this->input->post('possession_verified'),
                'period_possession'=>date('Y-m-d'),
                'nature_possession'=>$this->input->post('nature_possession'),
                'is_landless'=>$this->input->post('is_landless'),
                'land_falls'=>$this->input->post('land_falls'),
                'falls_und_gmc'=>$this->input->post('falls_und_gmc'),
                'roadside_reservation'=>$this->input->post('roadside_reservation'),
                'zonal_valuation'=>$this->input->post('zonal_valuation'),
                // 'trace_map_copy'=>$this->input->post('trace_map_copy'),
                // 'chitha_copy'=>$this->input->post('chitha_copy'),
                'trace_map_copy'=>'NA',
                'chitha_copy'=>'NA',
                'lm_note'=>$comment,
                'lm_remark_text'=>$this->input->post('lm_remark_text'),
                'date_entry'=>date('Y-m-d h:i:s'),
                'case_no'=>$case_no['case_no'],
                'status'=>'W',
                'r_bigha'=>$r_bigha,
                'r_katha'=>$r_katha,
                'r_lessa'=>$r_lessa,
                'r_ganda'=>$r_ganda,
                'r_kranti'=>$r_kranti,
                'total_bigha'=>$this->input->post('total_bigha'),
                'total_Katha'=>$this->input->post('total_Katha'),
                'total_lessa'=>$this->input->post('total_lessa'),
                'total_ganda'=>$this->input->post('total_ganda'),
                'total_kranti'=>$this->input->post('total_kranti'),
                'govt_allotted'=>$this->input->post('govt_allotted'),
                'landed_property'=>$this->input->post('landed_property'),
                'livelihood'=>$this->input->post('livelihood'),
                'suitability'=>$this->input->post('suitability'),
                'admissible_area'=>$this->input->post('admissible_area'),
                'is_st' => $this->input->post('is_st'),
                'is_indigenous' => $this->input->post('is_indigenous'),
                'is_reg_with_teaboard' => $this->input->post('is_reg_with_teaboard'),
                'is_tribal_belt' => $this->input->post('whether_tribal'),
                'protected_class_lm' => $protected_class_lm,
                'erosion' => $this->input->post('erosion'),
                'landslide' => $this->input->post('landslide'),
                'litigation' => $this->input->post('litigation'),
                'bhumiputra_confirmation'   => $this->input->post('bhumiputra_confirmation_lm'),
            );

            $insLmnote = $this->db->insert('settlement_ap_lmnote',$lmnote);

            if($insLmnote != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET0005: Insertion failed in settlement_ap_lmnote RTPS Case No '.$application_no. "######".$this->db->last_query());
                $data = array(
                    'error'=>"#ERRSET0005: Registration of Settlement failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }


            if($roadside_comment_check=='YES')
            {
                foreach($district['encroachers'] as $dags)
                {
                    $reservedarea=array(

                        'dist_code'=>$this->input->post('district_code'),
                        'subdiv_code'=>$this->input->post('sub_div_code'),
                        'cir_code'=>$this->input->post('circle_code'),
                        'mouza_pargona_code'=>$this->input->post('mouza_code'),
                        'lot_no'=>$this->input->post('lot_no'),
                        'vill_townprt_code'=>$this->input->post('select_village'),
                        'dag_no'=>$this->input->post('reserved_dag_road'.$dags->id),
                        'patta_no'=>$this->input->post('reserved_patta_road'.$dags->id),
                        'bigha'=>$this->input->post('reserved_bigha'.$dags->id),
                        'katha'=>$this->input->post('reserved_katha'.$dags->id),
                        'lessa'=>$this->input->post('reserved_lessa'.$dags->id),
                        'ganda'=>$this->input->post('reserved_ganda'.$dags->id),
                        'kranti'=>$this->input->post('reserved_kranti'.$dags->id),
                        'case_no'=>$case_no['case_no'],
                        'applid'=>$this->input->post('applid'),
                        'lm_code'=>$this->session->userdata('user_code'),
                        'date_entry'=>date('Y-m-d h:i:s'),
                        'date_update'=>date('Y-m-d h:i:s'),
                        'type'=>'R'
                    );

                    $reserveData = $this->db->insert('settlement_reservation',$reservedarea);
                    // echo $this->db->last_query(); die();
                    if($reserveData != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET00052: Insertion failed in settlement_reservation RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#ERRSET00052: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }
            }
            //////proceeding start//////
            $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='".$case_no['case_no']."' ")->row()->c;

            if($proceeding_id==null){
                $proceeding_id=1;
            }

            $insPetProceed = [
                'case_no'=>$case_no['case_no'],
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_on_order' => $comment,
                'status' => 'W',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'LM',
                'office_to' => 'CO',
                'task' => 'LM note submitted'
            ];
            $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

            // echo $this->db->last_query(); die();
            if($insertProceeding != 1){
                $this->db->trans_rollback();
                log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no['case_no']);
                $json = [
                    'errorMessage'=>"#ERRORPP: Failed to forward the case for Case No : ".$case_no['case_no']
                ];
                echo json_encode($json);
                return false;
            }
            //////proceeding end//////

            ////settlement Khas LM Report insert end

            if($this->db->trans_status()==FALSE){
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"Error in submitting. Please try Again"
                );
            }else
            {
                $basundhara=array(
                    'dharitree'=>$case_no['case_no'],
                    'basundhara'=>$application_no,
                    'date_reg'=>date('Y-m-d'),
                    'reg_by'=>$this->session->userdata('user_code'),
                    'app_status'=>'M',
                    'pending_with'=>'LM'
                );
                $this->db->insert('basundhar_application',$basundhara);
                //////////////POST To basundhara/////////////////////
                $rmk='Forwarded to CO';
                $status='M';
                $task='LM';
                $pen='CO';
                $case=$case_no['case_no'];
                $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                $rtps_status=json_decode($rtps_status);
                //var_dump($rtps_status);
                if(trim($rtps_status)!="y"){
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRAPP0011: Settlement Application not submitted case no # ".$case_no['case_no']);
                    redirect(base_url() . "index.php/home");
                }else{
                    $this->db->trans_commit();
                }

                //////////////////
                // $this->DashboardInheritance($case_no['case_no']);
                //////
                //////////////////////////////////
                $this->session->set_flashdata('message', "Application Successfully Forwarded to Circle Office With Case No # ".$case_no['case_no']);
                redirect(base_url() . "index.php/home");

                // $data=array(
                //     'success'=>"Settlement Application Registered Successfully with case no $case_no[case_no]",
                //     'redirect_url'=>base_url().'index.php/home'
                // );
            }
            // echo json_encode($data);
        }

    }


    // settlement tribal post
    public function settlementTribalPostNew()
    {

        $application_no=$this->input->post('application_no');
        $recordExist=$this->SettlementApiModel->checkExistDharitree($application_no);
        if($recordExist){
            $data=array(
                'error'=>"Case have been Registered Already. Please Check"
            );
            echo json_encode($data);
            exit;
        }

        /////////////////////
        $url = API_LINK_MB2."getAppDetails?application_no=" . $application_no ;
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

        $district['applicants']=$output->applicants;
        $district['document']=$output->documents;
        $district['query']=$output->query;
        $district['property']=$output->property;
        $district['settlements']=$output->settlements;
        $district['encroachers'] = $output->encroachers;
        $district['owners'] = $output->owners;
        $district['riotee_noks'] = $output->riotee_noks;
        $district['aadhar']=$output->aadhar;
        $district['nextKin'] = $output->nextKin;

        $d=$district['app']->dist_code;
        $s=$district['app']->subdiv_code;
        $c=$district['app']->cir_code;
        $m=$district['app']->mouza_code;
        $l=$district['app']->lot_no;
        $v=$district['app']->village_code;
        $pno=$district['pattaNo']->patta_no;
        $pc=$district['pattaNo']->patta_type_code;
        $dag = $district['app']->dag_no;

        $this->db->trans_begin();

        $case_name=$this->SettlementApiModel->genearteCaseName();
        if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Seesion Out. Please try Again"
            );
            echo json_encode($data);
            exit;
            die();
        }
        $case_no['petition_no']=$petition_no=$this->SettlementApiModel->genearteSettlementPetitionNo();

        $case_no['case_no']=$case_name.$petition_no."/".SETTLEMENT_TRIBAL_COMMUNITY;



        $basic=array(
            'dist_code'=>$this->input->post('dist_code'),
            'subdiv_code'=>$this->input->post('subdiv_code'),
            'cir_code'=>$this->input->post('cir_code'),
            'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
            'lot_no'=>$this->input->post('lot_no'),
            'vill_townprt_code'=>$this->input->post('vill_townprt_code'),
            'service_code'=>$this->input->post('service_code'),
            'ref_no'=>$this->input->post('ref_no'),
            'case_no'=>$case_no['case_no'],
            'trans_code'=>'F',/////////full
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'date_entry' => date('Y-m-d G:i:s'),
            'status'=>'W',
            'user_code'=>$this->session->userdata('user_code'),
            'lm_code' => $this->session->userdata('user_code'),
            'submission_date' => date('Y-m-d G:i:s'),
            'from_office' => 'LM',
            'pending_officer' => 'CO',
            'pending_office' => 'CO',
            'period_possession'=>date('Y-m-d'),
            'occupation_applicant'=>$this->input->post('occupation_applicant'),
            'applid'=>$this->input->post('applid'),
            /////////
        );

        $insSetBasic = $this->db->insert('settlement_basic',$basic);

        if($insSetBasic != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRSET0001: Insertion failed in settlement_basic RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRSET0001: Registration of Settlement failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }

        ////settlement_dag_details insert start
        foreach($district['encroachers'] as $dags){
            $fmd=array(
                'dist_code'=>$this->input->post('dist_code'),
                'subdiv_code'=>$this->input->post('subdiv_code'),
                'cir_code'=>$this->input->post('cir_code'),
                'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
                'lot_no'=>$this->input->post('lot_no'),
                'vill_townprt_code'=>$this->input->post('vill_townprt_code'),
                'user_code'=>$this->session->userdata('user_code'),
                'date_entry'=>date('Y-m-d'),
                'case_no'=>$case_no['case_no'],
                'petition_no'=>$case_no['petition_no'],
                'year_no'=>date('Y'),
                'operation'=>'E',
            );

            $fmd['dag_no']= $this->input->post('dag_no'.$dags->id);
            $fmd['patta_no']=$this->input->post('patta_no'.$dags->id);
            $fmd['patta_type_code']=$this->input->post('patta_type_code'.$dags->id);

            $fmd['dag_area_b']=$this->input->post('dag_area_b'.$dags->id);
            $fmd['dag_area_k']=$this->input->post('dag_area_k'.$dags->id);
            $fmd['dag_area_lc']=$this->input->post('dag_area_lc'.$dags->id);
            $fmd['dag_area_g']=$this->input->post('dag_area_g'.$dags->id);
            $fmd['dag_area_kr']=$this->input->post('dag_area_kr'.$dags->id);


            $fmd['home_b']=$this->input->post('mbigha'.$dags->id);
            $fmd['home_k']=$this->input->post('mkatha'.$dags->id);
            $fmd['home_lc']=$this->input->post('mlessa'.$dags->id);
            $fmd['home_g']=$this->input->post('mganda'.$dags->id);
            $fmd['home_kr']=$this->input->post('mkranti'.$dags->id);

            $fmd['agri_b']=$this->input->post('agri_bigha'.$dags->id);
            $fmd['agri_k']=$this->input->post('agri_katha'.$dags->id);
            $fmd['agri_lc']=$this->input->post('agri_lessa'.$dags->id);
            $fmd['agri_g']=$this->input->post('agri_ganda'.$dags->id);
            $fmd['agri_kr']=$this->input->post('agri_kranti'.$dags->id);

            // $fmd['s_dag_area_b']=$this->input->post('s_dag_area_b');
            // $fmd['s_dag_area_k']=$this->input->post('s_dag_area_k');
            // $fmd['s_dag_area_lc']=$this->input->post('s_dag_area_lc');
            // $fmd['s_dag_area_g']=$this->input->post('s_dag_area_g');
            // $fmd['s_dag_area_kr']=$this->input->post('s_dag_area_kr');
            $fmd['s_dag_area_b']=$fmd['home_b']+$fmd['agri_b'];
            $fmd['s_dag_area_k']=$fmd['home_k']+$fmd['agri_k'];
            $fmd['s_dag_area_lc']=$fmd['home_lc']+$fmd['agri_lc'];
            $fmd['s_dag_area_g']=$fmd['home_g']+$fmd['agri_g'];
            $fmd['s_dag_area_kr']=$fmd['home_kr']+$fmd['agri_kr'];

            $fmd['is_urban']=trim($this->input->post('is_urban'));
            $fmd['revenue']=0;
            $fmd['land_type']= $this->input->post('land_type'.$dags->id);
            $insSetDag = $this->db->insert('settlement_dag_details',$fmd);
            // echo $this->db->last_query($insSetDag);
            // die;

            if($insSetDag != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET0002: Insertion failed in settlement_dag_details RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRSET0002: Registration of Settlement failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
        }
        ////settlement_dag_details insert end

        ////settlement_applicant insert start
        foreach($district['applicants'] as $setl){

            if($this->input->post('pdar_id'.$setl->id)=="" || $this->input->post('pdar_id'.$setl->id)==null || empty($this->input->post('pdar_id'.$setl->id)))
            {
                $chitha_pdar_id=-1;
            }else{
                $chitha_pdar_id=$this->input->post('pdar_id'.$setl->id);
            }

            $applicant=array(
                'dist_code'=>$this->input->post('dist_code'),
                'subdiv_code'=>$this->input->post('subdiv_code'),
                'cir_code'=>$this->input->post('cir_code'),
                'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
                'lot_no'=>$this->input->post('lot_no'),
                'vill_townprt_code'=>$this->input->post('vill_townprt_code'),

                'user_code'=>$this->session->userdata('user_code'),
                'case_no'=>$case_no['case_no'],
                'petition_no'=>$case_no['petition_no'],
                'operation'=>'E',
                'dag_no' =>$this->input->post('dag_no'),
                'patta_no' =>$this->input->post('patta_no'),
                'patta_type_code'=>$this->input->post('patta_type_code'),
                'year_no'=>date('Y'),
                'date_entry'=>date('Y-m-d'),
                'pdar_id' =>$chitha_pdar_id,
                'pdar_cron_no'=>$setl->id,
                'pdar_name' =>$this->input->post('pdar_name'.$setl->id),
                'pdar_guardian' =>$this->input->post('pdar_guardian'.$setl->id),

                'pdar_rel_guar' =>$this->input->post('pdar_rel_guar'.$setl->id),
                'pdar_gender'=>$this->input->post('pdar_gender'.$setl->id),
                // //'pdar_add1' => $part->address,
                'pdar_add1' => $this->input->post('pdar_add1'.$setl->id),
                'pdar_add2' => $this->input->post('pdar_add2'.$setl->id),
                'pdar_mobile' => $this->input->post('pdar_mobile'.$setl->id),
                // 'i_area_b' => $this->input->post('i_area_b'.$setl->id),
                // 'i_area_k' => $this->input->post('i_area_k'.$setl->id),
                // 'i_area_lc' => $this->input->post('i_area_lc'.$setl->id),
                // 'i_area_g' => $this->input->post('i_area_g'.$setl->id),
                // 'i_area_kr' => $this->input->post('i_area_kr'.$setl->id),
                'pdar_type' => $this->input->post('pdar_type'.$setl->id),
            );

            $insSetApplicant = $this->db->insert('settlement_applicant',$applicant);
            // echo $this->db->last_query(); die();

            if($insSetApplicant != 1)
            {
                // var_dump($insSetApplicant);
                // echo $this->db->last_query(); die();
                $this->db->trans_rollback();
                log_message('error', '#ERRSET0003: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRSET0003: Registration of Settlement failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }

        }


        $petition_no = $case_no['petition_no'];
        $case_no = $case_no['case_no'];

        // insertion of encroacher/riotee -md- 06-09-2022
        // fetch encroachers -md- 07-09-2022
        if($output->encroachers == true){
            // foreach($output->encroachers as $encroacher){
            //     $vlb_encroacher = $this->SettlementApModel->getEncroacherDetails($d, $s, $c, $m, $l, $v, $$encroacher->dag_no);
            //     $district['vlb_enc'] = $vlb_encroacher;

            //     if($vlb_encroacher == true){
            //         $vlb_encroacher_in_dag = $this->SettlementApModel->getEncroacherInDag($vlb_encroacher->id);
            //         $district['vlb_enc_details'] = $vlb_encroacher_in_dag;
            //     }else{
            //         $district['empty_err'] = "No Land Bank Details found!!";
            //     }
            // }

            // insert encroachers
            foreach($output->encroachers as $enc_applicant){
                $sql = "SELECT pdar_cron_no FROM 
                            settlement_applicant
                                WHERE
                                    case_no = '$case_no'";
                $result = $this->db->query($sql)->row();


                $cron_no = (int)$result->pdar_cron_no + 1;

                $encroacher_app=array(
                    'dist_code'=>$this->input->post('dist_code'),
                    'subdiv_code'=>$this->input->post('subdiv_code'),
                    'cir_code'=>$this->input->post('cir_code'),
                    'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
                    'lot_no'=>$this->input->post('lot_no'),
                    'vill_townprt_code'=>$this->input->post('vill_townprt_code'),

                    'user_code'=>$this->session->userdata('user_code'),
                    'case_no'=> $case_no,
                    'petition_no'=>$petition_no,
                    'operation'=>'E',
                    'dag_no' =>$this->input->post('enc_dag'.$enc_applicant->id),
                    'patta_no' =>$this->input->post('patta_no'.$enc_applicant->id),
                    'patta_type_code'=>$this->input->post('patta_type_code'.$enc_applicant->id),
                    'period_possession'=>date('Y-m-d', strtotime($this->input->post('period_possession'.$enc_applicant->id))),

                    // 'home_b'=>$this->input->post('mbigha'.$enc_applicant->id),
                    // 'home_k'=>$this->input->post('home_k'.$enc_applicant->id),
                    // 'home_lc'=>$this->input->post('home_lc'.$enc_applicant->id),
                    // 'home_g'=>$this->input->post('home_g'.$enc_applicant->id),
                    // 'home_kr'=>$this->input->post('home_kr'.$enc_applicant->id),

                    // 'agri_b'=>$this->input->post('agri_b'.$enc_applicant->id),
                    // 'agri_k'=>$this->input->post('agri_k'.$enc_applicant->id),
                    // 'agri_lc'=>$this->input->post('agri_lc'.$enc_applicant->id),
                    // 'agri_g'=>$this->input->post('agri_g'.$enc_applicant->id),
                    // 'agri_kr'=>$this->input->post('agri_kr'.$enc_applicant->id),

                    'year_no'=>date('Y'),
                    'date_entry'=>date('Y-m-d'),
                    'pdar_name' => $this->input->post('riotee_name'.$enc_applicant->id),
                    'pdar_guardian' => $this->input->post('riotee_guardian'.$enc_applicant->id),
                    'pdar_rel_guar' => '0',
                    'pdar_cron_no'=> (string) $cron_no,
                    'pdar_id' => -1,
                    'pdar_type' => 'EN',
                    'enc_id' => $this->input->post('enc_id'.$enc_applicant->id)
                );
                $insSetEncroacher = $this->db->insert('settlement_applicant',$encroacher_app);

                // var_dump($insSetEncroacher); die();
                // echo $this->db->last_query();
                // if($insSetEncroacher == true){
                //     echo "true";
                // }else{
                //     echo "false";
                // }
                // die;

                // var_dump($insSetEncroacher);
                // die;

                if($insSetEncroacher != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET000334: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRSET000334: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }

            }
        }

        ////settlement khas LM Report insert start

        ////////////////////file///////////////////////////
        header('content-type:application/json');
        $documents_config = json_decode(SETTLEMENT_KHAS_FILES);
        $validations=[];
        $document_details=[];
        log_message("error","------------FILE validation STARTED------------- ");
        foreach($documents_config as $key=>$value){
            $return= $this->SettlementApiModel->fileManualValidation($value);

            if(!is_null($return)){
                $return['status']==1 ? $validations[]= $return['validation']: $document_details[]= $return['data'];
            }
        }
        log_message("error","------------FILE validation ENDED--------------- ");
        if(!empty($validations)){
            echo json_encode(array(
                'responseType' => 1,
                'validation' => $validations
            ));
            return;
        }
        // NOW STORE THE FILE
        // $application_id = $_POST['application_id'];
        $documents=[];
        log_message("error","------------FILE SAVE STARTED------------- ");
        foreach($document_details as $value){
            log_message("error","doc data".json_encode($value));
            // $file_new_name= RTPS_CODE.'_'.$application_id . '_'.SETTLEMENT_AP_TRANSFER_ID.'_'.$value['file_name'].'.'.$value['extension'];
            $file_new_name= $value['file_name'].'.'.$value['extension'];
            $app_doc = $this->db->select('id')->from('supportive_document')->where(
                array('case_no'=>$case_no,'file_name'=>$value['file_details'])
            )->get()->row();

            log_message("error","doc data".json_encode(empty($app_doc)));
            $document= array(
                'case_no' => $case_no,
                'file_name' => $value['file_details'],
                'user_code' => $this->session->userdata('user_code'),
                'fetch_file_name' => $file_new_name,
                'file_type' => $value['content_type'],
                'file_path' => UPLOAD_DIR.$file_new_name,
                'date_entry' => date('Y-m-d h:i:s'),
                'mut_type' => $this->input->post('service_code'),
            );
            // var_dump($document); die();
            if(empty($app_doc)){
                $status= $this->db->insert('supportive_document',$document);
                log_message("error","insert doc status:".json_encode($status));
                log_message("error","last query".json_encode($this->db->last_query()));
            }
            //else{
            //     log_message("error","update doc");
            //     $this->db->where('id',$app_doc->id)->update('supportive_document',$document);
            //     log_message("error","last query".json_encode($this->db->last_query()));
            // }
            log_message("error","doc data".json_encode($document));
            move_uploaded_file($_FILES[$value['file_name']]['tmp_name'], UPLOAD_DIR.$file_new_name);
        }
        if ($this->db->trans_status() === FALSE) {
            log_message("error","------------FILE SAVE ENDED WITH ERROR------------- ");
            $this->db->trans_rollback();
            echo json_encode(array(
                'responseType' => 3,
                'error' => 'Something Went wrong!!!'
            ));
            return;
        } else {
            log_message("error","------------FILE SAVE END------------- ");
            // echo json_encode(array(
            //     'responseType' => 2
            //     // 'application_id' => $application_id
            // ));
        }

        ///////////////////////////////////////////////

        $comment = addslashes($this->input->post('lm_remark'));
        $r_bigha = $this->input->post('reserved_bigha');
        $r_katha = $this->input->post('reserved_katha');
        $r_lessa = $this->input->post('reserved_lessa');
        $r_ganda = $this->input->post('reserved_ganda');
        $r_kranti = $this->input->post('reserved_kranti');

        $lmnote=array(
            'user_code'=>$this->session->userdata('user_code'),
            'chitha_verified'=>$this->input->post('chiitha_verified'),
            'vlb_verified'=>$this->input->post('vlb_verified'),
            'possession_verification'=>$this->input->post('possession_verified'),
            'period_possession'=>date('Y-m-d'),
            'land_falls'=>$this->input->post('land_falls'),
            'falls_und_gmc'=>$this->input->post('falls_und_gmc'),
            'roadside_reservation'=>$this->input->post('roadside_reservation'),


            'landed_property' =>$this->input->post('landed_property'),
            'is_st' => $this->input->post('whether_st'),
            'is_tribal_belt' => $this->input->post('whether_tribal'),
            'is_free_encroachment' => $this->input->post('is_free_encroachment'),

            // 'trace_map_copy'=>$this->input->post('trace_map_copy'),
            // 'chitha_copy'=>$this->input->post('chitha_copy'),
            'trace_map_copy'=>'NA',
            'chitha_copy'=>'NA',
            'lm_note'=>$comment,
            'date_entry'=>date('Y-m-d h:i:s'),
            'case_no'=>$case_no,
            'status'=>'W',
            'r_bigha'=>$r_bigha,
            'r_katha'=>$r_katha,
            'r_lessa'=>$r_lessa,
            'r_ganda'=>$r_ganda,
            'r_kranti'=>$r_kranti,
            // 'total_bigha'=>$this->input->post('total_bigha'),
            // 'total_Katha'=>$this->input->post('total_Katha'),
            // 'total_lessa'=>$this->input->post('total_lessa'),
            // 'total_ganda'=>$this->input->post('total_ganda'),
            // 'total_kranti'=>$this->input->post('total_kranti'),
        );

        // echo "<pre>";
        // var_dump($lmnote);
        // die;

        $insLmnote = $this->db->insert('settlement_ap_lmnote',$lmnote);
        // echo $this->db->last_query();
        // if($insLmnote == true){
        //     echo "true";
        // }else{
        //     echo "false";
        // }
        // die;


        if($insLmnote != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRSET0005: Insertion failed in settlement_ap_lmnote RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRSET0005: Registration of Settlement failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }
        //////proceeding start//////
        $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

        if($proceeding_id==null){
            $proceeding_id=1;
        }

        $insPetProceed = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'note_on_order' => $comment,
            'status' => 'W',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d h:i:s'),
            'operation' => 'E',
            'ip' => $this->utilityclass->get_client_ip(),
            'office_from' => 'LM',
            'office_to' => 'CO',
            'task' => 'LM note submitted'
        ];
        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

        // echo $this->db->last_query(); die();
        if($insertProceeding != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
            $json = [
                'errorMessage'=>"#ERRORPP: Failed to forward the case for Case No : ".$case_no
            ];
            echo json_encode($json);
            return false;
        }
        //////proceeding end//////

        ////settlement Khas LM Report insert end

        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            $data=array(
                'error'=>"Error in submitting. Please try Again"
            );
        }else
        {
            $basundhara=array(
                'dharitree'=>$case_no,
                'basundhara'=>$application_no,
                'date_reg'=>date('Y-m-d'),
                'reg_by'=>$this->session->userdata('user_code'),
                'app_status'=>'M',
                'pending_with'=>'LM'
            );
            $this->db->insert('basundhar_application',$basundhara);
            //////////////POST To basundhara/////////////////////
            $rmk='Forwarded to CO';
            $status='W';
            $task='LM';
            $pen='CO';
            $case=$case_no;
            $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
            $rtps_status=json_decode($rtps_status);
            //var_dump($rtps_status);
            if(trim($rtps_status)!="y"){
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error #ERRAPP0011: Settlement Application not submitted case no # $case_no");
                redirect(base_url() . "index.php/home");
            }else{
                $this->db->trans_commit();
            }

            //////////////////
            // $this->DashboardInheritance($case_no['case_no']);
            //////
            //////////////////////////////////
            $this->session->set_flashdata('message', "Settlement Application Registered Successfully with case no # $case_no");
            redirect(base_url() . "index.php/home");

            // $data=array(
            //     'success'=>"Settlement Application Registered Successfully with case no $case_no[case_no]",
            //     'redirect_url'=>base_url().'index.php/home'
            // );
        }

    }


    // settlement vgr post new
    function settlementVgrPost(){

        $application_no=$this->input->post('application_no');
        $recordExist=$this->SettlementApiModel->checkExistDharitree($application_no);
        if($recordExist){
            $data=array(
                'error'=>"Case have been Registered Already. Please Check"
            );
            echo json_encode($data);
            exit;
        }

        /////////////////////
        $url = API_LINK_MB2."getAppDetails?application_no=" . $application_no ;
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

        $district['applicants']=$output->applicants;
        $district['document']=$output->documents;
        $district['query']=$output->query;
        $district['property']=$output->property;
        $district['settlements']=$output->settlements;
        $district['encroachers'] = $output->encroachers;
        $district['owners'] = $output->owners;
        $district['riotee_noks'] = $output->riotee_noks;
        $district['aadhar']=$output->aadhar;
        $district['nextKin'] = $output->nextKin;

        $d=$district['app']->dist_code;
        $s=$district['app']->subdiv_code;
        $c=$district['app']->cir_code;
        $m=$district['app']->mouza_code;
        $l=$district['app']->lot_no;
        $v=$district['app']->village_code;
        $pno=$district['pattaNo']->patta_no;
        $pc=$district['pattaNo']->patta_type_code;
        $dag = $district['app']->dag_no;

        $this->db->trans_begin();

        $case_name=$this->SettlementApiModel->genearteCaseName();
        if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Seesion Out. Please try Again"
            );
            echo json_encode($data);
            exit;
            die();
        }
        $case_no['petition_no']=$petition_no=$this->SettlementApiModel->genearteSettlementPetitionNo();

        $case_no['case_no']=$case_name.$petition_no."/".SETTLEMENT_PGR_VGR_LAND;


        $basic=array(
            'dist_code'=>$this->input->post('dist_code'),
            'subdiv_code'=>$this->input->post('subdiv_code'),
            'cir_code'=>$this->input->post('cir_code'),
            'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
            'lot_no'=>$this->input->post('lot_no'),
            'vill_townprt_code'=>$this->input->post('vill_townprt_code'),
            'service_code'=>$this->input->post('service_code'),
            'ref_no'=>$this->input->post('ref_no'),
            'case_no'=>$case_no['case_no'],
            'trans_code'=>'F',/////////full
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'date_entry' => date('Y-m-d G:i:s'),
            'status'=>'W',
            'user_code'=>$this->session->userdata('user_code'),
            'lm_code' => $this->session->userdata('user_code'),
            'submission_date' => date('Y-m-d G:i:s'),
            'from_office' => 'LM',
            'pending_officer' => 'CO',
            'pending_office' => 'CO',
            'period_possession'=>date('Y-m-d'),
            'occupation_applicant'=>$this->input->post('occupation_applicant'),
            'applid'=>$this->input->post('applid'),
            /////////
        );

        $insSetBasic = $this->db->insert('settlement_basic',$basic);

        if($insSetBasic != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRSET0001: Insertion failed in settlement_basic RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRSET0001: Registration of Settlement failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }

        ////settlement_dag_details insert start
        foreach($district['encroachers'] as $dags){
            $fmd=array(
                'dist_code'=>$this->input->post('dist_code'),
                'subdiv_code'=>$this->input->post('subdiv_code'),
                'cir_code'=>$this->input->post('cir_code'),
                'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
                'lot_no'=>$this->input->post('lot_no'),
                'vill_townprt_code'=>$this->input->post('vill_townprt_code'),
                'user_code'=>$this->session->userdata('user_code'),
                'date_entry'=>date('Y-m-d'),
                'case_no'=>$case_no['case_no'],
                'petition_no'=>$case_no['petition_no'],
                'year_no'=>date('Y'),
                'operation'=>'E',
            );

            $fmd['dag_no']= $this->input->post('dag_no'.$dags->id);
            $fmd['patta_no']=$this->input->post('patta_no'.$dags->id);
            $fmd['patta_type_code']=$this->input->post('patta_type_code'.$dags->id);

            $fmd['dag_area_b']=$this->input->post('dag_area_b'.$dags->id);
            $fmd['dag_area_k']=$this->input->post('dag_area_k'.$dags->id);
            $fmd['dag_area_lc']=$this->input->post('dag_area_lc'.$dags->id);
            $fmd['dag_area_g']=$this->input->post('dag_area_g'.$dags->id);
            $fmd['dag_area_kr']=$this->input->post('dag_area_kr'.$dags->id);


            $fmd['home_b']=$this->input->post('mbigha'.$dags->id);
            $fmd['home_k']=$this->input->post('mkatha'.$dags->id);
            $fmd['home_lc']=$this->input->post('mlessa'.$dags->id);
            $fmd['home_g']=$this->input->post('mganda'.$dags->id);
            $fmd['home_kr']=$this->input->post('mkranti'.$dags->id);

            $fmd['agri_b']=$this->input->post('agri_bigha'.$dags->id);
            $fmd['agri_k']=$this->input->post('agri_katha'.$dags->id);
            $fmd['agri_lc']=$this->input->post('agri_lessa'.$dags->id);
            $fmd['agri_g']=$this->input->post('agri_ganda'.$dags->id);
            $fmd['agri_kr']=$this->input->post('agri_kranti'.$dags->id);

            // $fmd['s_dag_area_b']=$this->input->post('s_dag_area_b');
            // $fmd['s_dag_area_k']=$this->input->post('s_dag_area_k');
            // $fmd['s_dag_area_lc']=$this->input->post('s_dag_area_lc');
            // $fmd['s_dag_area_g']=$this->input->post('s_dag_area_g');
            // $fmd['s_dag_area_kr']=$this->input->post('s_dag_area_kr');
            $fmd['s_dag_area_b']=$fmd['home_b']+$fmd['agri_b'];
            $fmd['s_dag_area_k']=$fmd['home_k']+$fmd['agri_k'];
            $fmd['s_dag_area_lc']=$fmd['home_lc']+$fmd['agri_lc'];
            $fmd['s_dag_area_g']=$fmd['home_g']+$fmd['agri_g'];
            $fmd['s_dag_area_kr']=$fmd['home_kr']+$fmd['agri_kr'];

            $fmd['is_urban']=trim($this->input->post('is_urban'));
            $fmd['revenue']=0;
            $fmd['land_type']= $this->input->post('land_type'.$dags->id);
            $insSetDag = $this->db->insert('settlement_dag_details',$fmd);


            if($insSetDag != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRSET0002: Insertion failed in settlement_dag_details RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRSET0002: Registration of Settlement failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }
        }
        ////settlement_dag_details insert end

        ////settlement_applicant insert start
        foreach($district['applicants'] as $setl){

            if($this->input->post('pdar_id'.$setl->id)=="" || $this->input->post('pdar_id'.$setl->id)==null || empty($this->input->post('pdar_id'.$setl->id)))
            {
                $chitha_pdar_id=-1;
            }else{
                $chitha_pdar_id=$this->input->post('pdar_id'.$setl->id);
            }

            $c_n = $case_no['case_no'];
            $sql = "SELECT pdar_cron_no FROM
                        settlement_applicant
                            WHERE
                                case_no = '$c_n'";
            $result = $this->db->query($sql)->row();
            if($result == true){
                $cron_no = (int)$result->pdar_cron_no + 1;
            }else{
                $cron_no = 1;
            }

            $applicant=array(
                'dist_code'=>$this->input->post('dist_code'),
                'subdiv_code'=>$this->input->post('subdiv_code'),
                'cir_code'=>$this->input->post('cir_code'),
                'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
                'lot_no'=>$this->input->post('lot_no'),
                'vill_townprt_code'=>$this->input->post('vill_townprt_code'),

                'user_code'=>$this->session->userdata('user_code'),
                'case_no'=>$case_no['case_no'],
                'petition_no'=>$case_no['petition_no'],
                'operation'=>'E',
                'dag_no' =>$this->input->post('dag_no'),
                'patta_no' =>$this->input->post('patta_no'),
                'patta_type_code'=>$this->input->post('patta_type_code'),
                'year_no'=>date('Y'),
                'date_entry'=>date('Y-m-d'),
                'pdar_id' =>$chitha_pdar_id,
                'pdar_cron_no'=>(string) $cron_no++,
                'pdar_name' =>$this->input->post('pdar_name'.$setl->id),
                'pdar_guardian' =>$this->input->post('pdar_guardian'.$setl->id),

                'pdar_rel_guar' =>$this->input->post('pdar_rel_guar'.$setl->id),
                'pdar_gender'=>$this->input->post('pdar_gender'.$setl->id),
                // //'pdar_add1' => $part->address,
                'pdar_add1' => $this->input->post('pdar_add1'.$setl->id),
                'pdar_add2' => $this->input->post('pdar_add2'.$setl->id),
                'pdar_mobile' => $this->input->post('pdar_mobile'.$setl->id),
                // 'i_area_b' => $this->input->post('i_area_b'.$setl->id),
                // 'i_area_k' => $this->input->post('i_area_k'.$setl->id),
                // 'i_area_lc' => $this->input->post('i_area_lc'.$setl->id),
                // 'i_area_g' => $this->input->post('i_area_g'.$setl->id),
                // 'i_area_kr' => $this->input->post('i_area_kr'.$setl->id),
                'pdar_type' => $this->input->post('pdar_type'.$setl->id),
            );

            $insSetApplicant = $this->db->insert('settlement_applicant',$applicant);
            // echo $this->db->last_query(); die();

            if($insSetApplicant != 1)
            {
                // var_dump($insSetApplicant);
                // echo $this->db->last_query(); die();
                $this->db->trans_rollback();
                log_message('error', '#ERRSET0003: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRSET0003: Registration of Settlement failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }

        }


        $petition_no = $case_no['petition_no'];
        $case_no = $case_no['case_no'];

        // insertion of encroacher/riotee -md- 06-09-2022
        // fetch encroachers -md- 07-09-2022
        if($output->encroachers == true){
            // foreach($output->encroachers as $encroacher){
            //     $vlb_encroacher = $this->SettlementApModel->getEncroacherDetails($d, $s, $c, $m, $l, $v, $$encroacher->dag_no);
            //     $district['vlb_enc'] = $vlb_encroacher;

            //     if($vlb_encroacher == true){
            //         $vlb_encroacher_in_dag = $this->SettlementApModel->getEncroacherInDag($vlb_encroacher->id);
            //         $district['vlb_enc_details'] = $vlb_encroacher_in_dag;
            //     }else{
            //         $district['empty_err'] = "No Land Bank Details found!!";
            //     }
            // }

            // insert encroachers
            foreach($output->encroachers as $enc_applicant){
                // $sql = "SELECT pdar_cron_no FROM
                //                 settlement_applicant
                //                     WHERE
                //                         case_no = '$case_no'";
                // $result = $this->db->query($sql)->row();


                // $cron_no = (int)$result->pdar_cron_no + 1;

                $encroacher_app=array(
                    'dist_code'=>$this->input->post('dist_code'),
                    'subdiv_code'=>$this->input->post('subdiv_code'),
                    'cir_code'=>$this->input->post('cir_code'),
                    'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
                    'lot_no'=>$this->input->post('lot_no'),
                    'vill_townprt_code'=>$this->input->post('vill_townprt_code'),

                    'user_code'=>$this->session->userdata('user_code'),
                    'case_no'=> $case_no,
                    'petition_no'=>$petition_no,
                    'operation'=>'E',
                    'dag_no' =>$this->input->post('enc_dag'.$enc_applicant->id),
                    'patta_no' =>$this->input->post('patta_no'.$enc_applicant->id),
                    'patta_type_code'=>$this->input->post('patta_type_code'.$enc_applicant->id),
                    'period_possession'=>$this->input->post('period_possession'.$enc_applicant->id),

                    // 'home_b'=>$this->input->post('mbigha'.$enc_applicant->id),
                    // 'home_k'=>$this->input->post('home_k'.$enc_applicant->id),
                    // 'home_lc'=>$this->input->post('home_lc'.$enc_applicant->id),
                    // 'home_g'=>$this->input->post('home_g'.$enc_applicant->id),
                    // 'home_kr'=>$this->input->post('home_kr'.$enc_applicant->id),

                    // 'agri_b'=>$this->input->post('agri_b'.$enc_applicant->id),
                    // 'agri_k'=>$this->input->post('agri_k'.$enc_applicant->id),
                    // 'agri_lc'=>$this->input->post('agri_lc'.$enc_applicant->id),
                    // 'agri_g'=>$this->input->post('agri_g'.$enc_applicant->id),
                    // 'agri_kr'=>$this->input->post('agri_kr'.$enc_applicant->id),

                    'year_no'=>date('Y'),
                    'date_entry'=>date('Y-m-d'),
                    'pdar_name' => $this->input->post('riotee_name'.$enc_applicant->id),
                    'pdar_guardian' => $this->input->post('riotee_guardian'.$enc_applicant->id),
                    'pdar_rel_guar' => '0',
                    'pdar_cron_no'=> (string) $cron_no++,
                    'pdar_id' => -1,
                    'pdar_type' => 'EN',
                    'enc_id' => $this->input->post('enc_id'.$enc_applicant->id)
                );
                $insSetEncroacher = $this->db->insert('settlement_applicant',$encroacher_app);
                // echo $this->db->last_query();
                // var_dump($insSetEncroacher); die();

                if($insSetEncroacher != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET0003: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRSET0003: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }

            }
        }

        ////settlement vgr LM Report insert start

        ////////////////////file///////////////////////////
        header('content-type:application/json');
        $documents_config = json_decode(SETTLEMENT_KHAS_FILES);
        $validations=[];
        $document_details=[];
        log_message("error","------------FILE validation STARTED------------- ");
        foreach($documents_config as $key=>$value){
            $return= $this->SettlementApiModel->fileManualValidation($value);

            if(!is_null($return)){
                $return['status']==1 ? $validations[]= $return['validation']: $document_details[]= $return['data'];
            }
        }
        log_message("error","------------FILE validation ENDED--------------- ");
        if(!empty($validations)){
            echo json_encode(array(
                'responseType' => 1,
                'validation' => $validations
            ));
            return;
        }
        // NOW STORE THE FILE
        // $application_id = $_POST['application_id'];
        $documents=[];
        log_message("error","------------FILE SAVE STARTED------------- ");
        foreach($document_details as $value){
            log_message("error","doc data".json_encode($value));
            // $file_new_name= RTPS_CODE.'_'.$application_id . '_'.SETTLEMENT_AP_TRANSFER_ID.'_'.$value['file_name'].'.'.$value['extension'];
            $file_new_name= $value['file_name'].'.'.$value['extension'];
            $app_doc = $this->db->select('id')->from('supportive_document')->where(
                array('case_no'=>$case_no,'file_name'=>$value['file_details'])
            )->get()->row();

            log_message("error","doc data".json_encode(empty($app_doc)));
            $document= array(
                'case_no' => $case_no,
                'file_name' => $value['file_details'],
                'user_code' => $this->session->userdata('user_code'),
                'fetch_file_name' => $file_new_name,
                'file_type' => $value['content_type'],
                'file_path' => UPLOAD_DIR.$file_new_name,
                'date_entry' => date('Y-m-d h:i:s'),
                'mut_type' => $this->input->post('service_code'),
            );
            // var_dump($document); die();
            if(empty($app_doc)){
                $status= $this->db->insert('supportive_document',$document);
                log_message("error","insert doc status:".json_encode($status));
                log_message("error","last query".json_encode($this->db->last_query()));
            }
            //else{
            //     log_message("error","update doc");
            //     $this->db->where('id',$app_doc->id)->update('supportive_document',$document);
            //     log_message("error","last query".json_encode($this->db->last_query()));
            // }
            log_message("error","doc data".json_encode($document));
            move_uploaded_file($_FILES[$value['file_name']]['tmp_name'], UPLOAD_DIR.$file_new_name);
        }
        if ($this->db->trans_status() === FALSE) {
            log_message("error","------------FILE SAVE ENDED WITH ERROR------------- ");
            $this->db->trans_rollback();
            echo json_encode(array(
                'responseType' => 3,
                'error' => 'Something Went wrong!!!'
            ));
            return;
        } else {
            log_message("error","------------FILE SAVE END------------- ");
            // echo json_encode(array(
            //     'responseType' => 2
            //     // 'application_id' => $application_id
            // ));
        }

        ///////////////////////////////////////////////

        $comment = addslashes($this->input->post('lm_remark'));
        $r_bigha = $this->input->post('reserved_bigha');
        $r_katha = $this->input->post('reserved_katha');
        $r_lessa = $this->input->post('reserved_lessa');
        $r_ganda = $this->input->post('reserved_ganda');
        $r_kranti = $this->input->post('reserved_kranti');

        $lmnote=array(
            'user_code'=>$this->session->userdata('user_code'),
            'chitha_verified'=>$this->input->post('chiitha_verified'),
            'vlb_verified'=>$this->input->post('vlb_verified'),
            // 'possession_verification'=>$this->input->post('possession_verified'),
            'period_possession'=>date('Y-m-d'),
            'nature_possession'=>$this->input->post('nature_possession'),
            'is_landless'=>$this->input->post('is_landless'),
            'land_falls'=>$this->input->post('land_falls'),
            'falls_und_gmc'=>$this->input->post('falls_und_gmc'),
            'roadside_reservation'=>$this->input->post('roadside_reservation'),
            'zonal_valuation'=>$this->input->post('zonal_valuation'),
            // 'trace_map_copy'=>$this->input->post('trace_map_copy'),
            // 'chitha_copy'=>$this->input->post('chitha_copy'),
            'trace_map_copy'=>'NA',
            'chitha_copy'=>'NA',
            'lm_note'=>$comment,
            'date_entry'=>date('Y-m-d h:i:s'),
            'case_no'=>$case_no,
            'status'=>'W',
            'r_bigha'=>$r_bigha,
            'r_katha'=>$r_katha,
            'r_lessa'=>$r_lessa,
            'r_ganda'=>$r_ganda,
            'r_kranti'=>$r_kranti
        );

        $insLmnote = $this->db->insert('settlement_ap_lmnote',$lmnote);
        if($insLmnote != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRSET0005: Insertion failed in settlement_ap_lmnote RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRSET0005: Registration of Settlement failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }

        ///// vgr reserve area start /////

        $reserve=array(

            'dist_code'=>$this->input->post('district_code'),
            'subdiv_code'=>$this->input->post('sub_div_code'),
            'cir_code'=>$this->input->post('circle_code'),
            'mouza_pargona_code'=>$this->input->post('mouza_code'),
            'lot_no'=>$this->input->post('lot_no'),
            'vill_townprt_code'=>$this->input->post('select_village'),
            'dag_no'=>$this->input->post('dag_no'),
            'patta_type_code'=>$this->input->post('patta_code_dropdown'),
            'patta_no'=>$this->input->post('patta_no_dropdown'),
            'bigha'=>$this->input->post('bigha_dropdown'),
            'katha'=>$this->input->post('katha_dropdown'),
            'lessa'=>$this->input->post('lessa_dropdown'),
            'ganda'=>$this->input->post('ganda_dropdown'),
            'kranti'=>$this->input->post('kranti_dropdown'),
            'case_no'=>$case_no,
            'applid'=>$this->input->post('applid'),
            'lm_code'=>$this->session->userdata('user_code'),
            'date_entry'=>date('Y-m-d h:i:s'),
            'date_update'=>date('Y-m-d h:i:s'),
            'type'=>'V'
        );

        $reservePost = $this->db->insert('settlement_reservation',$reserve);
        // echo $this->db->last_query(); die();
        if($reservePost != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRSET00051: Insertion failed in settlement_reservation RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRSET00051: Registration of Settlement failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }

        ///// vgr reserve area end //////

        ///// road side reserve area start /////
        $roadside_comment_check=$this->input->post('roadside_comment_check');
        if($roadside_comment_check=='YES')
        {
            foreach($district['encroachers'] as $dags){
                $reservedarea=array(

                    'dist_code'=>$this->input->post('district_code'),
                    'subdiv_code'=>$this->input->post('sub_div_code'),
                    'cir_code'=>$this->input->post('circle_code'),
                    'mouza_pargona_code'=>$this->input->post('mouza_code'),
                    'lot_no'=>$this->input->post('lot_no'),
                    'vill_townprt_code'=>$this->input->post('select_village'),
                    'dag_no'=>$this->input->post('reserved_dag_road'.$dags->id),
                    'patta_no'=>$this->input->post('reserved_patta_road'.$dags->id),
                    'bigha'=>$this->input->post('reserved_bigha'.$dags->id),
                    'katha'=>$this->input->post('reserved_katha'.$dags->id),
                    'lessa'=>$this->input->post('reserved_lessa'.$dags->id),
                    'ganda'=>$this->input->post('reserved_ganda'.$dags->id),
                    'kranti'=>$this->input->post('reserved_kranti'.$dags->id),
                    'case_no'=>$case_no,
                    'applid'=>$this->input->post('applid'),
                    'lm_code'=>$this->session->userdata('user_code'),
                    'date_entry'=>date('Y-m-d h:i:s'),
                    'date_update'=>date('Y-m-d h:i:s'),
                    'type'=>'R'
                );

                $reserveData = $this->db->insert('settlement_reservation',$reservedarea);
                // echo $this->db->last_query(); die();
                if($reserveData != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET00052: Insertion failed in settlement_reservation RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRSET00052: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
            }
        }

        ///// road reserve area end //////

        ///// family reserve area start /////
        $family_comment_check=$this->input->post('family_comment_check');
        if($family_comment_check=='YES')
        {
            foreach($district['encroachers'] as $dags){
                $reservedarea=array(

                    'dist_code'=>$this->input->post('district_code'),
                    'subdiv_code'=>$this->input->post('sub_div_code'),
                    'cir_code'=>$this->input->post('circle_code'),
                    'mouza_pargona_code'=>$this->input->post('mouza_code'),
                    'lot_no'=>$this->input->post('lot_no'),
                    'vill_townprt_code'=>$this->input->post('select_village'),
                    'dag_no'=>$this->input->post('reserved_dag_family'.$dags->id),
                    'patta_no'=>$this->input->post('reserved_patta_family'.$dags->id),
                    'bigha'=>$this->input->post('reserved_bigha_family'.$dags->id),
                    'katha'=>$this->input->post('reserved_katha_family'.$dags->id),
                    'lessa'=>$this->input->post('reserved_lessa_family'.$dags->id),
                    'ganda'=>$this->input->post('reserved_ganda_family'.$dags->id),
                    'kranti'=>$this->input->post('reserved_kranti_family'.$dags->id),
                    'case_no'=>$case_no,
                    'applid'=>$this->input->post('applid'),
                    'lm_code'=>$this->session->userdata('user_code'),
                    'date_entry'=>date('Y-m-d h:i:s'),
                    'date_update'=>date('Y-m-d h:i:s'),
                    'type'=>'F'
                );

                $reserveData = $this->db->insert('settlement_reservation',$reservedarea);
                // echo $this->db->last_query(); die();
                if($reserveData != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET00053: Insertion failed in settlement_reservation RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRSET00053: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
            }
        }

        ///// family reserve area end //////


        //////proceeding start//////
        $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

        if($proceeding_id==null){
            $proceeding_id=1;
        }

        $insPetProceed = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'note_on_order' => $comment,
            'status' => 'W',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d h:i:s'),
            'operation' => 'E',
            'ip' => $this->utilityclass->get_client_ip(),
            'office_from' => 'LM',
            'office_to' => 'CO',
            'task' => 'LM note submitted'
        ];
        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

        // echo $this->db->last_query(); die();
        if($insertProceeding != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
            $json = [
                'errorMessage'=>"#ERRORPP: Failed to forward the case for Case No : ".$case_no
            ];
            echo json_encode($json);
            return false;
        }
        //////proceeding end//////

        ////settlement Khas LM Report insert end

        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            $data=array(
                'error'=>"Error in submitting. Please try Again"
            );
        }else
        {
            $basundhara=array(
                'dharitree'=>$case_no,
                'basundhara'=>$application_no,
                'date_reg'=>date('Y-m-d'),
                'reg_by'=>$this->session->userdata('user_code'),
                'app_status'=>'M',
                'pending_with'=>'LM'
            );
            $this->db->insert('basundhar_application',$basundhara);
            //////////////POST To basundhara/////////////////////
            $rmk='Forwarded to CO';
            $status='W';
            $task='LM';
            $pen='CO';
            $case=$case_no;
            $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
            $rtps_status=json_decode($rtps_status);
            //var_dump($rtps_status);
            if(trim($rtps_status)!="y"){
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error #ERRAPP0011: Settlement Application not submitted case no # $case_no");
                redirect(base_url() . "index.php/home");
            }else{
                $this->db->trans_commit();
            }

            //////////////////
            // $this->DashboardInheritance($case_no['case_no']);
            //////
            //////////////////////////////////
            $this->session->set_flashdata('message', "Settlement Application Registered Successfully with case no # $case_no");
            redirect(base_url() . "index.php/home");

            // $data=array(
            //     'success'=>"Settlement Application Registered Successfully with case no $case_no[case_no]",
            //     'redirect_url'=>base_url().'index.php/home'
            // );
        }
        // echo json_encode($data);


    }


    // settlement Ap Post new start
    function settlementApPostNew(){

        $application_no=$this->input->post('application_no');
        //////////////////
        $recordExist=$this->SettlementApiModel->checkExistDharitree($application_no);
        if($recordExist){
            $data=array(
                'error'=>"Case have been Registered Already. Please Check"
            );
            echo json_encode($data);
            exit;
        }

        /////////////////////
        $url = API_LINK_MB2."getAppDetails?application_no=" . $application_no ;
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

        $district['applicants']=$output->applicants;
        $district['document']=$output->documents;
        $district['query']=$output->query;
        $district['property']=$output->property;
        $district['settlements']=$output->settlements;
        $district['encroachers'] = $output->encroachers;
        $district['owners'] = $output->owners;
        $district['riotee_noks'] = $output->riotee_noks;
        $district['aadhar']=$output->aadhar;
        $district['nextKin'] = $output->nextKin;

        $d=$district['app']->dist_code;
        $s=$district['app']->subdiv_code;
        $c=$district['app']->cir_code;
        $m=$district['app']->mouza_code;
        $l=$district['app']->lot_no;
        $v=$district['app']->village_code;
        $pno=$district['pattaNo']->patta_no;
        $pc=$district['pattaNo']->patta_type_code;
        $dag = $district['app']->dag_no;

        $this->db->trans_begin();

        $case_name=$this->SettlementApiModel->genearteCaseName();
        if(empty($case_name)){
            $data=array(
                'error'=>"Network Issue or Seesion Out. Please try Again"
            );
            echo json_encode($data);
            exit;
            die();
        }
        $case_no['petition_no']=$petition_no=$this->SettlementApiModel->genearteSettlementPetitionNo();
        $case_no['case_no']=$case_name.$petition_no."/".SETTLEMENT_AP_TRANSFER;


        $basic=array(
            'dist_code'=>$this->input->post('dist_code'),
            'subdiv_code'=>$this->input->post('subdiv_code'),
            'cir_code'=>$this->input->post('cir_code'),
            'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
            'lot_no'=>$this->input->post('lot_no'),
            'vill_townprt_code'=>$this->input->post('vill_townprt_code'),
            'service_code'=>$this->input->post('service_code'),
            'ref_no'=>$this->input->post('ref_no'),
            'case_no'=>$case_no['case_no'],
            'trans_code'=>'F',/////////full
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'date_entry' => date('Y-m-d G:i:s'),
            'status'=>'W',
            'user_code'=>$this->session->userdata('user_code'),
            'lm_code' => $this->session->userdata('user_code'),
            'submission_date' => date('Y-m-d G:i:s'),
            'from_office' => 'LM',
            'pending_officer' => 'CO',
            'pending_office' => 'CO',
            // 'period_possession'=>$this->input->post('period_possession'),
            // 'occupation_applicant'=>$this->input->post('occupation_applicant'),
            'applid'=>$this->input->post('applid'),
            'caste'=>$this->input->post('caste'),
            'uuid'=>$this->input->post('uuid')
            /////////
        );

        $insSetBasic = $this->db->insert('settlement_basic',$basic);
        // echo $this->db->last_query(); die();
        if($insSetBasic != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRAP0001: Insertion failed in settlement_basic RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRAP0001: Registration of Settlement failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }

        ////settlement_dag_details insert start
        $fmd=array(
            'dist_code'=>$this->input->post('dist_code'),
            'subdiv_code'=>$this->input->post('subdiv_code'),
            'cir_code'=>$this->input->post('cir_code'),
            'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
            'lot_no'=>$this->input->post('lot_no'),
            'vill_townprt_code'=>$this->input->post('vill_townprt_code'),
            'user_code'=>$this->session->userdata('user_code'),
            'date_entry'=>date('Y-m-d'),
            'case_no'=>$case_no['case_no'],
            'petition_no'=>$case_no['petition_no'],
            'year_no'=>date('Y'),
            'operation'=>'E',
            'new_land_class_code'=>$this->input->post('land_class_code'),
        );

        $fmd['dag_no']= $this->input->post('dag_no');
        $fmd['patta_no']=$this->input->post('patta_no');
        $fmd['patta_type_code']=$this->input->post('patta_type_code');
        $fmd['dag_area_b']=$this->input->post('dag_area_b');
        $fmd['dag_area_k']=$this->input->post('dag_area_k');
        $fmd['dag_area_lc']=$this->input->post('dag_area_lc');
        $fmd['dag_area_g']=$this->input->post('dag_area_g');
        $fmd['dag_area_kr']=$this->input->post('dag_area_kr');
        $fmd['s_dag_area_b']=$this->input->post('s_dag_area_b');
        $fmd['s_dag_area_k']=$this->input->post('s_dag_area_k');
        $fmd['s_dag_area_lc']=$this->input->post('s_dag_area_lc');
        $fmd['s_dag_area_g']=$this->input->post('s_dag_area_g');
        $fmd['s_dag_area_kr']=$this->input->post('s_dag_area_kr');
        $fmd['is_urban']=trim($this->input->post('is_urban'));
        $fmd['revenue']=0;
        $insSetDag = $this->db->insert('settlement_dag_details',$fmd);

        if($insSetDag != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRAP0002: Insertion failed in settlement_dag_details RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRAP0002: Registration of Settlement failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }
        ////settlement_dag_details insert end


        ////settlement_applicant insert start
        foreach($district['applicants'] as $setl){

            if($this->input->post('pdar_id'.$setl->id)=="" || $this->input->post('pdar_id'.$setl->id)==null || empty($this->input->post('pdar_id'.$setl->id)))
            {
                $chitha_pdar_id=-1;
            }else{
                $chitha_pdar_id=$this->input->post('pdar_id'.$setl->id);
            }

            $c_n = $case_no['case_no'];
            $sql = "SELECT pdar_cron_no FROM
                    settlement_applicant
                        WHERE
                            case_no = '$c_n'";
            $result = $this->db->query($sql)->row();

            if($result == true){
                $cron_no = (int)$result->pdar_cron_no + 1;
            }else{
                $cron_no = 1;
            }

            $applicant=array(
                'dist_code'=>$this->input->post('dist_code'),
                'subdiv_code'=>$this->input->post('subdiv_code'),
                'cir_code'=>$this->input->post('cir_code'),
                'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
                'lot_no'=>$this->input->post('lot_no'),
                'vill_townprt_code'=>$this->input->post('vill_townprt_code'),

                'user_code'=>$this->session->userdata('user_code'),
                'case_no'=>$case_no['case_no'],
                'petition_no'=>$case_no['petition_no'],
                'operation'=>'E',
                'dag_no' =>$this->input->post('dag_no'),
                'patta_no' =>$this->input->post('patta_no'),
                'patta_type_code'=>$this->input->post('patta_type_code'),
                'year_no'=>date('Y'),
                'date_entry'=>date('Y-m-d'),
                'pdar_id' =>$chitha_pdar_id,
                'pdar_cron_no'=> (string) $cron_no++,
                'pdar_name' =>$this->input->post('pdar_name'.$setl->id),
                'pdar_guardian' =>$this->input->post('pdar_guardian'.$setl->id),

                'pdar_rel_guar' =>$this->input->post('pdar_rel_guar'.$setl->id),
                'pdar_gender'=>$this->input->post('pdar_gender'.$setl->id),
                // //'pdar_add1' => $part->address,
                'pdar_add1' => $this->input->post('pdar_add1'.$setl->id),
                'pdar_add2' => $this->input->post('pdar_add2'.$setl->id),
                'pdar_mobile' => $this->input->post('pdar_mobile'.$setl->id),
                // 'i_area_b' => $this->input->post('i_area_b'.$setl->id),
                // 'i_area_k' => $this->input->post('i_area_k'.$setl->id),
                // 'i_area_lc' => $this->input->post('i_area_lc'.$setl->id),
                // 'i_area_g' => $this->input->post('i_area_g'.$setl->id),
                // 'i_area_kr' => $this->input->post('i_area_kr'.$setl->id),
                'pdar_type' => $this->input->post('pdar_type'.$setl->id),
            );

            $insSetApplicant = $this->db->insert('settlement_applicant',$applicant);

            if($insSetApplicant != 1)
            {
                // var_dump($insSetApplicant);
                // echo $this->db->last_query(); die();
                $this->db->trans_rollback();
                log_message('error', '#ERRAP0003: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                $data = array(
                    'error'=>"#ERRAP0003: Registration of Settlement failed for case no : ".$application_no
                );
                echo json_encode($data);
                return false;
            }

        }


        $petition_no = $case_no['petition_no'];
        $case_no = $case_no['case_no'];


        // insert owner -md -12-09-2022
        if($output->owners == true){
            foreach($output->owners as $allapplicants){
                $query = "SELECT 
                            pdar_id,
                            pdar_name,
                            pdar_father 
                            FROM 
                                chitha_pattadar 
                                WHERE 
                                    dist_code= '$d' 
                                    AND 
                                    subdiv_code='$s' 
                                    AND 
                                    cir_code='$c' 
                                    AND 
                                    lot_no='$l' 
                                    AND 
                                    mouza_pargona_code='$m' 
                                    AND 
                                    vill_townprt_code='$v' 
                                    AND 
                                    trim(patta_no)=trim('$pno') 
                                    AND 
                                    patta_type_code='$pc' 
                                    AND 
                                    pdar_id='$allapplicants->chitha_pdar_id' ";

                $owner = $this->db->query($query)->result();
                $district['owner'] = $owner;
            }
            foreach($owner as $owner_applicant){

                $applicant_owner=array(
                    'dist_code'=>$this->input->post('dist_code'),
                    'subdiv_code'=>$this->input->post('subdiv_code'),
                    'cir_code'=>$this->input->post('cir_code'),
                    'mouza_pargona_code'=>$this->input->post('mouza_pargona_code'),
                    'lot_no'=>$this->input->post('lot_no'),
                    'vill_townprt_code'=>$this->input->post('vill_townprt_code'),

                    'user_code'=>$this->session->userdata('user_code'),
                    'case_no'=> $case_no,
                    'petition_no'=>$petition_no,
                    'operation'=>'E',
                    'dag_no' =>$this->input->post('dag_no'),
                    'patta_no' =>$this->input->post('patta_no'),
                    'patta_type_code'=>$this->input->post('patta_type_code'),
                    'year_no'=>date('Y'),
                    'date_entry'=>date('Y-m-d'),
                    'pdar_name' => $this->input->post('owners_name'.$owner_applicant->pdar_id),
                    'pdar_guardian' => $this->input->post('owners_guardian'.$owner_applicant->pdar_id),
                    'pdar_rel_guar' => '0',
                    'pdar_cron_no'=> (string) $cron_no++,
                    'pdar_id' => $owner_applicant->pdar_id,
                    'pdar_type' => 'O',
                    'inplace_alongwith' => $this->input->post('owners_in_place'.$owner_applicant->pdar_id)
                );

                $insSetOwners = $this->db->insert('settlement_applicant',$applicant_owner);


                if($insSetOwners != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRAP0004: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRAP0004: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }

            }

        }

        ////settlement_applicant insert end

        ////supportive_document insert start
        // foreach($data['documents'] as $docs){
        //     $document=array(
        //         'case_no'=>$case_no['case_no'],
        //         'user_code'=>$this->session->userdata('user_code'),
        //         'file_name'=>$this->input->post('file_name'),
        //         'file_type'=>$this->input->post('file_type'),
        //         'file_path'=>$this->input->post('file_path'),
        //         'date_entry' => date('Y-m-d G:i:s'),
        //         'mut_type'=>$this->input->post('mut_type'),
        //         /////////
        //     );

        //     $insDoc = $this->db->insert('supportive_document',$document);;
        //     if($insDoc != 1)
        //     {
        //         $this->db->trans_rollback();
        //         log_message('error', '#ERRSET0004: Insertion failed in supportive_document RTPS Case No '.$application_no);
        //         $data = array(
        //             'error'=>"#ERRSET0004: Registration of Settlement failed for case no : ".$application_no
        //         );
        //         echo json_encode($data);
        //         return false;
        //     }
        // }
        ////supportive_document insert end

        ////settlement AP LM Report insert start

        ////////////////////file///////////////////////////
        // var_dump("in file"); die();
        header('content-type:application/json');
        $documents_config = json_decode(SETTLEMENT_AP_FILES);
        $validations=[];
        $document_details=[];
        log_message("error","------------FILE validation STARTED------------- ");
        foreach($documents_config as $key=>$value){
            $return= $this->SettlementApiModel->fileManualValidation($value);

            if(!is_null($return)){
                $return['status']==1 ? $validations[]= $return['validation']: $document_details[]= $return['data'];
            }
        }
        log_message("error","------------FILE validation ENDED--------------- ");
        if(!empty($validations)){
            echo json_encode(array(
                'responseType' => 1,
                'validation' => $validations
            ));
            return;
        }
        // NOW STORE THE FILE
        // $application_id = $_POST['application_id'];
        $documents=[];
        log_message("error","------------FILE SAVE STARTED------------- ");
        foreach($document_details as $value){
            log_message("error","doc data".json_encode($value));
            // $file_new_name= RTPS_CODE.'_'.$application_id . '_'.SETTLEMENT_AP_TRANSFER_ID.'_'.$value['file_name'].'.'.$value['extension'];
            $timestamp = date('mdYhis', time());
            $file_new_name= $value['file_name'].$timestamp.'.'.$value['extension'];
            $app_doc = $this->db->select('id')->from('supportive_document')->where(
                array('case_no'=>$case_no,'file_name'=>$value['file_details'])
            )->get()->row();

            log_message("error","doc data".json_encode(empty($app_doc)));
            $document= array(
                'case_no' => $case_no,
                'file_name' => $value['file_details'],
                'user_code' => $this->session->userdata('user_code'),
                'fetch_file_name' => $file_new_name,
                'file_type' => $value['content_type'],
                'file_path' => UPLOAD_DIR.$file_new_name,
                'date_entry' => date('Y-m-d h:i:s'),
                'mut_type' => $this->input->post('service_code'),
            );
            // var_dump($document); die();
            if(empty($app_doc)){
                $status= $this->db->insert('supportive_document',$document);
                log_message("error","insert doc status:".json_encode($status));
                log_message("error","last query".json_encode($this->db->last_query()));
            }
            //else{
            //     log_message("error","update doc");
            //     $this->db->where('id',$app_doc->id)->update('supportive_document',$document);
            //     log_message("error","last query".json_encode($this->db->last_query()));
            // }
            log_message("error","doc data".json_encode($document));
            move_uploaded_file($_FILES[$value['file_name']]['tmp_name'], UPLOAD_DIR.$file_new_name);
        }
        if ($this->db->trans_status() === FALSE) {
            log_message("error","------------FILE SAVE ENDED WITH ERROR------------- ");
            $this->db->trans_rollback();
            echo json_encode(array(
                'responseType' => 3,
                'error' => 'Something Went wrong!!!'
            ));
            return;
        } else {
            log_message("error","------------FILE SAVE END------------- ");
            // echo json_encode(array(
            //     'responseType' => 2
            //     // 'application_id' => $application_id
            // ));
        }

        ///////////////////////////////////////////////

        $comment = addslashes($this->input->post('lm_remark'));
        $r_bigha = $this->input->post('reserved_bigha');
        $r_katha = $this->input->post('reserved_katha');
        $r_lessa = $this->input->post('reserved_lessa');
        $r_ganda = $this->input->post('reserved_ganda');
        $r_kranti = $this->input->post('reserved_kranti');

        $lmnote=array(
            'user_code'=>$this->session->userdata('user_code'),
            'chitha_verified'=>$this->input->post('chiitha_verified'),
            // 'vlb_verified'=>$this->input->post('vlb_verified'),
            'is_tribal_belt' => $this->input->post('whether_tribal'),
            'possession_verification'=>$this->input->post('possession_verified'),
            'period_possession'=>date('Y-m-d'),
            'nature_possession'=>$this->input->post('nature_possession'),
            'is_landless'=>$this->input->post('is_landless'),
            // 'ceiling_limit'=>$this->input->post('ceiling_limit'),
            'roadside_reservation'=>$this->input->post('roadside_reservation'),
            'zonal_valuation'=>$this->input->post('zonal_valuation'),
            // 'trace_map_copy'=>$this->input->post('trace_map_copy'),
            // 'chitha_copy'=>$this->input->post('chitha_copy'),
            'trace_map_copy'=>'NA',
            'chitha_copy'=>'NA',
            'lm_note'=>$comment,
            'date_entry'=>date('Y-m-d h:i:s'),
            'case_no'=>$case_no,
            'status'=>'W',
            'land_falls'=>$this->input->post('land_falls'),
            'falls_und_gmc'=>$this->input->post('falls_und_gmc'),
            'lm_remark_text'=>$this->input->post('lm_remark_text'),
            'total_bigha'=>$this->input->post('total_bigha'),
            'total_Katha'=>$this->input->post('total_Katha'),
            'total_lessa'=>$this->input->post('total_lessa'),
            'total_ganda'=>$this->input->post('total_ganda'),
            'total_kranti'=>$this->input->post('total_kranti'),
            // 'encroacher_exist_vlb' => $this->input->post('encroacher_exist_vlb'),
            'landslide'            => $this->input->post('landslide'),
            'is_nr_settlement'=>$this->input->post('is_nr_settlement')

        );

        $insLmnote = $this->db->insert('settlement_ap_lmnote',$lmnote);
        // echo $this->db->last_query(); die();
        if($insLmnote != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRAP0005: Insertion failed in settlement_ap_lmnote RTPS Case No '.$application_no);
            $data = array(
                'error'=>"#ERRAP0005: Registration of Settlement failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
        }


        ///// road side reserve area start /////
        if($roadside_comment_check=='YES')
        {
            foreach($district['encroachers'] as $dags)
            {
                $reservedarea=array(

                    'dist_code'=>$this->input->post('district_code'),
                    'subdiv_code'=>$this->input->post('sub_div_code'),
                    'cir_code'=>$this->input->post('circle_code'),
                    'mouza_pargona_code'=>$this->input->post('mouza_code'),
                    'lot_no'=>$this->input->post('lot_no'),
                    'vill_townprt_code'=>$this->input->post('select_village'),
                    'dag_no'=>$this->input->post('reserved_dag_road'.$dags->id),
                    'patta_no'=>$this->input->post('reserved_patta_road'.$dags->id),
                    'bigha'=>$this->input->post('reserved_bigha'.$dags->id),
                    'katha'=>$this->input->post('reserved_katha'.$dags->id),
                    'lessa'=>$this->input->post('reserved_lessa'.$dags->id),
                    'ganda'=>$this->input->post('reserved_ganda'.$dags->id),
                    'kranti'=>$this->input->post('reserved_kranti'.$dags->id),
                    'case_no'=>$case_no,
                    'applid'=>$this->input->post('applid'),
                    'lm_code'=>$this->session->userdata('user_code'),
                    'date_entry'=>date('Y-m-d h:i:s'),
                    'date_update'=>date('Y-m-d h:i:s'),
                    'type'=>'R'
                );

                $reserveData = $this->db->insert('settlement_reservation',$reservedarea);
                // echo $this->db->last_query(); die();
                if($reserveData != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET00052: Insertion failed in settlement_reservation RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRSET00052: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
            }
        }

        ///// road reserve area end //////

        ///// family reserve area start /////


        if($family_comment_check=='YES')
        {
            foreach($district['encroachers'] as $dags){
                $reservedarea=array(

                    'dist_code'=>$this->input->post('district_code'),
                    'subdiv_code'=>$this->input->post('sub_div_code'),
                    'cir_code'=>$this->input->post('circle_code'),
                    'mouza_pargona_code'=>$this->input->post('mouza_code'),
                    'lot_no'=>$this->input->post('lot_no'),
                    'vill_townprt_code'=>$this->input->post('select_village'),
                    'dag_no'=>$this->input->post('reserved_dag_family'.$dags->id),
                    'patta_no'=>$this->input->post('reserved_patta_family'.$dags->id),
                    'bigha'=>$this->input->post('reserved_bigha_family'.$dags->id),
                    'katha'=>$this->input->post('reserved_katha_family'.$dags->id),
                    'lessa'=>$this->input->post('reserved_lessa_family'.$dags->id),
                    'ganda'=>$this->input->post('reserved_ganda_family'.$dags->id),
                    'kranti'=>$this->input->post('reserved_kranti_family'.$dags->id),
                    'case_no'=>$case_no,
                    'applid'=>$this->input->post('applid'),
                    'lm_code'=>$this->session->userdata('user_code'),
                    'date_entry'=>date('Y-m-d h:i:s'),
                    'date_update'=>date('Y-m-d h:i:s'),
                    'type'=>'F'
                );

                $reserveData = $this->db->insert('settlement_reservation',$reservedarea);
                // echo $this->db->last_query(); die();
                if($reserveData != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET00053: Insertion failed in settlement_reservation RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRSET00053: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
            }
        }

        ///// family reserve area end //////


        //////proceeding start//////
        $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

        if($proceeding_id==null){
            $proceeding_id=1;
        }

        $insPetProceed = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'note_on_order' => $comment,
            'status' => 'W',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d h:i:s'),
            'operation' => 'E',
            'ip' => $this->utilityclass->get_client_ip(),
            'office_from' => 'LM',
            'office_to' => 'CO',
            'task' => 'LM note submitted'
        ];
        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

        // echo $this->db->last_query(); die();
        if($insertProceeding != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
            $json = [
                'errorMessage'=>"#ERRORPP: Failed to forward the case for Case No : ".$case_no
            ];
            echo json_encode($json);
            return false;
        }
        //////proceeding end//////

        ////settlement AP LM Report insert end

        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            $data=array(
                'error'=>"Error in submitting. Please try Again"
            );
        }else
        {
            $basundhara=array(
                'dharitree'=>$case_no,
                'basundhara'=>$application_no,
                'date_reg'=>date('Y-m-d'),
                'reg_by'=>$this->session->userdata('user_code'),
                'app_status'=>'M',
                'pending_with'=>'LM'
            );
            $this->db->insert('basundhar_application',$basundhara);

            //////////////POST To basundhara/////////////////////
            $rmk='Forwarded to CO';
            $status='W';
            $task='LM';
            $pen='CO';
            $case=$case_no;
            $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
            $rtps_status=json_decode($rtps_status);
            //var_dump($rtps_status);
            if(trim($rtps_status)!="y"){
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error #ERRAPP0011: Settlement Application not submitted case no # $case_no");
                redirect(base_url() . "index.php/home");
            }else{
                $this->db->trans_commit();
            }
            //////////////////
            // $this->DashboardInheritance($case_no['case_no']);
            //////
            //////////////////////////////////
            $this->session->set_flashdata('message', "Settlement Application Registered Successfully with case no # $case_no");
            redirect(base_url() . "index.php/home");

            // $data=array(
            //     'success'=>"Settlement Application Registered Successfully with case no $case_no[case_no]",
            //     'redirect_url'=>base_url().'index.php/home'
            // );
        }
        // echo json_encode($data);
    }

    public function encroacherPagination(){

        $dag_no = $this->input->post('dag_no');
        $riotee_id = $this->input->post('riotee_id');
        $uuid = $this->input->post('uuid');

        $s_code=$this->input->post('service');
        $search_term = $this->input->post('search_term');

        $status = $this->input->post('status');
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        $col = 0;
        $dir = "";
        $search = $this->input->post('search');
        $search = $search['value'];

        //$searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $searchByCol_1 = trim($this->input->post('columns')[1]['search']['value']);
        $searchByCol_3 = trim($this->input->post('columns')[3]['search']['value']);

        $is_cat = $this->input->post('is_category');

        if(!empty($order)){
            foreach($order as $o){
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if($dir != "asc" && $dir != 'desc'){
            $dir = 'desc';
        }

        $valid_columns = array(
            0   => 'name',
            // 1   => 'applid',
        );

        if(!isset($valid_columns[$col])){
            $order = null;
        }else{
            $order = $valid_columns[$col];
        }

        if($order != null){
            $this->db->order_by($order, $dir);
        }


        if(!empty($searchByCol_1)){

            $this->db->like('name', strtoupper($searchByCol_1));
        }

        if(!empty($searchByCol_3)){
            $this->db->like('TO_CHAR(encroachment_from,\'yyyy-mm-dd\')', $searchByCol_3);
            //$this->db->like('date_entry', $searchByCol_2);
        }


        $this->db->limit($length, $start);

        $this->db->select('c_land_bank_encroacher_details.id, name, fathers_name, encroachment_from, type_of_land_use') ;
        $this->db->from('c_land_bank_details');
        $this->db->join('c_land_bank_encroacher_details', 'c_land_bank_details.id = c_land_bank_encroacher_details.c_land_bank_details_id');
        $this->db->where(array('c_land_bank_details.village_uuid' => $uuid,'c_land_bank_details.dag_no' => $dag_no));
        $query = $this->db->get();

        // echo $this->db->last_query();

        if($query->num_rows()>0){
            $sl_count = 1;
            foreach($query->result() as $rows){

                foreach(json_decode(LB_ENC_TYPE_OF_LAND_USE) as $land_type){
                    if($land_type->CODE == $rows->type_of_land_use){
                        $land_type_name = $land_type->NAME;
                    }
                }

                $json[] = array(
                    $sl_count++,
                    '<span style= font-size:14px;><strong>'.$rows->name.'</strong></span>',

                    '<span style= font-size:14px;><strong>'.$rows->fathers_name.'</strong></span>',

                    date("Y-m-d", strtotime($rows->encroachment_from)),

                    '<span style= font-size:14px;><strong>'.$land_type_name.'</strong></span>
                    
                    
                    <input type="hidden" name="enc_name" id="enc_name'.$rows->id.'" value="'.$rows->name.'">
                    <input type="hidden" name="enc_fathers_name" id="enc_fathers_name'.$rows->id.'" value="'.$rows->fathers_name.'">
                    <input type="hidden" name="end_enc_from" id="end_enc_from'.$rows->id.'" value="'.date("Y-m-d", strtotime($rows->encroachment_from)).'">
                    <input type="hidden" name="enc_land_type" id="enc_land_type'.$rows->id.'" value="'.$rows->type_of_land_use.'">',

                    '<button type="button" onclick="changeEncroacher('.$rows->id.','.$riotee_id.');" id="'.$rows->id.'" class="btn btn-sm btn-danger">Select</button>',

                );
            }


            if(!empty($searchByCol_1)){

                $this->db->like('name', strtoupper($searchByCol_1));
            }

            if(!empty($searchByCol_3)){
                $this->db->like('TO_CHAR(encroachment_from,\'yyyy-mm-dd\')', $searchByCol_3);
                //$this->db->like('date_entry', $searchByCol_2);
            }

            $this->db->select('name, fathers_name, encroachment_from, type_of_land_use') ;
            $this->db->from('c_land_bank_details');
            $this->db->join('c_land_bank_encroacher_details', 'c_land_bank_details.id = c_land_bank_encroacher_details.c_land_bank_details_id');
            $this->db->where(array('c_land_bank_details.village_uuid' => $uuid,'c_land_bank_details.dag_no' => $dag_no));
            $total_records = $this->db->count_all_results();
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

    function document($doc){
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."attachment");
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

    function getCaseDetailsByServiceLot($service){
        $file_name=time()."_locations.xlsx";
        $d=$this->session->userdata('dist_code');
        $s=$this->session->userdata('subdiv_code');
        $c=$this->session->userdata('cir_code');
        $m=$this->session->userdata('mouza_pargona_code');
        $l=$this->session->userdata('lot_no');
        $url = API_LINK_MB2."/getCaseDetailsByServiceLot/$service/$d/$s/$c/$m/$l" ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
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

    public function downloadRejected()
    {
        $dist_code = $this->session->userdata('dist_code');

        $query = $this->db->query("SELECT
        (SELECT loc_name FROM location WHERE dist_code=a.dist_code AND subdiv_code=a.subdiv_code AND cir_code='00') sub_division,
        (SELECT loc_name FROM location WHERE dist_code=a.dist_code AND  subdiv_code=a.subdiv_code AND cir_code=a.cir_code AND mouza_pargona_code='00') circle,
        (SELECT loc_name FROM location WHERE dist_code=a.dist_code AND subdiv_code=a.subdiv_code AND cir_code=a.cir_code AND mouza_pargona_code=a.mouza_pargona_code AND lot_no=a.lot_no
        AND vill_townprt_code=a.vill_townprt_code) village,
         CASE              
                      WHEN (service_code = '13') THEN 'SETTLEMENT TENANT'
                      WHEN (service_code = '14') THEN 'SETTLEMENT AP TRANSFER'
                      WHEN (service_code = '15') THEN 'SETTLEMENT TRIBAL COMMUNITY'
                      WHEN (service_code = '16') THEN 'SETTLEMENT KHAS LAND'
                      WHEN (service_code = '17') THEN 'SETTLEMENT PGR VGR LAND'
                      WHEN (service_code = '18') THEN 'SETTLEMENT SPECIAL CULTIVATORS'
                     END AS service_name, a.applid AS application_no, a.case_no, b.note_on_order AS rejected_reason FROM settlement_basic a JOIN settlement_proceeding b ON a.case_no = b.case_no WHERE a.status = 'D' 
        AND b.id = (SELECT id FROM settlement_proceeding WHERE case_no = a.case_no ORDER BY id DESC LIMIT 1)");

        if($query->num_rows() <= 0)
        {
            echo json_encode('ERR414EEDD: No rejected case found!');
            return false;
        }

        $result = $query->result();

        $file_name = $this->utilityclass->getDistrictName($dist_code).".xlsx";
        $this->UtilsModel->downloadExcelReport($file_name, $result);

    }



    public function getApplicationList(){
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $dist_code   = $this->input->post('dist_code');
        $data['dist_code'] = $dist_code;
        $data['subdiv_code'] = $subdiv_code;
        $data['cir_code'] = $cir_code;
        $data['dist_name'] = $this->utilityclass->getDistrictName($dist_code);
        $data['circle_name'] = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $data['subdiv_name'] = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $this->load->view('basundhara/settlement_payment_notice_report_applications', $data);
    }

    public function getListofPaymentNoticeCases()
    {

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        $searchByCol_0 = trim($this->input->post('columns')[1]['search']['value']);
        $searchByCol_1 = trim($this->input->post('columns')[2]['search']['value']);
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $paymentStatus = $this->input->post('paymentStatus');
       
        $this->load->model('basundharaPaymentNoticeReportModel');

        $results = $this->basundharaPaymentNoticeReportModel->getCaseListNew($dist_code, $subdiv_code, $cir_code,$start,$length,$order,$searchByCol_0,$searchByCol_1,$paymentStatus);

        $total_records = count($this->basundharaPaymentNoticeReportModel->getCaseListNewCount($dist_code, $subdiv_code, $cir_code,$start,$length,$order,$searchByCol_0,$searchByCol_1,$paymentStatus));


        if (!empty($results)) {
            $data_rows = $results;
            $paymentNoticeStatus = 'N/A';
            foreach ($data_rows as $key => $rows) {
                if($rows->status == 'M'){
                    $paymentNoticeStatus = 'Pending';
                }else if($rows->status == 'N' && $rows->grn_no == null){
                    $paymentNoticeStatus = 'Payment Notice Generated';
                }else if($rows->grn_no != null){
                    $paymentNoticeStatus = 'Payment Done';   
                }
                
                $json[] = array(
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',
                    
                    $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                    $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    // $rows->date_entry,
                    $paymentNoticeStatus,
                    date("Y-m-d", strtotime($rows->date_entry))
                  

                );
            }

            
            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json,
            );
            echo json_encode($response);

        } else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }

    public function downloadPaymentNoticeReport()
    {

        if($this->session->userdata('user_desig_code')=='CO')
        {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');

        }
        else
        {
            $dist_code = $this->input->get('dist_code');
            $subdiv_code = $this->input->get('subdiv_code');
            $cir_code = $this->input->get('cir_code');
        }
        $paymentStatus = $this->input->get('paymentStatus');
        if($paymentStatus == null || $paymentStatus == ''){
            echo json_encode('ERROR0911 : ----Data not available for downloading the report...');
            return false;
        }
        $file_new_name = null;
        if($paymentStatus == 'M'){
            $file_new_name = 'Payment_Notice_Pending_report_for';
        }elseif($paymentStatus == 'N'){
            $file_new_name = 'Payment_Notice_Generated_report_for';
        }elseif($paymentStatus == 'G'){
            $file_new_name = 'Payment_Done_report_for';
        }
        elseif($paymentStatus == 'U'){
            $file_new_name = 'Pending_Payment_report_for';
        }
       
        $this->load->model('basundharaPaymentNoticeReportModel');

        $results = $this->basundharaPaymentNoticeReportModel->paymentNoticeCasesReport($dist_code, $subdiv_code, $cir_code,$paymentStatus);
        if(sizeof($results) <= 0)
        {
            echo json_encode('ERROR091 : ----Data not available for downloading the report...');
            return false;
        }

        $result = $results;
        $file_name = $file_new_name.$this->utilityclass->getDistrictName($dist_code).".xlsx";
        $this->UtilsModel->downloadExcelReport($file_name, $result);

    }

    function settlementOffered(){
        $dist_code=$this->session->userdata('dist_code');
        $subdiv_code=$this->session->userdata('subdiv_code');
        $cir_code=$this->session->userdata('cir_code');
        if($this->session->userdata('user_desig_code')=='DC' || $this->session->userdata('user_desig_code')=='ADC'){
            $where="sa.dist_code='$dist_code' ";
        }else if($this->session->userdata('user_desig_code')=='CO'){
            $where="sa.dist_code='$dist_code' and sa.subdiv_code='$subdiv_code' and sa.cir_code='$cir_code' ";
        }

        if ($dist_code == '21')
        {

            $sql="SELECT
                (select locname_eng from location where dist_code=sb.dist_code and subdiv_code=sb.subdiv_code
                and cir_code=sb.cir_code and mouza_pargona_code='00') CIRCLE,
                (select locname_eng from location where dist_code=sb.dist_code and subdiv_code=sb.subdiv_code and cir_code=sb.cir_code and mouza_pargona_code=sb.mouza_pargona_code and lot_no=sb.lot_no and vill_townprt_code=sb.vill_townprt_code) VILLAGE,
                case
                when sb.service_code=13 then 'SETTLEMENT_TENANT'
                when sb.service_code=14 then 'SETTLEMENT_AP_TRANSFER'
                when sb.service_code=15 then 'SETTLEMENT_TRIBAL_COMMUNITY'
                when sb.service_code=16 then 'SETTLEMENT_KHAS_LAND'
                when sb.service_code=17 then 'SETTLEMENT_PGR_VGR_LAND'
                when sb.service_code=18 then 'SETTLEMENT_SPECIAL_CULTIVATORS'
                end as SERVICE,
                UPPER(sa.eng_pdar_name) AS NAME_OF_APPLICANT,
                UPPER(sa.eng_pdar_guardian) AS GUARDIAN_NAME_OF_APPLICANT,
                CASE
                WHEN sa.pdar_gender = '1' THEN 'MALE'
                WHEN sa.pdar_gender = '2' THEN 'FEMALE'
                WHEN sa.pdar_gender = '3' THEN 'OTHER'
                end as GENDER,
                CASE
                        WHEN sb.caste = '1' THEN 'ST'
                        WHEN sb.caste = '2' THEN 'SC'
                        WHEN sb.caste = '3' THEN 'Tea Garden'
                        WHEN sb.caste = '4' THEN 'Ex Tea Garden'
                        WHEN sb.caste = '5' THEN 'OBC'
                        WHEN sb.caste = '6' THEN 'GEN'
                        WHEN sb.caste = '7' THEN 'MOBC'
                        END as category,
                (Select CASE
                WHEN SUM(sp.total_lessa) < 0 THEN 'B:' || -FLOOR(SUM(sp.total_lessa) / 6400)
                ELSE 'B:' || FLOOR(SUM(sp.total_lessa) / 6400)
                END || ', ' ||
                CASE
                WHEN SUM(sp.total_lessa) < 0 THEN 'K:' || -FLOOR((SUM(sp.total_lessa) % 6400) / 320)
                ELSE 'K:' || FLOOR((SUM(sp.total_lessa) % 6400) / 320)
                END || ', ' ||
                CASE
                WHEN SUM(sp.total_lessa) < 0 THEN 'C:' || -FLOOR(((ABS(SUM(sp.total_lessa)) % 6400) % 320) / 20)
                ELSE 'C:' || FLOOR(((ABS(SUM(sp.total_lessa)) % 6400) % 320) / 20)
                END || ', ' ||
                CASE
                WHEN SUM(sp.total_lessa) < 0 THEN 'G:' || -ROUND(((ABS(SUM(sp.total_lessa)) % 6400) % 320) % 20, 4)
                ELSE 'G:' || ROUND(((ABS(SUM(sp.total_lessa)) % 6400) % 320) % 20, 4)
                END AS final_area from settlement_premium sp where case_no=sb.case_no and is_final=1) as AREA
                from settlement_applicant sa
                JOIN settlement_basic sb ON sa.case_no = sb.case_no
                WHERE sa.case_no IN
                (
                    SELECT sb.case_no FROM settlement_basic sb WHERE sb.status = 'N'
                )
                AND sa.is_applicant = '1' and $where order by sa.dist_code,sa.subdiv_code,sa.cir_code ";
        }
        else
        {

            $sql="SELECT
                (select locname_eng from location where dist_code=sb.dist_code and subdiv_code=sb.subdiv_code
                and cir_code=sb.cir_code and mouza_pargona_code='00') CIRCLE,
                (select locname_eng from location where dist_code=sb.dist_code and subdiv_code=sb.subdiv_code and cir_code=sb.cir_code and mouza_pargona_code=sb.mouza_pargona_code and lot_no=sb.lot_no and vill_townprt_code=sb.vill_townprt_code) VILLAGE,
                case
                when sb.service_code=13 then 'SETTLEMENT_TENANT'
                when sb.service_code=14 then 'SETTLEMENT_AP_TRANSFER'
                when sb.service_code=15 then 'SETTLEMENT_TRIBAL_COMMUNITY'
                when sb.service_code=16 then 'SETTLEMENT_KHAS_LAND'
                when sb.service_code=17 then 'SETTLEMENT_PGR_VGR_LAND'
                when sb.service_code=18 then 'SETTLEMENT_SPECIAL_CULTIVATORS'
                end as SERVICE,
                UPPER(sa.eng_pdar_name) AS NAME_OF_APPLICANT,
                UPPER(sa.eng_pdar_guardian) AS GUARDIAN_NAME_OF_APPLICANT,
                CASE
                WHEN sa.pdar_gender = '1' THEN 'MALE'
                WHEN sa.pdar_gender = '2' THEN 'FEMALE'
                WHEN sa.pdar_gender = '3' THEN 'OTHER'
                end as GENDER,
                CASE
                        WHEN sb.caste = '1' THEN 'ST'
                        WHEN sb.caste = '2' THEN 'SC'
                        WHEN sb.caste = '3' THEN 'Tea Garden'
                        WHEN sb.caste = '4' THEN 'Ex Tea Garden'
                        WHEN sb.caste = '5' THEN 'OBC'
                        WHEN sb.caste = '6' THEN 'GEN'
                        WHEN sb.caste = '7' THEN 'MOBC'
                        END as category,
                (Select CASE
                WHEN SUM(sp.total_lessa) < 0 THEN 'B:' || -FLOOR(SUM(sp.total_lessa) / 100)
                ELSE 'B:' || FLOOR(SUM(sp.total_lessa) / 100)
                END || ', ' ||
                CASE
                WHEN SUM(sp.total_lessa) < 0 THEN 'K:' || -FLOOR((SUM(sp.total_lessa) % 100) / 20)
                ELSE 'K:' || FLOOR((SUM(sp.total_lessa) % 100) / 20)
                END || ', ' ||
                CASE
                WHEN SUM(sp.total_lessa) < 0 THEN 'L:' || -((SUM(sp.total_lessa) % 100) % 20)
                ELSE 'L:' || (SUM(sp.total_lessa) % 100) % 20
                END AS final_area from settlement_premium sp where case_no=sb.case_no and is_final=1) as AREA
                from settlement_applicant sa
                JOIN settlement_basic sb ON sa.case_no = sb.case_no
                WHERE sa.case_no IN
                (
                    SELECT sb.case_no FROM settlement_basic sb WHERE sb.status = 'N'
                )
                AND sa.is_applicant = '1' and $where order by sa.dist_code,sa.subdiv_code,sa.cir_code ";

        }
        
        $results=$this->db->query($sql);
        echo $this->db->last_query();
        if($results->num_rows()==0)
        {
            echo json_encode('NO DATA FOUND');
        }
        else
            $result[]=$results->result_array();
        // $this->load->model('UtilsModel');
        $file_name = 'report_'.time().".xlsx";
        $this->UtilsModel->downloadExcelReport_result($file_name,$result);
    }





    function paymentCaseReport(){
        $d=$this->session->userdata('dist_code');
        $s=$this->session->userdata('subdiv_code');
        $c=$this->session->userdata('cir_code');
        $this->session->unset_userdata('searchKeyword');
        $desigcode=$this->session->userdata('user_desig_code');
        if($desigcode=='DC' || $desigcode=='ADC'){
            $conditions = ' dist_code=?';

            $params = array($d);
            $query = $this->db->query("select dist_code,subdiv_code,cir_code,(select loc_name from location where dist_code =s.dist_code and subdiv_code=s.subdiv_code and cir_code = s.cir_code and mouza_pargona_code ='00') as circle_name, COUNT (*) FILTER (where status in ('M','N','P')) as total,count(*) filter (where status ='M') as payment_notice,count(*) filter (where status in ('N','P')) as payment_notice_generated, count(*) filter (where sp.grn_no is not null) as payment_done from settlement_basic s

                join (select distinct on(case_no) case_no,grn_no from settlement_premium where is_final=1) sp on s.case_no =sp.case_no

                where $conditions group by dist_code,subdiv_code,cir_code",$params);
        }else if($desigcode=='SDO'){
            $conditions = ' dist_code=? and subdiv_code=?';
            $params = array($d,$s);
            $query = $this->db->query("select dist_code,subdiv_code,cir_code,(select loc_name from location where dist_code =s.dist_code and subdiv_code=s.subdiv_code and cir_code = s.cir_code and mouza_pargona_code ='00') as circle_name, COUNT (*) FILTER (where status in ('M','N','P')) as total,count(*) filter (where status ='M') as payment_notice,count(*) filter (where status in ('N','P')) as payment_notice_generated, count(*) filter (where sp.grn_no is not null) as payment_done from settlement_basic s

                join (select distinct on(case_no) case_no,grn_no from settlement_premium where is_final=1) sp on s.case_no =sp.case_no

                where $conditions group by dist_code,subdiv_code,cir_code",$params);
        }
        else if($desigcode=='CO')
        {
            $conditions = ' dist_code=? and subdiv_code=? and cir_code=?';
            $params = array($d,$s,$c);
            $query = $this->db->query("select dist_code,subdiv_code,cir_code,(select loc_name from location where dist_code =s.dist_code and subdiv_code=s.subdiv_code and cir_code = s.cir_code and mouza_pargona_code ='00') as circle_name, COUNT (*) FILTER (where status in ('M','N','P')) as total,count(*) filter (where status ='M') as payment_notice,count(*) filter (where status in ('N','P')) as payment_notice_generated, count(*) filter (where sp.grn_no is not null) as payment_done from settlement_basic s

                join (select distinct on(case_no) case_no,grn_no from settlement_premium where is_final=1) sp on s.case_no =sp.case_no

                where $conditions group by dist_code,subdiv_code,cir_code",$params);

            $queryReport = $this->db->query("SELECT dist_code as dist_code, subdiv_code as subdiv_code, cir_code as cir_code, 
                mouza_pargona_code as mouza_pargona_code, lot_no as lot_no, vill_townprt_code as vill_townprt_code,
                (select locname_eng from location where dist_code=a.dist_code
                and subdiv_code=a.subdiv_code and cir_code=a.cir_code and mouza_pargona_code='00')
                CIRCLE,
                (select locname_eng from location where dist_code=a.dist_code
                and subdiv_code=a.subdiv_code and cir_code=a.cir_code and mouza_pargona_code= 
                a.mouza_pargona_code and lot_no=a.lot_no and vill_townprt_code=a.vill_townprt_code)
                VILLAGE,
                count(distinct a.case_no) filter (where a.status in ('N','P')) as OoS,
                count(distinct a.case_no) filter (where b.grn_no is  not null and a.status in ('N','P')
                and b.is_final=1) as premium_paid,
                count(distinct a.case_no) filter (where b.grn_no is  not null and a.status in ('N','P')
                and b.is_final=1 and due_amount<=paid_amount) as premium_paid_full,
                count(distinct a.case_no) filter (where b.grn_no is  not null and a.status in ('N','P')
                and b.is_final=1 and due_amount>paid_amount) as premium_paid_partial,
                count(distinct a.case_no) filter (where a.co_chitha_corrected_yn='Y') as chitha_update,
                count(distinct a.case_no) filter (where a.co_chitha_corrected_yn='Y' and b.grn_no is not null and a.status in ('N','P')
                and b.is_final=1 and due_amount<=paid_amount) as chitha_update_full
                FROM settlement_basic a join settlement_premium b on a.case_no=b.case_no where status in ('N','P') and b.is_final=1
                and dist_code='$d' and subdiv_code='$s' and cir_code='$c'
                group by a.dist_code,a.subdiv_code,a.cir_code,a.mouza_pargona_code,a.lot_no,a.vill_townprt_code   
            ");

            $data['reports'] = $queryReport->result();

        }



        log_message('error','---------MB:001--PARAMS--'.json_encode($params).'---conditions--'.$conditions.'-----LAST QUERY--'.$this->db->last_query());

        if($query->num_rows() <= 0)
        {

            echo json_encode('ERR414EEDD21: No Cases case found!');
            return false;
        }

        $result = $query->result();
        $data['output'] = $result;


        $data['_view'] = 'basundhara/settlement_payment_notice_report';
        $this->load->view('layouts/main',$data);
    }



    // Village wise partial paid application list
    public function villageWisePartialPaymentAppList($m,$l,$v)
    {
        $d=$this->session->userdata('dist_code');
        $s=$this->session->userdata('subdiv_code');
        $c=$this->session->userdata('cir_code');
        $m=trim($m);
        $l=trim($l);
        $v=trim($v);

        $query = $this->db->query("select distinct a.case_no from settlement_basic a join settlement_premium b 
                      on a.case_no=b.case_no where dist_code='$d'
                      and subdiv_code='$s' and cir_code='$c' 
                      and mouza_pargona_code='$m' and lot_no='$l' and vill_townprt_code='$v'
                      and due_amount>paid_amount and b.grn_no is not null and is_final=1");

        if($query->num_rows() != 0)
        {
            $data['reports'] = $query->result();
            $data['countReport'] = 1;
        }
        else
        {
            $data['reports'] = 0;
            $data['countReport'] = 0;
        }

        $data['_view'] = 'basundhara/village_wise_partial_payment_app';
        $this->load->view('layouts/main',$data);
    }



    // Village wise fully paid application list
    public function villageWiseFullPaymentAppList($m,$l,$v)
    {
        $d=$this->session->userdata('dist_code');
        $s=$this->session->userdata('subdiv_code');
        $c=$this->session->userdata('cir_code');
        $m=trim($m);
        $l=trim($l);
        $v=trim($v);

        $query = $this->db->query("select distinct a.case_no from settlement_basic a join settlement_premium b 
                      on a.case_no=b.case_no where dist_code='$d'
                      and subdiv_code='$s' and cir_code='$c' 
                      and mouza_pargona_code='$m' and lot_no='$l' and vill_townprt_code='$v'
                      and due_amount<=paid_amount and b.grn_no is  not null and  is_final=1");

        if($query->num_rows() != 0)
        {
            $data['reports'] = $query->result();
            $data['countReport'] = 1;
        }
        else
        {
            $data['reports'] = 0;
            $data['countReport'] = 0;
        }

        $data['_view'] = 'basundhara/village_wise_full_payment_app';
        $this->load->view('layouts/main',$data);
    }



    // Village wise chitha update application list
    public function villageWiseChithaUpdateAppList($m,$l,$v)
    {
        $d=$this->session->userdata('dist_code');
        $s=$this->session->userdata('subdiv_code');
        $c=$this->session->userdata('cir_code');
        $m=trim($m);
        $l=trim($l);
        $v=trim($v);

        $query = $this->db->query("select distinct a.case_no from settlement_basic a join settlement_premium b 
                      on a.case_no=b.case_no where dist_code='$d'
                      and subdiv_code='$s' and cir_code='$c' 
                      and mouza_pargona_code='$m' and lot_no='$l' and vill_townprt_code='$v'
                      and a.co_chitha_corrected_yn='Y' and b.grn_no is  not null and  is_final=1");

        if($query->num_rows() != 0)
        {
            $data['reports'] = $query->result();
            $data['countReport'] = 1;
        }
        else
        {
            $data['reports'] = 0;
            $data['countReport'] = 0;
        }

        $data['_view'] = 'basundhara/village_wise_chitha_update_app';
        $this->load->view('layouts/main',$data);
    }


    // Village wise chitha update fully paid application list
    public function villageWiseChithaUpdateFullPayAppList($m,$l,$v)
    {
        $d=$this->session->userdata('dist_code');
        $s=$this->session->userdata('subdiv_code');
        $c=$this->session->userdata('cir_code');
        $m=trim($m);
        $l=trim($l);
        $v=trim($v);

        $query = $this->db->query("select distinct a.case_no from settlement_basic a join settlement_premium b 
                      on a.case_no=b.case_no where dist_code='$d'
                      and subdiv_code='$s' and cir_code='$c' 
                      and mouza_pargona_code='$m' and lot_no='$l' and vill_townprt_code='$v'
                      and a.co_chitha_corrected_yn='Y' and b.grn_no is  not null and a.status in ('N','P')
                      and b.is_final=1 and due_amount<=paid_amount");

        if($query->num_rows() != 0)
        {
            $data['reports'] = $query->result();
            $data['countReport'] = 1;
        }
        else
        {
            $data['reports'] = 0;
            $data['countReport'] = 0;
        }

        $data['_view'] = 'basundhara/village_wise_chitha_update_full_pay_app';
        $this->load->view('layouts/main',$data);
    }



    // PPP fully paid but chitha not updated
    public function pppFullWithoutChithaUpdatedAppList()
    {
        $d=$this->session->userdata('dist_code');
        $s=$this->session->userdata('subdiv_code');
        $c=$this->session->userdata('cir_code');

        $query = $this->db->query("select distinct a.case_no,a.applid  from settlement_basic a join settlement_premium b
                      on a.case_no=b.case_no where dist_code='$d' and subdiv_code='$s' and cir_code='$c'
                      and b.grn_no is not null and  is_final=1 and due_amount<=paid_amount and a.co_chitha_corrected_yn != 'Y' ");


        if($query->num_rows() != 0)
        {
            $data['reports'] = $query->result();
            $data['countReport'] = 1;
        }
        else
        {
            $data['reports'] = 0;
            $data['countReport'] = 0;
        }

        $data['_view'] = 'basundhara/ppp_full_without_chitha_update_app';
        $this->load->view('layouts/main',$data);
    }


    // PPP partial payment
    public function pppPartialPaymentAppList()
    {
        $d=$this->session->userdata('dist_code');
        $s=$this->session->userdata('subdiv_code');
        $c=$this->session->userdata('cir_code');

        $query = $this->db->query("select distinct a.case_no,a.applid  from settlement_basic a join settlement_premium b
                      on a.case_no=b.case_no where dist_code='$d' and subdiv_code='$s' and cir_code='$c'
                      and b.grn_no is not null and  is_final=1 and due_amount>paid_amount");


        if($query->num_rows() != 0)
        {
            $data['reports'] = $query->result();
            $data['countReport'] = 1;
        }
        else
        {
            $data['reports'] = 0;
            $data['countReport'] = 0;
        }


        $data['_view'] = 'basundhara/ppp_partial_paid_app';
        $this->load->view('layouts/main',$data);
    }

    function settlementCasesCountCOReview(){
        $d=$this->session->userdata('dist_code');
        $s=$this->session->userdata('subdiv_code');
        $c=$this->session->userdata('cir_code');
        $this->session->unset_userdata('searchKeyword');
        $url = API_LINK_MB2."circleDashboardReview/$d/$s/$c" ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $output = curl_exec($ch);
        curl_close($ch);
        $district['output'] = json_decode($output);
        //var_dump($output);
        // exit;
        $district['_view'] = 'basundhara/settlement_cases_count_co_review';
        $this->load->view('layouts/main',$district);
    }

    function settlementCasesCountCOPerpetual(){
        $d=$this->session->userdata('dist_code');
        $s=$this->session->userdata('subdiv_code');
        $c=$this->session->userdata('cir_code');
        $this->session->unset_userdata('searchKeyword');
        $url = API_LINK_MB2."circleDashboardPerpetual/$d/$s/$c" ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $output = curl_exec($ch);
        curl_close($ch);
        $district['output'] = json_decode($output);
        //var_dump($output);
        // exit;
        $district['_view'] = 'basundhara/settlement_cases_count_co_perpetual';
        $this->load->view('layouts/main',$district);
    }


}

