<?php
class SettlementInstallment extends CI_Model {
   
    public function getDueInstallmentPaymentCaseListFromServiceCode($service_code,$dist_code,$subdiv_code,$cir_code){
        $case_list = $this->db->query("select sb.applid,sp.case_no from settlement_premium sp join  settlement_basic sb
                                    on sp.case_no = sb.case_no  where sp.is_final=? and sp.grn_no 
                                    is not null and sp.due_amount>sp.paid_amount and sb.service_code=? and sb.dist_code=?
                                    and sb.subdiv_code=? and sb.cir_code=?", 
                                   array(1,$service_code,$dist_code,$subdiv_code,$cir_code))->result();
                    
        return $case_list;
    }

    public function getSpDetailsFromCaseNo($case_no){
        $sp_details = $this->db->query("select * from settlement_premium where is_final=1 and grn_no 
                                    is not null and case_no=?", array($case_no))->result();
                    
        return $sp_details;
    }

    public function getSbDetailsFromCaseNo($case_no){
        $sb_details = $this->db->query("select * from settlement_basic where case_no=?", array($case_no))->row();                    
        return $sb_details;
    }

    public function getSehDetailsFromCaseNo($case_no){
        $sb_details = $this->db->query("select * from settlement_emi_history where case_no=?", array($case_no))->result();                    
        return $sb_details;
    }

}