<?php

class EkhajanaChangeRequestModel extends CI_Model {

    //getting pending list for co 
    public function pendingListForLC($dist_code,$subdiv_code,$cir_code){
        $query = "Select erm.*,elc.existing_land_class,elc.proposed_land_class from ekhajana_change_request_master erm join ekhajana_land_class_change elc on erm.petition_no=elc.petition_no where dist_code = ? and subdiv_code = ? and cir_code = ? and change_type = ?"; 

        $query = $this->db->query($query, array($dist_code, $subdiv_code, $cir_code, '1'));


        return $query->result();
    }

    public function pendingListForPA($dist_code,$subdiv_code,$cir_code){
        $query = "Select * from ekhajana_change_request_master where dist_code = ? and subdiv_code = ? and cir_code = ? and change_type = ?"; 

        $query = $this->db->query($query, array($dist_code, $subdiv_code, $cir_code, '2'));


        return $query->result();
    }

    //getting pending list count for co 
    public function pendingForLCCount($dist_code,$subdiv_code,$cir_code){
        $query = $this->db->select('count(*)')
                    ->where('dist_code', $dist_code)
                    ->where('subdiv_code', $subdiv_code)
                    ->where('cir_code', $cir_code)
                    ->where('change_type', '1')
                    ->from('ekhajana_change_request_master')
                    ->get(); 
        //return $this->db->last_query();
        if($query->num_rows() != 0 ){
            return $query->row()->count;
        }else{
            return 0;
        }
    }


     public function pendingForPACount($dist_code,$subdiv_code,$cir_code){
        $query = $this->db->select('count(*)')
                    ->where('dist_code', $dist_code)
                    ->where('subdiv_code', $subdiv_code)
                    ->where('cir_code', $cir_code)
                    ->where('change_type', '2')
                    ->from('ekhajana_change_request_master')
                    ->get(); 
        //return $this->db->last_query();
        if($query->num_rows() != 0 ){
            return $query->row()->count;
        }else{
            return 0;
        }
    }


    //getting pending case details 
    public function getPendingCaseDetailsFromId($petition_no){
        $query = "Select erm.*,elc.existing_land_class,elc.proposed_land_class from ekhajana_change_request_master erm join ekhajana_land_class_change elc on erm.petition_no=elc.petition_no where change_type = ? and erm.petition_no = ?"; 

        $query = $this->db->query($query, array('1',$petition_no));
       // echo $this->db->last_query();
        if($query->num_rows() != 0 ){
            return $query->row();
        }else{
            return false;
        }
    }

    //getting pending case details 
    public function getPendingCaseDetailsFromIdPA($petition_no){
        $query = "Select erm.*,eac.* from ekhajana_change_request_master erm join ekhajana_area_change eac on erm.petition_no=eac.petition_no where change_type = ? and erm.petition_no = ?"; 

        $query = $this->db->query($query, array('2',$petition_no));
       // echo $this->db->last_query();
        if($query->num_rows() != 0 ){
            return $query->result();
        }else{
            return false;
        }
    }

    
}