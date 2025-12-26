<?php 
class LandBankDC extends CI_Controller
 {
   public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('LandBank/LandBankDCModel');
        $this->load->model('LandBank/LandBankLMModel');
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
   if($this->session->userdata('user_desig_code') != "DC"){
      echo json_encode("Not Authorised..!, Please Login With DC's Credentials!");
      exit;
   }
   //**************************************************/         
   $data['pending_count'] = $this->LandBankDCModel->getPendingLbCount();
   $data['settlement_pending_count'] = $this->LandBankDCModel->getSettlementPendingLbCount();      
   $data['approve_count'] = $this->LandBankDCModel->getApproveLbCount();      
   $data['_view'] = 'land_bank_dc/index';
   $this->load->view('layouts/main',$data);
   }

   //displaying pending list for CO
   public function PendingListOld(){
   //***************chechink-user-designation**********/
   if($this->session->userdata('user_desig_code') != "DC"){
      echo json_encode("Not Authorised..!, Please Login With DC's Credentials!");
      exit;
   }
   //**************************************************/
   if ($this->input->server('REQUEST_METHOD') == 'POST') {
      $offset = $_POST['lbCoPageOffset'];
   }else{
      $offset = 0;
   }
   $data['dist_code'] = $dist_code = $_SESSION['credentials']["dist_code"];
   // $data['subdiv_code'] = $subdiv_code = $_SESSION['credentials']["subdiv_code"];
   // $data['circle_code'] = $cir_code = $_SESSION['credentials']["cir_code"];
   $uniqueVillageIdsInLandBankDetails = $this->LandBankDCModel->getUniqueVillageIdsInLandBankDetails($dist_code);      
   //creating dynamically the options for pagination 
   $total_pending_count = $this->LandBankDCModel->getPendingLbCount();
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
   $data['pending_list'] = $getLbPendingList = $this->LandBankDCModel->getLbPendingList($uniqueVillageIdsInLandBankDetails, $offset);
   $data['_view'] = 'land_bank_dc/pending_list';
   $this->load->view('layouts/main',$data);
   }

      //displaying pending list for DC
   public function PendingList(){
   //***************chechink-user-designation**********/
   if($this->session->userdata('user_desig_code') != "DC"){
      echo json_encode("Not Authorised..!, Please Login With DC's Credentials!");
      exit;
   }
   //**************************************************/
   if ($this->input->server('REQUEST_METHOD') == 'POST') {
      $offset = $_POST['lbCoPageOffset'];
   }else{
      $offset = 0;
   }
   $data['dist_code'] = $dist_code = $_SESSION['credentials']["dist_code"];
   // $data['subdiv_code'] = $subdiv_code = $_SESSION['credentials']["subdiv_code"];
   // $data['circle_code'] = $cir_code = $_SESSION['credentials']["cir_code"];
   // $uniqueVillageIdsInLandBankDetails = $this->LandBankDCModel->getUniqueVillageIdsInLandBankDetails($dist_code); 
   $VillageIds = $this->LandBankDCModel->getAllPendingVillageUUID($dist_code); 
   $data['villageList'] = $VillageIds;
   //listing all circle and subdiv code for search ----------
   $circleSubDivArray = $this->LandBankDCModel->getSubDivCircleList($dist_code);
   $circleList = array();
   foreach ($circleSubDivArray as $key => $circle) {
      $circleList[$key]['circleName'] = $this->utilityclass->getCircleName($dist_code, $circle->subdiv_code,$circle->cir_code);
      $circleList[$key]['subdiv_code'] = $circle->subdiv_code;
      $circleList[$key]['cir_code'] = $circle->cir_code;
   }
   $data['circleList'] = $circleList;
   $data['circleSubDivDagsArray'] = $this->LandBankDCModel->getSubDivCircleDagsList($dist_code);
   //creating dynamically the options for pagination 
   $total_pending_count = $this->LandBankDCModel->getPendingLbCount();
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
   // $data['pending_list'] = $getLbPendingList = $this->LandBankDCModel->getLbPendingList($uniqueVillageIdsInLandBankDetails, $offset);
   $data['_view'] = 'land_bank_dc/pending_list';
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
      $encroacher_id_dc = $_POST['encroacher_id_dc']; // all encraochers in comma separated field.
      $myArray = explode(',', $encroacher_id_dc);
      $deleteStatus = 0;
      $lb_delete_rmk_dc = $_POST['lb_delete_rmk_dc'];
      $this->db->trans_begin();
      if(!empty($_POST['encroacher_id_dc']) && $_POST['encroacher_id_dc'] !='' && $_POST['encroacher_id_dc'] != null){
         
         if($lb_delete_rmk_dc == null || $lb_delete_rmk_dc == ''){
            echo json_encode(['result' => 'validation_error', 'msg'=>"Deletion Remark Required"]);    
            return; 
         }else{
            $deleteStatus = $this->LandBankDCModel->lbOldDataSaveAndDeleteDC($lb_details_id,$encroacher_id_dc,$lb_delete_rmk_dc);
            if($deleteStatus == 0){
               echo json_encode(['result' => false, 'msg' => 'Deletion Status Failed, Error-Code : #LBCO0098112U']);
               return;
            }
         }
      }
      
      // if($deleteStatus != 0 && $deleteStatus == 1){
         $approvalStatus = $this->LandBankDCModel->lbdetailsApprove($lb_details_id, $lb_approval_rmk);
         if($approvalStatus['result'] == true){
            $this->db->trans_commit();
            echo json_encode($approvalStatus);
         }
      // }
      
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
      $approvalStatus = $this->LandBankDCModel->lbdetailsReject($lb_details_id, $lb_revert_rmk);
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
      if($this->session->userdata('user_desig_code') != "DC"){
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
      $uniqueVillageIdsInLandBankDetails = $this->LandBankDCModel->getUniqueVillageIdsInLandBankDetails($dist_code);      
      
      $total_pending_count = $this->LandBankDCModel->getPendingLbCount();
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
      $data['pending_list'] = $getLbPendingList = $this->LandBankDCModel->getLbSearchPendingListByDag($uniqueVillageIdsInLandBankDetails, $search);
      $data['_view'] = 'land_bank_dc/pending_list';
      $this->load->view('layouts/main',$data);
    }
    //displaying pending list for CO
    public function getApprovedList(){
      //***************chechink-user-designation**********/
      if($this->session->userdata('user_desig_code') != "DC"){
         echo json_encode("Not Authorised..!, Please Login With DC's Credentials!");
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
      $uniqueVillageIdsInLandBankDetails = $this->LandBankDCModel->getUniqueVillageIdsInLandBankDetails($dist_code,$subdiv_code, $cir_code);      
      //creating dynamically the options for pagination 
      $total_pending_count = $this->LandBankDCModel->getApproveLbCount();
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
      $data['pending_list'] = $getLbPendingList = $this->LandBankDCModel->getLbApprovedList($uniqueVillageIdsInLandBankDetails, $offset);
      // $data['_view'] = 'land_bank_dc/co_approved_list';
      $data['_view'] = 'land_bank_dc/dc_approved_list';
      $this->load->view('layouts/main',$data);
    }
    public function searchApprovedListByDag(){
      //***************chechink-user-designation**********/
      if($this->session->userdata('user_desig_code') != "DC"){
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
      $uniqueVillageIdsInLandBankDetails = $this->LandBankDCModel->getUniqueVillageIdsInLandBankDetails($dist_code,$subdiv_code, $cir_code);      
       $total_pending_count = $this->LandBankDCModel->getApproveLbCount();
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
      $data['pending_list'] = $getLbPendingList = $this->LandBankDCModel->getLbSearchApprovedListByDag($uniqueVillageIdsInLandBankDetails, $search);
      // $data['_view'] = 'land_bank_dc/co_approved_list';
      $data['_view'] = 'land_bank_dc/dc_approved_list';
      $this->load->view('layouts/main',$data);
    }

   public function getCORemarks(){        
      $lb_details_id = $_POST['lb_details_id'];
      if(isset($lb_details_id)){
         $remarks = $this->LandBankDCModel->getAllRemarks($lb_details_id); 
      }
      echo json_encode([$remarks]);
   }
   //created for getting all the pending list at DC login circle wise---------
   public function viewPendingCasesDC(){
            $dist_code =$this->session->userdata('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $cir_code = $this->input->post('cir_code');
            $dags = $this->input->post('dags');
            $draw = intval($this->input->post('draw'));
            $start = intval($this->input->post('start'));
            $length = intval($this->input->post('length'));
            $order = $this->input->post('order');
            $village_code = $this->input->post('village_code');
            $results = $this->LandBankDCModel->getPendingCasesInDC($dist_code,$start,$length,$order,$subdiv_code,$cir_code,$dags,$village_code);
            // if($cir_code){
            //    $villageList=$this->villageListDc($subdiv_code,$cir_code);
            // }
            if(isset($results)){
            $data_rows = $results['data_results'];
                foreach($data_rows as $rows){
                  $view_link = '<button type="button" class="btn btn-success btn-sm text-white" onclick="lbViewModalByDC('.$rows->id.')">
                                            <i class="fa fa-eye"></i>
                                            View & Approved
                                        </button>';
                  $co_remarks = '<button type="button" class="btn btn-primary btn-sm text-white" onclick="lbViewCORemarkModalByDC('.$rows->id.')">
                                            <i class="fa fa-eye"></i>
                                            CO Remarks
                                        </button>';
                  // $approved = '<button type="button" class="btn btn-success btn-sm text-white" onclick="lbApproveByDC('.$rows->id.', '.$rows->dag_no.')">
                  //                           <i class="fa fa-check"></i>
                  //                           Approved
                  //                       </button>';
                  $rejected = '<button type="button" class="btn btn-danger btn-sm text-white" onclick="lbRejectByDC('.$rows->id.','.$rows->dag_no.')">
                                            <i class="fa fa-arrow-left"></i>
                                            Reject
                                        </button>';
                  $village = $this->utilityclass->getVillageName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code,$rows->lot_no,$rows->vill_townprt_code);
                    $json[] = array(
                        $this->utilityclass->getCircleName($dist_code, $rows->subdiv_code,$rows->cir_code),
                        "<span id='lb_view_village_name_".$rows->id."'>".$village."</span>",
                        "<span id='lb_view_dag_no_".$rows->id."'>".$rows->dag_no."</span>",
                        $this->utilityclass->getDefinedMondalsName($rows->dist_code, $rows->subdiv_code, 
                                            $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no,$rows->user_code)->lm_name,
                        date('d-m-Y H:i:s',strtotime($rows->created_at)),
                        $view_link,
                        $co_remarks,
                        // $approved,
                        $rejected
                    );
                }
                $total_records = $results['total_records'];
                $response = array(
                    'draw'              => $draw,
                    'recordsTotal'      => $total_records,
                    'recordsFiltered'   => $total_records,
                    'data'              => $json,
                    //'village'          =>$villageList
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
        function villageListDc(){
         $subdiv=$this->input->post('subdiv_code');
         $circle=$this->input->post('cir_code');
         $sql="Select uuid as village_uuid,loc_name from location where subdiv_code=? and cir_code=? and vill_townprt_code!='00000'";
         $data=$this->db->query($sql,array($subdiv,$circle))->result();
         echo json_encode($data);
        }
    
}
