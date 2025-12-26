<?php
class CaseTransfer extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
        $this->load->model('patta/pattamodel');
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
        }
    }

    function index(){
        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $district['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name
        );
        $q="SElect use_name,user_code,dist_code,subdiv_code,cir_code from    loginuser_table where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and dis_enb_option='E' and user_code like 'CO%' and priv='adm' ";
        $district['colist']=$this->db->query($q)->result();
        //var_dump($district);
        // $this->load->view('../views/header');
        // $this->load->view('../views/transfer/index',$district);
        // $this->load->view('../views/footer');
        $district['_view'] = 'transfer/index';
        $this->load->view('layouts/main',$district);
    }

    function Update(){
        $db=  $this->session->userdata('db');
        $co_usercode=$this->input->post('user_code');
        $dist_code=$this->session->userdata('dist_code');
        $subdiv_code=$this->session->userdata('subdiv_code');
        $cir_code=$this->session->userdata('cir_code');
        $this->db->query("Update field_mut_basic set add_off_name='$co_usercode' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (order_passed!='Y' or is_dispose is null ) and year_no >='2017' ");
        $this->db->query("Update petition_basic set co_user_code='$co_usercode' , add_off_name='$co_usercode' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status='P' or status is null or status='H') and (co_user_code like 'CO%' or comp_serv_yn='Y') and year_no >='2017' ");
        $this->db->query("Update apcancel_petition_basic set add_off_name='$co_usercode' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and order_passed is null and year_no >='2017' ");
        $this->db->query("Update misc_case_basic set add_to_officer='$co_usercode' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status!='10' and year_no >='2017' ");
        // $this->db->query("Update settlement_basic set co_code='$co_usercode' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_officer='CO' and status in('W','R','X','C','M','N','D')");
        // $this->db->query("Update settlement_basic set co_code='$co_usercode' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status !='F'");
        $this->session->set_flashdata('message', "User updated!!!");
        redirect(base_url().'index.php/home');
    }


    // new case transfer by Masud
    public function getCaseTransferPage()
    {

        if(HOLD_All_MB2_CASES_STATUS == 1)
        {
            if(strtotime(HOLD_All_MB2_CASES_DATE) < strtotime(date('Y-m-d H:i:s')))
            {
                $this->session->set_flashdata('message', " Processing of settlement MB 2.0 Cases has been stopped !");
                redirect(base_url() . "index.php/Home/index");
            }
        }

        $db           = $this->session->userdata('db');
        $dist_code    = $this->session->userdata('dist_code');
        $subdiv_code  = $this->session->userdata('subdiv_code');
        $cir_code     = $this->session->userdata('cir_code');
        $dist_name    = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name     = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);

        $district['datas'] = array(
            'dist_code'    => $dist_code,
            'subdiv_code'  => $subdiv_code,
            'cir_code'     => $cir_code,
            'dist_name'    => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name'     => $cir_name
        );

        $q="Select use_name,user_code,dist_code,subdiv_code,cir_code from 
            loginuser_table where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and dis_enb_option='E' and user_code like 'CO%' and priv='adm' ";

        $district['colist']= $this->db->query($q)->result();


        $q1="Select use_name,user_code,dist_code,subdiv_code,cir_code from 
            loginuser_table where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and user_code like 'CO%' and priv='adm' ";

        $district['coListTo']= $this->db->query($q1)->result();


        $district['_view'] = 'transfer/get_case_transfer';

        $this->load->view('layouts/main',$district);
    }


    // cases assigning with selected CO
    public function casesAssigningToNewCo()
    {
        if(HOLD_All_MB2_CASES_STATUS == 1)
        {
            if(strtotime(HOLD_All_MB2_CASES_DATE) < strtotime(date('Y-m-d H:i:s')))
            {
                $this->session->set_flashdata('message', " Processing of settlement MB 2.0 Cases has been stopped !");
                redirect(base_url() . "index.php/Home/index");
            }
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_code', 'Cases pulling to ', 'trim|required');
        $this->form_validation->set_rules('circle_code_from', 'Cases pulling from ', 'trim|required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect(base_url() . "index.php/CaseTransfer/getCaseTransferPage");
        }

        $db           = $this->session->userdata('db');
        $dist_code    = $this->session->userdata('dist_code');
        $subdiv_code  = $this->session->userdata('subdiv_code');
        $cir_code     = $this->session->userdata('cir_code');
        $coAssignTo   = trim($this->input->post('user_code'));
        $coPullFrom   = trim($this->input->post('circle_code_from'));

        if($coPullFrom == $coAssignTo)
        {
            $this->session->set_flashdata('error', 'Please select pulling cases from properly');
            redirect(base_url() . "index.php/CaseTransfer/getCaseTransferPage");
        }

        $from       = $this->utilityclass->getSelectedCOName($dist_code,$subdiv_code,$cir_code,$coPullFrom);
        $to         = $this->utilityclass->getSelectedCOName($dist_code,$subdiv_code,$cir_code,$coAssignTo);
        $fromCoName = trim($from->username);
        $toCoName   = trim($to->username);

        $q ="Select case_no from settlement_basic
            where dist_code ='$dist_code' and subdiv_code ='$subdiv_code' and cir_code ='$cir_code' 
            and co_code ='$coPullFrom' and status not in ('D','F')";

        $allCases  = $this->db->query($q)->result();
        $caseCount = count($allCases);


        if($caseCount == 0 || $caseCount == '')
        {
            $this->session->set_flashdata('error', 'There is no cases assigning with CO');
            redirect(base_url() . "index.php/CaseTransfer/getCaseTransferPage");
        }


        $caseArray = '';
        $index = 0;
        foreach ($allCases as $singleCase)
        {
            if ($index == 0)
            {
                $caseArray = $caseArray."'".$singleCase->case_no."'";
            }
            else
            {
                $caseArray = $caseArray.",'".$singleCase->case_no."'";
            }
            $index++;
        }


        $q2 = "Select case_no, max(proceeding_id)+1 as pro_id from settlement_proceeding WHERE 
               case_no in ($caseArray)  group by case_no";

        $allProceeding = $this->db->query($q2)->result();
        $proCount = count($allProceeding);

        if($proCount == 0 || $proCount == '')
        {
            $this->session->set_flashdata('error', 'There is no cases assigning with CO');
            redirect(base_url() . "index.php/CaseTransfer/getCaseTransferPage");
        }

        // update settlement basic
        $updateBasic = array(
            'co_code' => $coAssignTo,
        );

        // update proceeding
        $proceedingUpdateArray = array();
        $proceedingInsert = [
            'date_of_hearing'      => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d h:i:s'),
            'operation'            => 'E',
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => 'CO',
            'office_to'            => 'CO',
            'task'                 => 'Case is Transferred / Pulled',
            'status'               => 'CT',
            'note_on_order'        => 'Case is Transferred / Pulled from '. $fromCoName .' to '. $toCoName,
        ];


        foreach ($allProceeding as $pro)
        {
            $proceedingInsert['case_no']       = $pro->case_no;
            $proceedingInsert['proceeding_id'] = $pro->pro_id;
            $proceedingUpdateArray[]           = $proceedingInsert;
        }

        $this->db->trans_begin();

        // batch update into settlement_basic
        $update_count = $this->updateBatch('settlement_basic', $updateBasic,
            'case_no',$caseArray);
        if($caseCount != $update_count)
        {
            $this->db->trans_rollback();
            log_message('error', "#MRCT001: Updation failed in settlement_basic for recommended, org_count: $caseCount , affected_count: $update_count ".$this->db->last_query());

            $this->session->set_flashdata('error', '#MRCT001: Case can not be transfer. Kindly contact system administrator');
            redirect(base_url() . "index.php/CaseTransfer/getCaseTransferPage");
        }

        // batch insert into settlement_proceeding
        $insert_count = $this->db->insert_batch('settlement_proceeding',$proceedingUpdateArray);
        if($caseCount != $insert_count)
        {
            $this->db->trans_rollback();
            log_message('error', '#MRCT002: INSERT failed in settlement_proceeding '.$this->db->last_query());

            $this->session->set_flashdata('error', '#MRCT002: Case can not be transfer. Kindly contact system administrator');
            redirect(base_url() . "index.php/CaseTransfer/getCaseTransferPage");
        }


        $this->db->trans_commit();
        $this->session->set_flashdata('success', 'All cases successfully transferred ');
        redirect(base_url() . "index.php/CaseTransfer/getCaseTransferPage");

    }


    // update batch Query
    public function updateBatch($table, $data, $where_filed, $where_array)
    {
        $sql = "update $table set ";

        foreach ($data as $key => $value) {
            $sql = $sql . ' ' . $key . '=\'' . $value . '\', ';
        }
        $sql = substr(trim($sql), 0, -1);
        $sql = $sql . ' where '.$where_filed.' in ('.$where_array.')';
        $this->db->query($sql);
        return $this->db->affected_rows();
    }






}