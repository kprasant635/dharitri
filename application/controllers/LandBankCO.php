<?php 
class LandBankCO extends CI_Controller
 {
   public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('LandBank/LandBankCOModel');
        $this->load->model('LandBank/LandBankLMModel');
        $this->load->model('mutation/mutationmodel');
        $this->dbswitch();
   }

   //script-validation-callback
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

   //date-validation-callback
   function date_valid($date){
      if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)) 
         return false;
      
      $day = (int) substr($date, 8, 2);
      $month = (int) substr($date, 5, 2);
      $year = (int) substr($date, 0, 4);                        
      return checkdate($month, $day, $year);
   }

   //db switch method
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

   //location select form 
   public function index(){      
   //***************chechink-user-designation**********/
   if($this->session->userdata('user_desig_code') != "CO"){
      echo json_encode("Not Authorised..!, Please Login With CO's Credentials!");
      exit;
   }
   //**************************************************/         
   $data['pending_count'] = $this->LandBankCOModel->getPendingLbCount();      
   $data['approve_count'] = $this->LandBankCOModel->getApproveLbCount();      
   $data['_view'] = 'land_bank_co/index';
   $this->load->view('layouts/main',$data);
   }

   //displaying pending list for CO
   public function PendingList(){
   //***************chechink-user-designation**********/
   if($this->session->userdata('user_desig_code') != "CO"){
      echo json_encode("Not Authorised..!, Please Login With CO's Credentials!");
      exit;
   }
   //**************************************************/
   if ($this->input->server('REQUEST_METHOD') == 'POST') {
      $offset = $_POST['lbCoPageOffset'];
   }else{
      $offset = 0;
   }
   $data['dist_code'] = $dist_code = $_SESSION['credentials']["dist_code"];
   $data['subdiv_code'] = $subdiv_code = $_SESSION['credentials']["subdiv_code"];
   $data['circle_code'] = $cir_code = $_SESSION['credentials']["cir_code"];
   $uniqueVillageIdsInLandBankDetails = $this->LandBankCOModel->getUniqueVillageIdsInLandBankDetails($dist_code,$subdiv_code, $cir_code);      
   //creating dynamically the options for pagination 
   $total_pending_count = $this->LandBankCOModel->getPendingLbCount();
   if($total_pending_count <= $offset && $offset !=0){
      $offset = $offset-LAND_BANK_CO_PENDING_LIST_PAGINATION_LIMIT; 
   }
   $no_of_pagination_options = $total_pending_count/LAND_BANK_CO_PENDING_LIST_PAGINATION_LIMIT;
   if($no_of_pagination_options == 0){
      $no_of_pagination_options = 1;
      $offset = 0;
   }else{
      $whole = floor($no_of_pagination_options);    
      $fraction = $no_of_pagination_options - $whole;
      if($fraction > 0){
         $no_of_pagination_options = $whole+1;
      }
   }
   //******************************************
   $data['offset'] = $offset;
   $data['no_of_pagination_optinos'] = $no_of_pagination_options;
   $data['pending_list'] = $getLbPendingList = $this->LandBankCOModel->getLbPendingList($uniqueVillageIdsInLandBankDetails, $offset);
   $data['_view'] = 'land_bank_co/pending_list';
   $this->load->view('layouts/main',$data);
   }

   //approval handle of lb details
   public function landBankDetailsApprove(){
      //******************validation***************/
      $lb_approval_rmk_fields = [
            [
                'field' => 'lb_approve_rmk',
                'label' => 'Approval-Remark',
                'rules' => 'required|callback_check_script|max_length[200]|trim|xss_clean'
            ],
            [
                'field' => 'lb_approve_rmk_lb_details_id',
                'label' => 'Land-Bank-id',
                'rules' => 'required|callback_check_script|integer|trim|xss_clean'
            ],
      ];
      $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
      $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
      $this->form_validation->set_rules($lb_approval_rmk_fields);
      if ($this->form_validation->run() == FALSE)
      {            
         $error_msg = array();   
         foreach($lb_approval_rmk_fields as $rule){
               if (form_error($rule['field'])) {
                  array_push($error_msg, form_error($rule['field']));
               }
         }     
         echo json_encode(['result' => 'validation_error', 'msg'=>$error_msg]);     
         return;    
      }
      //******************validation***************/

      $lb_details_id = $_POST['lb_approve_rmk_lb_details_id'];
      $lb_approval_rmk = $_POST['lb_approve_rmk'];
      //varialbe set for deletion of encroacher in co login------
      $encroacher_id = $_POST['encroacher_id']; // all encraochers in comma separated field.
      $myArray = explode(',', $encroacher_id);
      $deleteStatus = 0;
      $lb_delete_rmk = $_POST['lb_delete_rmk'];
      $this->db->trans_begin();
      // if(!empty($myArray) && $myArray !='' && $myArray != null){
      if(!empty($_POST['encroacher_id']) && $_POST['encroacher_id'] !='' && $_POST['encroacher_id'] != null){
         
         if($lb_delete_rmk == null || $lb_delete_rmk == ''){
            echo json_encode(['result' => 'validation_error', 'msg'=>"Deletion Remark Required"]);     
            return; 
         }else{
            $deleteStatus = $this->LandBankCOModel->lbOldDataSaveAndDelete($lb_details_id, $lb_approval_rmk,$encroacher_id,$lb_delete_rmk);
            if($deleteStatus == 0){
               echo json_encode(['result' => false, 'msg' => 'Deletion Status Failed, Error-Code : #LBCO0098112U']);
               return;
            }
         }
      }
      // if($deleteStatus != 0 && $deleteStatus == 1){
         $approvalStatus = $this->LandBankCOModel->lbdetailsForwardedbyCO($lb_details_id, $lb_approval_rmk);
         if($approvalStatus['result'] == true){
            $this->db->trans_commit();
            echo json_encode($approvalStatus);
         }
         
      // }
      // $approvalStatus = $this->LandBankCOModel->lbdetailsApprove($lb_details_id, $lb_approval_rmk);
      
   }

   //revert handle of lb details 
   public function landBankDetailsRevert(){
      //******************validation***************/
      $lb_approval_rmk_fields = [
         [
             'field' => 'lb_revert_rmk',
             'label' => 'Revert-Remark',
             'rules' => 'required|callback_check_script|max_length[200]|trim|xss_clean'
         ],
         [
             'field' => 'lb_revert_rmk_lb_details_id',
             'label' => 'Land-Bank-id',
             'rules' => 'required|callback_check_script|integer|trim|xss_clean'
         ],
      ];
      $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
      $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
      $this->form_validation->set_rules($lb_approval_rmk_fields);
      if ($this->form_validation->run() == FALSE)
      {            
         $error_msg = array();   
         foreach($lb_approval_rmk_fields as $rule){
               if (form_error($rule['field'])) {
                  array_push($error_msg, form_error($rule['field']));
               }
         }     
         echo json_encode(['result' => 'validation_error', 'msg'=>$error_msg]);     
         return;    
      }
      //******************validation***************/
      $lb_details_id = $_POST['lb_revert_rmk_lb_details_id'];
      $lb_revert_rmk = $_POST['lb_revert_rmk'];
      $approvalStatus = $this->LandBankCOModel->lbdetailsReject($lb_details_id, $lb_revert_rmk);
      echo json_encode($approvalStatus);
   }

   //getting type of encraocher
   public function getTypeOfEncroacher(){
      echo TYPE_OF_ENCROACHER;
   }

   //getting lb data for view 
   public function getLbDataForView(){        
      $lb_details_id = $_POST['lb_details_id'];
      if(isset($_POST['flag']) && $_POST['flag'] == 'approve_list'){
          $lbDataFromId = $this->LandBankLMModel->getApprovedLbDataFromId($lb_details_id);    
      }else{
          $lbDataFromId = $this->LandBankLMModel->getLbDataFromId($lb_details_id);
      }

      $gender_list = $this->getGenderList();
      $caste_list = $this->getCasteList();
      $type_of_land_use = $this->getTypeOfLandUse();
      $type_of_encroacher = TYPE_OF_ENCROACHER;
      echo json_encode([$lbDataFromId, $gender_list, $caste_list, $type_of_land_use, $type_of_encroacher]);
   }

   //getting all the master table gender list
   public function getGenderList(){
      $gender_list = $this->LandBankLMModel->getAllGenderList();
      return $gender_list;
   }

   // getting all the master table caste list
   public function getCasteList(){
      $caste_list = $this->LandBankLMModel->getAllCasteList();
      return $caste_list;
   }

   //getting type of land use from constant file
   public function getTypeOfLandUse(){ 
      return LB_ENC_TYPE_OF_LAND_USE;
   }
   public function searchPendingListByDag(){
      //***************chechink-user-designation**********/
      if($this->session->userdata('user_desig_code') != "CO"){
         echo json_encode("Not Authorised..!, Please Login With CO's Credentials!");
         exit;
      }
      //**************************************************/
      if ($this->input->server('REQUEST_METHOD') == 'POST') {
         $search = $_POST['lbsearchdag'];
      }else{
         $search = 0;
      }
      $offset = $search;
      $data['dist_code'] = $dist_code = $_SESSION['credentials']["dist_code"];
      $data['subdiv_code'] = $subdiv_code = $_SESSION['credentials']["subdiv_code"];
      $data['circle_code'] = $cir_code = $_SESSION['credentials']["cir_code"];
      $uniqueVillageIdsInLandBankDetails = $this->LandBankCOModel->getUniqueVillageIdsInLandBankDetails($dist_code,$subdiv_code, $cir_code);      
      
      $total_pending_count = $this->LandBankCOModel->getPendingLbCount();
      if($total_pending_count <= $offset && $offset !=0){
         $offset = $offset-LAND_BANK_CO_PENDING_LIST_PAGINATION_LIMIT; 
      }
      $no_of_pagination_options = $total_pending_count/LAND_BANK_CO_PENDING_LIST_PAGINATION_LIMIT;
      if($no_of_pagination_options == 0){
         $no_of_pagination_options = 1;
         $offset = 0;
      }else{
         $whole = floor($no_of_pagination_options);    
         $fraction = $no_of_pagination_options - $whole;
         if($fraction > 0){
            $no_of_pagination_options = $whole+1;
         }
      }
      //******************************************
      $data['offset'] = $search;
      $data['no_of_pagination_optinos'] = $no_of_pagination_options;
      $data['pending_list'] = $getLbPendingList = $this->LandBankCOModel->getLbSearchPendingListByDag($uniqueVillageIdsInLandBankDetails, $search);
      $data['_view'] = 'land_bank_co/pending_list';
      $this->load->view('layouts/main',$data);
    }
    //displaying pending list for CO
    public function getApprovedList(){
      //***************chechink-user-designation**********/
      if($this->session->userdata('user_desig_code') != "CO"){
         echo json_encode("Not Authorised..!, Please Login With CO's Credentials!");
         exit;
      }
      //**************************************************/
      if ($this->input->server('REQUEST_METHOD') == 'POST') {
         $offset = $_POST['lbCoPageOffset'];
      }else{
         $offset = 0;
      }
      $data['dist_code'] = $dist_code = $_SESSION['credentials']["dist_code"];
      $data['subdiv_code'] = $subdiv_code = $_SESSION['credentials']["subdiv_code"];
      $data['circle_code'] = $cir_code = $_SESSION['credentials']["cir_code"];
      $uniqueVillageIdsInLandBankDetails = $this->LandBankCOModel->getUniqueVillageIdsInLandBankDetails($dist_code,$subdiv_code, $cir_code);      
      //creating dynamically the options for pagination 
      $total_pending_count = $this->LandBankCOModel->getApproveLbCount();
      if($total_pending_count <= $offset && $offset !=0){
         $offset = $offset-LAND_BANK_CO_PENDING_LIST_PAGINATION_LIMIT; 
      }
      $no_of_pagination_options = $total_pending_count/LAND_BANK_CO_PENDING_LIST_PAGINATION_LIMIT;
      if($no_of_pagination_options == 0){
         $no_of_pagination_options = 1;
         $offset = 0;
      }else{
         $whole = floor($no_of_pagination_options);    
         $fraction = $no_of_pagination_options - $whole;
         if($fraction > 0){
            $no_of_pagination_options = $whole+1;
         }
      }
      //******************************************
      $data['offset'] = $offset;
      $data['no_of_pagination_optinos'] = $no_of_pagination_options;
      $data['pending_list'] = $getLbPendingList = $this->LandBankCOModel->getLbApprovedList($uniqueVillageIdsInLandBankDetails, $offset);
      $data['_view'] = 'land_bank_co/co_approved_list';
      $this->load->view('layouts/main',$data);
    }
    public function searchApprovedListByDag(){
      //***************chechink-user-designation**********/
      if($this->session->userdata('user_desig_code') != "CO"){
         echo json_encode("Not Authorised..!, Please Login With CO's Credentials!");
         exit;
      }
      //**************************************************/
      if ($this->input->server('REQUEST_METHOD') == 'POST') {
         $search = $_POST['lbsearchdag'];
      }else{
         $search = 0;
      }
      $offset = $search;
      $data['dist_code'] = $dist_code = $_SESSION['credentials']["dist_code"];
      $data['subdiv_code'] = $subdiv_code = $_SESSION['credentials']["subdiv_code"];
      $data['circle_code'] = $cir_code = $_SESSION['credentials']["cir_code"];
      $uniqueVillageIdsInLandBankDetails = $this->LandBankCOModel->getUniqueVillageIdsInLandBankDetails($dist_code,$subdiv_code, $cir_code);      
       $total_pending_count = $this->LandBankCOModel->getApproveLbCount();
      if($total_pending_count <= $offset && $offset !=0){
         $offset = $offset-LAND_BANK_CO_PENDING_LIST_PAGINATION_LIMIT; 
      }
      $no_of_pagination_options = $total_pending_count/LAND_BANK_CO_PENDING_LIST_PAGINATION_LIMIT;
      if($no_of_pagination_options == 0){
         $no_of_pagination_options = 1;
         $offset = 0;
      }else{
         $whole = floor($no_of_pagination_options);    
         $fraction = $no_of_pagination_options - $whole;
         if($fraction > 0){
            $no_of_pagination_options = $whole+1;
         }
      }     
      //******************************************
      $data['offset'] = $search;
      $data['no_of_pagination_optinos'] = $no_of_pagination_options;
      $data['pending_list'] = $getLbPendingList = $this->LandBankCOModel->getLbSearchApprovedListByDag($uniqueVillageIdsInLandBankDetails, $search);
      $data['_view'] = 'land_bank_co/co_approved_list';
      $this->load->view('layouts/main',$data);
    }

   public function vlbDagDetails() {
         $dist_code = $this->session->userdata('dist_code');
         $subdiv_code = $this->session->userdata('subdiv_code');
         $cir_code = $this->session->userdata('cir_code');
         $dist_name = $this->utilityclass->getDistrictName($dist_code);
         $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
         $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
         $data['mouza'] = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
         $data['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name
         );
         $data['_view'] = 'vlb_dag_report';
         $this->load->view('layouts/main',$data);
    }

   public function findDagVillageWise(){
      $subdiv_code = $this->input->post('subdiv_code');
      $circle_code = $this->input->post('cir_code');
      $dist_code   = $this->input->post('dist_code');
      $mouza_pargona_code   = $this->input->post('mouza_pargona_code');
      $lot_no      = $this->input->post('lot_no');
      $vill_code   = $this->input->post('vill_code');
      $dag_no   = $this->input->post('dag_no');
      $data = array();
      $data['subdiv_code'] =$subdiv_code;
      $data['cir_code'] =$circle_code;
      $data['dist_code'] =$dist_code;
      $data['mouza_pargona_code'] =$mouza_pargona_code;
      $data['lot_no'] =$lot_no;
      $data['vill_code'] =$vill_code;
      $data['mouza_name'] = 'N/A';
      $data['lot_name'] = 'N/A';
      $data['vill_name'] = 'N/A';
      if($subdiv_code != null && $circle_code != null && $dist_code !=null && $mouza_pargona_code !=null && 
         $lot_no != null && $vill_code !=null){
         $data['mouza_name'] = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code);
         $data['lot_name'] = $this->utilityclass->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code,$lot_no);
         $data['vill_name'] = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code,$lot_no,$vill_code);
      }
      $patta = $this->db->query("select dag_no,nature_of_reservation,whether_encroached,en_area_b,en_area_k,en_area_lc,en_area_g,no_of_encroacher,status from land_bank_details where dag_no = ? and dist_code =? 
               and subdiv_code=? and cir_code=? and mouza_pargona_code=? and 
               lot_no=? and vill_townprt_code=? and application_no is null
         group by dag_no,nature_of_reservation,whether_encroached,en_area_b,en_area_k,en_area_lc,en_area_g,no_of_encroacher,status"
            , array($dag_no,$dist_code,$subdiv_code,$circle_code,$mouza_pargona_code,$lot_no,$vill_code));
      $dags = $patta->result();
      $data['dags'] = $dags;
      $this->load->view('vlb_dag_report_details', $data);
   }
    
}
