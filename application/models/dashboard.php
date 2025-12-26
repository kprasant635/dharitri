<?php

class dashboard extends CI_Model
{	
	function __construct()
	{
		parent::__construct();
	}

	function allMutation($user,$dist_code,$subdiv_code,$cir_code){
		 $sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='$user' and date_of_reg::date=current_date "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allMutationDC($user,$dist_code){
		 $sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='$user' and date_of_reg=current_date "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}
	
	function allMutationuser_co($user,$dist_code,$subdiv_code,$cir_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='$user' and case_type IN ('OM','FM') and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allMutationuser_dc($dist_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='CO' and case_type IN ('OM','FM') and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allMutationuser_coFM($dist_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='CO' and case_type='FM' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allMutationuser_coOM($dist_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='CO' and case_type='OM' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}


	function allMutationuser_cowiseFM($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='CO' and case_type='FM' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allMutationuser_cowiseOM($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='CO' and case_type='OM' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}



	function allMutationuser_lm($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type IN ('OM','FM') and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allMutationuser_lmdc($dist_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='LM' and case_type IN ('OM','FM') and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allMutationuser_lmFM($dist_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='LM' and case_type='FM' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}



	function allMutationuser_lmwiseFM($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type='FM' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}



	function allMutationuser_lmOM($dist_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='LM' and case_type='OM' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allMutationuser_lmwiseOM($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type='OM' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}


	function allMutationuser_sk($dist_code,$subdiv_code,$cir_code){
		 $sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='SK' and case_type IN ('OM','FM') and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allMutationuser_skFM($dist_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='SK' and case_type='FM' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allMutationuser_skwiseFM($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='SK' and case_type='FM' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allMutationuser_skOM($dist_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='SK' and case_type='OM' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allMutationuser_skwiseOM($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='SK' and case_type='OM' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}


	function allMutationuser_skdc($dist_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='SK' and case_type IN ('OM','FM') and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}
	function allMutationuser_ast($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='AST' and case_type IN ('OM','FM') and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allMutationuser_astdc($dist_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='AST' and case_type IN ('OM','FM') and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allMutationuser_astFM($dist_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='AST' and case_type='FM' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allMutationuser_astwiseFM($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='AST' and case_type='FM' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}


	function allMutationuser_astOM($dist_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='AST' and case_type='OM' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allMutationuser_astwiseOM($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='AST' and case_type='OM' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}





	function allPartitionuser_co($user,$dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='$user' and case_type IN ('OP','FP') and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allPartitionuser_cowiseFP($user,$dist_code,$subdiv_code,$cir_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='$user' and case_type='FP' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allPartitionuser_cowiseOP($user,$dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='$user' and case_type='OP' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}


	function allPartitionuser_dc($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='CO' and case_type IN ('OP','FP') and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allPartitionuser_coFP($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='CO' and case_type='FP' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allPartitionuser_coOP($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='CO' and case_type='OP' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allPartitionuser_lm($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type IN ('OP','FP') and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allPartitionuser_lmwiseFP($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type='FP' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allPartitionuser_lmwiseOP($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type='OP' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allPartitionuser_lmdc($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='LM' and case_type IN ('OP','FP') and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allPartitionuser_lmFP($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='LM' and case_type='FP' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allPartitionuser_lmOP($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='LM' and case_type='OP' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}


	function allPartitionuser_sk($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='SK' and case_type IN ('OP','FP') and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allPartitionuser_skwiseFP($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='SK' and case_type='FP' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allPartitionuser_skwiseOP($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='SK' and case_type='OP' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}


	function allPartitionuser_skdc($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='SK' and case_type IN ('OP','FP') and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allPartitionuser_skFP($dist_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='SK' and case_type='FP' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allPartitionuser_skOP($dist_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='SK' and case_type='OP' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}


	function allPartitionuser_ast($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='AST' and case_type IN ('OP','FP') and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}


	function allPartitionuser_astwiseFP($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='AST' and case_type='FP' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allPartitionuser_astwiseOP($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='AST' and case_type='OP' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allPartitionuser_astdc($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='AST' and case_type IN ('OP','FP') and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allPartitionuser_astFP($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='AST' and case_type='FP' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allPartitionuser_astOP($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='AST' and case_type='OP' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}




	function allConversion_co($user,$dist_code,$subdiv_code,$cir_code){
	$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='$user' and case_type='CV' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allConversion_dc($dist_code){
	$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='CO' and case_type='CV' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allConversion_lm($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type='CV' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allConversion_lmdc($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='LM' and case_type='CV' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allReclass_lmdc($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='LM' and case_type='RC' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allConversion_sk($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='SK' and case_type='CV' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allConversion_skdc($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='SK' and case_type='CV' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allConversion_ast($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='AST' and case_type='CV' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}
	function allConversion_astdc($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='AST' and case_type='CV' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allConversion_adcpen($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='ADC' and case_type='CV' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}


	function allConversion_dcp($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='DC' and case_type='CV' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}



	function allReclass_co($user,$dist_code,$subdiv_code,$cir_code){
	$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='$user' and case_type='RC' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allReclass_district($dist_code){
	$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='CO' and case_type='RC' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allReclass_lm($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type='RC' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	// function allReclass_lmdc($dist_code){
	// 	$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type='RC' and status='P' "; //and status='F'
	// 	return $fm=$this->db->query($sql)->row()->c;
	// }


	function allReclass_sk($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='SK' and case_type='RC' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allReclass_skdc($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='SK' and case_type='RC' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allReclass_ast($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='AST' and case_type='RC' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allReclass_astdc($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='AST' and case_type='RC' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allReclass_adcpending($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='ADC' and case_type='RC' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allReclass_dcp($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='DC' and case_type='RC' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}



	function allReclass_dc($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='DC' and case_type='RC' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}



	function allCitizen_co($user,$dist_code,$subdiv_code,$cir_code){
	$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='$user' and case_type='CR' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allCitizen_codc($dist_code){
	$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='CO' and case_type='CR' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allCitizen_lm($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type='CR' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allCitizen_lmdc($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='LM' and case_type='CR' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}


	function allCitizen_sk($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='SK' and case_type='CR' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allCitizen_skdc($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='SK' and case_type='CR' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allCitizen_ast($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='AST' and case_type='CR' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;

	}

	function allCitizen_astdc($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='AST' and case_type='CR' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;

	}


	function allApcancel_co($user,$dist_code,$subdiv_code,$cir_code){
	$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='$user' and case_type='AP' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allApcancel_codc($dist_code){
	$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='CO' and case_type='AP' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}


	function allApcancel_lm($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type='AP' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allApcancel_lmdc($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='LM' and case_type='AP' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}


	function allApcancel_sk($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='SK' and case_type='AP' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allApcancel_skdc($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='SK' and case_type='AP' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allApcancel_ast($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='AST' and case_type='AP' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;

	}

	function allApcancel_astdc($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='AST' and case_type='AP' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;

	}

	function allApcancel_dcp($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='DC' and case_type='AP' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;

	}

	function allApcancel_adcpen($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='ADC' and case_type='AP' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;

	}




	function allAcpp_co($user,$dist_code,$subdiv_code,$cir_code){
	$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='$user' and case_type='AC' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}


	function allAcpp_codc($dist_code){
	$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='CO' and case_type='AC' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allAcPp_lm($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type='AC' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allAcPp_lmdc($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='LM' and case_type='AC' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allAcPp_sk($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='SK' and case_type='AC' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allAcPp_skdc($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='SK' and case_type='AC' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function allAcPp_ast($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='AST' and case_type='AC' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;

	}
	function allAcPp_astdc($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='AST' and case_type='AC' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;

	}

	function allAcPp_dcp($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='DC' and case_type='AC' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;

	}

	function allAcPp_adcpen($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='ADC' and case_type='AC' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;

	}


	function settle_co($user,$dist_code,$subdiv_code,$cir_code){
	$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='$user' and case_type='SM' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function settle_codc($dist_code){
	$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code'  and pending_with_user='CO' and case_type='SM' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function settle_lm($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type='SM' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function settle_lmdc($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='LM' and case_type='SM' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function settle_sk($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='SK' and case_type='SM' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function settle_skdc($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='SK' and case_type='SM' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function settle_ast($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='AST' and case_type='SM' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;

	}

	function settle_astdc($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code'  and pending_with_user='AST' and case_type='SM' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;

	}



	function misc_co($user,$dist_code,$subdiv_code,$cir_code){
	$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='$user' and case_type='MC' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function misc_codc($dist_code){
	$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='CO' and case_type='MC' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function misc_lm($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type='MC' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function misc_lmdc($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='LM' and case_type='MC' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}


	function misc_sk($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='SK' and case_type='MC' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function misc_skdc($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='SK' and case_type='MC' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}

	function misc_ast($dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='AST' and case_type='MC' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;

	}
	function misc_astdc($dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='AST' and case_type='MC' and status='P' "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;

	}




////////////////

	function allMutationLMwise($user,$dist_code,$subdiv_code,$cir_code,$mouza,$lot){
		 $sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza' and lot_no='$lot' and pending_with_user='$user' and date_of_reg=current_date "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}




///////////////////




	function allMutationCircle($user,$dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and date_of_reg=current_date "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}


	function allMutationDistrict($user,$dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and date_of_reg=current_date "; //and status='F'
		return $fm=$this->db->query($sql)->row()->c;
	}






	function allMutationLM($user,$dist_code,$subdiv_code,$cir_code){

		$sql="select count(distinct(case_no)) as case_no,mouza_pargona_code,lot_no from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type IN ('OM','FM') and status='P'  group by mouza_pargona_code,lot_no order by mouza_pargona_code,lot_no ASC"; 

		

		$data=$this->db->query($sql)->result();
		if(count($data)> 0) {


		foreach ($data as $key => $value) {
			 $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $value->mouza_pargona_code);
		
			$main = array
                    (
                    'case_no' => $value->case_no,
                    'mouza_name' => $mouza_name,
                    'lot_no' => $value->lot_no,
                    
                );

              $result[] = $main;       


		}
		return $result;
	}

	else {
		return false;
	}
	}



	function allMutationCOom($dist_code){

		// $sql="select count(distinct(case_no)) as case_no,mouza_pargona_code,lot_no from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type IN ('OM','FM') and status='P'  group by mouza_pargona_code,lot_no order by mouza_pargona_code,lot_no ASC;"; 

		$sql="select count(distinct(case_no)) as case_no,cir_code,mouza_pargona_code,subdiv_code from dashboard_data where dist_code='$dist_code' and pending_with_user='CO' and case_type='OM' and status='P' group by subdiv_code,cir_code,mouza_pargona_code order by cir_code,mouza_pargona_code ASC";

		

		$data=$this->db->query($sql)->result();

		if(count($data)> 0) {


		foreach ($data as $key => $value) {
			 $cir_name = $this->utilityclass->getCircleName($dist_code, $value->subdiv_code, $value->cir_code);

			 $mouza_name = $this->utilityclass->getMouzaName($dist_code, $value->subdiv_code, $value->cir_code, $value->mouza_pargona_code);
		
			$main = array
                    (
                    'case_no' => $value->case_no,
                    'mouza_name' => $mouza_name,
                    'cir_name' => $cir_name,
                    
                );

              $result[] = $main;       


		}
		return $result;
	}

	else {
		return false;
	}
	}

	function allMutationCOfm($dist_code){

		// $sql="select count(distinct(case_no)) as case_no,mouza_pargona_code,lot_no from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type IN ('OM','FM') and status='P'  group by mouza_pargona_code,lot_no order by mouza_pargona_code,lot_no ASC;"; 

		$sql="select count(distinct(case_no)) as case_no,cir_code,mouza_pargona_code,subdiv_code from dashboard_data where dist_code='$dist_code' and pending_with_user='CO' and case_type='FM' and status='P' group by subdiv_code,cir_code,mouza_pargona_code order by cir_code,mouza_pargona_code ASC";

		

		$data=$this->db->query($sql)->result();

		if(count($data)> 0) {


		foreach ($data as $key => $value) {
			 $cir_name = $this->utilityclass->getCircleName($dist_code, $value->subdiv_code, $value->cir_code);

			 $mouza_name = $this->utilityclass->getMouzaName($dist_code, $value->subdiv_code, $value->cir_code, $value->mouza_pargona_code);
		
			$main = array
                    (
                    'case_no' => $value->case_no,
                    'mouza_name' => $mouza_name,
                    'cir_name' => $cir_name,
                    
                );

              $result[] = $main;       


		}
		return $result;
	}

	else {
		return false;
	}
	}

	function allMutationCOconv($dist_code){

		// $sql="select count(distinct(case_no)) as case_no,mouza_pargona_code,lot_no from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type IN ('OM','FM') and status='P'  group by mouza_pargona_code,lot_no order by mouza_pargona_code,lot_no ASC;"; 

		$sql="select count(distinct(case_no)) as case_no,cir_code,mouza_pargona_code,subdiv_code from dashboard_data where dist_code='$dist_code' and pending_with_user='CO' and case_type='CV' and status='P' group by subdiv_code,cir_code,mouza_pargona_code order by cir_code,mouza_pargona_code ASC";

		

		$data=$this->db->query($sql)->result();

		if(count($data)> 0) {


		foreach ($data as $key => $value) {
			 $cir_name = $this->utilityclass->getCircleName($dist_code, $value->subdiv_code, $value->cir_code);

			 $mouza_name = $this->utilityclass->getMouzaName($dist_code, $value->subdiv_code, $value->cir_code, $value->mouza_pargona_code);
		
			$main = array
                    (
                    'case_no' => $value->case_no,
                    'mouza_name' => $mouza_name,
                    'cir_name' => $cir_name,
                    
                );

              $result[] = $main;       


		}
		return $result;
	}

	else {
		return false;
	}
	}

	function allMutationCOreclass($dist_code){

		// $sql="select count(distinct(case_no)) as case_no,mouza_pargona_code,lot_no from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type IN ('OM','FM') and status='P'  group by mouza_pargona_code,lot_no order by mouza_pargona_code,lot_no ASC;"; 

		$sql="select count(distinct(case_no)) as case_no,cir_code,mouza_pargona_code,subdiv_code from dashboard_data where dist_code='$dist_code' and pending_with_user='CO' and case_type='RC' and status='P' group by subdiv_code,cir_code,mouza_pargona_code order by cir_code,mouza_pargona_code ASC";

		

		$data=$this->db->query($sql)->result();

		if(count($data)> 0) {


		foreach ($data as $key => $value) {
			 $cir_name = $this->utilityclass->getCircleName($dist_code, $value->subdiv_code, $value->cir_code);

			 $mouza_name = $this->utilityclass->getMouzaName($dist_code, $value->subdiv_code, $value->cir_code, $value->mouza_pargona_code);
		
			$main = array
                    (
                    'case_no' => $value->case_no,
                    'mouza_name' => $mouza_name,
                    'cir_name' => $cir_name,
                    
                );

              $result[] = $main;       


		}
		return $result;
	}

	else {
		return false;
	}
	}


	function allMutationCOcert($dist_code){

		// $sql="select count(distinct(case_no)) as case_no,mouza_pargona_code,lot_no from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type IN ('OM','FM') and status='P'  group by mouza_pargona_code,lot_no order by mouza_pargona_code,lot_no ASC;"; 

		$sql="select count(distinct(case_no)) as case_no,cir_code,mouza_pargona_code,subdiv_code from dashboard_data where dist_code='$dist_code' and pending_with_user='CO' and case_type='CR' and status='P' group by subdiv_code,cir_code,mouza_pargona_code order by cir_code,mouza_pargona_code ASC";

		

		$data=$this->db->query($sql)->result();

		if(count($data)> 0) {


		foreach ($data as $key => $value) {
			 $cir_name = $this->utilityclass->getCircleName($dist_code, $value->subdiv_code, $value->cir_code);

			 $mouza_name = $this->utilityclass->getMouzaName($dist_code, $value->subdiv_code, $value->cir_code, $value->mouza_pargona_code);
		
			$main = array
                    (
                    'case_no' => $value->case_no,
                    'mouza_name' => $mouza_name,
                    'cir_name' => $cir_name,
                    
                );

              $result[] = $main;       


		}
		return $result;
	}

	else {
		return false;
	}
	}


	function allMutationCOapcancel($dist_code){

		// $sql="select count(distinct(case_no)) as case_no,mouza_pargona_code,lot_no from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type IN ('OM','FM') and status='P'  group by mouza_pargona_code,lot_no order by mouza_pargona_code,lot_no ASC;"; 

		$sql="select count(distinct(case_no)) as case_no,cir_code,mouza_pargona_code,subdiv_code from dashboard_data where dist_code='$dist_code' and pending_with_user='CO' and case_type='AP' and status='P' group by subdiv_code,cir_code,mouza_pargona_code order by cir_code,mouza_pargona_code ASC";

		

		$data=$this->db->query($sql)->result();

		if(count($data)> 0) {


		foreach ($data as $key => $value) {
			 $cir_name = $this->utilityclass->getCircleName($dist_code, $value->subdiv_code, $value->cir_code);

			 $mouza_name = $this->utilityclass->getMouzaName($dist_code, $value->subdiv_code, $value->cir_code, $value->mouza_pargona_code);
		
			$main = array
                    (
                    'case_no' => $value->case_no,
                    'mouza_name' => $mouza_name,
                    'cir_name' => $cir_name,
                    
                );

              $result[] = $main;       


		}
		return $result;
	}

	else {
		return false;
	}
	}

	function allMutationCOalot($dist_code){

		// $sql="select count(distinct(case_no)) as case_no,mouza_pargona_code,lot_no from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type IN ('OM','FM') and status='P'  group by mouza_pargona_code,lot_no order by mouza_pargona_code,lot_no ASC;"; 

		$sql="select count(distinct(case_no)) as case_no,cir_code,mouza_pargona_code,subdiv_code from dashboard_data where dist_code='$dist_code' and pending_with_user='CO' and case_type='AC' and status='P' group by subdiv_code,cir_code,mouza_pargona_code order by cir_code,mouza_pargona_code ASC";

		

		$data=$this->db->query($sql)->result();

		if(count($data)> 0) {


		foreach ($data as $key => $value) {
			 $cir_name = $this->utilityclass->getCircleName($dist_code, $value->subdiv_code, $value->cir_code);

			 $mouza_name = $this->utilityclass->getMouzaName($dist_code, $value->subdiv_code, $value->cir_code, $value->mouza_pargona_code);
		
			$main = array
                    (
                    'case_no' => $value->case_no,
                    'mouza_name' => $mouza_name,
                    'cir_name' => $cir_name,
                    
                );

              $result[] = $main;       


		}
		return $result;
	}

	else {
		return false;
	}
	}

	function allMutationCOsettle($dist_code){

		// $sql="select count(distinct(case_no)) as case_no,mouza_pargona_code,lot_no from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type IN ('OM','FM') and status='P'  group by mouza_pargona_code,lot_no order by mouza_pargona_code,lot_no ASC;"; 

		$sql="select count(distinct(case_no)) as case_no,cir_code,mouza_pargona_code,subdiv_code from dashboard_data where dist_code='$dist_code' and pending_with_user='CO' and case_type='SM' and status='P' group by subdiv_code,cir_code,mouza_pargona_code order by cir_code,mouza_pargona_code ASC";

		

		$data=$this->db->query($sql)->result();

		if(count($data)> 0) {


		foreach ($data as $key => $value) {
			 $cir_name = $this->utilityclass->getCircleName($dist_code, $value->subdiv_code, $value->cir_code);

			 $mouza_name = $this->utilityclass->getMouzaName($dist_code, $value->subdiv_code, $value->cir_code, $value->mouza_pargona_code);
		
			$main = array
                    (
                    'case_no' => $value->case_no,
                    'mouza_name' => $mouza_name,
                    'cir_name' => $cir_name,
                    
                );

              $result[] = $main;       


		}
		return $result;
	}

	else {
		return false;
	}
	}

	function allMutationCOmisc($dist_code){

		// $sql="select count(distinct(case_no)) as case_no,mouza_pargona_code,lot_no from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type IN ('OM','FM') and status='P'  group by mouza_pargona_code,lot_no order by mouza_pargona_code,lot_no ASC;"; 

		$sql="select count(distinct(case_no)) as case_no,cir_code,mouza_pargona_code,subdiv_code from dashboard_data where dist_code='$dist_code' and pending_with_user='CO' and case_type='MC' and status='P' group by subdiv_code,cir_code,mouza_pargona_code order by cir_code,mouza_pargona_code ASC";

		

		$data=$this->db->query($sql)->result();

		if(count($data)> 0) {


		foreach ($data as $key => $value) {
			 $cir_name = $this->utilityclass->getCircleName($dist_code, $value->subdiv_code, $value->cir_code);

			 $mouza_name = $this->utilityclass->getMouzaName($dist_code, $value->subdiv_code, $value->cir_code, $value->mouza_pargona_code);
		
			$main = array
                    (
                    'case_no' => $value->case_no,
                    'mouza_name' => $mouza_name,
                    'cir_name' => $cir_name,
                    
                );

              $result[] = $main;       


		}
		return $result;
	}

	else {
		return false;
	}
	}



	function allMutationCOfp($dist_code){

		// $sql="select count(distinct(case_no)) as case_no,mouza_pargona_code,lot_no from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type IN ('OM','FM') and status='P'  group by mouza_pargona_code,lot_no order by mouza_pargona_code,lot_no ASC;"; 

		$sql="select count(distinct(case_no)) as case_no,cir_code,mouza_pargona_code,subdiv_code from dashboard_data where dist_code='$dist_code' and pending_with_user='CO' and case_type='FP' and status='P' group by subdiv_code,cir_code,mouza_pargona_code order by cir_code,mouza_pargona_code ASC";

		

		$data=$this->db->query($sql)->result();

		if(count($data)> 0) {


		foreach ($data as $key => $value) {
			 $cir_name = $this->utilityclass->getCircleName($dist_code, $value->subdiv_code, $value->cir_code);

			 $mouza_name = $this->utilityclass->getMouzaName($dist_code, $value->subdiv_code, $value->cir_code, $value->mouza_pargona_code);
		
			$main = array
                    (
                    'case_no' => $value->case_no,
                    'mouza_name' => $mouza_name,
                    'cir_name' => $cir_name,
                    
                );

              $result[] = $main;       


		}
		return $result;
	}

	else {
		return false;
	}
	}

	function allMutationCOop($dist_code){

		// $sql="select count(distinct(case_no)) as case_no,mouza_pargona_code,lot_no from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type IN ('OM','FM') and status='P'  group by mouza_pargona_code,lot_no order by mouza_pargona_code,lot_no ASC;"; 

		$sql="select count(distinct(case_no)) as case_no,cir_code,mouza_pargona_code,subdiv_code from dashboard_data where dist_code='$dist_code' and pending_with_user='CO' and case_type='OP' and status='P' group by subdiv_code,cir_code,mouza_pargona_code order by cir_code,mouza_pargona_code ASC";

		

		$data=$this->db->query($sql)->result();

		if(count($data)> 0) {


		foreach ($data as $key => $value) {
			 $cir_name = $this->utilityclass->getCircleName($dist_code, $value->subdiv_code, $value->cir_code);

			 $mouza_name = $this->utilityclass->getMouzaName($dist_code, $value->subdiv_code, $value->cir_code, $value->mouza_pargona_code);
		
			$main = array
                    (
                    'case_no' => $value->case_no,
                    'mouza_name' => $mouza_name,
                    'cir_name' => $cir_name,
                    
                );

              $result[] = $main;       


		}
		return $result;
	}

	else {
		return false;
	}
	}


	function allPartitionLM($user,$dist_code,$subdiv_code,$cir_code){

		$sql="select count(distinct(case_no)) as case_no,mouza_pargona_code,lot_no from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type IN ('OP','FP') and status='P'  group by mouza_pargona_code,lot_no order by mouza_pargona_code,lot_no ASC"; 

		

		$data=$this->db->query($sql)->result();

		if(count($data)> 0) {


		foreach ($data as $key => $value) {
			 $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $value->mouza_pargona_code);
		
			$main = array
                    (
                    'case_no' => $value->case_no,
                    'mouza_name' => $mouza_name,
                    'lot_no' => $value->lot_no,
                    
                );

              $result[] = $main;       


		}
		return $result;
	}

	else {
		return false;
	}
	}


	function allCitizenLM($user,$dist_code,$subdiv_code,$cir_code){

		$sql="select count(case_no) as case_no,mouza_pargona_code,lot_no from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type='CR' and status='P'  group by mouza_pargona_code,lot_no order by mouza_pargona_code,lot_no ASC"; 

		

		$data=$this->db->query($sql)->result();
		if(count($data)> 0) {

		foreach ($data as $key => $value) {
			 $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $value->mouza_pargona_code);
		
			$main = array
                    (
                    'case_no' => $value->case_no,
                    'mouza_name' => $mouza_name,
                    'lot_no' => $value->lot_no,
                    
                );

              $result[] = $main;       


		}
		return $result;
	}

	else {
		return false;
	}
	}


	function allApcancelLM($user,$dist_code,$subdiv_code,$cir_code){

		$sql="select count(case_no) as case_no,mouza_pargona_code,lot_no from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type='AP' and status='P'  group by mouza_pargona_code,lot_no order by mouza_pargona_code,lot_no ASC"; 

		

		$data=$this->db->query($sql)->result();
		if(count($data)> 0) {

		foreach ($data as $key => $value) {
			 $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $value->mouza_pargona_code);
		
			$main = array
                    (
                    'case_no' => $value->case_no,
                    'mouza_name' => $mouza_name,
                    'lot_no' => $value->lot_no,
                    
                );

              $result[] = $main;       


		}
		return $result;
	}

	else {
		return false;
	}
	}


	function allAcppLM($user,$dist_code,$subdiv_code,$cir_code){

		$sql="select count(case_no) as case_no,mouza_pargona_code,lot_no from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type='AC' and status='P'  group by mouza_pargona_code,lot_no order by mouza_pargona_code,lot_no ASC"; 

		

		$data=$this->db->query($sql)->result();

		if(count($data)> 0) {

		foreach ($data as $key => $value) {
			 $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $value->mouza_pargona_code);
		
			$main = array
                    (
                    'case_no' => $value->case_no,
                    'mouza_name' => $mouza_name,
                    'lot_no' => $value->lot_no,
                    
                );

              $result[] = $main;       


		}
		return $result;
	}

	else {
		return false;
	}

	}


function allSettleLM($user,$dist_code,$subdiv_code,$cir_code){

		$sql="select count(case_no) as case_no,mouza_pargona_code,lot_no from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type='SM' and status='P'  group by mouza_pargona_code,lot_no order by mouza_pargona_code,lot_no ASC"; 

		

		$data=$this->db->query($sql)->result();
		if(count($data)> 0) {

		foreach ($data as $key => $value) {
			 $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $value->mouza_pargona_code);
		
			$main = array
                    (
                    'case_no' => $value->case_no,
                    'mouza_name' => $mouza_name,
                    'lot_no' => $value->lot_no,
                    
                );

              $result[] = $main;       


		}
		return $result;
	}

	else {
		return false;
	}
}


function allMiscLM($user,$dist_code,$subdiv_code,$cir_code){

		$sql="select count(case_no) as case_no,mouza_pargona_code,lot_no from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type='MC' and status='P'  group by mouza_pargona_code,lot_no order by mouza_pargona_code,lot_no ASC"; 

		

		$data=$this->db->query($sql)->result();

		if(count($data)> 0) {

		foreach ($data as $key => $value) {
			 $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $value->mouza_pargona_code);
		
			$main = array
                    (
                    'case_no' => $value->case_no,
                    'mouza_name' => $mouza_name,
                    'lot_no' => $value->lot_no,
                    
                );

              $result[] = $main;       


		}
		return $result;
	}

	else {
		return false;
	}

		
	}


function allConvLM($user,$dist_code,$subdiv_code,$cir_code){

		$sql="select count(case_no) as case_no,mouza_pargona_code,lot_no from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type='CV' and status='P'  group by mouza_pargona_code,lot_no order by mouza_pargona_code,lot_no ASC"; 

		

		$data=$this->db->query($sql)->result();



		if(count($data)> 0) {


		foreach ($data as $key => $value) {
			 $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $value->mouza_pargona_code);
		
			$main = array
                    (
                    'case_no' => $value->case_no,
                    'mouza_name' => $mouza_name,
                    'lot_no' => $value->lot_no,
                    
                );

              $result[] = $main;       


		

		}
		return $result;
	}

	else {
		return false;
	}
	}


	function allReclassLM($user,$dist_code,$subdiv_code,$cir_code){

		$sql="select count(case_no) as case_no,mouza_pargona_code,lot_no from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='LM' and case_type='RC' and status='P'  group by mouza_pargona_code,lot_no order by mouza_pargona_code,lot_no ASC"; 

		

		$data=$this->db->query($sql)->result();



		if(count($data)> 0) {


		foreach ($data as $key => $value) {
			 $mouza_name = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $value->mouza_pargona_code);
		
			$main = array
                    (
                    'case_no' => $value->case_no,
                    'mouza_name' => $mouza_name,
                    'lot_no' => $value->lot_no,
                    
                );

              $result[] = $main;       


		

		}
		return $result;
	}

	else {
		return false;
	}
	}


function applTime($user,$dist_code,$subdiv_code,$cir_code){

		$sql="select Min(DATE_PART('day', final_order_date-date_of_reg)) as min, max(DATE_PART('day', final_order_date-date_of_reg)) as max, avg(DATE_PART('day', final_order_date-date_of_reg)) as avg from dashboard_data where status='F' and case_type='FM'"; 
		$data=$this->db->query($sql)->row();
		$main = array
                    (
                    'min' => $data->min,
                    'max' => $data->max,
                    'avg' => $data->avg,
                    'type'=>'Field Mutation'
                );
        $result[] = $main;
        $sql="select Min(DATE_PART('day', final_order_date-date_of_reg)) as min, max(DATE_PART('day', final_order_date-date_of_reg)) as max, avg(DATE_PART('day', final_order_date-date_of_reg)) as avg from dashboard_data where status='F' and case_type='FP'"; 
		$data=$this->db->query($sql)->row();
		$main = array
                    (
                    'min' => $data->min,
                    'max' => $data->max,
                    'avg' => $data->avg,
                    'type'=>'Field Partition'
                );
        $result[] = $main; 
        $sql="select Min(DATE_PART('day', final_order_date-date_of_reg)) as min, max(DATE_PART('day', final_order_date-date_of_reg)) as max, avg(DATE_PART('day', final_order_date-date_of_reg)) as avg from dashboard_data where status='F' and case_type='OM'"; 
		$data=$this->db->query($sql)->row();
		$main = array
                    (
                    'min' => $data->min,
                    'max' => $data->max,
                    'avg' => $data->avg,
                    'type'=>'Office Mutation'
                );
        $result[] = $main;   

  //       $sql="select Min(DATE_PART('day', final_order_date-date_of_reg)) as min, max(DATE_PART('day', final_order_date-date_of_reg)) as max, avg(DATE_PART('day', final_order_date-date_of_reg)) as avg from dashboard_data where status='F' and case_type='CR'"; 
		// $data=$this->db->query($sql)->row();
		// $main = array
  //                   (
  //                   'min' => $data->min,
  //                   'max' => $data->max,
  //                   'avg' => $data->avg,
  //                   'type'=>'Certificate'
  //               );
  //       $result[] = $main;    


         $sql="select Min(DATE_PART('day', final_order_date-date_of_reg)) as min, max(DATE_PART('day', final_order_date-date_of_reg)) as max, avg(DATE_PART('day', final_order_date-date_of_reg)) as avg from dashboard_data where status='F' and case_type='CV'"; 
		$data=$this->db->query($sql)->row();
		$main = array
                    (
                    'min' => $data->min,
                    'max' => $data->max,
                    'avg' => $data->avg,
                    'type'=>'Conversion'
                );
        $result[] = $main; 

        $sql="select Min(DATE_PART('day', final_order_date-date_of_reg)) as min, max(DATE_PART('day', final_order_date-date_of_reg)) as max, avg(DATE_PART('day', final_order_date-date_of_reg)) as avg from dashboard_data where status='F' and case_type='RC'"; 
		$data=$this->db->query($sql)->row();
		$main = array
                    (
                    'min' => $data->min,
                    'max' => $data->max,
                    'avg' => $data->avg,
                    'type'=>'Reclassification'
                );
        $result[] = $main;  

        $sql="select Min(DATE_PART('day', final_order_date-date_of_reg)) as min, max(DATE_PART('day', final_order_date-date_of_reg)) as max, avg(DATE_PART('day', final_order_date-date_of_reg)) as avg from dashboard_data where status='F' and case_type='AP'"; 
		$data=$this->db->query($sql)->row();
		$main = array
                    (
                    'min' => $data->min,
                    'max' => $data->max,
                    'avg' => $data->avg,
                    'type'=>'AP Cancellation'
                );
        $result[] = $main;  

        $sql="select Min(DATE_PART('day', final_order_date-date_of_reg)) as min, max(DATE_PART('day', final_order_date-date_of_reg)) as max, avg(DATE_PART('day', final_order_date-date_of_reg)) as avg from dashboard_data where status='F' and case_type='SM'"; 
		$data=$this->db->query($sql)->row();
		$main = array
                    (
                    'min' => $data->min,
                    'max' => $data->max,
                    'avg' => $data->avg,
                    'type'=>'Settlement'
                );
        $result[] = $main;  

		return $result;
	}





	function allOffice(){
		$sql="Select count(*) as c from dashboard_data where (case_type!='FM' and case_type!='FP') ";
		return $fm=$this->db->query($sql)->row()->c;
	}


	function ofcMutation($user,$dist_code,$subdiv_code,$cir_code){
		 $sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='$user' and case_type='OM' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function ofcMutationLMwise($user,$dist_code,$subdiv_code,$cir_code,$mouza,$lot){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza' and lot_no='$lot' and pending_with_user='$user' and case_type='OM' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function ofcMutationCircle($user,$dist_code,$subdiv_code,$cir_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and case_type='OM' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function ofcMutationDistrict($user,$dist_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and case_type='OM' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	
	function delMutation($user,$dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and (status='F' or status='D') ";
		return $fm=$this->db->query($sql)->row()->c;
	}

	function delMutationDC($user,$dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='$user' and (status='F' or status='D') ";
		return $fm=$this->db->query($sql)->row()->c;
	}

	function delMutationCircle($user,$dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (status='F' or status='D') ";
		return $fm=$this->db->query($sql)->row()->c;
	}

	function delMutationDistrict($user,$dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and (status='F' or status='D') ";
		return $fm=$this->db->query($sql)->row()->c;
	}



	function delOffice(){
		$sql="Select count(*) as c from dashboard_data where (case_type!='FM' and case_type!='FP') and status='F' ";
		return $fm=$this->db->query($sql)->row()->c;
	}
	///////////////////////////////////////////////
	function penMutation($user,$dist_code,$subdiv_code,$cir_code){
		$sql="Select distinct(count(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='$user' and status='P' ";
		return $fm=$this->db->query($sql)->row()->c;
	}

	function penMutationDC($user,$dist_code){
		$sql="Select distinct(count(case_no)) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='$user' and status='P' ";
		return $fm=$this->db->query($sql)->row()->c;
	}

	function penMutationLMwise($user,$dist_code,$subdiv_code,$cir_code,$mouza,$lot){
		$sql="Select distinct(count(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza' and lot_no='$lot' and pending_with_user='$user' and status='P' ";
		return $fm=$this->db->query($sql)->row()->c;
	}

	function penMutationCircle($user,$dist_code,$subdiv_code,$cir_code){
		 $sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='P' ";
		return $fm=$this->db->query($sql)->row()->c;
	}

	function penMutationDistrict($user,$dist_code){
		 $sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and status='P' ";
		return $fm=$this->db->query($sql)->row()->c;
	}




	function penOffice(){
		$sql="Select count(*) as c from dashboard_data where (case_type!='FM' and case_type!='FP') and status='P' ";
		return $fm=$this->db->query($sql)->row()->c;
	}
	///////////////////////////////////////////////////
	function fieldMutation($user,$dist_code,$subdiv_code,$cir_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='$user' and case_type='FM' and status='P' ";
		return $fm=$this->db->query($sql)->row()->c;
	}

	function fieldMutationLMwise($user,$dist_code,$subdiv_code,$cir_code,$mouza,$lot){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza' and lot_no='$lot' and pending_with_user='$user' and case_type='FM' and status='P' ";
		return $fm=$this->db->query($sql)->row()->c;
	}

	function fieldMutationCircle($user,$dist_code,$subdiv_code,$cir_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and case_type='FM' and status='P' ";
		return $fm=$this->db->query($sql)->row()->c;
	}

	function fieldMutationDistrict($user,$dist_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and case_type='FM' and status='P' ";
		return $fm=$this->db->query($sql)->row()->c;
	}



	function fieldPartition($user,$dist_code,$subdiv_code,$cir_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='$user' and case_type='FP' and status='P' ";
		return $fm=$this->db->query($sql)->row()->c;
	}

	function fieldPartitionLMwise($user,$dist_code,$subdiv_code,$cir_code,$mouza,$lot){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza' and lot_no='$lot' and pending_with_user='$user' and case_type='FP' and status='P' ";
		return $fm=$this->db->query($sql)->row()->c;
	}

	function fieldPartitionCircle($user,$dist_code,$subdiv_code,$cir_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and case_type='FP' and status='P' ";
		return $fm=$this->db->query($sql)->row()->c;
	}

	function fieldPartitionDistrict($user,$dist_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and case_type='FP' and status='P' ";
		return $fm=$this->db->query($sql)->row()->c;
	}


	
	function ofcPartition($user,$dist_code,$subdiv_code,$cir_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='$user' and case_type='OP' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function ofcPartitionLMwise($user,$dist_code,$subdiv_code,$cir_code,$mouza,$lot){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza' and lot_no='$lot' and pending_with_user='$user' and case_type='OP' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}


	function ofcPartitionCircle($user,$dist_code,$subdiv_code,$cir_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and case_type='OP' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function ofcPartitionDistrict($user,$dist_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and case_type='OP' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}


	function certificate($user,$dist_code,$subdiv_code,$cir_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='$user' and case_type='CR' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function certificateLMwise($user,$dist_code,$subdiv_code,$cir_code,$mouza,$lot){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza' and lot_no='$lot' and pending_with_user='$user' and case_type='CR' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function certificateCircle($user,$dist_code,$subdiv_code,$cir_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and case_type='CR' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function certificateDistrict($user,$dist_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and case_type='CR' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}



	
	function alotCertificate($user,$dist_code,$subdiv_code,$cir_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='$user' and case_type='AC' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function alotCertificateDC($user,$dist_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='$user' and case_type='AC' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function alotCertificateLMwise($user,$dist_code,$subdiv_code,$cir_code,$mouza,$lot){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza' and lot_no='$lot' and pending_with_user='$user' and case_type='AC' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function alotCertificateCircle($user,$dist_code,$subdiv_code,$cir_code){
		 $sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and case_type='AC' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function alotCertificateDistrict($user,$dist_code){
		 $sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and case_type='AC' and status='P' and pending_with_user!='DC' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function alotCertificateDistrictDC($user,$dist_code){
		 $sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and case_type='AC' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}






	function apcases($user,$dist_code,$subdiv_code,$cir_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='$user' and case_type='AP' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function apcasesDC($user,$dist_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='$user' and case_type='AP' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function apcasesLMwise($user,$dist_code,$subdiv_code,$cir_code,$mouza,$lot){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza' and lot_no='$lot' and pending_with_user='$user' and case_type='AP' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function apcasesCircle($user,$dist_code,$subdiv_code,$cir_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and case_type='AP' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function apcasesDistrict($user,$dist_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and case_type='AP' and status='P' and pending_with_user!='DC'  ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function apcasesDistrictDC($user,$dist_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and case_type='AP' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}




	function misccases($user,$dist_code,$subdiv_code,$cir_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='$user' and case_type='MC' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function misccasesLMwise($user,$dist_code,$subdiv_code,$cir_code,$mouza,$lot){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza' and lot_no='$lot' and pending_with_user='$user' and case_type='MC' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function misccasesCircle($user,$dist_code,$subdiv_code,$cir_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and case_type='MC' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function misccasesDistrict($user,$dist_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and case_type='MC' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}
	///////////////////////
	

	function conversion($user,$dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='$user' and case_type='CV' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function conversionDC($user,$dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='$user' and case_type='CV' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function conversionLMwise($user,$dist_code,$subdiv_code,$cir_code,$mouza,$lot){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and mouza_pargona_code='$mouza' and lot_no='$lot' and pending_with_user='$user' and case_type='CV' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function conversionCircle($user,$dist_code,$subdiv_code,$cir_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and case_type='CV' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function conversionDistrict($user,$dist_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and case_type='CV' and status='P' and pending_with_user!='DC' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function conversionDistrictDC($user,$dist_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and case_type='CV' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}



	function reclassification($user,$dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='$user' and case_type='RC' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function reclassificationDC($user,$dist_code){
		 $sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and pending_with_user='$user' and case_type='RC' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function reclassificationLMwise($user,$dist_code,$subdiv_code,$cir_code,$mouza,$lot){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and mouza_pargona_code='$mouza' and lot_no='$lot' and pending_with_user='$user' and case_type='RC' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function reclassificationCircle($user,$dist_code,$subdiv_code,$cir_code){
		$sql="Select count(distinct(case_no)) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and case_type='RC' and status='P' and (pending_with_user!='DC' and pending_with_user!='ADC') ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function reclassificationDistrict($user,$dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and case_type='RC' and status='P' and pending_with_user!='DC' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function reclassificationDistrictDC($user,$dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and case_type='RC' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}



	function settlement($user,$dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_with_user='$user' and case_type='SM' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function settlementLMwise($user,$dist_code,$subdiv_code,$cir_code,$mouza,$lot){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza' and lot_no='$lot' and pending_with_user='$user' and case_type='SM' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function settlementCircle($user,$dist_code,$subdiv_code,$cir_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and case_type='SM' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	function settlementDistrict($user,$dist_code){
		$sql="Select count(*) as c from dashboard_data where dist_code='$dist_code' and case_type='SM' and status='P' ";
		return $om=$this->db->query($sql)->row()->c;
	}

	///////////////////////////////////
	///////////////////////////////////////////////////
	function fieldMutationC(){
		$sql="Select count(*) as c from dashboard_data where case_type='FM' and status='F' ";
		return $fm=$this->db->query($sql)->row()->c;
	}
	function fieldPartitionC(){
		$sql="Select count(*) as c from dashboard_data where case_type='FP' and status='F' ";
		return $fm=$this->db->query($sql)->row()->c;
	}
	function ofcMutationC(){
		$sql="Select count(*) as c from dashboard_data where case_type='OM' and status='F' ";
		return $om=$this->db->query($sql)->row()->c;
	}
	function ofcPartitionC(){
		$sql="Select count(*) as c from dashboard_data where case_type='OP' and status='F' ";
		return $om=$this->db->query($sql)->row()->c;
	}
	function certificateC(){
		$sql="Select count(*) as c from dashboard_data where case_type='CR' and status='F' ";
		return $om=$this->db->query($sql)->row()->c;
	}
	function alotCertificateC(){
		$sql="Select count(*) as c from dashboard_data where case_type='AC' and status='F' ";
		return $om=$this->db->query($sql)->row()->c;
	}
	function apcasesC(){
		$sql="Select count(*) as c from dashboard_data where case_type='AP' and status='F' ";
		return $om=$this->db->query($sql)->row()->c;
	}
	function misccasesC(){
		$sql="Select count(*) as c from dashboard_data where case_type='MC' and status='F' ";
		return $om=$this->db->query($sql)->row()->c;
	}
	///////////////////////
	function conversionC(){
		$sql="Select count(*) as c from dashboard_data where case_type='CV' and status='F' ";
		return $om=$this->db->query($sql)->row()->c;
	}
	function reclassificationC(){
		$sql="Select count(*) as c from dashboard_data where case_type='RC' and status='F' ";
		return $om=$this->db->query($sql)->row()->c;
	}
	function settlementC(){
		$sql="Select count(*) as c from dashboard_data where case_type='SM' and status='F' ";
		return $om=$this->db->query($sql)->row()->c;
	}
	//////////////////////////////////
	function fieldMutationR(){
		$sql="Select count(*) as c from dashboard_data where case_type='FM' ";
		return $fm=$this->db->query($sql)->row()->c;
	}
	function fieldPartitionR(){
		$sql="Select count(*) as c from dashboard_data where case_type='FP' ";
		return $fm=$this->db->query($sql)->row()->c;
	}
	function ofcMutationR(){
		$sql="Select count(*) as c from dashboard_data where case_type='OM'  ";
		return $om=$this->db->query($sql)->row()->c;
	}
	function ofcPartitionR(){
		$sql="Select count(*) as c from dashboard_data where case_type='OP'  ";
		return $om=$this->db->query($sql)->row()->c;
	}
	function certificateR(){
		$sql="Select count(*) as c from dashboard_data where case_type='CR' ";
		return $om=$this->db->query($sql)->row()->c;
	}
	function alotCertificateR(){
		$sql="Select count(*) as c from dashboard_data where case_type='AC' ";
		return $om=$this->db->query($sql)->row()->c;
	}
	function apcasesR(){
		$sql="Select count(*) as c from dashboard_data where case_type='AP' ";
		return $om=$this->db->query($sql)->row()->c;
	}
	function misccasesR(){
		$sql="Select count(*) as c from dashboard_data where case_type='MC' ";
		return $om=$this->db->query($sql)->row()->c;
	}
	///////////////////////
	function conversionR(){
		$sql="Select count(*) as c from dashboard_data where case_type='CV' ";
		return $om=$this->db->query($sql)->row()->c;
	}
	function reclassificationR(){
		$sql="Select count(*) as c from dashboard_data where case_type='RC' ";
		return $om=$this->db->query($sql)->row()->c;
	}
	function settlementR(){
		$sql="Select count(*) as c from dashboard_data where case_type='SM' ";
		return $om=$this->db->query($sql)->row()->c;
	}
	//////////////////////////////////
	function secMutation(){
		$twoMonths=$sixMonths=$sixMonthsGrt=$oneYear=0;
		$params= $this->switchProcess();
		$distList="select dist_code,locname_eng from location where dist_code!='00' and subdiv_code='00' ";
		$list=$this->db->query($distList)->result_array();
		foreach ($list as $key => $val) {
		$twoMonths=$sixMonths=$sixMonthsGrt=$oneYear=0;
		$sql="Select date_of_reg,dist_code  from dashboard_data where ($params)  and dist_code='$val[dist_code]' and status='P' ";
		$result=$this->db->query($sql)->result_array();
		foreach ($result as $key => $value) {

				$firstDate=new DateTime();
				$secondDate = new DateTime($value['date_of_reg']);
				$intvl = $firstDate->diff($secondDate);
				//var_dump($intvl);
				//echo $intvl->days ."days<br>";
				if($intvl->days >= 30 and $intvl->days < 90){
					$twoMonths=$twoMonths+1;
					//break;
				}elseif($intvl->days >= 90 and $intvl->days < 180){
					$sixMonths=$sixMonths+1;
					//break;
				}elseif($intvl->days >= 180 and $intvl->days < 365){
					$sixMonthsGrt=$sixMonthsGrt+1;
					//break;
				}elseif($intvl->days >= 365){
					 $oneYear=$oneYear+1;
					 //break;
				}
			}
			$pending[] = array(
			'dist_code' => $val['dist_code'],
			'name' => $val['locname_eng'],
			'twoMonths'=>$twoMonths,
			'sixMonths'=>$sixMonths,
			'sixMonthsGrt'=>$sixMonthsGrt,
			'oneYear'=>$oneYear
			 );
		
		}
		return $pending;
		
		//echo $twoMonths . "-" . $sixMonths . "-" . $sixMonthsGrt . "-" . $oneYear;
	}
	function secMutationReg(){
		$params= $this->switchProcess();
		$distList="select dist_code,locname_eng from location where dist_code!='00' and subdiv_code='00' ";
		$list=$this->db->query($distList)->result_array();
		foreach ($list as $key => $val) {
			/////////For Current Month/////////////
			$sql="Select count(*) as curmonth from dashboard_data where ($params) and dist_code='$val[dist_code]' and date_of_reg >  CURRENT_DATE - INTERVAL '1 months' ";
			$curmonth=$this->db->query($sql)->row()->curmonth;
			/////////For Previous Month/////////////
			$sql="Select count(*) as premonth from dashboard_data where ($params) and  dist_code='$val[dist_code]' and date_of_reg >= date_trunc('month', current_date - interval '1' month)
  and date_of_reg < date_trunc('month', current_date) ";
			$premonth=$this->db->query($sql)->row()->premonth;
			/////////For total/////////////
			$sql="Select count(*) as total from dashboard_data where ($params) and  dist_code='$val[dist_code]'  ";
			$total=$this->db->query($sql)->row()->total;
			//////////
			$pending[] = array(
				'dist_code' => $val['dist_code'],
				'name' => $val['locname_eng'],
				'curmonth'=>$curmonth,
				'premonth'=>$premonth,
				'total'=>$total
			 );
		}
		return $pending;
	}
	function secMutationDev(){
		$params= $this->switchProcess();
		$distList="select dist_code,locname_eng from location where dist_code!='00' and subdiv_code='00' ";
		$list=$this->db->query($distList)->result_array();
		foreach ($list as $key => $val) {
			/////////For Current Month/////////////
			$sql="Select count(*) as curmonth from dashboard_data where ($params) and dist_code='$val[dist_code]' and date_of_reg >  CURRENT_DATE - INTERVAL '1 months' and (status='F' or status='D') ";
			$curmonth=$this->db->query($sql)->row()->curmonth;
			/////////For Previous Month/////////////
			$sql="Select count(*) as premonth from dashboard_data where ($params) and  dist_code='$val[dist_code]' and date_of_reg >= date_trunc('month', current_date - interval '1' month)
  and date_of_reg < date_trunc('month', current_date) and (status='F' or status='D') ";
			$premonth=$this->db->query($sql)->row()->premonth;
			/////////For total/////////////
			$sql="Select count(*) as total from dashboard_data where ($params) and  dist_code='$val[dist_code]' and (status='F' or status='D')  ";
			$total=$this->db->query($sql)->row()->total;
			//////////
			$pending[] = array(
				'dist_code' => $val['dist_code'],
				'name' => $val['locname_eng'],
				'curmonth'=>$curmonth,
				'premonth'=>$premonth,
				'total'=>$total
			 );
		}
		return $pending;
	}
	function thirdMutation($dist){
		$params= $this->switchProcess();
		$circleList="select subdiv_code,cir_code,locname_eng from location where cir_code!='00' and mouza_pargona_code='00' and dist_code='$dist' ";
		$list=$this->db->query($circleList)->result_array();
		foreach ($list as $key => $val) {
			$twoMonths=$sixMonths=$sixMonthsGrt=$oneYear=0;
			$sql="Select date_of_reg,dist_code,cir_code  from dashboard_data where ($params) and dist_code='$dist' and subdiv_code='$val[subdiv_code]' and cir_code='$val[cir_code]' and (pending_with_user='CO' or pending_with_user='AST' or pending_with_user='SK') and status='P' ";
		
			$result=$this->db->query($sql)->result_array();
			foreach ($result as $key => $value) {
				$firstDate=new DateTime();
				$secondDate = new DateTime($value['date_of_reg']);
				$intvl = $firstDate->diff($secondDate);
				//var_dump($intvl->days);
				if($intvl->days >= 30 and $intvl->days < 90){
					$twoMonths=$twoMonths+1;
					//break;;
				}elseif($intvl->days >= 90 and $intvl->days < 180){
					$sixMonths=$sixMonths+1;
					//break;;
				}elseif($intvl->days >= 180 and $intvl->days < 365){
					$sixMonthsGrt=$sixMonthsGrt+1;
					//break;;
				}elseif($intvl->days >= 365){
					 $oneYear=$oneYear+1;
					 //break;;
				}
			}
			$pending[] = array(
			'dist_code'=>$dist,
			'subdiv_code'=>$val['subdiv_code'],
			'cir_code'=>$val['cir_code'],
			'circle' => $val['locname_eng'],
			'twoMonths'=>$twoMonths,
			'sixMonths'=>$sixMonths,
			'sixMonthsGrt'=>$sixMonthsGrt,
			'oneYear'=>$oneYear
			 );
		}
		return $pending;
		//echo $twoMonths . "-" . $sixMonths . "-" . $sixMonthsGrt . "-" . $oneYear;
	}
	function fourthMutation($d,$s,$c){
		$params= $this->switchProcess();
		$circleList="select subdiv_code,cir_code,mouza_pargona_code, locname_eng from location where cir_code='$c' and mouza_pargona_code!='00' and lot_no='00' and dist_code='$d' and subdiv_code='$s' ";
		$list=$this->db->query($circleList)->result_array();
		foreach ($list as $key => $val) {
			$twoMonths=$sixMonths=$sixMonthsGrt=$oneYear=0;
			$sql="Select date_of_reg  from dashboard_data where ($params) and dist_code='$d' and subdiv_code='$val[subdiv_code]' and cir_code='$val[cir_code]' and mouza_pargona_code='$val[mouza_pargona_code]' and pending_with_user='LM' and status='P' ";
			$result=$this->db->query($sql)->result_array();
			foreach ($result as $key => $value) {
				$firstDate=new DateTime();
				$secondDate = new DateTime($value['date_of_reg']);
				$intvl = $firstDate->diff($secondDate);
				//var_dump($intvl);
				if($intvl->days >= 30 and $intvl->days < 90){
					$twoMonths=$twoMonths+1;
					//break;;
				}elseif($intvl->days >= 90 and $intvl->days < 180){
					$sixMonths=$sixMonths+1;
					//break;;
				}elseif($intvl->days >= 180 and $intvl->days < 365){
					$sixMonthsGrt=$sixMonthsGrt+1;
					//break;;
				}elseif($intvl->days >= 365){
					 $oneYear=$oneYear+1;
					 //break;;
				}
			}
			$pending[] = array(
			'dist_code'=>$d,
			'subdiv_code'=>$val['subdiv_code'],
			'cir_code'=>$val['cir_code'],
			'mouza_pargona_code'=>$val['mouza_pargona_code'],
			'name' => $val['locname_eng'],
			'twoMonths'=>$twoMonths,
			'sixMonths'=>$sixMonths,
			'sixMonthsGrt'=>$sixMonthsGrt,
			'oneYear'=>$oneYear
			 );
		}
		return $pending;
		//echo $twoMonths . "-" . $sixMonths . "-" . $sixMonthsGrt . "-" . $oneYear;
	}
	function thirdMutationReg($dist){
		$params= $this->switchProcess();
		$circleList="select subdiv_code,cir_code,locname_eng from location where cir_code!='00' and mouza_pargona_code='00' and dist_code='$dist' ";
		$list=$this->db->query($circleList)->result_array();
		foreach ($list as $key => $val) {
			$curmonth=$premonth=$total=0;
			/////////For Current Month/////////////
			$sql="Select count(*) as curmonth from dashboard_data where ($params) and date_of_reg >  CURRENT_DATE - INTERVAL '1 months' and  dist_code='$dist' and subdiv_code='$val[subdiv_code]' and cir_code='$val[cir_code]' ";
			$curmonth=$this->db->query($sql)->row()->curmonth;
			/////////For Previous Month/////////////
			$sql="Select count(*) as premonth from dashboard_data where ($params) and   date_of_reg >= date_trunc('month', current_date - interval '1' month)
  and date_of_reg < date_trunc('month', current_date) and dist_code='$dist' and subdiv_code='$val[subdiv_code]' and cir_code='$val[cir_code]' ";
			$premonth=$this->db->query($sql)->row()->premonth;
			/////////For total/////////////
			$sql="Select count(*) as total from dashboard_data where ($params) and  dist_code='$dist' and subdiv_code='$val[subdiv_code]' and cir_code='$val[cir_code]'  ";
			$total=$this->db->query($sql)->row()->total;
			//////////
			$pending[] = array(
				'dist_code'=>$dist,
				'subdiv_code'=>$val['subdiv_code'],
				'cir_code'=>$val['cir_code'],
				'circle' => $val['locname_eng'],
				'name' => $val['locname_eng'],
				'curmonth'=>$curmonth,
				'premonth'=>$premonth,
				'total'=>$total
			 );
			
		}
		return $pending;
		//echo $twoMonths . "-" . $sixMonths . "-" . $sixMonthsGrt . "-" . $oneYear;
	}
	function thirdMutationDev($dist){
		$params= $this->switchProcess();
		$circleList="select subdiv_code,cir_code,locname_eng from location where cir_code!='00' and mouza_pargona_code='00' and dist_code='$dist' ";
		$list=$this->db->query($circleList)->result_array();
		foreach ($list as $key => $val) {
			$curmonth=$premonth=$total=0;
			/////////For Current Month/////////////
			$sql="Select count(*) as curmonth from dashboard_data where ($params) and date_of_reg >  CURRENT_DATE - INTERVAL '1 months' and  dist_code='$dist' and subdiv_code='$val[subdiv_code]' and cir_code='$val[cir_code]' and (status='F' or status='D')  ";
			$curmonth=$this->db->query($sql)->row()->curmonth;
			/////////For Previous Month/////////////
			$sql="Select count(*) as premonth from dashboard_data where ($params) and   date_of_reg >= date_trunc('month', current_date - interval '1' month)
  and date_of_reg < date_trunc('month', current_date) and dist_code='$dist' and subdiv_code='$val[subdiv_code]' and cir_code='$val[cir_code]' and (status='F' or status='D')  ";
			$premonth=$this->db->query($sql)->row()->premonth;
			/////////For total/////////////
			$sql="Select count(*) as total from dashboard_data where ($params) and  dist_code='$dist' and subdiv_code='$val[subdiv_code]' and cir_code='$val[cir_code]' and (status='F' or status='D')   ";
			$total=$this->db->query($sql)->row()->total;
			//////////
			$pending[] = array(
				'dist_code'=>$dist,
				'subdiv_code'=>$val['subdiv_code'],
				'cir_code'=>$val['cir_code'],
				'name' => $val['locname_eng'],
				'circle' => $val['locname_eng'],
				'curmonth'=>$curmonth,
				'premonth'=>$premonth,
				'total'=>$total
			 );
			
		}
		return $pending;
		//echo $twoMonths . "-" . $sixMonths . "-" . $sixMonthsGrt . "-" . $oneYear;
	}
	function fourthMutationDev($dist,$s,$c){
		$params= $this->switchProcess();
		$circleList="select subdiv_code,cir_code,mouza_pargona_code, locname_eng from location where cir_code='$c' and mouza_pargona_code!='00' and lot_no='00' and dist_code='$dist' and subdiv_code='$s' ";
		$list=$this->db->query($circleList)->result_array();
		foreach ($list as $key => $val) {
			$curmonth=$premonth=$total=0;
			/////////For Current Month/////////////
			$sql="Select count(*) as curmonth from dashboard_data where ($params) and date_of_reg >  CURRENT_DATE - INTERVAL '1 months' and  dist_code='$dist' and subdiv_code='$val[subdiv_code]' and cir_code='$val[cir_code]' and mouza_pargona_code='$val[mouza_pargona_code]' and (status='F' or status='D')  ";
			$curmonth=$this->db->query($sql)->row()->curmonth;
			/////////For Previous Month/////////////
			$sql="Select count(*) as premonth from dashboard_data where ($params) and   date_of_reg >= date_trunc('month', current_date - interval '1' month)
  and date_of_reg < date_trunc('month', current_date) and dist_code='$dist' and subdiv_code='$val[subdiv_code]' and cir_code='$val[cir_code]' and mouza_pargona_code='$val[mouza_pargona_code]' and (status='F' or status='D')  ";
			$premonth=$this->db->query($sql)->row()->premonth;
			/////////For total/////////////
			$sql="Select count(*) as total from dashboard_data where ($params) and  dist_code='$dist' and subdiv_code='$val[subdiv_code]' and cir_code='$val[cir_code]' and mouza_pargona_code='$val[mouza_pargona_code]' and (status='F' or status='D')   ";
			$total=$this->db->query($sql)->row()->total;
			//////////
			$pending[] = array(
				'dist_code'=>$dist,
				'subdiv_code'=>$val['subdiv_code'],
				'cir_code'=>$val['cir_code'],
				'name' => $val['locname_eng'],
				'mouza_pargona_code'=>$val['mouza_pargona_code'],
				'circle' => $val['locname_eng'],
				'curmonth'=>$curmonth,
				'premonth'=>$premonth,
				'total'=>$total
			 );
			
		}
		return $pending;
		//echo $twoMonths . "-" . $sixMonths . "-" . $sixMonthsGrt . "-" . $oneYear;
	}
	function fourthMutationReg($dist,$s,$c){
		$params= $this->switchProcess();
		$circleList="select subdiv_code,cir_code,mouza_pargona_code, locname_eng from location where cir_code='$c' and mouza_pargona_code!='00' and lot_no='00' and dist_code='$dist' and subdiv_code='$s' ";
		$list=$this->db->query($circleList)->result_array();
		foreach ($list as $key => $val) {
			$curmonth=$premonth=$total=0;
			/////////For Current Month/////////////
			$sql="Select count(*) as curmonth from dashboard_data where ($params) and date_of_reg >  CURRENT_DATE - INTERVAL '1 months' and  dist_code='$dist' and subdiv_code='$val[subdiv_code]' and cir_code='$val[cir_code]' and mouza_pargona_code='$val[mouza_pargona_code]' ";
			$curmonth=$this->db->query($sql)->row()->curmonth;
			/////////For Previous Month/////////////
			$sql="Select count(*) as premonth from dashboard_data where ($params) and   date_of_reg >= date_trunc('month', current_date - interval '1' month)
  and date_of_reg < date_trunc('month', current_date) and dist_code='$dist' and subdiv_code='$val[subdiv_code]' and cir_code='$val[cir_code]' and mouza_pargona_code='$val[mouza_pargona_code]'   ";
			$premonth=$this->db->query($sql)->row()->premonth;
			/////////For total/////////////
			$sql="Select count(*) as total from dashboard_data where ($params) and  dist_code='$dist' and subdiv_code='$val[subdiv_code]' and cir_code='$val[cir_code]' and mouza_pargona_code='$val[mouza_pargona_code]' ";
			$total=$this->db->query($sql)->row()->total;
			//////////
			$pending[] = array(
				'dist_code'=>$dist,
				'subdiv_code'=>$val['subdiv_code'],
				'cir_code'=>$val['cir_code'],
				'name' => $val['locname_eng'],
				'mouza_pargona_code'=>$val['mouza_pargona_code'],
				'circle' => $val['locname_eng'],
				'curmonth'=>$curmonth,
				'premonth'=>$premonth,
				'total'=>$total
			 );
			
		}
		return $pending;
		//echo $twoMonths . "-" . $sixMonths . "-" . $sixMonthsGrt . "-" . $oneYear;
	}
	function fifthMutation($d,$s,$c,$m){
		$params= $this->switchProcess();
		$circleList="select subdiv_code,cir_code,mouza_pargona_code,lot_no, locname_eng from location where cir_code='$c' and mouza_pargona_code='$m' and lot_no!='00' and dist_code='$d' and subdiv_code='$s' and vill_townprt_code='00000' ";
		$list=$this->db->query($circleList)->result_array();
		foreach ($list as $key => $val) {
			$twoMonths=$sixMonths=$sixMonthsGrt=$oneYear=0;
			$sql="Select date_of_reg  from dashboard_data where ($params) and dist_code='$d' and subdiv_code='$val[subdiv_code]' and cir_code='$val[cir_code]' and mouza_pargona_code='$val[mouza_pargona_code]' and lot_no='$val[lot_no]' and pending_with_user='LM' and status='P' ";
			$result=$this->db->query($sql)->result_array();
			foreach ($result as $key => $value) {
				$firstDate=new DateTime();
				$secondDate = new DateTime($value['date_of_reg']);
				$intvl = $firstDate->diff($secondDate);
				//var_dump($intvl);
				if($intvl->days >= 30 and $intvl->days < 90){
					$twoMonths=$twoMonths+1;
					//break;;
				}elseif($intvl->days >= 90 and $intvl->days < 180){
					$sixMonths=$sixMonths+1;
					//break;;
				}elseif($intvl->days >= 180 and $intvl->days < 365){
					$sixMonthsGrt=$sixMonthsGrt+1;
					//break;;
				}elseif($intvl->days >= 365){
					 $oneYear=$oneYear+1;
					 //break;;
				}
			}
			$pending[] = array(
			'dist_code'=>$d,
			'subdiv_code'=>$val['subdiv_code'],
			'cir_code'=>$val['cir_code'],
			'mouza_pargona_code'=>$val['mouza_pargona_code'],
			'lot_no'=>$val['lot_no'],
			'name' => $val['locname_eng'],
			'twoMonths'=>$twoMonths,
			'sixMonths'=>$sixMonths,
			'sixMonthsGrt'=>$sixMonthsGrt,
			'oneYear'=>$oneYear
			 );
		}
		return $pending;
		//echo $twoMonths . "-" . $sixMonths . "-" . $sixMonthsGrt . "-" . $oneYear;
	}
	function fifthMutationReg($dist,$s,$c,$m){
		$params= $this->switchProcess();
		$circleList="select subdiv_code,cir_code,mouza_pargona_code,lot_no, locname_eng from location where cir_code='$c' and mouza_pargona_code='$m' and lot_no!='00' and dist_code='$dist' and subdiv_code='$s' and vill_townprt_code='00000' ";
		$list=$this->db->query($circleList)->result_array();
		foreach ($list as $key => $val) {
			$curmonth=$premonth=$total=0;
			/////////For Current Month/////////////
			$sql="Select count(*) as curmonth from dashboard_data where ($params) and date_of_reg >  CURRENT_DATE - INTERVAL '1 months' and  dist_code='$dist' and subdiv_code='$val[subdiv_code]' and cir_code='$val[cir_code]' and mouza_pargona_code='$val[mouza_pargona_code]' and  lot_no='$val[lot_no]' ";
			$curmonth=$this->db->query($sql)->row()->curmonth;
			/////////For Previous Month/////////////
			$sql="Select count(*) as premonth from dashboard_data where ($params) and   date_of_reg >= date_trunc('month', current_date - interval '1' month)
  and date_of_reg < date_trunc('month', current_date) and dist_code='$dist' and subdiv_code='$val[subdiv_code]' and cir_code='$val[cir_code]' and mouza_pargona_code='$val[mouza_pargona_code]' and lot_no='$val[lot_no]'   ";
			$premonth=$this->db->query($sql)->row()->premonth;
			/////////For total/////////////
			$sql="Select count(*) as total from dashboard_data where ($params) and  dist_code='$dist' and subdiv_code='$val[subdiv_code]' and cir_code='$val[cir_code]' and mouza_pargona_code='$val[mouza_pargona_code]' and lot_no='$val[lot_no]' ";
			$total=$this->db->query($sql)->row()->total;
			//////////
			$pending[] = array(
				'dist_code'=>$dist,
				'subdiv_code'=>$val['subdiv_code'],
				'cir_code'=>$val['cir_code'],
				'name' => $val['locname_eng'],
				'mouza_pargona_code'=>$val['mouza_pargona_code'],
				'lot_no'=>$val['lot_no'],
				'name' => $val['locname_eng'],
				'curmonth'=>$curmonth,
				'premonth'=>$premonth,
				'total'=>$total
			 );
		}
		return $pending;
		//echo $twoMonths . "-" . $sixMonths . "-" . $sixMonthsGrt . "-" . $oneYear;
	}
	function fifthMutationDev($dist,$s,$c,$m){
		$params= $this->switchProcess();
		$circleList="select subdiv_code,cir_code,mouza_pargona_code,lot_no, locname_eng from location where cir_code='$c' and mouza_pargona_code='$m' and lot_no!='00' and dist_code='$dist' and subdiv_code='$s' and vill_townprt_code='00000' ";
		$list=$this->db->query($circleList)->result_array();
		foreach ($list as $key => $val) {
			$curmonth=$premonth=$total=0;
			/////////For Current Month/////////////
			$sql="Select count(*) as curmonth from dashboard_data where ($params) and date_of_reg >  CURRENT_DATE - INTERVAL '1 months' and  dist_code='$dist' and subdiv_code='$val[subdiv_code]' and cir_code='$val[cir_code]' and mouza_pargona_code='$val[mouza_pargona_code]' and  lot_no='$val[lot_no]' and (status='F' or status='D')  ";
			$curmonth=$this->db->query($sql)->row()->curmonth;
			/////////For Previous Month/////////////
			$sql="Select count(*) as premonth from dashboard_data where ($params) and   date_of_reg >= date_trunc('month', current_date - interval '1' month)
  and date_of_reg < date_trunc('month', current_date) and dist_code='$dist' and subdiv_code='$val[subdiv_code]' and cir_code='$val[cir_code]' and mouza_pargona_code='$val[mouza_pargona_code]' and lot_no='$val[lot_no]' and (status='F' or status='D')   ";
			$premonth=$this->db->query($sql)->row()->premonth;
			/////////For total/////////////
			$sql="Select count(*) as total from dashboard_data where ($params) and  dist_code='$dist' and subdiv_code='$val[subdiv_code]' and cir_code='$val[cir_code]' and mouza_pargona_code='$val[mouza_pargona_code]' and lot_no='$val[lot_no]' and (status='F' or status='D')  ";
			$total=$this->db->query($sql)->row()->total;
			//////////
			$pending[] = array(
				'dist_code'=>$dist,
				'subdiv_code'=>$val['subdiv_code'],
				'cir_code'=>$val['cir_code'],
				'name' => $val['locname_eng'],
				'mouza_pargona_code'=>$val['mouza_pargona_code'],
				'lot_no'=>$val['lot_no'],
				'name' => $val['locname_eng'],
				'curmonth'=>$curmonth,
				'premonth'=>$premonth,
				'total'=>$total
			 );
		}
		return $pending;
		//echo $twoMonths . "-" . $sixMonths . "-" . $sixMonthsGrt . "-" . $oneYear;
	}
	function switchProcess(){
		$type=$this->session->userdata('queryParams');
		// $status=$this->session->userdata('status');
		// if($status=='A'){
		// 	$status="F or status=P ";
		// }
		// else{
		// 	$status=$status;
		// }

		if($type=='1'){
			$this->session->set_userdata('case_type','Mutation');
			return $params="(case_type='FM' or case_type='OM')  ";
		}elseif($type=='2'){
			$this->session->set_userdata('case_type','Partition');
			return $params="(case_type='FP' or case_type='OP') ";
		}elseif($type=='3'){
			$this->session->set_userdata('case_type','Certificate');
			return $params="case_type='CR' ";
		}elseif($type=='4'){
			$this->session->set_userdata('case_type','Allotment Certificate');
			return $params="case_type='AC' ";
		}elseif($type=='5'){
			$this->session->set_userdata('case_type','Annual Patta Cancellation');
			return $params="case_type='AP'";
		}elseif($type=='6'){
			$this->session->set_userdata('case_type','Misc Case');
			return $params="case_type='MC' ";
		}elseif($type=='7'){
			$this->session->set_userdata('case_type','Conversion');
			return $params="case_type='CV' ";
		}elseif($type=='8'){
			$this->session->set_userdata('case_type','Reclassification');
			return $params="case_type='RC'";
		}elseif($type=='9'){
			$this->session->set_userdata('case_type','Settlement');
			return $params="case_type='SM'";
		}
	}
}
?>