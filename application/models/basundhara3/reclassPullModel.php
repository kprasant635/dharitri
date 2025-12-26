<?php
class reclassPullModel extends CI_Model
{

    function __construct()
    {
        parent::__construct();

    }


    public function caseListUnderMappingLot()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        //////////////////MARKING FOR CIRCLE WISE LOT MAPPING===========
        $sql="Select user_code from loginuser_table where dist_code=? and subdiv_code=? and cir_code=? and dis_enb_option='E' and user_code like 'CO%'";
        $data=$this->db->query($sql,array($dist_code,$subdiv_code,$cir_code));
        $lot_array = array();
        if($data->num_rows()> 1){
            $sql1="Select * from user_attached_mapping where dist_code=? and subdiv_code=? and cir_code=? and user_code=? ";
            $data1=$this->db->query($sql1,array($dist_code,$subdiv_code,$cir_code,$user_code));

            foreach ($data1->result() as $key => $value) {
                $lot_array[] = $value->mouza_pargona_code.'_'.$value->lot_no;
            }
            //////////////////
        }
        $lot_string = null;
        if(!empty($lot_array) && $lot_array!=null)
        {
            $lot_string = $this->convertLiteral($lot_array);
        }
        log_message("error","MB002: LOT STRING====FOR CIRCLE==D".$dist_code."S".$subdiv_code."C".$cir_code."==".json_encode($lot_string));
        return $lot_string;
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


    // get location for CO
    public function locationSelectPullRequest($service_code, $status)
    {

        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code    = $this->session->userdata('cir_code');
        $Query = "";

        if(LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO')
        {
            $lot_string = $this->caseListUnderMappingLot();
            if($lot_string != null )
            {
                $Query = " AND mouza_pargona_code ||'_' || lot_no in ($lot_string) ";
            }

        }

        $sql = "SELECT vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no FROM settlement_basic WHERE service_code = $service_code AND status != '$status' AND dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$cir_code' $Query GROUP BY vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no";


        $data = $this->db->query($sql);
        return $data->result();

    }


    // get location for SDO
    public function locationSelectPullRequestWithOutStatusSDO($service_code)
    {

        $dist_code   = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $Query = "";

        $sql = "SELECT vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no FROM settlement_basic WHERE dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' GROUP BY vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no";

        $data = $this->db->query($sql);
        return $data->result();

    }


    // get location for SDO
    public function locationSelectPullRequestWithOutStatusADC($service_code)
    {

        $dist_code   = $this->session->userdata('dist_code');
        $Query = "";

        $sql = "SELECT vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no FROM settlement_basic WHERE dist_code = '$dist_code' GROUP BY vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no";

        $data = $this->db->query($sql);
        return $data->result();

    }


    // get location for SDO
    public function locationSelectPullRequestWithOutStatusDC()
    {

        $dist_code   = $this->session->userdata('dist_code');
        $Query = "";

        $sql = "SELECT vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no FROM settlement_basic WHERE dist_code = '$dist_code' GROUP BY vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no";

        $data = $this->db->query($sql);
        return $data->result();

    }


    // get Settlement Basic Details by case no
    public function getSettlementBasicDetails($caseNo)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->get('reclass_suite_basic')
            ->row();
    }


    // get all settlement basic
    public function getSettlementBasicReCla($case)
    {
        $basic = $this->db->select()
            ->where('case_no',$case)
            ->get('reclass_suite_basic');
        return $basic->row_array();
    }


