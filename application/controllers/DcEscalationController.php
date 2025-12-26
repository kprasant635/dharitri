<?php
class DcEscalationController extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->model('DcEscalationModel');
    $this->load->model('EscalationListModel');
    $this->load->model('DataBaseSwitchModel');
  }

  public function landingEscalatedViewPage() 
  { 
    try
    {
      $user_desig_code = $this->session->userdata('user_desig_code');
      $dist_code       = $this->session->userdata('dist_code');
      $user_code       = $this->session->userdata('user_code');

      $data['escalated_cases'] = $this->DcEscalationModel->getEscalationFromUserToDc($user_desig_code, $user_code);
      // log_message('error', "#ERR24: ESCALATED_CASE ".json_encode($data['escalated_cases']));

      $data['_view'] = 'common/dc/dc_escalated_pending_list';
      $this->load->view('layouts/main',$data);
    }
    catch(Exception $e) {
      echo 'Message: ' .$e->landingEscalatedViewPage();
    }
  }


  // escalated cases by officers
  public function getPendingEscalatedCases_old()
  {
    try
    {
      $from_user     = $this->input->post('from_user');
      $user_code     = $this->session->userdata('user_code');

      $draw          = intval($this->input->post('draw'));
      $start         = intval($this->input->post('start'));
      $length        = intval($this->input->post('length'));
      $order         = $this->input->post('order');

      $detail = $this->DcEscalationModel->getEscalatedCasesToDcByOtherUsers($user_code,$from_user);
      // log_message('error', "#ERR38: ESCALATED_LIST_FROM_$from_user: ".$this->db->last_query());

      if($detail->num_rows() > 0)
      {
        $records = $detail->result();

        foreach($records as $rows)
        {
          // get service type
          $stype = $this->DcEscalationModel->explodeCaseNo($rows->case_no);
          // echo $stype; die;

          $rtps_no = $this->EscalationListModel->getFromBasundharApplByCaseNo($rows->case_no);
          // log_message('error', 'Rtps No: '.$rtps_no);

          $res = $this->EscalationListModel->getFromMasterBasicTable($stype, $rows->case_no)->row();

          if($stype == 'MiNC' || $stype == 'MiND')
          {
            $date_entry = date('M jS, Y',strtotime($res->submission_date));
          }
          else
          {
            $date_entry = date('M jS, Y',strtotime($res->date_entry));
          }  

          $circle = ($stype == 'ACPP') ? $res->circle_code : $res->cir_code;

          $mouza_lot = $this->utilityclass->getMouzaName($res->dist_code, $res->subdiv_code, $circle, $res->mouza_pargona_code)."-".$this->utilityclass->getLotName($res->dist_code, $res->subdiv_code, $circle, $res->mouza_pargona_code, $res->lot_no);

          $village = $this->utilityclass->getVillageName($res->dist_code, $res->subdiv_code, $circle, $res->mouza_pargona_code, $res->lot_no, $res->vill_townprt_code);

          $caseNo = $this->utilityclass->encryptJwtCase($rows->case_no);
          $toUser = $this->utilityclass->encryptJwtCase($from_user);

          $link = base_url()."index.php/DcEscalationController/revertEscalatedCase?case_no=".$caseNo."&revert_to_user=".$toUser;

          $details = base_url()."index.php/DcEscalationController/viewCaseDetails?case_no=".$caseNo;

          $revert_back = "<a href='".$link."' class='btn btn-sm btn-danger'>Revert Back</a>";

          $button = $revert_back;

          $json[] = array(
            $rows->case_no."<br><span class='small font-italic red'>".$rtps_no."</span>",
            $mouza_lot,
            $village,
            $date_entry,          
            $button
          );
        }
      }
      else {
        $json                             = "";
        $response                         = array();
        $response['sEcho']                = 0;
        $response['iTotalRecords']        = 0;
        $response['iTotalDisplayRecords'] = 0;
        $response['aaData']               = [];
        log_message('error', 'For empty data: '.json_encode($response));
        echo json_encode($response);
        return;
      }
      $response = array(
        'draw'            => $draw,
        'recordsTotal'    => $detail->num_rows(),
        'recordsFiltered' => $detail->num_rows(),
        'data'            => $json
      );
      echo json_encode($response);
      return;
    }
    catch(Exception $e) {
      echo 'Message: ' .$e->landingEscalatedViewPage();
    }
  }

  // revert cases to the officer from where it came
  public function revertEscalatedCase11111()
  { 
    $data               = array();
    $case_no            = $this->utilityclass->decryptJwtCase($this->input->get('case_no'));
    $revert_to_user     = $this->utilityclass->decryptJwtCase($this->input->get('revert_to_user'));

    $distCode           = $this->session->userdata('dist_code');
    $db                 = $this->DataBaseSwitchModel->dharDbSwitch($distCode);

    $response           = $this->DcEscalationModel->revertFromDc($case_no, $db);


    



    // get user wise days remains
    $response           = $this->DcEscalationModel->getEscRemainingDaysOfUsers($case_no, $db);
    // echo "<pre>";
    // var_dump($response); 
    // die;
    // log_message('error', "#ERR125==USER_REMAIN_DAYS : ".json_encode($response));

 
    $userMaxDays        = max($response['user_rem_days']);                        // max value
    $userKey            = array_search($userMaxDays, $response['user_rem_days']); // key of the array
    $totalAllocatedDays = $response['total_allocate_days'];                       // total allocated days
    $totalRemainingdays = $response['total_rem_days'];                            // total remaining days
    $totalCompletedDays = $response['total_complete_days'];                       // total completed days

    $userFields = json_encode($this->DcEscalationModel->getUserWiseFields($userKey)); // get user field names
    // log_message('error', "#ERR137==USER_FIELD_NAME : ".json_encode($userFields));


    // get the days diff reverted by DC, diff between reverted on and assigned to dc
    $dcRevertDays = $this->DcEscalationModel->getRevertedDaysByDcOn($case_no, $db);


    // var_dump($dcRevertDays);
    // die;
    // log_message('error', "#ERR141==DC_REVERTED_ON : ".json_encode($dcRevertDays));

    // check if reverted days has crossed the total days
    $countTotalDaysRemainsAfterDcRevert = $dcRevertDays + $totalCompletedDays;
    $dc_target_days = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($case_no);
    $totalAllocatedDays = $totalAllocatedDays + $dc_target_days->dc_target_days; 








    if($countTotalDaysRemainsAfterDcRevert > $totalAllocatedDays) // if exceeds the total allocate days
    {
      $data['remainingDays'] = 0;
      $data['dataArray']     = $userFields;
      $data['env']           = DEESCALATE;
    }
    else // if not exceeding total allocate days
    { 
      if($userMaxDays > $dcRevertDays) // check which user is having maximum days or not
      {
        $data['remainingDays'] = $userMaxDays - $dcRevertDays;
        $data['dataArray']     = $userFields;
        $data['env']           = REVERT;
        // DONE
      }
      else // if there is no max days available which is greater than the value of dc reverted days
      {
        if($totalRemainingdays > $dcRevertDays) // check if remaining days is greater than dc reverted days
        {
          $data['remainingDays'] = $totalRemainingdays - $dcRevertDays;
          $data['dataArray']     = null;
          $data['env']           = REVERT;
          // DONE
        }
        else // if remain days less than dc reverted days
        { 
          $data['remainingDays'] = 0;
          $data['dataArray']     = $userFields;
          $data['env']           = DEESCALATE;
        }
      }
    }
    // var_dump($data);die;

    $data['_view'] = 'EscalationRevertView/escRevertBackFromDc';
    $this->load->view('layouts/main',$data);

  }


  // reverted by DC
  public function revertBackEscalationCases()
  {
    try
    {
      // var_dump($_POST); die;
      $redirect = base_url()."index.php/DcEscalationController/landingEscalatedViewPage";
      $db     = $this->DataBaseSwitchModel->dharDbSwitch($this->session->userdata('dist_code'));
      $db->trans_begin();    
      // var_dump($_POST);
      // die; 
      // $result = $this->DcEscalationModel->revertBackEscalationCasesByDc($_POST, $db);
      $result = $this->DcEscalationModel->revertFromDc($_POST, $db);
      log_message('error', "#LOG198: revertBackEscalationCases() ".json_encode($result));

      if($result['response'] == 1)
      {
        $db->trans_rollback();
        log_message('error', "Revert failed for case no ".$_POST['case_no']." JSON_DATA: ".json_encode($result));
        $this->session->set_flashdata('message', $result['message']);
        redirect($result['redirect']);
      }
      else if($result['response'] == 3) // success
      {
        $db->trans_commit();
        $this->session->set_flashdata('success', $result['message']);
        redirect($result['redirect']);
      }
      else
      {
        $db->trans_rollback();
        log_message('error', "Revert failed for case no ".$_POST['case_no']." JSON_DATA: ".json_encode($result));
        $this->session->set_flashdata('message', "#ERR251: Something went wrong while reverting to ".$_POST['revert_to_user']." for case no ".$_POST['case_no'].".  Please contact system administrator !!!");
        redirect($result['redirect']);
      }
    }
    catch(Exception $e) {
      echo 'Message: ' .$e->revertBackEscalationCases();
    }
  }


  // get allocated percentage use wise
  public function userAllocateDaysPercentage()
  {
    // var_dump("dfghj"); die;
    $districts = ['35','08','25','02','17','03','14','36','15','24','21','12','34','32','33','06','16','11','37','18','07','10','38','13','05','39'];

    $districts = ['07'];

    foreach($districts as $dist) 
    {
      $this->db = $this->dbswitch($dist);

      $query = $this->db->query("SELECT total_timeline, da_allocated_days, lm_allocated_days, sk_allocated_days, co_allocated_days, bo_allocated_days, adc_allocated_days, dc_allocated_days, dept_allocated_days, sro_allocated_days, mouzadar_allocated_days, escalation_type, category FROM escalation_matrix");
      // echo $this->db->last_query();

      $count = $query->num_rows();
      $update_count = 0;

      foreach($query->result() as $row)
      {
        $total_timeline  = $row->total_timeline;
        $escalation_type = $row->escalation_type;
        $category        = $row->category;

        $da_percentage       = round((($row->da_allocated_days*100)/$total_timeline), 2);
        $lm_percentage       = round((($row->lm_allocated_days*100)/$total_timeline), 2);
        $sk_percentage       = round((($row->sk_allocated_days*100)/$total_timeline), 2);
        $co_percentage       = round((($row->co_allocated_days*100)/$total_timeline), 2);
        $bo_percentage       = round((($row->bo_allocated_days*100)/$total_timeline), 2);
        $adc_percentage      = round((($row->adc_allocated_days*100)/$total_timeline), 2);
        $dc_percentage       = round((($row->dc_allocated_days*100)/$total_timeline), 2);
        $dept_percentage     = round((($row->dept_allocated_days*100)/$total_timeline), 2);
        $sro_percentage      = round((($row->sro_allocated_days*100)/$total_timeline), 2);
        $mouzadar_percentage = round((($row->mouzadar_allocated_days*100)/$total_timeline), 2);

        // update matrix table
        $update = [
          'da_allocate_perc'       => $da_percentage,
          'lm_allocate_perc'       => $lm_percentage,
          'sk_allocate_perc'       => $sk_percentage,
          'co_allocate_perc'       => $co_percentage,
          'bo_allocate_perc'       => $bo_percentage,
          'adc_allocate_perc'      => $adc_percentage,
          'dc_allocate_perc'       => $dc_percentage,
          'dept_allocate_perc'     => $dept_percentage,
          'sro_allocate_perc'      => $sro_percentage,
          'mouzadar_allocate_perc' => $mouzadar_percentage,
        ];

        $where = [
          'category'        => $category,
          'escalation_type' => $escalation_type,
        ];

        $this->db->update('escalation_matrix', $update, $where);
        if($this->db->affected_rows() != 1)
        {
          log_message('error',"#ERR288: Updation_Failed");
          echo "Updation failed";
          exit;
        }
        $update_count++;
      }
    }
    if($update_count == $count)
    {
      echo "Total number of rows updated successfully $update_count";
    }
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



  // revert cases to the officer from where it came
  public function revertEscalatedCase()
  { 
    // echo "dfghjkl"; die;
    $data           = array();
    $case_no        = $this->utilityclass->decryptJwtCase($this->input->get('case_no'));
    $revert_to_user = $this->utilityclass->decryptJwtCase($this->input->get('revert_to_user'));

    $distCode       = $this->session->userdata('dist_code');
    $db             = $this->DataBaseSwitchModel->dharDbSwitch($distCode);
    $resp           = $this->DcEscalationModel->getDcRemainingDaysToRevert($case_no, $revert_to_user, $db); 

    // echo "<pre>"; var_dump($resp); die;

    if($resp['response'] == 1) // no time left, but failed to update service wise table
    {
      $data['message'] = $resp['message'];
      $data['go_back'] = $resp['go_back'];
    }

    if($resp['response'] == 3) // no time left, successfully updated service wise table and es_flag = 0
    {
      $data['message'] = $resp['message'];
      $data['go_back'] = $resp['go_back'];
    }

    if($resp['response'] == 4) // if between escalation/de-escalation time zone
    {
      $data['dc_remaining_days'] = $resp['dc_remaining_days'];
      $data['userCount']         = $resp['userCount'];
      $data['environment']       = $resp['environment'];
      $data['process_code']      = $resp['process_code'];
      $data['users']             = isset($resp['users']) ? $resp['users'] : '';
      $data['from_dc_to']        = isset($resp['from_dc_to']) ? $resp['from_dc_to'] : '';
    }
    $data['_view'] = $resp['view'];
    $this->load->view('layouts/main',$data);
  }


  // reverted by DC
  public function revertBackEscalationCasesToAllUsers()
  {
    try
    {
      // $redirect = base_url()."index.php/DcEscalationController/landingEscalatedViewPage";
      $db = $this->DataBaseSwitchModel->dharDbSwitch($this->session->userdata('dist_code'));
      $db->trans_begin();    
      // var_dump($_POST);
      // die; 
      // $result = $this->DcEscalationModel->revertBackEscalationCasesByDc($_POST, $db);
      $result = $this->DcEscalationModel->revertFromDc($_POST, $db);
      // echo "<pre>"; var_dump($result);
      log_message('error', "#LOG198:revertBackEscalationCasesToAllUsers() ".json_encode($result));
      // die;

      if($result['response'] == 1)
      {
        $db->trans_rollback();
        log_message('error', "Revert failed for case no ".$_POST['case_no']." JSON_DATA: ".json_encode($result));
        $this->session->set_flashdata('message', $result['message']);
        redirect(base_url() . "index.php/home");
      }
      else if($result['response'] == 3) // success
      {
        $db->trans_commit();
        $this->session->set_flashdata('success', $result['message']);
        redirect(base_url() . "index.php/home");
      }
      else
      {
        $db->trans_rollback();
        log_message('error', "Revert failed for case no ".$_POST['case_no']." JSON_DATA: ".json_encode($result));
        $this->session->set_flashdata('message', "#ERR464: Something went wrong while reverting to ".$_POST['revert_to_user']." for case no ".$_POST['case_no'].".  Please contact system administrator !!!");
        redirect(base_url() . "index.php/home");
      }
    }
    catch(Exception $e) {
      echo 'Message: ' .$e->revertBackEscalationCases();
    }
  }


  // re allocate days user wise
  public function manuallyReallocateDaysToUser()
  {
    try
    {
      $redirect = base_url()."index.php/DcEscalationController/landingEscalatedViewPage";
      $db     = $this->DataBaseSwitchModel->dharDbSwitch($this->session->userdata('dist_code'));
      $db->trans_begin();  

      $result = $this->DcEscalationModel->manuallyReallocateDaysToUser($_POST, $db);

      // var_dump($result['message']); die;

      if($result['response'] == 1)
      {
        $db->trans_rollback();
        log_message('error', "Revert failed for case no ".$_POST['case_no']." JSON_DATA: ".json_encode($result));
        $this->session->set_flashdata('message', $result['message']);
        redirect($result['redirect']);
      }
      else if($result['response'] == 3) // success
      {
        $db->trans_commit();
        $this->session->set_flashdata('success', $result['message']);
        redirect($result['redirect']);
      }
      else
      {
        $db->trans_rollback();
        log_message('error', "Revert failed for case no ".$_POST['case_no']." JSON_DATA: ".json_encode($result));
        $this->session->set_flashdata('message', "#ERR490: Something went wrong while reverting to ".$_POST['revert_to_user']." for case no ".$_POST['case_no'].".  Please contact system administrator !!!");
        redirect($result['redirect']);
      }
    }
    catch(Exception $e) {
      echo 'Message: ' .$e->manuallyReallocateDaysToUser();
    }
  }


  public function getPendingEscalatedCases()
  {
    try
    {
      $this->load->model('EscTableFieldsModel');
      $from_user     = $this->input->post('from_user');
      $user_code     = $this->session->userdata('user_code');
      $by_case_no    = $this->input->post('case_no');

      $draw          = intval($this->input->post('draw'));
      $start         = intval($this->input->post('start'));
      $length        = intval($this->input->post('length'));
      $order         = $this->input->post('order');

      $assigned_from_code = $this->EscTableFieldsModel->getUserCode($from_user);
      $escalate_status    = $this->EscTableFieldsModel->getEscalatedStatusByUserCode($from_user);

      $col = 0;
      $dir = "";
      if(!empty($order)){
        foreach($order as $o){
          $col = $o['column'];
          $dir = $o['dir'];
        }
      }
      if($dir != "asc" && $dir != 'desc'){
        $dir = 'asc';
      }
      $valid_columns = array(
        0 => 'ed.escalated_date',
      );
      if(!isset($valid_columns[$col])){
        $order = 'ed.escalated_date';
      } else {
        $order = $valid_columns[$col];
      }
      if($order != null){
        $this->db->order_by($order, $dir);
      }
      if(!empty($by_case_no)){
        $this->db->where("(ed.case_no='$by_case_no' OR ba.basundhara='$by_case_no')");
          // $this->db->where('ed.case_no', $by_case_no);
          // $this->db->or_where('ba.basundhara', $by_case_no);
      }

      $this->db->select('ed.*, ba.basundhara');
      $this->db->join('basundhar_application ba', 'ed.case_no = ba.dharitree', 'left');
      $this->db->from('escalation_details ed');
      $this->db->where('ed.'.$escalate_status, 'Y');
      $this->db->where('ed.assigned_from_code', $assigned_from_code);
      //$this->db->where('ed.assigned_to', $user_code);
      $this->db->where('ed.assigned_to_code', '2');
      $this->db->where('ed.status', 'P');
      $this->db->where('ed.final_completion_date IS NULL');
      $this->db->limit($length, $start);
      $query = $this->db->get();
      // echo $this->db->last_query(); die;


      if($query->num_rows() > 0) {

        $result = $query->result();
        $i=1;

        if(!empty($by_case_no)){
          $this->db->where("(ed.case_no='$by_case_no' OR ba.basundhara='$by_case_no')");
        }


        $this->db->select('ed.*, ba.basundhara');
        $this->db->join('basundhar_application ba', 'ed.case_no = ba.dharitree', 'left');
        $this->db->from('escalation_details ed');
        $this->db->where('ed.'.$escalate_status, 'Y');
        $this->db->where('ed.assigned_from_code', $assigned_from_code);
        //$this->db->where('ed.assigned_to', $user_code);
        $this->db->where('ed.assigned_to_code', '2');
        $this->db->where('ed.status', 'P');
        $this->db->where('ed.final_completion_date IS NULL');
        $query1 = $this->db->get();

        // echo $this->db->last_query(); die;
        $total_records = $query1->num_rows();

        foreach($result as $rows) {

          // get service type
          $stype = $this->DcEscalationModel->explodeCaseNo($rows->case_no);
          // echo $stype; die;

          $rtps_no = $this->EscalationListModel->getFromBasundharApplByCaseNo($rows->case_no);
          // log_message('error', 'Rtps No: '.$rtps_no);

          $res = $this->EscalationListModel->getFromMasterBasicTable($stype, $rows->case_no)->row();

          if($stype == 'MiNC' || $stype == 'MiND')
          {
            if($res->submission_date == null)
            {
              $date_entry =  date('M jS, Y',strtotime(date('Y-m-d H:i:s')));
            }
            else
            {
              $date_entry = date('M jS, Y',strtotime($res->submission_date));
            }
            
          }
          else
          {
            if($res->date_entry == null)
            {
              $date_entry =  date('M jS, Y',strtotime(date('Y-m-d H:i:s')));
            }
            else
            {
              $date_entry = date('M jS, Y',strtotime($res->date_entry));
            }
            
          }  

          $circle = ($stype == 'ACPP') ? $res->circle_code : $res->cir_code;

          $mouza_lot = $this->utilityclass->getMouzaName($res->dist_code, $res->subdiv_code, $circle, $res->mouza_pargona_code)."-".$this->utilityclass->getLotName($res->dist_code, $res->subdiv_code, $circle, $res->mouza_pargona_code, $res->lot_no);

          $village = $this->utilityclass->getVillageName($res->dist_code, $res->subdiv_code, $circle, $res->mouza_pargona_code, $res->lot_no, $res->vill_townprt_code);

          $caseNo = $this->utilityclass->encryptJwtCase($rows->case_no);
          $toUser = $this->utilityclass->encryptJwtCase($from_user);

          $link = base_url()."index.php/DcEscalationController/revertEscalatedCase?case_no=".$caseNo."&revert_to_user=".$toUser;

          $details = base_url()."index.php/DcEscalationController/viewCaseDetails?case_no=".$caseNo;

          $revert_back = "<a href='".$link."' class='btn btn-sm btn-danger'>Revert Back</a>";

          $button = $revert_back;

          $json[] = array(
            $rows->case_no."<br><span class='small font-italic red'>".$rtps_no."</span>",
            $mouza_lot,
            $village,
            $date_entry,          
            $button
          );
          $i++;
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
    catch(Exception $e) {
      echo 'Message: ' .$e->landingEscalatedViewPage();
    }
  }



}

