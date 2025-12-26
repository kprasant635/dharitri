<?php
class CaseTransferLduAdc extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
		    $this->load->helper('file');
        $this->load->helper('download');
        $this->dbswitch();
    }
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
     }  else if($this->session->userdata('dist_code') == "39"){
        $this->db=$this->load->database('dha39', TRUE);   
     }  else if($this->session->userdata('dist_code') == "38"){
        $this->db=$this->load->database('dha25', TRUE);   
     }  else if($this->session->userdata('dist_code') == "22"){
        $this->db=$this->load->database('dha41', TRUE);   
     }  else if($this->session->userdata('dist_code') == "23"){
        $this->db=$this->load->database('dha40', TRUE);   
     }                                                                                                                                                                                                   
  }
	function index(){
      $db=  $this->session->userdata('db');
      $dist_code = $this->session->userdata('dist_code');
      $dist_name = $this->utilityclass->getDistrictName($dist_code);
      $user_code = $this->session->userdata('user_code');
      
      $district['datas'] = array(
              'dist_code' => $dist_code,
              'dist_name' => $dist_name
      );

      $q="Select use_name,user_code,dist_code from loginuser_table where dist_code='$dist_code' and dis_enb_option='E' and user_code='$user_code' and priv='adm' ";
      $district['adclist']=$this->db->query($q)->result();

      $circles ="select loc_name AS circle,cir_code,subdiv_code from location where dist_code ='07' and cir_code !='00' and mouza_pargona_code='00'";
      $district['circle_list']=$this->db->query($circles)->result();
      $district['_view'] = 'transfer/adc_ldu_transfer';
      $this->load->view('layouts/main',$district);
	}

  public function convertLiteral($array)
    {
        $index = 0;
        $final_str = '';
        foreach ($array as $a) {
            if ($index == 0) {
                $final_str = "'" . $a . "'";
            } else {
                $final_str = $final_str . ",'" . $a . "'";
            }

            $index++;
        }
        return $final_str;
    }

	function Update(){
      $db=  $this->session->userdata('db');
      $adc_usercode=$this->input->post('user_code');
      $dist_code=$this->session->userdata('dist_code');
      $adc_name=$this->utilityclass->getSelectedADCName($dist_code,$adc_usercode);


      $circle_array = array();
      $circle_array = $_POST['circle_code'];
      
      $circle_string = null;

      if (!empty($circle_array) && $circle_array != null) {
        $circle_string = $this->convertLiteral($circle_array);
      }

      // var_dump($circle_string); die;

      $circle_bifurcate = "and subdiv_code ||'_' || cir_code in ($circle_string)";
        

      // if (isset($_POST['circle_code'])) {
      //   $selectedCircles = $_POST['circle_code'];


      //   foreach ($selectedCircles as $loc) {
      //     $values = explode(",", $loc);
      //     $subdiv_code[] = $values[0];
      //     $cir_code[] = $values[1];
      //   }



        // $formatted_subdiv_code = "'" . implode("','", $subdiv_code) . "'";
        // $formatted_cir_code = "'" . implode("','", $cir_code) . "'";
        
        // var_dump($formatted_subdiv_code); die;

      // }
      
      $q="select case_no,subdiv_code,cir_code from t_legacyupdation where co_yn is not null and dc_yn is null and status = 'P' and dist_code=? $circle_bifurcate and dc_adc_code !=?";
      $case_list=$this->db->query($q, array($dist_code, $adc_usercode))->result();
      // var_dump($this->db->last_query()); die;

      foreach ($case_list as $case) {
        $this->db->trans_begin();

        // $this->db->query("Update t_legacyupdation set dc_adc_code='$adc_usercode'  where co_yn is not null and dc_yn is null and status = 'P' and dist_code='$dist_code' and case_no='$case->case_no'");
        $legacyupdation_update_arr = [
          'dc_adc_code' => $adc_usercode
        ];

        $this->db->where('co_yn IS NOT NULL');
        $this->db->where('dc_yn IS NULL');
        $this->db->where('status', 'P');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('case_no', $case->case_no);
        $this->db->update('t_legacyupdation', $legacyupdation_update_arr);
        if($this->db->affected_rows() <= 0)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERROR001: Updation failed in t_legacyupdation RTPS Case No '.$case->case_no);
            $this->session->set_flashdata('message', "ADC not updated!!!");
            redirect(base_url().'index.php/home');
        }


        // proceeding start
        $proceeding = $this->db->query("select count(proceeding_id) as proceed from    petition_proceeding where case_no = '$case->case_no' limit 1")->result();
        $proceeding_id = $proceeding[0]->proceed + 1;

        $proceeding_data_ldu = array(
            'case_no' => $case->case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => date('Y-m-d h:i:s'),
            'co_order' => 'Case pulled by '.$adc_name->username,
            //'note_on_order' => '',
            //'next_date_of_hearing' => $hearing_date,
            'status' => 'pending',
            'user_code' => $adc_usercode,
            'date_entry' => date('Y-m-d h:i:s'),
            'operation' => 'E',
            'dist_code' => $dist_code,
            'subdiv_code' => $case->subdiv_code,
            'cir_code' => $case->cir_code
        );
        

        $insert_pp5 = $this->db->insert('petition_proceeding', $proceeding_data_ldu);
        if($insert_pp5 != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRCONVDC0017: Insertion failed in petition_proceeding for case no :'. $case->case_no);
            $json = [
                'message'=>"#ERRCONVDC0017: Failed to in Proceeding for Case No : ".$case->case_no
            ];
            echo json_encode($json);
            return false;
        }

        // proceeding end


        // echo "You selected: $case->case_no<br>";

        // die;
        $this->db->trans_commit();

      }
      // var_dump($case_list); die;
      
      $this->session->set_flashdata('message', "All cases pulled!!!");
      redirect(base_url().'index.php/home');
	}
}