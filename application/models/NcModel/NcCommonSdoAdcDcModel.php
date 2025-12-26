<?php
class NcCommonSdoAdcDcModel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }


    // NC code by Masud Reza (10/02/2024)

    //////////////// *************** **************** ////////////////


    // SDO update settlement Basic table
    public function updateNcBasicDataSdo($caseNo,$dist_code,$suv_div,$serviceCode,$data)
    {
        $this->db->where('case_no',$caseNo);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $suv_div);
        $this->db->where('service_code', $serviceCode);
        $this->db->where('pending_officer', MB_SUB_DIV_COMM);
        $this->db->set('date_update', 'NOW()', FALSE);
        $this->db->update('settlement_basic', $data);
        return $this->db->affected_rows();
    }


    // ADC update settlement Basic table
    public function updateNcBasicDataAdc($caseNo,$dist_code,$serviceCode,$data)
    {
        $this->db->where('case_no',$caseNo);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('service_code', $serviceCode);
        $this->db->where('pending_officer', MB_ADD_DEPUTY_COMM);
        $this->db->set('date_update', 'NOW()', FALSE);
        $this->db->update('settlement_basic', $data);
        return $this->db->affected_rows();
    }


    // DC update settlement Basic table (common DC/ADC/SDO)
    public function updateNcBasicDataDc($caseNo,$dist_code,$serviceCode,$data)
    {
        $this->db->where('case_no',$caseNo);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('service_code', $serviceCode);
        $this->db->where('pending_officer', MB_DEPUTY_COMM);
        $this->db->set('date_update', 'NOW()', FALSE);
        $this->db->update('settlement_basic', $data);
        return $this->db->affected_rows();
    }


    // DC/ADC/SDO update settlement Basic table (common DC/ADC/SDO)
    public function updateNcBasicDataDcAdcSdo($caseNo,$dist_code,$serviceCode,$data)
    {
        $this->db->where('case_no',$caseNo);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('service_code', $serviceCode);
        $this->db->where_in('pending_officer', [MB_DEPUTY_COMM,MB_ADD_DEPUTY_COMM,MB_SUB_DIV_COMM]);
        $this->db->set('date_update', 'NOW()', FALSE);
        $this->db->update('settlement_basic', $data);
        return $this->db->affected_rows();
    }


    // save proposal list for SDLAC
    public function saveProposalSDLACCases($data)
    {
        $this->db->set('created_at', 'NOW()', FALSE);
        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->insert('settlement_proposal_list', $data);
        return $this->db->trans_status();

    }


    // save proposal case list for SDLAC
    public function saveProposalCaseListSDLAC($data)
    {
        $this->db->set('created_at', 'NOW()', FALSE);
        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->insert('settlement_proposal_cases', $data);
        return $this->db->trans_status();
    }


    // count proposal file name duplicate
    public function checkDuplicateFileNameInProposal($fileName)
    {
        return $this->db->select()
            ->where('file_path', $fileName)
            ->get('settlement_proposal_list')
            ->num_rows();
    }


    // get all NC application details from  basic
    public function getNcApplicationBasic($case)
    {
        $basic = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_basic');

        return $basic->row_array();
    }



    // get Settlement Basic Details by case no
    public function getNcBasicDetails($caseNo)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->get('settlement_basic')
            ->row();
    }


    // get all applicant buyers
    public function getAllNcApplicantBuyers($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where('pdar_type', 'B')
            ->order_by('is_applicant', 'desc')
            ->get('settlement_applicant');

        return $applicants->result();
    }

    // get all applicant owners
    public function getAllNcApplicantOwners($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where('pdar_type', 'O')
            ->get('settlement_applicant');
        return $applicants->result();
    }

    // get all applicant encroacher
    public function getAllNcApplicantEncroacher($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where('pdar_type', 'EN')
            ->get('settlement_applicant');
        return $applicants->result();
    }


    // get all applicant riotee nok
    public function getAllNcApplicantRioteeNok($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where_in('pdar_type', ['P','GP','GGP'])
            ->get('settlement_applicant');
        return $applicants->result();
    }


    // get all nc dag
    public function getNcApplicationDag($case)
    {
        $dags = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_dag_details');

        return $dags->result();
    }


    // get all Nc lm note
    public function getNcLmNote($case)
    {
        $lmNotes = $this->db->select()
            ->where('case_no',$case)
            ->order_by('id', 'DESC')
            ->limit(1)
            ->get('settlement_ap_lmnote');
        return $lmNotes->result();
    }


    // get all nc proceeding
    public function getNcApplicationProceeding($case)
    {
        $proceedings = $this->db->select()
            ->where('case_no',$case)
            ->order_by('proceeding_id', 'desc')
            ->get('settlement_proceeding');

        return $proceedings->result();
    }


    // get all Nc Document
    public function getNcDocuments($case)
    {
        $applicaiton_no = $this->ncutility->getApplidFromCaseNo($case);
        $proceedings = $this->db->select()
            ->where('case_no in (\''.$applicaiton_no.'\', \''.$case.'\')')
            ->get('supportive_document');

        return $proceedings->result();
    }

    // get all Nc Nominee
    public function getAllNcNomineeDetail($case)
    {
//        $property = $this->db->select()
//            ->where('case_no = \''.$case.'\' or applid = \''.$case.'\'')
//            ->get('settlement_additional_property');
//
//        return $property->result();

        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_nominee');

        return $applicants->result();
    }




    // get all applicant encroacher
    public function getAllNcEncroacherDetailsWithId($encroacherId)
    {
        $applicants = $this->db->select()
            ->where('id',$encroacherId)
            ->get('c_land_bank_encroacher_details');

        return $applicants->result();
    }


    // get premium amount
    public function getNcPremium($case)
    {
        $premium = "SELECT sp.*,spa.area,spl.land_type,spr.house_type,spr.rate_type as ratetype FROM settlement_premium sp inner join settlement_premium_area spa on spa.paid=sp.area_name inner join settlement_premium_land_type spl on spl.plid=sp.land_type inner join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no='$case' and is_final=1";
        $data    = $this->db->query($premium);
        return $data->result();

    }


    // for guardian relation
    public function getNcGuardRelation()
    {
        $queryD = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
        $data   = $this->db->query($queryD);
        return $data;
    }


    // get all Nc deleted dags
    public function getNcDeletedDags($case)
    {
        $dags = $this->db->select()
            ->where('case_no',$case)
            ->where('table_name', 'settlement_dag_details')
            ->get('settlement_deleted_data');

        return $dags->result();
    }



    // get all Nc Deleted Encroacher
    public function getNcDeletedEncroacher($case)
    {
        $enc = $this->db->select()
            ->where('case_no',$case)
            ->where('table_name', 'settlement_applicant')
            ->get('settlement_deleted_data');

        return $enc->result();
    }


    // show reject modal
    public function getNcRejectModal($service_code)
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

    // show rejected head
    public function getNcRejectHead($r_code)
    {
        $head = $this->db->select('remark_head')
            ->where('reject_code',$r_code)
            ->get('reject_master');

        return $head->row();

    }


    // get all Nc additional property
    public function getNcAdditionalProperty($case)
    {
        $property = $this->db->select()
            ->where('case_no = \''.$case.'\' or applid = \''.$case.'\'')
            ->get('settlement_additional_property');

        return $property->result();
    }


    // get chitha dag details
    public function getNcChithaDagAreaDetails($appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta)
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
    public function getAllNcDagAreaDetailsByLocation($appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta)
    {
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
    public function getAllNcDagAreaDetailsByLocationNotSubmit($appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta,$application_no)
    {
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



    // get all settlement reservation
    public function getNcReservation($case)
    {
        $lmnotes = $this->db->select()
            ->where('case_no',$case)
            ->where('is_deleted', 0)
            ->get('settlement_reservation');

        return $lmnotes->result();
    }



    // get land bank details
    public function getNcLandBankDetails($application_no,$dag_no)
    {
        return $this->db->select()
            ->where('application_no', $application_no)
            ->where('dag_no', $dag_no)
            ->get('settlement_land_bank_details');

    }


    // get land bank details with village
    public function getNcLandBankDetailsWithVillage($land_bank_details_id,$enc_uuid,$enc_dag_no,$enc_encroacher_id)
    {
        $query = $this->db->query("SELECT B.land_bank_details_id, B.id AS enc_id, A.dag_no, A.village_uuid AS 
            uuid, B.name, B.fathers_name, B.encroachment_from, B.encroachment_to, B.landless_indigenous, B.erosion,
            B.landless, B.caste, B.gender, B.type_of_land_use, B.application_no FROM land_bank_details A INNER JOIN
            land_bank_encroacher_details B ON A.id = B.land_bank_details_id where A.id = ? AND A.village_uuid = ?
            AND A.dag_no = ? AND B.id = ? ORDER BY A.id DESC LIMIT 1",
            array($land_bank_details_id, $enc_uuid,$enc_dag_no,$enc_encroacher_id));

        return $query;
    }



    // ********************************************************************************


    // get location for SDO
    public function getLocationNameSdo($dist_code,$sub_code)
    {
        $this->db->select('subdiv_code, cir_code');
        $this->db->from('settlement_basic');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $sub_code);
        $this->db->group_by('subdiv_code,cir_code');
        $data = $this->db->get();
        return $data;

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


    public function headquarterCheck($dist_code, $subdiv_code)
    {
        $sqlDistHeadQtr = $this->db->query("SELECT district_headquater FROM location WHERE dist_code = ?  AND subdiv_code = ? AND cir_code = '00' AND mouza_pargona_code = '00' AND vill_townprt_code = '00000' AND lot_no = '00'", array($dist_code, $subdiv_code));

        if($sqlDistHeadQtr->num_rows() > 0){
            return $sqlDistHeadQtr->row()->district_headquater;
        }
        else
        {
            return false;
        }

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


    // put under consideration
    // count application id by case no for ADC/SDO
    public function countNcApplicationDetailsByCaseNoCommon($caseNo,$dist_code)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('dist_code', $dist_code)
            ->where_in('pending_officer', [MB_ADD_DEPUTY_COMM,MB_SUB_DIV_COMM])
            ->where_in('status', [MB_MARK_AS_SDLAC,MB_PENDING])
            ->get('settlement_basic')
            ->num_rows();
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


    // get sdlac committee member type
    public function getMembersFromUsersWithUserType($dist_code)
    {

        $sql = $this->db->query("SELECT u.username AS name, u.user_code, u.user_type,
                                    (SELECT user_desig FROM master_user_designation 
                                      WHERE user_desig_code=u.user_desig_code) AS designation
                                        FROM loginuser_table lg JOIN users u ON u.user_code=lg.user_code 
                                          WHERE lg.user_code LIKE 'SDLC%'
                                            AND (lg.dis_enb_option=? OR lg.special_status=?)  AND lg.dist_code=? order by priority asc",
            array('E',1, $dist_code));

        if($sql->num_rows() > 0){
            return $sql->result();
        }
        else{
            return false;
        }
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

        if($sql->num_rows() > 0)
        {
            return $sql->result();
        }
        else
        {
            return false;
        }
    }



    //get SDLAC User details for generating priority in ADC/SDO
    public function fetchSdlacMemberList($dist_code){

        $sql = $this->db->query("SELECT u.priority,u.user_code,u.username AS name,u.emailid as email,phone_no as phone,
                                    (SELECT user_desig FROM master_user_designation 
                                      WHERE user_desig_code=u.user_desig_code) AS designation
                                        FROM loginuser_table lg JOIN users u ON u.user_code=lg.user_code 
                                          WHERE lg.user_code LIKE 'SDLC%'
                                            AND lg.dis_enb_option=? AND lg.dist_code=? order by priority asc",
            array('E', $dist_code));

        return $sql;

    }


    // set priority of all SDLAC/CDLAC Member
    public function updateSdlacComFlag($dist_code,$memberId,$priority)
    {

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


    // get all settlement dag
    public function getSettlementDagCommon($case)
    {
        $dags = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_dag_details');

        return $dags->row();
    }


    // get urban by LM  (falls Under GMC)
    public function getLandFallsUnderUrban($case_no)
    {
        return $this->db->select('falls_und_gmc')
            ->where('case_no', $case_no)
            ->get('settlement_ap_lmnote')
            ->row();
    }


    public function checkAvailabilitySdlcMemberDistrictWise($dist_code)
    {
        return $this->db->query("SELECT A.* FROM users A JOIN loginuser_table B
                    ON A.dist_code = B.dist_code AND A.user_code=B.user_code
                    WHERE A.user_desig_code LIKE '%SDLC%' 
                    AND B.dis_enb_option = ? AND A.dist_code = ?", array('E', $dist_code));
    }


    // get selected members
    public function getSelectedMembersFromUsers($dist_code,$allSelectedMember)
    {
        $sql = $this->db->query("SELECT u.username AS name, u.user_code, u.display_name,
                                    (SELECT user_desig FROM master_user_designation 
                                      WHERE user_desig_code=u.user_desig_code) AS designation
                                        FROM loginuser_table lg JOIN users u ON u.user_code=lg.user_code 
                                          WHERE lg.user_code IN ($allSelectedMember)
                                            AND (lg.dis_enb_option=? OR lg.special_status=?) AND lg.dist_code=? order by priority asc",
            array('E',1, $dist_code));


        if($sql->num_rows() > 0)
        {
            return $sql->result();
        }
        else
        {
            return false;
        }
    }


    public function getAllProCaseForDownload($ProposalNo)
    {
        $data = $this->db->query("select
        (select locname_eng from location where dist_code=t1.dist_code and subdiv_code='00') district,
        (select locname_eng from location where dist_code=t1.dist_code and subdiv_code=t1.subdiv_code and cir_code=t1.cir_code and mouza_pargona_code='00') circle,
        (select locname_eng from location where dist_code=t1.dist_code and subdiv_code=t1.subdiv_code and cir_code=t1.cir_code and mouza_pargona_code=t1.mouza_pargona_code and lot_no='00') mouza,
        (select locname_eng from location where dist_code=t1.dist_code and subdiv_code=t1.subdiv_code and cir_code=t1.cir_code and mouza_pargona_code=t1.mouza_pargona_code and lot_no=t1.lot_no and vill_townprt_code='00000') lot,
        (select locname_eng from location where dist_code=t1.dist_code and subdiv_code=t1.subdiv_code and cir_code=t1.cir_code and mouza_pargona_code=t1.mouza_pargona_code and lot_no=t1.lot_no and vill_townprt_code=t1.vill_townprt_code) village,
        t1.uuid,t1.applid as application_no,t1.case_no, t2.applicant_name, t2.guardian_name, t2.Address, t3.dag_no, 
		t3.applied_area, t3.proposed_area, t5.encroacher_name, t6.joint_applicants,t1.occupation_applicant as Occupation,
        (select 'DagNo: '||string_agg(distinct(dag_no) || '- AreaType: '||
		CASE WHEN area_name=1 THEN 'Guwahati City'
		WHEN area_name=2 THEN 'Within GMDA area'
		WHEN area_name=3 THEN 'District Headquarter Towns, North Guwahati, Rangia and Palashbari town'
		WHEN area_name=4 THEN 'Within Restructured Development Authority Area of District Headquarter Towns.'
		WHEN area_name=5 THEN 'Within 5 Km radius from the periphery of North Guwahati, Rangia and Palashbari towns.'
		WHEN area_name=6 THEN 'Municipal Towns other than District Head Quarter Towns'
		WHEN area_name=7 THEN 'Within 5 km radius from the periphery of Municipal Towns other than District Head Quarter Towns'
		WHEN area_name=8 THEN 'Revenue Towns'
		WHEN area_name=9 THEN 'Within 3 km radius from the periphery of  Revenue Towns'
		WHEN area_name=10 THEN 'Rural Areas'
		WHEN area_name=11 THEN 'Municipal Corporation (Town Area)'
        WHEN area_name=12 THEN 'Municipal Corporation (Peripheral Area)'
        WHEN area_name=13 THEN 'District Headquarter Municipal Towns, Rangia and Palashbari Towns, having Master Plan area (Town Area)'
        WHEN area_name=14 THEN 'District Headquarter Municipal Towns, Rangia and Palashbari Towns, having Master Plan area (Peripheral Area)'
        WHEN area_name=15 THEN 'District Headquarter Municipal Towns for which Master Plan area is not notified (Town Area)'
        WHEN area_name=16 THEN 'District Headquarter Municipal Towns for which Master Plan area is not notified (Peripheral Area)'
        WHEN area_name=17 THEN 'Other Municipal Towns (Town Area)'
        WHEN area_name=18 THEN 'Other Municipal Towns (No Peripheral Area)'
        WHEN area_name=19 THEN 'Revenue Towns showing urbanization and industrial growth (Town Area)'
        WHEN area_name=20 THEN 'Revenue Towns showing urbanization and industrial growth (No Peripheral Area)'
        WHEN area_name=21 THEN 'Other Revenue Towns (Town Area)'
        WHEN area_name=22 THEN 'Other Revenue Towns (No Peripheral Area)'
		END, ',' )  from settlement_premium where case_no=t11.case_no and is_final=1 and  area_name is not null and t11.case_no is not null) as area_type
		
        from (select case_no,proposal_id from settlement_proposal_cases spc where proposal_id=$ProposalNo) t11
        left join (select applid,case_no,dist_code,subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code,uuid,occupation_applicant from settlement_basic a) t1 on t11.case_no=t1.case_no
        left join ( select case_no,sa.pdar_name as applicant_name,sa.pdar_guardian as guardian_name,sa.pdar_add1 as Address from settlement_applicant sa where is_applicant='1') t2 on t11.case_no=t2.case_no
        left join ( select case_no,string_agg(distinct(dag_no),'-') as dag_no,string_agg(distinct(dag_no || '-area( home: ' || home_b || ' B-'||home_k||' K-'||home_lc ||'L, agri: '||agri_b||'B-'||agri_k||'K-'||agri_lc||'L)'),',') as applied_area, string_agg(distinct(dag_no || '-area( Total_Proposed_area: ' || s_dag_area_b || ' B-'||s_dag_area_k||' K-'||s_dag_area_lc ||'L)'),',') as proposed_area from settlement_dag_details sdd group by case_no) t3 on t11.case_no=t3.case_no
        left join ( select case_no,array_agg(distinct(pdar_name)) as encroacher_name from settlement_applicant sap where pdar_type='EN' group by case_no) t5 on t11.case_no=t5.case_no
        left join ( select case_no,string_agg(distinct(pdar_name),'-') as joint_applicants from settlement_applicant sa where is_applicant!='1' and pdar_type='B' group by case_no) t6 on t11.case_no=t6.case_no")->result_array();


        return $data;
    }



    // count application by case no for DC in sdlac proposal list
    public function countNcApplicationByCaseNoInSdlacProList($caseNo)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where_in('status', [PRO_CASE_STATUS_PENDING,PRO_CASE_STATUS_APPROVE,PRO_CASE_STATUS_REJECT,PRO_CASE_STATUS_REVERTED])
            ->get('settlement_proposal_cases')
            ->num_rows();
    }


    // get all pending proposal list at SDO/ADO end
    public function getPendingProposalsOfCommon($dist_code,$subdiv_code,$createdBy)
    {
        $this->db->select('*');
        $this->db->from('proposal_meeting_list');
        $this->db->where_in('adc_forward_to_dc_status', 0);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('created_by', $createdBy);
        $this->db->where('nc', 1);
        $this->db->order_by('id', 'asc');
        $data = $this->db->get();
        return $data;
    }



    // check data exist or not under proposal list by case no
    public function countSettlementProposalList($proposal_no)
    {
        return $this->db->select()
            ->where('id', $proposal_no)
            ->where('status', 1)
            ->where('nc', 1)
            ->get('settlement_proposal_list')
            ->num_rows();
    }


    // count pending case in SDLAC proposal
    public function countSettlementProposalPendingCaseByCaseNo($caseNo)
    {
        return $this->db->select('proposal_id')
            ->where('case_no', $caseNo)
            ->where('nc', 1)
            ->where_in('status', [PRO_CASE_STATUS_PENDING,PRO_CASE_STATUS_REVERTED])
            ->get('settlement_proposal_cases')
            ->num_rows();
    }


    // count  application id by case no
    public function countSettlementAppDetailsByCaseNo($caseNo)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->get('settlement_basic')
            ->num_rows();
    }


    // get proposal details  by proposal Id
    public function getProposalDetailsByProId($proposal_no)
    {
        return $this->db->select()
            ->where('id', $proposal_no)
            ->where('status', 1)
            ->where('nc', 1)
            ->get('settlement_proposal_list')
            ->row();
    }


    // get proposal case details by case no
    public function getSettlementProposalCaseDetailsByCaseNo($caseNo)
    {
        return $this->db->select()
            ->where('case_no', $caseNo)
            ->where('nc', 1)
            ->where_in('status', [PRO_CASE_STATUS_PENDING,PRO_CASE_STATUS_REVERTED])
            ->get('settlement_proposal_cases')
            ->row();
    }


    // delete proposal case details
    public function deleteSettlementProposalCaseDetailsById($id)
    {
        $this->db->where('id', $id);
        $this->db->where('nc', 1);
        $this->db->delete('settlement_proposal_cases');
        return $this->db->trans_status();
    }


    // count proposal list ready for create meeting
    public function getPendingProposalsReadyForMeeting($dist_code,$userDegCode)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('created_by', $userDegCode)
            ->where('sdlac_prceed_status', 2)
            ->where('nc', 1)
            ->where('meeting_create_status', 1)
            ->where('user_code', $this->session->userdata('user_code'))
            ->get('settlement_proposal_list')
            ->num_rows();

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


    public function getCasesAgainstProposalIdSDLAC($proposal_id,$dist_code)
    {
        $result = $this->db->query("SELECT A.*, B.service_code, B.dist_code FROM 
        settlement_proposal_cases A JOIN settlement_proposal_list B ON
        B.id=A.proposal_id WHERE A.proposal_id=? AND B.dist_code=?", array($proposal_id, $dist_code));

        return $result;
    }


    // get all case under reverted proposal
    public function getAllCaseInProposalUnderRevertedMeeting($proposal_no)
    {
        $this->db->select('settlement_proposal_cases.*,
        settlement_basic.dist_code,settlement_basic.subdiv_code,settlement_basic.cir_code,settlement_basic.service_code');
        $this->db->from('settlement_proposal_cases');
        $this->db->join('settlement_basic','settlement_basic.case_no = settlement_proposal_cases.case_no');
        $this->db->where('settlement_proposal_cases.proposal_id', $proposal_no);
        $this->db->where('settlement_proposal_cases.nc', 1);
        $data = $this->db->get();
        return $data;

    }


    // get proposal details by id for SDO
    public function getRevertedProposalDetailsById($proId,$dist_code,$suv_div)
    {
        $this->db->select('*');
        $this->db->from('settlement_proposal_list');
        $this->db->where('id', $proId);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $suv_div);
        $this->db->where('created_by', MB_SUB_DIV_COMM);
        $this->db->where('status', 1);
        $this->db->where('nc', 1);
        $data = $this->db->get()->row();

        return $data;
    }


    // get proposal details by id for Adc
    public function getRevertedProposalDetailsByIdAdc($proId,$dist_code)
    {
        $this->db->select('*');
        $this->db->from('settlement_proposal_list');
        $this->db->where('id', $proId);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('created_by', MB_ADD_DEPUTY_COMM);
        $this->db->where('status', 1);
        $this->db->where('nc', 1);
        $data = $this->db->get()->row();

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
        // $this->db->where('user_type', 'NC_SDLC');
        $this->db->where('user_type', 'SDLC');
        $this->db->where('dist_code', $dist_code);
        $data = $this->db->get('users');
        return $data;
    }

    // get all SDLAC Copy To data
    public function getCopyToData($dist_code, $subdiv_code,$user_desig_code)
    {
        $this->db->select();
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('created_by', $user_desig_code);
//        $this->db->where('nc', 1);
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



    // get all SDLAC/CDLAC Member
    public function checkProposalAlreadyExistInMeeting($proposals)
    {
        return $this->db->select()
            ->where_in('id', $proposals)
            ->where_in('nc', 1)
            ->where('proposal_meeting_id IS NOT NULL')
            ->get('settlement_proposal_list')
            ->num_rows();
    }


    // get nominee name
    public function getNomineeName($id)
    {
        $nomId = intval($id);
        return $this->db->select()
            ->where('id', $nomId)
            ->where('nc', 1)
            ->where('nominee_status', 1)
            ->get('sdlac_nominee_list')
            ->row();
    }


    // get all proposal details  by proposal Ids
    public function getAllProposalDetailsByProId($proposalIds)
    {
        return $this->db->select()
            ->where_in('id', $proposalIds)
            ->where('status', 1)
            ->where('nc', 1)
            ->get('settlement_proposal_list')
            ->result();
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


    public function checkSdlacMember($p_no)
    {
        return $this->db->query("SELECT * FROM settlement_sdlac_member_report WHERE 
                        proposal_no=?", array($p_no));
    }

    function convertLiteral($array) {
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


    // get all reverted meeting list at SDO end
    public function getRevertedMeetingListSDO($dist_code,$subdiv_code,$createdBy)
    {
        $this->db->select('*');
        $this->db->from('proposal_meeting_list');
        $this->db->where_in('adc_forward_to_dc_status', 2);
        $this->db->where('nc', 1);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('created_by', $createdBy);
        $this->db->order_by('id', 'asc');
        $data = $this->db->get();
        return $data;
    }

    // get all reverted meeting list at SDO end
    public function getRevertedMeetingListAdc($dist_code,$createdBy)
    {
        $this->db->select('*');
        $this->db->from('proposal_meeting_list');
        $this->db->where_in('adc_forward_to_dc_status', 2);
        $this->db->where('nc', 1);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('created_by', $createdBy);
        $this->db->order_by('id', 'asc');
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
        $this->db->where('nc', 1);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $data = $this->db->get();
        return $data;
    }


    // check reverted meeting exits or not for SDO
    public function checkRevertedMeetingExistOrNotWithMeetingIdAdc($mId,$dist_code)
    {
        $this->db->select('*');
        $this->db->from('proposal_meeting_list');
        $this->db->where('adc_forward_to_dc_status', 2);
        $this->db->where('id', $mId);
        $this->db->where('nc', 1);
        $this->db->where('dist_code', $dist_code);
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
        $this->db->where('nc', 1);
        $this->db->where('status', 1);
        $data = $this->db->get();
        return $data;
    }



}