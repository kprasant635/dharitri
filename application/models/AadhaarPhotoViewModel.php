<?php
class AadhaarPhotoViewModel extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }

    public function aadhaarPhotoView($applNo)
    {
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, RTPS_API_LINK."getApplicantPhoto");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
        'application_no' => $applNo,
        )));
        $get_aadhaar_photo = curl_exec($curl_handle);
        curl_close($curl_handle);
        return $get_aadhaar_photo;
    }

    public function fromBasundharApplication($dharCaseNo)
    {
        return $query = $this->db->query("SELECT basundhara FROM basundhar_application WHERE dharitree=?", array($dharCaseNo))->row();
    }

    public  function decodeBase64($encoded_string){
        $file_data = base64_decode($encoded_string);
        $file      = finfo_open();
        $mime_type = finfo_buffer($file, $file_data, FILEINFO_MIME_TYPE);
        $file_type = explode('/', $mime_type)[0];
        $extension = explode('/', $mime_type)[1];
        log_message("error","No error occured".json_encode($mime_type));
        return $mime_type;
    }

}