<?php

class Allotment extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
        $this->load->model('patta/pattamodel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->model('basundhara/basundharamodel');
        $this->load->model('rtps/rtpsmodel');
        $this->load->model('AdcMappingWithCircleModel','circleMappingModel');

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
        if((RTPS_CERT_ON_OFF=='1') && (($this->session->userdata('dist_code')!='15') && ($this->session->userdata('subdiv_code')!='01') && ($this->session->userdata('cir_code')!='03'))){ 
            $this->session->set_flashdata('message', 'Not Authorised');
            redirect(base_url() . "index.php/home/index");
            return; 
        }     
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $district['mouza'] = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
        $district['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name
        );
        $this->form_validation->set_rules('mouza_code', 'Mouza Code', 'trim|required|numeric');
        $this->form_validation->set_rules('lot_no', 'Lot No', 'trim|required|numeric');
        $this->form_validation->set_rules('vill_code', 'Village Code', 'trim|required|numeric');
        if ($this->form_validation->run() == FALSE) {
            // $this->load->view('../views/header');
            // $this->load->view('../views/allotment/ast_n_one', $district);
            // $this->load->view('../views/footer');
            $district['_view'] = 'allotment/ast_n_one';
            $this->load->view('layouts/main',$district);
        } else {
            $location = array(
                'mouza_pargona_code' => $this->input->post('mouza_code'),
                'lot_no' => $this->input->post('lot_no'),
                'vill_code' => $this->input->post('vill_code'),
                'vill_townprt_code' => $this->input->post('vill_code')
            );
            $this->session->set_userdata($location);
            redirect(base_url() . 'index.php/Allotment/addpattadar');
        }
    }
    function addpattadar() {
        $query = "select * from master_guard_rel ";
        $district['relationship'] = $this->db->query($query)->result();
        $sql = "Select * from master_caste";
        $district['caste_name'] = $this->db->query($sql)->result();
        $sql = "Select * from master_gender";
        $district['gender'] = $this->db->query($sql)->result();
        if($this->input->post('name_stat')=='I'){
             $this->form_validation->set_rules('gurdian_name', 'Guardian Name', 'trim|required|min_length[5]|max_length[50]');
            $this->form_validation->set_rules('caste', 'Caste', 'trim|required');
            $this->form_validation->set_rules('relation', 'Relationship', 'required');
            $this->form_validation->set_rules('age', 'Age', 'trim|required|numeric');
        }
        $this->form_validation->set_rules('applicant_name', 'Applicant Name', 'trim|required|min_length[5]|max_length[50]');
       
        $this->form_validation->set_rules('mobile_no', 'Mobile Number', 'trim|required|numeric');
        if ($this->form_validation->run() == FALSE) {
            $district['_view'] = 'allotment/addpattadar';
            $this->load->view('layouts/main',$district);
        } else {
            $applicant_name = $this->input->post('applicant_name');
            $org_indv=$this->input->post('name_stat');
            if($org_indv=='O'){
                $gurdian_name = 'NA';
                $relation = 'n';
                $age = null;
                $gender = '4'; // id=4 -> 'Not Applicable'
                $caste = '7';  // caste_id=7-> 'NA'
                $applicant_hus_wife ='NA';
            }else{
                $gurdian_name = $this->input->post('gurdian_name');
                $relation = $this->input->post('relation');
                $age = $this->input->post('age');
                $gender = $this->input->post('gender');
                $caste = $this->input->post('caste');
                $applicant_hus_wife = $this->input->post('applicant_hus_wife');
            }
            
            $mobile_no = $this->input->post('mobile_no');
            $pan = $this->input->post('pan');
            if ($applicant_hus_wife == 'y') {
                $name_hus_wife = $this->input->post('name_hus_wife');
            } else {
                $name_hus_wife = '';
            }
            $applicant = array(
                'alotee_name' => $applicant_name,
                'alotee_gender' => $gender,
                'alotee_age' => $age,
                'alotee_gurdian' => $gurdian_name,
                'alotee_reln' => $relation,
                'alotee_caste' => $caste,
                'alotee_hus_wife' => $applicant_hus_wife,
                'name_alotee_h_w' => $name_hus_wife,
                'alotee_nationality' => 'Indian', //$nationality,
                'alotee_mobile' => $mobile_no,
                'alotee_pan_card' => $pan
            );
            if (!$this->session->userdata('mut_petitioner')) {
                $this->session->set_userdata('mut_petitioner', array());
                $mut_petitioner = $this->session->userdata('mut_petitioner');
                $mut_petitioner[] = $applicant;
                $this->session->set_userdata('mut_petitioner', $mut_petitioner);
            } else {
                $mut_petitioner = $this->session->userdata('mut_petitioner');
                $mut_petitioner[] = $applicant;
                $this->session->set_userdata('mut_petitioner', $mut_petitioner);
            }
            redirect(base_url() . 'index.php/Allotment/addmoreapplicant');
            //$this->addmoreapplicant();
        }
    }
    // function addpattadar() {
          // $db=  $this->session->userdata('db');
    //     $query = "select * from    master_guard_rel ";
    //     $district['relationship'] = $this->db->query($query)->result();
    //     $sql = "Select * from    master_caste";
    //     $district['caste_name'] = $this->db->query($sql)->result();
    //     $sql = "Select * from    master_gender";
    //     $district['gender'] = $this->db->query($sql)->result();
    //     $this->form_validation->set_rules('applicant_name', 'Applicant Name', 'trim|required|min_length[5]|max_length[50]');
    //     $this->form_validation->set_rules('gurdian_name', 'Guardian Name', 'trim|required|min_length[5]|max_length[50]');
    //     $this->form_validation->set_rules('caste', 'Caste', 'trim|required');
    //     $this->form_validation->set_rules('relation', 'Relationship', 'required');
    //     $this->form_validation->set_rules('age', 'Age', 'trim|required|numeric');
    //     $this->form_validation->set_rules('mobile_no', 'Mobile Number', 'trim|required|numeric');
    //     if ($this->form_validation->run() == FALSE) {
    //         // $this->load->view('../views/header');
    //         // $this->load->view('../views/allotment/addpattadar', $district);
    //         // $this->load->view('../views/footer');
    //         $district['_view'] = 'allotment/addpattadar';
    //         $this->load->view('layouts/main',$district);
    //     } else {
    //         $applicant_name = $this->input->post('applicant_name');
    //         $gurdian_name = $this->input->post('gurdian_name');
    //         $relation = $this->input->post('relation');
    //         $age = $this->input->post('age');
    //         $gender = $this->input->post('gender');
    //         $caste = $this->input->post('caste');
    //         $applicant_hus_wife = $this->input->post('applicant_hus_wife');
    //         $mobile_no = $this->input->post('mobile_no');
    //         $pan = $this->input->post('pan');
    //         if ($applicant_hus_wife == 'y') {
    //             $name_hus_wife = $this->input->post('name_hus_wife');
    //         } else {
    //             $name_hus_wife = '';
    //         }
    //         $applicant = array(
    //             'alotee_name' => $applicant_name,
    //             'alotee_gender' => $gender,
    //             'alotee_age' => $age,
    //             'alotee_gurdian' => $gurdian_name,
    //             'alotee_reln' => $relation,
    //             'alotee_caste' => $caste,
    //             'alotee_hus_wife' => $applicant_hus_wife,
    //             'name_alotee_h_w' => $name_hus_wife,
    //             'alotee_nationality' => 'Indian', //$nationality,
    //             'alotee_mobile' => $mobile_no,
    //             'alotee_pan_card' => $pan
    //         );
    //         if (!$this->session->userdata('mut_petitioner')) {
    //             $this->session->set_userdata('mut_petitioner', array());
    //             $mut_petitioner = $this->session->userdata('mut_petitioner');
    //             $mut_petitioner[] = $applicant;
    //             $this->session->set_userdata('mut_petitioner', $mut_petitioner);
    //         } else {
    //             $mut_petitioner = $this->session->userdata('mut_petitioner');
    //             $mut_petitioner[] = $applicant;
    //             $this->session->set_userdata('mut_petitioner', $mut_petitioner);
    //         }
    //         redirect(base_url() . 'index.php/Allotment/addmoreapplicant');
    //         //$this->addmoreapplicant();
    //     }
    // }

    function addmoreapplicant() {
          // $db=  $this->session->userdata('db');
    //     $this->load->view('../views/header');
    //     $this->load->view('../views/allotment/addmoreapplicant');
    //     $this->load->view('../views/footer');
        $district['_view'] = 'allotment/addmoreapplicant';
        $this->load->view('layouts/main',$district);
    }

    function landcert() {
        //var_dump($this->session->all_userdata());
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code');
        ////////Govt Dag////
        $q = "Select dag_no,dag_no_int as p from chitha_basic where dist_code='$dist_code' and 
        subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' 
        and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and patta_no='0'  order by dag_no_int ";
        $district['govt_dag']=$this->db->query($q)->result();
        ///////////////////
        $sql = "Select * from allote_scheme_name";
        $district['scheme_name'] = $this->db->query($sql)->result();
        $district['_view'] = 'allotment/landarea';
        $this->load->view('layouts/main',$district);
    }

    function detailslandarea() {
          $db=  $this->session->userdata('db');
        if (isset($_FILES['filename']) && $_FILES['filename']['name'] != '') {
            //var_dump($_FILES);
            $filename = $_FILES['filename']['name'];
            $ext = explode('.', $filename);
            $extension = strtolower($ext[1]);
            //$type = strtolower($_FILES['filename']['type']);
            $size = $_FILES['filename']['size'];
            $this->form_validation->set_rules('certificate_no', 'Certificate Number', 'required');
            $this->form_validation->set_rules('cert_date', 'Certificate Date', 'required');
            $this->form_validation->set_rules('alot_under', 'Allotment Under', 'required');
            $this->form_validation->set_rules('alot_whos_name', 'Allotee Name', 'required');
            $this->form_validation->set_rules('dag_no', 'Dag Number', 'required');
            $this->form_validation->set_rules('type_govt_land', 'Govt land Type', 'required');
            $this->form_validation->set_rules('alot_whos_name', 'Allotee Name', 'required');
            $this->form_validation->set_rules('tot_bigha', 'Total Bigha', 'required');
            $this->form_validation->set_rules('tot_katha', 'Total Katha', 'required');
            $this->form_validation->set_rules('tot_lessa', 'Total Lessa', 'required');
            $this->form_validation->set_rules('alot_bigha', 'Alloted Bigha', 'required');
            $this->form_validation->set_rules('alot_katha', 'Alloted Katha', 'required');
            $this->form_validation->set_rules('alot_lessa', 'Alloted Lessa', 'required');


            if (($this->form_validation->run() == FALSE) || ($size > 5000000) || ($extension != 'pdf')) {
                //echo $size;
                //echo $extension;
                $sql = "Select * from    allote_scheme_name";
                $district['scheme_name'] = $this->db->query($sql)->result();
                if ($size > 5000000) {
                    $district['error'] = "Only PDF File Allowed or Size";
                }
                // $this->load->view('../views/header');
                // $this->load->view('../views/allotment/landarea', $district);
                // $this->load->view('../views/footer');
                $district['_view'] = 'allotment/landarea';
                $this->load->view('layouts/main',$district);
            } else {
                $this->db->trans_start();
                $year_no = year_no;
                $user_code = $this->session->userdata('user_code');
                $dist_code = $this->session->userdata('dist_code');
                $subdiv_code = $this->session->userdata('subdiv_code');
                $cir_code = $this->session->userdata('cir_code');
                $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
                $lot_no = $this->session->userdata('lot_no');
                $vill_townprt_code = $this->session->userdata('vill_townprt_code');
                // $q = "Select max(petition_no)+1 as p from    allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and year_no='$year_no' ";
                // $petition_no = $this->db->query($q)->row()->p;
                // if ($petition_no == null) {
                //     $petition_no = $petition_no + 1;
                // }
                // $q = "Select dist_abbr,cir_abbr from    location where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code!='00' ";
                // $abbrname = $this->db->query($q)->row();
                // $cir_dist_name = $abbrname->dist_abbr . "/" . $abbrname->cir_abbr;
                // $financialyeardate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('y') : date('Y') . "-" . date('y', strtotime('+1 year'));
                // $case_no = $cir_dist_name . "/" . $financialyeardate . "/" . $petition_no . "/ACPP";
                $case_name=$this->basundharamodel->genearteCaseName();
                $case_no['petition_no']=$petition_no=$this->basundharamodel->genearteAlotPetitionNo();
                $case_no=$case_name.$petition_no."/ACPP";

                $certificate_no = $this->input->post('certificate_no');
                $cert_date = $this->input->post('cert_date');
                $alot_y_n = $this->input->post('alot_y_n');
                $alot_whos_name = $this->input->post('alot_whos_name');
                $type_govt_land = $this->input->post('type_govt_land');
                $dag_no = $this->input->post('dag_no');
                $tot_bigha = $this->input->post('tot_bigha');
                $tot_katha = $this->input->post('tot_katha');
                $tot_lessa = $this->input->post('tot_lessa');
                $alot_bigha = $this->input->post('alot_bigha');
                $alot_katha = $this->input->post('alot_katha');
                $alot_lessa = $this->input->post('alot_lessa');
                $alot_under = $this->input->post('alot_under');

                $allotment_basic = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'circle_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'case_no' => $case_no,
                    'year_no' => year_no,
                    'date_entry' => date('Y-m-d'),
                    'user_code' => $user_code,
                    'allotment_under' => $alot_under,
                    'petition_no' => $petition_no,
                    'original_alotee' => $alot_y_n,
                    'name_of_allote' => $alot_whos_name,
                    'type_govt_land' => $type_govt_land,
                );
                //VAR_DUMP($allotment_basic);
                $this->db->insert("allotment_cert_basic", $allotment_basic);
                $mut_petitioner = $this->session->userdata('mut_petitioner');
                $alotid = 1;
                foreach ($mut_petitioner as $mp) {
                    $alot_whos_name = $mp['alotee_hus_wife'];
                    if ($alot_whos_name != null) {
                        $name_alotee_h_w = $mp['name_alotee_h_w'];
                    } else {
                        $name_alotee_h_w = null;
                    }
                    $allotment_petitioner = array(
                        'dist_code' => $dist_code,
                        'subdiv_code' => $subdiv_code,
                        'circle_code' => $cir_code,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'lot_no' => $lot_no,
                        'vill_townprt_code' => $vill_townprt_code,
                        'case_no' => $case_no,
                        'year_no' => year_no,
                        'alotee_id' => $alotid,
                        'alotee_name' => $mp['alotee_name'],
                        'alotee_gender' => $mp['alotee_gender'],
                        'alotee_age' => $mp['alotee_age'],
                        'alotee_gurdian' => $mp['alotee_gurdian'],
                        'alotee_reln' => $mp['alotee_reln'],
                        'alotee_caste' => $mp['alotee_caste'],
                        'alotee_hus_wife' => $alot_whos_name,
                        'name_alotee_h_w' => $name_alotee_h_w,
                        'alotee_nationality' => $mp['alotee_nationality'],
                        'alotee_mobile' => $mp['alotee_mobile'],
                        'alotee_pan_card' => $mp['alotee_pan_card'],
                        'date_entry' => date('Y-m-d'),
                    );
                    //var_dump($allotment_petitioner);
                    $this->db->insert("allotment_petitioner", $allotment_petitioner);

                    $alotid = $alotid + 1;
                }
                //var_dump($allotment_petitioner);
                $allotment_dag = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'circle_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'case_no' => $case_no,
                    'year_no' => year_no,
                    'dag_no' => $dag_no,
                    //'patta_no'=>$patta_no,
                    //'patta_type_code'=>$this->input->post('p_type'),
                    'alot_area_b' => $alot_bigha,
                    'alot_area_k' => $alot_katha,
                    'alot_area_lc' => $alot_lessa,
                    'tot_area_b' => $tot_bigha,
                    'tot_area_k' => $tot_katha,
                    'tot_area_lc' => $tot_lessa,
                    'date_entry' => date('Y-m-d')
                );
                //var_dump($allotment_dag);
                $fdata = file_get_contents($_FILES['filename']['tmp_name']);
                $escaped = pg_escape_bytea($fdata);
                unlink($_FILES['filename']['tmp_name']);
                $allotment_doc_details = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'circle_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'case_no' => $case_no,
                    'year_no' => year_no,
                    'certficate_no' => $certificate_no,
                    'date_of_issue' => date('Y-m-d'), //$cert_date,
                    'name_of_certificate' => $filename,
                    'date_of_entry' => date('Y-m-d H:i:s'),
                    'file_name' => $escaped
                );
                //var_dump($allotment_doc_details);
                $this->db->insert("allotment_pet_dag", $allotment_dag);
                $this->db->insert("allotment_doc_details", $allotment_doc_details);
                $this->db->trans_complete();
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                } else {
                    $this->db->trans_commit();
                    $this->Dashboard($case_no);
                    $this->session->set_flashdata('message', "Case Successfully Passed with case number $case_no");
                    redirect(base_url() . 'index.php/home');
                }
            }
        }
    }

    public function index1() {
          $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $dist_name = $this->utilityclass->getDistrictName($dist_code);
        $sub_div_name = $this->utilityclass->getSubDivName($dist_code, $subdiv_code);
        $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $district['mouza'] = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
        $district['datas'] = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'dist_name' => $dist_name,
            'sub_div_name' => $sub_div_name,
            'cir_name' => $cir_name
        );
        $query = "select * from    master_guard_rel ";
        $district['relationship'] = $this->db->query($query)->result();
        $sql = "Select * from    allote_scheme_name";
        $district['scheme_name'] = $this->db->query($sql)->result();
        $sql = "Select * from    master_caste";
        $district['caste_name'] = $this->db->query($sql)->result();
        $sql = "Select * from    master_gender";
        $district['gender'] = $this->db->query($sql)->result();
        $checkfile = $_FILES['filename']['name'];
        if ($checkfile !== "") {
            $config['upload_path'] = CERT_BASE_DIR;
            $config['allowed_types'] = 'gif|jpg|png|pdf';
            $config['max_size'] = 1000;
            //  $config['max_width']            = 1024;
            // $config['max_height']           = 768;
            //$config['overwrite']           = TRUE;
            //$config['file_name']          = $checkfile;
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $config['mod_mime_fix'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->do_upload('filename');
            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];
        }
        //var_dump($config);
        /////////////////////
        $this->form_validation->set_rules('applicant_name', 'Applicant Name', 'trim|required|min_length[5]|max_length[50]');
        $this->form_validation->set_rules('gurdian_name', 'Guardian Name', 'trim|required|min_length[5]|max_length[50]');
        $this->form_validation->set_rules('relation', 'Relationship', 'required');
        //$this->form_validation->set_rules('income_per_yr', 'Income Per Year', 'trim|required|numeric');
        $this->form_validation->set_rules('age', 'Age', 'trim|required|numeric');
        $this->form_validation->set_rules('mobile_no', 'Mobile Number', 'trim|required|numeric');
        $this->form_validation->set_rules('dag_no', 'Dag Number', 'trim|required|numeric');
        $this->form_validation->set_rules('nationality', 'Type Here', 'required');
        $this->form_validation->set_rules('tot_bigha', 'Total Bigha', 'trim|required|numeric');
        $this->form_validation->set_rules('tot_katha', 'Total katha', 'trim|required|numeric');
        $this->form_validation->set_rules('tot_lessa', 'Total Lessa', 'trim|required|numeric');
        $this->form_validation->set_rules('alot_bigha', 'Bigha', 'trim|required|numeric');
        $this->form_validation->set_rules('alot_katha', 'Katha', 'trim|required|numeric');
        $this->form_validation->set_rules('alot_lessa', 'Lessa', 'trim|required|numeric');
        $this->form_validation->set_rules('filename', 'Error in Uploading', 'xss_clean');

        if (($this->form_validation->run() == FALSE) || (!$this->upload->do_upload('filename'))) {
            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/allotment/aststep_one', $district);
            $this->load->view('../views/footer');
        } else {
            $this->db->trans_start();
            // print_r($_POST);
            //echo $file_name;
            $year = year_no;
            $user_code = $this->session->userdata('user_code');
            $q = "Select max(petition_no)+1 as p from    allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and year_no='$year' ";
            $petition_no = $this->db->query($q)->row()->p;
            if ($petition_no == null) {
                $petition_no = +1;
            }
            //$case_no=;
            $q = "Select dist_abbr,cir_abbr from    location where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code!='00' ";
            $abbrname = $this->db->query($q)->row();
            $cir_dist_name = $abbrname->dist_abbr . "/" . $abbrname->cir_abbr;
            //var_dump($cirname);
            $financialyeardate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('y') : date('Y') . "-" . date('y', strtotime('+1 year'));
            $case_no = $cir_dist_name . "/" . $financialyeardate . "/" . $petition_no . "/ACPP";

            $mouza_pargona_code = $this->input->post('mouza_code');
            $lot_no = $this->input->post('lot_no');
            $vill_townprt_code = $this->input->post('vill_code');
            $year_no = date('Y');


            //$name_hus_wife = $this->input->post('lot_no');

            $emp_type = $this->input->post('emp_type');
            // $income_per_yr = $this->input->post('income_per_yr');
            $nationality = $this->input->post('nationality');
            $mobile_no = $this->input->post('mobile_no');
            $pan = $this->input->post('pan');
            $certificate_no = $this->input->post('certificate_no');
            $cert_date = $this->input->post('cert_date');

            $alot_y_n = $this->input->post('alot_y_n');
            $alot_whos_name = $this->input->post('alot_whos_name');
            $dag_no = $this->input->post('dag_no');
            $tot_bigha = $this->input->post('tot_bigha');
            $tot_katha = $this->input->post('tot_katha');
            $tot_lessa = $this->input->post('tot_lessa');
            $alot_bigha = $this->input->post('alot_bigha');
            $alot_katha = $this->input->post('alot_katha');
            $alot_lessa = $this->input->post('alot_lessa');

            $alot_under = $this->input->post('alot_under');

            $allotment_basic = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'circle_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'case_no' => $case_no,
                'year_no' => date('Y'),
                'date_entry' => date('Y-m-d'),
                'user_code' => $user_code,
                'allotment_under' => $alot_under,
                'petition_no' => $petition_no
            );
            $allotment_petitioner = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'circle_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'case_no' => $case_no,
                'year_no' => date('Y'),
                'alotee_id' => 1,
                'alotee_name' => $applicant_name,
                'alotee_gender' => $gender,
                'alotee_age' => $age,
                'alotee_gurdian' => $gurdian_name,
                'alotee_reln' => $relation,
                'alotee_caste' => $caste,
                'alotee_hus_wife' => $applicant_hus_wife,
                'name_alotee_h_w' => $name_hus_wife,
                'alotee_nationality' => $nationality,
                'alotee_mobile' => $mobile_no,
                'alotee_pan_card' => $pan,
                'original_alotee' => $alot_y_n,
                'name_of_allote' => $alot_whos_name,
                'date_entry' => date('Y-m-d'),
                    //'income_per_yr' => $income_per_yr
            );
            $allotment_dag = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'circle_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'case_no' => $case_no,
                'year_no' => date('Y'),
                'dag_no' => $dag_no,
                'patta_no' => $this->input->post('patta_no'),
                'patta_type_code' => $this->input->post('p_type'),
                'alot_area_b' => $alot_bigha,
                'alot_area_k' => $alot_katha,
                'alot_area_lc' => $alot_lessa,
                'tot_area_b' => $tot_bigha,
                'tot_area_k' => $tot_katha,
                'tot_area_lc' => $tot_lessa,
                'date_entry' => date('Y-m-d')
            );
            //var_dump($allotment_dag);
            $allotment_doc_details = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'circle_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'case_no' => $case_no,
                'year_no' => date('Y'),
                'certficate_no' => $certificate_no,
                'date_of_issue' => date('Y-m-d'), //$cert_date,
                'name_of_certificate' => $file_name,
                'date_of_entry' => date('Y-m-d')
            );
            // var_dump($allotment_doc_details);
            $this->db->insert('allotment_cert_basic', $allotment_basic);
            $this->db->insert('allotment_petitioner', $allotment_petitioner);
            $this->db->insert('allotment_pet_dag', $allotment_dag);
            $this->db->insert('allotment_doc_details', $allotment_doc_details);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Case Successfully Passed with case number $case_no");
                // redirect(base_url() . 'index.php/home');
            }
        }

        ////////////////////
    }

    function governmentland($d, $s, $c, $m, $l, $v) {
          $db=  $this->session->userdata('db');
        //and patta_type_code='0208'; 
        $pattasql = "Select type_code from    patta_code where mutation='n' ";
        $q = "SElect dag_no from    chitha_basic where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$m' and lot_no='$l' and vill_townprt_code='$v' and (patta_type_code in ($pattasql )) order by dag_no_int";
        $data = $this->db->query($q)->result();
        $json = array();
        foreach ($data as $object) {
            $json[] = array('dag_no' => $object->dag_no);
        }
        echo json_encode($json);
    }

    function landarea($d, $s, $c, $m, $l, $v, $dag) {
          $db=  $this->session->userdata('db');
        $q = "SElect dag_area_b as b,dag_area_k as k,dag_area_lc as lc,patta_no as pno,patta_type_code as pcode from    chitha_basic where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$m' and lot_no='$l' and vill_townprt_code='$v' and dag_no='$dag' ";
        $data = $this->db->query($q)->row();
        $json[] = array('bigha' => $data->b, 'katha' => $data->k, 'lessa' => $data->lc, 'pno' => $data->pno, 'pcode' => $data->pcode);
        echo json_encode($json);
    }


    function copendingfirstlist() {

        $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }


          $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $data['cases'] = $this->db->query("Select *,ba.basundhara from    allotment_cert_basic acb left join basundhar_application ba on acb.case_no=ba.dharitree where acb.dist_code='$dist_code' and acb.subdiv_code='$subdiv_code' and acb.circle_code='$cir_code' and  acb.not_fresh is null and acb.status is null and acb.settlement_typ is null ")->result();

        foreach($data['cases'] as $rows){
            if($rows->es_flag == '1' && ESCALATION_ENABLE ==1 && $rows->out_of_esc == 0){
                $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
                //log_message('error', '#55: Escalation ROW : '.json_encode($escRow));                         
                if(!empty($escRow)){                                                                
                    $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));                             
                    //log_message('error', '#5531: Escalation details : '.json_encode($escData)); 
                    if(!empty($escData)){                                
                        $rows->escalation_date = $escData->escalation_date;
                        $rows->escalation_zone = $escData->escalation_zone;
                        $rows->assigned_date   = $escData->assigned_date;
                    }else{
                        $rows->escalation_date = 'NA';
                        $rows->escalation_zone = 'NA';
                        $rows->assigned_date   = 'NA';
                    }
                }else{
                    $rows->escalation_date = 'NA';
                    $rows->escalation_zone = 'NA';
                    $rows->assigned_date   = 'NA';
                }                            
            }
            else {
                $rows->escalation_date = 'NA';
                $rows->escalation_zone = 'NA';
            }
        }

        $data['_view'] = 'allotment/copendinglistfirst';
        $this->load->view('layouts/main',$data);
    }

    function copendingseclist() {

        $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }


          $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $cases= $this->db->query("Select distinct on(case_no) *,ba.basundhara from    allotment_cert_basic acb left join basundhar_application ba on acb.case_no=ba.dharitree where acb.dist_code='$dist_code' and acb.subdiv_code='$subdiv_code' and acb.circle_code='$cir_code' and acb.status='P' and acb.co_code is not null and acb.settlement_typ is null ")->result();

        $cases2 = $this->db->query("Select distinct on(case_no) *,ba.basundhara from    allotment_cert_basic acb left join basundhar_application ba on acb.case_no=ba.dharitree where acb.dist_code='$dist_code' and acb.subdiv_code='$subdiv_code' and acb.circle_code='$cir_code' and acb.status='P' and acb.co_code is null and dc_code is not null and chitha_correct_yn is null and acb.settlement_typ is null ")->result();

        $data['cases']=array_merge($cases,$cases2 );

        foreach($data['cases'] as $rows){
            if($rows->es_flag == '1' && ESCALATION_ENABLE ==1 && $rows->out_of_esc == 0){
                $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
                //log_message('error', '#55: Escalation ROW : '.json_encode($escRow));                         
                if(!empty($escRow)){                                                                
                    $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));                             
                    //log_message('error', '#5531: Escalation details : '.json_encode($escData)); 
                    if(!empty($escData)){                                
                        $rows->escalation_date = $escData->escalation_date;
                        $rows->escalation_zone = $escData->escalation_zone;
                        $rows->assigned_date   = $escData->assigned_date;
                    }else{
                        $rows->escalation_date = 'NA';
                        $rows->escalation_zone = 'NA';
                        $rows->assigned_date   = 'NA';
                    }
                }else{
                    $rows->escalation_date = 'NA';
                    $rows->escalation_zone = 'NA';
                    $rows->assigned_date   = 'NA';
                }                            
            }
            else {
                $rows->escalation_date = 'NA';
                $rows->escalation_zone = 'NA';
            }
        }

         $data['_view'] = 'allotment/copendinglistsecond';
        $this->load->view('layouts/main',$data);


    }

    public function cofirstproceeding() {

        $_GET['case_no'] = dec_param($this->input->get('case_no'), 'case_no');
        if($_GET['case_no'] == null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
        return;
        }

        $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $case_no = $this->input->get('case_no');
        //$year_no = year_no;
        $data['allotment_cb'] = $this->db->query("Select * from    allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no' and not_fresh is null and status is null")->row();
        $data['allotment_certificate'] = $this->db->query("Select name_of_certificate from    allotment_doc_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no'  ")->row();
        $data['basuCase']=null;
        $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
        if($basundharaExist){
            $data['query']=null;
                $rtps=$this->rtpsmodel->checkBasundharaService($case_no);
                if($rtps=='RTPS'){
                    $data['basundharaAttachment']=$this->rtpsmodel->searchBasundharaLink($case_no);
                }else{
                    $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
                }
            $data['query']=$this->basundharamodel->QueryPost($basundharaExist);

            //noc certificate
            $data['noc_cert'] = $this->mutationmodel->getNOCForACPP($case_no)->row();

            //allotment certificate
            $data['allot_cert'] = $this->mutationmodel->getAllotmentCertificateACPP($case_no)->row();
        }
        $data['_view'] = 'allotment/costep_one';
        $this->load->view('layouts/main',$data);
    }

    function savecofirstorder() {
        //xss & security validation starts
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }
        $resp = checkRequestValidQuery($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }    
        if($errorMessageStr != ''){
            $this->session->set_flashdata('message', $errorMessageStr);
            return redirect($_SERVER['HTTP_REFERER']);
        }
        //xss & security validation ends 
          $db=  $this->session->userdata('db');
        //print_r($_POST);
        if (($_POST['next_hearing'] == 'P') or ( $_POST['next_hearing'] == 'D')) {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            if(ESCALATION_ENABLE == 1)
            {
                $next_date = date('Y-m-d',strtotime($this->input->post('next_date')))." ".date( 'H:i:s');
            }
            else
            {
                $next_date = date('Y-m-d',strtotime($this->input->post('next_date')));
            }
            
            $case_no = $this->input->post('case_no');
            $user_code = $this->session->userdata('user_code');
            $status = $this->input->post('next_hearing');
            $name = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $user_code);
            //var_dump($name);
            $co_name = $name->username;
            $proceeding1 = $this->input->post('proceeding1');
            $proceeding2 = $this->input->post('proceeding2');
            $proceeding3 = "চক্র বিষয়া -----" . $co_name;
            $merge = $proceeding1 . $next_date . $proceeding2 . $proceeding3;

            $q = "Select max(proceeding_id)+1 as p from    petition_proceeding_dc_adc where dist_code='$dist_code' and cir_code='$cir_code' and case_no='$case_no' ";
            $count = $this->db->query($q)->row()->p;
            if ($count == 0) {
                $count = $count + 1;
            }
            //echo $count;
            //echo $this->input->post('next_date');
            $this->db->trans_begin();

            $update = array(
                'next_date_hearing' => $next_date,
                'not_fresh' => 'Y',
                'status' => $status,
                'proceeding_yn' => 1,
                'co_code' => $user_code,
                'co_entry_date' => date('Y-m-d'),
                'co_note' => 'Y'
            );
            if ($status == 'D') {
                ///////////
                $rmk=$rmrk;
                $status='R';
                $task='CO';
                $pen='NA';
                $case=$case_no;
                
                ///////////
                $status = 'Finish';
            } else {
                //////////
                $penUser='LM';
                $rmrk='Case Have been forwarded by CO';
                $this->DashboardData($case_no,$penUser,$rmrk);
                $rmk=$rmrk;
                $status='M';
                $task='CO';
                $pen='LM';
                $case=$case_no;
                // $postAPI = $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen); 
                ///////
                $status = 'Pending';
            }

            

            $insert = array(
                'case_no' => $case_no,
                'proceeding_id' => $count,
                'date_of_hearing' => date('Y-m-d'),
                'co_order' => addslashes($merge),
                'next_date_of_hearing' => date('Y-m-d', strtotime($this->input->post('next_date'))),
                'status' => $status,
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code
            );
            //var_dump($insert);
            $this->db->insert('petition_proceeding_dc_adc', $insert);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('circle_code', $cir_code);
            $this->db->where('case_no', $case_no);
            $this->db->update('allotment_cert_basic', $update);
            //log_message('error', "#ERR918 : ".json_encode($this->db->last_query()));

            if($this->db->affected_rows() == 0){
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "ERR855: Something went wrong! Unable to process... $case_no");
                redirect(base_url() . 'index.php/home');
            }

            $getLoc = $this->db->query('select * from allotment_cert_basic where case_no = ?', array($case_no));
            if($getLoc->num_rows() <= 0){
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "ERR862: Something went wrong! Unable to process... $case_no");
                redirect(base_url() . 'index.php/home');
            }

            $locRow = $getLoc->row();

            
            $append = "dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$locRow->mouza_pargona_code' and lot_no='$locRow->lot_no' and ". "vill_townprt_code='$locRow->vill_townprt_code'";
            
            $pb = $this->db->query("select * from allotment_cert_basic where case_no='$case_no' and $append")->row();
            //ESCALATION CODE INTEGRATION================SANMRI
            // $executionDate = $this->input->post('executionDate');
            $executionDate = date('Y-m-d H:i:s');
            $user_code = $this->session->userdata('user_code');
            $es_flag = $pb->es_flag;
            $out_of_esc = $pb->out_of_esc;

            if($es_flag == 1 && ESCALATION_ENABLE ==1 && $out_of_esc == 0){

                $escalationUpdateStatus = $this->Escalationmodel->escalationCOFirstProcedingAllotment($executionDate,$dist_code,$subdiv_code,$cir_code,$locRow->mouza_pargona_code,$locRow->lot_no,$case_no,$user_code);

                log_message("error", "#ESC5803, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

                if($escalationUpdateStatus['responseType'] == 0){
                    $this->db->trans_rollback();
                    log_message("error", "#ESC5803, transaction-error in method 'Allotment/cofirstproceeding' with case-no :". $case_no.", dist-code : ".$dist_code);
                    $this->session->set_flashdata('message', "Something went wrong.ALLOT- Error Code(#ESC5803)");
                    redirect(base_url() . "index.php/home");
                }
            }


            $postAPI = $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
            if(trim(strtolower($postAPI)) != 'y'){
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "ERR827: Unable to connect to API! $case_no");
                redirect(base_url() . 'index.php/home');
            }
            ///////////////END ESCALATION//////////////
            $this->db->trans_commit();
            ///////
            $this->session->set_flashdata('message', "Case Successfully Passed with case number $case_no");
            redirect(base_url() . 'index.php/home');
        }
    }

    function cosecondproceeding() {

        $_GET['case_no'] = dec_param($this->input->get('case_no'), 'case_no');
        if($_GET['case_no'] == null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
        return;
        }

        $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }


         //xss & security validation starts
         $errorMessageStr = '';
         $resp = checkRequestSpecChar($_POST);
         if($resp['status'] == 'n'){
             $errorMessageStr .= $resp['messages'];
         }
         $resp = checkRequestValidQuery($_POST);
         if($resp['status'] == 'n'){
             $errorMessageStr .= $resp['messages'];
         }    
         if($errorMessageStr != ''){
            $this->session->set_flashdata('message', $errorMessageStr);
             return redirect($_SERVER['HTTP_REFERER']);
         }
        //xss & security validation ends 
        $db=  $this->session->userdata('db');
        $case_no = $this->input->get('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $q = "Select * from    allotment_cert_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code'";
        $data['allotment_cb'] = $this->db->query($q)->row();
        $q = "Select * from    allotment_petitioner where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code'";
        $data['applicant'] = $this->db->query($q)->result();
        $q = "Select * from    allotment_pet_dag where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code'";
        $data['lmreport'] = $this->db->query($q)->row();

        $q = "Select * from    allotment_lm_note where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code'";
        $data['lmposses'] = $this->db->query($q)->row();
        $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
            if($basundharaExist){
                $data['rtps']=$rtps=$this->rtpsmodel->checkBasundharaService($case_no);
                if($rtps=='RTPS'){
                    $data['basundharaAttachment']=$this->rtpsmodel->searchBasundharaLink($case_no);
                }else{
                    $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
                }
            }
        //noc certificate
        $data['noc_cert'] = $this->mutationmodel->getNOCForACPP($case_no)->row();

        //allotment certificate
        $data['allot_cert'] = $this->mutationmodel->getAllotmentCertificateACPP($case_no)->row();


        //****Escalation */
        $getLoc = $this->db->query('select * from allotment_cert_basic where case_no = ?', array($case_no));
        if($getLoc->num_rows() <= 0){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "ERR862: Something went wrong! Unable to process... $case_no");
            redirect(base_url() . 'index.php/home');
        }
        $locRow = $getLoc->row();
        $append = "dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$locRow->mouza_pargona_code' and lot_no='$locRow->lot_no' and ". "vill_townprt_code='$locRow->vill_townprt_code'";
        
        $pb = $this->db->query("select * from allotment_cert_basic where case_no='$case_no' and $append")->row();

        $flag = false;
        if($pb->es_flag == 1 && ESCALATION_ENABLE == 1 && $pb->out_of_esc == 0){
            //remaining Days of LM ============
            $escalatedRowDetailsAgainstPetitionno = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($case_no);
            if(empty($escalatedRowDetailsAgainstPetitionno) || $escalatedRowDetailsAgainstPetitionno == null)
            {
                $this->session->set_flashdata('message', "Something went wrong.ALLOT- Error Code(#ESC74047)");
                redirect(base_url() . "index.php/home");
            }

            $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->lm_target_days;
            $previousCompletedDaysLM = $escalatedRowDetailsAgainstPetitionno->lm_completed_days;
            $remaining_days_LM = $this->Escalationmodel->getRemainingDays($previousCompletedDaysLM,$originalAllocation);

            //remaining days of CO==============
            $originalAllocationCO   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            $remaining_days_CO= $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO,$originalAllocationCO);
            if($remaining_days_LM == 0){
                $flag = true;
            }else{
                $flag = false;
            }
        }
        $data['flag'] = $flag;
        $data['remainingDaysCO'] = $remaining_days_CO;
        $data['out_of_esc'] = $pb->out_of_esc;
        $data['adc'] = $this->db->query("Select users.username as username, users.user_desig_code as user_desig_code, loginuser_table.user_code as user_code from    users, "
                        . "loginuser_table where users.dist_code = loginuser_table.dist_code and users.user_code = loginuser_table.user_code and users.user_desig_code like 'ADC%' and "
                        . "loginuser_table.dist_code='$dist_code' and loginuser_table.subdiv_code='00' and loginuser_table.cir_code='00' and loginuser_table.dis_enb_option = 'E' and loginuser_table.priv = 'adm'")->result();
        $data['_view'] = 'allotment/co_secondproceeding';
        $this->load->view('layouts/main',$data);
    }

    function savecoscondorder() {
         //xss & security validation starts
         $errorMessageStr = '';
         $resp = checkRequestSpecChar($_POST);
         if($resp['status'] == 'n'){
             $errorMessageStr .= $resp['messages'];
         }
         $resp = checkRequestValidQuery($_POST);
         if($resp['status'] == 'n'){
             $errorMessageStr .= $resp['messages'];
         }    
         if($errorMessageStr != ''){
            $this->session->set_flashdata('message', $errorMessageStr);
             return redirect($_SERVER['HTTP_REFERER']);
         }
        //xss & security validation ends 
          $db=  $this->session->userdata('db');
        $case_no = $this->input->post('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        $comment = addslashes($this->input->post('co_comment'));


        $getLoc = $this->db->query('select * from allotment_cert_basic where case_no = ?', array($case_no));
        if($getLoc->num_rows() <= 0){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "ERR862: Something went wrong! Unable to process... $case_no");
            redirect(base_url() . 'index.php/home');
        }

        $locRow = $getLoc->row();

        if(ESCALATION_ENABLE == 1 && $locRow->es_flag == 1)
        {
            $next_date = date('Y-m-d',strtotime($this->input->post('next_date')))." ".date('H:i:s');
        }
        else 
        {
            $next_date = date('Y-m-d', strtotime($this->input->post('next_date')));
        }
        
        
        $next_status = $this->input->post('next_hearing');


        $name = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $user_code);
        $co_name = $name->username;
        $co_name = "চক্র বিষয়া -----" . $co_name;
        $comment = $comment . $co_name;


         ///////////// BARAK VALLEY CODE START HERE ////////////////
        $barak = in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY));
        if($barak){
            $co_name = "সার্কেল অফিসার -----" . $co_name;
        }
        else { $co_name = "চক্র বিষয়া -----" . $co_name; }
        ///////////// BARAK VALLEY CODE END HERE ////////////////
        //exit;

        $this->db->trans_begin();

        if ($next_status == 'L') {
            $update = array(
                'lm_code' => null,
                'lm_note' => null,
                'lm_entry_date' => null,
                'next_date_hearing' => $next_date,
                'co_code' => $user_code,
                'co_entry_date' => date('Y-m-d'),
                'co_note' => 'Y'
            );
             //////
                $penUser='LM';
                $rmrk='Revert back by CO';
                $this->DashboardData($case_no,$penUser,$rmrk);
                $rmk=$rmrk;
                $status='M';
                $task='CO';
                $pen='LM';
                $case=$case_no;
                $API = $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
            /////
        } elseif ($next_status == 'D') {
            $update = array(
                'status' => 'D',
                'next_date_hearing' => $next_date,
                'co_code' => $user_code,
                'co_entry_date' => date('Y-m-d'),
                'co_note' => 'Y'
            );
            //////
            $this->DashboardDataFinal($case_no);
            $rmk="Rejected";
            $status='R';
            $task='CO';
            $pen='NA';
            $case=$case_no;
            $API = $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
            
        } elseif ($next_status == 'P') {
            $adc_code = $this->input->post('adc_code');
            if(empty($adc_code))
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERR1167: ADC not selected...");
                redirect(base_url() . 'index.php/home');
            }

            $update = array(
                'next_date_hearing' => $next_date,
                'status' => 'R',
                'co_code' => $user_code,
                'co_entry_date' => date('Y-m-d'),
                'co_note' => 'Y',
                'dc_code' => null,
                'adc_code' => $adc_code
            );

            if(ESCALATION_ENABLE == 1 && $locRow->es_flag == 1)
            {

                 $update['bo_code'] = "BO";
                 $update['bo_date_entry'] = date('Y-m-d');
                 $update['bo_note'] = "For Escalation BO is not required";
                 $update['dc_note'] = null;

             
            }
            ///////////// BARAK VALLEY CODE START HERE ////////////////
            if($barak){
                $areaupdate = array(
                    'alot_area_b' => $_POST['mut_area_b'],
                    'alot_area_k' => $_POST['mut_area_k'],
                    'alot_area_lc' => $_POST['mut_area_l'],
                    'alot_area_g' => $_POST['mut_area_g'],
                );

                $arealmupdate = array(
                    'area_posession_b' => $_POST['mut_area_b'],
                    'area_posession_k' => $_POST['mut_area_k'],
                    'area_posession_lc' => $_POST['mut_area_l'],
                    'area_posession_g' => $_POST['mut_area_g'],
                );
            }
            else { 
            ///////////
            $areaupdate = array(
                'alot_area_b' => $_POST['mut_area_b'],
                'alot_area_k' => $_POST['mut_area_k'],
                'alot_area_lc' => $_POST['mut_area_l'],
            );

            $arealmupdate = array(
                'area_posession_b' => $_POST['mut_area_b'],
                'area_posession_k' => $_POST['mut_area_k'],
                'area_posession_lc' => $_POST['mut_area_l'],
            );
            }
            //////
            $penUser='DC';
            $rmrk='Send to ADC/DC for final order';
            $this->DashboardData($case_no,$penUser,$rmrk);
            $rmk=$rmrk;
            $status='M';
            $task='CO';
            $pen='DC';
            $case=$case_no;
              

            $API = $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);

            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('circle_code', $cir_code);
            $this->db->where('case_no', $case_no);
            
            $this->db->update('allotment_pet_dag', $areaupdate);

            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('circle_code', $cir_code);
            $this->db->where('case_no', $case_no);
            $this->db->update('allotment_lm_note', $arealmupdate);

            if($this->db->affected_rows() == 0){
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERR1094: Something went wrong unable to process... $case_no");
                redirect(base_url() . 'index.php/home');
            }

            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('circle_code', $cir_code);
            $this->db->where('case_no', $case_no);
            $this->db->update('allotment_lm_note', $arealmupdate);
            }

            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('circle_code', $cir_code);
            $this->db->where('case_no', $case_no);
            $this->db->update('allotment_cert_basic', $update);
            if($this->db->affected_rows() == 0){
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERR1107: Something went wrong unable to process... $case_no");
                redirect(base_url() . 'index.php/home');
            }
           // $this->db->update('allotment_pet_dag', $areaupdate);


            ////////////////        
            $q = "Select max(proceeding_id)+1 as p from    petition_proceeding_dc_adc where case_no='$case_no' ";
            $count = $this->db->query($q)->row()->p;
            if ($count == 0) {
                $count = $count + 1;
            }
            $insert = array(
                'case_no' => $case_no,
                'proceeding_id' => $count,
                'date_of_hearing' => date('Y-m-d'),
                'co_order' => $comment,
                'next_date_of_hearing' => date('Y-m-d', strtotime($this->input->post('next_date'))),
                'status' => 'Pending',
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code
            );
            //var_dump($insert);
            $insert = $this->db->insert('petition_proceeding_dc_adc', $insert);

            if($insert != 1){
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERR1138: Something went wrong unable to process... $case_no");
                redirect(base_url() . 'index.php/home');
            }

            

            $getLoc = $this->db->query('select * from allotment_cert_basic where case_no = ?', array($case_no));
            if($getLoc->num_rows() <= 0){
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "ERR862: Something went wrong! Unable to process... $case_no");
                redirect(base_url() . 'index.php/home');
            }

            $locRow = $getLoc->row();

            $append = "dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$locRow->mouza_pargona_code' and lot_no='$locRow->lot_no' and ". "vill_townprt_code='$locRow->vill_townprt_code'";
            
            $pb = $this->db->query("select * from allotment_cert_basic where case_no='$case_no' and $append")->row();
            //ESCALATION CODE INTEGRATION================SANMRI
            // $executionDate = $this->input->post('executionDate');
            $executionDate = date('Y-m-d H:i:s');
            $user_code = $this->session->userdata('user_code');
            $es_flag = $pb->es_flag;
            $out_of_esc = $pb->out_of_esc;

            if($es_flag == 1 && ESCALATION_ENABLE ==1 && $out_of_esc== 0)
            {

                if($next_status == 'P')
                {
                    //****Forward to DC */
                    $escalationUpdateStatus = $this->Escalationmodel->escalationCOSecondProcedingAllotment($executionDate,$dist_code,$subdiv_code,$cir_code,$locRow->mouza_pargona_code,$locRow->lot_no,$case_no,$user_code);
                    log_message("error", "#ESC835803, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

                    if($escalationUpdateStatus['responseType'] == 0){
                        $this->db->trans_rollback();
                        log_message('error', '#ESC835803: Updation failed in escalation for case no :'. $case_no);
                        $json = [
                            'errorMessage'=>"#ESC835803: Updation failed on escalation for Case No ".$case_no
                        ];
                        echo json_encode($json);
                        return false;
                    }
                

                }
                elseif($next_status == 'L')
                {
                    //****revert back to LM */

                    //ESCALATION CODE INTEGRATION================SANMRI
                    $getLoc = $this->db->query('select * from allotment_cert_basic where case_no = ?', array($case_no));
                    if($getLoc->num_rows() <= 0){
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "ERR862: Something went wrong! Unable to process... $case_no");
                        redirect(base_url() . 'index.php/home');
                    }
                    $locRow = $getLoc->row();
                    $append = "dist_code='$locRow->dist_code' and subdiv_code='$locRow->subdiv_code' and circle_code='$locRow->circle_code' and mouza_pargona_code='$locRow->mouza_pargona_code' and lot_no='$locRow->lot_no' and ". "vill_townprt_code='$locRow->vill_townprt_code'";
                    
                    $pb = $this->db->query("select * from allotment_cert_basic where case_no='$case_no' and $append")->row();
                    if($pb->es_flag == 1 && ESCALATION_ENABLE ==1 && $pb->out_of_esc == 0)
                    {
                        $user_code = $this->session->userdata('user_code');
                        // $executionDate = $this->input->post('executionDate');
                        $executionDate = date('Y-m-d H:i:s');
                        $allocation_days = null;

                        // if($this->input->post('allocate_day') !=null){
                        //     $allocation_days = $this->input->post('allocate_day');
                        // }
                        if (isset($_POST['allocate_day'])) {
                            $allocation_days = $this->input->post('allocate_day');
                            if(empty($allocation_days)){
                                $this->session->set_flashdata('message', "#ERR1034: Please select allocated days... $case_no");
                                redirect(base_url() . 'index.php/home');
                            }
                        }

                        $escalationUpdateStatus = $this->Escalationmodel->escalationCORevertToLmALOT($executionDate,$locRow->dist_code,$locRow->subdiv_code,$locRow->circle_code,$case_no,$user_code,$locRow->mouza_pargona_code,$locRow->lot_no,$allocation_days);

                        log_message("error", "#ESC4152, transaction-error-STATUS======".json_encode($escalationUpdateStatus));
                        if($escalationUpdateStatus['responseType'] == 0){
                            $this->db->trans_rollback();
                            log_message("error", "#ESC4152, transaction-error in method 'LandReclassification/revertToLMReclassByCOEscalation' with case-no :". $case_no);
                            $this->session->set_flashdata('message', "Something went wrong.RECLASS- Error Code(#ESC4152)");
                            redirect(base_url() . "index.php/home");
                        }
                        ///////////////END ESCALATION//////////////
                    }

                }
                elseif($next_status == 'D')
                {
                        //****reject */
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "ERR1173: Something went wrong! Unable to process... $case_no");
                        redirect(base_url() . 'index.php/home');
                }
                else{
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "ERR1184: Something went wrong! Unable to process... $case_no");
                    redirect(base_url() . 'index.php/home');
                }
                log_message("error", "#ESC5803, transaction-error-STATUS======".json_encode($escalationUpdateStatus));
            }
        if(trim(strtolower($API)) != 'y'){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#ERR1144: Something went wrong unable to process... $case_no");
            redirect(base_url() . 'index.php/home');
        }
        
        $this->db->trans_commit();
        $this->session->set_flashdata('message', "Case Successfully Passed with case number $case_no");
        redirect(base_url() . 'index.php/home');
    }

    function lmpending() {

        $allowed = ['LM'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

          $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');

        //$data['cases'] = $this->db->query("Select *,ba.basundhara from allotment_cert_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where fmb.dist_code='$dist_code' and fmb.subdiv_code='$subdiv_code' and fmb.circle_code='$cir_code' and fmb.mouza_pargona_code='$mouza_pargona_code' and fmb.lot_no='$lot_no' and fmb.lm_note is null and fmb.not_fresh='Y' and fmb.status='P' and fmb.co_note is not null")->result();

        $data['cases'] = $this->db->query("Select *,ba.basundhara from allotment_cert_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where fmb.dist_code='$dist_code' and fmb.subdiv_code='$subdiv_code' and fmb.circle_code='$cir_code' and fmb.mouza_pargona_code='$mouza_pargona_code' and fmb.lot_no='$lot_no' and fmb.lm_note is null and fmb.not_fresh='Y' and fmb.status='P'  and co_code is not null and settlement_typ is null")->result();

        foreach($data['cases'] as $rows){
            if($rows->es_flag == '1' && ESCALATION_ENABLE ==1 && $rows->out_of_esc == 0)
            {
                $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
                //log_message('error', '#55: Escalation ROW : '.json_encode($escRow));                         
                if(!empty($escRow)){                                                                
                    $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));                             
                    //log_message('error', '#5531: Escalation details : '.json_encode($escData)); 
                    if(!empty($escData)){                                
                        $rows->escalation_date = $escData->escalation_date;
                        $rows->escalation_zone = $escData->escalation_zone;
                        $rows->assigned_date   = $escData->assigned_date;
                    }else{
                        $rows->escalation_date = 'NA';
                        $rows->escalation_zone = 'NA';
                        $rows->assigned_date   = 'NA';
                    }
                }else{
                    $rows->escalation_date = 'NA';
                    $rows->escalation_zone = 'NA';
                    $rows->assigned_date   = 'NA';
                }                            
            }
            else {
                $rows->escalation_date = 'NA';
                $rows->escalation_zone = 'NA';
            }
        }

        $data['_view'] = 'allotment/lmpendinglist';
        $this->load->view('layouts/main',$data);
    }

    function lmstep_one() {

        $_GET['case_no'] = dec_param($this->input->get('case_no'), 'case_no');
        if($_GET['case_no'] == null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
        return;
        }


        $allowed = ['LM'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $case_no = $this->input->get('case_no');
        $this->load->model('relation/relationmodel');
        $data['genders'] = $this->mutationmodel->getGenders();
        $data['relation'] = $this->relationmodel->getRelations();
        $year_no = year_no;
        $sql = "Select * from allote_scheme_name";
        $data['allotment_cb'] = $cb = $this->db->query("Select * from    allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no' ")->row();
        $data['allotment_certificate'] = $this->db->query("Select name_of_certificate from    allotment_doc_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no' and year_no='$year_no' ")->row();
        //var_dump($data['allotment_cb']);

        $data['scheme_name'] = $this->db->query($sql)->result();
        $data['mouzaname'] = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
        $data['villname'] = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $cb->vill_townprt_code);
        $data['cases'] = $cb = $this->db->query("Select * from    allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and lm_note is null and case_no='$case_no' ")->row();

        $q = "Select dag_no,patta_no,dag_no_int as new_dag from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$cb->vill_townprt_code' order by dag_no_int";
        $data['dag_patta'] = $dag = $this->db->query($q)->result();

        $data['dag_details'] = $this->db->query("Select * from    allotment_pet_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and case_no='$case_no' ")->row();
        $dagNooo=$data['dag_details']->dag_no;
         ///////////// BARAK VALLEY CODE START HERE ////////////////
        $data['chithaDagArea']=$this->db->query("
           Select dag_area_b,dag_area_k,dag_area_lc,dag_area_g from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$cb->vill_townprt_code' and dag_no='$dagNooo'
            ")->row();
        ///////////// BARAK VALLEY CODE ENDS HERE ////////////////
        $data['certificate'] = $this->db->query("Select * from    allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and  case_no='$case_no' ")->row();

        $pattasql = "Select type_code from    patta_code where mutation='a' ";
        $pattasqll = "Select type_code,patta_type from    patta_code where mutation='a' ";
        $data['mutpatta'] = $this->db->query($pattasqll)->result();
        $landsql = "Select class_code,land_type from    landclass_code  ";
        $data['landsql'] = $this->db->query($landsql)->result();
        $sql = "Select distinct cast(patta_no as varchar) as patta_no from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
                . "and vill_townprt_code='$cb->vill_townprt_code' and patta_type_code in ($pattasql) and lot_no='$lot_no' and   patta_no!='' and patta_no!='.' order by patta_no desc  ";


        $data['co_comment'] = $this->db->query("Select co_order from petition_proceeding_dc_adc where case_no='$case_no' and user_code like 'CO%' order by proceeding_id desc ")->row();


        $patta_no = $data['oldPatta'] = $this->db->query($sql)->result();
        $newpatta = 0;
        $newdag = 0;
        foreach ($patta_no as $p) {
            $p = $p->patta_no;
            $p = (int) ($p);
            if ($newpatta < $p) {
                $newpatta = $p;
            }
        }
        foreach ($dag as $d) {
            $d = $d->dag_no;
            $d = (int) ($d);
            if ($newdag < $d) {
                $newdag = $d;
            }
        }
        $data['new_dag'] = $newdag + 1;
        $data['new_patta'] = $newpatta + 1;
        $data['basuCase']=null;
        $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
        if($basundharaExist){
            $data['query']=null;
            $data['rtps']=$rtps=$this->rtpsmodel->checkBasundharaService($case_no);
            if($rtps=='RTPS'){
                $data['basundharaAttachment']=$this->rtpsmodel->searchBasundharaLink($case_no);
            }else{
                $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
            }
            $data['query']=$this->basundharamodel->QueryPost($basundharaExist);
            //get applicant detail to edit
            $data['applicants'] = $this->db->query("SELECT alotee_id, alotee_name,
            alotee_gender, alotee_gurdian, alotee_reln, case_no FROM allotment_petitioner 
            WHERE case_no=? AND dist_code=? AND subdiv_code=? AND circle_code=? AND
            mouza_pargona_code=? AND lot_no=? ORDER BY alotee_id", 
            array($case_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no))->result();

            //noc certificate
            $data['noc_cert'] = $this->mutationmodel->getNOCForACPP($case_no)->row();

            //allotment certificate
            $data['allot_cert'] = $this->mutationmodel->getAllotmentCertificateACPP($case_no)->row();
        }
        $data['_view'] = 'allotment/lmstep_one';
        $this->load->view('layouts/main',$data);
    }

    function lm_submit_old() {
        $db=  $this->session->userdata('db');
        $case_no = $this->input->post('case_no');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->input->post('vill_code');
        $q = "Select  max(order_slno) as id from    allotment_lm_note where case_no='$case_no'";
        $slno = $this->db->query($q)->row()->id;
        if ($slno == 0) {
            $slno = 1;
        } else {
            $slno = $slno + 1;
        }
        $tot_bigha = $this->input->post('tot_bigha');
        $tot_katha = $this->input->post('tot_katha');
        $tot_lessa = $this->input->post('tot_lessa');
        $p_bigha = $this->input->post('p_bigha');
        $p_katha = $this->input->post('p_katha');
        $p_lessa = $this->input->post('p_lessa');
        $new_dag = $this->input->post('new_dag');
        $new_patta = $this->input->post('new_patta');
        $revenue = $this->input->post('revenue');
        $local_tax = $this->input->post('local_tax');
        $lm_comment = $this->input->post('lm_comment');
        $allotte_k = $this->input->post('allotte_k');
        $original_alotee = $this->input->post('original_alotee');
        $posession_y = $this->input->post('posession_y');
        $p_year = $this->input->post('p_year');
        $land_use = $this->input->post('land_use');
        $three_km = $this->input->post('three_km');
        $ten_km = $this->input->post('ten_km');
        $recorded_tenant = $this->input->post('allotte_rec');
        $old_rev = $this->input->post('exist_revenue');
        $old_lc = $this->input->post('exist_local_tax');
        $new_patta_type = $this->input->post('new_patta_type');
        $new_landcode = $this->input->post('new_landcode');
        $username = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code);
        $username = " লাট মন্ডল ------ " . $username->lm_name;
        $comment = $lm_comment . $username;
        $comment = addslashes($comment);

        //var_dump($comment);
        //exit;

        $lmnote = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'circle_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'case_no' => $case_no,
            'year_no' => date('Y'),
            'certificate_ok_not' => $allotte_k,
            'original_alotee' => $original_alotee,
            'under_possesion' => $posession_y,
            'under_possesion_yr' => $p_year,
            'nature_land' => $land_use,
            'three_km_radius' => $three_km,
            'ten_km_radius' => $ten_km,
            'area_posession_b' => $p_bigha,
            'area_posession_k' => $p_katha,
            'area_posession_lc' => $p_lessa,
            't_area_posession_b' => $tot_bigha,
            't_area_posession_k' => $tot_katha,
            't_area_posession_lc' => $tot_lessa,
            'new_dag' => $new_dag,
            'new_patta' => $new_patta,
            'l_rev' => $revenue,
            'l_tax' => $local_tax,
            'date_entry' => date('Y-m-d'),
            'user_code' => $user_code,
            'lm_comment' => $comment,
            'order_slno' => $slno,
            'recorded_tenant' => $recorded_tenant,
            'old_rev' => $old_rev,
            'old_lc' => $old_lc,
            'patta_type_code' => $new_patta_type,
            'ladclass_code' => $new_landcode,
        );
        $this->db->insert('allotment_lm_note', $lmnote);
        $y_n=$this->input->post('optrad');
        if($y_n=='N'){
            $full_partial_conversion=1;
        }else{
            $full_partial_conversion=0;
        }
        $update = array(
            'lm_code' => $user_code,
            'lm_note' => 'Y',
            'lm_entry_date' => date('Y-m-d'),
            'full_partial_conversion'=>$full_partial_conversion
        );
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('circle_code', $cir_code);
        $this->db->where('case_no', $case_no);
        $this->db->update('allotment_cert_basic', $update);
        ///////
        $penUser='SK';
        $rmrk='Report given by LM';
        $this->DashboardData($case_no,$penUser,$rmrk);
        $rmk=$rmrk;
        $status='M';
        $task='LM';
        $pen='SK';
        $case=$case_no;
        $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
        //////
        $this->session->set_flashdata('message', "Case Successfully Passed with case number $case_no");
        redirect(base_url() . 'index.php/home');

        //print_r($_POST);
    }

    function skfirst() {
          $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        
        $data['cases'] = $this->db->query("Select *,ba.basundhara from allotment_cert_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and lm_note='Y' and sk_note is null and not_fresh='Y' and status='P' and co_note is not null and settlement_typ is null")->result();
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/allotment/skpendinglist', $data);
        // $this->load->view('../views/footer');

        foreach($data['cases'] as $rows){
            if($rows->es_flag == '1' && ESCALATION_ENABLE ==1 && $rows->out_of_esc == 0){
                $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
                log_message('error', '#55: Escalation ROW : '.json_encode($escRow));                         
                if(!empty($escRow)){                                                                
                    $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));                             
                    log_message('error', '#5531: Escalation details : '.json_encode($escData)); 
                    if(!empty($escData)){                                
                        $rows->escalation_date = $escData->escalation_date;
                        $rows->escalation_zone = $escData->escalation_zone;
                        $rows->assigned_date   = $escData->assigned_date;
                    }else{
                        $rows->escalation_date = 'NA';
                        $rows->escalation_zone = 'NA';
                        $rows->assigned_date   = 'NA';
                    }
                }else{
                    $rows->escalation_date = 'NA';
                    $rows->escalation_zone = 'NA';
                    $rows->assigned_date   = 'NA';
                }                            
            }
            else {
                $rows->escalation_date = 'NA';
                $rows->escalation_zone = 'NA';
            }
        }


        $data['_view'] = 'allotment/skpendinglist';
        $this->load->view('layouts/main',$data);
    }

    function skstep_two() { 
        $db=  $this->session->userdata('db');
        $case_no = $this->input->get('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $data['allotment_cb'] = $this->db->query("Select * from    allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no' ")->row();
        $data['allotment_certificate'] = $this->db->query("Select name_of_certificate from    allotment_doc_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no' and year_no='$year_no' ")->row();

        $data['cases'] = $this->db->query("Select * from    allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and case_no='$case_no' and lm_note='Y' and not_fresh='Y' and status='P' and co_note is not null")->row();
        $data['basuCase']=null;
        $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
        if($basundharaExist){
            $data['query']=null;
            $rtps=$this->rtpsmodel->checkBasundharaService($case_no);
            if($rtps=='RTPS'){
                $data['basundharaAttachment']=$this->rtpsmodel->searchBasundharaLink($case_no);
            }else{
                $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
            }
            $data['query']=$this->basundharamodel->QueryPost($basundharaExist);
            //noc certificate
            $data['noc_cert'] = $this->mutationmodel->getNOCForACPP($case_no)->row();

            //allotment certificate
            $data['allot_cert'] = $this->mutationmodel->getAllotmentCertificateACPP($case_no)->row();
        }
        $data['_view'] = 'allotment/skstep_one';
        $this->load->view('layouts/main',$data);
    }

    function sk_submit() {
        //xss & security validation starts
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }
        $resp = checkRequestValidQuery($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }    
        if($errorMessageStr != ''){
            $this->session->set_flashdata('message', $errorMessageStr);
            return redirect($_SERVER['HTTP_REFERER']);
        }
        //xss & security validation ends 
        $db=  $this->session->userdata('db');
        $case_no = $this->input->post('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $sk_comment = addslashes($this->input->post('sk_comment'));
        $user_code = $this->session->userdata('user_code');
        $skname = $this->utilityclass->getSKByCode($dist_code, $subdiv_code, $cir_code, $user_code);
        $name = $skname->username;
        $sk_comment = $sk_comment . " কাননগোহ -----" . $name;

        $this->db->trans_begin();

        $update = array(
            'sk_code' => $user_code,
            'sk_note' => 'Y',
            'sk_entry_date' => date('Y-m-d')
        );
        $sknote = array(
            'sk_code' => $user_code,
            'sk_comment' => $sk_comment,
            'sk_date_entry' => date('Y-m-d')
        );

        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('circle_code', $cir_code);
        $this->db->where('case_no', $case_no);
        $this->db->update('allotment_cert_basic', $update);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('circle_code', $cir_code);
        $this->db->where('case_no', $case_no);
        $this->db->update('allotment_lm_note', $sknote);
        $this->session->set_flashdata('message', "Case Successfully Passed with case number $case_no");

        //////
        $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
        if($basundharaExist)
        {
            $penUser='CO';
            $rmrk='Report given by SK';
            $this->DashboardData($case_no,$penUser,$rmrk);
            $rmk=$rmrk;
            $status='M';
            $task='SK';
            $pen='CO';
            $case=$case_no;
            $API = $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);

            if(trim(strtolower($API)) != 'y'){
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERR1471: Unable to process! Something went wrong... $case_no");
                redirect(base_url() . 'index.php/home');
            }
        }

        $getLoc = $this->db->query('select * from allotment_cert_basic where case_no = ?', array($case_no));
        if($getLoc->num_rows() <= 0){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "ERR862: Something went wrong! Unable to process... $case_no");
            redirect(base_url() . 'index.php/home');
        }

        $locRow = $getLoc->row();

        
        $append = "dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$locRow->mouza_pargona_code' and lot_no='$locRow->lot_no' and ". "vill_townprt_code='$locRow->vill_townprt_code'";
        
        $pb = $this->db->query("select * from allotment_cert_basic where case_no='$case_no' and $append")->row();
        //ESCALATION CODE INTEGRATION================SANMRI
        // $executionDate = $this->input->post('executionDate');
        $executionDate = date('Y-m-d H:i:s');
        $user_code = $this->session->userdata('user_code');
        $es_flag = $pb->es_flag;

        if($es_flag == 1 && ESCALATION_ENABLE ==1 && $pb->out_of_esc == 0){

            $escalationUpdateStatus = $this->Escalationmodel->escalationSKFirstProcedingAllotment($executionDate,$dist_code,$subdiv_code,$cir_code,$locRow->mouza_pargona_code,$locRow->lot_no,$case_no,$user_code);

            log_message("error", "#ESC535803, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

            if($escalationUpdateStatus['responseType'] == 0){
                $this->db->trans_rollback();
                log_message('error', '#ESC535803: Updation failed in escalation for case no :'. $case_no);
                $json = [
                    'errorMessage'=>"#ESC535803: Updation failed on escalation for Case No ".$case_no
                ];
                echo json_encode($json);
                return false;
            }
        }

        $this->db->trans_commit();
        $this->session->set_flashdata('message', "Case Successfully Passed with case number $case_no");
        redirect(base_url() . 'index.php/home');
    }

    function passtobo() {

        $allowed = ['DC', 'ADC'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        //$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $user_code = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');

        //************INTEGRATE CIRCLE MAPPING***************
        $circle_bifurcate = ''; 
        if(CIRCLE_BIRFURCATE_ADC == 1 && $this->session->userdata('user_desig_code') == 'ADC')
        {
            $flag = 'ALLOTMENT';
            $circle_bifurcate = $this->circleMappingModel->caseListUnderMappingCircleOfADC($flag);
        }
        //************END************************************

        if($user_desig_code=='ADC'){
            $data['cases'] = $this->db->query("select *,ba.basundhara from allotment_cert_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree  where es_flag= '0' and status = 'R' and co_code is not null and dist_code='$dist_code' and dc_code is null and (adc_code='$user_code' or adc_code is null) and settlement_typ is null $circle_bifurcate")->result();
        }

        else
        {
            $data['cases'] = $this->db->query("select *,ba.basundhara from allotment_cert_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree  where es_flag= '0' and status = 'R' and co_code is not null and dist_code='$dist_code' and dc_code is null and settlement_typ is null $circle_bifurcate")->result();
        }

        // echo $this->db->last_query();
        //$this->load->helper('html');
        //$this->load->view('../views/header');
        //$this->load->view('../views/allotment/dcpendinglist', $data);
        //$this->load->view('../views/footer');

        foreach($data['cases'] as $rows){
            if($rows->es_flag == '1' && ESCALATION_ENABLE ==1){
                $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
                log_message('error', '#55: Escalation ROW : '.json_encode($escRow));                         
                if(!empty($escRow)){                                                                
                    $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));                             
                    log_message('error', '#5531: Escalation details : '.json_encode($escData)); 
                    if(!empty($escData)){                                
                        $rows->escalation_date = $escData->escalation_date;
                        $rows->escalation_zone = $escData->escalation_zone;
                        $rows->assigned_date   = $escData->assigned_date;
                    }else{
                        $rows->escalation_date = 'NA';
                        $rows->escalation_zone = 'NA';
                        $rows->assigned_date   = 'NA';
                    }
                }else{
                    $rows->escalation_date = 'NA';
                    $rows->escalation_zone = 'NA';
                    $rows->assigned_date   = 'NA';
                }                            
            }
            else {
                $rows->escalation_date = 'NA';
                $rows->escalation_zone = 'NA';
            }
        }

        $data['_view'] = 'allotment/dcpendinglist';
        $this->load->view('layouts/main',$data);
    }

    function dcstepone() {

        $_GET['case_no'] = dec_param($this->input->get('case_no'), 'case_no');
        if($_GET['case_no'] == null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
        return;
        }

        $allowed = ['DC', 'ADC'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $case_no = $this->input->get('case_no');

        $getLoc = $this->db->query('select * from allotment_cert_basic where case_no = ?', array($case_no));
        $locRow = $getLoc->row();
        if(ESCALATION_ENABLE == 1 && $locRow->es_flag == 1)
        {
            $data['allotment_cb'] = $alcb = $this->db->query("select * from    allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and case_no='$case_no' and bo_note is not null and dc_code is null ")->row();
        }
        else
        {
            $data['allotment_cb'] = $alcb = $this->db->query("select * from    allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and case_no='$case_no' and bo_note is null and dc_code is null ")->row();
        }
        
        $subdiv_code = $alcb->subdiv_code;
        $circle_code = $alcb->circle_code;
        $data['circlename'] = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $circle_code);
        $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
        if($basundharaExist){
            $data['rtps']=$rtps=$this->rtpsmodel->checkBasundharaService($case_no);
            if($rtps=='RTPS'){
                $data['basundharaAttachment']=$this->rtpsmodel->searchBasundharaLink($case_no);
            }else{
                $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
            }
        }
        $data['allot_cert'] = $this->mutationmodel->getAllotmentCertificateACPP($case_no)->row();



        //****Escalation */
        
        if($getLoc->num_rows() <= 0){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "ERR862: Something went wrong! Unable to process... $case_no");
            redirect(base_url() . 'index.php/home');
        }
        
        $append = "dist_code='$locRow->dist_code' and subdiv_code='$locRow->subdiv_code' and circle_code='$locRow->circle_code' and mouza_pargona_code='$locRow->mouza_pargona_code' and lot_no='$locRow->lot_no' and ". "vill_townprt_code='$locRow->vill_townprt_code'";
        
        $pb = $this->db->query("select * from allotment_cert_basic where case_no='$case_no' and $append")->row();

        $flag = false;
        $remaining_days_DC = 0;
        if($pb->es_flag == 1 && ESCALATION_ENABLE == 1){
            //remaining Days of LM ============
            $escalatedRowDetailsAgainstPetitionno = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($case_no);
            if(empty($escalatedRowDetailsAgainstPetitionno) || $escalatedRowDetailsAgainstPetitionno == null)
            {
                $this->session->set_flashdata('message', "Something went wrong.ALLOT- Error Code(#ESC74047)");
                redirect(base_url() . "index.php/home");
            }

            $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            $remaining_days_CO = $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO,$originalAllocation);

            //remaining days of CO==============
            $originalAllocationDC   = $escalatedRowDetailsAgainstPetitionno->dc_target_days;
            $previousCompletedDaysDC = $escalatedRowDetailsAgainstPetitionno->dc_completed_days;
            $remaining_days_DC= $this->Escalationmodel->getRemainingDays($previousCompletedDaysDC,$originalAllocationDC);
            if($remaining_days_CO == 0){
                $flag = true;
            }else{
                $flag = false;
            }
        }
        $data['escalation_flag'] = $pb->es_flag;
        $data['flag'] = $flag;
        $data['remaining_days_DC'] = $remaining_days_DC;

        $data['_view'] = 'allotment/dc_firstorder';
        $this->load->view('layouts/main',$data);
    }


    function savedcorder() {

        $allowed = ['DC', 'ADC'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        //xss & security validation starts
         $errorMessageStr = '';
         $resp = checkRequestSpecChar($_POST);
         if($resp['status'] == 'n'){
             $errorMessageStr .= $resp['messages'];
         }
         $resp = checkRequestValidQuery($_POST);
         if($resp['status'] == 'n'){
             $errorMessageStr .= $resp['messages'];
         }    
         if($errorMessageStr != ''){
            $this->session->set_flashdata('message', $errorMessageStr);
             return redirect($_SERVER['HTTP_REFERER']);
         }
        //xss & security validation ends 
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $case_no = $this->input->post('case_no');
        $comment = $this->input->post('dc_comment');
        $name = $this->utilityclass->dcname($dist_code, $user_code);
        $name = " উপায়ুক্ত / অতিৰিক্ত উপায়ুক্ত  ---" . $name;
        $merge = $comment . $name;
        $next_hearing = $this->input->post('next_hearing');

        $this->db->trans_begin();

        $q = "Select max(proceeding_id)+1 as p from petition_proceeding_dc_adc where case_no='$case_no' ";
        $count = $this->db->query($q)->row()->p;
        if ($count == 0) {
            $count = $count + 1;
        }
        $insert = array(
            'case_no' => $case_no,
            'proceeding_id' => $count,
            'date_of_hearing' => date('Y-m-d'),
            'co_order' => $merge,
            'next_date_of_hearing' => (ESCALATION_ENABLE == 1)?date('Y-m-d H:i:s', strtotime($this->input->post('next_date'))) : date('Y-m-d', strtotime($this->input->post('next_date'))),
            'status' => 'Pending',
            'user_code' => $user_code,
            'date_entry' => date('Y-m-d'),
            'operation' => 'E',
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code
        );
        //var_dump($insert);
        $insert_proc = $this->db->insert('petition_proceeding_dc_adc', $insert);
        if($insert_proc != 1){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#ERR1695: Unable to process! Someting went wrong... $case_no");
            redirect(base_url() . 'index.php/home');
        }

        if ($next_hearing == 'R') {
            $update = array(
                'dc_code' => $user_code,
                'dc_entry_date' => date('Y-m-d'),
                'dc_note' => $merge
            );

            /////
            $penUser='CO';
            $rmrk='Order given By DC';
            $this->DashboardData($case_no,$penUser,$rmrk);
            $rmk=$rmrk;
            $status='M';
            $task='DC';
            $pen='BO';
            $case=$case_no;
            $API = $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
            ////
        }
        if ($next_hearing == 'P') {
            $update = array(
                'dc_code' => null,
                'dc_entry_date' => null,
                'dc_note' => $merge,
                'co_note' => null,
                'bo_code' => null,
                'co_entry_date' => null,
                'bo_date_entry' => null,
                'status' => 'P'
            );

            ////////////////////////////////////////
            $penUser='CO';
            $rmrk='Revert back By DC';
            $this->DashboardData($case_no,$penUser,$rmrk);
            $rmk=$rmrk;
            $status='M';
            $task='DC';
            $pen='CO';
            $case=$case_no;
            $API = $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
            ////////////////////////////////////////
        }
        if ($next_hearing == 'D') {
            $update = array(
                'dc_code' => $user_code,
                'dc_entry_date' => date('Y-m-d'),
                'dc_note' => $merge,
                'status' => 'F',
                'next_date_hearing' => (ESCALATION_ENABLE == 1) ? date('Y-m-d H:i:s') : date('Y-m-d'),
            );

            ////////////////////////////////////////
            $this->DashboardDataFinal($case_no);
            $rmk="Rejected";
            $status='R';
            $task='DC';
            $pen='NA';
            $case=$case_no;
            $API = $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
            ////////////////////////////////////////
        }
        //var_dump($update);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('case_no', $case_no);
        $this->db->update('allotment_cert_basic', $update);
        if($this->db->affected_rows() == 0){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#ERR1768: Unable to process! Someting went wrong... $case_no");
            redirect(base_url() . 'index.php/home');
        }

        if(trim(strtolower($API)) != 'y'){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#ERR1773: Unable to process! Someting went wrong... $case_no");
            redirect(base_url() . 'index.php/home');
        }

        $getLoc = $this->db->query('select * from allotment_cert_basic where case_no = ?', array($case_no));
        if($getLoc->num_rows() <= 0){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "ERR862: Something went wrong! Unable to process... $case_no");
            redirect(base_url() . 'index.php/home');
        }

        $locRow = $getLoc->row();

        
        $append = " dist_code='$locRow->dist_code' and subdiv_code='$locRow->subdiv_code' and circle_code='$locRow->circle_code' and mouza_pargona_code='$locRow->mouza_pargona_code' and lot_no='$locRow->lot_no' and ". "vill_townprt_code='$locRow->vill_townprt_code'";
        
        $pb = $this->db->query("select * from allotment_cert_basic where case_no='$case_no' and $append")->row();
        //ESCALATION CODE INTEGRATION================SANMRI
        // $executionDate = $this->input->post('executionDate');
        $executionDate = date('Y-m-d H:i:s');
        $user_code = $this->session->userdata('user_code');
        $es_flag = $pb->es_flag;

        if($es_flag == 1 && ESCALATION_ENABLE ==1){

            if ($next_hearing == 'R'){
                $escalationUpdateStatus = $this->Escalationmodel->escalationDCFirstProcedingAllotment($executionDate,$locRow->dist_code,$locRow->subdiv_code,$locRow->circle_code,$locRow->mouza_pargona_code,$locRow->lot_no,$case_no,$user_code);

                log_message("error", "#ESC5803, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

                if($escalationUpdateStatus['responseType'] == 0){
                    $this->db->trans_rollback();
                    log_message('error', '#ESC35803: Updation failed in escalation for case no :'. $case_no);
                    $json = [
                        'errorMessage'=>"#ESC35803: Updation failed on escalation for Case No ".$case_no
                    ];
                    echo json_encode($json);
                    return false;
                }
            }elseif($next_hearing == 'P'){
                //****revert to CO */
                //ESCALATION CODE INTEGRATION================SANMRI
                $getLoc = $this->db->query('select * from allotment_cert_basic where case_no = ?', array($case_no));
                if($getLoc->num_rows() <= 0){
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "ERR862: Something went wrong! Unable to process... $case_no");
                    redirect(base_url() . 'index.php/home');
                }
                $locRow = $getLoc->row();
                $append = "dist_code='$locRow->dist_code' and subdiv_code='$locRow->subdiv_code' and circle_code='$locRow->circle_code' and mouza_pargona_code='$locRow->mouza_pargona_code' and lot_no='$locRow->lot_no' and ". "vill_townprt_code='$locRow->vill_townprt_code'";
                
                $pb = $this->db->query("select * from allotment_cert_basic where case_no='$case_no' and $append")->row();
                if($pb->es_flag == 1 && ESCALATION_ENABLE ==1){
                    $user_code = $this->session->userdata('user_code');
                    // $executionDate = $this->input->post('executionDate');
                    $executionDate = date('Y-m-d H:i:s');
                    $allocation_days = null;

                    // if($this->input->post('allocate_day') !=null){
                    //     $allocation_days = $this->input->post('allocate_day');
                    // }
                    if (isset($_POST['allocate_day'])) {
                        $allocation_days = $this->input->post('allocate_day');
                        if(empty($allocation_days)){
                            $this->session->set_flashdata('message', "#ERR1034: Please select allocated days... $case_no");
                            redirect(base_url() . 'index.php/home');
                        }
                    }

                    $escalationUpdateStatus = $this->Escalationmodel->escalationDCRevertToCoALOT($executionDate,$locRow->dist_code,$locRow->subdiv_code,$locRow->circle_code,$case_no,$user_code,$locRow->mouza_pargona_code,$locRow->lot_no,$allocation_days);

                    log_message("error", "#ESC4152, transaction-error-STATUS======".json_encode($escalationUpdateStatus));
                    if($escalationUpdateStatus['responseType'] == 0){
                        $this->db->trans_rollback();
                        log_message("error", "#ESC4152, transaction-error in method 'LandReclassification/revertToLMReclassByCOEscalation' with case-no :". $case_no);
                        $this->session->set_flashdata('message', "Something went wrong.RECLASS- Error Code(#ESC4152)");
                        redirect(base_url() . "index.php/home");
                    }
                    ///////////////END ESCALATION//////////////
                }
				
            }elseif($next_hearing == 'D'){
                //******reject */
                //ESCALATION CODE INTEGRATION================SANMRI
                $getLoc = $this->db->query('select * from allotment_cert_basic where case_no = ?', array($case_no));
                if($getLoc->num_rows() <= 0){
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "ERR1984862: Something went wrong! Unable to process... $case_no");
                    redirect(base_url() . 'index.php/home');
                }
                $locRow = $getLoc->row();
                $append = "dist_code='$locRow->dist_code' and subdiv_code='$locRow->subdiv_code' and circle_code='$locRow->circle_code' and mouza_pargona_code='$locRow->mouza_pargona_code' and lot_no='$locRow->lot_no' and ". "vill_townprt_code='$locRow->vill_townprt_code'";
                
                $pb = $this->db->query("select * from allotment_cert_basic where case_no='$case_no' and $append")->row();
                if($pb->es_flag == 1 && ESCALATION_ENABLE ==1){
                    $user_code = $this->session->userdata('user_code');
                    // $executionDate = $this->input->post('executionDate');
                    $executionDate = date('Y-m-d H:i:s');

                    $escalationUpdateStatus = $this->Escalationmodel->escalationDCRejectALOT($executionDate,$locRow->dist_code,$locRow->subdiv_code,$locRow->circle_code,$case_no,$user_code,$locRow->mouza_pargona_code,$locRow->lot_no);
                    
                    log_message("error", "#ESC204152, transaction-error-STATUS======".json_encode($escalationUpdateStatus));
                    if($escalationUpdateStatus['responseType'] == 0){
                        $this->db->trans_rollback();
                        log_message("error", "#ESC204152, transaction-error in method 'LandReclassification/revertToLMReclassByCOEscalation' with case-no :". $case_no);
                        $this->session->set_flashdata('message', "Something went wrong.RECLASS- Error Code(#ESC204152)");
                        redirect(base_url() . "index.php/home");
                    }
                    ///////////////END ESCALATION//////////////
                }

            }
            else{
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERR1811: Unable to process! Someting went wrong... $case_no");
                redirect(base_url() . 'index.php/home');
            }
        }


        $this->db->trans_commit();
        $this->session->set_flashdata('message', "Case Successfully Passed with case number $case_no");
        redirect(base_url() . 'index.php/home');
    }

    function pendingfinalorder() {

        $allowed = ['DC', 'ADC'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        //$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');

        //************INTEGRATE CIRCLE MAPPING***************
        $circle_bifurcate = ''; 
        if(CIRCLE_BIRFURCATE_ADC == 1 && $this->session->userdata('user_desig_code') == 'ADC')
        {
            $flag = 'ALLOTMENT';
            $circle_bifurcate = $this->circleMappingModel->caseListUnderMappingCircleOfADC($flag);
        }
        //************END************************************

        if(ESCALATION_ENABLE == 1)
        {
            $q = "select distinct on (fmb.case_no) *, ba.basundhara from allotment_cert_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree     where status = 'R' and co_code is not null and dist_code='$dist_code' and bo_note is not null and dc_note is null and es_flag ='1' $circle_bifurcate";
            $esc_data_allot = $this->db->query($q)->result();

            $q1 = "select distinct on (fmb.case_no) *, ba.basundhara from allotment_cert_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree     where status = 'R' and co_code is not null and dist_code='$dist_code' and bo_note is not null and dc_note is not null and es_flag ='0' $circle_bifurcate";

            $esc_data_allot1 = $this->db->query($q1)->result();

            $data_allot = array_merge($esc_data_allot,$esc_data_allot1);

        }
        else
        {
            $q = "select distinct on (fmb.case_no) *, ba.basundhara from allotment_cert_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree     where status = 'R' and co_code is not null and dist_code='$dist_code' and bo_note is not null and dc_note is not null and es_flag ='0' $circle_bifurcate";
            $data_allot = $this->db->query($q)->result();
        }
        
        $data['cases'] = $data_allot;
        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/allotment/finalpendinglist', $data);
        // $this->load->view('../views/footer');

        foreach($data['cases'] as $rows){
            if($rows->es_flag == '1' && ESCALATION_ENABLE ==1 && $rows->out_of_esc == 0){
                $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
                log_message('error', '#55: Escalation ROW : '.json_encode($escRow));                         
                if(!empty($escRow)){                                                                
                    $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));                             
                    log_message('error', '#5531: Escalation details : '.json_encode($escData)); 
                    if(!empty($escData)){                                
                        $rows->escalation_date = $escData->escalation_date;
                        $rows->escalation_zone = $escData->escalation_zone;
                        $rows->assigned_date   = $escData->assigned_date;
                    }else{
                        $rows->escalation_date = 'NA';
                        $rows->escalation_zone = 'NA';
                        $rows->assigned_date   = 'NA';
                    }
                }else{
                    $rows->escalation_date = 'NA';
                    $rows->escalation_zone = 'NA';
                    $rows->assigned_date   = 'NA';
                }                            
            }
            else {
                $rows->escalation_date = 'NA';
                $rows->escalation_zone = 'NA';
            }
        }

        $data['_view'] = 'allotment/finalpendinglist';
        $this->load->view('layouts/main',$data);
    }

    function dcfinalorder() {

        $_GET['case_no'] = dec_param($this->input->get('case_no'), 'case_no');
        if($_GET['case_no'] == null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
        return;
        }

        $allowed = ['DC', 'ADC'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }


        //$db=  $this->session->userdata('db');
        $case_no   = $this->input->get('case_no');
        $dist_code = $this->session->userdata('dist_code');

        $esCheckQuery = "select  * from    allotment_cert_basic where case_no = ?";
        $es_flag = $this->db->query($esCheckQuery,array($case_no))->row()->es_flag;

        if(ESCALATION_ENABLE == 1 && $es_flag == 1)
        {
            $q = "select  * from    allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and case_no='$case_no' and bo_note is not null and dc_note is null ";
        }
        else
        {
            $q = "select  * from    allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and case_no='$case_no' and bo_note is not null and dc_note is not null ";
        }

        $data['allotment_cb'] = $acb = $this->db->query($q)->row();
         ///////////// BARAK VALLEY CODE START HERE ////////////////
        $q = "Select new_dag,new_patta,area_posession_b as b,area_posession_k as k,area_posession_lc as lc, area_posession_g as g from    allotment_lm_note where case_no='$case_no'";
        ///////////// BARAK VALLEY CODE ENDS HERE ////////////////
        $data['allotment_d_p'] = $this->db->query($q)->row();
        $q = "SElect dag_no as d from    allotment_pet_dag where case_no='$case_no'";
        $data['old_dag'] = $this->db->query($q)->row();
        $data['mouza'] = $this->utilityclass->getMouzaName($dist_code, $acb->subdiv_code, $acb->circle_code, $acb->mouza_pargona_code);
        $data['vill'] = $this->utilityclass->getVillageName($dist_code, $acb->subdiv_code, $acb->circle_code, $acb->mouza_pargona_code, $acb->lot_no, $acb->vill_townprt_code);
        $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
        if($basundhara){
            $rtps=$this->rtpsmodel->checkBasundharaService($case_no);
            if($rtps=='RTPS'){
                $data['basundharaAttachment']=$this->rtpsmodel->searchBasundharaLink($case_no);
            }else{
                $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
            }
        }
        $data['_view'] = 'allotment/dc_finalorder';
        $this->load->view('layouts/main',$data);

    }

    function savefinalorder() {

        $allowed = ['DC', 'ADC'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        //xss & security validation starts
         $errorMessageStr = '';
         $resp = checkRequestSpecChar($_POST);
         if($resp['status'] == 'n'){
             $errorMessageStr .= $resp['messages'];
         }
         $resp = checkRequestValidQuery($_POST);
         if($resp['status'] == 'n'){
             $errorMessageStr .= $resp['messages'];
         }    
         if($errorMessageStr != ''){
            $this->session->set_flashdata('message', $errorMessageStr);
             return redirect($_SERVER['HTTP_REFERER']);
         }
        //xss & security validation ends 
        //$db=  $this->session->userdata('db');
        //print_r($_POST);
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        $case_no = $this->input->post('case_no');
        $comment = addslashes($this->input->post('dc_comment'));
        
        if(ESCALATION_ENABLE == 1)
    	{
    	    $status = $this->input->post('next_hearing');
	        $next_status = $this->input->post('next_hearing');
	        $next_date_hear = $this->input->post('next_date').date(' H:i:s');

            //////////update the time frame if DC done the final order//////////////
            if ($next_status == 'F')
            {
                $acbt = $this->db->query("select * from allotment_cert_basic where case_no='$case_no'")->row();
                if($acbt->es_flag ==1 )
                {
                    $executionDate = date('Y-m-d H:i:s');
                    $user_desig_code = $this->session->userdata('user_desig_code');
                    $escalationUpdateTimeFrame = $this->Escalationmodel->escalationUpdateTimeFrame($executionDate,$dist_code,$case_no,$user_code,$user_desig_code,'ACPP');
                    log_message("error", "#ESC2567, transaction-error-STATUS======".json_encode($escalationUpdateTimeFrame));
                    if($escalationUpdateTimeFrame['responseType'] == 1)
                    {
                        log_message("error", "#ESC2567, transaction-error in method 'Allotment/savefinalorder' with case-no :". $case_no);
                        $this->session->set_flashdata('message', "Something went wrong.ACPP- Error Code(#ESC2567)");
                        redirect(base_url() . "index.php/home");
                    }
                    ////////////////////END////////////////////////////
                }
            }

    	}
        else
    	{
    	    $status = $this->input->post('next_hearing');
	        $next_status = $this->input->post('next_hearing');
	        $next_date_hear = $this->input->post('next_date');
   		}
        		
        $name = $this->utilityclass->dcname($dist_code, $user_code);

        $this->db->trans_begin();

        ///////////// BARAK VALLEY CODE START HERE ////////////////
        if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
            $name = " জেলা প্রশাসক / অতিরিক্ত জেলা প্রশাসক  ---" . $name;
        }
        else {
            $name = " উপায়ুক্ত / অতিৰিক্ত উপায়ুক্ত  ---" . $name;    
        }
        
        ///////////// BARAK VALLEY CODE END HERE ////////////////
        $merge = $comment . $name;
        $q = "Select max(proceeding_id)+1 as p from    petition_proceeding_dc_adc where case_no='$case_no' ";
        $count = $this->db->query($q)->row()->p;
        if ($count == 0) {
            $count = $count + 1;
        }
        $insert = array(
            'case_no' => $case_no,
            'proceeding_id' => $count,
            'date_of_hearing' => date('Y-m-d'),
            'co_order' => $merge,
            'next_date_of_hearing' => date('Y-m-d', strtotime($this->input->post('next_date'))),
            'status' => 'Pending',
            'user_code' => $user_code,
            'date_entry' => date('Y-m-d'),
            'operation' => 'E',
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code
        );
        ///var_dump($insert);
        $insert_proc = $this->db->insert('petition_proceeding_dc_adc', $insert);

        if($insert_proc != 1){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#ERR1949: Unable to process! Something went wrong... $case_no");
            redirect(base_url() . 'index.php/home');
        }

        if ($status == 'R') {
            $update = array(
                'dc_code' => $user_code,
                'dc_entry_date' => date('Y-m-d'),
                'dc_note' => $merge,
                'bo_note' => null
            );

             ////////////////////////////////////////
            $penUser='BO';
            $rmrk='Order given By DC';
            $this->DashboardData($case_no,$penUser,$rmrk);
            $rmk=$rmrk;
            $status='M';
            $task='DC';
            $pen='BO';
            $case=$case_no;
            $API = $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
            ////////////////////////////////////////
        }

        if ($status == 'P') {
            $update = array(
                'dc_code' => $user_code,
                'dc_entry_date' => date('Y-m-d'),
                'dc_note' => $merge,
                'co_code' => null,
                'bo_code' => null,
                'bo_note' => null,
                'co_note' => null,
                'co_entry_date' => null,
                'status' => 'P'
            );
            ////////////////////////////////////////
            $penUser='CO';
            $rmrk='Revert back By DC to CO';
            $this->DashboardData($case_no,$penUser,$rmrk);
            $rmk=$rmrk;
            $status='M';
            $task='DC';
            $pen='CO';
            $case=$case_no;
            $API = $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
            ////////////////////////////////////////
        }

        if ($status == 'D') {
            $update = array(
                'dc_code' => $user_code,
                'dc_entry_date' => date('Y-m-d'),
                'dc_note' => $merge,
                'status' => 'D'
            );
            $this->DashboardDataFinal($case_no);
            $rmk="Rejected by DC";
            $status='R';
            $task='DC';
            $pen='NA';
            $case=$case_no;
            $API = $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
        }
        if ($status == 'F') {
            $update = array(
                'dc_code' => $user_code,
                'dc_entry_date' => date('Y-m-d'),
                'dc_note' => $merge,
                'status' => 'F',
                    //'chitha_correct_yn'=>null,
                    //'chitha_correct_date'=>date('Y-m-d')
            );
             ////////////////////////////////////////
            $penUser='CO';
            $rmrk='Order given By DC';
            $this->DashboardData($case_no,$penUser,$rmrk);
            $rmk=$rmrk;
            $status='M';
            $task='DC';
            $pen='CO';
            $case=$case_no;
            $API = $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
            ////////////////////////////////////////
        }
        //$test=$this->chithaupdate($dist_code,$subdiv_code,$cir_code,$case_no);
        //if($test==true){
        $this->db->where('dist_code', $dist_code);
        $this->db->where('case_no', $case_no);
        $this->db->update('allotment_cert_basic', $update);
        if($this->db->affected_rows() == 0){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#ERR2044: Unable to process! Something went wrong... $case_no");
            redirect(base_url() . 'index.php/home');
        }

        if(trim(strtolower($API)) != 'y'){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#ERR2049: Unable to process! Something went wrong... $case_no");
            redirect(base_url() . 'index.php/home');
        }

        $getLoc = $this->db->query('select * from allotment_cert_basic where case_no = ?', array($case_no));
        if($getLoc->num_rows() <= 0){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "ERR862: Something went wrong! Unable to process... $case_no");
            redirect(base_url() . 'index.php/home');
        }

        $locRow = $getLoc->row();


        
        $append = "dist_code='$locRow->dist_code' and subdiv_code='$locRow->subdiv_code' and circle_code='$locRow->circle_code' and mouza_pargona_code='$locRow->mouza_pargona_code' and lot_no='$locRow->lot_no' and ". "vill_townprt_code='$locRow->vill_townprt_code'";
        
        $pb = $this->db->query("select * from allotment_cert_basic where case_no='$case_no' and $append")->row();
        //ESCALATION CODE INTEGRATION================SANMRI
        // $executionDate = $this->input->post('executionDate');
        $executionDate = date('Y-m-d H:i:s');
        $user_code = $this->session->userdata('user_code');
        $es_flag = $pb->es_flag;

        if($es_flag == 1 && ESCALATION_ENABLE ==1 && $pb->out_of_esc == 0){

            if ($next_status == 'F')
            {





                $escalationUpdateStatus = $this->Escalationmodel->escalationDCFinalOrderAllotment($executionDate,$locRow->dist_code,$locRow->subdiv_code,$locRow->circle_code,$locRow->mouza_pargona_code,$locRow->lot_no,$case_no,$user_code);

                log_message("error", "#ESC5803, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

                if($escalationUpdateStatus['responseType'] == 0){
                    $this->db->trans_rollback();
                    log_message('error', '#ESC35803: Updation failed in escalation for case no :'. $case_no);
                    $json = [
                        'errorMessage'=>"#ESC35803: Updation failed on escalation for Case No ".$case_no
                    ];
                    echo json_encode($json);
                    return false;
                }
            }elseif($next_status == 'P'){
                    //****revert back to CO * L/
                //ESCALATION CODE INTEGRATION================SANMRI
                $getLoc = $this->db->query('select * from allotment_cert_basic where case_no = ?', array($case_no));
                if($getLoc->num_rows() <= 0){
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "ERR862: Something went wrong! Unable to process... $case_no");
                    redirect(base_url() . 'index.php/home');
                }
                $locRow = $getLoc->row();
                $append = "dist_code='$locRow->dist_code' and subdiv_code='$locRow->subdiv_code' and circle_code='$locRow->circle_code' and mouza_pargona_code='$locRow->mouza_pargona_code' and lot_no='$locRow->lot_no' and ". "vill_townprt_code='$locRow->vill_townprt_code'";
                
                $pb = $this->db->query("select * from allotment_cert_basic where case_no='$case_no' and $append")->row();
                if($pb->es_flag == 1 && ESCALATION_ENABLE ==1 && $pb->out_of_esc == 0){
                    $user_code = $this->session->userdata('user_code');
                    // $executionDate = $this->input->post('executionDate');
                    $executionDate = date('Y-m-d H:i:s');
                    $allocation_days = null;

                    // if($this->input->post('allocate_day') !=null){
                    //     $allocation_days = $this->input->post('allocate_day');
                    // }
                    if (isset($_POST['allocate_day'])) {
                        $allocation_days = $this->input->post('allocate_day');
                        if(empty($allocation_days)){
                            $this->session->set_flashdata('message', "#ERR1034: Please select allocated days... $case_no");
                            redirect(base_url() . 'index.php/home');
                        }
                    }

                    $escalationUpdateStatus = $this->Escalationmodel->escalationDCRevertToCoALOT($executionDate,$locRow->dist_code,$locRow->subdiv_code,$locRow->circle_code,$case_no,$user_code,$locRow->mouza_pargona_code,$locRow->lot_no,$allocation_days);

                    log_message("error", "#ESC22224152, transaction-error-STATUS======".json_encode($escalationUpdateStatus));
                    if($escalationUpdateStatus['responseType'] == 0){
                        $this->db->trans_rollback();
                        log_message("error", "#ESC22224152, transaction-error in method 'Allotment/escalationDCRevertToCoALOT' with case-no :". $case_no);
                        $this->session->set_flashdata('message', "Something went wrong.AC TO PP- Error Code(#ESC22224152)");
                        redirect(base_url() . "index.php/home");
                    }
                    ///////////////END ESCALATION//////////////
                }
            }elseif($next_status == 'D'){
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERR2094: Unable to process! Someting went wrong... $case_no");
                redirect(base_url() . 'index.php/home');
            }elseif($next_status == 'R'){
                
                //****revert back to BO * L/
                //ESCALATION CODE INTEGRATION================SANMRI
                $getLoc = $this->db->query('select * from allotment_cert_basic where case_no = ?', array($case_no));
                if($getLoc->num_rows() <= 0){
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "ERR862: Something went wrong! Unable to process... $case_no");
                    redirect(base_url() . 'index.php/home');
                }
                $locRow = $getLoc->row();
                $append = "dist_code='$locRow->dist_code' and subdiv_code='$locRow->subdiv_code' and circle_code='$locRow->circle_code' and mouza_pargona_code='$locRow->mouza_pargona_code' and lot_no='$locRow->lot_no' and ". "vill_townprt_code='$locRow->vill_townprt_code'";
                
                $pb = $this->db->query("select * from allotment_cert_basic where case_no='$case_no' and $append")->row();
                if($pb->es_flag == 1 && ESCALATION_ENABLE ==1 && $pb->out_of_esc == 0){
                    $user_code = $this->session->userdata('user_code');
                    // $executionDate = $this->input->post('executionDate');
                    $executionDate = date('Y-m-d H:i:s');
                    $allocation_days = null;

                    // if($this->input->post('allocate_day') !=null){
                    //     $allocation_days = $this->input->post('allocate_day');
                    // }
                    if (isset($_POST['allocate_day'])) {
                        $allocation_days = $this->input->post('allocate_day');
                        if(empty($allocation_days)){
                            $this->session->set_flashdata('message', "#ERR1034: Please select allocated days... $case_no");
                            redirect(base_url() . 'index.php/home');
                        }
                    }

                    $escalationUpdateStatus = $this->Escalationmodel->escalationDCRevertToBoALOT($executionDate,$locRow->dist_code,$locRow->subdiv_code,$locRow->circle_code,$case_no,$user_code,$locRow->mouza_pargona_code,$locRow->lot_no,$allocation_days);

                    log_message("error", "#ESC45454152, transaction-error-STATUS======".json_encode($escalationUpdateStatus));
                    if($escalationUpdateStatus['responseType'] == 0){
                        $this->db->trans_rollback();
                        log_message("error", "#ESC45454152, transaction-error in method 'LandReclassification/revertToLMReclassByCOEscalation' with case-no :". $case_no);
                        $this->session->set_flashdata('message', "Something went wrong.RECLASS- Error Code(#ESC45454152)");
                        redirect(base_url() . "index.php/home");
                    }
                    ///////////////END ESCALATION//////////////
                }

            }
            else{
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERR2103: Unable to process! Someting went wrong... $case_no");
                redirect(base_url() . 'index.php/home');
            }
        }

        $this->db->trans_commit();
        $this->session->set_flashdata('message', "Case Successfully Passed with case number $case_no");
        redirect(base_url() . 'index.php/home');

        // }
        // }else{
        // $this->session->set_flashdata('message', "Error found in processing with case number $case_no");
        // redirect(base_url() . 'index.php/home'); 
        // }
        //$this->db->where('dist_code', $dist_code);
        //  $this->db->where('case_no', $case_no);
        // $this->db->update('allotment_cert_basic', $update);
    }

    ////////////////////////////////////
    ////////////////////////////////////

    function chithaupdate($d, $s, $c, $case,$mouza,$lot_no,$vill) {
        $user_code = $this->session->userdata('user_code');
        $q = "SElect * from allotment_lm_note where case_no='$case' and dist_code='$d' and subdiv_code='$s' and circle_code='$c' and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill' order by date(date_entry) desc";
        $basic = $this->db->query($q)->row();
        if($basic->area_posession_b==null){
            $basic->area_posession_b=0;
        }
        if($basic->area_posession_k==null){
            $basic->area_posession_k=0;
        }
        if($basic->area_posession_lc==null){
            $basic->area_posession_lc=0;
        }
        $sumAreaTotal_1=$basic->area_posession_b+$basic->area_posession_k+$basic->area_posession_lc;
        ///////////// BARAK VALLEY CODE START HERE ////////////////
        $barak = in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY));
        if($barak){
            if($basic->area_posession_g==null){
                $basic->area_posession_g=0;
            }
            $sumAreaTotal_1=$basic->area_posession_b+$basic->area_posession_k+$basic->area_posession_lc+$basic->area_posession_g;   
            if($sumAreaTotal_1==0){
               $this->db->trans_rollback();
               log_message('error','ALLOTMENTAREA'.$case);
               $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#ALLOTMENTAREA000)Total ALlotment area can't be zero !!!");
               redirect(base_url() . "index.php/home");
            }        
        }else{
            if($sumAreaTotal_1==0){
               $this->db->trans_rollback();
               log_message('error','ALLOTMENTAREA'.$case);
               $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#ALLOTMENTAREA000)Total ALlotment area can't be zero !!!");
               redirect(base_url() . "index.php/home");
            }
        }
        ///////////// BARAK VALLEY CODE END HERE ////////////////

        $q = "SElect * from allotment_cert_basic where case_no='$case' and dist_code='$d' and subdiv_code='$s' and circle_code='$c' and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill'";
        $alb = $this->db->query($q)->row();
        $q="Select max(rmk_type_hist_no)+1 as c from chitha_rmk_gen where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill' and dag_no='$basic->new_dag' ";
        $histNo = $this->db->query($q)->row();
        //var_dump($histNo);
        //var_dump($this->session->all_userdata());
        if($histNo->c==null){
            $rmk_type_hist_no = 1;
        }else{
            $rmk_type_hist_no = $histNo->c;
        }
        
        $ord_cron_no = 1;
        
        $location = array(
            'dist_code' => $basic->dist_code,
            'subdiv_code' => $basic->subdiv_code,
            'cir_code' => $basic->circle_code,
            'mouza_pargona_code' => $basic->mouza_pargona_code,
            'lot_no' => $basic->lot_no,
            'vill_townprt_code' => $basic->vill_townprt_code,
            'dag_no' => $basic->new_dag
        );
        $r_gen = array(
            'rmk_type_code' => '10',
            'rmk_type_hist_no' => $rmk_type_hist_no,
            'user_code' => $user_code,
            'date_entry' => date('Y-m-d'),
            'operation' => 'E',
            'jama_updated' => null,
            'patta_no' => $basic->new_patta
        );
        $rmk_gen = array_merge($location, $r_gen);
        ///////////// BARAK VALLEY CODE START HERE ////////////////
        if($barak){
            $o_basic = array(
                'rmk_type_hist_no' => $rmk_type_hist_no,
                'ord_no' => $alb->case_no,
                'ord_date' => date('Y-m-d'),
                'ord_type_code' => '10',
                'ord_cron_no' => $ord_cron_no,
                'case_no' => $alb->case_no,
                'ord_passby_sign_yn' => 'Y',
                'ord_passby_desig' => $this->session->userdata('user_desig_code'),
                'lm_code' => $alb->lm_code,
                'lm_sign_yn' => 'Y',
                'lm_sign_date' => $alb->lm_entry_date,
                'sk_code' => $alb->sk_code,
                'sk_sign_yn' => 'Y',
                'sk_sign_date' => $alb->sk_entry_date,
                'co_code' => $alb->co_code,
                'co_sign_yn' => 'Y',
                'co_ord_date' => $alb->co_entry_date,
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'm_dag_area_b' => $this->utilityclass->assToeng($basic->area_posession_b),
                'm_dag_area_k' => $this->utilityclass->assToeng($basic->area_posession_k),
                'm_dag_area_lc' => $this->utilityclass->assToeng($basic->area_posession_lc),
                'm_dag_area_g' => $this->utilityclass->assToeng($basic->area_posession_g),
                'm_dag_area_kr' => '0',
                'area_left_b' => '0',
                'area_left_k' => '0',
                'area_left_lc' => '0',
                'area_left_g' => '0'
            );
        }
        else {
        $o_basic = array(
            'rmk_type_hist_no' => $rmk_type_hist_no,
            'ord_no' => $alb->case_no,
            'ord_date' => date('Y-m-d'),
            'ord_type_code' => '10',
            'ord_cron_no' => $ord_cron_no,
            'case_no' => $alb->case_no,
            'ord_passby_sign_yn' => 'Y',
            'ord_passby_desig' => $this->session->userdata('user_desig_code'),
            'lm_code' => $alb->lm_code,
            'lm_sign_yn' => 'Y',
            'lm_sign_date' => $alb->lm_entry_date,
            'sk_code' => $alb->sk_code,
            'sk_sign_yn' => 'Y',
            'sk_sign_date' => $alb->sk_entry_date,
            'co_code' => $alb->co_code,
            'co_sign_yn' => 'Y',
            'co_ord_date' => $alb->co_entry_date,
            'user_code' => $user_code,
            'date_entry' => date('Y-m-d'),
            'operation' => 'E',
            'm_dag_area_b' => $this->utilityclass->assToeng($basic->area_posession_b),
            'm_dag_area_k' => $this->utilityclass->assToeng($basic->area_posession_k),
            'm_dag_area_lc' => $this->utilityclass->assToeng($basic->area_posession_lc),
            'm_dag_area_g' => 0,
            'm_dag_area_kr' => '0',
            'area_left_b' => '0',
            'area_left_k' => '0',
            'area_left_lc' => '0',
            'area_left_g' => '0'
        );
        }
        $ord_basic = array_merge($location, $o_basic);

        $q = "SElect * from allotment_petitioner where case_no='$case' ";
        $allotp = $this->db->query($q)->result();
        $q = "SElect dag_no as dagold from allotment_pet_dag where case_no='$case' ";
        $olddag = $this->db->query($q)->row()->dagold;
        ///////////// BARAK VALLEY CODE START HERE ////////////////
        if($barak){
            $cb = array(
                'dag_no_int' => $basic->new_dag . '00',
                'patta_type_code' => $basic->patta_type_code,
                'patta_no' => $basic->new_patta,
                'land_class_code' => $basic->ladclass_code,
                'dag_area_b' => $this->utilityclass->assToeng($basic->area_posession_b),
                'dag_area_k' => $this->utilityclass->assToeng($basic->area_posession_k),
                'dag_area_lc' => $this->utilityclass->assToeng($basic->area_posession_lc),
                'dag_area_g' => $this->utilityclass->assToeng($basic->area_posession_g),
                'dag_area_kr' => 0,
                'dag_area_are' => 0,
                'dag_revenue' => $basic->l_rev,
                'dag_local_tax' => $basic->l_tax,
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'jama_yn' => null,
            );
        }
        else {
        $cb = array(
            'dag_no_int' => $basic->new_dag . '00',
            'patta_type_code' => $basic->patta_type_code,
            'patta_no' => $basic->new_patta,
            'land_class_code' => $basic->ladclass_code,
            'dag_area_b' => $this->utilityclass->assToeng($basic->area_posession_b),
            'dag_area_k' => $this->utilityclass->assToeng($basic->area_posession_k),
            'dag_area_lc' => $this->utilityclass->assToeng($basic->area_posession_lc),
            'dag_area_g' => 0,
            'dag_area_kr' => 0,
            'dag_area_are' => 0,
            'dag_revenue' => $basic->l_rev,
            'dag_local_tax' => $basic->l_tax,
            'user_code' => $user_code,
            'date_entry' => date('Y-m-d'),
            'operation' => 'E',
            'jama_yn' => null,
        );
        }
        $chitha_basic = array_merge($location, $cb);
        //echo $alb->full_partial_conversion;
        //var_dump($alb);
        if($alb->full_partial_conversion==0){
            //var_dump($chitha_basic);
            // $tstatus0 = $this->db->insert('chitha_basic', $chitha_basic);
            $tstatus0 =  $this->Chitha_basic_model->insert_table('chitha_basic',$chitha_basic);
            if($tstatus0 != 1)
            {
               $this->db->trans_rollback();
               $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#ALCB000)Please try Again. Error Code(#ALCB000). LM has selected as Partial Conversion so old dag no you can't enter !!!");
               redirect(base_url() . "index.php/home");
            }
            //////////////Update Old Dag Land Area////////////////
            $append = "dist_code = '$basic->dist_code' and subdiv_code = '$basic->subdiv_code' and cir_code = '$basic->circle_code' 
            and mouza_pargona_code = '$basic->mouza_pargona_code' and lot_no = '$basic->lot_no' and vill_townprt_code = '$basic->vill_townprt_code' and dag_no='$olddag' ";
            
            $cb="select * from chitha_basic where $append";
            $landAreacb = $this->db->query($cb)->row();            
            $total=$this->utilityclass->Total_Lessa($landAreacb->dag_area_b,$landAreacb->dag_area_k,$landAreacb->dag_area_lc);

            $q = "SElect * from allotment_pet_dag where case_no='$case' ";
            $landArea = $this->db->query($q)->row();
            // //var_dump($landArea);
            // $total=$this->utilityclass->Total_Lessa($landArea->tot_area_b,$landArea->tot_area_k,$landArea->tot_area_lc);
            ///////////// BARAK VALLEY CODE START HERE ////////////////
            if($barak){
                $converArea=$this->utilityclass->Total_ganda($this->utilityclass->assToeng($landArea->alot_area_b),$this->utilityclass->assToeng($landArea->alot_area_k),$this->utilityclass->assToeng($landArea->alot_area_lc),$this->utilityclass->assToeng($landArea->alot_area_g));
                $remanLanArea=$total-$converArea;
                $remanLanArea=$this->utilityclass->Total_Bigha_Katha_Lessa2($remanLanArea);
                $bigha=$remanLanArea[0];
                $katha=$remanLanArea[1];
                $lessa=$remanLanArea[2];
                $ganda=$remanLanArea[3];
                $cbArray=array(
                    'dag_area_b' => $bigha,
                    'dag_area_k' => $katha,
                    'dag_area_lc' => $lessa,
                    'dag_area_g' => $ganda,
                    'user_code' => $user_code,
                    'date_entry' => date('Y-m-d'),
                );
            }
            else {

            $converArea=$this->utilityclass->Total_Lessa($this->utilityclass->assToeng($landArea->alot_area_b),$this->utilityclass->assToeng($landArea->alot_area_k),$this->utilityclass->assToeng($landArea->alot_area_lc));
            $remanLanArea=$total-$converArea;
            $remanLanArea=$this->utilityclass->Total_Bigha_Katha_Lessa($remanLanArea);
            $bigha=$remanLanArea[0];
            $katha=$remanLanArea[1];
            $lessa=$remanLanArea[2];
            $cbArray=array(
                'dag_area_b' => $bigha,
                'dag_area_k' => $katha,
                'dag_area_lc' => $lessa,
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d'),
            );

            }
            // $this->db->where('dist_code',  $basic->dist_code);
            // $this->db->where('subdiv_code',  $basic->subdiv_code);
            // $this->db->where('cir_code',  $basic->circle_code);
            // $this->db->where('mouza_pargona_code', $basic->mouza_pargona_code);
            // $this->db->where('lot_no', $basic->lot_no);
            // $this->db->where('vill_townprt_code', $basic->vill_townprt_code);
            // $this->db->where('dag_no', $landArea->dag_no);
            
            // $this->db->update('chitha_basic', $cbArray);
            $where = [
                'dist_code'           => $basic->dist_code,
                'subdiv_code'         => $basic->subdiv_code,
                'cir_code'            => $basic->circle_code,
                'mouza_pargona_code'  => $basic->mouza_pargona_code,
                'lot_no'              => $basic->lot_no,
                'vill_townprt_code'   => $basic->vill_townprt_code,
                'dag_no'              => $landArea->dag_no,
            ];

            $table = 'chitha_basic';
            // Call model's reusable update method
            $result0 = $this->Chitha_basic_model->update_table($table, $cbArray, $where);

            if($result0 <=0)
            {
               $this->db->trans_rollback();
               $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#ALCB001).. Please check the dag no exists or not. Dag no might may change..");
               redirect(base_url() . "index.php/home");
            }
            //exit;
        }else{
            $cb_update=array(
                    'patta_type_code' => $basic->patta_type_code,
                    'patta_no' => $basic->new_patta,
                    'land_class_code' => $basic->ladclass_code,
                    'dag_revenue' => $basic->l_rev,
                    'dag_local_tax' => $basic->l_tax,
                    'user_code' => $user_code,
                    'date_entry' => date('Y-m-d'),
                    'operation' => 'E',
                    'jama_yn' => null,
            );
            //var_dump($cb_update);
            // $this->db->where($location);
            //$this->db->where('dist_code', $case_no);
            $table = 'chitha_basic';
            $this->Chitha_basic_model->update_table($table, $cb_update, $location);
            // $this->db->update('chitha_basic', $cb_update);

            if($this->db->affected_rows()<=0)
            {
               $this->db->trans_rollback();
               $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#ALCB002)...LM has selected as Full Conversion so new dag no you can't enter !!!");
               redirect(base_url() . "index.php/home");
            }  
        }     
        foreach ($allotp as $alp) {
            if($barak){
                $allotee = array(
                    'rmk_type_hist_no' => $rmk_type_hist_no,
                    'ord_no' => $alb->case_no,
                    'ord_date' => date('Y-m-d'),
                    'ord_cron_no' => $ord_cron_no,
                    //'ord_ref_let_no'=> character varying(45),
                    'allottee_id' => $alp->alotee_id,
                    'allottee_name' => $alp->alotee_name,
                    'allottee_guardian' => $alp->alotee_gurdian,
                    'allottee_guar_relation' => $alp->alotee_reln,
                    //allottee_type_code character varying(2),
                    //allottee_land_code character varying(2),
                    'type_of_allotment' => $alb->allotment_under,
                    //'allottee_since'=> timestamp without time zone,
                    'allottee_land_b' => $this->utilityclass->assToeng($basic->area_posession_b),
                    'allottee_land_k' => $this->utilityclass->assToeng($basic->area_posession_k),
                    'allottee_land_lc' => $this->utilityclass->assToeng($basic->area_posession_lc),
                    'allottee_land_g' => $this->utilityclass->assToeng($basic->area_posession_g),
                    'allottee_land_kr' => 0,
                    'land_revenue' => $basic->l_rev,
                    'land_local_tax' => $basic->l_tax,
                    'user_code' => $user_code,
                    'date_entry' => date('Y-m-d'),
                    'operation' => 'E',
                    //'allotment_no'=>,
                    'allottee_gender' => trim($alp->alotee_gender),
                    'patta_no' => $basic->new_patta,
                    'old_dag' => $olddag,
                    'doul_year' => date('Y')
                );
            }
            else
            {
            $allotee = array(
                'rmk_type_hist_no' => $rmk_type_hist_no,
                'ord_no' => $alb->case_no,
                'ord_date' => date('Y-m-d'),
                'ord_cron_no' => $ord_cron_no,
                //'ord_ref_let_no'=> character varying(45),
                'allottee_id' => $alp->alotee_id,
                'allottee_name' => $alp->alotee_name,
                'allottee_guardian' => $alp->alotee_gurdian,
                'allottee_guar_relation' => $alp->alotee_reln,
                //allottee_type_code character varying(2),
                //allottee_land_code character varying(2),
                'type_of_allotment' => $alb->allotment_under,
                //'allottee_since'=> timestamp without time zone,
                'allottee_land_b' => $this->utilityclass->assToeng($basic->area_posession_b),
                'allottee_land_k' => $this->utilityclass->assToeng($basic->area_posession_k),
                'allottee_land_lc' => $this->utilityclass->assToeng($basic->area_posession_lc),
                'allottee_land_g' => 0,
                'allottee_land_kr' => 0,
                'land_revenue' => $basic->l_rev,
                'land_local_tax' => $basic->l_tax,
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                //'allotment_no'=>,
                'allottee_gender' => trim($alp->alotee_gender),
                'patta_no' => $basic->new_patta,
                'old_dag' => $olddag,
                'doul_year' => date('Y')
            );
            }
            $chitha_allottee = array_merge($location, $allotee);
            //var_dump($chitha_allottee);
            $tstatus1 = $this->db->insert('chitha_rmk_allottee', $chitha_allottee);
            // echo $this->db->last_query(); die;
            if($tstatus1 != 1)
            {
               $this->db->trans_rollback();
               $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#ALCRA001)");
               redirect(base_url() . "index.php/home");
            }
            //var_dump($chitha_allottee);
            /////////////////////////////////////
            $pattadars_in_chitha_pattadar = $this->db->query("select max(pdar_id::int)+1 as cp from chitha_pattadar where 
                dist_code='$basic->dist_code' and  subdiv_code='$basic->subdiv_code' and cir_code='$basic->circle_code' and mouza_pargona_code='$basic->mouza_pargona_code' and lot_no='$basic->lot_no' and vill_townprt_code='$basic->vill_townprt_code' and patta_type_code='$basic->patta_type_code' and TRIM(patta_no)=trim('$basic->new_patta')")->row()->cp;

           $pattadars_in_jama_pattadar = $this->db->query("select max(pdar_id::int)+1 as jp from jama_pattadar where dist_code='$basic->dist_code' and subdiv_code='$basic->subdiv_code' and cir_code='$basic->circle_code' and mouza_pargona_code='$basic->mouza_pargona_code'  
                 and lot_no='$basic->lot_no' and vill_townprt_code='$basic->vill_townprt_code' and patta_type_code='$basic->patta_type_code' and 
                TRIM(patta_no)=trim('$basic->new_patta')")->row()->jp;
           $pattadars_in_chithaDag_pattadar = $this->db->query("select max(pdar_id::int)+1 as dp from chitha_dag_pattadar where 
                dist_code='$basic->dist_code' and  subdiv_code='$basic->subdiv_code' and cir_code='$basic->circle_code' and mouza_pargona_code='$basic->mouza_pargona_code' and lot_no='$basic->lot_no' and vill_townprt_code='$basic->vill_townprt_code' and patta_type_code='$basic->patta_type_code' and  TRIM(patta_no)=trim('$basic->new_patta') and dag_no='$basic->new_dag'")->row()->dp;
            
            if($pattadars_in_chitha_pattadar > $pattadars_in_jama_pattadar){
                if($pattadars_in_chithaDag_pattadar>$pattadars_in_chitha_pattadar){
                    $pdar_id= $pattadars_in_chithaDag_pattadar;
                }else{
                    $pdar_id= $pattadars_in_chitha_pattadar;
                }
            }elseif($pattadars_in_chithaDag_pattadar > $pattadars_in_jama_pattadar){
                $pdar_id= $pattadars_in_chithaDag_pattadar;
            }else{
                $pdar_id= $pattadars_in_jama_pattadar;
            }
            if($pdar_id== null){
                $pdar_id=1;
            }
            /////////////////////////////////////
            ///////////// BARAK VALLEY CODE START HERE ////////////////
            if($barak){
                $c_d_p = array(
                    'pdar_id' => $pdar_id,
                    'patta_no' => $basic->new_patta,
                    'patta_type_code' => $basic->patta_type_code,
                    'dag_por_b' => $this->utilityclass->assToeng($basic->area_posession_b),
                    'dag_por_k' => $this->utilityclass->assToeng($basic->area_posession_k),
                    'dag_por_lc' => $this->utilityclass->assToeng($basic->area_posession_lc),
                    'dag_por_g' => $this->utilityclass->assToeng($basic->area_posession_g),
                    'user_code' => $user_code,
                    'date_entry' => date('Y-m-d'),
                    'operation' => 'E',
                    'p_flag' => '0',
                    'jama_yn' => 'N',
                );
            }
            else {
            $c_d_p = array(
                'pdar_id' => $pdar_id,
                'patta_no' => $basic->new_patta,
                'patta_type_code' => $basic->patta_type_code,
                'dag_por_b' => $this->utilityclass->assToeng($basic->area_posession_b),
                'dag_por_k' => $this->utilityclass->assToeng($basic->area_posession_k),
                'dag_por_lc' => $this->utilityclass->assToeng($basic->area_posession_lc),
                'dag_por_g' => 0,
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'p_flag' => '0',
                'jama_yn' => 'N',
            );
            }
            $chitha_dag_p = array_merge($location, $c_d_p);
            // $tstatus2=$this->db->insert('chitha_dag_pattadar', $chitha_dag_p);
            $tstatus2=$this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$chitha_dag_p);
            if($tstatus2 != 1)
            {
               $this->db->trans_rollback();
               $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#ALCDP001)");
               redirect(base_url() . "index.php/home");
            }
            //var_dump($chitha_dag_p);
            $chitha_pattadar = array(
                'dist_code' => $basic->dist_code,
                'subdiv_code' => $basic->subdiv_code,
                'cir_code' => $basic->circle_code,
                'mouza_pargona_code' => $basic->mouza_pargona_code,
                'lot_no' => $basic->lot_no,
                'vill_townprt_code' => $basic->vill_townprt_code,
                'pdar_id' => $pdar_id,
                'patta_no' => $basic->new_patta,
                'patta_type_code' => $basic->patta_type_code,
                'pdar_name' => $alp->alotee_name,
                'pdar_father' => $alp->alotee_gurdian,
                'pdar_add1' => null,
                'pdar_add2' => null,
                'pdar_pan_no' => $alp->alotee_pan_card,
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'jama_yn' => 'N',
                'pdar_guard_reln' => $alp->alotee_reln,
                'pdar_gender' => $alp->alotee_gender,
                'pdar_minor_yn' => null,
                'pdar_minor_dob' => null,
                'pdar_mother' => null,
                'pdar_aadharno' => $alp->alotee_aadhar,
                'pdar_mobile' => $alp->alotee_mobile,
                // 'pdar_photo' => $alp->photo
            );
            // $tstatus3=$this->db->insert('chitha_pattadar', $chitha_pattadar);
            $chitha_pattadar['f1_case_no']=$alb->case_no;
            $tstatus3= $this->Chitha_basic_model->insert_table('chitha_pattadar',$chitha_pattadar);
            if($tstatus3 != 1)
            {
               $this->db->trans_rollback();
               $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#ALCP003)");
               redirect(base_url() . "index.php/home");
            }
        }
        $tstatus4=$this->db->insert('chitha_rmk_gen', $rmk_gen);
        if($tstatus4 != 1)
            {
               $this->db->trans_rollback();
               $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#ALCRG004)");
               redirect(base_url() . "index.php/home");
            }
        $tstatus5=$this->db->insert('chitha_rmk_ordbasic', $ord_basic);
        if($tstatus5 != 1)
            {
               $this->db->trans_rollback();
               $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#ALCRD005)");
               redirect(base_url() . "index.php/home");
            }

        if ($this->db->trans_status() == FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            return true;
        }
        //var_dump($ord_basic);
    }

    function bopending() {
        //$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $data['cases'] = $this->db->query("select *,ba.basundhara from allotment_cert_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where status = 'R' and co_code is not null and dist_code='$dist_code' and dc_note is not null and bo_note is null and settlement_typ is null")->result();

        foreach($data['cases'] as $rows){
            if($rows->es_flag == '1' && ESCALATION_ENABLE ==1){
                $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
                log_message('error', '#55: Escalation ROW : '.json_encode($escRow));                         
                if(!empty($escRow)){                                                                
                    $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));                             
                    log_message('error', '#5531: Escalation details : '.json_encode($escData)); 
                    if(!empty($escData)){                                
                        $rows->escalation_date = $escData->escalation_date;
                        $rows->escalation_zone = $escData->escalation_zone;
                        $rows->assigned_date   = $escData->assigned_date;
                    }else{
                        $rows->escalation_date = 'NA';
                        $rows->escalation_zone = 'NA';
                        $rows->assigned_date   = 'NA';
                    }
                }else{
                    $rows->escalation_date = 'NA';
                    $rows->escalation_zone = 'NA';
                    $rows->assigned_date   = 'NA';
                }                            
            }
            else {
                $rows->escalation_date = 'NA';
                $rows->escalation_zone = 'NA';
            }
        }


        // $this->load->helper('html');
        // $this->load->view('../views/header');
        // $this->load->view('../views/allotment/bopendinglistfirst', $data);
        // $this->load->view('../views/footer');

        $data['_view'] = 'allotment/bopendinglistfirst';
        $this->load->view('layouts/main',$data);
    }

    function bofirstproceeding() { 
        //$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $case_no = $this->input->get('case_no');
        $q = "select * from    allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and dc_note is not null and bo_note is null and case_no='$case_no'";
        $data['allotment_cb'] = $alcb = $this->db->query($q)->row();
        $subdiv_code = $alcb->subdiv_code;
        $circle_code = $alcb->circle_code;
        $data['circlename'] = $this->utilityclass->getCircleNamebydbload($dist_code, $subdiv_code, $circle_code);
        //$data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
        $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
        if($basundhara){
            $rtps=$this->rtpsmodel->checkBasundharaService($case_no);
	    $data['sup_doc']=$this->db->query("SELECT * FROM supportive_document WHERE case_no=?", array($case_no))->result();
            if($rtps=='RTPS'){
                $data['basundharaAttachment']=$this->rtpsmodel->searchBasundharaLink($case_no);
            }else{
                $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
            }
        }
        $data['_view'] = 'allotment/bofirstorder';
        $this->load->view('layouts/main',$data);
    }

    function saveboorder() {
        //xss & security validation starts

        $this->db->trans_begin();

            $errorMessageStr = '';
            $resp = checkRequestSpecChar($_POST);
            if($resp['status'] == 'n'){
                $errorMessageStr .= $resp['messages'];
            }
            $resp = checkRequestValidQuery($_POST);
            if($resp['status'] == 'n'){
                $errorMessageStr .= $resp['messages'];
            }   
            if($errorMessageStr != ''){
            $this->session->set_flashdata('message', $errorMessageStr);
                return redirect($_SERVER['HTTP_REFERER']);
            }
        //xss & security validation ends
        //$db=  $this->session->userdata('db');
        $user_code = $this->session->userdata('user_code');
        $case_no = $this->input->post('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $comment = addslashes($this->input->post('bo_comment'));
        $name = $this->utilityclass->getDefinedBOName($dist_code, $user_code);
        $name = $name->username;
        $name = " শাখা অফিসাৰ  ---" . $name;
        $merge = $comment . $name;
        $update_pro = array(
            'note_on_order' => $merge,
            'user_code' => $user_code,
            'date_entry' => date('Y-m-d')
        );
        $update = array(
            'bo_code' => $user_code,
            'bo_date_entry' => date('Y-m-d'),
            'bo_note' => $merge,
        );
        //var_dump($update);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('case_no', $case_no);
        $this->db->update('allotment_cert_basic', $update);

        if($this->db->affected_rows() == 0){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#ERR2613: Unable to process! Something went wrong... $case_no");
            redirect(base_url() . 'index.php/home');
        }

        ///////////////////////
        $penUser='DC';
        $rmrk='Order given by BO';
        $this->DashboardData($case_no,$penUser,$rmrk);
        $rmk=$rmrk;
        $status='M';
        $task='BO';
        $pen='DC';
        $case=$case_no;
        $API = $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
        //$id = $this->db->insert_id();
        $q = "Select max(proceeding_id) as p from    petition_proceeding_dc_adc where case_no='$case_no' ";
        $proceeding_id = $this->db->query($q)->row()->p;
        $this->db->where('dist_code', $dist_code);
        $this->db->where('case_no', $case_no);
        // $this->db->where('subdiv_code', '00');
        // $this->db->where('cir_code', '00');
        $this->db->where('proceeding_id', $proceeding_id);
        $this->db->update('petition_proceeding_dc_adc', $update_pro);
        if($this->db->affected_rows() == 0){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#ERR2641: Unable to process! Something went wrong... $case_no");
            redirect(base_url() . 'index.php/home');
        }

        if(trim(strtolower($API)) != 'y'){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#ERR2647: Unable to process! Something went wrong... $case_no");
            redirect(base_url() . 'index.php/home');
        }

        $getLoc = $this->db->query('select * from allotment_cert_basic where case_no = ?', array($case_no));
        if($getLoc->num_rows() <= 0){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "ERR862: Something went wrong! Unable to process... $case_no");
            redirect(base_url() . 'index.php/home');
        }

        $locRow = $getLoc->row();

        
        $append = "dist_code='$locRow->dist_code' and subdiv_code='$locRow->subdiv_code' and circle_code='$locRow->circle_code' and mouza_pargona_code='$locRow->mouza_pargona_code' and lot_no='$locRow->lot_no' and ". "vill_townprt_code='$locRow->vill_townprt_code'";
        
        $pb = $this->db->query("select * from allotment_cert_basic where case_no='$case_no' and $append")->row();
        //ESCALATION CODE INTEGRATION================SANMRI
        // $executionDate = $this->input->post('executionDate');
        $executionDate = date('Y-m-d H:i:s');
        $user_code = $this->session->userdata('user_code');
        $es_flag = $pb->es_flag;

        if($es_flag == 1 && ESCALATION_ENABLE ==1){

            $escalationUpdateStatus = $this->Escalationmodel->escalationBOFirstProcedingAllotment($executionDate,$locRow->dist_code,$locRow->subdiv_code,$locRow->circle_code,$locRow->mouza_pargona_code,$locRow->lot_no,$case_no,$user_code);

            log_message("error", "#ESC7735803, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

            if($escalationUpdateStatus['responseType'] == 0){
                $this->db->trans_rollback();
                log_message('error', '#ESC7735803: Updation failed in escalation for case no :'. $case_no);
                $json = [
                    'errorMessage'=>"#ESC7735803: Updation failed on escalation for Case No ".$case_no
                ];
                echo json_encode($json);
                return false;
            }
        }

        $this->db->trans_commit();
        $this->session->set_flashdata('message', "Case Successfully Passed with case number $case_no");
        redirect(base_url() . 'index.php/home');

        //var_dump($update);
    }

    /////////////////////View Application//////////////////////////////////
    function viewapplication() {
        //$db=  $this->session->userdata('db');
        $case_no = $this->input->get('case_no');
        $q = "Select * from    allotment_cert_basic where case_no='$case_no'";
        $data['certbasic'] = $this->db->query($q)->row();
        $q = "Select * from    allotment_petitioner where case_no='$case_no'";
        $data['aloteepett'] = $this->db->query($q)->result();
        $q = "Select * from    allotment_doc_details where case_no='$case_no'";
        $data['aloteedoc'] = $this->db->query($q)->row();
        $q = "Select * from    allotment_pet_dag where case_no='$case_no'";
        $data['aloteedag'] = $this->db->query($q)->row();
        //var_dump($data);
        //exit;
        //$this->load->view('../views/allotment/view_basic', $data);
        //$data['_view'] = 'allotment/view_basic';


        $params = [
          'case_no'          => $case_no,
          'service_code'     => 5,
          'remarks'          => 'AC to PP',
          'accessed_entity'  => 'Aadhaar Status (Verified or not)',
        ];
        $this->load->model('EkycLogModel');
        $log = $this->EkycLogModel->insertEkycAccessedBy($this->db, $params);

        $this->load->view('allotment/view_basic',$data);
    }

    function viewlmnote() {
        //$db=  $this->session->userdata('db');
        $case_no = $this->input->get('case_no');
        $q = "Select * from    allotment_lm_note where case_no='$case_no' order by date_entry desc";
        $data['aloteelm'] = $this->db->query($q)->row();
        //$this->load->view('../views/allotment/view_lmnote', $data);

        //$data['_view'] = 'allotment/view_lmnote';
        $this->load->view('allotment/view_lmnote',$data);
    }

    function viewcert() {
        //$db=  $this->session->userdata('db');
        $case_no = $this->input->get('case_no');
        $q = "Select * from    allotment_doc_details where case_no='$case_no'";
        $row = $this->db->query($q)->row();
        header("Content-type: application/pdf");
        echo $filedata1 = pg_unescape_bytea($row->file_name);
        //echo $row->file_name;
        //$this->load->view('../views/allotment/view_docfile', $data);

        $data['_view'] = 'allotment/view_docfile';
        $this->load->view('layouts/main',$data);
    }

    function viewsknote() {
        //$db=  $this->session->userdata('db');
        $case_no = $this->input->get('case_no');
        $q = "Select * from    allotment_lm_note where case_no='$case_no'";
        $data['aloteesk'] = $this->db->query($q)->row();
        //$this->load->view('../views/allotment/view_sknote', $data);

        //$data['_view'] = 'allotment/view_sknote';
        $this->load->view('allotment/view_sknote',$data);

    }

    function viewpro() {
        //$db=  $this->session->userdata('db');
        $case_no = $this->input->get('case_no');
        $q = "Select * from    allotment_cert_basic where case_no='$case_no'";
        $data['pb'] = $this->db->query($q)->row();
        $q = "Select * from    petition_proceeding_dc_adc where case_no='$case_no' order by proceeding_id ";
        $data['pd'] = $this->db->query($q)->result();
        //$this->load->view('../views/allotment/view_proceeding', $data);
        //$data['_view'] = 'allotment/view_proceeding';
        $this->load->view('allotment/view_proceeding',$data);
    }

    ///////////////
    function proceeding() {
          $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $data['cases'] = $this->db->query("Select * from    allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  status='F' ")->result();
        // $this->load->view('../views/header');
        // $this->load->view('../views/allotment/procaseslist', $data);
        // $this->load->view('../views/footer');
        //$data['_view'] = 'allotment/procaseslist';
        $this->load->view('allotment/procaseslist',$data);
    }

    function viewprceeding() {
          $db=  $this->session->userdata('db');
        $case_no = $this->input->get('case_no');
        $q = "Select * from    allotment_cert_basic where case_no='$case_no'";
        $data['pb'] = $this->db->query($q)->row();
        $q = "Select * from    petition_proceeding_dc_adc where case_no='$case_no' order by proceeding_id ";
        $data['pd'] = $this->db->query($q)->result();
        // $this->load->view('../views/header');
        // $this->load->view('../views/allotment/view_proceeding', $data);
        // $this->load->view('../views/footer');
        //$data['_view'] = 'allotment/view_proceeding';
        $this->load->view('allotment/view_proceeding',$data);
    }

    function cofinalpendingcase() {


        $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }


          $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $data['cases'] = $this->db->query("Select *,ba.basundhara from    allotment_cert_basic acb left join basundhar_application ba on acb.case_no=ba.dharitree where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  status='F' and dc_code is not null and chitha_correct_yn is null and lm_code is not null and sk_code is not null")->result();
        // $this->load->view('../views/header');
        // $this->load->view('../views/allotment/pendingcofinallist', $data);
        // $this->load->view('../views/footer');

        foreach($data['cases'] as $rows){
            if($rows->es_flag == '1' && ESCALATION_ENABLE ==1){
                $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
                log_message('error', '#55: Escalation ROW : '.json_encode($escRow));                         
                if(!empty($escRow)){                                                                
                    $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));                             
                    log_message('error', '#5531: Escalation details : '.json_encode($escData)); 
                    if(!empty($escData)){                                
                        $rows->escalation_date = $escData->escalation_date;
                        $rows->escalation_zone = $escData->escalation_zone;
                        $rows->assigned_date   = $escData->assigned_date;
                    }else{
                        $rows->escalation_date = 'NA';
                        $rows->escalation_zone = 'NA';
                        $rows->assigned_date   = 'NA';
                    }
                }else{
                    $rows->escalation_date = 'NA';
                    $rows->escalation_zone = 'NA';
                    $rows->assigned_date   = 'NA';
                }                            
            }
            else {
                $rows->escalation_date = 'NA';
                $rows->escalation_zone = 'NA';
            }
        }


        $data['_view'] = 'allotment/pendingcofinallist';
        $this->load->view('layouts/main',$data);
    }

    function Finalcoorder() {

        $_GET['case_no'] = dec_param($this->input->get('case_no'), 'case_no');
        if($_GET['case_no'] == null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
        return;
        }

        $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }


        $db=  $this->session->userdata('db');
        $case_no = $this->input->get('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $q = "Select * from allotment_lm_note where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and case_no='$case_no' order by order_slno desc ";// and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill'";
        $data['alm'] = $alm = $this->db->query($q)->row();
        $mouza=$alm->mouza_pargona_code;
        $lot_no=$alm->lot_no;//$this->input->get('lot_no');
        $vill=$alm->vill_townprt_code;//$this->input->get('vill_townprt_code');
        $patta_type = $alm->patta_type_code;
        $data['selectedPattaType']=$patta_type;
        $pattasql = "Select type_code from    patta_code where mutation='a' ";
        $pattasqll = "Select type_code,patta_type from    patta_code where mutation='a' ";
        $data['mutpatta'] = $this->db->query($pattasqll)->result();
        $data['newdag'] = $this->utilityclass->maxdag($dist_code, $subdiv_code, $cir_code, $mouza, $lot_no, $vill);
        $data['newpatta'] = $this->utilityclass->maxpatta($dist_code, $subdiv_code, $cir_code, $mouza, $lot_no, $vill, $patta_type);
        //var_dump($data);
        $q = "Select dag_no,patta_no,dag_no_int as new_dag from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill' order by dag_no_int";
        $data['dag_patta'] = $this->db->query($q)->result();
        $q = "Select * from  allotment_cert_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' ";
        // $q = "Select dc_note from    allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and case_no='$case_no'";
        $data['dcnote'] = $this->db->query($q)->row();


        $query = "Select dag_no from allotment_pet_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and case_no='$case_no'";
        $old_dag = $this->db->query($query)->row();
        $new_dag_no = $this->utilityclass->maxdag($dist_code, $subdiv_code, $cir_code, $mouza, $lot_no, $vill);
        //code for updating zonal informtion of dag------------17032023--
        $dag_no = $old_dag->dag_no;
        $data['old_dag'] = $dag_no;
    
        //code for generating village uuid------------
        $village_uuid = $this->utilityclass->getVillageUUID($dist_code, $subdiv_code, $cir_code, $mouza, $lot_no, $vill);
        ///////////old dag landclass
        $data['landclasscode']=$this->utilityclass->classCodeFromChitha($dist_code, $subdiv_code, $cir_code, $mouza, $lot_no, $vill, $dag_no);
        //code for generating zonal value--------------
        $data['zonalValueOfDag'] = $this->utilityclass->getZonalValue($dist_code, $village_uuid, $dag_no);
        
        $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
        if($basundhara){
            $rtps=$this->rtpsmodel->checkBasundharaService($case_no);
            if($rtps=='RTPS'){
                $data['basundharaAttachment']=$this->rtpsmodel->searchBasundharaLink($case_no);
            }else{
                $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
            }
        }

        $data['_view'] = 'allotment/coupdatedagpatta';
        $this->load->view('layouts/main',$data);
    }

    function updatechithaallotment() {

        $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }


        //xss & security validation starts
         $errorMessageStr = '';
         $resp = checkRequestSpecChar($_POST);
         if($resp['status'] == 'n'){
             $errorMessageStr .= $resp['messages'];
         }
         $resp = checkRequestValidQuery($_POST);
         if($resp['status'] == 'n'){
             $errorMessageStr .= $resp['messages'];
         }    
         if($errorMessageStr != ''){
            $this->session->set_flashdata('message', $errorMessageStr);
             return redirect($_SERVER['HTTP_REFERER']);
        }
        //xss & security validation ends  
        $this->db->trans_begin();
        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza=$this->input->post('mouza_pargona_code');
        $lot_no=$this->input->post('lot_no');
        $vill=$this->input->post('vill_townprt_code');
        $patta_type_code = $this->input->post('new_patta_type');
        $case_no = $this->input->post('case_no');
        //////////////////////////////////
        $getLoc = $this->db->query('select * from allotment_cert_basic where case_no = ? and status=? ', array($case_no,'F'));
        if($getLoc->num_rows()>=1){
            $this->session->set_flashdata('message', "Final Order might be completed.. Kindly Reload the page!!");
            redirect(base_url() . "index.php/home");
            return;
        }
        //////////////////////////////////
        $new_dag = $this->input->post('new_dag');
        $new_patta = $this->input->post('new_patta');
        $revenue = $this->input->post('revenue');
        $local_tax = $this->input->post('local_tax');
        $data = array(
            'new_dag' => $new_dag,
            'new_patta' => $new_patta,
            'l_rev' => $revenue,
            'l_tax' => $local_tax,
            'patta_type_code'=>$patta_type_code
        );
        $this->db->where('case_no', $case_no);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('circle_code', $cir_code);
        $this->db->update('allotment_lm_note', $data);
        $update = array(
            'chitha_correct_yn' => 'y',
            'chitha_correct_date' => date('Y-m-d')
        );

        $dag_details = $this->db->query("select * from allotment_pet_dag where case_no='$case_no' ")->row();

        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {

            $this->load->model('propChain/PropChainCommonModel');
            $block_status=$this->PropChainCommonModel->checkDagExistsInPropChain($dag_details->dist_code,$dag_details->subdiv_code,
            $dag_details->cir_code,$dag_details->mouza_pargona_code,$dag_details->lot_no,$dag_details->vill_townprt_code,$dag_details->dag_no);

            if($block_status==true){

                $this->session->set_flashdata('message', "Backlog Entry cannot be passed for the given Dag as it is in Property chain!!");
                redirect(base_url() . "index.php/home");
                return;
            }

        }
        $getLoc = $this->db->query('select * from allotment_cert_basic where case_no = ? and status!=? ', array($case_no,'F'));
        
        $test = $this->chithaupdate($dist_code, $subdiv_code, $cir_code, $case_no,$mouza,$lot_no,$vill);
        if ($test == true) {
        	
        	$getLoc = $this->db->query('select * from allotment_cert_basic where case_no = ?', array($case_no));
            if($getLoc->num_rows() <= 0){
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "ERR862: Something went wrong! Unable to process... $case_no");
                redirect(base_url() . 'index.php/home');
            }

            $locRow = $getLoc->row();
            
            $append = "dist_code='$locRow->dist_code' and subdiv_code='$locRow->subdiv_code' and circle_code='$locRow->circle_code' and mouza_pargona_code='$locRow->mouza_pargona_code' and lot_no='$locRow->lot_no' and ". "vill_townprt_code='$locRow->vill_townprt_code'";
            
            $pb = $this->db->query("select * from allotment_cert_basic where case_no='$case_no' and $append")->row();
            //ESCALATION CODE INTEGRATION================SANMRI
            // $executionDate = $this->input->post('executionDate');
            $executionDate = date('Y-m-d H:i:s');
            $user_code = $this->session->userdata('user_code');
            $es_flag = $pb->es_flag;

            if($es_flag == 1 && ESCALATION_ENABLE ==1 && $pb->out_of_esc == 0){
                $escalationUpdateStatus = $this->Escalationmodel->escalationFinalOrderCOChitha($executionDate,$locRow->dist_code,$locRow->subdiv_code,$locRow->circle_code,$case_no,$user_code);

                log_message("error", "#ESC5803, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

                if($escalationUpdateStatus['responseType'] == 0){
                    $this->db->trans_rollback();
                    log_message('error', '#ESC35803: Updation failed in escalation for case no :'. $case_no);
                    $json = [
                        'errorMessage'=>"#ESC35803: Updation failed on escalation for Case No ".$case_no
                    ];
                    echo json_encode($json);
                    return false;
                }
            }
            //autoupdate jamabandi starts here
            $this->load->model('jamabandi/jamabandiAutoUpdateModel');
            $jamaUpdate = $this->jamabandiAutoUpdateModel->updateJamabandi($new_patta, 
                $patta_type_code, $dist_code, $subdiv_code, $cir_code, $mouza, 
                $lot_no, $vill, $case_no);
            if($jamaUpdate != 1){
                $this->db->trans_rollback();
                log_message("error"," #ERRALT002: Issue occured in updating Jamabandi for case no: ". $case_no);            
                $this->session->set_flashdata('message',"#ERRALT002: Final Submission failed for case no : ".$case_no);
                redirect(base_url() . 'index.php/home');
                return false;    
            }
            //autoupdate jamabandi ends here

            $this->db->where('dist_code', $dist_code);
            $this->db->where('case_no', $case_no);
            $this->db->update('allotment_cert_basic', $update);
            if($this->db->affected_rows() != 1){
                $this->db->trans_rollback();
                log_message("error"," #ERRALT003: Updation failed in allotment_cert_basic 
                    for case no: ". $case_no);            
                $this->session->set_flashdata('message',"#ERRALT003: Final Submission failed 
                    for case no : ".$case_no);
                redirect(base_url() . 'index.php/home');
                return false;    
            }
            
            $this->DashboardDataFinal($case_no);
            $rmk=$rmrk;
            $status='F';
            $task='CO';
            $pen='NA';
            $case=$case_no;
            $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
            $this->db->trans_commit();


            $query = "Select dag_no from allotment_pet_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and case_no='$case_no'";
            $old_dag = $this->db->query($query)->row();
            $old_dag_no = $old_dag->dag_no;


            //code for generating village uuid------------
            $village_uuid = $this->utilityclass->getVillageUUID($dist_code, $subdiv_code, $cir_code,$mouza,$lot_no,$vill);

            //zonal row fetch row for insertion same row for new dag----------
            $ZonalStatus = $this->utilityclass->getZonalRowFetchAndInsert($dist_code, $village_uuid, $old_dag_no,$new_dag);

            if($ZonalStatus=='N'){
                log_message('error','#RES001 : Zonal value of new dag could not been updated. OLD Dag :'.$old_dag_no. " and New dag : ".$new_dag. " CASE NO : ".$case_no);
            }elseif($ZonalStatus == 'Y'){
                log_message('error','#RES002 : Zonal value of new dag updated successfully. OLD Dag :'.$old_dag_no. " and New dag : ".$new_dag. " CASE NO : ".$case_no);
            }
            //end-----------18032023


            $this->session->set_flashdata('message', "Case Successfully Passed with case number $case_no");
            redirect(base_url() . 'index.php/home');            
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "Error During Proceesing $case_no");
            redirect(base_url() . 'index.php/home');
        }
    }
    function Dashboard($case_no){
        $this->dbb = $this->load->database('dash', TRUE);
        $sql="Select pb.*,pd.patta_no,pd.patta_type_code,
        pd.dag_no from allotment_cert_basic pb 
        join allotment_pet_dag pd on pb.case_no=pd.case_no  where pb.settlement_typ is null and  pb.case_no='$case_no' ";
        $data=$this->db->query($sql)->row_array();
        $type='AC';
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
              'date_of_insert'=>date("Y-m-d h:i:s")
            );
            $this->dbb->insert('dashboard_data',$base);
            unset($base['dag_no']);
            unset($base['patta_type_code']);
            unset($base['patta_no']);
            $this->db->insert('dashboard_data',$base);
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
                    'pending_with_user' => $penUser,
                    'date_of_update'=>date("Y-m-d h:i:s")
                );
                $this->dbb->where('case_no',$case_no);
                $this->dbb->update('dashboard_data',$base);

                $this->db->where('case_no',$case_no);
                $this->db->update('dashboard_data',$base);


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
                        'remark'=>'Final Order Passed',
                        'date_of_update'=>date("Y-m-d h:i:s")
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

                    $this->db->where('case_no',$case_no);
                    $this->db->update('dashboard_data',$base);
            /////////////////////////////////////
    }
    ////////////22-02-22//////////////////
    function coBulkFDAPTOPP() {

        $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $data['cases'] = $this->db->query("Select *,ba.basundhara from  allotment_cert_basic acb left join basundhar_application ba on acb.case_no=ba.dharitree where acb.dist_code='$dist_code' and acb.subdiv_code='$subdiv_code' and acb.circle_code='$cir_code' and  acb.not_fresh is null and acb.status is null and acb.settlement_typ is null")->result();
        foreach ($data['cases'] as $key=>$case)
        {
            $basuCase=null;
            $basundharaExist=$this->basundharamodel->checkExistBasundhar($case->case_no);
            if($basundharaExist){
                $data['cases'][$key]->basundharaExist = 'true';
            }else{
                $data['cases'][$key]->basundharaExist = 'false';
            }
        }
        $data['_view'] = 'allotment/co_bulk_fd_lm_ac_pp';
        $this->load->view('layouts/main',$data);
    }
    ///////////////////////////checkNumberofCases/////////////////////////////
    function checkNumberofCases()
    {
        if(count($this->input->post('case_ac_pp')) > CO_BULK_SELECT_LIMIT)
        {
            $this->form_validation->set_message('checkNumberofCases', 'Allowed only '.CO_BULK_SELECT_LIMIT.' cases at a time.');
            return false;
        }
        else
        {
            return true;
        }
    }
    ////////////////////////
    public function coBulkFDACtoPP()
    {

        $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        $case_validate = array(
            array(
                'field' => 'case_ac_pp[]',
                'label' => 'Case No.',
                'rules' => 'trim|required|xss_clean|callback_checkNumberofCases'
            ),
            array(
                'field' => 'next_date',
                'label' => 'Next Date',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'order_pass',
                'label' => 'প্রক্রিয়া জাৰি ৰাখক',
                'rules' => 'trim|required|xss_clean'
            ),

        );

        $db=  $this->session->userdata('db');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->form_validation->set_rules($case_validate);
        $validation = null;
        if ($this->form_validation->run() == false)
        {
            $this->form_validation->set_error_delimiters('', '');
            foreach($case_validate as $rule){
                if (form_error($rule['field'])) {
                    $validation['error'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
                }
            }
            echo json_encode($validation);
            return;
        }
        $case_list = implode(", ",$this->input->post('case_ac_pp'));

        if ($_POST['order_pass'] == 'P')
        {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $next_date = $this->input->post('next_date');
            $cases = $this->input->post('case_ac_pp');
            $user_code = $this->session->userdata('user_code');
            $status = $this->input->post('order_pass');
            $name = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $user_code);
            $co_name = $name->username;
            $proceeding1 = "আবেদনকাৰীয়ে আবন্টন পোৱা মাটিৰ পট্টন বিচাৰি কৰা  আৱেদন চোৱা হ'ল । ভূমিলেখ্য সহায়ক  আৰু ভূমিলেখ্য পৰ্যবেক্ষক ই চৰজমিন জোখ মাখ কৰি  বিতং প্রতিবেদন দাখিল কৰিব  | প্রতিবেদন দাখিলৰ পৰবৰ্তী তাৰিখ ";
            $proceeding2 = " ধাৰ্য্য কৰা হল | ";
            $proceeding3 = "চক্র বিষয়া -----" . $co_name;
            $merge = $proceeding1 . $next_date . $proceeding2 . $proceeding3;
            $this->db->trans_begin();

            foreach ($cases as $key=>$case)
            {
                $case_no = trim($case);

                $q = "Select max(proceeding_id)+1 as p from petition_proceeding_dc_adc where dist_code='$dist_code' and case_no='$case_no' ";
                $count = $this->db->query($q)->row()->p;
                if ($count == 0) {
                    $count = $count + 1;
                }

                $update = array(
                    'next_date_hearing' => date('Y-m-d', strtotime($this->input->post('next_date'))),
                    'not_fresh' => 'Y',
                    'status' => $status,
                    'proceeding_yn' => 1,
                    'co_code' => $user_code,
                    'co_entry_date' => date('Y-m-d'),
                    'co_note' => 'Y'
                );

                $penUser='LM';
                $rmrk='Case have been forwarded by CO';
               // $this->DashboardData($case_no,$penUser,$rmrk);

                //////////////Update Dashboard Database///////////////////////
                $this->dbb = $this->load->database('dash', TRUE);
                $base=array(
                    'pending_with_user' => $penUser,
                    'remark' => $rmrk,
                    'date_of_update'=>date("Y-m-d h:i:s")
                );

                ///////////Update Dashboard DBB//////////
                $dashboard_dbb_data = $this->dbb->query("select * from dashboard_data where case_no=?",array($case_no))->num_rows();

                if($dashboard_dbb_data > 0)
                {
                    $this->dbb->where('case_no',$case_no);
                    $dashboard_dbb_update = $this->dbb->update('dashboard_data',$base);

                    if(($this->dbb->affected_rows() != $dashboard_dbb_data) || $dashboard_dbb_update == false)
                    {
                        $this->db->trans_rollback();
                        $validation['db_error'] = true;
                        $validation['msg'] = 'Error: AC to PP Proceeding Order for Case no '. $case_no .' Not Successful. Contact Helpdesk with case no (code:##001)';
                        echo json_encode($validation);
                        return;
                    }
                }

                ///////////Update Dashboard DB//////////

                $dashboard_db_data = $this->db->query("select * from dashboard_data where case_no=?",array($case_no))->num_rows();

                if($dashboard_db_data > 0)
                {
                    $this->db->where('case_no',$case_no);
                    $dashboard_db_update = $this->db->update('dashboard_data',$base);
                    if(($this->db->affected_rows() != $dashboard_db_data)  || $dashboard_db_update == false)
                    {
                        $this->db->trans_rollback();
                        $validation['db_error'] = true;
                        $validation['msg'] = 'Error: AC to PP Proceeding Order for Case no '. $case_no .' Not Successful. Contact Helpdesk with case no (code:##002)';
                        echo json_encode($validation);
                        return;
                    }
                }


                $action= array(
                    'case_no' => $case_no,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_of_action_taken' => date('Y-m-d'),
                    'ip_address ' => $this->input->ip_address(),
                    'user_designation' => $this->session->userdata('user_desig_code'),
                    'remark' => $rmrk,
                );
                $this->dbb->insert('dashboard_action',$action);
                $this->db->insert('dashboard_action',$action);
                ///////////////////////////////////


                $rmk=$rmrk;
                $status2='M';
                $task='CO';
                $pen='LM';
                $this->basundharamodel->postApiBasundharaSec($case_no,$rmk,$status2,$task,$pen);
                //$sql="Select basundhara from  basundhar_application where dharitree=?";
                //$linkAvail=$this->db->query($sql,array($case_no));
                //if($linkAvail->num_rows() > 0)
                //{
                //    $bs_case_no = $linkAvail->row()->basundhara;
                //    $this->basundharamodel->postApiBasundhara($bs_case_no,$case,$rmk,$status2,$task,$pen);
                //}

                $status1 = 'Pending';
                $insert = array(
                    'case_no' => $case_no,
                    'proceeding_id' => $count,
                    'date_of_hearing' => date('Y-m-d'),
                    'co_order' => addslashes($merge),
                    'next_date_of_hearing' => date('Y-m-d', strtotime($this->input->post('next_date'))),
                    'status' => $status1,
                    'user_code' => $user_code,
                    'date_entry' => date('Y-m-d'),
                    'operation' => 'E',
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code
                );
                $petition_proceeding_dc_adc_insert = $this->db->insert('petition_proceeding_dc_adc', $insert);
                if($petition_proceeding_dc_adc_insert == false)
                {
                    $this->db->trans_rollback();
                    $validation['db_error'] = true;
                    $validation['msg'] = 'Error: AC to PP Proceeding Order for Case no '. $case_no .' Not Successful. Contact Helpdesk with case no (code:##003)';
                    echo json_encode($validation);
                    return;
                }
                $this->db->where('dist_code', $dist_code);
                $this->db->where('subdiv_code', $subdiv_code);
                $this->db->where('circle_code', $cir_code);
                $this->db->where('case_no', $case_no);
                $allotment_cert_basic_update = $this->db->update('allotment_cert_basic', $update);
                if($this->db->affected_rows() != 1 || $allotment_cert_basic_update == false)
                {
                    $this->db->trans_rollback();
                    $validation['db_error'] = true;
                    $validation['msg'] = 'Error: AC to PP Proceeding Order for Case no '. $case_no .' Not Successful. Contact Helpdesk with case no (code:##004)';
                    echo json_encode($validation);
                    return;
                }
            }
            if ($this->db->trans_status() == FALSE)
            {
                $this->db->trans_rollback();
                $validation['db_error'] = true;
                $validation['msg'] = 'Error: AC to PP Proceeding Order for Case no '. $case_list .' Not Successful. Contact Helpdesk with case no (code:##005)';
                echo json_encode($validation);
                return;
            }
            else
            {
                $this->db->trans_commit();
                $validation['db_error'] = false;
                $validation['msg'] = 'Cases Successfully Passed with '. $case_list .' .';
                echo json_encode($validation);
                return;
            }
        }
        else
        {
            $this->db->trans_rollback();
            $validation['db_error'] = true;
            $validation['msg'] = 'Error: Conversion Proceeding Order for Case no '. $case_list .' Not Successful. Contact Helpdesk with case no (code:##006)';
            echo json_encode($validation);
            return;
        }
    }
    ////////////////16-03-22////////////////
    public function addNewAllotmentApplicant()
{
    //xss & security validation starts
    $errorMessageArr = [];
    $resp = checkRequestSpecChar($_POST);
    if($resp['status'] == 'n'){
    $errorMessageArr=$resp['field_wise_message'];
    }
    if(count($errorMessageArr)){
        $validation = [];
        foreach($errorMessageArr as $field => $errorMessageSing){
            $validation['error'][] = array('field' => $field, 'message' => $errorMessageSing);
        }
        echo json_encode($validation);
        return false;;
    }
    $resp = checkRequestValidQuery($_POST);
    if($resp['status'] == 'n'){
        $errorMessageArr=$resp['field_wise_message'];
    }        
    if(count($errorMessageArr)){
        $validation = [];
        foreach($errorMessageArr as $field => $errorMessageSing){
            $validation['error'][] = array('field' => $field, 'message' => $errorMessageSing);
        }
        echo json_encode($validation);
        return false;;
    }
    //xss & security validation ends
    $addNewAllotmentPartyValidation = [
        [
            'field' => 'appl_name',
            'label' => 'Applicant',
            'rules' => 'trim|required|xss_clean',
        ],
        [
            'field' => 'guardian_name',
            'label' => 'Guardian Name',
            'rules' => 'trim|required|xss_clean',
        ],
        [
            'field' => 'relation',
            'label' => 'Relation',
            'rules' => 'trim|required|xss_clean',
        ],
        [
            'field' => 'relation',
            'label' => 'Relation',
            'rules' => 'trim|required|xss_clean',
        ],
        [
            'field' => 'gender',
            'label' => 'Gender',
            'rules' => 'trim|required|integer|xss_clean',
        ],
    ];
    $json= null;
    $this->form_validation->set_rules($addNewAllotmentPartyValidation);
    $this->form_validation->set_message('integer', 'This %s is not valid');
    if ($this->form_validation->run('addNewAllotmentPartyValidation') == FALSE)
    {
        $this->form_validation->set_error_delimiters('', '');
        foreach($addNewAllotmentPartyValidation as $rule){
        if (form_error($rule['field'])) {
            $json['error'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
            }
        }             
    } 
    else 
    {
        $val = $this->input->post();
        $case_no = $val['case_no'];
        $this->db->trans_begin();

        //get detail from allotment_petitioner
        $id = $this->db->query("SELECT max(alotee_id)+1 as alotee_id 
        FROM allotment_petitioner WHERE case_no=?", array($case_no))->row();

        $exiting_petitioner = $this->db->query("SELECT * FROM allotment_petitioner WHERE case_no=?", array($case_no));

        if($exiting_petitioner->num_rows() <= 0){
            $this->db->trans_rollback();
            log_message('error', '#ERRALOT001: No Petitioner Available in allotment_petitioner for case no '.$case_no);
            return false;
        }

        $data = clone $exiting_petitioner->row();
        $data->alotee_name = $val['appl_name'];
        $data->alotee_id = $id->alotee_id;
        $data->alotee_gurdian = $val['guardian_name'];
        $data->alotee_reln = $val['relation'];
        $data->alotee_gender = $val['gender'];
        //$data->pdar_guardian = $val['address'];
        $data->date_entry = date('Y-m-d h:i:s');
        unset($data->alotee_mobile);
        $ins = $this->db->insert('allotment_petitioner', $data);            
        //echo $this->db->last_query();
        if($ins != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRALOT002: Insertion failed in allotment_petitioner for case no '.$case_no);
            return false;
        }                

        $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
        $basuData=array(
            'ip'=>$this->utilityclass->get_client_ip(),
            'case_no' => $case_no,
            'basundhara' => $basundharaExist,
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d H:i:s'),
            'changes_data' => json_encode($data),
        );   
        $basuIns=$this->db->insert('basundhara_data_updation', $basuData);
        if($basuIns != 1){
            $this->db->trans_rollback();
            log_message('error', '#ERRALOT003: Insertion failed in basundhara_data_updation for case no '.$case_no);
            return false;
        }

        $this->db->trans_commit();
        $json['success'] = 'true';
        $json['case'] = $case_no;
    }
    echo json_encode($json);
    return;
}

public function getEditAllomentApplicantDetail()
    {
        //xss & security validation starts
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }
        $resp = checkRequestValidQuery($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }    
        if($errorMessageStr != ''){
            $data=array(
                'error' => $errorMessageStr
            );
            echo json_encode($data);
            return false;
            exit;
        }
       //xss & security validation ends 
        $id = $this->input->post('alotee_id');
        $case_no = $this->input->post('case_no');
        $location = $this->utilityclass->getLocationfromSession();
        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];

        $details['alloted_applicant'] = $this->db->query("SELECT alotee_name, alotee_gender,
        alotee_gurdian, alotee_reln, alotee_id, case_no FROM allotment_petitioner WHERE 
        case_no=? AND dist_code=? AND subdiv_code=? AND circle_code=? AND alotee_id=?", 
        array(trim($case_no), $dist_code, $subdiv_code, $cir_code, $id))->row();
        //echo $this->db->last_query();

        $details['relation'] = $this->db->query("SELECT * FROM master_guard_rel")->result();
        $details['gender'] = $this->db->query("SELECT * FROM master_gender")->result();
        echo json_encode($details);
    }

    public function updateAllotedApplicant()
    {
        //xss & security validation starts
        $errorMessageArr = [];
        $resp = checkRequestSpecChar($_POST);
        if($resp['status'] == 'n'){
        $errorMessageArr=$resp['field_wise_message'];
        }
        if(count($errorMessageArr)){
            $validation = [];
            foreach($errorMessageArr as $field => $errorMessageSing){
                $validation['error'][] = array('field' => $field, 'message' => $errorMessageSing);
            }
            echo json_encode($validation);
            return false;;
        }
        $resp = checkRequestValidQuery($_POST);
        if($resp['status'] == 'n'){
            $errorMessageArr=$resp['field_wise_message'];
        }        
        if(count($errorMessageArr)){
            $validation = [];
            foreach($errorMessageArr as $field => $errorMessageSing){
                $validation['error'][] = array('field' => $field, 'message' => $errorMessageSing);
            }
            echo json_encode($validation);
            return false;;
        }
        //xss & security validation ends
        $editAllotmentPartyValidation = [
            [
                'field' => 'appl',
                'label' => 'Applicant',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'guard_name',
                'label' => 'Guardian Name',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'rel',
                'label' => 'Relation',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'gen',
                'label' => 'Gender',
                'rules' => 'trim|required|integer|xss_clean',
            ],
        ];
        $json= null;
        $this->form_validation->set_rules($editAllotmentPartyValidation);
        $this->form_validation->set_message('integer', 'This %s is not valid');
        if ($this->form_validation->run('editAllotmentPartyValidation') == FALSE)
        {
            $this->form_validation->set_error_delimiters('', '');
            foreach($editAllotmentPartyValidation as $rule){
            if (form_error($rule['field'])) {
                $json['error'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
                }
            }             
        } 
        else
        {
            $this->db->trans_begin();

            $val = $this->input->post();
            $case_no = $val['case_no'];
            $id = $val['alotee_id'];

            $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
            $oldData = $this->db->query("SELECT * FROM allotment_petitioner WHERE case_no=? 
            AND alotee_id=?", array($case_no, $id))->row();
            $data = [
                'ip'=>$this->utilityclass->get_client_ip(),
                'case_no' => $case_no,
                'basundhara' => $basundharaExist,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d H:i:s'),
                'changes_data' => json_encode($oldData),
            ];
            $basuInsert = $this->db->insert('basundhara_data_updation', $data);
            if($basuInsert != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRALOT004: Insertion failed in basundhara_data_updation for case no '.$case_no);
                return false;
            }

            $update = [
                'alotee_name' => $val['appl'],
                'alotee_gurdian' => $val['guard_name'],
                'alotee_reln' => $val['rel'],
                'alotee_gender' => $val['gen']
            ];
            $this->db->where(['case_no' => $case_no, 'alotee_id' => $id]);
            $this->db->update('allotment_petitioner', $update);
            if($this->db->affected_rows() <= 0){
                $this->db->trans_rollback();
                log_message('error', '#ERRALOT005: Updation failed in allotment_petitioner for case no '.$case_no);
                return false;   
            }
            
            $details = $this->db->query("SELECT * FROM allotment_petitioner 
            WHERE case_no=? ORDER BY alotee_id", array($case_no))->result();
            
            $variable = array();
            foreach($details as $appl){
                $variable[] = '<tr>
                    <td>'.$appl->alotee_id.'</td>
                    <td>'.$appl->alotee_name.'</td>
                    <td>'.$appl->alotee_gurdian.'</td>
                    <td>'.$this->utilityclass->get_relation($appl->alotee_reln).'</td>
                    <td>'.$this->utilityclass->gender($appl->alotee_gender).'</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-info btnApplicantEditCO" id="'.$appl->alotee_id.', '.$appl->case_no.'" title="Edit Applicant"><i class="fa fa-edit"></i></button>
                    </td>
                </tr>';
            }
            
            $json['details'] = $variable;
            $this->db->trans_commit();
        }
        echo json_encode($json);
        return;
    }
    //////////////////////////////////
    public function dagSelectOnPattachange(){
        //xss & security validation starts
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }
        $resp = checkRequestValidQuery($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }    
        if($errorMessageStr != ''){
            $data=array(
                'error' => strip_tags($errorMessageStr)
            );
            echo json_encode($data);
            return false;
            exit;
        }
        //xss & security validation ends 
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        //$mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        //$lot_no = $this->session->userdata('lot_no');
        $case_no = $this->input->post('case_no');
        $pattacode = $this->input->post('pattacode');


        $cb = $this->db->query("Select vill_townprt_code,mouza_pargona_code,lot_no from    allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no'")->row();

        $sql = "Select distinct cast(patta_no as varchar) as patta_no from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$cb->mouza_pargona_code'"
                . "and vill_townprt_code='$cb->vill_townprt_code' and patta_type_code='$pattacode' and lot_no='$cb->lot_no' and   patta_no!='' and patta_no!='.' order by patta_no desc  ";
        $patta_no = $data['oldPatta'] = $this->db->query($sql)->result();
        $newpatta = 0;
        foreach ($patta_no as $p) {
            $p = $p->patta_no;
            $p = (int) ($p);
            if ($newpatta < $p) {
                $newpatta = $p;
            }
        }
        $data['new_patta'] = $newpatta + 1;
        $data['success'] = true;
        echo json_encode($data);
    }

    //////////04-04-22/////////////
    //get govt dag list based on locations selected
    public function getDagList()
    { 
        //xss & security validation starts
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }
        $resp = checkRequestValidQuery($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }    
        if($errorMessageStr != ''){
            $data=array(
                'error' => $errorMessageStr
            );
            echo json_encode($data);
            return false;
            exit;
        }
       //xss & security validation ends        
        $case_no = $this->input->post('id');
        
        $loc = $this->db->query("SELECT dist_code, subdiv_code, circle_code, 
        mouza_pargona_code, lot_no, vill_townprt_code FROM allotment_cert_basic 
        WHERE case_no=?", array($case_no))->row();

        $dist = $loc->dist_code;
        $subdiv = $loc->subdiv_code;
        $circle = $loc->circle_code;
        $mouza = $loc->mouza_pargona_code;
        $lot = $loc->lot_no;
        $vill = $loc->vill_townprt_code;

        $govtPatta = $this->db->query("SELECT type_code FROM patta_code 
        WHERE jamabandi=?", array('n'))->result();

        $type_code = array();

        foreach($govtPatta as $row){
            array_push($type_code, "'".$row->type_code."'");
        }

        $str = implode(',', $type_code);
        $str = "(".$str.")";
        $dagNo = $this->db->query("SELECT dag_no FROM chitha_basic WHERE 
        dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=?
        AND lot_no=? AND vill_townprt_code=? AND patta_type_code IN $str ORDER BY dag_no ASC", 
        array($dist, $subdiv, $circle, $mouza, $lot, $vill))->result();

        $json['dag_details'] = $dagNo;
        $json['location'] = $loc;
        $json['type_code'] = $str;

        echo json_encode($json);
        return;
    }

    //change area against a dag no described in chitha
    public function changeAllotmentDag(){
        //xss & security validation starts
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }
        $resp = checkRequestValidQuery($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }    
        if($errorMessageStr != ''){
            $data=array(
                'error' => $errorMessageStr
            );
            echo json_encode($data);
            return false;
            exit;
        }
        //xss & security validation ends 
        $val = $this->input->post();

        $dag = $val['dag'];
        $dist = $val['dist'];
        $subdiv = $val['subdiv'];
        $cir = $val['cir'];
        $mouza = $val['mouza'];
        $vill = $val['vill'];
        $lot = $val['lot'];

        $json = null;

        $land = $this->db->query("SELECT dag_area_b, dag_area_k, dag_area_lc, 
        dag_area_g, dag_area_kr FROM chitha_basic WHERE dag_no=? AND
        dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=?
        AND lot_no=? AND vill_townprt_code=?", 
        array($dag, $dist, $subdiv, $cir, $mouza, $lot, $vill))->row();

        $json['area'] = $land;

        echo json_encode($json);
        return;
    }  

    public function dagNoValidationCheck()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $val = $this->input->post();

            if($this->input->post('change_dag') == 1){
                $dist = $val['dist_code'];
                $subdiv = $val['subdiv_code'];
                $cir = $val['cir_code'];
                $mouza = $val['mouza_pargona_code'];
                $vill = $val['vill_townprt_code'];
                $lot = $val['lot_no'];
                $ptypecode = $val['type_code'];

                $dag_nos = $this->db->query("SELECT dag_no FROM chitha_basic WHERE  
                dist_code=? AND subdiv_code=? AND cir_code=? AND lot_no=? AND 
                vill_townprt_code=? AND mouza_pargona_code=? AND patta_type_code IN $ptypecode", 
                array($dist, $subdiv, $cir, $lot, $vill, $mouza))->result_array(); 

                $dag = array_column($dag_nos, 'dag_no');

                if ((in_array($val['dag_list'], $dag)))
                { return TRUE; }

                else{
                    $this->form_validation->set_message('dagNoValidationCheck', 'The %s is not valid');
                    return FALSE;
                }
            }
        }
    }
    // function lm_submit() 
    // {
    //     $json =array();
    //     //$json['error_a'] =array();
    //     $case_no = $this->input->post('case');
    //     $no = explode('/', $case_no);
        
    //     $count = $this->db->query("SELECT count(case_no) AS count FROM supportive_document 
    //     WHERE case_no=?", array($case_no))->row()->count;
    //     $sl = $count+1;

    //    // $json = '';
    //     $updateFlag = $this->input->post('change_dag'); //used for if dag has changed

    //     if($updateFlag == 1) //if dag has changed
    //     {
    //         $dagDetailValidation = [
    //             [
    //                 'field' => 'dag_list',
    //                 'label' => 'Dag No',
    //                 'rules' => 'trim|required|xss_clean|callback_dagNoValidationCheck',
    //             ],
    //             [
    //                 'field' => 'new_alot_b',
    //                 'label' => 'Alloted Bigha',
    //                 'rules' => 'trim|required|xss_clean|integer',
    //             ],
    //             [
    //                 'field' => 'new_alot_k',
    //                 'label' => 'Alloted Katha',
    //                 'rules' => 'trim|required|xss_clean|integer',
    //             ],
    //             [
    //                 'field' => 'new_alot_lc',
    //                 'label' => 'Alloted Lessa',
    //                 'rules' => 'trim|numeric|required|xss_clean',
    //             ],
    //         ];
    //         $this->form_validation->set_rules($dagDetailValidation);
    //         $this->form_validation->set_message('integer', 'This %s is not valid');
    //         if ($this->form_validation->run('dagDetailValidation') == FALSE)
    //         {
    //             $this->form_validation->set_error_delimiters('', '');
    //             foreach($dagDetailValidation as $rule){
    //             if (form_error($rule['field'])) {
    //                 $json['error'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
    //                 }
    //             }             
    //         }
    //         //NOC upload validation starts here
    //         $_FILES['file']['type'] = $_FILES['up_noc']['type'];
    //         $_FILES['file']['tmp_name'] = $_FILES['up_noc']['tmp_name'];
    //         $_FILES['file']['error'] = $_FILES['up_noc']['error'];
    //         $_FILES['file']['size'] = $_FILES['up_noc']['size'];

    //         $ext = pathinfo($_FILES['up_noc']['name'], PATHINFO_EXTENSION);

    //         $check_file_type = explode('|', FILE_TYPE);
    //         $checkFileExt = false;
    //         foreach ($check_file_type as $file_type) {
    //             if($ext == $file_type) {
    //                 $checkFileExt = true;
    //                 break;
    //             }
    //         }
    //         //$json['error_a']=null;
    //         if(empty($_FILES['up_noc']['name']))
    //         {
    //             $json['error_a'][] = array('err_msg' => ' NOC upload is mandatory in case of changing Dag.');
    //         }
    //         else if(!$checkFileExt){
    //             $json['error_a'][] = array('err_msg' => ' File type should be in ' . FILE_TYPE . '. format only');
    //         }
    //         else if($_FILES['up_noc']['size'] > (MAX_SIZE * 1024) )
    //         {
    //             $json['error_a'][] = array('err_msg' => ' Larger file size selected.');
    //         }
    //         //var_dump($json);
    //         //NOC upload validation ends here
    //         if($json != null )
    //         {
    //             echo json_encode($json);
    //             return true;    
    //         }
    //     }
    //     $lmReportValidation = [
    //         [
    //             'field' => 'p_bigha',
    //             'label' => 'Possesion Bigha',
    //             'rules' => 'trim|required|xss_clean|integer',
    //         ],
    //         [
    //             'field' => 'p_katha',
    //             'label' => 'Possesion Katha',
    //             'rules' => 'trim|required|xss_clean|integer',
    //         ],
    //         [
    //             'field' => 'p_lessa',
    //             'label' => 'Possesion Lessa',
    //             'rules' => 'trim|numeric|required|xss_clean|numeric',
    //         ],
    //         [
    //             'field' => 'exist_revenue',
    //             'label' => 'Existing TB Revenue',
    //             'rules' => 'trim|required|xss_clean|numeric',
    //         ],
    //         [
    //             'field' => 'exist_local_tax',
    //             'label' => 'Existing Local Tax',
    //             'rules' => 'trim|required|xss_clean|numeric',
    //         ],
    //         [
    //             'field' => 'revenue',
    //             'label' => 'Proposed Land Revenue',
    //             'rules' => 'trim|required|xss_clean|numeric',
    //         ],
    //         [
    //             'field' => 'local_tax',
    //             'label' => 'Proposed Local Tax',
    //             'rules' => 'trim|required|xss_clean|numeric',
    //         ],
    //         [
    //             'field' => 'lm_comment',
    //             'label' => 'LM Comment',
    //             'rules' => 'trim|required|xss_clean',
    //         ],
    //     ];
    //     $this->form_validation->set_rules($lmReportValidation);
    //     $this->form_validation->set_message('integer', 'This %s is not valid');
    //     if ($this->form_validation->run('lmReportValidation') == FALSE)
    //     {
    //         $this->form_validation->set_error_delimiters('', '');
    //         foreach($lmReportValidation as $rule){
    //         if (form_error($rule['field'])) {
    //             $json['error1'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
    //             }
    //         }             
    //     }
    //     else
    //     {
    //         $user_code = $this->session->userdata('user_code');
    //         $dist_code = $this->input->post('dist_code');
    //         $subdiv_code = $this->input->post('subdiv_code');
    //         $cir_code = $this->input->post('cir_code');
    //         $mouza_pargona_code = $this->input->post('mouza_pargona_code');
    //         $vill_townprt_code = $this->input->post('vill_townprt_code');
    //         $lot_no = $this->input->post('lot_no');
    //         $old_dag = $this->input->post('old_dag');
    //         $new_dag_no = $this->input->post('dag_list');

    //         $new_allot_bigha = $this->input->post('new_alot_b');
    //         $new_allot_katha = $this->input->post('new_alot_k');
    //         $new_allot_lessa = $this->input->post('new_alot_lc');

    //         $tot_bigha = $this->input->post('tot_bigha');
    //         $tot_katha = $this->input->post('tot_katha');
    //         $tot_lessa = $this->input->post('tot_lessa');
    //         $p_bigha = $this->input->post('p_bigha');
    //         $p_katha = $this->input->post('p_katha');
    //         $p_lessa = $this->input->post('p_lessa');
    //         $new_dag = $this->input->post('new_dag');
    //         $new_patta = $this->input->post('new_patta');
    //         $revenue = $this->input->post('revenue');
    //         $local_tax = $this->input->post('local_tax');

    //         $redirectURL = base_url()."index.php/Allotment/lmstep_one?case_no=".$case_no;
            
    //         //check if location selected are same as post
    //         $q = $this->db->query("SELECT dist_code, subdiv_code, circle_code,
    //         mouza_pargona_code, lot_no, vill_townprt_code FROM allotment_cert_basic 
    //         WHERE case_no=?", $case_no)->row();
    //         if($q->dist_code!=$dist_code && $q->subdiv_code!=$subdiv_code && 
    //         $q->circle_code!=$cir_code && $q->mouza_pargona_code!=$mouza_pargona_code &&
    //         $q->vill_townprt_code!=$vill_townprt_code && $q->lot_no!=$lot_no){            
    //             $this->session->set_flashdata('message', '#ERRORLOC: Something went wrong for Case No ' . $case_no);
    //             $json['location'] = 'true';
    //             $json['redirect'] = $redirectURL;
    //             echo json_encode($json);
    //             return false;
    //         }
            
    //         // if dag changed, then add changes dag in lm comment
    //         if($updateFlag == 1){ 
    //             $lm_msg = 'Dag has changed from OLD DAG NO: '. $this->input->post('oDNo') .' to NEW DAG NO: '. $this->input->post('dag_list').'. ';
    //             $lm_comment = $lm_msg.$this->input->post('lm_comment');
    //         }
    //         else{
    //             $lm_comment = $this->input->post('lm_comment');    
    //         }

    //         $allotte_k = $this->input->post('allotte_k');
    //         $original_alotee = $this->input->post('original_alotee');
    //         $posession_y = $this->input->post('posession_y');
    //         $p_year = $this->input->post('p_year');
    //         $land_use = $this->input->post('land_use');
    //         $three_km = $this->input->post('three_km');
    //         $ten_km = $this->input->post('ten_km');
    //         $recorded_tenant = $this->input->post('allotte_rec');
    //         $old_rev = $this->input->post('exist_revenue');
    //         $old_lc = $this->input->post('exist_local_tax');
    //         $new_patta_type = $this->input->post('new_patta_type');
    //         $new_landcode = $this->input->post('new_landcode');
    //         $username = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code);
    //         $username = " লাট মন্ডল ------ " . $username->lm_name;
    //         $comment = $lm_comment . $username;
    //         $comment = addslashes($comment);

    //         $this->db->trans_begin();

    //         //if dag changed
    //         if($updateFlag == 1){

    //             //insert into petition_proceeding

    //             $pid = $this->db->query("SELECT count(proceeding_id) as pro_id FROM
    //             petition_proceeding WHERE case_no=?",array($case_no))->row()->pro_id;
    //             if($pid == 0) { $pid = 1; }
    //             else {$pid = $pid+1;}

    //             $insPetProceed = [
    //                 'case_no' => $case_no,
    //                 'proceeding_id' => $pid,
    //                 'date_of_hearing' => date('Y-m-d h:i:s'),
    //                 'next_date_of_hearing' => date('Y-m-d h:i:s'),
    //                 'note_on_order' => $comment,
    //                 'status' => 'Pending',
    //                 'user_code' => $user_code,
    //                 'date_entry' => date('Y-m-d h:i:s'),
    //                 'operation' => 'E',
    //                 'dist_code' => $dist_code,
    //                 'subdiv_code' => $subdiv_code,
    //                 'cir_code' => $cir_code
    //             ];
    //             $insertProceeding = $this->db->insert('petition_proceeding', $insPetProceed);
    //             if($insertProceeding != 1){
    //                 $this->db->trans_rollback();
    //                 log_message('error', '#ERRORPP: Insertion failed in petition_proceeding for case no :'. $case_no);
    //                 $json = [
    //                     'errorMessage'=>"#ERRORPP: Failed to forward the case for Case No : ".$case_no
    //                 ];
    //                 echo json_encode($json);
    //                 return false;
    //             }



    //             // for upload NOC starts here
    //             if($no[4]=='ACPP'){
    //                 $folder = 'allotment/'.$dist_code.'/';
    //                 $petition_no = $this->db->query("SELECT petition_no FROM allotment_cert_basic
    //                 WHERE case_no=? ", array($case_no))->row()->petition_no;
    //             }
    //             $file = $petition_no.date('Y').'_'.$sl;
                
    //             $_FILES['file']['type'] = $_FILES['up_noc']['type'];
    //             $_FILES['file']['tmp_name'] = $_FILES['up_noc']['tmp_name'];
    //             $_FILES['file']['error'] = $_FILES['up_noc']['error'];
    //             $_FILES['file']['size'] = $_FILES['up_noc']['size'];

    //             $ext = pathinfo($_FILES['up_noc']['name'], PATHINFO_EXTENSION);
    //             $_FILES['file']['name'] = $file.'.'.$ext;

    //             if(!file_exists('./uploads/'.$folder)){
    //                 mkdir('./uploads/'.$folder, 0777, true);
    //                 $path = './uploads/'.$folder;
    //             }
    //             else {
    //                 $path = './uploads/'.$folder;   
    //             }

    //             $config = array(
    //                 'upload_path' => $path,
    //                 'allowed_types' => FILE_TYPE,
    //                 'max_size' => MAX_SIZE,
    //             );
                
    //             $this->load->library('upload', $config);
    //             $this->upload->initialize($config);
    //             if ($this->upload->do_upload('file')) 
    //             {
    //                 $data = $this->upload->data();
    //                 $img = [
    //                     'case_no' => $case_no,
    //                     'user_code' => $user_code,
    //                     'file_name' => NOC,
    //                     'fetch_file_name' => $file.$data['file_ext'],
    //                     'file_type' => $data['file_type'],
    //                     'file_path' => $path.$file.$data['file_ext'],
    //                     'date_entry' => date('Y-m-d h:i:s'),
    //                     'mut_type' => 'NA',
    //                 ];
    //                 $insUpload = $this->db->insert('supportive_document', $img);
    //                 if($insUpload != 1 ){
    //                     $this->db->trans_rollback();
    //                     log_message('error', '#ERRORSD001: Uploading insertion failed in supportive_document for case no :'. $case_no);

    //                     $json = [
    //                         'errorMessage'=>"#ERRORSD001: NOC upload failed for Case No ".$case_no
    //                     ];
    //                     echo json_encode($json);
    //                     return false;
    //                 }
    //             }
    //             // for upload NOC ends here

    //             $old_data = $this->db->query("SELECT * FROM allotment_pet_dag WHERE 
    //             dist_code=? AND subdiv_code=? AND circle_code=? AND
    //             mouza_pargona_code=? and lot_no=? and case_no=? AND dag_no=?", 
    //             array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, 
    //             $case_no, $old_dag))->row();

    //             //land calculation
    //             $totalLand = ($tot_bigha * 100) + ($tot_katha * 20) + $tot_lessa;
    //             $totalAllotedLand = ($new_allot_bigha * 100) + ($new_allot_katha * 20) + $new_allot_lessa;

    //             if($totalLand < $totalAllotedLand){
    //                 $this->db->trans_rollback();
    //                 log_message('error', '#ERRALOT001: Alloted area was greated than the land described in chitha for case no :'. $case_no);
    //                 $json = [
    //                     'errorMessage'=>"#ERRALOT001: Invalid Alloted Land entered for Case No ".$case_no
    //                 ];
    //                 echo json_encode($json);
    //                 return false;
    //             }

    //             $dist_code = $this->input->post('dist_code');
    //             $subdiv_code = $this->input->post('subdiv_code');
    //             $cir_code = $this->input->post('cir_code');
    //             $mouza_pargona_code = $this->input->post('mouza_pargona_code');
    //             $vill_townprt_code = $this->input->post('vill_townprt_code');
    //             $lot_no = $this->input->post('lot_no');
    //             $old_dag = $this->input->post('old_dag');
    //             $new_dag_no = $this->input->post('dag_list');

    //             //updating new dag details in allotment_pet_dag
    //             $updateAllotmentPetDag = [
    //                 'dag_no' => $new_dag_no,
    //                 'alot_area_b' => $new_allot_bigha,
    //                 'alot_area_k' => $new_allot_katha,
    //                 'alot_area_lc' => $new_allot_lessa,
    //                 'tot_area_b' => $tot_bigha,
    //                 'tot_area_k' => $tot_katha,
    //                 'tot_area_lc' => $tot_lessa,
    //                 'date_entry' => date('Y-m-d H:i:s'),
    //             ];
    //             $this->db->where(['case_no' => $case_no, 'dist_code' => $dist_code, 
    //             'subdiv_code' => $subdiv_code, 'circle_code' => $cir_code, 
    //             'mouza_pargona_code' => $mouza_pargona_code, 
    //             'vill_townprt_code' => $vill_townprt_code, 'lot_no' => $lot_no]);
    //             $this->db->update('allotment_pet_dag', $updateAllotmentPetDag);
    //             if($this->db->affected_rows() <= 0)
    //             {
    //                 $this->db->trans_rollback();
    //                 log_message('error', '#ERRALOT002: Updation failed in allotment_pet_dag for case no :'. $case_no);
    //                 $json = [
    //                     'errorMessage'=>"#ERRALOT002: Updation failed on changing Dag for Case No ".$case_no
    //                 ];
    //                 echo json_encode($json);
    //                 return false;
    //             }

    //             //inserting old dag details in basundhara_data_updation
    //             $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
    //             $basuData=array(
    //                 'ip'=>$this->utilityclass->get_client_ip(),
    //                 'case_no' => $case_no,
    //                 'basundhara' => $basundharaExist,
    //                 'user_code' => $this->session->userdata('user_code'),
    //                 'date_entry' => date('Y-m-d H:i:s'),
    //                 'changes_data' => json_encode($old_data)
    //             );    
    //             $basuIns=$this->db->insert('basundhara_data_updation', $basuData);
    //             if($basuIns != 1){
    //                 $this->db->trans_rollback();
    //                 log_message('error', '#ERRALOT003: Insertion failed in basundhara_data_updation for case no '.$case_no);
    //                 $json = [
    //                     'errorMessage'=>"#ERRALOT003: Updation failed on changing Dag for Case No ".$case_no
    //                 ];
    //                 echo json_encode($json);
    //                 return false;
    //             }
    //         } //dag changed ends here

    //         ////upload allotment certificate
    //         if($no[4]=='ACPP'){
    //             $folder = 'allotment/'.$dist_code.'/';
    //             $petition_no = $this->db->query("SELECT petition_no FROM allotment_cert_basic
    //             WHERE case_no=? ", array($case_no))->row()->petition_no;
    //         }
    //         $file1 = $petition_no.date('Y').'_1'.$sl;

    //         $_FILES['file1']['type'] = $_FILES['upload_allotment']['type'];
    //         $_FILES['file1']['tmp_name'] = $_FILES['upload_allotment']['tmp_name'];
    //         $_FILES['file1']['error'] = $_FILES['upload_allotment']['error'];
    //         $_FILES['file1']['size'] = $_FILES['upload_allotment']['size'];

    //         $ext = pathinfo($_FILES['upload_allotment']['name'], PATHINFO_EXTENSION);
    //         $_FILES['file1']['name'] = $file1.'.'.$ext;

    //         if(!file_exists('./uploads/'.$folder)){
    //             mkdir('./uploads/'.$folder, 0777, true);
    //             $path = './uploads/'.$folder;
    //         }
    //         else {
    //             $path = './uploads/'.$folder;   
    //         }

    //         $config = array(
    //             'upload_path' => $path,
    //             'allowed_types' => FILE_TYPE,
    //             'max_size' => MAX_SIZE,
    //         );

    //         $this->load->library('upload', $config);
    //         $this->upload->initialize($config);
    //         if ($this->upload->do_upload('file1')) 
    //         {
    //             $data = $this->upload->data();
    //             $allot_cert = [
    //                 'case_no' => $case_no,
    //                 'user_code' => $user_code,
    //                 'file_name' => ALLOT_CERT,
    //                 'fetch_file_name' => $file1.$data['file_ext'],
    //                 'file_type' => $data['file_type'],
    //                 'file_path' => $path.$file1.$data['file_ext'],
    //                 'date_entry' => date('Y-m-d h:i:s'),
    //                 'mut_type' => 'NA',
    //             ];
    //             $insUploadAllot = $this->db->insert('supportive_document', $allot_cert);
    //             if($insUploadAllot != 1 ){
    //                 $this->db->trans_rollback();
    //                 log_message('error', '#ERRORAL001: Uploading insertion failed in supportive_document for case no :'. $case_no);

    //                 $json = [
    //                     'errorMessage'=>"#ERRORAL001: Allotment Certificate uploading failed for Case No ".$case_no
    //                 ];
    //                 echo json_encode($json);
    //                 return false;
    //             }
    //         }
    //         // allotment certificate upload ends here

    //         $q = "SELECT max(order_slno) AS id FROM allotment_lm_note WHERE 
    //         case_no='$case_no'";
    //         $slno = $this->db->query($q)->row()->id;
    //         if ($slno == 0) {
    //             $slno = 1;
    //         } else {
    //             $slno = $slno + 1;
    //         }
                
    //         $lmnote = array(
    //             'dist_code' => $dist_code,
    //             'subdiv_code' => $subdiv_code,
    //             'circle_code' => $cir_code,
    //             'mouza_pargona_code' => $mouza_pargona_code,
    //             'lot_no' => $lot_no,
    //             'vill_townprt_code' => $vill_townprt_code,
    //             'case_no' => $case_no,
    //             'year_no' => date('Y'),
    //             'certificate_ok_not' => $allotte_k,
    //             'original_alotee' => $original_alotee,
    //             'under_possesion' => $posession_y,
    //             'under_possesion_yr' => $p_year,
    //             'nature_land' => $land_use,
    //             'three_km_radius' => $three_km,
    //             'ten_km_radius' => $ten_km,
    //             'area_posession_b' => $p_bigha,
    //             'area_posession_k' => $p_katha,
    //             'area_posession_lc' => $p_lessa,
    //             't_area_posession_b' => $tot_bigha,
    //             't_area_posession_k' => $tot_katha,
    //             't_area_posession_lc' => $tot_lessa,
    //             'new_dag' => $new_dag,
    //             'new_patta' => $new_patta,
    //             'l_rev' => $revenue,
    //             'l_tax' => $local_tax,
    //             'date_entry' => date('Y-m-d'),
    //             'user_code' => $user_code,
    //             'lm_comment' => $comment,
    //             'order_slno' => $slno,
    //             'recorded_tenant' => $recorded_tenant,
    //             'old_rev' => $old_rev,
    //             'old_lc' => $old_lc,
    //             'patta_type_code' => $new_patta_type,
    //             'ladclass_code' => $new_landcode,
    //         );
    //         $alotmentLM = $this->db->insert('allotment_lm_note', $lmnote);
    //         if($alotmentLM != 1){
    //             $this->db->trans_rollback();
    //             log_message('error', '#ERRALOT004: Insertion failed in allotment_lm_note for case no '.$case_no);
    //             $json = [
    //                 'errorMessage'=>"#ERRALOT004: Updation failed on changing Dag for Case No ".$case_no
    //             ];
    //             echo json_encode($json);
    //             return false;
    //         }
    //         $update = array(
    //             'lm_code' => $user_code,
    //             'lm_note' => 'Y',
    //             'lm_entry_date' => date('Y-m-d'),
    //             'sk_note' => null
    //         );
    //         $this->db->where('dist_code', $dist_code);
    //         $this->db->where('subdiv_code', $subdiv_code);
    //         $this->db->where('circle_code', $cir_code);
    //         $this->db->where('case_no', $case_no);
    //         $this->db->update('allotment_cert_basic', $update);
    //         if($this->db->affected_rows() <= 0)
    //         {
    //             $this->db->trans_rollback();
    //             log_message('error', '#ERR005: Updation failed in allotment_pet_dag for case no :'. $case_no);
    //             $json = [
    //                 'errorMessage'=>"#ERR005: Updation failed on changing Dag for Case No ".$case_no
    //             ];
    //             echo json_encode($json);
    //             return false;
    //         }

    //         $this->db->trans_commit();
    //         ///////
    //         $penUser='SK';
    //         $rmrk='Report given by LM';
    //         $this->DashboardData($case_no,$penUser,$rmrk);
    //         $rmk=$rmrk;
    //         $status='M';
    //         $task='LM';
    //         $pen='SK';
    //         $case=$case_no;
    //         $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
    //         //////

    //         $json['success'] = 'true';
    //         $json['case_no'] = $case_no;
    //         $json['redirect'] = base_url()."index.php/Allotment/lmpending";
    //     }
    //     echo json_encode($json);
    //     return;
    // }
    function lm_submit() 
    {
        $allowed = ['LM'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        //xss & security validation starts
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }
        $resp = checkRequestValidQuery($_POST);
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }    
        if($errorMessageStr != ''){
            $data=array(
                'audit' => $errorMessageStr
            );
            echo json_encode($data);
            return false;
            exit;
        }
        //xss & security validation ends 
        $json =array();
        //$json['error_a'] =array();
        $case_no = $this->input->post('case');
        $no = explode('/', $case_no);
        
        ////////// BARAK VALLEY CODE STARTS HERE ///////////
        $barak = in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY));
        
        $count = $this->db->query("SELECT count(case_no) AS count FROM supportive_document 
        WHERE case_no=?", array($case_no))->row()->count;
        $sl = $count+1;

       // $json = '';
        $updateFlag = $this->input->post('change_dag'); //used for if dag has changed

        if($updateFlag == 1) //if dag has changed
        {
            ////////// BARAK VALLEY CODE STARTS HERE ///////////
            if($barak){
                $dagDetailValidation = [
                    [
                        'field' => 'dag_list',
                        'label' => 'Dag No',
                        'rules' => 'trim|required|xss_clean|callback_dagNoValidationCheck',
                    ],
                    [
                        'field' => 'new_alot_b',
                        'label' => 'Alloted Bigha',
                        'rules' => 'trim|required|xss_clean|integer',
                    ],
                    [
                        'field' => 'new_alot_k',
                        'label' => 'Alloted Katha',
                        'rules' => 'trim|required|xss_clean|integer',
                    ],
                    [
                        'field' => 'new_alot_lc',
                        'label' => 'Alloted Chatak',
                        'rules' => 'trim|numeric|required|xss_clean',
                    ],
                    [
                        'field' => 'new_alot_g',
                        'label' => 'Alloted Ganda',
                        'rules' => 'trim|numeric|required|xss_clean',
                    ],
                ];    
            }
            else {
                $dagDetailValidation = [
                    [
                        'field' => 'dag_list',
                        'label' => 'Dag No',
                        'rules' => 'trim|required|xss_clean|callback_dagNoValidationCheck',
                    ],
                    [
                        'field' => 'new_alot_b',
                        'label' => 'Alloted Bigha',
                        'rules' => 'trim|required|xss_clean|integer',
                    ],
                    [
                        'field' => 'new_alot_k',
                        'label' => 'Alloted Katha',
                        'rules' => 'trim|required|xss_clean|integer',
                    ],
                    [
                        'field' => 'new_alot_lc',
                        'label' => 'Alloted Lessa',
                        'rules' => 'trim|numeric|required|xss_clean',
                    ],
                ];   
            }////////// BARAK VALLEY CODE ENDS HERE ///////////
            $this->form_validation->set_rules($dagDetailValidation);
            $this->form_validation->set_message('required', 'This %s is not valid');
            if ($this->form_validation->run('dagDetailValidation') == FALSE)
            {
                $this->form_validation->set_error_delimiters('', '');
                foreach($dagDetailValidation as $rule){
                if (form_error($rule['field'])) {
                    $json['error'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
                    }
                }
                echo json_encode($json);
                return;             
            }
            //NOC upload validation starts here
            $_FILES['file']['type'] = $_FILES['up_noc']['type'];
            $_FILES['file']['tmp_name'] = $_FILES['up_noc']['tmp_name'];
            $_FILES['file']['error'] = $_FILES['up_noc']['error'];
            $_FILES['file']['size'] = $_FILES['up_noc']['size'];

            $ext = pathinfo($_FILES['up_noc']['name'], PATHINFO_EXTENSION);

            $check_file_type = explode('|', FILE_TYPE);
            $checkFileExt = false;
            foreach ($check_file_type as $file_type) {
                if($ext == $file_type) {
                    $checkFileExt = true;
                    break;
                }
            }
            //$json['error_a']=null;
            if(empty($_FILES['up_noc']['name']))
            {
                $json['error_a'][] = array('err_msg' => ' NOC upload is mandatory in case of changing Dag.');
            }
            else if(!$checkFileExt){
                $json['error_a'][] = array('err_msg' => ' File type should be in ' . FILE_TYPE . '. format only');
            }
            else if($_FILES['up_noc']['size'] > (MAX_SIZE * 1024) )
            {
                $json['error_a'][] = array('err_msg' => ' Larger file size selected.');
            }
            //var_dump($json);
            //NOC upload validation ends here
            if($json != null )
            {
                echo json_encode($json);
                return true;    
            }
        }
        $lmReportValidation = [
            [
                'field' => 'p_bigha',
                'label' => 'Possesion Bigha',
                'rules' => 'trim|required|xss_clean|integer',
            ],
            [
                'field' => 'p_katha',
                'label' => 'Possesion Katha',
                'rules' => 'trim|required|xss_clean|integer',
            ],
            [
                'field' => 'p_lessa',
                'label' => 'Possesion Lessa',
                'rules' => 'trim|numeric|required|xss_clean|numeric',
            ],
            [
                'field' => 'exist_revenue',
                'label' => 'Existing TB Revenue',
                'rules' => 'trim|required|xss_clean|numeric',
            ],
            [
                'field' => 'exist_local_tax',
                'label' => 'Existing Local Tax',
                'rules' => 'trim|required|xss_clean|numeric',
            ],
            [
                'field' => 'revenue',
                'label' => 'Proposed Land Revenue',
                'rules' => 'trim|required|xss_clean|numeric',
            ],
            [
                'field' => 'local_tax',
                'label' => 'Proposed Local Tax',
                'rules' => 'trim|required|xss_clean|numeric',
            ],
            [
                'field' => 'lm_comment',
                'label' => 'LM Comment',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'whetherOr',
                'label' => 'Please Select One option',
                'rules' => 'trim|required|xss_clean',
            ],
        ];
        $this->form_validation->set_rules($lmReportValidation);
        $this->form_validation->set_message('integer', 'This %s is not valid');
        if ($this->form_validation->run('lmReportValidation') == FALSE)
        {
            $this->form_validation->set_error_delimiters('', '');
            foreach($lmReportValidation as $rule){
            if (form_error($rule['field'])) {
                $json['error1'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
                }
            }             
        }
        else
        {

            ////////// BARAK VALLEY CODE STARTS HERE ///////////
            $redirectURL = base_url()."index.php/Allotment/lmstep_one?case_no=".$case_no;
            if($barak){
                $new_allot_ganda = $this->input->post('new_alot_g');
                $p_ganda = $this->input->post('p_ganda');
                $tot_ganda = $this->input->post('tot_ganda');
                if(($this->input->post('p_bigha')+$this->input->post('p_katha')+$this->input->post('p_lessa')+$this->input->post('p_ganda'))==0){            
                    $this->session->set_flashdata('message', '#ERRORLOC: Total Allotement Area can not be zero ' . $case_no);
                    $json['location'] = 'true';
                    $json['redirect'] = $redirectURL;
                    echo json_encode($json);
                    return false;
                }
            }else{
                if(($this->input->post('p_bigha')+$this->input->post('p_katha')+$this->input->post('p_lessa'))==0){            
                    $this->session->set_flashdata('message', '#ERRORLOC: Total Allotement Area can not be zero ' . $case_no);
                    $json['location'] = 'true';
                    $json['redirect'] = $redirectURL;
                    echo json_encode($json);
                    return false;
                }
            }
            ////////// BARAK VALLEY CODE ENDS HERE ///////////
            $user_code = $this->session->userdata('user_code');
            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $cir_code = $this->input->post('cir_code');
            $mouza_pargona_code = $this->input->post('mouza_pargona_code');
            $vill_townprt_code = $this->input->post('vill_townprt_code');
            $lot_no = $this->input->post('lot_no');
            $old_dag = $this->input->post('old_dag');
            $new_dag_no = $this->input->post('dag_list');

            $new_allot_bigha = $this->input->post('new_alot_b');
            $new_allot_katha = $this->input->post('new_alot_k');
            $new_allot_lessa = $this->input->post('new_alot_lc');

            $tot_bigha = $this->input->post('tot_bigha');
            $tot_katha = $this->input->post('tot_katha');
            $tot_lessa = $this->input->post('tot_lessa');
            $p_bigha = $this->input->post('p_bigha');
            $p_katha = $this->input->post('p_katha');
            $p_lessa = $this->input->post('p_lessa');
            $new_dag = $this->input->post('new_dag');
            $new_patta = $this->input->post('new_patta');
            $revenue = $this->input->post('revenue');
            $local_tax = $this->input->post('local_tax');
            $whetherOr = $this->input->post('whetherOr');

            
            
            //check if location selected are same as post
            $q = $this->db->query("SELECT dist_code, subdiv_code, circle_code,
            mouza_pargona_code, lot_no, vill_townprt_code FROM allotment_cert_basic 
            WHERE case_no=?", $case_no)->row();
            if($q->dist_code!=$dist_code && $q->subdiv_code!=$subdiv_code && 
            $q->circle_code!=$cir_code && $q->mouza_pargona_code!=$mouza_pargona_code &&
            $q->vill_townprt_code!=$vill_townprt_code && $q->lot_no!=$lot_no){            
                $this->session->set_flashdata('message', '#ERRORLOC: Something went wrong for Case No ' . $case_no);
                $json['location'] = 'true';
                $json['redirect'] = $redirectURL;
                echo json_encode($json);
                return false;
            }
            
            // if dag changed, then add changes dag in lm comment
            if($updateFlag == 1){ 
                $lm_msg = 'Dag has changed from OLD DAG NO: '. $this->input->post('oDNo') .' to NEW DAG NO: '. $this->input->post('dag_list').'. ';
                $lm_comment = $lm_msg.$this->input->post('lm_comment');
            }
            else{
                $lm_comment = $this->input->post('lm_comment');    
            }

            $allotte_k = $this->input->post('allotte_k');
            $original_alotee = $this->input->post('original_alotee');
            $posession_y = $this->input->post('posession_y');
            $p_year = $this->input->post('p_year');
            $land_use = $this->input->post('land_use');
            $three_km = $this->input->post('three_km');
            $ten_km = $this->input->post('ten_km');
            $recorded_tenant = $this->input->post('allotte_rec');
            $old_rev = $this->input->post('exist_revenue');
            $old_lc = $this->input->post('exist_local_tax');
            $new_patta_type = $this->input->post('new_patta_type');
            $new_landcode = $this->input->post('new_landcode');
            $username = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code);
            $username = " লাট মন্ডল ------ " . $username->lm_name;
            $comment = $lm_comment . $username;
            $comment = addslashes($comment);

            $this->db->trans_begin();

            //if dag changed
            if($updateFlag == 1){

                //insert into petition_proceeding

                $pid = $this->db->query("SELECT count(proceeding_id) as pro_id FROM
                petition_proceeding WHERE case_no=?",array($case_no))->row()->pro_id;
                if($pid == 0) { $pid = 1; }
                else {$pid = $pid+1;}

                $insPetProceed = [
                    'case_no' => $case_no,
                    'proceeding_id' => $pid,
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'note_on_order' => $comment,
                    'status' => 'Pending',
                    'user_code' => $user_code,
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code
                ];
                $insertProceeding = $this->db->insert('petition_proceeding', $insPetProceed);
                if($insertProceeding != 1){
                    $this->db->trans_rollback();
                    log_message('error', '#ERRORPP: Insertion failed in petition_proceeding for case no :'. $case_no);
                    $json = [
                        'errorMessage'=>"#ERRORPP: Failed to forward the case for Case No : ".$case_no
                    ];
                    echo json_encode($json);
                    return false;
                }



                // for upload NOC starts here
                if($no[4]=='ACPP'){
                    $folder = ALLOTMENT_BASE_DIR . $dist_code . UPLOAD_SEPARATOR;
                    $petition_no = $this->db->query("SELECT petition_no FROM allotment_cert_basic
                    WHERE case_no=? ", array($case_no))->row()->petition_no;
                }
                $file = $petition_no.date('Y').'_'.$sl;
                
                $_FILES['file']['type'] = $_FILES['up_noc']['type'];
                $_FILES['file']['tmp_name'] = $_FILES['up_noc']['tmp_name'];
                $_FILES['file']['error'] = $_FILES['up_noc']['error'];
                $_FILES['file']['size'] = $_FILES['up_noc']['size'];

                $ext = pathinfo($_FILES['up_noc']['name'], PATHINFO_EXTENSION);
                $_FILES['file']['name'] = $file.'.'.$ext;

                if(!file_exists($folder)){
                    mkdir($folder, 0777, true);
                    $path = $folder;
                }
                else {
                    $path = $folder;   
                }
                // if(!file_exists(UPLOAD_BASE.$folder)){
                //     mkdir(UPLOAD_BASE.$folder, 0777, true);
                //     $path = UPLOAD_BASE.$folder;
                // }
                // else {
                //     $path = UPLOAD_BASE.$folder;   
                // }

                $config = array(
                    'upload_path' => $path,
                    'allowed_types' => FILE_TYPE,
                    'max_size' => MAX_SIZE,
                );
                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('file')) 
                {
                    $data = $this->upload->data();
                    $img = [
                        'case_no' => $case_no,
                        'user_code' => $user_code,
                        'file_name' => NOC,
                        'fetch_file_name' => $file.$data['file_ext'],
                        'file_type' => $data['file_type'],
                        'file_path' => $path.$file.$data['file_ext'],
                        'date_entry' => date('Y-m-d h:i:s'),
                        'mut_type' => 'NA',
                    ];
                    $insUpload = $this->db->insert('supportive_document', $img);
                    if($insUpload != 1 ){
                        $this->db->trans_rollback();
                        log_message('error', '#ERRORSD001: Uploading insertion failed in supportive_document for case no :'. $case_no);

                        $json = [
                            'errorMessage'=>"#ERRORSD001: NOC upload failed for Case No ".$case_no
                        ];
                        echo json_encode($json);
                        return false;
                    }
                }
                // for upload NOC ends here

                $old_data = $this->db->query("SELECT * FROM allotment_pet_dag WHERE 
                dist_code=? AND subdiv_code=? AND circle_code=? AND
                mouza_pargona_code=? and lot_no=? and case_no=? AND dag_no=?", 
                array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, 
                $case_no, $old_dag))->row();

               ////////// BARAK VALLEY CODE STARTS HERE ///////////
                if($barak){
                    $totalLand = ($tot_bigha*6400)+($tot_katha*320)+($tot_lessa*20)+$tot_ganda;
                    $totalAllotedLand = ($new_allot_bigha*6400)+($new_allot_katha*320)+($new_allot_lessa*20)+$new_allot_ganda;
                }
                else {
                    $totalLand = ($tot_bigha * 100) + ($tot_katha * 20) + $tot_lessa;
                    $totalAllotedLand = ($new_allot_bigha * 100) + ($new_allot_katha * 20) + $new_allot_lessa;
                }
                ////////// BARAK VALLEY CODE ENDS HERE ///////////

                if($totalLand < $totalAllotedLand){
                    $this->db->trans_rollback();
                    log_message('error', '#ERRALOT001: Alloted area was greated than the land described in chitha for case no :'. $case_no);
                    $json = [
                        'errorMessage'=>"#ERRALOT001: Invalid Alloted Land entered for Case No ".$case_no
                    ];
                    echo json_encode($json);
                    return false;
                }

                $dist_code = $this->input->post('dist_code');
                $subdiv_code = $this->input->post('subdiv_code');
                $cir_code = $this->input->post('cir_code');
                $mouza_pargona_code = $this->input->post('mouza_pargona_code');
                $vill_townprt_code = $this->input->post('vill_townprt_code');
                $lot_no = $this->input->post('lot_no');
                $old_dag = $this->input->post('old_dag');
                $new_dag_no = $this->input->post('dag_list');

                //updating new dag details in allotment_pet_dag
                ////////// BARAK VALLEY CODE STARTS HERE ///////////
                if($barak){
                    $updateAllotmentPetDag = [
                        'dag_no' => $new_dag_no,
                        'alot_area_b' => $new_allot_bigha,
                        'alot_area_k' => $new_allot_katha,
                        'alot_area_lc' => $new_allot_lessa,
                        'tot_area_b' => $tot_bigha,
                        'tot_area_k' => $tot_katha,
                        'tot_area_lc' => $tot_lessa,
                        'tot_area_g' => $tot_ganda,
                        'date_entry' => date('Y-m-d H:i:s'),
                    ];
                }
                else {
                    $updateAllotmentPetDag = [
                        'dag_no' => $new_dag_no,
                        'alot_area_b' => $new_allot_bigha,
                        'alot_area_k' => $new_allot_katha,
                        'alot_area_lc' => $new_allot_lessa,
                        'tot_area_b' => $tot_bigha,
                        'tot_area_k' => $tot_katha,
                        'tot_area_lc' => $tot_lessa,
                        'date_entry' => date('Y-m-d H:i:s'),
                    ];    
                }
                ////////// BARAK VALLEY CODE ENDS HERE ///////////
                $this->db->where(['case_no' => $case_no, 'dist_code' => $dist_code, 
                'subdiv_code' => $subdiv_code, 'circle_code' => $cir_code, 
                'mouza_pargona_code' => $mouza_pargona_code, 
                'vill_townprt_code' => $vill_townprt_code, 'lot_no' => $lot_no]);
                $this->db->update('allotment_pet_dag', $updateAllotmentPetDag);
                if($this->db->affected_rows() <= 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRALOT002: Updation failed in allotment_pet_dag for case no :'. $case_no);
                    $json = [
                        'errorMessage'=>"#ERRALOT002: Updation failed on changing Dag for Case No ".$case_no
                    ];
                    echo json_encode($json);
                    return false;
                }

                //inserting old dag details in basundhara_data_updation
                $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
                $basuData=array(
                    'ip'=>$this->utilityclass->get_client_ip(),
                    'case_no' => $case_no,
                    'basundhara' => $basundharaExist,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d H:i:s'),
                    'changes_data' => json_encode($old_data)
                );    
                $basuIns=$this->db->insert('basundhara_data_updation', $basuData);
                if($basuIns != 1){
                    $this->db->trans_rollback();
                    log_message('error', '#ERRALOT003: Insertion failed in basundhara_data_updation for case no '.$case_no);
                    $json = [
                        'errorMessage'=>"#ERRALOT003: Updation failed on changing Dag for Case No ".$case_no
                    ];
                    echo json_encode($json);
                    return false;
                }
            } //dag changed ends here

            ////upload allotment certificate
            if($no[4]=='ACPP'){
                $folder = ALLOTMENT_BASE_DIR . $dist_code . UPLOAD_SEPARATOR;
                $petition_no = $this->db->query("SELECT petition_no FROM allotment_cert_basic
                WHERE case_no=? ", array($case_no))->row()->petition_no;
            }
            $file1 = $petition_no.date('Y').'_1'.$sl;

            $_FILES['file1']['type'] = $_FILES['upload_allotment']['type'];
            $_FILES['file1']['tmp_name'] = $_FILES['upload_allotment']['tmp_name'];
            $_FILES['file1']['error'] = $_FILES['upload_allotment']['error'];
            $_FILES['file1']['size'] = $_FILES['upload_allotment']['size'];

            $ext = pathinfo($_FILES['upload_allotment']['name'], PATHINFO_EXTENSION);
            $_FILES['file1']['name'] = $file1.'.'.$ext;

            if(!file_exists($folder)){
                mkdir($folder, 0777, true);
                $path = $folder;
            }
            else {
                $path = $folder;   
            }
            // if(!file_exists(UPLOAD_BASE.$folder)){
            //     mkdir(UPLOAD_BASE.$folder, 0777, true);
            //     $path = UPLOAD_BASE.$folder;
            // }
            // else {
            //     $path = UPLOAD_BASE.$folder;   
            // }

            $config = array(
                'upload_path' => $path,
                'allowed_types' => FILE_TYPE,
                'max_size' => MAX_SIZE,
            );

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file1')) 
            {
                $data = $this->upload->data();
                $allot_cert = [
                    'case_no' => $case_no,
                    'user_code' => $user_code,
                    'file_name' => ALLOT_CERT,
                    'fetch_file_name' => $file1.$data['file_ext'],
                    'file_type' => $data['file_type'],
                    'file_path' => $path.$file1.$data['file_ext'],
                    'date_entry' => date('Y-m-d h:i:s'),
                    'mut_type' => 'NA',
                ];
                $insUploadAllot = $this->db->insert('supportive_document', $allot_cert);
                if($insUploadAllot != 1 ){
                    $this->db->trans_rollback();
                    log_message('error', '#ERRORAL001: Uploading insertion failed in supportive_document for case no :'. $case_no);

                    $json = [
                        'errorMessage'=>"#ERRORAL001: Allotment Certificate uploading failed for Case No ".$case_no
                    ];
                    echo json_encode($json);
                    return false;
                }
            }
            // allotment certificate upload ends here

            $q = "SELECT max(order_slno) AS id FROM allotment_lm_note WHERE 
            case_no='$case_no'";
            $slno = $this->db->query($q)->row()->id;
            if ($slno == 0) {
                $slno = 1;
            } else {
                $slno = $slno + 1;
            }
                
            ////////// BARAK VALLEY CODE STARTS HERE //////////////
            if($barak){    
                $lmnote = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'circle_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'case_no' => $case_no,
                    'year_no' => date('Y'),
                    'certificate_ok_not' => $allotte_k,
                    'original_alotee' => $original_alotee,
                    'under_possesion' => $posession_y,
                    'under_possesion_yr' => $p_year,
                    'nature_land' => $land_use,
                    'three_km_radius' => $three_km,
                    'ten_km_radius' => $ten_km,
                    'area_posession_b' => $p_bigha,
                    'area_posession_k' => $p_katha,
                    'area_posession_lc' => $p_lessa,
                    'area_posession_g' => $p_ganda,
                    't_area_posession_b' => $tot_bigha,
                    't_area_posession_k' => $tot_katha,
                    't_area_posession_lc' => $tot_lessa,
                    't_area_posession_g' => $tot_ganda,
                    'new_dag' => $new_dag,
                    'new_patta' => $new_patta,
                    'l_rev' => $revenue,
                    'l_tax' => $local_tax,
                    'date_entry' => date('Y-m-d'),
                    'user_code' => $user_code,
                    'lm_comment' => $comment,
                    'order_slno' => $slno,
                    'recorded_tenant' => $recorded_tenant,
                    'old_rev' => $old_rev,
                    'old_lc' => $old_lc,
                    'patta_type_code' => $new_patta_type,
                    'ladclass_code' => $new_landcode,
                    'area_fall_under' => $whetherOr,
                );
            }
            else {
                $lmnote = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'circle_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'case_no' => $case_no,
                    'year_no' => date('Y'),
                    'certificate_ok_not' => $allotte_k,
                    'original_alotee' => $original_alotee,
                    'under_possesion' => $posession_y,
                    'under_possesion_yr' => $p_year,
                    'nature_land' => $land_use,
                    'three_km_radius' => $three_km,
                    'ten_km_radius' => $ten_km,
                    'area_posession_b' => $p_bigha,
                    'area_posession_k' => $p_katha,
                    'area_posession_lc' => $p_lessa,
                    't_area_posession_b' => $tot_bigha,
                    't_area_posession_k' => $tot_katha,
                    't_area_posession_lc' => $tot_lessa,
                    'new_dag' => $new_dag,
                    'new_patta' => $new_patta,
                    'l_rev' => $revenue,
                    'l_tax' => $local_tax,
                    'date_entry' => date('Y-m-d'),
                    'user_code' => $user_code,
                    'lm_comment' => $comment,
                    'order_slno' => $slno,
                    'recorded_tenant' => $recorded_tenant,
                    'old_rev' => $old_rev,
                    'old_lc' => $old_lc,
                    'patta_type_code' => $new_patta_type,
                    'ladclass_code' => $new_landcode,
                    'area_fall_under' => $whetherOr,
                );   
            }
            ////////// BARAK VALLEY CODE ENDS HERE //////////////
            $alotmentLM = $this->db->insert('allotment_lm_note', $lmnote);
            if($alotmentLM != 1){
                $this->db->trans_rollback();
                log_message('error', '#ERRALOT004: Insertion failed in allotment_lm_note for case no '.$case_no);
                $json = [
                    'errorMessage'=>"#ERRALOT004: Updation failed on changing Dag for Case No ".$case_no
                ];
                echo json_encode($json);
                return false;
            }
            $update = array(
                'lm_code' => $user_code,
                'lm_note' => 'Y',
                'lm_entry_date' => date('Y-m-d'),
                'sk_note' => null
            );
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('circle_code', $cir_code);
            $this->db->where('case_no', $case_no);
            $this->db->update('allotment_cert_basic', $update);
            if($this->db->affected_rows() <= 0)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERR005: Updation failed in allotment_pet_dag for case no :'. $case_no);
                $json = [
                    'errorMessage'=>"#ERR005: Updation failed on changing Dag for Case No ".$case_no
                ];
                echo json_encode($json);
                return false;
            }

            $getLoc = $this->db->query('select * from allotment_cert_basic where case_no = ?', array($case_no));
            if($getLoc->num_rows() <= 0){
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "ERR862: Something went wrong! Unable to process... $case_no");
                redirect(base_url() . 'index.php/home');
            }

            $locRow = $getLoc->row();

            
            $append = "dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$locRow->mouza_pargona_code' and lot_no='$locRow->lot_no' and ". "vill_townprt_code='$locRow->vill_townprt_code'";
            
            $pb = $this->db->query("select * from allotment_cert_basic where case_no='$case_no' and $append")->row();
            //ESCALATION CODE INTEGRATION================SANMRI
            // $executionDate = $this->input->post('executionDate');
            $executionDate = date('Y-m-d H:i:s');
            $user_code = $this->session->userdata('user_code');
            $es_flag = $pb->es_flag;

            if($es_flag == 1 && ESCALATION_ENABLE ==1 && $pb->out_of_esc == 0){

                $escalationUpdateStatus = $this->Escalationmodel->escalationLMFirstProcedingAllotment($executionDate,$dist_code,$subdiv_code,$cir_code,$locRow->mouza_pargona_code,$locRow->lot_no,$case_no,$user_code);

                log_message("error", "#ESC5803, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

                if($escalationUpdateStatus['responseType'] == 0){
                    $this->db->trans_rollback();
                    log_message('error', '#ESC35803: Updation failed in escalation for case no :'. $case_no);
                    $json = [
                        'errorMessage'=>"#ESC35803: Updation failed on escalation for Case No ".$case_no
                    ];
                    echo json_encode($json);
                    return false;
                }
            }

            $this->db->trans_commit();
            //$this->db->trans_rollback();
            ///////
            $penUser='SK';
            $rmrk='Report given by LM';
            $this->DashboardData($case_no,$penUser,$rmrk);
            $rmk=$rmrk;
            $status='M';
            $task='LM';
            $pen='SK';
            $case=$case_no;
            $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
            //////

            $json['success'] = 'true';
            $json['case_no'] = $case_no;
            $json['redirect'] = base_url()."index.php/Allotment/lmpending";
        }


        echo json_encode($json);
        return;
    }
    ///////////////////////////
    function viewproReject() {
        //$db=  $this->session->userdata('db');
        $basundhara = $this->input->get('app');
        $case_no=$this->basundharamodel->fetchDharitree($basundhara);
        if($case_no!=null){
            $q = "Select lm_comment,date_entry,sk_comment,sk_date_entry from allotment_lm_note where case_no='$case_no'";
            $data['pb'] = $this->db->query($q)->row();
            $q = "Select * from    petition_proceeding_dc_adc where case_no='$case_no' order by proceeding_id ";
            $data['pd'] = $this->db->query($q)->result();
            //$this->load->view('../views/allotment/view_proceeding', $data);
            //$data['_view'] = 'allotment/view_proceeding';
            $q1 = "SELECT COUNT(proceeding_id) AS c FROM petition_proceeding_dc_adc 
            WHERE case_no=?";
            $data['count'] = $this->db->query($q1, $case_no)->row()->c;
            $q_pet = "SELECT * FROM petition_proceeding WHERE case_no=? ORDER BY proceeding_id";
            $data['pet_proceeding'] = $this->db->query($q_pet, $case_no)->result();
        }else{
            $data=null;
            $data['pb']=$data['pd']=$data['count']=$data['pet_proceeding']=null;
        }
        $this->load->view('allotment/view_proceedingReject',$data);
    }
    //////////////////////////
    ///////////////// 19-04-22 /////////////////
    public function COrevertToADC(){ //view page

        $case_no = $this->input->get('case_no');
        //****Escalation */
        $getLoc = $this->db->query('select * from allotment_cert_basic where case_no = ?', array($case_no));
        if($getLoc->num_rows() <= 0){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "ERR862: Something went wrong! Unable to process... $case_no");
            redirect(base_url() . 'index.php/home');
        }
        $locRow = $getLoc->row();
        $append = "dist_code='$locRow->dist_code' and subdiv_code='$locRow->subdiv_code' and circle_code='$locRow->circle_code' and mouza_pargona_code='$locRow->mouza_pargona_code' and lot_no='$locRow->lot_no' and ". "vill_townprt_code='$locRow->vill_townprt_code'";
        
        $pb = $this->db->query("select * from allotment_cert_basic where case_no='$case_no' and $append")->row();

        $flag = false;
        if($pb->es_flag == 1 && ESCALATION_ENABLE == 1){
            //remaining Days of LM ============
            $escalatedRowDetailsAgainstPetitionno = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($case_no);
            if(empty($escalatedRowDetailsAgainstPetitionno) || $escalatedRowDetailsAgainstPetitionno == null)
            {
                $this->session->set_flashdata('message', "Something went wrong.ALLOT- Error Code(#ESC74047)");
                redirect(base_url() . "index.php/home");
            }

            $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->dc_target_days;
            $previousCompletedDaysDC = $escalatedRowDetailsAgainstPetitionno->dc_completed_days;
            $remaining_days_DC = $this->Escalationmodel->getRemainingDays($previousCompletedDaysDC,$originalAllocation);

            //remaining days of CO==============
            $originalAllocationCO   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            $remaining_days_CO= $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO,$originalAllocationCO);
            if($remaining_days_DC == 0){
                $flag = true;
            }else{
                $flag = false;
            }
        }

        $data['flag'] = $flag;
        $data['remainingDaysCO'] = $remaining_days_CO;

        $data['_view'] = 'allotment/revertToADC';
        $this->load->view('layouts/main', $data);
    }
    public function COrevertRemarks() //remarks
    {
        //xss & security validation starts
         $errorMessageStr = '';
         $resp = checkRequestSpecChar($_POST);
         if($resp['status'] == 'n'){
             $errorMessageStr .= $resp['messages'];
         }
         $resp = checkRequestValidQuery($_POST);
         if($resp['status'] == 'n'){
             $errorMessageStr .= $resp['messages'];
         }    
         if($errorMessageStr != ''){
            $this->session->set_flashdata('message', $errorMessageStr);
             return redirect($_SERVER['HTTP_REFERER']);
         }
        //xss & security validation ends  
        $case_no = $this->input->get('case_no');
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $user_code = $this->session->userdata('user_code');

        $url = base_url()."index.php/Allotment/COrevertToADC?case_no=".$case_no."&dist_code=".$dist_code."&subdiv_code=".$subdiv_code."&cir_code=".$cir_code."&mouza_pargona_code=".$mouza_pargona_code."&lot_no=".$lot_no."&vill_townprt_code=".$vill_townprt_code;

        $remarks = $this->input->post('revert_report_remarks_co');

        $this->form_validation->set_rules('revert_report_remarks_co', 'Remarks', 'required|trim|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', 'Remark field is required');
            redirect($url);
        }

        //get max proceeding id
        $max_id = $this->db->query("SELECT max(proceeding_id)+1 as proc_id FROM petition_proceeding_dc_adc WHERE case_no=?", $case_no)->row()->proc_id;

        if($max_id==null){ $proceeding_id = 1; }
        else { $proceeding_id = $max_id; }

        $name = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $user_code);
        $co_name = $name->username;
        $proceeding3 = " চক্র বিষয়া -----" . $co_name;

        $this->db->trans_begin();

        //insert into proceeding dc adc
        $ins = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'co_order' => $remarks.$proceeding3,
            'date_of_hearing' => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'status' => 'R',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d h:i:s'),
            'operation' => 'E',
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code
        ];
        $insertProceed = $this->db->insert("petition_proceeding_dc_adc", $ins);
        if($insertProceed != 1){
            $this->db->trans_rollback();
            log_message('error', '#ALLERR001: Insertion failed in petition_proceeding_dc_adc for case no :'. $case_no);
            $this->session->set_flashdata('message', '#ALLERR001: Failed to revert the case to ADC for case no :'. $case_no);
            redirect($url);
        }

        //update allotment cert basic
        $updateBasic = [
            'status' => 'R',
            //'status' => 'P',
            'dc_note' => null,
            'dc_entry_date' => null,
        ];
        $this->db->where(['dist_code'=>$dist_code, 'subdiv_code'=>$subdiv_code, 'circle_code'=>$cir_code, 'case_no'=>$case_no]);
        $this->db->update('allotment_cert_basic', $updateBasic);
        if($this->db->affected_rows() <= 0){
            $this->db->trans_rollback();
            log_message('error', '#ALLERR002: Uption failed in allotment_cert_basic for case no :'. $case_no);
            $this->session->set_flashdata('message', '#ALLERR002: Failed to revert the case to ADC for case no :'. $case_no);
            redirect($url);
        }

        //****revert back to DC * L/
        //ESCALATION CODE INTEGRATION================SANMRI
        $getLoc = $this->db->query('select * from allotment_cert_basic where case_no = ?', array($case_no));
        if($getLoc->num_rows() <= 0){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "ERR54862: Something went wrong! Unable to process... $case_no");
            redirect(base_url() . 'index.php/home');
        }
        $locRow = $getLoc->row();
        $append = "dist_code='$locRow->dist_code' and subdiv_code='$locRow->subdiv_code' and circle_code='$locRow->circle_code' and mouza_pargona_code='$locRow->mouza_pargona_code' and lot_no='$locRow->lot_no' and ". "vill_townprt_code='$locRow->vill_townprt_code'";
        
        $pb = $this->db->query("select * from allotment_cert_basic where case_no='$case_no' and $append")->row();
        if($pb->es_flag == 1 && ESCALATION_ENABLE ==1){
            $user_code = $this->session->userdata('user_code');
            // $executionDate = $this->input->post('executionDate');
            $executionDate = date('Y-m-d H:i:s');
            $allocation_days = null;

            // if($this->input->post('allocate_day') !=null){
            //     $allocation_days = $this->input->post('allocate_day');
            // }
            if (isset($_POST['allocate_day'])) {
                $allocation_days = $this->input->post('allocate_day');
                if(empty($allocation_days)){
                    $this->session->set_flashdata('message', "#ERR1034: Please select allocated days... $case_no");
                    redirect(base_url() . 'index.php/home');
                }
            }

            $escalationUpdateStatus = $this->Escalationmodel->escalationCORevertToDcALOT($executionDate,$locRow->dist_code,$locRow->subdiv_code,$locRow->circle_code,$case_no,$user_code,$locRow->mouza_pargona_code,$locRow->lot_no,$allocation_days);

            log_message("error", "#ESC5444152, transaction-error-STATUS======".json_encode($escalationUpdateStatus));
            if($escalationUpdateStatus['responseType'] == 0){
                $this->db->trans_rollback();
                log_message("error", "#ESC5444152, transaction-error in method 'LandReclassification/revertToLMReclassByCOEscalation' with case-no :". $case_no);
                $this->session->set_flashdata('message', "Something went wrong.RECLASS- Error Code(#ESC5444152)");
                redirect(base_url() . "index.php/home");
            }
            ///////////////END ESCALATION//////////////
        }


        $this->db->trans_commit();
        //////////////
        $rmk = $remarks.$proceeding3;
        $status='M';
        $task='CO';
        $pen='ADC';
        $this->basundharamodel->postApiBasundharaSec($case_no, $rmk, $status, $task, $pen);
        /////////////
        $this->session->set_flashdata('message', 'Successfully reverted to ADC for case no :'. $case_no);
        redirect(base_url() . "index.php/home");
    }
    //get pending reverted list
    public function getPendingCORevertCases(){

        $allowed = ['ADC'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');

        // $cases = $this->db->query("SELECT *, ba.basundhara FROM allotment_cert_basic fmb LEFT JOIN
        // basundhar_application ba ON fmb.case_no=ba.dharitree WHERE fmb.status=? AND fmb.dc_note 
        // IS NULL AND fmb.dist_code=? AND fmb.dc_code IS NOT NULL", array('P', $dist_code))->result();

        //************INTEGRATE CIRCLE MAPPING***************
        $circle_bifurcate = ''; 
        if(CIRCLE_BIRFURCATE_ADC == 1 && $this->session->userdata('user_desig_code') == 'ADC')
        {
            $flag = 'ALLOTMENT';
            $circle_bifurcate = $this->circleMappingModel->caseListUnderMappingCircleOfADC($flag);
        }
        //************END************************************

        $cases = $this->db->query("SELECT A.*, B.basundhara FROM allotment_cert_basic A LEFT JOIN basundhar_application B ON A.case_no=B.dharitree WHERE A.dc_note IS NULL 
            AND A.status='R' $circle_bifurcate AND A.case_no IN ( SELECT distinct on (pp.case_no) pp.case_no FROM petition_proceeding_dc_adc pp WHERE pp.status='R' ORDER BY pp.case_no,pp.proceeding_id DESC)")->result();
        //echo $this->db->last_query();return;
        $data['cases'] = $cases;
        $data['_view'] = 'Allotment/revertPendingCases';
        $this->load->view('layouts/main',$data);
    }
    //write report on reverted case
    function writeRevertReport() {

        $_GET['case_no'] = dec_param($this->input->get('case_no'), 'case_no');
        if($_GET['case_no'] == null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
        return;
        }

        $allowed = ['ADC'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

         //xss & security validation starts
         $errorMessageStr = '';
         $resp = checkRequestSpecChar($_POST);
         if($resp['status'] == 'n'){
             $errorMessageStr .= $resp['messages'];
         }
         $resp = checkRequestValidQuery($_POST);
         if($resp['status'] == 'n'){
             $errorMessageStr .= $resp['messages'];
         }    
         if($errorMessageStr != ''){
            $this->session->set_flashdata('message', $errorMessageStr);
             return redirect($_SERVER['HTTP_REFERER']);
         }
        //xss & security validation ends  
        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $case_no = $this->input->get('case_no');

        $data['allotment_cb'] = $alcb = $this->db->query("SELECT A.*, B.* FROM 
            allotment_cert_basic A JOIN petition_proceeding_dc_adc B ON
            A.case_no=B.case_no WHERE A.status=? AND A.dist_code=? AND A.case_no=? 
            AND A.dc_code IS NOT NULL AND B.status=? ORDER BY proceeding_id DESC", 
            array('R', $dist_code, $case_no, 'R'))->row();

        // $data['allotment_cb'] = $alcb = $this->db->query("SELECT A.*, B.* FROM 
        //     allotment_cert_basic A JOIN petition_proceeding_dc_adc B ON
        //     A.case_no=B.case_no WHERE A.status=? AND A.dist_code=? AND A.case_no=? 
        //     AND A.dc_code IS NOT NULL AND B.status=? ORDER BY proceeding_id DESC", 
        //     array('P', $dist_code, $case_no, 'Revert'))->row();
        $subdiv_code = $alcb->subdiv_code;
        $circle_code = $alcb->circle_code;
        $data['circlename'] = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $circle_code);
        $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
        $data['_view'] = 'allotment/writeRevertReport';
        $this->load->view('layouts/main',$data);
    }


    // added on 21-03-2024

    public function escProcessFinal() 
    {
        $allowed = ['DC', 'ADC'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }
        //xss & security validation starts
         $errorMessageStr = '';
         $resp = checkRequestSpecChar($_POST);
         if($resp['status'] == 'n'){
             $errorMessageStr .= $resp['messages'];
         }
         $resp = checkRequestValidQuery($_POST);
         if($resp['status'] == 'n'){
             $errorMessageStr .= $resp['messages'];
         } 

         if($errorMessageStr != ''){
            $this->session->set_flashdata('message', $errorMessageStr);
             return redirect($_SERVER['HTTP_REFERER']);
         }
        //xss & security validation ends 
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $case_no = $this->input->post('case_no');
        $comment = $this->input->post('dc_comment');
        $name = $this->utilityclass->dcname($dist_code, $user_code);
        $name = " উপায়ুক্ত / অতিৰিক্ত উপায়ুক্ত  ---" . $name;
        $merge = $comment . $name;
        $next_hearing = $this->input->post('next_hearing');

        $this->db->trans_begin();

        $q = "Select max(proceeding_id)+1 as p from petition_proceeding_dc_adc where case_no='$case_no' ";
        $count = $this->db->query($q)->row()->p;
        if ($count == 0) {
            $count = $count + 1;
        }
        $insert = array(
            'case_no' => $case_no,
            'proceeding_id' => $count,
            'date_of_hearing' => date('Y-m-d'),
            'co_order' => $merge,
            'next_date_of_hearing' => (ESCALATION_ENABLE == 1)?date('Y-m-d H:i:s', strtotime($this->input->post('next_date'))) : date('Y-m-d', strtotime($this->input->post('next_date'))),
            'status' => 'Pending',
            'user_code' => $user_code,
            'date_entry' => date('Y-m-d'),
            'operation' => 'E',
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code
        );
        //var_dump($insert);
        $insert_proc = $this->db->insert('petition_proceeding_dc_adc', $insert);
        if($insert_proc != 1){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#ERR1695: Unable to process! Someting went wrong... $case_no");
            redirect(base_url() . 'index.php/home');
        }

        if ($next_hearing == 'F') { // DC final order
            $update = array(
                'bo_code'       => 'BO',
                'bo_date_entry' => date('Y-m-d'),
                'bo_note'       => 'For escalation, BO report is not required.',
                'dc_code'       => $user_code,
                'dc_entry_date' => date('Y-m-d'),
                'dc_note'       => $merge,
                'status'        => 'F',
                //'chitha_correct_yn'=>null,
                //'chitha_correct_date'=>date('Y-m-d')
            );
            ////////////////////////////////////////
            $penUser  ='CO';
            $rmrk     ='Order given By DC';
            $this->DashboardData($case_no,$penUser,$rmrk);
            $rmk      = $rmrk;
            $status   = 'M';
            $task     = 'DC';
            $pen      = 'CO';
            $case     = $case_no;
            $API      = $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
            ////////////////////////////////////////
        }

        if ($next_hearing == 'P') {
            $update = array(
                'dc_code' => null,
                'dc_entry_date' => null,
                'dc_note' => $merge,
                'co_note' => null,
                'bo_code' => null,
                'co_entry_date' => null,
                'bo_date_entry' => null,
                'status' => 'P'
            );

            ////////////////////////////////////////
            $penUser='CO';
            $rmrk='Revert back By DC';
            $this->DashboardData($case_no,$penUser,$rmrk);
            $rmk=$rmrk;
            $status='M';
            $task='DC';
            $pen='CO';
            $case=$case_no;
            $API = $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
            ////////////////////////////////////////
        }
        if ($next_hearing == 'D') {
            $update = array(
                'dc_code' => $user_code,
                'dc_entry_date' => date('Y-m-d'),
                'dc_note' => $merge,
                'status' => 'F',
                'next_date_hearing' => (ESCALATION_ENABLE == 1) ? date('Y-m-d H:i:s') : date('Y-m-d'),
            );

            ////////////////////////////////////////
            $this->DashboardDataFinal($case_no);
            $rmk="Rejected";
            $status='R';
            $task='DC';
            $pen='NA';
            $case=$case_no;
            $API = $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
            ////////////////////////////////////////
        }

        $this->db->where('dist_code', $dist_code);
        $this->db->where('case_no', $case_no);
        $this->db->update('allotment_cert_basic', $update);
        if($this->db->affected_rows() == 0){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#ERR1768: Unable to process! Someting went wrong... $case_no");
            redirect(base_url() . 'index.php/home');
        }

        if(trim(strtolower($API)) != 'y'){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#ERR1773: Unable to process! Someting went wrong... $case_no");
            redirect(base_url() . 'index.php/home');
        }

        $getLoc = $this->db->query('select * from allotment_cert_basic where case_no = ?', array($case_no));
        if($getLoc->num_rows() <= 0){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "ERR862: Something went wrong! Unable to process... $case_no");
            redirect(base_url() . 'index.php/home');
        }

        $locRow = $getLoc->row();

        
        $append = "dist_code='$locRow->dist_code' and subdiv_code='$locRow->subdiv_code' and circle_code='$locRow->circle_code' and mouza_pargona_code='$locRow->mouza_pargona_code' and lot_no='$locRow->lot_no' and ". "vill_townprt_code='$locRow->vill_townprt_code'";
        
        $pb = $this->db->query("select * from allotment_cert_basic where case_no='$case_no' and $append")->row();
        //ESCALATION CODE INTEGRATION================SANMRI
        // $executionDate = $this->input->post('executionDate');
        $executionDate = date('Y-m-d H:i:s');
        $user_code = $this->session->userdata('user_code');
        $es_flag = $pb->es_flag;

        if($es_flag == 1 && ESCALATION_ENABLE ==1){

            if ($next_hearing == 'R'){
                $escalationUpdateStatus = $this->Escalationmodel->escalationDCFirstProcedingAllotment($executionDate,$locRow->dist_code,$locRow->subdiv_code,$locRow->circle_code,$locRow->mouza_pargona_code,$locRow->lot_no,$case_no,$user_code);

                log_message("error", "#ESC5803, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

                if($escalationUpdateStatus['responseType'] == 0){
                    $this->db->trans_rollback();
                    log_message('error', '#ESC35803: Updation failed in escalation for case no :'. $case_no);
                    $json = [
                        'errorMessage'=>"#ESC35803: Updation failed on escalation for Case No ".$case_no
                    ];
                    echo json_encode($json);
                    return false;
                }
            }elseif($next_hearing == 'P'){
                //****revert to CO */
                //ESCALATION CODE INTEGRATION================SANMRI
                $getLoc = $this->db->query('select * from allotment_cert_basic where case_no = ?', array($case_no));
                if($getLoc->num_rows() <= 0){
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "ERR862: Something went wrong! Unable to process... $case_no");
                    redirect(base_url() . 'index.php/home');
                }
                $locRow = $getLoc->row();
                $append = "dist_code='$locRow->dist_code' and subdiv_code='$locRow->subdiv_code' and circle_code='$locRow->circle_code' and mouza_pargona_code='$locRow->mouza_pargona_code' and lot_no='$locRow->lot_no' and ". "vill_townprt_code='$locRow->vill_townprt_code'";
                
                $pb = $this->db->query("select * from allotment_cert_basic where case_no='$case_no' and $append")->row();
                if($pb->es_flag == 1 && ESCALATION_ENABLE ==1){
                    $user_code = $this->session->userdata('user_code');
                    // $executionDate = $this->input->post('executionDate');
                    $executionDate = date('Y-m-d H:i:s');
                    $allocation_days = null;

                    // if($this->input->post('allocate_day') !=null){
                    //     $allocation_days = $this->input->post('allocate_day');
                    // }
                    if (isset($_POST['allocate_day'])) {
                        $allocation_days = $this->input->post('allocate_day');
                        if(empty($allocation_days)){
                            $this->session->set_flashdata('message', "#ERR1034: Please select allocated days... $case_no");
                            redirect(base_url() . 'index.php/home');
                        }
                    }

                    $escalationUpdateStatus = $this->Escalationmodel->escalationDCRevertToCoALOT($executionDate,$locRow->dist_code,$locRow->subdiv_code,$locRow->circle_code,$case_no,$user_code,$locRow->mouza_pargona_code,$locRow->lot_no,$allocation_days);

                    log_message("error", "#ESC4152, transaction-error-STATUS======".json_encode($escalationUpdateStatus));
                    if($escalationUpdateStatus['responseType'] == 0){
                        $this->db->trans_rollback();
                        log_message("error", "#ESC4152, transaction-error in method 'LandReclassification/revertToLMReclassByCOEscalation' with case-no :". $case_no);
                        $this->session->set_flashdata('message', "Something went wrong.RECLASS- Error Code(#ESC4152)");
                        redirect(base_url() . "index.php/home");
                    }
                    ///////////////END ESCALATION//////////////
                }
                
            }elseif($next_hearing == 'D'){
                //******reject */
                //ESCALATION CODE INTEGRATION================SANMRI
                $getLoc = $this->db->query('select * from allotment_cert_basic where case_no = ?', array($case_no));
                if($getLoc->num_rows() <= 0){
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "ERR1984862: Something went wrong! Unable to process... $case_no");
                    redirect(base_url() . 'index.php/home');
                }
                $locRow = $getLoc->row();
                $append = "dist_code='$locRow->dist_code' and subdiv_code='$locRow->subdiv_code' and circle_code='$locRow->circle_code' and mouza_pargona_code='$locRow->mouza_pargona_code' and lot_no='$locRow->lot_no' and ". "vill_townprt_code='$locRow->vill_townprt_code'";
                
                $pb = $this->db->query("select * from allotment_cert_basic where case_no='$case_no' and $append")->row();
                if($pb->es_flag == 1 && ESCALATION_ENABLE ==1){
                    $user_code = $this->session->userdata('user_code');
                    // $executionDate = $this->input->post('executionDate');
                    $executionDate = date('Y-m-d H:i:s');

                    $escalationUpdateStatus = $this->Escalationmodel->escalationDCRejectALOT($executionDate,$locRow->dist_code,$locRow->subdiv_code,$locRow->circle_code,$case_no,$user_code,$locRow->mouza_pargona_code,$locRow->lot_no);
                    
                    log_message("error", "#ESC204152, transaction-error-STATUS======".json_encode($escalationUpdateStatus));
                    if($escalationUpdateStatus['responseType'] == 0){
                        $this->db->trans_rollback();
                        log_message("error", "#ESC204152, transaction-error in method 'LandReclassification/revertToLMReclassByCOEscalation' with case-no :". $case_no);
                        $this->session->set_flashdata('message', "Something went wrong.RECLASS- Error Code(#ESC204152)");
                        redirect(base_url() . "index.php/home");
                    }
                    ///////////////END ESCALATION//////////////
                }

            }
            else{
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERR1811: Unable to process! Someting went wrong... $case_no");
                redirect(base_url() . 'index.php/home');
            }
        }


        $this->db->trans_commit();
        $this->session->set_flashdata('message', "Case Successfully Passed with case number $case_no");
        redirect(base_url() . 'index.php/home');
    }

    function withoutBOdcFinalOrder() {
        //$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');

        //************INTEGRATE CIRCLE MAPPING***************
        $circle_bifurcate = ''; 
        if(CIRCLE_BIRFURCATE_ADC == 1 && $this->session->userdata('user_desig_code') == 'ADC')
        {
            $flag = 'ALLOTMENT';
            $circle_bifurcate = $this->circleMappingModel->caseListUnderMappingCircleOfADC($flag);
        }
        //************END************************************

        $data['cases'] = $this->db->query("select *,ba.basundhara from allotment_cert_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree  where es_flag= '1' and status = 'R' and co_code is not null and dist_code='$dist_code' and dc_code is null and settlement_typ is null $circle_bifurcate")->result();
        //$this->load->helper('html');
        //$this->load->view('../views/header');
        //$this->load->view('../views/allotment/dcpendinglist', $data);
        //$this->load->view('../views/footer');

        foreach($data['cases'] as $rows){
            if($rows->es_flag == '1' && ESCALATION_ENABLE ==1){
                $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
                log_message('error', '#55: Escalation ROW : '.json_encode($escRow));                         
                if(!empty($escRow)){                                                                
                    $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));                             
                    log_message('error', '#5531: Escalation details : '.json_encode($escData)); 
                    if(!empty($escData)){                                
                        $rows->escalation_date = $escData->escalation_date;
                        $rows->escalation_zone = $escData->escalation_zone;
                        $rows->assigned_date   = $escData->assigned_date;
                    }else{
                        $rows->escalation_date = 'NA';
                        $rows->escalation_zone = 'NA';
                        $rows->assigned_date   = 'NA';
                    }
                }else{
                    $rows->escalation_date = 'NA';
                    $rows->escalation_zone = 'NA';
                    $rows->assigned_date   = 'NA';
                }                            
            }
            else {
                $rows->escalation_date = 'NA';
                $rows->escalation_zone = 'NA';
            }
        }

        $data['_view'] = 'allotment/dcpendinglist';
        $this->load->view('layouts/main',$data);
    }

    public function getRemDaysEscalation()
    {
        $case_no = $this->input->post('case_no');
        $revert_user = $this->input->post('revert_user');
        $pb = $this->db->query("select * from allotment_cert_basic where case_no=?",array($case_no))->row();
        $flag = false;
        if($pb->es_flag == 1 && ESCALATION_ENABLE == 1 && $revert_user == 'CO'){
            //remaining Days of LM ============
            $escalatedRowDetailsAgainstPetitionno = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($case_no);
            if(empty($escalatedRowDetailsAgainstPetitionno) || $escalatedRowDetailsAgainstPetitionno == null)
            {
                echo json_encode(
                    array('responseType'=> 1
                    ));
            }

            $originalAllocation   = $escalatedRowDetailsAgainstPetitionno->co_target_days;
            $previousCompletedDaysCO = $escalatedRowDetailsAgainstPetitionno->co_completed_days;
            $remaining_days_CO = $this->Escalationmodel->getRemainingDays($previousCompletedDaysCO,$originalAllocation);

            //remaining days of CO==============
            if($this->session->userdata('user_desig_code') == 'DC')
            {
                $originalAllocationDC   = $escalatedRowDetailsAgainstPetitionno->dc_target_days;
                $previousCompletedDaysDC = $escalatedRowDetailsAgainstPetitionno->dc_completed_days;
                $remaining_days_DCADC= $this->Escalationmodel->getRemainingDays($previousCompletedDaysDC,$originalAllocationDC);
            }
            else if($this->session->userdata('user_desig_code') == 'ADC')
            {
                $originalAllocationADC   = $escalatedRowDetailsAgainstPetitionno->adc_target_days;
                $previousCompletedDaysADC = $escalatedRowDetailsAgainstPetitionno->adc_completed_days;
                $remaining_days_DCADC= $this->Escalationmodel->getRemainingDays($previousCompletedDaysADC,$originalAllocationADC);
            }
            
            if($remaining_days_CO == 0){
                $flag = true;
            }else{
                $flag = false;
            }
        }
        echo json_encode(array('responseType'=> 2,'flag' => $flag,'remainingDays' =>$remaining_days_DCADC ));
    }
}

