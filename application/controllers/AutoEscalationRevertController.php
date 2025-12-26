<?php
class AutoEscalationRevertController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->model('basundhara/basundharamodel');
        $this->load->model('AutoEscalationRevertModel');  
        $this->load->model('Escalationmodel');
        $this->dbswitch();
    }

    public function dbswitch()
    {       
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

    // get target days
    public function getTargetDaysByUser($userCode, $case_no)
    {
        $res = $this->Escalationmodel->getEscalatedRowDetailsBasic($case_no);
        if($userCode == 'DEPT')
        {
            $target_days = $res->dept_target_days;
        }
        else if($userCode == 'DC')
        {
            $target_days = $res->dc_target_days;
        }
        else if($userCode == 'ADC')
        {
            $target_days = $res->adc_target_days;
        }
        else if($userCode == 'BO')
        {
            $target_days = $res->bo_target_days;
        }
        else if($userCode == 'CO')
        {
            $target_days = $res->co_target_days;
        }
        else if($userCode == 'SK')
        {
            $target_days = $res->sk_target_days;
        }
        else if($userCode == 'AST')
        {
            $target_days = $res->da_target_days;
        }
        else if($userCode == 'LM')
        {
            $target_days = $res->lm_target_days;
        }
        else if($userCode == 'SRO')
        {
            $target_days = $res->sro_target_days;
        }
        return $target_days;
    }

    // get completed days
    public function getCompletedDaysByUser($userCode, $case_no)
    {
        $res = $this->Escalationmodel->getEscalatedRowDetailsBasic($case_no);
        if($userCode == 'DEPT')
        {
            $completed_days = $res->dept_completed_days;
        }
        else if($userCode == 'DC')
        {
            $completed_days = $res->dc_completed_days;
        }
        else if($userCode == 'ADC')
        {
            $completed_days = $res->adc_completed_days;
        }
        else if($userCode == 'BO')
        {
            $completed_days = $res->bo_completed_days;
        }
        else if($userCode == 'CO')
        {
            $completed_days = $res->co_completed_days;
        }
        else if($userCode == 'SK')
        {
            $completed_days = $res->sk_completed_days;
        }
        else if($userCode == 'AST')
        {
            $completed_days = $res->da_completed_days;
        }
        else if($userCode == 'LM')
        {
            $completed_days = $res->lm_completed_days;
        }
        else if($userCode == 'SRO')
        {
            $completed_days = $res->sro_completed_days;
        }
        return $completed_days;
    }


    public function revertReportToAst()
    {        
        $case_no  = $this->utilityclass->decryptJwtCase($this->input->get('case_no'));
        $fromUser = $this->utilityclass->decryptJwtCase($this->input->get('fromUser'));

        // get previously completed days
        $previousCompletedDays = $this->getCompletedDaysByUser($fromUser, $case_no);
        $targetDays            = $this->getTargetDaysByUser($fromUser, $case_no);

        if(ESCALATION_ALLOW_TIME == 1)
        {
            $currDate     = date('Y-m-d H:i:s');
            $escalateDate = $this->getEscalatedDateForAst($case_no);
            $diff = $this->Escalationmodel->dateDiff($currDate,$escalateDate);
            $diff = (int)$diff;
        }
        else
        {
            $currDate     = date('Y-m-d');
            $escalateDate = date('Y-m-d', strtotime($this->getEscalatedDateForAst($case_no)));
            $diff = $this->Escalationmodel->dateDiff($currDate,$escalateDate);
        }
        $rem = $this->Escalationmodel->getRemainingDays($previousCompletedDays,$targetDays);

        $remainingDays = $rem - $diff;

        $data['remainingDays'] = $remainingDays;
        $data['_view'] = 'EscalationRevertView/escalationrevertback_ast';
        $this->load->view('layouts/main',$data);
    }

    public function revertReport()
    {        
        $case_no  = $this->utilityclass->decryptJwtCase($this->input->get('case_no'));
        $fromUser = $this->utilityclass->decryptJwtCase($this->input->get('fromUser'));

        $redirectUrl = base_url().'index.php/Home/index';

        // get previously completed days
        $previousCompletedDays = $this->getCompletedDaysByUser($fromUser, $case_no);
        $targetDays            = $this->getTargetDaysByUser($fromUser, $case_no);
        $escRow                = $this->Escalationmodel->getEscalatedRowDetailsBasic($case_no);

        $service_array         = array('1','2','3','4','5','6'); // mutation. partition, allotment, reclassification, name correction

        if(ESCALATION_ALLOW_TIME == 1)
        {
            $currDate     = date('Y-m-d H:i:s');
            $escalateDate = $this->getEscalatedDate($case_no);
            $diff = $this->Escalationmodel->dateDiff($currDate,$escalateDate);
            $diff = (int)$diff;
        }
        else
        {
            if(in_array($escRow->service_code, $service_array) && $fromUser=='CO') // out of escalation
            {
                $executionDate   = date('Y-m-d H-i-s');
                $user_code       = $escRow->assigned_to;
                $user_desig_code = $fromUser;

                $currDate        = date('Y-m-d');
                $registerd_on    = date('Y-m-d',strtotime($escRow->registerd_on));
                $total_diff      = $this->Escalationmodel->dateDiff($currDate,$registerd_on);
                $holidayDiff     = $this->Escalationmodel->getHolidayCountDetails($registerd_on, $currDate);
                $exactTime       = (int) $total_diff - (int) $holidayDiff;

                // var_dump($exactTime); die;

                if($escRow->service_code == '1' || $escRow->service_code == '2') // OMUT, FMUT
                {

                    $service_type = $this->Escalationmodel->getServiceNameForBlock($escRow->case_no);
                    $total_time = ($service_type == 'OMUT' || $service_type == 'OMUTD') ? 60 : 30;

                    // var_dump($exactTime .'>'. $total_time); die;

                    if($exactTime > $total_time)
                    {
                        // echo "sdfghjk"; die;
                        $this->db->trans_begin();
                        ///////out of escalation started////////
                        if($service_type == 'OMUT' || $service_type == 'OMUTD')
                        {
                            $update = $this->db->query("UPDATE petition_basic SET es_flag=?,is_escalated=?,out_of_esc=? WHERE case_no=?",array(1,0,1, $escRow->case_no));

                            // echo $this->db->last_query(); die; 
                            $table = 'petition_basic';
                        }
                        else if($service_type == 'FMUT' || $service_type == 'FMUTD')
                        {
                            $update = $this->db->query("UPDATE field_mut_basic SET es_flag=?,is_escalated=?,out_of_esc=? WHERE case_no=?",array(1,0,1, $escRow->case_no));
                            $table = 'field_mut_basic';
                        }     
                        
                        if($this->db->affected_rows() != 1)
                        {
                            $this->db->trans_rollback();
                            log_message("error", "ERR251_Updation_failed_in_$table: ".$this->db->last_query());
                            $this->session->set_flashdata('message', '#ERROR250 : Something went wrong...kindly contact system administrator');
                            redirect($redirectUrl);
                        }

                        $updateEsc = $this->db->query("UPDATE escalation_details SET final_completion_date=?,
                                      out_of_esc_status=?, updated_date=?, status=? WHERE case_no=?",
                                        array(date('Y-m-d'), 'y', date('Y-m-d H:i:s'), 'F', $escRow->case_no));

                        if($this->db->affected_rows() != 1)
                        {
                            $this->db->trans_rollback();
                            log_message("error", "ERR264_Updation_failed_in_escalation_details: ".$this->db->last_query());
                            $this->session->set_flashdata('message', '#ERROR264 : Something went wrong...kindly contact system administrator');
                            redirect($redirectUrl);
                        } 

                        if($this->db->trans_status() == FALSE)
                        {
                            $this->db->trans_rollback();
                            log_message("error", "ERR264_Updation_failed_in_escalation_details: ".$this->db->last_query());
                            $this->session->set_flashdata('message', '#ERROR264 : Something went wrong...kindly contact system administrator');
                            redirect($redirectUrl);   
                        }
                        else{
                            $this->db->trans_commit();
                            redirect($redirectUrl);
                        }                                  
                    }                    
                }

                if($escRow->service_code == '3') // OPART, FPART
                {
                    $service_type = $this->Escalationmodel->getServiceNameForBlock($escRow->case_no);
                    $total_time = $service_type == 'OPART' ? 60 : 50;
                    if($exactTime > $total_time)
                    {
                        $this->db->trans_begin();
                        ///////out of escalation started////////
                        if($service_type == 'OPART')
                        {
                            $update = $this->db->query("UPDATE petition_basic SET es_flag=?,is_escalated=?,out_of_esc=? WHERE case_no=?",array(1,0,1, $escRow->case_no));
                            $table = 'petition_basic';
                        }
                        else if($service_type == 'FPART')
                        {
                            $update = $this->db->query("UPDATE field_mut_basic SET es_flag=?,is_escalated=?,out_of_esc=? WHERE case_no=?",array(1,0,1, $escRow->case_no));
                            $table = 'field_mut_basic';
                        }               
                        
                        if($this->db->affected_rows() != 1)
                        {
                            $this->db->trans_rollback();
                            log_message("error", "ERR330_Updation_failed_in_$table: ".$this->db->last_query());
                            $this->session->set_flashdata('message', '#ERROR330 : Something went wrong...kindly contact system administrator');
                            redirect($redirectUrl);
                        }


                        $updateEsc = $this->db->query("UPDATE escalation_details SET final_completion_date=?,
                                      out_of_esc_status=?, updated_date=?, status=? WHERE case_no=?",
                                        array(date('Y-m-d'), 'y', date('Y-m-d H:i:s'), 'F', $escRow->case_no));

                        if($this->db->affected_rows() != 1)
                        {
                            $this->db->trans_rollback();
                            log_message("error", "ERR342_Updation_failed_in_escalation_details: ".$this->db->last_query());
                            $this->session->set_flashdata('message', '#ERROR342 : Something went wrong...kindly contact system administrator');
                            redirect($redirectUrl);
                        }
                        
                        if($this->db->trans_status() == FALSE)
                        {
                            $this->db->trans_rollback();
                            log_message("error", "ERR264_Updation_failed_in_escalation_details: ".$this->db->last_query());
                            $this->session->set_flashdata('message', '#ERROR264 : Something went wrong...kindly contact system administrator');
                            redirect($redirectUrl);   
                        }
                        else{
                            $this->db->trans_commit();
                            redirect($redirectUrl);
                        } 
                        
                    }                    
                }

                if($escRow->service_code == '6') // MiNC
                {
                    $registerd_on = date('Y-m-d',strtotime($escRow->registerd_on));
                    $total_diff = $this->Escalationmodel->dateDiff($currDate,$registerd_on);
                    $holidayDiff = $this->Escalationmodel->getHolidayCountDetails($registerd_on, $currDate);

                    $exactTime = (int) $total_diff - (int) $holidayDiff;

                    if($exactTime > 10)
                    {
                        ///////out of escalation started////////
                        $this->db->trans_begin();
                        $update = $this->db->query("UPDATE misc_case_basic SET es_flag=?,is_escalated=?,out_of_esc=? WHERE misc_case_no=?",array(1,0,1, $case_no));
                        if($this->db->affected_rows() != 1)
                        {
                            $this->db->trans_rollback();
                            log_message("error", "#ERR23591_UPDATION_FAILED23654: ".json_encode($this->db->last_query()));
                            $this->session->set_flashdata('message', '#ERROR233 : Something went wrong...kindly contact system administrator');
                            $redirectUrl    = base_url()."index.php/Home/index";
                            redirect($redirectUrl);
                        }

                        $updateEsc = $this->db->query("UPDATE escalation_details SET final_completion_date=?,
                                      out_of_esc_status=?, updated_date=?, status=? WHERE case_no=?",
                                        array(date('Y-m-d'), 'y', date('Y-m-d H:i:s'), 'F', $case_no));
                        if($this->db->affected_rows() != 1)
                        {
                            $this->db->trans_rollback();
                            log_message("error", "#ERR23591_UPDATION_FAILED23654: ".json_encode($this->db->last_query()));
                            $this->session->set_flashdata('message', '#ERROR243 : Something went wrong...kindly contact system administrator');
                            $redirectUrl    = base_url()."index.php/Home/index";
                            redirect($redirectUrl);
                        }
                        $this->db->trans_commit();
                        $redirectUrl    = base_url()."index.php/Home/index";
                        $this->session->set_flashdata('message', 'Successfully reverted...to LRA');
                        redirect($redirectUrl);
                    }                    
                }

                if($escRow->service_code == '4') // RECLASS
                {
                    $service_type = $this->Escalationmodel->getServiceNameForBlock($escRow->case_no);
                    $total_time = 45;

                    if($exactTime > $total_time)
                    {
                        $this->db->trans_begin();

                        $update = $this->db->query("UPDATE t_reclassification SET es_flag=?, is_escalated=?, out_of_esc=? WHERE case_no=?",array(1, 0, 1, $escRow->case_no));
                        $table = 't_reclassification';            
                        
                        if($this->db->affected_rows() != 1)
                        {
                            $this->db->trans_rollback();
                            log_message("error", "ERR409_Updation_failed_in_$table: ".$this->db->last_query());
                            $this->session->set_flashdata('message', '#ERROR409 : Something went wrong...kindly contact system administrator');
                            redirect($redirectUrl);
                        }

                        $updateEsc = $this->db->query("UPDATE escalation_details SET final_completion_date=?,
                                      out_of_esc_status=?, updated_date=?, status=? WHERE case_no=?",
                                        array(date('Y-m-d'), 'y', date('Y-m-d H:i:s'), 'F', $escRow->case_no));

                        if($this->db->affected_rows() != 1)
                        {
                            $this->db->trans_rollback();
                            log_message("error", "ERR421_Updation_failed_in_escalation_details: ".$this->db->last_query());
                            $this->session->set_flashdata('message', '#ERROR421 : Something went wrong...kindly contact system administrator');
                            redirect($redirectUrl);
                        }
                        
                        if($this->db->trans_status() == FALSE)
                        {
                            $this->db->trans_rollback();
                            log_message("error", "ERR430_Updation_failed_in_escalation_details: ".$this->db->last_query());
                            $this->session->set_flashdata('message', '#ERROR430 : Something went wrong...kindly contact system administrator');
                            redirect($redirectUrl);   
                        }
                        else{
                            $this->db->trans_commit();
                            redirect($redirectUrl);
                        }
                    }                    
                }

                if($escRow->service_code == '5') // ALLOTMENT
                {
                    $service_type = $this->Escalationmodel->getServiceNameForBlock($escRow->case_no);
                    $total_time = 90;

                    if($exactTime > $total_time)
                    {
                        $this->db->trans_begin();

                        $update = $this->db->query("UPDATE allotment_cert_basic SET es_flag=?, is_escalated=?, out_of_esc=? 
                                        WHERE case_no=?",array(1, 0, 1, $escRow->case_no));
                        $table = 'allotment_cert_basic';            
                        
                        if($this->db->affected_rows() != 1)
                        {
                            $this->db->trans_rollback();
                            log_message("error", "ERR444_Updation_failed_in_$table: ".$this->db->last_query());
                            $this->session->set_flashdata('message', '#ERROR444 : Something went wrong...kindly contact system administrator');
                            redirect($redirectUrl);
                        }

                        $updateEsc = $this->db->query("UPDATE escalation_details SET final_completion_date=?,
                                      out_of_esc_status=?, updated_date=?, status=? WHERE case_no=?",
                                        array(date('Y-m-d'), 'y', date('Y-m-d H:i:s'), 'F', $escRow->case_no));

                        if($this->db->affected_rows() != 1)
                        {
                            $this->db->trans_rollback();
                            log_message("error", "ERR456_Updation_failed_in_escalation_details: ".$this->db->last_query());
                            $this->session->set_flashdata('message', '#ERROR456 : Something went wrong...kindly contact system administrator');
                            redirect($redirectUrl);
                        }
                        
                        if($this->db->trans_status() == FALSE)
                        {
                            $this->db->trans_rollback();
                            log_message("error", "ERR464_Updation_failed_in_escalation_details: ".$this->db->last_query());
                            $this->session->set_flashdata('message', '#ERROR464 : Something went wrong...kindly contact system administrator');
                            redirect($redirectUrl);   
                        }
                        else{
                            $this->db->trans_commit();
                            redirect($redirectUrl);
                        }
                    }                    
                }

                // $registerd_on = date('Y-m-d',strtotime($escRow->registerd_on));
                // $total_diff = $this->Escalationmodel->dateDiff($currDate,$registerd_on);
                // $holidayDiff = $this->Escalationmodel->getHolidayCountDetails($registerd_on, $currDate);

                // $exactTime = (int) $total_diff - (int) $holidayDiff;
            }           
        }

        $registerd_on = date('Y-m-d',strtotime($escRow->registerd_on));
        $total_diff = $this->Escalationmodel->dateDiff($currDate, $registerd_on);
        $holidayDiff = $this->Escalationmodel->getHolidayCountDetails($registerd_on, $currDate);
        $exactTime = (int) $total_diff - (int) $holidayDiff;

        // echo "dfghj"; die;

        // mutation. partition, allotment, reclassification, name correction
        if(in_array($escRow->service_code, $service_array) && $fromUser=='CO') 
        {
            // echo "sdfghj"; die;
            $escalated_date    = date('Y-m-d',strtotime($escRow->escalated_date));
            // check if escalated days has surpassed the current date
            $days_diff_esc_curr = $this->Escalationmodel->dateDiff($escalated_date, $currDate);

            // get service type to get total time frame from escalation matrix
            $service_type = $this->Escalationmodel->getServiceNameForBlock($escRow->case_no);

            $stype = ($service_type == 'MiNC') ? 'NCOR' : $service_type;

            // get total timeline(esc + deesc) from escalation matrix by category
            $serviceTotalTime = $this->db->query("SELECT SUM(total_timeline)  FROM escalation_matrix 
                                    WHERE category=?", array($stype))->row()->sum;

            // $rem = $this->Escalationmodel->getRemainingDays($previousCompletedDays,$targetDays);
            // $remainingDays = $rem - $exactTime;

            // echo "sdfghj"; die;

            if($days_diff_esc_curr < 0 && $exactTime < $serviceTotalTime)
            {
                // echo "dsfg";
                $adc_dc_service_array = array('4', '5', '6'); // reclass, allotment
                if(in_array($escRow->service_code, $adc_dc_service_array))
                {
                    // get remaining days at ADC / DC
                    $adcRemainingDays = (int) $escRow->adc_target_days - (int) $escRow->adc_completed_days;
                    $dcRemainingDays  = (int) $escRow->dc_target_days - (int) $escRow->dc_completed_days;

                    $exactTime        = $exactTime - ($adcRemainingDays+$dcRemainingDays);
                }

                $assigned_date    = date('Y-m-d',strtotime($escRow->assigned_date));
                $whenCoDoneRevert = $this->Escalationmodel->dateDiff($currDate, $assigned_date);

                // get days diff between total service time and exact time
                $days_diff_totservice_exacttime = $serviceTotalTime-$exactTime;
                $escRow                         = $this->Escalationmodel->getEscalatedRowDetailsBasic($case_no);
                $originalco_target_days         = $escRow->co_target_days;
                $originalco_completed_days      = $escRow->co_completed_days;
                $originalco_allocate_days       = $escRow->co_allocate_days;

                $originalco_target_days         = $originalco_target_days + $days_diff_totservice_exacttime + $whenCoDoneRevert;
                $originalco_completed_days      = $originalco_completed_days + $whenCoDoneRevert;
                $originalco_allocate_days       = $originalco_allocate_days + $days_diff_totservice_exacttime;
                $newEscalatedDate               = $this->Escalationmodel->getEscalatedDate($days_diff_totservice_exacttime);


                // assign this total days to CO to revert to other user(s)
                $updateDaysToCo = $this->db->query("UPDATE escalation_details SET escalated_date=?, 
                                    co_allocate_days=?, co_target_days=?, co_completed_days=? WHERE case_no=?",  
                                        array($newEscalatedDate, $originalco_allocate_days, $originalco_target_days, 
                                            $originalco_completed_days, $case_no));

                if($this->db->affected_rows() != 1)
                {
                    log_message("error", "ERR532_Updation_failed_in_escalation_details: ".$this->db->last_query());
                    $this->session->set_flashdata('message', "#ERROR532 : Something went wrong for case_no $case_no...Kindly contact system administrator");
                    redirect($redirectUrl);
                }
                $escRow = $this->Escalationmodel->getEscalatedRowDetailsBasic($case_no);
                $remainingDaysCoToRevert = $escRow->co_target_days - $escRow->co_completed_days;
                $data['remainingDays'] = $remainingDaysCoToRevert;
                $data['_view'] = 'EscalationRevertView/escalationrevertback';
                $this->load->view('layouts/main',$data);
            }
            else
            {
                // echo "sdfghj"; die;
                $escRow = $this->Escalationmodel->getEscalatedRowDetailsBasic($case_no);
                $remainingDaysCoToRevert = $escRow->co_target_days - $escRow->co_completed_days;
                // echo $remainingDaysCoToRevert; die;
                $currDate        = date('Y-m-d');
                $assigned_date    = date('Y-m-d',strtotime($escRow->assigned_date));

                $whenCoDoneRevert = $this->Escalationmodel->dateDiff($currDate, $assigned_date);
                $originalco_completed_days      = $escRow->co_completed_days;
                $originalco_completed_days      = $originalco_completed_days + $whenCoDoneRevert;

                if($originalco_completed_days < $escRow->co_target_days)
                {
                    // assign this total days to CO to revert to other user(s)
                    $updateDaysToCo = $this->db->query("UPDATE escalation_details SET co_completed_days=? WHERE case_no=?", array($originalco_completed_days, $case_no));
                }


                if($this->db->affected_rows() != 1)
                {
                    log_message("error", "ERR4201_Updation_failed_in_escalation_details: ".$this->db->last_query());
                    $this->session->set_flashdata('message', "#ERROR4201 : Something went wrong for case_no $case_no...Kindly contact system administrator");
                    redirect($redirectUrl);
                }
                $escRow = $this->Escalationmodel->getEscalatedRowDetailsBasic($case_no);
                $remainingDaysCoToRevert = $escRow->co_target_days - $escRow->co_completed_days;
                $data['remainingDays'] = $remainingDaysCoToRevert;
                $data['_view'] = 'EscalationRevertView/escalationrevertback';
                $this->load->view('layouts/main',$data);
            }            
        }
        else
        {
            $escRow = $this->Escalationmodel->getEscalatedRowDetailsBasic($case_no);
            $remainingDaysCoToRevert = $escRow->co_target_days - $escRow->co_completed_days;
            $data['remainingDays'] = $remainingDaysCoToRevert;




            $data['_view'] = 'EscalationRevertView/escalationrevertback';
            $this->load->view('layouts/main',$data);
        }
    }


    public function revertBackEscalationCases()
    {
        $allocate_day   = $this->input->post('allocate_day');
        $revert_remarks = $this->input->post('revert_remarks');
        $executionDate  = $this->input->post('executionDate');
        $case_no        = $this->input->post('case_no');
        $revert_to_user = $this->input->post('revert_to_user');
        $from_user      = $this->input->post('from_user');
        // $esc_env        = $this->input->post('esc_env');
        // $remainingDays  = $this->input->post('remainingDays');        
        $en_case_no     = $this->utilityclass->encryptJwtCase($case_no);
        $en_revert_user = $this->utilityclass->encryptJwtCase($revert_to_user);
        if($revert_to_user == 'AST')
        {
            $redirectUrl    = base_url()."index.php/AutoEscalationRevertController/revertReportToAst?case_no=".$en_case_no."&revert_to_user=".$en_revert_user."&fromUser=".$from_user;
        }
        else
        {
            $redirectUrl    = base_url()."index.php/AutoEscalationRevertController/revertReport?case_no=".$en_case_no."&revert_to_user=".$en_revert_user."&fromUser=".$from_user;
        }

        if($revert_remarks == null || $revert_remarks == '')
        {
            log_message('error', "Remark is empty for case no ".$case_no);
            $this->session->set_flashdata('required_message', '#ERROR246 : Remark is mandatory');
            redirect($redirectUrl);
        }
        if($allocate_day == null || $allocate_day == '' || $allocate_day < 0)
        {
            log_message('error', "Invalid allocation day entered for case no ".$case_no);
            $this->session->set_flashdata('required_message', '#ERROR252 : Invalid allocation day entered');
            redirect($redirectUrl);
        }

        if($revert_to_user == null || $revert_to_user == '')
        {
            log_message('error', "No appellate authority selected for case no ".$case_no);
            $this->session->set_flashdata('required_message', '#ERROR259 :  Please select appellate authority');
            redirect($redirectUrl);
        }

        

        // auto escalate the case to DC as deescalation started
        if($allocate_day < 0)
        {
            echo "Something went wrong : Escalation error=======";die;
            $status1 = $this->AutoEscalationRevertModel->autoEscalateToDcForRevertedDeEscalation($_POST);
        }

        // var_dump($revert_to_user); die;


        if($revert_to_user == 'AST')
        {
            $resp = $this->AutoEscalationRevertModel->revertEscalatedCasesForAssistant($_POST);
        }
        else
        {
            $resp = $this->AutoEscalationRevertModel->revertEscalatedCases($_POST);
        }
        
        $this->db->trans_begin();
        if($resp['responseType'] == 1)
        {
            $this->db->trans_rollback();
            log_message('error', $resp['message']." for case no $case_no");
            $this->session->set_flashdata('required_message', $resp['message']);
            redirect($redirectUrl);
        }
        else
        {
            $this->db->trans_commit();
            $this->session->set_flashdata('required_message', $resp['message']);
            redirect(base_url()."index.php/EscalatedListController/loadEscalatedViewPage?service=".$resp['service_type']);    
        }
    }


    ///////Revert Escalation to LM
    public function escalationRevertToLM($case_no,$rmk,$revert_back,$dist_code,$subdiv_code,$cir_code,$service_code)
    {

            $update=array(
                'is_dispose'=>'L',
            );
            $pen="LM";

            $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);

            if($basundharaExist)
            {

                if($service_code == SERVICE_FIELD_MUTATION)
                {
                    $this->revertByCoFMUT($case_no,$rmk,$update,$revert_back,$dist_code,$subdiv_code,$cir_code,$service_code);
                }

                // $this->basundharamodel->insertproceeding($case_no,$rmk,$update);
                // $this->db->where('case_no',$case_no);
                // $this->db->update('field_mut_basic',$update);

                // $query1 = $this->db->query("SELECT es_flag,mouza_pargona_code,lot_no FROM field_mut_basic WHERE case_no=?",array($case_no))->row();
                // $co_user_code = $this->session->userdata('user_code');
                // $executionDate = $this->input->post('executionDate');
                // if($query1->es_flag == 1 && ESCALATION_ENABLE == 1){
                //     $allocation_days = null;
                //     if($this->input->post('allocate_day') !=null){
                //         $allocation_days = $this->input->post('allocate_day');
                //     }

                //     $escalationUpdateStatus = $this->AutoEscalationRevertModel->escalationCORevertAuto($revert_back,$executionDate,$dist_code,$subdiv_code,$cir_code,$case_no,$co_user_code,$query1->mouza_pargona_code,$query1->lot_no,$allocation_days,$service_code);

                //     log_message("error", "#ESC002, transaction-error-STATUS======".$escalationUpdateStatus);

                //     if($escalationUpdateStatus == 0){

                //         log_message("error", "#ESC002, transaction-error in method 'COFieldMutation/revertBackLS' with case-no :". $case_no);
                //         $this->session->set_flashdata('message', "Something went wrong. Error Code(#ESC002)");
                //         redirect(base_url() . "index.php/home");
                //     }
                // }

                //////////////POST To basundhara/////////////////////
                $application_no=$basundharaExist;
                $rmk='Reverted back to ' . $pen;
                $status='M';
                $task='CO';
                $case=$case_no;
                $this->basundharamodel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                //////////////////

                $this->DashboardData($case_no,$pen,$rmk);
            }
            $this->session->set_flashdata('message',"Case have been Reverted back to " . $pen);
            redirect('/home');
    }



    public function revertByCoFMUT($case_no,$rmk,$update,$revert_back,$dist_code,$subdiv_code,$cir_code,$service_code)
    {
        $this->basundharamodel->insertproceeding($case_no,$rmk);
        $this->db->where('case_no',$case_no);
        $this->db->update('field_mut_basic',$update);

        $query1 = $this->db->query("SELECT es_flag,mouza_pargona_code,lot_no FROM field_mut_basic WHERE case_no=?",array($case_no))->row();
        $co_user_code = $this->session->userdata('user_code');
        $executionDate = $this->input->post('executionDate');
        if($query1->es_flag == 1 && ESCALATION_ENABLE == 1){
            $allocation_days = null;
            if($this->input->post('allocate_day') !=null){
                $allocation_days = $this->input->post('allocate_day');
            }

            $escalationUpdateStatus = $this->AutoEscalationRevertModel->escalationCORevertAuto($revert_back,$executionDate,$dist_code,$subdiv_code,$cir_code,$case_no,$co_user_code,$query1->mouza_pargona_code,$query1->lot_no,$allocation_days,$service_code);

            log_message("error", "#ESC002, transaction-error-STATUS======".$escalationUpdateStatus);

            if($escalationUpdateStatus == 0){

                log_message("error", "#ESC002, transaction-error in method 'COFieldMutation/revertBackLS' with case-no :". $case_no);
                $this->session->set_flashdata('message', "Something went wrong. Error Code(#ESC002)");
                redirect(base_url() . "index.php/home");
            }
        }
    }


    public function escalationRevertToSK($case_no,$rmk,$revert_back,$dist_code,$subdiv_code,$cir_code,$service_code)
    {
             $update=array(
                    'is_dispose'=>'S',
                    'sk_note'=>null,
                    'sk_note_date'=>null,
                    'sk_flag'=>null,
                    'sk_id'=>null
                );
            $pen="SK";

            $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);

            if($basundharaExist)
            {

                if($service_code == SERVICE_FIELD_MUTATION)
                {
                    $this->revertByCoFMUT($case_no,$rmk,$update,$revert_back,$dist_code,$subdiv_code,$cir_code,$service_code);
                }

                //////////////POST To basundhara/////////////////////
                $application_no=$basundharaExist;
                $rmk='Reverted back to ' . $pen;
                $status='M';
                $task='CO';
                $case=$case_no;
                $this->basundharamodel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                //////////////////

                $this->DashboardData($case_no,$pen,$rmk);
            }
            $this->session->set_flashdata('message',"Case have been Reverted back to " . $pen);
            redirect('/home');
    }


    function DashboardData($case_no,$penUser,$rmrk)
    {
        //////////////Update Dashboard Database///////////////////////
            $this->dbb = $this->load->database('dash', TRUE);
            $base=array(
                'pending_with_user' => $penUser
            );
            $this->dbb->where('case_no',$case_no);
            $this->dbb->update('dashboard_data',$base);

            $this->db->where('case_no',$case_no);
            $this->db->update('dashboard_data',$base);


            $ip=$this->utilityclass->checkIp($_SERVER['REMOTE_ADDR']);
            if ($ip == true)
            return;
        
            $action= array(
                'case_no' => $case_no,
                'user_code' => $this->session->userdata('user_code'),
                'date_of_action_taken' => date("Y-m-d h:i:s"),
                'user_designation' => $this->session->userdata('user_desig_code'),
                'remark' => $rmrk,
                'ip_address'=>$_SERVER['REMOTE_ADDR']
                    );
            $this->dbb->insert('dashboard_action',$action);
            $this->db->insert('dashboard_action',$action);
            /////////////////////////////////////
    }

    function getServiceCodeByCaseNo($case_no)
    {
        if (strpos($case_no, '/FMUT') !== false) {
            return SERVICE_FIELD_MUTATION;
        } elseif (strpos($case_no, '/OMUT') !== false) {
            return SERVICE_OFFICE_MUTATION;
        } elseif (strpos($case_no, '/OPART') !== false){
            return SERVICE_OFFICE_PARTITION;
        } elseif (strpos($case_no, '/FPART') !== false){
        return SERVICE_FIELD_PARTITION;
        } elseif (strpos($case_no, '/RECLASS') !== false){
        return SERVICE_RECLASSIFICATION;
        }
    }

    // get assigned date
    public function getEscalatedDate($case_no)
    {
        $res = $this->Escalationmodel->getEscalatedRowDetailsBasic($case_no);
        $escalated_date = $res->escalated_date;
        return $escalated_date;
    }
    public function getEscRowDet($case_no)
    {
        $res = $this->Escalationmodel->getEscalatedRowDetailsBasic($case_no);
        return $res;
    }


    public function getEscalatedDateForAst($case_no)
    {
        $res = $this->Escalationmodel->getEscalatedRowDetailsBasic($case_no);
        $escalated_date_ast = $res->assigned_other_es_date;
        return $escalated_date_ast;
    }


    public function revertToAppellateUser()
    {        
        $case_no  = $this->utilityclass->decryptJwtCase($this->input->get('case_no'));
        $fromUser = $this->utilityclass->decryptJwtCase($this->input->get('fromUser'));

        // get detail from escalation table
        $escTable = $this->getFromEscalationDetailByCaseNo($case_no);

        if(ESCALATION_ALLOW_TIME == 1)
        {
            $currDate     = date('Y-m-d H:i:s');
            $assignedDate = $escTable->assigned_date;
            $diff         = $this->Escalationmodel->dateDiff($currDate, $assignedDate);
            $diff         = (int)$diff;
        }
        else
        {
            $currDate     = date('Y-m-d');
            $assignedDate = date('Y-m-d', strtotime($escTable->assigned_date));
            $diff         = $this->Escalationmodel->dateDiff($currDate, $assignedDate);
        }

        if($escTable->escalated_date > $currDate)
        {
            $remainingDays = $diff;
            $data['esc_env'] = null;
        }
        else // auto escalate to higher appellate authority
        {
            $remainingDays   = 0;
            $data['esc_env'] = DEESCALATE;
        }

        $data['remainingDays'] = $remainingDays;
        $data['_view'] = 'EscalationRevertView/revertToLowerAppellate';
        $this->load->view('layouts/main',$data);
    }


    public function getFromEscalationDetailByCaseNo($case_no)
    {
        $sql = $this->db->query("SELECT * FROM escalation_details WHERE case_no=? 
                    AND deescalation_status IS NULL", array($case_no));
        return $sql->row();
    }
}