<?php
class RelinquishmentCommonModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

    }


    // show reject modal
    public function getRejectModal($service_code)
    {
        $sql = $this->db->query("SELECT chitha_flag, sub_input_type, remark_head, service_code, reject_code, remark FROM reject_master WHERE flag=? and service_code=?", array('1', (string) $service_code));
        if ($sql->num_rows() > 0) {
            return $sql->result();
        } else {
            return 'n';
        }
    }


    // get all settlement dag
    public function getSettlementDag($case)
    {
        $dags = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_dag_details');

        return $dags->result();
    }




    public function getChithaFlaggedRemarks($dags, $rejected_list)
    {
        $dagFlagCheckChitha = '';
        foreach ($dags as $cd) {
            foreach ($rejected_list as $rej_list_key => $rej_list_chitha) {
                if ($rej_list_chitha->chitha_flag != 0) {

                    $chithaUuid = $this->utilityclass->getVillageUUID($cd->dist_code, $cd->subdiv_code, $cd->cir_code, $cd->mouza_pargona_code, $cd->lot_no, $cd->vill_townprt_code);

                    $resp = $this->utilityclass->getChithaFlagRemarks((string) $chithaUuid, (string) $cd->dag_no, $rej_list_chitha->chitha_flag);
                    if ($resp == true) {
                        $frech = '';
                        foreach ($resp as $pp) {
                            $frech .= $pp->remark . ", ";
                        }
                        $dagFlagCheckChitha .= "<div class='text-danger alert-warning pl-2 pr-2 pb-1'><b style='border-radius:2px; background:red; color:white; padding:3px;'>Dag No " . $cd->dag_no . " </b> &nbsp; <i class='fa fa-arrow-right' aria-hidden='true'></i> <span style='background:yellow; color:black; font-weight:500;'>This dag is flagged in Chitha with the followings - " . $frech . "</span></div>";
                        break;
                    }
                }
            }
        }
        return $dagFlagCheckChitha;
    }


    function checkExistDharitree($case_basu)
    {
        $sql="Select count(*) as c from  basundhar_application where basundhara='$case_basu' and (dharitree!=null or dharitree is not null )";
        $dataFound=$this->db->query($sql)->row();
        if($dataFound->c >0)
        {
            $dataFound = $dataFound->c;
        }
        else
        {
            $dataFound = NULL;
        }
        return $dataFound;
    }


    ///////////Case no using sequence//////////////
    function genearteCaseName($dist_code,$subdiv_code,$cir_code)
    {
        $financialyeardate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('y') : date('Y') . "-" . date('y', strtotime('+1 year'));
        $q = "Select dist_abbr,cir_abbr from location where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code!='00' ";
        $abbrname = $this->db->query($q)->row();
        if($abbrname)
        {
            $cir_dist_name = $abbrname->dist_abbr . "/" . $abbrname->cir_abbr;
            $case_no = $cir_dist_name . "/" . $financialyeardate . "/" ;
            return $case_no;
        }
        return false;
    }

    function genearteSettlementPetitionNo(){
        $petition_no = $this->db->query("select nextval('seq_max_settlement') as count ")->row()->count;
        return $petition_no;
    }

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




    public function getPremiumArea()
    {
        // $sql = "Select * from settlement_premium_area where not paid in(1,2,3,4,5,6,7,8,9) order by paid asc";
        $sql = "Select * from settlement_premium_area where paid in(1,3,4,5,7,9,10) order by paid asc";
        $data = $this->db->query($sql);
        return $data->result();
    }


    // getting the VLB encroacher details -js- 29-aug-22
    public function getEncroacherDetails($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_townprt_code, $dag_no){
        $vlb = $this->db->select()
            ->WHERE('dist_code', $dist_code)
            ->WHERE('subdiv_code', $subdiv_code)
            ->WHERE('cir_code', $circle_code)
            ->WHERE('mouza_pargona_code', $mouza_code)
            ->WHERE('lot_no', $lot_no)
            ->WHERE('vill_townprt_code', $vill_townprt_code)
            ->WHERE('dag_no', $dag_no)
            ->GET('c_land_bank_details');
        if ($vlb->num_rows() > 0) {
            return $vlb->row();
        } else {
            return FALSE;
        }
    }


    public function getEncroacherInDag($end_id){
        $enc_details = $this->db->select()
            ->WHERE('c_land_bank_details_id', $end_id)
            ->GET('c_land_bank_encroacher_details');
        if ($enc_details->num_rows() > 0) {
            return $enc_details->result();
        } else {
            return FALSE;
        }
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


    // count all pending cases DC
    public function countPendingRelinquishmentCasesDc($dist_code,$serviceCode)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('service_code', $serviceCode)
            ->where('pending_officer', MB_DEPUTY_COMM)
            ->where('status','W')
            ->get('settlement_basic')
            ->num_rows();
    }



    // count all Notice Served cases DC
    public function countNoticeServedRelinquishmentCasesDc($dist_code,$serviceCode)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('service_code', $serviceCode)
            ->where('pending_officer', MB_DEPUTY_COMM)
            ->where('status','S')
            ->where('notice_generated_yn','Y')
            ->get('settlement_basic')
            ->num_rows();
    }

    // count all Final Served cases DC
    public function countFinalOrderRelinquishmentCasesDc($dist_code,$serviceCode)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('service_code', $serviceCode)
            ->where('pending_officer', MB_DEPUTY_COMM)
            ->where('status','G')
            ->where('notice_generated_yn','Y')
            ->get('settlement_basic')
            ->num_rows();
    }



    // count all pending cases CO
    public function countPendingRelinquishmentCasesCo($dist_code,$subdiv_code,$cir_code,$serviceCode)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subdiv_code)
            ->where('cir_code', $cir_code)
            ->where('service_code', $serviceCode)
            ->where('pending_officer', MB_CIRCLE_OFFICER)
            ->where('status','Z')
            ->get('settlement_basic')
            ->num_rows();
    }


    // count all Forwarded cases by LM to CO
    public function countPendingCasesForwardedByLmToCo($dist_code,$subdiv_code,$cir_code,$serviceCode)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subdiv_code)
            ->where('cir_code', $cir_code)
            ->where('service_code', $serviceCode)
            ->where('from_office', MB_LOT_MONDOL)
            ->where('pending_officer', MB_CIRCLE_OFFICER)
            ->where('status','W')
            ->get('settlement_basic')
            ->num_rows();
    }


    // count all pending for Chitha update
    public function countPendingCasesForChithaUpdate($dist_code,$subdiv_code,$cir_code,$serviceCode)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subdiv_code)
            ->where('cir_code', $cir_code)
            ->where('service_code', $serviceCode)
            ->where('from_office', MB_DEPUTY_COMM)
            ->where('pending_officer', MB_CIRCLE_OFFICER)
            ->where('status','C')
            ->get('settlement_basic')
            ->num_rows();
    }


    // count all pending cases LM
    public function countPendingRelinquishmentCasesLm($dist_code,$subdiv_code,$cir_code,$mouza,$lot_no,$serviceCode)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subdiv_code)
            ->where('cir_code', $cir_code)
            ->where('mouza_pargona_code', $mouza)
            ->where('lot_no', $lot_no)
            ->where('service_code', $serviceCode)
            ->where('from_office', MB_CIRCLE_OFFICER)
            ->where('pending_officer', MB_LOT_MONDOL)
            ->where('status','W')
            ->get('settlement_basic')
            ->num_rows();
    }


    // get cases by case no
    public function getRelinquishmentCasesByCaseNo($dist_code,$serviceCode,$caseNo)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('service_code', $serviceCode)
            ->where('case_no', $caseNo)
            ->get('settlement_basic')
            ->row();
    }



    // get cases by case no Dc
    public function getRelinquishmentCasesDetails($dist_code,$serviceCode,$caseNo)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('service_code', $serviceCode)
            ->where('case_no', $caseNo)
            ->get('settlement_basic')
            ->row();
    }

    // get cases by case no Dc
    public function getRelinquishmentCasesByCaseNoForDc($dist_code,$serviceCode,$caseNo)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('service_code', $serviceCode)
            ->where('case_no', $caseNo)
            ->get('settlement_basic');
    }


    // get cases by case no CO
    public function getRelinquishmentCasesByCaseNoForCo($dist_code,$subdiv_code,$cir_code,$serviceCode,$caseNo)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subdiv_code)
            ->where('cir_code', $cir_code)
            ->where('service_code', $serviceCode)
            ->where('case_no', $caseNo)
            ->get('settlement_basic');
    }



    // get cases by case no LM
    public function getRelinquishmentCasesByCaseNoForLm($dist_code,$subdiv_code,$cir_code,$mouza,$lot_no,$serviceCode,$caseNo)
    {
        return $this->db->select()
            ->where('dist_code', $dist_code)
            ->where('subdiv_code', $subdiv_code)
            ->where('cir_code', $cir_code)
            ->where('mouza_pargona_code', $mouza)
            ->where('lot_no', $lot_no)
            ->where('service_code', $serviceCode)
            ->where('case_no', $caseNo)
            ->get('settlement_basic');
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


    // get all applicant buyers
    public function getAllApplicantBuyers($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->order_by('is_applicant', 1)
            ->get('settlement_applicant');
        return $applicants->result();
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


    // get LRA Report
    public function getSettlementLraReport($case)
    {
        return $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_ap_lmnote')
            ->result();
    }





    // get all settlement proceeding
    public function getDocuments($case)
    {
        $applicaiton_no = $this->utilityclass->getApplidFromCaseNo($case);
        $proceedings = $this->db->select()
            ->where('case_no in (\''.$applicaiton_no.'\', \''.$case.'\')')
            ->get('supportive_document');

        return $proceedings->result();
    }


    // get all (B,O,EN,P,GP,GGP) applicant
    public function getAllNomineeDetail($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_nominee');
        return $applicants->result();
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


    //  get all application though location details (Not Rejected on)
    public function getAllDagAreaDetailsByLocation($appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta)
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
    public function getAllDagAreaDetailsByLocationNotSubmit($appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta,$application_no)
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




    public function getAllOwnersChitha($case)
    {
        $location = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_dag_details')
            ->row();

        $condition = "subdiv_code ='$location->subdiv_code' and cir_code ='$location->cir_code' and mouza_pargona_code='$location->mouza_pargona_code' and lot_no='$location->lot_no' and vill_townprt_code ='$location->vill_townprt_code' 
        and trim(patta_no) ='$location->patta_no' and patta_type_code='$location->patta_type_code'";

        $st=microtime(true);

        $sqlcheck= "select * from chitha_dag_pattadar where $condition and trim(dag_no)=trim('$location->dag_no') and (p_flag is null or p_flag='0')" ;
        $result_check = $this->db->query($sqlcheck);
        if ($result_check->num_rows() > 0)
        {

            $sql= "select ''''||string_agg(pdar_id::varchar,''', ''')||'''' as pdar_ids from chitha_dag_pattadar where $condition and trim(dag_no)=trim('$location->dag_no') and (p_flag is null or p_flag='0')" ;
            $result_data = $this->db->query($sql)->row();

            $sql= "select string_agg(pdar_name || ' (' || pdar_father || ')', ', ') as owners from chitha_pattadar where $condition and  pdar_id in ($result_data->pdar_ids)";

            $ownersName = $this->db->query($sql);
            log_message('error', 'getAllOwnersChitha: time taken='.(microtime(true) - $st));
            if ($ownersName->num_rows() > 0)
            {
                return $ownersName->row();
            }
            else
            {
                // return null;
                $this->session->set_flashdata('message', "#ERRP00256: Pattadar's not found for case no : ".$case);
                redirect(base_url() . "index.php/home");
                return false;
            }
        }
        else
        {

            //check chitha and update dag_details
            //get patta_no from chitha_basic
            $sql = "select patta_type_code, trim(patta_no) as patta_no from chitha_basic where subdiv_code ='$location->subdiv_code' and cir_code ='$location->cir_code' and mouza_pargona_code='$location->mouza_pargona_code' and lot_no='$location->lot_no' and vill_townprt_code ='$location->vill_townprt_code' and trim(dag_no)=trim('$location->dag_no')";

            $data = $this->db->query($sql);
            if ($data->num_rows()<=0)
            {
                $this->session->set_flashdata('message', "#ERRP00256: Dag not found for case no : ".$case);
                redirect(base_url() . "index.php/home");
                return false;
            }
            $data = $data->row();

            //if applicant's patta_type and chitha_patta_type matching and patta_nos are not matching
            if ($data->patta_type_code == $location->patta_type_code && $data->patta_no!=$location->patta_no)
            {
                $sql = "select  pdar_id from settlement_applicant where case_no='$case' and pdar_type='O'";
                $pdars = $this->db->query($sql)->result();


                $sqlcheck= "select string_agg(pdar_id::text,',') as chitha_pdar_ids from chitha_dag_pattadar where subdiv_code ='$location->subdiv_code' and cir_code ='$location->cir_code' and mouza_pargona_code='$location->mouza_pargona_code' and lot_no='$location->lot_no' and vill_townprt_code ='$location->vill_townprt_code' and trim(dag_no)=trim('$location->dag_no') and (p_flag is null or p_flag='0')" ;
                $chitha_pdars = $this->db->query($sqlcheck)->row()->chitha_pdar_ids;
                $chitha_pdar_arr = explode(',', $chitha_pdars);
                // var_dump($chitha_pdars); die;

                foreach($pdars as $p)
                {
                    //if applicant's pdar_id and chitha_pdar_id matching
                    if (!in_array($p->pdar_id, $chitha_pdar_arr))
                    {
                        $this->session->set_flashdata('message', "#ERRP00256: Pattadars not found for case no : ".$case);
                        redirect(base_url() . "index.php/home");
                        return false;
                    }
                }

                //coming here means applicant's pdar_id and chitha pdar_id are matching so we can update patta_no
                $update_arrya=[
                    'patta_no' => $data->patta_no
                ];
                $this->db->where('case_no',$case);
                $this->db->update('settlement_applicant',$update_arrya);
                if ($this->db->affected_rows()<=0)
                {
                    $this->session->set_flashdata('message', "#ERRP00256: Pattadars not found for case no : ".$case);
                    redirect(base_url() . "index.php/home");
                    return false;
                }
                $this->db->where('case_no',$case);
                $this->db->update('settlement_dag_details',$update_arrya);
                if ($this->db->affected_rows()<=0)
                {
                    $this->session->set_flashdata('message', "#ERRP00256: Pattadars not found for case no : ".$case);
                    redirect(base_url() . "index.php/home");
                    return false;
                }

                $condition = "subdiv_code ='$location->subdiv_code' and cir_code ='$location->cir_code' and mouza_pargona_code='$location->mouza_pargona_code' and lot_no='$location->lot_no' and vill_townprt_code ='$location->vill_townprt_code' 
                    and trim(patta_no) ='$data->patta_no' and patta_type_code='$location->patta_type_code'";
                $sqlcheck= "select * from chitha_dag_pattadar where $condition and trim(dag_no)=trim('$location->dag_no') and (p_flag is null or p_flag='0')" ;
                $result_check = $this->db->query($sqlcheck);
                if ($result_check->num_rows() > 0) {

                    $sql= "select ''''||string_agg(pdar_id::varchar,''',''')||'''' as pdar_ids from chitha_dag_pattadar where $condition and trim(dag_no)=trim('$location->dag_no') and (p_flag is null or p_flag='0')" ;
                    $result_data = $this->db->query($sql)->row();

                    $sql= "select string_agg(pdar_name || ' (' || pdar_father || ')',',') as owners from chitha_pattadar where $condition and  pdar_id in ($result_data->pdar_ids)";

                    $ownersName = $this->db->query($sql);
                    log_message('error', 'getAllOwnersChitha: time taken='.(microtime(true) - $st));
                    if ($ownersName->num_rows() > 0) {
                        return $ownersName->row();
                    }else{
                        // return null;
                        $this->session->set_flashdata('message', "#ERRP00256: Pattadar's not found for case no : ".$case);
                        redirect(base_url() . "index.php/home");
                        return false;
                    }
                }
            }

            // return null;
            $this->session->set_flashdata('message', "#ERRP00275500: Pattadar's not found for case no : ".$case);
            redirect(base_url() . "index.php/home");
            return false;
        }
    }



    public function downloadNotice($notice_link)
    {
        if (!file_exists($notice_link)) {
            $parts = explode("uploads" . UPLOAD_SEPARATOR, $notice_link, 2);
            if (count($parts) > 1) {
                $path = BACKUP_DIR_34 . "uploads" . UPLOAD_SEPARATOR . $parts[1];
            } else {
                $path = $notice_link;
            }

            if (!file_exists($path)) {
                $path = BACKUP_DIR_35 . "uploads" . UPLOAD_SEPARATOR . $parts[1];
            }

            if (!file_exists($path)) {
                return false;
            }

        } else {
            $path = $notice_link;
        }
        return $path;
    }



}