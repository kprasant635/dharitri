<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SnaReport extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('SnaReport/SnaReportModel');
        $this->load->library('AES');
       
    }

    //dbswitch method passing the dist code
    public function dbswitchSecond($dist_code)
    {
        if ($dist_code == "02") {
            $this->db = $this->load->database('dha3', TRUE);
        } else if ($dist_code == "05") {
            $this->db = $this->load->database('dha1', TRUE);
        } else if ($dist_code == "10") {
            $this->db = $this->load->database('dha24', TRUE);
        } else if ($dist_code == "13") {
            $this->db = $this->load->database('dha2', TRUE);
        } else if ($dist_code == "17") {
            $this->db = $this->load->database('dha4', TRUE);
        } else if ($dist_code == "15") {
            $this->db = $this->load->database('dha5', TRUE);
        } else if ($dist_code == "14") {
            $this->db = $this->load->database('dha6', TRUE);
        } else if ($dist_code == "07") {
            $this->db = $this->load->database('dha7', TRUE);
        } else if ($dist_code == "03") {
            $this->db = $this->load->database('dha8', TRUE);
        } else if ($dist_code == "18") {
            $this->db = $this->load->database('dha9', TRUE);
        } else if ($dist_code == "12") {
            $this->db = $this->load->database('dha13', TRUE);
        } else if ($dist_code == "24") {
            $this->db = $this->load->database('dha10', TRUE);
        } else if ($dist_code == "06") {
            $this->db = $this->load->database('dha11', TRUE);
        } else if ($dist_code == "11") {
            $this->db = $this->load->database('dha12', TRUE);
        } else if ($dist_code == "16") {
            $this->db = $this->load->database('dha14', TRUE);
        } else if ($dist_code == "32") {
            $this->db = $this->load->database('dha15', TRUE);
        } else if ($dist_code == "33") {
            $this->db = $this->load->database('dha16', TRUE);
        } else if ($dist_code == "34") {
            $this->db = $this->load->database('dha17', TRUE);
        } else if ($dist_code == "21") {
            $this->db = $this->load->database('dha18', TRUE);
        } else if ($dist_code == "08") {
            $this->db = $this->load->database('dha19', TRUE);
        } else if ($dist_code == "35") {
            $this->db = $this->load->database('dha20', TRUE);
        } else if ($dist_code == "36") {
            $this->db = $this->load->database('dha21', TRUE);
        } else if ($dist_code == "37") {
            $this->db = $this->load->database('dha22', TRUE);
        } else if ($dist_code == "25") {
            $this->db = $this->load->database('dha23', TRUE);
        } else if ($dist_code == "39") {
            $this->db = $this->load->database('dha39', TRUE);
        }else if ($dist_code == "auth") {
            $this->db = $this->load->database('auth', TRUE);
        }
        return $this->db;
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

    //method to get the subdivision names from central auth database
    public function getSubdivNames()
    {
        $CI=&get_instance();
        $aurth_data = $this->db=$CI->load->database('auth', TRUE);
        $params = json_decode(file_get_contents("php://input"));
        $dist_code = $params->dist_code;
        $query = $this->db->query("select dist_code,subdiv_code,loc_name,locname_eng from location where dist_code=? and subdiv_code!=? and cir_code=? ",array($dist_code,'00','00'));
        echo json_encode($query->result());
    }

    //method to get the circle names from central auth database
    public function getCircleNames()
    {
        $CI=&get_instance();
        $aurth_data = $this->db=$CI->load->database('auth', TRUE);
        $params = json_decode(file_get_contents("php://input"));
        $dist_code = $params->dist_code;
        $subdiv_code = $params->subdiv_code;
        $query = $this->db->query("select dist_code,subdiv_code,cir_code,loc_name,locname_eng from location where dist_code=? and subdiv_code=? and cir_code!=? and mouza_pargona_code=? and lot_no=?",array($dist_code,$subdiv_code,'00','00','00'));
        echo json_encode($query->result());
    }

    //method to get the the usernames from previous office
    public function getPreviousUserList()
    {
        $params = json_decode(file_get_contents("php://input"));
        $dist_code = $params->dist_code;
        $subdiv_code = $params->subdiv_code;
        $cir_code = $params->cir_code;
        $this->dbswitchSecond($dist_code);
        $query = $this->db->query("select * from users u join loginuser_table lut on u.user_code = lut.user_code and u.dist_code = lut.dist_code and u.subdiv_code = lut.subdiv_code and u.cir_code = lut.cir_code  where u.dist_code=? and u.subdiv_code=? and u.cir_code=? and lut.mouza_pargona_code =? and lut.dis_enb_option =?  and lut.user_code like 'CO%' order by date_from desc",array($dist_code,$subdiv_code,$cir_code,'00','D'));
        echo json_encode($query->result());

    }

    //sna modal form submit method
    public function submitSnaForm()
    {
        $error_msg = array();
        $sna_post_data = [
            [
                'field' => 'user_name',
                'label' => 'User Name',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[45]'
            ],
            [
                'field' => 'join_date',
                'label' => 'Joining Date',
                'rules' => 'required'
            ],
            [
                'field' => 'user_phone_number',
                'label' => 'Phone No',
                'rules' => 'required|callback_check_script|max_length[10]|trim|xss_clean'
            ],
            [
                'field' => 'user_address',
                'label' => 'Address',
                'rules' => 'required|callback_check_script|xss_clean'
            ],
            [
                'field' => 'transfer_type',
                'label' => 'Transfer Type',
                'rules' => 'required|callback_check_script|trim|xss_clean|exact_length[1]'
            ],
            
        ];
        $this->form_validation->set_rules($sna_post_data);
        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
        if ($this->form_validation->run() == FALSE)
        {
            foreach($sna_post_data as $rule){
                if (form_error($rule['field'])) {
                array_push($error_msg, form_error($rule['field']));
                }
            }
        }
        if(count($error_msg) != 0){
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => $error_msg]);
            exit;
        }

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        $user_name = $_POST['user_name'];
        $joining_date = $_POST['join_date'];
        $user_phone_number = $_POST['user_phone_number'];
        $gender = null;
        $user_address = $_POST['user_address'];
        $transfer_type = $_POST['transfer_type'];
        $unique_user_id = $user_code.$dist_code.$subdiv_code.$cir_code;
       
        
        if($transfer_type =='y'){
           
            $error_msg = array();
            $sna_transfered_data_validation = [
                [
                    'field' => 'prev_dist',
                    'label' => 'Previous District',
                    'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
                ],
                [
                    'field' => 'prev_subdiv',
                    'label' => 'Previous Subdivision',
                    'rules' => 'required|callback_check_script|trim|xss_clean'
                ],
                [
                    'field' => 'prev_cir',
                    'label' => 'Previous Circle',
                    'rules' => 'required|callback_check_script|trim|xss_clean'
                ],
                [
                    'field' => 'previous_user_list',
                    'label' => 'Previous User Name',
                    'rules' => 'required|callback_check_script|xss_clean'
                ],
                [
                    'field' => 'prev_joining_date',
                    'label' => 'Previous Date Of Joining',
                    'rules' => 'required|callback_check_script|trim|xss_clean'
                ],
                [
                    'field' => 'prev_leave_date',
                    'label' => 'Previous Date Of Leaving',
                    'rules' => 'required|callback_check_script|trim|xss_clean'
                ],
                
            ];
            $this->form_validation->set_rules($sna_transfered_data_validation);
            $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
            $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
            if ($this->form_validation->run() == FALSE)
            {
                foreach($sna_transfered_data_validation as $rule){
                    if (form_error($rule['field'])) {
                    array_push($error_msg, form_error($rule['field']));
                    }
                }
            }
            if(count($error_msg) != 0){
                echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => $error_msg]);
                exit;
            }

            $previous_location = $_POST['prev_cir']; //need to explode
            $parts = explode(",",$previous_location);
            $previous_dist_code = $parts[0];
            $previous_subdiv_code = $parts[1];
            $previous_cir_code = $parts[2];
            $pre_user = $_POST['previous_user_list'];
            $previous_user = explode(",",$pre_user);
            $previous_user_code =$previous_user[3];
            $previous_user = $_POST['previous_user_list']; //need to explode for the user name
            $prev_joining_date = $_POST['prev_joining_date']; 
            $previous_leaving_date = $_POST['prev_leave_date'];
        }

        //file upload for joining doc 
        $tmp_name_1= $_FILES['join_doc']['tmp_name'];
        if (empty($tmp_name_1) || !file_exists($tmp_name_1)){
            log_message("error","joining document not found #ERRSNAREPORT005");
            echo json_encode(['result' => 'FILE_UPLOAD_ERR' ,'msg' => 'JOINING DOCUMENT FILE MISSING #ERRSNAREPORT005']);
            exit;
        }
     
        if($tmp_name_1 = null || $tmp_name_1=""){
            log_message("error","joining document not found #ERRSNAREPORT005");
            echo json_encode(['result' => 'FILE_UPLOAD_ERR' ,'msg' => 'JOINING DOCUMENT FILE MISSING #ERRSNAREPORT005']);
            exit;
        }
        
        $name = $_FILES['join_doc']['name'];
        $size = $_FILES['join_doc']['size'];
        
        $mime = mime_content_type($_FILES['join_doc']['tmp_name']);
      
        $exp  = explode("/",$mime);
        
        $ext  = $exp[1];
        
        if($name != NULL)
        {
            if($ext == NULL)
            {
                echo json_encode(['result' => 'FILE_UPLOAD_ERR', 'msg' => 'File extension not found']);
                exit();
            }
            if(!in_array($ext,SNA_UPLOAD_TYPE_VALIDATION))
            {
                echo json_encode(['result' => 'FILE_UPLOAD_ERR', 'msg' => 'File type not matched, Please upload only PDF Format files']);
                exit();
            }
            if($size > SNA_DOC_MAX_SIZE)
            {
                echo json_encode(['result' => 'FILE_UPLOAD_ERR', 'msg' => 'File size is too large to upload, Please Upload File of size less than 2MB']);
                exit();
            }
        }
        else
        {
            log_message("error","#SNAREPORTFILEUPLOAD1001 name of the file not found in joining documnet");
            echo json_encode(['result' => 'FILE_UPLOAD_ERR', 'msg' => 'Some Error Occurred ... Please Try Again #SNAREPORTFILEUPLOAD1001']);
            exit();
        }

        $config['upload_path']   = SNA_DOCUMENT_UPLOAD_PATH;
        $config['allowed_types'] = SNA_DOC_ALLOW_TYPE;
        $config['max_size']  = SNA_DOC_MAX_SIZE;
        $onlyExtension  = $exp[1];
        $fileRename =  'joining_doc'.time(). '.' . $onlyExtension;
        $config['file_name'] = $fileRename;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $transfer_doc_file_path = null;
        $joining_doc_file_path = null;
        if ($this->upload->do_upload('join_doc'))
        {   
            $joining_doc_file_path = SNA_DOCUMENT_UPLOAD_PATH.$fileRename;
        }

    
        //file upload for transfer doc 
        if($transfer_type =='y'){
            $tmp_name2 = $_FILES['prev_transfer_cert']['tmp_name'];
            if (empty($tmp_name2) && !file_exists($tmp_name2)){
                log_message("error","Previous transfer document not found #ERRSNAREPORT0065");
                echo json_encode(['result' => 'FILE_UPLOAD_ERR' ,'msg' => 'TRANSFER DOCUMENT FILE MISSING #ERRSNAREPORT005']);
                exit;
            }
            if($tmp_name2 = null || $tmp_name2=""){
                log_message("error","transfer document not found #ERRSNAREPORT006");
                echo json_encode(['result' => 'FILE_UPLOAD_ERR' ,'msg' => 'TRANSFER DOCUMENT FILE MISSING #ERRSNAREPORT006']);
                exit;
            }
            $name = $_FILES['prev_transfer_cert']['name'];
            $size = $_FILES['prev_transfer_cert']['size'];
            $mime = mime_content_type($_FILES['prev_transfer_cert']['tmp_name']);
            $exp1  = explode("/",$mime);
            $ext1  = $exp1[1];
            if($name != NULL)
            {
                if($ext1 == NULL)
                {
                    echo json_encode(['result' => 'FILE_UPLOAD_ERR', 'msg' => 'File extension not found']);
                    exit();
                }
                if(! in_array($ext1, SNA_UPLOAD_TYPE_VALIDATION))
                {
                    echo json_encode(['result' => 'FILE_UPLOAD_ERR', 'msg' => 'File type not matched, Please upload only PDF Format files']);
                    exit();
                }
                if($size > SNA_DOC_MAX_SIZE)
                {
                    echo json_encode(['result' => 'FILE_UPLOAD_ERR', 'msg' => 'File size is too large to upload, Please Upload File of size less than 2MB']);
                    exit();
                }
            }
            else
            {
                log_message("error","#SNAREPORTFILEUPLOAD1002 name of the file not found in transfer  documnet");
                echo json_encode(['result' => 'FILE_UPLOAD_ERR', 'msg' => 'Some Error Occurred ... Please Try Again #SNAREPORTFILEUPLOAD1002']);
                exit();
            }
            $config['upload_path']   = SNA_DOCUMENT_UPLOAD_PATH;
            $config['allowed_types'] = SNA_DOC_ALLOW_TYPE;
            $config['max_size']  = SNA_DOC_MAX_SIZE;
            $onlyExtension1  = $exp1[1];
            $fileRename1 =  'transfer_cert'.time(). '.' . $onlyExtension1;
            $config['file_name'] = $fileRename1;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('prev_transfer_cert'))
            {   
                $transfer_doc_file_path = SNA_DOCUMENT_UPLOAD_PATH.$fileRename1;
            }
        }

        $getUniqueSnaCode = $this->SnaReportModel->getUniqueSnaCode($dist_code,$subdiv_code,$cir_code);
    
        $dharitree_array =[
            "unique_user_id"        =>$unique_user_id,
            "unique_sna_code"       =>$getUniqueSnaCode,
            "usercode"              =>$user_code,
            "dist_code"             =>$dist_code,
            "subdiv_code"           =>$subdiv_code,
            "cir_code"              =>$cir_code,
            "mouza_pargona_code"    =>'00',
            "lot_no"                =>'00',
            "joining_doc"           => $joining_doc_file_path,
            "transfer_doc"          => $transfer_doc_file_path,
            "status"                =>'A',
            "created_at"            =>date('Y-m-d h:i:s'),
            "modified_at"           =>null,
            "transfer_type_yn"      =>$transfer_type,
        ];

        $dhar_db = $this->dbswitchSecond($dist_code);
        $insert_dharitree_array = $this->SnaReportModel->insertDharitreeArray($dhar_db,$dharitree_array);
        // var_dump($insert_dharitree_array);
        // exit;
        if($insert_dharitree_array = null || $insert_dharitree_array['result'] =='N')
        {
            $dhar_db->trans_rollback();
            log_message("error","Error in inserting into dhar_sna_details in dharitree db #ERRSNAR001");
            echo json_encode("Some Error Occurred #ERRSNAR001...!!, Please Try Again");
            exit;
        }
        

        if($transfer_type=="y"){

            $dhar_old_db = $this->dbswitchSecond($previous_dist_code);
            $GetPreviousSnaCode = $this->SnaReportModel->getOldSnaUniqueCode($dhar_old_db,$previous_dist_code,$previous_subdiv_code,$previous_cir_code);
            
            $dharitree_old_array =[
                "unique_user_id"        =>$previous_user_code.$previous_dist_code.$previous_subdiv_code.$previous_cir_code,
                "unique_sna_code"       =>$GetPreviousSnaCode,
                "usercode"              =>$previous_user_code,
                "dist_code"             =>$previous_dist_code,
                "subdiv_code"           =>$previous_subdiv_code,
                "cir_code"              =>$previous_cir_code,
                "mouza_pargona_code"    =>'00',
                "lot_no"                =>'00',
                "joining_doc"           => null,
                "transfer_doc"          => null,
                "status"                =>'D',
                "created_at"            =>date('Y-m-d h:i:s'),
                "modified_at"           =>null,
                "transfer_type_yn"      =>$transfer_type,
            ];

            $insert_dharitree_old_array = $this->SnaReportModel->insertDharitreeOldArray($dhar_old_db,$dharitree_old_array);

            if($insert_dharitree_old_array= null || $insert_dharitree_old_array['result'] =='N')
            {
                $dhar_old_db->trans_rollback();
                log_message("error","Error in inserting into dhar_sna_details in dharitree db #ERRSNAR002");
                echo json_encode(["result" => "SERVER-ERROR" ,"msg"=> "Some Error Occurred #ERRSNAR002...!!, Please Try Again"]);
                exit;
            }
        }

        $ilrms_db_sna_primary_account =[
            "unique_user_id"        =>$unique_user_id,
            "unique_sna_code"       =>$getUniqueSnaCode,
            "dhar_user_code"        =>$user_code,
            "status"                => "A",
            "name"                  =>$user_name,
            "mobile"                =>$user_phone_number,
            "gender"                =>$gender,
            "address"               =>$user_address, 
            "transferred_from_yn"   =>$transfer_type,
            "dist_code"             =>$dist_code,
            "subdiv_code"           =>$subdiv_code,
            "cir_code"              =>$cir_code,
            "mouza_pargona_code"    =>'00',
            "lot_no"                =>'00',
            "date_of_joining"       =>$joining_date,
            "date_of_leaving"       =>null,
            "created_at"            =>date('Y-m-d h:i:s'),
            "modified_at"           =>null,
        ];

        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $subdiv_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        if($transfer_type=="y"){
            $ilrms_db_sna_account_history =[
                "unique_user_id"        => $unique_user_id,
                "unique_sna_code"       => $getUniqueSnaCode,
                "dist_code"             => $dist_code,
                "subdiv_code"           => $subdiv_code,
                "cir_code"              => $cir_code,
                "mouza_pargona_code"    => '00',
                "lot_no"                => '00',
                "dist_name"             => $dist_name,
                "subdiv_name"           => $subdiv_name,
                "cir_name"              => $cir_name,
                "mouza_name"            => null,
                "lot_name"              => null,
                "status"                => "A",
                "prev_date_of_joining"  => $prev_joining_date,
                "prev_date_of_leaving"  => $previous_leaving_date,
                "prev_unique_user_id"   => $previous_user_code.$previous_dist_code.$previous_subdiv_code.$previous_cir_code, 
                "prev_unique_sna_code"  => $GetPreviousSnaCode, 
                "pre_dhar_code"         => $previous_user_code,
                "pre_dist_code"         => $previous_dist_code,
                "pre_subdiv_code"       => $previous_subdiv_code,
                "pre_cir_code"          => $previous_cir_code,
                "pre_mouza_pargona_code"=> null,
                "pre_lot_no"            => null,
                "created_at"            => date('Y-m-d h:i:s'),
                "modified_at"           => null,
            ];
            $insert_ilrms_db_array = $this->SnaReportModel->insertSnaDetailsInIlrms($dhar_db,$dhar_old_db,$ilrms_db_sna_primary_account,$ilrms_db_sna_account_history);
            
            echo json_encode($insert_ilrms_db_array);
        }else{
            $insert_ilrms_db_array = $this->SnaReportModel->insertSnaDetailsInIlrmsNewJoinee($dhar_db,$ilrms_db_sna_primary_account);
            echo json_encode($insert_ilrms_db_array);
        }
        
    } 

    public function ViewSnaAccount()
    {
        $data['dist_code'] = $dist_code= $this->session->userdata('dist_code');
        $data['subdiv_code'] = $subdiv_code= $this->session->userdata('subdiv_code');
        $data['cir_code'] = $cir_code= $this->session->userdata('cir_code');
        $data['user_code'] = $user_code= $this->session->userdata('user_code');
        $dhar_db = $this->dbswitchSecond($dist_code);
        $data['sna_details'] = $this->SnaReportModel->getAllSnaDetails($dhar_db,$dist_code,$subdiv_code,$cir_code,$user_code);
        // echo "<pre>";
        // var_dump($data['sna_details']);
        // exit;
        if($data['sna_details'] == "NOT_FOUND"){
            echo "SORRY NO SNA DETAILS FOUND ...!!! Please fill the SNA Details form First";
            exit;
        }
        $data['_view'] = 'Sna/viewSnaProfile';
        $this->load->view('layouts/main',$data);

    }
}
?>