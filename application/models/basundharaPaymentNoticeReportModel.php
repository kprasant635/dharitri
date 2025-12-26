<?php
class BasundharaPaymentNoticeReportModel extends CI_Model {
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

	public function getCaseListNew($dist_code, $subdiv_code, $cir_code,$start,$length,$order,$searchByCol_0,$searchByCol_1,$paymentStatus) {
		$this->dbswitch();

		if(isset($searchByCol_0) && $searchByCol_0 != null){
			$cons = " and (s.case_no like '%$searchByCol_0%') ";
		}else{
			$cons = '';
		}
		if(isset($searchByCol_1) && $searchByCol_1 != null){
			$cons1 = " and (s.applid like '%$searchByCol_1%') ";
		}else{
			$cons1 = '';
		}
		
		if($paymentStatus!= null && $paymentStatus != 'G'){
			$paymentStatusCheck =  "and s.status in ('$paymentStatus')";
		}else if($paymentStatus == 'G'){
			$paymentStatusCheck =  "and sp.grn_no is not null";
		}else{
			$paymentStatusCheck = "and s.status in ('M','N')";
		}

		$q = "select s.*,sp.grn_no from settlement_basic s

                join (select distinct on(case_no) case_no,grn_no from settlement_premium where is_final=1) sp
                	
                	on s.case_no =sp.case_no

         				where dist_code = ? and subdiv_code = ? and cir_code = ? $paymentStatusCheck  $cons $cons1 limit $length offset $start ";


		$district = $this->db->query($q,array($dist_code,$subdiv_code,$cir_code));
		log_message('error','---------QUERY--getCaseListNew---'.$this->db->last_query());
		return $district->result();
	}

	public function getCaseListNewCount($dist_code, $subdiv_code, $cir_code,$start,$length,$order,$searchByCol_0,$searchByCol_1,$paymentStatus) {
		$this->dbswitch();

		if(isset($searchByCol_0) && $searchByCol_0 != null){
			$cons = " and (s.case_no like '%$searchByCol_0%') ";
		}else{
			$cons = '';
		}
		if(isset($searchByCol_1) && $searchByCol_1 != null){
			$cons1 = " and (s.applid like '%$searchByCol_1%') ";
		}else{
			$cons1 = '';
		}
		if($paymentStatus!= null && $paymentStatus != 'G'){
			$paymentStatusCheck =  "and s.status in ('$paymentStatus')";
		}else if($paymentStatus == 'G'){
			$paymentStatusCheck =  "and sp.grn_no is not null";
		}else{
			$paymentStatusCheck = "and s.status in ('M','N')";
		}

		$q = "select s.*,sp.grn_no from settlement_basic s

                join (select distinct on(case_no) case_no,grn_no from settlement_premium where is_final=1) sp
                	
                	on s.case_no =sp.case_no

         				where dist_code = ? and subdiv_code = ? and cir_code = ?  $paymentStatusCheck $cons $cons1";


		$district = $this->db->query($q,array($dist_code,$subdiv_code,$cir_code));
		log_message('error','---------QUERY2getCaseListNewCount--'.$this->db->last_query());
		return $district->result();
	}
	public function paymentNoticeCasesReport($dist_code, $subdiv_code, $cir_code,$paymentStatus) {
		$this->dbswitch();
		log_message('error','MB:---PARAMS--'.$dist_code.', '.$subdiv_code.','. $cir_code.',--PaymentStatus---'.$paymentStatus);
		
		if($paymentStatus!= null && $paymentStatus != 'G' && $paymentStatus != 'U'){
			$paymentStatusCheck =  "and s.status in ('$paymentStatus')";
		}else if($paymentStatus == 'G'){
			$paymentStatusCheck =  "and sp.grn_no is not null";
		}else if($paymentStatus == 'U'){
			$paymentStatusCheck =  "and sp.grn_no is null and s.status='N'";
		}
		$q = "select (SELECT loc_name FROM location WHERE dist_code=s.dist_code AND subdiv_code=s.subdiv_code AND cir_code='00') sub_division,
		        (SELECT loc_name FROM location WHERE dist_code=s.dist_code AND  subdiv_code=s.subdiv_code AND cir_code=s.cir_code AND mouza_pargona_code='00') circle,
		        (SELECT loc_name FROM location WHERE dist_code=s.dist_code AND subdiv_code=s.subdiv_code AND cir_code=s.cir_code AND mouza_pargona_code=s.mouza_pargona_code AND lot_no=s.lot_no
		        AND vill_townprt_code=s.vill_townprt_code) village,
		         CASE              
		                      WHEN (s.service_code = '13') THEN 'SETTLEMENT TENANT'
		                      WHEN (s.service_code = '14') THEN 'SETTLEMENT AP TRANSFER'
		                      WHEN (s.service_code = '15') THEN 'SETTLEMENT TRIBAL COMMUNITY'
		                      WHEN (s.service_code = '16') THEN 'SETTLEMENT KHAS LAND'
		                      WHEN (s.service_code = '17') THEN 'SETTLEMENT PGR VGR LAND'
		                      WHEN (s.service_code = '18') THEN 'SETTLEMENT SPECIAL CULTIVATORS'
		                     END AS service_name, (SELECT pdar_name FROM settlement_applicant WHERE dist_code=s.dist_code AND subdiv_code=s.subdiv_code AND cir_code=s.cir_code AND mouza_pargona_code=s.mouza_pargona_code AND lot_no=s.lot_no
		        AND vill_townprt_code=s.vill_townprt_code and case_no=s.case_no and is_applicant=1) as applicant_name, s.applid AS application_no, s.case_no,sp.grn_no from settlement_basic s

                		join (select distinct on(case_no) case_no,grn_no from settlement_premium where is_final=1) sp
                	
                			on s.case_no =sp.case_no

         				where dist_code = ? and subdiv_code = ? and cir_code = ? $paymentStatusCheck ";


		$district = $this->db->query($q,array($dist_code,$subdiv_code,$cir_code));
		log_message('error','MB:DownloadQuery---'.$this->db->last_query());
		return $district->result();
	}
}
?>