<?php
class OfflineCommonModel extends CI_Model
{
    public function __construct() {
        parent::__construct();

    }

    public function createTokenJwtFileUpload()
    {
        $timestamp = date("Y-m-d H:i:s");
        $jwt       = new JWT();
        $key       = DHAR_AUTH_KEY;
        $payload = array(
            "timestamp" => $timestamp
        );
        $token = $jwt->encode($payload, $key, 'HS256');
        return $token;
    }

    function defaultValue($input, $value)
    {
        if (empty($input)) return $value;
        return $input;
    }


    // Offline District Name Circle Name Financial Year
    function generateOfflineCaseName($dist_code,$subdiv_code,$cir_code)
    {
        $financialYearDate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('y') : date('Y') . "-" . date('y', strtotime('+1 year'));

        $name =  $this->db->select('dist_abbr,cir_abbr')
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subdiv_code)
            ->where('cir_code', $cir_code)
            ->where('mouza_pargona_code !=', '00')
            ->get('location')
            ->row();

        if($name)
        {
            $cir_dist_name = $name->dist_abbr . "/" . $name->cir_abbr;
            $case_no = $cir_dist_name . "/" . $financialYearDate . "/" ;
            return $case_no;
        }
        return false;
    }


    // Offline Petition Generate using sequence
    function generateOfflineSettlementPetitionNo()
    {
        $petition_no = $this->db->query("select nextval('seq_max_settlement') as count ")->row()->count;
        return $petition_no;
    }

    // checking for duplicate
    public function checkDupOfflineSettlementCaseNo($caseNo)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get uuid from location table
    public function getUuidFromLocation($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code)
    {

        $name =  $this->db->select('uuid')
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subdiv_code)
            ->where('cir_code', $cir_code)
            ->where('mouza_pargona_code', $mouza_pargona_code)
            ->where('lot_no', $lot_no)
            ->where('vill_townprt_code', $vill_townprt_code)
            ->get('location')
            ->row();

        return $name->uuid;

    }

    // pattadar Cron No.
    public function getPdarCronNoForOffline($case_no)
    {
        $pdarCronNo = $this->db->select('pdar_cron_no')
            ->where('case_no',$case_no)
            ->get('settlement_applicant')->num_rows();
        if($pdarCronNo > 0)
        {
            $cron_no = $pdarCronNo + 1;
        }
        else
        {
            $cron_no = 1;
        }
        return $cron_no;
    }

    // get selected chitha pattadar from village land bank
    public function getSelectedChithaPattadarFromLandBank($id,$dis,$subdiv,$cir,$mza,$lot,$vill,$dag_no)
    {
        $this->db->select('c_land_bank_encroacher_details.*');
        $this->db->distinct();
        $this->db->from('c_land_bank_details');
        $this->db->join('c_land_bank_encroacher_details','c_land_bank_encroacher_details.c_land_bank_details_id = c_land_bank_details.id');
        $this->db->where('c_land_bank_encroacher_details.id',$id);
        $this->db->where('c_land_bank_details.dist_code',$dis);
        $this->db->where('c_land_bank_details.subdiv_code',$subdiv);
        $this->db->where('c_land_bank_details.cir_code',$cir);
        $this->db->where('c_land_bank_details.mouza_pargona_code',$mza);
        $this->db->where('c_land_bank_details.lot_no',$lot);
        $this->db->where('c_land_bank_details.vill_townprt_code',$vill);
        $this->db->where('c_land_bank_details.dag_no',$dag_no);
        $data = $this->db->get()->row();
        return $data;
    }


    // get Guardian Relation list
    public function getGuardianRelation()
    {
        return $this->db->select()
            ->where_not_in('id', ['5','6'])
            ->get('master_guard_rel')
            ->result();

    }



    // count my offline applied application
    public function countMyOfflineApplication($dist_code,$serviceCode,$user_code)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('service_code', $serviceCode)
            ->where('user_code', $user_code)
            ->where('is_offline', 1)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get my offline applied application
    public function getMyOfflineApplication($dist_code,$serviceCode,$user_code)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('service_code', $serviceCode)
            ->where('user_code', $user_code)
            ->where('is_offline', 1)
            ->get('settlement_basic');
    }


    public function offlineApplicationForMeeting($dist_code,$serviceCode)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('service_code', $serviceCode)
            ->where('is_offline', 1)
            ->where('status', 'Z')
            ->where('pending_office', MB_DEPUTY_COMM)
            ->where('pending_officer', MB_DEPUTY_COMM)
            ->get('settlement_basic');
    }



    public function countOfflineApplicationForMeeting($dist_code,$serviceCode)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('service_code', $serviceCode)
            ->where('is_offline', 1)
            ->where('status', 'Z')
            ->where('pending_office', MB_DEPUTY_COMM)
            ->where('pending_officer', MB_DEPUTY_COMM)
            ->get('settlement_basic')
            ->num_rows();
    }


    // count meeting pending with ADC
    public function countOfflinePendingMeeting($dist_code,$serviceCode)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('service_code', $serviceCode)
            ->where('meeting_status', 1)
            ->get('offline_meeting_list')
            ->num_rows();
    }


    // Get meeting pending with ADC
    public function getOfflinePendingMeeting($dist_code,$serviceCode)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('service_code', $serviceCode)
            ->where('meeting_status', 1)
            ->where('status', 1)
            ->get('offline_meeting_list');
    }

    // Get meeting details
    public function getOfflineMeetingDetails($dist_code,$meetingId,$serviceCode)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('id', $meetingId)
            ->where('service_code', $serviceCode)
            ->where('status', 1)
            ->get('offline_meeting_list');
    }


    // get meeting case details with SDLAC Rec
    public function getMeetingCaseDetails($meetingId,$serviceCode)
    {
        $this->db->select('offline_meeting_cases.*, offline_settlement_case_details.sdlac_rec,offline_settlement_case_details.sdlac_rec_date');
        $this->db->from('offline_meeting_cases');
        $this->db->join('offline_settlement_case_details','offline_settlement_case_details.case_no = offline_meeting_cases.case_no');
        $this->db->where('offline_meeting_cases.meeting_id',$meetingId);
        $this->db->where('offline_meeting_cases.service_code',$serviceCode);
        $data = $this->db->get();
        return $data;
    }

    // get meeting case list
    public function getMeetingCaseList($dist_code,$meetingId,$serviceCode)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('meeting_id', $meetingId)
            ->where('service_code', $serviceCode)
            ->where('status', 1)
            ->get('offline_meeting_cases');

    }






    // count pending offline applied application LM
    public function countPendingOfflineApplication($dist_code,$subDiv_code,$cir_code,$mouza_code,$lot_no,$serviceCode)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subDiv_code)
            ->where('cir_code', $cir_code)
            ->where('mouza_pargona_code', $mouza_code)
            ->where('lot_no', $lot_no)
            ->where('service_code', $serviceCode)
            ->where('status', 'Z')
            ->where('is_offline', 1)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get all pending application list LM
    public function getPendingOfflineApplicationList($dist_code,$subDiv_code,$cir_code,$mouza_code,$lot_no,$serviceCode)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subDiv_code)
            ->where('cir_code', $cir_code)
            ->where('mouza_pargona_code', $mouza_code)
            ->where('lot_no', $lot_no)
            ->where('service_code', $serviceCode)
            ->where('status', 'Z')
            ->where('is_offline', 1)
            ->get('settlement_basic');
    }

    // count Reverted pending offline  application LM
    public function countRevertedOfflineApplication($dist_code,$subDiv_code,$cir_code,$mouza_code,$lot_no,$serviceCode)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subDiv_code)
            ->where('cir_code', $cir_code)
            ->where('mouza_pargona_code', $mouza_code)
            ->where('lot_no', $lot_no)
            ->where('service_code', $serviceCode)
            ->where('status', 'R')
            ->where('pending_officer', MB_LOT_MONDOL)
            ->where('is_offline', 1)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get all Reverted pending application list LM
    public function getRevertedOfflineApplicationList($dist_code,$subDiv_code,$cir_code,$mouza_code,$lot_no,$serviceCode)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subDiv_code)
            ->where('cir_code', $cir_code)
            ->where('mouza_pargona_code', $mouza_code)
            ->where('lot_no', $lot_no)
            ->where('service_code', $serviceCode)
            ->where('status', 'R')
            ->where('pending_officer', MB_LOT_MONDOL)
            ->where('is_offline', 1)
            ->get('settlement_basic');
    }







    // count  pending offline application CO
    public function countPendingOfflineApplicationCo($dist_code,$subDiv_code,$cir_code,$serviceCode)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subDiv_code)
            ->where('cir_code', $cir_code)
            ->where('service_code', $serviceCode)
            ->where('status', 'W')
            ->where('pending_office', MB_CIRCLE_OFFICER)
            ->where('pending_officer', MB_CIRCLE_OFFICER)
            ->where('is_offline', 1)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get all pending application list CO
    public function getPendingOfflineApplicationListCo($dist_code,$subDiv_code,$cir_code,$serviceCode)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subDiv_code)
            ->where('cir_code', $cir_code)
            ->where('service_code', $serviceCode)
            ->where('status', 'W')
            ->where('pending_office', MB_CIRCLE_OFFICER)
            ->where('pending_officer', MB_CIRCLE_OFFICER)
            ->where('is_offline', 1)
            ->get('settlement_basic');
    }

    // count Re-Report pending offline applied application CO
    public function countReReportOfflineApplicationCo($dist_code,$subDiv_code,$cir_code,$serviceCode)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subDiv_code)
            ->where('cir_code', $cir_code)
            ->where('service_code', $serviceCode)
            ->where('status', 'X')
            ->where('pending_officer', MB_CIRCLE_OFFICER)
            ->where('is_offline', 1)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get all Re-Report pending application list CO
    public function getReReportOfflineApplicationListCo($dist_code,$subDiv_code,$cir_code,$serviceCode)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subDiv_code)
            ->where('cir_code', $cir_code)
            ->where('service_code', $serviceCode)
            ->where('status', 'X')
            ->where('pending_officer', MB_CIRCLE_OFFICER)
            ->where('is_offline', 1)
            ->get('settlement_basic');
    }





    // count  pending offline application CO
    public function countPendingOfflineApplicationSdo($dist_code,$subDiv_code,$serviceCode)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subDiv_code)
            ->where('service_code', $serviceCode)
            ->where('status', 'W')
            ->where('pending_office', MB_DEPUTY_COMM)
            ->where('pending_officer', MB_SUB_DIV_COMM)
            ->where('is_offline', 1)
            ->get('settlement_basic')
            ->num_rows();
    }

    // get all pending application list CO
    public function getPendingOfflineApplicationListSdo($dist_code,$subDiv_code,$serviceCode)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subDiv_code)
            ->where('service_code', $serviceCode)
            ->where('status', 'W')
            ->where('pending_office', MB_DEPUTY_COMM)
            ->where('pending_officer', MB_SUB_DIV_COMM)
            ->where('is_offline', 1)
            ->get('settlement_basic');
    }



    // count offline application by case no service code
    public function countOfflineApplicationByCaseNo($dist_code,$caseNo)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('case_no', $caseNo)
            ->where('is_offline', 1)
            ->get('settlement_basic')
            ->num_rows();
    }

    // count offline application by case no service code
    public function countOfflineApplicationByCaseNoServiceCode($dist_code,$caseNo,$serviceCode)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('case_no', $caseNo)
            ->where('service_code', $serviceCode)
            ->where('is_offline', 1)
            ->get('settlement_basic')
            ->num_rows();
    }


    // get offline application by case no
    public function getOfflineApplicationByCaseNo($dist_code,$caseNo)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('case_no', $caseNo)
            ->where('is_offline', 1)
            ->get('settlement_basic')
            ->row();
    }


    // get offline sdlac case details  by case no
    public function getOfflineSdlacDetailsByCaseNo($caseNo)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('status', 1)
            ->get('offline_settlement_case_details')
            ->row();
    }


    // count offline application by case no service code
    public function countOfflineApplicationByCaseNoInBasic($dist_code,$caseNo)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('case_no', $caseNo)
            ->where('is_offline', 1)
            ->where('status', 'Z')
            ->where('pending_officer', MB_DEPUTY_COMM)
            ->get('settlement_basic')
            ->num_rows();
    }

    // count offline application by case no under Meeting
    public function countOfflineApplicationByCaseNoUnderMeeting($dist_code,$caseNo)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('case_no', $caseNo)
            ->where('is_offline', 1)
            ->where('status', MB_SEND_TO_SDLAC)
            ->where('pending_officer', MB_ADD_DEPUTY_COMM)
            ->get('settlement_basic')
            ->num_rows();
    }


    // count case already in meeting
    public function countOfflineApplicationByCaseNoInMeetingList($caseNo)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where_in('case_status', [1,2])
            ->get('offline_meeting_cases')
            ->num_rows();
    }



    // get offline application by case no in array
    public function getOfflineApplicationArrayByCaseNo($dist_code,$caseNo)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('case_no', $caseNo)
            ->where('is_offline', 1)
            ->get('settlement_basic')
            ->row_array();
    }

    // get offline application by case no service code
    public function getOfflineApplicationByCaseNoServiceCode($dist_code,$caseNo,$serviceCode)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('case_no', $caseNo)
            ->where('service_code', $serviceCode)
            ->where('is_offline', 1)
            ->get('settlement_basic')
            ->row();
    }

    // get all applicant
    public function getApplicantOfflineApplication($dist_code,$caseNo)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('case_no', $caseNo)
            ->where('pdar_type', 'B')
            ->get('settlement_applicant')
            ->result();
    }


    // get All Applicant Encroacher
    public function getAllApplicantEncroacher($caseNo)
    {
        $applicants = $this->db->select()
            ->where('case_no',$caseNo)
            ->where('pdar_type', 'EN')
            ->get('settlement_applicant');
        return $applicants->result();
    }

    // get all applicant owners
    public function getAllApplicantOwners($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where('pdar_type', 'O')
            ->get('settlement_applicant');
        return $applicants->result();
    }


    // deleted settlement_dag_details data from settlement_deleted_data table
    public function getDeletedEncroacher($case)
    {
        $enc = $this->db->select()
            ->where('case_no',$case)
            ->where('table_name', 'settlement_applicant')
            ->get('settlement_deleted_data')
            ->result();

        $deletedEncArray = array();
        foreach($enc as $encroacherDeleted_data)
        {
            $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
        }

        return $deletedEncArray;
    }


    // get land bank data
    public function getLandBankData($caseNo, $dagNo, $uuid)
    {
        return $applicants = $this->db->select()
            ->where('application_no',$caseNo)
            ->where('dag_no', $dagNo)
            ->where('uuid', $uuid)
            ->get('settlement_land_bank_details');

    }

    // get land bank data with id
    public function getSelectedLandBankData($id)
    {
        return $applicants = $this->db->select('dag_no, status')
            ->where('id',$id)
            ->get('land_bank_details')
            ->row();

    }

    // get dag details with case no
    function getOfflineSettlementDagDetails($dist_code,$case_no)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('case_no',$case_no)
            ->get('settlement_dag_details')
            ->result();

    }

    // get dag details with case no
    function getOfflineSettlementDagDetailsRow($dist_code,$case_no)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('case_no',$case_no)
            ->get('settlement_dag_details');

    }

    // get all offline settlement deleted dags
    public function getDeletedDags($case)
    {
        $dags = $this->db->select()
            ->where('case_no',$case)
            ->where('table_name', 'settlement_dag_details')
            ->get('settlement_deleted_data')
            ->result();

        $deletedData = array();
        foreach($dags as $deleteDag)
        {
            $deletedData[] = json_decode($deleteDag->table_data);
        }

        return $deletedData;
    }


    // get chitha dag details
    public function getChithaDagAreaDetails($appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag)
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
        and status not in('D','F') and dc_proceeding=1) settlement_basic
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
        and status not in('D','F') and dc_proceeding=0) settlement_basic
        ON settlement_basic.case_no = settlement_dag_details.case_no
        ");

        return $applications->result();
    }


    // get all approve cases village wise
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
         AND vill_townprt_code='$appVillage' AND status not in ('D','F') 
         AND dc_proceeding=1 AND service_code!='13') sb ON sb.case_no = sd.case_no 
         WHERE sb.service_code!='14' OR (sb.service_code='14' AND sd.new_dag_no is not null) ");

        return $data->row();

    }

    // get all pending cases village wise
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

    // get all chitha area in village
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


    // get location for ADC / DC
    public function getLocationNameAdcDc($dist_code)
    {
        $this->db->select('subdiv_code, cir_code');
        $this->db->from('settlement_basic');
        $this->db->where('dist_code', $dist_code);
        $this->db->group_by('subdiv_code,cir_code');
        $data = $this->db->get();
        return $data;
    }

    // get Village name
    public function getVillageNameForNc($subdiv,$circle)
    {
        $query = $this->db->query("SELECT B.subdiv_code,B.cir_code,B.mouza_pargona_code,
            B.lot_no,B.vill_townprt_code, B.loc_name FROM settlement_basic A 
            JOIN location B ON A.uuid=B.uuid
            WHERE B.subdiv_code=? and B.cir_code=? and B.vill_townprt_code!='00000'
            GROUP BY B.subdiv_code,B.cir_code,B.mouza_pargona_code,B.lot_no,B.vill_townprt_code, B.loc_name",
            array($subdiv, $circle))->result();

        return $query;
    }

    // area history
    public function checkIfAreaModified($case_no)
    {
        $areaHistory = $this->db->select()
            ->where('case_no',$case_no)
            ->get('settlement_area_history');

        if($areaHistory->num_rows() > 0)
        {
            return $areaHistory->result();
        }
        else
        {
            return false;
        }
    }

    // check if SDO exist for that area
    public function headquarterCheck($dist_code, $subdiv_code)
    {
        $sqlDistHeadQtr = $this->db->query("SELECT district_headquater FROM location WHERE dist_code = ?  AND subdiv_code = ? AND cir_code = '00' AND mouza_pargona_code = '00' AND vill_townprt_code = '00000' AND lot_no = '00'", array($dist_code, $subdiv_code));

        if($sqlDistHeadQtr->num_rows() > 0)
        {
            return $sqlDistHeadQtr->row()->district_headquater;
        }
        else
        {
            return false;
        }

    }

    // check if SDO exist
    public function userCheckSDO($dist_code, $subdiv_code)
    {
        $sdoUserCheck = $this->db->query("SELECT * FROM loginuser_table WHERE dist_code = ? AND subdiv_code = ? AND dis_enb_option = ? AND user_code LIKE ? LIMIT 1", array($dist_code, $subdiv_code, 'E', '%SDO%'));

        if($sdoUserCheck->num_rows() > 0){
            return 'y';
        }
        else
        {
            return 'n';
        }
    }

    // SK Report Check For Proceeding
    public function skReportCheckForProceeding($caseNo)
    {
        return $this->db->select()
            ->where('case_no',$caseNo)
            ->where('office_from','SK')
            ->where('office_to',MB_CIRCLE_OFFICER)
            ->get('settlement_proceeding');
    }



    // get all applicant family member
    public function getAllNomineeDetail($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_nominee');
        return $applicants->result();
    }


    // get all document with case no
    public function getDocuments($case)
    {
        $docs = $this->db->select()
            ->where('case_no',$case)
            ->where('applid',NULL)
            ->get('supportive_document')
            ->result();

        return $docs;
    }

    // get all document TraceMap / Field Report
    public function getDocumentsTraceMapFieldMap($case)
    {
        $docs = $this->db->select()
            ->where('case_no',$case)
            ->where('applid',$case)
            ->get('supportive_document')
            ->result();

        return $docs;
    }

    // get all document with file id
    public function getDocumentsWithFileId($fileId)
    {
        $docs = $this->db->select()
            ->where('id',$fileId)
            ->get('supportive_document')
            ->row();

        return $docs;
    }


    // get minutes document with file id
    public function getMinutesDocWithFileId($fileId)
    {
        $docs = $this->db->select()
            ->where('id',$fileId)
            ->where('status',1)
            ->get('offline_settlement_case_details')
            ->row();

        return $docs;
    }


    // get additional property
    public function getAdditionalProperty($caseNo)
    {
        $proceedings = $this->db->select()
            ->where('case_no',$caseNo)
            ->get('settlement_additional_property');

        return $proceedings;
    }


    // get all proceeding
    public function getOfflineApplicationProceeding($case)
    {
        $proceedings = $this->db->select()
            ->where('case_no',$case)
            ->order_by('proceeding_id', 'desc')
            ->get('settlement_proceeding');

        return $proceedings->result();
    }


    // get premium amount
    public function getOfflineAppPremium($case)
    {
        $premium = "SELECT sp.*,spa.area,spl.land_type,spr.house_type,spr.rate_type as ratetype FROM settlement_premium sp inner join settlement_premium_area spa on spa.paid=sp.area_name inner join settlement_premium_land_type spl on spl.plid=sp.land_type inner join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no='$case' and is_final=1";
        $data    = $this->db->query($premium);
        return $data->result();

    }

    // get calculation of premium
    public function checkOfflineAppPremium($caseNo)
    {
        $premium = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and is_final= ?", array($caseNo, 1));
        return $premium;

    }

    // get calculated of premium
    public function getOfflineAppCalPremium($caseNo)
    {
        $premium = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and is_final= ?", array($caseNo, 1));
        return $premium->row();

    }



    // count premium amount
    public function countOfflineAppPremium($case)
    {
        $premium = "SELECT sp.*,spa.area,spl.land_type,spr.house_type,spr.rate_type as ratetype FROM settlement_premium sp inner join settlement_premium_area spa on spa.paid=sp.area_name inner join settlement_premium_land_type spl on spl.plid=sp.land_type inner join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no='$case' and is_final=1";
        $data    = $this->db->query($premium);
        return $data->num_rows();

    }


    // get all circle officer
    public function getCoName($d, $s, $c)
    {
        $sql = "select u.username, lt.user_code, u.user_desig_code from loginuser_table lt join users u on lt.dist_code=u.dist_code 
            and lt.subdiv_code=u.subdiv_code and lt.cir_code=u.cir_code
            and u.user_code=lt.user_code where lt.dis_enb_option='E' 
            and u.user_desig_code = 'CO' and lt.dist_code='$d' 
            and lt.subdiv_code='$s' and lt.cir_code='$c'";
        $data = $this->db->query($sql);
        return $data->result();
    }


    // show reject modal
    public function getRejectModal($service_code)
    {
        $sql = $this->db->query("SELECT chitha_flag, sub_input_type, remark_head, service_code, reject_code, remark FROM reject_master WHERE flag=? and service_code=?", array('1', (string)$service_code));
        if($sql->num_rows() > 0)
        {
            return $sql->result();
        }
        else
        {
            return 'n';
        }
    }


    public function checkMaxAreaAllowed($prid)
    {
        $sql = $this->db->query("SELECT max_land FROM settlement_premium_rate WHERE paid = ? limit 1", array($prid));

        if($sql->num_rows() > 0)
        {
            return $sql->row();
        }
        else
        {
            return false;
        }
    }


    public function getChithaFlaggedRemarks($dags, $rejected_list)
    {
        $dagFlagCheckChitha = '';
        foreach($dags as $cd)
        {
            foreach($rejected_list as $rej_list_key => $rej_list_chitha)
            {
                if($rej_list_chitha->chitha_flag != 0)
                {

                    $chithaUuid = $this->utilityclass->getVillageUUID($cd->dist_code, $cd->subdiv_code, $cd->cir_code, $cd->mouza_pargona_code, $cd->lot_no, $cd->vill_townprt_code);

                    $resp = $this->utilityclass->getChithaFlagRemarks((string)$chithaUuid, (string)$cd->dag_no, $rej_list_chitha->chitha_flag);
                    if($resp == true)
                    {
                        $frech = '';
                        foreach($resp as $pp)
                        {
                            $frech .= $pp->remark.", ";
                        }
                        $dagFlagCheckChitha .= "<div class='text-danger alert-warning pl-2 pr-2 pb-1'><b style='border-radius:2px; background:red; color:white; padding:3px;'>Dag No ".$cd->dag_no." </b> &nbsp; <i class='fa fa-arrow-right' aria-hidden='true'></i> <span style='background:yellow; color:black; font-weight:500;'>This dag is flagged in Chitha with the followings - ".$frech."</span></div>";
                        break;
                    }
                }
            }
        }
        return $dagFlagCheckChitha;
    }


    // get all offline lm note
    public function getNcLmNote($case)
    {
        $lmNotes = $this->db->select()
            ->where('case_no',$case)
            ->order_by('id', 'DESC')
            ->limit(1)
            ->get('settlement_ap_lmnote');
        return $lmNotes->result();
    }

    // get all settlement reservation
    public function getOfflineSettlementReservation($case)
    {
        $data = $this->db->select()
            ->where('case_no',$case)
            ->where('is_deleted != 1')
            ->get('settlement_reservation');

        return $data->result();
    }


    // count offline lm note
    public function countNcLmNote($case)
    {
        $lmNotes = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_ap_lmnote');
        return $lmNotes->num_rows();
    }


    // checking for user pending with
    public function checkUserPendingWithByCaseNo($caseNo)
    {
        $dist_code = trim($this->session->userdata('dist_code'));
        $uDeg      = trim($this->session->userdata('user_desig_code'));
        $dataFound =  $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('case_no', $caseNo)
            ->where('pending_officer', $uDeg)
            ->where('is_offline', 1)
            ->get('settlement_basic')
            ->num_rows();

        if($dataFound != 1)
        {
            $errors = '#MROFF00999: You are not authorized for this Application !';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() . "index.php/home");
        }
    }


    // ADC update settlement Basic table
    public function updateOfflineBasicDataAdc($caseNo,$dist_code,$serviceCode,$data)
    {
        $this->db->where('case_no',$caseNo);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('service_code', $serviceCode);
        $this->db->where('is_offline', 1);
        $this->db->where('pending_officer', MB_DEPUTY_COMM);
        $this->db->set('date_update', 'NOW()', FALSE);
        $this->db->update('settlement_basic', $data);
        return $this->db->affected_rows();
    }



    public function lmRejectedValidationBypassFalse($service_code)
    {
        if($_POST['lm_note'] == '2')
        {
            //*****creating rejected_reasons array for insertion */
            $rejected_reasons = $_POST['rejected_reasons'];

            if(isset($_POST['sub_rejected_reasons']))
            {
                $sub_rej_reasons = $_POST['sub_rejected_reasons'];
            }
            else
            {
                $sub_rej_reasons = array();
            }

            $reject_remarks_arr = array();

            $firstArray = array();
            $secondArray = array();

            foreach($rejected_reasons as $rej_key => $rej_val)
            {
                $firstArray[] = $rej_key;
            }

            foreach($sub_rej_reasons as $sub_rej_key => $sub_rej_val)
            {
                $secondArray[] = $sub_rej_key;
            }

            $dif_array = array_diff($firstArray, $secondArray);

            foreach($dif_array as $key)
            {
                foreach($rejected_reasons as $rej_key => $rej_val)
                {
                    if($key == $rej_key)
                    {

                        $rd_val = explode('_', $rej_key);

                        if(isset($rd_val[1]))
                        {
                            $remark_dag_nost = $rd_val[1];
                        }
                        else
                        {
                            $remark_dag_nost = '';
                        }

                        $reject_remarks_arr[] = (object)[
                            'reject_code' => $rej_val,
                            'dag_no' => $remark_dag_nost,
                            'service_code' => $service_code,
                            'sub_rejected_remark' => '',
                        ];
                    }
                }
            }


            foreach($rejected_reasons as $rej_key => $rej_val)
            {
                foreach($sub_rej_reasons as $sub_rej_key => $sub_rej_val)
                {
                    if($rej_key == $sub_rej_key)
                    {
                        $rdt_val = explode('_', $sub_rej_key);

                        if(isset($rdt_val[1]))
                        {
                            $remark_dag_no = $rdt_val[1];
                        }
                        else
                        {
                            $remark_dag_no = '';
                        }
                        $reject_remarks_arr[] = (object)[
                            'reject_code' => $rej_val,
                            'dag_no' => $remark_dag_no,
                            'service_code' => $service_code,
                            'sub_rejected_remark' => $sub_rej_val,
                        ];
                    }
                }
            }

            //*****for inserting in the lm rejected_reason */
            $reject_remarks = $reject_remarks_arr;
        }
        else
        {
            $reject_remarks = null;
        }

        return (object)[
            'reject_remarks' => $reject_remarks,
        ];

    }


    // get all settlement reservation
    public function getSettlementReservation($case)
    {
        $lmnotes = $this->db->select()
            ->where('case_no',$case)
            ->where('is_deleted != 1')
            ->get('settlement_reservation');
        return $lmnotes->result();
    }

    // get proceeding id
    public function getOfflineProceedingId($caseNo)
    {
        $sql = $this->db->query('Select max(proceeding_id)+1 as c from settlement_proceeding where case_no=? ',array($caseNo));
        $proceeding_id = $sql->row()->c;
        if ($proceeding_id == null)
        {
            $proceeding_id = 1;
        }

        return $proceeding_id;
    }


}