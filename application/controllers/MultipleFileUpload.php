<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
defined('MULTIPLE_FILE_UPLOAD_MAX') or define('MULTIPLE_FILE_UPLOAD_MAX', '{
    "multiple_file":{"file_name":"mul_file","file_details":"Other docs","required":"1","size":"2048","allowed_types":"pdf|jpg|jpeg|png"}
}');
class MultipleFileUpload extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
    }
    public function multipleFileSave()
    {
        log_message('error', json_encode($_POST));
        // $this->checkUserLoginOrNot();
        header('content-type:application/json');
        $documents_config = json_decode(MULTIPLE_FILE_UPLOAD_MAX);
        $validations      = [];
        $document_details = [];
        log_message("error", "------------FILE validation STARTED------------- " . ',config=' . json_encode($documents_config));
        foreach ($documents_config as $key => $value) {
            $return = $this->fileManualValidation($value);
            if (! is_null($return)) {
                $return['status'] == 1 ? $validations[] = $return['validation'] : $document_details[] = $return['data'];
            }
        }
        if (! empty($validations)) {
            echo json_encode([
                'responseType' => 1,
                'validation'   => $validations,
            ]);
            return;
        }
        // NOW STORE THE FILE
        $application_id = $_POST['application_id'];
        $doc_name       = $_POST['doc_name'];
        $documents      = [];
        $this->db->trans_begin();
        foreach ($document_details as $value) {
            log_message("error", "doc data" . json_encode($value));
            $file_new_name = str_replace("/", "_", $application_id) . '_' . time() . '.' . $value['extension'];
            $document      = [
                'case_no'         => $application_id,
                'file_path'       => UPLOAD_DIR . $file_new_name,
                'file_name'       => $doc_name,
                'user_code'       => 'CO',
                'date_entry'      => date('Y-m-d H:i:s'),
                'file_type'       => $value['content_type'],
                'fetch_file_name' => $file_new_name,
                'mut_type'        => '01',
                'applid'          => 'test',
            ];
            $status = $this->db->insert('supportive_document', $document);
            log_message("error", "insert doc status:" . json_encode($status));
            log_message("error", "last query" . json_encode($this->db->last_query()));
            log_message("error", "doc data" . json_encode($document));
            if (! move_uploaded_file($_FILES[$value['file_name']]['tmp_name'], UPLOAD_DIR . $file_new_name)) {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 3,
                    'error'        => 'Something Went wrong--1!!!',
                ]);
                return;
            }
        }
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 3,
                'error'        => 'Something Went wrong--2!!!',
            ]);
            return;
        } else {
            log_message("error", "------------FILE SAVE END------------- ");
            $this->db->trans_commit();
            //////////////////////////////////////
            $sql = "Select case_no,file_name,file_path,id from supportive_document  where case_no=? order by id desc limit 1";
            $row = $this->db->query($sql, [$application_id]);
            if ($row->num_rows() > 0) {
                $rowData = $row->row_array();
                echo json_encode([
                    'responseType'   => 2,
                    'application_id' => $application_id,
                    'doc_file'       => $rowData['file_name'],
                    'doc_id'         => $rowData['id'],
                    'file_path'      => $rowData['file_path'],
                ]);
                return;
            } else {
                echo json_encode([
                    'responseType' => 3,
                    'error'        => 'Something Went wrong--3!!!',
                ]);
                return;
            }
            /////////////////////////////////////
        }
    }
    public function deleteFile()
    {
        $doc_id       = $this->input->post('doc_id');
        $table        = 'supportive_document';
        $deleteStatus = $this->db->query("DELETE FROM $table WHERE id=?", [$doc_id]);
        if ($deleteStatus) {
            $json = [
                'responseType' => 3,
                'message'      => 'Successfully Removed',
                'doc_id'       => $doc_id,
            ];
        } else {
            $json = [
                'responseType' => 2,
                'message'      => 'Something went wrong--4...',
                'doc_id'       => $doc_id,
            ];
        }
        echo json_encode($json);
        return;
    }
    public function viewfile($doc_id)
    {
        $url_segment = $this->uri->segment(3);
        if (strlen($url_segment) >= 10) {
            $random_prefix = substr($url_segment, 0, 5);  // Extract the first 5 characters (prefix)
            $random_suffix = substr($url_segment, -5);    // Extract the last 5 characters (suffix)
            $doc_id        = substr($url_segment, 5, -5); // Extract the doc_id by removing prefix and suffix
                                                          // echo "Random Prefix: " . $random_prefix . "<br>";
                                                          // echo "Random Suffix: " . $random_suffix . "<br>";
                                                          // echo "Extracted doc_id: " . $doc_id . "<br>";
        } else {
            echo "Wrong Application Number";
            exit;
        }
        $table      = 'supportive_document';
        $viewStatus = $this->db->query("Select * FROM $table WHERE id=?", [$doc_id]);
        if ($viewStatus->num_rows() > 0) {
            $data = $viewStatus->row_array();
            if (file_exists($data['file_path'])) {
                $mime_type = $data['file_type'];
                $file_path = $data['file_path'];
                switch ($mime_type) {
                    case 'application/pdf':
                        header('Content-Type: application/pdf');
                        header('Content-Disposition: inline; filename="' . basename($file_path) . '"');
                        readfile($file_path);
                        exit;
                    case 'image/jpeg':
                        header('Content-Type: ' . $mime_type);
                        readfile($file_path);
                        exit;
                    case 'image/png':
                        header('Content-Type: ' . $mime_type);
                        readfile($file_path);
                        exit;
                    case 'image/gif':
                        header('Content-Type: ' . $mime_type);
                        readfile($file_path);
                        exit;
                    default:
                        header('Content-Type: application/octet-stream');
                        header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
                        readfile($file_path);
                        exit;
                }
            } else {
                echo "File not found!";
            }
        } else {
            $json = [
                'responseType' => 2,
                'message'      => 'Something went wrong...',
                'doc_id'       => $doc_id,
            ];
        }
        echo json_encode($json);
        return;
    }

    public function getLRAFiles()
    {
        $case_no = urldecode($this->input->get('case_no'));
        $table   = 'supportive_document';

        // Query files for the case
        $sql   = "SELECT * FROM $table WHERE case_no = ? AND mut_type = '01'";
        $query = $this->db->query($sql, [$case_no]);

        $data = [];
        if ($query && $query->num_rows() > 0) {
            foreach ($query->result_array() as $file) {
                // Generate hashId: random 10 hex + file id + random 10 hex
                $prefix = substr(bin2hex(random_bytes(3)), 0, 5);
                $suffix = substr(bin2hex(random_bytes(3)), 0, 5);
                $hashId = $prefix . $file['id'] . $suffix;

                // Add the file data along with the path URL
                $file['file_path'] = "MultipleFileUpload/viewfile/{$hashId}";

                // You can also add hashId explicitly if you want
                $file['hashId'] = $hashId;

                $data[] = $file;
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function fileManualValidation($file_details)
    {
        log_message("error", "file details: " . json_encode($file_details));
        $allowed_file_types = explode('|', $file_details->allowed_types);
        $name_pattern       = "/^[A-Za-z1-9 ._()]+$/";
        if ($file_details->required == '1' && ! isset($_FILES[$file_details->file_name])) {
            return ['status' => 1, 'validation' => ['field' => $file_details->file_name, 'message' => $file_details->file_details . " document is required"]];
        } else if (isset($_FILES[$file_details->file_name]) || ($file_details->required == '1' && isset($_FILES[$file_details->file_name]))) {
            // FILE NAME SANITIZE
            if (! preg_match($name_pattern, $_FILES[$file_details->file_name]['name'])) {
                return ['status' => 1, 'validation' => ['field' => $file_details->file_name, 'message' => "file name should be alpha numeric only eg. docname.pdf"]];
            } else {
                log_message("error", "allowed types of fie" . json_encode($allowed_file_types));
                log_message("error", "file_details" . json_encode($file_details));
                $mime = mime_content_type($_FILES[$file_details->file_name]['tmp_name']);
                $ext  = explode("/", $mime)[1];
                log_message("error", "file name" . json_decode($file_details->file_name) . " has ext: " . json_encode($ext));
                // FILE CONTENT TYPE AND ENTENSIONS CHECK
                if (! in_array($ext, $allowed_file_types)) {
                    return ['status' => 1, 'validation' => ['field' => $file_details->file_name, 'message' => "file format not supported, required formats are " . $file_details->allowed_types]];
                } else {
                    // FILE SIZE CHECK
                    if ($_FILES[$file_details->file_name]['size'] > (int) $file_details->size * 1024) {
                        // TO CHECK MAX SIZE
                        $validation = ['field' => $file_details->file_name, 'message' => $file_details->file_details . " has exceeded allowed file size limit of " . round($file_details->size / 1024, 2) . "mb"];
                        return ['status' => 1, 'validation' => $validation];
                    } else if ($_FILES[$file_details->file_name]['size'] < 10 * 1024) {
                        // TO CHECK MIN SIZE SO THAT EXCLUDE NULL BYTE FILES
                        $validation = ['field' => $file_details->file_name, 'message' => $file_details->file_details . " is below the allowed file size limit of 100kb"];
                        return ['status' => 1, 'validation' => $validation];
                    } else {
                        $meta_data = ['file_name' => $file_details->file_name, 'file_details' => $file_details->file_details, 'content_type' => $mime, 'extension' => $ext];
                        log_message("error", "meta data of file" . json_encode($meta_data));
                        return ['status' => 2, 'data' => $meta_data];
                    }
                }
            }
        } else {
            return;
        }
    }
}
