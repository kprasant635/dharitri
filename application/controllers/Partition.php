<?php //BRD0014: ByayPrak Report remove for RTPS Service(s) from LM End Auto submit ?>
<?php
class Partition extends CI_Controller {
    var $db;
    public function __construct() {
        parent::__construct();
        $this->load->model('mutation/mutationmodel');
        $this->load->model('patta/pattamodel');
        $this->load->model('partition/partmodel');
        $this->load->model('serviceplus/ServicePlusModel');
        $this->load->library('form_validation');
        $this->load->helper('html');
        $this->load->model('basundhara/basundharamodel');
        $this->load->model('Escalationmodel');
        $this->load->model('TransactionModel');
        $this->load->model('Chitha_basic_model');
        $this->load->model('AgriStackCaseHistory');
        $this->load->model('Log_model');
        if(ENABLED_BLOCKCHAIN == 1)
        {
            $this->load->model('propChain/PropChainModel');
            $this->load->model('propChain/PropChainCommonModel');
        }

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

    public function index() {
        redirect(base_url() . 'index.php/partition/mutation');
    }

    public function mutation() {
        if ($this->session->userdata('dags') !== FALSE) {
            $this->session->unset_userdata('dags');
        }
        if ($this->session->userdata('pattadar') !== FALSE) {
            $this->session->unset_userdata('pattadar');
        }

        $data = $this->mutationmodel->getDistricts();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouzas = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
        $district['d'] = $dist_code;
        $district['s'] = $subdiv_code;
        $district['c'] = $cir_code;
        $district['mouzas'] = $mouzas;
        $district['pattatype'] = $this->utilityclass->getPartitionPattaType();
        $q = "select * from  loginuser_table where dist_code = '$dist_code' and subdiv_code='$subdiv_code' and  cir_code='$cir_code' and dis_enb_option='E' and (priv='mut' or priv='adm') and user_code like 'CO%' ";
        $users = $this->db->query($q)->result();
        foreach ($users as $u) {
            $query_string = "dist_code = '$dist_code' and subdiv_code='$subdiv_code' and"
                    . " cir_code = '$cir_code' and user_code='$u->user_code' ";
            $district['user'] = $this->db->query("select * from  users where " . $query_string)->result();
        }
        $this->form_validation->set_rules('mouza_code', 'Mouza Code', 'required|trim|integer|max_length[2]');
        $this->form_validation->set_rules('lot_no', 'Lot Number', 'required|trim|integer|max_length[2]');
        $this->form_validation->set_rules('vill_code', 'Village Code', 'required|trim|integer|max_length[5]|min_length[5]');
        $this->form_validation->set_rules('patta_type', 'Patta Type', 'required|trim|integer|max_length[4]|min_length[4]');
        $this->form_validation->set_rules('patta_no', 'Patta Number', 'required|trim');
        $this->form_validation->set_rules('add_of_desig', 'Select Applied CO', 'required|trim');
        $this->form_validation->set_rules('add_of_name', 'CO Name Required', 'required|trim');
        if ($this->form_validation->run() == TRUE) {
            $this->partmodel->mutation();
            redirect(base_url() . "index.php/Partition/partland");
        } else {
            // $this->load->view('../views/header');
            // $this->load->view('../views/partition/select_location', $district);
            // $this->load->view('../views/footer');
            $district['_view'] = 'partition/select_location';
            $this->load->view('layouts/main',$district);
        }
    }

    public function partland() {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $patta_type_code = $this->session->userdata('patta_type');
        $patta_no = $this->session->userdata('patta_no');
        $data['dags'] = $this->utilityclass->allDags($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code, $patta_no, $patta_type_code);
        //var_dump($data);

        $this->form_validation->set_rules('dag_no', 'Select Dag Number', 'required|trim');
        $this->form_validation->set_rules('dag_area_b', 'Bigha', 'required|trim|integer|max_length[3]');
        $this->form_validation->set_rules('dag_area_k', 'Katha', 'required|trim|integer|max_length[3]');
        $this->form_validation->set_rules('dag_area_lc', 'Lessa', 'required|trim|numeric|max_length[10]');
        $this->form_validation->set_rules('m_dag_area_b', 'Bigha', 'required|trim|integer|max_length[3]');
        $this->form_validation->set_rules('m_dag_area_k', 'Katha', 'required|trim|integer|max_length[3]');
        $this->form_validation->set_rules('m_dag_area_lc', 'Lessa', 'required|trim|numeric|max_length[10]');
        $this->form_validation->set_rules('land_valuation', 'Revenue Amount', 'required|trim|integer|max_length[5]|min_length[1]');
        if ($this->form_validation->run() == TRUE) {
            $this->partmodel->landarea();
            redirect(base_url() . "index.php/Partition/applicantDetails");
        } else {
            $data['_view'] = 'partition/partitionlandarea';
            $this->load->view('layouts/main',$data);
        }
    }

    public function mutationType() {
        //$this->load->view('../views/header');
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('circle_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');
        $mouza_pargona_code = $this->input->post('mouza_code');
        $coname = $this->utilityclass->getCOName($dist_code, $subdiv_code, $cir_code);
        $locationData = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'lot_no' => $lot_no,
            'vill_code' => $vill_code,
            'mouza_pargona_code' => $mouza_pargona_code,
        );
        $this->session->set_userdata($locationData);
        $this->load->model('patta/pattamodel');
        $patta['pattatype'] = $this->pattamodel->getAllPattaType();
        $patta['_view'] = 'partition/mutationtype';
        $this->load->view('layouts/main',$patta);
    }

    public function savePartionCO() {
        
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        //$this->load->view('../views/header');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_code = $this->session->userdata('vill_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');

        $patta_no = trim($this->input->post('patta_no'));
        $patta_type_code = $this->input->post('patta_type');

        $query = "select * from    chitha_basic where dist_code= " . $this->db->escape($dist_code) . " and subdiv_code=" . $this->db->escape($subdiv_code) . " and "
                . " cir_code=" . $this->db->escape($cir_code) . " and lot_no=" . $this->db->escape($lot_no) . " and mouza_pargona_code=" . $this->db->escape($mouza_pargona_code) . " and "
                . " vill_townprt_code=" . $this->db->escape($vill_code) . " and TRIM(patta_no)=" . $this->db->escape($patta_no) . " and patta_type_code=" . $this->db->escape($patta_type_code) . "  ";
        $dags = $this->db->query($query)->result();
        $data['dags'] = $dags;
        $patta_no = $this->input->post('patta_no');
        $patta_type_code = $this->input->post('patta_type');
        $applied_to = $this->input->post('applied_to');
        $patta_type = $this->input->post('patta_type');
        $partition_type = $this->input->post('patition_type');
        $topseal = $this->input->post('topseal');
        $attachment = $this->input->post('attachment');
        $add_off_name = $this->input->post('COName');
        $partiondata = array(
            'add_off_name' => $add_off_name,
            'add_of_desig' => $applied_to,
            'patta_no' => $patta_no,
            'patta_type' => $patta_type,
            'patta_type_code' => $patta_type_code,
            'complete_patition_yn' => $partition_type,
            'supported_doc' => $attachment,
            'remarks' => $topseal
        );
        $this->session->set_userdata($partiondata);
        $data['_view'] = 'partition/partitionlandarea';
        $this->load->view('layouts/main',$data);
    }

    public function LandAreaDetails() {
        //$db=  $this->session->userdata('db');
        $dag_no = $this->input->post('dag_no');
        $partiondata = array('dag_no' => $dag_no);
        $this->session->set_userdata($partiondata);
        $dag_no = $this->input->post('dag_no');
        $bigha = $this->input->post('m_dag_area_b');
        $katha = $this->input->post('m_dag_area_k');
        $lessa = $this->input->post('m_dag_area_lc');
        $gonda = $this->input->post('m_dag_area_g');
        $kranti = $this->input->post('m_dag_area_kr');
        $t_bigha = $this->input->post('dag_area_b');
        $t_katha = $this->input->post('dag_area_k');
        $t_lessa = $this->input->post('dag_area_lc');
        $revenue = $this->input->post('land_valuation');
        $tot_lc = ($bigha * 5 * 20) + ($katha * 20) + $lessa;
        $total = ($t_bigha * 5 * 20) + ($t_katha * 20) + $t_lessa;
        if ($katha > 5 or $lessa > 20) {
            $this->session->set_flashdata('message', 'You did not enter the partition land area correctly !!');
            redirect(base_url() . 'index.php/partition/mutation');
        }
        if (($tot_lc == 0) or ( $total < $tot_lc)) {
            // $this->session->set_flashdata('message', 'You did not enter the partition land area correctly !!');
            $this->session->set_flashdata('message', 'You did not enter the partition land area correctly !!');
            redirect(base_url() . 'index.php/partition/mutation');
            // exit();
        }
        $this->session->set_userdata('dags', array());
        $dags = $this->session->userdata('dags');
        $data = array(
            'dag_no' => $dag_no,
            'bigha' => $bigha,
            'katha' => $katha,
            'lessa' => $lessa,
            'gonda' => $gonda,
            'kranti' => $kranti,
            'revenue' => $revenue
        );

        array_push($dags, $data);
        $this->session->set_userdata('dags', $dags);
        redirect(base_url() . 'index.php/partition/ApplicantDetails');
    }

    public function applicantDetails() {
        //$db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $this->load->model('relation/relationmodel');
        $data['relation'] = $this->relationmodel->getRelations();
        $data['gender'] = $this->partmodel->getGender();
        $data['pattadar'] = $this->partmodel->getPattadarPartition();
        //var_dump($data);
        $this->form_validation->set_rules('pdar_name', 'Select Pattadar Name', 'required|trim|integer');
        $this->form_validation->set_rules('pdar_guardian', 'Select Gurdian Name', 'required|trim');
        $this->form_validation->set_rules('pdar_gender', 'Select Gender', 'required|trim');
        $this->form_validation->set_rules('pdar_rel_guar', 'Select Relation ', 'required|trim');
        $this->form_validation->set_rules('pdar_cron_no', 'Serial Number', 'required|trim|integer');
        $this->form_validation->set_rules('pdar_mobile', 'Mobile Number', 'trim|integer|max_length[10]');
        if ($this->form_validation->run() == TRUE) {
            $this->partmodel->pattdar();
            redirect(base_url() . "index.php/Partition/applicantDetails");
        } else {
            $data['_view'] = 'partition/applicantdetails';
            $this->load->view('layouts/main',$data);
        }

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            if ($this->session->userdata('pattadar') != null) {
                $pattadar = $this->session->userdata('pattadar');
                //echo sizeof($pattadar);
                $pdar_cron_no = $this->input->post('pdar_cron_no');
                $pdar_name = $this->input->post('pdar_name');
                $pdar_guard_name = $this->input->post('pdar_guardian');
                $pdar_rel_guar = $this->input->post('pdar_rel_guar');
                $pdar_add1 = $this->input->post('pdar_add1');
                $pdar_add2 = $this->input->post('pdar_add2');
                $is_converted_pattadar = $this->input->post('Remain_Land');
                $pdar_gender = $this->input->post('pdar_gender');
                $pdar_mother = $this->input->post('pdar_mother');
                $pdar_mobile = $this->input->post('pdar_mobile');
                $pdar_aadhar = $this->input->post('pdar_aadhar');
                $pdar_nrc = $this->input->post('pdar_nrc');
                $pdar_pan = $this->input->post('pdar_pan');
                $pdar_voterID = $this->input->post('pdar_voterID');
                $data = array(
                    'pdar_name' => $pdar_name,
                    'pdar_guardian' => $pdar_guard_name,
                    'pdar_rel_guar' => $pdar_rel_guar,
                    'pdar_add1' => $pdar_add1,
                    'pdar_add2' => $pdar_add2,
                    'is_converted_pattadar' => $is_converted_pattadar,
                    'pdar_mother' => $pdar_mother,
                    'pdar_gender' => $pdar_gender,
                    'pdar_pan_no' => $pdar_pan,
                    'pdar_citizen_no' => $pdar_voterID,
                    'pdar_aadharno' => $pdar_aadhar,
                    'pdar_mobile' => $pdar_mobile,
                    'pdar_nrcno' => $pdar_nrc
                );
                $pattadar[] = $data;
                $this->session->set_userdata('pattadar', $pattadar);
            } else {
                $this->session->set_userdata('pattadar', array());
                $pattadar = $this->session->userdata('pattadar');
                $pdar_cron_no = $this->input->post('pdar_cron_no');
                $pdar_name = $this->input->post('pdar_name');
                $pdar_guard_name = $this->input->post('pdar_guardian');
                $pdar_rel_guar = $this->input->post('pdar_rel_guar');
                $pdar_add1 = $this->input->post('pdar_add1');
                $pdar_add2 = $this->input->post('pdar_add2');
                $is_converted_pattadar = $this->input->post('Remain_Land');
                $pdar_gender = $this->input->post('pdar_gender');
                $pdar_mother = $this->input->post('pdar_mother');
                $pdar_mobile = $this->input->post('pdar_mobile');
                $pdar_aadhar = $this->input->post('pdar_aadhar');
                $pdar_nrc = $this->input->post('pdar_nrc');
                $pdar_pan = $this->input->post('pdar_pan');
                $pdar_voterID = $this->input->post('pdar_voterID');
                $data = array(
                    'pdar_name' => $pdar_name,
                    'pdar_guardian' => $pdar_guard_name,
                    'pdar_rel_guar' => $pdar_rel_guar,
                    'pdar_add1' => $pdar_add1,
                    'pdar_add2' => $pdar_add2,
                    'is_converted_pattadar' => $is_converted_pattadar,
                    'pdar_mother' => $pdar_mother,
                    'pdar_gender' => $pdar_gender,
                    'pdar_pan_no' => $pdar_pan,
                    'pdar_citizen_no' => $pdar_voterID,
                    'pdar_aadharno' => $pdar_aadhar,
                    'pdar_mobile' => $pdar_mobile,
                    'pdar_nrcno' => $pdar_nrc
                );
                array_push($pattadar, $data);
                $this->session->set_userdata('pattadar', $pattadar);
            }
        }
    }

    public function saveApplicantDetails() {
        //$db=  $this->session->userdata('db');
        $data = array();
        // var_dump($this->session->all_userdata());
        $data['dags'] = $this->session->userdata('dags');
        $land = $this->session->userdata('landarea');
        $patta_type_code = $this->session->userdata('patta_type_code');
        $pattadar = $this->session->userdata('appdet');
        $data['patta_type'] = $this->db->get_where("patta_code", array('type_code' => $patta_type_code))->row()->patta_type;
        $data['patta_no'] = trim($this->session->userdata('patta_no'));
        $location = $this->utilityclass->getLocationFromSession();
        $dist_code = $this->utilityclass->getDistrictName($location['dist_code']);
        $subdiv_code = $this->utilityclass->getSubDivName($location['dist_code'], $location['subdiv_code']);
        $cir_code = $this->utilityclass->getCircleName($location['dist_code'], $location['subdiv_code'], $location['cir_code']);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code']);
        $lot_no = $this->utilityclass->getLotName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no']);
        $vill_townprt_code = $this->utilityclass->getVillageName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code']);
        $data['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code,
            'dag_no' => $this->session->userdata('dag_no'),
            'bigha' => $this->session->userdata('bigha'),
            'katha' => $this->session->userdata('katha'),
            'lessa' => $this->session->userdata('lessa'),
            'revenue' => $this->session->userdata('revenue')
        );
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $vill_code = $this->session->userdata('vill_code');
        $lot_no = $this->session->userdata('lot_no');
        $dag_no = $this->session->userdata('dag_no');
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type = $this->session->userdata('patta_type');
        $pattadars['pattadar'] = $this->session->userdata('appdet');
        $data1 = array_merge($data, $pattadars);
        $data1['_view'] = 'partition/ast_report_first';
        $this->load->view('layouts/main',$data1);
    }

    public function savePartionAsst() {
        //$db=  $this->session->userdata('db');
        $this->db->trans_begin();
        $location = $this->utilityclass->getLocationFromSession();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $dag_no = $this->session->userdata('dag_no');
        $user_code = $this->session->userdata('user_code');
        $year = year_no;
        $define_date = define_date;
        $sub_cir = $subdiv_code . $cir_code;
  //       $petition_no = $this->db->query("select MAX(petition_no)+1 as count from    petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' 
        // and cir_code='$cir_code'  ")->row()->count;
  //       if ($petition_no == null) {
  //           $petition_no = 1;
  //       }
  //       // case petition number///
  //       $casepetition_no = $this->db->query("select count(petition_no)+1 as count from    petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' 
        // and cir_code='$cir_code' and year_no='$year'  and mut_type='04' and date(date_entry) >='$define_date'  ")->row()->count;
  //       if ($casepetition_no == null) {
  //           $casepetition_no = 1;
  //       }
  //       $q = "Select dist_abbr,cir_abbr from    location where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code!='00' ";
  //       $abbrname = $this->db->query($q)->row();
  //       $cir_dist_name = $abbrname->dist_abbr . "/" . $abbrname->cir_abbr;
  //       $financialyeardate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('y') : date('Y') . "-" . date('y', strtotime('+1 year'));
  //       //$case_no = $cir_dist_name."/".$financialyeardate . "/" . $casepetition_no . "/OPART";
  //       $check_status = TRUE;
  //       while ($check_status == TRUE) {
  //           $case_no = $cir_dist_name . "/" . $financialyeardate . "/" . $casepetition_no . "/OPART";
  //           $check_existance = $this->db->query("select count(*) as c from    petition_basic where case_no='$case_no'")->row()->c;
  //           if ($check_existance <= '0') {
  //               $case_no = $cir_dist_name . "/" . $financialyeardate . "/" . $casepetition_no . "/OPART";
  //               $check_status = FALSE;
  //           } else {
  //               $casepetition_no = $casepetition_no + 1;
  //           }
  //       }
        $case_name=$this->basundharamodel->genearteCaseName();
        $case_no['petition_no']=$petition_no=$this->basundharamodel->genearteOfficePetitionNo();
        $case_no=$case_name.$petition_no."/OPART";

        $partiondata = array('case_no' => $case_no);
        $this->session->set_userdata($partiondata);
        $add_off_name = $this->session->userdata('add_off_name');
        $add_off_desig = $this->session->userdata('add_of_desig');
        $petition_basic = array(
            'dist_code' => $location['dist_code'],
            'subdiv_code' => $location['subdiv_code'],
            'cir_code' => $location['cir_code'],
            'mouza_pargona_code' => $location['mouza_pargona_code'],
            'lot_no' => $location['lot_no'],
            'vill_townprt_code' => $location['vill_townprt_code'],
            'year_no' => $year,
            'petition_no' => $petition_no,
            'case_no' => $case_no,
            'submission_date' => date('Y-m-d G:i:s'),
            'mut_type' => '04',
            'add_off_name' => $add_off_name,
            'add_off_desig' => $add_off_desig,
            'supported_doc' => '',
            'complete_partition_yn' => $this->session->userdata('complete_patition_yn'),
            'user_code' => $user_code,
            'date_entry' => date('Y-m-d G:i:s'),
            'operation' => 'E',
            'co_user_code' => $add_off_name
        );
        //var_dump($petition_basic);
        $this->db->insert("petition_basic", $petition_basic);
        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];
        $mouza_pargona_code = $location['mouza_pargona_code'];
        $vill_townprt_code = $location['vill_townprt_code'];
        $lot_no = $location['lot_no'];
        $patta_no = trim($this->session->userdata('patta_no'));
        $patta_type_code = $this->session->userdata('patta_type_code');
        $dag_no = $this->session->userdata('dag_no');
        $bigha = $this->session->userdata('bigha');
        $katha = $this->session->userdata('katha');
        $lessa = $this->session->userdata('lessa');
        $revenue = $this->session->userdata('revenue');
        $pattadar = $this->session->userdata('appdet');
        $user_code = $this->session->userdata('user_code');
        $dags_data = array(
            'dist_code' => $location['dist_code'],
            'subdiv_code' => $location['subdiv_code'],
            'cir_code' => $location['cir_code'],
            'mouza_pargona_code' => $location['mouza_pargona_code'],
            'lot_no' => $location['lot_no'],
            'vill_townprt_code' => $location['vill_townprt_code'],
            'year_no' => $year,
            'petition_no' => $petition_no,
            'm_dag_area_b' => $bigha,
            'm_dag_area_k' => $katha,
            'm_dag_area_lc' => $lessa,
            'm_dag_area_g' => '0',
            //'m_dag_area_kr' => $d['m_dag_area_kr'],
            'patta_no' => trim($this->session->userdata('patta_no')),
            'patta_type_code' => $this->session->userdata('patta_type_code'),
            'revenue' => $revenue,
            'user_code' => $user_code,
            'date_entry' => date('Y-m-d G:i:s'),
            'operation' => 'E',
            'dag_no' => $dag_no,
            'case_no' => $case_no
        );
        $cron_no = 1;
        foreach ($pattadar as $p) {
            $pdar_id = $p['pdar_name'];
            $is_converted_pattadar = $p['is_converted_pattadar'];
            $pdar_gender = $p['pdar_gender'];
            $pdar_father = $p['pdar_guardian'];
            $pdar_mobile = $p['pdar_mobile'];
            $relation = " ";
            $relation = $p['pdar_rel_guar'];
            $pdar_name = $name = $this->utilityclass->getnameByPdarId($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code'], $patta_no, $patta_type_code, $pdar_id);
            $other_data = array(
                'dist_code' => $location['dist_code'],
                'subdiv_code' => $location['subdiv_code'],
                'cir_code' => $location['cir_code'],
                'mouza_pargona_code' => $location['mouza_pargona_code'],
                'lot_no' => $location['lot_no'],
                'vill_townprt_code' => $location['vill_townprt_code'],
                'year_no' => $year,
                'petition_no' => $petition_no,
                'dag_no' => $dag_no,
                'patta_no' => $patta_no,
                'patta_type_code' => $patta_type_code,
                'pdar_id' => $pdar_id,
                'pdar_cron_no' => $cron_no++,
                'pdar_name' => $pdar_name,
                'pdar_guardian' => $pdar_father,
                'pdar_rel_guar' => $relation,
                'pdar_add1' => $p['pdar_add1'],
                'pdar_add2' => $p['pdar_add2'],
                'pdar_strike' => $is_converted_pattadar,
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'is_converted_pattadar' => $is_converted_pattadar,
                'pdar_gender' => $pdar_gender,
                'pdar_mother' => $p['pdar_mother'],
                'pdar_pan_no' => $p['pdar_pan_no'],
                'pdar_citizen_no' => $p['pdar_citizen_no'],
                'pdar_aadharno' => $p['pdar_aadharno'],
                'pdar_mobile' => $pdar_mobile,
                'pdar_nrcno' => $p['pdar_nrcno'],
                'case_no' => $case_no
            );
            $this->db->insert("petitioner_part", $other_data);
        }
        $this->db->insert("petition_dag_details", $dags_data);
        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('message', 'Error in Processing !! Please try again !!Please Contact Help Desk !!');
            redirect(base_url() . 'index.php/home');
        } else {
            $this->db->trans_commit();
            $this->Dashboard($case_no);
            //  $this->db->trans_rollback();
            redirect(base_url() . 'index.php/Partition/PrintReport');
            //$this->load->view('../views/header');
            //$this->load->view('../views/partition/asstt_final_report');
            //$this->load->view('../views/footer');
        }
    }

    public function PrintReport() {
        // $this->load->view('../views/header');
        // $this->load->view('../views/partition/asstt_final_report');
        // $this->load->view('../views/footer');
        $data1['_view'] = 'partition/asstt_final_report';
        $this->load->view('layouts/main',$data1);
    }

    public function applicant_receipet() {
        //$db=  $this->session->userdata('db');
        $case_no = $this->session->userdata('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        $dist = $this->utilityclass->getDistrictName($dist_code);
        $cir = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $q = "Select * from    petition_basic where dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' and user_code='$user_code' and case_no = '$case_no'";
        $result = $this->db->query($q)->row();
        $mutation_type_name = $this->db->query("select order_type as mut_name from    master_office_mut_type where order_type_code = '$result->mut_type'")->row()->mut_name;
        $mut_type = $result->mut_type;
        $applicant_name = $this->db->query("select * from    petitioner_part where dist_code='$dist_code' and cir_code='$cir_code' and subdiv_code='$subdiv_code' and case_no = '$case_no' and petition_no='$result->petition_no'")->result();
        //var_dump($data);
        $amount_fees = $this->db->query("select order_amount as amount from    master_fees_mut_type where order_type_code = '$result->mut_type'")->row()->amount;
        $data = array(
            'user_code' => $user_code,
            'current_date' => date('Y-m-d G:i:s'),
            'next_due_date' => $result->date_entry,
            'total_fee_amt' => $amount_fees,
            'case_no' => $case_no,
            'mut_type' => $mut_type,
            'mutation_type_name' => $mutation_type_name,
            'district' => $dist,
            'circle' => $cir,
            'applicant_name' => $applicant_name
        );
        $data['_view'] = 'partition/applicant_receipet';
        $this->load->view('layouts/main',$data);
    }

    //     Applied Not yET
    public function AstPaymentConfirm() {
        //$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $sql = "SELECT * FROM  Petition_byayprak WHERE dist_code=" . $this->db->escape($dist_code) . " and subdiv_code=" . $this->db->escape($subdiv_code) . ""
                . " and cir_code=" . $this->db->escape($cir_code) . " and if_paid is null";
        $data['values'] = $this->db->query($sql)->result();
        $data['_view'] = 'partition/PaymentPending';
        $this->load->view('layouts/main',$data);
    }

    // NOT aPPLIED yET 
    public function AstNoticeConParty() {
        $db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $sql = "SELECT * FROM  Petition_byayprak WHERE dist_code=" . $this->db->escape($dist_code) . " and subdiv_code=" . $this->db->escape($subdiv_code) . ""
                . "and cir_code=" . $this->db->escape($cir_code) . "  and if_paid is null";
        $data['values'] = $this->db->query($sql)->result();
        $data['_view'] = 'partition/AssttNoticeConParty';
        $this->load->view('layouts/main',$data);
    }

    public function getPendingPayCases() {
        //$db=  $this->session->userdata('db');
        $data = array();
        $cases = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $config['base_url'] = base_url() . 'index.php/partition/getPendingPayCases';
        $c_q = "SELECT petition_no FROM  Petition_byayprak WHERE dist_code=" . $this->db->escape($dist_code) . " "
                . "and subdiv_code=" . $this->db->escape($subdiv_code) . " and cir_code=" . $this->db->escape($cir_code) . " and if_paid is null ";
        //$cases = $this->db->query($c_q)->result();
        $sql = "Select * from    petition_basic where dist_code=" . $this->db->escape($dist_code) . " "
                . "and subdiv_code=" . $this->db->escape($subdiv_code) . " and cir_code=" . $this->db->escape($cir_code) . " and status='P' and mut_type='04' and  pay_notice_gen_yn='Y' and petition_no in ($c_q) ";
        $data['casess']=$this->db->query($sql)->result_array();
        if (sizeof($data) == 0) {
            $this->session->set_flashdata('message', 'No Data found ..! Data are deleted from    datbase !<br> Please contact administrator and delete junk data !');
            redirect(base_url() . "index.php/Home/");
        }
        $data['_view'] = 'partition/AssttNoticeConParty';
        $this->load->view('layouts/main',$data);
    }

    public function AstReportGen() {
        //$db=  $this->session->userdata('db');
        $petition_no = $this->input->get('case');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $sql = "Select * from    petition_basic where petition_no=" . $this->db->escape($petition_no) . " and mut_type='04' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
        $data = $dataa['details'] = $this->db->query($sql)->row();
        $sql = "Select * from    petition_byayprak WHERE dist_code = '$data->dist_code' and subdiv_code = '$data->subdiv_code' and cir_code = '$data->cir_code' and mouza_pargona_code = '$data->mouza_pargona_code' and lot_no = '$data->lot_no'"
                . " and vill_townprt_code = '$data->vill_townprt_code' and petition_no='$data->petition_no' ";
        $dataa['values'] = $this->db->query($sql)->row();

        $this->session->set_userdata('case_no',$data->case_no);

        $dataa['_view'] = 'partition/AssttPayConfirm';
        $this->load->view('layouts/main',$dataa);
    }

    public function UpdateByaPrak() {
        //$db=  $this->session->userdata('db');
        $data = array('if_paid' => 'Y');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $petition_no = $this->input->post('petition_no');
        $this->db->where('petition_no', $petition_no);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->update("petition_byayprak", $data);
        $data = array('pay_notice_gen_yn' => 'Y');
        $this->db->where('petition_no', $petition_no);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->update("petition_basic", $data);
        /////////////Dashboard/////////////////
        $penUser='CO';
        $rmrk='Payment Received';
       $case_no=$this->session->userdata('case_no');

        $this->DashboardData($case_no,$penUser,$rmrk);
        //////////////////
        $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
        if($basundhara){
            $rmk='Payment Received';
            $status='M';
            $task='AST';
            $pen='CO';
            $case=$case_no;
            $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
        }
        //////////////////////////////
        $this->session->set_flashdata('message', 'Byay Prak report updated');
        redirect(base_url() . 'index.php/home');
    }

    public function getPendingNoticeGenerationOld() {
        //$db=  $this->session->userdata('db');
        //$this->load->library('pagination');
        $data = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $cases = $this->db->query("SELECT pb.*,ba.basundhara as rtps FROM  Petition_basic pb 

            left join basundhar_application ba on pb.case_no = ba.dharitree

         WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                        . "and not_fresh='Y' and status ='P' and mut_type='04' and (notice_generated_yn is null or notice_generated_yn='' ) order by petition_no")->result();
        $data['cases'] = $cases;

        $data['_view'] = 'partition/AstNotice';
        $this->load->view('layouts/main',$data);
    }

    public function getPendingPayNoticeGeneration() {
        $data = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $cases = $this->db->query("SELECT * FROM  Petition_basic WHERE dist_code='$dist_code' and "
                        . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and notice_served_yn!='Y'  and pay_notice_gen_yn='Y' and status='P' and not_fresh='Y' and mut_type='04'")->result();
        $data['cases'] = $cases;
        $data['_view'] = 'partition/AstNotice';
        $this->load->view('layouts/main',$data);
    }

    public function ByayNoticeGenerate() {
        //$db=  $this->session->userdata('db');
        $data = array();
        $petition_no = $this->input->get('pid');
        $case_no = $this->input->get('case');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $sql = "Select * from    petition_byayprak where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code'  and  petition_no=" . $this->db->escape($petition_no) . "";

        $data['byayprak'] = $this->db->query($sql)->row();
        $sql = "Select case_no as case from    petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code'  and  petition_no=" . $this->db->escape($petition_no) . " and mut_type='04' ";
        $data['case'] = $this->db->query($sql)->row();
        $values = array('notice_served_yn' => 'Y', 'notice_generated_yn' => 'Y');
        $this->db->where('petition_no', $petition_no);
        $this->db->where('case_no', $case_no);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->update('petition_basic', $values);
        $data['_view'] = 'partition/ByayprakNotice';
        $this->load->view('layouts/main',$data);
    }

    public function NoticeSubmit() {
        //$db=  $this->session->userdata('db');
        $petition_no = $this->input->get('id');
        $case_no = $this->input->get('case');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $sql = "select * from    petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code' and case_no='$case_no' and petition_no=" . $this->db->escape($petition_no) . " ";
        $pb = $data['pb'] = $this->db->query($sql)->row();
        if($pb->application_ref_no!=null){
            $data['mobile_no']=$this->ServicePlusModel->rtpsMobile($pb->application_ref_no);
        }
        $sql = "SELECT * FROM  Petition_notified WHERE dist_code = '$pb->dist_code' and subdiv_code = '$pb->subdiv_code' and cir_code = '$pb->cir_code' and mouza_pargona_code = '$pb->mouza_pargona_code'"
                . " and lot_no = '$pb->lot_no' and vill_townprt_code = '$pb->vill_townprt_code' and Petition_no = '$pb->petition_no'";

        $data['notify'] = $this->db->query($sql)->row();
        $sql = "SELECT * FROM  Petitioner_part WHERE dist_code = '$pb->dist_code' and subdiv_code = '$pb->subdiv_code' and cir_code = '$pb->cir_code' and mouza_pargona_code = '$pb->mouza_pargona_code'"
                . " and lot_no = '$pb->lot_no' and vill_townprt_code = '$pb->vill_townprt_code' and Petition_no = '$pb->petition_no'";

        $data['partition'] = $this->db->query($sql)->result();
        $sql = "SELECT * FROM  petition_dag_details WHERE dist_code = '$pb->dist_code' and subdiv_code = '$pb->subdiv_code' and cir_code = '$pb->cir_code' and mouza_pargona_code = '$pb->mouza_pargona_code'"
                . " and lot_no = '$pb->lot_no' and vill_townprt_code = '$pb->vill_townprt_code'  and Petition_no = '$pb->petition_no'";
        $pet = $data['dag'] = $this->db->query($sql)->row();
        $sql = "SELECT * FROM  Chitha_dag_pattadar WHERE dist_code = '$pb->dist_code' and subdiv_code = '$pb->subdiv_code' and cir_code = '$pb->cir_code' and mouza_pargona_code = '$pb->mouza_pargona_code'"
                . " and lot_no = '$pb->lot_no' and vill_townprt_code = '$pb->vill_townprt_code' and TRIM(patta_no) = trim('$pet->patta_no') and patta_type_code = '$pet->patta_type_code' and dag_no='$pet->dag_no' and (p_flag ='0' or p_flag is null)";
        $dagpattadar = $this->db->query($sql)->result();
        foreach ($dagpattadar as $p) {
            $sql = "SELECT * FROM  Chitha_pattadar WHERE dist_code = '$pb->dist_code' and subdiv_code = '$pb->subdiv_code' and cir_code = '$pb->cir_code' and mouza_pargona_code = '$pb->mouza_pargona_code'"
                    . " and lot_no = '$pb->lot_no' and vill_townprt_code = '$pb->vill_townprt_code' and TRIM(patta_no) = trim('$pet->patta_no') and patta_type_code = '$pet->patta_type_code' and pdar_id='$p->pdar_id' ";
            //echo $sql;
            $data['pattadar'][] = $this->db->query($sql)->result();
        }

        $sql = "Select loc_name as cirname from    location where dist_code = '$pb->dist_code' and subdiv_code = '$pb->subdiv_code' and cir_code = '$pb->cir_code' and mouza_pargona_code = '00' and lot_no='00' and vill_townprt_code='00000'";
        $data['cirname'] = $this->db->query($sql)->row();
        $sql = "SELECT loc_name as mouza FROM  location WHERE dist_code = '$pb->dist_code' and subdiv_code = '$pb->subdiv_code' and cir_code = '$pb->cir_code' and mouza_pargona_code = '$pb->mouza_pargona_code' and lot_no='00' and vill_townprt_code='00000'";
        $data['mouza'] = $this->db->query($sql)->row();
        $sql = "SELECT loc_name as vill FROM  location WHERE dist_code = '$pb->dist_code' and subdiv_code = '$pb->subdiv_code' and cir_code = '$pb->cir_code' and mouza_pargona_code = '$pb->mouza_pargona_code' and lot_no='$pb->lot_no' and vill_townprt_code='$pb->vill_townprt_code'";
        $data['vill'] = $this->db->query($sql)->row();
        $sql = "SELECT patta_type as name from    patta_code where type_code='$pet->patta_type_code'";
        $data['PName'] = $this->db->query($sql)->row();

        if(in_array($dist_code, json_decode(BARAK_VALLEY))){
        $data['_view'] = 'partition/printpetitioner_kar';
        }
        else{
            $data['_view'] = 'partition/printpetitioner';
        }

        $this->load->view('layouts/main',$data);
    }

    public function SaveNotcPetioner() {
         //xss & security validation starts
         $errorMessageStr = '';
         $POST_REQUEST = $_POST;
         unset($POST_REQUEST['pageContent']);
         $resp = checkRequestSpecChar($POST_REQUEST);
         if($resp['status'] == 'n'){
             $errorMessageStr .= $resp['messages'];
         }
         $resp = checkRequestValidQuery($POST_REQUEST);
         if($resp['status'] == 'n'){
             $errorMessageStr .= $resp['messages'];
         }    
         if($errorMessageStr != ''){
            $this->session->set_flashdata('message', $errorMessageStr);
             return redirect($_SERVER['HTTP_REFERER']);
         }
        //xss & security validation ends 
        $case_no = $this->input->post('case_no');
        /////////////FILE UPLOAD//////////
        $this->load->model('FileUpload_model');
        $result = $this->FileUpload_model->save_notice(($_POST['pageContent']), $case_no);
        ///////////////////////////
        $this->db->trans_begin();
        $data = array('notice_generated_yn' => 'Y', 'notice_generated_date' => date('Y-m-d G:i:s'));
        $this->db->where('case_no', $case_no);
        $this->db->update("petition_basic", $data);

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        //ESCALATION CODE INTEGRATION================SANMRI

        $executionDate = $this->input->post('executionDate');
        $queryForUpdate = "select next_date_of_hearing,es_flag,out_of_esc from petition_basic where case_no='$case_no'";

        $hearingDateDetails = $this->db->query($queryForUpdate)->row();
        // log_message('error',"LAST QUERY===============".$this->db->last_query());
        // log_message('error',"DATE OF HEARING =========".json_encode($hearingDateDetails));
        if($hearingDateDetails->es_flag == 1 && ESCALATION_ENABLE ==1 && $hearingDateDetails->out_of_esc == 0){

            $user_code = $this->session->userdata('user_code');
            $escRow = $this->Escalationmodel->getEscalatedRowDetailsBasic($case_no);
            // as the escalation removed from notice print BHRIGU DA/MRIDU SIR////////////////decided on 20-11-2024
            if($escRow->registerd_on < NOTICE_REMOVED_DATE_OMUT_OPART)
            {
                // $escalationUpdateStatus = $this->Escalationmodel->escalationDANoticeOPART($executionDate,$dist_code,$subdiv_code,$cir_code,$case_no,$user_code,$hearingDateDetails->next_date_of_hearing);

                // log_message("error", "#ESC877, transaction-error-STATUS======".json_encode($escalationUpdateStatus));
                // if($escalationUpdateStatus['responseType'] == 0){
                //     $this->db->trans_rollback();
                //     log_message("error", "#ESC877, transaction-error in method 'Partition/SaveNotcPetioner' with case-no :". $case_no);
                //     $this->session->set_flashdata('message', "Something went wrong.OPART- Error Code(#ESC877)");
                //     redirect(base_url() . "index.php/home");
                // }
            }
            
        }
        $this->db->trans_commit();
        ///////////////END ESCALATION//////////////

          //////////////////////////////////////
        $penUser='LM';
        $rmrk='Notice Served By Assistant';
        $this->DashboardData($case_no,$penUser,$rmrk);
        ///////////////////////

        // $rmk='Notice Served By Assistant';
        // $status='M';
        // $task='AST';
        // $pen='LM';
        // $case=$case_no;
        // $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
        ///////////////////////////////////////////
        $this->session->set_flashdata('message', 'Notice has Served !!');
        redirect(base_url() . 'index.php/home/index');
    }

    public function getPendingProceeReportOld() {
        //$db=  $this->session->userdata('db');
        $this->load->library('pagination');
        $data = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $define_date = define_date;

        $cases = $this->db->query("select *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'"
                        . "  and not_fresh='Y' and  status='P' and mut_type='04' and date_entry>='$define_date' and (proceeding_yn is null or proceeding_yn='') order by petition_no ")->result();
        $data['cases'] = $cases;
        // $this->load->view('../views/header');
        // $this->load->view('../views/partition/NoteactionFirst', $data);
        // $this->load->view('../views/footer');
         $data['_view'] = 'partition/NoteactionFirst';
        $this->load->view('layouts/main',$data);
    }

    public function AsstActionTaken() {
        //$db=  $this->session->userdata('db');
        $case_no = $this->input->get('case');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $sql = "SELECT * FROM  Petition_Basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  case_no = " . $this->db->escape($case_no) . "";
        //echo $sql;
        $pb = $data['pb'] = $this->db->query($sql)->row();
        $location = $this->utilityclass->getLocationFromSession();
        $dist_name = $this->utilityclass->getDistrictName($pb->dist_code);
        $data['NameDist'] = array('dist' => $dist_name);
        $sql = "SELECT MIN(date_of_hearing) as stdate FROM  Petition_Proceeding Where case_no=" . $this->db->escape($case_no) . " and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
        $data['stdate'] = $this->db->query($sql)->row();
        $sql = "SELECT MAX(date_of_hearing) as endate FROM  Petition_Proceeding Where case_no=" . $this->db->escape($case_no) . " and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
        $data['endate'] = $this->db->query($sql)->row();
        $this->db->select('*');
        $this->db->from('petition_proceeding');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('case_no', $case_no);
        $this->db->like('user_code', 'CO', 'after');   // user_code LIKE 'CO%'
        $this->db->where('note_on_order IS NULL', null, false); // IS NULL check (CI2 style)
        $query = $this->db->get();
        if ($query && $query->num_rows() > 0) {
            $data['pd'] = $query->result();   // single object
        } else {
            $data['pd'] = null; // no record found
        }
        $data['_view'] = 'partition/NoteactionSec';
        $this->load->view('layouts/main',$data);
    }

    public function SaveNoteAction() {
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
        $case_no = $this->input->post('case_no');
        $proceeding_id = $this->input->post('proceeding_id');
        $note_on_order = $this->input->post('note_on_order');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;

        $this->db->trans_begin();
        //////////////UPLOAD ATTACHMENT//////////////////////
        if (empty($_FILES['upload_consent_report']['name'])) {
                echo "Error: No file selected!";
                return;
        }
        $this->load->model('FileUpload_model');
        $result = $this->FileUpload_model->upload_file('upload_consent_report', $case_no);
        if ($result['status']) {
            log_message('error',"FILES-SAVED-SUCCESSFULLY###$case_no".$result['data']['file_name']);
        } else {
            $this->session->set_flashdata('message', "ERROR IN UPLOADING FILE".$result['error']);
            return redirect($_SERVER['HTTP_REFERER']);
        }

        $notice_count=$this->db->query("Select * from petition_basic where case_no=? and not_fresh='Y' and mut_type='04' and status != 'F' and proceeding_yn is null and notice_generated_yn is null",array($case_no));
        if($notice_count->num_rows()>0){
            $this->db->trans_rollback();
            $data=array(
                'error'=>"#ERROPART-NOTICE-SERVE-EMPTY-984 : Error in submitting . Please Serve Notice First After that you should be allowed to report action-taken-report"
            );
            echo json_encode($data);
            return false;
        }



        $count = count($proceeding_id);
        for ($i = 0; $i < $count; $i++) {
            $data = array('note_on_order' => $note_on_order[$i], 'user_code' => $user_code);
            $this->db->where('case_no', $case_no);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('proceeding_id', $proceeding_id[$i]);
            $this->db->update("petition_proceeding", $data);
        }
        $value = array('proceeding_yn' => '1');
        $this->db->where('case_no', $case_no);
        //$this->db->where('year_no', $year_no);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->update("petition_basic", $value);




        //ESCALATION CODE INTEGRATION================SANMRI
        $query1 = "select es_flag,out_of_esc from petition_basic where case_no='$case_no'";
        $data = $this->db->query($query1)->row();
        if($data->es_flag == 1 && ESCALATION_ENABLE ==1 && $data->out_of_esc == 0){
            $executionDate = $this->input->post('executionDate');
            $user_code = $this->session->userdata('user_code');
            $escalationUpdateStatus = $this->Escalationmodel->escalationDAActionOPART($executionDate,$dist_code,$subdiv_code,$cir_code,$case_no,$user_code);
            log_message("error", "#ESC1008, transaction-error-STATUS======".json_encode($escalationUpdateStatus));
            if($escalationUpdateStatus['responseType'] == 0){
                $this->db->trans_rollback();
                log_message("error", "#ESC1008, transaction-error in method 'Partition/SaveNoteAction' with case-no :". $case_no);
                $this->session->set_flashdata('message', "Something went wrong.OPART- Error Code(#ESC1008)");
                redirect(base_url() . "index.php/home");
            }
            
        }
        $this->db->trans_commit();

        //////////////////////////////////////
        $penUser='LM';
        $rmrk='Action Taken Report By Assistant';
        $this->DashboardData($case_no,$penUser,$rmrk);

        $this->session->set_flashdata('message', 'Action Taken Report Submitted');
        redirect(base_url() . 'index.php/home/index');
    }

    public function getPendingIstharReport() {
        $this->load->library('pagination');
        //$db=  $this->session->userdata('db');
        $data = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $sql = "SELECT case_no from    petitioner_part pb "
                . "WHERE pb.dist_code='$dist_code' and pb.subdiv_code='$subdiv_code' and pb.cir_code='$cir_code'  ";

        $cases = $this->db->query("SELECT pb.* FROM  Petition_Basic as pb  "
                        . "WHERE pb.dist_code='$dist_code' and pb.subdiv_code='$subdiv_code' and pb.cir_code='$cir_code' and pb.mut_type='04' and pb.order_passed='Y' and pb.status='F' and pb.isthar_update is null and case_no in ($sql) order by pb.petition_no ")->result();
        $data['cases'] = $cases;
        //$this->load->view('../views/header');
        //$this->load->view('../views/partition/Isthar_case', $data);
        //$this->load->view('../views/footer');

        $data['_view'] = 'partition/Isthar_case';
        $this->load->view('layouts/main',$data);
    }

    public function IstharReport() {
        $data = array();
        $case_no = $this->input->get('case');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $q = "Select * from    petition_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and case_no='$case_no' and isthar_update is null ";
        //echo $q;
        $data['pb'] = $pb = $this->db->query($q)->row();
        $q = "Select * from    petitioner_part where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and petition_no='$pb->petition_no' ";
        $data['pp'] = $this->db->query($q)->result();
        $q = "Select * from    petition_dag_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and petition_no='$pb->petition_no' ";
        $data['pd'] = $this->db->query($q)->row();
        $q = "Select * from    t_chitha_rmk_infavor_of where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and petition_no='$pb->petition_no' "
                . "and ord_no='$pb->case_no' and iscorrected_inco='Y' ";
        //echo $q;
        $pbdata = $data['isdata'] = $this->db->query($q)->row();
        //$this->load->view('../views/header');
        //$this->load->view('../views/partition/IstharReport', $data);
        //$this->load->view('../views/footer');

        $data['_view'] = 'partition/IstharReport';
        $this->load->view('layouts/main',$data);
    }

    public function IstharReportUpdate() {
        if (isset($_POST['btn'])) {
            //var_dump($this->session->all_userdata());
            $case_no = $this->input->post('case_no');
            $petition_no = $this->input->post('petition_no');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $db=  $this->session->userdata('db');
            $year_no = year_no; //date('Y');
            $data = array(
                'isthar_update' => 'Y'
            );
            $this->db->where('case_no', $case_no);
            $this->db->where('petition_no', $petition_no);
            // $this->db->where('year_no', $year_no);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->update("petition_basic", $data);
            $this->session->set_flashdata('message', "Isthar Report Updated Successfully");
            redirect(base_url() . "index.php/home");
        }
    }

    /*
     *  ----------------------------------------**********End Of Asstt Part***********---------------------------------------------
     * ----------------------------------------********** Start CO Part***********---------------------------------------------
     */

    public function COPartition() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $q = " SELECT count(dist_code) as total_case FROM  Petition_basic WHERE  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='04' and not_fresh is null and lm_note_yn is null ";
        $data['case'] = $this->db->query($q)->result();
        $q = $this->db->query("SELECT * FROM  Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='04' and not_fresh is null and lm_note_yn is null ");
        $data['result'] = $q->result();
        $q = "SELECT * FROM  Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and not_fresh = 'Y' and status='P' order by next_date_of_hearing";
        $data['secondR'] = $this->db->query($q)->result();
        $sql = "SELECT count(petition_no) as sec_total FROM  Petition_basic WHERE  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and not_fresh = 'Y' and status='P'";
        $data['sec_total'] = $this->db->query($sql)->row();
        //$this->load->view('../views/header');
        //$this->load->view('../views/partition/co_partitino_1', $data);
        //$this->load->view('../views/footer');

        $data['_view'] = 'partition/co_partitino_1';
        $this->load->view('layouts/main',$data);
    }

    public function CoPendingFirst() {
        $this->dbswitch();
        $data = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        //$db=  $this->session->userdata('db');
        $year_no = year_no;
        // $cases = $this->db->query("select *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where  dist_code='$dist_code' and (status!='D' or status is null ) and subdiv_code='$subdiv_code' "
        //                 . "and cir_code='$cir_code' and mut_type='04' and co_user_code='$user_code' and (not_fresh is null or not_fresh='')"
        //                 . " and (lm_note_yn is null or lm_note_yn='') order by petition_no ")->result();
        // $data['cases1'] = $cases;
        // $case_array = array();
        // foreach ($data['cases1'] AS $d) {
        //     $sql = "SELECT * FROM  Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' "
        //             . "and cir_code='$cir_code' and status!='D' and mut_type='04' and co_user_code='$user_code' and (not_fresh is null or not_fresh='')"
        //             . " and (lm_note_yn is null or lm_note_yn='')";
        //     $q = $this->db->query($sql)->row();
        //     array_push($case_array, $d);
        // }
        // $data['cases'] = $case_array;

        $villageListNew = array();
        $villageList = $this->mutationmodel->getAllDistinctVillageListOP($dist_code,$subdiv_code,$cir_code,$user_code);
            foreach ($villageList as $key => $value) {
                $villageListNew[$key]['village_code'] = $value->mouza_pargona_code."-".$value->lot_no."-".$value->vill_townprt_code;
                $villageListNew[$key]['vill_name'] = $this->utilityclass->getVillageName($value->dist_code,$value->subdiv_code,$value->cir_code,$value->mouza_pargona_code,$value->lot_no,$value->vill_townprt_code);
             }
        $uniqueVillage = array_map("unserialize", array_unique(array_map("serialize", $villageListNew)));
        $data['villageListNew'] =  $uniqueVillage;
        $newMouzaList = array();
            foreach ($villageList as $key => $value) {
                $newMouzaList[$key]['mouza_code'] = $value->mouza_pargona_code;
                $newMouzaList[$key]['mouza_name'] = $this->utilityclass->getMouzaName($value->dist_code,$value->subdiv_code,$value->cir_code,$value->mouza_pargona_code);
                $newMouzaList[$key]['lot_name'] = $this->utilityclass->getLotName($value->dist_code,$value->subdiv_code,$value->cir_code,$value->mouza_pargona_code,$value->lot_no);
                $newMouzaList[$key]['lot_no'] = $value->lot_no;
        }
        $uniqueMouzaList = array_map("unserialize", array_unique(array_map("serialize", $newMouzaList)));
        $data['newMouzaList'] = $uniqueMouzaList;
        $data['_view'] = 'partition/PendingFresh';
        $this->load->view('layouts/main',$data);
    }



    public function FirstProceding() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $case_no = $this->input->get('case_no');
        $case_no = $_GET['case_no'] = dec_param($this->input->get('case_no'), 'case_no');
        if($_GET['case_no'] == null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }

        $FirstData = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code1' => $this->input->get('mouza_pargona_code'),
            'lot_no1' => $this->input->get('lot_no'),
            'vill_townprt_code1' => $this->input->get('vill_townprt_code'),
            'case_no' => $case_no
        );
        $this->session->set_userdata($FirstData);
        redirect(base_url() . 'index.php/partition/FirstPreeceding');
    }

    public function FirstPreeceding() {
        $data = array();
        //$db=  $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $case_no = $this->session->userdata('case_no');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code1');
        $lot_no = $this->session->userdata('lot_no1');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code1');
        $year_no = year_no;
        $q = "select * from    Petition_basic where dist_code=" . $this->db->escape($dist_code) . " and subdiv_code=" . $this->db->escape($subdiv_code) . " and cir_code=" . $this->db->escape($cir_code) . " "
                . "and case_no=" . $this->db->escape($case_no) . " and mut_type='04' and mouza_pargona_code =" . $this->db->escape($mouza_pargona_code) . " and lot_no =" . $this->db->escape($lot_no) . " and vill_townprt_code =" . $this->db->escape($vill_townprt_code) . " ";
        $part = $data['petition'] = $this->db->query($q)->row();
        $m = array('mouza_pargona_code' => $mouza_pargona_code, 'lot_no' => $lot_no, 'vill_townprt_code' => $vill_townprt_code);
        $this->session->set_userdata($m);
        $data['partioner'] = $this->db->query("select * from    petitioner_part where  petition_no=" . $this->db->escape($part->petition_no) . "    ")->result_array();
        $q = "select * from    petition_dag_details "
                . "where petition_no='$part->petition_no' and dist_code='$part->dist_code' and "
                . " cir_code = '$part->cir_code' and subdiv_code='$part->subdiv_code' and "
                . " mouza_pargona_code = '$part->mouza_pargona_code' and lot_no = '$part->lot_no' and "
                . " vill_townprt_code = '$part->vill_townprt_code' ";
        $data['dags'] = $this->db->query($q)->result();
        $sql = "select * from    petitioner_part "
                . "where petition_no='$part->petition_no' and dist_code='$part->dist_code' and "
                . " cir_code = '$part->cir_code' and subdiv_code='$part->subdiv_code' and "
                . " mouza_pargona_code = '$part->mouza_pargona_code' and lot_no = '$part->lot_no' and "
                . " vill_townprt_code = '$part->vill_townprt_code' ";
        $data['PetiPart'] = $this->db->query($sql)->result();
        $dist_code = $this->utilityclass->getDistrictName($part->dist_code);
        $subdiv_code = $this->utilityclass->getSubDivName($part->dist_code, $part->subdiv_code);
        $cir_code = $this->utilityclass->getCircleName($part->dist_code, $part->subdiv_code, $part->cir_code);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($part->dist_code, $part->subdiv_code, $part->cir_code, $part->mouza_pargona_code);
        $lot_no = $this->utilityclass->getLotName($part->dist_code, $part->subdiv_code, $part->cir_code, $part->mouza_pargona_code, $part->lot_no);
        $vill_townprt_code = $this->utilityclass->getVillageName($part->dist_code, $part->subdiv_code, $part->cir_code, $part->mouza_pargona_code, $part->lot_no, $part->vill_townprt_code);


        if(ESCALATION_ENABLE == 1){
            $sql112="Select * from petitioner_part where petition_no = ? and auth_type is not null";
            $petitioner = $this->db->query($sql112,array($part->petition_no))->result();
            $data['base64_decoded_adhar_file'] = "";
            $data['selfDecData'] = null;
            if(!empty($petitioner) && $petitioner != null){
                
                if($petitioner[0]->self_declaration != null){
                $data['selfDecData'] = json_decode($petitioner[0]->self_declaration);
                }
                

                if($petitioner[0]->auth_type !=null){
                    $statusAadhar = "<i class='fa fa-check'></i> ".$petitioner[0]->auth_type. " Verified";
                    $aadhaarData = json_decode($petitioner[0]->applicant_info);
                    $engName = $aadhaarData->pat_name_eng;
                }else{
                    $statusAadhar = 'N/A';
                    $engName = null;
                }
                
            

                $data['status'] = $statusAadhar;
                $data['engName'] = $engName;

                $application_no_sql="select * from basundhar_application where dharitree=? ";
                $data['application'] = $this->db->query($application_no_sql,array($part->case_no))->row();

                
                if (!empty($petitioner) && $petitioner !=null && trim($petitioner[0]->auth_type) == 'AADHAAR' ):

                        $adhar_photo_link = $petitioner[0]->photo;
                        if($adhar_photo_link == null)
                        {
                            $url = RTPS_API_LINK."getApplicantPhoto";
                            $arrayData =array(
                                'application_no' => $data['application']->basundhara,
                            );
                            //*****API call again for aadhar photo missing */
                            $aadhaarPhotoReCall = $this->utilityclass->curlPost($url, $arrayData);
                            if($aadhaarPhotoReCall != 'n')
                            {
                                $aadhaarPhotoDetails = json_decode($aadhaarPhotoReCall);
                                $aadhar_path = AADHAAR_UPLOAD_DIR. $petitioner[0]->id_ref_no . '.json';
                                $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file!");
                                $aadhaar_encoded_file = $aadhaarPhotoDetails->path;
                                fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                                fclose($aadhaar_file_to_write_base64);
               

                                $query = "update petitioner_part set photo = ? where case_no=? and id_ref_no = ? and auth_type is not null";
               
                                $this->db->query($query,array($aadhar_path,$part->case_no,$petitioner[0]->id_ref_no));
             
                               
                                $adhar_photo_link = $aadhar_path;
                                
                            }
                            else
                            {
                                echo json_encode(array('ERROR885784: API Response fail!'));
                                return false;
                            }


                        }
                        //**********reopening the updated file */
                        $open_adhar_file = fopen($adhar_photo_link, "r") or die("Unable to open file!");
                        $read_adhar_file = fread($open_adhar_file, filesize($adhar_photo_link));
                        fclose($open_adhar_file);
                        // decoding the base64 encoding file variable
                        $data['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($read_adhar_file).";base64,".$read_adhar_file." class='img-thumbnail mrl' alt='Aadhaar Photo' width='170' height='200'>";
              
                    
                endif;
                }
            }
        
        




            








        $data['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code, 'lot' => $lot_no,
            'vill' => $vill_townprt_code
        );
        $data['attachment'] = '';
        //var_dump($part->application_ref_no);
        if($part->application_ref_no){
            $url =RTPS_LINK. "partition/partition_attachment_details.php?application_ref_no=" . $part->application_ref_no . "&applid=" . $part->applid;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            $output = curl_exec($ch);
            curl_close($ch);
            $output = json_decode($output); 
            $data['attachment'] = $output;
            //var_dump($data['attachment']);
        }
        $data['basuCase']=null;
        $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($part->case_no);
        if($basundharaExist){
            $data['query']=null;
            $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($part->case_no);
            $data['query']=$this->basundharamodel->QueryPost($basundharaExist);
        }


        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
            $this->load->model('propChain/PropChainModel');
            ///////////////////////////////////////// Property chain code ///////////////////////////////////////////////////
            if ($data['petition']->comp_serv_yn == 'Y') {
                $dag_area_b = $data['dags'][0]->m_dag_area_b;
                $dag_area_k = $data['dags'][0]->m_dag_area_k;
                $dag_area_lc = $data['dags'][0]->m_dag_area_lc;
                $dag_area_g = $data['dags'][0]->m_dag_area_g;
            } else {
                $dag_area_b = $data['dags'][0]->dag_area_b;
                $dag_area_k = $data['dags'][0]->dag_area_k;
                $dag_area_lc = $data['dags'][0]->dag_area_lc;
                $dag_area_g = $data['dags'][0]->dag_area_g;
            }

            $checkPropAndChithaAndUlpn = $this->PropChainModel->chainChithaUlpinCheckProcess($data['petition']->dist_code, $data['petition']->subdiv_code, $data['petition']->cir_code, $data['petition']->mouza_pargona_code, $data['petition']->lot_no, $data['petition']->vill_townprt_code, $data['dags'][0]->patta_no, $data['dags'][0]->dag_no,  $dag_area_b, $dag_area_k, $dag_area_lc, $dag_area_g, $data['dags'][0]->patta_type_code);

            // update flag in field_mut_basic
            if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'Y' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'NE') {
                $this->PropChainModel->updateCmpFlag($case_no, $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag']);

                // get view mismatch case button
                if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N') {
                    $data['viewMisMatchBtn'] = $this->PropChainModel->getMismatchBtn($case_no, $data['petition']->dist_code, $data['petition']->subdiv_code, $data['petition']->cir_code, $data['petition']->mouza_pargona_code, $data['petition']->lot_no, $data['petition']->vill_townprt_code, $data['dags'][0]->patta_no, $data['dags'][0]->dag_no, $dag_area_b, $dag_area_k, $dag_area_lc, $dag_area_g, $data['dags'][0]->patta_type_code);
                }
            }
            // echo "<pre>";
            // var_dump($data['petition']->comp_serv_yn);
            // die;
            $data['ulpinCheck'] = $checkPropAndChithaAndUlpn['ulpinCheck'];
            $data['ulpinMsg'] = $checkPropAndChithaAndUlpn['ulpinMsg'];

            if ($data['ulpinCheck'] == 1) {
                $data['ulpin'] = $checkPropAndChithaAndUlpn['ulpin'];
                if (isset($checkPropAndChithaAndUlpn['old_ulpin']))
                    $data['old_ulpin'] = $checkPropAndChithaAndUlpn['old_ulpin'];
                else
                    $data['old_ulpin'] = "";
            }

            // if property does not exists get create asset button
            if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'NE') {
                $data['createPropChainBtn'] = $checkPropAndChithaAndUlpn['createPropChainBtn'];
            }
            $data['chithaPropChainCmpFlag'] = $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'];
            $data['compareFlagMsg'] = $checkPropAndChithaAndUlpn['compareFlagMsg'];
            $data['revenue'] = $checkPropAndChithaAndUlpn['revenue'];
            $data['local_tax'] = $checkPropAndChithaAndUlpn['local_tax'];
            // hidden fields
            $data['ulpin_hidden'] = $checkPropAndChithaAndUlpn['ulpin_hidden'];
            $data['uplpin_msg_hidden'] = $checkPropAndChithaAndUlpn['uplpin_msg_hidden'];
            $data['compare_hidden'] = $checkPropAndChithaAndUlpn['compare_hidden'];
            $data['compare_msg_hidden'] = $checkPropAndChithaAndUlpn['compare_msg_hidden'];

            // bhunaksha area cmp
            $data['bhuChithaCmpStatus'] = $checkPropAndChithaAndUlpn['bhuChithaCmpStatus'];
            $data['bhuChithaCmpMsg'] = $checkPropAndChithaAndUlpn['bhuChithaCmpMsg'];
            $data['bhu_hidden'] = $checkPropAndChithaAndUlpn['bhu_hidden'];
            $data['bhu_compare_msg_hidden'] = $checkPropAndChithaAndUlpn['bhu_compare_msg_hidden'];
            $data['propChainEnableFlag'] = $this->PropChainCommonModel->isLocationEnable($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code);
        }


        //ESCALATED CASES REMARK ENTRY FORM==============
        if(ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE == 1 && $part->es_flag == 1 && $part->out_of_esc == 0)
        {
            $remainingTime = $this->Escalationmodel->calculateRemainingTime($case_no,$this->session->userdata('user_desig_code'));
            $data['remainingTime'] = $remainingTime;
            $escRemarkData = $this->Escalationmodel->getEscalationRemarkDetails($case_no,$this->session->userdata('user_desig_code'),$this->session->userdata('user_code'));
            if(isset($escRemarkData) && !empty($escRemarkData))
            {
                $data['escRemarkData'] = $escRemarkData;
            }
        }
        ///END REMARKS/////////


        $data['_view'] = 'partition/proceeding_co_1';
        $this->load->view('layouts/main',$data);
    }

    public function savePartionCO1() {

      // var_dump($_POST); die;

        //xss & security validation starts
         $errorMessageStr = '';
	 $check_date=$_POST;
	 unset($check_date['COorder']);
         $resp = checkRequestSpecChar($check_date);
         if($resp['status'] == 'n'){
             $errorMessageStr .= $resp['messages'];
         }
         $resp = checkRequestValidQuery($check_date);
         if($resp['status'] == 'n'){
             $errorMessageStr .= $resp['messages'];
         }  
         $_POST=$_POST;
         // $resp = $this->checkAuthenticationAndValidationOpart1($_POST);
         // if($resp['responseType'] == 1)
         // {
         //    $errorMessageStr .= $resp['message'];
         // } 
         
         if($errorMessageStr != ''){
            $this->session->set_flashdata('message', $errorMessageStr);
             return redirect($_SERVER['HTTP_REFERER']);
         }


        //xss & security validation ends         
        $dataa = array();
        $rtps=null;
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $db=  $this->session->userdata('db');
        $case_no = $this->input->post('case_no');
        $year_no = year_no;
        $next_date = $this->input->post('next_date');
        $next_date1 = explode('/', $next_date);
        $next_date_input = $next_date1[2] . "-" . $next_date1[1] . "-" . $next_date1[0];

        $condOnHearing = $this->Escalationmodel->checkHearingDate($next_date, $case_no, 'petition_basic');
        if($condOnHearing['response'] == 1){
          $this->db->trans_rollback();
          log_message("error", $condOnHearing['message']);
          $this->session->set_flashdata('message', $condOnHearing['message']);
          redirect(base_url() . "index.php/home");
        }

        if(ESCALATION_ENABLE ==1 )
        {
            $esData=$this->db->query("Select es_flag,mouza_pargona_code,lot_no from petition_basic where case_no=? ",array($case_no))->row();
            if($esData->es_flag == 1 && ESCALATION_ENABLE ==1)
            {
                $next_date_input = $next_date_input . " ".  date('H:i:s');
            }
        }
        $status = $this->input->post('next_hearing');
        $petition_no = $this->input->post('petition_no');
        
        $user_code = $this->session->userdata('user_code');
        $petion = array('petition_no' => $petition_no);
        $this->session->set_userdata($petion);
        $this->db->trans_begin();
        $data = array(
            'not_fresh' => 'Y',
            'next_date_of_hearing' => $next_date_input,
            'status' => $status
        );
        //var_dump($data);
        $this->db->where('case_no', $case_no);
        $this->db->where('petition_no', $petition_no);
        $this->db->update("petition_basic", $data);
        //////////RTPS////////////
        $rtps=$this->db->query("Select application_ref_no from petition_basic where case_no='$case_no' ")->row()->application_ref_no;
        if($rtps){
            $msg="Next Hearing Date ". $next_date_input . " for Case No.". $case_no .".Please Visit Circle Office on the above mention date ." ;
            $this->SendRtpsStatus($case_no,$msg,'CO');
        }
        //////////end RTPS/////////////
        ////////////Dashboard Push Data///////////////////
        $penUser='AST';
        $rmrk='First Proceeding given by CO';
        $this->DashboardData($case_no,$penUser,$rmrk);
        /////////////////////
        $rmk='Forwarded to LM';
        if($status=='D'){
            $status='R';
            $pen='NA';
        }else{
            $status='M';
            $pen='LM';
        }
        $status=$status;
        $task='CO';
        $pen=$pen;
        $case=$case_no;
        $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
        //////////////////////////////
        $q = "select count(proceeding_id)+1 as count from    petition_proceeding where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and case_no='$case_no'";
        $pid = $this->db->query($q)->row();
        $COorder = $this->input->post('COorder');
        $find = 'dateName';
        $COorder = str_replace($find, $next_date, $COorder);
        $values = array(
            'case_no' => $case_no,
            'proceeding_id' => $pid->count,
            'date_of_hearing' => $next_date_input,
            'co_order' => $COorder,
            'next_date_of_hearing' => $next_date_input,
            'status' => 'Pending',
            'user_code' => $user_code,
            'date_entry' => date('Y-m-d G:i:s'),
            'operation' => 'E',
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'ip' => $this->utilityclass->get_client_ip()
        );
        //var_dump($values);
        $this->db->insert("petition_proceeding", $values);
        $q = "Select * from petitioner_part where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and petition_no='$petition_no' ";
        $data['name'] = $this->db->query($q)->result();



        //ESCALATION ==============
        $esData=$this->db->query("Select es_flag,mouza_pargona_code,lot_no,out_of_esc from petition_basic where case_no=? ",array($case_no))->row();
        if(ESCALATION_ENABLE == 1 && $esData->es_flag == 1 && ESCALATION_REMARK_ENABLE ==1 && $esData->out_of_esc == 0)
        {

            $responseEsc = $this->Escalationmodel->escalationRemarkCheckandUpdate($case_no,$this->input->post('esc_remark'),$this->session->userdata('user_desig_code'));
            if($responseEsc['responseType'] == 1)
            {
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"#ERRFPARTESCREMARK111 : Error in submitting in escalation remarks. Please try Again"
                );
                echo json_encode($data);
                return false;
            }

        }
        ///END+==================


        //ESCALATION CODE INTEGRATION================SANMRI
        
        $executionDate = $this->input->post('executionDate');
        $user_code = $this->session->userdata('user_code');
        if($esData->es_flag == 1 && ESCALATION_ENABLE ==1 && $esData->out_of_esc == 0){

            $hearingDateEsc = date('Y-m-d H:i:s', strtotime($next_date_input));

            $escalationUpdateStatus = $this->Escalationmodel->escalationCOFirstProcedingOPARTNew($executionDate,$dist_code,$subdiv_code,$cir_code,$esData->mouza_pargona_code,$esData->lot_no,$case_no,$user_code,$hearingDateEsc);

            log_message("error", "#ESC1523, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

            if($escalationUpdateStatus['responseType'] == 0){
                $this->db->trans_rollback();
                log_message("error", "#ESC1523, transaction-error in method 'Partition/proceeding1' with case-no :". $case_no.", dist-code : ".$dist_code);
                $this->session->set_flashdata('message', "Something went wrong.OPART- Error Code(#ESC1523)");
                redirect(base_url() . "index.php/home");
            }
        }

        if($this->db->trans_status() === FALSE){
            $this->session->set_flashdata('message', "Something went wrong. Error Code(#ESC0056)");
            redirect(base_url() . "index.php/home");
        }else{
            $this->db->trans_commit();
        }



        $data['_view'] = 'partition/proceeding_case';
        $this->load->view('layouts/main',$data);
    }

    public function savePartNotifi() {
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
             return redirect(base_url('index.php/partition/FirstPreeceding'));
         }
        //xss & security validation ends 
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $case_no = $this->session->userdata('case_no');
        //$db = $this->session->userdata('db');
        $year_no = year_no;
        $petition_no = $this->session->userdata('petition_no');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code');
        $name = $this->input->post('add_name');
        $loop = sizeof($name);
        $user_code = $this->session->userdata('user_code');
        $add_1 = $this->input->post('add_1');
        $add_2 = $this->input->post('add_2');
        $j = 1;
        for ($i = 0; $i < $loop; $i++) {
            $other_data = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'year_no' => date('Y'),
                'petition_no' => $petition_no,
                'notified_id' => $j,
                'notified_name' => $name[$i],
                'add1' => $add_1[$i],
                'add2' => $add_2[$i],
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E'
            );
            $this->db->insert("petition_notified", $other_data);
            $j++;
        }
        $q = "Select * from    petitioner_part where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and petition_no='$petition_no'";
        $pname = $this->db->query($q)->result();
        foreach ($pname as $n) {
            $other_data = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'year_no' => date('Y'),
                'petition_no' => $petition_no,
                'notified_id' => $j++,
                'notified_name' => $n->pdar_name,
                'add1' => $n->pdar_add1,
                'add2' => $n->pdar_add2,
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E'
            );
            $this->db->insert("petition_notified", $other_data);
        }
        $this->session->set_flashdata('message', 'Office Partition First Proceeding Order has Passed !!');
        redirect(base_url() . 'index.php/home/index');
    }

    public function NextProceeding() {
        //$this->load->view('../views/header');
        //$this->load->view('../views/partition/proceeding_co_2');
        //$this->load->view('../views/footer');

        $data['_view'] = 'partition/proceeding_co_2';
        $this->load->view('layouts/main',$data);
    }

    public function CoPendingSecond() {
        $this->dbswitch();
        //$this->load->library('pagination');
        $data = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $user_code = $this->session->userdata('user_code');
        //$db=  $this->session->userdata('db');
        $year_no = year_no;
        
        // $cases = $this->db->query("select *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree WHERE fmb.dist_code='$dist_code' "
        //                 . "and fmb.subdiv_code='$subdiv_code' and fmb.cir_code='$cir_code' and fmb.co_user_code='$user_code' and fmb.not_fresh = 'Y' and fmb.status='P' and  fmb.mut_type='04' ")->result();
        // $data['cases'] = $cases;
        $q = "Select count(*) as c from    t_chitha_rmk_ordbasic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' 
        and ( iscorrected_inco is null or iscorrected_inco=' ' ) and ord_type_code='04' and map_partition='Y'";
        $data['chithaupdatepending'] = $this->db->query($q)->row()->c;

        $villageList = $this->mutationmodel->getAllDistinctVillageListOPCaseSecond($dist_code,$subdiv_code,$cir_code,$user_code);
        $newMouzaList = array();
            foreach ($villageList as $key => $value) {
                $newMouzaList[$key]['mouza_code'] = $value->mouza_pargona_code;
                $newMouzaList[$key]['mouza_name'] = $this->utilityclass->getMouzaName($value->dist_code,$value->subdiv_code,$value->cir_code,$value->mouza_pargona_code);
                $newMouzaList[$key]['lot_name'] = $this->utilityclass->getLotName($value->dist_code,$value->subdiv_code,$value->cir_code,$value->mouza_pargona_code,$value->lot_no);
                $newMouzaList[$key]['lot_no'] = $value->lot_no;
        }
           
        $uniqueMouzaList = array_map("unserialize", array_unique(array_map("serialize", $newMouzaList)));
        $data['newMouzaList'] = $uniqueMouzaList;
        $data['_view'] = 'partition/PendingSecond';
        $this->load->view('layouts/main',$data);

    }

    public function COSecondProc() {
        $case_no = $_GET['case_no'] = dec_param($this->input->get('case_no'), 'case_no');
        if($_GET['case_no'] == null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }
        if($this->session->userdata('user_desig_code')!='CO'){
            echo "<p class='text-danger'>Error. You are not authorized</p>";
            return;
        }
        $attchedCo=$this->basundharamodel->attachedCO();
        if($attchedCo=='A'){
            echo json_encode('Sorry !! You are not Authorized to pass the order as Attached CO !!');
            return;
        }
        $data = array();
        //$db = $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        //$case_no = $this->input->get('case_no');
        //$db=  $this->session->userdata('db');
        $sql = "Select * from    petition_basic where  dist_code='$dist_code' "
                . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  case_no='$case_no'";
        $pb = $data['pb'] = $this->db->query($sql)->row();
        $sql = "Select * from    copattadar_consent where dist_code='$dist_code' "
                . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and case_no='$case_no' and consent !='' ";
        $data['consent'] = $this->db->query($sql)->result();
        $location = $this->utilityclass->getLocationFromSession();
        $dist_code = $this->utilityclass->getDistrictName($pb->dist_code);
        $subdiv_code = $this->utilityclass->getSubDivName($pb->dist_code, $pb->subdiv_code);
        $cir_code = $this->utilityclass->getCircleName($pb->dist_code, $pb->subdiv_code, $pb->cir_code);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($pb->dist_code, $pb->subdiv_code, $pb->cir_code, $pb->mouza_pargona_code);
        $lot_no = $this->utilityclass->getLotName($pb->dist_code, $pb->subdiv_code, $pb->cir_code, $pb->mouza_pargona_code, $pb->lot_no);
        $vill_townprt_code = $this->utilityclass->getVillageName($pb->dist_code, $pb->subdiv_code, $pb->cir_code, $pb->mouza_pargona_code, $pb->lot_no, $pb->vill_townprt_code);
        $data['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code
        );
        $SecondData = array(
            'dist_code' => $pb->dist_code,
            'subdiv_code' => $pb->subdiv_code,
            'cir_code' => $pb->cir_code,
            'mouza_pargona_code' => $pb->mouza_pargona_code,
            'lot_no' => $pb->lot_no,
            'vill_townprt_code' => $pb->vill_townprt_code,
            'year_no' => $pb->year_no,
            'case_no' => $pb->case_no,
            'petition_no' => $pb->petition_no
        );
        $this->session->set_userdata($SecondData);
        $q = "select * from    petition_dag_details "
                . "where petition_no='$pb->petition_no' and dist_code='$pb->dist_code' and "
                . " cir_code = '$pb->cir_code' and subdiv_code='$pb->subdiv_code' and "
                . " mouza_pargona_code = '$pb->mouza_pargona_code' and lot_no = '$pb->lot_no' and "
                . " vill_townprt_code = '$pb->vill_townprt_code' ";
        $data['dags'] = $this->db->query($q)->result();
        $sql = "select * from    petitioner_part "
                . "where petition_no='$pb->petition_no' and dist_code='$pb->dist_code' and "
                . " cir_code = '$pb->cir_code' and subdiv_code='$pb->subdiv_code' and "
                . " mouza_pargona_code = '$pb->mouza_pargona_code' and lot_no = '$pb->lot_no' and "
                . " vill_townprt_code = '$pb->vill_townprt_code' ";
        $data['PetiPart'] = $this->db->query($sql)->result();
        $sql = "select * from    petition_lm_note "
                . "where petition_no='$pb->petition_no' and dist_code='$pb->dist_code' and "
                . " cir_code = '$pb->cir_code' and subdiv_code='$pb->subdiv_code' and "
                . " mouza_pargona_code = '$pb->mouza_pargona_code' and lot_no = '$pb->lot_no' and "
                . " vill_townprt_code = '$pb->vill_townprt_code' ";
        $data['skNote'] = $data['lmNote'] = $this->db->query($sql)->result();
        //  $arr_size=  sizeof($lm);
        $sql = "select * from petition_byayprak "
                . "where petition_no='$pb->petition_no' and dist_code='$pb->dist_code' and "
                . " cir_code = '$pb->cir_code' and subdiv_code='$pb->subdiv_code' and "
                . " mouza_pargona_code = '$pb->mouza_pargona_code' and lot_no = '$pb->lot_no' and "
                . " vill_townprt_code = '$pb->vill_townprt_code' ";
        //echo $sql;
        $data['byayprak'] = $this->db->query($sql)->row();
        $data['attachment']='';
        if($pb->application_ref_no){
            $url = RTPS_LINK."partition/partition_attachment_details.php?application_ref_no=" . $pb->application_ref_no . "&applid=" . $pb->applid;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            $output = curl_exec($ch);
            curl_close($ch);
            $output = json_decode($output); 
            $data['attachment'] = $output;
        }
        $data['basuCase']=$data['sup_doc']=null;
        $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
        if($basundharaExist){
            $data['query']=null;
            $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
            $data['query']=$this->basundharamodel->QueryPost($basundharaExist);
            $data['sup_doc']=$this->db->query("SELECT * FROM supportive_document WHERE case_no=?", array($case_no))->result();
        }
        $data['lm_revert_note']=$data['sk_revert_note']=array();
        $data['lm_revert_note'] = $this->db->query("SELECT co_order, date(date_entry) 
        AS order_date FROM petition_proceeding 
        WHERE case_no=? AND dist_code=? AND subdiv_code=? AND cir_code=? 
        AND user_code LIKE 'M%' ORDER BY proceeding_id  asc", 
        array($case_no, $pb->dist_code, $pb->subdiv_code, $pb->cir_code))->result();

        $data['sk_revert_note'] = $this->db->query("SELECT co_order, date(date_entry) 
        AS order_date FROM petition_proceeding 
        WHERE case_no=? AND dist_code=? AND subdiv_code=? AND cir_code=? 
        AND user_code LIKE 'SK%' ORDER BY proceeding_id  asc",
        array($case_no, $pb->dist_code, $pb->subdiv_code, $pb->cir_code))->result();
        $q = "Select * from    Petition_Proceeding where case_no='$case_no' and dist_code='$pb->dist_code' "
                . "and subdiv_code='$pb->subdiv_code' and cir_code='$pb->cir_code' ";
        $data['pd'] = $this->db->query($q)->result();


        


        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {

            //////////////////////////////////////////////////////////////// Property Chain Code //////////////////////////////////////////////

            $this->load->model('propChain/PropChainModel');

            $data['propChainEnableFlag'] = $this->PropChainCommonModel->isLocationEnable($pb->dist_code, $pb->subdiv_code, $pb->cir_code, $pb->mouza_pargona_code, $pb->lot_no, $pb->vill_townprt_code);

            foreach ($data['dags'] as $propData) {

                $pattadars = $this->PropChainModel->getPattadars($pb->dist_code, $pb->subdiv_code, $pb->cir_code, $pb->mouza_pargona_code, $pb->lot_no, $pb->vill_townprt_code, $propData->patta_no, $propData->dag_no);


                // $checkPropAndChitha = $this->PropChainModel->chainChithaUlpinCheckProcess($pb->dist_code, $pb->subdiv_code, $pb->cir_code, $pb->mouza_pargona_code, $pb->lot_no, $pb->vill_townprt_code, $propData->patta_no, $propData->dag_no, $pattadars, $propData->dag_area_b, $propData->dag_area_k, $propData->dag_area_lc, $propData->dag_area_g, $propData->patta_type_code);


                $checkPropAndChitha = $this->PropChainModel->chainChithaUlpinCheckProcess($pb->dist_code, $pb->subdiv_code, $pb->cir_code, $pb->mouza_pargona_code, $pb->lot_no, $pb->vill_townprt_code, $propData->patta_no, $propData->dag_no, $propData->dag_area_b, $propData->dag_area_k, $propData->dag_area_lc, $propData->dag_area_g, $propData->patta_type_code);
                
            }
            // update flag 
            if ($checkPropAndChitha['chithaPropChainCmpFlag'] == 'Y' || $checkPropAndChitha['chithaPropChainCmpFlag'] == 'N' || $checkPropAndChitha['chithaPropChainCmpFlag'] == 'NE') {
                $this->PropChainModel->updateCmpFlag($case_no, $checkPropAndChitha['chithaPropChainCmpFlag']);
                // get view mismatch case button
                if ($checkPropAndChitha['chithaPropChainCmpFlag'] == 'N') {
                    $data['viewMisMatchBtn'] = $this->PropChainModel->getMismatchBtn($case_no, $pb->dist_code, $pb->subdiv_code, $pb->cir_code, $pb->mouza_pargona_code, $pb->lot_no, $pb->vill_townprt_code, $propData->patta_no, $propData->dag_no, $propData->dag_area_b, $propData->dag_area_k, $propData->dag_area_lc, $propData->dag_area_g, $propData->patta_type_code);
                }
            }

            $data['ulpinCheck'] = $checkPropAndChitha['ulpinCheck'];
            $data['ulpinMsg'] = $checkPropAndChitha['ulpinMsg'];

            if ($data['ulpinCheck'] == 1) {
                $data['ulpin'] = $checkPropAndChitha['ulpin'];
                if (isset($checkPropAndChitha['old_ulpin']))
                    $data['old_ulpin'] = $checkPropAndChitha['old_ulpin'];
                else
                    $data['old_ulpin'] = "";
            }

            // if property does not exists get create asset button
            if ($checkPropAndChitha['chithaPropChainCmpFlag'] == 'NE') {
                $data['createPropChainBtn'] = $checkPropAndChitha['createPropChainBtn'];
            }
            $data['chithaPropChainCmpFlag'] = $checkPropAndChitha['chithaPropChainCmpFlag'];
            $data['compareFlagMsg'] = $checkPropAndChitha['compareFlagMsg'];
            $data['revenue'] = $checkPropAndChitha['revenue'];
            $data['local_tax'] = $checkPropAndChitha['local_tax'];
            // hidden fields
            $data['ulpin_hidden'] = $checkPropAndChitha['ulpin_hidden'];
            $data['uplpin_msg_hidden'] = $checkPropAndChitha['uplpin_msg_hidden'];
            $data['compare_hidden'] = $checkPropAndChitha['compare_hidden'];
            $data['compare_msg_hidden'] = $checkPropAndChitha['compare_msg_hidden'];

            // bhunaksha area cmp
            $data['bhuChithaCmpStatus'] = $checkPropAndChitha['bhuChithaCmpStatus'];
            $data['bhuChithaCmpMsg'] = $checkPropAndChitha['bhuChithaCmpMsg'];
            $data['bhu_hidden'] = $checkPropAndChitha['bhu_hidden'];
            $data['bhu_compare_msg_hidden'] = $checkPropAndChitha['bhu_compare_msg_hidden'];


        }
        $data['_view'] = 'partition/SecondProceeding';
        $this->load->view('layouts/main',$data);
    }
    function LMreportBasuView(){
        $c=$this->input->get('case_no');
        $sql="Select * from petition_lm_note where case_no=? order by note_no desc";
        $data['lmNote']=$this->db->query($sql,array($c))->result();
        $this->load->view('partition/lmviewNote',$data);
    }
    public function SaveAgainReport() {

      // var_dump($_POST); die;
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
         // $resp = $this->checkAuthenticationAndValidationOpart2($_POST);
         // if($resp['responseType'] == 1)
         // {
         //    $errorMessageStr .= $resp['message'];
         // } 
         if($errorMessageStr != ''){
            $this->session->set_flashdata('message', $errorMessageStr);
             return redirect($_SERVER['HTTP_REFERER']);
         }
        //xss & security validation ends 
        if($this->session->userdata('user_desig_code')!='CO'){
            echo "<p class='text-danger'>Error. You are not authorized</p>";
            return;
        }
        $next_hearing = $this->input->post('next_hearing');
        $user_code = $this->session->userdata('user_code');
        $next_hear_date = $this->input->post('next_hear_date');
        $comment = $this->input->post('comment');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $case_no = $this->input->post('caseno');
        //$db=  $this->session->userdata('db');


        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
            // property chain data
            $ulpin = $this->input->post('ulpin');
            $ulpinCheckFlag = $this->input->post('ulpinCheckFlag');
            $compareCheckFlag = $this->input->post('compareCheckFlag');
            $old_revenue = $this->input->post('chain_revenue');
            $old_local_tax = $this->input->post('chain_local_tax');
            $old_ulpin = $this->input->post('old_ulpin');
            if (!isset($old_ulpin))
                $old_ulpin = "";
        }




        $refno=null;
        // $year_no=year_no;
        if ($next_hearing == 'P') {
            $next_hear_date = $this->input->post('next_hear_date');
            $next_hear_date = explode('/', $next_hear_date);
            $next_hear_date = $next_hear_date[2] . "-" . $next_hear_date[1] . "-" . $next_hear_date[0];
            $comment = $this->input->post('comment');
            $asst_notice = $this->input->post('asst_notice');
            $byay_notice = $this->input->post('byay_notice');
            $lm_notice = $this->input->post('lm_notice');

            $petition_no = $this->session->userdata('petition_no');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');

            $vill_townprt_code = $this->session->userdata('vill_townprt_code');
            //////////////Applkication Reff no/////////////////////
            $sql = "select application_ref_no as refno from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
            $refno = $this->db->query($sql)->row()->refno;
            ///////////////////////////////////
            if ($asst_notice == 'Y') {
                $arr = array('notice_generated_yn' => null, 'next_date_of_hearing' => $next_hear_date, 'proceeding_yn' => null);
                // var_dump($arr);
                $this->db->where('case_no', $case_no);
                $this->db->where('petition_no', $petition_no);
                $this->db->where('dist_code', $dist_code);
                $this->db->where('subdiv_code', $subdiv_code);
                $this->db->where('cir_code', $cir_code);
                $this->db->where('mouza_pargona_code', $mouza_pargona_code);
                $this->db->where('lot_no', $lot_no);
                $this->db->where('vill_townprt_code', $vill_townprt_code);
                // $this->db->where('year_no', $year_no);
                $this->db->update("petition_basic", $arr);
                $sql = "select MAX(proceeding_id)+1 as id from    petition_proceeding where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
                $data = $this->db->query($sql)->row();
                $values = array(
                    'case_no' => $case_no,
                    'proceeding_id' => $data->id,
                    'date_of_hearing' => $next_hear_date,
                    'co_order' => $comment,
                    'next_date_of_hearing' => $next_hear_date,
                    'status' => 'Pending',
                    'user_code' => $user_code,
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'E',
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'ip' => $this->utilityclass->get_client_ip()
                );
                //var_dump($values);
                $this->db->insert("petition_proceeding", $values);

                $pen='AST';
                $rmk='Forwarded to AST for reserve notice';
                $this->DashboardData($case_no,$pen,$rmk);

                $msg = "Notice Generated for case number " . $case_no;
                $this->session->set_flashdata('message', '');

                redirect(base_url() . 'index.php/home');
            }
            if ($byay_notice == 'Y') {
                $arr = array('next_date_of_hearing' => $next_hear_date, 'proceeding_yn' => null, 'pay_notice_gen_yn' => 'Y', 'notice_served_yn' => null);
                //var_dump($arr);
                $this->db->where('case_no', $case_no);
                $this->db->where('petition_no', $petition_no);
                $this->db->where('dist_code', $dist_code);
                $this->db->where('subdiv_code', $subdiv_code);
                $this->db->where('cir_code', $cir_code);
                $this->db->where('mouza_pargona_code', $mouza_pargona_code);
                $this->db->where('lot_no', $lot_no);
                $this->db->where('vill_townprt_code', $vill_townprt_code);
                //$this->db->where('year_no', $year_no);
                $this->db->update("petition_basic", $arr);
                $sql = "select MAX(proceeding_id)+1 as id from    petition_proceeding where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
                $data = $this->db->query($sql)->row();
                //var_dump($data);
                $values = array(
                    'case_no' => $case_no,
                    'proceeding_id' => $data->id,
                    'date_of_hearing' => $next_hear_date,
                    'co_order' => $comment,
                    'next_date_of_hearing' => $next_hear_date,
                    'status' => 'Pending',
                    'user_code' => $user_code,
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'E',
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'ip' => $this->utilityclass->get_client_ip()
                );
                $this->db->insert("petition_proceeding", $values);


                /////////////RTPS/////////////////////
                if($refno){
                $sql = "select * from    petition_byayprak "
                . "where petition_no='$petition_no' and dist_code='$dist_code' and "
                . " cir_code = '$cir_code' and subdiv_code='$subdiv_code' and "
                . " mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and "
                . " vill_townprt_code = '$vill_townprt_code' ";
                //echo $sql;
                $byayprak = $this->db->query($sql)->row();
                $fee=$byayprak->exp_details_total + $byayprak->copdar_amt_total ;
                $msg='Byay-Prak Notice Have been Generated/Served. Please pay the Amount Rs./-' . $fee ." Next Hearing Date :" . $next_hear_date ." for Case no." . $case_no;       
                //$this->SendRtpsPayQuery($case_no,$msg,$fee);
                }
                ///////////////Dashboard////////////////////
                $penUser='AST';
                $rmrk='Byay-Prak Notice Have been Generated/Served.';
                $this->DashboardData($case_no,$penUser,$rmrk);
                //////////
                $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
                if($basundharaExist){
                    $rmk='Byay-Prak Notice Have been Generated/Served.';
                    $status='M';
                    $task='CO';
                    $pen='AST';
                    $case=$case_no;
                    $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
                }
                //exit;
                $this->session->set_flashdata('message', 'Byay-Prak Notice Generated');
                redirect(base_url() . 'index.php/home');
            }
            if ($lm_notice == 'Y') {
                $pb = array('next_date_of_hearing' => $next_hear_date, 'lm_note_yn' => null, 'lm_note_date' => null, 'sk_comment' => null);
                $this->db->where('case_no', $case_no);
                $this->db->where('petition_no', $petition_no);
                $this->db->where('dist_code', $dist_code);
                $this->db->where('subdiv_code', $subdiv_code);
                $this->db->where('cir_code', $cir_code);
                $this->db->where('mouza_pargona_code', $mouza_pargona_code);
                $this->db->where('lot_no', $lot_no);
                $this->db->where('vill_townprt_code', $vill_townprt_code);
                // $this->db->where('year_no', $year_no);
                $this->db->update("petition_basic", $pb);
                $sql = "select MAX(proceeding_id)+1 as id from    petition_proceeding where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
                $data = $this->db->query($sql)->row();
                $values = array(
                    'case_no' => $case_no,
                    'proceeding_id' => $data->id,
                    'date_of_hearing' => $next_hear_date,
                    'co_order' => $comment,
                    'next_date_of_hearing' => $next_hear_date,
                    'status' => 'Pending',
                    'user_code' => $user_code,
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'E',
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'ip' => $this->utilityclass->get_client_ip()
                );
                $this->db->insert("petition_proceeding", $values);
                ///////Dasboard/////////////
                $penUser='LM';
                $rmrk='Revert Back by CO to LM';
                $this->DashboardData($case_no,$penUser,$rmrk);
                ////////////////////
                $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
                if($basundharaExist){
                    $rmk='Revert Back by CO';
                    $status='M';
                    $task='CO';
                    $pen='LM';
                    $case=$case_no;
                    $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
                }
                ///////////////////////////

                $this->session->set_flashdata('message', 'LM  Notice Regenerated');
                redirect(base_url() . 'index.php/home');
            }
        } elseif ($next_hearing == 'D') {
            $next_hear_date = $this->input->post('next_hear_date');
            $next_hear_date = explode('/', $next_hear_date);
            $next_hear_date = $next_hear_date[2] . "-" . $next_hear_date[1] . "-" . $next_hear_date[0];
            $comment = $this->input->post('comment');
            $asst_notice = $this->input->post('asst_notice');
            $byay_notice = $this->input->post('byay_notice');
            $lm_notice = $this->input->post('lm_notice');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $case_no = $this->input->post('caseno');
            $petition_no = $this->session->userdata('petition_no');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_townprt_code');
            $sql = "select MAX(proceeding_id)+1 as id from    petition_proceeding where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
            $data = $this->db->query($sql)->row();
            $values = array(
                'case_no' => $case_no,
                'proceeding_id' => $data->id,
                'date_of_hearing' => $next_hear_date,
                'co_order' => $comment,
                'next_date_of_hearing' => $next_hear_date,
                'status' => 'Dispose',
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'ip' => $this->utilityclass->get_client_ip()
            );

            $this->db->insert("petition_proceeding", $values);
            $pb = array('notice_generated_yn' => null, 'next_date_of_hearing' => $next_hear_date, 'status' => 'D', 'proceeding_yn' => null);
            $this->db->where('case_no', $case_no);
            $this->db->where('petition_no', $petition_no);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('mouza_pargona_code', $mouza_pargona_code);
            $this->db->where('lot_no', $lot_no);
            $this->db->where('vill_townprt_code', $vill_townprt_code);
            // $this->db->where('year_no', $year_no);
            $this->db->update("petition_basic", $pb);
            ///////Dasboard/////////////
            $this->DashboardDataReject($case_no);
            ////////////////
            $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
            if($basundharaExist){
                $rmk=$comment;
                $status='R';
                $task='CO';
                $pen='NA';
                $case=$case_no;
                $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
            }
            ///////////////////////////
            $this->session->set_flashdata('message', 'This Case has been Disposed');
            redirect(base_url() . 'index.php/home');
        } elseif ($next_hearing == 'F') {
            $next_hear_date = explode('/', $next_hear_date);
            $next_hear_date = $next_hear_date[2] . "-" . $next_hear_date[1] . "-" . $next_hear_date[0];
            $comment = $this->input->post('comment');
            $this->session->set_userdata('comment', $comment);
            $user_code = $this->session->userdata('user_code');
            $name = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $user_code);
            $comment = $comment . "<p>" . $name->username . "&nbsp&nbsp Dated:" . date('d/m/Y') . "</p>";
            //var_dump($comment);
            //  exit;
            $sql = "select MAX(proceeding_id)+1 as id from    petition_proceeding where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
            //var_dump($data);
            $values = array(
                'case_no' => $case_no,
                'proceeding_id' => $data->id,
                'date_of_hearing' => $next_hear_date,
                'co_order' => $comment,
                'next_date_of_hearing' => $next_hear_date,
                'status' => 'Final',
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'ip' => $this->utilityclass->get_client_ip()
            );
            //redirect(base_url() . 'index.php/partition/CoDagDetails');
            if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
            {

                redirect(base_url() . 'index.php/partition/finalOrderOfcPartitionCO?ulpin=' . $ulpin . '&old_revenue=' . $old_revenue . '&old_local_tax=' . $old_local_tax . '&old_ulpin=' . $old_ulpin . '&ulpinCheckFlag=' . $ulpinCheckFlag . '&compareCheckFlag=' . $compareCheckFlag);

            }
            redirect(base_url() . 'index.php/partition/finalOrderOfcPartitionCO');
            
        }
    }

    public function CoDagDetails() {
        $data = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $petition_no = $this->session->userdata('petition_no');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code');
        $case_no = $this->session->userdata('case_no');
        $db=  $this->session->userdata('db');
        //$year_no = $this->session->userdata('year_no');
        $sql = "SELECT * FROM  petition_dag_details  WHERE dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no'"
                . " and vill_townprt_code = '$vill_townprt_code' and petition_no = '$petition_no' ";
        $dag = $data['values'] = $this->db->query($sql)->row();
        $sql = "SELECT patta_type FROM  Patta_code WHERE type_code = '$dag->patta_type_code'";
        $data['patta'] = $this->db->query($sql)->row();
        //$this->load->view('../views/header');
       // $this->load->view('../views/partition/SecondProDag', $data);
        //$this->load->view('../views/footer');

        $data['_view'] = 'partition/SecondProDag';
        $this->load->view('layouts/main',$data);
    
    }

    public function CORMKOrder() {
        $data = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code');
        $case_no = $this->session->userdata('case_no');
        $petition_no = $this->session->userdata('petition_no');
        //$db = $this->session->userdata('db');
        //$year_no = $this->session->userdata('year_no');
        $user_code = $this->session->userdata('user_code');
        $sql = "Select * from    petition_basic where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no'"
                . " and vill_townprt_code = '$vill_townprt_code' and petition_no = '$petition_no'  and case_no='$case_no'";
        $data['pb'] = $this->db->query($sql)->row();
        $sql = "Select * from    petition_lm_note where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no'"
                . " and vill_townprt_code = '$vill_townprt_code' and petition_no = '$petition_no'  order by date(lm_sign_date) asc";
        $lm = $data['lmnote'] = $this->db->query($sql)->row();
        $data['getSelectedMondalsName'] = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $lm->lm_code);
        $data['getSelectedSKName'] = $this->utilityclass->getSKByCode($dist_code, $subdiv_code, $cir_code, $lm->user_code);
        $data['getSelectedCOName'] = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $user_code);
        //var_dump($data);
        //$this->load->view('../views/header');
        //$this->load->view('../views/partition/CORmkOrder', $data);
        //$this->load->view('../views/footer');

        $data['_view'] = 'partition/CORmkOrder';
        $this->load->view('layouts/main',$data);
    }

    public function COSelectDag() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code');
        $case_no = $this->session->userdata('case_no');
        //$db = $this->session->userdata('db');
        $petition_no = $this->session->userdata('petition_no');
        //$year_no = $this->session->userdata('year_no');
        $lmName = $this->input->post('lmName');
        $orderDate = $this->input->post('orderDate');
        $orderDate = explode('/', $orderDate);
        $orderDate = $orderDate[2] . "-" . $orderDate[1] . "-" . $orderDate[0];
        $lmSign = $this->input->post('lmSign');
        $orderType = $this->input->post('orderType');
        $lmSignDate = $this->input->post('lmSignDate');
        $OrderBy = $this->input->post('OrderBy');
        $OrderPassSign = $this->input->post('OrderPassSign');
        $skName = $this->input->post('skName');
        $skSign = $this->input->post('skSign');
        $skSignDate = $this->input->post('skSignDate');
        $orderNo = $this->input->post('orderNo');
        $coName = $this->input->post('coName');
        $GovtLand = $this->input->post('GovtLand');
        $COSign = $this->input->post('COSign');
        $refLtrNo = $this->input->post('refLtrNo');
        $coSignDate = date('Y-m-d G:i:s');
        $wrt1 = $this->input->post('wrt1');
        $wrt2 = $this->input->post('wrt2');
        $wrt3 = $this->input->post('wrt3');
        $wrt4 = $this->input->post('wrt4');
        $wrt5 = $this->input->post('wrt5');
        if ($COSign == 'Y') {

            $sql = "select * from    petition_dag_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
                    . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and petition_no='$petition_no' ";
            $data = $this->db->query($sql)->row();
            $values = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $data->dag_no,
                'year_no' => date('Y'),
                'petition_no' => $petition_no,
                'ord_no' => $case_no,
                'ord_date' => $orderDate,
                'ord_type_code' => '04',
                'case_no' => $case_no,
                'ord_on_gl_type' => 'U',
                'ord_passby_sign_yn' => 'Y',
                'ord_passby_desig' => $coName,
                'ord_ref_let_no' => $refLtrNo,
                'lm_code' => $lmName,
                'lm_sign_yn' => $lmSign,
                'lm_sign_date' => $lmSignDate,
                'sk_code' => $skName,
                'sk_sign_yn' => $skSign,
                'sk_sign_date' => $skSignDate,
                'co_code' => $coName,
                'co_sign_yn' => $COSign,
                'co_ord_date' => $coSignDate,
                'm_dag_area_b' => $data->m_dag_area_b,
                'm_dag_area_k' => $data->m_dag_area_k,
                'm_dag_area_lc' => $data->m_dag_area_lc,
                'm_dag_area_g' => $data->m_dag_area_g,
                'm_dag_area_kr' => $data->m_dag_area_kr,
                'area_left_b' => $data->dag_area_b,
                'area_left_k' => $data->dag_area_k,
                'area_left_lc' => $data->dag_area_lc,
                'area_left_g' => $data->dag_area_g,
                'area_left_kr' => $data->dag_area_kr,
                'wrt_order1' => $wrt1,
                'wrt_order2' => $wrt2,
                'wrt_order3' => $wrt3,
                'wrt_order4' => $wrt4,
                'wrt_order5' => $wrt5,
                'make_mdb' => 'Y',
            );
            $this->session->set_userdata($values);

            $sql = "Select dag_no from    petitioner_part where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
                    . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and petition_no='$petition_no' ";
            $daa['dag'] = $this->db->query($sql)->row();
            //$this->load->view('../views/header');
            //$this->load->view('../views/partition/COSelectDag', $daa);
            //$this->load->view('../views/footer');
            $daa['_view'] = 'partition/COSelectDag';
            $this->load->view('layouts/main',$daa);
        } else {
            //echo "Error";
            $this->session->set_flashdata('message', 'Error Found during Processing. Please do it correctly !!');
            redirect(base_url() . 'index.php/home');
        }
    }

    public function COInFavOfDtls() {
        //var_dump($this->session->all_userdata());
        $data = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code');
        $case_no = $this->session->userdata('case_no');
        $petition_no = $this->session->userdata('petition_no');
        //$db = $this->session->userdata('db');
        //$year_no = $this->session->userdata('year_no');
        $q = "select pdar_id from    t_chitha_rmk_infavor_of where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
                . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and petition_no='$petition_no' ";
        $sql = "Select * from    petitioner_part where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
                . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and petition_no='$petition_no' and pdar_id not in ($q) limit 1 ";
        $data['values'] = $this->db->query($sql)->result();
        $sql = "select * from    master_guard_rel";
        $data['relation'] = $this->db->query($sql)->result();
        $sql = "Select dag_no,dag_no_int from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
                . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' order by dag_no_int desc";
        $data['oldDag'] = $this->db->query($sql)->result();
        $sql = "Select * from    petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
                . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and case_no='$case_no' and petition_no='$petition_no'";
        $data['pbdata'] = $this->db->query($sql)->row();
        $sql = "Select * from    petition_lm_note where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
                . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and petition_no='$petition_no'";
        $plmnote = $data['plmnote'] = $this->db->query($sql)->row();
        $q = "Select * from    chitha_dag_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
                . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and dag_no='$plmnote->dag_no' and p_flag ='0' ";
        $PattadarCount = $this->db->query($q)->result();
        $q = "Select dag_area_b,dag_area_k,dag_area_lc from    chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
                . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and dag_no='$plmnote->dag_no' ";
        $oldland = $this->db->query($q)->row();
        $data['PattadarCount'] = sizeof($PattadarCount);
        //var_dump($data['PattadarCount']);
        $sql = "Select * from    petition_dag_details where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
                . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and petition_no='$petition_no' ";
        $land = $data['land'] = $this->db->query($sql)->row();
        $notinsql = "Select type_code from    patta_code where mutation='a' ";
        $sql = "Select patta_no as patta_no from    jama_patta where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
                . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and (patta_type_code='$land->patta_type_code')   and TRIM(patta_no)!='' and TRIM(patta_no)!='.' order by length(patta_no),patta_no  ";
        $data['oldPatta'] = $this->db->query($sql)->result();

        $newpatta = $this->utilityclass->maxpatta($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $land->patta_type_code);
        $newDag = $this->utilityclass->maxdag($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);
        $data['NewDag'] = array('dag' => $newDag);
        $data['NewPatta'] = array('patta' => $newpatta);
        //var_dump( $data['NewPatta'] );
        $bigha = $land->m_dag_area_b;
        $katha = $land->m_dag_area_k;
        $lessa = $land->m_dag_area_lc;
        $r = $plmnote->min_revenue;
        $tlessa = $bigha * 100 + $katha * 20 + $lessa;
        $rev = $tlessa * $r;
        $rev = $rev / 100;
        if ($tlessa < 100) {
            $rev = $plmnote->min_revenue;
        }
        //var_dump($data['oldDag']);
        $oldlandarea = $oldland->dag_area_b * 100 + $oldland->dag_area_k * 20 + $oldland->dag_area_lc;
        if ($oldlandarea == $tlessa) {
                $data['pbdata']->complete_partition_yn = 'y';
        }else{
            $data['pbdata']->complete_partition_yn = 'n';
        }
        $data['revenue'] = $rev;

        $data['_view'] = 'partition/COInFavourof';
        $this->load->view('layouts/main',$data);
        // var_dump($data);
        //var_dump($this->session->all_userdata());
        if (isset($_POST['formsubmit'])) {
            $this->db->trans_begin();
            $checkagain = 1;
            $new_dag_no = $this->input->post('newDag');
            $new_patta_no = $this->input->post('newPatta');
            $this->session->set_userdata('postPattaNo',$new_patta_no);
            $this->session->set_userdata('postDagNo',$new_dag_no);
            $dag_no = $this->input->post('oldDag');
            if ($new_dag_no == $dag_no) {
                $newpattadar = null;
            } else {
                $newpattadar = 'N';
            }
            $patta_no = trim($this->input->post('pattaNo'));
            $patta_type_code = $this->input->post('pattaCode');
            $infavor_of_id = $this->input->post('infavourOf');
            $infavor_of_name = $this->input->post('inFavourName');
            $infavor_of_guardian = $this->input->post('inFavourGurd');
            $infavor_of_guar_relation = $this->input->post('guar_rel');
            $pdar_cron_no = $this->input->post('pdar_cron_no');
            $infavor_of_add1 = $this->input->post('infavourAdd1');
            $infavor_of_add2 = $this->input->post('infavourAdd2');
            $infavor_of_gender = $this->input->post('inFavourSex');
            $infavor_of_mother = $this->input->post('inFavourMother');
            $by_right_of = '00';
            $land_area_b = $this->input->post('LandB');
            $land_area_k = $this->input->post('LandK');
            $land_area_lc = $this->input->post('LandL');
            $land_area_g = '0';
            $land_area_kr = '0';
            $revenue = $this->input->post('revenue');
            $deed_y_n = $this->input->post('deed_y_n');

            //$land_class_code=$this->input->post('new_land_class');
            if ($deed_y_n == 'Yes') {

                $reg_deal_no = $this->input->post('RegDeedNo');
                $reg_deedValue = $this->input->post('RegDeedValue');
                $reg_date = date('Y-m-d', strtotime($this->input->post('reg_date')));
                $sub_reg_office = $this->input->post('sub_regOffice');
            } else {

                $reg_deal_no = null;
                $reg_deedValue = null;
                $reg_date = null;
                $sub_reg_office = null;
            }

            $pdar_strike = $this->input->post('pdar_strike');
            $date = date('Y-m-d G:i:s');
            $pdar_mobile = $this->input->post('pdar_mobile');
            $pdar_aadhar = $this->input->post('pdar_aadhar');
            $pdar_nrc = $this->input->post('pdar_nrc');
            $pdar_pan = $this->input->post('pdar_pan');
            $pdar_voterID = $this->input->post('pdar_voterID');
            if ($infavor_of_guar_relation == 'u') {
                $infavor_of_guar_relation = 'u';
            }
            $insert = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'year_no' => date('Y'),
                'petition_no' => $petition_no,
                'patta_type_code' => $patta_type_code,
                'patta_no' => $patta_no,
                'ord_no' => $case_no,
                'ord_date' => $date,
                'pdar_id' => $infavor_of_id,
                'infavor_of_id' => $pdar_cron_no,
                'infavor_of_name' => $infavor_of_name,
                'infavor_of_guardian' => $infavor_of_guardian,
                'infav_of_guar_relation' => $infavor_of_guar_relation,
                'infavor_of_add1' => $infavor_of_add1,
                'infavor_of_add2' => $infavor_of_add2,
                'by_right_of' => '00',
                'land_area_b' => $land_area_b,
                'land_area_k' => $land_area_k,
                'land_area_lc' => $land_area_lc,
                'land_area_g' => $land_area_g,
                'land_area_kr' => $land_area_kr,
                'revenue' => $revenue,
                'reg_deal_no' => $reg_deal_no,
                'reg_date' => $date,
                'sub_reg_office' => $sub_reg_office,
                'new_dag_no' => $new_dag_no,
                'new_patta_no' => $new_patta_no,
                'make_mdb' => 'Y',
                'new_pattadar' => $newpattadar,
                'pdar_strike' => $pdar_strike,
                'infavor_of_gender' => $infavor_of_gender,
                'infavor_of_mother' => $infavor_of_mother,
                'pdar_pan_no' => $pdar_pan,
                'pdar_citizen_no' => $pdar_voterID,
                'pdar_aadharno' => $pdar_aadhar,
                'pdar_mobile' => $pdar_mobile,
                'pdar_nrcno' => $pdar_nrc
            );

            //  var_dump($insert);
            $tstatus1=$this->db->insert("t_chitha_rmk_infavor_of", $insert);
            if ($tstatus1 != 1 )
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Order for Case No $case_no Not Successfull. Error Code(#OP001)");
                redirect(base_url() . "index.php/home");
            }
            //
            $user_code = $this->session->userdata('user_code');
            $name = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $user_code);
            $comment = $this->session->userdata('comment');
            $comment = $comment . "<p>" . $name->username . "&nbsp&nbsp Dated:" . date('d/m/Y') . "</p>";
            //$comment=$comment."<p>"." নতুন দাগ নং ".$this->utilityclass->cassnum($new_dag_no)." নতুন পট্টা নং ".$this->utilityclass->cassnum($new_patta_no)."</p>";

            $sql = "select MAX(proceeding_id)+1 as id from    petition_proceeding where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
            $dataa = $this->db->query($sql)->row();
            //var_dump($data);
            $valuess = array(
                'case_no' => $case_no,
                'proceeding_id' => $dataa->id,
                'date_of_hearing' => date('Y-m-d G:i:s'),
                'co_order' => $comment,
                'next_date_of_hearing' => date('Y-m-d G:i:s'),
                'status' => 'Final',
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'ip' => $this->utilityclass->get_client_ip()
            );
            // var_dump($values);
            //  exit; 
            $values = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'year_no' => date('Y'),
                'petition_no' => $petition_no,
                'ord_no' => $case_no,
                'ord_date' => $date,
                'ord_type_code' => '04',
                'case_no' => $case_no,
                'ord_on_gl_type' => 'U',
                'ord_passby_sign_yn' => 'Y',
                'ord_passby_desig' => 'CO',
                'ord_ref_let_no' => $this->session->userdata('ord_ref_let_no'),
                'lm_code' => $this->session->userdata('lm_code'),
                'lm_sign_yn' => $this->session->userdata('lm_sign_yn'),
                'lm_sign_date' =>$this->session->userdata('lm_sign_date'),
                'sk_code' => $this->session->userdata('sk_code'),
                'sk_sign_yn' => $this->session->userdata('sk_sign_yn'),
                'sk_sign_date' => $this->session->userdata('sk_sign_date'),
                'co_code' => $this->session->userdata('co_code'),
                'co_sign_yn' => $this->session->userdata('co_sign_yn'),
                'co_ord_date' => date('Y-m-d G:i:s'),
                'm_dag_area_b' => $land_area_b,
                'm_dag_area_k' => $land_area_k,
                'm_dag_area_lc' => $land_area_lc,
                'm_dag_area_g' => $this->session->userdata('m_dag_area_g'),
                'm_dag_area_kr' => $this->session->userdata('m_dag_area_kr'),
                'area_left_b' => $this->session->userdata('area_left_b'),
                'area_left_k' => $this->session->userdata('area_left_k'),
                'area_left_lc' => $this->session->userdata('area_left_lc'),
                'area_left_g' => $this->session->userdata('area_left_g'),
                'area_left_kr' => $this->session->userdata('area_left_kr'),
                'wrt_order1' => $this->session->userdata('wrt_order1'),
                'wrt_order2' => $this->session->userdata('wrt_order2'),
                'wrt_order3' => $this->session->userdata('wrt_order3'),
                'wrt_order4' => $this->session->userdata('wrt_order4'),
                'wrt_order5' => $this->session->userdata('wrt_order5'),
                'make_mdb' => 'Y',
                'new_dag_no' => $new_dag_no,
                'min_revenue' => $revenue,
                'map_partition' => 'P'
            );
            $q = "Select count(*) as c from    t_chitha_rmk_ordbasic where cir_code='$cir_code' and subdiv_code='$subdiv_code' and petition_no='$petition_no' and ord_no='$case_no' ";
            $num_rows = $this->db->query($q)->row()->c;
            if ($num_rows == 0) {
                $tstatus2=$this->db->insert("t_chitha_rmk_ordbasic", $values);
                if ($tstatus2 != 1 )
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Order for Case No $case_no Not Successfull. Error Code(#OP002)");
                    redirect(base_url() . "index.php/home");
                }
                $this->db->insert("petition_proceeding", $valuess);
            }
            $val = array('status' => 'F', 'order_passed' => 'Y', 'date_of_order' => date('Y-m-d G:i:s'), 'deed_no' => $reg_deal_no, 'deed_value' => $reg_deedValue, 'deed_date' => $reg_date, 'sub_reg_office' => $sub_reg_office);
            $this->db->where('case_no', $case_no);
            $this->db->where('petition_no', $petition_no);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('mouza_pargona_code', $mouza_pargona_code);
            $this->db->where('lot_no', $lot_no);
            $this->db->where('vill_townprt_code', $vill_townprt_code);
            // $this->db->where('year_no', $year_no);
            $this->db->update("petition_basic", $val);
            // if($data['pbdata']->application_ref_no){
            //     $msg='Partition Order Passed Successfully '. $case_no . " New Dag No." . $new_dag_no ." New Patta No. " . $new_patta_no;
            //     $this->SendRtpsFStatus($case_no,$msg);
            // }
            $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
            if($basundharaExist){
                $rmk='Final Order Passed';
                $status='F';
                $task='CO';
                $pen='NA';
                $case=$case_no;
                $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
            }
            //redirect(base_url() . 'index.php/partition/COInFavOfDtls');
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo "Error during processing";
            } else {
                $this->db->trans_commit();
                $this->DashboardDataFinal($case_no);
                redirect(base_url() . 'index.php/partition/COInFavOfDtls');
            }
        }
    }

    public function UpdateData() {
        //$this->load->view('../views/header');
        //$this->load->view('../views/partition/chitha_update_complete');
        //$this->load->view('../views/footer');

        $data['_view'] = 'partition/chitha_update_complete';
        $this->load->view('layouts/main',$data);
    }

    /*
     * END CO Part  ----------------------------------------------------------------------------------------------------
     * Start LM Part ----------------------------------------------------------------------------------------------------
     */

    public function LMPartition() {
        //$this->load->view('../views/header');
        //$this->load->view('../views/partition/OfficePartition');
        //$this->load->view('../views/footer');

        $data['_view'] = 'partition/OfficePartition';
        $this->load->view('layouts/main',$data);
    }

    public function LmPartitionRpt() {
        $details = array();
        $petition_no = $this->input->get('petition_no');
        $case_no = $this->input->get('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        //$db = $this->session->userdata('db');
        $year_no = year_no;
        $details['attachment']=null;
        $partition = array('petition_no' => $petition_no, 'case_no' => $case_no);
        $this->session->set_userdata($partition);
        $sql = "SELECT * FROM  Nature_trans_code WHERE trans_code <> '00' ";
        $details['data'] = $this->db->query($sql)->result();
        $sql = "Select * from    petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'  and case_no='$case_no' and petition_no='$petition_no'  ";
        $pb = $details['pb'] = $this->db->query($sql)->row();
        if($pb->application_ref_no){
            $url =RTPS_LINK. "partition/partition_attachment_details.php?application_ref_no=" . $pb->application_ref_no . "&applid=" . $pb->applid;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            $output = curl_exec($ch);
            curl_close($ch);
            $output = json_decode($output); 
            $details['attachment'] = $output;
            $details['mobile_no']=$this->ServicePlusModel->rtpsMobile($pb->application_ref_no);
        }
        $locationData = array(
            'dist_code' => $pb->dist_code,
            'subdiv_code' => $pb->subdiv_code,
            'cir_code' => $pb->cir_code,
            'lot_no' => $pb->lot_no,
            'vill_townprt_code' => $pb->vill_townprt_code,
            'mouza_pargona_code' => $pb->mouza_pargona_code,
            'year_no' => $pb->year_no
        );
        $this->session->set_userdata($locationData);
        $location = $this->utilityclass->getLocationFromSession();
        //echo $pb->dist_code;
        $dist_code = $this->utilityclass->getDistrictName($pb->dist_code);
        $subdiv_code = $this->utilityclass->getSubDivName($pb->dist_code, $pb->subdiv_code);
        $cir_code = $this->utilityclass->getCircleName($pb->dist_code, $pb->subdiv_code, $pb->cir_code);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($pb->dist_code, $pb->subdiv_code, $pb->cir_code, $pb->mouza_pargona_code);
        $lot_no = $this->utilityclass->getLotName($pb->dist_code, $pb->subdiv_code, $pb->cir_code, $pb->mouza_pargona_code, $pb->lot_no);
        $vill_townprt_code = $this->utilityclass->getVillageName($pb->dist_code, $pb->subdiv_code, $pb->cir_code, $pb->mouza_pargona_code, $pb->lot_no, $pb->vill_townprt_code);
        $details['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code
        );
        $q = "select * from    petition_dag_details "
                . "where petition_no='$pb->petition_no' and dist_code='$pb->dist_code' and "
                . " cir_code = '$pb->cir_code' and subdiv_code='$pb->subdiv_code' and "
                . " mouza_pargona_code = '$pb->mouza_pargona_code' and lot_no = '$pb->lot_no' and "
                . " vill_townprt_code = '$pb->vill_townprt_code' ";
        // echo $q;
        $details['dags'] = $this->db->query($q)->row();

        $sql = "select * from    petitioner_part "
                . "where petition_no='$pb->petition_no' and dist_code='$pb->dist_code' and "
                . " cir_code = '$pb->cir_code' and subdiv_code='$pb->subdiv_code' and "
                . " mouza_pargona_code = '$pb->mouza_pargona_code' and lot_no = '$pb->lot_no' and "
                . " vill_townprt_code = '$pb->vill_townprt_code' ";
        $details['PetiPart'] = $this->db->query($sql)->result();
        $details['basuCase']=null;
        $details['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
        if($basundharaExist){
            $details['query']=null;
            $details['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
            $details['query']=$this->basundharamodel->QueryPost($basundharaExist);
        }
        ////////////////////////
        $details['sup_doc']=$this->db->query("SELECT * FROM supportive_document WHERE case_no=?", array($case_no))->result();
        //ESCALATED CASES REMARK ENTRY FORM==============
        if(ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE == 1 && $pb->es_flag == 1 && $pb->out_of_esc == 0)
        {
            $remainingTime = $this->Escalationmodel->calculateRemainingTime($case_no,$this->session->userdata('user_desig_code'));
            $details['remainingTime'] = $remainingTime;
            $escRemarkData = $this->Escalationmodel->getEscalationRemarkDetails($case_no,$this->session->userdata('user_desig_code'),$this->session->userdata('user_code'));
            if(isset($escRemarkData) && !empty($escRemarkData))
            {
                $details['escRemarkData'] = $escRemarkData;
            }
        }
        ///END REMARKS/////////

        $details['_view'] = 'partition/PartitionReport';
        $this->load->view('layouts/main',$details);
    }

    public function ModalPartitionRpt() {
        $details = array();
        $petition_no = $this->input->get('petition_no');
        $case_no = $this->input->get('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        //$db = $this->session->userdata('db');
        $year_no = year_no;
        $partition = array('petition_no' => $petition_no, 'case_no' => $case_no);
        $this->session->set_userdata($partition);
        $sql = "SELECT * FROM  Nature_trans_code WHERE trans_code <> '00' ";
        $details['data'] = $this->db->query($sql)->result();

        $sql = "Select * from    petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  case_no='$case_no'";
        $pb = $details['pb'] = $this->db->query($sql)->row();
        $locationData = array(
            'dist_code' => $pb->dist_code,
            'subdiv_code' => $pb->subdiv_code,
            'cir_code' => $pb->cir_code,
            'lot_no' => $pb->lot_no,
            'vill_townprt_code' => $pb->vill_townprt_code,
            'mouza_pargona_code' => $pb->mouza_pargona_code,
            'year_no' => $pb->year_no
        );
        $this->session->set_userdata($locationData);
        $location = $this->utilityclass->getLocationFromSession();
        //echo $pb->dist_code;
        $dist_code = $this->utilityclass->getDistrictName($pb->dist_code);
        $subdiv_code = $this->utilityclass->getSubDivName($pb->dist_code, $pb->subdiv_code);
        $cir_code = $this->utilityclass->getCircleName($pb->dist_code, $pb->subdiv_code, $pb->cir_code);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($pb->dist_code, $pb->subdiv_code, $pb->cir_code, $pb->mouza_pargona_code);
        $lot_no = $this->utilityclass->getLotName($pb->dist_code, $pb->subdiv_code, $pb->cir_code, $pb->mouza_pargona_code, $pb->lot_no);
        $vill_townprt_code = $this->utilityclass->getVillageName($pb->dist_code, $pb->subdiv_code, $pb->cir_code, $pb->mouza_pargona_code, $pb->lot_no, $pb->vill_townprt_code);
        $details['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code
        );
        $q = "select * from    petition_dag_details "
                . "where petition_no='$pb->petition_no' and dist_code='$pb->dist_code' and "
                . " cir_code = '$pb->cir_code' and subdiv_code='$pb->subdiv_code' and "
                . " mouza_pargona_code = '$pb->mouza_pargona_code' and lot_no = '$pb->lot_no' and "
                . " vill_townprt_code = '$pb->vill_townprt_code' ";
        // echo $q;
        $details['dags'] = $this->db->query($q)->row();

        $sql = "select * from    petitioner_part "
                . "where petition_no='$pb->petition_no' and dist_code='$pb->dist_code' and "
                . " cir_code = '$pb->cir_code' and subdiv_code='$pb->subdiv_code' and "
                . " mouza_pargona_code = '$pb->mouza_pargona_code' and lot_no = '$pb->lot_no' and "
                . " vill_townprt_code = '$pb->vill_townprt_code' ";
        $details['PetiPart'] = $this->db->query($sql)->result();

        $sql = "Select TRIM(patta_no) from    chitha_basic where dist_code='$pb->dist_code' and subdiv_code='$pb->subdiv_code' and cir_code='$pb->cir_code' and mouza_pargona_code='$pb->mouza_pargona_code'"
                . "and vill_townprt_code='$pb->vill_townprt_code' and lot_no='$pb->lot_no' and (TRIM(patta_no) !='0' and TRIM(patta_no)!='')";
        $details['oldPatta'] = $this->db->query($sql)->result();




        $sql112="Select * from petitioner_part where petition_no = ? and auth_type is not null";
        $petitioner = $this->db->query($sql112,array($pb->petition_no))->result();

        $details['base64_decoded_adhar_file'] = "";
        $details['selfDecData'] = null;
        if(!empty($petitioner) && $petitioner != null){
            
            if($petitioner[0]->self_declaration != null){
            $details['selfDecData'] = json_decode($petitioner[0]->self_declaration);
            }
            

            if($petitioner[0]->auth_type !=null){
                $statusAadhar = "<i class='fa fa-check'></i> ".$petitioner[0]->auth_type. " Verified";
                $aadhaarData = json_decode($petitioner[0]->applicant_info);
                $engName = $aadhaarData->pat_name_eng;
            }else{
                $statusAadhar = 'N/A';
                $engName = null;
            }
            
        

            $details['status'] = $statusAadhar;
            $details['engName'] = $engName;

            $application_no_sql="select * from basundhar_application where dharitree=? ";
            $details['application'] = $this->db->query($application_no_sql,array($pb->case_no))->row();

            
            if (!empty($petitioner) && $petitioner !=null && trim($petitioner[0]->auth_type) == 'AADHAAR' ):

                    $adhar_photo_link = $petitioner[0]->photo;
                    if($adhar_photo_link == null)
                    {
                        $url = RTPS_API_LINK."getApplicantPhoto";
                        $arrayData =array(
                            'application_no' => $details['application']->basundhara,
                        );
                        //*****API call again for aadhar photo missing */
                        $aadhaarPhotoReCall = $this->utilityclass->curlPost($url, $arrayData);
                        if($aadhaarPhotoReCall != 'n')
                        {
                            $aadhaarPhotoDetails = json_decode($aadhaarPhotoReCall);
                            $aadhar_path = AADHAAR_UPLOAD_DIR. $petitioner[0]->id_ref_no . '.json';
                            $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file!");
                            $aadhaar_encoded_file = $aadhaarPhotoDetails->path;
                            fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                            fclose($aadhaar_file_to_write_base64);
           

                            $query = "update petitioner_part set photo = ? where case_no=? and id_ref_no = ? and auth_type is not null";
           
                            $this->db->query($query,array($aadhar_path,$pb->case_no,$petitioner[0]->id_ref_no));
         
                           
                            $adhar_photo_link = $aadhar_path;
                            
                        }
                        else
                        {
                            echo json_encode(array('ERROR885784: API Response fail!'));
                            return false;
                        }


                    }
                    //**********reopening the updated file */
                    $open_adhar_file = fopen($adhar_photo_link, "r") or die("Unable to open file!");
                    $read_adhar_file = fread($open_adhar_file, filesize($adhar_photo_link));
                    fclose($open_adhar_file);
                    // decoding the base64 encoding file variable
                    $details['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($read_adhar_file).";base64,".$read_adhar_file." class='img-thumbnail mrl' alt='Aadhaar Photo' width='170' height='200'>";
          
                
            endif;
        }

        $params = [
          'case_no'          => $case_no,
          'service_code'     => 3,
          'remarks'          => 'Office Partition',
          'accessed_entity'  => 'Aadhaar Name, Photo',
        ];
        $this->load->model('EkycLogModel');
        $log = $this->EkycLogModel->insertEkycAccessedBy($this->db, $params);


        $this->load->view('../views/partition/ModalPartitionReport', $details);
        //$details['_view'] = 'partition/ModalPartitionReport';
    }

    public function saveLMReportOC() {
        //xss & security validation starts
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST,array(),array(),array('lm_note' => true));
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }
        $resp = checkRequestValidQuery($_POST,array(),array('lm_note' => true));
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }
        if($errorMessageStr != ''){
            $this->session->set_flashdata('message', $errorMessageStr);
            return redirect($_SERVER['HTTP_REFERER']);
        }
        //xss & security validation ends 
        // var_dump($this->session->all_userdata());
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        //$db = $this->session->userdata('db');
        $refNO=null;
        //$year_no = $this->session->userdata('year_no');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code');

        //        <!-----posted data---------> 
        $this->db->trans_begin();
        $petition_no = $this->session->userdata('petition_no');
        $case_no = $this->session->userdata('case_no');
        $partition_yn = $this->input->post('partition_yn');
        $partition_year = $this->input->post('partition_year');
        $trans_code = $this->input->post('trans_code');
        $other_cases_yn = $this->input->post('other_cases_yn');
        $revenue_paid_year = $this->input->post('revenue_paid_year');
        $copdar_yn = $this->input->post('copdar_yn');
        $trace_map_yn = $this->input->post('trace_map_yn');
        $ror_byayprak_yn = $this->input->post('ror_byayprak_yn');
        $lm_note = $this->input->post('lm_note');
        $min_revenue = $this->input->post('min_revenue');
        $IspattaSelect = $this->input->post('IspattaSelect');
        if ($IspattaSelect == 'Y') {
            $sugg_pno = $this->input->post('sugg_patta_no');
        } else {
            $sugg_pno = null;
        }
        $sql = "select * from petition_lm_note where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' "
                . "and lot_no ='$lot_no' and petition_no='$petition_no'  and vill_townprt_code='$vill_townprt_code' and case_no='$case_no' ";

        $note_no = $this->db->query($sql)->num_rows();
        $sql = "select * from petition_dag_details WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' "
                . "and lot_no ='$lot_no' and petition_no='$petition_no' and vill_townprt_code='$vill_townprt_code' and case_no='$case_no' ";
        $r = $this->db->query($sql)->row();
        $data = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'year_no' => $r->year_no,
                'petition_no' => $petition_no,
                'dag_no' => $r->dag_no,
                'note_no' => $note_no,
                'mut_b' => $r->m_dag_area_b,
                'mut_k' => $r->m_dag_area_k,
                'mut_lc' => $r->m_dag_area_lc,
                'mut_g' => $r->m_dag_area_g,
                'mut_kr' => $r->m_dag_area_kr,
                'trans_code' => $trans_code,
                'mutation_yn' => $partition_yn,
                'mutation_year' => $partition_year,
                'other_cases_yn' => $other_cases_yn,
                'revenue_paid_year' => $revenue_paid_year,
                'copdar_complain_yn' => $copdar_yn,
                'trace_map_yn' => $trace_map_yn,
                'ror_byayprak_yn' => $ror_byayprak_yn,
                'partition_info' => $lm_note,
                'min_revenue' => $min_revenue,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'lm_sign_yn' => 'Y',
                'lm_code' => $this->session->userdata('user_code'),
                'lm_sign_date' => date('Y-m-d G:i:s'),
                'sugg_pno' => $sugg_pno,
                'case_no' => $case_no
        );
        $byayprak = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'year_no' => date('Y'),
            'petition_no' => $petition_no,
            'mouza_vill_name' => 'NA',
            'pdar_name_add' => 'NA',
            'revenue' => $min_revenue,
            'land_details' => 'NA',
            'pet_name_add_por' =>'NA',
            'por_left_details' =>'NA',
            'survey_time' => 'NA',
            'exp_details' => 'NA',
            'exp_deposite_time' => 'NA',
            'copdar_amt' => 'NA',
            'byayprak_comp_time' => 'NA',
            'remarks' => 'Free Payment For RTPS Services',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d G:i:s'),
            'operation' => 'E',
            'exp_details_total' => 0,
            'copdar_amt_total' => 0
        );
        // var_dump($data);
        $case_no=$this->session->userdata('case_no');
        $found=$this->basundharamodel->checkExistBasundhar($case_no);
        if($found || $this->input->post('application_ref_no')!=null){
            $byayprak['if_paid']='Y';
        }
        ///////////////////////
        $arr = array('lm_note_yn' => 'Y', 'lm_note_date' => date('Y-m-d G:i:s'), 'trans_code' => $trans_code);
        //var_dump($data);
        ////////////////For Basundhara RTPS Only/////////////////////////
        if($found || $this->input->post('application_ref_no')!=null){
            $sql="Select count(*) as c from petition_byayprak  where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and petition_no='$petition_no' ";
            $exists=$this->db->query($sql)->num_rows();
            if($exists==0) {
                $arr['pay_notice_gen_yn']='Y';
                $arr['byayprak_yn']='Y';
                $arr['byayprak_date']=date('Y-m-d G:i:s');
                $tstatus2=$this->db->insert("petition_byayprak", $byayprak);
                if($tstatus2!=1){
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Auto Byay Report Not Submitted. Error Code(#OP003)");
                    redirect(base_url() . "index.php/home");
                    return; 
                }
            }                
        }
        /////////////////////////////////////////
        $tsatus=$this->db->insert("petition_lm_note", $data);
        //$this->db->last_query();
        if($tsatus!=1){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "Select Option not selected. Error Code(#OP001)");
            redirect(base_url() . "index.php/home");
            return;
        }



        $proInsert = $this->mutationmodel->proceeding_order($case_no,$lm_note);


        if($proInsert==false || $proInsert===false)
        {
        log_message('error', "#OPARTLM001:".$this->db->last_query());
        $this->db->trans_rollback();
        $this->session->set_flashdata('message', "Updation failed(#OPARTLM001)".$case_no);
        redirect(base_url() . "index.php/home");
        }


        //ESCALATION ==============
        $es_flag_data = $this->db->query("select es_flag,out_of_esc from  petition_basic where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? "
                . "and lot_no =? and petition_no=?  and vill_townprt_code=?",array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$petition_no,$vill_townprt_code))->row();
        if(ESCALATION_ENABLE == 1 && $es_flag_data->es_flag == 1 && ESCALATION_REMARK_ENABLE ==1 && $es_flag_data->out_of_esc == 0)
        {

            $responseEsc = $this->Escalationmodel->escalationRemarkCheckandUpdate($case_no,$this->input->post('esc_remark'),$this->session->userdata('user_desig_code'));
            if($responseEsc['responseType'] == 1)
            {
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"#ERRPARTESCREMARK111 : Error in submitting in escalation remarks. Please try Again"
                );
                echo json_encode($data);
                return false;
            }

        }
        ///END+==================


        
        //echo $this->db->last_query();
        //ESCALATION CHANGES============SK WITHAW THE ORDER NOTE========
        
        if($es_flag_data->es_flag == 1 && ESCALATION_ENABLE == 1)
        {
            $arr['sk_comment'] = 'Y';
        }
        //END==========
        $this->db->where('case_no', $case_no);
        $this->db->where('petition_no', $petition_no);
        $this->db->where('mut_type', '04');
        $this->db->update("petition_basic", $arr);
        // $this->db->trans_rollback();



     
        // die();
        /////////////////////////////////////////
        $penUser='LM';
        $rmrk=$lm_note;
        $this->DashboardData($case_no,$penUser,$rmrk);
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            $data=array(
                'error'=>"Error in submitting. Please try Again"
            );
        }else
        {

                $dist_code = $this->session->userdata('dist_code');
                $subdiv_code = $this->session->userdata('subdiv_code');
                $cir_code = $this->session->userdata('cir_code');

                //ESCALATION CODE INTEGRATION================SANMRI
                $es_flag_data = $this->db->query("select es_flag,out_of_esc,next_date_of_hearing,proceeding_yn from  petition_basic where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? "
                . "and lot_no =? and petition_no=?  and vill_townprt_code=?",array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$petition_no,$vill_townprt_code))->row();
                if($es_flag_data->es_flag == 1 && ESCALATION_ENABLE == 1 && $es_flag_data->out_of_esc == 0){
                    $user_code = $this->session->userdata('user_code');
                    $executionDate = $this->input->post('executionDate');

                    ///check action taken happen or not/////
                    ///if not then executionDate will be the assigned date otherwise hearing date will be assigned date///
                    if($es_flag_data->proceeding_yn == '1')
                    {
                        $executionDate = date('Y-m-d H:i:s');
                    }
                    else
                    {
                        $executionDate = $es_flag_data->next_date_of_hearing;
                    }

                    $escalationUpdateStatus = $this->Escalationmodel->escalationLMReportOPART($executionDate,$dist_code,$subdiv_code,$cir_code,$case_no,$user_code);


                    log_message("error", "#ESC3083, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

                    if($escalationUpdateStatus['responseType'] == 0){
                        $this->db->trans_rollback();
                        log_message("error", "#ESC3083, transaction-error in method 'Partition/saveLMReportOC' with case-no :". $case_no);
                        $this->session->set_flashdata('message', "Something went wrong.OPART- Error Code(#ESC3083)");
                        redirect(base_url() . "index.php/home");
                    }
                    ///////////////END ESCALATION//////////////
                }


                $this->db->trans_commit();
                if($es_flag_data->es_flag == 1 && ESCALATION_ENABLE == 1)
                {
                    $rmk='LM order Passed';
                    $status='M';
                    $task='LM';
                    $pen='CO';
                }
                else
                {
                    $rmk='LM order Passed';
                    $status='M';
                    $task='LM';
                    $pen='SK';
                }
                $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
                if($basundhara){
                    $case=$case_no;
                    $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
                }   
        }
        ////////////////////
             
        //////////////Applkication Reff no/////////////////////
        // $sql = "select application_ref_no as refNO from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
        // $refNO = $this->db->query($sql)->row()->refno;
        //var_dump($refNO);
        ///////////////////////////////////
        /////////////RTPS////////////////
        if($this->input->post('application_ref_no')!=null){
            $msg='Lot Mondal Verified Successfully.';
            $role='LM';
            $this->SendRtpsStatus($case_no,$msg,$role);
        }
        //exit;
        /////////////END////////////////
        $this->session->set_flashdata('message', 'LM Office Partition Report has Submitted !!');
        redirect(base_url() . 'index.php/home');
    }

    public function MapPartPendingCase() {
        $this->dbswitch();
        //$db = $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $year_no = year_no;
        $q = "Select * from    chitha_rmk_ordbasic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' 
        and mouza_pargona_code='$mouza_pargona_code' and lot_no = '$lot_no' and  map_partition='P' and ord_type_code='04'";
        $data['mappart'] = $this->db->query($q)->result();
        //var_dump($data);
        //$this->load->view('../views/header');
        //$this->load->view('../views/partition/mappartition', $data);
        //$this->load->view('../views/footer');

        $data['_view'] = 'partition/mappartition';
        $this->load->view('layouts/main',$data);
    }

    public function MapPartitionRpt() {
        $case_no = $this->input->get('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        //$db = $this->session->userdata('db');
        $year_no = year_no;
        $q = "Select * from    t_chitha_rmk_ordbasic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and ord_no='$case_no' ";
        $data['mappartdtls'] = $this->db->query($q)->row();
        //var_dump($data);
        //$this->load->view('../views/header');
        //$this->load->view('../views/partition/lmmappartitiondtls', $data);
       // $this->load->view('../views/footer');
        $data['_view'] = 'partition/lmmappartitiondtls';
        $this->load->view('layouts/main',$data);
    }

    function UpdateMapPartitionLM() {
        $ord_no = $this->input->post('ord_no');
        $year_no = $this->input->post('year_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        //$db = $this->session->userdata('db');
        $year_no = year_no;
        $q = "Update  t_chitha_rmk_ordbasic set map_partition='Y'  where ord_no='$ord_no' and   dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
        $this->db->query($q);
        $q = "Update  chitha_rmk_ordbasic set map_partition='Y'  where ord_no='$ord_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
        $this->db->query($q);

        $this->session->set_flashdata('message', 'Map Status has Successfully Updated !! ');
        redirect(base_url() . 'index.php/home');
    }

    public function LMByayPrakF() {
        $data['_view'] = 'partition/LMByayPrakF';
        $this->load->view('layouts/main',$data);
    }

    public function LmByayPrak() {
        $details = array();
        $petition_no = $this->input->get('petition_no');
        $case_no = $this->input->get('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        //$db = $this->session->userdata('db');
        $year_no = year_no;
        $define_date = define_date;
        $partition = array('petition_no' => $petition_no, 'case_no' => $case_no);
        $this->session->set_userdata($partition);
        $sql = "SELECT * from   Petition_Basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code'"
                . " and cir_code='$cir_code' and date_entry>='$define_date' and  case_no = '$case_no' and mut_type='04' and petition_no='$petition_no' ";
        $pb = $details['data'] = $this->db->query($sql)->row();

        $locationData = array(
            'dist_code' => $pb->dist_code,
            'subdiv_code' => $pb->subdiv_code,
            'cir_code' => $pb->cir_code,
            'lot_no' => $pb->lot_no,
            'vill_townprt_code' => $pb->vill_townprt_code,
            'mouza_pargona_code' => $pb->mouza_pargona_code,
            'rtps_no' => $pb->application_ref_no,
                //'year_no' => $pb->year_no
        );
        $this->session->set_userdata($locationData);
        $location = $this->utilityclass->getLocationFromSession();
        //echo $pb->dist_code;
        $dist_code = $this->utilityclass->getDistrictName($pb->dist_code);
        $subdiv_code = $this->utilityclass->getSubDivName($pb->dist_code, $pb->subdiv_code);
        $cir_code = $this->utilityclass->getCircleName($pb->dist_code, $pb->subdiv_code, $pb->cir_code);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($pb->dist_code, $pb->subdiv_code, $pb->cir_code, $pb->mouza_pargona_code);
        $lot_no = $this->utilityclass->getLotName($pb->dist_code, $pb->subdiv_code, $pb->cir_code, $pb->mouza_pargona_code, $pb->lot_no);
        $vill_townprt_code = $this->utilityclass->getVillageName($pb->dist_code, $pb->subdiv_code, $pb->cir_code, $pb->mouza_pargona_code, $pb->lot_no, $pb->vill_townprt_code);
        $details['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code
        );
        $q = "select * from    petition_dag_details "
                . "where petition_no='$pb->petition_no' and dist_code='$pb->dist_code' and "
                . " cir_code = '$pb->cir_code' and subdiv_code='$pb->subdiv_code' and "
                . " mouza_pargona_code = '$pb->mouza_pargona_code' and lot_no = '$pb->lot_no' and "
                . " vill_townprt_code = '$pb->vill_townprt_code' ";
        //echo $q;
        $dag = $details['dags'] = $this->db->query($q)->row();
        //var_dump($dag);
        $sql = "select * from    petitioner_part "
                . "where petition_no='$pb->petition_no' and dist_code='$pb->dist_code' and "
                . " cir_code = '$pb->cir_code' and subdiv_code='$pb->subdiv_code' and "
                . " mouza_pargona_code = '$pb->mouza_pargona_code' and lot_no = '$pb->lot_no' and "
                . " vill_townprt_code = '$pb->vill_townprt_code'";
        $details['PetiPart'] = $this->db->query($sql)->result();

        $sql = "Select patta_no from    chitha_basic where dist_code='$pb->dist_code' and subdiv_code='$pb->subdiv_code' and cir_code='$pb->cir_code' and mouza_pargona_code='$pb->mouza_pargona_code'"
                . "and vill_townprt_code='$pb->vill_townprt_code' and lot_no='$pb->lot_no' and (TRIM(patta_no) !='0' and TRIM(patta_no)!=' ')";
        //echo $sql;
        $details['oldPatta'] = $this->db->query($sql)->result();
        //var_dump($result);

        $sql = "Select patta_no,patta_type_code from    petition_dag_details WHERE dist_code = '$pb->dist_code' and subdiv_code = '$pb->subdiv_code' and cir_code = '$pb->cir_code' "
                . "and mouza_pargona_code = '$pb->mouza_pargona_code' and lot_no = '$pb->lot_no' and vill_townprt_code = '$pb->vill_townprt_code' and petition_no = '$pb->petition_no' ";
        $p = $details['patta'] = $this->db->query($sql)->row();
        $sql = "SELECT patta_type FROM  Patta_code WHERE type_code = '$p->patta_type_code'";
        $details['pattaName'] = $this->db->query($sql)->row();
        $sql = "Select pdar_id from    Chitha_dag_pattadar WHERE dist_code = '$pb->dist_code' and subdiv_code = '$pb->subdiv_code' and cir_code = '$pb->cir_code' "
                . "and mouza_pargona_code = '$pb->mouza_pargona_code' and lot_no = '$pb->lot_no' and vill_townprt_code = '$pb->vill_townprt_code' and patta_type_code='$p->patta_type_code' and patta_no=trim('$p->patta_no') and dag_no='$dag->dag_no' and (p_flag ='0' or p_flag is null) ";
        $pattadar = $this->db->query($sql)->result();
        foreach ($pattadar as $pp) {
            $sql = "Select pdar_name,pdar_father,pdar_add1,pdar_add2,pdar_add3 from    Chitha_pattadar WHERE dist_code = '$pb->dist_code' and subdiv_code = '$pb->subdiv_code' and cir_code = '$pb->cir_code' "
                    . "and mouza_pargona_code = '$pb->mouza_pargona_code' and lot_no = '$pb->lot_no' and vill_townprt_code = '$pb->vill_townprt_code' and patta_type_code='$p->patta_type_code' and TRIM(patta_no)=trim('$p->patta_no') and pdar_id='$pp->pdar_id'  ";
            $count=$this->db->query($sql)->num_rows();
            if($count==0)
                continue;
            $details['pattaDar'][] = $this->db->query($sql)->result();
        }
        //echo $sql;
        $sql = "Select min_revenue as revenue_rs from petition_lm_note WHERE dist_code = '$pb->dist_code' and subdiv_code = '$pb->subdiv_code' and cir_code = '$pb->cir_code' "
                . "and mouza_pargona_code = '$pb->mouza_pargona_code' and lot_no = '$pb->lot_no' and vill_townprt_code = '$pb->vill_townprt_code' and petition_no = '$pb->petition_no'";
        $plm = $this->db->query($sql)->row();       
        $size_arr = $plm->revenue_rs;
        $bigha = 0;
        $katha = 0;
        $lessa = 0;
        if ($size_arr != 0) {
            //echo $plm->revenue_rs;
            $r = ($bigha * 100 + $katha * 20 + $lessa );
            if ($r <= 100) {
                $r = $plm->revenue_rs;
            } else {
                $r = ($bigha * 100 + $katha * 20 + $lessa ) * $plm->revenue_rs;
                $r = $r / 100;
            }
        } else {
            $r = 0;
        }
        $details['revenue'] = $r;
        $details['_view'] = 'partition/ByakprakLMReport';
        $this->load->view('layouts/main',$details);
    }
    
    public function SaveLmByayPrak() {
        $this->db->trans_begin();
        $dist_code = $this->session->userdata('dist_code');
        //$db = $this->session->userdata('db');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code');
        $petition_no = $this->session->userdata('petition_no');
        // $year_no = $this->session->userdata('year_no');
        //              posted value
        $mouza_vill_name = $this->input->post('mouza_vill_name');
        $pdar_name_add = $this->input->post('pdar_name_add');
        $revenue = $this->input->post('revenue');
        $land_details = $this->input->post('land_details');
        $pet_name_add_por = $this->input->post('pet_name_add_por');
        $por_left_details = $this->input->post('por_left_details');
        $survey_time = $this->input->post('survey_time');
        $exp_details = $this->input->post('exp_details');
        $exp_details_total = $this->input->post('exp_details_total');
        $copdar_amt = $this->input->post('copdar_amt');
        $copdar_amt_total = $this->input->post('copdar_amt_total');
        $exp_deposite_time = $this->input->post('exp_deposite_time');
        $byayprak_comp_time = $this->input->post('byayprak_comp_time');
        $remarks = $this->input->post('remarks');
        //var_dump($this->session->all_userdata());
        if($exp_details_total==0 && $copdar_amt_total==0){
            $this->session->set_flashdata('message','Amount can not be zero. Please enter the amount correctly');
            redirect('/home');
        }
        $data = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'year_no' => date('Y'),
            'petition_no' => $petition_no,
            'mouza_vill_name' => $mouza_vill_name,
            'pdar_name_add' => $pdar_name_add,
            'revenue' => $revenue,
            'land_details' => $land_details,
            'pet_name_add_por' => $pet_name_add_por,
            'por_left_details' => $por_left_details,
            'survey_time' => $survey_time,
            'exp_details' => $exp_details,
            'exp_deposite_time' => $exp_deposite_time,
            'copdar_amt' => $copdar_amt,
            'byayprak_comp_time' => $byayprak_comp_time,
            'remarks' => $remarks,
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d G:i:s'),
            'operation' => 'E',
            'exp_details_total' => $exp_details_total,
            'copdar_amt_total' => $copdar_amt_total
        );
        // var_dump($data);
        $case_no=$this->session->userdata('case_no');
        $found=$this->basundharamodel->checkExistBasundhar($case_no);
        if($found || $this->session->userdata('rtps_no')!=null){
            $data['if_paid']='Y';
        }
        ///////////////////////

        $this->db->insert("petition_byayprak", $data);
        //exit;
        $arr = array('byayprak_yn' => 'Y', 'byayprak_date' => date('Y-m-d G:i:s'));
        ///////////////////
        //var_dump($arr);
        $this->db->where('petition_no', $petition_no);
        $this->db->where('mut_type', '04');
        $this->db->where('cir_code', $cir_code);
        $this->db->where('subdiv_code', $subdiv_code);
        //$this->db->where('year_no',$year_no);
        $this->db->update("petition_basic", $arr);
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', 'Error in Submitting');
            redirect(base_url() . 'index.php/home');
        }else{
            $this->db->trans_commit();
            ///////
            $penUser='SK';
            $rmrk='ByayPrak Report Submitted by LM';
            $this->DashboardData($case_no,$penUser,$rmrk);
            ////////
            $this->session->set_flashdata('message',"Application Forwarded to Circle Officer Successfully with case no $case_no ");
        }
        
        $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
        if($basundhara){
            $rmk='ByayPrak Report Submitted by LM';
            $status='M';
            $task='LM';
            $pen='SK';
            $case=$case_no;
            $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
        }
        //////////////////////////////
        $this->session->set_flashdata('message', 'LM has Submitted ByayPrak Report ');
        redirect(base_url() . 'index.php/home');
    }

    public function ConsentPendingCase() {
        //var_dump($this->session->all_userdata());
        $this->load->library('pagination');
        $data = array();
        //$db = $this->session->userdata('db');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $year_no = year_no;
        $user_code = $this->session->userdata('user_code');
        $define_date = define_date;
        $config['base_url'] = base_url() . 'index.php/partition/'
                . 'ConsentPendingCase';
        $c_q = "SELECT *,ba.basundhara from petition_basic pb left join basundhar_application ba on pb.case_no=ba.dharitree INNER JOIN (SELECT dist_code, subdiv_code, cir_code, mouza_pargona_code,"
                . " Lot_No, vill_townprt_code, Year_no, Petition_no,TRIM(patta_no), patta_type_code,dag_no FROM  petitioner_part GROUP BY dist_code, subdiv_code, "
                . "cir_code, mouza_pargona_code, Lot_No, vill_townprt_code, Year_no, Petition_no, TRIM(patta_no),patta_type_code,dag_no) pp ON pb.dist_code = pp.dist_code AND "
                . "pb.subdiv_code = pp.subdiv_code AND pb.cir_code = pp.cir_code AND pb.mouza_pargona_code = pp.mouza_pargona_code AND pb.Lot_No = pp.Lot_No "
                . "AND pb.vill_townprt_code = pp.vill_townprt_code AND pb.Petition_no = pp.Petition_no WHERE pb.dist_code='$dist_code' and pb.cir_code='$cir_code'
                    and pb.mouza_pargona_code='$mouza_pargona_code' and pb.date_entry>='$define_date' and pb.status='P' and  pb.lot_no='$lot_no' and pb.mut_type='04' and pb.status='P' and  pb.consent_updated is null";
        //echo $c_q;
        $cases = $this->db->query($c_q)->result();
        $data['cases'] = $cases;

        //$this->load->view('../views/header');
        //$this->load->view('../views/partition/ConsentPending', $data);
       // $this->load->view('../views/footer');
        $data['_view'] = 'partition/ConsentPending';
        $this->load->view('layouts/main',$data);
    }

    public function LMConsent() {
        $values = array();
        $num = array();
        $case_no = $this->input->get('case_no');
        $lmcode = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        //$db = $this->session->userdata('db');
        $year_no = year_no;
        $case = array(
            'case' => $case_no);
        $this->session->set_userdata($case);
        $sql = "SELECT pb.*,pp.dag_no, pp.Patta_no, pp.patta_type_code from   Petition_Basic pb INNER JOIN (SELECT dist_code, subdiv_code, cir_code, mouza_pargona_code, Lot_No, vill_townprt_code, Year_no, Petition_no,Patta_no, patta_type_code,dag_no from   petitioner_part "
                . "GROUP BY dist_code, subdiv_code, cir_code, mouza_pargona_code, Lot_No, vill_townprt_code, Year_no, Petition_no, Patta_no,patta_type_code,dag_no) pp ON pb.dist_code = pp.dist_code AND pb.subdiv_code = pp.subdiv_code AND pb.cir_code = pp.cir_code AND pb.mouza_pargona_code = pp.mouza_pargona_code AND pb.Lot_No = pp.Lot_No AND pb.vill_townprt_code = pp.vill_townprt_code AND"
                . "  pb.Petition_no = pp.Petition_no WHERE  pb.dist_code='$dist_code' and pb.subdiv_code='$subdiv_code' and pb.cir_code='$cir_code' and pb.mouza_pargona_code='$mouza_pargona_code' and pb.status='P' and pb.Lot_No='$lot_no' and pb.mut_type='04' and pb.case_no='$case_no' order by pb.submission_date";
        $data = $this->db->query($sql)->row();
        $pdar = "SELECT pdar_id from   petitioner_part WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_No='$lot_no' and TRIM(patta_no)=trim('$data->patta_no') and "
                . "dag_No='$data->dag_no' and patta_type_code='$data->patta_type_code' and petition_no='$data->petition_no' ";

        $sql1 = "SELECT Copattadar_id from   copattadar_consent WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and Lot_No='$lot_no' and TRIM(patta_no)=trim('$data->patta_no') and "
                . "Patta_Type_code='$data->patta_type_code' and case_no='$data->case_no'";

        $sql = "select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from    chitha_pattadar p join  chitha_dag_pattadar d 
                on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code and p.lot_no = d.lot_no 
                and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and p.pdar_id = d.pdar_id 
                where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and p.mouza_pargona_code='$mouza_pargona_code'
                and d.lot_no='$lot_no' and d.vill_townprt_code='$data->vill_townprt_code' and p.pdar_ID NOT IN ($sql1) and p.pdar_id NOT IN ($pdar) and (d.p_flag='0' or d.p_flag is null) and d.dag_no='$data->dag_no' and TRIM(p.patta_no)=trim('$data->patta_no') and p.patta_type_code='$data->patta_type_code'";

        $val = $this->db->query($sql)->result();
        $arrData = sizeof($val);
        if ($arrData != 0) {
            foreach ($val as $val) {
                $values['values'][] = array
                    (
                    'pdar_name' => $val->pdar_name,
                    'pdar_id' => $val->pdar_id,
                    'case_no' => $data->case_no,
                    'date_entry' => $data->date_entry,
                    'vill_townprt_code' => $data->vill_townprt_code,
                    'patta_no' => trim($data->patta_no),
                    'patta_type_code' => $data->patta_type_code,
                    'dag_no' => $data->dag_no
                );
                //var_dump($values);
            }
        } else {
            $values['values'] = array();
        }

        $values['_view'] = 'partition/ConsentNumber';
        $this->load->view('layouts/main',$values);
    }

    public function UpdatedAllConsent() {
        //var_dump($this->session->all_userdata());
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $case_no = $this->session->userdata('case');
        //$db = $this->session->userdata('db');
        $year_no = year_no;
        $data = array(
            'consent_updated' => 'Y'
        );
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('case_no', $case_no);
        // $this->db->where('year_no', $year_no);
        $this->db->update("petition_basic", $data);
        //////////////////////////////////
        $penUser='SK';$rmrk='Consent Updated by LM';
        $this->DashboardData($case_no,$penUser,$rmrk);
        ///////////////////
        $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
        if($basundhara){
                $rmk='Consent Updated by LM';
                $status='M';
                $task='LM';
                $pen='SK';
                $case=$case_no;
                $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
        }
        /////////////////////////////////

        $this->session->set_flashdata('message', 'Copattadar(s) consent has updated !!');
        redirect(base_url() . 'index.php/home');
    }

    public function LmConsentCoPattadar() {

        $pdar_id = $this->input->get('pdar_id');
        $pdar_name = $this->input->get('pdar_name');
        $case_no = $this->input->get('case');
        $vill_townprt_code = $this->input->get('vill');
        $dag_no = $this->input->get('dag');
        $patta_no = trim($this->input->get('patta_no'));
        $patta_type_code = $this->input->get('pcode');
        //$this->load->view('../views/header');
        //$this->load->view('../views/partition/ConsentCoPattadarReport');
        //$this->load->view('../views/footer');
        $data['_view'] = 'partition/ConsentCoPattadarReport';
        $this->load->view('layouts/main',$data);
    }

    public function SaveConsentF() {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');

        $vill_townprt_code = $this->input->post('vill_townprt_code');



        $concent = $this->input->post('concent');

        $patta_no = trim($this->input->post('patta_no'));
        $patta_type_code = $this->input->post('patta_type_code');
        $case_no = $this->input->post('case_no');
        $copattadar_name = $this->input->post('copattadar_name');
        $chekbox = $this->input->post('chekbox');
        $copattadar_id = $this->input->post('copattadar_id');
        $copattadar_comment = $this->input->post('copattadar_comment');

        for ($i = 0; $i < sizeof($chekbox); $i++) {
            $data = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'copattadar_id' => $copattadar_id[$i],
                'patta_no' => $patta_no,
                'patta_type_code' => $patta_type_code,
                'case_no' => $case_no,
                'copattadar_name' => $copattadar_name[$i],
                'consent' => $chekbox[$i],
                'copattadar_comment' => $copattadar_comment[$i],
                'mut_type' => '04',
                'entry_date' => date('Y-m-d G:i:s')
            );
            //var_dump($data);
            $this->db->insert('copattadar_consent', $data);
        }
        //redirect(base_url() . 'index.php/home');
        redirect(base_url() . "index.php/partition/LMConsent?case_no=$case_no");
    }

    /*
     * END LM Part  ----------------------------------------------------------------------------------------------------
     * Start SK Part  ----------------------------------------------------------------------------------------------------
     */

    public function SKPartition() {
        //$this->load->view('../views/header');
        //$this->load->view('../views/partition/SkReportList');
        //$this->load->view('../views/footer');
        $data['_view'] = 'partition/SkReportList';
        $this->load->view('layouts/main',$data);
    }

    public function SKPartitionR() {
        //var_dump($this->session->all_userdata());
        $petition_no = $this->session->userdata('petition_no');

        $case_no = $this->session->userdata('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        //$db = $this->session->userdata('db');
        $year_no = year_no;
        $sql = "Select * from    petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and case_no='$case_no' and petition_no='$petition_no'";
        $pb = $data['pb'] = $this->db->query($sql)->row();
        if($pb->application_ref_no){
            $url =RTPS_LINK. "partition/partition_attachment_details.php?application_ref_no=" . $pb->application_ref_no . "&applid=" . $pb->applid;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            $output = curl_exec($ch);
            curl_close($ch);
            $output = json_decode($output); 
            $data['attachment'] = $output;
        }
        $location = $this->utilityclass->getLocationFromSession();
        //echo $pb->dist_code;
        $dist_code = $this->utilityclass->getDistrictName($pb->dist_code);
        $subdiv_code = $this->utilityclass->getSubDivName($pb->dist_code, $pb->subdiv_code);
        $cir_code = $this->utilityclass->getCircleName($pb->dist_code, $pb->subdiv_code, $pb->cir_code);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($pb->dist_code, $pb->subdiv_code, $pb->cir_code, $pb->mouza_pargona_code);
        $lot_no = $this->utilityclass->getLotName($pb->dist_code, $pb->subdiv_code, $pb->cir_code, $pb->mouza_pargona_code, $pb->lot_no);
        $vill_townprt_code = $this->utilityclass->getVillageName($pb->dist_code, $pb->subdiv_code, $pb->cir_code, $pb->mouza_pargona_code, $pb->lot_no, $pb->vill_townprt_code);
        $data['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code
        );
        $q = "select * from    petition_dag_details "
                . "where petition_no='$pb->petition_no' and dist_code='$pb->dist_code' and "
                . " cir_code = '$pb->cir_code' and subdiv_code='$pb->subdiv_code' and "
                . " mouza_pargona_code = '$pb->mouza_pargona_code' and lot_no = '$pb->lot_no' and "
                . " vill_townprt_code = '$pb->vill_townprt_code'  and case_no='$case_no'";
        // echo $q;
        $data['dags'] = $this->db->query($q)->result();

        $sql = "select * from    petitioner_part "
                . "where petition_no='$pb->petition_no' and dist_code='$pb->dist_code' and "
                . " cir_code = '$pb->cir_code' and subdiv_code='$pb->subdiv_code' and "
                . " mouza_pargona_code = '$pb->mouza_pargona_code' and lot_no = '$pb->lot_no' and "
                . " vill_townprt_code = '$pb->vill_townprt_code' ";
        $data['PetiPart'] = $this->db->query($sql)->result();
        $sql = "select * from    petition_lm_note "
                . "where petition_no='$pb->petition_no' and dist_code='$pb->dist_code' and "
                . " cir_code = '$pb->cir_code' and subdiv_code='$pb->subdiv_code' and "
                . " mouza_pargona_code = '$pb->mouza_pargona_code' and lot_no = '$pb->lot_no' and "
                . " vill_townprt_code = '$pb->vill_townprt_code'";
        $data['lmNote'] = $this->db->query($sql)->result();
        //$lmname=$this->utilityclass->getDefinedMondalsName($pb->dist_code,$pb->subdiv_code,$pb->cir_code,$pb->mouza_pargona_code,$pb->lot_no,$lm->lm_code);
        // $data['lmname']=$lmname;
        $sql = "Select * from    petition_dag_details where petition_no='$petition_no' and dist_code='$pb->dist_code' and "
                . " cir_code = '$pb->cir_code' and subdiv_code='$pb->subdiv_code' and "
                . " mouza_pargona_code = '$pb->mouza_pargona_code' and lot_no = '$pb->lot_no' and "
                . " vill_townprt_code = '$pb->vill_townprt_code'  ";
        $data['dag_no'] = $this->db->query($sql)->row();




        if(ESCALATION_ENABLE == 1)
        {
        $sql112="Select * from petitioner_part where petition_no = ? and auth_type is not null";
        $petitioner = $this->db->query($sql112,array($petition_no))->result();

        $data['base64_decoded_adhar_file'] = "";
        $data['selfDecData'] = null;
        if(!empty($petitioner) && $petitioner != null){
            
            if($petitioner[0]->self_declaration != null){
            $data['selfDecData'] = json_decode($petitioner[0]->self_declaration);
            }
            

            if($petitioner[0]->auth_type !=null){
                $statusAadhar = "<i class='fa fa-check'></i> ".$petitioner[0]->auth_type. " Verified";
                $aadhaarData = json_decode($petitioner[0]->applicant_info);
                $engName = $aadhaarData->pat_name_eng;
            }else{
                $statusAadhar = 'N/A';
                $engName = null;
            }
            
        

            $data['status'] = $statusAadhar;
            $data['engName'] = $engName;

            $application_no_sql="select * from basundhar_application where dharitree=? ";
            $data['application'] = $this->db->query($application_no_sql,array($pb->case_no))->row();

            
            if (!empty($petitioner) && $petitioner !=null && trim($petitioner[0]->auth_type) == 'AADHAAR' ):

                    $adhar_photo_link = $petitioner[0]->photo;
                    if($adhar_photo_link == null)
                    {
                        $url = RTPS_API_LINK."getApplicantPhoto";
                        $arrayData =array(
                            'application_no' => $data['application']->basundhara,
                        );
                        //*****API call again for aadhar photo missing */
                        $aadhaarPhotoReCall = $this->utilityclass->curlPost($url, $arrayData);
                        if($aadhaarPhotoReCall != 'n')
                        {
                            $aadhaarPhotoDetails = json_decode($aadhaarPhotoReCall);
                            $aadhar_path = AADHAAR_UPLOAD_DIR. $petitioner[0]->id_ref_no . '.json';
                            $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file!");
                            $aadhaar_encoded_file = $aadhaarPhotoDetails->path;
                            fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                            fclose($aadhaar_file_to_write_base64);
           

                             $query = "update petitioner_part set photo = ? where case_no=? and id_ref_no = ? and auth_type is not null";
           
                            $this->db->query($query,array($aadhar_path,$pb->case_no,$petitioner[0]->id_ref_no));

                           
                            $adhar_photo_link = $aadhar_path;
                            
                        }
                        else
                        {
                            echo json_encode(array('ERROR885784: API Response fail!'));
                            return false;
                        }


                    }
                    //**********reopening the updated file */
                    $open_adhar_file = fopen($adhar_photo_link, "r") or die("Unable to open file!");
                    $read_adhar_file = fread($open_adhar_file, filesize($adhar_photo_link));
                    fclose($open_adhar_file);
                    // decoding the base64 encoding file variable
                    $data['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($read_adhar_file).";base64,".$read_adhar_file." class='img-thumbnail mrl' alt='Aadhaar Photo' width='170' height='200'>";
          
                
            endif;
            }
        }


        $data['basuCase']=$data['basundharaAttachment']=$data['query']=null;
        $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
        if($basundharaExist){
            $data['query']=null;
            $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
            $data['query']=$this->basundharamodel->QueryPost($basundharaExist);
        }
        $data['_view'] = 'partition/SkReportForm';
        $this->load->view('layouts/main',$data);
    }

    public function SKPartitionRedirect() {
        $case_no = $this->input->get('case_no');
        $petition_no = $this->input->get('p');
        $year = $this->input->get('y');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        //$db = $this->session->userdata('db');
        $year_no = year_no;
        $sql = "Select * from    petition_basic where petition_no='$petition_no' and  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and case_no='$case_no'";
        //echo $sql;
        $data = $this->db->query($sql)->row();
        $dataa = array(
            'dist_code' => $data->dist_code,
            'subdiv_code' => $data->subdiv_code,
            'cir_code' => $data->cir_code,
            'mouza_pargona_code' => $data->mouza_pargona_code,
            'lot_no' => $data->lot_no,
            'vill_townprt_code' => $data->vill_townprt_code,
            'petition_no' => $data->petition_no,
            //'year_no' => $data->year_no,
            'case_no' => $case_no
        );
        $this->session->set_userdata($dataa);
        redirect(base_url() . 'index.php/partition/SKPartitionR');
    }

    public function SaveSKData() {
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
        $dag_no = $this->input->post('dag_no');
        $sk_comment = $this->input->post('sk_comment');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code');
        $petition_no = $this->session->userdata('petition_no');
        //$year_no = $this->session->userdata('year_no');
        $case_no = $this->session->userdata('case_no');
        //$db = $this->session->userdata('db');
        $this->db->trans_begin();
        $query1 = "select es_flag,next_date_of_hearing from  petition_basic where petition_no = ?
        and dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and vill_townprt_code = ? and lot_no = ?;
        ";
        $data_petition = $this->db->query($query1, array($petition_no,$dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$vill_townprt_code,$lot_no))->row(); 


        $data = array(
            'sk_note_date' => date('Y-m-d G:i:s'),
            'sk_note' => $sk_comment,
            'sk_sign_yn' => 'Y',
            'user_code' => $this->session->userdata('user_code')
        );
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('mouza_pargona_code', $mouza_pargona_code);
        $this->db->where('vill_townprt_code', $vill_townprt_code);
        $this->db->where('lot_no', $lot_no);
        //$this->db->where('year_no', $year_no);
        $this->db->where('petition_no', $petition_no);
        $this->db->update("petition_lm_note", $data);
        $arr = array('sk_comment' => 'Y');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('mouza_pargona_code', $mouza_pargona_code);
        $this->db->where('vill_townprt_code', $vill_townprt_code);
        $this->db->where('lot_no', $lot_no);
        //$this->db->where('year_no', $year_no);
        $this->db->where('petition_no', $petition_no);
        $this->db->where('case_no', $case_no);
        $this->db->update("petition_basic", $arr);

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        //ESCALATION CODE INTEGRATION================SANMRI
        
        
        log_message("error","LAST QUERY====".$this->db->last_query());
        // log_message("error","DATA==========".json_encode();
        // if($data_petition->es_flag == 1 && ESCALATION_ENABLE == 1){
        //     $hearing_date = date('Y-m-d',strtotime($data_petition->next_date_of_hearing));
        //     $executionDate = $this->input->post('executionDate');
        //     $user_code = $this->session->userdata('user_code');
        //     $escalationUpdateStatus = $this->Escalationmodel->escalationSKReportOPART($executionDate,$dist_code,$subdiv_code,$cir_code,$case_no,$user_code,$hearing_date);
        //     log_message("error", "#ESC3865, transaction-error-STATUS======".json_encode($escalationUpdateStatus));
        //     if($escalationUpdateStatus['responseType'] == 0){
        //         // $this->db->trans_rollback();
        //         log_message("error", "#ESC3865, transaction-error in method 'skmutation/writeOfficeReport' with case-no :". $case_no);
        //         $this->session->set_flashdata('message', "Something went wrong.OPART- Error Code(#ESC3865)");
        //         redirect(base_url() . "index.php/home");
        //     }
            
        // }


        // $this->db->trans_commit();



        ///////////////////////////////////////////
        $penUser='CO';$rmrk=$sk_comment;
        $this->DashboardData($case_no,$penUser,$rmrk);
        ////////////////
        $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
        if($basundhara){
            $rmk='SK submitted his report';
            $status='M';
            $task='SK';
            $pen='CO';
            $case=$case_no;
            $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
        }
        ///////////////////////////////////


        $proInsert = $this->mutationmodel->proceeding_order($case_no,$rmrk);


           if($proInsert==false || $proInsert===false)
            {
                log_message('error', "#OPARTSK001:".$this->db->last_query());
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Updation failed(#OPARTSK001)".$case_no);
                redirect(base_url() . "index.php/home");
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata("message", "Something went wrong");
                redirect(base_url() . "index.php/home");
            }else{
                $this->db->trans_commit();
                 $this->session->set_flashdata("message","SK Report Submitted Successfully...");
                redirect(base_url() . "index.php/home");
            }

        // $this->session->set_flashdata('message', 'SK Submitted his report for Office Partition Case No.#' . "$case_no");
        // redirect(base_url() . 'index.php/home/index');
        //var_dump($arr);
    }

    public function getdesignation($user_code) {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $q = "Select * from    loginuser_table where dist_code='$dist_code' and subdiv_code='$subdiv_code' 
        and cir_code='$cir_code' and priv='adm' and dis_enb_option='E' ";
        $name = $this->db->query($q)->result();
        foreach ($name as $n) {
            $q = "select * from    users where dist_code='$dist_code' and subdiv_code='$subdiv_code' 
        and cir_code='$cir_code' and user_desig_code='$user_code' and user_code='$n->user_code' ";
            $data = $this->db->query($q);
            $data = $data->result();
        }
        $json = array();
        foreach ($data as $object) {
            $json[] = array('username' => $object->username, 'user_code' => $object->user_code);
        }
        echo json_encode($json);
        // echo json_encode($co_name);
    }

    /*
     * END SK Part  ----------------------------------------------------------------------------------------------------

     */

    function MapPartitionUpdate() {
        $this->dbswitch();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $q = "Select * from t_chitha_rmk_ordbasic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                . "and ( iscorrected_inco is null or iscorrected_inco=' ' ) and ord_type_code='04' ";
        $data['mappart'] = $this->db->query($q)->result();
        $data['_view'] = 'partition/mappartitiondtls';
        $this->load->view('layouts/main',$data);
    }

    // Update Chitha.......
    public function updateChithaPartition($case_no) {
        //$case_no = $this->session->userdata('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        //$db = $this->session->userdata('db');
        $year_no = year_no;
        $query = "select * from    t_chitha_rmk_ordbasic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                . "and "
                . " (iscorrected_inco is null or iscorrected_inco=' ') and ord_no='$case_no' and ord_type_code='04'  ";
        $result = $this->db->query($query);
        
        if($result->num_rows() <=0)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "OPTCRO001: Unable to update chitha !");
            log_message("error","#OPTCRO001 data not found in t_chitha_rmk_ordbasic dist: "
                    .$dist_code.", case no: ".  $case_no );
            redirect(base_url() . "index.php/home");
            return;
        }

        $result = $result->result();

        //$this->db->trans_begin();
        $validation = array();
        foreach ($result as $order) {
           
            $query_rmk_hist = "select max(rmk_type_hist_no) as c from    chitha_rmk_gen where "
                    . "dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' and cir_code='$order->cir_code'"
                    . " and lot_no='$order->lot_no' and mouza_pargona_code='$order->mouza_pargona_code' and "
                    . " vill_townprt_code='$order->vill_townprt_code' and dag_no='$order->dag_no' ";
            $rmk_hist_no = $this->db->query($query_rmk_hist)->row()->c;
            if ($rmk_hist_no == null) {
                $rmk_hist_no = 1;
            } else
                $rmk_hist_no += 1;
            $q = "select max(ord_cron_no)+1 as c1,max(rmk_type_hist_no)+1 as c2 from    chitha_rmk_ordbasic where "
                    . "dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' and cir_code='$order->cir_code'"
                    . " and lot_no='$order->lot_no' and mouza_pargona_code='$order->mouza_pargona_code' and "
                    . " vill_townprt_code='$order->vill_townprt_code' and dag_no='$order->dag_no' ";
            $ord_cron_no = $this->db->query($q)->row()->c1;
            if ($ord_cron_no == null) {
                $ord_cron_no = 1;
            } else {
                $ord_cron_no+=1;
            }
            $infavQuery = "select * from    t_chitha_rmk_infavor_of where ord_no='$order->ord_no' "
                    . "and dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' and cir_code='$order->cir_code' and  iscorrected_inco is null ";
            $infavData = $this->db->query($infavQuery)->result();
            $pdar_id = 1;
            $chitha_basic_update = 0;
            
            foreach ($infavData as $d) {
                $landclass_query = "select land_class_code from    chitha_basic  where dist_code='$d->dist_code' and"
                        . " subdiv_code='$d->subdiv_code' and cir_code='$order->cir_code'"
                        . " and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
                        . " vill_townprt_code='$d->vill_townprt_code' and dag_no='$d->dag_no' ";
                // . " and patta_type_code='$d->patta_type_code' and TRIM(patta_no)=trim('$d->patta_no')";
                //echo $landclass_query;
                $landclasscode = $this->db->query($landclass_query)->row()->land_class_code;
                // for chitha update
                if ($chitha_basic_update == 0) {
                    $chitha_basic = array(
                        'dist_code' => $d->dist_code,
                        'subdiv_code' => $d->subdiv_code,
                        'cir_code' => $d->cir_code,
                        'mouza_pargona_code' => $d->mouza_pargona_code,
                        'lot_no' => $d->lot_no,
                        'vill_townprt_code' => $d->vill_townprt_code,
                        'old_dag_no' => $d->dag_no,
                        'dag_no' => $d->new_dag_no,
                        'dag_no_int' => $d->new_dag_no . '00',
                        'patta_type_code' => $d->patta_type_code,
                        'patta_no' => trim($d->new_patta_no),
                        'land_class_code' => $landclasscode,
                        'dag_area_b' => $d->land_area_b,
                        'dag_area_k' => $d->land_area_k,
                        'dag_area_lc' => $d->land_area_lc,
                        'dag_area_g' => $d->land_area_g,
                        'dag_area_kr' => 0,
                        'dag_revenue' => $d->revenue,
                        'dag_local_tax' => ($d->revenue) / 4,
                        'user_code' => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d G:i:s'),
                        'operation' => 'E',
                        'jama_yn' => 'n',
                        'old_patta_no' => trim($d->patta_no)
                    );
                    // var_dump($chitha_basic);
                    if ($d->dag_no == $d->new_dag_no) {
                        // $chitha_update = "update  chitha_basic set patta_no='$d->new_patta_no',jama_yn='n'  where dist_code='$d->dist_code' and"
                        //         . " subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code'"
                        //         . " and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
                        //         . " vill_townprt_code='$d->vill_townprt_code' and dag_no='$d->dag_no'  "
                        //         . " and TRIM(patta_no)=trim('$d->patta_no') and patta_type_code='$d->patta_type_code'";
                        // //echo $chitha_update;
                        // $this->db->query($chitha_update);

                        $table = "chitha_basic";

                        $params = [
                            'patta_no' => $d->new_patta_no,
                            'jama_yn'  => 'n'
                        ];

                        $where = [
                            'dist_code'          => $d->dist_code,
                            'subdiv_code'        => $d->subdiv_code,
                            'cir_code'           => $d->cir_code,
                            'lot_no'             => $d->lot_no,
                            'mouza_pargona_code' => $d->mouza_pargona_code,
                            'vill_townprt_code'  => $d->vill_townprt_code,
                            'dag_no'             => $d->dag_no,
                            'patta_no'           => trim($d->patta_no),  // equivalent to TRIM(patta_no) = trim(...)
                            'patta_type_code'    => $d->patta_type_code
                        ];

                        $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                        $validation['OPCB001'] = $this->db->affected_rows();
                        ///////////////////////////
                        // $falseReturn=$this->jamaCheckToDeleteorNot($d->dist_code, $d->subdiv_code,
                        //     $d->cir_code, $d->mouza_pargona_code, $d->lot_no, $d->vill_townprt_code, $d->dag_no, $d->patta_no,$d->patta_type_code);
                        // if($falseReturn){
                        //     $this->db->trans_rollback();
                        //     log_message("error","#OPERRORReturn Insertion failed in delete in Jamabandi for dist: "
                        //         .$dist_code.", patta no: ". $patta_no);
                        //     echo "Error Occured";
                        //     die();
                        // }
                        ///////////////////////////
                    } else {
                        //var_dump($chitha_basic);   
                        // $this->db->insert("chitha_basic", $chitha_basic);
                        $result=$this->Chitha_basic_model->insert_table('chitha_basic',$chitha_basic);
                        if($result != 1)
                        {
                            $validation['OPCB0017CB'] = $this->db->affected_rows();
                        }
                        //var_dump  ($chitha_basic);                   
                        $landArea_query = "select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,dag_revenue,dag_local_tax from    chitha_basic"
                                . "  where dist_code='$d->dist_code' and  "
                                . " subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code'"
                                . " and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
                                . " vill_townprt_code='$d->vill_townprt_code' and dag_no='$d->dag_no'  "
                                . " and TRIM(patta_no)=trim('$d->patta_no') and patta_type_code='$d->patta_type_code'";
                        $landArea_query . "<br>";
                        $landDetails=$this->db->query($landArea_query)->row();
                        $sourceB = $landDetails->dag_area_b;
                        $sourceK = $landDetails->dag_area_k;
                        $sourceL = $landDetails->dag_area_lc;
                        $sourceRev = $landDetails->dag_revenue;
                        $sourceLTax = $landDetails->dag_local_tax;

                        ////// BARAK VALLEY CODE START ////////////
                        if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                            $sourceG = $landDetails->dag_area_g;
                            $sourceLessa = $sourceB * 6400 + $sourceK * 320 + $sourceL * 20 + $sourceG;
                            $targetLessa = $d->land_area_b * 6400 + $d->land_area_k * 320 + $d->land_area_lc * 20 + $d->land_area_g;
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
                        else // other than barak valley
                        {
                            
                            $sourceLessa = $sourceB * 100 + $sourceK * 20 + $sourceL;
                            $targetLessa = $d->land_area_b * 100 + $d->land_area_k * 20 + $d->land_area_lc;
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
                        ////// BARAK VALLEY CODE END ////////////

                        
                        $dag_no_int = $d->dag_no . "00";
                        // $chitha_update = "update  chitha_basic set dag_area_b='$b',dag_area_k='$k',"
                        //         . " dag_area_lc='$lc',dag_area_g='$g',dag_area_kr='$kr',dag_revenue='$new_revenue',dag_local_tax='$new_local_tax',jama_yn='n'  where dist_code='$d->dist_code' and"
                        //         . " subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code'"
                        //         . " and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
                        //         . " vill_townprt_code='$d->vill_townprt_code' and dag_no='$d->dag_no' and dag_no_int=$dag_no_int  "
                        //         . " and TRIM(patta_no)=trim('$d->patta_no') and patta_type_code='$d->patta_type_code'";
                    
                        // $this->db->query($chitha_update);

                        $table = "chitha_basic";

                        $params = [
                            'dag_area_b'     => $b,
                            'dag_area_k'     => $k,
                            'dag_area_lc'    => $lc,
                            'dag_area_g'     => $g,
                            'dag_area_kr'    => $kr,
                            'dag_revenue'    => $new_revenue,
                            'dag_local_tax'  => $new_local_tax,
                            'jama_yn'        => 'n'
                        ];

                        $where = [
                            'dist_code'          => $d->dist_code,
                            'subdiv_code'        => $d->subdiv_code,
                            'cir_code'           => $d->cir_code,
                            'lot_no'             => $d->lot_no,
                            'mouza_pargona_code' => $d->mouza_pargona_code,
                            'vill_townprt_code'  => $d->vill_townprt_code,
                            'dag_no'             => $d->dag_no,
                            'dag_no_int'         => $dag_no_int,
                            'patta_no'           => trim($d->patta_no),
                            'patta_type_code'    => $d->patta_type_code
                        ];

                        $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                        $validation['OPCB002'] = $this->db->affected_rows();
                    }
                    $chitha_basic_update = 1;
                }
                // end chitha update

                $data = array(
                    'pdar_name' => $d->infavor_of_name,
                    'pdar_father' => $d->infavor_of_guardian,
                    'patta_no' => trim($d->new_patta_no),
                    'patta_type_code' => $d->patta_type_code,
                    'pdar_add1' => $d->infavor_of_add1,
                    'pdar_add2' => $d->infavor_of_add2,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'E',
                    'pdar_guard_reln' => $d->infav_of_guar_relation,
                    'dist_code' => $d->dist_code,
                    'subdiv_code' => $d->subdiv_code,
                    'cir_code' => $d->cir_code,
                    'mouza_pargona_code' => $d->mouza_pargona_code,
                    'lot_no' => $d->lot_no,
                    'vill_townprt_code' => $d->vill_townprt_code,
                    'pdar_id' => $d->pdar_id,
                    'new_pdar_name' => 'N',
                    'jama_yn' => 'n',
                    'pdar_gender' => $d->infavor_of_gender,
                    'pdar_mother' => $d->infavor_of_mother
                );
                //var_dump($data);
                $dag_pattadar = array(
                    'dist_code' => $d->dist_code,
                    'subdiv_code' => $d->subdiv_code,
                    'cir_code' => $d->cir_code,
                    'mouza_pargona_code' => $d->mouza_pargona_code,
                    'lot_no' => $d->lot_no,
                    'vill_townprt_code' => $d->vill_townprt_code,
                    'pdar_id' => $d->pdar_id,
                    'patta_no' => trim($d->new_patta_no),
                    'dag_no' => $d->new_dag_no,
                    'patta_type_code' => $d->patta_type_code,
                    'dag_por_b' => 0, //$d->land_area_b,
                    'dag_por_k' => 0, //$d->land_area_k,
                    'dag_por_lc' => 0, //$d->land_area_lc,
                    'dag_por_g' => 0.0,
                    'dag_por_kr' => 0,
                    'pdar_land_revenue' => $d->revenue,
                    'pdar_land_localtax' => ($d->revenue) / 4,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'E',
                    'p_flag' => '0',
                    'jama_yn' => 'n'
                );
                //var_dump($dag_pattadar);
                $pdar_id++;
                if (($d->dag_no == $d->new_dag_no)) {
                    $q = "SElect pdar_id from    chitha_pattadar  where dist_code='$d->dist_code' and"
                            . " subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code'"
                            . " and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
                            . " vill_townprt_code='$d->vill_townprt_code' "
                            . " and TRIM(patta_no)=trim('$d->new_patta_no') and patta_type_code='$d->patta_type_code' and pdar_id='$d->pdar_id' ";
                    $exist = $this->db->query($q)->row();
                    if ($exist == null) {
                        // $this->db->insert("chitha_pattadar", $data);
                        $data['f1_case_no']=$case_no;
                        $this->Chitha_basic_model->insert_table('chitha_pattadar',$data);
                        $validation['OPCP003'] = $this->db->affected_rows();
                    }
                    // $chitha_update = "update  chitha_dag_pattadar set patta_no='$d->new_patta_no'  where dist_code='$d->dist_code' and subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code'"
                    //         . " and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
                    //         . " vill_townprt_code='$d->vill_townprt_code' and dag_no='$d->dag_no'  "
                    //         . " and TRIM(patta_no)=trim('$d->patta_no') and patta_type_code='$d->patta_type_code' and pdar_id='$d->pdar_id'";
                    // $this->db->query($chitha_update);
                    $table = 'chitha_dag_pattadar';

                    $params = [
                        'patta_no' => $d->new_patta_no,
                    ];

                    $where = [
                        'dist_code'          => $d->dist_code,
                        'subdiv_code'        => $d->subdiv_code,
                        'cir_code'           => $d->cir_code,
                        'lot_no'             => $d->lot_no,
                        'mouza_pargona_code' => $d->mouza_pargona_code,
                        'vill_townprt_code'  => $d->vill_townprt_code,
                        'dag_no'             => $d->dag_no,
                        'patta_type_code'    => $d->patta_type_code,
                        'pdar_id'            => $d->pdar_id,
                        'patta_no'           => trim($d->patta_no),
                    ];

                    // Call your update method exactly like this:
                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                    if($result != 1)
                    {
                        $validation['OPCCDP000'] = $this->db->affected_rows();
                    }
                } else {
                    //var_dump($d);
                    $q = "SElect dag_no from    chitha_dag_pattadar  where dist_code='$d->dist_code' and"
                            . " subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code'"
                            . " and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
                            . " vill_townprt_code='$d->vill_townprt_code' "
                            . " and TRIM(patta_no)=trim('$d->new_patta_no') and patta_type_code='$d->patta_type_code' and dag_no='$d->new_dag_no' and pdar_id='$d->pdar_id' ";
                    $exist_dag = $this->db->query($q)->row();
                    if ($exist_dag == null) {
                        // $this->db->insert("chitha_dag_pattadar", $dag_pattadar);
                        $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$dag_pattadar);
                        $validation['OPCDP004'] = $this->db->affected_rows();
                    }

                    //var_dump($dag_pattadar);
                    $q = "SElect pdar_id from    chitha_pattadar  where dist_code='$d->dist_code' and"
                            . " subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code'"
                            . " and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
                            . " vill_townprt_code='$d->vill_townprt_code' "
                            . " and TRIM(patta_no)=trim('$d->new_patta_no') and patta_type_code='$d->patta_type_code' and pdar_id='$d->pdar_id' ";
                    $exist = $this->db->query($q)->row();
                    //var_dump($exist);
                    if ($exist == null) {
                        // $this->db->insert("chitha_pattadar", $data);
                        $data['f1_case_no']=$case_no;
                        $this->Chitha_basic_model->insert_table('chitha_pattadar',$data);
                        $validation['OPCP005'] = $this->db->affected_rows();
                        //var_dump($data);
                    }
                    // if ($d->pdar_strike == 'Y') {
                    //     $p_flag = '1';
                    // } else {
                    //     $p_flag = '0';
                    // }
                    // $updateQuery = "update  chitha_dag_pattadar set p_flag = '$p_flag' where dist_code='$d->dist_code' and"
                    //         . " subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code' and lot_no='$d->lot_no' and "
                    //         . " mouza_pargona_code = '$d->mouza_pargona_code' and vill_townprt_code='$d->vill_townprt_code' and"
                    //         . " dag_no ='$d->dag_no' and TRIM(patta_no)=trim('$d->patta_no') and patta_type_code='$d->patta_type_code' and pdar_id = '$d->pdar_id' ";
                    // // echo $updateQuery . "<br>";
                    // $this->db->query($updateQuery);
                    $sqlCheck="Select * from chitha_dag_pattadar where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? and pdar_id=? and (p_flag is null or p_flag!='1') ";
                    $cdpCheck_12=$this->db->query($sqlCheck,[$d->dist_code,$d->subdiv_code,$d->cir_code,$d->mouza_pargona_code,$d->lot_no,$d->vill_townprt_code,$d->dag_no,$d->pdar_id]);
                    if($cdpCheck_12->num_rows()==0){
                        $this->db->trans_rollback();
                        log_message("error","#ERR0P1444 Pattadar Already Strike: ".$dist_code
            .", petition_no: ". $petition_no."QUERY##".$this->db->last_query());
                        return false;
                        }
                    $sqlCheck="Select * from chitha_dag_pattadar where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? and pdar_id!=? and (p_flag is null or p_flag!='1') ";
                    $cdpCheck_1=$this->db->query($sqlCheck,[$d->dist_code,$d->subdiv_code,$d->cir_code,$d->mouza_pargona_code,$d->lot_no,$d->vill_townprt_code,$d->dag_no,$d->pdar_id]);
                    if($cdpCheck_1->num_rows()==0){
                        $p_flag='0';
                    }else{
                        $p_flag='1';
                    }
                    ///////////////////////////
                    $table = 'chitha_dag_pattadar';

                    $params = [
                        'p_flag' => $p_flag,
                    ];

                    $where = [
                        'dist_code'          => $d->dist_code,
                        'subdiv_code'        => $d->subdiv_code,
                        'cir_code'           => $d->cir_code,
                        'lot_no'             => $d->lot_no,
                        'mouza_pargona_code' => $d->mouza_pargona_code,
                        'vill_townprt_code'  => $d->vill_townprt_code,
                        'dag_no'             => $d->dag_no,
                        'patta_type_code'    => $d->patta_type_code,
                        'pdar_id'            => $d->pdar_id,
                        'patta_no'           => trim($d->patta_no),
                    ];

                    // Then update via your model method:
                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                    $validation['OPCDP006'] = $result;
                }
                unset($d->year_no);
                unset($d->petition_no);
                unset($d->pdar_id);
                unset($d->revenue);
                unset($d->iscorrected_inco);
                unset($d->iscorrected_inco_date);
                unset($d->iscorrected_rkg_record);
                unset($d->iscorrected_rkg_date);
                unset($d->infavor_is_copdar);
                unset($d->make_mdb);
                unset($d->new_pattadar);
                unset($d->make_mdb);
                unset($d->make_mdb);
                unset($d->make_mdb);
                unset($d->make_mdb);
                $d->rmk_type_hist_no = $rmk_hist_no;
                $d->ord_cron_no = $ord_cron_no;
                $d->user_code = $this->session->userdata('user_code');
                $d->operation = 'E';
                $d->date_entry = date('Y-m-d G:i:s');
                unset($d->pdar_strike);
                unset($d->infavor_of_gender);
                unset($d->infavor_of_mother);
                $this->db->insert("chitha_rmk_infavor_of", $d);
                $validation['OPCRI007'] = $this->db->affected_rows();
            }

            unset($order->year_no);
            unset($order->petition_no);

            unset($order->petition_no);

            unset($order->iscorrected_inco);
            unset($order->iscorrected_inco_date);
            unset($order->iscorrected_rkg_record);
            unset($order->iscorrected_rkg_date);
            unset($order->pdar_id);
            unset($order->ord_onbehalf_guard);
            unset($order->ord_onbehalf_add1);
            unset($order->ord_onbehalf_add2);
            unset($order->make_mdb);
            unset($order->is_converted_pattadar);
            unset($order->patta_type_code);
            //unset($order->patta_no);
            unset($order->ord_onbehalf_id);
            unset($order->ord_onbehalf_of);
            unset($order->land_class_code);
            unset($order->land_area_b);
            unset($order->land_area_k);
            unset($order->land_area_lc);
            unset($order->min_revenue);
            unset($order->ifyes_reason3);
            unset($order->ifyes_reason2);
            unset($order->ifyes_reason1);
            unset($order->isorder_cancelled);
            unset($order->isdataposted_torkg_db);

            $order->ord_cron_no = $ord_cron_no;
            $order->rmk_type_hist_no = $rmk_hist_no;
            $order->user_code = $this->session->userdata('user_code');
            $order->operation = 'E';
            $order->date_entry = date('Y-m-d G:i:s');
            $order->area_left_b = 0;
            $order->area_left_k = 0;
            $order->area_left_lc = 0;
            $order->area_left_g = 0;
            $order->area_left_kr = 0;


            $rmk_gen = array(
                'dist_code' => $order->dist_code,
                'subdiv_code' => $order->subdiv_code,
                'cir_code' => $order->cir_code,
                'mouza_pargona_code' => $order->mouza_pargona_code,
                'vill_townprt_code' => $order->vill_townprt_code,
                'lot_no' => $order->lot_no,
                'dag_no' => $order->dag_no,
                'rmk_type_code' => '01',
                'rmk_type_hist_no' => $rmk_hist_no,
                'user_code' => $this->session->userdata('user_code'),
                'operation' => 'E',
                'date_entry' => date('Y-m-d G:i:s'),
                'jama_updated' => 'n',
                'new_dag_no' => $order->new_dag_no,
                'patta_no' => trim($d->new_patta_no)
            );
            //var_dump($rmk_gen);
            $this->db->insert("chitha_rmk_gen", $rmk_gen);
            $validation['OPCRG008'] = $this->db->affected_rows();

            $rmk_gen = array(
                'dist_code' => $order->dist_code,
                'subdiv_code' => $order->subdiv_code,
                'cir_code' => $order->cir_code,
                'mouza_pargona_code' => $order->mouza_pargona_code,
                'vill_townprt_code' => $order->vill_townprt_code,
                'lot_no' => $order->lot_no,
                'dag_no' => $order->new_dag_no,
                'rmk_type_code' => '01',
                'rmk_type_hist_no' => $rmk_hist_no,
                'user_code' => $this->session->userdata('user_code'),
                'operation' => 'E',
                'date_entry' => date('Y-m-d G:i:s'),
                'jama_updated' => 'n',
                'new_dag_no' => $order->dag_no,
                'patta_no' => trim($d->patta_no)
            );
            //var_dump($rmk_gen);
            if (($d->dag_no != $d->new_dag_no)) {
                $this->db->insert("chitha_rmk_gen", $rmk_gen);
                $validation['OPCRG009'] = $this->db->affected_rows();

                $this->db->insert("chitha_rmk_ordbasic", $order);
                $validation['OPCRO010'] = $this->db->affected_rows();
            }
            //var_dump($order);            
            unset($order->dag_no);
            $order->dag_no = $order->new_dag_no;
            $newDag = $order->new_dag_no;
            //var_dump($order);
            unset($order->new_dag_no);
            $this->db->insert("chitha_rmk_ordbasic", $order);
            $validation['OPCRO011'] = $this->db->affected_rows();
            $d = date('Y-m-d');
            $update_q = "update  t_chitha_rmk_ordbasic set iscorrected_inco='Y',iscorrected_inco_date='$d'"
                    . " where ord_no='$order->ord_no' and dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' and cir_code='$order->cir_code' ";
            $this->db->query($update_q);
            $validation['OPTCRO012'] = $this->db->affected_rows();

            $update_q = "update  t_chitha_rmk_infavor_of set iscorrected_inco='Y',iscorrected_inco_date='$d'"
                    . " where ord_no='$order->ord_no' and dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' and cir_code='$order->cir_code'  ";
            $this->db->query($update_q);
            $validation['OPTCRI013'] = $this->db->affected_rows();

            if ($this->db->trans_status() == FALSE) {
                $this->db->trans_rollback();
                log_message("error","#OPUC001 Insertion failed in chitha_col8_order for dist: "
                                .$dist_code.", petition no: ". $petition_no." JSON: ".json_encode($validation));
                echo "Error Occured";
            } else {
                foreach($validation as $key=>$val)
                {
                   if ($val <=0)
                   {                
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', $key.": Unable to update final chitha !");
                        log_message("error","#OPUC001 Insertion failed in chitha_col8_order for dist: "
                                .$dist_code.", petition no: ". $petition_no." JSON: ".json_encode($validation));
                        redirect(base_url() . "index.php/home");
                        return;
                   }
                }
                //echo "wht";
                ////////////////Composite API to NOC update Table////////////////////
                $sql = "select comp_serv_yn,noc_no,application_ref_no from petition_basic where 
                    case_no=? and dist_code=? and subdiv_code=? and
                     cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=?";
                $res = $this->db->query($sql,array($case_no,$dist_code,
                    $subdiv_code,$cir_code,$order->mouza_pargona_code,
                    $order->lot_no,$order->vill_townprt_code))->row();
                if($res->comp_serv_yn == 'Y')
                {
                    $comp_array5 = [
                        'case_no' => $case_no,
                        'user_code' => $this->session->userdata('user_code'),
                        'status' => 'F',
                        'remark' => 'Order Passed by CO',
                        'entry_date' => date('Y-m-d'),
                    ];
                    $process = $this->db->insert('composite_service', $comp_array5);
                    if ($process != 1) {
                        log_message("error", " #COMOPART0008 Unable to save data into composite_service
                        district: " . $dist_code . ", case no: " . $case_no);
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Order for Case No $case_no Not Successfull. Error Code(#COMOPART0008)");
                        redirect(base_url() . "index.php/home");
                    }

                    //////////////update noc table (landsale)////////
                    $land_sale_update = "UPDATE landsale SET partcomp=?,partcompdt=? WHERE
                        appno=? and distcode =? and subcode=? and circode=? and compserv=?";
                    $this->db->query($land_sale_update,
                        array('Y',date('Y-m-d'),$res->noc_no,$dist_code,$subdiv_code,$cir_code,'Y'));
                    if($this->db->affected_rows() != 1)
                    {
                        $this->db->trans_rollback();
                        log_message("error"," #COMOPART0009 could not update in landsale
                           district: ".$dist_code.", noc no: ". $res->noc_no);
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Order for Case No $case_no Not Successfull. Error Code(#COMOPART0009)");
                        redirect(base_url() . "index.php/home");
                    }
                }
                ////////////////////////////////////////////////////////////////////
                // if($res->application_ref_no){
                //     $msg='Partition Order Passed Successfully '. $case_no . " New Dag No." . $newDag ;
                //     $this->SendRtpsFStatus($case_no,$msg);
                // }
                ////////////////////////////////////////////////////////////////////
                // $this->db->trans_commit();
                // $rmk='Order Passed';
                // $status='F';
                // $task='CO';
                // $pen='NA';
                // $case=$case_no;
                // $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
                // //////////////////////////
                // $data['newdagno'] = array('newdag' => $newDag);                
                // $data['_view'] = 'partition/chitha_update_complete2';
                // $this->load->view('layouts/main',$data);
            }
        }
    }

     public function updateChithaPartition_dd() {
        //  var_dump($this->session->all_userdata());
        $case_no = $this->input->get('case_no');
        //$case_no = $this->session->userdata('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $query = "select * from    t_chitha_rmk_ordbasic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                . "and "
                . " (iscorrected_inco is null or iscorrected_inco=' ') and ord_no='$case_no' and ord_type_code='04'  ";
        $result = $this->db->query($query)->result();
        //  exit;
        foreach ($result as $order) {
            $this->db->trans_begin();

            $query_rmk_hist = "select max(rmk_type_hist_no) as c from    chitha_rmk_gen where "
                    . "dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' and cir_code='$order->cir_code'"
                    . " and lot_no='$order->lot_no' and mouza_pargona_code='$order->mouza_pargona_code' and "
                    . " vill_townprt_code='$order->vill_townprt_code' and dag_no='$order->dag_no' ";
            $rmk_hist_no = $this->db->query($query_rmk_hist)->row()->c;
            if ($rmk_hist_no == null) {
                $rmk_hist_no = 1;
            } else
                $rmk_hist_no += 1;
            $q = "select max(ord_cron_no)+1 as c1,max(rmk_type_hist_no)+1 as c2 from    chitha_rmk_ordbasic where "
                    . "dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' and cir_code='$order->cir_code'"
                    . " and lot_no='$order->lot_no' and mouza_pargona_code='$order->mouza_pargona_code' and "
                    . " vill_townprt_code='$order->vill_townprt_code' and dag_no='$order->dag_no' ";
            $ord_cron_no = $this->db->query($q)->row()->c1;
            if ($ord_cron_no == null) {
                $ord_cron_no = 1;
            } else {
                $ord_cron_no+=1;
            }
            $infavQuery = "select * from    t_chitha_rmk_infavor_of where ord_no='$order->ord_no' "
                    . "and dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' and cir_code='$order->cir_code'  and  iscorrected_inco is null ";
            //$infavData = $this->db->query($infavQuery)->result();
            $infavData = $this->db->query($infavQuery);
            
            if ($infavData == null || $infavData->num_rows()<=0)
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Could not update. Error Code(#OPTCRI001)");
                log_message("error","#OPTCRI001 not data in t_chitha_rmk_infavor_of for dist:".$dist_code.", case: ". $case_no);
                redirect(base_url() . "index.php/home");
                return;        
            }
            $infavData = $infavData->result();

            $pdar_id = 1;
            $chitha_basic_update = 0;
            foreach ($infavData as $d) {
                $landclass_query = "select land_class_code from    chitha_basic  where dist_code='$d->dist_code' and"
                        . " subdiv_code='$d->subdiv_code' and cir_code='$order->cir_code'"
                        . " and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
                        . " vill_townprt_code='$d->vill_townprt_code' and dag_no='$d->dag_no' ";
                        //. " and patta_type_code='$d->patta_type_code' and TRIM(patta_no)=trim('$d->patta_no')";
                // echo $landclass_query;
                $landclasscode = $this->db->query($landclass_query)->row()->land_class_code;
                // for chitha update
                if ($chitha_basic_update == 0) {
                    $chitha_basic = array(
                        'dist_code' => $d->dist_code,
                        'subdiv_code' => $d->subdiv_code,
                        'cir_code' => $d->cir_code,
                        'mouza_pargona_code' => $d->mouza_pargona_code,
                        'lot_no' => $d->lot_no,
                        'vill_townprt_code' => $d->vill_townprt_code,
                        'old_dag_no' => $d->dag_no,
                        'dag_no' => $d->new_dag_no,
                        'dag_no_int' => $d->new_dag_no . '00',
                        'patta_type_code' => $d->patta_type_code,
                        'patta_no' => trim($d->new_patta_no),
                        'land_class_code' => $landclasscode,
                        'dag_area_b' => $d->land_area_b,
                        'dag_area_k' => $d->land_area_k,
                        'dag_area_lc' => $d->land_area_lc,
                        'dag_area_g' => $d->land_area_g,
                        'dag_area_kr' => 0,
                        'dag_revenue' => $d->revenue,
                        'dag_local_tax' => ($d->revenue) / 4,
                        'user_code' => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d G:i:s'),
                        'operation' => 'E',
                        'jama_yn' => 'n',
                        'old_patta_no' => trim($d->patta_no)
                    );
                    // var_dump($chitha_basic);
                    if ($d->dag_no == $d->new_dag_no) {
                        // $chitha_update = "update chitha_basic set patta_no='$d->new_patta_no',jama_yn=null  where dist_code='$d->dist_code' and"
                        //         . " subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code'"
                        //         . " and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
                        //         . " vill_townprt_code='$d->vill_townprt_code' and dag_no='$d->dag_no'  "
                        //         . " and TRIM(patta_no)=trim('$d->patta_no') and patta_type_code='$d->patta_type_code'";
                        // //echo $chitha_update;
                        // $this->db->query($chitha_update);
                        $table = "chitha_basic";

                        $params = [
                            'patta_no' => $d->new_patta_no,
                            'jama_yn'  => null   // set jama_yn to NULL
                        ];

                        $where = [
                            'dist_code'          => $d->dist_code,
                            'subdiv_code'        => $d->subdiv_code,
                            'cir_code'           => $d->cir_code,
                            'lot_no'             => $d->lot_no,
                            'mouza_pargona_code' => $d->mouza_pargona_code,
                            'vill_townprt_code'  => $d->vill_townprt_code,
                            'dag_no'             => $d->dag_no,
                            'patta_no'           => trim($d->patta_no),  // TRIM equivalent
                            'patta_type_code'    => $d->patta_type_code
                        ];

                        $result0 = $this->Chitha_basic_model->update_table($table, $params, $where);

                        if ($result0 <=0)
                        {
                           $this->db->trans_rollback();
                           $this->session->set_flashdata('message', "Unable to update new patta no. Please try Again. Error Code(#OPTCB002)");
                           log_message("error","#OPTCB002 unable to update new patta no chitha basic for dist:"
                                    .$dist_code.", case: ". $case_no);
                           redirect(base_url() . "index.php/home");
                           return;                   
                        }
                    } else {
                        //var_dump($chitha_basic);   
                        // $tstatus0 = $this->db->insert('chitha_basic', $chitha_basic);
                        $tstatus0 = $this->Chitha_basic_model->insert_table('chitha_basic',$chitha_basic);
                         if ($tstatus0 != 1 )
                        {
                           $this->db->trans_rollback();
                           $this->session->set_flashdata('message', "Unable to add new dag . Please try Again. Error Code(#OPCB000)");
                           log_message("error","#OPCB000 Unable to add new dag in chitha_basic for dist:"
                                    .$dist_code.", case: ". $case_no);
                           redirect(base_url() . "index.php/home");
                           return;                   
                        }

                        $landArea_query = "select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,dag_revenue,dag_local_tax from    chitha_basic"
                                . "  where dist_code='$d->dist_code' and  "
                                . " subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code'"
                                . " and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
                                . " vill_townprt_code='$d->vill_townprt_code' and dag_no='$d->dag_no'  "
                                . " and TRIM(patta_no)=trim('$d->patta_no') and patta_type_code='$d->patta_type_code'";
                        $landArea_query . "<br>";
                        $sourceB = $this->db->query($landArea_query)->row()->dag_area_b;
                        $sourceK = $this->db->query($landArea_query)->row()->dag_area_k;
                        $sourceL = $this->db->query($landArea_query)->row()->dag_area_lc;
                        $sourceG = $this->db->query($landArea_query)->row()->dag_area_g;
                        $sourceRev = $this->db->query($landArea_query)->row()->dag_revenue;
                        $sourceLTax = $this->db->query($landArea_query)->row()->dag_local_tax;


                        ////// BARAK VALLEY CODE START ////////////
                        if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                            $sourceLessa = $sourceB * 6400 + $sourceK * 320 + $sourceL * 20 + $sourceG;
                            $targetLessa = $d->land_area_b * 6400 + $d->land_area_k * 320 + $d->land_area_lc * 20 + $d->land_area_g;
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
                            $targetLessa = $d->land_area_b * 100 + $d->land_area_k * 20 + $d->land_area_lc;
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
                        
                        $dag_no_int = $d->dag_no . "00";
                        // $chitha_update = "update chitha_basic set dag_area_b='$b',dag_area_k='$k',"
                        //         . " dag_area_lc='$lc',dag_area_g='$g',dag_area_kr='$kr',dag_revenue='$new_revenue',dag_local_tax='$new_local_tax',jama_yn='n'  where dist_code='$d->dist_code' and"
                        //         . " subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code'"
                        //         . " and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
                        //         . " vill_townprt_code='$d->vill_townprt_code' and dag_no='$d->dag_no' and dag_no_int=$dag_no_int  "
                        //         . " and TRIM(patta_no)=trim('$d->patta_no') and patta_type_code='$d->patta_type_code'";
                        // //echo $chitha_update;

                        // $this->db->query($chitha_update);

                        $table = 'chitha_basic';

                        $params = [
                            'dag_area_b'    => $b,
                            'dag_area_k'    => $k,
                            'dag_area_lc'   => $lc,
                            'dag_area_g'    => $g,
                            'dag_area_kr'   => $kr,
                            'dag_revenue'   => $new_revenue,
                            'dag_local_tax' => $new_local_tax,
                            'jama_yn'       => 'n',
                        ];

                        $where = [
                            'dist_code'          => $d->dist_code,
                            'subdiv_code'        => $d->subdiv_code,
                            'cir_code'           => $d->cir_code,
                            'lot_no'             => $d->lot_no,
                            'mouza_pargona_code' => $d->mouza_pargona_code,
                            'vill_townprt_code'  => $d->vill_townprt_code,
                            'dag_no'             => $d->dag_no,
                            'dag_no_int'         => $dag_no_int,
                            'patta_no'           => trim($d->patta_no),
                            'patta_type_code'    => $d->patta_type_code,
                        ];

                        $result1 = $this->Chitha_basic_model->update_table($table, $params, $where);

                        if ($result1 <=0)
                        {
                           $this->db->trans_rollback();
                           $this->session->set_flashdata('message', "Unable to update dag area and revenue. Please try Again. Error Code(#OPTCB003)");
                           log_message("error","#OPTCB003 unable to update new patta no chitha basic for dist:"
                                    .$dist_code.", case: ". $case_no);
                           redirect(base_url() . "index.php/home");
                           return;                   
                        }
                    }
                    $chitha_basic_update = 1;
                }
                // end chitha update

                $data = array(
                    'pdar_name' => $d->infavor_of_name,
                    'pdar_father' => $d->infavor_of_guardian,
                    'patta_no' => trim($d->new_patta_no),
                    'patta_type_code' => $d->patta_type_code,
                    'pdar_add1' => $d->infavor_of_add1,
                    'pdar_add2' => $d->infavor_of_add2,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'E',
                    'pdar_guard_reln' => $d->infav_of_guar_relation,
                    'dist_code' => $d->dist_code,
                    'subdiv_code' => $d->subdiv_code,
                    'cir_code' => $d->cir_code,
                    'mouza_pargona_code' => $d->mouza_pargona_code,
                    'lot_no' => $d->lot_no,
                    'vill_townprt_code' => $d->vill_townprt_code,
                    'pdar_id' => $d->pdar_id,
                    'new_pdar_name' => 'N',
                    'jama_yn' => 'n',
                    'pdar_gender' => $d->infavor_of_gender,
                    'pdar_mother' => $d->infavor_of_mother
                );
                //var_dump($data);
                $dag_pattadar = array(
                    'dist_code' => $d->dist_code,
                    'subdiv_code' => $d->subdiv_code,
                    'cir_code' => $d->cir_code,
                    'mouza_pargona_code' => $d->mouza_pargona_code,
                    'lot_no' => $d->lot_no,
                    'vill_townprt_code' => $d->vill_townprt_code,
                    'pdar_id' => $d->pdar_id,
                    'patta_no' => trim($d->new_patta_no),
                    'dag_no' => $d->new_dag_no,
                    'patta_type_code' => $d->patta_type_code,
                    'dag_por_b' => 0, //$d->land_area_b,
                    'dag_por_k' => 0, //$d->land_area_k,
                    'dag_por_lc' => 0, //$d->land_area_lc,
                    'dag_por_g' => 0.0,
                    'dag_por_kr' => 0,
                    'pdar_land_revenue' => $d->revenue,
                    'pdar_land_localtax' => ($d->revenue) / 4,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'E',
                    'p_flag' => '0',
                    'jama_yn' => 'n'
                );
                //var_dump($dag_pattadar);
                $pdar_id++;
                if (($d->dag_no == $d->new_dag_no)) {                   
                    $q = "SElect pdar_id from    chitha_pattadar  where dist_code='$d->dist_code' and"
                            . " subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code'"
                            . " and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
                            . " vill_townprt_code='$d->vill_townprt_code' "
                            . " and TRIM(patta_no)=trim('$d->new_patta_no') and patta_type_code='$d->patta_type_code' and pdar_id='$d->pdar_id' ";
                    $exist = $this->db->query($q)->row();
                    if ($exist == null) {
                        // $tstatus1 = $this->db->insert('chitha_pattadar', $data);
                        $data['f1_case_no']=$case_no;
                        $tstatus1 = $this->Chitha_basic_model->insert_table('chitha_pattadar',$data);
                        if ($tstatus1 != 1 )
                        {
                           $this->db->trans_rollback();
                           $this->session->set_flashdata('message', "Unable to add new pattadar . Please try Again. Error Code(#OPTCP005)");
                           log_message("error","#OPTCP005 unable to add new pattadar in chitha_pattadar for dist:"
                                    .$dist_code.", case: ". $case_no);
                           redirect(base_url() . "index.php/home");
                           return;                   
                        }
                    }
                    $chitha_update = "update  chitha_dag_pattadar set patta_no='$d->new_patta_no'  where dist_code='$d->dist_code' and subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code'"
                            . " and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
                            . " vill_townprt_code='$d->vill_townprt_code' and dag_no='$d->dag_no'  "
                            . " and TRIM(patta_no)=trim('$d->patta_no') and patta_type_code='$d->patta_type_code' and pdar_id='$d->pdar_id' ";
                    $this->db->query($chitha_update);
                    if($this->db->affected_rows() != 1)
                    {
                        $validation['OPCCDP000'] = $this->db->affected_rows();
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Unable to add new pattadar . Please try Again. Error Code(#OPTCDP005)");
                        log_message("error","#OPTCDP005 unable to add new pattadar in chitha_dag_pattadar for dist:"
                                .$dist_code.", case: ". $case_no);
                        redirect(base_url() . "index.php/home");
                        return;
                    }


                } else {
                    //var_dump($d);
                    $q = "SElect dag_no from    chitha_dag_pattadar  where dist_code='$d->dist_code' and"
                            . " subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code'"
                            . " and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
                            . " vill_townprt_code='$d->vill_townprt_code' "
                            . " and TRIM(patta_no)=trim('$d->new_patta_no') and patta_type_code='$d->patta_type_code' and dag_no='$d->new_dag_no' and pdar_id='$d->pdar_id' ";
                    $exist_dag = $this->db->query($q)->row();
                    if ($exist_dag == null) {
                        // $tstatus2 = $this->db->insert('chitha_dag_pattadar', $dag_pattadar);      
                        $tstatus2 = $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$dag_pattadar);                 
                        if ($tstatus2 != 1 )
                        {
                           $this->db->trans_rollback();
                           $this->session->set_flashdata('message', "Unable to add new pattadar to new dag. Please try Again. Error Code(#OPTCDP006)");
                           log_message("error","#OPTCDP006 Unable to add new pattadar to new dag in chitha_dag_pattadar for dist:"
                                    .$dist_code.", case: ". $case_no);
                           redirect(base_url() . "index.php/home");
                           return;                   
                        }
                    }
                    $q = "SElect pdar_id from    chitha_pattadar  where dist_code='$d->dist_code' and"
                            . " subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code'"
                            . " and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
                            . " vill_townprt_code='$d->vill_townprt_code' "
                            . " and TRIM(patta_no)=trim('$d->new_patta_no') and patta_type_code='$d->patta_type_code' and pdar_id='$d->pdar_id' ";
                    $exist = $this->db->query($q)->row();
                    if ($exist == null) {
                        // $tstatus3 = $this->db->insert('chitha_pattadar', $data);
                        $data['f1_case_no']=$case_no;
                        $tstatus3 = $this->Chitha_basic_model->insert_table('chitha_pattadar',$data);
                        if ($tstatus3 != 1 )
                        {
                           $this->db->trans_rollback();
                           $this->session->set_flashdata('message', "Unable to add new pattadar name . Please try Again. Error Code(#OPTCP007)");
                           log_message("error","#OPTCP007 unable to add new pattadar name in chitha_pattadar for dist:"
                                    .$dist_code.", case: ". $case_no);
                           redirect(base_url() . "index.php/home");
                           return;                   
                        }
                    }

                    if ($d->pdar_strike == 'Y') {
                        $p_flag = '0';
                    } else {
                        $p_flag = '1';
                    }
                    // $updateQuery = "update chitha_dag_pattadar set p_flag = '$p_flag' where dist_code='$d->dist_code' and"
                    //         . " subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code' and lot_no='$d->lot_no' and "
                    //         . " mouza_pargona_code = '$d->mouza_pargona_code' and vill_townprt_code='$d->vill_townprt_code' and"
                    //         . " dag_no ='$d->dag_no' and TRIM(patta_no)=trim('$d->patta_no') and patta_type_code='$d->patta_type_code' and pdar_id = '$d->pdar_id' ";
                    // // echo $updateQuery . "<br>";
                    // $this->db->query($updateQuery);
                    $table = 'chitha_dag_pattadar';
                    $params = [
                        'p_flag' => $p_flag,
                    ];
                    $where = [
                        'dist_code'          => $d->dist_code,
                        'subdiv_code'        => $d->subdiv_code,
                        'cir_code'           => $d->cir_code,
                        'lot_no'             => $d->lot_no,
                        'mouza_pargona_code' => $d->mouza_pargona_code,
                        'vill_townprt_code'  => $d->vill_townprt_code,
                        'dag_no'             => $d->dag_no,
                        // Apply trim on patta_no in PHP before passing
                        'patta_no'           => trim($d->patta_no),
                        'patta_type_code'    => $d->patta_type_code,
                        'pdar_id'            => $d->pdar_id,
                    ];
                    // Then call your update method
                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                    if ($result <=0)
                    {
                       $this->db->trans_rollback();
                       $this->session->set_flashdata('message', "Unable to strike out pattadar in old dag. Please try Again. Error Code(#OPTCDP008)");
                       log_message("error","#OPTCDP008 Unable to update strike out pattadar chitha_dag_pattadar for dist:"
                                .$dist_code.", case: ". $case_no);
                       redirect(base_url() . "index.php/home");
                       return;                   
                    }
                }
                unset($d->year_no);
                unset($d->petition_no);
                unset($d->pdar_id);
                unset($d->revenue);
                unset($d->iscorrected_inco);
                unset($d->iscorrected_inco_date);
                unset($d->iscorrected_rkg_record);
                unset($d->iscorrected_rkg_date);
                unset($d->infavor_is_copdar);
                unset($d->make_mdb);
                unset($d->new_pattadar);
                unset($d->make_mdb);
                unset($d->make_mdb);
                unset($d->make_mdb);
                unset($d->make_mdb);
                $d->rmk_type_hist_no = $rmk_hist_no;
                $d->ord_cron_no = $ord_cron_no;
                $d->user_code = $this->session->userdata('user_code');
                $d->operation = 'E';
                $d->date_entry = date('Y-m-d G:i:s');
                unset($d->pdar_strike);
                unset($d->infavor_of_gender);
                unset($d->infavor_of_mother);
                $tstatus4 = $this->db->insert('chitha_rmk_infavor_of', $d);
                if ($tstatus4 != 1 )
                {
                   $this->db->trans_rollback();
                   $this->session->set_flashdata('message', "Unable to add remark in favor . Please try Again. Error Code(#OPCRI009)");
                   log_message("error","#OPCRI009 Unable to add order remark in favor in chitha_rmk_infavor_of for dist:"
                            .$dist_code.", case: ". $case_no);
                   redirect(base_url() . "index.php/home");
                   return;                   
                }
            }

            unset($order->year_no);
            unset($order->petition_no);

            unset($order->petition_no);

            unset($order->iscorrected_inco);
            unset($order->iscorrected_inco_date);
            unset($order->iscorrected_rkg_record);
            unset($order->iscorrected_rkg_date);
            unset($order->pdar_id);
            unset($order->ord_onbehalf_guard);
            unset($order->ord_onbehalf_add1);
            unset($order->ord_onbehalf_add2);
            unset($order->make_mdb);
            unset($order->is_converted_pattadar);
            unset($order->patta_type_code);
            //unset($order->patta_no);
            unset($order->ord_onbehalf_id);
            unset($order->ord_onbehalf_of);
            unset($order->land_class_code);
            unset($order->land_area_b);
            unset($order->land_area_k);
            unset($order->land_area_lc);
            unset($order->min_revenue);
            unset($order->ifyes_reason3);
            unset($order->ifyes_reason2);
            unset($order->ifyes_reason1);
            unset($order->isorder_cancelled);
            unset($order->isdataposted_torkg_db);

            $order->ord_cron_no = $ord_cron_no;
            $order->rmk_type_hist_no = $rmk_hist_no;
            $order->user_code = $this->session->userdata('user_code');
            $order->operation = 'E';
            $order->date_entry = date('Y-m-d G:i:s');
            $order->area_left_b = 0;
            $order->area_left_k = 0;
            $order->area_left_lc = 0;
            $order->area_left_g = 0;
            $order->area_left_kr = 0;


            $rmk_gen = array(
                'dist_code' => $order->dist_code,
                'subdiv_code' => $order->subdiv_code,
                'cir_code' => $order->cir_code,
                'mouza_pargona_code' => $order->mouza_pargona_code,
                'vill_townprt_code' => $order->vill_townprt_code,
                'lot_no' => $order->lot_no,
                'dag_no' => $order->dag_no,
                'rmk_type_code' => '01',
                'rmk_type_hist_no' => $rmk_hist_no,
                'user_code' => $this->session->userdata('user_code'),
                'operation' => 'E',
                'date_entry' => date('Y-m-d G:i:s'),
                'jama_updated' => 'n',
                'new_dag_no' => $order->new_dag_no,
                'patta_no' => trim($d->new_patta_no)
            );
            //var_dump($rmk_gen);
            $tstatus5 = $this->db->insert('chitha_rmk_gen', $rmk_gen);
            if ($tstatus5 != 1 )
            {
               $this->db->trans_rollback();
               $this->session->set_flashdata('message', "Unable to add remark for new dag in chitha . Please try Again. Error Code(#OPCRG010)");
               log_message("error","#OPCRG010 Unable to add order remark  for new dag  in chitha_rmk_gen for dist:"
                        .$dist_code.", case: ". $case_no);
               redirect(base_url() . "index.php/home");
               return;                   
            }
            $rmk_gen = array(
                'dist_code' => $order->dist_code,
                'subdiv_code' => $order->subdiv_code,
                'cir_code' => $order->cir_code,
                'mouza_pargona_code' => $order->mouza_pargona_code,
                'vill_townprt_code' => $order->vill_townprt_code,
                'lot_no' => $order->lot_no,
                'dag_no' => $order->new_dag_no,
                'rmk_type_code' => '01',
                'rmk_type_hist_no' => $rmk_hist_no,
                'user_code' => $this->session->userdata('user_code'),
                'operation' => 'E',
                'date_entry' => date('Y-m-d G:i:s'),
                'jama_updated' => 'n',
                'new_dag_no' => $order->dag_no,
                'patta_no' => trim($d->patta_no)
            );
            //var_dump($rmk_gen);
            if (($d->dag_no != $d->new_dag_no)) {
                $tstatus6 = $this->db->insert('chitha_rmk_gen', $rmk_gen);
                if ($tstatus6 != 1 )
                {
                   $this->db->trans_rollback();
                   $this->session->set_flashdata('message', "Unable to add remark for old dag in chitha . Please try Again. Error Code(#OPCRG011)");
                   log_message("error","#OPCRG011 Unable to add order remark  for old dag  in chitha_rmk_gen for dist:"
                            .$dist_code.", case: ". $case_no);
                   redirect(base_url() . "index.php/home");
                   return;                   
                }

                $tstatus7 = $this->db->insert('chitha_rmk_ordbasic', $order);
                if ($tstatus7 != 1 )
                {
                   $this->db->trans_rollback();
                   $this->session->set_flashdata('message', "Unable to add order in chitha . Please try Again. Error Code(#OPCRO012)");
                   log_message("error","#OPCRO012 Unable to add order in chitha in chitha_rmk_ordbasic for dist:"
                            .$dist_code.", case: ". $case_no);
                   redirect(base_url() . "index.php/home");
                   return;                   
                }
            }
            //var_dump($order);

            unset($order->dag_no);
            $order->dag_no = $order->new_dag_no;
            $newDag = $order->new_dag_no;
            //var_dump($order);
            unset($order->new_dag_no);
            $tstatus8 = $this->db->insert('chitha_rmk_ordbasic', $order);
            if ($tstatus8 != 1 )
            {
               $this->db->trans_rollback();
               $this->session->set_flashdata('message', "Unable to add order remark in chitha . Please try Again. Error Code(#OPCRO013)");
               log_message("error","#OPCRO013 Unable to add order remark in chitha in chitha_rmk_ordbasic for dist:"
                        .$dist_code.", case: ". $case_no);
               redirect(base_url() . "index.php/home");
               return;                   
            }
            //var_dump($order);
            $d = date('Y-m-d');

            $update_q = "update t_chitha_rmk_ordbasic set iscorrected_inco='Y',iscorrected_inco_date='$d'"
                    . " where ord_no='$order->ord_no' and dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' and cir_code='$order->cir_code' ";
            $this->db->query($update_q);
            if ($this->db->affected_rows() <=0)
            {
               $this->db->trans_rollback();
               $this->session->set_flashdata('message', "Unable to update chitha correction status in chitha. Please try Again. Error Code(#OPTCRO014)");
               log_message("error","#OPTCRO014 Unable to update chitha correction status in chitha in t_chitha_rmk_ordbasic for dist:"
                        .$dist_code.", case: ". $case_no);
               redirect(base_url() . "index.php/home");
               return;                   
            }

            $update_q = "update t_chitha_rmk_infavor_of set iscorrected_inco='Y',iscorrected_inco_date='$d'"
                    . " where ord_no='$order->ord_no' and dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' and cir_code='$order->cir_code'  ";
            $this->db->query($update_q);
            if ($this->db->affected_rows() <=0)
            {
               $this->db->trans_rollback();
               $this->session->set_flashdata('message', "Unable to update chitha correction status in chitha in favor of. Please try Again. Error Code(#OPTCRI015)");
               log_message("error","#OPTCRI015 Unable to update chitha correction status in chitha in favor of in t_chitha_rmk_infavor_of for dist:"
                        .$dist_code.", case: ". $case_no);
               redirect(base_url() . "index.php/home");
               return;                   
            }

            if ($this->db->trans_status() == FALSE) {
                $this->db->trans_rollback();
                echo "Error Occured";
            } else {
                //echo "wht";
                $data['newdagno'] = array('newdag' => $newDag);
                $this->db->trans_commit();
                ///////////////////////
                $rmk='Order Passed';
                $status='F';
                $task='CO';
                $pen='NA';
                $case=$case_no;
                $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
                //////////////////////////
                $data['_view'] = 'partition/chitha_update_complete2';
                $this->load->view('layouts/main',$data);
            }
        }
    }
    public function getGuardianName($pattadarID) {
        $data = $this->pattamodel->getGuardianName($pattadarID)->result();
        $json = array();
        foreach ($data as $d) {
            $json[] = array('gaurdian_name' => $d->pdar_father, 'relation' => $d->pdar_guard_reln, 'pdar_add1' => $d->pdar_add1, 'pdar_add2' => $d->pdar_add2, 'pdar_gender' => $d->pdar_gender,
                'pdar_mother' => $d->pdar_mother, 'aadhar' => $d->pdar_aadharno, 'nrc' => $d->pdar_nrcno, 'mobile' => $d->pdar_mobile, 'pan' => $d->pdar_pan_no, 'voter' => $d->pdar_citizen_no);
        }
        echo json_encode($json);
    }

    public function saveJamabandiByPattano() {
        if (isset($_GET['case_no'])) {
            $case_no = $this->input->get('case_no');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $circle_code = $this->session->userdata('cir_code');
            $db = $this->session->userdata('db');
            $year_no = year_no;
            if ($case_no === 0) {
                //var_dump($this->session->all_userdata());
                $dist_code = $this->session->userdata('dist_code');
                $subdiv_code = $this->session->userdata('subdiv_code');
                $circle_code = $this->session->userdata('cir_code');
                $mouza_code = $this->session->userdata('mouza_pargona_code');
                $lot_no = $this->session->userdata('lot_no');
                $vill_code = $this->session->userdata('vill_code');
                $pattatypeCode = $this->session->userdata('patta_type_code');
                $patta_no = trim($this->session->userdata('patta_no'));
            } elseif ($case_no === 1) {
                //this is for land reclassification
                $proposal_no = $this->input->get('proposal_no');
                $t_reclassification = $this->db->query("Select * from    t_reclassification where proposal_no = '$proposal_no'")->row();
                $dist_code = $t_reclassification->dist_code;
                $subdiv_code = $t_reclassification->subdiv_code;
                $circle_code = $t_reclassification->cir_code;
                $mouza_code = $t_reclassification->mouza_pargona_code;
                $lot_no = $t_reclassification->lot_no;
                $vill_code = $t_reclassification->vill_townprt_code;
                $pattatypeCode = $t_reclassification->patta_type_code;
                $patta_no = trim($t_reclassification->patta_no);
            } else {
                $petition_basic = $this->db->query("Select * from    petition_basic where case_no = '$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' ")->row();
                // echo "Select * from    petition_basic where case_no = '$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and year_no='$year_no'";
                $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,"
                                . "patta_type_code from    petition_dag_details where dist_code='$petition_basic->dist_code' and"
                                . " subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and "
                                . "lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
                                . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'  ")->row_array();
                $dist_code = $petition_basic->dist_code;
                $subdiv_code = $petition_basic->subdiv_code;
                $circle_code = $petition_basic->cir_code;
                $mouza_code = $petition_basic->mouza_pargona_code;
                $lot_no = $petition_basic->lot_no;
                $vill_code = $petition_basic->vill_townprt_code;
                $pattatypeCode = $landdetails['patta_type_code'];
                $patta_no = trim($landdetails['patta_no']);
            }
        }
        $main = array();
        $jamainfo = array();
        $pattatype = array(
            'patta_type' => $pattatypeCode,
            'patta_no' => $patta_no
        );
        $this->session->set_userdata($pattatype);
        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $lotdata = $this->MisModel->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
        $pattatypename = $this->MisModel->getpattatypeNameforJamabandi($pattatypeCode);
        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata, $pattatypename);
        $maindata['pattainfo'] = $pattatype;
        $pno = $patta_no;
        $main['daginfo'] = array();
        $query = "select jd.dag_no,jd.dag_revenue,jd.dag_localtax,jd.dag_area_b,jd.dag_area_k,jd.dag_area_lc,lcd.land_type,lcd.class_code_cat from    "
                . "jama_dag as jd  JOIN   landclass_code as lcd ON jd.dag_class_code=lcd.class_code WHERE jd.dist_code='$dist_code' and jd.subdiv_code = '$subdiv_code' and jd.cir_code='$circle_code' and "
                . "jd.mouza_pargona_code = '$mouza_code' and jd.lot_no = '$lot_no' and jd.vill_townprt_code='$vill_code' and "
                . "jd.patta_type_code='$pattatypeCode' and TRIM(jd.patta_no)='$pno'";
        //  echo $query . "<br>";
        $main['daginfo'] = $daginfo = $this->db->query($query)->result();
        $daginfo_counted = count($main['daginfo']);
        if ($daginfo_counted != "") {
            $query = "select patta_no,pdar_name,pdar_id,pdar_father,pdar_add1,pdar_add2,pdar_add3,p_flag,new_pdar_name,pdar_land_b,pdar_land_k,pdar_land_lc  "
                    . "from    jama_pattadar WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                    . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
                    . "patta_type_code='$pattatypeCode' and TRIM(patta_no)='$pno' order by length(pdar_id), pdar_id";
            $main['pattadarinf'] = $this->db->query($query)->result();
            $query = "select patta_no,remark,rmk_line_no from    jama_remark WHERE "
                    . "dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                    . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and "
                    . "vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and "
                    . "TRIM(patta_no)='$pno' order by rmk_line_no";
            $main['remarkinf'] = $this->db->query($query)->result();
            //changes 02/05///
            $query = "select old_patta_no from    jama_patta WHERE "
                    . "dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
                    . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and "
                    . "vill_townprt_code='$vill_code' and patta_type_code='$pattatypeCode' and "
                    . "TRIM(patta_no)='$pno' ";
            // echo $query . "<br>";
            $main['oldpno'] = $this->db->query($query)->result();
            $main = array_merge($maindata, $main);
            $this->load->view('jamabandi/save_jamabandi_by_selecting_pattano', $main);
        } else {
            $this->load->helper('html');
            $data['_view'] = 'jamabandi/no_jamabandi';
            $this->load->view('layouts/main',$data);
        }
    }

    public function SetMessage() {
        $case_no = $this->session->userdata('case_no');
        $this->session->set_flashdata('message', "New Case with Case number $case_no has Registered");
        redirect(base_url() . "index.php/home/index");
    }

    public function ActionTakenRpt() {
        $this->dbswitch();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $circle_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $sql = "select * from    petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code'"
                . " and mut_type='04' ";
        $data['partpetition'] = $this->db->query($sql)->result();
        $this->load->helper('html');

        $data['_view'] = 'partition/actiontakenreportPart';
        $this->load->view('layouts/main',$data);
    }

    public function ViewActionTakenReport() {
        $this->dbswitch();
        $data = array();
        $case_no = $this->input->get('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $circle_code = $this->session->userdata('cir_code');

        $year_no = year_no;
        $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' ")->row();

        $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,next_date_of_hearing"
                        . " from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code'")->row_array();

        $locationData = array(
            'dist_code' => $location['dist_code'],
            'subdiv_code' => $location['subdiv_code'],
            'cir_code' => $location['cir_code'],
            'lot_no' => $location['lot_no'],
            'vill_code' => $location['vill_townprt_code'],
            'mouza_pargona_code' => $location['mouza_pargona_code']
        );
        $dist_code = $this->utilityclass->getDistrictName($location['dist_code']);
        $subdiv_code = $this->utilityclass->getSubDivName($location['dist_code'], $location['subdiv_code']);
        $cir_code = $this->utilityclass->getCircleName($location['dist_code'], $location['subdiv_code'], $location['cir_code']);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code']);
        $lot_no = $this->utilityclass->getLotName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no']);
        $vill_townprt_code = $this->utilityclass->getVillageName($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code']);
        $data['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code,
            'case_no' => $case_no,
            'date' => $location['date_entry'],
            'next_date' => $location['next_date_of_hearing']
        );

        $convertion_code = '04';
        $data['conv_type'] = $this->db->query("select order_type from    master_office_mut_type "
                        . " where order_type_code='$convertion_code'")->row()->order_type;

        $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and "
                        . "vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'  ")->row_array();

        $pattadardetails = "select pdar_name,pdar_guardian,pdar_rel_guar,pdar_add1,pdar_add2 from    petitioner_part where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' "
                . "and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no' and dag_no='$landdetails[dag_no]' and TRIM(patta_no)=trim('$landdetails[patta_no]') and patta_type_code= '$landdetails[patta_type_code]'";
        $data['p_in_order'] = $this->db->query($pattadardetails)->result();
        $query = "select * from    petition_proceeding where case_no = '$case_no' and  dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' order by date_entry asc  ";
        $data['cases'] = $this->db->query($query)->result();
        $this->load->helper('html');
        $data['_view'] = 'partition/action_taken_report';
        $this->load->view('layouts/main',$data);
    }

    //////////////////////////////********FORM  VALIDATION ***********////////////////////////  
    public function namecheck($str) {
        $pattern = '/^[a-zA-Z0-9\/, \s_.-:]{2,50000}$/';
        if ($str != '') {
            if (preg_match($pattern, $str)) {
                return TRUE;
            } else {
                $this->form_validation->set_message('namecheck', 'The %s field can not contain special Character.');
                return FALSE;
            }
        }
    }
    public function datevalid($str) {
        $pattern = '/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/[0-9]{4}$/';

        if (preg_match($pattern, $str)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('datevalid', 'The %s field is not a valid date.');
            return FALSE;
        }
    }
    public function numbercheck($str) {
        if ($str != '') {
            if (preg_match('/[0-9]/', $str)) {
                return true;
            } else {
                $this->form_validation->set_message('numbercheck', 'The %s field must be a Number.');
                return FALSE;
            }
        }
    }
    public function alphacheck($str) {
        $pattern = '/^[a-zA-Z\/, \s_.-:]{2,50000}$/';
        if ($str != '') {
            if (preg_match($pattern, $str)) {
                return TRUE;
            } else {
                $this->form_validation->set_message('alphacheck', 'The %s field must be Letters');
            }
        }
    }
    function old_notice() {
        $this->load->helper('html');
        $data['_view'] = 'partition/notice_regenerate';
        $this->load->view('layouts/main',$data);
    }

    function search_regenerate_notice() {
        if (isset($_POST)) {
            //echo "hello";
            $case_no = trim($_POST['case_no']);
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $user_code = $this->session->userdata('user_code');
            $sql = "Select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='P' ";
            $pb = $data['pb'] = $this->db->query($sql)->row();
            if($pb->application_ref_no!=null){
                $data['mobile_no']=$this->ServicePlusModel->rtpsMobile($pb->application_ref_no);
            }
            //$size = sizeof($pb);
            if ($pb) {
                $sql = "SELECT * FROM Petition_notified WHERE dist_code = '$pb->dist_code' and subdiv_code = '$pb->subdiv_code' and cir_code = '$pb->cir_code' and mouza_pargona_code = '$pb->mouza_pargona_code'"
                        . " and lot_no = '$pb->lot_no' and vill_townprt_code = '$pb->vill_townprt_code'  and Petition_no = '$pb->petition_no'";

                $data['notify'] = $this->db->query($sql)->row();
                $sql = "SELECT * FROM Petitioner_part WHERE dist_code = '$pb->dist_code' and subdiv_code = '$pb->subdiv_code' and cir_code = '$pb->cir_code' and mouza_pargona_code = '$pb->mouza_pargona_code'"
                        . " and lot_no = '$pb->lot_no' and vill_townprt_code = '$pb->vill_townprt_code'  and Petition_no = '$pb->petition_no'";

                $data['partition'] = $this->db->query($sql)->result();
                $sql = "SELECT * FROM petition_dag_details WHERE dist_code = '$pb->dist_code' and subdiv_code = '$pb->subdiv_code' and cir_code = '$pb->cir_code' and mouza_pargona_code = '$pb->mouza_pargona_code'"
                        . " and lot_no = '$pb->lot_no' and vill_townprt_code = '$pb->vill_townprt_code'  and Petition_no = '$pb->petition_no'";
                $pet = $data['dag'] = $this->db->query($sql)->row();
                $sql = "SELECT * FROM Chitha_dag_pattadar WHERE dist_code = '$pb->dist_code' and subdiv_code = '$pb->subdiv_code' and cir_code = '$pb->cir_code' and mouza_pargona_code = '$pb->mouza_pargona_code'"
                        . " and lot_no = '$pb->lot_no' and vill_townprt_code = '$pb->vill_townprt_code' and TRIM(patta_no) = trim('$pet->patta_no') and patta_type_code = '$pet->patta_type_code' and dag_no='$pet->dag_no' and (p_flag ='0' or p_flag is null) ";
                $dagpattadar = $this->db->query($sql)->result();
                foreach ($dagpattadar as $p) {
                    $sql = "SELECT * FROM Chitha_pattadar WHERE dist_code = '$pb->dist_code' and subdiv_code = '$pb->subdiv_code' and cir_code = '$pb->cir_code' and mouza_pargona_code = '$pb->mouza_pargona_code'"
                            . " and lot_no = '$pb->lot_no' and vill_townprt_code = '$pb->vill_townprt_code' and TRIM(patta_no) = trim('$pet->patta_no') and patta_type_code = '$pet->patta_type_code' and pdar_id='$p->pdar_id' ";
                    //echo $sql;
                    $data['pattadar'][] = $this->db->query($sql)->result();
                }

                $sql = "Select loc_name as cirname from    location where dist_code = '$pb->dist_code' and subdiv_code = '$pb->subdiv_code' and cir_code = '$pb->cir_code' and mouza_pargona_code = '00' and lot_no='00' and vill_townprt_code='00000'";
                $data['cirname'] = $this->db->query($sql)->row();
                $sql = "SELECT loc_name as mouza FROM location WHERE dist_code = '$pb->dist_code' and subdiv_code = '$pb->subdiv_code' and cir_code = '$pb->cir_code' and mouza_pargona_code = '$pb->mouza_pargona_code' and lot_no='00' and vill_townprt_code='00000'";
                $data['mouza'] = $this->db->query($sql)->row();
                $sql = "SELECT loc_name as vill FROM location WHERE dist_code = '$pb->dist_code' and subdiv_code = '$pb->subdiv_code' and cir_code = '$pb->cir_code' and mouza_pargona_code = '$pb->mouza_pargona_code' and lot_no='$pb->lot_no' and vill_townprt_code='$pb->vill_townprt_code'";
                $data['vill'] = $this->db->query($sql)->row();
                $sql = "SELECT patta_type as name from    patta_code where type_code='$pet->patta_type_code'";
                $data['PName'] = $this->db->query($sql)->row();

                $data['_view'] = 'partition/regenrate_printpetitioner';
                $this->load->view('layouts/main',$data);
            } else {
                $this->session->set_flashdata('message', 'Case number not Found / Final order have been passed .#' . "$case_no");
                redirect(base_url() . 'index.php/home/index');
            }
        }
    }
    function mut_old_notice() {
        $this->load->helper('html');
        $data['_view'] = 'partition/mut_notice_regenerate';
        $this->load->view('layouts/main',$data);
    }
    function mut_search_regenerate_notice() {
        if (isset($_POST)) {
            //echo "hello";
            $case_no = trim($_POST['case_no']);
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $user_code = $this->session->userdata('user_code');
            $year_no = year_no;
            $this->base_query = "dist_code = '$dist_code' and "
                    . "subdiv_code = '$subdiv_code' and cir_code = '$cir_code' ";
            $detailsQuery = "select * from    petition_basic pb join  petition_dag_details pd on"
                    . " pb.dist_code = pd.dist_code and pb.subdiv_code = pd.subdiv_code and pb.cir_code = pd.cir_code and pb.petition_no=pd.petition_no and "
                    . " pb.lot_no = pd.lot_no and pb.mouza_pargona_code = pd.mouza_pargona_code and pb.vill_townprt_code = pd.vill_townprt_code"
                    . " where pb.case_no = '$case_no'  AND pb.dist_code='$dist_code' and pb.subdiv_code='$subdiv_code' and pb.cir_code='$cir_code' and pb.status='P' ";
            //echo $detailsQuery;
            $details = $this->db->query($detailsQuery)->row();
            $data['details'] = $details;
            $size = sizeof($details);
            if ($size != '0') {
                $applicantQuery = "select * from    petitioner where petition_no = $details->petition_no and $this->base_query";
                $applicants = $this->db->query($applicantQuery)->result();
                $data['applicants'] = $applicants;
                $notifyPerson = "Select * from    petition_notified where petition_no = $details->petition_no "
                        . "and $this->base_query";
                $data['notifyname'] = $this->db->query($notifyPerson)->result();
                $pattadarQuery = "select * from    petition_pattadar where petition_no = $details->petition_no "
                        . "and dag_no='$details->dag_no' and $this->base_query";
                $pattadars = $this->db->query($pattadarQuery)->result();
                $data['pattadars'] = $pattadars;
                $data['case_no'] = $case_no;
                //$this->load->view('../views/header');
                //$this->load->view('../views/partition/regenerate_notice', $data);
                //$this->load->view('../views/footer');

                $data['_view'] = 'partition/regenerate_notice';
                $this->load->view('layouts/main',$data);
            } else {
                $this->session->set_flashdata('message', 'Case number not Found / Final order have been passed .#' . "$case_no");
                redirect(base_url() . 'index.php/home/index');
            }
        }
    }

    function setupdateProDate() {
        $case_no = $this->input->get('case_no');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $this->session->set_userdata('case_no', $case_no);
        $this->session->set_userdata('mouza_pargona_code', $mouza_pargona_code);
        $this->session->set_userdata('lot_no', $lot_no);
        $this->session->set_userdata('vill_townprt_code', $vill_townprt_code);
        redirect(base_url() . 'index.php/Partition/updateProDate');
    }

    function updateProDate() {
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
        $this->dbswitch();
        //$db=  $this->session->userdata('db');
        $this->form_validation->set_rules('update_date', 'Select Date', 'required');
        $this->form_validation->set_rules('remark', 'Write Remarks', 'required');
        if ($this->form_validation->run() == FALSE) {
            //$this->load->view('../views/header');
            //$this->load->view('../views/partition/updatenotice');
            //$this->load->view('../views/footer');
            $data['_view'] = 'partition/updatenotice';
            $this->load->view('layouts/main',$data);

        } else {
            $updateProDate = $this->input->post('update_date');
            $case_no = $this->input->post('case_no');
            $remark = addslashes($this->input->post('remark'));
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
            $lot_no = $this->session->userdata('lot_no');
            $vill_townprt_code = $this->session->userdata('vill_townprt_code');
            $user_code = $this->session->userdata('user_code');
            $q = "Select max(proceeding_id)+1 as id from    petition_proceeding where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
            $id = $this->db->query($q)->row()->id;
            if ($id == null) {
                $id = 1;
            }
            $date = date('Y-m-d');
            $pb = array(
                'next_date_of_hearing' => date('Y-m-d', strtotime($updateProDate)),
                'submission_date' => $date
            );
            $pp = array(
                'case_no' => $case_no,
                'proceeding_id' => $id,
                'date_of_hearing' => date('Y-m-d G:i:s'),
                'co_order' => $remark,
                'next_date_of_hearing' => date('Y-m-d', strtotime($updateProDate)),
                'status' => 0,
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'ip' => $this->utilityclass->get_client_ip()
            );
            $this->db->where('case_no', $case_no);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('mouza_pargona_code', $mouza_pargona_code);
            $this->db->where('lot_no', $lot_no);
            $this->db->where('vill_townprt_code', $vill_townprt_code);
            $this->db->update("petition_basic", $pb);
            $this->db->insert("petition_proceeding", $pp);

            $penUser='CO';
            $rmrk='Change of Hearing date by CO';
            $this->DashboardData($case_no,$penUser,$rmrk);

            $this->session->set_flashdata('message', "Date Updated Successfully ## $case_no !!");
            redirect(base_url() . 'index.php/home/index');
        }
    }
    function SendRtpsStatus($case_no,$msg,$role){
            //$db=  $this->session->userdata('db');
            $sql="select *  from petition_basic where case_no='$case_no'";
            $data=$this->db->query($sql)->row();
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK."partition/partition_status_update.php");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'applid' => $data->applid,
                'application_ref_no' => $data->application_ref_no,
                'rmk' => $msg,
                'status' => $role,
                'task' => $role,
            )));
            $result = curl_exec($curl_handle);
    }
    function SendRtpsFStatus($case_no,$msg){
            $sql="select *  from    petition_basic where case_no='$case_no'";
            $data=$this->db->query($sql)->row();
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK."partition/partition_co_order.php");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'applid' => $data->applid,
                'application_ref_no' => $data->application_ref_no,
                'rmk' => $msg,
                'status' => 'D',
            )));
            $result = curl_exec($curl_handle);
            //exit;
    }
    function SendRtpsPayQuery($case_no,$msg,$fee){
            $sql="select *  from    petition_basic where case_no='$case_no'";
            $data=$this->db->query($sql)->row();
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK."partition/partition_pay_query.php");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'applid' => $data->applid,
                'application_ref_no' => $data->application_ref_no,
                'msg' => $msg,
                'byaipark_fee' => $fee,
                'status' => 'FRS',
            )));
            $result = curl_exec($curl_handle);
            //exit;
    }
    //////////////////////////////
    /////////Modified 08/12/2020///////////
    function updatePartition_order(){
        $case_no=$this->input->get('case_no');
        $user_code=$this->session->userdata('user_code');
        $sql="delete from t_chitha_rmk_ordbasic where ord_no='$case_no'";
        $this->db->query($sql);
        $sql="delete from t_chitha_rmk_infavor_of where ord_no='$case_no'";
        $this->db->query($sql);
        $upsql="Update petition_basic set status='P',add_off_name='$user_code'  where case_no='$case_no' ";
        $this->db->query($upsql);
        redirect('Partition/MapPartitionUpdate');
    }
    ///////////////Dashboard Data Insert///////////////////////////
    function Dashboard($case_no){
        $this->dbb = $this->load->database('dash', TRUE);
        $sql="Select pb.*,pd.dag_no,pd.patta_no,pd.patta_type_code from petition_basic pb join petition_dag_details pd on pb.dist_code=pd.dist_code and pb.subdiv_code=pd.subdiv_code and pb.cir_code=pd.cir_code and pb.mouza_pargona_code=pd.mouza_pargona_code and pb.lot_no=pd.lot_no and pb.vill_townprt_code=pd.vill_townprt_code  and pb.petition_no=pd.petition_no 
            where  pb.case_no='$case_no' ";
        $data=$this->db->query($sql)->row_array();
        if($data['mut_type']=='04'){
            $type='OP';
        }else{
            
        }
        $base= array(
              'dist_code'=> $data['dist_code'],
              'subdiv_code' =>$data['subdiv_code'],
              'cir_code'=>$data['cir_code'],
              'mouza_pargona_code'=>$data['mouza_pargona_code'],
              'lot_no'=>$data['lot_no'],
              'vill_townprt_code'=>$data['vill_townprt_code'],
              'case_no'=>$data['case_no'],
              'date_of_reg'=>$data['date_entry'],
              'dag_no'=>$data['dag_no'],
              'patta_type_code' =>$data['patta_type_code'],
              'patta_no' =>$data['patta_no'],
              'status' =>'P',
              'pending_with_user' =>'CO',
              'case_type' =>$type,
              'date_of_insert'=>date("Y-m-d h:i:s")
            );
        


            unset($base['dag_no']);
            unset($base['patta_type_code']);
            unset($base['patta_no']);
        $this->dbb->insert('dashboard_data',$base);
        $this->db->insert('dashboard_data',$base);


        $sql="Select pdar_name as pet_name,pdar_guardian as guard_name,pdar_rel_guar as guard_rel from petitioner_part where dist_code='$data[dist_code]' and subdiv_code='$data[subdiv_code]' and cir_code='$data[cir_code]' and "
                    . "mouza_pargona_code = '$data[mouza_pargona_code]' and lot_no = '$data[lot_no]' and vill_townprt_code = '$data[vill_townprt_code]' and petition_no='$data[petition_no]'  ";
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
            'date_of_action_taken' => date("Y-m-d h:i:s"),
            'user_designation' => $this->session->userdata('user_desig_code'),
            'remark' => 'Registered By Assistant',
             'ip_address'=>$this->utilityclass->get_client_ip()
             );
         $this->dbb->insert('dashboard_action',$action);
         $this->db->insert('dashboard_action',$action);
    }
    /////////////////////////////////////////

    function DashboardData($case_no,$penUser,$rmrk){
        //////////////Update Dashboard Database///////////////////////
                $this->dbb = $this->load->database('dash', TRUE);
                $base=array(
                    'pending_with_user' => $penUser,
                    'date_of_update'=>date("Y-m-d h:i:s")
                );
                $this->dbb->where('case_no',$case_no);
                $this->dbb->update('dashboard_data',$base);
                $action= array(
                    'case_no' => $case_no,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_of_action_taken' => date("Y-m-d h:i:s"),
                    'user_designation' => $this->session->userdata('user_desig_code'),
                    'remark' => $rmrk,
                    'ip_address'=>$this->utilityclass->get_client_ip()
                     );
                $this->dbb->insert('dashboard_action',$action);
                $this->db->insert('dashboard_action',$action);

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
                        'remark'=>'Final Order Passed',
                        'date_of_update'=>date("Y-m-d h:i:s")
                    );
                    $this->dbb->where('case_no',$case_no);
                    $this->dbb->update('dashboard_data',$base);
                    $action= array(
                        'case_no' => $case_no,
                        'user_code' => $this->session->userdata('user_code'),
                        'date_of_action_taken' => date("Y-m-d h:i:s"),
                        'user_designation' => $this->session->userdata('user_desig_code'),
                        'remark' => 'Final Order Passed',
                        'ip_address'=>$this->utilityclass->get_client_ip()
                         );
                    $this->dbb->insert('dashboard_action',$action);
                    $this->db->insert('dashboard_action',$action);

                    $this->db->where('case_no',$case_no);

                    $this->db->update('dashboard_data',$base);
            /////////////////////////////////////
    }


    function DashboardDataReject($case_no){
        $this->dbb = $this->load->database('dash', TRUE);
                $base=array(
                            'final_order_date' => date('Y-m-d'),
                            'pending_with_user'=>'NA',
                            'status'=>'F',
                            'remark'=>'Case Rejected',
                            'date_of_update'=>date("Y-m-d h:i:s")
                );
                $this->dbb->where('case_no',$case_no);
                $this->dbb->update('dashboard_data',$base);

                $this->db->where('case_no',$case_no);
                $this->db->update('dashboard_data',$base);

                $action= array(
                    'case_no' => $case_no,
                    'user_code' => $this->session->userdata('user_code'),
                    'date_of_action_taken' => date("Y-m-d h:i:s"),
                    'user_designation' => $this->session->userdata('user_desig_code'),
                    'remark' => 'Rejected by CO',
                    'ip_address'=>$this->utilityclass->get_client_ip()
                     );
                $this->dbb->insert('dashboard_action',$action);
                $this->db->insert('dashboard_action',$action);
            }
    ////////////////////////////
    function rejectOrder(){
        $case_no=$this->input->get('case_no');
        $sql="Select * from petition_basic where case_no='$case_no' ";
        $data['pb']=$pb = $this->db->query($sql)->row_array();
        $append = "dist_code='$pb[dist_code]' and subdiv_code='$pb[subdiv_code]' and cir_code='$pb[cir_code]' and mouza_pargona_code='$pb[mouza_pargona_code]' and lot_no='$pb[lot_no]' and "
                    . "vill_townprt_code='$pb[vill_townprt_code]'";
        $data['petitioner'] = $this->db->query("select * from petitioner where $append and petition_no=$pb[petition_no]")->result();
        $data['pattadar'] = $this->db->query("select * from petition_pattadar where $append and petition_no=$pb[petition_no]")->result();
        $data['dag'] = $this->db->query("select * from petition_dag_details where $append  and  petition_no=$pb[petition_no]")->row();
        $data['case_no']=$case_no;
        // $this->load->view('../views/header');
        // $this->load->view('../views/partition/rejectOrder',$data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'partition/rejectOrder';
        $this->load->view('layouts/main',$data);
    }
    public function CORejectOrder() {
        $data = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $case_no = $this->input->get('case_no');
        $sql = "Select * from petition_basic where  dist_code='$dist_code' "
                . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  case_no='$case_no'";
        $pb = $data['pb'] = $this->db->query($sql)->row();
        $sql = "Select * from copattadar_consent where dist_code='$dist_code' "
                . "and subdiv_code='$subdiv_code' and cir_code='$cir_code' and case_no='$case_no' and consent !='' ";
        $data['consent'] = $this->db->query($sql)->result();
        $location = $this->utilityclass->getLocationFromSession();
        $dist_code = $this->utilityclass->getDistrictName($pb->dist_code);
        $subdiv_code = $this->utilityclass->getSubDivName($pb->dist_code, $pb->subdiv_code);
        $cir_code = $this->utilityclass->getCircleName($pb->dist_code, $pb->subdiv_code, $pb->cir_code);
        $mouza_pargona_code = $this->utilityclass->getMouzaName($pb->dist_code, $pb->subdiv_code, $pb->cir_code, $pb->mouza_pargona_code);
        $lot_no = $this->utilityclass->getLotName($pb->dist_code, $pb->subdiv_code, $pb->cir_code, $pb->mouza_pargona_code, $pb->lot_no);
        $vill_townprt_code = $this->utilityclass->getVillageName($pb->dist_code, $pb->subdiv_code, $pb->cir_code, $pb->mouza_pargona_code, $pb->lot_no, $pb->vill_townprt_code);
        $data['location'] = array(
            'dist' => $dist_code,
            'sub' => $subdiv_code,
            'cir' => $cir_code,
            'mouza' => $mouza_pargona_code,
            'lot' => $lot_no,
            'vill' => $vill_townprt_code
        );
        $SecondData = array(
            'dist_code' => $pb->dist_code,
            'subdiv_code' => $pb->subdiv_code,
            'cir_code' => $pb->cir_code,
            'mouza_pargona_code' => $pb->mouza_pargona_code,
            'lot_no' => $pb->lot_no,
            'vill_townprt_code' => $pb->vill_townprt_code,
            'year_no' => $pb->year_no,
            'case_no' => $pb->case_no,
            'petition_no' => $pb->petition_no
        );
        $this->session->set_userdata($SecondData);
        $q = "select * from petition_dag_details "
                . "where petition_no='$pb->petition_no' and dist_code='$pb->dist_code' and "
                . " cir_code = '$pb->cir_code' and subdiv_code='$pb->subdiv_code' and "
                . " mouza_pargona_code = '$pb->mouza_pargona_code' and lot_no = '$pb->lot_no' and "
                . " vill_townprt_code = '$pb->vill_townprt_code' ";
        $data['dags'] = $this->db->query($q)->result();
        $sql = "select * from petitioner_part "
                . "where petition_no='$pb->petition_no' and dist_code='$pb->dist_code' and "
                . " cir_code = '$pb->cir_code' and subdiv_code='$pb->subdiv_code' and "
                . " mouza_pargona_code = '$pb->mouza_pargona_code' and lot_no = '$pb->lot_no' and "
                . " vill_townprt_code = '$pb->vill_townprt_code' ";
        $data['PetiPart'] = $this->db->query($sql)->result();
        $sql = "select * from petition_lm_note "
                . "where petition_no='$pb->petition_no' and dist_code='$pb->dist_code' and "
                . " cir_code = '$pb->cir_code' and subdiv_code='$pb->subdiv_code' and "
                . " mouza_pargona_code = '$pb->mouza_pargona_code' and lot_no = '$pb->lot_no' and "
                . " vill_townprt_code = '$pb->vill_townprt_code' ";
        $data['skNote'] = $data['lmNote'] = $this->db->query($sql)->result();
        //  $arr_size=  sizeof($lm);
        $sql = "select * from petition_byayprak "
                . "where petition_no='$pb->petition_no' and dist_code='$pb->dist_code' and "
                . " cir_code = '$pb->cir_code' and subdiv_code='$pb->subdiv_code' and "
                . " mouza_pargona_code = '$pb->mouza_pargona_code' and lot_no = '$pb->lot_no' and "
                . " vill_townprt_code = '$pb->vill_townprt_code' ";
        //echo $sql;
        $data['byayprak'] = $this->db->query($sql)->row();
        
        $q = "Select * from Petition_Proceeding where case_no='$case_no' and dist_code='$pb->dist_code' "
                . "and subdiv_code='$pb->subdiv_code' and cir_code='$pb->cir_code' ";
        $data['pd'] = $this->db->query($q)->result();
        // $this->load->view('../views/header');
        // $this->load->view('../views/partition/rejectorderco', $data);
        // $this->load->view('../views/footer');
        $data['_view'] = 'partition/rejectorderco';
        $this->load->view('layouts/main',$data);
    }
    function confirmRejectOrder(){
        $this->form_validation->set_rules('remark', 'Remark', 'required');
        $this->form_validation->set_rules('case_no', 'Case Number', 'required');
        //$this->form_validation->set_rules('type', 'type', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message',"Case No not Found. Please Try Again");
            redirect('/home');
        }else{
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $user_code = $this->session->userdata('user_code');
            $case_no=$this->input->post('case_no');
            $remark=$this->input->post('remark');
            //$case_no=$this->input->post('case_no');
            $q = "Select max(proceeding_id)+1 as id from petition_proceeding where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
            $id = $this->db->query($q)->row()->id;
            if ($id == null) {
                $id = 1;
            }
            $date = date('Y-m-d');
            $pp = array(
                'case_no' => $case_no,
                'proceeding_id' => $id,
                'date_of_hearing' => date('Y-m-d G:i:s'),
                'co_order' => $remark,
                'next_date_of_hearing' => date('Y-m-d'),
                'status' => 'F',
                'user_code' => $user_code,
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'ip' => $this->utilityclass->get_client_ip()
            );
            $pb=array(
                'status'=>'D',
                'order_passed'=>'Y',
                'date_of_order'=>date('Y-m-d G:i:s'),
                'co_user_code'=>$user_code,
            );
            $this->db->where('case_no', $case_no);
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->update('petition_basic', $pb);
            $this->db->insert('petition_proceeding', $pp);

            $this->DashboardDataReject($case_no);

            $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
            if($basundharaExist){
                $rmk= $remark;
                $status='R';
                $task='CO';
                $pen='NA';
                $case=$case_no;
                $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
            }
            $this->session->set_flashdata('message', "Case Rejected Successfully ## $case_no !!");
            redirect(base_url() . 'index.php/home/index');   
        }
    }
    /////////////08-03-2022////////////
    public function revertback(){
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
        $circle_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $user_code=$this->session->userdata('user_code');

        if ($this->input->server('REQUEST_METHOD') == 'GET') { 

        //escalation implementation================
            $es_flag_data = $this->db->query("select es_flag,out_of_esc from  petition_basic where "
                                        . " case_no='$case_no'")->row();
            $flag =false;
            $remaining_days_CO='';
            if($es_flag_data->es_flag == 1 && ESCALATION_ENABLE == 1 && $es_flag_data->out_of_esc == 0){
                //remaining Days of LM ============
                $escalatedRowDetailsAgainstPetitionno = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($case_no);
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
            $data['es_flag'] = $es_flag_data->es_flag;
            $data['flag'] = $flag;
            $data['remainingDaysCO'] = $remaining_days_CO;
            $data['out_of_esc'] = $es_flag_data->out_of_esc;



            $data['_view'] = 'partition/revertOfcPartitionCase';
            $this->load->view('layouts/main',$data);
        }
        else if ($this->input->server('REQUEST_METHOD') == 'POST')
        {
            $this->db->trans_begin();

            $rmk=addslashes(trim($_POST['revert_report_remarks_co']));
            $coname=$this->utilityclass->getSelectedCOName($dist_code,$subdiv_code,$circle_code,$user_code);
            $rmk=$rmk . "  চক্র বিষয়া : " . $coname->username; 

            $this->load->library('form_validation');
            $this->form_validation->set_rules('revert_report_remarks_co', 'Remarks', 'trim|required|xss_clean');
            if($this->form_validation->run()) //if successful
            {
                $data = array(
                    'lm_note_yn' => null,
                    'lm_note_date' => null,
                    'is_pending' => 'Y',
                );                
                $this->db->where('case_no', $case_no);
                $update = $this->db->update('petition_basic', $data);    

                if($this->db->affected_rows() != 1){ //if no updation made
                    $this->db->trans_rollback();
                    $this->session->set_flashdata(array('message' => "Revert Failed. No rows effected.."));
                    redirect(base_url()."index.php/partition/CoPendingSecond");
                    return;
                }
                else { // successful

                    $proceeding_id = $this->db->query("SELECT max(proceeding_id)+1 as proceed_id FROM petition_proceeding WHERE case_no=?", array($case_no));
                    if($proceeding_id->num_rows()<=0){
                        $this->db->trans_rollback();
                        $this->session->set_flashdata(array('message' => "Proceeding Report Missing"));
                        redirect(base_url()."index.php/partition/CoPendingSecond");
                        return;
                    }
                    $proceeding = [
                        'case_no' => $case_no,
                        'proceeding_id' => $proceeding_id->row()->proceed_id,
                        'co_order' => $rmk,
                        'user_code' => $user_code,
                        'date_entry' => date('Y-m-d h:i:s'),
                        'status' => 'Pending',
                        'dist_code' => $dist_code,
                        'subdiv_code' => $subdiv_code,
                        'cir_code' => $circle_code,
                        'operation' => 'E',
                        'date_of_hearing' => date('Y-m-d h:i:s'),
                        'ip' => $this->utilityclass->get_client_ip()
                    ];
                    
                    $ins = $this->db->insert('petition_proceeding', $proceeding);
                    if($ins == true){


                        //ESCALATION CODE INTEGRATION================SANMRI

                        $query1 = $this->db->query("SELECT es_flag,mouza_pargona_code,lot_no,out_of_esc FROM petition_basic WHERE case_no=?",array($case_no))->row();
                        $user_code = $this->session->userdata('user_code');
                        $executionDate = $this->input->post('executionDate');
                        if($query1->es_flag == 1 && ESCALATION_ENABLE == 1 && $query1->out_of_esc == 0){
                            $allocation_days = null;
                            if($this->input->post('allocate_day') !=null){
                                $allocation_days = $this->input->post('allocate_day');
                            }
                            $escalationUpdateStatus = $this->Escalationmodel->escalationCORevertToLMOPART($executionDate,$dist_code,$subdiv_code,$circle_code,$case_no,$user_code,$query1->mouza_pargona_code,$query1->lot_no,$allocation_days);
                            log_message("error", "#ESC5935, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

                            if($escalationUpdateStatus['responseType'] == 0){
                                $this->db->trans_rollback();
                                log_message("error", "#ESC5935, transaction-error in method 'Partition/revertBack' with case-no :". $case_no);
                                $this->session->set_flashdata('message', "Something went wrong.PART- Error Code(#ESC5935)");
                                redirect(base_url() . "index.php/home");
                            }
                        }




                        $this->db->trans_commit();
                        $this->session->set_flashdata(array('message' => "Case has successfully reverted to LM"));
                        redirect(base_url()."index.php/partition/CoPendingSecond");       
                    }
                    else
                    {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata(array('message' => "Insertion failed in Proceeding"));
                        redirect(base_url()."index.php/partition/CoPendingSecond");       
                        return;
                    }
                }
            }            
        }
    }

    public function getRevertedOfcPartitionCases() 
    {
        $this->dbswitch();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $year_no = year_no;

        $data['revertedCase'] = $this->db->query("SELECT *, ba.basundhara FROM 
        petition_basic A LEFT JOIN basundhar_application ba on A.case_no=ba.dharitree 
        WHERE A.order_passed IS NULL AND A.dist_code=? AND A.subdiv_code=? AND A.cir_code=? AND
        A.mouza_pargona_code=? AND A.lot_no=? AND A.lm_note_yn IS NULL AND A.mut_type='04' AND 
        A.is_pending='Y'", array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no))->result();

        foreach($data['revertedCase'] as $rows) {

            if($rows->es_flag == 1 && ESCALATION_ENABLE == 1 && $rows->out_of_esc == 0){

                $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
                // log_message('error', '#3015: Escalation details : '.json_encode($escRow));

                if(!empty($escRow) && $escRow != null)
                {
                    $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->lm_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry));

                    if(!empty($escData) && $escData != null)
                    {
                        log_message('error', '#3019: Escalation details : '.json_encode($escData)); 

                        $rows->escalation_date = $escData->escalation_date;
                        $rows->escalation_zone = $escData->escalation_zone;
                        $rows->assigned_date   = $escData->assigned_date;
                    }
                    else 
                    {
                        $rows->escalation_date = 'NA';
                        $rows->escalation_zone = 'NA';
                    } 
                }
                else 
                {
                    $rows->escalation_date = 'NA';
                    $rows->escalation_zone = 'NA';
                }
            }
            else 
            {
                $rows->escalation_date = 'NA';
                $rows->escalation_zone = 'NA';
            }
            
        }        

        $data['_view'] = 'partition/revertedPendingOPartCases';
        $this->load->view('layouts/main', $data);
    }

    public function revertReportOP()
    {
        $data['genders'] = $this->mutationmodel->getGenders();
        $data['time'] = time();
        //$data['nok_temp']=array();
        $case_no = $this->input->get('name');
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');

        $pet_basic = $this->db->query("SELECT * FROM petition_basic WHERE 
        case_no=? AND dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? 
        AND lot_no=?", array($case_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, 
        $lot_no))->row();
        $petition_no = $pet_basic->petition_no;

        $data['petition_basic'] = $pet_basic;

        $dag = $this->db->query("SELECT * FROM petition_dag_details 
        WHERE petition_no=? AND dist_code=? AND subdiv_code=? AND cir_code=? AND 
        mouza_pargona_code=? AND lot_no=?", array($petition_no, 
        $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no))->row();
        $data['dag'] = $dag;

        $data['first_party'] = $this->db->query("SELECT * FROM petitioner_part 
        WHERE petition_no=? AND dist_code=? AND subdiv_code=? AND cir_code=? AND 
        mouza_pargona_code=? AND lot_no=?", array($petition_no, 
        $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no))->result();

        $this->load->model('relation/relationmodel');
        $data['relation'] = $this->relationmodel->getRelations();
        $data['gender'] = $this->partmodel->getGender();

        $data['pattadar_list'] = $this->db->query("SELECT  distinct(A.pdar_id), A.pdar_name, 
        A.pdar_father, A.pdar_add1, A.pdar_mobile FROM chitha_pattadar A JOIN chitha_dag_pattadar B ON A.dist_code=B.dist_code AND A.subdiv_code=B.subdiv_code AND A.cir_code=B.cir_code AND A.mouza_pargona_code=B.mouza_pargona_code AND A.lot_no=B.lot_no AND A.vill_townprt_code=B.vill_townprt_code AND A.patta_no=B.patta_no AND A.patta_type_code=B.patta_type_code AND A.pdar_id=B.pdar_id WHERE B.dag_no=? AND (B.p_flag='0' or B.p_flag is null) AND A.dist_code=? AND A.subdiv_code=? AND A.cir_code=? AND A.mouza_pargona_code=? AND A.lot_no=? AND A.vill_townprt_code=? AND A.patta_no=? AND A.patta_type_code=? AND A.pdar_id NOT IN (SELECT pdar_id FROM petitioner_part WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND patta_no=? AND patta_type_code=? AND petition_no=? )", array($dag->dag_no,
            $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no,
            $dag->vill_townprt_code, $dag->patta_no, $dag->patta_type_code, 
            $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no,
            $dag->vill_townprt_code, $dag->patta_no, $dag->patta_type_code, $petition_no))->result();
        //echo $this->db->last_query();

        $data['jama_id']=$this->db->query("SELECT id, file_name FROM supportive_document WHERE file_name='".JAMABANDI."' AND case_no=?", array($case_no))->row();

        $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
        if($basundharaExist){
            $data['query']=null;
            $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
            $data['query']=$this->basundharamodel->QueryPost($basundharaExist);
        }
        $data['_view'] = 'partition/revertReportOP';
        $this->load->view('layouts/main', $data);
    }

    public function getPattadarDetail()
    {
        $val = $this->input->post();
        $pet = $this->db->query("SELECT dist_code, subdiv_code, cir_code,
        mouza_pargona_code, lot_no, vill_townprt_code, patta_no, dag_no, 
        patta_type_code FROM petition_dag_details 
        WHERE case_no=?", array($val['case_no']))->row();

        $pattadar = $this->db->query("SELECT A.pdar_id, A.pdar_name, A.pdar_father,
        A.pdar_add1, A.pdar_guard_reln, A.pdar_gender, A.pdar_minor_dob FROM chitha_pattadar A JOIN chitha_dag_pattadar B ON A.dist_code=B.dist_code AND A.subdiv_code=B.subdiv_code AND A.cir_code=B.cir_code AND A.mouza_pargona_code=B.mouza_pargona_code AND A.lot_no=B.lot_no AND A.vill_townprt_code=B.vill_townprt_code AND A.patta_no=B.patta_no AND A.patta_type_code=B.patta_type_code AND A.pdar_id=B.pdar_id WHERE B.dag_no=? AND (B.p_flag=? or B.p_flag is null ) AND A.dist_code=? AND A.subdiv_code=? AND A.cir_code=? AND A.mouza_pargona_code=? AND A.lot_no=? AND A.vill_townprt_code=? AND A.patta_no=? AND A.patta_type_code=? AND A.pdar_id=?", array($pet->dag_no, '0', $pet->dist_code, $pet->subdiv_code, $pet->cir_code, $pet->mouza_pargona_code,
        $pet->lot_no, $pet->vill_townprt_code, $pet->patta_no, 
        $pet->patta_type_code, $val['id']))->row();

        $json['details'] = $pattadar;
        echo json_encode($json);
    }

    public function revertReportOPartSubmit(){
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

        $mutatedLandValidation = [
            [
                'field' => 'note_order',
                'label' => 'Remarks',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'mut_b_op',
                'label' => 'Bigha',
                'rules' => 'trim|required|integer|xss_clean',
            ],
            [
                'field' => 'mut_k_op',
                'label' => 'Katha ',
                'rules' => 'trim|required|integer|xss_clean',
            ],
            [
                'field' => 'mut_lc_op',
                'label' => 'Lessa',
                'rules' => 'trim|required|numeric|xss_clean',
            ],
            [
                'field' => 'mut_g_op',
                'label' => 'Ganda',
                'rules' => 'trim|required|xss_clean',
            ],
        ];
        $validation= null;
        $this->form_validation->set_rules($mutatedLandValidation);
        $this->form_validation->set_message('integer', 'This %s is not valid');
        if ($this->form_validation->run('mutatedLandValidation') == FALSE)
        {
            $this->form_validation->set_error_delimiters('', '');
            foreach($mutatedLandValidation as $rule){
            if (form_error($rule['field'])) {
                $validation['error'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
                }
            }             
        }
        else
        {
            $rmk = addslashes(trim($_POST['note_order']));
            $case_no = $this->input->post('case_no');
            //$del_appl = $this->input->post('del_OPart');
            $mut_b_op = $this->input->post('mut_b_op');
            $mut_k_op = $this->input->post('mut_k_op');
            $mut_lc_op = $this->input->post('mut_lc_op');
            $mut_g_op = $this->input->post('mut_g_op');
            $mut_kr_op = $this->input->post('mut_kr_op');
            $revert_back = $this->session->userdata('user_desig_code');
            $user_code = $this->session->userdata('user_code');
            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $cir_code = $this->input->post('cir_code');
            $mouza_pargona_code = $this->input->post('mouza_pargona_code');
            $lot_no = $this->input->post('lot_no');
            $petition_no = $this->input->post('petition_no');
            $dag_no = $this->input->post('dag_no');

            $this->db->trans_begin();

            $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);

            if($revert_back=='LM')
            {
                $lmname=$this->utilityclass->getDefinedMondalsName($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$user_code);
                $rmk=$rmk ."   ভূমিলেখ্য সহায়ক : ".$lmname->lm_name;
                $task="LM";

                //insert old data of petition_dag_details in basundhara
                $sql = "SELECT * FROM petition_dag_details WHERE petition_no=? 
                AND dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? 
                AND lot_no=? AND dag_no=?";
                $oldData = $this->db->query($sql, array($petition_no, $dist_code, 
                $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $dag_no))->result();

                if($basundhara){
                    $basuData=array(
                        'ip'=>$this->utilityclass->get_client_ip(),
                        'case_no' => $case_no,
                        'basundhara' => $basundhara,
                        'user_code' => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d H:i:s'),
                        'changes_data' => json_encode($oldData),
                    );
                    $basu_ins = $this->db->insert('basundhara_data_updation', $basuData);
                }

                if($basu_ins != 1){
                    $this->db->trans_rollback();
                    log_message("error","#OPART001 Insertion failed in basundhara_data_updation");
                    return false;
                }

                //update mutated land area
                $update = [
                    'm_dag_area_b' => $mut_b_op,
                    'm_dag_area_k' => $mut_k_op,
                    'm_dag_area_lc' => $mut_lc_op,
                    'm_dag_area_g' => $mut_g_op,
                    'm_dag_area_kr' => $mut_kr_op,
                ];
                $this->db->where(['petition_no'=>$petition_no, 'dist_code'=>$dist_code, 'subdiv_code'=>$subdiv_code, 'cir_code'=>$cir_code, 'mouza_pargona_code'=>$mouza_pargona_code, 'lot_no'=>$lot_no, 'dag_no'=>$dag_no]);
                $this->db->update('petition_dag_details', $update);
                if($this->db->affected_rows() != 1){
                    $this->db->trans_rollback();
                    log_message("error","#OPART002 Updation failed in petition_dag_details");
                    return false;
                }
                $data = array(
                    'lm_note_yn' => 'Y',
                    'lm_note_date' => date('Y-m-d h:i:s'),
                    'is_pending' => null,
                );                
                $this->db->where('case_no', $case_no);
                $this->db->update('petition_basic', $data);    
                if($this->db->affected_rows() != 1){
                    $this->db->trans_rollback();
                    log_message("error","#OPART005 Updation failed in petition_basic");
                    return false;
                }

                if($basundhara){
                    $this->basundharamodel->insertproceeding($case_no,$rmk);
                    //$this->db->where('case_no',$case_no);
                    $application_no=$basundhara;
                    $rmk='Reverted Case has Forwarded to CO';
                    $status='M';
                    $pen='CO';
                    $case=$case_no;
                    
                    $this->DashboardData($case_no,$pen,$rmk);   

                    $dist_code = $this->session->userdata('dist_code');
                    $subdiv_code = $this->session->userdata('subdiv_code');
                    $cir_code = $this->session->userdata('cir_code');

                    //ESCALATION CODE INTEGRATION================SANMRI
                    $esData = $this->db->query("select es_flag,next_date_of_hearing,out_of_esc,proceeding_yn from  petition_basic where case_no='$case_no'")->row();
                    if($esData->es_flag == 1 && ESCALATION_ENABLE == 1 && $esData->out_of_esc == 0)
                    {

                        $user_code = $this->session->userdata('user_code');
                        $executionDate = $this->input->post('executionDate');
                        $hearing_date = date('Y-m-d',strtotime($esData->next_date_of_hearing));

                        ///check action taken happen or not/////
                        ///if not then executionDate will be the assigned date otherwise hearing date will be assigned date///
                        if($esData->proceeding_yn == '1')
                        {
                            $executionDate = date('Y-m-d H:i:s');
                        }
                        else
                        {
                            $executionDate = $esData->next_date_of_hearing;
                        }
                        $escalationUpdateStatus = $this->Escalationmodel->escalationLMRevertReportOPART($executionDate,$dist_code,$subdiv_code,$cir_code,$case_no,$user_code,$hearing_date);
                        log_message("error", "#ESC6291, transaction-error-STATUS======".json_encode($escalationUpdateStatus));
                        if($escalationUpdateStatus['responseType'] == 0)
                        {
                            $this->db->trans_rollback();
                            log_message("error", "#ESC6291, transaction-error in method 'partition/revertReportOPartSubmit' with case-no :". $case_no);
                            $this->session->set_flashdata('message', "Something went wrong. Error Code(#ESC6291)");
                            redirect(base_url() . "index.php/home");
                        }
                        
                    }
                    ///////////////END ESCALATION//////////////

                    $this->basundharamodel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);



                    $this->session->set_flashdata('message',"Case has been forwarded");
                    $this->db->trans_commit();
                    $validation['final'] = 'true';
                }
            }
        }
        echo json_encode($validation);
        return;       
    }

    // public function addAdditionalFirstParty()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //         $addPartyValidation = [
    //             [
    //                 'field' => 'add_pattadar',
    //                 'label' => 'Pattadar',
    //                 'rules' => 'trim|required|integer|xss_clean',
    //             ],
    //             [
    //                 'field' => 'appl_name',
    //                 'label' => 'Applicant ',
    //                 'rules' => 'trim|required|xss_clean',
    //             ],
    //             [
    //                 'field' => 'guardian_name',
    //                 'label' => 'Guardian Name',
    //                 'rules' => 'trim|required|xss_clean',
    //             ],
    //             [
    //                 'field' => 'relation',
    //                 'label' => 'Relation',
    //                 'rules' => 'trim|required|xss_clean',
    //             ],
    //             [
    //                 'field' => 'gender',
    //                 'label' => 'Gender',
    //                 'rules' => 'trim|required|xss_clean',
    //             ],
    //             [
    //                 'field' => 'dob',
    //                 'label' => 'Date of Birth',
    //                 'rules' => 'trim|required|xss_clean',
    //             ],
    //             [
    //                 'field' => 'address',
    //                 'label' => 'Address',
    //                 'rules' => 'trim|required|xss_clean',
    //             ],
    //         ];
    //         $validation= null;
    //         $this->form_validation->set_rules($addPartyValidation);
    //         $this->form_validation->set_message('integer', 'This %s is not valid');
    //         if ($this->form_validation->run('addPartyValidation') == FALSE)
    //         {
    //             $this->form_validation->set_error_delimiters('', '');
    //             foreach($addPartyValidation as $rule){
    //             if (form_error($rule['field'])) {
    //                 $validation['error'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
    //                 }
    //             }             
    //         } 
    //         else 
    //         {
    //             $this->db->trans_begin();
    //             $val = $this->input->post();
    //             $date = date('Y-m-d', strtotime($val['dob']));

    //             $cron_no = $this->db->query("SELECT max(pdar_cron_no)+1 as cron_no 
    //             FROM petitioner_part WHERE case_no=?", array($val['case_no']))->row();

    //             $field_partition = $this->db->query("SELECT * FROM petitioner_part 
    //             WHERE case_no=?", array($val['case_no']));

    //             $petitioner = $field_partition->row();
    //             $data = clone $petitioner;
    //             $data->pdar_id = $val['add_pattadar'];
    //             $data->pdar_cron_no = $cron_no->cron_no;
    //             $data->pdar_name = $val['appl_name'];
    //             $data->pdar_guardian = $val['guardian_name'];
    //             $data->pdar_rel_guar = $val['relation'];
    //             $data->pdar_add1 = $val['address'];
    //             $data->pdar_strike = 'N';
    //             $data->user_code = $this->session->userdata('user_code');
    //             $data->date_entry = date('Y-m-d h:i:s');
    //             $data->operation = 'E';
    //             $data->is_converted_pattadar = 'N';
    //             $data->pdar_gender = $val['gender'];
    //             $data->case_no = $val['case_no'];
    //             unset($data->pdar_mobile);
    //             unset($data->id);
    //             $ins = $this->db->insert('petitioner_part', $data);
                
    //             if($ins != 1){
    //                 $this->db->trans_rollback();
    //                 log_message("error","#ERR001 Insertion failed in petitioner_part");
    //                 return false;
    //             }

    //             $basundhara=$this->basundharamodel->checkExistBasundhar($val['case_no']);
    //             if($basundhara){
    //                 $basuData=array(
    //                     'ip'=>$this->utilityclass->get_client_ip(),
    //                     'case_no' => $val['case_no'],
    //                     'basundhara' => $basundhara,
    //                     'user_code' => $this->session->userdata('user_code'),
    //                     'date_entry' => date('Y-m-d H:i:s'),
    //                     'changes_data' => json_encode($data),
    //                 );
    //                 $basu_ins = $this->db->insert('basundhara_data_updation', $basuData);
    //             }

    //             if($basu_ins != 1){
    //                 $this->db->trans_rollback();
    //                 log_message("error","#ERR002 Insertion failed in basundhara_data_updation");
    //                 return false;
    //             }

    //             $new_petitioner = $this->db->query("SELECT * FROM petitioner_part 
    //             WHERE case_no=?", array($val['case_no']));

    //             $validation['details'] = $new_petitioner->result();
    //             $data = $new_petitioner->row();

    //             $pattadar = $this->db->query("SELECT DISTINCT(A.pdar_id), A.pdar_name, A.pdar_father,
    //             A.pdar_add1, A.pdar_guard_reln, A.pdar_gender, A.pdar_minor_dob
    //             FROM chitha_pattadar A
    //             JOIN chitha_dag_pattadar B
    //             ON
    //             A.dist_code=B.dist_code AND A.subdiv_code=B.subdiv_code AND A.cir_code=B.cir_code AND A.mouza_pargona_code=B.mouza_pargona_code AND A.lot_no=B.lot_no AND A.vill_townprt_code=B.vill_townprt_code AND A.patta_no=B.patta_no AND A.patta_type_code=B.patta_type_code AND A.pdar_id=B.pdar_id WHERE B.dag_no=? AND B.p_flag!=? AND A.dist_code=? AND A.subdiv_code=? AND A.cir_code=? AND A.mouza_pargona_code=? AND A.lot_no=? AND A.vill_townprt_code=? AND A.patta_no=? AND A.patta_type_code=? AND A.pdar_id NOT IN (
    //             SELECT pdar_id FROM petitioner_part WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND patta_no=? AND patta_type_code=? AND petition_no=? )", array($data->dag_no, '1',
    //             $data->dist_code, $data->subdiv_code, $data->cir_code, 
    //             $data->mouza_pargona_code, $data->lot_no, $data->vill_townprt_code, 
    //             $data->patta_no, $data->patta_type_code, $data->dist_code, 
    //             $data->subdiv_code, $data->cir_code, 
    //             $data->mouza_pargona_code, $data->lot_no, $data->vill_townprt_code, 
    //             $data->patta_no, $data->patta_type_code, $data->petition_no))->result();
                
    //             $validation['pattadar_list'] = $pattadar;

    //             $this->db->trans_commit();
                
    //         }
    //         echo json_encode($validation);
    //         return;
    //     }
    // }
    public function addAdditionalFirstParty()
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
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $addPartyValidation = [
                [
                    'field' => 'add_pattadar',
                    'label' => 'Pattadar',
                    'rules' => 'trim|required|integer|xss_clean',
                ],
                [
                    'field' => 'appl_name',
                    'label' => 'Applicant ',
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
                    'field' => 'gender',
                    'label' => 'Gender',
                    'rules' => 'trim|required|xss_clean',
                ],
                [
                    'field' => 'dob',
                    'label' => 'Date of Birth',
                    'rules' => 'trim|required|xss_clean',
                ],
                [
                    'field' => 'address',
                    'label' => 'Address',
                    'rules' => 'trim|required|xss_clean',
                ],
            ];
            $validation= null;
            $this->form_validation->set_rules($addPartyValidation);
            $this->form_validation->set_message('integer', 'This %s is not valid');
            if ($this->form_validation->run('addPartyValidation') == FALSE)
            {
                $this->form_validation->set_error_delimiters('', '');
                foreach($addPartyValidation as $rule){
                if (form_error($rule['field'])) {
                    $validation['error'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
                    }
                }             
            } 
            else 
            {
                $this->db->trans_begin();
                $val = $this->input->post();
                $date = date('Y-m-d', strtotime($val['dob']));
                $case_no = $val['case_no'];

                //get petition_no from petition_basic
                $pb = $this->db->query("SELECT * FROM 
                    petition_basic WHERE case_no=?",$case_no)->row();
                
                $petition_no = $pb->petition_no;
                $dist = $pb->dist_code; 
                $sub = $pb->subdiv_code; 
                $cir = $pb->cir_code; 
                $mouza = $pb->mouza_pargona_code; 
                $lot = $pb->lot_no; 
                $vill = $pb->vill_townprt_code;

                //get dag detail from petition dag details
                $pd = $this->db->query("SELECT * FROM 
                    petition_dag_details WHERE case_no=? AND petition_no=? AND
                    dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=?
                    AND lot_no=? AND vill_townprt_code=?", 
                    array($case_no, $petition_no, $dist, $sub, $cir, $mouza, 
                        $lot, $vill))->row();
                //echo $this->db->last_query(); return;

                $cron_no = $this->db->query("SELECT max(pdar_cron_no)+1 as cron_no 
                FROM petitioner_part WHERE case_no=?", array($val['case_no']))->row()->cron_no;
                //echo $this->db->last_query(); return;

                if($cron_no == null || $cron_no == ''){
                    $cron_no = 1;
                }
                else { $cron_no = $cron_no; }

                $data = [
                    'dist_code' => $dist,
                    'subdiv_code' => $sub,
                    'cir_code' => $cir,
                    'mouza_pargona_code' => $mouza,
                    'lot_no' => $lot,
                    'vill_townprt_code' => $vill,
                    'year_no' => date('Y'),
                    'petition_no' => $petition_no,
                    'case_no' => $case_no,
                    'dag_no' => $pd->dag_no,
                    'patta_no' => $pd->patta_no,
                    'patta_type_code' => $pd->patta_type_code,
                    'pdar_id' => $val['add_pattadar'],
                    'pdar_cron_no' => $cron_no,
                    'pdar_name' => $val['appl_name'],
                    'pdar_guardian' => $val['guardian_name'],
                    'pdar_rel_guar' => $val['relation'],
                    'pdar_add1' => $val['address'],
                    'pdar_strike' => 'N',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'is_converted_pattadar' => 'N',
                    'pdar_gender' => $val['gender'],
                    'case_no' => $val['case_no'],    
                ];
                $ins = $this->db->insert('petitioner_part', $data);
                if($ins != 1){
                    $this->db->trans_rollback();
                    log_message("error","#ERR001 Insertion failed in petitioner_part");
                    return false;
                }

                $basundhara=$this->basundharamodel->checkExistBasundhar($val['case_no']);
                if($basundhara){
                    $basuData=array(
                        'ip'=>$this->utilityclass->get_client_ip(),
                        'case_no' => $val['case_no'],
                        'basundhara' => $basundhara,
                        'user_code' => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d H:i:s'),
                        'changes_data' => json_encode($data),
                    );
                    $basu_ins = $this->db->insert('basundhara_data_updation', $basuData);
                }

                if($basu_ins != 1){
                    $this->db->trans_rollback();
                    log_message("error","#ERR002 Insertion failed in basundhara_data_updation");
                    return false;
                }

                $new_petitioner = $this->db->query("SELECT * FROM petitioner_part 
                WHERE case_no=?", array($val['case_no']));

                $validation['details'] = $new_petitioner->result();
                $data = $new_petitioner->row();

                $pattadar = $this->db->query("SELECT DISTINCT(A.pdar_id), A.pdar_name, A.pdar_father,
                A.pdar_add1, A.pdar_guard_reln, A.pdar_gender, A.pdar_minor_dob
                FROM chitha_pattadar A
                JOIN chitha_dag_pattadar B
                ON
                A.dist_code=B.dist_code AND A.subdiv_code=B.subdiv_code AND A.cir_code=B.cir_code AND A.mouza_pargona_code=B.mouza_pargona_code AND A.lot_no=B.lot_no AND A.vill_townprt_code=B.vill_townprt_code AND A.patta_no=B.patta_no AND A.patta_type_code=B.patta_type_code AND A.pdar_id=B.pdar_id WHERE B.dag_no=? AND (B.p_flag=? or B.p_flag is null) AND A.dist_code=? AND A.subdiv_code=? AND A.cir_code=? AND A.mouza_pargona_code=? AND A.lot_no=? AND A.vill_townprt_code=? AND A.patta_no=? AND A.patta_type_code=? AND A.pdar_id NOT IN (
                SELECT pdar_id FROM petitioner_part WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND patta_no=? AND patta_type_code=? AND petition_no=? )", array($data->dag_no, '0',
                $data->dist_code, $data->subdiv_code, $data->cir_code, 
                $data->mouza_pargona_code, $data->lot_no, $data->vill_townprt_code, 
                $data->patta_no, $data->patta_type_code, $data->dist_code, 
                $data->subdiv_code, $data->cir_code, 
                $data->mouza_pargona_code, $data->lot_no, $data->vill_townprt_code, 
                $data->patta_no, $data->patta_type_code, $data->petition_no))->result();
                
                $validation['pattadar_list'] = $pattadar;

                $this->db->trans_commit();
                
            }
            echo json_encode($validation);
            return;
        }
    }

    //////////////////
    function deleteFirstPartyFPART(){
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
            $data = [
                'success' => false,
                'errors' => $errorMessageStr
            ];
            return $this->output
                    ->set_status_header('403')
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data)); 
        }
        //xss & security validation ends 
        $id = $_POST['id'];
        $case_no = $_POST['case_no'];

        $field_part = $this->db->query("SELECT * FROM petition_basic WHERE case_no=?", array($case_no))->row();

        $dist_code = $field_part->dist_code;
        $subdiv_code = $field_part->subdiv_code;
        $cir_code = $field_part->cir_code;
        $mouza_pargona_code = $field_part->mouza_pargona_code;
        $lot_no = $field_part->lot_no;
        $vill_code = $field_part->vill_townprt_code;

        $append = " dist_code='$dist_code' AND subdiv_code='$subdiv_code' AND 
        cir_code='$cir_code' AND mouza_pargona_code='$mouza_pargona_code' AND 
        lot_no='$lot_no' AND vill_townprt_code='$vill_code'";

        $count = $this->db->query("SELECT * FROM petitioner_part WHERE case_no=? AND $append", array($case_no))->num_rows();

        if($count == 1){ // one applicant available
            $json['delete'] = false;
        }
        else
        {
            $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
            $old_data = $this->db->query("SELECT * FROM petitioner_part WHERE 
            case_no=? AND pdar_id=? and dist_code=? and subdiv_code=? 
            and cir_code=? and mouza_pargona_code=? and lot_no=?", array($case_no, $id, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no))->row();
            $data=array(
                'ip'=>$this->utilityclass->get_client_ip(),
                'case_no' => $case_no,
                'basundhara' => $basundharaExist,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d H:i:s'),
                'changes_data' => json_encode($old_data),
            );                    
            $delete=$this->db->insert('basundhara_data_updation', $data);
            if($delete==true)
            {
                $del = $this->db->query("DELETE FROM petitioner_part WHERE pdar_id=? 
                AND case_no=? and dist_code=? and subdiv_code=? AND cir_code=? AND
                mouza_pargona_code=? AND lot_no=?", array($id, $case_no, $dist_code, $subdiv_code,
                $cir_code, $mouza_pargona_code, $lot_no));
                if($del == true)
                {
                    $dag = $this->db->query("SELECT dag_no, patta_no, patta_type_code FROM petition_dag_details WHERE case_no=?", array($case_no))->row();

                    $pattadar = $this->db->query("SELECT DISTINCT(A.pdar_id), A.pdar_name, 
                    A.pdar_father,
                    A.pdar_add1, A.pdar_guard_reln, A.pdar_gender, A.pdar_minor_dob
                    FROM chitha_pattadar A
                    JOIN chitha_dag_pattadar B
                    ON
                    A.dist_code=B.dist_code AND A.subdiv_code=B.subdiv_code AND A.cir_code=B.cir_code AND A.mouza_pargona_code=B.mouza_pargona_code AND A.lot_no=B.lot_no AND A.vill_townprt_code=B.vill_townprt_code AND A.patta_no=B.patta_no AND A.patta_type_code=B.patta_type_code AND A.pdar_id=B.pdar_id WHERE
                    B.dag_no=? 
                    AND (B.p_flag = '0' or B.p_flag is null) AND A.dist_code=? AND A.subdiv_code=? AND A.cir_code=? AND A.mouza_pargona_code=? AND A.lot_no=? AND A.vill_townprt_code=? AND A.patta_no=? AND A.patta_type_code=? AND A.pdar_id NOT IN (
                    SELECT pdar_id FROM petitioner_part WHERE 
                    dist_code=? 
                    AND subdiv_code=?
                    AND cir_code=?
                    AND mouza_pargona_code=?
                    AND lot_no=?
                    AND vill_townprt_code=?
                    AND patta_no=?
                    AND patta_type_code=? AND case_no=?
                    )", array($dag->dag_no, 
                    $dist_code, $subdiv_code, $cir_code, 
                    $mouza_pargona_code, $lot_no, $vill_code, 
                    $dag->patta_no, $dag->patta_type_code, $dist_code, 
                    $subdiv_code, $cir_code, 
                    $mouza_pargona_code, $lot_no, $vill_code, 
                    $dag->patta_no, $dag->patta_type_code, $case_no))->result();
                    
                    $json['pattadar_list'] = $pattadar;

                    $detail = $this->db->query("SELECT * FROM 
                    petitioner_part WHERE case_no=?", array($case_no))->result();
                    $json['details'] = $detail;
                    echo json_encode($json); 
                    return;  
                }
                else
                {
                   $json['delete'] = false; 
                   return;
                }
            }   
        }
        echo json_encode($json);
    }
    //////////////////////
    public function finalOrderOfcPartitionCO()
    {
        if($this->session->userdata('user_desig_code')!='CO'){
            echo "<p class='text-danger'>Error. You are not authorized</p>";
            return;
        }
        $data = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $petition_no = $this->session->userdata('petition_no');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $vill_townprt_code = $this->session->userdata('vill_townprt_code');
        $case_no = $this->session->userdata('case_no');
        $user_code = $this->session->userdata('user_code');

        //get from petition_dag_details
        $q1 = "SELECT * FROM  petition_dag_details WHERE dist_code=? AND subdiv_code=? 
        AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? 
        AND petition_no=? ";
        $dag = $data['values'] = $land = $data['land'] = $this->db->query($q1, 
            array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, 
                $vill_townprt_code, $petition_no))->row();

        //get from patta_code
        $q2 = "SELECT patta_type FROM patta_code WHERE type_code = ?";
        $data['patta'] = $this->db->query($q2, $dag->patta_type_code)->row();
        
        //get from petition_basic
        $q3 = "SELECT * FROM petition_basic WHERE dist_code=? AND subdiv_code=? AND 
        cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? 
        AND petition_no=? AND case_no=?";
        $data['pb'] = $data['pbdata'] = $this->db->query($q3, array($dist_code, $subdiv_code, 
            $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, 
            $petition_no, $case_no))->row();

        //get from petition_lm_note
        $q4 = "SELECT * FROM petition_lm_note WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND petition_no=?  
            ORDER BY date(lm_sign_date) ASC";
        $lm = $data['lmnote'] = $plmnote = $data['plmnote'] = $this->db->query($q4, 
            array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, 
                $vill_townprt_code, $petition_no, ))->row();

        $data['getSelectedMondalsName'] = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $lm->lm_code);
        $data['getSelectedSKName'] = $this->utilityclass->getSKByCode($dist_code, $subdiv_code, $cir_code, $lm->user_code);
        $data['getSelectedCOName'] = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $user_code);

        $q5 = "SELECT pdar_id FROM t_chitha_rmk_infavor_of WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
                . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and petition_no='$petition_no' ";

        $q6 = "SELECT * FROM petitioner_part WHERE dist_code=? AND subdiv_code=? AND cir_code=? 
        AND mouza_pargona_code=? AND vill_townprt_code=? AND lot_no=? AND petition_no=? 
        AND pdar_id not IN ($q5)  "; //limit 1
        $data['applicant'] = $this->db->query($q6, array($dist_code, $subdiv_code, $cir_code, 
            $mouza_pargona_code, $vill_townprt_code, $lot_no, $petition_no))->result();

        $q7 = "SELECT * FROM master_guard_rel";
        $data['relation'] = $this->db->query($q7)->result();

        $q8 = "SELECT dag_no, dag_no_int FROM chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND vill_townprt_code=? AND lot_no=? 
            ORDER BY dag_no_int DESC";
        $data['oldDag'] = $this->db->query($q8, array($dist_code, $subdiv_code, $cir_code,
            $mouza_pargona_code, $vill_townprt_code, $lot_no))->result();
        
        $q9 = "SELECT * FROM chitha_dag_pattadar WHERE dist_code=? AND subdiv_code=? 
        AND cir_code=? AND mouza_pargona_code=? AND vill_townprt_code=? AND lot_no=? 
        AND dag_no=? AND (p_flag=? or p_flag is null)";
        $PattadarCount = $this->db->query($q9, array($dist_code, $subdiv_code, $cir_code, 
            $mouza_pargona_code, $vill_townprt_code, $lot_no, $plmnote->dag_no, '0'))->result();

        $q10 = "SELECT dag_area_b, dag_area_k, dag_area_lc, dag_area_g, dag_area_kr FROM chitha_basic WHERE 
        dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? 
        AND vill_townprt_code=? AND lot_no=? AND dag_no=? ";
        $oldland = $this->db->query($q10, array($dist_code, $subdiv_code, $cir_code, 
            $mouza_pargona_code, $vill_townprt_code, $lot_no, $plmnote->dag_no))->row();
        $data['PattadarCount'] = sizeof($PattadarCount);

        $q11 = "SELECT type_code FROM patta_code WHERE mutation='a' ";
        $q12 = "SELECT patta_no AS patta_no FROM jama_patta WHERE dist_code=? 
        AND subdiv_code=? AND cir_code=? AND 
        mouza_pargona_code=? AND vill_townprt_code=? AND lot_no=? AND patta_type_code=? 
        AND TRIM(patta_no)!='' AND TRIM(patta_no)!='.' ORDER BY length(patta_no), patta_no";
        $data['oldPatta'] = $this->db->query($q12, array($dist_code, $subdiv_code, $cir_code,
            $mouza_pargona_code, $vill_townprt_code, $lot_no, $land->patta_type_code))->result();
        
        $newpatta = $this->utilityclass->maxpatta($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $land->patta_type_code);
        $newDag = $this->utilityclass->maxdag($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

        $data['NewDag'] = array('dag' => $newDag);
        $data['NewPatta'] = array('patta' => $newpatta);
        $data['oldDagArea']=$oldland;
        $bigha = $land->m_dag_area_b;
        $katha = $land->m_dag_area_k;
        $lessa = $land->m_dag_area_lc;
        $r = $plmnote->min_revenue;
        ////// BARAK VALLEY CODE START ////////////
        if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
            $ganda = $land->m_dag_area_g;

            $tlessa = $bigha * 6400 + $katha * 320 + $lessa * 20 + $ganda;
            $rev = $tlessa * $r;
            $rev = $rev / 100;
            if ($tlessa < 100) {
                $rev = $plmnote->min_revenue;
            }
            $oldlandarea = $oldland->dag_area_b * 6400 + $oldland->dag_area_k * 320 + $oldland->dag_area_lc * 20 + $oldland->dag_area_g;
        }
        else // other than barak valley
        {
            $tlessa = $bigha * 100 + $katha * 20 + $lessa;
            $rev = $tlessa * $r;
            $rev = $rev / 100;
            if ($tlessa < 100) {
                $rev = $plmnote->min_revenue;
            }
            $oldlandarea = $oldland->dag_area_b * 100 + $oldland->dag_area_k * 20 + $oldland->dag_area_lc;
        }
        ////// BARAK VALLEY CODE END ////////////
        if ($oldlandarea == $tlessa) {
                $data['pbdata']->complete_partition_yn = 'y';
        }else{
            $data['pbdata']->complete_partition_yn = 'n';
        }
        $data['revenue'] = $rev;

        //code for generating village uuid------------
        $village_uuid = $this->utilityclass->getVillageUUID($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);
        //code for generating zonal value--------------
        $data['zonalValueOfDag'] = $this->utilityclass->getZonalValue($dist_code, $village_uuid, $dag->dag_no);


        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
            // property chain data
            $data['ulpin'] = $this->input->get('ulpin', true);
            $data['old_ulpin'] = $this->input->get('old_ulpin', true);
            $data['old_revenue'] = $this->input->get('old_revenue', true);
            $data['old_local_tax'] = $this->input->get('old_local_tax', true);
            $data['chithaPropChainCmpFlag'] = $this->input->get('compareCheckFlag', true);
            $data['ulpinCheck'] = $this->input->get('ulpinCheckFlag', true);
        }


        //ESCALATED CASES REMARK ENTRY FORM==============
        if(ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE == 1 && $data['pb']->es_flag == 1 && $data['pb']->out_of_esc == 0)
        {
            $escRemarkData = $this->Escalationmodel->getEscalationRemarkDetails($case_no,$this->session->userdata('user_desig_code'),$this->session->userdata('user_code'));
            if(isset($escRemarkData) && !empty($escRemarkData))
            {
                $data['escRemarkData'] = $escRemarkData;
            }
        }
        ///END REMARKS/////////

        $data['_view'] = 'partition/finalOrderPassOfcPartitionCO';
        $this->load->view('layouts/main',$data);   
    }

    public function finalOrderOfcPartitionCO_save(){
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
        if($this->session->userdata('user_desig_code')!='CO'){
            echo "<p class='text-danger'>Error. You are not authorized</p>";
            return;
        }

        if($this->input->post('revenue')<=0){
            $this->session->set_flashdata('message', "Please enter revenue amount");
             return redirect($_SERVER['HTTP_REFERER']);
        }

        $this->db->trans_begin();
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill');
        $user_code = $this->session->userdata('user_code');
        $case_no = $this->input->post('appl');
        $this->AgriStackCaseHistory->CreateLogFile($dist_code, $case_no);
        $checkagain = 1;
        $new_dag_no = $this->input->post('newDag');
        $new_patta_no = $this->input->post('newPatta');
        $dag_no = $this->input->post('oldDag');
        
        ///////////////////////////////
        $sql="Select * from petition_basic where case_no=?";
        $petData=$this->db->query($sql,array($case_no));
        if($petData->num_rows()==0){
            $this->session->set_flashdata('message', "Something went wrong.PART- Error Code(#PP2345)");
            redirect(base_url() . "index.php/home");
            return;
        }
        $petition_no = $petData->row()->petition_no;
        ///////////////////////////////
        $q5 = "SELECT pdar_id FROM t_chitha_rmk_infavor_of WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code'"
                . "and vill_townprt_code='$vill_townprt_code' and lot_no='$lot_no' and petition_no='$petition_no' ";

        $q6 = "SELECT * FROM petitioner_part WHERE dist_code=? AND subdiv_code=? AND cir_code=? 
        AND mouza_pargona_code=? AND vill_townprt_code=? AND lot_no=? AND petition_no=? 
        AND pdar_id not IN ($q5)  "; //limit 1
        $applicant = $this->db->query($q6, array($dist_code, $subdiv_code, $cir_code, 
        $mouza_pargona_code, $vill_townprt_code, $lot_no, $petition_no))->result();


        $caseInfoEsc = $this->db->query("SELECT * FROM petition_basic WHERE case_no=?",array($case_no))->row();
        if($caseInfoEsc->es_flag == 1 && ESCALATION_ENABLE == 1)
        {
            $executionDate = date('Y-m-d- H-i-s');
            $user_code = $this->session->userdata('user_code');
            $user_desig_code = $this->session->userdata('user_desig_code');
            $escalationUpdateTimeFrame = $this->Escalationmodel->escalationUpdateTimeFrame($executionDate,$dist_code,$case_no,$user_code,$user_desig_code,'OPART');
            log_message("error", "#ESC7153, transaction-error-STATUS======".json_encode($escalationUpdateTimeFrame));
            if($escalationUpdateTimeFrame['responseType'] == 1)
            {
                log_message("error", "#ESC7156, transaction-error in method 'Partition/finalOrderOfcPartitionCO_save' with case-no :". $case_no);
                $this->session->set_flashdata('message', "Something went wrong.ACPP- Error Code(#ESC7156)");
                redirect(base_url() . "index.php/home");
                return;
            }
            ////////////////////END////////////////////////////
        }

        //==========check dag pending in blockchain or not=================
        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
            $checkVal = $this->PropChainCommonModel->checkDagExistsInPropChainInPending($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$dag_no);
            if($checkVal === false)
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERRORBLOCCHAIN6166 : You cannot procced as dag no is pending for property chain update...");
                redirect(base_url() . "index.php/home");
            }
        }
        ///=============end CODE=====================

        if ($new_dag_no == $dag_no) {
            $newpattadar = null;
        } else {
            $newpattadar = 'N';
        }
        $patta_no = trim($this->input->post('pattaNo'));
        if(empty($patta_no) || $patta_no==null){
            echo "Error. Patta No cann't be empty";
            return;
        }if(empty($new_patta_no) || $new_patta_no==null){
            echo "Error. New Patta No cann't be empty";
            return;
        }
        $patta_type_code = $this->input->post('pattaCode');
        if(empty($patta_type_code) || $patta_type_code==null){
            echo "Error. Patta Type cann't be empty";
            return;
        }
        $infavor_of_id = $this->input->post('infavourOf');
        /*$infavor_of_name = $applicant[0]->pdar_name;
        $infavor_of_guardian = $applicant[0]->pdar_guardian;*/
        $infavor_of_guar_relation = $this->input->post('guar_rel');
        $pdar_cron_no = $this->input->post('pdar_cron_no');
        $infavor_of_add1 = $this->input->post('infavourAdd1');
        $infavor_of_add2 = $this->input->post('infavourAdd2');
        $infavor_of_gender = $this->input->post('inFavourSex');
        $infavor_of_mother = $this->input->post('inFavourMother');
        $by_right_of = '00';
        $land_area_b = $this->input->post('LandB');
        $land_area_k = $this->input->post('LandK');
        $land_area_lc = $this->input->post('LandL');
        $land_area_g =  $this->input->post('LandG'); ////// BARAK VALLEY CODE START ////////////
        $land_area_kr = '0';
        $revenue = $this->input->post('revenue');
        $deed_y_n = $this->input->post('deed_y_n');

        $petition_no = $this->input->post('petitionno');
        

        $name = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $user_code);
        $comment = $this->input->post('notes');
        $comment = $comment . "<p>" . $name->username . "&nbsp&nbsp Dated:" . date('d/m/Y') . "</p>";


        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {

            // get pattadars details for full dag process before update
            $old_dag = $this->input->post('oldDag');
            $old_patta = $this->input->post('pattaNo');
            $pattadar_details = $this->PropChainModel->getPattadars($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $old_patta, $old_dag);

            $land_class_code_query = "select land_class_code from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and patta_no='$old_patta' and dag_no='$old_dag'";

            $land_class_code = $this->db->query($land_class_code_query)->row()->land_class_code;
        }



        //////////////////////////////////
        if(isset($_FILES['fileUpload']['name'])){ 
        $this->form_validation->set_rules('fileText[]', 'Document Details', 'trim|xss_clean|required');
        $fileCount = count($_FILES['fileUpload']['name']);
        // validation for file type and file size
        for($i = 0; $i < $fileCount; $i++)
        {
            if($_FILES['fileUpload']['name'][$i] && $_FILES['fileUpload']['size'][$i] && $_FILES['fileUpload']['tmp_name'][$i]){
                $name = $_FILES['fileUpload']['name'][$i];
                $size = $_FILES['fileUpload']['size'][$i];
                $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                $exp  = explode("/",$mime);
                $ext  = $exp[1];
                    if($name != NULL)
                    {
                        if($ext == NULL)
                        {
                            // todo error show extension missing
                            $this->session->set_flashdata('message', "File Not Supported. Error Code(#FAPL001)");
                            redirect(base_url() . "index.php/home");
                        }
                        if(! in_array($ext, UPLOAD_TYPE_VALIDATION))
                        {
                            // todo error show file allow type not match
                            $this->session->set_flashdata('message', "File Not Supported (ONLY JPG/PNG/PDF). Error Code(#FAPL002)");
                            redirect(base_url() . "index.php/home");
                        }
                        if($size > UPLOAD_MAX_SIZE)
                        {
                            $this->session->set_flashdata('message', "Maximum 2MB file size. Error Code(#FAPL003)");
                            redirect(base_url() . "index.php/home");
                        }
                    }
                    else
                    {
                        $this->session->set_flashdata('message', "File name cann't be empty. Error Code(#FAPL004)");
                        redirect(base_url() . "index.php/home");
                    }
                }
                else{
                    $this->session->set_flashdata('message', "File is required. Error Code(#FAPL005)");
                    redirect(base_url() . "index.php/home");
                }
            }
        }
        ///////////////////Insert attached file////////////////////////
        if(isset($_FILES['fileUpload']['name'])){
            for($i = 0; $i < $fileCount; $i++)
            {
                $_FILES['file']['name'] = $_FILES['fileUpload']['name'][$i];
                $_FILES['file']['type'] = $_FILES['fileUpload']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['fileUpload']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['fileUpload']['error'][$i];
                $_FILES['file']['size'] = $_FILES['fileUpload']['size'][$i];
                $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                $exp  = explode("/",$mime);
                $onlyExtension  = $exp[1];
                $replaceCase=str_replace("/","-",$case_no);
                $fileRename =  $replaceCase."-".time() . '.' . $onlyExtension;
                $config['upload_path']   = MANUAL_ATTACHMENT;
                $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                $config['max_size']  = UPLOAD_MAX_SIZE;;
                $config['file_name'] = $fileRename;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('file'))
                {
                    $document= array(
                        'case_no'   => $case_no,
                        'file_name' => $_POST['fileText'][$i],
                        'user_code' => $this->session->userdata('user_code'),
                        // 'fetch_file_name' => $_FILES['file']['name'],
                        'fetch_file_name' => $_POST['fileText'][$i],
                        'file_type'  => $_FILES['file']['type'],
                        'file_path'  => MANUAL_ATTACHMENT . $fileRename,
                        'date_entry' => date('Y-m-d h:i:s'),
                        'mut_type'   => 'OP',
                    );
                    // save data in attachment file
                    $addMoreDocQuery = $this->db->insert('supportive_document',$document);
                    log_message('error',$this->db->last_query());
                    if($addMoreDocQuery != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRADDDOC0001: Insertion failed in supportive document RTPS Case No '.$case_no);
                        $this->session->set_flashdata('error_data', "#ERRADDDOC0001: Registration of Settlement failed for case no : ".$case_no);
                        redirect(base_url() . "index.php/home");
                        return false;
                    }
                }
                else
                {
                    $this->db->trans_rollback();
                    // todo error show
                    // redirect to respected route with error mgs
                    log_message('error', '#ERRADDDOC0001: Insertion failed in supportive document RTPS Case No '.$case_no);
                    $this->session->set_flashdata('error_data', "#ERRADDDOC0001: Registration of Settlement failed for case no : ".$case_no);
                    redirect(base_url() . "index.php/home");
                    return false;
                }
            }
        }
        //////////////////////////////////////////
        //$land_class_code=$this->input->post('new_land_class');
        if ($deed_y_n == 'Yes') {
            $reg_deal_no = $this->input->post('RegDeedNo');
            $reg_deedValue = $this->input->post('RegDeedValue');
            $reg_date = date('Y-m-d', strtotime($this->input->post('reg_date')));
            $sub_reg_office = $this->input->post('sub_regOffice');
        } else {
            $reg_deal_no = null;
            $reg_deedValue = null;
            $reg_date = null;
            $sub_reg_office = null;
        }

        $pdar_strike = $this->input->post('pdar_strike');
        $date = date('Y-m-d G:i:s');
        $pdar_mobile = $this->input->post('pdar_mobile');
        $pdar_aadhar = $this->input->post('pdar_aadhar');
        $pdar_nrc = $this->input->post('pdar_nrc');
        $pdar_pan = $this->input->post('pdar_pan');
        $pdar_voterID = $this->input->post('pdar_voterID');
        
        if ($infavor_of_guar_relation == 'u') {
            $infavor_of_guar_relation = 'u';
        }

        //insert into t_chitha_rmk_infavor_of
        $intkey = 0;
        foreach($pdar_cron_no as $key=>$val){
            $intkey = (int)$key;
            $insert_into_t_chitha_rmk_infavor_of = [
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'dag_no' => $dag_no,
                'year_no' => date('Y'),
                'petition_no' => $petition_no,
                'patta_type_code' => $patta_type_code,
                'patta_no' => $patta_no,
                'ord_no' => $case_no,
                'ord_date' => $date,
                'pdar_id' => $infavor_of_id[$key],
                'infavor_of_id' => $pdar_cron_no[$key],
                'infavor_of_name' => $applicant[$intkey]->pdar_name,
                'infavor_of_guardian' => $applicant[$intkey]->pdar_guardian,
                'infav_of_guar_relation' => $infavor_of_guar_relation[$key],
                'infavor_of_add1' => $infavor_of_add1[$key],
                'infavor_of_add2' => $infavor_of_add2[$key],
                'by_right_of' => '00',
                'land_area_b' => $land_area_b,
                'land_area_k' => $land_area_k,
                'land_area_lc' => $land_area_lc,
                'land_area_g' => $land_area_g,
                'land_area_kr' => $land_area_kr,
                'revenue' => $revenue,
                'reg_deal_no' => $reg_deal_no,
                'reg_date' => $date,
                'sub_reg_office' => $sub_reg_office,
                'new_dag_no' => $new_dag_no,
                'new_patta_no' => $new_patta_no,
                'make_mdb' => 'Y',
                'new_pattadar' => $newpattadar,
                'pdar_strike' => $pdar_strike,
                'infavor_of_gender' => $infavor_of_gender[$key],
                'infavor_of_mother' => $infavor_of_mother[$key],
                'pdar_pan_no' => $pdar_pan[$key],
                'pdar_citizen_no' => $pdar_voterID[$key],
                'pdar_aadharno' => $pdar_aadhar[$key],
                'pdar_mobile' => $pdar_mobile[$key],
                'pdar_nrcno' => $pdar_nrc[$key],
            ];    
            //var_dump($insert); return;
            $instInfavor=$this->db->insert("t_chitha_rmk_infavor_of", $insert_into_t_chitha_rmk_infavor_of);
            if ($instInfavor != 1 )
            {
                $this->db->trans_rollback();
                log_message("error","#ERROR0001: Insertion failed in t_chitha_rmk_infavor_of 
                    for case no: ". $case_no. " and query is : ". $this->db->last_query());
                $this->session->set_flashdata('message', "#ERROR0001: Final Order submission failed 
                    for Case No: ".$case_no);
                redirect(base_url() . "index.php/home");
            }
        }

        ////// BARAK VALLEY CODE START ////////////

        $bigha_r = 0;
        $katha_r = 0;
        $lessa_r = 0;
        $ganda_r = 0;

        $chithalandbitha = $this->input->post('ChithaLandB');
        $chithalandkatha = $this->input->post('ChithaLandK');
        $chithalandlessa = $this->input->post('ChithaLandL');
        $chithalandganda = $this->input->post('ChithaLandG');

        if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
            
            $mutated = $land_area_b * 6400 + $land_area_k * 320 + $land_area_lc * 20 + $land_area_g;
            $chitha = $chithalandbitha * 6400 + $chithalandkatha * 320 + $chithalandlessa * 20 + $chithalandganda;

            $rem = $chitha - $mutated;

            $bigha_r = floor($rem / 6400.0);
            $katha_r = floor(($rem - $bigha_r * 6400.0) / 320.0);
            $lessa_r = ($rem - $bigha_r * 6400.0 - $katha_r * 320.0)/20.0;
            $ganda_r = $rem - $bigha_r * 6400.0 - $katha_r * 320.0 - $lessa_r * 20.0;
        }
        else  // other than BARAK Valley
        {
            $mutated = $land_area_b * 100 + $land_area_k * 20 + $land_area_lc;
            $chitha = $chithalandbitha * 100 + $chithalandkatha * 20 + $chithalandlessa;

            $rem = $chitha - $mutated;

            $bigha_r = floor($rem / 100.0);
            $katha_r = floor(($rem - $bigha_r * 100.0) / 20.0);
            $lessa_r = $rem - $bigha_r * 100.0 - $katha_r * 20.0;
            $ganda_r = 0;
        }
        ////// BARAK VALLEY CODE END ////////////

        ///////ESCALATION CODE ///////
        $query1 = $this->db->query("SELECT es_flag FROM petition_basic WHERE petition_no=?",array($petition_no))->row();
        if(ESCALATION_ENABLE == 1 && $query1->es_flag == 1)
        {

            $sk_code = null;
            $sk_sign_yn = null;
            $sk_sign_date = null;
        }
        else
        {
            $sk_code = $this->input->post('skName');
            $sk_sign_yn = $this->input->post('skSign');
            $sk_sign_date = $this->input->post('skSignDate');
        }
        //insert into t_chitha_rmk_ordbasic
        $insert_into_t_chitha_rmk_ordbasic = [
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'dag_no' => $dag_no,
            'year_no' => date('Y'),
            'petition_no' => $petition_no,
            'ord_no' => $case_no,
            'ord_date' => $date,
            'ord_type_code' => '04',
            'case_no' => $case_no,
            'ord_on_gl_type' => 'U',
            'ord_passby_sign_yn' => 'Y',
            'ord_passby_desig' => 'CO',
            'ord_ref_let_no' => $this->input->post('refLtrNo'),
            'lm_code' => $this->input->post('lmName'),
            'lm_sign_yn' => $this->input->post('lmSign'),
            'lm_sign_date' =>$this->input->post('lmSignDate'),
            'sk_code' => $sk_code,
            'sk_sign_yn' => $sk_sign_yn,
            'sk_sign_date' => $sk_sign_date,
            'co_code' => $this->input->post('coName'),
            'co_sign_yn' => $this->input->post('COSign'),
            'co_ord_date' => date('Y-m-d',strtotime($this->input->post('coSignDate'))),
            'm_dag_area_b' => $land_area_b,
            'm_dag_area_k' => $land_area_k,
            'm_dag_area_lc' => $land_area_lc,
            'm_dag_area_g' => $land_area_g,
            'm_dag_area_kr' => '0',
            'area_left_b' => '0',
            'area_left_k' => '0',
            'area_left_lc' => '0',
            'area_left_g' => '0',
            'area_left_kr' => '0',
            'make_mdb' => 'Y',
            'new_dag_no' => $new_dag_no,
            'min_revenue' => $revenue,
            'map_partition' => 'P',
        ];
        $instOrdbasic=$this->db->insert("t_chitha_rmk_ordbasic", $insert_into_t_chitha_rmk_ordbasic);
        if ($instOrdbasic != 1 )
        {
            $this->db->trans_rollback();
            log_message("error","#ERROR0002: Insertion failed in t_chitha_rmk_ordbasic 
                for case no: ". $case_no. " and query is : ". $this->db->last_query());
            $this->session->set_flashdata('message', "#ERROR0002: Final Order submission failed 
                for Case No: ".$case_no);
            redirect(base_url() . "index.php/home");
        }

        //insert into petition proceeding
        $proceeding_id = $this->db->query("SELECT MAX(proceeding_id) AS id FROM 
            petition_proceeding WHERE case_no=? AND dist_code=? AND subdiv_code=? 
            AND cir_code=?", array($case_no, $dist_code, $subdiv_code, $cir_code))->row()->id;

        if($proceeding_id == null || $proceeding_id == ''){ $proceeding_id = 1; }
        else { $proceeding_id = $proceeding_id + 1; }

        $insert_into_petition_proceeding = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => date('Y-m-d G:i:s'),
            'co_order' => $comment,
            'next_date_of_hearing' => date('Y-m-d G:i:s'),
            'status' => 'Final',
            'user_code' => $user_code,
            'date_entry' => date('Y-m-d G:i:s'),
            'operation' => 'E',
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'ip' => $this->utilityclass->get_client_ip()
        ];
        $insProceeding=$this->db->insert("petition_proceeding", $insert_into_petition_proceeding);
        if ($insProceeding != 1 )
        {
            $this->db->trans_rollback();
            log_message("error","#ERROR0003: Insertion failed in petition_proceeding for 
                case no: ". $case_no. " and query is : ". $this->db->last_query());
            $this->session->set_flashdata('message', "#ERROR0003: Final Order submission failed 
                for Case No: ".$case_no);
            redirect(base_url() . "index.php/home");
        }

        //update petition basic
        $update_petition_basic = [
            'status' => 'F', 
            'order_passed' => 'Y', 
            'date_of_order' => date('Y-m-d G:i:s'), 
            'deed_no' => $reg_deal_no, 
            'deed_value' => $reg_deedValue, 
            'deed_date' => $reg_date, 
            'sub_reg_office' => $sub_reg_office,
        ];
        $this->db->where([
            'case_no' => $case_no, 
            'petition_no' => $petition_no, 
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
        ]);
        $this->db->update("petition_basic", $update_petition_basic);
        if ($this->db->affected_rows() != 1 )
        {
            $this->db->trans_rollback();
            log_message("error","#ERROR0004: Updation failed in petition_basic for 
                case no: ". $case_no. " and query is : ". $this->db->last_query());
            $this->session->set_flashdata('message', "#ERROR0004: Final Order submission failed 
                for Case No: ".$case_no);
            redirect(base_url() . "index.php/home");
        }


        //ESCALATION ==============
        $es_flag_data = $this->db->query("select es_flag,out_of_esc from  petition_basic where case_no=?",array($case_no))->row();
        if(ESCALATION_ENABLE == 1 && $es_flag_data->es_flag == 1 && ESCALATION_REMARK_ENABLE ==1 && $es_flag_data->out_of_esc == 0)
        {

            $responseEsc = $this->Escalationmodel->escalationRemarkCheckandUpdate($case_no,$this->input->post('esc_remark'),$this->session->userdata('user_desig_code'));
            if($responseEsc['responseType'] == 1)
            {
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"#ERROR00111 : Error in submitting in escalation remarks. Please try Again"
                );
                echo json_encode($data);
                return false;
            }

        }
        ///END+==================
        
        //redirect(base_url() . 'index.php/partition/COInFavOfDtls');
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo "Error during processing";
        } else {
            $this->updateChithaPartition($case_no);


            //ESCALATION CODE INTEGRATION================SANMRI

            $query1 = $this->db->query("SELECT es_flag,out_of_esc FROM petition_basic WHERE petition_no=?",array($petition_no))->row();
            $user_code = $this->session->userdata('user_code');
            if($query1->es_flag == 1 && ESCALATION_ENABLE ==1 && $query1->out_of_esc == 0){

                $executionDate = $this->input->post('executionDate');
                $escalationUpdateStatus = $this->Escalationmodel->escalationFinalOrderCOOPART($executionDate,$dist_code,$subdiv_code,$cir_code,$case_no,$user_code);
                log_message("error", "#ESC7381, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

                if($escalationUpdateStatus['responseType'] == 0){
                    $this->db->trans_rollback();
                    log_message("error", "#ESC7381, transaction-error in method 'Partition/FinalOrder' with case-no :". $case_no);
                    $this->session->set_flashdata('message', "Something went wrong.OPART- Error Code(#ESC7381)");
                    redirect(base_url() . "index.php/home");
                }
            }
                
                ///////////////END ESCALATION//////////////
            $chain_result_2 = new \stdClass;
            $chain_result_2->success = 1;

            if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
            {

                $pattadar_details = $this->PropChainModel->getPattadars($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $new_patta_no, $this->input->post('old_dag'));

                if($dag_no !=null && ($new_dag_no != $dag_no))
                {
                    $checkValidate = $this->PropChainCommonModel->checkValidateMapDagForOrderPass($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$new_dag_no,$dag_no);
                    // $checkValidate = true;
                    if($checkValidate != 0)
                    {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "ERROR6566 : Update map is pending for dag no ($new_dag_no,$dag_no) == ".$case_no);
                        redirect(base_url() . "index.php/home");
                    }
                }


                $ulpinCheckFlag   = $this->input->post('ulpinCheckFlag', true);
                $compareCheckFlag = $this->input->post('compareCheckFlag', true);
                
                if($compareCheckFlag == 'Y' && $ulpinCheckFlag == 1)
                {

                    $type = LOC_TYPE_RURAL;
                    $new_dag = $this->input->post('newDag', true);
                    $new_patta = $this->input->post('newPatta', true);
                    $location_id = $dist_code . $subdiv_code . $cir_code . $mouza_pargona_code . $lot_no . $vill_townprt_code;
                    $revenue = $this->input->post('revenue', true);
                    $local_tax = strval($revenue / 4);
                    $ulpin = $this->input->post('ulpin', true);
                    $old_ulpin = $this->input->post('old_ulpin', true);
                    $old_revenue = $this->input->post('old_revenue', true);
                    $old_local_tax = $this->input->post('old_local_tax', true);

                    $patta_type_code = $this->input->post('pattaCode');
                    $reference_id = $case_no;
                    $certmnemonic = CERTMNEMONIC_PRT;
                    $property_signature = "base64 encoded signature";
                    $property_signer_key = "base64 encoded public key";
                    $office_code = $this->session->userdata('cir_code');
                    $user_code = $this->session->userdata('user_code');

                    // partition land details;
                    $prt_bigha = $land_area_b;
                    $prt_katha = $land_area_k;
                    $prt_lessa = $land_area_lc;
                    $prt_ganda = $land_area_g;
                    // $prt_ganda = $this->input->post('landG');

                    $dag_query = "select dag_area_b, dag_area_k, dag_area_lc, dag_area_g, dag_area_kr from  petition_dag_details where case_no='$case_no' ";

                    //total land area
                    $dag_details = $this->db->query($dag_query)->row();
                    $bigha_chain = $dag_details->dag_area_b;
                    $katha_chain = $dag_details->dag_area_k;
                    $lessa_chain = $dag_details->dag_area_lc;
                    $ganda_chain = $dag_details->dag_area_g;

                    $land_class_code_query = "select land_class_code from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and patta_no='$old_patta' and dag_no='$old_dag'";

                    $land_class_code = $this->db->query($land_class_code_query)->row()->land_class_code;


                    if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY)))
                    {
                        $source_lessa = $bigha_chain * 6400 + $katha_chain * 320 + $lessa_chain * 20 + $ganda_chain;
                        $partition_lessa = $prt_bigha * 6400 + $prt_katha * 320 + $prt_lessa * 20 + $prt_ganda;

                        $remaining_lessa = $source_lessa - $partition_lessa;

                        $remaining_b = floor($remaining_lessa / 6400);
                        $remaining_k = floor(($remaining_lessa - $remaining_b * 6400) / 320);
                        $remaining_lc = floor(($remaining_lessa - $remaining_b * 6400 - $remaining_k * 320)/20 );
                        $remaining_g = $remaining_lessa - $remaining_b * 6400 - $remaining_k * 320 - $remaining_lc * 20;
                        $remaining_kr = 0;

                    }
                    else
                    {

                        $source_lessa = $bigha_chain * 100 + $katha_chain * 20 + $lessa_chain;

                        $partition_lessa = $prt_bigha * 100 + $prt_katha * 20 + $prt_lessa;

                        $remaining_lessa = $source_lessa - $partition_lessa;

                        $remaining_b = floor($remaining_lessa / 100);
                        $remaining_k = floor(($remaining_lessa - $remaining_b * 100) / 20);
                        $remaining_lc = $remaining_lessa - $remaining_b * 100 - $remaining_k * 20;
                        $remaining_g = 0;
                        $remaining_kr = 0;
                    }


                    $chain_result_2 = new \stdClass;

                    $new_patta_type_code = $old_land_class_code = '';
                    if ($new_dag == $old_dag) {
                        // Full dag

                        // TODO: when the format of the property id changes the follwing attributes will be $bigha_chain_new= $katha_chain_new= $lessa_chain_new= $ganda_chain_new = ''

                        // $land_class_code_query = "select land_class_code from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and patta_no='$new_patta_chain' and dag_no='$old_dag'";

                        // $land_class_code = $this->db->query($land_class_code_query)->row()->land_class_code;

                        // TODO: when the format of the property id changes the follwing attributes will be 
                        $bigha_chain_new = $katha_chain_new = $lessa_chain_new = $ganda_chain_new = '';
                        $new_dag_no = '';

                        $chain_data_params = array(
                            'pattadar_details' => $pattadar_details,
                            'dist_code' => $dist_code,
                            'subdiv_code' => $subdiv_code,
                            'cir_code' => $cir_code,
                            'mouza_pargona_code' => $mouza_pargona_code,
                            'lot_no' => $lot_no,
                            'vill_townprt_code' => $vill_townprt_code,
                            'reference_id' => $reference_id,
                            'old_dag' => $old_dag,
                            'old_patta' => $old_patta,
                            'patta_type_code' => $patta_type_code,
                            'land_class_code' => $land_class_code,
                            'remaining_b' => $bigha_chain,
                            'remaining_k' => $katha_chain,
                            'remaining_lc' => $lessa_chain,
                            'remaining_g' => $ganda_chain,
                            'certmnemonic' => $certmnemonic,
                            'property_signature' => $property_signature,
                            'property_signer_key' => $property_signer_key,
                            'office_code' => $office_code,
                            'user_code' => $user_code,
                            'ulpin' => $ulpin,
                            'old_ulpin' => $old_ulpin,
                            'dag_revenue' => $revenue,
                            'dag_local_tax' => $local_tax,
                            'new_patta_no' => $new_patta,
                            'old_dag_revenue' => $old_revenue,
                            'old_dag_local_tax' => $old_local_tax,
                            'old_land_class_code' => $old_land_class_code,
                            'new_bigha' => $prt_bigha,
                            'new_katha' => $prt_katha,
                            'new_lessa' => $prt_lessa,
                            'new_ganda' => $prt_ganda,
                            'new_patta_type_code' => $new_patta_type_code
                        );

                        $fullDagProcess = $this->PropChainModel->chainFullDagProcess((object)$chain_data_params);
                        // var_dump($fullDagProcess);
                        // die;
                        $chain_result_2 = $fullDagProcess;
                    } else {
                        // partial dag
                        $partial_chain_data = array(
                            'dist_code' => $dist_code,
                            'subdiv_code' => $subdiv_code,
                            'cir_code' => $cir_code,
                            'mouza_pargona_code' => $mouza_pargona_code,
                            'lot_no' => $lot_no,
                            'vill_townprt_code' => $vill_townprt_code,
                            'old_patta' => $old_patta,
                            'old_dag' => $old_dag,
                            'patta_type_code' => $patta_type_code,
                            'reference_id' => $reference_id,
                            'land_class_code' => $land_class_code,
                            'remaining_b' => $remaining_b,
                            'remaining_k' => $remaining_k,
                            'remaining_lc' => $remaining_lc,
                            'remaining_g' => $remaining_g,
                            'certmnemonic' => $certmnemonic,
                            'property_signature' => $property_signature,
                            'property_signer_key' => $property_signer_key,
                            'office_code' => $office_code,
                            'user_code' => $user_code,
                            'ulpin' => $ulpin,
                            'old_ulpin' => $old_ulpin,
                            'dag_revenue' => $revenue,
                            'dag_local_tax' => $local_tax,
                            'new_patta_no' => $new_patta,
                            'new_dag_no' => $new_dag,
                            'old_dag_revenue' => $old_revenue,
                            'old_dag_local_tax' => $old_local_tax,
                            'old_land_class_code' => $old_land_class_code,
                            'bigha_new' => $prt_bigha,
                            'katha_new' => $prt_katha,
                            'lessa_new' => $prt_lessa,
                            'ganda_new' => $prt_ganda,
                            'new_patta_type_code' => $new_patta_type_code
                        );


                        $update_chain_api = $this->PropChainModel->chainPartialDagProcessN((object)$partial_chain_data);


                        $chain_result_2 = $update_chain_api;
                    }

                }

                
            }

           



            if($chain_result_2->success == 1)
            {

                $this->db->trans_commit();
                $this->AgriStackCaseHistory->CreateLog($dist_code,$case_no);
                $this->DashboardDataFinal($case_no);
                //code for updating zonal informtion of dag------------17032023--

                //code for generating village uuid------------
                $village_uuid = $this->utilityclass->getVillageUUID($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

                //zonal row fetch row for insertion same row for new dag----------
                $ZonalStatus = $this->utilityclass->getZonalRowFetchAndInsert($dist_code, $village_uuid, $dag_no,$new_dag_no);
                if($ZonalStatus=='N'){
                    log_message('error','#RES001 : Zonal value of new dag could not been updated. OLD Dag :'.$dag_no. " and New dag : ".$new_dag_no. " CASE NO : ".$case_no);
                }elseif($ZonalStatus == 'Y'){
                    log_message('error','#RES002 : Zonal value of new dag updated successfully. OLD Dag :'.$dag_no. " and New dag : ".$new_dag_no. " CASE NO : ".$case_no);
                }
                //end-----------17032023


                $sql = "Select * from petition_basic where case_no='$case_no'";
                $data['pbdata'] = $this->db->query($sql)->row();
                if($data['pbdata']->application_ref_no){
                    $msg='Partition Order Passed Successfully '. $case_no . " New Dag No." . $new_dag_no ." New Patta No. " . $new_patta_no;
                    $this->SendRtpsFStatus($case_no,$msg);
                }
                $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
                if($basundharaExist && !empty($data['pbdata']) ){
                    $rmk='Final Order Passed';
                    $status='F';
                    $task='CO';
                    $pen='NA';
                    $case=$case_no;
                    $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
                }

                $this->load->model('jamabandi/jamabandiAutoUpdateModel');

                /////////////////For Old Patta
                if($new_dag_no!=$dag_no){
                    
                    $jamaUpdate = $this->jamabandiAutoUpdateModel->updateJamabandi($patta_no, 
                    $patta_type_code, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, 
                    $lot_no, $vill_townprt_code, $case_no);
                }
                
                /////////////////For New Patta
                // $jamaUpdate = $this->jamabandiAutoUpdateModel->updateJamabandi($new_patta_no, 
                //     $patta_type_code, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, 
                //     $lot_no, $vill_townprt_code, $case_no);
                $location = array(
                        'd'=> $dist_code,
                        's' => $subdiv_code,
                        'c' => $cir_code,
                        'm' => $mouza_pargona_code,
                        'l' => $lot_no,
                        'v' => $vill_townprt_code,
                );
                $this->session->set_userdata(array('loc' => $location));
                // $this->DashboardDataFinal($case_no);
                $this->session->set_flashdata('message', "Final Order Completed 
                    for Case No: ".$case_no ."  Please check Chitha & Jamabandi Copy");
                //redirect(base_url() . "index.php/home");
                
                if(ENABLED_BLOCKCHAIN == 1 && in_array($dist_code,json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                {
                    if($ulpinCheckFlag == 1 && $compareCheckFlag == 'Y')
                    {
                        redirect(base_url() . "index.php/JamaBandi/step3/" . $new_patta_no . "/" . $patta_type_code . '/' . urlencode(base64_encode($case_no)));
                    }
                    
                }
            
                redirect(base_url() . "index.php/JamaBandi/step3/".$new_patta_no."/".$patta_type_code);

            }elseif ($chain_result_2->success == 0 || $chain_result_2->success == 2 && ENABLED_BLOCKCHAIN ==1) {
                $this->db->trans_rollback();
                log_message('error','#ERRORPROPCHAIN6795 : Error occured. Order not passed for Case No $case_no Not Successfull');
                $this->session->set_flashdata('message', $chain_result_2->message . ": " . $chain_result_2->error_msg . ". Property Chain updation for Case No $case_no Not Successfull. Error Code(" . $chain_result_2->error_code . ")");
                redirect(base_url() . "index.php/home");
            } else {
                log_message('error','#ERRORPROPCHAIN6798 : Error occured. Order not passed for Case No $case_no Not Successfull');
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERRORPROPCHAIN6798 : Error occured. Order not passed for Case No $case_no Not Successfull.");
            }
        }
        
    }
    function jamaCheckToDeleteorNot($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number, $patta_number,$patta_type){

        $q33 = "select count(*) as c from jama_dag where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=?";
        $q33_result = $this->db->query($q33, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number));
        
        if ($q33_result->row()->c <= 0)
            return;
       
        $this->db->delete('jama_dag',
            array('dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $circle_code,
                'mouza_pargona_code' => $mouza_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_code,
                'dag_no' => $dag_number));
        if($this->db->affected_rows() != $q33_result->row()->c)
        {
            $this->db->trans_rollback();
            log_message("error", "#OPDELJAMA001 Delete failed, Unable to delete data from jama_dag
                         for dist_code:" . $dist_code . ", dag no: " . $dag_number);
            $this->session->set_flashdata('message', "Unable to Pass the Order. Error Code (#OPDELJAMA001)");
            redirect(base_url() . "index.php/home");
        }

        //////////check multiple dag////////
        $q34 = "select count(*) as c from jama_dag where 
        dist_code=? and subdiv_code=? and cir_code=? and 
        mouza_pargona_code=? and lot_no=? and vill_townprt_code=? 
        and dag_no !=? and patta_no=? and patta_type_code=?";
        $q34_result = $this->db->query($q34, array($dist_code, $subdiv_code,
        $circle_code, $mouza_code, $lot_no, $vill_code, $dag_number, $patta_number,$patta_type));
        
        if ($q34_result->row()->c > 0) 
            return;

        ///////Delete jama_patta///////////
        $q35 = "select count(*) as c from jama_patta where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? 
            and patta_no=? and patta_type_code=?";
        $q35_result = $this->db->query($q35, array($dist_code, $subdiv_code,
                    $circle_code, $mouza_code, $lot_no, $vill_code,
                    $patta_number,$patta_type));
        if ($q35_result->row()->c > 0) {
            $this->db->delete('jama_patta',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'patta_no' => $patta_number,
                    'patta_type_code' => $patta_type));
            if ($this->db->affected_rows() != $q35_result->row()->c) {
                $this->db->trans_rollback();
                log_message("error", "#OPDELJAMA002 Delete failed, Unable to delete data from jama_patta
                     for dist_code:" . $dist_code . ", patta_no: " . $patta_no);
                $this->session->set_flashdata('message', "Unable to Pass the Order. Error Code (#OPDELJAMA002)");
                redirect(base_url() . "index.php/home");
            }
        }
        ///////Delete jama_pattadar///////////
        $q36 = "select count(*) as c from jama_pattadar where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? 
            and patta_no=? and patta_type_code=?";
        $q36_result = $this->db->query($q36, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $patta_number,$patta_type));
        if ($q36_result->row()->c > 0) {
            $this->db->delete('jama_pattadar',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'patta_no' => $patta_number,
                    'patta_type_code' => $patta_type));
            if ($this->db->affected_rows() != $q36_result->row()->c) {
                $this->db->trans_rollback();
                log_message("error", "#OPDELJAMA003 Delete failed, Unable to delete data from jama_pattadar
                     for dist_code:" . $dist_code . ", patta_no: " . $patta_no);
                $this->session->set_flashdata('message', "Unable to Pass the Order. Error Code (#OPDELJAMA003)");
                redirect(base_url() . "index.php/home");
            }
        }
        ///////Delete jama_remark///////////
        $q37 = "select count(*) as c from jama_remark where 
            dist_code=? and subdiv_code=? and cir_code=? and 
            mouza_pargona_code=? and lot_no=? and vill_townprt_code=? 
            and patta_no=? and patta_type_code=?";
        $q37_result = $this->db->query($q37, array($dist_code, $subdiv_code,
            $circle_code, $mouza_code, $lot_no, $vill_code, $patta_number,$patta_type));
        if ($q37_result->row()->c > 0) {
            $this->db->delete('jama_remark',
                array('dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'patta_no' => $patta_number,
                    'patta_type_code' => $patta_type));
            if ($this->db->affected_rows() != $q37_result->row()->c) {
                $this->db->trans_rollback();
                log_message("error", "#OPDELJAMA004 Delete failed, Unable to delete data from jama_remark
                     for dist_code:" . $dist_code . ", patta_no: " . $patta_no);
                $this->session->set_flashdata('message', "Unable to Pass the Order. Error Code (#OPDELJAMA004)");
                redirect(base_url() . "index.php/home");
            }
        }           
    }
    //////////////////
    function saveArea(){
        $mutatedLandValidation = [
            [
                'field' => 'edit_kranti',
                'label' => 'Kranti',
                'rules' => 'trim|required|numeric|xss_clean',
            ],
            [
                'field' => 'edit_bigha',
                'label' => 'Bigha',
                'rules' => 'trim|required|integer|xss_clean',
            ],
            [
                'field' => 'edit_katha',
                'label' => 'Katha ',
                'rules' => 'trim|required|integer|xss_clean',
            ],
            [
                'field' => 'edit_lessa',
                'label' => 'Lessa',
                'rules' => 'trim|required|numeric|xss_clean',
            ],
            [
                'field' => 'edit_gonda',
                'label' => 'Ganda',
                'rules' => 'trim|required|xss_clean',
            ],
        ];
        $validation= null;
        $this->form_validation->set_rules($mutatedLandValidation);
        $this->form_validation->set_message('integer', 'This %s is not valid');
        echo $tot_lc = ($this->input->post('total_bigha') * 5 * 20) + ($this->input->post('total_katha') * 20) + $this->input->post('total_lessa');
        echo $total = ($this->input->post('edit_bigha')* 5 * 20) + ($this->input->post('edit_katha')* 20) + $this->input->post('edit_lessa');
        if (($this->input->post('edit_katha') > 5) || ($this->input->post('edit_lessa') > 20)) {
            $this->session->set_flashdata('message', 'You did not enter the partition land area correctly !!');
            redirect(base_url() . 'index.php/home');
        }
        if (($tot_lc == 0) or ( $total > $tot_lc)) {
            // $this->session->set_flashdata('message', 'You did not enter the partition land area correctly !!');
            $this->session->set_flashdata('message', 'You did not enter the partition land area correctly !!');
            redirect(base_url() . 'index.php/home');
            // exit();
        }
        if ($this->form_validation->run('mutatedLandValidation') == FALSE)
        {
            // $this->form_validation->set_error_delimiters('', '');
            // foreach($mutatedLandValidation as $rule){
            // if (form_error($rule['field'])) {
            //     $validation['error'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
            //     }
            // } 
            $this->session->set_flashdata('message', "Error in Area Submit");
            redirect(base_url() . "index.php/home");            
        }
        $update = [
            'm_dag_area_b' => $this->input->post('edit_bigha'),
            'm_dag_area_k' => $this->input->post('edit_katha'),
            'm_dag_area_lc' => $this->input->post('edit_lessa'),
            'm_dag_area_g' => $this->input->post('edit_gonda'),
            'm_dag_area_kr' => $this->input->post('edit_kranti')
        ];
        $this->db->where(['petition_no'=>$this->input->post('petitionno'), 'dist_code'=>$this->input->post('dist_code'), 'subdiv_code'=>$this->input->post('subdiv_code'), 'cir_code'=>$this->input->post('cir_code'), 'mouza_pargona_code'=>$this->input->post('mouza_code'), 'lot_no'=>$this->input->post('lot_no'),'vill_townprt_code'=>$this->input->post('vill'), 'dag_no'=>$this->input->post('dag_no')]);
        $this->db->update('petition_dag_details', $update);
        redirect(base_url() . "index.php/partition/finalOrderOfcPartitionCO");
    }
    ////////////////////For field Partition//////////////////////////
    //////// field partition /////////////
    public function finalOrderFieldPartitionCO()
    {
      // var_dump($_POST); die;

        $_GET['case_no'] = dec_param($this->input->get('case_no'), 'case_no');
        if($_GET['case_no'] == null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }

        $data = array();
        if($this->session->userdata('user_desig_code')!='CO'){
            echo "<p class='text-danger'>Error. You are not authorized</p>";
            return;
        }
        $attchedCo=$this->basundharamodel->attachedCO();
        if($attchedCo=='A'){
            echo json_encode('Sorry !! You are not Authorized to pass the order as Attached CO !!');
            return;
        }
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $case_no = $this->input->get('case_no');
        $user_code = $this->session->userdata('user_code');

        $dag_details = $this->db->query("SELECT * FROM field_mut_dag_details d
            JOIN patta_code P ON d.patta_type_code=p.type_code
            WHERE d.case_no=? AND dist_code=? AND subdiv_code=? AND cir_code=? AND 
            mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=?", 
            array($case_no, $dist_code, $subdiv_code, $cir_code, 
                $mouza_pargona_code, $lot_no, $vill_townprt_code));
        $data['dag_details'] = $data['dagapply'] = $dagapply = $dag_details->row();
        $patta_type_code = $dagapply->patta_type_code;

        //basic Details
        $q_mut_basic = $this->db->query("SELECT * FROM field_mut_basic mb 
            JOIN lm_code lm ON mb.user_code=lm.lm_code AND 
            mb.dist_code = lm.dist_code AND mb.subdiv_code = lm.subdiv_code 
            AND mb.cir_code = lm.cir_code AND mb.mouza_pargona_code = lm.mouza_pargona_code
            AND mb.lot_no = lm.lot_no WHERE case_no=? AND mb.dist_code=? 
            AND mb.subdiv_code=? AND mb.cir_code=? AND mb.mouza_pargona_code=? 
            AND mb.lot_no=? AND mb.vill_townprt_code=?", 
            array($case_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code,
            $lot_no, $vill_townprt_code));
        $data['details'] = $basic_details = $q_mut_basic->row();
        $query = $this->db->query("SELECT remark, date(date_entry) AS date_entry FROM 
            (SELECT remark, date_entry FROM field_mut_dag_details WHERE 
            case_no=? UNION SELECT co_order AS remark, date_entry FROM petition_proceeding  
            WHERE case_no=? AND user_code LIKE 'M%' ) AS t ORDER BY date_entry DESC LIMIT 1", 
            array($case_no, $case_no));
        $data['remark'] = $query->row();

        //////////////////////////
        $data['revenue'] = $basic_details->min_revenue;
        $data['local_tax'] = $basic_details->min_revenue/4;
                    
        $data['patta_type'] = $this->db->query("SELECT patta_type AS patta_type FROM 
            patta_code WHERE type_code=?",$dagapply->patta_type_code)->row()->patta_type;


        if($basic_details->lm_note==null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }

        if(($basic_details->dist_code!=$dist_code) || ($basic_details->subdiv_code!=$subdiv_code) ||($basic_details->cir_code!=$cir_code) ||($basic_details->mouza_pargona_code!=$mouza_pargona_code) || ($basic_details->vill_townprt_code!=$vill_townprt_code))
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }

        //field part petitioner
        $data['petitioner'] = $this->db->query("SELECT * FROM field_part_petitioner 
            WHERE case_no=? AND dist_code=? AND subdiv_code=? AND cir_code=? AND
            mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=?", 
            array($case_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, 
                $lot_no, $vill_townprt_code))->result();

        //chitha_basic
        $dag_nos = $this->db->query("SELECT dag_no FROM chitha_basic WHERE dist_code=? 
            AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? 
            AND vill_townprt_code=? ORDER BY dag_no_int DESC", 
            array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, 
                $lot_no, $vill_townprt_code))->row();

        $patta_nos = $this->db->query("SELECT patta_no FROM chitha_basic WHERE 
            dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? 
            AND lot_no=? AND vill_townprt_code=? AND patta_type_code=? AND 
            (patta_type_code IN (SELECT type_code FROM patta_code WHERE mutation=?))", 
            array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, 
                $lot_no, $vill_townprt_code, $dagapply->patta_type_code, 'a'))->result();

        $patta_all = $this->db->query("SELECT DISTINCT(patta_no) AS patta_no FROM 
            chitha_basic WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND 
            mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND 
            TRIM(patta_no)!='' AND TRIM(patta_no)!='.' AND 
            (patta_type_code IN (SELECT type_code FROM patta_code WHERE mutation=?)) 
            AND patta_type_code=? ORDER BY patta_no", 
            array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, 
                $vill_townprt_code, 'a', $patta_type_code))->result();

        $dag_nos_all = $this->db->query("SELECT dag_no FROM chitha_basic WHERE 
            dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? 
            AND lot_no=? AND vill_townprt_code=? ORDER BY dag_no_int", 
            array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, 
                $vill_townprt_code))->result();

        $pattas = array();

        foreach ($patta_nos as $p) {
            $pattas[] = (int) (trim($p->patta_no));
        }

        $new_dag = $dag_nos->dag_no + 1;
        $new_patta = max($pattas) + 1;

        $t_max_dp = $this->db->query("SELECT max(new_dag_no) as t_max_dag, 
            max(new_patta_no) AS t_max_patta FROM t_chitha_col8_occup WHERE 
            dist_code=? AND subdiv_code=? AND cir_code=?
            AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? 
            AND new_dag_no!='' AND trim(new_patta_no)!='' ", 
            array($dist_code, $subdiv_code, $cir_code, 
                $mouza_pargona_code, $lot_no, $vill_townprt_code))->row();

        //var_dump($t_max_dp);
        $t_max_dag = $t_max_dp->t_max_dag;
        $t_max_patta = $t_max_dp->t_max_patta;
        if ($new_dag <= $t_max_dag) {
            $new_dag = $new_dag + 1;
        }
        if ($new_patta <= $t_max_patta) {
            $new_patta = $new_patta + 1;
        }
        $data['new_dag'] = $new_dag;
        $data['new_patta'] = $new_patta;
        $data['dags_all'] = $dag_nos_all;
        $data['patta_all'] = $patta_all;

        $data['check'] = $this->db->query("SELECT COUNT(*) FROM chitha_pattadar p 
            JOIN chitha_dag_pattadar d ON p.dist_code = d.dist_code AND p.subdiv_code=d.subdiv_code 
            AND p.cir_code=d.cir_code AND p.lot_no=d.lot_no AND 
            p.vill_townprt_code=d.vill_townprt_code AND p.mouza_pargona_code=d.mouza_pargona_code 
            AND p.pdar_id=d.pdar_id WHERE p.dist_code=? AND p.subdiv_code=? AND p.cir_code=? 
            AND p.mouza_pargona_code=? AND p.vill_townprt_code=? AND 
            d.lot_no=? AND d.dag_no=? AND TRIM(p.patta_no)=trim(?) AND p.patta_type_code=? 
            AND (d.p_flag=? or d.p_flag is null) AND p.pdar_id NOT IN (SELECT pdar_id FROM field_part_petitioner 
            WHERE case_no=?)", array($dist_code, $subdiv_code, 
            $cir_code, $mouza_pargona_code, $vill_townprt_code, $lot_no, 
            $dagapply->dag_no, $dagapply->patta_no, $patta_type_code, '0', $case_no))->result();

        $data['areaFromChitha'] =$areaFromChitha = $this->db->query("SELECT 
            dag_area_b, dag_area_k, dag_area_lc, dag_area_g,dag_area_kr FROM chitha_basic 
            WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? 
            AND lot_no=? AND vill_townprt_code=? AND dag_no=?", 
            array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, 
                $vill_townprt_code, $dagapply->dag_no))->row();
        //var_dump($data['areaFromChitha']);
        //////////////////////////////////////
        // for checking if its full dag partition.
       $applied_lessa=$this->utilityclass->Total_Lessa($dagapply->m_dag_area_b,$dagapply->m_dag_area_k,$dagapply->m_dag_area_lc);
       $original_lessa=$this->utilityclass->Total_Lessa($areaFromChitha->dag_area_b,$areaFromChitha->dag_area_k,$areaFromChitha->dag_area_lc);
        if($applied_lessa == $original_lessa)
        {
            $data['land_area_check']='0';
        }
        else
        {
            $data['land_area_check']='1';
        }  
        //var_dump($data['land_area_check']);
        $data['check_count'] = $data['check'][0]->count;
        //$data['check_count'] = $data['land_area_check'];

        // if (($data['check'][0]->count == '0') && ($data['land_area_check'] != '0')) {
        //     $this->session->set_flashdata('message', "For all selected pattadar, dag with partial area partition is not allowed");
        //     redirect(base_url() . "index.php/home");
        //     return;
        // }   

        $data['basuCase']=null;
        $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
        if($basundharaExist){
            $data['query']=null;
            $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
            $data['sup_doc']=$this->db->query("SELECT * FROM supportive_document WHERE case_no=?", array($case_no))->result();
            $data['query']=$this->basundharamodel->QueryPost($basundharaExist);
        }

        //code for generating village uuid------------
        $village_uuid = $this->utilityclass->getVillageUUID($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

        //code for generating zonal value--------------
        $data['zonalValueOfDag'] = $this->utilityclass->getZonalValue($dist_code, $village_uuid, $dagapply->dag_no);

        if(ENABLED_BLOCKCHAIN ==1 && in_array($dist_code,json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
            /////////////////////////////////// property chain code /////////////////////////////////


            $data['propChainEnableFlag'] = $this->PropChainCommonModel->isLocationEnable($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code);

            $checkPropAndChithaAndUlpn = $this->PropChainModel->chainChithaUlpinCheckProcess($dagapply->dist_code, $dagapply->subdiv_code, $dagapply->cir_code, $dagapply->mouza_pargona_code, $dagapply->lot_no, $dagapply->vill_townprt_code, $dagapply->patta_no, $dagapply->dag_no,  $areaFromChitha->dag_area_b, $areaFromChitha->dag_area_k, $areaFromChitha->dag_area_lc, $areaFromChitha->dag_area_g, $dagapply->patta_type_code);

            // update flag in field_mut_basic
            if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'Y' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'NE') {
                $this->PropChainModel->updateCmpFlag($case_no, $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag']);

                // get view mismatch case button
                if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N') {
                    $data['viewMisMatchBtn'] = $this->PropChainModel->getMismatchBtn($case_no, $dagapply->dist_code, $dagapply->subdiv_code, $dagapply->cir_code, $dagapply->mouza_pargona_code, $dagapply->lot_no, $dagapply->vill_townprt_code, $dagapply->patta_no, $dagapply->dag_no, $areaFromChitha->dag_area_b, $areaFromChitha->dag_area_k, $areaFromChitha->dag_area_lc, $areaFromChitha->dag_area_g, $dagapply->patta_type_code);
                }
            }
            $data['ulpinCheck'] = $checkPropAndChithaAndUlpn['ulpinCheck'];
            $data['ulpinMsg'] = $checkPropAndChithaAndUlpn['ulpinMsg'];

            if ($data['ulpinCheck'] == 1) {
                $data['ulpin'] = $checkPropAndChithaAndUlpn['ulpin'];
                if (isset($checkPropAndChithaAndUlpn['old_ulpin']))
                    $data['old_ulpin'] = $checkPropAndChithaAndUlpn['old_ulpin'];
                else
                    $data['old_ulpin'] = "";
            }

            // if property does not exists get create asset button
            if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'NE') {
                $data['createPropChainBtn'] = $checkPropAndChithaAndUlpn['createPropChainBtn'];
            }
            $data['chithaPropChainCmpFlag'] = $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'];
            $data['compareFlagMsg'] = $checkPropAndChithaAndUlpn['compareFlagMsg'];
            $data['revenue'] = $checkPropAndChithaAndUlpn['revenue'];
            $data['local_tax'] = $checkPropAndChithaAndUlpn['local_tax'];
            // hidden fields
            $data['ulpin_hidden'] = $checkPropAndChithaAndUlpn['ulpin_hidden'];
            $data['uplpin_msg_hidden'] = $checkPropAndChithaAndUlpn['uplpin_msg_hidden'];
            $data['compare_hidden'] = $checkPropAndChithaAndUlpn['compare_hidden'];
            $data['compare_msg_hidden'] = $checkPropAndChithaAndUlpn['compare_msg_hidden'];

            // bhunaksha area cmp
            $data['bhuChithaCmpStatus'] = $checkPropAndChithaAndUlpn['bhuChithaCmpStatus'];
            $data['bhuChithaCmpMsg'] = $checkPropAndChithaAndUlpn['bhuChithaCmpMsg'];
            $data['bhu_hidden'] = $checkPropAndChithaAndUlpn['bhu_hidden'];
            $data['bhu_compare_msg_hidden'] = $checkPropAndChithaAndUlpn['bhu_compare_msg_hidden'];
        }


        //ESCALATED CASES REMARK ENTRY FORM==============
        if(ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE == 1 && $basic_details->es_flag == 1 && $basic_details->out_of_esc == 0)
        {
            $remainingTime = $this->Escalationmodel->calculateRemainingTime($case_no,$this->session->userdata('user_desig_code'));
            $data['remainingTime'] = $remainingTime;
            $escRemarkData = $this->Escalationmodel->getEscalationRemarkDetails($case_no,$this->session->userdata('user_desig_code'),$this->session->userdata('user_code'));
            if(isset($escRemarkData) && !empty($escRemarkData))
            {
                $data['escRemarkData'] = $escRemarkData;
            }
        }
        ///END REMARKS/////////


        $params = [
          'case_no'          => $case_no,
          'service_code'     => 3,
          'remarks'          => 'Field Partition',
          'accessed_entity'  => 'Aadhaar Name',
        ];
        $this->load->model('EkycLogModel');
        $log = $this->EkycLogModel->insertEkycAccessedBy($this->db, $params);


        $data['_view'] = 'partition/finalOrderPassFieldPartitionCO';
        $this->load->view('layouts/main',$data);   
    }

    //////// field partition save /////////////
    public function finalOrderFieldPartitionCOSave()
    {
        //xss & security validation starts
         $errorMessageStr = '';
         $resp = checkRequestSpecChar($_POST, [], [], ['inFavourGurd' => true]);
         if($resp['status'] == 'n'){
             $errorMessageStr .= $resp['messages'];
         }
         $resp = checkRequestValidQuery($_POST);
         if($resp['status'] == 'n'){
             $errorMessageStr .= $resp['messages'];
         }    
         
         // $resp = $this->checkuthenticationAndValidationFpart($_POST);
         // if($resp['responseType'] == 1)
         // {
         //    $errorMessageStr .= $resp['message'];
         // }      

         if($errorMessageStr != ''){
            $this->session->set_flashdata('message', $errorMessageStr);
             return redirect($_SERVER['HTTP_REFERER']);
         }
        //xss & security validation ends 
        if($this->session->userdata('user_desig_code')!='CO'){
            echo "<p class='text-danger'>Error. You are not authorized</p>";
            return;
        }
        $dist_code = $this->input->post('dist_code');
        $cir_code = $this->input->post('cir_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');

        $case_no = $this->input->post('case_no');
        $this->AgriStackCaseHistory->CreateLogFile($dist_code, $case_no);
        $new_dag = trim($this->input->post('sugg_dag_no'));
        $new_patta = trim($this->input->post('sugg_patta_no'));
        $dag_revenue=$this->input->post('dag_revenue');
        $dag_local_tax=$this->input->post('dag_local_tax');
        $bigha = $this->input->post('bigha_applied');
        $katha = $this->input->post('katha_applied');
        $lessa= $this->input->post('lessa_applied');

        $old_dag_bc = null;

        $caseInfoEsc = $this->db->query("SELECT * FROM field_mut_basic WHERE case_no=?",array($case_no))->row();


        if($caseInfoEsc->lm_note==null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }

        if(($caseInfoEsc->dist_code!=$dist_code) || ($caseInfoEsc->subdiv_code!=$subdiv_code) ||($caseInfoEsc->cir_code!=$cir_code) ||($caseInfoEsc->mouza_pargona_code!=$mouza_pargona_code) || ($caseInfoEsc->vill_townprt_code!=$vill_townprt_code))
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }

        if($caseInfoEsc->es_flag == 1 && ESCALATION_ENABLE == 1)
        {
            $executionDate = date('Y-m-d- H-i-s');
            $user_code = $this->session->userdata('user_code');
            $user_desig_code = $this->session->userdata('user_desig_code');
            $escalationUpdateTimeFrame = $this->Escalationmodel->escalationUpdateTimeFrame($executionDate,$dist_code,$case_no,$user_code,$user_desig_code,'FPART');
            log_message("error", "#ESC8432, transaction-error-STATUS======".json_encode($escalationUpdateTimeFrame));
            if($escalationUpdateTimeFrame['responseType'] == 1)
            {
                log_message("error", "#ESC8435, transaction-error in method 'Partition/finalOrderFieldPartitionCOSave' with case-no :". $case_no);
                $this->session->set_flashdata('message', "Something went wrong.ACPP- Error Code(#ESC8435)");
                redirect(base_url() . "index.php/home");
                return;
            }
            ////////////////////END////////////////////////////
        }


        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {

            //==========check dag pending in blockchain or not=================
                $this->load->model('propChain/PropChainCommonModel');
                $oldDagNo = $this->input->post('old_dag');
                $checkVal = $this->PropChainCommonModel->checkDagExistsInPropChainInPending($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code,$oldDagNo);
                if($checkVal === false)
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "#ERRORBLOCCHAIN7303 : You cannot procced as dag no is pending for property chain update...");
                    redirect(base_url() . "index.php/home");
                }
                

            ///=============end CODE=====================




            ////////////////////////////////////////////////////// property chain code ////////////////////////////////////
            $ulpin = $this->input->post('ulpin');
            $old_dag_bc = $this->input->post('old_dag');
            // get the dag details for the full dag partion before chitha update
            


            $get_old_revenue = $this->PropChainModel->getDagRevenue($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $this->input->post('old_patta'), $this->input->post('old_dag'));
            ///////////////////////////////////////////////////////////////////////////////////////////////////////// 

        }
        // var_dump($pattadar_details);exit;

    


        if(empty($new_patta) || $new_patta==null){
            echo "<p class='text-danger'>Error. Patta no cann't be empty</p>";
            return;
        }
        if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
            $ganda=$this->input->post('ganda_applied');
        }

        $date=date('Y-m-d');

        // if (($this->input->post('check_count') == '0') && ($this->input->post('land_area_check') != '0')) {
        //     $this->session->set_flashdata('message', "For all selected pattadar, dag with partial area partition is not allowed");
        //     redirect(base_url() . "index.php/home");
        //     return;
        // }

        $this->db->trans_begin();

        //ESCALATION ==============
        $es_flag_data = $this->db->query("select es_flag,out_of_esc from  field_mut_basic where case_no=?",array($case_no))->row();
        if(ESCALATION_ENABLE == 1 && $es_flag_data->es_flag == 1 && $es_flag_data->out_of_esc == 0)
        {

            $responseEsc = $this->Escalationmodel->escalationRemarkCheckandUpdate($case_no,$this->input->post('esc_remark'),$this->session->userdata('user_desig_code'));
            if($responseEsc['responseType'] == 1)
            {
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"#ERRESCREMARKPART00111 : Error in submitting in escalation remarks. Please try Again"
                );
                echo json_encode($data);
                return false;
            }

        }
        ///END+==================
        //////////////////////////////////
        if(isset($_FILES['fileUpload']['name'])){
            $this->form_validation->set_rules('fileText[]', 'Document Details', 'trim|xss_clean|required');
            $fileCount = count($_FILES['fileUpload']['name']);
            // validation for file type and file size
            for($i = 0; $i < $fileCount; $i++)
            {
                if($_FILES['fileUpload']['name'][$i] && $_FILES['fileUpload']['size'][$i] && $_FILES['fileUpload']['tmp_name'][$i]){
                    $name = $_FILES['fileUpload']['name'][$i];
                    $size = $_FILES['fileUpload']['size'][$i];
                    $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                    $exp  = explode("/",$mime);
                    $ext  = $exp[1];
                        if($name != NULL)
                        {
                            if($ext == NULL)
                            {
                                // todo error show extension missing
                                $this->session->set_flashdata('message', "File Not Supported. Error Code(#FAPL001)");
                                redirect(base_url() . "index.php/home");
                            }
                            if(! in_array($ext, UPLOAD_TYPE_VALIDATION))
                            {
                                // todo error show file allow type not match
                                $this->session->set_flashdata('message', "File Not Supported (ONLY JPG/PNG/PDF). Error Code(#FAPL002)");
                                redirect(base_url() . "index.php/home");
                            }
                            if($size > UPLOAD_MAX_SIZE)
                            {
                                $this->session->set_flashdata('message', "Maximum 2MB file size. Error Code(#FAPL003)");
                                redirect(base_url() . "index.php/home");
                            }
                        }
                        else
                        {
                            $this->session->set_flashdata('message', "File name cann't be empty. Error Code(#FAPL004)");
                            redirect(base_url() . "index.php/home");
                        }
                    }
                    else{
                        $this->session->set_flashdata('message', "File is required. Error Code(#FAPL005)");
                        redirect(base_url() . "index.php/home");
                    }
                }
            }
            ///////////////////Insert attached file////////////////////////
            if(isset($_FILES['fileUpload']['name'])){
                for($i = 0; $i < $fileCount; $i++)
                {
                    $_FILES['file']['name'] = $_FILES['fileUpload']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['fileUpload']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['fileUpload']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['fileUpload']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['fileUpload']['size'][$i];
                    $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                    $exp  = explode("/",$mime);
                    $onlyExtension  = $exp[1];
                    $replaceCase=str_replace("/","-",$case_no);
                    $fileRename =  $replaceCase."-".time() . '.' . $onlyExtension;
                    $config['upload_path']   = MANUAL_ATTACHMENT;
                    $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
                    $config['max_size']  = UPLOAD_MAX_SIZE;;
                    $config['file_name'] = $fileRename;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file'))
                    {
                        $document= array(
                            'case_no'   => $case_no,
                            'file_name' => $_POST['fileText'][$i],
                            'user_code' => $this->session->userdata('user_code'),
                            // 'fetch_file_name' => $_FILES['file']['name'],
                            'fetch_file_name' => $_POST['fileText'][$i],
                            'file_type'  => $_FILES['file']['type'],
                            'file_path'  => MANUAL_ATTACHMENT . $fileRename,
                            'date_entry' => date('Y-m-d h:i:s'),
                            'mut_type'   => 'FP',
                        );
                        // save data in attachment file
                        $addMoreDocQuery = $this->db->insert('supportive_document',$document);
                        if($addMoreDocQuery != 1)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRADDDOC0001: Insertion failed in supportive document RTPS Case No '.$case_no);
                            $this->session->set_flashdata('error_data', "#ERRADDDOC0001: Registration of Settlement failed for case no : ".$case_no);
                            redirect(base_url() . "index.php/home");
                            return false;
                        }
                    }
                    else
                    {
                        $this->db->trans_rollback();
                        // todo error show
                        // redirect to respected route with error mgs
                        log_message('error', '#ERRADDDOC0001: Insertion failed in supportive document RTPS Case No '.$case_no);
                        $this->session->set_flashdata('error_data', "#ERRADDDOC0001: Registration of Settlement failed for case no : ".$case_no);
                        redirect(base_url() . "index.php/home");
                        return false;
                    }
                }
            }
            //////////////////////////////////////////

        $occup_query = "SELECT mp.dist_code, mp.subdiv_code, mp.cir_code, mp.mouza_pargona_code,
        mp.lot_no, mp.vill_townprt_code, mp.pdar_id, mp.year_no, mp.petition_no, mp.pdar_add1,
        mp.pdar_add2, mp.pdar_name, mp.pdar_guardian, mp.pdar_rel_guar, dd.patta_no,
        dd.patta_type_code, mp.pdar_dag_por_b, mp.pdar_dag_por_k, mp.pdar_dag_por_lc, dd.dag_no 
        FROM field_part_petitioner mp 
        JOIN field_mut_dag_details dd ON mp.cir_code=dd.cir_code AND mp.case_no = dd.case_no
        WHERE mp.case_no=? AND mp.cir_code=? AND mp.subdiv_code=? AND mp.mouza_pargona_code=? 
        AND mp.lot_no=? AND mp.vill_townprt_code=? limit 1";
        $petitioner_save = $this->db->query($occup_query, array($case_no, $cir_code, 
            $subdiv_code, $mouza_pargona_code, $lot_no, $vill_townprt_code));
        // echo $this->db->last_query();
        // return;

        if ($petitioner_save == null || $petitioner_save->num_rows()<=0)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "Could not get petitioner details. Error Code(#ERRFP001)");
            log_message("error","#ERRFP001: No Petitioner found in field_part_petitioner 
                for dist:".$dist_code.", case: ". $case_no);
            redirect(base_url() . "index.php/home");
            return;        
        }
        $petitioner_save = $petitioner_save->row();
        
        $occup_data = "SELECT * FROM field_part_petitioner WHERE case_no=? AND 
            mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND 
            dist_code=? AND subdiv_code=? AND cir_code=?";
        $occup_data = $this->db->query($occup_data, array($case_no, $mouza_pargona_code, $lot_no,
        $vill_townprt_code, $dist_code, $subdiv_code, $cir_code));


        if ($occup_data == null || $occup_data->num_rows()<=0)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "Could not get petitioner details. Error Code(#ERRFP002)");
            log_message("error","#ERRFP002: No Petitioner found in field_part_petitioner 
                for dist:".$dist_code.", case: ". $case_no);
            redirect(base_url() . "index.php/home");
            return;                
        }
        $occup_data = $occup_data->result();

        $get_mut_type = $this->db->query("SELECT * FROM field_mut_basic 
            WHERE case_no=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? 
            AND dist_code=? AND subdiv_code=? AND cir_code=?", 
            array($case_no, $mouza_pargona_code, $lot_no, $vill_townprt_code, 
                $dist_code, $subdiv_code, $cir_code ))->row();

        //Field Partition
        if($get_mut_type->mut_type == '02')
        {
            $new_pattadar = 'N';
            $sql="SELECT patta_type_code, dag_no FROM field_mut_dag_details WHERE case_no=?";
            $dd=$this->db->query($sql, $case_no);
            if ($dd == null || $dd->num_rows()<=0)
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Could not get petitioner details. Error Code(#ERRFP003)");
                log_message("error","#ERRFP003 No petitioner found in field_mut_dag_details 
                    for dist:".$dist_code.", case: ". $case_no);
                redirect(base_url() . "index.php/home");
                return;                
            }
            $dd=$dd->row();
            $pp_code=$dd->patta_type_code;
            $old=$dd->dag_no;

            $sql="SELECT COUNT(*) AS d FROM chitha_basic WHERE mouza_pargona_code=? 
                AND lot_no=? AND vill_townprt_code=? AND dist_code=? AND subdiv_code=? 
                AND cir_code=? AND dag_no=? AND dag_no!=? ";
            $count=$this->db->query($sql, array($mouza_pargona_code, $lot_no, $vill_townprt_code,
                $dist_code, $subdiv_code, $cir_code, $new_dag, $old))->row()->d;
            if($count != null && $count>0){                
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "The Dag no you have given already exist ! Please re-verify the dag no again (#ERRFP004)");
                log_message("error","#ERRFP004 No petitioner in chitha_basic for 
                    dist:".$dist_code.", case: ". $case_no);
                redirect(base_url() . "index.php/home");
                return;
            }

            $sql="SELECT COUNT(*) AS c FROM chitha_pattadar WHERE 
                mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? AND dist_code=? 
                AND subdiv_code=? AND cir_code=? AND patta_no=? AND patta_type_code=? ";           
            $count=$this->db->query($sql, array($mouza_pargona_code, $lot_no, $vill_townprt_code,
                $dist_code, $subdiv_code, $cir_code, $new_patta, $pp_code))->row()->c;

            // if($count != null && $count>0){                
            //     $this->db->trans_rollback();
            //     $this->session->set_flashdata('message', "The patta no you have selected already exist pattadar (#ERRFP005)");
            //     log_message("error","#ERRFP005 No detail available in chitha_pattadar 
            //         for dist:".$dist_code.", case: ". $case_no);
            //     redirect(base_url() . "index.php/home");
            //     return;
            // }
        }
        else
        {
            $new_pattadar = '';
        }
        
        //var_dump($occup_data);
        foreach ($occup_data as $occup) {

                 if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                $occup_ganda=$occup->pdar_dag_por_g;
                    }
                else{
                    $occup_ganda='0';
                    $ganda='0';
                }
                $dec= null;
                if(isset($occup->self_declaration) && $occup->self_declaration !=null){
                    $dec       = $occup->self_declaration;
                }
                if($occup->auth_type != null){
                    /*if($occup->auth_type=='AADHAAR' && $occup->photo == null){
                        $this->db->trans_rollback();
                        log_message('error', '#ERRFMUTI005 : Aadhaar Photo fetching error');
                        $this->session->set_flashdata('message', "#ERRFMUTI005:Aadhaar fetching error-img");
                        redirect(base_url() . "index.php/home");
		    }*/
                    $auth_type = $occup->auth_type;
                    $id_ref_no = $occup->id_ref_no;
                    //$photo     = $occup->photo;
                    $photo     = null;
                }else{
                    $auth_type = null;
                    $id_ref_no = null;
                    $photo = null;
                }
                
            $t_chitha_col8_occup = array(
                'dist_code'=>$occup->dist_code, 
                'subdiv_code'=>$occup->subdiv_code,
                'cir_code'=>$occup->cir_code,
                'mouza_pargona_code'=>$occup->mouza_pargona_code,
                'lot_no'=>$occup->lot_no, 
                'vill_townprt_code'=>$occup->vill_townprt_code, 
                'dag_no'=>$occup->dag_no,//$new_dag, //should be the new dag
                'year_no'=>$occup->year_no, 
                'petition_no'=>$occup->petition_no, 
                'occupant_id'=>$occup->pdar_cron_no, 
                'patta_type_code'=>$occup->patta_type_code,
                'patta_no'=>$occup->patta_no,//$new_patta,  //should be the new patta no
                'pdar_id'=>$occup->pdar_id, 
                'occupant_name'=>$occup->pdar_name, 
                'occupant_fmh_name'=>$occup->pdar_guardian, 
                'occupant_fmh_flag'=>$occup->pdar_rel_guar, 
                'occupant_add1'=>$occup->pdar_add1, 
                'occupant_add2'=>$occup->pdar_add2, 
                'land_area_b'=>$occup->pdar_dag_por_b, 
                'land_area_k'=>$occup->pdar_dag_por_k, 
                'land_area_lc'=>$occup->pdar_dag_por_lc, 
                'land_area_g'=>$occup_ganda, 
                'land_area_kr'=>'0', 
                'old_patta_no'=>$occup->patta_no, 
                'new_patta_no'=>$new_patta, 
                'old_dag_no'=>$occup->dag_no, 
                'new_dag_no'=>$new_dag,  
                'new_pattadar'=>$new_pattadar,
                'revenue'=> $dag_revenue,
                'self_declaration' => $dec,
                'auth_type' => $auth_type,
                'id_ref_no'=> $id_ref_no,
                'photo'=> $photo
            );
            //var_dump($t_chitha_col8_occup);
            $tstatus1 = $this->db->insert("t_chitha_col8_occup", $t_chitha_col8_occup); //****************************
            if ($tstatus1 != 1 )
            {
               $this->db->trans_rollback();
               $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#ERRFP006)");
               log_message("error","#ERRFP006 Nill petition from t_chitha_col8_occup for dist:"
                           .$dist_code.", case: ". $case_no);
               redirect(base_url() . "index.php/home");
            }
            // ////////////Set Patta For JamaUpdation 14/10/2020/////////////////
            $patta_no=$new_patta;
            $patta_type_code=$occup->patta_type_code;
            // ////////////////////////////
        }
        $insert_t_chitha_col8_order = array(
            'dist_code' => $dist_code, 
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no, 
            'vill_townprt_code' => $vill_townprt_code, 
            'dag_no' => $this->input->post('old_dag'),
            'year_no' => date('Y'), 
            'petition_no' => $get_mut_type->petition_no, 
            'order_pass_yn' => 'y',
            'order_type_code' => '02',
            'nature_trans_code' => $get_mut_type->trans_code,
            'lm_code' => $this->input->post('lm_code'),
            'lm_sign_yn' => 'y', 
            'lm_note_date' => date('Y-m-d', strtotime($this->input->post('lm_date'))),
            'co_code' => $this->input->post('co_code'),
            'co_sign_yn' => 'y',
            'co_ord_date' => date('Y-m-d h:i:s'),
            'iscorrected_inco' => 'y', 
            'iscorrected_inco_date' => date('Y-m-d h:i:s'),
            'mut_land_area_b' => $this->input->post('bigha_applied'),
            'mut_land_area_k' => $this->input->post('katha_applied'),
            'mut_land_area_lc' => $this->input->post('lessa_applied'),
            'mut_land_area_g' => $ganda,
            'mut_land_area_kr' => '0',
            'land_area_left_b' => $this->input->post('bigha'), 
            'land_area_left_k' => $this->input->post('katha'), 
            'land_area_left_lc' => $this->input->post('lessa'), 
            'land_area_left_g' => $ganda,
            'land_area_left_kr' => '0',
            'rajah_adalat' => $get_mut_type->rajah_adalat,
            'case_no' => $case_no,
            'min_revenue' => $this->input->post('dag_revenue'),
        );
        $instChithaCol8Order=$this->db->insert("t_chitha_col8_order", $insert_t_chitha_col8_order); 
        if ($instChithaCol8Order != 1 )
        {
           $this->db->trans_rollback();
           $this->session->set_flashdata('message', "Error in Processing. Please try Again. Error Code(#ERRFP009)");
           log_message("error","#ERRFP009 unable to insert into t_chitha_col8_order for dist:"
                    .$dist_code.", case: ". $case_no);
           redirect(base_url() . "index.php/home");
           return;
        }

        

        $dist_code = $petitioner_save->dist_code;
        $subdiv_code = $petitioner_save->subdiv_code;
        $cir_code = $petitioner_save->cir_code;
        $mouza_pargona_code = $petitioner_save->mouza_pargona_code;
        $lot_no = $petitioner_save->lot_no;
        $vill_townprt_code = $petitioner_save->vill_townprt_code;
        $dag_no = $petitioner_save->dag_no;
        $petition_no = $petitioner_save->petition_no;
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $db_debug = $this->db->db_debug;
            $this->db->db_debug = TRUE;
            //echo $this->db->_error_message();
            $this->db->db_debug = $db_debug;
            $url="<a href='cofieldmutation/pendingmaps' class='text-success'>Kindly Click Here to Remove Temporary Data </a>";
            $this->session->set_flashdata("message", "Order Cannot be passed. Error Code [T-TABLE_HAS_DATA] . Contact help desk with case no. $url");
            redirect(base_url() . "index.php/home");
            return;
        } else {
            $this->session->set_flashdata("message", "Order passed. Case Pending with mandal for parition Map Correction");           
        }
            
        $this->load->model('jamabandi/jamabandiAutoUpdateModel');
        if($occup->dag_no == $new_dag)
        {
            $ok = $this->autoUpdate_fulldag_field($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $petition_no, $dag_no);
            $this->jamabandiAutoUpdateModel->jamaCheckToDeleteorNot($dist_code, $subdiv_code,
            $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $occup->dag_no, $this->input->post('old_patta'), $this->input->post('patta_code'));
        }
        else
        {
            $ok = $this->autoUpdateForField($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $petition_no, $occup->dag_no);
            //var_dump($ok);
            // return;
            //die();
            if ($ok != true)
            {
               $this->db->trans_rollback();
               $this->session->set_flashdata('message', "Chitha Could not be updated. Please try Again. Error Code(#ERRFP010)");
               log_message("error","#ERRFP010 unable to update chitha from autoUpdate dist:"
                        .$dist_code.", case: ". $case_no);
               redirect(base_url() . "index.php/home");
               return;                
            }

            $order_date = date('Y-m-d');
            $this->db->query("UPDATE field_mut_basic SET order_passed=?, date_of_order=? 
                WHERE case_no=? ", array('y', $order_date, $case_no));
            if ($this->db->affected_rows() <=0)
            {
               $this->db->trans_rollback();
               $this->session->set_flashdata('message', "Chitha Could not be updated. Please try Again. Error Code(#ERRFP011)");
               log_message("error","##ERRFP011 unable to update chitha from autoUpdate dist:"
                        .$dist_code.", case: ". $case_no);
               redirect(base_url() . "index.php/home");
               return;                   
            }

            $this->db->query("UPDATE t_chitha_col8_order SET order_passed=?, 
                date_of_order=? WHERE case_no=? ", array('y', $order_date, $case_no));
            if ($this->db->affected_rows() <=0)
            {
               $this->db->trans_rollback();
               $this->session->set_flashdata('message', "Chitha Could not be updated. Please try Again. Error Code(#ERRFP012)");
               log_message("error","##ERRFP012 unable to update chitha from autoUpdate dist:"
                        .$dist_code.", case: ". $case_no);
               redirect(base_url() . "index.php/home");
               return;                   
            }
        }

            $rmrk='CO order';

           $proInsert = $this->mutationmodel->proceeding_order($case_no,$rmrk);


           if($proInsert==false || $proInsert===false)
            {
                log_message('error', "#OPARTCO001:".$this->db->last_query());
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Updation failed(#OPARTCO001)".$case_no);
                redirect(base_url() . "index.php/home");
            }
        
        if ($ok) {
            
            
            //ESCALATION CODE INTEGRATION================SANMRI
            $dist_code=$this->session->userdata('dist_code');
            $subdiv_code=$this->session->userdata('subdiv_code');
            $cir_code= $this->session->userdata('cir_code');
            $query1 = $this->db->query("SELECT es_flag,out_of_esc FROM field_mut_basic WHERE case_no=?", 
                array($case_no))->row();
            $user_code = $this->session->userdata('user_code');
            $executionDate = $this->input->post('executionDate');
            if($query1->es_flag == 1 && ESCALATION_ENABLE == 1 && $query1->out_of_esc == 0){

                $escalationUpdateStatus = $this->Escalationmodel->escalationFinalOrderCOFPART($executionDate,$dist_code,$subdiv_code,$cir_code,$case_no,$user_code);
                log_message("error", "#ESC8610, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

                if($escalationUpdateStatus['responseType'] == 0){
                    $this->db->trans_rollback();
                    log_message("error", "#ESC8610, transaction-error in method 'cofieldmutation/finalorderCO' with case-no :". $case_no);
                    $this->session->set_flashdata('message', "Something went wrong. Error Code(#ESC8610)");
                    redirect(base_url() . "index.php/home");
                }
            }

            //////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////////Property Chain Code////////////////////////////////
            //////////////////////////////////////////////////////////////////////////////////////////

            


            if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
            {

                $pattadar_details = $this->PropChainModel->getPattadars($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $new_patta, $this->input->post('old_dag'));

                if($old_dag_bc !=null && ($new_dag != $old_dag_bc))
                {
                    // $checkValidate = true;
                    $checkValidate = $this->PropChainCommonModel->checkValidateMapDagForOrderPass($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$new_dag,$old_dag_bc);
                    
                    if($checkValidate>0)
                    {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "ERROR7711 : Update map is pending for dag no ($new_dag,$old_dag_bc)==".$case_no);
                        redirect(base_url() . "index.php/home");
                    }
                }

                $ulpinFlag = $this->input->post('ulpinCheckFlag');
                $compareFlag = $this->input->post('compareCheckFlag');


                if($compareFlag == 'Y' && $ulpinFlag ==1)
                {
                    $type = LOC_TYPE_RURAL;
                    $old_dag = $this->input->post('old_dag');
                    $old_patta = $this->input->post('old_patta');
                    $old_ulpin = $this->input->post('old_ulpin');
                    if (!isset($old_ulpin))
                        $old_ulpin = "";
                    $new_dag_chain = $new_dag;
                    $new_patta_chain = $new_patta;

                    $patta_type_code = $this->input->post('patta_code');
                    $reference_id = $case_no;
                    $certmnemonic = CERTMNEMONIC_PRT;
                    $property_signature = "base64 encoded signature";
                    $property_signer_key = "base64 encoded public key";
                    $office_code = $this->session->userdata('cir_code');
                    $user_code = $this->session->userdata('user_code');


                    $dag_query = "select m_dag_area_b, m_dag_area_k, m_dag_area_lc, m_dag_area_g, m_dag_area_kr, dag_area_b, dag_area_k, dag_area_lc, dag_area_g, dag_area_kr from  field_mut_dag_details where case_no='$case_no' ";

                    $dag_details = $this->db->query($dag_query)->row();
                    $bigha_chain_source = $dag_details->dag_area_b;
                    $katha_chain_source = $dag_details->dag_area_k;
                    $lessa_chain_source = $dag_details->dag_area_lc;
                    $ganda_chain_source = $dag_details->dag_area_g;

                    $bigha_chain_new = $dag_details->m_dag_area_b;
                    $katha_chain_new = $dag_details->m_dag_area_k;
                    $lessa_chain_new = $dag_details->m_dag_area_lc;
                    $ganda_chain_new = $dag_details->m_dag_area_g;


                    if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY)))
                    {
                        $source_lessa = $bigha_chain_source * 6400 + $katha_chain_source * 320 + $lessa_chain_source * 20 + $ganda_chain_source;
                        $partition_lessa = $bigha_chain_new * 6400 + $katha_chain_new * 320 + $lessa_chain_new * 20 + $ganda_chain_new;

                        $remaining_lessa = $source_lessa - $partition_lessa;

                        $remaining_b = floor($remaining_lessa / 6400);
                        $remaining_k = floor(($remaining_lessa - $remaining_b * 6400) / 320);
                        $remaining_lc = floor(($remaining_lessa - $remaining_b * 6400 - $remaining_k * 320)/20 );
                        $remaining_g = $remaining_lessa - $remaining_b * 6400 - $remaining_k * 320 - $remaining_lc * 20;
                        $remaining_kr = 0;

                    }
                    else
                    {

                        $source_lessa = $bigha_chain_source * 100 + $katha_chain_source * 20 + $lessa_chain_source;
                        $partition_lessa = $bigha_chain_new * 100 + $katha_chain_new * 20 + $lessa_chain_new;

                        $remaining_lessa = $source_lessa - $partition_lessa;

                        $remaining_b = floor($remaining_lessa / 100);
                        $remaining_k = floor(($remaining_lessa - $remaining_b * 100) / 20);
                        $remaining_lc = $remaining_lessa - $remaining_b * 100 - $remaining_k * 20;
                        $remaining_g = 0;
                        $remaining_kr = 0;
                    }


                    // $source_lessa = $bigha_chain_source * 100 + $katha_chain_source * 20 + $lessa_chain_source;

                    // $partition_lessa = $bigha_chain_new * 100 + $katha_chain_new * 20 + $lessa_chain_new;

                    // $remaining_lessa = $source_lessa - $partition_lessa;

                    // $remaining_b = floor($remaining_lessa / 100);
                    // $remaining_k = floor(($remaining_lessa - $remaining_b * 100) / 20);
                    // $remaining_lc = $remaining_lessa - $remaining_b * 100 - $remaining_k * 20;
                    // $remaining_g = 0;
                    // $remaining_kr = 0;

                    $chain_result = new \stdClass;
                    $chain_result_2 = new \stdClass;
                    $chain_result_3 = new \stdClass;
                    $chain_result_4 = new \stdClass;

                    // since the below paramaters are not applicable in partition send empty string
                    $old_land_class_code =  $new_patta_type_code = "";

                    if ($occup->dag_no == $new_dag)
                    {

                        $land_class_code_query = "select land_class_code from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and patta_no='$new_patta_chain' and dag_no='$old_dag'";

                        $land_class_code = $this->db->query($land_class_code_query)->row()->land_class_code;

                        // TODO: when the format of the property id changes the follwing attributes will be 
                        $bigha_chain_new = $katha_chain_new = $lessa_chain_new = $ganda_chain_new = '';
                        $new_dag_no = '';

                        $chain_data_params = array(
                            'pattadar_details' => $pattadar_details,
                            'dist_code' => $dist_code,
                            'subdiv_code' => $subdiv_code,
                            'cir_code' => $cir_code,
                            'mouza_pargona_code' => $mouza_pargona_code,
                            'lot_no' => $lot_no,
                            'vill_townprt_code' => $vill_townprt_code,
                            'reference_id' => $reference_id,
                            'old_dag' => $old_dag,
                            'old_patta' => $old_patta,
                            'patta_type_code' => $patta_type_code,
                            'land_class_code' => $land_class_code,
                            'remaining_b' => $bigha_chain_source,
                            'remaining_k' => $katha_chain_source,
                            'remaining_lc' => $lessa_chain_source,
                            'remaining_g' => $ganda_chain_source,
                            'certmnemonic' => $certmnemonic,
                            'property_signature' => $property_signature,
                            'property_signer_key' => $property_signer_key,
                            'office_code' => $office_code,
                            'user_code' => $user_code,
                            'ulpin' => $ulpin,
                            'old_ulpin' => $old_ulpin,
                            'dag_revenue' => $dag_revenue,
                            'dag_local_tax' => $dag_local_tax,
                            'new_patta_no' => $new_patta_chain,
                            'old_dag_revenue' => $get_old_revenue->dag_revenue,
                            'old_dag_local_tax' => $get_old_revenue->dag_local_tax,
                            'old_land_class_code' => $old_land_class_code,
                            'new_bigha' => $bigha_chain_new,
                            'new_katha' => $katha_chain_new,
                            'new_lessa' => $lessa_chain_new,
                            'new_ganda' => $ganda_chain_new,
                            'new_patta_type_code' => $new_patta_type_code
                        );

                        $fullDagProcess = $this->PropChainModel->chainFullDagProcess((object)$chain_data_params);
                        // var_dump($fullDagProcess);
                        // die;
                        $chain_result_2 = $fullDagProcess;
                    } 
                    else
                    {

                        $property_id_update = $this->blockchainutilityclass->generatePropertyId($type, $vill_townprt_code, $old_patta, $old_dag, $ulpin);

                        $land_class_code_query_update = "select land_class_code from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and patta_no='$old_patta' and dag_no='$old_dag'";

                        $land_class_code_update = $this->db->query($land_class_code_query_update)->row()->land_class_code;
                        ///////////////////////// update property chain ///////////////////

                        $chain_data_params = array(
                            'dist_code' => $dist_code,
                            'subdiv_code' => $subdiv_code,
                            'cir_code' => $cir_code,
                            'mouza_pargona_code' => $mouza_pargona_code,
                            'lot_no' => $lot_no,
                            'vill_townprt_code' => $vill_townprt_code,
                            'old_patta' => $old_patta,
                            'old_dag' => $old_dag,
                            'patta_type_code' => $patta_type_code,
                            'reference_id' => $reference_id,
                            'land_class_code' => $land_class_code_update,
                            'remaining_b' => $remaining_b,
                            'remaining_k' => $remaining_k,
                            'remaining_lc' => $remaining_lc,
                            'remaining_g' => $remaining_g,
                            'certmnemonic' => $certmnemonic,
                            'property_signature' => $property_signature,
                            'property_signer_key' => $property_signer_key,
                            'office_code' => $office_code,
                            'user_code' => $user_code,
                            'ulpin' => $ulpin,
                            'old_ulpin' => $old_ulpin,
                            'dag_revenue' => $dag_revenue,
                            'dag_local_tax' => $dag_local_tax,
                            'new_patta_no' => $new_patta_chain,
                            'new_dag_no' => $new_dag_chain,
                            'old_dag_revenue' => $get_old_revenue->dag_revenue,
                            'old_dag_local_tax' => $get_old_revenue->dag_local_tax,
                            'old_land_class_code' => $old_land_class_code,
                            'bigha_new' => $bigha_chain_new,
                            'katha_new' => $katha_chain_new,
                            'lessa_new' => $lessa_chain_new,
                            'ganda_new' => $ganda_chain_new,
                            'new_patta_type_code' => $new_patta_type_code
                        );
                        // $this->db->trans_rollback();
                        $update_chain_api = $this->PropChainModel->chainPartialDagProcessN((object)$chain_data_params);

                        // $update_chain_api = $this->PropChainModel->chainPartialDagProcess($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $old_patta, $old_dag, $patta_type_code, $reference_id, $land_class_code_update, $remaining_b, $remaining_k,  $remaining_lc, $remaining_g, $certmnemonic, $property_signature, $property_signer_key, $office_code, $user_code, $ulpin, $old_ulpin, $dag_revenue, $dag_local_tax, $new_patta_chain, $new_dag_chain, $get_old_revenue->dag_revenue, $get_old_revenue->dag_local_tax, $old_land_class_code, $bigha_chain_new, $katha_chain_new, $lessa_chain_new, $ganda_chain_new, $new_patta_type_code);



                        $chain_result_2 = $update_chain_api;

                    }
                }
                else
                {
                    //uses for default==============
                    $chain_result_2 = new \stdClass;
                    $chain_result_2->success = 1;

                }
            }
            else
            {

                                    //uses for default==============
                    $chain_result_2 = new \stdClass;
                    $chain_result_2->success = 1;
            }

            if ($chain_result_2->success == 1) {

                //autoupdate jamabandi starts here for old patta
                $this->db->trans_commit();  
                $this->AgriStackCaseHistory->CreateLog($dist_code,$case_no);
                //code for updating zonal informtion of dag------------17032023--

                //code for generating village uuid------------
                $village_uuid = $this->utilityclass->getVillageUUID($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

                //zonal row fetch row for insertion same row for new dag----------
                $ZonalStatus = $this->utilityclass->getZonalRowFetchAndInsert($dist_code, $village_uuid, $this->input->post('old_dag'),$new_dag);
                if($ZonalStatus=='N'){
                    log_message('error','#RES001 : Zonal value of new dag could not been updated. OLD Dag :'.$this->input->post('old_dag'). " and New dag : ".$new_dag. " CASE NO : ".$case_no);
                }elseif($ZonalStatus == 'Y'){
                    log_message('error','#RES002 : Zonal value of new dag updated successfully. OLD Dag :'.$this->input->post('old_dag'). " and New dag : ".$new_dag. " CASE NO : ".$case_no);
                }
                //end-----------17032023




                $jamaUpdate = $this->jamabandiAutoUpdateModel->updateJamabandi($this->input->post('old_patta'), $this->input->post('patta_code'), $dist_code, $subdiv_code, 
                $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $case_no);
                //////////
                $this->DashboardDataFinal($case_no);
                ///////
                $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
                if($basundhara){
                    $rmk='Order passed';
                    $status='F';
                    $task='CO';
                    $pen='NA';
                    $case=$case_no;
                    $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
                }   
                      
                //////////////////////////////////
                $this->session->set_flashdata('message', "Order for Case No $case_no Successfully Saved.");
                $this->session->set_flashdata('message', "Chitha Has Been Updated");
                //////////////JamaBandi Update///////////////////
                $location = array(
                        'd'=> $dist_code,
                        's' => $subdiv_code,
                        'c' => $cir_code,
                        'm' => $mouza_pargona_code,
                        'l' => $lot_no,
                        'v' => $vill_townprt_code,
                    );
                //var_dump($location);
                $this->session->set_userdata(array('loc' => $location));
                // echo $patta_no."-".$patta_type_code;
                // exit;
                $popUpmsg="<h4>Order for Case No $case_no Successfully Saved.Chitha has been Updated !!! Updating JamaBandi Now<h4>";
                $msgggg= "<script type='text/javascript'>alert(' " .$popUpmsg ." ');</script>";
                //echo $msgggg;
                if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                {
                    if($compareFlag == 'Y' && $ulpinFlag ==1)
                    {
                        redirect('JamaBandi/step3/' . $patta_no . '/' . $patta_type_code . '/' .  urlencode(base64_encode($case_no)));
                    }
                }
                redirect('JamaBandi/step3/' .$patta_no .'/'. $patta_type_code);
                    
            }elseif ($chain_result_2->success === 0) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', $chain_result_2->message . ": " . $chain_result_2->error_msg . ". Property Chain updation for Case No $case_no Not Successfull. Error Code(" . $chain_result_2->error_code . ")");
                redirect(base_url() . "index.php/home");
            } else {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error occured. Property Chain updation and creation for Case No $case_no Not Successfull.");
                redirect(base_url() . "index.php/home");
            }
            //redirect(base_url() . "index.php/home");
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "Chitha Could not be updated for case no $case_no.Contact Helpdesk with case no");
            redirect(base_url() . "index.php/home");
        }
    }

    public function autoUpdate_fulldag_field($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_code,
         $petition_no, $dag_no)
    {
        
        $locationData = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'lot_no' => $lot_no,
            'vill_code' => $vill_code,
            'mouza_pargona_code' => $mouza_pargona_code,
        );
        
        $year_no = year_no;
        $col8order_cron_no = $this->db->query("select max(col8order_cron_no)+1 as cron_no from   chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                . "vill_townprt_code='$vill_code' and dag_no='$dag_no'")->row()->cron_no;
        //echo "select max(col8order_cron_no)+1 as cron_no from   chitha_col8_order";           
        if ($col8order_cron_no == null) {
            $col8order_cron_no = 1;
        }
        $t_order_data_query = "select * from   t_chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                . "vill_townprt_code='$vill_code' and petition_no=$petition_no and dag_no='$dag_no'";
        //echo $t_order_data_query;           
        $t_data_order = $this->db->query($t_order_data_query);
        if($t_data_order==null || $t_data_order->num_rows() <= 0 )
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "FPTCO007: Unable to pass order !");
            log_message("error","#FPTCO007 No detail available in t_chitha_col8_order for dist:".$dist_code.", petition no: ". $petition_no);
            redirect(base_url() . "index.php/home");
            return;
        }

        $t_data_order = $t_data_order->result();
        $i = 1;
        foreach ($t_data_order as $ord)
        {
            log_message("error","MPR:****************************: count=".$i++);
            $data_order = array();
            foreach ($ord as $key => $value) {
                $data[$key] = $value;
            }
            //var_dump($data);
            $data['col8order_cron_no'] = $col8order_cron_no;
            $data['user_code'] = $this->session->userdata('user_code');
            $data['date_entry'] = date('Y-m-d G:i:s');
            $data['operation'] = date('E');
            unset($data['year_no']);
            unset($data['petition_no']);
            unset($data['iscorrected_inco']);
            unset($data['iscorrected_inco_date']);
            unset($data['isdataposted_torkg_db']);
            unset($data['iscorrected_rkg_record']);
            unset($data['iscorrected_rkg_date']);
            unset($data['order_passed']);
            unset($data['date_of_order']);
            unset($data['make_mdb']);
            unset($data['date_of_order']);
            unset($data['not_consistent']);
            $corrected = date('Y-m-d G:i:s');
            $dataNew = $data;
            //var_dump($data);
            $tstatus11 = $this->db->insert("chitha_col8_order", $data); //*************************

            if($tstatus11 != 1 )
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "FPCC008: Unable to pass order !");
                log_message("error","#FPCC008 Insertion failed in chitha_col8_order for dist: "
                        .$dist_code.", petition no: ". $petition_no);
                redirect(base_url() . "index.php/home");
                return;
            }

            $update_query = "update t_chitha_col8_order  set iscorrected_inco='Y',iscorrected_inco_date='$corrected' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                    . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                    . "vill_townprt_code='$vill_code' and petition_no=$petition_no and  dag_no='$dag_no' ";
            $this->db->query($update_query); //************************

            if($this->db->affected_rows() <=0 )
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "FPTCC009: Unable to pass order !");
                log_message("error","#FPTCC009 Updation failed in t_chitha_col8_order for dist: ".$dist_code.", petition no: ". $petition_no);
                redirect(base_url() . "index.php/home");
                return;
            }
            
            $t_occup_query = "select * from   t_chitha_col8_occup where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                    . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                    . "vill_townprt_code='$vill_code' and petition_no=$petition_no and dag_no='$dag_no' "
                    . " and iscorrected_inco is null";
            //echo $t_occup_query;

            $t_occup_data = $this->db->query($t_occup_query);
            if($t_occup_data == null || $t_occup_data->num_rows()<=0 )
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "FPTCC010: Unable to pass order !");
                log_message("error","#FPTCC010 Data not available in t_chitha_col8_occup for dist:".$dist_code.", petition no: ". $petition_no);
                redirect(base_url() . "index.php/home");
                return;
            }
            $chitha_update=0;
            $t_occup_data = $t_occup_data->result();
            //var_dump($t_occup_data);
            
            $chitha_basic_update = FALSE;
            foreach ($t_occup_data as $occ) {
                //var_dump($occ);
               if($chitha_update==0){
                    // $sql = "update chitha_basic set jama_yn=null, patta_no = '$occ->new_patta_no', old_patta_no = '$occ->patta_no'"
                    //         . " where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                    //         . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                    //         . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                    //         . " and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->patta_no') and"
                    //         . " patta_type_code='$occ->patta_type_code' ";

                    // $this->db->query($sql); //****************
                    //log_message("error","MPR: AFFECTED ROWS: ".$this->db->affected_rows());
                    $table = 'chitha_basic';

                    $params = [
                        'jama_yn'      => null,
                        'patta_no'     => $occ->new_patta_no,
                        'old_patta_no' => $occ->patta_no,
                    ];

                    $where = [
                        'dist_code'          => $occ->dist_code,
                        'subdiv_code'        => $occ->subdiv_code,
                        'cir_code'           => $occ->cir_code,
                        'mouza_pargona_code' => $occ->mouza_pargona_code,
                        'lot_no'             => $occ->lot_no,
                        'vill_townprt_code'  => $occ->vill_townprt_code,
                        'dag_no'             => $occ->dag_no,
                        'patta_no'           => trim($occ->patta_no),
                        'patta_type_code'    => $occ->patta_type_code,
                    ];

                    $result2 = $this->Chitha_basic_model->update_table($table, $params, $where);

                    if($result2 <= 0)
                    {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "FPCB011: Unable to pass order !");
                        log_message("error","#FPCB011 Updation failed in chitha_basic for dist: ".$dist_code.", petition no: ". $petition_no." Query:".$this->db->affected_rows());
                        redirect(base_url() . "index.php/home");
                        return;
                    }
                    $chitha_update=1;
               }

                //$this->db->trans_begin();
                $data = array();
                foreach ($occ as $key => $value) {
                    $data[$key] = $value;
                }
                
                unset($data['year_no']);
                unset($data['petition_no']);
                unset($data['iscorrected_inco']);
                unset($data['iscorrected_inco_date']);
                unset($data['isdataposted_torkg_db']);
                unset($data['iscorrected_rkg_record']);
                unset($data['iscorrected_rkg_date']);
                unset($data['order_passed']);
                unset($data['date_of_order']);
                unset($data['make_mdb']);
                unset($data['date_of_order']);
                unset($data['patta_type_code']);
                unset($data['patta_no']);
                unset($data['pdar_id']);
                unset($data['revenue']);
                unset($data['new_pattadar']);
                $data['col8order_cron_no'] = $col8order_cron_no;
                $data['user_code'] = $this->session->userdata('user_code');
                $data['date_entry'] = date('Y-m-d G:i:s');
                $data['operation'] = date('E');
                $occupData = $data;
                //var_dump($data);
                $tstatus12 = $this->db->insert("chitha_col8_occup", $data); // ******************

                if($tstatus12 != 1 )
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "FPCCO012: Unable to pass order !");
                    log_message("error","#FPCCO012 Insertion failed in chitha_col8_occup for dist:".$dist_code.", petition no: ". $petition_no);
                    redirect(base_url() . "index.php/home");
                    return;
                }

                $dag_pattadar = array();
                $chitha_pattadar = array();

                $pdar_id = null;

                if ($ord->order_type_code == '02') {
                    $pdar_id = $this->Chitha_basic_model->maxpdarIdCheck($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_code,$occ->patta_type_code,trim($occ->patta_no));
                } else {
                    $pdar_id = $this->Chitha_basic_model->maxpdarIdCheck($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_code,$occ->patta_type_code,trim($occ->patta_no));
                }
                if ($pdar_id == null) {
                    $pdar_id = 1;
                }
                $dag_pattadar['dist_code'] = $dist_code;
                $dag_pattadar['subdiv_code'] = $subdiv_code;
                $dag_pattadar['cir_code'] = $cir_code;
                $dag_pattadar['lot_no'] = $lot_no;
                $dag_pattadar['mouza_pargona_code'] = $mouza_pargona_code;
                $dag_pattadar['vill_townprt_code'] = $vill_code;
                if ($ord->order_type_code == '02') {
                    $dag_pattadar['dag_no '] = $occ->new_dag_no;
                } else {
                    $dag_pattadar['dag_no '] = $dag_no;
                }
                if (($occ->pdar_id) && (!($ord->order_type_code == '02'))) {
                    $dag_pattadar['pdar_id'] = $occ->pdar_id;
                } else {
                    $dag_pattadar['pdar_id'] = $pdar_id;
                }
                if ($ord->order_type_code == '02') {
                    $dag_pattadar['patta_no'] = trim($occ->new_patta_no);
                    $chitha_pattadar['patta_no'] = trim($occ->new_patta_no);
                } else {
                    $dag_pattadar['patta_no'] = trim($occ->patta_no);
                    $chitha_pattadar['patta_no'] = trim($occ->patta_no);
                }
                $dag_pattadar['p_flag'] = '0';
                $dag_pattadar['patta_type_code'] = $occ->patta_type_code;
                $dag_pattadar['dag_por_b'] = $occ->land_area_b;
                $dag_pattadar['dag_por_k'] = $occ->land_area_k;
                $dag_pattadar['dag_por_lc'] = $occ->land_area_lc;
                $dag_pattadar['dag_por_g'] = $occ->land_area_g;
                $dag_pattadar['dag_por_kr'] = $occ->land_area_kr;

                $dag_pattadar['user_code'] = $this->session->userdata('user_code');
                $dag_pattadar['date_entry'] = date('Y-m-d G:i:s');
                $dag_pattadar['operation'] = date('E');

                $chitha_pattadar['dist_code'] = $dist_code;
                $chitha_pattadar['subdiv_code'] = $subdiv_code;
                $chitha_pattadar['cir_code'] = $cir_code;
                $chitha_pattadar['lot_no'] = $lot_no;
                $chitha_pattadar['mouza_pargona_code'] = $mouza_pargona_code;
                $chitha_pattadar['vill_townprt_code'] = $vill_code;

                $chitha_pattadar['pdar_id'] = $occ->pdar_id;
                $chitha_pattadar['new_pdar_name'] = $occ->new_pattadar;
                $chitha_pattadar['patta_type_code'] = $occ->patta_type_code;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_father'] = $occ->occupant_fmh_name;
                $chitha_pattadar['pdar_add1'] = $occ->occupant_add1;
                $chitha_pattadar['pdar_add2'] = $occ->occupant_add2;
                $chitha_pattadar['pdar_add3'] = $occ->occupant_add3;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_guard_reln'] = $occ->occupant_fmh_flag;
                $chitha_pattadar['user_code'] = $this->session->userdata('user_code');
                $chitha_pattadar['date_entry'] = date('Y-m-d G:i:s');
                $chitha_pattadar['operation'] = date('E');
                $chitha_pattadar['jama_yn'] = 'N';
                //newly added aadhaar details to chitha pattadar----
                $flagAadhaar = null;
                $flagPan = null;
                if($occ->auth_type == 'AADHAAR'){
                    $chitha_pattadar['pdar_aadharno'] = $occ->id_ref_no;
                    $flagAadhaar = $occ->id_ref_no;
                    $flagPan = null;
                }else if($occ->auth_type == 'PAN'){
                    $chitha_pattadar['pdar_pan_no'] = $occ->id_ref_no;
                    $flagAadhaar = null;
                    $flagPan = $occ->id_ref_no;
                }
                // $chitha_pattadar['pdar_photo'] = $occ->photo;
                //end-----------
                //var_dump($chitha_pattadar);
                //var_dump($dag_pattadar);
                $chitha_basic_query = "select land_class_code from   chitha_basic "
                        . "where dist_code='$dist_code' and subdiv_code='$subdiv_code' and"
                        . " cir_code='$cir_code' and lot_no='$lot_no' and"
                        . " mouza_pargona_code='$mouza_pargona_code' and TRIM(patta_no)=trim('$occ->new_patta_no') and"
                        . " patta_type_code='$occ->patta_type_code' and dag_no='$dag_no'";
                //echo($chitha_basic_query);
                $result = $this->db->query($chitha_basic_query);
                if($result == null || $result->num_rows() <=0 )
                {
                    $this->db->trans_rollback();
                    log_message("error","#FPLCCO013 Data not available in land_class_code for dist:"
                                .$dist_code.", petition no: ". $this->db->last_query());
                    $this->session->set_flashdata('message', "FPLCCO013: Unable to pass order !");
                    redirect(base_url() . "index.php/home");
                    return;
                }
                $result = $result->row();
                //var_dump($ord);
                $chitha_basic = array();
                $chitha_basic['dist_code'] = $dist_code;
                $chitha_basic['subdiv_code'] = $subdiv_code;
                $chitha_basic['cir_code'] = $cir_code;
                $chitha_basic['mouza_pargona_code'] = $mouza_pargona_code;
                $chitha_basic['lot_no'] = $lot_no;
                $chitha_basic['vill_townprt_code'] = $vill_code;
                $chitha_basic['dag_area_b'] = $ord->mut_land_area_b;
                $chitha_basic['dag_area_k'] = $ord->mut_land_area_k;
                $chitha_basic['dag_area_lc'] = $ord->mut_land_area_lc;
                $chitha_basic['dag_area_g'] = $ord->mut_land_area_g;
                $chitha_basic['dag_area_kr'] = $ord->mut_land_area_kr;
                $chitha_basic['user_code'] = $this->session->userdata('user_code');
                $chitha_basic['date_entry'] = date('Y-m-d G:i:s');
                $chitha_basic['land_class_code'] = $result->land_class_code;

                //var_dump($chitha_basic);
                if ($ord->order_type_code == '02') {
                    $old_dag = $dag_no;

                    $chitha_basic['dag_no'] = $occ->new_dag_no;
                    $chitha_basic['dag_no_int'] = $occ->new_dag_no . '00';
                    $chitha_basic['old_dag_no '] = $dag_no;
                    $old_patta = trim($occ->patta_no);
                    $chitha_basic['patta_no'] = trim($occ->new_patta_no);
                    $q = "update chitha_col8_order set new_dag_no='$occ->new_dag_no' where "
                            . "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                            . " mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and"
                            . " vill_townprt_code='$vill_code' and col8order_cron_no=$col8order_cron_no";
                    $this->db->query($q); //***********************
                    if($this->db->affected_rows() <= 0 )
                    {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "FPCCO014: Unable to pass order !");
                        log_message("error","#FPCCO014 Updation failed in chitha_col8_order for dist:"
                                    .$dist_code.", petition no: ". $this->db->last_query());
                        redirect(base_url() . "index.php/home");
                        return;
                    }
                } else {
                    $chitha_basic['dag_no'] = $dag_no;

                    $q = "select dag_no_int as dag_no_int from   chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'" .
                            " and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$occ->patta_type_code' and TRIM(patta_no)=trim('$occ->patta_no')";

                    $dag_no_int = $this->db->query($q)->row()->dag_no_int;

                    $chitha_basic['dag_no_int'] = $dag_no_int;
                    $chitha_basic['patta_no'] = trim($occ->patta_no);
                }
                $chitha_basic['patta_type_code'] = $occ->patta_type_code;

                $chitha_basic['operation'] = "E";
                //var_dump($chitha_basic);
                //var_dump($dag_pattadar);
                $corrected = date('Y-m-d G:i:s');
                if ((!$chitha_basic_update) && ($ord->order_type_code == '02')) {

                    $chitha_basic_update = TRUE;
                    // $update_for_old_jama="Update chitha_basic set jama_yn=null where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                    //         . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                    //         . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                    //         . " and TRIM(patta_no)=trim('$occ->patta_no') and"
                    //         . " patta_type_code='$occ->patta_type_code' ";

                    // $this->db->query($update_for_old_jama); //*******************
                    // if($this->db->affected_rows() <= 0 )
                    // {
                    //     $this->db->trans_rollback();
                    //     $this->session->set_flashdata('message', "FPCBO015: Unable to pass order !");
                    //     log_message("error","#FPCBO015 Failed to update jama_yn=null in chitha_basic for dist:"
                    //                 .$dist_code.", petition no: ". $petition_no);
                    //     redirect(base_url() . "index.php/home");
                    //     return;
                    // }
                    
                    $sql = "select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,dag_revenue from chitha_basic where"
                            . "  dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                            . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                            . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                            . " and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->new_patta_no') and"
                            . " patta_type_code='$occ->patta_type_code' ";
                    //echo $sql;
                    $data = $this->db->query($sql)->row();

                    if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                    $chitha_basic['dag_revenue'] = $ord->min_revenue * (($ord->mut_land_area_b * 6400 + $ord->mut_land_area_k * 320 + $ord->mut_land_area_lc*20 + $ord->mut_land_area_g) / 100.0);
                    }

                    else{
                    $chitha_basic['dag_revenue'] = $ord->min_revenue * (($ord->mut_land_area_b * 100 + $ord->mut_land_area_k * 20 + $ord->mut_land_area_lc) / 100.0);

                    }
                    $chitha_basic['dag_local_tax'] = $chitha_basic['dag_revenue'] / 4.0;
                    //$this->db->insert('chitha_basic', $chitha_basic); //********************************* not required

                    $dataNew['dag_no'] = $chitha_basic['dag_no'];

                    if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                    $sourcelessa = $data->dag_area_b * 6400 + $data->dag_area_k * 320 + $data->dag_area_lc * 20 + $data->dag_area_g;
                    $mutationlessa = $ord->mut_land_area_b * 6400 + $ord->mut_land_area_k * 320 + $ord->mut_land_area_lc * 20 + $ord->mut_land_area_g;
                    $sourcelessa;
                    $mutationlessa;
                    $remaining_lessa = $sourcelessa - $mutationlessa;

                    $left_b = floor($remaining_lessa / 6400);
                    $left_k = floor(($remaining_lessa - $left_b * 6400) / 320);
                    $left_lc = floor(($remaining_lessa - $left_b * 6400 - $left_k * 320)/20 );
                    $left_g = $remaining_lessa - $left_b * 6400 - $left_k * 320 - $left_lc * 20;
                    $left_kr = 0;

                    }
                    else{

                    $sourcelessa = $data->dag_area_b * 100 + $data->dag_area_k * 20 + $data->dag_area_lc;
                    $mutationlessa = $ord->mut_land_area_b * 100 + $ord->mut_land_area_k * 20 + $ord->mut_land_area_lc;
                    $sourcelessa;
                    $mutationlessa;
                    $remaining_lessa = $sourcelessa - $mutationlessa;

                    $left_b = floor($remaining_lessa / 100);
                    $left_k = floor(($remaining_lessa - $left_b * 100) / 20);
                    $left_lc = $remaining_lessa - $left_b * 100 - $left_k * 20;
                    $left_g = 0;
                    $left_kr = 0;
                    }
     
                    $d = date('Y-m-d G:i:s');

                    $dag_revenue_updates = $data->dag_revenue; //$ord->min_revenue; // * (($left_b * 100 + $left_k * 20 + $left_lc));
                    //$old_patta_no = $data->dag_revenue;
                    if ($dag_revenue_updates == null) {
                        $dag_revenue_updates = 0;
                    }
                    $dag_local_tax_update = $dag_revenue_updates / 4;
                    // $sql = "update chitha_basic set jama_yn=null,dag_revenue=$dag_revenue_updates,dag_local_tax=$dag_local_tax_update, "
                    //         . " dag_area_b='$ord->mut_land_area_b',dag_area_k='$ord->mut_land_area_k',dag_area_lc='$ord->mut_land_area_lc',"
                    //         . " dag_area_g=$left_g,dag_area_kr=$left_kr,date_entry='$d',operation='M' "
                    //         . " where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                    //         . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                    //         . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                    //         . " and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->new_patta_no') and"
                    //         . " patta_type_code='$occ->patta_type_code' ";

                    // $this->db->query($sql); //*******************
                    //$this->db->last_query();

                    $table = 'chitha_basic';

                    $params = [
                        'jama_yn'        => null,
                        'dag_revenue'    => $dag_revenue_updates,
                        'dag_local_tax'  => $dag_local_tax_update,
                        'dag_area_b'     => $ord->mut_land_area_b,
                        'dag_area_k'     => $ord->mut_land_area_k,
                        'dag_area_lc'    => $ord->mut_land_area_lc,
                        'dag_area_g'     => $left_g,
                        'dag_area_kr'    => $left_kr,
                        'date_entry'     => $d,
                        'operation'      => 'M',
                    ];

                    $where = [
                        'dist_code'          => $occ->dist_code,
                        'subdiv_code'        => $occ->subdiv_code,
                        'cir_code'           => $occ->cir_code,
                        'mouza_pargona_code' => $occ->mouza_pargona_code,
                        'lot_no'             => $occ->lot_no,
                        'vill_townprt_code'  => $occ->vill_townprt_code,
                        'dag_no'             => $occ->dag_no,
                        'patta_no'           => trim($occ->new_patta_no),
                        'patta_type_code'    => $occ->patta_type_code,
                    ];

                    // Then update like this:
                    $result3 = $this->Chitha_basic_model->update_table($table, $params, $where);

                   
                    if($result3 <= 0 )
                    {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "FPCBO016: Unable to pass order !");
                        log_message("error","#FPCBO016 Failed to update jama_yn=null in chitha_basic for dist:"
                                    .$dist_code.", petition no: ". $petition_no);
                        redirect(base_url() . "index.php/home");
                        return;
                    }
                }
                $p_id = $occ->pdar_id;
                $q = "select count(*) as count from   chitha_dag_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                        . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                        . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                        . " and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->patta_no') and"
                        . " patta_type_code='$occ->patta_type_code'";// and pdar_id=$p_id";
                //echo $q;
                $cDagPattadarExists = $this->db->query($q)->row()->count;
                
                $q = "select count(*) as count from   chitha_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                        . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                        . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                        . " and TRIM(patta_no)=trim('$occ->new_patta_no') and"
                        . " patta_type_code='$occ->patta_type_code' and pdar_id=$p_id";
                //echo $q;
                $cPattadarExists = $this->db->query($q)->row()->count;
                
                $occ->new_pattadar;
                
                //update chitha_dag_pattadar
                // $update_pattadar = "Update chitha_dag_pattadar set patta_no='$occ->new_patta_no', p_flag ='0',jama_yn='n' where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                //         . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                //         . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                //         . " and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->patta_no') and"
                //         . " patta_type_code='$occ->patta_type_code' and pdar_id=$p_id ";
                // //echo $update_pattadar;
                // $this->db->query($update_pattadar); //*******************
                //insert in chitha_pattadar

                $table = 'chitha_dag_pattadar';

                $params = [
                    'patta_no' => $occ->new_patta_no,
                    'p_flag'   => '0',
                    'jama_yn'  => 'n',
                ];

                $where = [
                    'dist_code'          => $occ->dist_code,
                    'subdiv_code'        => $occ->subdiv_code,
                    'cir_code'           => $occ->cir_code,
                    'mouza_pargona_code' => $occ->mouza_pargona_code,
                    'lot_no'             => $occ->lot_no,
                    'vill_townprt_code'  => $occ->vill_townprt_code,
                    'dag_no'             => $occ->dag_no,
                    'patta_no'           => trim($occ->patta_no),  // trim in PHP
                    'patta_type_code'    => $occ->patta_type_code,
                    'pdar_id'            => $p_id,
                ];

                // Then you can call the update function:
                $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                if($result <=0 )
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "FPCDP017: Unable to pass order !");
                    log_message("error","#FPCDP017 Updation failed in chitha_dag_pattadar for dist:"
                                .$dist_code.", petition no: ". $petition_no);
                    redirect(base_url() . "index.php/home");
                    return;
                }
                
                if($cPattadarExists ==0)
                {
                    //var_dump ($chitha_pattadar);
                    // $tstatus_pat = $this->db->insert("chitha_pattadar", $chitha_pattadar); // ********************
                    $chitha_pattadar['f1_case_no']=$case_no;
                    $tstatus_pat = $this->Chitha_basic_model->insert_table('chitha_pattadar',$chitha_pattadar);
                    if($tstatus_pat != 1 )
                    {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "#FPCP0017: Unable to pass order !");
                        log_message("error","#FPCP0017 Failed to insert chitha_pattadar for dist:"
                                .$dist_code.", petition no: ". $petition_no);
                        redirect(base_url() . "index.php/home");
                        return;
                    }
                }
               // exit;
                $today = date('Y-m-d');
                $t_occup_query = "update t_chitha_col8_occup set iscorrected_inco='Y',iscorrected_inco_date='$corrected',order_passed='Y' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                        . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                        . "vill_townprt_code='$vill_code' and petition_no=$petition_no and dag_no='$dag_no' ";
                $this->db->query($t_occup_query); // ********************
                if($this->db->affected_rows() <=0 )
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "FPTCC018: Unable to pass order !");
                    log_message("error","#FPTCC018 Failed to update iscorrected_inco in t_chitha_col8_occup for dist:"
                                .$dist_code.", petition no: ". $petition_no);
                    redirect(base_url() . "index.php/home");
                    return;
                }
            }
        }
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            //$this->db->trans_commit();
            $order_update_query = "update field_mut_basic set order_passed='Y' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                    . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                    . "vill_townprt_code='$vill_code' and petition_no='$petition_no'";
            $this->db->query($order_update_query);
            if($this->db->affected_rows() <=0 )
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "FPFINAL001: Unable to pass order !");
                log_message("error","#FPFINAL001 Failed to update order_passed in field_mut_basic for dist:"
                            .$dist_code.", petition no: ". $petition_no);
                redirect(base_url() . "index.php/home");
                return;
            }
            return true;
        }
    }

    public function autoUpdateForField($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, 
        $lot_no, $vill_code, $petition_no, $dag_no)
    {
        //$db=  $this->session->userdata('db');
        $locationData = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'lot_no' => $lot_no,
            'vill_code' => $vill_code,
            'mouza_pargona_code' => $mouza_pargona_code,
        );
        //var_dump($locationData);
        $year_no = year_no;

        $col8order_cron_no = $this->db->query("select max(col8order_cron_no)+1 as cron_no from   chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and dag_no='$dag_no'")->row()->cron_no;
        // /echo $this->db->last_query(); return;
        if ($col8order_cron_no == null) {
            $col8order_cron_no = 1;
        }
        
        $t_order_data_query = "select * from   t_chitha_col8_order where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and "
                . "mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and petition_no='$petition_no' and dag_no='$dag_no'";// and iscorrected_inco is null";
        $t_data_order = $this->db->query($t_order_data_query);
        
        if ($t_data_order == null || $t_data_order->num_rows() <=0)
        {
            $this->db->trans_rollback();
            log_message("error","#ERR001 No data found in t_chitha_col8_order with district: ".$dist_code.", petition_no: ". $petition_no);
            return false;
        }
        $t_data_order = $t_data_order->result();
        //var_dump($t_data_order);
        $case_no = null;
        foreach ($t_data_order as $ord) {
            $case_no = $ord->case_no;
            $data_order = array();
            foreach ($ord as $key => $value) {
                $data[$key] = $value;
            }
            $data['col8order_cron_no'] = $col8order_cron_no;
            $data['user_code'] = $this->session->userdata('user_code');
            $data['date_entry'] = date('Y-m-d G:i:s');
            $data['operation'] = date('E');
            unset($data['year_no']);
            unset($data['petition_no']);
            unset($data['iscorrected_inco']);
            unset($data['iscorrected_inco_date']);
            unset($data['isdataposted_torkg_db']);
            unset($data['iscorrected_rkg_record']);
            unset($data['iscorrected_rkg_date']);
            unset($data['order_passed']);
            unset($data['date_of_order']);
            unset($data['make_mdb']);
            unset($data['date_of_order']);
            unset($data['not_consistent']);
            $corrected = date('Y-m-d G:i:s');
            $dataNew = $data;
            $tstatus1=$this->db->insert("chitha_col8_order", $data); //************************************************************************************************ insert query
            if ($tstatus1 != 1 )
            {
                $this->db->trans_rollback();
                log_message("error"," #ERR002 could not insert chitha_col8_order with district: ".$dist_code.", petition_no: ". $petition_no);
                return false;
            }

            //Checking for occupents
            $t_occup_query = "select * from   t_chitha_col8_occup where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and "
                    . "mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and petition_no=$petition_no and dag_no='$dag_no'";// and iscorrected_inco is null";
            $t_occup_data = $this->db->query($t_occup_query);
            if ($t_occup_data == null || $t_occup_data->num_rows() <=0)
            {
                $this->db->trans_rollback();
                log_message("error","#ERR003 No data found in t_chitha_col8_occup with district: ".$dist_code.", petition_no: ". $petition_no);
                return false;
            }
            $t_occup_data = $t_occup_data->result();

            //updating t_chitha_col8_order iscorrected_inco status
            // $update_query = "update t_chitha_col8_order  set iscorrected_inco='Y',iscorrected_inco_date='$corrected' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
            //         . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and petition_no=$petition_no and "
            //         . "dag_no='$dag_no' ";
            // $this->db->query($update_query); //
            // echo $this->db->last_query();
            // echo $this->db->affected_rows();
            // die();
            // if ($this->db->affected_rows()<=0 )
            // {
            //     $this->db->trans_rollback();
            //     log_message("error","#ERR004 Could not update iscorrected_inco in t_chitha_col8_order with district: ".$dist_code.", petition_no: ". $petition_no);
            //     return false;
            // }                                
                       
            $chitha_basic_update = FALSE;
            // occupants details starts here
            foreach ($t_occup_data as $occ) {
                
                // $sql = "update chitha_basic set jama_yn=null where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' and "
                //         . "mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' and dag_no='$occ->dag_no' "
                //         . "and TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' ";
                // $this->db->query($sql); //************************************************************************************************ update query

                $table = 'chitha_basic';

                $params = [
                    'jama_yn' => null,
                ];

                $where = [
                    'dist_code'          => $occ->dist_code,
                    'subdiv_code'        => $occ->subdiv_code,
                    'cir_code'           => $occ->cir_code,
                    'mouza_pargona_code' => $occ->mouza_pargona_code,
                    'lot_no'             => $occ->lot_no,
                    'vill_townprt_code'  => $occ->vill_townprt_code,
                    'dag_no'             => $occ->dag_no,
                    'patta_no'           => trim($occ->patta_no),
                    'patta_type_code'    => $occ->patta_type_code,
                ];

                // Assuming your model has a method like update_table($table, $params, $where)
                $result4 = $this->Chitha_basic_model->update_table($table, $params, $where);

                if ($result4 <= 0 )
                {
                    $this->db->trans_rollback();
                    log_message("error","#ERR005 Could not update jama_yn in chitha_basic with district: ".$dist_code.", petition_no: ". $petition_no);
                    return false;
                }  
                
                $data = array();
                foreach ($occ as $key => $value) {
                    $data[$key] = $value;
                }
                unset($data['year_no']);
                unset($data['petition_no']);
                unset($data['iscorrected_inco']);
                unset($data['iscorrected_inco_date']);
                unset($data['isdataposted_torkg_db']);
                unset($data['iscorrected_rkg_record']);
                unset($data['iscorrected_rkg_date']);
                unset($data['order_passed']);
                unset($data['date_of_order']);
                unset($data['make_mdb']);
                unset($data['date_of_order']);
                unset($data['patta_type_code']);
                unset($data['patta_no']);
                unset($data['pdar_id']);
                unset($data['revenue']);
                unset($data['new_pattadar']);
                $data['col8order_cron_no'] = $col8order_cron_no;
                $data['user_code'] = $this->session->userdata('user_code');
                $data['date_entry'] = date('Y-m-d G:i:s');
                $data['operation'] = date('E');
                $occupData = $data;
                //var_dump($data);
                
                $tstatus2 = $this->db->insert("chitha_col8_occup", $data); //************************************************************************************************ insert query
                if ($tstatus2 != 1 )
                {
                    $this->db->trans_rollback();
                    log_message("error","#ERR006 Could not insert in chitha_col8_occup with district: ".$dist_code.", petition_no: ". $petition_no);
                    return false;
                }

                $dag_pattadar = array();
                $chitha_pattadar = array();

                $pdar_id = $occ->pdar_id;
                
                if ($ord->order_type_code == '02') {
                    // Order Type Code 02 iIs For Field Partition. and 01 is For Field Mutation
                   $pdar_id = $this->Chitha_basic_model->maxpdarIdCheck($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_code,$occ->patta_type_code,trim($occ->new_patta_no));
                }
                if ($pdar_id == null) {
                    $pdar_id = 1;
                }
                //echo $pdar_id;
                $dag_pattadar['dist_code'] = $dist_code;
                $dag_pattadar['subdiv_code'] = $subdiv_code;
                $dag_pattadar['cir_code'] = $cir_code;
                $dag_pattadar['lot_no'] = $lot_no;
                $dag_pattadar['mouza_pargona_code'] = $mouza_pargona_code;
                $dag_pattadar['vill_townprt_code'] = $vill_code;
                
                if ($ord->order_type_code == '02') {
                    $dag_pattadar['dag_no'] = $occ->new_dag_no;
                    $newDag = $this->utilityclass->maxdag($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_code);
                    if($newDag < $occ->new_dag_no){
                        $this->db->trans_rollback();
                        log_message("error","#ERR00001212 Kindly Check the New Dag no you have Assigned ($occ->new_dag_no) ####  ". $petition_no);
                        return false;
                    }
                } else {
                    $dag_pattadar['dag_no'] = $dag_no;
                }
                if (($occ->pdar_id) && (!($ord->order_type_code == '02'))) {
                    $dag_pattadar['pdar_id'] = $occ->pdar_id;
                } else {
                    $dag_pattadar['pdar_id'] = $pdar_id;
                }
                
                if ($ord->order_type_code == '02') {
                    $dag_pattadar['patta_no'] = trim($occ->new_patta_no);
                    $chitha_pattadar['patta_no'] = trim($occ->new_patta_no);
                } else {
                    $dag_pattadar['patta_no'] = trim($occ->patta_no);
                    $chitha_pattadar['patta_no'] = trim($occ->patta_no);
                }
                $dag_pattadar['p_flag'] = '0';
                $dag_pattadar['patta_type_code'] = $occ->patta_type_code;
                $dag_pattadar['dag_por_b'] = $occ->land_area_b;
                $dag_pattadar['dag_por_k'] = $occ->land_area_k;
                $dag_pattadar['dag_por_lc'] = $occ->land_area_lc;
                $dag_pattadar['dag_por_g'] = $occ->land_area_g;
                $dag_pattadar['dag_por_kr'] = $occ->land_area_kr;

                $dag_pattadar['user_code'] = $this->session->userdata('user_code');
                $dag_pattadar['date_entry'] = date('Y-m-d G:i:s');
                $dag_pattadar['operation'] = date('E');

                $chitha_pattadar['dist_code'] = $dist_code;
                $chitha_pattadar['subdiv_code'] = $subdiv_code;
                $chitha_pattadar['cir_code'] = $cir_code;
                $chitha_pattadar['lot_no'] = $lot_no;
                $chitha_pattadar['mouza_pargona_code'] = $mouza_pargona_code;
                $chitha_pattadar['vill_townprt_code'] = $vill_code;

                $chitha_pattadar['pdar_id'] = $pdar_id;
                $chitha_pattadar['new_pdar_name'] = $occ->new_pattadar;
                $chitha_pattadar['patta_type_code'] = $occ->patta_type_code;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_father'] = $occ->occupant_fmh_name;
                $chitha_pattadar['pdar_add1'] = $occ->occupant_add1;
                $chitha_pattadar['pdar_add2'] = $occ->occupant_add2;
                $chitha_pattadar['pdar_add3'] = $occ->occupant_add3;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_name'] = $occ->occupant_name;
                $chitha_pattadar['pdar_guard_reln'] = $occ->occupant_fmh_flag;
                $chitha_pattadar['user_code'] = $this->session->userdata('user_code');
                $chitha_pattadar['date_entry'] = date('Y-m-d G:i:s');
                $chitha_pattadar['operation'] = date('E');
                $chitha_pattadar['jama_yn'] = 'N';
                //newly added aadhaar details to chitha pattadar----
                $flagAadhaar = null;
                $flagPan = null;
                if($occ->auth_type == 'AADHAAR'){
                    $chitha_pattadar['pdar_aadharno'] = $occ->id_ref_no;
                    $flagAadhaar = $occ->id_ref_no;
                    $flagPan = null;
                }else if($occ->auth_type == 'PAN'){
                    $chitha_pattadar['pdar_pan_no'] = $occ->id_ref_no;
                    $flagAadhaar = null;
                    $flagPan = $occ->id_ref_no;
                }
                // $chitha_pattadar['pdar_photo'] = $occ->photo;
                //end-----------


                $chitha_basic_query = "select land_class_code from   chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' "
                        . "and mouza_pargona_code='$mouza_pargona_code' and TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' and dag_no='$dag_no'";
                $result = $this->db->query($chitha_basic_query)->row();
                
                $chitha_basic = array();
                $chitha_basic['dist_code'] = $dist_code;
                $chitha_basic['subdiv_code'] = $subdiv_code;
                $chitha_basic['cir_code'] = $cir_code;
                $chitha_basic['mouza_pargona_code'] = $mouza_pargona_code;
                $chitha_basic['lot_no'] = $lot_no;
                $chitha_basic['vill_townprt_code'] = $vill_code;
                $chitha_basic['dag_area_b'] = $ord->mut_land_area_b;
                $chitha_basic['dag_area_k'] = $ord->mut_land_area_k;
                $chitha_basic['dag_area_lc'] = $ord->mut_land_area_lc;
                $chitha_basic['dag_area_g'] = $ord->mut_land_area_g;
                $chitha_basic['dag_area_kr'] = $ord->mut_land_area_kr;
                $chitha_basic['user_code'] = $this->session->userdata('user_code');
                $chitha_basic['date_entry'] = date('Y-m-d G:i:s');
                $chitha_basic['land_class_code'] = $result->land_class_code;

                //Partition to new dag
                if ($ord->order_type_code == '02') {
                    $old_dag = $dag_no;
                    $chitha_basic['dag_no'] = $occ->new_dag_no;
                    $chitha_basic['dag_no_int'] = $occ->new_dag_no . '00';
                    $chitha_basic['old_dag_no '] = $dag_no;
                    $old_patta = trim($occ->old_patta_no);
                    $chitha_basic['patta_no'] = trim($occ->new_patta_no);
                    
                    $q = "update chitha_col8_order set new_dag_no='$occ->new_dag_no' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                            . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and col8order_cron_no=$col8order_cron_no and dag_no='$dag_no' ";
                    $this->db->query($q); //************************************************************************************************ update query
                    if ($this->db->affected_rows()<=0 )
                    {
                        $this->db->trans_rollback();
                        log_message("error","#ERR007 Could not update new_dag_no in chitha_col8_order with district: ".$dist_code.", petition_no: ". $petition_no);
                        return false;
                    } 
                } else {
                    $chitha_basic['dag_no'] = $dag_no;

                    $q = "select dag_no_int as dag_no_int from   chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                            . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$occ->patta_type_code' and "
                            . "TRIM(patta_no)=trim('$occ->patta_no')";
                    $dag_no_int = $this->db->query($q)->row()->dag_no_int;

                    $chitha_basic['dag_no_int'] = $dag_no_int;
                    $chitha_basic['patta_no'] = trim($occ->patta_no);
                }
                
                $chitha_basic['patta_type_code'] = $occ->patta_type_code;
                $chitha_basic['operation'] = "E";
                //var_dump($dag_pattadar);
                
                $corrected = date('Y-m-d G:i:s');
                if ((!$chitha_basic_update) && ($ord->order_type_code == '02')) {
                    // This Block Is For Field Partition
                    $chitha_basic_update = TRUE;
                    $sql = "select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,dag_revenue from   chitha_basic where dist_code='$occ->dist_code' and "
                            . "subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' and mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and "
                            . "vill_townprt_code='$occ->vill_townprt_code' and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' ";
                    $data = $this->db->query($sql)->row();

                    ////// BARAK VALLEY CODE START ////////////
                    if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                    $chitha_basic['dag_revenue'] = $ord->min_revenue * (($ord->mut_land_area_b * 6400 + $ord->mut_land_area_k * 320 + $ord->mut_land_area_lc*20 + $ord->mut_land_area_g) / 100.0);
                    }

                    else{
                    $chitha_basic['dag_revenue'] = $ord->min_revenue * (($ord->mut_land_area_b * 100 + $ord->mut_land_area_k * 20 + $ord->mut_land_area_lc) / 100.0);

                    }
                    
                    
                    $chitha_basic['dag_local_tax'] = $chitha_basic['dag_revenue'] / 4.0;
                    
                    // $tstatus_ch = $this->db->insert("chitha_basic", $chitha_basic); //************************************************************************************************ insert query
                    $tstatus_ch = $this->Chitha_basic_model->insert_table('chitha_basic',$chitha_basic);

                    if ($tstatus_ch != 1 )
                    {
                        $this->db->trans_rollback();
                        log_message("error","#ERR008 Could not insert in chitha_basic with district: ".$dist_code.", petition_no: ". $petition_no);
                        return false;
                    }
                    

                    $dataNew['dag_no'] = $chitha_basic['dag_no'];
                    $tstatus_ord = $this->db->insert("chitha_col8_order", $dataNew); //************************************************************************************************ insert query
                    if ($tstatus_ord != 1 )
                    {
                        $this->db->trans_rollback();
                        log_message("error","#ERR009 Could not insert in chitha_col8_order with district: ".$dist_code.", petition_no: ". $petition_no);
                        return false;
                    }


                    if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                    $sourcelessa = $data->dag_area_b * 6400 + $data->dag_area_k * 320 + $data->dag_area_lc * 20 + $data->dag_area_g;
                    $mutationlessa = $ord->mut_land_area_b * 6400 + $ord->mut_land_area_k * 320 + $ord->mut_land_area_lc * 20 + $ord->mut_land_area_g;
                    $remaining_lessa = $sourcelessa - $mutationlessa;

                    $left_b = floor($remaining_lessa / 6400);
                    $left_k = floor(($remaining_lessa - $left_b * 6400) / 320);
                    $left_lc = floor(($remaining_lessa - $left_b * 6400 - $left_k * 320)/20);
                    $left_g = $remaining_lessa - $left_b * 6400 - $left_k * 320 - $left_lc * 20;
                    $left_kr = 0;
                    }

                    else{
                    $sourcelessa = $data->dag_area_b * 100 + $data->dag_area_k * 20 + $data->dag_area_lc;
                    $mutationlessa = $ord->mut_land_area_b * 100 + $ord->mut_land_area_k * 20 + $ord->mut_land_area_lc;
                    $remaining_lessa = $sourcelessa - $mutationlessa;

                    $left_b = floor($remaining_lessa / 100);
                    $left_k = floor(($remaining_lessa - $left_b * 100) / 20);
                    $left_lc = $remaining_lessa - $left_b * 100 - $left_k * 20;
                    $left_g = 0;
                    $left_kr = 0;
                    }
                    
                    $d = date('Y-m-d G:i:s');

                    $dag_revenue_updates = $data->dag_revenue; 
                    
                    if ($dag_revenue_updates == null) {
                        $dag_revenue_updates = 0;
                    }
                    $dag_local_tax_update = $dag_revenue_updates / 4;
                    // $sql = "update chitha_basic set jama_yn=null,dag_revenue=$dag_revenue_updates,dag_local_tax=$dag_local_tax_update,dag_area_b=$left_b,dag_area_k=$left_k,"
                    //         . "dag_area_lc=$left_lc,dag_area_g=$left_g,dag_area_kr=$left_kr,date_entry='$d',operation='M' where dist_code='$occ->dist_code' and "
                    //         . "subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' and mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and "
                    //         . "vill_townprt_code='$occ->vill_townprt_code' and dag_no='$occ->dag_no' and TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' ";
                    // $this->db->query($sql); //************************************************************************************************ update query

                    $table = 'chitha_basic';

                    $params = [
                        'jama_yn'       => null,
                        'dag_revenue'   => $dag_revenue_updates,
                        'dag_local_tax' => $dag_local_tax_update,
                        'dag_area_b'    => $left_b,
                        'dag_area_k'    => $left_k,
                        'dag_area_lc'   => $left_lc,
                        'dag_area_g'    => $left_g,
                        'dag_area_kr'   => $left_kr,
                        'date_entry'    => $d,
                        'operation'     => 'M',
                    ];

                    $where = [
                        'dist_code'          => $occ->dist_code,
                        'subdiv_code'        => $occ->subdiv_code,
                        'cir_code'           => $occ->cir_code,
                        'mouza_pargona_code' => $occ->mouza_pargona_code,
                        'lot_no'             => $occ->lot_no,
                        'vill_townprt_code'  => $occ->vill_townprt_code,
                        'dag_no'             => $occ->dag_no,
                        'patta_no'           => trim($occ->patta_no),
                        'patta_type_code'    => $occ->patta_type_code,
                    ];

                    // Call your model method to update
                    $result5 = $this->Chitha_basic_model->update_table($table, $params, $where);

                    if ($result5 <= 0 )
                    {
                        $this->db->trans_rollback();
                        log_message("error","#ERR010 Could not update  jama_yn=null in chitha_basic with district: ".$dist_code.", petition_no: ". $petition_no);
                        return false;
                    } 
                }
                
                $p_id = $dag_pattadar['pdar_id'];
                
                if ($ord->order_type_code == '02') {
                    // This Block Is For Field Partition
                    $q = "select count(*) as count from   chitha_dag_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' "
                            . "and mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' and dag_no='$occ->dag_no' "
                            . "and TRIM(patta_no)=trim('$occ->new_patta_no') and patta_type_code='$occ->patta_type_code' and pdar_id='$p_id'";
                    $cDagPattadarExists = $this->db->query($q)->row()->count;

                    $q = "select count(*) as count from   chitha_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code'"
                            . " and mouza_pargona_code='$occ->mouza_pargona_code' and"
                            . " lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' "
                            . " and TRIM(patta_no)=trim('$occ->new_patta_no') and"
                            . " patta_type_code='$occ->patta_type_code' and pdar_id='$p_id'";
                    $cPattadarExists = $this->db->query($q)->row()->count;
                } else {
                    // This Block Is For Field Mutation
                    $q = "select count(*) as count from   chitha_dag_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' "
                            . "and mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' and dag_no='$occ->dag_no' "
                            . "and TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' and pdar_id='$p_id'";
                    $cDagPattadarExists = $this->db->query($q)->row()->count;

                    $q = "select count(*) as count from   chitha_pattadar  where dist_code='$occ->dist_code' and subdiv_code='$occ->subdiv_code' and cir_code='$occ->cir_code' and "
                            . "mouza_pargona_code='$occ->mouza_pargona_code' and lot_no='$occ->lot_no' and vill_townprt_code='$occ->vill_townprt_code' and "
                            . "TRIM(patta_no)=trim('$occ->patta_no') and patta_type_code='$occ->patta_type_code' and pdar_id='$p_id'";
                    $cPattadarExists = $this->db->query($q)->row()->count;
                }
                //var_dump($dag_pattadar);
                $occ->new_pattadar; // for partition it will always be new pattadar
                if (($occ->new_pattadar=='N')){
                    //var_dump($dag_pattadar);
                    //var_dump($chitha_pattadar);
                    // $tstatus3 = $this->db->insert("chitha_dag_pattadar", $dag_pattadar);//************************************************* insert query
                    $tstatus3 = $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$dag_pattadar);
                    if ($tstatus3 != 1 )
                    {
                        $this->db->trans_rollback();
                        log_message("error","#ERR011 Could not insert in  chitha_dag_pattadar with district: ".$dist_code.", petition_no: ". $petition_no);
                        return false;
                    }
                    if(($cPattadarExists == 0)){
                        // $tstatus4 = $this->db->insert("chitha_pattadar", $chitha_pattadar);//************************************************************************************************ insert query
                        $chitha_pattadar['f1_case_no']=$case_no;
                        $tstatus4 = $this->Chitha_basic_model->insert_table('chitha_pattadar',$chitha_pattadar);
                        if ($tstatus4 != 1 )
                        {
                            $this->db->trans_rollback();
                            log_message("error","#ERR012 Could not insert in  chitha_pattadar with district: ".$dist_code.", petition_no: ". $petition_no);
                            return false;
                        }
                    }
                }
                $today = date('Y-m-d');
                $t_occup_query = "update t_chitha_col8_occup set iscorrected_inco='Y',iscorrected_inco_date='$corrected',order_passed='Y' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                        . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                        . "vill_townprt_code='$vill_code' and petition_no=$petition_no and dag_no='$dag_no' ";
                $this->db->query($t_occup_query);//*********************************************************************************** update query
                if ($this->db->affected_rows()<=0 )
                {
                    $this->db->trans_rollback();
                    log_message("error","#ERR013 Could not update iscorrected_inco in t_chitha_col8_occup with district: ".$dist_code
                                .", petition_no: ". $petition_no);
                    return false;
                } 
            }
            // occupants details ends here

            if ($ord->order_type_code == '02') {
                foreach ($t_occup_data as $occup) {
                    // $sql = "update chitha_dag_pattadar set p_flag='1' where   dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and "
                    //         . "mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and dag_no='$dag_no' and pdar_id=$occup->pdar_id";
                    // $this->db->query($sql);//************************************************************************************************ update query
                    $sqlCheck="Select * from chitha_dag_pattadar where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? and pdar_id=? and (p_flag is null or p_flag!='1') ";
                    $cdpCheck_12=$this->db->query($sqlCheck,[$occ->dist_code,$occ->subdiv_code,$occ->cir_code,$occ->mouza_pargona_code,$occ->lot_no,$occ->vill_townprt_code,$occ->dag_no,$occup->pdar_id]);
                    if($cdpCheck_12->num_rows()==0){
                        $this->db->trans_rollback();
                        log_message("error","#ERR01444 Pattadar Already Strike: ".$dist_code
                                .", petition_no: ". $petition_no."QUERY##".$this->db->last_query());
                        return false;
                    }
                    /////////////////////////////////////////
                    $sqlCheck="Select * from chitha_dag_pattadar where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? and pdar_id!=? and (p_flag is null or p_flag!='1') ";
                    $cdpCheck_1=$this->db->query($sqlCheck,[$occ->dist_code,$occ->subdiv_code,$occ->cir_code,$occ->mouza_pargona_code,$occ->lot_no,$occ->vill_townprt_code,$occ->dag_no,$occup->pdar_id]);
                    if($cdpCheck_1->num_rows()==0){
                        $params = [
                            'p_flag' => '0',
                        ];
                    }else{
                        $params = [
                            'p_flag' => '1',
                        ];
                    }
                    $table = 'chitha_dag_pattadar';
                    $where = [
                        'dist_code'          => $dist_code,
                        'subdiv_code'        => $subdiv_code,
                        'cir_code'           => $cir_code,
                        'lot_no'             => $lot_no,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'vill_townprt_code'  => $vill_code,
                        'dag_no'             => $dag_no,
                        'pdar_id'            => $occup->pdar_id,
                    ];

                    // Then call the update method:
                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                    if ($result<=0 )
                    {
                        $this->db->trans_rollback();
                        log_message("error","#ERR014 Could not update p_flag in chitha_dag_pattadar with district: ".$dist_code
                                .", petition_no: ". $petition_no);
                        return false;
                    } 
                }
            }

            if (($ord->order_type_code == '01') || ($ord->order_type_code == '02')) {

                 $t_inplace_query = "select * from   t_chitha_col8_inplace where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and "
                    . "mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and dag_no='$dag_no' and iscorrected_inco is null";
                $t_inplace_data = $this->db->query($t_inplace_query); 
                
                if (($ord->order_type_code == '01') && ($t_inplace_data == null || $t_inplace_data->num_rows() <=0))
                {
                    $this->db->trans_rollback();
                     log_message("error","#ERR015 Could not find data in t_chitha_col8_inplace with district: "
                        .$dist_code.", petition_no: ". $petition_no);
                    return false;
                }
                $t_inplace_data = $t_inplace_data->result();

                foreach ($t_inplace_data as $inplace) {
                    $data = array();

                    foreach ($inplace as $key => $value) {
                        $data[$key] = $value;
                    }
                    unset($data['occupant_id']);
                    unset($data['year_no']);
                    unset($data['petition_no']);
                    unset($data['occupant_name']);
                    unset($data['occupant_fmh_name']);
                    unset($data['occupant_fmh_flag']);
                    unset($data['occupant_add1']);
                    unset($data['occupant_add2']);
                    unset($data['occupant_add3']);
                    unset($data['old_patta_no']);
                    unset($data['new_patta_no']);
                    unset($data['old_dag_no']);
                    unset($data['patta_type_code']);
                    unset($data['patta_no']);
                    unset($data['pdar_id']);
                    unset($data['iscorrected_inco']);
                    unset($data['iscorrected_inco_date']);
                    unset($data['isdataposted_torkg_db']);
                    unset($data['iscorrected_rkg_record']);
                    unset($data['new_dag_no']);
                    unset($data['order_passed']);
                    unset($data['date_of_order']);
                    unset($data['make_mdb']);
                    unset($data['iscorrected_rkg_date']);
                    unset($data['revenue']);
                    unset($data['new_pattadar']);
                    unset($data['hus_wife']);
                    unset($data['revenue']);


                    if ($data['fmute_strike_out'] == '1') {
                        $data['inplaceof_alongwith'] = 'i';
                    } else {
                        $data['inplaceof_alongwith'] = 'a';
                    }
                    unset($data['fmute_strike_out']);
                    $data['col8order_cron_no'] = $col8order_cron_no;
                    $data['user_code'] = $this->session->userdata('user_code');
                    $data['date_entry'] = date('Y-m-d G:i:s');
                    $data['operation'] = date('E');
                    // var_dump($data);
                    $key = array(
                        'dist_code' => $data['dist_code'],
                        'subdiv_code' => $data['subdiv_code'],
                        'cir_code' => $data['cir_code'],
                        'mouza_pargona_code' => $data['mouza_pargona_code'],
                        'lot_no' => $data['lot_no'],
                        'vill_townprt_code' => $data['vill_townprt_code'],
                        'dag_no' => $data['dag_no'],
                        'col8order_cron_no' => $data['col8order_cron_no'],
                        'inplace_of_id' => $data['inplace_of_id'],
                    );

                    $queryCheck = "select count(*) as c from   chitha_col8_inplace where dist_code='$data[dist_code]' and subdiv_code='$data[subdiv_code]' and cir_code='$data[cir_code]' and "
                            . " mouza_pargona_code='$data[mouza_pargona_code]' and lot_no='$data[lot_no]' and vill_townprt_code='$data[vill_townprt_code]' and dag_no='$data[dag_no]' and "
                            . "col8order_cron_no='$data[col8order_cron_no]' and inplace_of_id='$data[inplace_of_id]' ";
                    $count = $this->db->query($queryCheck)->row()->c;
                    if ($count <= 0)
                    {
                        $tstatus5 = $this->db->insert("chitha_col8_inplace", $data);//********************************************** insert query
                        if ($tstatus5 != 1 )
                        {
                            $this->db->trans_rollback();
                            log_message("error","#ERR016 Could not insert in chitha_col8_inplace with district: ".$dist_code
                                .", petition_no: ". $petition_no);
                            return false;
                        }
                    }

                    $p_flag = '0';
                    if ($inplace->fmute_strike_out == '1')
                    $p_flag = '1';
                    $corrected = date('Y-m-d G:i:s');
                    // $update_query = "update chitha_dag_pattadar  set p_flag='$p_flag',date_entry='$corrected' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and "
                    //         . "lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' and dag_no='$dag_no' and pdar_id=$inplace->pdar_id";
                    
                    // $this->db->query($update_query);//************************************************************************************ update query
                    $table = 'chitha_dag_pattadar';

                    $params = [
                        'p_flag'    => $p_flag,
                        'date_entry'=> $corrected,
                    ];

                    $where = [
                        'dist_code'          => $dist_code,
                        'subdiv_code'        => $subdiv_code,
                        'cir_code'           => $cir_code,
                        'lot_no'             => $lot_no,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'vill_townprt_code'  => $vill_code,
                        'dag_no'             => $dag_no,
                        'pdar_id'            => $inplace->pdar_id,
                    ];

                    // Execute update
                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                    
                    if ($result<=0 )
                    {
                        $this->db->trans_rollback();
                        log_message("error","#ERR017 Could not update p_flag in chitha_dag_pattadar with district: ".$dist_code
                                .", petition_no: ". $petition_no);
                        return false;
                    } 

                    $t_inplace_query = "update t_chitha_col8_inplace set iscorrected_inco='Y',iscorrected_inco_date='$corrected',order_passed='Y' where dist_code='$dist_code' and "
                            . "subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and vill_townprt_code='$vill_code' "
                            . "and dag_no='$dag_no'";
                    $this->db->query($t_inplace_query);//*********************************************************************************** update query
                    if ($this->db->affected_rows()<=0 )
                    {
                        $this->db->trans_rollback();
                        log_message("error","#ERR018 Could not update iscorrected_inco in t_chitha_col8_inplace with district: ".$dist_code
                                .", petition_no: ". $petition_no);
                        return false;
                    } 

                    $date_of_order=date('Y-m-d');
                    $order_update_query = "update field_mut_basic set order_passed='Y',date_of_order='$date_of_order' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                            . "cir_code='$cir_code' and lot_no='$lot_no' and mouza_pargona_code='$mouza_pargona_code' and "
                            . "vill_townprt_code='$vill_code' and petition_no=$petition_no";
                    $this->db->query($order_update_query);//***************************************************************** update query
                    if ($this->db->affected_rows()<=0 )
                    {
                        $this->db->trans_rollback();
                        log_message("error"," #ERR019 Could not update order_passed in field_mut_basic with district: ".$dist_code
                                .", petition_no: ". $petition_no);
                        return false;
                    } 
                }
            }
        }        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message("error","#ERR020 Could not complet autoUpdate for chitha with district: ".$dist_code
                                .", petition_no: ". $petition_no);
            return false;
        }
        return true;
    }
    function saveFieldArea(){
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
            $this->session->set_flashdata('query_mdl_message', $errorMessageStr);
             return redirect($_SERVER['HTTP_REFERER']);
         }
    //xss & security validation ends  
        $mutatedLandValidation = [
            [
                'field' => 'edit_kranti',
                'label' => 'Kranti',
                'rules' => 'trim|required|numeric|xss_clean',
            ],
            [
                'field' => 'edit_bigha',
                'label' => 'Bigha',
                'rules' => 'trim|required|integer|xss_clean',
            ],
            [
                'field' => 'edit_katha',
                'label' => 'Katha ',
                'rules' => 'trim|required|integer|xss_clean',
            ],
            [
                'field' => 'edit_lessa',
                'label' => 'Lessa',
                'rules' => 'trim|required|numeric|xss_clean',
            ],
            [
                'field' => 'edit_gonda',
                'label' => 'Ganda',
                'rules' => 'trim|required|xss_clean',
            ],
        ];
        $validation= null;
        $this->form_validation->set_rules($mutatedLandValidation);
        $this->form_validation->set_message('integer', 'This %s is not valid');
        $tot_lc = ($this->input->post('total_bigha') * 5 * 20) + ($this->input->post('total_katha') * 20) + $this->input->post('total_lessa');
        $total = ($this->input->post('edit_bigha')* 5 * 20) + ($this->input->post('edit_katha')* 20) + $this->input->post('edit_lessa');
        if (($this->input->post('edit_katha') > 5) || ($this->input->post('edit_lessa') > 20)) {
            $this->session->set_flashdata('message', 'You did not enter the partition land area correctly !!');
            redirect(base_url() . 'index.php/home');
        }
        if (($tot_lc == 0) or ( $total > $tot_lc)) {
            // $this->session->set_flashdata('message', 'You did not enter the partition land area correctly !!');
            $this->session->set_flashdata('message', 'You did not enter the partition land area correctly !!');
            redirect(base_url() . 'index.php/home');
            // exit();
        }
        if ($this->form_validation->run('mutatedLandValidation') == FALSE)
        {
            $this->session->set_flashdata('message', "Error in Area Submit");
            redirect(base_url() . "index.php/home");            
        }
        $update = [
            'm_dag_area_b' => $this->input->post('edit_bigha'),
            'm_dag_area_k' => $this->input->post('edit_katha'),
            'm_dag_area_lc' => $this->input->post('edit_lessa'),
            'm_dag_area_g' => $this->input->post('edit_gonda'),
            'm_dag_area_kr' => $this->input->post('edit_kranti')
        ];
        $this->db->where([
            'petition_no'=>$this->input->post('petitionno'), 
            'dist_code'=>$this->input->post('dist_code'), 
            'subdiv_code'=>$this->input->post('subdiv_code'), 
            'cir_code'=>$this->input->post('cir_code'), 
            'mouza_pargona_code'=>$this->input->post('mouza_code'), 
            'lot_no'=>$this->input->post('lot_no'),
            'vill_townprt_code'=>$this->input->post('vill'), 
            'dag_no'=>$this->input->post('dag_no')]);
        $this->db->update('field_mut_dag_details', $update);

        redirect(base_url() . "index.php/Partition/finalOrderFieldPartitionCO?case_no=".$this->input->post('caseno')."&dist_code=".$this->input->post('dist_code')."&subdiv_code=".$this->input->post('subdiv_code')."&cir_code=".$this->input->post('cir_code')."&mouza_pargona_code=".$this->input->post('mouza_code')."&lot_no=".$this->input->post('lot_no')."&vill_townprt_code=".$this->input->post('vill'));

    }

    //created for getting all the pending list at CO login circle wise---------
        public function getPendingOfficePartCaseCOend(){
            $dist_code =$this->session->userdata('dist_code');
            $subdiv_code =$this->session->userdata('subdiv_code');
            $cir_code =$this->session->userdata('cir_code');
            $draw = intval($this->input->post('draw'));
            $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
            $start = intval($this->input->post('start'));
            $length = intval($this->input->post('length'));
            $order = $this->input->post('order');
            $mouza_code = $this->input->post('mouza_code');
            $lot_no = $this->input->post('lot_no');
            $vill_mouza_code = $this->input->post('vill_mouza_code');
            $vill_lot_no = $this->input->post('vill_lot_no');
            $village_code = $this->input->post('village_code');
            $zone_status = $this->input->post('zone_status');
            // $define_date = define_date;
            // $results = $this->mutationmodel->getPendingOfficePartCaseCOend($dist_code,$subdiv_code,$cir_code,$start,$length,$order,$mouza_code,$lot_no,$vill_mouza_code,$vill_lot_no,$village_code,$searchByCol_0);

            if($zone_status != null || $zone_status != ''){
                $results = $this->Escalationmodel->getPendingOfficePartCaseCOend($dist_code,$subdiv_code,$cir_code,$start,$length,$order,$mouza_code,$lot_no,$vill_mouza_code,$vill_lot_no,$village_code,$searchByCol_0, $zone_status);    
            }
            else {
                $results = $this->mutationmodel->getPendingOfficePartCaseCOend($dist_code,$subdiv_code,$cir_code,$start,$length,$order,$mouza_code,$lot_no,$vill_mouza_code,$vill_lot_no,$village_code,$searchByCol_0);
            }
            $link2 = '';
            if(isset($results)){
            $data_rows = $results['data_results'];
                foreach($data_rows as $rows){


                    // log_message("error","9147: ==========".json_encode($rows));
                    if($rows->es_flag == '1' && ESCALATION_ENABLE == 1 && $rows->out_of_esc == 0) {

                        $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
                        // log_message('error', '#9151: Escalation details : '.json_encode($escRow));

                        if(!empty($escRow) && $escRow != null) {                            

                            $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry)); 
                            // log_message('error', '#9157: Escalation details : '.json_encode($escData)); 

                            if(!empty($escData) && $escData != null) {

                                $rows->escalation_date = $escData->escalation_date;
                                $rows->escalation_zone = $escData->escalation_zone;
                                $rows->assigned_date   = $escData->assigned_date;
                            }else {
                                $rows->escalation_date = 'NA';
                                $rows->escalation_zone = 'NA';
                            }
                        }else {
                            $rows->escalation_date = 'NA';
                            $rows->escalation_zone = 'NA';
                        }
                        
                    }
                    else
                    {
                        $rows->escalation_date = 'NA';
                        $rows->escalation_zone = 'NA';
                    }
  

                    $link = base_url() . "index.php/partition/FirstProceding?case_no=" . enc_param('case_no', $rows->case_no, 600) . "&dist_code=" . $rows->dist_code . "&subdiv_code=" . $rows->subdiv_code . "&cir_code=" . $rows->cir_code . "&mouza_pargona_code=" . $rows->mouza_pargona_code . "&lot_no=" . $rows->lot_no . "&vill_townprt_code=" . $rows->vill_townprt_code;
                    if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                    {
                        $link2 = '<button type="button" data-toggle="modal" data-target="#myModal" case_no="'.$rows->case_no.'" dist_code="'.$rows->dist_code.'" subdiv_code="'.$rows->subdiv_code.'" cir_code="'.$rows->cir_code.'" mouza_pargona_code="'.$rows->mouza_pargona_code.'" lot_no="'.$rows->lot_no.'" vill_townprt_code="'.$rows->vill_townprt_code.'" class="chainReport btn btn-success">View Property Chain</button>';

                    }
                    if(ESCALATION_ENABLE == 1 && $rows->is_escalated == 1)
                    {
                        $button = "Escalated to Appellate Authority";
                    }
                    else
                    {
                        $button = "<a href=".$link." class='btn btn-success'>".$this->lang->line("write_report")."</a>".$link2;
                    }
                    
                    $mouza_lot = $this->utilityclass->getMouzaName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code)."-".$this->utilityclass->getLotName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code,$rows->lot_no);
                    $e = $rows->application_ref_no!=null?$rows->application_ref_no:$rows->basundhara;
                    if(ESCALATION_ENABLE == 1)
                    {
                        $json[] = array(
                            $rows->escalation_zone,
                            $rows->escalation_date,
                            $rows->case_no."<br><span class='small font-italic red'>".$e."</span>",
                            $mouza_lot,
                            $this->utilityclass->getVillageName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code,$rows->lot_no,$rows->vill_townprt_code),
                            $this->lang->line('office_partition'),
                            date('M jS, Y',strtotime($rows->submission_date)),
                            $button
                        );
                    }
                    else
                    {
                        $json[] = array(
                            $rows->case_no."<br><span class='small font-italic red'>".$e."</span>",
                            $mouza_lot,
                            $this->utilityclass->getVillageName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code,$rows->lot_no,$rows->vill_townprt_code),
                            $this->lang->line('office_partition'),
                            date('M jS, Y',strtotime($rows->submission_date)),
                            $button
                        );
                    }
                    
                }
                $total_records = $results['total_records'];
                $response = array(
                    'draw'              => $draw,
                    'recordsTotal'      => $total_records,
                    'recordsFiltered'   => $total_records,
                    'data'              => $json
                );
                echo json_encode($response);
            }else{
                $response = array();
                $response['sEcho']=0;
                $response['iTotalRecords']=0;
                $response['iTotalDisplayRecords']=0;
                $response['aaData']=[];
                echo json_encode($response);
            }
        }

    public function decodeBase64($encoded_string){
        $file_data= base64_decode($encoded_string);
        $file = finfo_open();
        $mime_type = finfo_buffer($file, $file_data, FILEINFO_MIME_TYPE);
        $file_type = explode('/', $mime_type)[0];
        $extension = explode('/', $mime_type)[1];
        log_message("error","No error occured".json_encode($mime_type));
        return $mime_type;
    }

    public function getPendingOfficePartCaseCOendXXX(){
    $dist_code =$this->session->userdata('dist_code');
    $subdiv_code =$this->session->userdata('subdiv_code');
    $cir_code =$this->session->userdata('cir_code');
    $draw = intval($this->input->post('draw'));
    $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
    $start = intval($this->input->post('start'));
    $length = intval($this->input->post('length'));
    $order = $this->input->post('order');
    $mouza_code = $this->input->post('mouza_code');
    $lot_no = $this->input->post('lot_no');
    $vill_mouza_code = $this->input->post('vill_mouza_code');
    $vill_lot_no = $this->input->post('vill_lot_no');
    $village_code = $this->input->post('village_code');
    $zone_status = $this->input->post('zone_status');
    // $define_date = define_date;

    if($zone_status != null || $zone_status != ''){
        $results = $this->Escalationmodel->getPendingOfficePartCaseCOend($dist_code,$subdiv_code,$cir_code,$start,$length,$order,$mouza_code,$lot_no,$vill_mouza_code,$vill_lot_no,$village_code,$searchByCol_0, $zone_status);    
    }
    else {
        $results = $this->mutationmodel->getPendingOfficePartCaseCOend($dist_code,$subdiv_code,$cir_code,$start,$length,$order,$mouza_code,$lot_no,$vill_mouza_code,$vill_lot_no,$village_code,$searchByCol_0);
    }
    
    if(isset($results)){
        $data_rows = $results['data_results'];
        $total_records = $results['total_records'];

        if($total_records > 0) {
            foreach($data_rows as $rows){

                // log_message("error","9147: ==========".json_encode($rows));
                if($rows->es_flag == '1' && ESCALATION_ENABLE == 1) {

                    $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
                    // log_message('error', '#9151: Escalation details : '.json_encode($escRow));

                    if(!empty($escRow) && $escRow != null) {                            

                        $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_to, $escRow->co_target_days, $escRow->assigned_date, $escRow->escalated_date, $rows->date_entry)); 
                        // log_message('error', '#9157: Escalation details : '.json_encode($escData)); 

                        if(!empty($escData) && $escData != null) {

                            $rows->escalation_date = $escData->escalation_date;
                            $rows->escalation_zone = $escData->escalation_zone;
                            $rows->assigned_date   = $escData->assigned_date;
                        }else {
                            $rows->escalation_date = 'NA';
                            $rows->escalation_zone = 'NA';
                        }
                    }else {
                        $rows->escalation_date = 'NA';
                        $rows->escalation_zone = 'NA';
                    }
                    
                }
                else {
                    $rows->escalation_date = 'NA';
                    $rows->escalation_zone = 'NA';
                }

                $link = base_url() . "index.php/partition/FirstProceding?case_no=" . $rows->case_no . "&dist_code=" . $rows->dist_code . "&subdiv_code=" . $rows->subdiv_code . "&cir_code=" . $rows->cir_code . "&mouza_pargona_code=" . $rows->mouza_pargona_code . "&lot_no=" . $rows->lot_no . "&vill_townprt_code=" . $rows->vill_townprt_code;
                $button = "<a href=".$link." class='btn btn-success'>".$this->lang->line("write_report")."</a>";
                $mouza_lot = $this->utilityclass->getMouzaName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code)."-".$this->utilityclass->getLotName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code,$rows->lot_no);
                $e = $rows->application_ref_no!=null?$rows->application_ref_no:$rows->basundhara;
                $json[] = array(

                    $rows->escalation_zone,
                    $rows->escalation_date,

                    $rows->case_no."<br><span class='small font-italic red'>".$e."</span>",
                    $mouza_lot,
                    $this->utilityclass->getVillageName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code,$rows->lot_no,$rows->vill_townprt_code),
                    $this->lang->line('office_partition'),
                    date('M jS, Y',strtotime($rows->submission_date)),
                    $button
                );
            }
        }
        else {
            $json = "";
        }

        $response = array(
            'draw'              => $draw,
            'recordsTotal'      => $total_records,
            'recordsFiltered'   => $total_records,
            'data'              => $json
        );
        echo json_encode($response);
    }
    else
    {
        $response = array();
        $response['sEcho']=0;
        $response['iTotalRecords']=0;
        $response['iTotalDisplayRecords']=0;
        $response['aaData']=[];
        echo json_encode($response);
    }  
}

public function getPendingNoticeGeneration() {
        //$db=  $this->session->userdata('db');
        //$this->load->library('pagination');
        $data = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $cases = $this->db->query("SELECT ed.* ,pb.*, pb.case_no as c_no,ba.basundhara as rtps
                        FROM  Petition_basic pb
                        left join basundhar_application ba on pb.case_no = ba.dharitree
                        left join escalation_details ed on pb.case_no = ed.case_no
                        WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' 
                        and cir_code='$cir_code' and pb.not_fresh='Y' and pb.status ='P' 
                        and pb.mut_type='04' and (pb.notice_generated_yn is null or 
                        pb.notice_generated_yn='' ) order by pb.petition_no")->result();

        $data['cases'] = $cases;    
        if(ESCALATION_ENABLE == 1)
        {
            foreach($data['cases'] as $rows){

                //log_message("error","740: ==========".json_encode($rows));

                if($rows->es_flag == '1' && ESCALATION_ENABLE == 1) {

                    $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
                    //log_message('error', '#745: Escalation details : '.json_encode($escRow));

                    if(!empty($escRow) && $escRow != null) {                            

                        $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_other, $escRow->da_target_days, $escRow->assigned_other_date, $escRow->assigned_other_es_date, $rows->date_entry)); 
                        //log_message('error', '#750: Escalation details : '.json_encode($escData)); 

                        if(!empty($escData) && $escData != null) {

                            $rows->escalation_date = $escData->escalation_date;
                            $rows->escalation_zone = $escData->escalation_zone;
                            $rows->assigned_date   = $escData->assigned_date;
                        }else {
                            $rows->escalation_date = 'NA';
                            $rows->escalation_zone = 'NA';
                        }
                    }else {
                        $rows->escalation_date = 'NA';
                        $rows->escalation_zone = 'NA';
                    }                
                }
                else {
                    $rows->escalation_date = 'NA';
                    $rows->escalation_zone = 'NA';
                }
            }
        }
        

        $data['_view'] = 'partition/AstNotice';
        $this->load->view('layouts/main',$data);
    }
    
    public function getPendingProceeReport() {
        //$db=  $this->session->userdata('db');
        $this->load->library('pagination');
        $data = array();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $define_date = define_date;

        $cases = $this->db->query("select  ed.* ,fmb.*, fmb.case_no as c_no, ba.basundhara
                    from petition_basic fmb 
                    left join basundhar_application ba on fmb.case_no=ba.dharitree 
                    left join escalation_details ed on fmb.case_no=ed.case_no
                    where dist_code='$dist_code' and subdiv_code='$subdiv_code' 
                    and cir_code='$cir_code' and fmb.not_fresh='Y' and fmb.status='P' and fmb.mut_type='04' 
                    and fmb.date_entry>='$define_date' 
                    and (fmb.proceeding_yn is null or fmb.proceeding_yn='') 
                    order by fmb.petition_no ")->result();
        $data['cases'] = $cases;
        if(ESCALATION_ENABLE == 1)
        {
            foreach($data['cases'] as $rows){

                // log_message("error","947: ==========".json_encode($rows));

                if($rows->es_flag == '1' && ESCALATION_ENABLE == 1) {

                    $escRow = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($rows->case_no);
                    // log_message('error', '#952: Escalation details : '.json_encode($escRow));

                    if(!empty($escRow) && $escRow != null) {                            

                        $escData = json_decode($this->Escalationmodel->getEscalationZoneDetails($rows->es_flag, $escRow->assigned_other, $escRow->da_target_days, $escRow->assigned_other_date, $escRow->assigned_other_es_date, $rows->date_entry)); 
                        // log_message('error', '#957: Escalation details : '.json_encode($escData)); 

                        if(!empty($escData) && $escData != null) {

                            $rows->escalation_date = $escData->escalation_date;
                            $rows->escalation_zone = $escData->escalation_zone;
                            $rows->assigned_date   = $escData->assigned_date;
                        }else {
                            $rows->escalation_date = 'NA';
                            $rows->escalation_zone = 'NA';
                        }
                    }else {
                        $rows->escalation_date = 'NA';
                        $rows->escalation_zone = 'NA';
                    }                
                }
                else {
                    $rows->escalation_date = 'NA';
                    $rows->escalation_zone = 'NA';
                }
            }
        }
        


        // $this->load->view('../views/header');
        // $this->load->view('../views/partition/NoteactionFirst', $data);
        // $this->load->view('../views/footer');
         $data['_view'] = 'partition/NoteactionFirst';
        $this->load->view('layouts/main',$data);
    }

    // added on 22-Aug-2024 ===================================================

    //check authentication n validation of CO first proceeding in office partition
    public function checkAuthenticationAndValidationOpart1($postData)
    {
      log_message("error", "checkAuthenticationAndValidationOpart1: ".json_encode($postData));
      $json         = array();
      $case_no      = $postData['case_no'];
      $dist_code    = $this->session->userdata('dist_code');
      $subdiv_code  = $this->session->userdata('subdiv_code');
      $cir_code     = $this->session->userdata('cir_code');
      $session_user = $this->session->userdata('user_code');
      $curr_date    = strtotime(date('Y-m-d'));   

      $next_date1 = explode('/', $postData['next_date']);
      $next_date_input = $next_date1[2] . "-" . $next_date1[1] . "-" . $next_date1[0];

      $loc_session_code = $dist_code.'_'.$subdiv_code.'_'.$cir_code;

      $query = $this->db->query("SELECT * FROM petition_basic WHERE case_no=? AND status IS NULL", 
                array($case_no));

      // if no data available
      if($query->num_rows() == 0)
      {
        log_message("error", "#ERR10734_NO_DATA_FOUND_$case_no");
        $json = [
          'responseType' => 1,
          'message'      => "#ERR10734: No detail available to proceed for case no $case_no. Please contact system administrator !!!",
        ];
        return $json;
      }

      $row = $query->row();
      $table_location = $row->dist_code.'_'.$row->subdiv_code.'_'.$row->cir_code;

      // check the user code is same or not
      if($session_user != $row->co_user_code)
      {
        log_message("error", "#ERR10747_USER_MISMATCHED: ".$session_user.'-'.$row->co_user_code);
        $json = [
          'responseType' => 1,
          'message'      => "#ERR10734: This case seems to be not belongs to you. It is assigned to other CO as per data recorded in system for the case no $case_no. Please contact system administrator !!!",
        ];
        return $json;
      }

      // check if location is same or not
      if($loc_session_code != $table_location)
      {
        log_message("error", "#ERR10765_LOCATION_MISMATCHED: ".$loc_session_code.'-'.$table_location);
        $json = [
          'responseType' => 1,
          'message'      => "#ERR10765: Location seems to be different. This case does not belongs to you. It is assigned to other location as per data recorded in system for the case no $case_no. Please contact system administrator !!!",
        ];
        return $json;
      }

      // check if status, lm_note_yn, lm_note_date, next_date_of_hearing, notice_generated_yn, notice_served_yn fields are null for first proceeding
      if(($row->status != ''      || $row->status != null)     || 
        ($row->lm_note_yn != ''   || $row->lm_note_yn != null) || 
        ($row->lm_note_date != '' || $row->lm_note_date != null))
      {
        log_message("error", "#ERR10815: LM has already submitted the report for case no $case_no");
        $json = [
          'responseType' => 1,
          'message'      => "#ERR10815: LM has already submitted the report as per the data recorded in the system for the case no $case_no. Please contact system administrator !!!",
        ];
        return $json;
      }

      if(($row->notice_generated_yn != '' || $row->notice_generated_yn != null))
      {
        log_message("error", "#ERR10825: Notice has already been generated by Asst for case no $case_no");
        $json = [
          'responseType' => 1,
          'message'      => "#ERR10825: Notice has already been generated by Asst as per the data recorded in the system for the case no $case_no. Please contact system administrator !!!",
        ];
        return $json;
      }

      if(($row->note_action_yn != '' || $row->note_action_yn != null))
      {
        log_message("error", "#ERR10835: Note of Action already taken by Asst for case no $case_no");
        $json = [
          'responseType' => 1,
          'message'      => "#ERR10835: Note of Action already taken by Asst as per the data recorded in the system for the case no $case_no. Please contact system administrator !!!",
        ];
        return $json;
      }

      if(($row->next_date_of_hearing != '' || $row->next_date_of_hearing != null))
      {
        log_message("error", "#ERR10845: Hearing date is available for case no $case_no");
        $json = [
          'responseType' => 1,
          'message'      => "#ERR10845: As per the data recorded in the system, hearing for the service has already given for the case no $case_no. Please contact system administrator !!!",
        ];
        return $json;
      }

      // check if hearing date is less than the current date
      if(strtotime($next_date_input) < $curr_date)
      {
        log_message("error", "#ERR10807: Entered next days of hearing as previous days for case no $case_no");
        $json = [
          'responseType' => 1,
          'message'      => "#ERR10807: Next date of hearing can not be less than the current date for the case no $case_no !!!",
        ];
        return $json;
      }

      $this->load->model('UserPostModel');
      $response = $this->UserPostModel->insertPostData($postData, SERVICE_OFFICE_PARTITION, 'FIRST_PROCEEDING');

      if($response == 'n')
      {
        log_message("error", "#ERR10826: Insertion failed in json_post_data for case no $case_no");
        $json = [
          'responseType' => 1,
          'message'      => "#ERR10826: Failed to save data you have entered for the case no $case_no. Please contact system administrator !!!",
        ];
        return $json;
      }

      if($response == 'y')
      {
        log_message("error", "#ERR10816: Authenticaiton and validation successfully done for case no $case_no");
        $json = [
          'responseType' => 3,
          'message'      => "#ERR10816: Success",
        ];
        return $json;
      }
    }

    //check authentication n validation of CO second proceeding in office partition
    public function checkAuthenticationAndValidationOpart2($postData)
    {
      log_message("error", "checkAuthenticationAndValidationOpart2: ".json_encode($postData));
      $json         = array();
      $case_no      = $postData['caseno'];
      $dist_code    = $this->session->userdata('dist_code');
      $subdiv_code  = $this->session->userdata('subdiv_code');
      $cir_code     = $this->session->userdata('cir_code');
      $session_user = $this->session->userdata('user_code');
      $curr_date    = strtotime(date('Y-m-d'));   

      $next_date1      = explode('/', $postData['next_hear_date']);
      $next_date_input = $next_date1[2] . "-" . $next_date1[1] . "-" . $next_date1[0];

      $loc_session_code = $dist_code.'_'.$subdiv_code.'_'.$cir_code;

      $query = $this->db->query("SELECT * FROM petition_basic WHERE case_no=?", array($case_no));

      // if no data available
      if($query->num_rows() == 0)
      {
        log_message("error", "#ERR10867_NO_DATA_FOUND_$case_no");
        $json = [
          'responseType' => 1,
          'message'      => "#ERR10867: No detail available to proceed for case no $case_no. Please contact system administrator !!!",
        ];
        return $json;
      }

      $row = $query->row();
      $table_location = $row->dist_code.'_'.$row->subdiv_code.'_'.$row->cir_code;

      // check the user code is same or not
      if($session_user != $row->co_user_code)
      {
        log_message("error", "#ERR10881_USER_MISMATCHED: ".$session_user.'-'.$row->co_user_code);
        $json = [
          'responseType' => 1,
          'message'      => "#ERR10881: This case seems to be not belongs to you. It is assigned to other CO as per data recorded in system for the case no $case_no. Please contact system administrator !!!",
        ];
        return $json;
      }

      // check if location is same or not
      if($loc_session_code != $table_location)
      {
        log_message("error", "#ERR10892_LOCATION_MISMATCHED: ".$loc_session_code.'-'.$table_location);
        $json = [
          'responseType' => 1,
          'message'      => "#ERR10892: Location seems to be different. This case does not belongs to you. It is assigned to other location as per data recorded in system for the case no $case_no. Please contact system administrator !!!",
        ];
        return $json;
      }

      // check if status, lm_note_yn, lm_note_date, notice_generated_yn, notice_generated_date, sk_comment fields are null for second proceeding
      if(($row->status == ''      || $row->status == null)     ||
        ($row->lm_note_yn == ''   || $row->lm_note_yn == null) || 
        ($row->lm_note_date == '' || $row->lm_note_date == null))
      {
        log_message("error", "#ERR10932: LM hasnot submitted the report yet to proceed for case no $case_no");
        $json = [
          'responseType' => 1,
          'message'      => "#ERR10932: LM has not submitted the report yet to proceed for second proceeding from your end for the case no $case_no. Please contact system administrator !!!",
        ];
        return $json;
      }

      if($row->sk_comment == '' || $row->sk_comment == null)
      {
        log_message("error", "#ERR10942: SK hasnot submitted the report yet to proceed for case no $case_no");
        $json = [
          'responseType' => 1,
          'message'      => "#ERR10942: SK has not submitted the report yet to proceed for second proceeding from your end for the case no $case_no. Please contact system administrator !!!",
        ];
        return $json;
      }

      if($row->note_action_yn == '' || $row->note_action_yn == null)
      {
        log_message("error", "#ERR10952: Assistance hasnot taken action yet to proceed for case no $case_no");
        $json = [
          'responseType' => 1,
          'message'      => "#ERR10952: Note of action has not been taken yet by Assistant to proceed for second proceeding from your end for the case no $case_no. Please contact system administrator !!!",
        ];
        return $json;
      }

      if(($row->notice_generated_yn == ''  || $row->notice_generated_yn == null) || 
        ($row->notice_generated_date == '' || $row->notice_generated_date == null))
      {
        log_message("error", "#ERR10963: Assistance hasnot generated notice yet to proceed for case no $case_no");
        $json = [
          'responseType' => 1,
          'message'      => "#ERR10963: Notice generation not done by the Assistant to proceed for second proceeding from your end for the case no $case_no. Please contact system administrator !!!",
        ];
        return $json;
      }

      // check if hearing date is less than the current date
      if(strtotime($next_date_input) < $curr_date)
      {
        log_message("error", "#ERR10975: Entered next days of hearing as previous days for case no $case_no");
        $json = [
          'responseType' => 1,
          'message'      => "#ERR10975: Next date of hearing can not be less than the current date for the case no $case_no !!!",
        ];
        return $json;
      }

      $this->load->model('UserPostModel');
      $response = $this->UserPostModel->insertPostData($postData, SERVICE_OFFICE_PARTITION, 'SECOND_PROCEEDING');

      if($response == 'n')
      {
        log_message("error", "#ERR10938: Insertion failed in json_post_data for case no $case_no");
        $json = [
          'responseType' => 1,
          'message'      => "#ERR10938: Failed to save data you have entered for the case no $case_no. Please contact system administrator !!!",
        ];
        return $json;
      }

      if($response == 'y')
      {
        log_message("error", "#ERR10950: Authenticaiton and validation successfully done for case no $case_no");
        $json = [
          'responseType' => 3,
          'message'      => "#ERR10950: Success",
        ];
        return $json;
      }
    }

    // check authentication n validation of CO in Field Partition
    public function checkuthenticationAndValidationFpart($postData)
    {
      log_message("error", "checkuthenticationAndValidationFpart: ".json_encode($postData));
      $json               = array();
      $case_no            = $postData['case_no'];
      $dist_code          = $postData['dist_code'];
      $subdiv_code        = $postData['subdiv_code'];
      $cir_code           = $postData['cir_code'];
      $mouza_pargona_code = $postData['mouza_pargona_code'];
      $lot_no             = $postData['lot_no'];
      $vill_townprt_code  = $postData['vill_townprt_code'];
      $session_user       = $this->session->userdata('user_code');

      $complete_post_loc = $dist_code.'_'.$subdiv_code.'_'.$cir_code.'_'.$mouza_pargona_code.'_'.$lot_no.'_'.$vill_townprt_code;

      $query = $this->db->query("SELECT * FROM field_mut_basic WHERE case_no=? AND mut_type=? 
                AND is_dispose IS NULL", array($case_no, '02'));

      // check if data available
      if($query->num_rows() == 0)
      {
        log_message("error", "#ERR10979_NO_DATA_FOUND_$case_no");
        $json = [
          'responseType' => 1,
          'message'      => "#ERR10979: No detail available to proceed for case no $case_no. Please contact system administrator !!!",
        ];
        return $json;
      }

      $row = $query->row();
      $table_location = $row->dist_code.'_'.$row->subdiv_code.'_'.$row->cir_code.'_'.$row->mouza_pargona_code.'_'.$row->lot_no.'_'.$row->vill_townprt_code;

      // check if location matched
      if($complete_post_loc != $table_location)
      {
        log_message("error", "#ERR10995_LOCATION_MISMATCHED: ".$complete_post_loc.'-'.$table_location);
        $json = [
          'responseType' => 1,
          'message'      => "#ERR10995: Location seems to be different. This case does not belongs to you. It is assigned to other location as per data recorded in system for the case no $case_no. Please contact system administrator !!!",
        ];
        return $json;
      }

      //get circle user code login user table
      $login_user = $this->db->query("SELECT * FROM loginuser_table WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND dis_enb_option=? AND user_code=?", array($row->dist_code, $row->subdiv_code, $row->cir_code, 'E', $session_user))->row()->user_code;

      if($login_user == null || $login_user == '')
      {
        log_message("error", "#ERR11028_NO_USER: ".$login_user);
        $json = [
          'responseType' => 1,
          'message'      => "#ERR11028: No such enabled user found as per data recorded in the system to process for the case no $case_no. Please contact system administrator !!!",
        ];
        return $json;
      }

      // check the user code is same or not
      if($session_user != $login_user)
      {
        log_message("error", "#ERR11012_USER_MISMATCHED: ".$session_user.'-'.$login_user);
        $json = [
          'responseType' => 1,
          'message'      => "#ERR11012: This case seems to be not belongs to you. It is assigned to other CO as per data recorded in the system for the case no $case_no. Please contact system administrator !!!",
        ];
        return $json;
      }

      if(ESCALATION_ENABLE == 1)
      {
        // check if LM haven't gave any report
        if(($row->lm_note == null || $row->lm_note == '') && ($row->lm_note_date == null || $row->lm_note_date == ''))
        {
          log_message("error", "#ERR11020_NO_LM_REPORT: ".json_encode($row->lm_note));
          $json = [
            'responseType' => 1,
            'message'      => "#ERR11020: LM has not submitted report for the same yet to proceed from your end for the case no $case_no. Please contact system administrator !!!",
          ];
          return $json;
        }
      }        

      $this->load->model('UserPostModel');
      $response = $this->UserPostModel->insertPostData($postData, SERVICE_FIELD_PARTITION, 'FIELD_PARTITION_CO');

      if($response == 'n')
      {
        log_message("error", "#ERR11037: Insertion failed in json_post_data for case no $case_no");
        $json = [
          'responseType' => 1,
          'message'      => "#ERR11037: Failed to save data you have entered for the case no $case_no. Please contact system administrator !!!",
        ];
        return $json;
      }

      if($response == 'y')
      {
        log_message("error", "#ERR11047: Authenticaiton and validation successfully done for case no $case_no");
        $json = [
          'responseType' => 3,
          'message'      => "#ERR11047: Success",
        ];
        return $json;
      }
    }


     public function uploadSupportiveDocsPart()
    {
        // XSS Validation START
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
            // $this->session->set_flashdata('message', $errorMessageStr);
            // return redirect($_SERVER['HTTP_REFERER']);
            $data = [
                'success' => false,
                'errors' => $errorMessageStr
            ];

            return $this->output
                ->set_status_header('403')
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
        }
        // XSS Validation END
        $user_desig_code = $this->session->userdata('user_desig_code');
        if(!in_array($user_desig_code, ['CO'])){
            $data = [
                'success' => false,
                'errors' => 'You are not authorized to perform this action.'
            ];

            return $this->output
                ->set_status_header('403')
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
        }

        $val = $this->input->post();
        $case_no = $val['case_no'];
        $flag = $val['flag'];
        $dist_code = $this->session->userdata('dist_code');//$val['dist_code'];
        $doc1 = isset($val['doc1']) ? $val['doc1'] : '';
        $doc2 = isset($val['doc2']) ? $val['doc2'] : '';
        $doc3 = isset($val['doc3']) ? $val['doc3'] : '';

        $val = explode('/',$case_no);
        $petition_no = $val[3];

        if($val[4]=='FPART'){
            $folder = UPLOAD_DIR . $dist_code . UPLOAD_SEPARATOR.'PART/';
            $petition_no = $this->db->query("SELECT petition_no FROM field_mut_basic WHERE case_no=? ", array($case_no))->row()->petition_no;

            $mut_type = 'FP';
        }

        if($val[4]=='OPART'){
            $folder = UPLOAD_DIR . $dist_code . UPLOAD_SEPARATOR.'PART/';
            $petition_no = $this->db->query("SELECT petition_no FROM petition_basic WHERE case_no=? ", array($case_no))->row()->petition_no;

            $mut_type = 'OP';
        }

        if ($petition_no == null || $petition_no == '' || empty($petition_no))
        {
            $validation['img_upload'] = false;
            echo json_encode($validation);
            return;
        }

        $name = ($flag == 1) ? 'doc1_file' : (($flag == 2) ? 'doc2_file' : (($flag == 3) ? 'doc3_file' : 'null'));
        $sl = ($flag == 1) ? '1' : (($flag == 2) ? '2' : (($flag == 3) ? '3' : '0'));
        $file_name = ($flag == 1) ? $doc1 : (($flag == 2) ? $doc2 : (($flag == 3) ? $doc3 : ''));


        $ext = pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION);
        $_FILES[$name]['name'] = $petition_no.'_'.$sl.'.'.$ext;

        if(!file_exists($folder)){
            mkdir($folder, 0777, true);
            $path = $folder;
        }
        else {
            $path = $folder;
        }
        //echo $path;
        $config = [
            'upload_path' => $path,
            'allowed_types' => FILE_TYPE,
            'max_size' => MAX_SIZE,
        ];
        $FILES_TYPE_VALIDATION_ARR = explode('|', FILE_TYPE);
        $checkFileExt = false;
        foreach ($FILES_TYPE_VALIDATION_ARR as $file_type) {
            if($ext == $file_type) {
                $checkFileExt = true;
                break;
            }
        }
        $validation=null;
        //log_message('error',json_encode($_FILES[$name]['size']));
        if(!$checkFileExt){
            $validation['error'][] = array('message' => ' Only allowed types ' . FILE_TYPE . '.');
        }
        else if($_FILES[$name]['size'] > (MAX_SIZE * 1024) )
        {
            $validation['error'][] = array('message' => ' Larger file size selected.');
        }
        else
        {
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            $count = $this->db->query("SELECT * FROM supportive_document WHERE case_no=? AND user_code=? and doc_flag= ? ",array($case_no, $this->user_code,$flag))->num_rows();
            // var_dump($count);
            //  exit;

            if($count == 0)
            {
                if ($this->upload->do_upload($name))
                {
                    $up = $this->upload->data();
                    $img = [
                        'case_no' => $case_no,
                        'file_name' => $file_name,
                        'user_code' => $this->session->userdata('user_code'),
                        'fetch_file_name' => $petition_no.'_'.$sl.$up['file_ext'],
                        'file_type' => $up['file_type'],
                        'file_path' => $path.$petition_no.'_'.$sl.$up['file_ext'],
                        'date_entry' => date('Y-m-d h:i:s'),
                        'mut_type' => $mut_type,
                        'doc_flag'=>$flag
                    ];
                    $ins = $this->db->insert('supportive_document', $img);
                    if($ins == true)
                    {
                        $id=$this->db->query("SELECT * FROM supportive_document WHERE case_no=? AND file_name=?", array($case_no, $file_name))->row()->id;
                        $validation['img_upload'] = true;
                        $validation['flag_set'] = $flag;
                        $validation['doc_id'] = $id;
                        $validation['filename'] = $file_name;
                    }
                    else
                    {
                        $validation['img_upload'] = false;
                    }
                }//end do upload
                else{
                    $validation['img_upload'] = false;
                }
            }// end count if

            else { //overwrite previous one

                $file = $this->db->query("SELECT * FROM supportive_document WHERE case_no=? and doc_flag= ?", array($case_no,$flag))->row()->file_path;
                // echo $file;
                // exit;
                unlink($file);
                if ($this->upload->do_upload($name))
                {
                    $up = $this->upload->data();
                    $overwrite = [
                        'fetch_file_name' => $petition_no.'_'.$sl.$up['file_ext'],
                        'file_type' => $up['file_type'],
                        'file_path' => $path.$petition_no.'_'.$sl.$up['file_ext'],
                        'date_entry' => date('Y-m-d h:i:s'),
                        'mut_type' => $mut_type,
                        'file_name'=>$file_name
                    ];
                    $this->db->where(['case_no'=>$case_no, 'doc_flag'=>$flag, 'user_code'=>$this->user_code]);
                    $this->db->update('supportive_document', $overwrite);
                    if($this->db->affected_rows() != 1)//if no updation made
                    {
                        $validation['img_upload'] = false;
                    }
                    else
                    {
                        $id=$this->db->query("SELECT * FROM supportive_document WHERE case_no=? AND doc_flag=?", array($case_no, $flag))->row()->id;
                        $validation['img_upload'] = true;
                        $validation['flag_set'] = $flag;
                        $validation['doc_id'] = $id;
                        $validation['filename'] = $file_name;
                    }
                }
            }
        }
        echo json_encode($validation);
    }


       public function removeSupportiveDocsPart()
    {
        // XSS Validation START
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
            // $this->session->set_flashdata('message', $errorMessageStr);
            // return redirect($_SERVER['HTTP_REFERER']);
            $data = [
                'success' => false,
                'errors' => $errorMessageStr
            ];

            return $this->output
                    ->set_status_header('403')
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data)); 
        }
        // XSS Validation END
        $user_desig_code = $this->session->userdata('user_desig_code');
        if(!in_array($user_desig_code, ['CO'])){
            $data = [
                'success' => false,
                'errors' => 'You are not authorized to perform this action.'
            ];

            return $this->output
                    ->set_status_header('403')
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));
        }
        
        $dist_code = $this->session->userdata('dist_code');
        $case_no = $this->input->post('case_no');
        $flag = $this->input->post('flag');
        $doc1 = $this->input->post('doc1');
        $doc2 = $this->input->post('doc2');
        $doc3 = $this->input->post('doc3');
        $val = explode('/',$case_no);

        $petition_no = $val[3];   

        $getFileDetails = $this->db->query("SELECT id, fetch_file_name, file_path,file_name FROM supportive_document WHERE case_no=? and doc_flag=?", array($case_no,$flag))->row(); 
       
        // var_dump($getFileDetails->file_name);
        // exit; 
        if($getFileDetails) { 
            $file_name = (in_array($flag, [1, 2, 3])) ? $getFileDetails->file_name : NOK_CONSENT;

            $getFile = $this->db->query("SELECT id, fetch_file_name, file_path FROM supportive_document WHERE case_no=? AND file_name=?", array($case_no, $file_name))->row();
            $file_path=$getFile->file_path;
            $delete = $this->db->query("DELETE FROM supportive_document WHERE id=?", array($getFile->id));

            if($delete == true) {
                unlink($file_path);
                $validation['flag'] = $flag;
            }
        }
        else{
            $file_name = (in_array($flag, [1, 2, 3])) ? $getFileDetails->file_name : NOK_CONSENT;

            $getFile = $this->db->query("SELECT id, fetch_file_name, file_path FROM supportive_document WHERE case_no=? AND file_name=?", array($case_no, $file_name))->row();
            $delete = $this->db->query("DELETE FROM supportive_document WHERE id=?", array($getFile->id));

            if($delete == true) {
                unlink($getFile->file_path);
                $validation['flag'] = $flag;
            }
        }
        echo json_encode($validation);
    }


}