    // Count CO Modification Request Cases For SDO
    public function countCoModificationRequestCaseForSDO($dist_code,$subDiv_code,$serviceCode)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subDiv_code)
            ->where('service_code', $serviceCode)
            ->where('final_status', MODIFICATION_REQUEST_PENDING)
            ->where('pending_request_officer', MB_SUB_DIV_COMM)
            ->get('settlement_pull_request')
            ->num_rows();
    }


    // Count CO Modification Request Cases For ADC
    public function countCoModificationRequestCaseForADC($dist_code,$serviceCode)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('service_code', $serviceCode)
            ->where('final_status', MODIFICATION_REQUEST_PENDING)
            ->where('pending_request_officer', MB_ADD_DEPUTY_COMM)
            ->get('settlement_pull_request')
            ->num_rows();
    }


    // get all CO Modification Request Cases For SDO
    public function getCoModificationRequestCaseForSDO($dist_code,$subDiv_code,$serviceCode)
    {
        $this->db->select('a.dist_code, a.subdiv_code, 
        a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code');
        $this->db->from('settlement_basic a');
        $this->db->join('settlement_pull_request', 'a.case_no = settlement_pull_request.case_no');
        $this->db->where('a.dist_code', $dist_code);
        $this->db->where('a.subdiv_code', $subDiv_code);
        $this->db->where('a.service_code', $serviceCode);
        $this->db->where('a.pull_request',1);
        $this->db->where('settlement_pull_request.service_code', $serviceCode);
        $this->db->where('settlement_pull_request.final_status', MODIFICATION_REQUEST_PENDING);
        $this->db->where('settlement_pull_request.pending_request_officer', MB_SUB_DIV_COMM);
        $query = $this->db->get();

        $data = $query->result();

        return $data;
    }


    // get Modification Request Cases Details For SDO
    public function getModificationRequestCaseDetailsForSdo($dist_code,$subDiv_code,$serviceCode,$caseNo)
    {
        $this->db->select('settlement_pull_request.*');
        $this->db->from('settlement_basic a');
        $this->db->join('settlement_pull_request', 'a.case_no = settlement_pull_request.case_no');
        $this->db->where('a.case_no', $caseNo);
        $this->db->where('a.dist_code', $dist_code);
        $this->db->where('a.subdiv_code', $subDiv_code);
        $this->db->where('a.service_code', $serviceCode);
        $this->db->where('a.pull_request',1);
        $this->db->where('settlement_pull_request.service_code', $serviceCode);
        $this->db->where('settlement_pull_request.final_status', MODIFICATION_REQUEST_PENDING);
        $this->db->where('settlement_pull_request.pending_request_officer', MB_SUB_DIV_COMM);
        $this->db->where('settlement_pull_request.case_no', $caseNo);
        $query = $this->db->get();

        $data = $query;

        return $data;
    }


    // get Modification Request Cases Details For ADC
    public function getModificationRequestCaseDetailsForAdc($dist_code,$serviceCode,$caseNo)
    {
        $this->db->select('settlement_pull_request.*');
        $this->db->from('settlement_basic a');
        $this->db->join('settlement_pull_request', 'a.case_no = settlement_pull_request.case_no');
        $this->db->where('a.case_no', $caseNo);
        $this->db->where('a.dist_code', $dist_code);
        $this->db->where('a.service_code', $serviceCode);
        $this->db->where('a.pull_request',1);
        $this->db->where('settlement_pull_request.service_code', $serviceCode);
        $this->db->where('settlement_pull_request.final_status', MODIFICATION_REQUEST_PENDING);
        $this->db->where('settlement_pull_request.pending_request_officer', MB_ADD_DEPUTY_COMM);
        $this->db->where('settlement_pull_request.case_no', $caseNo);
        $query = $this->db->get();

        $data = $query;

        return $data;
    }


    // get Modification Request Cases Details For ADC
    public function getModificationRequestCaseDetailsForDc($dist_code,$serviceCode,$caseNo)
    {
        $this->db->select('settlement_pull_request.*');
        $this->db->from('settlement_basic a');
        $this->db->join('settlement_pull_request', 'a.case_no = settlement_pull_request.case_no');
        $this->db->where('a.case_no', $caseNo);
        $this->db->where('a.dist_code', $dist_code);
        $this->db->where('a.service_code', $serviceCode);
        $this->db->where('a.pull_request',1);
        $this->db->where('settlement_pull_request.service_code', $serviceCode);
        $this->db->where('settlement_pull_request.final_status', MODIFICATION_REQUEST_PENDING);
        $this->db->where('settlement_pull_request.pending_request_officer', MB_DEPUTY_COMM);
        $this->db->where('settlement_pull_request.case_no', $caseNo);
        $query = $this->db->get();

        $data = $query;

        return $data;
    }


    // get Modification Request Cases Details For Common
    public function getModificationRequestCaseDetailsForCommon($req_id,$dist_code,$serviceCode,$caseNo,$user_desig_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_pull_request');
        $this->db->where('settlement_pull_request.id', $req_id);
        $this->db->where('settlement_pull_request.dist_code', $dist_code);
        $this->db->where('settlement_pull_request.service_code', $serviceCode);
        $this->db->where('settlement_pull_request.final_status', MODIFICATION_REQUEST_PENDING);
        $this->db->where('settlement_pull_request.case_no', $caseNo);
        $this->db->where('settlement_pull_request.pending_request_officer', $user_desig_code);
        $query = $this->db->get();

        $data = $query;

        return $data;
    }


    // get proposal case details by case no
    public function getSettlementProposalCaseDetailsByCaseNoPull($caseNo)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where_in('status', [PRO_CASE_STATUS_PENDING,PRO_CASE_STATUS_APPROVE,PRO_CASE_STATUS_REJECT,PRO_CASE_STATUS_REVERTED])
            ->get('settlement_proposal_cases')
            ->row();
    }

    // get proposal details  by proposal Id
    public function getProposalDetailsByProIdPull($proposal_no)
    {
        return $this->db->select()
            ->where('id', $proposal_no)
            ->get('settlement_proposal_list')
            ->row();
    }

    // count meeting
    public function countMeetingDetailByMeetingIDPull($meetingId)
    {
        return $this->db->select()
            ->where('id', $meetingId)
            ->get('proposal_meeting_list')
            ->num_rows();
    }

    // get meeting details
    public function getMeetingDetailByMeetingIDPull($meetingId)
    {

        return $this->db->select()
            ->where('id', $meetingId)
            ->get('proposal_meeting_list')
            ->row();
    }


    // get Modification Request Cases Details For reverted case
    public function getModificationRequestCaseDetailsForRevertCase($caseNo,$dist_code,$serviceCode)
    {
        $this->db->select('*');
        $this->db->from('settlement_pull_request');
        $this->db->where('settlement_pull_request.case_no', $caseNo);
        $this->db->where('settlement_pull_request.dist_code', $dist_code);
        $this->db->where('settlement_pull_request.service_code', $serviceCode);
        $this->db->where('settlement_pull_request.final_status', MODIFICATION_REQUEST_PENDING);
        $query = $this->db->get();

        $data = $query;

        return $data;
    }


    // check already Modification Request exist
    public function checkModificationRequestAlreadyExist($caseNo,$dist_code)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
            ->where('final_status', MODIFICATION_REQUEST_PENDING)
            ->get('settlement_pull_request')
            ->num_rows();

    }


    // delete VGR cluster case
    public function deleteClusterCaseDetailsByClusterId($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('settlement_circle_cluster_cases');
        return $this->db->trans_status();
    }

}
