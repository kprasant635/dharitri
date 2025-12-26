<?php
class Partmodel extends CI_Model {
    public function __construct() {
        parent::__construct();

        $this->dbswitch();
    }

	function mutation(){
		$lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');
        $mouza_pargona_code = $this->input->post('mouza_code');
        $locationData = array(
            'lot_no' => $lot_no,
            'vill_code' => $vill_code,
            'mouza_pargona_code' => $mouza_pargona_code,
        );
		$this->session->set_userdata($locationData);
		$patta_no = $this->input->post('patta_no');
        $patta_type_code = $this->input->post('patta_type');
		$patta_type = $this->input->post('patta_type');
        $applied_to = $this->input->post('add_of_desig');
        $topseal = $this->input->post('topseal');
        $add_off_name = $this->input->post('add_of_name');
        $partiondata = array(
            'add_off_name' => $add_off_name,
            'add_of_desig' => $applied_to,
            'patta_no' => $patta_no,
            'patta_type' =>$patta_type,
            'patta_type_code'=>$patta_type_code,
            'complete_patition_yn' => 'y',
            'remarks' => $topseal
        );
        $this->session->set_userdata($partiondata);
	}
	function landarea(){
		$dag_no = $this->input->post('dag_no');
        $bigha = $this->input->post('m_dag_area_b');
        $katha = $this->input->post('m_dag_area_k');
        $lessa = $this->input->post('m_dag_area_lc');
        $gonda = $this->input->post('m_dag_area_g');
        $kranti = $this->input->post('m_dag_area_kr');
        $t_bigha=$this->input->post('dag_area_b');
        $t_katha=$this->input->post('dag_area_k');
        $t_lessa=$this->input->post('dag_area_lc');
        $revenue = $this->input->post('land_valuation');
        $tot_lc=($bigha*5*20)+($katha*20)+$lessa;
        $total=($t_bigha*5*20)+($t_katha*20)+$t_lessa;
        if($katha>5 or $lessa>20)
        {
            $this->session->set_flashdata('message', 'You did not enter the partition land area correctly !!');
            redirect(base_url() . 'index.php/Partition/partland'); 
        }
        if(($tot_lc == 0) or ($total<$tot_lc))
        {
            $this->session->set_flashdata('message', 'You did not enter the partition land area correctly !!');
            redirect(base_url() . 'index.php/Partition/partland');
        }
		$data = array(
            'dag_no' => $dag_no,
            'bigha' => $bigha,
            'katha' => $katha,
            'lessa' => $lessa,
            'gonda' => $gonda,
            'kranti' => $kranti,
            'revenue' => $revenue
        );
        $this->session->set_userdata($data);
	}
	function pattdar(){
		     $db=  $this->session->userdata('db');
				$pdar_cron_no = $this->input->post('pdar_cron_no');
                $pdar_name = $this->input->post('pdar_name');
                $pdar_guard_name = $this->input->post('pdar_guardian');
                $pdar_rel_guar = $this->input->post('pdar_rel_guar');
                $pdar_add1 = $this->input->post('pdar_add1');
                $pdar_add2 = $this->input->post('pdar_add2');
                $is_converted_pattadar = $this->input->post('Remain_Land');
                $pdar_gender = $this->input->post('pdar_gender');
                $pdar_mother = $this->input->post('pdar_mother');
                $pdar_mobile=$this->input->post('pdar_mobile');
                $pdar_aadhar=$this->input->post('pdar_aadhar');
                $pdar_nrc=$this->input->post('pdar_nrc');
                $pdar_pan=$this->input->post('pdar_pan');
                $pdar_voterID=$this->input->post('pdar_voterID');
                $merged = array(
                    'pdar_name' => $pdar_name,
                    'pdar_guardian' => $pdar_guard_name,
                    'pdar_rel_guar' => $pdar_rel_guar,
                    'pdar_add1' => $pdar_add1,
                    'pdar_add2' => $pdar_add2,
                    'is_converted_pattadar' => $is_converted_pattadar,
                    'pdar_mother'=>$pdar_mother,
                    'pdar_gender'=>$pdar_gender,
                    'pdar_pan_no'=>$pdar_pan,
                    'pdar_citizen_no'=>$pdar_voterID,
                    'pdar_aadharno'=>$pdar_aadhar,
                    'pdar_mobile'=>$pdar_mobile,
                    'pdar_nrcno'=>$pdar_nrc
                );
				$data['pdar_id'] = $merged['pdar_name'];
				if (!$this->session->userdata('pdaridarray')) {
					 $this->session->set_userdata('appdet', array());
					 $appdet = $this->session->userdata('appdet');
					 $appdet[] = $merged;
					 $this->session->set_userdata('appdet', $appdet);
					 $this->session->set_userdata('pdaridarray', array());
					 $pdararray = $this->session->userdata('pdaridarray');
					 $pdararray[] = $data['pdar_id'];
					 $this->session->set_userdata('pdaridarray', $pdararray);
				} else {
					$appdet = $this->session->userdata('appdet');
					$appdet[] = $merged;
					$this->session->set_userdata('appdet', $appdet);
					$pdararray = $this->session->userdata('pdaridarray');
					$pdararray[] = $data['pdar_id'];
					$this->session->set_userdata('pdaridarray', $pdararray);
				}
				
	}
	function getGender(){
		$db=  $this->session->userdata('db');
		$q="Select * from   master_gender ";
		return $this->db->query($q)->result();
	}
	public function getPattadarPartition() {
		$db=  $this->session->userdata('db');
        $pattaNo = $this->session->userdata('patta_no');
        $pattaType = $this->session->userdata('patta_type');
        $dag_no = $this->session->userdata('dag_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $vill_townprt_code = $this->session->userdata('vill_code');
        $lot_no = $this->session->userdata('lot_no');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        //$case_no = $this->session->userdata('case_no');
        $incompare = null;
        if ($this->session->userdata('pdaridarray')) {
            $incompare = implode(',', array_values($this->session->userdata('pdaridarray')));
            //echo $incompare;
            $q = "select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from   chitha_pattadar p join 
             chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
            and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
            p.pdar_id = d.pdar_id where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' and d.p_flag!='1'
            and d.lot_no='$lot_no' and d.dag_no='$dag_no' and trim(p.patta_no)=trim('$pattaNo') 
            and p.patta_type_code='$pattaType' and p.pdar_id not in($incompare)";
        } else {
            $q = "select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from   chitha_pattadar p join 
             chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
            and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
            p.pdar_id = d.pdar_id where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
            p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' and d.p_flag!='1'
            and d.lot_no='$lot_no' and d.dag_no='$dag_no' and trim(p.patta_no)=trim('$pattaNo')
            and p.patta_type_code='$pattaType'";
        }
        $data = $this->db->query($q)->result();
        return $data;
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

}
