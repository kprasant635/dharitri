<?php

class chitha_basic_deo extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Chitha_basic_model');
        $this->load->model('mutation/mutationmodel');
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

    function index() {
		//  $db=  $this->session->userdata('db');
        $this->load->library('form_validation');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouzas = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
        $data['mouzas'] = $mouzas;
        $q = "Select type_code,patta_type from    patta_code";
        $data['patta'] = $this->db->query($q)->result();
        $q = "Select class_code,land_type from    landclass_code order by class_code";
        $data['landclass'] = $this->db->query($q)->result();
        $this->form_validation->set_rules('dist_code', 'Dist Code', 'required|max_length[2]');
        $this->form_validation->set_rules('subdiv_code', 'Subdiv Code', 'required|max_length[2]');
        $this->form_validation->set_rules('cir_code', 'Cir Code', 'required|max_length[2]');
        $this->form_validation->set_rules('mouza_pargona_code', 'Mouza Pargona Code', 'required|max_length[2]');
        $this->form_validation->set_rules('lot_no', 'Lot No', 'required|max_length[2]');
        $this->form_validation->set_rules('vill_townprt_code', 'Vill Townprt Code', 'required|max_length[5]');
        $this->form_validation->set_rules('old_dag_no', 'Old Dag No', 'max_length[12]');
        $this->form_validation->set_rules('dag_no', 'Dag No', 'required|max_length[12]');
        $this->form_validation->set_rules('patta_type_code', 'Patta Type Code', 'required|max_length[4]');
        $this->form_validation->set_rules('patta_no', 'Patta No', 'required|max_length[20]');
        $this->form_validation->set_rules('land_class_code', 'Land Class Code', 'required|max_length[4]');
        $this->form_validation->set_rules('dag_area_b', 'Dag Area B', 'required');
        $this->form_validation->set_rules('dag_area_k', 'Dag Area K', 'required');
        $this->form_validation->set_rules('dag_area_lc', 'Dag Area Lc', 'required|numeric');
        $this->form_validation->set_rules('dag_area_g', 'Dag Area G', 'required|numeric');
        $this->form_validation->set_rules('dag_area_kr', 'Dag Area Kr', 'required');
        $this->form_validation->set_rules('dag_area_are', 'Dag Area Are', 'numeric');
        $this->form_validation->set_rules('dag_revenue', 'Dag Revenue', 'numeric');
        $this->form_validation->set_rules('dag_local_tax', 'Dag Local Tax', 'numeric');
        $this->form_validation->set_rules('dag_n_desc', 'Dag N Desc', 'max_length[50]');
        $this->form_validation->set_rules('dag_s_desc', 'Dag S Desc', 'max_length[50]');
        $this->form_validation->set_rules('dag_e_desc', 'Dag E Desc', 'max_length[50]');
        $this->form_validation->set_rules('dag_w_desc', 'Dag W Desc', 'max_length[50]');
        $this->form_validation->set_rules('dag_n_dag_no', 'Dag N Dag No', 'max_length[12]');
        $this->form_validation->set_rules('dag_s_dag_no', 'Dag S Dag No', 'max_length[12]');
        $this->form_validation->set_rules('dag_e_dag_no', 'Dag E Dag No', 'max_length[12]');
        $this->form_validation->set_rules('dag_w_dag_no', 'Dag W Dag No', 'max_length[12]');
        $this->form_validation->set_rules('dag_nlrg_no', 'Dag Nlrg No', 'max_length[40]');
        $this->form_validation->set_rules('dp_flag_yn', 'Dp Flag Yn', 'max_length[1]');
        $this->form_validation->set_rules('user_code', 'User Code', 'required|max_length[5]');
        $this->form_validation->set_rules('date_entry', 'Date Entry', 'required');
        $this->form_validation->set_rules('operation', 'Operation', 'required|max_length[1]');
        $this->form_validation->set_rules('jama_yn', 'Jama Yn', 'max_length[1]');
        $this->form_validation->set_rules('status', 'Status', 'max_length[1]');
        $this->form_validation->set_rules('old_patta_no', 'Old Patta No', 'max_length[20]');
        $this->form_validation->set_rules('dag_name', 'Dag Name', 'max_length[100]');
        $this->form_validation->set_rules('dag_dept_name', 'Dag Dept Name', 'max_length[100]');
        //var_dump($this->form_validation->error());
        //var_dump($_POST);
        //var_dump($this->form_validation->run());
        if ($this->form_validation->run()) {
            $params = array(
                'dist_code' => $this->input->post('dist_code'),
                'subdiv_code' => $this->input->post('subdiv_code'),
                'cir_code' => $this->input->post('cir_code'),
                'mouza_pargona_code' => $this->input->post('mouza_pargona_code'),
                'lot_no' => $this->input->post('lot_no'),
                'vill_townprt_code' => $this->input->post('vill_townprt_code'),
                'old_dag_no' => $this->input->post('old_dag_no'),
                'dag_no' => $this->input->post('dag_no'),
                'patta_type_code' => $this->input->post('patta_type_code'),
                'patta_no' => $this->input->post('patta_no'),
                'land_class_code' => $this->input->post('land_class_code'),
                'dag_area_b' => $this->input->post('dag_area_b'),
                'dag_area_k' => $this->input->post('dag_area_k'),
                'dag_area_lc' => $this->input->post('dag_area_lc'),
                'dag_area_g' => $this->input->post('dag_area_g'),
                'dag_area_kr' => $this->input->post('dag_area_kr'),
                //'dag_area_are' => $this->input->post('dag_area_are'),
                'dag_revenue' => $this->input->post('dag_revenue'),
                'dag_local_tax' => $this->input->post('dag_local_tax'),
                //'dag_no_map' => $this->input->post('dag_no_map'),
                'dag_n_desc' => $this->input->post('dag_n_desc'),
                'dag_s_desc' => $this->input->post('dag_s_desc'),
                'dag_e_desc' => $this->input->post('dag_e_desc'),
                'dag_w_desc' => $this->input->post('dag_w_desc'),
                'dag_n_dag_no' => $this->input->post('dag_n_dag_no'),
                'dag_s_dag_no' => $this->input->post('dag_s_dag_no'),
                'dag_e_dag_no' => $this->input->post('dag_e_dag_no'),
                'dag_w_dag_no' => $this->input->post('dag_w_dag_no'),
                'dag_nlrg_no' => $this->input->post('dag_nlrg_no'),
                //'dp_flag_yn' => $this->input->post('dp_flag_yn'),
                'user_code' => $this->input->post('user_code'),
                'date_entry' => $this->input->post('date_entry'),
                'operation' => $this->input->post('operation'),
                'jama_yn' => $this->input->post('jama_yn'),
                'status' => $this->input->post('status'),
                'old_patta_no' => $this->input->post('old_patta_no'),
                    //'dag_name' => $this->input->post('dag_name'),
                    //'dag_dept_name' => $this->input->post('dag_dept_name'),
            );
            $sql = "select dag_no from    chitha_basic where dist_code='$params[dist_code]' and subdiv_code='$params[subdiv_code]' and cir_code='$params[cir_code]' and 
			mouza_pargona_code='$params[mouza_pargona_code]'  and lot_no='$params[lot_no]' and vill_townprt_code='$params[vill_townprt_code]' and dag_no='$params[dag_no]' ";
            $query = $this->db->query($sql);
            $count = $query->num_rows();
            if ($count != 0) {
                $this->session->set_flashdata('message', "Dag Number $params[dag_no] exists in database ");
                redirect('chitha_basic_deo/index');
            }
            $sql = "select dag_no from    chitha_basic_entry where dist_code='$params[dist_code]' and subdiv_code='$params[subdiv_code]' and cir_code='$params[cir_code]' and 
			mouza_pargona_code='$params[mouza_pargona_code]'  and lot_no='$params[lot_no]' and vill_townprt_code='$params[vill_townprt_code]' and dag_no='$params[dag_no]' ";
            $query = $this->db->query($sql);
            $count = $query->num_rows();
            if ($count != 0) {
                $this->session->set_flashdata('message', "You Have Allready Inserted $params[dag_no] exists in database ");
                redirect('chitha_basic_deo/index');
            }
            $this->session->set_userdata('basic_entry', $params);
            redirect('chitha_basic_deo/add');
        } else {
            // $this->load->view('../views/chitha_basic/header');
            // $this->load->view('../views/chitha_basic/add', $data);
            // $this->load->view('../views/footer');

            $data['_view'] = 'chitha_basic/add';
            $this->load->view('layouts/main',$data);
        }
    }

    function add() {
		 // $db=  $this->session->userdata('db');
        $this->load->library('form_validation');
        //var_dump($this->session->all_userdata());
        $q = "Select gen_name_ass,short_name from    master_gender";
        $data['gender'] = $this->db->query($q)->result();
        $q = "Select guard_rel,guard_rel_desc_as from    master_guard_rel where guard_rel!=' '";
        $data['relation'] = $this->db->query($q)->result();
        $this->form_validation->set_rules('dist_code', 'Dist Code', 'required|max_length[2]');
        $this->form_validation->set_rules('subdiv_code', 'Subdiv Code', 'required|max_length[2]');
        $this->form_validation->set_rules('cir_code', 'Cir Code', 'required|max_length[2]');
        $this->form_validation->set_rules('mouza_pargona_code', 'Mouza Pargona Code', 'required|max_length[2]');
        $this->form_validation->set_rules('lot_no', 'Lot No', 'required|max_length[2]');
        $this->form_validation->set_rules('vill_townprt_code', 'Vill Townprt Code', 'required|max_length[5]');
        //$this->form_validation->set_rules('pdar_id','Pdar Id','required');
        $this->form_validation->set_rules('patta_no', 'Patta No', 'required|max_length[20]');
        $this->form_validation->set_rules('patta_type_code', 'Patta Type Code', 'required|max_length[4]');
        $this->form_validation->set_rules('pdar_name', 'Pdar Name', 'required|max_length[100]');
        $this->form_validation->set_rules('pdar_father', 'Pdar Father', 'required|max_length[100]');
        $this->form_validation->set_rules('pdar_add1', 'Pdar Add1', 'max_length[100]');
        $this->form_validation->set_rules('pdar_add2', 'Pdar Add2', 'max_length[100]');
        $this->form_validation->set_rules('pdar_add3', 'Pdar Add3', 'max_length[100]');
        $this->form_validation->set_rules('pdar_pan_no', 'Pdar Pan No', 'max_length[12]');
        $this->form_validation->set_rules('pdar_citizen_no', 'Pdar Citizen No', 'max_length[21]');
        $this->form_validation->set_rules('pdar_guard_reln', 'Pdar Guard Reln', 'max_length[1]');
        $this->form_validation->set_rules('dag_por_b', 'Dag Por B', 'required');
        $this->form_validation->set_rules('dag_por_k', 'Dag Por K', 'required');
        $this->form_validation->set_rules('dag_por_lc', 'Dag Por Lc', 'required|numeric');
        $this->form_validation->set_rules('pdar_land_revenue', 'Pdar Land Revenue', 'required|numeric');
        $this->form_validation->set_rules('pdar_land_localtax', 'Pdar Land Localtax', 'required|numeric');
        $this->form_validation->set_rules('pdar_land_n', 'Pdar Land N', 'max_length[50]');
        $this->form_validation->set_rules('pdar_land_s', 'Pdar Land S', 'max_length[50]');
        $this->form_validation->set_rules('pdar_land_e', 'Pdar Land E', 'max_length[50]');
        $this->form_validation->set_rules('pdar_land_w', 'Pdar Land W', 'max_length[50]');
        $this->form_validation->set_rules('new_pdar_name', 'New Pdar Name', 'max_length[2]');
        $this->form_validation->set_rules('pdar_gender', 'Pdar Gender', 'max_length[1]');
        $this->form_validation->set_rules('pdar_minor_yn', 'Pdar Minor Yn', 'max_length[1]|required');
        $this->form_validation->set_rules('pdar_minor_dob', 'Pdar Minor Dob', '');
        $this->form_validation->set_rules('pdar_mother', 'Pdar Mother', 'max_length[100]');
        $this->form_validation->set_rules('pdar_aadharno', 'Pdar Aadharno', 'max_length[20]');
        $this->form_validation->set_rules('pdar_mobile', 'Pdar Mobile', 'max_length[13]');
        $this->form_validation->set_rules('pdar_nrcno', 'Pdar Nrcno', 'max_length[20]');


        /////////////
        $this->form_validation->set_rules('user_code', 'User Code', 'required|max_length[5]');
        $this->form_validation->set_rules('date_entry', 'Date Entry', 'required');
        $this->form_validation->set_rules('operation', 'Operation', 'required|max_length[1]');
        $this->form_validation->set_rules('p_flag', 'P Flag', 'max_length[1]');
        $this->form_validation->set_rules('jama_yn', 'Jama Yn', 'max_length[1]');

        if ($this->form_validation->run()) {
            if ($this->input->post('pdar_minor_dob') == null) {
                $minor = '1970-01-01';
            } else {
                $minor = $this->input->post('pdar_minor_dob');
            }
            $params = array(
                'dist_code' => $this->input->post('dist_code'),
                'subdiv_code' => $this->input->post('subdiv_code'),
                'cir_code' => $this->input->post('cir_code'),
                'mouza_pargona_code' => $this->input->post('mouza_pargona_code'),
                'lot_no' => $this->input->post('lot_no'),
                'vill_townprt_code' => $this->input->post('vill_townprt_code'),
                'patta_no' => $this->input->post('patta_no'),
                'patta_type_code' => $this->input->post('patta_type_code'),
                'pdar_name' => $this->input->post('pdar_name'),
                'pdar_father' => $this->input->post('pdar_father'),
                'pdar_add1' => $this->input->post('pdar_add1'),
                'pdar_add2' => $this->input->post('pdar_add2'),
                'pdar_add3' => $this->input->post('pdar_add3'),
                'pdar_pan_no' => $this->input->post('pdar_pan_no'),
                'pdar_citizen_no' => $this->input->post('pdar_citizen_no'),
                //'pdar_thumb_imp' => $this->input->post('pdar_thumb_imp'),
                //'pdar_photo' => $this->input->post('pdar_photo'),
                'user_code' => $this->input->post('user_code'),
                'date_entry' => $this->input->post('date_entry'),
                'operation' => $this->input->post('operation'),
                'jama_yn' => $this->input->post('jama_yn'),
                'pdar_guard_reln' => $this->input->post('pdar_guard_reln'),
                'f1_case_no' => $this->input->post('f1_case_no'),
                'f2_case_no' => $this->input->post('f2_case_no'),
                'o1_case_no' => $this->input->post('o1_case_no'),
                'o2_case_no' => $this->input->post('o2_case_no'),
                'new_pdar_name' => $this->input->post('new_pdar_name'),
                'pdar_gender' => $this->input->post('pdar_gender'),
                'pdar_minor_yn' => $this->input->post('pdar_minor_yn'),
                'pdar_minor_dob' => $minor,
                'pdar_mother' => $this->input->post('pdar_mother'),
                'pdar_aadharno' => $this->input->post('pdar_aadharno'),
                'pdar_mobile' => $this->input->post('pdar_mobile'),
                'pdar_nrcno' => $this->input->post('pdar_nrcno'),
            );
            $this->Chitha_basic_model->add_chitha_pattadar($params);
            $params = array(
                'dist_code' => $this->input->post('dist_code'),
                'subdiv_code' => $this->input->post('subdiv_code'),
                'cir_code' => $this->input->post('cir_code'),
                'mouza_pargona_code' => $this->input->post('mouza_pargona_code'),
                'lot_no' => $this->input->post('lot_no'),
                'vill_townprt_code' => $this->input->post('vill_townprt_code'),
                'dag_no' => $this->input->post('dag_no'),
                'patta_no' => $this->input->post('patta_no'),
                'patta_type_code' => $this->input->post('patta_type_code'),
                'dag_por_b' => $this->input->post('dag_por_b'),
                'dag_por_k' => $this->input->post('dag_por_k'),
                'dag_por_lc' => $this->input->post('dag_por_lc'),
                'dag_por_g' => $this->input->post('dag_por_g'),
                'dag_por_kr' => $this->input->post('dag_por_kr'),
                'pdar_land_n' => $this->input->post('pdar_land_n'),
                'pdar_land_s' => $this->input->post('pdar_land_s'),
                'pdar_land_e' => $this->input->post('pdar_land_e'),
                'pdar_land_w' => $this->input->post('pdar_land_w'),
                //'pdar_land_map' => $this->input->post('pdar_land_map'),
                //'pdar_land_acre' => $this->input->post('pdar_land_acre'),
                'pdar_land_revenue' => $this->input->post('pdar_land_revenue'),
                'pdar_land_localtax' => $this->input->post('pdar_land_localtax'),
                'user_code' => $this->input->post('user_code'),
                'date_entry' => $this->input->post('date_entry'),
                'operation' => $this->input->post('operation'),
                'p_flag' => $this->input->post('p_flag'),
                'jama_yn' => $this->input->post('jama_yn'),
            );
            $this->Chitha_basic_model->add_dag_pattadar($params);
            redirect('chitha_basic_deo/more');
        } else {
            // $this->load->view('../views/chitha_basic/header');
            // $this->load->view('../views/chitha_basic/add_pattadar', $data);
            // $this->load->view('../views/footer');

            $data['_view'] = 'chitha_basic/add_pattadar';
            $this->load->view('layouts/main',$data);
        }
    }

    function more() {
		  // $db=  $this->session->userdata('db');
    //     $this->load->view('../views/chitha_basic/header');
    //     $this->load->view('../views/chitha_basic/addmoresecapplicant');
    //     $this->load->view('../views/footer');

        $data['_view'] = 'chitha_basic/addmoresecapplicant';
        $this->load->view('layouts/main',$data);
    }

    function finalSave() {
		  // $db=  $this->session->userdata('db');
    //     $this->load->view('../views/chitha_basic/header');
    //     $this->load->view('../views/chitha_basic/finalconfirm');
    //     $this->load->view('../views/footer');

        $data['_view'] = 'chitha_basic/finalconfirm';
        $this->load->view('layouts/main',$data);
    }

    function FinalSubmit() {
		 // $db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        if ($this->session->userdata('basic_entry')) {
            $this->db->trans_begin();
            $dist_code = $this->session->userdata['basic_entry']['dist_code'];
            $subdiv_code = $this->session->userdata['basic_entry']['subdiv_code'];
            $cir_code = $this->session->userdata['basic_entry']['cir_code'];
            $mouza_pargona_code = $this->session->userdata['basic_entry']['mouza_pargona_code'];
            $lot_no = $this->session->userdata['basic_entry']['lot_no'];
            $vill_townprt_code = $this->session->userdata['basic_entry']['vill_townprt_code'];
            $patta_type_code = $this->session->userdata['basic_entry']['patta_type_code'];
            $patta_no = $this->session->userdata['basic_entry']['patta_no'];
            $dag_no = $this->session->userdata['basic_entry']['dag_no'];
            $sql = "Select max(pdar_id)+1 as pdar_id from    chitha_dag_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and 
				mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and dag_no='$dag_no' and patta_no='$patta_no' and patta_type_code='$patta_type_code' ";

            $pdar_id = $this->db->query($sql)->row()->pdar_id;
            if ($pdar_id == null) {
                $pdar_id = 1;
            }
            $basic = $this->session->userdata('basic_entry');
            $dagpattadar = $this->session->userdata('dagpattadar');
            $pattadar = $this->session->userdata('pattadar');
            $basic['dag_no_int'] = $dag_no . "00";
            $this->db->insert('chitha_basic_entry', $basic);
            foreach ($pattadar as $key => $p) {
                $p['pdar_id'] = $pdar_id;
                $dagpattadar[$key]['pdar_id'] = $pdar_id;
                $dagpattadar[$key]['p_flag'] = 0;
                $this->db->insert('chitha_dag_pattadar_entry', $dagpattadar[$key]);
                //var_dump($p);
                /////////Check this line//////
                $q = "SElect pdar_id from    chitha_pattadar_entry  where dist_code='$p[dist_code]' and"
                        . " subdiv_code='$p[subdiv_code]' and cir_code='$p[cir_code]'"
                        . " and lot_no='$p[lot_no]' and mouza_pargona_code='$p[mouza_pargona_code]' and "
                        . " vill_townprt_code='$p[vill_townprt_code]' "
                        . " and TRIM(patta_no)=trim('$p[patta_no]') and patta_type_code='$p[patta_type_code]' and pdar_id='$pdar_id' ";
                $exist = $this->db->query($q)->row();
                if ($exist == null) {
                    $this->db->insert('chitha_pattadar_entry', $p);
                }
                //var_dump($p);
                $pdar_id++;
            }
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                show_error('Error !!! Please contact System Administrator !!');
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Data inserted Successfully. Dag Number $dag_no and Patta Number $patta_no ");
                redirect('/home');
            }
        }
    }

    /*
     * Editing a chitha_basic
     */


    /*
     * CO List
     */

    function listAll() {
		 // $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $sql = "SElect * from    chitha_basic_entry where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and chitha_update is null ";
        $data['basic'] = $this->db->query($sql)->result();
        // $this->load->view('../views/header');
        // $this->load->view('../views/chitha_basic/listAll', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'chitha_basic/listAll';
        $this->load->view('layouts/main',$data);
    }

    function coview() {
		//  $db=  $this->session->userdata('db');
        $d = $this->input->get('d');
        $s = $this->input->get('s');
        $c = $this->input->get('c');
        $m = $this->input->get('m');
        $l = $this->input->get('l');
        $v = $this->input->get('v');
        $p = $this->input->get('p');
        $dg = $this->input->get('dg');
        $pc = $this->input->get('pc');
        $cn = $this->input->get('cn');
        $sql = "Select * from    chitha_basic_entry where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$m' and 
			lot_no='$l' and vill_townprt_code='$v' and dag_no='$dg' and patta_no='$p' and patta_type_code='$pc' ";
        $basic = $this->db->query($sql)->row();
        $this->session->set_userdata('basic_entry', $basic);
        $sql = "Select * from    chitha_pattadar_entry where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$m' and 
			lot_no='$l' and vill_townprt_code='$v' and patta_no='$p' and patta_type_code='$pc' ";
        $pattadar = $this->db->query($sql)->result();
        $this->session->set_userdata('pattadar', $pattadar);
        $this->session->set_userdata('popup_control', $cn);
        $this->load->view('../views/chitha_basic/coconfirm');
    }

    function coconfirm() {
		 // $db=  $this->session->userdata('db');
        if (isset($_POST)) {
            //var_dump($_POST);
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->input->post('mouza_pargona_code');
            $lot_no = $this->input->post('lot_no');
            $vill_townprt_code = $this->input->post('vill_townprt_code');
            $dag_no = $this->input->post('dag_no');
            $patta_no = $this->input->post('patta_no');
            $patta_type_code = $this->input->post('patta_type_code');
            $status = $this->input->post('status');
            $reason = $this->input->post('reason');
            $user_code = $this->session->userdata('user_code');
            $this->db->trans_begin();
            if ($status == '2') {
               $delete = "DELETE FROM chitha_basic_entry where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'"
                    . "and mouza_pargona_code = '$mouza_pargona_code' and vill_townprt_code = '$vill_townprt_code' "
                    . "and lot_no = '$lot_no'  and patta_no='$patta_no' and patta_type_code='$patta_type_code' and dag_no='$dag_no'";
					$this->db->query($delete);	
					
				$chitha_dag_pattadar_entry_delete = "DELETE FROM chitha_dag_pattadar_entry where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'"
				. "and mouza_pargona_code = '$mouza_pargona_code' and vill_townprt_code = '$vill_townprt_code' "
				. "and lot_no = '$lot_no'  and patta_no='$patta_no' and patta_type_code='$patta_type_code'";
				$this->db->query($chitha_dag_pattadar_entry_delete);
			
			   $chitha_pattadar_entry_delete = "DELETE FROM chitha_pattadar_entry where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'"
				. "and mouza_pargona_code = '$mouza_pargona_code' and vill_townprt_code = '$vill_townprt_code' "
				. "and lot_no = '$lot_no'  and patta_no='$patta_no' and patta_type_code='$patta_type_code'";
				$this->db->query($chitha_pattadar_entry_delete);
				$msg="Records Updated !!!";
            }
            if ($status == '1') {

                $sql = "Select * from    chitha_basic_entry where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and "
                        . "lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and dag_no='$dag_no' and patta_no='$patta_no' and patta_type_code='$patta_type_code' ";
                $basic = $this->db->query($sql)->row_array();
                unset($basic['co_user_code']);
                unset($basic['chitha_update']);
                unset($basic['chitha_udate_date']);
                unset($basic['dispose_reason']);
                //var_dump($basic);
                // $this->db->insert('chitha_basic', $basic);
                $return=$this->Chitha_basic_model->insert_table('chitha_basic',$basic);
                if($return==0){
                  $this->db->trans_rollback();
                  log_message('error',"#001".$this->db->last_query());
                  $this->session->set_flashdata('message',"Error In Processing #001");
                  redirect('chitha_basic_deo/listAll');
                }
                ////// pattadar
                  $sql = "Select max(cast (pdar_id as integer))+1 as num from    jama_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and "
                                  . "lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and patta_no='$patta_no' and patta_type_code='$patta_type_code' ";
                  $num_rows_jama = $this->db->query($sql)->row()->num;
                 //echo "----"; 
                 $sql = "Select max(cast (pdar_id as integer))+1 as num from    chitha_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and "
                         . "lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and patta_no='$patta_no' and patta_type_code='$patta_type_code' ";
                 $num_rows_chitha = $this->db->query($sql)->row()->num;
                 //echo "----"; 
                 if($num_rows_jama > $num_rows_chitha){
                     $num_rows = $num_rows_jama;
                 } else {
                     $num_rows = $num_rows_chitha;
                 }
                 $start=true;
                 $sql = "Select * from    chitha_pattadar_entry where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and "
                        . "lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and patta_no='$patta_no' and patta_type_code='$patta_type_code' ";
                 $pattadar = $this->db->query($sql)->result_array();
                foreach($pattadar as $pap){
                      if($start==true){
                        $num_rows=$num_rows;
                        if($num_rows==null){
                           $num_rows=1;
                        }
                      }else{
                        $num_rows=$num_rows+1;
                      }

                      $start=false;
                      $sql = "Select * from chitha_dag_pattadar_entry where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and "
                        . "lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and dag_no='$dag_no' and patta_no='$patta_no' and patta_type_code='$patta_type_code' and pdar_id=$pap[pdar_id] ";
                      $dagpattadarQuery = $this->db->query($sql);
                      if($dagpattadarQuery->num_rows()==0)
                           continue;
                      $dagpattadar=$dagpattadarQuery->row_array();
                      //echo $num_rows;
                      $dagpattadar['pdar_id']=$num_rows;  
                      // echo "<pre>";
                      // var_dump($dagpattadar);
                      if($patta_no==0){
                        $dagpattadar['pdar_id']='1';
                      }
                    //   $this->db->insert('chitha_dag_pattadar', $dagpattadar);
                      $return=$this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$dagpattadar);
                      if($return==0){
                           $this->db->trans_rollback();
                           log_message('error',"#002".$this->db->last_query());
                           $this->session->set_flashdata('message',"Error In Processing #002");
                           redirect('chitha_basic_deo/listAll');
                      }
                      $pap['pdar_id']=$num_rows;
                      if($patta_no!=0){
                        //  $this->db->insert('chitha_pattadar', $pap);
                        // $pap['f1_case_no']=$case_no;
                        $return=$this->Chitha_basic_model->insert_table('chitha_pattadar',$pap);
                        if($return==0){
                            $this->db->trans_rollback();
                            log_message('error',"#003".$this->db->last_query());
                            $this->session->set_flashdata('message',"Error In Processing #003");
                            redirect('chitha_basic_deo/listAll');
                        }
                      } 
                }
                ////////////dag pattadar
                $array = array(
                    'co_user_code' => $user_code,
                    'chitha_update' => 'Y',
                    'chitha_udate_date' => date('Y-m-d'),
                    'status' => $status
                );
                $this->db->where('dag_no', $dag_no);
                $this->db->where('patta_no', $patta_no);
                $this->db->where('patta_type_code', $patta_type_code);
                $this->db->where('vill_townprt_code', $vill_townprt_code);
                $this->db->where('lot_no', $lot_no);
                $this->db->where('mouza_pargona_code', $mouza_pargona_code);
                $this->db->where('cir_code', $cir_code);
                $this->db->where('subdiv_code', $subdiv_code);
                $this->db->where('dist_code', $dist_code);
                $this->db->update('chitha_basic_entry', $array);
                if($this->db->affected_rows!=1){
                  log_message('error',"#004".$this->db->last_query());
                  $this->session->set_flashdata('message',"Error In Processing #004");
                }
            }
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                show_error('The chitha_basic you are trying to delete does not exist.');
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('message', 'Data Inserted in Chitha Successfully !!');
                redirect('chitha_basic_deo/listAll');
            }
        }
    }

    /*
     * Deleting chitha_basic
     */

    function remove($dag_no_int) {
		  $db=  $this->session->userdata('db');
        $chitha_basic = $this->Chitha_basic_model->get_chitha_basic($dag_no_int);

        // check if the chitha_basic exists before trying to delete it
        if (isset($chitha_basic['dag_no_int'])) {
            $this->Chitha_basic_model->delete_chitha_basic($dag_no_int);
            redirect('chitha_basic/index');
        } else
            show_error('The chitha_basic you are trying to delete does not exist.');
    }


    public function coIndex()
    {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        if (isset($_SESSION['basic_entry'])) {
            unset($_SESSION['dagpattadar']);
            unset($_SESSION['pattadar']);
            unset($_SESSION['basic_entry']);
        }

        $sql = "Select * from     chitha_basic_entry where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
        $data['basic'] = $this->db->query($sql)->result();

        $data['_view'] = 'chitha_basic/co_list';
        $this->load->view('layouts/main', $data);
    }

}
