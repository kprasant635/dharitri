<?php
class EkhajanaCFRmodel extends CI_Model {
    
    public function getCircleListFromDistCode($dist_code){
        //return "from the model dist code is ".$dist_code;
        $circleList = $this->db->query("select * from location where dist_code=? and subdiv_code!=? and cir_code!=?
                                        and mouza_pargona_code=?",array($dist_code, '00', '00','00'))->result();
        return $circleList;
    }

    public function getAllMouzaName($dist_code,$subdiv_code,$cir_code)
    {
        $query = $this->db->query("select dist_code,subdiv_code,cir_code,mouza_pargona_code,locname_eng,loc_name from location where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code!=? and lot_no=?",array($dist_code,$subdiv_code,$cir_code,'00','00'))->result();
        return $query;
    }
    
    public function insertCFRDetails($insert_details_for_cfr_data,$insert_details_for_cfr_transactions){
        error_reporting(0);
        $this->db->trans_begin();   
        $tstatus1 = $this->db->insert('ekhajana_cfr_records', $insert_details_for_cfr_data);               
        if ($tstatus1 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#CFRENTRY001, Error in insert, table 'ekhajana_cfr_records' with data :". json_encode($insert_details_for_cfr_data));
            return;
        }  

        $tstatus2 = $this->db->insert('ekhajana_cfr_records_transactions', $insert_details_for_cfr_transactions);               
        if ($tstatus2 != 1 )
        {
            $this->db->trans_rollback();
            log_message("error", "#CFRENTRY002, Error in insert, table 'ekhajana_cfr_records_transactions' with data :". json_encode($insert_details_for_cfr_data));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #CFRENTRY002'];
        }  
        //checkeing all transaction status 
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            log_message("error", "#CFRENTRY002, Transaction Status Error In CFR entry Tables");
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #CFRENTRY002'];
        }else{
            $this->db->trans_commit();
            return ['result' => 'SUCCESS', 'msg' => 'CFR DETAILS ADDED SUCCESSFULLY AND FORWARDED TO ADC, STATUS OF THE ENTRY CAN BE VIEWED UNDER VIEW SECTION'];
        }  
    }

