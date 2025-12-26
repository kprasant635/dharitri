<?php
class SettlementNRCFileUploadModel extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->model('SettlementModel/SettlementApModel');

    }
    public function dbswitch($dist_code)
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

    public function uploadNrcFiles($case_no,$nrcDesc,$files,$nrcFileName,$service_code)
    {
        $_FILES = $files;
        $fileCount = count($files);
        $response = array('responseType' => 2,'msg' => null);
        if($fileCount == 0)
        {
            $response['responseType'] =1;
            log_message('error', '#ERRNRCDOC00012: File is missing for supportive document Case No '.$case_no);
            return $response;
        }
        for($i = 0; $i < $fileCount; $i++)
        {

            $_FILES['file']['name'] = $_FILES[$i]['name'];
            $_FILES['file']['type'] = $_FILES[$i]['type'];
            $_FILES['file']['tmp_name'] = $_FILES[$i]['tmp_name'];
            $_FILES['file']['error'] = $_FILES[$i]['error'];
            $_FILES['file']['size'] = $_FILES[$i]['size'];
            
            if($_FILES['file']['name'] != null && $_FILES['file']['name'] != '')
            {

                $mime = mime_content_type($_FILES[$i]['tmp_name']);
                $exp  = explode("/",$mime);
                $onlyExtension  = $exp[1];

                $fileRename =  $this->UUID4() . '.' . $onlyExtension;

                $config['upload_path']   = UPLOAD_DIR;
                $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                $config['max_size']  = UPLOAD_MAX_SIZE;;
                $config['file_name'] = $fileRename;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('file'))
                {

                    $document= array(
                        'case_no'   => $case_no,
                        'file_name' => $nrcFileName[$i],
                        'user_code' => $this->session->userdata('user_code'),
                        'fetch_file_name' =>$_FILES['file']['name'],
                        'file_type'  => $_FILES['file']['type'],
                        'file_path'  => UPLOAD_DIR . $fileRename,
                        'date_entry' => date('Y-m-d h:i:s'),
                        'mut_type'   => $service_code,
                        'file_desc'  => $nrcDesc[$i],
                    );
                    log_message('error','MB:NRC1 POST PARAMS------------'.json_encode($document));
                    
                        // save data in attachment file
                        $nrcDocQuery = $this->db->insert('supportive_document',$document);
                        if($nrcDocQuery != 1)
                        {
                            $response['responseType'] =1;
                            $response['msg'] = 'ERRNRCDOC0009';
                            log_message('error', '#ERRNRCDOC0009: Insertion failed in supportive document DHAR Case No '.$case_no);
                            return $response;
                        }

                
                    

                }
                else
                {
                    $response['responseType'] =1;
                    $response['msg'] ='#ERRNRCDOC00871';
                    log_message('error', '#ERRNRCDOC00871: Insertion failed in supportive document DHAR Case No '.$case_no);
                    return $response;
                }
            }
            
        }
        return $response;


    }
}