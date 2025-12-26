<?php
class SettlementCommonDcModel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }




    // get by case no
    public function getCasesByCaseNo($caseNo)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('case_no', $caseNo);
        $data = $this->db->get();
        return $data;
    }

    // get by case no Reclass
    public function getCasesByCaseNoReCla($caseNo)
    {
        $this->db->select('*');
        $this->db->from('reclass_suite_basic');
        $this->db->where('case_no', $caseNo);
        $data = $this->db->get();
        return $data;
    }

    // get by Application no
    public function getCasesByApplicationNo($caseNo)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('applid', $caseNo);
        $data = $this->db->get();
        return $data;
    }

    // get by Application no
    public function getCasesByApplicationNoReCla($caseNo)
    {
        $this->db->select('*');
        $this->db->from('reclass_suite_basic');
        $this->db->where('applid', $caseNo);
        $data = $this->db->get();
        return $data;
    }



    // get all data without date range
    public function getCasesByRespectedData
    ($dist_code,$serviceType,$appStatus,$pendingOffice,$selectCircle,$fromDate,$toDate)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('dist_code', $dist_code);
        if($serviceType != '')
        {
            $this->db->where('service_code', $serviceType);
        }
        if($appStatus != '')
        {
            $this->db->where('status', $appStatus);
        }
        if($pendingOffice != '')
        {
            $this->db->where('pending_officer', $pendingOffice);
        }
        if($selectCircle != '')
        {
            $this->db->where('cir_code', $selectCircle);
        }
        if($fromDate != '')
        {
            $this->db->where('DATE(submission_date)', $fromDate);
        }
        if($toDate != '')
        {
            $this->db->where('DATE(submission_date)', $toDate);
        }
        $data = $this->db->get();

        return $data;

    }



    // get all data without date range
    public function getCasesByRespectedDataReCla
    ($dist_code,$serviceType,$appStatus,$pendingOffice,$selectCircle,$fromDate,$toDate)
    {
        $this->db->select('*');
        $this->db->from('reclass_suite_basic');
        $this->db->where('dist_code', $dist_code);
        if($serviceType != '')
        {
            $this->db->where('service_code', $serviceType);
        }
        if($appStatus != '')
        {
            $this->db->where('status', $appStatus);
        }
        if($pendingOffice != '')
        {
            $this->db->where('pending_officer', $pendingOffice);
        }
        if($selectCircle != '')
        {
            $this->db->where('cir_code', $selectCircle);
        }
        if($fromDate != '')
        {
            $this->db->where('DATE(submission_date)', $fromDate);
        }
        if($toDate != '')
        {
            $this->db->where('DATE(submission_date)', $toDate);
        }
        $data = $this->db->get();

        return $data;

    }


    // get all data with date range
    public function getCasesByRespectedDataWithDateRage
    ($dist_code,$serviceType,$appStatus,$pendingOffice,$selectCircle,$fromDate,$toDate)
    {
        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('dist_code', $dist_code);
        if($serviceType != '')
        {
            $this->db->where('service_code', $serviceType);
        }
        if($appStatus != '')
        {
            $this->db->where('status', $appStatus);
        }
        if($pendingOffice != '')
        {
            $this->db->where('pending_officer', $pendingOffice);
        }
        if($selectCircle != '')
        {
            $this->db->where('cir_code', $selectCircle);
        }

        $this->db->where('DATE(submission_date) >=', $fromDate);
        $this->db->where('DATE(submission_date) <=', $toDate);

        $data = $this->db->get();
        return $data;

    }


    // count  application id by case no
    public function countSettlementAppDetailsByCaseNo($caseNo)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->get('settlement_basic')
            ->num_rows();
    }


    // count  application id by case no
    public function countSettlementAppDetailsByCaseNoReCla($caseNo)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->get('reclass_suite_basic')
            ->num_rows();
    }


    // count  application id by case no
    public function getSettlementAppDetailsByCaseNoReCla($caseNo)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->get('reclass_suite_basic')
            ->row();
    }


    // get  application id by case no
    public function getSettlementAppDetailsByCaseNo($caseNo)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->get('settlement_basic')
            ->row();

    }


    // get all settlement proceeding
    public function getSettlementProceeding($case)
    {
        $proceedings = $this->db->select()
            ->where('case_no',$case)
            ->order_by('proceeding_id', 'desc')
            ->get('settlement_proceeding');
        return $proceedings->result();
    }

    // save sdlac committee
    public function saveSdlacCommitteeMemberToDB($data)
    {
        $this->db->trans_start();
        $this->db->set('created_at', 'NOW()', FALSE);
        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->insert('settlement_sdlac_committee', $data);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }


    // get all SDLAC/CDLAC Member under me
    public function getAllSdlacMemberUnderMe($dist_code,$user_code,$user_desig_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_sdlac_committee');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('created_by', $user_code);
        $this->db->where('created_des', $user_desig_code);
        $this->db->where('status', 1);
        $data = $this->db->get();
        return $data;
    }


    // count member exist or not
    public function countIndSdlacMemberUnderMe($memberId,$dist_code,$user_code,$user_desig_code)
    {
        return $this->db->select()
            ->where('id', $memberId)
            ->where('dist_code', $dist_code)
            ->where('created_by', $user_code)
            ->where('created_des', $user_desig_code)
            ->get('settlement_sdlac_committee')
            ->num_rows();
    }


    // get member details
    public function getIndSdlacMemberUnderMe($memberId,$dist_code,$user_code,$user_desig_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_sdlac_committee');
        $this->db->where('id', $memberId);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('created_by', $user_code);
        $this->db->where('created_des', $user_desig_code);
        $data = $this->db->get()->row();

        return $data;
    }

    // update member details
    public function updateSdlacCommitteeMemberToDB($memberId,$dataUpdate)
    {
        $this->db->trans_start();
        $this->db->where('id',$memberId);
        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->update('settlement_sdlac_committee', $dataUpdate);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }


    // count sdlac committee member
    public function countAllSDLACCommitteeMember($dist_code,$user_code,$user_desig_code)
    {
        $sql = $this->db->query("SELECT u.user_code,
                                    (SELECT user_desig FROM master_user_designation 
                                      WHERE user_desig_code=u.user_desig_code) AS designation
                                        FROM loginuser_table lg JOIN users u ON u.user_code=lg.user_code 
                                          WHERE lg.user_code LIKE 'SDLC%'
                                            AND lg.dis_enb_option=? AND lg.dist_code=?",
            array('E', $dist_code));
        return $sql->num_rows();
    }


    // get Settlement Proposal id By CaseNo
    public function getSettlementProposalDetailsByCaseNo($caseNo)
    {
        return $this->db->select('proposal_id')
            ->where('case_no', $caseNo)
            ->where('status', 1)
            ->get('settlement_proposal_cases')
            ->row();
    }


    // get all applicant buyers
    public function getAllApplicantBuyers($case)
    {
        $applicants = $this->db->select('pdar_name')
            ->where('case_no',$case)
            ->where('pdar_type', 'B')
            ->get('settlement_applicant');
        return $applicants;
    }



    // check data exist or not under proposal list by case no
    public function countSettlementProposalList($proposal_no)
    {
        return $this->db->select()
            ->where('id', $proposal_no)
            ->where('status', 1)
            ->where('mb_status', 0)
            ->where_in('service_code',MB_2_SERVICE_CODE_ALLOW_FOR_PROPOSAL)
            ->get('settlement_proposal_list')
            ->num_rows();
    }

    // check data exist or not under proposal list by case no
    public function countSettlementProposalListAllService($proposal_no)
    {
        return $this->db->select()
            ->where('id', $proposal_no)
            ->where('status', 1)
            ->get('settlement_proposal_list')
            ->num_rows();
    }


    // check data exist or not under proposal list by case no
    public function countSettlementProposalListReCla($proposal_no)
    {
        return $this->db->select()
            ->where('id', $proposal_no)
            ->where('status', 1)
            ->where('mb_status', 0)
            ->where('meeting_type_ins', '40')
            ->get('settlement_proposal_list')
            ->num_rows();
    }


    // check data exist or not under proposal list by case no
    public function countSettlementProposalListMbTin($proposal_no)
    {
        return $this->db->select()
            ->where('id', $proposal_no)
            ->where('status', 1)
            ->where('mb_status', 3)
            ->where_in('service_code',MB_3_SERVICE_CODE_ALLOW_FOR_PROPOSAL)
            ->get('settlement_proposal_list')
            ->num_rows();
    }

    // check data exist or not under proposal list deleted by case no
    public function countSettlementProposalListDeleted($proposal_no)
    {
        return $this->db->select()
            ->where('proposal_id', $proposal_no)
            ->get('settlement_proposal_list_deleted')
            ->num_rows();
    }



    // get proposal details  by proposal Id
    public function getProposalDetailsByProId($proposal_no)
    {
        return $this->db->select()
            ->where('id', $proposal_no)
            ->where('status', 1)
            ->get('settlement_proposal_list')
            ->row();
    }


    // get all proposal details  by proposal Ids
    public function getAllProposalDetailsByProId($proposalIds)
    {
        return $this->db->select()
            ->where_in('id', $proposalIds)
            ->where('status', 1)
            ->where('mb_status', 0)
            ->where('user_code',$this->session->userdata('user_code'))
            ->where_in('service_code',MB_2_SERVICE_CODE_ALLOW_FOR_PROPOSAL)
            ->get('settlement_proposal_list')
            ->result();
    }

    // get all proposal details  by proposal Ids
    public function getAllProposalDetailsByProIdMbTin($proposalIds)
    {
        return $this->db->select()
            ->where_in('id', $proposalIds)
            ->where('status', 1)
            ->where('mb_status', 3)
            ->where_in('service_code',MB_3_SERVICE_CODE_ALLOW_FOR_PROPOSAL)
            ->get('settlement_proposal_list')
            ->result();
    }


    // get all proposal details  by proposal Ids
    public function getAllProposalDetailsByProIdSdoMbTin($proposalIds)
    {
        return $this->db->select()
            ->where_in('id', $proposalIds)
            ->where('status', 1)
            ->where('mb_status', 3)
            ->where('dist_code', $this->session->userdata('dist_code'))
            ->where('subdiv_code', $this->session->userdata('subdiv_code'))
            ->where_in('service_code',MB_3_SERVICE_CODE_ALLOW_FOR_PROPOSAL)
            ->get('settlement_proposal_list')
            ->result();
    }

    //count cluster id by proposal id
    public function countClusterIdByProposal($proposalId)
    {
        return $this->db->select()
            ->where('proposal_id', $proposalId)
            ->get('settlement_circle_cluster')
            ->num_rows();
    }

    //count cluster id by Meeting id
    public function countClusterIdByMeetingId($mId)
    {
        return $this->db->select()
            ->where('meeting_id', $mId)
            ->get('settlement_circle_cluster')
            ->num_rows();
    }


    //get cluster id by proposal id
    public function getClusterIdByProposal($proposalId)
    {
        return $this->db->select('cluster_id')
            ->where('proposal_id', $proposalId)
            ->get('settlement_circle_cluster')
            ->row()->cluster_id;
    }

    //get cluster id by proposal id
    public function getClusterIdByMeetingId($mId)
    {
        return $this->db->select('*')
            ->where('meeting_id', $mId)
            ->get('settlement_circle_cluster')
            ->row();
    }

    // get all case under selected proposal in send by DC to SDLAC KHAS
    public function getAllAppInReportSendByDcToSdlacCommon($proposal_no,$dist_code,$serviceID)
    {

        $this->db->select('settlement_proposal_cases.case_no');
        $this->db->from('settlement_proposal_cases');
        $this->db->where('proposal_id', $proposal_no);
        $data = $this->db->get();
        return $data;

    }

    // get all data for Minutes of the SDLAC Committee meeting
    public function getAllDataForSDLACMinutes($case_no)
    {
        $sql = "SELECT 
                (select locname_eng from location where dist_code=sd.dist_code and subdiv_code=sd.subdiv_code and 
                 cir_code=sd.cir_code and mouza_pargona_code='00') as cirname,
                (select locname_eng from location where dist_code=sd.dist_code and subdiv_code=sd.subdiv_code and 
                 cir_code=sd.cir_code and mouza_pargona_code=sd.mouza_pargona_code and lot_no='00') as mouza,
                (select locname_eng from location where dist_code=sd.dist_code and subdiv_code=sd.subdiv_code and 
                 cir_code=sd.cir_code and mouza_pargona_code=sd.mouza_pargona_code and lot_no=sd.lot_no AND 
                 vill_townprt_code = sd.vill_townprt_code
                ) as village,
                string_agg(DISTINCT(sa.eng_pdar_name),',') as name,
                string_agg(DISTINCT(sa.eng_pdar_guardian),',') as gurdian ,STRING_AGG(sp.dag_no,',') as dags,
                string_agg(sp.total_lessa::varchar,',') area,
                string_agg(DISTINCT(sc.template_remarks),',') remark,
                string_agg((sd.land_type),',') ladtype
                FROM settlement_proposal_cases sc
                JOIN settlement_applicant sa on sc.case_no = sa.case_no
                JOIN settlement_premium sp on sc.case_no = sp.case_no
                JOIN  settlement_dag_details sd on sd.case_no=sa.case_no and sp.dag_no=sd.dag_no
                WHERE sa.is_applicant=1 and sd.case_no = '$case_no' and sp.is_final=1
                GROUP BY  sd.dist_code,sd.subdiv_code,sd.cir_code,sd.mouza_pargona_code,sd.lot_no,sd.vill_townprt_code";

        $result = $this->db->query($sql)->result();

        return $result;
    }

    // get all minutes from processing
    public function getAllMinutesInProcessingSdlacCommon($proposal_no)
    {
        $proceedings = $this->db->select()
            ->where('minutes_proposal_id',$proposal_no)
            ->get('settlement_proceeding');

        return $proceedings->result();
    }


    // get all SDLAC/CDLAC Member
    public function getMembersFromUsers($dist_code){

        $sql = $this->db->query("SELECT u.username AS name, u.user_code, u.display_name,
                                    (SELECT user_desig FROM master_user_designation 
                                      WHERE user_desig_code=u.user_desig_code) AS designation
                                        FROM loginuser_table lg JOIN users u ON u.user_code=lg.user_code 
                                          WHERE lg.user_code LIKE 'SDLC%'
                                            AND (lg.dis_enb_option=? OR lg.special_status=?) AND lg.dist_code=? order by priority asc",
            array('E',1, $dist_code));

        if($sql->num_rows() > 0){
            return $sql->result();
        }
        else{
            return false;
        }
    }

    // get all SDLAC/CDLAC Member
    public function checkProposalAlreadyExistInMeeting($proposals)
    {
        return $this->db->select()
            ->where_in('id', $proposals)
            ->where('user_code',$this->session->userdata('user_code'))
            ->where('proposal_meeting_id IS NOT NULL')
            ->get('settlement_proposal_list')
            ->num_rows();
    }


    // get all SDLAC/CDLAC Member for MB 3
    public function checkProposalMatchWithMbTwoWithMbThree($proposals)
    {
        return $this->db->select()
            ->where_in('id', $proposals)
            ->where('mb_status !=',3)
            ->get('settlement_proposal_list')
            ->num_rows();
    }


    // get all SDLAC/CDLAC Member for MB 3
    public function checkProposalMatchWithMbThreeWithMbTwo($proposals)
    {
        return $this->db->select()
            ->where_in('id', $proposals)
            ->where('mb_status !=',0)
            ->where('user_code',$this->session->userdata('user_code'))
            ->get('settlement_proposal_list')
            ->num_rows();
    }



    // get nominee name
    public function getNomineeName($id)
    {
        $nomId = intval($id);
        return $this->db->select()
            ->where('id', $nomId)
            ->where('nominee_status', 1)
            ->get('sdlac_nominee_list')
            ->row();
    }





    // get urban by LM  (falls Under GMC)
    public function getLandFallsUnderUrban($case_no)
    {
        return $this->db->select('falls_und_gmc')
            ->where('case_no', $case_no)
            ->get('settlement_ap_lmnote')
            ->row();
    }

    // get all settlement dag
    public function getSettlementDagCommon($case)
    {
        $dags = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_dag_details');

        return $dags->row();
    }



    // count application by case no for DC in sdlac proposal list
    public function countSettlementApplicationByCaseNoInSdlacProList($caseNo)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where_in('status', [PRO_CASE_STATUS_PENDING,PRO_CASE_STATUS_APPROVE,PRO_CASE_STATUS_REJECT,PRO_CASE_STATUS_REVERTED])
            ->get('settlement_proposal_cases')
            ->num_rows();
    }


    // count case under proposal with proposal id
    public function countCasesWithProposalId($proNo)
    {
        return $this->db->select()
            ->where('proposal_id', $proNo)
            ->get('settlement_proposal_cases')
            ->num_rows();
    }





    // count pending case in SDLAC proposal
    public function countSettlementProposalPendingCaseByCaseNo($caseNo)
    {
        return $this->db->select('proposal_id')
            ->where('case_no', $caseNo)
            ->where_in('status', [PRO_CASE_STATUS_PENDING,PRO_CASE_STATUS_REVERTED])
            ->get('settlement_proposal_cases')
            ->num_rows();
    }

    // count pending case in SDLAC proposal for holding case
    public function countSettlementProposalPendingCaseByCaseNoDeptHold($caseNo)
    {
        return $this->db->select('proposal_id')
            ->where('case_no', $caseNo)
            ->get('settlement_proposal_cases')
            ->num_rows();
    }

    // count revert case bu dept in SDLAC proposal
    public function countSettlementProposalPendingCaseByCaseNoForDeptRevert($caseNo)
    {
        return $this->db->select('proposal_id')
            ->where('case_no', $caseNo)
            ->where_in('status', [PRO_CASE_STATUS_APPROVE,PRO_CASE_STATUS_REJECT])
            ->get('settlement_proposal_cases')
            ->num_rows();
    }

    // get revert case bu dept in SDLAC proposa
    public function getSettlementProposalPendingCaseByCaseNoForDeptRevert($caseNo)
    {
        return $this->db->select('proposal_id')
            ->where('case_no', $caseNo)
            ->where_in('status', [PRO_CASE_STATUS_APPROVE,PRO_CASE_STATUS_REJECT])
            ->get('settlement_proposal_cases')
            ->row();
    }


    // get proposal case details by case no
    public function getSettlementProposalCaseDetailsByCaseNo($caseNo)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where_in('status', [PRO_CASE_STATUS_PENDING,PRO_CASE_STATUS_REVERTED])
            ->get('settlement_proposal_cases')
            ->row();
    }

    // get proposal case details by case no
    public function getSettlementProposalCaseDetailsByCaseNoModification($caseNo)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->get('settlement_proposal_cases')
            ->row();
    }


    // get proposal case details by case no
    public function getSettlementProposalCaseDetailsByCaseNoModificationCo($caseNo)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->get('settlement_proposal_cases');
    }




    // get reverted proposal case details by case no
    public function getSettlementRevertedProposalCaseDetailsByCaseNo($caseNo)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->get('settlement_proposal_cases')
            ->row();
    }



    // update data exist or not under proposal list by case no
    public function updateSettlementProposalCaseDetailsByCaseNo($caseNo,$data)
    {
        $this->db->where('case_no', $caseNo);
        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->update('settlement_proposal_cases',$data);
        return $this->db->trans_status();
    }


    // delete proposal case details
    public function deleteSettlementProposalCaseDetailsById($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('settlement_proposal_cases');
        return $this->db->trans_status();
    }

    // delete proposal from proposal list
    public function deleteSettlementProposalByProId($id,$dist_code)
    {
        $this->db->where('id', $id);
        $this->db->where('dist_code', $dist_code);
        $this->db->delete('settlement_proposal_list');
        return $this->db->trans_status();
    }



    // get all SDLAC/CDLAC Member by proposal no
    public function getSdlacMemberListByProId($proId,$dist_code,$serviceID)
    {
        $this->db->select('users.username,users.phone_no,users.display_name');
        $this->db->from('settlement_sdlac_member_report');
        $this->db->join('users','users.user_code = settlement_sdlac_member_report.sdlac_member_code');
        $this->db->where('settlement_sdlac_member_report.proposal_no', $proId);
        $this->db->where('settlement_sdlac_member_report.dist_code', $dist_code);
        $this->db->where('settlement_sdlac_member_report.service_code', $serviceID);
        $data = $this->db->get();
        return $data;

    }


    // get all applicant
    public function getApplicantDetails($case)
    {
        return $this->db->select('pdar_name')
            ->where('case_no',$case)
            ->where('is_applicant',1)
            ->get('settlement_applicant')
            ->row();

    }


    // count proposal no with case no
    public function countProposalIdByCaseNo($case)
    {
        return $this->db->select('proposal_id')
            ->where('case_no',$case)
            ->get('settlement_proposal_cases')
            ->num_rows();
    }

    // get proposal no with case no
    public function getProposalIdByCaseNo($case)
    {
        $mm = $this->db->select('proposal_id')
            ->where('case_no',$case)
            ->get('settlement_proposal_cases');

        return $mm->result();
    }


    // get proposal no with case no
    public function getProposalNameByCaseNo($case)
    {
        $this->db->select('settlement_proposal_list.proposal_name as proposal_id');
        $this->db->from('settlement_proposal_cases');
        $this->db->join('settlement_proposal_list','settlement_proposal_list.id = settlement_proposal_cases.proposal_id');
        $this->db->where('settlement_proposal_cases.case_no', $case);
        $data = $this->db->get();
        return $data->result();
    }


    // count proposal no with case no
    public function countApplicationDetailsByAppNo($case)
    {
        return $this->db->select('case_no')
            ->where('applid',$case)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get proposal no with case no
    public function getApplicationDetailsByAppNo($case)
    {
        return $this->db->select('case_no')
            ->where('applid',$case)
            ->get('settlement_basic')
            ->row();

    }



    // get chitha dag details
    public function getChithaDagAreaDetails($appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta)
    {
        return $this->db->select()
            ->where('dist_code',$appDistrict)
            ->where('subdiv_code',$appSubDiv)
            ->where('cir_code',$appCircle)
            ->where('mouza_pargona_code',$appMouza)
            ->where('lot_no',$appLot)
            ->where('vill_townprt_code',$appVillage)
            ->where('dag_no',$appDag)
//            ->where('patta_type_code',$appPattaType)
//            ->where('patta_no',$appPatta)
            ->get('chitha_basic')
            ->row();
    }


    // get new chitha dag details
    public function getNewChithaDagAreaDetails($appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag)
    {
        return $this->db->select()
            ->where('dist_code',$appDistrict)
            ->where('subdiv_code',$appSubDiv)
            ->where('cir_code',$appCircle)
            ->where('mouza_pargona_code',$appMouza)
            ->where('lot_no',$appLot)
            ->where('vill_townprt_code',$appVillage)
            ->where('dag_no',$appDag)
            ->get('chitha_basic')
            ->row();
    }

    // get chitha dag details
    public function getChithaDagAreaDetailsByDagNo($appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag)
    {
        return $this->db->select()
            ->where('dist_code',$appDistrict)
            ->where('subdiv_code',$appSubDiv)
            ->where('cir_code',$appCircle)
            ->where('mouza_pargona_code',$appMouza)
            ->where('lot_no',$appLot)
            ->where('vill_townprt_code',$appVillage)
            ->where('dag_no',$appDag)
            ->get('chitha_basic')
            ->row();
    }


    //  get all application though location details (Not Rejected on)
    public function getAllDagAreaDetailsByLocation($appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta)
    {
        //  $this->db->select('settlement_dag_details.*,settlement_basic.status');
        //  $this->db->from('settlement_dag_details');
        //  $this->db->join('settlement_basic','settlement_basic.case_no = settlement_dag_details.case_no');
        //  $this->db->where('settlement_basic.status !=','D');
        //  $this->db->where('settlement_basic.status !=','F');
        //  $this->db->where('settlement_basic.dc_proceeding',1);
        //  $this->db->where('settlement_dag_details.dist_code',$appDistrict);
        //  $this->db->where('settlement_dag_details.subdiv_code',$appSubDiv);
        //  $this->db->where('settlement_dag_details.cir_code',$appCircle);
        //  $this->db->where('settlement_dag_details.mouza_pargona_code',$appMouza);
        //  $this->db->where('settlement_dag_details.lot_no',$appLot);
        //  $this->db->where('settlement_dag_details.vill_townprt_code',$appVillage);
        //  $this->db->where('settlement_dag_details.dag_no',$appDag);
        //  $this->db->where('settlement_dag_details.patta_type_code',$appPattaType);
        //  $this->db->where('settlement_dag_details.patta_no',$appPatta);
        //  $applications = $this->db->get();


        $applications = $this->db->query("
        SELECT settlement_dag_details.*, settlement_basic.status
	    FROM (select * from settlement_dag_details where dist_code='$appDistrict' and subdiv_code='$appSubDiv' and cir_code='$appCircle'
	    and mouza_pargona_code='$appMouza' and lot_no='$appLot' and vill_townprt_code='$appVillage' 
	    and dag_no='$appDag' and patta_type_code='$appPattaType' and patta_no='$appPatta') settlement_dag_details
	    JOIN (select * from settlement_basic where dist_code='$appDistrict' and subdiv_code='$appSubDiv' and cir_code='$appCircle' and 
	    mouza_pargona_code='$appMouza' and lot_no='$appLot' and vill_townprt_code='$appVillage'
	    and status not in('D','F') and co_chitha_corrected_yn is null and order_passed is null and dc_proceeding=1) settlement_basic
	    ON settlement_basic.case_no = settlement_dag_details.case_no
        ");

        return $applications->result();
    }


    //  get all application though location details (Not Rejected on)
    public function getAllDagAreaDetailsByLocationOnlyApCase($appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta)
    {
        $applications = $this->db->query("
        SELECT settlement_dag_details.*, settlement_basic.status
	    FROM (select * from settlement_dag_details where dist_code='$appDistrict' and subdiv_code='$appSubDiv' and cir_code='$appCircle'
	    and mouza_pargona_code='$appMouza' and lot_no='$appLot' and vill_townprt_code='$appVillage' 
	    and dag_no='$appDag' and patta_type_code='$appPattaType' and patta_no='$appPatta' 
	    and new_dag_no is NULL ) settlement_dag_details
	    JOIN (select * from settlement_basic where dist_code='$appDistrict' and subdiv_code='$appSubDiv' and cir_code='$appCircle' and 
	    mouza_pargona_code='$appMouza' and lot_no='$appLot' and vill_townprt_code='$appVillage'
	    and status not in('D','F') and co_chitha_corrected_yn is null and order_passed is null and dc_proceeding=1) settlement_basic
	    ON settlement_basic.case_no = settlement_dag_details.case_no
        ");

        return $applications->result();
    }



    //  get all application though location details (Not Rejected on)
    public function getAllDagAreaDetailsByLocationNotSubmit($appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta,$application_no)
    {
        //  $this->db->select('settlement_dag_details.*,settlement_basic.status');
        //  $this->db->from('settlement_dag_details');
        //  $this->db->join('settlement_basic','settlement_basic.case_no = settlement_dag_details.case_no');
        //  $this->db->where('settlement_basic.status !=','D');
        //  $this->db->where('settlement_basic.status !=','F');
        //  $this->db->where('settlement_basic.case_no !=',$application_no);
        //  $this->db->where('settlement_basic.dc_proceeding',0);
        //  $this->db->where('settlement_dag_details.dist_code',$appDistrict);
        //  $this->db->where('settlement_dag_details.subdiv_code',$appSubDiv);
        //  $this->db->where('settlement_dag_details.cir_code',$appCircle);
        //  $this->db->where('settlement_dag_details.mouza_pargona_code',$appMouza);
        //  $this->db->where('settlement_dag_details.lot_no',$appLot);
        //  $this->db->where('settlement_dag_details.vill_townprt_code',$appVillage);
        //  $this->db->where('settlement_dag_details.dag_no',$appDag);
        //  $this->db->where('settlement_dag_details.patta_type_code',$appPattaType);
        //  $this->db->where('settlement_dag_details.patta_no',$appPatta);
        //  $applications = $this->db->get();

        $applications = $this->db->query("
        SELECT settlement_dag_details.*, settlement_basic.status
	    FROM (select * from settlement_dag_details where dist_code='$appDistrict' and subdiv_code='$appSubDiv' and cir_code='$appCircle'
	    and mouza_pargona_code='$appMouza' and lot_no='$appLot' and vill_townprt_code='$appVillage' 
	    and dag_no='$appDag' and patta_type_code='$appPattaType' and patta_no='$appPatta') settlement_dag_details
	    JOIN (select * from settlement_basic where dist_code='$appDistrict' and subdiv_code='$appSubDiv' and cir_code='$appCircle' and 
	    mouza_pargona_code='$appMouza' and lot_no='$appLot' and vill_townprt_code='$appVillage'
	    and status not in('D','F') and co_chitha_corrected_yn is null and order_passed is null and dc_proceeding=0) settlement_basic
	    ON settlement_basic.case_no = settlement_dag_details.case_no
        ");

        return $applications->result();
    }



    // Only AP case  get all application though location details (Not Rejected on)
    public function getAllDagAreaDetailsByLocationNotSubmitOnlyApCase($appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta,$application_no)
    {

        $applications = $this->db->query("
        SELECT settlement_dag_details.*, settlement_basic.status
	    FROM (select * from settlement_dag_details where dist_code='$appDistrict' and subdiv_code='$appSubDiv' and cir_code='$appCircle'
	    and mouza_pargona_code='$appMouza' and lot_no='$appLot' and vill_townprt_code='$appVillage' 
	    and dag_no='$appDag' and patta_type_code='$appPattaType' and patta_no='$appPatta' and new_dag_no IS NULL) settlement_dag_details
	    JOIN (select * from settlement_basic where dist_code='$appDistrict' and subdiv_code='$appSubDiv' and cir_code='$appCircle' and 
	    mouza_pargona_code='$appMouza' and lot_no='$appLot' and vill_townprt_code='$appVillage'
	    and status not in('D','F') and co_chitha_corrected_yn is null and order_passed is null and dc_proceeding=0) settlement_basic
	    ON settlement_basic.case_no = settlement_dag_details.case_no
        ");

        return $applications->result();
    }




    //  get all application though location details (Not Rejected on)
    public function getAllDagAreaDetailsByLocationNotSubmitOnlyApCoCase($appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta,$application_no)
    {
        $applications = $this->db->query("
        SELECT settlement_dag_details.*, settlement_basic.status
	    FROM (select * from settlement_dag_details where dist_code='$appDistrict' and subdiv_code='$appSubDiv' and cir_code='$appCircle'
	    and mouza_pargona_code='$appMouza' and lot_no='$appLot' and vill_townprt_code='$appVillage' 
	    and dag_no='$appDag' and patta_type_code='$appPattaType' and patta_no='$appPatta' 
	    and new_dag_no is NULL) settlement_dag_details
	    JOIN (select * from settlement_basic where dist_code='$appDistrict' and subdiv_code='$appSubDiv' and cir_code='$appCircle' and 
	    mouza_pargona_code='$appMouza' and lot_no='$appLot' and vill_townprt_code='$appVillage'
	    and status not in('D','F') and co_chitha_corrected_yn is null and order_passed is null and dc_proceeding=0) settlement_basic
	    ON settlement_basic.case_no = settlement_dag_details.case_no
        ");

        return $applications->result();
    }




    // get all settlement reservation
    public function getSettlementReservationCommon($case)
    {
        $lmnotes = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_reservation');
        return $lmnotes->result();
    }


    // get all settlement dag
    public function getAppliedSettlementDag($case)
    {
        $dags = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_dag_details');

        return $dags->result();
    }


    // get basic details with case no
    public function getSettlementBasicData($case_no){
        $query = "SELECT * FROM settlement_basic WHERE case_no = '$case_no'";
        $data = $this->db->query($query)->row();
        return $data;
    }


    // get all SDLAC/CDLAC Member under of a district
    public function getAllSdlacMemberOfDistrict($dist_code)
    {
        $query = $this->db->query("SELECT A.use_name, A.user_code, B.username, B.emailid 
                                    FROM loginuser_table A
                                      JOIN users B on A.user_code=B.user_code 
                                        AND A.dist_code = B.dist_code
                                          WHERE A.user_code LIKE '%SDLC%' AND A.dist_code = ? 
                                            AND A.dis_enb_option = ?", array($dist_code, 'E'));
        return $query;
    }


    // get all SDLAC/CDLAC Member under of a district
    public function checkForSdlacProcess($dist_code, $prop_id)
    {
        $query = $this->db->query("SELECT * FROM settlement_proposal_list
                                    WHERE sdlac_prceed_status ".PROPOSAL_SEND_TO_SDLAC." 
                                    AND dist_code = ? AND id = ? ", array($dist_code, $prop_id));
        return $query;
    }


    //fetch SDLAC User details for generating priority in ADC/SDO Login--2702-2023
    public function fetch_sdlac_member_list($dist_code){

        $sql = $this->db->query("SELECT u.priority,u.user_code,u.username AS name,u.emailid as email,phone_no as phone,
                                    (SELECT user_desig FROM master_user_designation 
                                      WHERE user_desig_code=u.user_desig_code) AS designation
                                        FROM loginuser_table lg JOIN users u ON u.user_code=lg.user_code 
                                          WHERE lg.user_code LIKE 'SDLC%'
                                            AND lg.dis_enb_option=? AND lg.dist_code=? order by priority asc",
            array('E', $dist_code));

        return $sql;

    }
    //function for set priority of all SDLAC memeber-----27-02-2023
    public function updateFlag($dist_code,$memberId,$priority){

        //FIRST CHECK THE USERCODE IS AVAILABLE OR NOT IN BOTH TABLE----
        $sql = $this->db->query("SELECT u.user_code,
                                    (SELECT user_desig FROM master_user_designation 
                                      WHERE user_desig_code=u.user_desig_code) AS designation
                                        FROM loginuser_table lg JOIN users u ON u.user_code=lg.user_code 
                                          WHERE lg.user_code LIKE 'SDLC%'
                                            AND lg.dis_enb_option=? AND lg.dist_code=? and u.user_code=?",
            array('E', $dist_code,$memberId));

        if($sql->num_rows() > 0){

            //IF FOUND THEN UPDATE SQL WILL RUN----
            $this->db->query("update users set priority = '$priority' where user_code = '$memberId' and dist_code = '$dist_code'");
            if($this->db->affected_rows() != 1){
                //if error in update--------
                $this->db->trans_rollback();
                log_message("error", "#USERS789, Error in update, table 'users' in updating priority");
                return 0;
            }else if($this->db->affected_rows() == 1){
                return 1;
            }
        }
        else{
            $this->db->trans_rollback();
            log_message("error", "user code not found");
            return 3;
        }
    }

    public function checkPaymentRequestGenerated($case_no)
    {
        $sql = $this->db->query("SELECT status FROM settlement_basic WHERE case_no = ?", array($case_no));

        if($sql->num_rows() > 0)
        {
            $status = $sql->row()->status;
            if(trim($status) == 'M')
            {
                return 'y';
            }
            else
            {
                return 'n';
            }
        }
        else
        {
            return false;
        }

    }

    public function checkStatusProposalCases($case_no)
    {
        $sql = $this->db->query('SELECT approved_by_dc FROM settlement_proposal_cases WHERE case_no = ?', array($case_no));
        if($sql->num_rows() > 0)
        {
            return $sql->row()->approved_by_dc;
        }
        else
        {
            return 'n';
        }

    }


    // get all pending proposal list at ADC end
    public function getPendingProposals($dist_code,$createdBy)
    {
        $this->db->select('*');
        $this->db->from('proposal_meeting_list');
        $this->db->where_in('adc_forward_to_dc_status', 0);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('created_by', $createdBy);
        $this->db->where('mb_status', 0);
        $this->db->where('nc', 0);
        $this->db->where("(meeting_type_ins = '" . '' . "' OR meeting_type_ins IS NULL)", null, false);
        $this->db->where("(user_code = '" . $this->session->userdata('user_code') . "' OR user_code IS NULL)", null, false);
        $this->db->order_by('id', 'asc');
        $data = $this->db->get();
        return $data;
    }


    // get all pending proposal list at ADC end
    public function getPendingProposalsReCla($dist_code,$createdBy)
    {
        $this->db->select('*');
        $this->db->from('proposal_meeting_list');
        $this->db->where_in('adc_forward_to_dc_status', 0);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('created_by', $createdBy);
        $this->db->where('mb_status', 0);
        $this->db->where('nc', 0);
        $this->db->where("(meeting_type_ins = '" . '' . "' OR meeting_type_ins IS NULL)", null, false);
        $this->db->where('user_code',$this->session->userdata('user_code'));
        $this->db->order_by('id', 'asc');
        $data = $this->db->get();
        return $data;
    }


    // get all pending proposal list at ADC end
    public function getPendingProposalsMbTin($dist_code,$createdBy)
    {
        $this->db->select('*');
        $this->db->from('proposal_meeting_list');
        $this->db->where_in('adc_forward_to_dc_status', 0);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('created_by', $createdBy);
        $this->db->where('mb_status', 3);
        $this->db->where("(user_code = '" . $this->session->userdata('user_code') . "' OR user_code IS NULL)", null, false);
        $this->db->order_by('id', 'asc');
        $data = $this->db->get();
        return $data;
    }

    // count proposal list ready for create meeting
    public function getPendingProposalsReadyForMeeting($dist_code,$userDegCode)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('created_by', $userDegCode)
            ->where('sdlac_prceed_status', 2)
            ->where('meeting_create_status', 1)
            ->where('user_code',$this->session->userdata('user_code'))
            ->where_in('service_code',MB_2_SERVICE_CODE_ALLOW_FOR_PROPOSAL)
            ->get('settlement_proposal_list')
            ->num_rows();

    }


    // count proposal list ready for create meeting
    public function getPendingProposalsReadyForMeetingMbTin($dist_code,$userDegCode)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('created_by', $userDegCode)
            ->where('sdlac_prceed_status', 2)
            ->where('meeting_create_status', 1)
            ->where('mb_status', 3)
            ->where_in('service_code',MB_3_SERVICE_CODE_ALLOW_FOR_PROPOSAL)
            ->get('settlement_proposal_list')
            ->num_rows();

    }


    // count proposal list ready for create meeting
    public function getPendingProposalsReadyForMeetingSdoMbTin($dist_code,$userDegCode)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('subdiv_code',$this->session->userdata('subdiv_code'))
            ->where('created_by', $userDegCode)
            ->where('sdlac_prceed_status', 2)
            ->where('meeting_create_status', 1)
            ->where('mb_status', 3)
            ->where_in('service_code',MB_3_SERVICE_CODE_ALLOW_FOR_PROPOSAL)
            ->get('settlement_proposal_list')
            ->num_rows();

    }



    // get all pending proposal list at SDO end
    public function getPendingProposalsOfSdo($dist_code,$subdiv_code,$createdBy)
    {
        $this->db->select('*');
        $this->db->from('proposal_meeting_list');
        $this->db->where_in('adc_forward_to_dc_status', 0);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('created_by', $createdBy);
        $this->db->where("(user_code = '" . $this->session->userdata('user_code') . "' OR user_code IS NULL)", null, false);
        $this->db->order_by('id', 'asc');
        $data = $this->db->get();
        return $data;
    }

    // get all pending proposal list at SDO end
    public function getPendingProposalsOfSdoMbTin($dist_code,$createdBy)
    {
        $this->db->select('*');
        $this->db->from('proposal_meeting_list');
        $this->db->where_in('adc_forward_to_dc_status', 0);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('mb_status', 3);
        $this->db->where('subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('created_by', $createdBy);
        $this->db->where("(user_code = '" . $this->session->userdata('user_code') . "' OR user_code IS NULL)", null, false);
        $this->db->order_by('id', 'asc');
        $data = $this->db->get();
        return $data;
    }



    // check meeting exits or not
    public function checkMeetingExistOrNotWithMeetingId($mId,$dist_code)
    {
        $this->db->select('*');
        $this->db->from('proposal_meeting_list');
        $this->db->where('adc_forward_to_dc_status', 0);
        $this->db->where('id', $mId);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('user_code',$this->session->userdata('user_code'));
        $data = $this->db->get();
        return $data;
    }


    // check meeting exits or not
    public function checkMeetingExistOrNotWithMeetingIdSdo($mId,$dist_code)
    {
        $this->db->select('*');
        $this->db->from('proposal_meeting_list');
        $this->db->where('adc_forward_to_dc_status', 0);
        $this->db->where('id', $mId);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $this->session->userdata('subdiv_code'));
        $data = $this->db->get();
        return $data;
    }


    // check reverted meeting exits or not for SDO
    public function checkRevertedMeetingExistOrNotWithMeetingId($mId,$dist_code,$subdiv_code)
    {
        $this->db->select('*');
        $this->db->from('proposal_meeting_list');
        $this->db->where('adc_forward_to_dc_status', 2);
        $this->db->where('id', $mId);
        $this->db->where('mb_status', 0);
        $this->db->where('nc', 0);
        $this->db->where("(meeting_type_ins = '" . '' . "' OR meeting_type_ins IS NULL)", null, false);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $data = $this->db->get();
        return $data;
    }


    // check reverted meeting exits or not for SDO
    public function checkRevertedMeetingExistOrNotWithMeetingIdMbTin($mId,$dist_code,$subdiv_code)
    {
        $this->db->select('*');
        $this->db->from('proposal_meeting_list');
        $this->db->where('adc_forward_to_dc_status', 2);
        $this->db->where('id', $mId);
        $this->db->where('mb_status', 3);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $data = $this->db->get();
        return $data;
    }


    // check reverted meeting exits or not for Adc
    public function checkRevertedMeetingExistOrNotWithMeetingIdAdc($mId,$dist_code)
    {
        $this->db->select('*');
        $this->db->from('proposal_meeting_list');
        $this->db->where('adc_forward_to_dc_status', 2);
        $this->db->where('id', $mId);
        $this->db->where('mb_status', 3);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;
    }


    // check reverted meeting exits or not for Adc
    public function checkRevertedMeetingExistOrNotWithMeetingIdAdcMB2($mId,$dist_code)
    {
        $this->db->select('*');
        $this->db->from('proposal_meeting_list');
        $this->db->where('adc_forward_to_dc_status', 2);
        $this->db->where('id', $mId);
        $this->db->where('mb_status', 0);
        $this->db->where('nc', 0);
        $this->db->where("(meeting_type_ins = '" . '' . "' OR meeting_type_ins IS NULL)", null, false);
        $this->db->where('user_code',$this->session->userdata('user_code'));
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;
    }


    // check reverted meeting exits or not for Adc
    public function checkRevertedMeetingExistOrNotWithMeetingIdAdcMbTin($mId,$dist_code)
    {
        $this->db->select('*');
        $this->db->from('proposal_meeting_list');
        $this->db->where('adc_forward_to_dc_status', 2);
        $this->db->where('id', $mId);
        $this->db->where('mb_status', 3);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;
    }


    // get all pending proposal list at DC end
    public function getPendingMeetingDetail($dist_code)
    {
        $this->db->select('*');
        $this->db->from('proposal_meeting_list');
        $this->db->where_in('adc_forward_to_dc_status', 1);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get();
        return $data;
    }


    public function getLocationName($dist_code)
    {
        $this->db->select('subdiv_code, cir_code');
        $this->db->from('settlement_basic');
        $this->db->where('dist_code', $dist_code);
        $this->db->group_by('subdiv_code, cir_code');
        $data = $this->db->get();
        return $data;
    }


    // get all MP from users table
    public function getUsersMp($dist_code, $subdiv_code)
    {
        $this->db->select();
        $this->db->where('user_type', 'MP');
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get('users');
        return $data;
    }

    // get all MLA users from users table
    public function getUsersMla($dist_code, $subdiv_code)
    {
        $this->db->select();
        $this->db->where('user_type', 'MLA');
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get('users');
        return $data;
    }

    // get all SDLAC users from users table
    public function getUsersSdlac($dist_code, $subdiv_code)
    {
        $this->db->select();
        $this->db->where('user_type', 'SDLC');
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get('users');
        return $data;
    }


    // get all MP from minutes copy to table
    public function countUsersMpCopyToForSDO($dist_code,$subdiv_code,$proposalCreatedBy)
    {

        return $this->db->select()
            ->where('user_desg', 'MP')
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subdiv_code)
            ->where('created_by', MB_SUB_DIV_COMM)
            ->where('created_code',$proposalCreatedBy)
            ->get('minute_meeting_copy_to')
            ->num_rows();
    }


    // get all MP from minutes copy to table
    public function countUsersMpCopyToForADC($dist_code,$proposalCreatedBy)
    {

        return $this->db->select()
            ->where('user_desg', 'MP')
            ->where('dist_code', $dist_code)
            ->where('created_by', MB_ADD_DEPUTY_COMM)
            ->where('created_code',$proposalCreatedBy)
            ->get('minute_meeting_copy_to')
            ->num_rows();
    }


    // get all MP from minutes copy to table
    public function getUsersMpCopyTo($dist_code, $subdiv_code,$proposalCreatedBy)
    {
        $this->db->select();
        $this->db->where('user_desg', 'MP');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('created_by', MB_ADD_DEPUTY_COMM);
        if($proposalCreatedBy != '' OR $proposalCreatedBy != NULL)
        {
            $this->db->where('created_code',$proposalCreatedBy);
        }
        else
        {
            $this->db->where('created_code',NULL, FALSE);
        }
        $this->db->order_by('hpc_type', 'asc');
        $data = $this->db->get('minute_meeting_copy_to');
        return $data;
    }


    // get all MP from minutes copy to table
    public function getUsersMpCopyToForSdo($dist_code,$subdiv_code,$proposalCreatedBy)
    {
        $this->db->select();
        $this->db->where('user_desg', 'MP');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('created_by', MB_SUB_DIV_COMM);
        if($proposalCreatedBy != '' OR $proposalCreatedBy != NULL)
        {
            $this->db->where('created_code',$proposalCreatedBy);
        }
        else
        {
            $this->db->where('created_code',NULL, FALSE);
        }
        $this->db->order_by('hpc_type', 'asc');
        $data = $this->db->get('minute_meeting_copy_to');
        return $data;
    }

    // get all users from minutes copy to table
    public function getUsersMlaCopyTo($dist_code, $subdiv_code,$proposalCreatedBy)
    {
        $this->db->select();
        $this->db->where('user_desg', 'MLA');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('created_by', MB_ADD_DEPUTY_COMM);
        if($proposalCreatedBy != '' OR $proposalCreatedBy != NULL)
        {
            $this->db->where('created_code',$proposalCreatedBy);
        }
        else
        {
            $this->db->where('created_code',NULL, FALSE);
        }
        $this->db->order_by('sl_no', 'asc');
        $data = $this->db->get('minute_meeting_copy_to');
        return $data;
    }


    // get all users from minutes copy to table
    public function getUsersMlaCopyToForSdo($dist_code,$subdiv_code,$proposalCreatedBy)
    {
        $this->db->select();
        $this->db->where('user_desg', 'MLA');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('created_by', MB_SUB_DIV_COMM);
        if($proposalCreatedBy != '' OR $proposalCreatedBy != NULL)
        {
            $this->db->where('created_code',$proposalCreatedBy);
        }
        else
        {
            $this->db->where('created_code',NULL, FALSE);
        }
        $this->db->order_by('sl_no', 'asc');
        $data = $this->db->get('minute_meeting_copy_to');

        return $data;
    }

    // get all SDLAC users from minutes copy to table
    public function getUsersSdlacCopyTo($dist_code, $subdiv_code,$proposalCreatedBy)
    {
        $this->db->select();
        $this->db->where('user_desg', 'SDLC');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('created_by', MB_ADD_DEPUTY_COMM);
        if($proposalCreatedBy != '' OR $proposalCreatedBy != NULL)
        {
            $this->db->where('created_code',$proposalCreatedBy);
        }
        else
        {
            $this->db->where('created_code',NULL, FALSE);
        }
        $data = $this->db->get('minute_meeting_copy_to');
        return $data;
    }

    // get all SDLAC users from minutes copy to table
    public function getUsersSdlacCopyToForSdo($dist_code,$subdiv_code,$proposalCreatedBy)
    {
        $this->db->select();
        $this->db->where('user_desg', 'SDLC');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('created_by', MB_SUB_DIV_COMM);
        if($proposalCreatedBy != '' OR $proposalCreatedBy != NULL)
        {
            $this->db->where('created_code',$proposalCreatedBy);
        }
        else
        {
            $this->db->where('created_code',NULL, FALSE);
        }
        $data = $this->db->get('minute_meeting_copy_to');
        return $data;
    }

    // get all users from users table
    public function getUsersDetail($dist_code, $ucode)
    {
        $this->db->select();
        $this->db->where('user_code', $ucode);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get('users');
        return $data;
    }


    // update settlement Basic table
    public function updateSettlementBasicData($caseNo,$dist_code,$data)
    {
        $this->db->where('case_no',$caseNo);
        $this->db->where('dist_code', $dist_code);
        $this->db->where_in('pending_officer', [MB_DEPUTY_COMM,MB_ADD_DEPUTY_COMM,MB_SUB_DIV_COMM]);
        $this->db->set('date_update', 'NOW()', FALSE);
        $this->db->update('settlement_basic', $data);
        return $this->db->affected_rows();

    }


    // update settlement Basic table
    public function updateSettlementBasicDataOnlyDept($caseNo,$dist_code,$data)
    {
        $this->db->where('case_no',$caseNo);
        $this->db->where('dist_code', $dist_code);
        $this->db->where_in('pending_officer', ['DPT']);
        $this->db->set('date_update', 'NOW()', FALSE);
        $this->db->update('settlement_basic', $data);
        return $this->db->affected_rows();

    }



    // put under consideration
    // count application id by case no for ADC/SDO
    public function countSettlementApplicationDetailsByCaseNoCommon($caseNo,$dist_code)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
            ->where_in('pending_officer', [MB_ADD_DEPUTY_COMM,MB_SUB_DIV_COMM])
            ->where_in('status', [MB_MARK_AS_SDLAC,MB_PENDING])
            ->get('settlement_basic')
            ->num_rows();
    }


    // get  application id by case no
    public function getSettlementAppDetailsByCaseNoDistCode($caseNo,$dist_code)
    {
        $this->db->select();
        $this->db->where('case_no', $caseNo);
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get('settlement_basic');
        return $data;

    }


    public function getApprovedChithaAreaVillageWise
    ($appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage)
    {

        // $data = $this->db->query('SELECT
        //     SUM(sd.s_dag_area_b) as dag_bigha,
        //     SUM(sd.s_dag_area_k) as dag_katha,
        //     SUM(sd.s_dag_area_lc) as dag_lessa,
        //     SUM(sd.s_dag_area_g) as dag_ganda
        //     from settlement_dag_details sd INNER JOIN settlement_basic sb
        //     ON sb.case_no = sd.case_no
        //     Where sd.dist_code=? AND
        //     sd.subdiv_code=? AND
        //     sd.cir_code=? AND
        //     sd.mouza_pargona_code=? AND
        //     sd.lot_no=? AND
        //     sd.vill_townprt_code=? AND
        //     sb.status!=? AND
        //     sb.status!=? AND
        //     sb.dc_proceeding=?',
        //     array($appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,'D','F',1));


        $data = $this->db->query("
         SELECT SUM(sd.s_dag_area_b) as dag_bigha, SUM(sd.s_dag_area_k) as dag_katha, SUM(sd.s_dag_area_lc) as dag_lessa,
         SUM(sd.s_dag_area_g) as dag_ganda from (select * from settlement_dag_details where
         dist_code='$appDistrict' AND subdiv_code='$appSubDiv' AND cir_code='$appCircle'
         AND mouza_pargona_code='$appMouza' AND lot_no='$appLot' AND vill_townprt_code='$appVillage')
         sd INNER JOIN (select * from settlement_basic where 
         dist_code='$appDistrict' AND subdiv_code='$appSubDiv' AND cir_code='$appCircle'
         AND mouza_pargona_code='$appMouza' AND lot_no='$appLot' 
         AND vill_townprt_code='$appVillage' AND status not in ('D','F') AND co_chitha_corrected_yn is null AND order_passed is null 
         AND dc_proceeding=1 AND service_code!='13') sb ON sb.case_no = sd.case_no 
         WHERE sb.service_code!='14' OR (sb.service_code='14' AND sd.new_dag_no is not null) ");

        return $data->row();

    }


    public function getPendingChithaAreaVillageWise
    ($appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage)
    {
        // $data = $this->db->query('SELECT
        //     SUM(sd.s_dag_area_b) as dag_bigha,
        //     SUM(sd.s_dag_area_k) as dag_katha,
        //     SUM(sd.s_dag_area_lc) as dag_lessa,
        //     SUM(sd.s_dag_area_g) as dag_ganda
        //     from settlement_dag_details sd INNER JOIN settlement_basic sb
        //     ON sb.case_no = sd.case_no
        //     Where sd.dist_code=? AND
        //     sd.subdiv_code=? AND
        //     sd.cir_code=? AND
        //     sd.mouza_pargona_code=? AND
        //     sd.lot_no=? AND
        //     sd.vill_townprt_code=? AND
        //     sb.status!=? AND
        //     sb.status!=? AND
        //     sb.status!=? AND
        //     sb.dc_proceeding=?',
        //     array($appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,'D','F','Z',0));


        $data = $this->db->query("
         SELECT SUM(sd.s_dag_area_b) as dag_bigha, SUM(sd.s_dag_area_k) as dag_katha, SUM(sd.s_dag_area_lc) as dag_lessa,
         SUM(sd.s_dag_area_g) as dag_ganda from (select * from settlement_dag_details where
         dist_code='$appDistrict' AND subdiv_code='$appSubDiv' AND cir_code='$appCircle'
         AND mouza_pargona_code='$appMouza' AND lot_no='$appLot' AND vill_townprt_code='$appVillage')
         sd INNER JOIN (select * from settlement_basic where 
         dist_code='$appDistrict' AND subdiv_code='$appSubDiv' AND cir_code='$appCircle'
         AND mouza_pargona_code='$appMouza' AND lot_no='$appLot' 
         AND vill_townprt_code='$appVillage' AND status not in ('D','F','Z') 
         and dc_proceeding=0 and service_code!='13') sb ON sb.case_no = sd.case_no
         WHERE sb.service_code!='14' or (sb.service_code='14' AND sd.new_dag_no is not null)
         ");


        return $data->row();

    }


    public function getTotalChithaAreaInDagVillageWise
    ($appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage)
    {
        $data = $this->db->query('SELECT
            SUM(cb.dag_area_b) as chitha_bigha, 
            SUM(cb.dag_area_k) as chitha_katha, 
            SUM(cb.dag_area_lc) as chitha_lessa, 
            SUM(cb.dag_area_g) as chitha_ganda
            from chitha_basic cb INNER JOIN patta_code pc 
            ON cb.patta_type_code = pc.type_code
            Where cb.dist_code=? AND 
            cb.subdiv_code=? AND 
            cb.cir_code=? AND 
            cb.mouza_pargona_code=? AND 
            cb.lot_no=? AND 
            cb.vill_townprt_code=? AND
            pc.jamabandi=?
            ',
            array($appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,'n'));

        return $data->row();
    }





    // count rejected application by co for ADC
    public function countCoRejectedCaseForADC($dist_code,$service_code)
    {

        $count = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code'
                 and pending_officer='CO' and status='D'
                 and service_code='$service_code' ")->row()->c;

        return $count;
    }

    public function getCoRejectedCaseForADC($service_code, $dist_code)
    {

        $sql = "SELECT vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no 
                FROM settlement_basic WHERE service_code = $service_code AND pending_officer = 'CO'
                AND status = 'D' AND dist_code = '$dist_code'
                GROUP BY vill_townprt_code, dist_code, subdiv_code,
                cir_code, mouza_pargona_code, lot_no";

        $data = $this->db->query($sql);

        return $data->result();
    }




    public function getUsersDLCCopyTo($dist_code, $user_desig_code, $user_log_code)
    {
        $inserted_data = $this->db->query("SELECT * FROM dlc_copy_to WHERE dist_code = ? 
                        and created_by = ? and user_code = ? ORDER BY sl_no",
            array($dist_code, $user_desig_code, $user_log_code));

        return $inserted_data;


    }






    // count rejected application by co for SDO
    public function countCoRejectedCaseForSDO($dist_code, $subdiv_code, $service_code)
    {

        $count = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code'
                 and subdiv_code='$subdiv_code' and pending_officer='CO' and status='D'
                 and service_code='$service_code' ")->row()->c;

        return $count;
    }

    public function getCoRejectedCaseForSDO($service_code,$dist_code,$subdiv_code)
    {

        $sql = "SELECT vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no 
                FROM settlement_basic WHERE service_code = $service_code AND pending_officer = 'CO'
                AND status = 'D' AND dist_code = '$dist_code' AND subdiv_code = '$subdiv_code'
                GROUP BY vill_townprt_code, dist_code, subdiv_code,
                cir_code, mouza_pargona_code, lot_no";

        $data = $this->db->query($sql);

        return $data->result();
    }





    // get all pending proposal list at ADC end
    public function getRevertedMeetingList($dist_code,$createdBy)
    {
        $this->db->select('*');
        $this->db->from('proposal_meeting_list');
        $this->db->where_in('adc_forward_to_dc_status', 2);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('created_by', $createdBy);
        $this->db->where('mb_status', 0);
        $this->db->where('nc', 0);
        $this->db->where("(meeting_type_ins = '" . '' . "' OR meeting_type_ins IS NULL)", null, false);
        $this->db->where("(user_code = '" . $this->session->userdata('user_code') . "' OR user_code IS NULL)", null, false);
        $this->db->order_by('id', 'asc');
        $data = $this->db->get();
        return $data;
    }


    // get all pending proposal list at ADC end
    public function getRevertedMeetingListMbTin($dist_code,$createdBy)
    {
        $this->db->select('*');
        $this->db->from('proposal_meeting_list');
        $this->db->where_in('adc_forward_to_dc_status', 2);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('created_by', $createdBy);
        $this->db->where('mb_status', 3);
        $this->db->where("(user_code = '" . $this->session->userdata('user_code') . "' OR user_code IS NULL)", null, false);
        $this->db->order_by('id', 'asc');
        $data = $this->db->get();
        return $data;
    }



    // get all reverted meeting list at SDO end
    public function getRevertedMeetingListSDO($dist_code,$subdiv_code,$createdBy)
    {
        $this->db->select('*');
        $this->db->from('proposal_meeting_list');
        $this->db->where_in('adc_forward_to_dc_status', 2);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('created_by', $createdBy);
        $this->db->where('mb_status', 0);
        $this->db->where('nc', 0);
        $this->db->where("(meeting_type_ins = '" . '' . "' OR meeting_type_ins IS NULL)", null, false);
        $this->db->where("(user_code = '" . $this->session->userdata('user_code') . "' OR user_code IS NULL)", null, false);
        $this->db->order_by('id', 'asc');
        $data = $this->db->get();
        return $data;
    }


    // get all reverted meeting list at SDO end
    public function getRevertedMeetingListSDOMbTin($dist_code,$subdiv_code,$createdBy)
    {
        $this->db->select('*');
        $this->db->from('proposal_meeting_list');
        $this->db->where_in('adc_forward_to_dc_status', 2);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('created_by', $createdBy);
        $this->db->where('mb_status', 3);
        $this->db->where("(user_code = '" . $this->session->userdata('user_code') . "' OR user_code IS NULL)", null, false);
        $this->db->order_by('id', 'asc');
        $data = $this->db->get();
        return $data;
    }


    // get reverted proposal by list
    public function getRevertedProposalDetailAgainstMeetingId($dist_code,$meetingId)
    {
        $this->db->select('*');
        $this->db->from('settlement_proposal_list');
//        $this->db->where_in('sdlac_prceed_status', [2]);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('proposal_meeting_id', $meetingId);
        $this->db->where('meeting_create_status', 2);
        $this->db->where('status', 1);
        $this->db->where('mb_status', 0);
        $this->db->where('nc', 0);
        $this->db->where('user_code',$this->session->userdata('user_code'));
        $this->db->where_in('service_code',MB_2_SERVICE_CODE_ALLOW_FOR_PROPOSAL);
        $data = $this->db->get();
        return $data;
    }


    // get reverted proposal by list
    public function getRevertedProposalDetailAgainstMeetingIdMbTin($dist_code,$meetingId)
    {
        $this->db->select('*');
        $this->db->from('settlement_proposal_list');
//        $this->db->where_in('sdlac_prceed_status', [2]);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('proposal_meeting_id', $meetingId);
        $this->db->where('meeting_create_status', 2);
        $this->db->where('status', 1);
        $this->db->where_in('service_code',MB_3_SERVICE_CODE_ALLOW_FOR_PROPOSAL);
        $this->db->where('mb_status', 3);
        $data = $this->db->get();
        return $data;
    }


    // get reverted proposal by list
    public function getRevertedProposalDetailAgainstMeetingIdSdoMbTin($dist_code,$meetingId)
    {
        $this->db->select('*');
        $this->db->from('settlement_proposal_list');
//        $this->db->where_in('sdlac_prceed_status', [2]);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('proposal_meeting_id', $meetingId);
        $this->db->where('meeting_create_status', 2);
        $this->db->where('status', 1);
        $this->db->where('mb_status', 3);
        $this->db->where_in('service_code',MB_3_SERVICE_CODE_ALLOW_FOR_PROPOSAL);
        $data = $this->db->get();
        return $data;
    }






    // get all case under reverted proposal by DC
    public function getAllCaseInProposalUnderRevertedMeeting($proposal_no)
    {
        $this->db->select('settlement_proposal_cases.*,
        settlement_basic.dist_code,settlement_basic.subdiv_code,settlement_basic.cir_code,settlement_basic.service_code');
        $this->db->from('settlement_proposal_cases');
        $this->db->join('settlement_basic','settlement_basic.case_no = settlement_proposal_cases.case_no');
        $this->db->where('settlement_proposal_cases.proposal_id', $proposal_no);
        $data = $this->db->get();
        return $data;

    }


    // get proposal details by id SDO
    public function getRevertedProposalDetailsById($proId,$dist_code,$suv_div)
    {
        $this->db->select('*');
        $this->db->from('settlement_proposal_list');
        $this->db->where('id', $proId);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $suv_div);
        $this->db->where('status', 1);
        $this->db->where('mb_status', 0);
        $this->db->where('nc', 0);
        $this->db->where_in('service_code',MB_2_SERVICE_CODE_ALLOW_FOR_PROPOSAL);
        $data = $this->db->get()->row();

        return $data;
    }


    // get proposal details by id
    public function getRevertedProposalDetailsByIdAdc($proId,$dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_proposal_list');
        $this->db->where('id', $proId);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('status', 1);
        $this->db->where('mb_status', 0);
        $this->db->where('nc', 0);
        $this->db->where_in('service_code',MB_2_SERVICE_CODE_ALLOW_FOR_PROPOSAL);
        $data = $this->db->get()->row();

        return $data;
    }


    // get proposal details by id
    public function getRevertedProposalDetailsByIdAdcMbTin($proId,$dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_proposal_list');
        $this->db->where('id', $proId);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('status', 1);
        $this->db->where('mb_status', 3);
        $this->db->where_in('service_code',MB_3_SERVICE_CODE_ALLOW_FOR_PROPOSAL);
        $data = $this->db->get()->row();

        return $data;
    }


    // get proposal details by id
    public function getRevertedProposalDetailsByIdSdoMbTin($proId,$dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_proposal_list');
        $this->db->where('id', $proId);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('status', 1);
        $this->db->where('mb_status', 3);
        $this->db->where_in('service_code',MB_3_SERVICE_CODE_ALLOW_FOR_PROPOSAL);
        $data = $this->db->get()->row();

        return $data;
    }







    // get all Forwarded meeting list at SDO end
    public function getForwardedMeetingListSDO($dist_code,$subdiv_code,$createdBy)
    {
        $this->db->select('*');
        $this->db->from('proposal_meeting_list');
        $this->db->where_in('adc_forward_to_dc_status', 1);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('created_by', $createdBy);
        $this->db->where("(user_code = '" . $this->session->userdata('user_code') . "' OR user_code IS NULL)", null, false);
        $this->db->order_by('id', 'asc');
        $data = $this->db->get();
        return $data;
    }


    public function getProposalDetailAgainstMeetingIdForSdo($meetingId,$dist_code,$subdiv_code,$createdBy)
    {
        $this->db->select('service_code, proposal_name, id as proposal_id');
        $this->db->where('proposal_meeting_id', $meetingId);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('created_by', $createdBy);
        $this->db->where('meeting_create_status', 2);
        $this->db->group_by('service_code, proposal_name, proposal_id');
        $data = $this->db->get('settlement_proposal_list');
        return $data;
    }

    public function getForwardedMeetingDetailByMeetingID($meetingId,$dist_code,$subdiv_code,$createdBy)
    {
        $this->db->select();
        $this->db->where('id', $meetingId);
        $this->db->where_in('adc_forward_to_dc_status', 1);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('created_by', $createdBy);
        $data = $this->db->get('proposal_meeting_list');
        return $data;
    }




    // get all Forwarded meeting list at Adc end
    public function getForwardedMeetingListAdc($dist_code,$createdBy)
    {
        $this->db->select('*');
        $this->db->from('proposal_meeting_list');
        $this->db->where_in('adc_forward_to_dc_status', 1);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('created_by', $createdBy);
        $this->db->where('mb_status', 0);
        $this->db->where('nc', 0);
        $this->db->where("(meeting_type_ins = '" . '' . "' OR meeting_type_ins IS NULL)", null, false);
        $this->db->where("(user_code = '" . $this->session->userdata('user_code') . "' OR user_code IS NULL)", null, false);
        $this->db->order_by('id', 'asc');
        $data = $this->db->get();
        return $data;
    }


    // get all Forwarded meeting list at Adc end
    public function getForwardedMeetingListAdcMbTin($dist_code,$createdBy)
    {
        $this->db->select('*');
        $this->db->from('proposal_meeting_list');
        $this->db->where_in('adc_forward_to_dc_status', 1);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('created_by', $createdBy);
        $this->db->where('mb_status', 3);
        $this->db->where("(user_code = '" . $this->session->userdata('user_code') . "' OR user_code IS NULL)", null, false);
        $this->db->order_by('id', 'asc');
        $data = $this->db->get();
        return $data;
    }


    public function getProposalDetailAgainstMeetingIdForAdc($meetingId,$dist_code,$createdBy)
    {
        $this->db->select('service_code, proposal_name, id as proposal_id');
        $this->db->where('proposal_meeting_id', $meetingId);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('created_by', $createdBy);
        $this->db->where('meeting_create_status', 2);
        $this->db->where('user_code',$this->session->userdata('user_code'));
        $this->db->group_by('service_code, proposal_name, proposal_id');
        $data = $this->db->get('settlement_proposal_list');
        return $data;
    }

    public function getForwardedMeetingDetailByMeetingIDAdc($meetingId,$dist_code,$createdBy)
    {
        $this->db->select();
        $this->db->where('id', $meetingId);
        $this->db->where_in('adc_forward_to_dc_status', 1);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('created_by', $createdBy);
        $this->db->where('mb_status', 0);
        $this->db->where('nc', 0);
        $this->db->where("(meeting_type_ins = '" . '' . "' OR meeting_type_ins IS NULL)", null, false);
        $data = $this->db->get('proposal_meeting_list');
        return $data;
    }

    public function getForwardedMeetingDetailByMeetingIDAdcMbTin($meetingId,$dist_code,$createdBy)
    {
        $this->db->select();
        $this->db->where('id', $meetingId);
        $this->db->where_in('adc_forward_to_dc_status', 1);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('created_by', $createdBy);
        $this->db->where('mb_status', 3);
        $data = $this->db->get('proposal_meeting_list');
        return $data;
    }






    // get all additional document
    public function getMeetingAdditionalDocumentDetail($meetingName)
    {
        $this->db->select();
        $this->db->where('case_no', $meetingName);
        $data = $this->db->get('supportive_document');
        return $data;
    }

    public function getClusterList($dist_code)
    {
        $this->db->select();
        $this->db->where('status', 'AE');
        $data = $this->db->get('settlement_circle_cluster');
        return $data;
    }
    public function getClusterReReport($dist_code)
    {
        $this->db->select();
        $this->db->where('status', 'AF');
        $data = $this->db->get('settlement_basic');
        return $data;
    }

    public function rejectedCaseList($dist_code, $service_code, $rejected_by)
    {
        $this->db->select();
        $this->db->where('status', 'D');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('service_code', $service_code);
        $this->db->where('from_office', $rejected_by);
        return $this->db->count_all_results('settlement_basic');
    }

    public function revivalListCount($dist_code, $service_code, $rejected_by)
    {
        $this->db->select();
        $this->db->where('revival_status', 1);
        $this->db->where('service_code', $service_code);
        $this->db->where('req_by', $rejected_by);
        return $this->db->count_all_results('settlement_revival_flag');
    }

    public function rejectedCaseListSDO($dist_code, $subdiv_code, $service_code, $rejected_by)
    {
        $this->db->select();
        $this->db->where('status', 'D');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('service_code', $service_code);
        $this->db->where('from_office', $rejected_by);
        return $this->db->count_all_results('settlement_basic');
    }

    public function revivalListCountSDO($dist_code, $subdiv_code, $service_code, $rejected_by)
    {
        $this->db->select();
        $this->db->where('revival_status', 1);
        $this->db->where('service_code', $service_code);
        $this->db->where('req_by', $rejected_by);
        return $this->db->count_all_results('settlement_revival_flag');
    }




    // get meeting details
    public function getMeetingDetailByMeetingId($meetingId)
    {

        return $this->db->select()
            ->where('id', $meetingId)
            ->where('mb_status', 0)
            ->get('proposal_meeting_list')
            ->row();
    }


    // get meeting details
    public function getMeetingDetailByMeetingIdReCla($meetingId)
    {

        return $this->db->select()
            ->where('id', $meetingId)
            ->where('mb_status', 0)
            ->where('meeting_type_ins', '40')
            ->get('proposal_meeting_list')
            ->row();
    }



    // get meeting details
    public function getMeetingDetailByMeetingIdMbTin($meetingId)
    {

        return $this->db->select()
            ->where('id', $meetingId)
            ->where('mb_status', 3)
            ->get('proposal_meeting_list')
            ->row();
    }



    // case Under Dept Or DC By WetLand for DC
    public function caseUnderDeptOrDCByWetLand($case_no)
    {
        $data = array();
        $wetLand = 0;
        $sql = $this->db->query('select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,dag_no,
                    (select wet_land from chitha_dag_all_flag_details_final  where
                     dist_code = s.dist_code and subdiv_code = s.subdiv_code and cir_code=s.cir_code 
                     and mouza_pargona_code=s.mouza_pargona_code and lot_no=s.lot_no and vill_townprt_code = s.vill_townprt_code and dag_no=s.dag_no) 
                    from settlement_dag_details s 
                     where case_no = ?',array($case_no));

        $data = $sql->result();

        if(!empty($data))
        {
            if(in_array(6, array_column($data, 'wet_land')))
            {
                $wetLand = 1;
            }
        }

        return $wetLand;
    }


    // count Vgr Pgr reverted Case ADC end
    public function countAllVgrPgrRevertedCaseForAdc($dist_code)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('to_office',MB_ADD_DEPUTY_COMM)
            ->where('status',1)
            ->get('settlement_vgr_pgr_revert_cases')
            ->num_rows();
    }


    // get all Vgr Pgr reverted Case ADC end
    public function getAllVgrPgrRevertedCaseForAdc($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_vgr_pgr_revert_cases');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('to_office', MB_ADD_DEPUTY_COMM);
        $this->db->where('status',1);
        $this->db->order_by('id', 'asc');
        $data = $this->db->get();
        return $data;
    }



    // count Vgr Pgr reverted Case SDO end
    public function countAllVgrPgrRevertedCaseForSdo($dist_code,$subDiv_code)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subDiv_code)
            ->where('to_office',MB_SUB_DIV_COMM)
            ->where('status',1)
            ->get('settlement_vgr_pgr_revert_cases')
            ->num_rows();
    }


    // get Vgr Pgr reverted Case SDO end
    public function getAllVgrPgrRevertedCaseForSdo($dist_code,$subDiv_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_vgr_pgr_revert_cases');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subDiv_code);
        $this->db->where('to_office', MB_SUB_DIV_COMM);
        $this->db->where('status',1);
        $this->db->order_by('id', 'asc');
        $data = $this->db->get();
        return $data;
    }


    // get all Vgr Pgr reverted Case Dc end
    public function getAllVgrPgrRevertedCaseForDc($dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_vgr_pgr_revert_cases');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('to_office', MB_DEPUTY_COMM);
        $this->db->where('status',1);
        $this->db->order_by('id', 'asc');
        $data = $this->db->get();
        return $data;
    }


    // get Vgr Pgr reverted Case details
    public function getVgrPgrRevertedCaseDetails($dist_code,$caseId)
    {
        $this->db->select('*');
        $this->db->from('settlement_vgr_pgr_revert_cases');
        $this->db->where('id', $caseId);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('status',1);
        $data = $this->db->get();
        return $data;
    }


    // get Vgr Pgr reverted Case details for revert back to co
    public function getVgrPgrRevertedCaseDetailsForRevertToCo($rev_id,$case_no,$dist_code,$user_desig_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_vgr_pgr_revert_cases');
        $this->db->where('settlement_vgr_pgr_revert_cases.id', $rev_id);
        $this->db->where('settlement_vgr_pgr_revert_cases.case_no', $case_no);
        $this->db->where('settlement_vgr_pgr_revert_cases.dist_code', $dist_code);
        $this->db->where('settlement_vgr_pgr_revert_cases.to_office', $user_desig_code);
        $this->db->where('settlement_vgr_pgr_revert_cases.status', 1);
        $query = $this->db->get();
        $data  = $query;

        return $data;
    }


    // count count All Pending Vgr-Pgr Reverted Cases (Under Meeting)
    public function countAllPendingVgrPgrRevertedMeetingCases($meetingId,$dist_code)
    {
        return $this->db->select()
            ->where('meeting_id', $meetingId)
            ->where('dist_code', $dist_code)
            ->where('status',1)
            ->get('settlement_vgr_pgr_revert_cases')
            ->num_rows();
    }


    // get all DC rejected case
    public function locationSelectCoRejectCasesDc($service_code)
    {
        $dist_code = $this->session->userdata('dist_code');

        $sql = "SELECT vill_townprt_code, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no FROM 
                settlement_basic WHERE service_code = $service_code AND from_office = 'DC' AND status = 'D' 
                AND dist_code = '$dist_code'  GROUP BY vill_townprt_code, dist_code, subdiv_code, cir_code, 
                mouza_pargona_code, lot_no";
        $data = $this->db->query($sql);

        return $data->result();

    }

    // get alreadyAlloted by LM  (falls Under GMC)
    public function getAlreadyAlloted($case_no)
    {
        return $this->db->select('already_alloted')
            ->where('case_no', $case_no)
            ->get('settlement_ap_lmnote')
            ->row();
    }



    public function getProceedingIdAdc($case_no)
    {
        $query = $this->db->select("MAX(proceeding_id) + 1 AS c", FALSE)
            ->where('case_no', $case_no)
            ->get('settlement_proceeding');

        if ($query->num_rows() > 0)
        {
            return (int) $query->row()->c;
        }

        return 1;

    }


    public function getPendingMeetingDetailByMeetingID($meetingId){
        $this->db->select();
        $this->db->where('id', $meetingId);
        $data = $this->db->get('proposal_meeting_list');
        return $data;
    }


}