    public function getCfrDetailsDistWise(){        
        $cfr_details = $this->db->query("select 
                                        (select loc_name as circle_name from location where dist_code=t.dist_code and 
                                        subdiv_code=t.subdiv_code and cir_code=t.cir_code and mouza_pargona_code='00'), 
                                        (select loc_name as mouza_name from location where dist_code=t.dist_code and 
                                        subdiv_code=t.subdiv_code and cir_code=t.cir_code and 
                                        mouza_pargona_code=t.mouza_pargona_code and lot_no='00'),
                                        cfr_book_number,
                                        no_of_cfr_pages_in_the_book,
                                        cfr_page_serial_no_start,
                                        cfr_page_serial_no_end,
                                        CASE
                                            WHEN status='P' THEN 'Pending-At-ADC'
                                            WHEN status='R' THEN 'Rejected-By-ADC'
                                            WHEN status='Y' THEN 'Approved-By-ADC'
                                            ELSE 'Status-Not-Found'
                                        END As status
                                        from ekhajana_cfr_records t
                                        order by t.id desc")->result();
        return $cfr_details;
    }

    public function checkDuplicateData($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$cfr_book_no,$total_cfr_pages,$cfr_page_no_starts,$cfr_page_no_ends)
    {
        $query = $this->db->query("select * from ekhajana_cfr_records where cfr_book_number=? and status in ('P','Y')",array($cfr_book_no));
        if($query->num_rows() ==0)
        {
            return ['result' => 'SUCCESS', 'msg' => ''];
        }else{
            return ['result' => 'SERVER-ERROR', 'msg' => 'Given CFR Book Details Already Exists And Its Status is Pending Or Approved. Only Rejected Book Details Can Be Entered Again'];
        }

    }

    public function geCFRBookDetails($id)
    {
        $query = $this->db->query("select * from ekhajana_cfr_records where id=?",array($id));
        if($query->num_rows() ==0 )
        {
            return [];
        }else{
            return $query->row();
        }
    }

    public function approveEcfrBook($ecfr_book_id,$adc_remarks,$posted_data)
    {
        $ecfr_record_row = $this->db->query("select * from ekhajana_cfr_records where id=?",array($ecfr_book_id))->row();
        $ecfr_transactions_row = $this->db->query("select * from ekhajana_cfr_records_transactions where cfr_book_number=?",array($ecfr_record_row->cfr_book_number))->row();        
        $user_details = $this->session->userdata;
        //insert into ekhajana_rejected_cfr_records
        $ekhajana_cfr_records_transactions = array(
            'dist_code'  => $ecfr_record_row->dist_code,
            'subdiv_code' => $ecfr_record_row->subdiv_code,
            'cir_code' => $ecfr_record_row->cir_code,            
            'mouza_pargona_code' => $ecfr_record_row->mouza_pargona_code,
            "cfr_book_number" => $ecfr_record_row->cfr_book_number,
            "no_of_cfr_pages_in_the_book" => $ecfr_record_row->no_of_cfr_pages_in_the_book,
            "cfr_page_serial_no_start" => $ecfr_record_row->cfr_page_serial_no_start,
            "cfr_page_serial_no_end" => $ecfr_record_row->cfr_page_serial_no_end,
            "entry_year" => $ecfr_record_row->entry_year,
            "doul_year" => $ecfr_record_row->doul_year,
            "status" => 'Y',
            "tn_user_details" => $ecfr_record_row->tn_user_details,
            "tn_posted_data" => $ecfr_transactions_row->tn_posted_data,
            "tn_remarks" => $ecfr_record_row->tn_remarks,
            "adc_remarks" =>  $adc_remarks,
            "adc_user_details" => json_encode($user_details),
            "adc_posted_data" => json_encode($posted_data),
            "created_at" => date('Y-m-d h:i:s'),
        ); 
        $tstatus2 = $this->db->insert('ekhajana_cfr_records_transactions', $ekhajana_cfr_records_transactions); 
        if ($tstatus2!= 1)
        {
            $this->db->trans_rollback();
            log_message("error", "#EKHADCDCDPEWI003, Error in insert on ekhajana_cfr_records_transactions table with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHADCDCDPEWI003'];
        }
        // update in ecfr records book 
        $ecfr_record_book = array(
            'adc_remarks'   => $adc_remarks,         
            'adc_user_details' =>  json_encode($user_details),
            "modified_at"   => date('Y-m-d h:i:s'),
            'status'        => 'Y'
        ); 
        $this->db->where('id', $ecfr_book_id);
        $this->db->update('ekhajana_cfr_records', $ecfr_record_book);
        if($this->db->affected_rows() != 1){ 
            $this->db->trans_rollback();
            log_message("error", "#EKHADCDCDPE006, Error in update table 'ekhajana_mouzadar_arrear_details' with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHADCDCDPE007'];
        }else{
            return ['result' => 'SUCCESS', 'msg' => 'CFR Book Records Approved Successsfullyy...!!!'];
        }
    }

    public function rejectEcfrBook($ecfr_book_id,$adc_remarks,$adc_reject_remarks,$posted_data)
    {
        $ecfr_record_row = $this->db->query("select * from ekhajana_cfr_records where id=?",array($ecfr_book_id))->row();
        $ecfr_transactions_row = $this->db->query("select * from ekhajana_cfr_records_transactions where cfr_book_number=?",array($ecfr_record_row->cfr_book_number))->row();        
        $user_details = $this->session->userdata;
        //insert into ekhajana_rejected_cfr_records
        $ekhajana_cfr_records_transactions = array(
            // 'dist_code'             => $ecfr_record_row->dist_code,
            // 'subdiv_code'           => $ecfr_record_row->subdiv_code,
            // 'cir_code'              => $ecfr_record_row->cir_code,            
            // 'mouza_pargona_code'    => $ecfr_record_row->mouza_pargona_code,
            // "all_data"              => json_encode($ecfr_record_row),
            // 'adc_verified'          => 'N',
            // 'adc_remarks'           => $adc_remarks,
            // 'adc_rejected_remarks'  => $adc_reject_remarks,
            // 'status'                => 'R',
            // 'adc_user_code'         => $this->session->all_userdata()['user_code'],
            // "created_at"            => date('Y-m-d h:i:s'),
            // "modified_at"           => date('Y-m-d h:i:s'),
            'dist_code'  => $ecfr_record_row->dist_code,
            'subdiv_code' => $ecfr_record_row->subdiv_code,
            'cir_code' => $ecfr_record_row->cir_code,            
            'mouza_pargona_code' => $ecfr_record_row->mouza_pargona_code,
            "cfr_book_number" => $ecfr_record_row->cfr_book_number,
            "no_of_cfr_pages_in_the_book" => $ecfr_record_row->no_of_cfr_pages_in_the_book,
            "cfr_page_serial_no_start" => $ecfr_record_row->cfr_page_serial_no_start,
            "cfr_page_serial_no_end" => $ecfr_record_row->cfr_page_serial_no_end,
            "entry_year" => $ecfr_record_row->entry_year,
            "doul_year" => $ecfr_record_row->doul_year,
            "status" => 'R',
            "tn_user_details" => $ecfr_record_row->tn_user_details,
            "tn_posted_data" => $ecfr_transactions_row->tn_posted_data,
            "tn_remarks" => $ecfr_record_row->tn_remarks,
            "adc_remarks" =>  $adc_remarks,
            'adc_rejected_remarks'  => $adc_reject_remarks,
            "adc_user_details" => json_encode($user_details),
            "adc_posted_data" => json_encode($posted_data),
            "created_at"            => date('Y-m-d h:i:s'),
        ); 
        $tstatus2 = $this->db->insert('ekhajana_cfr_records_transactions', $ekhajana_cfr_records_transactions); 
        if ($tstatus2!= 1)
        {
            $this->db->trans_rollback();
            log_message("error", "#EKHADCDCDPEWI0031, Error in insert on ekhajana_cfr_records_transactions table with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHADCDCDPEWI0031'];
        }
        // update in ecfr records book 
        $ecfr_record_book = array(
            'adc_remarks'           => $adc_remarks,         
            'adc_rejected_remarks'  => $adc_reject_remarks,         
            'adc_user_details' =>  json_encode($user_details),
            "modified_at"   => date('Y-m-d h:i:s'),
            'status'        => 'R'
        ); 

        $this->db->where('id', $ecfr_book_id);
        $this->db->update('ekhajana_cfr_records', $ecfr_record_book);
        if($this->db->affected_rows() != 1){ 
            $this->db->trans_rollback();
            log_message("error", "#EKHADCDCDPE0061, Error in update table 'ekhajana_mouzadar_arrear_details' with query- ". json_encode($this->db->last_query()));
            return ['result' => 'SERVER-ERROR', 'msg' => 'Some error occured, Error-Code : #EKHADCDCDPE0061'];
        }else{
            return ['result' => 'SUCCESS', 'msg' => 'CFR Book Records Rejected Successsfullyy...!!!'];
        }
    }

    public function getPendingCFRBooksDetails($dist_code)
    {
        $query = $this->db->query("select * from ekhajana_cfr_records where dist_code=? and status in('P')",array($dist_code));
        if($query->num_rows() == 0)
        {
            return [];
        }else{
            return $query->result();
        }
    }

    public function getApprovedCFRBooksDetails($dist_code)
    {
        $query = $this->db->query("select * from ekhajana_cfr_records where dist_code=? and status in('Y')",array($dist_code));
        if($query->num_rows() == 0)
        {
            return [];
        }else{
            return $query->result();
        }
    }

    public function getRejectedCFRBooksDetails($dist_code)
    {
        $query = $this->db->query("select * from ekhajana_cfr_records where dist_code=? and status in('R')",array($dist_code));
        if($query->num_rows() == 0)
        {
            return [];
        }else{
            return $query->result();
        }
    }
}

?>