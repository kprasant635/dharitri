<?php
class Escalationmodel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('TransactionModel');
    }

    public function getTimeLine($service_code, $service_name, $escalation_type = 'normal')
    {
        $sql = "Select * from escalation_matrix where service_code=? and category = ? and escalation_type = ?";
        $matrix = $this->db->query($sql, array($service_code, $service_name, $escalation_type))->row();
        if (isset($matrix) && !empty($matrix) && $matrix != null) {
            return $matrix;
        } else {
            return null;
        }

    }

    public function generateDateCode()
    {
        $code = $this->db->query("select nextval('escalation_dates_details_sr_no_seq') as count ")->row()->count;
        return $code;

    }

    public function address($full_address)
    {
        //if less then 100
        if (strlen($full_address) < 100) {
            $address[0] = $full_address;
            $address[1] = null;
            return $address;
        }
        //if more then 100 containing ',' or space separator
        $sub_address = substr($full_address, 0, 100);
        $pos = strrpos($sub_address, ",");
        if (!$pos) {
            $pos = strrpos($sub_address, " ");
        }

        $address[1] = substr($full_address, $pos + 1, strlen($full_address));
        $address[0] = substr($full_address, 0, $pos);
        return $address;
    }

    public function getPendingOfficer($d, $s, $c, $desig_code)
    {
        $sql = "select u.username, lt.user_code, u.user_desig_code from loginuser_table lt join users u on lt.dist_code=u.dist_code
            and lt.subdiv_code=u.subdiv_code and lt.cir_code=u.cir_code
            and u.user_code=lt.user_code where lt.dis_enb_option='E'
            and u.user_desig_code = '$desig_code' and lt.dist_code='$d'
            and lt.subdiv_code='$s' and lt.cir_code='$c'";
        $data = $this->db->query($sql);
        // log_message('error', '52======************========pendingOfficer==' . json_encode($this->db->last_query()) . json_encode($data->row()));
        return $data->row();
    }

    public function getPendingOfficerADC($d, $desig_code)
    {
        $sql = "select u.username, lt.user_code, u.user_desig_code from loginuser_table lt join users u on
                  lt.dist_code=u.dist_code
                    and lt.subdiv_code=u.subdiv_code
                      and u.user_code=lt.user_code where lt.dis_enb_option='E'
                        and u.user_desig_code like 'ADC%'";
        $data = $this->db->query($sql);
        return $data->row();
    }
    public function getPendingOfficerDC($d, $desig_code)
    {
        $sql = "select u.username, lt.user_code, u.user_desig_code from loginuser_table 
                  lt join users u on
                    lt.dist_code=u.dist_code
                      and lt.subdiv_code=u.subdiv_code
                        and u.user_code=lt.user_code where lt.dis_enb_option='E'
                          and u.user_desig_code not like 'DCN%'
                            and u.user_desig_code like 'DC%'";
        $data = $this->db->query($sql);
        return $data->row();
    }

    public function getPendingOfficerLM($d, $s, $c, $mouza_pargona_code, $lot_no)
    {
        $sql = "select lt.user_code from loginuser_table lt join lm_code u on lt.dist_code=u.dist_code
            and lt.subdiv_code=u.subdiv_code
            and lt.cir_code=u.cir_code
            and lt.mouza_pargona_code=u.mouza_pargona_code
            and lt.lot_no=u.lot_no
            and u.lm_code=lt.user_code
            where lt.dis_enb_option='E'
            and lt.dist_code='$d'
            and lt.subdiv_code='$s' and lt.cir_code='$c' and lt.mouza_pargona_code='$mouza_pargona_code' and lt.lot_no='$lot_no'";
        $data = $this->db->query($sql);

        return $data->row();
    }

    public function genearteCaseNameEs($dist_code, $subdiv_code, $cir_code)
    {

        $financialyeardate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('y') : date('Y') . "-" . date('y', strtotime('+1 year'));
        $q = "Select dist_abbr,cir_abbr from location where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code!='00' ";
        $abbrname = $this->db->query($q)->row();
        if ($abbrname) {
            $cir_dist_name = $abbrname->dist_abbr . "/" . $abbrname->cir_abbr;
            $case_no = $cir_dist_name . "/" . $financialyeardate . "/";
            return $case_no;
        }
        return false;
    }

    public function getEscalatedRowDetails($petition_no, $service_code)
    {
        $sql = $this->db->query("select * from escalation_details where petition_no = ? AND service_code=?", 
                    array($petition_no, $service_code));
        return $sql->row();
    }

    public function getEscalatedRowDetailsBasic($case_no)
    {
        $sql = $this->db->query("select * from escalation_details where case_no = ?", 
                    array($case_no));
        return $sql->row();
    }

    public function getEscalatedRowDetailsCaseNo($case_no)
    {
        $sql = $this->db->query("select * from escalation_details where case_no = ? ", array($case_no));
        $esc_data = $sql->row();
        if($this->session->userdata('user_desig_code') == 'LM')
        {
            if($esc_data->lm_escalate_status == 'N' || $esc_data->lm_escalate_status == null)
            {
                return $esc_data;
            }
            else
            {
                $esc_data->escalated_date = 'ESCALATED';
                $esc_data->assigned_date = 'ESCALATED';
                return $esc_data;
            }
        }
        else if($this->session->userdata('user_desig_code') == 'CO')
        {
            if($esc_data->co_escalate_status == 'N' || $esc_data->co_escalate_status == null)
            {
                return $esc_data;
            }
            else
            {
                $esc_data->escalated_date = 'ESCALATED';
                $esc_data->assigned_date  = 'ESCALATED';
                return $esc_data;
            }
        }
        else if($this->session->userdata('user_desig_code') == 'SK')
        {
            if($esc_data->sk_escalate_status == 'N' || $esc_data->sk_escalate_status == null)
            {
                return $esc_data;
            }
            else
            {
                $esc_data->escalated_date = 'ESCALATED';
                $esc_data->assigned_date  = 'ESCALATED';
                return $esc_data;
            }
        }
        else if($this->session->userdata('user_desig_code') == 'ADC')
        {
            if($esc_data->adc_escalate_status == 'N' || $esc_data->adc_escalate_status == null)
            {
                return $esc_data;
            }
            else
            {
                $esc_data->escalated_date = 'ESCALATED';
                $esc_data->assigned_date = 'ESCALATED';
                return $esc_data;
            }
        }
        else
        {

            return $esc_data;
        }
    }

    public function updateExtraDays($case_no, $allocation_days)
    {
        $sql = $this->db->query("update escalation_details set lm_target_days = lm_target_days + '$allocation_days',lm_allocate_days = '$allocation_days',co_completed_days = co_completed_days + '$allocation_days' where case_no = ? ", array($case_no));
        return $this->db->affected_rows();
    }

    public function updateExtraDaysADCCO($case_no, $allocation_days)
    {
        $sql = $this->db->query("update escalation_details set co_target_days = co_target_days + '$allocation_days',co_allocate_days = '$allocation_days',adc_completed_days = adc_completed_days + '$allocation_days' where case_no = ? ", array($case_no));
        return $this->db->affected_rows();
    }

    public function updateExtraDaysDCCO($case_no, $allocation_days)
    {
        $sql = $this->db->query("update escalation_details set co_target_days = co_target_days + '$allocation_days',co_allocate_days = '$allocation_days',dc_completed_days = dc_completed_days + '$allocation_days' where case_no = ? ", array($case_no));
        return $this->db->affected_rows();
    }

    public function updateExtraDaysDCADC($case_no, $allocation_days)
    {
        $sql = $this->db->query("update escalation_details set adc_target_days = adc_target_days + '$allocation_days',adc_allocate_days = '$allocation_days',dc_completed_days = dc_completed_days + '$allocation_days' where case_no = ? ", array($case_no));
        return $this->db->affected_rows();
    }

    public function getRemainingDays($previousCompletedDays, $orginalTargetDays)
    {
        // log_message("error", "ddd==" . $previousCompletedDays . " ==========" . $orginalTargetDays);
        return $orginalTargetDays - $previousCompletedDays;
    }

    public function escalationMatrixUpdateOMUT($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days)
    {
        if($user_type == 'LM')
        {
            $executionDate = $executionDate;
        }
        else
        {
            $executionDate = date('Y-m-d H:i:s');
        }
        $current_date = date('Y-m-d H:i:s');
        $response = array('responseType' => 1, 'msg' => null);
        $petition_no = $this->getPetitionNoOMUT($case_no);
        if ($petition_no == null || $petition_no == '') {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION150 : Petition no not found';
            return $response;
        }
        // WARNING BEFORE CODE=========================
        // $assigned_to_other_type may be notice or role name
        ///////////////////////////////////
        // log_message('error','TTTTTTTTTTTTTTTTTTT'.$petition_no."-----".$service_code);
        $escalatedRowDetailsAgainstPetitionno = $this->getEscalatedRowDetails($petition_no,$service_code);
        if ($escalatedRowDetailsAgainstPetitionno == null || empty($escalatedRowDetailsAgainstPetitionno)) {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION163 : Escalation row not found';
            return $response;
        }
        $assigned_other_code = $assigned_to_code = $assigned_from_code = null;
        $userCodeList = json_decode(USER_ALLOT_CODE);
        foreach ($userCodeList as $key => $value) {
            if ($value->USER == $user_type) {
                $assigned_from_code = $value->CODE;
            }
            if ($value->USER == $assigned_user_type) {
                $assigned_to_code = $value->CODE;
            }
            if ($value->USER == $assigned_to_other_type) {
                $assigned_other_code = $value->CODE;
            }
        }

        $lastAssignedDate = $escalatedRowDetailsAgainstPetitionno->assigned_date;
        // log_message("error","ASSIGNED_DATE=======".$lastAssignedDate);
        $lastEscalatedDate = $escalatedRowDetailsAgainstPetitionno->escalated_date;
        if ($user_type == 'AST') {
            $lastAssignedDate = $escalatedRowDetailsAgainstPetitionno->assigned_other_date;
            $lastEscalatedDate = $escalatedRowDetailsAgainstPetitionno->assigned_other_es_date;
        }

        if($assigned_to_other_type != "Action")
        {
            $validateExecutionDateTime = $this->checkCaseExecutionOnTimeOrNot($current_date, $lastAssignedDate, $lastEscalatedDate);
            log_message('error', 'validation:--' . json_encode($validateExecutionDateTime));
            if ($validateExecutionDateTime == 'n') {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRESCLATIONOMUT183 : Case Execution not on Time';
                return $response;
            }
        }

        
        $typeServices = 'OMUT';
        if($service_code == 2)
        {
            $typeServices = 'OMUTD';
        }

        $timeLineRow = $this->getTimeLine($escalatedRowDetailsAgainstPetitionno->service_code, $typeServices);
        if ($timeLineRow == null || empty($timeLineRow)) {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION163 : Escalation row not found';
            return $response;
        }

        if ($assigned_user_type == 'AST') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->da_target_days;
            $previousCompletedDaysDA = $escalatedRowDetailsAgainstPetitionno->da_completed_days;

            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysDA, $originalAllocation);
            if ($remaining_days_other < 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281OMUT1 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDateNew($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $hearing_date);

        } elseif ($assigned_user_type == 'LM') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
            $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
            // log_message("error","previousCompletedDaysLM--------------".$previousCompletedDaysLM);
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysLM, $originalAllocation);
            if ($remaining_days_other < 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281OMUT2 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);

        } elseif ($assigned_user_type == 'SK') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->sk_target_days;
            $previousCompletedDaysSK = $escalatedRowDetailsAgainstPetitionno->sk_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysSK, $originalAllocation);
            if ($remaining_days_other < 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281OMUT3 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);
            // $escalatedDate = $this->getOtherEscalatedDate($remaining_days_other,$hearing_date);

        } elseif ($assigned_user_type == 'CO') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO, $originalAllocation);
            if ($remaining_days_other < 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281OMUT4 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);

        }

        $dateCode = $this->generateDateCode();
        // log_message("error","TYPE ".$user_type." =====ESCALATED_DATE=======".$escalatedDate);
        if ($user_type == 'CO') {
            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);
            $dateCodes = $escalatedRowDetailsAgainstPetitionno->co_date_code_list;

            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->co_completed_days;

            $co_target_days = $escalatedRowDetailsAgainstPetitionno->co_target_days;

            // log_message("error","========CO-TARGET_DAYS =======".$co_target_days);

            $co_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);

            // log_message("error","========CO-COMPLETION_DAYS=======".$co_completed_days);
            // if ($co_target_days < $co_completed_days) {
            //     $escalate_status = 'Y';
            // } else {
                $escalate_status = 'N';
            // }
            // log_message("error","CO-ESCALATE_STATUS=======".$escalate_status);
            $latestHistoryCode = $dateCodes;
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }
            $entryTimes = 0;
            $doubleEntry = 0;
            $assigned_other_date = null;
            $to_be_other_completed_within_days = null;
            $assigned_other_es_date = null;
            if ($assigned_to_other != null) {
                //this is designed for CO first proceding as assigned to LM and DA==========
                $entryTimes = 1;
                //////////

                $assigned_other_date = $hearing_date;
                if ($assigned_to_other_type == 'LM') {
                    $originalAllocation = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
                    $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
                    $remaining_days_other = $this->getRemainingDays($previousCompletedDaysLM, $originalAllocation);
                    if ($remaining_days_other < 0) {
                        $response['responseType'] = 0;
                        $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                        return $response;
                    }
                    // $assigned_other_es_date = $this->getEscalatedDate($remaining_days_other);
                    $assigned_other_es_date = $this->getEscalatedDateNew($remaining_days_other, $executionDate);
                    $to_be_other_completed_within_days = $this->dateDiff($assigned_other_es_date, $executionDate);
                } elseif ($assigned_to_other_type == 'AST') {
                    $originalAllocation = $escalatedRowDetailsAgainstPetitionno->da_target_days;
                    $previousCompletedDaysDA = $escalatedRowDetailsAgainstPetitionno->da_completed_days;
                    $remaining_days_other = $this->getRemainingDays($previousCompletedDaysDA, $originalAllocation);
                    if ($remaining_days_other < 0) {
                        $response['responseType'] = 0;
                        $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                        return $response;
                    }
                    // $assigned_other_es_date = $this->getEscalatedDate($remaining_days_other);
                    // $assigned_other_es_date = $this->getEscalatedDateNew($remaining_days_other, $executionDate);
                    $assigned_other_es_date = $this->getEscalatedDateNew($remaining_days_other, $hearing_date);
                    $to_be_other_completed_within_days = $this->dateDiff($assigned_other_es_date, $hearing_date);
                    
                }

            }
            $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);

            $updateArray = array(
                'taskid' => $taskid,
                'co_completed_days' => (int) $co_completed_days + (int) $previousCompletedDays,
                'co_escalate_status' => $escalate_status,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_date' => $executionDate,
                'escalated_date' => $escalatedDate,
                'to_be_completed_within_days' => $to_be_completed_within_days,
                'co_date_code_list' => $dateCodes,
                'assignment_type_other' => $assignment_type_other,
                'assigned_from_other' => $user_code,
                'assigned_from_other_code' => $assigned_from_code,
                'assigned_other' => $assigned_to_other,
                'assigned_other_code' => $assigned_other_code,
                'assigned_other_date' => $assigned_other_date,
                'assigned_other_es_date' => $assigned_other_es_date,
                'to_be_other_completed_within_days' => $to_be_other_completed_within_days,
            );

        }
        if ($user_type == 'AST') {
            
            $completion_days_for_history = $this->dateDiff($current_date, $escalatedRowDetailsAgainstPetitionno->assigned_other_date);
            $dateCodes = $escalatedRowDetailsAgainstPetitionno->da_date_code_list;

            if ($assigned_to_other_type == 'Notice' || $assigned_to_other_type == 'Action') {
                $lastAssignedDate = $escalatedRowDetailsAgainstPetitionno->assigned_other_date;
            }
            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->da_completed_days;
            $da_target_days = $escalatedRowDetailsAgainstPetitionno->da_target_days;
            // log_message("error","DA-TARGET_DAYS=======".$da_target_days);
            $da_completed_days = $this->dateDiff($current_date, $lastAssignedDate);
            // log_message("error","DA-COMPLETION_DAYS=======".$da_completed_days);
            // if ($da_target_days < $da_completed_days) {
            //     $escalate_status = 'Y';
            // } else {
                $escalate_status = 'N';
            // }
            // log_message("error","DA-ESCALATE_STATUS=======".$escalate_status);

            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }

            $updateArray = array(
                'taskid' => $taskid,
                // 'da_target_days'     => $da_target_days,
                'da_completed_days' => (int) $da_completed_days + (int) $previousCompletedDays,
                'da_escalate_status' => $escalate_status,
                'assigned_from_other' => $user_code,
                'assigned_from_other_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_date' => $executionDate,
                'escalated_date' => $escalatedDate,
                'da_date_code_list' => $dateCodes,
            );

            //this code use only while Asistant generate notice==============
            if ($assigned_to_other_type == 'Notice') {

                //THIS CODE ONLY FOR NOTICE GENERATE AND NEXT ALLOCATION DATE WILL BE AFTER HEARING DATE==========
                $originalAllocation = $escalatedRowDetailsAgainstPetitionno->da_target_days;
                $previousCompletedDaysDA = $da_completed_days;
                $remaining_days_other = $this->getRemainingDays($previousCompletedDaysDA, $originalAllocation);
                if ($remaining_days_other == null || $remaining_days_other == 0) {
                    $response['responseType'] = 0;
                    $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                    return $response;
                }
                //end==============
                // log_message("error","remaining_days_other,hearing_date =======".$remaining_days_other."---".$hearing_date);

                $assigned_other_es_date = $this->getOtherEscalatedDate($remaining_days_other, $hearing_date);
                unset($updateArray['assigned_from']);
                unset($updateArray['assigned_from_code']);
                unset($updateArray['assigned_to_code']);
                unset($updateArray['assigned_to']);
                unset($updateArray['assigned_date']);
                unset($updateArray['escalated_date']);
                $updateArray['assigned_other_date'] = $hearing_date;
                $updateArray['to_be_other_completed_within_days'] = $this->dateDiff($assigned_other_es_date, $hearing_date);
                $updateArray['assigned_other_es_date'] = $assigned_other_es_date;

            }
            //// end====================
            //this code use only while Asistant generate Action Taken==============
            if ($assigned_to_other_type == 'Action') {

                unset($updateArray['assigned_from']);
                unset($updateArray['assigned_from_code']);
                unset($updateArray['assigned_to_code']);
                unset($updateArray['assigned_to']);

                $petitioBasicData = $this->getPetitionBasicDetails($case_no);
                if($petitioBasicData->lm_note_yn == 'Y')
                {
                    //unset($updateArray['assigned_date']);
                    //unset($updateArray['escalated_date']);
                }
                else
                {
                    unset($updateArray['assigned_date']);
                    unset($updateArray['escalated_date']);                    
                }

                //// $updateArray['history_id_others'] = null;
                $updateArray['assignment_type_other'] = null;
                $updateArray['assigned_other'] = null;
                $updateArray['assigned_other_code'] = null;
                $updateArray['assigned_other_date'] = null;
                $updateArray['assigned_other_es_date'] = null;
                $updateArray['to_be_other_completed_within_days'] = null;
                $updateArray['assigned_from_other'] = null;
                $updateArray['assigned_from_other_code'] = null;

                $checkSKReportDoneorNot = $escalatedRowDetailsAgainstPetitionno->assigned_to_code;
                if ($checkSKReportDoneorNot == 6) {
                    $originalAllocation = $escalatedRowDetailsAgainstPetitionno->co_target_days;
                    $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
                    $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO, $originalAllocation);
                    if ($remaining_days_other < 0) {
                        $response['responseType'] = 0;
                        $response['msg'] = '#ERRRMESCLATION3281AST : Remaining days can not be zero days';
                        return $response;
                    }
                    // $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);
                    // $updateArray['assigned_date'] = $executionDate;
                    // $updateArray['escalated_date'] = $escalatedDate;
                }

            }
            //// end====================

        }

        if ($user_type == 'SK') {
            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);

            $dateCodes = $escalatedRowDetailsAgainstPetitionno->sk_date_code_list;
            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->sk_completed_days;
            $sk_target_days = $escalatedRowDetailsAgainstPetitionno->sk_target_days;
            // log_message("error","SK-TARGET_DAYS=======".$sk_target_days);
            $sk_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);
            // log_message("error","SK-COMPLETION_DAYS=======".$sk_completed_days);
            // if ($sk_target_days < $sk_completed_days) {
            //     $escalate_status = 'Y';
            // } else {
                $escalate_status = 'N';
            // }
            // log_message("error","SK-ESCALATE_STATUS=======".$escalate_status);
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }

            //this calculation is for assigning CO from SK and taking hearing date as assigned date====
            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO, $originalAllocation);
            if ($remaining_days_other == null || $remaining_days_other < 0) {
                    $response['responseType'] = 0;
                    $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                    return $response;
                }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $assigned_other_es_date = $this->getOtherEscalatedDate($remaining_days_other, $hearing_date);
            $to_be_completed_within_days = $this->dateDiff($assigned_other_es_date, $hearing_date);
            // log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);

            ///end==============

            //if action taken done then co assigned date is sk report date
            //otherwise co report date is action taken date

            $checkDAActionTakenDoneOrNot = $escalatedRowDetailsAgainstPetitionno->assigned_other;
            if ($checkDAActionTakenDoneOrNot == null) {
                $hearing_date = $executionDate;
                $assigned_other_es_date = $this->getEscalatedDateNew($remaining_days_other, $hearing_date);
            }

            $updateArray = array(
                'taskid' => $taskid,
                'sk_completed_days' => (int) $sk_completed_days + (int) $previousCompletedDays,
                'sk_escalate_status' => $escalate_status,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                // 'assigned_date'      => $executionDate,
                'assigned_date' => $hearing_date,
                'escalated_date' => $assigned_other_es_date,
                'sk_date_code_list' => $dateCodes,
                'to_be_completed_within_days' => $to_be_completed_within_days,
            );

            // log_message("error","CO==============SK".json_encode($updateArray));

        }

        if ($user_type == 'LM') {

            // changed as the execution date is depend on action taken or not
            $completion_days_for_history = $this->dateDiff($current_date, $lastAssignedDate);

            $dateCodes = $escalatedRowDetailsAgainstPetitionno->lm_date_code_list;
            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
            $lm_target_days = $escalatedRowDetailsAgainstPetitionno->lm_target_days;

            // log_message("error","LM-TARGET_DAYS=======".$lm_target_days);
            $lm_completed_days = $this->dateDiff($current_date, $lastAssignedDate);
            // log_message("error","LM-COMPLETION_DAYS=======".$lm_completed_days);
            // if ($lm_target_days < $lm_completed_days) {
            //     $escalate_status = 'Y';
            // } else {
                $escalate_status = 'N';
            // }
            // log_message("error","LM-ESCALATE_STATUS=======".$escalate_status);
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }

            // if($assigned_to_other_type == 'LMRevert'){
            //   //this calculation is for assigning CO from LM and taking hearing date as assigned date AS REVERT CASE====
            //   $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            //   $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            //   $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
            //   $assigned_other_es_date = $this->getOtherEscalatedDate($remaining_days_other,$hearing_date);
            //   $to_be_completed_within_days = $this->dateDiff($assigned_other_es_date,$hearing_date);
            //   log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);
            //   $executionDate = $hearing_date;
            //   $escalatedDate = $assigned_other_es_date;
            // }
            $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);
            $updateArray = array(
                'taskid' => $taskid,
                'lm_completed_days' => (int) $lm_completed_days + (int) $previousCompletedDays,
                'lm_escalate_status' => $escalate_status,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_date' => $executionDate,
                'escalated_date' => $escalatedDate,
                'lm_date_code_list' => $dateCodes,
                'to_be_completed_within_days' => $to_be_completed_within_days,
            );

        }

        //UPDATE ESCALATION DATE HISTORY TABLE=====================

        $updateFlag = true;
        if ($assigned_to_other_type == 'Notice' || $assigned_to_other_type == 'Action') {
            $updateFlag = false;
            $history_id = $escalatedRowDetailsAgainstPetitionno->history_id_others;
        } else {
            $updateFlag = true;
            $history_id = $escalatedRowDetailsAgainstPetitionno->history_id;
        }

        // log_message("error","UPDATED FLAG ==========".$updateFlag);

        //STEPS to be followed:
        // 1. update escalation_dates_details against or history id
        // 2.update escalation_details with new date codes without history id
        // 3.insert history details and updated escalattion details with new history id

        $where_history = array(
            'petition_no' => $petition_no,
            'date_code'   => $history_id,
            'service_code' => $service_code
        );
        $updateDatesArray = array(
            'completion_date' => $current_date,
            'escalated_status' => $escalate_status,
            'completion_days' => $completion_days_for_history,
        );

        $updateStatus22 = $this->db->update('escalation_dates_details', $updateDatesArray, $where_history);
        // log_message("error","UPDt history escalation_dates_details TABLE=======".$this->db->affected_rows());
        if ($this->db->affected_rows() <= 0) {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION565 : Updation failed on Escalation row not found';
            return $response;
        }

        ///////////////END PROCESS//////////////////////////

        $where = array(
            'petition_no' => $petition_no,
            'case_no'     => $case_no,
        );

        if ($finalStatus == 'final') {
            unset($updateArray['assigned_to']);
            unset($updateArray['assigned_to_code']);
            unset($updateArray['assigned_from']);
            unset($updateArray['assigned_from_code']);
            unset($updateArray['assigned_date']);
            unset($updateArray['escalated_date']);
            unset($updateArray['to_be_completed_within_days']);
            unset($updateArray['co_date_code_list']);

            $updateArray['assignment_type_other'] = null;
            $updateArray['assigned_other'] = null;
            $updateArray['assigned_other_code'] = null;
            $updateArray['assigned_other_date'] = null;
            $updateArray['assigned_other_es_date'] = null;
            $updateArray['to_be_other_completed_within_days'] = null;
            $updateArray['assigned_from_other'] = null;
            $updateArray['assigned_from_other_code'] = null;
            $updateArray['final_completion_date'] = $executionDate;
            $updateArray['status'] = 'F';

        }

        // log_message('error',"FINAL UPDATED ARRAY===============".json_encode($updateArray));
        $updateStatus1 = $this->db->update('escalation_details', $updateArray, $where);

        // log_message("error","ESCALATION DETAILS ENTRY TABLE=======".$this->db->affected_rows());
        // if($this->db->affected_rows() <= 0){
        //    $flag = 0;
        // }else{
        //    $flag = 1;
        // }
        if ($this->db->affected_rows() <= 0) {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION610 : Updation failed on escalation_details';
            return $response;
        }

        if ($doubleEntry == 0 && $finalStatus == null) {
            if ($assigned_to_other_type == 'Notice' || $assigned_to_other_type == 'SKReport') {
                $executionDate = $hearing_date;
                $escalatedDate = $assigned_other_es_date;
            }
            if($assigned_to_code == 8)
            {
                $executionDate = $hearing_date;
            }

            $action_type = json_decode(ASSIGNMENT_TYPE);
            $action_type = $action_type[0]->CODE;
            if ($escalate_status == 'Y') {
                $action_type = $action_type[1]->CODE;
            }

            $date_history = $this->generateDateCode();
            $insertDateArray = array(
                'sr_no' => $dateCode,
                'date_code' => $date_history,
                'petition_no' => $petition_no,
                'service_code' => $escalatedRowDetailsAgainstPetitionno->service_code,
                'taskid' => $taskid,
                'action_type' => $action_type,
                'pending_officer' => $assigned_to,
                'assigned_user' => $user_code,
                'assigned_user_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'registerd_on' => $escalatedRowDetailsAgainstPetitionno->registerd_on,
                'allocation_date' => $executionDate,
                'target_completion_date' => $escalatedDate,
                'date_diff' => $this->dateDiff($escalatedDate, $executionDate),
                'escalated_status' => $escalate_status,
                'created_date' => date('Y-m-d H:i:s'),
                'updated_date' => date('Y-m-d H:i:s'),
                'case_no'      => $case_no,
            );
            if ($finalStatus == 'final') {
                $insertDateArray['completion_date'] = $executionDate;
            }
            // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
            $status = $this->db->insert('escalation_dates_details', $insertDateArray);
            if ($status != 1) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRESCLATION610 : Updation failed on escalation_details';
                return $response;
            }
            if ($updateFlag == true) {
                $where_history_set = array(
                    'petition_no' => $petition_no,
                    'case_no'     => $case_no
                );
                $updateDatesArraySet = array(
                    'history_id' => $date_history,
                );
                $updateStatus22 = $this->db->update('escalation_details', $updateDatesArraySet, $where_history_set);
                if ($this->db->affected_rows() <= 0) {
                    $response['responseType'] = 0;
                    $response['msg'] = '#ERRESCLATION662 : Updation failed on escalation_details';
                    return $response;
                }
            }

        }

        //INSERT HISTORY FOR ESCALATION DATE DETAILS=====================
        if ($entryTimes == 1) {
            $action_type = json_decode(ASSIGNMENT_TYPE);
            $action_type = $action_type[0]->CODE;
            if ($escalate_status == 'Y') {
                $action_type = $action_type[1]->CODE;
            }
            if($assigned_other_code == 8)
            {
                $executionDate = $hearing_date;
            }

            $date_history = $this->generateDateCode();
            $insertDateArray = array(
                'date_code' => $date_history,
                'petition_no' => $petition_no,
                'service_code' => $escalatedRowDetailsAgainstPetitionno->service_code,
                'taskid' => $taskid,
                'action_type' => $action_type,
                'pending_officer' => $assigned_to_other,
                'assigned_user' => $user_code,
                'assigned_user_code' => $assigned_from_code,
                'assigned_to' => $assigned_to_other,
                'assigned_to_code' => $assigned_other_code,
                'registerd_on' => $escalatedRowDetailsAgainstPetitionno->registerd_on,
                'allocation_date' => $assigned_other_date,
                'target_completion_date' => $assigned_other_es_date,
                'date_diff' => $this->dateDiff($assigned_other_es_date, $executionDate),
                'escalated_status' => $escalate_status,
                'created_date' => date('Y-m-d H:i:s'),
                'updated_date' => date('Y-m-d H:i:s'),
                'case_no'      => $case_no,
            );
            $status = $this->db->insert('escalation_dates_details', $insertDateArray);
            if ($status != 1) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRESCLATION696 : Updation failed on escalation_dates_details';
                return $response;
            }
            $where_history_set = array(
                'petition_no' => $petition_no,
                'case_no'      => $case_no,
            );

            $updateDatesArraySet = array(
                'history_id_others' => $date_history,
            );
            $updateStatus22 = $this->db->update('escalation_details', $updateDatesArraySet, $where_history_set);
            if ($this->db->affected_rows() <= 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRESCLATION710 : Updation failed on escalation_details';
                return $response;
            }
        }

        return $response;

        // log_message("error","ESCALATION DATE DETAILS ENTRY TABLE=======".$status);
        //////////////////////END PROCESS////////////////////
        // if($status !=1){
        //   $flag1 = 0;
        // }else{
        //   $flag1 = 1;
        // }
        // if($flag==1 && $flag1 == 1){
        //   return $flag;
        // }else{
        //   return 0;
        // }
    }

    public function escalationMatrixUpdateFMUT($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days)
    {
        $executionDate = date('Y-m-d H:i:s');
        $response = array('responseType' => 1, 'msg' => null);
        $petition_no = $this->getPetitionNo($case_no, $service_code, 'FMUT');
        if ($petition_no == null || $petition_no == '') {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION731 : Petition No not found';
            return $response;
        }
        // WARNING BEFORE CODE=========================
        // $assigned_to_other_type may be notice or role name
        ///////////////////////////////////

        $doubleEntry = 0;
        log_message('error','SSSSSSSSSSSSSS'.$petition_no."-----".$service_code);
        $escalatedRowDetailsAgainstPetitionno = $this->getEscalatedRowDetails($petition_no,$service_code);
        if ($escalatedRowDetailsAgainstPetitionno == null || empty($escalatedRowDetailsAgainstPetitionno)) {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION744 : Escalation row not found';
            return $response;
        }

        // log_message('error',"getEscalatedRowDetails=========".json_encode($escalatedRowDetailsAgainstPetitionno));

        $assigned_other_code = $assigned_to_code = $assigned_from_code = null;
        $userCodeList = json_decode(USER_ALLOT_CODE);
        foreach ($userCodeList as $key => $value) {
            if ($value->USER == $user_type) {
                $assigned_from_code = $value->CODE;
            }
            if ($value->USER == $assigned_user_type) {
                $assigned_to_code = $value->CODE;
            }
            if ($value->USER == $assigned_to_other_type) {
                $assigned_other_code = $value->CODE;
            }
        }

        $lastAssignedDate = $escalatedRowDetailsAgainstPetitionno->assigned_date;

        $lastEscalatedDate = $escalatedRowDetailsAgainstPetitionno->escalated_date;
        if ($user_type == 'AST') {
            $lastAssignedDate = $escalatedRowDetailsAgainstPetitionno->assigned_other_date;
            $lastEscalatedDate = $escalatedRowDetailsAgainstPetitionno->assigned_other_es_date;
        }
        $validateExecutionDateTime = $this->checkCaseExecutionOnTimeOrNot($executionDate, $lastAssignedDate, $lastEscalatedDate);
        if ($validateExecutionDateTime == 'n') {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION820 : Case Execution not on time';
            return $response;
        }

        // log_message("error","ASSIGNED_DATE=======".$lastAssignedDate);
        $typeService = null;
        if($service_code == 2)
        {
            $typeService = 'FMUTD';
        }
        elseif($service_code == 1)
        {
            $typeService = 'FMUT';
        }
        $timeLineRow = $this->getTimeLine($service_code,$typeService);
        if ($timeLineRow == null || empty($timeLineRow)) {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION771 : Escalation row not found';
            return $response;
        }

        if ($assigned_user_type == 'LM') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
            $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
            // log_message("error","previousCompletedDaysLM--------------".$previousCompletedDaysLM);
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysLM, $originalAllocation);
            if ($remaining_days_other < 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281LM : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);

        } elseif ($assigned_user_type == 'SK') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->sk_target_days;
            $previousCompletedDaysSK = $escalatedRowDetailsAgainstPetitionno->sk_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysSK, $originalAllocation);
            if ($remaining_days_other < 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);
            // $escalatedDate = $this->getOtherEscalatedDate($remaining_days_other,$hearing_date);

        } elseif ($assigned_user_type == 'CO') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO, $originalAllocation);
            if ($remaining_days_other < 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281CO : Remaining days can not be zero days';
                return $response;
            }
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);

        }

        // var_dump($escalatedDate); die;
        $dateCode = $this->generateDateCode();
        // log_message("error","TYPE ".$user_type." =====ESCALATED_DATE=======".$escalatedDate);
        if ($user_type == 'CO') {
            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);
            $dateCodes = $escalatedRowDetailsAgainstPetitionno->co_date_code_list;

            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->co_completed_days;

            $co_target_days = $escalatedRowDetailsAgainstPetitionno->co_target_days;

            // log_message("error","========CO-TARGET_DAYS =======".$co_target_days);

            $co_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);

            // log_message("error","========CO-COMPLETION_DAYS=======".$co_completed_days);
            // if ($co_target_days < $co_completed_days) {
            //     $escalate_status = 'Y';
            // } else {
                $escalate_status = 'N';
            // }
            // log_message("error","CO-ESCALATE_STATUS=======".$escalate_status);
            $latestHistoryCode = $dateCodes;
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }
            $entryTimes = 0;
            $doubleEntry = 0;
            $assigned_other_date = null;
            $to_be_other_completed_within_days = null;
            $assigned_other_es_date = null;

            $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);

            $updateArray = array(
                'taskid' => $taskid,
                'co_completed_days' => (int) $co_completed_days + (int) $previousCompletedDays,
                'co_escalate_status' => $escalate_status,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_date' => $executionDate,
                'escalated_date' => $escalatedDate,
                'to_be_completed_within_days' => $to_be_completed_within_days,
                'co_date_code_list' => $dateCodes,
            );

        }

        if ($user_type == 'SK') {
            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);

            $dateCodes = $escalatedRowDetailsAgainstPetitionno->sk_date_code_list;
            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->sk_completed_days;
            $sk_target_days = $escalatedRowDetailsAgainstPetitionno->sk_target_days;
            // log_message("error","SK-TARGET_DAYS=======".$sk_target_days);
            $sk_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);
            // log_message("error","SK-COMPLETION_DAYS=======".$sk_completed_days);
            // if ($sk_target_days < $sk_completed_days) {
            //     $escalate_status = 'Y';
            // } else {
                $escalate_status = 'N';
            // }
            // log_message("error","SK-ESCALATE_STATUS=======".$escalate_status);
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }

            //this calculation is for assigning CO from SK and taking hearing date as assigned date====
            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO, $originalAllocation);
            if ($remaining_days_other < 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $assigned_other_es_date = $this->getOtherEscalatedDate($remaining_days_other, $hearing_date);
            $to_be_completed_within_days = $this->dateDiff($assigned_other_es_date, $hearing_date);
            // log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);
            ///end==============

            $updateArray = array(
                'taskid' => $taskid,
                'sk_completed_days' => (int) $sk_completed_days + (int) $previousCompletedDays,
                'sk_escalate_status' => $escalate_status,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                // 'assigned_date'      => $executionDate,
                'assigned_date' => $hearing_date,
                'escalated_date' => $assigned_other_es_date,
                'sk_date_code_list' => $dateCodes,
                'to_be_completed_within_days' => $to_be_completed_within_days,
            );

            // log_message("error","CO==============SK".json_encode($updateArray));

        }

        if ($user_type == 'LM') {

            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);

            $dateCodes = $escalatedRowDetailsAgainstPetitionno->lm_date_code_list;
            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
            $lm_target_days = $escalatedRowDetailsAgainstPetitionno->lm_target_days;

            // log_message("error","LM-TARGET_DAYS=======".$lm_target_days);
            $lm_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);
            // log_message("error","LM-COMPLETION_DAYS=======".$lm_completed_days);
            // if ($lm_target_days < $lm_completed_days) {
            //     $escalate_status = 'Y';
            // } else {
                $escalate_status = 'N';
            // }
            // log_message("error","LM-ESCALATE_STATUS=======".$escalate_status);
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }

            // if($assigned_to_other_type == 'LMRevert'){
            //   //this calculation is for assigning CO from LM and taking hearing date as assigned date AS REVERT CASE====
            //   $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            //   $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            //   $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
            //   $assigned_other_es_date = $this->getOtherEscalatedDate($remaining_days_other,$hearing_date);
            //   $to_be_completed_within_days = $this->dateDiff($assigned_other_es_date,$hearing_date);
            //   log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);
            //   $executionDate = $hearing_date;
            //   $escalatedDate = $assigned_other_es_date;
            // }
            $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);
            $updateArray = array(
                'taskid' => $taskid,
                'lm_completed_days' => (int) $lm_completed_days + (int) $previousCompletedDays,
                'lm_escalate_status' => $escalate_status,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_date' => $executionDate,
                'escalated_date' => $escalatedDate,
                'lm_date_code_list' => $dateCodes,
                'to_be_completed_within_days' => $to_be_completed_within_days,
            );

        }

        //UPDATE ESCALATION DATE HISTORY TABLE=====================

        // $updateFlag =true;
        // if($assigned_to_other_type == 'Notice' || $assigned_to_other_type == 'Action'){
        //     $updateFlag = false;
        //     $history_id = $escalatedRowDetailsAgainstPetitionno->history_id_others;
        // }else{
        $updateFlag = true;
        $history_id = $escalatedRowDetailsAgainstPetitionno->history_id;
        // }

        // log_message("error","UPDATED FLAG ==========".$updateFlag);

        //STEPS to be followed:
        // 1. update escalation_dates_details against or history id
        // 2.update escalation_details with new date codes without history id
        // 3.insert history details and updated escalattion details with new history id

        $where_history = array(
            'petition_no' => $petition_no,
            'date_code' => $history_id,
            'service_code' => $service_code
        );
        $updateDatesArray = array(
            'completion_date' => $executionDate,
            'escalated_status' => $escalate_status,
            'completion_days' => $completion_days_for_history,

        );

        $updateStatus22 = $this->db->update('escalation_dates_details', $updateDatesArray, $where_history);
        // log_message("error","UPDt history escalation_dates_details TABLE=======".$this->db->affected_rows());
        if ($this->db->affected_rows() <= 0) {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION995 : Insertion Failed on escalation_dates_details';
            return $response;
        }

        ///////////////END PROCESS//////////////////////////

        $where = array(
            'petition_no' => $petition_no,
            'service_code' => $service_code,
            'case_no' => $case_no
        );

        // old01082023
        // if($finalStatus == 'final'){

        //   $updateArray['final_completion_date']= $executionDate;
        //   $updateArray['status']= 'F';

        // }
        if ($finalStatus == 'final') {
            unset($updateArray['assigned_to']);
            unset($updateArray['assigned_to_code']);
            unset($updateArray['assigned_from']);
            unset($updateArray['assigned_from_code']);
            unset($updateArray['assigned_date']);
            unset($updateArray['escalated_date']);
            unset($updateArray['to_be_completed_within_days']);
            unset($updateArray['co_date_code_list']);

            $updateArray['assignment_type_other'] = null;
            $updateArray['assigned_other'] = null;
            $updateArray['assigned_other_code'] = null;
            $updateArray['assigned_other_date'] = null;
            $updateArray['assigned_other_es_date'] = null;
            $updateArray['to_be_other_completed_within_days'] = null;
            $updateArray['final_completion_date'] = $executionDate;
            $updateArray['status'] = 'F';

        }

        // log_message('error',"FINAL UPDATED ARRAY===============".json_encode($updateArray));
        $updateStatus1 = $this->db->update('escalation_details', $updateArray, $where);

        // log_message("error","ESCALATION DETAILS ENTRY TABLE=======".$this->db->affected_rows());
        // if($this->db->affected_rows() <= 0){
        //    $flag = 0;
        // }else{
        //    $flag = 1;
        // }
        if ($this->db->affected_rows() <= 0) {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION1046 : Insertion Failed on escalation_details';
            return $response;
        }

        if ($doubleEntry == 0 && $finalStatus == null) {
            // if($assigned_to_other_type == 'Notice' || $assigned_to_other_type == 'SKReport'){
            //   $executionDate = $hearing_date;
            //   $escalatedDate = $assigned_other_es_date;
            // }
            $action_type = json_decode(ASSIGNMENT_TYPE);
            $action_type = $action_type[0]->CODE;
            if ($escalate_status == 'Y') {
                $action_type = $action_type[1]->CODE;
            }

            $date_history = $this->generateDateCode();
            $insertDateArray = array(
                'sr_no' => $dateCode,
                'date_code' => $date_history,
                'petition_no' => $petition_no,
                'service_code' => $service_code,
                'taskid' => $taskid,
                'action_type' => $action_type,
                'pending_officer' => $assigned_to,
                'assigned_user' => $user_code,
                'assigned_user_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'registerd_on' => $escalatedRowDetailsAgainstPetitionno->registerd_on,
                'allocation_date' => $executionDate,
                'target_completion_date' => $escalatedDate,
                'date_diff' => $this->dateDiff($escalatedDate, $executionDate),
                'escalated_status' => $escalate_status,
                'created_date' => date('Y-m-d H:i:s'),
                'updated_date' => date('Y-m-d H:i:s'),
                'case_no'      => $case_no,
            );
            // if($finalStatus == 'final'){
            //   $insertDateArray['completion_date'] = $executionDate;
            // }
            // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
            $status = $this->db->insert('escalation_dates_details', $insertDateArray);
            if ($status != 1) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRESCLATION1084 : Insertion Failed on escalation_dates_details';
                return $response;
            }
            if ($updateFlag == true) {
                $where_history_set = array(
                    'petition_no' => $petition_no,
                    'case_no'     => $case_no
                );
                $updateDatesArraySet = array(
                    'history_id' => $date_history,
                );
                $updateStatus22 = $this->db->update('escalation_details', $updateDatesArraySet, $where_history_set);
                if ($this->db->affected_rows() <= 0) {
                    $response['responseType'] = 0;
                    $response['msg'] = '#ERRESCLATION1098 : Updation Failed on escalation_details';
                    return $response;
                }
            }

        }
        return $response;
        // else{
        //     $status = 1;
        // }

        // log_message("error","ESCALATION DATE DETAILS ENTRY TABLE=======".$status);
        //////////////////////END PROCESS////////////////////
        // if($status !=1){
        //   $flag1 = 0;
        // }else{
        //   $flag1 = 1;
        // }
        // if($flag==1 && $flag1 == 1){
        //   return $flag;
        // }else{
        //   return 0;
        // }
    }

    public function escalationMatrixUpdateNCAN($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days)
    {

        $executionDate = date('Y-m-d H:i:s');
        $response = array('responseType' => 1, 'msg' => null);
        $petition_no = $this->getPetitionNoNCAN($case_no);
        if ($petition_no == null || $petition_no == '') {
            log_message('error', '#ERRESCLATION1144 : Petition No not found');
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION1144 : Petition No not found';
            return $response;
        }
        // WARNING BEFORE CODE=========================
        // $assigned_to_other_type may be notice or role name
        ///////////////////////////////////

        $escalatedRowDetailsAgainstPetitionno = $this->getEscalatedRowDetails($petition_no,$service_code);
        if ($escalatedRowDetailsAgainstPetitionno == null || empty($escalatedRowDetailsAgainstPetitionno)) {
            log_message('error', '#ERRESCLATION1157 : Escalation matrix row not found');
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION1157 : Escalation matrix row not found';
            return $response;
        }
        $assigned_other_code = $assigned_to_code = $assigned_from_code = null;
        $userCodeList = json_decode(USER_ALLOT_CODE);
        foreach ($userCodeList as $key => $value) {
            if ($value->USER == $user_type) {
                $assigned_from_code = $value->CODE;
            }
            if ($value->USER == $assigned_user_type) {
                $assigned_to_code = $value->CODE;
            }
            if ($value->USER == $assigned_to_other_type) {
                $assigned_other_code = $value->CODE;
            }
        }

        $lastAssignedDate = $escalatedRowDetailsAgainstPetitionno->assigned_date;

        $lastEscalatedDate = $escalatedRowDetailsAgainstPetitionno->escalated_date;
        if ($user_type == 'AST') {
            $lastEscalatedDate = $escalatedRowDetailsAgainstPetitionno->assigned_other_es_date;
        }

        $validateExecutionDateTime = $this->checkCaseExecutionOnTimeOrNot($executionDate, $lastAssignedDate, $lastEscalatedDate);
        if ($validateExecutionDateTime == 'n') {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION1243 : Case Execution not on time';
            return $response;
        }
        // log_message("error","ASSIGNED_DATE=======".$lastAssignedDate);
        $timeLineRow = $this->getTimeLine($service_code, 'NCAN');
        if ($timeLineRow == null || empty($timeLineRow)) {
            log_message('error', '#ERRESCLATION1157 : Escalation matrix row not found');
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION1157 : Escalation matrix row not found';
            return $response;
        }

        if ($assigned_user_type == 'AST') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->da_target_days;
            $previousCompletedDaysDA = $escalatedRowDetailsAgainstPetitionno->da_completed_days;

            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysDA, $originalAllocation);
            if ($remaining_days_other == null || $remaining_days_other == 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);

        } elseif ($assigned_user_type == 'LM') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
            $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
            // log_message("error","previousCompletedDaysLM--------------".$previousCompletedDaysLM);
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysLM, $originalAllocation);
            if ($remaining_days_other == null || $remaining_days_other == 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);

        } elseif ($assigned_user_type == 'SK') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->sk_target_days;
            $previousCompletedDaysSK = $escalatedRowDetailsAgainstPetitionno->sk_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysSK, $originalAllocation);
            if ($remaining_days_other == null || $remaining_days_other == 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);
            // $escalatedDate = $this->getOtherEscalatedDate($remaining_days_other,$hearing_date);

        } elseif ($assigned_user_type == 'CO') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO, $originalAllocation);
            if ($remaining_days_other == null || $remaining_days_other == 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);

        }
        $doubleEntry = 0;
        $entryTimes = 0;
        $dateCode = $this->generateDateCode();
        // log_message("error","TYPE ".$user_type." =====ESCALATED_DATE=======".$escalatedDate);
        if ($user_type == 'CO') {
            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);
            $dateCodes = $escalatedRowDetailsAgainstPetitionno->co_date_code_list;

            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->co_completed_days;

            $co_target_days = $escalatedRowDetailsAgainstPetitionno->co_target_days;

            // log_message("error","========CO-TARGET_DAYS =======".$co_target_days);

            $co_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);

            // log_message("error","========CO-COMPLETION_DAYS=======".$co_completed_days);
            if ($co_target_days < $co_completed_days) {
                $escalate_status = 'Y';
            } else {
                $escalate_status = 'N';
            }
            // log_message("error","CO-ESCALATE_STATUS=======".$escalate_status);
            $latestHistoryCode = $dateCodes;
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }
            $entryTimes = 0;

            $assigned_other_date = null;
            $to_be_other_completed_within_days = null;
            $assigned_other_es_date = null;
            if ($assigned_to_other != null) {
                //this is designed for CO first proceding as assigned to LM and DA==========
                $entryTimes = 1;
                //////////

                $assigned_other_date = $executionDate;
                if ($assigned_to_other_type == 'LM') {

                    $originalAllocation = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
                    $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
                    $remaining_days_other = $this->getRemainingDays($previousCompletedDaysLM, $originalAllocation);
                    if ($remaining_days_other == null || $remaining_days_other == 0) {
                        $response['responseType'] = 0;
                        $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                        return $response;
                    }
                    // $assigned_other_es_date = $this->getEscalatedDate($remaining_days_other);
                    $assigned_other_es_date = $this->getEscalatedDateNew($remaining_days_other, $executionDate);
                    $to_be_other_completed_within_days = $this->dateDiff($assigned_other_es_date, $executionDate);
                } elseif ($assigned_to_other_type == 'AST') {

                    $originalAllocation = $escalatedRowDetailsAgainstPetitionno->da_target_days;
                    $previousCompletedDaysDA = $escalatedRowDetailsAgainstPetitionno->da_completed_days;
                    $remaining_days_other = $this->getRemainingDays($previousCompletedDaysDA, $originalAllocation);
                    if ($remaining_days_other == null || $remaining_days_other == 0) {
                        $response['responseType'] = 0;
                        $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                        return $response;
                    }
                    // $assigned_other_es_date = $this->getEscalatedDate($remaining_days_other);
                    $assigned_other_es_date = $this->getEscalatedDateNew($remaining_days_other, $executionDate);
                    $to_be_other_completed_within_days = $this->dateDiff($assigned_other_es_date, $executionDate);
                }

            }
            $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);

            $updateArray = array(
                'taskid' => $taskid,
                'co_completed_days' => (int) $co_completed_days + (int) $previousCompletedDays,
                'co_escalate_status' => $escalate_status,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_date' => $executionDate,
                'escalated_date' => $escalatedDate,
                'to_be_completed_within_days' => $to_be_completed_within_days,
                'co_date_code_list' => $dateCodes,
                'assignment_type' => $assignment_type,
                'assignment_type_other' => $assignment_type_other,
                'assigned_from_other'      => $user_code,
                'assigned_from_other_code' => $assigned_from_code,
                'assigned_other' => $assigned_to_other,
                'assigned_other_code' => $assigned_other_code,
                'assigned_other_date' => $assigned_other_date,
                'assigned_other_es_date' => $assigned_other_es_date,
                'to_be_other_completed_within_days' => $to_be_other_completed_within_days,
            );

        }
        if ($user_type == 'AST') {

            $completion_days_for_history = $this->dateDiff($executionDate, $escalatedRowDetailsAgainstPetitionno->assigned_other_date);
            $dateCodes = $escalatedRowDetailsAgainstPetitionno->da_date_code_list;

            if ($assigned_to_other_type == 'Notice' || $assigned_to_other_type == 'Action') {
                $lastAssignedDate = $escalatedRowDetailsAgainstPetitionno->assigned_other_date;
            }

            $da_target_days = $escalatedRowDetailsAgainstPetitionno->da_target_days;
            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->da_completed_days;
            // log_message("error","DA-TARGET_DAYS=======".$da_target_days);
            $da_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);
            // log_message("error","DA-COMPLETION_DAYS=======".$da_completed_days);
            if ($da_target_days < $da_completed_days) {
                $escalate_status = 'Y';
            } else {
                $escalate_status = 'N';
            }
            // log_message("error","DA-ESCALATE_STATUS=======".$escalate_status);

            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }

            $updateArray = array(
                'taskid' => $taskid,
                'da_completed_days' => (int) $da_completed_days + (int) $previousCompletedDays,
                'da_escalate_status' => $escalate_status,
                'assigned_from_other' => $user_code,
                'assigned_from_other_code' => $assigned_from_code,
                // 'assigned_from' => $user_code,
                // 'assigned_from_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_date' => $executionDate,
                'escalated_date' => $escalatedDate,
                'da_date_code_list' => $dateCodes,
            );

            //this code use only while Asistant generate notice==============
            if ($assigned_to_other_type == 'Notice') {

                //THIS CODE ONLY FOR NOTICE GENERATE AND NEXT ALLOCATION DATE WILL BE AFTER HEARING DATE==========
                $originalAllocation = $escalatedRowDetailsAgainstPetitionno->da_target_days;
                $previousCompletedDaysDA = $da_completed_days;
                $remaining_days_other = $this->getRemainingDays($previousCompletedDaysDA, $originalAllocation);
                if ($remaining_days_other == null || $remaining_days_other == 0) {
                    $response['responseType'] = 0;
                    $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                    return $response;
                }
                //end==============
                log_message("error","remaining_days_other,hearing_date =======".$remaining_days_other."---".$hearing_date);
                
                $assigned_other_es_date = $this->getOtherEscalatedDate($remaining_days_other, $hearing_date);
                unset($updateArray['assigned_from']);
                unset($updateArray['assigned_from_code']);
                unset($updateArray['assigned_to_code']);
                unset($updateArray['assigned_to']);
                unset($updateArray['assigned_date']);
                unset($updateArray['escalated_date']);
                $updateArray['assigned_other_date'] = $hearing_date;
                $updateArray['to_be_other_completed_within_days'] = $this->dateDiff($assigned_other_es_date, $hearing_date);
                $updateArray['assigned_other_es_date'] = $assigned_other_es_date;

            }
            //// end====================
            //this code use only while Asistant generate Action Taken==============

            if ($assigned_to_other_type == 'Action') {

                unset($updateArray['assigned_from']);
                unset($updateArray['assigned_from_code']);
                unset($updateArray['assigned_to_code']);
                unset($updateArray['assigned_to']);
                unset($updateArray['assigned_date']);
                unset($updateArray['escalated_date']);
                //$updateArray['history_id_others'] = null;
                $updateArray['assignment_type_other'] = null;
                $updateArray['assigned_other'] = null;
                $updateArray['assigned_other_code'] = null;
                $updateArray['assigned_other_date'] = null;
                $updateArray['assigned_other_es_date'] = null;
                $updateArray['to_be_other_completed_within_days'] = null;
                $updateArray['assigned_from_other'] = null;
                $updateArray['assigned_from_other_code'] = null;

                $checkLMReportDoneorNot = $escalatedRowDetailsAgainstPetitionno->assigned_to_code;
                if ($checkLMReportDoneorNot == 6) {
                    $originalAllocation = $escalatedRowDetailsAgainstPetitionno->co_target_days;
                    $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
                    $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO, $originalAllocation);
                    if ($remaining_days_other == null || $remaining_days_other == 0) {
                        $response['responseType'] = 0;
                        $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                        return $response;
                    }
                    // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
                    $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);
                    $updateArray['assigned_date'] = $executionDate;
                    $updateArray['escalated_date'] = $escalatedDate;
                }

            }
            //// end====================

        }

        if ($user_type == 'SK') {
            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);

            $dateCodes = $escalatedRowDetailsAgainstPetitionno->sk_date_code_list;
            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->sk_completed_days;
            $sk_target_days = $escalatedRowDetailsAgainstPetitionno->sk_target_days;
            // log_message("error","SK-TARGET_DAYS=======".$sk_target_days);
            $sk_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);
            // log_message("error","SK-COMPLETION_DAYS=======".$sk_completed_days);
            if ($sk_target_days < $sk_completed_days) {
                $escalate_status = 'Y';
            } else {
                $escalate_status = 'N';
            }
            // log_message("error","SK-ESCALATE_STATUS=======".$escalate_status);
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }

            //this calculation is for assigning CO from SK and taking hearing date as assigned date====
            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO, $originalAllocation);
            if ($remaining_days_other == null || $remaining_days_other == 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $assigned_other_es_date = $this->getOtherEscalatedDate($remaining_days_other, $hearing_date);
            $to_be_completed_within_days = $this->dateDiff($assigned_other_es_date, $hearing_date);
            // log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);
            ///end==============

            $updateArray = array(
                'taskid' => $taskid,
                'sk_completed_days' => (int) $sk_completed_days + (int) $previousCompletedDays,
                'sk_escalate_status' => $escalate_status,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                // 'assigned_date'      => $executionDate,
                'assigned_date' => $hearing_date,
                'escalated_date' => $assigned_other_es_date,
                'sk_date_code_list' => $dateCodes,
                'to_be_completed_within_days' => $to_be_completed_within_days,
            );

            // log_message("error","CO==============SK".json_encode($updateArray));

        }

        if ($user_type == 'LM') {

            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);

            $dateCodes = $escalatedRowDetailsAgainstPetitionno->lm_date_code_list;
            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
            $lm_target_days = $escalatedRowDetailsAgainstPetitionno->lm_target_days;

            // log_message("error","LM-TARGET_DAYS=======".$lm_target_days);
            $lm_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);
            // log_message("error","LM-COMPLETION_DAYS=======".$lm_completed_days);
            if ($lm_target_days < $lm_completed_days) {
                $escalate_status = 'Y';
            } else {
                $escalate_status = 'N';
            }
            // log_message("error","LM-ESCALATE_STATUS=======".$escalate_status);
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }

            //this calculation is for assigning CO from SK and taking hearing date as assigned date====
            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO, $originalAllocation);
            if ($remaining_days_other == null || $remaining_days_other == 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $assigned_other_es_date = $this->getOtherEscalatedDate($remaining_days_other, $hearing_date);
            $to_be_completed_within_days = $this->dateDiff($assigned_other_es_date, $hearing_date);
            // log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);

            if ($assigned_to_other_type == 'LMRevert') {
                //this calculation is for assigning CO from LM and taking hearing date as assigned date AS REVERT CASE====
                $originalAllocation = $escalatedRowDetailsAgainstPetitionno->co_target_days;
                $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
                $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO, $originalAllocation);
                if ($remaining_days_other == null || $remaining_days_other == 0) {
                    $response['responseType'] = 0;
                    $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                    return $response;
                }
                // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
                $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);
                $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);
                // log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);
                $assigned_other_es_date = $escalatedDate;
                $hearing_date = $executionDate;
            }
            ///end==============

            $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);
            $updateArray = array(
                'taskid' => $taskid,
                'lm_completed_days' => (int) $lm_completed_days + (int) $previousCompletedDays,
                'lm_escalate_status' => $escalate_status,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_date' => $hearing_date,
                'escalated_date' => $assigned_other_es_date,
                'lm_date_code_list' => $dateCodes,
                'to_be_completed_within_days' => $to_be_completed_within_days,
            );

        }

        //UPDATE ESCALATION DATE HISTORY TABLE=====================

        $updateFlag = true;
        if ($assigned_to_other_type == 'Notice' || $assigned_to_other_type == 'Action') {
            $updateFlag = false;
            $history_id = $escalatedRowDetailsAgainstPetitionno->history_id_others;
        } else {
            $updateFlag = true;
            $history_id = $escalatedRowDetailsAgainstPetitionno->history_id;
        }

        // log_message("error","UPDATED FLAG ==========".$updateFlag);

        //STEPS to be followed:
        // 1. update escalation_dates_details against or history id
        // 2.update escalation_details with new date codes without history id
        // 3.insert history details and updated escalattion details with new history id

        $where_history = array(
            'petition_no' => $petition_no,
            'date_code' => $history_id,
            'service_code' => $service_code
        );
        $updateDatesArray = array(
            'completion_date' => $executionDate,
            'escalated_status' => $escalate_status,
            'completion_days' => $completion_days_for_history,
        );

        $updateStatus22 = $this->db->update('escalation_dates_details', $updateDatesArray, $where_history);
        // log_message("error","UPDt history escalation_dates_details TABLE=======".$this->db->affected_rows());
        if ($this->db->affected_rows() <= 0) {
            log_message('error', '#ERRESCLATION1569 : Updation failed on escalation_dates_details' . json_encode($this->db->last_query()));
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION1569 : Updation failed on escalation_dates_details';
            return $response;
        }

        ///////////////END PROCESS//////////////////////////

        $where = array(
            'petition_no' => $petition_no,
        );
        if ($finalStatus == 'final') {
            unset($updateArray['assigned_to']);
            unset($updateArray['assigned_to_code']);
            unset($updateArray['assigned_from']);
            unset($updateArray['assigned_from_code']);
            unset($updateArray['assigned_date']);
            unset($updateArray['escalated_date']);
            unset($updateArray['to_be_completed_within_days']);
            unset($updateArray['co_date_code_list']);

            $updateArray['assignment_type_other'] = null;
            $updateArray['assigned_other'] = null;
            $updateArray['assigned_other_code'] = null;
            $updateArray['assigned_other_date'] = null;
            $updateArray['assigned_other_es_date'] = null;
            $updateArray['to_be_other_completed_within_days'] = null;
            $updateArray['assigned_from_other'] = null;
            $updateArray['assigned_from_other_code'] = null;
            $updateArray['final_completion_date'] = $executionDate;
            $updateArray['status'] = 'F';

        }

        // log_message('error',"FINAL UPDATED ARRAY===============".json_encode($updateArray));
        $updateStatus1 = $this->db->update('escalation_details', $updateArray, $where);

        // log_message("error","ESCALATION DETAILS ENTRY TABLE=======".$this->db->affected_rows());
        // if($this->db->affected_rows() <= 0){
        //    $flag = 0;
        // }else{
        //    $flag = 1;
        // }
        if ($this->db->affected_rows() <= 0) {
            log_message('error', '#ERRESCLATION1613 : Updation failed on escalation_details' . json_encode($this->db->last_query()));
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION1613 : Updation failed on escalation_details';
            return $response;
        }

        if ($doubleEntry == 0 && $finalStatus == null) {
            if ($assigned_to_other_type == 'Notice' || $assigned_to_other_type == 'SKReport') {
                $executionDate = $hearing_date;
                $escalatedDate = $assigned_other_es_date;
            }

            $action_type = json_decode(ASSIGNMENT_TYPE);
            $action_type = $action_type[0]->CODE;
            if ($escalate_status == 'Y') {
                $action_type = $action_type[1]->CODE;
            }

            $date_history = $this->generateDateCode();
            $insertDateArray = array(
                'sr_no' => $dateCode,
                'date_code' => $date_history,
                'petition_no' => $petition_no,
                'service_code' => $service_code,
                'taskid' => $taskid,
                'action_type' => $action_type,
                'pending_officer' => $assigned_to,
                'assigned_user' => $user_code,
                'assigned_user_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'registerd_on' => $escalatedRowDetailsAgainstPetitionno->registerd_on,
                'allocation_date' => $executionDate,
                'target_completion_date' => $escalatedDate,
                'date_diff' => $this->dateDiff($escalatedDate, $executionDate),
                'escalated_status' => $escalate_status,
                'created_date' => date('Y-m-d H:i:s'),
                'updated_date' => date('Y-m-d H:i:s'),
            );
            // if($finalStatus == 'final'){
            //   $insertDateArray['completion_date'] = $executionDate;
            // }
            // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
            $status = $this->db->insert('escalation_dates_details', $insertDateArray);
            if ($status != 1) {
                log_message('error', '#ERRESCLATION1654 : Insertion failed on escalation_dates_details' . json_encode($this->db->last_query()));
                $response['responseType'] = 0;
                $response['msg'] = '#ERRESCLATION1654 : Insertion failed on escalation_dates_details';
                return $response;
            }
            if ($updateFlag == true) {
                $where_history_set = array(
                    'petition_no' => $petition_no,
                );
                $updateDatesArraySet = array(
                    'history_id' => $date_history,
                );
                $updateStatus22 = $this->db->update('escalation_details', $updateDatesArraySet, $where_history_set);
                if ($this->db->affected_rows() <= 0) {
                    log_message('error', '#ERRESCLATION1667 : Updation failed on escalation_details' . json_encode($this->db->last_query()));
                    $response['responseType'] = 0;
                    $response['msg'] = '#ERRESCLATION1667 : Updation failed on escalation_details';
                    return $response;
                }
            }

        }

        //INSERT HISTORY FOR ESCALATION DATE DETAILS=====================
        if ($entryTimes == 1) {

            $action_type = json_decode(ASSIGNMENT_TYPE);
            $action_type = $action_type[0]->CODE;
            if ($escalate_status == 'Y') {
                $action_type = $action_type[1]->CODE;
            }

            $date_history = $this->generateDateCode();
            $insertDateArray = array(
                'date_code' => $date_history,
                'petition_no' => $petition_no,
                'service_code' => $service_code,
                'taskid' => $taskid,
                'action_type' => $action_type,
                'pending_officer' => $assigned_to_other,
                'assigned_user' => $user_code,
                'assigned_user_code' => $assigned_from_code,
                'assigned_to' => $assigned_to_other,
                'assigned_to_code' => $assigned_other_code,
                'registerd_on' => $escalatedRowDetailsAgainstPetitionno->registerd_on,
                'allocation_date' => $assigned_other_date,
                'target_completion_date' => $assigned_other_es_date,
                'date_diff' => $this->dateDiff($assigned_other_es_date, $executionDate),
                'escalated_status' => $escalate_status,
                'created_date' => date('Y-m-d H:i:s'),
                'updated_date' => date('Y-m-d H:i:s'),
            );
            $status = $this->db->insert('escalation_dates_details', $insertDateArray);
            if ($status != 1) {
                log_message('error', '#ERRESCLATION1702 : Insertion failed on escalation_dates_details' . json_encode($this->db->last_query()));
                $response['responseType'] = 0;
                $response['msg'] = '#ERRESCLATION1702 : Insertion failed on escalation_dates_details';
                return $response;
            }
            $where_history_set = array(
                'petition_no' => $petition_no,
            );

            $updateDatesArraySet = array(
                'history_id_others' => $date_history,
            );
            $updateStatus22 = $this->db->update('escalation_details', $updateDatesArraySet, $where_history_set);
            if ($this->db->affected_rows() <= 0) {
                log_message('error', '#ERRESCLATION1702 : Updation failed on escalation_details' . json_encode($this->db->last_query()));
                $response['responseType'] = 0;
                $response['msg'] = '#ERRESCLATION1702 : Updation failed on escalation_details';
                return $response;
            }
        }

        return $response;
        // log_message("error","ESCALATION DATE DETAILS ENTRY TABLE=======".$status);
        // //////////////////////END PROCESS////////////////////
        // if($status !=1){
        //   $flag1 = 0;
        // }else{
        //   $flag1 = 1;
        // }
        // if($flag==1 && $flag1 == 1){
        //   return $flag;
        // }else{
        //   return 0;
        // }
    }

    public function escalationMatrixUpdateANCOR($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days)
    {

        $petition_no = $this->getPetitionNoANCOR($case_no);
        // WARNING BEFORE CODE=========================
        // $assigned_to_other_type may be notice or role name
        ///////////////////////////////////

        $escalatedRowDetailsAgainstPetitionno = $this->getEscalatedRowDetails($petition_no,$service_code);
        $assigned_other_code = $assigned_to_code = $assigned_from_code = null;
        $userCodeList = json_decode(USER_ALLOT_CODE);
        foreach ($userCodeList as $key => $value) {
            if ($value->USER == $user_type) {
                $assigned_from_code = $value->CODE;
            }
            if ($value->USER == $assigned_user_type) {
                $assigned_to_code = $value->CODE;
            }
            if ($value->USER == $assigned_to_other_type) {
                $assigned_other_code = $value->CODE;
            }
        }

        $lastAssignedDate = $escalatedRowDetailsAgainstPetitionno->assigned_date;
        log_message("error", "ASSIGNED_DATE=======" . $lastAssignedDate);
        $timeLineRow = $this->getTimeLine($service_code, 'ACOR');

        $doubleEntry = 0;
        if ($assigned_user_type == 'LM') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
            $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
            log_message("error", "previousCompletedDaysLM--------------" . $previousCompletedDaysLM);
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysLM, $originalAllocation);
            if ($remaining_days_other == null || $remaining_days_other == 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            $escalatedDate = $this->getEscalatedDate($remaining_days_other);

        } elseif ($assigned_user_type == 'CO') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO, $originalAllocation);
            if ($remaining_days_other == null || $remaining_days_other == 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            $escalatedDate = $this->getEscalatedDate($remaining_days_other);

        }

        $dateCode = $this->generateDateCode();
        log_message("error", "TYPE " . $user_type . " =====ESCALATED_DATE=======" . $escalatedDate);
        if ($user_type == 'CO') {
            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);
            $dateCodes = $escalatedRowDetailsAgainstPetitionno->co_date_code_list;

            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->co_completed_days;

            $co_target_days = $escalatedRowDetailsAgainstPetitionno->co_target_days;

            log_message("error", "========CO-TARGET_DAYS =======" . $co_target_days);

            $co_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);

            log_message("error", "========CO-COMPLETION_DAYS=======" . $co_completed_days);
            if ($co_target_days < $co_completed_days) {
                $escalate_status = 'Y';
            } else {
                $escalate_status = 'N';
            }
            log_message("error", "CO-ESCALATE_STATUS=======" . $escalate_status);
            $latestHistoryCode = $dateCodes;
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }
            $entryTimes = 0;
            $doubleEntry = 0;
            $assigned_other_date = null;
            $to_be_other_completed_within_days = null;
            $assigned_other_es_date = null;
            if ($assigned_to_other != null) {
                //this is designed for CO first proceding as assigned to LM and DA==========
                $entryTimes = 1;
                //////////

                $assigned_other_date = $executionDate;
                if ($assigned_to_other_type == 'LM') {

                    $originalAllocation = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
                    $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
                    $remaining_days_other = $this->getRemainingDays($previousCompletedDaysLM, $originalAllocation);
                    if ($remaining_days_other == null || $remaining_days_other == 0) {
                        $response['responseType'] = 0;
                        $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                        return $response;
                    }
                    $assigned_other_es_date = $this->getEscalatedDate($remaining_days_other);
                    $to_be_other_completed_within_days = $this->dateDiff($assigned_other_es_date, $executionDate);
                } elseif ($assigned_to_other_type == 'AST') {

                    $originalAllocation = $escalatedRowDetailsAgainstPetitionno->da_target_days;
                    $previousCompletedDaysDA = $escalatedRowDetailsAgainstPetitionno->da_completed_days;
                    $remaining_days_other = $this->getRemainingDays($previousCompletedDaysDA, $originalAllocation);
                    if ($remaining_days_other == null || $remaining_days_other == 0) {
                        $response['responseType'] = 0;
                        $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                        return $response;
                    }
                    $assigned_other_es_date = $this->getEscalatedDate($remaining_days_other);
                    $to_be_other_completed_within_days = $this->dateDiff($assigned_other_es_date, $executionDate);
                }

            }
            $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);

            $updateArray = array(
                'taskid' => $taskid,
                'co_completed_days' => (int) $co_completed_days + (int) $previousCompletedDays,
                'co_escalate_status' => $escalate_status,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_date' => $executionDate,
                'escalated_date' => $escalatedDate,
                'to_be_completed_within_days' => $to_be_completed_within_days,
                'co_date_code_list' => $dateCodes,
                'assignment_type' => $assignment_type,
                'assignment_type_other' => $assignment_type_other,
                'assigned_other' => $assigned_to_other,
                'assigned_other_code' => $assigned_other_code,
                'assigned_other_date' => $assigned_other_date,
                'assigned_other_es_date' => $assigned_other_es_date,
                'to_be_other_completed_within_days' => $to_be_other_completed_within_days,
            );

        }

        if ($user_type == 'LM') {

            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);

            $dateCodes = $escalatedRowDetailsAgainstPetitionno->lm_date_code_list;
            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
            $lm_target_days = $escalatedRowDetailsAgainstPetitionno->lm_target_days;

            log_message("error", "LM-TARGET_DAYS=======" . $lm_target_days);
            $lm_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);
            log_message("error", "LM-COMPLETION_DAYS=======" . $lm_completed_days);
            if ($lm_target_days < $lm_completed_days) {
                $escalate_status = 'Y';
            } else {
                $escalate_status = 'N';
            }
            log_message("error", "LM-ESCALATE_STATUS=======" . $escalate_status);
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }

            // //this calculation is for assigning CO from SK and taking hearing date as assigned date====
            // $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            // $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            // $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
            // // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            // $assigned_other_es_date = $this->getOtherEscalatedDate($remaining_days_other,$hearing_date);
            // $to_be_completed_within_days = $this->dateDiff($assigned_other_es_date,$hearing_date);
            // log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);
            // ///end==============

            $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);
            $updateArray = array(
                'taskid' => $taskid,
                'lm_completed_days' => (int) $lm_completed_days + (int) $previousCompletedDays,
                'lm_escalate_status' => $escalate_status,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_date' => $executionDate,
                'escalated_date' => $escalatedDate,
                'lm_date_code_list' => $dateCodes,
                'to_be_completed_within_days' => $to_be_completed_within_days,
            );

        }

        //UPDATE ESCALATION DATE HISTORY TABLE=====================

        $updateFlag = true;
        $history_id = $escalatedRowDetailsAgainstPetitionno->history_id;

        log_message("error", "UPDATED FLAG ==========" . $updateFlag);

        //STEPS to be followed:
        // 1. update escalation_dates_details against or history id
        // 2.update escalation_details with new date codes without history id
        // 3.insert history details and updated escalattion details with new history id

        $where_history = array(
            'petition_no' => $petition_no,
            'date_code' => $history_id,
            'service_code' => $service_code
        );
        $updateDatesArray = array(
            'completion_date' => $executionDate,
            'escalated_status' => $escalate_status,
            'completion_days' => $completion_days_for_history,
        );

        $updateStatus22 = $this->db->update('escalation_dates_details', $updateDatesArray, $where_history);
        log_message("error", "UPDt history escalation_dates_details TABLE=======" . $this->db->affected_rows());

        ///////////////END PROCESS//////////////////////////

        $where = array(
            'petition_no' => $petition_no,
        );
        if ($finalStatus == 'final') {
            unset($updateArray['assigned_to']);
            unset($updateArray['assigned_to_code']);
            unset($updateArray['assigned_from']);
            unset($updateArray['assigned_from_code']);
            unset($updateArray['assigned_date']);
            unset($updateArray['escalated_date']);
            unset($updateArray['to_be_completed_within_days']);

            $updateArray['assignment_type_other'] = null;
            $updateArray['assigned_other'] = null;
            $updateArray['assigned_other_code'] = null;
            $updateArray['assigned_other_date'] = null;
            $updateArray['assigned_other_es_date'] = null;
            $updateArray['to_be_other_completed_within_days'] = null;
            $updateArray['final_completion_date'] = $executionDate;
            $updateArray['status'] = 'F';

        }

        log_message('error', "FINAL UPDATED ARRAY===============" . json_encode($updateArray));
        $updateStatus1 = $this->db->update('escalation_details', $updateArray, $where);

        log_message("error", "ESCALATION DETAILS ENTRY TABLE=======" . $this->db->affected_rows());
        if ($this->db->affected_rows() <= 0) {
            $flag = 0;
        } else {
            $flag = 1;
        }

        if ($doubleEntry == 0 && $finalStatus == null) {

            $date_history = $this->generateDateCode();
            $insertDateArray = array(
                'sr_no' => $dateCode,
                'date_code' => $date_history,
                'petition_no' => $petition_no,
                'service_code' => $service_code,
                'taskid' => $taskid,
                'pending_officer' => $assigned_to,
                'assigned_user' => $user_code,
                'assigned_user_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'registerd_on' => $escalatedRowDetailsAgainstPetitionno->registerd_on,
                'allocation_date' => $executionDate,
                'target_completion_date' => $escalatedDate,
                'date_diff' => $this->dateDiff($escalatedDate, $executionDate),
                'escalated_status' => $escalate_status,
                'created_date' => date('Y-m-d H:i:s'),
                'updated_date' => date('Y-m-d H:i:s'),
            );

            log_message("error", "escalate_dates_status======" . json_encode($insertDateArray));
            $status = $this->db->insert('escalation_dates_details', $insertDateArray);
            if ($updateFlag == true) {
                $where_history_set = array(
                    'petition_no' => $petition_no,
                );
                $updateDatesArraySet = array(
                    'history_id' => $date_history,
                );
                $updateStatus22 = $this->db->update('escalation_details', $updateDatesArraySet, $where_history_set);
            }

        } else {
            $status = 1;
        }

        log_message("error", "ESCALATION DATE DETAILS ENTRY TABLE=======" . $status);
        //////////////////////END PROCESS////////////////////
        if ($status != 1) {
            $flag1 = 0;
        } else {
            $flag1 = 1;
        }
        if ($flag == 1 && $flag1 == 1) {
            return $flag;
        } else {
            return 0;
        }
    }

    public function escalationMatrixUpdateMCOR($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days)
    {

        $petition_no = $this->getPetitionNoMCOR($case_no);
        // WARNING BEFORE CODE=========================
        // $assigned_to_other_type may be notice or role name
        ///////////////////////////////////

        $escalatedRowDetailsAgainstPetitionno = $this->getEscalatedRowDetails($petition_no,$service_code);
        $assigned_other_code = $assigned_to_code = $assigned_from_code = null;
        $userCodeList = json_decode(USER_ALLOT_CODE);
        foreach ($userCodeList as $key => $value) {
            if ($value->USER == $user_type) {
                $assigned_from_code = $value->CODE;
            }
            if ($value->USER == $assigned_user_type) {
                $assigned_to_code = $value->CODE;
            }
            if ($value->USER == $assigned_to_other_type) {
                $assigned_other_code = $value->CODE;
            }
        }

        $lastAssignedDate = $escalatedRowDetailsAgainstPetitionno->assigned_date;
        log_message("error", "ASSIGNED_DATE=======" . $lastAssignedDate);
        $timeLineRow = $this->getTimeLine($service_code, 'MCOR');

        $doubleEntry = 0;
        if ($assigned_user_type == 'CO') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO, $originalAllocation);
            if ($remaining_days_other == null || $remaining_days_other == 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            $escalatedDate = $this->getEscalatedDate($remaining_days_other);

        }

        $dateCode = $this->generateDateCode();
        log_message("error", "TYPE " . $user_type . " =====ESCALATED_DATE=======" . $escalatedDate);
        if ($user_type == 'CO') {
            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);
            $dateCodes = $escalatedRowDetailsAgainstPetitionno->co_date_code_list;

            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->co_completed_days;

            $co_target_days = $escalatedRowDetailsAgainstPetitionno->co_target_days;

            log_message("error", "========CO-TARGET_DAYS =======" . $co_target_days);

            $co_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);

            log_message("error", "========CO-COMPLETION_DAYS=======" . $co_completed_days);
            if ($co_target_days < $co_completed_days) {
                $escalate_status = 'Y';
            } else {
                $escalate_status = 'N';
            }
            log_message("error", "CO-ESCALATE_STATUS=======" . $escalate_status);
            $latestHistoryCode = $dateCodes;
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }
            $entryTimes = 0;
            $doubleEntry = 0;
            $assigned_other_date = null;
            $to_be_other_completed_within_days = null;
            $assigned_other_es_date = null;

            $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);

            $updateArray = array(
                'taskid' => $taskid,
                'co_completed_days' => (int) $co_completed_days + (int) $previousCompletedDays,
                'co_escalate_status' => $escalate_status,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_date' => $executionDate,
                'escalated_date' => $escalatedDate,
                'to_be_completed_within_days' => $to_be_completed_within_days,
                'co_date_code_list' => $dateCodes,
                'assignment_type' => $assignment_type,
                'assignment_type_other' => $assignment_type_other,
                'assigned_other' => $assigned_to_other,
                'assigned_other_code' => $assigned_other_code,
                'assigned_other_date' => $assigned_other_date,
                'assigned_other_es_date' => $assigned_other_es_date,
                'to_be_other_completed_within_days' => $to_be_other_completed_within_days,
            );

        }

        //UPDATE ESCALATION DATE HISTORY TABLE=====================

        $updateFlag = true;
        $history_id = $escalatedRowDetailsAgainstPetitionno->history_id;

        log_message("error", "UPDATED FLAG ==========" . $updateFlag);

        //STEPS to be followed:
        // 1. update escalation_dates_details against or history id
        // 2.update escalation_details with new date codes without history id
        // 3.insert history details and updated escalattion details with new history id

        $where_history = array(
            'petition_no' => $petition_no,
            'date_code' => $history_id,
            'service_code' => $service_code
        );
        $updateDatesArray = array(
            'completion_date' => $executionDate,
            'escalated_status' => $escalate_status,
            'completion_days' => $completion_days_for_history,
        );

        $updateStatus22 = $this->db->update('escalation_dates_details', $updateDatesArray, $where_history);
        log_message("error", "UPDt history escalation_dates_details TABLE=======" . $this->db->affected_rows());

        ///////////////END PROCESS//////////////////////////

        $where = array(
            'petition_no' => $petition_no,
        );
        if ($finalStatus == 'final') {
            unset($updateArray['assigned_to']);
            unset($updateArray['assigned_to_code']);
            unset($updateArray['assigned_from']);
            unset($updateArray['assigned_from_code']);
            unset($updateArray['assigned_date']);
            unset($updateArray['escalated_date']);
            unset($updateArray['to_be_completed_within_days']);

            $updateArray['assignment_type_other'] = null;
            $updateArray['assigned_other'] = null;
            $updateArray['assigned_other_code'] = null;
            $updateArray['assigned_other_date'] = null;
            $updateArray['assigned_other_es_date'] = null;
            $updateArray['to_be_other_completed_within_days'] = null;
            $updateArray['final_completion_date'] = $executionDate;
            $updateArray['status'] = 'F';

        }

        log_message('error', "FINAL UPDATED ARRAY===============" . json_encode($updateArray));
        $updateStatus1 = $this->db->update('escalation_details', $updateArray, $where);

        log_message("error", "ESCALATION DETAILS ENTRY TABLE=======" . $this->db->affected_rows());
        if ($this->db->affected_rows() <= 0) {
            $flag = 0;
        } else {
            $flag = 1;
        }

        if ($doubleEntry == 0 && $finalStatus == null) {

            $date_history = $this->generateDateCode();
            $insertDateArray = array(
                'sr_no' => $dateCode,
                'date_code' => $date_history,
                'petition_no' => $petition_no,
                'service_code' => $service_code,
                'taskid' => $taskid,
                'pending_officer' => $assigned_to,
                'assigned_user' => $user_code,
                'assigned_user_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'registerd_on' => $escalatedRowDetailsAgainstPetitionno->registerd_on,
                'allocation_date' => $executionDate,
                'target_completion_date' => $escalatedDate,
                'date_diff' => $this->dateDiff($escalatedDate, $executionDate),
                'escalated_status' => $escalate_status,
                'created_date' => date('Y-m-d H:i:s'),
                'updated_date' => date('Y-m-d H:i:s'),
            );

            log_message("error", "escalate_dates_status======" . json_encode($insertDateArray));
            $status = $this->db->insert('escalation_dates_details', $insertDateArray);
            if ($updateFlag == true) {
                $where_history_set = array(
                    'petition_no' => $petition_no,
                );
                $updateDatesArraySet = array(
                    'history_id' => $date_history,
                );
                $updateStatus22 = $this->db->update('escalation_details', $updateDatesArraySet, $where_history_set);
            }

        } else {
            $status = 1;
        }

        log_message("error", "ESCALATION DATE DETAILS ENTRY TABLE=======" . $status);
        //////////////////////END PROCESS////////////////////
        if ($status != 1) {
            $flag1 = 0;
        } else {
            $flag1 = 1;
        }
        if ($flag == 1 && $flag1 == 1) {
            return $flag;
        } else {
            return 0;
        }
    }

    public function escalationMatrixUpdateReject($case_no, $executionDate, $user_code, $user_type, $service_code, $finalStatus, $taskid)
    {
        $petition_no = $this->getPetitionNoMCOR($case_no);

        $escalatedRowDetailsAgainstPetitionno = $this->getEscalatedRowDetails($petition_no,$service_code);
        $assigned_other_code = $assigned_to_code = $assigned_from_code = null;
        $userCodeList = json_decode(USER_ALLOT_CODE);
        foreach ($userCodeList as $key => $value) {
            if ($value->USER == $user_type) {
                $assigned_from_code = $value->CODE;
            }
            if ($value->USER == $assigned_user_type) {
                $assigned_to_code = $value->CODE;
            }
            if ($value->USER == $assigned_to_other_type) {
                $assigned_other_code = $value->CODE;
            }
        }

        $lastAssignedDate = $escalatedRowDetailsAgainstPetitionno->assigned_date;
        log_message("error", "ASSIGNED_DATE=======" . $lastAssignedDate);
        $timeLineRow = $this->getTimeLine($service_code, 'MCOR');

        $doubleEntry = 0;
        if ($assigned_user_type == 'CO') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO, $originalAllocation);
            if ($remaining_days_other == null || $remaining_days_other == 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            $escalatedDate = $this->getEscalatedDate($remaining_days_other);

        }

        $dateCode = $this->generateDateCode();
        log_message("error", "TYPE " . $user_type . " =====ESCALATED_DATE=======" . $escalatedDate);
        if ($user_type == 'CO') {

            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);
            $dateCodes = $escalatedRowDetailsAgainstPetitionno->co_date_code_list;

            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->co_completed_days;

            $co_target_days = $escalatedRowDetailsAgainstPetitionno->co_target_days;

            log_message("error", "========CO-TARGET_DAYS =======" . $co_target_days);

            $co_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);

            log_message("error", "========CO-COMPLETION_DAYS=======" . $co_completed_days);
            if ($co_target_days < $co_completed_days) {
                $escalate_status = 'Y';
            } else {
                $escalate_status = 'N';
            }
            log_message("error", "CO-ESCALATE_STATUS=======" . $escalate_status);
            $latestHistoryCode = $dateCodes;
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }
            $entryTimes = 0;
            $doubleEntry = 0;
            $assigned_other_date = null;
            $to_be_other_completed_within_days = null;
            $assigned_other_es_date = null;

            $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);

            $updateArray = array(
                'taskid' => $taskid,
                'co_completed_days' => (int) $co_completed_days + (int) $previousCompletedDays,
                'co_escalate_status' => $escalate_status,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_date' => $executionDate,
                'escalated_date' => $escalatedDate,
                'to_be_completed_within_days' => $to_be_completed_within_days,
                'co_date_code_list' => $dateCodes,
                'assignment_type' => $assignment_type,
                'assignment_type_other' => $assignment_type_other,
                'assigned_other' => $assigned_to_other,
                'assigned_other_code' => $assigned_other_code,
                'assigned_other_date' => $assigned_other_date,
                'assigned_other_es_date' => $assigned_other_es_date,
                'to_be_other_completed_within_days' => $to_be_other_completed_within_days,
            );

        }

        //UPDATE ESCALATION DATE HISTORY TABLE=====================

        $updateFlag = true;
        $history_id = $escalatedRowDetailsAgainstPetitionno->history_id;

        log_message("error", "UPDATED FLAG ==========" . $updateFlag);

        //STEPS to be followed:
        // 1. update escalation_dates_details against or history id
        // 2.update escalation_details with new date codes without history id
        // 3.insert history details and updated escalattion details with new history id

        $where_history = array(
            'petition_no' => $petition_no,
            'date_code' => $history_id,
            'service_code' => $service_code
        );
        $updateDatesArray = array(
            'completion_date' => $executionDate,
            'escalated_status' => $escalate_status,
            'completion_days' => $completion_days_for_history,
        );

        $updateStatus22 = $this->db->update('escalation_dates_details', $updateDatesArray, $where_history);
        log_message("error", "UPDt history escalation_dates_details TABLE=======" . $this->db->affected_rows());

        ///////////////END PROCESS//////////////////////////

        $where = array(
            'petition_no' => $petition_no,
        );
        if ($finalStatus == 'Reject') {
            unset($updateArray['assigned_to']);
            unset($updateArray['assigned_to_code']);
            unset($updateArray['assigned_from']);
            unset($updateArray['assigned_from_code']);
            unset($updateArray['assigned_date']);
            unset($updateArray['escalated_date']);
            unset($updateArray['to_be_completed_within_days']);

            $updateArray['assignment_type_other'] = null;
            $updateArray['assigned_other'] = null;
            $updateArray['assigned_other_code'] = null;
            $updateArray['assigned_other_date'] = null;
            $updateArray['assigned_other_es_date'] = null;
            $updateArray['to_be_other_completed_within_days'] = null;
            $updateArray['final_completion_date'] = $executionDate;
            $updateArray['status'] = 'R';

        }

        log_message('error', "FINAL UPDATED ARRAY===============" . json_encode($updateArray));
        $updateStatus1 = $this->db->update('escalation_details', $updateArray, $where);

        log_message("error", "ESCALATION DETAILS ENTRY TABLE=======" . $this->db->affected_rows());
        if ($this->db->affected_rows() <= 0) {
            $flag = 0;
        } else {
            $flag = 1;
        }
        return $flag;
    }

    public function escalationMatrixUpdateRejectMBService($case_no, $executionDate, $user_code, $user_type, $service_code, $finalStatus, $taskid, $petition_no)
    {

        $escalatedRowDetailsAgainstPetitionno = $this->getEscalatedRowDetails($petition_no,$service_code);
        $assigned_other_code = $assigned_to_code = $assigned_from_code = null;

        $lastAssignedDate = $escalatedRowDetailsAgainstPetitionno->assigned_date;

        if ($user_type == "CO") {

            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);
            $dateCodes = $escalatedRowDetailsAgainstPetitionno->co_date_code_list;

            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->co_completed_days;

            $co_target_days = $escalatedRowDetailsAgainstPetitionno->co_target_days;

            log_message("error", "========CO-TARGET_DAYS =======" . $co_target_days);

            $co_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);

            log_message("error", "========CO-COMPLETION_DAYS=======" . $co_completed_days);
            if ($co_target_days < $co_completed_days) {
                $escalate_status = 'Y';
            } else {
                $escalate_status = 'N';
            }
        }

        //UPDATE ESCALATION DATE HISTORY TABLE=====================

        $updateFlag = true;
        $history_id = $escalatedRowDetailsAgainstPetitionno->history_id;

        log_message("error", "UPDATED FLAG ==========" . $updateFlag);

        //STEPS to be followed:
        // 1. update escalation_dates_details against or history id
        // 2.update escalation_details with new date codes without history id
        // 3.insert history details and updated escalattion details with new history id

        $where_history = array(
            'petition_no' => $petition_no,
            'date_code' => $history_id,
            'service_code' => $service_code
        );
        $updateDatesArray = array(
            'completion_date' => $executionDate,
            'escalated_status' => $escalate_status,
            'completion_days' => $completion_days_for_history,
        );

        $updateStatus22 = $this->db->update('escalation_dates_details', $updateDatesArray, $where_history);
        log_message("error", "UPDt history escalation_dates_details TABLE=======" . $this->db->affected_rows());

        ///////////////END PROCESS//////////////////////////

        $where = array(
            'petition_no' => $petition_no,
        );
        $updateArray = array();
        if ($finalStatus == 'Reject') {

            // $updateArray['assignment_type_other'] = null;
            // $updateArray['assigned_other']     = null;
            // $updateArray['assigned_other_code'] = null;
            // $updateArray['assigned_other_date'] = null;
            // $updateArray['assigned_other_es_date'] = null;
            // $updateArray['to_be_other_completed_within_days'] = null;
            $updateArray['final_completion_date'] = $executionDate;
            $updateArray['status'] = 'R';

        }

        log_message('error', "FINAL UPDATED ARRAY===============" . json_encode($updateArray));
        $updateStatus1 = $this->db->update('escalation_details', $updateArray, $where);

        log_message("error", "ESCALATION DETAILS ENTRY TABLE=======" . $this->db->affected_rows());
        if ($this->db->affected_rows() <= 0) {
            $flag = 0;
        } else {
            $flag = 1;
        }
        return $flag;
    }

    public function escalationMatrixUpdateRECLASS($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days)
    {
        $executionDate = date('Y-m-d H:i:s');
        $response = array('responseType' => 1, 'msg' => null);
        $petition_no = $this->getPetitionNoRECLASS($case_no);
        if ($petition_no == null || $petition_no == '') {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION2461 : Petition No not found';
            return $response;
        }
        // WARNING BEFORE CODE=========================
        // $assigned_to_other_type may be notice or role name
        ///////////////////////////////////

        $doubleEntry = 0;

        $escalatedRowDetailsAgainstPetitionno = $this->getEscalatedRowDetails($petition_no,$service_code);
        if (empty($escalatedRowDetailsAgainstPetitionno) || $escalatedRowDetailsAgainstPetitionno == null) {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION2474 : Escalation Matrix Row Not Updated';
            return $response;
        }

        // log_message('error',"getEscalatedRowDetails=========".json_encode($escalatedRowDetailsAgainstPetitionno));

        $assigned_other_code = $assigned_to_code = $assigned_from_code = null;
        $userCodeList = json_decode(USER_ALLOT_CODE);
        foreach ($userCodeList as $key => $value) {
            if ($value->USER == $user_type) {
                $assigned_from_code = $value->CODE;
            }
            if ($value->USER == $assigned_user_type) {
                $assigned_to_code = $value->CODE;
            }
            if ($value->USER == $assigned_to_other_type) {
                $assigned_other_code = $value->CODE;
            }
        }

        $lastAssignedDate = $escalatedRowDetailsAgainstPetitionno->assigned_date;
        $lastEscalatedDate = $escalatedRowDetailsAgainstPetitionno->escalated_date;
        if ($user_type == 'AST') {
            $lastEscalatedDate = $escalatedRowDetailsAgainstPetitionno->assigned_other_es_date;
        }
        $validateExecutionDateTime = $this->checkCaseExecutionOnTimeOrNot($executionDate, $lastAssignedDate, $lastEscalatedDate);
        if ($validateExecutionDateTime == 'n') {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION2651 : Case Execution not on time';
            return $response;
        }
        // log_message("error","ASSIGNED_DATE=======".$lastAssignedDate);
        $timeLineRow = $this->getTimeLine($service_code, 'RECLASS');
        if (empty($timeLineRow) || $timeLineRow == null) {
            log_message('#ERRESCLATION2502 : Escalation Timeline Not Updated');
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION2502 : Escalation Timeline Not Updated';
            return $response;
        }

        if ($assigned_user_type == 'LM') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
            $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
            log_message("error", "previousCompletedDaysLM--------------" . $previousCompletedDaysLM);
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysLM, $originalAllocation);
            if ($remaining_days_other < 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);

        } elseif ($assigned_user_type == 'CO') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO, $originalAllocation);
            if ($remaining_days_other < 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);

        } elseif ($assigned_user_type == 'ADC') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->adc_target_days;
            $previousCompletedDaysADC = $escalatedRowDetailsAgainstPetitionno->adc_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysADC, $originalAllocation);
            if ($remaining_days_other < 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);
        } elseif ($assigned_user_type == 'DC') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->dc_target_days;
            $previousCompletedDaysDC = $escalatedRowDetailsAgainstPetitionno->dc_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysDC, $originalAllocation);
            if ($remaining_days_other < 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);
        }

        $dateCode = $this->generateDateCode();
        // log_message("error","TYPE ".$user_type." =====ESCALATED_DATE=======".$escalatedDate);

        if ($user_type == 'ADC') {
            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);
            $dateCodes = $escalatedRowDetailsAgainstPetitionno->adc_date_code_list;

            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->adc_completed_days;

            $adc_target_days = $escalatedRowDetailsAgainstPetitionno->adc_target_days;

            // log_message("error","========ADC-TARGET_DAYS =======".$adc_target_days);

            $adc_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);

            // log_message("error","========ADC-COMPLETION_DAYS=======".$adc_completed_days);
            // if ($adc_target_days < $adc_completed_days) {
            //     $escalate_status = 'Y';
            // } else {
                $escalate_status = 'N';
            // }
            // log_message("error","ADC-ESCALATE_STATUS=======".$escalate_status);
            $latestHistoryCode = $dateCodes;
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }
            $entryTimes = 0;
            $doubleEntry = 0;
            $assigned_other_date = null;
            $to_be_other_completed_within_days = null;
            $assigned_other_es_date = null;

            $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);

            $updateArray = array(
                'taskid' => $taskid,
                'adc_completed_days' => (int) $adc_completed_days + (int) $previousCompletedDays,
                'adc_escalate_status' => $escalate_status,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_date' => $executionDate,
                'escalated_date' => $escalatedDate,
                'to_be_completed_within_days' => $to_be_completed_within_days,
                'adc_date_code_list' => $dateCodes,
            );

        }

        if ($user_type == 'CO') {
            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);
            $dateCodes = $escalatedRowDetailsAgainstPetitionno->co_date_code_list;

            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->co_completed_days;

            $co_target_days = $escalatedRowDetailsAgainstPetitionno->co_target_days;

            // log_message("error","========CO-TARGET_DAYS =======".$co_target_days);

            $co_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);

            // log_message("error","========CO-COMPLETION_DAYS=======".$co_completed_days);
            // if ($co_target_days < $co_completed_days) {
            //     $escalate_status = 'Y';
            // } else {
                $escalate_status = 'N';
            // }
            // log_message("error","CO-ESCALATE_STATUS=======".$escalate_status);
            $latestHistoryCode = $dateCodes;
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }
            $entryTimes = 0;
            $doubleEntry = 0;
            $assigned_other_date = null;
            $to_be_other_completed_within_days = null;
            $assigned_other_es_date = null;

            $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);

            $updateArray = array(
                'taskid' => $taskid,
                'co_completed_days' => (int) $co_completed_days + (int) $previousCompletedDays,
                'co_escalate_status' => $escalate_status,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_date' => $executionDate,
                'escalated_date' => $escalatedDate,
                'to_be_completed_within_days' => $to_be_completed_within_days,
                'co_date_code_list' => $dateCodes,
            );

        }

        if ($user_type == 'LM') {

            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);

            $dateCodes = $escalatedRowDetailsAgainstPetitionno->lm_date_code_list;
            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
            $lm_target_days = $escalatedRowDetailsAgainstPetitionno->lm_target_days;

            // log_message("error","LM-TARGET_DAYS=======".$lm_target_days);
            $lm_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);
            // log_message("error","LM-COMPLETION_DAYS=======".$lm_completed_days);
            // if ($lm_target_days < $lm_completed_days) {
            //     $escalate_status = 'Y';
            // } else {
                $escalate_status = 'N';
            // }
            // log_message("error","LM-ESCALATE_STATUS=======".$escalate_status);
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }

            // if($assigned_to_other_type == 'LMRevert'){
            //   //this calculation is for assigning CO from LM and taking hearing date as assigned date AS REVERT CASE====
            //   $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            //   $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            //   $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
            //   $assigned_other_es_date = $this->getOtherEscalatedDate($remaining_days_other,$hearing_date);
            //   $to_be_completed_within_days = $this->dateDiff($assigned_other_es_date,$hearing_date);
            //   log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);
            //   $executionDate = $hearing_date;
            //   $escalatedDate = $assigned_other_es_date;
            // }
            $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);
            $updateArray = array(
                'taskid' => $taskid,
                'lm_completed_days' => (int) $lm_completed_days + (int) $previousCompletedDays,
                'lm_escalate_status' => $escalate_status,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_date' => $executionDate,
                'escalated_date' => $escalatedDate,
                'lm_date_code_list' => $dateCodes,
                'to_be_completed_within_days' => $to_be_completed_within_days,
            );

        }

        if ($user_type == 'DC') {

            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);

            $dateCodes = $escalatedRowDetailsAgainstPetitionno->dc_date_code_list;
            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->dc_completed_days;
            $dc_target_days = $escalatedRowDetailsAgainstPetitionno->dc_target_days;

            // log_message("error","DC-TARGET_DAYS=======".$dc_target_days);
            $dc_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);
            // log_message("error","DC-COMPLETION_DAYS=======".$dc_completed_days);
            // if ($dc_target_days < $dc_completed_days) {
            //     $escalate_status = 'Y';
            // } else {
                $escalate_status = 'N';
            // }
            // log_message("error","DC-ESCALATE_STATUS=======".$escalate_status);
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }

            // if($assigned_to_other_type == 'LMRevert'){
            //   //this calculation is for assigning CO from LM and taking hearing date as assigned date AS REVERT CASE====
            //   $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            //   $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            //   $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
            //   $assigned_other_es_date = $this->getOtherEscalatedDate($remaining_days_other,$hearing_date);
            //   $to_be_completed_within_days = $this->dateDiff($assigned_other_es_date,$hearing_date);
            //   log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);
            //   $executionDate = $hearing_date;
            //   $escalatedDate = $assigned_other_es_date;
            // }
            $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);
            $updateArray = array(
                'taskid' => $taskid,
                'dc_completed_days' => (int) $dc_completed_days + (int) $previousCompletedDays,
                'dc_escalate_status' => $escalate_status,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_date' => $executionDate,
                'escalated_date' => $escalatedDate,
                'dc_date_code_list' => $dateCodes,
                'to_be_completed_within_days' => $to_be_completed_within_days,
            );

        }

        //UPDATE ESCALATION DATE HISTORY TABLE=====================

        // $updateFlag =true;
        // if($assigned_to_other_type == 'Notice' || $assigned_to_other_type == 'Action'){
        //     $updateFlag = false;
        //     $history_id = $escalatedRowDetailsAgainstPetitionno->history_id_others;
        // }else{
        $updateFlag = true;
        $history_id = $escalatedRowDetailsAgainstPetitionno->history_id;
        // }

        // log_message("error","UPDATED FLAG ==========".$updateFlag);

        //STEPS to be followed:
        // 1. update escalation_dates_details against or history id
        // 2.update escalation_details with new date codes without history id
        // 3.insert history details and updated escalattion details with new history id

        $where_history = array(
            'petition_no' => $petition_no,
            'date_code' => $history_id,
            'service_code' => $service_code,
        );
        $updateDatesArray = array(
            'completion_date' => $executionDate,
            'escalated_status' => $escalate_status,
            'completion_days' => $completion_days_for_history,
        );

        $updateStatus22 = $this->db->update('escalation_dates_details', $updateDatesArray, $where_history);
        // log_message("error","UPDt history escalation_dates_details TABLE=======".$this->db->affected_rows());
        if ($this->db->affected_rows() <= 0) {
            log_message('error', '#ERRESCLATION2782 : Updation failed on escalation_dates_details' . $this->db->last_query());
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION2782 : Updation failed on escalation_dates_details';
            return $response;
        }

        ///////////////END PROCESS//////////////////////////

        $where = array(
            'petition_no' => $petition_no,
            'case_no'     => $case_no
        );

        // old01082023
        // if($finalStatus == 'final'){

        //   $updateArray['final_completion_date']= $executionDate;
        //   $updateArray['status']= 'F';

        // }
        if ($finalStatus == 'final') {
            unset($updateArray['assigned_to']);
            unset($updateArray['assigned_to_code']);
            unset($updateArray['assigned_from']);
            unset($updateArray['assigned_from_code']);
            unset($updateArray['assigned_date']);
            unset($updateArray['escalated_date']);
            unset($updateArray['to_be_completed_within_days']);
            unset($updateArray['dc_date_code_list']);

            $updateArray['assignment_type_other'] = null;
            $updateArray['assigned_other'] = null;
            $updateArray['assigned_other_code'] = null;
            $updateArray['assigned_other_date'] = null;
            $updateArray['assigned_other_es_date'] = null;
            $updateArray['to_be_other_completed_within_days'] = null;
            $updateArray['final_completion_date'] = $executionDate;
            $updateArray['status'] = 'F';

        }

        // log_message('error',"FINAL UPDATED ARRAY===============".json_encode($updateArray));
        $updateStatus1 = $this->db->update('escalation_details', $updateArray, $where);

        // log_message("error","ESCALATION DETAILS ENTRY TABLE=======".$this->db->affected_rows());
        // if($this->db->affected_rows() <= 0){
        //    $flag = 0;
        // }else{
        //    $flag = 1;
        // }
        if ($this->db->affected_rows() <= 0) {
            log_message('error', '#ERRESCLATION2834 : Updation failed on escalation_details=' . $this->db->last_query());
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION2834 : Updation failed on escalation_details';
            return $response;
        }

        if ($doubleEntry == 0 && $finalStatus == null) {
            $action_type = json_decode(ASSIGNMENT_TYPE);
            $action_type = $action_type[0]->CODE;
            if ($escalate_status == 'Y') {
                $action_type = $action_type[1]->CODE;
            }

            $date_history = $this->generateDateCode();
            $insertDateArray = array(
                'sr_no' => $dateCode,
                'date_code' => $date_history,
                'petition_no' => $petition_no,
                'service_code' => $service_code,
                'taskid' => $taskid,
                'action_type' => $action_type,
                'pending_officer' => $assigned_to,
                'assigned_user' => $user_code,
                'assigned_user_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'registerd_on' => $escalatedRowDetailsAgainstPetitionno->registerd_on,
                'allocation_date' => $executionDate,
                'target_completion_date' => $escalatedDate,
                'date_diff' => $this->dateDiff($escalatedDate, $executionDate),
                'escalated_status' => $escalate_status,
                'created_date' => date('Y-m-d H:i:s'),
                'updated_date' => date('Y-m-d H:i:s'),
                'case_no'      => $case_no,
            );

            // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
            $status = $this->db->insert('escalation_dates_details', $insertDateArray);
            if ($status != 1) {
                log_message('error', '#ERRESCLATION2869 : Insertion failed on escalation_dates_details=' . $this->db->last_query());
                $response['responseType'] = 0;
                $response['msg'] = '#ERRESCLATION2869 : Insertion failed on escalation_dates_details';
                return $response;
            }

            if ($updateFlag == true) {
                $where_history_set = array(
                    'petition_no' => $petition_no,
                    'case_no'     => $case_no
                );
                $updateDatesArraySet = array(
                    'history_id' => $date_history,
                );
                $updateStatus22 = $this->db->update('escalation_details', $updateDatesArraySet, $where_history_set);
                if ($this->db->affected_rows() <= 0) {
                    log_message('error', '#ERRESCLATION2886 : Updation failed on escalation_details=' . $this->db->last_query());
                    $response['responseType'] = 0;
                    $response['msg'] = '#ERRESCLATION2886 : Updation failed on escalation_details';
                    return $response;
                }
            }

        }
        return $response;

        // log_message("error","ESCALATION DATE DETAILS ENTRY TABLE=======".$status);
        // //////////////////////END PROCESS////////////////////
        // if($status !=1){
        //   $flag1 = 0;
        // }else{
        //   $flag1 = 1;
        // }
        // if($flag==1 && $flag1 == 1){
        //   return $flag;
        // }else{
        //   return 0;
        // }
    }

    public function escalationMatrixUpdateFPART($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days)
    {
        $executionDate = date('Y-m-d H:i:s');
        $response = array('responseType' => 1, 'msg' => null);
        $petition_no = $this->getPetitionNo($case_no, $service_code, 'FPART');
        if ($petition_no == null || $petition_no == '') {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION2856 : Petition No not found';
            return $response;
        }
        // WARNING BEFORE CODE=========================
        // $assigned_to_other_type may be notice or role name
        ///////////////////////////////////

        $doubleEntry = 0;

        $escalatedRowDetailsAgainstPetitionno = $this->getEscalatedRowDetails($petition_no,$service_code);
        if (empty($escalatedRowDetailsAgainstPetitionno) || $escalatedRowDetailsAgainstPetitionno == null) {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION2868 : Escalation Matrix Row Not Updated';
            return $response;
        }

        // log_message('error',"getEscalatedRowDetails=========".json_encode($escalatedRowDetailsAgainstPetitionno));

        $assigned_other_code = $assigned_to_code = $assigned_from_code = null;
        $userCodeList = json_decode(USER_ALLOT_CODE);
        foreach ($userCodeList as $key => $value) {
            if ($value->USER == $user_type) {
                $assigned_from_code = $value->CODE;
            }
            if ($value->USER == $assigned_user_type) {
                $assigned_to_code = $value->CODE;
            }
            if ($value->USER == $assigned_to_other_type) {
                $assigned_other_code = $value->CODE;
            }
        }

        $lastAssignedDate = $escalatedRowDetailsAgainstPetitionno->assigned_date;
        $lastEscalatedDate = $escalatedRowDetailsAgainstPetitionno->escalated_date;
        if ($user_type == 'AST') {
            $lastEscalatedDate = $escalatedRowDetailsAgainstPetitionno->assigned_other_es_date;
        }
        $validateExecutionDateTime = $this->checkCaseExecutionOnTimeOrNot($executionDate, $lastAssignedDate, $lastEscalatedDate);
        if ($validateExecutionDateTime == 'n') {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION3124 : Case Execution not on time';
            return $response;
        }

        // log_message("error","ASSIGNED_DATE=======".$lastAssignedDate);
        $timeLineRow = $this->getTimeLine($service_code, 'FPART');
        if (empty($timeLineRow) || $timeLineRow == null) {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION2894 : Escalation Timeline Not Updated';
            return $response;
        }

        if ($assigned_user_type == 'LM') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
            $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
            // log_message("error","previousCompletedDaysLM--------------".$previousCompletedDaysLM);
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysLM, $originalAllocation);
            if ($remaining_days_other < 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);

        } elseif ($assigned_user_type == 'SK') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->sk_target_days;
            $previousCompletedDaysSK = $escalatedRowDetailsAgainstPetitionno->sk_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysSK, $originalAllocation);
            if ($remaining_days_other < 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);
            // $escalatedDate = $this->getOtherEscalatedDate($remaining_days_other,$hearing_date);

        } elseif ($assigned_user_type == 'CO') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO, $originalAllocation);
            if ($remaining_days_other < 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);

        }

        $dateCode = $this->generateDateCode();
        // log_message("error","TYPE ".$user_type." =====ESCALATED_DATE=======".$escalatedDate);
        if ($user_type == 'CO') {
            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);
            $dateCodes = $escalatedRowDetailsAgainstPetitionno->co_date_code_list;

            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->co_completed_days;

            $co_target_days = $escalatedRowDetailsAgainstPetitionno->co_target_days;

            // log_message("error","========CO-TARGET_DAYS =======".$co_target_days);

            $co_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);

            // log_message("error","========CO-COMPLETION_DAYS=======".$co_completed_days);
            // if ($co_target_days < $co_completed_days) {
            //     $escalate_status = 'Y';
            // } else {
                $escalate_status = 'N';
            // }
            // log_message("error","CO-ESCALATE_STATUS=======".$escalate_status);
            $latestHistoryCode = $dateCodes;
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }
            $entryTimes = 0;
            $doubleEntry = 0;
            $assigned_other_date = null;
            $to_be_other_completed_within_days = null;
            $assigned_other_es_date = null;

            $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);

            $updateArray = array(
                'taskid' => $taskid,
                'co_completed_days' => (int) $co_completed_days + (int) $previousCompletedDays,
                'co_escalate_status' => $escalate_status,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_date' => $executionDate,
                'escalated_date' => $escalatedDate,
                'to_be_completed_within_days' => $to_be_completed_within_days,
                'co_date_code_list' => $dateCodes,
            );

        }

        if ($user_type == 'SK') {
            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);

            $dateCodes = $escalatedRowDetailsAgainstPetitionno->sk_date_code_list;
            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->sk_completed_days;
            $sk_target_days = $escalatedRowDetailsAgainstPetitionno->sk_target_days;
            // log_message("error","SK-TARGET_DAYS=======".$sk_target_days);
            $sk_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);
            // log_message("error","SK-COMPLETION_DAYS=======".$sk_completed_days);
            // if ($sk_target_days < $sk_completed_days) {
            //     $escalate_status = 'Y';
            // } else {
                $escalate_status = 'N';
            // }
            // log_message("error","SK-ESCALATE_STATUS=======".$escalate_status);
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }

            //this calculation is for assigning CO from SK and taking hearing date as assigned date====
            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO, $originalAllocation);
            if ($remaining_days_other == null || $remaining_days_other < 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $assigned_other_es_date = $this->getOtherEscalatedDate($remaining_days_other, $hearing_date);
            $to_be_completed_within_days = $this->dateDiff($assigned_other_es_date, $hearing_date);
            // log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);
            ///end==============

            $updateArray = array(
                'taskid' => $taskid,
                'sk_completed_days' => (int) $sk_completed_days + (int) $previousCompletedDays,
                'sk_escalate_status' => $escalate_status,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                // 'assigned_date'      => $executionDate,
                'assigned_date' => $hearing_date,
                'escalated_date' => $assigned_other_es_date,
                'sk_date_code_list' => $dateCodes,
                'to_be_completed_within_days' => $to_be_completed_within_days,
            );

            // log_message("error","CO==============SK".json_encode($updateArray));

        }

        if ($user_type == 'LM') {

            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);

            $dateCodes = $escalatedRowDetailsAgainstPetitionno->lm_date_code_list;
            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
            $lm_target_days = $escalatedRowDetailsAgainstPetitionno->lm_target_days;

            // log_message("error","LM-TARGET_DAYS=======".$lm_target_days);
            $lm_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);
            // log_message("error","LM-COMPLETION_DAYS=======".$lm_completed_days);
            // if ($lm_target_days < $lm_completed_days) {
            //     $escalate_status = 'Y';
            // } else {
                $escalate_status = 'N';
            // }
            // log_message("error","LM-ESCALATE_STATUS=======".$escalate_status);
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }

            // if($assigned_to_other_type == 'LMRevert'){
            //   //this calculation is for assigning CO from LM and taking hearing date as assigned date AS REVERT CASE====
            //   $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            //   $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            //   $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
            //   $assigned_other_es_date = $this->getOtherEscalatedDate($remaining_days_other,$hearing_date);
            //   $to_be_completed_within_days = $this->dateDiff($assigned_other_es_date,$hearing_date);
            //   log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);
            //   $executionDate = $hearing_date;
            //   $escalatedDate = $assigned_other_es_date;
            // }
            $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);
            $updateArray = array(
                'taskid' => $taskid,
                'lm_completed_days' => (int) $lm_completed_days + (int) $previousCompletedDays,
                'lm_escalate_status' => $escalate_status,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_date' => $executionDate,
                'escalated_date' => $escalatedDate,
                'lm_date_code_list' => $dateCodes,
                'to_be_completed_within_days' => $to_be_completed_within_days,
            );

        }

        //UPDATE ESCALATION DATE HISTORY TABLE=====================

        // $updateFlag =true;
        // if($assigned_to_other_type == 'Notice' || $assigned_to_other_type == 'Action'){
        //     $updateFlag = false;
        //     $history_id = $escalatedRowDetailsAgainstPetitionno->history_id_others;
        // }else{
        $updateFlag = true;
        $history_id = $escalatedRowDetailsAgainstPetitionno->history_id;
        // }

        // log_message("error","UPDATED FLAG ==========".$updateFlag);

        //STEPS to be followed:
        // 1. update escalation_dates_details against or history id
        // 2.update escalation_details with new date codes without history id
        // 3.insert history details and updated escalattion details with new history id

        $where_history = array(
            'petition_no' => $petition_no,
            'date_code' => $history_id,
            'service_code' => $service_code,
        );
        $updateDatesArray = array(
            'completion_date' => $executionDate,
            'escalated_status' => $escalate_status,
            'completion_days' => $completion_days_for_history,
        );

        $updateStatus22 = $this->db->update('escalation_dates_details', $updateDatesArray, $where_history);
        log_message("error","UPDt history escalation_dates_details TABLE=======".$this->db->last_query());
        if ($this->db->affected_rows() <= 0) {
            log_message("error", "#ERRESCLATION3116 : UPDt history escalation_dates_details TABLE=======" . $this->db->affected_rows());
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION3116 : Update Failed on escalation';
            return $response;
        }

        ///////////////END PROCESS//////////////////////////

        $where = array(
            'petition_no' => $petition_no,
            'case_no'     => $case_no
        );

        // old01082023
        // if($finalStatus == 'final'){

        //   $updateArray['final_completion_date']= $executionDate;
        //   $updateArray['status']= 'F';

        // }
        if ($finalStatus == 'final') {
            unset($updateArray['assigned_to']);
            unset($updateArray['assigned_to_code']);
            unset($updateArray['assigned_from']);
            unset($updateArray['assigned_from_code']);
            unset($updateArray['assigned_date']);
            unset($updateArray['escalated_date']);
            unset($updateArray['to_be_completed_within_days']);
            unset($updateArray['co_date_code_list']);

            $updateArray['assignment_type_other'] = null;
            $updateArray['assigned_other'] = null;
            $updateArray['assigned_other_code'] = null;
            $updateArray['assigned_other_date'] = null;
            $updateArray['assigned_other_es_date'] = null;
            $updateArray['to_be_other_completed_within_days'] = null;
            $updateArray['final_completion_date'] = $executionDate;
            $updateArray['status'] = 'F';

        }

        // log_message('error',"FINAL UPDATED ARRAY===============".json_encode($updateArray));
        $updateStatus1 = $this->db->update('escalation_details', $updateArray, $where);

        // log_message("error","ESCALATION DETAILS ENTRY TABLE=======".$this->db->affected_rows());
        // if($this->db->affected_rows() <= 0){
        //    $flag = 0;
        // }else{
        //    $flag = 1;
        // }
        if ($this->db->affected_rows() <= 0) {
            log_message("error", "#ERRESCLATION3167 : Update Failed on escalation_details Failed=======" . $this->db->last_query());
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION3167 : Update Failed on escalation_details Failed';
            return $response;
        }

        if ($doubleEntry == 0 && $finalStatus == null) {
            // if($assigned_to_other_type == 'Notice' || $assigned_to_other_type == 'SKReport'){
            //   $executionDate = $hearing_date;
            //   $escalatedDate = $assigned_other_es_date;
            // }

            $action_type = json_decode(ASSIGNMENT_TYPE);
            $action_type = $action_type[1]->CODE;
            if ($escalate_status == 'Y') {
                $action_type = $action_type[1]->CODE;
            }

            $date_history = $this->generateDateCode();
            $insertDateArray = array(
                'sr_no' => $dateCode,
                'date_code' => $date_history,
                'petition_no' => $petition_no,
                'service_code' => $service_code,
                'taskid' => $taskid,
                'action_type' => $action_type,
                'pending_officer' => $assigned_to,
                'assigned_user' => $user_code,
                'assigned_user_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'registerd_on' => $escalatedRowDetailsAgainstPetitionno->registerd_on,
                'allocation_date' => $executionDate,
                'target_completion_date' => $escalatedDate,
                'date_diff' => $this->dateDiff($escalatedDate, $executionDate),
                'escalated_status' => $escalate_status,
                'created_date' => date('Y-m-d H:i:s'),
                'updated_date' => date('Y-m-d H:i:s'),
                'case_no'      => $case_no,
            );
            // if($finalStatus == 'final'){
            //   $insertDateArray['completion_date'] = $executionDate;
            // }
            // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
            $status = $this->db->insert('escalation_dates_details', $insertDateArray);
            if ($status != 1) {
                log_message("error", "#ERRESCLATION3206 : Insert Failed on escalation_dates_details Failed=======" . $this->db->last_query());
                $response['responseType'] = 0;
                $response['msg'] = '#ERRESCLATION3206 : Insert Failed on escalation_dates_details Failed';
                return $response;
            }
            if ($updateFlag == true) {
                $where_history_set = array(
                    'petition_no' => $petition_no,
                    'case_no'     => $case_no,
                );
                $updateDatesArraySet = array(
                    'history_id' => $date_history,
                );
                $updateStatus22 = $this->db->update('escalation_details', $updateDatesArraySet, $where_history_set);
                if ($this->db->affected_rows() <= 0) {
                    log_message("error", "#ERRESCLATION3221 : Update Failed on escalation_details Failed=======" . $this->db->last_query());
                    $response['responseType'] = 0;
                    $response['msg'] = '#ERRESCLATION3221 : Update Failed on escalation_details Failed';
                    return $response;
                }
            }

        }

        return $response;

        // log_message("error","ESCALATION DATE DETAILS ENTRY TABLE=======".$status);
        // //////////////////////END PROCESS////////////////////
        // if($status !=1){
        //   $flag1 = 0;
        // }else{
        //   $flag1 = 1;
        // }
        // if($flag==1 && $flag1 == 1){
        //   return $flag;
        // }else{
        //   return 0;
        // }
    }

    public function escalationMatrixUpdateOPART($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days)
    {
        if($user_type == 'LM')
        {
            $executionDate = $executionDate;
        }
        else
        {
            $executionDate = date('Y-m-d H:i:s');
        }
        $current_date = date('Y-m-d H:i:s');
        
        // log_message("error",'#876=============='.json_encode($case_no.$executionDate.$user_code.$user_type.$service_code.$assigned_to.$assigned_user_type.$finalStatus.$assigned_to_other.$assigned_to_other_type.$hearing_date.$taskid.$assignment_type.$assignment_type_other.$allocation_days));

        $response = array('responseType' => 1,'msg' => null);
        $petition_no = $this->getPetitionNoOMUT($case_no);
        if ($petition_no == null || $petition_no == '') {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION3281 : Petition no not found';
            return $response;
        }
        // WARNING BEFORE CODE=========================
        // $assigned_to_other_type may be notice or role name
        ///////////////////////////////////
        // var_dump($service_code);
        $escalatedRowDetailsAgainstPetitionno = $this->getEscalatedRowDetails($petition_no,$service_code);
        // var_dump($escalatedRowDetailsAgainstPetitionno)
        if (empty($escalatedRowDetailsAgainstPetitionno) && $escalatedRowDetailsAgainstPetitionno == null) {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION32812 : Petition no not found';
            return $response;
        }
        $assigned_other_code = $assigned_to_code = $assigned_from_code = null;
        $userCodeList = json_decode(USER_ALLOT_CODE);
        foreach ($userCodeList as $key => $value) {
            if ($value->USER == $user_type) {
                $assigned_from_code = $value->CODE;
            }
            if ($value->USER == $assigned_user_type) {
                $assigned_to_code = $value->CODE;
            }
            if ($value->USER == $assigned_to_other_type) {
                $assigned_other_code = $value->CODE;
            }
        }

        $lastAssignedDate = $escalatedRowDetailsAgainstPetitionno->assigned_date;
        $lastEscalatedDate = $escalatedRowDetailsAgainstPetitionno->escalated_date;
        if ($user_type == 'AST') 
        {
            $lastEscalatedDate = $escalatedRowDetailsAgainstPetitionno->assigned_other_es_date;
            if($lastEscalatedDate == null && $assigned_to_other_type == 'Notice')
            {
                log_message('error','#ERROR3590 : Case is already action taken');
                return $response;
            }
        }


        if($assigned_to_other_type != "Action")
        {
            $validateExecutionDateTime = $this->checkCaseExecutionOnTimeOrNot($current_date, $lastAssignedDate, $lastEscalatedDate);
            if ($validateExecutionDateTime == 'n') {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRESCLATION3548 : Case Execution not on time';
                return $response;
            }
        }


        // log_message("error","ASSIGNED_DATE=======".$lastAssignedDate);
        $timeLineRow = $this->getTimeLine($escalatedRowDetailsAgainstPetitionno->service_code, 'OPART');
        if (empty($timeLineRow) && $timeLineRow == null) {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION32813 : Timeline for Escalation not found';
            return $response;
        }

        if ($assigned_user_type == 'AST') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->da_target_days;
            $previousCompletedDaysDA = $escalatedRowDetailsAgainstPetitionno->da_completed_days;

            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysDA, $originalAllocation);
            if ($remaining_days_other < 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281OPART1 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDateNew($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $hearing_date);

        } elseif ($assigned_user_type == 'LM') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
            $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
            log_message("error", "previousCompletedDaysLM--------------" . $previousCompletedDaysLM);
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysLM, $originalAllocation);
            if ($remaining_days_other < 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281OPART2 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);

        } elseif ($assigned_user_type == 'SK') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->sk_target_days;
            $previousCompletedDaysSK = $escalatedRowDetailsAgainstPetitionno->sk_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysSK, $originalAllocation);
            if ($remaining_days_other < 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281OPART3 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);
            // $escalatedDate = $this->getOtherEscalatedDate($remaining_days_other,$hearing_date);

        } elseif ($assigned_user_type == 'CO') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO, $originalAllocation);
            if ($remaining_days_other < 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281OPART4 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);

        }
        $entryTimes = 0;
        $doubleEntry = 0;
        $dateCode = $this->generateDateCode();
        // log_message("error","TYPE ".$user_type." =====ESCALATED_DATE=======".$escalatedDate);
        if ($user_type == 'CO') {
            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);
            $dateCodes = $escalatedRowDetailsAgainstPetitionno->co_date_code_list;

            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->co_completed_days;

            $co_target_days = $escalatedRowDetailsAgainstPetitionno->co_target_days;

            // log_message("error","========CO-TARGET_DAYS =======".$co_target_days);

            $co_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);

            // log_message("error","========CO-COMPLETION_DAYS=======".$co_completed_days);
            // if ($co_target_days < $co_completed_days) {
            //     $escalate_status = 'Y';
            // } else {
                $escalate_status = 'N';
            // }
            // log_message("error","CO-ESCALATE_STATUS=======".$escalate_status);
            $latestHistoryCode = $dateCodes;
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }
            $entryTimes = 0;
            $doubleEntry = 0;
            $assigned_other_date = null;
            $to_be_other_completed_within_days = null;
            $assigned_other_es_date = null;
            if ($assigned_to_other != null) {
                //this is designed for CO first proceding as assigned to LM and DA==========
                $entryTimes = 1;
                //////////

                $assigned_other_date = $hearing_date;
                if ($assigned_to_other_type == 'LM') {
                    $originalAllocation = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
                    $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
                    $remaining_days_other = $this->getRemainingDays($previousCompletedDaysLM, $originalAllocation);
                    if ($remaining_days_other < 0) {
                        $response['responseType'] = 0;
                        $response['msg'] = '#ERRRMESCLATION3281OPART5 : Remaining days can not be zero days';
                        return $response;
                    }
                    // $assigned_other_es_date = $this->getEscalatedDate($remaining_days_other);
                    $assigned_other_es_date = $this->getEscalatedDateNew($remaining_days_other, $executionDate);
                    $to_be_other_completed_within_days = $this->dateDiff($assigned_other_es_date, $executionDate);
                } elseif ($assigned_to_other_type == 'AST') {
                    $originalAllocation = $escalatedRowDetailsAgainstPetitionno->da_target_days;
                    $previousCompletedDaysDA = $escalatedRowDetailsAgainstPetitionno->da_completed_days;
                    $remaining_days_other = $this->getRemainingDays($previousCompletedDaysDA, $originalAllocation);
                    if ($remaining_days_other < 0) {
                        $response['responseType'] = 0;
                        $response['msg'] = '#ERRRMESCLATION3281OPART6 : Remaining days can not be zero days';
                        return $response;
                    }
                    // $assigned_other_es_date = $this->getEscalatedDate($remaining_days_other);
                    $assigned_other_es_date = $this->getEscalatedDateNew($remaining_days_other, $hearing_date);
                    $to_be_other_completed_within_days = $this->dateDiff($assigned_other_es_date, $hearing_date);
                }

            }
            $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);

            $updateArray = array(
                'taskid' => $taskid,
                'co_completed_days' => (int) $co_completed_days + (int) $previousCompletedDays,
                'co_escalate_status' => $escalate_status,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_date' => $executionDate,
                'escalated_date' => $escalatedDate,
                'to_be_completed_within_days' => $to_be_completed_within_days,
                'co_date_code_list' => $dateCodes,
                'assignment_type_other' => $assignment_type_other,
                'assigned_from_other'      => $user_code,
                'assigned_from_other_code' => $assigned_from_code,
                'assigned_other' => $assigned_to_other,
                'assigned_other_code' => $assigned_other_code,
                'assigned_other_date' => $assigned_other_date,
                'assigned_other_es_date' => $assigned_other_es_date,
                'to_be_other_completed_within_days' => $to_be_other_completed_within_days,
            );

        }
        if ($user_type == 'AST') {

            $completion_days_for_history = $this->dateDiff($executionDate, $escalatedRowDetailsAgainstPetitionno->assigned_other_date);
            $dateCodes = $escalatedRowDetailsAgainstPetitionno->da_date_code_list;

            if ($assigned_to_other_type == 'Notice' || $assigned_to_other_type == 'Action') {
                $lastAssignedDate = $escalatedRowDetailsAgainstPetitionno->assigned_other_date;
            }
            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->da_completed_days;
            $da_target_days = $escalatedRowDetailsAgainstPetitionno->da_target_days;
            // log_message("error","DA-TARGET_DAYS=======".$da_target_days);
            $da_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);
            // log_message("error","DA-COMPLETION_DAYS=======".$da_completed_days);
            // if ($da_target_days < $da_completed_days) {
            //     $escalate_status = 'Y';
            // } else {
                $escalate_status = 'N';
            // }
            // log_message("error","DA-ESCALATE_STATUS=======".$escalate_status);

            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }

            $updateArray = array(
                'taskid' => $taskid,
                // 'da_target_days'     => $da_target_days,
                'da_completed_days' => (int) $da_completed_days + (int) $previousCompletedDays,
                'da_escalate_status' => $escalate_status,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_date' => $executionDate,
                'escalated_date' => $escalatedDate,
                'da_date_code_list' => $dateCodes,
            );

            //this code use only while Asistant generate notice==============
            if ($assigned_to_other_type == 'Notice') {

                //THIS CODE ONLY FOR NOTICE GENERATE AND NEXT ALLOCATION DATE WILL BE AFTER HEARING DATE==========
                $originalAllocation = $escalatedRowDetailsAgainstPetitionno->da_target_days;
                $previousCompletedDaysDA = $da_completed_days;
                $remaining_days_other = $this->getRemainingDays($previousCompletedDaysDA, $originalAllocation);
                if ($remaining_days_other < 0) {
                    $response['responseType'] = 0;
                    $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                    return $response;
                }
                //end==============
                // log_message("error","remaining_days_other,hearing_date =======".$remaining_days_other."---".$hearing_date);

                $assigned_other_es_date = $this->getOtherEscalatedDate($remaining_days_other, $hearing_date);
                unset($updateArray['assigned_from']);
                unset($updateArray['assigned_from_code']);
                unset($updateArray['assigned_to_code']);
                unset($updateArray['assigned_to']);
                unset($updateArray['assigned_date']);
                unset($updateArray['escalated_date']);
                $updateArray['assigned_other_date'] = $hearing_date;
                $updateArray['to_be_other_completed_within_days'] = $this->dateDiff($assigned_other_es_date, $hearing_date);
                $updateArray['assigned_other_es_date'] = $assigned_other_es_date;

            }
            //// end====================
            //this code use only while Asistant generate Action Taken==============
            if ($assigned_to_other_type == 'Action') {

                unset($updateArray['assigned_from']);
                unset($updateArray['assigned_from_code']);
                unset($updateArray['assigned_to_code']);
                unset($updateArray['assigned_to']);

                $petitioBasicData = $this->getPetitionBasicDetails($case_no);
                if($petitioBasicData->lm_note_yn == 'Y')
                {
                    //unset($updateArray['assigned_date']);
                    //unset($updateArray['escalated_date']);
                }
                else
                {
                    unset($updateArray['assigned_date']);
                    unset($updateArray['escalated_date']);                    
                }
                //$updateArray['history_id_others'] = null;
                $updateArray['assignment_type_other'] = null;
                $updateArray['assigned_other'] = null;
                $updateArray['assigned_other_code'] = null;
                $updateArray['assigned_other_date'] = null;
                $updateArray['assigned_other_es_date'] = null;
                $updateArray['to_be_other_completed_within_days'] = null;

                $checkSKReportDoneorNot = $escalatedRowDetailsAgainstPetitionno->assigned_to_code;
                if ($checkSKReportDoneorNot == 6) {
                    $originalAllocation = $escalatedRowDetailsAgainstPetitionno->co_target_days;
                    $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
                    $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO, $originalAllocation);
                    if ($remaining_days_other < 0) {
                        $response['responseType'] = 0;
                        $response['msg'] = '#ERRRMESCLATION3281OPART7 : Remaining days can not be zero days';
                        return $response;
                    }
                    $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);
                    $updateArray['assigned_date'] = $executionDate;
                    $updateArray['escalated_date'] = $escalatedDate;
                }

            }
            //// end====================

        }

        if ($user_type == 'SK') {
            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);

            $dateCodes = $escalatedRowDetailsAgainstPetitionno->sk_date_code_list;
            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->sk_completed_days;
            $sk_target_days = $escalatedRowDetailsAgainstPetitionno->sk_target_days;
            // log_message("error","SK-TARGET_DAYS=======".$sk_target_days);
            $sk_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);
            // log_message("error","SK-COMPLETION_DAYS=======".$sk_completed_days);
            // if ($sk_target_days < $sk_completed_days) {
            //     $escalate_status = 'Y';
            // } else {
                $escalate_status = 'N';
            // }
            // log_message("error","SK-ESCALATE_STATUS=======".$escalate_status);
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }

            //this calculation is for assigning CO from SK and taking hearing date as assigned date====
            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO, $originalAllocation);
            if ($remaining_days_other == null || $remaining_days_other < 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $assigned_other_es_date = $this->getOtherEscalatedDate($remaining_days_other, $hearing_date);
            $to_be_completed_within_days = $this->dateDiff($assigned_other_es_date, $hearing_date);
            // log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);

            ///end==============

            //if action taken done then co assigned date is sk report date
            //otherwise co report date is action taken date

            $checkDAActionTakenDoneOrNot = $escalatedRowDetailsAgainstPetitionno->assigned_other;
            if ($checkDAActionTakenDoneOrNot == null) {
                $hearing_date = $executionDate;
                $assigned_other_es_date = $this->getEscalatedDateNew($remaining_days_other, $hearing_date);
            }

            $updateArray = array(
                'taskid' => $taskid,
                'sk_completed_days' => (int) $sk_completed_days + (int) $previousCompletedDays,
                'sk_escalate_status' => $escalate_status,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                // 'assigned_date'      => $executionDate,
                'assigned_date' => $hearing_date,
                'escalated_date' => $assigned_other_es_date,
                'sk_date_code_list' => $dateCodes,
                'to_be_completed_within_days' => $to_be_completed_within_days,
            );

            // log_message("error","CO==============SK".json_encode($updateArray));

        }

        if ($user_type == 'LM') {

            $completion_days_for_history = $this->dateDiff($current_date, $lastAssignedDate);

            $dateCodes = $escalatedRowDetailsAgainstPetitionno->lm_date_code_list;
            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
            $lm_target_days = $escalatedRowDetailsAgainstPetitionno->lm_target_days;

            // log_message("error","LM-TARGET_DAYS=======".$lm_target_days);
            $lm_completed_days = $this->dateDiff($current_date, $lastAssignedDate);
            // log_message("error","LM-COMPLETION_DAYS=======".$lm_completed_days);
            // if ($lm_target_days < $lm_completed_days) {
            //     $escalate_status = 'Y';
            // } else {
                $escalate_status = 'N';
            // }
            // log_message("error","LM-ESCALATE_STATUS=======".$escalate_status);
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }

            // if($assigned_to_other_type == 'LMRevert'){
            //   //this calculation is for assigning CO from LM and taking hearing date as assigned date AS REVERT CASE====
            //   $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            //   $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            //   $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
            //   $assigned_other_es_date = $this->getOtherEscalatedDate($remaining_days_other,$hearing_date);
            //   $to_be_completed_within_days = $this->dateDiff($assigned_other_es_date,$hearing_date);
            //   log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);
            //   $executionDate = $hearing_date;
            //   $escalatedDate = $assigned_other_es_date;
            // }
            $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);
            $updateArray = array(
                'taskid' => $taskid,
                'lm_completed_days' => (int) $lm_completed_days + (int) $previousCompletedDays,
                'lm_escalate_status' => $escalate_status,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_date' => $executionDate,
                'escalated_date' => $escalatedDate,
                'lm_date_code_list' => $dateCodes,
                'to_be_completed_within_days' => $to_be_completed_within_days,
            );

        }

        //UPDATE ESCALATION DATE HISTORY TABLE=====================

        $updateFlag = true;
        if ($assigned_to_other_type == 'Notice' || $assigned_to_other_type == 'Action') {
            $updateFlag = false;
            $history_id = $escalatedRowDetailsAgainstPetitionno->history_id_others;
        } else {
            $updateFlag = true;
            $history_id = $escalatedRowDetailsAgainstPetitionno->history_id;
        }

        // log_message("error","UPDATED FLAG ==========".$updateFlag);

        //STEPS to be followed:
        // 1. update escalation_dates_details against or history id
        // 2.update escalation_details with new date codes without history id
        // 3.insert history details and updated escalattion details with new history id

        $where_history = array(
            'petition_no' => $petition_no,
            'date_code' => $history_id,
            'service_code' => $service_code
        );
        $updateDatesArray = array(
            'completion_date' => $current_date,
            'escalated_status' => $escalate_status,
            'completion_days' => $completion_days_for_history,
        );

        $updateStatus22 = $this->db->update('escalation_dates_details', $updateDatesArray, $where_history);
        // log_message("error","UPDt history escalation_dates_details TABLE=======".$this->db->affected_rows());
        if ($this->db->affected_rows() <= 0) {
            log_message('error', '#ERRESCLATION3697 : Updation failed on escalation_dates_details' . $this->db->last_query());
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION3697 : Updation failed on escalation_dates_details';
            return $response;
        }

        ///////////////END PROCESS//////////////////////////

        $where = array(
            'petition_no' => $petition_no,
            'case_no'     => $case_no,
            'service_code' => $service_code
        );

        if ($finalStatus == 'final') {
            unset($updateArray['assigned_to']);
            unset($updateArray['assigned_to_code']);
            unset($updateArray['assigned_from']);
            unset($updateArray['assigned_from_code']);
            unset($updateArray['assigned_date']);
            unset($updateArray['escalated_date']);
            unset($updateArray['to_be_completed_within_days']);
            unset($updateArray['co_date_code_list']);

            $updateArray['assignment_type_other'] = null;
            $updateArray['assigned_other'] = null;
            $updateArray['assigned_other_code'] = null;
            $updateArray['assigned_other_date'] = null;
            $updateArray['assigned_other_es_date'] = null;
            $updateArray['to_be_other_completed_within_days'] = null;
            $updateArray['final_completion_date'] = $executionDate;
            $updateArray['status'] = 'F';

        }

        // log_message('error',"FINAL UPDATED ARRAY===============".json_encode($updateArray));
        $updateStatus1 = $this->db->update('escalation_details', $updateArray, $where);

        // log_message("error","ESCALATION DETAILS ENTRY TABLE=======".$this->db->affected_rows());
        // if($this->db->affected_rows() <= 0){
        //    $flag = 0;
        // }else{
        //    $flag = 1;
        // }
        if ($this->db->affected_rows() <= 0) {
            log_message('error', '#ERRESCLATION3742 : Updation failed on escalation_details' . $this->db->last_query());
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION3742 : Updation failed on escalation_details';
            return $response;
        }

        if ($doubleEntry == 0 && $finalStatus == null) {
            if ($assigned_to_other_type == 'Notice' || $assigned_to_other_type == 'SKReport') {
                $executionDate = $hearing_date;
                $escalatedDate = $assigned_other_es_date;
            }
            if($assigned_to_code == 8)
            {
                $executionDate = $hearing_date;
            }

            $action_type = json_decode(ASSIGNMENT_TYPE);
            $action_type = $action_type[0]->CODE;
            if ($escalate_status == 'Y') {
                $action_type = $action_type[1]->CODE;
            }

            $date_history = $this->generateDateCode();
            $insertDateArray = array(
                'sr_no' => $dateCode,
                'date_code' => $date_history,
                'petition_no' => $petition_no,
                'service_code' => $escalatedRowDetailsAgainstPetitionno->service_code,
                'taskid' => $taskid,
                'action_type' => $action_type,
                'pending_officer' => $assigned_to,
                'assigned_user' => $user_code,
                'assigned_user_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'registerd_on' => $escalatedRowDetailsAgainstPetitionno->registerd_on,
                'allocation_date' => $executionDate,
                'target_completion_date' => $escalatedDate,
                'date_diff' => $this->dateDiff($escalatedDate, $executionDate),
                'escalated_status' => $escalate_status,
                'created_date' => date('Y-m-d H:i:s'),
                'updated_date' => date('Y-m-d H:i:s'),
                'case_no' => $case_no,
            );
            if ($finalStatus == 'final') {
                $insertDateArray['completion_date'] = $executionDate;
            }
            log_message("error", "escalate_dates_status======" . json_encode($insertDateArray));
            $status = $this->db->insert('escalation_dates_details', $insertDateArray);
            if ($status != 1) {
                log_message('error', '#ERRESCLATION3781 : Insertion failed on escalation_dates_details' . $this->db->last_query());
                $response['responseType'] = 0;
                $response['msg'] = '#ERRESCLATION3781 : Insertion failed on escalation_dates_details';
                return $response;
            }
            if ($updateFlag == true) {
                $where_history_set = array(
                    'petition_no' => $petition_no,
                    'case_no'     => $case_no,
                );
                $updateDatesArraySet = array(
                    'history_id' => $date_history,
                );
                $updateStatus22 = $this->db->update('escalation_details', $updateDatesArraySet, $where_history_set);
                if ($this->db->affected_rows() <= 0) {
                    log_message('error', '#ERRESCLATION3796 : Updation failed on escalation_details' . $this->db->last_query());
                    $response['responseType'] = 0;
                    $response['msg'] = '#ERRESCLATION3796 : Updation failed on escalation_details';
                    return $response;
                }
            }

        }

        //INSERT HISTORY FOR ESCALATION DATE DETAILS=====================
        if ($entryTimes == 1) {
            $action_type = json_decode(ASSIGNMENT_TYPE);
            $action_type = $action_type[0]->CODE;
            if ($escalate_status == 'Y') {
                $action_type = $action_type[1]->CODE;
            }

            if($assigned_other_code == 8)
            {
                $executionDate = $hearing_date;
            }

            $date_history = $this->generateDateCode();
            $insertDateArray = array(
                'date_code' => $date_history,
                'petition_no' => $petition_no,
                'service_code' => $escalatedRowDetailsAgainstPetitionno->service_code,
                'taskid' => $taskid,
                'action_type' => $action_type,
                'pending_officer' => $assigned_to_other,
                'assigned_user' => $user_code,
                'assigned_user_code' => $assigned_from_code,
                'assigned_to' => $assigned_to_other,
                'assigned_to_code' => $assigned_other_code,
                'registerd_on' => $escalatedRowDetailsAgainstPetitionno->registerd_on,
                'allocation_date' => $assigned_other_date,
                'target_completion_date' => $assigned_other_es_date,
                'date_diff' => $this->dateDiff($assigned_other_es_date, $executionDate),
                'escalated_status' => $escalate_status,
                'created_date' => date('Y-m-d H:i:s'),
                'updated_date' => date('Y-m-d H:i:s'),
                'case_no'      => $case_no
            );
            $status = $this->db->insert('escalation_dates_details', $insertDateArray);
            if ($status != 1) {
                log_message('error', '#ERRESCLATION3831 : Insertion failed on escalation_dates_details' . $this->db->last_query());
                $response['responseType'] = 0;
                $response['msg'] = '#ERRESCLATION3831 : Insertion failed on escalation_dates_details';
                return $response;
            }
            $where_history_set = array(
                'petition_no' => $petition_no,
                'case_no'     => $case_no,
            );

            $updateDatesArraySet = array(
                'history_id_others' => $date_history,
            );
            $updateStatus22 = $this->db->update('escalation_details', $updateDatesArraySet, $where_history_set);
            if ($this->db->affected_rows() <= 0) {
                log_message('error', '#ERRESCLATION3846 : Updation failed on escalation_details' . $this->db->last_query());
                $response['responseType'] = 0;
                $response['msg'] = '#ERRESCLATION3846 : Updation failed on escalation_details';
                return $response;
            }
        }
        return $response;

        // log_message("error","ESCALATION DATE DETAILS ENTRY TABLE=======".$status);
        // //////////////////////END PROCESS////////////////////
        // if($status !=1){
        //   $flag1 = 0;
        // }else{
        //   $flag1 = 1;
        // }
        // if($flag==1 && $flag1 == 1){
        //   return $flag;
        // }else{
        //   return 0;
        // }
    }

    public function getEscalatedDateNew($target_days, $executionDate)
    {

        if (ESCALATION_ALLOW_TIME == 1) {
            return date("Y-m-d H:i:s", strtotime($executionDate) + (60 * $target_days));
        } else {
            $Interval = '+' . $target_days . ' days';
            // $escalatedDate =Date('Y-m-d', strtotime($Interval));
            $escalatedDate = date('Y-m-d H:i:s', strtotime($executionDate . $Interval));
            return $escalatedDate;
        }
    }

    public function getEscalatedDate($target_days)
    {

        if (ESCALATION_ALLOW_TIME == 1) {
            $date = date('Y-m-d H:i:s');
            $addingMinutes = strtotime($date . ' + ' . $target_days . ' minute');
            // echo date('Y-m-d H:i:s', $addingFiveMinutes);

            // $addingMinutes= strtotime("Y-m-d H:i:s + 2 minute");
            // var_dump($addingMinutes); die;
            return date('Y-m-d H:i:s', $addingMinutes);
        } else {
            $Interval = '+' . $target_days . ' days';
            $escalatedDate = Date('Y-m-d', strtotime($Interval));
            return $escalatedDate;
        }

    }

    public function getOtherEscalatedDate($target_days, $hearing_date)
    {
        if (ESCALATION_ALLOW_TIME == 1) {
            return date("Y-m-d H:i:s", strtotime($hearing_date) + (60 * $target_days));
        } else {
            $Interval = '+' . $target_days . ' day';
            // $escalatedDate =Date(date('Y-m-d',strtotime($hearing_date)), strtotime($Interval));
            $escalatedDate = date('Y-m-d', strtotime($hearing_date . $Interval));
            return $escalatedDate;
        }
    }

    // public function dateDiff($date1, $date2){
    //   $date1_ts = strtotime($date1);
    //   $date2_ts = strtotime($date2);
    //   $diff = $date1_ts - $date2_ts;
    //   return round($diff / 86400);
    // }

    public function dateDiff($date1, $date2)
    {

        if (ESCALATION_ALLOW_TIME == 1) {
            $to_time = strtotime($date1);
            $from_time = strtotime($date2);
            $d = round(abs($to_time - $from_time) / 60, 2);
            return $d;
        } else {
            $date1_ts = strtotime($date1);
            $date2_ts = strtotime($date2);
            $diff = $date1_ts - $date2_ts;
            return round($diff / 86400);
        }
    }

    public function getPetitionNo($case_no, $service_code, $service_name)
    {
        if ($service_code == 1 && $service_name == 'OMUT') {
            $sql = "Select petition_no from petition_basic where  case_no=?";
            $data = $this->db->query($sql, array($case_no))->row();
            return $data->petition_no;
        } else {
            $sql = "Select petition_no from field_mut_basic where  case_no=?";
            $data = $this->db->query($sql, array($case_no))->row();
            return $data->petition_no;
        }

    }
    public function getPetitionBasicDetails($case_no)
    {
        $sql = "Select * from petition_basic where  case_no=?";
        $data = $this->db->query($sql, array($case_no))->row();
        return $data;
    }
    public function getPetitionNoOMUT($case_no)
    {
        $sql = "Select petition_no from petition_basic where  case_no=?";
        $data = $this->db->query($sql, array($case_no))->row();
        return $data->petition_no;
    }

    public function getPetitionNoNCAN($case_no)
    {

        $sql = "Select misc_case_petition_no from misc_case_basic where  misc_case_no=?";
        $data = $this->db->query($sql, array($case_no))->row();
        return $data->misc_case_petition_no;

    }

    public function getPetitionNoNCOR($case_no)
    {

        $sql = "Select misc_case_petition_no from misc_case_basic where  misc_case_no=?";
        $data = $this->db->query($sql, array($case_no))->row();
        return $data->misc_case_petition_no;

    }

    public function getPetitionNoANCOR($case_no)
    {

        $sql = "Select petition_no from legacy_correction where case_no=?";
        $data = $this->db->query($sql, array($case_no))->row();
        return $data->petition_no;

    }
    public function getPetitionNoACOR($case_no)
    {

        $sql = "Select proposal_no from t_legacyupdation where case_no=?";
        $data = $this->db->query($sql, array($case_no))->row();
        return $data->proposal_no;

    }
    public function getPetitionNoRECLASS($case_no)
    {

        $sql = "Select proposal_no from t_reclassification where case_no=?";
        $data = $this->db->query($sql, array($case_no))->row();
        return $data->proposal_no;

    }

    public function getPetitionNoMCOR($value = '')
    {
        $sql = "Select petition_no from legacy_correction where case_no=?";
        $data = $this->db->query($sql, array($case_no))->row();
        return $data->petition_no;
    }

    public function escalationCOFirstProceding($service_code,$executionDate, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $case_no, $user_code)
    {

        $executionDate = $executionDate;
        $assigned_to_other = $this->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'AST');
        $assigned_to = $this->getPendingOfficerLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $hearing_date = null;
        $user_type = 'CO';
        $service_code = $service_code;
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'LM';
        $assigned_to_other_type = 'AST';
        $finalStatus = null;
        $assigned_to_other = $assigned_to_other->user_code;
        $task = json_decode(OMUT_TASK);
        $taskid = $task[1]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = null;
        $assignment_type_other = $assignment_type_list[0]->CODE;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->escalationMatrixUpdateOMUT($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;

    }

    public function escalationCOFirstProcedingNew($service_code,$executionDate, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $case_no, $user_code,$nextHearingDate)
    {

        $executionDate = $executionDate;
        $assigned_to_other = $this->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'AST');
        $assigned_to = $this->getPendingOfficerLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $hearing_date = $nextHearingDate;
        $user_type = 'CO';
        $service_code = $service_code;
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'LM';
        $assigned_to_other_type = 'AST';
        $finalStatus = null;
        $assigned_to_other = $assigned_to_other->user_code;
        $task = json_decode(OMUT_TASK);
        $taskid = $task[1]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = null;
        $assignment_type_other = $assignment_type_list[0]->CODE;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->escalationMatrixUpdateOMUT($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;

    }

    public function escalationDANotice($service_code,$executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code, $hearing_date)
    {

        //taken because next time will start from completion date of hearing===========
        $executionDate = date('Y-m-d H:i:s');
        ///////////////////
        $user_type = 'AST';
        $service_code = $service_code;
        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'AST';
        $assigned_to_other_type = "Notice";
        $finalStatus = null;
        $assigned_to_other = null;
        $task = json_decode(OMUT_TASK);
        $taskid = $task[2]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = null;
        $assignment_type_other = $assignment_type_list[0]->CODE;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateOMUT($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;
    }

    public function escalationLMReport($service_code,$executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code)
    {
        $executionDate = $executionDate;
        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $user_type = 'LM';
        $service_code = $service_code;
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'CO';
        $assigned_to_other_type = null;
        $finalStatus = null;
        $assigned_to_other = null;
        $hearing_date = null;
        $task = json_decode(OMUT_TASK);
        $taskid = $task[3]->CODE;
        $assignment_type = null;
        $assignment_type_other = null;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateOMUT($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);

        return $escalationUpdateStatus;
    }

    public function escalationSKReport($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code, $hearing_date)
    {

        $executionDate = $executionDate;
        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $user_type = 'SK';
        $service_code = '1';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'CO';
        $assigned_to_other_type = 'SKReport';
        $finalStatus = null;
        $assigned_to_other = null;
        $task = json_decode(OMUT_TASK);
        $taskid = $task[5]->CODE;
        $assignment_type = null;
        $assignment_type_other = null;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateOMUT($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);

        return $escalationUpdateStatus;

    }

    public function escalationDAAction($service_code,$executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code)
    {

        $executionDate = $executionDate;
        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $user_type = 'AST';
        $service_code = $service_code;
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'CO';
        $assigned_to_other_type = 'Action';
        $finalStatus = null;
        $assigned_to_other = null;
        $hearing_date = null;
        $task = json_decode(OMUT_TASK);
        $taskid = $task[4]->CODE;
        $assignment_type = null;
        $assignment_type_other = null;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateOMUT($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);

        return $escalationUpdateStatus;
    }

    public function escalationFinalOrderCO($service_code,$executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code)
    {

        $executionDate = $executionDate;
        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $hearing_date = null;
        $user_type = 'CO';
        $service_code = $service_code;
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'CO';
        $assigned_to_other_type = null;
        $finalStatus = 'final';
        $assigned_to_other = null;
        $task = json_decode(OMUT_TASK);
        $taskid = $task[6]->CODE;
        $assignment_type = null;
        $assignment_type_other = null;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateOMUT($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;
    }

    // public function escalationCORevert($dist_code,$subdiv_code,$cir_code,$case_no,$user_code,$mouza_pargona_code,$lot_no,$allocation_days){

    //     $executionDate = date('Y-m-d');
    //     $assigned_to = $this->getPendingOfficerLM($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no);
    //     $hearing_date = null;
    //     $user_type = 'CO';
    //     $service_code = '1';
    //     $assigned_to_code = $assigned_to->user_code;
    //     $assigned_user_type = 'LM';
    //     $assigned_to_other_type = null;
    //     $finalStatus = null;
    //     $assigned_to_other = null;
    //     $task= json_decode(OMUT_TASK);
    //     $taskid = $task[7]->CODE;
    //     $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
    //     $assignment_type=null;
    //     //this is for revert
    //     if($allocation_days == null){
    //       $assignment_type_other = $assignment_type_list[3]->CODE;
    //     }else{
    //       $assignment_type_other = $assignment_type_list[2]->CODE;
    //     }
    //     $allocation_days = 0;
    //     $escalationUpdateStatus = $this->escalationMatrixUpdateOMUT($case_no,$executionDate,$user_code,$user_type,$service_code,$assigned_to_code,$assigned_user_type,$finalStatus,$assigned_to_other,$assigned_to_other_type,$hearing_date,$taskid,$assignment_type,$assignment_type_other,$allocation_days);
    //     return $escalationUpdateStatus;

    // }

    public function escalationCORevert($dist_code, $subdiv_code, $cir_code, $case_no, $user_code, $mouza_pargona_code, $lot_no, $allocation_days,$service_code)
    {

        $executionDate = date('Y-m-d');
        $assigned_to = $this->getPendingOfficerLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $hearing_date = null;
        $user_type = 'CO';
        $service_code = $service_code;
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'LM';
        $assigned_to_other_type = null;
        $finalStatus = null;
        $assigned_to_other = null;
        $task = json_decode(OMUT_TASK);
        $taskid = $task[7]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = null;
        //this is for revert
        // if($allocation_days == null){
        $assignment_type_other = $assignment_type_list[0]->CODE;
        // }else{
        //   $assignment_type_other = $assignment_type_list[2]->CODE;

        // }

        if ($allocation_days != null) {
            $updateExtraDaysAgainstPetitionNo = $this->updateExtraDays($case_no, $allocation_days);
        }

        $escalationUpdateStatus = $this->escalationMatrixUpdateOMUT($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;

    }

    public function escalationLMRevertReport($service_code,$dist_code, $subdiv_code, $cir_code, $case_no, $user_code, $hearing_date)
    {
        $executionDate = date('Y-m-d H:i:s');
        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $user_type = 'LM';
        $service_code = $service_code;
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'CO';
        $assigned_to_other_type = "LMRevert";
        $finalStatus = null;
        $assigned_to_other = null;
        $task = json_decode(OMUT_TASK);
        $taskid = $task[3]->CODE;
        $assignment_type = null;
        $hearing_date = null;
        $assignment_type_other = null;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateOMUT($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);

        return $escalationUpdateStatus;

    }

    public function escalationLMFieldMutReport($service_code,$executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code)
    {
        // $executionDate = date('Y-m-d');
        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $user_type = 'LM';
        $service_code = $service_code;
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'CO';
        $assigned_to_other_type = null;
        $finalStatus = null;
        $assigned_to_other = null;
        $hearing_date = null;
        $task = json_decode(FMUT_TASK);
        $taskid = $task[1]->CODE;
        $assignment_type = null;
        $assignment_type_other = null;
        $allocation_days = 0;
        $service_type = explode('/',$case_no);
        $response = array();
        if($service_type[4] == 'FMUT')
        {
            $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateFMUT($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        }
        elseif($service_type[4] == 'FPART')
        {
            $service_code = '3';
            $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateFPART($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        }
        else
        {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION4296 : Case not under Mutation or Partition';
            $escalationUpdateStatus = $response;
        }
        

        return $escalationUpdateStatus;
    }

    public function escalationFinalOrderCOFmut($service_code,$executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code)
    {

        $executionDate = $executionDate;
        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $hearing_date = null;
        $user_type = 'CO';
        $service_code = $this->Escalationmodel->getServiceCodeForMutD($case_no);
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'CO';
        $assigned_to_other_type = null;
        $finalStatus = 'final';
        $assigned_to_other = null;
        $task = json_decode(FMUT_TASK);
        $taskid = $task[3]->CODE;
        $assignment_type = null;
        $assignment_type_other = null;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateFMUT($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;
    }

    public function escalationCORevertToLM($service_code,$executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code, $mouza_pargona_code, $lot_no, $allocation_days)
    {

        // $executionDate = date('Y-m-d');
        $assigned_to = $this->getPendingOfficerLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $hearing_date = null;
        $user_type = 'CO';
        $service_code = $service_code;
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'LM';
        $assigned_to_other_type = null;
        $finalStatus = null;
        $assigned_to_other = null;
        $task = json_decode(FMUT_TASK);
        $taskid = $task[4]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = null;
        $assignment_type_other = $assignment_type_list[3]->CODE;
        if ($allocation_days != null) {
            $updateExtraDaysAgainstPetitionNo = $this->updateExtraDays($case_no, $allocation_days);
        }
        $escalationUpdateStatus = $this->escalationMatrixUpdateFMUT($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;

    }

    public function escalationCOFirstProcedingNCAN($executionDate, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $case_no, $user_code)
    {

        $allocation_days = 0;
        $executionDate = $executionDate;
        $assigned_to_other = $this->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'AST');
        $assigned_to = $this->getPendingOfficerLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $hearing_date = null;
        $user_type = 'CO';
        $service_code = '8';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'LM';
        $assigned_to_other_type = 'AST';
        $finalStatus = null;
        $assigned_to_other = $assigned_to_other->user_code;
        $task = json_decode(NCAN);
        $taskid = $task[1]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = $assignment_type_list[0]->CODE;
        $assignment_type_other = $assignment_type_list[0]->CODE;

        $escalationUpdateStatus = $this->escalationMatrixUpdateNCAN($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;
    }

    public function escalationLMReportNCAN($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code, $hearing_date)
    {
        $executionDate = $executionDate;
        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $user_type = 'LM';
        $service_code = '8';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'CO';
        $assigned_to_other_type = null;
        $finalStatus = null;
        $assigned_to_other = null;
        $task = json_decode(NCAN);
        $taskid = $task[2]->CODE;
        $assignment_type = null;
        $assignment_type_other = null;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateNCAN($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);

        return $escalationUpdateStatus;
    }

    public function escalationSKReportNCAN($dist_code, $subdiv_code, $cir_code, $case_no, $user_code, $hearing_date)
    {

        $executionDate = date('Y-m-d');
        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $user_type = 'SK';
        $service_code = '8';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'CO';
        $assigned_to_other_type = 'SKReport';
        $finalStatus = null;
        $assigned_to_other = null;
        $task = json_decode(NCAN);
        $taskid = $task[3]->CODE;
        $assignment_type = null;
        $assignment_type_other = null;
        $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateNCAN($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        $allocation_days = 0;
        return $escalationUpdateStatus;

    }

    public function escalationFinalOrderNCAN($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code)
    {

        $executionDate = $executionDate;
        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $hearing_date = null;
        $user_type = 'CO';
        $service_code = '8';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'CO';
        $assigned_to_other_type = null;
        $finalStatus = 'final';
        $assigned_to_other = null;
        $task = json_decode(NCAN);
        $taskid = $task[5]->CODE;
        $assignment_type = null;
        $assignment_type_other = null;
        $allocation_days = 0;

        $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateNCAN($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;
    }

    public function escalationCORevertNCAN($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code, $mouza_pargona_code, $lot_no, $allocation_days)
    {

        $executionDate = $executionDate;
        $assigned_to = $this->getPendingOfficerLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $hearing_date = null;
        $user_type = 'CO';
        $service_code = '8';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'LM';
        $assigned_to_other_type = null;
        $finalStatus = null;
        $assigned_to_other = null;
        $task = json_decode(NCAN);
        $taskid = $task[6]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = $assignment_type_list[3]->CODE;
        $assignment_type_other = null;

        if ($allocation_days != null) {
            $updateExtraDaysAgainstPetitionNo = $this->updateExtraDays($case_no, $allocation_days);
        }

        $escalationUpdateStatus = $this->escalationMatrixUpdateNCAN($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;

    }

    public function escalationDANoticeNCAN($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code, $hearing_date)
    {

        //taken because next time will start from completion date of hearing===========
        // $executionDate = date('Y-m-d');
        ///////////////////
        $user_type = 'AST';
        $service_code = '8';
        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'AST';
        $assigned_to_other_type = "Notice";
        $finalStatus = null;
        $assigned_to_other = null;
        $task = json_decode(NCAN);
        $taskid = $task[4]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = null;
        $assignment_type_other = $assignment_type_list[0]->CODE;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateNCAN($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;
    }

    public function escalationDAActionNCAN($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code)
    {

        $executionDate = $executionDate;
        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');

        $user_type = 'AST';
        $service_code = '8';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'CO';
        $assigned_to_other_type = 'Action';
        $finalStatus = null;
        $assigned_to_other = null;
        $hearing_date = null;
        $task = json_decode(NCAN);
        $taskid = $task[8]->CODE;
        $assignment_type = null;
        $assignment_type_other = null;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateNCAN($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);

        return $escalationUpdateStatus;
    }

    public function escalationLMReportANCOR($dist_code, $subdiv_code, $cir_code, $case_no, $user_code)
    {
        $executionDate = date('Y-m-d');
        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $user_type = 'LM';
        $service_code = '20';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'CO';
        $assigned_to_other_type = null;
        $finalStatus = null;
        $assigned_to_other = null;
        $hearing_date = null;
        $task = json_decode(ANCOR);
        $taskid = $task[1]->CODE;
        $assignment_type = null;
        $assignment_type_other = null;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateANCOR($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);

        return $escalationUpdateStatus;
    }

    public function escalationLMRevertReportNCAN($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code)
    {
        $executionDate = $executionDate;
        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $user_type = 'LM';
        $service_code = '8';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'CO';
        $assigned_to_other_type = "LMRevert";
        $finalStatus = null;
        $assigned_to_other = null;
        $task = json_decode(NCAN);
        $taskid = $task[7]->CODE;
        $assignment_type = null;
        $hearing_date = null;
        $assignment_type_other = null;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateNCAN($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);

        return $escalationUpdateStatus;

    }

    public function escalationCOReportMCOR($dist_code, $subdiv_code, $cir_code, $case_no, $user_code)
    {

        $executionDate = date('Y-m-d');
        $assigned_to = $this->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $assigned_to_other = null;
        $hearing_date = null;
        $user_type = 'CO';
        $service_code = '20';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = null;
        $assigned_to_other_type = null;
        $finalStatus = 'final';
        $assigned_to_other = $assigned_to_other->user_code;
        $task = json_decode(MCOR);
        $taskid = $task[1]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = null;
        $assignment_type_other = $assignment_type_list[0]->CODE;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->escalationMatrixUpdateMCOR($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;
    }

    public function escalationCOReportRejectMCOR($dist_code, $subdiv_code, $cir_code, $case_no, $user_code)
    {
        $executionDate = date('Y-m-d');
        $user_type = 'CO';
        $service_code = '20';
        $finalStatus = 'Reject';
        $task = json_decode(MCOR);
        $taskid = $task[2]->CODE;
        $escalationUpdateStatus = $this->escalationMatrixUpdateReject($case_no, $executionDate, $user_code, $user_type, $service_code, $finalStatus, $taskid);
        return $escalationUpdateStatus;
    }

    public function escalationRejectMBService($case_no, $user_code, $petition_no)
    {
        $executionDate = date('Y-m-d');
        $user_type = 'CO';
        $service_code = '20';
        $finalStatus = 'Reject';
        $task = json_decode(MCOR);
        $taskid = $task[2]->CODE;
        $escalationUpdateStatus = $this->escalationMatrixUpdateRejectMBService($case_no, $executionDate, $user_code, $user_type, $service_code, $finalStatus, $taskid, $petition_no);
        return $escalationUpdateStatus;
    }

    public function escalationLMReclassReport($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code)
    {
        $executionDate = $executionDate;
        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $user_type = 'LM';
        $service_code = '4';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'CO';
        $assigned_to_other_type = null;
        $finalStatus = null;
        $assigned_to_other = null;
        $hearing_date = null;
        $task = json_decode(RECLASS);
        $taskid = $task[1]->CODE;
        $assignment_type = null;
        $assignment_type_other = null;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateRECLASS($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);

        return $escalationUpdateStatus;
    }

    public function escalationCOProcessRECLASS($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code)
    {
        $executionDate = $executionDate;
        $assigned_to = $this->Escalationmodel->getPendingOfficerADC($dist_code, 'ADC');
        $user_type = 'CO';
        $service_code = '4';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'ADC';
        $assigned_to_other_type = null;
        $finalStatus = null;
        $assigned_to_other = null;
        $hearing_date = null;
        $task = json_decode(RECLASS);
        $taskid = $task[2]->CODE;
        $assignment_type = null;
        $assignment_type_other = null;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateRECLASS($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);

        return $escalationUpdateStatus;
    }

    public function escalationADCProcessRECLASS($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code)
    {
        $executionDate = $executionDate;
        $assigned_to = $this->Escalationmodel->getPendingOfficerDC($dist_code, 'DC');
        $user_type = 'ADC';
        $service_code = '4';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'DC';
        $assigned_to_other_type = null;
        $finalStatus = null;
        $assigned_to_other = null;
        $hearing_date = null;
        $task = json_decode(RECLASS);
        $taskid = $task[3]->CODE;
        $assignment_type = null;
        $assignment_type_other = null;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateRECLASS($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);

        return $escalationUpdateStatus;
    }
    public function escalationDCProcessRECLASS($executionDate, $dist_code, $case_no, $user_code)
    {
        $executionDate = $executionDate;
        $assigned_to = $this->Escalationmodel->getPendingOfficerDC($dist_code, 'DC');
        $user_type = 'DC';
        $service_code = '4';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'DC';
        $assigned_to_other_type = null;
        $finalStatus = 'final';
        $assigned_to_other = null;
        $hearing_date = null;
        $task = json_decode(RECLASS);
        $taskid = $task[4]->CODE;
        $assignment_type = null;
        $assignment_type_other = null;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateRECLASS($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);

        return $escalationUpdateStatus;
    }

    public function escalationCORevertToLMRECLASS($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code, $mouza_pargona_code, $lot_no, $allocation_days)
    {

        $assigned_to = $this->getPendingOfficerLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $hearing_date = null;
        $user_type = 'CO';
        $service_code = '4';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'LM';
        $assigned_to_other_type = null;
        $finalStatus = null;
        $assigned_to_other = null;
        $task = json_decode(RECLASS);
        $taskid = $task[5]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = null;
        $assignment_type_other = $assignment_type_list[3]->CODE;
        if ($allocation_days != null) {
            $updateExtraDaysAgainstPetitionNo = $this->updateExtraDays($case_no, $allocation_days);
        }
        $escalationUpdateStatus = $this->escalationMatrixUpdateRECLASS($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;

    }
    public function escalationADCRevertCoRECLASS($executionDate, $allocation_days, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code)
    {
        $assigned_to = $this->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $hearing_date = null;
        $user_type = 'ADC';
        $service_code = '4';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'CO';
        $assigned_to_other_type = null;
        $finalStatus = null;
        $assigned_to_other = null;
        $task = json_decode(RECLASS);
        $taskid = $task[6]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = null;
        $assignment_type_other = $assignment_type_list[3]->CODE;
        if ($allocation_days != null) {
            $updateExtraDaysAgainstPetitionNo = $this->updateExtraDaysADCCO($case_no, $allocation_days);
        }
        $escalationUpdateStatus = $this->escalationMatrixUpdateRECLASS($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;
    }

    public function escalationDCRevertCoRECLASS($executionDate, $allocation_days, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code)
    {
        $assigned_to = $this->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $hearing_date = null;
        $user_type = 'DC';
        $service_code = '4';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'CO';
        $assigned_to_other_type = null;
        $finalStatus = null;
        $assigned_to_other = null;
        $task = json_decode(RECLASS);
        $taskid = $task[7]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = null;
        $assignment_type_other = $assignment_type_list[3]->CODE;
        if ($allocation_days != null) {
            $updateExtraDaysAgainstPetitionNo = $this->updateExtraDaysDCCO($case_no, $allocation_days);
        }
        $escalationUpdateStatus = $this->escalationMatrixUpdateRECLASS($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;
    }

    public function escalationDCRevertADCRECLASS($executionDate, $allocation_days, $dist_code, $case_no, $user_code)
    {

        $assigned_to = $this->getPendingOfficerADC($dist_code, 'ADC');
        $hearing_date = null;
        $user_type = 'DC';
        $service_code = '4';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'ADC';
        $assigned_to_other_type = null;
        $finalStatus = null;
        $assigned_to_other = null;
        $task = json_decode(RECLASS);
        $taskid = $task[8]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = null;
        $assignment_type_other = $assignment_type_list[3]->CODE;
        if ($allocation_days != null) {
            $updateExtraDaysAgainstPetitionNo = $this->updateExtraDaysDCADC($case_no, $allocation_days);
        }
        $escalationUpdateStatus = $this->escalationMatrixUpdateRECLASS($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;

    }

    public function escalationLMPartFieldReport($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code)
    {

        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $user_type = 'LM';
        $service_code = '3';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'CO';
        $assigned_to_other_type = null;
        $finalStatus = null;
        $assigned_to_other = null;
        $hearing_date = null;
        $task = json_decode(FPART_TASK);
        $taskid = $task[1]->CODE;
        $assignment_type = null;
        $assignment_type_other = null;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateFPART($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);

        return $escalationUpdateStatus;
    }

    public function escalationCORevertToLMFPART($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code, $mouza_pargona_code, $lot_no, $allocation_days)
    {

        // $executionDate = date('Y-m-d');
        $assigned_to = $this->getPendingOfficerLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $hearing_date = null;
        $user_type = 'CO';
        $service_code = '3';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'LM';
        $assigned_to_other_type = null;
        $finalStatus = null;
        $assigned_to_other = null;
        $task = json_decode(FPART_TASK);
        $taskid = $task[4]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = null;
        $assignment_type_other = $assignment_type_list[3]->CODE;
        if ($allocation_days != null) {
            $updateExtraDaysAgainstPetitionNo = $this->updateExtraDays($case_no, $allocation_days);
        }
        $escalationUpdateStatus = $this->escalationMatrixUpdateFPART($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;

    }

    public function escalationFinalOrderCOFPART($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code)
    {

        $executionDate = $executionDate;
        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $hearing_date = null;
        $user_type = 'CO';
        $service_code = '3';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'CO';
        $assigned_to_other_type = null;
        $finalStatus = 'final';
        $assigned_to_other = null;
        $task = json_decode(FPART_TASK);
        $taskid = $task[3]->CODE;
        $assignment_type = null;
        $assignment_type_other = null;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateFPART($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;
    }

    public function escalationCOFirstProcedingOPART($executionDate, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $case_no, $user_code)
    {

        $executionDate = $executionDate;
        $assigned_to_other = $this->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'AST');
        $assigned_to = $this->getPendingOfficerLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $hearing_date = null;
        $user_type = 'CO';
        $service_code = '3';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'LM';
        $assigned_to_other_type = 'AST';
        $finalStatus = null;
        $assigned_to_other = $assigned_to_other->user_code;
        $task = json_decode(OPART_TASK);
        $taskid = $task[1]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = null;
        $assignment_type_other = $assignment_type_list[0]->CODE;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->escalationMatrixUpdateOPART($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;

    }

    public function escalationCOFirstProcedingOPARTNew($executionDate, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $case_no, $user_code,$nextHearingDate)
    {

        $executionDate = $executionDate;
        $assigned_to_other = $this->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'AST');
        $assigned_to = $this->getPendingOfficerLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $hearing_date = $nextHearingDate;
        $user_type = 'CO';
        $service_code = '3';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'LM';
        $assigned_to_other_type = 'AST';
        $finalStatus = null;
        $assigned_to_other = $assigned_to_other->user_code;
        $task = json_decode(OPART_TASK);
        $taskid = $task[1]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = null;
        $assignment_type_other = $assignment_type_list[0]->CODE;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->escalationMatrixUpdateOPART($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;

    }

    public function escalationLMReportOPART($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code)
    {
        $executionDate = $executionDate;
        // $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'SK');
        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $user_type = 'LM';
        $service_code = '3';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'CO';
        $assigned_to_other_type = null;
        $finalStatus = null;
        $assigned_to_other = null;
        $hearing_date = null;
        $task = json_decode(OPART_TASK);
        $taskid = $task[3]->CODE;
        $assignment_type = null;
        $assignment_type_other = null;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateOPART($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);

        return $escalationUpdateStatus;
    }

    public function escalationDANoticeOPART($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code, $hearing_date)
    {

        //taken because next time will start from completion date of hearing===========
        $executionDate = $executionDate;
        ///////////////////
        $user_type = 'AST';
        $service_code = '3';
        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'AST';
        $assigned_to_other_type = "Notice";
        $finalStatus = null;
        $assigned_to_other = null;
        $task = json_decode(OPART_TASK);
        $taskid = $task[2]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = null;
        $assignment_type_other = $assignment_type_list[0]->CODE;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateOPART($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;
    }

    public function escalationDAActionOPART($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code)
    {

        $executionDate = $executionDate;
        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');

        $user_type = 'AST';
        $service_code = '3';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'CO';
        $assigned_to_other_type = 'Action';
        $finalStatus = null;
        $assigned_to_other = null;
        $hearing_date = null;
        $task = json_decode(OPART_TASK);
        $taskid = $task[4]->CODE;
        $assignment_type = null;
        $assignment_type_other = null;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateOPART($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);

        return $escalationUpdateStatus;
    }

    public function escalationSKReportOPART($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code, $hearing_date)
    {

        $executionDate = $executionDate;
        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $user_type = 'SK';
        $service_code = '3';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'CO';
        $assigned_to_other_type = 'SKReport';
        $finalStatus = null;
        $assigned_to_other = null;
        $task = json_decode(OPART_TASK);
        $taskid = $task[5]->CODE;
        $assignment_type = null;
        $assignment_type_other = null;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateOPART($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);

        return $escalationUpdateStatus;

    }

    public function escalationFinalOrderCOOPART($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code)
    {

        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $hearing_date = null;
        $user_type = 'CO';
        $service_code = '3';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'CO';
        $assigned_to_other_type = null;
        $finalStatus = 'final';
        $assigned_to_other = null;
        $task = json_decode(OPART_TASK);
        $taskid = $task[6]->CODE;
        $assignment_type = null;
        $assignment_type_other = null;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateOPART($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;
    }

    public function escalationCORevertToLMOPART($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code, $mouza_pargona_code, $lot_no, $allocation_days)
    {

        // $executionDate = date('Y-m-d');
        $assigned_to = $this->getPendingOfficerLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $hearing_date = null;
        $user_type = 'CO';
        $service_code = '3';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'LM';
        $assigned_to_other_type = null;
        $finalStatus = null;
        $assigned_to_other = null;
        $task = json_decode(OPART_TASK);
        $taskid = $task[7]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = null;
        $assignment_type_other = $assignment_type_list[3]->CODE;
        if ($allocation_days != null) {
            $updateExtraDaysAgainstPetitionNo = $this->updateExtraDays($case_no, $allocation_days);
        }
        $escalationUpdateStatus = $this->escalationMatrixUpdateOPART($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;

    }

    public function escalationLMRevertReportOPART($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code, $hearing_date)
    {
        $executionDate = date('Y-m-d');
        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $user_type = 'LM';
        $service_code = '3';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'CO';
        $assigned_to_other_type = "LMRevert";
        $finalStatus = null;
        $assigned_to_other = null;
        $task = json_decode(OPART_TASK);
        $taskid = $task[3]->CODE;
        $assignment_type = null;
        $hearing_date = null;
        $assignment_type_other = null;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateOPART($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);

        return $escalationUpdateStatus;

    }

    // *********************************** Added by Utpal *****************

    public function getPendingMutationCasesCOEnd($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $mouza_code, $lot_no, $vill_mouza_code, $vill_lot_no, $village_code, $define_date, $searchByCol_0, $zone_status)
    {
        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 'petition_basic.petition_no',
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
            $this->db->where("(application_ref_no like '%$searchByCol_0%' or case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }
        if (!empty($mouza_code)) {
            $this->db->where('mouza_pargona_code', $mouza_code);
        }
        if (!empty($lot_no)) {
            $this->db->where('lot_no', $lot_no);
        }
        if (!empty($vill_mouza_code)) {
            $this->db->where('mouza_pargona_code', $vill_mouza_code);
        }
        if (!empty($vill_lot_no)) {
            $this->db->where('lot_no', $vill_lot_no);
        }
        if (!empty($village_code)) {
            $this->db->where('vill_townprt_code', $village_code);
        }

        $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('petition_basic.status', null);
        $this->db->where('petition_basic.comp_serv_yn', null);
        $this->db->where('petition_basic.not_fresh', null);
        $this->db->where('petition_basic.lm_note_yn', null);
        $this->db->where('petition_basic.mut_type', '03');
        $this->db->where('date(date_entry) >=', $define_date);

        if ($zone_status == 4) {
            $this->db->where('petition_basic.es_flag', 0);
        } else {
            $this->db->where('petition_basic.es_flag', 1);
        }

        $this->db->limit($length, $start);
        $query = $this->db->get('petition_basic');
        log_message('error', "petition_basic: " . $this->db->last_query());

        // echo $this->db->last_query();

        if ($query->num_rows() > 0) {

            $data_results = $query->result();
            $final_array = array();

            foreach ($data_results as $rr) {
                $variable = $this->escalationZoneWiseSearch($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->submission_date, $rr->escalated_date, $this->session->userdata('user_code'), $rr->co_target_days, $rr->assigned_date, $rr->date_entry, $rr->next_date_of_hearing, $rr->status, $rr->lm_note_yn, $rr->notice_generated_yn, $rr->sk_comment, $rr->proceeding_yn, $rr->is_escalated);

                // var_dump($variable); die;

                if (!empty($variable)) {
                    $final_array[] = $variable;
                }
            }

            $data['data_results'] = $final_array;
            $data['total_records'] = count($final_array);

            if (!empty($mouza_code)) {
                $this->db->where('mouza_pargona_code', $mouza_code);
            }
            if (!empty($lot_no)) {
                $this->db->where('lot_no', $lot_no);
            }
            if (!empty($vill_mouza_code)) {
                $this->db->where('mouza_pargona_code', $vill_mouza_code);
            }
            if (!empty($vill_lot_no)) {
                $this->db->where('lot_no', $vill_lot_no);
            }
            if (!empty($village_code)) {
                $this->db->where('vill_townprt_code', $village_code);
            }
            if (!empty($searchByCol_0)) {
                $this->db->like('case_no', strtoupper($searchByCol_0));
            }
            $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
            $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('petition_basic.status', null);
            $this->db->where('petition_basic.comp_serv_yn', null);
            $this->db->where('petition_basic.not_fresh', null);
            $this->db->where('petition_basic.lm_note_yn', null);
            $this->db->where('petition_basic.mut_type', '03');
            $this->db->where('date(date_entry) >=', $define_date);

            if ($zone_status == 4) {
                $this->db->where('petition_basic.es_flag', 0);
            } else {
                $this->db->where('petition_basic.es_flag', 1);
            }

            $res = $this->db->get('petition_basic')->result();

            $cc = array();

            foreach ($res as $r) {

                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->co_target_days;

                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }
            $data['total_records'] = count($cc);
            return $data;
        }
    }

    public function getEscalationZoneDetails($es_flag, $user_code, $target_days, $assigned_date, $esc_date, $date_entry)
    {
        //log_message('error','******************es_flag: '.$es_flag.', user code: '.$user_code.', target_days: '.$target_days.', assigned_date: '.$assigned_date.', esc_date: '.$esc_date.', date_entry: '. $date_entry.', session user code: '.$this->session->userdata('user_code'));

        $curr_date = date('Y-m-d H:i:s');
        if($esc_date == null)
        {
            $remaining_days = 0;
        }
        else
        {
            if($esc_date == 'ESCALATED' && $assigned_date =='ESCALATED')
            {
                $remaining_days = 0;
            }
            else
            {
                $remaining_days = $this->dateDiff($esc_date, $curr_date);
            }
            
        }
        
        // log_message('error','=============********===='.json_encode($remaining_days));
        $json = array();
        $percentage_availability = '';
        $esc_zone = '';

        if ($es_flag == 1 && $target_days != null && $target_days != 0) {

            $percentage_availability = (100 * $remaining_days) / $target_days;
            // log_message('error','=============********===='.json_encode($percentage_availability));
            if ($percentage_availability <= RED_ZONE) {
                $esc_zone = '<i class="fa fa-circle text-red"></i>';
                $zone_color = COL_RED;
            }
            if ($percentage_availability >= RED_ZONE && $percentage_availability <= YELLOW_ZONE) {
                $esc_zone = '<i class="fa fa-circle text-orange"></i>';
                $zone_color = COL_YELLOW;
            }
            if ($percentage_availability >= YELLOW_ZONE) {
                $esc_zone = '<i class="fa fa-circle text-green"></i>';
                $zone_color = COL_GREEN;
            }
            $json = [
                'escalation_zone' => $esc_zone,
                'escalation_date' => $esc_date . "<br>" . ' ' . $remaining_days . ' days left',
                'assigned_date' => $assigned_date,
                'zone_color' => $zone_color,
            ];
        } else {
            $json = [
                'escalation_zone' => 'NA',
                'escalation_date' => 'NA',
                'assigned_date' => date('Y-m-d H:i:s', strtotime($date_entry)),
                'zone_color' => '',
            ];
        }

        // for log data
        $log_json = ['es_flag' => $es_flag, 'user_code' => $user_code, 'target_days' => $target_days,
            'assigned_date' => $assigned_date, 'esc_date' => $esc_date, 'date_entry' => $date_entry,
            'percentage' => $percentage_availability, 'remaining_days' => $remaining_days,
        ];
        // log_message('error', '====================================56'.json_encode($json));
        //log_message('error', '#1501, EscalationModel == Data: '.json_encode($log_json));

        return json_encode($json);
    }

    public function escalationZoneWiseSearch($zone_status, $es_flag, $c_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $rtps_no, $submission_date, $escalated_date, $user_code, $co_target_days, $assigned_date, $date_entry, $next_date_of_hearing, $status, $lm_note_yn, $notice_generated_yn, $sk_comment, $proceeding_yn, $is_escalated)
    {

        $curr_date = date('Y-m-d');
        $esc_date = $escalated_date;
        $esc_flag = $es_flag;
        $final_array = '';

        if (!empty($zone_status) && ($esc_date != null || $esc_date != '') && ($esc_flag == 1)) {
            log_message('error', '---1');
            $remaining_days = $this->dateDiff($esc_date, $curr_date);
            $per_avail = (100 * $remaining_days) / $co_target_days;

            //green zone
            if (($zone_status == 1) && ($per_avail >= YELLOW_ZONE)) {
                $final_array = (object) [
                    'case_no' => $c_no,
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'basundhara' => $rtps_no,
                    'submission_date' => $submission_date,
                    'escalated_date' => $escalated_date,
                    'es_flag' => $es_flag,
                    'assigned_from' => $user_code,
                    'co_target_days' => $co_target_days,
                    'assigned_date' => $assigned_date,
                    'date_entry' => $date_entry,
                    'application_ref_no' => $rtps_no,
                    'next_date_of_hearing' => $next_date_of_hearing,
                    'status' => $status,
                    'lm_note_yn' => $lm_note_yn,
                    'notice_generated_yn' => $notice_generated_yn,
                    'sk_comment' => $sk_comment,
                    'proceeding_yn' => $proceeding_yn,
                    'is_escalated' => $is_escalated,
                ];
            }

            //yellow zone
            else if (($zone_status == 2) && (($per_avail < YELLOW_ZONE) && ($per_avail > RED_ZONE))) {
                log_message('error', '---2');
                $final_array = (object) [
                    'case_no' => $c_no,
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'basundhara' => $rtps_no,
                    'submission_date' => $submission_date,
                    'escalated_date' => $escalated_date,
                    'es_flag' => $es_flag,
                    'assigned_from' => $user_code,
                    'co_target_days' => $co_target_days,
                    'assigned_date' => $assigned_date,
                    'date_entry' => $date_entry,
                    'application_ref_no' => $rtps_no,
                    'next_date_of_hearing' => $next_date_of_hearing,
                    'status' => $status,
                    'lm_note_yn' => $lm_note_yn,
                    'notice_generated_yn' => $notice_generated_yn,
                    'sk_comment' => $sk_comment,
                    'proceeding_yn' => $proceeding_yn,
                    'is_escalated' => $is_escalated,
                ];
            }

            //red zone
            else if (($zone_status == 3) && ($per_avail <= RED_ZONE)) {
                log_message('error', '---3');
                $final_array = (object) [
                    'case_no' => $c_no,
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'basundhara' => $rtps_no,
                    'submission_date' => $submission_date,
                    'escalated_date' => $escalated_date,
                    'es_flag' => $es_flag,
                    'assigned_from' => $user_code,
                    'co_target_days' => $co_target_days,
                    'assigned_date' => $assigned_date,
                    'date_entry' => $date_entry,
                    'application_ref_no' => $rtps_no,
                    'next_date_of_hearing' => $next_date_of_hearing,
                    'status' => $status,
                    'lm_note_yn' => $lm_note_yn,
                    'notice_generated_yn' => $notice_generated_yn,
                    'sk_comment' => $sk_comment,
                    'proceeding_yn' => $proceeding_yn,
                    'is_escalated' => $is_escalated,
                ];
            }

            //old cases
            else if ($zone_status == 4) {
                log_message('error', '---4');
                $final_array = (object) [
                    'case_no' => $c_no,
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'basundhara' => $rtps_no,
                    'submission_date' => $submission_date,
                    'escalated_date' => $escalated_date,
                    'es_flag' => $es_flag,
                    'assigned_from' => $user_code,
                    'co_target_days' => $co_target_days,
                    'assigned_date' => $assigned_date,
                    'date_entry' => $date_entry,
                    'application_ref_no' => $rtps_no,
                    'next_date_of_hearing' => $next_date_of_hearing,
                    'status' => $status,
                    'lm_note_yn' => $lm_note_yn,
                    'notice_generated_yn' => $notice_generated_yn,
                    'sk_comment' => $sk_comment,
                    'proceeding_yn' => $proceeding_yn,
                    'is_escalated' => $is_escalated,
                ];
            }
        } else {
            log_message('error', '---5');
            $final_array = (object) [
                'case_no' => $c_no,
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'basundhara' => $rtps_no,
                'submission_date' => $submission_date,
                'escalated_date' => $escalated_date,
                'es_flag' => $es_flag,
                'assigned_from' => $user_code,
                'co_target_days' => $co_target_days,
                'assigned_date' => $assigned_date,
                'date_entry' => $date_entry,
                'application_ref_no' => $rtps_no,
                'next_date_of_hearing' => $next_date_of_hearing,
                'status' => $status,
                'lm_note_yn' => $lm_note_yn,
                'notice_generated_yn' => $notice_generated_yn,
                'sk_comment' => $sk_comment,
                'proceeding_yn' => $proceeding_yn,
                'is_escalated' => $is_escalated,
            ];
        }

        return $final_array;
    }

    public function getPendingMutationCasesLmEnd($fresh, $mut_type, $status, $location)
    {

        $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');
        $this->db->where($location);
        $this->db->where('petition_basic.not_fresh', $fresh);
        $this->db->where('petition_basic.notice_generated_yn', null);
        $this->db->where('petition_basic.status', $status);
        $this->db->where('petition_basic.mut_type', $mut_type);
        $this->db->order_by('submission_date', 'desc');
        $query = $this->db->get('petition_basic');

        log_message('error', "****************************************************");
        log_message('error', "petition_basic: " . $this->db->last_query());
        log_message('error', "****************************************************");

        return $query;
    }

    public function getEscalationZoneDetailsOfCaseNo($es_flag, $user_code, $target_days, $assigned_date, $esc_date, $date_entry, $case_no)
    {

        $curr_date = date('Y-m-d');
        $remaining_days = $this->dateDiff($esc_date, $curr_date);

        if ($es_flag == 1 && $user_code == $this->session->userdata('user_code')) {

            $percentage_availability = (100 * $remaining_days) / $target_days;

            if ($percentage_availability <= RED_ZONE) {
                $esc_zone = '<i class="fa fa-circle text-red"></i>';
            }
            if ($percentage_availability >= RED_ZONE && $percentage_availability <= YELLOW_ZONE) {
                $esc_zone = '<i class="fa fa-circle text-orange"></i>';
            }
            if ($percentage_availability >= YELLOW_ZONE) {
                $esc_zone = '<i class="fa fa-circle text-green"></i>';
            }
            $json = [
                'escalation_zone' => $esc_zone,
                'escalation_date' => $esc_date . "<br>" . ' ' . $remaining_days . ' days left',
                'assigned_date' => $assigned_date,
            ];
        } else if ($es_flag == 0) {
            $json = [
                'escalation_zone' => 'NA',
                'escalation_date' => 'NA',
                'assigned_date' => date('Y-m-d', strtotime($date_entry)),
            ];
        }

        // for log data
        $log_json = ['es_flag' => $es_flag, 'user_code' => $user_code, 'target_days' => $target_days,
            'assigned_date' => $assigned_date, 'esc_date' => $esc_date, 'date_entry' => $date_entry,
            'percentage' => $percentage_availability, 'remaining_days' => $remaining_days,
        ];
        log_message('error', '====================================');
        log_message('error', 'Data: ' . json_encode($log_json));

        return json_encode($json);
    }

    public function searchByEscalationZone()
    {

        // $query ="Select *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree  where fmb.not_fresh='Y' and notice_generated_yn is null and fmb.mut_type='03' and fmb.status='P' and $append  order by submission_date desc  ";

        // $this->base_query = "dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'  and date(date_entry)>='$defined_date'";

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $draw = intval($this->input->post('draw'));
        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        $define_date = define_date;
        $zone_status = $this->input->post('zone_status');

        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 'petition_basic.petition_no',
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
            $this->db->where("(application_ref_no like '%$searchByCol_0%' or case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }
        $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');
        $this->db->where('petition_basic.dist_code', $dist_code);
        $this->db->where('petition_basic.subdiv_code', $subdiv_code);
        $this->db->where('petition_basic.cir_code', $cir_code);
        $this->db->where('date(date_entry) >=', $define_date);
        $this->db->where('petition_basic.not_fresh', 'Y');
        $this->db->where('petition_basic.notice_generated_yn', null);
        $this->db->where('petition_basic.mut_type', '03');
        $this->db->where('petition_basic.status', 'P');

        if ($zone_status == 4) {
            $this->db->where('petition_basic.es_flag', 0);
        } else {
            $this->db->where('petition_basic.es_flag', 1);
        }

        $this->db->limit($length, $start);
        $query = $this->db->get('petition_basic');
        log_message('error', "petition_basic: " . $this->db->last_query());

        // echo $this->db->last_query();

        if ($query->num_rows() > 0) {

            $data_results = $query->result();
            $final_array = array();

            foreach ($data_results as $rr) {
                $variable = $this->escalationZoneWiseSearch($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->submission_date, $rr->escalated_date, $this->session->userdata('user_code'), $rr->co_target_days, $rr->assigned_date, $rr->date_entry, $rr->next_date_of_hearing, $rr->status, $rr->lm_note_yn, $rr->notice_generated_yn, $rr->sk_comment, $rr->proceeding_yn, $rr->is_escalated);

                if (!empty($variable)) {
                    $final_array[] = $variable;
                }
            }

            $data['data_results'] = $final_array;
            // $data['total_records'] = count($final_array);

            if (!empty($searchByCol_0)) {
                $this->db->like('case_no', strtoupper($searchByCol_0));
            }
            $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
            $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');
            $this->db->where('petition_basic.dist_code', $dist_code);
            $this->db->where('petition_basic.subdiv_code', $subdiv_code);
            $this->db->where('petition_basic.cir_code', $cir_code);
            $this->db->where('date(date_entry) >=', $define_date);
            $this->db->where('petition_basic.not_fresh', 'Y');
            $this->db->where('petition_basic.notice_generated_yn', null);
            $this->db->where('petition_basic.mut_type', '03');
            $this->db->where('petition_basic.status', 'P');
            if ($zone_status == 4) {
                $this->db->where('petition_basic.es_flag', 0);
            } else {
                $this->db->where('petition_basic.es_flag', 1);
            }
            $res = $this->db->get('petition_basic')->result();

            $cc = array();

            foreach ($res as $r) {

                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->co_target_days;

                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }

            $data['total_records'] = count($cc);
            // return $data;
        }

        if (isset($res)) {
            $data_rows = $results['data_results'];

            $total_records = count($cc);

            if ($total_records > 0) {
                // log_message('error', '#5521: Data details : '.json_encode($data_rows));
                foreach ($data_rows as $rows) {
                    // echo "<pre>";
                    // var_dump($rows);
                    log_message("error", "MRIG001: ==========" . json_encode($rows));
                    if ($rows->es_flag == '1') {

                        $escRow = $this->getEscalatedRowDetailsCaseNo($rows->case_no);

                        $escData = json_decode($this->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));

                        // log_message('error', '#5531: Escalation details : '.json_encode($escData));

                        $rows->escalation_date = $escData->escalation_date;
                        $rows->escalation_zone = $escData->escalation_zone;
                        $rows->assigned_date = $escData->assigned_date;
                    } else {
                        $rows->escalation_date = 'NA';
                        $rows->escalation_zone = 'NA';
                    }

                    $link = base_url() . "index.php/coofficemutation/proceeding1?case_no=" . $rows->case_no . "&dist_code=" . $rows->dist_code . "&subdiv_code=" . $rows->subdiv_code . "&cir_code=" . $rows->cir_code . "&mouza_pargona_code=" . $rows->mouza_pargona_code . "&lot_no=" . $rows->lot_no . "&vill_townprt_code=" . $rows->vill_townprt_code;

                    $button = "<a href=" . $link . " class='btn btn-success'>" . $this->lang->line("write_report") . "</a>";
                    $mouza_lot = $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code) . "-" . $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no);

                    $e = $rows->application_ref_no != null ? $rows->application_ref_no : $rows->basundhara;
                    $json[] = array(

                        $rows->escalation_zone,
                        $rows->escalation_date,

                        $rows->case_no . "<br><span class='small font-italic red'>" . $e . "</span>",
                        $mouza_lot,
                        $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),
                        date('M jS, Y', strtotime($rows->date_entry)),
                        $button,
                    );
                }
            } else {
                $json = "";
            }

            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json,
            );
            echo json_encode($response);
        } else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }

    public function getPendingMutationCasesDaEnd($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status, $work_type)
    {

        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 'petition_basic.petition_no',
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
            $this->db->where("(application_ref_no like '%$searchByCol_0%' or case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }
        $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');
        $this->db->where('petition_basic.dist_code', $dist_code);
        $this->db->where('petition_basic.subdiv_code', $subdiv_code);
        $this->db->where('petition_basic.cir_code', $cir_code);
        $this->db->where('date(date_entry) >=', $define_date);

        if ($work_type == 'notice_generate') {
            $this->db->where('petition_basic.not_fresh', 'Y');
            $this->db->where('petition_basic.notice_generated_yn', null);
            $this->db->where('petition_basic.mut_type', '03');
            $this->db->where('petition_basic.status', 'P');
        } else if ($work_type == 'action_taken') {
            $this->db->where('petition_basic.not_fresh', 'Y');
            $this->db->where('petition_basic.mut_type', '03');
            $this->db->where('petition_basic.proceeding_yn', null);
            $this->db->where('petition_basic.status !=', 'F');
        }

        if ($zone_status == 4) {
            $this->db->where('petition_basic.es_flag', 0);
        } else {
            $this->db->where('petition_basic.es_flag', 1);
        }

        $this->db->limit($length, $start);
        $query = $this->db->get('petition_basic');
        log_message('error', "petition_basic: " . $this->db->last_query());

        if ($query->num_rows() > 0) {

            $data_results = $query->result();
            $final_array = array();

            foreach ($data_results as $rr) {
                $variable = $this->escalationZoneWiseSearch($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->submission_date, $rr->assigned_other_es_date, $this->session->userdata('user_code'), $rr->da_target_days, $rr->assigned_other_date, $rr->date_entry, $rr->next_date_of_hearing, $rr->status, $rr->lm_note_yn, $rr->notice_generated_yn, $rr->sk_comment, $rr->proceeding_yn, $rr->is_escalated);

                if (!empty($variable)) {
                    $final_array[] = $variable;
                }
            }

            $data['data_results'] = $final_array;
            $data['total_records'] = count($final_array);

            if (!empty($searchByCol_0)) {
                $this->db->like('case_no', strtoupper($searchByCol_0));
            }

            $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
            $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');
            $this->db->where('petition_basic.dist_code', $dist_code);
            $this->db->where('petition_basic.subdiv_code', $subdiv_code);
            $this->db->where('petition_basic.cir_code', $cir_code);
            $this->db->where('date(date_entry) >=', $define_date);

            if ($work_type == 'notice_generate') {
                $this->db->where('petition_basic.not_fresh', 'Y');
                $this->db->where('petition_basic.notice_generated_yn', null);
                $this->db->where('petition_basic.mut_type', '03');
                $this->db->where('petition_basic.status', 'P');
            } else if ($work_type == 'action_taken') {
                $this->db->where('petition_basic.not_fresh', 'Y');
                $this->db->where('petition_basic.mut_type', '03');
                $this->db->where('petition_basic.proceeding_yn', null);
                $this->db->where('petition_basic.status !=', 'F');
            }

            if ($zone_status == 4) {
                $this->db->where('petition_basic.es_flag', 0);
            } else {
                $this->db->where('petition_basic.es_flag', 1);
            }

            $res = $this->db->get('petition_basic')->result();

            $cc = array();

            foreach ($res as $r) {

                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->co_target_days;

                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }

            $data['total_records'] = count($cc);
            return $data;
        }
    }

    public function getPendingOfficeMutationCasesForLm($dist_code, $subdiv_code, $cir_code, $lot_no, $mouza, $start, $length, $order, $define_date, $searchByCol_0, $zone_status)
    {
        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 'petition_basic.petition_no',
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
            $this->db->where("(application_ref_no like '%$searchByCol_0%' or case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }
        $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');

        $this->db->where('petition_basic.dist_code', $dist_code);
        $this->db->where('petition_basic.subdiv_code', $subdiv_code);
        $this->db->where('petition_basic.cir_code', $cir_code);
        $this->db->where('petition_basic.lot_no', $lot_no);
        $this->db->where('petition_basic.mouza_pargona_code', $mouza);
        $this->db->where('date(date_entry) >=', $define_date);
        $this->db->where('petition_basic.lm_note_date', null);
        $this->db->where('petition_basic.not_fresh', 'Y');
        $this->db->where('petition_basic.sk_comment', null);
        $this->db->where('petition_basic.order_passed', null);
        $this->db->where('petition_basic.mut_type', '03');
        $this->db->where('petition_basic.status', 'P');

        if ($zone_status == 4) {
            $this->db->where('petition_basic.es_flag', 0);
        } else {
            $this->db->where('petition_basic.es_flag', 1);
        }

        $this->db->limit($length, $start);
        $query = $this->db->get('petition_basic');
        log_message('error', "petition_basic: " . $this->db->last_query());

        if ($query->num_rows() > 0) {

            $data_results = $query->result();
            $final_array = array();

            foreach ($data_results as $rr) {
                $variable = $this->escalationZoneWiseSearch($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->submission_date, $rr->assigned_other_es_date, $this->session->userdata('user_code'), $rr->da_target_days, $rr->assigned_other_date, $rr->date_entry, $rr->next_date_of_hearing, $rr->status, $rr->lm_note_yn, $rr->notice_generated_yn, $rr->sk_comment, $rr->proceeding_yn, $rr->is_escalated);

                if (!empty($variable)) {
                    $final_array[] = $variable;
                }
            }

            $data['data_results'] = $final_array;
            $data['total_records'] = count($final_array);

            if (!empty($searchByCol_0)) {
                $this->db->like('case_no', strtoupper($searchByCol_0));
            }

            $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
            $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');

            $this->db->where('petition_basic.dist_code', $dist_code);
            $this->db->where('petition_basic.subdiv_code', $subdiv_code);
            $this->db->where('petition_basic.cir_code', $cir_code);
            $this->db->where('petition_basic.lot_no', $lot_no);
            $this->db->where('petition_basic.mouza_pargona_code', $mouza);
            $this->db->where('date(date_entry) >=', $define_date);
            $this->db->where('petition_basic.lm_note_date', null);
            $this->db->where('petition_basic.not_fresh', 'Y');
            $this->db->where('petition_basic.sk_comment', null);
            $this->db->where('petition_basic.order_passed', null);
            $this->db->where('petition_basic.mut_type', '03');
            $this->db->where('petition_basic.status', 'P');

            if ($zone_status == 4) {
                $this->db->where('petition_basic.es_flag', 0);
            } else {
                $this->db->where('petition_basic.es_flag', 1);
            }

            $res = $this->db->get('petition_basic')->result();

            $cc = array();

            foreach ($res as $r) {

                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->co_target_days;

                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }

            $data['total_records'] = count($cc);
            return $data;
        }
    }

    public function getPendingOfficeMutationCasesForSk($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status)
    {
        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 'petition_basic.petition_no',
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
            $this->db->where("(application_ref_no like '%$searchByCol_0%' or case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }
        $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');

        $this->db->where('petition_basic.dist_code', $dist_code);
        $this->db->where('petition_basic.subdiv_code', $subdiv_code);
        $this->db->where('petition_basic.cir_code', $cir_code);
        $this->db->where('date(date_entry) >=', $define_date);
        $this->db->where('petition_basic.not_fresh', 'Y');
        $this->db->where('petition_basic.sk_comment', null);
        $this->db->where('petition_basic.lm_note_date IS NOT NULL');
        $this->db->where('petition_basic.order_passed', null);
        $this->db->where('petition_basic.mut_type', '03');
        $this->db->where('petition_basic.status !=', 'D');

        if ($zone_status == 4) {
            $this->db->where('petition_basic.es_flag', 0);
        } else {
            $this->db->where('petition_basic.es_flag', 1);
        }

        $this->db->limit($length, $start);
        $query = $this->db->get('petition_basic');
        log_message('error', "petition_basic: " . $this->db->last_query());

        if ($query->num_rows() > 0) {

            $data_results = $query->result();
            $final_array = array();

            foreach ($data_results as $rr) {
                $variable = $this->escalationZoneWiseSearch($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->submission_date, $rr->assigned_other_es_date, $this->session->userdata('user_code'), $rr->da_target_days, $rr->assigned_other_date, $rr->date_entry, $rr->next_date_of_hearing, $rr->status, $rr->lm_note_yn, $rr->notice_generated_yn, $rr->sk_comment, $rr->proceeding_yn, $rr->is_escalated);

                if (!empty($variable)) {
                    $final_array[] = $variable;
                }
            }
            log_message('error', '------------FINALARRAY------' . json_encode($this->session->userdata('user_code')));
            $data['data_results'] = $final_array;
            $data['total_records'] = count($final_array);

            if (!empty($searchByCol_0)) {
                $this->db->like('case_no', strtoupper($searchByCol_0));
            }

            $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
            $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');

            $this->db->where('petition_basic.dist_code', $dist_code);
            $this->db->where('petition_basic.subdiv_code', $subdiv_code);
            $this->db->where('petition_basic.cir_code', $cir_code);
            $this->db->where('date(date_entry) >=', $define_date);
            $this->db->where('petition_basic.not_fresh', 'Y');
            $this->db->where('petition_basic.sk_comment', null);
            $this->db->where('petition_basic.lm_note_date IS NOT NULL');
            $this->db->where('petition_basic.order_passed', null);
            $this->db->where('petition_basic.mut_type', '03');
            $this->db->where('petition_basic.status !=', 'D');

            if ($zone_status == 4) {
                $this->db->where('petition_basic.es_flag', 0);
            } else {
                $this->db->where('petition_basic.es_flag', 1);
            }

            $res = $this->db->get('petition_basic')->result();

            $cc = array();

            foreach ($res as $r) {

                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->co_target_days;

                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }

            $data['total_records'] = count($cc);
            return $data;
        }
    }

    public function getSecondProceedPendingMutationCasesCoEnd($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $mouza_code, $lot_no, $define_date, $zone_status, $searchByCol_0)
    {
        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 'petition_basic.petition_no',
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
            $this->db->where("(application_ref_no like '%$searchByCol_0%' or case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }
        if (!empty($mouza_code)) {
            $this->db->where('mouza_pargona_code', $mouza_code);
        }
        if (!empty($lot_no)) {
            $this->db->where('lot_no', $lot_no);
        }

        $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
        $this->db->join('landsale', 'petition_basic.noc_no = landsale.appno', 'left');
        $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');

        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('date(date_entry) >=', $define_date);
        $this->db->where('petition_basic.not_fresh', 'Y');
        $this->db->where('petition_basic.status', 'P');
        $this->db->where('petition_basic.mut_type', '03');
        $this->db->where('petition_basic.comp_serv_yn', null);

        if ($zone_status == 4) {
            $this->db->where('petition_basic.es_flag', 0);
        } else {
            $this->db->where('petition_basic.es_flag', 1);
        }

        $this->db->limit($length, $start);
        $query = $this->db->get('petition_basic');
        log_message('error', "petition_basic: " . $this->db->last_query());

        if ($query->num_rows() > 0) {

            $data_results = $query->result();
            $final_array = array();

            foreach ($data_results as $rr) {
                $variable = $this->escalationZoneWiseSearch($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->submission_date, $rr->escalated_date, $this->session->userdata('user_code'), $rr->co_target_days, $rr->assigned_date, $rr->date_entry, $rr->next_date_of_hearing, $rr->status, $rr->lm_note_yn, $rr->notice_generated_yn, $rr->sk_comment, $rr->proceeding_yn, $rr->is_escalated);

                if (!empty($variable)) {
                    $final_array[] = $variable;
                }
            }

            $data['data_results'] = $final_array;
            $data['total_records'] = count($final_array);

            if (!empty($mouza_code)) {
                $this->db->where('mouza_pargona_code', $mouza_code);
            }
            if (!empty($lot_no)) {
                $this->db->where('lot_no', $lot_no);
            }
            if (!empty($searchByCol_0)) {
                $this->db->like('case_no', strtoupper($searchByCol_0));
            }

            $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
            $this->db->join('landsale', 'petition_basic.noc_no = landsale.appno', 'left');
            $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');

            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('date(date_entry) >=', $define_date);
            $this->db->where('petition_basic.not_fresh', 'Y');
            $this->db->where('petition_basic.status', 'P');
            $this->db->where('petition_basic.mut_type', '03');
            $this->db->where('petition_basic.comp_serv_yn', null);

            if ($zone_status == 4) {
                $this->db->where('petition_basic.es_flag', 0);
            } else {
                $this->db->where('petition_basic.es_flag', 1);
            }
            $res = $this->db->get('petition_basic')->result();

            $cc = array();

            foreach ($res as $r) {

                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->co_target_days;

                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }
            $data['total_records'] = count($cc);
            return $data;
        }
    }

    public function escalationZoneWiseSearchFieldCase($zone_status, $es_flag, $c_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $rtps_no, $submission_date, $escalated_date, $user_code, $target_days, $assigned_date, $date_entry, $mut_type, $is_multigeneration, $is_escalated)
    {

        $curr_date = date('Y-m-d');
        $esc_date = $escalated_date;
        $esc_flag = $es_flag;
        $final_array = '';

        if (!empty($zone_status) && ($esc_date != null || $esc_date != '') && ($esc_flag == 1)) {
            $remaining_days = $this->dateDiff($esc_date, $curr_date);
            $per_avail = (100 * $remaining_days) / $target_days;

            //green zone
            if (($zone_status == 1) && ($per_avail >= YELLOW_ZONE)) {

                $final_array = (object) [
                    'case_no' => $c_no,
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'basundhara' => $rtps_no,
                    'report_date' => $submission_date,
                    'escalated_date' => $escalated_date,
                    'es_flag' => $es_flag,
                    'assigned_from' => $user_code,
                    'co_target_days' => $target_days,
                    'assigned_date' => $assigned_date,
                    'date_entry' => $date_entry,
                    'application_ref_no' => $rtps_no,
                    'mut_type' => $mut_type,
                    'is_multigeneration' => $is_multigeneration,
                    'is_escalated' => $is_escalated,

                ];

                log_message('error', '#2564 : Green Zone ' . json_encode($final_array));
            }

            //yellow zone
            else if (($zone_status == 2) && (($per_avail < YELLOW_ZONE) && ($per_avail > RED_ZONE))) {
                $final_array = (object) [
                    'case_no' => $c_no,
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'basundhara' => $rtps_no,
                    'report_date' => $submission_date,
                    'escalated_date' => $escalated_date,
                    'es_flag' => $es_flag,
                    'assigned_from' => $user_code,
                    'co_target_days' => $target_days,
                    'assigned_date' => $assigned_date,
                    'date_entry' => $date_entry,
                    'application_ref_no' => $rtps_no,
                    'mut_type' => $mut_type,
                    'is_multigeneration' => $is_multigeneration,
                    'is_escalated' => $is_escalated,
                ];

                log_message('error', '#2589 : Yellow Zone ' . json_encode($final_array));
            }

            //red zone
            else if (($zone_status == 3) && ($per_avail <= RED_ZONE)) {
                $final_array = (object) [
                    'case_no' => $c_no,
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'basundhara' => $rtps_no,
                    'report_date' => $submission_date,
                    'escalated_date' => $escalated_date,
                    'es_flag' => $es_flag,
                    'assigned_from' => $user_code,
                    'co_target_days' => $target_days,
                    'assigned_date' => $assigned_date,
                    'date_entry' => $date_entry,
                    'application_ref_no' => $rtps_no,
                    'mut_type' => $mut_type,
                    'is_multigeneration' => $is_multigeneration,
                    'is_escalated' => $is_escalated,
                ];

                log_message('error', '#2614 : Red Zone ' . json_encode($final_array));
            }

            //old cases
            else if ($zone_status == 4) {
                $final_array = (object) [
                    'case_no' => $c_no,
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'basundhara' => $rtps_no,
                    'report_date' => $submission_date,
                    'escalated_date' => $escalated_date,
                    'es_flag' => $es_flag,
                    'assigned_from' => $user_code,
                    'co_target_days' => $target_days,
                    'assigned_date' => $assigned_date,
                    'date_entry' => $date_entry,
                    'application_ref_no' => $rtps_no,
                    'mut_type' => $mut_type,
                    'is_multigeneration' => $is_multigeneration,
                    'is_escalated' => $is_escalated,
                ];

                log_message('error', '#2639 : Old Cases ' . json_encode($final_array));
            }
        } else {
            $final_array = (object) [
                'case_no' => $c_no,
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'basundhara' => $rtps_no,
                'report_date' => $submission_date,
                'escalated_date' => $escalated_date,
                'es_flag' => $es_flag,
                'assigned_from' => $user_code,
                'co_target_days' => $target_days,
                'assigned_date' => $assigned_date,
                'date_entry' => $date_entry,
                'application_ref_no' => $rtps_no,
                'mut_type' => $mut_type,
                'is_multigeneration' => $is_multigeneration,
                'is_escalated' => $is_escalated,
            ];

            log_message('error', '#2664 : Others ' . json_encode($final_array));
        }

        return $final_array;
    }

    //get pending office partition cases in co end--------SEARCH-13022023
    public function getPendingFieldMutCaseLMend($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $mouza_code, $lot_no, $vill_mouza_code, $vill_lot_no, $village_code, $searchByCol_0, $zone_status)
    {
        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 'field_mut_basic.petition_no',
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
            $this->db->where("(case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }
        if (!empty($mouza_code)) {
            $this->db->where('mouza_pargona_code', $mouza_code);
        }
        if (!empty($lot_no)) {
            $this->db->where('lot_no', $lot_no);
        }
        if (!empty($vill_mouza_code)) {
            $this->db->where('mouza_pargona_code', $vill_mouza_code);
        }
        if (!empty($vill_lot_no)) {
            $this->db->where('lot_no', $vill_lot_no);
        }
        if (!empty($village_code)) {
            $this->db->where('vill_townprt_code', $village_code);
        }

        $this->db->select('field_mut_basic.*, field_mut_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 'field_mut_basic.case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 'field_mut_basic.case_no = escalation_details.case_no', 'left');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('field_mut_basic.possession_yn', null);
        $this->db->where('field_mut_basic.lm_note', null);
        $this->db->where('field_mut_basic.mut_type', '01');

        if ($zone_status == 4) { // for old cases
            $this->db->where('field_mut_basic.es_flag', 0);
        } else {
            $this->db->where('field_mut_basic.es_flag', 1);
        }
        $this->db->limit($length, $start);
        $query = $this->db->get('field_mut_basic');
        log_message('error', "Field Mut Basic : " . $this->db->last_query());

        if ($query->num_rows() > 0) {

            $data_results = $query->result();
            $final_array = array();

            foreach ($data_results as $rr) {
                $variable = $this->escalationZoneWiseSearchFieldCase($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->report_date, $rr->escalated_date, $this->session->userdata('user_code'), $rr->lm_target_days, $rr->assigned_date, $rr->date_entry, $rr->mut_type, $rr->is_multigeneration, $rr->is_escalated);

                if (!empty($variable)) {
                    $final_array[] = $variable;
                }
            }

            $data['data_results'] = $final_array;

            $data['total_records'] = count($final_array);

            if (!empty($mouza_code)) {
                $this->db->where('mouza_pargona_code', $mouza_code);
            }
            if (!empty($lot_no)) {
                $this->db->where('lot_no', $lot_no);
            }
            if (!empty($vill_mouza_code)) {
                $this->db->where('mouza_pargona_code', $vill_mouza_code);
            }
            if (!empty($vill_lot_no)) {
                $this->db->where('lot_no', $vill_lot_no);
            }
            if (!empty($village_code)) {
                $this->db->where('vill_townprt_code', $village_code);
            }
            if (!empty($searchByCol_0)) {
                $this->db->like('case_no', strtoupper($searchByCol_0));
            }
            $this->db->select('field_mut_basic.*, field_mut_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 'field_mut_basic.case_no = basundhar_application.dharitree', 'left');
            $this->db->join('escalation_details', 'field_mut_basic.case_no = escalation_details.case_no', 'left');
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('field_mut_basic.possession_yn', null);
            $this->db->where('field_mut_basic.lm_note', null);
            $this->db->where('field_mut_basic.mut_type', '01');
            if ($zone_status == 4) { // for old cases
                $this->db->where('field_mut_basic.es_flag', 0);
            } else {
                $this->db->where('field_mut_basic.es_flag', 1);
            }

            $res = $this->db->get('field_mut_basic')->result();

            $cc = array();

            foreach ($res as $r) {

                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->co_target_days;

                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }

            $data['total_records'] = count($cc);
            return $data;
        }
    }

    public function getPendingFieldMutationCasesCoEnd($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status)
    {

        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 'field_mut_basic.petition_no',
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
            $this->db->where("(application_ref_no like '%$searchByCol_0%' or case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }

        $this->db->select('field_mut_basic.*, field_mut_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 'field_mut_basic.case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 'field_mut_basic.case_no = escalation_details.case_no', 'left');

        $this->db->where('field_mut_basic.dist_code', $dist_code);
        $this->db->where('field_mut_basic.subdiv_code', $subdiv_code);
        $this->db->where('field_mut_basic.cir_code', $cir_code);
        $this->db->where('date(date_entry) >=', $define_date);

        $this->db->where('field_mut_basic.order_passed', null);
        $this->db->where('field_mut_basic.is_dispose', null);
        $this->db->where('field_mut_basic.mut_type', '01');
        $this->db->where('field_mut_basic.lm_note IS NOT NULL');

        if ($zone_status == 4) {
            $this->db->where('field_mut_basic.es_flag', 0);
        } else {
            $this->db->where('field_mut_basic.es_flag', 1);
        }

        $this->db->limit($length, $start);
        $query = $this->db->get('field_mut_basic');

        // echo $this->db->last_query();

        log_message('error', "field_mut_basic: " . $this->db->last_query());

        if ($query->num_rows() > 0) {

            $data_results = $query->result();
            $final_array = array();

            // echo "<pre>";
            // var_dump($data_results);

            foreach ($data_results as $rr) {
                $variable = $this->escalationZoneWiseSearchFieldCase($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->report_date, $rr->escalated_date, $this->session->userdata('user_code'), $rr->co_target_days, $rr->assigned_date, $rr->date_entry, $rr->mut_type);

                if (!empty($variable)) {
                    $final_array[] = $variable;
                }

                // echo "<pre>";
                // var_dump($data_results);
            }

            $data['data_results'] = $final_array;
            // $data['total_records'] = count($final_array);

            // var_dump($data['data_results']);

            if (!empty($searchByCol_0)) {
                $this->db->like('case_no', strtoupper($searchByCol_0));
            }

            $this->db->select('field_mut_basic.*, field_mut_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 'field_mut_basic.case_no = basundhar_application.dharitree', 'left');
            $this->db->join('escalation_details', 'field_mut_basic.case_no = escalation_details.case_no', 'left');

            $this->db->where('field_mut_basic.dist_code', $dist_code);
            $this->db->where('field_mut_basic.subdiv_code', $subdiv_code);
            $this->db->where('field_mut_basic.cir_code', $cir_code);
            $this->db->where('date(date_entry) >=', $define_date);

            $this->db->where('field_mut_basic.order_passed', null);
            $this->db->where('field_mut_basic.is_dispose', null);
            $this->db->where('field_mut_basic.mut_type', '01');
            $this->db->where('field_mut_basic.lm_note IS NOT NULL');

            if ($zone_status == 4) {
                $this->db->where('field_mut_basic.es_flag', 0);
            } else {
                $this->db->where('field_mut_basic.es_flag', 1);
            }

            $res = $this->db->get('field_mut_basic')->result();

            $cc = array();

            foreach ($res as $r) {

                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->co_target_days;

                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }

            $data['total_records'] = count($cc);
            return $data;
        }
    }

    public function getPendingNameCancellationCasesForCo($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status, $user_code)
    {
        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 'misc_case_basic.misc_case_petition_no',
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
            $this->db->where("(misc_case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }
        $this->db->select('misc_case_basic.*, misc_case_basic.misc_case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 'misc_case_basic.misc_case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 'misc_case_basic.misc_case_no = escalation_details.case_no', 'left');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('add_to_officer', $user_code);
        $this->db->where('misc_case_basic.status', '01');
        $this->db->where('misc_case_basic.lm_note_yn', null);
        $this->db->where('misc_case_basic.sk_note_yn', null);
        $this->db->where('misc_case_basic.notice_generated_yn', null);
        $this->db->where('misc_case_basic.fresh_yn', 'Y');
        if ($zone_status == 4) {
            $this->db->where('misc_case_basic.es_flag', 0);
        } else {
            $this->db->where('misc_case_basic.es_flag', 1);
        }
        $this->db->limit($length, $start);
        $query = $this->db->get('misc_case_basic');
        log_message('error', "#3022: misc_case_basic: " . $this->db->last_query());
        if ($query->num_rows() > 0) {
            $data_results = $query->result();
            $final_array = array();
            foreach ($data_results as $rr) {
                $variable = $this->escalationZoneWiseSearchNameCancellation($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->submission_date, $rr->escalated_date, $user_code, $rr->co_target_days, $rr->assigned_date, $rr->fresh_yn, $rr->status, $rr->lm_note_yn, $rr->notice_generated_yn, $rr->sk_note_yn, $rr->next_date_of_hearing, $rr->proceeding_yn, $rr->misc_case_type, $rr->misc_case_petition_no, $rr->is_escalated);
                if (!empty($variable)) {
                    $final_array[] = $variable;
                }
            }
            $data['data_results'] = $final_array;
            $data['total_records'] = count($final_array);
            if (!empty($searchByCol_0)) {
                $this->db->where("(misc_case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
            }
            $this->db->select('misc_case_basic.*, misc_case_basic.misc_case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 'misc_case_basic.misc_case_no = basundhar_application.dharitree', 'left');
            $this->db->join('escalation_details', 'misc_case_basic.misc_case_no = escalation_details.case_no', 'left');
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('add_to_officer', $user_code);
            $this->db->where('misc_case_basic.status', '01');
            $this->db->where('misc_case_basic.lm_note_yn', null);
            $this->db->where('misc_case_basic.sk_note_yn', null);
            $this->db->where('misc_case_basic.notice_generated_yn', null);
            $this->db->where('misc_case_basic.fresh_yn', 'Y');
            if ($zone_status == 4) {
                $this->db->where('misc_case_basic.es_flag', 0);
            } else {
                $this->db->where('misc_case_basic.es_flag', 1);
            }
            $res = $this->db->get('misc_case_basic')->result();
            $cc = array();
            foreach ($res as $r) {
                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->co_target_days;
                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }
            $data['total_records'] = count($cc);
            return $data;
        }
    }

    public function escalationZoneWiseSearchNameCancellation($zone_status, $es_flag, $c_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $rtps_no, $submission_date, $escalated_date, $user_code, $target_days, $assigned_date, $fresh_yn, $status, $lm_note_yn, $notice_generated_yn, $sk_note_yn, $next_date_of_hearing, $proceeding_yn, $misc_case_type, $misc_case_petition_no, $is_escalated)
    {
        $curr_date = date('Y-m-d');
        $esc_date = $escalated_date;
        $esc_flag = $es_flag;
        $final_array = '';
        if (!empty($zone_status) && ($esc_date != null || $esc_date != '') && ($esc_flag == 1)) {
            $remaining_days = $this->dateDiff($esc_date, $curr_date);
            $per_avail = (100 * $remaining_days) / $target_days;
            //green zone
            if (($zone_status == 1) && ($per_avail >= YELLOW_ZONE)) {
                $final_array = (object) [
                    'misc_case_no' => $c_no,
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'basundhara' => $rtps_no,
                    'submission_date' => $submission_date,
                    'escalated_date' => $escalated_date,
                    'es_flag' => $es_flag,
                    'assigned_from' => $user_code,
                    'target_days' => $target_days,
                    'assigned_date' => $assigned_date,
                    'fresh_yn' => $fresh_yn,
                    'status' => $status,
                    'lm_note_yn' => $lm_note_yn,
                    'notice_generated_yn' => $notice_generated_yn,
                    'sk_note_yn' => $sk_note_yn,
                    'next_date_of_hearing' => $next_date_of_hearing,
                    'proceeding_yn' => $proceeding_yn,
                    'misc_case_type' => $misc_case_type,
                    'misc_case_petition_no' => $misc_case_petition_no,
                    'is_escalated' => $is_escalated,
                ];
            }
            //yellow zone
            else if (($zone_status == 2) && (($per_avail < YELLOW_ZONE) && ($per_avail > RED_ZONE))) {
                $final_array = (object) [
                    'misc_case_no' => $c_no,
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'basundhara' => $rtps_no,
                    'submission_date' => $submission_date,
                    'escalated_date' => $escalated_date,
                    'es_flag' => $es_flag,
                    'assigned_from' => $user_code,
                    'target_days' => $target_days,
                    'assigned_date' => $assigned_date,
                    'fresh_yn' => $fresh_yn,
                    'status' => $status,
                    'lm_note_yn' => $lm_note_yn,
                    'notice_generated_yn' => $notice_generated_yn,
                    'sk_note_yn' => $sk_note_yn,
                    'next_date_of_hearing' => $next_date_of_hearing,
                    'proceeding_yn' => $proceeding_yn,
                    'misc_case_type' => $misc_case_type,
                    'misc_case_petition_no' => $misc_case_petition_no,
                    'is_escalated' => $is_escalated,
                ];
            }
            //red zone
            else if (($zone_status == 3) && ($per_avail <= RED_ZONE)) {
                $final_array = (object) [
                    'misc_case_no' => $c_no,
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'basundhara' => $rtps_no,
                    'submission_date' => $submission_date,
                    'escalated_date' => $escalated_date,
                    'es_flag' => $es_flag,
                    'assigned_from' => $user_code,
                    'target_days' => $target_days,
                    'assigned_date' => $assigned_date,
                    'fresh_yn' => $fresh_yn,
                    'status' => $status,
                    'lm_note_yn' => $lm_note_yn,
                    'notice_generated_yn' => $notice_generated_yn,
                    'sk_note_yn' => $sk_note_yn,
                    'next_date_of_hearing' => $next_date_of_hearing,
                    'proceeding_yn' => $proceeding_yn,
                    'misc_case_type' => $misc_case_type,
                    'misc_case_petition_no' => $misc_case_petition_no,
                    'is_escalated' => $is_escalated,
                ];
            }
            //old cases
            else if ($zone_status == 4) {
                $final_array = (object) [
                    'misc_case_no' => $c_no,
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'basundhara' => $rtps_no,
                    'submission_date' => $submission_date,
                    'escalated_date' => $escalated_date,
                    'es_flag' => $es_flag,
                    'assigned_from' => $user_code,
                    'target_days' => $target_days,
                    'assigned_date' => $assigned_date,
                    'fresh_yn' => $fresh_yn,
                    'status' => $status,
                    'lm_note_yn' => $lm_note_yn,
                    'notice_generated_yn' => $notice_generated_yn,
                    'sk_note_yn' => $sk_note_yn,
                    'next_date_of_hearing' => $next_date_of_hearing,
                    'proceeding_yn' => $proceeding_yn,
                    'misc_case_type' => $misc_case_type,
                    'misc_case_petition_no' => $misc_case_petition_no,
                    'is_escalated' => $is_escalated,
                ];
            }
        } else {
            $final_array = (object) [
                'misc_case_no' => $c_no,
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'basundhara' => $rtps_no,
                'submission_date' => $submission_date,
                'escalated_date' => $escalated_date,
                'es_flag' => $es_flag,
                'assigned_from' => $user_code,
                'target_days' => $target_days,
                'assigned_date' => $assigned_date,
                'fresh_yn' => $fresh_yn,
                'status' => $status,
                'lm_note_yn' => $lm_note_yn,
                'notice_generated_yn' => $notice_generated_yn,
                'sk_note_yn' => $sk_note_yn,
                'next_date_of_hearing' => $next_date_of_hearing,
                'proceeding_yn' => $proceeding_yn,
                'misc_case_type' => $misc_case_type,
                'misc_case_petition_no' => $misc_case_petition_no,
                'is_escalated' => $is_escalated,
            ];
        }
        return $final_array;
    }

    public function getPendingNameCancellationCasesForLm($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $start, $length, $order, $define_date, $searchByCol_0, $zone_status, $user_code)
    {
        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 'misc_case_basic.submission_date',
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
            $this->db->where("(misc_case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }
        $this->db->select('misc_case_basic.*, misc_case_basic.misc_case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 'misc_case_basic.misc_case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 'misc_case_basic.misc_case_no = escalation_details.case_no', 'left');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('mouza_pargona_code', $mouza_pargona_code);
        $this->db->where('lot_no', $lot_no);
        $this->db->where('misc_case_basic.lm_note_yn', null);
        $this->db->where('misc_case_basic.next_date_of_hearing  IS NOT NULL');
        $this->db->where('misc_case_basic.fresh_yn', 'Y');
        $this->db->where('misc_case_basic.status !=', 'F');
        $this->db->where('misc_case_basic.submission_date >=', $define_date);
        if ($zone_status == 4) {
            $this->db->where('misc_case_basic.es_flag', 0);
        } else {
            $this->db->where('misc_case_basic.es_flag', 1);
        }
        $this->db->limit($length, $start);
        $query = $this->db->get('misc_case_basic');
        log_message('error', "#3022: misc_case_basic: " . $this->db->last_query());
        if ($query->num_rows() > 0) {
            $data_results = $query->result();
            $final_array = array();
            foreach ($data_results as $rr) {
                $variable = $this->escalationZoneWiseSearchNameCancellation($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->submission_date, $rr->escalated_date, $user_code, $rr->lm_target_days, $rr->assigned_date, $rr->fresh_yn, $rr->status, $rr->lm_note_yn, $rr->notice_generated_yn, $rr->sk_note_yn, $rr->next_date_of_hearing, $rr->proceeding_yn, $rr->misc_case_type, $rr->misc_case_petition_no, $rr->is_escalated);
                if (!empty($variable)) {
                    $final_array[] = $variable;
                }
            }
            $data['data_results'] = $final_array;
            $data['total_records'] = count($final_array);
            if (!empty($searchByCol_0)) {
                $this->db->where("(misc_case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
            }
            $this->db->select('misc_case_basic.*, misc_case_basic.misc_case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 'misc_case_basic.misc_case_no = basundhar_application.dharitree', 'left');
            $this->db->join('escalation_details', 'misc_case_basic.misc_case_no = escalation_details.case_no', 'left');
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('mouza_pargona_code', $mouza_pargona_code);
            $this->db->where('lot_no', $lot_no);
            $this->db->where('misc_case_basic.lm_note_yn', null);
            $this->db->where('misc_case_basic.next_date_of_hearing  IS NOT NULL');
            $this->db->where('misc_case_basic.fresh_yn', 'Y');
            $this->db->where('misc_case_basic.status !=', 'F');
            $this->db->where('misc_case_basic.submission_date >=', $define_date);
            if ($zone_status == 4) {
                $this->db->where('misc_case_basic.es_flag', 0);
            } else {
                $this->db->where('misc_case_basic.es_flag', 1);
            }
            $res = $this->db->get('misc_case_basic')->result();
            // echo $this->db->last_query();
            $cc = array();
            foreach ($res as $r) {
                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->lm_target_days;
                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }
            $data['total_records'] = count($cc);
            return $data;
        }
    }

    public function getPendingNameCancellationCasesForAst($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status)
    {
        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 'misc_case_basic.misc_case_petition_no',
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
            $this->db->where("(misc_case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }
        $this->db->select('misc_case_basic.*, misc_case_basic.misc_case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 'misc_case_basic.misc_case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 'misc_case_basic.misc_case_no = escalation_details.case_no', 'left');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('misc_case_basic.lm_note_yn', null);
        $this->db->where('misc_case_basic.sk_note_yn', null);
        $this->db->where('misc_case_basic.notice_generated_yn', null);
        $this->db->where('misc_case_basic.submission_date >=', $define_date);
        $this->db->where('misc_case_basic.status', '18');
        if ($zone_status == 4) {
            $this->db->where('misc_case_basic.es_flag', 0);
        } else {
            $this->db->where('misc_case_basic.es_flag', 1);
        }
        $this->db->limit($length, $start);
        $query = $this->db->get('misc_case_basic');
        log_message('error', "#4100: misc_case_basic: " . $this->db->last_query());
        if ($query->num_rows() > 0) {
            $data_results = $query->result();
            $final_array = array();
            foreach ($data_results as $rr) {
                $variable = $this->escalationZoneWiseSearchNameCancellation($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->submission_date, $rr->assigned_other_es_date, $this->session->userdata('user_code'), $rr->da_target_days, $rr->assigned_other_date, $rr->fresh_yn, $rr->status, $rr->lm_note_yn, $rr->notice_generated_yn, $rr->sk_note_yn, $rr->next_date_of_hearing, $rr->proceeding_yn, $rr->misc_case_type, $rr->misc_case_petition_no, $rr->is_escalated);
                if (!empty($variable)) {
                    $final_array[] = $variable;
                }
            }
            $data['data_results'] = $final_array;
            $data['total_records'] = count($final_array);
            if (!empty($searchByCol_0)) {
                $this->db->where("(misc_case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
            }
            $this->db->select('misc_case_basic.*, misc_case_basic.misc_case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 'misc_case_basic.misc_case_no = basundhar_application.dharitree', 'left');
            $this->db->join('escalation_details', 'misc_case_basic.misc_case_no = escalation_details.case_no', 'left');
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('misc_case_basic.lm_note_yn', null);
            $this->db->where('misc_case_basic.sk_note_yn', null);
            $this->db->where('misc_case_basic.notice_generated_yn', null);
            $this->db->where('misc_case_basic.submission_date >=', $define_date);
            $this->db->where('misc_case_basic.status', '18');
            if ($zone_status == 4) {
                $this->db->where('misc_case_basic.es_flag', 0);
            } else {
                $this->db->where('misc_case_basic.es_flag', 1);
            }
            $res = $this->db->get('misc_case_basic')->result();
            // echo $this->db->last_query();
            $cc = array();
            foreach ($res as $r) {
                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->lm_target_days;
                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }
            $data['total_records'] = count($cc);
            return $data;
        }
    }

    public function getPendingNameCancellationCasesForCoFinalOrder($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status, $user_code)
    {
        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 'misc_case_basic.misc_case_petition_no',
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
            $this->db->where("(misc_case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }
        $status = array('10', '02');
        $this->db->select('misc_case_basic.*, misc_case_basic.misc_case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 'misc_case_basic.misc_case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 'misc_case_basic.misc_case_no = escalation_details.case_no', 'left');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('add_to_officer', $user_code);
        $this->db->where_in('misc_case_basic.status', $status);
        $this->db->where('misc_case_basic.operation !=', 'E');
        $this->db->where('misc_case_basic.misc_case_type', '07');
        $this->db->where('misc_case_basic.lm_note_yn', 'Y');
        $this->db->where('misc_case_basic.sk_note_yn', 'Y');
        $this->db->where('misc_case_basic.submission_date >=', $define_date);
        if ($zone_status == 4) {
            $this->db->where('misc_case_basic.es_flag', 0);
        } else {
            $this->db->where('misc_case_basic.es_flag', 1);
        }
        $this->db->limit($length, $start);
        $query = $this->db->get('misc_case_basic');
        log_message('error', "#4236: misc_case_basic: " . $this->db->last_query());
        if ($query->num_rows() > 0) {
            $data_results = $query->result();
            $final_array = array();
            foreach ($data_results as $rr) {
                $variable = $this->escalationZoneWiseSearchNameCancellation($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->submission_date, $rr->escalated_date, $user_code, $rr->co_target_days, $rr->assigned_date, $rr->fresh_yn, $rr->status, $rr->lm_note_yn, $rr->notice_generated_yn, $rr->sk_note_yn, $rr->next_date_of_hearing, $rr->proceeding_yn, $rr->misc_case_type, $rr->misc_case_petition_no, $rr->is_escalated);
                if (!empty($variable)) {
                    $final_array[] = $variable;
                }
            }
            $data['data_results'] = $final_array;
            $data['total_records'] = count($final_array);
            if (!empty($searchByCol_0)) {
                $this->db->where("(misc_case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
            }
            $this->db->select('misc_case_basic.*, misc_case_basic.misc_case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 'misc_case_basic.misc_case_no = basundhar_application.dharitree', 'left');
            $this->db->join('escalation_details', 'misc_case_basic.misc_case_no = escalation_details.case_no', 'left');
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('add_to_officer', $user_code);
            $this->db->where_in('misc_case_basic.status', $status);
            $this->db->where('misc_case_basic.operation !=', 'E');
            $this->db->where('misc_case_basic.misc_case_type', '07');
            $this->db->where('misc_case_basic.lm_note_yn', 'Y');
            $this->db->where('misc_case_basic.sk_note_yn', 'Y');
            $this->db->where('misc_case_basic.submission_date >=', $define_date);
            if ($zone_status == 4) {
                $this->db->where('misc_case_basic.es_flag', 0);
            } else {
                $this->db->where('misc_case_basic.es_flag', 1);
            }
            $res = $this->db->get('misc_case_basic')->result();
            $cc = array();
            foreach ($res as $r) {
                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->co_target_days;
                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }
            $data['total_records'] = count($cc);
            return $data;
        }
    }

    public function getPendingNameCancellationRevertCasesForLm($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $start, $length, $order, $define_date, $searchByCol_0, $zone_status, $user_code)
    {
        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 'misc_case_basic.submission_date',
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
            $this->db->where("(misc_case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }

        $this->db->select('misc_case_basic.*, misc_case_basic.misc_case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 'misc_case_basic.misc_case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 'misc_case_basic.misc_case_no = escalation_details.case_no', 'left');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('mouza_pargona_code', $mouza_pargona_code);
        $this->db->where('lot_no', $lot_no);
        $this->db->where('misc_case_basic.lm_note_yn', null);
        $this->db->where('misc_case_basic.status', 'L');
        $this->db->where('misc_case_basic.misc_case_type', '07');
        $this->db->where('misc_case_basic.fresh_yn', 'Y');
        $this->db->where('misc_case_basic.submission_date >=', $define_date);

        if ($zone_status == 4) {
            $this->db->where('misc_case_basic.es_flag', 0);
        } else {
            $this->db->where('misc_case_basic.es_flag', 1);
        }
        $this->db->limit($length, $start);
        $query = $this->db->get('misc_case_basic');
        log_message('error', "#4645: misc_case_basic: " . $this->db->last_query());
        if ($query->num_rows() > 0) {
            $data_results = $query->result();
            $final_array = array();
            foreach ($data_results as $rr) {
                $variable = $this->escalationZoneWiseSearchNameCancellation($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->submission_date, $rr->escalated_date, $user_code, $rr->lm_target_days, $rr->assigned_date, $rr->fresh_yn, $rr->status, $rr->lm_note_yn, $rr->notice_generated_yn, $rr->sk_note_yn, $rr->next_date_of_hearing, $rr->proceeding_yn, $rr->misc_case_type, $rr->misc_case_petition_no, $rr->is_escalated);
                if (!empty($variable)) {
                    $final_array[] = $variable;
                }
            }
            $data['data_results'] = $final_array;
            $data['total_records'] = count($final_array);
            if (!empty($searchByCol_0)) {
                $this->db->where("(misc_case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
            }
            $this->db->select('misc_case_basic.*, misc_case_basic.misc_case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 'misc_case_basic.misc_case_no = basundhar_application.dharitree', 'left');
            $this->db->join('escalation_details', 'misc_case_basic.misc_case_no = escalation_details.case_no', 'left');
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('mouza_pargona_code', $mouza_pargona_code);
            $this->db->where('lot_no', $lot_no);
            $this->db->where('misc_case_basic.lm_note_yn', null);
            $this->db->where('misc_case_basic.status', 'L');
            $this->db->where('misc_case_basic.misc_case_type', '07');
            $this->db->where('misc_case_basic.fresh_yn', 'Y');
            $this->db->where('misc_case_basic.submission_date >=', $define_date);

            if ($zone_status == 4) {
                $this->db->where('misc_case_basic.es_flag', 0);
            } else {
                $this->db->where('misc_case_basic.es_flag', 1);
            }

            $res = $this->db->get('misc_case_basic')->result();
            // echo $this->db->last_query();
            $cc = array();
            foreach ($res as $r) {
                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->lm_target_days;
                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }
            $data['total_records'] = count($cc);
            return $data;
        }
    }

    public function getPendingMobileUpdationCasesCoEnd($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status)
    {
        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 'legacy_correction.petition_no',
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
            $this->db->where("(case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }
        $this->db->select('legacy_correction.*, legacy_correction.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 'legacy_correction.case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 'legacy_correction.case_no = escalation_details.case_no', 'left');
        $this->db->where('legacy_correction.dist_code', $dist_code);
        $this->db->where('legacy_correction.subdiv_code', $subdiv_code);
        $this->db->where('legacy_correction.cir_code', $cir_code);
        $this->db->where('legacy_correction.service_type', 'M');
        $this->db->where('legacy_correction.status', 'A');
        if ($zone_status == 4) {
            $this->db->where('legacy_correction.es_flag', 0);
        } else {
            $this->db->where('legacy_correction.es_flag', 1);
        }
        $this->db->limit($length, $start);
        $query = $this->db->get('legacy_correction');
        log_message('error', "#4759 legacy_correction: " . $this->db->last_query());
        if ($query->num_rows() > 0) {
            $data_results = $query->result();
            $final_array = array();
            foreach ($data_results as $rr) {
                $date_entry = date('Y-m-d', strtotime($rr->date_of_reg));
                $variable = $this->escalationZoneWiseSearchLegacyCorrection($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $date_entry, $rr->escalated_date, $this->session->userdata('user_code'), $rr->co_target_days, $rr->assigned_date, $rr->status,
                    $rr->petition_no, $rr->service_type);
                if (!empty($variable)) {
                    $final_array[] = $variable;
                }
            }
            $data['data_results'] = $final_array;
            $data['total_records'] = count($final_array);
            if (!empty($searchByCol_0)) {
                $this->db->like('case_no', strtoupper($searchByCol_0));
            }
            $this->db->select('legacy_correction.*, legacy_correction.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 'legacy_correction.case_no = basundhar_application.dharitree', 'left');
            $this->db->join('escalation_details', 'legacy_correction.case_no = escalation_details.case_no', 'left');
            $this->db->where('legacy_correction.dist_code', $dist_code);
            $this->db->where('legacy_correction.subdiv_code', $subdiv_code);
            $this->db->where('legacy_correction.cir_code', $cir_code);
            $this->db->where('legacy_correction.service_type', 'M');
            $this->db->where('legacy_correction.status', 'A');
            if ($zone_status == 4) {
                $this->db->where('legacy_correction.es_flag', 0);
            } else {
                $this->db->where('legacy_correction.es_flag', 1);
            }
            $res = $this->db->get('legacy_correction')->result();
            $cc = array();
            foreach ($res as $r) {
                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->co_target_days;
                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }
            $data['total_records'] = count($cc);
            return $data;
        }
    }
    public function escalationZoneWiseSearchLegacyCorrection($zone_status, $es_flag, $c_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $rtps_no, $date_entry, $escalated_date, $user_code, $target_days, $assigned_date, $status, $petition_no, $service_type)
    {
        $curr_date = date('Y-m-d');
        $esc_date = $escalated_date;
        $esc_flag = $es_flag;
        $final_array = '';
        if (!empty($zone_status) && ($esc_date != null || $esc_date != '') && ($esc_flag == 1)) {
            $remaining_days = $this->dateDiff($esc_date, $curr_date);
            $per_avail = (100 * $remaining_days) / $target_days;
            //green zone
            if (($zone_status == 1) && ($per_avail >= YELLOW_ZONE)) {
                $final_array = (object) [
                    'case_no' => $c_no,
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'basundhara' => $rtps_no,
                    'date_of_reg' => $date_entry,
                    'escalated_date' => $escalated_date,
                    'es_flag' => $es_flag,
                    'assigned_from' => $user_code,
                    'target_days' => $target_days,
                    'assigned_date' => $assigned_date,
                    'status' => $status,
                    'petition_no' => $petition_no,
                    'service_type' => $service_type,
                ];
            }
            //yellow zone
            else if (($zone_status == 2) && (($per_avail < YELLOW_ZONE) && ($per_avail > RED_ZONE))) {
                $final_array = (object) [
                    'case_no' => $c_no,
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'basundhara' => $rtps_no,
                    'date_of_reg' => $date_entry,
                    'escalated_date' => $escalated_date,
                    'es_flag' => $es_flag,
                    'assigned_from' => $user_code,
                    'target_days' => $target_days,
                    'assigned_date' => $assigned_date,
                    'status' => $status,
                    'petition_no' => $petition_no,
                    'service_type' => $service_type,
                ];
            }
            //red zone
            else if (($zone_status == 3) && ($per_avail <= RED_ZONE)) {
                $final_array = (object) [
                    'case_no' => $c_no,
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'basundhara' => $rtps_no,
                    'date_of_reg' => $date_entry,
                    'escalated_date' => $escalated_date,
                    'es_flag' => $es_flag,
                    'assigned_from' => $user_code,
                    'target_days' => $target_days,
                    'assigned_date' => $assigned_date,
                    'status' => $status,
                    'petition_no' => $petition_no,
                    'service_type' => $service_type,
                ];
            }
            //old cases
            else if ($zone_status == 4) {
                $final_array = (object) [
                    'case_no' => $c_no,
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'basundhara' => $rtps_no,
                    'date_of_reg' => $date_entry,
                    'escalated_date' => $escalated_date,
                    'es_flag' => $es_flag,
                    'assigned_from' => $user_code,
                    'target_days' => $target_days,
                    'assigned_date' => $assigned_date,
                    'status' => $status,
                    'petition_no' => $petition_no,
                    'service_type' => $service_type,
                ];
            }
        } else {
            $final_array = (object) [
                'case_no' => $c_no,
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'basundhara' => $rtps_no,
                'date_of_reg' => $date_entry,
                'escalated_date' => $escalated_date,
                'es_flag' => $es_flag,
                'assigned_from' => $user_code,
                'target_days' => $target_days,
                'assigned_date' => $assigned_date,
                'status' => $status,
                'petition_no' => $petition_no,
                'service_type' => $service_type,
            ];
        }
        return $final_array;
    }

    public function getPendingAreaDataCorrectionLmEnd($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status)
    {
        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 'legacy_correction.date_of_reg',
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
            $this->db->where("(case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }
        $this->db->select('legacy_correction.*, legacy_correction.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 'legacy_correction.case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 'legacy_correction.case_no = escalation_details.case_no', 'left');
        $this->db->where('legacy_correction.dist_code', $dist_code);
        $this->db->where('legacy_correction.subdiv_code', $subdiv_code);
        $this->db->where('legacy_correction.cir_code', $cir_code);
        $this->db->where('legacy_correction.mouza_pargona_code', $mouza_pargona_code);
        $this->db->where('legacy_correction.lot_no', $lot_no);

        $this->db->where("legacy_correction.service_type IN ('A','N')");
        $this->db->where('legacy_correction.status', 'A');

        if ($zone_status == 4) {
            $this->db->where('legacy_correction.es_flag', 0);
        } else {
            $this->db->where('legacy_correction.es_flag', 1);
        }

        $this->db->limit($length, $start);

        $query = $this->db->get('legacy_correction');
        log_message('error', "#4996 legacy_correction: " . $this->db->last_query());

        if ($query->num_rows() > 0) {
            $data_results = $query->result();
            $final_array = array();
            foreach ($data_results as $rr) {
                $date_entry = date('Y-m-d', strtotime($rr->date_of_reg));
                $variable = $this->escalationZoneWiseSearchLegacyCorrection($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $date_entry, $rr->escalated_date, $this->session->userdata('user_code'), $rr->co_target_days, $rr->assigned_date, $rr->status,
                    $rr->petition_no, $rr->service_type);
                if (!empty($variable)) {
                    $final_array[] = $variable;
                }
            }
            $data['data_results'] = $final_array;
            $data['total_records'] = count($final_array);
            if (!empty($searchByCol_0)) {
                $this->db->like('case_no', strtoupper($searchByCol_0));
            }
            $this->db->select('legacy_correction.*, legacy_correction.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 'legacy_correction.case_no = basundhar_application.dharitree', 'left');
            $this->db->join('escalation_details', 'legacy_correction.case_no = escalation_details.case_no', 'left');
            $this->db->where('legacy_correction.dist_code', $dist_code);
            $this->db->where('legacy_correction.subdiv_code', $subdiv_code);
            $this->db->where('legacy_correction.cir_code', $cir_code);
            $this->db->where('legacy_correction.mouza_pargona_code', $mouza_pargona_code);
            $this->db->where('legacy_correction.lot_no', $lot_no);

            $this->db->where("legacy_correction.service_type IN ('A','N')");
            $this->db->where('legacy_correction.status', 'A');

            if ($zone_status == 4) {
                $this->db->where('legacy_correction.es_flag', 0);
            } else {
                $this->db->where('legacy_correction.es_flag', 1);
            }
            $res = $this->db->get('legacy_correction')->result();
            $cc = array();
            foreach ($res as $r) {
                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->co_target_days;
                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }
            $data['total_records'] = count($cc);
            return $data;
        }
    }

    public function getPendingAreaDataCorrectionCasesCoEnd($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status)
    {
        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 'legacy_correction.petition_no',
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
            $this->db->where("(case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }
        $this->db->select('legacy_correction.*, legacy_correction.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 'legacy_correction.case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 'legacy_correction.case_no = escalation_details.case_no', 'left');
        $this->db->where('legacy_correction.dist_code', $dist_code);
        $this->db->where('legacy_correction.subdiv_code', $subdiv_code);
        $this->db->where('legacy_correction.cir_code', $cir_code);
        $this->db->where("legacy_correction.service_type IN ('A','N')");
        $this->db->where('legacy_correction.status', 'C');
        if ($zone_status == 4) {
            $this->db->where('legacy_correction.es_flag', 0);
        } else {
            $this->db->where('legacy_correction.es_flag', 1);
        }

        $this->db->limit($length, $start);
        $query = $this->db->get('legacy_correction');
        log_message('error', "#4759 legacy_correction: " . $this->db->last_query());
        if ($query->num_rows() > 0) {
            $data_results = $query->result();
            $final_array = array();
            foreach ($data_results as $rr) {
                $date_entry = date('Y-m-d', strtotime($rr->date_of_reg));
                $variable = $this->escalationZoneWiseSearchLegacyCorrection($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $date_entry, $rr->escalated_date, $this->session->userdata('user_code'), $rr->co_target_days, $rr->assigned_date, $rr->status,
                    $rr->petition_no, $rr->service_type);
                if (!empty($variable)) {
                    $final_array[] = $variable;
                }
            }
            $data['data_results'] = $final_array;
            $data['total_records'] = count($final_array);
            if (!empty($searchByCol_0)) {
                $this->db->like('case_no', strtoupper($searchByCol_0));
            }
            $this->db->select('legacy_correction.*, legacy_correction.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 'legacy_correction.case_no = basundhar_application.dharitree', 'left');
            $this->db->join('escalation_details', 'legacy_correction.case_no = escalation_details.case_no', 'left');
            $this->db->where('legacy_correction.dist_code', $dist_code);
            $this->db->where('legacy_correction.subdiv_code', $subdiv_code);
            $this->db->where('legacy_correction.cir_code', $cir_code);
            $this->db->where("legacy_correction.service_type IN ('A','N')");
            $this->db->where('legacy_correction.status', 'C');
            if ($zone_status == 4) {
                $this->db->where('legacy_correction.es_flag', 0);
            } else {
                $this->db->where('legacy_correction.es_flag', 1);
            }
            $res = $this->db->get('legacy_correction')->result();
            $cc = array();
            foreach ($res as $r) {
                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->co_target_days;
                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }
            $data['total_records'] = count($cc);
            return $data;
        }
    }

    //************************** added on 09/08/2023 ****************************
    //get pending reclassification cases in LM end
    public function getPendingReclassCaseLMend($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $mouza_code, $lot_no, $vill_mouza_code, $vill_lot_no, $village_code, $searchByCol_0, $zone_status)
    {
        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 't_reclassification.proposal_no',
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
            $this->db->where("(case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }
        if (!empty($mouza_code)) {
            $this->db->where('mouza_pargona_code', $mouza_code);
        }
        if (!empty($lot_no)) {
            $this->db->where('lot_no', $lot_no);
        }
        if (!empty($vill_mouza_code)) {
            $this->db->where('mouza_pargona_code', $vill_mouza_code);
        }
        if (!empty($vill_lot_no)) {
            $this->db->where('lot_no', $vill_lot_no);
        }
        if (!empty($village_code)) {
            $this->db->where('vill_townprt_code', $village_code);
        }
        $this->db->select('t_reclassification.*, t_reclassification.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 't_reclassification.case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 't_reclassification.case_no = escalation_details.case_no', 'left');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('t_reclassification.lm_yn', null);
        $this->db->where('t_reclassification.lm_date', null);
        if ($zone_status == 4) { // for old cases
            $this->db->where('t_reclassification.es_flag', '0');
        } else {
            $this->db->where('t_reclassification.es_flag', '1');
        }
        $this->db->limit($length, $start);
        $query = $this->db->get('t_reclassification');
        log_message('error', "#6384 = t_reclassification : " . $this->db->last_query());
        if ($query->num_rows() > 0) {
            $data_results = $query->result();
            $final_array = array();
            foreach ($data_results as $rr) {
                $variable = $this->escalationZoneWiseSearchReclassification($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->registerd_on, $rr->escalated_date, $this->session->userdata('user_code'), $rr->lm_target_days, $rr->assigned_date, $rr->date_entry, $rr->proposal_no, $rr->lm_date, $rr->dag_no, $rr->is_escalated);
                if (!empty($variable)) {
                    $final_array[] = $variable;
                }
            }
            $data['data_results'] = $final_array;
            $data['total_records'] = count($final_array);
            if (!empty($mouza_code)) {
                $this->db->where('mouza_pargona_code', $mouza_code);
            }
            if (!empty($lot_no)) {
                $this->db->where('lot_no', $lot_no);
            }
            if (!empty($vill_mouza_code)) {
                $this->db->where('mouza_pargona_code', $vill_mouza_code);
            }
            if (!empty($vill_lot_no)) {
                $this->db->where('lot_no', $vill_lot_no);
            }
            if (!empty($village_code)) {
                $this->db->where('vill_townprt_code', $village_code);
            }
            if (!empty($searchByCol_0)) {
                $this->db->like('case_no', strtoupper($searchByCol_0));
            }
            $this->db->select('t_reclassification.*, t_reclassification.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 't_reclassification.case_no = basundhar_application.dharitree', 'left');
            $this->db->join('escalation_details', 't_reclassification.case_no = escalation_details.case_no', 'left');
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('t_reclassification.lm_yn', null);
            $this->db->where('t_reclassification.lm_date', null);
            if ($zone_status == 4) { // for old cases
                $this->db->where('t_reclassification.es_flag', '0');
            } else {
                $this->db->where('t_reclassification.es_flag', '1');
            }
            $res = $this->db->get('t_reclassification')->result();
            log_message('error', '#6442 ' . $this->db->last_query());
            $cc = array();
            foreach ($res as $r) {
                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->lm_target_days;
                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }
            $data['total_records'] = count($cc);
            return $data;
        }
    }

    // reclassification array
    public function escalationZoneWiseSearchReclassification($zone_status, $es_flag, $c_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $rtps_no, $submission_date, $escalated_date, $user_code, $target_days, $assigned_date, $date_entry, $proposal_no, $lm_date, $dag_no, $is_escalated)
    {
        $curr_date = date('Y-m-d');
        $esc_date = $escalated_date;
        $esc_flag = $es_flag;
        $final_array = '';
        if (!empty($zone_status) && ($esc_date != null || $esc_date != '') && ($esc_flag == 1)) {
            $remaining_days = $this->dateDiff($esc_date, $curr_date);
            $per_avail = (100 * $remaining_days) / $target_days;
            //green zone
            if (($zone_status == 1) && ($per_avail >= YELLOW_ZONE)) {
                $final_array = (object) [
                    'case_no' => $c_no,
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'basundhara' => $rtps_no,
                    'report_date' => $submission_date,
                    'escalated_date' => $escalated_date,
                    'es_flag' => $es_flag,
                    'assigned_from' => $user_code,
                    'co_target_days' => $target_days,
                    'assigned_date' => $assigned_date,
                    'date_entry' => $date_entry,
                    'application_ref_no' => $rtps_no,
                    'proposal_no' => $proposal_no,
                    'lm_date' => $lm_date,
                    'dag_no' => $dag_no,
                    'is_escalated' => $is_escalated,
                ];
                log_message('error', '#6512 : Green Zone ' . json_encode($final_array));
            }
            //yellow zone
            else if (($zone_status == 2) && (($per_avail < YELLOW_ZONE) && ($per_avail > RED_ZONE))) {
                $final_array = (object) [
                    'case_no' => $c_no,
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'basundhara' => $rtps_no,
                    'report_date' => $submission_date,
                    'escalated_date' => $escalated_date,
                    'es_flag' => $es_flag,
                    'assigned_from' => $user_code,
                    'co_target_days' => $target_days,
                    'assigned_date' => $assigned_date,
                    'date_entry' => $date_entry,
                    'application_ref_no' => $rtps_no,
                    'proposal_no' => $proposal_no,
                    'lm_date' => $lm_date,
                    'dag_no' => $dag_no,
                    'is_escalated' => $is_escalated,
                ];
                log_message('error', '#6537 : Yellow Zone ' . json_encode($final_array));
            }
            //red zone
            else if (($zone_status == 3) && ($per_avail <= RED_ZONE)) {
                $final_array = (object) [
                    'case_no' => $c_no,
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'basundhara' => $rtps_no,
                    'report_date' => $submission_date,
                    'escalated_date' => $escalated_date,
                    'es_flag' => $es_flag,
                    'assigned_from' => $user_code,
                    'co_target_days' => $target_days,
                    'assigned_date' => $assigned_date,
                    'date_entry' => $date_entry,
                    'application_ref_no' => $rtps_no,
                    'proposal_no' => $proposal_no,
                    'lm_date' => $lm_date,
                    'dag_no' => $dag_no,
                    'is_escalated' => $is_escalated,
                ];
                log_message('error', '#6562 : Red Zone ' . json_encode($final_array));
            }
            //old cases
            else if ($zone_status == 4) {
                $final_array = (object) [
                    'case_no' => $c_no,
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'basundhara' => $rtps_no,
                    'report_date' => $submission_date,
                    'escalated_date' => $escalated_date,
                    'es_flag' => $es_flag,
                    'assigned_from' => $user_code,
                    'co_target_days' => $target_days,
                    'assigned_date' => $assigned_date,
                    'date_entry' => $date_entry,
                    'application_ref_no' => $rtps_no,
                    'proposal_no' => $proposal_no,
                    'lm_date' => $lm_date,
                    'dag_no' => $dag_no,
                    'is_escalated' => $is_escalated,
                ];
                log_message('error', '#6587 : Old Cases ' . json_encode($final_array));
            }
        } else {
            $final_array = (object) [
                'case_no' => $c_no,
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'basundhara' => $rtps_no,
                'report_date' => $submission_date,
                'escalated_date' => $escalated_date,
                'es_flag' => $es_flag,
                'assigned_from' => $user_code,
                'co_target_days' => $target_days,
                'assigned_date' => $assigned_date,
                'date_entry' => $date_entry,
                'application_ref_no' => $rtps_no,
                'proposal_no' => $proposal_no,
                'lm_date' => $lm_date,
                'dag_no' => $dag_no,
                'is_escalated' => $is_escalated,
            ];
            log_message('error', '#6626 : Others ' . json_encode($final_array));
        }
        return $final_array;
    }

    //get pending reclassification cases in CO end
    public function getPendingReclassificationCasesCoEnd($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status)
    {
        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 't_reclassification.proposal_no',
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
            $this->db->where("(case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }
        $this->db->select('t_reclassification.*, t_reclassification.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 't_reclassification.case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 't_reclassification.case_no = escalation_details.case_no', 'left');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('lm_yn IS NOT NULL');
        $this->db->where('co_yn', null);
        $this->db->where('dc_yn', null);
        $this->db->where("(t_reclassification.status != 'R' and t_reclassification.status!='M' OR t_reclassification.status is null OR t_reclassification.status='C')");
        if ($zone_status == 4) {
            $this->db->where('t_reclassification.es_flag', '0');
        } else {
            $this->db->where('t_reclassification.es_flag', '1');
        }
        $this->db->limit($length, $start);
        $query = $this->db->get('t_reclassification');
        log_message('error', "t_reclassification: " . $this->db->last_query());
        if ($query->num_rows() > 0) {
            $data_results = $query->result();
            $final_array = array();
            foreach ($data_results as $rr) {
                $variable = $this->escalationZoneWiseSearchReclassification($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->registerd_on, $rr->escalated_date, $this->session->userdata('user_code'), $rr->co_target_days, $rr->assigned_date, $rr->date_entry, $rr->proposal_no, $rr->lm_date, $rr->dag_no, $rr->is_escalated);
                if (!empty($variable)) {
                    $final_array[] = $variable;
                }
            }
            $data['data_results'] = $final_array;
            $data['total_records'] = count($final_array);
            // var_dump($data['data_results']);
            if (!empty($searchByCol_0)) {
                $this->db->like('case_no', strtoupper($searchByCol_0));
            }
            $this->db->select('t_reclassification.*, t_reclassification.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 't_reclassification.case_no = basundhar_application.dharitree', 'left');
            $this->db->join('escalation_details', 't_reclassification.case_no = escalation_details.case_no', 'left');
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('lm_yn IS NOT NULL');
            $this->db->where('co_yn', null);
            $this->db->where('dc_yn', null);
            $this->db->where("(t_reclassification.status != 'R' and t_reclassification.status!='M' OR t_reclassification.status is null OR t_reclassification.status='C')");
            if ($zone_status == 4) {
                $this->db->where('t_reclassification.es_flag', '0');
            } else {
                $this->db->where('t_reclassification.es_flag', '1');
            }
            $res = $this->db->get('t_reclassification')->result();
            $cc = array();
            foreach ($res as $r) {
                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->co_target_days;
                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }
            $data['total_records'] = count($cc);
            return $data;
        }
    }

    //get pending reclassification cases in ADC end
    public function getPendingReclassificationCasesAdcEnd($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status)
    {
        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 't_reclassification.proposal_no',
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
            $this->db->where("(case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }
        $this->db->select('t_reclassification.*, t_reclassification.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 't_reclassification.case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 't_reclassification.case_no = escalation_details.case_no', 'left');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('co_yn', 'Y');
        $this->db->where('dc_yn', null);
        $this->db->where('dc_approval', null);
        $this->db->where('t_reclassification.status', 'A');
        if ($zone_status == 4) {
            $this->db->where('t_reclassification.es_flag', '0');
        } else {
            $this->db->where('t_reclassification.es_flag', '1');
        }
        $this->db->limit($length, $start);
        $query = $this->db->get('t_reclassification');
        log_message('error', "t_reclassification: " . $this->db->last_query());
        if ($query->num_rows() > 0) {
            $data_results = $query->result();
            $final_array = array();
            foreach ($data_results as $rr) {
                $variable = $this->escalationZoneWiseSearchReclassification($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->registerd_on, $rr->escalated_date, $this->session->userdata('user_code'), $rr->co_target_days, $rr->assigned_date, $rr->date_entry, $rr->proposal_no, $rr->lm_date, $rr->dag_no, $rr->is_escalated);
                if (!empty($variable)) {
                    $final_array[] = $variable;
                }
            }
            $data['data_results'] = $final_array;
            $data['total_records'] = count($final_array);
            // var_dump($data['data_results']);
            if (!empty($searchByCol_0)) {
                $this->db->like('case_no', strtoupper($searchByCol_0));
            }
            $this->db->select('t_reclassification.*, t_reclassification.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 't_reclassification.case_no = basundhar_application.dharitree', 'left');
            $this->db->join('escalation_details', 't_reclassification.case_no = escalation_details.case_no', 'left');
            $this->db->where('dist_code', $dist_code);
            $this->db->where('co_yn', 'Y');
            $this->db->where('dc_yn', null);
            $this->db->where('dc_approval', null);
            $this->db->where('t_reclassification.status', 'A');
            if ($zone_status == 4) {
                $this->db->where('t_reclassification.es_flag', '0');
            } else {
                $this->db->where('t_reclassification.es_flag', '1');
            }
            $res = $this->db->get('t_reclassification')->result();
            $cc = array();
            foreach ($res as $r) {
                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->co_target_days;
                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }
            $data['total_records'] = count($cc);
            return $data;
        }
    }

    //get pending reclassification cases in DC end
    public function getPendingReclassificationCasesDcEnd($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status)
    {
        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 't_reclassification.proposal_no',
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
            $this->db->where("(case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }
        $this->db->select('t_reclassification.*, t_reclassification.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 't_reclassification.case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 't_reclassification.case_no = escalation_details.case_no', 'left');
        $this->db->where('co_chitha_updated_yn', null);
        $this->db->where('t_reclassification.status', 'D');
        if ($zone_status == 4) {
            $this->db->where('t_reclassification.es_flag', '0');
        } else {
            $this->db->where('t_reclassification.es_flag', '1');
        }
        $this->db->limit($length, $start);
        $query = $this->db->get('t_reclassification');
        log_message('error', "t_reclassification: ===========" . $this->db->last_query());
        if ($query->num_rows() > 0) {
            $data_results = $query->result();
            $final_array = array();
            foreach ($data_results as $rr) {
                $variable = $this->escalationZoneWiseSearchReclassification($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->registerd_on, $rr->escalated_date, $this->session->userdata('user_code'), $rr->co_target_days, $rr->assigned_date, $rr->date_entry, $rr->proposal_no, $rr->lm_date, $rr->dag_no, $rr->is_escalated);
                if (!empty($variable)) {
                    $final_array[] = $variable;
                }
            }
            $data['data_results'] = $final_array;
            $data['total_records'] = count($final_array);
            // var_dump($data['data_results']);
            if (!empty($searchByCol_0)) {
                $this->db->like('case_no', strtoupper($searchByCol_0));
            }
            $this->db->select('t_reclassification.*, t_reclassification.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 't_reclassification.case_no = basundhar_application.dharitree', 'left');
            $this->db->join('escalation_details', 't_reclassification.case_no = escalation_details.case_no', 'left');
            $this->db->where('co_chitha_updated_yn', null);
            $this->db->where('t_reclassification.status', 'D');
            if ($zone_status == 4) {
                $this->db->where('t_reclassification.es_flag', '0');
            } else {
                $this->db->where('t_reclassification.es_flag', '1');
            }
            $res = $this->db->get('t_reclassification')->result();
            $cc = array();
            foreach ($res as $r) {
                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->co_target_days;
                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }
            $data['total_records'] = count($cc);
            return $data;
        }
    }

    //***************** added on 18082023
    public function getPendingFieldPartitionCaseLMendList($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $mouza_code, $lot_no, $vill_mouza_code, $vill_lot_no, $village_code, $searchByCol_0, $zone_status)
    {
        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 'field_mut_basic.petition_no',
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
            $this->db->where("(case_no like '%$searchByCol_0%' OR basundhara like '%$searchByCol_0%')");
        }
        if (!empty($mouza_code)) {
            $this->db->where('mouza_pargona_code', $mouza_code);
        }
        if (!empty($lot_no)) {
            $this->db->where('lot_no', $lot_no);
        }
        if (!empty($vill_mouza_code)) {
            $this->db->where('mouza_pargona_code', $vill_mouza_code);
        }
        if (!empty($vill_lot_no)) {
            $this->db->where('lot_no', $vill_lot_no);
        }
        if (!empty($village_code)) {
            $this->db->where('vill_townprt_code', $village_code);
        }

        $this->db->select('field_mut_basic.*, field_mut_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 'field_mut_basic.case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 'field_mut_basic.case_no = escalation_details.case_no', 'left');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('field_mut_basic.possession_yn', 'y');
        $this->db->where('field_mut_basic.order_passed', null);
        $this->db->where('field_mut_basic.mut_type', '02');

        if ($zone_status == 4) { // for old cases
            $this->db->where('field_mut_basic.es_flag', 0);
        } else {
            $this->db->where('field_mut_basic.es_flag', 1);
        }
        $this->db->limit($length, $start);
        $query = $this->db->get('field_mut_basic');
        // log_message('error', "Field Mut Basic : " . $this->db->last_query());

        if ($query->num_rows() > 0) {

            $data_results = $query->result();
            $final_array = array();

            foreach ($data_results as $rr) {
                $variable = $this->escalationZoneWiseSearchFieldCase($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->report_date, $rr->escalated_date, $this->session->userdata('user_code'), $rr->lm_target_days, $rr->assigned_date, $rr->date_entry, $rr->mut_type);

                if (!empty($variable)) {
                    $final_array[] = $variable;
                }
            }

            $data['data_results'] = $final_array;

            $data['total_records'] = count($final_array);

            if (!empty($mouza_code)) {
                $this->db->where('mouza_pargona_code', $mouza_code);
            }
            if (!empty($lot_no)) {
                $this->db->where('lot_no', $lot_no);
            }
            if (!empty($vill_mouza_code)) {
                $this->db->where('mouza_pargona_code', $vill_mouza_code);
            }
            if (!empty($vill_lot_no)) {
                $this->db->where('lot_no', $vill_lot_no);
            }
            if (!empty($village_code)) {
                $this->db->where('vill_townprt_code', $village_code);
            }
            if (!empty($searchByCol_0)) {
                $this->db->like('case_no', strtoupper($searchByCol_0));
            }
            $this->db->select('field_mut_basic.*, field_mut_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 'field_mut_basic.case_no = basundhar_application.dharitree', 'left');
            $this->db->join('escalation_details', 'field_mut_basic.case_no = escalation_details.case_no', 'left');
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('field_mut_basic.possession_yn', 'y');
            $this->db->where('field_mut_basic.order_passed', null);
            $this->db->where('field_mut_basic.mut_type', '02');

            if ($zone_status == 4) { // for old cases
                $this->db->where('field_mut_basic.es_flag', 0);
            } else {
                $this->db->where('field_mut_basic.es_flag', 1);
            }

            $res = $this->db->get('field_mut_basic')->result();

            $cc = array();

            foreach ($res as $r) {

                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->co_target_days;

                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }

            $data['total_records'] = count($cc);
            return $data;
        }
    }

    public function getPendingFieldPartitionCasesCoEnd($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status)
    {
        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 'field_mut_basic.petition_no',
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
            $this->db->where("(application_ref_no like '%$searchByCol_0%' or case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }

        $this->db->select('field_mut_basic.*, field_mut_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 'field_mut_basic.case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 'field_mut_basic.case_no = escalation_details.case_no', 'left');

        $this->db->where('field_mut_basic.dist_code', $dist_code);
        $this->db->where('field_mut_basic.subdiv_code', $subdiv_code);
        $this->db->where('field_mut_basic.cir_code', $cir_code);

        $this->db->where('field_mut_basic.lm_note', 'Y');
        $this->db->where('field_mut_basic.order_passed', null);
        $this->db->where('date(field_mut_basic.date_entry) >=', $define_date);
        $this->db->where('field_mut_basic.is_dispose', null);
        $this->db->where('field_mut_basic.mut_type', '02');

        if ($zone_status == 4) {
            $this->db->where('field_mut_basic.es_flag', 0);
        } else {
            $this->db->where('field_mut_basic.es_flag', 1);
        }

        $this->db->limit($length, $start);
        $query = $this->db->get('field_mut_basic');

        // echo $this->db->last_query();

        log_message('error', "field_mut_basic: " . $this->db->last_query());

        if ($query->num_rows() > 0) {

            $data_results = $query->result();
            $final_array = array();

            // echo "<pre>";
            // var_dump($data_results);

            foreach ($data_results as $rr) {
                $variable = $this->escalationZoneWiseSearchFieldCase($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->report_date, $rr->escalated_date, $this->session->userdata('user_code'), $rr->co_target_days, $rr->assigned_date, $rr->date_entry, $rr->mut_type);

                if (!empty($variable)) {
                    $final_array[] = $variable;
                }
            }

            $data['data_results'] = $final_array;
            $data['total_records'] = count($final_array);

            // var_dump($data['data_results']);

            if (!empty($searchByCol_0)) {
                $this->db->like('case_no', strtoupper($searchByCol_0));
            }

            $this->db->select('field_mut_basic.*, field_mut_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 'field_mut_basic.case_no = basundhar_application.dharitree', 'left');
            $this->db->join('escalation_details', 'field_mut_basic.case_no = escalation_details.case_no', 'left');

            $this->db->where('field_mut_basic.dist_code', $dist_code);
            $this->db->where('field_mut_basic.subdiv_code', $subdiv_code);
            $this->db->where('field_mut_basic.cir_code', $cir_code);

            $this->db->where('field_mut_basic.lm_note', 'Y');
            $this->db->where('field_mut_basic.order_passed', null);
            $this->db->where('date(field_mut_basic.date_entry) >=', $define_date);
            $this->db->where('field_mut_basic.is_dispose', null);
            $this->db->where('field_mut_basic.mut_type', '02');

            if ($zone_status == 4) {
                $this->db->where('field_mut_basic.es_flag', 0);
            } else {
                $this->db->where('field_mut_basic.es_flag', 1);
            }

            $res = $this->db->get('field_mut_basic')->result();

            $cc = array();

            foreach ($res as $r) {

                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->co_target_days;

                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }

            $data['total_records'] = count($cc);
            return $data;
        }
    }

    public function getPendingOfficePartCaseCOend($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status)
    {
        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 'petition_basic.petition_no',
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
            $this->db->where("(application_ref_no like '%$searchByCol_0%' or petition_basic.case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }

        $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');

        $this->db->where('petition_basic.dist_code', $dist_code);
        $this->db->where('petition_basic.subdiv_code', $subdiv_code);
        $this->db->where('petition_basic.cir_code', $cir_code);

        $this->db->where('petition_basic.not_fresh', null);
        $this->db->where("(petition_basic.status != 'D' or petition_basic.status is null)");
        $this->db->where('petition_basic.lm_note_yn', null);
        $this->db->where('petition_basic.mut_type', '04');

        if ($zone_status == 4) {
            $this->db->where('petition_basic.es_flag', 0);
        } else {
            $this->db->where('petition_basic.es_flag', 1);
        }

        $this->db->limit($length, $start);
        $query = $this->db->get('petition_basic');
        log_message('error', "petition_basic: " . $this->db->last_query());

        if ($query->num_rows() > 0) {

            $data_results = $query->result();
            $final_array = array();

            // echo "<pre>";
            // var_dump($data_results);

            foreach ($data_results as $rr) {
                $variable = $this->escalationZoneWiseSearchPartition($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->submission_date, $rr->escalated_date, $this->session->userdata('user_code'), $rr->co_target_days, $rr->assigned_date, $rr->date_entry, $rr->next_date_of_hearing, $rr->status, $rr->lm_note_yn, $rr->notice_generated_yn, $rr->sk_comment, $rr->proceeding_yn, $rr->petition_no, $rr->comp_serv_yn, $rr->pay_notice_gen_yn, $rr->mut_type);

                if (!empty($variable)) {
                    $final_array[] = $variable;
                }
            }

            $data['data_results'] = $final_array;
            $data['total_records'] = count($final_array);

            // var_dump($data['data_results']);

            if (!empty($searchByCol_0)) {
                $this->db->like('case_no', strtoupper($searchByCol_0));
            }

            $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
            $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');

            $this->db->where('petition_basic.dist_code', $dist_code);
            $this->db->where('petition_basic.subdiv_code', $subdiv_code);
            $this->db->where('petition_basic.cir_code', $cir_code);

            $this->db->where('petition_basic.not_fresh', null);
            $this->db->where("(petition_basic.status != 'D' or petition_basic.status is null)");
            $this->db->where('petition_basic.lm_note_yn', null);
            $this->db->where('petition_basic.mut_type', '04');

            if ($zone_status == 4) {
                $this->db->where('petition_basic.es_flag', 0);
            } else {
                $this->db->where('petition_basic.es_flag', 1);
            }

            $res = $this->db->get('petition_basic')->result();

            // echo $this->db->last_query();

            $cc = array();

            foreach ($res as $r) {

                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->co_target_days;

                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }

            $data['total_records'] = count($cc);
            return $data;
        }
    }

    public function getPendingOfficePartitionCasesForLm($dist_code, $subdiv_code, $cir_code, $lot_no, $mouza, $start, $length, $order, $define_date, $searchByCol_0, $zone_status)
    {
        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 'petition_basic.petition_no',
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
            $this->db->where("(application_ref_no like '%$searchByCol_0%' or case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }
        $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');

        $this->db->where('petition_basic.dist_code', $dist_code);
        $this->db->where('petition_basic.subdiv_code', $subdiv_code);
        $this->db->where('petition_basic.cir_code', $cir_code);
        $this->db->where('petition_basic.lot_no', $lot_no);
        $this->db->where('petition_basic.mouza_pargona_code', $mouza);
        $this->db->where('date(date_entry) >=', $define_date);
        $this->db->where('petition_basic.lm_note_date', null);
        $this->db->where('petition_basic.lm_note_yn', null);
        $this->db->where('petition_basic.not_fresh', 'Y');
        $this->db->where('petition_basic.sk_comment', null);
        $this->db->where('petition_basic.order_passed', null);
        $this->db->where('petition_basic.mut_type', '04');
        $this->db->where('petition_basic.status', 'P');
        $this->db->where("(petition_basic.is_pending!='Y' or petition_basic.is_pending is null)");

        if ($zone_status == 4) {
            $this->db->where('petition_basic.es_flag', 0);
        } else {
            $this->db->where('petition_basic.es_flag', 1);
        }

        $this->db->limit($length, $start);
        $query = $this->db->get('petition_basic');
        // log_message('error', "petition_basic: " . $this->db->last_query());

        if ($query->num_rows() > 0) {

            $data_results = $query->result();
            $final_array = array();

            foreach ($data_results as $rr) {
                $variable = $this->escalationZoneWiseSearchPartition($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->submission_date, $rr->escalated_date, $this->session->userdata('user_code'), $rr->lm_target_days, $rr->assigned_date, $rr->date_entry, $rr->next_date_of_hearing, $rr->status, $rr->lm_note_yn, $rr->notice_generated_yn, $rr->sk_comment, $rr->proceeding_yn, $rr->petition_no, $rr->comp_serv_yn, $rr->pay_notice_gen_yn, $rr->mut_type);

                if (!empty($variable)) {
                    $final_array[] = $variable;
                }
            }

            $data['data_results'] = $final_array;
            $data['total_records'] = count($final_array);

            if (!empty($searchByCol_0)) {
                $this->db->like('case_no', strtoupper($searchByCol_0));
            }

            $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
            $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');

            $this->db->where('petition_basic.dist_code', $dist_code);
            $this->db->where('petition_basic.subdiv_code', $subdiv_code);
            $this->db->where('petition_basic.cir_code', $cir_code);
            $this->db->where('petition_basic.lot_no', $lot_no);
            $this->db->where('petition_basic.mouza_pargona_code', $mouza);
            $this->db->where('date(date_entry) >=', $define_date);
            $this->db->where('petition_basic.lm_note_date', null);
            $this->db->where('petition_basic.lm_note_yn', null);
            $this->db->where('petition_basic.not_fresh', 'Y');
            $this->db->where('petition_basic.sk_comment', null);
            $this->db->where('petition_basic.order_passed', null);
            $this->db->where('petition_basic.mut_type', '04');
            $this->db->where('petition_basic.status', 'P');
            $this->db->where("(petition_basic.is_pending!='Y' or petition_basic.is_pending is null)");

            if ($zone_status == 4) {
                $this->db->where('petition_basic.es_flag', 0);
            } else {
                $this->db->where('petition_basic.es_flag', 1);
            }

            $res = $this->db->get('petition_basic')->result();

            $cc = array();

            foreach ($res as $r) {

                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->co_target_days;

                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }

            $data['total_records'] = count($cc);
            return $data;
        }
    }

    public function getPendingOfficePartitionCasesForSK($dist_code, $subdiv_code, $cir_code, $lot_no, $mouza, $start, $length, $order, $define_date, $searchByCol_0, $zone_status)
    {
        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 'petition_basic.petition_no',
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
            $this->db->where("(application_ref_no like '%$searchByCol_0%' or case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }
        $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');

        $this->db->where('petition_basic.dist_code', $dist_code);
        $this->db->where('petition_basic.subdiv_code', $subdiv_code);
        $this->db->where('petition_basic.cir_code', $cir_code);
        $this->db->where('petition_basic.lot_no', $lot_no);
        $this->db->where('petition_basic.mouza_pargona_code', $mouza);
        $this->db->where('date(date_entry) >=', $define_date);
        // $this->db->where('petition_basic.lm_note_date !=', );
        $this->db->where('petition_basic.lm_note_yn', 'Y');
        $this->db->where('petition_basic.not_fresh', 'Y');
        $this->db->where('petition_basic.sk_comment', null);
        $this->db->where('petition_basic.order_passed', null);
        $this->db->where('petition_basic.mut_type', '04');
        $this->db->where('petition_basic.status', 'P');
        $this->db->where("(petition_basic.is_pending!='Y' or petition_basic.is_pending is null)");

        if ($zone_status == 4) {
            $this->db->where('petition_basic.es_flag', 0);
        } else {
            $this->db->where('petition_basic.es_flag', 1);
        }

        $this->db->limit($length, $start);
        $query = $this->db->get('petition_basic');
        log_message('error', "petition_basic: " . $this->db->last_query());

        if ($query->num_rows() > 0) {

            $data_results = $query->result();

            $final_array = array();

            foreach ($data_results as $rr) {
                $variable = $this->escalationZoneWiseSearchPartition($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->submission_date, $rr->escalated_date, $this->session->userdata('user_code'), $rr->lm_target_days, $rr->assigned_date, $rr->date_entry, $rr->next_date_of_hearing, $rr->status, $rr->lm_note_yn, $rr->notice_generated_yn, $rr->sk_comment, $rr->proceeding_yn, $rr->petition_no, $rr->comp_serv_yn, $rr->pay_notice_gen_yn, $rr->mut_type);
                log_message("error", "===9876 : " . json_encode($variable));
                if (!empty($variable)) {
                    $final_array[] = $variable;
                }
            }
            var_dump($final_array);
            die;
            $data['data_results'] = $final_array;
            $data['total_records'] = count($final_array);

            if (!empty($searchByCol_0)) {
                $this->db->like('case_no', strtoupper($searchByCol_0));
            }

            $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
            $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');

            $this->db->where('petition_basic.dist_code', $dist_code);
            $this->db->where('petition_basic.subdiv_code', $subdiv_code);
            $this->db->where('petition_basic.cir_code', $cir_code);
            $this->db->where('petition_basic.lot_no', $lot_no);
            $this->db->where('petition_basic.mouza_pargona_code', $mouza);
            $this->db->where('date(date_entry) >=', $define_date);
            // $this->db->where('petition_basic.lm_note_date ', null);
            $this->db->where('petition_basic.lm_note_yn ', 'Y');
            $this->db->where('petition_basic.not_fresh', 'Y');
            $this->db->where('petition_basic.sk_comment', null);
            $this->db->where('petition_basic.order_passed', null);
            $this->db->where('petition_basic.mut_type', '04');
            $this->db->where('petition_basic.status', 'P');
            $this->db->where("(petition_basic.is_pending!='Y' or petition_basic.is_pending is null)");

            if ($zone_status == 4) {
                $this->db->where('petition_basic.es_flag', 0);
            } else {
                $this->db->where('petition_basic.es_flag', 1);
            }

            $res = $this->db->get('petition_basic')->result();

            $cc = array();

            foreach ($res as $r) {

                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->co_target_days;

                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }

            $data['total_records'] = count($cc);
            return $data;
        }
    }

    public function escalationZoneWiseSearchPartition($zone_status, $es_flag, $c_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $rtps_no, $submission_date, $escalated_date, $user_code, $co_target_days, $assigned_date, $date_entry, $next_date_of_hearing, $status, $lm_note_yn, $notice_generated_yn, $sk_comment, $proceeding_yn, $petition_no, $comp_serv_yn, $pay_notice_gen_yn, $mut_type)
    {
        // log_message("error","098".$zone_status.$es_flag.$c_no.$dist_code.$subdiv_code.$cir_code.$mouza_pargona_code.$lot_no.$vill_townprt_code.$rtps_no.$submission_date.$escalated_date.$user_code.$co_target_days.$assigned_date.$date_entry.$next_date_of_hearing.$status.$lm_note_yn.$notice_generated_yn.$sk_comment.$proceeding_yn.$petition_no.$comp_serv_yn.$pay_notice_gen_yn.$mut_type);
        $curr_date = date('Y-m-d');
        $esc_date = $escalated_date;
        $esc_flag = $es_flag;
        $final_array = array();

        if (!empty($zone_status) && ($esc_date != null || $esc_date != '') && ($esc_flag == 1)) {
            $remaining_days = $this->dateDiff($esc_date, $curr_date);
            $per_avail = (100 * $remaining_days) / $co_target_days;

            //green zone
            if (($zone_status == 1) && ($per_avail >= YELLOW_ZONE)) {
                log_message('error', "1============");
                $final_array = (object) [
                    'case_no' => $c_no,
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'basundhara' => $rtps_no,
                    'submission_date' => $submission_date,
                    'escalated_date' => $escalated_date,
                    'es_flag' => $es_flag,
                    'assigned_from' => $user_code,
                    'co_target_days' => $co_target_days,
                    'assigned_date' => $assigned_date,
                    'date_entry' => $date_entry,
                    'application_ref_no' => $rtps_no,
                    'next_date_of_hearing' => $next_date_of_hearing,
                    'status' => $status,
                    'lm_note_yn' => $lm_note_yn,
                    'notice_generated_yn' => $notice_generated_yn,
                    'sk_comment' => $sk_comment,
                    'proceeding_yn' => $proceeding_yn,
                    'petition_no' => $petition_no,
                    'comp_serv_yn' => $comp_serv_yn,
                    'pay_notice_gen_yn' => $pay_notice_gen_yn,
                    'mut_type' => $mut_type,
                ];
            }

            //yellow zone
            else if (($zone_status == 2) && (($per_avail < YELLOW_ZONE) && ($per_avail > RED_ZONE))) {
                log_message('error', "21============");
                $final_array = (object) [
                    'case_no' => $c_no,
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'basundhara' => $rtps_no,
                    'submission_date' => $submission_date,
                    'escalated_date' => $escalated_date,
                    'es_flag' => $es_flag,
                    'assigned_from' => $user_code,
                    'co_target_days' => $co_target_days,
                    'assigned_date' => $assigned_date,
                    'date_entry' => $date_entry,
                    'application_ref_no' => $rtps_no,
                    'next_date_of_hearing' => $next_date_of_hearing,
                    'status' => $status,
                    'lm_note_yn' => $lm_note_yn,
                    'notice_generated_yn' => $notice_generated_yn,
                    'sk_comment' => $sk_comment,
                    'proceeding_yn' => $proceeding_yn,
                    'petition_no' => $petition_no,
                    'comp_serv_yn' => $comp_serv_yn,
                    'pay_notice_gen_yn' => $pay_notice_gen_yn,
                    'mut_type' => $mut_type,
                ];
            }

            //red zone
            else if (($zone_status == 3) && ($per_avail <= RED_ZONE)) {
                log_message('error', "31============");
                $final_array = (object) [
                    'case_no' => $c_no,
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'basundhara' => $rtps_no,
                    'submission_date' => $submission_date,
                    'escalated_date' => $escalated_date,
                    'es_flag' => $es_flag,
                    'assigned_from' => $user_code,
                    'co_target_days' => $co_target_days,
                    'assigned_date' => $assigned_date,
                    'date_entry' => $date_entry,
                    'application_ref_no' => $rtps_no,
                    'next_date_of_hearing' => $next_date_of_hearing,
                    'status' => $status,
                    'lm_note_yn' => $lm_note_yn,
                    'notice_generated_yn' => $notice_generated_yn,
                    'sk_comment' => $sk_comment,
                    'proceeding_yn' => $proceeding_yn,
                    'petition_no' => $petition_no,
                    'comp_serv_yn' => $comp_serv_yn,
                    'pay_notice_gen_yn' => $pay_notice_gen_yn,
                    'mut_type' => $mut_type,
                ];
            }

            //old cases
            else if ($zone_status == 4) {
                log_message('error', "41============");
                $final_array = (object) [
                    'case_no' => $c_no,
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'basundhara' => $rtps_no,
                    'submission_date' => $submission_date,
                    'escalated_date' => $escalated_date,
                    'es_flag' => $es_flag,
                    'assigned_from' => $user_code,
                    'co_target_days' => $co_target_days,
                    'assigned_date' => $assigned_date,
                    'date_entry' => $date_entry,
                    'application_ref_no' => $rtps_no,
                    'next_date_of_hearing' => $next_date_of_hearing,
                    'status' => $status,
                    'lm_note_yn' => $lm_note_yn,
                    'notice_generated_yn' => $notice_generated_yn,
                    'sk_comment' => $sk_comment,
                    'proceeding_yn' => $proceeding_yn,
                    'petition_no' => $petition_no,
                    'comp_serv_yn' => $comp_serv_yn,
                    'pay_notice_gen_yn' => $pay_notice_gen_yn,
                    'mut_type' => $mut_type,
                ];
            }
        } else {
            log_message('error', "51============");
            $final_array = (object) [
                'case_no' => $c_no,
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'basundhara' => $rtps_no,
                'submission_date' => $submission_date,
                'escalated_date' => $escalated_date,
                'es_flag' => $es_flag,
                'assigned_from' => $user_code,
                'co_target_days' => $co_target_days,
                'assigned_date' => $assigned_date,
                'date_entry' => $date_entry,
                'application_ref_no' => $rtps_no,
                'next_date_of_hearing' => $next_date_of_hearing,
                'status' => $status,
                'lm_note_yn' => $lm_note_yn,
                'notice_generated_yn' => $notice_generated_yn,
                'sk_comment' => $sk_comment,
                'proceeding_yn' => $proceeding_yn,
                'petition_no' => $petition_no,
                'comp_serv_yn' => $comp_serv_yn,
                'pay_notice_gen_yn' => $pay_notice_gen_yn,
                'mut_type' => $mut_type,
            ];
        }

        return $final_array;
    }

    public function getPendingOfficePartitionCasesForAstNoticeGenrate($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status)
    {
        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 'petition_basic.petition_no',
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
            $this->db->where("(application_ref_no like '%$searchByCol_0%' or case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }
        $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');

        $this->db->where('petition_basic.dist_code', $dist_code);
        $this->db->where('petition_basic.subdiv_code', $subdiv_code);
        $this->db->where('petition_basic.cir_code', $cir_code);
        $this->db->where('petition_basic.not_fresh', 'Y');
        $this->db->where('petition_basic.status', 'P');
        $this->db->where('petition_basic.mut_type', '04');
        $this->db->where("(petition_basic.notice_generated_yn is null or petition_basic.notice_generated_yn='')");

        if ($zone_status == 4) {
            $this->db->where('petition_basic.es_flag', 0);
        } else {
            $this->db->where('petition_basic.es_flag', 1);
        }

        $this->db->limit($length, $start);
        $query = $this->db->get('petition_basic');
        log_message('error', "petition_basic: " . $this->db->last_query());

        if ($query->num_rows() > 0) {

            $data_results = $query->result();
            $final_array = array();

            foreach ($data_results as $rr) {
                $variable = $this->escalationZoneWiseSearchPartition($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->submission_date, $rr->assigned_other_es_date, $this->session->userdata('user_code'), $rr->da_target_days, $rr->assigned_other_date, $rr->date_entry, $rr->next_date_of_hearing, $rr->status, $rr->lm_note_yn, $rr->notice_generated_yn, $rr->sk_comment, $rr->proceeding_yn, $rr->petition_no, $rr->comp_serv_yn, $rr->pay_notice_gen_yn, $rr->mut_type);

                if (!empty($variable)) {
                    $final_array[] = $variable;
                }
            }

            $data['data_results'] = $final_array;
            $data['total_records'] = count($final_array);

            if (!empty($searchByCol_0)) {
                $this->db->like('case_no', strtoupper($searchByCol_0));
            }

            $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
            $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');

            $this->db->where('petition_basic.dist_code', $dist_code);
            $this->db->where('petition_basic.subdiv_code', $subdiv_code);
            $this->db->where('petition_basic.cir_code', $cir_code);
            $this->db->where('petition_basic.not_fresh', 'Y');
            $this->db->where('petition_basic.status', 'P');
            $this->db->where('petition_basic.mut_type', '04');
            $this->db->where("(petition_basic.notice_generated_yn is null or petition_basic.notice_generated_yn='')");

            if ($zone_status == 4) {
                $this->db->where('petition_basic.es_flag', 0);
            } else {
                $this->db->where('petition_basic.es_flag', 1);
            }

            $res = $this->db->get('petition_basic')->result();

            $cc = array();

            foreach ($res as $r) {

                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->co_target_days;

                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }

            $data['total_records'] = count($cc);
            return $data;
        }
    }

    public function getPendingOfficePartitionCasesForAstActionTaken($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status)
    {
        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 'petition_basic.petition_no',
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
            $this->db->where("(application_ref_no like '%$searchByCol_0%' or case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }
        $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');

        $this->db->where('petition_basic.dist_code', $dist_code);
        $this->db->where('petition_basic.subdiv_code', $subdiv_code);
        $this->db->where('petition_basic.cir_code', $cir_code);
        $this->db->where('petition_basic.not_fresh', 'Y');
        $this->db->where('date(petition_basic.date_entry) >=', $define_date);
        $this->db->where('petition_basic.status', 'P');
        $this->db->where('petition_basic.mut_type', '04');
        $this->db->where("(petition_basic.proceeding_yn is null or petition_basic.proceeding_yn='')");

        if ($zone_status == 4) {
            $this->db->where('petition_basic.es_flag', 0);
        } else {
            $this->db->where('petition_basic.es_flag', 1);
        }

        $this->db->limit($length, $start);
        $query = $this->db->get('petition_basic');
        log_message('error', "petition_basic: " . $this->db->last_query());

        if ($query->num_rows() > 0) {

            $data_results = $query->result();
            $final_array = array();

            foreach ($data_results as $rr) {
                $variable = $this->escalationZoneWiseSearchPartition($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->submission_date, $rr->assigned_other_es_date, $this->session->userdata('user_code'), $rr->da_target_days, $rr->assigned_other_date, $rr->date_entry, $rr->next_date_of_hearing, $rr->status, $rr->lm_note_yn, $rr->notice_generated_yn, $rr->sk_comment, $rr->proceeding_yn, $rr->petition_no, $rr->comp_serv_yn, $rr->pay_notice_gen_yn, $rr->mut_type);

                if (!empty($variable)) {
                    $final_array[] = $variable;
                }
            }

            $data['data_results'] = $final_array;
            $data['total_records'] = count($final_array);

            if (!empty($searchByCol_0)) {
                $this->db->like('case_no', strtoupper($searchByCol_0));
            }

            $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
            $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');

            $this->db->where('petition_basic.dist_code', $dist_code);
            $this->db->where('petition_basic.subdiv_code', $subdiv_code);
            $this->db->where('petition_basic.cir_code', $cir_code);
            $this->db->where('petition_basic.not_fresh', 'Y');
            $this->db->where('date(petition_basic.date_entry) >=', $define_date);
            $this->db->where('petition_basic.status', 'P');
            $this->db->where('petition_basic.mut_type', '04');
            $this->db->where("(petition_basic.proceeding_yn is null or petition_basic.proceeding_yn='')");

            if ($zone_status == 4) {
                $this->db->where('petition_basic.es_flag', 0);
            } else {
                $this->db->where('petition_basic.es_flag', 1);
            }

            $res = $this->db->get('petition_basic')->result();

            $cc = array();

            foreach ($res as $r) {

                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->co_target_days;

                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }

            $data['total_records'] = count($cc);
            return $data;
        }
    }

    public function getSecondProceedPendingPartitionCasesCoEnd($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $mouza_code, $lot_no, $define_date, $zone_status, $searchByCol_0)
    {
        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 'petition_basic.petition_no',
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
            $this->db->where("(application_ref_no like '%$searchByCol_0%' or case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }
        if (!empty($mouza_code)) {
            $this->db->where('mouza_pargona_code', $mouza_code);
        }
        if (!empty($lot_no)) {
            $this->db->where('lot_no', $lot_no);
        }

        $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
        $this->db->join('landsale', 'petition_basic.noc_no = landsale.appno', 'left');
        $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');

        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('date(date_entry) >=', $define_date);

        $this->db->where('petition_basic.co_user_code', $this->session->userdata('user_code'));
        $this->db->where('petition_basic.not_fresh', 'Y');
        $this->db->where('petition_basic.status', 'P');
        $this->db->where('petition_basic.mut_type', '04');

        if ($zone_status == 4) {
            $this->db->where('petition_basic.es_flag', 0);
        } else {
            $this->db->where('petition_basic.es_flag', 1);
        }

        $this->db->limit($length, $start);
        $query = $this->db->get('petition_basic');
        log_message('error', "petition_basic: " . $this->db->last_query());

        if ($query->num_rows() > 0) {

            $data_results = $query->result();
            $final_array = array();

            foreach ($data_results as $rr) {
                $variable = $this->escalationZoneWiseSearchPartition($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->submission_date, $rr->escalated_date, $this->session->userdata('user_code'), $rr->co_target_days, $rr->assigned_date, $rr->date_entry, $rr->next_date_of_hearing, $rr->status, $rr->lm_note_yn, $rr->notice_generated_yn, $rr->sk_comment, $rr->proceeding_yn, $rr->petition_no, $rr->comp_serv_yn, $rr->pay_notice_gen_yn, $rr->mut_type);

                if (!empty($variable)) {
                    $final_array[] = $variable;
                }
            }

            $data['data_results'] = $final_array;
            $data['total_records'] = count($final_array);

            if (!empty($mouza_code)) {
                $this->db->where('mouza_pargona_code', $mouza_code);
            }
            if (!empty($lot_no)) {
                $this->db->where('lot_no', $lot_no);
            }
            if (!empty($searchByCol_0)) {
                $this->db->like('case_no', strtoupper($searchByCol_0));
            }

            $this->db->select('petition_basic.*, petition_basic.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 'petition_basic.case_no = basundhar_application.dharitree', 'left');
            $this->db->join('landsale', 'petition_basic.noc_no = landsale.appno', 'left');
            $this->db->join('escalation_details', 'petition_basic.case_no = escalation_details.case_no', 'left');

            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('date(date_entry) >=', $define_date);

            $this->db->where('petition_basic.co_user_code', $this->session->userdata('user_code'));
            $this->db->where('petition_basic.not_fresh', 'Y');
            $this->db->where('petition_basic.status', 'P');
            $this->db->where('petition_basic.mut_type', '04');

            if ($zone_status == 4) {
                $this->db->where('petition_basic.es_flag', 0);
            } else {
                $this->db->where('petition_basic.es_flag', 1);
            }
            $res = $this->db->get('petition_basic')->result();

            $cc = array();

            foreach ($res as $r) {

                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->co_target_days;

                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }
            $data['total_records'] = count($cc);
            return $data;
        }
    }

    public function getEscaltionViewFormat($cases)
    {
        // log_message('error', "#ERR9663: CASE_LIST_MODEL ".json_encode($cases));
        foreach ($cases as $rows) {
            if ($rows->es_flag == '1') {

                $escRow = $this->getEscalatedRowDetailsCaseNo($rows->case_no);

                // log_message('error', '#55: Data from escalation_details : ' . json_encode($escRow));
                // log_message('error', '#60: Last_query_escalation_details : ' . json_encode($this->db->last_query()));
                // log_message("error", "#56" . $escRow->assigned_date);

                if (!empty($escRow)) 
                {

                    // log_message("error", "getEscalationZoneDetails ".json_encode('case_no->'.$rows->case_no.', es_flag->'.$rows->es_flag.', assigned_to->'.$escRow->assigned_to.', co_target_days->'.$escRow->co_target_days.' assigned_date->'.$escRow->assigned_date.', escalated_date->'.$escRow->escalated_date.', date_entry->'.$rows->date_entry));

                    $escData = json_decode($this->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));

                    // log_message('error', '#63: Escalation details : ' . json_encode($escData));

                    $rows->escalation_date = $escData->escalation_date;
                    $rows->escalation_zone = $escData->escalation_zone;
                    $rows->assigned_date = $escData->assigned_date;
                } else {
                    $rows->escalation_date = 'NA';
                    $rows->escalation_zone = 'NA';
                }

            } else {
                $rows->escalation_date = 'NA';
                $rows->escalation_zone = 'NA';
            }
        }
    }

    //get pending office partition cases in co end--------SEARCH-13022023
    public function getPendingAreaCaseLMend($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $mouza_code, $lot_no, $vill_mouza_code, $vill_lot_no, $village_code, $searchByCol_0, $zone_status)
    {
        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 't_legacyupdation.proposal_no',
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
            $this->db->where("(case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }
        if (!empty($mouza_code)) {
            $this->db->where('mouza_pargona_code', $mouza_code);
        }
        if (!empty($lot_no)) {
            $this->db->where('lot_no', $lot_no);
        }
        if (!empty($vill_mouza_code)) {
            $this->db->where('mouza_pargona_code', $vill_mouza_code);
        }
        if (!empty($vill_lot_no)) {
            $this->db->where('lot_no', $vill_lot_no);
        }
        if (!empty($village_code)) {
            $this->db->where('vill_townprt_code', $village_code);
        }

        $this->db->select('t_legacyupdation.*, t_legacyupdation.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 't_legacyupdation.case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 't_legacyupdation.case_no = escalation_details.case_no', 'left');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('t_legacyupdation.lm_note', 'y');

        if ($zone_status == 4) { // for old cases
            $this->db->where('t_legacyupdation.es_flag', 0);
        } else {
            $this->db->where('t_legacyupdation.es_flag', 1);
        }
        $this->db->limit($length, $start);
        $query = $this->db->get('t_legacyupdation');

        if ($query->num_rows() > 0) {

            $data_results = $query->result();
            $final_array = array();

            foreach ($data_results as $rr) {
                $variable = $this->escalationZoneWiseSearchFieldCase($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->lm_date, $rr->escalated_date, $this->session->userdata('user_code'), $rr->lm_target_days, $rr->assigned_date, $rr->lm_date, null);

                if (!empty($variable)) {
                    $final_array[] = $variable;
                }
            }

            $data['data_results'] = $final_array;

            $data['total_records'] = count($final_array);

            if (!empty($mouza_code)) {
                $this->db->where('mouza_pargona_code', $mouza_code);
            }
            if (!empty($lot_no)) {
                $this->db->where('lot_no', $lot_no);
            }
            if (!empty($vill_mouza_code)) {
                $this->db->where('mouza_pargona_code', $vill_mouza_code);
            }
            if (!empty($vill_lot_no)) {
                $this->db->where('lot_no', $vill_lot_no);
            }
            if (!empty($village_code)) {
                $this->db->where('vill_townprt_code', $village_code);
            }
            if (!empty($searchByCol_0)) {
                $this->db->like('case_no', strtoupper($searchByCol_0));
            }
            $this->db->select('t_legacyupdation.*, t_legacyupdation.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 't_legacyupdation.case_no = basundhar_application.dharitree', 'left');
            $this->db->join('escalation_details', 't_legacyupdation.case_no = escalation_details.case_no', 'left');
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('t_legacyupdation.lm_note', 'y');
            if ($zone_status == 4) { // for old cases
                $this->db->where('t_legacyupdation.es_flag', 0);
            } else {
                $this->db->where('t_legacyupdation.es_flag', 1);
            }

            $res = $this->db->get('t_legacyupdation')->result();

            $cc = array();

            foreach ($res as $r) {

                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->co_target_days;

                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }

            $data['total_records'] = count($cc);
            return $data;
        }
    }
    public function escalationLMReportACOR($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code)
    {

        $executionDate = date('Y-m-d');
        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');

        $user_type = 'LM';
        $service_code = '7';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'CO';
        $assigned_to_other_type = null;
        $finalStatus = null;
        $assigned_to_other = null;
        $hearing_date = null;
        $task = json_decode(ACOR);
        $taskid = $task[1]->CODE;
        $assignment_type = null;
        $assignment_type_other = null;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateACOR($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);

        return $escalationUpdateStatus;
    }
    public function escalationCOReportACOR($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code, $assignUser)
    {
        if ($assignUser == 'ADC') {
            $assigned_user_type = 'ADC';
            $assigned_to = $this->Escalationmodel->getPendingOfficerADC($dist_code, 'ADC');
        } else {
            $assigned_user_type = 'DC';
            $assigned_to = $this->Escalationmodel->getPendingOfficerDC($dist_code, 'DC');
        }

        $assigned_to_other = null;
        $hearing_date = null;
        $user_type = 'CO';
        $service_code = '7';
        $assigned_to_code = $assigned_to->user_code;

        $assigned_to_other_type = null;
        $finalStatus = null;
        $assigned_to_other = null;
        $task = json_decode(ACOR);
        $taskid = $task[2]->CODE;
        $assignment_type = null;
        $assignment_type_other = null;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->escalationMatrixUpdateACOR($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;
    }

    public function escalationADCDCFinalReportACOR($executionDate, $dist_code, $case_no, $user_code, $assignUser)
    {

        if ($assignUser == 'ADC') {
            $assigned_user_type = 'ADC';
            $assigned_to = $this->Escalationmodel->getPendingOfficerADC($dist_code, 'ADC');
        } else {
            $assigned_user_type = 'DC';
            $assigned_to = $this->Escalationmodel->getPendingOfficerDC($dist_code, 'DC');
        }

        $executionDate = $executionDate;
        $user_type = $assigned_user_type;
        $service_code = '7';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = $assigned_user_type;
        $assigned_to_other_type = null;
        $finalStatus = 'final';
        $assigned_to_other = null;
        $hearing_date = null;
        $task = json_decode(ACOR);
        $taskid = $task[4]->CODE;
        $assignment_type = null;
        $assignment_type_other = null;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateACOR($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);

        return $escalationUpdateStatus;
    }

    public function escalationMatrixUpdateACOR($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days)
    {
        $executionDate = date('Y-m-d H:i:s');
        $response = array('responseType' => 1, 'msg' => null);
        $petition_no = $this->getPetitionNoACOR($case_no);
        if ($petition_no == null || $petition_no == '') {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION10130 : Petition No not found';
            return $response;
        }
        // WARNING BEFORE CODE=========================
        // $assigned_to_other_type may be notice or role name
        ///////////////////////////////////

        $escalatedRowDetailsAgainstPetitionno = $this->getEscalatedRowDetails($petition_no,$service_code);
        if ($escalatedRowDetailsAgainstPetitionno == null || empty($escalatedRowDetailsAgainstPetitionno)) {
            log_message('error', '#ERRESCLATION10142 : Escalation matrix row not found');
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION10142 : Escalation matrix row not found';
            return $response;
        }
        $assigned_other_code = $assigned_to_code = $assigned_from_code = null;
        $userCodeList = json_decode(USER_ALLOT_CODE);
        foreach ($userCodeList as $key => $value) {
            if ($value->USER == $user_type) {
                $assigned_from_code = $value->CODE;
            }
            if ($value->USER == $assigned_user_type) {
                $assigned_to_code = $value->CODE;
            }
            if ($value->USER == $assigned_to_other_type) {
                $assigned_other_code = $value->CODE;
            }
        }

        $lastAssignedDate = $escalatedRowDetailsAgainstPetitionno->assigned_date;
        $lastEscalatedDate = $escalatedRowDetailsAgainstPetitionno->escalated_date;
        if ($user_type == 'AST') {
            $lastEscalatedDate = $escalatedRowDetailsAgainstPetitionno->assigned_other_es_date;
        }
        $validateExecutionDateTime = $this->checkCaseExecutionOnTimeOrNot($executionDate, $lastAssignedDate, $lastEscalatedDate);
        if ($validateExecutionDateTime == 'n') {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION10394 : Case Execution not on time';
            return $response;
        }
        // log_message("error","ASSIGNED_DATE=======".$lastAssignedDate);
        $timeLineRow = $this->getTimeLine($service_code, 'ACOR');
        if ($timeLineRow == null || empty($timeLineRow)) {
            log_message('error', '#ERRESCLATION10167 : Escalation Timeline not found');
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION10167 : Escalation Timeline not found';
            return $response;
        }

        $doubleEntry = 0;
        if ($assigned_user_type == 'LM') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
            $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
            // log_message("error","previousCompletedDaysLM--------------".$previousCompletedDaysLM);
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysLM, $originalAllocation);
            if ($remaining_days_other == null || $remaining_days_other == 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            $escalatedDate = $this->getEscalatedDate($remaining_days_other);

        } elseif ($assigned_user_type == 'CO') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO, $originalAllocation);
            if ($remaining_days_other == null || $remaining_days_other == 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            $escalatedDate = $this->getEscalatedDate($remaining_days_other);

        } elseif ($assigned_user_type == 'ADC') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->adc_target_days;
            $previousCompletedDaysADC = $escalatedRowDetailsAgainstPetitionno->adc_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysADC, $originalAllocation);
            if ($remaining_days_other == null || $remaining_days_other == 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);
        } elseif ($assigned_user_type == 'DC') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->dc_target_days;
            $previousCompletedDaysDC = $escalatedRowDetailsAgainstPetitionno->dc_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysDC, $originalAllocation);
            if ($remaining_days_other == null || $remaining_days_other == 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);
        }

        $dateCode = $this->generateDateCode();
        // log_message("error","TYPE ".$user_type." =====ESCALATED_DATE=======".$escalatedDate);
        if ($user_type == 'CO') {
            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);
            $dateCodes = $escalatedRowDetailsAgainstPetitionno->co_date_code_list;

            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->co_completed_days;

            $co_target_days = $escalatedRowDetailsAgainstPetitionno->co_target_days;

            // log_message("error","========CO-TARGET_DAYS =======".$co_target_days);

            $co_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);

            // log_message("error","========CO-COMPLETION_DAYS=======".$co_completed_days);
            if ($co_target_days < $co_completed_days) {
                $escalate_status = 'Y';
            } else {
                $escalate_status = 'N';
            }
            // log_message("error","CO-ESCALATE_STATUS=======".$escalate_status);
            $latestHistoryCode = $dateCodes;
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }
            $entryTimes = 0;
            $doubleEntry = 0;
            $assigned_other_date = null;
            $to_be_other_completed_within_days = null;
            $assigned_other_es_date = null;
            if ($assigned_to_other != null) {
                //this is designed for CO first proceding as assigned to LM and DA==========
                $entryTimes = 1;
                //////////

                $assigned_other_date = $executionDate;
                if ($assigned_to_other_type == 'LM') {

                    $originalAllocation = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
                    $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
                    $remaining_days_other = $this->getRemainingDays($previousCompletedDaysLM, $originalAllocation);
                    if ($remaining_days_other == null || $remaining_days_other == 0) {
                        $response['responseType'] = 0;
                        $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                        return $response;
                    }
                    $assigned_other_es_date = $this->getEscalatedDate($remaining_days_other);
                    $to_be_other_completed_within_days = $this->dateDiff($assigned_other_es_date, $executionDate);
                } elseif ($assigned_to_other_type == 'AST') {

                    $originalAllocation = $escalatedRowDetailsAgainstPetitionno->da_target_days;
                    $previousCompletedDaysDA = $escalatedRowDetailsAgainstPetitionno->da_completed_days;
                    $remaining_days_other = $this->getRemainingDays($previousCompletedDaysDA, $originalAllocation);
                    if ($remaining_days_other == null || $remaining_days_other == 0) {
                        $response['responseType'] = 0;
                        $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                        return $response;
                    }
                    $assigned_other_es_date = $this->getEscalatedDate($remaining_days_other);
                    $to_be_other_completed_within_days = $this->dateDiff($assigned_other_es_date, $executionDate);
                }

            }
            $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);

            $updateArray = array(
                'taskid' => $taskid,
                'co_completed_days' => (int) $co_completed_days + (int) $previousCompletedDays,
                'co_escalate_status' => $escalate_status,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_date' => $executionDate,
                'escalated_date' => $escalatedDate,
                'to_be_completed_within_days' => $to_be_completed_within_days,
                'co_date_code_list' => $dateCodes,
                'assignment_type' => $assignment_type,
                'assignment_type_other' => $assignment_type_other,
                'assigned_other' => $assigned_to_other,
                'assigned_other_code' => $assigned_other_code,
                'assigned_other_date' => $assigned_other_date,
                'assigned_other_es_date' => $assigned_other_es_date,
                'to_be_other_completed_within_days' => $to_be_other_completed_within_days,
            );

        }

        if ($user_type == 'ADC') {
            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);
            $dateCodes = $escalatedRowDetailsAgainstPetitionno->adc_date_code_list;

            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->adc_completed_days;

            $adc_target_days = $escalatedRowDetailsAgainstPetitionno->adc_target_days;

            // log_message("error","========ADC-TARGET_DAYS =======".$adc_target_days);

            $adc_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);

            // log_message("error","========ADC-COMPLETION_DAYS=======".$adc_completed_days);
            if ($adc_target_days < $adc_completed_days) {
                $escalate_status = 'Y';
            } else {
                $escalate_status = 'N';
            }
            // log_message("error","ADC-ESCALATE_STATUS=======".$escalate_status);
            $latestHistoryCode = $dateCodes;
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }
            $entryTimes = 0;
            $doubleEntry = 0;
            $assigned_other_date = null;
            $to_be_other_completed_within_days = null;
            $assigned_other_es_date = null;

            $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);

            $updateArray = array(
                'taskid' => $taskid,
                'adc_completed_days' => (int) $adc_completed_days + (int) $previousCompletedDays,
                'adc_escalate_status' => $escalate_status,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_date' => $executionDate,
                'escalated_date' => $escalatedDate,
                'to_be_completed_within_days' => $to_be_completed_within_days,
                'adc_date_code_list' => $dateCodes,
            );

        }

        if ($user_type == 'DC') {

            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);

            $dateCodes = $escalatedRowDetailsAgainstPetitionno->dc_date_code_list;
            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->dc_completed_days;
            $dc_target_days = $escalatedRowDetailsAgainstPetitionno->dc_target_days;

            // log_message("error","DC-TARGET_DAYS=======".$dc_target_days);
            $dc_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);
            // log_message("error","DC-COMPLETION_DAYS=======".$dc_completed_days);
            if ($dc_target_days < $dc_completed_days) {
                $escalate_status = 'Y';
            } else {
                $escalate_status = 'N';
            }
            // log_message("error","DC-ESCALATE_STATUS=======".$escalate_status);
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }

            // if($assigned_to_other_type == 'LMRevert'){
            //   //this calculation is for assigning CO from LM and taking hearing date as assigned date AS REVERT CASE====
            //   $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            //   $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            //   $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
            //   $assigned_other_es_date = $this->getOtherEscalatedDate($remaining_days_other,$hearing_date);
            //   $to_be_completed_within_days = $this->dateDiff($assigned_other_es_date,$hearing_date);
            //   log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);
            //   $executionDate = $hearing_date;
            //   $escalatedDate = $assigned_other_es_date;
            // }
            $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);
            $updateArray = array(
                'taskid' => $taskid,
                'dc_completed_days' => (int) $dc_completed_days + (int) $previousCompletedDays,
                'dc_escalate_status' => $escalate_status,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_date' => $executionDate,
                'escalated_date' => $escalatedDate,
                'dc_date_code_list' => $dateCodes,
                'to_be_completed_within_days' => $to_be_completed_within_days,
            );

        }

        if ($user_type == 'LM') {

            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);

            $dateCodes = $escalatedRowDetailsAgainstPetitionno->lm_date_code_list;
            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
            $lm_target_days = $escalatedRowDetailsAgainstPetitionno->lm_target_days;

            // log_message("error","LM-TARGET_DAYS=======".$lm_target_days);
            $lm_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);
            // log_message("error","LM-COMPLETION_DAYS=======".$lm_completed_days);
            if ($lm_target_days < $lm_completed_days) {
                $escalate_status = 'Y';
            } else {
                $escalate_status = 'N';
            }
            // log_message("error","LM-ESCALATE_STATUS=======".$escalate_status);
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }

            // //this calculation is for assigning CO from SK and taking hearing date as assigned date====
            // $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            // $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            // $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
            // // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            // $assigned_other_es_date = $this->getOtherEscalatedDate($remaining_days_other,$hearing_date);
            // $to_be_completed_within_days = $this->dateDiff($assigned_other_es_date,$hearing_date);
            // log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);
            // ///end==============

            $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);
            $updateArray = array(
                'taskid' => $taskid,
                'lm_completed_days' => (int) $lm_completed_days + (int) $previousCompletedDays,
                'lm_escalate_status' => $escalate_status,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_date' => $executionDate,
                'escalated_date' => $escalatedDate,
                'lm_date_code_list' => $dateCodes,
                'to_be_completed_within_days' => $to_be_completed_within_days,
            );

        }

        //UPDATE ESCALATION DATE HISTORY TABLE=====================

        $updateFlag = true;
        $history_id = $escalatedRowDetailsAgainstPetitionno->history_id;

        // log_message("error","UPDATED FLAG ==========".$updateFlag);

        //STEPS to be followed:
        // 1. update escalation_dates_details against or history id
        // 2.update escalation_details with new date codes without history id
        // 3.insert history details and updated escalattion details with new history id

        $where_history = array(
            'petition_no' => $petition_no,
            'date_code' => $history_id,
            'service_code' => $service_code
        );
        $updateDatesArray = array(
            'completion_date' => $executionDate,
            'escalated_status' => $escalate_status,
            'completion_days' => $completion_days_for_history,
        );

        $updateStatus22 = $this->db->update('escalation_dates_details', $updateDatesArray, $where_history);
        log_message("error", "UPDt history escalation_dates_details TABLE=======" . $this->db->affected_rows());
        if ($this->db->affected_rows() <= 0) {
            log_message('error', '#ERRESCLATION10473 : Updation failed on escalation_dates_details' . json_encode($this->db->last_query()));
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION10473 : Updation failed on escalation_dates_details';
            return $response;
        }

        ///////////////END PROCESS//////////////////////////

        $where = array(
            'petition_no' => $petition_no,
        );
        if ($finalStatus == 'final') {
            unset($updateArray['assigned_to']);
            unset($updateArray['assigned_to_code']);
            unset($updateArray['assigned_from']);
            unset($updateArray['assigned_from_code']);
            unset($updateArray['assigned_date']);
            unset($updateArray['escalated_date']);
            unset($updateArray['to_be_completed_within_days']);
            unset($updateArray['dc_date_code_list']);
            unset($updateArray['adc_date_code_list']);

            $updateArray['assignment_type_other'] = null;
            $updateArray['assigned_other'] = null;
            $updateArray['assigned_other_code'] = null;
            $updateArray['assigned_other_date'] = null;
            $updateArray['assigned_other_es_date'] = null;
            $updateArray['to_be_other_completed_within_days'] = null;
            $updateArray['final_completion_date'] = $executionDate;
            $updateArray['status'] = 'F';

        }

        log_message('error', "FINAL UPDATED ARRAY===============" . json_encode($updateArray));
        $updateStatus1 = $this->db->update('escalation_details', $updateArray, $where);

        // log_message("error","ESCALATION DETAILS ENTRY TABLE=======".$this->db->affected_rows());
        // if($this->db->affected_rows() <= 0){
        //    $flag = 0;
        // }else{
        //    $flag = 1;
        // }
        if ($this->db->affected_rows() <= 0) {
            log_message('error', '#ERRESCLATION10517 : Updation failed on escalation_details' . json_encode($this->db->last_query()));
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION10517 : Updation failed on escalation_details';
            return $response;
        }

        if ($doubleEntry == 0 && $finalStatus == null) {

            $action_type = json_decode(ASSIGNMENT_TYPE);
            $action_type = $action_type[0]->CODE;
            if ($escalate_status == 'Y') {
                $action_type = $action_type[1]->CODE;
            }

            $date_history = $this->generateDateCode();
            $insertDateArray = array(
                'sr_no' => $dateCode,
                'date_code' => $date_history,
                'petition_no' => $petition_no,
                'service_code' => $service_code,
                'taskid' => $taskid,
                'action_type' => $action_type,
                'pending_officer' => $assigned_to,
                'assigned_user' => $user_code,
                'assigned_user_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'registerd_on' => $escalatedRowDetailsAgainstPetitionno->registerd_on,
                'allocation_date' => $executionDate,
                'target_completion_date' => $escalatedDate,
                'date_diff' => $this->dateDiff($escalatedDate, $executionDate),
                'escalated_status' => $escalate_status,
                'created_date' => date('Y-m-d H:i:s'),
                'updated_date' => date('Y-m-d H:i:s'),
            );

            log_message("error", "escalate_dates_status======" . json_encode($insertDateArray));
            $status = $this->db->insert('escalation_dates_details', $insertDateArray);
            if ($status != 1) {
                log_message('error', '#ERRESCLATION10551 : Insertion failed on escalation_dates_details' . json_encode($this->db->last_query()));
                $response['responseType'] = 0;
                $response['msg'] = '#ERRESCLATION10551 : Insertion failed on escalation_dates_details';
                return $response;
            }
            if ($updateFlag == true) {
                $where_history_set = array(
                    'petition_no' => $petition_no,
                );
                $updateDatesArraySet = array(
                    'history_id' => $date_history,
                );
                $updateStatus22 = $this->db->update('escalation_details', $updateDatesArraySet, $where_history_set);
                if ($this->db->affected_rows() <= 0) {
                    log_message('error', '#ERRESCLATION10566 : Updation failed on escalation_details' . json_encode($this->db->last_query()));
                    $response['responseType'] = 0;
                    $response['msg'] = '#ERRESCLATION10566 : Updation failed on escalation_details';
                    return $response;
                }
            }

        }

        return $response;

        // log_message("error","ESCALATION DATE DETAILS ENTRY TABLE=======".$status);
        // //////////////////////END PROCESS////////////////////
        // if($status !=1){
        //   $flag1 = 0;
        // }else{
        //   $flag1 = 1;
        // }
        // if($flag==1 && $flag1 == 1){
        //   return $flag;
        // }else{
        //   return 0;
        // }
    }

    public function escalationCOFirstProcedingNCOR($executionDate, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $case_no, $user_code)
    {

        $allocation_days = 0;
        $executionDate = $executionDate;
        $assigned_to_other = $this->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'AST');
        $assigned_to = $this->getPendingOfficerLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $hearing_date = null;
        $user_type = 'CO';
        $service_code = '6';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'LM';
        $assigned_to_other_type = 'AST';
        $finalStatus = null;
        $assigned_to_other = $assigned_to_other->user_code;
        $task = json_decode(NCOR);
        $taskid = $task[1]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = $assignment_type_list[0]->CODE;
        $assignment_type_other = $assignment_type_list[0]->CODE;

        $escalationUpdateStatus = $this->escalationMatrixUpdateNCOR($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;
    }

    public function escalationMatrixUpdateNCOR($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days)
    {

        $response = array('responseType' => 1, 'msg' => null);
        $petition_no = $this->getPetitionNoNCOR($case_no);
        if ($petition_no == null || $petition_no == '') {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION10576 : Petition No not found';
            return $response;
        }
        // WARNING BEFORE CODE=========================
        // $assigned_to_other_type may be notice or role name
        ///////////////////////////////////

        $escalatedRowDetailsAgainstPetitionno = $this->getEscalatedRowDetails($petition_no,$service_code);
        if ($escalatedRowDetailsAgainstPetitionno == null || empty($escalatedRowDetailsAgainstPetitionno)) {
            log_message('error', '#ERRESCLATION10588 : Escalation matrix row not found');
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION10588 : Escalation matrix row not found';
            return $response;
        }
        $assigned_other_code = $assigned_to_code = $assigned_from_code = null;
        $userCodeList = json_decode(USER_ALLOT_CODE);
        foreach ($userCodeList as $key => $value) {
            if ($value->USER == $user_type) {
                $assigned_from_code = $value->CODE;
            }
            if ($value->USER == $assigned_user_type) {
                $assigned_to_code = $value->CODE;
            }
            if ($value->USER == $assigned_to_other_type) {
                $assigned_other_code = $value->CODE;
            }
        }

        $lastAssignedDate = $escalatedRowDetailsAgainstPetitionno->assigned_date;
        $lastEscalatedDate = $escalatedRowDetailsAgainstPetitionno->escalated_date;
        if ($user_type == 'AST') {
            $lastEscalatedDate = $escalatedRowDetailsAgainstPetitionno->assigned_other_es_date;
        }
        $validateExecutionDateTime = $this->checkCaseExecutionOnTimeOrNot($executionDate, $lastAssignedDate, $lastEscalatedDate);
        if ($validateExecutionDateTime == 'n') {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION10905 : Case Execution not on time';
            return $response;
        }

        // log_message("error","ASSIGNED_DATE=======".$lastAssignedDate);
        $timeLineRow = $this->getTimeLine($service_code, 'NCOR');
        if ($timeLineRow == null || empty($timeLineRow)) {
            log_message('error', '#ERRESCLATION10613 : Escalation Timeline not found');
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION10613 : Escalation Timeline not found';
            return $response;
        }

        if ($assigned_user_type == 'AST') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->da_target_days;
            $previousCompletedDaysDA = $escalatedRowDetailsAgainstPetitionno->da_completed_days;

            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysDA, $originalAllocation);
            if ($remaining_days_other == null || $remaining_days_other == 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);

        } elseif ($assigned_user_type == 'LM') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
            $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
            // log_message("error","previousCompletedDaysLM--------------".$previousCompletedDaysLM);
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysLM, $originalAllocation);
            if ($remaining_days_other == null || $remaining_days_other == 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);

        } elseif ($assigned_user_type == 'SK') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->sk_target_days;
            $previousCompletedDaysSK = $escalatedRowDetailsAgainstPetitionno->sk_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysSK, $originalAllocation);
            if ($remaining_days_other == null || $remaining_days_other == 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);
            // $escalatedDate = $this->getOtherEscalatedDate($remaining_days_other,$hearing_date);

        } elseif ($assigned_user_type == 'CO') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO, $originalAllocation);
            if ($remaining_days_other == null || $remaining_days_other == 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);

        }
        $doubleEntry = 0;
        $entryTimes = 0;
        $dateCode = $this->generateDateCode();
        // log_message("error","TYPE ".$user_type." =====ESCALATED_DATE=======".$escalatedDate);
        if ($user_type == 'CO') {
            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);
            $dateCodes = $escalatedRowDetailsAgainstPetitionno->co_date_code_list;

            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->co_completed_days;

            $co_target_days = $escalatedRowDetailsAgainstPetitionno->co_target_days;

            // log_message("error","========CO-TARGET_DAYS =======".$co_target_days);

            $co_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);

            // log_message("error","========CO-COMPLETION_DAYS=======".$co_completed_days);
            if ($co_target_days < $co_completed_days) {
                $escalate_status = 'Y';
            } else {
                $escalate_status = 'N';
            }
            // log_message("error","CO-ESCALATE_STATUS=======".$escalate_status);
            $latestHistoryCode = $dateCodes;
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }
            $entryTimes = 0;

            $assigned_other_date = null;
            $to_be_other_completed_within_days = null;
            $assigned_other_es_date = null;
            if ($assigned_to_other != null) {
                //this is designed for CO first proceding as assigned to LM and DA==========
                $entryTimes = 1;
                //////////

                $assigned_other_date = $executionDate;
                if ($assigned_to_other_type == 'LM') {

                    $originalAllocation = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
                    $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
                    $remaining_days_other = $this->getRemainingDays($previousCompletedDaysLM, $originalAllocation);
                    if ($remaining_days_other == null || $remaining_days_other == 0) {
                        $response['responseType'] = 0;
                        $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                        return $response;
                    }
                    // $assigned_other_es_date = $this->getEscalatedDate($remaining_days_other);
                    $assigned_other_es_date = $this->getEscalatedDateNew($remaining_days_other, $executionDate);
                    $to_be_other_completed_within_days = $this->dateDiff($assigned_other_es_date, $executionDate);
                } elseif ($assigned_to_other_type == 'AST') {

                    $originalAllocation = $escalatedRowDetailsAgainstPetitionno->da_target_days;
                    $previousCompletedDaysDA = $escalatedRowDetailsAgainstPetitionno->da_completed_days;
                    $remaining_days_other = $this->getRemainingDays($previousCompletedDaysDA, $originalAllocation);
                    if ($remaining_days_other == null || $remaining_days_other == 0) {
                        $response['responseType'] = 0;
                        $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                        return $response;
                    }
                    // $assigned_other_es_date = $this->getEscalatedDate($remaining_days_other);
                    $assigned_other_es_date = $this->getEscalatedDateNew($remaining_days_other, $executionDate);
                    $to_be_other_completed_within_days = $this->dateDiff($assigned_other_es_date, $executionDate);
                }

            }
            $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);

            $updateArray = array(
                'taskid' => $taskid,
                'co_completed_days' => (int) $co_completed_days + (int) $previousCompletedDays,
                'co_escalate_status' => $escalate_status,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_date' => $executionDate,
                'escalated_date' => $escalatedDate,
                'to_be_completed_within_days' => $to_be_completed_within_days,
                'co_date_code_list' => $dateCodes,
                'assignment_type' => $assignment_type,
                'assignment_type_other' => $assignment_type_other,
                'assigned_other' => $assigned_to_other,
                'assigned_other_code' => $assigned_other_code,
                'assigned_other_date' => $assigned_other_date,
                'assigned_other_es_date' => $assigned_other_es_date,
                'to_be_other_completed_within_days' => $to_be_other_completed_within_days,
            );

        }
        if ($user_type == 'AST') {

            $completion_days_for_history = $this->dateDiff($executionDate, $escalatedRowDetailsAgainstPetitionno->assigned_other_date);
            $dateCodes = $escalatedRowDetailsAgainstPetitionno->da_date_code_list;

            if ($assigned_to_other_type == 'Notice' || $assigned_to_other_type == 'Action') {
                $lastAssignedDate = $escalatedRowDetailsAgainstPetitionno->assigned_other_date;
            }

            $da_target_days = $escalatedRowDetailsAgainstPetitionno->da_target_days;
            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->da_completed_days;
            // log_message("error","DA-TARGET_DAYS=======".$da_target_days);
            $da_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);
            // log_message("error","DA-COMPLETION_DAYS=======".$da_completed_days);
            if ($da_target_days < $da_completed_days) {
                $escalate_status = 'Y';
            } else {
                $escalate_status = 'N';
            }
            // log_message("error","DA-ESCALATE_STATUS=======".$escalate_status);

            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }

            $updateArray = array(
                'taskid' => $taskid,
                'da_completed_days' => (int) $da_completed_days + (int) $previousCompletedDays,
                'da_escalate_status' => $escalate_status,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_date' => $executionDate,
                'escalated_date' => $escalatedDate,
                'da_date_code_list' => $dateCodes,
            );

            //this code use only while Asistant generate notice==============
            if ($assigned_to_other_type == 'Notice') {

                //THIS CODE ONLY FOR NOTICE GENERATE AND NEXT ALLOCATION DATE WILL BE AFTER HEARING DATE==========
                $originalAllocation = $escalatedRowDetailsAgainstPetitionno->da_target_days;
                $previousCompletedDaysDA = $da_completed_days;
                $remaining_days_other = $this->getRemainingDays($previousCompletedDaysDA, $originalAllocation);
                if ($remaining_days_other == null || $remaining_days_other == 0) {
                    $response['responseType'] = 0;
                    $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                    return $response;
                }
                //end==============
                // log_message("error","remaining_days_other,hearing_date =======".$remaining_days_other."---".$hearing_date);

                $assigned_other_es_date = $this->getOtherEscalatedDate($remaining_days_other, $hearing_date);
                unset($updateArray['assigned_from']);
                unset($updateArray['assigned_from_code']);
                unset($updateArray['assigned_to_code']);
                unset($updateArray['assigned_to']);
                unset($updateArray['assigned_date']);
                unset($updateArray['escalated_date']);
                $updateArray['assigned_other_date'] = $hearing_date;
                $updateArray['to_be_other_completed_within_days'] = $this->dateDiff($assigned_other_es_date, $hearing_date);
                $updateArray['assigned_other_es_date'] = $assigned_other_es_date;

            }
            //// end====================
            //this code use only while Asistant generate Action Taken==============

            if ($assigned_to_other_type == 'Action') {

                unset($updateArray['assigned_from']);
                unset($updateArray['assigned_from_code']);
                unset($updateArray['assigned_to_code']);
                unset($updateArray['assigned_to']);
                unset($updateArray['assigned_date']);
                unset($updateArray['escalated_date']);
                //// $updateArray['history_id_others'] = null;
                $updateArray['assignment_type_other'] = null;
                $updateArray['assigned_other'] = null;
                $updateArray['assigned_other_code'] = null;
                $updateArray['assigned_other_date'] = null;
                $updateArray['assigned_other_es_date'] = null;
                $updateArray['to_be_other_completed_within_days'] = null;

                $checkLMReportDoneorNot = $escalatedRowDetailsAgainstPetitionno->assigned_to_code;
                if ($checkLMReportDoneorNot == 6) {
                    $originalAllocation = $escalatedRowDetailsAgainstPetitionno->co_target_days;
                    $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
                    $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO, $originalAllocation);
                    if ($remaining_days_other == null || $remaining_days_other == 0) {
                        $response['responseType'] = 0;
                        $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                        return $response;
                    }
                    // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
                    $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);
                    $updateArray['assigned_date'] = $executionDate;
                    $updateArray['escalated_date'] = $escalatedDate;
                }

            }
            //// end====================

        }

        if ($user_type == 'SK') {
            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);

            $dateCodes = $escalatedRowDetailsAgainstPetitionno->sk_date_code_list;
            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->sk_completed_days;
            $sk_target_days = $escalatedRowDetailsAgainstPetitionno->sk_target_days;
            // log_message("error","SK-TARGET_DAYS=======".$sk_target_days);
            $sk_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);
            // log_message("error","SK-COMPLETION_DAYS=======".$sk_completed_days);
            if ($sk_target_days < $sk_completed_days) {
                $escalate_status = 'Y';
            } else {
                $escalate_status = 'N';
            }
            // log_message("error","SK-ESCALATE_STATUS=======".$escalate_status);
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }

            //this calculation is for assigning CO from SK and taking hearing date as assigned date====
            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO, $originalAllocation);
            if ($remaining_days_other == null || $remaining_days_other == 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $assigned_other_es_date = $this->getOtherEscalatedDate($remaining_days_other, $hearing_date);
            $to_be_completed_within_days = $this->dateDiff($assigned_other_es_date, $hearing_date);
            // log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);
            ///end==============

            $updateArray = array(
                'taskid' => $taskid,
                'sk_completed_days' => (int) $sk_completed_days + (int) $previousCompletedDays,
                'sk_escalate_status' => $escalate_status,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                // 'assigned_date'      => $executionDate,
                'assigned_date' => $hearing_date,
                'escalated_date' => $assigned_other_es_date,
                'sk_date_code_list' => $dateCodes,
                'to_be_completed_within_days' => $to_be_completed_within_days,
            );

            // log_message("error","CO==============SK".json_encode($updateArray));

        }

        if ($user_type == 'LM') {

            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);

            $dateCodes = $escalatedRowDetailsAgainstPetitionno->lm_date_code_list;
            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
            $lm_target_days = $escalatedRowDetailsAgainstPetitionno->lm_target_days;

            // log_message("error","LM-TARGET_DAYS=======".$lm_target_days);
            $lm_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);
            // log_message("error","LM-COMPLETION_DAYS=======".$lm_completed_days);
            if ($lm_target_days < $lm_completed_days) {
                $escalate_status = 'Y';
            } else {
                $escalate_status = 'N';
            }
            // log_message("error","LM-ESCALATE_STATUS=======".$escalate_status);
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }

            //this calculation is for assigning CO from SK and taking hearing date as assigned date====
            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO, $originalAllocation);
            if ($remaining_days_other == null || $remaining_days_other == 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $assigned_other_es_date = $this->getOtherEscalatedDate($remaining_days_other, $hearing_date);
            $to_be_completed_within_days = $this->dateDiff($assigned_other_es_date, $hearing_date);
            // log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);

            if ($assigned_to_other_type == 'LMRevert') {
                //this calculation is for assigning CO from LM and taking hearing date as assigned date AS REVERT CASE====
                $originalAllocation = $escalatedRowDetailsAgainstPetitionno->co_target_days;
                $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
                $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO, $originalAllocation);
                if ($remaining_days_other == null || $remaining_days_other == 0) {
                    $response['responseType'] = 0;
                    $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                    return $response;
                }
                // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
                $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);
                $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);
                // log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);
                $assigned_other_es_date = $escalatedDate;
                $hearing_date = $executionDate;
            }
            ///end==============

            $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);
            $updateArray = array(
                'taskid' => $taskid,
                'lm_completed_days' => (int) $lm_completed_days + (int) $previousCompletedDays,
                'lm_escalate_status' => $escalate_status,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_date' => $hearing_date,
                'escalated_date' => $assigned_other_es_date,
                'lm_date_code_list' => $dateCodes,
                'to_be_completed_within_days' => $to_be_completed_within_days,
            );

        }

        //UPDATE ESCALATION DATE HISTORY TABLE=====================

        $updateFlag = true;
        if ($assigned_to_other_type == 'Notice' || $assigned_to_other_type == 'Action') {
            $updateFlag = false;
            $history_id = $escalatedRowDetailsAgainstPetitionno->history_id_others;
        } else {
            $updateFlag = true;
            $history_id = $escalatedRowDetailsAgainstPetitionno->history_id;
        }

        // log_message("error","UPDATED FLAG ==========".$updateFlag);

        //STEPS to be followed:
        // 1. update escalation_dates_details against or history id
        // 2.update escalation_details with new date codes without history id
        // 3.insert history details and updated escalattion details with new history id

        $where_history = array(
            'petition_no' => $petition_no,
            'date_code' => $history_id,
            'service_code' => $service_code
        );
        $updateDatesArray = array(
            'completion_date' => $executionDate,
            'escalated_status' => $escalate_status,
            'completion_days' => $completion_days_for_history,
        );

        $updateStatus22 = $this->db->update('escalation_dates_details', $updateDatesArray, $where_history);
        if ($this->db->affected_rows() <= 0) {
            log_message('error', '#ERRESCLATION10999 : Updation failed escalation_dates_details' . json_encode($this->db->last_query()));
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION10999 : Updation failed escalation_dates_details';
            return $response;
        }
        // log_message("error","UPDt history escalation_dates_details TABLE=======".$this->db->affected_rows());

        ///////////////END PROCESS//////////////////////////

        $where = array(
            'petition_no' => $petition_no,
        );
        if ($finalStatus == 'final') {
            unset($updateArray['assigned_to']);
            unset($updateArray['assigned_to_code']);
            unset($updateArray['assigned_from']);
            unset($updateArray['assigned_from_code']);
            unset($updateArray['assigned_date']);
            unset($updateArray['escalated_date']);
            unset($updateArray['to_be_completed_within_days']);
            unset($updateArray['co_date_code_list']);

            $updateArray['assignment_type_other'] = null;
            $updateArray['assigned_other'] = null;
            $updateArray['assigned_other_code'] = null;
            $updateArray['assigned_other_date'] = null;
            $updateArray['assigned_other_es_date'] = null;
            $updateArray['to_be_other_completed_within_days'] = null;
            $updateArray['final_completion_date'] = $executionDate;
            $updateArray['status'] = 'F';

        }

        // log_message('error',"FINAL UPDATED ARRAY===============".json_encode($updateArray));
        $updateStatus1 = $this->db->update('escalation_details', $updateArray, $where);

        // log_message("error","ESCALATION DETAILS ENTRY TABLE=======".$this->db->affected_rows());
        // if($this->db->affected_rows() <= 0){
        //    $flag = 0;
        // }else{
        //    $flag = 1;
        // }
        if ($this->db->affected_rows() <= 0) {
            log_message('error', '#ERRESCLATION11045 : Updation failed escalation_details' . json_encode($this->db->last_query()));
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION11045 : Updation failed escalation_details';
            return $response;
        }

        if ($doubleEntry == 0 && $finalStatus == null) {
            if ($assigned_to_other_type == 'Notice' || $assigned_to_other_type == 'SKReport') {
                $executionDate = $hearing_date;
                $escalatedDate = $assigned_other_es_date;
            }

            $action_type = json_decode(ASSIGNMENT_TYPE);
            $action_type = $action_type[0]->CODE;
            if ($escalate_status == 'Y') {
                $action_type = $action_type[1]->CODE;
            }

            $date_history = $this->generateDateCode();
            $insertDateArray = array(
                'sr_no' => $dateCode,
                'date_code' => $date_history,
                'petition_no' => $petition_no,
                'service_code' => $service_code,
                'taskid' => $taskid,
                'action_type' => $action_type,
                'pending_officer' => $assigned_to,
                'assigned_user' => $user_code,
                'assigned_user_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'registerd_on' => $escalatedRowDetailsAgainstPetitionno->registerd_on,
                'allocation_date' => $executionDate,
                'target_completion_date' => $escalatedDate,
                'date_diff' => $this->dateDiff($escalatedDate, $executionDate),
                'escalated_status' => $escalate_status,
                'created_date' => date('Y-m-d H:i:s'),
                'updated_date' => date('Y-m-d H:i:s'),
            );
            // if($finalStatus == 'final'){
            //   $insertDateArray['completion_date'] = $executionDate;
            // }
            // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
            $status = $this->db->insert('escalation_dates_details', $insertDateArray);
            if ($status != 1) {
                log_message('error', '#ERRESCLATION11084 : Insertion failed escalation_dates_details' . json_encode($this->db->last_query()));
                $response['responseType'] = 0;
                $response['msg'] = '#ERRESCLATION11084 : Insertion failed escalation_dates_details';
                return $response;
            }
            if ($updateFlag == true) {
                $where_history_set = array(
                    'petition_no' => $petition_no,
                );
                $updateDatesArraySet = array(
                    'history_id' => $date_history,
                );
                $updateStatus22 = $this->db->update('escalation_details', $updateDatesArraySet, $where_history_set);
                if ($this->db->affected_rows() <= 0) {
                    log_message('error', '#ERRESCLATION11099 : Updation failed escalation_details' . json_encode($this->db->last_query()));
                    $response['responseType'] = 0;
                    $response['msg'] = '#ERRESCLATION11099 : Updation failed escalation_details';
                    return $response;
                }
            }

        }

        //INSERT HISTORY FOR ESCALATION DATE DETAILS=====================
        if ($entryTimes == 1) {
            $action_type = json_decode(ASSIGNMENT_TYPE);
            $action_type = $action_type[0]->CODE;
            if ($escalate_status == 'Y') {
                $action_type = $action_type[1]->CODE;
            }

            $date_history = $this->generateDateCode();
            $insertDateArray = array(
                'date_code' => $date_history,
                'petition_no' => $petition_no,
                'service_code' => $service_code,
                'taskid' => $taskid,
                'action_type' => $action_type,
                'pending_officer' => $assigned_to_other,
                'assigned_user' => $user_code,
                'assigned_user_code' => $assigned_from_code,
                'assigned_to' => $assigned_to_other,
                'assigned_to_code' => $assigned_other_code,
                'registerd_on' => $escalatedRowDetailsAgainstPetitionno->registerd_on,
                'allocation_date' => $assigned_other_date,
                'target_completion_date' => $assigned_other_es_date,
                'date_diff' => $this->dateDiff($assigned_other_es_date, $executionDate),
                'escalated_status' => $escalate_status,
                'created_date' => date('Y-m-d H:i:s'),
                'updated_date' => date('Y-m-d H:i:s'),
            );
            $status = $this->db->insert('escalation_dates_details', $insertDateArray);
            $where_history_set = array(
                'petition_no' => $petition_no,
            );

            $updateDatesArraySet = array(
                'history_id_others' => $date_history,
            );
            $updateStatus22 = $this->db->update('escalation_details', $updateDatesArraySet, $where_history_set);
            if ($this->db->affected_rows() <= 0) {
                log_message('error', '#ERRESCLATION11141 : Updation failed escalation_details' . json_encode($this->db->last_query()));
                $response['responseType'] = 0;
                $response['msg'] = '#ERRESCLATION11141 : Updation failed escalation_details';
                return $response;
            }
        }

        return $response;

        // log_message("error","ESCALATION DATE DETAILS ENTRY TABLE=======".$status);
        // //////////////////////END PROCESS////////////////////
        // if($status !=1){
        //   $flag1 = 0;
        // }else{
        //   $flag1 = 1;
        // }
        // if($flag==1 && $flag1 == 1){
        //   return $flag;
        // }else{
        //   return 0;
        // }
    }

    public function escalationDANoticeNCOR($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code, $hearing_date)
    {

        //taken because next time will start from completion date of hearing===========
        // $executionDate = date('Y-m-d');
        ///////////////////
        $user_type = 'AST';
        $service_code = '6';
        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'AST';
        $assigned_to_other_type = "Notice";
        $finalStatus = null;
        $assigned_to_other = null;
        $task = json_decode(NCOR);
        $taskid = $task[4]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = null;
        $assignment_type_other = $assignment_type_list[0]->CODE;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateNCOR($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;
    }

    public function escalationLMReportNCOR($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code, $hearing_date)
    {
        $executionDate = $executionDate;
        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $user_type = 'LM';
        $service_code = '6';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'CO';
        $assigned_to_other_type = null;
        $finalStatus = null;
        $assigned_to_other = null;
        $task = json_decode(NCOR);
        $taskid = $task[2]->CODE;
        $assignment_type = null;
        $assignment_type_other = null;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateNCOR($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;
    }

    public function getPendingNameCorrectionCasesForCoFinalOrder($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status, $user_code)
    {
        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 'misc_case_basic.misc_case_petition_no',
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
            $this->db->where("(misc_case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }
        $status = array('10', '02');
        $this->db->select('misc_case_basic.*, misc_case_basic.misc_case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 'misc_case_basic.misc_case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 'misc_case_basic.misc_case_no = escalation_details.case_no', 'left');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('add_to_officer', $user_code);
        $this->db->where_in('misc_case_basic.status', $status);
        $this->db->where('misc_case_basic.operation !=', 'E');
        $this->db->where('misc_case_basic.misc_case_type', '06');
        $this->db->where('misc_case_basic.lm_note_yn', 'Y');
        $this->db->where('misc_case_basic.sk_note_yn', 'Y');
        $this->db->where('misc_case_basic.note_of_action', 'Y');
        $this->db->where('misc_case_basic.submission_date >=', $define_date);
        if ($zone_status == 4) {
            $this->db->where('misc_case_basic.es_flag', 0);
        } else {
            $this->db->where('misc_case_basic.es_flag', 1);
        }
        $this->db->limit($length, $start);
        $query = $this->db->get('misc_case_basic');
        log_message('error', "#4236: misc_case_basic: " . $this->db->last_query());
        if ($query->num_rows() > 0) {
            $data_results = $query->result();
            $final_array = array();
            foreach ($data_results as $rr) {
                $variable = $this->escalationZoneWiseSearchNameCancellation($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->submission_date, $rr->escalated_date, $user_code, $rr->co_target_days, $rr->assigned_date, $rr->fresh_yn, $rr->status, $rr->lm_note_yn, $rr->notice_generated_yn, $rr->sk_note_yn, $rr->next_date_of_hearing, $rr->proceeding_yn, $rr->misc_case_type, $rr->misc_case_petition_no, $rr->is_escalated);
                if (!empty($variable)) {
                    $final_array[] = $variable;
                }
            }
            $data['data_results'] = $final_array;
            $data['total_records'] = count($final_array);
            if (!empty($searchByCol_0)) {
                $this->db->where("(misc_case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
            }
            $this->db->select('misc_case_basic.*, misc_case_basic.misc_case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 'misc_case_basic.misc_case_no = basundhar_application.dharitree', 'left');
            $this->db->join('escalation_details', 'misc_case_basic.misc_case_no = escalation_details.case_no', 'left');
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('add_to_officer', $user_code);
            $this->db->where_in('misc_case_basic.status', $status);
            $this->db->where('misc_case_basic.operation !=', 'E');
            $this->db->where('misc_case_basic.misc_case_type', '06');
            $this->db->where('misc_case_basic.lm_note_yn', 'Y');
            $this->db->where('misc_case_basic.sk_note_yn', 'Y');
            $this->db->where('misc_case_basic.note_of_action', 'Y');
            $this->db->where('misc_case_basic.submission_date >=', $define_date);
            if ($zone_status == 4) {
                $this->db->where('misc_case_basic.es_flag', 0);
            } else {
                $this->db->where('misc_case_basic.es_flag', 1);
            }
            $res = $this->db->get('misc_case_basic')->result();
            $cc = array();
            foreach ($res as $r) {
                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->co_target_days;
                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }
            $data['total_records'] = count($cc);
            return $data;
        }
    }

    public function escalationFinalOrderNCOR($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code)
    {

        $executionDate = $executionDate;
        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $hearing_date = null;
        $user_type = 'CO';
        $service_code = '6';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'CO';
        $assigned_to_other_type = null;
        $finalStatus = 'final';
        $assigned_to_other = null;
        $task = json_decode(NCOR);
        $taskid = $task[5]->CODE;
        $assignment_type = null;
        $assignment_type_other = null;
        $allocation_days = 0;

        $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateNCOR($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;
    }

    // added on 20/01/2024

    // get pending area correction cases at CO end
    public function getPendingAreaCorrectionCasesCoEnd($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status)
    {

        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 't_legacyupdation.proposal_no',
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
            $this->db->where("(application_ref_no like '%$searchByCol_0%' or case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }

        $this->db->select('t_legacyupdation.*, t_legacyupdation.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 't_legacyupdation.case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 't_legacyupdation.case_no = escalation_details.case_no', 'left');

        $this->db->where('t_legacyupdation.dist_code', $dist_code);
        $this->db->where('t_legacyupdation.subdiv_code', $subdiv_code);
        $this->db->where('t_legacyupdation.cir_code', $cir_code);
        $this->db->where('t_legacyupdation.lm_note != ', 'y');
        $this->db->where('t_legacyupdation.status', 'P');
        $this->db->where('t_legacyupdation.co_yn IS NULL');
        $this->db->where('t_legacyupdation.dc_yn IS NULL');

        if ($zone_status == 4) {
            $this->db->where('t_legacyupdation.es_flag', 0);
        } else {
            $this->db->where('t_legacyupdation.es_flag', 1);
        }

        $this->db->limit($length, $start);
        $query = $this->db->get('t_legacyupdation');

        // echo $this->db->last_query();

        log_message('error', "t_legacyupdation: " . $this->db->last_query());

        if ($query->num_rows() > 0) {

            $data_results = $query->result();
            $final_array = array();

            // echo "<pre>";
            // var_dump($data_results);

            foreach ($data_results as $rr) {
                $variable = $this->escalationZoneWiseSearchAreaCorrection($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->status_date, $rr->escalated_date, $this->session->userdata('user_code'), $rr->adc_target_days, $rr->assigned_date, $rr->registerd_on, $rr->proposal_no,
                    $rr->dag_no, $rr->patta_no);

                if (!empty($variable)) {
                    $final_array[] = $variable;
                }

                // echo "<pre>";
                // var_dump($data_results);
            }

            $data['data_results'] = $final_array;
            // $data['total_records'] = count($final_array);

            // var_dump($data['data_results']);

            if (!empty($searchByCol_0)) {
                $this->db->like('case_no', strtoupper($searchByCol_0));
            }

            $this->db->select('t_legacyupdation.*, t_legacyupdation.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 't_legacyupdation.case_no = basundhar_application.dharitree', 'left');
            $this->db->join('escalation_details', 't_legacyupdation.case_no = escalation_details.case_no', 'left');

            $this->db->where('t_legacyupdation.dist_code', $dist_code);
            $this->db->where('t_legacyupdation.subdiv_code', $subdiv_code);
            $this->db->where('t_legacyupdation.cir_code', $cir_code);
            $this->db->where('t_legacyupdation.lm_note != ', 'y');
            $this->db->where('t_legacyupdation.status', 'P');
            $this->db->where('t_legacyupdation.co_yn IS NULL');
            $this->db->where('t_legacyupdation.dc_yn IS NULL');

            if ($zone_status == 4) {
                $this->db->where('t_legacyupdation.es_flag', 0);
            } else {
                $this->db->where('t_legacyupdation.es_flag', 1);
            }

            $res = $this->db->get('t_legacyupdation')->result();

            $cc = array();

            foreach ($res as $r) {

                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->co_target_days;

                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }

            $data['total_records'] = count($cc);
            return $data;
        }
    }

    public function getPendingAreaCorrectionCasesAdcEnd($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status)
    {

        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 't_legacyupdation.proposal_no',
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
            $this->db->where("(application_ref_no like '%$searchByCol_0%' or case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }

        $this->db->select('t_legacyupdation.*, t_legacyupdation.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 't_legacyupdation.case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 't_legacyupdation.case_no = escalation_details.case_no', 'left');

        $this->db->where('t_legacyupdation.dist_code', $dist_code);
        $this->db->where('t_legacyupdation.status', 'P');
        $this->db->where('t_legacyupdation.co_yn IS NOT NULL');
        $this->db->where('t_legacyupdation.dc_yn IS NULL');

        if ($zone_status == 4) {
            $this->db->where('t_legacyupdation.es_flag', 0);
        } else {
            $this->db->where('t_legacyupdation.es_flag', 1);
        }

        $this->db->limit($length, $start);
        $query = $this->db->get('t_legacyupdation');

        log_message('error', "t_legacyupdation: " . $this->db->last_query());

        if ($query->num_rows() > 0) {

            $data_results = $query->result();
            $final_array = array();

            // var_dump($data_results); die;

            foreach ($data_results as $rr) {
                $variable = $this->escalationZoneWiseSearchAreaCorrection($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->status_date, $rr->escalated_date, $this->session->userdata('user_code'), $rr->adc_target_days, $rr->assigned_date, $rr->registerd_on, $rr->proposal_no, $rr->dag_no, $rr->patta_no);

                if (!empty($variable)) {
                    $final_array[] = $variable;
                }
            }

            $data['data_results'] = $final_array;

            if (!empty($searchByCol_0)) {
                $this->db->like('case_no', strtoupper($searchByCol_0));
            }

            $this->db->select('t_legacyupdation.*, t_legacyupdation.case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 't_legacyupdation.case_no = basundhar_application.dharitree', 'left');
            $this->db->join('escalation_details', 't_legacyupdation.case_no = escalation_details.case_no', 'left');

            $this->db->where('t_legacyupdation.dist_code', $dist_code);
            $this->db->where('t_legacyupdation.status', 'P');
            $this->db->where('t_legacyupdation.co_yn IS NOT NULL');
            $this->db->where('t_legacyupdation.dc_yn IS NULL');

            if ($zone_status == 4) {
                $this->db->where('t_legacyupdation.es_flag', 0);
            } else {
                $this->db->where('t_legacyupdation.es_flag', 1);
            }

            $res = $this->db->get('t_legacyupdation')->result();

            $cc = array();

            foreach ($res as $r) {

                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->co_target_days;

                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }

            $data['total_records'] = count($cc);
            return $data;
        }
    }

    public function escalationZoneWiseSearchAreaCorrection($zone_status, $es_flag, $c_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $rtps_no, $submission_date, $escalated_date, $user_code, $target_days, $assigned_date, $date_entry, $proposal_no, $dag_no, $patta_no)
    {

        $curr_date = date('Y-m-d');
        $esc_date = $escalated_date;
        $esc_flag = $es_flag;
        $final_array = '';

        if (!empty($zone_status) && ($esc_date != null || $esc_date != '') && ($esc_flag == 1)) {
            $remaining_days = $this->dateDiff($esc_date, $curr_date);
            $per_avail = (100 * $remaining_days) / $target_days;

            //green zone
            if (($zone_status == 1) && ($per_avail >= YELLOW_ZONE)) {

                $final_array = (object) [
                    'case_no' => $c_no,
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'basundhara' => $rtps_no,
                    'lm_date' => $submission_date,
                    'escalated_date' => $escalated_date,
                    'es_flag' => $es_flag,
                    'assigned_from' => $user_code,
                    'co_target_days' => $target_days,
                    'assigned_date' => $assigned_date,
                    'date_entry' => $date_entry,
                    'application_ref_no' => $rtps_no,
                    'proposal_no' => $proposal_no,
                    'dag_no' => $dag_no,
                    'patta_no' => $patta_no,
                ];

                log_message('error', '#11433 : Green Zone ' . json_encode($final_array));
            }

            //yellow zone
            else if (($zone_status == 2) && (($per_avail < YELLOW_ZONE) && ($per_avail > RED_ZONE))) {
                $final_array = (object) [
                    'case_no' => $c_no,
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'basundhara' => $rtps_no,
                    'lm_date' => $submission_date,
                    'escalated_date' => $escalated_date,
                    'es_flag' => $es_flag,
                    'assigned_from' => $user_code,
                    'co_target_days' => $target_days,
                    'assigned_date' => $assigned_date,
                    'date_entry' => $date_entry,
                    'application_ref_no' => $rtps_no,
                    'proposal_no' => $proposal_no,
                    'dag_no' => $dag_no,
                    'patta_no' => $patta_no,
                ];

                log_message('error', '#11457 : Yellow Zone ' . json_encode($final_array));
            }

            //red zone
            else if (($zone_status == 3) && ($per_avail <= RED_ZONE)) {
                $final_array = (object) [
                    'case_no' => $c_no,
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'basundhara' => $rtps_no,
                    'lm_date' => $submission_date,
                    'escalated_date' => $escalated_date,
                    'es_flag' => $es_flag,
                    'assigned_from' => $user_code,
                    'co_target_days' => $target_days,
                    'assigned_date' => $assigned_date,
                    'date_entry' => $date_entry,
                    'application_ref_no' => $rtps_no,
                    'proposal_no' => $proposal_no,
                    'dag_no' => $dag_no,
                    'patta_no' => $patta_no,
                ];

                log_message('error', '#11481 : Red Zone ' . json_encode($final_array));
            }

            //old cases
            else if ($zone_status == 4) {
                $final_array = (object) [
                    'case_no' => $c_no,
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'basundhara' => $rtps_no,
                    'lm_date' => $submission_date,
                    'escalated_date' => $escalated_date,
                    'es_flag' => $es_flag,
                    'assigned_from' => $user_code,
                    'co_target_days' => $target_days,
                    'assigned_date' => $assigned_date,
                    'date_entry' => $date_entry,
                    'application_ref_no' => $rtps_no,
                    'proposal_no' => $proposal_no,
                    'dag_no' => $dag_no,
                    'patta_no' => $patta_no,
                ];

                log_message('error', '#11505 : Old Cases ' . json_encode($final_array));
            }
        } else {
            $final_array = (object) [
                'case_no' => $c_no,
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'basundhara' => $rtps_no,
                'lm_date' => $submission_date,
                'escalated_date' => $escalated_date,
                'es_flag' => $es_flag,
                'assigned_from' => $user_code,
                'co_target_days' => $target_days,
                'assigned_date' => $assigned_date,
                'date_entry' => $date_entry,
                'application_ref_no' => $rtps_no,
                'proposal_no' => $proposal_no,
                'dag_no' => $dag_no,
                'patta_no' => $patta_no,
            ];

            log_message('error', '#11529 : Others ' . json_encode($final_array));
        }

        return $final_array;
    }

    public function fetchQueryData($petition_no)
    {
        $data = array();
        $queryEscalationData = $this->db->query('select * from escalation_details where petition_no = ?', array($petition_no))->result();
        $queryEscalationDatesData = $this->db->query('select * from escalation_dates_details where petition_no = ? order by sr_no asc', array($petition_no))->result();
        $data['escalationDetails'] = $queryEscalationData;
        $data['escalationDatesDetails'] = $queryEscalationDatesData;
        return $data;

    }

    public function getServiceCodeForMutD($case_no)
    {
        $queryEscalationData = $this->db->query('select service_code from escalation_details where case_no = ?', array($case_no))->row();

        return $queryEscalationData->service_code;
    }

    public function checkCaseExecutionOnTimeOrNot($executionDate, $lastAssignedDate, $lastEscalatedDate)
    {
        $newExecutionDate = date('Y-m-d',strtotime($executionDate));
        $newlastEscalatedDate = date('Y-m-d',strtotime($lastEscalatedDate));

        log_message('error', '1--------' . $executionDate . "-2-" . $lastAssignedDate . "-3-" . $lastEscalatedDate);
        if (($executionDate > $lastAssignedDate) && ($newExecutionDate <= $newlastEscalatedDate)) {
            return 'y';
        } else {
            return 'n';
        }
    }

    public function getPendingOfficerBO($d, $desig_code)
    {
        $sql = "select u.username, lt.user_code, u.user_desig_code from loginuser_table lt join users u on
              lt.dist_code=u.dist_code
                and lt.subdiv_code=u.subdiv_code
                  and u.user_code=lt.user_code where lt.dis_enb_option='E'
                    and u.user_desig_code like 'BO%'";
        $data = $this->db->query($sql);
        return $data->row();
    }

    public function getPetitionNoALOT($case_no)
    {
        $sql = "Select petition_no from allotment_cert_basic where  case_no=?";
        $data = $this->db->query($sql, array($case_no))->row();
        return $data->petition_no;
    }

    public function escalationCOFirstProcedingAllotment($executionDate, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $case_no, $user_code)
    {

        $executionDate = $executionDate;
        // $assigned_to_other = $this->getPendingOfficer($dist_code,$subdiv_code,$cir_code,'LM');
        $assigned_to = $this->getPendingOfficerLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $hearing_date = null;
        $user_type = 'CO';
        $service_code = '5';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'LM';
        // $assigned_to_other_type = 'AST';
        $finalStatus = null;
        // $assigned_to_other = $assigned_to_other->user_code;
        $task = json_decode(ALOT_TASK);
        $taskid = $task[1]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = null;
        $assignment_type_other = $assignment_type_list[0]->CODE;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->escalationMatrixUpdateALOT($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, null, null, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;
    }
    public function escalationLMFirstProcedingAllotment($executionDate, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $case_no, $user_code)
    {

        $executionDate = $executionDate;
        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'SK');
        $hearing_date = null;
        $user_type = 'LM';
        $service_code = '5';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'SK';
        // $assigned_to_other_type = 'AST';
        $finalStatus = null;
        // $assigned_to_other = $assigned_to_other->user_code;
        $task = json_decode(ALOT_TASK);
        $taskid = $task[2]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = null;
        $assignment_type_other = $assignment_type_list[0]->CODE;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->escalationMatrixUpdateALOT($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, null, null, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;
    }
    public function escalationSKFirstProcedingAllotment($executionDate, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $case_no, $user_code)
    {

        $executionDate = $executionDate;
        // $assigned_to_other = $this->getPendingOfficer($dist_code,$subdiv_code,$cir_code,'LM');
        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $hearing_date = null;
        $user_type = 'SK';
        $service_code = '5';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'CO';
        // $assigned_to_other_type = 'AST';
        $finalStatus = null;
        // $assigned_to_other = $assigned_to_other->user_code;
        $task = json_decode(ALOT_TASK);
        $taskid = $task[3]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = null;
        $assignment_type_other = $assignment_type_list[0]->CODE;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->escalationMatrixUpdateALOT($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, null, null, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;
    }

    public function escalationCOSecondProcedingAllotment($executionDate, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $case_no, $user_code)
    {

        $executionDate = $executionDate;
        // $assigned_to_other = $this->getPendingOfficer($dist_code,$subdiv_code,$cir_code,'LM');
        $assigned_to = $this->getPendingOfficerDC($dist_code, 'DC');
        $hearing_date = null;
        $user_type = 'CO';
        $service_code = '5';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'DC';
        // $assigned_to_other_type = 'AST';
        $finalStatus = null;
        // $assigned_to_other = $assigned_to_other->user_code;
        $task = json_decode(ALOT_TASK);
        $taskid = $task[1]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = null;
        $assignment_type_other = $assignment_type_list[0]->CODE;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->escalationMatrixUpdateALOT($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, null, null, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;
    }

    public function escalationDCFirstProcedingAllotment($executionDate, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $case_no, $user_code)
    {

        $executionDate = $executionDate;
        // $assigned_to_other = $this->getPendingOfficer($dist_code,$subdiv_code,$cir_code,'LM');
        $assigned_to = $this->getPendingOfficerBO($dist_code, 'BO');

        $hearing_date = null;
        $user_type = 'DC';
        $service_code = '5';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'BO';
        // $assigned_to_other_type = 'AST';
        $finalStatus = null;
        // $assigned_to_other = $assigned_to_other->user_code;
        $task = json_decode(ALOT_TASK);
        $taskid = $task[5]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = null;
        $assignment_type_other = $assignment_type_list[0]->CODE;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->escalationMatrixUpdateALOT($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, null, null, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;
    }

    public function escalationBOFirstProcedingAllotment($executionDate, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $case_no, $user_code)
    {

        $executionDate = $executionDate;
        // $assigned_to_other = $this->getPendingOfficer($dist_code,$subdiv_code,$cir_code,'LM');
        $assigned_to = $this->getPendingOfficerDC($dist_code, 'DC');

        $hearing_date = null;
        $user_type = 'BO';
        $service_code = '5';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'DC';
        // $assigned_to_other_type = 'AST';
        $finalStatus = null;
        // $assigned_to_other = $assigned_to_other->user_code;
        $task = json_decode(ALOT_TASK);
        $taskid = $task[6]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = null;
        $assignment_type_other = $assignment_type_list[0]->CODE;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->escalationMatrixUpdateALOT($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, null, null, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;
    }

    public function escalationDCFinalOrderAllotment($executionDate, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $case_no, $user_code)
    {

        $executionDate = $executionDate;
        // $assigned_to_other = $this->getPendingOfficer($dist_code,$subdiv_code,$cir_code,'LM');
        $assigned_to = $this->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');

        $hearing_date = null;
        $user_type = 'DC';
        $service_code = '5';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'CO';
        // $assigned_to_other_type = 'AST';
        $finalStatus = null;
        // $assigned_to_other = $assigned_to_other->user_code;
        $task = json_decode(ALOT_TASK);
        $taskid = $task[7]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = null;
        $assignment_type_other = $assignment_type_list[0]->CODE;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->escalationMatrixUpdateALOT($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, null, null, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;
    }

    public function escalationFinalOrderCOChitha($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code)
    {

        $executionDate = $executionDate;
        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $hearing_date = null;
        $user_type = 'CO';
        $service_code = '5';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'CO';
        $assigned_to_other_type = null;
        $finalStatus = 'final';
        $assigned_to_other = null;
        $task = json_decode(ALOT_TASK);
        $taskid = $task[8]->CODE;
        $assignment_type = null;
        $assignment_type_other = null;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->Escalationmodel->escalationMatrixUpdateALOT($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;
    }

    public function escalationCORevertToLmALOT($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code, $mouza_pargona_code, $lot_no, $allocation_days)
    {

        $assigned_to = $this->getPendingOfficerLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $hearing_date = null;
        $user_type = 'CO';
        $service_code = '5';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'LM';
        $assigned_to_other_type = null;
        $finalStatus = null;
        $assigned_to_other = null;
        $task = json_decode(ALOT_TASK);
        $taskid = $task[9]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = null;
        $assignment_type_other = $assignment_type_list[3]->CODE;
        if ($allocation_days != null) {
            $updateExtraDaysAgainstPetitionNo = $this->updateExtraDays($case_no, $allocation_days);
        }
        $escalationUpdateStatus = $this->escalationMatrixUpdateALOT($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;
    }
    public function escalationCORevertToDcALOT($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code, $mouza_pargona_code, $lot_no, $allocation_days)
    {

        $assigned_to = $this->getPendingOfficerDC($dist_code, 'DC');
        $hearing_date = null;
        $user_type = 'CO';
        $service_code = '5';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'DC';
        $assigned_to_other_type = null;
        $finalStatus = null;
        $assigned_to_other = null;
        $task = json_decode(ALOT_TASK);
        $taskid = $task[10]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = null;
        $assignment_type_other = $assignment_type_list[3]->CODE;
        if ($allocation_days != null) {
            $updateExtraDaysAgainstPetitionNo = $this->updateExtraDays($case_no, $allocation_days);
        }
        $escalationUpdateStatus = $this->escalationMatrixUpdateALOT($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;
    }
    public function escalationDCRevertToCoALOT($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code, $mouza_pargona_code, $lot_no, $allocation_days)
    {

        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $hearing_date = null;
        $user_type = 'DC';
        $service_code = '5';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'CO';
        $assigned_to_other_type = null;
        $finalStatus = null;
        $assigned_to_other = null;
        $task = json_decode(ALOT_TASK);
        $taskid = $task[11]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = null;
        $assignment_type_other = $assignment_type_list[3]->CODE;
        if ($allocation_days != null) {
            if($this->session->userdata('user_desig_code') == 'ADC')
            {
                $updateExtraDaysAgainstPetitionNo = $this->updateExtraDaysADCCO($case_no, $allocation_days);
            }
            else if($this->session->userdata('user_desig_code') == 'DC')
            {
                $updateExtraDaysAgainstPetitionNo = $this->updateExtraDaysDCCO($case_no, $allocation_days);
            }
            
        }
        $escalationUpdateStatus = $this->escalationMatrixUpdateALOT($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;
    }

    public function escalationDCRevertToBoALOT($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code, $mouza_pargona_code, $lot_no, $allocation_days)
    {

        $assigned_to = $this->getPendingOfficerBO($dist_code, 'BO');
        $hearing_date = null;
        $user_type = 'DC';
        $service_code = '5';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'BO';
        $assigned_to_other_type = null;
        $finalStatus = null;
        $assigned_to_other = null;
        $task = json_decode(ALOT_TASK);
        $taskid = $task[13]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = null;
        $assignment_type_other = $assignment_type_list[3]->CODE;
        if ($allocation_days != null) {
            $updateExtraDaysAgainstPetitionNo = $this->updateExtraDays($case_no, $allocation_days);
        }
        $escalationUpdateStatus = $this->escalationMatrixUpdateALOT($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;
    }

    public function escalationDCRejectALOT($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code, $mouza_pargona_code, $lot_no)
    {

        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $hearing_date = null;
        $user_type = 'DC';
        $service_code = '5';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'DC';
        $assigned_to_other_type = null;
        $finalStatus = 'F';
        $assigned_to_other = null;
        $task = json_decode(ALOT_TASK);
        $taskid = $task[12]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = null;
        $assignment_type_other = $assignment_type_list[0]->CODE;
        $allocation_days = 0;
        $escalationUpdateStatus = $this->escalationMatrixUpdateALOT($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days);
        return $escalationUpdateStatus;
    }

    public function escalationMatrixUpdateALOT($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to, $assigned_user_type, $finalStatus, $assigned_to_other, $assigned_to_other_type, $hearing_date, $taskid, $assignment_type, $assignment_type_other, $allocation_days)
    {
        $executionDate = date('Y-m-d H:i:s');
        // var_dump($assigned_user_type); die;

        $response = array('responseType' => 1, 'msg' => null);
        $petition_no = $this->getPetitionNoALOT($case_no);
        if ($petition_no == null || $petition_no == '') {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION150 : Petition no not found';
            return $response;
        }
        // WARNING BEFORE CODE=========================
        // $assigned_to_other_type may be notice or role name
        ///////////////////////////////////

        $escalatedRowDetailsAgainstPetitionno = $this->getEscalatedRowDetails($petition_no, $service_code);

        // log_message('error', "#ERR11942: esc_detail: ".json_encode($this->db->last_query()));


        if ($escalatedRowDetailsAgainstPetitionno == null || empty($escalatedRowDetailsAgainstPetitionno)) {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATIONA163 : Escalation row not found';
            return $response;
        }
        $assigned_other_code = $assigned_to_code = $assigned_from_code = null;
        $userCodeList = json_decode(USER_ALLOT_CODE);
        foreach ($userCodeList as $key => $value) {
            if ($value->USER == $user_type) {
                $assigned_from_code = $value->CODE;
            }
            if ($value->USER == $assigned_user_type) {
                $assigned_to_code = $value->CODE;
            }
            if ($value->USER == $assigned_to_other_type) {
                $assigned_other_code = $value->CODE;
            }
        }

        $lastAssignedDate = $escalatedRowDetailsAgainstPetitionno->assigned_date;
        // log_message("error","ASSIGNED_DATE=======".$lastAssignedDate);
        $lastEscalatedDate = $escalatedRowDetailsAgainstPetitionno->escalated_date;
        if ($user_type == 'AST') {
            $lastEscalatedDate = $escalatedRowDetailsAgainstPetitionno->assigned_other_es_date;
        }

        log_message('error', "#ERR11967: exe_date: ".json_encode($executionDate)." last_date: ".$lastAssignedDate." last_esc_date: ".$lastEscalatedDate);

        $validateExecutionDateTime = $this->checkCaseExecutionOnTimeOrNot($executionDate, $lastAssignedDate, $lastEscalatedDate);

        // log_message('error', "#ERR11969 ".json_encode($validateExecutionDateTime));

        if ($validateExecutionDateTime == 'n') {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATIONACPP183 : Case Execution not on Time';
            return $response;
        }

        $timeLineRow = $this->getTimeLine($escalatedRowDetailsAgainstPetitionno->service_code, 'ACPP');
        if ($timeLineRow == null || empty($timeLineRow)) {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATIONACPP163 : Escalation row not found';
            return $response;
        }

        if ($assigned_user_type == 'AST') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->da_target_days;
            $previousCompletedDaysDA = $escalatedRowDetailsAgainstPetitionno->da_completed_days;

            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysDA, $originalAllocation);
            if ($remaining_days_other < 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATIONACPP3281 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDateNew($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);

        } elseif ($assigned_user_type == 'LM') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
            $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
            // log_message("error","previousCompletedDaysLM--------------".$previousCompletedDaysLM);
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysLM, $originalAllocation);
            if ($remaining_days_other < 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATIONACPP3281 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);

        } elseif ($assigned_user_type == 'SK') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->sk_target_days;
            $previousCompletedDaysSK = $escalatedRowDetailsAgainstPetitionno->sk_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysSK, $originalAllocation);
            if ($remaining_days_other < 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATIONACPP3281 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);
            // $escalatedDate = $this->getOtherEscalatedDate($remaining_days_other,$hearing_date);

        } elseif ($assigned_user_type == 'CO') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO, $originalAllocation);
            log_message('error','$coremaining_days_other=='.$originalAllocation);
            log_message('error','$previousCompletedDaysCOremaining_days_other=='.$previousCompletedDaysCO);
            log_message('error','$remaining_days_other=='.$remaining_days_other);
            if ($remaining_days_other < 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATIONACPP12461 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);

        } elseif ($assigned_user_type == 'DC') {
            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->dc_target_days;
            $previousCompletedDaysDC = $escalatedRowDetailsAgainstPetitionno->dc_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysDC, $originalAllocation);
            if ($remaining_days_other < 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATIONACPP12473 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);
        } 
        elseif ($assigned_user_type == 'BO') {
            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->bo_target_days;
            $previousCompletedDaysBO = $escalatedRowDetailsAgainstPetitionno->bo_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysBO, $originalAllocation);
            if ($remaining_days_other == null || $remaining_days_other < 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATIONACPP12485 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);
        }

        $dateCode = $this->generateDateCode();
        // log_message("error","TYPE ".$user_type." =====ESCALATED_DATE=======".$escalatedDate);
        if ($user_type == 'CO') {
            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);
            $dateCodes = $escalatedRowDetailsAgainstPetitionno->co_date_code_list;

            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->co_completed_days;

            $co_target_days = $escalatedRowDetailsAgainstPetitionno->co_target_days;

            // log_message("error","========CO-TARGET_DAYS =======".$co_target_days);

            $co_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);

            // log_message("error","========CO-COMPLETION_DAYS=======".$co_completed_days);
            // if ($co_target_days < $co_completed_days) {
            //     $escalate_status = 'Y';
            // } else {
                $escalate_status = 'N';
            // }
            // log_message("error","CO-ESCALATE_STATUS=======".$escalate_status);
            $latestHistoryCode = $dateCodes;
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }
            $entryTimes = 0;
            $doubleEntry = 0;
            $assigned_other_date = null;
            $to_be_other_completed_within_days = null;
            $assigned_other_es_date = null;
            if ($assigned_to_other != null) {
                //this is designed for CO first proceding as assigned to LM and DA==========
                $entryTimes = 1;
                //////////

                $assigned_other_date = $executionDate;
                if ($assigned_to_other_type == 'LM') {
                    $originalAllocation = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
                    $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
                    $remaining_days_other = $this->getRemainingDays($previousCompletedDaysLM, $originalAllocation);
                    if ($remaining_days_other < 0) {
                        $response['responseType'] = 0;
                        $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                        return $response;
                    }
                    // $assigned_other_es_date = $this->getEscalatedDate($remaining_days_other);
                    $assigned_other_es_date = $this->getEscalatedDateNew($remaining_days_other, $executionDate);
                    $to_be_other_completed_within_days = $this->dateDiff($assigned_other_es_date, $executionDate);
                } elseif ($assigned_to_other_type == 'AST') {
                    $originalAllocation = $escalatedRowDetailsAgainstPetitionno->da_target_days;
                    $previousCompletedDaysDA = $escalatedRowDetailsAgainstPetitionno->da_completed_days;
                    $remaining_days_other = $this->getRemainingDays($previousCompletedDaysDA, $originalAllocation);
                    if ($remaining_days_other < 0) {
                        $response['responseType'] = 0;
                        $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                        return $response;
                    }
                    // $assigned_other_es_date = $this->getEscalatedDate($remaining_days_other);
                    $assigned_other_es_date = $this->getEscalatedDateNew($remaining_days_other, $executionDate);
                    $to_be_other_completed_within_days = $this->dateDiff($assigned_other_es_date, $executionDate);
                }

            }

            $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);

            $updateArray = array(
                'taskid' => $taskid,
                'co_completed_days' => (int) $co_completed_days + (int) $previousCompletedDays,
                'co_escalate_status' => $escalate_status,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_date' => $executionDate,
                'escalated_date' => $escalatedDate,
                'to_be_completed_within_days' => $to_be_completed_within_days,
                'co_date_code_list' => $dateCodes,
                'assignment_type_other' => $assignment_type_other,
                'assigned_other' => $assigned_to_other,
                'assigned_other_code' => $assigned_other_code,
                'assigned_other_date' => $assigned_other_date,
                'assigned_other_es_date' => $assigned_other_es_date,
                'to_be_other_completed_within_days' => $to_be_other_completed_within_days,
            );

        }
        if ($user_type == 'AST') {

            $completion_days_for_history = $this->dateDiff($executionDate, $escalatedRowDetailsAgainstPetitionno->assigned_other_date);
            $dateCodes = $escalatedRowDetailsAgainstPetitionno->da_date_code_list;

            if ($assigned_to_other_type == 'Notice' || $assigned_to_other_type == 'Action') {
                $lastAssignedDate = $escalatedRowDetailsAgainstPetitionno->assigned_other_date;
            }
            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->da_completed_days;
            $da_target_days = $escalatedRowDetailsAgainstPetitionno->da_target_days;
            // log_message("error","DA-TARGET_DAYS=======".$da_target_days);
            $da_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);
            // log_message("error","DA-COMPLETION_DAYS=======".$da_completed_days);
            // if ($da_target_days < $da_completed_days) {
            //     $escalate_status = 'Y';
            // } else {
                $escalate_status = 'N';
            // }
            // log_message("error","DA-ESCALATE_STATUS=======".$escalate_status);

            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }

            $updateArray = array(
                'taskid' => $taskid,
                // 'da_target_days'     => $da_target_days,
                'da_completed_days' => (int) $da_completed_days + (int) $previousCompletedDays,
                'da_escalate_status' => $escalate_status,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_date' => $executionDate,
                'escalated_date' => $escalatedDate,
                'da_date_code_list' => $dateCodes,
            );

            //this code use only while Asistant generate notice==============
            if ($assigned_to_other_type == 'Notice') {

                //THIS CODE ONLY FOR NOTICE GENERATE AND NEXT ALLOCATION DATE WILL BE AFTER HEARING DATE==========
                $originalAllocation = $escalatedRowDetailsAgainstPetitionno->da_target_days;
                $previousCompletedDaysDA = $da_completed_days;
                $remaining_days_other = $this->getRemainingDays($previousCompletedDaysDA, $originalAllocation);
                if ($remaining_days_other < 0) {
                    $response['responseType'] = 0;
                    $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                    return $response;
                }
                //end==============
                // log_message("error","remaining_days_other,hearing_date =======".$remaining_days_other."---".$hearing_date);

                $assigned_other_es_date = $this->getOtherEscalatedDate($remaining_days_other, $hearing_date);
                unset($updateArray['assigned_from']);
                unset($updateArray['assigned_from_code']);
                unset($updateArray['assigned_to_code']);
                unset($updateArray['assigned_to']);
                unset($updateArray['assigned_date']);
                unset($updateArray['escalated_date']);
                $updateArray['assigned_other_date'] = $hearing_date;
                $updateArray['to_be_other_completed_within_days'] = $this->dateDiff($assigned_other_es_date, $hearing_date);
                $updateArray['assigned_other_es_date'] = $assigned_other_es_date;

            }
            //// end====================
            //this code use only while Asistant generate Action Taken==============
            if ($assigned_to_other_type == 'Action') {

                unset($updateArray['assigned_from']);
                unset($updateArray['assigned_from_code']);
                unset($updateArray['assigned_to_code']);
                unset($updateArray['assigned_to']);
                unset($updateArray['assigned_date']);
                unset($updateArray['escalated_date']);
                //// $updateArray['history_id_others'] = null;
                $updateArray['assignment_type_other'] = null;
                $updateArray['assigned_other'] = null;
                $updateArray['assigned_other_code'] = null;
                $updateArray['assigned_other_date'] = null;
                $updateArray['assigned_other_es_date'] = null;
                $updateArray['to_be_other_completed_within_days'] = null;

                $checkSKReportDoneorNot = $escalatedRowDetailsAgainstPetitionno->assigned_to_code;
                if ($checkSKReportDoneorNot == 6) {
                    $originalAllocation = $escalatedRowDetailsAgainstPetitionno->co_target_days;
                    $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
                    $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO, $originalAllocation);
                    if ($remaining_days_other < 0) {
                        $response['responseType'] = 0;
                        $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                        return $response;
                    }
                    $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);
                    $updateArray['assigned_date'] = $executionDate;
                    $updateArray['escalated_date'] = $escalatedDate;
                }

            }
            //// end====================

        }

        if ($user_type == 'SK') {

            $doubleEntry = 0;
            $entryTimes = 0;

            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);

            $dateCodes = $escalatedRowDetailsAgainstPetitionno->sk_date_code_list;
            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->sk_completed_days;
            $sk_target_days = $escalatedRowDetailsAgainstPetitionno->sk_target_days;
            // log_message("error","SK-TARGET_DAYS=======".$sk_target_days);
            $sk_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);
            // log_message("error","SK-COMPLETION_DAYS=======".$sk_completed_days);
            // if ($sk_target_days < $sk_completed_days) {
            //     $escalate_status = 'Y';
            // } else {
                $escalate_status = 'N';
            // }
            // log_message("error","SK-ESCALATE_STATUS=======".$escalate_status);
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }

            //this calculation is for assigning CO from SK and taking hearing date as assigned date====
            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO, $originalAllocation);
            if ($remaining_days_other < 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $assigned_other_es_date = $this->getOtherEscalatedDate($remaining_days_other, $hearing_date);
            // $to_be_completed_within_days = $this->dateDiff($assigned_other_es_date, $hearing_date);
            $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);
            // log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);

            ///end==============

            //if action taken done then co assigned date is sk report date
            //otherwise co report date is action taken date

            $checkDAActionTakenDoneOrNot = $escalatedRowDetailsAgainstPetitionno->assigned_other;
            if ($checkDAActionTakenDoneOrNot == null) {
                $hearing_date = $executionDate;
                $assigned_other_es_date = $this->getEscalatedDateNew($remaining_days_other, $hearing_date);
            }

            $updateArray = array(
                'taskid' => $taskid,
                'sk_completed_days' => (int) $sk_completed_days + (int) $previousCompletedDays,
                'sk_escalate_status' => $escalate_status,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                // 'assigned_date'      => $executionDate,
                'assigned_date' => $executionDate,
                'escalated_date' => $escalatedDate,
                'sk_date_code_list' => $dateCodes,
                'to_be_completed_within_days' => $to_be_completed_within_days,
            );

            // log_message("error","CO==============SK".json_encode($updateArray));

        }

        if ($user_type == 'LM') {

            $doubleEntry = 0;
            $entryTimes = 0;

            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);

            $dateCodes = $escalatedRowDetailsAgainstPetitionno->lm_date_code_list;
            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
            $lm_target_days = $escalatedRowDetailsAgainstPetitionno->lm_target_days;

            // log_message("error","LM-TARGET_DAYS=======".$lm_target_days);
            $lm_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);
            // log_message("error","LM-COMPLETION_DAYS=======".$lm_completed_days);
            // if ($lm_target_days < $lm_completed_days) {
            //     $escalate_status = 'Y';
            // } else {
                $escalate_status = 'N';
            // }
            // log_message("error","LM-ESCALATE_STATUS=======".$escalate_status);
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }

            // if($assigned_to_other_type == 'LMRevert'){
            //   //this calculation is for assigning CO from LM and taking hearing date as assigned date AS REVERT CASE====
            //   $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            //   $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            //   $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
            //   $assigned_other_es_date = $this->getOtherEscalatedDate($remaining_days_other,$hearing_date);
            //   $to_be_completed_within_days = $this->dateDiff($assigned_other_es_date,$hearing_date);
            //   log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);
            //   $executionDate = $hearing_date;
            //   $escalatedDate = $assigned_other_es_date;
            // }
            $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);
            $updateArray = array(
                'taskid' => $taskid,
                'lm_completed_days' => (int) $lm_completed_days + (int) $previousCompletedDays,
                'lm_escalate_status' => $escalate_status,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_date' => $executionDate,
                'escalated_date' => $escalatedDate,
                'lm_date_code_list' => $dateCodes,
                'to_be_completed_within_days' => $to_be_completed_within_days,
            );

        }

        if ($user_type == 'DC') {
            $entryTimes = 0;
            $doubleEntry = 0;
            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);

            $dateCodes = $escalatedRowDetailsAgainstPetitionno->dc_date_code_list;
            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->dc_completed_days;
            $dc_target_days = $escalatedRowDetailsAgainstPetitionno->dc_target_days;

            // log_message("error","DC-TARGET_DAYS=======".$dc_target_days);
            $dc_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);
            // log_message("error","DC-COMPLETION_DAYS=======".$dc_completed_days);
            // if ($dc_target_days < $dc_completed_days) {
            //     $escalate_status = 'Y';
            // } else {
                $escalate_status = 'N';
            // }
            // log_message("error","DC-ESCALATE_STATUS=======".$escalate_status);
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }

            // if($assigned_to_other_type == 'LMRevert'){
            //   //this calculation is for assigning CO from LM and taking hearing date as assigned date AS REVERT CASE====
            //   $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            //   $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            //   $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
            //   $assigned_other_es_date = $this->getOtherEscalatedDate($remaining_days_other,$hearing_date);
            //   $to_be_completed_within_days = $this->dateDiff($assigned_other_es_date,$hearing_date);
            //   log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);
            //   $executionDate = $hearing_date;
            //   $escalatedDate = $assigned_other_es_date;
            // }
            $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);
            $updateArray = array(
                'taskid' => $taskid,
                'dc_completed_days' => (int) $dc_completed_days + (int) $previousCompletedDays,
                'dc_escalate_status' => $escalate_status,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_date' => $executionDate,
                'escalated_date' => $escalatedDate,
                'dc_date_code_list' => $dateCodes,
                'to_be_completed_within_days' => $to_be_completed_within_days,
            );

        }

        if ($user_type == 'BO') {
            $entryTimes = 0;
            $doubleEntry = 0;
            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);

            $dateCodes = $escalatedRowDetailsAgainstPetitionno->bo_date_code_list;
            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->bo_completed_days;
            $bo_target_days = $escalatedRowDetailsAgainstPetitionno->bo_target_days;

            // log_message("error","DC-TARGET_DAYS=======".$dc_target_days);
            $bo_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);
            // log_message("error","DC-COMPLETION_DAYS=======".$dc_completed_days);
            // if ($bo_target_days < $bo_completed_days) {
            //     $escalate_status = 'Y';
            // } else {
                $escalate_status = 'N';
            // }
            // log_message("error","DC-ESCALATE_STATUS=======".$escalate_status);
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }

            // if($assigned_to_other_type == 'LMRevert'){
            //   //this calculation is for assigning CO from LM and taking hearing date as assigned date AS REVERT CASE====
            //   $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            //   $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            //   $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO,$originalAllocation);
            //   $assigned_other_es_date = $this->getOtherEscalatedDate($remaining_days_other,$hearing_date);
            //   $to_be_completed_within_days = $this->dateDiff($assigned_other_es_date,$hearing_date);
            //   log_message("error","hearing_date==========".$hearing_date."===assigned_other_es_date".$assigned_other_es_date);
            //   $executionDate = $hearing_date;
            //   $escalatedDate = $assigned_other_es_date;
            // }
            $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);
            $updateArray = array(
                'taskid' => $taskid,
                'bo_completed_days' => (int) $bo_completed_days + (int) $previousCompletedDays,
                'bo_escalate_status' => $escalate_status,
                'assigned_from' => $user_code,
                'assigned_from_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'assigned_date' => $executionDate,
                'escalated_date' => $escalatedDate,
                'bo_date_code_list' => $dateCodes,
                'to_be_completed_within_days' => $to_be_completed_within_days,
            );

        }

        //UPDATE ESCALATION DATE HISTORY TABLE=====================

        $updateFlag = true;
        if ($assigned_to_other_type == 'Notice' || $assigned_to_other_type == 'Action') {
            $updateFlag = false;
            $history_id = $escalatedRowDetailsAgainstPetitionno->history_id_others;
        } else {
            $updateFlag = true;
            $history_id = $escalatedRowDetailsAgainstPetitionno->history_id;
        }

        // log_message("error","UPDATED FLAG ==========".$updateFlag);

        //STEPS to be followed:
        // 1. update escalation_dates_details against or history id
        // 2.update escalation_details with new date codes without history id
        // 3.insert history details and updated escalattion details with new history id

        $where_history = array(
            'petition_no' => $petition_no,
            'date_code' => $history_id,
            'service_code' => $service_code
        );

        // var_dump($where_history);
        // die;

        $updateDatesArray = array(
            'completion_date' => $executionDate,
            'escalated_status' => $escalate_status,
            'completion_days' => (int) $completion_days_for_history,
        );

        $updateStatus22 = $this->db->update('escalation_dates_details', $updateDatesArray, $where_history);
        // log_message("error","UPDt history escalation_dates_details TABLE=======".$this->db->affected_rows());
        if ($this->db->affected_rows() <= 0) {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION565 : Updation failed on Escalation row not found';
            return $response;
        }

        ///////////////END PROCESS//////////////////////////

        $where = array(
            'petition_no' => $petition_no,
            'case_no'     => $case_no
        );

        if ($finalStatus == 'final') {
            unset($updateArray['assigned_to']);
            unset($updateArray['assigned_to_code']);
            unset($updateArray['assigned_from']);
            unset($updateArray['assigned_from_code']);
            unset($updateArray['assigned_date']);
            unset($updateArray['escalated_date']);
            unset($updateArray['to_be_completed_within_days']);
            unset($updateArray['co_date_code_list']);

            $updateArray['assignment_type_other'] = null;
            $updateArray['assigned_other'] = null;
            $updateArray['assigned_other_code'] = null;
            $updateArray['assigned_other_date'] = null;
            $updateArray['assigned_other_es_date'] = null;
            $updateArray['to_be_other_completed_within_days'] = null;
            $updateArray['final_completion_date'] = $executionDate;
            $updateArray['status'] = 'F';

        }

        // log_message('error',"FINAL UPDATED ARRAY===============".json_encode($updateArray));
        $updateStatus1 = $this->db->update('escalation_details', $updateArray, $where);

        // log_message("error","ESCALATION DETAILS ENTRY TABLE=======".$this->db->affected_rows());
        // if($this->db->affected_rows() <= 0){
        //    $flag = 0;
        // }else{
        //    $flag = 1;
        // }
        if ($this->db->affected_rows() <= 0) {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION610 : Updation failed on escalation_details';
            return $response;
        }

        if ($doubleEntry == 0 && $finalStatus == null) {
            if ($assigned_to_other_type == 'Notice' || $assigned_to_other_type == 'SKReport') {
                $executionDate = $hearing_date;
                $escalatedDate = $assigned_other_es_date;
            }

            $action_type_array = json_decode(ASSIGNMENT_TYPE);

            $action_type = $action_type_array[0]->CODE;
            if ($escalate_status == 'Y') {
                $action_type = $action_type_array[1]->CODE;
            }

            $date_history = $this->generateDateCode();
            $insertDateArray = array(
                'sr_no' => $dateCode,
                'date_code' => $date_history,
                'petition_no' => $petition_no,
                'service_code' => $escalatedRowDetailsAgainstPetitionno->service_code,
                'taskid' => $taskid,
                'action_type' => $action_type,
                'pending_officer' => $assigned_to,
                'assigned_user' => $user_code,
                'assigned_user_code' => $assigned_from_code,
                'assigned_to' => $assigned_to,
                'assigned_to_code' => $assigned_to_code,
                'registerd_on' => $escalatedRowDetailsAgainstPetitionno->registerd_on,
                'allocation_date' => $executionDate,
                'target_completion_date' => $escalatedDate,
                'date_diff' => $this->dateDiff($escalatedDate, $executionDate),
                'escalated_status' => $escalate_status,
                'created_date' => date('Y-m-d H:i:s'),
                'updated_date' => date('Y-m-d H:i:s'),
                'case_no'      => $case_no,
            );
            if ($finalStatus == 'final') {
                $insertDateArray['completion_date'] = $executionDate;
            }
            // log_message("error","escalate_dates_status======".json_encode($insertDateArray));
            $status = $this->db->insert('escalation_dates_details', $insertDateArray);
            if ($status != 1) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRESCLATION610 : Updation failed on escalation_details';
                return $response;
            }
            if ($updateFlag == true) {
                $where_history_set = array(
                    'petition_no' => $petition_no,
                    'case_no'     => $case_no
                );
                $updateDatesArraySet = array(
                    'history_id' => $date_history,
                );
                $updateStatus22 = $this->db->update('escalation_details', $updateDatesArraySet, $where_history_set);
                if ($this->db->affected_rows() <= 0) {
                    $response['responseType'] = 0;
                    $response['msg'] = '#ERRESCLATION662 : Updation failed on escalation_details';
                    return $response;
                }
            }

        }

        //INSERT HISTORY FOR ESCALATION DATE DETAILS=====================
        if ($entryTimes == 1) {
            $action_type = json_decode(ASSIGNMENT_TYPE);
            $action_type = $action_type[0]->CODE;
            if ($escalate_status == 'Y') {
                $action_type = $action_type[1]->CODE;
            }

            $date_history = $this->generateDateCode();
            $insertDateArray = array(
                'date_code' => $date_history,
                'petition_no' => $petition_no,
                'service_code' => $escalatedRowDetailsAgainstPetitionno->service_code,
                'taskid' => $taskid,
                'action_type' => $action_type,
                'pending_officer' => $assigned_to_other,
                'assigned_user' => $user_code,
                'assigned_user_code' => $assigned_from_code,
                'assigned_to' => $assigned_to_other,
                'assigned_to_code' => $assigned_other_code,
                'registerd_on' => $escalatedRowDetailsAgainstPetitionno->registerd_on,
                'allocation_date' => $assigned_other_date,
                'target_completion_date' => $assigned_other_es_date,
                'date_diff' => $this->dateDiff($assigned_other_es_date, $executionDate),
                'escalated_status' => $escalate_status,
                'created_date' => date('Y-m-d H:i:s'),
                'updated_date' => date('Y-m-d H:i:s'),
                'case_no'      => $case_no,
            );
            $status = $this->db->insert('escalation_dates_details', $insertDateArray);
            if ($status != 1) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRESCLATION696 : Updation failed on escalation_dates_details';
                return $response;
            }
            $where_history_set = array(
                'petition_no' => $petition_no,
                'case_no'     => $case_no
            );

            $updateDatesArraySet = array(
                'history_id_others' => $date_history,
            );
            $updateStatus22 = $this->db->update('escalation_details', $updateDatesArraySet, $where_history_set);
            if ($this->db->affected_rows() <= 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRESCLATION710 : Updation failed on escalation_details';
                return $response;
            }
        }

        return $response;

        // log_message("error","ESCALATION DATE DETAILS ENTRY TABLE=======".$status);
        //////////////////////END PROCESS////////////////////
        // if($status !=1){
        //   $flag1 = 0;
        // }else{
        //   $flag1 = 1;
        // }
        // if($flag==1 && $flag1 == 1){
        //   return $flag;
        // }else{
        //   return 0;
        // }
    }


    // added on 05/04/2024
    public function getPendingNameCorrectionCasesForLm($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $start, $length, $order, $define_date, $searchByCol_0, $zone_status, $user_code)
    {
        $curr_date = date('Y-m-d');
        $col = 0;
        $dir = "asc";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 'misc_case_basic.submission_date',
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
            $this->db->where("(misc_case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }

        $this->db->select('misc_case_basic.*, misc_case_basic.misc_case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 'misc_case_basic.misc_case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 'misc_case_basic.misc_case_no = escalation_details.case_no', 'left');

        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('mouza_pargona_code', $mouza_pargona_code);
        $this->db->where('lot_no', $lot_no);
        $this->db->where('misc_case_basic.lm_note_yn', null);
        $this->db->where('misc_case_basic.fresh_yn', 'Y');
        $this->db->where('misc_case_basic.status !=', 'F');
        $this->db->where('misc_case_basic.submission_date >=', $define_date);
        if ($zone_status == 4) {
            $this->db->where('misc_case_basic.es_flag', 0);
        } else {
            $this->db->where('misc_case_basic.es_flag', 1);
        }
        $this->db->limit($length, $start);
        $query = $this->db->get('misc_case_basic');
        log_message('error', "#3022: misc_case_basic: " . $this->db->last_query());
        if ($query->num_rows() > 0) {
            $data_results = $query->result();
            $final_array = array();
            foreach ($data_results as $rr) {
                $variable = $this->escalationZoneWiseSearchNameCorrection($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->submission_date, $rr->escalated_date, $user_code, $rr->lm_target_days, $rr->assigned_date, $rr->fresh_yn, $rr->status, $rr->lm_note_yn, $rr->notice_generated_yn, $rr->sk_note_yn, $rr->next_date_of_hearing, $rr->proceeding_yn, $rr->misc_case_type, $rr->misc_case_petition_no, $rr->is_escalated);
                if (!empty($variable)) {
                    $final_array[] = $variable;
                }
            }
            $data['data_results'] = $final_array;
            $data['total_records'] = count($final_array);
            if (!empty($searchByCol_0)) {
                $this->db->where("(misc_case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
            }
            $this->db->select('misc_case_basic.*, misc_case_basic.misc_case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
            $this->db->join('basundhar_application', 'misc_case_basic.misc_case_no = basundhar_application.dharitree', 'left');
            $this->db->join('escalation_details', 'misc_case_basic.misc_case_no = escalation_details.case_no', 'left');
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('mouza_pargona_code', $mouza_pargona_code);
            $this->db->where('lot_no', $lot_no);
            $this->db->where('misc_case_basic.lm_note_yn', null);
            $this->db->where('misc_case_basic.fresh_yn', 'Y');
            $this->db->where('misc_case_basic.status !=', 'F');
            $this->db->where('misc_case_basic.submission_date >=', $define_date);
            if ($zone_status == 4) {
                $this->db->where('misc_case_basic.es_flag', 0);
            } else {
                $this->db->where('misc_case_basic.es_flag', 1);
            }
            $res = $this->db->get('misc_case_basic')->result();
            // echo $this->db->last_query();
            $cc = array();
            foreach ($res as $r) {
                if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
                    $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
                    $perct_avail = (100 * $remain_days) / $r->lm_target_days;
                    //green zone
                    if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
                        $cc[] = 1;
                    }
                    //yellow zone
                    else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
                        $cc[] = 1;
                    }
                    //red zone
                    else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
                        $cc[] = 1;
                    } else if ($zone_status == 4) {
                        $cc[] = 1;
                    }
                } else {
                    $cc[] = 1;
                }
            }
            $data['total_records'] = count($cc);
            return $data;
        }
    }

    public function escalationZoneWiseSearchNameCorrection($zone_status, $es_flag, $c_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $rtps_no, $submission_date, $escalated_date, $user_code, $target_days, $assigned_date, $fresh_yn, $status, $lm_note_yn, $notice_generated_yn, $sk_note_yn, $next_date_of_hearing, $proceeding_yn, $misc_case_type, $misc_case_petition_no, $is_escalated)
    {
        $curr_date = date('Y-m-d');
        $esc_date = $escalated_date;
        $esc_flag = $es_flag;
        $final_array = '';
        if (!empty($zone_status) && ($esc_date != null || $esc_date != '') && ($esc_flag == 1)) {
            $remaining_days = $this->dateDiff($esc_date, $curr_date);
            $per_avail = (100 * $remaining_days) / $target_days;
            //green zone
            if (($zone_status == 1) && ($per_avail >= YELLOW_ZONE)) {
                $final_array = (object) [
                    'misc_case_no'          => $c_no,
                    'dist_code'             => $dist_code,
                    'subdiv_code'           => $subdiv_code,
                    'cir_code'              => $cir_code,
                    'mouza_pargona_code'    => $mouza_pargona_code,
                    'lot_no'                => $lot_no,
                    'vill_townprt_code'     => $vill_townprt_code,
                    'basundhara'            => $rtps_no,
                    'submission_date'       => $submission_date,
                    'escalated_date'        => $escalated_date,
                    'es_flag'               => $es_flag,
                    'assigned_from'         => $user_code,
                    'target_days'           => $target_days,
                    'assigned_date'         => $assigned_date,
                    'fresh_yn'              => $fresh_yn,
                    'status'                => $status,
                    'lm_note_yn'            => $lm_note_yn,
                    'notice_generated_yn'   => $notice_generated_yn,
                    'sk_note_yn'            => $sk_note_yn,
                    'next_date_of_hearing'  => $next_date_of_hearing,
                    'proceeding_yn'         => $proceeding_yn,
                    'misc_case_type'        => $misc_case_type,
                    'misc_case_petition_no' => $misc_case_petition_no,
                    'is_escalated'          => $is_escalated,
                ];
            }
            //yellow zone
            else if (($zone_status == 2) && (($per_avail < YELLOW_ZONE) && ($per_avail > RED_ZONE))) {
                $final_array = (object) [
                    'misc_case_no'          => $c_no,
                    'dist_code'             => $dist_code,
                    'subdiv_code'           => $subdiv_code,
                    'cir_code'              => $cir_code,
                    'mouza_pargona_code'    => $mouza_pargona_code,
                    'lot_no'                => $lot_no,
                    'vill_townprt_code'     => $vill_townprt_code,
                    'basundhara'            => $rtps_no,
                    'submission_date'       => $submission_date,
                    'escalated_date'        => $escalated_date,
                    'es_flag'               => $es_flag,
                    'assigned_from'         => $user_code,
                    'target_days'           => $target_days,
                    'assigned_date'         => $assigned_date,
                    'fresh_yn'              => $fresh_yn,
                    'status'                => $status,
                    'lm_note_yn'            => $lm_note_yn,
                    'notice_generated_yn'   => $notice_generated_yn,
                    'sk_note_yn'            => $sk_note_yn,
                    'next_date_of_hearing'  => $next_date_of_hearing,
                    'proceeding_yn'         => $proceeding_yn,
                    'misc_case_type'        => $misc_case_type,
                    'misc_case_petition_no' => $misc_case_petition_no,
                    'is_escalated'          => $is_escalated,
                ];
            }
            //red zone
            else if (($zone_status == 3) && ($per_avail <= RED_ZONE)) {
                $final_array = (object) [
                    'misc_case_no'          => $c_no,
                    'dist_code'             => $dist_code,
                    'subdiv_code'           => $subdiv_code,
                    'cir_code'              => $cir_code,
                    'mouza_pargona_code'    => $mouza_pargona_code,
                    'lot_no'                => $lot_no,
                    'vill_townprt_code'     => $vill_townprt_code,
                    'basundhara'            => $rtps_no,
                    'submission_date'       => $submission_date,
                    'escalated_date'        => $escalated_date,
                    'es_flag'               => $es_flag,
                    'assigned_from'         => $user_code,
                    'target_days'           => $target_days,
                    'assigned_date'         => $assigned_date,
                    'fresh_yn'              => $fresh_yn,
                    'status'                => $status,
                    'lm_note_yn'            => $lm_note_yn,
                    'notice_generated_yn'   => $notice_generated_yn,
                    'sk_note_yn'            => $sk_note_yn,
                    'next_date_of_hearing'  => $next_date_of_hearing,
                    'proceeding_yn'         => $proceeding_yn,
                    'misc_case_type'        => $misc_case_type,
                    'misc_case_petition_no' => $misc_case_petition_no,
                    'is_escalated'          => $is_escalated,
                ];
            }
            //old cases
            else if ($zone_status == 4) {
                $final_array = (object) [
                    'misc_case_no'          => $c_no,
                    'dist_code'             => $dist_code,
                    'subdiv_code'           => $subdiv_code,
                    'cir_code'              => $cir_code,
                    'mouza_pargona_code'    => $mouza_pargona_code,
                    'lot_no'                => $lot_no,
                    'vill_townprt_code'     => $vill_townprt_code,
                    'basundhara'            => $rtps_no,
                    'submission_date'       => $submission_date,
                    'escalated_date'        => $escalated_date,
                    'es_flag'               => $es_flag,
                    'assigned_from'         => $user_code,
                    'target_days'           => $target_days,
                    'assigned_date'         => $assigned_date,
                    'fresh_yn'              => $fresh_yn,
                    'status'                => $status,
                    'lm_note_yn'            => $lm_note_yn,
                    'notice_generated_yn'   => $notice_generated_yn,
                    'sk_note_yn'            => $sk_note_yn,
                    'next_date_of_hearing'  => $next_date_of_hearing,
                    'proceeding_yn'         => $proceeding_yn,
                    'misc_case_type'        => $misc_case_type,
                    'misc_case_petition_no' => $misc_case_petition_no,
                    'is_escalated'          => $is_escalated,
                ];
            }
        } else {
            $final_array = (object) [
                'misc_case_no'              => $c_no,
                'dist_code'                 => $dist_code,
                'subdiv_code'               => $subdiv_code,
                'cir_code'                  => $cir_code,
                'mouza_pargona_code'        => $mouza_pargona_code,
                'lot_no'                    => $lot_no,
                'vill_townprt_code'         => $vill_townprt_code,
                'basundhara'                => $rtps_no,
                'submission_date'           => $submission_date,
                'escalated_date'            => $escalated_date,
                'es_flag'                   => $es_flag,
                'assigned_from'             => $user_code,
                'target_days'               => $target_days,
                'assigned_date'             => $assigned_date,
                'fresh_yn'                  => $fresh_yn,
                'status'                    => $status,
                'lm_note_yn'                => $lm_note_yn,
                'notice_generated_yn'       => $notice_generated_yn,
                'sk_note_yn'                => $sk_note_yn,
                'next_date_of_hearing'      => $next_date_of_hearing,
                'proceeding_yn'             => $proceeding_yn,
                'misc_case_type'            => $misc_case_type,
                'misc_case_petition_no'     => $misc_case_petition_no,
                'is_escalated'              => $is_escalated,
            ];
        }
        return $final_array;
    }

    public function escalationLmNameCorrReport($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code)
    {
        // $executionDate = date('Y-m-d H:i:s');
        $assigned_to = $this->Escalationmodel->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $user_type          = 'LM';
        $service_code       = '6';
        $assigned_to_code   = $assigned_to->user_code;
        $assigned_user_type = 'CO';
        $finalStatus        = null;
        $hearing_date       = null;
        $task               = json_decode(NCOR);
        $taskid             = $task[1]->CODE;
        $assignment_type    = null;
        $allocation_days    = 0;
        $service_type       = explode('/',$case_no);
        $response           = array();

        $escalationUpdateStatus = $this->escalationMatrixUpdateNameCorr($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $hearing_date, $taskid, $assignment_type, $allocation_days);

        return $escalationUpdateStatus;
    }

    public function escalationMatrixUpdateNameCorr($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to, $assigned_user_type, $finalStatus, $hearing_date, $taskid, 
        $assignment_type, $allocation_days)
    {
        $executionDate = date('Y-m-d H:i:s');
        // log_message("error", "NCRPARAMS12943: ".json_encode('case_no:'.$case_no.'---executionDate:'.$executionDate.'---user_code:'.$user_code.'---user_type:'.$user_type.'---service_code:'.$service_code.'---assigned_to:'.$assigned_to.'---assigned_user_type:'.$assigned_user_type.'---finalStatus:'.$finalStatus.'---hearing_date:'.$hearing_date.'---taskid:'.$taskid.'---assignment_type:'.$assignment_type.'---allocation_days:'.$allocation_days));

        $response = array('responseType' => 1, 'msg' => null);
        $petition_no = $this->getPetitionNoNCOR($case_no);
        // WARNING BEFORE CODE=========================
        
        $escalatedRowDetailsAgainstPetitionno = $this->getEscalatedRowDetails($petition_no, $service_code);
        // $escalatedRowDetailsAgainstPetitionno = $this->getEscalatedRowDetails($petition_no);
        if ($escalatedRowDetailsAgainstPetitionno == null || empty($escalatedRowDetailsAgainstPetitionno)) {
            log_message('error', '#ERRESCLATION12951 : Escalation matrix row not found');
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION12951 : Escalation matrix row not found';
            return $response;
        }
        $assigned_to_code = $assigned_from_code = null;
        $userCodeList = json_decode(USER_ALLOT_CODE);
        foreach ($userCodeList as $key => $value) {
            if ($value->USER == $user_type) {
                $assigned_from_code = $value->CODE;
            }
            if ($value->USER == $assigned_user_type) {
                $assigned_to_code = $value->CODE;
            }
        }

        $lastAssignedDate = $escalatedRowDetailsAgainstPetitionno->assigned_date;
        $lastEscalatedDate = $escalatedRowDetailsAgainstPetitionno->escalated_date;
        // log_message("error", "ASSIGNED_DATE=======" . $lastAssignedDate);

        $validateExecutionDateTime = $this->checkCaseExecutionOnTimeOrNot($executionDate, $lastAssignedDate, $lastEscalatedDate);
        if ($validateExecutionDateTime == 'n') {
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION12974 : Case Execution not on time';
            return $response;
        }

        $timeLineRow = $this->getTimeLine($service_code, 'NCOR');
        if ($timeLineRow == null || empty($timeLineRow)) {
            log_message('error', '#ERRESCLATION12980 : Escalation Timeline not found');
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION12980 : Escalation Timeline not found';
            return $response;
        }

        if ($assigned_user_type == 'LM') {
            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
            $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
            // log_message("error","previousCompletedDaysLM--------------".$previousCompletedDaysLM);
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysLM, $originalAllocation);
        if ($remaining_days_other < 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);
        } elseif ($assigned_user_type == 'CO') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysCO, $originalAllocation);
        if ($remaining_days_other < 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);
        } elseif ($assigned_user_type == 'ADC') {

            $originalAllocation = $escalatedRowDetailsAgainstPetitionno->adc_target_days;
            $previousCompletedDaysAdc = $escalatedRowDetailsAgainstPetitionno->adc_completed_days;
            $remaining_days_other = $this->getRemainingDays($previousCompletedDaysAdc, $originalAllocation);
        if ($remaining_days_other < 0) {
                $response['responseType'] = 0;
                $response['msg'] = '#ERRRMESCLATION3281 : Remaining days can not be zero days';
                return $response;
            }
            // $escalatedDate        = $this->getEscalatedDate($remaining_days_other);
            $escalatedDate = $this->getEscalatedDateNew($remaining_days_other, $executionDate);
        }

        $doubleEntry = 0;
        $entryTimes = 0;
        $dateCode = $this->generateDateCode();

        if ($user_type == 'LM') {
            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);
            $dateCodes = $escalatedRowDetailsAgainstPetitionno->lm_date_code_list;

            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;

            $lm_target_days = $escalatedRowDetailsAgainstPetitionno->lm_target_days;

            // log_message("error","========LM-TARGET_DAYS =======".$lm_target_days);

            $lm_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);

            // log_message("error","========LM-COMPLETION_DAYS=======".$lm_completed_days);
            // if ($lm_target_days < $lm_completed_days) {
            //     $escalate_status = 'Y';
            // } else {
            $escalate_status = 'N';
            // }
            // log_message("error","LM-ESCALATE_STATUS=======".$escalate_status);
            $latestHistoryCode = $dateCodes;
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }
            $entryTimes = 0;
            $doubleEntry = 0;
            $assigned_other_date = null;
            $to_be_other_completed_within_days = null;
            $assigned_other_es_date = null;

            $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);

            $updateArray = array(
                'taskid' => $taskid,
                'lm_completed_days'           => (int) $lm_completed_days + (int) $previousCompletedDays,
                'lm_escalate_status'          => $escalate_status,
                'assigned_to'                 => $assigned_to,
                'assigned_to_code'            => $assigned_to_code,
                'assigned_from'               => $user_code,
                'assigned_from_code'          => $assigned_from_code,
                'assigned_date'               => $executionDate,
                'escalated_date'              => $escalatedDate,
                'to_be_completed_within_days' => $to_be_completed_within_days,
                'lm_date_code_list'           => $dateCodes,
            );
        }

        if ($user_type == 'CO') {
            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);
            $dateCodes = $escalatedRowDetailsAgainstPetitionno->co_date_code_list;

            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->co_completed_days;

            $co_target_days = $escalatedRowDetailsAgainstPetitionno->co_target_days;

            // log_message("error","========CO-TARGET_DAYS =======".$co_target_days);

            $co_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);

            // log_message("error","========CO-COMPLETION_DAYS=======".$co_completed_days);

            $escalate_status = 'N';

            // log_message("error","CO-ESCALATE_STATUS=======".$escalate_status);
            $latestHistoryCode = $dateCodes;
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }
            $entryTimes = 0;
            $doubleEntry = 0;
            $assigned_other_date = null;
            $to_be_other_completed_within_days = null;
            $assigned_other_es_date = null;

            $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);

            $updateArray = array(
                'taskid' => $taskid,
                'co_completed_days'           => (int) $co_completed_days + (int) $previousCompletedDays,
                'co_escalate_status'          => $escalate_status,
                'assigned_to'                 => $assigned_to,
                'assigned_to_code'            => $assigned_to_code,
                'assigned_from'               => $user_code,
                'assigned_from_code'          => $assigned_from_code,
                'assigned_date'               => $executionDate,
                'escalated_date'              => $escalatedDate,
                'to_be_completed_within_days' => $to_be_completed_within_days,
                'co_date_code_list'           => $dateCodes,
            );
        }

        if ($user_type == 'ADC') {
            $completion_days_for_history = $this->dateDiff($executionDate, $lastAssignedDate);
            $dateCodes = $escalatedRowDetailsAgainstPetitionno->adc_date_code_list;

            $previousCompletedDays = $escalatedRowDetailsAgainstPetitionno->adc_completed_days;

            $adc_target_days = $escalatedRowDetailsAgainstPetitionno->adc_target_days;

            // log_message("error","========ADC-TARGET_DAYS =======".$adc_target_days);

            $adc_completed_days = $this->dateDiff($executionDate, $lastAssignedDate);

            // log_message("error","========ADC-COMPLETION_DAYS=======".$adc_completed_days);
            // if ($adc_target_days < $adc_completed_days) {
            //     $escalate_status = 'Y';
            // } else {
                $escalate_status = 'N';
            // }
            // log_message("error","ADC-ESCALATE_STATUS=======".$escalate_status);
            $latestHistoryCode = $dateCodes;
            if ($dateCodes == null) {
                $dateCodes = $dateCode;
            } else {
                $dateCodes = $dateCodes . ',' . $dateCode;
            }
            $entryTimes = 0;
            $doubleEntry = 0;
            $assigned_other_date = null;
            $to_be_other_completed_within_days = null;
            $assigned_other_es_date = null;

            $to_be_completed_within_days = $this->dateDiff($escalatedDate, $executionDate);

            $updateArray = array(
                'taskid' => $taskid,
                'adc_completed_days'          => (int) $adc_completed_days + (int) $previousCompletedDays,
                'adc_escalate_status'         => $escalate_status,
                'assigned_to'                 => $assigned_to,
                'assigned_to_code'            => $assigned_to_code,
                'assigned_from'               => $user_code,
                'assigned_from_code'          => $assigned_from_code,
                'assigned_date'               => $executionDate,
                'escalated_date'              => $escalatedDate,
                'to_be_completed_within_days' => $to_be_completed_within_days,
                'adc_date_code_list'          => $dateCodes,
            );
        }

        $updateFlag = true;
        $history_id = $escalatedRowDetailsAgainstPetitionno->history_id;

        $where_history = array(
            'petition_no' => $petition_no,
            'date_code'   => $history_id,
            'service_code'  => $service_code,
        );
        $updateDatesArray = array(
            'completion_date'  => $executionDate,
            'escalated_status' => $escalate_status,
            'completion_days'  => $completion_days_for_history,
        );

        $updateStatus22 = $this->db->update('escalation_dates_details', $updateDatesArray, $where_history);
        if ($this->db->affected_rows() <= 0) {
            log_message('error', '#ERRESCLATION13169 : Updation failed escalation_dates_details' . json_encode($this->db->last_query()));
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION13169 : Updation failed escalation_dates_details';
            return $response;
        }

        $where = array(
            'petition_no' => $petition_no,
            'case_no'     => $case_no
        );
        if ($finalStatus == 'final') 
        {
          unset($updateArray['assigned_to']);
          unset($updateArray['assigned_to_code']);
          unset($updateArray['assigned_from']);
          unset($updateArray['assigned_from_code']);
          unset($updateArray['assigned_date']);
          unset($updateArray['escalated_date']);
          unset($updateArray['to_be_completed_within_days']);
          unset($updateArray['co_date_code_list']);

          $updateArray['to_be_other_completed_within_days'] = null;
          $updateArray['final_completion_date']             = $executionDate;
          $updateArray['status']                            = 'F';
        }

        // log_message('error',"FINAL UPDATED ARRAY===============".json_encode($updateArray));
        $updateStatus1 = $this->db->update('escalation_details', $updateArray, $where);
        if ($this->db->affected_rows() <= 0) {
            log_message('error', '#ERRESCLATION13200 : Updation failed escalation_details' . json_encode($this->db->last_query()));
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION13200 : Updation failed escalation_details';
            return $response;
        }

        $where = array(
            'petition_no' => $petition_no,
            'case_no'     => $case_no
        );
        if ($finalStatus == 'final') {
            unset($updateArray['assigned_to']);
            unset($updateArray['assigned_to_code']);
            unset($updateArray['assigned_from']);
            unset($updateArray['assigned_from_code']);
            unset($updateArray['assigned_date']);
            unset($updateArray['escalated_date']);
            unset($updateArray['to_be_completed_within_days']);

            $updateArray['to_be_other_completed_within_days'] = null;
            $updateArray['final_completion_date']             = $executionDate;
            $updateArray['status']                            = 'F';
        }

        $updateStatus1 = $this->db->update('escalation_details', $updateArray, $where);
        if ($this->db->affected_rows() <= 0) {
            log_message('error', '#ERRESCLATION13225 : Updation failed escalation_details' . json_encode($this->db->last_query()));
            $response['responseType'] = 0;
            $response['msg'] = '#ERRESCLATION13225 : Updation failed escalation_details';
            return $response;
        }


        if ($doubleEntry == 0 && $finalStatus == null) {
            
            $action_type = json_decode(ASSIGNMENT_TYPE);
            $action_type = $action_type[0]->CODE;
            if ($escalate_status == 'Y') {
                $action_type = $action_type[1]->CODE;
            }

            $date_history = $this->generateDateCode();
            $insertDateArray = array(
              'sr_no'                  => $dateCode,
              'date_code'              => $date_history,
              'petition_no'            => $petition_no,
              'service_code'           => $service_code,
              'taskid'                 => $taskid,
              'action_type'            => $action_type,
              'pending_officer'        => $assigned_to,
              'assigned_user'          => $user_code,
              'assigned_user_code'     => $assigned_from_code,
              'assigned_to'            => $assigned_to,
              'assigned_to_code'       => $assigned_to_code,
              'registerd_on'           => $escalatedRowDetailsAgainstPetitionno->registerd_on,
              'allocation_date'        => $executionDate,
              'target_completion_date' => $escalatedDate,
              'date_diff'              => $this->dateDiff($escalatedDate, $executionDate),
              'escalated_status'       => $escalate_status,
              'created_date'           => date('Y-m-d H:i:s'),
              'updated_date'           => date('Y-m-d H:i:s'),
              'case_no'                => $case_no
            );

            $status = $this->db->insert('escalation_dates_details', $insertDateArray);
            if ($status != 1) {
                log_message('error', '#ERRESCLATION13264 : Insertion failed escalation_dates_details' . json_encode($this->db->last_query()));
                $response['responseType'] = 0;
                $response['msg'] = '#ERRESCLATION13264 : Insertion failed escalation_dates_details';
                return $response;
            }
            if ($updateFlag == true) {
                $where_history_set = array(
                    'petition_no' => $petition_no,
                    'case_no'     => $case_no
                );
                $updateDatesArraySet = array(
                    'history_id' => $date_history,
                );
                $updateStatus22 = $this->db->update('escalation_details', $updateDatesArraySet, $where_history_set);
                if ($this->db->affected_rows() <= 0) {
                    log_message('error', '#ERRESCLATION13280 : Updation failed escalation_details' . json_encode($this->db->last_query()));
                    $response['responseType'] = 0;
                    $response['msg'] = '#ERRESCLATION13280 : Updation failed escalation_details';
                    return $response;
                }
            }

        }
        return $response;
    }

    public function escalationCoNameCorrReport($executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code)
    {
      $executionDate          = $executionDate;
      $assigned_to            = $this->getPendingOfficerADC($dist_code, 'ADC');
      $hearing_date           = null;
      $user_type              = 'CO';
      $service_code           = '6';
      $assigned_to_code       = $assigned_to->user_code;
      $assigned_user_type     = 'ADC';
      $finalStatus            = null;
      $task                   = json_decode(NCOR);
      $taskid                 = $task[2]->CODE;
      $allocation_days        = 0;
      $assignment_type        = null;

      $escalationUpdateStatus = $this->escalationMatrixUpdateNameCorr($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $hearing_date, $taskid, $assignment_type, $allocation_days);

      return $escalationUpdateStatus;
    }


    public function getMiscellaneousEscaltionViewFormat($cases)
    {
      // log_message('error', "#ERR9663: CASE_LIST_MODEL ".json_encode($cases));
      foreach ($cases as $rows) {
        if ($rows->es_flag == '1') {

          $escRow = $this->getEscalatedRowDetailsCaseNo($rows->misc_case_no);

          // log_message('error', '#13320: Data from escalation_details : ' . json_encode($escRow));
          // log_message('error', '#13321: Last_query_escalation_details : ' . json_encode($this->db->last_query()));
          // log_message("error", "#13322" . $escRow->assigned_date);
          
          if(!empty($escRow) && $escRow != null)
          {
            $escData = json_decode($this->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, 
              $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->submission_date));

            // log_message('error', '#13326: Escalation details : ' . json_encode($escData));

            $rows->escalation_date = $escData->escalation_date;
            $rows->escalation_zone = $escData->escalation_zone;
            $rows->assigned_date = $escData->assigned_date;
          } 
          else 
          {
            $rows->escalation_date = 'NA';
            $rows->escalation_zone = 'NA';
          }
        } 
        else 
        {
          $rows->escalation_date = 'NA';
          $rows->escalation_zone = 'NA';
        }
      }
    }

    public function getPendingNameCorrectionCasesForCo($dist_code, $subdiv_code, $cir_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status, $user_code)
    {
      $curr_date = date('Y-m-d');
      $col = 0;
      $dir = "asc";
      if (!empty($order)) {
        foreach ($order as $o) {
          $col = $o['column'];
          $dir = $o['dir'];
        }
      }

      if ($dir != "asc" && $dir != 'desc') {
        $dir = 'desc';
      }
      $valid_columns = array(
        0 => 'misc_case_basic.submission_date',
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
        $this->db->where("(misc_case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
      }

      $this->db->select('misc_case_basic.*, misc_case_basic.misc_case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
      $this->db->join('basundhar_application', 'misc_case_basic.misc_case_no = basundhar_application.dharitree', 'left');
      $this->db->join('escalation_details', 'misc_case_basic.misc_case_no = escalation_details.case_no', 'left');

      $this->db->where('dist_code', $dist_code);
      $this->db->where('subdiv_code', $subdiv_code);
      $this->db->where('cir_code', $cir_code);
      $this->db->where('misc_case_basic.status', '1');
      $this->db->where('misc_case_basic.lm_note_yn IS NOT NULL');
      $this->db->where('misc_case_basic.submission_date >=', $define_date);
      $this->db->where('misc_case_basic.fresh_yn', 'Y');
      $this->db->where('misc_case_basic.add_to_officer', $user_code);
      
      if ($zone_status == 4) {
          $this->db->where('misc_case_basic.es_flag', 0);
      } else {
          $this->db->where('misc_case_basic.es_flag', 1);
      }
      $this->db->limit($length, $start);
      $query = $this->db->get('misc_case_basic');
      // log_message('error', "#13401: misc_case_basic: " . $this->db->last_query());
      if ($query->num_rows() > 0) 
      {
        $data_results = $query->result();
        $final_array = array();
        foreach ($data_results as $rr) {
          $variable = $this->escalationZoneWiseSearchNameCorrection($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->submission_date, $rr->escalated_date, $user_code, $rr->lm_target_days, $rr->assigned_date, $rr->fresh_yn, $rr->status, $rr->lm_note_yn, $rr->notice_generated_yn, $rr->sk_note_yn, $rr->next_date_of_hearing, $rr->proceeding_yn, $rr->misc_case_type, $rr->misc_case_petition_no, $rr->is_escalated);
          if (!empty($variable)) {
            $final_array[] = $variable;
          }
        }
        $data['data_results'] = $final_array;
        $data['total_records'] = count($final_array);
        if (!empty($searchByCol_0)) {
          $this->db->where("(misc_case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }
        $this->db->select('misc_case_basic.*, misc_case_basic.misc_case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 'misc_case_basic.misc_case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 'misc_case_basic.misc_case_no = escalation_details.case_no', 'left');

        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('misc_case_basic.status', '1');
        $this->db->where('misc_case_basic.lm_note_yn IS NOT NULL');
        $this->db->where('misc_case_basic.submission_date >=', $define_date);
        $this->db->where('misc_case_basic.fresh_yn', 'Y');
        $this->db->where('misc_case_basic.add_to_officer', $user_code);

        if ($zone_status == 4) {
          $this->db->where('misc_case_basic.es_flag', 0);
        } else {
          $this->db->where('misc_case_basic.es_flag', 1);
        }
        $res = $this->db->get('misc_case_basic')->result();
        // echo $this->db->last_query();
        $cc = array();
        foreach ($res as $r) {
          if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
            $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
            $perct_avail = (100 * $remain_days) / $r->lm_target_days;
            //green zone
            if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
              $cc[] = 1;
            }
            //yellow zone
            else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
              $cc[] = 1;
            }
            //red zone
            else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
              $cc[] = 1;
            } else if ($zone_status == 4) {
              $cc[] = 1;
            }
          } else {
            $cc[] = 1;
          }
        }
        $data['total_records'] = count($cc);
        return $data;
      }
    }

    public function getPendingNameCorrectionCasesForAdc($dist_code, $start, $length, $order, $define_date, $searchByCol_0, $zone_status, $user_code)
    {
      $curr_date = date('Y-m-d');
      $col = 0;
      $dir = "asc";
      if (!empty($order)) {
        foreach ($order as $o) {
          $col = $o['column'];
          $dir = $o['dir'];
        }
      }

      if ($dir != "asc" && $dir != 'desc') {
        $dir = 'desc';
      }
      $valid_columns = array(
        0 => 'misc_case_basic.submission_date',
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
        $this->db->where("(misc_case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
      }

      $this->db->select('misc_case_basic.*, misc_case_basic.misc_case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
      $this->db->join('basundhar_application', 'misc_case_basic.misc_case_no = basundhar_application.dharitree', 'left');
      $this->db->join('escalation_details', 'misc_case_basic.misc_case_no = escalation_details.case_no', 'left');

      $this->db->where('dist_code', $dist_code);
      $this->db->where('subdiv_code', $subdiv_code);
      $this->db->where('cir_code', $cir_code);
      $this->db->where('misc_case_basic.status', 'A');
      $this->db->where('misc_case_basic.lm_note_yn', 'Y');
      $this->db->where('misc_case_basic.submission_date >=', $define_date);      
      if ($zone_status == 4) {
          $this->db->where('misc_case_basic.es_flag', 0);
      } else {
          $this->db->where('misc_case_basic.es_flag', 1);
      }
      $this->db->limit($length, $start);
      $query = $this->db->get('misc_case_basic');
      // log_message('error', "#13401: misc_case_basic: " . $this->db->last_query());
      if ($query->num_rows() > 0) 
      {
        $data_results = $query->result();
        $final_array = array();
        foreach ($data_results as $rr) {
          $variable = $this->escalationZoneWiseSearchNameCorrection($zone_status, $rr->es_flag, $rr->c_no, $rr->dist_code, $rr->subdiv_code, $rr->cir_code, $rr->mouza_pargona_code, $rr->lot_no, $rr->vill_townprt_code, $rr->rtps_no, $rr->submission_date, $rr->escalated_date, $user_code, $rr->lm_target_days, $rr->assigned_date, $rr->fresh_yn, $rr->status, $rr->lm_note_yn, $rr->notice_generated_yn, $rr->sk_note_yn, $rr->next_date_of_hearing, $rr->proceeding_yn, $rr->misc_case_type, $rr->misc_case_petition_no, $rr->is_escalated);
          if (!empty($variable)) {
            $final_array[] = $variable;
          }
        }
        $data['data_results'] = $final_array;
        $data['total_records'] = count($final_array);
        if (!empty($searchByCol_0)) {
          $this->db->where("(misc_case_no like '%$searchByCol_0%' or basundhara like '%$searchByCol_0%')");
        }
        $this->db->select('misc_case_basic.*, misc_case_basic.misc_case_no as c_no, basundhar_application.basundhara as rtps_no, escalation_details.*');
        $this->db->join('basundhar_application', 'misc_case_basic.misc_case_no = basundhar_application.dharitree', 'left');
        $this->db->join('escalation_details', 'misc_case_basic.misc_case_no = escalation_details.case_no', 'left');

        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('misc_case_basic.status', '1');
        $this->db->where('misc_case_basic.lm_note_yn IS NOT NULL');
        $this->db->where('misc_case_basic.submission_date >=', $define_date);
        $this->db->where('misc_case_basic.fresh_yn', 'Y');
        $this->db->where('misc_case_basic.add_to_officer', $user_code);

        if ($zone_status == 4) {
          $this->db->where('misc_case_basic.es_flag', 0);
        } else {
          $this->db->where('misc_case_basic.es_flag', 1);
        }
        $res = $this->db->get('misc_case_basic')->result();
        // echo $this->db->last_query();
        $cc = array();
        foreach ($res as $r) {
          if (!empty($zone_status) && ($r->escalated_date != null || $r->escalated_date != '') && ($r->es_flag == 1)) {
            $remain_days = $this->dateDiff($r->escalated_date, $curr_date);
            $perct_avail = (100 * $remain_days) / $r->lm_target_days;
            //green zone
            if (($zone_status == 1) && ($perct_avail >= YELLOW_ZONE)) {
              $cc[] = 1;
            }
            //yellow zone
            else if (($zone_status == 2) && (($perct_avail < YELLOW_ZONE) && ($perct_avail > RED_ZONE))) {
              $cc[] = 1;
            }
            //red zone
            else if (($zone_status == 3) && ($perct_avail <= RED_ZONE)) {
              $cc[] = 1;
            } else if ($zone_status == 4) {
              $cc[] = 1;
            }
          } else {
            $cc[] = 1;
          }
        }
        $data['total_records'] = count($cc);
        return $data;
      }
    }

    public function escalationAdcNameCorrReport($executionDate, $dist_code, $case_no, $user_code)
    {
      $executionDate          = $executionDate;
      $assigned_to            = $this->getPendingOfficerADC($dist_code, 'ADC');
      $hearing_date           = null;
      $user_type              = 'ADC';
      $service_code           = '6';
      $assigned_to_code       = $assigned_to->user_code;
      $assigned_user_type     = 'ADC';
      $finalStatus            = 'final';
      $task                   = json_decode(NCOR);
      $taskid                 = $task[3]->CODE;
      $allocation_days        = 0;
      $assignment_type        = null;

      $escalationUpdateStatus = $this->escalationMatrixUpdateNameCorr($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $hearing_date, $taskid, $assignment_type, $allocation_days);

      return $escalationUpdateStatus;
    }

    public function getEscalationRemarkDetails($case_no,$user_desig_code,$user_code)
    {
        if($user_desig_code == 'LM')
        {
            $sql = $this->db->query("select * from escalation_cases_remark_status where case_no = ? and assigned_from = ? and  remark_status is null ", array($case_no,$user_desig_code));
            return $sql->row();
        }
        else
        {
            $sql = $this->db->query("select * from escalation_cases_remark_status where case_no = ? and assigned_from = ? and  remark_status is null ", array($case_no,$user_desig_code));
            return $sql->row();
        }
    }
    public function escalationRemarkCheckandUpdate($case_no,$esc_remark,$user_desig_code)
    {
        $response = array('responseType' => 2,'msg' => null);
        $remarkDetails = $this->db->query("select * from  escalation_cases_remark_status where case_no=? and assigned_from = ? ",array($case_no,$user_desig_code))->row();
        if(!empty($remarkDetails) && $remarkDetails != null)
        {
            if($remarkDetails->assigned_from == $user_desig_code && $remarkDetails->remark_status == null)
            {
                if($esc_remark == null || $esc_remark == '')
                {
                    $response['responseType'] = 1;
                    return $response;
                }

                $tablename = "escalation_cases_remark_status";
                $dataUpdate = array('remark_status' => 'Y','escalation_remark' => $esc_remark);
                $where = array('case_no' => $case_no ,'assigned_from' => $user_desig_code);
                $updateESCStatus = $this->TransactionModel->update_multiple_condition($tablename, $where, $dataUpdate);
                if($updateESCStatus <= 0){
                    $response['responseType'] = 1;
                    return $response;
                }

            }
        }
        return $response;   
    }

    public function blockEscalationForQueryCase($case_no)
    {
        $executionDate = date('Y-m-d');
        $finalStatus = 'F';
        $escalationUpdateStatus = $this->escalationMatrixBlock($case_no, $executionDate,$finalStatus);
        return $escalationUpdateStatus;
    }

    public function escalationMatrixBlock($case_no, $executionDate,$finalStatus)
    {
    
        $response = array('responseType' => 2,'msg'=>null);
        $where = array(
            'case_no' => $case_no
        );
        $updateDatesArray = array(
            'status' => $finalStatus,
            'final_completion_date' => $executionDate,
        );
        $updateStatus22 = $this->db->update('escalation_details', $updateDatesArray, $where);
        log_message("error","#ESCQUERY=======".$case_no);
        if ($this->db->affected_rows() <= 0) {
            $response['responseType'] = 1;
            $response['msg'] = '#ERRESCLATION787777 : Updation failed on Escalation row not found';
            return $response;
        }
        $serviceResponse = $this->updateServiceWiseTableForBlock($case_no);
        if($serviceResponse == 'n')
        {
            $response['responseType'] = 1;
            $response['msg'] = '#ERRESCLATION787778 : Updation failed on service wise table';
            return $response;
        }
        return $response;
    }

    public function escalationMatrixBlockAfterReject($case_no, $executionDate,$finalStatus)
    {
    
        $response = array('responseType' => 2,'msg'=>null);
        $where = array(
            'case_no' => $case_no
        );
        $updateDatesArray = array(
            'status' => $finalStatus,
            'final_completion_date' => $executionDate,
        );
        $updateStatus22 = $this->db->update('escalation_details', $updateDatesArray, $where);
        log_message("error","#ESCQUERYREJECT=======".$case_no);
        if ($this->db->affected_rows() <= 0) {
            $response['responseType'] = 1;
            $response['msg'] = '#ERRESCLATIONREJECT787777 : Updation failed on Escalation row not found';
            return $response;
        }
        return $response;
    }

    public function updateServiceWiseTableForBlock($case_no)
    {
        // get service name
        $service_type = $this->getServiceNameForBlock($case_no);

        //update service wise table
        $table = $this->getTableNameByServiceTypeForBlock($service_type);
        if($table == 'misc_case_basic')
        {
            $case_no_val = ' misc_case_no ';
        }
        else
        {
            $case_no_val = ' case_no ';
        }

        // update service table
        $query = $this->db->query("UPDATE $table SET es_flag=? WHERE $case_no_val=?", array(0, $case_no));
        if($this->db->affected_rows() != 1)
        {
          return 'n';
        }
        return 'y';
    }

    // explode case name from case no
  public function getServiceNameForBlock($case_no)
  {
    $get_case_no = explode('/', $case_no);
    return $get_type = $get_case_no[4];
  }


  public function getTableNameByServiceTypeForBlock($service_type)
  {
    $table = '';
    if($service_type == OMUT || $service_type == OPART || $service_type == CONV_SERV)
    {
      $table = 'petition_basic';
    }
    else if($service_type == FMUT || $service_type == FPART)
    {
      $table = 'field_mut_basic';
    }
    else if($service_type == ALLOT_SERV)
    {
      $table = 'allotment_cert_basic';
    }
    else if($service_type == RECLASS_SERV)
    {
      $table = 't_reclassification';
    }
    else if($service_type == NCAN_SERV || $service_type == MIND_SERV || $service_type == MINC_SERV)
    {
      $table = 'misc_case_basic';
    }
    else if($service_type == LEGACY_SERV || $service_type == ANCOR_SERV || $service_type == MCOR_SERV)
    {
      $table = 't_legacyupdation';
    }

    return $table;
  }

  public function calculateRemainingTime($case_no,$desig_code)
  {
    if(ESCALATION_ALLOW_TIME == 1)
    {
        $curr_date = date('Y-m-d H:i:s');
    }
    else
    {
        $curr_date =  date('Y-m-d H:i:s');   
    }
    $row = $this->getEscalatedRowDetailsCaseNo($case_no);
    if($desig_code == 'AST')
    {
        
        $assignedDate = $row->assigned_other_es_date;
    }
    else
    {
        $assignedDate = $row->escalated_date;
    }
    $remainingTime = $this->dateDiff($assignedDate,$curr_date);
    return $remainingTime;
  }

    public function blockEscalationForRejectCase($case_no)
    {
        $executionDate = date('Y-m-d');
        $finalStatus = 'F';
        $escalationUpdateStatus = $this->escalationMatrixBlockAfterReject($case_no, $executionDate,$finalStatus);
        return $escalationUpdateStatus;
    }


   
    public function getHolidayCountDetails($registerd_on, $curr_date)
    {
        $sql = "Select count(*) as tot_time from holiday_details where holiday_date between ? and ? ";
        $matrix = $this->db->query($sql, array($registerd_on, $curr_date))->row();
        if (isset($matrix) && !empty($matrix) && $matrix != null) {
            return $matrix->tot_time;
        } else {
            return 0;
        }
    }


    // check if next date of hearing by co is less than escaation date
    public function checkHearingDate($nextHearingDate, $caseNo, $table)
    {
      $json = array();
      // get es flag status to check if falls under escalation
      $es_flag = $this->db->query("SELECT es_flag FROM $table WHERE case_no=? AND out_of_esc != ?", 
                  array($caseNo, 1))->row()->es_flag;

      if($es_flag == 1 && ESCALATION_ENABLE == 1)
      {
        // get escalation date from escalation_details table
        $esDetails = $this->db->query("SELECT registerd_on, total_days, escalated_date,service_code 
                      FROM escalation_details WHERE case_no=?", array($caseNo))->row();

        $newDate = str_replace('/','-',$nextHearingDate);
        $next  = date('Y-m-d', strtotime($newDate));
        $regOn = date('Y-m-d', strtotime($esDetails->registerd_on));
        $getHolidayCount = $this->getHolidayCountDetails($regOn,$next);

        // get the difference between hearing date and registered on date
        $daysDiff = $this->dateDiff($next, $regOn);
        $daysDiff = (int) $daysDiff - (int) $getHolidayCount;

        if($daysDiff >= 31)
        {
          return $json = [
            'response' => 1,
            'message'  => "#WARNING14233: The case was registered on $regOn, and the next hearing date selected as $next. The difference between the two dates is $daysDiff, which exceeds the total limit of $totalDays for the case no $caseNo !!!!",
          ];
        }
        return $json = [ 'response' => 2, ];
      }
      else
      {
        return $json = [ 'response' => 2, ];
      }
    }

    public function escalationCORevertToLMNCOR($service_code,$executionDate, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code, $mouza_pargona_code, $lot_no, $allocation_days)
    {

        // $executionDate = date('Y-m-d');
        $assigned_to = $this->getPendingOfficerLM($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
        $hearing_date = null;
        $user_type = 'CO';
        $service_code = "6";
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'LM';
        $assigned_to_other_type = null;
        $finalStatus = null;
        $assigned_to_other = null;
        $task = json_decode(NCOR);
        $taskid = $task[4]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = null;
        $assignment_type_other = $assignment_type_list[3]->CODE;
        if ($allocation_days != null) {
            $updateExtraDaysAgainstPetitionNo = $this->updateExtraDays($case_no, $allocation_days);
        }
        $escalationUpdateStatus = $this->escalationMatrixUpdateNameCorr($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $hearing_date, $taskid, $assignment_type, $allocation_days);
        return $escalationUpdateStatus;

    }

    public function escalationADCRevertCoNCOR($executionDate, $allocation_days, $dist_code, $subdiv_code, $cir_code, $case_no, $user_code)
    {
        $assigned_to = $this->getPendingOfficer($dist_code, $subdiv_code, $cir_code, 'CO');
        $hearing_date = null;
        $user_type = 'ADC';
        $service_code = '6';
        $assigned_to_code = $assigned_to->user_code;
        $assigned_user_type = 'CO';
        $assigned_to_other_type = null;
        $finalStatus = null;
        $assigned_to_other = null;
        $task = json_decode(NCOR);
        $taskid = $task[6]->CODE;
        $assignment_type_list = json_decode(ASSIGNMENT_TYPE);
        $assignment_type = null;
        $assignment_type_other = $assignment_type_list[3]->CODE;
        if ($allocation_days != null) {
            $updateExtraDaysAgainstPetitionNo = $this->updateExtraDaysADCCO($case_no, $allocation_days);
        }
        $escalationUpdateStatus = $this->escalationMatrixUpdateNameCorr($case_no, $executionDate, $user_code, $user_type, $service_code, $assigned_to_code, $assigned_user_type, $finalStatus, $hearing_date, $taskid, $assignment_type, $allocation_days);
        return $escalationUpdateStatus;
    }

    public function escalationUpdateTimeFrame($executionDate,$dist_code,$case_no,$user_code,$user_desig_code,$service_name)
    {

        $response = array('responseType' => 2,'msg' => null);
        if(($user_desig_code == 'DC' || $user_desig_code == 'ADC') && ($service_name == 'ACPP' || $service_name == 'RECLASS'))
        {
            $curr_date = date('Y-m-d H:i:s');
            $escRow = $this->getEscalatedRowDetailsBasic($case_no);
            if($escRow->escalated_date < $curr_date)
            {
                $daysDiff = $this->dateDiff($curr_date, $escRow->escalated_date);
                $total_days = (int) $escRow->total_days +  (int) $daysDiff;
                $dc_target_days = (int) $escRow->dc_target_days +  (int) $daysDiff;
                $newEscalatedDate = $this->getEscalatedDateNew($daysDiff, $escRow->escalated_date);
                $updateTimeframe = array(
                    'total_days'     => $total_days,
                    'dc_target_days' => $dc_target_days,
                    'escalated_date' => $newEscalatedDate,
                );
                $where = array('case_no' => $case_no);
                $updateStatus = $this->db->update('escalation_details', $updateTimeframe, $where);
                if($this->db->affected_rows() != 1)
                {
                    $response = array('responseType' => 1,'msg' => 'Update Failed');
                    return $response;
                    
                }
                return $response;
            }
            else
            {
                return $response;
            }
        }

        if($user_desig_code == 'ADC' && $service_name == 'NCOR')
        {
            $escRow = $this->getEscalatedRowDetailsBasic($case_no);    
            $resOutEsc = $this->autoOutOfEscalation($escRow);
            if($resOutEsc['responseType'] == 4)
            {
                return $response;
            }
            else if($resOutEsc['responseType'] == 3)
            {
                return $response;
            }
            else
            {
                $curr_date = date('Y-m-d H:i:s');

                if($escRow->escalated_date < $curr_date)
                {
                    $daysDiff = $this->dateDiff($curr_date, $escRow->escalated_date);
                    $total_days = (int) $escRow->total_days +  (int) $daysDiff;
                    $adc_target_days = (int) $escRow->adc_target_days +  (int) $daysDiff;
                    $newEscalatedDate = $this->getEscalatedDateNew($daysDiff, $escRow->escalated_date);
                    $updateTimeframe = array(
                        'total_days'     => $total_days,
                        'adc_target_days' => $adc_target_days,
                        'escalated_date' => $newEscalatedDate,
                    );
                    $where = array('case_no' => $case_no);
                    $updateStatus = $this->db->update('escalation_details', $updateTimeframe, $where);

                    if($this->db->affected_rows() != 1)
                    {
                        $response = array('responseType' => 1,'msg' => 'Update Failed');
                        return $response;
                    }
                    return $response;
                }
                else
                {
                    return $response;
                }
            }
           
        }
        if($user_desig_code == 'CO' && ($service_name == 'OMUT' || $service_name == 'FMUT' || $service_name == 'OPART' || $service_name == 'FPART'))
        {
            $escRow = $this->getEscalatedRowDetailsBasic($case_no);    
            $resOutEsc = $this->autoOutOfEscalation($escRow);
            if($resOutEsc['responseType'] == 4)
            {
                return $response;
            }
            else if($resOutEsc['responseType'] == 3)
            {
                return $response;
            }
            else
            {
                $curr_date = date('Y-m-d H:i:s');

                if($escRow->escalated_date < $curr_date)
                {
                    $daysDiff = $this->dateDiff($curr_date, $escRow->escalated_date);
                    $total_days = (int) $escRow->total_days +  (int) $daysDiff;
                    $co_target_days = (int) $escRow->co_target_days +  (int) $daysDiff;
                    $newEscalatedDate = $this->getEscalatedDateNew($daysDiff, $escRow->escalated_date);
                    $updateTimeframe = array(
                        'total_days'     => $total_days,
                        'co_target_days' => $co_target_days,
                        'escalated_date' => $newEscalatedDate,
                    );
                    $where = array('case_no' => $case_no);
                    $updateStatus = $this->db->update('escalation_details', $updateTimeframe, $where);

                    if($this->db->affected_rows() != 1)
                    {
                        $response = array('responseType' => 1,'msg' => 'Update Failed');
                        return $response;
                    }
                    return $response;
                }
                else
                {
                    return $response;
                }
            }
           
        }
        
    }

    public function autoOutOfEscalation($escRow)
    {
        $response = array('responseType' => 2,'msg' => null);
        $curr_date = date('Y-m-d H:i:s');
        $currDate     = date('Y-m-d');
        $registerd_on = date('Y-m-d',strtotime($escRow->registerd_on));
        $total_diff = $this->dateDiff($currDate,$registerd_on);
        $holidayDiff = $this->getHolidayCountDetails($registerd_on, $currDate);

        $exactTime = (int) $total_diff - (int) $holidayDiff;
        ////for Name Correction cases only///////////
        if($escRow->service_code == '6')
        {
            if($exactTime > 10)
            {
                ///////out of escalation started////////
               
                $update = $this->db->query("UPDATE misc_case_basic SET es_flag=?,is_escalated=?,out_of_esc=? WHERE misc_case_no=?",array(1,0,1, $escRow->case_no));
                if($this->db->affected_rows() != 1)
                {
                    $response['responseType'] = 3;
                    return $response;
                }


                $updateEsc = $this->db->query("UPDATE escalation_details SET final_completion_date=?,
                              out_of_esc_status=?, updated_date=?, status=? WHERE case_no=?",
                                array(date('Y-m-d'), 'y', date('Y-m-d H:i:s'), 'F', $escRow->case_no));

                if($this->db->affected_rows() != 1)
                {
                    $response['responseType'] = 3;
                    return $response;
                }
                $response['responseType'] = 4;
                return $response;
                
            }
            
        }
        if($escRow->service_code == '1') // OMUT, FMUT
        {
            $service_type = $this->getServiceNameForBlock($escRow->case_no);
            $total_time = $service_type == 'OMUT' ? 60 : 30;
            if($exactTime > $total_time)
            {
                ///////out of escalation started////////
                if($service_type == 'OMUT')
                {
                    $update = $this->db->query("UPDATE petition_basic SET es_flag=?,is_escalated=?,out_of_esc=? WHERE case_no=?",array(1,0,1, $escRow->case_no));
                }
                else if($service_type == 'FMUT')
                {
                    $update = $this->db->query("UPDATE field_mut_basic SET es_flag=?,is_escalated=?,out_of_esc=? WHERE case_no=?",array(1,0,1, $escRow->case_no));
                }               
                
                if($this->db->affected_rows() != 1)
                {
                    $response['responseType'] = 3;
                    return $response;
                }


                $updateEsc = $this->db->query("UPDATE escalation_details SET final_completion_date=?,
                              out_of_esc_status=?, updated_date=?, status=? WHERE case_no=?",
                                array(date('Y-m-d'), 'y', date('Y-m-d H:i:s'), 'F', $escRow->case_no));

                if($this->db->affected_rows() != 1)
                {
                    $response['responseType'] = 3;
                    return $response;
                }
                $response['responseType'] = 4;
                return $response;
                
            }
            
        }

        if($escRow->service_code == '2') // OMUTD, FMUTD
        {
            $service_type = $this->getServiceNameForBlock($escRow->case_no);
            $total_time = $service_type == 'OMUTD' ? 60 : 30;
            if($exactTime > $total_time)
            {
                ///////out of escalation started////////
                if($service_type == 'OMUTD')
                {
                    $update = $this->db->query("UPDATE petition_basic SET es_flag=?,is_escalated=?,out_of_esc=? WHERE case_no=?",array(1,0,1, $escRow->case_no));
                }
                else if($service_type == 'FMUTD ')
                {
                    $update = $this->db->query("UPDATE field_mut_basic SET es_flag=?,is_escalated=?,out_of_esc=? WHERE case_no=?",array(1,0,1, $escRow->case_no));
                }               
                
                if($this->db->affected_rows() != 1)
                {
                    $response['responseType'] = 3;
                    return $response;
                }


                $updateEsc = $this->db->query("UPDATE escalation_details SET final_completion_date=?,
                              out_of_esc_status=?, updated_date=?, status=? WHERE case_no=?",
                                array(date('Y-m-d'), 'y', date('Y-m-d H:i:s'), 'F', $escRow->case_no));

                if($this->db->affected_rows() != 1)
                {
                    $response['responseType'] = 3;
                    return $response;
                }
                $response['responseType'] = 4;
                return $response;
                
            }
            
        }
        if($escRow->service_code == '3') // OPART, FPART
        {
            $service_type = $this->getServiceNameForBlock($escRow->case_no);
            $total_time = $service_type == 'OPART' ? 60 : 50;
            if($exactTime > $total_time)
            {
                ///////out of escalation started////////
                if($service_type == 'OPART')
                {
                    $update = $this->db->query("UPDATE petition_basic SET es_flag=?,is_escalated=?,out_of_esc=? WHERE case_no=?",array(1,0,1, $escRow->case_no));
                }
                else if($service_type == 'FPART')
                {
                    $update = $this->db->query("UPDATE field_mut_basic SET es_flag=?,is_escalated=?,out_of_esc=? WHERE case_no=?",array(1,0,1, $escRow->case_no));
                }               
                
                if($this->db->affected_rows() != 1)
                {
                    $response['responseType'] = 3;
                    return $response;
                }


                $updateEsc = $this->db->query("UPDATE escalation_details SET final_completion_date=?,
                              out_of_esc_status=?, updated_date=?, status=? WHERE case_no=?",
                                array(date('Y-m-d'), 'y', date('Y-m-d H:i:s'), 'F', $escRow->case_no));

                if($this->db->affected_rows() != 1)
                {
                    $response['responseType'] = 3;
                    return $response;
                }
                $response['responseType'] = 4;
                return $response;
                
            }
            
        }


        return $response;
    }

    public function outOfEscServiceWise($case_no,$serviceType,$user_desig_code)
    {
        $response = array('responseType'=>2);
        if(($user_desig_code == 'CO' || $user_desig_code == 'LM') && $serviceType == 'NCOR')
        {
            $escRow = $this->getEscalatedRowDetailsBasic($case_no);   
            if(empty($escRow) || $escRow == null)
            {
                $response['responseType'] = 1;
                return $response;
            } 
            $resOutEsc = $this->autoOutOfEscalation($escRow);
            log_message('error','#outOfEscServiceWise======'.$case_no.'===='.json_encode($resOutEsc));
            if($resOutEsc['responseType'] == 4 || $resOutEsc['responseType'] == 2)
            {
                return $response;
            }
            else
            {
                $response['responseType'] = 1;
                return $response;
            }
        }
    }
    

}
