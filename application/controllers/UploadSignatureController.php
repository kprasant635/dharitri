<?php
class UploadSignatureController extends CI_Controller {

    public function __construct() {
        parent::__construct();
 
    }


    public function index(){
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');

        $sql = $this->db->query('select * from users where dist_code = ? and subdiv_code = ? and cir_code = ? and user_code = ? and user_sign1 is not null', array($dist_code, $subdiv_code, $cir_code, $user_code));

        $lmdata['sign'] = false;
        if($sql->num_rows() > 0){
            $lmdata['sign'] = pg_unescape_bytea($sql->row()->user_sign1);
        }
        if($lmdata['sign'] != false){
            $base64Image = base64_encode($lmdata['sign']);
            $tempFile = tempnam(sys_get_temp_dir(), 'img');
            file_put_contents($tempFile, $lmdata['sign']);
            $fileMimeType = mime_content_type($tempFile);
            unlink($tempFile);
            $lmdata['sign'] = '<img max-height ="200" max-width="500" src="data:' . $fileMimeType . ';base64,' . $base64Image . '" />';
        }

        $lmdata['_view'] = 'UploadSignature/index';
        $this->load->view('layouts/main', $lmdata);




    }

    public function uploadSignatureReview(){

        if (!isset($_FILES['signature_file']) && $_FILES['signature_file']['error'] == UPLOAD_ERR_OK) {
            echo json_encode([
                'responseType'  => 0,
                'msg'           => '#ERR272: Inputs should not be empty!'
            ]);
            return false;
        }
    
        $fileTmp = $_FILES['signature_file'];
    
        if(empty($fileTmp)){
            echo json_encode([
                'responseType'  => 0,
                'msg'           => '#ERR22: Inputs should not be empty!'
            ]);
            return false;
        }

        // Check file extension
        $fileExtension = strtolower(pathinfo($fileTmp['name'], PATHINFO_EXTENSION));
        if ($fileExtension !== 'png' && $fileExtension !== 'jpg' && $fileExtension !== 'jpeg') {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR31: Please upload a .png/.jpg/.jpeg file!'
            ]);
            return false;
        }

        // Check file size
        $maxFileSize = .1 * 1024 * 1024;
        if ($fileTmp['size'] > $maxFileSize) {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR33: File is too large. Maximum allowed size is 100KB.'
            ]);
            return false;
        }

        $maxWidth = 500;  
        $maxHeight = 200; 

        // Check image dimensions
        list($width, $height) = getimagesize($fileTmp['tmp_name']);
        if ($width > $maxWidth || $height > $maxHeight) {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR3233: Signature dimensions should not exceed ' . $maxWidth . 'x' . $maxHeight . ' pixels.'
            ]);
            return false;
        }

        // Check file content
        $fileTmpPath = $fileTmp['tmp_name'];
        $fileContent = file_get_contents($fileTmpPath);

        $base64Image = base64_encode($fileContent);
        $fileMimeType = mime_content_type($fileTmpPath);
        $preview_image = '<img max-height ="200" max-width="500" src="data:' . $fileMimeType . ';base64,' . $base64Image . '" />';

        if ($fileContent === false) {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR34: Failed to read file content.'
            ]);
            return false;
        }

        $preview = '<div class="container bg-white shadow pb-3" id="print_direct">
                    <div class="row mt-5 text-center">
                        <div class="col-12 text-center" style="font-size: 18px; font-weight:bold;">
                            অসম চৰকাৰ <br>
                            জিলা আয়ুক্তৰ কাৰ্য্যলয়: জিলা – ---<br>
                            জাননী
                        </div>
                    </div>
                    <div class="row mt-5 px-5">
                        <div class="col-3">
                            No : ---
                        </div>
                        <div class="col-9 text-right">
                            Dated :---
                        </div>
                    </div>

                    <div class="row mt-5 px-5">
                        <div class="col-12 text-justify">
                            প্ৰতি, ----
                            ঠিকনা : ----
                            
                            <br><br>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Impedit earum qui distinctio ex, illo iure libero animi reprehenderit similique odit laboriosam. Nam molestiae eos illum autem voluptatum nisi aperiam ducimus.
                        
                            <br><br>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Impedit earum qui distinctio ex, illo iure libero animi reprehenderit similique odit laboriosam. Nam molestiae eos illum autem voluptatum nisi aperiam ducimus.

                            <br><br>

                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Impedit earum qui distinctio ex, illo iure libero animi reprehenderit similique odit laboriosam. Nam molestiae eos illum autem voluptatum nisi aperiam ducimus.

                        </div>
                    </div>

                    <div class="row mt-5 justify-content-end mb-5">
                        <div class="col-5 text-center mt-5">

                            '.$preview_image.'
                            <br>
                            <b>My Name</b><br>
                            জিলা ----- <br>
                            জিলা - ----
                        </div>
                    </div>
                </div>';


        echo json_encode([
            'responseType' => 2,
            'content' => $preview,
            'image_data' => $base64Image
        ]);
    }


    public function saveSignature(){
        $image_data = $this->input->post('image_data');

        $fileBinary = base64_decode($image_data);

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');

        $input = [
            'user_sign1' => pg_escape_bytea($fileBinary)
        ];

        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('user_code', $user_code);
        $this->db->update('users', $input);

        if($this->db->affected_rows() != 1){
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR1386: Unable to upload signaure!'
            ]);
            return false;
        }

        echo json_encode([
            'responseType' => 2,
            'msg' => 'Signature uploaded successfully...'
        ]);
    }



}