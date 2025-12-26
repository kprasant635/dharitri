    <?php

    class Settlement extends CI_Controller {

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
                // $this->load->view('../views/settlement/ast_n_one', $district);
                // $this->load->view('../views/footer');

                $district['_view'] = 'settlement/ast_n_one';
                $this->load->view('layouts/main',$district);
            } else {
                $location = array(
                    'mouza_pargona_code' => $this->input->post('mouza_code'),
                    'lot_no' => $this->input->post('lot_no'),
                    'vill_townprt_code' => $this->input->post('vill_code')
                );
                $this->session->set_userdata($location);
                redirect(base_url() . 'index.php/Settlement/addpattadar');
            }
        }
        
        
        
        
        
        
            function indexAP() {
        
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
                $this->load->view('../views/header');
                $this->load->view('../views/settlement/ast_n_oneAp', $district);
                $this->load->view('../views/footer');
            } else {
                $location = array(
                    'mouza_pargona_code' => $this->input->post('mouza_code'),
                    'lot_no' => $this->input->post('lot_no'),
                    'vill_townprt_code' => $this->input->post('vill_code')
                );
                $this->session->set_userdata($location);
                redirect(base_url() . 'index.php/Settlement/addpattadarAp');
            }
        }
        
        
        
            function indexGrant() {
        
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
                // $this->load->view('../views/settlement/ast_n_oneGrant', $district);
                // $this->load->view('../views/footer');

                $district['_view'] = 'settlement/ast_n_oneGrant';
                $this->load->view('layouts/main',$district);
            } else {
                $location = array(
                    'mouza_pargona_code' => $this->input->post('mouza_code'),
                    'lot_no' => $this->input->post('lot_no'),
                    'vill_townprt_code' => $this->input->post('vill_code')
                );
                $this->session->set_userdata($location);
                redirect(base_url() . 'index.php/Settlement/landcertGrant');
            }
        }
        
        
        
        
           function addpattadarAp() {
            $query = "select * from master_guard_rel ";
            $district['relationship'] = $this->db->query($query)->result();
            $sql = "Select * from master_caste";
            $district['caste_name'] = $this->db->query($sql)->result();
            $sql = "Select * from master_gender";
            $district['gender'] = $this->db->query($sql)->result();
            $this->form_validation->set_rules('applicant_name', 'Applicant Name', 'trim|required|min_length[5]|max_length[50]');
            $this->form_validation->set_rules('gurdian_name', 'Guardian Name', 'trim|required|min_length[5]|max_length[50]');
            $this->form_validation->set_rules('caste', 'Caste', 'trim|required');
            $this->form_validation->set_rules('relation', 'Relationship', 'required');
            $this->form_validation->set_rules('age', 'Age', 'trim|required|numeric');
            $this->form_validation->set_rules('mobile_no', 'Mobile Number', 'trim|required|numeric');
            if ($this->form_validation->run() == FALSE) {
                // $this->load->view('../views/header');
                // $this->load->view('../views/settlement/addpattadarAp', $district);
                // $this->load->view('../views/footer');

                $district['_view'] = 'settlement/addpattadarAp';
                $this->load->view('layouts/main',$district);
            } else {
                $applicant_name = $this->input->post('applicant_name');
                $gurdian_name = $this->input->post('gurdian_name');
                $relation = $this->input->post('relation');
                $age = $this->input->post('age');
                $gender = $this->input->post('gender');
                $caste = $this->input->post('caste');
                $applicant_hus_wife = $this->input->post('applicant_hus_wife');
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
                redirect(base_url() . 'index.php/Settlement/addmoreapplicantAp');
                //$this->addmoreapplicant();
            }
        }
        
        
           function addmoreapplicantAp() {
            // $this->load->view('../views/header');
            // $this->load->view('../views/settlement/addmoreapplicantAp');
            // $this->load->view('../views/footer');

            $data['_view'] = 'settlement/addmoreapplicantAp';
            $this->load->view('layouts/main',$data);
        }
        
        
        
        
        
               function addpattadarGrant() {
            $query = "select * from master_guard_rel ";
            $district['relationship'] = $this->db->query($query)->result();
            $sql = "Select * from master_caste";
            $district['caste_name'] = $this->db->query($sql)->result();
            $sql = "Select * from master_gender";
            $district['gender'] = $this->db->query($sql)->result();
            $this->form_validation->set_rules('applicant_name', 'Applicant Name', 'trim|required|min_length[5]|max_length[50]');
            $this->form_validation->set_rules('gurdian_name', 'Guardian Name', 'trim|required|min_length[5]|max_length[50]');
            $this->form_validation->set_rules('caste', 'Caste', 'trim|required');
            $this->form_validation->set_rules('relation', 'Relationship', 'required');
            $this->form_validation->set_rules('age', 'Age', 'trim|required|numeric');
            $this->form_validation->set_rules('mobile_no', 'Mobile Number', 'trim|required|numeric');
            if ($this->form_validation->run() == FALSE) {
                // $this->load->view('../views/header');
                // $this->load->view('../views/settlement/addpattadarGrant', $district);
                // $this->load->view('../views/footer');

                $district['_view'] = 'settlement/addpattadarGrant';
                $this->load->view('layouts/main',$district);
            } else {
                $applicant_name = $this->input->post('applicant_name');
                $gurdian_name = $this->input->post('gurdian_name');
                $relation = $this->input->post('relation');
                $age = $this->input->post('age');
                $gender = $this->input->post('gender');
                $caste = $this->input->post('caste');
                $applicant_hus_wife = $this->input->post('applicant_hus_wife');
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
                redirect(base_url() . 'index.php/Settlement/addmoreapplicantGrant');
                //$this->addmoreapplicant();
            }
        }
        
        
        
        
           function addmoreapplicantGrant() {
            // $this->load->view('../views/header');
            // $this->load->view('../views/settlement/addmoreapplicantGrant');
            // $this->load->view('../views/footer');

            $data['_view'] = 'settlement/addmoreapplicantGrant';
            $this->load->view('layouts/main',$data);
        }
        
        
        
            function landcertGrant() {
            
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_townprt_code');
            
                  $locationData = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'lot_no' => $lot_no,
                    'vill_code' => $vill_townprt_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                  //  'convertion_code' => $convertion_code,
                );
                $this->session->set_userdata($locationData);
                 $district['location'] = $locationData;
            
            $sql = "Select * from allote_scheme_name";
            $district['scheme_name'] = $this->db->query($sql)->result();
            //$sql2 = "Select dag_no from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and patta_no='0'";
            //$district['govt_dag_no'] = $this->db->query($sql2)->result();
            // $district['govt_dag_no'] = $this->PattaModel->getDagsByPattaNoConversion($patta_no, $patta_type, $dist_code, $subdiv_code, $cir_code, $lot_no, $vill_code, $mouza_pargona_code)->result();
             $district['patta_conv_type'] = $this->db->query("SELECT * FROM  patta_code where type_code='0210' or patta_type like '%গ্ৰান্ট%'  OR patta_type like 'নিস্ফি%' or patta_type like '% গ্ৰ্যান্ট%' ")->result();
            // $this->load->view('../views/header');
            // $this->load->view('../views/settlement/landareaGrant', $district);
            // $this->load->view('../views/footer');

            $district['_view'] = 'settlement/landareaGrant';
            $this->load->view('layouts/main',$district);
        }
        
        
        
        
        
                public function getDagsGrant($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $p,$pno) {
           // $this->load->model('conversion/COofficeConversionModel');
           // $daginfo = $this->COofficeConversionModel->getDagforchitha1111($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $p, $patta_no);
            //echo "select dag_no,dag_no_int from chitha_basic where patta_type_code='$p' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$circle_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_code'  and patta_no='$pno' ";
          $daginfo = $this->db->query("select dag_no,dag_no_int from chitha_basic where patta_type_code='$p' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$circle_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_code'  and patta_no='$pno' ")->result();
          
    //echo"select dag_no,dag_no_int from chitha_basic where TRIM(patta_no)=trim('$patta_no') and patta_type_code='$p' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$circle_code' and mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code = '$vill_code' ";
          $json = array();

            foreach ($daginfo as $d) {
                $json[] = array('dag' => $d->dag_no, 'dag_no_int' => $d->dag_no_int);
            }
            echo json_encode($json);
        }
        
        
        
        
        
        
        
        function landcertAP() {
            
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_townprt_code');
            
                  $locationData = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'lot_no' => $lot_no,
                    'vill_code' => $vill_townprt_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                  //  'convertion_code' => $convertion_code,
                );
                $this->session->set_userdata($locationData);
                 $district['location'] = $locationData;
            
            $sql = "Select * from allote_scheme_name";
            $district['scheme_name'] = $this->db->query($sql)->result();
            $sql2 = "Select dag_no from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and patta_no='0'";
            $district['govt_dag_no'] = $this->db->query($sql2)->result();
            // $district['govt_dag_no'] = $this->PattaModel->getDagsByPattaNoConversion($patta_no, $patta_type, $dist_code, $subdiv_code, $cir_code, $lot_no, $vill_code, $mouza_pargona_code)->result();
             $district['patta_conv_type'] = $this->db->query("SELECT * FROM  patta_code where conversion ='y'")->result();
            // $this->load->view('../views/header');
            // $this->load->view('../views/settlement/landareaAp', $district);
            // $this->load->view('../views/footer');

            $district['_view'] = 'settlement/landareaAp';
            $this->load->view('layouts/main',$district);
        }
        
        
        
        
        
            function detailslandareaGrant() {
                
            $dir = UPLOAD_BASE_GRPPDOCS.UPLOAD_SEPARATOR;
                    if (is_dir($dir) === false) {
                        mkdir($dir, 0777, true);
                    }
                    $config['upload_path'] = $dir;
                    $config['allowed_types'] = 'gif|jpg|png|pdf';
                    $config['encrypt_name'] = TRUE;
                    $config['detect_mime'] = TRUE;
                    $config['mod_mime_fix'] = TRUE;
                    $this->load->library('upload', $config);
                    
                    $file_upload1 = $_FILES['file_upload1']['name'];
                    $file_name1 = '';
                    if ($file_upload1 !== "") {
                        $this->upload->do_upload('file_upload1');
                        $upload_data = $this->upload->data();
                        $file_name1 = $upload_data['file_name'];
                    }
                    //var_dump($_POST);
                    /*$file_upload2 = $_FILES['file_upload2']['name'];
                    $file_name2 = '';
                    if ($file_upload2 !== "") {
                        $this->upload->do_upload('file_upload2');
                        $upload_data = $this->upload->data();
                        $file_name2 = $upload_data['file_name'];
                    }
                    
                    $file_upload3 = $_FILES['file_upload3']['name'];
                    $file_name3 = '';
                    if ($file_upload3 !== "") {
                        $this->upload->do_upload('file_upload1');
                        $upload_data = $this->upload->data();
                        $file_name3 = $upload_data['file_name'];
                    }
                    */
            //echo'hello';
            //$this->db->trans_start();
                    $year_no = year_no;
                    $user_code = $this->session->userdata('user_code');
                    $dist_code = $this->session->userdata('dist_code');
                    $subdiv_code = $this->session->userdata('subdiv_code');
                    $cir_code = $this->session->userdata('cir_code');
                    $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
                    $lot_no = $this->session->userdata('lot_no');
                    $vill_townprt_code = $this->session->userdata('vill_townprt_code');
                   // $q = "Select max(petition_no)+1 as p from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and year_no='$year_no' and settlement_typ='gr' ";
                  

                   // $petition_no = $this->db->query($q)->row()->p;
                   //  if ($petition_no == null) {
                   //      $petition_no = $petition_no + 1;
                   //  }
                    // $q = "Select dist_abbr,cir_abbr from location where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code!='00' ";
                    // $abbrname = $this->db->query($q)->row();
                    // $cir_dist_name = $abbrname->dist_abbr . "/" . $abbrname->cir_abbr;
                    // $financialyeardate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('y') : date('Y') . "-" . date('y', strtotime('+1 year'));


                    $case_name=$this->basundharamodel->genearteCaseName();
                    $seq_pet=year_no.'0';
                    $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteAlotPetitionNo();
                    $case_no=$case_name.$petition_no."/GRPP";

                   // $case_no = $cir_dist_name . "/" . $financialyeardate . "/" . $petition_no . "/GRPP";



                    $this->session->set_userdata('case_no', $case_no);
                    

                    $certificate_no = $this->input->post('certificate_no');
                    $cert_date = $this->input->post('cert_date');
                    
                    
                  //  $alot_y_n = $this->input->post('alot_y_n');
                    $alot_whos_name = $this->input->post('alot_whos_name');
                    $type_govt_land = $this->input->post('type_govt_land');
                    $dag_no[] = $this->input->post('dag_noGrant');
                    $dag_no_counted =count($dag_no[0]);
                    $dag_no_counted;
                    
                    //$dag_no = ($dag_no_int%100);
                     
        
                    $this->session->set_userdata('dag_no', $dag_no);
                    
                    
                    $govtcertificate_no = $this->input->post('govtcertificate_no');
                    $govtcert_date = $this->input->post('govtcert_date');
                    
                    $challancertificate_no = $this->input->post('challancertificate_no');
                    $challancert_date = $this->input->post('challancert_date');
                    
                    $fullorpartial = $this->input->post('PartialOrFull');
                    
                    //$dag_no =$this->session->userdata('dag_no');
                    //echo'ggggggggggggg'.$dag_no;
                    //exit();
                    
                    $tot_bigha = $this->input->post('tot_bigha');
                    $tot_katha = $this->input->post('tot_katha');
                    $tot_lessa = $this->input->post('tot_lessa');
                    $alot_bigha = $this->input->post('alot_bigha');
                    
                    $alot_katha = $this->input->post('alot_katha');
                    $alot_lessa = $this->input->post('alot_lessa');
                    
                    $alot_under = $this->input->post('alot_under');
                    $premium = $this->input->post('premium');
                    
                    $patta_typeAp= $this->input->post('patta_type');
                    //echo $patta_typeAp ;
                
                     $this->session->set_userdata('patta_type_old',$patta_typeAp);
                    
                    $patta_noAP = $this->input->post('patta_no');
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
                        'original_alotee' => '',
                        'name_of_allote' => $alot_whos_name,
                        'type_govt_land' => $type_govt_land,
                        'settlement_typ'=>'gr',
                        'name_of_certificate' => $file_name1,
                    //  'rev_certificate'=> $file_name2,
                    //  'premium_certificate'=> $file_name3,
                        'not_fresh'=>'Y',
                        'status' =>'P'
                        // 'certficate_no' => $certificate_no,
                         
                        //'date_of_issue' => $cert_date,
                        //'govtcertificate_no'=>$govtcertificate_no,
                        //'govt_date_of_issue'=>$govtcert_date,
                    );
                  //  VAR_DUMP($allotment_basic);
                    
                    $this->db->insert('allotment_cert_basic', $allotment_basic);//************************
                    
                //echo  $update_doc="update allotment_cert_basic set certficate_no='$certificate_no',date_of_issue= to_date('$cert_date','dd/mm/yyyy') where dist_code ='$dist_code'  and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' ";
                    
                    //$this->db->query($update_doc);
                    
                    $mut_petitioner = $this->session->userdata('mut_petitioner');
                     $q = "select max(alotee_id) from allotment_petitioner where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and year_no='$year_no' ";
                    $allottee_no = $this->db->query($q)->row();
                    $alloteeidcounted =count($allottee_no);
                    //echo $alloteeidcounted;
                    
                    if($alloteeidcounted !='0'){
                        $alotid = $alloteeidcounted + 1;
                        //echo 'i am here'.$alotid;
                    }
                    else{
                        $alotid = 1;
                        //echo 'i am in else';
                    }
             
                /*    foreach ($mut_petitioner as $mp) {
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
                        $this->db->insert('allotment_petitioner', $allotment_petitioner);//************************

                        $alotid = $alotid + 1;
                    }
                    //var_dump($allotment_petitioner); */
                    
                    for($i='0';$i<$dag_no_counted;$i++){
                    $allotment_dag = array(
                        'dist_code' => $dist_code,
                        'subdiv_code' => $subdiv_code,
                        'circle_code' => $cir_code,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'lot_no' => $lot_no,
                        'vill_townprt_code' => $vill_townprt_code,
                        'case_no' => $case_no,
                        'year_no' => year_no,
                        'dag_no' => $dag_no[0][$i],
                        'patta_no'=>$patta_noAP,
                        'patta_type_code'=>$patta_typeAp,
                        'alot_area_b' => $alot_bigha,
                        'alot_area_k' => $alot_katha,
                        'alot_area_lc' => $alot_lessa,
                        'tot_area_b' => $tot_bigha,
                        'tot_area_k' => $tot_katha,
                        'tot_area_lc' => $tot_lessa,
                        'date_entry' => date('Y-m-d'),
                        'premium'=> $premium,
                        
                    );
                    
                    //var_dump($allotment_dag);
                
                    $this->db->insert('allotment_pet_dag', $allotment_dag);//************************
                    
                    
                    }
                        
            
                    $certdate=date('Y-m-d', strtotime($cert_date));
                    $govtdate=date('Y-m-d', strtotime($govtcert_date));
                    $challan_date = date('Y-m-d',strtotime($challancert_date));
                    
                    $allotment = array(
                        'dist_code' => $dist_code,
                        'subdiv_code' => $subdiv_code,
                        'circle_code' => $cir_code,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'lot_no' => $lot_no,
                        'vill_townprt_code' => $vill_townprt_code,
                        'case_no' => $case_no,
                        'year_no' => year_no,
                        'certficate_no' => $certificate_no,
                        'date_of_issue' =>$certdate,
                        'name_of_certificate' => $file_name1,
                        'date_of_entry' => date("Y-m-d"),
                        //'file_name' => '',
                    //  'govtcertificate_no'=>$govtcertificate_no,
                    //  'govt_date_of_issue'=>$govtdate,
                    //  'challandate'=>$challan_date,
                    //  'challancert_no'=>$challancertificate_no,
                        
                        
                        //'name_of_certificate' => $file_name1,
                        //'rev_certificate'=> $file_name2,
                        //'premium_certificate'=> $file_name3,
                        //'file_namerev'=> '',
                        //'file_namepremium'=> '',
                    );
                    
                    
                    //var_dump($allotment);
                    
                    $this->session->set_userdata('doc',$allotment);
                    $this->db->insert('allotment_doc_details', $allotment);
                    
                    
                    redirect(base_url() . 'index.php/Settlement/lmstep_oneGrant');
                     
                     
                     
                   // var_dump($this->db->insert('allotment_doc_details', $allotment_doc_details));//************************ 
                    
                  /*  $this->db->trans_complete();
                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                    } else {
                        $this->db->trans_commit();
                        $this->session->set_flashdata('message', "Case Successfully Passed with case number $case_no");
                        redirect(base_url() . 'index.php/home');
                    } */
                    
                    
                    
        }
        
        
        
        
            function lmstep_oneGrant() {
                 $year_no = year_no;
            $dist_code = $this->session->userdata('dist_code');
             $dist_name = $this->utilityclass->getDistrictName($dist_code);
             $data['dist_name']=$dist_name;
            //echo $dist_code;
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
             
              $lot_no = $this->session->userdata('lot_no');
               
                    $vill_townprt_code = $this->session->userdata('vill_townprt_code');
                     
           $lot_no = $this->session->userdata('lot_no');
            $case_no = $this->session->userdata('case_no');
            
              $data['allotment_certificate123'] = $this->db->query("Select * from allotment_doc_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no' and year_no='$year_no' ")->row();
            
            //echo "Select * from allotment_doc_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no' and year_no='$year_no' ";
            
            
            
              $data['dag_details'] = $this->db->query("Select * from allotment_pet_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and case_no='$case_no' ")->row();

              
              $q = "Select * from allotment_petitioner where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no'";
            //echo"Select * from allotment_petitioner where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no'";
            $data['applicant'] = $this->db->query($q)->row();
              $ptyp = $this->session->userdata('patta_type_old');
            
               $pattasqll = "Select type_code,patta_type from patta_code where type_code='$ptyp' ";
                
            $data['patta_typ'] = $this->db->query($pattasqll)->row();
            
          // echo $case_no;
            $pattasqll = "Select type_code,patta_type from patta_code where type_code='0201' ";
            $data['mutpatta'] = $this->db->query($pattasqll)->result();
                 $q = "Select land_class_code from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' order by dag_no_int";
          // echo "Select land_class_code from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$villcode' order by dag_no_int";

           $landclasscode = $this->db->query($q)->row();
            
            $class_code = $landclasscode->land_class_code;
            
            $landsql = "Select  class_code,land_type from landclass_code where class_code='$class_code' ";
            
            //echo "Select  distinct class_code,land_type from landclass_code where class_code='$class_code' ";
            $data['landsql'] = $this->db->query($landsql)->result();
            
            
             $q = "Select dag_no from allotment_pet_dag where case_no='$case_no'";
            $data['dag_patta'] = $dag = $this->db->query($q)->result();

           

            $pattasql = "Select type_code from patta_code where mutation='a' ";
            $pattasqll = "Select type_code,patta_type from patta_code where type_code='0201' ";
            $data['mutpatta'] = $this->db->query($pattasqll)->result();
            
             $q = "Select land_class_code from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' order by dag_no_int";
          // echo "Select land_class_code from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$villcode' order by dag_no_int";

           $landclasscode = $this->db->query($q)->row();
            
            $class_code = $landclasscode->land_class_code;
            
            $landsql = "Select  class_code,land_type from landclass_code where class_code='$class_code' ";
            
            //echo "Select  distinct class_code,land_type from landclass_code where class_code='$class_code' ";
            $data['landsql'] = $this->db->query($landsql)->result();
            $new_patta=$this->utilityclass->maxpatta($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,'0201');
            // echo $sql = "Select distinct cast(patta_no as varchar) as patta_no from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
                    // . "and vill_townprt_code='$vill_townprt_code' and patta_type_code in ($pattasql) and lot_no='$lot_no' and    patta_no!='' and patta_no!='.' order by patta_no desc  ";
            // $patta_no = $data['oldPatta'] = $this->db->query($sql)->result();
            // $newpatta = 0;
            $newdag = 0;
            // foreach ($patta_no as $p) {
                // $p = $p->patta_no;
                // $p = (int) ($p);
                // if ($newpatta < $p) {
                    // $newpatta = $p;
                // }
            // }
           
            $data['new_patta'] = $new_patta;
           
         
            $this->load->helper('html');
           $this->load->view('../views/header');
            $this->load->view('../views/settlement/lmstep_oneGrant', $data);
            $this->load->view('../views/footer');
            
        }
        
        
        
               function lm_submitGrant() {
            $case_no = $this->input->post('caseno');
            $user_code = $this->session->userdata('user_code');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
              $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_townprt_code');;
            $q = "Select  max(order_slno) as id from allotment_lm_note where case_no='$case_no'";
            $slno = $this->db->query($q)->row()->id;
            if ($slno == 0) {
                $slno = 1;
            } else {
                $slno = $slno + 1;
            }
            
            
           
           // $new_dag = $this->input->post('new_dag');
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
           // $old_rev = $this->input->post('exist_revenue');
            //$old_lc = $this->input->post('exist_local_tax');
            $new_patta_type = $this->input->post('new_patta_type');
            $new_landcode = $this->input->post('new_landcode');
            $username = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code);
            $username =  $username->lm_name;
            $comment = $lm_comment . $username;
            $comment = addslashes($comment);

            //var_dump($comment);
            //exit;

                 $q = "Select dag_no from allotment_pet_dag where case_no='$case_no'";
           $dag = $this->db->query($q)->result();
           
           //var_dump($dag);
         
          $dgcounted = count($dag);
             
            foreach($dag as $dg){
                
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
            
                'new_dag' => $dg->dag_no,
                'new_patta' => $new_patta,
                'l_rev' => $revenue,
                'l_tax' => $local_tax,
                'date_entry' => date('Y-m-d'),
                'user_code' => $user_code,
                'lm_comment' => $comment,
                'order_slno' => $slno,
                'recorded_tenant' => $recorded_tenant,
                'old_rev' => '',
                'old_lc' => '',
                'patta_type_code' => $new_patta_type,
                'ladclass_code' => $new_landcode,
            );
            $this->db->insert('allotment_lm_note', $lmnote);
            }
            $update = array(
                'lm_code' => $user_code,
                'lm_note' => 'Y',
                'lm_entry_date' => date('Y-m-d')
            );
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('circle_code', $cir_code);
            $this->db->where('case_no', $case_no);
            $this->db->update('allotment_cert_basic', $update);
            
            
            $this->session->set_flashdata('message', "Case Successfully Passed with case number $case_no");
            redirect(base_url() . 'index.php/home');

            //print_r($_POST);
        }
        
     
        
        function detailslandareaAp() {
        
            $dir = UPLOAD_BASE_APPPDOCS.UPLOAD_SEPARATOR;
                    if (is_dir($dir) === false) {
                        mkdir($dir, 0777, true);
                    }
                    $config['upload_path'] = $dir;
                    $config['allowed_types'] = 'gif|jpg|png|pdf';
                    $config['encrypt_name'] = TRUE;
                    $config['detect_mime'] = TRUE;
                    $config['mod_mime_fix'] = TRUE;
                    $this->load->library('upload', $config);
                    
                    $file_upload1 = $_FILES['file_upload1']['name'];
                    $file_name1 = '';
                    if ($file_upload1 !== "") {
                        $this->upload->do_upload('file_upload1');
                        $upload_data = $this->upload->data();
                        $file_name1 = $upload_data['file_name'];
                    }
                    
                    $file_upload2 = $_FILES['file_upload2']['name'];
                    $file_name2 = '';
                    if ($file_upload2 !== "") {
                        $this->upload->do_upload('file_upload2');
                        $upload_data = $this->upload->data();
                        $file_name2 = $upload_data['file_name'];
                    }
                    
                    $file_upload3 = $_FILES['file_upload3']['name'];
                    $file_name3 = '';
                    if ($file_upload3 !== "") {
                        $this->upload->do_upload('file_upload1');
                        $upload_data = $this->upload->data();
                        $file_name3 = $upload_data['file_name'];
                    }
            //echo'hello';
            //$this->db->trans_start();
                    $year_no = year_no;
                    $user_code = $this->session->userdata('user_code');
                    $dist_code = $this->session->userdata('dist_code');
                    $subdiv_code = $this->session->userdata('subdiv_code');
                    $cir_code = $this->session->userdata('cir_code');
                    $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
                    $lot_no = $this->session->userdata('lot_no');
                    $vill_townprt_code = $this->session->userdata('vill_townprt_code');
                    // $q = "Select max(petition_no)+1 as p from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and year_no='$year_no' ";
                    // $petition_no = $this->db->query($q)->row()->p;
                    // if ($petition_no == null) {
                    //     $petition_no = $petition_no + 1;
                    // }
                    // $q = "Select dist_abbr,cir_abbr from location where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code!='00' ";
                    // $abbrname = $this->db->query($q)->row();
                    // $cir_dist_name = $abbrname->dist_abbr . "/" . $abbrname->cir_abbr;
                    // $financialyeardate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('y') : date('Y') . "-" . date('y', strtotime('+1 year'));
                    // $case_no = $cir_dist_name . "/" . $financialyeardate . "/" . $petition_no . "/APPP";

                    $case_name=$this->basundharamodel->genearteCaseName();
                    $seq_pet=year_no.'0';
                    $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteAlotPetitionNo();
                    $case_no['case_no']=$case_no=$case_name.$petition_no."/APPP";


                    $certificate_no = $this->input->post('certificate_no');
                    $cert_date = $this->input->post('cert_date');
                    
                    
                  //  $alot_y_n = $this->input->post('alot_y_n');
                    $alot_whos_name = $this->input->post('alot_whos_name');
                    $type_govt_land = $this->input->post('type_govt_land');
                    $dag_no = $this->input->post('dag_noAp');
                    $this->session->set_userdata('dag_no', $dag_no);
                    
                    
                    $govtcertificate_no = $this->input->post('govtcertificate_no');
                    $govtcert_date = $this->input->post('govtcert_date');
                    
                    $challancertificate_no = $this->input->post('challancertificate_no');
                    $challancert_date = $this->input->post('challancert_date');
                    
                    $fullorpartial = $this->input->post('PartialOrFull');
                    
                    //$dag_no =$this->session->userdata('dag_no');
                    //echo'ggggggggggggg'.$dag_no;
                    //exit();
                    
                    $tot_bigha = $this->input->post('tot_bigha');
                    $tot_katha = $this->input->post('tot_katha');
                    $tot_lessa = $this->input->post('tot_lessa');
                    $alot_bigha = $this->input->post('alot_bigha');
                    
                    $alot_katha = $this->input->post('alot_katha');
                    $alot_lessa = $this->input->post('alot_lessa');
                    
                    $alot_under = $this->input->post('alot_under');
                    $premium = $this->input->post('premium');
                    
                    $patta_typeAp= $this->input->post('patta_type');
                    $patta_noAP = $this->input->post('patta_no');
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
                        'original_alotee' => '',
                        'name_of_allote' => $alot_whos_name,
                        'type_govt_land' => $type_govt_land,
                        'settlement_typ'=>'ap',
                        'name_of_certificate' => $file_name1,
                        'rev_certificate'=> $file_name2,
                        'premium_certificate'=> $file_name3,
                        // 'certficate_no' => $certificate_no,
                         
                        //'date_of_issue' => $cert_date,
                        //'govtcertificate_no'=>$govtcertificate_no,
                        //'govt_date_of_issue'=>$govtcert_date,
                    );
                  //  VAR_DUMP($allotment_basic);
                    
                    $this->db->insert('allotment_cert_basic', $allotment_basic);//************************
                    
                //echo  $update_doc="update allotment_cert_basic set certficate_no='$certificate_no',date_of_issue= to_date('$cert_date','dd/mm/yyyy') where dist_code ='$dist_code'  and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' ";
                    
                    //$this->db->query($update_doc);
                    
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
                        $this->db->insert('allotment_petitioner', $allotment_petitioner);//************************

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
                        'patta_no'=>$patta_noAP,
                        'patta_type_code'=>$patta_typeAp,
                        'alot_area_b' => $alot_bigha,
                        'alot_area_k' => $alot_katha,
                        'alot_area_lc' => $alot_lessa,
                        'tot_area_b' => $tot_bigha,
                        'tot_area_k' => $tot_katha,
                        'tot_area_lc' => $tot_lessa,
                        'date_entry' => date('Y-m-d'),
                        'premium'=> $premium,
                        'fullorpartial' => $fullorpartial,
                    );
                    
                    //var_dump($allotment_dag);
                
                    $this->db->insert('allotment_pet_dag', $allotment_dag);//************************
                    
                    $certdate=date('Y-m-d', strtotime($cert_date));
                    $govtdate=date('Y-m-d', strtotime($govtcert_date));
                    $challan_date = date('Y-m-d',strtotime($challancert_date));
                    
                    $allotment = array(
                        'dist_code' => $dist_code,
                        'subdiv_code' => $subdiv_code,
                        'circle_code' => $cir_code,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'lot_no' => $lot_no,
                        'vill_townprt_code' => $vill_townprt_code,
                        'case_no' => $case_no,
                        'year_no' => year_no,
                        'certficate_no' => $certificate_no,
                        'date_of_issue' =>$certdate,
                        //'name_of_certificate' => $file_name1,
                        'date_of_entry' => date("Y/m/d h:i:sa"),
                        //'file_name' => '',
                        'govtcertificate_no'=>$govtcertificate_no,
                        'govt_date_of_issue'=>$govtdate,
                        'challandate'=>$challan_date,
                        'challancert_no'=>$challancertificate_no,
                        
                        
                        //'name_of_certificate' => $file_name1,
                        //'rev_certificate'=> $file_name2,
                        //'premium_certificate'=> $file_name3,
                        //'file_namerev'=> '',
                        //'file_namepremium'=> '',
                    );
                    
                    
                    //var_dump($allotment);
                      $this->db->insert('allotment_doc_details', $allotment);
                    var_dump($this->db->insert('allotment_doc_details', $allotment));//************************ 
                    
                    $this->db->trans_complete();
                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                    } else {
                        $this->db->trans_commit();
                        $this->session->set_flashdata('message', "Case Successfully Passed with case number $case_no");
                        redirect(base_url() . 'index.php/home');
                    }
        }   
        
        
        


        function addpattadar() {
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
                // $this->load->view('../views/header');
                // $this->load->view('../views/settlement/addpattadar', $district);
                // $this->load->view('../views/footer');

                $district['_view'] = 'settlement/addpattadar';
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
                redirect(base_url() . 'index.php/Settlement/addmoreapplicant');
                //$this->addmoreapplicant();
            }
        }
        

        function addmoreapplicant() {
            // $this->load->view('../views/header');
            // $this->load->view('../views/settlement/addmoreapplicant');
            // $this->load->view('../views/footer');

            $data['_view'] = 'settlement/addmoreapplicant';
            $this->load->view('layouts/main',$data);
        }

        function landcert() {
            
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_townprt_code');
            
            $sql = "Select * from allote_scheme_name";
            $district['scheme_name'] = $this->db->query($sql)->result();
            $sql2 = "Select dag_no from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and patta_no='0' order by length(dag_no),dag_no";
            $district['govt_dag_no'] = $this->db->query($sql2)->result();
            
            
            // $this->load->view('../views/header');
            // $this->load->view('../views/settlement/landarea', $district);
            // $this->load->view('../views/footer');

            $district['_view'] = 'settlement/landarea';
            $this->load->view('layouts/main',$district);
        }

         public function getLandAreaSettle($dag_no) {
            
            
            
            
            
            //  VAR_DUMP($this->session->all_userdata());
            $dist_code = $this->session->userdata('dist_code');
            
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $vill_code = $this->session->userdata('vill_townprt_code');
            $lot_no = $this->session->userdata('lot_no');
            $other = $dag_no;
            //echo "Select dag_area_b,dag_area_k,dag_area_lc from chitha_basic where dag_no='$other' and  dist_code ='$dist_code'  and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and lot_no='$lot_no' "; 
            $data=$this->db->query("Select dag_area_b,dag_area_k,dag_area_lc,dag_area_g from chitha_basic where dag_no='$other' and  dist_code ='$dist_code'  and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and lot_no='$lot_no' ")->result();
          

            
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        
        
        
        
        
        
        function detailslandarea() {
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
            $dir = UPLOAD_BASE_STPPDOCS.UPLOAD_SEPARATOR;
                    if (is_dir($dir) === false) {
                        mkdir($dir, 0777, true);
                    }
                    $config['upload_path'] = $dir;
                    $config['allowed_types'] = 'gif|jpg|png|pdf';
                    $config['encrypt_name'] = TRUE;
                    $config['detect_mime'] = TRUE;
                    $config['mod_mime_fix'] = TRUE;
                    $this->load->library('upload', $config);
                    
                    $file_upload1 = $_FILES['file_upload1']['name'];
                    $file_name1 = '';
                    if ($file_upload1 !== "") {
                        $this->upload->do_upload('file_upload1');
                        $upload_data = $this->upload->data();
                        $file_name1 = $upload_data['file_name'];
                    }
                    
                    $file_upload2 = $_FILES['file_upload2']['name'];
                    $file_name2 = '';
                    if ($file_upload2 !== "") {
                        $this->upload->do_upload('file_upload2');
                        $upload_data = $this->upload->data();
                        $file_name2 = $upload_data['file_name'];
                    }
                    
                    $file_upload3 = $_FILES['file_upload3']['name'];
                    $file_name3 = '';
                    if ($file_upload3 !== "") {
                        $this->upload->do_upload('file_upload3');
                        $upload_data = $this->upload->data();
                        $file_name3 = $upload_data['file_name'];
                    }
            //echo'hello';
            $this->db->trans_begin();
                    $year_no = year_no;
                    $user_code = $this->session->userdata('user_code');
                    $dist_code = $this->session->userdata('dist_code');
                    $subdiv_code = $this->session->userdata('subdiv_code');
                    $cir_code = $this->session->userdata('cir_code');
                    $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
                    $lot_no = $this->session->userdata('lot_no');
                    $vill_townprt_code = $this->session->userdata('vill_townprt_code');

                    ///////////////
                    // $q = "Select max(petition_no)+1 as p from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and year_no='$year_no' ";
                    // $petition_no = $this->db->query($q)->row()->p;
                    // if ($petition_no == null) {
                    //     $petition_no = $petition_no + 1;
                    // }
                    // $q = "Select dist_abbr,cir_abbr from location where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code!='00' ";
                    // $abbrname = $this->db->query($q)->row();
                    // $cir_dist_name = $abbrname->dist_abbr . "/" . $abbrname->cir_abbr;
                    // $financialyeardate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('y') : date('Y') . "-" . date('y', strtotime('+1 year'));
                    // $case_no = $cir_dist_name . "/" . $financialyeardate . "/" . $petition_no . "/STPP";

                    ///////////////



                    $case_name=$this->basundharamodel->genearteCaseName();
                    // $case_no['petition_no']=$petition_no=$this->basundharamodel->genearteAlotPetitionNo();
                    // $case_no=$case_name.$petition_no."/STPP";


                    $seq_pet=year_no.'0';
                    $case_no['petition_no']=$petition_no=$seq_pet.$this->rtpsmodel->genearteAlotPetitionNo();
                    $case_no=$case_name.$petition_no."/STPP";

                    $certificate_no = $this->input->post('certificate_no');
                    $cert_date = $this->input->post('cert_date');
                    
                    
                  //  $alot_y_n = $this->input->post('alot_y_n');
                    $alot_whos_name = $this->input->post('alot_whos_name');
                    $type_govt_land = $this->input->post('type_govt_land');
                    $dag_no = $this->input->post('dag_no');
                    $this->session->set_userdata('dag_no', $dag_no);
                    
                    
                    $govtcertificate_no = $this->input->post('govtcertificate_no');
                    $govtcert_date = $this->input->post('govtcert_date');
                    
                    
                    //$dag_no =$this->session->userdata('dag_no');
                    //echo'ggggggggggggg'.$dag_no;
                    //exit();
                    
                    $tot_bigha = $this->input->post('tot_bigha');
                    $tot_katha = $this->input->post('tot_katha');
                    $tot_lessa = $this->input->post('tot_lessa');
                    $alot_bigha = $this->input->post('alot_bigha');
                    $alot_katha = $this->input->post('alot_katha');
                    $alot_lessa = $this->input->post('alot_lessa');
                    $alot_under = $this->input->post('alot_under');
                    $premium = $this->input->post('premium');
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
                        'original_alotee' => '',
                        'name_of_allote' => $alot_whos_name,
                        'type_govt_land' => $type_govt_land,
                        'settlement_typ'=>'s',
                        'name_of_certificate' => $file_name1,
                        'rev_certificate'=> $file_name2,
                        'premium_certificate'=> $file_name3,
                        'status'=>'P'
                        // 'certficate_no' => $certificate_no,
                         
                        //'date_of_issue' => $cert_date,
                        //'govtcertificate_no'=>$govtcertificate_no,
                        //'govt_date_of_issue'=>$govtcert_date,
                    );
                  //  VAR_DUMP($allotment_basic);
                   $tstatus1 = $this->db->insert('allotment_cert_basic', $allotment_basic);//************************
                   if ($tstatus1 != 1 )
                    {
                        $this->db->trans_rollback();
                        log_message("error", "#STPP001, Error in insert on allotment_cert_basic table with query- ". json_encode($this->db->last_query()));
                        $this->session->set_flashdata('message', "Error in saving applicant information.Error Code(#STPP001)");
                        redirect(base_url() . "index.php/home");
                    }
                //echo  $update_doc="update allotment_cert_basic set certficate_no='$certificate_no',date_of_issue= to_date('$cert_date','dd/mm/yyyy') where dist_code ='$dist_code'  and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' ";
                    
                    //$this->db->query($update_doc);
                    
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
                       $tstatus2 = $this->db->insert('allotment_petitioner', $allotment_petitioner);//************************
                       if ($tstatus2 != 1 )
                        {
                            $this->db->trans_rollback();
                            log_message("error", "#STPP002, Error in insert on allotment_petitioner table with query- ". json_encode($this->db->last_query()));
                            $this->session->set_flashdata('message', "Error in saving applicant information.Error Code(#STPP002)");
                            redirect(base_url() . "index.php/home");
                        }

                        $alotid = $alotid + 1;
                    }
                    //var_dump($allotment_petitioner);
                    if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                    {
                        $tot_ganda = $this->input->post('tot_ganda');
                        $alot_ganda = $this->input->post('alot_ganda');

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
                        'alot_area_g' =>$alot_ganda,
                        'tot_area_b' => $tot_bigha,
                        'tot_area_k' => $tot_katha,
                        'tot_area_lc' => $tot_lessa,
                        'tot_area_g' => $tot_ganda,
                        'date_entry' => date('Y-m-d'),
                        'premium'=> $premium,
                    );

                    }
                    else{
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
                        'date_entry' => date('Y-m-d'),
                        'premium'=> $premium,
                    );
                    }

                    $tstatus3 = $this->db->insert('allotment_pet_dag', $allotment_dag);//************************
                    //echo $this->db->last_query();
                    if ($tstatus3 != 1 )
                        {
                            $this->db->trans_rollback();
                            log_message("error", "#STPP003, Error in insert on allotment_pet_dag table with query- ". json_encode($this->db->last_query()));
                            $this->session->set_flashdata('message', "Error in saving applicant information.Error Code(#STPP003)");
                            redirect(base_url() . "index.php/home");
                        }
                                    
                    $certdate=date('Y-m-d', strtotime($cert_date));
                    $govtdate=date('Y-m-d', strtotime($govtcert_date));
                    
                    $allotment = array(
                        'dist_code' => $dist_code,
                        'subdiv_code' => $subdiv_code,
                        'circle_code' => $cir_code,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'lot_no' => $lot_no,
                        'vill_townprt_code' => $vill_townprt_code,
                        'case_no' => $case_no,
                        'year_no' => year_no,
                        'certficate_no' => $certificate_no,
                        'date_of_issue' =>$certdate,
                        'date_of_entry' => date("Y/m/d h:i:sa"),
                        //'file_name' => '',
                        'govtcertificate_no'=>$govtcertificate_no,
                        'govt_date_of_issue'=>$govtdate,
                        'name_of_certificate' => $file_name1
                        //'rev_certificate'=> $file_name2,
                        //'premium_certificate'=> $file_name3,
                        //'file_namerev'=> '',
                        //'file_namepremium'=> '',
                    );
                    
                    $this->session->userdata('cert',$allotment);
                    //var_dump($allotment);
                    $tstatus4 = $this->db->insert('allotment_doc_details', $allotment);

                     if ($tstatus4 != 1 )
                        {
                            $this->db->trans_rollback();
                            log_message("error", "#STPP004, Error in insert on allotment_doc_details table with query- ". json_encode($this->db->last_query()));
                            $this->session->set_flashdata('message', "Error in saving applicant information.Error Code(#STPP004)");
                            redirect(base_url() . "index.php/home");
                        }
                    

                    //$this->db->trans_complete();
                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                    } 
                    else {
                        $this->db->trans_commit();
                        $this->Dashboard($case_no);
                        $this->session->set_flashdata('message', "Case Successfully Passed with case number $case_no");
                        redirect(base_url() . 'index.php/home');
                    }
        }

        
        public function Reject() {
           
           
             $case_no = $this->input->get('case_no');
             $this->db->query("UPDATE allotment_cert_basic SET status = 'R' WHERE case_no = '$case_no'");
            
            $this->session->set_flashdata('message', "# $case_no has been rejected.");
            redirect(base_url() . "index.php/home");
        }
        
        
        
        
        
        
        public function index1() {
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
            $query = "select * from master_guard_rel ";
            $district['relationship'] = $this->db->query($query)->result();
            $sql = "Select * from allote_scheme_name";
            $district['scheme_name'] = $this->db->query($sql)->result();
            $sql = "Select * from master_caste";
            $district['caste_name'] = $this->db->query($sql)->result();
            $sql = "Select * from master_gender";
            $district['gender'] = $this->db->query($sql)->result();
            $checkfile = $_FILES['filename']['name'];
            if ($checkfile !== "") {
                $config['upload_path'] = UPLOAD_BASE_CERTIFICATE.UPLOAD_SEPARATOR;
                // $config['upload_path'] = './Certificate/';                
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
                $this->load->view('../views/settlement/aststep_one', $district);
                $this->load->view('../views/footer');
            } else {
                $this->db->trans_start();
                // print_r($_POST);
                //echo $file_name;
                $year = year_no;
                $user_code = $this->session->userdata('user_code');
                $q = "Select max(petition_no)+1 as p from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and year_no='$year' ";
                $petition_no = $this->db->query($q)->row()->p;
                if ($petition_no == null) {
                    $petition_no = +1;
                }
                //$case_no=;
                $q = "Select dist_abbr,cir_abbr from location where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code!='00' ";
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
            //and patta_type_code='0208'; 
            $pattasql = "Select type_code from patta_code where mutation='n' ";
            $q = "SElect dag_no from chitha_basic where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$m' and lot_no='$l' and vill_townprt_code='$v' and (patta_type_code in ($pattasql )) order by dag_no_int";
            $data = $this->db->query($q)->result();
            $json = array();
            foreach ($data as $object) {
                $json[] = array('dag_no' => $object->dag_no);
            }
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
        }

        function landarea($d, $s, $c, $m, $l, $v, $dag) {
            $q = "SElect dag_area_b as b,dag_area_k as k,dag_area_lc as lc,patta_no as pno,patta_type_code as pcode from chitha_basic where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$m' and lot_no='$l' and vill_townprt_code='$v' and dag_no='$dag' ";
            $data = $this->db->query($q)->row();
            $json[] = array('bigha' => $data->b, 'katha' => $data->k, 'lessa' => $data->lc, 'pno' => $data->pno, 'pcode' => $data->pcode);
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
        }

        function copendingfirstlist() {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $this->load->helper('html');
            $this->load->view('../views/header');
            $data['cases'] = $this->db->query("Select * from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  not_fresh is null and status is null and settlement_typ='s'")->result();
            $this->load->view('../views/settlement/copendinglistfirst', $data);
            $this->load->view('../views/footer');
        }

        function copendingseclist() {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $this->load->helper('html');
            $this->load->view('../views/header');
             $data['cases'] = $this->db->query("Select * from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and lm_note='Y' and sk_note is null and not_fresh='Y' and status='P' and co_note is not null")->result();
            // echo"Select * from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and lm_note='Y' and sk_note is null and not_fresh='Y' and status='P' and co_note is not null";
            
           // $data['cases'] = $this->db->query("Select * from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and status='P' and co_code is not null")->result();
            $this->load->view('../views/settlement/copendinglistsecond', $data);
            $this->load->view('../views/footer');
        }

        public function cofirstproceeding() {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $case_no = $this->input->get('case_no');
            
              $data['allotment_cb'] = $this->db->query("Select * from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no' ")->row();
            $data['allotment_certificate'] = $this->db->query("Select name_of_certificate from allotment_doc_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no' and year_no='$year_no' ")->row();

            $data['cases'] = $this->db->query("Select * from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and case_no='$case_no' and lm_note='Y' and not_fresh='Y' and status='P' and co_note is not null")->row();
            
            //$year_no = year_no;
           // $data['allotment_cb'] = $this->db->query("Select * from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no' and not_fresh is null and status is null")->row();
           // $data['allotment_certificate'] = $this->db->query("Select name_of_certificate from allotment_doc_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no'  ")->row();

            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/settlement/costep_one', $data);
            $this->load->view('../views/footer');
        }

        function savecofirstorder() {
            //print_r($_POST);
            if (($_POST['next_hearing'] == 'P') or ( $_POST['next_hearing'] == 'D')) {
                $dist_code = $this->session->userdata('dist_code');
                $subdiv_code = $this->session->userdata('subdiv_code');
                $cir_code = $this->session->userdata('cir_code');
                $next_date = $this->input->post('next_date');
                $case_no = $this->input->post('case_no');
                $user_code = $this->session->userdata('user_code');
                $status = $this->input->post('next_hearing');
                $name = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $user_code);
                //var_dump($name);
                $co_name = $name->username;
                $proceeding1 = $this->input->post('proceeding1');
                $proceeding2 = $this->input->post('proceeding2');
                $proceeding3 = "???? ????? -----" . $co_name;
                $merge = $proceeding1 . $next_date . $proceeding2 . $proceeding3;

                $q = "Select max(proceeding_id)+1 as p from petition_proceeding_dc_adc where dist_code='$dist_code' and cir_code='$cir_code' and case_no='$case_no' ";
                $count = $this->db->query($q)->row()->p;
                if ($count == 0) {
                    $count = $count + 1;
                }
                //echo $count;
                //echo $this->input->post('next_date');
                $update = array(
                    'next_date_hearing' => date('Y-m-d', strtotime($this->input->post('next_date'))),
                    'not_fresh' => 'Y',
                    'status' => $status,
                    'proceeding_yn' => 1,
                    'co_code' => $user_code,
                    'co_entry_date' => date('Y-m-d'),
                    'co_note' => 'Y'
                );
                if ($status == 'D') {
                    $status = 'Finish';
                } else {
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
                $this->session->set_flashdata('message', "Case Successfully Passed with case number $case_no");
                redirect(base_url() . 'index.php/home');
            }
        }

        function cosecondproceeding() {
            $case_no = $this->input->get('case_no');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $q = "Select * from allotment_cert_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code'";
            $data['allotment_cb'] = $this->db->query($q)->row();
            $q = "Select * from allotment_petitioner where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code'";
            $data['applicant'] = $this->db->query($q)->result();
            $q = "Select * from allotment_pet_dag where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code'";
            $data['lmreport'] = $this->db->query($q)->row();
            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/settlement/co_secondproceeding', $data);
            $this->load->view('../views/footer');
        }

        function savecoscondorder() {
            $case_no = $this->input->post('case_no');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $user_code = $this->session->userdata('user_code');
            $comment = addslashes($this->input->post('co_comment'));
            $next_date = date('Y-m-d', strtotime($this->input->post('next_date')));
            $next_status = $this->input->post('next_hearing');
            $name = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $user_code);
            $co_name = $name->username;
            $co_name = "???? ????? -----" . $co_name;
            $comment = $comment . $co_name;
            //exit;

            if ($next_status == 'L') {
                $update = array(
                    'lm_code' => null,
                    'lm_note' => null,
                    'lm_entry_date' => null,
                    'next_date_hearing' => $next_date
                );
            } elseif ($next_status == 'D') {
                $update = array(
                    'status' => 'D',
                    'next_date_hearing' => $next_date
                );
            } elseif ($next_status == 'P') {
                $update = array(
                    'next_date_hearing' => $next_date,
                    'status' => 'R',
                    'co_entry_date' => date('Y-m-d'),
                    'co_note' => 'Y',
                    'dc_code' => null
                );
            }
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('circle_code', $cir_code);
            $this->db->where('case_no', $case_no);
            $this->db->update('allotment_cert_basic', $update);


            ////////////////
            $q = "Select max(proceeding_id)+1 as p from petition_proceeding_dc_adc where dist_code='$dist_code' and cir_code='$cir_code' and case_no='$case_no' ";
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
            $this->db->insert('petition_proceeding_dc_adc', $insert);
            $this->session->set_flashdata('message', "Case Successfully Passed with case number $case_no");
            redirect(base_url() . 'index.php/home');
        }

        function lmpending() {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');

            // $this->load->helper('html');
            // $this->load->view('../views/header');

            $data['cases'] = $this->db->query("Select * from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code'  and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no'  and lm_note is null and  not_fresh is null and (status is null or status='P') and settlement_typ='s' and chitha_correct_yn is null")->result();

              // $data['cases'] = $this->db->query("Select * from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code'  and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no'  and lm_note is null and  not_fresh='Y'  and status='P' and co_note is not null and settlement_typ='s' and chitha_correct_yn is null")->result();
            
          //  $data['cases'] = $this->db->query("Select * from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and lm_note is null and not_fresh='Y' and status='P' and co_note is not null")->result();
            // $this->load->view('../views/settlement/lmpendinglist', $data);
            // $this->load->view('../views/footer');

            $data['_view'] = 'settlement/lmpendinglist';
            $this->load->view('layouts/main',$data);
        }
        
        
        
          function lmpendingAp() {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');

            $this->load->helper('html');
            $this->load->view('../views/header');
              $data['cases'] = $this->db->query("Select * from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code'  and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no'  and  not_fresh is null and status is null and settlement_typ='ap' and chitha_correct_yn is null")->result();
            
          //  $data['cases'] = $this->db->query("Select * from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and lm_note is null and not_fresh='Y' and status='P' and co_note is not null")->result();
            $this->load->view('../views/settlement/lmpendinglistAp', $data);
            $this->load->view('../views/footer');
        }
        
        
        

        function lmstep_one() {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $case_no = $this->input->get('case_no');
            //$year_no = year_no;
            $sql = "Select * from allote_scheme_name";
            $data['allotment_cb'] = $cb = $this->db->query("Select * from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no' ")->row();
            $data['allotment_certificate'] = $this->db->query("Select name_of_certificate,rev_certificate,premium_certificate  from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no' ")->row();
            
            // $data['allotment_certificate'] = $this->db->query("Select name_of_certificate,rev_certificate,premium_certificate from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no' and year_no='$year_no' ")->row();
            
            
            $data['allotment_certificate123'] = $this->db->query("Select * from allotment_doc_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no'  ")->row();
            
            
            //echo"Select * from allotment_doc_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no' and year_no='$year_no' ";
            
            
            //echo "Select * from allotment_doc_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no' and year_no='$year_no' ";

            $q = "Select * from allotment_petitioner where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no'";
            //echo"Select * from allotment_petitioner where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no'";
            $data['applicant'] = $this->db->query($q)->row();
            
            //******bondita**************//
            
            //var_dump($data['allotment_cb']);

            $data['scheme_name'] = $this->db->query($sql)->result();
            $data['mouzaname'] = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
            $data['villname'] = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $cb->vill_townprt_code);
            
            $villcode =$cb->vill_townprt_code;
        //  echo $villcode;
            
            $data['cases'] = $cb = $this->db->query("Select * from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and lm_note is null and case_no='$case_no' ")->row();

            $q = "Select dag_no,patta_no,dag_no_int as new_dag from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$villcode' order by dag_no_int";
            $data['dag_patta'] = $dag = $this->db->query($q)->result();

            $data['dag_details'] = $this->db->query("Select * from allotment_pet_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and case_no='$case_no' ")->row();

            $data['certificate'] = $this->db->query("Select * from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and  case_no='$case_no' ")->row();

            $pattasql = "Select type_code from patta_code where mutation='a' ";
            //$pattasqll = "Select type_code,patta_type from patta_code where type_code='0201' ";
            $pattasqll = "Select type_code,patta_type from patta_code where mutation='a' ";
            $data['mutpatta'] = $this->db->query($pattasqll)->result();
            
             $q = "Select land_class_code from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$villcode' order by dag_no_int";
          // echo "Select land_class_code from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$villcode' order by dag_no_int";

           $landclasscode = $this->db->query($q)->row();
            
            $class_code = $landclasscode->land_class_code;
            
            $landsql = "Select  class_code,land_type from landclass_code";
            
            //echo "Select  distinct class_code,land_type from landclass_code where class_code='$class_code' ";
            $data['landsql'] = $this->db->query($landsql)->result();
            $pattasqll = "Select type_code,patta_type from    patta_code where mutation='a' ";
            $data['mutpatta'] = $this->db->query($pattasqll)->result();
            $landsql = "Select class_code,land_type from    landclass_code  ";
            $data['landsql'] = $this->db->query($landsql)->result();
            $sql = "Select distinct cast(patta_no as varchar) as patta_no from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
                    . "and vill_townprt_code='$cb->vill_townprt_code' and patta_type_code in ($pattasql) and lot_no='$lot_no' and   patta_no!='' and patta_no!='.' order by patta_no desc  ";
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

            $data['_view'] = 'settlement/lmstep_one';
            $this->load->view('layouts/main',$data);
        }

        
        
        
        function lmstep_oneAp() {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $case_no = $this->input->get('case_no');
            $year_no = year_no;
            $sql = "Select * from allote_scheme_name";
            $data['allotment_cb'] = $cb = $this->db->query("Select * from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no' ")->row();
            $data['allotment_certificate'] = $this->db->query("Select name_of_certificate from allotment_doc_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no'  ")->row();
            $data['allotment_certificate123'] = $this->db->query("Select * from allotment_doc_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no'  ")->row();
            
            //echo "Select * from allotment_doc_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no'  ";

            $q = "Select * from allotment_petitioner where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no'";
            //echo"Select * from allotment_petitioner where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no'";
            $data['applicant'] = $this->db->query($q)->row();
            
            //******bondita**************//
            
            //var_dump($data['allotment_cb']);

            $data['scheme_name'] = $this->db->query($sql)->result();
            $data['mouzaname'] = $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code);
            $data['villname'] = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $cb->vill_townprt_code);
            
            $villcode =$cb->vill_townprt_code;
        //  echo $villcode;
            
            $data['cases'] = $cb = $this->db->query("Select * from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and lm_note is null and case_no='$case_no' ")->row();

           $q = "Select dag_no,patta_no,dag_no_int as new_dag from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$villcode' order by dag_no_int";
            $data['dag_patta'] = $dag = $this->db->query($q)->result();

            $data['dag_details'] = $this->db->query("Select * from allotment_pet_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and case_no='$case_no' ")->row();

            $data['certificate'] = $this->db->query("Select * from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and  case_no='$case_no' ")->row();

            $pattasql = "Select type_code from patta_code where mutation='a' ";
            $pattasqll = "Select type_code,patta_type from patta_code where type_code='0201' ";
            $data['mutpatta'] = $this->db->query($pattasqll)->result();
            
             $q = "Select land_class_code from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$villcode' order by dag_no_int";
          // echo "Select land_class_code from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$villcode' order by dag_no_int";

           $landclasscode = $this->db->query($q)->row();
            
            $class_code = $landclasscode->land_class_code;
            
            $landsql = "Select  class_code,land_type from landclass_code where class_code='$class_code' ";
            
            //echo "Select  distinct class_code,land_type from landclass_code where class_code='$class_code' ";
            $data['landsql'] = $this->db->query($landsql)->result();
            $sql = "Select distinct cast(patta_no as varchar) as patta_no from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
                    . "and vill_townprt_code='$villcode' and patta_type_code in ($pattasql) and lot_no='$lot_no' and    patta_no!='' and patta_no!='.' order by patta_no desc  ";
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
            
            $sqlFullpart="select * from allotment_pet_dag where case_no='$case_no' ";
            $fullpart =$this->db->query($sqlFullpart)->row();
            if($fullpart->fullorpartial =='Y'){
                 $data['new_dag'] = ($fullpart->dag_no)/100;
                $data['new_patta'] = $newpatta + 1;
            }
            
            else{
            $data['new_dag'] = $newdag + 1;
            $data['new_patta'] = $newpatta + 1;
            }
            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/settlement/lmstep_oneAp', $data);
            $this->load->view('../views/footer');
        }

        
        
        
        
        
        
        
        
        
        
        
        
           function lm_submitAp() {
            $case_no = $this->input->post('case_no');
            $user_code = $this->session->userdata('user_code');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->input->post('vill_code');
            $q = "Select  max(order_slno) as id from allotment_lm_note where case_no='$case_no'";
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
           // $old_rev = $this->input->post('exist_revenue');
            //$old_lc = $this->input->post('exist_local_tax');
            $new_patta_type = $this->input->post('new_patta_type');
            $new_landcode = $this->input->post('new_landcode');
            $username = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code);
            $username =  $username->lm_name;
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
                'old_rev' => '',
                'old_lc' => '',
                'patta_type_code' => $new_patta_type,
                'ladclass_code' => $new_landcode,
            );
            $this->db->insert('allotment_lm_note', $lmnote);
            $update = array(
                'lm_code' => $user_code,
                'lm_note' => 'Y',
                'lm_entry_date' => date('Y-m-d')
            );
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('circle_code', $cir_code);
            $this->db->where('case_no', $case_no);
            $this->db->update('allotment_cert_basic', $update);
            $this->session->set_flashdata('message', "Case Successfully Passed with case number $case_no");
            redirect(base_url() . 'index.php/home');

            //print_r($_POST);
        }
        
        
        
        
        
        
        
        
        
        
        
        
        
        function lm_submit() {
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
            $case_no = $this->input->post('case_no');
            $user_code = $this->session->userdata('user_code');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->input->post('vill_code');
            $q = "Select  max(order_slno) as id from allotment_lm_note where case_no='$case_no'";
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
           // $old_rev = $this->input->post('exist_revenue');
            //$old_lc = $this->input->post('exist_local_tax');
            $new_patta_type = $this->input->post('new_patta_type');
            $new_landcode = $this->input->post('new_landcode');
            $username = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code);
            $username =  $username->lm_name;
            $comment = $lm_comment . $username;
            $comment = addslashes($comment);

            //var_dump($comment);
            //exit;
            if(in_array($dist_code, json_decode(BARAK_VALLEY))){
            $tot_ganda = $this->input->post('tot_ganda');
            $p_ganda = $this->input->post('p_ganda');

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
                'old_rev' => '',
                'old_lc' => '',
                'patta_type_code' => $new_patta_type,
                'ladclass_code' => $new_landcode,
            );
            }

            else{

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
                'old_rev' => '',
                'old_lc' => '',
                'patta_type_code' => $new_patta_type,
                'ladclass_code' => $new_landcode,
            );
            }


            $this->db->insert('allotment_lm_note', $lmnote);
            // echo $this->db->last_query();
            // exit;
            $update = array(
                'lm_code' => $user_code,
                'lm_note' => 'Y',
                'lm_entry_date' => date('Y-m-d')
            );
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('circle_code', $cir_code);
            $this->db->where('case_no', $case_no);
            $this->db->update('allotment_cert_basic', $update);

            //////////
                $penUser='CO';
                $rmrk='Report by LM';
                $this->DashboardData($case_no,$penUser,$rmrk);

                ///////
            $this->session->set_flashdata('message', "Case Successfully Passed with case number $case_no");
            redirect(base_url() . 'index.php/home');

            //print_r($_POST);
        }

        function skfirst() {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');

            $data['cases'] = $this->db->query("Select * from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and lm_note='Y' and sk_note is null  and status='P' and settlement_typ='s' and chitha_correct_yn is null")->result();
            //echo $this->db->last_query();
            //$this->load->helper('html');
            // $this->load->view('../views/header');
            // $this->load->view('../views/settlement/skpendinglist', $data);
            // $this->load->view('../views/footer');
            $data['_view'] = 'settlement/skpendinglist';
            $this->load->view('layouts/main',$data);
        }

        function skstep_two() {
            $case_no = $this->input->get('case_no');
            //echo $case_no;
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $year_no = year_no;
            $data['allotment_cb'] = $this->db->query("Select * from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no' ")->row();
            $data['allotment_certificate'] = $this->db->query("Select name_of_certificate from allotment_doc_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no'  ")->row();

            $data['cases'] = $this->db->query("Select * from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and case_no='$case_no' and lm_note='Y'  and status='P' ")->row();
        //  echo "Select * from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and case_no='$case_no' and lm_note='Y' and not_fresh='Y' and status='P'";

          // $this->load->helper('html');
       //      $this->load->view('../views/header');
       //      $this->load->view('../views/settlement/skstep_one', $data);
       //      $this->load->view('../views/footer');
            $data['_view'] = 'settlement/skstep_one';
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
            $case_no = $this->input->post('case_no');
            
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $sk_comment = addslashes($this->input->post('sk_comment'));
            $user_code = $this->session->userdata('user_code');
            $skname = $this->utilityclass->getSKByCode($dist_code, $subdiv_code, $cir_code, $user_code);
            $name = $skname->username;
            $sk_comment = $sk_comment . " কাননগোহ -----" . $name;
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
            redirect(base_url() . 'index.php/home');
        }

        function passtobo() {
            $dist_code = $this->session->userdata('dist_code');
            $data['cases'] = $this->db->query("select * from allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and bo_note is null and dc_code is null and settlement_typ='s'")->result();
            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/settlement/dcpendinglist', $data);
            $this->load->view('../views/footer');
        }

        function dcstepone() {
            $dist_code = $this->session->userdata('dist_code');
            $case_no = $this->input->get('case_no');
            $data['allotment_cb'] = $alcb = $this->db->query("select * from allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and case_no='$case_no' and bo_note is null and dc_code is null ")->row();
            $subdiv_code = $alcb->subdiv_code;
            $circle_code = $alcb->circle_code;
            $data['circlename'] = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $circle_code);
            // echo "select * from allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and case_no='$case_no' and bo_note is null and dc_note is null";
            //var_dump($data);
            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/settlement/dc_firstorder', $data);
            $this->load->view('../views/footer');
        }

        function savedcorder() {
            // print_r($_POST);
            $user_code = $this->session->userdata('user_code');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $case_no = $this->input->post('case_no');
            $comment = $this->input->post('dc_comment');
            $name = $this->utilityclass->dcname($dist_code, $user_code);
            $name = " ????????  ---" . $name;
            $merge = $comment . $name;
            $next_hearing = $this->input->post('next_hearing');

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
            $this->db->insert('petition_proceeding_dc_adc', $insert);
            if ($next_hearing == 'R') {
                $update = array(
                    'dc_code' => $user_code,
                    'dc_entry_date' => date('Y-m-d'),
                    'dc_note' => $merge
                );
            }
            if ($next_hearing == 'P') {
                $update = array(
                    'dc_code' => $user_code,
                    'dc_entry_date' => date('Y-m-d'),
                    'dc_note' => $merge,
                    'co_note' => null,
                    'co_entry_date' => null,
                    'status' => 'P'
                );
            }
            if ($next_hearing == 'D') {
                $update = array(
                    'dc_code' => $user_code,
                    'dc_entry_date' => date('Y-m-d'),
                    'dc_note' => $merge,
                    'status' => 'F',
                    'next_date_hearing' => date('Y-m-d')
                );
            }
            //var_dump($update);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('case_no', $case_no);
            $this->db->update('allotment_cert_basic', $update);
            $this->session->set_flashdata('message', "Case Successfully Passed with case number $case_no");
            redirect(base_url() . 'index.php/home');
        }

        function pendingfinalorder() {
            $dist_code = $this->session->userdata('dist_code');
            $q = "select  * from allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and bo_note is not null and dc_note is not null";
            $data['cases'] = $this->db->query($q)->result();
            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/settlement/finalpendinglist', $data);
            $this->load->view('../views/footer');
        }

        function dcfinalorder() {
            $case_no = $this->input->get('case_no');
            $dist_code = $this->session->userdata('dist_code');
            $q = "select  * from allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and case_no='$case_no' and bo_code is not null and dc_code is not null";
            $data['allotment_cb'] = $acb = $this->db->query($q)->row();
            $q = "SElect new_dag,new_patta,area_posession_b as b,area_posession_k as k,area_posession_lc as lc from allotment_lm_note where case_no='$case_no'";
            $data['allotment_d_p'] = $this->db->query($q)->row();
            $q = "SElect dag_no as d from allotment_pet_dag where case_no='$case_no'";
            $data['old_dag'] = $this->db->query($q)->row();
            $data['mouza'] = $this->utilityclass->getMouzaName($dist_code, $acb->subdiv_code, $acb->circle_code, $acb->mouza_pargona_code);
            $data['vill'] = $this->utilityclass->getVillageName($dist_code, $acb->subdiv_code, $acb->circle_code, $acb->mouza_pargona_code, $acb->lot_no, $acb->vill_townprt_code);
            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/settlement/dc_finalorder', $data);
            $this->load->view('../views/footer');
        }

        function savefinalorder() {
            //print_r($_POST);
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $user_code = $this->session->userdata('user_code');
            $case_no = $this->input->post('case_no');
            $comment = addslashes($this->input->post('dc_comment'));
            $status = $this->input->post('next_hearing');
            $next_date_hear = $this->input->post('next_date');
            $name = $this->utilityclass->dcname($dist_code, $user_code);
            $name =  $name;
            $merge = $comment . $name;
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
            $this->db->insert('petition_proceeding_dc_adc', $insert);
            if ($status == 'R') {
                $update = array(
                    'dc_code' => $user_code,
                    'dc_entry_date' => date('Y-m-d'),
                    'dc_note' => $merge,
                    'bo_note' => null
                );
            }
            if ($status == 'D') {
                $update = array(
                    'dc_code' => $user_code,
                    'dc_entry_date' => date('Y-m-d'),
                    'dc_note' => $merge,
                    'status' => 'D'
                );
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
            }
            //$test=$this->chithaupdate($dist_code,$subdiv_code,$cir_code,$case_no);
            //if($test==true){
            $this->db->where('dist_code', $dist_code);
            $this->db->where('case_no', $case_no);
            $this->db->update('allotment_cert_basic', $update);
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
        function chithaupdate($d, $s, $c, $case,$mouza,$lot_no,$vill) {
            $this->db->trans_begin();
            $q = "Select * from allotment_pet_dag where case_no='$case' and dist_code='$d' and "
                                . "subdiv_code='$s' and circle_code='$c' and lot_no='$lot_no' and mouza_pargona_code='$mouza' and "
                                . "vill_townprt_code='$vill' ";
                            
                                
                                
            $dag_no = $this->db->query($q)->row()->dag_no;
            $query_rmk_hist = "select max(rmk_type_hist_no) as c from chitha_rmk_gen where "
                        . "dist_code='$d' and subdiv_code='$s' and cir_code='$c'"
                        . " and lot_no='$lot_no' and mouza_pargona_code='$mouza' and "
                        . " vill_townprt_code='$vill' and dag_no='$dag_no' ";
                
            $rmk_hist_no_old = $this->db->query($query_rmk_hist)->row()->c;
            if ($rmk_hist_no_old == null) {
                $rmk_hist_no_old = 1;
            } else
                $rmk_hist_no_old += 1;
            $q = "select max(ord_cron_no) as c1,max(rmk_type_hist_no) as c2 from chitha_rmk_ordbasic where "
                        . "dist_code='$d' and subdiv_code='$s' and cir_code='$c'"
                        . " and lot_no='$lot_no' and mouza_pargona_code='$mouza' and "
                        . " vill_townprt_code='$vill' and dag_no='$dag_no' ";
            $ord_cron_no_old = $this->db->query($q)->row()->c1;
            if ($ord_cron_no_old == null) {
                $ord_cron_no_old = 1;
            } else {
                $ord_cron_no_old +=1;
            }       
             $rmk_type_hist_no_old = $this->db->query($q)->row()->c2;
            if ($rmk_type_hist_no_old == null) {
                $rmk_type_hist_no_old = 1;
            } else {
                $rmk_type_hist_no_old +=1;
            }
            $user_code = $this->session->userdata('user_code');
            $q = "SElect * from allotment_lm_note where case_no='$case' and dist_code='$d' and subdiv_code='$s' and circle_code='$c' and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill'";
            $basic = $this->db->query($q)->row();
            //var_dump($basic);
            ///////////// BARAK VALLEY CODE START HERE ////////////////
            $barak = in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY));
            if($barak){
                if($basic->area_posession_g==null){
                    $basic->area_posession_g=0;
                }            
            }

            $q = "SElect * from allotment_cert_basic where case_no='$case' and dist_code='$d' and subdiv_code='$s' and circle_code='$c' and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill'";
            $alb = $this->db->query($q)->row();
            //var_dump($this->session->all_userdata());
            $rmk_type_hist_no = 1;
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
                'rmk_type_code' => '11',
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
                'co_code' => $user_code,
                'co_sign_yn' => 'Y',
                'co_ord_date' => $alb->co_entry_date,
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'm_dag_area_b' => $basic->area_posession_b,
                'm_dag_area_k' => $basic->area_posession_k,
                'm_dag_area_lc' => $basic->area_posession_lc,
                'm_dag_area_g' => $basic->area_posession_g,
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
                'co_code' => $user_code,
                'co_sign_yn' => 'Y',
                'co_ord_date' => $alb->co_entry_date,
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'm_dag_area_b' => $basic->area_posession_b,
                'm_dag_area_k' => $basic->area_posession_k,
                'm_dag_area_lc' => $basic->area_posession_lc,
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
        if($barak)
            {
                $cb = array(
                    'dag_no_int' => $basic->new_dag . '00',
                    'patta_type_code' => $basic->patta_type_code,
                    'patta_no' => $basic->new_patta,
                    'land_class_code' => $basic->ladclass_code,
                    'dag_area_b' => $basic->area_posession_b,
                    'dag_area_k' => $basic->area_posession_k,
                    'dag_area_lc' => $basic->area_posession_lc,
                    'dag_area_g' => $basic->area_posession_g,
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
            else{
            $cb = array(
                'dag_no_int' => $basic->new_dag . '00',
                'patta_type_code' => $basic->patta_type_code,
                'patta_no' => $basic->new_patta,
                'land_class_code' => $basic->ladclass_code,
                'dag_area_b' => $basic->area_posession_b,
                'dag_area_k' => $basic->area_posession_k,
                'dag_area_lc' => $basic->area_posession_lc,
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
            // $this->db->insert('chitha_basic', $chitha_basic);
            $this->Chitha_basic_model->insert_table('chitha_basic',$chitha_basic);
            $q = "Select * from allotment_pet_dag where case_no='$case' and dist_code='$d' and "
                                . "subdiv_code='$s' and circle_code='$c' and lot_no='$lot_no' and mouza_pargona_code='$mouza' and "
                                . "vill_townprt_code='$vill' "; 
            $dag_no = $this->db->query($q)->row()->dag_no;
            $landArea_query = "select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,dag_revenue,dag_local_tax from chitha_basic where dist_code='$d' and "
                                . "subdiv_code='$s' and cir_code='$c' and lot_no='$lot_no' and mouza_pargona_code='$mouza' and "
                                . "vill_townprt_code='$vill' and dag_no='$dag_no' ";

            $sourceB = $this->db->query($landArea_query)->row()->dag_area_b;
            $sourceK = $this->db->query($landArea_query)->row()->dag_area_k;
            $sourceL = $this->db->query($landArea_query)->row()->dag_area_lc;
            $sourceRev = $this->db->query($landArea_query)->row()->dag_revenue;
            $sourceLTax = $this->db->query($landArea_query)->row()->dag_local_tax;
            if($barak)
            {
                $sourceG = $this->db->query($landArea_query)->row()->dag_area_g;
                $sourceLessa = $sourceB * 6400 + $sourceK * 320 + $sourceL * 20 + $sourceG;
                $targetLessa = $basic->area_posession_b * 6400 + $basic->area_posession_k * 320 + $basic->area_posession_lc * 20 + $basic->area_posession_g ;
                $remLessa = $sourceLessa - $targetLessa;
                $new_revenue = ($sourceRev / $sourceLessa) * $remLessa;
                $new_local_tax = ($new_revenue / 4);

                $b = floor($remLessa / 6400.0);
                $k = ($remLessa - $b * 6400.0) / 320.0; //0
                $k = floor($k);
                $lc = ($remLessa - $b * 6400.0 - $k * 320.0)/20;
                $lc= floor($lc);
                $g = ($remLessa - $b * 6400.0 - $k * 320.0 - $lc * 20);
                $kr = 0.0;

            }
            else{
                $sourceLessa = $sourceB * 100 + $sourceK * 20 + $sourceL;
                $targetLessa = $basic->area_posession_b * 100 + $basic->area_posession_k * 20 + $basic->area_posession_lc;
                $remLessa = $sourceLessa - $targetLessa;
                $new_revenue = ($sourceRev / $sourceLessa) * $remLessa;
                $new_local_tax = ($new_revenue / 4);
                $b = floor($remLessa / 100.0);
                $k = ($remLessa - $b * 100.0) / 20.0; //0
                $k = floor($k);
                $lc = ($remLessa - $b * 100.0 - $k * 20.0);
                $g = 0.0;
                $kr = 0.0;
            }           
            $dag_no_int = $dag_no . "00";
            // $chitha_update = "update chitha_basic set dag_area_b='$b',dag_area_k='$k', dag_area_lc='$lc',dag_area_g='$g',jama_yn='n' where dist_code='$d' and  subdiv_code='$s' and cir_code='$c' and lot_no='$lot_no' and mouza_pargona_code='$mouza' and  vill_townprt_code='$vill' and dag_no='$dag_no' ";

            $table = 'chitha_basic';
            $params = [
                'dag_area_b' => $b,
                'dag_area_k' => $k,
                'dag_area_lc' => $lc,
                'dag_area_g' => $g,
                'jama_yn' => 'n',
            ];
            $where = [
                'dist_code'          => $d,
                'subdiv_code'        => $s,
                'cir_code'           => $c,
                'lot_no'             => $lot_no,
                'mouza_pargona_code' => $mouza,
                'vill_townprt_code'  => $vill,
                'dag_no'             => $dag_no,
            ];
            $result = $this->Chitha_basic_model->update_table($table, $params, $where);

            
            // $this->db->query($chitha_update);
            $co_comment="Select lm_comment from allotment_lm_note where case_no='$case' and dist_code='$d' and "
                . "subdiv_code='$s' and circle_code='$c' and lot_no='$lot_no' and mouza_pargona_code='$mouza' and "
                . "vill_townprt_code='$vill'";          
            $co_comment = $this->db->query($co_comment)->row(); 
            if($barak)
            {
                $ganda=$basic->area_posession_g==null?"0":$basic->area_posession_g;
            }
            else{
                $ganda=0;
            }
            
            //old chitha update ends
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
            $pattdaridCheck=true;
            foreach ($allotp as $alp) {
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
                    'allottee_land_b' => $basic->area_posession_b,
                    'allottee_land_k' => $basic->area_posession_k,
                    'allottee_land_lc' => $basic->area_posession_lc,
                    'allottee_land_g' => $ganda,
                    'allottee_land_kr' => 0,
                    'land_revenue' => $basic->l_rev,
                    'land_local_tax' => $basic->l_tax,
                    'user_code' => $user_code,
                    'date_entry' => date('Y-m-d'),
                    'operation' => 'E',
                    //'allotment_no'=>,
                    'allottee_gender' => $alp->alotee_gender,
                    'patta_no' => $basic->new_patta,
                    'old_dag' => $olddag,
                    'doul_year' => date('Y')
                );
                $chitha_allottee = array_merge($location, $allotee);
                $this->db->insert('chitha_rmk_allottee', $chitha_allottee);
                //var_dump($chitha_allottee);
                /////////////////////////////////
                
                ///////////////////////////////////////

                $pdar_id=$pattdaridCheck==true?$pdar_id:$pdar_id+1;

                $c_d_p = array(
                    'pdar_id' => $pdar_id,
                    'patta_no' => $basic->new_patta,
                    'patta_type_code' => $basic->patta_type_code,
                    'dag_por_b' => $basic->area_posession_b,
                    'dag_por_k' => $basic->area_posession_k,
                    'dag_por_lc' => $basic->area_posession_lc,
                    'dag_por_g' => $ganda,
                    'user_code' => $user_code,
                    'date_entry' => date('Y-m-d'),
                    'operation' => 'E',
                    'p_flag' => '0',
                    'jama_yn' => 'N',
                );
                $chitha_dag_p = array_merge($location, $c_d_p);
               // var_dump($chitha_dag_p);
                // $this->db->insert('chitha_dag_pattadar', $chitha_dag_p);
                $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$chitha_dag_p);  
                // echo $this->db->affected_rows();
                // echo $this->db->last_query();
                // echo "<br>***********************************<br>";
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
                    'pdar_aadharno' => null,
                    'pdar_mobile' => $alp->alotee_mobile,
                );
                //var_dump($chitha_pattadar);
                // $this->db->insert('chitha_pattadar', $chitha_pattadar);
                $chitha_pattadar['f1_case_no']=$case;
                $this->Chitha_basic_model->insert_table('chitha_pattadar',$chitha_pattadar);
                //echo $this->db->last_query();
                $pattdaridCheck=false;
                //echo "<br>*****************<br>";
            }
            // $this->db->trans_rollback();
            // die;
            $this->db->insert('chitha_rmk_gen', $rmk_gen);
            $this->db->insert('chitha_rmk_ordbasic', $ord_basic);
               $rmk_gen = array(
                'dist_code' => $d,
                'subdiv_code' => $s,
                'cir_code' => $c,
                'mouza_pargona_code' =>$mouza,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill,
                'dag_no' => $dag_no,
                'rmk_type_code' => '12',
                'rmk_type_hist_no' => $rmk_hist_no_old,
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'jama_updated' => null,
                'patta_no' => '0'
                
            );
            //var_dump($rmk_gen);
            $this->db->insert('chitha_rmk_gen', $rmk_gen); 
            
            $user_code = $this->session->userdata('user_code');
            $ord_basic = array(
                'dist_code' => $d,
                'subdiv_code' => $s,
                'cir_code' => $c,
                'mouza_pargona_code' =>$mouza,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill,
                'dag_no' => $dag_no,
                'rmk_type_hist_no' => $rmk_type_hist_no_old,
                'ord_no' => $alb->case_no,
                'ord_date' => date('Y-m-d'),
                'ord_type_code' => '10',
                'ord_cron_no' => $ord_cron_no_old,
                'case_no' => $alb->case_no,
                'ord_passby_sign_yn' => 'Y',
                'ord_passby_desig' => $this->session->userdata('user_desig_code'),
                'lm_code' => $alb->lm_code,
                'lm_sign_yn' => 'Y',
                'lm_sign_date' => $alb->lm_entry_date,
                'sk_code' => $alb->sk_code,
                'sk_sign_yn' => 'Y',
                'sk_sign_date' => $alb->sk_entry_date,
                'co_code' => $user_code,
                'co_sign_yn' => 'Y',
                'co_ord_date' => $alb->co_entry_date,
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'm_dag_area_b' => '0',
                'm_dag_area_k' => '0',
                'm_dag_area_lc' => '0',
                'm_dag_area_g' => 0,
                'm_dag_area_kr' => '0',
                'area_left_b' => $b,
                'area_left_k' => $k,
                'area_left_lc' => $lc,
                'area_left_g' => $g
            );
            // var_dump($ord_basic);
            $this->db->insert('chitha_rmk_ordbasic', $ord_basic);

            $patta_nonew=$basic->new_patta;
            $newpattatyp=$basic->patta_type_code;
            $co_comment="Select lm_comment from allotment_lm_note where case_no='$case' and dist_code='$d' and "
                                . "subdiv_code='$s' and circle_code='$c' and lot_no='$lot_no' and mouza_pargona_code='$mouza' and "
                                . "vill_townprt_code='$vill'";                  
            $co_comment = $this->db->query($co_comment)->row();
            // $lineNo = "select rmk_line_no as max from jama_remark where dist_code='$d' and "
      //                           . "subdiv_code='$s' and cir_code='$c' and lot_no='$lot_no' and mouza_pargona_code='$mouza' and "
      //                           . "vill_townprt_code='$vill'  and TRIM(patta_no)=trim('$basic->new_patta') and patta_type_code='$basic->patta_type_code' order by rmk_line_no desc limit 1";

      //       $line_no = $this->db->query($lineNo);
      //       if ($line_no->num_rows()>0) {
      //           $line_no = ($line_no->rows()->max)+1;
      //       }else{
      //           $line_no = 1;
      //       }
            // $remarkData = array(
            //         'dist_code' => $d,
            //         'subdiv_code' => $s,
            //         'cir_code' => $c,
            //         'mouza_pargona_code' => $mouza,
            //         'lot_no' =>$lot_no,
            //         'vill_townprt_code' => $vill,
            //         'patta_no' => $patta_nonew,
            //         'patta_type_code' => $newpattatyp,
            //         'rmk_line_no' => $line_no++,
            //         'remark' => $remarks,
            //         'user_code' => $result->user_code,
            //         'entry_date' => date('Y-m-d'),
            //         'entry_mode' => 'U'
            // );
            // if ($remarkData != null) {
            //     $this->db->insert('jama_remark', $remarkData); //.......................
            // }
            // $this->db->trans_rollback();
            // die;
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
            //var_dump($ord_basic);
        }

        function bopending() {
            $dist_code = $this->session->userdata('dist_code');
            $data['cases'] = $this->db->query("select * from allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and dc_note is not null and bo_note is null and settlement_typ='s' ")->result();
            $this->load->helper('html');
            $this->load->view('../views/header');
            $this->load->view('../views/settlement/bopendinglistfirst', $data);
            $this->load->view('../views/footer');
        }

        function bofirstproceeding() {
            $dist_code = $this->session->userdata('dist_code');
            $case_no = $this->input->get('case_no');
            $q = "select * from allotment_cert_basic where status = 'R' and co_code is not null and dist_code='$dist_code' and dc_note is not null and bo_note is null and case_no='$case_no' and settlement_typ='s'";
            $data['allotment_cb'] = $alcb = $this->db->query($q)->row();
            $subdiv_code = $alcb->subdiv_code;
            $circle_code = $alcb->circle_code;
            $data['circlename'] = $this->utilityclass->getCircleNamebydbload($dist_code, $subdiv_code, $circle_code);
            $this->load->view('../views/header');
            $this->load->view('../views/settlement/bofirstorder', $data);
            $this->load->view('../views/footer');
        }

        function saveboorder() {
            $user_code = $this->session->userdata('user_code');
            $case_no = $this->input->post('case_no');
            $dist_code = $this->session->userdata('dist_code');
            $comment = addslashes($this->input->post('bo_comment'));
            $name = $this->utilityclass->getDefinedBOName($dist_code, $user_code);
            $name = $name->username;
            $name = " ???? ??????  ---" . $name;
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
            //$id = $this->db->insert_id();
            $q = "Select max(proceeding_id) as p from petition_proceeding_dc_adc where case_no='$case_no' ";
            $proceeding_id = $this->db->query($q)->row()->p;
            $this->db->where('dist_code', $dist_code);
            $this->db->where('case_no', $case_no);
            $this->db->where('subdiv_code', '00');
            $this->db->where('cir_code', '00');
            $this->db->where('proceeding_id', $proceeding_id);
            $this->db->update('petition_proceeding_dc_adc', $update_pro);
            $this->session->set_flashdata('message', "Case Successfully Passed with case number $case_no");
            redirect(base_url() . 'index.php/home');

            //var_dump($update);
        }

        /////////////////////View Application//////////////////////////////////
        function viewapplication() {
            $case_no = $this->input->get('case_no');
            $q = "Select * from allotment_cert_basic where case_no='$case_no'";
            $data['certbasic'] = $this->db->query($q)->row();
            $q = "Select * from allotment_petitioner where case_no='$case_no'";
            $data['aloteepett'] = $this->db->query($q)->result();
            $q = "Select * from allotment_doc_details where case_no='$case_no'";
            $data['aloteedoc'] = $this->db->query($q)->row();
            $q = "Select * from allotment_pet_dag where case_no='$case_no'";
            $data['aloteedag'] = $this->db->query($q)->result();
            $q = "Select * from allotment_pet_dag where case_no='$case_no'";
            $aloteedag = $this->db->query($q)->row();
            //var_dump($aloteedag);
            //$landclass= "select patta_type from patta_code where type_code='$aloteedag->patta_type_code'";
        //  echo "select patta_type from patta_code where type_code='$aloteedag->patta_type_code'";
           //$data['patta_typ'] =$this->db->query($landclass)->row();

           $landclass= "select patta_type from patta_code where type_code='0201'";
        //  echo "select patta_type from patta_code where type_code='$aloteedag->patta_type_code'";
           $data['patta_typ_new'] =$this->db->query($landclass)->row();
        
        
        
            $this->load->view('../views/settlement/view_basic', $data);
        }

        function viewlmnote() {
            $case_no = $this->input->get('case_no');
            $q = "Select * from allotment_lm_note where case_no='$case_no'";
            $data['aloteelm'] = $this->db->query($q)->row();
            $this->load->view('../views/settlement/view_lmnote', $data);
        }

        function viewcert() {
            // $case_no = $this->input->get('case_no');
            // $q = "Select * from allotment_doc_details where case_no='$case_no'";
            // //echo "Select * from allotment_doc_details where case_no='$case_no'";
            // $row = $this->db->query($q)->row();
            
            // header("Content-type: application/pdf");
            // //ltrim($row->file_name,'\\')
            // //pg_query('SET bytea_output = "escape";');
            // $filedata1 = pg_unescape_bytea($row->file_name);
            
            // echo $filedata1;
            //$this->load->view('../views/allotment/view_docfile', $filedata1);
             $bytea = "Set bytea_output='escape'";
             $this->db->query($bytea);
             
            
            $case_no = $this->input->get('case_no');
            $q = "Select * from allotment_doc_details where case_no='$case_no'";
            $row = $this->db->query($q)->row();
            $ext='.pdf';
              header("Content-type: application/pdf");
            header("Content-disposition:attachment; filename=$case_no.$ext ");
            echo $filedata1 = pg_unescape_bytea($row->file_name);
            
            
            
            
        }
        
        
           function viewcertrev() {
            // $case_no = $this->input->get('case_no');
            // $q = "Select * from allotment_doc_details where case_no='$case_no'";
            // //echo "Select * from allotment_doc_details where case_no='$case_no'";
            // $row = $this->db->query($q)->row();
            
            // header("Content-type: application/pdf");
            // //ltrim($row->file_name,'\\')
            // //pg_query('SET bytea_output = "escape";');
            // $filedata1 = pg_unescape_bytea($row->file_name);
            
            // echo $filedata1;
            //$this->load->view('../views/allotment/view_docfile', $filedata1);
             $bytea = "Set bytea_output='escape'";
             $this->db->query($bytea);
             
            
            $case_no = $this->input->get('case_no');
            $q = "Select * from allotment_doc_details where case_no='$case_no'";
            $row = $this->db->query($q)->row();
            $ext='.pdf';
              header("Content-type: application/pdf");
            header("Content-disposition:attachment; filename=$case_no.$ext ");
            echo $filedata1 = pg_unescape_bytea($row->file_namerev);
            
            
            
            
        }
        
        
        
           function viewcertpre() {
            // $case_no = $this->input->get('case_no');
            // $q = "Select * from allotment_doc_details where case_no='$case_no'";
            // //echo "Select * from allotment_doc_details where case_no='$case_no'";
            // $row = $this->db->query($q)->row();
            
            // header("Content-type: application/pdf");
            // //ltrim($row->file_name,'\\')
            // //pg_query('SET bytea_output = "escape";');
            // $filedata1 = pg_unescape_bytea($row->file_name);
            
            // echo $filedata1;
            //$this->load->view('../views/allotment/view_docfile', $filedata1);
             $bytea = "Set bytea_output='escape'";
             $this->db->query($bytea);
             
            
            $case_no = $this->input->get('case_no');
            $q = "Select * from allotment_doc_details where case_no='$case_no'";
            $row = $this->db->query($q)->row();
            $ext='.pdf';
              header("Content-type: application/pdf");
            header("Content-disposition:attachment; filename=$case_no.$ext ");
            echo $filedata1 = pg_unescape_bytea($row->file_namepremium);
            
            
            
            
        }
        
        
        
        
        
        
        
        
        
        
        

        function viewsknote() {
            $case_no = $this->input->get('case_no');
            $q = "Select * from allotment_lm_note where case_no='$case_no'";
            $data['aloteesk'] = $this->db->query($q)->row();
            $this->load->view('../views/settlement/view_sknote', $data);
        }

        function viewpro() {
            $case_no = $this->input->get('case_no');
            $q = "Select * from allotment_cert_basic where case_no='$case_no'";
            $data['pb'] = $this->db->query($q)->row();
            $q = "Select * from petition_proceeding_dc_adc where case_no='$case_no' order by proceeding_id ";
            $data['pd'] = $this->db->query($q)->result();
            $this->load->view('../views/settlement/view_proceeding', $data);
        }

        ///////////////
        function proceeding() {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $data['cases'] = $this->db->query("Select * from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  status='F' ")->result();
            $this->load->view('../views/header');
            $this->load->view('../views/settlement/procaseslist', $data);
            $this->load->view('../views/footer');
        }

        function viewprceeding() {
            $case_no = $this->input->get('case_no');
            $q = "Select * from allotment_cert_basic where case_no='$case_no'";
            $data['pb'] = $this->db->query($q)->row();
            $q = "Select * from petition_proceeding_dc_adc where case_no='$case_no' order by proceeding_id ";
            $data['pd'] = $this->db->query($q)->result();
            $this->load->view('../views/header');
            $this->load->view('../views/settlement/view_proceeding', $data);
            $this->load->view('../views/footer');
        }

        function cofinalpendingcase() {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');

            $data['cases'] = $this->db->query("Select * from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code'  and status='P' and lm_note='Y' 
                and sk_code is not null and settlement_typ='s' and chitha_correct_yn is null ")->result();
            // $data['cases'] = $this->db->query("Select * from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and not_fresh='Y' and status='P' and co_note is not null and settlement_typ='s' and chitha_correct_yn is null and lm_code is not null and sk_code is not null ")->result();
            // $this->load->view('../views/header');
            // $this->load->view('../views/settlement/pendingcofinallist', $data);
            // $this->load->view('../views/footer');

            $data['_view'] = 'settlement/pendingcofinallist';
            $this->load->view('layouts/main',$data);
        }
        
         function cofinalpendingcaseAP() {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            
            $data['cases'] = $this->db->query("Select * from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and not_fresh is null and status is null and lm_note='Y' and co_note is null and settlement_typ='ap' and chitha_correct_yn is null ")->result();
            $this->load->view('../views/header');
            $this->load->view('../views/settlement/pendingcofinallistAp', $data);
            $this->load->view('../views/footer');
        }
        
        
        
         function cofinalpendingcaseGrant() {
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            
            $data['cases'] = $this->db->query("Select * from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and not_fresh is not null  and lm_note='Y' and status is not null and sk_note='Y' and co_note is null and settlement_typ='gr' and chitha_correct_yn is null ")->result();
          
         
            $this->load->view('../views/header');
            $this->load->view('../views/settlement/pendingcofinallistGrant', $data);
            $this->load->view('../views/footer');
        }

        

        function Finalcoorder() {
            $case_no = $this->input->get('case_no');
            $data['case_no'] = $case_no;
             
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $year_no = year_no;
            
             $dist_name = $this->utilityclass->getDistrictName($dist_code);
             $data['dist_name'] =$dist_name;
             $data['allotment_cb'] = $this->db->query("Select * from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no' and settlement_typ='s' ")->row();

            $q = "Select * from allotment_lm_note where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and case_no='$case_no' ";// and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill'";
            $data['alm'] = $alm = $this->db->query($q)->row();
            $mouza=$alm->mouza_pargona_code;
            $lot_no=$alm->lot_no;//$this->input->get('lot_no');
            $vill=$alm->vill_townprt_code;//$this->input->get('vill_townprt_code');
            $patta_type = $alm->patta_type_code;
            $data['selectedPattaType']=$patta_type;
            $pattasqll = "Select type_code,patta_type from    patta_code where mutation='a' ";
            $data['mutpatta'] = $this->db->query($pattasqll)->result();
            $data['newdag'] = $this->utilityclass->maxdag($dist_code, $subdiv_code, $cir_code, $mouza, $lot_no, $vill);
            $data['newpatta'] = $this->utilityclass->maxpatta($dist_code, $subdiv_code, $cir_code, $mouza, $lot_no, $vill, $patta_type);
            $q = "Select dag_no,patta_no,dag_no_int as new_dag from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill' order by dag_no_int";
            $data['dag_patta'] = $this->db->query($q)->result();
            $q = "Select lm_comment from allotment_lm_note where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and case_no='$case_no' and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill'";
            $data['lmnote'] = $this->db->query($q)->row();
            $q = "Select l_rev,l_tax from allotment_lm_note where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and case_no='$case_no' and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill'";
            $data['l_rev_local'] = $this->db->query($q)->row();
            
            //lines to be deleted..................................
            
             $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
          //  $lot_no = $this->session->userdata('lot_no');
          
            $data['allotment_certificate123'] = $this->db->query("Select * from allotment_doc_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no'  ")->row();

            $q = "Select * from allotment_petitioner where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no'";
            
            $data['applicant'] = $this->db->query($q)->row();
            
            

            $data['dag_details'] = $this->db->query("Select * from allotment_pet_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code'  and case_no='$case_no' ")->row();
           $patta_typecode = $this->db->query("Select * from allotment_pet_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code'  and case_no='$case_no' ")->row();

            
            //Query for generation Zonal Valuation    -------------18032022
            $query = "Select dag_no from allotment_pet_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and case_no='$case_no'";
            $old_dag = $this->db->query($query)->row();
            $new_dag_no = $this->utilityclass->maxdag($dist_code, $subdiv_code, $cir_code, $mouza, $lot_no, $vill);
            //code for updating zonal informtion of dag------------17032023--
            $dag_no = $old_dag->dag_no;
            $data['old_dag'] = $dag_no;
        
            //code for generating village uuid------------
            $village_uuid = $this->utilityclass->getVillageUUID($dist_code, $subdiv_code, $cir_code, $mouza, $lot_no, $vill);

            //code for generating zonal value--------------
            $data['zonalValueOfDag'] = $this->utilityclass->getZonalValue($dist_code, $village_uuid, $dag_no);


            //var_dump($data);
            // $this->load->view('../views/header');
            // $this->load->view('../views/settlement/coupdatedagpatta', $data);
            // $this->load->view('../views/footer');

            $data['_view'] = 'settlement/coupdatedagpatta';
            $this->load->view('layouts/main',$data);
        }

           function FinalcoorderAP() {
            $case_no = $this->input->get('case_no');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $year_no = year_no;
             $data['allotment_cb'] = $this->db->query("Select * from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no' ")->row();
            $data['allotment_certificate'] = $this->db->query("Select name_of_certificate,rev_certificate,premium_certificate from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no' and year_no='$year_no' ")->row();
            
            $q = "Select * from allotment_lm_note where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and case_no='$case_no' ";// and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill'";
            $data['alm'] = $alm = $this->db->query($q)->row();
            $mouza=$alm->mouza_pargona_code;
            $lot_no=$alm->lot_no;//$this->input->get('lot_no');
            $vill=$alm->vill_townprt_code;//$this->input->get('vill_townprt_code');
            $patta_type = $alm->patta_type_code;
           
            $q = "Select dag_no,patta_no,dag_no_int as new_dag from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill' order by dag_no_int";
            $data['dag_patta'] = $this->db->query($q)->result();
            $q = "Select lm_comment from allotment_lm_note where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and case_no='$case_no' and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill'";
            $data['lmnote'] = $this->db->query($q)->row();
            $q = "Select l_rev,l_tax from allotment_lm_note where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and case_no='$case_no' and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill'";
            $data['l_rev_local'] = $this->db->query($q)->row();
            
            //lines to be deleted..................................
            
             $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
          //  $lot_no = $this->session->userdata('lot_no');
          
            $data['allotment_certificate123'] = $this->db->query("Select * from allotment_doc_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no' and year_no='$year_no' ")->row();
            
            //$challandate =$allotment_certificate123->challandate;
            //$createDate = new DateTime($challandate);

          // $cdate = $createDate->format('Y-m-d');
         //  $data['cdate']=$cdate;
            
            //echo"Select * from allotment_doc_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no' and year_no='$year_no'";
            

            $q = "Select * from allotment_petitioner where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no'";
            
            $data['applicant'] = $this->db->query($q)->row();
            
            

            $data['dag_details'] = $this->db->query("Select * from allotment_pet_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code'  and case_no='$case_no' ")->row();
           $patta_typecode = $this->db->query("Select * from allotment_pet_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code'  and case_no='$case_no' ")->row();
          

          $newdag = $this->utilityclass->maxdagAP($dist_code, $subdiv_code, $cir_code, $mouza, $lot_no, $vill);
            $newpatta = $this->utilityclass->maxpattaAP($dist_code, $subdiv_code, $cir_code, $mouza, $lot_no, $vill);
          
          
          //  echo"Select * from allotment_pet_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and case_no='$case_no'";
            
                $sqlFullpart="select * from allotment_pet_dag where case_no='$case_no' ";
            $fullpart =$this->db->query($sqlFullpart)->row();
            if($fullpart->fullorpartial =='Y'){
                 $data['new_dag'] = ($fullpart->dag_no)/100;
                $data['new_patta'] = $newpatta + 1;
            }
            
            else{
            $data['new_dag'] = $newdag + 1;
            $data['new_patta'] = $newpatta + 1;
            }
            
            
            
            
            //lines to be deleted...................................
            
            //var_dump($data);
            // $this->load->view('../views/header');
            // $this->load->view('../views/settlement/coupdatedagpattaAP', $data);
            // $this->load->view('../views/footer');

            $data['_view'] = 'settlement/coupdatedagpattaAP';
            $this->load->view('layouts/main',$data);
        }
        
        
        
        
        
        
        
               function FinalcoorderGrant() {
            $case_no = $this->input->get('case_no');
            //echo 'jjjjjjjjjjj'.$case_no;
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $year_no = year_no;
             $dist_name = $this->utilityclass->getDistrictName($dist_code);
            // echo $dist_name;
             $data['dist_name']=$dist_name;
              $data['allotment_certificate123'] = $this->db->query("Select * from allotment_doc_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no' and year_no='$year_no' ")->row();
            
            //echo "Select * from allotment_doc_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no' and year_no='$year_no'";
             
            
            $q = "Select * from allotment_petitioner where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no'";
            
            $data['applicant'] = $this->db->query($q)->row();
            
             $data['dag_details'] = $this->db->query("Select * from allotment_pet_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code'  and case_no='$case_no' ")->row();
            
            
            $patta_type_grant = $this->db->query("Select * from allotment_pet_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code'  and case_no='$case_no' ")->row();
            
            
              $pattasqll = "Select type_code,patta_type from patta_code where type_code='$patta_type_grant->patta_type_code' ";
              
            $data['patta_typ'] = $this->db->query($pattasqll)->row();
            
            $q = "Select * from allotment_lm_note where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and case_no='$case_no' ";// and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill'";
            
            
            $data['alm'] = $alm = $this->db->query($q)->row();
            $mouza=$alm->mouza_pargona_code;
             
            $lot_no=$alm->lot_no;//$this->input->get('lot_no');
            $vill=$alm->vill_townprt_code;//$this->input->get('vill_townprt_code');
            //echo 'village'.$vill;
            $patta_type = $alm->patta_type_code;
                    
             $q = "Select dag_no from allotment_pet_dag where case_no='$case_no'";
            $data['dag_patta'] = $dag = $this->db->query($q)->result();

            $q = "Select lm_comment from allotment_lm_note where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and case_no='$case_no' and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill'";
            $data['lmnote'] = $this->db->query($q)->row();

          
            $pattasqll = "Select type_code,patta_type from patta_code where type_code='0201' ";
            $data['mutpatta']= $this->db->query($pattasqll)->row();
            
            
            
            //echo "Select  distinct class_code,land_type from landclass_code where class_code='$class_code' ";
         
             $newpatta = $this->utilityclass->maxpattaAP($dist_code, $subdiv_code, $cir_code, $mouza, $lot_no, $vill,'0201');
            
            
                $q = "Select l_rev,l_tax from allotment_lm_note where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and case_no='$case_no' and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill'";
            $data['l_rev_local'] = $this->db->query($q)->row();
          
            $data['new_patta'] = $newpatta ;
            
            
            
            
            
            
            
            
            
            
                    /*$data['allotment_cb'] = $this->db->query("Select * from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no' ")->row();
            $data['allotment_certificate'] = $this->db->query("Select name_of_certificate,rev_certificate,premium_certificate from allotment_cert_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no' and year_no='$year_no' ")->row();
            
            $q = "Select * from allotment_lm_note where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and case_no='$case_no' ";// and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill'";
            $data['alm'] = $alm = $this->db->query($q)->row();
            $mouza=$alm->mouza_pargona_code;
            $lot_no=$alm->lot_no;//$this->input->get('lot_no');
            $vill=$alm->vill_townprt_code;//$this->input->get('vill_townprt_code');
            $patta_type = $alm->patta_type_code;
           
            $q = "Select dag_no,patta_no,dag_no_int as new_dag from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill' order by dag_no_int";
            $data['dag_patta'] = $this->db->query($q)->result();
            $q = "Select lm_comment from allotment_lm_note where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and case_no='$case_no' and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill'";
            $data['lmnote'] = $this->db->query($q)->row();
            $q = "Select l_rev,l_tax from allotment_lm_note where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and case_no='$case_no' and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill'";
            $data['l_rev_local'] = $this->db->query($q)->row();
            
            //lines to be deleted..................................
            
             $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
          //  $lot_no = $this->session->userdata('lot_no');
          
            $data['allotment_certificate123'] = $this->db->query("Select * from allotment_doc_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no' and year_no='$year_no' ")->row();
            
            //$challandate =$allotment_certificate123->challandate;
            //$createDate = new DateTime($challandate);

          // $cdate = $createDate->format('Y-m-d');
         //  $data['cdate']=$cdate;
            
            //echo"Select * from allotment_doc_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no' and year_no='$year_no'";
            

            $q = "Select * from allotment_petitioner where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and  case_no='$case_no'";
            
            $data['applicant'] = $this->db->query($q)->row();
            
            

            $data['dag_details'] = $this->db->query("Select * from allotment_pet_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code'  and case_no='$case_no' ")->row();
           $patta_typecode = $this->db->query("Select * from allotment_pet_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code'  and case_no='$case_no' ")->row();
          

          //$newdag = $this->utilityclass->maxdagAP($dist_code, $subdiv_code, $cir_code, $mouza, $lot_no, $vill);
            $newpatta = $this->utilityclass->maxpattaAP($dist_code, $subdiv_code, $cir_code, $mouza, $lot_no, $vill);
          
          
          //  echo"Select * from allotment_pet_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and circle_code='$cir_code' and case_no='$case_no'";
            
                $sqlFullpart="select * from allotment_pet_dag where case_no='$case_no' ";
            $fullpart =$this->db->query($sqlFullpart)->row();
            if($fullpart->fullorpartial =='Y'){
                 $data['new_dag'] = ($fullpart->dag_no)/100;
                $data['new_patta'] = $newpatta + 1;
            }
            
            else{
            $data['new_dag'] = $newdag + 1;
            $data['new_patta'] = $newpatta + 1;
            } */
            
            
            
            
            
            //lines to be deleted...................................
            
            //var_dump($data);
            // $this->load->view('../views/header');
            // $this->load->view('../views/settlement/coupdatedagpattaGrant', $data);
            // $this->load->view('../views/footer');

            $data['_view'] = 'settlement/coupdatedagpattaGrant';
            $this->load->view('layouts/main',$data);
        }
        
         
        
        function updatechithaallotment() {
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
            // var_dump($_POST);
            // die;
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $user_code = $this->session->userdata('user_code');
            $mouza=$this->input->post('mouza_pargona_code');
            $lot_no=$this->input->post('lot_no');
            $vill=$this->input->post('vill_townprt_code');
            
            $case_no = $this->input->post('case_no');
            $new_dag = $this->input->post('new_dag');
            $new_patta = $this->input->post('new_patta');
            $newpattatyp = $this->input->post('new_patta_type');
            $revenue = $this->input->post('revenue');
            $local_tax = $this->input->post('local_tax');
            $co_comment = $this->input->post('coComment');

            $username = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code,$user_code);
            $username =  $username->username;
            $comment = $co_comment . $username;
            $comment = addslashes($comment);
            
            $data = array(
                'new_dag' => $new_dag,
                'new_patta' => $new_patta,
                'l_rev' => $revenue,
                'l_tax' => $local_tax,
                'co_comment' => $comment,
                'patta_type_code' => $newpattatyp
            );
            $this->db->where('case_no', $case_no);
            $this->db->update('allotment_lm_note', $data);
            $update = array(
                'chitha_correct_yn' => 'y',
                'chitha_correct_date' => date('Y-m-d'),
                'status'=>'F'
            );
            $test = $this->chithaupdate($dist_code, $subdiv_code, $cir_code, $case_no,$mouza,$lot_no,$vill);
            
            if ($test == true) {
                $this->db->where('dist_code', $dist_code);
                $this->db->where('case_no', $case_no);
                $this->db->update('allotment_cert_basic', $update);
                ////////
                $this->DashboardDataFinal($case_no);



                //code for generating zonal valuation-----------18022023
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



                //////
                $this->session->set_flashdata('message', "Case Successfully Passed with case number $case_no");
                $newpattatyp=$newpattatyp;
                
                header("location:".base_url() . "index.php/JamaBandi/step31/$new_patta/$newpattatyp/$dist_code/$subdiv_code/$cir_code/$mouza/$lot_no/$vill");
               exit();
               redirect(base_url() . 'index.php/home');
            } else {
                $this->session->set_flashdata('message', "Error During Proceesing $case_no");
                redirect(base_url() . 'index.php/home');
            }
        }

        
        
        
        
             function updatechithaallotmentGrant() {
            
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza=$this->input->post('mouza_pargona_code');
            $lot_no=$this->input->post('lot_no');
            $vill=$this->input->post('vill_townprt_code');
            
       $case_no = $this->input->post('case_no');
          //echo 'caseno'.$case_no;
            $new_patta = $this->input->post('new_patta');
            $new_patta_no = $this->input->post('new_patta_no');
            $revenue = $this->input->post('revenue');
            $local_tax = $this->input->post('local_tax');
            $co_comment = $this->input->post('coComment');
            
            
            
            $data = array(
                
               
             
                'lm_comment' => $co_comment
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
            
            
        
            $test = $this->chithaupdateGrant($dist_code, $subdiv_code, $cir_code, $case_no,$mouza,$lot_no,$vill,$new_patta_no);
            
            if ($test == true) {
                $this->db->where('dist_code', $dist_code);
                $this->db->where('case_no', $case_no);
                $this->db->update('allotment_cert_basic', $update);
                $this->session->set_flashdata('message', "Case Successfully Passed with case number $case_no");
                $newpattatyp='0201';
                
                header("location:".base_url() . "index.php/JamaBandi/step31/$new_patta_no/$newpattatyp/$dist_code/$subdiv_code/$cir_code/$mouza/$lot_no/$vill");
               exit();
               redirect(base_url() . 'index.php/home');
            } else {
                $this->session->set_flashdata('message', "Error During Proceesing $case_no");
                redirect(base_url() . 'index.php/home');
            }
        }
        
         
        
         function updatechithaallotmentAP() {
            
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza=$this->input->post('mouza_pargona_code');
            $lot_no=$this->input->post('lot_no');
            $vill=$this->input->post('vill_townprt_code');
            
            $case_no = $this->input->post('case_no');
            $new_dag = $this->input->post('new_dag');
            $new_patta = $this->input->post('new_patta');
            $revenue = $this->input->post('revenue');
            $local_tax = $this->input->post('local_tax');
            $co_comment = $this->input->post('coComment');
            
            $data = array(
                'new_dag' => $new_dag,
                'new_patta' => $new_patta,
                'l_rev' => $revenue,
                'l_tax' => $local_tax,
                'lm_comment' => $co_comment
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
            
            
            $old_dag="select * from allotment_pet_dag where case_no='case_no'";
            $olddg = $this->db->query($old_dag)->row()->dag_no;
         
            
            $test = $this->chithaupdateAP($dist_code, $subdiv_code, $cir_code, $case_no,$mouza,$lot_no,$vill,$new_dag,$olddg);
            
            if ($test == true) {
                $this->db->where('dist_code', $dist_code);
                $this->db->where('case_no', $case_no);
                $this->db->update('allotment_cert_basic', $update);
                $this->session->set_flashdata('message', "Case Successfully Passed with case number $case_no");
                $newpattatyp='0201';
                
                header("location:".base_url() . "index.php/JamaBandi/step31/$new_patta/$newpattatyp/$dist_code/$subdiv_code/$cir_code/$mouza/$lot_no/$vill");
               exit();
               redirect(base_url() . 'index.php/home');
            } else {
                $this->session->set_flashdata('message', "Error During Proceesing $case_no");
                redirect(base_url() . 'index.php/home');
            }
        }
        
        
        function chithaupdateAP($d, $s, $c, $case,$mouza,$lot_no,$vill,$new_dag,$olddag) {
            
            
         $this->db->trans_begin();
          $q = "Select * from allotment_pet_dag where case_no='$case' and dist_code='$d' and "
                                . "subdiv_code='$s' and circle_code='$c' and lot_no='$lot_no' and mouza_pargona_code='$mouza' and "
                                . "vill_townprt_code='$vill' ";
                            
                                
                                
            $dag_no = $this->db->query($q)->row()->dag_no;
            
            $allotment_petdag = $this->db->query($q)->row();
            
           $query_rmk_hist = "select max(rmk_type_hist_no) as c from chitha_rmk_gen where "
                        . "dist_code='$d' and subdiv_code='$s' and cir_code='$c'"
                        . " and lot_no='$lot_no' and mouza_pargona_code='$mouza' and "
                        . " vill_townprt_code='$vill' and dag_no='$dag_no' ";
                
                $rmk_hist_no_old = $this->db->query($query_rmk_hist)->row()->c;
                if ($rmk_hist_no_old == null) {
                    $rmk_hist_no_old = 1;
                } else
                    $rmk_hist_no_old += 1;
                  $user_code = $this->session->userdata('user_code');
            $q = "SElect * from allotment_lm_note where case_no='$case' and dist_code='$d' and subdiv_code='$s' and circle_code='$c' and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill'";
            $basic = $this->db->query($q)->row();
            $q = "SElect * from allotment_cert_basic where case_no='$case' and dist_code='$d' and subdiv_code='$s' and circle_code='$c' and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill'";
            $alb = $this->db->query($q)->row();
            //var_dump($this->session->all_userdata());
            $rmk_type_hist_no = 1;
            $ord_cron_no = 1;
                
          $q = "select max(ord_cron_no) as c1,max(rmk_type_hist_no) as c2 from chitha_rmk_ordbasic where "
                        . "dist_code='$d' and subdiv_code='$s' and cir_code='$c'"
                        . " and lot_no='$lot_no' and mouza_pargona_code='$mouza' and "
                        . " vill_townprt_code='$vill' and dag_no='$dag_no' ";
                        
                        

                $ord_cron_no_old = $this->db->query($q)->row()->c1;
                if ($ord_cron_no_old == null) {
                    $ord_cron_no_old = 1;
                } else {
                    $ord_cron_no_old +=1;
                }       
                 $rmk_type_hist_no_old = $this->db->query($q)->row()->c2;
                if ($rmk_type_hist_no_old == null) {
                    $rmk_type_hist_no_old = 1;
                } else {
                    $rmk_type_hist_no_old +=1;
                }
                 $q = "SElect * from allotment_petitioner where case_no='$case' ";
            $allotp = $this->db->query($q)->result();
            $q = "SElect dag_no as dagold from allotment_pet_dag where case_no='$case' ";
            $olddag = $this->db->query($q)->row()->dagold;
            $olddg=($olddag/100);
                
                //check chitha for full partition
            
             $check_cb = "select * from chitha_basic where dist_code='$d' and "
                                . "subdiv_code='$s' and cir_code='$c' and lot_no='$basic->lot_no' and mouza_pargona_code='$basic->mouza_pargona_code' and "
                                . "vill_townprt_code='$basic->vill_townprt_code' and dag_no='$new_dag'";
                
                
                 
                
            
                 
                 $resultcb = $this->db->query($check_cb)->row();
                 $resultcb_counted = count($resultcb);
                 if($resultcb_counted !=''){
                     
                 //echo 'full';
                
            
            //   $delete_cb = "update chitha_basic set patta_no='$basic->new_patta',jama_yn='n',patta_type_code='0201' where  dist_code='$d' and "
            //                     . "subdiv_code='$s' and cir_code='$c' and lot_no='$basic->lot_no' and mouza_pargona_code='$basic->mouza_pargona_code' and "
            //                     . "vill_townprt_code='$basic->vill_townprt_code' and dag_no='$olddg' ";
                
                
            //               $this->db->query($delete_cb);

            $table = 'chitha_basic';
            $params = [
                'patta_no'       => $basic->new_patta,
                'jama_yn'        => 'n',
                'patta_type_code'=> '0201',
            ];
            $where = [
                'dist_code'          => $d,
                'subdiv_code'        => $s,
                'cir_code'           => $c,
                'lot_no'             => $basic->lot_no,
                'mouza_pargona_code' => $basic->mouza_pargona_code,
                'vill_townprt_code'  => $basic->vill_townprt_code,
                'dag_no'             => $olddg,
            ];
            $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                          
                          
                 $chitha_dag_pattadar="select * from chitha_dag_pattadar   where  dist_code='$d' and "
                                . "subdiv_code='$s' and cir_code='$c' and lot_no='$basic->lot_no' and mouza_pargona_code='$basic->mouza_pargona_code' and "
                                . "vill_townprt_code='$basic->vill_townprt_code' and dag_no='$olddg' ";
                 
                 
                     
                    


                    $result123 = $this->db->query($chitha_dag_pattadar)->result();
                      
                      foreach($result123 as $pid){
                          if($pid->p_flag=='0'){
                              
                        // $chitha_pattadar_strike= "update chitha_dag_pattadar set p_flag='1'  where  dist_code='$d' and "
                        //         . "subdiv_code='$s' and cir_code='$c' and lot_no='$basic->lot_no' and mouza_pargona_code='$basic->mouza_pargona_code' and "
                        //         . "vill_townprt_code='$basic->vill_townprt_code' and dag_no='$olddg' ";   
                              
                        //  $this->db->query($chitha_pattadar_strike);   

                            $table = 'chitha_dag_pattadar';

                            $params = [
                                'p_flag' => '1',
                            ];

                            $where = [
                                'dist_code'          => $d,
                                'subdiv_code'        => $s,
                                'cir_code'           => $c,
                                'lot_no'             => $basic->lot_no,
                                'mouza_pargona_code' => $basic->mouza_pargona_code,
                                'vill_townprt_code'  => $basic->vill_townprt_code,
                                'dag_no'             => $olddg,
                            ];

                            // Then execute:
                            $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                              
                          }
                          
                          
                      }       
                        

            /* echo $update_jammapatta = "update jama_patta set patta_no='$basic->new_patta',patta_type_code='0201' where  dist_code='$d' and "
                                . "subdiv_code='$s' and cir_code='$c' and lot_no='$basic->lot_no' and mouza_pargona_code='$basic->mouza_pargona_code' and "
                                . "vill_townprt_code='$basic->vill_townprt_code' and patta_type_code='$allotment_petdag->patta_type_code' ";
                
                
                          $this->db->query($update_jammapatta); allotment_pet_dag patta_no patta_type_code */
                        
                          
            
            
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
                'rmk_type_code' => '13',
                'rmk_type_hist_no' => $rmk_type_hist_no,
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'jama_updated' => null,
                'patta_no' => $basic->new_patta
            );
            $rmk_gen = array_merge($location, $r_gen);
            
             $this->db->insert('chitha_rmk_gen', $rmk_gen);
            
                   $o_basic = array(
                'rmk_type_hist_no' => $rmk_type_hist_no_old,
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
                'co_code' => $user_code,
                'co_sign_yn' => 'Y',
                'co_ord_date' => $alb->co_entry_date,
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'm_dag_area_b' => $basic->area_posession_b,
                'm_dag_area_k' => $basic->area_posession_k,
                'm_dag_area_lc' => $basic->area_posession_lc,
                'm_dag_area_g' => '0',
                'm_dag_area_kr' => '0',
                'area_left_b' => '0',
                'area_left_k' => '0',
                'area_left_lc' => '0',
                'area_left_g' => '0'
            );
            $ord_basic = array_merge($location, $o_basic);
            
              $this->db->insert('chitha_rmk_ordbasic', $ord_basic);
              
                foreach ($allotp as $alp) {
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
                    'allottee_land_b' => $basic->area_posession_b,
                    'allottee_land_k' => $basic->area_posession_k,
                    'allottee_land_lc' => $basic->area_posession_lc,
                    'allottee_land_g' => 0,
                    'allottee_land_kr' => 0,
                    'land_revenue' => $basic->l_rev,
                    'land_local_tax' => $basic->l_tax,
                    'user_code' => $user_code,
                    'date_entry' => date('Y-m-d'),
                    'operation' => 'E',
                    //'allotment_no'=>,
                    'allottee_gender' => $alp->alotee_gender,
                    'patta_no' => $basic->new_patta,
                    'old_dag' =>$basic->new_dag,
                    'doul_year' => date('Y')
                );
                //var_dump($allotee);
                $chitha_allottee = array_merge($location, $allotee);
                $this->db->insert('chitha_rmk_allottee', $chitha_allottee);
                
                $patta_nonew=$basic->new_patta;
            $newpattatyp=$basic->patta_type_code;
            
            
            
            $co_comment="Select lm_comment from allotment_lm_note where case_no='$case' and dist_code='$d' and "
                                . "subdiv_code='$s' and circle_code='$c' and lot_no='$lot_no' and mouza_pargona_code='$mouza' and "
                                . "vill_townprt_code='$vill'";
                            
                                
                                
            $co_comment = $this->db->query($co_comment)->row();
            
            $lineNo = "select max(rmk_line_no)+1 as max from jama_remark where dist_code='$d' and "
                                . "subdiv_code='$s' and cir_code='$c' and lot_no='$lot_no' and mouza_pargona_code='$mouza' and "
                                . "vill_townprt_code='$vill'  and TRIM(patta_no)=trim('$patta_nonew') and patta_type_code='$newpattatyp'";

                $line_no = $this->db->query($lineNo)->row()->max;

                if ($line_no == null) {
                    $line_no = 1;
                }
                for ($j = 0; $j < sizeof($remarks); $j++) {

                    $remarkData = array(
                        'dist_code' => $d,
                        'subdiv_code' => $s,
                        'cir_code' => $c,
                        'mouza_pargona_code' => $mouza,
                        'lot_no' =>$lot_no,
                        'vill_townprt_code' => $vill,
                        'patta_no' => $patta_nonew,
                        'patta_type_code' => $newpattatyp,
                        'rmk_line_no' => $line_no++,
                        'remark' => $remarks,
                        'user_code' =>$user_code,
                        'entry_date' => date('Y-m-d'),
                        'entry_mode' => 'U'
                    );
                    if ($remarks != null) {
                        $this->db->insert('jama_remark', $remarkData); //.......................
                    }
                }   
                }
            
              
              
              
            
            
            
            
            
                 }
            //check chitha for full partition
                
                
                if($resultcb_counted ==''){
         
        
        
          
            
            $location = array(
                'dist_code' => $basic->dist_code,
                'subdiv_code' => $basic->subdiv_code,
                'cir_code' => $basic->circle_code,
                'mouza_pargona_code' => $basic->mouza_pargona_code,
                'lot_no' => $basic->lot_no,
                'vill_townprt_code' => $basic->vill_townprt_code,
                'dag_no' => $basic->new_dag
            );
            /*$r_gen = array(
                'rmk_type_code' => '14',
                'rmk_type_hist_no' => $rmk_type_hist_no,
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'jama_updated' => null,
                'patta_no' => $basic->new_patta
            );
            $rmk_gen = array_merge($location, $r_gen); */
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
                'co_code' => $user_code,
                'co_sign_yn' => 'Y',
                'co_ord_date' => $alb->co_entry_date,
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'm_dag_area_b' => $basic->area_posession_b,
                'm_dag_area_k' => $basic->area_posession_k,
                'm_dag_area_lc' => $basic->area_posession_lc,
                'm_dag_area_g' => '0',
                'm_dag_area_kr' => '0',
                'area_left_b' => '0',
                'area_left_k' => '0',
                'area_left_lc' => '0',
                'area_left_g' => '0'
            );
            $ord_basic = array_merge($location, $o_basic);

           
            
            $cb = array(
                'dag_no_int' => $basic->new_dag . '00',
                'patta_type_code' => $basic->patta_type_code,
                'patta_no' => $basic->new_patta,
                'land_class_code' => $basic->ladclass_code,
                'dag_area_b' => $basic->area_posession_b,
                'dag_area_k' => $basic->area_posession_k,
                'dag_area_lc' => $basic->area_posession_lc,
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
            $chitha_basic = array_merge($location, $cb);
            // $this->db->insert('chitha_basic', $chitha_basic);
            $this->Chitha_basic_model->insert_table('chitha_basic',$chitha_basic);
            
        
            
            
             $q = "Select * from allotment_pet_dag where case_no='$case' and dist_code='$d' and "
                                . "subdiv_code='$s' and circle_code='$c' and lot_no='$lot_no' and mouza_pargona_code='$mouza' and "
                                . "vill_townprt_code='$vill' ";
                            
                                
                                
            $dag_no = $this->db->query($q)->row()->dag_no;
            
            
        
            
      $landArea_query = "select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,dag_revenue,dag_local_tax from chitha_basic where dist_code='$d' and "
                                . "subdiv_code='$s' and cir_code='$c' and lot_no='$lot_no' and mouza_pargona_code='$mouza' and "
                                . "vill_townprt_code='$vill' and dag_no='$olddg' ";
                                
                      echo"select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,dag_revenue,dag_local_tax from chitha_basic where dist_code='$d' and "
                                . "subdiv_code='$s' and cir_code='$c' and lot_no='$lot_no' and mouza_pargona_code='$mouza' and "
                                . "vill_townprt_code='$vill' and dag_no='$olddg' ";      

                        $sourceB = $this->db->query($landArea_query)->row()->dag_area_b;
                        $sourceK = $this->db->query($landArea_query)->row()->dag_area_k;
                        $sourceL = $this->db->query($landArea_query)->row()->dag_area_lc;
                        $sourceRev = $this->db->query($landArea_query)->row()->dag_revenue;
                        $sourceLTax = $this->db->query($landArea_query)->row()->dag_local_tax;
                        $sourceLessa = $sourceB * 100 + $sourceK * 20 + $sourceL;
                        $targetLessa = $basic->area_posession_b * 100 + $basic->area_posession_k * 20 + $basic->area_posession_lc;
                        $remLessa = $sourceLessa - $targetLessa;
                        $new_revenue = ($sourceRev / $sourceLessa) * $remLessa;
                        $new_local_tax = ($new_revenue / 4);
                        $b = floor($remLessa / 100.0);
                        $k = ($remLessa - $b * 100.0) / 20.0; //0
                        $k = floor($k);
                        $lc = ($remLessa - $b * 100.0 - $k * 20.0);
                        $g = 0.0;
                        $kr = 0.0;
                        $dag_no_int = $dag_no . "00";
                        
                        //echo "this is when updating the old dag in chitha.<br><br>";
                        // $chitha_update = "update chitha_basic set dag_area_b='$b',dag_area_k='$k', dag_area_lc='$lc',jama_yn='n' where dist_code='$d' and  subdiv_code='$s' and cir_code='$c' and lot_no='$lot_no' and mouza_pargona_code='$mouza' and  vill_townprt_code='$vill' and dag_no='$olddg' ";

     // echo"update chitha_basic set dag_area_b='$b',dag_area_k='$k', dag_area_lc='$lc',jama_yn='n' where dist_code='$d' and  subdiv_code='$s' and cir_code='$c' and lot_no='$lot_no' and mouza_pargona_code='$mouza' and  vill_townprt_code='$vill' and dag_no='$olddg' ";
         //  exit();           
                    //   $this->db->query($chitha_update);

                    $table = 'chitha_basic';
                    $params = [
                        'dag_area_b' => $b,
                        'dag_area_k' => $k,
                        'dag_area_lc' => $lc,
                        'jama_yn'    => 'n',
                    ];
                    $where = [
                        'dist_code'          => $d,
                        'subdiv_code'        => $s,
                        'cir_code'           => $c,
                        'lot_no'             => $lot_no,
                        'mouza_pargona_code' => $mouza,
                        'vill_townprt_code'  => $vill,
                        'dag_no'             => $olddg,
                    ];
                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                      
                      
                

                
            
                
                
                $co_comment="Select lm_comment from allotment_lm_note where case_no='$case' and dist_code='$d' and "
                                . "subdiv_code='$s' and circle_code='$c' and lot_no='$lot_no' and mouza_pargona_code='$mouza' and "
                                . "vill_townprt_code='$vill'";
                            
                                
                                
            $co_comment = $this->db->query($co_comment)->row();
            
            $comment = $co_comment->lm_comment;
            //echo $comment;
            
            $lineNo = "select max(rmk_line_no)+1 as max from jama_remark where dist_code='$d' and "
                                . "subdiv_code='$s' and cir_code='$c' and lot_no='$lot_no' and mouza_pargona_code='$mouza' and "
                                . "vill_townprt_code='$vill'  and TRIM(patta_no)=trim('$basic->new_patta') and patta_type_code='0201'";

                $line_no = $this->db->query($lineNo)->row()->max;

                if ($line_no == null) {
                    $line_no = 1;
                }
                for ($j = 0; $j < sizeof($comment); $j++) {

                    $remarkData = array(
                        'dist_code' => $d,
                        'subdiv_code' => $s,
                        'cir_code' => $c,
                        'mouza_pargona_code' => $mouza,
                        'lot_no' =>$lot_no,
                        'vill_townprt_code' => $vill,
                        'patta_no' => $basic->new_patta,
                        'patta_type_code' => '0201',
                        'rmk_line_no' => $line_no++,
                        'remark' => $comment,
                        'user_code' =>$user_code,
                        'entry_date' => date('Y-m-d'),
                        'entry_mode' => 'U'
                    );
                    if ($comment != null) {
                        $this->db->insert('jama_remark', $remarkData); //.......................
                    }
                }   
            
        
        
            
            foreach ($allotp as $alp) {
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
                    'allottee_land_b' => $basic->area_posession_b,
                    'allottee_land_k' => $basic->area_posession_k,
                    'allottee_land_lc' => $basic->area_posession_lc,
                    'allottee_land_g' => 0,
                    'allottee_land_kr' => 0,
                    'land_revenue' => $basic->l_rev,
                    'land_local_tax' => $basic->l_tax,
                    'user_code' => $user_code,
                    'date_entry' => date('Y-m-d'),
                    'operation' => 'E',
                    //'allotment_no'=>,
                    'allottee_gender' => $alp->alotee_gender,
                    'patta_no' => $basic->new_patta,
                    'old_dag' =>$basic->new_dag,
                    'doul_year' => date('Y')
                );
                //var_dump($allotee);
                $chitha_allottee = array_merge($location, $allotee);
                $this->db->insert('chitha_rmk_allottee', $chitha_allottee);
                //var_dump($chitha_allottee);
                $c_d_p = array(
                    'pdar_id' => $alp->alotee_id,
                    'patta_no' => $basic->new_patta,
                    'patta_type_code' => $basic->patta_type_code,
                    'dag_por_b' => $basic->area_posession_b,
                    'dag_por_k' => $basic->area_posession_k,
                    'dag_por_lc' => $basic->area_posession_lc,
                    'dag_por_g' => '0',
                    'user_code' => $user_code,
                    'date_entry' => date('Y-m-d'),
                    'operation' => 'E',
                    'p_flag' => '0',
                    'jama_yn' => 'N',
                );
                $chitha_dag_p = array_merge($location, $c_d_p);
                // $this->db->insert('chitha_dag_pattadar', $chitha_dag_p);
                $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$chitha_dag_p);  
                //var_dump($chitha_dag_p);
                $chitha_pattadar = array(
                    'dist_code' => $basic->dist_code,
                    'subdiv_code' => $basic->subdiv_code,
                    'cir_code' => $basic->circle_code,
                    'mouza_pargona_code' => $basic->mouza_pargona_code,
                    'lot_no' => $basic->lot_no,
                    'vill_townprt_code' => $basic->vill_townprt_code,
                    'pdar_id' => $alp->alotee_id,
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
                    'pdar_aadharno' => null,
                    'pdar_mobile' => $alp->alotee_mobile,
                );
                //var_dump($chitha_pattadar);
                // $this->db->insert('chitha_pattadar', $chitha_pattadar);
                $chitha_pattadar['f1_case_no']=$case;
                $this->Chitha_basic_model->insert_table('chitha_pattadar',$chitha_pattadar);
            }
           //...........11... $this->db->insert('chitha_rmk_gen', $rmk_gen);
            
            
            $this->db->insert('chitha_rmk_ordbasic', $ord_basic);
               $rmk_gen = array(
                'dist_code' => $d,
                'subdiv_code' => $s,
                'cir_code' => $c,
                'mouza_pargona_code' =>$mouza,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill,
                'dag_no' => $basic->new_dag,
           
                'rmk_type_code' => '14',
                'rmk_type_hist_no' => $rmk_hist_no_old,
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'jama_updated' => null,
                'patta_no' => ''
                
            );
         
                //var_dump($rmk_gen);
            $this->db->insert('chitha_rmk_gen', $rmk_gen); 
            $user_code = $this->session->userdata('user_code');
            
              $ord_basic = array(
                'dist_code' => $d,
                'subdiv_code' => $s,
                'cir_code' => $c,
                'mouza_pargona_code' =>$mouza,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill,
                'dag_no' => $dag_no,
                'rmk_type_hist_no' => $rmk_type_hist_no_old,
                'ord_no' => $alb->case_no,
                'ord_date' => date('Y-m-d'),
                'ord_type_code' => '10',
                'ord_cron_no' => $ord_cron_no_old,
                'case_no' => $alb->case_no,
                'ord_passby_sign_yn' => 'Y',
                'ord_passby_desig' => $this->session->userdata('user_desig_code'),
                'lm_code' => $alb->lm_code,
                'lm_sign_yn' => 'Y',
                'lm_sign_date' => $alb->lm_entry_date,
                'sk_code' => $alb->sk_code,
                'sk_sign_yn' => 'Y',
                'sk_sign_date' => $alb->sk_entry_date,
                'co_code' => $user_code,
                'co_sign_yn' => 'Y',
                'co_ord_date' => $alb->co_entry_date,
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d'),
                'operation' => 'E',
                'm_dag_area_b' => '0',
                'm_dag_area_k' => '0',
                'm_dag_area_lc' => '0',
                'm_dag_area_g' => '0',
                'm_dag_area_kr' => '0',
                'area_left_b' => $b,
                'area_left_k' => $k,
                'area_left_lc' => $lc,
                'area_left_g' => '0'
            );
          // var_dump($ord_basic);
            $this->db->insert('chitha_rmk_ordbasic', $ord_basic);
            $patta_nonew=$basic->new_patta;
            $newpattatyp=$basic->patta_type_code;
            
            
            
            $co_comment="Select lm_comment from allotment_lm_note where case_no='$case' and dist_code='$d' and "
                                . "subdiv_code='$s' and circle_code='$c' and lot_no='$lot_no' and mouza_pargona_code='$mouza' and "
                                . "vill_townprt_code='$vill'";
                            
                                
                                
            $co_comment = $this->db->query($co_comment)->row();
            
            $lineNo = "select max(rmk_line_no)+1 as max from jama_remark where dist_code='$d' and "
                                . "subdiv_code='$s' and cir_code='$c' and lot_no='$lot_no' and mouza_pargona_code='$mouza' and "
                                . "vill_townprt_code='$vill'  and TRIM(patta_no)=trim('$patta_nonew') and patta_type_code='$newpattatyp'";

                $line_no = $this->db->query($lineNo)->row()->max;

                if ($line_no == null) {
                    $line_no = 1;
                }
                for ($j = 0; $j < sizeof($remarks); $j++) {

                    $remarkData = array(
                        'dist_code' => $d,
                        'subdiv_code' => $s,
                        'cir_code' => $c,
                        'mouza_pargona_code' => $mouza,
                        'lot_no' =>$lot_no,
                        'vill_townprt_code' => $vill,
                        'patta_no' => $patta_nonew,
                        'patta_type_code' => $newpattatyp,
                        'rmk_line_no' => $line_no++,
                        'remark' => $remarks,
                        'user_code' =>$user_code,
                        'entry_date' => date('Y-m-d'),
                        'entry_mode' => 'U'
                    );
                    if ($remarks != null) {
                        $this->db->insert('jama_remark', $remarkData); //.......................
                    }
                }   
                }
            
            
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
            //var_dump($ord_basic);
        
        
        
        

    }

     
        /*function chithaupdateGrant($d, $s, $c, $case_no,$mouza,$lot_no,$vill,$new_patta_no) {
            $user_code = $this->session->userdata('user_code');
            
            $q = "SElect * from allotment_petitioner where case_no='$case_no' ";
            $allotp = $this->db->query($q)->result();
            
            $allotment_petdag = "SElect * from allotment_pet_dag where case_no='$case_no' ";
            $allotpetdag = $this->db->query($allotment_petdag)->result();
            //var_dump($allotpetdag);
            $q = "SElect * from allotment_lm_note where case_no='$case_no' and dist_code='$d' and subdiv_code='$s' and circle_code='$c' and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill'";
            $basic = $this->db->query($q)->row();
            $new_patta_no=$new_patta_no;
            foreach($allotpetdag as $dagnm){
                $pc =$dagnm->patta_type_code;           
                $dgg = $this->db->query("Select dag_no as dagno,  patta_no as pattano from chitha_basic where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill' and dag_no_int='$dagnm->dag_no'")->row();
                //var_dump($dgg);
                $dg = $dgg->dagno;
                $pno_old = $dgg->pattano;     
                $chk_chitha_dag_pattadar = "SElect * from chitha_dag_pattadar where  dist_code='$d' and subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill' and dag_no='$dg' and patta_no = '$pno_old' and patta_type_code = '$pc'";
                $c_d_p = $this->db->query($chk_chitha_dag_pattadar)->result();
                /////////new/////////           
                $chitha__dag_update_pno="update chitha_dag_pattadar set patta_no='$new_patta_no', patta_type_code = '0201' ,jama_yn='n' where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill' and dag_no='$dg' 
                 ";
                $this->db->query($chitha__dag_update_pno);
                $chitha_update="update chitha_basic set patta_type_code='0201',patta_no='$new_patta_no',jama_yn='n'  where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill' and dag_no='$dg'  ";
                $this->db->query($chitha_update);   
                /////////end////////            
            }
            $chitha__dag_update_ptyp="update chitha_pattadar set patta_type_code='0201',patta_no='$new_patta_no',jama_yn='n' where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill' and patta_no='$pno_old' and  patta_type_code='$pc'";
            $this->db->query($chitha__dag_update_ptyp);
            
            //exit;
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
            //var_dump($ord_basic);
        
        
        
        

    } */






        function chithaupdateGrant($d, $s, $c, $case_no,$mouza,$lot_no,$vill,$new_patta_no) {
            $user_code = $this->session->userdata('user_code');
            
            $q = "SElect * from allotment_petitioner where case_no='$case_no' ";
            $allotp = $this->db->query($q)->result();
            
            $allotment_petdag = "SElect * from allotment_pet_dag where case_no='$case_no' ";
            $allotpetdag = $this->db->query($allotment_petdag)->result();
            //var_dump($allotpetdag);
            $q = "SElect * from allotment_lm_note where case_no='$case_no' and dist_code='$d' and subdiv_code='$s' and circle_code='$c' and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill'";
            $basic = $this->db->query($q)->row();
             
            $q = "SElect * from allotment_lm_note where case_no='$case_no' and dist_code='$d' and subdiv_code='$s' and circle_code='$c' and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill'";
            $basic = $this->db->query($q)->row();
            $new_patta_no=$new_patta_no;
            foreach($allotpetdag as $dagnm){
                $pc =$dagnm->patta_type_code;           
                $dgg = $this->db->query("Select dag_no as dagno,  patta_no as pattano from chitha_basic where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill' and dag_no_int='$dagnm->dag_no'")->row();
                //var_dump($dgg);
                $dg = $dgg->dagno;
                $pno_old = $dgg->pattano;     
                $p_old = $dagnm->patta_no;    
                $chk_chitha_dag_pattadar = "SElect * from chitha_dag_pattadar where  dist_code='$d' and subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill' and dag_no='$dg' and patta_no = '$pno_old' and patta_type_code = '$pc'";
                $c_d_p = $this->db->query($chk_chitha_dag_pattadar)->result();
                /////////new/////////           
                // $chitha__dag_update_pno="update chitha_dag_pattadar set patta_no='$new_patta_no', patta_type_code = '0201' ,jama_yn='n' where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill' and dag_no='$dg' 
                //  ";
                // $this->db->query($chitha__dag_update_pno);
                $table = 'chitha_dag_pattadar';

                $params = [
                    'patta_no'       => $new_patta_no,
                    'patta_type_code'=> '0201',
                    'jama_yn'        => 'n',
                ];
                $where = [
                    'dist_code'          => $d,
                    'subdiv_code'        => $s,
                    'cir_code'           => $c,
                    'mouza_pargona_code' => $mouza,
                    'lot_no'             => $lot_no,
                    'vill_townprt_code'  => $vill,
                    'dag_no'             => $dg,
                ];
                // Then call the update function
                $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                // $chitha_update="update chitha_basic set patta_type_code='0201',patta_no='$new_patta_no',jama_yn='n',operation='G' where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill' and dag_no='$dg'  ";
                // $this->db->query($chitha_update);   
                /////////end////////

                $table = 'chitha_basic';

                $params = [
                    'patta_type_code' => '0201',
                    'patta_no'       => $new_patta_no,
                    'jama_yn'        => 'n',
                    'operation'      => 'G',
                ];

                $where = [
                    'dist_code'          => $d,
                    'subdiv_code'        => $s,
                    'cir_code'           => $c,
                    'mouza_pargona_code' => $mouza,
                    'lot_no'             => $lot_no,
                    'vill_townprt_code'  => $vill,
                    'dag_no'             => $dg,
                ];

                // Then update using your model method:
                $this->Chitha_basic_model->update_table($table, $params, $where);

                
                
                
                    $rmk_gen = array(
                'dist_code' => $d,
                'subdiv_code' => $s,
                'cir_code' => $c,
                'mouza_pargona_code' =>$mouza,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill,
                'dag_no' => $dg,
                'patta_no' => $new_patta_no,
                'patta_type_code' => '0201',
                'dag_no_int' => $dagnm->dag_no,
                'remark' => $basic->lm_comment,
                'category' => '2',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d G:i:s'),
                );
                //var_dump($rmk_gen);
                //exit;
                $this->db->insert('backlog_orders', $rmk_gen);          
            }
         
        
        
            //echo $pno_old;
            $sql="Select * from chitha_pattadar where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill' and patta_no='$p_old' and  patta_type_code='$pc'";
            $cp=$this->db->query($sql)->result();
            foreach($cp as $r){
                $r->patta_type_code='0201';
                $r->patta_no=$new_patta_no;
                $r->jama_yn='n';
                // $this->db->insert('chitha_pattadar',$r);
                $r['f1_case_no']=$case_no;
                $this->Chitha_basic_model->insert_table('chitha_pattadar',$r);
            }
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
                //exit;
            }
            //var_dump($ord_basic);
    }

    function Dashboard($case_no)
        {
            
            $this->dbb = $this->load->database('dash', TRUE);

            $sql="Select acb.*,dag_no from allotment_cert_basic acb left join allotment_pet_dag apd on acb.case_no=apd.case_no where acb.settlement_typ='s' and acb.case_no='$case_no' ";
            $type='SM';

            $data=$this->db->query($sql)->row_array();
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
                  'pending_with_user' =>'LM',
                  'case_type' =>$type,
                  'date_of_insert'=>date("Y-m-d h:i:s")
                        );
                $this->dbb->insert('dashboard_data',$base);

                unset($base['dag_no']);
                unset($base['patta_type_code']);
                unset($base['patta_no']);

            $this->db->insert('dashboard_data',$base);



            $sql="Select alotee_name as pet_name,alotee_gurdian as guard_name,alotee_reln as guard_rel from allotment_petitioner where dist_code='$data[dist_code]' and subdiv_code='$data[subdiv_code]' and circle_code='$data[circle_code]' and "
                        . "mouza_pargona_code = '$data[mouza_pargona_code]' and lot_no = '$data[lot_no]' and vill_townprt_code = '$data[vill_townprt_code]' and case_no='$data[case_no]'";

            $petitioner=$this->db->query($sql)->result();
            foreach ($petitioner as $key => $value) {
                $applicant= array(
                    'case_no' => $case_no,
                    'applicant_name' => $value->pet_name,
                    'guardian_name' => $value->guard_name,
                    'gender' => $value->guard_rel );
                $this->dbb->insert('dashboard_applicant',$applicant);
            }
            $action= array(
                'case_no' => $case_no,
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


                        $this->db->where('case_no',$case_no);
                        $this->db->update('dashboard_data',$base);
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

                            $this->db->where('case_no',$case_no);
                        $this->db->update('dashboard_data',$base);
                    /////////////////////////////////////
            }


    }