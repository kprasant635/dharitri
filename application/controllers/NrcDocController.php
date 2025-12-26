<?php
class NrcDocController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->model('NrcDocModel'); 
        $this->load->model('ApplicantChangeModel');        
        $this->dbswitch();
    }

    public function dbswitch11($dist_code)
    {         
         if($dist_code == "02"){
            $this->db=$this->load->database('dha3', TRUE);    
         } else if($dist_code == "05"){
            $this->db=$this->load->database('dha1', TRUE);    
          } else if($dist_code == "10"){
            $this->db=$this->load->database('dha24', TRUE);       
         } else if($dist_code == "13"){
            $this->db=$this->load->database('dha2', TRUE);    
         }  else if($dist_code == "17"){
            $this->db=$this->load->database('dha4', TRUE);    
         }  else if($dist_code == "15"){
            $this->db=$this->load->database('dha5', TRUE);    
         }  else if($dist_code == "14"){
            $this->db=$this->load->database('dha6', TRUE);    
         }  else if($dist_code == "07"){
            $this->db=$this->load->database('dha7', TRUE);    
         }  else if($dist_code == "03"){
            $this->db=$this->load->database('dha8', TRUE);    
         }  else if($dist_code == "18"){
            $this->db=$this->load->database('dha9', TRUE);    
         }  else if($dist_code == "12"){
            $this->db=$this->load->database('dha13', TRUE);   
         }  else if($dist_code == "24"){
            $this->db=$this->load->database('dha10', TRUE);   
         }  else if($dist_code == "06"){
            $this->db=$this->load->database('dha11', TRUE);   
         }  else if($dist_code == "11"){
            $this->db=$this->load->database('dha12', TRUE);   
         }  else if($dist_code == "12"){
            $this->db=$this->load->database('dha13', TRUE);   
         }  else if($dist_code == "16"){
            $this->db=$this->load->database('dha14', TRUE);   
         }  else if($dist_code == "32"){
            $this->db=$this->load->database('dha15', TRUE);   
         }  else if($dist_code == "33"){
            $this->db=$this->load->database('dha16', TRUE);   
         }  else if($dist_code == "34"){
            $this->db=$this->load->database('dha17', TRUE);   
         }  else if($dist_code == "21"){
            $this->db=$this->load->database('dha18', TRUE);   
         }  else if($dist_code == "08"){
            $this->db=$this->load->database('dha19', TRUE);   
         }  else if($dist_code == "35"){
            $this->db=$this->load->database('dha20', TRUE);   
         }  else if($dist_code == "36"){
            $this->db=$this->load->database('dha21', TRUE);   
         }  else if($dist_code == "37"){
            $this->db=$this->load->database('dha22', TRUE);   
         }  else if($dist_code == "25"){
            $this->db=$this->load->database('dha23', TRUE);   
         }  else if($dist_code == "39"){
            $this->db=$this->load->database('dha39', TRUE);   
         }else if($dist_code == "38"){
            $this->db=$this->load->database('dha25', TRUE);   
         }else if($dist_code == "22"){
            $this->db=$this->load->database('dha41', TRUE);   
         }else if($dist_code == "23"){
            $this->db=$this->load->database('dha40', TRUE);   
         }
         return $this->db;                                                                                      
    }

    public function dbswitch()
    {
        //$CI=&get_instance();
        if ($this->session->userdata('dist_code') == "02") {
            $this->db = $this->load->database('dha3', true);
        } else if ($this->session->userdata('dist_code') == "05") {
            $this->db = $this->load->database('dha1', true);
        } else if ($this->session->userdata('dist_code') == "10") {
            $this->db = $this->load->database('dha24', true);
        } else if ($this->session->userdata('dist_code') == "13") {
            $this->db = $this->load->database('dha2', true);
        } else if ($this->session->userdata('dist_code') == "17") {
            $this->db = $this->load->database('dha4', true);
        } else if ($this->session->userdata('dist_code') == "15") {
            $this->db = $this->load->database('dha5', true);
        } else if ($this->session->userdata('dist_code') == "14") {
            $this->db = $this->load->database('dha6', true);
        } else if ($this->session->userdata('dist_code') == "07") {
            $this->db = $this->load->database('dha7', true);
        } else if ($this->session->userdata('dist_code') == "03") {
            $this->db = $this->load->database('dha8', true);
        } else if ($this->session->userdata('dist_code') == "18") {
            $this->db = $this->load->database('dha9', true);
        } else if ($this->session->userdata('dist_code') == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($this->session->userdata('dist_code') == "24") {
            $this->db = $this->load->database('dha10', true);
        } else if ($this->session->userdata('dist_code') == "06") {
            $this->db = $this->load->database('dha11', true);
        } else if ($this->session->userdata('dist_code') == "11") {
            $this->db = $this->load->database('dha12', true);
        } else if ($this->session->userdata('dist_code') == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($this->session->userdata('dist_code') == "16") {
            $this->db = $this->load->database('dha14', true);
        } else if ($this->session->userdata('dist_code') == "32") {
            $this->db = $this->load->database('dha15', true);
        } else if ($this->session->userdata('dist_code') == "33") {
            $this->db = $this->load->database('dha16', true);
        } else if ($this->session->userdata('dist_code') == "34") {
            $this->db = $this->load->database('dha17', true);
        } else if ($this->session->userdata('dist_code') == "21") {
            $this->db = $this->load->database('dha18', true);
        } else if ($this->session->userdata('dist_code') == "08") {
            $this->db = $this->load->database('dha19', true);
        } else if ($this->session->userdata('dist_code') == "35") {
            $this->db = $this->load->database('dha20', true);
        } else if ($this->session->userdata('dist_code') == "36") {
            $this->db = $this->load->database('dha21', true);
        } else if ($this->session->userdata('dist_code') == "37") {
            $this->db = $this->load->database('dha22', true);
        } else if ($this->session->userdata('dist_code') == "25") {
            $this->db = $this->load->database('dha23', true);
        } else if ($this->session->userdata('dist_code') == "39") {
            $this->db = $this->load->database('dha39', true);
        } else if ($this->session->userdata('dist_code') == "38") {
            $this->db = $this->load->database('dha25', true);
        }
    }


    public function fileManualValidation($file_details){
        log_message("error","file details: ".json_encode($file_details));
        $allowed_file_types= explode('|',$file_details->allowed_types);
        $name_pattern = "/^[A-Za-z1-9 ._()]+$/";
        if($file_details->required=='1' && !isset($_FILES[$file_details->file_name])){
            return array('status'=>1,'validation'=> array('field' => $file_details->file_name, 'message' => $file_details->file_details." document is required"));
        }else if(isset($_FILES[$file_details->file_name]) || ($file_details->required=='1' && isset($_FILES[$file_details->file_name]))){
            // FILE NAME SANITIZE
            if(!preg_match($name_pattern, $_FILES[$file_details->file_name]['name'])){
                return array('status'=>1,'validation'=>array('field' => $file_details->file_name, 'message' => "file name should be alpha numeric only eg. docname.pdf"));
            }else{
                log_message("error","allowed types of fie".json_encode($allowed_file_types));
                log_message("error","file_details".json_encode($file_details));
                $mime =  mime_content_type($_FILES[$file_details->file_name]['tmp_name']);
                $ext  =  explode("/",$mime)[1];
                log_message("error","file name".json_decode($file_details->file_name)." has ext: ".json_encode($ext));
                // FILE CONTENT TYPE AND ENTENSIONS CHECK
                if(!in_array($ext,$allowed_file_types)){
                    return array('status'=>1,'validation'=>array('field' => $file_details->file_name, 'message' => "file format not supported, required formats are ".$file_details->allowed_types));
                }else{
                    // FILE SIZE CHECK
                    if($_FILES[$file_details->file_name]['size'] > (int)$file_details->size*1024){
                        // TO CHECK MAX SIZE
                        $validation= array('field' => $file_details->file_name, 'message' => $file_details->file_details." has exceeded allowed file size limit of ".round($file_details->size/1024,2)."mb");
                        return array('status'=>1,'validation'=>$validation);
                    }else if($_FILES[$file_details->file_name]['size'] < 10*1024){
                        // TO CHECK MIN SIZE SO THAT EXCLUDE NULL BYTE FILES
                        $validation= array('field' => $file_details->file_name, 'message' => $file_details->file_details." is below the allowed file size limit of 100kb");
                        return array('status'=>1,'validation'=>$validation);
                    }else{
                        $meta_data= array('file_name'=>$file_details->file_name,'file_details'=>$file_details->file_details,'content_type' => $mime, 'extension' => $ext);
                        log_message("error","meta data of file".json_encode($meta_data));
                        return array('status'=>2,'data'=>$meta_data);
                    }
                }
            }
        }else{
            return;
        }
    }


    public function nrcFileUpload()
    {
        log_message('error',json_encode($_FILES));
        header('content-type:application/json');
        $legacy_yes_or_no = $_POST['legacy_yes_or_no'];
        $relationship = null;

        $id_cat1 = $_POST['id_cat1'];
        $id_cat2 = $_POST['id_cat2'];
        $id_cat3 = $_POST['id_cat3'];
        $id_cat4 = $_POST['id_cat4'];
        $id_cat5 = $_POST['id_cat5'];

        $doc_name1 = $_POST['doc_name1'];
        $doc_name2 = $_POST['doc_name2'];
        $doc_name3 = $_POST['doc_name3'];
        $doc_name4 = $_POST['doc_name4'];
        $doc_name5 = $_POST['doc_name5'];

        // var_dump($_POST);die;

        $descArray = array($doc_name1,$doc_name2,$doc_name3,$doc_name4,$doc_name5);
        $relationCategory = array($id_cat1,$id_cat2,$id_cat3,$id_cat4,$id_cat5);
        log_message("error","VAL09 : ------------VALIDATION START------------- ");
        if($legacy_yes_or_no == 1)
        {
            
            $relationship = $_POST['relationship_yes'];

            $documents_config = json_decode(MULTIPLE_NRC_FILE_UPLOAD_LEGACY_YES);
            if($relationship == 4)
            {
                unset($descArray[1]);
                unset($relationCategory[0]);
                unset($relationCategory[1]);
                unset($documents_config->nrc_add_file1);
                unset($documents_config->nrc_add_file2);
            }
            elseif($relationship == 3)
            {
                unset($descArray[1]);
                unset($descArray[4]);
                unset($relationCategory[0]);
                unset($relationCategory[1]);
                unset($relationCategory[4]);

                unset($documents_config->nrc_add_file1);
                unset($documents_config->nrc_add_file2);
                unset($documents_config->nrc_add_file5);
            }
            elseif($relationship == 2)
            {
                unset($descArray[1]);
                unset($descArray[3]);
                unset($descArray[4]);

                unset($relationCategory[0]);
                unset($relationCategory[1]);
                unset($relationCategory[3]);
                unset($relationCategory[4]);

                unset($documents_config->nrc_add_file1);
                unset($documents_config->nrc_add_file2);
                unset($documents_config->nrc_add_file4);
                unset($documents_config->nrc_add_file5);
            }


        }
        else
        {
            
            $relationship = $_POST['relationship_no'];
            $documents_config = json_decode(MULTIPLE_NRC_FILE_UPLOAD_LEGACY_NO);
            if($relationship == 4)
            {
                unset($descArray[0]);
                unset($relationCategory[0]);
                unset($documents_config->nrc_add_file1);
            }
            elseif($relationship == 3)
            {
                unset($descArray[0]);
                unset($descArray[4]);
                unset($relationCategory[0]);
                unset($relationCategory[4]);

                unset($documents_config->nrc_add_file1);
                unset($documents_config->nrc_add_file5);
            }
            elseif($relationship == 2)
            {
                unset($descArray[0]);
                unset($descArray[3]);
                unset($descArray[4]);

                unset($relationCategory[0]);
                unset($relationCategory[3]);
                unset($relationCategory[4]);

                unset($documents_config->nrc_add_file1);
                // unset($documents_config->nrc_add_file2);
                unset($documents_config->nrc_add_file4);
                unset($documents_config->nrc_add_file5);
            }
        }
        
        $validations=[];
        $document_details=[];
        // log_message("error","------------FILE validation STARTED------------- ".',config='.json_encode($documents_config));
        foreach($documents_config as $key => $value){
            $return= $this->fileManualValidation($value);
            if(!is_null($return)){
                $return['status']==1 ? $validations[]= $return['validation']: $document_details[]= $return['data'];
            }
        }
        // log_message("error","------------FILE validation ENDED--------------- ");

        
        $legacy_code_details = $_POST['legacy_code'];

        $validationsFiles = array();
        foreach ($descArray as $key1 => $value1) 
        {
            $j = $key1 + 1;
            if($j > 1)
            {
                if($value1 == null || $value1 == '')
                {
                    $validationsFiles[]= array('field' => 'doc_name'.$j, 'message' => "file name Missing...");
                }
            }
            
            // code...
        }


        if(!empty($validations)){
            echo json_encode(array(
                'responseType'    => 1,
                'validation'      => $validations,
                'validationFiles' => $validationsFiles
            ));
            return;
        }
        log_message("error","VAL09 : ------------VALIDATION END------------- ");

        // NOW STORE THE FILE
        $appl_no = $_POST['application_id'];
        $case_no = $this->NrcDocModel->getDharCaseNoFromBasu($appl_no); // get dhar no

        $basic=$this->NrcDocModel->getDetailFromSettlementBasic($appl_no);

        $service_code   = $_POST['service_code'];

        $documents=[];
        log_message("error","FILSAVE08 : ------------FILE SAVE STARTED------------- ");

        $doc_name_for_upload1 = $_POST['doc_name1'];
        $doc_name_for_upload2 = $_POST['doc_name2'];

        $id_cat_for_upload1 = $_POST['id_cat1'];
        $id_cat_for_upload2= $_POST['id_cat2'];
        //for first upload==============

        $file_new_name = null;
        $mime = null;
        $file_details = 'NA';
        if($legacy_yes_or_no == 0 && !empty($_FILES['nrc_add_file2']['name']))
        {
            $legacy_code_details = null;
            $doc_name = $doc_name_for_upload2;
            $id_cat   = $id_cat_for_upload2;
            $mime =  mime_content_type($_FILES['nrc_add_file2']['tmp_name']);
            $ext  =  explode("/",$mime)[1];
            $file_new_name= $basic->dist_code.'_'.$basic->id.'_'.$service_code.'_'.time().'.'.$ext;
            $file_details = 'LEGACY_PERSON_DOC';
            $path = UPLOAD_DIR.$file_new_name;
        }
        elseif($legacy_yes_or_no == 1)
        {
            $legacy_code_details = $legacy_code_details;
            $doc_name = $doc_name_for_upload1;
            $id_cat   = $id_cat_for_upload1;
            $path = null;
        }

        //check if data exist in nrc_dicuments table
        $check_nrc = $this->NrcDocModel->getDetailNrcDocuments($case_no); // get dhar no        
        log_message('error', 'getDetailNrcDocuments Count '.$check_nrc->num_rows());
        // echo $this->db->last_query();

        $this->db->trans_begin();

        if($check_nrc->num_rows() > 0) // if data exist
        {
            // if uploaded previously, then set them to 0
            $update = $this->db->query("UPDATE nrc_documents SET is_final=? WHERE case_no=? 
                        AND is_final=?", array(0, $case_no, 1));
            if($this->db->affected_rows() != $check_nrc->num_rows())
            {
                $this->db->trans_rollback();
                log_message("error","MB382: Updation failed ".$this->db->last_query());
                echo json_encode(array(
                    'responseType' => 3,
                    'error'        => 'MB382: Uploading failed. Contact system administrator.'
                ));
                return;
            }
        }

        //insert data of legacy owner
        $document = array(
            'relation'           => $relationship,
            'legacy_flag'        => $legacy_yes_or_no,
            'legacy_code'        => $legacy_code_details,
            'rel_identity'       => $id_cat,
            'doc_holder_name'    => $doc_name,
            'content_type'       => $mime,
            'name'               => $file_new_name,
            'path'               => $path,
            'file_details'       => $file_details,
            'active_status'      => 1,
            'creation_date_time' => date('Y-m-d h:i:s'),
            'uploaded_by'        => $this->session->userdata('user_code'),
            'case_no'            => $case_no,
        );

        $status = $this->db->insert('nrc_documents',$document);
        if($status != 1)
        {
            $this->db->trans_rollback();
            log_message("error","MB415: Insertion failed ".$this->db->last_query());
            echo json_encode(array(
                'responseType' => 3,
                'error'        => 'MB415: Uploading failed. Contact system administrator.'
            ));
            return;
        }

        $doc_id = $this->db->insert_id();

        log_message("error","MB01: insert doc status:".json_encode($status));
        log_message("error","MB02: last query ".$this->db->last_query());

        if($legacy_yes_or_no == 0 && !empty($_FILES['nrc_add_file2']['name']))
        {
            move_uploaded_file($_FILES['nrc_add_file2']['tmp_name'], UPLOAD_DIR.$file_new_name);
            log_message("error","MB02: LEGACY UPLOAD YES===========".json_encode($_FILES['nrc_add_file2']['name']));
        }
        

        //for minimize the uploaded data as first legacy person data already inserted====
        if($legacy_yes_or_no == 1 || $legacy_yes_or_no == 0)
        {
            unset($descArray[0]);
            unset($descArray[1]);
            unset($relationCategory[0]);
            unset($relationCategory[1]);            
        }

        if($legacy_yes_or_no == 0)
        {
            unset($document_details[0]);
        }

        ///CHANGES THE FILTERED ARRAY AS DOCUMENT ARRAY UPDATED=============
        $masterDocHolderName = array();
        foreach ($descArray as $key2 => $value2) {
            $masterDocHolderName[] = $value2;
        }

        ///CHANGES THE FILTERED ARRAY AS DOCUMENT ARRAY UPDATED=============
        $masterRelationCategory = array();
        foreach ($relationCategory as $key1 => $value1) {
            $masterRelationCategory[] = $value1;
        }

        $master_document_details = array();
        foreach ($document_details as $key3 => $value3) {
            $master_document_details[] = $value3;
        }

        // var_dump($masterDocHolderName);

        // var_dump($masterRelationCategory);

        // var_dump($master_document_details);
        // die;


        $rl = (int) $relationship - 1;
        foreach($master_document_details as $key => $value)
        {

            $doc_name = $masterDocHolderName[$key];
            $id_cat   = $masterRelationCategory[$key];
            log_message("error","doc data".json_encode($value));
            $file_new_name= $basic->dist_code.'_'.$basic->id.'_'.$service_code.'_'.$value['file_details'].'_'.time().'.'.$value['extension'];
            $document = array(
                'relation_id'        => $doc_id,
                'relation'           => $rl--,
                'legacy_flag'        => $legacy_yes_or_no,
                'legacy_code'        => $legacy_code_details,
                'rel_identity'       => $id_cat,
                'doc_holder_name'    => $doc_name,
                'content_type'       => $value['content_type'],
                'name'               => $file_new_name,
                'path'               => $path,
                'file_details'       => $value['file_details'],
                'active_status'      => 1,
                'creation_date_time' => date('Y-m-d h:i:s'),
                'uploaded_by'        => $this->session->userdata('user_code'),
                'case_no'            => $case_no,
            );

            $status = $this->db->insert('nrc_documents',$document);

            if($status != 1)
            {
                $this->db->trans_rollback();
                log_message("error","MB503: Insertion failed for dynamic users  ".$this->db->last_query());
                echo json_encode(array(
                    'responseType' => 3,
                    'error'        => 'MB503: Uploading failed. Contact system administrator.'
                ));
                return;
            }

            $doc_id = $this->db->insert_id();

            log_message("error","insert doc status:".json_encode($status));
            log_message("error","last query ".$this->db->last_query());
          
            log_message("error","doc data".json_encode($document));
            move_uploaded_file($_FILES[$value['file_name']]['tmp_name'], UPLOAD_DIR.$file_new_name);

            //insert into settlement proceeding
            $task = 'Inconvertible Hereditary Linkage With 1951 NRC Data has been uploaded';
            $insert = [
                'case_no'              => $case_no,
                'date_of_hearing'      => date('Y-m-d h:i:s'),
                'note_on_order'        => $task,
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'status'               => 'R',
                'user_code'            => $this->session->userdata('user_code'),
                'date_entry'           => date('Y-m-d h:i:s'),
                'operation'            => 'E',
                'ip'                   => $this->input->ip_address(),
                'office_from'          => MB_LOT_MONDOL,
                'office_to'            => MB_LOT_MONDOL,
                'proceeding_id'        => $this->ApplicantChangeModel->getFromProceeding($case_no),
                'task'                 => $task,
            ];
            $ins = $this->db->insert('settlement_proceeding',$insert);
            if($ins != 1)
            {
                $this->db->trans_rollback();
                log_message("error","MB532: Insertion failed in settlement_proceeding ".$this->db->last_query());
                echo json_encode(array(
                    'responseType' => 3,
                    'error'        => 'MB532: Uploading failed. Contact system administrator.'
                ));
                return;
            }
        }
        if ($this->db->trans_status() === FALSE) {
            log_message("error","------------FILE SAVE ENDED WITH ERROR------------- ");
            $this->db->trans_rollback();
            echo json_encode(array(
                'responseType' => 3,
                'error'        => 'Something Went wrong!!!'
            ));
            return;
        } else {

            log_message("error","------------FILE SAVE END------------- ");
            $rowappDocs = $this->db->query("SELECT * FROM nrc_documents WHERE case_no=? and active_status=? order by id asc", array($case_no, 1));
            if($rowappDocs->num_rows() == 0)
            {
                echo json_encode(array(
                    'responseType' => 3,
                    'error'        => 'Something Went wrong!!!'
                ));
                return;
            }
            $masterArray = $rowappDocs->result();
            foreach ($masterArray as $key => $value) {
                $masterArray[$key]->parentName = 'Owner';
                if($value->relation_id != null)
                {
                    $row = $this->db->query("SELECT doc_holder_name FROM nrc_documents WHERE id=? and active_status=?", array($value->relation_id,1))->row();

                    $masterArray[$key]->parentName = $row->doc_holder_name;
                }
                
            }

            // $this->db->trans_rollback();
            $this->db->trans_commit();
            echo json_encode(array(
                'responseType'   => 2,
                'application_id' => $appl_no,
                'doc_file'       => $masterArray,
            ));
            return;
        }
    }
}
