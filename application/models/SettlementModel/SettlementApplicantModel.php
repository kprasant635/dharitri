<?php
class SettlementApplicantModel extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

   

    // get all new pattdars from citizen entry
    public function getAllApplicantBuyers($case)
    {
        $applicants = $this->db->select()
            ->where('application_no',$case)
            ->where('changed_for', 1)
            ->order_by('id', 'asc')
            ->get('t_changed_data');
        return $applicants->result();
    }

     // get main applicant marital status updated data
     public function getMainApplicantMaritalStatus($case)
     {
         $applicants = $this->db->select()
             ->where('application_no',$case)
             ->where('changed_for', 3)
             ->order_by('id', 'asc')
             ->get('t_changed_data');
         return $applicants->row();
     }

     // get all new pattdars from citizen entry
    public function getAllApplicantBuyersCo($case)
    {
        $applicants = $this->db->select()
            ->where('application_no',$case)
            ->where('changed_for', 1)
            ->where_in('status_dhar', array('LY','LN'))
            ->order_by('id', 'asc')
            ->get('t_changed_data');
        return $applicants->result();
    }

     // get main applicant marital status updated data
     public function getMainApplicantMaritalStatusCo($case)
     {
         $applicants = $this->db->select()
             ->where('application_no',$case)
             ->where('changed_for', 3)
             ->where_in('status_dhar', array('LY','LN'))
             ->order_by('id', 'asc')
             ->get('t_changed_data');
         return $applicants->result();
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

      // get location for CO
    public function locationSelectCo($service_code, $status)
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

    public function checkLmAuth($applid)
    {
        $applicants = $this->db->select()
            ->where('application_no',$applid)
            ->where('status_dhar', null)
            ->get('t_changed_data');
        $data = $applicants->num_rows();

        if ($data >0)
        {
            return 'y';
        }
        else
        {
            return 'n';
        }

    }

    public function checkCoAuth($applid)
    {
        $applicants = $this->db->select()
            ->where('application_no',$applid)
            ->where_in('status_dhar', array('LY','LN'))
            ->get('t_changed_data');
        $data = $applicants->num_rows();

        if ($data >0)
        {
            return 'y';
        }
        else
        {
            return 'n';
        }

    }

     // get lm report from settlement proceeding
     public function getLmReportProceeding($case)
     {
         $proceedings = $this->db->select()
             ->where('case_no',$case)
             ->where('status','AE')
             ->order_by('proceeding_id', 'desc')
             ->get('settlement_proceeding');
 
         return $proceedings->row();
     }

     public function getPdarCronNo($case_no)
     {
        $sql = "SELECT pdar_cron_no FROM settlement_applicant WHERE case_no = ? order by pdar_cron_no desc";
        $result = $this->db->query($sql, array($case_no));
        
        return $result;

     }

}