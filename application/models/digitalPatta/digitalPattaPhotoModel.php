<?php
class digitalPattaPhotoModel extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    //db_switch method
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
        } else if($this->session->userdata('dist_code') == "39"){
            $this->db=$this->load->database('dha39', TRUE);
        } else if($this->session->userdata('dist_code') == "38"){
            $this->db=$this->load->database('dha25', TRUE);
        }
    }

    //getting primary land holder image used in basundhara
    public function getPrimaryLandHolderImg_old($ref_no)
    {
        //$this->db = $this->load->database('default', TRUE);
        $getAadhaar = $this->db->query("SELECT upload_path FROM aadhaar_verification WHERE ref_no=?",array($ref_no));
        $upload_path = $getAadhaar->row()->upload_path; 
        $open_adhar_file = fopen($upload_path, "r") or die("Unable to open file!");
        $read_adhar_file = fread($open_adhar_file, filesize($upload_path));
        fclose($open_adhar_file);
        return $read_adhar_file;
    }

    //method to get the aadhaar phto of primary land holder for digital patta
    public function getPrimaryLandHolderImg($settlement_applicant_data,$case_no)
    {
        $applid =$this->DigitalPattaCommonModel->getApplidFromCaseNo($case_no);

        $adhar_photo_link = $settlement_applicant_data->identity_doc_link;
        if(!file_exists($adhar_photo_link))
        {

            $parts = explode("uploads/", $adhar_photo_link, 2);
            if (count($parts) > 1) {
                $adhar_photo_link = BACKUP_DIR."uploads".UPLOAD_SEPARATOR . $parts[1];
            }
            else
            {
                $adhar_photo_link = $adhar_photo_link;
            }

            if(!file_exists($adhar_photo_link))
            {
                $url = API_LINK_MB2."getApplicantPhoto";
                $arrayData =array(
                    'application_no' => $applid,
                );
                //$url = API_LINK_MB2."getApplicantPhoto";
                //$url = "http://localhost/mb_ekhajana/Api/getApplicantPhoto";
                $arrayData =array(
                    'application_no' => $applid,
                );
                //***API call again for aadhar photo missing */
                $aadhaarPhotoReCall = $this->curlPost($url, $arrayData);

                if($aadhaarPhotoReCall == true)
                {
                    $aadhar_path = $adhar_photo_link;
                    $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file!");
                    $aadhaar_encoded_file = $aadhaarPhotoReCall;
                    fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                    fclose($aadhaar_file_to_write_base64);
                }
                else
                {
                    echo json_encode(array('ERROR885784: API Response fail!'));
                    return false;
                }
            }
        }
        //****reopening the updated file */
        $open_adhar_file = fopen($adhar_photo_link, "r") or die("Unable to open file!");
        $read_adhar_file = fread($open_adhar_file, filesize($adhar_photo_link));
        fclose($open_adhar_file);
        // decoding the base64 encoding file variable
        $photo = "<img src = data:".$this->decodeBase64($read_adhar_file).";base64,".$read_adhar_file." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
            
        return $photo;
    }

    //curl to get the photo from basundhara if not found in dharitree
    public function curlPost($url, $arrayData)
    {
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query($arrayData));
        $result = curl_exec($curl_handle);
        $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
        curl_close($curl_handle);
        if($httpcode !=200 || $result == null){
            return false;
        }
        else
        {
            return $result;
        }
    }

    //method to decode base 64
    public function decodeBase64($encoded_string){
        $file_data= base64_decode($encoded_string);
        $file = finfo_open();
        $mime_type = finfo_buffer($file, $file_data, FILEINFO_MIME_TYPE);
        $file_type = explode('/', $mime_type)[0];
        $extension = explode('/', $mime_type)[1];
        log_message("error","No error occured".json_encode($mime_type));
        return $mime_type;
    } 

    public function getSketchOfDag($case_no)
    {
        $query = $this->db->query("select * from supportive_document where file_name  = 'Trace Map Copy' and case_no = ?",array($case_no));
        $result = $query->row();
           
        $file = $result->file_path;
        $content_type = $result->file_type;
        return [
            'file' => $file,
            'content_type' => $content_type,

        ];
    }
    
}
?>