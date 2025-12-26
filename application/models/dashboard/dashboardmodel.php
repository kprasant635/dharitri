<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PattaModel extends CI_Model {

    public function __construct() {
        parent::__construct();
		$this->dbswitch();
    }
	public function dbswitch(){       
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


function Dashboard($case_no,$type){
        $this->dbb = $this->load->database('dash', TRUE);
        $sql="Select pb.*,pd.patta_no,pd.patta_type_code,
pd.dag_no from allotment_cert_basic pb 
join allotment_pet_dag pd on pb.case_no=pd.case_no  where pb.settlement_typ is null and  pb.case_no='$case_no' ";
        $data=$this->db->query($sql)->row_array();
        // $type='AC';
        $base= array(
              'dist_code'=> $data['dist_code'],
              'subdiv_code' =>$data['subdiv_code'],
              'cir_code'=>$data['circle_code'],
              'mouza_pargona_code'=>$data['mouza_pargona_code'],
              'lot_no'=>$data['lot_no'],
              'vill_townprt_code'=>$data['vill_townprt_code'],
              'case_no'=>$data['case_no'],
              'date_of_reg'=>$data['date_entry'],
              'dag_no'=>$data['dag_no'],
              'patta_type_code' =>'NA',
              'patta_no' =>'NA',
              'status' =>'P',
              'pending_with_user' =>'CO',
              'case_type' =>$type,
            );
        $this->dbb->insert('dashboard_data',$base);
        $sql="Select alotee_name as pet_name,alotee_gurdian as guard_name,alotee_reln as guard_rel from allotment_petitioner where case_no='$data[case_no]'  ";
        $petitioner=$this->db->query($sql)->result();
        foreach ($petitioner as $key => $value) {
            $applicant= array(
                'case_no' => $data['case_no'],
                'applicant_name' => $value->pet_name,
                'guardian_name' => $value->guard_name,
                'gender' => $value->guard_rel );
            $this->dbb->insert('dashboard_applicant',$applicant);
        }
        $action= array(
            'case_no' =>$data['case_no'],
            'user_code' => $this->session->userdata('user_code'),
            'date_of_action_taken' => date('Y-m-d'),
            'user_designation' => $this->session->userdata('user_desig_code'),
            'remark' => 'Registered By Assistant',
             );
         $this->dbb->insert('dashboard_action',$action);
    }
    function DashboardData($case_no,$penUser,$rmrk){
        //////////////Update Dashboard Database///////////////////////
                $this->dbb = $this->load->database('dash', TRUE);
                $base=array(
                    'pending_with_user' => $penUser
                );
                $this->dbb->where('case_no',$case_no);
                $this->dbb->update('dashboard_data',$base);
                $action= array(
                    'case_no' => $case_no,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_of_action_taken' => date('Y-m-d'),
                    'user_designation' => $this->session->userdata('user_desig_code'),
                    'remark' => $rmrk,
                     );
                $this->dbb->insert('dashboard_action',$action);
            /////////////////////////////////////
    }
    function DashboardDataFinal($case_no){
        //////////////Update Dashboard Database///////////////////////
                    $this->dbb = $this->load->database('dash', TRUE);
                    $base=array(
                        'final_order_date' => date('Y-m-d'),
                        'pending_with_user'=>'NA',
                        'status'=>'F',
                        'remark'=>'Final Order Passed'
                    );
                    $this->dbb->where('case_no',$case_no);
                    $this->dbb->update('dashboard_data',$base);
                    $action= array(
                        'case_no' => $case_no,
                        'user_code' => $this->session->userdata('user_code'),
                        'date_of_action_taken' => date('Y-m-d'),
                        'user_designation' => $this->session->userdata('user_desig_code'),
                        'remark' => 'Final Order Passed',
                         );
                    $this->dbb->insert('dashboard_action',$action);
            /////////////////////////////////////
    }
    

}
