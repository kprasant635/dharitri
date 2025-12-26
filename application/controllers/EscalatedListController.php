<?php

class EscalatedListController extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('patta/pattamodel');
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->helper('file');
    $this->load->helper('download');
    $this->load->model('rtps/rtpsmodel');
    $this->load->model('Escalationmodel');
    $this->load->model('basundhara/basundharamodel');
    $this->load->model('AutoRegistrationmodel');
    $this->load->model('EscalationListModel');
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
    }
  }

  public function explodeCaseNo($case_no)
  {
    $get_case_no = explode('/', $case_no);
    $c_no = $get_case_no['4'];
    return $c_no;
  }

  public function loadEscalatedViewPage() 
  {    
    $this->dbswitch();
    $user_desig_code = $this->session->userdata('user_desig_code');
    $dist_code       = $this->session->userdata('dist_code');
    $subdiv_code     = $this->session->userdata('subdiv_code');
    $cir_code        = $this->session->userdata('cir_code');
    $user_code       = $this->session->userdata('user_code');
    $curr_date       = date('Y-m-d');
    $stype           = $this->utilityclass->decryptJwtCase($_GET['service']);

    $data['ast_data']  = $this->getEscalationFromAstToOtherUser($stype, 'AST');
    $data['sk_data']   = $this->getEscalationFromSkToOtherUser($stype, 'SK');
    $data['lm_data']   = $this->getEscalationFromLmToOtherUser($stype, 'LM');
    $data['co_data']   = $this->getEscalationFromCoToOtherUser($stype, 'CO');
    $data['adc_data']  = $this->getEscalationFromAdcToOtherUser($stype, 'ADC');
    $data['dc_data']   = $this->getEscalationFromDcToOtherUser($stype, 'DC');
    $data['bo_data']   = $this->getEscalationFromBoToOtherUser($stype, 'BO');
    $data['dept_data'] = $this->getEscalationFromDeptToOtherUser($stype, 'DEPT');

    $data['revert_ast_data']  = $this->getRevertedCasesFromAstToOtherUser($stype, 'AST');
    $data['revert_sk_data']   = $this->getRevertedCasesFromSkToOtherUser($stype, 'SK');
    $data['revert_lm_data']   = $this->getRevertedCasesFromLmToOtherUser($stype, 'LM');
    $data['revert_co_data']   = $this->getRevertedCasesFromCoToOtherUser($stype, 'CO');
    $data['revert_adc_data']  = $this->getRevertedCasesFromAdcToOtherUser($stype, 'ADC');
    $data['revert_dc_data']   = $this->getRevertedCasesFromDcToOtherUser($stype, 'DC');
    $data['revert_bo_data']   = $this->getRevertedCasesFromBoToOtherUser($stype, 'BO');
    $data['revert_dept_data'] = $this->getRevertedCasesFromDeptToOtherUser($stype, 'DEPT');

    $data['_view'] = 'common/escalated_pending_list_details';
    $this->load->view('layouts/main',$data);
  }

  public function getPendingEscalatedCasesByUser()
  {
    $from_user     = $this->input->post('from_user');
    $to_user       = $this->input->post('to_user');
    $stype         = $this->input->post('stype');

    $draw          = intval($this->input->post('draw'));
    $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
    $start         = intval($this->input->post('start'));
    $length        = intval($this->input->post('length'));
    $order         = $this->input->post('order');    
    log_message('error',"AS:".$stype."------".$from_user."---------".$to_user);

    if($from_user == "AST")
    {
      $detail = $this->EscalationListModel->getPendingEscalationCountFromAST($stype, $from_user, $to_user); 
    }
    else
    {
      $detail = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, $to_user); 
    }
       
    log_message('error', 'Detail from escalation_details: '.$this->db->last_query());

    if($detail->num_rows() > 0)
    {
      $records = $detail->result();

      foreach($records as $rows)
      {
        $circle_code = $rows->service_code == 5 ? 'circle_code' : 'cir_code'; // allotment
        
        $rtps_no = $this->EscalationListModel->getFromBasundharApplByCaseNo($rows->case_no);
        log_message('error', 'Rtps No: '.$rtps_no);

        $res = $this->EscalationListModel->getFromMasterBasicTable($stype, $rows->case_no)->row();

        $date_entry = date('M jS, Y',strtotime($rows->registerd_on));

        $mouza_lot = $this->utilityclass->getMouzaName($res->dist_code, $res->subdiv_code, $res->$circle_code, $res->mouza_pargona_code)."-".$this->utilityclass->getLotName($res->dist_code, $res->subdiv_code, $res->$circle_code, $res->mouza_pargona_code, $res->lot_no);

        $village = $this->utilityclass->getVillageName($res->dist_code, $res->subdiv_code, $res->$circle_code, $res->mouza_pargona_code, $res->lot_no, $res->vill_townprt_code);

        $caseNo = $this->utilityclass->encryptJwtCase($rows->case_no);
        $toUser = $this->utilityclass->encryptJwtCase($from_user);
        
        $fromUser = $this->utilityclass->encryptJwtCase($to_user);

        if($from_user == "AST")
        {
          $link = base_url()."index.php/AutoEscalationRevertController/revertReportToAst?case_no=".$caseNo."&revert_to_user=".$toUser."&fromUser=".$fromUser;
        }
        else
        {
          $link = base_url()."index.php/AutoEscalationRevertController/revertReport?case_no=".$caseNo."&revert_to_user=".$toUser."&fromUser=".$fromUser;
        }

        $revert_back = "<a href='".$link."' class='btn btn-sm btn-danger'>Revert Back</a>";

        $json[] = array(

          $rows->case_no."<br><span class='small font-italic red'>".$rtps_no."</span>",
          $mouza_lot,
          $village,
          $date_entry,          
          $revert_back
        );
      }
    }
    else {
      $json = "";
      $response = array();
      $response['sEcho']=0;
      $response['iTotalRecords']=0;
      $response['iTotalDisplayRecords']=0;
      $response['aaData']=[];
      log_message('error', 'For empty data: '.json_encode($response));
      echo json_encode($response);
      return;
    }
    $response = array(
      'draw'              => $draw,
      'recordsTotal'      => $detail->num_rows(),
      'recordsFiltered'   => $detail->num_rows(),
      'data'              => $json
    );
    echo json_encode($response);
    return;
  }

  // escalated FROM user list
  public function getPendingEscalatedFromUser()
  {
    $data['service_type']    = $this->input->post('service_type');
    $data['user_desig_code'] = $this->input->post('from_user');
    $data['ast_data']        = $this->input->post('ast_data');
    $data['sk_data']         = $this->input->post('sk_data');
    $data['lm_data']         = $this->input->post('lm_data');
    $data['co_data']         = $this->input->post('co_data');
    $data['adc_data']        = $this->input->post('adc_data');
    $data['dc_data']         = $this->input->post('dc_data');
    $data['bo_data']         = $this->input->post('bo_data');
    $data['dept_data']       = $this->input->post('dept_data');

    $this->load->view('common/escalated_from_user_wise_list',$data);
  }

  // escalated TO user list
  public function getPendingEscalatedToUser()
  {
    $data['service_type']    = $this->input->post('service_type');
    $data['user_desig_code'] = $this->input->post('from_user');
    $data['ast_data']        = $this->input->post('ast_data');
    $data['sk_data']         = $this->input->post('sk_data');
    $data['lm_data']         = $this->input->post('lm_data');
    $data['co_data']         = $this->input->post('co_data');
    $data['adc_data']        = $this->input->post('adc_data');
    $data['dc_data']         = $this->input->post('dc_data');
    $data['bo_data']         = $this->input->post('bo_data');
    $data['dept_data']       = $this->input->post('dept_data');

    $this->load->view('common/escalated_to_user_wise_list',$data);
  }

  // from lm to other user
  public function getEscalationFromLmToOtherUser($stype, $from_user)
  {
    $json = null;

    // from lm to ast
    $lm_to_ast = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'AST');

    // from lm to sk
    $lm_to_sk = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'SK');

    // from lm to co
    $lm_to_co = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'CO');
    // var_dump($lm_to_co); 
    // var_dump($from_user); 

    // from lm to adc
    $lm_to_adc = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'ADC');

    // from lm to dc
    $lm_to_dc = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'DC');

    // from lm to bo
    $lm_to_bo = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'BO');

    // from lm to dept
    $lm_to_dept = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'DEPT');

    $json = [
      'lm_to_ast'  => $lm_to_ast->num_rows()==null ? 0 : $lm_to_ast->num_rows(),
      'lm_to_lm'   => 0,
      'lm_to_sk'   => $lm_to_sk->num_rows()==null ? 0 : $lm_to_sk->num_rows(),
      'lm_to_co'   => $lm_to_co->num_rows()==null ? 0 : $lm_to_co->num_rows(),
      'lm_to_adc'  => $lm_to_adc->num_rows()==null ? 0 : $lm_to_adc->num_rows(),
      'lm_to_dc'   => $lm_to_dc->num_rows()==null ? 0 : $lm_to_dc->num_rows(),
      'lm_to_bo'   => $lm_to_bo->num_rows()==null ? 0 : $lm_to_bo->num_rows(),
      'lm_to_dept' => $lm_to_dept->num_rows()==null ? 0 : $lm_to_dept->num_rows(),
    ];

    log_message('error', '#227 FROM_LM_TO_OTHER '.json_encode($json));
    return json_encode($json);
  }

  // from ast to other user
  public function getEscalationFromAstToOtherUser($stype, $from_user)
  {
    $json = null;

    // from ast to lm
    $ast_to_lm = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'LM');

    // from ast to sk
    $ast_to_sk = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'SK');

    // from ast to co
    $ast_to_co = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'CO');

    // from ast to adc
    $ast_to_adc = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'ADC');

    // from ast to dc
    $ast_to_dc = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'DC');

    // from ast to bo
    $ast_to_bo = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'BO');

    // from ast to dept
    $ast_to_dept = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'DEPT');

    $json = [
      'ast_to_ast'  => 0,
      'ast_to_lm'   => $ast_to_lm->num_rows()==null ? 0 : $ast_to_lm->num_rows(),
      'ast_to_sk'   => $ast_to_sk->num_rows()==null ? 0 : $ast_to_sk->num_rows(),
      'ast_to_co'   => $ast_to_co->num_rows()==null ? 0 : $ast_to_co->num_rows(),
      'ast_to_adc'  => $ast_to_adc->num_rows()==null ? 0 : $ast_to_adc->num_rows(),
      'ast_to_dc'   => $ast_to_dc->num_rows()==null ? 0 : $ast_to_dc->num_rows(),
      'ast_to_bo'   => $ast_to_bo->num_rows()==null ? 0 : $ast_to_bo->num_rows(),
      'ast_to_dept' => $ast_to_dept->num_rows()==null ? 0 : $ast_to_dept->num_rows(),
    ];

    log_message('error', '#268 FROM_AST_TO_OTHER '.json_encode($json));
    return json_encode($json);
  } 

  // from sk to other user
  public function getEscalationFromSkToOtherUser($stype, $from_user)
  {
    $json = null;

    // from sk to ast
    $sk_to_ast = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'AST');

    // from sk to lm
    $sk_to_lm = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'LM');

    // from sk to co
    $sk_to_co = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'CO');

    // from sk to adc
    $sk_to_adc = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'ADC');

    // from sk to dc
    $sk_to_dc = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'DC');

    // from sk to bo
    $sk_to_bo = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'BO');

    // from sk to dept
    $sk_to_dept = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'DEPT');

    $json = [
      'sk_to_ast'  => $sk_to_ast->num_rows()==null ? 0 : $sk_to_ast->num_rows(),
      'sk_to_lm'   => $sk_to_lm->num_rows()==null ? 0 : $sk_to_lm->num_rows(),
      'sk_to_sk'   => 0,
      'sk_to_co'   => $sk_to_co->num_rows()==null ? 0 : $sk_to_co->num_rows(),
      'sk_to_adc'  => $sk_to_adc->num_rows()==null ? 0 : $sk_to_adc->num_rows(),
      'sk_to_dc'   => $sk_to_dc->num_rows()==null ? 0 : $sk_to_dc->num_rows(),
      'sk_to_bo'   => $sk_to_bo->num_rows()==null ? 0 : $sk_to_bo->num_rows(),
      'sk_to_dept' => $sk_to_dept->num_rows()==null ? 0 : $sk_to_dept->num_rows(),
    ];

    log_message('error', '#309 FROM_SK_TO_OTHER '.json_encode($json));
    return json_encode($json);
  } 

  // from co to other user
  public function getEscalationFromCoToOtherUser($stype, $from_user)
  {
    $json = null;

    // from co to ast
    $co_to_ast = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'AST');

    // from co to sk
    $co_to_sk = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'SK');

    // from co to lm
    $co_to_lm = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'LM');    

    // from co to adc
    $co_to_adc = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'ADC');

    // from co to dc
    $co_to_dc = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'DC');

    // from co to bo
    $co_to_bo = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'BO');

    // from co to dept
    $co_to_dept = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'DEPT');

    $json = [
      'co_to_ast'  => $co_to_ast->num_rows()==null ? 0 : $co_to_ast->num_rows(),
      'co_to_lm'   => $co_to_lm->num_rows()==null ? 0 : $co_to_lm->num_rows(),
      'co_to_sk'   => $co_to_sk->num_rows()==null ? 0 : $co_to_sk->num_rows(),
      'co_to_co'   => 0,
      'co_to_adc'  => $co_to_adc->num_rows()==null ? 0 : $co_to_adc->num_rows(),
      'co_to_dc'   => $co_to_dc->num_rows()==null ? 0 : $co_to_dc->num_rows(),
      'co_to_bo'   => $co_to_bo->num_rows()==null ? 0 : $co_to_bo->num_rows(),
      'co_to_dept' => $co_to_dept->num_rows()==null ? 0 : $co_to_dept->num_rows(),
    ];

    log_message('error', '#350 FROM_CO_TO_OTHER '.json_encode($json));
    return json_encode($json);
  } 

  // from adc to other user
  public function getEscalationFromAdcToOtherUser($stype, $from_user)
  {
    $json = null;

    // from adc to ast
    $adc_to_ast = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'AST');

    // from adc to sk
    $adc_to_sk = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'SK');

    // from adc to lm
    $adc_to_lm = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'LM');    

    // from adc to co
    $adc_to_co = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'CO');

    // from adc to dc
    $adc_to_dc = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'DC');

    // from adc to bo
    $adc_to_bo = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'BO');

    // from adc to dept
    $adc_to_dept = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'DEPT');

    $json = [
      'adc_to_ast'  => $adc_to_ast->num_rows()==null ? 0 : $adc_to_ast->num_rows(),
      'adc_to_lm'   => $adc_to_lm->num_rows()==null ? 0 : $adc_to_lm->num_rows(),
      'adc_to_sk'   => $adc_to_sk->num_rows()==null ? 0 : $adc_to_sk->num_rows(),
      'adc_to_co'   => $adc_to_co->num_rows()==null ? 0 : $adc_to_co->num_rows(),
      'adc_to_adc'  => 0,
      'adc_to_dc'   => $adc_to_dc->num_rows()==null ? 0 : $adc_to_dc->num_rows(),
      'adc_to_bo'   => $adc_to_bo->num_rows()==null ? 0 : $adc_to_bo->num_rows(),
      'adc_to_dept' => $adc_to_dept->num_rows()==null ? 0 : $adc_to_dept->num_rows(),
    ];

    log_message('error', '#391 FROM_ADC_TO_OTHER '.json_encode($json));
    return json_encode($json);
  }

  // from dc to other user
  public function getEscalationFromDcToOtherUser($stype, $from_user)
  {
    $json = null;

    // from dc to ast
    $dc_to_ast = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'AST');

    // from dc to sk
    $dc_to_sk = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'SK');

    // from dc to lm
    $dc_to_lm = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'LM');    

    // from dc to co
    $dc_to_co = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'CO');

    // from dc to adc
    $dc_to_adc = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'ADC');

    // from dc to bo
    $dc_to_bo = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'BO');

    // from dc to dept
    $dc_to_dept = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'DEPT');

    $json = [
      'dc_to_ast'  => $dc_to_ast->num_rows()==null ? 0 : $dc_to_ast->num_rows(),
      'dc_to_lm'   => $dc_to_lm->num_rows()==null ? 0 : $dc_to_lm->num_rows(),
      'dc_to_sk'   => $dc_to_sk->num_rows()==null ? 0 : $dc_to_sk->num_rows(),
      'dc_to_co'   => $dc_to_co->num_rows()==null ? 0 : $dc_to_co->num_rows(),
      'dc_to_adc'  => $dc_to_adc->num_rows()==null ? 0 : $dc_to_adc->num_rows(),
      'dc_to_dc'   => 0,
      'dc_to_bo'   => $dc_to_bo->num_rows()==null ? 0 : $dc_to_bo->num_rows(),
      'dc_to_dept' => $dc_to_dept->num_rows()==null ? 0 : $dc_to_dept->num_rows(),
    ];

    log_message('error', '#432 FROM_DC_TO_OTHER '.json_encode($json));
    return json_encode($json);
  }

  // from bo to other user
  public function getEscalationFromBoToOtherUser($stype, $from_user)
  {
    $json = null;

    // from bo to ast
    $bo_to_ast = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'AST');

    // from bo to sk
    $bo_to_sk = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'SK');

    // from bo to lm
    $bo_to_lm = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'LM');    

    // from bo to co
    $bo_to_co = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'CO');

    // from bo to dc
    $bo_to_adc = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'ADC');

    // from bo to dc
    $bo_to_dc = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'DC');

    // from bo to dept
    $bo_to_dept = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'DEPT');

    $json = [
      'bo_to_ast'  => $bo_to_ast->num_rows()==null ? 0 : $bo_to_ast->num_rows(),
      'bo_to_lm'   => $bo_to_lm->num_rows()==null ? 0 : $bo_to_lm->num_rows(),
      'bo_to_sk'   => $bo_to_sk->num_rows()==null ? 0 : $bo_to_sk->num_rows(),
      'bo_to_co'   => $bo_to_co->num_rows()==null ? 0 : $bo_to_co->num_rows(),
      'bo_to_adc'  => $bo_to_adc->num_rows()==null ? 0 : $bo_to_adc->num_rows(),
      'bo_to_dc'   => $bo_to_dc->num_rows()==null ? 0 : $bo_to_dc->num_rows(),
      'bo_to_bo'   => 0,
      'bo_to_dept' => $bo_to_dept->num_rows()==null ? 0 : $bo_to_dept->num_rows(),
    ];

    log_message('error', '#473 FROM_BO_TO_OTHER '.json_encode($json));
    return json_encode($json);
  }

  // from dept to other user
  public function getEscalationFromDeptToOtherUser($stype, $from_user)
  {
    $json = null;

    // from dept to ast
    $dept_to_ast = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'AST');

    // from dept to sk
    $dept_to_sk = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'SK');

    // from dept to lm
    $dept_to_lm = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'LM');    

    // from dept to co
    $dept_to_co = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'CO');

    // from dept to dc
    $dept_to_adc = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'ADC');

    // from dept to dc
    $dept_to_dc = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'DC');

    // from dept to bo
    $dept_to_bo = $this->EscalationListModel->getPendingEscalationCountBetweenFromAndToUser($stype, $from_user, 'BO');

    $json = [
      'dept_to_ast'  => $dept_to_ast->num_rows()==null ? 0 : $dept_to_ast->num_rows(),
      'dept_to_lm'   => $dept_to_lm->num_rows()==null ? 0 : $dept_to_lm->num_rows(),
      'dept_to_sk'   => $dept_to_sk->num_rows()==null ? 0 : $dept_to_sk->num_rows(),
      'dept_to_co'   => $dept_to_co->num_rows()==null ? 0 : $dept_to_co->num_rows(),
      'dept_to_adc'  => $dept_to_adc->num_rows()==null ? 0 : $dept_to_adc->num_rows(),
      'dept_to_dc'   => $dept_to_dc->num_rows()==null ? 0 : $dept_to_dc->num_rows(),
      'dept_to_bo'   => $dept_to_bo->num_rows()==null ? 0 : $dept_to_bo->num_rows(),
      'dept_to_dept' => 0,
    ];

    log_message('error', '#514 FROM_DEPT_TO_OTHER '.json_encode($json));
    return json_encode($json);
  }


  // reverted from user list
  public function getPendingRevertedFromUser()
  {
    $data['service_type']    = $this->input->post('service_type');
    $data['user_desig_code'] = $this->input->post('from_user');
    $data['ast_data']        = $this->input->post('ast_data');
    $data['sk_data']         = $this->input->post('sk_data');
    $data['lm_data']         = $this->input->post('lm_data');
    $data['co_data']         = $this->input->post('co_data');
    $data['adc_data']        = $this->input->post('adc_data');
    $data['dc_data']         = $this->input->post('dc_data');
    $data['bo_data']         = $this->input->post('bo_data');
    $data['dept_data']       = $this->input->post('dept_data');

    $this->load->view('common/reverted_from_user_wise_list',$data);
  }

  public function getPendingRevertedCasesByUser()
  {
    // var_dump($_POST); die;


    $from_user     = $this->input->post('from_user');
    $to_user       = $this->input->post('to_user');
    $stype         = $this->input->post('stype');

    $draw          = intval($this->input->post('draw'));
    $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
    $start         = intval($this->input->post('start'));
    $length        = intval($this->input->post('length'));
    $order         = $this->input->post('order');    

    $detail = $this->EscalationListModel->getPendingRevertedCountBetweenFromAndToUser($stype, $from_user, $to_user);    
    // log_message('error', '#LOG582: revert_escalation_details: '.$this->db->last_query());
    // die;

    if($detail->num_rows() > 0)
    {
      $records = $detail->result();

      foreach($records as $rows)
      {
        $rtps_no = $this->EscalationListModel->getFromBasundharApplByCaseNo($rows->case_no);
        // log_message('error', 'Rtps No: '.$rtps_no);

        $res = $this->EscalationListModel->getFromMasterBasicTable($stype, $rows->case_no)->row();
        $date_entry = date('M jS, Y',strtotime($res->date_entry));

        $mouza_lot = $this->utilityclass->getMouzaName($res->dist_code, $res->subdiv_code, $res->cir_code, $res->mouza_pargona_code)."-".$this->utilityclass->getLotName($res->dist_code, $res->subdiv_code, $res->cir_code, $res->mouza_pargona_code, $res->lot_no);

        $village = $this->utilityclass->getVillageName($res->dist_code, $res->subdiv_code, $res->cir_code, $res->mouza_pargona_code, $res->lot_no, $res->vill_townprt_code);

        $caseNo = $this->utilityclass->encryptJwtCase($rows->case_no);
        $toUser = $this->utilityclass->encryptJwtCase($from_user);
        
        $fromUser = $this->utilityclass->encryptJwtCase($to_user);

        $link = base_url()."index.php/AutoEscalationRevertController/revertToAppellateUser?case_no=".$caseNo."&revert_to_user=".$toUser."&fromUser=".$fromUser;

        $revert_back = "<a href='".$link."' class='btn btn-sm btn-danger'>Revert Back</a>";

        $json[] = array(
          $rows->case_no."<br><span class='small font-italic red'>".$rtps_no."</span>",
          $mouza_lot,
          $village,
          $date_entry,          
          $revert_back
        );
      }
    }
    else {
      $json = "";
      $response = array();
      $response['sEcho']=0;
      $response['iTotalRecords']=0;
      $response['iTotalDisplayRecords']=0;
      $response['aaData']=[];
      log_message('error', 'For empty data: '.json_encode($response));
      echo json_encode($response);
      return;
    }
    $response = array(
      'draw'              => $draw,
      'recordsTotal'      => $detail->num_rows(),
      'recordsFiltered'   => $detail->num_rows(),
      'data'              => $json
    );
    echo json_encode($response);
    return;
  }


  // from ast to other user
  public function getRevertedCasesFromAstToOtherUser($stype, $from_user)
  {
    $json = null;

    $json = [
      'from_ast_to_ast'  => 0,
      'from_ast_to_lm'   => 0,
      'from_ast_to_sk'   => 0,
      'from_ast_to_co'   => 0,
      'from_ast_to_adc'  => 0,
      'from_ast_to_dc'   => 0,
      'from_ast_to_bo'   => 0,
      'from_ast_to_dept' => 0,
    ];

    log_message('error', '#677 FROM_AST_TO_OTHER '.json_encode($json));
    return json_encode($json);
  }

  // from lm to other user
  public function getRevertedCasesFromLmToOtherUser($stype, $from_user)
  {
    $json = null;

    // from lm to ast
    $from_lm_to_ast = $this->EscalationListModel->getPendingRevertedCountBetweenFromAndToUser($stype, $from_user, 'AST');

    $json = [
      'from_lm_to_ast'  => $from_lm_to_ast->num_rows()==null ? 0 : $from_lm_to_ast->num_rows(),
      'from_lm_to_lm'   => 0,
      'from_lm_to_sk'   => 0,
      'from_lm_to_co'   => 0,
      'from_lm_to_adc'  => 0,
      'from_lm_to_dc'   => 0,
      'from_lm_to_bo'   => 0,
      'from_lm_to_dept' => 0,
    ];

    log_message('error', '#681 FROM_LM_TO_OTHER '.json_encode($json));
    return json_encode($json);
  }


  // from co to other user
  public function getRevertedCasesFromCoToOtherUser($stype, $from_user)
  {
    $json = null;

    // from CO to ast
    $from_co_to_ast = $this->EscalationListModel->getPendingRevertedCountBetweenFromAndToUser($stype, $from_user, 'AST');

    // from CO to LM
    $from_co_to_lm = $this->EscalationListModel->getPendingRevertedCountBetweenFromAndToUser($stype, $from_user, 'LM');

    // from CO to SK
    $from_co_to_sk = $this->EscalationListModel->getPendingRevertedCountBetweenFromAndToUser($stype, $from_user, 'LM');

    $json = [
      'from_co_to_ast'  => $from_co_to_ast->num_rows()==null ? 0 : $from_co_to_ast->num_rows(),
      'from_co_to_lm'   => $from_co_to_lm->num_rows()==null ? 0 : $from_co_to_lm->num_rows(),
      'from_co_to_sk'   => $from_co_to_sk->num_rows()==null ? 0 : $from_co_to_sk->num_rows(),
      'from_co_to_co'   => 0,
      'from_co_to_adc'  => 0,
      'from_co_to_dc'   => 0,
      'from_co_to_bo'   => 0,
      'from_co_to_dept' => 0,
    ];

    log_message('error', '#709 FROM_CO_TO_OTHER '.json_encode($json));
    return json_encode($json);
  }


  // from sk to other user
  public function getRevertedCasesFromSkToOtherUser($stype, $from_user)
  {
    $json = null;

    // from sk to ast
    $from_sk_to_ast = $this->EscalationListModel->getPendingRevertedCountBetweenFromAndToUser($stype, $from_user, 'AST');

    $json = [
      'from_sk_to_ast'  => $from_sk_to_ast->num_rows()==null ? 0 : $from_sk_to_ast->num_rows(),
      'from_sk_to_lm'   => 0,
      'from_sk_to_sk'   => 0,
      'from_sk_to_co'   => 0,
      'from_sk_to_adc'  => 0,
      'from_sk_to_dc'   => 0,
      'from_sk_to_bo'   => 0,
      'from_sk_to_dept' => 0,
    ];

    log_message('error', '#709 FROM_CO_TO_OTHER '.json_encode($json));
    return json_encode($json);
  }


  // from adc to other user
  public function getRevertedCasesFromAdcToOtherUser($stype, $from_user)
  {
    $json = null;

    // from adc to ast
    $from_adc_to_ast = $this->EscalationListModel->getPendingRevertedCountBetweenFromAndToUser($stype, $from_user, 'AST');

    // from adc to lm
    $from_adc_to_lm = $this->EscalationListModel->getPendingRevertedCountBetweenFromAndToUser($stype, $from_user, 'LM');

    // from adc to sk
    $from_adc_to_sk = $this->EscalationListModel->getPendingRevertedCountBetweenFromAndToUser($stype, $from_user, 'SK');

    // from adc to co
    $from_adc_to_co = $this->EscalationListModel->getPendingRevertedCountBetweenFromAndToUser($stype, $from_user, 'CO');

    $json = [
      'from_adc_to_ast'  => $from_adc_to_ast->num_rows()==null ? 0 : $from_adc_to_ast->num_rows(),
      'from_adc_to_lm'   => $from_adc_to_lm->num_rows()==null ? 0 : $from_adc_to_lm->num_rows(),
      'from_adc_to_sk'   => $from_adc_to_sk->num_rows()==null ? 0 : $from_adc_to_sk->num_rows(),
      'from_adc_to_co'   => $from_adc_to_co->num_rows()==null ? 0 : $from_adc_to_co->num_rows(),
      'from_adc_to_adc'  => 0,
      'from_adc_to_dc'   => 0,
      'from_adc_to_bo'   => 0,
      'from_adc_to_dept' => 0,
    ];

    log_message('error', '#766 FROM_ADC_TO_OTHER '.json_encode($json));
    return json_encode($json);
  }


  // from dc to other user
  public function getRevertedCasesFromDcToOtherUser($stype, $from_user)
  {
    $json = null;

    // from dc to ast
    $from_dc_to_ast = $this->EscalationListModel->getPendingRevertedCountBetweenFromAndToUser($stype, $from_user, 'AST');

    // from dc to lm
    $from_dc_to_lm = $this->EscalationListModel->getPendingRevertedCountBetweenFromAndToUser($stype, $from_user, 'LM');

    // from dc to sk
    $from_dc_to_sk = $this->EscalationListModel->getPendingRevertedCountBetweenFromAndToUser($stype, $from_user, 'SK');

    // from dc to co
    $from_dc_to_co = $this->EscalationListModel->getPendingRevertedCountBetweenFromAndToUser($stype, $from_user, 'CO');

    // echo $this->db->last_query(); die;

    // from dc to adc
    $from_dc_to_adc = $this->EscalationListModel->getPendingRevertedCountBetweenFromAndToUser($stype, $from_user, 'ADC');

    $json = [
      'from_dc_to_ast'  => $from_dc_to_ast->num_rows()==null ? 0 : $from_dc_to_ast->num_rows(),
      'from_dc_to_lm'   => $from_dc_to_lm->num_rows()==null ? 0 : $from_dc_to_lm->num_rows(),
      'from_dc_to_sk'   => $from_dc_to_sk->num_rows()==null ? 0 : $from_dc_to_sk->num_rows(),
      'from_dc_to_co'   => $from_dc_to_co->num_rows()==null ? 0 : $from_dc_to_co->num_rows(),
      'from_dc_to_adc'  => $from_dc_to_adc->num_rows()==null ? 0 : $from_dc_to_adc->num_rows(),
      'from_dc_to_dc'   => 0,
      'from_dc_to_bo'   => 0,
      'from_dc_to_dept' => 0,
    ];

    log_message('error', '#802 FROM_DC_TO_OTHER '.json_encode($json));
    return json_encode($json);
  }


  // from bo to other user
  public function getRevertedCasesFromBoToOtherUser($stype, $from_user)
  {
    $json = null;

    // from bo to ast
    $from_bo_to_ast = $this->EscalationListModel->getPendingRevertedCountBetweenFromAndToUser($stype, $from_user, 'AST');

    // from bo to LM
    $from_bo_to_lm = $this->EscalationListModel->getPendingRevertedCountBetweenFromAndToUser($stype, $from_user, 'LM');

    // from bo to SK
    $from_bo_to_sk = $this->EscalationListModel->getPendingRevertedCountBetweenFromAndToUser($stype, $from_user, 'LM');

    $json = [
      'from_bo_to_ast'  => $from_bo_to_ast->num_rows()==null ? 0 : $from_bo_to_ast->num_rows(),
      'from_bo_to_lm'   => $from_bo_to_lm->num_rows()==null ? 0 : $from_bo_to_lm->num_rows(),
      'from_bo_to_sk'   => $from_bo_to_sk->num_rows()==null ? 0 : $from_bo_to_sk->num_rows(),
      'from_bo_to_co'   => 0,
      'from_bo_to_adc'  => 0,
      'from_bo_to_dc'   => 0,
      'from_bo_to_bo'   => 0,
      'from_bo_to_dept' => 0,
    ];

    log_message('error', '#709 FROM_CO_TO_OTHER '.json_encode($json));
    return json_encode($json);
  }


  // from dept to other user
  public function getRevertedCasesFromDeptToOtherUser($stype, $from_user)
  {
    $json = null;

    // from dept to ast
    $from_dept_to_ast = $this->EscalationListModel->getPendingRevertedCountBetweenFromAndToUser($stype, $from_user, 'AST');

    // from dept to lm
    $from_dept_to_lm = $this->EscalationListModel->getPendingRevertedCountBetweenFromAndToUser($stype, $from_user, 'LM');

    // from dept to sk
    $from_dept_to_sk = $this->EscalationListModel->getPendingRevertedCountBetweenFromAndToUser($stype, $from_user, 'SK');

    // from dept to co
    $from_dept_to_co = $this->EscalationListModel->getPendingRevertedCountBetweenFromAndToUser($stype, $from_user, 'CO');

    // from dept to adc
    $from_dept_to_adc = $this->EscalationListModel->getPendingRevertedCountBetweenFromAndToUser($stype, $from_user, 'ADC');

    // from dept to dc
    $from_dept_to_dc = $this->EscalationListModel->getPendingRevertedCountBetweenFromAndToUser($stype, $from_user, 'DC');

    // from dept to bo
    $from_dept_to_bo = $this->EscalationListModel->getPendingRevertedCountBetweenFromAndToUser($stype, $from_user, 'BO');

    $json = [
      'from_dept_to_ast'  => $from_dept_to_ast->num_rows()==null ? 0 : $from_dept_to_ast->num_rows(),
      'from_dept_to_lm'   => $from_dept_to_lm->num_rows()==null ? 0 : $from_dept_to_lm->num_rows(),
      'from_dept_to_sk'   => $from_dept_to_sk->num_rows()==null ? 0 : $from_dept_to_sk->num_rows(),
      'from_dept_to_co'   => $from_dept_to_co->num_rows()==null ? 0 : $from_dept_to_co->num_rows(),
      'from_dept_to_adc'  => $from_dept_to_adc->num_rows()==null ? 0 : $from_dept_to_adc->num_rows(),
      'from_dept_to_dc'   => $from_dept_to_dc->num_rows()==null ? 0 : $from_dept_to_dc->num_rows(),
      'from_dept_to_bo'   => $from_dept_to_bo->num_rows()==null ? 0 : $from_dept_to_bo->num_rows(),
      'from_dept_to_dept' => 0,
    ];

    log_message('error', '#841 FROM_DEPT_TO_OTHER '.json_encode($json));
    return json_encode($json);
  }


}
?>