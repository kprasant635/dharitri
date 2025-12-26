<?php
class Dagsreportmodel extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->dbswitch();
	}
	public function dbswitch(){
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
	
	public function getDagsWithZeroArea(){
		// $this->dbswitch();
		//dag_zeroarea
		$sql = "Select 
		(select loc_name from location where dist_code=cb.dist_code and subdiv_code=cb.subdiv_code and cir_code=cb.cir_code and mouza_pargona_code='00' limit 1) as circle,
		(select loc_name from location where dist_code=cb.dist_code and subdiv_code=cb.subdiv_code and cir_code=cb.cir_code and mouza_pargona_code=cb.mouza_pargona_code and lot_no='00' limit 1) as mouza,
		(select loc_name from location where dist_code=cb.dist_code and subdiv_code=cb.subdiv_code and cir_code=cb.cir_code and mouza_pargona_code=cb.mouza_pargona_code and lot_no=cb.lot_no and vill_townprt_code=cb.vill_townprt_code limit 1) as village,
		dag_no,patta_no,pc.patta_type,cb.dag_area_b as bigha,cb.dag_area_k as katha,cb.dag_area_lc lessa,cb.dag_area_g as ganda
		from chitha_basic cb join patta_code pc on cb.patta_type_code=pc.type_code 
		where (cb.dag_area_b+cb.dag_area_k+cb.dag_area_lc+cb.dag_area_g)=0 and pc.jamabandi='y'
		order by cir_code,mouza_pargona_code,vill_townprt_code";
		$result = $this->db->query($sql)->result_array();
		return $result;

	}

	public function getDagsWithRevenueZero(){

		$sql = "Select 
		(select loc_name from location where dist_code=cb.dist_code and subdiv_code=cb.subdiv_code and cir_code=cb.cir_code and mouza_pargona_code='00' limit 1) as circle,
		(select loc_name from location where dist_code=cb.dist_code and subdiv_code=cb.subdiv_code and cir_code=cb.cir_code and mouza_pargona_code=cb.mouza_pargona_code and lot_no='00' limit 1) as mouza,
		(select loc_name from location where dist_code=cb.dist_code and subdiv_code=cb.subdiv_code and cir_code=cb.cir_code and mouza_pargona_code=cb.mouza_pargona_code and lot_no=cb.lot_no and vill_townprt_code=cb.vill_townprt_code limit 1) as village,
		dag_no,patta_no,pc.patta_type
		from chitha_basic cb join patta_code pc on cb.patta_type_code=pc.type_code 
		where (cb.dag_revenue='0' or cb.dag_revenue is null) and pc.jamabandi='y'
		order by cir_code,mouza_pargona_code,vill_townprt_code";
		$result = $this->db->query($sql)->result_array();
		return $result;

	}
	//dag_no zero-----
	public function getDagsNoZero(){
		$sql = "Select 
		(select loc_name from location where dist_code=cb.dist_code and subdiv_code=cb.subdiv_code and cir_code=cb.cir_code and mouza_pargona_code='00' limit 1) as circle,
		(select loc_name from location where dist_code=cb.dist_code and subdiv_code=cb.subdiv_code and cir_code=cb.cir_code and mouza_pargona_code=cb.mouza_pargona_code and lot_no='00' limit 1) as mouza,
		(select loc_name from location where dist_code=cb.dist_code and subdiv_code=cb.subdiv_code and cir_code=cb.cir_code and mouza_pargona_code=cb.mouza_pargona_code and lot_no=cb.lot_no and vill_townprt_code=cb.vill_townprt_code limit 1) as village,
		dag_no,patta_no
		from chitha_basic cb
		where (cb.dag_no='0' or cb.dag_no is null)
		order by cir_code,mouza_pargona_code,vill_townprt_code";
		$result = $this->db->query($sql)->result_array();
		return $result;

	}

	//patta no zero----
	public function getPattaNoZeroExceptGovtDag(){
		$sql = "Select 
		(select loc_name from location where dist_code=cb.dist_code and subdiv_code=cb.subdiv_code and cir_code=cb.cir_code and mouza_pargona_code='00' limit 1) as circle,
		(select loc_name from location where dist_code=cb.dist_code and subdiv_code=cb.subdiv_code and cir_code=cb.cir_code and mouza_pargona_code=cb.mouza_pargona_code and lot_no='00' limit 1) as mouza,
		(select loc_name from location where dist_code=cb.dist_code and subdiv_code=cb.subdiv_code and cir_code=cb.cir_code and mouza_pargona_code=cb.mouza_pargona_code and lot_no=cb.lot_no and vill_townprt_code=cb.vill_townprt_code limit 1) as village,
		dag_no,patta_no,pc.patta_type,cb.dag_area_b as bigha,cb.dag_area_k as katha,cb.dag_area_lc as lessa,cb.dag_area_g as ganda
		from chitha_basic cb join patta_code pc on cb.patta_type_code=pc.type_code 
		where (cb.patta_no ='0' or cb.patta_no is null) and pc.conversion='y'
		order by cir_code,mouza_pargona_code,vill_townprt_code";
		$result = $this->db->query($sql)->result_array();
		return $result;

	}
}