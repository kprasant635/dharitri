<?php 
use Shuchkin\SimpleXLSX;
require_once APPPATH.'/../system/libraries/SimpleXLSX.php';
class LandBankLM extends CI_Controller
 {
     public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('LandBank/LandBankCOModel');
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

    //getting all the master table gender list
    public function getGenderList(){
        $gender_list = $this->LandBankLMModel->getAllGenderList();
        echo $gender_list;
    }

    // getting all the master table caste list
    public function getCasteList(){
        $caste_list = $this->LandBankLMModel->getAllCasteList();
        echo $caste_list;
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

    //getting the index page for LM 
    public function index(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "LM"){
            echo json_encode("Not Authorised..!, Please Login With LM's Credentials!");
            exit;
        }
        //**************************************************/      
        $data['dist_code'] = $dist_code = $_SESSION['credentials']["dist_code"];
        $data['subdiv_code'] = $subdiv_code = $_SESSION['credentials']["subdiv_code"];
        $data['circle_code'] = $cir_code = $_SESSION['credentials']["cir_code"];
        $data['mouza_code'] = $mouza_code = $_SESSION['credentials']["mouza_pargona_code"];
        $data['lot_no'] = $lot_no = $_SESSION['credentials']["lot_no"];               
        //**************************************************/    
        // $totalGovtDagLotWise = $this->LandBankLMModel->getLotWiseTotalGovtDagCount($dist_code, $subdiv_code,
        // $cir_code, $mouza_code, $lot_no);
        //**************************************************/    
        $data['pending_count'] = $pending_count = $this->LandBankLMModel->getPendingLbCount($dist_code, $subdiv_code,
        $cir_code, $mouza_code, $lot_no);
        //**************************************************/    
        $lb_entries_count = $this->LandBankLMModel->getDagCountFromLb($dist_code, $subdiv_code,
        $cir_code, $mouza_code, $lot_no);
        $data['update_count'] = (int)$lb_entries_count-(int)$pending_count; 
        //**************************************************/    
        // count of dags which are not approved and rejected in first entry 
        // $rejectedWithoutApproveCount = $this->LandBankLMModel->getRejectedWithoutApproveCount($dist_code, $subdiv_code,
        // $cir_code, $mouza_code, $lot_no);
        //**************************************************/    
        // count of dags which are in chitha but not in c land bank details 
        $overallPendingCount = $this->LandBankLMModel->getOverallPendingCount($dist_code, $subdiv_code,
        $cir_code, $mouza_code, $lot_no);
        //**************************************************/    
        // to be newly added dags for lm 
        // $add_count = (int)$totalGovtDagLotWise-(int)$lb_entries_count+(int)$rejectedWithoutApproveCount;
        $add_count = (int)$overallPendingCount - (int)$pending_count;
        if($add_count < 0){
            $data['add_count'] = 0;
        }else{
            $data['add_count'] = $add_count;
        }
        $data['vgrPendingCount'] = $this->LandBankLMModel->getVgrPendingCount($dist_code, $subdiv_code,
        $cir_code, $mouza_code, $lot_no);
        $data['pgrPendingCount'] = $this->LandBankLMModel->getPgrPendingCount($dist_code, $subdiv_code,
        $cir_code, $mouza_code, $lot_no);
        //**************************************************/    
        $data['approved_count'] = $lbApprovedCount = $this->LandBankLMModel->getLbApprovedCount($dist_code, $subdiv_code,
        $cir_code, $mouza_code, $lot_no);
        $data['rejected_count'] = $this->LandBankLMModel->getLbRejectedCount($dist_code, $subdiv_code,
        $cir_code, $mouza_code, $lot_no);
        $data['_view'] = 'land_bank_lm/index';
        $this->load->view('layouts/main',$data);
    }

    //getting the village list for lm where land bank 
    //details can be added or updated
    public function VillageList(){        
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "LM"){
            echo json_encode("Not Authorised..!, Please Login With LM's Credentials!");
            exit;
        }
        //**************************************************/
        $data['flag'] = $_GET['flag'];
        $data['dist_code'] = $dist_code = $_SESSION['credentials']["dist_code"];
        $data['subdiv_code'] = $subdiv_code = $_SESSION['credentials']["subdiv_code"];
        $data['circle_code'] = $cir_code = $_SESSION['credentials']["cir_code"];
        $data['mouza_code'] = $mouza_pargona_code = $_SESSION['credentials']["mouza_pargona_code"];
        $data['lot_no'] = $lot_no = $_SESSION['credentials']["lot_no"];
        $villageListWithGovtDaag = $this->LandBankLMModel->getVillageListWithGovtDaag($dist_code, 
        $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $data['flag']);
        $data['villageList'] = $villageListWithGovtDaag;
        $data['_view'] = 'land_bank_lm/village_list';
        $this->load->view('layouts/main',$data);
    }

    //getting all the dag list of the selected village
    public function DagList($villageCode){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "LM"){
            echo json_encode("Not Authorised..!, Please Login With LM's Credentials!");
            exit;
        }
        //**************************************************/
        $data['flag'] = $_GET['flag'];
        $data['dist_code'] = $dist_code = $_SESSION['credentials']["dist_code"];
        $data['subdiv_code'] = $subdiv_code = $_SESSION['credentials']["subdiv_code"];
        $data['circle_code'] = $cir_code = $_SESSION['credentials']["cir_code"];
        $data['mouza_code'] = $mouza_code = $_SESSION['credentials']["mouza_pargona_code"];
        $data['lot_no'] = $lot_no = $_SESSION['credentials']["lot_no"];
        $data['vill_code'] = $vill_code = $villageCode;
        $data['land_details'] = $land_details = $this->LandBankLMModel->getLandDetails($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no,$vill_code);
        $data['_view'] = 'land_bank_lm/dag_list';
        $this->load->view('layouts/main',$data);
    }

    //getting the lm update details modal
    public function getLandBankDetailsForUpdate(){
        $gender_list = $this->LandBankLMModel->getAllGenderList();
        $caste_list = $this->LandBankLMModel->getAllCasteList();
        $type_of_land_use = LB_ENC_TYPE_OF_LAND_USE;
        $type_of_encroacher = TYPE_OF_ENCROACHER;
        $dist_code = $_SESSION['credentials']["dist_code"];
        $subdiv_code = $_SESSION['credentials']["subdiv_code"];
        $cir_code = $_SESSION['credentials']["cir_code"];
        $mouza_code = $_SESSION['credentials']["mouza_pargona_code"];
        $lot_no = $_SESSION['credentials']["lot_no"];
        $vill_code = $_POST['vill_code'];
        $dag_no = trim($_POST['lb_lm_update_form_dag_no']);
        $lbLmUpdateFormDetails = $this->LandBankLMModel->getLbLmUpdateFormDetails($dist_code, 
        $subdiv_code, $cir_code, $mouza_code, $lot_no, $vill_code, $dag_no);
        echo json_encode([$lbLmUpdateFormDetails, $gender_list, $caste_list, $type_of_land_use, $type_of_encroacher]);
    }   

    //checking encroiacher file entries
    public function getFileEncroacherList($file_name_with_location, $no_of_encroacher_in_encroacher_file){

        $error_msg = array();
        $encroacher_in_excel_file_arr = array();
        //parsing
        if ( $xlsx = SimpleXLSX::parse($file_name_with_location) ) {
            $rows = $xlsx->rows();
            unset($rows[0]);
        } else {
            log_message("error", "#LBEF001, Encroacher Excel File Parsing Error Msg : ".json_encode(SimpleXLSX::parseError()));
            echo json_encode(
                [   'result' => 'logical_validation_error', 
                    'msg' => "No Of Encroacher in Encroacher File Format Not Matched..!, Please Enter No Of Encroacher Correctly..!", 
                ]);                    
            exit;
        }   
        //validation and creating array        
        for ($i = 1; $i <= $no_of_encroacher_in_encroacher_file; $i++) {
            //gender
            $gender_in_enc_file = $rows[$i][2];
            $gender = explode(')', (explode('(', $gender_in_enc_file)[1]))[0];
            //encroached from            
            $encroached_from_in_enc_file = $rows[$i][3];
            $encroached_from = explode(" ", $encroached_from_in_enc_file)[0];
            //encroached to 
            $encroached_to_in_enc_file = $rows[$i][4];
            $encroached_to = explode(" ", $encroached_to_in_enc_file)[0];
            if($encroached_from_in_enc_file == $encroached_to_in_enc_file){
                log_message("error", "#LBEF002, From Date And To Date Are Same.!");
                echo json_encode(
                    [   'result' => 'logical_validation_error', 
                        'msg' => "From date and to date are same for line no ". $i. " in excel file..please correctly add the encroachment dates..!", 
                    ]);                    
                exit;
            }
            //to-do-encroached from and to checking
            //landless indigenous
            $landless_indigenous_in_enc_file = $rows[$i][5];
            $landless_indigenous = explode(')', (explode('(', $landless_indigenous_in_enc_file)[1]))[0];
            //landless
            $landless_in_enc_file = $rows[$i][6];
            $landless = explode(')', (explode('(', $landless_in_enc_file)[1]))[0];
            //caste
            $caste_in_enc_file = $rows[$i][7];
            $caste = explode(')', (explode('(', $caste_in_enc_file)[1]))[0];
            //erosion
            $erosion_in_enc_file = $rows[$i][8];
            $erosion = explode(')', (explode('(', $erosion_in_enc_file)[1]))[0];
            //landslide
            $landslide_in_enc_file = $rows[$i][9];
            $landslide = explode(')', (explode('(', $landslide_in_enc_file)[1]))[0];
            //type of land use 
            $type_of_land_use_in_enc_file = $rows[$i][10];
            $type_of_land_use = explode(')', (explode('(', $type_of_land_use_in_enc_file)[1]))[0];
            //type of encroacher 
            $type_of_encroacher_in_excel_file = $rows[$i][11];
            $type_of_encroacher = explode(')', (explode('(', $type_of_encroacher_in_excel_file)[1]))[0];
            //validation 
            $_POST['v_name'] = $rows[$i][0];
            $_POST['v_fathers_name'] = $rows[$i][1];
            $_POST['v_gender'] = $gender;
            $_POST['v_encroachment_from'] = $encroached_from;
            $_POST['v_encroachment_to'] = $encroached_to;
            $_POST['v_landless_indigenous'] = $landless_indigenous;
            $_POST['v_landless'] = $landless;                
            $_POST['v_caste'] = $caste;
            $_POST['v_erosion'] = $erosion;
            $_POST['v_landslide'] = $landslide;
            $_POST['v_type_of_land_use'] = $type_of_land_use;
            $_POST['v_type_of_encroacher'] = $type_of_encroacher;

            $lb_enc_val = [
                [
                    'field' => 'v_name',
                    'label' => 'Encroacher Name In Excel File, (Row-'.$i .')',
                    'rules' => 'required|callback_check_script|max_length[50]|trim|xss_clean'
                ],
                [
                    'field' => 'v_fathers_name',
                    'label' => 'Encroacher Father Name In Excel File,(Row-'.$i .')',
                    'rules' => 'required|callback_check_script|max_length[50]|trim|xss_clean'
                ],
                [
                    'field' => 'v_gender',
                    'label' => 'Gender In Excel File, (Row-'.$i.')',
                    'rules' => 'required|callback_check_script|less_than_equal_to[3]|numeric|trim|xss_clean'
                ],
                [
                    'field' => 'v_encroachment_from',
                    'label' => 'Encroacher From date (YYYY-MM-DD) In Excel File, (Row-'.$i .')',
                    'rules' => 'required|callback_check_script|callback_date_valid|trim|xss_clean'
                ],
                [
                    'field' => 'v_encroachment_to',
                    'label' => 'Encroacher To date (YYYY-MM-DD) In Excel File, (Row-'.$i .')',
                    'rules' => 'required|callback_check_script|callback_date_valid|trim|xss_clean'
                ],
                [
                    'field' => 'v_landless_indigenous',
                    'label' => 'Landless Indigenous In Excel File, (Row-'.$i .')',
                    'rules' => 'required|callback_check_script|exact_length[1]|trim|xss_clean'
                ],
                [
                    'field' => 'v_landless',
                    'label' => 'Landless In Excel File, (Row-'.$i .')',
                    'rules' => 'required|callback_check_script|exact_length[1]|trim|xss_clean'
                ],                    
                [
                    'field' => 'v_caste',
                    'label' => 'Caste In Excel File, (Row-'.$i .')',
                    'rules' => 'required|callback_check_script|less_than_equal_to[6]|trim|xss_clean'
                ],
                [
                    'field' => 'v_erosion',
                    'label' => 'Erosion In Excel File, (Row-'.$i .')',
                    'rules' => 'required|callback_check_script|exact_length[1]|trim|xss_clean'
                ],
                [
                    'field' => 'v_landslide',
                    'label' => 'Landslide In Excel File, (Row-'.$i .')',
                    'rules' => 'required|callback_check_script|exact_length[1]|trim|xss_clean'
                ],
                [
                    'field' => 'v_type_of_land_use',
                    'label' => 'Type Of Land Use In Excel File, (Row-'.$i .')',
                    'rules' => 'required|callback_check_script|less_thank[6]|trim|xss_clean'
                ],
                [
                    'field' => 'v_type_of_encroacher',
                    'label' => 'Type Of Encroacher In Excel File, (Row-'.$i .')',
                    'rules' => 'required|callback_check_script|less_thank[6]|trim|xss_clean'
                ],
            ];
            $this->form_validation->set_rules($lb_enc_val);
            $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
            $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
            if ($this->form_validation->run() == FALSE)
            {               
                foreach($lb_enc_val as $rule){
                    if (form_error($rule['field'])) {
                        array_push($error_msg, form_error($rule['field']));
                    }
                }              
            }

            array_push($encroacher_in_excel_file_arr, [
                'name' => $rows[$i][0],
                'fathers_name' => $rows[$i][1],
                'gender' => $gender,
                'encroachment_from' => $encroached_from,
                'encroachment_to' => $encroached_to,
                'landless_indigenous' => $landless_indigenous,
                'landless' => $landless,
                'caste' => $caste,
                'erosion' => $erosion,
                'landslide' => $landslide,
                'type_of_land_use' => $type_of_land_use,
                'type_of_encroacher' => $type_of_encroacher,
                'created_at' => date('Y-m-d H:i:s'),  
            ]);
        }
        //pushing the data to $_POST for backup
        $_POST['excel_file_encroacher_list'] = array();
        array_push($_POST['excel_file_encroacher_list'],$encroacher_in_excel_file_arr);
        if(count($error_msg) != 0){
            return (['result' => 'validation_error', 'msg' => $error_msg]);
        }else{
            return (['result' => 'success', 'excel_enc_arr' => $encroacher_in_excel_file_arr]);
        }
    }

    //land bank details upadte -- working 
    public function landBankDetailsUpdate(){
        //********************************************/
        //browser cache clear alerts from server
        //to-do for excel alerts
        // for concurrent operation restriction 
        if(!isset($_POST['lb_lm_update_form_prev_data_exists_flag'])){
            echo json_encode(
                [   'result' => 'logical_validation_error', 
                    'msg' => "Some Changes Has Been Added, Please Clear Cache Of the Browser(Control+Shift+r)!!" 
                ]);                    
            exit;
        }
        //******************encroacher-excel-file-handle***************/       
        if(isset($_FILES['encoracher_list_file']) && !$_FILES['encoracher_list_file']['error'] == UPLOAD_ERR_NO_FILE) {                        
            $info = pathinfo($_FILES['encoracher_list_file']['name']);
            //checking filename 
            if($info['filename'] != LAND_BANK_ENCROACHER_EXCEL_FORMAT_FILE_NAME){
                echo json_encode(
                    [   'result' => 'logical_validation_error', 
                        'msg' => "Encroacher File Name Not Matched..! File name should be ".LAND_BANK_ENCROACHER_EXCEL_FORMAT_FILE_NAME.".xlsx, Please Use the proper excerl file..!", 
                    ]);                    
                exit;
            }
            //checking file extension 
            if($info['extension'] != 'xlsx'){
                echo json_encode(
                    [   'result' => 'logical_validation_error', 
                        'msg' => "Encroacher File Format Not Matched..!, Please Use the proper excerl file..!", 
                    ]);                    
                exit;
            }
            //checking no of encroacher value with encroacher list
            if($_POST['no_of_encoracher_in_file'] == "" || $_POST['no_of_encoracher_in_file'] < 1){
                echo json_encode(
                    [   'result' => 'logical_validation_error', 
                        'msg' => "No Of Encroacher in Encroacher File Format Not Given Properly..!, Please Enter No Of Encroacher..!", 
                    ]);                    
                exit;
            }
            //saving the file
            $last_id = $this->LandBankLMModel->getLastLbInsertedId();
            $file_name = "enc_excel_file_".$_POST['dist_code']."_".$_POST['subdiv_code']."_".$_POST['circle_code']."_".$_POST['mouza_code']."_".$_POST['lot_no']."_".$_POST['vill_code']."_".$_POST['lb_lm_update_form_dag_no']."_".$last_id;
            $file_name_with_location = LAND_BANK_ENCROACHER_EXCEL_FORMAT_FILE_UPLOAD_LOCATION.$file_name.".".$info['extension']; 
            move_uploaded_file( $_FILES['encoracher_list_file']['tmp_name'], $file_name_with_location);            
            $encroacher_list_in_file = $this->getFileEncroacherList($file_name_with_location,$_POST['no_of_encoracher_in_file']);
            if($encroacher_list_in_file['result'] == "validation_error"){
                echo json_encode(['result' => 'validation_error', 'msg' => $encroacher_list_in_file['msg']]);
                exit;
            }else{
                $encroacher_list_excel_file_arr = $encroacher_list_in_file['excel_enc_arr'];
            }
        }else{
            $encroacher_list_excel_file_arr = [];
        }
        //*************************************************************/
        //*******************Validation-Start******************/  

        /** Edited by manashjyoti Deka 13-03-25 Start */
        $lb_lm_update_nature_of_reservation_temp=$_POST['lb_lm_update_nature_of_reservation'];
        // if(!($lb_lm_update_nature_of_reservation_temp==1 || $lb_lm_update_nature_of_reservation_temp==2  || $lb_lm_update_nature_of_reservation_temp==10  || $lb_lm_update_nature_of_reservation_temp==11 )){
        //     //Not For 1: VGR, 2: PGR, 10: UNRESERVED, 11: PATTALAND
        //     $_POST['lb_lm_update_form_Is_Institute_flag']="";
        // }
        // if( $_POST['lb_lm_update_form_Is_Institute_flag']=="Y"){
        //     // Write code to Check `lb_lm_update_form_type_of_land_use[]`

        // }

        /** Edited by manashjyoti Deka 13-03-25 end*/


        if($_POST['lb_lm_update_form_whether_encroached'] == 'N'){
            $_POST['lb_lm_update_details_form_no_of_encroacher'] = 0;
        }
        $dis_code = $_POST['v_dist_code'] = $_POST['dist_code'];
        $subdiv_code = $_POST['v_subdiv_code'] = $_POST['subdiv_code'];
        $circle_code = $_POST['v_cir_code'] = $_POST['circle_code'];
        $mouza_code = $_POST['v_mouza_pargona_code'] = $_POST['mouza_code'];
        $lot_no = $_POST['v_lot_no'] = $_POST['lot_no'];
        $vill_code = $_POST['v_vill_townprt_code'] = $_POST['vill_code'];
        $dag_no =$_POST['v_dag_no'] = $_POST['lb_lm_update_form_dag_no'];
        $_POST['v_nature_of_reservation'] = $_POST['lb_lm_update_nature_of_reservation'];
        /////////////////////
        if($_POST['v_nature_of_reservation']==9){
            $status_type=$this->CheckGramDagTrue($dis_code,$subdiv_code,$circle_code,$mouza_code,$lot_no,$vill_code,$dag_no);
            if($status_type===FALSE || $status_type==FALSE){
                echo json_encode(
                    [   'result' => 'logical_validation_error', 
                        'msg' => "You are not Allowed to Enter GRAMDAN-BHUDAN DAG. Please Check Chitha of this Dag", 
                    ]);                    
                exit;
            }
        }
        $lbRsv = $_POST['v_nature_of_reservation'];

        $status_type_check_details=$this->checkPattaLandandCheckUnderPattaLandorNot($dis_code,$subdiv_code,$circle_code,$mouza_code,$lot_no,$vill_code,$dag_no,$lbRsv);
        if($status_type_check_details===FALSE || $status_type_check_details==FALSE){
            echo json_encode(
                [   'result' => 'logical_validation_error', 
                    'msg' => "#ERROR You are not Allowed to Enter PATTA-LAND DAG. Please Check Chitha of this Dag", 
                ]);                    
            exit;
        }

        if($_POST['v_nature_of_reservation']==11){
            $status_type_check=$this->checkPattaLandOrNot($dis_code,$subdiv_code,$circle_code,$mouza_code,$lot_no,$vill_code,$dag_no);
            if($status_type_check===FALSE || $status_type_check==FALSE){
                echo json_encode(
                    [   'result' => 'logical_validation_error', 
                        'msg' => "You are not Allowed to Enter PATTA-LAND DAG. Please Check Chitha of this Dag", 
                    ]);                    
                exit;
            }
        }

        if($_POST['v_nature_of_reservation']==12){
            $status_type_tea_check=$this->checkTeaLandOrNot($dis_code,$subdiv_code,$circle_code,$mouza_code,$lot_no,$vill_code,$dag_no);
            if($status_type_tea_check===FALSE || $status_type_tea_check==FALSE){
                echo json_encode(
                    [   'result' => 'logical_validation_error', 
                        'msg' => "You are not Allowed to Enter TEA-PERIODIC-PATTA DAG. Please Check Chitha of this Dag", 
                    ]);                    
                exit;
            }
        }

        if(!isset($_POST['lb_lm_update_form_Is_Institute_flag']))
        {
            echo json_encode(
                [   'result' => 'logical_validation_error', 
                    'msg' => "Whether dag is flag for institute is not selected... please check the form properly", 
                ]);                    
            exit;
        }
        $_POST['v_whether_encroached'] = $_POST['lb_lm_update_form_whether_encroached'];      
        $_POST['v_Institute_flag'] = $_POST['lb_lm_update_form_Is_Institute_flag']; // Added by Manashjyoti Deka on 13-03-2025       
        $_POST['v_no_of_encroachers_lm_update_form'] = $_POST['lb_lm_update_details_form_no_of_encroacher'];
        $_POST['v_longitude'] = $_POST['lb_lm_update_form_longitude'];
        $_POST['v_latitude'] = $_POST['lb_lm_update_form_latitude'];
        $_POST['v_prev_data_flag'] = $_POST['lb_lm_update_form_prev_data_exists_flag'];
        $error_msg = array();
        $lb_lm_update_form_val = [
            [
                'field' => 'v_dist_code',
                'label' => 'District-Code',
                'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
            ],
            [
                'field' => 'v_subdiv_code',
                'label' => 'Sub-Division-Code',
                'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
            ],
            [
                'field' => 'v_cir_code',
                'label' => 'Circle-Code',
                'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
            ],
            [
                'field' => 'v_mouza_pargona_code',
                'label' => 'Mouza Pargona Code',
                'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
            ],
            [
                'field' => 'v_lot_no',
                'label' => 'Lot-No',
                'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
            ],
            [
                'field' => 'v_vill_townprt_code',
                'label' => 'Village-Code',
                'rules' => 'required|callback_check_script|max_length[5]|trim|xss_clean'
            ],
            [
                'field' => 'v_dag_no',
                'label' => 'Dag-No',
                'rules' => 'required|callback_check_script|max_length[12]|trim|xss_clean'
            ],
            [
                'field' => 'v_nature_of_reservation',
                'label' => 'Type-Of-Govt-Land',
                'rules' => 'required|callback_check_script|less_than[15]|trim|xss_clean'
            ],
            [
                'field' => 'v_whether_encroached',
                'label' => 'Whether-Encroached',
                'rules' => 'required|callback_check_script|exact_length[1]|trim|xss_clean'
            ],
            [
                'field' => 'v_longitude',
                'label' => 'Longitude',
                'rules' => 'callback_check_script|numeric|trim|xss_clean'
            ],
            [
                'field' => 'v_latitude',
                'label' => 'Latitude',
                'rules' => 'callback_check_script|numeric|trim|xss_clean'
            ],
            [
                'field' => 'v_no_of_encroachers_lm_update_form',
                'label' => 'No-Of-Encroacher',
                'rules' => 'integer|trim|xss_clean'
            ],
            [
                'field' => 'v_prev_data_flag',
                'label' => 'Previous-Data-Flag',
                'rules' => 'required|exact_length[1]|trim|xss_clean'
            ],
            [
                'field' => 'lb_lm_update_form_last_approval_time',
                'label' => 'Last-Approval-Time',
                'rules' => 'required|trim|xss_clean'
            ],
            [
                'field' => 'v_Institute_flag',
                'label' => 'Whether flag for institute',
                'rules' => 'required|trim|xss_clean'
            ],
        ];
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        $this->form_validation->set_rules($lb_lm_update_form_val);
        if ($this->form_validation->run() == FALSE)
        {               
            foreach($lb_lm_update_form_val as $rule){
                if (form_error($rule['field'])) {
                    array_push($error_msg, form_error($rule['field']));
                }
            }              
        }
        if($_POST['dist_code'] != 21 && $_POST['v_whether_encroached'] == 'Y' 
            || $_POST['v_whether_encroached'] == 'I'){
            $bigha = $_POST['v_en_area_b'] = $_POST['lb_lm_update_form_en_area_b'];
            $katha = $_POST['v_en_area_k'] = $_POST['lb_lm_update_form_en_area_k'];
            $lessa = $_POST['v_en_area_lc'] = $_POST['lb_lm_update_form_en_area_l'];
            $lb_area_val = [
                [
                    'field' => 'v_en_area_b',
                    'label' => 'Encroach-Area(Bigha)',
                    'rules' => 'required|integer|greater_than_equal_to[0]'
                ],
                [
                    'field' => 'v_en_area_k',
                    'label' => 'Encroach-Area(Katha)',
                    'rules' => 'required|integer|less_than[5]|greater_than_equal_to[0]'
                ],
                [
                    'field' => 'v_en_area_lc',
                    'label' => 'Encroach-Area(Lessa)',
                    'rules' => 'required|numeric|less_than[20]|greater_than_equal_to[0]'
                ],
            ];
            $this->form_validation->set_rules($lb_area_val);
            if ($this->form_validation->run() == FALSE)
            {               
                foreach($lb_area_val as $rule){
                    if (form_error($rule['field'])) {
                        array_push($error_msg, form_error($rule['field']));
                    }
                }              
            }
        }
        //validation data for encroacher's details
        $no_of_encroacher = $_POST['lb_lm_update_details_form_no_of_encroacher'];
        $enc_row_count = 1;
        if($no_of_encroacher > 0 && $_POST['v_whether_encroached'] == 'Y' || $_POST['v_whether_encroached'] == 'I'){
            for ($i = 0; $i <= ($no_of_encroacher-1); $i++) {
                $_POST['v_name'] = $_POST['lb_lm_update_form_en_name'][$i];
                $_POST['v_fathers_name'] = $_POST['lb_lm_update_form_en_father_name'][$i];
                $_POST['v_gender'] = $_POST['lb_lm_update_form_en_gender'][$i];
                $_POST['v_encroachment_from'] = $_POST['lb_lm_update_form_en_from_date'][$i];
                $_POST['v_encroachment_to'] = $_POST['lb_lm_update_form_en_to_date'][$i];
                $_POST['v_landless_indigenous'] = $_POST['lb_lm_update_form_en_landless_indigenuous'][$i];
                $_POST['v_landless'] = $_POST['lb_lm_update_form_en_landless'][$i];                
                $_POST['v_caste'] = $_POST['lb_lm_update_form_en_caste'][$i];
                $_POST['v_erosion'] = $_POST['lb_lm_update_form_en_erosion'][$i];
                $_POST['v_landslide'] = $_POST['lb_lm_update_form_en_landslide'][$i];
                $_POST['v_type_of_land_use'] = $_POST['lb_lm_update_form_type_of_land_use'][$i];
                $_POST['v_type_of_encroacher'] = $_POST['lb_lm_update_form_type_of_encroacher'][$i];
                //$_POST['v_entry_made_in_blank_page'] = $_POST['lb_lm_update_form_en_entry_made_in_blank_page'][$i];
                $lb_enc_val = [
                    [
                        'field' => 'v_name',
                        'label' => 'Encroacher Name (Row-'.$enc_row_count .')',
                        'rules' => 'required|callback_check_script|max_length[50]|trim|xss_clean'
                    ],
                    [
                        'field' => 'v_fathers_name',
                        'label' => 'Encroacher Father Name (Row-'.$enc_row_count .')',
                        'rules' => 'required|callback_check_script|max_length[50]|trim|xss_clean'
                    ],
                    [
                        'field' => 'v_gender',
                        'label' => 'Gender (Row-'.$enc_row_count .')',
                        'rules' => 'required|callback_check_script|less_than_equal_to[3]|numeric|trim|xss_clean'
                    ],
                    [
                        'field' => 'v_encroachment_from',
                        'label' => 'Encroacher From date (YYYY-MM-DD) (Row-'.$enc_row_count .')',
                        'rules' => 'required|callback_check_script|callback_date_valid|trim|xss_clean'
                    ],
                    [
                        'field' => 'v_encroachment_to',
                        'label' => 'Encroacher To date (YYYY-MM-DD) (Row-'.$enc_row_count .')',
                        'rules' => 'required|callback_check_script|callback_date_valid|trim|xss_clean'
                    ],
                    [
                        'field' => 'v_landless_indigenous',
                        'label' => 'Landless Indigenous (Row-'.$enc_row_count .')',
                        'rules' => 'required|callback_check_script|exact_length[1]|trim|xss_clean'
                    ],
                    [
                        'field' => 'v_landless',
                        'label' => 'Landless (Row-'.$enc_row_count .')',
                        'rules' => 'required|callback_check_script|exact_length[1]|trim|xss_clean'
                    ],                    
                    [
                        'field' => 'v_caste',
                        'label' => 'Caste (Row-'.$enc_row_count .')',
                        'rules' => 'required|callback_check_script|less_than_equal_to[6]|trim|xss_clean'
                    ],
                    [
                        'field' => 'v_erosion',
                        'label' => 'Erosion (Row-'.$enc_row_count .')',
                        'rules' => 'required|callback_check_script|exact_length[1]|trim|xss_clean'
                    ],
                    [
                        'field' => 'v_landslide',
                        'label' => 'Landslide (Row-'.$enc_row_count .')',
                        'rules' => 'required|callback_check_script|exact_length[1]|trim|xss_clean'
                    ],
                    // [
                    //     'field' => 'v_entry_made_in_blank_page',
                    //     'label' => 'Entry Made In Blank Page (Row-'.$enc_row_count .')',
                    //     'rules' => 'required|callback_check_script|exact_length[1]|trim|xss_clean'
                    // ],
                    [
                        'field' => 'v_type_of_land_use',
                        'label' => 'Type Of Land Use (Row-'.$enc_row_count .')',
                        'rules' => 'required|callback_check_script|less_thank[6]|trim|xss_clean'
                    ],
                    [
                        'field' => 'v_type_of_land_use',
                        'label' => 'Type Of Land Use (Row-'.$enc_row_count .')',
                        'rules' => 'required|callback_check_script|less_thank[6]|trim|xss_clean'
                    ],
                    [
                        'field' => 'v_type_of_encroacher',
                        'label' => 'Type Of Encroacher Use (Row-'.$enc_row_count .')',
                        'rules' => 'required|callback_check_script|less_thank[6]|trim|xss_clean'
                    ],
                ];
                $this->form_validation->set_rules($lb_enc_val);
                $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
                $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
                if ($this->form_validation->run() == FALSE)
                {               
                    foreach($lb_enc_val as $rule){
                        if (form_error($rule['field'])) {
                            array_push($error_msg, form_error($rule['field']));
                        }
                    }              
                }
                //*****************************************************************/
                //date logical validation                 
                $from_date = strtotime($_POST['v_encroachment_from']);
                $to_date   = strtotime($_POST['v_encroachment_to']);
                $date_now = strtotime(date("Y-m-d"));
                if($from_date > $date_now){
                    echo json_encode(
                        [   'result' => 'logical_validation_error', 
                            'msg' => "'Encroachment From' Can't Be Greater Than Today in Row-no ". ((int)$i+1). ", Please fill the dates correctly!" 
                        ]);                    
                    exit;
                }
                if($to_date > $date_now){
                    echo json_encode(
                        [   'result' => 'logical_validation_error', 
                            'msg' => "'Encroachment To' Can't Be Greater Than Today in Row-no ". ((int)$i+1). ", Please fill the dates correctly!" 
                        ]);                    
                    exit;
                }
                if ($from_date > $to_date) {
                    echo json_encode(
                        [   'result' => 'logical_validation_error', 
                            'msg' => "'Encroachment From' Can't Be Greater Than 'Encroachment To' in Row-no ". ((int)$i+1). ", Please fill the dates correctly!" 
                        ]);                    
                    exit;
                }
                //*****************************************************************/
                $enc_row_count++;
            }            
        }
        if(count($error_msg) != 0){
            echo json_encode(['result' => 'validation_error', 'msg' => $error_msg]);
            exit;
        }
        //*****************************************************************/
        //logical validation encroacher if whether encroach is Y
        if(trim($_POST['v_whether_encroached']) == 'Y' || trim($_POST['v_whether_encroached']) == 'I'){
            //logical validation area
            $area_validation_flag = $this->lbAreaValidation($dis_code,$subdiv_code,$circle_code,
            $mouza_code, $lot_no,$vill_code,$dag_no,$bigha,$katha,$lessa);
            if($area_validation_flag['result'] == "logical_validation_error"){
                echo json_encode($area_validation_flag);
                exit;
            }
            $no_of_encroacher = $_POST['v_no_of_encroachers_lm_update_form'];
            if($no_of_encroacher == 0 && empty($encroacher_list_excel_file_arr)){
                echo json_encode(
                    [   'result' => 'logical_validation_error', 
                        'msg' => "No Of Encroacher Can't Be Empty If 'Whether-Encroached' field is 'Yes', Please Add Encroacher's!", 
                    ]);                    
                exit;
            }
        }
    //***********************validation-end*****************************/
    
    //********************backup************************//
        date_default_timezone_set("Asia/Calcutta"); 
        $this->db->trans_begin();    
        $data = [
          'data_json' => json_encode($_POST),
          'user_data' => json_encode($this->session->all_userdata()),
          'ip_address' => $this->session->all_userdata()['ip_address'],
          'created_at' => date('Y-m-d H:i:s')
        ];
        $status = $this->db->insert('land_bank_backup', $data);
        if($status !=1){
          $this->db->trans_rollback();
          log_message("error", "#LB-BAK00, Error in insert, table 'land_bank_backup' with data :". json_encode($data));
          echo json_encode(
                [   'result' => 'logical_validation_error', 
                    'msg' => "Some-error-occured, error-code: #LB-BAK00" 
                ]);   
          exit;
        }else{
          $this->db->trans_commit();
        }
    //*******************************************************//
    
        date_default_timezone_set("Asia/Calcutta");  
        $village_uuid = $this->LandBankLMModel->getVillageUUID(trim($_POST['dist_code']), trim($_POST['subdiv_code']),
                        trim($_POST['circle_code']),trim($_POST['mouza_code']),trim($_POST['lot_no']),trim($_POST['vill_code']));        
        if(trim($_POST['dist_code']) != 21){
            $_POST['lb_lm_update_form_en_area_g'] = NULL;
            $_POST['lb_lm_update_form_en_area_kr'] = NULL;
            if(trim($_POST['v_whether_encroached']) == 'N'){
                $_POST['lb_lm_update_form_en_area_b'] = NULL;
                $_POST['lb_lm_update_form_en_area_k'] = NULL;
                $_POST['lb_lm_update_form_en_area_l'] = NULL;    
            }
        }   
        $same_year_flag = false;
        $diff_year_flag = false;            
        $prev_year = "";
        // if previous data exits in the update method
        if($_POST['v_prev_data_flag'] != 'N'){
            //data exists            
            if(!isset($_POST['lb_lm_update_form_existing_year']) || $_POST['lb_lm_update_form_existing_year'] == ""){
                echo json_encode(
                    [   'result' => 'logical_validation_error', 
                        'msg' => "Existing Year Is Missing, Please Recheck The Form!", 
                    ]);                    
                exit;
            }      
            if(date("Y") == $_POST['lb_lm_update_form_existing_year']){
                $same_year_flag = true;
            }else{
                // $diff_year_flag = true;
                $same_year_flag = true;
                $prev_year = $_POST['lb_lm_update_form_existing_year'];
            }            
        
        }
        //*****************************************************************/
        //checking session data with post data
        $sessionValidationFlag = $this->utilityclass->validateSessionUserData($_POST['dist_code'],
        $_POST['subdiv_code'],$_POST['circle_code'], $_POST['mouza_code'], $_POST['lot_no']);
        if(!$sessionValidationFlag){
            log_message("error", "Session Mismatched With Posted Data : ". $_POST['dist_code']."-".
            "-".$_POST['subdiv_code']."-".$_POST['circle_code']."-".$_POST['mouza_code']."-".$_POST['lot_no']);
            echo json_encode(
                [   'result' => 'logical_validation_error', 
                    'msg' => "Some error occured..!, error code LBS001", 
                ]);                    
            exit;
        }
        //*****************************************************************/
        // checking prevous year entries before saving 
        $previous_entry = $this->LandBankLMModel->checkPreviousEntries($_POST['dist_code'],
        $_POST['subdiv_code'],$_POST['circle_code'], $_POST['mouza_code'], $_POST['lot_no'],
        $_POST['vill_code'], $_POST['lb_lm_update_form_dag_no']);
        if(!empty($previous_entry)){
            // if pending new entries can't be added
            if($previous_entry->status == LAND_BANK_STATUS_PENDING){
                echo json_encode(
                    [   'result' => 'logical_validation_error', 
                        'msg' => "Previous Entries Of This Dag Is Already Pending For Approval..!, After Approval By CO Only New Entries Can Be Updated!", 
                    ]);      
                exit;
            }
            // for concurrent operation restriction 
            if($previous_entry->status == LAND_BANK_STATUS_APPROVED){
                if($previous_entry->created_at != $_POST['lb_lm_update_form_last_approval_time']){
                    echo json_encode(
                        [   'result' => 'logical_validation_error', 
                            'msg' => "Previous Entries Of This Dag Has Approved Recently..!, Please Refresh The Page and Add Again..!", 
                        ]);      
                    exit;
                }
            }
            // for same year previous entries
            if($previous_entry->year == date('Y')){            
                $same_year_flag = true;
                $_POST['v_prev_data_flag'] = 'Y';        
            }else {
                $same_year_flag = true;
                //$diff_year_flag = true;
                $_POST['v_prev_data_flag'] = 'Y';
            }
        }else{
            $_POST['v_prev_data_flag'] = 'N';
        }
        //*****************************************************************/
        // if previous data found with same year
        if($_POST['v_prev_data_flag'] == 'Y'){
            $updation_data_for_land_bank_details = [
                'dist_code' => trim($_POST['dist_code']),
                'subdiv_code' => trim($_POST['subdiv_code']),
                'cir_code' => trim($_POST['circle_code']),
                'mouza_pargona_code' => trim($_POST['mouza_code']),
                'lot_no' => trim($_POST['lot_no']),
                'vill_townprt_code' => trim($_POST['vill_code']),
                'year' => date('Y'),
                'dag_no' => trim($_POST['v_dag_no']),
                'village_uuid' => $village_uuid,
                'nature_of_reservation' => trim($_POST['v_nature_of_reservation']),
                'whether_encroached' => trim($_POST['v_whether_encroached']),
                'flag_for_institute' => trim($_POST['v_Institute_flag']), // Added by Manashjyoti Deka on 13-03-2025
                'created_at' => date('Y-m-d H:i:s'),
                'en_area_b' => $_POST['lb_lm_update_form_en_area_b'],
                'en_area_k' => $_POST['lb_lm_update_form_en_area_k'],
                'en_area_lc' => $_POST['lb_lm_update_form_en_area_l'],
                'en_area_g' => $_POST['lb_lm_update_form_en_area_g'],
                'en_area_kr' => $_POST['lb_lm_update_form_en_area_kr'],
                'no_of_encroacher' =>  (int)$_POST['v_no_of_encroachers_lm_update_form'] + count($encroacher_list_excel_file_arr),
                'longitude' => $_POST['v_longitude'],
                'latitude' => $_POST['v_latitude'],
                'status' => LAND_BANK_STATUS_PENDING,
                'user_code' => $this->session->all_userdata()['user_code'],
            ];
            $no_of_encroacher = $_POST['lb_lm_update_details_form_no_of_encroacher'];
            $land_bank_whether_encroached_flag = $_POST['v_whether_encroached'];
            $update_data_for_encroacher_details_arr = array();  
            $new_enc_insert_data_in_updation_arr = array();  
            $existing_enc_arr_in_update = array();         
            if((int)$no_of_encroacher > 0 && $_POST['v_whether_encroached'] == 'Y' || $_POST['v_whether_encroached'] == 'I'){
                for ($i = 0; $i <= (count($_POST['lb_lm_update_form_en_id'])-1); $i++) {
                    if((int)$_POST['lb_lm_update_form_en_id'][$i] == 00){
                        array_push($new_enc_insert_data_in_updation_arr, [
                            'name' => $_POST['lb_lm_update_form_en_name'][$i],
                            'fathers_name' => $_POST['lb_lm_update_form_en_father_name'][$i],
                            'gender' => $_POST['lb_lm_update_form_en_gender'][$i],
                            'encroachment_from' => $_POST['lb_lm_update_form_en_from_date'][$i],
                            'encroachment_to' => $_POST['lb_lm_update_form_en_to_date'][$i],
                            'landless_indigenous' => $_POST['lb_lm_update_form_en_landless_indigenuous'][$i],
                            'landless' => $_POST['lb_lm_update_form_en_landless'][$i],
                            'caste' => $_POST['lb_lm_update_form_en_caste'][$i],
                            'erosion' => $_POST['lb_lm_update_form_en_erosion'][$i],
                            'landslide' => $_POST['lb_lm_update_form_en_landslide'][$i],
                            //'entry_made_in_blank_page' => $_POST['lb_lm_update_form_en_entry_made_in_blank_page'][$i],
                            'type_of_land_use' => $_POST['lb_lm_update_form_type_of_land_use'][$i],
                            'type_of_encroacher' => $_POST['lb_lm_update_form_type_of_encroacher'][$i],
                            'created_at' => date('Y-m-d H:i:s'),  
                        ]);
                    }else{
                        array_push($update_data_for_encroacher_details_arr, [
                            'existing_id' => $_POST['lb_lm_update_form_en_id'][$i],
                            'name' => $_POST['lb_lm_update_form_en_name'][$i],
                            'fathers_name' => $_POST['lb_lm_update_form_en_father_name'][$i],
                            'gender' => $_POST['lb_lm_update_form_en_gender'][$i],
                            'encroachment_from' => $_POST['lb_lm_update_form_en_from_date'][$i],
                            'encroachment_to' => $_POST['lb_lm_update_form_en_to_date'][$i],
                            'landless_indigenous' => $_POST['lb_lm_update_form_en_landless_indigenuous'][$i],
                            'landless' => $_POST['lb_lm_update_form_en_landless'][$i],
                            'caste' => $_POST['lb_lm_update_form_en_caste'][$i],
                            'erosion' => $_POST['lb_lm_update_form_en_erosion'][$i],
                            'landslide' => $_POST['lb_lm_update_form_en_landslide'][$i],
                            //'entry_made_in_blank_page' => $_POST['lb_lm_update_form_en_entry_made_in_blank_page'][$i],
                            'type_of_land_use' => $_POST['lb_lm_update_form_type_of_land_use'][$i],
                            'type_of_encroacher' => $_POST['lb_lm_update_form_type_of_encroacher'][$i],
                            'modified_at' => date('Y-m-d H:i:s'),

                        ]);
                        array_push($existing_enc_arr_in_update, $_POST['lb_lm_update_form_en_id'][$i]);
                    }                        
                }
            }  
            //*********************testing*****************/
            // echo "<pre>";
            // var_dump($updation_data_for_land_bank_details);
            // var_dump($update_data_for_encroacher_details_arr);
            // var_dump($new_enc_insert_data_in_updation_arr);
            // var_dump($existing_enc_arr_in_update);
            // echo "</pre>";  
            // exit;
            //*********************testing*****************/
            $updateSameYearFlag = $this->LandBankLMModel->updateSameYearLbDetails($updation_data_for_land_bank_details,
            $update_data_for_encroacher_details_arr, $new_enc_insert_data_in_updation_arr,$existing_enc_arr_in_update,
            $land_bank_whether_encroached_flag, $encroacher_list_excel_file_arr);
            echo json_encode($updateSameYearFlag);
            exit;
        }

        // if previous data not exits or exists for diff year in the update method
        if($_POST['v_prev_data_flag'] == 'N'){
            $insertion_data_for_land_bank_details = [
                'dist_code' => trim($_POST['dist_code']),
                'subdiv_code' => trim($_POST['subdiv_code']),
                'cir_code' => trim($_POST['circle_code']),
                'mouza_pargona_code' => trim($_POST['mouza_code']),
                'lot_no' => trim($_POST['lot_no']),
                'vill_townprt_code' => trim($_POST['vill_code']),
                'year' => date("Y"),
                'dag_no' => trim($_POST['v_dag_no']),
                'village_uuid' => $village_uuid,
                'nature_of_reservation' => trim($_POST['v_nature_of_reservation']),
                'whether_encroached' => trim($_POST['v_whether_encroached']),
                'flag_for_institute' => trim($_POST['v_Institute_flag']), // Added by Manashjyoti Deka on 13-03-2025
                'created_at' => date('Y-m-d H:i:s'),
                'en_area_b' => $_POST['lb_lm_update_form_en_area_b'],
                'en_area_k' => $_POST['lb_lm_update_form_en_area_k'],
                'en_area_lc' => $_POST['lb_lm_update_form_en_area_l'],
                'en_area_g' => $_POST['lb_lm_update_form_en_area_g'],
                'en_area_kr' => $_POST['lb_lm_update_form_en_area_kr'],
                'no_of_encroacher' =>  (int)$_POST['v_no_of_encroachers_lm_update_form'] + count($encroacher_list_excel_file_arr),
                'longitude' => $_POST['v_longitude'],
                'latitude' => $_POST['v_latitude'],
                'status' => LAND_BANK_STATUS_PENDING,
                'user_code' => $this->session->all_userdata()['user_code'],

            ];
            $no_of_encroacher = $_POST['lb_lm_update_details_form_no_of_encroacher'];
            $insertion_data_for_encroacher_details_arr = array();              
            if((int)$no_of_encroacher > 0 && $_POST['v_whether_encroached'] == 'Y' || $_POST['v_whether_encroached'] == 'I'){
                for ($i = 0; $i <= ($no_of_encroacher-1); $i++) {
                    array_push($insertion_data_for_encroacher_details_arr, [
                        'name' => $_POST['lb_lm_update_form_en_name'][$i],
                        'fathers_name' => $_POST['lb_lm_update_form_en_father_name'][$i],
                        'gender' => $_POST['lb_lm_update_form_en_gender'][$i],
                        'encroachment_from' => $_POST['lb_lm_update_form_en_from_date'][$i],
                        'encroachment_to' => $_POST['lb_lm_update_form_en_to_date'][$i],
                        'landless_indigenous' => $_POST['lb_lm_update_form_en_landless_indigenuous'][$i],
                        'landless' => $_POST['lb_lm_update_form_en_landless'][$i],
                        'caste' => $_POST['lb_lm_update_form_en_caste'][$i],
                        'erosion' => $_POST['lb_lm_update_form_en_erosion'][$i],
                        'landslide' => $_POST['lb_lm_update_form_en_landslide'][$i],
                        //'entry_made_in_blank_page' => $_POST['lb_lm_update_form_en_entry_made_in_blank_page'][$i],
                        'type_of_land_use' => $_POST['lb_lm_update_form_type_of_land_use'][$i],
                        'type_of_encroacher' => $_POST['lb_lm_update_form_type_of_encroacher'][$i],
                        'created_at' => date('Y-m-d H:i:s'),                        
                    ]);
                }
            }    
            //*********************testing*****************/
            // echo "<pre>";
            // var_dump($insertion_data_for_land_bank_details);
            // var_dump($insertion_data_for_encroacher_details_arr);
            // echo "</pre>";  
            // exit;
            //*********************testing*****************/
            $insertFlag = $this->LandBankLMModel->insertNewLbDetails($insertion_data_for_land_bank_details,$insertion_data_for_encroacher_details_arr,$diff_year_flag,$prev_year,$encroacher_list_excel_file_arr);
            echo json_encode($insertFlag);
            exit;
        }

    }

    // validating area with daag area 
    function lbAreaValidation($dist_code,$subdiv_code,$cir_code,
    $mouza_code, $lot_no,$vill_code,$dag_no,$bigha,$katha,$lessa)
    {
        $sql = "select * from chitha_basic where dist_code = ? and subdiv_code = ? and cir_code = ? 
                and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and dag_no = ?";
        $query = $this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no,$vill_code,$dag_no));
        $result =  $query->row();
        //original dag area in chitha basic
        $c_area_b = $result->dag_area_b;
        $c_area_k = $result->dag_area_k;
        $c_area_lc = $result->dag_area_lc;
        //comparing with posted area
        $c_area_in_lc = (int)$c_area_b*5*20 + (int)$c_area_k*20 + $c_area_lc;
        $post_area_in_lc = (int)$bigha*5*20 + (int)$katha*20 + $lessa;
        if($c_area_in_lc < $post_area_in_lc){
            return [   
                'result' => 'logical_validation_error', 
                'msg' => "Total Encroach Area Must Be Less Than Or Equal To Original Dag Area(".$c_area_b."-Bigha, ".$c_area_k."-Katha, ".$c_area_lc."-Lessa)",  
            ];       
        }else{
            return [   
                'result' => "", 
                'msg' => "Total Encroach Area Must Be Less Than Or Equal To Original Dag Area(".$c_area_b."-Bigha, ".$c_area_k."-Katha, ".$c_area_lc."-Lessa)",  
            ]; 
        }
    }

    //getting pending list data
    public function PendingList(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "LM"){
            echo json_encode("Not Authorised..!, Please Login With LM's Credentials!");
            exit;
        }
        //**************************************************/
        $data['dist_code'] = $dist_code = $_SESSION['credentials']["dist_code"];
        $data['subdiv_code'] = $subdiv_code = $_SESSION['credentials']["subdiv_code"];
        $data['circle_code'] = $cir_code = $_SESSION['credentials']["cir_code"];
        $data['mouza_code'] = $mouza_pargona_code = $_SESSION['credentials']["mouza_pargona_code"];
        $data['lot_no'] = $lot_no = $_SESSION['credentials']["lot_no"];
        $uniqueVillageIdsInLandBankDetails = $this->LandBankLMModel->getUniqueVillageIdsInLandBankDetails($dist_code,
        $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $data['pending_list'] = $getLbPendingList = $this->LandBankLMModel->getLbPendingList($uniqueVillageIdsInLandBankDetails);
        $data['_view'] = 'land_bank_lm/pending_list';
        $this->load->view('layouts/main',$data);
    }

    // getting reverted list data
    public function RevertedList(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "LM"){
            echo json_encode("Not Authorised..!, Please Login With LM's Credentials!");
            exit;
        }
        //**************************************************/
        $data['dist_code'] = $dist_code = $_SESSION['credentials']["dist_code"];
        $data['subdiv_code'] = $subdiv_code = $_SESSION['credentials']["subdiv_code"];
        $data['circle_code'] = $cir_code = $_SESSION['credentials']["cir_code"];
        $data['mouza_code'] = $mouza_pargona_code = $_SESSION['credentials']["mouza_pargona_code"];
        $data['lot_no'] = $lot_no = $_SESSION['credentials']["lot_no"];
        $uniqueVillageIdsInLandBankDetails = $this->LandBankLMModel->getUniqueVillageIdsInLandBankDetails($dist_code,
        $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $reverted_list = $getLbRevertedList = $this->LandBankLMModel->getLbRevertedList($uniqueVillageIdsInLandBankDetails);
        foreach($reverted_list as $key => $val){
            $rejected_by = $this->LandBankLMModel->getLBRevertUser($val->id);
            $reverted_list[$key]->reverted_person = $rejected_by;
        }
        $data['reverted_list'] = $reverted_list;
        $data['_view'] = 'land_bank_lm/reverted_list';
        $this->load->view('layouts/main',$data);
    }

    //getting the approved list
    public function ApprovedList(){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "LM"){
            echo json_encode("Not Authorised..!, Please Login With LM's Credentials!");
            exit;
        }
        //**************************************************/
        $data['dist_code'] = $dist_code = $_SESSION['credentials']["dist_code"];
        $data['subdiv_code'] = $subdiv_code = $_SESSION['credentials']["subdiv_code"];
        $data['circle_code'] = $cir_code = $_SESSION['credentials']["cir_code"];
        $data['mouza_code'] = $mouza_pargona_code = $_SESSION['credentials']["mouza_pargona_code"];
        $data['lot_no'] = $lot_no = $_SESSION['credentials']["lot_no"];
        $data['_view'] = 'land_bank_lm/approved_list';
        $uniqueVillageIdsInCLandBankDetails = $this->LandBankLMModel->getUniqueVillageIdsInCLandBankDetails($dist_code,
        $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $data['approved_list'] = $this->LandBankLMModel->getLbApprovedList($uniqueVillageIdsInCLandBankDetails);
        $this->load->view('layouts/main',$data);
    }

    //getting lb data for view 
    public function getLbDataForView(){     
        $lb_details_id = $_POST['lb_details_id'];
        $gender_list = $this->LandBankLMModel->getAllGenderList();
        $caste_list = $this->LandBankLMModel->getAllCasteList();
        $type_of_land_use = LB_ENC_TYPE_OF_LAND_USE;
        $type_of_encroacher = TYPE_OF_ENCROACHER;
        if(isset($_POST['flag']) && $_POST['flag'] == 'approve_list'){
            $lbDataFromId = $this->LandBankLMModel->getApprovedLbDataFromId($lb_details_id);    
        }else{
            $lbDataFromId = $this->LandBankLMModel->getLbDataFromId($lb_details_id);
        }
        echo json_encode([$lbDataFromId, $gender_list,$caste_list,$type_of_land_use, $type_of_encroacher]);
    }

    //getting type of land use from constant file
    public function getTypeOfLandUse(){ 
        echo LB_ENC_TYPE_OF_LAND_USE;
    }

    //getting the rejcetd remark of lb 
    public function getLbRejectedRemark(){ 
        $lb_details_id = $_POST['lb_details_id'];
        $rejected_remark = $this->LandBankLMModel->getLBrejectedRmk($lb_details_id);
        echo json_encode($rejected_remark);
    }

    //download encroacher excel format  
    public function DownloadEncroacherFormat(){
        $file_url = LAND_BANK_ENCROACHER_EXCEL_FORMAT_FILE_LOCATION.LAND_BANK_ENCROACHER_EXCEL_FORMAT_FILE_NAME;
        header('Content-Type: application/octet-stream');  
        header("Content-Transfer-Encoding: utf-8");   
        header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\"");   
        readfile($file_url);  
    }

    //getting all the vgr dag list
    public function VGRdagList($villageCode){
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "LM"){
            echo json_encode("Not Authorised..!, Please Login With LM's Credentials!");
            exit;
        }
        //**************************************************/
        $data['flag'] = $_GET['flag'];
        $data['dist_code'] = $dist_code = $_SESSION['credentials']["dist_code"];
        $data['subdiv_code'] = $subdiv_code = $_SESSION['credentials']["subdiv_code"];
        $data['circle_code'] = $cir_code = $_SESSION['credentials']["cir_code"];
        $data['mouza_code'] = $mouza_code = $_SESSION['credentials']["mouza_pargona_code"];
        $data['lot_no'] = $lot_no = $_SESSION['credentials']["lot_no"];
        $data['vill_code'] = $vill_code = $villageCode;
        $data['vgrLandDetails'] = $vgrLandDetails = $this->LandBankLMModel->getVgrLandDetails($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no,$vill_code);
        // echo "<pre>";
        // var_dump($data['vgrLandDetails']);
        // echo "</pre>";
        // exit;        
        $data['_view'] = 'land_bank_lm/vgr_dag_list';
        $this->load->view('layouts/main',$data);
    }

    //getting all the pgr dag list 
    public function PGRdagList($villageCode) {
        //***************chechink-user-designation**********/
        if($this->session->userdata('user_desig_code') != "LM"){
            echo json_encode("Not Authorised..!, Please Login With LM's Credentials!");
            exit;
        }
        //**************************************************/
        $data['flag'] = $_GET['flag'];
        $data['dist_code'] = $dist_code = $_SESSION['credentials']["dist_code"];
        $data['subdiv_code'] = $subdiv_code = $_SESSION['credentials']["subdiv_code"];
        $data['circle_code'] = $cir_code = $_SESSION['credentials']["cir_code"];
        $data['mouza_code'] = $mouza_code = $_SESSION['credentials']["mouza_pargona_code"];
        $data['lot_no'] = $lot_no = $_SESSION['credentials']["lot_no"];
        $data['vill_code'] = $vill_code = $villageCode;
        $data['pgrLandDetails'] = $pgrLandDetails = $this->LandBankLMModel->getPgrLandDetails($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no,$vill_code);
        $data['_view'] = 'land_bank_lm/pgr_dag_list';
        $this->load->view('layouts/main',$data);
    }

    //getting type of encraocher
    public function getTypeOfEncroacher(){
        echo TYPE_OF_ENCROACHER;
    }
    function CheckGramDagTrue($d,$s,$c,$m,$l,$v,$dag){
        $sql="Select * from chitha_basic where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?
        and patta_type_code in (Select type_code from patta_code where pattatype_eng like '%GRAM%')";
        $data_count=$this->db->query($sql,array($d,$s,$c,$m,$l,$v,$dag));
        if($data_count->num_rows()>0) return true;
        $sql_govt_dag_check="Select * from chitha_basic where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?
        and patta_type_code in (Select type_code from patta_code where jamabandi='n')";
        $data_govt_count=$this->db->query($sql_govt_dag_check,array($d,$s,$c,$m,$l,$v,$dag));
        if($data_govt_count->num_rows()>0) return true;
        else return false;
    }

    function checkPattaLandOrNot($d,$s,$c,$m,$l,$v,$dag)
    {
        $sql="Select * from chitha_basic where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?
        and patta_type_code in (Select type_code from patta_code where type_code='0201')";
        $data_count=$this->db->query($sql,array($d,$s,$c,$m,$l,$v,$dag));
        if($data_count->num_rows()>0)
        {
            return TRUE;
        } 
        else
        {
            return FALSE;
        }
    }

    
    function checkTeaLandOrNot($d,$s,$c,$m,$l,$v,$dag)
    {
        $sql="Select * from chitha_basic where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?
        and patta_type_code in (Select type_code from patta_code where type_code='0216')";
        $data_count=$this->db->query($sql,array($d,$s,$c,$m,$l,$v,$dag));
        if($data_count->num_rows()>0)
        {
            return TRUE;
        } 
        else
        {
            return FALSE;
        }
    }

    function checkPattaLandandCheckUnderPattaLandorNot($d,$s,$c,$m,$l,$v,$dag,$reservation)
    {
        $sql="Select * from chitha_basic where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?
        and patta_type_code in (Select type_code from patta_code where type_code in ('0201','0216'))";
        $data_count=$this->db->query($sql,array($d,$s,$c,$m,$l,$v,$dag));
        if($data_count->num_rows()>0)
        {
            if($reservation == '11' || $reservation == '12')
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        } 
        else
        {
            return TRUE;
        }
    }


 
    //svamitva code
    public function VillageListSvamitva()
    {
        //***************chechink-user-designation**********/
        if ($this->session->userdata('user_desig_code') != "LM") {
            echo json_encode("Not Authorised..!, Please Login With LM's Credentials!");
            exit;
        }
        //**************************************************/
        $data['dist_code'] = $dist_code = $_SESSION['credentials']["dist_code"];
        $data['subdiv_code'] = $subdiv_code = $_SESSION['credentials']["subdiv_code"];
        $data['circle_code'] = $cir_code = $_SESSION['credentials']["cir_code"];
        $data['mouza_code'] = $mouza_pargona_code = $_SESSION['credentials']["mouza_pargona_code"];
        $data['lot_no'] = $lot_no = $_SESSION['credentials']["lot_no"];
        $data['villages'] = $this->LandBankLMModel->getVillageListSvamitva(
            $dist_code,
            $subdiv_code,
            $cir_code,
            $mouza_pargona_code,
            $lot_no
        );
        $data['_view'] = 'land_bank_lm/village_list_import';
        $this->load->view('layouts/main', $data);
    }

    public function getLandBankVillageData()
    {
        if ($this->session->userdata('user_desig_code') != "LM") {
            echo json_encode("Not Authorised..!, Please Login With LM's Credentials!");
            exit;
        }
        $dist_code = $_SESSION['credentials']["dist_code"];
        $subdiv_code = $_SESSION['credentials']["subdiv_code"];
        $cir_code = $_SESSION['credentials']["cir_code"];
        $mouza_pargona_code = $_SESSION['credentials']["mouza_pargona_code"];
        $lot_no = $_SESSION['credentials']["lot_no"];
        $vill_code = $_POST['vill_code'];
        $vlbs = $this->LandBankLMModel->getVillageVlbs(
            $dist_code,
            $subdiv_code,
            $cir_code,
            $mouza_pargona_code,
            $lot_no,
            $vill_code
        );
        echo json_encode($vlbs);
    }

    public function importOccupiers()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('dist_code', 'District Code', 'required|alpha_numeric');
        $this->form_validation->set_rules('subdiv_code', 'Subdivision Code', 'required|alpha_numeric');
        $this->form_validation->set_rules('cir_code', 'Circle Code', 'required|alpha_numeric');
        $this->form_validation->set_rules('mouza_pargona_code', 'Mouza Code', 'required|alpha_numeric');
        $this->form_validation->set_rules('lot_no', 'Lot Number', 'required');
        $this->form_validation->set_rules('vill_code', 'Village Code', 'required');
        $this->form_validation->set_rules('occupiers', 'Occupiers Data', 'required');

        if ($this->form_validation->run() === FALSE) {
            echo json_encode([
                'success' => false,
                'message' => validation_errors()
            ]);
            return;
        }

        $data = $this->input->post();
        $occupiers = json_decode($data['occupiers'], true);

        if (!is_array($occupiers) || count($occupiers) === 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid or empty occupier data']);
            return;
        }

        if (!empty($_FILES['import_file']['name'])) {
            $uploadPath = UPLOAD_PATH_FOR_VLB_BULK_ENCROACHER;

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $config['upload_path']   = $uploadPath;
            $config['allowed_types'] = 'xlsx';
            $config['file_name']     = time() . '_' . $_FILES['import_file']['name'];

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('import_file')) {
                $uploadData = $this->upload->data();

                $filePath   = $uploadData['full_path'];   // full server path
                $fileName   = $uploadData['file_name'];   // just the filename

                // Build public file URL
                $file_url = 'uploads/vlb_import/' . $fileName;

                $this->LandBankLMModel->logImport(
                    $data['dist_code'],
                    $data['subdiv_code'],
                    $data['cir_code'],
                    $data['mouza_pargona_code'],
                    $data['lot_no'],
                    $data['vill_code'],
                    $this->session->userdata('user_code'),
                    'Y',
                    'xl uploaded',
                    null,
                    $file_url
                );
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => $this->upload->display_errors()
                ]);
                return;
            }
        }

        // Call model
        $result = $this->LandBankLMModel->importOccupiersData(
            $data['dist_code'],
            $data['subdiv_code'],
            $data['cir_code'],
            $data['mouza_pargona_code'],
            $data['lot_no'],
            $data['vill_code'],
            $occupiers,
            $this->session->userdata('user_code')
        );

        echo json_encode($result);
    }
 }
