<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Tenants extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
        $this->load->model('tenant');
        $this->load->helper(array('form', 'url', 'Language'));
		$this->load->library('form_validation');
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

	public function checkKhatianExist() {
        $tenants = $this->session->userdata('tenants');
        $d = $tenants['dist_code'];
        $s = $tenants['subdiv_code'];
        $c = $tenants['circle_code'];
        $m = $tenants['mouza_code'];
        $l = $tenants['lot_no'];
        $v = $tenants['vill_code'];
        $id = $tenants['khatian_no'];
        $exists = $this->db->query("select count(*) as c from chitha_tenant where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and "
                    . " mouza_pargona_code='$m' and lot_no='$l' and vill_townprt_code='$v' and khatian_no=$id ")->row()->c;
        return($exists);
    }

    public function indexAdd() {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $data = $this->mutationmodel->getVillageCodeJSON($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
            $district['villages'] = $data;
			$this->form_validation->set_rules('khatian_no', 'Khatian No', 'required|trim|integer');
			$this->form_validation->set_rules('vill_code', 'Village','required|trim|strip_tags|xss_clean|interger|max_length[5]|min_length[5]');
			if ($this->form_validation->run() == FALSE)
            {
				// $this->load->helper('html');
				// $this->load->view('../views/header');
				// $this->load->view('../views/Tenant/select_location', $district);
				// $this->load->view('../views/footer');

				$district['_view'] = 'Tenant/select_location';
        		$this->load->view('layouts/main',$district);
			}
			else{
				$this->session->set_userdata(array('tenants' => $this->input->post()));
				$value=$this->checkKhatianExist();
				if($value==0){
					redirect(base_url() . "index.php/Tenants/AddTenant");
				}else{
					$this->session->set_flashdata('message',"Khatian Already Exists in Records !! Please Check Khatian ");
					redirect(base_url() . "index.php/Home");
				}
			}
			
    }
	public function deleteTenant() {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $data = $this->mutationmodel->getVillageCodeJSON($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
            $district['villages'] = $data;
			$this->form_validation->set_rules('khatian_no', 'Khatian No', 'required|trim|integer');
			$this->form_validation->set_rules('vill_code', 'Village','required|trim|strip_tags|xss_clean|interger|max_length[5]|min_length[5]');
			if ($this->form_validation->run() == FALSE)
            {
				// $this->load->helper('html');
				// $this->load->view('../views/header');
				// $this->load->view('../views/Tenant/select_location_delete', $district);
				// $this->load->view('../views/footer');

				$district['_view'] = 'Tenant/select_location_delete';
        		$this->load->view('layouts/main',$district);
			}
			else{
				$this->session->set_userdata(array('tenants' => $this->input->post()));
				$value=$this->checkKhatianExist();
				if($value!=0){
					redirect(base_url() . "index.php/Tenants/RemoveTenant");
				}else{
					$this->session->set_flashdata('message',"Khatian Not Exists in our Records !! Please Check Khatian ");
					redirect(base_url() . "index.php/Home");
				}
			}
			
    }
	function RemoveTenant(){
			//var_dump($this->session->all_userdata());
			$dist_code = $this->session->userdata['tenants']['dist_code'];
            $subdiv_code = $this->session->userdata['tenants']['subdiv_code'];
            $cir_code = $this->session->userdata['tenants']['circle_code'];
            $mouza_code = $this->session->userdata['tenants']['mouza_code'];
            $lot_no = $this->session->userdata['tenants']['lot_no'];
            $vill_code = $this->session->userdata['tenants']['vill_code'];
            $khatian_no = $this->session->userdata['tenants']['khatian_no'];
			$q="SElect tenant_id,tenant_name,tenants_father,tenants_add1,status from chitha_tenant where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'
			and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'  and khatian_no='$khatian_no' order by tenant_id asc ";
			$data['pattadar']=$this->db->query($q)->result();
			// $this->load->view('../views/header');
			// $this->load->view('../views/Tenant/viewtenant',$data);
			// $this->load->view('../views/footer');

			$district['_view'] = 'Tenant/viewtenant';
        	$this->load->view('layouts/main',$district);
			//var_dump($data);
	}
	function AddBackTenant(){
		//var_dump($this->session->all_userdata());
		$query = "select * from tenant_type";
        $data['tenant_type'] = $this->db->query($query)->result();
		$this->form_validation->set_rules('tenant_name', 'Enter Name', 'required|trim|strip_tags|xss_clean|');
		$this->form_validation->set_rules('tenants_father', 'Father Name', 'required|trim|strip_tags|xss_clean|');
		$this->form_validation->set_rules('tenants_add1', 'Address', 'required|trim|strip_tags|xss_clean');
		$this->form_validation->set_rules('teant_type', 'Tenant Type', 'required|trim|strip_tags|xss_clean');
			if ($this->form_validation->run() == FALSE)
            {
				// $this->load->view('../views/header');
				// $this->load->view('../views/Tenant/addbacktenant',$data);
				// $this->load->view('../views/footer');

				$data['_view'] = 'Tenant/addbacktenant';
        		$this->load->view('layouts/main',$data);	
			}else{
				$dist_code = $this->session->userdata['tenants']['dist_code'];
				$subdiv_code = $this->session->userdata['tenants']['subdiv_code'];
				$cir_code = $this->session->userdata['tenants']['circle_code'];
				$mouza_code = $this->session->userdata['tenants']['mouza_code'];
				$lot_no = $this->session->userdata['tenants']['lot_no'];
				$vill_code = $this->session->userdata['tenants']['vill_code'];
				$khatian_no = $this->session->userdata['tenants']['khatian_no'];
				$user_code=$this->session->userdata('user_code');
				$q="SElect max(tenant_id)+1 as id from chitha_tenant where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'
				and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and khatian_no='$khatian_no' ";
				$id=$this->db->query($q)->row()->id;
				$q="SElect dag_no as dag from chitha_tenant where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'
				and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and khatian_no='$khatian_no' ";
				$dag=$this->db->query($q)->row()->dag;
				$tenant=array(
					'dist_code'=>$dist_code,
					'subdiv_code'=>$subdiv_code,
					'cir_code'=>$cir_code,
					'mouza_pargona_code'=>$mouza_code,
					'lot_no'=>$lot_no,
					'vill_townprt_code'=>$vill_code,
					'dag_no'=>$dag,
					'tenant_name'=>$this->input->post('tenant_name'),
					'tenants_father'=>$this->input->post('tenants_father'),
					'tenants_add1'=>$this->input->post('tenants_add1'),
					'type_of_tenant'=>$this->input->post('teant_type'),
					'khatian_no'=>$khatian_no,
					'user_code'=>$user_code,
					'date_entry'=>date('Y-m-d'),
					'status'=>'0',
					'operation'=>'O',
					'tenant_id'=>$id,
				);
				//var_dump($tenant);
				$this->db->insert('chitha_tenant',$tenant);
				redirect(base_url()."index.php/Tenants/RemoveTenant");
			}
	}
	function PermanenantRTenant(){
				$dist_code = $this->session->userdata['tenants']['dist_code'];
				$subdiv_code = $this->session->userdata['tenants']['subdiv_code'];
				$cir_code = $this->session->userdata['tenants']['circle_code'];
				$mouza_code = $this->session->userdata['tenants']['mouza_code'];
				$lot_no = $this->session->userdata['tenants']['lot_no'];
				$vill_code = $this->session->userdata['tenants']['vill_code'];
				$khatian_no = $this->session->userdata['tenants']['khatian_no'];
				$tenantid=$this->input->get('id');
				$q="Delete from chitha_tenant where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'
				and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and 
				tenant_id='$tenantid' and khatian_no='$khatian_no'	";
				$this->db->query($q);
				redirect(base_url()."index.php/Tenants/RemoveTenant");
	}	
	function StrikeTenant(){
				$dist_code = $this->session->userdata['tenants']['dist_code'];
				$subdiv_code = $this->session->userdata['tenants']['subdiv_code'];
				$cir_code = $this->session->userdata['tenants']['circle_code'];
				$mouza_code = $this->session->userdata['tenants']['mouza_code'];
				$lot_no = $this->session->userdata['tenants']['lot_no'];
				$vill_code = $this->session->userdata['tenants']['vill_code'];
				$khatian_no = $this->session->userdata['tenants']['khatian_no'];
				$tenantid=$this->input->get('id');
				$q="Update chitha_tenant set status='1' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'
				and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and 
				tenant_id='$tenantid' and khatian_no='$khatian_no'	";
				$this->db->query($q);
				redirect(base_url()."index.php/Tenants/RemoveTenant");
	}
	function UnStrikeTenant(){
				$dist_code = $this->session->userdata['tenants']['dist_code'];
				$subdiv_code = $this->session->userdata['tenants']['subdiv_code'];
				$cir_code = $this->session->userdata['tenants']['circle_code'];
				$mouza_code = $this->session->userdata['tenants']['mouza_code'];
				$lot_no = $this->session->userdata['tenants']['lot_no'];
				$vill_code = $this->session->userdata['tenants']['vill_code'];
				$khatian_no = $this->session->userdata['tenants']['khatian_no'];
				$tenantid=$this->input->get('id');
				$q="Update chitha_tenant set status='0' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'
				and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and 
				tenant_id='$tenantid' and khatian_no='$khatian_no'	";
				$this->db->query($q);
				redirect(base_url()."index.php/Tenants/RemoveTenant");
	}
	function AddTenant(){
		//var_dump($this->session->all_userdata());
		$query = "select * from tenant_type";
        $data['tenant_type'] = $this->db->query($query)->result();
		$this->form_validation->set_rules('tenant_name', 'Enter Name', 'required|trim|strip_tags|xss_clean|');
		$this->form_validation->set_rules('tenants_father', 'Father Name', 'required|trim|strip_tags|xss_clean|');
		$this->form_validation->set_rules('tenants_add1', 'Address', 'required|trim|strip_tags|xss_clean');
		$this->form_validation->set_rules('teant_type', 'Tenant Type', 'required|trim|strip_tags|xss_clean');
			if ($this->form_validation->run() == FALSE)
            {
			// $this->load->view('../views/header');
			// $this->load->view('../views/Tenant/addtenant',$data);
			// $this->load->view('../views/footer');

			$data['_view'] = 'Tenant/addtenant';
        	$this->load->view('layouts/main',$data);

			}else{
			$this->tenant->addTenant();
			// $this->load->view('../views/header');
			// $this->load->view('../views/Tenant/addmoretenant');
			// $this->load->view('../views/footer');

			$data['_view'] = 'Tenant/addmoretenant';
        	$this->load->view('layouts/main',$data);
			}
	}
	
	function AddBasic(){
		$tenants = $this->session->userdata('tenants');
            $d = $tenants['dist_code'];
            $s = $tenants['subdiv_code'];
            $c = $tenants['circle_code'];
            $m = $tenants['mouza_code'];
            $l = $tenants['lot_no'];
            $v = $tenants['vill_code'];
            $query = "select distinct dag_no_int,dag_no from chitha_basic where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and "
                    . " mouza_pargona_code='$m' and lot_no='$l' and vill_townprt_code='$v' and patta_type_code!='0209' order by dag_no_int";

        $data['dags'] = $this->db->query($query)->result();
		$this->form_validation->set_rules('length_posession', 'Possesion Duration', 'required|trim|strip_tags|xss_clean');
		$this->form_validation->set_rules('dag_no', 'Dag_no', 'required|trim|strip_tags|xss_clean|integer');
		$this->form_validation->set_rules('id', 'Khatian no', 'required|trim|strip_tags|xss_clean|integer');	
		$this->form_validation->set_rules('tenant_status', 'Dag Number', 'required|trim|strip_tags|xss_clean');
		$this->form_validation->set_rules('payable_cash_kind', 'Payable Cash', 'required|trim|strip_tags|xss_clean');
		$this->form_validation->set_rules('paid_cash_kind', 'Cash Kind', 'required|trim|strip_tags|xss_clean');
		$this->form_validation->set_rules('special_conditions', 'Special Condition', 'required|trim|strip_tags|xss_clean');
		$this->form_validation->set_rules('remarks', 'Remark', 'required|trim|strip_tags|xss_clean');
		if ($this->form_validation->run() == FALSE)
            {
				// $this->load->view('../views/header');
				// $this->load->view('../views/Tenant/khatianbasic',$data);
				// $this->load->view('../views/footer');

				$data['_view'] = 'Tenant/khatianbasic';
        		$this->load->view('layouts/main',$data);
			}else{
				$this->tenant->basicDetails();
				// $this->load->view('../views/header');
				// $this->load->view('../views/Tenant/addmoredag');
				// $this->load->view('../views/footer');

				$data['_view'] = 'Tenant/addmoredag';
        		$this->load->view('layouts/main',$data);
			}
		
	}
	function FinalSubmit(){
			// $this->load->view('../views/header');
			// $this->load->view('../views/Tenant/report');
			// $this->load->view('../views/footer');

			$data['_view'] = 'Tenant/report';
        	$this->load->view('layouts/main',$data);
	}
	function SaveAll(){
		$chitha=$this->session->userdata('tenant_basic');
		foreach($chitha as $ct){
			$ct['mouza_pargona_code']=$ct['mouza_code'];
			$ct['vill_townprt_code']=$ct['vill_code'];
			$ct['cir_code']=$ct['circle_code'];
			$ct['dag_no']=$ct['dag_no']/100;
			unset($ct['mouza_code']);
			unset($ct['circle_code']);
			unset($ct['vill_code']);
			unset($ct['khatian_no']);
			//var_dump($ct);
			$this->db->insert('khatian',$ct);
			
		}
		$name=$this->session->userdata('mut_petitioner');
		foreach($name as $tenant){
				$d=$tenant['dist_code'];
				$s=$tenant['subdiv_code'];
				$c=$tenant['circle_code'];
				$m=$tenant['mouza_code'];
				$l=$tenant['lot_no'];
				$v=$tenant['vill_code'];
				$k=$tenant['khatian_no'];
				$tenant['cir_code'] = $tenant['circle_code'];
				$tenant['mouza_pargona_code']=$tenant['mouza_code'];
				$tenant['vill_townprt_code']=$tenant['vill_code'];
				$tenant['type_of_tenant']=$tenant['teant_type'];
				$tenant['dag_no']=$ct['dag_no'];
				$tenant['user_code'] = $this->session->userdata('user_code');
				$tenant['date_entry'] = date('Y-m-d');
				$tenant['operation'] = 'E';
				unset($tenant['mouza_code']);
				unset($tenant['vill_code']);
				unset($tenant['circle_code']);
				unset($tenant['teant_type']);
				//unset($tenant['dag_no']);
				$tenant_id = $this->db->query("select max(tenant_id) as tenant_id from chitha_tenant where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$m' and lot_no='$l' and vill_townprt_code='$v' and khatian_no='$k' ")->row()->tenant_id;
					if($tenant_id==null){
						$tenant_id = 1;
					} else {
						$tenant_id += 1;
					}
				$tenant['tenant_id'] = $tenant_id;
				//var_dump($tenant);
				$this->db->insert('chitha_tenant',$tenant);
			}
		$this->session->set_flashdata('message',"Tenant Name Added Successfully !!");
		redirect(base_url() . "index.php/Home");
	}
    public function add() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            //var_dump($this->input->post());
            $basicdata = array();
            $basicdata['khatian_no'] = $this->input->post('khatian_no');
            $basicdata['areab'] = $this->input->post('areab');
            $basicdata['areak'] = $this->input->post('areak');
            $basicdata['areal'] = $this->input->post('areal');
            $basicdata['dag_no'] = $this->input->post('dag_no');
            $basicdata['payable_cash_kind'] = $this->input->post('payable_cash_kind');
            $basicdata['paid_cash_kind'] = $this->input->post('paid_cash_kind');
            $basicdata['duration'] = $this->input->post('duration');
            $basicdata['tenant_status'] = $this->input->post('tenant_status');
            $basicdata['special_conditions'] = $this->input->post('special_conditions');
            $basicdata['remarks'] = $this->input->post('remarks');
            $basicdata['revenue'] = $this->input->post('revenue_tenant');
            $basicdata['duration'] = $this->input->post('duration');
            $this->session->set_userdata(array('basicdata'=>$basicdata));
            $tenants = $this->session->userdata('tenants');
            // var_dump($tenants);
            //$khatian_no = $this->db->query("select max(id) as khatian_no from khatian")->row()->khatian_no;
            $khatian_no = $this->input->post('khatian_no');

            /* if (!$khatian_no) {
              $khatian_no = 1;
              } else {
              $khatian_no += 1;
              } */
            $d = $tenants['dist_code'];
            $s = $tenants['subdiv_code'];
            $c = $tenants['circle_code'];
            $m = $tenants['mouza_code'];
            $l = $tenants['lot_no'];
            $v = $tenants['vill_code'];

            $query = "select count(*) as c from khatian where id=$khatian_no";
            $khatianExists = $this->db->query($query)->row()->c;

            if ($this->input->post('possession_duration_years')==null)
                $pdy = 0;
            if ($this->input->post('possession_duration_months')==null)
                $pdm = 0;
            if ($this->input->post('possession_duration_days')==null)
                $pdd = 0;
            $khatian = array(
                'possession_duration_years' => $pdy,
                'possession_duration_months' => $pdm,
                'possession_duration_days' => $pdd,
                'payable_cash_kind' => $this->input->post('payable_cash_kind'),
                'tenant_status' => $this->input->post('tenant_status'),
                'special_conditions' => $this->input->post('special_conditions'),
                'remarks' => $this->input->post('special_conditions'),
                'id' => $khatian_no
            );
            if (!$khatianExists) {
                $this->db->insert('khatian', $khatian);
            }
            $data = $this->input->post();
            unset($data['possession_duration_years']);
            unset($data['possession_duration_months']);
            unset($data['possession_duration_days']);
            unset($data['possession_duration']);
            $data['payable_cash_kind'];
            $data['tenant_status'];
            $data['special_conditions'];
            $data['remarks'];
            if (!$data['revenue_tenant'])
                $data['revenue_tenant'] = 0;
            $data['dist_code'] = $d;
            $data['subdiv_code'] = $s;
            $data['cir_code'] = $c;
            $data['mouza_pargona_code'] = $m;
            $data['lot_no'] = $l;
            $data['vill_townprt_code'] = $v;
            $data['khatian_no'] = $khatian_no;
            $tenant_id = $this->db->query("select max(tenant_id) as tenant_id from chitha_tenant")->row()->tenant_id;
            if (!$tenant_id) {
                $tenant_id = 1;
            } else {
                $tenant_id += 1;
            }
            $data['tenant_id'] = $tenant_id;
            $data['user_code'] = $this->session->userdata('user_code');
            $data['date_entry'] = date('Y-m-d');
            $data['operation'] = 'E';
            $data['duration']=$this->input->post('duration');
            //var_dump($data);
            $this->db->insert('chitha_tenant', $data);
            if ($this->db->affected_rows() == 1) {
                redirect(base_url() . "index.php/Tenants/add");
            }
        } elseif ($this->input->server('REQUEST_METHOD') == 'GET') {
            $this->load->helper('html');
            $this->load->view('../views/header');
            if($this->session->userdata('basicdata')){
                $data['first'] = false;
                $bd = $this->session->userdata('basicdata');
                $data['khatian_no'] = $bd['khatian_no'];
                $data['areab'] = $bd['areab'];
                $data['areak'] = $bd['areak'];
                $data['areal'] = $bd['areal'];
                $data['dag_no'] = $bd['dag_no'];
                $data['revenue'] = $bd['revenue'];
                $data['duration'] = $bd['duration'];
                $data['payable_cash_kind'] = $bd['payable_cash_kind'];
                $data['paid_cash_kind'] = $bd['paid_cash_kind'];
                $data['tenant_status'] = $bd['tenant_status'];
                $data['special_conditions'] = $bd['special_conditions'];
                $data['remarks'] = $bd['remarks'];
                
            }else{
                $data['first'] = true;
            }
            $tenants = $this->session->userdata('tenants');
            $d = $tenants['dist_code'];
            $s = $tenants['subdiv_code'];
            $c = $tenants['circle_code'];
            $m = $tenants['mouza_code'];
            $l = $tenants['lot_no'];
            $v = $tenants['vill_code'];
            $query = "select distinct dag_no_int,dag_no from chitha_basic where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and "
                    . " mouza_pargona_code='$m' and lot_no='$l' order by dag_no_int";

            $data['dags'] = $this->db->query($query)->result();
            $query = "select * from tenant_type";
            $data['tenant_type'] = $this->db->query($query)->result();
            //$this->load->view('../views/Tenant/add', $data);

            $data['_view'] = 'Tenant/add';
        	$this->load->view('layouts/main',$data);
        }
       // $this->load->view('../views/footer');
    }

}
