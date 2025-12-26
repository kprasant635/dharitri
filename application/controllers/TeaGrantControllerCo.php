<?php
class TeaGrantControllerCo extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('patta/pattamodel');
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->helper('file');
    $this->load->helper('download');
    $this->load->model('basundhara/SettlementApiModel');
    $this->load->model('rtps/rtpsmodel');
    $this->load->model('SettlementModel/SettlementApModel');
    $this->load->model('TeaGrant/LM/TeaGrantModel');
    $this->load->model('SettlementModel/SettlementVgrModel');
    $this->load->model('SettlementModel/SettlementCommonModel');
    $this->load->library('AES');
    $this->load->model('SettlementModel/SettlementNRCFileUploadModel');
    $this->load->model('UtilsModel');
    $this->load->model('SettlementMb/SettlementCommonDcModel');


    $allowed = ['CO'];
    $user_desig_code = $this->session->userdata('user_desig_code');

    // Restrict access if not in allowed list
    if ( ! in_array($user_desig_code, $allowed)) {
        echo json_encode(['error' => 'Unauthorized access']);
        exit; // or die();
    }


    $this->dbswitch();

    if(HOLD_All_MB2_CASES_STATUS == 1)
    {
      if(strtotime(HOLD_All_MB2_CASES_DATE) < strtotime(date('Y-m-d H:i:s')))
      {
        $this->session->set_flashdata('message', " Processing of settlement MB 2.0 Cases has been stopped !");
        redirect(base_url() . "index.php/Home/index");
      }
    }
  }

  protected function dbswitch()
  {
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
    } else if ($this->session->userdata('dist_code') == "22") {
      $this->db = $this->load->database('dha41', true);
    }
  }

  protected function decodeBase64($encoded_string){
    $file_data = base64_decode($encoded_string);
    $file      = finfo_open();
    $mime_type = finfo_buffer($file, $file_data, FILEINFO_MIME_TYPE);
    $file_type = explode('/', $mime_type)[0];
    $extension = explode('/', $mime_type)[1];
    log_message("error","No error occured".json_encode($mime_type));
    return $mime_type;
  }

  public function FirstProceeding()
  {
    $service_code        = $this->input->get('service');
    $status              = $this->input->get('s');
    $data['SELECT_data'] = $this->SettlementCommonModel->locationSELECT($service_code, $status);
    $data['_view']       = 'TeaGrant/CO/TeaGrantFirstProceedingCo';
    $this->load->view('layouts/main', $data);
  }

  public function getLotsFromMouzaCo()
  {
    $dist_code          = $this->session->userdata('dist_code');
    $subdiv_code        = $this->session->userdata('subdiv_code');
    $cir_code           = $this->session->userdata('cir_code');
    $mouza_pargona_code = $this->input->post('mouza_pargona_code');
    $lot_no             = $this->input->post('lot_no');

    if(!empty($mouza_pargona_code))
    {
      $this->db->SELECT('loc_name, lot_no, vill_townprt_code');
      $this->db->from('location');
      $this->db->where('dist_code', $dist_code);
      $this->db->where('subdiv_code', $subdiv_code);
      $this->db->where('cir_code', $cir_code);
      $this->db->where('mouza_pargona_code', $mouza_pargona_code);

      if(!empty($lot_no))
      {
        $this->db->where('lot_no =', $lot_no);
        $this->db->where('vill_townprt_code !=', '00000');
      }
      else
      {
        $this->db->where('lot_no !=', '00');
        $this->db->where('vill_townprt_code', '00000');
      }

      $query = $this->db->get();
      $result = $query->result();

      if(!empty($lot_no))
      {
        echo json_encode([
          'responseType'    => 2,
          'lot_details'     => '',
          'village_details' => $result,
        ]);
      }
      else
      {
        echo json_encode([
          'responseType'    => 2,
          'lot_details'     => $result,
          'village_details' => '',
        ]);
      }
    }
    else
    {
      echo json_encode([
        'responseType'    => 2,
        'lot_details'     => '',
        'village_details' => '',
      ]);
    }
  }

  public function convertLiteral($array) {
    $index = 0;
    $final_str = '';
    foreach($array as $a)
    {
        if ($index == 0)
            $final_str = "'".$a."'";
        else
            $final_str = $final_str.",'". $a."'";
        $index++;
    }
    return $final_str;
  }

  public function caseListUnderMappingLot()
  {
    $dist_code    = $this->session->userdata('dist_code');
    $subdiv_code  = $this->session->userdata('subdiv_code');
    $cir_code     = $this->session->userdata('cir_code');
    $user_code    = $this->session->userdata('user_code');
    //////////////////MARKING FOR CIRCLE WISE LOT MAPPING===========
    
    $sql="SELECT user_code from loginuser_table where dist_code=? and subdiv_code=? and cir_code=? and dis_enb_option='E' and user_code like 'CO%'";

    $data=$this->db->query($sql,array($dist_code,$subdiv_code,$cir_code));
    
    $lot_array = array();

    if($data->num_rows()> 1)
    {
      $sql1="SELECT * from user_attached_mapping where dist_code=? and subdiv_code=? and cir_code=? and user_code=? ";
      $data1=$this->db->query($sql1,array($dist_code,$subdiv_code,$cir_code,$user_code));

      foreach ($data1->result() as $key => $value) {
        $lot_array[] = $value->mouza_pargona_code.'_'.$value->lot_no;
      }
        //////////////////
    }
    $lot_string = null;
    if(!empty($lot_array) && $lot_array!=null){
      $lot_string = $this->convertLiteral($lot_array);
    }
    log_message("error","MB: LOT STRING====FOR CIRCLE==D".$dist_code."S".$subdiv_code."C".$cir_code."==".json_encode($lot_string));
    return $lot_string;
  }

  public function pagination()
  {
    if(LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO'){
      $lot_string = $this->caseListUnderMappingLot();
    }

    $s_code             = $this->input->post('service');
    $search_term        = $this->input->post('search_term');
    $remark_cat         = $this->input->post('remark_cat');
    $reverted           = $this->input->post('reverted');
    $user_code          = $this->session->userdata('user_code');
    $payment_status     = $this->input->post('payment_status');

    $mouza_pargona_code = $this->input->post('mouza_pargona_code');
    $lot_no             = $this->input->post('lot_no');
    $nr_cat             = $this->input->post('nr_cat');

    $status             = $this->input->post('status');
    $draw               = intval($this->input->post('draw'));
    $start              = intval($this->input->post('start'));
    $length             = intval($this->input->post('length'));
    $order              = $this->input->post('order');

    $pagination         = $this->input->post('pagination');


    $final_verification_report = $this->input->post('final_verification_report');
    $co_approved               = $this->input->post('co_approved');

    $col = 0;
    $dir = "";
    $search = $this->input->post('search');
    $search = $search['value'];

    $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
    $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];
    $searchByCol_3 = $this->input->post('columns')[3]['search']['value'];

    $is_cat        = $this->input->post('is_category');

    if (!empty($order)) {
      foreach ($order as $o) {
        $col = $o['column'];
        $dir = $o['dir'];
      }
    }

    if ($dir != "asc" && $dir != 'desc') {
      $dir = 'asc';
    }

    $valid_columns = array(
      0 => 'date_entry',
      // 1   => 'applid',
    );

    if (!isset($valid_columns[$col])) {
      $order = null;
    } else {
      $order = $valid_columns[$col];
    }

    if ($order != null) {
      $this->db->order_by($order, $dir);
    }

    if (!empty($searchByCol_0)) {
      $this->db->like('a.case_no', strtoupper($searchByCol_0));
    }

    if (!empty($searchByCol_1)) {
      $this->db->like('a.applid', strtoupper($searchByCol_1));
    }

    if (!empty($searchByCol_3)) {
      $this->db->like('TO_CHAR(a.date_entry,\'yyyy-mm-dd\')', $searchByCol_3);
    }

    $this->db->limit($length, $start);

    $this->db->where('a.service_code', $s_code);

    if(!empty($remark_cat))
    {  //settlement_ap_lmnote, lm_note
      $this->db->where('b.lm_note', $remark_cat);
    }

    if(!empty($mouza_pargona_code))
    {
      $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
    }

    if(!empty($mouza_pargona_code) && !empty($lot_no))
    {
      $this->db->where('a.lot_no', $lot_no);
    }

    if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
      $this->db->where('a.vill_townprt_code', $is_cat);
    }

    if (trim($reverted) == 'LM'){
      $this->db->where('a.pending_officer', MB_LOT_MONDOL);
    }
    else if (trim($reverted) == 'ADC'){
      $this->db->where_not_in('a.pending_officer',array(MB_LOT_MONDOL,MB_SUPERVISOR_KANANGU,MB_CIRCLE_OFFICER));
    }
    else {
      $this->db->where_in('a.pending_officer', array(MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU));
    }
    if ($this->session->userdata('user_desig_code') == 'CO'){
      // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
      if(LOT_BIFURCATE ==1 && empty($mouza_pargona_code) && empty($lot_no)){
        if(isset($lot_string) && $lot_string != null)
        {
          $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
        }
      }
    }
    // if ($this->session->userdata('user_desig_code') == 'SK') {
    //   $this->db->where('b.lm_note', '1');
    //   $this->db->where('a.from_office', 'LM');
    // }
    if(trim($reverted) == 'LM' and $status =='V'){
      $this->db->SELECT("distinct(a.case_no),a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, a.chitha_processing_details");
      $this->db->SELECT('(SELECT \'0\') as lm_note');
    } else {
      $this->db->SELECT('distinct(a.case_no), a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note, a.chitha_processing_details');
    }

    if (trim($reverted) != 'ADC'){
      $this->db->where('a.status', $status);
    }
    $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
    $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
    $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

    // $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
    if(trim($reverted) == 'LM' and $status =='V'){
      $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no', 'left');
    }else{
      $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
    }

    if($s_code == 14 && ($status !='R' && $status !='X' && $status !='M' && $status !='N' && $status !='D'))
    {
      if (trim($reverted) != 'ADC'){
        if (($this->session->userdata('user_desig_code') == 'SK' and $status =='W') || trim($reverted) == 'LM' and $status =='V') {

        }

        else{
          $this->db->where('a.notice_generated_yn', NULL);
        }
      }
    }

    $this->db->from('settlement_basic a');

    if($status == MB_PAYMENT_NOTICE)
    {
      $this->db->join('settlement_premium c', 'a.case_no = c.case_no');
      $this->db->where('c.is_final', 1);

      if(!empty($payment_status))
      {
        if(trim($payment_status) == 'paid')
        {
          $this->db->where('c.grn_no is not null');
        }
        elseif(trim($payment_status) == 'unpaid')
        {
          $this->db->where('c.grn_no is null');
        }
      }

      if(!empty($final_verification_report))
      {
        if($final_verification_report == 'Yes')
        {
          $this->db->where_in('a.chitha_processing_details', array(1,2));
        }
        else if($final_verification_report == 'No')
        {
          $this->db->where('a.chitha_processing_details', 0);
        }
        elseif(trim($final_verification_report) == 'land_class_issue') {

          $this->db->where('EXISTS (SELECT 1 FROM settlement_dag_details sd WHERE sd.case_no = a.case_no AND ((sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = \'\' OR sd.new_land_class_agri = \'\')))', NULL, FALSE);
        }
      }

      if(!empty($co_approved))
      {
        if($co_approved == 'Yes')
        {
          $this->db->where('a.chitha_processing_details', 2);
        }
        else if($co_approved == 'No')
        {
          $this->db->where_in('a.chitha_processing_details', array(1,0));
        }
      }
    }

    $query = $this->db->get();
    // echo $this->db->last_query();

    if ($query->num_rows() > 0) {
      foreach ($query->result() as $rows) {

        $revialSql = $this->db->query('SELECT * from settlement_revival_flag where case_no = ? and revival_status = ?', array($rows->case_no, 1));

        if($revialSql->num_rows() > 0)
        {
          $revival_flg_button = '';
        }
        else
        {
          $revival_flg_button = '<button type="button" onclick="caseRevivalList(\''.$rows->case_no.'\',\''.$rows->service_code.'\');" class="btn btn-sm btn-warning">Flag for Revival</button>';
        }

        $download_rejected_cases = '<br><a class="mt-2 btn btn-sm btn-dark" target= "RejectedCases" href="'.base_url().'index.php/SettlementCommon/downloadRejectedCases/?service='.$s_code.'">Download Reject Cases</a>';

        if(trim($rows->lm_note) == 1)
        {
          $lmnoteRemark = 'Recommended';
        }
        else
        {
          $lmnoteRemark = 'Not Recommended';
        }

        $write_report = '<a type="button" href="' . base_url() . 'index.php/TeaGrantControllerCo/TeaGrantCo?case=' . $this->utilityclass->encryptJwtCase($rows->case_no) . '" class="lmreportmut btn-sm btn btn-primary">Write Report</a>';

        
        // log_message("error", "#ERR452: ".json_encode($responseJuridiction));

        // check SRO report receives or not
        $sroReportStatus = $this->db->query("SELECT * FROM sro_push_history WHERE case_no=? ORDER BY slno DESC LIMIT 1", 
                              array($rows->case_no));

        if($sroReportStatus->num_rows() == 0)
        {
          $sroMessage = '<span class="badge text-bg-warning">This case was not forwarded to SRO for deed_verification. <a href="'.base_url().'index.php/TeaGrantControllerCo/manuallyForwardToSro/'.$this->utilityclass->encryptJwtCase($rows->case_no).'">Click here to Forward</a></span>';
          $btn        = 0;
        }
        else
        {
          $sroReport = $sroReportStatus->row();

          $sro_action_arr = ['Y', 'N'];

          if(!in_array($sroReport->action, $sro_action_arr))
          {
            $responseJuridiction = $this->checkSroJuridication($rows->case_no);
            $sroReport = $sroReportStatus->row();
          }

          // $forward_to_sro = '<br><a type="button" href="' . base_url() . 'index.php/TeaGrantControllerCo/reforwardToSroFromList?case=' . $rows->case_no . '" class="btn-sm btn btn-success">Forward to SRO</a>';



          $forward_to_sro = '<button title="Re Forward to SRO" class="btn btn-success btn-sm forward_dc_btn" onclick="reforward_to_sro_with_deed_details(\''.$rows->case_no.'\')">Reforward to SRO</button>';

          if($sroReport->action == 'Y' && strtoupper($sroReport->is_deed_valid) == 'Y')
          {
            $sroMessage = '<span class="badge text-bg-warning">SRO Approved Deed No & is VALID</span>';
            $btn        = 1;
            $forward_to_sro = null;
          }
          else if($sroReport->action == 'Y' && strtoupper($sroReport->is_deed_valid) != 'Y')
          {
            $sroMessage = '<span class="badge text-bg-warning">SRO Approved Deed No & is INVALID</span>';
            $btn        = 1;
            $forward_to_sro = $forward_to_sro.'&nbsp;'.$write_report;
          }
          else if($sroReport->action == 'N' && $sroReport->status == 'N') // if SRO says no, checking for juridication
          {
            $sroMessage = '<span class="badge text-bg-warning">The SRO did not verify the case, as it does not fall within their jurisdiction.</span>';
            $btn        = 0;            
            $forward_to_sro = $forward_to_sro.'&nbsp;'.$write_report;
          }
          else if($sroReport->action == 'F')
          {
            $sroMessage = '<span class="badge text-bg-warning">SRO Report Pending</span>';
            $btn        = 0;
            $forward_to_sro = null;
          }
        }

        if(SRO_REPORT_MANDATE == 1 && $sroReport->action == 'F') // if SRO report is mandatory
        {
          $co_second_proceeding = $sroMessage.'<br>'.$forward_to_sro;
        }
        else
        {
          $co_second_proceeding = (($btn == 1) ? $write_report.'<br>' : '').$sroMessage.'<br>'.$forward_to_sro;
        }

        $sro_report = '<a type="button" href="' . base_url() . 'index.php/TeaGrantControllerCo/reportFromSro?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">SRO Report Dummy</a>';

        $button = (IS_PRODUCTION == 0) ? ($write_report.'<br>'.$sro_report.'<br>'.$forward_to_sro) : ((DISABLE_ALL_BUTTON == 0) ? $co_second_proceeding : null);
        
        $json[] = array(
          '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
          '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',
          $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),
          $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),
          $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),
          date("Y-m-d", strtotime($rows->date_entry)),
          $lmnoteRemark,
          $button
        );
      }

      $this->db->where('a.service_code', $s_code);

      if(!empty($remark_cat))
      {  //settlement_ap_lmnote, lm_note
        $this->db->where('b.lm_note', $remark_cat);
      }

      if (trim($reverted) == 'LM'){
        $this->db->where('a.pending_officer', MB_LOT_MONDOL);
      }
      else if (trim($reverted) == 'ADC'){
        $this->db->where_not_in('a.pending_officer',array(MB_LOT_MONDOL,MB_SUPERVISOR_KANANGU,MB_CIRCLE_OFFICER));
      }
      else {
        $this->db->where_in('a.pending_officer', array(MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU, MB_LOT_MONDOL));
      }

      if ($this->session->userdata('user_desig_code') == 'CO'){
        // $this->db->where('a.co_code', $user_code);
        // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
        if(LOT_BIFURCATE ==1 && empty($mouza_pargona_code) && empty($lot_no)){

          if(isset($lot_string) && $lot_string != null)
          {
            $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
          }
        }
      }

      if ($this->session->userdata('user_desig_code') == 'SK') {
        $this->db->where('b.lm_note', '1');
        $this->db->where('a.from_office', 'LM');
      }

      if(!empty($mouza_pargona_code))
      {
        $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
      }

      if(!empty($mouza_pargona_code) && !empty($lot_no))
      {
        $this->db->where('a.lot_no', $lot_no);
      }

      if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
        $this->db->where('a.vill_townprt_code', $is_cat);
      }


      if(trim($reverted) == 'LM' and $status =='V') {
        $this->db->SELECT('distinct(a.case_no)');
        $this->db->SELECT('(SELECT \'0\') as lm_note');
      } else {
        $this->db->SELECT('distinct(a.case_no)');
      }

      if (trim($reverted) != 'ADC') {
        $this->db->where('a.status', $status);
      }
      $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
      $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
      $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

      // $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
      if(trim($reverted) == 'LM' and $status =='V') {
        $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no', 'left');
      } else {
        $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
      }

      if($s_code == 14 && ($status !='R' && $status !='X' && $status !='M' && $status !='N' && $status !='D'))
      {
        if (trim($reverted) != 'ADC'){
          if (($this->session->userdata('user_desig_code') == 'SK' and $status =='W') || trim($reverted) == 'LM' and $status =='V') {

          }
          else{
            $this->db->where('a.notice_generated_yn', NULL);
          }
        }
      }

      if($status == MB_PAYMENT_NOTICE)
      {
        $this->db->join('settlement_premium c', 'a.case_no = c.case_no');
        $this->db->where('c.is_final', 1);

        if(!empty($payment_status))
        {
          if(trim($payment_status) == 'paid')
          {
            $this->db->where('c.grn_no is not null');
          }
          elseif(trim($payment_status) == 'unpaid')
          {
            $this->db->where('c.grn_no is null');
          }              
        }

        if(!empty($final_verification_report))
        {
          if($final_verification_report == 'Yes')
          {
            $this->db->where_in('a.chitha_processing_details', array(1,2));
          }
          else if($final_verification_report == 'No')
          {
            $this->db->where('a.chitha_processing_details', 0);
          }
          elseif(trim($final_verification_report) == 'land_class_issue')
          { 
            $this->db->where('EXISTS (SELECT 1 FROM settlement_dag_details sd WHERE sd.case_no = a.case_no AND ((sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = \'\' OR sd.new_land_class_agri = \'\')))', NULL, FALSE);
          }
        }

        if(!empty($co_approved))
        {
          if($co_approved == 'Yes')
          {
            $this->db->where('a.chitha_processing_details', 2);
          }
          else if($co_approved == 'No')
          {
            $this->db->where_in('a.chitha_processing_details', array(1,0));
          }
        }
      }


      // $total_records = $this->db->count_all_results('settlement_basic a');
      $data=$this->db->get('settlement_basic a');
      $total_records = $data->num_rows();
      $response = array(
        'draw'            => $draw,
        'recordsTotal'    => $total_records,
        'recordsFiltered' => $total_records,
        'data'            => $json,
      );

      echo json_encode($response);

    } 
    else {
      $response = array();
      $response['sEcho'] = 0;
      $response['iTotalRecords'] = 0;
      $response['iTotalDisplayRecords'] = 0;
      $response['aaData'] = [];
      echo json_encode($response);
    }
  }

  // New area check By Masud Reza
  public function chithaAreaCheckWithCaseNo($application_no)
  {

    $dags = $this->SettlementApModel->getSettlementDag($application_no);

    $totalAreaInChitha[] = 0;
    $appAreaInApplication = 0;
    $areaCheck = 0;
    $chithaDagArray = [];
    $lmProcessArea = [];
    $allApplicationDagArray = [];
    $appliedDags = $this->SettlementCommonDcModel->getAppliedSettlementDag($application_no);
    $basic = $this->SettlementCommonDcModel->getSettlementBasicData($application_no);

    foreach ($dags as $dag)
    {
        $totalAreaInApplication = 0;
        $totalAreaInLMApplication = 0;
        $totalAppliedAreaInApplication = 0;

        $appDistrict  = $dag->dist_code;
        $appSubDiv    = $dag->subdiv_code;
        $appCircle    = $dag->cir_code;
        $appMouza     = $dag->mouza_pargona_code;
        $appLot       = $dag->lot_no;
        $appVillage   = $dag->vill_townprt_code;
        $appDag       = $dag->dag_no;
        $appPattaType = $dag->patta_type_code;
        $appPatta     = $dag->patta_no;

        $chithaDag = $this->SettlementCommonDcModel->getChithaDagAreaDetails(
            $appDistrict, $appSubDiv, $appCircle, $appMouza, $appLot, $appVillage, $appDag, $appPattaType, $appPatta);

        $allApplicationDags = $this->SettlementCommonDcModel->getAllDagAreaDetailsByLocation(
            $appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta);

        //  all lm processing application but  SDO/ADC/DC not proceeded
          $allLmProcess = $this->SettlementCommonDcModel->getAllDagAreaDetailsByLocationNotSubmit(
          $appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta,$application_no);


        if (in_array($appDistrict, json_decode(BARAK_VALLEY)))
        {
            // chitha
            $bighaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_b, 0);
            $kathaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_k, 0);
            $lessaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_lc, 0);
            $gandaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_g, 0);
            $totalAreaInChitha = ($bighaChitha * 6400) + ($kathaChitha * 320) + ($lessaChitha * 20) + $gandaChitha;

            // processing application
            foreach ($allApplicationDags as $singleApp)
            {
                $bighaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_b, 0);
                $kathaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_k, 0);
                $lessaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_lc, 0);
                $gandaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_g, 0);
                $areaInApplication = ($bighaApp * 6400) + ($kathaApp * 320) + ($lessaApp * 20) + $gandaApp;

                $totalAreaInApplication += $areaInApplication;
            }
            // LM processing application
            foreach ($allLmProcess as $singleLMApp)
            {
                $bighaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_b, 0);
                $kathaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_k, 0);
                $lessaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_lc, 0);
                $gandaLMApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_g, 0);

                $areaInLMApplication = ($bighaLmApp * 6400) + ($kathaLmApp * 320) + ($lessaLmApp * 20) + $gandaLMApp;
                $totalAreaInLMApplication += $areaInLMApplication;
            }

            if($basic->dc_proceeding == 0)
            {
                // application area
                foreach ($appliedDags as $singleAppArea)
                {
                    if($chithaDag->dag_no == $singleAppArea->dag_no)
                    {
                        $bighaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_b, 0);
                        $kathaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_k, 0);
                        $lessaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_lc, 0);
                        $gandaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_g, 0);
                        $appAreaInApplication = ($bighaAppArea * 6400) + ($kathaAppArea * 320) + ($lessaAppArea * 20) + $gandaAppArea;

                        $totalAppliedAreaInApplication += $appAreaInApplication;
                    }

                }
            }
            if($totalAreaInChitha == 0)
            {
                $areaCheck = 1;
            }
            if(($totalAreaInApplication + $totalAppliedAreaInApplication) == 0)
            {
                $areaCheck = 1;
            }
            if($totalAreaInChitha < $totalAreaInApplication + $totalAreaInLMApplication)
            {
                $areaCheck = 1;
            }
        }
        else
        {
            // chitha
            $bighaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_b, 0);
            $kathaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_k, 0);
            $lessaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_lc, 0);
            $totalAreaInChitha = ($bighaChitha * 100) + ($kathaChitha * 20) + $lessaChitha;

            // processing application
            foreach ($allApplicationDags as $singleApp)
            {
                $bighaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_b, 0);
                $kathaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_k, 0);
                $lessaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_lc, 0);
                $areaInApplication = ($bighaApp * 100) + ($kathaApp * 20) + $lessaApp;

                $totalAreaInApplication += $areaInApplication;
            }
            // LM processing application
            foreach ($allLmProcess as $singleLMApp)
            {
                $bighaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_b, 0);
                $kathaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_k, 0);
                $lessaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_lc, 0);
                $areaInLMApplication = ($bighaLmApp * 100) + ($kathaLmApp * 20) + $lessaLmApp;

                $totalAreaInLMApplication += $areaInLMApplication;
            }
            if($basic->dc_proceeding == 0)
            {
                // application area
                foreach ($appliedDags as $singleAppArea)
                {
                    if($chithaDag->dag_no == $singleAppArea->dag_no)
                    {
                        $bighaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_b, 0);
                        $kathaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_k, 0);
                        $lessaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_lc, 0);
                        $appAreaInApplication = ($bighaAppArea * 100) + ($kathaAppArea * 20) + $lessaAppArea;

                        $totalAppliedAreaInApplication += $appAreaInApplication;
                    }
                }
            }
            if($totalAreaInChitha == 0)
            {
                $areaCheck = 1;
            }
            if(($totalAreaInApplication + $totalAppliedAreaInApplication) == 0)
            {
                $areaCheck = 1;
            }
            if($totalAreaInChitha < $totalAreaInApplication + $totalAreaInLMApplication)
            {
                $areaCheck = 1;
            }
        }

        $lmProcessArea[]          = $allLmProcess;
        $chithaDagArray[]         = $chithaDag;
        $allApplicationDagArray[] = $allApplicationDags;
    }

    $checkAreaDetail = array(
        'chithaArea'    => $chithaDagArray,
        'reservedArea'  => $allApplicationDagArray,
        'lmProcessArea' => $lmProcessArea,
        'appliedDags'   => $appliedDags,
        'areaCheck'     => $areaCheck,
    );


    return $checkAreaDetail;

  }





  // Settlement Khas CO view starts here -md-
  public function TeaGrantCo()
  {
    $application_no  = $this->input->get('case');
    $application_no = $this->utilityclass->decryptJwtCase($application_no);
    $user_desig_code = $this->session->userdata('user_desig_code');
  
    if($user_desig_code == 'SK')
    {
        $this->utilityclass->authCheckCoSk($application_no, 'SK');
        $this->utilityclass->checkUserAuthForCaseForSk($application_no);
    }
    else if ($user_desig_code == 'CO')
    {
        $this->utilityclass->authCheckCoSk($application_no, 'CO');
        $this->utilityclass->checkUserAuthForCaseForCo($application_no);
    }
    else
    {
      $this->session->set_flashdata('message', "#ERR290: error occured! Contact admin...");
      redirect(base_url() . "index.php/home");
      return false;
    }

    $basic                 = $this->TeaGrantModel->getSettlementBasic($application_no);
    $applicants_buyers     = $this->TeaGrantModel->getAllApplicantBuyers($application_no);
    $applicants_owners     = $this->TeaGrantModel->getAllApplicantOwners($application_no);
    
    $applicants_dag_details= $this->TeaGrantModel->getAllApplicantDagDetails($application_no);
    $adcUsers              = $this->UtilsModel->adcSelect($this->session->userdata('dist_code'));

    $lmdata        = [];

    $dags          = $this->TeaGrantModel->getSettlementDag($application_no);
    $lmnotes       = $this->TeaGrantModel->getSettlementTenantLmNote($application_no);
    $proceedings   = $this->TeaGrantModel->getSettlementProceeding($application_no);
    $dhardocuments = $this->TeaGrantModel->getDocuments($application_no);
    $nominee       = $this->TeaGrantModel->getAllNomineeDetail($application_no);
    $existing_pattadar = $this->TeaGrantModel->getAllExistingPattadar($application_no);
    $deed_applicant= $this->TeaGrantModel->getAllDeedPattadar($application_no);
    $family_tree   = $this->TeaGrantModel->getAllFamilyTree($application_no);

    $sro_remark    = $this->TeaGrantModel->getSroRemark($application_no);
    $sro_check     = $this->TeaGrantModel->checkSroJuridicationSaysNo($application_no);

    $lmdata['sro_check']              = $sro_check;
    $lmdata['sro_remark']             = $sro_remark;
    $lmdata['basic']                  = $basic;
    $lmdata['nominee']                = $nominee;
    $lmdata['applicants_buyers']      = $applicants_buyers;
    $lmdata['applicants_owners']      = $applicants_owners;

    $lmdata['existing_pattadar']      = $existing_pattadar;
    $lmdata['deed_applicant']         = $deed_applicant;
    $lmdata['family_tree']            = $family_tree;
    $lmdata['applicants_dag_details'] = $applicants_dag_details;
    $lmdata['adcUsers']               = $adcUsers;

    $lmdata['checkAdditionalProperty'] = $this->SettlementCommonModel->activeAdditionalPropertyDetailByCase($application_no)->result();
    
    $applid = $this->utilityclass->getApplidFromCaseNo($application_no);

    // echo "sdfghj"; die;

    // echo "<pre>"; var_dump($lmdata['applicants_buyers']); die;

    foreach($lmdata['applicants_buyers'] as $adhar_photo):
      if($adhar_photo->is_applicant == 1 && trim($adhar_photo->identity_type) == 'AADHAAR'):
        $get_aadhaar_photo = $this->TeaGrantModel->aadhaarPhotoView($applid);
        if($get_aadhaar_photo != 'n'){
          $lmdata['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($get_aadhaar_photo).";base64,".$get_aadhaar_photo." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
        }
      endif;
    endforeach;

    //****getting tribe cat and under tribal belt data from backup */
    $getJsonBackup = $this->TeaGrantModel->getJsonDataFromBackup($application_no);

    $lmdata['dags']          = $dags;
    $lmdata['lmnotes']       = $lmnotes;
    $lmdata['proceedings']   = $proceedings;
    $lmdata['dhardocuments'] = $dhardocuments;

    // $premium_data = $this->db->query("SELECT sp.*,spa.area, spl.land_type, spr.house_type, spr.rate_type as ratetype FROM settlement_premium sp inner join settlement_premium_area spa on spa.paid=sp.area_name inner join settlement_premium_land_type spl on spl.plid=sp.land_type inner join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no='$application_no' and is_final=1")->result();


    $premium_data = $this->db->query("SELECT * FROM settlement_premium where case_no='$application_no' and is_final=1")->result();
    $lmdata['premium_data'] = $premium_data;

    
    $lmdata['premium']     = $premium_data;
    $lmdata['reservation'] = $this->SettlementVgrModel->getSettlementReservation($application_no);
    $lmdata['additional_property'] = $this->TeaGrantModel->getAdditionalProperty($application_no);

    //********check if SDO exist for that area */
    // $headQtrCheck = $this->SettlementCommonModel->headquarterCheck($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'));
    // if(trim($headQtrCheck) != 'Y'){

    //   $sdoCheckResult = $this->SettlementCommonModel->userCheckSDO($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'));

    //   // echo $this->db->last_query(); die;

    //   if(trim($sdoCheckResult) == 'y'){
    //     $lmdata['sdo_user_check'] = trim($sdoCheckResult);
    //   }
    //   else
    //   {
    //     $lmdata['sdo_user_check'] = 'No SDO created for this location...';
    //   }
    // }
    // else
    // {
    //   $lmdata['sdo_user_check'] = 'y';
    // }

    // $lmdata['sdo_user_check'] = 'y';

    $areaModificationCheck = $this->SettlementCommonModel->checkIfAreaModified($application_no);

    if(isset($areaModificationCheck)){
        if($areaModificationCheck){
            foreach($areaModificationCheck as $areaHis){
                $applied_area_home_bigha = $areaHis->applied_area_home_bigha;
                $applied_area_home_katha = $areaHis->applied_area_home_katha;
                $applied_area_home_lessa = $areaHis->applied_area_home_lessa;
                $applied_area_home_ganda = $areaHis->applied_area_home_ganda;
                $applied_area_home_kranti = $areaHis->applied_area_home_kranti;

                $applied_area_agri_bigha = $areaHis->applied_area_agri_bigha;
                $applied_area_agri_katha = $areaHis->applied_area_agri_katha;
                $applied_area_agri_lessa = $areaHis->applied_area_agri_lessa;
                $applied_area_agri_ganda = $areaHis->applied_area_agri_ganda;
                $applied_area_agri_kranti = $areaHis->applied_area_agri_kranti;


                $settlement_area_home_bigha = $areaHis->settlement_area_home_bigha;
                $settlement_area_home_katha = $areaHis->settlement_area_home_katha;
                $settlement_area_home_lessa = $areaHis->settlement_area_home_lessa;
                $settlement_area_home_ganda = $areaHis->settlement_area_home_ganda;
                $settlement_area_home_kranti = $areaHis->settlement_area_home_kranti;

                $settlement_area_agri_bigha = $areaHis->settlement_area_agri_bigha;
                $settlement_area_agri_katha = $areaHis->settlement_area_agri_katha;
                $settlement_area_agri_lessa = $areaHis->settlement_area_agri_lessa;
                $settlement_area_agri_ganda = $areaHis->settlement_area_agri_ganda;
                $settlement_area_agri_kranti = $areaHis->settlement_area_agri_kranti;


                if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {

                    $total_applied_area_home_in_ganda = $this->utilityclass->Total_ganda($applied_area_home_bigha, $applied_area_home_katha, $applied_area_home_lessa, $applied_area_home_ganda);
                    $total_applied_area_agri_in_ganda = $this->utilityclass->Total_ganda($applied_area_agri_bigha, $applied_area_agri_katha, $applied_area_agri_lessa, $applied_area_agri_ganda);
                    $total_settlement_area_home_in_ganda = $this->utilityclass->Total_ganda($settlement_area_home_bigha, $settlement_area_home_katha, $settlement_area_home_lessa, $settlement_area_home_ganda);
                    $total_settlement_area_agri_in_ganda = $this->utilityclass->Total_ganda($settlement_area_agri_bigha, $settlement_area_agri_katha, $settlement_area_agri_lessa, $settlement_area_agri_ganda);

                    if(($total_applied_area_home_in_ganda != $total_settlement_area_home_in_ganda) || ($total_applied_area_agri_in_ganda != $total_settlement_area_agri_in_ganda)){

                        $lmdata['area_modified'] = $areaModificationCheck;
                    }

                }
                else
                {
                    $total_applied_area_home_in_lessa = $this->utilityclass->Total_Lessa($applied_area_home_bigha, $applied_area_home_katha, $applied_area_home_lessa);
                    $total_applied_area_agri_in_lessa = $this->utilityclass->Total_Lessa($applied_area_agri_bigha, $applied_area_agri_katha, $applied_area_agri_lessa);
                    $total_settlement_area_home_in_lessa = $this->utilityclass->Total_Lessa($settlement_area_home_bigha, $settlement_area_home_katha, $settlement_area_home_lessa);
                    $total_settlement_area_agri_in_lessa = $this->utilityclass->Total_Lessa($settlement_area_agri_bigha, $settlement_area_agri_katha, $settlement_area_agri_lessa);
                    //check if area modified
                    if(($total_applied_area_home_in_lessa != $total_settlement_area_home_in_lessa) || ($total_applied_area_agri_in_lessa != $total_settlement_area_agri_in_lessa)){

                        $lmdata['area_modified'] = $areaModificationCheck;
                    }
                }
            }
        }
    }

    $checkAreaDetails = $this->chithaAreaCheckWithCaseNo($application_no);

    $lmdata['chithaArea']   = $checkAreaDetails['chithaArea'];
    $lmdata['reservedArea'] = $checkAreaDetails['reservedArea'];
    $lmdata['areaCheck']    = $checkAreaDetails['areaCheck'];
    $lmdata['appliedDags']  = $checkAreaDetails['appliedDags'];
    $lmdata['lmProcessArea']= $checkAreaDetails['lmProcessArea'];

    // for guardian relation
    $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
    $relation_executation = $this->db->query($query_for_guar_rel);
    $row = $relation_executation->num_rows;
    if ($row != 0) {
      $lmdata['guar_rel'] = $relation_executation->result();
    }

    $lmdata['basic_status'] = $this->SettlementCommonModel->getCurrentBasicStatus($application_no);

    $lmdata['user_desig_code'] = $this->session->userdata('user_desig_code');
    $lmdata['co_name']= $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);



    //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
    $deletedDags=$this->SettlementCommonModel->getDeletedDags($application_no);
    $deletedData = array();
    foreach($deletedDags as $deleteDag){
      $deletedData[] = json_decode($deleteDag->table_data);
    }
    $lmdata['deleted_dags'] = $deletedData;

    $rejected_data = $this->SettlementCommonModel->getRejectModal(TEA_SERVICE_CODE);
    if($rejected_data == 'n')
    {
      $lmdata['rejected_list'] = false;
    }
    else
    {
      $lmdata['rejected_list'] = $rejected_data;
    }


    foreach(json_decode(VALIDATION_BYPASS_TEA_GRANT) as $val_bypas)
    {
      if($val_bypas->SERVICE_CODE == TEA_SERVICE_CODE)
      {
        $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
      }
    }

    $lmdata['validation_bypass'] = 0;

    foreach($lmdata['lmnotes'] as $lm_rr)
    {
      $decoded_r = json_decode($lm_rr->lm_rejected_remarks);

      if($decoded_r){
        foreach($decoded_r as  $lm_rejected_code)
        {
          if(isset($lm_rejected_code->reject_code))
          {
            if(in_array($lm_rejected_code->reject_code, $const_bypass_arr_code)){
              $lmdata['validation_bypass'] = 1;
            }
          }
          else
          {
            if(in_array($lm_rejected_code, $const_bypass_arr_code)){
              $lmdata['validation_bypass'] = 1;
            }
          }            
        }
      }       
    }

    $lmdata['reject_list_type'] = '';

    foreach($lmnotes as $r_remark)
    {
      $rejected_list_json = json_decode($r_remark->lm_rejected_remarks);

      if($rejected_list_json)
      {
        foreach ($rejected_list_json as $re_list) 
        {
          if(isset($re_list->reject_code))
          {
            $r_code = $re_list->reject_code;
          }
          else
          {
            $r_code = $re_list;
          }

          $sql = $this->db->query("SELECT remark_head from reject_master where reject_code = ?", array($r_code));

          if($sql->row()->remark_head != null)
          {
            $lmdata['reject_list_type'] = 'new';
          }
          else
          {
            $lmdata['reject_list_type'] = 'old';
          }
        }
      }
    }

    $lmdata['_view'] = 'TeaGrant/CO/TeaGrantCoView';
    $this->load->view('layouts/main', $lmdata);
  }


  public function generateNoticeCo()
  {
    // var_dump($_POST); 
    //******disagree and revert to LM */
    if(isset($_POST['co_rejection_disagree']))
    {
      // echo 'co_rejection_disagree'; die;

        if($_POST['co_rejection_disagree'] == 'co_rejection_disagree')
        {
            $case_no = $this->input->post('case_no');
            $remark_co = 'Re-verify this case';
            $remark_co_type = '3';

            $this->db->trans_begin();

            $updateArr = [
                'status' => 'R',
                'co_code' => $this->session->userdata('user_code'),
                'date_update' => date('Y-m-d H:i:s'),
                'from_office' => 'CO',
                'pending_officer' => 'LM',
                'pending_office' => 'CO',

            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $updateArr);

            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCO0001: Falied to revert back to LM');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0001: Falied to revert back to LM. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }

            //////proceeding start//////
            $proceeding_id = $this->db->query("SELECT max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
            if ($proceeding_id == null) {
                $proceeding_id = 1;
            }

            $insertArr = [
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => date('Y-m-d H:i:s'),
                'next_date_of_hearing' => date('Y-m-d H:i:s'),
                'note_type' => $remark_co_type,
                'note_on_order' => $remark_co,
                'status' => 'W',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d H:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => 'LM',
                'task' => 'Reverted Back to LM',
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if ($insertProc != 1) 
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRCO0002: Insertion failed in settlement_proceeding');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0002: Failed to generate notice. Kindly contact System Administrator',
                ];
                echo json_encode($json);
                return false;
            }
            if ($this->db->trans_status() == false) 
            {
                $this->db->trans_rollback();
                $data = array(
                    'error' => "Error in submitting. Please try Again",
                );
                return $data;
                exit;
            } 
            else 
            {
                //////////////POST To basundhara////////////////////
                $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;

                $rmk='Reverted to LM';
                $status='M';
                $task='CO';
                $pen='LM';
                $case=$case_no;
                $rtps_status=$this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
                $rtps_status=json_decode($rtps_status);
                //var_dump($rtps_status);
                if(trim($rtps_status) != "y")
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRAPP003211: Revert to LM failed case no # $case_no");
                    redirect(base_url() . "index.php/home");
                }
                else
                {
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message', "Case no # $case_no reverted back to LM");
                    redirect(base_url() . "index.php/home");
                    // redirect(base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $case_no);
                }
            }
        }
    }

    // Revert back to LM stats here
    if (isset($_POST['revert_to_lm'])) 
    {
      // echo 'revert_to_lm'; die;

      $case_no         = $this->input->post('case_no');
      $remark_co       = $this->input->post('remark_co');
      $remark_co_type  = $this->input->post('remark_co_type');

      $district        = $this->input->post('district');
      $sub_division    = $this->input->post('sub_division');
      $circle          = $this->input->post('circle');
      $lot_no          = $this->input->post('lot_no');
      $mouza           = $this->input->post('mouza');
      $village         = $this->input->post('village');
      $petitioner_name = $this->input->post('petitioner_name');
      $g_name          = $this->input->post('g_name');
      $dag_name        = $this->input->post('dag_name');

      $this->db->trans_begin();

      $updateArr = [
        'status'          => 'R',
        'co_code'         => $this->session->userdata('user_code'),
        'date_update'     => date('Y-m-d H:i:s'),
        'from_office'     => 'CO',
        'pending_officer' => 'LM',
        'pending_office'  => 'CO',
      ];
      $this->db->where('case_no', $case_no);
      $this->db->update('settlement_basic', $updateArr);

      if ($this->db->affected_rows() == 0) {
        $this->db->trans_rollback();
        log_message('error', '#ERRCO0001: Falied to revert back to LM');
        $json = [
          'responseType' => 3,
          'message'      => '#ERRCO0001: Falied to revert back to LM. Kindly contact system administrator',
        ];
        echo json_encode($json);
        return false;
      }

      //////proceeding start//////
      $proceeding_id = $this->db->query("SELECT max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
      if ($proceeding_id == null) {
        $proceeding_id = 1;
      }

      $insertArr = [
        'case_no'              => $case_no,
        'proceeding_id'        => $proceeding_id,
        'date_of_hearing'      => date('Y-m-d H:i:s'),
        'next_date_of_hearing' => date('Y-m-d H:i:s'),
        'note_type'            => $remark_co_type,
        'note_on_order'        => $remark_co,
        'status'               => 'W',
        'user_code'            => $this->session->userdata('user_code'),
        'date_entry'           => date('Y-m-d H:i:s'),
        'operation'            => 'E',
        'ip'                   => $this->utilityclass->get_client_ip(),
        'office_from'          => 'CO',
        'office_to'            => 'LM',
        'task'                 => 'Reverted Back to LM',
      ];
      $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
      if ($insertProc != 1) {
        $this->db->trans_rollback();
        log_message('error', '#ERRCO0002: Insertion failed in settlement_proceeding');
        $json = [
          'responseType' => 3,
          'message'      => '#ERRCO0002: Failed to generate notice. Kindly contact System Administrator',
        ];
        echo json_encode($json);
        return false;
      }
      if ($this->db->trans_status() == false) {
        $this->db->trans_rollback();
        $data = array(
          'error' => "Error in submitting. Please try Again",
        );
        return $data;
        exit;
      } 
      else 
      {
        //////////////POST To basundhara////////////////////
        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;

        $rmk            = 'Reverted to LM';
        $status         = 'M';
        $task           = 'CO';
        $pen            = 'LM';
        $case           = $case_no;
        $rtps_status    = $this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
        $rtps_status    = json_decode($rtps_status);
        //var_dump($rtps_status);
        if(trim($rtps_status) != "y"){
          $this->db->trans_rollback();
          $this->session->set_flashdata('message', "Error #ERRAPP003211: Revert to LM failed case no # $case_no");
          redirect(base_url() . "index.php/home");
        }else{
          $this->db->trans_commit();
          $this->session->set_flashdata('message', "Case no # $case_no reverted back to LM");
          redirect(base_url() . "index.php/home");
        }
      }
    }

    if(isset($_POST['sk_forward_co']))
    {
      // echo 'sk_forward_co'; die;

        $case_no = $this->input->post('case_no');
        $remark_co = $this->input->post('remark_co_type');
        $remark_co_text = $this->input->post('remark_co_note');

        $basic_status = $this->SettlementCommonModel->getCurrentBasicStatus($case_no);

        if($basic_status == 'X')
        {
            $status = 'X';
        }
        else
        {
            $status = 'W';
        }

        $co_code = $this->input->post('co_code');

        $this->db->trans_begin();

        $updateArr = [
            'status' => $status,
            'date_update' => date('Y-m-d H:i:s'),
            'from_office' => 'SK',
            'pending_officer' => 'CO',
            'pending_office' => 'CO',
            'sk_code' => $this->session->userdata('user_code'),
        ];

        if($status == 'W')
        {
            $updateArr['co_code'] = $this->input->post('co_code');
        }

        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $updateArr);

        if($this->db->affected_rows() == 0 ){
            $this->db->trans_rollback();
            log_message('error', '#ERRCO003303: Falied to forward to CO');
            $json = [
                'responseType' => 3,
                'message' => '#ERRCO003303: Falied to forward to CO. Kindly contact system administrator',
            ];
            echo json_encode($json);
            return false;
        }

        //////proceeding start//////
        $proceeding_id=$this->db->query("SELECT max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        if($proceeding_id==null){
            $proceeding_id=1;
        }

        $insertArr = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => date('Y-m-d H:i:s'),
            'next_date_of_hearing' => date('Y-m-d H:i:s'),
            'note_type' => $remark_co,
            'note_on_order' => $remark_co_text,
            'status' => $status,
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d H:i:s'),
            'operation' => 'E',
            'ip' => $this->utilityclass->get_client_ip(),
            'office_from' => 'SK',
            'office_to' => 'CO',
            'task' => 'Forwarded to CO'
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if($insertProc != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRCO0004: Insertion failed in settlement_proceeding');
            $json = [
                'responseType' => 3,
                'message' => '#ERRCO0004: Failed to foward to DC. Kindly contact System Administrator',
            ];
            echo json_encode($json);
            return false;
        }
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            $data=array(
                'error'=>"Error in submitting. Please try Again"
            );
            echo json_encode($data);
            return false;
        }else{

            //////////////POST To basundhara////////////////////
            $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;

            $rmk='Forwarded to CO';
            $status='M';
            $task='SK';
            $pen='CO';
            $case=$case_no;
            $rtps_status=$this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
            $rtps_status=json_decode($rtps_status);
            //var_dump($rtps_status);
            if(trim($rtps_status)!="y"){
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error #ERRAPP1701: Forward to DC failed case no # $case_no");
                redirect(base_url() . "index.php/home");
            }else{
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Case no # $case_no forwarded to CO");
                redirect(base_url() . "index.php/home");
                // redirect(base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $case_no);
            }
            // $this->load->view('SettlementView/Co/SettlementApTransferred');
        }
    }

    //forward to DC starts here
    if (isset($_POST['forward_to_dc'])) {

      $case_no        = $this->input->post('case_no');
      $remark_co      = $this->input->post('remark_co');
      $remark_co_type = $this->input->post('remark_co_type');
      $district       = $this->input->post('district');
      $sub_division   = $this->input->post('sub_division');
      $order_type     = $this->input->post('order_type');
      $adc_dc_code    = $this->input->post('adc_dc_code');

      // $checkForLmReport = $this->TeaGrantModel->checkAllReportGivenByLm($case_no);
      // $lm_tea_report = json_decode($checkForLmReport->lm_tea_report);

      // foreach($lm_tea_report->land_class as $val)
      // {
      //   if($val->prev_land_class_code == null || $val->prev_land_class_code == '')
      //   {
      //     log_message('error', '#ERROR1532: LRS has not submitted the previous land class !!!');
      //     $this->session->set_flashdata('message', "Warning1531: LRA report is not complete, please revert to LRA");
      //     redirect(base_url() . "index.php/home");
      //   }
      // }

      if($adc_dc_code == '' || $adc_dc_code == null)
      {
        log_message('error', '#ERROR1530: ADC selection is required !!!');
        $this->session->set_flashdata('message', "Warning1531: Please select ADC");
        redirect(base_url() . "index.php/home");
      }

      // check if SRO has given the report or not
      $sroReport = $this->db->query("SELECT * FROM sro_push_history WHERE case_no=? AND 
                      sro_code IS NOT NULL AND action=?", array($case_no, 'Y'))->num_rows();

      if($sroReport == 0 && IS_PRODUCTION == 1)
      {
        log_message('error', '#ERROR1501: SRO report pending !!!');
        $this->session->set_flashdata('message', "Error #ERR1500: SRO report pending for case no # $case_no");
        redirect(base_url() . "index.php/home");
      }

      $this->db->trans_begin();

      // foward to dc updates

      $get_settlement_basic2 = $this->SettlementApModel->getSettlementBasicCo($case_no);
      $from_office_check = $get_settlement_basic2->from_office;

      $headQtrCheck = $this->SettlementCommonModel->headquarterCheck($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'));

      // var_dump($headQtrCheck); die;

      $pending_officer = 'ADC';
      $pending_office  = 'DC';


      // if(trim($headQtrCheck) == 'Y'){
      //     $pending_officer = 'ADC';
      //     $pending_office = 'DC';
      // }else{
      //     $pending_officer = 'SDO';
      //     $pending_office = 'DC';
      // }

      // var_dump($from_office_check); die;

      //////proceeding if sk report not submitted//////
      if($from_office_check == 'LM'){

        $proceeding_sk_check = $this->db->query("SELECT * from settlement_proceeding where case_no='$case_no' and office_from='SK' and office_to='CO'");

        if($proceeding_sk_check->num_rows() <= 0) {

          $proceeding_id = $this->db->query("SELECT max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
          if ($proceeding_id == null) {
            $proceeding_id = 1;
          }

          $insertArr = [
            'case_no'              => $case_no,
            'proceeding_id'        => $proceeding_id,
            'date_of_hearing'      => date('Y-m-d H:i:s'),
            'next_date_of_hearing' => date('Y-m-d H:i:s'),
            'note_type'            => $adc_dc_code,
            'note_on_order'        => 'SK Report not submitted',
            'status'               => 'W',
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d H:i:s'),
            'operation'            => 'E',
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => 'CO',
            'office_to'            => 'CO',
            'task'                 => 'SK Report not submitted.',
          ];
          $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
          if ($insertProc != 1) {
            log_message('error', '#ERR1600: Insertion failed in settlement_proceeding');
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#ERR1600: Failed to forward to DC for case no # $case_no");
            redirect(base_url() . "index.php/home");
          }
        }
      }

      $updateArr = [
        'status'          => 'W',
        'co_code'         => $this->session->userdata('user_code'),
        'co_note_yn'      => $remark_co_type,
        'date_update'     => date('Y-m-d H:i:s'),
        'from_office'     => 'CO',
        'pending_officer' => $pending_officer,
        'pending_office'  => $pending_office,
        'adc_code'        => $adc_dc_code,
      ];
      $this->db->where('case_no', $case_no);
      $this->db->update('settlement_basic', $updateArr);

      if ($this->db->affected_rows() != 1) 
      {
        $this->db->trans_rollback();
        $this->session->set_flashdata('message', "Error #ERR1590: Failed to forward to DC for case no # $case_no");
        redirect(base_url() . "index.php/home");
      }

      //////proceeding start//////
      $proceeding_id = $this->db->query("SELECT max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
      if ($proceeding_id == null) {
          $proceeding_id = 1;
      }

      $msg = '';
      $msg = $remark_co_type == 1 ? 'Can be Recommended' : 'Can not be Recommended';

      $insertArr = [
        'case_no'              => $case_no,
        'proceeding_id'        => $proceeding_id,
        'date_of_hearing'      => date('Y-m-d H:i:s'),
        'next_date_of_hearing' => date('Y-m-d H:i:s'),
        'note_type'            => $remark_co_type,
        'note_on_order'        => $remark_co.'<br>'.$msg,
        'status'               => 'W',
        'user_code'            => $this->session->userdata('user_code'),
        'date_entry'           => date('Y-m-d H:i:s'),
        'operation'            => 'E',
        'ip'                   => $this->utilityclass->get_client_ip(),
        'office_from'          => 'CO',
        'office_to'            => $pending_officer,
        'task'                 => 'Forwarded to '.$pending_officer,
        'co_order'             => $adc_dc_code,
      ];
      $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
      if ($insertProc != 1) {
        $this->db->trans_rollback();
        $this->session->set_flashdata('message', "Error #ERR1652: Failed to forward to DC for case no # $case_no");
        redirect(base_url() . "index.php/home");
      }
      if ($this->db->trans_status() == false) {
        $this->db->trans_rollback();
        $data = array(
          'error' => "Error in submitting. Please try Again",
        );
        return $data;
        exit;
      } else {

        // echo "moi "; die;

        //////////////POST To basundhara////////////////////

        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
        // $this->db->trans_rollback();

        $rmk         = 'Forwarded to '.$pending_officer;
        $status      = 'M';
        $task        = 'CO';
        $pen         = $pending_officer;
        $case        = $case_no;
        $rtps_status = $this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);

        // var_dump($pending_officer); die;
        $rtps_status=json_decode($rtps_status);
        if(trim($rtps_status)!="y"){
          $this->db->trans_rollback();
          $this->session->set_flashdata('message', "Error #ERRAPP2076: Forward to $pending_officer failed case no # $case_no");
          redirect(base_url() . "index.php/home");
        }else{
          $this->db->trans_commit();
          $this->session->set_flashdata('message', "Case no # $case_no forwarded to ".$pending_officer);
          redirect(base_url() . "index.php/home");
          // redirect(base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $case_no);
        }
        // $this->load->view('SettlementView/Co/SettlementApTransferred');
      }
    }
  }



  public function initialLanding(){
    // echo "sdfgh"; die;
    $service_code        = $this->input->get('service');
    $status              = $this->input->get('s');    
    $data['SELECT_data'] = $this->SettlementCommonModel->locationSELECTAll();
    $data['_view']       = 'TeaGrant/CO/TeaGrantLandingPageCo';
    $this->load->view('layouts/main', $data);
  }

  public function paginationCoFirstBulk()
  {
    if(LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO'){
      $lot_string = $this->caseListUnderMappingLot();
    }

    $s_code         = TEA_SERVICE_CODE;
    $search_term    = $this->input->post('search_term');
    $reverted       = $this->input->post('reverted');
    $user_code      = $this->session->userdata('user_code');
    $payment_status = $this->input->post('payment_status');

    $mouza_pargona_code = $this->input->post('mouza_pargona_code');
    $lot_no             = $this->input->post('lot_no');
    $nr_cat             = $this->input->post('nr_cat');

    $status = $this->input->post('status');
    $draw   = intval($this->input->post('draw'));
    $start  = intval($this->input->post('start'));
    $length = intval($this->input->post('length'));
    $order  = $this->input->post('order');

    $search = $this->input->post('search');
    $search = $search['value'];

    $searchByCol_0 = $this->input->post('columns')[1]['search']['value'];
    $is_cat        = $this->input->post('is_category');

    $dist_code   = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code    = $this->session->userdata('cir_code');

    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "coServicewiseRecords/$s_code/$dist_code/$subdiv_code/$cir_code");

    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
      'start'              => $start,
      'length'             => $length,
      'order'              => $order,
      'application_no'     => $searchByCol_0,
      'mouza_pargona_code' => $mouza_pargona_code,
      'lot_no'             => $lot_no,
      'vill_townprt_code'  => $is_cat
    )));
    $result  = curl_exec($curl_handle);
    $results = json_decode($result);

    if (isset($results)) 
    {         
      foreach ($results->data_results as $rows) {

        $tea_grant_link = '<a type="button" href="' . base_url() . 'index.php/TeaGrantControllerCo/applicationTeaGrantRegistrationCo?app='. $this->utilityclass->encryptJwtCase($rows->application_no).'" class="btn-sm btn btn-primary">Write Report</a>';

        $json[] = array(
          $rows->application_no,
          '<span class="px-3"><strong>' . $rows->application_no . '</strong></span>',
          $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_code),
          $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_code, $rows->lot_no),
          $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_code, $rows->lot_no, $rows->village_code),  
          $rows->date_submission,  
          (($s_code == TEA_SERVICE_CODE && DISABLE_ALL_BUTTON == 0) ? $tea_grant_link : ''),
        );
      }



      $total_records = $results->total_records;
      $response = array(
        'draw'            => $draw,
        'recordsTotal'    => $total_records,
        'recordsFiltered' => $total_records,
        'data'            => $json,
      );
      echo json_encode($response);
    } 
    else 
    {
      $response                         = array();
      $response['sEcho']                = 0;
      $response['iTotalRecords']        = 0;
      $response['iTotalDisplayRecords'] = 0;
      $response['aaData']               = [];
      echo json_encode($response);
    }
  }

  public function applicationTeaGrantRegistrationCo($review_flag = false) 
  {
    $application_no = $this->input->get('app');

    $application_no = $this->utilityclass->decryptJwtCase($application_no);

    // get deed_no if applied by applicant
    // $appl_deed_no = $this->db->query("SELECT * FROM settlement_applicant WHERE pdar_type=? AND application_no=?",
    //                     array('DA', $application_no));
    // var_dump($this->db);
    // if($appl_deed_no->num_rows() == 0) {
    //   $appl_deed_no = '';
    // }
    // else {
    //   $appl_deed_no = $appl_deed_no->row()->deed_no;
    // }    

    $geo_date_query = $this->db->query("SELECT date_entry FROM supportive_document WHERE applid='$application_no'")->row();
    $geo_date = isset($geo_date_query->date_entry)? $geo_date_query->date_entry : '.....';

    // $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE applid = ? AND file_name = ? ", array($application_no, GEO_TAG_PHOTO) );
    $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE id in (SELECT max(id) FROM supportive_document WHERE applid=? and dag_no is not null and file_name=? GROUP BY applid, dag_no)", array($application_no, GEO_TAG_PHOTO));

    if($supportive_document_sql->num_rows() > 0)
    {
      $codata['geo_tag_doc'] = $supportive_document_sql->result();
    }
    else
    {
      $codata['geo_tag_doc_empty'] = "<span class='text-danger alert-danger'><b>Geo tag photo yet to be uploaded.</b></span>";
    }

    //********************case registration FROM API start ********* */
    //********************check and insert if case not registered */
    $recordExist=$this->SettlementApiModel->checkExistDharitree($application_no);

    // var_dump($recordExist); die;

    if(!$recordExist)
    {
      // echo "sdfg"; die;
      /// additional property for LM note
      $additional_property = $this->db->query("SELECT * FROM      settlement_additional_property WHERE applid='$application_no'");
      if($additional_property->num_rows() > 0){
        $totallesaa=0;
        $totalganda=0;
        foreach($additional_property->result() as $addprop){
          if(in_array($addprop->dist_code, json_decode(BARAK_VALLEY))){
            $total_g=$this->utilityclass->Total_ganda($addprop->bigha,$addprop->katha,$addprop->lessa,$addprop->ganda);
            $totalganda = $totalganda+$total_g;
          }else{
            $total_l=$this->utilityclass->Total_Lessa($addprop->bigha,$addprop->katha,$addprop->lessa);
            $totallesaa = $totallesaa+$total_l;
          }

        }
        if(!empty($totallesaa)){
          $district['total_aditional_area']= $this->utilityclass->Total_Bigha_Katha_Lessa($totallesaa);
        }
        if(!empty($totalganda)){
          $district['total_aditional_area_g']= $this->utilityclass->Total_Bigha_Katha_Lessa2($totalganda);
        }
        $district['additional_property']=$additional_property->result();
        //var_dump($district['additional_property']); die;
      }

      $token = $this->utilityclass->createTokenJwt();
      $curl_handle = curl_init();
      curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."getAppDetails");
      curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
      curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
        'application_no' => $application_no,
        'api_key'        => API_KEY,
        'token'          => $token
      )));

      $output = curl_exec($curl_handle);
      if(isset(json_decode($output)->responseType)){
        if(json_decode($output)->responseType == 3){
          echo json_decode($output)->data." - Unauthorized access!";
          return false;
        }
      }
      curl_close($curl_handle);
      $backup = $output;
      $output = json_decode($output);

      // echo "<pre>";var_dump($output); die;

      //****************generate case number********************
      $case_name=$this->SettlementApiModel->genearteCaseName();
      if(empty($case_name))
      {
        $data = array(
          'error' => "Network Issue or Session Out. Please try Again"
        );
        echo json_encode($data);
        die();
      }
      //*******generating petition_no and case_no */
      $case_no['petition_no'] = $petition_no=$this->SettlementApiModel->genearteSettlementPetitionNo();
      $case_no['case_no']     = $case_name.$petition_no."/".TEA_PREFIX;
      $district['geo_date']   = $geo_date;
      $district['app']        = $output->application;
      $district['pattaNo']    = $this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$district['app']->dag_no);

      $district['applicants']   = $output->applicants;
      $district['document']     = $output->documents;
      $district['query']        = $output->query;
      $district['property']     = $output->property;
      $district['settlements']  = $output->settlements;
      $district['owners']       = $output->owners;
      $district['aadhar']       = $output->aadhar;
      $district['nextKin']      = $output->nextKin;
      $district['teaDagDetail'] = $output->teadags;

      

      // get khatian number
      $d   = $district['app']->dist_code;
      $s   = $district['app']->subdiv_code;
      $c   = $district['app']->cir_code;
      $m   = $district['app']->mouza_code;
      $l   = $district['app']->lot_no;
      $v   = $district['app']->village_code;
      $dag = $district['app']->dag_no;

      $district['co_name']= $this->SettlementCommonModel->getCoName($d, $s, $c);
      $district['s_area'] = $this->SettlementCommonModel->getPremiumArea();

      $district['bhumi']  = $output->bhumi;

      // for guardian relation
      $query_for_guar_rel = "SELECT * FROM master_guard_rel WHERE id NOT IN ('5','6')";

      $relation_executation = $this->db->query($query_for_guar_rel);
      $row = $relation_executation->num_rows();

      if ($row != 0) {
        $district['guar_rel'] = $relation_executation->result();
      }

      // $district['selfDeclarationDetails'] = $output->selfDeclaration;
      foreach($output->selfDeclaration as $selfDec){
        $district['selfDeclarationDetails']=json_decode($selfDec->dec_details);
      }

      // aadhaar photo api
      $curl_handle = curl_init();
      curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."getApplicantPhoto");

      curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
      curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
        'application_no' => $application_no,
      )));
      $get_aadhaar_photo = curl_exec($curl_handle);
      curl_close($curl_handle);

      if($get_aadhaar_photo != 'n'){
        $district['aadhaar_b64_decoded'] = "<img src = data:".$this->decodeBase64($get_aadhaar_photo).";base64,".$get_aadhaar_photo." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
      }

      // var_dump($get_aadhaar_photo); die;

      $this->db->trans_begin();

      // insertion in backup table (lm)
      $backup_array = [
        'applid'  => $application_no,
        'case_no' => $case_no['case_no'],
        'status'  => 'I',
        'data'    => $backup
      ];

      $backup_insertion = $this->db->insert('settlement_backup_json', $backup_array);

      if($backup_insertion != 1){
        $this->db->trans_rollback();
        log_message('error', '#BACKUP001: Insertion failed in settlement_backup_json RTPS Case No '.$application_no);

        $this->session->set_flashdata('message', "#BACKUP001: Registration of Settlement failed for case no : ".$application_no);
        redirect(base_url() . "index.php/home");
        return false;
      }

      ///////// additional property starts here
      $checkAdditionalProperty = $this->db->query("SELECT * FROM 
                                    settlement_additional_property 
                                      WHERE applid=?", array($application_no));

      if($checkAdditionalProperty->num_rows() == 0) {
        if(isset($output->property)) {
          foreach($output->property as $value) {
            $add_property = array(
              'case_no'            => $case_no['case_no'],
              'dist_code'          => $value->dist_code,
              'subdiv_code'        => $value->subdiv_code,
              'cir_code'           => $value->cir_code,
              'mouza_pargona_code' => $value->mouza_pargona_code,
              'lot_no'             => $value->lot_no,
              'vill_townprt_code'  => $value->vill_townprt_code,
              'bigha'              => $value->bigha,
              'katha'              => $value->katha,
              'lessa'              => $value->lessa,
              'chatak'             => $value->lessa,
              'ganda'              => $value->ganda,
              'kranti'             => $value->kranti,
              'entry_date'         => date('Y-m-d H:i:s'),
              'is_rural'           => $value->is_rural,
              'dag_no'             => $value->dag_no,
              'patta_no'           => $value->patta_no,
              'service_id'         => TEA_SERVICE_CODE,
              'applied_flag'       => CITIZEN,
              'dist_name'          => trim($value->dist_name),
              'cir_name'           => trim($value->cir_name),
              'vill_name'          => trim($value->vill_name),
              'applid'             => $application_no,
            );
            $insAddProperty = $this->db->insert('settlement_additional_property', $add_property);

            if($insAddProperty != 1) {
              $this->db->trans_rollback();
              log_message('error', '#ERROR393: Insertion failed in settlement_additional_property RTPS Case No '.$application_no);
              $data = array(
                  'error'=>"#ERROR393: Registration of Settlement failed for case no : ".$application_no
              );
              echo json_encode($data);
              return false;
            }
          }
        }
      }
      ///////// additional property ends here

      $pro_class          = $this->input->post('protected_class');
      $protected_class_vr = ($pro_class==null || $pro_class=='' || $pro_class==0) ? 0 : $this->input->post('protected_class');

      //****bhumiputra condition prepare for insertation */
      // if(!empty($output->bhumi['0'])) {
      //   if($output->bhumi['0']->bhumi_cert_available == 1){ //if bhumiputra available
      //     $bhumiputra_confirmation     = 'YES';
      //     $bhumiputra_certificate_no   = $output->bhumi['0']->bhumi_ack_no;
      //     $bhumiputra_certificate_type = 'CERT';
      //   }
      //   else if($output->bhumi['0']->is_bhumi_applied == 1){ //if applied in bhumiputra
      //     $bhumiputra_confirmation     = 'YES';
      //     $bhumiputra_certificate_no   = $output->bhumi['0']->bhumi_ack_no;
      //     $bhumiputra_certificate_type = 'ACK';
      //   }
      //   else {
      //     $bhumiputra_confirmation     = '0';
      //     $bhumiputra_certificate_no   = '0';
      //     $bhumiputra_certificate_type = '0';
      //   }
      // }
      // else {
      //   $bhumiputra_confirmation     = '0';
      //   $bhumiputra_certificate_no   = '0';
      //   $bhumiputra_certificate_type = '0';
      // }

      //********settlement_basic insertation */
      $basic=array(
        'dist_code'                   => $district['app']->dist_code,
        'subdiv_code'                 => $district['app']->subdiv_code,
        'cir_code'                    => $district['app']->cir_code,
        'mouza_pargona_code'          => $district['app']->mouza_code,
        'lot_no'                      => $district['app']->lot_no,
        'vill_townprt_code'           => $district['app']->village_code,
        'service_code'                => $district['app']->service_code,
        'ref_no'                      => $district['app']->ref_no,
        'case_no'                     => $case_no['case_no'],
        'trans_code'                  => 'F',/////////full
        'petition_no'                 => $case_no['petition_no'],
        'year_no'                     => date('Y'),
        'date_entry'                  => date('Y-m-d G:i:s'),
        'status'                      => 'ZC',
        'user_code'                   => $this->session->userdata('user_code'),
        'submission_date'             => date('Y-m-d G:i:s'),
        'from_office'                 => 'API',
        'pending_officer'             => 'CO',
        'pending_office'              => 'CO',
        'occupation_applicant'        => $district['applicants'][0]->occupation,
        'applid'                      => $district['app']->application_no,
        'caste'                       => $district['applicants'][0]->caste,
        'uuid'                        => $district['app']->uuid,
        'protected_class'             => $protected_class_vr,
        // 'applicant_applied_on'        => $district['app']->applicant_applied_on,
        // 'bhumiputra_confirmation'     => $bhumiputra_confirmation,
        // 'bhumiputra_certificate_no'   => $bhumiputra_certificate_no,
        // 'bhumiputra_certificate_type' => $bhumiputra_certificate_type,
      );

      $insSetBasic = $this->db->insert('settlement_basic', $basic);
      // echo $this->db->last_query(); die();

      if ($insSetBasic != 1) {
        $this->db->trans_rollback();
        log_message('error', '#ERRSET00011: Insertion failed in settlement_basic RTPS Case No '.$application_no);

        $data = array(
            'error'=>"#ERRSET00011: Registration of Settlement failed for case no : ".$application_no
        );
        echo json_encode($data);
        return false;
      }

      // echo "<pre>"; var_dump($district['teaDagDetail']); die;

      ////settlement_dag_details insert start
      if ($district['teaDagDetail'] == false || empty($district['teaDagDetail']) || $district['teaDagDetail'] == '') {
          $this->db->trans_rollback();
          log_message('error', '#ERRSET00443: Insertion failed settlement_dag details empty RTPS Case No '.$application_no);

          $data = array(
              'error'=>"#ERRSET00443: Registration of Settlement failed for case no : ".$application_no
          );
          echo json_encode($data);
          return false;
      }
      foreach ($district['teaDagDetail'] as $dags) {

        // var_dump($dags); die;

        $district['class']=$this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code, $dags->dag_no);

        // var_dump($district['class']); die;

        $applied_bigha  = $dags->bigha;
        $applied_katha  = $dags->katha;
        $applied_lessa  = $dags->lessa;
        $applied_ganda  = $dags->ganda;
        $applied_kranti = $dags->kranti;

        $applied_area = [
          'applied_bigha'  => $dags->bigha,
          'applied_katha'  => $dags->katha,
          'applied_lessa'  => $dags->lessa,
          'applied_ganda'  => $dags->ganda,
          'applied_kranti' => $dags->kranti,
        ];

        // echo "<pre>"; var_dump($dags); die;

        $fmd = array(
          'dist_code'           => $district['app']->dist_code,
          'subdiv_code'         => $district['app']->subdiv_code,
          'cir_code'            => $district['app']->cir_code,
          'mouza_pargona_code'  => $district['app']->mouza_code,
          'lot_no'              => $district['app']->lot_no,
          'vill_townprt_code'   => $district['app']->village_code,
          'user_code'           => $this->session->userdata('user_code'),
          'date_entry'          => date('Y-m-d'),
          'case_no'             => $case_no['case_no'],
          'petition_no'         => $case_no['petition_no'],
          'year_no'             => date('Y'),
          'new_land_class_code' => $district['class']->land_class_code,
          'dag_no'              => $dags->dag_no,
          'patta_no'            => $dags->patta_no,
          'patta_type_code'     => $dags->patta_type_code,
          'is_urban'            => $district['app']->is_urban,
          'land_type'           => 0,
          'revenue'             => 0,
          'operation'           => 'E',
          'encroachement_area'  => json_encode($applied_area),
        );

        $fmd['dag_area_b']  = $dags->chitha_bigha;
        $fmd['dag_area_k']  = $dags->chitha_katha;
        $fmd['dag_area_lc'] = $dags->chitha_lessa;
        $fmd['dag_area_g']  = $dags->chitha_ganda;
        $fmd['dag_area_kr'] = $dags->chitha_kranti;

        $fmd['applied_b']   = $dags->bigha;
        $fmd['applied_k']   = $dags->katha;
        $fmd['applied_lc']  = $dags->lessa;
        $fmd['applied_g']   = $dags->ganda;
        $fmd['applied_kr']  = $dags->kranti;

        //************Total Area Calculation -js- ******************
        if(in_array($district['app']->dist_code, json_decode(BARAK_VALLEY)))
        {
          //******for Barak valley */
          $appliedArea    = $this->utilityclass->Total_ganda($fmd['applied_b'],$fmd['applied_k'],$fmd['applied_lc'],$fmd['applied_g'],$fmd['applied_kr']);
          $totalAreaGanda = (float)$appliedArea;
          $totalAreaArr   = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalAreaGanda);
        }
        else
        {
          $appliedArea    = $this->utilityclass->Total_Lessa($fmd['applied_b'],$fmd['applied_k'],$fmd['applied_lc']);
          $totalAreaLessa = (float)$appliedArea;
          $totalAreaArr   = $this->utilityclass->Total_Bigha_Katha_Lessa($totalAreaLessa);
        }

        $fmd['s_dag_area_b']  = $totalAreaArr[0];
        $fmd['s_dag_area_k']  = $totalAreaArr[1];
        $fmd['s_dag_area_lc'] = $totalAreaArr[2];
        $fmd['s_dag_area_g']  = $totalAreaArr[3];
        $fmd['s_dag_area_kr'] = 0;

        $landTypeUpdate = 0;

        $insSetDag = $this->db->insert('settlement_dag_details', $fmd);
        // echo $this->db->last_query();die;
        // log_message('error',$this->db->last_query());

        if ($insSetDag != 1) {
          $this->db->trans_rollback();
          log_message('error', '#ERRSET0002: Insertion failed in settlement_dag_details RTPS Case No '.$application_no);
          // log_message('error', '#ERRSET0002: Insertion failed in settlement_dag_details RTPS Case No '.$this->db->last_query());
          $data = array(
            'error'=>"#ERRSET0002: Registration of Settlement failed for case no : ".$application_no
          );
          echo json_encode($data);
          return false;
        }

        //*******insertion in settlement_area_history**************
        if (in_array($district['app']->dist_code, json_decode(BARAK_VALLEY)))
        {
          //***********actual Encroachment area ***************
          $actual_applied_area_ganda = $this->utilityclass->Total_ganda($applied_bigha,$applied_katha,$applied_lessa,$applied_ganda);

          //***********total Actual Encroachment area*****************
          $total_actual_applied_area_ganda = (float)$actual_applied_area_ganda;
          $totalAppliedAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_actual_applied_area_ganda);
          // **********************************************


          //***********Settlement area that applicant will get settlement on***********
          $total_settlement_ganda_tea_grant = $this->utilityclass->Total_ganda($applied_bigha,$applied_katha,$applied_lessa,$applied_ganda);

          //*****total Settlement area *************/
          $total_settlement_ganda = (float)$total_settlement_ganda_tea_grant;
          $totalSettlementAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_settlement_ganda);

          //*************leftout area **************
          $leftOutAreaTeaGrantGanda = (float)$actual_applied_area_ganda - (float)$total_actual_applied_area_ganda;
          $leftOutAreaTeaGrantArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($leftOutAreaTeaGrantGanda);

          //**********Total left out area***************
          $totalLeftOutAreaGanda = (float)$total_actual_applied_area_ganda - (float)$total_settlement_ganda;
          $totalLeftOutAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalLeftOutAreaGanda);
        }
        else
        {
          //***********actual Encroachment area ***************
          $actual_applied_area_lessa = $this->utilityclass->Total_Lessa($applied_bigha,$applied_katha,$applied_lessa);

          //***********total Actual Encroachment area*****************
          $total_actual_applied_area_lessa = (float)$actual_applied_area_lessa;
          $totalAppliedAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_actual_applied_area_lessa);
          // **********************************************


          //***********Settlement area that applicant will get settlement on***********
          $total_settlement_lessa_tea_grant = $this->utilityclass->Total_Lessa($applied_bigha,$applied_katha,$applied_lessa);

          //*************Total settlement area */
          $total_settlement_lessa = (float)$total_settlement_lessa_tea_grant;
          $totalSettlementAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_settlement_lessa);

          //****************leftout area homestead**************
          $leftOutAreaTeaGrantLessa = (float)$actual_applied_area_lessa - (float)$total_settlement_lessa_tea_grant;
          $leftOutAreaTeaGrantArr = $this->utilityclass->Total_Bigha_Katha_Lessa($leftOutAreaTeaGrantLessa);

          //**********Total left out area***************
          $totalLeftOutArealessa = (float)$total_actual_applied_area_lessa - (float)$total_settlement_lessa;
          $totalLeftOutAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($totalLeftOutArealessa);
        }

        $settlementAreaHistoryArr = [
          'application_no'                        => $application_no,
          'case_no'                               => $case_no['case_no'],
          'dag_no'                                => $dags->dag_no,
          'uuid'                                  => $district['app']->uuid,
          'created_at'                            => date('Y-m-d'),
          'applied_area_home_bigha'               => $dags->bigha,
          'applied_area_home_katha'               => $dags->katha,
          'applied_area_home_lessa'               => $dags->lessa,
          'applied_area_home_ganda'               => $dags->ganda,
          'applied_area_home_kranti'              => $dags->kranti,
          'applied_area_agri_bigha'               => 0,
          'applied_area_agri_katha'               => 0,
          'applied_area_agri_lessa'               => 0,
          'applied_area_agri_ganda'               => 0,
          'applied_area_agri_kranti'              => 0,
          'actual_encroachment_area_home_bigha'   => $dags->bigha,
          'actual_encroachment_area_home_katha'   => $dags->katha,
          'actual_encroachment_area_home_lessa'   => $dags->lessa,
          'actual_encroachment_area_home_ganda'   => $dags->ganda,
          'actual_encroachment_area_home_kranti'  => $dags->kranti,
          'actual_encroachment_area_agri_bigha'   => 0,
          'actual_encroachment_area_agri_katha'   => 0,
          'actual_encroachment_area_agri_lessa'   => 0,
          'actual_encroachment_area_agri_ganda'   => 0,
          'actual_encroachment_area_agri_kranti'  => 0,
          'total_actual_encroachment_area_bigha'  => $totalAppliedAreaArr[0],
          'total_actual_encroachment_area_katha'  => $totalAppliedAreaArr[1],
          'total_actual_encroachment_area_lessa'  => $totalAppliedAreaArr[2],
          'total_actual_encroachment_area_ganda'  => $totalAppliedAreaArr[3],
          'total_actual_encroachment_area_kranti' => 0,
          'settlement_area_home_bigha'            => $dags->bigha,
          'settlement_area_home_katha'            => $dags->katha,
          'settlement_area_home_lessa'            => $dags->lessa,
          'settlement_area_home_ganda'            => $dags->ganda,
          'settlement_area_home_kranti'           => $dags->kranti,
          'settlement_area_agri_bigha'            => 0,
          'settlement_area_agri_katha'            => 0,
          'settlement_area_agri_lessa'            => 0,
          'settlement_area_agri_ganda'            => 0,
          'settlement_area_agri_kranti'           => 0,
          'total_settlement_area_bigha'           => $totalSettlementAreaArr[0],
          'total_settlement_area_katha'           => $totalSettlementAreaArr[1],
          'total_settlement_area_lessa'           => $totalSettlementAreaArr[2],
          'total_settlement_area_ganda'           => $totalSettlementAreaArr[3],
          'total_settlement_area_kranti'          => 0,
          'leftout_area_home_bigha'               => $leftOutAreaTeaGrantArr[0],
          'leftout_area_home_katha'               => $leftOutAreaTeaGrantArr[1],
          'leftout_area_home_lessa'               => $leftOutAreaTeaGrantArr[2],
          'leftout_area_home_ganda'               => $leftOutAreaTeaGrantArr[3],
          'leftout_area_home_kranti'              => 0,
          'leftout_area_agri_bigha'               => 0,
          'leftout_area_agri_katha'               => 0,
          'leftout_area_agri_lessa'               => 0,
          'leftout_area_agri_ganda'               => 0,
          'leftout_area_agri_kranti'              => 0,
          'total_leftout_area_bigha'              => $totalLeftOutAreaArr[0],
          'total_leftout_area_katha'              => $totalLeftOutAreaArr[1],
          'total_leftout_area_lessa'              => $totalLeftOutAreaArr[2],
          'total_leftout_area_ganda'              => $totalLeftOutAreaArr[3],
          'total_leftout_area_kranti'             => 0,
        ];

        $insertSetlArea = $this->db->insert('settlement_area_history', $settlementAreaHistoryArr);


        if ($insertSetlArea != 1) {
          $this->db->trans_rollback();
          log_message('error', '#SETLARRHIS0001: Insertion failed in settlement_area_history RTPS Case No '.$application_no);
          $data = array(
            'error'=>"#SETLARRHIS0001: Registration of Settlement failed for case no : ".$application_no,
          );
          echo json_encode($data);
          return false;
        }
        //**************end of settlement_area_history********************
      }

      //*******pdar_cron number generation */
      $sql = "SELECT pdar_cron_no FROM settlement_applicant WHERE case_no = '".$case_no['case_no']."'";
      $result = $this->db->query($sql);
      if($result->num_rows() > 0){
        $cron_no = (int)$result->row()->pdar_cron_no + 1;
      }else{
        $cron_no = 1;
      }

      // echo "<pre>"; var_dump($district['applicants']); die;

      //*********settlement_applicant insertion */
      // foreach ($district['applicants'] as $setl) 
      // {
                
      // }
      foreach ($district['applicants'] as $setl) 
      {
        if ($get_aadhaar_photo != 'n' && $setl->is_applicant == '1' && IS_PRODUCTION == 1) 
        {
          $timestamp = date('mdYhis', time()).uniqid();
          $identity_doc_unique_name = str_replace('/', "-", $application_no.'_'.$timestamp);
          // creating and saving the base64 format payment notice to uploads/paymentNotice folder
          $aadhar_path = AADHAAR_PHOTO . $identity_doc_unique_name . ".json";
          $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file!");
          $aadhaar_encoded_file = $get_aadhaar_photo;
          fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
          fclose($aadhaar_file_to_write_base64);
        }
        else{
          $aadhar_path = '';
        }

        if($district['aadhar']->type == 'AADHAAR'){
          $identity_ref_no = $district['aadhar']->aadhaar_no;
        }else{
          $identity_ref_no = $district['aadhar']->pan_no;
        }    

        // echo "<pre>";
        // var_dump($district['applicants']); die;

        if($setl->is_applicant == 1 && $setl->pdar_type == 'B')
        {
          $present_add   = $setl->entered_add1;
          $permanent_add = $setl->entered_add2;
          $mobile_no     = $setl->mobile_no;    
              

          $otherApplicant=array(
            'dist_code'           => $district['app']->dist_code,
            'subdiv_code'         => $district['app']->subdiv_code,
            'cir_code'            => $district['app']->cir_code,
            'mouza_pargona_code'  => $district['app']->mouza_code,
            'lot_no'              => $district['app']->lot_no,
            'vill_townprt_code'   => $district['app']->village_code,
            'user_code'           => $this->session->userdata('user_code'),
            'case_no'             => $case_no['case_no'],
            'petition_no'         => $case_no['petition_no'],
            'operation'           => 'E',
            'dag_no'              => '0',
            'patta_no'            => '0',
            'patta_type_code'     => '0',
            'year_no'             => date('Y'),
            'date_entry'          => date('Y-m-d H:i:s'),
            'pdar_id'             => $setl->pdar_id == null ? '-1' : $setl->pdar_id,
            'pdar_cron_no'        => (int) $cron_no++,
            'pdar_name'           => $setl->pdar_name,
            'pdar_guardian'       => $setl->pdar_father,
            'eng_pdar_name'       => $setl->pdar_name_eng,
            'eng_pdar_guardian'   => $setl->pdar_father_eng,
            'pdar_rel_guar'       => isset($setl->relation) && $setl->relation != null ? $setl->relation : 0,
            'pdar_gender'         => isset($setl->pdar_gender) && $setl->pdar_gender != null ? $setl->pdar_gender : 0,
            'pdar_add1'           => $present_add,
            'pdar_add2'           => $permanent_add,
            'pdar_mobile'         => $mobile_no,
            'pdar_type'           => $setl->pdar_type,
            'is_applicant'        => $setl->is_applicant,
            'identity_ref_no'     => $identity_ref_no,
            'identity_type'       => $district['aadhar']->type,
            'identity_doc_link'   => $setl->is_applicant == '1' ? $aadhar_path : '',
            'marital_status'      => $setl->marital_status,
            'dob'                 => isset($setl->dob) ? $setl->dob : null,
            'relation_with_pattadar' => isset($setl->relation_with_pattadar) ? $setl->relation_with_pattadar : null,
            'period_possession'   => $setl->possession_from,
            'appl_deed_no'        => $setl->deed_no,
          );                

          $insOtherApplicant = $this->db->insert('settlement_applicant', $otherApplicant);
          // echo $this->db->last_query();  

          if($insOtherApplicant != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRSET2425: Insertion failed in settlement_applicant RTPS Case No '.$application_no.' and query :'.$this->db->last_query());
            $data = array(
              'error'=>"#ERRSET2425: Registration of Settlement failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
          }
        }
      }

      // die;

      // insert other pdar type
      foreach ($district['settlements'] as $setl) 
      {
        // if($setl->pdar_type != 'B')
        if($setl->is_applicant == 0)
        {
          $otherApplicant=array(
            'dist_code'           => $district['app']->dist_code,
            'subdiv_code'         => $district['app']->subdiv_code,
            'cir_code'            => $district['app']->cir_code,
            'mouza_pargona_code'  => $district['app']->mouza_code,
            'lot_no'              => $district['app']->lot_no,
            'vill_townprt_code'   => $district['app']->village_code,
            'user_code'           => $this->session->userdata('user_code'),
            'case_no'             => $case_no['case_no'],
            'petition_no'         => $case_no['petition_no'],
            'operation'           => 'E',
            'dag_no'              => empty($setl->dag_no) ? 0 : $setl->dag_no,
            'patta_no'            => empty($setl->patta_no) ? 0 : $setl->patta_no,
            'patta_type_code'     => empty($setl->patta_type_code) ? 0 : $setl->patta_type_code,
            'year_no'             => date('Y'),
            'date_entry'          => date('Y-m-d H:i:s'),
            'pdar_id'             => $setl->pdar_id == null ? '-1' : $setl->pdar_id,
            'pdar_cron_no'        => (int) $cron_no++,
            'pdar_name'           => $setl->pdar_name,
            'pdar_guardian'       => $setl->pdar_father,
            'eng_pdar_name'       => $setl->pdar_name_eng,
            'eng_pdar_guardian'   => $setl->pdar_father_eng,
            'pdar_rel_guar'       => isset($setl->pdar_rel_guar) && $setl->pdar_rel_guar != null ? $setl->pdar_rel_guar : 0,
            'pdar_gender'         => isset($setl->pdar_gender) && $setl->pdar_gender != null ? $setl->pdar_gender : 0,
            'pdar_add1'           => $present_add,
            'pdar_add2'           => $permanent_add,
            'pdar_mobile'         => $mobile_no,
            'pdar_type'           => $setl->pdar_type,
            'is_applicant'        => $setl->is_applicant,
            'identity_ref_no'     => $identity_ref_no,
            'identity_type'       => $district['aadhar']->type,
            'identity_doc_link'   => '',
            'marital_status'      => $setl->marital_status,
            'dob'                 => isset($setl->dob) ? $setl->dob : null,
            'relation_with_pattadar' => isset($setl->relation_with_pattadar) ? $setl->relation_with_pattadar : null,
            'period_possession'   => $setl->possession_from,
            'appl_deed_no'        => $setl->deed_no,
          );                

          $insOtherApplicant = $this->db->insert('settlement_applicant', $otherApplicant);
          // echo "<pre>"; echo $this->db->last_query();

          if($insOtherApplicant != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRSET2478: Insertion failed in settlement_applicant RTPS Case No '.$application_no.' and query :'.$this->db->last_query());
            $data = array(
              'error'=>"#ERRSET2478: Registration of Settlement failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
          }
        }
      }
      // die;

      // var_dump($setl->pdar_type); die;

      // var_dump($setl->pdar_type); die;

      ///// nominee add start /////
      if ($output->nextKin == true) {
        // foreach ($_POST['kin_name'] as $key =>$value) {
        foreach ($output->nextKin as $nex_of_kin) {
          $nominee_data=array(
            'case_no'       => $case_no['case_no'],
            'nominee_name'  => $nex_of_kin->next_of_kin_name,
            'address'       => $nex_of_kin->address,
            'mobile_no'     => $nex_of_kin->mobile_no,
            'relation'      => $nex_of_kin->relation_with_kin
          );
          $insNominee = $this->db->insert('settlement_nominee', $nominee_data);            

          if ($insNominee != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRSET00032: Insertion failed in settlement_nominee RTPS Case No '.$application_no);
            $data = array(
              'error'=>"#ERRSET00032: Registration of Settlement failed for case no : ".$application_no
            );
            echo json_encode($data);
            return false;
          }
        }
      }
      ///// nominee end //////

      //********basundhar_application insertation */
      $basundhara=array(
        'dharitree'    => $case_no['case_no'],
        'basundhara'   => $application_no,
        'date_reg'     => date('Y-m-d'),
        'reg_by'       => $this->session->userdata('user_code'),
        'app_status'   => 'M',
        'pending_with' => 'CO'
      );
      $basundhar_app = $this->db->insert('basundhar_application',$basundhara);

      if ($basundhar_app != 1) {
        $this->db->trans_rollback();
        log_message('error', '#ERRSET0003202: Insertion failed in basundhar_application RTPS Case No '.$application_no);
        $data = array(
          'error'=>"#ERRSET0003202: Registration of Settlement failed for case no : ".$application_no
        );
        echo json_encode($data);
        return false;
      }
      else {
        $this->db->trans_commit();
      }
    }
 
    $startTime = microtime(true);
    try{
      $codata['review_flag'] = false;
      if($review_flag){
        $sql = $this->db->query('SELECT * FROM settlement_basic WHERE applid = ? and review_flag = ?', array($application_no, $review_flag));

        if($sql->num_rows() > 0){
          $case_no = $sql->row()->case_no;
        }
        else{
          $data = array(
            'error' => 'Something went wrong! please contact administration!' .$application_no,
          );
          echo json_encode($data);
          return false;
        }
        $codata['review_flag'] = true;
      }else{
        $sql = $this->db->query('SELECT dharitree FROM basundhar_application WHERE basundhara = ?', array($application_no));

        if($sql->num_rows() > 0){
          $case_no = $sql->row()->dharitree;
        }
        else{
          $data = array(
            'error' => 'Something went wrong! please contact administration!' .$application_no,
          );
          echo json_encode($data);
          return false;
        }
      }

      //  row_array
      $basic             = $this->TeaGrantModel->getSettlementBasic($case_no);
      //  result
      $applicants_buyers = $this->TeaGrantModel->getAllApplicantBuyers($case_no);
      $applicants_owners = $this->TeaGrantModel->getAllApplicantOwners($case_no);

      $applicants_dag_details = $this->TeaGrantModel->getAllApplicantDagDetails($case_no);

      $dags              = $this->TeaGrantModel->getSettlementDag($case_no);
      $lmnotes           = $this->TeaGrantModel->getSettlementTenantLmNote($case_no);
      $proceedings       = $this->TeaGrantModel->getSettlementProceeding($case_no);
      $dhardocuments     = $this->TeaGrantModel->getDocuments($case_no);
      $nominee           = $this->TeaGrantModel->getAllNomineeDetail($case_no);

      $existing_pattadar = $this->TeaGrantModel->getAllExistingPattadar($case_no);
      $deed_applicant    = $this->TeaGrantModel->getAllDeedPattadar($case_no);
      $family_tree       = $this->TeaGrantModel->getAllFamilyTree($case_no);

      /// premium
      $codata['s_area']  = $this->SettlementCommonModel->getPremiumArea();
      
      $premiumData = $this->db->query("SELECT * FROM settlement_premium WHERE case_no='$case_no' and is_final=1")->row();
      $codata['premiumData'] = $premiumData;
      /// premium end

      $codata['basic']                  = $basic;
      $codata['geo_date']               = $geo_date;
      $codata['applicants_buyers']      = $applicants_buyers;
      $codata['applicants_owners']      = $applicants_owners;
      $codata['applicants_dag_details'] = $applicants_dag_details;
      $codata['reservation']            = $this->SettlementVgrModel->getSettlementReservation($case_no);

      $codata['dags']                   = $dags;
      $codata['lmnotes']                = $lmnotes;
      $codata['proceedings']            = $proceedings;
      $codata['dhardocuments']          = $dhardocuments;
      $codata['nominee']                = $nominee;
      $codata['existing_pattadar']      = $existing_pattadar;
      $codata['deed_applicant']         = $deed_applicant;
      $codata['family_tree']            = $family_tree;

      //for dag not eligible
      $codata['dag_count']              = count($dags);

      $d = $basic["dist_code"];
      $s = $basic["subdiv_code"];
      $c = $basic["cir_code"];
      $m = $basic["mouza_pargona_code"];
      $l = $basic["lot_no"];
      $v = $basic["vill_townprt_code"];

      //*******getting the deleted settlement_dag_details data FROM settlement_deleted_data table */
      $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($case_no);
      $deletedEncArray = array();
      foreach($deletedEnc as $encroacherDeleted_data)
      {
          $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
      }
      $codata['deleted_encroacher'] = $deletedEncArray;

      //***********getting the settlement_applicant occupiers data FROM settlement_deleted_data table */
      $deletedDags=$this->SettlementCommonModel->getDeletedDags($case_no);
      $deletedData = array();
      foreach($deletedDags as $deleteDag){
          $deletedData[] = json_decode($deleteDag->table_data);
      }
      $codata['deleted_dags'] = $deletedData;


      //   calling API for self declaration data

      $sql = "SELECT basundhara FROM basundhar_application WHERE dharitree='$case_no' ";
      $basundhara = $this->db->query($sql)->row();
      $token = $this->utilityclass->createTokenJwt();
      $curl_handle = curl_init();
      curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."getAppDetails");
      curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
      curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
        'application_no' => $basundhara->basundhara,
        'api_key'        => API_KEY,
        'token'          => $token
      )));
      $output = curl_exec($curl_handle);
      if(isset(json_decode($output)->responseType)){
        if(json_decode($output)->responseType == 3){
          echo json_decode($output)->data." - Unauthorized access!";
          return false;
        }
      }
      curl_close($curl_handle);
      $output = json_decode($output);

      $codata['document'] = $output->documents;
      $codata['query']    = $output->query;
      $codata['property'] = $output->property;
      $codata['aadhar']   = $output->aadhar;
      $codata['nextKin']  = $output->nextKin;
      foreach($output->selfDeclaration as $selfDec){
        $codata['selfDeclarationDetails'] = json_decode($selfDec->dec_details);
      }

      foreach($codata['applicants_buyers'] as $adhar_photo):
        if($adhar_photo->is_applicant == 1 && trim($adhar_photo->identity_type) == 'AADHAAR'):
          $get_aadhaar_photo = $this->TeaGrantModel->aadhaarPhotoView($application_no);
          if($get_aadhaar_photo != 'n'){
            $codata['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($get_aadhaar_photo).";base64,".$get_aadhaar_photo." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
          }
        endif;
      endforeach;

      // for guardian relation
      $query_for_guar_rel = "SELECT * FROM master_guard_rel WHERE id NOT IN ('5','6')";

      $relation_executation = $this->db->query($query_for_guar_rel);
      $row = $relation_executation->num_rows();

      if ($row != 0) {
        $codata['guar_rel'] = $relation_executation->result();
      }

      /// vlb data 
      if(isset($dags)){
        foreach($dags as $vlb_dag){
          $sqlvlbcheck = $this->db->query("SELECT * FROM settlement_land_bank_details WHERE application_no = ? AND dag_no = ?", array($application_no, $vlb_dag->dag_no));

          if($sqlvlbcheck->num_rows() > 0){
            $vlb_newly_added[] = $sqlvlbcheck->row()->dag_no;
          }
          else{
            $vlb_newly_added[] = false;
          }
        }
        $codata['vlb_newly_added'] = $vlb_newly_added;
      }

      /// additional property for LM note
      $additional_property = $this->db->query("SELECT * FROM settlement_additional_property WHERE applid='$application_no'");
      if($additional_property->num_rows() > 0){
        $totallesaa=0;
        $totalganda=0;
        foreach($additional_property->result() as $addprop){
          if(in_array($addprop->dist_code, json_decode(BARAK_VALLEY))){
            $total_g=$this->utilityclass->Total_ganda($addprop->bigha,$addprop->katha,$addprop->lessa,$addprop->ganda);
            $totalganda = $totalganda+$total_g;
          }else{
            $total_l=$this->utilityclass->Total_Lessa($addprop->bigha,$addprop->katha,$addprop->lessa);
            $totallesaa = $totallesaa+$total_l;
          }
        }
        if(!empty($totallesaa)){
          $codata['total_aditional_area']= $this->utilityclass->Total_Bigha_Katha_Lessa($totallesaa);
        }
        if(!empty($totalganda)){
          $codata['total_aditional_area_g']= $this->utilityclass->Total_Bigha_Katha_Lessa2($totalganda);
        }
        $codata['additional_property']=$additional_property->result();
          //var_dump($codata['additional_property']); die;
      }

      $codata['case_no'] = $case_no;

      $rejected_data = $this->SettlementCommonModel->getRejectModal(TEA_SERVICE_CODE);
      if($rejected_data == 'n')
      {
        $codata['rejected_list'] = false;
      }
      else
      {
        $codata['rejected_list'] = $rejected_data;
      }
    }

    catch (Exception $e)
    {
      log_message('ERROR#LM_DATA_FETCH', 'Lm application data fetch...####'. $e);
    }
    finally
    {
      $endTime = microtime(true);
      $timeDiff = $endTime - $startTime;

      if($timeDiff > (float)2){
        log_message('EXECUTION_TIME', $this->router->fetch_class().'->'.$this->router->fetch_method().' # The execution time is : '.$timeDiff);
      }
    }

    //****getting tribe cat and under tribal belt data FROM backup */
    $getJsonBackup = $this->TeaGrantModel->getJsonDataFromBackup($case_no);

    //************check if SK is available*/
    $codata['sk_name']= $this->SettlementCommonModel->getSkName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);

    if($codata['sk_name'] == 'n')
    {
      //************if SK is not available then load CO */
      $codata['sk_availability'] = 'n';

      $codata['co_name'] = $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
    }
    else
    {
      $codata['sk_availability'] = 'y';
    }

    $codata['co_name']= $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);

    $codata['co_name_reject']= $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);

    $codata['dagFlagCheckChitha'] = $this->SettlementCommonModel->getChithaFlaggedRemarks($dags, $codata['rejected_list']);


    $codata['mouza_name'] = $this->utilityclass->getMouzaName($basic['dist_code'], 
                              $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code']);

    $codata['vill_name'] = $this->utilityclass->getVillageName($basic['dist_code'], 
                              $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], 
                                $basic['lot_no'], $basic['vill_townprt_code']);


    // $params = [
    //   'case_no'          => $case_no,
    //   'service_code'     => TEA_SERVICE_CODE,
    //   'remarks'          => 'Tea Grant',
    //   'accessed_entity'  => 'Aadhaar Name, Photo, Status',
    // ];
    // $this->load->model('EkycLogModel');
    // $log = $this->EkycLogModel->insertEkycAccessedBy($this->db, $params);

    // $codata['appl_deed_no'] = $appl_deed_no;

    // initial tea grant view through API
    if($_SERVER['REQUEST_METHOD'] != 'POST'){
      $codata['_view'] = 'TeaGrant/CO/TeaGrantFirstLandingViewCo';
      $this->load->view('layouts/main',$codata);
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){ 



      //  row_array
      $basic   = $this->TeaGrantModel->getSettlementBasic($case_no);

      $d = $basic["dist_code"];
      $s = $basic["subdiv_code"];
      $c = $basic["cir_code"];
      $m = $basic["mouza_pargona_code"];
      $l = $basic["lot_no"];
      $v = $basic["vill_townprt_code"];
      $location = $d.'_'.$s.'_'.$c.'_'.$m.'_'.$l.'_'.$v;

      $redirect = base_url()."index.php/TeaGrantControllerCo/applicationTeaGrantRegistrationCo?app=".$this->utilityclass->encryptJwtCase($application_no);
      
      $sqlCheckExist = "SELECT count(*) as c from  settlement_basic where case_no='$case_no' and pending_officer !='CO' and status != 'ZC'"; 

      $dataFound      = $this->db->query($sqlCheckExist)->row();
      $co_remark      = $this->input->post('co_remark');
      $deed_no        = $this->input->post('deed_no');
      $deed_date      = $this->input->post('deed_date');
      $multi_dist_sro = (SEND_TO_MULTIPLE_SRO_DIST == 1 && !empty($this->input->post('multi_dist_sro'))) ? $this->input->post('multi_dist_sro'): null;

      $forwarded_to_lm  = 'LM';
      $forwarded_to_sro = 'SRO'; 

      if((empty($co_remark)))
      {
        $this->session->set_flashdata('message', "#WARNING2932: CO remark is mandatory !!!");        
        redirect($redirect);
      }

      if((empty($deed_no)) || $deed_no == 'NA' || $deed_no == 'N.A' || $deed_no == 'N.A.' || $deed_no == 'N A')
      {
        $this->session->set_flashdata('message', "#WARNING2939: Please enter valid Deed No !!!");
        redirect($redirect);
      }

      if((empty($deed_date)))
      {
        $this->session->set_flashdata('message', "#WARNING2832: Please enter Deed Date !!!");
        redirect($redirect);
      }

      // get CO name
      $co_name = $this->utilityclass->getSelectedCOName($d, $s, $c, $this->session->userdata('user_code'));

      // to forward in SRO

      // get max serial no
      $slno = $this->db->query("SELECT max(slno)+1 AS c FROM sro_push_history")->row()->c;
      // echo $this->db->last_query(); die;

      if ($slno == null) {
        $slno = 1;
      }

      $this->db->trans_begin();

      // insert into sro_push_history
      $insSroPush = [
        'slno'               => $slno,
        'dist_code'          => $d,
        'subdiv_code'        => $s,
        'cir_code'           => $c,
        'mouza_pargona_code' => $m,
        'lot_no'             => $l,
        'vill_townprt_code'  => $v,
        'case_no'            => $case_no,
        'deed_no'            => $deed_no,
        'status'             => 'P', // P: pending, A: approved
        'action'             => 'F',
        'remark'             => 'Forwarded to '.$forwarded_to_sro,
        'user_code'          => $this->session->userdata('user_code'),
        'date_of_creation'   => date('Y-m-d H:i:s'),
        'client_ip'          => $this->utilityclass->get_client_ip(),
        'multi_dist_codes'   => json_encode($multi_dist_sro),
      ];
      $insertData = $this->db->insert('sro_push_history', $insSroPush);
      // echo $this->db->last_query(); die;
      if($insertData != 1)
      {
        log_message("error", "ERROR3224 : Insertion failed ".$this->db->last_query());
        $this->db->trans_rollback();
        $this->session->set_flashdata('message', "#WARNING3224: Failed in forwarding to LRA & SRO for case no $case_no !!!");
        redirect($redirect);
      }

      // to forward to LRA
      $location = $this->db->query('SELECT * from settlement_basic where case_no = ?', array($case_no));
      if($location->num_rows() <= 0){
        log_message("error", "ERROR3041 :No detail found in settlement_basic for case no $case_no !!!");
        $this->db->trans_rollback();
        $this->session->set_flashdata('message', "#ERROR3041: Failed in forwarding to LRA & SRO for case no $case_no !!!");
        redirect($redirect);
      }

      $basic_row = $location->row();

      $lm_code_sql = $this->db->query('SELECT * from loginuser_table where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and dis_enb_option = ?', array($basic_row->dist_code, $basic_row->subdiv_code, $basic_row->cir_code, $basic_row->mouza_pargona_code, $basic_row->lot_no, 'E'));

      $lm_code = $lm_code_sql->row();
      
      $basicData = [
        'status'          => 'Z',
        'lm_code'         => $lm_code->user_code,
        'submission_date' => date('Y-m-d H:i:s'),
        'from_office'     => 'CO',
        'pending_officer' => $forwarded_to_lm,
        'pending_office'  => 'CO',
        'co_code'         => $this->session->userdata('user_code'),
        'date_update'     => date('Y-m-d H:i:s'),
        'deed_no'         => $this->input->post('deed_no'),
        'deed_date'       => $this->input->post('deed_date'),
      ];

      $this->db->where('case_no', $case_no);
      $this->db->update('settlement_basic', $basicData);
      if($this->db->affected_rows() != 1)
      { 
        log_message("error", "ERROR3069 : updation failed in settlement_basic for case no $case_no !!!".$this->db->last_query());
        $this->db->trans_rollback();
        $this->session->set_flashdata('message', "#ERROR3069: Failed in forwarding to LRA & SRO for case no $case_no !!!");
        redirect($redirect);
      }

      //////proceeding start//////
      $proceeding_id = $this->db->query("SELECT max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

      if ($proceeding_id == null) {
        $proceeding_id = 1;
      }

      $msg = '';
      $msg = ($this->input->post('recommend') == 'YES') ? 'Can be recommended' : 'Can not recommended';

      $note_on_order = $co_remark."<br>".$msg;

      // echo $note_on_order; die;

      $insPetProceed = [
        'case_no'              => $case_no,
        'proceeding_id'        => $proceeding_id,
        'date_of_hearing'      => date('Y-m-d H:i:s'),
        'next_date_of_hearing' => date('Y-m-d H:i:s'),
        'note_on_order'        => $note_on_order,
        'status'               => 'Z',
        'user_code'            => $this->session->userdata('user_code'),
        'date_entry'           => date('Y-m-d H:i:s'),
        'operation'            => 'E',
        'ip'                   => $this->utilityclass->get_client_ip(),
        'office_from'          => 'CO',
        'office_to'            => 'CO',
        'task'                 => 'Forwarded to LRA & SRO',
        'note_type'            => 'Forwarded to LRA & SRO',
      ];
      $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

      if ($insertProceeding != 1) {
        log_message("error", "ERROR3069 : updation failed in settlement_basic for case no $case_no !!!".$this->db->last_query());
        $this->db->trans_rollback();
        $this->session->set_flashdata('message', "#ERROR3069: Failed in forwarding to LRA & SRO for case no $case_no !!!");
        redirect($redirect);
      }

      if ($this->db->trans_status() == false) 
      {
        log_message("error", "ERROR3095 : Transaction failedfor case no $case_no !!!");
        $this->db->trans_rollback();
        $this->session->set_flashdata('message', "#ERROR3095: Failed in forwarding to LRA & SRO for case no $case_no !!!");
        redirect($redirect);
      } 
      else 
      {
        // call API to forward to SRO

        // "search_value" : "666/4567",
        // "dist_code"    : "07",
        // "co_name"      : "Uttar Ghy CO",
        // "location"     : "07_01_01_01_02_10003",
        // "case_no"      : "KAM/UTT/2023-24/202400021/FMUT",
        // "slno"         : "8"

        $loc = $d.'_'.$s.'_'.$c.'_'.$m.'_'.$l.'_'.$v;

        if(($multi_dist_sro != '' || $multi_dist_sro != null || !empty($multi_dist_sro)) && SEND_TO_MULTIPLE_SRO_DIST == 1)
        {
          $results    = [];
          $allSuccess = true; // Assume all are successful initially

          foreach($multi_dist_sro as $d) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL            => NGDRS_SRO_PUSH_PROD,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING       => '',
              CURLOPT_MAXREDIRS      => 10,
              CURLOPT_TIMEOUT        => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST  => 'POST',
              CURLOPT_POSTFIELDS     => json_encode([
                "search_value" => $deed_no,
                "dist_code"    => $d,
                "co_name"      => $co_name->username,
                "location"     => $loc,
                "case_no"      => $case_no,
                "slno"         => $slno,
              ]),
              CURLOPT_SSL_VERIFYHOST => false,
              CURLOPT_SSL_VERIFYPEER => false,
              CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
              ),
            ));

            $response    = curl_exec($curl);
            curl_close($curl);
            $decoded     = json_decode($response);            
            $results[$d] = $decoded ; // Store all responses

            // If any fails, mark overall failure
            if (!isset($decoded->status) || $decoded->status !== 'success') {
              $allSuccess = false;
            }
          }

          // Final check: If even one failed
          if(!$allSuccess || empty($results)) {
            log_message("error", "WARNING3073 : Forward to SRO failed for case no $case_no !!! " . json_encode($results));
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#WARNING3073: Failed in forwarding to SRO for case no $case_no !!!");
            redirect($redirect);
          }
        }
        else
        {
          $curl = curl_init();
          curl_setopt_array($curl, array(
            CURLOPT_URL            => NGDRS_SRO_PUSH_PROD,
            //CURLOPT_URL            => NGDRS_SRO_PUSH_STAGE,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => json_encode([
              "search_value"  => $deed_no,
              "dist_code"     => $d,
              "co_name"       => $co_name->username,
              "location"      => $loc,
              "case_no"       => $case_no,
              "slno"          => $slno,
            ]),
            CURLOPT_SSL_VERIFYHOST => false, // Disable SSL host verification
            CURLOPT_SSL_VERIFYPEER => false,  // Disable SSL certificate verification
            CURLOPT_HTTPHEADER => array(
              'Content-Type: application/json'
            ),
          ));

          $response = curl_exec($curl);
          curl_close($curl);
          $results = json_decode($response);

          if($results->status != 'success' || empty($results))
          {
            log_message("error", "WARNING3255 : API response failed for case no $case_no !!!".json_encode($results));
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#WARNING3255: Failed in forwarding to SRO for case no $case_no !!!");
            redirect($redirect);
          }
        }
         
      
        //////////////POST To basundhara/////////////////////
        $rmk         = 'Forwarded to LRA';
        $status      = 'M';
        $task        = 'CO';
        $pen         = $forwarded_to_lm;
        $case        = $case_no;
        $rtps_status = $this->SettlementApiModel->postApiBasundharaMb3($application_no, $case, $rmk, $status, $task, $pen);

        // $this->db->trans_rollback();
        // var_dump($rtps_status); die;

        $rtps_status = json_decode($rtps_status);
        
        if (trim($rtps_status) != "y") 
        {
          $this->db->trans_rollback();
          $this->session->set_flashdata('message', "#ERROR3120: Failed in forwarding to LRA for case no $case_no !!!");
          redirect($redirect);
        } 
        else
        {
          // $this->db->trans_rollback();
          $this->db->trans_commit();
          $this->session->set_flashdata('message', "Application Successfully Forwarded to LRA and SRO for Case No: $case_no");
          redirect(base_url() . "index.php/TeaGrantControllerCo/initialLanding?service=43&s=i");
        }        
      }
    }
  }


  public function coReSubmitLmCases()
  {
    $service_code         = $this->input->get('service');
    $status               = $this->input->get('s');

    $dist_code            = $this->session->userdata('dist_code');
    $subdiv_code          = $this->session->userdata('subdiv_code');
    $cir_code             = $this->session->userdata('cir_code');
    $chitha_data['cases'] = $this->db->query("SELECT * FROM settlement_basic WHERE dist_code=? 
                              AND subdiv_code=? AND cir_code=? AND status=? AND lm_code is not null AND service_code=?", 
                                array($dist_code, $subdiv_code, $cir_code, MB_RE_REPORT, TEA_SERVICE_CODE))->result();
    
    // echo $this->db->last_query(); die;

    $chitha_data['select_data']  = $this->SettlementCommonModel->locationSelect($service_code, $status);
    $chitha_data['service_code'] = $service_code;
    $chitha_data['_view']        = 'TeaGrant/CO/TeaGrantCOResubmitLMCasesView';

    $this->load->view('layouts/main', $chitha_data);
  }


  public function sroReport()
  {
    $service_code         = $this->input->get('service');
    $status               = $this->input->get('s');

    $dist_code            = $this->session->userdata('dist_code');
    $subdiv_code          = $this->session->userdata('subdiv_code');
    $cir_code             = $this->session->userdata('cir_code');

    $chitha_data['cases'] = $this->db->query("SELECT * FROM settlement_basic WHERE dist_code=? 
                              AND subdiv_code=? AND cir_code=? AND status=? AND lm_code is not null", 
                                array($dist_code, $subdiv_code, $cir_code, MB_RE_REPORT))->result();

    // $counts['report_from_sro'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='W' and from_office='CO' and pending_officer='SRO' and service_code='$service_code'  and date_entry >= '$define_date' $lot_bifurcate")->row()->c;    


    $chitha_data['select_data']  = $this->SettlementCommonModel->locationSelect($service_code, $status);
    $chitha_data['service_code'] = $service_code;
    $chitha_data['_view']        = 'TeaGrant/CO/TeaGrantCOResubmitLMCasesView';

    $this->load->view('layouts/main', $chitha_data);
  }


  public function manuallyForwardToSro($cno)
  {
    $case_no  = $this->utilityclass->decryptJwtCase($cno);
    $basic    = $this->TeaGrantModel->getSettlementBasic($case_no);
    $d        = $basic['dist_code'];
    $s        = $basic['subdiv_code'];
    $c        = $basic['cir_code'];
    $m        = $basic['mouza_pargona_code'];
    $l        = $basic['lot_no'];
    $v        = $basic['vill_townprt_code'];
    $location = $d.'_'.$s.'_'.$c.'_'.$m.'_'.$l.'_'.$v;
    $deed_no  = $basic['deed_no'];

    $redirect = base_url()."index.php/TeaGrantControllerCo/applicationTeaGrantRegistrationCo?app=".$this->utilityclass->encryptJwtCase($applid);

    // get max serial no
    $slno = $this->db->query("SELECT max(slno)+1 AS c FROM sro_push_history")->row()->c;
    // echo $this->db->last_query(); die;

    if ($slno == null) {
      $slno = 1;
    }

    $this->db->trans_begin();

    // insert into sro_push_history
    $insSroPush = [
      'slno'               => $slno,
      'dist_code'          => $d,
      'subdiv_code'        => $s,
      'cir_code'           => $c,
      'mouza_pargona_code' => $m,
      'lot_no'             => $l,
      'vill_townprt_code'  => $v,
      'case_no'            => $case_no,
      'deed_no'            => $deed_no,
      'status'             => 'P', // P: pending, A: approved
      'action'             => 'F', // F: pending, Y: approved
      'remark'             => 'Forwarded to SRO',
      'user_code'          => $this->session->userdata('user_code'),
      'date_of_creation'   => date('Y-m-d H:i:s'),
      'client_ip'          => $this->utilityclass->get_client_ip(),
    ];
    $insertData = $this->db->insert('sro_push_history', $insSroPush);
    if($insertData != 1)
    {
      log_message("error", "ERROR3259 : Insertion failed ".$this->db->last_query());
      $this->db->trans_rollback();
      $this->session->set_flashdata('message', "#ERROR3259: Failed in forwarding to SRO for case no $case_no !!!");
      redirect($redirect);
    }

    // call API to forward to SRO
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL            => 'https://landhub.assam.gov.in/nocApi/dhar_ngdrs/co_query.php',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING       => '',
      CURLOPT_MAXREDIRS      => 10,
      CURLOPT_TIMEOUT        => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST  => 'POST',
      CURLOPT_POSTFIELDS     =>'{
        "search_value" : $deed_no,
        "dist_code"    : $d,
        "co_name"      : $co_name,
        "location"     : $location,
        "case_no"      : $case_no,
        "slno"         : $slno
      }',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
      ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    $results = json_decode($response);

    if($results->status != 'success' || empty($results))
    {
      log_message("error", "WARNING3302 : API response failed for case no $case_no !!!".json_encode($results));
      $this->db->trans_rollback();
      $this->session->set_flashdata('message', "#WARNING3302: Failed in forwarding to SRO for case no $case_no !!!");
      redirect($redirect);
    }

    $this->db->trans_commit();
    $this->session->set_flashdata('message', "Application has successfully Forwarded to SRO for Case No: $case_no");
    redirect(base_url() . "index.php/TeaGrantControllerCo/initialLanding?service=43&s=i");
  }

  public function reportFromSro()
  {
    $case_no = $this->input->get('case');
    $update = [
      'sro_code'       => 'SRO1',
      'status'         => 'A',
      'action'         => 'Y',
      'date_of_update' => date('Y-m-d H:i:s'),
      'is_deed_valid'  => 'Y',
      'remark'         => 'said deed has been found in index register and volume book',
    ];
    $this->db->where('case_no', $case_no);
    $this->db->update('sro_push_history', $update);

    if($this->db->affected_rows() != 1)
    {
      $this->session->set_flashdata('message', "#WARNING3302: Updation failed for case no $case_no !!!");
      redirect(base_url() . "index.php/TeaGrantControllerCo/FirstProceeding?service=43&s=W");
    }

    $this->session->set_flashdata('message', "SRO has successfully submitted the report for Case No: $case_no");
    redirect(base_url() . "index.php/TeaGrantControllerCo/FirstProceeding?service=43&s=W");
  }

  public function chithaUpdatePending()
  {
    $dist_code            = $this->session->userdata('dist_code');
    $subdiv_code          = $this->session->userdata('subdiv_code');
    $cir_code             = $this->session->userdata('cir_code');

    $chitha_data['cases'] = $this->db->query(" SELECT COUNT(*) AS c FROM settlement_basic sb JOIN settlement_premium sp ON sp.case_no = sb.case_no WHERE sb.dist_code = ? AND sb.subdiv_code = ? AND sb.cir_code = ? AND sb.status = ? AND sb.pending_officer = ? AND sb.service_code = ? AND sb.date_entry >= ? AND sb.notice_generated_yn = ? AND sb.pay_notice_gen_yn = ? AND sb.general_notice_dc = ? AND sb.dc_proceeding = ? AND sb.chitha_processing_details = ? AND sp.is_final = ? AND sp.grn_no IS NOT NULL AND sb.order_passed IS NULL AND sb.co_chitha_corrected_yn IS NULL", [ $dist_code, $subdiv_code, $cir_code, MB_PAYMENT_NOTICE, 'CO', TEA_SERVICE_CODE, define_date, 'y', 'Y', 'y', 1, 2, 1 ] )->row()->c;

    $chitha_data['service_code'] = TEA_SERVICE_CODE;
    $chitha_data['_view']        = 'TeaGrant/CO/TeaGrantCoChithaUpdatePendingList';
    $this->load->view('layouts/main', $chitha_data);
  }

  public function paginationChithaUpdatePending()
  {
    // dd('sdfghjk');
    if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
      $lot_string = $this->caseListUnderMappingLot();
    }

    $s_code             = TEA_SERVICE_CODE;
    $search_term        = $this->input->post('search_term');
    $remark_cat         = $this->input->post('remark_cat');
    $reverted           = $this->input->post('reverted');
    $user_code          = $this->session->userdata('user_code');
    $l_mis              = $this->input->post('l_mis');
    $mouza_pargona_code = $this->input->post('mouza_pargona_code');
    $lot_no             = $this->input->post('lot_no');

    $draw   = intval($this->input->post('draw'));
    $start  = intval($this->input->post('start'));
    $length = intval($this->input->post('length'));
    $order  = $this->input->post('order');
    $p_type = $this->input->post('p_type');

    $col    = 0;
    $dir    = "";
    $search = $this->input->post('search');
    $search = $search['value'];

    $searchByCol_0 = $this->input->post('columns')[1]['search']['value'];
    $searchByCol_1 = $this->input->post('columns')[2]['search']['value'];
    $searchByCol_3 = $this->input->post('columns')[4]['search']['value'];

    $is_cat = $this->input->post('is_category');

    if (!empty($order)) {
      foreach ($order as $o) {
        $col = $o['column'];
        $dir = $o['dir'];
      }
    }

    if ($dir != "asc" && $dir != 'desc') {
      $dir = 'asc';
    }

    if (!isset($valid_columns[$col])) {
      $order = null;
    } else {
      $order = $valid_columns[$col];
    }

    if ($order != null) {
      $this->db->order_by($order, $dir);
    }

    if (!empty($searchByCol_0)) {
      $this->db->like('a.case_no', strtoupper($searchByCol_0));
    }

    if (!empty($searchByCol_1)) {
      $this->db->like('a.applid', strtoupper($searchByCol_1));
    }

    if (!empty($searchByCol_3)) {
      $this->db->like('TO_CHAR(a.date_entry,\'yyyy-mm-dd\')', $searchByCol_3);
    }

    $this->db->limit($length, $start);
    $this->db->where('a.service_code', $s_code);

    if (!empty($remark_cat)) { //settlement_ap_lmnote, lm_note
      $this->db->where('b.lm_note', $remark_cat);
    }

    if (!empty($mouza_pargona_code)) {
      $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
    }

    if (!empty($mouza_pargona_code) && !empty($lot_no)) {
      $this->db->where('a.lot_no', $lot_no);
    }

    if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
      $this->db->where('a.vill_townprt_code', $is_cat);
    }

    $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
    $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
    $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

    if ($this->session->userdata('user_desig_code') == 'CO') {          
      if (LOT_BIFURCATE == 1 && empty($mouza_pargona_code) && empty($lot_no)) {
        if (isset($lot_string) && $lot_string != null) {
          $this->db->where("CONCAT(a.mouza_pargona_code, '_', a.lot_no) in ($lot_string)");
        }
      }
    }

    if (!empty($p_type)) {
      if ($p_type == 'f') {
        $this->db->where('sp.due_amount <= sp.paid_amount');
      }

      if ($p_type == 'p') {
        $this->db->where('sp.due_amount > sp.paid_amount');
      }
    }

    $this->db->where('chitha_processing_details', 2);
    $this->db->where('status', 'N');
    $this->db->where('a.notice_generated_yn', 'y');
    $this->db->where('a.pay_notice_gen_yn', 'Y');
    $this->db->where('a.general_notice_dc', 'y');
    $this->db->where('a.dc_proceeding', '1');

    $this->db->join('settlement_premium sp', 'sp.case_no = a.case_no');
    $this->db->where('sp.is_final', 1);
    $this->db->where('sp.grn_no is not null');
    $this->db->where('a.pending_officer', 'CO');
    $this->db->where('a.order_passed is null', null, false);
    $this->db->where('a.co_chitha_corrected_yn is null', null, false);
    $this->db->where("DATE_PART('day', now()::timestamp- a.ppp_issue_date::timestamp)>15");
    $this->db->from('settlement_basic a');
    $this->db->select('distinct(a.case_no), a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry');

    $landcc = '';

    if (!empty($l_mis)) {
      if ($l_mis == 'l_miss') {
        $this->db->where('EXISTS (SELECT 1 FROM settlement_dag_details sd WHERE sd.case_no = a.case_no AND ((sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = \'\' OR sd.new_land_class_agri = \'\')))', null, false);

        $landcc = 'Landclass missing';
      }
      if ($l_mis == 'l_not_mis') {
        $this->db->where('NOT EXISTS (SELECT 1 FROM settlement_dag_details sd WHERE sd.case_no = a.case_no AND ((sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = \'\' OR sd.new_land_class_agri = \'\')))', null, false);

        $landcc = 'Landclass not missing';
      }
    }

    $landcc = '';

    if (!empty($l_mis)) {
        if ($l_mis == 'l_miss') {
            // $this->db->join('settlement_dag_details sd', 'sd.case_no = a.case_no');
            $this->db->where('EXISTS (SELECT 1 FROM settlement_dag_details sd WHERE sd.case_no = a.case_no AND ((sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = \'\' OR sd.new_land_class_agri = \'\')))', null, false);

            $landcc = 'Landclass missing';
        }
        if ($l_mis == 'l_not_mis') {
            $this->db->where('NOT EXISTS (SELECT 1 FROM settlement_dag_details sd WHERE sd.case_no = a.case_no AND ((sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = \'\' OR sd.new_land_class_agri = \'\')))', null, false);

            $landcc = 'Landclass not missing';

        }
    }


    // echo $this->db->last_query();

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
      foreach ($query->result() as $rows) {

        $tea_grant_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>';

        //*****getting the payment made type */
        $getPType = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ?', array($rows->case_no, 1))->row();

        if ($getPType->paid_amount < $getPType->due_amount) {
          $pTypeText = 'Partial Payment';
        } else if ($getPType->paid_amount >= $getPType->due_amount) {
          $pTypeText = 'Full Payment';
        } else {
          $pTypeText = '';
        }

        $json[] = array(
          $rows->case_no,
          '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
          '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

          $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

          $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

          $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

          date("Y-m-d", strtotime($rows->date_entry)),

          $pTypeText,
          $landcc,
          $tea_grant_link
        );

      }

      $this->db->where('a.service_code', $s_code);
      $this->db->where('a.pending_officer', MB_CIRCLE_OFFICER);
      $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
      $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
      $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

      if ($this->session->userdata('user_desig_code') == 'CO') {
        if (LOT_BIFURCATE == 1 && empty($mouza_pargona_code) && empty($lot_no)) {
          if (isset($lot_string) && $lot_string != null) {
            $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
          }
        }
      }

      if (!empty($mouza_pargona_code)) {
        $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
      }

      if (!empty($mouza_pargona_code) && !empty($lot_no)) {
        $this->db->where('a.lot_no', $lot_no);
      }

      if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
        $this->db->where('a.vill_townprt_code', $is_cat);
      }

      $this->db->select('distinct(a.case_no), a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry');

      $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
      $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
      $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

      $this->db->where('chitha_processing_details', 2);

      $this->db->where('status', 'N');
      $this->db->where('a.notice_generated_yn', 'y');
      $this->db->where('a.pay_notice_gen_yn', 'Y');
      $this->db->where('a.general_notice_dc', 'y');
      $this->db->where('a.dc_proceeding', '1');

      $this->db->join('settlement_premium sp', 'sp.case_no = a.case_no');
      $this->db->where('sp.is_final', 1);
      $this->db->where('sp.grn_no is not null');

      $this->db->where('a.pending_officer', 'CO');

      $this->db->where('a.order_passed is null', null, false);
      $this->db->where('a.co_chitha_corrected_yn is null', null, false);
      $this->db->where("DATE_PART('day', now()::timestamp- a.ppp_issue_date::timestamp)>15");
        
      if (!empty($l_mis)) {
        if ($l_mis == 'l_miss') {
          $this->db->where('EXISTS (SELECT 1 FROM settlement_dag_details sd WHERE sd.case_no = a.case_no AND ((sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = \'\' OR sd.new_land_class_agri = \'\')))', null, false);
        }

        if ($l_mis == 'l_not_mis') {
          $this->db->where('NOT EXISTS (SELECT 1 FROM settlement_dag_details sd WHERE sd.case_no = a.case_no AND ((sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = \'\' OR sd.new_land_class_agri = \'\')))', null, false);
        }
      }

      if (!empty($p_type)) {
        if ($p_type == 'f') {
          $this->db->where('sp.due_amount <= sp.paid_amount');
        }

        if ($p_type == 'p') {
          $this->db->where('sp.due_amount > sp.paid_amount');
        }
      }

      $this->db->from('settlement_basic a');
      $qu = $this->db->get();
      $total_records = $qu->num_rows();

      $response = array(
        'draw'            => $draw,
        'recordsTotal'    => $total_records,
        'recordsFiltered' => $total_records,
        'data'            => $json,
      );
      echo json_encode($response);
    } 
    else {
      $response                         = array();
      $response['sEcho']                = 0;
      $response['iTotalRecords']        = 0;
      $response['iTotalDisplayRecords'] = 0;
      $response['aaData']               = [];
      echo json_encode($response);
    }
  }


  public function pushToSroManually()
  {

    // get details from application
    $fromPushHistory = $this->db->query("SELECT * FROM sro_push_history WHERE case_no LIKE '%TGPP' 
                          AND case_no !='MET/GUW/2024-25/55287/TGPP' LIMIT 1");

    if($fromPushHistory->num_rows() == 0)
    {
      echo "No data available for push to SRO";
      return;
    }

    $response = $fromPushHistory->result();

    foreach($response as $r)
    {
      $loc = $r->dist_code.'_'.$r->subdiv_code.'_'.$r->cir_code.'_'.$r->mouza_pargona_code.'_'.$r->lot_no.'_'.$r->vill_townprt_code;

      $deed_no = $r->deed_no; 
      $d = $r->dist_code;
      $case_no = $r->case_no;
      $slno = $r->slno;

      // get CO name
      $co_name = $this->utilityclass->getSelectedCOName($r->dist_code, $r->subdiv_code, $r->cir_code, $r->user_code)->username;
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL            => NGDRS_SRO_PUSH_PROD,
        // CURLOPT_URL            => NGDRS_SRO_PUSH_STAGE,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING       => '',
        CURLOPT_MAXREDIRS      => 10,
        CURLOPT_TIMEOUT        => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST  => 'POST',
        CURLOPT_POSTFIELDS     =>'{            
          "search_value"  : $deed_no,
          "dist_code"     : $d,
          "co_name"       : $co_name,
          "location"      : $loc,
          "case_no"       : $case_no,
          "slno"          : $slno 
        }',
        CURLOPT_HTTPHEADER => array(
          'Content-Type: application/json'
        ),
      ));

      $response = curl_exec($curl);
      curl_close($curl);
      $results = json_decode($response);

      if($results->status != 'success' || empty($results))
      {
        log_message("error", "WARNING3255 : API response failed for case no $case_no !!!".json_encode($results));
        echo " REsponse failed";
        continue;
      }

      log_message("error", "WARNING3255 : Successfully push to SRO for case no $case_no !!!");
      echo "Success for case no $case_no";
    }
  }

  public function revertedCasesFromDc()
  {
    $service_code         = $this->input->get('service');
    $status               = $this->input->get('s');

    $dist_code            = $this->session->userdata('dist_code');
    $subdiv_code          = $this->session->userdata('subdiv_code');
    $cir_code             = $this->session->userdata('cir_code');
    $chitha_data['cases'] = $this->db->query("SELECT * FROM settlement_basic WHERE dist_code=? 
                              AND subdiv_code=? AND cir_code=? AND status=? AND pending_office=? AND from_office IN (?, ?, ?) AND service_code=?", 
                                array($dist_code, $subdiv_code, $cir_code, MB_REVERT, MB_CIRCLE_OFFICER, 'ADC', 'DC', 'DPT', $service_code))->result();

    $chitha_data['select_data']  = $this->SettlementCommonModel->locationSelect($service_code, $status);
    $chitha_data['service_code'] = $service_code;
    $chitha_data['_view']        = 'TeaGrant/CO/TeaGrantDcRevertCases';

    $this->load->view('layouts/main', $chitha_data);
  }

  public function reforwardToSro()
  {
    $json    = array();
    $case_no = $this->input->post('case_no');
    $deed_no = $this->input->post('deed_no');

    $redirect = base_url()."index.php/TeaGrantControllerCo/FirstProceeding?service=43&s=W";  

    // get detail from settlement basic
    $fromBasic = $this->db->query("SELECT * FROM settlement_basic WHERE case_no=?", array($case_no))->row();

    $dist_code          = $fromBasic->dist_code;
    $subdiv_code        = $fromBasic->subdiv_code;
    $cir_code           = $fromBasic->cir_code;
    $mouza_pargona_code = $fromBasic->mouza_pargona_code;
    $lot_no             = $fromBasic->lot_no;
    $vill_townprt_code  = $fromBasic->vill_townprt_code;

    // get CO name
    $co_name = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $this->session->userdata('user_code')); 

    $slno = $this->db->query("SELECT max(slno)+1 AS c FROM sro_push_history")->row()->c;
    if ($slno == null) { $slno = 1; }

    // insert into sro_push_history
    $insSroPush = [
      'slno'               => $slno,
      'dist_code'          => $dist_code,
      'subdiv_code'        => $subdiv_code,
      'cir_code'           => $cir_code,
      'mouza_pargona_code' => $mouza_pargona_code,
      'lot_no'             => $lot_no,
      'vill_townprt_code'  => $vill_townprt_code,
      'case_no'            => $case_no,
      'deed_no'            => $deed_no,
      'status'             => 'P', // P: pending, A: approved
      'action'             => 'F',
      'remark'             => 'Forwarded to SRO',
      'user_code'          => $this->session->userdata('user_code'),
      'date_of_creation'   => date('Y-m-d H:i:s'),
      'client_ip'          => $this->utilityclass->get_client_ip(),
    ];
    $insertData = $this->db->insert('sro_push_history', $insSroPush);
    if($insertData != 1)
    {
      log_message("error", "ERROR3631 : Insertion failed ".$this->db->last_query());
      $json = [
        'responseType' => 3,
        'message'      => "#WARNING3631: Failed in forwarding to SRO for case no $case_no !!!",
        'redirect'     => $redirect,
      ];
      echo json_encode($json);
      return;
    }

    // call API to forward to SRO

    $dist_code          = $fromBasic->dist_code;
    $subdiv_code        = $fromBasic->subdiv_code;
    $cir_code           = $fromBasic->cir_code;
    $mouza_pargona_code = $fromBasic->mouza_pargona_code;
    $lot_no             = $fromBasic->lot_no;
    $vill_townprt_code  = $fromBasic->vill_townprt_code;

    $loc = $dist_code.'_'.$subdiv_code.'_'.$cir_code.'_'.$mouza_pargona_code.'_'.$lot_no.'_'.$vill_townprt_code;

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL            => NGDRS_SRO_PUSH_PROD,
      //CURLOPT_URL            => NGDRS_SRO_PUSH_STAGE,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING       => '',
      CURLOPT_MAXREDIRS      => 10,
      CURLOPT_TIMEOUT        => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST  => 'POST',
      CURLOPT_POSTFIELDS     => json_encode([
        "search_value" => $deed_no,
        "dist_code"    => $dist_code,
        "co_name"      => $co_name->username,
        "location"     => $loc,
        "case_no"      => $case_no,
        "slno"         => $slno
      ]),
      CURLOPT_SSL_VERIFYHOST => false, // Disable SSL host verification
      CURLOPT_SSL_VERIFYPEER => false,  // Disable SSL certificate verification
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
      ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    $results = json_decode($response);

    if($results->status != 'success' || empty($results))
    {
      log_message("error", "WARNING3692 : API response failed for case no $case_no !!!".json_encode($results));
      $json = [
        'responseType' => 3,
        'message'      => "#WARNING3692: Failed in forwarding to SRO for case no $case_no !!!",
        'redirect'     => $redirect,
      ];
      echo json_encode($json);
      return;
    }
    else
    {
      $json = [
        'responseType' => 2,
        'message'      => "#SUCCESS3710: Case $case_no has successfully forwarded to SRO for verification of deed detail : $deed_no",
        'redirect'     => $redirect,
      ];
      echo json_encode($json);
      return;
    }
  }

  protected function checkSroJuridication($case_no)
  {
    $basic    = $this->TeaGrantModel->getSettlementBasic($case_no);
    $d        = $basic['dist_code'];
    $s        = $basic['subdiv_code'];
    $c        = $basic['cir_code'];
    $m        = $basic['mouza_pargona_code'];
    $l        = $basic['lot_no'];
    $v        = $basic['vill_townprt_code'];
    $location = $d.'_'.$s.'_'.$c.'_'.$m.'_'.$l.'_'.$v;
    $deed_no  = $basic['deed_no'];

    // get CO name
    $co_name = $this->utilityclass->getSelectedCOName($d, $s, $c, $this->session->userdata('user_code'))->username;

    // get last detail from SRO push history
    $sro = $this->db->query("SELECT * FROM sro_push_history WHERE case_no=? ORDER BY slno DESC LIMIT 1", array($case_no));

    if($sro->num_rows() == 0)
    {
      $btn        = 0;
      $sroMessage = '<span class="badge text-bg-warning">This case was not forwarded to SRO for deed_verification. <a href="'.base_url().'index.php/TeaGrantControllerCo/manuallyForwardToSro/'.$this->utilityclass->encryptJwtCase($case_no).'">Click here to Forward</a></span>';
    }
    else
    {
      $sro  = $sro->row();
      $slno = $sro->slno;

      if($sro->action == 'F')
      {        
        // call API to forward to SRO
        $curl = curl_init();
        $postFields = http_build_query([
          'search_value' => $deed_no,
          'dist_code'    => $d,
          'co_name'      => $co_name,
          'location'     => $location,
          'case_no'      => $case_no,
          'slno'         => $slno
        ]);

        curl_setopt_array($curl, array(
          CURLOPT_URL            => 'https://landhub.assam.gov.in/nocApi/dhar_ngdrs/co_query_status.php',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING       => '',
          CURLOPT_MAXREDIRS      => 10,
          CURLOPT_TIMEOUT        => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST  => 'POST',
          CURLOPT_POSTFIELDS     => $postFields,
          CURLOPT_HTTPHEADER     => array(
            'Content-Type: application/x-www-form-urlencoded',
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $results = json_decode($response);

        // log_message("error", "checkSroJuridication====1".json_encode($results));
        // log_message("error", "checkSroJuridication====2".json_encode($results->status));

        $remark = 'The said deed details remain unverified by the SRO, as the matter doesn`t fall under their jurisdiction and authority to act upon !!!';

        // y - all SRO says NO
        if($results->status == 'y') // if SRO says no under juridiction question
        {
          // update sro_push_history table
          $update = $this->db->query("UPDATE sro_push_history SET status=?, action=?, remark=?, 
                      date_of_update=? WHERE case_no=? AND slno=?", 
                        array('N', 'N', $remark, date('Y-m-d H:i:s'), $case_no, $slno));
          if($this->db->affected_rows() != 1)
          {
            log_message("error", "#ERR3781: Updation failed in sro_push_history table for case no $case_no: ".$this->db->last_query());
          }
        } 
      }

    }
  }

  public function reforwardToSroFromList()
  {
    $json       = array();
    $_POST      = json_decode(file_get_contents("php://input"), true);
    $case_no    = $this->input->post('re_case_no');
    $deed_no    = $this->input->post('re_deed_no');
    $deed_date  = date('Y-m-d', strtotime($this->input->post('re_deed_date')));
    $multi_dist = (SEND_TO_MULTIPLE_SRO_DIST == 1 && !empty($this->input->post('multi_dist'))) ? $this->input->post('multi_dist'): null;

    if(empty($deed_no))
    {
      echo json_encode([
        'responseType' => 1,
        'message'      => "#WARNING3863: Please enter valid Deed No !!!",
      ]);
      return false;
    }
    if(empty($deed_date))
    {
      echo json_encode([
        'responseType' => 1,
        'message'      => "#WARNING3869: Please enter valid Deed Date !!!",
      ]);
      return false;
    }

    // $redirect = base_url()."index.php/TeaGrantControllerCo/FirstProceeding?service=43&s=W";  

    // get detail from settlement basic
    $fromBasic = $this->db->query("SELECT * FROM settlement_basic WHERE case_no=?", array($case_no))->row();

    $dist_code          = $fromBasic->dist_code;
    $subdiv_code        = $fromBasic->subdiv_code;
    $cir_code           = $fromBasic->cir_code;
    $mouza_pargona_code = $fromBasic->mouza_pargona_code;
    $lot_no             = $fromBasic->lot_no;
    $vill_townprt_code  = $fromBasic->vill_townprt_code;

    // get CO name
    $co_name = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $this->session->userdata('user_code'));

    $this->db->trans_begin();

    // settlement basic
    $updateBasic = $this->db->query("UPDATE settlement_basic SET deed_no=?, deed_date=? WHERE case_no=?", 
                    array($deed_no, $deed_date, $case_no));
    if($this->db->affected_rows() != 1)
    {
      $this->db->trans_rollback();
      log_message("error", "#WARNING3896: Updation failed in settlement_basic: ".$this->db->last_query());
      echo json_encode([
        'responseType' => 1,
        'message'      => "#WARNING3896: Failed in forwarding to SRO for case no $case_no !!!",
      ]);
      return false;
    }

    // check if DA exist
    $check = $this->db->query("SELECT * FROM settlement_applicant WHERE case_no=? AND pdar_type=?", array($case_no, 'DA'));

    if($check->num_rows() > 0)
    {      
      // settlement applicant
      $fromApplicant = $this->db->query("UPDATE settlement_applicant SET appl_deed_no=?, appl_deed_date=? WHERE case_no=? 
                        AND pdar_type=?", array($deed_no, $deed_date, $case_no, 'DA'));
      if($this->db->affected_rows() != $check->num_rows())
      {
        $this->db->trans_rollback();
        log_message("error", "#WARNING3907: Updation failed in settlement_applicant: ".$this->db->last_query());
        echo json_encode([
          'responseType' => 1,
          'message'      => "#WARNING3907: Failed in forwarding to SRO for case no $case_no !!!",
        ]);
        return false;
      }
    }

    $slno = $this->db->query("SELECT max(slno)+1 AS c FROM sro_push_history")->row()->c;
    if ($slno == null) { $slno = 1; }

    // insert into sro_push_history
    $insSroPush = [
      'slno'               => $slno,
      'dist_code'          => $dist_code,
      'subdiv_code'        => $subdiv_code,
      'cir_code'           => $cir_code,
      'mouza_pargona_code' => $mouza_pargona_code,
      'lot_no'             => $lot_no,
      'vill_townprt_code'  => $vill_townprt_code,
      'case_no'            => $case_no,
      'deed_no'            => $deed_no,
      'status'             => 'P', // P: pending, A: approved
      'action'             => 'F',
      'remark'             => 'Forwarded to SRO',
      'user_code'          => $this->session->userdata('user_code'),
      'date_of_creation'   => date('Y-m-d H:i:s'),
      'client_ip'          => $this->utilityclass->get_client_ip(),
      'multi_dist_codes'   => json_encode($multi_dist),
    ];
    $insertData = $this->db->insert('sro_push_history', $insSroPush);
    if($insertData != 1)
    {
      $this->db->trans_rollback();
      log_message("error", "#WARNING3937: Insertion failed in sro_push_history: ".$this->db->last_query());
      echo json_encode([
        'responseType' => 1,
        'message'      => "#WARNING3937: Failed in forwarding to SRO for case no $case_no !!!",
      ]);
      return false;
    }

    //////proceeding start//////
    $proceeding_id = $this->db->query("SELECT max(proceeding_id)+1 AS c FROM settlement_proceeding WHERE case_no=?", 
                        array($case_no))->row()->c;
    if ($proceeding_id == null) {
      $proceeding_id = 1;
    }

    $insertArr = [
      'case_no'              => $case_no,
      'proceeding_id'        => $proceeding_id,
      'date_of_hearing'      => date('Y-m-d H:i:s'),
      'next_date_of_hearing' => date('Y-m-d H:i:s'),
      'note_type'            => 'Re forward to SRO',
      'note_on_order'        => "Re forward to SRO with deed detail: NO: $deed_no, Date: $deed_date",
      'status'               => 'W',
      'user_code'            => $this->session->userdata('user_code'),
      'date_entry'           => date('Y-m-d H:i:s'),
      'operation'            => 'E',
      'ip'                   => $this->utilityclass->get_client_ip(),
      'office_from'          => 'CO',
      'office_to'            => 'SRO',
      'task'                 => 'Re forward to SRO',
    ];
    $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
    if ($insertProc != 1) 
    {
      $this->db->trans_rollback();
      log_message("error", "#WARNING3972: Insertion failed in settlement_proceeding: ".$this->db->last_query());
      echo json_encode([
        'responseType' => 1,
        'message'      => "#WARNING3972: Failed in forwarding to SRO for case no $case_no !!!",
      ]);
      return false;
    }

    // call API to forward to SRO
    $loc = $dist_code.'_'.$subdiv_code.'_'.$cir_code.'_'.$mouza_pargona_code.'_'.$lot_no.'_'.$vill_townprt_code;

    if(($multi_dist != '' || $multi_dist != null || !empty($multi_dist)) && SEND_TO_MULTIPLE_SRO_DIST == 1)
    {
      $results    = [];
      $allSuccess = true; // Assume all are successful initially

      foreach($multi_dist as $d) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL            => NGDRS_SRO_PUSH_PROD,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING       => '',
          CURLOPT_MAXREDIRS      => 10,
          CURLOPT_TIMEOUT        => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST  => 'POST',
          CURLOPT_POSTFIELDS     => json_encode([
            "search_value" => $deed_no,
            "dist_code"    => $d,
            "co_name"      => $co_name->username,
            "location"     => $loc,
            "case_no"      => $case_no,
            "slno"         => $slno

          ]),
          CURLOPT_SSL_VERIFYHOST => false,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));

        $response    = curl_exec($curl);
        curl_close($curl);
        $decoded     = json_decode($response);            
        $results[$d] = $decoded ; // Store all responses

        // If any fails, mark overall failure
        if (!isset($decoded->status) || $decoded->status !== 'success') {
          $allSuccess = false;
        }
      }

      // Final check: If even one failed
      if(!$allSuccess || empty($results)) {
        $this->db->trans_rollback();
        log_message("error", "#WARNING4083: Failed to forward to SRO: ".json_encode($results));
        echo json_encode([
          'responseType' => 1,
          'message'      => "#WARNING4083: Failed in forwarding to SRO for case no $case_no !!!",
        ]);
        return false;
      }
    }
    else
    {
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL            => NGDRS_SRO_PUSH_PROD,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING       => '',
        CURLOPT_MAXREDIRS      => 10,
        CURLOPT_TIMEOUT        => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST  => 'POST',
        CURLOPT_POSTFIELDS     => json_encode([
          "search_value" => $deed_no,
          "dist_code"    => $dist_code,
          "co_name"      => $co_name->username,
          "location"     => $loc,
          "case_no"      => $case_no,
          "slno"         => $slno
        ]),
        CURLOPT_SSL_VERIFYHOST => false, // Disable SSL host verification
        CURLOPT_SSL_VERIFYPEER => false,  // Disable SSL certificate verification
        CURLOPT_HTTPHEADER => array(
          'Content-Type: application/json'
        ),
      ));

      $response = curl_exec($curl);
      curl_close($curl);
      $results = json_decode($response);

      if($results->status != 'success' || empty($results))
      {
        $this->db->trans_rollback();
        log_message("error", "#WARNING4125: Failed to forward to SRO: ".json_encode($results));
        echo json_encode([
          'responseType' => 1,
          'message'      => "#WARNING4125: Failed in forwarding to SRO for case no $case_no !!!",
        ]);
        return false;
      }
    }
    $this->db->trans_commit();
    echo json_encode([
      'responseType' => 2,
      'message'      => "#SUCCESS4027: Case $case_no has successfully forwarded to SRO for verification of deed detail",
    ]);
    return false;
  }

  public function loadViewForSroReForward()
  {
    $data['case_no'] = $this->input->post('case_no');
    $this->load->view('TeaGrant/CO/TeaGrantSroReforwardView', $data);
  }



  public function generateChithaArrays()
  {
    //$case_no = 'KAM/KAM/2024-25/4683/TGPP'; //option = no
    // $case_no = 'KAM/KAM/2024-25/4565/TGPP';
    $case_no = 'KAM/KAM/2024-25/4767/TGPP';
    

    $location_arr = $this->TeaGrantModel->getLocationArray($case_no);
    $pattadar_arr = $this->TeaGrantModel->getPattadarArray($case_no);

    // var_dump($pattadar_arr); die;

    foreach ($pattadar_arr as $key => $value) {
        // print_r($value);
        // die;
      $authorised_applicant_name = $value['pdar_name'];
      $dag_arr                   = $this->TeaGrantModel->getDagArray($case_no, $authorised_applicant_name);
      $data['dag_arr']           = $dag_arr;
    }
    // $authorised_applicant_name = $pattadar_arr->authorised_applicant_name;
    // $dag_arr                   = $this->TeaGrantModel->getDagArray($case_no, $authorised_applicant_name);

    $premium_arr = $this->TeaGrantModel->getPremiumArray($case_no);
    $outcome_arr = $this->TeaGrantModel->getOutcomeArray($case_no);

    $isSettlement = false; // or use: $this->TeaGrantModel->isSettlement($case_no);

                           // Add the flag into the settlement array
    $location_arr['settlement']['is_settlement'] = $isSettlement ? 1 : 0;

    $data = [
      'case_no'  => $case_no,
      'location' => $location_arr,
      'pattadar' => $pattadar_arr,
      'dag'      => $dag_arr,
      'premium'  => $premium_arr,
      'outcome'  => $outcome_arr,
    ];

    return $this->TeaGrantModel->settlementChithaUpdatev2($data);

  }


  public function reGeoTagCaseList()
  {
    // exit;
    $service_code        = '43';
    $status              = 'Z'; // in query it is checked as not equal to Z status/////
    $data['select_data'] = $this->TeaGrantModel->locationSelectReGeotagTea($service_code, $status);
    // echo $this->db->last_query();
    $data['_view']       = 'TeaGrant/CO/TeaGrantReGeoTag';
    $this->load->view('layouts/main', $data);
  }

  public function paginationForReGeoTagTeaGrant()
  {
    if(LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO'){
      $lot_string = $this->caseListUnderMappingLot();
    }

    $s_code             = $this->input->post('service');
    $search_term        = $this->input->post('search_term');
    $remark_cat         = $this->input->post('remark_cat');
    $reverted           = $this->input->post('reverted');
    $user_code          = $this->session->userdata('user_code');
    $mouza_pargona_code = $this->input->post('mouza_pargona_code');
    $lot_no             = $this->input->post('lot_no');
    $status             = $this->input->post('status');
    $draw               = intval($this->input->post('draw'));
    $start              = intval($this->input->post('start'));
    $length             = intval($this->input->post('length'));
    $order              = $this->input->post('order');
    $col                = 0;
    $dir                = "";
    $search             = $this->input->post('search');
    $search             = $search['value'];
    $searchByCol_0      = $this->input->post('columns')[0]['search']['value'];
    $searchByCol_1      = $this->input->post('columns')[1]['search']['value'];
    $searchByCol_3      = $this->input->post('columns')[3]['search']['value'];
    $is_cat             = $this->input->post('is_category');

    if (!empty($order)) {
        foreach ($order as $o) {
            $col = $o['column'];
            $dir = $o['dir'];
        }
    }

    if ($dir != "asc" && $dir != 'desc') {
        $dir = 'asc';
    }

    $valid_columns = array(
        0 => 'date_entry',
        // 1   => 'applid',
    );

    if (!isset($valid_columns[$col])) {
        $order = null;
    } else {
        $order = $valid_columns[$col];
    }

    if ($order != null) {
        $this->db->order_by($order, $dir);
    }

    if (!empty($searchByCol_0)) {

        $this->db->like('a.case_no', strtoupper($searchByCol_0));
    }

    if (!empty($searchByCol_1)) {

        $this->db->like('a.applid', strtoupper($searchByCol_1));
    }

    if (!empty($searchByCol_3)) {
        $this->db->like('TO_CHAR(a.date_entry,\'yyyy-mm-dd\')', $searchByCol_3);
        //$this->db->like('date_entry', $searchByCol_2);
    }

    $this->db->limit($length, $start);

    $this->db->where('a.service_code', $s_code);


    if(!empty($mouza_pargona_code))
    {
        $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
    }

    if(!empty($mouza_pargona_code) && !empty($lot_no))
    {
        $this->db->where('a.lot_no', $lot_no);
    }

    if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
        $this->db->where('a.vill_townprt_code', $is_cat);
    }



    if ($this->session->userdata('user_desig_code') == 'CO'){
        // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
        if(LOT_BIFURCATE ==1 && empty($mouza_pargona_code) && empty($lot_no)){
            if(isset($lot_string) && $lot_string != null)
            {
                $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
            }
        }

        // $this->db->orWhere('a.co_code', null);
    }



    $this->db->select('distinct(a.case_no), a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry,a.re_geotag_status,a.status');

    $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
    $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
    $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

    $this->db->from('settlement_basic a');
    $this->db->join('supportive_document b', 'a.case_no = b.case_no or a.applid = b.case_no');
    $query = $this->db->get();
    // echo $this->db->last_query(); die;


    log_message('error',"Query for Sel=======".$this->db->last_query());
    if ($query->num_rows() > 0) {
        foreach ($query->result() as $rows) {

            $tea_link = '<a type="button" href="#" onclick="reGeotagTeaGrant(\''.$rows->case_no.'\',\''.$rows->applid.'\')" class="btn-sm btn btn-primary">
                <i class="fa fa-map-marker" aria-hidden="true"></i> Enable Re-Geotag</a>';
            if(trim($rows->re_geotag_status) == 1)
            {
                $re_geotag_status = 'Requested For Re-Geotag';
                $tea_link = '--';

            }
            elseif(trim($rows->re_geotag_status) == 2)
            {
                $re_geotag_status = 'Re-Geotag Done';
            }
            else
            {
                $re_geotag_status = 'N/A';
            }
            $status = '<b class="text-warning">On Process</b>';
            if(trim($rows->status) == 'D'){
                $status = '<b class="text-danger">Rejected</b>';
            }

            $json[] = array(
                '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                // $rows->date_entry,
                date("Y-m-d", strtotime($rows->date_entry)),
                $status,
                $re_geotag_status,

                $s_code == TEA_SERVICE_CODE ? $tea_link : "NA"
            );
        }

        $this->db->where('a.service_code', $s_code);




        if ($this->session->userdata('user_desig_code') == 'CO'){
          // $this->db->where('a.co_code', $user_code);
          // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
          if(LOT_BIFURCATE ==1 && empty($mouza_pargona_code) && empty($lot_no)){

            if(isset($lot_string) && $lot_string != null)
            {
              $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
            }
          }
        }



        if(!empty($mouza_pargona_code))
        {
            $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
        }

        if(!empty($mouza_pargona_code) && !empty($lot_no))
        {
            $this->db->where('a.lot_no', $lot_no);
        }

        if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }

        // $this->db->distinct();
        $this->db->select('a.case_no');
        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
        $this->db->join('supportive_document b', 'a.case_no = b.case_no or a.applid = b.case_no');
        $this->db->group_by('a.case_no');

        // $query1 = $query->num_rows();
        $this->db->from('settlement_basic a');
        $query = $this->db->get();
        // log_message("error","Count Query==========".$this->db->last_query());
        $total_records =$query->num_rows();
        $response = array(
          'draw'            => $draw,
          'recordsTotal'    => $total_records,
          'recordsFiltered' => $total_records,
          'data'            => $json,
        );
        echo json_encode($response);

    } else {
      $response                         = array();
      $response['sEcho']                = 0;
      $response['iTotalRecords']        = 0;
      $response['iTotalDisplayRecords'] = 0;
      $response['aaData']               = [];
      echo json_encode($response);
    }
  }

  public function checkWhetherGeoTagorNot()
  {
    $case_no = $this->input->post('case_no');
    $applid  = $this->input->post('applid');

    if($case_no == null && $applid == null){
      echo json_encode([
        'responseType' => 3,
        'msg'          => '#ERRREGEO0002: Enable Re-geotag cancelled...!case no missing',
      ]);
      return false;
    }
    $url = API_LINK_MB3."requestRegeo";

    $arrayData =array(
      'application' => $applid,
    );
    log_message("error","MB001: CALLING URL=======".$url."===PARAMETER===".json_encode($arrayData));
    //*****API call again for geotag available */
    $getAvailable = $this->utilityclass->curlPost($url, $arrayData);

    if(isset($getAvailable) && !empty(json_decode($getAvailable)) && trim(json_decode($getAvailable)->status) == 'y'){
         //*****update in settlement_basic */
      $basicArray = [
        're_geotag_status'   => 1
      ];
      $this->db->where('case_no', $case_no);
      $this->db->update('settlement_basic', $basicArray);
      if($this->db->affected_rows() !=1)
      {
        log_message('error', '#ERRREGEOINS0001: Updating failed in settlement_basic and query is: ' . $this->db->last_query());
        echo json_encode([
          'responseType' => 3,
          'msg'          => '#ERRREGEOINS0001: Enable Re-geotag cancelled...!',
        ]);
        return false;
      }
      if($this->db->affected_rows() == 1 && trim(json_decode($getAvailable)->status) == 'y') {
        echo json_encode([
          'responseType' => 2,
          'msg'          => 'Requested for Re-geotag for the case no --'.$case_no,
        ]);
        return false;
      }
    }
    else{
      log_message('error', '#ERRREGEOINS0003: Fetching data error');
      echo json_encode([
        'responseType' => 3,
        'msg'          => '#ERRREGEOINS0003: Fetching data error',
      ]);
      return false;
    }

  }

  public function markedAsInstitute()
  { 
    $dist_code     = $this->session->userdata('dist_code');
    $subdiv_code   = $this->session->userdata('subdiv_code');
    $cir_code      = $this->session->userdata('cir_code');   

    $data['basic'] = $this->db->query("SELECT count(*) AS c FROM settlement_basic WHERE dist_code=? 
                                        AND subdiv_code=? AND cir_code=? AND pending_office=? AND service_code=? AND tgtpp_ins IS NULL AND status NOT IN ('F', 'D')", [$dist_code, $subdiv_code, $cir_code, 'CO', '43'])->result();

    // echo $this->db->last_query();
    $data['_view'] = 'TeaGrant/CO/TeaGrantMarkedAsInst';
    $this->load->view('layouts/main', $data);
  }

  public function listOfToBeMarkedAsInstitute()
  {
    if(LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO'){
      $lot_string = $this->caseListUnderMappingLot();
    }

    $s_code             = TEA_SERVICE_CODE;
    $search_term        = $this->input->post('search_term');
    $reverted           = $this->input->post('reverted');
    $user_code          = $this->session->userdata('user_code');
    $payment_status     = $this->input->post('payment_status');
    $mouza_pargona_code = $this->input->post('mouza_pargona_code');
    $lot_no             = $this->input->post('lot_no');
    $nr_cat             = $this->input->post('nr_cat');
    $status             = $this->input->post('status');
    $draw               = intval($this->input->post('draw'));
    $start              = intval($this->input->post('start'));
    $length             = intval($this->input->post('length'));
    $order              = $this->input->post('order');
    $search             = $this->input->post('search');
    $search             = $search['value'];
    $searchByCol_0      = $this->input->post('columns')[1]['search']['value'];
    $is_cat             = $this->input->post('is_category');
    $dist_code          = $this->session->userdata('dist_code');
    $subdiv_code        = $this->session->userdata('subdiv_code');
    $cir_code           = $this->session->userdata('cir_code');
    $mouza_code         = $this->input->post('mouza');
    $lot_no             = $this->input->post('lot');
    $village            = $this->input->post('vill_id');    

    $this->db->select('*');
    $this->db->from('settlement_basic');
    $this->db->where('dist_code', $dist_code);
    $this->db->where('subdiv_code', $subdiv_code);
    $this->db->where('cir_code', $cir_code);
    $this->db->where('pending_office', 'CO');
    $this->db->where('service_code', '43');
    $this->db->where('tgtpp_ins IS NULL');
    $this->db->limit($length, $start);
    $query = $this->db->get();

    if($query->num_rows() > 0) {

      $results = $query->result();
      $i=1;

      $this->db->select('*');
      $this->db->from('settlement_basic');
      $this->db->where('dist_code', $dist_code);
      $this->db->where('subdiv_code', $subdiv_code);
      $this->db->where('cir_code', $cir_code);
      $this->db->where('pending_office', 'CO');
      $this->db->where('service_code', '43');
      $this->db->where("status NOT IN ('F','D')");
      $this->db->where('tgtpp_ins IS NULL');
      $query1 = $this->db->get();

      $total_records = $query1->num_rows();

      foreach ($results as $rows) {

        $tea_grant_link = '<a type="button" href="' . base_url() . 'index.php/TeaGrantControllerCo/markApplicationRegistrationAsInst?app='. $this->utilityclass->encryptJwtCase($rows->applid).'" class="btn-sm btn btn-primary">Write Report</a>';

        $json[] = array(
          $rows->applid,
          '<span class="px-3"><strong>' . $rows->applid . '</strong></span>',
          $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),
          $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),
          $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),  
          date('Y-m-d', strtotime($rows->submission_date)),  
          $tea_grant_link,
        );
      }

      $response = array(
        'draw'            => $draw,
        'recordsTotal'    => $total_records,
        'recordsFiltered' => $total_records,
        'data'            => $json,
      );
      echo json_encode($response);
    }
    else {
      $response                         = array();
      $response['sEcho']                = 0;
      $response['iTotalRecords']        = 0;
      $response['iTotalDisplayRecords'] = 0;
      $response['aaData']               = [];
      echo json_encode($response);
    }
  }


  public function markApplicationRegistrationAsInst($review_flag = false) 
  {
    $application_no = $this->input->get('app');

    $application_no = $this->utilityclass->decryptJwtCase($application_no);

    $geo_date_query = $this->db->query("SELECT date_entry FROM supportive_document WHERE applid='$application_no'")->row();
    $geo_date = isset($geo_date_query->date_entry)? $geo_date_query->date_entry : '.....';

    // $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE applid = ? AND file_name = ? ", array($application_no, GEO_TAG_PHOTO) );
    $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE id in (SELECT max(id) FROM supportive_document WHERE applid=? and dag_no is not null and file_name=? GROUP BY applid, dag_no)", array($application_no, GEO_TAG_PHOTO));

    if($supportive_document_sql->num_rows() > 0)
    {
      $codata['geo_tag_doc'] = $supportive_document_sql->result();
    }
    else
    {
      $codata['geo_tag_doc_empty'] = "<span class='text-danger alert-danger'><b>Geo tag photo yet to be uploaded.</b></span>";
    }

    //********************case registration FROM API start ********* */
    //********************check and insert if case not registered */
    $recordExist=$this->SettlementApiModel->checkExistDharitree($application_no);
 
    $startTime = microtime(true);
    try{
      $codata['review_flag'] = false;
      if($review_flag){
        $sql = $this->db->query('SELECT * FROM settlement_basic WHERE applid = ? and review_flag = ?', array($application_no, $review_flag));

        if($sql->num_rows() > 0){
          $case_no = $sql->row()->case_no;
        }
        else{
          $data = array(
            'error' => 'Something went wrong! please contact administration!' .$application_no,
          );
          echo json_encode($data);
          return false;
        }
        $codata['review_flag'] = true;
      }else{
        $sql = $this->db->query('SELECT dharitree FROM basundhar_application WHERE basundhara = ?', array($application_no));

        if($sql->num_rows() > 0){
          $case_no = $sql->row()->dharitree;
        }
        else{
          $data = array(
            'error' => 'Something went wrong! please contact administration!' .$application_no,
          );
          echo json_encode($data);
          return false;
        }
      }

      //  row_array
      $basic             = $this->TeaGrantModel->getSettlementBasic($case_no);
      //  result
      $applicants_buyers = $this->TeaGrantModel->getAllApplicantBuyers($case_no);
      $applicants_owners = $this->TeaGrantModel->getAllApplicantOwners($case_no);

      $applicants_dag_details = $this->TeaGrantModel->getAllApplicantDagDetails($case_no);

      $dags              = $this->TeaGrantModel->getSettlementDag($case_no);
      $lmnotes           = $this->TeaGrantModel->getSettlementTenantLmNote($case_no);
      $proceedings       = $this->TeaGrantModel->getSettlementProceeding($case_no);
      $dhardocuments     = $this->TeaGrantModel->getDocuments($case_no);
      $nominee           = $this->TeaGrantModel->getAllNomineeDetail($case_no);

      $existing_pattadar = $this->TeaGrantModel->getAllExistingPattadar($case_no);
      $deed_applicant    = $this->TeaGrantModel->getAllDeedPattadar($case_no);
      $family_tree       = $this->TeaGrantModel->getAllFamilyTree($case_no);

      /// premium
      $codata['s_area']  = $this->SettlementCommonModel->getPremiumArea();
      
      $premiumData = $this->db->query("SELECT * FROM settlement_premium WHERE case_no='$case_no' and is_final=1")->row();
      $codata['premiumData'] = $premiumData;
      /// premium end

      $codata['basic']                  = $basic;
      $codata['geo_date']               = $geo_date;
      $codata['applicants_buyers']      = $applicants_buyers;
      $codata['applicants_owners']      = $applicants_owners;
      $codata['applicants_dag_details'] = $applicants_dag_details;
      $codata['reservation']            = $this->SettlementVgrModel->getSettlementReservation($case_no);

      $codata['dags']                   = $dags;
      $codata['lmnotes']                = $lmnotes;
      $codata['proceedings']            = $proceedings;
      $codata['dhardocuments']          = $dhardocuments;
      $codata['nominee']                = $nominee;
      $codata['existing_pattadar']      = $existing_pattadar;
      $codata['deed_applicant']         = $deed_applicant;
      $codata['family_tree']            = $family_tree;

      //for dag not eligible
      $codata['dag_count']              = count($dags);

      $d = $basic["dist_code"];
      $s = $basic["subdiv_code"];
      $c = $basic["cir_code"];
      $m = $basic["mouza_pargona_code"];
      $l = $basic["lot_no"];
      $v = $basic["vill_townprt_code"];

      //*******getting the deleted settlement_dag_details data FROM settlement_deleted_data table */
      $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($case_no);
      $deletedEncArray = array();
      foreach($deletedEnc as $encroacherDeleted_data)
      {
          $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
      }
      $codata['deleted_encroacher'] = $deletedEncArray;

      //***********getting the settlement_applicant occupiers data FROM settlement_deleted_data table */
      $deletedDags=$this->SettlementCommonModel->getDeletedDags($case_no);
      $deletedData = array();
      foreach($deletedDags as $deleteDag){
          $deletedData[] = json_decode($deleteDag->table_data);
      }
      $codata['deleted_dags'] = $deletedData;


      //   calling API for self declaration data

      $sql = "SELECT basundhara FROM basundhar_application WHERE dharitree='$case_no' ";
      $basundhara = $this->db->query($sql)->row();
      $token = $this->utilityclass->createTokenJwt();
      $curl_handle = curl_init();
      curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."getAppDetails");
      curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
      curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
        'application_no' => $basundhara->basundhara,
        'api_key'        => API_KEY,
        'token'          => $token
      )));
      $output = curl_exec($curl_handle);
      if(isset(json_decode($output)->responseType)){
        if(json_decode($output)->responseType == 3){
          echo json_decode($output)->data." - Unauthorized access!";
          return false;
        }
      }
      curl_close($curl_handle);
      $output = json_decode($output);

      $codata['document'] = $output->documents;
      $codata['query']    = $output->query;
      $codata['property'] = $output->property;
      $codata['aadhar']   = $output->aadhar;
      $codata['nextKin']  = $output->nextKin;
      foreach($output->selfDeclaration as $selfDec){
        $codata['selfDeclarationDetails'] = json_decode($selfDec->dec_details);
      }

      foreach($codata['applicants_buyers'] as $adhar_photo):
        if($adhar_photo->is_applicant == 1 && trim($adhar_photo->identity_type) == 'AADHAAR'):
          $get_aadhaar_photo = $this->TeaGrantModel->aadhaarPhotoView($application_no);
          if($get_aadhaar_photo != 'n'){
            $codata['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($get_aadhaar_photo).";base64,".$get_aadhaar_photo." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
          }
        endif;
      endforeach;

      // for guardian relation
      $query_for_guar_rel = "SELECT * FROM master_guard_rel WHERE id NOT IN ('5','6')";

      $relation_executation = $this->db->query($query_for_guar_rel);
      $row = $relation_executation->num_rows();

      if ($row != 0) {
        $codata['guar_rel'] = $relation_executation->result();
      }

      /// vlb data 
      if(isset($dags)){
        foreach($dags as $vlb_dag){
          $sqlvlbcheck = $this->db->query("SELECT * FROM settlement_land_bank_details WHERE application_no = ? AND dag_no = ?", array($application_no, $vlb_dag->dag_no));

          if($sqlvlbcheck->num_rows() > 0){
            $vlb_newly_added[] = $sqlvlbcheck->row()->dag_no;
          }
          else{
            $vlb_newly_added[] = false;
          }
        }
        $codata['vlb_newly_added'] = $vlb_newly_added;
      }

      /// additional property for LM note
      $additional_property = $this->db->query("SELECT * FROM settlement_additional_property WHERE applid='$application_no'");
      if($additional_property->num_rows() > 0){
        $totallesaa=0;
        $totalganda=0;
        foreach($additional_property->result() as $addprop){
          if(in_array($addprop->dist_code, json_decode(BARAK_VALLEY))){
            $total_g=$this->utilityclass->Total_ganda($addprop->bigha,$addprop->katha,$addprop->lessa,$addprop->ganda);
            $totalganda = $totalganda+$total_g;
          }else{
            $total_l=$this->utilityclass->Total_Lessa($addprop->bigha,$addprop->katha,$addprop->lessa);
            $totallesaa = $totallesaa+$total_l;
          }
        }
        if(!empty($totallesaa)){
          $codata['total_aditional_area']= $this->utilityclass->Total_Bigha_Katha_Lessa($totallesaa);
        }
        if(!empty($totalganda)){
          $codata['total_aditional_area_g']= $this->utilityclass->Total_Bigha_Katha_Lessa2($totalganda);
        }
        $codata['additional_property']=$additional_property->result();
          //var_dump($codata['additional_property']); die;
      }

      $codata['case_no'] = $case_no;

      $rejected_data = $this->SettlementCommonModel->getRejectModal(TEA_SERVICE_CODE);
      if($rejected_data == 'n')
      {
        $codata['rejected_list'] = false;
      }
      else
      {
        $codata['rejected_list'] = $rejected_data;
      }
    }

    catch (Exception $e)
    {
      log_message('ERROR#LM_DATA_FETCH', 'Lm application data fetch...####'. $e);
    }
    finally
    {
      $endTime = microtime(true);
      $timeDiff = $endTime - $startTime;

      if($timeDiff > (float)2){
        log_message('EXECUTION_TIME', $this->router->fetch_class().'->'.$this->router->fetch_method().' # The execution time is : '.$timeDiff);
      }
    }

    //****getting tribe cat and under tribal belt data FROM backup */
    $getJsonBackup = $this->TeaGrantModel->getJsonDataFromBackup($case_no);

    //************check if SK is available*/
    $codata['sk_name']= $this->SettlementCommonModel->getSkName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);

    if($codata['sk_name'] == 'n')
    {
      //************if SK is not available then load CO */
      $codata['sk_availability'] = 'n';

      $codata['co_name'] = $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
    }
    else
    {
      $codata['sk_availability'] = 'y';
    }

    $codata['co_name']= $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);

    $codata['co_name_reject']= $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);

    $codata['dagFlagCheckChitha'] = $this->SettlementCommonModel->getChithaFlaggedRemarks($dags, $codata['rejected_list']);


    $codata['mouza_name'] = $this->utilityclass->getMouzaName($basic['dist_code'], 
                              $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code']);

    $codata['vill_name'] = $this->utilityclass->getVillageName($basic['dist_code'], 
                              $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], 
                                $basic['lot_no'], $basic['vill_townprt_code']);

    // initial tea grant view through API
    if($_SERVER['REQUEST_METHOD'] != 'POST'){
      $codata['_view'] = 'TeaGrant/CO/TeaGrantViewToMarkAsInst';
      $this->load->view('layouts/main',$codata);
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){ 

      $redirect = base_url()."index.php/TeaGrantControllerCo/markApplicationRegistrationAsInst?app=".$this->utilityclass->encryptJwtCase($application_no);

      $case_no = $this->input->post('case_no');

      $this->db->trans_begin();

      $sqlCheckExist = $this->db->query("SELECT count(*) as c FROM  settlement_basic WHERE case_no=? 
                          AND pending_officer=?", [$case_no, 'CO']); 
      if($sqlCheckExist->num_rows() <= 0){
        log_message("error", "ERR4878 :No detail found in settlement_basic for case no $case_no !!!");
        $this->session->set_flashdata('message', "#ERR4878: Failed to mark this case as institute for case no $case_no !!!");
        redirect($redirect);
      }

      $updateBasic = $this->db->query("UPDATE settlement_basic SET tgtpp_ins=? WHERE case_no=?", ['Y', $case_no]); 
      if($this->db->affected_rows() != 1){
        log_message("error", "ERR4888 : Updation failed in settlement_basic for case no $case_no !!!");
        $this->db->trans_rollback();
        $this->session->set_flashdata('message', "#ERR4888: Failed to mark this case as institute for case no $case_no !!!");
        redirect($redirect);
      }


      //////proceeding start//////
      $proceeding_id = $this->db->query("SELECT max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

      if ($proceeding_id == null) {
        $proceeding_id = 1;
      }

      $msg = '';
      $msg = ($this->input->post('recommend') == 'YES') ? 'Can be recommended' : 'Can not recommended';

      $note_on_order = 'Marked this case as Institute. It will be processed soon.';

      $insPetProceed = [
        'case_no'              => $case_no,
        'proceeding_id'        => $proceeding_id,
        'date_of_hearing'      => date('Y-m-d H:i:s'),
        'next_date_of_hearing' => date('Y-m-d H:i:s'),
        'note_on_order'        => $note_on_order,
        'status'               => 'W',
        'user_code'            => $this->session->userdata('user_code'),
        'date_entry'           => date('Y-m-d H:i:s'),
        'operation'            => 'E',
        'ip'                   => $this->utilityclass->get_client_ip(),
        'office_from'          => 'CO',
        'office_to'            => 'CO',
        'task'                 => 'Marked case as Institute',
        'note_type'            => 'Marked case as Institute',
      ];
      $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

      if ($insertProceeding != 1) {
        log_message("error", "ERR4926 : updation failed in settlement_proceeding for case no $case_no !!!".$this->db->last_query());
        $this->db->trans_rollback();
        $this->session->set_flashdata('message', "#ERR4926: Failed in forwarding to LRA & SRO for case no $case_no !!!");
        redirect($redirect);
      }      

      if ($this->db->trans_status() == false) 
      {
        log_message("error", "ERR4938 : Transaction failed for case no $case_no !!!");
        $this->db->trans_rollback();
        $this->session->set_flashdata('message', "#ERR4938: Failed to mark this case as institute for case no $case_no !!!");
        redirect($redirect);
      } 
      else 
      {
        //////////////POST To basundhara/////////////////////
        $rmk         = $note_on_order;
        $status      = 'M';
        $task        = 'CO';
        $pen         = 'CO';
        $case        = $case_no;
        $rtps_status = $this->SettlementApiModel->postApiBasundharaMb3($application_no, $case, $rmk, $status, $task, $pen);

        $rtps_status = json_decode($rtps_status);
        
        if (trim($rtps_status) != "y") 
        {
          $this->db->trans_rollback();
          $this->session->set_flashdata('message', "#ERR4956: Failed to mark this case as institute for case no $case_no !!!");
          redirect($redirect);
        } 
        else
        {
          $this->db->trans_commit();
          $this->session->set_flashdata('message', "Application has successfully marked as Institute for Case No: $case_no");
          redirect(base_url() . "index.php/TeaGrantControllerCo/markedAsInstitute");
        }        
      }
    }
  }




  

}
