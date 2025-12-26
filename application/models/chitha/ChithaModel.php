<?php
class ChithaModel extends CI_Model {
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
	public function getDistrictName() {
		$CI = &get_instance();
		$this->db2 = $CI->load->database('db2', TRUE);
		$district = $this->db2->query("select district_name,district_code AS district from   district_details ");
		return $district->result();
	}
	public function getDagforchitha($district_code, $subdivision_code, $circle_code, $mouza_code, $lot_code, $village_code, $p) {
		$this->dbswitch();
		$district = $this->db->query(""
			. "Select dag_no, dag_no_int from   Chitha_Basic where "
			. "Dist_code='$district_code' and Subdiv_code='$subdivision_code' and  patta_type_code='$p' and "
			. "Cir_code='$circle_code' and Mouza_Pargona_code='$mouza_code' and Lot_No='$lot_code' "
			. "and Vill_townprt_code='$village_code' order by CAST(coalesce(dag_no_int, '0') AS numeric)");
		return $district->result();
	}
	public function getDagforchithaFromChithabasicDoul($district_code, $subdivision_code, $circle_code, $mouza_code, $lot_code, $village_code, $p, $year_no) {
		$this->dbswitch();
		$district = $this->db->query(""
			. "Select dag_no, dag_no_int from   chitha_basic_doul where "
			. "Dist_code='$district_code' and Subdiv_code='$subdivision_code' and  patta_type_code='$p' and "
			. "Cir_code='$circle_code' and Mouza_Pargona_code='$mouza_code' and Lot_No='$lot_code' "
			. "and Vill_townprt_code='$village_code' and year_no = '$year_no' order by CAST(coalesce(dag_no, '0') AS numeric)");
		return $district->result();
	}
	public function getDagforchitha1($district_code, $subdivision_code, $circle_code, $mouza_code, $lot_code, $village_code, $p) {
		$this->dbswitch();
		$district = $this->db->query(""
			. "Select dag_no, dag_no_int from   Chitha_Basic where "
			. "Dist_code='$district_code' and Subdiv_code='$subdivision_code' and  patta_type_code='$p' and "
			. "Cir_code='$circle_code' and Mouza_Pargona_code='$mouza_code' and Lot_No='$lot_code' "
			. "and Vill_townprt_code='$village_code' order by CAST(coalesce(dag_no, '0') AS numeric)");
		return $district->result();
	}
	public function getDagforchitha1111($district_code, $subdivision_code, $circle_code, $mouza_code, $lot_code, $village_code, $p) {
		$q = ""
		. "Select dag_no, dag_no_int from   Chitha_Basic where "
		. "Dist_code='$district_code' and Subdiv_code='$subdivision_code' and  patta_type_code='$p' and "
		. "Cir_code='$circle_code' and Mouza_Pargona_code='$mouza_code' and Lot_No='$lot_code' "
		. "and Vill_townprt_code='$village_code' order by CAST(coalesce(dag_no_int, '0') AS numeric)";
		$district = $this->db->query($q);
		return $district->result();
	}
	public function getDagforchithaAll($district_code, $subdivision_code, $circle_code, $mouza_code, $lot_code, $village_code) {
		$this->dbswitch();
		$q = "Select dag_no, dag_no_int from   Chitha_Basic where Dist_code='$district_code' and Subdiv_code='$subdivision_code' and "
		. "Cir_code='$circle_code' and Mouza_Pargona_code='$mouza_code' and Lot_No='$lot_code' "
		. "and Vill_townprt_code='$village_code' order by CAST(coalesce(dag_no_int, '0') AS numeric)";
		$district = $this->db->query($q);
		return $district->result();
	}
	public function getDagforchithaAll_old_records($district_code, $subdivision_code, $circle_code, $mouza_code, $lot_code, $village_code, $year_no) {
		$this->dbswitch();
		$q = "Select dag_no, dag_no_int from   Chitha_Basic_doul where Dist_code='$district_code' and Subdiv_code='$subdivision_code' and "
		. "Cir_code='$circle_code' and Mouza_Pargona_code='$mouza_code' and Lot_No='$lot_code' "
		. "and Vill_townprt_code='$village_code' and year_no = '$year_no' order by CAST(coalesce(dag_no_int, '0') AS numeric)";
		$district = $this->db->query($q);
		return $district->result();
	}
	public function getDagforchitha1111_old_records($district_code, $subdivision_code, $circle_code, $mouza_code, $lot_code, $village_code, $p, $year_no) {
		$this->dbswitch();
		$q = ""
		. "Select dag_no, dag_no_int from   Chitha_Basic_doul where "
		. "Dist_code='$district_code' and Subdiv_code='$subdivision_code' and  patta_type_code='$p' and "
		. "Cir_code='$circle_code' and Mouza_Pargona_code='$mouza_code' and Lot_No='$lot_code' "
		. "and Vill_townprt_code='$village_code' and year_no = '$year_no' order by CAST(coalesce(dag_no_int, '0') AS numeric)";
		$district = $this->db->query($q);
		return $district->result();
	}
	public function getDagforchithaMiscCase($district_code, $subdivision_code, $circle_code, $mouza_code, $lot_code, $village_code, $p, $pno) {
		$this->dbswitch();
		$q = ""
		. "Select dag_no, dag_no_int from   Chitha_Basic where "
		. "Dist_code='$district_code' and Subdiv_code='$subdivision_code' and  patta_type_code='$p' and "
		. "Cir_code='$circle_code' and Mouza_Pargona_code='$mouza_code' and Lot_No='$lot_code' "
		. "and Vill_townprt_code='$village_code' and TRIM(patta_no)=trim('$pno') order by CAST(coalesce(dag_no_int, '0') AS numeric)";
		$district = $this->db->query($q);
		return $district->result();
	}
	public function getDagforchithalower($district_code, $subdivision_code, $circle_code, $mouza_code, $lot_code, $village_code, $l, $p) {
		$this->dbswitch();
		$district = $this->db->query(""
			. "Select dag_no, dag_no_int from   Chitha_Basic where "
			. "Dist_code='$district_code' and Subdiv_code='$subdivision_code' and  patta_type_code='$p' and "
			. "Cir_code='$circle_code' and Mouza_Pargona_code='$mouza_code' and Lot_No='$lot_code' "
			. "and Vill_townprt_code='$village_code' and CAST(coalesce(dag_no_int, '0') AS numeric)>='$l' order by CAST(coalesce(dag_no_int, '0') AS numeric)");
		return $district->result();
	}
	public function getDagforchithalowerFromOld($district_code, $subdivision_code, $circle_code, $mouza_code, $lot_code, $village_code, $l, $p, $year_no) {
		$this->dbswitch();
		$district = $this->db->query(""
			. "Select dag_no, dag_no_int from   chitha_basic_doul where "
			. "Dist_code='$district_code' and Subdiv_code='$subdivision_code' and  patta_type_code='$p' and "
			. "Cir_code='$circle_code' and Mouza_Pargona_code='$mouza_code' and Lot_No='$lot_code' "
			. "and Vill_townprt_code='$village_code' and year_no = '$year_no' and CAST(coalesce(dag_no_int, '0') AS numeric)>='$l' order by CAST(coalesce(dag_no_int, '0') AS numeric)");
		return $district->result();
	}
	public function getDagforALLchithalower($district_code, $subdivision_code, $circle_code, $mouza_code, $lot_code, $village_code, $l) {
		$this->dbswitch();
		$district = $this->db->query(""
			. "Select dag_no, dag_no_int from   Chitha_Basic where Dist_code='$district_code' and Subdiv_code='$subdivision_code' and "
			. "Cir_code='$circle_code' and Mouza_Pargona_code='$mouza_code' and Lot_No='$lot_code' "
			. "and Vill_townprt_code='$village_code' and CAST(coalesce(dag_no_int, '0') AS numeric)>='$l' order by CAST(coalesce(dag_no_int, '0') AS numeric)");
		return $district->result();
	}
	public function getDagforALLchithalowerFromOld($district_code, $subdivision_code, $circle_code, $mouza_code, $lot_code, $village_code, $l, $year_no) {
		$this->dbswitch();
		$district = $this->db->query(""
			. "Select dag_no, dag_no_int from   chitha_basic_doul where Dist_code='$district_code' and Subdiv_code='$subdivision_code' and "
			. "Cir_code='$circle_code' and Mouza_Pargona_code='$mouza_code' and Lot_No='$lot_code' "
			. "and Vill_townprt_code='$village_code' and year_no = '$year_no' and CAST(coalesce(dag_no_int, '0') AS numeric)>='$l' order by CAST(coalesce(dag_no_int, '0') AS numeric)");
		return $district->result();
	}
	public function getPattaforALLchithalower($district_code, $subdivision_code, $circle_code, $mouza_code, $lot_code, $village_code, $l) {
		$this->dbswitch();
		$district = $this->db->query("Select patta_no from   jama_patta where Dist_code='$district_code' and Subdiv_code='$subdivision_code' and "
			. "Cir_code='$circle_code' and Mouza_Pargona_code='$mouza_code' and Lot_No='$lot_code' "
. "and Vill_townprt_code='$village_code' order by length(patta_no),patta_no");// and patta_no >= '$l'
		return $district->result();
	}
	public function getPattaforchithalower($district_code, $subdivision_code, $circle_code, $mouza_code, $lot_code, $village_code, $l, $p) {
		$this->dbswitch();
		$district = $this->db->query("Select patta_no from   jama_patta where Dist_code='$district_code' and Subdiv_code='$subdivision_code' and  patta_type_code='$p' and "
			. "Cir_code='$circle_code' and Mouza_Pargona_code='$mouza_code' and Lot_No='$lot_code' "
. "and Vill_townprt_code='$village_code' and patta_type_code='$p' order by length(patta_no),patta_no");
		return $district->result();
	}
	public function pattatypeforchitha() {
		$this->dbswitch();
		$district = $this->db->query("Select type_code,patta_type from   patta_code order by type_code asc");
		return $district->result();
	}
	public function getpattatype($patta_code) {
		$this->dbswitch();
		$district = $this->db->query("Select patta_type from   patta_code where type_code='$patta_code'");
		return $district->result();
	}
	public function getchithaDetails($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper, $patta_code) {
		$this->dbswitch();
		$district = $this->db->query("Select cb.old_dag_no,cb.dag_no,cb.patta_no,cb.dag_area_b,cb.dag_area_k,cb.dag_area_lc,cb.dag_revenue,cb.dag_local_tax,lcc.land_type "
			. "from   chitha_basic AS cb JOIN landclass_code AS lcc ON cb.land_class_code = lcc.class_code "
			. "where Dist_code='$district_code' and Subdiv_code='$subdivision_code' and Cir_code='$circlecode' "
			. "and Mouza_Pargona_code='$mouzacode' and Lot_No='$lot_code' and Vill_townprt_code='$village_code'  "
			. "and dag_no >='$dag_no_lower' and dag_no <= '$dag_no_upper' and patta_type_code='$patta_code'");
		return $district->result();
	}
	public function getchithaDetails2($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper) {
		$this->dbswitch();
		$district = $this->db->query("Select cb.old_dag_no,cb.dag_no_int,cb.dag_no,cb.patta_no,cb.patta_type_code,cb.dag_area_b,cb.dag_area_k,cb.dag_area_lc,cb.dag_revenue,cb.dag_local_tax,lcc.land_type,pc.patta_type "
			. "from   chitha_basic AS cb JOIN landclass_code AS lcc ON cb.land_class_code = lcc.class_code JOIN patta_code AS pc ON cb.patta_type_code = pc.type_code "
			. "where Dist_code='$district_code' and Subdiv_code='$subdivision_code' and Cir_code='$circlecode' "
			. "and Mouza_Pargona_code='$mouzacode' and Lot_No='$lot_code' and Vill_townprt_code='$village_code'  "
			. "and cb.dag_no_int >='$dag_no_lower' and cb.dag_no_int <= '$dag_no_upper' order by CAST(coalesce(cb.dag_no_int, '0') AS numeric)");
		return $district->result();
	}
	public function getLmNotes($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no) {
		$this->dbswitch();
		$query = "select * from  chitha_rmk_lmnote where dist_code='$district_code' " .
		" and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no='$dag_no' ";
		$lmnotes = $this->db->query($query)->result();
		return $lmnotes;
	}
	function landClass($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no){
		$query = "select * from  land_class_updates where dist_code=?  and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? ";
		$landClassRemark = $this->db->query($query,[$district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no])->row();
		// echo $this->db->last_query();
		return $landClassRemark;
	}
	public function getCol31($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no) {
	$data[] = array();
	$innerquery26 = "select  dag_no,rmk_type_code,rmk_type_hist_no from   chitha_rmk_gen where  "
	. "dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and"
	. " (dag_no ='$dag_no') order by rmk_type_hist_no";
	$innerdata26 = $this->db->query($innerquery26)->result();
	foreach ($innerdata26 as $rmkGen) {
		$dagnoRemarkgen = $rmkGen->dag_no;
		$rmk_type_code = $rmkGen->rmk_type_code;
		$rmk_type_hist_no = $rmkGen->rmk_type_hist_no;
		if ($rmk_type_code == "01") 
		{
			$innerquery27 = " select dag_no,ord_date,ord_no,case_no,ord_passby_desig,lm_code,co_code,ord_type_code,"
			. " ord_ref_let_no,co_ord_date,new_dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,m_dag_area_g,user_code,operation,strike_order,rural_urban,full_partial,rtps_no ,rtps_app_date,old_dag_area_b,old_dag_area_k,old_dag_area_lc,old_dag_area_g,ord_impli_flag,full_dag,partial_pay_status   "
			. " from   chitha_rmk_ordbasic where  dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code'"
			. " and (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no' order by ord_cron_no ";
			$innerdata27 = $this->db->query($innerquery27)->result();
			foreach ($innerdata27 as $chitharmk_ord_basic) 
			{
				$dag_no_orderbasic = $chitharmk_ord_basic->ord_date;
				$order_date = $chitharmk_ord_basic->ord_date;
				$ord_no = $chitharmk_ord_basic->ord_no;
				$case_no = $chitharmk_ord_basic->case_no;
				$ord_passby_desig = $chitharmk_ord_basic->ord_passby_desig;
				$lm_code = $chitharmk_ord_basic->lm_code;
				$co_code = $chitharmk_ord_basic->co_code;
				$user_code = $chitharmk_ord_basic->user_code;
				$operation = $chitharmk_ord_basic->operation;
				$order_passby_designation = $chitharmk_ord_basic->ord_passby_desig;
				$ord_type_code = $chitharmk_ord_basic->ord_type_code;
				$ord_ref_let_no = $chitharmk_ord_basic->ord_ref_let_no;
				$co_ord_date = $chitharmk_ord_basic->co_ord_date;
				$new_dag_no = $chitharmk_ord_basic->new_dag_no;
				$m_dag_area_b = $chitharmk_ord_basic->m_dag_area_b;
				$m_dag_area_k = $chitharmk_ord_basic->m_dag_area_k;
				$m_dag_area_lc = $chitharmk_ord_basic->m_dag_area_lc;
				$m_dag_area_g = $chitharmk_ord_basic->m_dag_area_g;
				$strike_order = $chitharmk_ord_basic->strike_order;
				$rural_urban = $chitharmk_ord_basic->rural_urban;
				$full_partial = $chitharmk_ord_basic->full_partial;
				$rtps_no = $chitharmk_ord_basic->rtps_no;
				$rtps_app_date = $chitharmk_ord_basic->rtps_app_date;
				$old_dag_area_b = $chitharmk_ord_basic->old_dag_area_b;
				$old_dag_area_k = $chitharmk_ord_basic->old_dag_area_k;
				$old_dag_area_lc = $chitharmk_ord_basic->old_dag_area_lc;
				$old_dag_area_g = $chitharmk_ord_basic->old_dag_area_g;
				$ord_impli_flag = $chitharmk_ord_basic->ord_impli_flag;
				$full_dag = $chitharmk_ord_basic->full_dag;
				$partial_pay_status = $chitharmk_ord_basic->partial_pay_status;
				if($chitharmk_ord_basic->operation == 'B'){
					$get_designation = $this->db->query("select lm_name as designation from  lm_code "
						. "where lm_code = '$order_passby_designation' and dist_code='$district_code' "
						. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
						. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code'")->row()->designation;
				} else {
					$query = $this->db->query("
                        SELECT user_desig_as AS designation
                        FROM master_user_designation
                        WHERE user_desig_code = ?", [$order_passby_designation]);

                    $row = $query->row();
                    $get_designation = $row ? $row->designation : null;
				}
				if ($ord_type_code == '01') 
				{
					$innerquery28 = " select patta_no,new_patta_type FROM chitha_rmk_convorder where dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
					. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
					. "and (dag_no ='$new_dag_no' or new_dag_no='$new_dag_no') and "
					. "rmk_type_hist_no='$rmk_type_hist_no' ";
					$innerdata28 = $this->db->query($innerquery28)->result();
					$patta_no = "";
					$patta_type_code = "";
					$patta_type = "";
					$premium = "";
					$premi_chal_recpt_no = "";
					$premi_chal_recpt = "";
					$dag_no = "";
					$new_patta_no = "";
					$new_dag_no = "";
					$ord_onbehalf_of = "";
					$land_area_b = "";
					$land_area_k = "";
					$land_area_lc = "";
					$land_area_g = "";
					$username = "";
					$lm_name = "";
					$dag_no = "";
					$new_patta_no = "";
					$new_dag_no = "";
					$ord_onbehalf_of = "";
					$chalan_name = "";
					foreach ($innerdata28 as $rmkconvorder) {
						$patta_no = trim($rmkconvorder->patta_no);
						$patta_type_code = $rmkconvorder->new_patta_type;
						$innerquery29 = "select patta_type FROM patta_code where type_code='$patta_type_code'";
						$innerdata29 = $this->db->query($innerquery29)->result();
						foreach ($innerdata29 as $pattatype) {
							$patta_type = $pattatype->patta_type;
						}
					}
					$innerquery30 = "select distinct (premium) as premium,premi_chal_recpt_no "
					. "FROM chitha_rmk_convorder where dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
					. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and "
					. "vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') "
					. "and rmk_type_hist_no='$rmk_type_hist_no' and premium is not null order by premi_chal_recpt_no";
					$innerdata30 = $this->db->query($innerquery30)->result();
					foreach ($innerdata30 as $premiuminfo) {
						$premium = $premiuminfo->premium;
						$premi_chal_recpt_no = $premiuminfo->premi_chal_recpt_no;
						$innerquery31 = "select chalan_name from   premium_chalan_receipt where code='$premi_chal_recpt'";
						$innerdata31 = $this->db->query($innerquery31)->result();
						foreach ($innerdata31 as $premiumchalanrecpt) {
							$chalan_name = $premiumchalanrecpt->chalan_name;
						}
					}
					$innerquery32 = "select premi_chal_recpt, dag_no,new_patta_no,new_dag_no,ord_onbehalf_of FROM Chitha_rmk_Convorder where"
					. " dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
					. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code'"
					. " and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and "
					. " rmk_type_hist_no='$rmk_type_hist_no'  ";
					$innerdata32 = $this->db->query($innerquery32)->result();
					$applicants = array();
					foreach ($innerdata32 as $rmk_conv) {
						$premi_chal_recpt = $rmk_conv->premi_chal_recpt;
						$dag_no = $rmk_conv->dag_no;
						$new_patta_no = trim($rmk_conv->new_patta_no);
						$new_dag_no = $rmk_conv->new_dag_no;
						$ord_onbehalf_of = $rmk_conv->ord_onbehalf_of;
						$innerquery33 = "select land_area_b as land_area_b,land_area_k as land_area_k,land_area_lc as "
						. "land_area_lc,land_area_g as land_area_g from   chitha_rmk_convorder where dist_code='$district_code' "
						. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
						. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
						. "and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";
						$innerdata33 = $this->db->query($innerquery33)->result();
						foreach ($innerdata33 as $bklconvorder) {
							$land_area_b = $bklconvorder->land_area_b;
							$land_area_k = $bklconvorder->land_area_k;
							$land_area_lc = $bklconvorder->land_area_lc;
							$land_area_g = $bklconvorder->land_area_g;
						}
						$applicants[] = array(
							'app_name' => $ord_onbehalf_of,
							'dag_no' => $dag_no,
							'new_dag_no' => $new_dag_no,
							'new_patta_no' => $new_patta_no,
						);
					}
					$innerquery34 = "select lm_name FROM  lm_code where dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
					. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code'";
					$innerdata34 = $this->db->query($innerquery34)->result();
					foreach ($innerdata34 as $lminfo) {
						$lm_name = $lminfo->lm_name;
					}
					$innerquery35 = " select username,status FROM users where dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";
					$innerdata35 = $this->db->query($innerquery35)->result();
					foreach ($innerdata35 as $userinfo) {
						$username = $userinfo->username;
					}
					if (($premi_chal_recpt != null) && (strlen($premi_chal_recpt) == 3)) {
						$PremiumType35 = "select chalan_name FROM premium_chalan_receipt where code ='$premi_chal_recpt'";
						$PremiumType35 = $this->db->query($PremiumType35)->result();
						foreach ($PremiumType35 as $ptype) {
							$premium_type = $ptype->chalan_name;
						}
					} else {
						$premium_type = '';
					}
					$data[] = array(
						'patta_no' => $patta_no,
						'premi_chal_name' => $premium_type,
						'patta_type_code' => $patta_type_code,
						'patta_type' => $patta_type,
						'premium' => $premium,
						'premi_chal_recpt_no' => $premi_chal_recpt_no,
						'premi_chal_recpt' => $premi_chal_recpt,
						'dag_no' => $dag_no,
						'new_patta_no' => $new_patta_no,
						'new_dag_no' => $new_dag_no,
						'ord_onbehalf_of' => $applicants,
						'land_area_b' => $land_area_b,
						'land_area_k' => $land_area_k,
						'land_area_lc' => $land_area_lc,
						'land_area_g' => $land_area_g,
						'username' => $username,
						'lm_name' => $lm_name,
						'dag_no' => $dag_no,
						'new_patta_no' => $new_patta_no,
						'new_dag_no' => $new_dag_no,
						'chalan_name' => $chalan_name,
						'remark_type_code' => $rmk_type_code,
						'ord_type_code' => '01',
						'ord_no' => $ord_no,
						'case_no' => $case_no,
						'order_date' => $order_date,
						'co_code' => $co_code,
						'ord_passby_desig' => $get_designation
					);
				}
				if ($ord_type_code == "02") {
					$innerquery36 = "select ord_date,dag_no,ord_ref_let_no,allottee_name,allottee_land_code,allottee_land_b,allottee_land_k,allottee_land_lc from   chitha_rmk_allottee  where dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
					. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen' and new_dag_no='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";
					$innerdata36 = $this->db->query($innerquery36)->result();
					$ord_date = "";
					$dag_no = "";
					$ord_ref_let_no = "";
					$allottee_name = "";
					$allottee_land_code = "";
					$allottee_land_b = "";
					$allottee_land_k = "";
					$allottee_land_lc = "";
					$type = "";
					$lm_name = "";
					$status = "";
					foreach ($innerdata36 as $allotee) {
						$ord_date = $allotee->ord_date;
						$dag_no = $allotee->dag_no;
						$ord_ref_let_no = $allotee->ord_ref_let_no;
						$allottee_name = $allotee->allottee_name;
						$allottee_land_code = $allotee->allottee_land_code;
						$allottee_land_b = $allotee->allottee_land_b;
						$allottee_land_k = $allotee->allottee_land_k;
						$allottee_land_lc = $allotee->allottee_land_lc;
						$allottee_land_g = $allotee->allottee_land_g;
						$innerquery37 = "select  type from    ord_on_gl_type_code where type_code='$allottee_land_code'";
						$innerdata37 = $this->db->query($innerquery37)->result();
						foreach ($innerdata37 as $ord_on_typ) {
							$type = $ord_on_typ->type;
						}
					}
					$innerquery38 = "select lm_name FROM  lm_code where dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
					. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";
					$innerdata38 = $this->db->query($innerquery38)->result();
					foreach ($innerdata38 as $lminfo) {
						$lm_name = $lminfo->lm_name;
					}
					$innerquery39 = " select username,status FROM users where dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";
					$innerdata39 = $this->db->query($innerquery39)->result();
					foreach ($innerdata39 as $userinfo) {
						$username = $userinfo->username;
					}
					$data[] = array(
						'ord_date' => $ord_date,
						'dag_no' => $dag_no,
						'ord_ref_let_no' => $ord_ref_let_no,
						'allottee_name' => $allottee_name,
						'allottee_land_code' => $allottee_land_code,
						'allottee_land_b' => $allottee_land_b,
						'allottee_land_k' => $allottee_land_k,
						'allottee_land_lc' => $allottee_land_lc,
						'allottee_land_g' => $allottee_land_g,
						'username' => $username,
						'status' => $status,
						'lm_name' => $lm_name
					);
				}
				if ($ord_type_code == "03") {
					$innerquery40 = "SELECT inplace_of_name FROM  chitha_rmk_inplace_of  where dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
					. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";
					$innerdata40 = $this->db->query($innerquery40)->result();
					$by_right_of = "";
					$infavor_of_corrected_name = "";
					$infavor_of_name = "";
					$reg_deal_no = "";
					$reg_date = "";
					$new_dag_no = "";
					$new_patta_no = "";
					$inplace_of_name = "";
					$alongwithname = "";
					$lm_name = "";
					$status = "";
					$username = "";
					foreach ($innerdata40 as $inplace) {
						$inplace_of_name = $inplace->inplace_of_name;
					}
					$innerquery41 = "select alongwith_name  FROM  chitha_rmk_alongwith where  dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
					. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";
					$innerdata41 = $this->db->query($innerquery41)->result();
					$alongwitharray = array();
					foreach ($innerdata41 as $alongwith) {
						$alongwithname = $alongwith->alongwith_name;
						$alongwitharray[] = array(
							'alongwithname' => $alongwithname
						);
					}
					$innerquery41 = "select inplace_of_name  FROM  chitha_rmk_inplace_of where  dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
					. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";
					$innerdata46 = $this->db->query($innerquery41)->result();
					$inplaceofarray = array();
					foreach ($innerdata46 as $inplace) {
						$inplace_of_name = $inplace->inplace_of_name;
						$inplaceofarray[] = array(
							'inplace_of_name' => $inplace_of_name
						);
					}
					$innerquery42 = "select by_right_of,infavor_of_corrected_name,infavor_of_name,reg_deal_no,reg_date,new_dag_no,"
					. " new_patta_no  from   chitha_rmk_infavor_of where dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
					. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and "
					. " vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' "
					. " and rmk_type_hist_no='$rmk_type_hist_no'"
					. " and ord_no= '$ord_no' ";
					
					$innerdata42 = $this->db->query($innerquery42)->result();
					$infav = array();
					foreach ($innerdata42 as $infav_of) {
						$by_right_of = $infav_of->by_right_of;
						$infavor_of_corrected_name = $infav_of->infavor_of_corrected_name;
						$infavor_of_name = $infav_of->infavor_of_name;
						$reg_deal_no = $infav_of->reg_deal_no;
						$reg_date = $infav_of->reg_date;
						$new_dag_no = $infav_of->new_dag_no;
						$new_patta_no = trim($infav_of->new_patta_no);
						$infav[] = array(
							'infavor_of_corrected_name' => $infav_of->infavor_of_corrected_name,
							'infavor_of_name' => $infav_of->infavor_of_name
						);
					}
					//infav query bracket
					$innerquery43 = "select lm_name FROM  lm_code where dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
					. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$chitharmk_ord_basic->lm_code'";
					$innerdata43 = $this->db->query($innerquery43)->result();
					foreach ($innerdata43 as $lminfo) {
						$lm_name = $lminfo->lm_name;
					}
					$innerquery44 = " select username,status FROM users where dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";
					$innerdata44 = $this->db->query($innerquery44)->result();
					foreach ($innerdata44 as $userinfo) {
						$username = $userinfo->username;
						$status = $userinfo->status;
					}
					$innerquery45 = "select m_dag_area_b,m_dag_area_k,m_dag_area_lc,m_dag_area_g from   chitha_rmk_ordbasic "
					. " where dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
					. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and ord_no='$ord_no' and dag_no='$dagnoRemarkgen' ";
					$m_area = $this->db->query($innerquery45)->row();
					$m_area_b = $m_area->m_dag_area_b;
					$m_area_k = $m_area->m_dag_area_k;
					$m_area_lc = $m_area->m_dag_area_lc;
					$m_area_g = $m_area->m_dag_area_g;
					$co_name = "select username from   users where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code='$user_code'";
					$co_name = $this->db->query($co_name)->result();
					foreach ($co_name as $co) {
						$co_username = $co->username;
					}
					$data[] = array(
						'by_right_of' => $by_right_of,
						'infav' => $infav,
						'reg_deal_no' => $reg_deal_no,
						'reg_date' => $reg_date,
						'new_dag_no' => $new_dag_no,
						'new_patta_no' => $new_patta_no,
						'username' => $username,
						'status' => $status,
						'lm_name' => $lm_name,
						'alongwith_name' => $alongwitharray,
						'inplace_of_name' => $inplaceofarray,
						'bigha' => $m_area_b,
						'katha' => $m_area_k,
						'lessa' => $m_area_lc,
						'ganda' => $m_area_g,
						'remark_type_code' => $rmk_type_code,
						'ord_type_code' => $ord_type_code,
						'ord_no' => $ord_no,
						'order_date' => $order_date,
						'co_name' => $co_username,
						'operation' => $operation,
						'strikeout' => $strike_order,
					);
				}
				if ($ord_type_code == "04") {
					$innerquery45 = "select by_right_of,infavor_of_corrected_name,infavor_of_name,reg_deal_no,reg_date,new_dag_no,new_patta_no  from   chitha_rmk_infavor_of where dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
					. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no' and ord_no= '$ord_no' ";
					$innerdata45 = $this->db->query($innerquery45)->result();
					$by_right_of = "";
					$infavor_of_corrected_name = "";
					$infavor_of_name = "";
					$reg_deal_no = "";
					$reg_date = "";
					$new_dag_no = "";
					$new_patta_no = "";
					$infav = array();
					foreach ($innerdata45 as $infav_of) {
						$by_right_of = $infav_of->by_right_of;
						$infavor_of_corrected_name = $infav_of->infavor_of_corrected_name;
						$infavor_of_name = $infav_of->infavor_of_name;
						$reg_deal_no = $infav_of->reg_deal_no;
						$reg_date = $infav_of->reg_date;
						$new_dag_no = $infav_of->new_dag_no;
						$new_patta_no = trim($infav_of->new_patta_no);
						$infav[] = array(
							'infavor_of_corrected_name' => $infav_of->infavor_of_corrected_name,
							'infavor_of_name' => $infav_of->infavor_of_name
						);
					} //infav query bracket
					$innerquery46 = "select lm_name FROM  lm_code where dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
					. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";
					$innerdata46 = $this->db->query($innerquery46)->result();
					$lm_name = "";
					foreach ($innerdata46 as $lminfo) {
						$lm_name = $lminfo->lm_name;
					}
					$innerquery47 = "select username,status FROM users where dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";
					$innerdata47 = $this->db->query($innerquery47)->result();
					$username = "";
					$status = "";
					foreach ($innerdata47 as $userinfo) {
						$username = $userinfo->username;
						$status = $userinfo->status;
					}
					$co_name = "select username from   users where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code='$user_code'";
					$co_name = $this->db->query($co_name)->result();
					foreach ($co_name as $co) {
						$co_username = $co->username;
					}
					$data[] = array(
						'by_right_of' => $by_right_of,
						'infav' => $infav,
						'reg_deal_no' => $reg_deal_no,
						'reg_date' => $reg_date,
						'new_dag_no' => $new_dag_no,
						'new_patta_no' => $new_patta_no,
						'username' => $username,
						'status' => $status,
						'lm_name' => $lm_name,
						'remark_type_code' => $rmk_type_code,
						'ord_type_code' => $ord_type_code,
						'ord_no' => $ord_no,
						'case_no' => $case_no,
						'order_date' => $order_date,
						'co_code' => $co_code,
						'bigha' => $m_dag_area_b,
						'katha' => $m_dag_area_k,
						'lessa' => $m_dag_area_lc,
						'ganda' => $m_dag_area_g,
						'co_name' => $co_username,
						'operation' => $operation
					);
				}
				if ($ord_type_code == "05") {
					$innerquery48 = "select name_for,name_for_land_b,name_for_land_k,name_for_land_lc,name_for_land_g,case_type_code from   chitha_rmk_other_opp_party where dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
					. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen'  and rmk_type_hist_no='$rmk_type_hist_no'";
					$name_for = "";
					$name_for_land_b = "";
					$name_for_land_k = "";
					$name_for_land_lc = "";
					$name_for_land_g = "";
					$case_type_code = "";
					$case_type_name = "";
					$lm_name = "";
					$username = "";
					$status = "";
					$innerdata48 = $this->db->query($innerquery48)->result();
					foreach ($innerdata48 as $opp_party) {
						$name_for = $opp_party->name_for;
						$name_for_land_b = $opp_party->name_for_land_b;
						$name_for_land_k = $opp_party->name_for_land_k;
						$name_for_land_lc = $opp_party->name_for_land_lc;
						$name_for_land_g = $opp_party->name_for_land_g;
						$case_type_code = $opp_party->case_type_code;
						$innerquery49 = "select case_type_name from   case_type_code where case_type_code='$case_type_code'";
						$innerdata49 = $this->db->query($innerquery49)->result();
						foreach ($innerdata49 as $casename) {
							$case_type_name = $casename->case_type_name;
						}
					}
					//lminf for case 5
					$innerquery50 = "select lm_name FROM  lm_code where dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
					. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";
					$innerdata50 = $this->db->query($innerquery50)->result();
					foreach ($innerdata50 as $lminfo) {
						$lm_name = $lminfo->lm_name;
					}
					$innerquery51 = " select username,status FROM users where dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";
					$innerdata51 = $this->db->query($innerquery51)->result();
					foreach ($innerdata51 as $userinfo) {
						$username = $userinfo->username;
						$status = $userinfo->status;
					}
					$data[] = array(
						'name_for' => $name_for,
						'name_for_land_b' => $name_for_land_b,
						'name_for_land_k' => $name_for_land_k,
						'name_for_land_lc' => $name_for_land_lc,
						'name_for_land_g' => $name_for_land_g,
						'case_type_code' => $case_type_code,
						'case_type_name' => $case_type_name,
						'username' => $username,
						'status' => $status,
						'lmname' => $lm_name,
						'remark_type_code' => $rmk_type_code,
						'order_type_code' => $ord_type_code,
					);
				}
				if ($ord_type_code == "06") {
					$innerquery52 = "select ord_date,ord_no,by_right_of,infavor_of_corrected_name,user_code,infavor_of_name,reg_deal_no,reg_date,new_dag_no,new_patta_no  from   chitha_rmk_infavor_of where dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
					. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' " .
					" and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen')  and ord_no= '$ord_no' ";
					$innerdata52 = $this->db->query($innerquery52)->result();
					$by_right_of = "";
					$infavor_of_corrected_name = "";
					$infavor_of_name = "";
					$reg_deal_no = "";
					$reg_date = "";
					$new_dag_no = "";
					$new_patta_no = "";
					foreach ($innerdata52 as $infav_of) {
						$by_right_of = $infav_of->by_right_of;
						$infavor_of_corrected_name = $infav_of->infavor_of_corrected_name;
						$infavor_of_name = $infav_of->infavor_of_name;
						$reg_deal_no = $infav_of->reg_deal_no;
						$reg_date = $infav_of->reg_date;
						$new_dag_no = $infav_of->new_dag_no;
						$new_patta_no = trim($infav_of->new_patta_no);
						$co_code = $infav_of->user_code;
						$ord_date = $infav_of->ord_date;

					} //infav query bracket
					$innerquery53 = "select lm_name FROM  LM_code where dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
					. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code'  ";
					$innerdata53 = $this->db->query($innerquery53)->result();
					$lm_name = "";
					foreach ($innerdata53 as $lminfo) {
						$lm_name = $lminfo->lm_name;
					}
					
					$innerquery54 = "select username,status FROM users where dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";
					$innerdata54 = $this->db->query($innerquery54)->result();
					$username = "";
					$status = "";
					foreach ($innerdata54 as $userinfo) {
						$username = $userinfo->username;
						$status = $userinfo->status;
					}
					$data[] = array(
						'innerdata52' => $innerdata52,
						'by_right_of' => $by_right_of,
						'infavor_of_corrected_name' => $infavor_of_corrected_name,
						'infavor_of_name' => $infavor_of_name,
						'reg_deal_no' => $reg_deal_no,
						'reg_date' => $reg_date,
						'new_dag_no' => $new_dag_no,
						'new_patta_no' => $new_patta_no,
						'username' => $username,
						'status' => $status,
						'lmname' => $lm_name,
						'remark_type_code' => $rmk_type_code,
						'ord_type_code' => $ord_type_code,
						'username' => $username,
						'orderdate' => $ord_date,
						'strikeout' => $strike_order
					);
				}
				if ($ord_type_code == "07") {
					$innerquery52 = "select ord_date,ord_no,by_right_of,user_code,infavor_of_name  from   chitha_rmk_infavor_of where dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
					. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' " .
					" and (dag_no ='$dagnoRemarkgen')  and ord_no= '$ord_no' ";
					$innerdata52 = $this->db->query($innerquery52)->result();
					$by_right_of = "";
					$infavor_of_name = "";
					$name_delete = '';
					foreach ($innerdata52 as $infav_of) {
						$by_right_of = $infav_of->by_right_of;
						$infavor_of_name = $infav_of->infavor_of_name;
						$co_code = $infav_of->user_code;
						$ord_date = $infav_of->ord_date;
					} //infav query bracket
					$ordparty = "Select array_agg(name_for) name_for from   chitha_rmk_other_opp_party where  dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
					. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' " .
					" and (dag_no ='$dagnoRemarkgen')  and ord_no= '$ord_no' ";
					$innerdata59 = $this->db->query($ordparty)->row();
					$name_delete=$innerdata59->name_for;
					$name_delete = str_replace("{", '', $name_delete);
					$name_delete = str_replace("}", '', $name_delete);
					$name_delete = str_replace("\"", '', $name_delete);
					$innerquery53 = "select lm_name FROM  LM_code where dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
					. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code'  ";
					$innerdata53 = $this->db->query($innerquery53)->result();
					$lm_name = "";
					foreach ($innerdata53 as $lminfo) {
						$lm_name = $lminfo->lm_name;
					}
					
					$innerquery54 = "select username,status FROM users where dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";
					$innerdata54 = $this->db->query($innerquery54)->result();
					$username = "";
					$status = "";
					foreach ($innerdata54 as $userinfo) {
						$username = $userinfo->username;
						$status = $userinfo->status;
					}
					$data[] = array(
						'by_right_of' => $by_right_of,
						'order_no' => $ord_no,
						'name_delete' => $name_delete,
						'infavor_of_name' => $infavor_of_name,
						'username' => $username,
						'status' => $status,
						'lmname' => $lm_name,
						'remark_type_code' => $rmk_type_code,
						'ord_type_code' => $ord_type_code,
						'username' => $username,
						'orderdate' => $ord_date
					);
				}
				if(in_array($ord_type_code, [SETTLEMENT_KHAS_LAND_ID,SETTLEMENT_TRIBAL_COMMUNITY_ID,SETTLEMENT_SPECIAL_CULTIVATORS_ID,SETTLEMENT_AP_TRANSFER_ID,SETTLEMENT_TENANT_ID,SETTLEMENT_SVAMITVA])) {
					// echo $ord_type_code;
					if($ord_type_code == SETTLEMENT_AP_TRANSFER_ID){
						$innerqueryKhas="Select *,(select string_agg(concat (surname ||' ' || name ||' (' || relation || ' '|| guard ||')'),',') as name
						from (
						select 
						case  
						when settlement_gender='1' then 'শ্ৰী'
						when settlement_gender='2' then 'শ্ৰীমতী' ELSE
						'NA'
						END as surname,
						settlement_name as name,
						case  
						when settlement_guar_relation='2' then 'পিতৃ'
						when settlement_guar_relation='1' then 'মাতৃ'
						when settlement_guar_relation='3' then 'পতি'
						when settlement_guar_relation='4' then 'পত্নী'
						when settlement_guar_relation='7' then 'অভিভাৱক'
						ELSE
						'NA'
						END as relation,
						settlement_guardian as guard
						from chitha_settlement_allottee where ord_no=? and new_dag=? and rmk_type_hist_no = ?
						) t ) from chitha_settlement_allottee where ord_no=? and dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and (new_dag=?) and rmk_type_hist_no=?";
						$khadData=$this->db->query($innerqueryKhas,array($ord_no,$dagnoRemarkgen,$rmk_type_hist_no,$ord_no,$district_code,$subdivision_code,$circlecode,$mouzacode,$lot_code,$village_code,$dagnoRemarkgen,$rmk_type_hist_no));
					}else{
						if($ord_type_code == SETTLEMENT_TENANT_ID){
							$check=" ";
						}else{
							$check=" and dag_no != old_dag ";
						}
						$innerqueryKhas="Select *,(select string_agg(concat (surname ||' ' || name ||' (' || relation || ' '|| guard ||')'),',') as name
						from (
						select 
						case  
						when settlement_gender='1' then 'শ্ৰী'
						when settlement_gender='2' then 'শ্ৰীমতী' ELSE
						'NA'
						END as surname,
						settlement_name as name,
						case  
						when settlement_guar_relation='2' then 'পিতৃ'
						when settlement_guar_relation='1' then 'মাতৃ'
						when settlement_guar_relation='3' then 'পতি'
						when settlement_guar_relation='4' then 'পত্নী'
						when settlement_guar_relation='7' then 'অভিভাৱক'
						ELSE
						'NA'
						END as relation,
						settlement_guardian as guard
						from chitha_settlement_allottee where ord_no=? and (dag_no=? or old_dag=?) ". $check ."  and rmk_type_hist_no=?
						) t ) from chitha_settlement_allottee where ord_no=? and dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and (dag_no=? or old_dag=?) and rmk_type_hist_no=?";
						$khadData=$this->db->query($innerqueryKhas,array($ord_no,$dagnoRemarkgen,$dagnoRemarkgen,$rmk_type_hist_no,$ord_no,$district_code,$subdivision_code,$circlecode,$mouzacode,$lot_code,$village_code,$dagnoRemarkgen,$dagnoRemarkgen,$rmk_type_hist_no));
						// echo $this->db->last_query();
						$payment_reamining="select sum(sum) as total
							from (select sum(distinct(paid_amount)) from public.chitha_settlement_allottee
							where ord_no=? group by grn_no ) t";
						$total_paid=$this->db->query($payment_reamining,array($ord_no));
						if($total_paid->num_rows()>0)
						{
							$total_paid_amount=$total_paid->row()->total;
						}
					}
					
					// echo $this->db->last_query();
					if($khadData->num_rows()>0){
						$alloteeList=$khadData->row();
						// var_dump($alloteeList);
						// $oldChithaArea=$this->chithaDagArea($district_code,$subdivision_code,$circlecode,$mouzacode,$lot_code,$village_code,$alloteeList->old_dag);
						$data[] = array(
							'order_no' => $ord_no,
							'ord_date' => $alloteeList->ord_date,
							'dag'=>$alloteeList->new_dag,
							'newpatta_no'=>$alloteeList->patta_no,
							'old_dag'=>$alloteeList->old_dag,
							'newpatta_type'=>$alloteeList->new_patta_type=='0201'?'ম্যাদী':$this->utilityclass->getPattaName($alloteeList->new_patta_type),
							'infavor_of_name' => $alloteeList->name,
							'remark_type_code' => $rmk_type_code,
							'ord_type_code' => $ord_type_code,
							'orderdate' => $alloteeList->ord_date,
							'dc_order_date' => $alloteeList->dc_order_date,
							'dc_order_no' => $alloteeList->dc_order_no,
							'dept_order_no' => $alloteeList->dept_order_no,
							'dept_order_date' => $alloteeList->dept_order_date,
							'possession_from' => $alloteeList->possession_from,
							'grn_no' => $alloteeList->grn_no,
							'payment_date' => $alloteeList->payment_date,
							'final_premium_amount' => $alloteeList->final_premium_amount,
							'paid_amount' => $alloteeList->paid_amount,
							'rural_urban' => $rural_urban,
							'full_partial' => $full_partial,
							'partial_pay_status' => $partial_pay_status,
							'full_dag' => $full_dag,
							'mdagareab'=>$m_dag_area_b,
							'mdagareak'=>$m_dag_area_k,
							'mdagarealc'=>number_format($m_dag_area_lc, 2, '.', ''),
							'oldarea_b'=>$old_dag_area_b,
							'oldarea_b'=>$old_dag_area_b,
							'oldarea_k'=>$old_dag_area_k,
							'oldarea_lc'=>number_format($old_dag_area_lc, 2, '.', ''),
							'oldarea_g'=>number_format($old_dag_area_g, 2, '.', ''),
							'rtps_no'=>$rtps_no,
							'home_agri' => $ord_impli_flag,
							'rtps_app_date'=>$rtps_app_date,
							'co_name'=>$this->coName($district_code,$subdivision_code,$circlecode,$alloteeList->user_code),
							'old_dag'=>$alloteeList->old_dag,
							'lm_name'=>$this->lmName($district_code,$subdivision_code,$circlecode,$mouzacode,$lot_code,$alloteeList->lm_code),
							'old_chitha_date' =>$co_ord_date,
							'total_paid_amount' => isset($total_paid_amount) ? $total_paid_amount : 0,
							'khatian_no' =>  $alloteeList->khatian_no,
							'old_patta_no' =>  $alloteeList->old_patta_no,
						);
					}
				}

				if($ord_type_code == SLIJE_ID){
					$innserQueryIns="Select *  from chitha_institute_allottee where case_no=? and dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and 
						lot_no=? and vill_townprt_code=? and (dag_no=? or applied_dag_no=?)";
					$InsData=$this->db->query($innserQueryIns,array($ord_no,$district_code,$subdivision_code,$circlecode,$mouzacode,$lot_code,$village_code,$dagnoRemarkgen,$dagnoRemarkgen));
					// echo $this->db->last_query();
					/////////////////////////////
					if($InsData->num_rows()>0){
						// institute_name,purpose_land_allotment,other_purpose
						$institutionApp= $InsData->row();
						$data[] = array(
							'order_no' =>     $ord_no,
							'ord_date' =>     $institutionApp->date_entry,
							'dag_no'      =>     $institutionApp->dag_no,
							'old_dag'  =>     $institutionApp->applied_dag_no,
							'new_patta_no' => $institutionApp->new_patta_no ?? null,
							'new_patta_type' => $institutionApp->new_patta_type=='0203'?'বিশেষ ম্যাদী': null,
							'infavor_of_name' => $institutionApp->institute_name,
							'purpose' => $institutionApp->purpose_land_allotment,
							'remark_type_code' => $rmk_type_code,
							'ord_type_code' => $ord_type_code,
							'orderdate' =>     $institutionApp->date_entry,
							'dc_order_date' => $institutionApp->dc_order_date,
							'dc_order_no' => $institutionApp->dc_order_no,
							'dept_order_no' => $institutionApp->dept_order_no,
							'dept_order_date' => $institutionApp->dept_order_date,
							'possession_from' => $institutionApp->possession_from,
							'grn_no' => $institutionApp->grn_no,
							'payment_date' => $institutionApp->payment_date,
							'final_premium_amount' => $institutionApp->final_premium_amount,
							'paid_amount' => $institutionApp->paid_amount,
							'rural_urban' => $rural_urban,
							'full_partial' => $full_partial,
							'partial_pay_status' => $partial_pay_status,
							'full_dag' => $full_dag,
							'mdagareab'=>$m_dag_area_b,
							'mdagareak'=>$m_dag_area_k,
							'mdagarealc'=>number_format($m_dag_area_lc, 2, '.', ''),
							'mdagareaganda' => $m_area_g,
							'oldarea_b'=>$old_dag_area_b,
							'oldarea_b'=>$old_dag_area_b,
							'oldarea_k'=>$old_dag_area_k,
							'oldarea_lc'=>number_format($old_dag_area_lc, 2, '.', ''),
							'oldarea_g'=>number_format($old_dag_area_g, 2, '.', ''),
							'rtps_no'=>$rtps_no,
							'is_settlement' => $ord_impli_flag,
							'rtps_app_date'=>$rtps_app_date,
							'co_name'=>$this->coName($district_code,$subdivision_code,$circlecode,$institutionApp->user_code),
							'lm_name'=>$this->lmName($district_code,$subdivision_code,$circlecode,$mouzacode,$lot_code,$lm_code),
							'old_chitha_date' =>$co_ord_date,
							'total_paid_amount' => isset($total_paid_amount) ? $total_paid_amount : 0,
						);
						// var_dump($data);
					}
				}
				if($ord_type_code == RECLASS_ID){
					$innserQueryRecls="Select *,(select string_agg(concat ( name ||' (' || relation || ' '|| guard ||')'),',') as name
						from (
						select 
						pdar_name as name,
						case  
						when pdar_relation='2' then 'পিতৃ'
						when pdar_relation='1' then 'মাতৃ'
						when pdar_relation='3' then 'পতি'
						when pdar_relation='4' then 'পত্নী'
						when pdar_relation='7' then 'অভিভাৱক'
						ELSE
						'NA'
						END as relation,
						pdar_guardian as guard
						from chitha_reclassification_suite  where ord_no=? and dag_no=? and rmk_type_hist_no=?
						) t)  from chitha_reclassification_suite where ord_no=? and dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and 
						lot_no=? and vill_townprt_code=? and (dag_no=? or new_dag_no=?) and rmk_type_hist_no=?";
					$reclsData=$this->db->query($innserQueryRecls,array($ord_no,$dagnoRemarkgen,$rmk_type_hist_no, $ord_no,$district_code,$subdivision_code,$circlecode,$mouzacode,$lot_code,$village_code,$dagnoRemarkgen,$dagnoRemarkgen,$rmk_type_hist_no));
					// echo $this->db->last_query();
					/////////////////////////////
					if($reclsData->num_rows()>0){
						// institute_name,purpose_land_allotment,other_purpose
						$ReclassApp= $reclsData->row();
						$data[] = array(
							'order_no' =>     $ord_no,
							'ord_date' =>     $ReclassApp->date_entry,
							'dag_no'      =>     $ReclassApp->new_dag_no,
							'old_dag'  =>     $ReclassApp->dag_no,
							'new_patta_no' => $ReclassApp->new_patta_no ?? null,
							'pdar_name' => $ReclassApp->name,
							'remark_type_code' => $rmk_type_code,
							'ord_type_code' => $ord_type_code,
							'orderdate' =>     $ReclassApp->date_entry,
							'dc_order_date' => date('Y-m-d',strtotime($ReclassApp->dc_date)),
							'dc_order_no' => $ReclassApp->dc_order_no,
							'dept_order_no' => $ReclassApp->dpt_order_no,
							'dept_order_date' => $ReclassApp->dpt_order_date,
							'grn_no' => $ReclassApp->grn_no,
							'payment_date' => $ReclassApp->payment_date,
							'paid_amount' => $ReclassApp->paid_amount ?? 0,
							'rural_urban' => $rural_urban,
							'full_partial' => $full_partial,
							'full_dag' => $full_dag,
							'mdagareab'=>$m_dag_area_b,
							'mdagareak'=>$m_dag_area_k,
							'mdagarealc'=>number_format($m_dag_area_lc, 2, '.', ''),
							'mdagareaganda' => $m_dag_area_g,
							'oldarea_b'=>$old_dag_area_b,
							'oldarea_b'=>$old_dag_area_b,
							'oldarea_k'=>$old_dag_area_k,
							'oldarea_lc'=>number_format($old_dag_area_lc, 2, '.', ''),
							'oldarea_g'=>number_format($old_dag_area_g, 2, '.', ''),
							'rtps_no'=>$rtps_no,
							'is_settlement' => $ord_impli_flag,
							'rtps_app_date'=>$rtps_app_date,
							'co_name'=>$this->coName($district_code,$subdivision_code,$circlecode,$ReclassApp->user_code),
							'lm_name'=>$this->lmName($district_code,$subdivision_code,$circlecode,$mouzacode,$lot_code,$lm_code),
							'old_chitha_date' =>$co_ord_date,
							'proposed_land_class' =>$this->utilityclass->getLandClassCode($ReclassApp->proposed_land_class),
							'present_land_class' =>$this->utilityclass->getLandClassCode($ReclassApp->present_land_class),
						);
						// var_dump($data);
					}
				}
				if($ord_type_code == RECLASS_HYDRO){
			    $innserQueryRecls="Select *  from chitha_reclassification_suite where ord_no=? and dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and 
			      lot_no=? and vill_townprt_code=? and dag_no=?  and rmk_type_hist_no=?";
			    $reclsData=$this->db->query($innserQueryRecls,array(
			    $ord_no,$district_code,$subdivision_code,$circlecode,$mouzacode,$lot_code,$village_code,
			    $dagnoRemarkgen,$rmk_type_hist_no));
			    // echo $this->db->last_query();
			    /////////////////////////////
			    if($reclsData->num_rows()>0){
			      $ReclassApp= $reclsData->row();
			      $data[] = array(
			        'order_no' =>     $ord_no,
			        'ord_date' =>     date('Y-m-d',strtotime($ReclassApp->date_entry)),
			        'dag_no'      =>     $ReclassApp->new_dag_no,
			        'old_dag'  =>     $ReclassApp->dag_no,
			        'new_patta_no' => $ReclassApp->new_patta_no ?? null,
			        'remark_type_code' => $rmk_type_code,
			        'ord_type_code' => $ord_type_code,
			        'orderdate' =>     $ReclassApp->date_entry,
			        'dept_order_no' => $ReclassApp->dpt_order_no,
			        'dept_order_date' => date('Y-m-d',strtotime($ReclassApp->dpt_order_date)),
			        'grn_no' => $ReclassApp->grn_no,
			        'payment_date' => $ReclassApp->payment_date,
			        'paid_amount' => $ReclassApp->paid_amount ?? 0,
			        'mdagareab'=> $m_dag_area_b,
			        'mdagareak'=> $m_dag_area_k,
			        'mdagarealc'=> number_format($m_dag_area_lc, 2, '.', ''),
			        'mdagareaganda' => $m_dag_area_g,
			        'rtps_no'=> $rtps_no,
			        'is_settlement' => $ord_impli_flag,
			        'rtps_app_date'=>date('Y-m-d',strtotime($rtps_app_date)),
			        'proposed_land_class' =>$this->utilityclass->getLandClassCode($ReclassApp->proposed_land_class),
			        'present_land_class' =>$this->utilityclass->getLandClassCode($ReclassApp->present_land_class),
			      );
			      // var_dump($data);
			    }
			  }
				if($ord_type_code == SERVICE_CONVERSION_MB3){
					
					$innserQueryConv="Select *,(select string_agg(name || ' (' || guard || ')', ',') as name
						from (
						select 
						ord_onbehalf_of as name,
						ord_onbehalf_guard as guard
						from chitha_rmk_convorder  where ord_no=? and (dag_no=? or new_dag_no=?) and rmk_type_hist_no=?
						) t)  from chitha_rmk_convorder where ord_no=? and dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and 
						lot_no=? and vill_townprt_code=? and (dag_no=? or new_dag_no=?) and rmk_type_hist_no=?";
					$convData=$this->db->query($innserQueryConv,array($ord_no,$dagnoRemarkgen,$dagnoRemarkgen,$rmk_type_hist_no, $ord_no,$district_code,$subdivision_code,$circlecode,$mouzacode,$lot_code,$village_code,$dagnoRemarkgen,$dagnoRemarkgen,$rmk_type_hist_no));
					// echo $this->db->last_query();
					/////////////////////////////
					if($convData->num_rows()>0){
						// institute_name,purpose_land_allotment,other_purpose
						$ConvApp= $convData->row();
						$data[] = array(
							'order_no' =>     $ord_no,
							'ord_date' =>     date('Y-m-d',strtotime($ConvApp->date_entry)),
							'dag_no'      =>     $ConvApp->new_dag_no,
							'old_dag'  =>     $ConvApp->dag_no,
							'new_patta_no' => $ConvApp->new_patta_no ?? null,
							'pdar_name' => $ConvApp->name,
							'remark_type_code' => $rmk_type_code,
							'ord_type_code' => $ord_type_code,
							'orderdate' =>     $ConvApp->date_entry,
							'dc_order_date' => date('Y-m-d',strtotime($ConvApp->dc_order_date)),
							'dc_order_no' => $ConvApp->dc_order_no,
							'dept_order_no' => $ConvApp->dpt_order_no,
							'dept_order_date' => $ConvApp->dpt_order_date,
							'grn_no' => $ConvApp->premi_chal_recpt_no,
							'payment_date' => date('Y-m-d',strtotime($ConvApp->payment_date)),
							'paid_amount' => $ConvApp->premium ?? 0,
							'rural_urban' => $rural_urban,
							'full_partial' => $full_partial,
							'full_dag' => $full_dag,
							'mdagareab'=>$m_dag_area_b,
							'mdagareak'=>$m_dag_area_k,
							'mdagarealc'=>number_format($m_dag_area_lc, 2, '.', ''),
							'mdagareaganda' => $m_dag_area_g,
							'oldarea_b'=>$old_dag_area_b,
							'oldarea_b'=>$old_dag_area_b,
							'oldarea_k'=>$old_dag_area_k,
							'oldarea_lc'=>number_format($old_dag_area_lc, 2, '.', ''),
							'oldarea_g'=>number_format($old_dag_area_g, 2, '.', ''),
							'rtps_no'=>$rtps_no,
							'is_settlement' => $ord_impli_flag,
							'rtps_app_date'=>date('Y-m-d',strtotime($rtps_app_date)),
							'co_name'=>$this->coName($district_code,$subdivision_code,$circlecode,$ConvApp->user_code),
							'lm_name'=>$this->lmName($district_code,$subdivision_code,$circlecode,$mouzacode,$lot_code,$lm_code),
							'old_chitha_date' =>$co_ord_date,
						);
						// var_dump($data);
					}
				}
				// echo "<pre>";
				// var_dump($data);
				// die;
				// if ($ord_type_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID) {
				// 	$innerquery52 = "select old_dag,ord_date,ord_no,user_code,array_to_string(ARRAY_AGG (settlement_name),',') as infavor_of_name,patta_no,lm_code  from   chitha_settlement_allottee where dist_code='$district_code'  and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
				// 	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' " .
				// 	" and (dag_no ='$dagnoRemarkgen' )  and ord_no= '$ord_no' group by ord_date,ord_no,user_code,patta_no,old_dag,lm_code ";
				// 	$innerdata52 = $this->db->query($innerquery52)->row();
				// 	$by_right_of = "";
				// 	$infavor_of_name = "";
				// 	$name_delete = '';
				// 	$infavor_of_name = $innerdata52->infavor_of_name;
				// 	$co_code = $innerdata52->user_code;
				// 	$ord_date = $innerdata52->ord_date;
				// 	$newpatta_no = $innerdata52->patta_no;
				// 	$old_dag = $innerdata52->old_dag;
				// 	$innerquery54 = "select username,status FROM users where dist_code='$district_code' "
				// 	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";
				// 	$innerdata54 = $this->db->query($innerquery54)->row();
				// 	$username = "";
				// 		//foreach ($innerdata54 as $userinfo) {
				// 	$username = $innerdata54->username;
				// 		//}
				// 	$innerquery55 = "select lm_name FROM  lm_code where dist_code='$district_code' "
				// 	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
				// 	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";
				// 	$innerdata55 = $this->db->query($innerquery55);
				// 	if($innerdata55->num_rows()>0)
				// 		$lmname = $innerdata55->row()->lm_name;
				// 	else
				// 		$lmname = null;
				// 	$data[] = array(
				// 		'order_no' => $ord_no,
				// 		'dag'=>$dagnoRemarkgen,
				// 		'old_dag'=>$old_dag,
				// 		'newpatta_no'=>$newpatta_no,
				// 		'infavor_of_name' => $infavor_of_name,
				// 		'remark_type_code' => $rmk_type_code,
				// 		'ord_type_code' => $ord_type_code,
				// 		'username' => $username,
				// 		'orderdate' => $ord_date,
				// 		'mdagareab'=>$m_dag_area_b,
				// 		'mdagareak'=>$m_dag_area_k,
				// 		'mdagarealc'=>$m_dag_area_lc,
				// 		'co_name'=>$username,
				// 		'lm_name'=>$lmname
				// 	);
				// }
			}
		}
		//for remark type code 02
		if ($rmk_type_code == '02') {
			$innerquery56 = "select  lm_note,lm_note_date,lm_code FROM  chitha_rmk_lmnote where dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' ORDER BY LM_note_cron_no  ";
			$innerdata56 = $this->db->query($innerquery56)->result();
			foreach ($innerdata56 as $lmnote) {
				$lm_note = $lmnote->lm_note;
				$lm_note_date = $lmnote->lm_note_date;
				$lm_code = $lmnote->lm_code;
			}
		}
		if ($rmk_type_code == '03') {
			$innerquery57 = "SELECT sk_note,sk_note_date FROM chitha_rmk_sknote where  dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' ORDER BY SK_note_cron_no ";
			$innerdata57 = $this->db->query($innerquery57)->result();
			foreach ($innerdata57 as $sknoteinf) {
				$sk_note = $sknoteinf->sk_note;
				$sk_note_date = $sknoteinf->sk_note_date;
			}
		}
		if ($rmk_type_code == '04') {
			$innerquery58 = "SELECT encro_evicted_yn,encro_name FROM  chitha_rmk_encro where dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' ";
			$innerdata58 = $this->db->query($innerquery58)->result();
			foreach ($innerdata58 as $encro) {
				$encro_evicted_yn = $encro->encro_evicted_yn;
				$encro_name = $encro->encro_name;
			}
		}
		//reclassification
		if ($rmk_type_code == '08') {
			$innerquery59 = "SELECT patta_no,patta_type_code,present_land_class,proposed_land_class,proposed_land_revenue,proposed_land_localtax, revenue_diff,"
			. "dc_approval_date, case_no, dag_no FROM   chitha_rmk_reclassification where dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen'";
			$innerdata59 = $this->db->query($innerquery59)->result();
			$get_user_designation = "Select user_code as order_designation from   chitha_rmk_gen where dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen'";
			$str = $this->db->query($get_user_designation)->row()->order_designation;
			$order_designation = preg_replace('#\d.*$#', '', $str);
			$get_designation_name = $this->db->query("Select user_desig_as as user_desig_as from   master_user_designation where user_desig_code = '$order_designation'")->row()->user_desig_as;
			foreach ($innerdata59 as $reclass) {
				$present_class = $this->db->query("Select land_type from   landclass_code where class_code = '$reclass->present_land_class'")->row()->land_type;
				$proposed_class = $this->db->query("Select land_type from   landclass_code where class_code = '$reclass->proposed_land_class'")->row()->land_type;
				$patta_no = trim($reclass->patta_no);
				$patta_type_code = $reclass->patta_type_code;
				$present_land_class = $present_class;
				$proposed_land_class = $proposed_class;
				$proposed_land_revenue = $reclass->proposed_land_revenue;
				$proposed_land_localtax = $reclass->proposed_land_localtax;
				$revenue_diff = $reclass->revenue_diff;
				$dc_approval_date = $reclass->dc_approval_date;
				$remark_type_code = $rmk_type_code;
				$ord_type_code = '00';
				$case_no = $reclass->case_no;
				$dag_no = $reclass->dag_no;
				$data[] = array(
					'patta_no' => $patta_no,
					'patta_type_code' => $patta_type_code,
					'present_land_class' => $present_land_class,
					'proposed_land_class' => $proposed_land_class,
					'proposed_land_revenue' => $proposed_land_revenue,
					'proposed_land_localtax' => $proposed_land_localtax,
					'revenue_diff' => $revenue_diff,
					'dc_approval_date' => $dc_approval_date,
					'remark_type_code' => $remark_type_code,
					'ord_type_code' => $ord_type_code,
					'case_no' => $case_no,
					'dag_no' => $dag_no,
					'order_passed_designation' => $get_designation_name,
				);
			}
		}
		if ($rmk_type_code == '09') {
			$innerquery69 = "select * FROM apt_chitha_rmk_ordbasic as apt,apcancel_dag_details as ap where apt.dist_code='$district_code' "
			. " and apt.subdiv_code='$subdivision_code' and apt.cir_code='$circlecode' and apt.case_no = ap.case_no and"
			. " apt.mouza_pargona_code='$mouzacode' and  apt.lot_no='$lot_code' and apt.vill_townprt_code='$village_code' and apt.dag_no ='$dagnoRemarkgen'";
			$innerdata69 = $this->db->query($innerquery69)->result();
			foreach ($innerdata69 as $apcancel) {
				$patta_no = trim($apcancel->patta_no);
				$order_date = $apcancel->co_ord_date;
				$remark_type_code = $rmk_type_code;
				$ord_type_code = '00';
				$case_no = $apcancel->case_no;
				$dag_no = $apcancel->dag_no;
				$lm_code = $apcancel->lm_code;
				$co_code = $apcancel->co_code;
				$final_date = $apcancel->iscorrected_inco_date;
			}
			$innerqueryLM46 = "select lm_name FROM  lm_code where dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";
			$innerqueryLM46 = $this->db->query($innerqueryLM46)->result();
			$lm_name = "";
			foreach ($innerqueryLM46 as $lminfo) {
				$lm_name = $lminfo->lm_name;
			}
			$innerqueryCO47 = "select username FROM users where dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";
			$innerqueryCO47 = $this->db->query($innerqueryCO47)->row();
			$username = "";
			$apcancel = array(
				'patta_no' => $patta_no,
				'order_date' => $order_date,
				'remark_type_code' => $remark_type_code,
				'ord_type_code' => $ord_type_code,
				'case_no' => $case_no,
				'dag_no' => $dag_no,
				'lm_name' => $lm_name,
				'username' => $innerqueryCO47->username,
				'final_date' => $final_date
			);
			$data['apcancel'] = $apcancel;
		}
		//for remark type code 10
		if ($rmk_type_code == '10') {
			$innerquery59 = "select ord_no,allottee_land_b,allottee_land_k,allottee_land_lc,allottee_land_g,allottee_name,date_entry, old_dag,patta_no,dag_no FROM chitha_rmk_allottee where dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no'  ";
			$innerdata59 = $this->db->query($innerquery59)->result();
			$q = "Select lm_code,co_code from   chitha_rmk_ordbasic WHERE dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' ";
			$lmco = $this->db->query($q)->row();
			$lm_name = $this->utilityclass->getDefinedMondalsName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $lmco->lm_code);
			$username = $this->utilityclass->getSelectedCOName($district_code, $subdivision_code, $circlecode, $lmco->co_code);
			$ord_type_code = 10;
			foreach ($innerdata59 as $allotee) {
				$ord_no = $allotee->ord_no;
				$allottee_land_b = $allotee->allottee_land_b;
				$allottee_land_k = $allotee->allottee_land_k;
				$allottee_land_lc = $allotee->allottee_land_lc;
				$allottee_land_g = $allotee->allottee_land_g;
				$allottee_name = $allotee->allottee_name;
				$date_entry = $allotee->date_entry;
				$olddag = $allotee->old_dag;
				$patta = $allotee->patta_no;
				$dag = $allotee->dag_no;
			}
			$actopp = array(
				'ord_no' => $ord_no,
				'history_no' => $rmk_type_hist_no,
				'old_dag' => $olddag,
				'new_dag' => $dag,
				'new_patta' => $patta,
				'ord_type_code' => $ord_type_code,
				'remark_type_code' => $rmk_type_code,
				'allottee_land_b' => $allottee_land_b,
				'allottee_land_k' => $allottee_land_k,
				'allottee_land_lc' => $allottee_land_lc,
				'allottee_land_g' => $allottee_land_g,
				'allottee_name' => $allottee_name,
				'date_entry' => $date_entry,
				'username' => $username->username,
				'lm_name' => $lm_name->lm_name,
			);
			$data['allotee'] = $actopp;
		}
		//for remark type code 11 settlement

		if ($rmk_type_code == '11') {
			$innerquery59 = "select ord_no,allottee_land_b,allottee_land_k,allottee_land_lc,allottee_land_g,allottee_name,date_entry, old_dag,patta_no,dag_no FROM chitha_rmk_allottee where dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no'  ";
			$innerdata59 = $this->db->query($innerquery59)->result();
			$q = "Select lm_code,co_code from   chitha_rmk_ordbasic WHERE dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' ";
			$lmco = $this->db->query($q)->row();
			$lm_name = $this->utilityclass->getDefinedMondalsName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $lmco->lm_code);
			$username = $this->utilityclass->getSelectedCOName($district_code, $subdivision_code, $circlecode, $lmco->co_code);
			$ord_type_code = 10;
			foreach ($innerdata59 as $allotee) {
				$ord_no = $allotee->ord_no;
				$allottee_land_b = $allotee->allottee_land_b;
				$allottee_land_k = $allotee->allottee_land_k;
				$allottee_land_lc = $allotee->allottee_land_lc;
				$allottee_land_g = $allotee->allottee_land_g;
				$allottee_name = $allotee->allottee_name;
				$date_entry = $allotee->date_entry;
				$olddag = $allotee->old_dag;
				$patta = $allotee->patta_no;
				$dag = $allotee->dag_no;
			}
			$actopp = array(
				'ord_no' => $ord_no,
				'history_no' => $rmk_type_hist_no,
				'old_dag' => $olddag,
				'new_dag' => $dag,
				'new_patta' => $patta,
				'ord_type_code' => $ord_type_code,
				'remark_type_code' => $rmk_type_code,
				'allottee_land_b' => $allottee_land_b,
				'allottee_land_k' => $allottee_land_k,
				'allottee_land_lc' => $allottee_land_lc,
				'allottee_land_g' => $allottee_land_g,
				'allottee_name' => $allottee_name,
				'date_entry' => $date_entry,
				'username' => $username->username,
				'lm_name' => $lm_name->lm_name,
			);
			$data['allotee'] = $actopp;
		}
	}
	return $data;
}
public function getCol31Kar($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no) {
	$this->dbswitch();
	$data[] = array();
	$innerquery26 = "select  dag_no,rmk_type_code,rmk_type_hist_no from   chitha_rmk_gen where  "
	. "dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and"
	. " (dag_no ='$dag_no') order by rmk_type_hist_no";
	//echo $innerquery26;
	$innerdata26 = $this->db->query($innerquery26)->result();
	foreach ($innerdata26 as $rmkGen) {
		$dagnoRemarkgen = $rmkGen->dag_no;
		$rmk_type_code = $rmkGen->rmk_type_code;
		$rmk_type_hist_no = $rmkGen->rmk_type_hist_no;
		if ($rmk_type_code == "01") {
			$innerquery27 = " select dag_no,ord_date,ord_no,case_no,ord_passby_desig,lm_code,co_code,ord_type_code,"
			. " ord_ref_let_no,co_ord_date,new_dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,m_dag_area_g,user_code,operation  "
			. " from   chitha_rmk_ordbasic where  dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code'"
			. " and (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no' order by ord_cron_no ";
	//echo $innerquery27;
			$innerdata27 = $this->db->query($innerquery27)->result();
			foreach ($innerdata27 as $chitharmk_ord_basic) {
				$dag_no_orderbasic = $chitharmk_ord_basic->ord_date;
				$order_date = $chitharmk_ord_basic->ord_date;
				$ord_no = $chitharmk_ord_basic->ord_no;
				$case_no = $chitharmk_ord_basic->case_no;
				$ord_passby_desig = $chitharmk_ord_basic->ord_passby_desig;
				$lm_code = $chitharmk_ord_basic->lm_code;
				$co_code = $chitharmk_ord_basic->co_code;
				$user_code = $chitharmk_ord_basic->user_code;
				$operation = $chitharmk_ord_basic->operation;
				$order_passby_designation = $chitharmk_ord_basic->ord_passby_desig;
				$ord_type_code = $chitharmk_ord_basic->ord_type_code;
				$ord_ref_let_no = $chitharmk_ord_basic->ord_ref_let_no;
				$co_ord_date = $chitharmk_ord_basic->co_ord_date;
				$new_dag_no = $chitharmk_ord_basic->new_dag_no;
				$m_dag_area_b = $chitharmk_ord_basic->m_dag_area_b;
				$m_dag_area_k = $chitharmk_ord_basic->m_dag_area_k;
				$m_dag_area_lc = $chitharmk_ord_basic->m_dag_area_lc;
				$m_dag_area_g = $chitharmk_ord_basic->m_dag_area_g;
				if($chitharmk_ord_basic->operation == 'B'){
					$get_designation = $this->db->query("select lm_name as designation from  lm_code "
						. "where lm_code = '$order_passby_designation' and dist_code='$district_code' "
						. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
						. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code'")->row()->designation;
				} else {
					$get_designation = $this->db->query("select user_desig_as as designation from  master_user_designation "
						. "where user_desig_code = '$order_passby_designation'")->row()->designation;
				}
				if ($ord_type_code == '01') {
					$innerquery28 = " select patta_no,new_patta_type FROM chitha_rmk_convorder where dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
					. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
					. "and (dag_no ='$new_dag_no' or new_dag_no='$new_dag_no') and "
					. "rmk_type_hist_no='$rmk_type_hist_no' ";
	//////echo $innerquery28;
					$innerdata28 = $this->db->query($innerquery28)->result();
	// ////var_dump($innerdata28);
					$patta_no = "";
					$patta_type_code = "";
					$patta_type = "";
					$premium = "";
					$premi_chal_recpt_no = "";
					$premi_chal_recpt = "";
					$dag_no = "";
					$new_patta_no = "";
					$new_dag_no = "";
					$ord_onbehalf_of = "";
					$land_area_b = "";
					$land_area_k = "";
					$land_area_lc = "";
					$land_area_g = "";
					$username = "";
					$lm_name = "";
					$dag_no = "";
					$new_patta_no = "";
					$new_dag_no = "";
					$ord_onbehalf_of = "";
					$chalan_name = "";
					foreach ($innerdata28 as $rmkconvorder) {
						$patta_no = trim($rmkconvorder->patta_no);
						$patta_type_code = $rmkconvorder->new_patta_type;
						$innerquery29 = "select patta_type FROM patta_code where type_code='$patta_type_code'";
						$innerdata29 = $this->db->query($innerquery29)->result();
						foreach ($innerdata29 as $pattatype) {
							$patta_type = $pattatype->patta_type;
						}
					}
					$innerquery30 = "select distinct (premium) as premium,premi_chal_recpt_no "
					. "FROM chitha_rmk_convorder where dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
					. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and "
					. "vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') "
					. "and rmk_type_hist_no='$rmk_type_hist_no' and premium is not null order by premi_chal_recpt_no";
					$innerdata30 = $this->db->query($innerquery30)->result();
					foreach ($innerdata30 as $premiuminfo) {
						$premium = $premiuminfo->premium;
						$premi_chal_recpt_no = $premiuminfo->premi_chal_recpt_no;
	//$premi_chal_recpt = $premiuminfo->premium;
						$innerquery31 = "select chalan_name from   premium_chalan_receipt where code='$premi_chal_recpt'";
						$innerdata31 = $this->db->query($innerquery31)->result();
						foreach ($innerdata31 as $premiumchalanrecpt) {
							$chalan_name = $premiumchalanrecpt->chalan_name;
						}
					}
					$innerquery32 = "select premi_chal_recpt, dag_no,new_patta_no,new_dag_no,ord_onbehalf_of FROM Chitha_rmk_Convorder where"
					. " dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
					. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code'"
					. " and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and "
					. " rmk_type_hist_no='$rmk_type_hist_no'  ";
					$innerdata32 = $this->db->query($innerquery32)->result();
					$applicants = array();
					foreach ($innerdata32 as $rmk_conv) {
						$premi_chal_recpt = $rmk_conv->premi_chal_recpt;
						$dag_no = $rmk_conv->dag_no;
						$new_patta_no = trim($rmk_conv->new_patta_no);
						$new_dag_no = $rmk_conv->new_dag_no;
						$ord_onbehalf_of = $rmk_conv->ord_onbehalf_of;
						$innerquery33 = "select land_area_b as land_area_b,land_area_k as land_area_k,land_area_lc as "
						. "land_area_lc,land_area_g as land_area_g from   chitha_rmk_convorder where dist_code='$district_code' "
						. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
						. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
						. "and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";
	//////echo $innerquery33;
						$innerdata33 = $this->db->query($innerquery33)->result();
						foreach ($innerdata33 as $bklconvorder) {
							$land_area_b = $bklconvorder->land_area_b;
							$land_area_k = $bklconvorder->land_area_k;
							$land_area_lc = $bklconvorder->land_area_lc;
							$land_area_g = $bklconvorder->land_area_g;
						}
						$applicants[] = array(
							'app_name' => $ord_onbehalf_of,
							'dag_no' => $dag_no,
							'new_dag_no' => $new_dag_no,
							'new_patta_no' => $new_patta_no,
						);
					}
					$innerquery34 = "select lm_name FROM  lm_code where dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
					. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code'";
	//echo $innerquery34;
					$innerdata34 = $this->db->query($innerquery34)->result();
	////echo "<br>$innerquery34";
					foreach ($innerdata34 as $lminfo) {
						$lm_name = $lminfo->lm_name;
					}
	/* if(($order_passby_designation == 'DC') || ($order_passby_designation == 'ADC'))
	{
	$innerquery35 = " select username,status FROM users where dist_code='$district_code' "
	. " and subdiv_code='00' and cir_code='00' and user_code ='$co_code'";
	}
	else
	{
	$innerquery35 = " select username,status FROM users where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";
} */
$innerquery35 = " select username,status FROM users where dist_code='$district_code' "
. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";
$innerdata35 = $this->db->query($innerquery35)->result();
foreach ($innerdata35 as $userinfo) {
	$username = $userinfo->username;
}
if (($premi_chal_recpt != null) && (strlen($premi_chal_recpt) == 3)) {
	$PremiumType35 = "select chalan_name FROM premium_chalan_receipt where code ='$premi_chal_recpt'";
	$PremiumType35 = $this->db->query($PremiumType35)->result();
	foreach ($PremiumType35 as $ptype) {
		$premium_type = $ptype->chalan_name;
	//////var_dump($username);
	}
} else {
	$premium_type = '';
}
$data[] = array(
	'patta_no' => $patta_no,
	'premi_chal_name' => $premium_type,
	'patta_type_code' => $patta_type_code,
	'patta_type' => $patta_type,
	'premium' => $premium,
	'premi_chal_recpt_no' => $premi_chal_recpt_no,
	'premi_chal_recpt' => $premi_chal_recpt,
	'dag_no' => $dag_no,
	'new_patta_no' => $new_patta_no,
	'new_dag_no' => $new_dag_no,
	'ord_onbehalf_of' => $applicants,
	'land_area_b' => $land_area_b,
	'land_area_k' => $land_area_k,
	'land_area_lc' => $land_area_lc,
	'land_area_g' => $land_area_g,
	'username' => $username,
	'lm_name' => $lm_name,
	'dag_no' => $dag_no,
	'new_patta_no' => $new_patta_no,
	'new_dag_no' => $new_dag_no,
	'chalan_name' => $chalan_name,
	'remark_type_code' => $rmk_type_code,
	'ord_type_code' => '01',
	'ord_no' => $ord_no,
	'case_no' => $case_no,
	'order_date' => $order_date,
	'co_code' => $co_code,
	'ord_passby_desig' => $get_designation
);
	//var_dump($data);
}
if ($ord_type_code == "02") {
	$innerquery36 = "select ord_date,dag_no,ord_ref_let_no,allottee_name,allottee_land_code,allottee_land_b,allottee_land_k,allottee_land_lc from   chitha_rmk_allottee  where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen' and new_dag_no='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";
	$innerdata36 = $this->db->query($innerquery36)->result();
	$ord_date = "";
	$dag_no = "";
	$ord_ref_let_no = "";
	$allottee_name = "";
	$allottee_land_code = "";
	$allottee_land_b = "";
	$allottee_land_k = "";
	$allottee_land_lc = "";
	$type = "";
	$lm_name = "";
	$status = "";
	foreach ($innerdata36 as $allotee) {
		$ord_date = $allotee->ord_date;
		$dag_no = $allotee->dag_no;
		$ord_ref_let_no = $allotee->ord_ref_let_no;
		$allottee_name = $allotee->allottee_name;
		$allottee_land_code = $allotee->allottee_land_code;
		$allottee_land_b = $allotee->allottee_land_b;
		$allottee_land_k = $allotee->allottee_land_k;
		$allottee_land_lc = $allotee->allottee_land_lc;
		$allottee_land_g = $allotee->allottee_land_g;
		$innerquery37 = "select  type from    ord_on_gl_type_code where type_code='$allottee_land_code'";
		$innerdata37 = $this->db->query($innerquery37)->result();
		foreach ($innerdata37 as $ord_on_typ) {
			$type = $ord_on_typ->type;
		}
	}
	$innerquery38 = "select lm_name FROM  lm_code where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";
	$innerdata38 = $this->db->query($innerquery38)->result();
	foreach ($innerdata38 as $lminfo) {
		$lm_name = $lminfo->lm_name;
	}
	$innerquery39 = " select username,status FROM users where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";
	$innerdata39 = $this->db->query($innerquery39)->result();
	foreach ($innerdata39 as $userinfo) {
		$username = $userinfo->username;
	}
	$data[] = array(
		'ord_date' => $ord_date,
		'dag_no' => $dag_no,
		'ord_ref_let_no' => $ord_ref_let_no,
		'allottee_name' => $allottee_name,
		'allottee_land_code' => $allottee_land_code,
		'allottee_land_b' => $allottee_land_b,
		'allottee_land_k' => $allottee_land_k,
		'allottee_land_lc' => $allottee_land_lc,
		'allottee_land_g' => $allottee_land_g,
		'username' => $username,
		'status' => $status,
		'lm_name' => $lm_name
	);
}
if ($ord_type_code == "03") {
	$innerquery40 = "SELECT inplace_of_name FROM  chitha_rmk_inplace_of  where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";
	$innerdata40 = $this->db->query($innerquery40)->result();
	$by_right_of = "";
	$infavor_of_corrected_name = "";
	$infavor_of_name = "";
	$reg_deal_no = "";
	$reg_date = "";
	$new_dag_no = "";
	$new_patta_no = "";
	$inplace_of_name = "";
	$alongwithname = "";
	$lm_name = "";
	$status = "";
	$username = "";
	foreach ($innerdata40 as $inplace) {
		$inplace_of_name = $inplace->inplace_of_name;
	}
	$innerquery41 = "select alongwith_name  FROM  chitha_rmk_alongwith where  dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";
	$innerdata41 = $this->db->query($innerquery41)->result();
	$alongwitharray = array();
	foreach ($innerdata41 as $alongwith) {
		$alongwithname = $alongwith->alongwith_name;
		$alongwitharray[] = array(
			'alongwithname' => $alongwithname
		);
	}
	$innerquery41 = "select inplace_of_name  FROM  chitha_rmk_inplace_of where  dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no'  ";
	$innerdata46 = $this->db->query($innerquery41)->result();
	$inplaceofarray = array();
	foreach ($innerdata46 as $inplace) {
		$inplace_of_name = $inplace->inplace_of_name;
		$inplaceofarray[] = array(
			'inplace_of_name' => $inplace_of_name
		);
	}
	$innerquery42 = "select by_right_of,infavor_of_corrected_name,infavor_of_name,reg_deal_no,reg_date,new_dag_no,"
	. " new_patta_no  from   chitha_rmk_infavor_of where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and "
	. " vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' "
	. " and rmk_type_hist_no='$rmk_type_hist_no'"
	. " and ord_no= '$ord_no' ";
	//echo $innerquery42;
	$innerdata42 = $this->db->query($innerquery42)->result();
	$infav = array();
	foreach ($innerdata42 as $infav_of) {
		$by_right_of = $infav_of->by_right_of;
		$infavor_of_corrected_name = $infav_of->infavor_of_corrected_name;
		$infavor_of_name = $infav_of->infavor_of_name;
		$reg_deal_no = $infav_of->reg_deal_no;
		$reg_date = $infav_of->reg_date;
		$new_dag_no = $infav_of->new_dag_no;
		$new_patta_no = trim($infav_of->new_patta_no);
		$infav[] = array(
			'infavor_of_corrected_name' => $infav_of->infavor_of_corrected_name,
			'infavor_of_name' => $infav_of->infavor_of_name
		);
	}
	//infav query bracket
	$innerquery43 = "select lm_name FROM  lm_code where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$chitharmk_ord_basic->lm_code'";
	$innerdata43 = $this->db->query($innerquery43)->result();
	foreach ($innerdata43 as $lminfo) {
		$lm_name = $lminfo->lm_name;
	}
	$innerquery44 = " select username,status FROM users where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";
	$innerdata44 = $this->db->query($innerquery44)->result();
	foreach ($innerdata44 as $userinfo) {
		$username = $userinfo->username;
		$status = $userinfo->status;
	}
	$innerquery45 = "select m_dag_area_b,m_dag_area_k,m_dag_area_lc,m_dag_area_g from   chitha_rmk_ordbasic "
	. " where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and ord_no='$ord_no' and dag_no='$dagnoRemarkgen'";
	$m_area = $this->db->query($innerquery45)->row();
	$m_area_b = $m_area->m_dag_area_b;
	$m_area_k = $m_area->m_dag_area_k;
	$m_area_lc = $m_area->m_dag_area_lc;
	$m_area_g = $m_area->m_dag_area_g;
	$co_name = "select username from   users where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code='$user_code'";
	$co_name = $this->db->query($co_name)->result();
	foreach ($co_name as $co) {
		$co_username = $co->username;
	}
	$data[] = array(
		'by_right_of' => $by_right_of,
		'infav' => $infav,
		'reg_deal_no' => $reg_deal_no,
		'reg_date' => $reg_date,
		'new_dag_no' => $new_dag_no,
		'new_patta_no' => $new_patta_no,
		'username' => $username,
		'status' => $status,
		'lm_name' => $lm_name,
		'alongwith_name' => $alongwitharray,
		'inplace_of_name' => $inplaceofarray,
		'bigha' => $m_area_b,
		'katha' => $m_area_k,
		'lessa' => $m_area_lc,
		'ganda' => $m_area_g,
		'remark_type_code' => $rmk_type_code,
		'ord_type_code' => $ord_type_code,
		'ord_no' => $ord_no,
		'order_date' => $order_date,
		'co_name' => $co_username,
		'operation' => $operation
	);
}
if ($ord_type_code == "04") {
	$innerquery45 = "select by_right_of,infavor_of_corrected_name,infavor_of_name,reg_deal_no,reg_date,new_dag_no,new_patta_no  from   chitha_rmk_infavor_of where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen') and rmk_type_hist_no='$rmk_type_hist_no' and ord_no= '$ord_no' ";
	$innerdata45 = $this->db->query($innerquery45)->result();
	$by_right_of = "";
	$infavor_of_corrected_name = "";
	$infavor_of_name = "";
	$reg_deal_no = "";
	$reg_date = "";
	$new_dag_no = "";
	$new_patta_no = "";
	$infav = array();
	foreach ($innerdata45 as $infav_of) {
		$by_right_of = $infav_of->by_right_of;
		$infavor_of_corrected_name = $infav_of->infavor_of_corrected_name;
		$infavor_of_name = $infav_of->infavor_of_name;
		$reg_deal_no = $infav_of->reg_deal_no;
		$reg_date = $infav_of->reg_date;
		$new_dag_no = $infav_of->new_dag_no;
		$new_patta_no = trim($infav_of->new_patta_no);
		$infav[] = array(
			'infavor_of_corrected_name' => $infav_of->infavor_of_corrected_name,
			'infavor_of_name' => $infav_of->infavor_of_name
		);
	} //infav query bracket
	$innerquery46 = "select lm_name FROM  lm_code where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";
	$innerdata46 = $this->db->query($innerquery46)->result();
	$lm_name = "";
	foreach ($innerdata46 as $lminfo) {
		$lm_name = $lminfo->lm_name;
	}
	$innerquery47 = "select username,status FROM users where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";
	$innerdata47 = $this->db->query($innerquery47)->result();
	$username = "";
	$status = "";
	foreach ($innerdata47 as $userinfo) {
		$username = $userinfo->username;
		$status = $userinfo->status;
	}
	$co_name = "select username from   users where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code='$user_code'";
	$co_name = $this->db->query($co_name)->result();
	foreach ($co_name as $co) {
		$co_username = $co->username;
	}
	$data[] = array(
		'by_right_of' => $by_right_of,
		'infav' => $infav,
		'reg_deal_no' => $reg_deal_no,
		'reg_date' => $reg_date,
		'new_dag_no' => $new_dag_no,
		'new_patta_no' => $new_patta_no,
		'username' => $username,
		'status' => $status,
		'lm_name' => $lm_name,
		'remark_type_code' => $rmk_type_code,
		'ord_type_code' => $ord_type_code,
		'ord_no' => $ord_no,
		'case_no' => $case_no,
		'order_date' => $order_date,
		'co_code' => $co_code,
		'bigha' => $m_dag_area_b,
		'katha' => $m_dag_area_k,
		'lessa' => $m_dag_area_lc,
		'ganda' => $m_dag_area_g,
		'co_name' => $co_username,
		'operation' => $operation
	);
}
if ($ord_type_code == "05") {
	$innerquery48 = "select name_for,name_for_land_b,name_for_land_k,name_for_land_lc,name_for_land_g,case_type_code from   chitha_rmk_other_opp_party where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen'  and rmk_type_hist_no='$rmk_type_hist_no'";
	$name_for = "";
	$name_for_land_b = "";
	$name_for_land_k = "";
	$name_for_land_lc = "";
	$name_for_land_g = "";
	$case_type_code = "";
	$case_type_name = "";
	$lm_name = "";
	$username = "";
	$status = "";
	$innerdata48 = $this->db->query($innerquery48)->result();
	foreach ($innerdata48 as $opp_party) {
		$name_for = $opp_party->name_for;
		$name_for_land_b = $opp_party->name_for_land_b;
		$name_for_land_k = $opp_party->name_for_land_k;
		$name_for_land_lc = $opp_party->name_for_land_lc;
		$name_for_land_g = $opp_party->name_for_land_g;
		$case_type_code = $opp_party->case_type_code;
		$innerquery49 = "select case_type_name from   case_type_code where case_type_code='$case_type_code'";
		$innerdata49 = $this->db->query($innerquery49)->result();
		foreach ($innerdata49 as $casename) {
			$case_type_name = $casename->case_type_name;
		}
	}
	//lminf for case 5
	$innerquery50 = "select lm_name FROM  lm_code where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";
	$innerdata50 = $this->db->query($innerquery50)->result();
	foreach ($innerdata50 as $lminfo) {
		$lm_name = $lminfo->lm_name;
	}
	$innerquery51 = " select username,status FROM users where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";
	$innerdata51 = $this->db->query($innerquery51)->result();
	foreach ($innerdata51 as $userinfo) {
		$username = $userinfo->username;
		$status = $userinfo->status;
	}
	$data[] = array(
		'name_for' => $name_for,
		'name_for_land_b' => $name_for_land_b,
		'name_for_land_k' => $name_for_land_k,
		'name_for_land_lc' => $name_for_land_lc,
		'name_for_land_g' => $name_for_land_g,
		'case_type_code' => $case_type_code,
		'case_type_name' => $case_type_name,
		'username' => $username,
		'status' => $status,
		'lmname' => $lm_name,
		'remark_type_code' => $rmk_type_code,
		'order_type_code' => $ord_type_code,
	);
}
if ($ord_type_code == "06") {
	$innerquery52 = "select ord_date,ord_no,by_right_of,infavor_of_corrected_name,user_code,infavor_of_name,reg_deal_no,reg_date,new_dag_no,new_patta_no  from   chitha_rmk_infavor_of where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' " .
	" and (dag_no ='$dagnoRemarkgen' or new_dag_no='$dagnoRemarkgen')  and ord_no= '$ord_no' ";
	$innerdata52 = $this->db->query($innerquery52)->result();
	$by_right_of = "";
	$infavor_of_corrected_name = "";
	$infavor_of_name = "";
	$reg_deal_no = "";
	$reg_date = "";
	$new_dag_no = "";
	$new_patta_no = "";
	foreach ($innerdata52 as $infav_of) {
		$by_right_of = $infav_of->by_right_of;
		$infavor_of_corrected_name = $infav_of->infavor_of_corrected_name;
		$infavor_of_name = $infav_of->infavor_of_name;
		$reg_deal_no = $infav_of->reg_deal_no;
		$reg_date = $infav_of->reg_date;
		$new_dag_no = $infav_of->new_dag_no;
		$new_patta_no = trim($infav_of->new_patta_no);
		$co_code = $infav_of->user_code;
		$ord_date = $infav_of->ord_date;
	} //infav query bracket
	$innerquery53 = "select lm_name FROM  LM_code where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code'  ";
	$innerdata53 = $this->db->query($innerquery53)->result();
	$lm_name = "";
	foreach ($innerdata53 as $lminfo) {
		$lm_name = $lminfo->lm_name;
	}
	//echo $lm_name;
	$innerquery54 = "select username,status FROM users where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";
	$innerdata54 = $this->db->query($innerquery54)->result();
	$username = "";
	$status = "";
	foreach ($innerdata54 as $userinfo) {
		$username = $userinfo->username;
		$status = $userinfo->status;
	}
	$data[] = array(
		'innerdata52' => $innerdata52,
		'by_right_of' => $by_right_of,
		'infavor_of_corrected_name' => $infavor_of_corrected_name,
		'infavor_of_name' => $infavor_of_name,
		'reg_deal_no' => $reg_deal_no,
		'reg_date' => $reg_date,
		'new_dag_no' => $new_dag_no,
		'new_patta_no' => $new_patta_no,
		'username' => $username,
		'status' => $status,
		'lmname' => $lm_name,
		'remark_type_code' => $rmk_type_code,
		'ord_type_code' => $ord_type_code,
		'username' => $username,
		'orderdate' => $ord_date
	);
}
if ($ord_type_code == "07") {
	$innerquery52 = "select ord_date,ord_no,by_right_of,user_code,infavor_of_name  from   chitha_rmk_infavor_of where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' " .
	" and (dag_no ='$dagnoRemarkgen')  and ord_no= '$ord_no' ";
	$innerdata52 = $this->db->query($innerquery52)->result();
	$by_right_of = "";
	$infavor_of_name = "";
	$name_delete = '';
	foreach ($innerdata52 as $infav_of) {
		$by_right_of = $infav_of->by_right_of;
		$infavor_of_name = $infav_of->infavor_of_name;
		$co_code = $infav_of->user_code;
		$ord_date = $infav_of->ord_date;
	} //infav query bracket
	$ordparty = "Select array_agg(name_for) name_for from   chitha_rmk_other_opp_party where  dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' " .
	" and (dag_no ='$dagnoRemarkgen')  and ord_no= '$ord_no' ";
	$innerdata59 = $this->db->query($ordparty)->row();
	$name_delete=$innerdata59->name_for;
	$name_delete = str_replace("{", '', $name_delete);
	$name_delete = str_replace("}", '', $name_delete);
	$name_delete = str_replace("\"", '', $name_delete);
	//var_dump($name_delete);
	// foreach ($innerdata59 as $ordparty) {
	//     $name_delete[] = $ordparty->name_for;
	// } //infav query bracket
	$innerquery53 = "select lm_name FROM  LM_code where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code'  ";
	$innerdata53 = $this->db->query($innerquery53)->result();
	$lm_name = "";
	foreach ($innerdata53 as $lminfo) {
		$lm_name = $lminfo->lm_name;
	}
	//echo $lm_name;
	$innerquery54 = "select username,status FROM users where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";
	$innerdata54 = $this->db->query($innerquery54)->result();
	$username = "";
	$status = "";
	foreach ($innerdata54 as $userinfo) {
		$username = $userinfo->username;
		$status = $userinfo->status;
	}
	$data[] = array(
		'by_right_of' => $by_right_of,
		'order_no' => $ord_no,
		'name_delete' => $name_delete,
		'infavor_of_name' => $infavor_of_name,
		'username' => $username,
		'status' => $status,
		'lmname' => $lm_name,
		'remark_type_code' => $rmk_type_code,
		'ord_type_code' => $ord_type_code,
		'username' => $username,
		'orderdate' => $ord_date
	);
	//var_dump($data);
}
}
}
	//for remark type code 02
if ($rmk_type_code == '02') {
	$innerquery56 = "select  lm_note,lm_note_date,lm_code FROM  chitha_rmk_lmnote where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' ORDER BY LM_note_cron_no  ";
	$innerdata56 = $this->db->query($innerquery56)->result();
	foreach ($innerdata56 as $lmnote) {
		$lm_note = $lmnote->lm_note;
		$lm_note_date = $lmnote->lm_note_date;
		$lm_code = $lmnote->lm_code;
	}
	/*
	$lmnote02 = array(
	'lm_note' => $lm_note,
	'lm_note_date' => $lm_note_date,
	'lm_code' => $lm_code
	);
	$data['lmnote02'] = $lmnote02;
	*/
}
	//
if ($rmk_type_code == '03') {
	$innerquery57 = "SELECT sk_note,sk_note_date FROM chitha_rmk_sknote where  dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' ORDER BY SK_note_cron_no ";
	$innerdata57 = $this->db->query($innerquery57)->result();
	foreach ($innerdata57 as $sknoteinf) {
		$sk_note = $sknoteinf->sk_note;
		$sk_note_date = $sknoteinf->sk_note_date;
	}
}
if ($rmk_type_code == '04') {
	$innerquery58 = "SELECT encro_evicted_yn,encro_name FROM  chitha_rmk_encro where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' ";
	$innerdata58 = $this->db->query($innerquery58)->result();
	foreach ($innerdata58 as $encro) {
		$encro_evicted_yn = $encro->encro_evicted_yn;
		$encro_name = $encro->encro_name;
	}
}
	//reclassification
if ($rmk_type_code == '08') {
	$innerquery59 = "SELECT patta_no,patta_type_code,present_land_class,proposed_land_class,proposed_land_revenue,proposed_land_localtax, revenue_diff,"
	. "dc_approval_date, case_no, dag_no FROM   chitha_rmk_reclassification where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen'";
	$innerdata59 = $this->db->query($innerquery59)->result();
	$get_user_designation = "Select user_code as order_designation from   chitha_rmk_gen where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen'";
	$str = $this->db->query($get_user_designation)->row()->order_designation;
	$order_designation = preg_replace('#\d.*$#', '', $str);
	$get_designation_name = $this->db->query("Select user_desig_as as user_desig_as from   master_user_designation where user_desig_code = '$order_designation'")->row()->user_desig_as;
	foreach ($innerdata59 as $reclass) {
		$present_class = $this->db->query("Select land_type from   landclass_code where class_code = '$reclass->present_land_class'")->row()->land_type;
		$proposed_class = $this->db->query("Select land_type from   landclass_code where class_code = '$reclass->proposed_land_class'")->row()->land_type;
		$patta_no = trim($reclass->patta_no);
		$patta_type_code = $reclass->patta_type_code;
		$present_land_class = $present_class;
		$proposed_land_class = $proposed_class;
		$proposed_land_revenue = $reclass->proposed_land_revenue;
		$proposed_land_localtax = $reclass->proposed_land_localtax;
		$revenue_diff = $reclass->revenue_diff;
		$dc_approval_date = $reclass->dc_approval_date;
		$remark_type_code = $rmk_type_code;
		$ord_type_code = '00';
		$case_no = $reclass->case_no;
		$dag_no = $reclass->dag_no;
		$data[] = array(
			'patta_no' => $patta_no,
			'patta_type_code' => $patta_type_code,
			'present_land_class' => $present_land_class,
			'proposed_land_class' => $proposed_land_class,
			'proposed_land_revenue' => $proposed_land_revenue,
			'proposed_land_localtax' => $proposed_land_localtax,
			'revenue_diff' => $revenue_diff,
			'dc_approval_date' => $dc_approval_date,
			'remark_type_code' => $remark_type_code,
			'ord_type_code' => $ord_type_code,
			'case_no' => $case_no,
			'dag_no' => $dag_no,
			'order_passed_designation' => $get_designation_name,
		);
	}
	//$data['reclass'][] = $reclass;
	//var_dump($data['reclass']);
}
if ($rmk_type_code == '09') {
	$innerquery69 = "select * FROM apt_chitha_rmk_ordbasic as apt,apcancel_dag_details as ap where apt.dist_code='$district_code' "
	. " and apt.subdiv_code='$subdivision_code' and apt.cir_code='$circlecode' and apt.case_no = ap.case_no and"
	. " apt.mouza_pargona_code='$mouzacode' and  apt.lot_no='$lot_code' and apt.vill_townprt_code='$village_code' and apt.dag_no ='$dagnoRemarkgen'";
	$innerdata69 = $this->db->query($innerquery69)->result();
	foreach ($innerdata69 as $apcancel) {
		$patta_no = trim($apcancel->patta_no);
		$order_date = $apcancel->co_ord_date;
		$remark_type_code = $rmk_type_code;
		$ord_type_code = '00';
		$case_no = $apcancel->case_no;
		$dag_no = $apcancel->dag_no;
		$lm_code = $apcancel->lm_code;
		$co_code = $apcancel->co_code;
		$final_date = $apcancel->iscorrected_inco_date;
	}
	$innerqueryLM46 = "select lm_name FROM  lm_code where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";
	$innerqueryLM46 = $this->db->query($innerqueryLM46)->result();
	$lm_name = "";
	foreach ($innerqueryLM46 as $lminfo) {
		$lm_name = $lminfo->lm_name;
	}
	$innerqueryCO47 = "select username FROM users where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code ='$co_code'";
	$innerqueryCO47 = $this->db->query($innerqueryCO47)->row();
	$username = "";
	$apcancel = array(
		'patta_no' => $patta_no,
		'order_date' => $order_date,
		'remark_type_code' => $remark_type_code,
		'ord_type_code' => $ord_type_code,
		'case_no' => $case_no,
		'dag_no' => $dag_no,
		'lm_name' => $lm_name,
		'username' => $innerqueryCO47->username,
		'final_date' => $final_date
	);
	$data['apcancel'] = $apcancel;
}
	//for remark type code 10
if ($rmk_type_code == '10') {
	$innerquery59 = "select ord_no,allottee_land_b,allottee_land_k,allottee_land_lc,allottee_land_g,allottee_name,date_entry, old_dag,patta_no,dag_no FROM chitha_rmk_allottee where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no'  ";
	$innerdata59 = $this->db->query($innerquery59)->result();
	$q = "Select lm_code,co_code from   chitha_rmk_ordbasic WHERE dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' ";
	$lmco = $this->db->query($q)->row();
	//var_dump($lmco);
	$lm_name = $this->utilityclass->getDefinedMondalsName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $lmco->lm_code);
	//var_dump($lm_name);
	$username = $this->utilityclass->getSelectedCOName($district_code, $subdivision_code, $circlecode, $lmco->co_code);
	//var_dump($username);
	$ord_type_code = 10;
	foreach ($innerdata59 as $allotee) {
		$ord_no = $allotee->ord_no;
		$allottee_land_b = $allotee->allottee_land_b;
		$allottee_land_k = $allotee->allottee_land_k;
		$allottee_land_lc = $allotee->allottee_land_lc;
		$allottee_land_g = $allotee->allottee_land_g;
		$allottee_name = $allotee->allottee_name;
		$date_entry = $allotee->date_entry;
		$olddag = $allotee->old_dag;
		$patta = $allotee->patta_no;
		$dag = $allotee->dag_no;
	}
	$actopp = array(
		'ord_no' => $ord_no,
		'history_no' => $rmk_type_hist_no,
		'old_dag' => $olddag,
		'new_dag' => $dag,
		'new_patta' => $patta,
		'ord_type_code' => $ord_type_code,
		'remark_type_code' => $rmk_type_code,
		'allottee_land_b' => $allottee_land_b,
		'allottee_land_k' => $allottee_land_k,
		'allottee_land_lc' => $allottee_land_lc,
		'allottee_land_g' => $allottee_land_g,
		'allottee_name' => $allottee_name,
		'date_entry' => $date_entry,
		'username' => $username->username,
		'lm_name' => $lm_name->lm_name,
	);
	$data['allotee'] = $actopp;
}
	//for remark type code 11
if ($rmk_type_code == '11') {
	$innerquery59 = "select ord_no,allottee_land_b,allottee_land_k,allottee_land_lc,allottee_land_g,allottee_name,date_entry, old_dag,patta_no,dag_no FROM chitha_rmk_allottee where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no'  ";
	$innerdata59 = $this->db->query($innerquery59)->result();
	$q = "Select lm_code,co_code from   chitha_rmk_ordbasic WHERE dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dagnoRemarkgen' and rmk_type_hist_no='$rmk_type_hist_no' ";
	$lmco = $this->db->query($q)->row();
	//var_dump($lmco);
	$lm_name = $this->utilityclass->getDefinedMondalsName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $lmco->lm_code);
	//var_dump($lm_name);
	$username = $this->utilityclass->getSelectedCOName($district_code, $subdivision_code, $circlecode, $lmco->co_code);
	//var_dump($username);
	$ord_type_code = 10;
	foreach ($innerdata59 as $allotee) {
		$ord_no = $allotee->ord_no;
		$allottee_land_b = $allotee->allottee_land_b;
		$allottee_land_k = $allotee->allottee_land_k;
		$allottee_land_lc = $allotee->allottee_land_lc;
		$allottee_land_g = $allotee->allottee_land_g;
		$allottee_name = $allotee->allottee_name;
		$date_entry = $allotee->date_entry;
		$olddag = $allotee->old_dag;
		$patta = $allotee->patta_no;
		$dag = $allotee->dag_no;
	}
	$actopp = array(
		'ord_no' => $ord_no,
		'history_no' => $rmk_type_hist_no,
		'old_dag' => $olddag,
		'new_dag' => $dag,
		'new_patta' => $patta,
		'ord_type_code' => $ord_type_code,
		'remark_type_code' => $rmk_type_code,
		'allottee_land_b' => $allottee_land_b,
		'allottee_land_k' => $allottee_land_k,
		'allottee_land_lc' => $allottee_land_lc,
		'allottee_land_g' => $allottee_land_g,
		'allottee_name' => $allottee_name,
		'date_entry' => $date_entry,
		'username' => $username->username,
		'lm_name' => $lm_name->lm_name,
	);
	$data['allotee'] = $actopp;
}
}
return $data;
}
public function getchithaDetailsALL($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper) {
	//$this->db = $CI->load->database('db', TRUE);
	//$this->dbswitch();
	$this->dbswitch();
	ini_set('max_execution_time', 0);
	$q = "Select cb.old_dag_no, cb.dag_no,cb.dag_no_int,cb.patta_no,cb.dag_area_b,cb.dag_area_k,cb.dag_area_lc,cb.dag_revenue,
	cb.dag_local_tax,lcc.land_type,lcc.class_code from   chitha_basic AS cb JOIN  landclass_code
	AS lcc ON cb.land_class_code = lcc.class_code where Dist_code='$district_code' and Subdiv_code='$subdivision_code'
	and Cir_code='$circlecode'
	and Mouza_Pargona_code='$mouzacode' and Lot_No='$lot_code' and Vill_townprt_code='$village_code'
	and CAST(coalesce(cb.dag_no_int, '0') AS numeric)>=$dag_no_lower and
	CAST(coalesce(cb.dag_no_int, '0') AS numeric)<=$dag_no_upper order by CAST(coalesce(cb.dag_no_int, '0') AS numeric)";
	$district = $this->db->query("
		Select cb.old_dag_no, cb.dag_no,cb.patta_no,cb.patta_type_code,cb.dag_area_b,cb.dag_area_k,cb.dag_area_lc,cb.dag_revenue,
		cb.dag_local_tax,lcc.land_type,lcc.class_code_cat,lcc.class_code  from   chitha_basic AS cb JOIN  landclass_code
		AS lcc ON cb.land_class_code = lcc.class_code where Dist_code='$district_code' and Subdiv_code='$subdivision_code'
		and Cir_code='$circlecode'
		and Mouza_Pargona_code='$mouzacode' and Lot_No='$lot_code' and Vill_townprt_code='$village_code'
		and CAST(coalesce(cb.dag_no_int, '0') AS numeric)>=$dag_no_lower and
		CAST(coalesce(cb.dag_no_int, '0') AS numeric)<=$dag_no_upper order by CAST(coalesce(cb.dag_no_int, '0') AS numeric)");
	//log_message('error',$this->db->last_query());
	$data1 = array();
	$outerdata = $district->result();
	$innerdata = array();
	// $chithadetailsArr = array();
	$innerdata2 = array();
	$innerdata3 = array();
	$innerdata4 = array();
	$innerdata5 = array();
	$innerdata6 = array();
	$innerdata7 = array();
	$innerdata8 = array();
	$innerdata9 = array();
	$innerdata10 = array();
	$innerdata11 = array();
	$innerdata12 = array();
	$innerdata13 = array();
	$innerdata14 = array();
	$innerdata15 = array();
	$innerdata16 = array();
	$innerdata17 = array();
	$innerdata18 = array();
	$innerdata19 = array();
	$innerdata20 = array();
	$innerdata21 = array();
	$innerdata22 = array();
	$innerdata23 = array();
	$innerdata24 = array();
	$innerdata25 = array();
	$innerdata26 = array();
	$relation = array();
	//this is the start of the loop for each dag..
	foreach ($outerdata as $chithadetails) {
		$patta_no = trim($chithadetails->patta_no);
		$dag_no = $chithadetails->dag_no;
		$patta_code = $chithadetails->patta_type_code;
		$backlog_court_order = "select * from   backlog_orders where dist_code='$district_code' and subdiv_code='$subdivision_code' and"
		. " cir_code='$circlecode' and lot_no='$lot_code' and mouza_pargona_code='$mouzacode' and "
		. " vill_townprt_code='$village_code' and dag_no='$dag_no' "
		. " and patta_type_code='$patta_code' and category=0";
		$data_court = $this->db->query($backlog_court_order)->result();
		$backlogquery = "select * from   backlog_orders where dist_code='$district_code' and subdiv_code='$subdivision_code' and"
		. " cir_code='$circlecode' and lot_no='$lot_code' and mouza_pargona_code='$mouzacode' and "
		. " vill_townprt_code='$village_code' and dag_no='$dag_no' "
		. " and patta_type_code='$patta_code' and category=1";
		$data = $this->db->query($backlogquery)->result();
		$backlogquery = "select * from   backlog_orders where dist_code='$district_code' and subdiv_code='$subdivision_code' and"
		. " cir_code='$circlecode' and lot_no='$lot_code' and mouza_pargona_code='$mouzacode' and "
		. " vill_townprt_code='$village_code' and dag_no='$dag_no' "
		. " and patta_type_code='$patta_code' and category=2";
		$dataBacklog31 = $this->db->query($backlogquery)->result();
		$patta_type_name = $this->db->query("Select patta_type as patta_type_name from   patta_code where type_code ='$patta_code'")->row()->patta_type_name;

		
         
        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {       // 
	
			$data1[$dag_no] = array(
				'old_dag_no' => $chithadetails->old_dag_no,
				'dag_no' => $chithadetails->dag_no,
				'patta_no' => trim($chithadetails->patta_no),
				'patta_type_name' => $patta_type_name,
				'dag_area_b' => $chithadetails->dag_area_b,
				'dag_area_k' => $chithadetails->dag_area_k,
				'dag_area_lc' => $chithadetails->dag_area_lc,
				'dag_revenue' => $chithadetails->dag_revenue,
				'dag_localtax' => $chithadetails->dag_local_tax,
				'land_type' => $chithadetails->land_type,
				'class_code_cat' => $chithadetails->class_code_cat,
				// edit for property chain
                'land_type_code' => $chithadetails->class_code,
                ////
			);
		}
		else
		{
				
			$data1[$dag_no] = array(
				'old_dag_no' => $chithadetails->old_dag_no,
				'dag_no' => $chithadetails->dag_no,
				'patta_no' => trim($chithadetails->patta_no),
				'patta_type_name' => $patta_type_name,
				'dag_area_b' => $chithadetails->dag_area_b,
				'dag_area_k' => $chithadetails->dag_area_k,
				'dag_area_lc' => $chithadetails->dag_area_lc,
				'dag_revenue' => $chithadetails->dag_revenue,
				'dag_localtax' => $chithadetails->dag_local_tax,
				'land_type' => $chithadetails->land_type,
				'class_code_cat' => $chithadetails->class_code_cat,
			);	

		}

		$innerquery4 = "select col8order_cron_no,order_type_code,nature_trans_code,mut_land_area_b,mut_land_area_k,mut_land_area_lc,user_code,rajah_adalat,lm_code,case_no,"
		. "co_ord_date,deed_reg_no,deed_value,deed_date,operation,co_code from   Chitha_col8_order where dist_code='$district_code' and subdiv_code='$subdivision_code' "
		. "and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no='$dag_no' ) ";
		$innerdata4 = $this->db->query($innerquery4)->result();
		// this is the start to col8 order details
		foreach ($innerdata4 as $col8OrderDetails) {
			$col8order_cron_no = $col8OrderDetails->col8order_cron_no;
			$order_type_code = $col8OrderDetails->order_type_code;
			$nature_trans_code = $col8OrderDetails->nature_trans_code;
			$mut_land_area_b = $col8OrderDetails->mut_land_area_b;
			$mut_land_area_k = $col8OrderDetails->mut_land_area_k;
			$mut_land_area_lc = $col8OrderDetails->mut_land_area_lc;
			$user_code = $col8OrderDetails->user_code;
			$rajah_adalat = $col8OrderDetails->rajah_adalat;
			$lm_code = $col8OrderDetails->lm_code;
			$case_no = $col8OrderDetails->case_no;
			$co_ord_date = $col8OrderDetails->co_ord_date;
			$deed_value = $col8OrderDetails->deed_value;
			$deed_reg_no = $col8OrderDetails->deed_reg_no;
			$deed_date = $col8OrderDetails->deed_date;
			$co_code = $col8OrderDetails->co_code;
			$operation = $col8OrderDetails->operation;
			$inplace_of_name = "";
			$inplaceof_alongwith = "";
			$occupant_name = "";
			$occupant_fmh_name = "";
			$occupant_fmh_flag = "";
			$new_patta_no = "";
			$new_dag_no = "";
			$hus_wife = "";
			$nature_trans_desc = "";
			$lm_name = "";
			$applicant=$inplaceofName=$alongwith=$tenant_dag="";
			if($order_type_code!=SETTLEMENT_TENANT_ID){
				$innerquery5 = "select order_type from   master_field_mut_type
				where  order_type_code = '$order_type_code' ";
	
				$innerdata5 = $this->db->query($innerquery5)->row();
				$ordertype = $innerdata5->order_type;
			}else{
				$ordertype = null;
			}
			$innerquery6 = "select inplace_of_name,inplaceof_alongwith from   chitha_col8_inplace
			where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' "
			. "and  mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and "
			. " vill_townprt_code='$village_code' and Dag_no='$dag_no' and Col8Order_cron_no='$col8order_cron_no' "
			. " ORDER BY inplace_of_id";
			$innerdata6 = $this->db->query($innerquery6)->result();
			$inplace_data = array();
			$innerquery7 = "select trans_desc_as from   nature_trans_code where trans_code = '$nature_trans_code'";
	
			//$nature_trans_desc = $this->db->query($innerquery7)->row()->trans_desc_as;
			foreach ($innerdata6 as $inplace) {
				$inplace_data[] = array(
					'inplace_of_name' => $inplace->inplace_of_name,
					'inplaceof_alongwith' => $inplace->inplaceof_alongwith,
				);
			}
			$occup_data = array();
			$innerquery8 = "select occupant_name,occupant_fmh_name,occupant_fmh_flag,new_patta_no,new_dag_no,hus_wife from   "
			. " chitha_col8_occup where dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
			. " and (dag_no='$dag_no' or new_dag_no='$dag_no')  and Col8Order_cron_no='$col8order_cron_no' and user_code='$co_code'  ORDER BY occupant_id";
			$innerdata8 = $this->db->query($innerquery8)->result();
			foreach ($innerdata8 as $occupant) {
				$occupant_name = $occupant->occupant_name;
				$occupant_fmh_name = $occupant->occupant_fmh_name;
				$occupant_fmh_flag = $occupant->occupant_fmh_flag;
				$new_patta_no = trim($occupant->new_patta_no);
				$new_dag_no = $occupant->new_dag_no;
				$hus_wife = $occupant->hus_wife;
				$innerquery9 = "select guard_rel_desc_as from   master_guard_rel where guard_rel = '$occupant_fmh_flag'";
				$innerdata9 = $this->db->query($innerquery9)->result();
				$guard_rel_desc_as = "";
				foreach ($innerdata9 as $guard_rel) {
					$guard_rel_desc_as = $guard_rel->guard_rel_desc_as;
				}
				$occup_data[] = array(
					'occupant_name' => $occupant->occupant_name,
					'occupant_fmh_name' => $occupant->occupant_fmh_name,
					'occupant_fmh_flag' => $occupant->occupant_fmh_flag,
					'new_patta_no' => trim($occupant->new_patta_no),
					'new_dag_no' => $occupant->new_dag_no,
					'hus_wife' => $occupant->hus_wife,
					'guard_rel_desc_as' => $guard_rel_desc_as
				);
			}
			$innerquery10 = "select lm_name from   lm_code  where dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code = '$lm_code' ";
	
			$innerdata10 = $this->db->query($innerquery10)->result();
			foreach ($innerdata10 as $lm) {
				$lm_name = $lm->lm_name;
			}
			$innerquery11 = "select username,status from   users where dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code='$user_code'";
			$innerdata11 = $this->db->query($innerquery11)->result();
			foreach ($innerdata11 as $users) {
				$username = $users->username;
				$status = $users->status;
			}
			if ($order_type_code == '03') 
			{
				$innerquery12 = "select * from   field_mut_objection where objection_case_no='$case_no' and  obj_flag is not null and chitha_correct_yn='1' and dist_code='$district_code'
				 and subdiv_code='$subdivision_code' and cir_code='$circlecode' and  
				 mp_code='$mouzacode' and  lot_no='$lot_code' and 
				 vt_code='$village_code' and dag_no='$dag_no' ";
				$innerdata12 = $this->db->query($innerquery12)->result();
				foreach ($innerdata12 as $objection) {
					$q = "select col8order_cron_no,dag_no from   chitha_col8_order where case_no='$objection->prev_fm_ca_no' and dist_code='$district_code'  and subdiv_code='$subdivision_code' and cir_code='$circlecode' and  mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' ";
					$col8_cronNo = $this->db->query($q)->row();
					$q = "select occupant_name from   chitha_col8_occup where dist_code='$district_code' "
					. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
					. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and
					col8order_cron_no='$col8_cronNo->col8order_cron_no' and dag_no='$col8_cronNo->dag_no'  ";
					$result = $this->db->query($q)->result();
					$fname = "";
					foreach ($result as $name) {
						$fname = $fname . $name->occupant_name . ",";
					}
					$data1[$dag_no]['objection'][] = array(
						'mut_type' => $objection->mut_type,
						'regist_date' => $objection->regist_date,
						'objection_case_no' => $objection->objection_case_no,
						'prev_fm_ca_no' => $objection->prev_fm_ca_no,
						'submission_date' => $objection->entry_date,
						'obj_name' => $objection->obj_name,
						'co_id' => $objection->co_id,
						'occupant' => $fname
					);

			}
	//var_dump($data1[$dag_no]['objection']);
}
$innerquery13 = "select * from   field_mut_petitioner where case_no='$case_no' ";
$innerdata13 = $this->db->query($innerquery13)->result();
if ($order_type_code == '01') {
	$innerquery14 = " select deed_reg_no,deed_value,deed_date from   chitha_col8_order
	where Order_type_code='$order_type_code' and dag_no='$dag_no' and case_no='$case_no'";
	
	$innerdata14 = $this->db->query($innerquery14)->result();
	foreach ($innerdata14 as $deedinf) {
		$deed_reg_no = $deedinf->deed_reg_no;
		$deed_value = $deedinf->deed_value;
		$deed_date = $deedinf->deed_date;
	}
}
else if ($order_type_code == '13') {
	$innerquery15 = "select array_to_string(ARRAY_AGG (tenant_name),',') as name,dag_no from   chitha_col8_tenant
	where dag_no='$dag_no' and dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and case_no='$case_no' and pdar_type='B' group by pdar_type,dag_no";
	$applicant = $this->db->query($innerquery15);
	if($applicant->num_rows()>0){
		$applicant=$applicant->row()->name;
		$tenant_dag=$applicant->row()->dag_no;
	}else{
		$applicant=$tenant_dag=null;
	}
	$innerquery15 = "select array_to_string(ARRAY_AGG (tenant_name),',') as name from   chitha_col8_tenant
	where dag_no='$dag_no' and dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and case_no='$case_no' and pdar_type='O' and inplace_alongwith='i' group by pdar_type";
	$inplaceofName = $this->db->query($innerquery15);
	if($inplaceofName->num_rows()>0){
		$inplaceofName=$inplaceofName->row()->name;
	}else{
		$inplaceofName=null;
	}
	$innerquery16 = "select array_to_string(ARRAY_AGG (tenant_name),',') as name from   chitha_col8_tenant
	where dag_no='$dag_no' and dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and case_no='$case_no' and pdar_type='O' and inplace_alongwith='a' group by pdar_type";
	$alongwith = $this->db->query($innerquery16);
	if($alongwith->num_rows()>0){
		$alongwith=$alongwith->row()->name;
	}else{
		$alongwith=null;
	}
}
	// if ($order_type_code == '13') {
	//    $co_name = "select username from   users where dist_code='$district_code' and user_code='$user_code'";
	//    $co_username = $this->db->query($co_name)->row()->username;
	// }else{
$co_name = "select username from   users where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code='$user_code'";
$co_username = $this->db->query($co_name)->row()->username;
	//}
	
if ($order_type_code != '03') {
	$data1[$dag_no]['col8'][] = array(
		'co_ord_date' => $col8OrderDetails->co_ord_date,
		'order_type_code' => $col8OrderDetails->order_type_code,
		'case_no' => $col8OrderDetails->case_no,
		'col8order_cron_no' => $col8OrderDetails->col8order_cron_no,
		'order_type' => $ordertype,
		'nature_trans_code' => $col8OrderDetails->nature_trans_code,
		'mut_land_area_b' => $col8OrderDetails->mut_land_area_b,
		'mut_land_area_k' => $col8OrderDetails->mut_land_area_k,
		'mut_land_area_lc' => $col8OrderDetails->mut_land_area_lc,
		'inplace' => $inplace_data,
		'occup' => $occup_data,
		'rajah' => $rajah_adalat,
		'deed_value' => $deed_value,
		'deed_reg_no' => $deed_reg_no,
		'deed_date' => $deed_date,
		'lm_name' => $lm_name,
		'username' => $co_username,
		'co_name' => $co_username,
		'operation' => $operation,
		'riotee'=>$applicant,
		'inplaceofriotee'=>$inplaceofName,
		'alongwithriotee'=>$alongwith,
		'tenant_dag'=>$tenant_dag
	);
}
}
$data1[$dag_no]['backlog_court_order'][] = $data_court;
$data1[$dag_no]['backlogs'][] = $data;
$data1[$dag_no]['backlogs31'][] = $dataBacklog31;
	// this is the End to col8 order details
$d = $this->getCol31($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no);
$data1[$dag_no]['col31'][] = $d;
$lmnotes = $this->getLmNotes($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no);
$data1[$dag_no]['lmnotes'] = $lmnotes;
//////////Remarks for LandClass//////////////
$data1[$dag_no]['classRemark'] = $this->landClass($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no);
///////////////////////
$innerquery = "select p_flag,pdar_id,patta_no,dag_por_b,dag_por_k,dag_por_lc from   chitha_dag_pattadar where dist_code='$district_code' "
. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
. " and dag_no='$dag_no' and TRIM(patta_no)='$patta_no' and  patta_type_code='$patta_code' order by pdar_id";
$innerdata = $this->db->query($innerquery)->result();
$data1[$dag_no]['pattadars'] = array();
foreach ($innerdata as $data) {
	// $p_flag = $data->p_flag;
	$pdar_id = $data->pdar_id;
	$patta_no = trim($data->patta_no);
	//$data1[$dag_no]['col8'] = array();
	$data1[$dag_no]['tenant'] = array();
	$data1[$dag_no]['subtenant'] = array();
	$innerquery2 = "select pdar_name,pdar_father,new_pdar_name,pdar_guard_reln,pdar_add1,Pdar_add2,Pdar_add3 from   chitha_pattadar where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
	. " and TRIM(patta_no)='$patta_no' and  patta_type_code='$patta_code' and pdar_id=$data->pdar_id order by pdar_id";
	
	$innerdata2 = $this->db->query($innerquery2)->result();
	/* if (!empty($innerdata2)) {
	
	} else {
	
} */
	/* if (!empty($innerdata2)) {
	
	} else {
	
} */
	/* if (!empty($innerdata2)) {
	
	} else {
	
	} */
	foreach ($innerdata2 as $pdardata) {
		$pdar_guardRelation = $pdardata->pdar_guard_reln;
		$innerquery3 = "select guard_rel_desc_as from   master_guard_rel where guard_rel_desc = '$pdar_guardRelation'";
		$innerdata3 = $this->db->query($innerquery3)->result();
		foreach ($innerdata3 as $guard_rel_desc) {
			$relation = $guard_rel_desc->guard_reln_desc_as;
		}
		$data1[$dag_no]['pattadars'][] = array(
			'p_flag' => $data->p_flag,
			'dag_por_b' => $data->dag_por_b,
			'dag_por_k' => $data->dag_por_k,
			'dag_por_lc' => $data->dag_por_lc,
			'pdar_name' => $pdardata->pdar_name,
			'guard_reln_desc_as' => $relation,
			'new_pdar_name' => $pdardata->new_pdar_name,
			'pdar_father' => $pdardata->pdar_father,
			'pdar_relation' => $pdardata->pdar_guard_reln,
			'pdar_address1' => $pdardata->pdar_add1,
			'pdar_address2' => $pdardata->pdar_add2,
			'pdar_address3' => $pdardata->pdar_add3,
			'pdar_guard_reln' => $pdardata->pdar_guard_reln,
			'pdar_id' => $pdar_id
		);
	}
	$innerquery15 = " select tenant_name,tenants_father,tenants_add1,tenants_add2,tenants_add3,type_of_tenant,khatian_no,revenue_tenant,crop_rate,tenant_id,status,p_flag from   chitha_tenant where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no='$dag_no' order by tenant_id";
	$innerdata15 = $this->db->query($innerquery15)->result();
	foreach ($innerdata15 as $tenant)
	{
		if ($tenant->type_of_tenant == null) {
			$tenant_typ = "00";
		} else {
			$tenant_typ = $tenant->type_of_tenant;
		}
		$tenant_name = $tenant->tenant_name;
		$tenants_father = $tenant->tenants_father;
		$tenants_add1 = $tenant->tenants_add1;
		$tenants_add2 = $tenant->tenants_add2;
		$tenants_add3 = $tenant->tenants_add3;
		$type_of_tenant = $tenant_typ;
		$khatian_no = $tenant->khatian_no;
		$status = $tenant->status;
		$revenue_tenant = $tenant->revenue_tenant;
		$crop_rate = $tenant->crop_rate;
		$tenant_id = $tenant->tenant_id;
		if ($tenant->type_of_tenant == null) {
			$tenant_typ = "00";
		} else {
			$tenant_typ = $tenant->type_of_tenant;
		}
		$tenant_name = $tenant->tenant_name;
		$tenants_father = $tenant->tenants_father;
		$tenants_add1 = $tenant->tenants_add1;
		$tenants_add2 = $tenant->tenants_add2;
		$tenants_add3 = $tenant->tenants_add3;
		$type_of_tenant = $tenant_typ;
		$khatian_no = $tenant->khatian_no;
		$status = $tenant->status;
		$revenue_tenant = $tenant->revenue_tenant;
		$crop_rate = $tenant->crop_rate;
		$tenant_id = $tenant->tenant_id;
		if ($tenant->type_of_tenant == "00") {
			$tenant_typ = "";
		} else {
			$tenant_typ = $tenant->type_of_tenant;
		}
		$tenant_name = $tenant->tenant_name;
		$tenants_father = $tenant->tenants_father;
		$tenants_add1 = $tenant->tenants_add1;
		$tenants_add2 = $tenant->tenants_add2;
		$tenants_add3 = $tenant->tenants_add3;
		$type_of_tenant = $tenant_typ;
		$khatian_no = $tenant->khatian_no;
		$status = $tenant->status;
		$revenue_tenant = $tenant->revenue_tenant;
		$crop_rate = $tenant->crop_rate;
		$tenant_id = $tenant->tenant_id;
		$innerquery16 = "Select tenant_type from   Tenant_type where type_code ='$type_of_tenant'";
		$innerdata16 = $this->db->query($innerquery16)->result();
		foreach ($innerdata16 as $tenanttype)
		{
			$tenant_type = $tenanttype->tenant_type;
			$data1[$dag_no]['tenant'][] = array(
				'tenant_name' => $tenant->tenant_name,
				'tenants_father' => $tenant->tenants_father,
				'tenants_add1' => $tenant->tenants_add1,
				'tenants_add2' => $tenant->tenants_add2,
				'tenants_add3' => $tenant->tenants_add3,
				'type_of_tenant' => $tenant->type_of_tenant,
				'khatian_no' => $tenant->khatian_no,
				'status' => $tenant->status,
				'revenue_tenant' => $tenant->revenue_tenant,
				'crop_rate' => $tenant->crop_rate,
				'tenant_type' => $tenanttype->tenant_type,
				'p_flag' => $tenant->p_flag,
			);
		}
		$innerquery17 = "Select subtenant_name,subtenants_father,subtenants_add1,subtenants_add2,subtenants_add3 from   Chitha_Subtenant where  dist_code='$district_code' "
		. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
		. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and Dag_no='$dag_no' and tenant_id = '$tenant_id'";
		$innerdata17 = $this->db->query($innerquery17)->result();
		$subtenant_name = "";
		$subtenants_father = "";
		$subtenants_add1 = "";
		$subtenants_add2 = "";
		$subtenants_add = "";
		foreach ($innerdata17 as $subtenant)
		{
			$subtenant_name = $subtenant->subtenant_name;
			$subtenants_father = $subtenant->subtenants_father;
			$subtenants_add1 = $subtenant->subtenants_add1;
			$subtenants_add2 = $subtenant->subtenants_add2;
			$subtenants_add3 = $subtenant->subtenants_add3;
			$data1[$dag_no]['subtenant'][] = array(
				'subtenant_name' => $subtenant->subtenant_name,
				'subtenants_father' => $subtenant->subtenants_father,
				'subtenants_add1' => $subtenant->subtenants_add1,
				'subtenants_add2' => $subtenant->subtenants_add2,
				'subtenants_add3' => $subtenant->subtenants_add3,
			);
		}
	}
}
$sysyear = date("Y");
	
$data1[$dag_no]['archeo'] = array();
$data1[$dag_no]['noncrp'] = array();
$data1[$dag_no]['mcrp'] = array();
$data1[$dag_no]['fruit'] = array();
$data1[$dag_no]['mcrp_akeadhig'] = array();
$data1[$dag_no]['years'] = array();
$year1 = $sysyear;
$year = ($year1 - 2);
for ($j = 0; $j < 3; $j++) {
	$innerquerynoncrp = "select type_of_used_noncrop,noncrop_land_area_b,noncrop_land_area_k,noncrop_land_area_lc from   chitha_noncrop where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' and yn='$year'";
	$innerdatanoncrp = $this->db->query($innerquerynoncrp)->result();
	foreach ($innerdatanoncrp as $noncrop) {
		$type_of_used_noncrp = $noncrop->type_of_used_noncrop;
		$noncrp_b = $noncrop->noncrop_land_area_b;
		$noncrop_k = $noncrop->noncrop_land_area_k;
		$noncrop_lc = $noncrop->noncrop_land_area_lc;
		$innerquery19 = "select noncrop_type from   used_noncrop_type where used_noncrop_type_code = '$type_of_used_noncrp'";
		$innerdata19 = $this->db->query($innerquery19)->result();
		foreach ($innerdata19 as $noncrptyp) {
			$noncrop_type = $noncrptyp->noncrop_type;
			$data1[$dag_no]['noncrp'][] = array(
				'year' => $year,
				'type_of_used_noncrp' => $noncrop_type,
				'noncrp_b' => $noncrp_b,
				'noncrop_k' => $noncrop_k,
				'noncrop_lc' => $noncrop_lc
			);
		}
	}
	$innerquerycrp = " select source_of_water,crop_code,crop_land_area_b,crop_land_area_k,crop_land_area_lc,crop_categ_code from   chitha_mcrop where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' and yearno='$year' and crop_code<>'057' ";
	$innerdatacrp = $this->db->query($innerquerycrp)->result();
	foreach ($innerdatacrp as $mcropdetails) {
		$source_of_water = $mcropdetails->source_of_water;
		$crop_code = $mcropdetails->crop_code;
		$crop_land_area_b = $mcropdetails->crop_land_area_b;
		$crop_land_area_k = $mcropdetails->crop_land_area_k;
		$crop_land_area_lc = $mcropdetails->crop_land_area_lc;
		$crop_category = $mcropdetails->crop_categ_code;
		$innerquerywatersrc = "select source from   source_water where water_source_code = '$source_of_water'";
		$innerdatawatersrc = $this->db->query($innerquerywatersrc)->result();
		foreach ($innerdatawatersrc as $watersrc) {
			$sourceOFwater = $watersrc->source;
			$innerqueryCropCateg = "select crop_categ_desc from   crop_category_code where crop_categ_code = '$crop_category'";
			$innerdataCropcateg = $this->db->query($innerqueryCropCateg)->result();
			foreach ($innerdataCropcateg as $CropDesc) {
				$CropDesc_inChitha = $CropDesc->crop_categ_desc;
				$innerquerymcrop = "select crop_name from   crop_code where crop_code = '$crop_code'";
				$innerdatamcrop = $this->db->query($innerquerymcrop)->result();
				foreach ($innerdatamcrop as $cropinfo) {
					$cropname = $cropinfo->crop_name;
					$data1[$dag_no]['mcrp'][] = array(
						'sourceofwater' => $sourceOFwater,
						'cropname' => $cropname,
						'mcrp_b' => $crop_land_area_b,
						'mcrop_k' => $crop_land_area_k,
						'mcrop_lc' => $crop_land_area_lc,
						'crop_category' => $CropDesc_inChitha
					);
				}
			}
		}
	}
	$innerquerycrp_ekadhig = " select crop_land_area_b,crop_land_area_k,crop_land_area_lc from   chitha_mcrop where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' and yearno='$year'  ";
	
	$innerdatacrp_ekadhig = $this->db->query($innerquerycrp_ekadhig)->result();
	foreach ($innerdatacrp_ekadhig as $ekadhig)
		$data1[$dag_no]['mcrp_akeadhig'][] = array(
			'bigha' => $ekadhig->crop_land_area_b,
			'katha' => $ekadhig->crop_land_area_k,
			'lesa' => $ekadhig->crop_land_area_lc
		);
	$data1[$dag_no]['years'][] = array(
		'year' => $year
	);
	$year = ($year + 1);
}
$innerquery23 = "select fruit_plants_name,no_of_plants,fruit_land_area_b,fruit_land_area_k,fruit_land_area_lc from   chitha_fruit where dist_code='$district_code' "
. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' ORDER BY Fruit_plant_ID";
$innerdata23 = $this->db->query($innerquery23)->result();
foreach ($innerdata23 as $chithafruitinf) {
	$fruit_plants_name = $chithafruitinf->fruit_plants_name;
	$no_of_fruit_plants = $chithafruitinf->no_of_plants;
	$fruit_bigha = $chithafruitinf->fruit_land_area_b;
	$fruit_katha = $chithafruitinf->fruit_land_area_k;
	$fruit_lesa = $chithafruitinf->fruit_land_area_lc;
	$innerquery24 = "select fruit_name from   fruit_tree_code where fruit_code='$fruit_plants_name'";
	$innerdata24 = $this->db->query($innerquery24)->result();
	foreach ($innerdata24 as $fruitinfo) {
		$fruit_name = $fruitinfo->fruit_name;
		$data1[$dag_no]['fruit'][] = array(
			'fruitname' => $fruit_name,
			'no_of_plants' => $no_of_fruit_plants,
			'fbigha' => $fruit_bigha,
			'fkatha' => $fruit_katha,
			'flesa' => $fruit_lesa
		);
	}
}
$chithaarcheo = "select archeo_hist_code,hist_land_area_b,hist_land_area_k,hist_land_area_lc,archeo_hist_site_desc from   chitha_acho_hist where dist_code='$district_code' "
. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no'";
	
$innerdataarcheo = $this->db->query($chithaarcheo)->result();
	foreach ($innerdataarcheo as $archeoinfo) {
	$archeo_code = $archeoinfo->archeo_hist_code;
	$archeo_area_b = $archeoinfo->hist_land_area_b;
	$archeo_area_k = $archeoinfo->hist_land_area_k;
	$archeo_area_lc = $archeoinfo->hist_land_area_lc;
	$archeo_area_description = $archeoinfo->archeo_hist_site_desc;
	$archeo_siteCd = "select archeo_hist_desc from   archeo_hist_site_code where archeo_hist_code='$archeo_code' ";
	$innerdataarcheo_cd = $this->db->query($archeo_siteCd)->result();
	foreach ($innerdataarcheo_cd as $archeo_cd) {
		$hist_description = $archeo_cd->archeo_hist_desc;
		$data1[$dag_no]['archeo'][] = array(
			'hist_description_nme' => $hist_description,
			'archeo_hist_code' => $archeo_code,
			'archeo_b' => $archeo_area_b,
			'archeo_k' => $archeo_area_k,
			'archeo_lc' => $archeo_area_lc,
			'archeo_decribed' => $archeo_area_description
		);
	}
}
$innerquery58 = "SELECT encro_evicted_yn,encro_name,encro_since,encro_land_b,encro_land_k,encro_land_lc,encro_land_used_for,encro_evic_date FROM  chitha_rmk_encro where  dist_code='$district_code' "
. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' "; //and rmk_type_hist_no='$rmk_type_hist_no' ";
	$innerdata58 = $this->db->query($innerquery58)->result();
	foreach ($innerdata58 as $encro) {
		$encro_land_used_for = $encro->encro_land_used_for;
		$innerquery_encroland = "SELECT used_for from   encro_land_used_for where code='$encro_land_used_for' ";
		$innerdata_encroland = $this->db->query($innerquery_encroland)->result();
		foreach ($innerdata_encroland as $encro_land) {
			$data1[$dag_no]['encro'][] = array(
				'encro_evicted_yn' => $encro->encro_evicted_yn,
				'encro_name' => $encro->encro_name,
				'encro_since' => $encro->encro_since,
				'encro_land_b' => $encro->encro_land_b,
				'encro_land_k' => $encro->encro_land_k,
				'encro_land_lc' => $encro->encro_land_lc,
				'encro_land_used_for' => $encro->encro_land_used_for,
				'encro_evic_date' => $encro->encro_evic_date,
				'land_used_by_encro' => $encro_land->used_for
			);
		}
	}
	//sro note
	//////////////////////////////
	$sroCheck=$this->govtDagSro($district_code,$subdivision_code,$circlecode,$mouzacode,$lot_code,$village_code,$dag_no);
	if($sroCheck===false)
	{
	/////////////////////////////
	$innerquery_sro = "SELECT  dag_area_b, dag_area_k, dag_area_lc,reg_to_name,reg_from_name,name_of_sro,deed_no,date_of_deed, status, deed_type FROM  sro_note where  dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' and patta_no='$patta_no' and patta_type_code='$patta_code' "; //and rmk_type_hist_no='$rmk_type_hist_no' ";
	$innerdata_sro_note = $this->db->query($innerquery_sro)->result();
	foreach ($innerdata_sro_note as $sro) {
		$data1[$dag_no]['sro'][] = array(
			'dag_no' => $dag_no,
			'dag_area_b' => $sro->dag_area_b,
			'dag_area_k' => $sro->dag_area_k,
			'dag_area_lc' => $sro->dag_area_lc,
			'reg_to_name' => $sro->reg_to_name,
			'reg_from_name' => $sro->reg_from_name==null?'':$sro->reg_from_name,
			'name_of_sro' => $sro->name_of_sro,
			'deed_no' => $sro->deed_no,
			'date_of_deed' => $sro->date_of_deed,
			'status' => $sro->status,
			'deed_type' => $sro->deed_type
		);
	}
	}
	//lm note
	$innerquery_LMNOTE = "select  lm_note,lm_note_date,lm_code FROM  chitha_rmk_lmnote where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' ";
	$innerdata_LMNOTE = $this->db->query($innerquery_LMNOTE)->result();
	foreach ($innerdata_LMNOTE as $lmnote) {
		$lm_note = $lmnote->lm_note;
		$lm_note_date = $lmnote->lm_note_date;
		$lm_code = $lmnote->lm_code;
		$q = "Select lm_name from   lm_code where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";
		$lm_name = $this->db->query($q)->row()->lm_name ?? '';
		$data1[$dag_no]['lmnote'][] = array(
			'lm_note' => $lmnote->lm_note,
			'lm_code' => $lm_name
		);
	}
}
	//result encro
	//modification ends here
	//            $sysyear = date("Y");
	//            for ($j = 0; $j < 3; $j++) {
	//                $year = $sysyear;
	//
	//                $sysyear = ($sysyear - 1);
	//
	//
	//
	//                $innerquery18 = "select type_of_used_noncrop,noncrop_land_area_b,noncrop_land_area_k,noncrop_land_area_lc from   chitha_noncrop where dist_code='$district_code' "
	//                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	//                        . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' and yn='$year' ";
	//                $innerdata18 = $this->db->query($innerquery18)->result();
	//                foreach ($innerdata18 as $noncropInfo) {
	//
	//                    $type_of_used_noncrop = $noncropInfo->type_of_used_noncrop;
	//                    $noncrop_land_area_b = $noncropInfo->noncrop_land_area_b;
	//                    $noncrop_land_area_k = $noncropInfo->noncrop_land_area_k;
	//                    $noncrop_land_area_lc = $noncropInfo->noncrop_land_area_lc;
	//
	//                    $innerquery19 = "select noncrop_type from   used_noncrop_type where used_noncrop_type_code = '$type_of_used_noncrop'";
	//                    $innerdata19 = $this->db->query($innerquery19)->result();
	//                    foreach ($innerdata19 as $noncrptyp) {
	//                        $noncrop_type = $noncrptyp->noncrop_type;
	//                    }
	//                }
	//
	//
	//
	//
	//
	//                $innerquery20 = " select source_of_water,crop_code,crop_land_area_b,crop_land_area_k,crop_land_area_lc from   chitha_mcrop where dist_code='$district_code' "
	//                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	//                        . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' and yearno='$year' and crop_code<>'057' ";
	//
	//                $innerdata20 = $this->db->query($innerquery20)->result();
	//                foreach ($innerdata20 as $mcropdetails) {
	//                    $source_of_water = $mcropdetails->source_of_water;
	//                    $crop_code = $mcropdetails->crop_code;
	//                    $crop_land_area_b = $mcropdetails->crop_land_area_b;
	//                    $crop_land_area_k = $mcropdetails->crop_land_area_k;
	//                    $crop_land_area_lc = $mcropdetails->crop_land_area_lc;
	//
	//                    $innerquery21 = " select source from   source_water where water_source_code = '$source_of_water'";
	//                    $innerdata21 = $this->db->query($innerquery21)->result();
	//                    foreach ($innerdata21 as $watersrc) {
	//
	//                        $sourceOFwater = $watersrc->source;
	//                    }
	//
	//                    $innerquery22 = "select crop_name from   crop_code where crop_code = '$crop_code'";
	//                    $innerdata22 = $this->db->query($innerquery22)->result();
	//                    foreach ($innerdata22 as $cropinfo) {
	//                        $cropname = $cropinfo->crop_name;
	//                    }
	//                }
	//            }
	//            $innerquery23 = "select fruit_plants_name from   chitha_fruit where dist_code='$district_code' "
	//                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	//                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' ORDER BY Fruit_plant_ID";
	//
	//            $innerdata23 = $this->db->query($innerquery23)->result();
	//            foreach ($innerdata23 as $chithafruitinf) {
	//
	//                $fruit_plants_name = $chithafruitinf->fruit_plants_name;
	//
	//
	//                $innerquery24 = "select fruit_name from   fruit_tree_code where fruit_code='$fruit_plants_name'";
	//                $innerdata24 = $this->db->query($innerquery24)->result();
	//                foreach ($innerdata24 as $fruitinfo) {
	//                    $fruit_name = $fruitinfo->fruit_name;
	//                }
	//            }
	//
	//
	//            //for remark column
	//            $innerquery25 = "select dag_area_b,dag_area_k,dag_area_lc,reg_from  _name,deed_type,reg_to_name,name_of_sro,deed_no,date_of_deed from   sro_note where dag_no='$dag_no'";
	//            $innerdata25 = $this->db->query($innerquery25)->result();
	//            foreach ($innerdata25 as $sronoteInfo) {
	//                $dag_area_b = $sronoteInfo->dag_area_b;
	//                $dag_area_k = $sronoteInfo->dag_area_k;
	//                $dag_area_lc = $sronoteInfo->dag_area_lc;
	//            }
	//        }
	// ini_set('xdebug.var_display_max_depth', 15);
	//ini_set('xdebug.var_display_max_children', 256);
	// ini_set('xdebug.var_display_max_data', 1024);
	return $data1;
}
public function getchithaDetails123($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper, $patta_code) {
	// $this->dbswitch();
	$this->dbswitch();
	ini_set('max_execution_time', 0);
	$q = "
	Select cb.old_dag_no, cb.dag_no,cb.dag_no_int,cb.patta_no,cb.dag_area_b,cb.dag_area_k,cb.dag_area_lc,cb.dag_revenue,
	cb.dag_local_tax,lcc.land_type,lcc.class_code from   chitha_basic AS cb JOIN  landclass_code
	AS lcc ON cb.land_class_code = lcc.class_code where Dist_code='$district_code' and Subdiv_code='$subdivision_code'
	and Cir_code='$circlecode'
	and Mouza_Pargona_code='$mouzacode' and Lot_No='$lot_code' and Vill_townprt_code='$village_code'
	and CAST(coalesce(cb.dag_no_int, '0') AS numeric)>=$dag_no_lower and
	CAST(coalesce(cb.dag_no_int, '0') AS numeric)<=$dag_no_upper and
	patta_type_code='$patta_code' order by CAST(coalesce(cb.dag_no_int, '0') AS numeric)";
	$district = $this->db->query("
		Select cb.old_dag_no, cb.dag_no,cb.patta_no,cb.dag_area_b,cb.dag_area_k,cb.dag_area_lc,cb.dag_revenue,
		cb.dag_local_tax,lcc.land_type,lcc.class_code_cat,lcc.class_code  from   chitha_basic AS cb JOIN  landclass_code
		AS lcc ON cb.land_class_code = lcc.class_code where Dist_code='$district_code' and Subdiv_code='$subdivision_code'
		and Cir_code='$circlecode'
		and Mouza_Pargona_code='$mouzacode' and Lot_No='$lot_code' and Vill_townprt_code='$village_code'
		and CAST(coalesce(cb.dag_no_int, '0') AS numeric)>=$dag_no_lower and
		CAST(coalesce(cb.dag_no_int, '0') AS numeric)<=$dag_no_upper and
		patta_type_code='$patta_code'  order by CAST(coalesce(cb.dag_no_int, '0') AS numeric)");
	$data1 = array();
	$outerdata = $district->result();
	$innerdata = array();
	// $chithadetailsArr = array();
	$innerdata2 = array();
	$innerdata3 = array();
	$innerdata4 = array();
	$innerdata5 = array();
	$innerdata6 = array();
	$innerdata7 = array();
	$innerdata8 = array();
	$innerdata9 = array();
	$innerdata10 = array();
	$innerdata11 = array();
	$innerdata12 = array();
	$innerdata13 = array();
	$innerdata14 = array();
	$innerdata15 = array();
	$innerdata16 = array();
	$innerdata17 = array();
	$innerdata18 = array();
	$innerdata19 = array();
	$innerdata20 = array();
	$innerdata21 = array();
	$innerdata22 = array();
	$innerdata23 = array();
	$innerdata24 = array();
	$innerdata25 = array();
	$innerdata26 = array();
	$relation = array();
	//this is the start of the loop for each dag..
	foreach ($outerdata as $chithadetails) {
		$patta_no = trim($chithadetails->patta_no);
		$dag_no = $chithadetails->dag_no;
		$backlog_court_order = "select * from   backlog_orders where dist_code='$district_code' and subdiv_code='$subdivision_code' and"
		. " cir_code='$circlecode' and lot_no='$lot_code' and mouza_pargona_code='$mouzacode' and "
		. " vill_townprt_code='$village_code' and dag_no='$dag_no' "
		. " and patta_type_code='$patta_code' and category=0";
		$data_court = $this->db->query($backlog_court_order)->result();
		$backlogquery = "select * from   backlog_orders where dist_code='$district_code' and subdiv_code='$subdivision_code' and"
		. " cir_code='$circlecode' and lot_no='$lot_code' and mouza_pargona_code='$mouzacode' and "
		. " vill_townprt_code='$village_code' and dag_no='$dag_no' "
		. " and patta_type_code='$patta_code' and category=1";
		$data = $this->db->query($backlogquery)->result();
		$backlogquery = "select * from   backlog_orders where dist_code='$district_code' and subdiv_code='$subdivision_code' and"
		. " cir_code='$circlecode' and lot_no='$lot_code' and mouza_pargona_code='$mouzacode' and "
		. " vill_townprt_code='$village_code' and dag_no='$dag_no' "
		. " and patta_type_code='$patta_code' and category=2";
		$dag_no_int = $dag_no . "00";
		$dataBacklog31 = $this->db->query($backlogquery)->result();
		$patta_type_name = $this->db->query("Select patta_type as patta_type_name from   patta_code where type_code ='$patta_code'")->row()->patta_type_name;

		if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {

        	$data1[$dag_no] = array(
				'old_dag_no' => $chithadetails->old_dag_no,
				'dag_no' => $chithadetails->dag_no,
				'patta_no' => trim($chithadetails->patta_no),
				'patta_type_name' => $patta_type_name,
				'dag_area_b' => $chithadetails->dag_area_b,
				'dag_area_k' => $chithadetails->dag_area_k,
				'dag_area_lc' => $chithadetails->dag_area_lc,
				'dag_revenue' => $chithadetails->dag_revenue,
				'dag_localtax' => $chithadetails->dag_local_tax,
				'land_type' => $chithadetails->land_type,
				'class_code_cat' => $chithadetails->class_code_cat,
				// edit for property chain
	             'land_type_code' => $chithadetails->class_code,
	             // 
			);

        }

        else{
			$data1[$dag_no] = array(
				'old_dag_no' => $chithadetails->old_dag_no,
				'dag_no' => $chithadetails->dag_no,
				'patta_no' => trim($chithadetails->patta_no),
				'patta_type_name' => $patta_type_name,
				'dag_area_b' => $chithadetails->dag_area_b,
				'dag_area_k' => $chithadetails->dag_area_k,
				'dag_area_lc' => $chithadetails->dag_area_lc,
				'dag_revenue' => $chithadetails->dag_revenue,
				'dag_localtax' => $chithadetails->dag_local_tax,
				'land_type' => $chithadetails->land_type,
				'class_code_cat' => $chithadetails->class_code_cat,
			);
		}
		$innerquery4 = "select col8order_cron_no,order_type_code,nature_trans_code,mut_land_area_b,mut_land_area_k,mut_land_area_lc,user_code,rajah_adalat,lm_code,"
		. "case_no,co_ord_date,deed_reg_no,deed_value,deed_date,operation,co_code from   Chitha_col8_order where dist_code='$district_code' and subdiv_code='$subdivision_code' "
		. "and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no='$dag_no' ) ";
		$innerdata4 = $this->db->query($innerquery4)->result();
	// this is the start to col8 order details
		foreach ($innerdata4 as $col8OrderDetails) {
			$col8order_cron_no = $col8OrderDetails->col8order_cron_no;
			$order_type_code = $col8OrderDetails->order_type_code;
			$nature_trans_code = $col8OrderDetails->nature_trans_code;
			$mut_land_area_b = $col8OrderDetails->mut_land_area_b;
			$mut_land_area_k = $col8OrderDetails->mut_land_area_k;
			$mut_land_area_lc = $col8OrderDetails->mut_land_area_lc;
			$user_code = $col8OrderDetails->user_code;
			$rajah_adalat = $col8OrderDetails->rajah_adalat;
			$lm_code = $col8OrderDetails->lm_code;
			$case_no = $col8OrderDetails->case_no;
			$co_ord_date = $col8OrderDetails->co_ord_date;
			$deed_value = $col8OrderDetails->deed_value;
			$deed_reg_no = $col8OrderDetails->deed_reg_no;
			$deed_date = $col8OrderDetails->deed_date;
			$operation = $col8OrderDetails->operation;
			$co_code = $col8OrderDetails->co_code;
			$inplace_of_name = "";
			$inplaceof_alongwith = "";
			$occupant_name = "";
			$occupant_fmh_name = "";
			$occupant_fmh_flag = "";
			$new_patta_no = "";
			$new_dag_no = "";
			$hus_wife = "";
			$nature_trans_desc = "";
			$lm_name = "";
			$applicant="";
			$inplaceofName="";
			$alongwith="";
			$riotee="";
			$inplaceofriotee="";
			$alongwithriotee="";
			if($order_type_code=='13'){
				$ordertype=13;
			}else{
				$innerquery5 = "select order_type from   master_field_mut_type
				where  order_type_code = '$order_type_code' ";
	
				$innerdata5 = $this->db->query($innerquery5)->row();
				$ordertype = $innerdata5->order_type;
			}
			$innerquery6 = "select inplace_of_name,inplaceof_alongwith from   chitha_col8_inplace
			where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' "
			. "and  mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and "
			. " vill_townprt_code='$village_code' and Dag_no='$dag_no' and Col8Order_cron_no='$col8order_cron_no' "
			. " ORDER BY inplace_of_id";
			$innerdata6 = $this->db->query($innerquery6)->result();
			$inplace_data = array();
			$innerquery7 = "select trans_desc_as from   nature_trans_code where trans_code = '$nature_trans_code'";
	
	//$nature_trans_desc = $this->db->query($innerquery7)->row()->trans_desc_as;
			foreach ($innerdata6 as $inplace) {
				$inplace_data[] = array(
					'inplace_of_name' => $inplace->inplace_of_name,
					'inplaceof_alongwith' => $inplace->inplaceof_alongwith,
				);
			}
			$occup_data = array();
			$innerquery8 = "select occupant_name,occupant_fmh_name,occupant_fmh_flag,new_patta_no,new_dag_no,hus_wife from   "
			. " chitha_col8_occup where dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
			. " and (dag_no='$dag_no' or new_dag_no='$dag_no')  and Col8Order_cron_no='$col8order_cron_no' and user_code='$co_code'   ORDER BY occupant_id";
			$innerdata8 = $this->db->query($innerquery8)->result();
			foreach ($innerdata8 as $occupant) {
				$occupant_name = $occupant->occupant_name;
				$occupant_fmh_name = $occupant->occupant_fmh_name;
				$occupant_fmh_flag = $occupant->occupant_fmh_flag;
				$new_patta_no = trim($occupant->new_patta_no);
				$new_dag_no = $occupant->new_dag_no;
				$hus_wife = $occupant->hus_wife;
				$innerquery9 = "select guard_rel_desc_as from   master_guard_rel where guard_rel = '$occupant_fmh_flag'";
				$innerdata9 = $this->db->query($innerquery9)->result();
				$guard_rel_desc_as = "";
				foreach ($innerdata9 as $guard_rel) {
					$guard_rel_desc_as = $guard_rel->guard_rel_desc_as;
				}
				$occup_data[] = array(
					'occupant_name' => $occupant->occupant_name,
					'occupant_fmh_name' => $occupant->occupant_fmh_name,
					'occupant_fmh_flag' => $occupant->occupant_fmh_flag,
					'new_patta_no' => trim($occupant->new_patta_no),
					'new_dag_no' => $occupant->new_dag_no,
					'hus_wife' => $occupant->hus_wife,
					'guard_rel_desc_as' => $guard_rel_desc_as
				);
			}
			$innerquery10 = "select lm_name from   lm_code  where dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code = '$lm_code' ";
			$innerdata10 = $this->db->query($innerquery10)->result();
			foreach ($innerdata10 as $lm) {
				$lm_name = $lm->lm_name;
			}
			if ($user_code != 'admn') {
				$innerquery11 = "select username,status from   users where dist_code='$district_code' "
				. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code='$user_code'";
				$innerdata11 = $this->db->query($innerquery11)->result();
				foreach ($innerdata11 as $users) {
					$username = $users->username;
					$status = $users->status;
				}
			} else {
				$username = '';
				$status = 'O';
			}
			$innerquery12 = "select * from   field_mut_objection where prev_fm_ca_no='$case_no' and obj_flag is not null and chitha_correct_yn='1' ";
			$innerdata12 = $this->db->query($innerquery12)->result();
			foreach ($innerdata12 as $objection) {
				$q = "select col8order_cron_no,dag_no from   chitha_col8_order where case_no='$objection->prev_fm_ca_no' ";
				$col8_cronNo = $this->db->query($q)->row();
				$q = "select occupant_name from   chitha_col8_occup where dist_code='$district_code' "
				. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
				. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and
				col8order_cron_no='$col8_cronNo->col8order_cron_no' and dag_no='$col8_cronNo->dag_no'  ";
				$result = $this->db->query($q)->result();
				$fname = " ";
				foreach ($result as $name) {
					$fname = $fname . $name->occupant_name . ",";
				}
				$data1[$dag_no]['objection'][] = array(
					'mut_type' => $objection->mut_type,
					'regist_date' => $objection->regist_date,
					'objection_case_no' => $objection->objection_case_no,
					'prev_fm_ca_no' => $objection->prev_fm_ca_no,
					'submission_date' => $objection->entry_date,
					'obj_name' => $objection->obj_name,
					'co_id' => $objection->co_id,
					'occupant' => $fname
				);
			}
			$innerquery13 = "select * from   field_mut_petitioner where case_no='$case_no' ";
			$innerdata13 = $this->db->query($innerquery13)->result();
			if ($order_type_code == '01') {
				$innerquery14 = " select deed_reg_no,deed_value,deed_date from   chitha_col8_order
				where Order_type_code='$order_type_code' and dag_no='$dag_no' and case_no='$case_no'";
	
				$innerdata14 = $this->db->query($innerquery14)->result();
				foreach ($innerdata14 as $deedinf) {
					$deed_reg_no = $deedinf->deed_reg_no;
					$deed_value = $deedinf->deed_value;
					$deed_date = $deedinf->deed_date;
				}
			}
			else if ($order_type_code == '13') {
				$innerquery15 = "select array_to_string(ARRAY_AGG (tenant_name),',') as name from   chitha_col8_tenant
				where dag_no='$dag_no' and dist_code='$district_code' "
				. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
				. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and case_no='$case_no' and pdar_type='B' group by pdar_type";
				$applicant = $this->db->query($innerquery15)->row()->name;
				$innerquery15 = "select array_to_string(ARRAY_AGG (tenant_name),',') as name from   chitha_col8_tenant
				where dag_no='$dag_no' and dist_code='$district_code' "
				. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
				. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and case_no='$case_no' and pdar_type='O' and inplace_alongwith='i' group by pdar_type";
				$inplaceofName = $this->db->query($innerquery15);
				if($inplaceofName->num_rows()>0){
					$inplaceofName=$inplaceofName->row()->name;
				}else{
					$inplaceofName=null;
				}
				$innerquery16 = "select array_to_string(ARRAY_AGG (tenant_name),',') as name from   chitha_col8_tenant
				where dag_no='$dag_no' and dist_code='$district_code' "
				. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
				. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and case_no='$case_no' and pdar_type='O' and inplace_alongwith='a' group by pdar_type";
				$alongwith = $this->db->query($innerquery16);
				if($alongwith->num_rows()>0){
					$alongwith=$alongwith->row()->name;
				}else{
					$alongwith=null;
				}
			}
	// if ($order_type_code == '13') {
	//    $co_name = "select username from   users where dist_code='$district_code' and user_code='$user_code'";
	//    $co_username = $this->db->query($co_name)->row()->username;
	// }else{
			$co_name = "select username from   users where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code='$user_code'";
			$co_username = $this->db->query($co_name);
			if($co_username->num_rows()>0){
				$co_username=$co_username->row()->username;
			}else{
				$co_username='NA';
			}
	//}
	
			if ($order_type_code != '03') {
				$data1[$dag_no]['col8'][] = array(
					'co_ord_date' => $col8OrderDetails->co_ord_date,
					'order_type_code' => $col8OrderDetails->order_type_code,
					'case_no' => $col8OrderDetails->case_no,
					'col8order_cron_no' => $col8OrderDetails->col8order_cron_no,
					'order_type' => $ordertype,
					'nature_trans_code' => $col8OrderDetails->nature_trans_code,
					'mut_land_area_b' => $col8OrderDetails->mut_land_area_b,
					'mut_land_area_k' => $col8OrderDetails->mut_land_area_k,
					'mut_land_area_lc' => $col8OrderDetails->mut_land_area_lc,
					'inplace' => $inplace_data,
					'occup' => $occup_data,
					'rajah' => $rajah_adalat,
					'deed_value' => $deed_value,
					'deed_reg_no' => $deed_reg_no,
					'deed_date' => $deed_date,
					'lm_name' => $lm_name,
					'username' => $co_username==null?'NA':$co_username,
					'co_name' => $co_username==null?'NA':$co_username,
					'operation' => $operation,
					'riotee'=>$applicant,
					'inplaceofriotee'=>$inplaceofName,
					'alongwithriotee'=>$alongwith
				);
			}
		}
		$data1[$dag_no]['backlog_court_order'][] = $data_court;
		$data1[$dag_no]['backlogs'][] = $data;
		$data1[$dag_no]['backlogs31'][] = $dataBacklog31;
	//$data1[$dag_no]['appeal147'][] = $appeal147;
	// this is the End to col8 order details
		$d = $this->getCol31($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no);
		//var_dump($d);
		$data1[$dag_no]['col31'][] = $d;
		$lmnotes = $this->getLmNotes($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no);
		$data1[$dag_no]['lmnotes'] = $lmnotes;
		//////////Remarks for LandClass//////////////
		$data1[$dag_no]['classRemark'] = $this->landClass($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no);
		///////////////////////
		$innerquery = "select p_flag,pdar_id,patta_no,dag_por_b,dag_por_k,dag_por_lc from   chitha_dag_pattadar where dist_code='$district_code' "
		. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
		. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
		. " and dag_no='$dag_no' and TRIM(patta_no)='$patta_no' and  patta_type_code='$patta_code' order by pdar_id";
		$innerdata = $this->db->query($innerquery)->result();
		$data1[$dag_no]['pattadars'] = array();
		foreach ($innerdata as $data) {
	// $p_flag = $data->p_flag;
			$pdar_id = $data->pdar_id;
			$patta_no = trim($data->patta_no);
	//$data1[$dag_no]['col8'] = array();
			$data1[$dag_no]['tenant'] = array();
			$data1[$dag_no]['subtenant'] = array();
			$innerquery2 = "select pdar_name,pdar_father,new_pdar_name,pdar_guard_reln,pdar_add1,Pdar_add2,Pdar_add3 from   chitha_pattadar where dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
			. " and TRIM(patta_no)='$patta_no' and  patta_type_code='$patta_code' and pdar_id=$data->pdar_id order by pdar_id";
	
			$innerdata2 = $this->db->query($innerquery2)->result();
	/* if (!empty($innerdata2)) {
	
	} else {
	
} */
	/* if (!empty($innerdata2)) {
	
	} else {
	
} */
	/* if (!empty($innerdata2)) {
	
	} else {
	
	} */
	foreach ($innerdata2 as $pdardata) {
		$pdar_guardRelation = $pdardata->pdar_guard_reln;
		$innerquery3 = "select guard_rel_desc_as from   master_guard_rel where guard_rel_desc = '$pdar_guardRelation'";
		$innerdata3 = $this->db->query($innerquery3)->result();
		foreach ($innerdata3 as $guard_rel_desc) {
			$relation = $guard_rel_desc->guard_reln_desc_as;
		}
		$data1[$dag_no]['pattadars'][] = array(
			'p_flag' => $data->p_flag,
			'dag_por_b' => $data->dag_por_b,
			'dag_por_k' => $data->dag_por_k,
			'dag_por_lc' => $data->dag_por_lc,
			'pdar_name' => $pdardata->pdar_name,
			'guard_reln_desc_as' => $relation,
			'new_pdar_name' => $pdardata->new_pdar_name,
			'pdar_father' => $pdardata->pdar_father,
			'pdar_relation' => $pdardata->pdar_guard_reln,
			'pdar_address1' => $pdardata->pdar_add1,
			'pdar_address2' => $pdardata->pdar_add2,
			'pdar_address3' => $pdardata->pdar_add3,
			'pdar_guard_reln' => $pdardata->pdar_guard_reln,
			'pdar_id' => $pdar_id
		);
	}
	if (!empty($dag_no)){
		$sql = "Select * from  khatian where dist_code='$district_code' "
		. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
		. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no='$dag_no' ";
		$khatia = $this->db->query($sql);
		if ($khatia->num_rows()>0) {
			$khatia=$khatia->row();
			$innerquery15 = " select tenant_name,tenants_father,tenants_add1,tenants_add2,type_of_tenant,khatian_no,tenant_id,status,p_flag from   chitha_tenant where dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and khatian_no='$khatia->id'
			and dag_no='$dag_no' order by tenant_id";
			$innerdata15 = $this->db->query($innerquery15)->result();
			foreach ($innerdata15 as $tenant) {
				if ($tenant->type_of_tenant == null) {
					$tenant_typ = "00";
				} else {
					$tenant_typ = $tenant->type_of_tenant;
				}
				$tenant_name = $tenant->tenant_name;
				$tenants_father = $tenant->tenants_father;
				$tenants_add1 = $tenant->tenants_add1;
				$tenants_add2 = $tenant->tenants_add2;
				$type_of_tenant = $tenant_typ;
				$khatian_no = $tenant->khatian_no;
				$status = $tenant->status;
	//$revenue_tenant = $tenant->revenue_tenant;
	//$crop_rate = $tenant->crop_rate;
				$tenant_id = $tenant->tenant_id;
				$innerquery16 = "Select tenant_type from   Tenant_type where type_code ='$type_of_tenant'";
				$innerdata16 = $this->db->query($innerquery16)->result();
				foreach ($innerdata16 as $tenanttype) {
					$tenant_type = $tenanttype->tenant_type;
					$data1[$dag_no]['tenant'][] = array(
						'tenant_name' => $tenant->tenant_name,
						'tenants_father' => $tenant->tenants_father,
						'tenants_add1' => $tenant->tenants_add1,
						'tenants_add2' => $tenant->tenants_add2,
	//'tenants_add3' => $tenant->tenants_add3,
						'type_of_tenant' => $tenant->type_of_tenant,
						'khatian_no' => $tenant->khatian_no,
						'status' => $tenant->status,
	// 'revenue_tenant' => $tenant->revenue_tenant,
	//'crop_rate' => $tenant->crop_rate,
						'tenant_type' => $tenanttype->tenant_type,
						'p_flag'=> $tenant->p_flag,
					);
				}
			}
			$innerquery17 = "Select subtenant_name,subtenants_father,subtenants_add1,subtenants_add2,subtenants_add3 from   Chitha_Subtenant where  dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and Dag_no='$dag_no' and tenant_id = '$tenant_id'";
			$innerdata17 = $this->db->query($innerquery17)->result();
			$subtenant_name = "";
			$subtenants_father = "";
			$subtenants_add1 = "";
			$subtenants_add2 = "";
			$subtenants_add = "";
			foreach ($innerdata17 as $subtenant) {
				$subtenant_name = $subtenant->subtenant_name;
				$subtenants_father = $subtenant->subtenants_father;
				$subtenants_add1 = $subtenant->subtenants_add1;
				$subtenants_add2 = $subtenant->subtenants_add2;
				$subtenants_add3 = $subtenant->subtenants_add3;
				$data1[$dag_no]['subtenant'][] = array(
					'subtenant_name' => $subtenant->subtenant_name,
					'subtenants_father' => $subtenant->subtenants_father,
					'subtenants_add1' => $subtenant->subtenants_add1,
					'subtenants_add2' => $subtenant->subtenants_add2,
					'subtenants_add3' => $subtenant->subtenants_add3,
				);
			}
		}
	}
}
	//modification by bondita
$sysyear = date("Y");
	
$data1[$dag_no]['archeo'] = array();
$data1[$dag_no]['noncrp'] = array();
$data1[$dag_no]['mcrp'] = array();
$data1[$dag_no]['fruit'] = array();
$data1[$dag_no]['mcrp_akeadhig'] = array();
$data1[$dag_no]['years'] = array();
$year1 = $sysyear;
$year = ($year1 - 2);
for ($j = 0; $j < 3; $j++) {
	$innerquerynoncrp = "select type_of_used_noncrop,noncrop_land_area_b,noncrop_land_area_k,noncrop_land_area_lc from   chitha_noncrop where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' and yn='$year'";
	$innerdatanoncrp = $this->db->query($innerquerynoncrp)->result();
	foreach ($innerdatanoncrp as $noncrop) {
		$type_of_used_noncrp = $noncrop->type_of_used_noncrop;
		$noncrp_b = $noncrop->noncrop_land_area_b;
		$noncrop_k = $noncrop->noncrop_land_area_k;
		$noncrop_lc = $noncrop->noncrop_land_area_lc;
		$innerquery19 = "select noncrop_type from   used_noncrop_type where used_noncrop_type_code = '$type_of_used_noncrp'";
		$innerdata19 = $this->db->query($innerquery19)->result();
		foreach ($innerdata19 as $noncrptyp) {
			$noncrop_type = $noncrptyp->noncrop_type;
			$data1[$dag_no]['noncrp'][] = array(
				'year' => $year,
				'type_of_used_noncrp' => $noncrop_type,
				'noncrp_b' => $noncrp_b,
				'noncrop_k' => $noncrop_k,
				'noncrop_lc' => $noncrop_lc
			);
		}
	}
	$innerquerycrp = " select source_of_water,crop_code,crop_land_area_b,crop_land_area_k,crop_land_area_lc,crop_categ_code from   chitha_mcrop where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' and yearno='$year' and crop_code<>'057' ";
	$innerdatacrp = $this->db->query($innerquerycrp)->result();
	foreach ($innerdatacrp as $mcropdetails) {
		$source_of_water = $mcropdetails->source_of_water;
		$crop_code = $mcropdetails->crop_code;
		$crop_land_area_b = $mcropdetails->crop_land_area_b;
		$crop_land_area_k = $mcropdetails->crop_land_area_k;
		$crop_land_area_lc = $mcropdetails->crop_land_area_lc;
		$crop_category = $mcropdetails->crop_categ_code;
		$innerquerywatersrc = "select source from   source_water where water_source_code = '$source_of_water'";
		$innerdatawatersrc = $this->db->query($innerquerywatersrc)->result();
		foreach ($innerdatawatersrc as $watersrc) {
			$sourceOFwater = $watersrc->source;
			$innerqueryCropCateg = "select crop_categ_desc from   crop_category_code where crop_categ_code = '$crop_category'";
			$innerdataCropcateg = $this->db->query($innerqueryCropCateg)->result();
			foreach ($innerdataCropcateg as $CropDesc) {
				$CropDesc_inChitha = $CropDesc->crop_categ_desc;
				$innerquerymcrop = "select crop_name from   crop_code where crop_code = '$crop_code'";
				$innerdatamcrop = $this->db->query($innerquerymcrop)->result();
				foreach ($innerdatamcrop as $cropinfo) {
					$cropname = $cropinfo->crop_name;
					$data1[$dag_no]['mcrp'][] = array(
						'sourceofwater' => $sourceOFwater,
						'cropname' => $cropname,
						'mcrp_b' => $crop_land_area_b,
						'mcrop_k' => $crop_land_area_k,
						'mcrop_lc' => $crop_land_area_lc,
						'crop_category' => $CropDesc_inChitha
					);
				}
			}
		}
	}
	$innerquerycrp_ekadhig = " select crop_land_area_b,crop_land_area_k,crop_land_area_lc from   chitha_mcrop where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' and yearno='$year'  ";
	
	$innerdatacrp_ekadhig = $this->db->query($innerquerycrp_ekadhig)->result();
	foreach ($innerdatacrp_ekadhig as $ekadhig)
		$data1[$dag_no]['mcrp_akeadhig'][] = array(
			'bigha' => $ekadhig->crop_land_area_b,
			'katha' => $ekadhig->crop_land_area_k,
			'lesa' => $ekadhig->crop_land_area_lc
		);
	$data1[$dag_no]['years'][] = array(
		'year' => $year
	);
	$year = ($year + 1);
}
$innerquery23 = "select fruit_plants_name,no_of_plants,fruit_land_area_b,fruit_land_area_k,fruit_land_area_lc from   chitha_fruit where dist_code='$district_code' "
. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' ORDER BY Fruit_plant_ID";
$innerdata23 = $this->db->query($innerquery23)->result();
foreach ($innerdata23 as $chithafruitinf) {
	$fruit_plants_name = $chithafruitinf->fruit_plants_name;
	$no_of_fruit_plants = $chithafruitinf->no_of_plants;
	$fruit_bigha = $chithafruitinf->fruit_land_area_b;
	$fruit_katha = $chithafruitinf->fruit_land_area_k;
	$fruit_lesa = $chithafruitinf->fruit_land_area_lc;
	$innerquery24 = "select fruit_name from   fruit_tree_code where fruit_code='$fruit_plants_name'";
	$innerdata24 = $this->db->query($innerquery24)->result();
	foreach ($innerdata24 as $fruitinfo) {
		$fruit_name = $fruitinfo->fruit_name;
		$data1[$dag_no]['fruit'][] = array(
			'fruitname' => $fruit_name,
			'no_of_plants' => $no_of_fruit_plants,
			'fbigha' => $fruit_bigha,
			'fkatha' => $fruit_katha,
			'flesa' => $fruit_lesa
		);
	}
}
$chithaarcheo = "select archeo_hist_code,hist_land_area_b,hist_land_area_k,hist_land_area_lc,archeo_hist_site_desc from   chitha_acho_hist where dist_code='$district_code' "
. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no'";
	
$innerdataarcheo = $this->db->query($chithaarcheo)->result();
	foreach ($innerdataarcheo as $archeoinfo) {
	$archeo_code = $archeoinfo->archeo_hist_code;
	$archeo_area_b = $archeoinfo->hist_land_area_b;
	$archeo_area_k = $archeoinfo->hist_land_area_k;
	$archeo_area_lc = $archeoinfo->hist_land_area_lc;
	$archeo_area_description = $archeoinfo->archeo_hist_site_desc;
	$archeo_siteCd = "select archeo_hist_desc from   archeo_hist_site_code where archeo_hist_code='$archeo_code' ";
	$innerdataarcheo_cd = $this->db->query($archeo_siteCd)->result();
	foreach ($innerdataarcheo_cd as $archeo_cd) {
		$hist_description = $archeo_cd->archeo_hist_desc;
		$data1[$dag_no]['archeo'][] = array(
			'hist_description_nme' => $hist_description,
			'archeo_hist_code' => $archeo_code,
			'archeo_b' => $archeo_area_b,
			'archeo_k' => $archeo_area_k,
			'archeo_lc' => $archeo_area_lc,
			'archeo_decribed' => $archeo_area_description
		);
	}
}
$innerquery58 = "SELECT encro_evicted_yn,encro_name,encro_since,encro_land_b,encro_land_k,encro_land_lc,encro_land_used_for,encro_evic_date FROM  chitha_rmk_encro where  dist_code='$district_code' "
. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' "; //and rmk_type_hist_no='$rmk_type_hist_no' ";
	$innerdata58 = $this->db->query($innerquery58)->result();
	foreach ($innerdata58 as $encro) {
		$encro_land_used_for = $encro->encro_land_used_for;
		$innerquery_encroland = "SELECT used_for from   encro_land_used_for where code='$encro_land_used_for' ";
		$innerdata_encroland = $this->db->query($innerquery_encroland)->result();
		foreach ($innerdata_encroland as $encro_land) {
			$data1[$dag_no]['encro'][] = array(
				'encro_evicted_yn' => $encro->encro_evicted_yn,
				'encro_name' => $encro->encro_name,
				'encro_since' => $encro->encro_since,
				'encro_land_b' => $encro->encro_land_b,
				'encro_land_k' => $encro->encro_land_k,
				'encro_land_lc' => $encro->encro_land_lc,
				'encro_land_used_for' => $encro->encro_land_used_for,
				'encro_evic_date' => $encro->encro_evic_date,
				'land_used_by_encro' => $encro_land->used_for
			);
		}
	}
	//sro note
	$sroCheck=$this->govtDagSro($district_code,$subdivision_code,$circlecode,$mouzacode,$lot_code,$village_code,$dag_no);
	if($sroCheck===false)
	{
	$innerquery_sro = "SELECT  dag_area_b, dag_area_k, dag_area_lc,reg_to_name,reg_from_name,name_of_sro,deed_no,date_of_deed, status,deed_type FROM  sro_note where  dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' "; //and rmk_type_hist_no='$rmk_type_hist_no' ";
	$innerdata_sro_note = $this->db->query($innerquery_sro)->result();
	foreach ($innerdata_sro_note as $sro) {
		$data1[$dag_no]['sro'][] = array(
			'dag_no' => $dag_no,
			'dag_area_b' => $sro->dag_area_b,
			'dag_area_k' => $sro->dag_area_k,
			'dag_area_lc' => $sro->dag_area_lc,
			'reg_to_name' => $sro->reg_to_name,
			'reg_from_name' => $sro->reg_from_name,
			'name_of_sro' => $sro->name_of_sro,
			'deed_no' => $sro->deed_no,
			'date_of_deed' => $sro->date_of_deed,
			'status' => $sro->status,
			'deed_type'=> $sro->deed_type
		);
	}
	}
	//lm note
	$innerquery_LMNOTE = "select  lm_note,lm_note_date,lm_code FROM  chitha_rmk_lmnote where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' ";
	$innerdata_LMNOTE = $this->db->query($innerquery_LMNOTE)->result();
	foreach ($innerdata_LMNOTE as $lmnote) {
		$q = "Select lm_name from   lm_code where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lmnote->lm_code' ";
		$lm_name = $this->db->query($q)->row()->lm_name ?? '';
		$lm_note = $lmnote->lm_note;
		$lm_note_date = $lmnote->lm_note_date;
		$lm_code = $lmnote->lm_code;
		$data1[$dag_no]['lmnote'][] = array(
			'lm_note' => $lmnote->lm_note,
			'lm_code' => $lm_name,
			'lm_note_date' => $lmnote->lm_note_date
		);
	}
}
	//result encro
	//modification ends here
	//            $sysyear = date("Y");
	//            for ($j = 0; $j < 3; $j++) {
	//                $year = $sysyear;
	//
	//                $sysyear = ($sysyear - 1);
	//
	//
	//
	//                $innerquery18 = "select type_of_used_noncrop,noncrop_land_area_b,noncrop_land_area_k,noncrop_land_area_lc from   chitha_noncrop where dist_code='$district_code' "
	//                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	//                        . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' and yn='$year' ";
	//                $innerdata18 = $this->db->query($innerquery18)->result();
	//                foreach ($innerdata18 as $noncropInfo) {
	//
	//                    $type_of_used_noncrop = $noncropInfo->type_of_used_noncrop;
	//                    $noncrop_land_area_b = $noncropInfo->noncrop_land_area_b;
	//                    $noncrop_land_area_k = $noncropInfo->noncrop_land_area_k;
	//                    $noncrop_land_area_lc = $noncropInfo->noncrop_land_area_lc;
	//
	//                    $innerquery19 = "select noncrop_type from   used_noncrop_type where used_noncrop_type_code = '$type_of_used_noncrop'";
	//                    $innerdata19 = $this->db->query($innerquery19)->result();
	//                    foreach ($innerdata19 as $noncrptyp) {
	//                        $noncrop_type = $noncrptyp->noncrop_type;
	//                    }
	//                }
	//
	//
	//
	//
	//
	//                $innerquery20 = " select source_of_water,crop_code,crop_land_area_b,crop_land_area_k,crop_land_area_lc from   chitha_mcrop where dist_code='$district_code' "
	//                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	//                        . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' and yearno='$year' and crop_code<>'057' ";
	//
	//                $innerdata20 = $this->db->query($innerquery20)->result();
	//                foreach ($innerdata20 as $mcropdetails) {
	//                    $source_of_water = $mcropdetails->source_of_water;
	//                    $crop_code = $mcropdetails->crop_code;
	//                    $crop_land_area_b = $mcropdetails->crop_land_area_b;
	//                    $crop_land_area_k = $mcropdetails->crop_land_area_k;
	//                    $crop_land_area_lc = $mcropdetails->crop_land_area_lc;
	//
	//                    $innerquery21 = " select source from   source_water where water_source_code = '$source_of_water'";
	//                    $innerdata21 = $this->db->query($innerquery21)->result();
	//                    foreach ($innerdata21 as $watersrc) {
	//
	//                        $sourceOFwater = $watersrc->source;
	//                    }
	//
	//                    $innerquery22 = "select crop_name from   crop_code where crop_code = '$crop_code'";
	//                    $innerdata22 = $this->db->query($innerquery22)->result();
	//                    foreach ($innerdata22 as $cropinfo) {
	//                        $cropname = $cropinfo->crop_name;
	//                    }
	//                }
	//            }
	//            $innerquery23 = "select fruit_plants_name from   chitha_fruit where dist_code='$district_code' "
	//                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	//                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' ORDER BY Fruit_plant_ID";
	//
	//            $innerdata23 = $this->db->query($innerquery23)->result();
	//            foreach ($innerdata23 as $chithafruitinf) {
	//
	//                $fruit_plants_name = $chithafruitinf->fruit_plants_name;
	//
	//
	//                $innerquery24 = "select fruit_name from   fruit_tree_code where fruit_code='$fruit_plants_name'";
	//                $innerdata24 = $this->db->query($innerquery24)->result();
	//                foreach ($innerdata24 as $fruitinfo) {
	//                    $fruit_name = $fruitinfo->fruit_name;
	//                }
	//            }
	//
	//
	//            //for remark column
	//            $innerquery25 = "select dag_area_b,dag_area_k,dag_area_lc,reg_from  _name,deed_type,reg_to_name,name_of_sro,deed_no,date_of_deed from   sro_note where dag_no='$dag_no'";
	//            $innerdata25 = $this->db->query($innerquery25)->result();
	//            foreach ($innerdata25 as $sronoteInfo) {
	//                $dag_area_b = $sronoteInfo->dag_area_b;
	//                $dag_area_k = $sronoteInfo->dag_area_k;
	//                $dag_area_lc = $sronoteInfo->dag_area_lc;
	//            }
	//        }
	// ini_set('xdebug.var_display_max_depth', 15);
	//ini_set('xdebug.var_display_max_children', 256);
	// ini_set('xdebug.var_display_max_data', 1024);
	return $data1;
}
	/////
public function getchithaDetails123Barak($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper, $patta_code) {
	// $this->dbswitch();
	$this->dbswitch();
	ini_set('max_execution_time', 0);
	$q = "
	Select cb.old_dag_no, cb.dag_no,cb.dag_no_int,cb.patta_no,cb.dag_area_b,cb.dag_area_k,cb.dag_area_lc,cb.dag_area_g,cb.dag_revenue,
	cb.dag_local_tax,lcc.land_type from   chitha_basic AS cb JOIN  landclass_code
	AS lcc ON cb.land_class_code = lcc.class_code where Dist_code='$district_code' and Subdiv_code='$subdivision_code'
	and Cir_code='$circlecode'
	and Mouza_Pargona_code='$mouzacode' and Lot_No='$lot_code' and Vill_townprt_code='$village_code'
	and CAST(coalesce(cb.dag_no_int, '0') AS numeric)>=$dag_no_lower and
	CAST(coalesce(cb.dag_no_int, '0') AS numeric)<=$dag_no_upper and
	patta_type_code='$patta_code' order by CAST(coalesce(cb.dag_no_int, '0') AS numeric)";
	$district = $this->db->query("
		Select cb.old_dag_no, cb.dag_no,cb.patta_no,cb.dag_area_b,cb.dag_area_k,cb.dag_area_lc,cb.dag_area_g,cb.dag_revenue,
		cb.dag_local_tax,lcc.land_type,lcc.class_code_cat  from   chitha_basic AS cb JOIN  landclass_code
		AS lcc ON cb.land_class_code = lcc.class_code where Dist_code='$district_code' and Subdiv_code='$subdivision_code'
		and Cir_code='$circlecode'
		and Mouza_Pargona_code='$mouzacode' and Lot_No='$lot_code' and Vill_townprt_code='$village_code'
		and CAST(coalesce(cb.dag_no_int, '0') AS numeric)>=$dag_no_lower and
		CAST(coalesce(cb.dag_no_int, '0') AS numeric)<=$dag_no_upper and
		patta_type_code='$patta_code'  order by CAST(coalesce(cb.dag_no_int, '0') AS numeric)");
	$data1 = array();
	$outerdata = $district->result();
	$innerdata = array();
	// $chithadetailsArr = array();
	$innerdata2 = array();
	$innerdata3 = array();
	$innerdata4 = array();
	$innerdata5 = array();
	$innerdata6 = array();
	$innerdata7 = array();
	$innerdata8 = array();
	$innerdata9 = array();
	$innerdata10 = array();
	$innerdata11 = array();
	$innerdata12 = array();
	$innerdata13 = array();
	$innerdata14 = array();
	$innerdata15 = array();
	$innerdata16 = array();
	$innerdata17 = array();
	$innerdata18 = array();
	$innerdata19 = array();
	$innerdata20 = array();
	$innerdata21 = array();
	$innerdata22 = array();
	$innerdata23 = array();
	$innerdata24 = array();
	$innerdata25 = array();
	$innerdata26 = array();
	$relation = array();
	//this is the start of the loop for each dag..
	foreach ($outerdata as $chithadetails) {
		$patta_no = trim($chithadetails->patta_no);
		$dag_no = $chithadetails->dag_no;
		$backlog_court_order = "select * from   backlog_orders where dist_code='$district_code' and subdiv_code='$subdivision_code' and"
		. " cir_code='$circlecode' and lot_no='$lot_code' and mouza_pargona_code='$mouzacode' and "
		. " vill_townprt_code='$village_code' and dag_no='$dag_no' "
		. " and patta_type_code='$patta_code' and category=0";
		$data_court = $this->db->query($backlog_court_order)->result();
		$backlogquery = "select * from   backlog_orders where dist_code='$district_code' and subdiv_code='$subdivision_code' and"
		. " cir_code='$circlecode' and lot_no='$lot_code' and mouza_pargona_code='$mouzacode' and "
		. " vill_townprt_code='$village_code' and dag_no='$dag_no' "
		. " and patta_type_code='$patta_code' and category=1";
		$data = $this->db->query($backlogquery)->result();
		$backlogquery = "select * from   backlog_orders where dist_code='$district_code' and subdiv_code='$subdivision_code' and"
		. " cir_code='$circlecode' and lot_no='$lot_code' and mouza_pargona_code='$mouzacode' and "
		. " vill_townprt_code='$village_code' and dag_no='$dag_no' "
		. " and patta_type_code='$patta_code' and category=2";
		$dag_no_int = $dag_no . "00";
		$dataBacklog31 = $this->db->query($backlogquery)->result();
		$patta_type_name = $this->db->query("Select patta_type as patta_type_name from   patta_code where type_code ='$patta_code'")->row()->patta_type_name;

		if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
			$data1[$dag_no] = array(
				'old_dag_no' => $chithadetails->old_dag_no,
				'dag_no' => $chithadetails->dag_no,
				'patta_no' => trim($chithadetails->patta_no),
				'patta_type_name' => $patta_type_name,
				'dag_area_b' => $chithadetails->dag_area_b,
				'dag_area_k' => $chithadetails->dag_area_k,
				'dag_area_lc' => $chithadetails->dag_area_lc,
				'dag_area_g'=>$chithadetails->dag_area_g,
				'dag_revenue' => $chithadetails->dag_revenue,
				'dag_localtax' => $chithadetails->dag_local_tax,
				'land_type' => $chithadetails->land_type,
				'class_code_cat' => $chithadetails->class_code_cat,
				// edit for property chain
                'land_type_code' => $chithadetails->class_code,
                // 
			);

		}

		else
		{
			$data1[$dag_no] = array(
				'old_dag_no' => $chithadetails->old_dag_no,
				'dag_no' => $chithadetails->dag_no,
				'patta_no' => trim($chithadetails->patta_no),
				'patta_type_name' => $patta_type_name,
				'dag_area_b' => $chithadetails->dag_area_b,
				'dag_area_k' => $chithadetails->dag_area_k,
				'dag_area_lc' => $chithadetails->dag_area_lc,
				'dag_area_g'=>$chithadetails->dag_area_g,
				'dag_revenue' => $chithadetails->dag_revenue,
				'dag_localtax' => $chithadetails->dag_local_tax,
				'land_type' => $chithadetails->land_type,
				'class_code_cat' => $chithadetails->class_code_cat,
			);

		}
		$innerquery4 = "select col8order_cron_no,order_type_code,nature_trans_code,mut_land_area_b,mut_land_area_k,mut_land_area_lc,mut_land_area_g,user_code,rajah_adalat,lm_code,"
		. "case_no,co_ord_date,deed_reg_no,deed_value,deed_date,operation,co_code from   Chitha_col8_order where dist_code='$district_code' and subdiv_code='$subdivision_code' "
		. "and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no='$dag_no' ) ";
		$innerdata4 = $this->db->query($innerquery4)->result();
	// this is the start to col8 order details
		foreach ($innerdata4 as $col8OrderDetails) {
			$col8order_cron_no = $col8OrderDetails->col8order_cron_no;
			$order_type_code = $col8OrderDetails->order_type_code;
			$nature_trans_code = $col8OrderDetails->nature_trans_code;
			$mut_land_area_b = $col8OrderDetails->mut_land_area_b;
			$mut_land_area_k = $col8OrderDetails->mut_land_area_k;
			$mut_land_area_lc = $col8OrderDetails->mut_land_area_lc;
			$mut_land_area_g = $col8OrderDetails->mut_land_area_g;
			$user_code = $col8OrderDetails->user_code;
			$rajah_adalat = $col8OrderDetails->rajah_adalat;
			$lm_code = $col8OrderDetails->lm_code;
			$case_no = $col8OrderDetails->case_no;
			$co_ord_date = $col8OrderDetails->co_ord_date;
			$deed_value = $col8OrderDetails->deed_value;
			$deed_reg_no = $col8OrderDetails->deed_reg_no;
			$deed_date = $col8OrderDetails->deed_date;
			$operation = $col8OrderDetails->operation;
			$co_code = $col8OrderDetails->co_code;
			$inplace_of_name = "";
			$inplaceof_alongwith = "";
			$occupant_name = "";
			$occupant_fmh_name = "";
			$occupant_fmh_flag = "";
			$new_patta_no = "";
			$new_dag_no = "";
			$hus_wife = "";
			$nature_trans_desc = "";
			$lm_name = "";
			$innerquery5 = "select order_type from   master_field_mut_type
			where  order_type_code = '$order_type_code' ";
	
			$innerdata5 = $this->db->query($innerquery5)->row();
			$ordertype = $innerdata5->order_type;
			$innerquery6 = "select inplace_of_name,inplaceof_alongwith from   chitha_col8_inplace
			where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' "
			. "and  mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and "
			. " vill_townprt_code='$village_code' and Dag_no='$dag_no' and Col8Order_cron_no='$col8order_cron_no' "
			. " ORDER BY inplace_of_id";
			$innerdata6 = $this->db->query($innerquery6)->result();
			$inplace_data = array();
			$innerquery7 = "select trans_desc_as from   nature_trans_code where trans_code = '$nature_trans_code'";
	
	//$nature_trans_desc = $this->db->query($innerquery7)->row()->trans_desc_as;
			foreach ($innerdata6 as $inplace) {
				$inplace_data[] = array(
					'inplace_of_name' => $inplace->inplace_of_name,
					'inplaceof_alongwith' => $inplace->inplaceof_alongwith,
				);
			}
			$occup_data = array();
			$innerquery8 = "select occupant_name,occupant_fmh_name,occupant_fmh_flag,new_patta_no,new_dag_no,hus_wife from   "
			. " chitha_col8_occup where dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
			. " and (dag_no='$dag_no' or new_dag_no='$dag_no')  and Col8Order_cron_no='$col8order_cron_no' and user_code='$co_code'   ORDER BY occupant_id";
			$innerdata8 = $this->db->query($innerquery8)->result();
			foreach ($innerdata8 as $occupant) {
				$occupant_name = $occupant->occupant_name;
				$occupant_fmh_name = $occupant->occupant_fmh_name;
				$occupant_fmh_flag = $occupant->occupant_fmh_flag;
				$new_patta_no = trim($occupant->new_patta_no);
				$new_dag_no = $occupant->new_dag_no;
				$hus_wife = $occupant->hus_wife;
				$innerquery9 = "select guard_rel_desc_as from   master_guard_rel where guard_rel = '$occupant_fmh_flag'";
				$innerdata9 = $this->db->query($innerquery9)->result();
				$guard_rel_desc_as = "";
				foreach ($innerdata9 as $guard_rel) {
					$guard_rel_desc_as = $guard_rel->guard_rel_desc_as;
				}
				$occup_data[] = array(
					'occupant_name' => $occupant->occupant_name,
					'occupant_fmh_name' => $occupant->occupant_fmh_name,
					'occupant_fmh_flag' => $occupant->occupant_fmh_flag,
					'new_patta_no' => trim($occupant->new_patta_no),
					'new_dag_no' => $occupant->new_dag_no,
					'hus_wife' => $occupant->hus_wife,
					'guard_rel_desc_as' => $guard_rel_desc_as
				);
			}
			$innerquery10 = "select lm_name from   lm_code  where dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code = '$lm_code' ";
			$innerdata10 = $this->db->query($innerquery10)->result();
			foreach ($innerdata10 as $lm) {
				$lm_name = $lm->lm_name;
			}
			if ($user_code != 'admn') {
				$innerquery11 = "select username,status from   users where dist_code='$district_code' "
				. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code='$user_code'";
				$innerdata11 = $this->db->query($innerquery11)->result();
				foreach ($innerdata11 as $users) {
					$username = $users->username;
					$status = $users->status;
				}
			} else {
				$username = '';
				$status = 'O';
			}
			$innerquery12 = "select * from   field_mut_objection where prev_fm_ca_no='$case_no' and obj_flag is not null and chitha_correct_yn='1' ";
			$innerdata12 = $this->db->query($innerquery12)->result();
			foreach ($innerdata12 as $objection) {
				$q = "select col8order_cron_no,dag_no from   chitha_col8_order where case_no='$objection->prev_fm_ca_no' ";
				$col8_cronNo = $this->db->query($q)->row();
				$q = "select occupant_name from   chitha_col8_occup where dist_code='$district_code' "
				. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
				. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and
				col8order_cron_no='$col8_cronNo->col8order_cron_no' and dag_no='$col8_cronNo->dag_no'  ";
				$result = $this->db->query($q)->result();
				$fname = " ";
				foreach ($result as $name) {
					$fname = $fname . $name->occupant_name . ",";
				}
				$data1[$dag_no]['objection'][] = array(
					'mut_type' => $objection->mut_type,
					'regist_date' => $objection->regist_date,
					'objection_case_no' => $objection->objection_case_no,
					'prev_fm_ca_no' => $objection->prev_fm_ca_no,
					'submission_date' => $objection->entry_date,
					'obj_name' => $objection->obj_name,
					'co_id' => $objection->co_id,
					'occupant' => $fname
				);
			}
			$innerquery13 = "select * from   field_mut_petitioner where case_no='$case_no' ";
			$innerdata13 = $this->db->query($innerquery13)->result();
			if ($order_type_code == '01') {
				$innerquery14 = " select deed_reg_no,deed_value,deed_date from   chitha_col8_order
				where Order_type_code='$order_type_code' and dag_no='$dag_no' and case_no='$case_no'";
	
				$innerdata14 = $this->db->query($innerquery14)->result();
				foreach ($innerdata14 as $deedinf) {
					$deed_reg_no = $deedinf->deed_reg_no;
					$deed_value = $deedinf->deed_value;
					$deed_date = $deedinf->deed_date;
				}
			}
			$co_name = "select username from   users where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code='$co_code'";
			$co_name = $this->db->query($co_name)->result();
			foreach ($co_name as $co) {
				$co_username = $co->username;
			}
	
			$data1[$dag_no]['col8'][] = array(
				'co_ord_date' => $col8OrderDetails->co_ord_date,
				'order_type_code' => $col8OrderDetails->order_type_code,
				'case_no' => $col8OrderDetails->case_no,
				'col8order_cron_no' => $col8OrderDetails->col8order_cron_no,
				'order_type' => $ordertype,
				'nature_trans_code' => $col8OrderDetails->nature_trans_code,
				'mut_land_area_b' => $col8OrderDetails->mut_land_area_b,
				'mut_land_area_k' => $col8OrderDetails->mut_land_area_k,
				'mut_land_area_lc' => $col8OrderDetails->mut_land_area_lc,
				'mut_land_area_g' => $col8OrderDetails->mut_land_area_g,
				'inplace' => $inplace_data,
				'occup' => $occup_data,
				'rajah' => $rajah_adalat,
				'deed_value' => $deed_value,
				'deed_reg_no' => $deed_reg_no,
				'deed_date' => $deed_date,
				'lm_name' => $lm_name,
				'username' => $username,
				'operation' => $operation,
				'co_name' => $co_username
			);
		}
		$data1[$dag_no]['backlog_court_order'][] = $data_court;
		$data1[$dag_no]['backlogs'][] = $data;
		$data1[$dag_no]['backlogs31'][] = $dataBacklog31;
	//$data1[$dag_no]['appeal147'][] = $appeal147;
	// this is the End to col8 order details
		$d = $this->getCol31Kar($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no);
		$data1[$dag_no]['col31'][] = $d;
		$lmnotes = $this->getLmNotes($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no);
		$data1[$dag_no]['lmnotes'] = $lmnotes;
		//////////Remarks for LandClass//////////////
		$data1[$dag_no]['classRemark'] = $this->landClass($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no);
		///////////////////////
		$innerquery = "select p_flag,pdar_id,patta_no,dag_por_b,dag_por_k,dag_por_lc,dag_por_g from   chitha_dag_pattadar where dist_code='$district_code' "
		. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
		. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
		. " and dag_no='$dag_no' and TRIM(patta_no)='$patta_no' and  patta_type_code='$patta_code' order by pdar_id";
		$innerdata = $this->db->query($innerquery)->result();
		$data1[$dag_no]['pattadars'] = array();
		foreach ($innerdata as $data) {
	// $p_flag = $data->p_flag;
			$pdar_id = $data->pdar_id;
			$patta_no = trim($data->patta_no);
	//$data1[$dag_no]['col8'] = array();
			$data1[$dag_no]['tenant'] = array();
			$data1[$dag_no]['subtenant'] = array();
			$innerquery2 = "select pdar_name,pdar_father,new_pdar_name,pdar_guard_reln,pdar_add1,Pdar_add2,Pdar_add3 from   chitha_pattadar where dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
			. " and TRIM(patta_no)='$patta_no' and  patta_type_code='$patta_code' and pdar_id=$data->pdar_id order by pdar_id";
	
			$innerdata2 = $this->db->query($innerquery2)->result();
	/* if (!empty($innerdata2)) {
	
	} else {
	
} */
	/* if (!empty($innerdata2)) {
	
	} else {
	
} */
	/* if (!empty($innerdata2)) {
	
	} else {
	
	} */
	foreach ($innerdata2 as $pdardata) {
		$pdar_guardRelation = $pdardata->pdar_guard_reln;
		$innerquery3 = "select guard_rel_desc_as from   master_guard_rel where guard_rel_desc = '$pdar_guardRelation'";
		$innerdata3 = $this->db->query($innerquery3)->result();
		foreach ($innerdata3 as $guard_rel_desc) {
			$relation = $guard_rel_desc->guard_reln_desc_as;
		}
		$data1[$dag_no]['pattadars'][] = array(
			'p_flag' => $data->p_flag,
			'dag_por_b' => $data->dag_por_b,
			'dag_por_k' => $data->dag_por_k,
			'dag_por_lc' => $data->dag_por_lc,
			'dag_por_g' => $data->dag_por_g,
			'pdar_name' => $pdardata->pdar_name,
			'guard_reln_desc_as' => $relation,
			'new_pdar_name' => $pdardata->new_pdar_name,
			'pdar_father' => $pdardata->pdar_father,
			'pdar_relation' => $pdardata->pdar_guard_reln,
			'pdar_address1' => $pdardata->pdar_add1,
			'pdar_address2' => $pdardata->pdar_add2,
			'pdar_address3' => $pdardata->pdar_add3,
			'pdar_guard_reln' => $pdardata->pdar_guard_reln,
			'pdar_id' => $pdar_id
		);
	}
	if (is_int($dag_no)){
		$sql = "Select * from   khatian where dist_code='$district_code' "
		. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
		. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no='$dag_no' ";
		$khatia = $this->db->query($sql)->row();
		if (sizeof($khatia) > 0) {
			$innerquery15 = " select tenant_name,tenants_father,tenants_add1,tenants_add2,type_of_tenant,khatian_no,tenant_id,status from   chitha_tenant where dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and khatian_no='$khatia->id' order by tenant_id";
			$innerdata15 = $this->db->query($innerquery15)->result();
			foreach ($innerdata15 as $tenant) {
				if ($tenant->type_of_tenant == null) {
					$tenant_typ = "00";
				} else {
					$tenant_typ = $tenant->type_of_tenant;
				}
				$tenant_name = $tenant->tenant_name;
				$tenants_father = $tenant->tenants_father;
				$tenants_add1 = $tenant->tenants_add1;
				$tenants_add2 = $tenant->tenants_add2;
				$type_of_tenant = $tenant_typ;
				$khatian_no = $tenant->khatian_no;
				$status = $tenant->status;
	//$revenue_tenant = $tenant->revenue_tenant;
	//$crop_rate = $tenant->crop_rate;
				$tenant_id = $tenant->tenant_id;
				if ($tenant->type_of_tenant == null) {
					$tenant_typ = "00";
				} else {
					$tenant_typ = $tenant->type_of_tenant;
				}
				$tenant_name = $tenant->tenant_name;
				$tenants_father = $tenant->tenants_father;
				$tenants_add1 = $tenant->tenants_add1;
				$tenants_add2 = $tenant->tenants_add2;
	//$tenants_add3 = $tenant->tenants_add3;
				$type_of_tenant = $tenant_typ;
				$khatian_no = $tenant->khatian_no;
				$status = $tenant->status;
	//$revenue_tenant = $tenant->revenue_tenant;
	//$crop_rate = $tenant->crop_rate;
				$tenant_id = $tenant->tenant_id;
				if ($tenant->type_of_tenant == "00") {
					$tenant_typ = "";
				} else {
					$tenant_typ = $tenant->type_of_tenant;
				}
				$tenant_name = $tenant->tenant_name;
				$tenants_father = $tenant->tenants_father;
				$tenants_add1 = $tenant->tenants_add1;
				$tenants_add2 = $tenant->tenants_add2;
	//$tenants_add3 = $tenant->tenants_add3;
				$type_of_tenant = $tenant_typ;
				$khatian_no = $tenant->khatian_no;
				$status = $tenant->status;
	// $revenue_tenant = $tenant->revenue_tenant;
	//$crop_rate = $tenant->crop_rate;
				$tenant_id = $tenant->tenant_id;
				$innerquery16 = "Select tenant_type from   Tenant_type where type_code ='$type_of_tenant'";
				$innerdata16 = $this->db->query($innerquery16)->result();
				foreach ($innerdata16 as $tenanttype) {
					$tenant_type = $tenanttype->tenant_type;
					$data1[$dag_no]['tenant'][] = array(
						'tenant_name' => $tenant->tenant_name,
						'tenants_father' => $tenant->tenants_father,
						'tenants_add1' => $tenant->tenants_add1,
						'tenants_add2' => $tenant->tenants_add2,
	//'tenants_add3' => $tenant->tenants_add3,
						'type_of_tenant' => $tenant->type_of_tenant,
						'khatian_no' => $tenant->khatian_no,
						'status' => $tenant->status,
	// 'revenue_tenant' => $tenant->revenue_tenant,
	//'crop_rate' => $tenant->crop_rate,
						'tenant_type' => $tenanttype->tenant_type,
					);
				}
			}
			$innerquery17 = "Select subtenant_name,subtenants_father,subtenants_add1,subtenants_add2,subtenants_add3 from   Chitha_Subtenant where  dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and Dag_no='$dag_no' and tenant_id = '$tenant_id'";
			$innerdata17 = $this->db->query($innerquery17)->result();
			$subtenant_name = "";
			$subtenants_father = "";
			$subtenants_add1 = "";
			$subtenants_add2 = "";
			$subtenants_add = "";
			foreach ($innerdata17 as $subtenant) {
				$subtenant_name = $subtenant->subtenant_name;
				$subtenants_father = $subtenant->subtenants_father;
				$subtenants_add1 = $subtenant->subtenants_add1;
				$subtenants_add2 = $subtenant->subtenants_add2;
				$subtenants_add3 = $subtenant->subtenants_add3;
				$data1[$dag_no]['subtenant'][] = array(
					'subtenant_name' => $subtenant->subtenant_name,
					'subtenants_father' => $subtenant->subtenants_father,
					'subtenants_add1' => $subtenant->subtenants_add1,
					'subtenants_add2' => $subtenant->subtenants_add2,
					'subtenants_add3' => $subtenant->subtenants_add3,
				);
			}
		}
	}
}
	//modification by bondita
$sysyear = date("Y");
	
$data1[$dag_no]['archeo'] = array();
$data1[$dag_no]['noncrp'] = array();
$data1[$dag_no]['mcrp'] = array();
$data1[$dag_no]['fruit'] = array();
$data1[$dag_no]['mcrp_akeadhig'] = array();
$data1[$dag_no]['years'] = array();
$year1 = $sysyear;
$year = ($year1 - 2);
for ($j = 0; $j < 3; $j++) {
	$innerquerynoncrp = "select type_of_used_noncrop,noncrop_land_area_b,noncrop_land_area_k,noncrop_land_area_lc,noncrop_land_area_g from   chitha_noncrop where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' and yn='$year'";
	$innerdatanoncrp = $this->db->query($innerquerynoncrp)->result();
	foreach ($innerdatanoncrp as $noncrop) {
		$type_of_used_noncrp = $noncrop->type_of_used_noncrop;
		$noncrp_b = $noncrop->noncrop_land_area_b;
		$noncrop_k = $noncrop->noncrop_land_area_k;
		$noncrop_lc = $noncrop->noncrop_land_area_lc;
		$noncrop_g = $noncrop->noncrop_land_area_g;
		$innerquery19 = "select noncrop_type from   used_noncrop_type where used_noncrop_type_code = '$type_of_used_noncrp'";
		$innerdata19 = $this->db->query($innerquery19)->result();
		foreach ($innerdata19 as $noncrptyp) {
			$noncrop_type = $noncrptyp->noncrop_type;
			$data1[$dag_no]['noncrp'][] = array(
				'year' => $year,
				'type_of_used_noncrp' => $noncrop_type,
				'noncrp_b' => $noncrp_b,
				'noncrop_k' => $noncrop_k,
				'noncrop_lc' => $noncrop_lc,
				'noncrop_g' => $noncrop_g
			);
		}
	}
	$innerquerycrp = " select source_of_water,crop_code,crop_land_area_b,crop_land_area_k,crop_land_area_lc,crop_land_area_g,crop_categ_code from   chitha_mcrop where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' and yearno='$year' and crop_code<>'057' ";
	$innerdatacrp = $this->db->query($innerquerycrp)->result();
	foreach ($innerdatacrp as $mcropdetails) {
		$source_of_water = $mcropdetails->source_of_water;
		$crop_code = $mcropdetails->crop_code;
		$crop_land_area_b = $mcropdetails->crop_land_area_b;
		$crop_land_area_k = $mcropdetails->crop_land_area_k;
		$crop_land_area_lc = $mcropdetails->crop_land_area_lc;
		$crop_land_area_g = $mcropdetails->crop_land_area_g;
		$crop_category = $mcropdetails->crop_categ_code;
		$innerquerywatersrc = "select source from   source_water where water_source_code = '$source_of_water'";
		$innerdatawatersrc = $this->db->query($innerquerywatersrc)->result();
		foreach ($innerdatawatersrc as $watersrc) {
			$sourceOFwater = $watersrc->source;
			$innerqueryCropCateg = "select crop_categ_desc from   crop_category_code where crop_categ_code = '$crop_category'";
			$innerdataCropcateg = $this->db->query($innerqueryCropCateg)->result();
			foreach ($innerdataCropcateg as $CropDesc) {
				$CropDesc_inChitha = $CropDesc->crop_categ_desc;
				$innerquerymcrop = "select crop_name from   crop_code where crop_code = '$crop_code'";
				$innerdatamcrop = $this->db->query($innerquerymcrop)->result();
				foreach ($innerdatamcrop as $cropinfo) {
					$cropname = $cropinfo->crop_name;
					$data1[$dag_no]['mcrp'][] = array(
						'sourceofwater' => $sourceOFwater,
						'cropname' => $cropname,
						'mcrp_b' => $crop_land_area_b,
						'mcrop_k' => $crop_land_area_k,
						'mcrop_lc' => $crop_land_area_lc,
						'mcrop_g' => $crop_land_area_g,
						'crop_category' => $CropDesc_inChitha
					);
				}
			}
		}
	}
	$innerquerycrp_ekadhig = " select crop_land_area_b,crop_land_area_k,crop_land_area_lc,crop_land_area_g from   chitha_mcrop where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' and yearno='$year' and crop_code = '057' ";
	
	$innerdatacrp_ekadhig = $this->db->query($innerquerycrp_ekadhig)->result();
	foreach ($innerdatacrp_ekadhig as $ekadhig)
		$data1[$dag_no]['mcrp_akeadhig'][] = array(
			'bigha' => $ekadhig->crop_land_area_b,
			'katha' => $ekadhig->crop_land_area_k,
			'lesa' => $ekadhig->crop_land_area_lc,
			'ganda'=>$ekadhig->crop_land_area_g
		);
	$data1[$dag_no]['years'][] = array(
		'year' => $year
	);
	$year = ($year + 1);
}
$innerquery23 = "select fruit_plants_name,no_of_plants,fruit_land_area_b,fruit_land_area_k,fruit_land_area_lc,fruit_land_area_g from   chitha_fruit where dist_code='$district_code' "
. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' ORDER BY Fruit_plant_ID";
$innerdata23 = $this->db->query($innerquery23)->result();
foreach ($innerdata23 as $chithafruitinf) {
	$fruit_plants_name = $chithafruitinf->fruit_plants_name;
	$no_of_fruit_plants = $chithafruitinf->no_of_plants;
	$fruit_bigha = $chithafruitinf->fruit_land_area_b;
	$fruit_katha = $chithafruitinf->fruit_land_area_k;
	$fruit_lesa = $chithafruitinf->fruit_land_area_lc;
	$fruit_ganda = $chithafruitinf->fruit_land_area_g;
	$innerquery24 = "select fruit_name from   fruit_tree_code where fruit_code='$fruit_plants_name'";
	$innerdata24 = $this->db->query($innerquery24)->result();
	foreach ($innerdata24 as $fruitinfo) {
		$fruit_name = $fruitinfo->fruit_name;
		$data1[$dag_no]['fruit'][] = array(
			'fruitname' => $fruit_name,
			'no_of_plants' => $no_of_fruit_plants,
			'fbigha' => $fruit_bigha,
			'fkatha' => $fruit_katha,
			'flesa' => $fruit_lesa,
			'fganda' => $fruit_ganda
		);
	}
}
$chithaarcheo = "select archeo_hist_code,hist_land_area_b,hist_land_area_k,hist_land_area_lc,hist_land_area_g,archeo_hist_site_desc from   chitha_acho_hist where dist_code='$district_code' "
. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no'";
	
$innerdataarcheo = $this->db->query($chithaarcheo)->result();
	foreach ($innerdataarcheo as $archeoinfo) {
	$archeo_code = $archeoinfo->archeo_hist_code;
	$archeo_area_b = $archeoinfo->hist_land_area_b;
	$archeo_area_k = $archeoinfo->hist_land_area_k;
	$archeo_area_lc = $archeoinfo->hist_land_area_lc;
	$archeo_area_g = $archeoinfo->hist_land_area_g;
	$archeo_area_description = $archeoinfo->archeo_hist_site_desc;
	$archeo_siteCd = "select archeo_hist_desc from   archeo_hist_site_code where archeo_hist_code='$archeo_code' ";
	$innerdataarcheo_cd = $this->db->query($archeo_siteCd)->result();
	foreach ($innerdataarcheo_cd as $archeo_cd) {
		$hist_description = $archeo_cd->archeo_hist_desc;
		$data1[$dag_no]['archeo'][] = array(
			'hist_description_nme' => $hist_description,
			'archeo_hist_code' => $archeo_code,
			'archeo_b' => $archeo_area_b,
			'archeo_k' => $archeo_area_k,
			'archeo_lc' => $archeo_area_lc,
			'archeo_g' => $archeo_area_g,
			'archeo_decribed' => $archeo_area_description
		);
	}
}
$innerquery58 = "SELECT encro_evicted_yn,encro_name,encro_since,encro_land_b,encro_land_k,encro_land_lc,encro_land_g,encro_land_used_for,encro_evic_date FROM  chitha_rmk_encro where  dist_code='$district_code' "
. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' "; //and rmk_type_hist_no='$rmk_type_hist_no' ";
	$innerdata58 = $this->db->query($innerquery58)->result();
	foreach ($innerdata58 as $encro) {
		$encro_land_used_for = $encro->encro_land_used_for;
		$innerquery_encroland = "SELECT used_for from   encro_land_used_for where code='$encro_land_used_for' ";
		$innerdata_encroland = $this->db->query($innerquery_encroland)->result();
		foreach ($innerdata_encroland as $encro_land) {
			$data1[$dag_no]['encro'][] = array(
				'encro_evicted_yn' => $encro->encro_evicted_yn,
				'encro_name' => $encro->encro_name,
				'encro_since' => $encro->encro_since,
				'encro_land_b' => $encro->encro_land_b,
				'encro_land_k' => $encro->encro_land_k,
				'encro_land_lc' => $encro->encro_land_lc,
				'encro_land_g' => $encro->encro_land_g,
				'encro_land_used_for' => $encro->encro_land_used_for,
				'encro_evic_date' => $encro->encro_evic_date,
				'land_used_by_encro' => $encro_land->used_for
			);
		}
	}
	//sro note
	$sroCheck=$this->govtDagSro($district_code,$subdivision_code,$circlecode,$mouzacode,$lot_code,$village_code,$dag_no);
	if($sroCheck===false)
	{
	$innerquery_sro = "
	select a.dag_area_b,a.dag_area_k,a.dag_area_lc,a.dag_area_g,a.reg_to_name,a.reg_from_name,a.name_of_sro,a.deed_no,a.date_of_deed,a.status,a.deed_type from sro_note a join landschedule b on a.nocno=b.appno and a.dist_code= b.distcode and a.subdiv_code=b.subcode
	and a.cir_code=b.circode and a.mouza_pargona_code=b.mouzacode and a.lot_no=b.lotno and a.vill_townprt_code=b.villcode
	and a.dag_no=b.dagno and a.patta_no=b.pattano and a.patta_type_code=b.pattatype
	where a.dist_code=? 
	and a.subdiv_code=? and a.cir_code=? and 
	a.mouza_pargona_code=? and  a.lot_no=? and a.vill_townprt_code=? and a.dag_no =?
	 "; //and rmk_type_hist_no='$rmk_type_hist_no' ";
	$innerdata_sro_note = $this->db->query($innerquery_sro,[$district_code,$subdivision_code,$circlecode,$mouzacode,$lot_code,$village_code,$dag_no])->result();
	foreach ($innerdata_sro_note as $sro) {
		$data1[$dag_no]['sro'][] = array(
			'dag_no' => $dag_no,
			'dag_area_b' => $sro->dag_area_b,
			'dag_area_k' => $sro->dag_area_k,
			'dag_area_lc' => $sro->dag_area_lc,
			'dag_area_g' => $sro->dag_area_g,
			'reg_to_name' => $sro->reg_to_name,
			'reg_from_name' => $sro->reg_from_name,
			'name_of_sro' => $sro->name_of_sro,
			'deed_no' => $sro->deed_no,
			'date_of_deed' => $sro->date_of_deed,
			'status' => $sro->status,
			'deed_type' => $sro->deed_type
		);
	}
	}
	//lm note
	$innerquery_LMNOTE = "select  lm_note,lm_note_date,lm_code FROM  chitha_rmk_lmnote where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' ";
	$innerdata_LMNOTE = $this->db->query($innerquery_LMNOTE)->result();
	foreach ($innerdata_LMNOTE as $lmnote) {
		$q = "Select lm_name from   lm_code where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lmnote->lm_code' ";
		$lm_name = $this->db->query($q)->row()->lm_name;
		$lm_note = $lmnote->lm_note;
		$lm_note_date = $lmnote->lm_note_date;
		$lm_code = $lmnote->lm_code;
		$data1[$dag_no]['lmnote'][] = array(
			'lm_note' => $lmnote->lm_note,
			'lm_code' => $lm_name,
			'lm_note_date' => $lmnote->lm_note_date
		);
	}
}
	//result encro
	//modification ends here
	//            $sysyear = date("Y");
	//            for ($j = 0; $j < 3; $j++) {
	//                $year = $sysyear;
	//
	//                $sysyear = ($sysyear - 1);
	//
	//
	//
	//                $innerquery18 = "select type_of_used_noncrop,noncrop_land_area_b,noncrop_land_area_k,noncrop_land_area_lc from   chitha_noncrop where dist_code='$district_code' "
	//                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	//                        . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' and yn='$year' ";
	//                $innerdata18 = $this->db->query($innerquery18)->result();
	//                foreach ($innerdata18 as $noncropInfo) {
	//
	//                    $type_of_used_noncrop = $noncropInfo->type_of_used_noncrop;
	//                    $noncrop_land_area_b = $noncropInfo->noncrop_land_area_b;
	//                    $noncrop_land_area_k = $noncropInfo->noncrop_land_area_k;
	//                    $noncrop_land_area_lc = $noncropInfo->noncrop_land_area_lc;
	//
	//                    $innerquery19 = "select noncrop_type from   used_noncrop_type where used_noncrop_type_code = '$type_of_used_noncrop'";
	//                    $innerdata19 = $this->db->query($innerquery19)->result();
	//                    foreach ($innerdata19 as $noncrptyp) {
	//                        $noncrop_type = $noncrptyp->noncrop_type;
	//                    }
	//                }
	//
	//
	//
	//
	//
	//                $innerquery20 = " select source_of_water,crop_code,crop_land_area_b,crop_land_area_k,crop_land_area_lc from   chitha_mcrop where dist_code='$district_code' "
	//                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	//                        . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' and yearno='$year' and crop_code<>'057' ";
	//
	//                $innerdata20 = $this->db->query($innerquery20)->result();
	//                foreach ($innerdata20 as $mcropdetails) {
	//                    $source_of_water = $mcropdetails->source_of_water;
	//                    $crop_code = $mcropdetails->crop_code;
	//                    $crop_land_area_b = $mcropdetails->crop_land_area_b;
	//                    $crop_land_area_k = $mcropdetails->crop_land_area_k;
	//                    $crop_land_area_lc = $mcropdetails->crop_land_area_lc;
	//
	//                    $innerquery21 = " select source from   source_water where water_source_code = '$source_of_water'";
	//                    $innerdata21 = $this->db->query($innerquery21)->result();
	//                    foreach ($innerdata21 as $watersrc) {
	//
	//                        $sourceOFwater = $watersrc->source;
	//                    }
	//
	//                    $innerquery22 = "select crop_name from   crop_code where crop_code = '$crop_code'";
	//                    $innerdata22 = $this->db->query($innerquery22)->result();
	//                    foreach ($innerdata22 as $cropinfo) {
	//                        $cropname = $cropinfo->crop_name;
	//                    }
	//                }
	//            }
	//            $innerquery23 = "select fruit_plants_name from   chitha_fruit where dist_code='$district_code' "
	//                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	//                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' ORDER BY Fruit_plant_ID";
	//
	//            $innerdata23 = $this->db->query($innerquery23)->result();
	//            foreach ($innerdata23 as $chithafruitinf) {
	//
	//                $fruit_plants_name = $chithafruitinf->fruit_plants_name;
	//
	//
	//                $innerquery24 = "select fruit_name from   fruit_tree_code where fruit_code='$fruit_plants_name'";
	//                $innerdata24 = $this->db->query($innerquery24)->result();
	//                foreach ($innerdata24 as $fruitinfo) {
	//                    $fruit_name = $fruitinfo->fruit_name;
	//                }
	//            }
	//
	//
	//            //for remark column
	//            $innerquery25 = "select dag_area_b,dag_area_k,dag_area_lc,reg_from  _name,deed_type,reg_to_name,name_of_sro,deed_no,date_of_deed from   sro_note where dag_no='$dag_no'";
	//            $innerdata25 = $this->db->query($innerquery25)->result();
	//            foreach ($innerdata25 as $sronoteInfo) {
	//                $dag_area_b = $sronoteInfo->dag_area_b;
	//                $dag_area_k = $sronoteInfo->dag_area_k;
	//                $dag_area_lc = $sronoteInfo->dag_area_lc;
	//            }
	//        }
	// ini_set('xdebug.var_display_max_depth', 15);
	//ini_set('xdebug.var_display_max_children', 256);
	// ini_set('xdebug.var_display_max_data', 1024);
	return $data1;
}
public function getchithaDetailsALLOLDDATA($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper,$year_no) {
	//$this->db = $CI->load->database('db', TRUE);
	$this->dbswitch();
	ini_set('max_execution_time', 0);
	$q = "Select cb.old_dag_no, cb.dag_no,cb.dag_no_int,cb.patta_no,cb.dag_area_b,cb.dag_area_k,cb.dag_area_lc,cb.dag_revenue,
	cb.dag_local_tax,lcc.land_type,cb.col8,cb.col9,cb.col10,cb.col11,cb.col12,cb.col13,cb.col14,cb.col15,cb.col16,cb.col17,cb.col30,cb.col31,cb.year_no from   chitha_basic_doul AS cb JOIN landclass_code
	AS lcc ON cb.land_class_code = lcc.class_code where Dist_code='$district_code' and Subdiv_code='$subdivision_code'
	and Cir_code='$circlecode'
	and Mouza_Pargona_code='$mouzacode' and Lot_No='$lot_code' and Vill_townprt_code='$village_code'
	and CAST(coalesce(cb.dag_no_int, '0') AS numeric)>=$dag_no_lower and
	CAST(coalesce(cb.dag_no_int, '0') AS numeric)<=$dag_no_upper and year_no = '$year_no' order by CAST(coalesce(cb.dag_no_int, '0') AS numeric)";
	$district = $this->db->query("
		Select cb.old_dag_no, cb.dag_no,cb.patta_no,cb.patta_type_code,cb.dag_area_b,cb.dag_area_k,cb.dag_area_lc,cb.dag_revenue,
		cb.dag_local_tax,lcc.land_type,lcc.class_code_cat,cb.col8,cb.col9,cb.col10,cb.col11,cb.col12,cb.col13,cb.col14,cb.col15,cb.col16,cb.col17,cb.col30,cb.col31,cb.year_no from   chitha_basic_doul AS cb JOIN landclass_code
		AS lcc ON cb.land_class_code = lcc.class_code where Dist_code='$district_code' and Subdiv_code='$subdivision_code'
		and Cir_code='$circlecode'
		and Mouza_Pargona_code='$mouzacode' and Lot_No='$lot_code' and Vill_townprt_code='$village_code'
		and CAST(coalesce(cb.dag_no_int, '0') AS numeric)>=$dag_no_lower and
		CAST(coalesce(cb.dag_no_int, '0') AS numeric)<=$dag_no_upper and year_no = '$year_no' order by CAST(coalesce(cb.dag_no_int, '0') AS numeric)");
	$data1 = array();
	$outerdata = $district->result();
	$innerdata = array();
	$relation = array();
	//this is the start of the loop for each dag..
	foreach ($outerdata as $chithadetails) {
		$patta_no = trim($chithadetails->patta_no);
		$dag_no = $chithadetails->dag_no;
		$patta_code = $chithadetails->patta_type_code;
		$patta_type_name = $this->db->query("Select patta_type as patta_type_name from   patta_code where type_code ='$patta_code'")->row()->patta_type_name;
	
		$data1[$dag_no] = array(
			'old_dag_no' => $chithadetails->old_dag_no,
			'dag_no' => $chithadetails->dag_no,
			'patta_no' => trim($chithadetails->patta_no),
			'patta_type_name' => $patta_type_name,
			'dag_area_b' => $chithadetails->dag_area_b,
			'dag_area_k' => $chithadetails->dag_area_k,
			'dag_area_lc' => $chithadetails->dag_area_lc,
			'dag_revenue' => $chithadetails->dag_revenue,
			'dag_localtax' => $chithadetails->dag_local_tax,
			'land_type' => $chithadetails->land_type,
			'class_code_cat' => $chithadetails->class_code_cat,
			'col8' => $chithadetails->col8,
			'col9' => $chithadetails->col9,
			'col10' => $chithadetails->col10,
			'col11' => $chithadetails->col11,
			'col12' => $chithadetails->col12,
			'col13' => $chithadetails->col13,
			'col14' => $chithadetails->col14,
			'col15' => $chithadetails->col15,
			'col16' => $chithadetails->col16,
			'col17' => $chithadetails->col17,
			'col30' => $chithadetails->col30,
			'col31' => $chithadetails->col31,
			'year_no' => '2017'
		);
		$innerquery = "select p_flag,pdar_id,patta_no,dag_por_b,dag_por_k,dag_por_lc from   chitha_dag_pattadar_doul where dist_code='$district_code' "
		. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
		. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
		. " and dag_no='$dag_no' and TRIM(patta_no)='$patta_no' and  patta_type_code='$patta_code' and year_no = '$year_no' order by pdar_id";
		$innerdata = $this->db->query($innerquery)->result();
		$data1[$dag_no]['pattadars'] = array();
		foreach ($innerdata as $data) {
	// $p_flag = $data->p_flag;
			$pdar_id = $data->pdar_id;
			$patta_no = trim($data->patta_no);
	//$data1[$dag_no]['col8'] = array();
			$data1[$dag_no]['tenant'] = array();
			$data1[$dag_no]['subtenant'] = array();
			$innerquery2 = "select pdar_name,pdar_father,new_pdar_name,pdar_guard_reln,pdar_add1,Pdar_add2,Pdar_add3 from   chitha_pattadar_doul where dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
			. " and TRIM(patta_no)='$patta_no' and  patta_type_code='$patta_code' and year_no = '$year_no' and pdar_id=$data->pdar_id order by pdar_id";
	
			$innerdata2 = $this->db->query($innerquery2)->result();
			foreach ($innerdata2 as $pdardata) {
				$pdar_guardRelation = $pdardata->pdar_guard_reln;
				$innerquery3 = "select guard_rel_desc_as from   master_guard_rel where guard_rel_desc = '$pdar_guardRelation'";
				$innerdata3 = $this->db->query($innerquery3)->result();
				foreach ($innerdata3 as $guard_rel_desc) {
					$relation = $guard_rel_desc->guard_reln_desc_as;
				}
				$data1[$dag_no]['pattadars'][] = array(
					'p_flag' => $data->p_flag,
					'dag_por_b' => $data->dag_por_b,
					'dag_por_k' => $data->dag_por_k,
					'dag_por_lc' => $data->dag_por_lc,
					'pdar_name' => $pdardata->pdar_name,
					'guard_reln_desc_as' => $relation,
					'new_pdar_name' => $pdardata->new_pdar_name,
					'pdar_father' => $pdardata->pdar_father,
					'pdar_relation' => $pdardata->pdar_guard_reln,
					'pdar_address1' => $pdardata->pdar_add1,
					'pdar_address2' => $pdardata->pdar_add2,
					'pdar_address3' => $pdardata->pdar_add3,
					'pdar_guard_reln' => $pdardata->pdar_guard_reln,
					'pdar_id' => $pdar_id
				);
			}
		}
	}
	return $data1;
}
public function getchithaDetails123OLDDATA($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper, $patta_code, $year_no) {
	$this->dbswitch();
	ini_set('max_execution_time', 0);
	$q = "Select cb.old_dag_no, cb.dag_no,cb.dag_no_int,cb.patta_no,cb.dag_area_b,cb.dag_area_k,cb.dag_area_lc,cb.dag_revenue,cb.dag_local_tax,lcc.land_type,
	cb.col8,cb.col9,cb.col10,cb.col11,cb.col12,cb.col13,cb.col14,cb.col15,cb.col16,cb.col17,cb.col30,cb.col31,cb.year_no from   chitha_basic_doul AS cb JOIN landclass_code
	AS lcc ON cb.land_class_code = lcc.class_code where Dist_code='$district_code' and Subdiv_code='$subdivision_code'
	and Cir_code='$circlecode'
	and Mouza_Pargona_code='$mouzacode' and Lot_No='$lot_code' and Vill_townprt_code='$village_code'
	and CAST(coalesce(cb.dag_no_int, '0') AS numeric)>=$dag_no_lower and
	CAST(coalesce(cb.dag_no_int, '0') AS numeric)<=$dag_no_upper and
	patta_type_code='$patta_code' and year_no = '$year_no' order by CAST(coalesce(cb.dag_no_int, '0') AS numeric)";
	$district = $this->db->query("
		Select cb.old_dag_no, cb.dag_no,cb.patta_no,cb.dag_area_b,cb.dag_area_k,cb.dag_area_lc,cb.dag_revenue,
		cb.dag_local_tax,lcc.land_type,lcc.class_code_cat,cb.col8,cb.col9,cb.col10,cb.col11,cb.col12,cb.col13,cb.col14,cb.col15,cb.col16,cb.col17,cb.col30,cb.col31,cb.year_no from   chitha_basic_doul AS cb JOIN landclass_code
		AS lcc ON cb.land_class_code = lcc.class_code where Dist_code='$district_code' and Subdiv_code='$subdivision_code'
		and Cir_code='$circlecode'
		and Mouza_Pargona_code='$mouzacode' and Lot_No='$lot_code' and Vill_townprt_code='$village_code'
		and CAST(coalesce(cb.dag_no_int, '0') AS numeric)>=$dag_no_lower and
		CAST(coalesce(cb.dag_no_int, '0') AS numeric)<=$dag_no_upper and
		patta_type_code='$patta_code' and year_no = '$year_no' order by CAST(coalesce(cb.dag_no_int, '0') AS numeric)");
	$data1 = array();
	$outerdata = $district->result();
	$innerdata = array();
	$relation = array();
	//this is the start of the loop for each dag..
	foreach ($outerdata as $chithadetails) {
		$patta_no = trim($chithadetails->patta_no);
		$dag_no = $chithadetails->dag_no;
		$patta_type_name = $this->db->query("Select patta_type as patta_type_name from   patta_code where type_code ='$patta_code'")->row()->patta_type_name;
		$data1[$dag_no] = array(
			'old_dag_no' => $chithadetails->old_dag_no,
			'dag_no' => $chithadetails->dag_no,
			'patta_no' => trim($chithadetails->patta_no),
			'patta_type_name' => $patta_type_name,
			'dag_area_b' => $chithadetails->dag_area_b,
			'dag_area_k' => $chithadetails->dag_area_k,
			'dag_area_lc' => $chithadetails->dag_area_lc,
			'dag_revenue' => $chithadetails->dag_revenue,
			'dag_localtax' => $chithadetails->dag_local_tax,
			'land_type' => $chithadetails->land_type,
			'class_code_cat' => $chithadetails->class_code_cat,
			'col8' => $chithadetails->col8,
			'col9' => $chithadetails->col9,
			'col10' => $chithadetails->col10,
			'col11' => $chithadetails->col11,
			'col12' => $chithadetails->col12,
			'col13' => $chithadetails->col13,
			'col14' => $chithadetails->col14,
			'col15' => $chithadetails->col15,
			'col16' => $chithadetails->col16,
			'col17' => $chithadetails->col17,
			'col30' => $chithadetails->col30,
			'col31' => $chithadetails->col31,
			'year_no' => date('Y')
		);
		$innerquery = "select p_flag,pdar_id,patta_no,dag_por_b,dag_por_k,dag_por_lc from   chitha_dag_pattadar_doul where dist_code='$district_code' "
		. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
		. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
		. " and dag_no='$dag_no' and TRIM(patta_no)='$patta_no' and  patta_type_code='$patta_code' and year_no = '$year_no' order by pdar_id";
		$innerdata = $this->db->query($innerquery)->result();
		$data1[$dag_no]['pattadars'] = array();
		foreach ($innerdata as $data) {
	// $p_flag = $data->p_flag;
			$pdar_id = $data->pdar_id;
			$patta_no = trim($data->patta_no);
	//$data1[$dag_no]['col8'] = array();
			$data1[$dag_no]['tenant'] = array();
			$data1[$dag_no]['subtenant'] = array();
			$innerquery2 = "select pdar_name,pdar_father,new_pdar_name,pdar_guard_reln,pdar_add1,Pdar_add2,Pdar_add3 from   chitha_pattadar_doul where dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
			. " and TRIM(patta_no)='$patta_no' and  patta_type_code='$patta_code' and year_no = '$year_no' and pdar_id=$data->pdar_id order by pdar_id";
	
			$innerdata2 = $this->db->query($innerquery2)->result();
			foreach ($innerdata2 as $pdardata) {
				$pdar_guardRelation = $pdardata->pdar_guard_reln;
				$innerquery3 = "select guard_rel_desc_as from   master_guard_rel where guard_rel_desc = '$pdar_guardRelation'";
				$innerdata3 = $this->db->query($innerquery3)->result();
				foreach ($innerdata3 as $guard_rel_desc) {
					$relation = $guard_rel_desc->guard_reln_desc_as;
				}
				$data1[$dag_no]['pattadars'][] = array(
					'p_flag' => $data->p_flag,
					'dag_por_b' => $data->dag_por_b,
					'dag_por_k' => $data->dag_por_k,
					'dag_por_lc' => $data->dag_por_lc,
					'pdar_name' => $pdardata->pdar_name,
					'guard_reln_desc_as' => $relation,
					'new_pdar_name' => $pdardata->new_pdar_name,
					'pdar_father' => $pdardata->pdar_father,
					'pdar_relation' => $pdardata->pdar_guard_reln,
					'pdar_address1' => $pdardata->pdar_add1,
					'pdar_address2' => $pdardata->pdar_add2,
					'pdar_address3' => $pdardata->pdar_add3,
					'pdar_guard_reln' => $pdardata->pdar_guard_reln,
					'pdar_id' => $pdar_id
				);
			}
		}
	}
	return $data1;
}
public function getchithaDetailsALLTest($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper, $year_no) {
	$this->dbswitch();
	ini_set('max_execution_time', 0);
	$q = "Select cb.old_dag_no, cb.dag_no,cb.dag_no_int,cb.patta_no,cb.dag_area_b,cb.dag_area_k,cb.dag_area_lc,cb.dag_revenue,
	cb.dag_local_tax,lcc.land_type from   chitha_basic_doul AS cb JOIN landclass_code
	AS lcc ON cb.land_class_code = lcc.class_code where Dist_code='$district_code' and Subdiv_code='$subdivision_code'
	and Cir_code='$circlecode'
	and Mouza_Pargona_code='$mouzacode' and Lot_No='$lot_code' and Vill_townprt_code='$village_code'
	and CAST(coalesce(cb.dag_no_int, '0') AS numeric)>=$dag_no_lower and
	CAST(coalesce(cb.dag_no_int, '0') AS numeric)<=$dag_no_upper order by CAST(coalesce(cb.dag_no_int, '0') AS numeric)";
	$district = $this->db->query("
		Select cb.old_dag_no, cb.dag_no,cb.patta_no,cb.patta_type_code,cb.dag_area_b,cb.dag_area_k,cb.dag_area_lc,cb.dag_revenue,
		cb.dag_local_tax,lcc.land_type,lcc.class_code_cat  from   chitha_basic_doul AS cb JOIN landclass_code
		AS lcc ON cb.land_class_code = lcc.class_code where Dist_code='$district_code' and Subdiv_code='$subdivision_code'
		and Cir_code='$circlecode'
		and Mouza_Pargona_code='$mouzacode' and Lot_No='$lot_code' and Vill_townprt_code='$village_code'
		and CAST(coalesce(cb.dag_no_int, '0') AS numeric)>=$dag_no_lower and
		CAST(coalesce(cb.dag_no_int, '0') AS numeric)<=$dag_no_upper order by CAST(coalesce(cb.dag_no_int, '0') AS numeric)");
	$data1 = array();
	$outerdata = $district->result();
	$innerdata = array();
	// $chithadetailsArr = array();
	$innerdata2 = array();
	$innerdata3 = array();
	$innerdata4 = array();
	$innerdata5 = array();
	$innerdata6 = array();
	$innerdata7 = array();
	$innerdata8 = array();
	$innerdata9 = array();
	$innerdata10 = array();
	$innerdata11 = array();
	$innerdata12 = array();
	$innerdata13 = array();
	$innerdata14 = array();
	$innerdata15 = array();
	$innerdata16 = array();
	$innerdata17 = array();
	$innerdata18 = array();
	$innerdata19 = array();
	$innerdata20 = array();
	$innerdata21 = array();
	$innerdata22 = array();
	$innerdata23 = array();
	$innerdata24 = array();
	$innerdata25 = array();
	$innerdata26 = array();
	$relation = array();
	//this is the start of the loop for each dag..
	foreach ($outerdata as $chithadetails) {
		$patta_no = trim($chithadetails->patta_no);
		$dag_no = $chithadetails->dag_no;
		$patta_code = $chithadetails->patta_type_code;
		$backlog_court_order = "select * from   backlog_orders where dist_code='$district_code' and subdiv_code='$subdivision_code' and"
		. " cir_code='$circlecode' and lot_no='$lot_code' and mouza_pargona_code='$mouzacode' and "
		. " vill_townprt_code='$village_code' and dag_no='$dag_no' "
		. " and patta_type_code='$patta_code' and category=0";
		$data_court = $this->db->query($backlog_court_order)->result();
		$backlogquery = "select * from   backlog_orders where dist_code='$district_code' and subdiv_code='$subdivision_code' and"
		. " cir_code='$circlecode' and lot_no='$lot_code' and mouza_pargona_code='$mouzacode' and "
		. " vill_townprt_code='$village_code' and dag_no='$dag_no' "
		. " and patta_type_code='$patta_code' and category=1";
		$data = $this->db->query($backlogquery)->result();
		$backlogquery = "select * from   backlog_orders where dist_code='$district_code' and subdiv_code='$subdivision_code' and"
		. " cir_code='$circlecode' and lot_no='$lot_code' and mouza_pargona_code='$mouzacode' and "
		. " vill_townprt_code='$village_code' and dag_no='$dag_no' "
		. " and patta_type_code='$patta_code' and category=2";
		$dataBacklog31 = $this->db->query($backlogquery)->result();
		$patta_type_name = $this->db->query("Select patta_type as patta_type_name from   patta_code where type_code ='$patta_code'")->row()->patta_type_name;
	
		$data1[$dag_no] = array(
			'old_dag_no' => $chithadetails->old_dag_no,
			'dag_no' => $chithadetails->dag_no,
			'patta_no' => trim($chithadetails->patta_no),
			'patta_type_name' => $patta_type_name,
			'dag_area_b' => $chithadetails->dag_area_b,
			'dag_area_k' => $chithadetails->dag_area_k,
			'dag_area_lc' => $chithadetails->dag_area_lc,
			'dag_revenue' => $chithadetails->dag_revenue,
			'dag_localtax' => $chithadetails->dag_local_tax,
			'land_type' => $chithadetails->land_type,
			'class_code_cat' => $chithadetails->class_code_cat,
		);
		$innerquery4 = "select col8order_cron_no,order_type_code,nature_trans_code,mut_land_area_b,"
		. " mut_land_area_k,mut_land_area_lc,user_code,rajah_adalat,lm_code,case_no,co_ord_date,deed_reg_no,deed_value,deed_date from   Chitha_col8_order where dist_code='$district_code' "
		. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
		. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and year_no ='$year_no' and (dag_no='$dag_no' ) ";
		$innerdata4 = $this->db->query($innerquery4)->result();
	// this is the start to col8 order details
		foreach ($innerdata4 as $col8OrderDetails) {
			$col8order_cron_no = $col8OrderDetails->col8order_cron_no;
			$order_type_code = $col8OrderDetails->order_type_code;
			$nature_trans_code = $col8OrderDetails->nature_trans_code;
			$mut_land_area_b = $col8OrderDetails->mut_land_area_b;
			$mut_land_area_k = $col8OrderDetails->mut_land_area_k;
			$mut_land_area_lc = $col8OrderDetails->mut_land_area_lc;
			$user_code = $col8OrderDetails->user_code;
			$rajah_adalat = $col8OrderDetails->rajah_adalat;
			$lm_code = $col8OrderDetails->lm_code;
			$case_no = $col8OrderDetails->case_no;
			$co_ord_date = $col8OrderDetails->co_ord_date;
			$deed_value = $col8OrderDetails->deed_value;
			$deed_reg_no = $col8OrderDetails->deed_reg_no;
			$deed_date = $col8OrderDetails->deed_date;
			$inplace_of_name = "";
			$inplaceof_alongwith = "";
			$occupant_name = "";
			$occupant_fmh_name = "";
			$occupant_fmh_flag = "";
			$new_patta_no = "";
			$new_dag_no = "";
			$hus_wife = "";
			$nature_trans_desc = "";
			$lm_name = "";
			$innerquery5 = "select order_type from   master_field_mut_type
			where  order_type_code = '$order_type_code' ";
	
			$innerdata5 = $this->db->query($innerquery5)->row();
			$ordertype = $innerdata5->order_type;
			$innerquery6 = "select inplace_of_name,inplaceof_alongwith from   chitha_col8_inplace
			where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' "
			. "and  mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and "
			. " vill_townprt_code='$village_code' and Dag_no='$dag_no' and Col8Order_cron_no='$col8order_cron_no' "
			. " ORDER BY inplace_of_id";
			$innerdata6 = $this->db->query($innerquery6)->result();
			$inplace_data = array();
			$innerquery7 = "select trans_desc_as from   nature_trans_code where trans_code = '$nature_trans_code'";
	
	//$nature_trans_desc = $this->db->query($innerquery7)->row()->trans_desc_as;
			foreach ($innerdata6 as $inplace) {
				$inplace_data[] = array(
					'inplace_of_name' => $inplace->inplace_of_name,
					'inplaceof_alongwith' => $inplace->inplaceof_alongwith,
				);
			}
			$occup_data = array();
			$innerquery8 = "select occupant_name,occupant_fmh_name,occupant_fmh_flag,new_patta_no,new_dag_no,hus_wife from   "
			. " chitha_col8_occup where dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
			. " and (dag_no='$dag_no' or new_dag_no='$dag_no')  and Col8Order_cron_no='$col8order_cron_no' and user_code='$co_code'   ORDER BY occupant_id";
			$innerdata8 = $this->db->query($innerquery8)->result();
			foreach ($innerdata8 as $occupant) {
				$occupant_name = $occupant->occupant_name;
				$occupant_fmh_name = $occupant->occupant_fmh_name;
				$occupant_fmh_flag = $occupant->occupant_fmh_flag;
				$new_patta_no = trim($occupant->new_patta_no);
				$new_dag_no = $occupant->new_dag_no;
				$hus_wife = $occupant->hus_wife;
				$innerquery9 = "select guard_rel_desc_as from   master_guard_rel where guard_rel = '$occupant_fmh_flag'";
				$innerdata9 = $this->db->query($innerquery9)->result();
				$guard_rel_desc_as = "";
				foreach ($innerdata9 as $guard_rel) {
					$guard_rel_desc_as = $guard_rel->guard_rel_desc_as;
				}
				$occup_data[] = array(
					'occupant_name' => $occupant->occupant_name,
					'occupant_fmh_name' => $occupant->occupant_fmh_name,
					'occupant_fmh_flag' => $occupant->occupant_fmh_flag,
					'new_patta_no' => trim($occupant->new_patta_no),
					'new_dag_no' => $occupant->new_dag_no,
					'hus_wife' => $occupant->hus_wife,
					'guard_rel_desc_as' => $guard_rel_desc_as
				);
			}
			$innerquery10 = "select lm_name from   lm_code  where dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code = '$lm_code' ";
	
			$innerdata10 = $this->db->query($innerquery10)->result();
			foreach ($innerdata10 as $lm) {
				$lm_name = $lm->lm_name;
			}
			$innerquery11 = "select username,status from   users where dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code='$user_code'";
			$innerdata11 = $this->db->query($innerquery11)->result();
			foreach ($innerdata11 as $users) {
				$username = $users->username;
				$status = $users->status;
			}
			if ($order_type_code == '03') {
	$innerquery12 = "select * from   field_mut_objection where objection_case_no='$case_no' "; //and  obj_flag is not null and chitha_correct_yn='1' ";
	$innerdata12 = $this->db->query($innerquery12)->result();
	foreach ($innerdata12 as $objection) {
		$q = "select col8order_cron_no,dag_no from   chitha_col8_order where case_no='$objection->prev_fm_ca_no' and year_no ='$year_no' ";
		$col8_cronNo = $this->db->query($q)->row();
		$q = "select occupant_name from   chitha_col8_occup where dist_code='$district_code' "
		. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
		. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and
		col8order_cron_no='$col8_cronNo->col8order_cron_no' and dag_no='$col8_cronNo->dag_no'  ";
		$result = $this->db->query($q)->result();
		$fname = "";
		foreach ($result as $name) {
			$fname = $fname . $name->occupant_name . ",";
		}
		$data1[$dag_no]['objection'][] = array(
			'mut_type' => $objection->mut_type,
			'regist_date' => $objection->regist_date,
			'objection_case_no' => $objection->objection_case_no,
			'prev_fm_ca_no' => $objection->prev_fm_ca_no,
			'submission_date' => $objection->entry_date,
			'obj_name' => $objection->obj_name,
			'co_id' => $objection->co_id,
			'occupant' => $fname
		);
	}
}
$innerquery13 = "select * from   field_mut_petitioner where case_no='$case_no' ";
$innerdata13 = $this->db->query($innerquery13)->result();
if ($order_type_code == '01') {
	$innerquery14 = " select deed_reg_no,deed_value,deed_date from   chitha_col8_order
	where Order_type_code='$order_type_code' and dag_no='$dag_no' and case_no='$case_no'";
	
	$innerdata14 = $this->db->query($innerquery14)->result();
	foreach ($innerdata14 as $deedinf) {
		$deed_reg_no = $deedinf->deed_reg_no;
		$deed_value = $deedinf->deed_value;
		$deed_date = $deedinf->deed_date;
	}
}else if ($order_type_code == '13') {
	$innerquery15 = "select array_to_string(ARRAY_AGG (tenant_name),',') as name from   chitha_col8_tenant
	where dag_no='$dag_no' and dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and case_no='$case_no' and pdar_type='B' group by pdar_type";
	$applicant = $this->db->query($innerquery15)->row()->name;
	$innerquery15 = "select array_to_string(ARRAY_AGG (tenant_name),',') as name from   chitha_col8_tenant
	where dag_no='$dag_no' and dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and case_no='$case_no' and pdar_type='O' and inplace_alongwith='i' group by pdar_type";
	$inplaceofName = $this->db->query($innerquery15);
	if($inplaceofName->num_rows()>0){
		$inplaceofName=$inplaceofName->row()->name;
	}else{
		$inplaceofName=null;
	}
	$innerquery16 = "select array_to_string(ARRAY_AGG (tenant_name),',') as name from   chitha_col8_tenant
	where dag_no='$dag_no' and dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and case_no='$case_no' and pdar_type='O' and inplace_alongwith='a' group by pdar_type";
	$alongwith = $this->db->query($innerquery16);
	if($alongwith->num_rows()>0){
		$alongwith=$alongwith->row()->name;
	}else{
		$alongwith=null;
	}
}
	
if ($order_type_code != '03') {
	$data1[$dag_no]['col8'][] = array(
		'co_ord_date' => $col8OrderDetails->co_ord_date,
		'order_type_code' => $col8OrderDetails->order_type_code,
		'case_no' => $col8OrderDetails->case_no,
		'col8order_cron_no' => $col8OrderDetails->col8order_cron_no,
		'order_type' => $ordertype,
		'nature_trans_code' => $col8OrderDetails->nature_trans_code,
		'mut_land_area_b' => $col8OrderDetails->mut_land_area_b,
		'mut_land_area_k' => $col8OrderDetails->mut_land_area_k,
		'mut_land_area_lc' => $col8OrderDetails->mut_land_area_lc,
		'inplace' => $inplace_data,
		'occup' => $occup_data,
		'rajah' => $rajah_adalat,
		'deed_value' => $deed_value,
		'deed_reg_no' => $deed_reg_no,
		'deed_date' => $deed_date,
		'lm_name' => $lm_name,
		'username' => $username,
		'riotee'=>$applicant,
		'inplaceofriotee'=>$inplaceofName,
		'alongwithriotee'=>$alongwith
	);
}
}
$data1[$dag_no]['backlog_court_order'][] = $data_court;
$data1[$dag_no]['backlogs'][] = $data;
$data1[$dag_no]['backlogs31'][] = $dataBacklog31;
	// this is the End to col8 order details
$d = $this->getCol31($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no);
$data1[$dag_no]['col31'][] = $d;
$lmnotes = $this->getLmNotes($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no);
$data1[$dag_no]['lmnotes'] = $lmnotes;
//////////Remarks for LandClass//////////////
$data1[$dag_no]['classRemark'] = $this->landClass($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no);
///////////////////////
$innerquery = "select p_flag,pdar_id,patta_no,dag_por_b,dag_por_k,dag_por_lc from   chitha_dag_pattadar_doul where dist_code='$district_code' and subdiv_code='$subdivision_code' "
. "and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no='$dag_no' and "
. "TRIM(patta_no)='$patta_no' and  patta_type_code='$patta_code' order by pdar_id";
$innerdata = $this->db->query($innerquery)->result();
$data1[$dag_no]['pattadars'] = array();
foreach ($innerdata as $data) {
	$pdar_id = $data->pdar_id;
	$patta_no = trim($data->patta_no);
	$data1[$dag_no]['tenant'] = array();
	$data1[$dag_no]['subtenant'] = array();
	$innerquery2 = "select pdar_name,pdar_father,new_pdar_name,pdar_guard_reln,pdar_add1,Pdar_add2,Pdar_add3 from   chitha_pattadar_doul where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
	. " and TRIM(patta_no)='$patta_no' and  patta_type_code='$patta_code' and pdar_id=$data->pdar_id order by pdar_id";
	$innerdata2 = $this->db->query($innerquery2)->result();
	foreach ($innerdata2 as $pdardata) {
		$pdar_guardRelation = $pdardata->pdar_guard_reln;
		$innerquery3 = "select guard_rel_desc_as from   master_guard_rel where guard_rel_desc = '$pdar_guardRelation'";
		$innerdata3 = $this->db->query($innerquery3)->result();
		foreach ($innerdata3 as $guard_rel_desc) {
			$relation = $guard_rel_desc->guard_reln_desc_as;
		}
		$data1[$dag_no]['pattadars'][] = array(
			'p_flag' => $data->p_flag,
			'dag_por_b' => $data->dag_por_b,
			'dag_por_k' => $data->dag_por_k,
			'dag_por_lc' => $data->dag_por_lc,
			'pdar_name' => $pdardata->pdar_name,
			'guard_reln_desc_as' => $relation,
			'new_pdar_name' => $pdardata->new_pdar_name,
			'pdar_father' => $pdardata->pdar_father,
			'pdar_relation' => $pdardata->pdar_guard_reln,
			'pdar_address1' => $pdardata->pdar_add1,
			'pdar_address2' => $pdardata->pdar_add2,
			'pdar_address3' => $pdardata->pdar_add3,
			'pdar_guard_reln' => $pdardata->pdar_guard_reln,
			'pdar_id' => $pdar_id
		);
	}
	$innerquery15 = " select tenant_name,tenants_father,tenants_add1,tenants_add2,tenants_add3,type_of_tenant,khatian_no,revenue_tenant,crop_rate,tenant_id,status,p_flag from   "
	. "chitha_tenant where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and  "
	. "lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no='$dag_no' and year_no <= '$year_no' order by tenant_id";
	$innerdata15 = $this->db->query($innerquery15)->result();
	foreach ($innerdata15 as $tenant) {
		if ($tenant->type_of_tenant == null) {
			$tenant_typ = "00";
		} else {
			$tenant_typ = $tenant->type_of_tenant;
		}
		$tenant_name = $tenant->tenant_name;
		$tenants_father = $tenant->tenants_father;
		$tenants_add1 = $tenant->tenants_add1;
		$tenants_add2 = $tenant->tenants_add2;
		$tenants_add3 = $tenant->tenants_add3;
		$type_of_tenant = $tenant_typ;
		$khatian_no = $tenant->khatian_no;
		$status = $tenant->status;
		$revenue_tenant = $tenant->revenue_tenant;
		$crop_rate = $tenant->crop_rate;
		$tenant_id = $tenant->tenant_id;
		if ($tenant->type_of_tenant == null) {
			$tenant_typ = "00";
		} else {
			$tenant_typ = $tenant->type_of_tenant;
		}
		$tenant_name = $tenant->tenant_name;
		$tenants_father = $tenant->tenants_father;
		$tenants_add1 = $tenant->tenants_add1;
		$tenants_add2 = $tenant->tenants_add2;
		$tenants_add3 = $tenant->tenants_add3;
		$type_of_tenant = $tenant_typ;
		$khatian_no = $tenant->khatian_no;
		$status = $tenant->status;
		$revenue_tenant = $tenant->revenue_tenant;
		$crop_rate = $tenant->crop_rate;
		$tenant_id = $tenant->tenant_id;
		if ($tenant->type_of_tenant == "00") {
			$tenant_typ = "";
		} else {
			$tenant_typ = $tenant->type_of_tenant;
		}
		$tenant_name = $tenant->tenant_name;
		$tenants_father = $tenant->tenants_father;
		$tenants_add1 = $tenant->tenants_add1;
		$tenants_add2 = $tenant->tenants_add2;
		$tenants_add3 = $tenant->tenants_add3;
		$type_of_tenant = $tenant_typ;
		$khatian_no = $tenant->khatian_no;
		$status = $tenant->status;
		$revenue_tenant = $tenant->revenue_tenant;
		$crop_rate = $tenant->crop_rate;
		$tenant_id = $tenant->tenant_id;
		$innerquery16 = "Select tenant_type from   Tenant_type where type_code ='$type_of_tenant'";
		$innerdata16 = $this->db->query($innerquery16)->result();
		foreach ($innerdata16 as $tenanttype) {
			$tenant_type = $tenanttype->tenant_type;
			$data1[$dag_no]['tenant'][] = array(
				'tenant_name' => $tenant->tenant_name,
				'tenants_father' => $tenant->tenants_father,
				'tenants_add1' => $tenant->tenants_add1,
				'tenants_add2' => $tenant->tenants_add2,
				'tenants_add3' => $tenant->tenants_add3,
				'type_of_tenant' => $tenant->type_of_tenant,
				'khatian_no' => $tenant->khatian_no,
				'status' => $tenant->status,
				'revenue_tenant' => $tenant->revenue_tenant,
				'crop_rate' => $tenant->crop_rate,
				'tenant_type' => $tenanttype->tenant_type,
				'p_flag' => $tenant->p_flag,
			);
		}
		$innerquery17 = "Select subtenant_name,subtenants_father,subtenants_add1,subtenants_add2,subtenants_add3 from   Chitha_Subtenant where  dist_code='$district_code' "
		. "and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
		. "and Dag_no='$dag_no' and year_no <= '$year_no' and tenant_id = '$tenant_id'";
		$innerdata17 = $this->db->query($innerquery17)->result();
		$subtenant_name = "";
		$subtenants_father = "";
		$subtenants_add1 = "";
		$subtenants_add2 = "";
		$subtenants_add = "";
		foreach ($innerdata17 as $subtenant) {
			$subtenant_name = $subtenant->subtenant_name;
			$subtenants_father = $subtenant->subtenants_father;
			$subtenants_add1 = $subtenant->subtenants_add1;
			$subtenants_add2 = $subtenant->subtenants_add2;
			$subtenants_add3 = $subtenant->subtenants_add3;
			$data1[$dag_no]['subtenant'][] = array(
				'subtenant_name' => $subtenant->subtenant_name,
				'subtenants_father' => $subtenant->subtenants_father,
				'subtenants_add1' => $subtenant->subtenants_add1,
				'subtenants_add2' => $subtenant->subtenants_add2,
				'subtenants_add3' => $subtenant->subtenants_add3,
			);
		}
	}
}
$data1[$dag_no]['archeo'] = array();
$data1[$dag_no]['noncrp'] = array();
$data1[$dag_no]['mcrp'] = array();
$data1[$dag_no]['fruit'] = array();
$data1[$dag_no]['mcrp_akeadhig'] = array();
$data1[$dag_no]['years'] = array();
$innerquerynoncrp = "select type_of_used_noncrop,noncrop_land_area_b,noncrop_land_area_k,noncrop_land_area_lc from   chitha_noncrop where dist_code='$district_code' "
. "and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
. "and dag_no ='$dag_no' and yn='$year_no'";
$innerdatanoncrp = $this->db->query($innerquerynoncrp)->result();
foreach ($innerdatanoncrp as $noncrop) {
	$type_of_used_noncrp = $noncrop->type_of_used_noncrop;
	$noncrp_b = $noncrop->noncrop_land_area_b;
	$noncrop_k = $noncrop->noncrop_land_area_k;
	$noncrop_lc = $noncrop->noncrop_land_area_lc;
	$innerquery19 = "select noncrop_type from   used_noncrop_type where used_noncrop_type_code = '$type_of_used_noncrp'";
	$innerdata19 = $this->db->query($innerquery19)->result();
	foreach ($innerdata19 as $noncrptyp) {
		$noncrop_type = $noncrptyp->noncrop_type;
		$data1[$dag_no]['noncrp'][] = array(
			'year' => $year,
			'type_of_used_noncrp' => $noncrop_type,
			'noncrp_b' => $noncrp_b,
			'noncrop_k' => $noncrop_k,
			'noncrop_lc' => $noncrop_lc
		);
	}
}
$innerquerycrp = " select source_of_water,crop_code,crop_land_area_b,crop_land_area_k,crop_land_area_lc,crop_categ_code from   chitha_mcrop where dist_code='$district_code' "
. "and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
. "and dag_no ='$dag_no' and yearno='$year_no' and crop_code<>'057' ";
$innerdatacrp = $this->db->query($innerquerycrp)->result();
foreach ($innerdatacrp as $mcropdetails) {
	$source_of_water = $mcropdetails->source_of_water;
	$crop_code = $mcropdetails->crop_code;
	$crop_land_area_b = $mcropdetails->crop_land_area_b;
	$crop_land_area_k = $mcropdetails->crop_land_area_k;
	$crop_land_area_lc = $mcropdetails->crop_land_area_lc;
	$crop_category = $mcropdetails->crop_categ_code;
	$innerquerywatersrc = "select source from   source_water where water_source_code = '$source_of_water'";
	$innerdatawatersrc = $this->db->query($innerquerywatersrc)->result();
	foreach ($innerdatawatersrc as $watersrc) {
		$sourceOFwater = $watersrc->source;
		$innerqueryCropCateg = "select crop_categ_desc from   crop_category_code where crop_categ_code = '$crop_category'";
		$innerdataCropcateg = $this->db->query($innerqueryCropCateg)->result();
		foreach ($innerdataCropcateg as $CropDesc) {
			$CropDesc_inChitha = $CropDesc->crop_categ_desc;
			$innerquerymcrop = "select crop_name from   crop_code where crop_code = '$crop_code'";
			$innerdatamcrop = $this->db->query($innerquerymcrop)->result();
			foreach ($innerdatamcrop as $cropinfo) {
				$cropname = $cropinfo->crop_name;
				$data1[$dag_no]['mcrp'][] = array(
					'sourceofwater' => $sourceOFwater,
					'cropname' => $cropname,
					'mcrp_b' => $crop_land_area_b,
					'mcrop_k' => $crop_land_area_k,
					'mcrop_lc' => $crop_land_area_lc,
					'crop_category' => $CropDesc_inChitha
				);
			}
		}
	}
}
$innerquerycrp_ekadhig = " select crop_land_area_b,crop_land_area_k,crop_land_area_lc from   chitha_mcrop where dist_code='$district_code' and subdiv_code='$subdivision_code'"
. " and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' and yearno='$year_no' "
. " ";
$innerdatacrp_ekadhig = $this->db->query($innerquerycrp_ekadhig)->result();
foreach ($innerdatacrp_ekadhig as $ekadhig)
	$data1[$dag_no]['mcrp_akeadhig'][] = array(
		'bigha' => $ekadhig->crop_land_area_b,
		'katha' => $ekadhig->crop_land_area_k,
		'lesa' => $ekadhig->crop_land_area_lc
	);
$data1[$dag_no]['years'][] = array(
	'year' => $year
);
$innerquery23 = "select fruit_plants_name,no_of_plants,fruit_land_area_b,fruit_land_area_k,fruit_land_area_lc from   chitha_fruit where dist_code='$district_code' "
. "and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
. "and dag_no ='$dag_no' and year_no = '$year_no' ORDER BY Fruit_plant_ID";
$innerdata23 = $this->db->query($innerquery23)->result();
foreach ($innerdata23 as $chithafruitinf) {
	$fruit_plants_name = $chithafruitinf->fruit_plants_name;
	$no_of_fruit_plants = $chithafruitinf->no_of_plants;
	$fruit_bigha = $chithafruitinf->fruit_land_area_b;
	$fruit_katha = $chithafruitinf->fruit_land_area_k;
	$fruit_lesa = $chithafruitinf->fruit_land_area_lc;
	$innerquery24 = "select fruit_name from   fruit_tree_code where fruit_code='$fruit_plants_name'";
	$innerdata24 = $this->db->query($innerquery24)->result();
	foreach ($innerdata24 as $fruitinfo) {
		$fruit_name = $fruitinfo->fruit_name;
		$data1[$dag_no]['fruit'][] = array(
			'fruitname' => $fruit_name,
			'no_of_plants' => $no_of_fruit_plants,
			'fbigha' => $fruit_bigha,
			'fkatha' => $fruit_katha,
			'flesa' => $fruit_lesa
		);
	}
}
$chithaarcheo = "select archeo_hist_code,hist_land_area_b,hist_land_area_k,hist_land_area_lc,archeo_hist_site_desc from   chitha_acho_hist where dist_code='$district_code' "
. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code'"
. " and dag_no ='$dag_no' and year_no = '$year_no'";
$innerdataarcheo = $this->db->query($chithaarcheo)->result();
foreach ($innerdataarcheo as $archeoinfo) {
	$archeo_code = $archeoinfo->archeo_hist_code;
	$archeo_area_b = $archeoinfo->hist_land_area_b;
	$archeo_area_k = $archeoinfo->hist_land_area_k;
	$archeo_area_lc = $archeoinfo->hist_land_area_lc;
	$archeo_area_description = $archeoinfo->archeo_hist_site_desc;
	$archeo_siteCd = "select archeo_hist_desc from   archeo_hist_site_code where archeo_hist_code='$archeo_code' ";
	$innerdataarcheo_cd = $this->db->query($archeo_siteCd)->result();
	foreach ($innerdataarcheo_cd as $archeo_cd) {
		$hist_description = $archeo_cd->archeo_hist_desc;
		$data1[$dag_no]['archeo'][] = array(
			'hist_description_nme' => $hist_description,
			'archeo_hist_code' => $archeo_code,
			'archeo_b' => $archeo_area_b,
			'archeo_k' => $archeo_area_k,
			'archeo_lc' => $archeo_area_lc,
			'archeo_decribed' => $archeo_area_description
		);
	}
}
$innerquery58 = "SELECT encro_evicted_yn,encro_name,encro_since,encro_land_b,encro_land_k,encro_land_lc,encro_land_used_for,encro_evic_date FROM  chitha_rmk_encro "
. "where  dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' "
	. "and vill_townprt_code='$village_code' and dag_no ='$dag_no' and year_no = '$year_no'"; //and rmk_type_hist_no='$rmk_type_hist_no' ";
	$innerdata58 = $this->db->query($innerquery58)->result();
	foreach ($innerdata58 as $encro) {
		$encro_land_used_for = $encro->encro_land_used_for;
		$innerquery_encroland = "SELECT used_for from   encro_land_used_for where code='$encro_land_used_for' ";
		$innerdata_encroland = $this->db->query($innerquery_encroland)->result();
		foreach ($innerdata_encroland as $encro_land) {
			$data1[$dag_no]['encro'][] = array(
				'encro_evicted_yn' => $encro->encro_evicted_yn,
				'encro_name' => $encro->encro_name,
				'encro_since' => $encro->encro_since,
				'encro_land_b' => $encro->encro_land_b,
				'encro_land_k' => $encro->encro_land_k,
				'encro_land_lc' => $encro->encro_land_lc,
				'encro_land_used_for' => $encro->encro_land_used_for,
				'encro_evic_date' => $encro->encro_evic_date,
				'land_used_by_encro' => $encro_land->used_for
			);
		}
	}
	//sro note
	$sroCheck=$this->govtDagSro($district_code,$subdivision_code,$circlecode,$mouzacode,$lot_code,$village_code,$dag_no);
	if($sroCheck===false)
	{
	$innerquery_sro = "SELECT  dag_area_b, dag_area_k, dag_area_lc,reg_to_name,reg_from_name,name_of_sro,deed_no,date_of_deed, status,deed_type FROM  sro_note where  "
	. "dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and "
	. "vill_townprt_code='$village_code' and dag_no ='$dag_no' and year_no = '$year_no'"; //and rmk_type_hist_no='$rmk_type_hist_no' ";
	$innerdata_sro_note = $this->db->query($innerquery_sro)->result();
	foreach ($innerdata_sro_note as $sro) {
		$data1[$dag_no]['sro'][] = array(
			'dag_no' => $dag_no,
			'dag_area_b' => $sro->dag_area_b,
			'dag_area_k' => $sro->dag_area_k,
			'dag_area_lc' => $sro->dag_area_lc,
			'reg_to_name' => $sro->reg_to_name,
			'reg_from_name' => $sro->reg_from_name,
			'name_of_sro' => $sro->name_of_sro,
			'deed_no' => $sro->deed_no,
			'date_of_deed' => $sro->date_of_deed,
			'status' => $sro->status,
			'deed_type' => $sro->deed_type
		);
	}
	}
	//lm note
	$innerquery_LMNOTE = "select  lm_note,lm_note_date,lm_code FROM  chitha_rmk_lmnote where dist_code='$district_code' and subdiv_code='$subdivision_code' "
	. "and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' "
	. "and year_no = '$year_no'";
	$innerdata_LMNOTE = $this->db->query($innerquery_LMNOTE)->result();
	foreach ($innerdata_LMNOTE as $lmnote) {
		$lm_note = $lmnote->lm_note;
		$lm_note_date = $lmnote->lm_note_date;
		$lm_code = $lmnote->lm_code;
		$q = "Select lm_name from   lm_code where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";
		$lm_code = $this->db->query($q)->row()->lm_name;
		$lm_name = $this->db->query($q)->row()->lm_name;
		$data1[$dag_no]['lmnote'][] = array(
			'lm_note' => $lmnote->lm_note,
			'lm_code' => $lm_code
		);
	}
}
return $data1;
}
public function getchithaDetails123Test($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper, $patta_code, $year_no) {
	ini_set('max_execution_time', 0);
	$q = "
	Select cb.old_dag_no, cb.dag_no,cb.dag_no_int,cb.patta_no,cb.dag_area_b,cb.dag_area_k,cb.dag_area_lc,cb.dag_revenue,
	cb.dag_local_tax,lcc.land_type from   chitha_basic_doul AS cb JOIN landclass_code
	AS lcc ON cb.land_class_code = lcc.class_code where Dist_code='$district_code' and Subdiv_code='$subdivision_code'
	and Cir_code='$circlecode'
	and Mouza_Pargona_code='$mouzacode' and Lot_No='$lot_code' and Vill_townprt_code='$village_code'
	and CAST(coalesce(cb.dag_no_int, '0') AS numeric)>=$dag_no_lower and
	CAST(coalesce(cb.dag_no_int, '0') AS numeric)<=$dag_no_upper and
	patta_type_code='$patta_code' order by CAST(coalesce(cb.dag_no_int, '0') AS numeric)";
	$district = $this->db->query("
		Select cb.old_dag_no, cb.dag_no,cb.patta_no,cb.dag_area_b,cb.dag_area_k,cb.dag_area_lc,cb.dag_revenue,
		cb.dag_local_tax,lcc.land_type,lcc.class_code_cat  from   chitha_basic_doul AS cb JOIN landclass_code
		AS lcc ON cb.land_class_code = lcc.class_code where Dist_code='$district_code' and Subdiv_code='$subdivision_code'
		and Cir_code='$circlecode'
		and Mouza_Pargona_code='$mouzacode' and Lot_No='$lot_code' and Vill_townprt_code='$village_code'
		and CAST(coalesce(cb.dag_no_int, '0') AS numeric)>=$dag_no_lower and
		CAST(coalesce(cb.dag_no_int, '0') AS numeric)<=$dag_no_upper and
		patta_type_code='$patta_code'  order by CAST(coalesce(cb.dag_no_int, '0') AS numeric)");
	$data1 = array();
	$outerdata = $district->result();
	$innerdata = array();
	// $chithadetailsArr = array();
	$innerdata2 = array();
	$innerdata3 = array();
	$innerdata4 = array();
	$innerdata5 = array();
	$innerdata6 = array();
	$innerdata7 = array();
	$innerdata8 = array();
	$innerdata9 = array();
	$innerdata10 = array();
	$innerdata11 = array();
	$innerdata12 = array();
	$innerdata13 = array();
	$innerdata14 = array();
	$innerdata15 = array();
	$innerdata16 = array();
	$innerdata17 = array();
	$innerdata18 = array();
	$innerdata19 = array();
	$innerdata20 = array();
	$innerdata21 = array();
	$innerdata22 = array();
	$innerdata23 = array();
	$innerdata24 = array();
	$innerdata25 = array();
	$innerdata26 = array();
	$relation = array();
	//this is the start of the loop for each dag..
	foreach ($outerdata as $chithadetails) {
		$patta_no = trim($chithadetails->patta_no);
		$dag_no = $chithadetails->dag_no;
		$backlog_court_order = "select * from   backlog_orders where dist_code='$district_code' and subdiv_code='$subdivision_code' and"
		. " cir_code='$circlecode' and lot_no='$lot_code' and mouza_pargona_code='$mouzacode' and "
		. " vill_townprt_code='$village_code' and dag_no='$dag_no' "
		. " and patta_type_code='$patta_code' and category=0";
		$data_court = $this->db->query($backlog_court_order)->result();
		$backlogquery = "select * from   backlog_orders where dist_code='$district_code' and subdiv_code='$subdivision_code' and"
		. " cir_code='$circlecode' and lot_no='$lot_code' and mouza_pargona_code='$mouzacode' and "
		. " vill_townprt_code='$village_code' and dag_no='$dag_no' "
		. " and patta_type_code='$patta_code' and category=1";
		$data = $this->db->query($backlogquery)->result();
		$backlogquery = "select * from   backlog_orders where dist_code='$district_code' and subdiv_code='$subdivision_code' and"
		. " cir_code='$circlecode' and lot_no='$lot_code' and mouza_pargona_code='$mouzacode' and "
		. " vill_townprt_code='$village_code' and dag_no='$dag_no' "
		. " and patta_type_code='$patta_code' and category=2";
		$dag_no_int = $dag_no . "00";
		$dataBacklog31 = $this->db->query($backlogquery)->result();
		$patta_type_name = $this->db->query("Select patta_type as patta_type_name from   patta_code where type_code ='$patta_code'")->row()->patta_type_name;
		$data1[$dag_no] = array(
			'old_dag_no' => $chithadetails->old_dag_no,
			'dag_no' => $chithadetails->dag_no,
			'patta_no' => trim($chithadetails->patta_no),
			'patta_type_name' => $patta_type_name,
			'dag_area_b' => $chithadetails->dag_area_b,
			'dag_area_k' => $chithadetails->dag_area_k,
			'dag_area_lc' => $chithadetails->dag_area_lc,
			'dag_revenue' => $chithadetails->dag_revenue,
			'dag_localtax' => $chithadetails->dag_local_tax,
			'land_type' => $chithadetails->land_type,
			'class_code_cat' => $chithadetails->class_code_cat,
		);
		$innerquery4 = "select col8order_cron_no,order_type_code,nature_trans_code,mut_land_area_b,"
		. " mut_land_area_k,mut_land_area_lc,user_code,rajah_adalat,lm_code,case_no,co_ord_date,deed_reg_no,deed_value,deed_date from   Chitha_col8_order where dist_code='$district_code' "
		. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
		. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and year_no = '$year_no' and (dag_no='$dag_no' ) ";
		$innerdata4 = $this->db->query($innerquery4)->result();
	// this is the start to col8 order details
		foreach ($innerdata4 as $col8OrderDetails) {
			$col8order_cron_no = $col8OrderDetails->col8order_cron_no;
			$order_type_code = $col8OrderDetails->order_type_code;
			$nature_trans_code = $col8OrderDetails->nature_trans_code;
			$mut_land_area_b = $col8OrderDetails->mut_land_area_b;
			$mut_land_area_k = $col8OrderDetails->mut_land_area_k;
			$mut_land_area_lc = $col8OrderDetails->mut_land_area_lc;
			$user_code = $col8OrderDetails->user_code;
			$rajah_adalat = $col8OrderDetails->rajah_adalat;
			$lm_code = $col8OrderDetails->lm_code;
			$case_no = $col8OrderDetails->case_no;
			$co_ord_date = $col8OrderDetails->co_ord_date;
			$deed_value = $col8OrderDetails->deed_value;
			$deed_reg_no = $col8OrderDetails->deed_reg_no;
			$deed_date = $col8OrderDetails->deed_date;
			$inplace_of_name = "";
			$inplaceof_alongwith = "";
			$occupant_name = "";
			$occupant_fmh_name = "";
			$occupant_fmh_flag = "";
			$new_patta_no = "";
			$new_dag_no = "";
			$hus_wife = "";
			$nature_trans_desc = "";
			$lm_name = "";
			$innerquery5 = "select order_type from   master_field_mut_type
			where  order_type_code = '$order_type_code' ";
	
			$innerdata5 = $this->db->query($innerquery5)->row();
			$ordertype = $innerdata5->order_type;
			$innerquery6 = "select inplace_of_name,inplaceof_alongwith from   chitha_col8_inplace
			where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' "
			. "and  mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and "
			. " vill_townprt_code='$village_code' and Dag_no='$dag_no' and Col8Order_cron_no='$col8order_cron_no' "
			. " ORDER BY inplace_of_id";
			$innerdata6 = $this->db->query($innerquery6)->result();
			$inplace_data = array();
			$innerquery7 = "select trans_desc_as from   nature_trans_code where trans_code = '$nature_trans_code'";
	
	//$nature_trans_desc = $this->db->query($innerquery7)->row()->trans_desc_as;
			foreach ($innerdata6 as $inplace) {
				$inplace_data[] = array(
					'inplace_of_name' => $inplace->inplace_of_name,
					'inplaceof_alongwith' => $inplace->inplaceof_alongwith,
				);
			}
			$occup_data = array();
			$innerquery8 = "select occupant_name,occupant_fmh_name,occupant_fmh_flag,new_patta_no,new_dag_no,hus_wife from   "
			. " chitha_col8_occup where dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
			. " and (dag_no='$dag_no' or new_dag_no='$dag_no')  and Col8Order_cron_no='$col8order_cron_no' and user_code='$co_code'   ORDER BY occupant_id";
			$innerdata8 = $this->db->query($innerquery8)->result();
			foreach ($innerdata8 as $occupant) {
				$occupant_name = $occupant->occupant_name;
				$occupant_fmh_name = $occupant->occupant_fmh_name;
				$occupant_fmh_flag = $occupant->occupant_fmh_flag;
				$new_patta_no = trim($occupant->new_patta_no);
				$new_dag_no = $occupant->new_dag_no;
				$hus_wife = $occupant->hus_wife;
				$innerquery9 = "select guard_rel_desc_as from   master_guard_rel where guard_rel = '$occupant_fmh_flag'";
				$innerdata9 = $this->db->query($innerquery9)->result();
				$guard_rel_desc_as = "";
				foreach ($innerdata9 as $guard_rel) {
					$guard_rel_desc_as = $guard_rel->guard_rel_desc_as;
				}
				$occup_data[] = array(
					'occupant_name' => $occupant->occupant_name,
					'occupant_fmh_name' => $occupant->occupant_fmh_name,
					'occupant_fmh_flag' => $occupant->occupant_fmh_flag,
					'new_patta_no' => trim($occupant->new_patta_no),
					'new_dag_no' => $occupant->new_dag_no,
					'hus_wife' => $occupant->hus_wife,
					'guard_rel_desc_as' => $guard_rel_desc_as
				);
			}
			$innerquery10 = "select lm_name from   lm_code  where dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code = '$lm_code' ";
	
			$innerdata10 = $this->db->query($innerquery10)->result();
			foreach ($innerdata10 as $lm) {
				$lm_name = $lm->lm_name;
			}
			if ($user_code != 'admn') {
				$innerquery11 = "select username,status from   users where dist_code='$district_code' "
				. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code='$user_code'";
				$innerdata11 = $this->db->query($innerquery11)->result();
				foreach ($innerdata11 as $users) {
					$username = $users->username;
					$status = $users->status;
				}
			} else {
				$username = '';
				$status = 'O';
			}
			$innerquery12 = "select * from   field_mut_objection where prev_fm_ca_no='$case_no' and obj_flag is not null and chitha_correct_yn='1' ";
			$innerdata12 = $this->db->query($innerquery12)->result();
			foreach ($innerdata12 as $objection) {
				$q = "select col8order_cron_no,dag_no from   chitha_col8_order where case_no='$objection->prev_fm_ca_no' ";
				$col8_cronNo = $this->db->query($q)->row();
				$q = "select occupant_name from   chitha_col8_occup where dist_code='$district_code' "
				. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
				. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and
				col8order_cron_no='$col8_cronNo->col8order_cron_no' and dag_no='$col8_cronNo->dag_no'  ";
				$result = $this->db->query($q)->result();
				$fname = " ";
				foreach ($result as $name) {
					$fname = $fname . $name->occupant_name . ",";
				}
				$data1[$dag_no]['objection'][] = array(
					'mut_type' => $objection->mut_type,
					'regist_date' => $objection->regist_date,
					'objection_case_no' => $objection->objection_case_no,
					'prev_fm_ca_no' => $objection->prev_fm_ca_no,
					'submission_date' => $objection->entry_date,
					'obj_name' => $objection->obj_name,
					'co_id' => $objection->co_id,
					'occupant' => $fname
				);
			}
			$innerquery13 = "select * from   field_mut_petitioner where case_no='$case_no' ";
			$innerdata13 = $this->db->query($innerquery13)->result();
			if ($order_type_code == '01') {
				$innerquery14 = " select deed_reg_no,deed_value,deed_date from   chitha_col8_order
				where Order_type_code='$order_type_code' and dag_no='$dag_no' and case_no='$case_no'";
	
				$innerdata14 = $this->db->query($innerquery14)->result();
				foreach ($innerdata14 as $deedinf) {
					$deed_reg_no = $deedinf->deed_reg_no;
					$deed_value = $deedinf->deed_value;
					$deed_date = $deedinf->deed_date;
				}
			}
	
			$data1[$dag_no]['col8'][] = array(
				'co_ord_date' => $col8OrderDetails->co_ord_date,
				'order_type_code' => $col8OrderDetails->order_type_code,
				'case_no' => $col8OrderDetails->case_no,
				'col8order_cron_no' => $col8OrderDetails->col8order_cron_no,
				'order_type' => $ordertype,
				'nature_trans_code' => $col8OrderDetails->nature_trans_code,
				'mut_land_area_b' => $col8OrderDetails->mut_land_area_b,
				'mut_land_area_k' => $col8OrderDetails->mut_land_area_k,
				'mut_land_area_lc' => $col8OrderDetails->mut_land_area_lc,
				'inplace' => $inplace_data,
				'occup' => $occup_data,
				'rajah' => $rajah_adalat,
				'deed_value' => $deed_value,
				'deed_reg_no' => $deed_reg_no,
				'deed_date' => $deed_date,
				'lm_name' => $lm_name,
				'username' => $username,
				'riotee'=>$applicant,
				'inplaceofriotee'=>$inplaceofName,
				'alongwithriotee'=>$alongwith
			);
		}
		$data1[$dag_no]['backlog_court_order'][] = $data_court;
		$data1[$dag_no]['backlogs'][] = $data;
		$data1[$dag_no]['backlogs31'][] = $dataBacklog31;
	//$data1[$dag_no]['appeal147'][] = $appeal147;
	// this is the End to col8 order details
		$d = $this->getCol31($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no);
		$data1[$dag_no]['col31'][] = $d;
		$lmnotes = $this->getLmNotes($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no);
		$data1[$dag_no]['lmnotes'] = $lmnotes;
		//////////Remarks for LandClass//////////////
		$data1[$dag_no]['classRemark'] = $this->landClass($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no);
		///////////////////////
		$innerquery = "select p_flag,pdar_id,patta_no,dag_por_b,dag_por_k,dag_por_lc from   chitha_dag_pattadar where dist_code='$district_code' "
		. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
		. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
		. " and dag_no='$dag_no' and TRIM(patta_no)='$patta_no' and  patta_type_code='$patta_code' order by pdar_id";
		$innerdata = $this->db->query($innerquery)->result();
		$data1[$dag_no]['pattadars'] = array();
		foreach ($innerdata as $data) {
	// $p_flag = $data->p_flag;
			$pdar_id = $data->pdar_id;
			$patta_no = trim($data->patta_no);
	//$data1[$dag_no]['col8'] = array();
			$data1[$dag_no]['tenant'] = array();
			$data1[$dag_no]['subtenant'] = array();
			$innerquery2 = "select pdar_name,pdar_father,new_pdar_name,pdar_guard_reln,pdar_add1,Pdar_add2,Pdar_add3 from   chitha_pattadar where dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
			. " and TRIM(patta_no)='$patta_no' and  patta_type_code='$patta_code' and pdar_id=$data->pdar_id order by pdar_id";
	
			$innerdata2 = $this->db->query($innerquery2)->result();
	/* if (!empty($innerdata2)) {
	
	} else {
	
} */
	/* if (!empty($innerdata2)) {
	
	} else {
	
} */
	/* if (!empty($innerdata2)) {
	
	} else {
	
	} */
	foreach ($innerdata2 as $pdardata) {
		$pdar_guardRelation = $pdardata->pdar_guard_reln;
		$innerquery3 = "select guard_rel_desc_as from   master_guard_rel where guard_rel_desc = '$pdar_guardRelation'";
		$innerdata3 = $this->db->query($innerquery3)->result();
		foreach ($innerdata3 as $guard_rel_desc) {
			$relation = $guard_rel_desc->guard_reln_desc_as;
		}
		$data1[$dag_no]['pattadars'][] = array(
			'p_flag' => $data->p_flag,
			'dag_por_b' => $data->dag_por_b,
			'dag_por_k' => $data->dag_por_k,
			'dag_por_lc' => $data->dag_por_lc,
			'pdar_name' => $pdardata->pdar_name,
			'guard_reln_desc_as' => $relation,
			'new_pdar_name' => $pdardata->new_pdar_name,
			'pdar_father' => $pdardata->pdar_father,
			'pdar_relation' => $pdardata->pdar_guard_reln,
			'pdar_address1' => $pdardata->pdar_add1,
			'pdar_address2' => $pdardata->pdar_add2,
			'pdar_address3' => $pdardata->pdar_add3,
			'pdar_guard_reln' => $pdardata->pdar_guard_reln,
			'pdar_id' => $pdar_id
		);
	}
	$sql = "Select * from   khatian where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no='$dag_no' ";
	$khatia = $this->db->query($sql)->row();
	if (sizeof($khatia) > 0) {
		$innerquery15 = " select tenant_name,tenants_father,tenants_add1,tenants_add2,type_of_tenant,khatian_no,tenant_id,status,p_flag from   chitha_tenant where dist_code='$district_code' "
		. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
		. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and khatian_no='$khatia->id' order by tenant_id";
		$innerdata15 = $this->db->query($innerquery15)->result();
		foreach ($innerdata15 as $tenant) {
			if ($tenant->type_of_tenant == null) {
				$tenant_typ = "00";
			} else {
				$tenant_typ = $tenant->type_of_tenant;
			}
			$tenant_name = $tenant->tenant_name;
			$tenants_father = $tenant->tenants_father;
			$tenants_add1 = $tenant->tenants_add1;
			$tenants_add2 = $tenant->tenants_add2;
			$type_of_tenant = $tenant_typ;
			$khatian_no = $tenant->khatian_no;
			$status = $tenant->status;
	//$revenue_tenant = $tenant->revenue_tenant;
	//$crop_rate = $tenant->crop_rate;
			$tenant_id = $tenant->tenant_id;
			if ($tenant->type_of_tenant == null) {
				$tenant_typ = "00";
			} else {
				$tenant_typ = $tenant->type_of_tenant;
			}
			$tenant_name = $tenant->tenant_name;
			$tenants_father = $tenant->tenants_father;
			$tenants_add1 = $tenant->tenants_add1;
			$tenants_add2 = $tenant->tenants_add2;
	//$tenants_add3 = $tenant->tenants_add3;
			$type_of_tenant = $tenant_typ;
			$khatian_no = $tenant->khatian_no;
			$status = $tenant->status;
	//$revenue_tenant = $tenant->revenue_tenant;
	//$crop_rate = $tenant->crop_rate;
			$tenant_id = $tenant->tenant_id;
			if ($tenant->type_of_tenant == "00") {
				$tenant_typ = "";
			} else {
				$tenant_typ = $tenant->type_of_tenant;
			}
			$tenant_name = $tenant->tenant_name;
			$tenants_father = $tenant->tenants_father;
			$tenants_add1 = $tenant->tenants_add1;
			$tenants_add2 = $tenant->tenants_add2;
	//$tenants_add3 = $tenant->tenants_add3;
			$type_of_tenant = $tenant_typ;
			$khatian_no = $tenant->khatian_no;
			$status = $tenant->status;
	// $revenue_tenant = $tenant->revenue_tenant;
	//$crop_rate = $tenant->crop_rate;
			$tenant_id = $tenant->tenant_id;
			$innerquery16 = "Select tenant_type from   Tenant_type where type_code ='$type_of_tenant'";
			$innerdata16 = $this->db->query($innerquery16)->result();
			foreach ($innerdata16 as $tenanttype) {
				$tenant_type = $tenanttype->tenant_type;
				$data1[$dag_no]['tenant'][] = array(
					'tenant_name' => $tenant->tenant_name,
					'tenants_father' => $tenant->tenants_father,
					'tenants_add1' => $tenant->tenants_add1,
					'tenants_add2' => $tenant->tenants_add2,
	//'tenants_add3' => $tenant->tenants_add3,
					'type_of_tenant' => $tenant->type_of_tenant,
					'khatian_no' => $tenant->khatian_no,
					'status' => $tenant->status,
	// 'revenue_tenant' => $tenant->revenue_tenant,
	//'crop_rate' => $tenant->crop_rate,
					'tenant_type' => $tenanttype->tenant_type,
					'p_flag' => $tenant->p_flag,
				);
			}
		}
		$innerquery17 = "Select subtenant_name,subtenants_father,subtenants_add1,subtenants_add2,subtenants_add3 from   Chitha_Subtenant where  dist_code='$district_code' "
		. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
		. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and Dag_no='$dag_no' and tenant_id = '$tenant_id'";
		$innerdata17 = $this->db->query($innerquery17)->result();
		$subtenant_name = "";
		$subtenants_father = "";
		$subtenants_add1 = "";
		$subtenants_add2 = "";
		$subtenants_add = "";
		foreach ($innerdata17 as $subtenant) {
			$subtenant_name = $subtenant->subtenant_name;
			$subtenants_father = $subtenant->subtenants_father;
			$subtenants_add1 = $subtenant->subtenants_add1;
			$subtenants_add2 = $subtenant->subtenants_add2;
			$subtenants_add3 = $subtenant->subtenants_add3;
			$data1[$dag_no]['subtenant'][] = array(
				'subtenant_name' => $subtenant->subtenant_name,
				'subtenants_father' => $subtenant->subtenants_father,
				'subtenants_add1' => $subtenant->subtenants_add1,
				'subtenants_add2' => $subtenant->subtenants_add2,
				'subtenants_add3' => $subtenant->subtenants_add3,
			);
		}
	}
}
	//modification by bondita
$sysyear = date("Y");
	
$data1[$dag_no]['archeo'] = array();
$data1[$dag_no]['noncrp'] = array();
$data1[$dag_no]['mcrp'] = array();
$data1[$dag_no]['fruit'] = array();
$data1[$dag_no]['mcrp_akeadhig'] = array();
$data1[$dag_no]['years'] = array();
$year1 = $sysyear;
$year = ($year1 - 2);
for ($j = 0; $j < 3; $j++) {
	$innerquerynoncrp = "select type_of_used_noncrop,noncrop_land_area_b,noncrop_land_area_k,noncrop_land_area_lc from   chitha_noncrop where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' and yn='$year'";
	$innerdatanoncrp = $this->db->query($innerquerynoncrp)->result();
	foreach ($innerdatanoncrp as $noncrop) {
		$type_of_used_noncrp = $noncrop->type_of_used_noncrop;
		$noncrp_b = $noncrop->noncrop_land_area_b;
		$noncrop_k = $noncrop->noncrop_land_area_k;
		$noncrop_lc = $noncrop->noncrop_land_area_lc;
		$innerquery19 = "select noncrop_type from   used_noncrop_type where used_noncrop_type_code = '$type_of_used_noncrp'";
		$innerdata19 = $this->db->query($innerquery19)->result();
		foreach ($innerdata19 as $noncrptyp) {
			$noncrop_type = $noncrptyp->noncrop_type;
			$data1[$dag_no]['noncrp'][] = array(
				'year' => $year,
				'type_of_used_noncrp' => $noncrop_type,
				'noncrp_b' => $noncrp_b,
				'noncrop_k' => $noncrop_k,
				'noncrop_lc' => $noncrop_lc
			);
		}
	}
	$innerquerycrp = " select source_of_water,crop_code,crop_land_area_b,crop_land_area_k,crop_land_area_lc,crop_categ_code from   chitha_mcrop where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' and yearno='$year' and crop_code<>'057' ";
	$innerdatacrp = $this->db->query($innerquerycrp)->result();
	foreach ($innerdatacrp as $mcropdetails) {
		$source_of_water = $mcropdetails->source_of_water;
		$crop_code = $mcropdetails->crop_code;
		$crop_land_area_b = $mcropdetails->crop_land_area_b;
		$crop_land_area_k = $mcropdetails->crop_land_area_k;
		$crop_land_area_lc = $mcropdetails->crop_land_area_lc;
		$crop_category = $mcropdetails->crop_categ_code;
		$innerquerywatersrc = "select source from   source_water where water_source_code = '$source_of_water'";
		$innerdatawatersrc = $this->db->query($innerquerywatersrc)->result();
		foreach ($innerdatawatersrc as $watersrc) {
			$sourceOFwater = $watersrc->source;
			$innerqueryCropCateg = "select crop_categ_desc from   crop_category_code where crop_categ_code = '$crop_category'";
			$innerdataCropcateg = $this->db->query($innerqueryCropCateg)->result();
			foreach ($innerdataCropcateg as $CropDesc) {
				$CropDesc_inChitha = $CropDesc->crop_categ_desc;
				$innerquerymcrop = "select crop_name from   crop_code where crop_code = '$crop_code'";
				$innerdatamcrop = $this->db->query($innerquerymcrop)->result();
				foreach ($innerdatamcrop as $cropinfo) {
					$cropname = $cropinfo->crop_name;
					$data1[$dag_no]['mcrp'][] = array(
						'sourceofwater' => $sourceOFwater,
						'cropname' => $cropname,
						'mcrp_b' => $crop_land_area_b,
						'mcrop_k' => $crop_land_area_k,
						'mcrop_lc' => $crop_land_area_lc,
						'crop_category' => $CropDesc_inChitha
					);
				}
			}
		}
	}
	$innerquerycrp_ekadhig = " select crop_land_area_b,crop_land_area_k,crop_land_area_lc from   chitha_mcrop where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' and yearno='$year'  ";
	
	$innerdatacrp_ekadhig = $this->db->query($innerquerycrp_ekadhig)->result();
	foreach ($innerdatacrp_ekadhig as $ekadhig)
		$data1[$dag_no]['mcrp_akeadhig'][] = array(
			'bigha' => $ekadhig->crop_land_area_b,
			'katha' => $ekadhig->crop_land_area_k,
			'lesa' => $ekadhig->crop_land_area_lc
		);
	$data1[$dag_no]['years'][] = array(
		'year' => $year
	);
	$year = ($year + 1);
}
$innerquery23 = "select fruit_plants_name,no_of_plants,fruit_land_area_b,fruit_land_area_k,fruit_land_area_lc from   chitha_fruit where dist_code='$district_code' "
. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' ORDER BY Fruit_plant_ID";
$innerdata23 = $this->db->query($innerquery23)->result();
foreach ($innerdata23 as $chithafruitinf) {
	$fruit_plants_name = $chithafruitinf->fruit_plants_name;
	$no_of_fruit_plants = $chithafruitinf->no_of_plants;
	$fruit_bigha = $chithafruitinf->fruit_land_area_b;
	$fruit_katha = $chithafruitinf->fruit_land_area_k;
	$fruit_lesa = $chithafruitinf->fruit_land_area_lc;
	$innerquery24 = "select fruit_name from   fruit_tree_code where fruit_code='$fruit_plants_name'";
	$innerdata24 = $this->db->query($innerquery24)->result();
	foreach ($innerdata24 as $fruitinfo) {
		$fruit_name = $fruitinfo->fruit_name;
		$data1[$dag_no]['fruit'][] = array(
			'fruitname' => $fruit_name,
			'no_of_plants' => $no_of_fruit_plants,
			'fbigha' => $fruit_bigha,
			'fkatha' => $fruit_katha,
			'flesa' => $fruit_lesa
		);
	}
}
$chithaarcheo = "select archeo_hist_code,hist_land_area_b,hist_land_area_k,hist_land_area_lc,archeo_hist_site_desc from   chitha_acho_hist where dist_code='$district_code' "
. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no'";
	
$innerdataarcheo = $this->db->query($chithaarcheo)->result();
	foreach ($innerdataarcheo as $archeoinfo) {
	$archeo_code = $archeoinfo->archeo_hist_code;
	$archeo_area_b = $archeoinfo->hist_land_area_b;
	$archeo_area_k = $archeoinfo->hist_land_area_k;
	$archeo_area_lc = $archeoinfo->hist_land_area_lc;
	$archeo_area_description = $archeoinfo->archeo_hist_site_desc;
	$archeo_siteCd = "select archeo_hist_desc from   archeo_hist_site_code where archeo_hist_code='$archeo_code' ";
	$innerdataarcheo_cd = $this->db->query($archeo_siteCd)->result();
	foreach ($innerdataarcheo_cd as $archeo_cd) {
		$hist_description = $archeo_cd->archeo_hist_desc;
		$data1[$dag_no]['archeo'][] = array(
			'hist_description_nme' => $hist_description,
			'archeo_hist_code' => $archeo_code,
			'archeo_b' => $archeo_area_b,
			'archeo_k' => $archeo_area_k,
			'archeo_lc' => $archeo_area_lc,
			'archeo_decribed' => $archeo_area_description
		);
	}
}
$innerquery58 = "SELECT encro_evicted_yn,encro_name,encro_since,encro_land_b,encro_land_k,encro_land_lc,encro_land_used_for,encro_evic_date FROM  chitha_rmk_encro where  dist_code='$district_code' "
. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' "; //and rmk_type_hist_no='$rmk_type_hist_no' ";
	$innerdata58 = $this->db->query($innerquery58)->result();
	foreach ($innerdata58 as $encro) {
		$encro_land_used_for = $encro->encro_land_used_for;
		$innerquery_encroland = "SELECT used_for from   encro_land_used_for where code='$encro_land_used_for' ";
		$innerdata_encroland = $this->db->query($innerquery_encroland)->result();
		foreach ($innerdata_encroland as $encro_land) {
			$data1[$dag_no]['encro'][] = array(
				'encro_evicted_yn' => $encro->encro_evicted_yn,
				'encro_name' => $encro->encro_name,
				'encro_since' => $encro->encro_since,
				'encro_land_b' => $encro->encro_land_b,
				'encro_land_k' => $encro->encro_land_k,
				'encro_land_lc' => $encro->encro_land_lc,
				'encro_land_used_for' => $encro->encro_land_used_for,
				'encro_evic_date' => $encro->encro_evic_date,
				'land_used_by_encro' => $encro_land->used_for
			);
		}
	}
	//sro note
	$sroCheck=$this->govtDagSro($district_code,$subdivision_code,$circlecode,$mouzacode,$lot_code,$village_code,$dag_no);
	if($sroCheck===false)
	{
	$innerquery_sro = "SELECT  dag_area_b, dag_area_k, dag_area_lc,reg_to_name,reg_from_name,name_of_sro,deed_no,date_of_deed, status,deed_type FROM  sro_note where  dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' "; //and rmk_type_hist_no='$rmk_type_hist_no' ";
	$innerdata_sro_note = $this->db->query($innerquery_sro)->result();
	foreach ($innerdata_sro_note as $sro) {
		$data1[$dag_no]['sro'][] = array(
			'dag_no' => $dag_no,
			'dag_area_b' => $sro->dag_area_b,
			'dag_area_k' => $sro->dag_area_k,
			'dag_area_lc' => $sro->dag_area_lc,
			'reg_to_name' => $sro->reg_to_name,
			'reg_from_name' => $sro->reg_from_name,
			'name_of_sro' => $sro->name_of_sro,
			'deed_no' => $sro->deed_no,
			'date_of_deed' => $sro->date_of_deed,
			'status' => $sro->status,
			'deed_type' => $sro->deed_type
		);
	}
	}
	//lm note
	$innerquery_LMNOTE = "select  lm_note,lm_note_date,lm_code FROM  chitha_rmk_lmnote where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' ";
	$innerdata_LMNOTE = $this->db->query($innerquery_LMNOTE)->result();
	foreach ($innerdata_LMNOTE as $lmnote) {
		$q = "Select lm_name from   lm_code where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lmnote->lm_code' ";
		$lm_name = $this->db->query($q)->row()->lm_name;
		$lm_note = $lmnote->lm_note;
		$lm_note_date = $lmnote->lm_note_date;
		$lm_code = $lmnote->lm_code;
		$data1[$dag_no]['lmnote'][] = array(
			'lm_note' => $lmnote->lm_note,
			'lm_code' => $lm_name,
			'lm_note_date' => $lmnote->lm_note_date
		);
	}
}
	//result encro
	//modification ends here
	//            $sysyear = date("Y");
	//            for ($j = 0; $j < 3; $j++) {
	//                $year = $sysyear;
	//
	//                $sysyear = ($sysyear - 1);
	//
	//
	//
	//                $innerquery18 = "select type_of_used_noncrop,noncrop_land_area_b,noncrop_land_area_k,noncrop_land_area_lc from   chitha_noncrop where dist_code='$district_code' "
	//                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	//                        . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' and yn='$year' ";
	//                $innerdata18 = $this->db->query($innerquery18)->result();
	//                foreach ($innerdata18 as $noncropInfo) {
	//
	//                    $type_of_used_noncrop = $noncropInfo->type_of_used_noncrop;
	//                    $noncrop_land_area_b = $noncropInfo->noncrop_land_area_b;
	//                    $noncrop_land_area_k = $noncropInfo->noncrop_land_area_k;
	//                    $noncrop_land_area_lc = $noncropInfo->noncrop_land_area_lc;
	//
	//                    $innerquery19 = "select noncrop_type from   used_noncrop_type where used_noncrop_type_code = '$type_of_used_noncrop'";
	//                    $innerdata19 = $this->db->query($innerquery19)->result();
	//                    foreach ($innerdata19 as $noncrptyp) {
	//                        $noncrop_type = $noncrptyp->noncrop_type;
	//                    }
	//                }
	//
	//
	//
	//
	//
	//                $innerquery20 = " select source_of_water,crop_code,crop_land_area_b,crop_land_area_k,crop_land_area_lc from   chitha_mcrop where dist_code='$district_code' "
	//                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	//                        . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' and yearno='$year' and crop_code<>'057' ";
	//
	//                $innerdata20 = $this->db->query($innerquery20)->result();
	//                foreach ($innerdata20 as $mcropdetails) {
	//                    $source_of_water = $mcropdetails->source_of_water;
	//                    $crop_code = $mcropdetails->crop_code;
	//                    $crop_land_area_b = $mcropdetails->crop_land_area_b;
	//                    $crop_land_area_k = $mcropdetails->crop_land_area_k;
	//                    $crop_land_area_lc = $mcropdetails->crop_land_area_lc;
	//
	//                    $innerquery21 = " select source from   source_water where water_source_code = '$source_of_water'";
	//                    $innerdata21 = $this->db->query($innerquery21)->result();
	//                    foreach ($innerdata21 as $watersrc) {
	//
	//                        $sourceOFwater = $watersrc->source;
	//                    }
	//
	//                    $innerquery22 = "select crop_name from   crop_code where crop_code = '$crop_code'";
	//                    $innerdata22 = $this->db->query($innerquery22)->result();
	//                    foreach ($innerdata22 as $cropinfo) {
	//                        $cropname = $cropinfo->crop_name;
	//                    }
	//                }
	//            }
	//            $innerquery23 = "select fruit_plants_name from   chitha_fruit where dist_code='$district_code' "
	//                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	//                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' ORDER BY Fruit_plant_ID";
	//
	//            $innerdata23 = $this->db->query($innerquery23)->result();
	//            foreach ($innerdata23 as $chithafruitinf) {
	//
	//                $fruit_plants_name = $chithafruitinf->fruit_plants_name;
	//
	//
	//                $innerquery24 = "select fruit_name from   fruit_tree_code where fruit_code='$fruit_plants_name'";
	//                $innerdata24 = $this->db->query($innerquery24)->result();
	//                foreach ($innerdata24 as $fruitinfo) {
	//                    $fruit_name = $fruitinfo->fruit_name;
	//                }
	//            }
	//
	//
	//            //for remark column
	//            $innerquery25 = "select dag_area_b,dag_area_k,dag_area_lc,reg_from  _name,deed_type,reg_to_name,name_of_sro,deed_no,date_of_deed from   sro_note where dag_no='$dag_no'";
	//            $innerdata25 = $this->db->query($innerquery25)->result();
	//            foreach ($innerdata25 as $sronoteInfo) {
	//                $dag_area_b = $sronoteInfo->dag_area_b;
	//                $dag_area_k = $sronoteInfo->dag_area_k;
	//                $dag_area_lc = $sronoteInfo->dag_area_lc;
	//            }
	//        }
	// ini_set('xdebug.var_display_max_depth', 15);
	//ini_set('xdebug.var_display_max_children', 256);
	// ini_set('xdebug.var_display_max_data', 1024);
	return $data1;
}
	// <!----------------db swicth------------>
public function getchithaDetailsALLBarak($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper) {
	//$this->db = $CI->load->database('db', TRUE);
	//$this->dbswitch();
	$this->dbswitch();
	ini_set('max_execution_time', 0);
	$q = "Select cb.old_dag_no, cb.dag_no,cb.dag_no_int,cb.patta_no,cb.dag_area_b,cb.dag_area_k,cb.dag_area_lc,cb.dag_area_g,cb.dag_revenue,
	cb.dag_local_tax,lcc.land_type from   chitha_basic AS cb JOIN  landclass_code
	AS lcc ON cb.land_class_code = lcc.class_code where Dist_code='$district_code' and Subdiv_code='$subdivision_code'
	and Cir_code='$circlecode'
	and Mouza_Pargona_code='$mouzacode' and Lot_No='$lot_code' and Vill_townprt_code='$village_code'
	and CAST(coalesce(cb.dag_no_int, '0') AS numeric)>=$dag_no_lower and
	CAST(coalesce(cb.dag_no_int, '0') AS numeric)<=$dag_no_upper order by CAST(coalesce(cb.dag_no_int, '0') AS numeric)";
	$district = $this->db->query("
		Select cb.old_dag_no, cb.dag_no,cb.patta_no,cb.patta_type_code,cb.dag_area_b,cb.dag_area_k,cb.dag_area_lc,cb.dag_area_g,cb.dag_revenue,
		cb.dag_local_tax,lcc.land_type,lcc.class_code_cat  from   chitha_basic AS cb JOIN  landclass_code
		AS lcc ON cb.land_class_code = lcc.class_code where Dist_code='$district_code' and Subdiv_code='$subdivision_code'
		and Cir_code='$circlecode'
		and Mouza_Pargona_code='$mouzacode' and Lot_No='$lot_code' and Vill_townprt_code='$village_code'
		and CAST(coalesce(cb.dag_no_int, '0') AS numeric)>=$dag_no_lower and
		CAST(coalesce(cb.dag_no_int, '0') AS numeric)<=$dag_no_upper order by CAST(coalesce(cb.dag_no_int, '0') AS numeric)");
	$data1 = array();
	$outerdata = $district->result();
	$innerdata = array();
	// $chithadetailsArr = array();
	$innerdata2 = array();
	$innerdata3 = array();
	$innerdata4 = array();
	$innerdata5 = array();
	$innerdata6 = array();
	$innerdata7 = array();
	$innerdata8 = array();
	$innerdata9 = array();
	$innerdata10 = array();
	$innerdata11 = array();
	$innerdata12 = array();
	$innerdata13 = array();
	$innerdata14 = array();
	$innerdata15 = array();
	$innerdata16 = array();
	$innerdata17 = array();
	$innerdata18 = array();
	$innerdata19 = array();
	$innerdata20 = array();
	$innerdata21 = array();
	$innerdata22 = array();
	$innerdata23 = array();
	$innerdata24 = array();
	$innerdata25 = array();
	$innerdata26 = array();
	$relation = array();
	//this is the start of the loop for each dag..
	foreach ($outerdata as $chithadetails) {
		$patta_no = trim($chithadetails->patta_no);
		$dag_no = $chithadetails->dag_no;
		$patta_code = $chithadetails->patta_type_code;
		$backlog_court_order = "select * from   backlog_orders where dist_code='$district_code' and subdiv_code='$subdivision_code' and"
		. " cir_code='$circlecode' and lot_no='$lot_code' and mouza_pargona_code='$mouzacode' and "
		. " vill_townprt_code='$village_code' and dag_no='$dag_no' "
		. " and patta_type_code='$patta_code' and category=0";
		$data_court = $this->db->query($backlog_court_order)->result();
		$backlogquery = "select * from   backlog_orders where dist_code='$district_code' and subdiv_code='$subdivision_code' and"
		. " cir_code='$circlecode' and lot_no='$lot_code' and mouza_pargona_code='$mouzacode' and "
		. " vill_townprt_code='$village_code' and dag_no='$dag_no' "
		. " and patta_type_code='$patta_code' and category=1";
		$data = $this->db->query($backlogquery)->result();
		$backlogquery = "select * from   backlog_orders where dist_code='$district_code' and subdiv_code='$subdivision_code' and"
		. " cir_code='$circlecode' and lot_no='$lot_code' and mouza_pargona_code='$mouzacode' and "
		. " vill_townprt_code='$village_code' and dag_no='$dag_no' "
		. " and patta_type_code='$patta_code' and category=2";
		$dataBacklog31 = $this->db->query($backlogquery)->result();
		$patta_type_name = $this->db->query("Select patta_type as patta_type_name from   patta_code where type_code ='$patta_code'")->row()->patta_type_name;
	
		$data1[$dag_no] = array(
			'old_dag_no' => $chithadetails->old_dag_no,
			'dag_no' => $chithadetails->dag_no,
			'patta_no' => trim($chithadetails->patta_no),
			'patta_type_name' => $patta_type_name,
			'dag_area_b' => $chithadetails->dag_area_b,
			'dag_area_k' => $chithadetails->dag_area_k,
			'dag_area_lc' => $chithadetails->dag_area_lc,
			'dag_area_g' => $chithadetails->dag_area_g,
			'dag_revenue' => $chithadetails->dag_revenue,
			'dag_localtax' => $chithadetails->dag_local_tax,
			'land_type' => $chithadetails->land_type,
			'class_code_cat' => $chithadetails->class_code_cat,
		);
		$innerquery4 = "select col8order_cron_no,order_type_code,nature_trans_code,mut_land_area_b,mut_land_area_k,mut_land_area_lc,mut_land_area_g,user_code,rajah_adalat,lm_code,case_no,"
		. "co_ord_date,deed_reg_no,deed_value,deed_date,operation,co_code from   Chitha_col8_order where dist_code='$district_code' and subdiv_code='$subdivision_code' "
		. "and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and (dag_no='$dag_no' ) ";
		$innerdata4 = $this->db->query($innerquery4)->result();
	// this is the start to col8 order details
		foreach ($innerdata4 as $col8OrderDetails) {
			$col8order_cron_no = $col8OrderDetails->col8order_cron_no;
			$order_type_code = $col8OrderDetails->order_type_code;
			$nature_trans_code = $col8OrderDetails->nature_trans_code;
			$mut_land_area_b = $col8OrderDetails->mut_land_area_b;
			$mut_land_area_k = $col8OrderDetails->mut_land_area_k;
			$mut_land_area_lc = $col8OrderDetails->mut_land_area_lc;
			$mut_land_area_g = $col8OrderDetails->mut_land_area_g;
			$user_code = $col8OrderDetails->user_code;
			$rajah_adalat = $col8OrderDetails->rajah_adalat;
			$lm_code = $col8OrderDetails->lm_code;
			$case_no = $col8OrderDetails->case_no;
			$co_ord_date = $col8OrderDetails->co_ord_date;
			$deed_value = $col8OrderDetails->deed_value;
			$deed_reg_no = $col8OrderDetails->deed_reg_no;
			$deed_date = $col8OrderDetails->deed_date;
			$co_code = $col8OrderDetails->co_code;
			$operation = $col8OrderDetails->operation;
			$inplace_of_name = "";
			$inplaceof_alongwith = "";
			$occupant_name = "";
			$occupant_fmh_name = "";
			$occupant_fmh_flag = "";
			$new_patta_no = "";
			$new_dag_no = "";
			$hus_wife = "";
			$nature_trans_desc = "";
			$lm_name = "";
			$innerquery5 = "select order_type from   master_field_mut_type
			where  order_type_code = '$order_type_code' ";
	
			$innerdata5 = $this->db->query($innerquery5)->row();
			$ordertype = $innerdata5->order_type;
			$innerquery6 = "select inplace_of_name,inplaceof_alongwith from   chitha_col8_inplace
			where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' "
			. "and  mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and "
			. " vill_townprt_code='$village_code' and Dag_no='$dag_no' and Col8Order_cron_no='$col8order_cron_no' "
			. " ORDER BY inplace_of_id";
			$innerdata6 = $this->db->query($innerquery6)->result();
			$inplace_data = array();
			$innerquery7 = "select trans_desc_as from   nature_trans_code where trans_code = '$nature_trans_code'";
	
	//$nature_trans_desc = $this->db->query($innerquery7)->row()->trans_desc_as;
			foreach ($innerdata6 as $inplace) {
				$inplace_data[] = array(
					'inplace_of_name' => $inplace->inplace_of_name,
					'inplaceof_alongwith' => $inplace->inplaceof_alongwith,
				);
			}
			$occup_data = array();
			$innerquery8 = "select occupant_name,occupant_fmh_name,occupant_fmh_flag,new_patta_no,new_dag_no,hus_wife from   "
			. " chitha_col8_occup where dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
			. " and (dag_no='$dag_no' or new_dag_no='$dag_no')  and Col8Order_cron_no='$col8order_cron_no' and user_code='$co_code'  ORDER BY occupant_id";
			$innerdata8 = $this->db->query($innerquery8)->result();
			foreach ($innerdata8 as $occupant) {
				$occupant_name = $occupant->occupant_name;
				$occupant_fmh_name = $occupant->occupant_fmh_name;
				$occupant_fmh_flag = $occupant->occupant_fmh_flag;
				$new_patta_no = trim($occupant->new_patta_no);
				$new_dag_no = $occupant->new_dag_no;
				$hus_wife = $occupant->hus_wife;
				$innerquery9 = "select guard_rel_desc_as from   master_guard_rel where guard_rel = '$occupant_fmh_flag'";
				$innerdata9 = $this->db->query($innerquery9)->result();
				$guard_rel_desc_as = "";
				foreach ($innerdata9 as $guard_rel) {
					$guard_rel_desc_as = $guard_rel->guard_rel_desc_as;
				}
				$occup_data[] = array(
					'occupant_name' => $occupant->occupant_name,
					'occupant_fmh_name' => $occupant->occupant_fmh_name,
					'occupant_fmh_flag' => $occupant->occupant_fmh_flag,
					'new_patta_no' => trim($occupant->new_patta_no),
					'new_dag_no' => $occupant->new_dag_no,
					'hus_wife' => $occupant->hus_wife,
					'guard_rel_desc_as' => $guard_rel_desc_as
				);
			}
			$innerquery10 = "select lm_name from   lm_code  where dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
			. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code = '$lm_code' ";
	
			$innerdata10 = $this->db->query($innerquery10)->result();
			foreach ($innerdata10 as $lm) {
				$lm_name = $lm->lm_name;
			}
			$innerquery11 = "select username,status from   users where dist_code='$district_code' "
			. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code='$user_code'";
			$innerdata11 = $this->db->query($innerquery11)->result();
			foreach ($innerdata11 as $users) {
				$username = $users->username;
				$status = $users->status;
			}
			if ($order_type_code == '03') {
	$innerquery12 = "select * from   field_mut_objection where objection_case_no='$case_no' "; //and  obj_flag is not null and chitha_correct_yn='1' ";
	$innerdata12 = $this->db->query($innerquery12)->result();
	foreach ($innerdata12 as $objection) {
		$q = "select col8order_cron_no,dag_no from   chitha_col8_order where case_no='$objection->prev_fm_ca_no' ";
		$col8_cronNo = $this->db->query($q)->row();
		$q = "select occupant_name from   chitha_col8_occup where dist_code='$district_code' "
		. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
		. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and
		col8order_cron_no='$col8_cronNo->col8order_cron_no' and dag_no='$col8_cronNo->dag_no'  ";
		$result = $this->db->query($q)->result();
		$fname = "";
		foreach ($result as $name) {
			$fname = $fname . $name->occupant_name . ",";
		}
		$data1[$dag_no]['objection'][] = array(
			'mut_type' => $objection->mut_type,
			'regist_date' => $objection->regist_date,
			'objection_case_no' => $objection->objection_case_no,
			'prev_fm_ca_no' => $objection->prev_fm_ca_no,
			'submission_date' => $objection->entry_date,
			'obj_name' => $objection->obj_name,
			'co_id' => $objection->co_id,
			'occupant' => $fname
		);
	}
}
$innerquery13 = "select * from   field_mut_petitioner where case_no='$case_no' ";
$innerdata13 = $this->db->query($innerquery13)->result();
if ($order_type_code == '01') {
	$innerquery14 = " select deed_reg_no,deed_value,deed_date from   chitha_col8_order
	where Order_type_code='$order_type_code' and dag_no='$dag_no' and case_no='$case_no'";
	
	$innerdata14 = $this->db->query($innerquery14)->result();
	foreach ($innerdata14 as $deedinf) {
		$deed_reg_no = $deedinf->deed_reg_no;
		$deed_value = $deedinf->deed_value;
		$deed_date = $deedinf->deed_date;
	}
}
$co_name = "select username from   users where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' and user_code='$user_code'";
$co_name = $this->db->query($co_name)->result();
foreach ($co_name as $co) {
	$co_username = $co->username;
}
	
if ($order_type_code != '03') {
	$data1[$dag_no]['col8'][] = array(
		'co_ord_date' => $col8OrderDetails->co_ord_date,
		'order_type_code' => $col8OrderDetails->order_type_code,
		'case_no' => $col8OrderDetails->case_no,
		'col8order_cron_no' => $col8OrderDetails->col8order_cron_no,
		'order_type' => $ordertype,
		'nature_trans_code' => $col8OrderDetails->nature_trans_code,
		'mut_land_area_b' => $col8OrderDetails->mut_land_area_b,
		'mut_land_area_k' => $col8OrderDetails->mut_land_area_k,
		'mut_land_area_lc' => $col8OrderDetails->mut_land_area_lc,
		'mut_land_area_g' => $col8OrderDetails->mut_land_area_g,
		'inplace' => $inplace_data,
		'occup' => $occup_data,
		'rajah' => $rajah_adalat,
		'deed_value' => $deed_value,
		'deed_reg_no' => $deed_reg_no,
		'deed_date' => $deed_date,
		'lm_name' => $lm_name,
		'username' => $username,
		'co_name' => $co_username,
		'operation' => $operation
	);
}
}
$data1[$dag_no]['backlog_court_order'][] = $data_court;
$data1[$dag_no]['backlogs'][] = $data;
$data1[$dag_no]['backlogs31'][] = $dataBacklog31;
	// this is the End to col8 order details
$d = $this->getCol31Kar($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no);
$data1[$dag_no]['col31'][] = $d;
$lmnotes = $this->getLmNotes($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no);
$data1[$dag_no]['lmnotes'] = $lmnotes;
//////////Remarks for LandClass//////////////
$data1[$dag_no]['classRemark'] = $this->landClass($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no);
///////////////////////
$innerquery = "select p_flag,pdar_id,patta_no,dag_por_b,dag_por_k,dag_por_lc,dag_por_g from   chitha_dag_pattadar where dist_code='$district_code' "
. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
. " and dag_no='$dag_no' and TRIM(patta_no)='$patta_no' and  patta_type_code='$patta_code' order by pdar_id";
$innerdata = $this->db->query($innerquery)->result();
$data1[$dag_no]['pattadars'] = array();
foreach ($innerdata as $data) {
	// $p_flag = $data->p_flag;
	$pdar_id = $data->pdar_id;
	$patta_no = trim($data->patta_no);
	//$data1[$dag_no]['col8'] = array();
	$data1[$dag_no]['tenant'] = array();
	$data1[$dag_no]['subtenant'] = array();
	$innerquery2 = "select pdar_name,pdar_father,new_pdar_name,pdar_guard_reln,pdar_add1,Pdar_add2,Pdar_add3 from   chitha_pattadar where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' "
	. " and TRIM(patta_no)='$patta_no' and  patta_type_code='$patta_code' and pdar_id=$data->pdar_id order by pdar_id";
	
	$innerdata2 = $this->db->query($innerquery2)->result();
	/* if (!empty($innerdata2)) {
	
	} else {
	
} */
	/* if (!empty($innerdata2)) {
	
	} else {
	
} */
	/* if (!empty($innerdata2)) {
	
	} else {
	
	} */
	foreach ($innerdata2 as $pdardata) {
		$pdar_guardRelation = $pdardata->pdar_guard_reln;
		$innerquery3 = "select guard_rel_desc_as from   master_guard_rel where guard_rel_desc = '$pdar_guardRelation'";
		$innerdata3 = $this->db->query($innerquery3)->result();
		foreach ($innerdata3 as $guard_rel_desc) {
			$relation = $guard_rel_desc->guard_reln_desc_as;
		}
		$data1[$dag_no]['pattadars'][] = array(
			'p_flag' => $data->p_flag,
			'dag_por_b' => $data->dag_por_b,
			'dag_por_k' => $data->dag_por_k,
			'dag_por_lc' => $data->dag_por_lc,
			'dag_por_g' => $data->dag_por_g,
			'pdar_name' => $pdardata->pdar_name,
			'guard_reln_desc_as' => $relation,
			'new_pdar_name' => $pdardata->new_pdar_name,
			'pdar_father' => $pdardata->pdar_father,
			'pdar_relation' => $pdardata->pdar_guard_reln,
			'pdar_address1' => $pdardata->pdar_add1,
			'pdar_address2' => $pdardata->pdar_add2,
			'pdar_address3' => $pdardata->pdar_add3,
			'pdar_guard_reln' => $pdardata->pdar_guard_reln,
			'pdar_id' => $pdar_id
		);
	}
	$innerquery15 = " select tenant_name,tenants_father,tenants_add1,tenants_add2,tenants_add3,type_of_tenant,khatian_no,revenue_tenant,crop_rate,tenant_id,status from   chitha_tenant where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no='$dag_no' order by tenant_id";
	$innerdata15 = $this->db->query($innerquery15)->result();
	
	
	
	foreach ($innerdata15 as $tenant) {
		if ($tenant->type_of_tenant == null) {
			$tenant_typ = "00";
		} else {
			$tenant_typ = $tenant->type_of_tenant;
		}
		$tenant_name = $tenant->tenant_name;
		$tenants_father = $tenant->tenants_father;
		$tenants_add1 = $tenant->tenants_add1;
		$tenants_add2 = $tenant->tenants_add2;
		$tenants_add3 = $tenant->tenants_add3;
		$type_of_tenant = $tenant_typ;
		$khatian_no = $tenant->khatian_no;
		$status = $tenant->status;
		$revenue_tenant = $tenant->revenue_tenant;
		$crop_rate = $tenant->crop_rate;
		$tenant_id = $tenant->tenant_id;
		if ($tenant->type_of_tenant == null) {
			$tenant_typ = "00";
		} else {
			$tenant_typ = $tenant->type_of_tenant;
		}
		$tenant_name = $tenant->tenant_name;
		$tenants_father = $tenant->tenants_father;
		$tenants_add1 = $tenant->tenants_add1;
		$tenants_add2 = $tenant->tenants_add2;
		$tenants_add3 = $tenant->tenants_add3;
		$type_of_tenant = $tenant_typ;
		$khatian_no = $tenant->khatian_no;
		$status = $tenant->status;
		$revenue_tenant = $tenant->revenue_tenant;
		$crop_rate = $tenant->crop_rate;
		$tenant_id = $tenant->tenant_id;
		if ($tenant->type_of_tenant == "00") {
			$tenant_typ = "";
		} else {
			$tenant_typ = $tenant->type_of_tenant;
		}
		$tenant_name = $tenant->tenant_name;
		$tenants_father = $tenant->tenants_father;
		$tenants_add1 = $tenant->tenants_add1;
		$tenants_add2 = $tenant->tenants_add2;
		$tenants_add3 = $tenant->tenants_add3;
		$type_of_tenant = $tenant_typ;
		$khatian_no = $tenant->khatian_no;
		$status = $tenant->status;
		$revenue_tenant = $tenant->revenue_tenant;
		$crop_rate = $tenant->crop_rate;
		$tenant_id = $tenant->tenant_id;
		$innerquery16 = "Select tenant_type from   Tenant_type where type_code ='$type_of_tenant'";
		$innerdata16 = $this->db->query($innerquery16)->result();
		foreach ($innerdata16 as $tenanttype) {
			$tenant_type = $tenanttype->tenant_type;
			$data1[$dag_no]['tenant'][] = array(
				'tenant_name' => $tenant->tenant_name,
				'tenants_father' => $tenant->tenants_father,
				'tenants_add1' => $tenant->tenants_add1,
				'tenants_add2' => $tenant->tenants_add2,
				'tenants_add3' => $tenant->tenants_add3,
				'type_of_tenant' => $tenant->type_of_tenant,
				'khatian_no' => $tenant->khatian_no,
				'status' => $tenant->status,
				'revenue_tenant' => $tenant->revenue_tenant,
				'crop_rate' => $tenant->crop_rate,
				'tenant_type' => $tenanttype->tenant_type,
			);
		}
		$innerquery17 = "Select subtenant_name,subtenants_father,subtenants_add1,subtenants_add2,subtenants_add3 from   Chitha_Subtenant where  dist_code='$district_code' "
		. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
		. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and Dag_no='$dag_no' and tenant_id = '$tenant_id'";
		$innerdata17 = $this->db->query($innerquery17)->result();
		$subtenant_name = "";
		$subtenants_father = "";
		$subtenants_add1 = "";
		$subtenants_add2 = "";
		$subtenants_add = "";
		foreach ($innerdata17 as $subtenant) {
			$subtenant_name = $subtenant->subtenant_name;
			$subtenants_father = $subtenant->subtenants_father;
			$subtenants_add1 = $subtenant->subtenants_add1;
			$subtenants_add2 = $subtenant->subtenants_add2;
			$subtenants_add3 = $subtenant->subtenants_add3;
			$data1[$dag_no]['subtenant'][] = array(
				'subtenant_name' => $subtenant->subtenant_name,
				'subtenants_father' => $subtenant->subtenants_father,
				'subtenants_add1' => $subtenant->subtenants_add1,
				'subtenants_add2' => $subtenant->subtenants_add2,
				'subtenants_add3' => $subtenant->subtenants_add3,
			);
		}
	}
}
	//modification by bondita
$sysyear = date("Y");
	
$data1[$dag_no]['archeo'] = array();
$data1[$dag_no]['noncrp'] = array();
$data1[$dag_no]['mcrp'] = array();
$data1[$dag_no]['fruit'] = array();
$data1[$dag_no]['mcrp_akeadhig'] = array();
$data1[$dag_no]['years'] = array();
$year1 = $sysyear;
$year = ($year1 - 2);
for ($j = 0; $j < 3; $j++) {
	$innerquerynoncrp = "select type_of_used_noncrop,noncrop_land_area_b,noncrop_land_area_k,noncrop_land_area_lc,noncrop_land_area_g from   chitha_noncrop where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' and yn='$year'";
	$innerdatanoncrp = $this->db->query($innerquerynoncrp)->result();
	foreach ($innerdatanoncrp as $noncrop) {
		$type_of_used_noncrp = $noncrop->type_of_used_noncrop;
		$noncrp_b = $noncrop->noncrop_land_area_b;
		$noncrop_k = $noncrop->noncrop_land_area_k;
		$noncrop_lc = $noncrop->noncrop_land_area_lc;
		$noncrop_g = $noncrop->noncrop_land_area_g;
		$innerquery19 = "select noncrop_type from   used_noncrop_type where used_noncrop_type_code = '$type_of_used_noncrp'";
		$innerdata19 = $this->db->query($innerquery19)->result();
		foreach ($innerdata19 as $noncrptyp) {
			$noncrop_type = $noncrptyp->noncrop_type;
			$data1[$dag_no]['noncrp'][] = array(
				'year' => $year,
				'type_of_used_noncrp' => $noncrop_type,
				'noncrp_b' => $noncrp_b,
				'noncrop_k' => $noncrop_k,
				'noncrop_lc' => $noncrop_lc,
				'noncrop_g' => $noncrop_g
			);
		}
	}
	$innerquerycrp = " select source_of_water,crop_code,crop_land_area_b,crop_land_area_k,crop_land_area_lc,crop_land_area_g,crop_categ_code from   chitha_mcrop where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' and yearno='$year' and crop_code<>'057' ";
	$innerdatacrp = $this->db->query($innerquerycrp)->result();
	foreach ($innerdatacrp as $mcropdetails) {
		$source_of_water = $mcropdetails->source_of_water;
		$crop_code = $mcropdetails->crop_code;
		$crop_land_area_b = $mcropdetails->crop_land_area_b;
		$crop_land_area_k = $mcropdetails->crop_land_area_k;
		$crop_land_area_lc = $mcropdetails->crop_land_area_lc;
		$crop_land_area_g = $mcropdetails->crop_land_area_g;
		$crop_category = $mcropdetails->crop_categ_code;
		$innerquerywatersrc = "select source from   source_water where water_source_code = '$source_of_water'";
		$innerdatawatersrc = $this->db->query($innerquerywatersrc)->result();
		foreach ($innerdatawatersrc as $watersrc) {
			$sourceOFwater = $watersrc->source;
			$innerqueryCropCateg = "select crop_categ_desc from   crop_category_code where crop_categ_code = '$crop_category'";
			$innerdataCropcateg = $this->db->query($innerqueryCropCateg)->result();
			foreach ($innerdataCropcateg as $CropDesc) {
				$CropDesc_inChitha = $CropDesc->crop_categ_desc;
				$innerquerymcrop = "select crop_name from   crop_code where crop_code = '$crop_code'";
				$innerdatamcrop = $this->db->query($innerquerymcrop)->result();
				foreach ($innerdatamcrop as $cropinfo) {
					$cropname = $cropinfo->crop_name;
					$data1[$dag_no]['mcrp'][] = array(
						'sourceofwater' => $sourceOFwater,
						'cropname' => $cropname,
						'mcrp_b' => $crop_land_area_b,
						'mcrop_k' => $crop_land_area_k,
						'mcrop_lc' => $crop_land_area_lc,
						'mcrop_g' => $crop_land_area_g,
						'crop_category' => $CropDesc_inChitha
					);
				}
			}
		}
	}
	$innerquerycrp_ekadhig = " select crop_land_area_b,crop_land_area_k,crop_land_area_lc,crop_land_area_g from   chitha_mcrop where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' and yearno='$year' and crop_code = '057' ";
	
	$innerdatacrp_ekadhig = $this->db->query($innerquerycrp_ekadhig)->result();
	foreach ($innerdatacrp_ekadhig as $ekadhig)
		$data1[$dag_no]['mcrp_akeadhig'][] = array(
			'bigha' => $ekadhig->crop_land_area_b,
			'katha' => $ekadhig->crop_land_area_k,
			'lesa' => $ekadhig->crop_land_area_lc,
			'ganda' => $ekadhig->crop_land_area_g
		);
	$data1[$dag_no]['years'][] = array(
		'year' => $year
	);
	$year = ($year + 1);
}
$innerquery23 = "select fruit_plants_name,no_of_plants,fruit_land_area_b,fruit_land_area_k,fruit_land_area_lc,fruit_land_area_g from   chitha_fruit where dist_code='$district_code' "
. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' ORDER BY Fruit_plant_ID";
$innerdata23 = $this->db->query($innerquery23)->result();
foreach ($innerdata23 as $chithafruitinf) {
	$fruit_plants_name = $chithafruitinf->fruit_plants_name;
	$no_of_fruit_plants = $chithafruitinf->no_of_plants;
	$fruit_bigha = $chithafruitinf->fruit_land_area_b;
	$fruit_katha = $chithafruitinf->fruit_land_area_k;
	$fruit_lesa = $chithafruitinf->fruit_land_area_lc;
	$fruit_ganda = $chithafruitinf->fruit_land_area_g;
	$innerquery24 = "select fruit_name from   fruit_tree_code where fruit_code='$fruit_plants_name'";
	$innerdata24 = $this->db->query($innerquery24)->result();
	foreach ($innerdata24 as $fruitinfo) {
		$fruit_name = $fruitinfo->fruit_name;
		$data1[$dag_no]['fruit'][] = array(
			'fruitname' => $fruit_name,
			'no_of_plants' => $no_of_fruit_plants,
			'fbigha' => $fruit_bigha,
			'fkatha' => $fruit_katha,
			'flesa' => $fruit_lesa,
			'fganda' => $fruit_ganda
		);
	}
}
$chithaarcheo = "select archeo_hist_code,hist_land_area_b,hist_land_area_k,hist_land_area_lc,hist_land_area_g,archeo_hist_site_desc from   chitha_acho_hist where dist_code='$district_code' "
. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no'";
	
$innerdataarcheo = $this->db->query($chithaarcheo)->result();
	foreach ($innerdataarcheo as $archeoinfo) {
	$archeo_code = $archeoinfo->archeo_hist_code;
	$archeo_area_b = $archeoinfo->hist_land_area_b;
	$archeo_area_k = $archeoinfo->hist_land_area_k;
	$archeo_area_lc = $archeoinfo->hist_land_area_lc;
	$archeo_area_g = $archeoinfo->hist_land_area_g;
	$archeo_area_description = $archeoinfo->archeo_hist_site_desc;
	$archeo_siteCd = "select archeo_hist_desc from   archeo_hist_site_code where archeo_hist_code='$archeo_code' ";
	$innerdataarcheo_cd = $this->db->query($archeo_siteCd)->result();
	foreach ($innerdataarcheo_cd as $archeo_cd) {
		$hist_description = $archeo_cd->archeo_hist_desc;
		$data1[$dag_no]['archeo'][] = array(
			'hist_description_nme' => $hist_description,
			'archeo_hist_code' => $archeo_code,
			'archeo_b' => $archeo_area_b,
			'archeo_k' => $archeo_area_k,
			'archeo_lc' => $archeo_area_lc,
			'archeo_g' => $archeo_area_g,
			'archeo_decribed' => $archeo_area_description
		);
	}
}
$innerquery58 = "SELECT encro_evicted_yn,encro_name,encro_since,encro_land_b,encro_land_k,encro_land_lc,encro_land_g,encro_land_used_for,encro_evic_date FROM  chitha_rmk_encro where  dist_code='$district_code' "
. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' "; //and rmk_type_hist_no='$rmk_type_hist_no' ";
	$innerdata58 = $this->db->query($innerquery58)->result();
	foreach ($innerdata58 as $encro) {
		$encro_land_used_for = $encro->encro_land_used_for;
		$innerquery_encroland = "SELECT used_for from   encro_land_used_for where code='$encro_land_used_for' ";
		$innerdata_encroland = $this->db->query($innerquery_encroland)->result();
		foreach ($innerdata_encroland as $encro_land) {
			$data1[$dag_no]['encro'][] = array(
				'encro_evicted_yn' => $encro->encro_evicted_yn,
				'encro_name' => $encro->encro_name,
				'encro_since' => $encro->encro_since,
				'encro_land_b' => $encro->encro_land_b,
				'encro_land_k' => $encro->encro_land_k,
				'encro_land_lc' => $encro->encro_land_lc,
				'encro_land_g' => $encro->encro_land_g,
				'encro_land_used_for' => $encro->encro_land_used_for,
				'encro_evic_date' => $encro->encro_evic_date,
				'land_used_by_encro' => $encro_land->used_for
			);
		}
	}
	//sro note
	$sroCheck=$this->govtDagSro($district_code,$subdivision_code,$circlecode,$mouzacode,$lot_code,$village_code,$dag_no);
	if($sroCheck===false)
	{
	$innerquery_sro = "SELECT  dag_area_b, dag_area_k, dag_area_lc,dag_area_g,reg_to_name,reg_from_name,name_of_sro,deed_no,date_of_deed, status,deed_type FROM  sro_note where  dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' "; //and rmk_type_hist_no='$rmk_type_hist_no' ";
	$innerdata_sro_note = $this->db->query($innerquery_sro)->result();
	foreach ($innerdata_sro_note as $sro) {
		$data1[$dag_no]['sro'][] = array(
			'dag_no' => $dag_no,
			'dag_area_b' => $sro->dag_area_b,
			'dag_area_k' => $sro->dag_area_k,
			'dag_area_lc' => $sro->dag_area_lc,
			'dag_area_g' => $sro->dag_area_g,
			'reg_to_name' => $sro->reg_to_name,
			'reg_from_name' => $sro->reg_from_name==null?'':$sro->reg_from_name,
			'name_of_sro' => $sro->name_of_sro,
			'deed_no' => $sro->deed_no,
			'date_of_deed' => $sro->date_of_deed,
			'status' => $sro->status,
			'deed_type' => $sro->deed_type
		);
	}
	}
	//lm note
	$innerquery_LMNOTE = "select  lm_note,lm_note_date,lm_code FROM  chitha_rmk_lmnote where dist_code='$district_code' "
	. " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	. " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' ";
	$innerdata_LMNOTE = $this->db->query($innerquery_LMNOTE)->result();
	foreach ($innerdata_LMNOTE as $lmnote) {
		$lm_note = $lmnote->lm_note;
		$lm_note_date = $lmnote->lm_note_date;
		$lm_code = $lmnote->lm_code;
		$q = "Select lm_name from   lm_code where dist_code='$district_code' and subdiv_code='$subdivision_code' and cir_code='$circlecode' and mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and lm_code='$lm_code' ";
		$lm_code = $this->db->query($q)->row()->lm_name;
		$lm_name = $this->db->query($q)->row()->lm_name;
		$data1[$dag_no]['lmnote'][] = array(
			'lm_note' => $lmnote->lm_note,
			'lm_code' => $lm_code
		);
	}
}
	//result encro
	//modification ends here
	//            $sysyear = date("Y");
	//            for ($j = 0; $j < 3; $j++) {
	//                $year = $sysyear;
	//
	//                $sysyear = ($sysyear - 1);
	//
	//
	//
	//                $innerquery18 = "select type_of_used_noncrop,noncrop_land_area_b,noncrop_land_area_k,noncrop_land_area_lc from   chitha_noncrop where dist_code='$district_code' "
	//                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	//                        . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' and yn='$year' ";
	//                $innerdata18 = $this->db->query($innerquery18)->result();
	//                foreach ($innerdata18 as $noncropInfo) {
	//
	//                    $type_of_used_noncrop = $noncropInfo->type_of_used_noncrop;
	//                    $noncrop_land_area_b = $noncropInfo->noncrop_land_area_b;
	//                    $noncrop_land_area_k = $noncropInfo->noncrop_land_area_k;
	//                    $noncrop_land_area_lc = $noncropInfo->noncrop_land_area_lc;
	//
	//                    $innerquery19 = "select noncrop_type from   used_noncrop_type where used_noncrop_type_code = '$type_of_used_noncrop'";
	//                    $innerdata19 = $this->db->query($innerquery19)->result();
	//                    foreach ($innerdata19 as $noncrptyp) {
	//                        $noncrop_type = $noncrptyp->noncrop_type;
	//                    }
	//                }
	//
	//
	//
	//
	//
	//                $innerquery20 = " select source_of_water,crop_code,crop_land_area_b,crop_land_area_k,crop_land_area_lc from   chitha_mcrop where dist_code='$district_code' "
	//                        . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	//                        . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' and yearno='$year' and crop_code<>'057' ";
	//
	//                $innerdata20 = $this->db->query($innerquery20)->result();
	//                foreach ($innerdata20 as $mcropdetails) {
	//                    $source_of_water = $mcropdetails->source_of_water;
	//                    $crop_code = $mcropdetails->crop_code;
	//                    $crop_land_area_b = $mcropdetails->crop_land_area_b;
	//                    $crop_land_area_k = $mcropdetails->crop_land_area_k;
	//                    $crop_land_area_lc = $mcropdetails->crop_land_area_lc;
	//
	//                    $innerquery21 = " select source from   source_water where water_source_code = '$source_of_water'";
	//                    $innerdata21 = $this->db->query($innerquery21)->result();
	//                    foreach ($innerdata21 as $watersrc) {
	//
	//                        $sourceOFwater = $watersrc->source;
	//                    }
	//
	//                    $innerquery22 = "select crop_name from   crop_code where crop_code = '$crop_code'";
	//                    $innerdata22 = $this->db->query($innerquery22)->result();
	//                    foreach ($innerdata22 as $cropinfo) {
	//                        $cropname = $cropinfo->crop_name;
	//                    }
	//                }
	//            }
	//            $innerquery23 = "select fruit_plants_name from   chitha_fruit where dist_code='$district_code' "
	//                    . " and subdiv_code='$subdivision_code' and cir_code='$circlecode' and "
	//                    . " mouza_pargona_code='$mouzacode' and  lot_no='$lot_code' and vill_townprt_code='$village_code' and dag_no ='$dag_no' ORDER BY Fruit_plant_ID";
	//
	//            $innerdata23 = $this->db->query($innerquery23)->result();
	//            foreach ($innerdata23 as $chithafruitinf) {
	//
	//                $fruit_plants_name = $chithafruitinf->fruit_plants_name;
	//
	//
	//                $innerquery24 = "select fruit_name from   fruit_tree_code where fruit_code='$fruit_plants_name'";
	//                $innerdata24 = $this->db->query($innerquery24)->result();
	//                foreach ($innerdata24 as $fruitinfo) {
	//                    $fruit_name = $fruitinfo->fruit_name;
	//                }
	//            }
	//
	//
	//            //for remark column
	//            $innerquery25 = "select dag_area_b,dag_area_k,dag_area_lc,reg_from  _name,deed_type,reg_to_name,name_of_sro,deed_no,date_of_deed from   sro_note where dag_no='$dag_no'";
	//            $innerdata25 = $this->db->query($innerquery25)->result();
	//            foreach ($innerdata25 as $sronoteInfo) {
	//                $dag_area_b = $sronoteInfo->dag_area_b;
	//                $dag_area_k = $sronoteInfo->dag_area_k;
	//                $dag_area_lc = $sronoteInfo->dag_area_lc;
	//            }
	//        }
	// ini_set('xdebug.var_display_max_depth', 15);
	//ini_set('xdebug.var_display_max_children', 256);
	// ini_set('xdebug.var_display_max_data', 1024);
	return $data1;
}
	function lmName($d,$s,$c,$m,$l,$u){
		$innerquery55 = "select lm_name FROM  lm_code where dist_code=? "
		. " and subdiv_code=? and cir_code=? and "
		. " mouza_pargona_code=? and  lot_no=? and lm_code=? ";
		$innerdata55 = $this->db->query($innerquery55,array($d,$s,$c,$m,$l,$u));
		if($innerdata55->num_rows()>0){
			$lm_name=$innerdata55->row()->lm_name;
		}else{
			$lm_name="NA";
		}
		return $lm_name;
	}
	function coName($d,$s,$c,$u){
		$innerquery54 = "select username FROM users where dist_code=? "
			. " and subdiv_code=? and cir_code=? and user_code =?";
		$innerdata54 = $this->db->query($innerquery54,array($d,$s,$c,$u));
		if($innerdata54->num_rows()>0){
			$co_name=$innerdata54->row()->username;
		}else{
			$co_name="NA";
		}
		return $co_name;
	}
	function chithaDagArea($d,$s,$c,$m,$l,$v,$dag){
		$innerquery55 = "select dag_area_b,dag_area_k,round(dag_area_lc,2) as dag_area_lc,round(dag_area_g,2) as dag_area_g FROM chitha_basic where dist_code=? "
			. " and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
		$innerdata55 = $this->db->query($innerquery55,array($d,$s,$c,$m,$l,$v,$dag));
		if($innerdata55->num_rows()>0){
			$oldDagArea=$innerdata55->row();
		}else{
			$oldDagArea="NA";
		}
		return $oldDagArea;
	}
	function govtDagSro($d,$s,$c,$m,$l,$v,$dag){
		$innerquerySroCheck = "select * FROM chitha_basic where dist_code=? "
			. " and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and trim(dag_no)=?";
		$innerquerySroCheck = $this->db->query($innerquerySroCheck,array($d,$s,$c,$m,$l,$v,$dag));
		if($innerquerySroCheck->num_rows()>0){
			$sroPatta=$innerquerySroCheck->row();
			if($sroPatta->patta_no=='0'){
				return true;
			}
			else{
				return false;
			}
		}else{
				return false;
		}
	}
}
?>