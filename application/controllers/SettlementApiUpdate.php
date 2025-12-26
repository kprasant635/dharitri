<?php
class SettlementApiUpdate extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        
        // $this->dbswitch();
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

    public function pendingApiUpdate($d){
      $this->dbswitch($d);
      $sql="SELECT * FROM settlement_basic WHERE pending_officer=?";
      $caseQuery=$this->db->query($sql, 'ADC');
      
      if($caseQuery->num_rows()>0)
      {
          $cases=$caseQuery->result();
          foreach($cases as $case){

            $apilink=API_LINK_MB2;
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, $apilink."getPendingWith");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application_no' => $case->applid,
            )));

            $result = curl_exec($curl_handle);
            $httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
            curl_close($curl_handle);
            if($httpcode != 200){
                return false;
            }
            $apiresult = json_decode($result);

            // $url = $apilink."getPendingWith?application_no=" . $case->applid;;
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, $url);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
            // $output = curl_exec($ch);
            
            // $output = json_decode($output);
          

            if($apiresult->pending_with !='ADC'){

                  $rmk='Forwarded to ADC';
                  $status='M';
                  $task='CO';
                  $pen='ADC';
                  $case=$case->case_no;
                  $application_no = $case->applid;
                  $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no, $case, $rmk, $status, $task, $pen);
                  $rtps_status=json_decode($rtps_status);
                  if (trim($rtps_status)!="y") {
                      $this->session->set_flashdata('message', "Error #ERRAPI0001: Unable to update pending officer case no # $case");
                      redirect(base_url() . "index.php/home");
                  } else {
                      
                  }

                  // $this->session->set_flashdata('message', "Application Successfully Forwarded to ".$pending_officer." With Case No # ".$case_no);
                  // redirect(base_url() . "index.php/home");
            }
        }
      }
  }

}
