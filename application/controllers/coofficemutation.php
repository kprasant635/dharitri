    <?php
    //BRD0002: Fix to Final order by CO for the issue of petition no
    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */

    class coofficemutation extends CI_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->library('pagination');
            $this->load->model('basundhara/basundharamodel');
            $this->load->model('mutation/mutationmodel');
            $this->load->model('Escalationmodel');
            $this->load->model('mutation/cofieldmutationmodel'); // Added by Abhijit -- 2024-02-29
            $this->load->model('AgriStackCaseHistory');
            $this->user_code = $this->session->userdata('user_code');
            $location = $this->utilityclass->getLocationfromSession();
            $dist_code = $location['dist_code'];
            $subdiv_code = $location['subdiv_code'];
            $cir_code = $location['cir_code'];
            $define_date = define_date;
            $year_no = year_no;
            $this->base_query = "dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and date(date_entry) >='$define_date'";
            $this->query = "dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'";
            if(ENABLED_BLOCKCHAIN == 1)
            {
                $this->load->model('propChain/PropChainModel');
                $this->load->model('propChain/PropChainCommonModel');
            }
            if(MULTIGENERATION_ACTIVE == 1)
            {
                $this->load->model('ChithaUpdateForMutationModel');
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
            $define_date = "2017-09-16";
            $this->db=$this->load->database('dha22', TRUE);   
        }  else if($this->session->userdata('dist_code') == "25"){
            $this->db=$this->load->database('dha23', TRUE);   
        }   else if($this->session->userdata('dist_code') == "39"){
            $this->db=$this->load->database('dha39', TRUE);   
        }                                                                                                                                                                                                            
    }

    public function getPendingCases() {
           // $this->dbswitch();
          //$db=  $this->session->userdata('db');
            //log_message("error","BHRIGU: db connection: ".json_encode($this->db));
        $query = "select * from    petition_basic where not_fresh is null and lm_note_yn is null ";
        $data['cases'] = $this->db->query($query)->result();
        $date = date('Y-m-d G:i:s');
        $next_query = "select * from petition_basic where not_fresh='Y' and status='P' ";

        $data['next_proceeding'] = $this->db->query($next_query)->result();
        $resume_query = "SELECT * from petition_basic WHERE  status='F' and order_passed is null";
        $data['resume'] = $this->db->query($resume_query)->result();
        $data['_view'] = 'officemutation/cases';
        $this->load->view('layouts/main',$data);
    }

    public function getPendingMutationCases() {
       ini_set('memory_limit', '-1');
       // $this->dbswitch();
        $proceeding_id = $this->input->get('id');
        if (!$proceeding_id) {
           $proceeding_id = 1;
       }
       $append=$this->base_query;

       if ($proceeding_id == 1) {
            $villageListNew = array();
            $villageList = $this->mutationmodel->getAllDistinctVillageList($append);
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
           // var_dump($uniqueMouzaList);die;
           //old code---------
           // $query="select distinct on (case_no) *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where fmb.status is null AND fmb.comp_serv_yn is null and fmb.not_fresh is null "
           // . "and fmb.lm_note_yn is null and fmb.mut_type='03' and ".$append." ";
           //-----------
         // $query = "select * from petition_basic where status is null and not_fresh is null "
         // . "and lm_note_yn is null and mut_type='03' and ".$append." order by date_entry desc";

       } else if ($proceeding_id == 2) {
            $villageList = $this->mutationmodel->getAllDistinctVillageListCaseSecond($append);
            $newMouzaList = array();
                foreach ($villageList as $key => $value) {
                    $newMouzaList[$key]['mouza_code'] = $value->mouza_pargona_code;
                    $newMouzaList[$key]['mouza_name'] = $this->utilityclass->getMouzaName($value->dist_code,$value->subdiv_code,$value->cir_code,$value->mouza_pargona_code);
                    $newMouzaList[$key]['lot_name'] = $this->utilityclass->getLotName($value->dist_code,$value->subdiv_code,$value->cir_code,$value->mouza_pargona_code,$value->lot_no);
                    $newMouzaList[$key]['lot_no'] = $value->lot_no;
            }
           
           $uniqueMouzaList = array_map("unserialize", array_unique(array_map("serialize", $newMouzaList)));
           $data['newMouzaList'] = $uniqueMouzaList;
            $query="select distinct on (case_no) *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where  fmb.not_fresh='Y' AND fmb.comp_serv_yn is null and "
            . " fmb.status='P' and fmb.mut_type='03' and ".$append." ";
             // $query = "select * from petition_basic where not_fresh='Y' and "
             // . " status='P' and mut_type='03' and ".$append." order by date_entry desc";
            $data['cases'] = $this->db->query($query)->result();
        }
        
        // var_dump($data['cases']);
        // exit;
             //var_dump($data);
        $data['proceeding_id'] = $proceeding_id;
	$resume_query = "SELECT * from Petition_basic WHERE  status='F' AND comp_serv_yn is null and order_passed is null and ".$append."  order by date_entry desc";
        $data['resume'] = $this->db->query($resume_query)->result();

        $data['_view'] = 'officemutation/cases';
        $this->load->view('layouts/main',$data);
    }

    public function getPendingPartitionCases() {
      $db=  $this->session->userdata('db');
      $this->load->library('pagination');
      $proceeding_id = $this->input->get('id');

      if (!$proceeding_id) {
        $proceeding_id = 1;
    }
    $config['base_url'] = base_url() . 'index.php/coofficemutation/getPendingPartitionCases?id=' . $proceeding_id;
    $count_query = "select count(*) as c from    petition_basic where not_fresh is null and lm_note_yn is null and mut_type='04'";
    $config['total_rows'] = $this->db->query($count_query)->row()->c;
    $config['per_page'] = 10;

    $config['full_tag_open'] = '<ul class="tsc_pagination tsc_paginationA tsc_paginationA01">';
    $config['full_tag_close'] = '</ul>';
    $config['prev_link'] = '&lt;';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['next_link'] = '&gt;';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="current"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $config['page_query_string'] = TRUE;
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';

    $config['first_link'] = '&lt;&lt;';
    $config['last_link'] = '&gt;&gt;';
    $config['page_query_string'] = TRUE;
    $page = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
    $this->pagination->initialize($config);
    $query = "";
    if ($proceeding_id == 1) {
        $query = "select * from    petition_basic where not_fresh is null "
        . "and lm_note_yn is null and mut_type='04' limit $config[per_page] offset $page";
    } else if ($proceeding_id == 2) {
        $query = "select * from    petition_basic where not_fresh='Y' and "
        . " status='P' ";
    }

    $data['cases'] = $this->db->query($query)->result();
    $resume_query = "SELECT * from    Petition_basic WHERE  status='F' and order_passed is null and " . $append;
    $data['resume'] = $this->db->query($resume_query)->result();
    $data['proceeding_id'] = $proceeding_id;

    $data['_view'] = 'officemutation/cases';
    $this->load->view('layouts/main',$data);
    }

    public function registrationPetition() {
     $db=  $this->session->userdata('db');
     $data = array();
     $mut_type = $this->input->get('mut_type');
     $case_no = $this->input->get('case_no');
     $append = $this->base_query;
     $year_no = year_no;
     $pb = $data['petition_basic'] = $this->db->query("select * from    petition_basic where case_no='$case_no' and  $append")->row();

     if ($mut_type == '03') {
        $data['petitioner'] = $this->db->query("select * from    petitioner where dist_code='$pb->dist_code' and subdiv_code='$pb->subdiv_code' and cir_code='$pb->cir_code'  and petition_no=$pb->petition_no"
            . " ")->result_array();
    }

    $data['pattadar'] = $this->db->query("select * from  petition_pattadar where dist_code='$pb->dist_code' and subdiv_code='$pb->subdiv_code' and cir_code='$pb->cir_code'  and  petition_no=$pb->petition_no")->result_array();
    $trans_code = $pb->trans_code;
    $data['tranfer_type'] = $this->db->query("select trans_desc_as from    nature_trans_code "
        . " where trans_code='$trans_code'")->row()->trans_desc_as;
    $data['addressed_to'] = $pb->add_off_name;

    $temp = $this->db->query("select * from    petition_pattadar where  dist_code='$pb->dist_code' and subdiv_code='$pb->subdiv_code' and cir_code='$pb->cir_code'  and  petition_no=$pb->petition_no")->row()->patta_no;
    $data['patta_no'] = trim($temp);


    $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code from    petition_basic where $append ")->row_array();

    $q = "select * from    petition_dag_details "
    . "where petition_no=$pb->petition_no and dist_code='$location[dist_code]' and "
    . " cir_code = '$location[cir_code]' and subdiv_code='$location[subdiv_code]' and "
    . " mouza_pargona_code = '$location[mouza_pargona_code]' and lot_no = '$location[lot_no]' and "
    . " vill_townprt_code = '$location[vill_townprt_code]' and year_no = '$pb->year_no'";
            //echo $q;
    $data['dags'] = $this->db->query($q)->result_array();

            ////////var_dump($data['dags']);
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
        'vill' => $vill_townprt_code
    );
    $this->load->model('patta/PattaModel');
            // $this->load->view('../views/header');
            // $this->load->view('../views/asstofficemutation/registrationpetition', $data);
            // $this->load->view('../views/footer');

    $data['_view'] = 'asstofficemutation/registrationpetition';
    $this->load->view('layouts/main',$data);
    }

    public function proceeding1_old() {
      $db=  $this->session->userdata('db');
      $case_no = $this->input->get('case_no');
      $dist_code = $this->input->get('dist_code');
      $subdiv_code = $this->input->get('subdiv_code');
      $circle_code = $this->input->get('cir_code');
      $mouza_pargona_code = $this->input->get('mouza_pargona_code');
      $lot_no = $this->input->get('lot_no');
      $vill_townprt_code = $this->input->get('vill_townprt_code');

      $append = "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and "
      . "vill_townprt_code='$vill_townprt_code'";

      $data['case_no'] = $case_no;
      $year_no = year_no;
      if ($this->input->server('REQUEST_METHOD') == 'POST') {
        $case_no = $this->input->post('case_no');
        $proceeding_id = $this->db->query("select count(proceeding_id)+1 as pid from    petition_proceeding where case_no='$case_no' and $this->query")->row()->pid;
        if ($proceeding_id == null) {
            $proceeding_id = 1;
        }
        $date_of_hearing = date('Y-m-d G:i:s');
        $co_order = $this->input->post('co_order');
        $next_date_of_hearing = $this->input->post('next_hearing_date');

        $status = $this->input->post('status');
        $user_code = $this->user_code;
        $date_entry = date('Y-m-d G:i:s');
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');

        $append = "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and "
        . "vill_townprt_code='$vill_townprt_code'";
        $dd = date('Y-m-d', strtotime($next_date_of_hearing));
        $data = array(
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => $date_of_hearing,
            'co_order' => $co_order,
            'next_date_of_hearing' => date('Y-m-d', strtotime($next_date_of_hearing)),
            'status' => $status,
            'user_code' => $user_code,
            'date_entry' => $date_entry,
            'dist_code' => $dist_code,
            'cir_code' => $cir_code,
            'subdiv_code' => $subdiv_code,
            'operation' => 'E'
        );
                $tstatus1=$this->db->insert("petition_proceeding", $data); //********************
                if ($tstatus1 != 1 )
                {
                 $this->session->set_flashdata('message', "Petition Proceeding could not saved. Error Code(#OM005)");
                 redirect(base_url() . "index.php/home");
             }
             $query = "update  petition_basic set not_fresh='Y',status='P',next_date_of_hearing='$dd' where case_no='$case_no' and $append";
                $this->db->query($query); //**********************

                $pb = $data['petition_basic'] = $this->db->query("select * from petition_basic where case_no='$case_no' and $append")->row();
                $firstParty = $this->db->query("select * from    petitioner where $append and petition_no=$pb->petition_no")->result();
                $q = "select * from    petition_pattadar where $append and petition_no=$pb->petition_no";
                $secondParty = $this->db->query("select * from    petition_pattadar where $append and petition_no=$pb->petition_no")->result();

                $query = "select count(notified_id)+1 as cunt from    petition_notified where $append and petition_no=$pb->petition_no";
                $notified_id = $this->db->query($query)->row()->cunt;

                foreach ($firstParty as $app) {
                    $noticeData = array(
                        'dist_code' => $pb->dist_code,
                        'subdiv_code' => $pb->subdiv_code,
                        'cir_code' => $pb->cir_code,
                        'lot_no' => $pb->lot_no,
                        'mouza_pargona_code' => $pb->mouza_pargona_code,
                        'vill_townprt_code' => $pb->vill_townprt_code,
                        'petition_no' => $pb->petition_no,
                        'notified_id' => $notified_id++,
                        'notified_name' => $app->pet_name,
                        'add1' => $app->add1,
                        'add2' => $app->add2,
                        'user_code' => $this->user_code,
                        'date_entry' => date('Y-m-d G:i:s'),
                        'operation' => 'E',
                        'year_no' => date('Y')
                    );
                    $this->db->insert("petition_notified", $noticeData); //****************
                }

                foreach ($secondParty as $app) {
                    $noticeData = array(
                        'dist_code' => $pb->dist_code,
                        'subdiv_code' => $pb->subdiv_code,
                        'cir_code' => $pb->cir_code,
                        'lot_no' => $pb->lot_no,
                        'mouza_pargona_code' => $pb->mouza_pargona_code,
                        'vill_townprt_code' => $pb->vill_townprt_code,
                        'petition_no' => $pb->petition_no,
                        'notified_id' => $notified_id++,
                        'notified_name' => $app->pdar_name,
                        'add1' => $app->pdar_add1,
                        'add2' => $app->pdar_add2,
                        'user_code' => $this->user_code,
                        'date_entry' => date('Y-m-d G:i:s'),
                        'operation' => 'E',
                        'year_no' => date('Y')
                    );
                    $this->db->insert("petition_notified", $noticeData); //*******************
                }
                //////
                $penUser='AST';
                $rmrk='First Proceeding given by CO';
                $this->DashboardData($case_no,$penUser,$rmrk);

                //////////////////////////
                $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
                if($basundharaExist){
                    $rmk='Forwarded to LM';
                    $status='M';
                    $task='CO';
                    $pen='LM';
                    $case=$case_no;
                    $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen); 
                }
                //////////////////////
                redirect(base_url() . "index.php/coofficemutation/issueNotice?case_no=" . $case_no . "&petition_no=" . $pb->petition_no);
            } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
                $query = "select * from    petition_basic where case_no='$case_no' and $append";
                $pb = $data['petition_basic'] = $this->db->query($query)->row();
                
                if($pb->application_ref_no){
                    $url = RTPS_LINK."mutation/mutation_attachment_details.php?application_ref_no=" . $pb->application_ref_no . "&applid=" . $pb->applid;
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
                $data['basuCase']=null;
                $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
                if($basundharaExist){
                    $data['query']=null;
                    $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
                    $data['query']=$this->basundharamodel->QueryPost($basundharaExist);
                    $data['sro']=$this->basundharamodel->SroPost($basundharaExist);
                }
                $query = "select * from    petitioner where $append and petition_no=$pb->petition_no" . " ";
                $data['petitioner'] = $this->db->query($query)->result();

                $q = "select * from    petition_pattadar where $append and  petition_no=$pb->petition_no";

                $data['pattadar'] = $this->db->query("select * from    petition_pattadar where $append  and  petition_no=$pb->petition_no")->result();
                $q = "select * from    petition_dag_details where $append and  petition_no=$pb->petition_no";
                $data['dag'] = $this->db->query("select * from    petition_dag_details where $append  and  petition_no=$pb->petition_no")->row();

                $data['_view'] = 'officemutation/proceeding1';
                $this->load->view('layouts/main',$data);
            }
        }

        // public function issueNotice() {
        //    $db=  $this->session->userdata('db');
        //     if ($this->input->server('REQUEST_METHOD') == 'POST') {
        //         $data = $this->input->post('notification');
        //         $case_no = $this->input->post('case_no');
        //         $petition_no = $this->input->post('petition_no');
        //         $append = $this->base_query;
        //         $appendq = $this->query;
        //         $query = "select petition_no,dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,petition_no from   "
        //                 . " petition_basic where case_no='$case_no' and petition_no='$petition_no' limit 1";
        //         $location = $this->db->query($query)->row();
        //         $query = "select count(notified_id)+1 as cunt from    petition_notified where $appendq and petition_no=$petition_no";
        //         $notified_id = $this->db->query($query)->row()->cunt;

        //         foreach ($data as $key => $value) {
        //             $notice_data = array(
        //                 'dist_code' => $location->dist_code,
        //                 'subdiv_code' => $location->subdiv_code,
        //                 'cir_code' => $location->cir_code,
        //                 'mouza_pargona_code' => $location->mouza_pargona_code,
        //                 'lot_no' => $location->lot_no,
        //                 'vill_townprt_code' => $location->vill_townprt_code,
        //                 'petition_no' => $location->petition_no,
        //                 'notified_id' => $notified_id++,
        //                 'notified_name' => $value['name'],
        //                 'add1' => $value['address1'],
        //                 'add2' => $value['address2'],
        //                 'user_code' => $this->user_code,
        //                 'operation' => 'E',
        //                 'year_no' => date('Y'),
        //                 'date_entry' => date('Y-m-d G:i:s')
        //             );
        //             $this->db->insert("petition_notified", $notice_data);
        //         }
        //         ////////////////////////////////////
        //         $rmk='Forwarded to LM';
        //         $status='M';
        //         $task='CO';
        //         $pen='LM';
        //         $case=$case_no;
        //         $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
        //         ///////////////////////////////
        //         $this->session->set_flashdata(array('message' => "Request for notice generation given to assistant for Case : $case_no"));
        //         redirect(base_url() . "index.php/home");
        //     } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
        //         $case_no = $this->input->get('case_no');
        //         $data['case_no'] = $case_no;
        //         $petition_no = $this->input->get('petition_no');
        //         $data['petition_no'] = $petition_no;
        //      $data['_view'] = 'officemutation/issuenotice';
        //      $this->load->view('layouts/main',$data);
        //     }
        // }
        public function issueNotice() {
           
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
            if ($this->input->server('REQUEST_METHOD') == 'POST') {            
                //********************validation************************//
                $_POST['name11'] = $_POST['notification'][1]['name'];
                $_POST['address11'] = $_POST['notification'][1]['address1'];
                $_POST['address22'] = $_POST['notification'][1]['address2'];
                $om_in = [
                    [
                        'field' => 'name11',
                        'label' => "Name Of (Notified-Party-1)",
                        'rules' => 'callback_check_script|max_length[100]|trim|xss_clean'
                    ],
                    [
                        'field' => 'address11',
                        'label' => "Address1 Of (Notified-Party-1)",
                        'rules' => 'callback_check_script|max_length[100]|trim|xss_clean'
                    ],
                    [
                        'field' => 'address22',
                        'label' => "Address2 Of (Notified-Party-1)",
                        'rules' => 'callback_check_script|max_length[100]|trim|xss_clean'
                    ],
                    [
                        'field' => 'case_no',
                        'label' => 'Case-No',
                        'rules' => 'required|callback_check_script|max_length[50]|trim|xss_clean'
                    ],
                    [
                        'field' => 'petition_no',
                        'label' => 'Petition-No',
                        'rules' => 'required|integer|less_than_equal_to[32,766]|greater_than_equal_to[0]'
                    ],
                ];
                $this->form_validation->set_rules($om_in);      
                $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');          
                if ($this->form_validation->run() == FALSE)
                {   
                    $error_msg = array();
                    foreach($om_in as $rule){
                        if (form_error($rule['field'])) {
                            array_push($error_msg, form_error($rule['field']));
                        }
                    }  
                    $this->session->set_flashdata('validation_msg_issue_notice', $error_msg);
                    redirect($_SERVER['HTTP_REFERER']);
                    exit;
                }
                //other_name_validation        
                if(isset($_POST['add_name'])){
                    $count=2;
                    foreach($_POST['add_name'] as $name){                
                        $_POST['name'] = $name;
                        $name_rule = [
                            [
                                'field' => 'name',
                                'label' => "Name Of (Notified-Party-".$count.")",
                                'rules' => 'callback_check_script|max_length[100]|trim|xss_clean'
                            ],
                        ];                
                        $this->form_validation->set_rules($name_rule);      
                        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');          
                        if ($this->form_validation->run() == FALSE)
                        {   
                            $error_msg = array();
                            foreach($name_rule as $rule){
                                if (form_error($rule['field'])) {
                                    array_push($error_msg, form_error($rule['field']));
                                }
                            }  
                            $this->session->set_flashdata('validation_msg_issue_notice', $error_msg);
                            redirect($_SERVER['HTTP_REFERER']);
                            exit;
                        }
                        $count= $count+1;
                    }
                }
                //add_1 validation 
                if(isset($_POST['add_1'])){
                    $count=2;
                    foreach($_POST['add_1'] as $add1){                
                        $_POST['add1'] = $add1;
                        $add_rule = [
                            [
                                'field' => 'add1',
                                'label' => "Address-1 Of (Notified-Party-".$count.")",
                                'rules' => 'callback_check_script|max_length[100]|trim|xss_clean'
                            ],
                        ];                
                        $this->form_validation->set_rules($add_rule);      
                        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');          
                        if ($this->form_validation->run() == FALSE)
                        {   
                            $error_msg = array();
                            foreach($add_rule as $rule){
                                if (form_error($rule['field'])) {
                                    array_push($error_msg, form_error($rule['field']));
                                }
                            }  
                            $this->session->set_flashdata('validation_msg_issue_notice', $error_msg);
                            redirect($_SERVER['HTTP_REFERER']);
                            exit;
                        }
                        $count= $count+1;
                    }
                }
                //add_2 validation 
                if(isset($_POST['add_2'])){
                    $count=2;
                    foreach($_POST['add_2'] as $add1){                
                        $_POST['add2'] = $add1;
                        $add_rule = [
                            [
                                'field' => 'add2',
                                'label' => "Address-2 Of (Notified-Party-".$count.")",
                                'rules' => 'callback_check_script|max_length[100]|trim|xss_clean'
                            ],
                        ];                
                        $this->form_validation->set_rules($add_rule);      
                        $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');          
                        if ($this->form_validation->run() == FALSE)
                        {   
                            $error_msg = array();
                            foreach($add_rule as $rule){
                                if (form_error($rule['field'])) {
                                    array_push($error_msg, form_error($rule['field']));
                                }
                            }  
                            $this->session->set_flashdata('validation_msg_issue_notice', $error_msg);
                            redirect($_SERVER['HTTP_REFERER']);
                            exit;
                        }
                        $count= $count+1;
                    }
                }
                //********************validation************************//
                $this->db->trans_begin();
                $data = $this->input->post('notification');
                //*********************new-modification******************/
                if(isset($_POST['add_name'])){
                    $count = 0;
                    foreach($_POST['add_name'] as $name){
                        array_push($data, [
                            "name" => $name,
                            "address1" => $_POST['add_1'][$count],
                            "address2" => $_POST['add_2'][$count],
                        ]);
                    }
                }
                //*********************new-modification******************/
                $case_no = $this->input->post('case_no');
                $petition_no = $this->input->post('petition_no');
                $append = $this->base_query;
                $appendq = $this->query;
                $query = "select petition_no,dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,petition_no from   "
                . " petition_basic where case_no='$case_no' and petition_no='$petition_no' limit 1";
                $location = $this->db->query($query)->row();
                $query = "select count(notified_id)+1 as cunt from petition_notified where $appendq and petition_no=$petition_no";
                $notified_id = $this->db->query($query)->row()->cunt;

                foreach ($data as $key => $value) {
                    $notice_data = array(
                        'dist_code' => $location->dist_code,
                        'subdiv_code' => $location->subdiv_code,
                        'cir_code' => $location->cir_code,
                        'mouza_pargona_code' => $location->mouza_pargona_code,
                        'lot_no' => $location->lot_no,
                        'vill_townprt_code' => $location->vill_townprt_code,
                        'petition_no' => $location->petition_no,
                        'notified_id' => $notified_id++,
                        'notified_name' => $value['name'],
                        'add1' => $value['address1'],
                        'add2' => $value['address2'],
                        'user_code' => $this->user_code,
                        'operation' => 'E',
                        'year_no' => date('Y'),
                        'date_entry' => date('Y-m-d G:i:s')
                    );
                    $tstatus = $this->db->insert("petition_notified", $notice_data);
                    if ($tstatus != 1 )
                    {
                        $this->db->trans_rollback();
                        log_message("error", "#OMCOFP006, Error in insert, table 'petition_notified' with case-no :". $case_no);
                        $this->session->set_flashdata('message', "Error in saving parties information who will get notice. Error Code(#OMCOFP006)");
                        redirect(base_url() . "index.php/home");
                    }
                }
                if($this->db->trans_status()==FALSE){
                    $this->db->trans_rollback();
                    log_message("error", "#OMCOFP007, transaction-error in method 'coofficemutation/issueNotice' with case-no :". $case_no['case_no']);
                    $this->session->set_flashdata('message', "Error in saving parties information who will get notice. Error Code(#OMCOFP007)");
                    redirect(base_url() . "index.php/home");
                }else{
                    $this->db->trans_commit();
                } 
                ////////////////////////////////////
                $rmk='Forwarded to LM';
                $status='M';
                $task='CO';
                $pen='LM';
                $case=$case_no;
                $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
                ///////////////////////////////
                $this->session->set_flashdata(array('message' => "Request for notice generation given to assistant for Case : $case_no"));
                redirect(base_url() . "index.php/home");
            } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
                $case_no = $this->input->get('case_no');
                $data['case_no'] = $case_no;
                $petition_no = $this->input->get('petition_no');
                $data['petition_no'] = $petition_no;
                $data['_view'] = 'officemutation/issuenotice';
                $this->load->view('layouts/main',$data);
            }
        }

        public function proceeding2_old() {
          $db=  $this->session->userdata('db');
          $case_no = $this->input->get('case_no');
          $dist_code = $this->input->get('dist_code');
          $subdiv_code = $this->input->get('subdiv_code');
          $circle_code = $this->input->get('cir_code');
          $mouza_pargona_code = $this->input->get('mouza_pargona_code');
          $lot_no = $this->input->get('lot_no');
          $vill_townprt_code = $this->input->get('vill_townprt_code');

          $append = "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and "
          . "vill_townprt_code='$vill_townprt_code'";
          $data['case_no'] = $case_no;
          if ($this->input->server('REQUEST_METHOD') == 'POST') {
              $case_no = $this->input->post('case_no');

              $status = $this->input->post('case_status');
              $user_code = $this->user_code;
              $date_entry = date('Y-m-d G:i:s');
              $dist_code = $this->input->post('dist_code');
              $subdiv_code = $this->input->post('subdiv_code');
              $cir_code = $this->input->post('cir_code');
              $mouza_pargona_code = $this->input->post('mouza_pargona_code');
              $lot_no = $this->input->post('lot_no');
              $vill_townprt_code = $this->input->post('vill_townprt_code');
              $proceeding_id = $this->db->query("select max(proceeding_id)+1 as pid from    petition_proceeding where case_no='$case_no' and $this->query")->row()->pid;
              if ($proceeding_id == null) {
                  $proceeding_id = 1;
              }
              $date_of_hearing = date('Y-m-d G:i:s');
              $co_order = $this->input->post('co_order');
              if($co_order == '' || $co_order == null){ $co_order = ''; }
              if($status != 'final')
              {
               $data = [
                   'case_no' => $case_no,
                   'proceeding_id' => $proceeding_id,
                   'date_of_hearing' => $date_of_hearing,
                   'co_order' => $co_order,
                   'next_date_of_hearing' => $next_date_of_hearing,
                   'status' => $status,
                   'user_code' => $user_code,
                   'date_entry' => $date_entry,
                   'dist_code' => $dist_code,
                   'cir_code' => $cir_code,
                   'subdiv_code' => $subdiv_code,
                   'operation' => 'E',
                   'date_entry' => date('Y-m-d G:i:s')
               ]; 
           }
           if ($status == 'final') {
               $next_date_of_hearing = date('Y-m-d G:i:s');
           } else {
             $next_date_of_hearing = date('Y-m-d', strtotime($this->input->post('next_hearing_date'))); // $this->input->post('next_hearing_date');
         }
         
         $append = "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and "
         . "vill_townprt_code='$vill_townprt_code'";
         $reissue_notice = $this->input->post('reissue_notice');
         $lm_petition_re = $this->input->post('lm_petition_re');
         if ($lm_petition_re == 'y') {
          $query = "update  petition_basic set lm_note_yn=null,lm_note_date=null,sk_comment=null where case_no='$case_no' and $append";
          $this->db->query($query);
          /////
          $penUser='LM';
          $rmrk='Revert by CO to LM for fresh report';
          $this->DashboardData($case_no,$penUser,$rmrk);
      }
      if ($reissue_notice == 'y') {
          $query = "update  petition_basic set notice_generated_yn=null,proceeding_yn=null,"
          . "notice_served_yn=null,notice_generated_date=null where case_no='$case_no' and $append";
          $this->db->query($query);
          //////
          $penUser='AST';
          $rmrk='Revert by CO to AST for re-issue of notice';
          $this->DashboardData($case_no,$penUser,$rmrk);
          //////////////////////////
      }
      if ($status == 'pending') {
       $d = date('Y-m-d', strtotime($this->input->post('next_hearing_date')));
       $next_date_of_hearing;
       $this->db->insert("petition_proceeding", $data);
       $query = "update  petition_basic set proceeding_yn=null,next_date_of_hearing='$next_date_of_hearing' where case_no='$case_no' and $append";
       $this->db->query($query);
       redirect(base_url() . "index.php/coofficemutation/getPendingMutationCases?id=2");
    } else if ($status == 'final') {
             //////////01-03-22////////////
       redirect(base_url() . "index.php/coofficemutation/finalOrderPass?case_no=" . $case_no . "&dist_code=" . $dist_code . "&subdiv_code=" . $subdiv_code . "&cir_code=" . $cir_code . "&mouza_pargona_code=" . $mouza_pargona_code . "&lot_no=" . $lot_no . "&vill_townprt_code=" . $vill_townprt_code); 
    } else if ($status == 'dispose') {
       $d = date('Y-m-d', strtotime($this->input->post('next_hearing_date')));
       $this->db->insert("petition_proceeding", $data);
       $query = "update  petition_basic set status='D',date_of_order='$d' where case_no='$case_no' and $append and mut_type='03'  ";
       $this->db->query($query);
       $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
       if($basundhara){
        $rmrk=$co_order;
        $status='R';
        $task='CO';
        $pen='NA';
        $this->basundharamodel->postApiBasundharaSec($case_no,$rmrk,$status,$task,$pen);
    }
    redirect(base_url() . "index.php/coofficemutation/getPendingMutationCases?id=2");
    }
    } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
       $pb = $data['petition_basic'] = $this->db->query("select * from  petition_basic where case_no='$case_no' and $append")->row();
       $data['petitioner'] = $this->db->query("select * from    petitioner where $append and petition_no=$pb->petition_no")->result();
       $data['pattadar'] = $this->db->query("select * from    petition_pattadar where $append and petition_no=$pb->petition_no")->result();
       $data['dag'] = $this->db->query("select * from    petition_dag_details where $append  and  petition_no=$pb->petition_no")->row();
       $data['basuCase']=null;
       $data['tempNok']=$data['apps']=$data['sro']=$data['basundharaAttachment']=$data['query']=array();
       $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($pb->case_no);
       if($basundharaExist){
         $data['query']=null;
         $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($pb->case_no);
         $sql="Select * from nok_tmp where case_id='$case_no'";
         $data['tempNok']=$this->db->query($sql)->result_array();
         $data['sup_doc']=$this->mutationmodel->getDocument($case_no);
         $data['query']=$this->basundharamodel->QueryPost($basundharaExist);
         $data['sro']=$this->basundharamodel->SroPost($basundharaExist);
         $data['apps']=array();
         $url = API_LINK."serviceResponse?application_no=" . $basundharaExist ;
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
         $output = curl_exec($ch);
         curl_close($ch);
         $output = json_decode($output);
         if($output){
             $data['apps']=$output->application;
         }
     }
     $data['_view'] = 'officemutation/proceeding2';
     $this->load->view('layouts/main',$data);
    }
    }


    public function finalOrderStep1() {
     $db=  $this->session->userdata('db');
     if ($this->input->server('REQUEST_METHOD') == 'POST') {
        $case_no = $this->input->post('case_no');
        redirect(base_url() . "index.php/coofficemutation/finalorderstep2?case_no=$case_no");
    } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
        $case_no = $this->input->get('case_no');
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $this->session->set_userdata(array('mutation_case_no' => $case_no));
        redirect(base_url() . "index.php/coofficemutation/finalorderstep2?case_no=" . $case_no . "&dist_code=" . $dist_code . "&subdiv_code=" . $subdiv_code . "&cir_code=" . $cir_code . "&mouza_pargona_code=" . $mouza_pargona_code . "&lot_no=" . $lot_no . "&vill_townprt_code=" . $vill_townprt_code);
    }
    }

    public function finalOrderStep2() {
     $db=  $this->session->userdata('db');
     if ($this->input->server('REQUEST_METHOD') == 'POST') {
        $pass = $this->input->post('pass');
        $appenq = $this->query;
        $case_no = $this->input->post('case_no');
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');

        $append = "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and "
        . "vill_townprt_code='$vill_townprt_code'";
        $year_no = year_no;
        $orderBasic = array();
        foreach ($_POST as $k => $v) {
            $orderBasic[$k] = $v;
        }
        $query = "select petition_no,dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code"
        . " from    petition_basic where case_no='$case_no' and $append";
        $data = $this->db->query($query)->row();

        $dag_no_q = "select dag_no,patta_no,patta_type_code from    petition_dag_details where $append  and petition_no=$data->petition_no";
        $d = $this->db->query($dag_no_q)->row();
        foreach ($data as $key => $value) {
            $orderBasic[$key] = $value;
        }
        $orderBasic['dag_no'] = $d->dag_no;
        $orderBasic['patta_no'] = trim($d->patta_no);
        $orderBasic['patta_type_code'] = $d->patta_type_code;
        $this->session->set_userdata(array('orderbasic' => $orderBasic));
        redirect(base_url() . "index.php/coofficemutation/finalorderstep4?case_no=" . $case_no . "&dist_code=" . $dist_code . "&subdiv_code=" . $subdiv_code . "&cir_code=" . $cir_code . "&mouza_pargona_code=" . $mouza_pargona_code . "&lot_no=" . $lot_no . "&vill_townprt_code=" . $vill_townprt_code);
    } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
        $case_no = $this->input->get('case_no');
        $append = $this->base_query;
        $appenq = $this->query;
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $query = "select max(proceeding_id) as last from    petition_proceeding where case_no='$case_no' and $appenq ";
        $proceeding_id = $this->db->query($query)->row()->last;
        $query = "select * from    petition_basic pb join  petition_dag_details pd on"
        . " pb.dist_code = pd.dist_code and pb.subdiv_code = pd.subdiv_code and pb.cir_code = pd.cir_code and"
        . " pb.mouza_pargona_code = pd.mouza_pargona_code and pb.lot_no = pd.lot_no  and pb.petition_no = pd.petition_no and "
        . " pb.vill_townprt_code = pd.vill_townprt_code where pb.case_no='$case_no' and pb.dist_code='$dist_code' and pb.subdiv_code='$subdiv_code' and pb.cir_code='$cir_code' ";

        $data = $this->db->query($query)->row();
        $details['data'] = $data;

        $details['proceeding_id'] = $proceeding_id;
        $q = "select lm_code,lm_sign_yn,sk_sign_yn,sk_note_date,lm_sign_date from    petition_lm_note where $appenq   and "
        . "petition_no=$data->petition_no";
        
             //echo "select lm_code,lm_sign_yn,sk_sign_yn,sk_note_date,lm_sign_date,user_code,lm_code from     petition_lm_note where $appenq and petition_no = '$data->petition_no'";

        $dates = $this->db->query("select lm_code,lm_sign_yn,sk_sign_yn,sk_note_date,lm_sign_date,user_code,lm_code from    petition_lm_note where $appenq and petition_no = '$data->petition_no'")->row();

        $details['sk_note_date'] = $dates->sk_note_date;
        $details['lm_note_date'] = $dates->lm_sign_date;
        $details['lm_sign_yn'] = $dates->lm_sign_yn;
                $details['sk_sign_yn'] = $data->sk_comment; //$dates->sk_sign_yn;
                $details['lm_code'] = $dates->lm_code;
                $details['case_no'] = $case_no;
                $details['user_code'] = $dates->user_code;
    //var_dump($dates);
                // $this->load->view('../views/header');
                // $this->load->view('../views/officemutation/finalorderstep2', $details);
                // $this->load->view('../views/footer');
                $details['_view'] = 'officemutation/finalorderstep2';
                $this->load->view('layouts/main',$details);
            }
        }

        public function finalOrderStep3() {
         $db=  $this->session->userdata('db');
         if ($this->input->server('REQUEST_METHOD') == 'POST') {
            redirect(base_url() . "index.php/coofficemutation/finalorderstep4");
        } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
                //var_dump($this->session->all_userdata());
            $case_no = $this->session->userdata('mutation_case_no');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $cir_code = $this->session->userdata('cir_code');
            $year_no = year_no;
                //echo $case_no;
            $query = "select * from    petition_basic pb join  petition_dag_details pd on"
            . " pb.dist_code = pd.dist_code and pb.subdiv_code = pd.subdiv_code and pb.cir_code = pd.cir_code and"
            . " pb.mouza_pargona_code = pd.mouza_pargona_code and pb.lot_no = pd.lot_no and  pb.petition_no = pd.petition_no and "
            . " pb.vill_townprt_code = pd.vill_townprt_code where pb.case_no='$case_no' and pb.dist_code='$dist_code' and pb.subdiv_code='$subdiv_code' and pb.cir_code='$cir_code'  ";
                //echo $query;
            $data = $this->db->query($query)->result();
            $details['data'] = $data;
                //$this->load->view('../views/header');
            $this->load->view('../views/common/bar');
                //$this->load->view('../views/officemutation/finalorderstep3', $details);
                //$this->load->view('../views/footer');

            $details['_view'] = 'officemutation/finalorderstep3';
            $this->load->view('layouts/main',$details);
        }
    }

    public function finalOrderStep4() {
     $db=  $this->session->userdata('db');
     if ($this->input->server('REQUEST_METHOD') == 'POST') {
        if (!($count = $this->input->post('infavor_of_id'))) {
            $count = 1;
        } else {
            $count++;
        }
        $case_no = $this->session->userdata('mutation_case_no');
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');

        $append = "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and "
        . "vill_townprt_code='$vill_townprt_code'";

        $appendq = $this->query;
        $year_no = year_no;
        $petition_no_q = "select petition_no,trans_code,deed_no,deed_value,sub_reg_office,submission_date from    petition_basic where case_no='$case_no' and $append ";
        $petition_no = $this->db->query($petition_no_q)->row()->petition_no;
        $trans_code = $this->db->query($petition_no_q)->row()->trans_code;
        $deed_no = $this->db->query($petition_no_q)->row()->deed_no;
        $deed_value = $this->db->query($petition_no_q)->row()->deed_value;
        $sub_reg_office = $this->db->query($petition_no_q)->row()->sub_reg_office;
        $submission_date = $this->db->query($petition_no_q)->row()->submission_date;

        $bigha = $this->input->post('land_area_b');
        $katha = $this->input->post('land_area_k');
        $lessa = $this->input->post('land_area_lc');
        $pet_id = $this->input->post('infavor_of_id');

        $i = count($this->input->post('infavor_of_id'));
        for ($z = 0; $z < $i; $z++) {
            $update = "update  petitioner set applied_b='$bigha[$z]', applied_k='$katha[$z]', applied_lc='$lessa[$z]' where $append and petition_no=$petition_no and pet_id='$pet_id[$z]'";
                    $this->db->query($update); //*****************
                }
                $query = "select * from    petitioner pb join  petition_dag_details pd on pb.dist_code = pd.dist_code and pb.subdiv_code = pd.subdiv_code and pb.cir_code = pd.cir_code and "
                . "pb.mouza_pargona_code = pd.mouza_pargona_code and pb.lot_no = pd.lot_no and pb.vill_townprt_code = pd.vill_townprt_code where pb.petition_no=$petition_no "
                . "and pb.dist_code='$dist_code' and pb.subdiv_code='$subdiv_code' and pb.cir_code='$cir_code' and pb.mouza_pargona_code='$mouza_pargona_code' and pb.lot_no='$lot_no' and "
                . "pb.vill_townprt_code='$vill_townprt_code' and pd.petition_no=$petition_no";
                $datas = $this->db->query($query)->result();
                foreach ($datas as $data) {
                    $orderBasic = array();
                    foreach ($_POST as $k => $v) {
                        $orderBasic[$k] = $v;
                    }
                    $query = "select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code, deed_no,deed_value,deed_date from    petition_basic where "
                    . "case_no='$case_no' and $append ";
                    $data1 = $this->db->query($query)->row();

                    foreach ($data1 as $key => $value) {
                        $orderBasic[$key] = $value;
                    }
                    $orderBasic['infavor_of_id'] = $data->pet_id;
                    $orderBasic['infavor_of_name'] = $data->pet_name;
                    $orderBasic['infavor_of_guardian'] = $data->guard_name;
                    $orderBasic['infav_of_guar_relation'] = $data->guard_rel;
                    $orderBasic['infavor_of_add1'] = $data->add1;
                    $orderBasic['infavor_of_add2'] = $data->add2;
                    $orderBasic['land_area_b'] = $data->m_dag_area_b;
                    $orderBasic['land_area_k'] = $data->m_dag_area_k;
                    $orderBasic['land_area_lc'] = $data->m_dag_area_lc;
                    $orderBasic['dag_no'] = $this->input->post('dag_no');
                    $orderBasic['year_no'] = date('Y');
                    $orderBasic['petition_no'] = $petition_no;

                    $orderBasic['land_area_g'] = 0;
                    $orderBasic['land_area_kr'] = 0;
                    $orderBasic['revenue'] = 0;
                    $orderBasic['reg_deal_no'] = $orderBasic['deed_no'];
                    $orderBasic['reg_date'] = $orderBasic['deed_date'];
                    $orderBasic['infavor_of_gender'] = $data->pet_gender;
                    $orderBasic['infavor_of_minor_yn'] = $data->pet_minor_yn;
                    $orderBasic['infavor_of_minor_dob'] = $data->pet_minor_dob;
                    $orderBasic['infavor_of_mother'] = $data->pet_mother;
                    $orderBasic['pdar_name_eng'] = $data->pdar_name_eng;
                    $orderBasic['pdar_guard_eng'] = $data->pdar_guard_eng;

                    unset($orderBasic['deed_no']);
                    unset($orderBasic['deed_date']);
                    unset($orderBasic['submit']);
                    $orderBasic['ord_date'] = date('Y-m-d', strtotime($orderBasic['ord_date']));
                    unset($orderBasic['case_no']);
                    unset($orderBasic['deed_value']);
                    //var_dump($orderBasic);
                    $tstatus1=$this->db->insert("t_chitha_rmk_infavor_of", $orderBasic); //**********************
                    if ($tstatus1 != 1 )
                    {
                      $this->db->trans_rollback();
                      $this->session->set_flashdata('message', "Order Not Successfull. Error Code(#OM001)");
                      redirect(base_url() . "index.php/home");
                  }
              }
              redirect(base_url() . "index.php/coofficemutation/finalorderstep6?case_no=" . $case_no . "&dist_code=" . $dist_code . "&subdiv_code=" . $subdiv_code . "&cir_code=" . $cir_code . "&mouza_pargona_code=" . $mouza_pargona_code . "&lot_no=" . $lot_no . "&vill_townprt_code=" . $vill_townprt_code);
          } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
            if (!($count = $this->input->post('id'))) {
                $count = 1;
            } else
            $count++;
            $case_no = $this->session->userdata('mutation_case_no');
            $dist_code = $this->input->get('dist_code');
            $subdiv_code = $this->input->get('subdiv_code');
            $cir_code = $this->input->get('cir_code');
            $mouza_pargona_code = $this->input->get('mouza_pargona_code');
            $lot_no = $this->input->get('lot_no');
            $vill_townprt_code = $this->input->get('vill_townprt_code');

            $append = "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and "
            . "vill_townprt_code='$vill_townprt_code'";

            $appendq = $this->query;
            $petition_no_q = "select petition_no,trans_code,deed_no,deed_value,sub_reg_office,submission_date,dist_code,subdiv_code,cir_code,deed_date from    petition_basic where case_no='$case_no' and $append ";
            $petition_no = $this->db->query($petition_no_q)->row()->petition_no;
            $trans_code = $this->db->query($petition_no_q)->row()->trans_code;
            $deed_no = $this->db->query($petition_no_q)->row()->deed_no;
            $deed_value = $this->db->query($petition_no_q)->row()->deed_value;
            $sub_reg_office = $this->db->query($petition_no_q)->row()->sub_reg_office;
            $submission_date = $this->db->query($petition_no_q)->row()->submission_date;
            $dist_code = $this->db->query($petition_no_q)->row()->dist_code;
            $subdiv_code = $this->db->query($petition_no_q)->row()->subdiv_code;
            $cir_code = $this->db->query($petition_no_q)->row()->cir_code;
            $deed_date = $this->db->query($petition_no_q)->row()->deed_date;
            $year_no = year_no;

            $c = $count - 1;

            $land_q = "select * from    petitioner pb where pb.petition_no=$petition_no and pb.petition_no=$petition_no and pb.dist_code='$dist_code' and pb.subdiv_code='$subdiv_code' "
            . "and pb.cir_code='$cir_code' and pb.mouza_pargona_code='$mouza_pargona_code' and pb.lot_no='$lot_no' and "
            . "pb.vill_townprt_code='$vill_townprt_code' limit 1 offset $c";
            $land = $this->db->query($land_q)->row();

            $query = "select * from    petitioner pb join  petition_dag_details pd on pb.dist_code = pd.dist_code and pb.subdiv_code = pd.subdiv_code and pb.cir_code = pd.cir_code and "
            . "pb.mouza_pargona_code = pd.mouza_pargona_code and pb.lot_no = pd.lot_no and pb.vill_townprt_code = pd.vill_townprt_code where pb.petition_no=$petition_no and "
            . "pd.petition_no=$petition_no and pb.dist_code='$dist_code' and pb.subdiv_code='$subdiv_code' and pb.cir_code='$cir_code' and "
            . "pb.mouza_pargona_code='$mouza_pargona_code' and pb.lot_no='$lot_no' and pb.vill_townprt_code='$vill_townprt_code' limit 1 offset $c";
            $data = $this->db->query($query)->row();

            $details['data'] = $data;
            $details['case_no'] = $case_no;
            $details['count'] = $count;
            $details['trans_code'] = $trans_code;
            $details['deed_no'] = $deed_no;
            $details['deed_value'] = $deed_value;
            $details['sub_reg_office'] = $sub_reg_office;
            $details['submission_date'] = $submission_date;
            $details['land'] = $land;
            $details['deed_date'] = $deed_date;

            $applicants = "select * from petitioner where petition_no=$petition_no and $append";
            $details['applicants'] = $this->db->query($applicants)->result();

                // $this->load->view('../views/header');
                // $this->load->view('../views/officemutation/finalorderstep4', $details);
                // $this->load->view('../views/footer');
            $details['_view'] = 'officemutation/finalorderstep4';
            $this->load->view('layouts/main',$details);
        }
    }

    public function finalOrderStep5() {
     $db=  $this->session->userdata('db');
     if ($this->input->server('REQUEST_METHOD') == 'POST') {
        $case_no = $this->input->post('case_no');
        redirect(base_url() . "index.php/coofficemutation/finalorderstep6?case_no=$case_no");
    } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
        $case_no = $this->input->get('case_no');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $year_no = year_no;
        $query = "select * from    petition_basic pb join petition_dag_details pd on"
        . " pb.dist_code = pd.dist_code and pb.subdiv_code = pd.subdiv_code and pb.cir_code = pd.cir_code and"
        . " pb.mouza_pargona_code = pd.mouza_pargona_code and pb.lot_no = pd.lot_no and "
        . " pb.vill_townprt_code = pd.vill_townprt_code   and pb.petition_no = pd.petition_no  where pb.case_no='$case_no' and pb.dist_code='$dist_code' and pb.subdiv_code='$subdiv_code' and pb.cir_code='$cir_code' ";
                //echo $query;
        $data = $this->db->query($query)->result();
        $details['data'] = $data;
        $details['case_no'] = $case_no;
                //$this->load->view('../views/header');
                //$this->load->view('../views/common/bar');
                //$this->load->view('menu/menu4');

                // $this->load->view('../views/officemutation/finalorderstep5', $details);
                // $this->load->view('../views/footer');
        $details['_view'] = 'officemutation/finalorderstep5';
        $this->load->view('layouts/main',$details);
    }
    }


    public function finalOrderStep6() {
     $db=  $this->session->userdata('db');
     if ($this->input->server('REQUEST_METHOD') == 'POST') {
        $this->db->trans_begin();
        
        if (!($count = $this->input->post('alongwith_id'))) {
            $count = 1;
        } else
        $count++;

        $case_no = $this->session->userdata('mutation_case_no');
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');

        $append = "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and "
        . "vill_townprt_code='$vill_townprt_code'";

        $appendq = $this->query;
        $pdar_id = $this->input->post('alongwith_id');
        $inplace_alongwith = $this->input->post('inplace_alongwith');
        $i = count($this->input->post('alongwith_id'));
        for ($z = 0; $z < $i; $z++) {
            $petition_no_q = "select petition_no from    petition_basic where case_no='$case_no' and $append";
            $petition_no = $this->db->query($petition_no_q)->row()->petition_no;

            $query = "select * from    petition_pattadar where petition_no=$petition_no and $append and pdar_id = '$pdar_id[$z]'";
            $data = $this->db->query($query)->row();
            $orderBasic = array();

            if ($inplace_alongwith[$z] == 1) {
                $orderBasic['inplace_of_name'] = $data->pdar_name;
                $orderBasic['inplace_of_guardian'] = $data->pdar_guardian;
                $orderBasic['inplace_of_relation'] = $data->pdar_rel_guar;
                $orderBasic['inplace_of_id'] = $data->pdar_id;
                $orderBasic['pdar_id'] = $data->pdar_id;
                $orderBasic['dag_no'] = $this->input->post('dag_no');
                $orderBasic['strike_out'] = '1';
                $orderBasic['ord_no'] = $this->input->post('case_no');
            } else if (($inplace_alongwith[$z] == 0) || ($inplace_alongwith[$z] == '')) {
                $orderBasic['alongwith_id'] = $data->pdar_id;
                $orderBasic['alongwith_name'] = $data->pdar_name;
                $orderBasic['alongwith_guardian'] = $data->pdar_guardian;
                $orderBasic['alongwith_rel_gur'] = $data->pdar_rel_guar;
                $orderBasic['inplace_alongwith'] = $inplace_alongwith[$z];
                $orderBasic['case_no'] = $case_no;
                $orderBasic['dag_no'] = $this->input->post('dag_no');
                $orderBasic['pdar_id'] = $data->pdar_id;
                $orderBasic['ord_no'] = $this->input->post('ord_no');
                $orderBasic['ord_date'] = $this->input->post('ord_date');
            }

            $query = "select dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code"
            . " from    petition_basic where case_no='$case_no' and $append";
            $data1 = $this->db->query($query)->row();

            foreach ($data1 as $key => $value) {
                $orderBasic[$key] = $value;
            }
            $orderBasic['year_no'] = date('Y');
            $orderBasic['petition_no'] = $petition_no;
            $orderBasic['ord_date'] = date('Y-m-d');

            unset($orderBasic['case_no']);
            unset($orderBasic['inplace_alongwith']);
            if ($inplace_alongwith[$z] === '1') {
                unset($orderBasic['alongwith_id']);
                        //var_dump($orderBasic);
                        $tstatus2=$this->db->insert("t_chitha_rmk_inplace_of", $orderBasic); //***************
                        if ($tstatus2 != 1 )
                        {
                           $this->db->trans_rollback();
                           $this->session->set_flashdata('message', "Order Not Successfull. Error Code(#OM002)");
                           redirect(base_url() . "index.php/home");
                       }
                   }
                   if (($inplace_alongwith[$z] === '0') || ($inplace_alongwith[$z] === '')) {
                        //var_dump($orderBasic);
                        $tstatus3=$this->db->insert("t_chitha_rmk_alongwith", $orderBasic); //***************
                        if ($tstatus3 != 1 )
                        {
                           $this->db->trans_rollback();
                           $this->session->set_flashdata('message', "Order Not Successfull. Error Code(#OM003)");
                           redirect(base_url() . "index.php/home");
                       }
                   }
               }
               $date = date('Y-m-d');
               $update = "update  petition_basic set status='F',date_of_order='$date' where case_no='$case_no' and $append";
                $this->db->query($update); //******************
                $year_no = year_no;
                $q = "select applied_b,applied_k,applied_lc from    petitioner where petition_no=$petition_no and $append";
                $d = $this->db->query($q)->result();

                $q = "select m_dag_area_b,m_dag_area_k,m_dag_area_lc,dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,patta_no,patta_type_code from    petition_dag_details where petition_no=$petition_no and $append";
                $result = $this->db->query($q)->row();
                
                $total_mutation_b = 0;
                $total_mutation_k = 0;
                $total_mutation_lc = 0;
                $total_mutation_g = 0;
                $total_mutation_kr = 0;
                foreach ($d as $e) {
                    $total_mutation_b+=$e->applied_b;
                    $total_mutation_k+=$e->applied_k;
                    $total_mutation_lc+=$e->applied_lc;
                }

                $m = $total_mutation_b * 100 + $total_mutation_k * 20 + $total_mutation_lc;
                $s = $result->dag_area_b * 100 + $result->dag_area_k * 20 + $result->dag_area_lc;
                $rem = $s - $m;

                $bigha_r = floor($rem / 100.0);
                $katha_r = floor(($rem - $bigha_r * 100.0) / 20.0);
                $lessa_r = $rem - $bigha_r * 100.0 - $katha_r * 20.0;
                if ($m == 0) {
                    $total_mutation_b = $result->m_dag_area_b;
                    $total_mutation_k = $result->m_dag_area_k;
                    $total_mutation_lc = $result->m_dag_area_lc;
                }
                // if($total_mutation_k==0){
                // $total_mutation_k=$result->m_dag_area_k;
                // }
                // if($total_mutation_lc==0){
                // $total_mutation_lc=$result->m_dag_area_lc;
                // }
                $order_basic = $this->session->userdata('orderbasic');
                $order_basic['m_dag_area_b'] = $total_mutation_b;
                $order_basic['m_dag_area_k'] = $total_mutation_k;
                $order_basic['m_dag_area_lc'] = $total_mutation_lc;
                $order_basic['m_dag_area_g'] = $total_mutation_g;
                $order_basic['m_dag_area_kr'] = $total_mutation_kr;
                $order_basic['min_revenue'] = 0.0;
                $order_basic['year_no'] = date('Y');
                $order_basic['area_left_b'] = $bigha_r;
                $order_basic['area_left_k'] = $katha_r;
                $order_basic['area_left_lc'] = $lessa_r;
                $order_basic['area_left_g'] = $result->dag_area_g - $total_mutation_g;
                $order_basic['area_left_kr'] = $result->dag_area_kr - $total_mutation_kr;
                $order_basic['ord_date'] = date('Y-m-d', strtotime($orderBasic['ord_date']));
                $order_basic['co_ord_date'] = date('Y-m-d');
                $order_basic['lm_sign_date'] = date('Y-m-d');
                $order_basic['sk_sign_date'] = date('Y-m-d');
                $order_basic['ord_type_code'] = '03';
                
                unset($order_basic['pass']);
                unset($order_basic['patta_no']);
                unset($order_basic['patta_type_code']);
                unset($order_basic['submit']);
                $tstatus4=$this->db->insert("t_chitha_rmk_ordbasic", $order_basic); //****************
                if ($tstatus4 != 1 )
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Order Not Successfull. Error Code(#OM004)");
                    redirect(base_url() . "index.php/home");
                }
                $q = "select * from    petition_basic where case_no='$case_no' and $append";
                $data = $this->db->query($q)->row();

                $dist_code = $data->dist_code;
                $subdiv_code = $data->subdiv_code;
                $cir_code = $data->cir_code;
                $lot_no = $data->lot_no;
                $vill_code = $data->vill_townprt_code;
                $mouza_pargona_code = $data->mouza_pargona_code;
                $petition_no = $data->petition_no;
                $deed_no = $data->deed_no;
                $dag_no= $this->input->post('dag_no');
                if ($deed_no != 0 or $deed_no != null) {
                    $update = "update  sro_note set status='3' where deed_no='$deed_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$dag_no' ";
                    $this->db->query($update);
                }

                $dag_no = $this->db->query("Select dag_no from    petition_dag_details where petition_no='$petition_no' and $append")->row()->dag_no;
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata(array('message' => "Could not pass order. Rolling back changes for case_no "));
                    redirect(base_url() . "index.php/home");
                    return false;
                } else {
                    $this->db->trans_commit();
                    $ok = $this->autoUpdate($dist_code, $subdiv_code, $cir_code, $lot_no, $vill_code, $mouza_pargona_code, $petition_no, $dag_no);
                    
                    if ($ok) {
                     
                     
                        $curl_handle = curl_init();
                        curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK."/mutation/mutation_response.php");
                        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                            'applId' => $data->applid,
                            'application_ref_no' => $data->application_ref_no,
                            'msg' => "Delivered",
                            'status' => "D",
                        )));
                        $result = curl_exec($curl_handle);
                        $this->session->set_flashdata(array('message' => "Order Passed for Case # $case_no"));
                        $this->session->set_flashdata(array('message2' => "Chitha Updated for Case # $case_no\ and Dag # $dag_no."));

                        ////////
                        $this->DashboardDataFinal($case_no);
                        $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
                        if($basundhara){
                            $rmk='Final Order Passed';
                            $status='F';
                            $task='CO';
                            $pen='NA';
                            $case=$case_no;

                            $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
                        }
                        ////////////////////////////////////
                   /////////for jb////////////
                        $pa_no=$this->session->userdata['orderbasic']['patta_no'];
                        $pt_code=$this->session->userdata['orderbasic']['patta_type_code'];
                   /////////////////////
                        $location = array(
                         'd'=> $dist_code,
                         's' => $subdiv_code,
                         'c' => $cir_code,
                         'm' => $mouza_pargona_code,
                         'l' => $lot_no,
                         'v' => $vill_code,
                     );
                   //var_dump($location);
                        $this->session->set_userdata('case_no',$case_no); 
                        $this->session->set_userdata('patta_no',$pa_no);
                        $this->session->set_userdata('patta_type_code',$pt_code);
                        $this->session->set_userdata(array('loc' => $location));
                   //var_dump($this->session->all_userdata());
                        redirect('JamaBandi/step3/' .$pa_no .'/'. $pt_code);
                   ////////////////////////////////////
                   //redirect(base_url() . "index.php/home");
                    } else {
                        $this->session->set_flashdata(array('message' => "Order for case_no $case_no not passed. Contact helpdesk with case_no"));
                        redirect(base_url() . "index.php/home");
                    }
                    return true;
                }
            } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
                $case_no = $this->session->userdata('mutation_case_no');
                $dist_code = $this->input->get('dist_code');
                $subdiv_code = $this->input->get('subdiv_code');
                $cir_code = $this->input->get('cir_code');
                $mouza_pargona_code = $this->input->get('mouza_pargona_code');
                $lot_no = $this->input->get('lot_no');
                $vill_townprt_code = $this->input->get('vill_townprt_code');

                $append = "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and "
                . "vill_townprt_code='$vill_townprt_code'";

                $appendq = $this->query;
                $count = 1;
                $petition_no_q = "select petition_no from    petition_basic where case_no='$case_no'";
                $petition_no = $this->db->query($petition_no_q)->row()->petition_no;
                $c = $count - 1;
                $query = "select * from    petition_pattadar where petition_no='$petition_no' and $append limit 1 offset $c";
                $data = $this->db->query($query)->row();
                $details['data'] = $data;
                $details['count'] = $count;
                $details['case_no'] = $case_no;
                $details['petition_no'] = $petition_no;

                $pattadars = "select * from    petition_pattadar where petition_no=$petition_no and $append";
                $details['pattadars'] = $this->db->query($pattadars)->result();
                //var_dump($details);
                // $this->load->view('../views/header');
                // $this->load->view('../views/officemutation/finalorderstep6', $details);
                // $this->load->view('../views/footer');
                $details['_view'] = 'officemutation/finalorderstep6';
                $this->load->view('layouts/main',$details);
            }
        }

        public function ReAlongInplaceDetails() {
         $db=  $this->session->userdata('db');
         $case_no = $this->input->get('case_no');
         $petition_no = $this->input->get('petition_no');
         
         $details = $this->db->query("Select * from    petition_basic where case_no = '$case_no' and petition_no = '$petition_no' ")->row();
         
         $dag_details = $this->db->query("Select * from    petition_dag_details where dist_code='$details->dist_code' and subdiv_code='$details->subdiv_code' "
            . "and cir_code='$details->cir_code' and lot_no='$details->lot_no' and vill_townprt_code='$details->vill_townprt_code' and mouza_pargona_code='$details->mouza_pargona_code' "
            . "and petition_no='$details->petition_no' ")->row();
         
         $data['dag_details'] = $dag_details;
         $where_condition="dist_code='$dag_details->dist_code' and subdiv_code='$dag_details->subdiv_code' and cir_code='$dag_details->cir_code' and
           mouza_pargona_code='$dag_details->mouza_pargona_code' and vill_townprt_code='$dag_details->vill_townprt_code' 
           and lot_no='$dag_details->lot_no' and trim(patta_no)='$dag_details->patta_no'  and patta_type_code='$dag_details->patta_type_code' ";
         $data['pattadar_details'] = $this->db->query("select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from   (select * from chitha_pattadar where $where_condition) p join 
           (select pdar_id from chitha_dag_pattadar where $where_condition and dag_no='$dag_details->dag_no' and (p_flag!=1 or p_flag is null)) d on p.pdar_id=d.pdar_id  ")->result();
         
         $data['case_no'] = $case_no;
         $data['petition_no'] = $petition_no;
         
            // $this->load->helper('html');
            // $this->load->view('../views/header');
            // $this->load->view('../views/officemutation/pattadardetails', $data);
            // $this->load->view('../views/footer');

         $data['_view'] = 'officemutation/pattadardetails';
         $this->load->view('layouts/main',$data);
     }
     
     public function SaveReAlongInplaceDetails(){
         $db=  $this->session->userdata('db');
            //var_dump($this->input->post());
         $case_no = $this->input->post('case_no');
         $petition_no = $this->input->post('petition_no');
         
         $details = $this->db->query("Select * from    petition_basic where case_no = '$case_no' and petition_no = '$petition_no' ")->row();
         $dag_details = $this->db->query("Select * from    petition_dag_details where dist_code='$details->dist_code' and subdiv_code='$details->subdiv_code' "
            . "and cir_code='$details->cir_code' and lot_no='$details->lot_no' and vill_townprt_code='$details->vill_townprt_code' and mouza_pargona_code='$details->mouza_pargona_code' "
            . "and petition_no='$details->petition_no' ")->row();
            // Add the pattadars
         $pdar_name = $this->input->post('pdar_name');
         $striked_out = $this->input->post('striked_out');
         $count_pattadars  = count($pdar_name);
         
         for ($j = 0; $j < $count_pattadars; $j++){
            $pdar_id = $pdar_name[$j];
            $pdar_cron_no = $j+1;
            $pdar_guard_reln = 'u';
            $where_condition="dist_code='$dag_details->dist_code' and subdiv_code='$dag_details->subdiv_code' and cir_code='$dag_details->cir_code' and 
                mouza_pargona_code='$dag_details->mouza_pargona_code' and vill_townprt_code='$dag_details->vill_townprt_code' and lot_no='$dag_details->lot_no'
                and 
                TRIM(patta_no)=trim('$dag_details->patta_no') and patta_type_code='$dag_details->patta_type_code' and pdar_id = '$pdar_id' ";

            $pattadar = $this->db->query("select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln from (select pdar_id,pdar_name,pdar_father,pdar_add1,pdar_add2,pdar_add3,pdar_guard_reln chitha_pattadar where $where_condition) p join  
                (select pdar_id from chitha_dag_pattadar where $where_condition and dag_no='$dag_details->dag_no' and (p_flag is null or p_flag!=1)) d on  p.pdar_id = d.pdar_id   ")->row();
                //var_dump($pattadar);
            if($pattadar->pdar_guard_reln != null){
                $pdar_guard_reln = $pattadar->pdar_guard_reln;
            }
            $pattadardata = array(
                'dist_code' => $dag_details->dist_code,
                'subdiv_code' => $dag_details->subdiv_code,
                'cir_code' => $dag_details->cir_code,
                'mouza_pargona_code' => $dag_details->mouza_pargona_code,
                'lot_no' => $dag_details->lot_no,
                'vill_townprt_code' => $dag_details->vill_townprt_code,
                'year_no' => $this->session->userdata('year_no'),
                'petition_no' => $details->petition_no,
                'dag_no' => $dag_details->dag_no,
                'patta_no' => $dag_details->patta_no,
                'patta_type_code' => $dag_details->patta_type_code,
                'pdar_id' => $pdar_id,
                'pdar_cron_no' => $pdar_cron_no,
                'pdar_name' => $pattadar->pdar_name,
                'pdar_guardian' => $pattadar->pdar_father,
                'pdar_rel_guar' => $pdar_guard_reln,
                'pdar_add1' => $pattadar->pdar_add1,
                'pdar_add2' => $pattadar->pdar_add2,
                'user_code' => $this->input->post('lm_code'),
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'striked_out' => $striked_out[$j],
            );
                //var_dump($pattadardata);
                $this->db->insert("petition_pattadar", $pattadardata); //************************
            }
            redirect(base_url() . "index.php/coofficemutation/finalorderstep6?case_no=" . $case_no . "&dist_code=" . $dag_details->dist_code . "&subdiv_code=" . $dag_details->subdiv_code . "&cir_code=" . $dag_details->cir_code . "&mouza_pargona_code=" . $dag_details->mouza_pargona_code . "&lot_no=" . $dag_details->lot_no . "&vill_townprt_code=" . $dag_details->vill_townprt_code);
        }
        
        public function autoUpdate($dist_code, $subdiv_code, $cir_code, $lot_no, $vill_code, $mouza_pargona_code, $petition_no, $dag_no) {
         $db=  $this->session->userdata('db');
         $this->db->trans_begin();
         $record_count = 0;

         $patta_no = "";
         $locationData = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_code,
            'mouza_pargona_code' => $mouza_pargona_code,
        );

         $q = "select max(ord_cron_no)+1 as c1,max(rmk_type_hist_no)+1 as c2 from    chitha_rmk_ordbasic where"
         . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
         . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and mouza_pargona_code='$mouza_pargona_code'";

         $ord_cron_no = $this->db->query($q)->row()->c1;
         $q = "select max(rmk_type_hist_no)+1 as c2 from    chitha_rmk_gen where"
         . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
         . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and mouza_pargona_code='$mouza_pargona_code'";
         $rmk_type_hist_no = $this->db->query($q)->row()->c2;

         if ($ord_cron_no == null) {
            $ord_cron_no = 1;
        }
        if ($rmk_type_hist_no == null) {
            $rmk_type_hist_no = 1;
        }
        $order_query = "select * from    t_chitha_rmk_ordbasic where "
        . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
        . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and ord_type_code='03' and mouza_pargona_code='$mouza_pargona_code' and dag_no='$dag_no' and iscorrected_inco is null ";
        $orders = $this->db->query($order_query)->result();
        $case_no = null;
        foreach ($orders as $order) {
            $case_no = $order->ord_no;
                //copy alongwith information from    transaction to chitha
            $record_count++;
            $alongwith_q = "select * from    t_chitha_rmk_alongwith where ord_no='$order->ord_no'";
            $alongwith_d = $this->db->query($alongwith_q)->result();
            foreach ($alongwith_d as $along) {
                $ord_cron_no = $ord_cron_no;
                unset($along->year_no);
                unset($along->petition_no);
                unset($along->iscorrected_inco);
                unset($along->iscorrected_inco_date);
                unset($along->iscorrected_rkg_record);
                unset($along->iscorrected_rkg_date);
                unset($along->make_mdb);
                $along->rmk_type_hist_no = $rmk_type_hist_no;
                $along->ord_cron_no = $ord_cron_no;
                $along->user_code = $this->user_code;
                $along->operation = 'E';
                $along->date_entry = date('Y-m-d G:i:s');
                    //var_dump($along);
                    $this->db->insert("chitha_rmk_alongwith", $along); //*****************
                }

                $inplace_q = "select * from    t_chitha_rmk_inplace_of where ord_no='$order->ord_no'";
                $inplace_d = $this->db->query($inplace_q)->result();
                foreach ($inplace_d as $inplace) {
                    $petition_no = $inplace->petition_no;
                    $ord_cron_no = $ord_cron_no;
                    unset($inplace->year_no);
                    unset($inplace->petition_no);
                    unset($inplace->iscorrected_inco);
                    unset($inplace->iscorrected_inco_date);
                    unset($inplace->iscorrected_rkg_record);
                    unset($inplace->iscorrected_rkg_date);
                    unset($inplace->make_mdb);

                    $inplace->rmk_type_hist_no = $rmk_type_hist_no;
                    $inplace->ord_cron_no = $ord_cron_no;
                    $inplace->user_code = $this->user_code;
                    $inplace->operation = 'E';
                    $inplace->date_entry = date('Y-m-d G:i:s');
                    //var_dump($inplace);

                    $this->db->insert("chitha_rmk_inplace_of", $inplace); //**************
                    $details = $this->db->query("select * from    petition_dag_details where petition_no=$petition_no and $this->base_query")->row();

                    // $update_query = "update  chitha_dag_pattadar set p_flag='1' where "
                    // . " dist_code ='$inplace->dist_code' and subdiv_code='$inplace->subdiv_code' and "
                    // . " cir_code ='$inplace->cir_code' and mouza_pargona_code='$inplace->mouza_pargona_code' and"
                    // . " lot_no='$inplace->lot_no' and vill_townprt_code='$inplace->vill_townprt_code' and"
                    // . " TRIM(patta_no)=trim('$details->patta_no') and dag_no='$details->dag_no' and patta_type_code='$details->patta_type_code' "
                    // . " and pdar_id=$inplace->pdar_id ";
                    // //echo $update_query;;
                    // $patta_no = trim($details->patta_no);
                    // $this->db->query($update_query);

                    $table = 'chitha_dag_pattadar';

                    $params = [
                        'p_flag' => '1',
                    ];

                    $where = [
                        'dist_code'          => $inplace->dist_code,
                        'subdiv_code'        => $inplace->subdiv_code,
                        'cir_code'           => $inplace->cir_code,
                        'mouza_pargona_code' => $inplace->mouza_pargona_code,
                        'lot_no'             => $inplace->lot_no,
                        'vill_townprt_code'  => $inplace->vill_townprt_code,
                        'dag_no'             => $details->dag_no,
                        'patta_type_code'    => $details->patta_type_code,
                        'pdar_id'            => $inplace->pdar_id,
                        'patta_no' => trim($details->patta_no)
                    ];

                    $this->Chitha_basic_model->update_table($table, $params, $where);

                }

                $infavour_q = "select * from    t_chitha_rmk_infavor_of where ord_no='$order->ord_no'";
                $infavour_d = $this->db->query($infavour_q)->result();
                foreach ($infavour_d as $infavour) {
                    $infavour->user_code = $this->user_code;
                    $infavour->operation = 'E';
                    $infavour->rmk_type_hist_no = $rmk_type_hist_no;
                    $infavour->ord_cron_no = $ord_cron_no;
                    $infavour->date_entry = date('Y-m-d G:i:s');
                    unset($infavour->year_no);
                    unset($infavour->petition_no);
                    unset($infavour->iscorrected_inco);
                    unset($infavour->iscorrected_inco_date);
                    unset($infavour->iscorrected_rkg_record);
                    unset($infavour->iscorrected_rkg_date);
                    unset($infavour->make_mdb);
                    unset($infavour->pdar_id);
                    unset($infavour->revenue);
                    unset($infavour->infavor_is_copdar);
                    $new_pattadar = $infavour->new_pattadar;
                    unset($infavour->new_pattadar);
                    //var_dump($infavour);
                    //save new pattadar in infavour of
                    $this->db->insert("chitha_rmk_infavor_of", $infavour);

                    $newObj = clone $infavour;
                    $pattadar = array();
                    $pattadar = array_merge($pattadar, $locationData);
                    unset($pattadar['application_no']);

                    $pdar_id_query = "select max(cast(pdar_id as int))+1 as pdar_id from    chitha_pattadar  where "
                    . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
                    . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and mouza_pargona_code='$mouza_pargona_code' "
                    . " and TRIM(patta_no)=trim('$infavour->patta_no') and patta_type_code='$infavour->patta_type_code'";
                    $pdar_id = $this->db->query($pdar_id_query)->row()->pdar_id;

                    //echo $pdar_id_query;
                    if ($pdar_id == null) {
                        $pdar_id = 1;
                    }
                    $other_data = array(
                        'pdar_id' => $pdar_id,
                        'patta_no' => trim($infavour->patta_no),
                        'patta_type_code' => $infavour->patta_type_code,
                        'pdar_name' => $infavour->infavor_of_name,
                        'pdar_father' => $infavour->infavor_of_guardian,
                        'pdar_name_eng' => $infavour->pdar_name_eng,
                        'pdar_guard_eng' => $infavour->pdar_guard_eng,
                        'pdar_add1' => $infavour->infavor_of_add1,
                        'pdar_add2' => $infavour->infavor_of_add2,
                        'pdar_add3' => "",
                        'user_code' => $infavour->user_code,
                        'date_entry' => date('Y-m-d G:i:s'),
                        'operation' => 'E',
                        'jama_yn' => 'n',
                        'pdar_guard_reln' => $infavour->infav_of_guar_relation,
                        'new_pdar_name' => $new_pattadar
                    );

                    $details = $this->db->query("select * from    petition_dag_details where petition_no=$petition_no and $this->base_query")->row();
                    $patta_no = trim($details->patta_no);
                    $pattadar = array_merge($pattadar, $other_data);
                    // $this->db->insert("chitha_pattadar", $pattadar);
                    $pattadar['f1_case_no']=$case_no;
                    $this->Chitha_basic_model->insert_table('chitha_pattadar',$pattadar);

                    $dag_pattadar = array();
                    $dag_pattadar = array_merge($dag_pattadar, $locationData);
                    unset($dag_pattadar['application_no']);

                    $dag_pattadar_other = array(
                        'pdar_id' => $pdar_id,
                        'patta_no' => trim($infavour->patta_no),
                        'patta_type_code' => $infavour->patta_type_code,
                        'dag_por_b' => $infavour->land_area_b,
                        'dag_por_k' => $infavour->land_area_k,
                        'dag_por_lc' => $infavour->land_area_lc,
                        'dag_por_g' => $infavour->land_area_g,
                        'dag_por_kr' => $infavour->land_area_kr,
                        'user_code' => $this->user_code,
                        'date_entry' => date('Y-m-d G:i:s'),
                        'operation' => 'E',
                        'jama_yn' => 'n',
                        'dag_no' => $infavour->dag_no,
                        'p_flag' => 0,
                    );
                    $dag_pattadar = array_merge($dag_pattadar, $dag_pattadar_other);
                    // $this->db->insert("chitha_dag_pattadar", $dag_pattadar);
                    $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$dag_pattadar);
                    // $q = "update  chitha_basic set jama_yn=null where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                    // . "cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and "
                    // . "lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$infavour->dag_no' and TRIM(patta_no)=trim('$infavour->patta_no')";

                    // $this->db->query($q);
                    $table = "chitha_basic";

                    $params = [
                        'jama_yn' => null
                    ];

                    $where = [
                        'dist_code'          => $dist_code,
                        'subdiv_code'        => $subdiv_code,
                        'cir_code'           => $cir_code,
                        'mouza_pargona_code' => $mouza_pargona_code,
                        'lot_no'             => $lot_no,
                        'vill_townprt_code'  => $vill_code,
                        'dag_no'             => $infavour->dag_no,
                        'patta_no'           => trim($infavour->patta_no) // handles TRIM(patta_no)=trim(...)
                    ];

                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                }

                $order->user_code = $this->user_code;
                $order->date_entry = date('Y-m-d G:i:s');
                $order->operation = 'E';
                $order->user_code = $this->user_code;
                //var_dump($order);
                unset($order->year_no);
                unset($order->petition_no);
                unset($order->year_no);
                unset($order->iscorrected_inco);
                unset($order->iscorrected_inco_date);
                unset($order->iscorrected_rkg_record);
                unset($order->iscorrected_rkg_date);
                unset($order->isdataposted_torkg_db);
                unset($order->isorder_cancelled);
                unset($order->ifyes_reason1);
                unset($order->ifyes_reason2);
                unset($order->ifyes_reason3);
                unset($order->ifyes_reason4);
                unset($order->make_mdb);
                unset($order->min_revenue);
                unset($order->make_mdb);

                $rmk_gen = array(
                    'dag_no' => $dag_no,
                    'rmk_type_code' => '01',
                    'rmk_type_hist_no' => $rmk_type_hist_no,
                    'user_code' => $this->user_code,
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'E',
                    'jama_updated' => 'N',
                    'patta_no' => trim($patta_no)
                );
                $rmk_gen = array_merge($locationData, $rmk_gen);
                unset($rmk_gen['application_no']);

                $this->db->insert("chitha_rmk_gen", $rmk_gen);
                $order->ord_cron_no = $ord_cron_no;
                $order->rmk_type_hist_no = $rmk_type_hist_no;
                //var_dump($rmk_gen);
                $this->db->insert("chitha_rmk_ordbasic", $order);
                $q = "update  t_chitha_rmk_ordbasic set iscorrected_inco='Y' where ord_no='$order->ord_no'";
                $this->db->query($q);
                $rmk_type_hist_no++;
            }
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        }

        public function getOfficeMutationPetitions($d, $s, $c, $m, $l, $v) {
         $db=  $this->session->userdata('db');
         $query = "select * from    t_Chitha_Rmk_Ordbasic where"
         . " dist_code='$d' and cir_code='$c' and subdiv_code='$s' and mouza_pargona_code='$m' and"
         . " lot_no='$l' and vill_townprt_code='$v' and iscorrected_inco is null";

         $data = $this->db->query($query)->result();
         $json = array();
         foreach ($data as $d) {
            $json[] = array('petition' => $d->petition_no, 'dag' => $d->dag_no);
        }
        echo json_encode($json);
    }

    public function updateChitha() {
     $db=  $this->session->userdata('db');
     if ($this->input->server('REQUEST_METHOD') == 'POST') {
        $this->db->trans_begin();
        $record_count = 0;
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('circle_code');
        $lot_no = $this->input->post('lot_no');
        $vill_code = $this->input->post('vill_code');
        $mouza_pargona_code = $this->input->post('mouza_code');
        $application = $this->input->post('application_no');
        $locationData = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'application_no' => $application
        );
                ////////var_dump($locationData);
                //$petition_no = explode("-", $application)[0];
                //$dag_no = explode("-", $application)[1];
        $petition_no = explode("-", $application);
        $petition_no = $petition[0];
        $dag_no = explode("-", $application);
        $dag_no=$dag_no[1];
        
        $q = "select max(ord_cron_no)+1 as c1,max(rmk_type_hist_no)+1 as c2 from    chitha_rmk_ordbasic where"
        . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
        . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and mouza_pargona_code='$mouza_pargona_code'";

        $ord_cron_no = $this->db->query($q)->row()->c1;
        $q = "select max(rmk_type_hist_no)+1 as c2 from    chitha_rmk_gen where"
        . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
        . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and mouza_pargona_code='$mouza_pargona_code'";
        $rmk_type_hist_no = $this->db->query($q)->row()->c2;
        if ($ord_cron_no == null) {
            $ord_cron_no = 1;
        }
        if ($rmk_type_hist_no == null) {
            $rmk_type_hist_no = 1;
        }
        $order_query = "select * from    t_chitha_rmk_ordbasic where "
        . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
        . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and mouza_pargona_code='$mouza_pargona_code' "
        . " and iscorrected_inco is null";
                //echo $order_query;
        $orders = $this->db->query($order_query)->result();
        $case_no = null;
        foreach ($orders as $order) {
            $case_no = $order->ord_no;
                    //copy alongwith information from    transaction to chitha
            $record_count++;
            $alongwith_q = "select * from    t_chitha_rmk_alongwith where ord_no='$order->ord_no'";
            $alongwith_d = $this->db->query($alongwith_q)->result();
            foreach ($alongwith_d as $along) {

                $ord_cron_no = $ord_cron_no;
                unset($along->year_no);
                unset($along->petition_no);
                unset($along->iscorrected_inco);
                unset($along->iscorrected_inco_date);
                unset($along->iscorrected_rkg_record);
                unset($along->iscorrected_rkg_date);
                unset($along->make_mdb);
                $along->rmk_type_hist_no = $rmk_type_hist_no;
                $along->ord_cron_no = $ord_cron_no;
                $along->user_code = $this->user_code;
                $along->operation = 'E';
                $along->date_entry = date('Y-m-d G:i:s');
                $this->db->insert('chitha_rmk_alongwith', $along);
            }
            $inplace_q = "select * from    t_chitha_rmk_inplace_of where ord_no='$order->ord_no'";
            $inplace_d = $this->db->query($inplace_q)->result();
            foreach ($inplace_d as $inplace) {
                $petition_no = $inplace->petition_no;
                $ord_cron_no = $ord_cron_no;
                unset($inplace->year_no);
                unset($inplace->petition_no);
                unset($inplace->iscorrected_inco);
                unset($inplace->iscorrected_inco_date);
                unset($inplace->iscorrected_rkg_record);
                unset($inplace->iscorrected_rkg_date);
                unset($inplace->make_mdb);

                $inplace->rmk_type_hist_no = $rmk_type_hist_no;
                $inplace->ord_cron_no = $ord_cron_no;
                $inplace->user_code = $this->user_code;
                $inplace->operation = 'E';
                $inplace->date_entry = date('Y-m-d G:i:s');
                        ////////var_dump($inplace);
                $this->db->insert('chitha_rmk_inplace_of', $inplace);
                $details = $this->db->query("select * from    petition_dag_details where"
                    . " petition_no=$petition_no")->row();
                // $update_query = "update chitha_dag_pattadar set p_flag='1' where "
                // . " dist_code ='$inplace->dist_code' and subdiv_code='$inplace->subdiv_code' and "
                // . " cir_code ='$inplace->cir_code' and mouza_pargona_code='$inplace->mouza_pargona_code' and"
                // . " lot_no='$inplacie->lot_no' and vill_townprt_code='$inplace->vill_townprt_code' and"
                // . " TRIM(patta_no)=trim('$details->patta_no') and dag_no='$details->dag_no' and patta_type_code='$details->patta_type_code' "
                // . " and pdar_id=$inplace->pdar_id ";
                //         //echo $update_query;
                // $this->db->query($update_query);
                $table = 'chitha_dag_pattadar';

                $params = [
                    'p_flag' => '1',
                ];

                $where = [
                    'dist_code'          => $inplace->dist_code,
                    'subdiv_code'        => $inplace->subdiv_code,
                    'cir_code'           => $inplace->cir_code,
                    'mouza_pargona_code' => $inplace->mouza_pargona_code,
                    'lot_no'             => $inplace->lot_no,
                    'vill_townprt_code'  => $inplace->vill_townprt_code,
                    'patta_no'           => trim($details->patta_no),  // apply trim here in PHP before passing
                    'dag_no'             => $details->dag_no,
                    'patta_type_code'    => $details->patta_type_code,
                    'pdar_id'            => $inplace->pdar_id,
                ];

                // Then call your update function
                $result = $this->Chitha_basic_model->update_table($table, $params, $where);

            }


            $infavour_q = "select * from    t_chitha_rmk_infavor_of where ord_no='$order->ord_no'";
            $infavour_d = $this->db->query($infavour_q)->result();
            foreach ($infavour_d as $infavour) {


                $infavour->user_code = $this->user_code;
                $infavour->operation = 'E';
                $infavour->rmk_type_hist_no = $rmk_type_hist_no;
                $infavour->ord_cron_no = $ord_cron_no;
                $infavour->date_entry = date('Y-m-d G:i:s');
                unset($infavour->year_no);
                unset($infavour->petition_no);
                unset($infavour->iscorrected_inco);
                unset($infavour->iscorrected_inco_date);
                unset($infavour->iscorrected_rkg_record);
                unset($infavour->iscorrected_rkg_date);
                unset($infavour->make_mdb);
                unset($infavour->pdar_id);
                unset($infavour->revenue);
                unset($infavour->infavor_is_copdar);
                $new_pattadar = $infavour->new_pattadar;
                unset($infavour->new_pattadar);
                        //save new pattadar in infavour of
                $this->db->insert('chitha_rmk_infavor_of', $infavour);

                $newObj = clone $infavour;
                $pattadar = array();
                $pattadar = array_merge($pattadar, $locationData);
                unset($pattadar['application_no']);

                $pdar_id_query = "select max(cast(pdar_id as int))+1 as pdar_id from    chitha_pattadar where "
                . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
                . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and mouza_pargona_code='$mouza_pargona_code' "
                . " and TRIM(patta_no)=trim('$infavour->patta_no') and patta_type_code='$infavour->patta_type_code'";
                $pdar_id = $this->db->query($pdar_id_query)->row()->pdar_id;
                        //echo $pdar_id_query;

                if ($pdar_id == null) {
                    $pdar_id = 1;
                }
                $other_data = array(
                    'pdar_id' => $pdar_id,
                    'patta_no' => trim($infavour->patta_no),
                    'patta_type_code' => $infavour->patta_type_code,
                    'pdar_name' => $infavour->infavor_of_name,
                    'pdar_father' => $infavour->infavor_of_guardian,
                    'pdar_add1' => $infavour->infavor_of_add1,
                    'pdar_add2' => $infavour->infavor_of_add2,
                    'pdar_add3' => "",
                    'user_code' => $infavour->user_code,
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'E',
                    'jama_yn' => 'n',
                    'pdar_guard_reln' => $infavour->infav_of_guar_relation,
                    'new_pdar_name' => $new_pattadar
                );
                $pattadar = array_merge($pattadar, $other_data);
                        ////////var_dump($pattadar);
                // $this->db->insert('chitha_pattadar', $pattadar);
                $pattadar['f1_case_no']=$case_no;
                $this->Chitha_basic_model->insert_table('chitha_pattadar',$pattadar);

                $dag_pattadar = array();
                $dag_pattadar = array_merge($dag_pattadar, $locationData);
                unset($dag_pattadar['application_no']);
                        ////////var_dump($infavour);

                $dag_pattadar_other = array(
                    'pdar_id' => $pdar_id,
                    'patta_no' => trim($infavour->patta_no),
                    'patta_type_code' => $infavour->patta_type_code,
                    'dag_por_b' => $infavour->land_area_b,
                    'dag_por_k' => $infavour->land_area_k,
                    'dag_por_lc' => $infavour->land_area_lc,
                    'dag_por_g' => $infavour->land_area_g,
                    'dag_por_kr' => $infavour->land_area_kr,
                    'user_code' => $this->user_code,
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'E',
                    'jama_yn' => 'n',
                    'dag_no' => $infavour->dag_no,
                    'p_flag' => 0,
                );
                $dag_pattadar = array_merge($dag_pattadar, $dag_pattadar_other);
                // $this->db->insert('chitha_dag_pattadar', $dag_pattadar);
                $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$dag_pattadar);
                // $q = "update chitha_basic set jama_yn=null where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                // . "cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and "
                // . "lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$infavour->dag_no' and TRIM(patta_no)='trim($infavour->patta_no)'";

                // $this->db->query($q);

                $table = "chitha_basic";

                $params = [
                    'jama_yn' => null
                ];

                $where = [
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'dag_no' => $infavour->dag_no,
                    'patta_no' => trim($infavour->patta_no)
                ];

                $this->Chitha_basic_model->update_table($table, $params, $where);

            }

            $order->user_code = $this->user_code;
            $order->date_entry = date('Y-m-d G:i:s');
            $order->operation = 'E';
            $order->user_code = $this->user_code;
                    //var_dump($order);
            unset($order->year_no);
            unset($order->petition_no);
            unset($order->year_no);
            unset($order->iscorrected_inco);
            unset($order->iscorrected_inco_date);
            unset($order->iscorrected_rkg_record);
            unset($order->iscorrected_rkg_date);
            unset($order->isdataposted_torkg_db);
            unset($order->isorder_cancelled);
            unset($order->ifyes_reason1);
            unset($order->ifyes_reason2);
            unset($order->ifyes_reason3);
            unset($order->ifyes_reason4);
            unset($order->make_mdb);
            unset($order->min_revenue);
            unset($order->make_mdb);



            $rmk_gen = array(
                'dag_no' => $dag_no,
                'rmk_type_code' => '01',
                'rmk_type_hist_no' => $rmk_type_hist_no,
                'user_code' => $this->user_code,
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'jama_updated' => 'n',
                'patta_no' => trim($infavour->patta_no)
            );
            $rmk_gen = array_merge($locationData, $rmk_gen);
                    ////var_dump($rmk_gen);
            unset($rmk_gen['application_no']);
            $this->db->insert('chitha_rmk_gen', $rmk_gen);
            $order->ord_cron_no = $ord_cron_no;
            $order->rmk_type_hist_no = $rmk_type_hist_no;
            $this->db->insert('chitha_rmk_ordbasic', $order);
            $q = "update t_chitha_rmk_ordbasic set iscorrected_inco='Y' where ord_no='$order->ord_no'";
            $this->db->query($q);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
                    //echo "Error Occured";
        } else {
            $this->db->trans_commit();
            return true;
        }
    } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
        $this->load->model('mutation/mutationmodel');
        $this->load->helper('html');
        $this->load->view('../views/header');
        $this->load->view('../views/common/bar');
                //$this->load->view('menu/menu4');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouzas = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code);
        $district['d'] = $dist_code;
        $district['s'] = $subdiv_code;
        $district['c'] = $cir_code;
        $district['mouzas'] = $mouzas;
        $data = $this->mutationmodel->getDistricts();
        $district['names'] = $data;
        $this->load->view('../views/officemutation/select_location', $district);
        $this->load->view('../views/footer');
    }
    }

    // public function updateChithaConversion() {
    //  $db=  $this->session->userdata('db');
    //  $query = "select * from    t_chitha_rmk_ordbasic "
    //  . "where (iscorrected_inco is null or iscorrected_inco=' ')  and ord_type_code='01'";
    //         //echo $query;
    //  $result = $this->db->query($query)->result();
    //  foreach ($result as $order) {
    //     $query_rmk_hist = "select max(rmk_type_hist_no) as c from    chitha_rmk_convorder where "
    //     . "dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' and cir_code='$order->cir_code'"
    //     . " and lot_no='$order->lot_no' and mouza_pargona_code='$order->mouza_pargona_code' and "
    //     . " vill_townprt_code='$order->vill_townprt_code' and dag_no='$order->dag_no' ";
    //     $rmk_hist_no = $this->db->query($query_rmk_hist)->row()->c;
    //     if ($rmk_hist_no == null) {
    //         $rmk_hist_no = 1;
    //     } else
    //     $rmk_hist_no += 1;

    //     $q = "select max(ord_cron_no)+1 as c1,max(rmk_type_hist_no)+1 as c2 from    chitha_rmk_ordbasic where "
    //     . "dist_code='$order->dist_code' and subdiv_code='$order->subdiv_code' and cir_code='$order->cir_code'"
    //     . " and lot_no='$order->lot_no' and mouza_pargona_code='$order->mouza_pargona_code' and "
    //     . " vill_townprt_code='$order->vill_townprt_code' and dag_no='$order->dag_no' ";

    //     $ord_cron_no = $this->db->query($q)->row()->c1;
    //     if ($ord_cron_no == null) {
    //         $ord_cron_no = 1;
    //     } else {
    //         $ord_cron_no+=1;
    //     }

    //     $query = "select * from    t_chitha_rmk_convorder where ord_no='$order->ord_no' and iscorrected_inco is null ";
    //     $pattdars = $this->db->query($query)->result();
    //     foreach ($pattdars as $p) {
    //         $c = $p;
    //         $ord = clone $p;
    //         unset($c->year_no);
    //         unset($c->petition_no);
    //         unset($c->ord_no);
    //         unset($c->petition_no);
    //         unset($c->ord_date);
    //         unset($c->ord_date);
    //         unset($c->iscorrected_inco);
    //         unset($c->iscorrected_inco_date);
    //         unset($c->iscorrected_rkg_record);
    //         unset($c->iscorrected_rkg_date);
    //         unset($c->pdar_id);
    //         unset($c->pdar_strike);
    //         unset($c->ord_onbehalf_guard);
    //         unset($c->ord_onbehalf_add1);
    //         unset($c->ord_onbehalf_add2);
    //         unset($c->make_mdb);
    //         unset($c->is_converted_pattadar);
    //         unset($c->is_converted_pattadar);
    //         $c->rmk_type_hist_no = $rmk_hist_no;
    //         $c->ord_cron_no = $rmk_hist_no;
    //         $c->user_code = $this->session->userdata('user_code');
    //         $c->date_entry = date('Y-m-d G:i:s');
    //         $c->operation = 'E';

    //         $this->db->insert('chitha_rmk_convorder', $c);
    //         $d = date('Y-m-d');
    //         $update_conv_order_q = "update t_chitha_rmk_convorder set iscorrected_inco='Y',iscorrected_inco_date='$d' "
    //         . " where ord_no='$order->ord_no'";
    //         $this->db->query($update_conv_order_q);

    //         $data = array(
    //             'pdar_name' => $ord->ord_onbehalf_of,
    //             'pdar_father' => $ord->ord_onbehalf_guard,
    //             'patta_no' => trim($ord->new_patta_no),
    //             'patta_type_code' => $ord->new_patta_type,
    //             'pdar_add1' => $ord->ord_onbehalf_add1,
    //             'pdar_add2' => $ord->ord_onbehalf_add1,
    //             'user_code' => $this->session->userdata('user_code'),
    //             'date_entry' => date('Y-m-d G:i:s'),
    //             'operation' => 'E',
    //             'pdar_guard_reln' => 'u',
    //             'dist_code' => $ord->dist_code,
    //             'subdiv_code' => $ord->subdiv_code,
    //             'cir_code' => $ord->cir_code,
    //             'mouza_pargona_code' => $ord->mouza_pargona_code,
    //             'lot_no' => $ord->lot_no,
    //             'vill_townprt_code' => $ord->vill_townprt_code,
    //             'pdar_id' => $ord->pdar_id,
    //             'new_pdar_name' => 'N',
    //             'jama_yn' => 'n'
    //         );

    //         $this->db->insert('chitha_pattadar', $data);

    //         $landArea_query = "select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr from    chitha_basic"
    //         . "  where dist_code='$ord->dist_code' and"
    //         . " subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
    //         . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
    //         . " vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no'  "
    //         . " and TRIM(patta_no)=trim('$ord->patta_no') and patta_type_code='$ord->patta_type_code'";
    //                 //echo $landArea_query;



    //         $b = $this->db->query($landArea_query)->row()->dag_area_b - $ord->land_area_b;
    //         $k = $this->db->query($landArea_query)->row()->dag_area_k - $ord->land_area_k;
    //         $lc = $this->db->query($landArea_query)->row()->dag_area_lc - $ord->land_area_lc;
    //         $g = 0.0;
    //         $kr = 0.0;



    //         // $chitha_update = "update chitha_basic set dag_area_b=$b,dag_area_k=$k,"
    //         // . " dag_area_lc=$lc,dag_area_g=$g,dag_area_kr=$kr  where dist_code='$ord->dist_code' and"
    //         // . " subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
    //         // . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
    //         // . " vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no'  "
    //         // . " and TRIM(patta_no)=trim('$ord->patta_no') and patta_type_code='$ord->patta_type_code'";
    //         //         //echo $chitha_update;
    //         // $this->db->query($chitha_update);

    //         $table = "chitha_basic";

    //         $params = [
    //             'dag_area_b' => $b,
    //             'dag_area_k' => $k,
    //             'dag_area_lc' => $lc,
    //             'dag_area_g' => $g,
    //             'dag_area_kr' => $kr
    //         ];

    //         $where = [
    //             'dist_code' => $ord->dist_code,
    //             'subdiv_code' => $ord->subdiv_code,
    //             'cir_code' => $ord->cir_code,
    //             'lot_no' => $ord->lot_no,
    //             'mouza_pargona_code' => $ord->mouza_pargona_code,
    //             'vill_townprt_code' => $ord->vill_townprt_code,
    //             'dag_no' => $ord->dag_no,
    //             'patta_no' => trim($ord->patta_no),
    //             'patta_type_code' => $ord->patta_type_code
    //         ];

    //         $result = $this->Chitha_basic_model->update_table($table, $params, $where);


    //         $landclass_query = "select land_class_code from    petition_lm_note  where dist_code='$ord->dist_code' and"
    //         . " subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
    //         . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
    //         . " vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no' "
    //         . " and co_reject is null order by note_no desc limit 1";
    //                 //echo $landclass_query;
    //         $landclasscode = $this->db->query($landclass_query)->row()->land_class_code;

    //         $chitha_basic = array(
    //             'dist_code' => $ord->dist_code,
    //             'subdiv_code' => $ord->subdiv_code,
    //             'cir_code' => $ord->cir_code,
    //             'mouza_pargona_code' => $ord->mouza_pargona_code,
    //             'lot_no' => $ord->lot_no,
    //             'vill_townprt_code' => $ord->vill_townprt_code,
    //             'patta_no' => trim($ord->new_patta_no),
    //             'old_patta_no' => trim($ord->patta_no),
    //             'old_dag_no' => $ord->dag_no,
    //             'dag_no' => $ord->new_dag_no,
    //             'patta_type_code' => $ord->new_patta_type,
    //             'dag_area_b' => $ord->land_area_b,
    //             'dag_area_k' => $ord->land_area_k,
    //             'dag_area_lc' => $ord->land_area_lc,
    //             'dag_area_g' => 0.0,
    //             'dag_area_kr' => 0,
    //             'user_code' => $this->session->userdata('user_code'),
    //             'date_entry' => date('Y-m-d G:i:s'),
    //             'operation' => 'E',
    //             'jama_yn' => 'n',
    //             'land_class_code' => $landclasscode
    //         );

    //         // $this->db->insert('chitha_basic', $chitha_basic);
    //         $this->Chitha_basic_model->insert_table('chitha_basic',$chitha_basic);

    //         $update_query = "update chitha_dag_pattadar set p_flag='1',operation='M' where "
    //         . "dist_code='$ord->dist_code' and subdiv_code='$ord->subdiv_code' and cir_code='$ord->cir_code'"
    //         . " and lot_no='$ord->lot_no' and mouza_pargona_code='$ord->mouza_pargona_code' and "
    //         . " vill_townprt_code='$ord->vill_townprt_code' and dag_no='$ord->dag_no' "
    //         . " and pdar_id=$ord->ord_onbehalf_id and patta_type_code='$ord->patta_type_code' and "
    //         . " pdar_id=$ord->pdar_id";
    //         $this->db->query($update_query);

    //         $dag_pattadar = array(
    //             'dist_code' => $ord->dist_code,
    //             'subdiv_code' => $ord->subdiv_code,
    //             'cir_code' => $ord->cir_code,
    //             'mouza_pargona_code' => $ord->mouza_pargona_code,
    //             'lot_no' => $ord->lot_no,
    //             'vill_townprt_code' => $ord->vill_townprt_code,
    //             'pdar_id' => $ord->pdar_id,
    //             'patta_no' => trim($ord->new_patta_no),
    //             'dag_no' => $ord->new_dag_no,
    //             'patta_type_code' => $ord->new_patta_type,
    //             'dag_por_b' => $ord->land_area_b,
    //             'dag_por_k' => $ord->land_area_k,
    //             'dag_por_lc' => $ord->land_area_lc,
    //             'dag_por_g' => 0.0,
    //             'dag_por_kr' => 0,
    //             'user_code' => $this->session->userdata('user_code'),
    //             'date_entry' => date('Y-m-d G:i:s'),
    //             'operation' => 'E',
    //         );

    //         $this->db->insert('chitha_dag_pattadar', $dag_pattadar);
    //     }




    //     unset($order->year_no);
    //     unset($order->petition_no);

    //     unset($order->petition_no);

    //     unset($order->iscorrected_inco);
    //     unset($order->iscorrected_inco_date);
    //     unset($order->iscorrected_rkg_record);
    //     unset($order->iscorrected_rkg_date);
    //     unset($order->pdar_id);
    //     unset($order->pdar_strike);
    //     unset($order->ord_onbehalf_guard);
    //     unset($order->ord_onbehalf_add1);
    //     unset($order->ord_onbehalf_add2);
    //     unset($order->make_mdb);
    //     unset($order->is_converted_pattadar);
    //     unset($order->patta_type_code);
    //     unset($order->patta_no);
    //     unset($order->ord_onbehalf_id);
    //     unset($order->ord_onbehalf_of);
    //     unset($order->premium);
    //     unset($order->premi_chal_recpt);
    //     unset($order->premi_chal_recpt_no);
    //     unset($order->land_area_b);
    //     unset($order->land_area_k);
    //     unset($order->land_area_lc);
    //     unset($order->min_revenue);
    //     unset($order->ifyes_reason3);
    //     unset($order->ifyes_reason2);
    //     unset($order->ifyes_reason1);
    //     unset($order->isorder_cancelled);
    //     unset($order->isdataposted_torkg_db);

    //     $order->ord_cron_no = $ord_cron_no;
    //     $order->rmk_type_hist_no = $rmk_hist_no;
    //     $order->user_code = $this->session->userdata('user_code');
    //     $order->operation = 'E';
    //     $order->date_entry = date('Y-m-d G:i:s');
    //     $order->area_left_b = 0;
    //     $order->area_left_k = 0;
    //     $order->area_left_lc = 0;
    //     $order->area_left_g = 0;
    //     $order->area_left_kr = 0;

    //             ////////var_dump($order);
    //     $rmk_gen = array(
    //         'dist_code' => $order->dist_code,
    //         'subdiv_code' => $order->subdiv_code,
    //         'cir_code' => $order->cir_code,
    //         'mouza_pargona_code' => $order->mouza_pargona_code,
    //         'vill_townprt_code' => $order->vill_townprt_code,
    //         'lot_no' => $order->lot_no,
    //         'dag_no' => $order->dag_no,
    //         'rmk_type_code' => '01',
    //         'rmk_type_hist_no' => $rmk_hist_no,
    //         'user_code' => $this->session->userdata('user_code'),
    //         'operation' => 'E',
    //         'date_entry' => date('Y-m-d G:i:s'),
    //         'jama_updated' => 'n',
    //         'new_dag_no' => $order->new_dag_no
    //     );
    //     $this->db->insert('chitha_rmk_gen', $rmk_gen);
    //     $this->db->insert('chitha_rmk_ordbasic', $order);
    //     $d = date('Y-m-d');
    //     $update_q = "update t_chitha_rmk_ordbasic set iscorrected_inco='Y',iscorrected_inco_date='$d'"
    //     . " where ord_no='$order->ord_no'  ";
    //     $this->db->query($update_q);
    // }
    // }

    public function updateChithaPartition() {
    $db=  $this->session->userdata('db');
    $query = "select * from    t_chitha_rmk_ordbasic "
    . "where (iscorrected_inco is null or iscorrected_inco=' ')  and ord_type_code='04'";
        //echo $query;
    $result = $this->db->query($query)->result();
    $case_no = null;
     foreach ($result as $order) {
        $case_no = $order->ord_no;
        $this->db->trans_begin();
        $query_rmk_hist = "select max(rmk_type_hist_no) as c from    chitha_rmk_convorder where "
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
        $infavQuery = "select * from    t_chitha_rmk_infavor_of where ord_no='$order->ord_no' and iscorrected_inco is null ";
        $infavData = $this->db->query($infavQuery)->result();
        $pdar_id = 1;
        $chitha_basic_update = 0;
        foreach ($infavData as $d) {
            $landclass_query = "select land_class_code from    chitha_basic  where dist_code='$d->dist_code' and"
            . " subdiv_code='$d->subdiv_code' and cir_code='$order->cir_code'"
            . " and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
            . " vill_townprt_code='$d->vill_townprt_code' and dag_no='$d->dag_no' "
            . " and patta_type_code='$d->patta_type_code' and TRIM(patta_no)=trim('$d->patta_no')";
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
                    'patta_type_code' => $d->patta_type_code,
                    'patta_no' => trim($d->new_patta_no),
                    'land_class_code' => $landclasscode,
                    'dag_area_b' => $d->land_area_b,
                    'dag_area_k' => $d->land_area_k,
                    'dag_area_lc' => $d->land_area_lc,
                    'dag_area_g' => 0.0,
                    'dag_area_kr' => 0,
                    'dag_revenue' => $d->revenue,
                    'dag_local_tax' => (($d->revenue) / 4)==null ? '4.00': ceil(($d->revenue) / 4),
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'E',
                    'jama_yn' => 'n',
                    'old_patta_no' => trim($d->patta_no)
                );
                        // //////var_dump($chitha_basic);
                // echo $this->db->insert('chitha_basic', $chitha_basic);
                $this->Chitha_basic_model->insert_table('chitha_basic',$chitha_basic);
                $chitha_basic_update = 1;

                $landArea_query = "select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,dag_revenue,dag_local_tax from    chitha_basic"
                . "  where dist_code='$d->dist_code' and  "
                . " subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code'"
                . " and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
                . " vill_townprt_code='$d->vill_townprt_code' and dag_no='$d->dag_no'  "
                . " and TRIM(patta_no)=trim('$d->patta_no') and patta_type_code='$d->patta_type_code'";

                $sourceB = $this->db->query($landArea_query)->row()->dag_area_b;
                $sourceK = $this->db->query($landArea_query)->row()->dag_area_k;
                $sourceL = $this->db->query($landArea_query)->row()->dag_area_lc;
                $sourceRev = $this->db->query($landArea_query)->row()->dag_revenue;
                $sourceLTax = $this->db->query($landArea_query)->row()->dag_local_tax;
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
                        // $chitha_update = "update chitha_basic set dag_area_b='$b',dag_area_k='$k',"
                        // . " dag_area_lc='$lc',dag_area_g='$g',dag_area_kr='$kr',dag_revenue='$new_revenue',dag_local_tax='$new_local_tax'  where dist_code='$d->dist_code' and"
                        // . " subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code'"
                        // . " and lot_no='$d->lot_no' and mouza_pargona_code='$d->mouza_pargona_code' and "
                        // . " vill_townprt_code='$d->vill_townprt_code' and dag_no='$d->dag_no'  "
                        // . " and TRIM(patta_no)=trim('$d->patta_no') and patta_type_code='$d->patta_type_code'";

                        // $this->db->query($chitha_update);
                        $table = "chitha_basic";

                        $params = [
                            'dag_area_b'     => $b,
                            'dag_area_k'     => $k,
                            'dag_area_lc'    => $lc,
                            'dag_area_g'     => $g,
                            'dag_area_kr'    => $kr,
                            'dag_revenue'    => $new_revenue,
                            'dag_local_tax'  => $new_local_tax
                        ];

                        $where = [
                            'dist_code'          => $d->dist_code,
                            'subdiv_code'        => $d->subdiv_code,
                            'cir_code'           => $d->cir_code,
                            'lot_no'             => $d->lot_no,
                            'mouza_pargona_code' => $d->mouza_pargona_code,
                            'vill_townprt_code'  => $d->vill_townprt_code,
                            'dag_no'             => $d->dag_no,
                            'patta_no'           => trim($d->patta_no),
                            'patta_type_code'    => $d->patta_type_code
                        ];

                        $this->Chitha_basic_model->update_table($table, $params, $where);

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
                        'jama_yn' => 'n'
                    );

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
                        'dag_por_b' => $d->land_area_b,
                        'dag_por_k' => $d->land_area_k,
                        'dag_por_lc' => $d->land_area_lc,
                        'dag_por_g' => 0.0,
                        'dag_por_kr' => 0,
                        'pdar_land_revenue' => $d->revenue,
                        'pdar_land_localtax' => ($d->revenue) / 4,
                        'user_code' => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d G:i:s'),
                        'operation' => 'E'
                    );
                    ////////var_dump($dag_pattadar);
                    $pdar_id++;
                    // $this->db->insert('chitha_dag_pattadar', $dag_pattadar);
                    $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$dag_pattadar);
                    // $this->db->insert('chitha_pattadar', $data);
                    $data['f1_case_no']=$case_no;
                    $this->Chitha_basic_model->insert_table('chitha_pattadar',$data);
                    if ($d->pdar_strike == 'Y') {
                        $p_flag = '0';
                    } else {
                        $p_flag = '1';
                    }
                    // $updateQuery = "update chitha_dag_pattadar set p_flag = '$p_flag' where dist_code='$d->dist_code' and"
                    // . " subdiv_code='$d->subdiv_code' and cir_code='$d->cir_code' and lot_no='$d->lot_no' and "
                    // . " mouza_pargona_code = '$d->mouza_pargona_code' and vill_townprt_code='$d->vill_townprt_code' and"
                    // . " dag_no ='$d->dag_no' and TRIM(patta_no)=trim('$d->patta_no') and patta_type_code='$d->patta_type_code' and pdar_id = '$d->pdar_id' ";

                    // $this->db->query($updateQuery);

                    $table = 'chitha_dag_pattadar';

                    $params = [
                        'p_flag' => $p_flag,   // e.g. '1' or whatever value you want to set
                    ];

                    $where = [
                        'dist_code'          => $d->dist_code,
                        'subdiv_code'        => $d->subdiv_code,
                        'cir_code'           => $d->cir_code,
                        'lot_no'             => $d->lot_no,
                        'mouza_pargona_code' => $d->mouza_pargona_code,
                        'vill_townprt_code'  => $d->vill_townprt_code,
                        'dag_no'             => $d->dag_no,
                        'patta_no'           => trim($d->patta_no),   // trimming in PHP before passing
                        'patta_type_code'    => $d->patta_type_code,
                        'pdar_id'            => $d->pdar_id,
                    ];

                    // Call the update function
                    $result = $this->Chitha_basic_model->update_table($table, $params, $where);



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
                    $this->db->insert('chitha_rmk_infavor_of', $d);
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
                unset($order->patta_no);
                unset($order->ord_onbehalf_id);
                unset($order->ord_onbehalf_of);
                unset($order->premium);
                unset($order->premi_chal_recpt);
                unset($order->premi_chal_recpt_no);
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
                    'new_dag_no' => $order->new_dag_no
                );
                $this->db->insert('chitha_rmk_gen', $rmk_gen);
                $this->db->insert('chitha_rmk_ordbasic', $order);
                $d = date('Y-m-d');
                $update_q = "update t_chitha_rmk_ordbasic set iscorrected_inco='Y',iscorrected_inco_date='$d'"
                . " where ord_no='$order->ord_no'  ";
                $this->db->query($update_q);
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                } else {

                    $this->db->trans_commit();
                }
            }
        }

        public function updateComplete() {
         $db=  $this->session->userdata('db');
         $this->updateChitha();
         $this->updateChithaConversion();
     }

     public function updateChithaApCancel() {
         $cntDag = 0;
         $dist_code = $this->session->userdata('dist_code');
         $subdiv_code = $this->session->userdata('subdiv_code');
         $cir_code = $this->session->userdata('cir_code');
         $case_no = $_GET['case_no'];
         $query = "select * from    apt_chitha_rmk_ordbasic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and 
         order_passed='Y' and iscorrected_inco is null";
         $apcanelData = $this->db->query($query)->result();
            foreach ($apcanelData as $d) { //Start of the FOR loop
                $case_no = $d->case_no;
                $patta_no_query = "select * from    apcancel_dag_details where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'";
                $patta_type_code = $this->db->query($patta_no_query)->row()->patta_type_code;
                $patta_no = $this->db->query($patta_no_query)->row()->patta_no;
                $dist_code = $this->db->query($patta_no_query)->row()->dist_code;
                $subdiv_code = $this->db->query($patta_no_query)->row()->subdiv_code;
                $cir_code = $this->db->query($patta_no_query)->row()->cir_code;
                $mouza_pargona_code = $this->db->query($patta_no_query)->row()->mouza_pargona_code;
                $lot_no = $this->db->query($patta_no_query)->row()->lot_no;
                $dag_no = $this->db->query($patta_no_query)->row()->dag_no;
                $vill_townprt_code = $this->db->query($patta_no_query)->row()->vill_townprt_code;
                $petition_no = $this->db->query($patta_no_query)->row()->petition_no;
                $d = date('Y-m-d G:i:s');
                $sqlCntDags = "SELECT count(dag_no) as cntdag from    chitha_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and
                vill_townprt_code='$vill_townprt_code' and mouza_pargona_code='$mouza_pargona_code' and patta_type_code='$patta_type_code' and TRIM(patta_no)= trim('$patta_no') ";
                $cntDag = $this->db->query($sqlCntDags)->row();
                if ($cntDag->cntdag == 1) { //If Pdar ID is not exist in other DAG then form the SQL string with Pattadar IDs so that the same may be used for deletion.
                    $this->NR_IfThereIsOnlyOneDagIn_A_Patta($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $patta_type_code, $dag_no);
                } else if ($cntDag->cntdag > 1) {
                    $this->NR_IfThereAreMoreDagsIn_A_Patta($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $patta_type_code, $dag_no);
                }

                $to_govt_type = "update chitha_basic set patta_type_code='0209',patta_no='0',dag_revenue=0,dag_local_tax=0 "
                . "where dist_code='$dist_code' and"
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and patta_type_code='$patta_type_code' and dag_no='$dag_no' "
                . " ";
                $this->db->query($to_govt_type);
                $q = "select max(rmk_type_hist_no)+1 as c2 from    chitha_rmk_gen where"
                . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
                . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and mouza_pargona_code='$mouza_pargona_code'";
                $rmk_type_hist_no = $this->db->query($q)->row()->c2;
                if ($rmk_type_hist_no == null) {
                    $rmk_type_hist_no = 1;
                }
                $rmk_gen = array(
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'vill_townprt_code' => $vill_townprt_code,
                    'lot_no' => $lot_no,
                    'dag_no' => $dag_no,
                    'rmk_type_code' => '09',
                    'rmk_type_hist_no' => $rmk_type_hist_no,
                    'user_code' => 'DC',
                    'operation' => 'E',
                    'date_entry' => date('Y-m-d G:i:s'),
                    'jama_updated' => 'n'
                );
                $this->db->insert('chitha_rmk_gen', $rmk_gen);
                //var_dump($rmk_gen);
                $dt = date('Y-m-d');
                $update_apt_remark = "update apt_chitha_rmk_ordbasic set iscorrected_inco = 'Y',iscorrected_inco_date='$d' where dist_code='$dist_code' and"
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and petition_no=$petition_no ";

                $update_apt_basic = "update apcancel_petition_basic set co_chitha_corrected_yn = 'Y',co_chitha_corrected_date='$d' where dist_code='$dist_code' and"
                . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and petition_no=$petition_no ";
                $this->db->query($update_apt_remark);
                $this->db->query($update_apt_basic);
                $this->session->set_flashdata('message', "Chitha Updated for Annual Patta Cancellation");
                redirect(base_url() . "index.php/Home");
            } //End of foreach Loop
        }

    //     public function ActionTakenRpt() {
    //      $db=  $this->session->userdata('db');
    //      set_time_limit(0);
    //      $dist_code = $this->session->userdata('dist_code');
    //      $subdiv_code = $this->session->userdata('subdiv_code');
    //      $circle_code = $this->session->userdata('cir_code');
    //      $user_code = $this->session->userdata('user_code');
    //      $query = "select * from    petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' "
    //      . " and mut_type='03' and  date(date_entry)>='2017-02-21' order by date_entry desc";
    //      $data['partpetition'] = $this->db->query($query)->result();
    //         // $this->load->helper('html');
    //         // $this->load->view('header');
    //         // $this->load->view('comutation/actiontakenreportPart', $data);
    //         // $this->load->view('footer');
    //      $data['_view'] = 'comutation/actiontakenreportPart';
    //      $this->load->view('layouts/main',$data);
    //  }

     public function ViewActionTakenReport() {
         $db=  $this->session->userdata('db');
         $data = array();
         $case_no = $this->input->get('case_no');
         $dist_code = $this->input->get('dist_code');
         $subdiv_code = $this->input->get('subdiv_code');
         $circle_code = $this->input->get('cir_code');
         $mouza_pargona_code = $this->input->get('mouza_pargona_code');
         $lot_no = $this->input->get('lot_no');
         $vill_townprt_code = $this->input->get('vill_townprt_code');

         $append = "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and "
         . "vill_townprt_code='$vill_townprt_code'";
         $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and "
            . "mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code'")->row();

         $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,next_date_of_hearing from    petition_basic where "
            . "case_no='$case_no' and $append")->row_array();

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

         $convertion_code = CONVERSION_CODE;
         $data['conv_type'] = $this->db->query("select order_type from    master_office_mut_type where order_type_code='$convertion_code'")->row()->order_type;

         $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where "
            . "dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' "
            . "and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and "
            . "petition_no='$petition_basic->petition_no'")->row_array();

         $pattadardetails = "select pet_name,guard_name,guard_rel,add1,add2 from    petitioner where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
         . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
         . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'  ";
         $data['p_in_order'] = $this->db->query($pattadardetails)->result();

         $query = "select * from    petition_proceeding where case_no = '$case_no' and dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
         . "and cir_code='$petition_basic->cir_code'";
         $data['cases'] = $this->db->query($query)->result();

            // $this->load->helper('html');
            // $this->load->view('../views/header');
            // $this->load->view('../views/comutation/action_taken_report', $data);
            // $this->load->view('../views/footer');
         $data['_view'] = 'comutation/action_taken_report';
         $this->load->view('layouts/main',$data);
     }

     public function ActionTakenReport() {
         $db=  $this->session->userdata('db');
         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = array();
            $case_no = $this->input->post('case_no');
                // $dist_code = $this->input->get('dist_code');
                // $subdiv_code = $this->input->get('subdiv_code');
                // $circle_code = $this->input->get('cir_code');
            $dist_code = $this->session->userdata('dist_code');
            $subdiv_code = $this->session->userdata('subdiv_code');
            $circle_code = $this->session->userdata('cir_code');

            $petition_basic = $this->db->query("select * from    petition_basic where case_no='$case_no' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' ")->row();

            $mouza_pargona_code = $petition_basic->mouza_pargona_code;
            $lot_no = $petition_basic->lot_no;
            $vill_townprt_code = $petition_basic->vill_townprt_code;
            $append = "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and "
            . "vill_townprt_code='$vill_townprt_code'";

            $location = $this->db->query("select dist_code,subdiv_code,cir_code,lot_no,vill_townprt_code,mouza_pargona_code,date_entry,next_date_of_hearing from    petition_basic where "
                . "case_no='$case_no' and $append")->row_array();

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
            $convertion_code = $petition_basic->mut_type;
            $data['conv_type'] = $this->db->query("select order_type from    master_office_mut_type where order_type_code='$convertion_code'")->row()->order_type;

            $landdetails = $this->db->query("select dag_no,m_dag_area_b,m_dag_area_k,m_dag_area_lc,patta_no,patta_type_code from    petition_dag_details where "
                . "dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' "
                . "and vill_townprt_code='$petition_basic->vill_townprt_code' and mouza_pargona_code='$petition_basic->mouza_pargona_code' and "
                . "petition_no='$petition_basic->petition_no'")->row_array();
            if($petition_basic->mut_type=='03'){
                $pattadardetails = "select pet_name,guard_name,guard_rel,add1,add2 from    petitioner where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
                . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
                . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'  ";
                $data['p_in_order'] = $this->db->query($pattadardetails)->result();
            }else if($petition_basic->mut_type=='04'){
                $pattadardetails = "select pdar_name as pet_name,pdar_guardian as guard_name,pdar_rel_guar as guard_rel,pdar_add1 as add1,pdar_add2 as add2 from    petitioner_part where dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
                . "and cir_code='$petition_basic->cir_code' and lot_no='$petition_basic->lot_no' and vill_townprt_code='$petition_basic->vill_townprt_code' and "
                . "mouza_pargona_code='$petition_basic->mouza_pargona_code' and petition_no='$petition_basic->petition_no'  ";
                $data['p_in_order'] = $this->db->query($pattadardetails)->result();
            }
            $query = "select * from    petition_proceeding where case_no = '$case_no' and dist_code='$petition_basic->dist_code' and subdiv_code='$petition_basic->subdiv_code' "
            . "and cir_code='$petition_basic->cir_code'";
            $data['cases'] = $this->db->query($query)->result();
            $data['_view'] = 'comutation/action_taken_report';
            $this->load->view('layouts/main',$data);
        } else {
            $data['_view'] = 'comutation/a_taken_report';
            $this->load->view('layouts/main',$data);
        }
    }

        //Added by Bijoy Mazumder, DIO, Bongaigaon on 10/06/2017
    public function NR_IfThereIsOnlyOneDagIn_A_Patta($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $patta_type_code, $dag_no) {
       $db=  $this->session->userdata('db');
       
          //Deleting from    Chitha_dag_pattadar except the Pdar_id=1. Since there should atleast one record for Pattadar "Charkari" mati.
       $sqlDelCDP = "update chitha_dag_pattadar set patta_type_code='0000',p_flag='1' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and 
       vill_townprt_code='$vill_townprt_code' and mouza_pargona_code='$mouza_pargona_code' and patta_type_code='$patta_type_code' and TRIM(patta_no)=trim('$patta_no') and dag_no='$dag_no' ";
            ////Deleting from    Chitha_pattadar except the Pdar_id=1. Since there should atleast one record for Pattadar "Charkari" mati.
       $sqlDelCP = "update chitha_pattadar set patta_type_code='0000',pdar_name='NA',pdar_father='NA' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and 
       vill_townprt_code='$vill_townprt_code' and mouza_pargona_code='$mouza_pargona_code' and patta_type_code='$patta_type_code' and TRIM(patta_no)=trim('$patta_no')";

       $sqlDelJD = "delete from    jama_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and 
       vill_townprt_code='$vill_townprt_code' and mouza_pargona_code='$mouza_pargona_code' and patta_type_code='$patta_type_code' and TRIM(patta_no)=trim('$patta_no') and dag_no='$dag_no'";
            //Delete all from    Jamma_pattadar table as there will be no Jamabandi against this Patta No
       $sqlDelJPdar = "delete from    jama_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and 
       vill_townprt_code='$vill_townprt_code' and mouza_pargona_code='$mouza_pargona_code' and patta_type_code='$patta_type_code' and TRIM(patta_no)=trim('$patta_no') ";
       $sqlDelJP = "delete from    jama_patta where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and 
       vill_townprt_code='$vill_townprt_code' and mouza_pargona_code='$mouza_pargona_code' and patta_type_code='$patta_type_code' and TRIM(patta_no)=trim('$patta_no') ";
       $sqlDelJR = "delete from    jama_remark where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and 
       vill_townprt_code='$vill_townprt_code' and mouza_pargona_code='$mouza_pargona_code' and patta_type_code='$patta_type_code' and TRIM(patta_no)=trim('$patta_no') ";

       $this->db->query($sqlDelCDP);
       $this->db->query($sqlDelJP);
       $this->db->query($sqlDelJD);
       $this->db->query($sqlDelJPdar);
       $this->db->query($sqlDelJR);
    }

    public function NR_IfThereAreMoreDagsIn_A_Patta($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $patta_type_code, $dag_no) {
      
       $db=  $this->session->userdata('db');

         //Added by Bijoy Mazumder, DIO, Bongaigaon on 10/06/2017

       $sqlMaxID = "Select max(pdar_id) as maxid from    jama_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and 
       vill_townprt_code='$vill_townprt_code' and  mouza_pargona_code='$mouza_pargona_code' and patta_type_code='$patta_type_code' and TRIM(patta_no)=trim('$patta_no') and ";

       $sqlDelCP = "delete  from    chitha_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and 
       vill_townprt_code='$vill_townprt_code' and mouza_pargona_code='$mouza_pargona_code' and patta_type_code='$patta_type_code' and TRIM(patta_no)=trim('$patta_no') and ";

            //Delete all from    Jamma_pattadar table as there will be no Jamabandi against this Patta No
       $sqlDelJPdar = "delete  from    jama_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and 
       vill_townprt_code='$vill_townprt_code' and mouza_pargona_code='$mouza_pargona_code' and patta_type_code='$patta_type_code' and TRIM(patta_no)=trim('$patta_no') and ";
            //--------------------------------------------------------------
            //Get Heighest Pdar ID to be used for adjusting pdar ids in jama_pattada & chitha_pattadar
       $sqlDelCDP = "delete  from    chitha_dag_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and 
       vill_townprt_code='$vill_townprt_code' and mouza_pargona_code='$mouza_pargona_code' and patta_type_code='$patta_type_code' and TRIM(patta_no)=trim('$patta_no') and dag_no='$dag_no'";

       $sqlDelJP = "delete  from    jama_patta where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and 
       vill_townprt_code='$vill_townprt_code' and mouza_pargona_code='$mouza_pargona_code' and patta_type_code='$patta_type_code' and TRIM(patta_no)=trim('$patta_no')";

       $sqlDelJD = "delete  from    jama_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and 
       vill_townprt_code='$vill_townprt_code' and mouza_pargona_code='$mouza_pargona_code' and patta_type_code='$patta_type_code' and TRIM(patta_no)=trim('$patta_no') and dag_no='$dag_no'";
            ////Deleting from    Chitha_pattadar except the Pdar_id=1. Since there should atleast one record for Pattadar "Charkari" mati. 
       $MkSQL = "";
       $MkSQLmaxid = "( ";
       $MkSQLDelCP = "( ";
       $MkSQLDelJPdar = "( ";
       $cntID = 0;
       $maxid = 0;
            //Get the list of PDar_ID for a Patta and Dag and form the SQL string for deletion etc-Bijoy Mazumder, 09/06/2017
       $sqlBM = "select pdar_id from    chitha_dag_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and 
       lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and mouza_pargona_code='$mouza_pargona_code' and patta_type_code='$patta_type_code' and 
       TRIM(patta_no)=trim('$patta_no') and dag_no='$dag_no'";
       $pdarid = $this->db->query($sqlBM)->result();
            foreach ($pdarid as $id) { //Start of FOR Loop...//Check if the ID is exist in other DAG -Bijoy Mazumder, 09/06/2017
                $tt = $id->pdar_id;
                $sqlExist = "select count(pdar_id) as c5 from    chitha_dag_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and mouza_pargona_code='$mouza_pargona_code' and patta_type_code='$patta_type_code' and patta_no='$patta_no' and pdar_id='$tt' and dag_no!='$dag_no'";
                $pID = $this->db->query($sqlExist)->row();
                if ($pID->c5 == 0) { //($pID->c5 > 0)  If Pdar ID is not exist in other DAG then form the SQL string with Pattadar IDs so that the same may be used for deletion.
                    $cntID++;
                    if ($cntID == 1) {
                        $MkSQL = " pdar_id = " . "'" . $id->pdar_id . "'";
                    } else if ($cntID > 1) {
                        $MkSQL = $MkSQL . " or pdar_id = " . "'" . $id->pdar_id . "'";
                    }
                }
            } //End of FOR Loop
            $MkSQLmaxid = $MkSQLmaxid . $MkSQL . ")";
            $MkSQLDelCP = $MkSQLDelCP . $MkSQL . ")";
            $MkSQLDelJPdar = $MkSQLDelJPdar . $MkSQL . ")";
            $StrFinal1 = $sqlDelCP . $MkSQLDelCP;
            $StrFinal2 = $sqlDelJPdar . $MkSQLDelJPdar;
            $StrFinal3 = $sqlMaxID . $MkSQLmaxid;
            if ($cntID > 0) { //if there are Pattadar which are not in other dag, then execute the following. If all IDs are common for multiple dags, than no need to delete.
                //Suppose Dags-6,8,10   and in each dag suppose Pdar_id 1,2 3 are available, than it is not required to delete.
                $maxid = $this->db->query($StrFinal3)->row()->maxid;
                $this->db->query($StrFinal1);
                $this->db->query($StrFinal2);
                $this->db->query($sqlDelCDP);
                $this->db->query($sqlDelJD);
                $sqlU1 = "update chitha_pattadar set pdar_id=pdar_id - $cntID " //Adjusting pdarid nos.
                . "where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and patta_type_code='$patta_type_code' and TRIM(patta_no)=trim('$patta_no') and pdar_id > '$maxid' ";
                $sqlU2 = "update jama_pattadar set pdar_id=cast(pdar_id as int) - $cntID " //adjusting pdarid
                . "where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and patta_type_code='$patta_type_code' and TRIM(patta_no)=trim('$patta_no') and pdar_id > '$maxid' ";
                $sqlU3 = "update chitha_dag_pattadar set pdar_id=pdar_id - $cntID " //adjusting pdarid
                . "where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and "
                . " lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and patta_type_code='$patta_type_code' and TRIM(patta_no)=trim('$patta_no') and pdar_id > '$maxid' ";
                $this->db->query($sqlU1);
                $this->db->query($sqlU2);
                $this->db->query($sqlU3);
            } else {
                $this->db->query($sqlDelCDP);
                $this->db->query($sqlDelJD);
            }
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

            $ip=$this->utilityclass->checkIp($this->utilityclass->get_client_ip());
            if ($ip == true)
            return;
            
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


            $this->db->where('case_no',$case_no);
            $this->db->update('dashboard_data',$base);

            $ip=$this->utilityclass->checkIp($this->utilityclass->get_client_ip());
            if ($ip == true)
            return;

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
                    /////////////////////////////////////
        }

        function DashboardDataReject($case_no){
            $this->dbb = $this->load->database('dash', TRUE);
            $base=array(
                'final_order_date' => date('Y-m-d'),
                'pending_with_user'=>'NA',
                'status'=>'R',
                'remark'=>'Case Rejected',
                'date_of_update'=>date("Y-m-d h:i:s")
            );
            $this->dbb->where('case_no',$case_no);
            $this->dbb->update('dashboard_data',$base);

            $ip=$this->utilityclass->checkIp($this->utilityclass->get_client_ip());
            if ($ip == true)
            return;

            $action= array(
                'case_no' => $case_no,
                'user_code' => $this->session->userdata('user_code'),
                'date_of_action_taken' => date('Y-m-d'),
                'user_designation' => $this->session->userdata('user_desig_code'),
                'remark' => 'Rejected',
            );
            $this->dbb->insert('dashboard_action',$action);
        }
       ///////////01-03-22////////////
        public function finalOrderPass() 
        {
           $_GET['case_no'] = dec_param($this->input->get('case_no'), 'case_no');
            if($_GET['case_no'] == null)
            {
                echo json_encode('Sorry !! You are not Authorized to access the content!!');
                return;
            }

          $case_no = $this->input->get('case_no');

          $type = explode('/', $case_no);

          $case_type = $type['4'];

          // if somebody tries to pass OMUTC in OMUT method
          if ($case_type != 'OMUT') 
          {
           echo 'Unauthorized'; exit();
          }

            $allowed = ['CO'];
            $user_desig_code = $this->session->userdata('user_desig_code');

            // Restrict access if not in allowed list
            if ( ! in_array($user_desig_code, $allowed)) {
                echo json_encode(['error' => 'Unauthorized access']);
                exit; // or die();
            }


          $append = $this->base_query;
          $appenq = $this->query;
          $dist_code = $this->session->userdata('dist_code');
          $subdiv_code = $this->session->userdata('subdiv_code');
          $cir_code = $this->session->userdata('cir_code');
          $user_code = $this->session->userdata('user_code');
          $year_no = year_no;

              // $proceeding_id = $this->db->query("SELECT max(proceeding_id) as last FROM petition_proceeding WHERE case_no=? and $appenq ", array($case_no))->row()->last;

          $data = $this->db->query("SELECT * FROM petition_basic pb JOIN petition_dag_details pd ON 
              pb.dist_code = pd.dist_code AND pb.subdiv_code = pd.subdiv_code AND 
              pb.cir_code = pd.cir_code AND pb.mouza_pargona_code = pd.mouza_pargona_code AND 
              pb.lot_no = pd.lot_no AND pb.petition_no = pd.petition_no AND 
              pb.vill_townprt_code = pd.vill_townprt_code WHERE pb.case_no=? AND pb.dist_code=? AND 
              pb.subdiv_code=? AND pb.cir_code=?", array($case_no, $dist_code, $subdiv_code, $cir_code))->row();
          $details['data']=$details['dag'] = $data;


        if($data->comp_serv_yn =='Y')
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }

        if($data->lm_note_yn == null && $data->notice_generated_yn == null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }

        if(($data->dist_code!=$dist_code) || ($data->subdiv_code!=$subdiv_code) ||($data->cir_code!=$cir_code))
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }




              //$details['proceeding_id'] = $proceeding_id;
          $q = "select lm_code,lm_sign_yn,sk_sign_yn,sk_note_date,lm_sign_date from    petition_lm_note where $appenq   and "
          . "petition_no=$data->petition_no";

          $dates = $this->db->query("SELECT lm_code, lm_sign_yn, sk_sign_yn, sk_note_date, lm_sign_date, user_code, lm_code FROM petition_lm_note WHERE $appenq AND 
              petition_no = ?", array($data->petition_no))->row();
          if(ESCALATION_ENABLE == 1 && $data->es_flag == 1)
          {
            $details['sk_note_date'] = null;
            $details['sk_sign_yn'] = null;
            $details['user_code'] = null;
          }
          
          $details['lm_note_date'] = $dates->lm_sign_date;
          $details['lm_sign_yn'] = $dates->lm_sign_yn;
              $details['sk_sign_yn'] = $data->sk_comment; //$dates->sk_sign_yn;
              $details['lm_code'] = $dates->lm_code;
              $details['case_no'] = $case_no;
              $details['user_code'] = $dates->user_code;

              //////////////////////////////////////////////////////////////////////////////
              $petition_no_q = "SELECT petition_no, trans_code, deed_no, deed_value, sub_reg_office,
              submission_date, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no,
              vill_townprt_code FROM petition_basic WHERE case_no=? and $append ";
              $petition_no = $this->db->query($petition_no_q, array($case_no))->row()->petition_no;
              $trans_code = $this->db->query($petition_no_q, array($case_no))->row()->trans_code;
              $deed_no = $this->db->query($petition_no_q, array($case_no))->row()->deed_no;
              $deed_value = $this->db->query($petition_no_q, array($case_no))->row()->deed_value;
              $sub_reg_office = $this->db->query($petition_no_q, array($case_no))->row()->sub_reg_office;
              $submission_date = $this->db->query($petition_no_q, array($case_no))->row()->submission_date;
              $dist_code = $this->db->query($petition_no_q, array($case_no))->row()->dist_code;
              $subdiv_code = $this->db->query($petition_no_q, array($case_no))->row()->subdiv_code;
              $cir_code = $this->db->query($petition_no_q, array($case_no))->row()->cir_code;
              $mouza_pargona_code = $this->db->query($petition_no_q, array($case_no))->row()->mouza_pargona_code;
              $lot_no = $this->db->query($petition_no_q, array($case_no))->row()->lot_no;
              $vill_townprt_code = $this->db->query($petition_no_q, array($case_no))->row()->vill_townprt_code;
              $year_no = year_no;
              $append = "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and "
                    . "vill_townprt_code='$vill_townprt_code'";
              
              $details['trans_code'] = $trans_code;
              $details['deed_no'] = $deed_no;
              $details['deed_value'] = $deed_value;
              $details['sub_reg_office'] = $sub_reg_office;
              $details['submission_date'] = $submission_date;
              //$details['land'] = $land;

              $details['mut_type_deed']=$this->utilityclass->mutType('o');
              $details['mut_type_inherit']=$this->utilityclass->mutType('i');

              

              $applicants = "SELECT * FROM petitioner WHERE petition_no=? AND $append order by pet_id";
              $details['applicants']=$details['petitioner'] = $this->db->query($applicants, array($petition_no))->result();

              $details['relation'] = $this->db->query("SELECT * FROM master_guard_rel")->result();
              $details['genders'] = $this->db->query("SELECT * FROM master_gender")->result();
              $details["pdars"] = $this->db->query("select * from  chitha_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' 
                  and p.cir_code='$cir_code' and p.mouza_pargona_code='$mouza_pargona_code' and"
                  . " p.vill_townprt_code='$vill_townprt_code' and p.lot_no='$lot_no'
                  and TRIM(p.patta_no)='$data->patta_no' and p.patta_type_code='$data->patta_type_code' and p.pdar_id in(
                  select pdar_id from  chitha_dag_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' 
                  and p.cir_code='$cir_code' 
                  and p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
                  . "and p.lot_no='$lot_no' and TRIM(p.patta_no)='$data->patta_no' 
                  and p.patta_type_code='$data->patta_type_code' and p_flag!='1')")->result();

              $pattadars = "SELECT * FROM petition_pattadar WHERE petition_no=? and $append";
              $details['pattadars'] = $this->db->query($pattadars, array($petition_no))->result();

                if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                {
                    // property chain data
                    $details['ulpin'] = $this->input->get('ulpin', true);
                    $details['old_ulpin'] = $this->input->get('old_ulpin', true);
                    $details['revenue'] = $this->input->get('dag_revenue', true);
                    $details['local_tax'] = $this->input->get('dag_local_tax', true);
                    $details['ulpinCheckFlag'] = $this->input->get('ulpinCheckFlag', true);
                    $details['compareCheckFlag'] = $this->input->get('compareCheckFlag', true);

                }


            //ESCALATED CASES REMARK ENTRY FORM==============
            if(ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE == 1 && $data->es_flag == 1 && $data->out_of_esc == 0)
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

            $basundhara="select * from basundhar_application where dharitree='$case_no' ";
            $details['basundhara'] = $this->db->query($basundhara)->row();
            //  var_dump($data);   
            // $uuid = $this->utilityclass->getUuid($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

            $restriction=false;
            $transCodesFetched = array_map(function($item) {
                    return $item['trans_code'];
            }, $details['mut_type_deed']);

            if(in_array($trans_code,$transCodesFetched)){
                $test = $dist_code.'_'.$subdiv_code.'_'.$cir_code.'_'.$mouza_pargona_code.'_'.$lot_no.'_'.$vill_townprt_code;
                $restriction=false;
                if((in_array($dist_code,json_decode(DISTRICTS_TO_PREVENT_THE_CASE_PASS)) || in_array($test,json_decode(LOCATIONS_TO_PREVENT_THE_CASE_PASS)))){
                    $restriction = true;
                }  
            }
            $details['restriction'] = $restriction;
            
            $details['_view'] = 'officemutation/finalOrderPassCO';
            $this->load->view('layouts/main',$details);

          }

          public function getEditApplicantOmutCODetail(){
            $id = $this->input->post('id');
            $petition_no = $this->input->post('petition_no');
            $details['relation'] = $this->db->query("SELECT * FROM master_guard_rel")->result();
            $details['genders'] = $this->db->query("SELECT * FROM master_gender")->result();

            $details['petitioners'] = $this->db->query("SELECT * FROM petitioner WHERE  $this->query 
                AND pet_id=? and petition_no=?", array($id,$petition_no))->row();
            echo json_encode($details);
        }

        public function updateFinalOrderApplicantOmutCO()
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
                        if($field=='mother'){
                        $field= 'mother_name';
                        }
                        if($field=='rel'){
                            $field= 'relation_guardian';
                            }
                    
                        
                        $validation['error'][] = array('field' => $field, 'message' => $errorMessageSing);
                    }
                    echo json_encode($validation);
                    return false;;
                }
                $resp = checkRequestValidQuery($_POST);
                if($resp['status'] == 'n'){
                    // $errorMessageStr .= $resp['messages'];
                    $errorMessageArr=$resp['field_wise_message'];
                }        
            //xss & security validation ends 
            $applicantValidation= [
                [
                    'field' => 'appl',
                    'label' => 'Applicant Name',
                    'rules' => 'trim|required|xss_clean',
                ],
                [
                    'field' => 'gen',
                    'label' => 'Gender',
                    'rules' => 'trim|required|xss_clean',
                ],
                [
                    'field' => 'guard_name',
                    'label' => 'Guardian',
                    'rules' => 'trim|required|xss_clear',
                ],
                [
                    'field' => 'rel',
                    'label' => 'Relation',
                    'rules' => 'trim|required|xss_clean',
                ],
                [
                    'field' => 'dob',
                    'label' => 'Date of Birth',
                    'rules' => 'trim|required|xss_clean',
                ],
                [
                    'field' => 'add1',
                    'label' => 'Address 1',
                    'rules' => 'trim|required|xss_clean',
                ]
            ];
            $this->load->library('form_validation');
            $this->form_validation->set_rules($applicantValidation);
            $this->form_validation->set_message('integer', 'This %s is not valid');
            $validation= null;
            if ($this->form_validation->run('applicantValidation') == FALSE)
            {
                $this->form_validation->set_error_delimiters('', '');
                foreach($applicantValidation as $rule){
                    if (form_error($rule['field'])) {
                        $validation['error'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
                    }
                }             
            }
            else
            {
                $val = $this->input->post();
                $location = $this->utilityclass->getLocationfromSession();
                $dist_code = $location['dist_code'];
                $subdiv_code = $location['subdiv_code'];
                $cir_code = $location['cir_code'];

                $pet = $this->db->query("SELECT A.*, B.trans_code FROM 
                 petitioner A JOIN petition_basic B ON A.petition_no=B.petition_no 
                 WHERE A.pet_id=? and A.dist_code=? and A.subdiv_code=? and A.cir_code=? AND A.petition_no=?", array($val['id'], $dist_code, $subdiv_code, $cir_code,$val['petition_no']))->row();

            // $pet = $this->db->query("SELECT A.*, B.case_no FROM petitioner A 
            // JOIN petition_basic B ON A.petition_no=B.petition_no WHERE A.id=?", 
            // array($val['id']))->row();

                $basundharaExist=$this->basundharamodel->checkExistBasundhar($pet->case_no);

                $old_data = $this->db->query("SELECT * FROM petitioner WHERE 
                    petition_no=? AND pet_id=? AND dist_code=? AND subdiv_code=? AND cir_code=? 
                    AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=?", array($pet->petition_no, $pet->pet_id, $pet->dist_code, $pet->subdiv_code, $pet->cir_code, $pet->mouza_pargona_code, $pet->lot_no, $pet->vill_townprt_code))->row();
                $data = [
                    'ip'=>$this->utilityclass->get_client_ip(),
                    'case_no' => $pet->case_no,
                    'basundhara' => $basundharaExist,
                    'user_code' => $this->user_code,
                    'date_entry' => date('Y-m-d H:i:s'),
                    'changes_data' => json_encode($old_data),
                ];
                $basuInsert = $this->db->insert('basundhara_data_updation', $data);

                if($basuInsert == true)
                {
                    if($val['mother'] == '' || $val['mother'] == null) {
                        $val['mother'] == '';
                    }
                    if($val['add2'] == '' || $val['add2'] == null) {
                        $val['add2'] == '';
                    }
                    $update = [
                        'pet_name' => $val['appl'],
                        'pet_gender' => $val['gen'],
                        'guard_name' => $val['guard_name'],
                        'guard_rel' => $val['rel'],
                        'pet_mother' => $val['mother'],
                        'pet_minor_dob' => $val['dob'],
                        'add1' => $val['add1'],
                        'add2' => $val['add2'],
                    ];
                    $this->db->where('pet_id', $val['id']);
                    $this->db->where('dist_code',  $pet->dist_code);
                    $this->db->where('subdiv_code',  $pet->subdiv_code);
                    $this->db->where('cir_code',  $pet->cir_code);
                    $this->db->where('petition_no',  $pet->petition_no);
                    $this->db->update('petitioner', $update);
                    if($this->db->affected_rows() != 1)
                    {
                        $validation['success'] = false;
                    }
                    else
                    {
                     $details = $this->db->query("SELECT * FROM petitioner WHERE petition_no=? AND dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? ORDER BY pet_id", array($pet->petition_no, $pet->dist_code, $pet->subdiv_code, $pet->cir_code, $pet->mouza_pargona_code, $pet->lot_no, $pet->vill_townprt_code))->result();
                     $validation['success'] = true;
                     $validation['details'] = $details;
                 }  
             }
             else
             {
                $validation['basundhara'] = false;
            }
        }
        echo json_encode($validation);
    }
    
    // Added by Abhijit --2024-05-22
    public function updateFinalOrderApplicantOmutCOMultiDagGen()
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
                    if($field=='mother'){
                    $field= 'mother_name';
                    }
                    if($field=='rel'){
                        $field= 'relation_guardian';
                        }
                
                    
                    $validation['error'][] = array('field' => $field, 'message' => $errorMessageSing);
                }
                echo json_encode($validation);
                return false;;
            }
            $resp = checkRequestValidQuery($_POST);
            if($resp['status'] == 'n'){
                // $errorMessageStr .= $resp['messages'];
                $errorMessageArr=$resp['field_wise_message'];
            }        
        //xss & security validation ends 
        $applicantValidation= [
            [
                'field' => 'appl',
                'label' => 'Applicant Name',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'gen',
                'label' => 'Gender',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'guard_name',
                'label' => 'Guardian',
                'rules' => 'trim|required|xss_clear',
            ],
            [
                'field' => 'rel',
                'label' => 'Relation',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'dob',
                'label' => 'Date of Birth',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'add1',
                'label' => 'Address 1',
                'rules' => 'trim|required|xss_clean',
            ],
            [
                'field' => 'marital_status',
                'label' => 'Marital Status',
                'rules' => 'trim|xss_clean|required',
            ],
            [
                'field' => 'occupation',
                'label' => 'Occupation',
                'rules' => 'trim|xss_clean|required',
            ],
            [
                'field' => 'pet_caste',
                'label' => 'Caste',
                'rules' => 'trim|xss_clean|required',
            ],
            [
                'field' => 'id',
                'label' => 'ID',
                'rules' => 'trim|xss_clean|required',
            ],
        ];

        if($_POST['pet_caste'] != '6'){
            array_push($applicantValidation, [
                'field' => 'pet_protected_class',
                'label' => 'Protected Class',
                'rules' => 'trim|xss_clean|required',
            ]);
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules($applicantValidation);
        $this->form_validation->set_message('integer', 'This %s is not valid');
        $validation= null;
        if ($this->form_validation->run('applicantValidation') == FALSE)
        {
            $this->form_validation->set_error_delimiters('', '');
            foreach($applicantValidation as $rule){
                if (form_error($rule['field'])) {
                    $validation['error'][] = array('field' => $rule['field'], 'message' => form_error($rule['field']));
                }
            }             
        }
        else
        {
            $val = $this->input->post();
            $location = $this->utilityclass->getLocationfromSession();
            $dist_code = $location['dist_code'];
            $subdiv_code = $location['subdiv_code'];
            $cir_code = $location['cir_code'];

            $pet = $this->db->query("SELECT A.*, B.trans_code FROM 
                petitioner A JOIN petition_basic B ON A.petition_no=B.petition_no 
                WHERE A.pet_id=? and A.dist_code=? and A.subdiv_code=? and A.cir_code=? AND A.petition_no=?", array($val['pet_id'], $dist_code, $subdiv_code, $cir_code,$val['petition_no']))->row();

            // $pet = $this->db->query("SELECT A.*, B.case_no FROM petitioner A 
            // JOIN petition_basic B ON A.petition_no=B.petition_no WHERE A.id=?", 
            // array($val['id']))->row();

            $basundharaExist=$this->basundharamodel->checkExistBasundhar($pet->case_no);

            $old_data = $this->db->query("SELECT * FROM petitioner WHERE 
                petition_no=? AND pet_id=? AND dist_code=? AND subdiv_code=? AND cir_code=? 
                AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=?", array($pet->petition_no, $pet->pet_id, $pet->dist_code, $pet->subdiv_code, $pet->cir_code, $pet->mouza_pargona_code, $pet->lot_no, $pet->vill_townprt_code))->row();
            $data = [
                'ip'=>$this->utilityclass->get_client_ip(),
                'case_no' => $pet->case_no,
                'basundhara' => $basundharaExist,
                'user_code' => $this->user_code,
                'date_entry' => date('Y-m-d H:i:s'),
                'changes_data' => json_encode($old_data),
            ];
            $basuInsert = $this->db->insert('basundhara_data_updation', $data);

            if($basuInsert == true)
            {
                if($val['mother'] == '' || $val['mother'] == null) {
                    $val['mother'] == '';
                }
                if($val['add2'] == '' || $val['add2'] == null) {
                    $val['add2'] == '';
                }
                $update = [
                    'pet_name' => $val['appl'],
                    'pet_gender' => $val['gen'],
                    'guard_name' => $val['guard_name'],
                    'guard_rel' => $val['rel'],
                    'pet_mother' => $val['mother'],
                    'pet_minor_dob' => $val['dob'],
                    'add1' => $val['add1'],
                    'add2' => $val['add2'],
                    'marital_status' => $val['marital_status'],
                    'applicant_occupation' => $val['occupation'],
                    'caste_category' => $val['pet_caste'],
                    'tribe_category' => isset($val['pet_protected_class']) ? $val['pet_protected_class'] : '',
                ];
                $this->db->where('id', $val['id']);
                $this->db->where('pet_id', $val['pet_id']);
                $this->db->where('dist_code',  $pet->dist_code);
                $this->db->where('subdiv_code',  $pet->subdiv_code);
                $this->db->where('cir_code',  $pet->cir_code);
                $this->db->where('petition_no',  $pet->petition_no);
                $this->db->update('petitioner', $update);
                if($this->db->affected_rows() != 1)
                {
                    $validation['success'] = false;
                }
                else
                {
                    $details = $this->db->query("SELECT * FROM petitioner WHERE petition_no=? AND dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? ORDER BY pet_id", array($pet->petition_no, $pet->dist_code, $pet->subdiv_code, $pet->cir_code, $pet->mouza_pargona_code, $pet->lot_no, $pet->vill_townprt_code))->result();
                    $validation['success'] = true;
                    $validation['details'] = $details;
                }  
            }else{
                $validation['basundhara'] = false;
            }
        }
        echo json_encode($validation);
    }

    public function deleteFinalOrderApplicantOmutCO()
    {
        $id = $this->input->post('id');
        $petition_no = $this->input->post('petition_no');
        $location = $this->utilityclass->getLocationfromSession();
        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];

        $pet = $this->db->query("SELECT A.*, B.case_no FROM petitioner A 
            JOIN petition_basic B ON A.petition_no=B.petition_no and a.dist_code=b.dist_code and a.subdiv_code=b.subdiv_code and a.cir_code=b.cir_code WHERE A.pet_id=? and a.dist_code=? and a.subdiv_code=? and a.cir_code=? and a.petition_no=? ", 
            array($id,$dist_code,$subdiv_code,$cir_code,$petition_no))->row();

        $count = $this->db->query("SELECT count(*) as count FROM petitioner WHERE petition_no=? AND dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=?", array($pet->petition_no, $pet->dist_code, $pet->subdiv_code, $pet->cir_code, $pet->mouza_pargona_code, $pet->lot_no, $pet->vill_townprt_code))->row()->count;
        
        if($count == 1){ // one applicant available
            $json['delete'] = false;
        }
        else
        {
            $basundharaExist=$this->basundharamodel->checkExistBasundhar($pet->case_no);
            $old_data = $this->db->query("SELECT * FROM petitioner WHERE 
                petition_no=? AND pet_id=? AND dist_code=? AND subdiv_code=? AND cir_code=? 
                AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=?", array($pet->petition_no, $pet->pet_id, $pet->dist_code, $pet->subdiv_code, $pet->cir_code, $pet->mouza_pargona_code, $pet->lot_no, $pet->vill_townprt_code))->row();
            $data=array(
                'ip'=>$this->utilityclass->get_client_ip(),
                'case_no' => $pet->case_no,
                'basundhara' => $basundharaExist,
                'user_code' => $this->user_code,
                'date_entry' => date('Y-m-d H:i:s'),
                'changes_data' => json_encode($old_data),
            );
            $this->db->insert('basundhara_data_updation', $data);

            $del = $this->db->query("DELETE FROM petitioner WHERE petition_no=? AND pet_id=? AND dist_code=? AND subdiv_code=? AND cir_code=? 
                AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=?", array($pet->petition_no, $pet->pet_id, $pet->dist_code, $pet->subdiv_code, $pet->cir_code, $pet->mouza_pargona_code, $pet->lot_no, $pet->vill_townprt_code));
            if($del == true){
                $details = $this->db->query("SELECT * FROM petitioner WHERE petition_no=? AND dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? ORDER BY pet_id", array($pet->petition_no, $pet->dist_code, $pet->subdiv_code, $pet->cir_code, $pet->mouza_pargona_code, $pet->lot_no, $pet->vill_townprt_code))->result();
                $json['details'] = $details;
            }    
        }
        echo json_encode($json);
    }

    public function getEditPattadarOmutCODetail()
    {
        $id = $this->input->post('id');
        $petition_no = $this->input->post('petition_no');
        $location = $this->utilityclass->getLocationfromSession();
        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];

        $details['pattadars'] = $this->db->query("SELECT A.*, B.trans_code FROM 
            petition_pattadar A JOIN petition_basic B ON A.petition_no=B.petition_no  and a.dist_code=b.dist_code and a.subdiv_code=b.subdiv_code and a.cir_code=b.cir_code
            WHERE A.pdar_id=? and A.dist_code=? and A.subdiv_code=? and A.cir_code=? AND A.petition_no=?", array($id, $dist_code, $subdiv_code, $cir_code,$petition_no))->row();
        //echo $this->db->last_query();

        $details['relation'] = $this->db->query("SELECT * FROM master_guard_rel")->result();
        echo json_encode($details);
    }

    public function updateFinalOrderPattadarOmutCO()
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
                    $validation['success'] = false;
                    $validation['type'] ='audit';
                    $validation['msg'] = strip_tags( $errorMessageStr);
                    echo json_encode($validation);
                    return false;
                    exit;
                }
            //xss & security validation ends 
        $val = $this->input->post();
        $striked_out = $val['striked_out'];
        $id = $val['id'];
        $petition_no=$val['petition_no'];
        $location = $this->utilityclass->getLocationfromSession();
        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];
        $pet = $this->db->query("SELECT A.*, B.case_no FROM petition_pattadar A 
            JOIN petition_basic B ON A.petition_no=B.petition_no and a.dist_code=b.dist_code and a.subdiv_code=b.subdiv_code and a.cir_code=b.cir_code WHERE A.pdar_id=? and A.dist_code=? and A.subdiv_code=? and A.cir_code=? AND A.petition_no=?", array($id, $dist_code, $subdiv_code, $cir_code,$petition_no))->row();

        $basundharaExist=$this->basundharamodel->checkExistBasundhar($pet->case_no);
        $old_data = $this->db->query("SELECT * FROM petition_pattadar WHERE pdar_id=? and $this->query and petition_no=?", 
            array($id,$petition_no))->row();
        $data = [
            'ip'=>$this->utilityclass->get_client_ip(),
            'case_no' => $pet->case_no,
            'basundhara' => $basundharaExist,
            'user_code' => $this->user_code,
            'date_entry' => date('Y-m-d H:i:s'),
            'changes_data' => json_encode($old_data),
        ];
        $basuInsert = $this->db->insert('basundhara_data_updation', $data);

        if($basuInsert == true)
        {
            $dag = $this->db->query("SELECT * FROM petition_dag_details WHERE petition_no=? 
                AND dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND 
                lot_no=? AND vill_townprt_code=?", array($pet->petition_no, $pet->dist_code, $pet->subdiv_code, $pet->cir_code, $pet->mouza_pargona_code, $pet->lot_no, $pet->vill_townprt_code))->row();

            //chitha land detail
            $totalChithaAvailableLand = ($dag->dag_area_b * 100) + ($dag->dag_area_k * 20) + $dag->dag_area_lc;
            
            //applied land detail
            $totalAppliedLand = ($dag->m_dag_area_b * 100) + ($dag->m_dag_area_k * 20) + $dag->m_dag_area_lc;

            //check pattadar count
            $pattadar = $this->db->query("SELECT petition_no FROM petition_pattadar WHERE 
                petition_no=? AND dist_code=? AND subdiv_code=? AND cir_code=? AND 
                mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? ", array($pet->petition_no, $pet->dist_code, $pet->subdiv_code, $pet->cir_code, $pet->mouza_pargona_code, $pet->lot_no, $pet->vill_townprt_code))->num_rows();

            //if pattadar list greater than one, both inplace alongwith will be enable 
            if($pattadar > 1) {
                $this->db->query("UPDATE petition_pattadar SET 
                    striked_out='".$striked_out."' WHERE  petition_no=? AND dist_code=? AND subdiv_code=? AND cir_code=? AND 
                    mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? and pdar_id=?", array($pet->petition_no, $pet->dist_code, $pet->subdiv_code, $pet->cir_code, $pet->mouza_pargona_code, $pet->lot_no, $pet->vill_townprt_code,$id));
            }
            else {
                //land in chitha and applied land is equal, alongwith not require
                if($totalChithaAvailableLand == $totalAppliedLand){
                    if($striked_out == '1') //if checked inplace
                    {
                      $this->db->query("UPDATE petition_pattadar SET 
                        striked_out='".$striked_out."' WHERE  petition_no=? AND dist_code=? AND subdiv_code=? AND cir_code=? AND 
                        mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? and pdar_id=?", array($pet->petition_no, $pet->dist_code, $pet->subdiv_code, $pet->cir_code, $pet->mouza_pargona_code, $pet->lot_no, $pet->vill_townprt_code,$id));
                  }
                    else { //if checked alongwith
                        $validation['alongwith'] = false; //alongwith can't be selected
                    }
                }
                else{ 
                 $this->db->query("UPDATE petition_pattadar SET 
                    striked_out='".$striked_out."' WHERE  petition_no=? AND dist_code=? AND subdiv_code=? AND cir_code=? AND 
                    mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? and pdar_id=?", array($pet->petition_no, $pet->dist_code, $pet->subdiv_code, $pet->cir_code, $pet->mouza_pargona_code, $pet->lot_no, $pet->vill_townprt_code,$id));
             }
         }
         if($this->db->affected_rows() != 1)
         {
            $validation['success'] = false;
        }
        else
        {
            $details = $this->db->query("SELECT * FROM petition_pattadar WHERE petition_no=? AND dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? ORDER BY pdar_cron_no", array($pet->petition_no, $pet->dist_code, $pet->subdiv_code, $pet->cir_code, $pet->mouza_pargona_code, $pet->lot_no, $pet->vill_townprt_code))->result();
            $validation['success'] = true;
            $validation['details'] = $details;
        }  
    }
    else
    {
        $validation['basundhara'] = false;
    }
    echo json_encode($validation);
    }

    public function deleteFinalOrderPattadarOmutCO()
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
                $json['type'] = 'audit';
                $json['details'] = strip_tags($errorMessageStr);
                echo json_encode($json);
                return false;
                exit;
            }
         //xss & security validation ends 
        $id = $this->input->post('id');
        $petition_no=$this->input->post('petition_no');
        $location = $this->utilityclass->getLocationfromSession();
        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];
        $pet = $this->db->query("SELECT A.*, B.case_no FROM petition_pattadar A 
            JOIN petition_basic B ON A.petition_no=B.petition_no and a.dist_code=b.dist_code and a.subdiv_code=b.subdiv_code and a.cir_code=b.cir_code WHERE A.pdar_id=? and a.petition_no=? and a.dist_code=? AND a.subdiv_code=? AND a.cir_code=? ", 
            array($id,$petition_no,$dist_code,$subdiv_code,$cir_code))->row();

        $count = $this->db->query("SELECT petition_no FROM petition_pattadar WHERE petition_no=? AND dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=?", array($pet->petition_no, $pet->dist_code, $pet->subdiv_code, $pet->cir_code, $pet->mouza_pargona_code, $pet->lot_no, $pet->vill_townprt_code))->num_rows();
        
        if($count == 1){ // one applicant available
            $json['delete'] = false;
        }
        else
        {
            $this->db->trans_begin();
            $basundharaExist=$this->basundharamodel->checkExistBasundhar($pet->case_no);
            $old_data = $this->db->query("SELECT * FROM petition_pattadar WHERE 
                petition_no=? AND id=? AND dist_code=? AND subdiv_code=? AND cir_code=? 
                AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=?", array($pet->petition_no, $pet->pdar_id, $pet->dist_code, $pet->subdiv_code, $pet->cir_code, $pet->mouza_pargona_code, $pet->lot_no, $pet->vill_townprt_code))->row();
            $data=array(
                'ip'=>$this->utilityclass->get_client_ip(),
                'case_no' => $pet->case_no,
                'basundhara' => $basundharaExist,
                'user_code' => $this->user_code,
                'date_entry' => date('Y-m-d H:i:s'),
                'changes_data' => json_encode($old_data),
            );
            $ins = $this->db->insert('basundhara_data_updation', $data);

            if($ins == true){
                $del = $this->db->query("DELETE FROM petition_pattadar WHERE petition_no=? AND dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? and pdar_id=?", array($pet->petition_no, $pet->dist_code, $pet->subdiv_code, $pet->cir_code, $pet->mouza_pargona_code, $pet->lot_no, $pet->vill_townprt_code,$pet->pdar_id));
                if($del == true){
                    $details = $this->db->query("SELECT * FROM petition_pattadar WHERE petition_no=? AND dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? ORDER BY pdar_id", array($pet->petition_no, $pet->dist_code, $pet->subdiv_code, $pet->cir_code, $pet->mouza_pargona_code, $pet->lot_no, $pet->vill_townprt_code))->result();
                    $json['details'] = $details;
                    $this->db->trans_commit();
                }
                else
                {
                    $this->db->trans_rollback();
                    return;     
                }
            }
            else
            {
                $this->db->trans_rollback();
                return;
            }    
        }
        echo json_encode($json);
    }


    function nokApprove(){
        $success=null;
        $request=$_POST['co_status'];
        $case_no=$_POST['case_no'];
        $co_code=$this->session->userdata('user_code');
        $co_approve_date=date('Y-m-d H:i:s');
        
        $redirect_url = base_url().'index.php/coofficemutation/getPendingMutationCases?id=2';

        $petition_basic = $this->db->where('case_no', $case_no)->get('petition_basic')->row();
        
        if($request=='1'){
            
            $sql="Update nok_tmp set co_code='$co_code', co_approve_date='$co_approve_date',approve_reject=1 where case_id='$case_no' ";
            $this->db->query($sql);
            $success="NOK Application Approved. Please wait for 7 days for Objection rasied by the Applicant";
            $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
            if($basundharaExist){
                $sql="Select * from nok_tmp where case_id='$case_no' and approve_reject=1 ";
                    //$sql="Select * from nok_tmp where case_id='$case_no'  ";
                $pushData=$this->db->query($sql)->result_array();
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, API_LINK."postNok");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, json_encode(array(
                    'data' => $pushData,
                    'basundhara'=>$basundharaExist
                )));
                $data=curl_exec($curl_handle);
                  //return json_decode($data);
            }

        }else if($request=='0'){
            /////////Revert to LM/////////////
            $update = [
                'lm_note_yn' => null,
                'lm_note_date' => null,
                'is_pending' => 'Y',
            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('petition_basic', $update);
            $success="NOK Application Revert back to LM. ";   
            
            // 2024-07-09
            $redirect_url = base_url()."index.php/coofficemutation/revertToLMOfficeMutationCO?case_no=" . $case_no . "&dist_code=" . $petition_basic->dist_code . "&subdiv_code=" . $petition_basic->subdiv_code . "&cir_code=" . $petition_basic->cir_code . "&mouza_pargona_code=" . $petition_basic->mouza_pargona_code . "&lot_no=" . $petition_basic->lot_no . "&vill_townprt_code=" . $petition_basic->vill_townprt_code;
        }
        else if($request=='2'){
            ///////Cancel/////////
            $sql="Update nok_tmp set co_code='$co_code', co_approve_date='$co_approve_date',approve_reject='2' where case_id='$case_no' ";
            $this->db->query($sql);
            $success="NOK Application Rejected. ";
        }
        if($success)
        {
            $data=array(
                'success'=>$success,
                'redirect_url' => $redirect_url
            );
        }else{
            $data=array(
                'error'=>"Error in submitting. Please try Again"
            );
        }
        echo json_encode($data);
    }
        ////////////////////////////////////  
    public function revertToLMOfficeMutationCO(){
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
                // $data=array(
                //     'error' => $errorMessageStr
                // );
                // echo json_encode($data);
                $this->session->set_flashdata('message', $errorMessageStr);
                return redirect($_SERVER['HTTP_REFERER']);
            }
        //xss & security validation ends 
        $db = $this->session->userdata('db');
        $case_no = $this->input->get('case_no');
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $circle_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $user_code=$this->session->userdata('user_code');


        //escalation implementation================
        $es_flag = $this->db->query("select es_flag from  petition_basic where "
                                        . " case_no='$case_no'")->row()->es_flag;


        ////////END///////////////
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $flag =false;
            $remaining_days_CO =0;
            if($es_flag == 1 && ESCALATION_ENABLE == 1){
                //remaining Days of LM ============
                $escalatedRowDetailsAgainstPetitionno = $this->Escalationmodel->getEscalatedRowDetailsCaseNo($case_no);
                if(empty($escalatedRowDetailsAgainstPetitionno) || $escalatedRowDetailsAgainstPetitionno == null)
                {
                    log_message("error", "#ESC3656, transaction-error in method 'officemutation/revertToLMOfficeMutationCO' with case-no :". $case_no);
                    $this->session->set_flashdata('message', "Something went wrong.OMUT- Error Code(#ESC3656)");
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
            $data['_view'] = 'officemutation/revertOfcMutationCaseToLM';
            $this->load->view('layouts/main',$data);
        }
        else if ($this->input->server('REQUEST_METHOD') == 'POST') {

            $this->db->trans_begin();

            $rmk=addslashes(trim($_POST['revert_report_remarks_co']));
            $coname=$this->utilityclass->getSelectedCOName($dist_code,$subdiv_code,$circle_code,$user_code);
            $rmk=$rmk . "  ???? ????? : " . $coname->username; 

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
                    $this->db->update('petition_basic', $data);    
                    if($this->db->affected_rows() != 1){ //if no updation made
                        $this->db->trans_rollback();
                        $this->session->set_flashdata(array('message' => "Revert Failed. No rows effected.."));
                        redirect(base_url()."index.php/coofficemutation/getPendingMutationCases?id=2");
                        return;
                    }
                    else { // successful


                        $proceeding_id = $this->db->query("select count(proceeding_id)+1 as pid from petition_proceeding where case_no='$case_no' ")->row()->pid;
                        if ($proceeding_id == null) {
                            $proceeding_id = 1;
                        }

                        $proceeding = [
                            'case_no' => $case_no,
                            'proceeding_id' => $proceeding_id,
                            'co_order' => $rmk,
                            'user_code' => $this->user_code,
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

                            $dist_code = $this->session->userdata('dist_code');
                            $subdiv_code = $this->session->userdata('subdiv_code');
                            $cir_code = $this->session->userdata('cir_code');

                            //ESCALATION CODE INTEGRATION================SANMRI
                            $esDataOmut = $this->db->query("select es_flag,out_of_esc from  petition_basic where "
                                        . " case_no='$case_no'")->row();

                            $es_flag = $esDataOmut->es_flag;
                            $out_of_esc = $esDataOmut->out_of_esc;
                            if($es_flag == 1 && ESCALATION_ENABLE ==1 && $out_of_esc == 0){
                                $user_code = $this->session->userdata('user_code');
                                $allocation_days = null;
                                if($this->input->post('allocate_day') !=null){
                                    $allocation_days = $this->input->post('allocate_day');
                                }

                                $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
                                $serviceType = explode('/',$basundhara);
                                $service_code =1;
                                if($serviceType[1] == 'MUTD')
                                {
                                    $service_code = 2;
                                }


                                $escalationUpdateStatus = $this->Escalationmodel->escalationCORevert($dist_code,$subdiv_code,$cir_code,$case_no,$user_code,$mouza_pargona_code,$lot_no,$allocation_days,$service_code);

                                log_message("error", "#ESC3743, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

                                if($escalationUpdateStatus['responseType'] == 0){
                                    $this->db->trans_rollback();
                                    log_message("error", "#ESC3743, transaction-error in method 'officemutation/revertToLMOfficeMutationCO' with case-no :". $case_no);
                                    $this->session->set_flashdata('message', "Something went wrong.OMUT- Error Code(#ESC3743)");
                                    redirect(base_url() . "index.php/home");
                                }
                                ///////////////END ESCALATION//////////////
                            }


                            $this->db->trans_commit();
                            $this->session->set_flashdata(array('message' => "Case has successfully reverted to LM"));
                            redirect(base_url()."index.php/coofficemutation/getPendingMutationCases?id=2");       
                        }
                        else
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata(array('message' => "Insertion failed in Proceeding"));
                            redirect(base_url()."index.php/coofficemutation/getPendingMutationCases?id=2");       
                            return;
                        }
                    }
                }
            }
        }

        public function proceeding2()
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

          //$db =  $this->session->userdata('db');

        $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

          
          if ($this->input->server('REQUEST_METHOD') == 'GET')
          {
            $_GET['case_no'] = dec_param($this->input->get('case_no'), 'case_no');
            if($_GET['case_no'] == null)
            {
                echo json_encode('Sorry !! You are not Authorized to access the content!!');
                return;
            }
            $case_no = $this->input->get('case_no');
          }
          else
          {
            $case_no = $this->input->get('case_no');
          }
          $dist_code = $this->input->get('dist_code');
          $subdiv_code = $this->input->get('subdiv_code');
          $circle_code = $this->input->get('cir_code');
          $mouza_pargona_code = $this->input->get('mouza_pargona_code');
          $lot_no = $this->input->get('lot_no');
          $vill_townprt_code = $this->input->get('vill_townprt_code');
          $attchedCo=$this->basundharamodel->attachedCO();
            if($attchedCo=='A'){
                echo json_encode('Sorry !! You are not Authorized to pass the order as Attached CO !!');
                return;
            }
          $append = "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and "
          . "vill_townprt_code='$vill_townprt_code'";
          $data['case_no'] = $case_no;
          if ($this->input->server('REQUEST_METHOD') == 'POST')
          {
           $case_no = $this->input->post('case_no');
           $status = $this->input->post('case_status');
           $user_code = $this->user_code;
           $date_entry = date('Y-m-d G:i:s');
           $dist_code = $this->input->post('dist_code');
           $subdiv_code = $this->input->post('subdiv_code');
           $cir_code = $this->input->post('cir_code');
           $mouza_pargona_code = $this->input->post('mouza_pargona_code');
           $lot_no = $this->input->post('lot_no');
           $vill_townprt_code = $this->input->post('vill_townprt_code');

        //    $is_passable = $this->utilityclass->isTheCasePassable($case_no, 'OMUT');
        //     if(!$is_passable['success']){
        //         $this->session->set_flashdata('message', $is_passable['message']);
        //         return redirect($_SERVER['HTTP_REFERER']);
        //     }

            // property chain data
            if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
            {
                $chain_ulpin = $this->input->post('ulpin', true);
                $chain_old_ulpin = $this->input->post('old_ulpin', true);
                $dag_revenue = $this->input->post('chain_revenue', true);
                $dag_local_tax = $this->input->post('chain_local_tax', true);
                $ulpinCheckFlag = $this->input->post('ulpinCheckFlag', true);
                $compareCheckFlag = $this->input->post('compareCheckFlag', true);
                // 
                if (!isset($chain_old_ulpin)) {
                    $chain_old_ulpin = "";
                }
            }
                


           $date_of_hearing = date('Y-m-d G:i:s');
           if ($status == 'final') {
            $next_date_of_hearing = date('Y-m-d G:i:s');
            } else {
                $next_date_of_hearing = date('Y-m-d', strtotime($this->input->post('next_hearing_date'))); // $this->input->post('next_hearing_date');
            }

            $co_order = $this->input->post('co_order');      
            if($co_order == '' || $co_order == null)
            {
               $co_order = ''; 
           }

           $proceeding_sql = "select max(proceeding_id)+1 as pid from  petition_proceeding 
           where case_no='$case_no' and $this->query";

           $append = "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and "
           . "vill_townprt_code='$vill_townprt_code'";
           
           $reissue_notice = $this->input->post('reissue_notice');
           $lm_petition_re = $this->input->post('lm_petition_re');
           
             //Peding for LM report/AST Notice/Continue hearing
           if ($status == 'pending')
           {
            $status='M';
            $task='CO';
            $pen = 'CO';
            $rmrk='Hearing continued by CO';
            $this->db->trans_begin();

            if ($lm_petition_re == 'y')
            {

             $pen = 'LM';
             $rmrk='Revert by CO to LM for fresh report';

             $query = "update  petition_basic set lm_note_yn=null,lm_note_date=null,sk_comment=null where case_no='$case_no' and $append";
             $this->db->query($query);
             if ($this->db->affected_rows()<=0 )
             {             
                 $this->db->trans_rollback();
                 log_message("error","#OM001 Could not update petition_basic with 
                    district: ".$dist_code.", case_no: ". $case_no);
                 $this->session->set_flashdata('message', "Could not revert to LM for fresh
                    report. Case No:".$case_no." Error Code(#OM001)");
                 redirect(base_url() . "index.php/home");
                 return;
             }            
         }
                //revert to AST for regenerate notice
         if ($reissue_notice == 'y')
         {
             $pen = 'AST';
             $rmrk='Revert by CO to AST for re-issue of notice';

             $query = "update  petition_basic set notice_generated_yn=null,proceeding_yn=null,"
             . "notice_served_yn=null,notice_generated_date=null where case_no='$case_no' and $append";
             $this->db->query($query);
             if ($this->db->affected_rows()<=0 )
             {             
                 $this->db->trans_rollback();
                 log_message("error","#OM002 Could not update petition_basic for re notice with 
                     district: ".$dist_code.", case_no: ". $case_no);
                 $this->session->set_flashdata('message', "Could not revert to AST 
                     for notice. Case No:".$case_no." Error Code(#OM002)");
                 redirect(base_url() . "index.php/home");
                 return;
             }            
         }

         $next_date_of_hearing = date('Y-m-d', strtotime($this->input->post('next_hearing_date')));
         
         
         $proceeding_id = $this->db->query($proceeding_sql)->row()->pid;
         
         if ($proceeding_id == null) {
             $proceeding_id = 1;
         }
         
         $data = [
             'case_no' => $case_no,
             'proceeding_id' => $proceeding_id,
             'date_of_hearing' => $date_of_hearing,
             'co_order' => $co_order,
             'next_date_of_hearing' => $next_date_of_hearing,
             'status' => $status,
             'user_code' => $user_code,
             'date_entry' => $date_entry,
             'dist_code' => $dist_code,
             'cir_code' => $cir_code,
             'subdiv_code' => $subdiv_code,
             'operation' => 'E',
             'date_entry' => date('Y-m-d G:i:s'),
             'ip' => $this->utilityclass->get_client_ip()
         ];
         $tstatus1 = $this->db->insert("petition_proceeding", $data);
         if ($tstatus1 != 1 )
         {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "Could not continue hearing for the case
             ".$case_no." Error Code(#OM003)");
            log_message("error","#OM003 Could not insert petition_proceeding with district: ".$dist_code.", case_no: ". $case_no);
            redirect(base_url() . "index.php/home");
            return;
        }

        $query = "update  petition_basic set proceeding_yn=null,next_date_of_hearing='$next_date_of_hearing' where case_no='$case_no' and $append";
        $this->db->query($query);
        if ($this->db->affected_rows()<=0 )
        {             
            $this->db->trans_rollback();
            log_message("error","#OM004 Could not update petition_basic with district: ".$dist_code.", case_no: ". $case_no);
            $this->session->set_flashdata('message', "Could not continue hearing for the case
             ".$case_no." Error Code(#OM004)");
            redirect(base_url() . "index.php/home");
            return;
        }
        $this->db->trans_commit();
        
        $this->DashboardData($case_no,$pen,$rmrk);           
        
        $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
        if($basundhara){                        
         $this->basundharamodel->postApiBasundharaSec($case_no,$rmrk,$status,$task,$pen);
     }
     
     redirect(base_url() . "index.php/coofficemutation/getPendingMutationCases?id=2");
    }
    else if ($status == 'final')
    {
                //////////01-03-22////////////
        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
            redirect(base_url() . "index.php/coofficemutation/finalOrderPass?case_no=" . enc_param('case_no', $case_no, 600) . "&dist_code=" . $dist_code . "&subdiv_code=" . $subdiv_code . "&cir_code=" . $cir_code . "&mouza_pargona_code=" . $mouza_pargona_code . "&lot_no=" . $lot_no . "&vill_townprt_code=" . $vill_townprt_code . "&ulpin=" . $chain_ulpin . "&old_ulpin=" . $chain_old_ulpin . "&dag_revenue=" . $dag_revenue . "&dag_local_tax=" . $dag_local_tax . "&compareCheckFlag=" . $compareCheckFlag . "&ulpinCheckFlag=" . $ulpinCheckFlag); 
        }
        else
        {
            redirect(base_url() . "index.php/coofficemutation/finalOrderPass?case_no=" . enc_param('case_no', $case_no, 600) . "&dist_code=" . $dist_code . "&subdiv_code=" . $subdiv_code . "&cir_code=" . $cir_code . "&mouza_pargona_code=" . $mouza_pargona_code . "&lot_no=" . $lot_no . "&vill_townprt_code=" . $vill_townprt_code); 
        }

    } 
             // else if ($status == 'dispose')
             // {         
             //    $this->db->trans_begin();
             //    $proceeding_id = $this->db->query($proceeding_sql)->row()->pid;

             //    if ($proceeding_id == null) {
             //       $proceeding_id = 1;
             //    }      
             //    $data = [
             //       'case_no' => $case_no,
             //       'proceeding_id' => $proceeding_id,
             //       'date_of_hearing' => $date_of_hearing,
             //       'co_order' => $co_order,
             //       'next_date_of_hearing' => $next_date_of_hearing,
             //       'status' => $status,
             //       'user_code' => $user_code,
             //       'date_entry' => $date_entry,
             //       'dist_code' => $dist_code,
             //       'cir_code' => $cir_code,
             //       'subdiv_code' => $subdiv_code,
             //       'operation' => 'E',
             //       'date_entry' => date('Y-m-d G:i:s')
             //    ];
             //    $tstatus2 = $this->db->insert("petition_proceeding", $data);
             //    if ($tstatus2 != 1 )
             //    {
             //        $this->db->trans_rollback();
             //        $this->session->set_flashdata('message', "Could not reject the case
             //           ".$case_no." Error Code(#OM005)");
             //        log_message("error","#OM005 Could not insert petition_proceeding for reject
             //          with district: ".$dist_code.", case_no: ". $case_no);
             //        redirect(base_url() . "index.php/home");
             //        return;
             //    }

             //    $d = date('Y-m-d', strtotime($this->input->post('next_hearing_date')));
             //    $query = "update  petition_basic set status='D',date_of_order='$d' where case_no='$case_no' and $append and mut_type='03'  ";
             //    $this->db->query($query);
             //    if ($this->db->affected_rows()<=0 )
             //    {             
             //        $this->db->trans_rollback();
             //        log_message("error","#OM006 Could not update petition_basic  for rejection 
             //             with district: ".$dist_code.", case_no: ". $case_no);
             //        $this->session->set_flashdata('message', "Could not reject the  the case
             //           ".$case_no." Error Code(#OM006)");
             //        redirect(base_url() . "index.php/home");
             //        return;
             //    }
             //    $this->db->trans_commit();

             //    $this->DashboardData($case_no,'NA','Rejected-'.$co_order);

             //    $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
             //    if($basundhara){
             //       $rmrk=$co_order;
             //       $status='R';
             //       $task='CO';
             //       $pen='NA';
             //       $this->basundharamodel->postApiBasundharaSec($case_no,$rmrk,$status,$task,$pen);
             //    }
             //    //redirect(base_url() . "index.php/coofficemutation/getPendingMutationCases?id=2");
             //    $this->session->set_flashdata('message', "The case
             //           ".$case_no." is successfully rejected");
             //    redirect(base_url() . "index.php/home");
             // }
    }
    else if ($this->input->server('REQUEST_METHOD') == 'GET')
    {

        $pb = $data['petition_basic'] = $this->db->query("select * from  petition_basic where case_no='$case_no' and $append")->row();
        $data['petitioner'] = $this->db->query("select * from    petitioner where $append and petition_no=$pb->petition_no")->result();
        //echo $this->db->last_query();
        if(MULTIGENERATION_ACTIVE == 1){
            if($pb->is_multigeneration == "M" || $pb->is_multigeneration == 'S'){

                return $this->proceedingForMultigeneration();
                // foreach ($data['petitioner'] as $key => $value) {
                //   if($value->generation_type == "P" || $value->generation_type == "A" ){
                //     $sql = "select pet_name as name from petitioner where pdar_id = ?";
                //     $data['petitioner'][$key]->child_of = $this->db->query($sql,array($value->next_of_pdar_id))->row()->name;
                //   }else{
                //     $data['petitioner'][$key]->child_of = "Owner Dag Pattadar";
                //   }  
                // }
            }
        }

        // Added by Abhijit -- 2024-04-29
        if($pb->is_multidag == 'Y'){
            return $this->proceeding2Multidag();
        }
        
        
       $data['pattadar'] = $this->db->query("select * from    petition_pattadar where $append and petition_no=$pb->petition_no")->result();
             //echo $this->db->last_query();
       $data['dag'] = $this->db->query("select * from    petition_dag_details where $append  and  petition_no=$pb->petition_no")->row();
        ///////////////////////////
       $sql="Select * from sro_push_history where case_no='$case_no'";
       $data['sro_history']=$this->db->query($sql)->result_array();
       //////
       if($pb->application_ref_no){
        $url = RTPS_LINK."mutation/mutation_attachment_details.php?application_ref_no=" . $pb->application_ref_no . "&applid=" . $pb->applid;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        $output = curl_exec($ch);
        curl_close($ch);
        //var_dump($output);
        $output = json_decode($output);
        $data['attachment'] = $output;
        //        var_dump($data['attachment']);
    }
             ///////////////////////////
    $data['basuCase']=null;
    $data['tempNok']=$data['apps']=$data['sro']=$data['basundharaAttachment']=$data['query']=array();
    $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($pb->case_no);
    if($basundharaExist)
    {
        $data['query']=null;
        $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($pb->case_no);
        $sql="Select * from nok_tmp where case_id='$case_no'";
        $data['tempNok']=$this->db->query($sql)->result_array();
        $data['sup_doc']=$this->mutationmodel->getDocument($case_no);
        $data['query']=$this->basundharamodel->QueryPost($basundharaExist);
        $data['sro']=$this->basundharamodel->SroPost($basundharaExist);
        $data['apps']=array();
        $url = API_LINK."serviceResponse?application_no=" . $basundharaExist ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        if($output){
         $data['apps']=$output->application;
     }

     //////////////////////////////////////////////////////////////// Property Chain Code //////////////////////////////////////////////
     if(ENABLED_BLOCKCHAIN == 1 &&  in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {

            $this->load->model('propChain/PropChainModel');
            // echo "<pre>";
            // var_dump($data['dag']);
            // die;

            $data['propChainEnableFlag'] = $this->PropChainCommonModel->isLocationEnable($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

            $landArea = $this->PropChainModel->getLandArea($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code, $lot_no, $vill_townprt_code,  $data['dag']->patta_no, $data['dag']->dag_no);

            $checkPropAndChithaAndUlpn = $this->PropChainModel->chainChithaUlpinCheckProcess($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code, $lot_no, $vill_townprt_code,  $data['dag']->patta_no, $data['dag']->dag_no, $landArea->dag_area_b, $landArea->dag_area_k, $landArea->dag_area_lc,  $landArea->dag_area_g, $data['dag']->patta_type_code);

            // echo "<pre>";
            // var_dump($data['dag']->dag_area_lc);

            // update flag in field_mut_basic only if ulpin found
            if ($checkPropAndChithaAndUlpn['ulpinCheck'] == 1 && ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'Y' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'NE')) {
                $this->PropChainModel->updateCmpFlag($case_no, $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag']);

                // if mismatch case get the view mismatch case button
                if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N')
                    $data['viewMisMatchBtn'] =  $this->PropChainModel->getMismatchBtn($case_no, $dist_code, $subdiv_code, $circle_code, $mouza_pargona_code, $lot_no, $vill_townprt_code,  $data['dag']->patta_no, $data['dag']->dag_no, $data['dag']->dag_area_b, $data['dag']->dag_area_k, $data['dag']->dag_area_lc,  $data['dag']->dag_area_g, $data['dag']->patta_type_code);
            }


            $data['ulpinCheck'] = $checkPropAndChithaAndUlpn['ulpinCheck'];
            $data['ulpinMsg'] = $checkPropAndChithaAndUlpn['ulpinMsg'];

            if ($data['ulpinCheck'] == 1) {
                $data['ulpin'] = $checkPropAndChithaAndUlpn['ulpin'];
                if (isset($data['old_ulpin']))
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
                // /////////////////////////////////////////////////////////////////////////////
    }
    $data['_view'] = 'officemutation/proceeding2';
    $this->load->view('layouts/main',$data);
    }         
    }
    public function finalOrderOfcMutationPassCO()
    {
        //xss & security validation starts
        $user_desig_code = $this->session->userdata('user_desig_code');
            $allowed = array('CO');
            if (!in_array($user_desig_code, $allowed)) {
                echo "USER-NOT-AUTHORISED"; die; // Valid
            }	
        $errorMessageStr = '';
        
        $resp = checkRequestSpecChar($_POST,array(),array(),array('co_order' => true));
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }
        $resp = checkRequestValidQuery($_POST,array(),array('co_order' => true));
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        } 
        if($errorMessageStr != ''){
            $validation=array(
                'error' => $errorMessageStr
            );
            $validation['attachment'] = 'audit';                  
            echo json_encode($validation);
            return;
        }

        //xss & security validation ends 
      //var_dump($this->input->post());
      if ($this->input->server('REQUEST_METHOD') == 'POST') 
      {
        $this->db->trans_begin();
            //$db = $this->session->userdata('db');
        $year_no = year_no;
        $value = $this->input->post();
        $case_no = $this->input->post('case_no');
          $type = explode('/', $case_no);

          $case_type = $type['4'];

          // if somebody tries to pass OMUTC in OMUT method
          if ($case_type != 'OMUT') 
          {
           echo 'Unauthorized'; exit();
          }



        $original_inhabitants = $this->input->post('original_inhabitants')??null;
        
        $dag_no = $this->input->post('dag_no');
        $dist_code = $this->input->post('dist_code');
        $this->AgriStackCaseHistory->CreateLogFile($dist_code, $case_no);
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');
        $date = date('Y-m-d');

        $deed_no = $this->input->post('deed_no');
        $trans_type = $this->input->post('mut_type');
        // var_dump($trans_type);exit;

        $caseInfoEsc = $this->db->query("SELECT * FROM petition_basic WHERE case_no=?",array($case_no))->row();


        if($caseInfoEsc->comp_serv_yn =='Y')
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }

        if($caseInfoEsc->status =='D')
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }

        if($caseInfoEsc->lm_note_yn == null && $caseInfoEsc->notice_generated_yn == null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }

        if(($caseInfoEsc->dist_code!=$dist_code) || ($caseInfoEsc->subdiv_code!=$subdiv_code) ||($caseInfoEsc->cir_code!=$cir_code) ||($caseInfoEsc->mouza_pargona_code!=$mouza_pargona_code) ||($caseInfoEsc->lot_no!=$lot_no) || ($caseInfoEsc->vill_townprt_code!=$vill_townprt_code))
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }

        if($caseInfoEsc->es_flag == 1 && ESCALATION_ENABLE == 1)
        {
            $executionDate = date('Y-m-d- H-i-s');
            $user_code = $this->session->userdata('user_code');
            $user_desig_code = $this->session->userdata('user_desig_code');
            $escalationUpdateTimeFrame = $this->Escalationmodel->escalationUpdateTimeFrame($executionDate, $dist_code, 
                $case_no, $user_code,$user_desig_code,'OMUT');
            log_message("error", "#ESC4068, transaction-error-STATUS======".json_encode($escalationUpdateTimeFrame));
            if($escalationUpdateTimeFrame['responseType'] == 1)
            {
                log_message("error", "#ESC4071, transaction-error in method 'coofficemutation/finalOrderOfcMutationPassCO' with case-no :". $case_no);
                $this->session->set_flashdata('message', "Something went wrong.ACPP- Error Code(#ESC4071)");
                redirect(base_url() . "index.php/home");
                return;
            }
            ////////////////////END////////////////////////////
        }

        if($trans_type=='' or $trans_type==null)
        {
            $validation['trans_code'] = '4468'; // updation failed in sro_note
                $this->db->trans_rollback();
                log_message("error"," #OMTCRMOR0011 Not a Valid Transfer Type or Transfer Type empty");            
                echo json_encode($validation);
                return;
        }
        $original_inhabitants = $this->input->post('original_inhabitants')??null;
        $is_passable = $this->utilityclass->isTheCasePassable($case_no, 'OMUT',$original_inhabitants);
        if(!$is_passable['success']){
            $data=array(
                'error'=> $is_passable['message'],
                'attachment' => 'audit'
            );
            echo json_encode($data);
            return false;
        }

        $transDetail = [
        'trans_code' => $trans_type
        ];
        $this->db->where('case_no', $case_no);
        $this->db->update('petition_basic', $transDetail);

        if($this->db->affected_rows() != 1){
            $this->db->trans_rollback();
            $validation['trans_code'] = '4468';
            log_message("error"," #TRNS001 Not a Valid Transfer Type or Transfer Type empty");            
            echo json_encode($validation);
            return;
        }


        // log_message('error',json_encode($_POST));
        // log_message('error',json_encode($_FILES));
        // return;
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

                                $this->db->trans_rollback();
                                $validation['attachment'] = '1001';                  
                                echo json_encode($validation);
                                return;
                            }
                            if(! in_array($ext, UPLOAD_TYPE_VALIDATION))
                            {
                                $this->db->trans_rollback();
                                $validation['attachment'] = '1001';                  
                                echo json_encode($validation);
                                return;
                            }
                            if($size > UPLOAD_MAX_SIZE)
                            {
                                $this->db->trans_rollback();
                                $validation['attachment'] = '1001';                  
                                echo json_encode($validation);
                                return;
                            }
                        }
                        else
                        {
                            $this->db->trans_rollback();
                            $validation['attachment'] = '1001';                  
                            echo json_encode($validation);
                            return;
                        }
                    }
                    else{
                        $this->db->trans_rollback();
                        $validation['attachment'] = '1001';                  
                        echo json_encode($validation);
                        return;
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
                            'mut_type'   => 'OM',
                        );
                        // save data in attachment file
                        $addMoreDocQuery = $this->db->insert('supportive_document',$document);
                        if($addMoreDocQuery != 1)
                        {
                            $this->db->trans_rollback();
                            $validation['attachment'] = '1001';                  
                            echo json_encode($validation);
                            return;
                        }
                    }
                    else
                    {
                        $this->db->trans_rollback();
                        $validation['attachment'] = '1001';                  
                        echo json_encode($validation);
                        return;
                    }
                }
            }
            //////////////////////////////////////////
        $appendq = $this->query;

        $append = "dist_code='$dist_code' AND subdiv_code='$subdiv_code' AND 
        cir_code='$cir_code' AND mouza_pargona_code='$mouza_pargona_code' AND 
        lot_no='$lot_no' AND vill_townprt_code='$vill_townprt_code'";

        $proceeding_idd = $this->db->query("SELECT max(proceeding_id)+1 AS pid FROM
           petition_proceeding WHERE case_no=? AND $this->query", array($case_no));
        //log_message('error',$this->db->last_query());
        if ($proceeding_idd->num_rows()==0){
            $proceeding_id=1;
        }else { $proceeding_id=$proceeding_idd->row()->pid; }
            //get detail from petition_basic

        $pet_basic = $this->db->query("SELECT * FROM petition_basic WHERE case_no=? and $append", array($case_no))->row();
        $petition_no = $pet_basic->petition_no;
        $deed_no = $this->input->post('deed_no');
        $sql="select trans_code from nature_trans_code where trans_type='o'";
        $trans_code_array=$this->db->query($sql)->result_array();
        if($pet_basic->mut_type=='03' && in_array($pet_basic->trans_code, $trans_code_array))
        {
            
            $is_valid_deed_no = isValidDeedNo($deed_no);
            if(!$is_valid_deed_no['success'])
            {
                $data=array(
                    'error'=> $is_valid_deed_no['message'],
                    'attachment' => 'audit'
                );
                echo json_encode($data);
                return false;
            }
        }
        ///////////Transfer Type////////////
        $sql="select trans_code from nature_trans_code ";
        $trans_code_array_all=$this->db->query($sql)->result_array();
        foreach($trans_code_array_all as $val) {$trans_code_array_check[]=$val['trans_code'];}
        if(!in_array($pet_basic->trans_code, $trans_code_array_check)){
                log_message('error',"TRANS_CODE".$pet_basic->trans_code."CASE-NO".$case_no."ARRAY".json_encode($trans_code_array_check));
                $data=array(
                    'error'=> "#ERROMUTTRANS7070 : Not a Valid Transfer Type or Transfer Type empty",
                );
                echo json_encode($data);
                return false;
        }
        //ESCALATION ==============
        if(ESCALATION_ENABLE == 1 && $pet_basic->es_flag == 1 && ESCALATION_REMARK_ENABLE ==1 && $pet_basic->out_of_esc == 0)
        {

            $responseEsc = $this->Escalationmodel->escalationRemarkCheckandUpdate($case_no,$this->input->post('esc_remark'),$this->session->userdata('user_desig_code'));
            if($responseEsc['responseType'] == 1)
            {
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"#ERROMUTESCREMARK4600 : Error in submitting in escalation remarks. Please try Again"
                );
                echo json_encode($data);
                return false;
            }

        }
        ///END+==================



        //==========check dag pending in blockchain or not=================
        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
            $this->load->model('propChain/PropChainCommonModel');
            $query = "SELECT * FROM petition_dag_details  WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND  vill_townprt_code=? AND petition_no=?";
              $dagList = $this->db->query($query, array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $petition_no))->result();
            foreach ($dagList as $key => $dagCheck) {

                $checkVal = $this->PropChainCommonModel->checkDagExistsInPropChainInPending($dagCheck->dist_code,$dagCheck->subdiv_code,$dagCheck->cir_code,$dagCheck->mouza_pargona_code,$dagCheck->lot_no,$dagCheck->vill_townprt_code,$dagCheck->dag_no);
                if($checkVal === false)
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "#ERRORBLOCCHAIN4143 : You cannot procced as dag no is pending for property chain update...");
                    redirect(base_url() . "index.php/home");
                }
            }

            
        }
        ///=============end CODE=====================

            //get detail from petitioner & petition_dag_details

        $petitioner = $this->db->query("SELECT * FROM petitioner WHERE petition_no=? AND $append order by pet_id desc ", array($petition_no));

        if ($petitioner == null || $petitioner->num_rows()<=0)
        {
            log_message("error"," #OMPET001 could not find petitioner 
                district: ".$dist_code.", petition_no: ". $petition_no);
                $validation['petitioner_nok'] = '109'; // insertion failed in infavour t_chitha
                $this->db->trans_rollback();
                echo json_encode($validation);
                return;
            } 
            $petitioner = $petitioner->row();

             // /var_dump($petitioner);
            $noktmp = $this->db->query("SELECT * FROM nok_tmp WHERE case_id=? AND approve_reject=?", array($case_no, 1))->result();
            if($noktmp)
            {
                $i=1;                    
                foreach($noktmp as $nok){
                 $basic = clone $petitioner;
                 $basic->pet_id = ($petitioner->pet_id)+$i;
                 $basic->pet_name = $nok->name_asm;
                 $basic->pet_name = $nok->name_asm;
                 $basic->guard_name = $nok->guardian_name_asm;
                 $basic->guard_rel = $nok->relation;
                 $basic->pet_gender = $nok->gender;
                 $basic->add1 = $nok->address;
                 $basic->pet_minor_dob = $nok->dob;
                 $basic->new_pattadar='N';
                 unset($basic->id);
                 $ins_pet = $this->db->insert("petitioner", $basic);
                 $i++;

                 if ($ins_pet != 1 )
                 {
                  $this->db->trans_rollback();
                  log_message("error"," #OMNOK001 could not insert nok to petitioner 
                    district: ".$dist_code.", petition_no: ". $petition_no);
                  $validation['petitioner_nok'] = '109';                  
                  echo json_encode($validation);
                  return;
              }
              
              $update="Update nok_tmp set approve_reject=2 where case_id='$case_no' and serial_id=$nok->serial_id ";
              $this->db->query($update);
              if ($this->db->affected_rows()<=0)
              {
                  $this->db->trans_rollback();
                  log_message("error"," #OMNOK002 could not update nok approve_reject  
                    district: ".$dist_code.", petition_no: ". $petition_no);
                  $validation['petitioner_nok'] = '109';                  
                  echo json_encode($validation);
                  return;
              }
          }            
      }
            //////////////////////////
      $query = "SELECT * FROM petitioner pb JOIN petition_dag_details pd ON 
      pb.dist_code = pd.dist_code AND pb.subdiv_code = pd.subdiv_code AND 
      pb.cir_code = pd.cir_code AND pb.mouza_pargona_code = pd.mouza_pargona_code AND 
      pb.lot_no = pd.lot_no AND pb.vill_townprt_code = pd.vill_townprt_code and pb.petition_no=pd.petition_no and pb.year_no=pd.year_no WHERE 
      pb.dist_code=? AND pb.subdiv_code=? AND pb.cir_code=?
      AND pb.mouza_pargona_code=? AND pb.lot_no=? AND 
      pb.vill_townprt_code=? AND pb.petition_no=?";
      $datas = $this->db->query($query, array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $petition_no))->result();

            //get detail from petition_pattadar
      $query = "SELECT * FROM petition_pattadar WHERE petition_no=? AND $append";
      $pet_pattadar = $this->db->query($query, array($petition_no));
      if ($pet_pattadar == null || $pet_pattadar->num_rows()<=0)
      {
        $this->db->trans_rollback();
        log_message("error"," #OMPPT001 could not get petition_pattadar  
          district: ".$dist_code.", petition_no: ". $petition_no);
        $validation['petitioner_nok'] = '109';                  
        echo json_encode($validation);
        return;
    }
    $pet_pattadar = $pet_pattadar->result();
    $locationData = [
       'dist_code' => $dist_code,
       'subdiv_code' => $subdiv_code,
       'cir_code' => $cir_code,
       'lot_no' => $lot_no,
       'vill_townprt_code' => $vill_townprt_code,
       'mouza_pargona_code' => $mouza_pargona_code,
       'dag_no' => $dag_no,
       'year_no' => date('Y'),
       'petition_no' => $petition_no,
    ];
    $data = [
        'case_no' => $case_no,
        'proceeding_id' => $proceeding_id,
        'date_of_hearing' => date('Y-m-d h:i:s'),
        'co_order' => addslashes($this->input->post('co_order')),
        'next_date_of_hearing' => date('Y-m-d h:i:s'),
        'status' => 'final',
        'user_code' => $this->user_code,
        'dist_code' => $dist_code,
        'cir_code' => $cir_code,
        'subdiv_code' => $subdiv_code,
        'operation' => 'E',
        'date_entry' => date('Y-m-d G:i:s'),
        'ip' => $this->utilityclass->get_client_ip()
    ];
    $pet_proceed = $this->db->insert('petition_proceeding', $data);
    if($pet_proceed != 1){
        $this->db->trans_rollback();
        $validation['pet_proceed'] = '108';            
        log_message("error"," #OMPP001 could not insert petition_proceeding  
            district: ".$dist_code.", petition_no: ". $petition_no);
        echo json_encode($validation);            
        return;
    }
            ////////////////////////////
    if($value['deed_no']=='' || $value['deed_no']==null){$value['deed_no']='';}
    if($value['deed_value']=='' || $value['deed_value']==null){$value['deed_value']='';}
    if($value['deed_date']=='' || $value['deed_date']==null){$value['deed_date']='';}

            //updation of deed details
    $deedDetail = [
        'deed_no' => $value['deed_no'],
        'deed_value' => $value['deed_value'],
        'deed_date' => date('Y-m-d', strtotime($value['deed_date'])),
        'is_original_inhabitants' => $this->input->post('original_inhabitants')??0,
    ];
    $this->db->where('case_no', $case_no);
    $this->db->update('petition_basic', $deedDetail);
    if($this->db->affected_rows() != 1){
        $this->db->trans_rollback();
        $validation['deed_updation'] = '101';
        log_message("error"," #OMPB001 could not insert petition_proceeding  
            district: ".$dist_code.", petition_no: ". $petition_no);            
        echo json_encode($validation);
        return;
    }

            //updation of mutated land
    if($value['mut_b']=='' || $value['mut_b']==null){$value['mut_b']='0';}
    if($value['mut_k']=='' || $value['mut_k']==null){$value['mut_k']='0';}
    if($value['mut_lc']=='' || $value['mut_lc']==null){$value['mut_lc']='0';}
    if($value['mut_g']=='' || $value['mut_g']==null){$value['mut_g']='0';}
    if($value['mut_kr']=='' || $value['mut_kr']==null){$value['mut_kr']='0';}

    /////////////////////////////
    if(in_array($pet_basic->trans_code, ['11', '01', '02']) && $pet_basic->mut_type=='03'){
        $value['mut_b']=$value['mut_k']=$value['mut_lc']=$value['mut_g']=$value['mut_kr']=0;
    }
    /////////////////////////////

    $mut_land = "UPDATE petition_dag_details SET 
    m_dag_area_b='".$value['mut_b']."',
    m_dag_area_k='".$value['mut_k']."',
    m_dag_area_lc='".$value['mut_lc']."',
    m_dag_area_g='".$value['mut_g']."',
    m_dag_area_kr='".$value['mut_kr']."'
    WHERE $append AND petition_no=?";
    $this->db->query($mut_land, array($petition_no));
    if($this->db->affected_rows() != 1){
        $this->db->trans_rollback();
                $validation['land_updation'] = '102'; // mutated land updation failed            
                log_message("error"," #OMPDD001 could not update land details  
                    district: ".$dist_code.", petition_no: ". $petition_no);            
                echo json_encode($validation);
                return;
            }

            //insertion in t_chitha_rmk_infavor_of
            foreach($datas as $data){
                $dec= null;
                if(isset($data->self_declaration) && $data->self_declaration !=null){
                    $dec       = $data->self_declaration;
                }
                if(isset($data->auth_type) && $data->auth_type != null){
                    //if($data->auth_type=='AADHAAR' && $data->photo == null){
                      //  $this->db->trans_rollback();
                       // log_message('error', '#ERRFMUTI005:Aadhaar Photo fetching error');
                       // redirect(base_url() . "index.php/home");
                    //}
                    $auth_type = $data->auth_type;
                    $id_ref_no = $data->id_ref_no;
                    // $photo     = $data->photo;
                    $photo     = null;
                }else{
                    $auth_type = null;
                    $id_ref_no = null;
                    $photo = null;
                }
                $strikeForce=0;
                //for multigeneration only
                if(MULTIGENERATION_ACTIVE == 1){
                    
                    //checking for GP and P as there have NOK or not-----
                    // if found then striking out otherwise not----------
                    if($data->generation_type == 'GP' || $data->generation_type=='P'){
                    $sqlStrikeForce="Select * from petitioner where petition_no = '$petition_no' and next_of_pdar_id='$data->pdar_id'";
                        if ($this->db->query($sqlStrikeForce)->num_rows()==0)
                        {
                            $strikeForce = 0;
                        }else{
                            $strikeForce = 1;
                        }
                    }
                }



                $t_chitha_rmk_infavor_of = [
                    'patta_type_code' => $data->patta_type_code,
                    'patta_no' => $data->patta_no,
                    'ord_no' => $case_no,
                    'ord_date' => date('Y-m-d G:i:s'),
                    'infavor_of_id' => $data->pet_id,
                    'infavor_of_name' => $data->pet_name,
                    'infavor_of_guardian' => $data->guard_name,
                    'infav_of_guar_relation' => $data->guard_rel,
                    'infavor_of_add1' => $data->add1,
                    'infavor_of_add2' => $data->add2,
                    'by_right_of' => $trans_type,
                    'land_area_b' => $data->m_dag_area_b,
                    'land_area_k' => $data->m_dag_area_k,
                    'land_area_lc' => $data->m_dag_area_lc,
                    'land_area_g' => 0,
                    'land_area_kr' => 0,
                    'revenue' => 0,
                    'reg_deal_no' => $value['deed_no'],
                    'reg_date' => date('Y-m-d', strtotime($value['deed_date'])),
                    'infavor_of_gender' => $data->pet_gender,
                    'infavor_of_minor_yn' => $data->pet_minor_yn,
                    'infavor_of_minor_dob' => $data->pet_minor_dob,
                    'infavor_of_mother' => $data->pet_mother,
                    'new_pattadar'     =>$data->new_pattadar,
                    'self_declaration' => $dec,
                    'auth_type'        => $auth_type,
                    'id_ref_no'        => $id_ref_no,
                    'photo'            => $photo,
                    'pdar_name_eng'    => $data->pdar_name_eng,
                    'pdar_guard_eng'   => $data->pdar_guard_eng

                ];

                //multigeneration-----------
                if(MULTIGENERATION_ACTIVE == 1){
                    $t_chitha_rmk_infavor_of['pdar_strike']     = $strikeForce;
                    $t_chitha_rmk_infavor_of['generation_type'] = $data->generation_type;
                    $t_chitha_rmk_infavor_of['rel_pdar_id']     = $data->pdar_id;
                }
                //end-===---
                $tchitha_infavorof = array_merge($t_chitha_rmk_infavor_of, $locationData);

                $ins_tchitha_infavour = $this->db->insert("t_chitha_rmk_infavor_of", $tchitha_infavorof);
                if($ins_tchitha_infavour != 1){
                   $validation['t_chitha_infavor'] = '103'; // insertion failed in infavour t_chitha
                   $this->db->trans_rollback();
                   log_message("error"," #OMTCRMI001 could not insert t_chitha_rmk_infavour_of 
                    district: ".$dist_code.", petition_no: ". $petition_no);            
                   echo json_encode($validation);
                   return;
               }
           }
           
           
            //insertion in inplace & alongwith
           foreach($pet_pattadar as $inall) 
           {
            $inplace_alongwith = $inall->striked_out;
            $table = (($inplace_alongwith==1)?'t_chitha_rmk_inplace_of':'t_chitha_rmk_alongwith');

                if($inplace_alongwith == 1) //insertion in inplace chitha
                {
                    $insertInplaceAlong = [
                        'ord_no' => $case_no,
                        'ord_date' => $date,
                        'inplace_of_id' => $inall->pdar_id,
                        'pdar_id' => $inall->pdar_id,
                        'inplace_of_name' => $inall->pdar_name,
                        'inplace_of_guardian' => $inall->pdar_guardian,
                        'inplace_of_relation' => $inall->pdar_rel_guar,
                        'strike_out' => '1'
                    ];
                }
                else if($inplace_alongwith == 0 || $inplace_alongwith == '') //insertion in alongwith chitha
                {
                    $insertInplaceAlong = [
                        'ord_no' => $case_no,
                        'ord_date' => $date,
                        'alongwith_id' => $inall->pdar_id,
                        'alongwith_name' => $inall->pdar_name,
                        'alongwith_guardian' => $inall->pdar_guardian,
                        'alongwith_rel_gur' => $inall->pdar_rel_guar,
                        'pdar_id' => $inall->pdar_id
                    ];
                }
                $tchitha_inplaceof_tmp = array_merge($insertInplaceAlong, $locationData);
                $ins_inplace = $this->db->insert($table, $tchitha_inplaceof_tmp);
               // echo $this->db->last_query();
               // echo "----------------<br>";
                if($ins_inplace != 1){
                   $validation['inplace'] = '104'; // insertion failed in inplace chitha
                   $this->db->trans_rollback();
                   log_message("error"," #OMTCIA001 could not insert ".$table
                    ."district: ".$dist_code.", petition_no: ". $petition_no);            
                   echo json_encode($validation);
                   return;
               }
               
            } //end of foreach //insertion in inplace & alongwith
            
            
            //***************************************//

            // if ($pet_basic->deed_no != 0 or $pet_basic->deed_no != null) {
            //     $update = "UPDATE sro_note SET status='3' WHERE deed_no=?";
            //     $update_sro = $this->db->query($update, array($pet_basic->deed_no));
            //     if($update_sro != true)
            //     {
            //         $validation['sro_note'] = '106'; // updation failed in sro_note
            //         $this->db->trans_rollback();
            //         return;
            //     }
            // }
            
           ////// BARAK VALLEY CODE START ////////////
            $petitioner = $this->db->query("SELECT applied_b, applied_k, applied_lc, applied_g, 
                applied_kr FROM petitioner WHERE petition_no=? and $append", 
                array($petition_no))->result();

            $pet_dag = $this->db->query("SELECT m_dag_area_b, m_dag_area_k, m_dag_area_lc,
                m_dag_area_g, m_dag_area_kr,
                dag_area_b, dag_area_k, dag_area_lc, dag_area_g, dag_area_kr, patta_no,
                patta_type_code FROM petition_dag_details WHERE petition_no=? and $append", 
                array($petition_no))->row();
            
            //calcilation for remailning land starts here
            $total_mutation_b = 0;
            $total_mutation_k = 0;
            $total_mutation_lc = 0;
            $total_mutation_g = 0;
            $total_mutation_kr = 0;

            
            if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                foreach ($petitioner  as $applied) {
                    $total_mutation_b += $applied->applied_b;
                    $total_mutation_k += $applied->applied_k;
                    $total_mutation_lc += $applied->applied_lc;
                    $total_mutation_g += $applied->applied_g;
                }

                $mutated = $total_mutation_b * 6400 + $total_mutation_k * 320 + $total_mutation_lc * 20 + $total_mutation_g ;
                $chitha = $pet_dag->dag_area_b * 6400 + $pet_dag->dag_area_k * 320 + $pet_dag->dag_area_lc * 20 + $pet_dag->dag_area_g;

                $rem = $chitha - $mutated;

                $bigha_r = floor($rem / 6400.0);
                $katha_r = floor(($rem - $bigha_r * 6400.0) / 320.0);
                $lessa_r = ($rem - $bigha_r * 6400.0 - $katha_r * 320.0)/20.0;
                $ganda_r = $rem - $bigha_r * 6400.0 - $katha_r * 320.0 - $lessa_r * 20.0;

                if ($mutated == 0) {
                    $total_mutation_b = $pet_dag->m_dag_area_b;
                    $total_mutation_k = $pet_dag->m_dag_area_k;
                    $total_mutation_lc = $pet_dag->m_dag_area_lc;
                    $total_mutation_g = $pet_dag->m_dag_area_g;
                }
            }
            else { // other than barak valley
                foreach ($petitioner  as $applied) {
                    $total_mutation_b += $applied->applied_b;
                    $total_mutation_k += $applied->applied_k;
                    $total_mutation_lc += $applied->applied_lc;
                }

                $mutated = $total_mutation_b * 100 + $total_mutation_k * 20 + $total_mutation_lc;
                $chitha = $pet_dag->dag_area_b * 100 + $pet_dag->dag_area_k * 20 + $pet_dag->dag_area_lc;
                $rem = $chitha - $mutated;

                $bigha_r = floor($rem / 100.0);
                $katha_r = floor(($rem - $bigha_r * 100.0) / 20.0);
                $lessa_r = $rem - $bigha_r * 100.0 - $katha_r * 20.0;
                $ganda_r = 0;

                if ($mutated == 0) {
                    $total_mutation_b = $pet_dag->m_dag_area_b;
                    $total_mutation_k = $pet_dag->m_dag_area_k;
                    $total_mutation_lc = $pet_dag->m_dag_area_lc;
                }    
            }
            //calculation for remaining land ends here

            //insertion in t_chitha_rmk_ordbasic
            $order_basic = [
                'ord_no' => $case_no,
                'ord_date' => date('Y-m-d'),
                'ord_type_code' => '03',
                'case_no' => $case_no,
                'ord_passby_sign_yn' => 'Y',           
                'ord_passby_desig' => 'CO',
                'lm_code' => $value['lm_code'],
                'lm_sign_yn' => 'Y',
                'lm_sign_date' => date('Y-m-d'),
                'sk_code' => $value['sk_code'],
                'sk_sign_yn' => 'Y',
                'sk_sign_date' => date('Y-m-d'),
                'co_code' => $value['co_code'],
                'co_sign_yn' => 'Y',
                'co_ord_date' => date('Y-m-d'),
                'm_dag_area_b' => $total_mutation_b,
                'm_dag_area_k' => $total_mutation_k,
                'm_dag_area_lc' => $total_mutation_lc,
                'm_dag_area_g' => $total_mutation_g,
                'm_dag_area_kr' => $total_mutation_kr,
                'area_left_b' => $bigha_r,
                'area_left_k' => $katha_r,
                'area_left_lc' => $lessa_r,
                'area_left_g' => $ganda_r, //ganda has changed
                'area_left_kr' => $pet_dag->dag_area_kr - $total_mutation_kr,
                'min_revenue' => 0.0
            ];

            ////// BARAK VALLEY CODE END //////////// 
            
            $chithaBasic = array_merge($order_basic, $locationData);
            //var_dump($chithaBasic);
            $ins_basic = $this->db->insert("t_chitha_rmk_ordbasic", $chithaBasic);
            // echo $this->db->last_query();
            // echo "----------------<br>";
            if($ins_basic != 1)
            {
                $validation['chitha_order_basic'] = '107'; // updation failed in sro_note
                $this->db->trans_rollback();
                log_message("error"," #OMTCRMOR001 could not insert t_chitha_rmk_ordbasic 
                    district: ".$dist_code.", petition_no: ". $petition_no);            
                echo json_encode($validation);
                return;
            }
            else
            {
                //$this->db->trans_rollback();
                //$this->db->trans_commit();
                $ok = $this->autoUpdateOfc($dist_code, $subdiv_code, $cir_code, $lot_no, $vill_townprt_code, $mouza_pargona_code, $petition_no, $dag_no);
                if ($ok != true)
                {
                   $validation['chitha_order_basic'] = '107'; // updation failed in sro_note
                   $this->db->trans_rollback();
                   log_message("error"," #OMAUTO001 could not auto update chitha 
                     district: ".$dist_code.", petition_no: ". $petition_no);            
                   echo json_encode($validation);
                   return;
               }

               $update = "UPDATE petition_basic SET status = 'F', date_of_order='$date' WHERE 
               case_no=? and $append and status= ?";
               $update_pet_status = $this->db->query($update, array($case_no,'P'));
               if($this->db->affected_rows() != 1)
               {
                   $validation['pet_status'] = '105'; // updation failed in petition_basic
                   $this->db->trans_rollback();
                   log_message("error"," #OMPB002 could not update Final petition_basic
                     district: ".$dist_code.", petition_no: ". $petition_no);
                   return;
               }




                //ESCALATION CODE INTEGRATION================SANMRI
                $query1 = $this->db->query("SELECT es_flag,out_of_esc FROM petition_basic WHERE petition_no=? and $append",array($petition_no))->row();
                $user_code = $this->session->userdata('user_code');
                if($query1->es_flag == 1 && ESCALATION_ENABLE ==1 && $query1->out_of_esc == 0){

                    $executionDate = $this->input->post('executionDate');

                    $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
                    $serviceType = explode('/',$basundhara);
                    $service_code =1;
                    if($serviceType[1] == 'MUTD')
                    {
                        $service_code = 2;
                    }
                    $escalationUpdateStatus = $this->Escalationmodel->escalationFinalOrderCO($service_code,$executionDate,$dist_code,$subdiv_code,$cir_code,$case_no,$user_code);
                    log_message("error", "#ESCOMUT4788, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

                    if($escalationUpdateStatus['responseType'] == 0){
                        $this->db->trans_rollback();
                        log_message("error", "#ESC4788, transaction-error in method 'officemutation/finalorderCOMain' with case-no :". $case_no);
                        $this->session->set_flashdata('message', "Something went wrong.OMUT- Error Code(#ESC4788)");
                        redirect(base_url() . "index.php/home");
                    }
                }
                ///////////////END ESCALATION//////////////

               
               
                // $validation=array(
                //     'success'=>true,
                //     'redirect_url'=>base_url().'index.php/home'
                // );
               if ($ok) 
               {
                $save_chain_data =true;
                if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                {
                    ///////////////////////////////////////////////////////////////////////////
                    //////////////////////Property chain code /////////////////////////////////
                    ///////////////////////////////////////////////////////////////////////////
                    $this->load->model('propChain/PropChainModel');
                    $ulpin = $this->input->post('ulpin', true);
                    $revenue = $this->input->post('chain_revenue', true);
                    $local_tax = $this->input->post('chain_local_tax', true);
                    $old_ulpin = $this->input->post('old_ulpin', true);

                    if (!isset($old_ulpin)) {
                        $old_ulpin = "";
                    }

                    $ulpinFlag = $this->input->post('ulpinCheckFlag', true);
                    $compareFlag = $this->input->post('compareCheckFlag', true);
                    if($compareFlag == 'Y' && $ulpinFlag ==1)
                    {

                        $type = LOC_TYPE_RURAL;
                        $patta_no = $this->input->post('patta_no');
                        $patta_type_code = $this->input->post('patta_type_code');
                        $location_id = $dist_code . $subdiv_code . $cir_code . $mouza_pargona_code . $lot_no . $vill_townprt_code;

                        $property_id = $this->blockchainutilityclass->generatePropertyId($type, $vill_townprt_code, $patta_no, $dag_no, $ulpin);
                        $reference_id = $case_no;

                        $certmnemonic = CERTMNEMONIC_MUT;

                        $property_signature = "base64 encoded signature";
                        $property_signer_key = "base64 encoded public key";
                        $office_code = $this->session->userdata('cir_code');
                        $user_code = $this->session->userdata('user_code');

                        // mutated land area
                        // $mutated_bigha = $this->input->post('mut_b');
                        // $mutated_katha = $this->input->post('mut_k');
                        // $mutated_lessa = $this->input->post('mut_lc');
                        // $mutated_ganda = $this->input->post('mut_g');

                        // total land area
                        $land_area = $this->PropChainModel->getLandArea($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no);

                        $bigha_chain = $land_area->dag_area_b;
                        $katha_chain = $land_area->dag_area_k;
                        $lessa_chain = $land_area->dag_area_lc;
                        $ganda_chain = $land_area->dag_area_g;

                        $land_class_code_query = "select land_class_code from chitha_basic where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and patta_no=? and dag_no=?";

                        $land_class_code = $this->db->query($land_class_code_query,array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_no,$dag_no))->row()->land_class_code;


                        $pattadar_details = $this->PropChainModel->getPattadars($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no);


                        // since the below parameters are not applicable assign the empty string
                        $new_patta_no = $new_dag_no = $old_revenue = $old_local_tax = $old_land_class_code  = $new_bigha = $new_katha = $new_lessa = $new_ganda = "";

                        $update_params = array(
                            'pattadar_details' => $pattadar_details,
                            'location_id' => $location_id,
                            'property_id' => $property_id,
                            'reference_id' => $reference_id,
                            'dag_no' => $dag_no,
                            'patta_no' => $patta_no,
                            'patta_type_code' => $patta_type_code,
                            'land_class_code' => $land_class_code,
                            'bigha_chain' => $bigha_chain,
                            'katha_chain' => $katha_chain,
                            'lessa_chain' => $lessa_chain,
                            'ganda_chain' => $ganda_chain,
                            'certmnemonic' => $certmnemonic,
                            'property_signature' => $property_signature,
                            'property_signer_key' => $property_signer_key,
                            'office_code' => $office_code,
                            'user_code' => $user_code,
                            'ulpin' => $ulpin,
                            'old_ulpin' => $old_ulpin,
                            'revenue' => $revenue,
                            'local_tax' => $local_tax,
                            'new_patta_no' => $new_patta_no,
                            'new_dag_no' => $new_dag_no,
                            'old_revenue' => $old_revenue,
                            'old_local_tax' => $old_local_tax,
                            'old_land_class_code' => $old_land_class_code,
                            'new_bigha' => $new_bigha,
                            'new_katha' => $new_katha,
                            'new_lessa' => $new_lessa,
                            'new_ganda' => $new_ganda
                        );

                        $chain_send_data = $this->blockchainutilityclass->getUpdateChainArrayN((object)$update_params);

                        ///////////////////////////////// call chain update api ///////////////////////////////

                        $save_chain_data = $this->PropChainModel->save_chain_data(json_encode($chain_send_data), $case_no);
                    }
                }
                if($save_chain_data)
                {
                    $this->db->trans_commit();
                    $this->AgriStackCaseHistory->CreateLog($dist_code,$case_no);
                    $curl_handle = curl_init();
                    curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK."/mutation/mutation_response.php");
                    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                         'applId' => $pet_basic->applid,
                         'application_ref_no' => $pet_basic->application_ref_no,
                         'msg' => "Delivered",
                         'status' => "D",
                    )));
                    $result = curl_exec($curl_handle);
                    $this->session->set_flashdata(array('message' => "Order Passed for Case # $case_no"));
                    $this->session->set_flashdata(array('message2' => "Chitha Updated for Case # $case_no\ and Dag # $dag_no."));

                        ////////
                    $this->DashboardDataFinal($case_no);
                    $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
                    if($basundhara){
                        $rmk='Final Order Passed';
                        $status='F';
                        $task='CO';
                        $pen='NA';
                        $case=$case_no;
                        $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
                    }
                        ////////////////////////////////////
                        /////////for jb////////////
                    $pa_no=$t_chitha_rmk_infavor_of['patta_no'];
                    $pt_code=$t_chitha_rmk_infavor_of['patta_type_code'];
                        /////////////////////
                    $location = array(
                        'd'=> $dist_code,
                        's' => $subdiv_code,
                        'c' => $cir_code,
                        'm' => $mouza_pargona_code,
                        'l' => $lot_no,
                        'v' => $vill_townprt_code,
                    );
                        //var_dump($location);
                    $this->session->set_userdata('case_no',$case_no); 
                    $this->session->set_userdata('patta_no',$pa_no);
                    $this->session->set_userdata('patta_type_code',$pt_code);
                    $this->session->set_userdata(array('loc' => $location));
                    if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                    {
                        if($ulpinFlag == 1 && $compareFlag == 'Y')
                        {
                            log_message('error',"MB4708 : BLOCK CHAIN Insertion===============");
                            $chain_update_status = 1;
                            $chain_create_status = 2;
                            $validation = array(
                                'success' => true,
                                'redirect_url' => base_url() . 'index.php/JamaBandi/step3/' .$pa_no .'/'. $pt_code.'/'.urlencode(base64_encode($case_no))
                            );
                            echo json_encode($validation);
                            return;
                        }
                        
                    }
                    $validation=array(
                     'success'=>true,
                     'redirect_url'=>base_url().'index.php/JamaBandi/step3/' .$pa_no .'/'. $pt_code);
                    echo json_encode($validation);
                    return;

                }
                elseif (!$save_chain_data) {
                    $validation['chain_status'] = 0;
                    $this->db->trans_rollback();
                    log_message('error', "Data not saved in table prop_chain_sent_data. Error code: #CHAINSAVEERROR0001");
                    return;
                } else {
                    $validation['chain_status'] = null;
                    $this->db->trans_rollback();
                    log_message("error", "#CHAINSAVEERROR0002 : Error occured. Property Chain updation for Case No $case_no Not Successfull.");
                    echo json_encode($validation);
                    return;
                }
                        
            }
        }
        echo json_encode($validation);
    }
    }
    public function autoUpdateOfc($dist_code, $subdiv_code, $cir_code, $lot_no, $vill_code, $mouza_pargona_code, $petition_no, $dag_no)
    {
        
            // $db=  $this->session->userdata('db');
            // $this->db->trans_begin();
        $record_count = 0;

        $patta_no = "";
        $locationData = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_code,
            'mouza_pargona_code' => $mouza_pargona_code,
        );

        $q = "select max(ord_cron_no)+1 as c1,max(rmk_type_hist_no)+1 as c2 from    chitha_rmk_ordbasic where"
        . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
        . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and mouza_pargona_code='$mouza_pargona_code'";

        $ord_cron_no = $this->db->query($q)->row()->c1;
        $q = "select max(rmk_type_hist_no)+1 as c2 from    chitha_rmk_gen where"
        . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
        . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and mouza_pargona_code='$mouza_pargona_code'";
        $rmk_type_hist_no = $this->db->query($q)->row()->c2;

        if ($ord_cron_no == null) {
            $ord_cron_no = 1;
        }
        if ($rmk_type_hist_no == null) {
            $rmk_type_hist_no = 1;
        }
        $order_query = "select * from    t_chitha_rmk_ordbasic where "
        . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
        . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and ord_type_code='03' and mouza_pargona_code='$mouza_pargona_code' and dag_no='$dag_no' and iscorrected_inco is null  and petition_no=$petition_no ";
        $orders = $this->db->query($order_query);
        if ($orders == null || $orders->num_rows()<=0)
        {
            $this->db->trans_rollback();
            log_message("error"," #OMAUTO003 could not get t_chitha_rmk_ordbasic data 
             district: ".$dist_code.", petition_no: ". $petition_no);
            return false;
        }

        $orders = $orders->result();
        $case_no = null;
        foreach ($orders as $order) {
            $case_no = $order->ord_no;
                //copy alongwith information from    transaction to chitha
            $record_count++;

            $alongwith_q = "select * from    t_chitha_rmk_alongwith where ord_no='$order->ord_no'";
            $alongwith_d = $this->db->query($alongwith_q);
            $alongwith_d_count = $alongwith_d->num_rows();
            

            $inplace_q = "select * from    t_chitha_rmk_inplace_of where ord_no='$order->ord_no'";
            $inplace_d = $this->db->query($inplace_q);
            $inplace_d_count = $inplace_d->num_rows();
            

            if ($alongwith_d_count <=0 && $inplace_d_count <=0)
            {
             $this->db->trans_rollback();
             log_message("error"," #OMAUTO005 inplace/alongwih data not found 
                district: ".$dist_code.", petition_no: ". $petition_no);
             return false;
         }
         $alongwith_d = $alongwith_d->result();
         $inplace_d= $inplace_d->result();


         foreach ($alongwith_d as $along) {
            $ord_cron_no = $ord_cron_no;
            unset($along->year_no);
            unset($along->petition_no);
            unset($along->iscorrected_inco);
            unset($along->iscorrected_inco_date);
            unset($along->iscorrected_rkg_record);
            unset($along->iscorrected_rkg_date);
            unset($along->make_mdb);
            $along->rmk_type_hist_no = $rmk_type_hist_no;
            $along->ord_cron_no = $ord_cron_no;
            $along->user_code = $this->user_code;
            $along->operation = 'E';
            $along->date_entry = date('Y-m-d G:i:s');
                    //var_dump($along);
                    $tstatus1 = $this->db->insert("chitha_rmk_alongwith", $along); //*****************
                    if ($tstatus1 != 1)
                    {
                      $this->db->trans_rollback();
                      log_message("error"," #OMAUTO004 could not insert t_chitha_rmk_alongwith
                         district: ".$dist_code.", petition_no: ". $petition_no);
                      return false;
                  }
              }            

              foreach ($inplace_d as $inplace) {
                $petition_no = $inplace->petition_no;
                $ord_cron_no = $ord_cron_no;
                unset($inplace->year_no);
                unset($inplace->petition_no);
                unset($inplace->iscorrected_inco);
                unset($inplace->iscorrected_inco_date);
                unset($inplace->iscorrected_rkg_record);
                unset($inplace->iscorrected_rkg_date);
                unset($inplace->make_mdb);

                $inplace->rmk_type_hist_no = $rmk_type_hist_no;
                $inplace->ord_cron_no = $ord_cron_no;
                $inplace->user_code = $this->user_code;
                $inplace->operation = 'E';
                $inplace->date_entry = date('Y-m-d G:i:s');
                    //var_dump($inplace);

                    $tstatus2 = $this->db->insert("chitha_rmk_inplace_of", $inplace); //**************
                    if ($tstatus2 != 1)
                    {
                      $this->db->trans_rollback();
                      log_message("error"," #OMAUTO005 could not insert t_chitha_rmk_inplace_of
                         district: ".$dist_code.", petition_no: ". $petition_no);
                      return false;
                  }

                  $details = $this->db->query("select * from    petition_dag_details where petition_no=$petition_no and $this->base_query")->row();

                //   $update_query = "update  chitha_dag_pattadar set p_flag='1' where "
                //   . " dist_code ='$inplace->dist_code' and subdiv_code='$inplace->subdiv_code' and "
                //   . " cir_code ='$inplace->cir_code' and mouza_pargona_code='$inplace->mouza_pargona_code' and"
                //   . " lot_no='$inplace->lot_no' and vill_townprt_code='$inplace->vill_townprt_code' and"
                //   . " TRIM(patta_no)=trim('$details->patta_no') and dag_no='$details->dag_no' and patta_type_code='$details->patta_type_code' "
                //   . " and pdar_id=$inplace->pdar_id ";
                //     //echo $update_query;;
                //   $patta_no = trim($details->patta_no);
                //   $this->db->query($update_query);
                $table = 'chitha_dag_pattadar';

                $params = [
                    'p_flag' => '1',
                ];

                // Note: Assuming your update_table method uses simple equality checks,
                // the 'patta_no' in $where is trimmed before passing here.
                $where = [
                    'dist_code'          => $inplace->dist_code,
                    'subdiv_code'        => $inplace->subdiv_code,
                    'cir_code'           => $inplace->cir_code,
                    'mouza_pargona_code' => $inplace->mouza_pargona_code,
                    'lot_no'             => $inplace->lot_no,
                    'vill_townprt_code'  => $inplace->vill_townprt_code,
                    'dag_no'             => $details->dag_no,
                    'patta_type_code'    => $details->patta_type_code,
                    'pdar_id'            => $inplace->pdar_id,
                    'patta_no'           => trim($details->patta_no), // trimmed here
                ];

                $this->Chitha_basic_model->update_table($table, $params, $where);

                  log_message('error',$this->db->last_query());
                  if ($this->db->affected_rows() <=0)
                  {
                      $this->db->trans_rollback();
                      log_message("error"," #OMAUTO006 could not update chitha_dag_pattadar
                         district: ".$dist_code.", petition_no: ". $petition_no);
                        log_message('error', '#OMAUTO006 Last query => ' . $this->db->last_query());
                      return false;
                  }
              }

              $infavour_q = "select * from  t_chitha_rmk_infavor_of where ord_no='$order->ord_no'";
              $infavour_d = $this->db->query($infavour_q);
              if ($infavour_d == null || $infavour_d->num_rows() <=0)
              {
                 $this->db->trans_rollback();
                 log_message("error"," #OMAUTO007 could not find data in t_chitha_rmk_infavor_of
                    district: ".$dist_code.", petition_no: ". $petition_no);
                 return false;
             }
             $infavour_d = $infavour_d->result();
             $is_pdar_id_set=FALSE;
             foreach ($infavour_d as $infavour) {
                $infavour->user_code = $this->user_code;
                $infavour->operation = 'E';
                $infavour->rmk_type_hist_no = $rmk_type_hist_no;
                $infavour->ord_cron_no = $ord_cron_no;
                $infavour->date_entry = date('Y-m-d G:i:s');
                unset($infavour->year_no);
                unset($infavour->petition_no);
                unset($infavour->iscorrected_inco);
                unset($infavour->iscorrected_inco_date);
                unset($infavour->iscorrected_rkg_record);
                unset($infavour->iscorrected_rkg_date);
                unset($infavour->make_mdb);
                unset($infavour->pdar_id);
                unset($infavour->revenue);
                unset($infavour->infavor_is_copdar);
                $new_pattadar = $infavour->new_pattadar;
                unset($infavour->new_pattadar);
                    //var_dump($infavour);
                    //save new pattadar in infavour of
                $this->db->insert("chitha_rmk_infavor_of", $infavour);

                $newObj = clone $infavour;
                $pattadar = array();
                $pattadar = array_merge($pattadar, $locationData);
                unset($pattadar['application_no']);

                $org_patta_no=$infavour->patta_no;
                $org_patta_type_code=$infavour->patta_type_code;
                if($is_pdar_id_set==FALSE){
                  $pattadars_in_chitha_pattadar = $this->db->query("select max(pdar_id::int)+1 as cp from chitha_pattadar where dist_code='$dist_code' and "
                    . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
                    . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$org_patta_type_code' and TRIM(patta_no)=trim('$org_patta_no')")->row()->cp;

                  $pattadars_in_jama_pattadar = $this->db->query("select max(pdar_id::int)+1 as jp from jama_pattadar where dist_code='$dist_code' and "
                   . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
                   . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$org_patta_type_code' and TRIM(patta_no)=trim('$org_patta_no')")->row()->jp;
                  $pattadars_in_chithaDag_pattadar = $this->db->query("select max(pdar_id::int)+1 as dp from chitha_dag_pattadar where dist_code='$dist_code' and "
                   . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
                   . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$org_patta_type_code' and TRIM(patta_no)=trim('$org_patta_no') and dag_no='$dag_no'")->row()->dp;
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
                if ($pdar_id == null) {
                    $pdar_id = 1;
                }
                $is_pdar_id_set=TRUE;
            }else{
              $pdar_id = $pdar_id+1;
          }
                    // $pdar_id_query = "select max(cast(pdar_id as int))+1 as pdar_id from    chitha_pattadar  where "
                    //         . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
                    //         . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and mouza_pargona_code='$mouza_pargona_code' "
                    //         . " and TRIM(patta_no)=trim('$infavour->patta_no') and patta_type_code='$infavour->patta_type_code'";
                    // $pdar_id = $this->db->query($pdar_id_query)->row()->pdar_id;

                    // //echo $pdar_id_query;
                    // if ($pdar_id == null) {
                    //     $pdar_id = 1;
                    // }


          //newly added aadhaar details to chitha pattadar----10052023
            $flagAadhaar = null;
            $flagPan = null;
            if($infavour->auth_type == 'AADHAAR'){
                $pdar_aadharno = $infavour->id_ref_no;
                $flagAadhaar = $infavour->id_ref_no;
                $flagPan = null;
            }else if($infavour->auth_type == 'PAN'){
                $pdar_pan_no = $infavour->id_ref_no;
                $flagAadhaar = null;
                $flagPan = $infavour->id_ref_no;
            }

            $pdar_photo = $infavour->photo;
            $other_data = array(
                'pdar_id' => $pdar_id,
                'patta_no' => trim($infavour->patta_no),
                'patta_type_code' => $infavour->patta_type_code,
                'pdar_name' => $infavour->infavor_of_name,
                'pdar_father' => $infavour->infavor_of_guardian,
                'pdar_add1' => $infavour->infavor_of_add1,
                'pdar_add2' => $infavour->infavor_of_add2,
                'pdar_add3' => "",
                'user_code' => $infavour->user_code,
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'jama_yn' => 'n',
                'pdar_guard_reln' => $infavour->infav_of_guar_relation,
                'new_pdar_name' => $new_pattadar,
                'pdar_aadharno' => $flagAadhaar,
                'pdar_pan_no'   => $flagPan,
                'pdar_photo'    => $pdar_photo,
                'pdar_name_eng' => $infavour->pdar_name_eng,
                'pdar_guard_eng' => $infavour->pdar_guard_eng,
            );

          $details = $this->db->query("select * from    petition_dag_details where petition_no=$petition_no and $this->base_query")->row();
          $patta_no = trim($details->patta_no);
          $pattadar = array_merge($pattadar, $other_data);
          $pattadar['f1_case_no']=$case_no;
        //   $tstatus4 = $this->db->insert("chitha_pattadar", $pattadar);
          $tstatus4 = $this->Chitha_basic_model->insert_table('chitha_pattadar',$pattadar);
          if ($tstatus4 != 1)
          {
              $this->db->trans_rollback();
              log_message("error"," #OMAUTO008 could not insert chitha_pattadar
                 district: ".$dist_code.", petition_no: ". $petition_no);
              return false;
          }

          $dag_pattadar = array();
          $dag_pattadar = array_merge($dag_pattadar, $locationData);
          unset($dag_pattadar['application_no']);

          $dag_pattadar_other = array(
            'pdar_id' => $pdar_id,
            'patta_no' => trim($infavour->patta_no),
            'patta_type_code' => $infavour->patta_type_code,
            'dag_por_b' => $infavour->land_area_b,
            'dag_por_k' => $infavour->land_area_k,
            'dag_por_lc' => $infavour->land_area_lc,
            'dag_por_g' => $infavour->land_area_g,
            'dag_por_kr' => $infavour->land_area_kr,
            'user_code' => $this->user_code,
            'date_entry' => date('Y-m-d G:i:s'),
            'operation' => 'E',
            'jama_yn' => 'n',
            'dag_no' => $infavour->dag_no,
            'p_flag' => 0,
        );
          $dag_pattadar = array_merge($dag_pattadar, $dag_pattadar_other);
        //   $tstatus5 = $this->db->insert("chitha_dag_pattadar", $dag_pattadar);
          $tstatus5 = $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$dag_pattadar);
          if ($tstatus5 != 1)
          {
              $this->db->trans_rollback();
              log_message("error"," #OMAUTO009 could not insert chitha_dag_pattadar
                 district: ".$dist_code.", petition_no: ". $petition_no);
              return false;
          }

        //   $q = "update  chitha_basic set jama_yn=null where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
        //   . "cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and "
        //   . "lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$infavour->dag_no' and TRIM(patta_no)=trim('$infavour->patta_no')";

        //   $this->db->query($q);

        $table = "chitha_basic";

        $params = [
            'jama_yn' => null
        ];

        $where = [
            'dist_code'          => $dist_code,
            'subdiv_code'        => $subdiv_code,
            'cir_code'           => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no'             => $lot_no,
            'vill_townprt_code'  => $vill_code,
            'dag_no'             => $infavour->dag_no,
            'patta_no'           => trim($infavour->patta_no)
        ];

        $result0 = $this->Chitha_basic_model->update_table($table, $params, $where);

        if ($result0 <=0)
        {
            $this->db->trans_rollback();
            log_message("error"," #OMAUTO010 could not update chitha_basic
                district: ".$dist_code.", petition_no: ". $petition_no);
            return false;
        }
      }

      $order->user_code = $this->user_code;
      $order->date_entry = date('Y-m-d G:i:s');
      $order->operation = 'E';
      $order->user_code = $this->user_code;
                //var_dump($order);
      unset($order->year_no);
      unset($order->petition_no);
      unset($order->year_no);
      unset($order->iscorrected_inco);
      unset($order->iscorrected_inco_date);
      unset($order->iscorrected_rkg_record);
      unset($order->iscorrected_rkg_date);
      unset($order->isdataposted_torkg_db);
      unset($order->isorder_cancelled);
      unset($order->ifyes_reason1);
      unset($order->ifyes_reason2);
      unset($order->ifyes_reason3);
      unset($order->ifyes_reason4);
      unset($order->make_mdb);
      unset($order->min_revenue);
      unset($order->make_mdb);

      $rmk_gen = array(
        'dag_no' => $dag_no,
        'rmk_type_code' => '01',
        'rmk_type_hist_no' => $rmk_type_hist_no,
        'user_code' => $this->user_code,
        'date_entry' => date('Y-m-d G:i:s'),
        'operation' => 'E',
        'jama_updated' => 'N',
        'patta_no' => trim($patta_no)
    );
      $rmk_gen = array_merge($locationData, $rmk_gen);
      unset($rmk_gen['application_no']);

      $tstatus6 = $this->db->insert("chitha_rmk_gen", $rmk_gen);
      if ($tstatus6 != 1)
      {
         $this->db->trans_rollback();
         log_message("error"," #OMAUTO011 could not insert chitha_rmk_gen
            district: ".$dist_code.", petition_no: ". $petition_no);
         return false;
     }

     $order->ord_cron_no = $ord_cron_no;
     $order->rmk_type_hist_no = $rmk_type_hist_no;
                //var_dump($rmk_gen);
     $tstatus7 = $this->db->insert("chitha_rmk_ordbasic", $order);
     if ($tstatus7 != 1)
     {
         $this->db->trans_rollback();
         log_message("error"," #OMAUTO012 could not insert chitha_rmk_ordbasic
            district: ".$dist_code.", petition_no: ". $petition_no);
         return false;
     }

     $q = "update  t_chitha_rmk_ordbasic set iscorrected_inco='Y' where ord_no='$order->ord_no'";
     $this->db->query($q);
     if ($this->db->affected_rows() <=0)
     {
         $this->db->trans_rollback();
         log_message("error"," #OMAUTO013 could not update t_chitha_rmk_ordbasic
            district: ".$dist_code.", petition_no: ". $petition_no);
         return false;
     }
     $rmk_type_hist_no++;
    }
    if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();
        return false;
    } else {            
        return true;
    }
    }

          ////////////START MPR:////////
        //   public function proceeding1() {
        //     $db=  $this->session->userdata('db');
        //     $case_no = $this->input->get('case_no');
        //     $dist_code = $this->input->get('dist_code');
        //     $subdiv_code = $this->input->get('subdiv_code');
        //     $circle_code = $this->input->get('cir_code');
        //     $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        //     $lot_no = $this->input->get('lot_no');
        //     $vill_townprt_code = $this->input->get('vill_townprt_code');

        //     $append = "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and "
        //             . "vill_townprt_code='$vill_townprt_code'";

        //     $data['case_no'] = $case_no;
        //     $year_no = year_no;
        //     if ($this->input->server('REQUEST_METHOD') == 'POST') {
        //         $case_no = $this->input->post('case_no');
        //         $proceeding_id = $this->db->query("select count(proceeding_id)+1 as pid from  petition_proceeding where case_no='$case_no' and $this->query")->row()->pid;
        //         if ($proceeding_id == null) {
        //             $proceeding_id = 1;
        //         }
        //         $date_of_hearing = date('Y-m-d G:i:s');
        //         $co_order = $this->input->post('co_order');
        //         $next_date_of_hearing = $this->input->post('next_hearing_date');

        //         $status = $this->input->post('status');
        //         $user_code = $this->user_code;
        //         $date_entry = date('Y-m-d G:i:s');
        //         $dist_code = $this->input->post('dist_code');
        //         $subdiv_code = $this->input->post('subdiv_code');
        //         $cir_code = $this->input->post('cir_code');
        //         $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        //         $lot_no = $this->input->post('lot_no');
        //         $vill_townprt_code = $this->input->post('vill_townprt_code');

        //         $append = "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and "
        //                 . "vill_townprt_code='$vill_townprt_code'";
        //         $dd = date('Y-m-d', strtotime($next_date_of_hearing));
        //         $data = array(
        //             'case_no' => $case_no,
        //             'proceeding_id' => $proceeding_id,
        //             'date_of_hearing' => $date_of_hearing,
        //             'co_order' => $co_order,
        //             'next_date_of_hearing' => date('Y-m-d', strtotime($next_date_of_hearing)),
        //             'status' => $status,
        //             'user_code' => $user_code,
        //             'date_entry' => $date_entry,
        //             'dist_code' => $dist_code,
        //             'cir_code' => $cir_code,
        //             'subdiv_code' => $subdiv_code,
        //             'operation' => 'E'
        //         );
        //         $tstatus1=$this->db->insert("petition_proceeding", $data); //********************
        //         if ($tstatus1 != 1 )
        //         {
        //            $this->session->set_flashdata('message', "Petition Proceeding could not saved. Error Code(#OM005)");
        //            redirect(base_url() . "index.php/home");
        //         }
        //         $query = "update  petition_basic set not_fresh='Y',status='P',next_date_of_hearing='$dd' where case_no='$case_no' and $append";
        //         $this->db->query($query); //**********************

        //         $pb = $data['petition_basic'] = $this->db->query("select * from petition_basic where case_no='$case_no' and $append")->row();
        //         $firstParty = $this->db->query("select * from    petitioner where $append and petition_no=$pb->petition_no")->result();
        //         $q = "select * from    petition_pattadar where $append and petition_no=$pb->petition_no";
        //         $secondParty = $this->db->query("select * from    petition_pattadar where $append and petition_no=$pb->petition_no")->result();

        //         $query = "select count(notified_id)+1 as cunt from    petition_notified where $append and petition_no=$pb->petition_no";
        //         $notified_id = $this->db->query($query)->row()->cunt;

        //         foreach ($firstParty as $app) {
        //             $noticeData = array(
        //                 'dist_code' => $pb->dist_code,
        //                 'subdiv_code' => $pb->subdiv_code,
        //                 'cir_code' => $pb->cir_code,
        //                 'lot_no' => $pb->lot_no,
        //                 'mouza_pargona_code' => $pb->mouza_pargona_code,
        //                 'vill_townprt_code' => $pb->vill_townprt_code,
        //                 'petition_no' => $pb->petition_no,
        //                 'notified_id' => $notified_id++,
        //                 'notified_name' => $app->pet_name,
        //                 'add1' => $app->add1,
        //                 'add2' => $app->add2,
        //                 'user_code' => $this->user_code,
        //                 'date_entry' => date('Y-m-d G:i:s'),
        //                 'operation' => 'E',
        //                 'year_no' => date('Y')
        //             );
        //             $this->db->insert("petition_notified", $noticeData); //****************
        //         }

        //         foreach ($secondParty as $app) {
        //             $noticeData = array(
        //                 'dist_code' => $pb->dist_code,
        //                 'subdiv_code' => $pb->subdiv_code,
        //                 'cir_code' => $pb->cir_code,
        //                 'lot_no' => $pb->lot_no,
        //                 'mouza_pargona_code' => $pb->mouza_pargona_code,
        //                 'vill_townprt_code' => $pb->vill_townprt_code,
        //                 'petition_no' => $pb->petition_no,
        //                 'notified_id' => $notified_id++,
        //                 'notified_name' => $app->pdar_name,
        //                 'add1' => $app->pdar_add1,
        //                 'add2' => $app->pdar_add2,
        //                 'user_code' => $this->user_code,
        //                 'date_entry' => date('Y-m-d G:i:s'),
        //                 'operation' => 'E',
        //                 'year_no' => date('Y')
        //             );
        //             $this->db->insert("petition_notified", $noticeData); //*******************
        //         }
        //         //////
        //         $penUser='AST';
        //         $rmrk='First Proceeding given by CO';
        //         $this->DashboardData($case_no,$penUser,$rmrk);

        //         //////////////////////////
        //         $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
        //         if($basundharaExist){
        //             $rmk='Forwarded to LM';
        //             $status='M';
        //             $task='CO';
        //             $pen='LM';
        //             $case=$case_no;
        //             $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen); 
        //         }
        //         //////////////////////
        //         redirect(base_url() . "index.php/coofficemutation/issueNotice?case_no=" . $case_no . "&petition_no=" . $pb->petition_no);
        //     } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
        //         $query = "select * from    petition_basic where case_no='$case_no' and $append";
        //         $pb = $data['petition_basic'] = $this->db->query($query)->row();

        //      if($pb->application_ref_no){
        //         $url = RTPS_LINK."mutation/mutation_attachment_details.php?application_ref_no=" . $pb->application_ref_no . "&applid=" . $pb->applid;
        //         $ch = curl_init();
        //         curl_setopt($ch, CURLOPT_URL, $url);
        //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //         $output = curl_exec($ch);
        //         curl_close($ch);
        //         $output = json_decode($output);
        //         $data['attachment'] = $output;
        //         //var_dump($data['attachment']);
        //      }
        //         $data['basuCase']=null;
        //         $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
        //         if($basundharaExist){
        //             $data['query']=null;
        //             $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
        //             $data['query']=$this->basundharamodel->QueryPost($basundharaExist);
        //             $data['sro']=$this->basundharamodel->SroPost($basundharaExist);
        //         }
        //         $query = "select * from    petitioner where $append and petition_no=$pb->petition_no" . " ";
        //         $data['petitioner'] = $this->db->query($query)->result();

        //         $q = "select * from    petition_pattadar where $append and  petition_no=$pb->petition_no";

        //         $data['pattadar'] = $this->db->query("select * from    petition_pattadar where $append  and  petition_no=$pb->petition_no")->result();
        //         $q = "select * from    petition_dag_details where $append and  petition_no=$pb->petition_no";
        //         $data['dag'] = $this->db->query("select * from    petition_dag_details where $append  and  petition_no=$pb->petition_no")->row();

        //      $data['_view'] = 'officemutation/proceeding1';
        //      $this->load->view('layouts/main',$data);
        //     }
        // }
    public function proceeding1() {  
        //xss and sql injection checking start
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
        //xss and sql injection checking ends    
        $db=  $this->session->userdata('db');
        //$case_no = $this->input->get('case_no');
        if ($this->input->server('REQUEST_METHOD') == 'GET')
        {
            $case_no = $_GET['case_no'] = dec_param($this->input->get('case_no'), 'case_no');
            if($_GET['case_no'] == null)
            {
                echo json_encode('Sorry !! You are not Authorized to access the content!!');
                return;
            }
            $case_no = $this->input->get('case_no');
        }
        else
        {
            $case_no = $this->input->get('case_no');
        }

        $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }
        
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $circle_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');

        $append = "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and "
        . "vill_townprt_code='$vill_townprt_code'";

        $data['case_no'] = $case_no;
        $year_no = year_no;

        // // Added by Abhijit -- 2024-04-23
        // $case_segments = explode('/', $pb->case_no);
        // $serviceCode = end($case_segments);

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            // if($serviceCode == 'OMUT' && MULTI_DAG_MUTATION_DEED_ACTIVE == 1){
            //     $data['_view'] = 'officemutation/multi-dag-proceeding1';                    
            // }
                //*******************validation*****************//
            $om_cofp = [
                [
                    'field' => 'case_no',
                    'label' => 'Case-No',
                    'rules' => 'required|callback_check_script|max_length[50]|trim|xss_clean'
                ],
                [
                    'field' => 'dist_code',
                    'label' => 'District-Code',
                    'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
                ],
                [
                    'field' => 'subdiv_code',
                    'label' => 'Sub-Division-Code',
                    'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
                ],
                [
                    'field' => 'cir_code',
                    'label' => 'Circle-Code',
                    'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
                ],
                [
                    'field' => 'mouza_pargona_code',
                    'label' => 'Mouza Pargona Code',
                    'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
                ],
                [
                    'field' => 'lot_no',
                    'label' => 'Lot-No',
                    'rules' => 'required|callback_check_script|max_length[2]|trim|xss_clean'
                ],
                [
                    'field' => 'vill_townprt_code',
                    'label' => 'Village-To',
                    'rules' => 'required|callback_check_script|max_length[5]|trim|xss_clean'
                ],
                [
                    'field' => 'co_order',
                    'label' => 'Co-Order',
                    'rules' => 'required|callback_check_script|trim|xss_clean'
                ],
                [
                    'field' => 'next_hearing_date',
                    'label' => 'Next-Hearing-Date',
                    'rules' => 'required|callback_check_script|callback_date_valid|trim|xss_clean'
                ],
            ];
            $this->form_validation->set_message('check_script','Please Fill The %s Correctly!');
            $this->form_validation->set_message('date_valid','Please Fill The %s Correctly!');
            $this->form_validation->set_rules($om_cofp);
            if ($this->form_validation->run() == FALSE)
            {   
                $error_msg = array();
                foreach($om_cofp as $rule){
                    if (form_error($rule['field'])) {
                        array_push($error_msg, form_error($rule['field']));
                    }
                }  
                $this->session->set_flashdata('validation_msg', $error_msg);
                redirect(base_url() . "index.php/home");
                exit;
            }
                //***********************************************************************//
            $this->db->trans_begin();            
            $case_no = $this->input->post('case_no');
            $proceeding_id = $this->db->query("select count(proceeding_id)+1 as pid from  petition_proceeding where case_no='$case_no' and $this->query")->row()->pid;
            if ($proceeding_id == null) {
                $proceeding_id = 1;
            }
            $date_of_hearing = date('Y-m-d G:i:s');
            $co_order = $this->input->post('co_order');
            $next_date_of_hearing = $this->input->post('next_hearing_date');

            $status = $this->input->post('status');
            $user_code = $this->user_code;
            $date_entry = date('Y-m-d G:i:s');
            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $cir_code = $this->input->post('cir_code');
            $mouza_pargona_code = $this->input->post('mouza_pargona_code');
            $lot_no = $this->input->post('lot_no');
            $vill_townprt_code = $this->input->post('vill_townprt_code');

            $append = "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and "
            . "vill_townprt_code='$vill_townprt_code'";
            $dd = date('Y-m-d', strtotime($next_date_of_hearing));

            $ip = $this->utilityclass->get_client_ip();

            

            $data = array(
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => $date_of_hearing,
                'co_order' => $co_order,
                'next_date_of_hearing' => date('Y-m-d', strtotime($next_date_of_hearing)),
                'status' => $status,
                'user_code' => $user_code,
                'date_entry' => $date_entry,
                'dist_code' => $dist_code,
                'cir_code' => $cir_code,
                'subdiv_code' => $subdiv_code,
                'operation' => 'E',
                'ip' => $ip
            );
                $tstatus1=$this->db->insert("petition_proceeding", $data); //********************                
                if ($tstatus1 != 1 )
                {
                    $this->db->trans_rollback();
                    log_message("error", "#OMCOFP001, Error in insert, table 'petition_proceeding' with case-no :". $case_no. ", dist-code : ".$dist_code);
                    $this->session->set_flashdata('message', "Petition Proceeding could not saved. Error Code(#OMCOFP001)");
                    redirect(base_url() . "index.php/home");
                }
                // $next_date_of_hearing_new = date('Y-m-d H:i:s', strtotime($next_date_of_hearing));
                $next_date_of_hearing_new = date('Y-m-d H:i:s', strtotime($next_date_of_hearing . date('H:i:s')));
				
                $query = "update  petition_basic set not_fresh=?,status=?,next_date_of_hearing=? where case_no=? and $append";
                $this->db->query($query,array('Y','P',$next_date_of_hearing_new,$case_no)); //**********************
                // log_message('error','LASTSSSSS================='.$this->db->last_query());
                if($this->db->affected_rows() <= 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', "#OMCOFP002: Updation failed in petition_basic with case-no :". $case_no. ", dist-code : ".$dist_code);
                    $this->session->set_flashdata('message', "Petition Proceeding could not saved. Error Code(#OMCOFP002)");
                    redirect(base_url() . "index.php/home");
                    return false;
                }

                $pb = $data['petition_basic'] = $this->db->query("select * from petition_basic where case_no='$case_no' and $append")->row();

                if(ESCALATION_ENABLE == 1 && $pb->es_flag == 1 && $pb->out_of_esc == 0)
                {
                    $condOnHearing = $this->Escalationmodel->checkHearingDate($next_date_of_hearing, $case_no, 'petition_basic');
                    if($condOnHearing['response'] == 1){
                      $this->db->trans_rollback();
                      log_message("error", $condOnHearing['message']);
                      $this->session->set_flashdata('message', $condOnHearing['message']);
                      redirect(base_url() . "index.php/home");
                    }
                }



                $firstParty = $this->db->query("select * from    petitioner where $append and petition_no=$pb->petition_no")->result();
                $q = "select * from    petition_pattadar where $append and petition_no=$pb->petition_no";
                $secondParty = $this->db->query("select * from    petition_pattadar where $append and petition_no=$pb->petition_no")->result();

                $query = "select count(notified_id)+1 as cunt from    petition_notified where $append and petition_no=$pb->petition_no";
                $notified_id = $this->db->query($query)->row()->cunt;

                if(ESCALATION_ENABLE ==1 && $pb->es_flag == 1){
                    $trans_type = $this->input->post('mut_type');
                    if(isset($trans_type) && $trans_type !=null){
                        $queryForUpdateTransType = "update  petition_basic set trans_code='$trans_type' where case_no='$case_no' and $append";
                        $this->db->query($queryForUpdateTransType); //**********************
                        if($this->db->affected_rows() <= 0)
                        {
                            $this->db->trans_rollback();
                            log_message('error', "#OMCOFP002M: Updation failed in petition_basic with case-no :". $case_no. ", dist-code : ".$dist_code);
                            $this->session->set_flashdata('message', "Petition Proceeding could not saved. Error Code(#OMCOFP002M)");
                            redirect(base_url() . "index.php/home");
                            return false;
                        }
                    }
                   $next_date_of_hearing_new = date('Y-m-d H:i:s', strtotime($next_date_of_hearing . date('H:i:s')));
                }

                foreach ($firstParty as $app) {
                    $noticeData = array(
                        'dist_code' => $pb->dist_code,
                        'subdiv_code' => $pb->subdiv_code,
                        'cir_code' => $pb->cir_code,
                        'lot_no' => $pb->lot_no,
                        'mouza_pargona_code' => $pb->mouza_pargona_code,
                        'vill_townprt_code' => $pb->vill_townprt_code,
                        'petition_no' => $pb->petition_no,
                        'notified_id' => $notified_id++,
                        'notified_name' => $app->pet_name,
                        'add1' => $app->add1,
                        'add2' => $app->add2,
                        'user_code' => $this->user_code,
                        'date_entry' => date('Y-m-d G:i:s'),
                        'operation' => 'E',
                        'year_no' => date('Y')
                    );
                    $tstatus2 = $this->db->insert("petition_notified", $noticeData); //****************
                    if ($tstatus2 != 1 )
                    {
                        $this->db->trans_rollback();
                        log_message("error", "#OMCOFP003, Error in insert, table 'petition_notified' with case-no :". $case_no. ", dist-code : ".$dist_code);
                        $this->session->set_flashdata('message', "Petition Proceeding could not saved. Error Code(#OMCOFP003)");
                        redirect(base_url() . "index.php/home");
                    }
                }

                foreach ($secondParty as $app) {
                    $noticeData = array(
                        'dist_code' => $pb->dist_code,
                        'subdiv_code' => $pb->subdiv_code,
                        'cir_code' => $pb->cir_code,
                        'lot_no' => $pb->lot_no,
                        'mouza_pargona_code' => $pb->mouza_pargona_code,
                        'vill_townprt_code' => $pb->vill_townprt_code,
                        'petition_no' => $pb->petition_no,
                        'notified_id' => $notified_id++,
                        'notified_name' => $app->pdar_name,
                        'add1' => $app->pdar_add1,
                        'add2' => $app->pdar_add2,
                        'user_code' => $this->user_code,
                        'date_entry' => date('Y-m-d G:i:s'),
                        'operation' => 'E',
                        'year_no' => date('Y')
                    );
                    $tstatus3 = $this->db->insert("petition_notified", $noticeData); 
                    //*******************
                    if ($tstatus3 != 1 )
                    {
                        $this->db->trans_rollback();
                        log_message("error", "#OMCOFP004, Error in insert, table 'petition_notified' with case-no :". $case_no. ", dist-code : ".$dist_code);
                        $this->session->set_flashdata('message', "Petition Proceeding could not saved. Error Code(#OMCOFP004)");
                        redirect(base_url() . "index.php/home");
                    }
                }

                //ESCALATION ==============
                if(ESCALATION_ENABLE == 1 && $pb->es_flag == 1 && $pb->out_of_esc ==0)
                {

                    $responseEsc = $this->Escalationmodel->escalationRemarkCheckandUpdate($case_no,$this->input->post('esc_remark'),$this->session->userdata('user_desig_code'));
                    if($responseEsc['responseType'] == 1)
                    {
                        $this->db->trans_rollback();
                        $data=array(
                            'error'=>"#ERRESCREMARKOMUT00111 : Error in submitting in escalation remarks. Please try Again"
                        );
                        echo json_encode($data);
                        return false;
                    }

                }
                ///END+==================

                if($this->db->trans_status()==FALSE){
                    $this->db->trans_rollback();
                    log_message("error", "#OMCOFP005, transaction-error in method 'coofficemutation/proceeding1' with case-no :". $case_no['case_no'].", dist-code : ".$dist_code);
                    $this->session->set_flashdata('message', "Petition Proceeding could not saved. Error Code(#OMCOFP005)");
                    redirect(base_url() . "index.php/home");
                }else{

                    //ESCALATION CODE INTEGRATION================SANMRI
                    $executionDate = $this->input->post('executionDate');
                    $user_code = $this->session->userdata('user_code');
                    $es_flag = $pb->es_flag;
                    if($es_flag == 1 && ESCALATION_ENABLE ==1 && $pb->out_of_esc == 0){
                        $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
                        $serviceType = explode('/',$basundharaExist);
                        $service_code =1;
                        if($serviceType[1] == 'MUTD')
                        {
                            $service_code = 2;
                        }
                        $hearingDateEsc = date('Y-m-d H:i:s', strtotime($next_date_of_hearing));
                        $escalationUpdateStatus = $this->Escalationmodel->escalationCOFirstProcedingNew($service_code,$executionDate,$dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$case_no,$user_code,$hearingDateEsc);

                        log_message("error", "#ESC5803, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

                        if($escalationUpdateStatus['responseType'] == 0){
                            $this->db->trans_rollback();
                            log_message("error", "#ESC5803, transaction-error in method 'coofficemutation/proceeding1' with case-no :". $case_no['case_no'].", dist-code : ".$dist_code);
                            $this->session->set_flashdata('message', "Something went wrong.OMUT- Error Code(#ESC5803)");
                            redirect(base_url() . "index.php/home");
                        }
                    }
                    ///////////////END ESCALATION//////////////
                    $this->db->trans_commit();
                }       
                //////
                $penUser='AST';
                $rmrk='First Proceeding given by CO';
                $this->DashboardData($case_no,$penUser,$rmrk);
                //////////////////////////
                $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
                if($basundharaExist){
                    $rmk='Forwarded to LM';
                    $status='M';
                    $task='CO';
                    $pen='LM';
                    $case=$case_no;
                    $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen); 
                }
                //////////////////////
                redirect(base_url() . "index.php/coofficemutation/issueNotice?case_no=" . $case_no . "&petition_no=" . $pb->petition_no);
            } else if ($this->input->server('REQUEST_METHOD') == 'GET') {
                $query = "select * from    petition_basic where case_no='$case_no' and $append";
                $pb = $data['petition_basic'] = $this->db->query($query)->row();
                if(MULTIGENERATION_ACTIVE == 1){
                    if($pb->is_multigeneration == "M" || $pb->is_multigeneration == 'S'){
                        $this->coIssueNoticeOmutCase($case_no,$append);
                        return;
                    }
                    
                }
            
				//$data['tranfer_type'] = null;
                if($pb->trans_code == null){
                    $data['tranfer_type'] = $this->utilityclass->mutType('i');
                }else{
                    $data['trans_code'] = $pb->trans_code;
                }
                // Added by Abhijit -- 2024-04-23
                $case_segments = explode('/', $pb->case_no);
                $serviceCode = end($case_segments);


                if($pb->application_ref_no){
                    $url = RTPS_LINK."mutation/mutation_attachment_details.php?application_ref_no=" . $pb->application_ref_no . "&applid=" . $pb->applid;
                    $output = sendCurlRequest($url);
                    // $ch = curl_init();
                    // curl_setopt($ch, CURLOPT_URL, $url);
                    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                    // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                    // $output = curl_exec($ch);
                    // curl_close($ch);
                    $output = json_decode($output);
                    $data['attachment'] = $output;
                }
                $data['basuCase']=null;
                $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
                if($basundharaExist){
                    $data['query']=null;
                    $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
                    $data['query']=$this->basundharamodel->QueryPost($basundharaExist);
                    $data['sro']=$this->basundharamodel->SroPost($basundharaExist);
                }
                $query = "select * from    petitioner where $append and petition_no=$pb->petition_no" . " ";
                $data['petitioner'] = $this->db->query($query)->result();

                $q = "select * from    petition_pattadar where $append and  petition_no=$pb->petition_no";

                $data['pattadar'] = $this->db->query("select * from    petition_pattadar where $append  and  petition_no=$pb->petition_no")->result();
                $q = "select * from    petition_dag_details where $append and  petition_no=$pb->petition_no";
                $data['dag'] = $this->db->query("select * from    petition_dag_details where $append  and  petition_no=$pb->petition_no")->row();


                //////////////////////////////////////////////////////////////// Property Chain Code //////////////////////////////////////////////

                if(ENABLED_BLOCKCHAIN == 1 &&  in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                {
                    $this->load->model('propChain/PropChainModel');
                    $land_area = $this->PropChainModel->getLandArea($data['dag']->dist_code, $data['dag']->subdiv_code, $data['dag']->cir_code, $data['dag']->mouza_pargona_code, $data['dag']->lot_no, $data['dag']->vill_townprt_code, $data['dag']->patta_no, $data['dag']->dag_no);

                    $checkPropAndChithaAndUlpn = $this->PropChainModel->chainChithaUlpinCheckProcess($data['dag']->dist_code, $data['dag']->subdiv_code, $data['dag']->cir_code, $data['dag']->mouza_pargona_code, $data['dag']->lot_no, $data['dag']->vill_townprt_code,  $data['dag']->patta_no, $data['dag']->dag_no, $land_area->dag_area_b, $land_area->dag_area_k, $land_area->dag_area_lc, $land_area->dag_area_g, $data['dag']->patta_type_code);

                    // update flag only if ulpin found
                    if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'Y' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'NE') {
                        $this->PropChainModel->updateCmpFlag($case_no, $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag']);
                        // if mismatch case get the view mismatch case button
                        if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N')
                            $data['viewMisMatchBtn'] =  $this->PropChainModel->getMismatchBtn($case_no, $data['dag']->dist_code, $data['dag']->subdiv_code, $data['dag']->cir_code, $data['dag']->mouza_pargona_code, $data['dag']->lot_no, $data['dag']->vill_townprt_code,  $data['dag']->patta_no, $data['dag']->dag_no, $land_area->dag_area_b, $land_area->dag_area_k, $land_area->dag_area_lc, $land_area->dag_area_g, $data['dag']->patta_type_code);
                    }

                    $data['ulpinCheck'] = $checkPropAndChithaAndUlpn['ulpinCheck'];
                    $data['ulpinMsg'] = $checkPropAndChithaAndUlpn['ulpinMsg'];

                    if ($data['ulpinCheck'] == 1) {
                        $data['ulpin'] = $checkPropAndChithaAndUlpn['ulpin'];
                        if (isset($data['old_ulpin']))
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

                    $data['propChainEnableFlag'] = $this->PropChainCommonModel->isLocationEnable($data['dag']->dist_code, $data['dag']->subdiv_code, $data['dag']->cir_code, $data['dag']->mouza_pargona_code, $data['dag']->lot_no, $data['dag']->vill_townprt_code);
                }

                //ESCALATED CASES REMARK ENTRY FORM==============
                if(ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE == 1 && $pb->es_flag == 1 && $pb->out_of_esc == 0)
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

                $data['_view'] = 'officemutation/proceeding1';

                // Added by Abhijit -- 2024-04-23
                if($data['petition_basic']->is_multidag == 'Y'){
                    $data['_view'] = 'officemutation/multi-dag-proceeding1';                    
                }

                $this->load->view('layouts/main',$data);
            }
        }

          ////////////END MPR:////////
        function check_script($str){

            if( strpos( trim(strtolower($str)), '<' ) !== false) {
                return FALSE;
            }

            if( strpos( trim(strtolower($str)), '>' ) !== false) {
                return FALSE;
            }
            
            if( strpos( trim(strtolower($str)), '<script>' ) !== false) {
                return FALSE;
            }
            if( strpos( trim(strtolower($str)), '</script>' ) !== false) {
                return FALSE;
            }
            return TRUE;
        }

            //date-validation 
        function date_valid($date){
            $day = (int) substr($date, 0, 2);
            $month = (int) substr($date, 3, 2);
            $year = (int) substr($date, 6, 4);
            return checkdate($month, $day, $year);
        }

        public function getPendingMutationCasesCOEndOld() {
            $this->dbswitch();
            $proceeding_id = $this->input->get('id');
            if (!$proceeding_id) {
               $proceeding_id = 1;
           }
           $append=$this->base_query;
           if ($proceeding_id == 1) {
               $query="select distinct on (case_no) *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where fmb.status is null AND fmb.comp_serv_yn is null and fmb.not_fresh is null "
               . "and fmb.lm_note_yn is null and fmb.mut_type='03' and ".$append." ";
             // $query = "select * from petition_basic where status is null and not_fresh is null "
             // . "and lm_note_yn is null and mut_type='03' and ".$append." order by date_entry desc";
           } else if ($proceeding_id == 2) {
            $query="select distinct on (case_no) *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where  fmb.not_fresh='Y' AND fmb.comp_serv_yn is null and "
            . " fmb.status='P' and fmb.mut_type='03' and ".$append." ";
             // $query = "select * from petition_basic where not_fresh='Y' and "
             // . " status='P' and mut_type='03' and ".$append." order by date_entry desc";
            }
            $data['cases'] = $this->db->query($query)->result();
            // var_dump($data['cases']);
            // exit;
                 //var_dump($data);
            $data['proceeding_id'] = $proceeding_id;
            $resume_query = "SELECT * from Petition_basic WHERE  status='F' AND comp_serv_yn is null and order_passed is null and ".$append."  order by date_entry desc";
            $data['resume'] = $this->db->query($resume_query)->result();
            $data['_view'] = 'officemutation/cases';
            $this->load->view('layouts/main',$data);
        }

        //created for getting all the pending list at CO login circle wise---------
        public function getPendingMutationCasesCOEnd(){
            $dist_code =$this->session->userdata('dist_code');
            $subdiv_code =$this->session->userdata('subdiv_code');
            $cir_code =$this->session->userdata('cir_code');
            $draw = intval($this->input->post('draw'));
            $searchByCol_0 = $this->input->post('columns')[2]['search']['value'];
            $start = intval($this->input->post('start'));
            $length = intval($this->input->post('length'));
            $order = $this->input->post('order');
            $mouza_code = $this->input->post('mouza_code');
            $lot_no = $this->input->post('lot_no');
            $vill_mouza_code = $this->input->post('vill_mouza_code');
            $vill_lot_no = $this->input->post('vill_lot_no');
            $village_code = $this->input->post('village_code');
            $define_date = define_date;
            $zone_status     = $this->input->post('zone_status');

            if($zone_status != null || $zone_status != ''){ // 4: old cases

                $results = $this->Escalationmodel->getPendingMutationCasesCOEnd($dist_code,$subdiv_code,$cir_code,$start,$length,$order,$mouza_code,$lot_no,$vill_mouza_code,$vill_lot_no,$village_code,$define_date,$searchByCol_0, $zone_status);
            }
            else {
                $results = $this->mutationmodel->getPendingMutationCasesCOEnd($dist_code,$subdiv_code,$cir_code,$start,$length,$order,$mouza_code,$lot_no,$vill_mouza_code,$vill_lot_no,$village_code,$define_date,$searchByCol_0);    
            }

            if(isset($results)){
            $data_rows = $results['data_results'];
                // foreach($data_rows as $rows){
                //     $link = base_url() . "index.php/coofficemutation/proceeding1?case_no=" . $rows->case_no . "&dist_code=" . $rows->dist_code . "&subdiv_code=" . $rows->subdiv_code . "&cir_code=" . $rows->cir_code . "&mouza_pargona_code=" . $rows->mouza_pargona_code . "&lot_no=" . $rows->lot_no . "&vill_townprt_code=" . $rows->vill_townprt_code;
                //     $button = "<a href=".$link." class='btn btn-success'>".$this->lang->line("write_report")."</a>";
                //     $mouza_lot = $this->utilityclass->getMouzaName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code)."-".$this->utilityclass->getLotName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code,$rows->lot_no);
                //     $e = $rows->application_ref_no!=null?$rows->application_ref_no:$rows->basundhara;
                //     $json[] = array(
                //         $rows->case_no."<br><span class='small font-italic red'>".$e."</span>",
                //         $mouza_lot,
                //         $this->utilityclass->getVillageName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code,$rows->lot_no,$rows->vill_townprt_code),
                //         date('M jS, Y',strtotime($rows->date_entry)),
                //         $button
                //     );
                // }
                $total_records = $results['total_records'];

                if($total_records > 0){
                    // log_message('error', '#5521: Data details : '.json_encode($data_rows));
                    foreach($data_rows as $rows){
                        // echo "<pre>";
                        // var_dump($rows); 
                        // log_message("error","UTPAL001: ==========".json_encode($rows));
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
                        $link = base_url() . "index.php/coofficemutation/proceeding1?case_no=" . enc_param('case_no', $rows->case_no, 600) . "&dist_code=" . $rows->dist_code . "&subdiv_code=" . $rows->subdiv_code . "&cir_code=" . $rows->cir_code . "&mouza_pargona_code=" . $rows->mouza_pargona_code . "&lot_no=" . $rows->lot_no . "&vill_townprt_code=" . $rows->vill_townprt_code;

                        if(ESCALATION_ENABLE == 1 && $rows->is_escalated == 1)
                        {
                            $button = "Escalated to Upper Officer";
                        }
                        else
                        {
                            $button = "<a href=".$link." class='btn btn-success'>".$this->lang->line("write_report")."</a>";
                        }


                        
                        $mouza_lot = $this->utilityclass->getMouzaName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code)."-".$this->utilityclass->getLotName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code,$rows->lot_no);
                        $e = $rows->application_ref_no!=null?$rows->application_ref_no:$rows->basundhara;
                        if(ESCALATION_ENABLE == 1){
                            $json[] = array(

                                $rows->escalation_zone,
                                $rows->escalation_date,

                                $rows->case_no."<br><span class='small font-italic red'>".$e."</span>",
                                $mouza_lot,
                                $this->utilityclass->getVillageName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code,$rows->lot_no,$rows->vill_townprt_code),
                                date('M jS, Y',strtotime($rows->date_entry)),
                                $button
                            );
                        }else{
                            $json[] = array(

                                $rows->case_no."<br><span class='small font-italic red'>".$e."</span>",
                                $mouza_lot,
                                $this->utilityclass->getVillageName($rows->dist_code,$rows->subdiv_code,$rows->cir_code,$rows->mouza_pargona_code,$rows->lot_no,$rows->vill_townprt_code),
                                date('M jS, Y',strtotime($rows->date_entry)),
                                $button
                            );
                        }
                        
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
            }else{
                $response = array();
                $response['sEcho']=0;
                $response['iTotalRecords']=0;
                $response['iTotalDisplayRecords']=0;
                $response['aaData']=[];
                echo json_encode($response);
            }
        }

    //multigeneration office case first procceding for co login ------------
    public function coIssueNoticeOmutCase($case_no,$append){
        $data = array();
        $data['case_no'] = $case_no;
        $query = "select * from    petition_basic where case_no='$case_no' and $append";
        $pb = $data['petition_basic'] = $this->db->query($query)->row();
 
        if($pb->is_multigeneration == "M"){
            $genType = "Multi Generation ";
        }else if($pb->is_multigeneration == "S"){
            $genType = "Single Generation";
        }
        $data['mutation_type_single_multi'] = $genType;
        $data['other_properties'] = $this->db->where('case_no', $case_no)->get('mut_additional_properties')->result();

        if($pb->application_ref_no){
            $url = RTPS_LINK."mutation/mutation_attachment_details.php?application_ref_no=" . $pb->application_ref_no . "&applid=" . $pb->applid;
            $output = sendCurlRequest($url);
            $output = json_decode($output);
            $data['attachment'] = $output;
        }
        $data['basuCase']=null;
        $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
        if($basundharaExist){
            $data['query']=null;
            $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($case_no);
            $data['query']=$this->basundharamodel->QueryPost($basundharaExist);
            $data['sro']=$this->basundharamodel->SroPost($basundharaExist);
        }
        $query = "select * from    petitioner where $append and petition_no=$pb->petition_no" . " ";
        $data['petitioner'] = $this->db->query($query)->result();
        
        if($pb->is_multigeneration == "M"){
            foreach ($data['petitioner'] as $key => $value) {
              if($value->generation_type == "P" || $value->generation_type == "A" ){
                $sql = "select pet_name as name from petitioner where pdar_id = ?";
                $child_of = $this->db->query($sql,array($value->next_of_pdar_id))->row();

                $data['petitioner'][$key]->child_of = $child_of ? $child_of->name : '';
              }else{
                $data['petitioner'][$key]->child_of = "Owner Dag Pattadar";
              }  
            }
        }
        
        $q = "select * from    petition_pattadar where $append and  petition_no=$pb->petition_no";

        $data['pattadar'] = $this->db->query("select * from    petition_pattadar where $append  and  petition_no=$pb->petition_no")->result();
        $q = "select * from    petition_dag_details where $append and  petition_no=$pb->petition_no";
        $data['dag'] = $this->db->query("select * from    petition_dag_details where $append  and  petition_no=$pb->petition_no")->row();
        //tree view for CO end----------
        $data['owner_pattadar'] = null;
        $tree['tree'] = null;
        $tree['generation_type'] = null;

        if($pb->is_multigeneration == "M"){
            $tree = $this->cofieldmutationmodel->fetchTreeDataOffice($case_no); 
            $data['owner_pattadar'] = $tree['owner_pattadar'];
            $data['tree'] = $tree['tree'];
            $data['generation_type'] = $tree['generation_type'];
        }

        if($pb->trans_code == null){
            $data['tranfer_type'] = $this->utilityclass->mutType('i');
        }else{
            $data['trans_code'] = $pb->trans_code;
        }

        //

        //////////////////////////////////////////////////////////////// Property Chain Code //////////////////////////////////////////////

        // if(ENABLED_BLOCKCHAIN == 1 &&  in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))){
        //     $this->load->model('propChain/PropChainModel');
        //     $land_area = $this->PropChainModel->getLandArea($data['dag']->dist_code, $data['dag']->subdiv_code, $data['dag']->cir_code, $data['dag']->mouza_pargona_code, $data['dag']->lot_no, $data['dag']->vill_townprt_code, $data['dag']->patta_no, $data['dag']->dag_no);

        //     $checkPropAndChithaAndUlpn = $this->PropChainModel->chainChithaUlpinCheckProcess($data['dag']->dist_code, $data['dag']->subdiv_code, $data['dag']->cir_code, $data['dag']->mouza_pargona_code, $data['dag']->lot_no, $data['dag']->vill_townprt_code,  $data['dag']->patta_no, $data['dag']->dag_no, $land_area->dag_area_b, $land_area->dag_area_k, $land_area->dag_area_lc, $land_area->dag_area_g, $data['dag']->patta_type_code);

        //     // update flag only if ulpin found
        //     if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'Y' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'NE') {
        //         $this->PropChainModel->updateCmpFlag($case_no, $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag']);
        //         // if mismatch case get the view mismatch case button
        //         if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N')
        //             $data['viewMisMatchBtn'] =  $this->PropChainModel->getMismatchBtn($case_no, $data['dag']->dist_code, $data['dag']->subdiv_code, $data['dag']->cir_code, $data['dag']->mouza_pargona_code, $data['dag']->lot_no, $data['dag']->vill_townprt_code,  $data['dag']->patta_no, $data['dag']->dag_no, $land_area->dag_area_b, $land_area->dag_area_k, $land_area->dag_area_lc, $land_area->dag_area_g, $data['dag']->patta_type_code);
        //     }

        //     $data['ulpinCheck'] = $checkPropAndChithaAndUlpn['ulpinCheck'];
        //     $data['ulpinMsg'] = $checkPropAndChithaAndUlpn['ulpinMsg'];

        //     if ($data['ulpinCheck'] == 1) {
        //         $data['ulpin'] = $checkPropAndChithaAndUlpn['ulpin'];
        //         if (isset($data['old_ulpin']))
        //             $data['old_ulpin'] = $checkPropAndChithaAndUlpn['old_ulpin'];
        //         else
        //             $data['old_ulpin'] = "";
        //     }

        //     // if property does not exists get create asset button
        //     if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'NE') {
        //         $data['createPropChainBtn'] = $checkPropAndChithaAndUlpn['createPropChainBtn'];
        //     }
        //     $data['chithaPropChainCmpFlag'] = $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'];
        //     $data['compareFlagMsg'] = $checkPropAndChithaAndUlpn['compareFlagMsg'];
        //     $data['revenue'] = $checkPropAndChithaAndUlpn['revenue'];
        //     $data['local_tax'] = $checkPropAndChithaAndUlpn['local_tax'];
        //     // hidden fields
        //     $data['ulpin_hidden'] = $checkPropAndChithaAndUlpn['ulpin_hidden'];
        //     $data['uplpin_msg_hidden'] = $checkPropAndChithaAndUlpn['uplpin_msg_hidden'];
        //     $data['compare_hidden'] = $checkPropAndChithaAndUlpn['compare_hidden'];
        //     $data['compare_msg_hidden'] = $checkPropAndChithaAndUlpn['compare_msg_hidden'];

        //     // bhunaksha area cmp
        //     $data['bhuChithaCmpStatus'] = $checkPropAndChithaAndUlpn['bhuChithaCmpStatus'];
        //     $data['bhuChithaCmpMsg'] = $checkPropAndChithaAndUlpn['bhuChithaCmpMsg'];
        //     $data['bhu_hidden'] = $checkPropAndChithaAndUlpn['bhu_hidden'];
        //     $data['bhu_compare_msg_hidden'] = $checkPropAndChithaAndUlpn['bhu_compare_msg_hidden'];

        //     $data['propChainEnableFlag'] = $this->PropChainCommonModel->isLocationEnable($data['dag']->dist_code, $data['dag']->subdiv_code, $data['dag']->cir_code, $data['dag']->mouza_pargona_code, $data['dag']->lot_no, $data['dag']->vill_townprt_code);
        // }


        //ESCALATED CASES REMARK ENTRY FORM==============
        if(ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE == 1 && $pb->es_flag == 1)
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
        $data['_view'] = 'officemutation/proceeding_for_issue_notice';
        $this->load->view('layouts/main',$data);
    }

    // Added by Abhijit -- 2024-04-29
    public function proceeding2Multidag(){
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
        $attchedCo=$this->basundharamodel->attachedCO();
        if($attchedCo=='A'){
            echo json_encode('Sorry !! You are not Authorized to pass the order as Attached CO !!');
            return;
        }
        $append = "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and "
        . "vill_townprt_code='$vill_townprt_code'";
        $data['case_no'] = $case_no;
        if ($this->input->server('REQUEST_METHOD') == 'POST')
        {
            $case_no = $this->input->post('case_no');
            $status = $this->input->post('case_status');
            $user_code = $this->user_code;
            $date_entry = date('Y-m-d G:i:s');
            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $cir_code = $this->input->post('cir_code');
            $mouza_pargona_code = $this->input->post('mouza_pargona_code');
            $lot_no = $this->input->post('lot_no');
            $vill_townprt_code = $this->input->post('vill_townprt_code');

            // $is_passable = $this->utilityclass->isTheCasePassable($case_no, 'OMUT');
            // if(!$is_passable['success']){
            //     $this->session->set_flashdata('message', $is_passable['message']);
            //     return redirect($_SERVER['HTTP_REFERER']);
            // }

            $pb = $this->db->query("select * from  petition_basic where case_no='$case_no'")->row();
            if(!$pb){
                $this->session->set_flashdata('message',"No such case found.");
                return redirect('/home');
            }
            
            if($pb->is_multidag != 'Y'){
                $this->session->set_flashdata('message',"This service is inactive for now.");
                return redirect('/home');
            }
            
            // property chain data
            if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
            {
                $chain_ulpin = $this->input->post('ulpin', true);
                $chain_old_ulpin = $this->input->post('old_ulpin', true);
                $dag_revenue = $this->input->post('chain_revenue', true);
                $dag_local_tax = $this->input->post('chain_local_tax', true);
                $ulpinCheckFlag = $this->input->post('ulpinCheckFlag', true);
                $compareCheckFlag = $this->input->post('compareCheckFlag', true);
                // 
                if (!isset($chain_old_ulpin)) {
                    $chain_old_ulpin = "";
                }
            }
                
    
    
            $date_of_hearing = date('Y-m-d G:i:s');
            if ($status == 'final') {
                $next_date_of_hearing = date('Y-m-d G:i:s');
            } else {
                $next_date_of_hearing = date('Y-m-d', strtotime($this->input->post('next_hearing_date'))); // $this->input->post('next_hearing_date');
            }
    
            $co_order = $this->input->post('co_order');      
            if($co_order == '' || $co_order == null)
            {
                $co_order = ''; 
            }
    
            $proceeding_sql = "select max(proceeding_id)+1 as pid from  petition_proceeding 
            where case_no='$case_no' and $this->query";
    
            $append = "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and "
            . "vill_townprt_code='$vill_townprt_code'";
            
            $reissue_notice = $this->input->post('reissue_notice');
            $lm_petition_re = $this->input->post('lm_petition_re');
            
                //Peding for LM report/AST Notice/Continue hearing
            if ($status == 'pending')
            {
                $status='M';
                $task='CO';
                $pen = 'CO';
                $rmrk='Hearing continued by CO';
                $this->db->trans_begin();
    
                if ($lm_petition_re == 'y')
                {
    
                    $pen = 'LM';
                    $rmrk='Revert by CO to LM for fresh report';
    
                    $query = "update  petition_basic set lm_note_yn=null,lm_note_date=null,sk_comment=null where case_no='$case_no' and $append";
                    $this->db->query($query);
                    if ($this->db->affected_rows()<=0 )
                    {             
                        $this->db->trans_rollback();
                        log_message("error","#MULDOM001 Could not update petition_basic with 
                        district: ".$dist_code.", case_no: ". $case_no);
                        $this->session->set_flashdata('message', "Could not revert to LM for fresh
                        report. Case No:".$case_no." Error Code(#MULDOM001)");
                        redirect(base_url() . "index.php/home");
                        return;
                    }            
                }
                    //revert to AST for regenerate notice
                if ($reissue_notice == 'y')
                {
                    $pen = 'AST';
                    $rmrk='Revert by CO to AST for re-issue of notice';
    
                    $query = "update  petition_basic set notice_generated_yn=null,proceeding_yn=null,"
                    . "notice_served_yn=null,notice_generated_date=null where case_no='$case_no' and $append";
                    $this->db->query($query);
                    if ($this->db->affected_rows()<=0 )
                    {             
                        $this->db->trans_rollback();
                        log_message("error","#MULDOM002 Could not update petition_basic for re notice with 
                            district: ".$dist_code.", case_no: ". $case_no);
                        $this->session->set_flashdata('message', "Could not revert to AST 
                            for notice. Case No:".$case_no." Error Code(#MULDOM002)");
                        redirect(base_url() . "index.php/home");
                        return;
                    }            
                }
    
                $next_date_of_hearing = date('Y-m-d', strtotime($this->input->post('next_hearing_date')));
                
                
                $proceeding_id = $this->db->query($proceeding_sql)->row()->pid;
                
                if ($proceeding_id == null) {
                    $proceeding_id = 1;
                }
                
                $data = [
                    'case_no' => $case_no,
                    'proceeding_id' => $proceeding_id,
                    'date_of_hearing' => $date_of_hearing,
                    'co_order' => $co_order,
                    'next_date_of_hearing' => $next_date_of_hearing,
                    'status' => $status,
                    'user_code' => $user_code,
                    'date_entry' => $date_entry,
                    'dist_code' => $dist_code,
                    'cir_code' => $cir_code,
                    'subdiv_code' => $subdiv_code,
                    'operation' => 'E',
                    'date_entry' => date('Y-m-d G:i:s'),
                    'ip' => $this->utilityclass->get_client_ip()
                ];
                $tstatus1 = $this->db->insert("petition_proceeding", $data);
                if ($tstatus1 != 1 )
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Could not continue hearing for the case
                        ".$case_no." Error Code(#MULDOM003)");
                    log_message("error","#MULDOM003 Could not insert petition_proceeding with district: ".$dist_code.", case_no: ". $case_no);
                    redirect(base_url() . "index.php/home");
                    return;
                }
    
                $query = "update  petition_basic set proceeding_yn=null,next_date_of_hearing='$next_date_of_hearing' where case_no='$case_no' and $append";
                $this->db->query($query);
                if ($this->db->affected_rows()<=0 )
                {             
                    $this->db->trans_rollback();
                    log_message("error","#MULDOM004 Could not update petition_basic with district: ".$dist_code.", case_no: ". $case_no);
                    $this->session->set_flashdata('message', "Could not continue hearing for the case
                        ".$case_no." Error Code(#MULDOM004)");
                    redirect(base_url() . "index.php/home");
                    return;
                }
                $this->db->trans_commit();
    
                $this->DashboardData($case_no,$pen,$rmrk);           
    
                $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
                if($basundhara){                        
                    $this->basundharamodel->postApiBasundharaSec($case_no,$rmrk,$status,$task,$pen);
                }
    
                redirect(base_url() . "index.php/coofficemutation/getPendingMutationCases?id=2");
            } else if ($status == 'final') {
                    //////////01-03-22////////////
                if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                {
                    redirect(base_url() . "index.php/coofficemutation/finalOrderPassMultiDag?case_no=" . $case_no . "&dist_code=" . $dist_code . "&subdiv_code=" . $subdiv_code . "&cir_code=" . $cir_code . "&mouza_pargona_code=" . $mouza_pargona_code . "&lot_no=" . $lot_no . "&vill_townprt_code=" . $vill_townprt_code . "&ulpin=" . $chain_ulpin . "&old_ulpin=" . $chain_old_ulpin . "&dag_revenue=" . $dag_revenue . "&dag_local_tax=" . $dag_local_tax . "&compareCheckFlag=" . $compareCheckFlag . "&ulpinCheckFlag=" . $ulpinCheckFlag); 
                }
                else
                {
                    redirect(base_url() . "index.php/coofficemutation/finalOrderPassMultiDag?case_no=" . $case_no . "&dist_code=" . $dist_code . "&subdiv_code=" . $subdiv_code . "&cir_code=" . $cir_code . "&mouza_pargona_code=" . $mouza_pargona_code . "&lot_no=" . $lot_no . "&vill_townprt_code=" . $vill_townprt_code); 
                }
            } 
            
        } else if ($this->input->server('REQUEST_METHOD') == 'GET')
        {
            $pb = $data['petition_basic'] = $this->db->query("select * from  petition_basic where case_no='$case_no' and $append")->row();
            if(!$pb){
                $this->session->set_flashdata('message',"No such case found.");
                return redirect('/home');
            }
            
            if($pb->is_multidag != 'Y'){
                $this->session->set_flashdata('message',"This service is inactive for now.");
                return redirect('/home');
            }

            $data['petitioner'] = $this->db->query("select * from    petitioner where $append and petition_no=$pb->petition_no")->result();
            //echo $this->db->last_query();
            
            $data['pattadar'] = $this->db->query("select * from    petition_pattadar where $append and petition_no=$pb->petition_no")->result();
                 //echo $this->db->last_query();
            $data['dag'] = $this->db->query("select * from    petition_dag_details where $append  and  petition_no=$pb->petition_no")->row();
                 ///////////////////////////
            if($pb->application_ref_no){
                $url = RTPS_LINK."mutation/mutation_attachment_details.php?application_ref_no=" . $pb->application_ref_no . "&applid=" . $pb->applid;
                $output = sendCurlRequest($url);
    
                $output = json_decode($output);
                $data['attachment'] = $output;
                //        var_dump($data['attachment']);
            }
                 ///////////////////////////
            $data['basuCase']=null;
            $data['tempNok']=$data['apps']=$data['sro']=$data['basundharaAttachment']=$data['query']=array();
            $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($pb->case_no);
            if($basundharaExist)
            {
                $data['query']=null;
                $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($pb->case_no);
                $sql="Select * from nok_tmp where case_id='$case_no'";
                $data['tempNok']=$this->db->query($sql)->result_array();
                $data['sup_doc']=$this->mutationmodel->getDocument($case_no);
                $data['query']=$this->basundharamodel->QueryPost($basundharaExist);
                $data['sro']=$this->basundharamodel->SroPost($basundharaExist);
                $data['apps']=array();
                $url = API_LINK."serviceResponse?application_no=" . $basundharaExist ;
                $output = sendCurlRequest($url);
                
                $output = json_decode($output);
                if($output){
                    $data['apps']=$output->application;
                }
    
                //////////////////////////////////////////////////////////////// Property Chain Code //////////////////////////////////////////////
                if(ENABLED_BLOCKCHAIN == 1 &&  in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                {
    
                    $this->load->model('propChain/PropChainModel');
                    // echo "<pre>";
                    // var_dump($data['dag']);
                    // die;
    
                    $data['propChainEnableFlag'] = $this->PropChainCommonModel->isLocationEnable($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);
    
                    $landArea = $this->PropChainModel->getLandArea($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code, $lot_no, $vill_townprt_code,  $data['dag']->patta_no, $data['dag']->dag_no);
    
                    $checkPropAndChithaAndUlpn = $this->PropChainModel->chainChithaUlpinCheckProcess($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code, $lot_no, $vill_townprt_code,  $data['dag']->patta_no, $data['dag']->dag_no, $landArea->dag_area_b, $landArea->dag_area_k, $landArea->dag_area_lc,  $landArea->dag_area_g, $data['dag']->patta_type_code);
    
                    // echo "<pre>";
                    // var_dump($data['dag']->dag_area_lc);
    
                    // update flag in field_mut_basic only if ulpin found
                    if ($checkPropAndChithaAndUlpn['ulpinCheck'] == 1 && ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'Y' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'NE')) {
                        $this->PropChainModel->updateCmpFlag($case_no, $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag']);
    
                        // if mismatch case get the view mismatch case button
                        if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N')
                            $data['viewMisMatchBtn'] =  $this->PropChainModel->getMismatchBtn($case_no, $dist_code, $subdiv_code, $circle_code, $mouza_pargona_code, $lot_no, $vill_townprt_code,  $data['dag']->patta_no, $data['dag']->dag_no, $data['dag']->dag_area_b, $data['dag']->dag_area_k, $data['dag']->dag_area_lc,  $data['dag']->dag_area_g, $data['dag']->patta_type_code);
                    }
    
    
                    $data['ulpinCheck'] = $checkPropAndChithaAndUlpn['ulpinCheck'];
                    $data['ulpinMsg'] = $checkPropAndChithaAndUlpn['ulpinMsg'];
    
                    if ($data['ulpinCheck'] == 1) {
                        $data['ulpin'] = $checkPropAndChithaAndUlpn['ulpin'];
                        if (isset($data['old_ulpin']))
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
                    // /////////////////////////////////////////////////////////////////////////////
            }
            
            $data['_view'] = 'officemutation/multi-dag-proceeding2';
            $this->load->view('layouts/main',$data);
        } 
    }


    //multigeneration office case for procceding assistant login=========
    public function proceedingForMultigeneration(){
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
        //$db =  $this->session->userdata('db');
        $case_no = $this->input->get('case_no');
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $circle_code = $this->input->get('cir_code');
        $mouza_pargona_code = $this->input->get('mouza_pargona_code');
        $lot_no = $this->input->get('lot_no');
        $vill_townprt_code = $this->input->get('vill_townprt_code');
        $attchedCo=$this->basundharamodel->attachedCO();
        if($attchedCo=='A'){
            echo json_encode('Sorry !! You are not Authorized to pass the order as Attached CO !!');
            return;
        }
        $append = "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and "
          . "vill_townprt_code='$vill_townprt_code'";
          $data['case_no'] = $case_no;
        if ($this->input->server('REQUEST_METHOD') == 'POST')
        {
            $case_no = $this->input->post('case_no');
            $status = $this->input->post('case_status');
            $user_code = $this->user_code;
            $date_entry = date('Y-m-d G:i:s');
            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $cir_code = $this->input->post('cir_code');
            $mouza_pargona_code = $this->input->post('mouza_pargona_code');
            $lot_no = $this->input->post('lot_no');
            $vill_townprt_code = $this->input->post('vill_townprt_code');


            // property chain data
            if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
            {
                $chain_ulpin = $this->input->post('ulpin', true);
                $chain_old_ulpin = $this->input->post('old_ulpin', true);
                $dag_revenue = $this->input->post('chain_revenue', true);
                $dag_local_tax = $this->input->post('chain_local_tax', true);
                $ulpinCheckFlag = $this->input->post('ulpinCheckFlag', true);
                $compareCheckFlag = $this->input->post('compareCheckFlag', true);
                // 
                if (!isset($chain_old_ulpin)) {
                    $chain_old_ulpin = "";
                }
            }
           
           
            $date_of_hearing = date('Y-m-d G:i:s');
            if ($status == 'final') {
            $next_date_of_hearing = date('Y-m-d G:i:s');
            } else {
                $next_date_of_hearing = date('Y-m-d', strtotime($this->input->post('next_hearing_date'))); // $this->input->post('next_hearing_date');
            }

            $co_order = $this->input->post('co_order');      
            if($co_order == '' || $co_order == null)
            {
               $co_order = ''; 
            }

            $proceeding_sql = "select max(proceeding_id)+1 as pid from  petition_proceeding 
            where case_no='$case_no' and $this->query";

            $append = "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and "
            . "vill_townprt_code='$vill_townprt_code'";
           
            $reissue_notice = $this->input->post('reissue_notice');
            $lm_petition_re = $this->input->post('lm_petition_re');
           
             //Peding for LM report/AST Notice/Continue hearing
            if ($status == 'pending')
            {
                $status='M';
                $task='CO';
                $pen = 'CO';
                $rmrk='Hearing continued by CO';
                $this->db->trans_begin();

                if ($lm_petition_re == 'y')
                {

                    $pen = 'LM';
                    $rmrk='Revert by CO to LM for fresh report';

                    $query = "update  petition_basic set lm_note_yn=null,lm_note_date=null,sk_comment=null where case_no='$case_no' and $append";
                    $this->db->query($query);
                    if ($this->db->affected_rows()<=0 )
                    {             
                         $this->db->trans_rollback();
                         log_message("error","#OM001 Could not update petition_basic with 
                            district: ".$dist_code.", case_no: ". $case_no);
                         $this->session->set_flashdata('message', "Could not revert to LM for fresh
                            report. Case No:".$case_no." Error Code(#OM001)");
                         redirect(base_url() . "index.php/home");
                         return;
                    }            
                }
                //revert to AST for regenerate notice
                 if ($reissue_notice == 'y')
                {
                    $pen = 'AST';
                    $rmrk='Revert by CO to AST for re-issue of notice';

                    $query = "update  petition_basic set notice_generated_yn=null,proceeding_yn=null,"
                     . "notice_served_yn=null,notice_generated_date=null where case_no='$case_no' and $append";
                     $this->db->query($query);
                    if ($this->db->affected_rows()<=0 )
                    {             
                        $this->db->trans_rollback();
                         log_message("error","#OM002 Could not update petition_basic for re notice with 
                             district: ".$dist_code.", case_no: ". $case_no);
                         $this->session->set_flashdata('message', "Could not revert to AST 
                             for notice. Case No:".$case_no." Error Code(#OM002)");
                         redirect(base_url() . "index.php/home");
                         return;
                    }            
                }

                $next_date_of_hearing = date('Y-m-d', strtotime($this->input->post('next_hearing_date')));
             
             
                $proceeding_id = $this->db->query($proceeding_sql)->row()->pid;
             
                if ($proceeding_id == null) {
                 $proceeding_id = 1;
                }
         
                $data = [
                     'case_no' => $case_no,
                     'proceeding_id' => $proceeding_id,
                     'date_of_hearing' => $date_of_hearing,
                     'co_order' => $co_order,
                     'next_date_of_hearing' => $next_date_of_hearing,
                     'status' => $status,
                     'user_code' => $user_code,
                     'date_entry' => $date_entry,
                     'dist_code' => $dist_code,
                     'cir_code' => $cir_code,
                     'subdiv_code' => $subdiv_code,
                     'operation' => 'E',
                     'date_entry' => date('Y-m-d G:i:s'),
                     'ip' => $this->utilityclass->get_client_ip()
                ];
                $tstatus1 = $this->db->insert("petition_proceeding", $data);
                if ($tstatus1 != 1 )
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Could not continue hearing for the case
                     ".$case_no." Error Code(#OM003)");
                    log_message("error","#OM003 Could not insert petition_proceeding with district: ".$dist_code.", case_no: ". $case_no);
                    redirect(base_url() . "index.php/home");
                    return;
                }

                $query = "update  petition_basic set proceeding_yn=null,next_date_of_hearing='$next_date_of_hearing' where case_no='$case_no' and $append";
                $this->db->query($query);
                if ($this->db->affected_rows()<=0 )
                {             
                    $this->db->trans_rollback();
                    log_message("error","#OM004 Could not update petition_basic with district: ".$dist_code.", case_no: ". $case_no);
                    $this->session->set_flashdata('message', "Could not continue hearing for the case
                     ".$case_no." Error Code(#OM004)");
                    redirect(base_url() . "index.php/home");
                    return;
                }
                $this->db->trans_commit();
            
                $this->DashboardData($case_no,$pen,$rmrk);           
            
                $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
                if($basundhara){                        
                    $this->basundharamodel->postApiBasundharaSec($case_no,$rmrk,$status,$task,$pen);
                }
     
                redirect(base_url() . "index.php/coofficemutation/getPendingMutationCases?id=2");
            }   
            else if ($status == 'final')
            {
                        //////////01-03-22////////////
                // redirect(base_url() . "index.php/coofficemutation/finalOrderPass?case_no=" . $case_no . "&dist_code=" . $dist_code . "&subdiv_code=" . $subdiv_code . "&cir_code=" . $cir_code . "&mouza_pargona_code=" . $mouza_pargona_code . "&lot_no=" . $lot_no . "&vill_townprt_code=" . $vill_townprt_code); 

                        //////////01-03-22////////////
                if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                {
                    redirect(base_url() . "index.php/coofficemutation/finalOrderPassMultiGen?case_no=" . $case_no . "&dist_code=" . $dist_code . "&subdiv_code=" . $subdiv_code . "&cir_code=" . $cir_code . "&mouza_pargona_code=" . $mouza_pargona_code . "&lot_no=" . $lot_no . "&vill_townprt_code=" . $vill_townprt_code . "&ulpin=" . $chain_ulpin . "&old_ulpin=" . $chain_old_ulpin . "&dag_revenue=" . $dag_revenue . "&dag_local_tax=" . $dag_local_tax . "&compareCheckFlag=" . $compareCheckFlag . "&ulpinCheckFlag=" . $ulpinCheckFlag); 
                }
                else
                {
                    redirect(base_url() . "index.php/coofficemutation/finalOrderPassMultiGen?case_no=" . $case_no . "&dist_code=" . $dist_code . "&subdiv_code=" . $subdiv_code . "&cir_code=" . $cir_code . "&mouza_pargona_code=" . $mouza_pargona_code . "&lot_no=" . $lot_no . "&vill_townprt_code=" . $vill_townprt_code); 
                }
            } 
             
        }
        else if ($this->input->server('REQUEST_METHOD') == 'GET')
        {
            $pb = $data['petition_basic'] = $this->db->query("select * from  petition_basic where case_no='$case_no' and $append")->row();
            $data['petitioner'] = $this->db->query("select * from    petitioner where $append and petition_no=$pb->petition_no")->result();

            
           $data['pattadar'] = $this->db->query("select * from    petition_pattadar where $append and petition_no=$pb->petition_no")->result();
                 //echo $this->db->last_query();
           $data['dag'] = $this->db->query("select * from    petition_dag_details where $append  and  petition_no=$pb->petition_no")->row();
                 ///////////////////////////
            if($pb->application_ref_no){
                $url = RTPS_LINK."mutation/mutation_attachment_details.php?application_ref_no=" . $pb->application_ref_no . "&applid=" . $pb->applid;
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
             ///////////////////////////
            $data['basuCase']=null;
            $data['tempNok']=$data['apps']=$data['sro']=$data['basundharaAttachment']=$data['query']=array();
            $data['basuCase']=$basundharaExist=$this->basundharamodel->checkExistBasundhar($pb->case_no);
            if($basundharaExist)
            {
                    $data['query']=null;
                    $data['basundharaAttachment']=$this->basundharamodel->searchBasundharaLink($pb->case_no);
                    $sql="Select * from nok_tmp where case_id='$case_no'";
                    $data['tempNok']=$this->db->query($sql)->result_array();
                    $data['sup_doc']=$this->mutationmodel->getDocument($case_no);
                    $data['query']=$this->basundharamodel->QueryPost($basundharaExist);
                    $data['sro']=$this->basundharamodel->SroPost($basundharaExist);
                    $data['apps']=array();
                    $url = API_LINK."serviceResponse?application_no=" . $basundharaExist ;
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
                    $output = curl_exec($ch);
                    curl_close($ch);
                    $output = json_decode($output);
                    if($output){
                     $data['apps']=$output->application;
                        }
            }

            //////////////////////////////////////////////////////////////// Property Chain Code //////////////////////////////////////////////
            if(ENABLED_BLOCKCHAIN == 1 &&  in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
            {

                $this->load->model('propChain/PropChainModel');
                // echo "<pre>";
                // var_dump($data['dag']);
                // die;

                $data['propChainEnableFlag'] = $this->PropChainCommonModel->isLocationEnable($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

                $landArea = $this->PropChainModel->getLandArea($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code, $lot_no, $vill_townprt_code,  $data['dag']->patta_no, $data['dag']->dag_no);

                $checkPropAndChithaAndUlpn = $this->PropChainModel->chainChithaUlpinCheckProcess($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code, $lot_no, $vill_townprt_code,  $data['dag']->patta_no, $data['dag']->dag_no, $landArea->dag_area_b, $landArea->dag_area_k, $landArea->dag_area_lc,  $landArea->dag_area_g, $data['dag']->patta_type_code);

                // echo "<pre>";
                // var_dump($data['dag']->dag_area_lc);

                // update flag in field_mut_basic only if ulpin found
                if ($checkPropAndChithaAndUlpn['ulpinCheck'] == 1 && ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'Y' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N' || $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'NE')) {
                    $this->PropChainModel->updateCmpFlag($case_no, $checkPropAndChithaAndUlpn['chithaPropChainCmpFlag']);

                    // if mismatch case get the view mismatch case button
                    if ($checkPropAndChithaAndUlpn['chithaPropChainCmpFlag'] == 'N')
                        $data['viewMisMatchBtn'] =  $this->PropChainModel->getMismatchBtn($case_no, $dist_code, $subdiv_code, $circle_code, $mouza_pargona_code, $lot_no, $vill_townprt_code,  $data['dag']->patta_no, $data['dag']->dag_no, $data['dag']->dag_area_b, $data['dag']->dag_area_k, $data['dag']->dag_area_lc,  $data['dag']->dag_area_g, $data['dag']->patta_type_code);
                }


                $data['ulpinCheck'] = $checkPropAndChithaAndUlpn['ulpinCheck'];
                $data['ulpinMsg'] = $checkPropAndChithaAndUlpn['ulpinMsg'];

                if ($data['ulpinCheck'] == 1) {
                    $data['ulpin'] = $checkPropAndChithaAndUlpn['ulpin'];
                    if (isset($data['old_ulpin']))
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
            $data['_view'] = 'officemutation/proceedingForMultigeneration';
            $this->load->view('layouts/main',$data);
        }         
    }

    // multi generation office case show in co login ==================

    public function finalOrderPassMultiGen() 
    {
        $case_no = $this->input->get('case_no');
        $append = $this->base_query;
      	$appenq = $this->query;
      	$dist_code = $this->session->userdata('dist_code');
      	$subdiv_code = $this->session->userdata('subdiv_code');
      	$cir_code = $this->session->userdata('cir_code');
      	$user_code = $this->session->userdata('user_code');
      	$year_no = year_no;

        // $proceeding_id = $this->db->query("SELECT max(proceeding_id) as last FROM petition_proceeding WHERE case_no=? and $appenq ", array($case_no))->row()->last;

        $data = $this->db->query("SELECT * FROM petition_basic pb JOIN petition_dag_details pd ON 
              pb.dist_code = pd.dist_code AND pb.subdiv_code = pd.subdiv_code AND 
              pb.cir_code = pd.cir_code AND pb.mouza_pargona_code = pd.mouza_pargona_code AND 
              pb.lot_no = pd.lot_no AND pb.petition_no = pd.petition_no AND 
              pb.vill_townprt_code = pd.vill_townprt_code WHERE pb.case_no=? AND pb.dist_code=? AND 
              pb.subdiv_code=? AND pb.cir_code=?", array($case_no, $dist_code, $subdiv_code, $cir_code))->row();
        $details['data'] = $data;


        $dagDetails = $this->db->query("SELECT * FROM petition_basic pb JOIN petition_dag_details pd ON 
              pb.dist_code = pd.dist_code AND pb.subdiv_code = pd.subdiv_code AND 
              pb.cir_code = pd.cir_code AND pb.mouza_pargona_code = pd.mouza_pargona_code AND 
              pb.lot_no = pd.lot_no AND pb.petition_no = pd.petition_no AND 
              pb.vill_townprt_code = pd.vill_townprt_code WHERE pb.case_no=? AND pb.dist_code=? AND 
              pb.subdiv_code=? AND pb.cir_code=?", array($case_no, $dist_code, $subdiv_code, $cir_code))->result();
        $details['dag'] = $dagDetails;


        $dagPattaNoList = $this->db->query("SELECT string_agg(dag_no, ',') as dag_no,string_agg(patta_no, ',') as patta_no FROM petition_dag_details pd WHERE petition_no = ? ", array($data->petition_no))->row();
        $details['dagPattaNoList'] = $dagPattaNoList;


        //$details['proceeding_id'] = $proceeding_id;
        $q = "select lm_code,lm_sign_yn,sk_sign_yn,sk_note_date,lm_sign_date from    petition_lm_note where $appenq   and "
          . "petition_no=$data->petition_no";

        $dates = $this->db->query("SELECT lm_code, lm_sign_yn, sk_sign_yn, sk_note_date, lm_sign_date, user_code, lm_code FROM petition_lm_note WHERE $appenq AND 
              petition_no = ?", array($data->petition_no))->row();


        if(ESCALATION_ENABLE == 1 && $data->es_flag == 1)
          {
            $details['sk_note_date'] = null;
            $details['sk_sign_yn'] = null;
            $details['user_code'] = null;
          }
          
          $details['lm_note_date'] = $dates->lm_sign_date;
          $details['lm_sign_yn'] = $dates->lm_sign_yn;
            $details['sk_sign_yn'] = $data->sk_comment; //$dates->sk_sign_yn;
              $details['lm_code'] = $dates->lm_code;
              $details['case_no'] = $case_no;
              $details['user_code'] = $dates->user_code;

      	//////////////////////////////////////////////////////////////////////////////
      	$petition_no_q = "SELECT petition_no, trans_code, deed_no, deed_value, sub_reg_office,
      							submission_date, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no,
      								vill_townprt_code FROM petition_basic WHERE case_no=? and $append ";
      	$petition_no = $this->db->query($petition_no_q, array($case_no))->row()->petition_no;
      	$trans_code = $this->db->query($petition_no_q, array($case_no))->row()->trans_code;
      	$deed_no = $this->db->query($petition_no_q, array($case_no))->row()->deed_no;
      	$deed_value = $this->db->query($petition_no_q, array($case_no))->row()->deed_value;
      	$sub_reg_office = $this->db->query($petition_no_q, array($case_no))->row()->sub_reg_office;
      	$submission_date = $this->db->query($petition_no_q, array($case_no))->row()->submission_date;
      	$dist_code = $this->db->query($petition_no_q, array($case_no))->row()->dist_code;
      	$subdiv_code = $this->db->query($petition_no_q, array($case_no))->row()->subdiv_code;
      	$cir_code = $this->db->query($petition_no_q, array($case_no))->row()->cir_code;
      	$mouza_pargona_code = $this->db->query($petition_no_q, array($case_no))->row()->mouza_pargona_code;
      	$lot_no = $this->db->query($petition_no_q, array($case_no))->row()->lot_no;
      	$vill_townprt_code = $this->db->query($petition_no_q, array($case_no))->row()->vill_townprt_code;
      	$year_no = year_no;
      	$append = "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and "
            . "vill_townprt_code='$vill_townprt_code'";
      
      	$details['trans_code'] = $trans_code;
      	$details['deed_no'] = $deed_no;
      	$details['deed_value'] = $deed_value;
      	$details['sub_reg_office'] = $sub_reg_office;
      	$details['submission_date'] = $submission_date;
      	//$details['land'] = $land;

      	$applicants = "SELECT * FROM petitioner WHERE petition_no=? AND $append order by pet_id";
      	$details['applicants']=$details['petitioner'] = $this->db->query($applicants, array($petition_no))->result();

      	$details['relation'] = $this->db->query("SELECT * FROM master_guard_rel")->result();
      	$details['genders'] = $this->db->query("SELECT * FROM master_gender")->result();
      	$details["pdars"] = $this->db->query("select * from  chitha_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' 
          and p.cir_code='$cir_code' and p.mouza_pargona_code='$mouza_pargona_code' and"
          . " p.vill_townprt_code='$vill_townprt_code' and p.lot_no='$lot_no'
          and TRIM(p.patta_no)='$data->patta_no' and p.patta_type_code='$data->patta_type_code' and p.pdar_id in(
          select pdar_id from  chitha_dag_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' 
          and p.cir_code='$cir_code' 
          and p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
          . "and p.lot_no='$lot_no' and TRIM(p.patta_no)='$data->patta_no' 
          and p.patta_type_code='$data->patta_type_code' and p_flag!='1')")->result();

      	$pattadars = "SELECT * FROM petition_pattadar WHERE petition_no=? and $append";
      	$details['pattadars'] = $this->db->query($pattadars, array($petition_no))->result();

        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
            // property chain data
            $details['ulpin'] = $this->input->get('ulpin', true);
            $details['old_ulpin'] = $this->input->get('old_ulpin', true);
            $details['revenue'] = $this->input->get('dag_revenue', true);
            $details['local_tax'] = $this->input->get('dag_local_tax', true);
            $details['ulpinCheckFlag'] = $this->input->get('ulpinCheckFlag', true);
            $details['compareCheckFlag'] = $this->input->get('compareCheckFlag', true);

        }

        //ESCALATED CASES REMARK ENTRY FORM==============
        if(ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE == 1 && $data->es_flag == 1)
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
      	$details['_view'] = 'officemutation/finalOrderPassCOMultiGen';
      	$this->load->view('layouts/main',$details);

    }

    // Added by Abhijit -- 2024-04-29 [Multi dag office case show in CO login]
    public function finalOrderPassMultiDag() 
    {
        $case_no = $this->input->get('case_no');
        $append = $this->base_query;
        $appenq = $this->query;
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;

        $pb = $this->db->query("select * from  petition_basic where case_no='$case_no'")->row();
        if(!$pb){
            $this->session->set_flashdata('message',"No such case found.");
            return redirect('/home');
        }
        
        if($pb->is_multidag != 'Y'){
            $this->session->set_flashdata('message',"This service is inactive for now.");
            return redirect('/home');
        }

            // $proceeding_id = $this->db->query("SELECT max(proceeding_id) as last FROM petition_proceeding WHERE case_no=? and $appenq ", array($case_no))->row()->last;

        $data = $this->db->query("SELECT * FROM petition_basic pb JOIN petition_dag_details pd ON 
            pb.dist_code = pd.dist_code AND pb.subdiv_code = pd.subdiv_code AND 
            pb.cir_code = pd.cir_code AND pb.mouza_pargona_code = pd.mouza_pargona_code AND 
            pb.lot_no = pd.lot_no AND pb.petition_no = pd.petition_no AND 
            pb.vill_townprt_code = pd.vill_townprt_code WHERE pb.case_no=? AND pb.dist_code=? AND 
            pb.subdiv_code=? AND pb.cir_code=?", array($case_no, $dist_code, $subdiv_code, $cir_code))->row();
        $details['data'] = $data;

        $dagDetails = $this->db->query("SELECT * FROM petition_basic pb JOIN petition_dag_details pd ON 
        pb.dist_code = pd.dist_code AND pb.subdiv_code = pd.subdiv_code AND 
        pb.cir_code = pd.cir_code AND pb.mouza_pargona_code = pd.mouza_pargona_code AND 
        pb.lot_no = pd.lot_no AND pb.petition_no = pd.petition_no AND 
        pb.vill_townprt_code = pd.vill_townprt_code WHERE pb.case_no=? AND pb.dist_code=? AND 
        pb.subdiv_code=? AND pb.cir_code=?", array($case_no, $dist_code, $subdiv_code, $cir_code))->result();

        $details['dag'] = $dagDetails;

        $dagPattaNoList = $this->db->query("SELECT string_agg(dag_no, ',') as dag_no,string_agg(patta_no, ',') as patta_no FROM petition_dag_details pd WHERE petition_no = ? ", array($data->petition_no))->row();
        $details['dagPattaNoList'] = $dagPattaNoList;

            //$details['proceeding_id'] = $proceeding_id;
        $q = "select lm_code,lm_sign_yn,sk_sign_yn,sk_note_date,lm_sign_date from    petition_lm_note where $appenq   and "
        . "petition_no=$data->petition_no";

        $dates = $this->db->query("SELECT lm_code, lm_sign_yn, sk_sign_yn, sk_note_date, lm_sign_date, user_code, lm_code FROM petition_lm_note WHERE $appenq AND 
            petition_no = ?", array($data->petition_no))->row();

        $details['sk_note_date'] = $dates->sk_note_date;
        $details['lm_note_date'] = $dates->lm_sign_date;
        $details['lm_sign_yn'] = $dates->lm_sign_yn;
        $details['sk_sign_yn'] = $data->sk_comment; //$dates->sk_sign_yn;
        $details['lm_code'] = $dates->lm_code;
        $details['case_no'] = $case_no;
        $details['user_code'] = $dates->user_code;

        //////////////////////////////////////////////////////////////////////////////
        $petition_no_q = "SELECT petition_no, trans_code, deed_no, deed_value, sub_reg_office,
        submission_date, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no,
        vill_townprt_code FROM petition_basic WHERE case_no=? and $append ";

        $petition_no = $this->db->query($petition_no_q, array($case_no))->row()->petition_no;
        $trans_code = $this->db->query($petition_no_q, array($case_no))->row()->trans_code;
        $deed_no = $this->db->query($petition_no_q, array($case_no))->row()->deed_no;
        $deed_value = $this->db->query($petition_no_q, array($case_no))->row()->deed_value;
        $sub_reg_office = $this->db->query($petition_no_q, array($case_no))->row()->sub_reg_office;
        $submission_date = $this->db->query($petition_no_q, array($case_no))->row()->submission_date;
        $dist_code = $this->db->query($petition_no_q, array($case_no))->row()->dist_code;
        $subdiv_code = $this->db->query($petition_no_q, array($case_no))->row()->subdiv_code;
        $cir_code = $this->db->query($petition_no_q, array($case_no))->row()->cir_code;
        $mouza_pargona_code = $this->db->query($petition_no_q, array($case_no))->row()->mouza_pargona_code;
        $lot_no = $this->db->query($petition_no_q, array($case_no))->row()->lot_no;
        $vill_townprt_code = $this->db->query($petition_no_q, array($case_no))->row()->vill_townprt_code;
        $year_no = year_no;
        $append = "dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and "
            . "vill_townprt_code='$vill_townprt_code'";
        
        $details['trans_code'] = $trans_code;
        $details['deed_no'] = $deed_no;
        $details['deed_value'] = $deed_value;
        $details['sub_reg_office'] = $sub_reg_office;
        $details['submission_date'] = $submission_date;
        //$details['land'] = $land;

        $applicants = "SELECT * FROM petitioner WHERE petition_no=? AND $append order by pet_id";
        $details['applicants']=$details['petitioner'] = $this->db->query($applicants, array($petition_no))->result();

        $details['relation'] = $this->db->query("SELECT * FROM master_guard_rel")->result();
        $details['genders'] = $this->db->query("SELECT * FROM master_gender")->result();
        $details["pdars"] = $this->db->query("select * from  chitha_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' 
            and p.cir_code='$cir_code' and p.mouza_pargona_code='$mouza_pargona_code' and"
            . " p.vill_townprt_code='$vill_townprt_code' and p.lot_no='$lot_no'
            and TRIM(p.patta_no)='$data->patta_no' and p.patta_type_code='$data->patta_type_code' and p.pdar_id in(
            select pdar_id from  chitha_dag_pattadar p where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' 
            and p.cir_code='$cir_code' 
            and p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_townprt_code' "
            . "and p.lot_no='$lot_no' and TRIM(p.patta_no)='$data->patta_no' 
            and p.patta_type_code='$data->patta_type_code' and p_flag!='1')")->result();

        $pattadars = "SELECT * FROM petition_pattadar WHERE petition_no=? and $append";
        $details['pattadars'] = $this->db->query($pattadars, array($petition_no))->result();

        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
            // property chain data
            $details['ulpin'] = $this->input->get('ulpin', true);
            $details['old_ulpin'] = $this->input->get('old_ulpin', true);
            $details['revenue'] = $this->input->get('dag_revenue', true);
            $details['local_tax'] = $this->input->get('dag_local_tax', true);
            $details['ulpinCheckFlag'] = $this->input->get('ulpinCheckFlag', true);
            $details['compareCheckFlag'] = $this->input->get('compareCheckFlag', true);

        }
        

        $details['_view'] = 'officemutation/finalOrderPassCOMultiDag';
        $this->load->view('layouts/main',$details);

    }

    //multi generation office case pass by circle==================
    public function finalOrderOfcMutationPassCOMultiGen()
    {
        //xss & security validation starts
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST,array(),array(),array('co_order' => true));
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }
        $resp = checkRequestValidQuery($_POST,array(),array('co_order' => true));
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }    
        if($errorMessageStr != ''){
            $validation=array(
                'error' => $errorMessageStr
            );
            $validation['attachment'] = 'audit';                  
            echo json_encode($validation);
            return;
        }
        //xss & security validation ends 
    	
      	if ($this->input->server('REQUEST_METHOD') == 'POST') 
      	{
	        $this->db->trans_begin();
	        $year_no = year_no;
	        $value = $this->input->post();
	        $mutatedBigha = $this->input->post('mut_b');
	        $mutatedKatha = $this->input->post('mut_k');
	        $mutatedLessa = $this->input->post('mut_lc');
	        $mutatedGanda = $this->input->post('mut_g');
	        $mutatedKranti = $this->input->post('mut_kr');
	        $case_no = $this->input->post('case_no');
	        $dag_no = $this->input->post('dag_no');
	        $dist_code = $this->input->post('dist_code');
	        $subdiv_code = $this->input->post('subdiv_code');
	        $cir_code = $this->input->post('cir_code');
	        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
	        $lot_no = $this->input->post('lot_no');
	        $vill_townprt_code = $this->input->post('vill_townprt_code');
	        $date = date('Y-m-d');

            // $deed_no = $this->input->post('deed_no');
            // $is_valid_deed_no = isValidDeedNo($deed_no);
            // if(!$is_valid_deed_no['success']){
            //     $data=array(
            //         'error'=> $is_valid_deed_no['message'],
            //         'attachment' => 'audit'
            //     );
            //     echo json_encode($data);
            //     return false;
            // }
	        //////////////////////////////////
	        if(isset($_FILES['fileUpload']['name']))
	        {
	            $this->form_validation->set_rules('fileText[]', 'Document Details', 'trim|xss_clean|required');
	            $fileCount = count($_FILES['fileUpload']['name']);
	            // validation for file type and file size
	            for($i = 0; $i < $fileCount; $i++)
	            {
	                if($_FILES['fileUpload']['name'][$i] && $_FILES['fileUpload']['size'][$i] && $_FILES['fileUpload']['tmp_name'][$i])
	                {
	                    $name = $_FILES['fileUpload']['name'][$i];
	                    $size = $_FILES['fileUpload']['size'][$i];
	                    $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
	                    $exp  = explode("/",$mime);
	                    $ext  = $exp[1];
	                        if($name != NULL)
	                        {
	                            if($ext == NULL)
	                            {

	                                $this->db->trans_rollback();
	                                $validation['attachment'] = '1001';                  
	                                echo json_encode($validation);
	                                return;
	                            }
	                            if(! in_array($ext, UPLOAD_TYPE_VALIDATION))
	                            {
	                                $this->db->trans_rollback();
	                                $validation['attachment'] = '1001';                  
	                                echo json_encode($validation);
	                                return;
	                            }
	                            if($size > UPLOAD_MAX_SIZE)
	                            {
	                                $this->db->trans_rollback();
	                                $validation['attachment'] = '1001';                  
	                                echo json_encode($validation);
	                                return;
	                            }
	                        }
	                        else
	                        {
	                            $this->db->trans_rollback();
	                            $validation['attachment'] = '1001';                  
	                            echo json_encode($validation);
	                            return;
	                        }
	                }
                    else{
                        $this->db->trans_rollback();
                        $validation['attachment'] = '1001';                  
                        echo json_encode($validation);
                        return;
                    }
	            }
	        }
            ///////////////////Insert attached file////////////////////////
            if(isset($_FILES['fileUpload']['name']))
            {
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
                            'mut_type'   => 'OM',
                        );
                        // save data in attachment file
                        $addMoreDocQuery = $this->db->insert('supportive_document',$document);
                        if($addMoreDocQuery != 1)
                        {
                            $this->db->trans_rollback();
                            $validation['attachment'] = '1001';                  
                            echo json_encode($validation);
                            return;
                        }
                    }
                    else
                    {
                        $this->db->trans_rollback();
                        $validation['attachment'] = '1001';                  
                        echo json_encode($validation);
                        return;
                    }
                }
            }
            //////////////////////////////////////////
	        $appendq = $this->query;

	        $append = "dist_code='$dist_code' AND subdiv_code='$subdiv_code' AND 
	        cir_code='$cir_code' AND mouza_pargona_code='$mouza_pargona_code' AND 
	        lot_no='$lot_no' AND vill_townprt_code='$vill_townprt_code'";

	        $proceeding_idd = $this->db->query("SELECT max(proceeding_id)+1 AS pid FROM
	           petition_proceeding WHERE case_no=? AND $this->query", array($case_no));
	        //log_message('error',$this->db->last_query());
	        if ($proceeding_idd->num_rows()==0){
	            $proceeding_id=1;
	        }else
	        { 
	        	$proceeding_id=$proceeding_idd->row()->pid; 
	        }
	        //get detail from petition_basic



            $deed_no = $this->input->post('deed_no');
            $sql="select trans_code from nature_trans_code where trans_type='o'";
            $trans_code_array=$this->db->query($sql)->result_array();
            if($pet_basic->mut_type=='03' && in_array($pet_basic->trans_code, $trans_code_array))
            {
                
                $is_valid_deed_no = isValidDeedNo($deed_no);
                if(!$is_valid_deed_no['success'])
                {
                    $data=array(
                        'error'=> $is_valid_deed_no['message'],
                        'attachment' => 'audit'
                    );
                    echo json_encode($data);
                    return false;
                }
            }


	        $pet_basic = $this->db->query("SELECT * FROM petition_basic WHERE case_no=? and $append", array($case_no))->row();
	        $petition_no = $pet_basic->petition_no;

            //ESCALATION ==============
            if(ESCALATION_ENABLE == 1 && $pet_basic->es_flag == 1 && ESCALATION_REMARK_ENABLE ==1)
            {

                $responseEsc = $this->Escalationmodel->escalationRemarkCheckandUpdate($case_no,$this->input->post('esc_remark'),$this->session->userdata('user_desig_code'));
                if($responseEsc['responseType'] == 1)
                {
                    $this->db->trans_rollback();
                    $data=array(
                        'error'=>"#ERROMUTESCREMARK7771 : Error in submitting in escalation remarks. Please try Again"
                    );
                    echo json_encode($data);
                    return false;
                }

            }
            ///END+==================



	        //==========check dag pending in blockchain or not=================
	        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
	        {
	            $this->load->model('propChain/PropChainCommonModel');
	            $query = "SELECT * FROM petition_dag_details  WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND  vill_townprt_code=? AND petition_no=?";
	              $dagList = $this->db->query($query, array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $petition_no))->result();
	            foreach ($dagList as $key => $dagCheck)
	            {

	                $checkVal = $this->PropChainCommonModel->checkDagExistsInPropChainInPending($dagCheck->dist_code,$dagCheck->subdiv_code,$dagCheck->cir_code,$dagCheck->mouza_pargona_code,$dagCheck->lot_no,$dagCheck->vill_townprt_code,$dagCheck->dag_no);
	                if($checkVal === false)
	                {
	                    $this->db->trans_rollback();
	                    $this->session->set_flashdata('message', "#ERRORBLOCCHAIN4143 : You cannot procced as dag no is pending for property chain update...");
	                    redirect(base_url() . "index.php/home");
	                }
	            }
        	}
	        ///=============end CODE=====================

	            //get detail from petitioner & petition_dag_details

	        $petitioner = $this->db->query("SELECT * FROM petitioner WHERE petition_no=? AND $append order by pet_id desc ", array($petition_no));

	        if ($petitioner == null || $petitioner->num_rows()<=0)
	        {
	            log_message("error"," #OMPET001 could not find petitioner 
	                district: ".$dist_code.", petition_no: ". $petition_no);
	                $validation['petitioner_nok'] = '109'; // insertion failed in infavour t_chitha
	                $this->db->trans_rollback();
	                echo json_encode($validation);
	                return;
            } 
            $petitioner = $petitioner->row();

             // /var_dump($petitioner);
            $noktmp = $this->db->query("SELECT * FROM nok_tmp WHERE case_id=? AND approve_reject=?", array($case_no, 1))->result();
            if($noktmp)
            {
                $i=1;                    
                foreach($noktmp as $nok)
                {
	                 $basic = clone $petitioner;
	                 $basic->pet_id = ($petitioner->pet_id)+$i;
	                 $basic->pet_name = $nok->name_asm;
	                 $basic->pet_name = $nok->name_asm;
	                 $basic->guard_name = $nok->guardian_name_asm;
	                 $basic->guard_rel = $nok->relation;
	                 $basic->pet_gender = $nok->gender;
	                 $basic->add1 = $nok->address;
	                 $basic->pet_minor_dob = $nok->dob;
	                 $basic->new_pattadar='N';
	                 unset($basic->id);
	                 $ins_pet = $this->db->insert("petitioner", $basic);
	                 $i++;

	                if ($ins_pet != 1 )
	                {
	                  $this->db->trans_rollback();
	                  log_message("error"," #OMNOK001 could not insert nok to petitioner 
	                    district: ".$dist_code.", petition_no: ". $petition_no);
	                  $validation['petitioner_nok'] = '109';                  
	                  echo json_encode($validation);
	                  return;
	              	}
	              
	              	$update="Update nok_tmp set approve_reject=2 where case_id='$case_no' and serial_id=$nok->serial_id ";
	              	$this->db->query($update);
	              	if ($this->db->affected_rows()<=0)
	              	{
	                  	$this->db->trans_rollback();
	                  	log_message("error"," #OMNOK002 could not update nok approve_reject district: ".$dist_code.", petition_no: ". $petition_no);
	                  	$validation['petitioner_nok'] = '109';                  
	                  	echo json_encode($validation);
	                  	return;
	              	}
          		}            
      		}
            //////////////////////////
		    $query = "SELECT * FROM petitioner pb JOIN petition_dag_details pd ON 
		     	pb.dist_code = pd.dist_code AND pb.subdiv_code = pd.subdiv_code AND 
		      pb.cir_code = pd.cir_code AND pb.mouza_pargona_code = pd.mouza_pargona_code AND 
		      pb.lot_no = pd.lot_no AND pb.vill_townprt_code = pd.vill_townprt_code and pb.petition_no=pd.petition_no and pb.year_no=pd.year_no WHERE 
		      pb.dist_code=? AND pb.subdiv_code=? AND pb.cir_code=?
		      AND pb.mouza_pargona_code=? AND pb.lot_no=? AND 
		      pb.vill_townprt_code=? AND pb.petition_no=?  order by pb.pet_id asc";
		    $datas = $this->db->query($query, array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $petition_no))->result();
		    log_message('error','6730------------'.json_encode($this->db->last_query()));

		            //get detail from petition_pattadar
		    // $query = "SELECT * FROM petition_pattadar WHERE petition_no=? AND $append";
		    // $pet_pattadar = $this->db->query($query, array($petition_no));
		    // if ($pet_pattadar == null || $pet_pattadar->num_rows()<=0)
		    // {
		    //     $this->db->trans_rollback();
		    //     log_message("error"," #OMPPT001 could not get petition_pattadar  
		    //       district: ".$dist_code.", petition_no: ". $petition_no);
		    //     $validation['petitioner_nok'] = '109';                  
		    //     echo json_encode($validation);
		    //     return;
		    // }
		    // $pet_pattadar = $pet_pattadar->result();
		    $locationData = [
		       'dist_code' => $dist_code,
		       'subdiv_code' => $subdiv_code,
		       'cir_code' => $cir_code,
		       'lot_no' => $lot_no,
		       'vill_townprt_code' => $vill_townprt_code,
		       'mouza_pargona_code' => $mouza_pargona_code,
		       // 'dag_no' => $dag_no,
		       'year_no' => date('Y'),
		       'petition_no' => $petition_no,
		    ];

		    $data = [
		        'case_no' => $case_no,
		        'proceeding_id' => $proceeding_id,
		        'date_of_hearing' => date('Y-m-d h:i:s'),
		        'co_order' => addslashes($this->input->post('co_order')),
		        'next_date_of_hearing' => date('Y-m-d h:i:s'),
		        'status' => 'final',
		        'user_code' => $this->user_code,
		        'dist_code' => $dist_code,
		        'cir_code' => $cir_code,
		        'subdiv_code' => $subdiv_code,
		        'operation' => 'E',
		        'date_entry' => date('Y-m-d G:i:s'),
		        'ip' => $this->utilityclass->get_client_ip()
		    ];
		    $pet_proceed = $this->db->insert('petition_proceeding', $data);
		    if($pet_proceed != 1){
		        $this->db->trans_rollback();
		        $validation['pet_proceed'] = '108';            
		        log_message("error"," #OMPP001 could not insert petition_proceeding  
		            district: ".$dist_code.", petition_no: ". $petition_no);
		        echo json_encode($validation);            
		        return;
		    }
            ////////////////////////////
		    if($value['deed_no']=='' || $value['deed_no']==null){$value['deed_no']='';}
		    if($value['deed_value']=='' || $value['deed_value']==null){$value['deed_value']='';}
		    if($value['deed_date']=='' || $value['deed_date']==null){$value['deed_date']='';}

		            //updation of deed details
		    $deedDetail = [
		        'deed_no' => $value['deed_no'],
		        'deed_value' => $value['deed_value'],
		        'deed_date' => date('Y-m-d', strtotime($value['deed_date'])),
		    ];
		    $this->db->where('case_no', $case_no);
		    $this->db->update('petition_basic', $deedDetail);
		    if($this->db->affected_rows() != 1){
		        $this->db->trans_rollback();
		        $validation['deed_updation'] = '101';
		        log_message("error"," #OMPB001 could not insert petition_proceeding  
		            district: ".$dist_code.", petition_no: ". $petition_no);            
		        echo json_encode($validation);
		        return;
		    }


		    $query = "SELECT * FROM petition_dag_details WHERE petition_no=? AND $append";
		    $petDagDetails = $this->db->query($query, array($petition_no));
		    if ($petDagDetails == null || $petDagDetails->num_rows()<=0)
		    {
		        $this->db->trans_rollback();
		        log_message("error"," #OMPPT6802 could not get Petition Dag Details  
		          district: ".$dist_code.", petition_no: ". $petition_no);
		        $validation['petitioner_nok'] = '101';                  
		        echo json_encode($validation);
		        return;
		    }
		    $postDagNo = $this->input->post('dag_no'); 
		    for ($i=0; $i < count($mutatedBigha) ; $i++) { 
		    	if($mutatedBigha[$i]=='' || $mutatedBigha[$i]==null){$mutatedBigha[$i]='0';}
			    if($mutatedKatha[$i]=='' || $mutatedKatha[$i] ==null){$mutatedKatha[$i]='0';}
			    if($mutatedLessa[$i] =='' || $mutatedLessa[$i] ==null){$mutatedLessa[$i] ='0';}
			    if($mutatedGanda[$i] =='' || $mutatedGanda[$i] ==null){$mutatedGanda[$i] ='0';}
			    if($mutatedKranti[$i] =='' || $mutatedKranti[$i] ==null){$mutatedKranti[$i] ='0';}
			    $mut_land = "UPDATE petition_dag_details SET 
							    m_dag_area_b='".$mutatedBigha[$i]."',
							    m_dag_area_k='".$mutatedKatha[$i]."',
							    m_dag_area_lc='".$mutatedLessa[$i]."',
							    m_dag_area_g='".$mutatedGanda[$i]."',
							    m_dag_area_kr='".$mutatedKranti[$i]."'
							    WHERE $append AND petition_no=? and dag_no = ? ";
	   			$this->db->query($mut_land, array($petition_no,$postDagNo[$i]));
	    		if($this->db->affected_rows() != 1)
	    		{
	        		$this->db->trans_rollback();
	                $validation['land_updation'] = '102'; // mutated land updation failed            
	                log_message("error"," #OMPDD001 could not update land details  
	                    district: ".$dist_code.", petition_no: ". $petition_no);            
	                echo json_encode($validation);
	                return;
	            }
		    }
            //updation of mutated land
		    $query = "SELECT * FROM petition_pattadar WHERE petition_no=? AND $append";
            $pet_pattadar = $this->db->query($query, array($petition_no));
            if ($pet_pattadar == null || $pet_pattadar->num_rows()<=0)
            {
                $this->db->trans_rollback();
                log_message("error"," #OMPPT001 could not get petition_pattadar  
                  district: ".$dist_code.", petition_no: ". $petition_no);
                $validation['petitioner_nok'] = '109';                  
                echo json_encode($validation);
                return;
            }
            $pet_pattadar = $pet_pattadar->result();

            //insertion in t_chitha_rmk_infavor_of
            foreach($datas as $data)
            {
                


                $dec= null;
                if(isset($data->self_declaration) && $data->self_declaration !=null)
                {
                    $dec       = $data->self_declaration;
                }
                if(isset($data->auth_type) && $data->auth_type != null)
                {
                    if($data->auth_type=='AADHAAR' && $data->photo == null)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRFMUTI005:Aadhaar Photo fetching error');
                        redirect(base_url() . "index.php/home");
                    }
                    $auth_type = $data->auth_type;
                    $id_ref_no = $data->id_ref_no;
                    // $photo     = $data->photo;
                    $photo     = null;
                }
                else
                {
                    $auth_type = null;
                    $id_ref_no = null;
                    $photo = null;
                }
                $strikeForce=0;
                //for multigeneration only
                if(MULTIGENERATION_ACTIVE == 1 && ($pet_basic->is_multigeneration == 'S' || $pet_basic->is_multigeneration == 'M'))
                {
                    
                    //checking for GP and P as there have NOK or not-----
                    // if found then striking out otherwise not----------
                    if($data->generation_type == 'GP' || $data->generation_type=='P'){
                    $sqlStrikeForce="Select * from petitioner where petition_no = '$petition_no' and next_of_pdar_id='$data->pdar_id'";
                        if ($this->db->query($sqlStrikeForce)->num_rows()==0)
                        {
                            $strikeForce = 0;
                        }else{
                            $strikeForce = 1;
                        }
                    }
                }



                $t_chitha_rmk_infavor_of = [
                    'patta_type_code' => $data->patta_type_code,
                    'patta_no' => $data->patta_no,
                    'ord_no' => $case_no,
                    'ord_date' => date('Y-m-d G:i:s'),
                    'infavor_of_id' => $data->pet_id,
                    'infavor_of_name' => $data->pet_name,
                    'infavor_of_guardian' => $data->guard_name,
                    'infav_of_guar_relation' => $data->guard_rel,
                    'infavor_of_add1' => $data->add1,
                    'infavor_of_add2' => $data->add2,
                    'by_right_of' => $value['by_right_of'],
                    'land_area_b' => $data->m_dag_area_b,
                    'land_area_k' => $data->m_dag_area_k,
                    'land_area_lc' => $data->m_dag_area_lc,
                    'land_area_g' => 0,
                    'land_area_kr' => 0,
                    'revenue' => 0,
                    'reg_deal_no' => $value['deed_no'],
                    'reg_date' => date('Y-m-d', strtotime($value['deed_date'])),
                    'infavor_of_gender' => $data->pet_gender,
                    'infavor_of_minor_yn' => $data->pet_minor_yn,
                    'infavor_of_minor_dob' => $data->pet_minor_dob,
                    'infavor_of_mother' => $data->pet_mother,
                    'new_pattadar'     =>$data->new_pattadar,
                    'self_declaration' => $dec,
                    'auth_type'        => $auth_type,
                    'id_ref_no'        => $id_ref_no,
                    'photo'            => $photo,
                    'pdar_name_eng'    => $data->pdar_name_eng,
                    'pdar_guard_eng'   => $data->pdar_guard_eng,
                    'dag_no'           => $data->dag_no,

                ];
                // unset($locationData['dag_no']);
                //multigeneration-----------
                if(MULTIGENERATION_ACTIVE == 1 && ($pet_basic->is_multigeneration == 'S' || $pet_basic->is_multigeneration == 'M'))
                {
                    $t_chitha_rmk_infavor_of['pdar_strike']     = $strikeForce;
                    $t_chitha_rmk_infavor_of['generation_type'] = $data->generation_type;
                    $t_chitha_rmk_infavor_of['rel_pdar_id']     = $data->pdar_id;
                    $t_chitha_rmk_infavor_of['next_of_pdar_id']     = $data->next_of_pdar_id;
                }
                //end-===---

                $tchitha_infavorof = array_merge($t_chitha_rmk_infavor_of, $locationData);

                $ins_tchitha_infavour = $this->db->insert("t_chitha_rmk_infavor_of", $tchitha_infavorof);
                 // log_message('error','---------25'.json_encode($this->db->last_query()));
                if($ins_tchitha_infavour != 1)
                {
                   $validation['t_chitha_infavor'] = '103'; // insertion failed in infavour t_chitha
                   $this->db->trans_rollback();
                   log_message("error"," #OMTCRMI001 could not insert t_chitha_rmk_infavour_of 
                    district: ".$dist_code.", petition_no: ". $petition_no);            
                   echo json_encode($validation);
                   return;
               	}



           	}
           
           
            //insertion in inplace & alongwith
            foreach($pet_pattadar as $inall) 
            {
                $inplace_alongwith = $inall->striked_out;
                $table = (($inplace_alongwith==1)?'t_chitha_rmk_inplace_of':'t_chitha_rmk_alongwith');

                if($inplace_alongwith == 1) //insertion in inplace chitha
                {
                    $insertInplaceAlong = [
                        'ord_no' => $case_no,
                        'ord_date' => $date,
                        'inplace_of_id' => $inall->pdar_id,
                        'pdar_id' => $inall->pdar_id,
                        'inplace_of_name' => $inall->pdar_name,
                        'inplace_of_guardian' => $inall->pdar_guardian,
                        'inplace_of_relation' => $inall->pdar_rel_guar,
                        'strike_out' => '1',
                        'dag_no' => $inall->dag_no,
                    ];
                }
                else if($inplace_alongwith == 0 || $inplace_alongwith == '') //insertion in alongwith chitha
                {
                    $insertInplaceAlong = [
                        'ord_no' => $case_no,
                        'ord_date' => $date,
                        'alongwith_id' => $inall->pdar_id,
                        'alongwith_name' => $inall->pdar_name,
                        'alongwith_guardian' => $inall->pdar_guardian,
                        'alongwith_rel_gur' => $inall->pdar_rel_guar,
                        'pdar_id' => $inall->pdar_id,
                        'dag_no' => $inall->dag_no,
                    ];
                }
                // unset($locationData['dag_no']);
                $tchitha_inplaceof_tmp = array_merge($insertInplaceAlong, $locationData);
                $ins_inplace = $this->db->insert($table, $tchitha_inplaceof_tmp);
               // echo $this->db->last_query();
                // log_message('error','104Q--'.$this->db->last_query());
               // echo "----------------<br>";
                if($ins_inplace != 1){
                   $validation['inplace'] = '104'; // insertion failed in inplace chitha
                   $this->db->trans_rollback();
                   log_message("error"," #OMTCIA001 could not insert ".$table
                    ."district: ".$dist_code.", petition_no: ". $petition_no);            
                   echo json_encode($validation);
                   return;
               }
               
            } //end of foreach //insertion in inplace & alongwith
            
            
            //***************************************//

            // if ($pet_basic->deed_no != 0 or $pet_basic->deed_no != null) {
            //     $update = "UPDATE sro_note SET status='3' WHERE deed_no=?";
            //     $update_sro = $this->db->query($update, array($pet_basic->deed_no));
            //     if($update_sro != true)
            //     {
            //         $validation['sro_note'] = '106'; // updation failed in sro_note
            //         $this->db->trans_rollback();
            //         return;
            //     }
            // }

            
           	////// BARAK VALLEY CODE START ////////////
            $petitioner = $this->db->query("SELECT applied_b, applied_k, applied_lc, applied_g, 
                applied_kr FROM petitioner WHERE petition_no=? and $append", 
                array($petition_no))->result();

            $pet_dag = $this->db->query("SELECT dag_no,m_dag_area_b, m_dag_area_k, m_dag_area_lc,
                m_dag_area_g, m_dag_area_kr,
                dag_area_b, dag_area_k, dag_area_lc, dag_area_g, dag_area_kr, patta_no,
                patta_type_code FROM petition_dag_details WHERE petition_no=? and $append", 
                array($petition_no))->result();

            $globalPdarID = false;
            $globalPdarIDss = null;
            foreach ($pet_dag as $pet_dag) 
            {
            
	            //calcilation for remailning land starts here
	            $total_mutation_b = 0;
	            $total_mutation_k = 0;
	            $total_mutation_lc = 0;
	            $total_mutation_g = 0;
	            $total_mutation_kr = 0;

	            
	            if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY)))
	            {
	                foreach ($petitioner  as $applied)
	                {
	                    $total_mutation_b += $applied->applied_b;
	                    $total_mutation_k += $applied->applied_k;
	                    $total_mutation_lc += $applied->applied_lc;
	                    $total_mutation_g += $applied->applied_g;
	                }

	                $mutated = $total_mutation_b * 6400 + $total_mutation_k * 320 + $total_mutation_lc * 20 + $total_mutation_g ;
	                $chitha = $pet_dag->dag_area_b * 6400 + $pet_dag->dag_area_k * 320 + $pet_dag->dag_area_lc * 20 + $pet_dag->dag_area_g;

	                $rem = $chitha - $mutated;

	                $bigha_r = floor($rem / 6400.0);
	                $katha_r = floor(($rem - $bigha_r * 6400.0) / 320.0);
	                $lessa_r = ($rem - $bigha_r * 6400.0 - $katha_r * 320.0)/20.0;
	                $ganda_r = $rem - $bigha_r * 6400.0 - $katha_r * 320.0 - $lessa_r * 20.0;

	                if ($mutated == 0) {
	                    $total_mutation_b = $pet_dag->m_dag_area_b;
	                    $total_mutation_k = $pet_dag->m_dag_area_k;
	                    $total_mutation_lc = $pet_dag->m_dag_area_lc;
	                    $total_mutation_g = $pet_dag->m_dag_area_g;
	                }
	            }
	            else 
	            { // other than barak valley
	                foreach ($petitioner  as $applied) {
	                    $total_mutation_b += $applied->applied_b;
	                    $total_mutation_k += $applied->applied_k;
	                    $total_mutation_lc += $applied->applied_lc;
	                }

	                $mutated = $total_mutation_b * 100 + $total_mutation_k * 20 + $total_mutation_lc;
	                $chitha = $pet_dag->dag_area_b * 100 + $pet_dag->dag_area_k * 20 + $pet_dag->dag_area_lc;
	                $rem = $chitha - $mutated;

	                $bigha_r = floor($rem / 100.0);
	                $katha_r = floor(($rem - $bigha_r * 100.0) / 20.0);
	                $lessa_r = $rem - $bigha_r * 100.0 - $katha_r * 20.0;
	                $ganda_r = 0;

	                if ($mutated == 0) {
	                    $total_mutation_b = $pet_dag->m_dag_area_b;
	                    $total_mutation_k = $pet_dag->m_dag_area_k;
	                    $total_mutation_lc = $pet_dag->m_dag_area_lc;
	                }    
	            }
            	//calculation for remaining land ends here

            	//insertion in t_chitha_rmk_ordbasic
	            $order_basic = [
	                'ord_no' => $case_no,
	                'ord_date' => date('Y-m-d'),
	                'ord_type_code' => '03',
	                'case_no' => $case_no,
	                'ord_passby_sign_yn' => 'Y',           
	                'ord_passby_desig' => 'CO',
	                'lm_code' => $value['lm_code'],
	                'lm_sign_yn' => 'Y',
	                'lm_sign_date' => date('Y-m-d'),
	                'sk_code' => $value['sk_code'],
	                'sk_sign_yn' => 'Y',
	                'sk_sign_date' => date('Y-m-d'),
	                'co_code' => $value['co_code'],
	                'co_sign_yn' => 'Y',
	                'co_ord_date' => date('Y-m-d'),
	                'm_dag_area_b' => $total_mutation_b,
	                'm_dag_area_k' => $total_mutation_k,
	                'm_dag_area_lc' => $total_mutation_lc,
	                'm_dag_area_g' => $total_mutation_g,
	                'm_dag_area_kr' => $total_mutation_kr,
	                'area_left_b' => $bigha_r,
	                'area_left_k' => $katha_r,
	                'area_left_lc' => $lessa_r,
	                'area_left_g' => $ganda_r, //ganda has changed
	                'area_left_kr' => $pet_dag->dag_area_kr - $total_mutation_kr,
	                'min_revenue' => 0.0,
                    'dag_no' => $pet_dag->dag_no,
	            ];
                // unset($locationData['dag_no']);
	            ////// BARAK VALLEY CODE END //////////// 
	            
	            $chithaBasic = array_merge($order_basic, $locationData);
	            //var_dump($chithaBasic);
	            $ins_basic = $this->db->insert("t_chitha_rmk_ordbasic", $chithaBasic);
	            // echo $this->db->last_query();
	            // echo "----------------<br>";
	            if($ins_basic != 1)
	            {
	                $validation['chitha_order_basic'] = '107'; // updation failed in sro_note
	                $this->db->trans_rollback();
	                log_message("error"," #OMTCRMOR001 could not insert t_chitha_rmk_ordbasic 
	                    district: ".$dist_code.", petition_no: ". $petition_no);            
	                echo json_encode($validation);
	                return;
	            }

                $response = $this->ChithaUpdateForMutationModel->autoUpdateOfcMultiGen($pet_basic->is_multigeneration,$dist_code, $subdiv_code, $cir_code, $lot_no, $vill_townprt_code, $mouza_pargona_code, $petition_no, $pet_dag->dag_no,$globalPdarID,$globalPdarIDss);
                log_message('error','RESPONSE==='.json_encode($response));
                if($response['responseType'] == 1)
                {
                    $validation['chitha_order_basic'] = '107'; // updation failed in sro_note
                    $this->db->trans_rollback();
                    log_message("error"," #OMAUTO001 could not auto update chitha district: ".$dist_code.", petition_no: ". $petition_no);            
                    echo json_encode($validation);
                    return;
                }  
                if($response['responseType'] == 2)
                {
                    $globalPdarID = true;
                    // if($response['globalPdarID'] != 1)
                    // {
                    //     $globalPdarIDss = $response['globalPdarID']-1;
                    // }
                    // else
                    // {
                    //     $globalPdarIDss = $response['globalPdarID'];
                    // }
                    $globalPdarIDss = $response['globalPdarID'];
                    $globalPdarIDss = $globalPdarIDss;
                }            
	        }

           	$update = "UPDATE petition_basic SET status = 'F', date_of_order='$date' WHERE 
           	case_no=? and $append";
           	$update_pet_status = $this->db->query($update, array($case_no));
           	if($this->db->affected_rows() != 1)
           	{
               $validation['pet_status'] = '105'; // updation failed in petition_basic
               $this->db->trans_rollback();
               log_message("error"," #OMPB002 could not update Final petition_basic
                 district: ".$dist_code.", petition_no: ". $petition_no);
               return;
           	}
            // $this->db->trans_rollback();
           
           
            // $validation=array(
            //     'success'=>true,
            //     'redirect_url'=>base_url().'index.php/home'
            // );
            // $this->db->trans_rollback();
           	if ($response['responseType'] == 2) 
           	{

                //ESCALATION CODE INTEGRATION================SANMRI
                $query1 = $this->db->query("SELECT es_flag FROM petition_basic WHERE petition_no=? and $append",array($petition_no))->row();
                $user_code = $this->session->userdata('user_code');
                if($query1->es_flag == 1 && ESCALATION_ENABLE ==1){

                    $executionDate = $this->input->post('executionDate');

                    $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
                    $serviceType = explode('/',$basundhara);
                    $service_code =1;
                    if($serviceType[1] == 'MUTD')
                    {
                        $service_code = 2;
                    }
                    $escalationUpdateStatus = $this->Escalationmodel->escalationFinalOrderCO($service_code,$executionDate,$dist_code,$subdiv_code,$cir_code,$case_no,$user_code);
                    log_message("error", "#ESC4788, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

                    if($escalationUpdateStatus['responseType'] == 0){
                        $this->db->trans_rollback();
                        log_message("error", "#ESC4788, transaction-error in method 'officemutation/finalorderCOMain' with case-no :". $case_no);
                        $this->session->set_flashdata('message', "Something went wrong.OMUT- Error Code(#ESC4788)");
                        redirect(base_url() . "index.php/home");
                    }
                }
                ///////////////END ESCALATION//////////////


                $save_chain_data =true;
                if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                {
                    ///////////////////////////////////////////////////////////////////////////
                    //////////////////////Property chain code /////////////////////////////////
                    ///////////////////////////////////////////////////////////////////////////
                    $this->load->model('propChain/PropChainModel');
                    $ulpin = $this->input->post('ulpin', true);
                    $revenue = $this->input->post('chain_revenue', true);
                    $local_tax = $this->input->post('chain_local_tax', true);
                    $old_ulpin = $this->input->post('old_ulpin', true);

                    if (!isset($old_ulpin)) {
                        $old_ulpin = "";
                    }

                    $ulpinFlag = $this->input->post('ulpinCheckFlag', true);
                    $compareFlag = $this->input->post('compareCheckFlag', true);
                    if($compareFlag == 'Y' && $ulpinFlag ==1)
                    {

                        $type = LOC_TYPE_RURAL;
                        $patta_no = $this->input->post('patta_no');
                        $patta_type_code = $this->input->post('patta_type_code');
                        $location_id = $dist_code . $subdiv_code . $cir_code . $mouza_pargona_code . $lot_no . $vill_townprt_code;

                        $property_id = $this->blockchainutilityclass->generatePropertyId($type, $vill_townprt_code, $patta_no, $dag_no, $ulpin);
                        $reference_id = $case_no;

                        $certmnemonic = CERTMNEMONIC_MUT;

                        $property_signature = "base64 encoded signature";
                        $property_signer_key = "base64 encoded public key";
                        $office_code = $this->session->userdata('cir_code');
                        $user_code = $this->session->userdata('user_code');

                        // mutated land area
                        // $mutated_bigha = $this->input->post('mut_b');
                        // $mutated_katha = $this->input->post('mut_k');
                        // $mutated_lessa = $this->input->post('mut_lc');
                        // $mutated_ganda = $this->input->post('mut_g');

                        // total land area
                        $land_area = $this->PropChainModel->getLandArea($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no);

                        $bigha_chain = $land_area->dag_area_b;
                        $katha_chain = $land_area->dag_area_k;
                        $lessa_chain = $land_area->dag_area_lc;
                        $ganda_chain = $land_area->dag_area_g;

                        $land_class_code_query = "select land_class_code from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and patta_no='$patta_no' and dag_no='$dag_no'";

                        $land_class_code = $this->db->query($land_class_code_query)->row()->land_class_code;

                        $pattadar_details = $this->PropChainModel->getPattadars($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no);


                        // since the below parameters are not applicable assign the empty string
                        $new_patta_no = $new_dag_no = $old_revenue = $old_local_tax = $old_land_class_code  = $new_bigha = $new_katha = $new_lessa = $new_ganda = "";

                        $update_params = array(
                            'pattadar_details' => $pattadar_details,
                            'location_id' => $location_id,
                            'property_id' => $property_id,
                            'reference_id' => $reference_id,
                            'dag_no' => $dag_no,
                            'patta_no' => $patta_no,
                            'patta_type_code' => $patta_type_code,
                            'land_class_code' => $land_class_code,
                            'bigha_chain' => $bigha_chain,
                            'katha_chain' => $katha_chain,
                            'lessa_chain' => $lessa_chain,
                            'ganda_chain' => $ganda_chain,
                            'certmnemonic' => $certmnemonic,
                            'property_signature' => $property_signature,
                            'property_signer_key' => $property_signer_key,
                            'office_code' => $office_code,
                            'user_code' => $user_code,
                            'ulpin' => $ulpin,
                            'old_ulpin' => $old_ulpin,
                            'revenue' => $revenue,
                            'local_tax' => $local_tax,
                            'new_patta_no' => $new_patta_no,
                            'new_dag_no' => $new_dag_no,
                            'old_revenue' => $old_revenue,
                            'old_local_tax' => $old_local_tax,
                            'old_land_class_code' => $old_land_class_code,
                            'new_bigha' => $new_bigha,
                            'new_katha' => $new_katha,
                            'new_lessa' => $new_lessa,
                            'new_ganda' => $new_ganda
                        );

                        $chain_send_data = $this->blockchainutilityclass->getUpdateChainArrayN((object)$update_params);

                        ///////////////////////////////// call chain update api ///////////////////////////////

                        $save_chain_data = $this->PropChainModel->save_chain_data(json_encode($chain_send_data), $case_no);
                	}
            	}
                if($save_chain_data)
                {
                    $this->db->trans_commit();
                    // $this->db->trans_rollback();
                    $curl_handle = curl_init();
                    curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK."/mutation/mutation_response.php");
                    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                         'applId' => $pet_basic->applid,
                         'application_ref_no' => $pet_basic->application_ref_no,
                         'msg' => "Delivered",
                         'status' => "D",
                    )));
                    $result = curl_exec($curl_handle);
                    $this->session->set_flashdata(array('message' => "Order Passed for Case # $case_no"));
                    $this->session->set_flashdata(array('message2' => "Chitha Updated for Case # $case_no\ and Dag # (" . implode(', ', $dag_no) . ")."));

                        ////////
                    $this->DashboardDataFinal($case_no);
                    $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
                    if($basundhara){
                        $rmk='Final Order Passed';
                        $status='F';
                        $task='CO';
                        $pen='NA';
                        $case=$case_no;
                        $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
                    }
                        ////////////////////////////////////
                        /////////for jb////////////
                    $pa_no=$t_chitha_rmk_infavor_of['patta_no'];
                    $pt_code=$t_chitha_rmk_infavor_of['patta_type_code'];
                        /////////////////////
                    $location = array(
                        'd'=> $dist_code,
                        's' => $subdiv_code,
                        'c' => $cir_code,
                        'm' => $mouza_pargona_code,
                        'l' => $lot_no,
                        'v' => $vill_townprt_code,
                    );
                        //var_dump($location);
                    $this->session->set_userdata('case_no',$case_no); 
                    $this->session->set_userdata('patta_no',$pa_no);
                    $this->session->set_userdata('patta_type_code',$pt_code);
                    $this->session->set_userdata(array('loc' => $location));
                    if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                    {
                        if($ulpinFlag == 1 && $compareFlag == 'Y')
                        {
                            log_message('error',"MB4708 : BLOCK CHAIN Insertion===============");
                            $chain_update_status = 1;
                            $chain_create_status = 2;
                            $validation = array(
                                'success' => true,
                                'redirect_url' => base_url() . 'index.php/JamaBandi/step3/' .$pa_no .'/'. $pt_code.'/'.urlencode(base64_encode($case_no))
                            );
                            echo json_encode($validation);
                            return;
                        }
                        
                    }
                    $validation=array(
                     'success'=>true,
                     'redirect_url'=>base_url().'index.php/JamaBandi/step3/' .$pa_no .'/'. $pt_code);
                    echo json_encode($validation);
                    return;

                }
                elseif (!$save_chain_data) {
                    $validation['chain_status'] = 0;
                    $this->db->trans_rollback();
                    log_message('error', "Data not saved in table prop_chain_sent_data. Error code: #CHAINSAVEERROR0001");
                    return;
                } else {
                    $validation['chain_status'] = null;
                    $this->db->trans_rollback();
                    log_message("error", "#CHAINSAVEERROR0002 : Error occured. Property Chain updation for Case No $case_no Not Successfull.");
                    echo json_encode($validation);
                    return;
            	}
                    
        	}
        	echo json_encode($validation);
    	}
    }
    
    // Added by Abhijit -- 2024-04-29
    public function finalOrderOfcMutationPassCOMultiDag()
    {
        //xss & security validation starts
        $errorMessageStr = '';
        $resp = checkRequestSpecChar($_POST,array(),array(),array('co_order' => true));
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }
        $resp = checkRequestValidQuery($_POST,array(),array('co_order' => true));
        if($resp['status'] == 'n'){
            $errorMessageStr .= $resp['messages'];
        }    
        if($errorMessageStr != ''){
            $validation=array(
                'error' => $errorMessageStr
            );
            $validation['attachment'] = 'audit';                  
            echo json_encode($validation);
            return;
        }
        //xss & security validation ends 
        
        if ($this->input->server('REQUEST_METHOD') == 'POST') 
        {
            $this->db->trans_begin();
            $year_no = year_no;
            $value = $this->input->post();
            $mutatedBigha = $this->input->post('mut_b');
            $mutatedKatha = $this->input->post('mut_k');
            $mutatedLessa = $this->input->post('mut_lc');
            $mutatedGanda = $this->input->post('mut_g');
            $mutatedKranti = $this->input->post('mut_kr');
            $case_no = $this->input->post('case_no');
            $dag_no = $this->input->post('dag_no');
            $dist_code = $this->input->post('dist_code');
            $subdiv_code = $this->input->post('subdiv_code');
            $cir_code = $this->input->post('cir_code');
            $mouza_pargona_code = $this->input->post('mouza_pargona_code');
            $lot_no = $this->input->post('lot_no');
            $vill_townprt_code = $this->input->post('vill_townprt_code');
            $date = date('Y-m-d');

            $deed_no = $this->input->post('deed_no');
            $is_valid_deed_no = isValidDeedNo($deed_no);
            if(!$is_valid_deed_no['success']){
                $data=array(
                    'error'=> $is_valid_deed_no['message'],
                    'attachment' => 'audit'
                );
                echo json_encode($data);
                return false;
            }

            $is_passable = $this->utilityclass->isTheCasePassable($case_no, 'OMUT');
            if(!$is_passable['success']){
                $data=array(
                    'error'=> $is_passable['message'],
                    'attachment' => 'audit'
                );
                echo json_encode($data);
                return false;
            }

            //////////////////////////////////
            if(isset($_FILES['fileUpload']['name']))
            {
                $this->form_validation->set_rules('fileText[]', 'Document Details', 'trim|xss_clean|required');
                $fileCount = count($_FILES['fileUpload']['name']);
                // validation for file type and file size
                for($i = 0; $i < $fileCount; $i++)
                {
                    if($_FILES['fileUpload']['name'][$i] && $_FILES['fileUpload']['size'][$i] && $_FILES['fileUpload']['tmp_name'][$i])
                    {
                        $name = $_FILES['fileUpload']['name'][$i];
                        $size = $_FILES['fileUpload']['size'][$i];
                        $mime = mime_content_type($_FILES['fileUpload']['tmp_name'][$i]);
                        $exp  = explode("/",$mime);
                        $ext  = $exp[1];
                            if($name != NULL)
                            {
                                if($ext == NULL)
                                {

                                    $this->db->trans_rollback();
                                    $validation['attachment'] = '1001';                  
                                    echo json_encode($validation);
                                    return;
                                }
                                if(! in_array($ext, UPLOAD_TYPE_VALIDATION))
                                {
                                    $this->db->trans_rollback();
                                    $validation['attachment'] = '1001';                  
                                    echo json_encode($validation);
                                    return;
                                }
                                if($size > UPLOAD_MAX_SIZE)
                                {
                                    $this->db->trans_rollback();
                                    $validation['attachment'] = '1001';                  
                                    echo json_encode($validation);
                                    return;
                                }
                            }
                            else
                            {
                                $this->db->trans_rollback();
                                $validation['attachment'] = '1001';                  
                                echo json_encode($validation);
                                return;
                            }
                    }
                    else{
                        $this->db->trans_rollback();
                        $validation['attachment'] = '1001';                  
                        echo json_encode($validation);
                        return;
                    }
                }
            }
            ///////////////////Insert attached file////////////////////////
            if(isset($_FILES['fileUpload']['name']))
            {
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
                    $config['max_size']  = UPLOAD_MAX_SIZE;
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
                            'mut_type'   => 'OM',
                        );
                        // save data in attachment file
                        $addMoreDocQuery = $this->db->insert('supportive_document',$document);
                        if($addMoreDocQuery != 1)
                        {
                            $this->db->trans_rollback();
                            $validation['attachment'] = '1001';                  
                            echo json_encode($validation);
                            return;
                        }
                    }
                    else
                    {
                        $this->db->trans_rollback();
                        $validation['attachment'] = '1001';                  
                        echo json_encode($validation);
                        return;
                    }
                }
            }
            //////////////////////////////////////////
            $appendq = $this->query;

            $append = "dist_code='$dist_code' AND subdiv_code='$subdiv_code' AND 
            cir_code='$cir_code' AND mouza_pargona_code='$mouza_pargona_code' AND 
            lot_no='$lot_no' AND vill_townprt_code='$vill_townprt_code'";

            $proceeding_idd = $this->db->query("SELECT max(proceeding_id)+1 AS pid FROM
                petition_proceeding WHERE case_no=? AND $this->query", array($case_no));
            //log_message('error',$this->db->last_query());
            if ($proceeding_idd->num_rows()==0){
                $proceeding_id=1;
            }else
            { 
                $proceeding_id=$proceeding_idd->row()->pid; 
            }
            //get detail from petition_basic

            $pet_basic = $this->db->query("SELECT * FROM petition_basic WHERE case_no=? and $append", array($case_no))->row();
            $petition_no = $pet_basic->petition_no;

            if(!$pet_basic){
                $this->session->set_flashdata('message',"No such case found.");
                return redirect('/home');
            }
            
            if($pet_basic->is_multidag != 'Y'){
                $this->session->set_flashdata('message',"This service is inactive for now.");
                return redirect('/home');
            }



            //==========check dag pending in blockchain or not=================
            if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
            {
                $this->load->model('propChain/PropChainCommonModel');
                $query = "SELECT * FROM petition_dag_details  WHERE dist_code=? AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? AND  vill_townprt_code=? AND petition_no=?";
                    $dagList = $this->db->query($query, array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $petition_no))->result();
                foreach ($dagList as $key => $dagCheck)
                {

                    $checkVal = $this->PropChainCommonModel->checkDagExistsInPropChainInPending($dagCheck->dist_code,$dagCheck->subdiv_code,$dagCheck->cir_code,$dagCheck->mouza_pargona_code,$dagCheck->lot_no,$dagCheck->vill_townprt_code,$dagCheck->dag_no);
                    if($checkVal === false)
                    {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "#ERRORBLOCCHAIN4143 : You cannot procced as dag no is pending for property chain update...");
                        redirect(base_url() . "index.php/home");
                    }
                }
            }
            ///=============end CODE=====================

                //get detail from petitioner & petition_dag_details

            $petitioner = $this->db->query("SELECT * FROM petitioner WHERE petition_no=? AND $append order by pet_id desc ", array($petition_no));

            if ($petitioner == null || $petitioner->num_rows()<=0)
            {
                log_message("error"," #OMPET001 could not find petitioner 
                    district: ".$dist_code.", petition_no: ". $petition_no);
                    $validation['petitioner_nok'] = '109'; // insertion failed in infavour t_chitha
                    $this->db->trans_rollback();
                    echo json_encode($validation);
                    return;
            } 
            $petitioner = $petitioner->row();

                // /var_dump($petitioner);
            $noktmp = $this->db->query("SELECT * FROM nok_tmp WHERE case_id=? AND approve_reject=?", array($case_no, 1))->result();
            if($noktmp)
            {
                $i=1;                    
                foreach($noktmp as $nok)
                {
                    $basic = clone $petitioner;
                    $basic->pet_id = ($petitioner->pet_id)+$i;
                    $basic->pet_name = $nok->name_asm;
                    $basic->pet_name = $nok->name_asm;
                    $basic->guard_name = $nok->guardian_name_asm;
                    $basic->guard_rel = $nok->relation;
                    $basic->pet_gender = $nok->gender;
                    $basic->add1 = $nok->address;
                    $basic->pet_minor_dob = $nok->dob;
                    $basic->new_pattadar='N';
                    
                    $basic->pdar_mobile = $nok->mobile;
                    $basic->pdar_id = null;
                    $basic->self_declaration = null;
                    $basic->auth_type = null;
                    $basic->id_ref_no = null;
                    $basic->photo = null;
                    $basic->pdar_name_eng = null;
                    $basic->pdar_guard_eng = null;
    
                    $basic->marital_status = $nok->marital_status;
                    $basic->applicant_occupation = $nok->applicant_occupation;
                    $basic->caste_category = $nok->caste_category;
                    $basic->tribe_category = $nok->tribe_category;

                    unset($basic->id);
                    $ins_pet = $this->db->insert("petitioner", $basic);
                    $i++;

                    if ($ins_pet != 1 )
                    {
                        $this->db->trans_rollback();
                        log_message("error"," #OMNOK001 could not insert nok to petitioner 
                        district: ".$dist_code.", petition_no: ". $petition_no);
                        $validation['petitioner_nok'] = '109';                  
                        echo json_encode($validation);
                        return;
                    }
                    
                    $update="Update nok_tmp set approve_reject=2 where case_id='$case_no' and serial_id=$nok->serial_id ";
                    $this->db->query($update);
                    if ($this->db->affected_rows()<=0)
                    {
                        $this->db->trans_rollback();
                        log_message("error"," #OMNOK002 could not update nok approve_reject district: ".$dist_code.", petition_no: ". $petition_no);
                        $validation['petitioner_nok'] = '109';                  
                        echo json_encode($validation);
                        return;
                    }
                }            
            }
            //////////////////////////
            $query = "SELECT * FROM petitioner pb JOIN petition_dag_details pd ON 
                pb.dist_code = pd.dist_code AND pb.subdiv_code = pd.subdiv_code AND 
                pb.cir_code = pd.cir_code AND pb.mouza_pargona_code = pd.mouza_pargona_code AND 
                pb.lot_no = pd.lot_no AND pb.vill_townprt_code = pd.vill_townprt_code and pb.petition_no=pd.petition_no and pb.year_no=pd.year_no WHERE 
                pb.dist_code=? AND pb.subdiv_code=? AND pb.cir_code=?
                AND pb.mouza_pargona_code=? AND pb.lot_no=? AND 
                pb.vill_townprt_code=? AND pb.petition_no=?";
            $datas = $this->db->query($query, array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $petition_no))->result();

            // log_message('error','6730------------'.json_encode($this->db->last_query()));

                    //get detail from petition_pattadar
            // $query = "SELECT * FROM petition_pattadar WHERE petition_no=? AND $append";
            // $pet_pattadar = $this->db->query($query, array($data->dag_no, $petition_no));
            // if ($pet_pattadar == null || $pet_pattadar->num_rows()<=0)
            // {
            //     $this->db->trans_rollback();
            //     log_message("error"," #OMPPT001 could not get petition_pattadar  
            //         district: ".$dist_code.", petition_no: ". $petition_no);
            //     $validation['petitioner_nok'] = '109';                  
            //     echo json_encode($validation);
            //     return;
            // }
            // $pet_pattadar = $pet_pattadar->result();
            
            $locationData = [
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_townprt_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                // 'dag_no' => $dag_no,
                'year_no' => date('Y'),
                'petition_no' => $petition_no,
            ];

            $data = [
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => date('Y-m-d h:i:s'),
                'co_order' => addslashes($this->input->post('co_order')),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'status' => 'final',
                'user_code' => $this->user_code,
                'dist_code' => $dist_code,
                'cir_code' => $cir_code,
                'subdiv_code' => $subdiv_code,
                'operation' => 'E',
                'date_entry' => date('Y-m-d G:i:s'),
                'ip' => $this->utilityclass->get_client_ip()
            ];
            $pet_proceed = $this->db->insert('petition_proceeding', $data);
            if($pet_proceed != 1){
                $this->db->trans_rollback();
                $validation['pet_proceed'] = '108';            
                log_message("error"," #OMPP001 could not insert petition_proceeding  
                    district: ".$dist_code.", petition_no: ". $petition_no);
                echo json_encode($validation);            
                return;
            }
            ////////////////////////////
            if($value['deed_no']=='' || $value['deed_no']==null){$value['deed_no']='';}
            if($value['deed_value']=='' || $value['deed_value']==null){$value['deed_value']='';}
            if($value['deed_date']=='' || $value['deed_date']==null){$value['deed_date']='';}

            //updation of deed details
            $deedDetail = [
                'deed_no' => $value['deed_no'],
                'deed_value' => $value['deed_value'],
                'deed_date' => date('Y-m-d', strtotime($value['deed_date'])),
            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('petition_basic', $deedDetail);
            if($this->db->affected_rows() != 1){
                $this->db->trans_rollback();
                $validation['deed_updation'] = '101';
                log_message("error"," #OMPB001 could not insert petition_proceeding  
                    district: ".$dist_code.", petition_no: ". $petition_no);            
                echo json_encode($validation);
                return;
            }


            $query = "SELECT * FROM petition_dag_details WHERE petition_no=? AND $append";
            $petDagDetails = $this->db->query($query, array($petition_no));
            if ($petDagDetails == null || $petDagDetails->num_rows()<=0)
            {
                $this->db->trans_rollback();
                log_message("error"," #OMPPT6802 could not get Petition Dag Details  
                    district: ".$dist_code.", petition_no: ". $petition_no);
                $validation['petitioner_nok'] = '101';                  
                echo json_encode($validation);
                return;
            }
            $postDagNo = $this->input->post('dag_no'); 
            for ($i=0; $i < count($mutatedBigha) ; $i++) { 
                if($mutatedBigha[$i]=='' || $mutatedBigha[$i]==null){$mutatedBigha[$i]='0';}
                if($mutatedKatha[$i]=='' || $mutatedKatha[$i] ==null){$mutatedKatha[$i]='0';}
                if($mutatedLessa[$i] =='' || $mutatedLessa[$i] ==null){$mutatedLessa[$i] ='0';}
                if($mutatedGanda[$i] =='' || $mutatedGanda[$i] ==null){$mutatedGanda[$i] ='0';}
                if($mutatedKranti[$i] =='' || $mutatedKranti[$i] ==null){$mutatedKranti[$i] ='0';}
                $mut_land = "UPDATE petition_dag_details SET 
                                m_dag_area_b='".$mutatedBigha[$i]."',
                                m_dag_area_k='".$mutatedKatha[$i]."',
                                m_dag_area_lc='".$mutatedLessa[$i]."',
                                m_dag_area_g='".$mutatedGanda[$i]."',
                                m_dag_area_kr='".$mutatedKranti[$i]."'
                                WHERE $append AND petition_no=? and dag_no = ? ";
                $this->db->query($mut_land, array($petition_no,$postDagNo[$i]));
                if($this->db->affected_rows() == 0)
                {
                    $this->db->trans_rollback();
                    $validation['land_updation'] = '102'; // mutated land updation failed            
                    log_message("error"," #OMPDD001 could not update land details  
                        district: ".$dist_code.", petition_no: ". $petition_no);            
                    echo json_encode($validation);
                    return;
                }
            }
            //updation of mutated land
            

            //insertion in t_chitha_rmk_infavor_of
            foreach($datas as $data)
            {
                // $query = "SELECT * FROM petition_pattadar WHERE petition_no=? AND dag_no=? AND $append";
                // $pet_pattadar = $this->db->query($query, array($petition_no, $data->dag_no));
                // if ($pet_pattadar == null || $pet_pattadar->num_rows()<=0)
                // {
                //     $this->db->trans_rollback();
                //     log_message('error', 'PETPTTDR => ' . $this->db->last_query());
                //     log_message("error"," #OMPPT001 could not get petition_pattadar  
                //         district: ".$dist_code.", petition_no: ". $petition_no);
                //     $validation['petitioner_nok'] = '109';                  
                //     echo json_encode($validation);
                //     return;
                // }
                // $pet_pattadar = $pet_pattadar->result();

                $dec= null;
                if(isset($data->self_declaration) && $data->self_declaration !=null)
                {
                    $dec       = $data->self_declaration;
                }
                if(isset($data->auth_type) && $data->auth_type != null)
                {
                    if($data->auth_type=='AADHAAR' && $data->photo == null)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRFMUTI005:Aadhaar Photo fetching error');
                        redirect(base_url() . "index.php/home");
                    }
                    $auth_type = $data->auth_type;
                    $id_ref_no = $data->id_ref_no;
                    // $photo     = $data->photo;
                    $photo     = null;
                }
                else
                {
                    $auth_type = null;
                    $id_ref_no = null;
                    $photo = null;
                }
                $strikeForce=0;


                $t_chitha_rmk_infavor_of = [
                    'patta_type_code' => $data->patta_type_code,
                    'patta_no' => $data->patta_no,
                    'ord_no' => $case_no,
                    'ord_date' => date('Y-m-d G:i:s'),
                    'infavor_of_id' => $data->pet_id,
                    'infavor_of_name' => $data->pet_name,
                    'infavor_of_guardian' => $data->guard_name,
                    'infav_of_guar_relation' => $data->guard_rel,
                    'infavor_of_add1' => $data->add1,
                    'infavor_of_add2' => $data->add2,
                    'by_right_of' => $value['by_right_of'],
                    'land_area_b' => $data->m_dag_area_b,
                    'land_area_k' => $data->m_dag_area_k,
                    'land_area_lc' => $data->m_dag_area_lc,
                    'land_area_g' => 0,
                    'land_area_kr' => 0,
                    'revenue' => 0,
                    'reg_deal_no' => $value['deed_no'],
                    'reg_date' => date('Y-m-d', strtotime($value['deed_date'])),
                    'infavor_of_gender' => $data->pet_gender,
                    'infavor_of_minor_yn' => $data->pet_minor_yn,
                    'infavor_of_minor_dob' => $data->pet_minor_dob,
                    'infavor_of_mother' => $data->pet_mother,
                    'new_pattadar'     =>$data->new_pattadar,
                    'self_declaration' => $dec,
                    'auth_type'        => $auth_type,
                    'id_ref_no'        => $id_ref_no,
                    'photo'            => $photo,
                    'pdar_name_eng'    => $data->pdar_name_eng,
                    'pdar_guard_eng'   => $data->pdar_guard_eng,
                    'dag_no'           => $data->dag_no,

                ];
                // unset($locationData['dag_no']);

                $tchitha_infavorof = array_merge($t_chitha_rmk_infavor_of, $locationData);

                $ins_tchitha_infavour = $this->db->insert("t_chitha_rmk_infavor_of", $tchitha_infavorof);
                    // log_message('error','---------25'.json_encode($this->db->last_query()));
                if($ins_tchitha_infavour != 1)
                {
                    $validation['t_chitha_infavor'] = '103'; // insertion failed in infavour t_chitha
                    $this->db->trans_rollback();
                    log_message("error"," #OMTCRMI001 could not insert t_chitha_rmk_infavour_of 
                    district: ".$dist_code.", petition_no: ". $petition_no);            
                    echo json_encode($validation);
                    return;
                }
                
                // //insertion in inplace & alongwith
                // foreach($pet_pattadar as $inall) 
                // {
                //     $inplace_alongwith = $inall->striked_out;
                //     $table = (($inplace_alongwith==1)?'t_chitha_rmk_inplace_of':'t_chitha_rmk_alongwith');
    
                //     if($inplace_alongwith == 1) //insertion in inplace chitha
                //     {
                //         $insertInplaceAlong = [
                //             'ord_no' => $case_no,
                //             'ord_date' => $date,
                //             'inplace_of_id' => $inall->pdar_id,
                //             'pdar_id' => $inall->pdar_id,
                //             'inplace_of_name' => $inall->pdar_name,
                //             'inplace_of_guardian' => $inall->pdar_guardian,
                //             'inplace_of_relation' => $inall->pdar_rel_guar,
                //             'strike_out' => '1',
                //             'dag_no' => $inall->dag_no,
                //         ];
                //     }
                //     else if($inplace_alongwith == 0 || $inplace_alongwith == '') //insertion in alongwith chitha
                //     {
                //         $insertInplaceAlong = [
                //             'ord_no' => $case_no,
                //             'ord_date' => $date,
                //             'alongwith_id' => $inall->pdar_id,
                //             'alongwith_name' => $inall->pdar_name,
                //             'alongwith_guardian' => $inall->pdar_guardian,
                //             'alongwith_rel_gur' => $inall->pdar_rel_guar,
                //             'pdar_id' => $inall->pdar_id,
                //             'dag_no' => $inall->dag_no,
                //         ];
                //     }
                //     // unset($locationData['dag_no']);
                //     $tchitha_inplaceof_tmp = array_merge($insertInplaceAlong, $locationData);
                //     $ins_inplace = $this->db->insert($table, $tchitha_inplaceof_tmp);
                //     // echo $this->db->last_query();
                //     // echo "----------------<br>";
                //     if($ins_inplace != 1){
                //         $validation['inplace'] = '104'; // insertion failed in inplace chitha
                //         $this->db->trans_rollback();
                //         log_message("error"," #OMTCIA001 could not insert ".$table
                //         ."district: ".$dist_code.", petition_no: ". $petition_no);            
                //         echo json_encode($validation);
                //         return;
                //     }
                    
                // } //end of foreach //insertion in inplace & alongwith
                
            }
            
            foreach($postDagNo as $singDagNo){
                $query = "SELECT * FROM petition_pattadar WHERE petition_no=? AND dag_no=? AND $append";
                $pet_pattadar = $this->db->query($query, array($petition_no, $singDagNo));
                if ($pet_pattadar == null || $pet_pattadar->num_rows()<=0)
                {
                    $this->db->trans_rollback();
                    log_message('error', 'PETPTTDR => ' . $this->db->last_query());
                    log_message("error"," #OMPPT001 could not get petition_pattadar  
                        district: ".$dist_code.", petition_no: ". $petition_no);
                    $validation['petitioner_nok'] = '109';                  
                    echo json_encode($validation);
                    return;
                }
                $pet_pattadar = $pet_pattadar->result();

                //insertion in inplace & alongwith
                foreach($pet_pattadar as $inall) 
                {
                    $inplace_alongwith = $inall->striked_out;
                    $table = (($inplace_alongwith==1)?'t_chitha_rmk_inplace_of':'t_chitha_rmk_alongwith');
    
                    if($inplace_alongwith == 1) //insertion in inplace chitha
                    {
                        $insertInplaceAlong = [
                            'ord_no' => $case_no,
                            'ord_date' => $date,
                            'inplace_of_id' => $inall->pdar_id,
                            'pdar_id' => $inall->pdar_id,
                            'inplace_of_name' => $inall->pdar_name,
                            'inplace_of_guardian' => $inall->pdar_guardian,
                            'inplace_of_relation' => $inall->pdar_rel_guar,
                            'strike_out' => '1',
                            'dag_no' => $inall->dag_no,
                        ];
                    }
                    else if($inplace_alongwith == 0 || $inplace_alongwith == '') //insertion in alongwith chitha
                    {
                        $insertInplaceAlong = [
                            'ord_no' => $case_no,
                            'ord_date' => $date,
                            'alongwith_id' => $inall->pdar_id,
                            'alongwith_name' => $inall->pdar_name,
                            'alongwith_guardian' => $inall->pdar_guardian,
                            'alongwith_rel_gur' => $inall->pdar_rel_guar,
                            'pdar_id' => $inall->pdar_id,
                            'dag_no' => $inall->dag_no,
                        ];
                    }
                    // unset($locationData['dag_no']);
                    $tchitha_inplaceof_tmp = array_merge($insertInplaceAlong, $locationData);
                    $ins_inplace = $this->db->insert($table, $tchitha_inplaceof_tmp);
                    // echo $this->db->last_query();
                    // echo "----------------<br>";
                    if($ins_inplace != 1){
                        $validation['inplace'] = '104'; // insertion failed in inplace chitha
                        $this->db->trans_rollback();
                        log_message("error"," #OMTCIA001 could not insert ".$table
                        ."district: ".$dist_code.", petition_no: ". $petition_no);            
                        echo json_encode($validation);
                        return;
                    }
                    
                } //end of foreach //insertion in inplace & alongwith
                
            }
                
            
            
            //***************************************//

            // if ($pet_basic->deed_no != 0 or $pet_basic->deed_no != null) {
            //     $update = "UPDATE sro_note SET status='3' WHERE deed_no=?";
            //     $update_sro = $this->db->query($update, array($pet_basic->deed_no));
            //     if($update_sro != true)
            //     {
            //         $validation['sro_note'] = '106'; // updation failed in sro_note
            //         $this->db->trans_rollback();
            //         return;
            //     }
            // }

            
            ////// BARAK VALLEY CODE START ////////////
            $petitioner = $this->db->query("SELECT applied_b, applied_k, applied_lc, applied_g, 
                applied_kr FROM petitioner WHERE petition_no=? and $append", 
                array($petition_no))->result();

            $pet_dag = $this->db->query("SELECT dag_no,m_dag_area_b, m_dag_area_k, m_dag_area_lc,
                m_dag_area_g, m_dag_area_kr,
                dag_area_b, dag_area_k, dag_area_lc, dag_area_g, dag_area_kr, patta_no,
                patta_type_code FROM petition_dag_details WHERE petition_no=? and $append", 
                array($petition_no))->result();


            foreach ($pet_dag as $pet_dag) 
            {
            
                //calcilation for remailning land starts here
                $total_mutation_b = 0;
                $total_mutation_k = 0;
                $total_mutation_lc = 0;
                $total_mutation_g = 0;
                $total_mutation_kr = 0;

                
                if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY)))
                {
                    foreach ($petitioner  as $applied)
                    {
                        $total_mutation_b += $applied->applied_b;
                        $total_mutation_k += $applied->applied_k;
                        $total_mutation_lc += $applied->applied_lc;
                        $total_mutation_g += $applied->applied_g;
                    }

                    $mutated = $total_mutation_b * 6400 + $total_mutation_k * 320 + $total_mutation_lc * 20 + $total_mutation_g ;
                    $chitha = $pet_dag->dag_area_b * 6400 + $pet_dag->dag_area_k * 320 + $pet_dag->dag_area_lc * 20 + $pet_dag->dag_area_g;

                    $rem = $chitha - $mutated;

                    $bigha_r = floor($rem / 6400.0);
                    $katha_r = floor(($rem - $bigha_r * 6400.0) / 320.0);
                    $lessa_r = ($rem - $bigha_r * 6400.0 - $katha_r * 320.0)/20.0;
                    $ganda_r = $rem - $bigha_r * 6400.0 - $katha_r * 320.0 - $lessa_r * 20.0;

                    if ($mutated == 0) {
                        $total_mutation_b = $pet_dag->m_dag_area_b;
                        $total_mutation_k = $pet_dag->m_dag_area_k;
                        $total_mutation_lc = $pet_dag->m_dag_area_lc;
                        $total_mutation_g = $pet_dag->m_dag_area_g;
                    }
                }
                else 
                { // other than barak valley
                    foreach ($petitioner  as $applied) {
                        $total_mutation_b += $applied->applied_b;
                        $total_mutation_k += $applied->applied_k;
                        $total_mutation_lc += $applied->applied_lc;
                    }

                    $mutated = $total_mutation_b * 100 + $total_mutation_k * 20 + $total_mutation_lc;
                    $chitha = $pet_dag->dag_area_b * 100 + $pet_dag->dag_area_k * 20 + $pet_dag->dag_area_lc;
                    $rem = $chitha - $mutated;

                    $bigha_r = floor($rem / 100.0);
                    $katha_r = floor(($rem - $bigha_r * 100.0) / 20.0);
                    $lessa_r = $rem - $bigha_r * 100.0 - $katha_r * 20.0;
                    $ganda_r = 0;

                    if ($mutated == 0) {
                        $total_mutation_b = $pet_dag->m_dag_area_b;
                        $total_mutation_k = $pet_dag->m_dag_area_k;
                        $total_mutation_lc = $pet_dag->m_dag_area_lc;
                    }    
                }
                //calculation for remaining land ends here

                //insertion in t_chitha_rmk_ordbasic
                $order_basic = [
                    'ord_no' => $case_no,
                    'ord_date' => date('Y-m-d'),
                    'ord_type_code' => '03',
                    'case_no' => $case_no,
                    'ord_passby_sign_yn' => 'Y',           
                    'ord_passby_desig' => 'CO',
                    'lm_code' => $value['lm_code'],
                    'lm_sign_yn' => 'Y',
                    'lm_sign_date' => date('Y-m-d'),
                    'sk_code' => $value['sk_code'],
                    'sk_sign_yn' => 'Y',
                    'sk_sign_date' => date('Y-m-d'),
                    'co_code' => $value['co_code'],
                    'co_sign_yn' => 'Y',
                    'co_ord_date' => date('Y-m-d'),
                    'm_dag_area_b' => $total_mutation_b,
                    'm_dag_area_k' => $total_mutation_k,
                    'm_dag_area_lc' => $total_mutation_lc,
                    'm_dag_area_g' => $total_mutation_g,
                    'm_dag_area_kr' => $total_mutation_kr,
                    'area_left_b' => $bigha_r,
                    'area_left_k' => $katha_r,
                    'area_left_lc' => $lessa_r,
                    'area_left_g' => $ganda_r, //ganda has changed
                    'area_left_kr' => $pet_dag->dag_area_kr - $total_mutation_kr,
                    'min_revenue' => 0.0,
                    'dag_no' => $pet_dag->dag_no,
                ];
                // unset($locationData['dag_no']);
                ////// BARAK VALLEY CODE END //////////// 
                
                $chithaBasic = array_merge($order_basic, $locationData);
                // echo "<pre>";
                // var_dump($chithaBasic);
                // $this->db->trans_rollback();
                // dd(123);
                $ins_basic = $this->db->insert("t_chitha_rmk_ordbasic", $chithaBasic);
                // echo $this->db->last_query();
                // echo "----------------<br>";
                if($ins_basic != 1)
                {
                    $validation['chitha_order_basic'] = '107'; // updation failed in sro_note
                    $this->db->trans_rollback();
                    log_message("error"," #MULOMTCRMOR001 could not insert t_chitha_rmk_ordbasic 
                        district: ".$dist_code.", petition_no: ". $petition_no);            
                    echo json_encode($validation);
                    return;
                }

                $ok = $this->autoUpdateOfcMultiDag($dist_code, $subdiv_code, $cir_code, $lot_no, $vill_townprt_code, $mouza_pargona_code, $petition_no, $pet_dag->dag_no);
                
                if ($ok != true)
                {
                    $validation['chitha_order_basic'] = '107'; // updation failed in sro_note
                    $this->db->trans_rollback();
                    log_message("error"," #MULOMAUTO001 could not auto update chitha district: ".$dist_code.", petition_no: ". $petition_no);            
                    echo json_encode($validation);
                    return;
                } 
                
            }

            $update = "UPDATE petition_basic SET status = 'F', date_of_order='$date' WHERE 
            case_no=? and $append";
            $update_pet_status = $this->db->query($update, array($case_no));
            if($this->db->affected_rows() != 1)
            {
                $validation['pet_status'] = '105'; // updation failed in petition_basic
                $this->db->trans_rollback();
                log_message("error"," #MULOMPB002 could not update Final petition_basic
                    district: ".$dist_code.", petition_no: ". $petition_no);
                return;
            }

            //ESCALATION CODE INTEGRATION================SANMRI
            $query1 = $this->db->query("SELECT es_flag FROM petition_basic WHERE petition_no=? and $append",array($petition_no))->row();
            $user_code = $this->session->userdata('user_code');
            if($query1->es_flag == 1 && ESCALATION_ENABLE ==1){

                $executionDate = $this->input->post('executionDate');

                $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
                $serviceType = explode('/',$basundhara);
                $service_code =1;
                if($serviceType[1] == 'MUTD')
                {
                    $service_code = 2;
                }

                $escalationUpdateStatus = $this->Escalationmodel->escalationFinalOrderCO($service_code,$executionDate,$dist_code,$subdiv_code,$cir_code,$case_no,$user_code);
                log_message("error", "#ESC4788, transaction-error-STATUS======".json_encode($escalationUpdateStatus));

                if($escalationUpdateStatus['responseType'] == 0){
                    $this->db->trans_rollback();
                    log_message("error", "#ESC4788, transaction-error in method 'officemutation/finalorderCOMain' with case-no :". $case_no);
                    $this->session->set_flashdata('message', "Something went wrong.OMUT- Error Code(#ESC4788)");
                    redirect(base_url() . "index.php/home");
                }
            }
            ///////////////END ESCALATION//////////////

            

           
           
            // $validation=array(
            //     'success'=>true,
            //     'redirect_url'=>base_url().'index.php/home'
            // );
            if ($ok) 
            {
                $save_chain_data =true;
                if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                {
                    ///////////////////////////////////////////////////////////////////////////
                    //////////////////////Property chain code /////////////////////////////////
                    ///////////////////////////////////////////////////////////////////////////
                    $this->load->model('propChain/PropChainModel');
                    $ulpin = $this->input->post('ulpin', true);
                    $revenue = $this->input->post('chain_revenue', true);
                    $local_tax = $this->input->post('chain_local_tax', true);
                    $old_ulpin = $this->input->post('old_ulpin', true);

                    if (!isset($old_ulpin)) {
                        $old_ulpin = "";
                    }

                    $ulpinFlag = $this->input->post('ulpinCheckFlag', true);
                    $compareFlag = $this->input->post('compareCheckFlag', true);
                    if($compareFlag == 'Y' && $ulpinFlag ==1)
                    {

                        $type = LOC_TYPE_RURAL;
                        $patta_no = $this->input->post('patta_no');
                        $patta_type_code = $this->input->post('patta_type_code');
                        $location_id = $dist_code . $subdiv_code . $cir_code . $mouza_pargona_code . $lot_no . $vill_townprt_code;

                        $property_id = $this->blockchainutilityclass->generatePropertyId($type, $vill_townprt_code, $patta_no, $dag_no, $ulpin);
                        $reference_id = $case_no;

                        $certmnemonic = CERTMNEMONIC_MUT;

                        $property_signature = "base64 encoded signature";
                        $property_signer_key = "base64 encoded public key";
                        $office_code = $this->session->userdata('cir_code');
                        $user_code = $this->session->userdata('user_code');

                        // mutated land area
                        // $mutated_bigha = $this->input->post('mut_b');
                        // $mutated_katha = $this->input->post('mut_k');
                        // $mutated_lessa = $this->input->post('mut_lc');
                        // $mutated_ganda = $this->input->post('mut_g');

                        // total land area
                        $land_area = $this->PropChainModel->getLandArea($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no);

                        $bigha_chain = $land_area->dag_area_b;
                        $katha_chain = $land_area->dag_area_k;
                        $lessa_chain = $land_area->dag_area_lc;
                        $ganda_chain = $land_area->dag_area_g;

                        $land_class_code_query = "select land_class_code from chitha_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and patta_no='$patta_no' and dag_no='$dag_no'";

                        $land_class_code = $this->db->query($land_class_code_query)->row()->land_class_code;

                        $pattadar_details = $this->PropChainModel->getPattadars($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no);


                        // since the below parameters are not applicable assign the empty string
                        $new_patta_no = $new_dag_no = $old_revenue = $old_local_tax = $old_land_class_code  = $new_bigha = $new_katha = $new_lessa = $new_ganda = "";

                        $update_params = array(
                            'pattadar_details' => $pattadar_details,
                            'location_id' => $location_id,
                            'property_id' => $property_id,
                            'reference_id' => $reference_id,
                            'dag_no' => $dag_no,
                            'patta_no' => $patta_no,
                            'patta_type_code' => $patta_type_code,
                            'land_class_code' => $land_class_code,
                            'bigha_chain' => $bigha_chain,
                            'katha_chain' => $katha_chain,
                            'lessa_chain' => $lessa_chain,
                            'ganda_chain' => $ganda_chain,
                            'certmnemonic' => $certmnemonic,
                            'property_signature' => $property_signature,
                            'property_signer_key' => $property_signer_key,
                            'office_code' => $office_code,
                            'user_code' => $user_code,
                            'ulpin' => $ulpin,
                            'old_ulpin' => $old_ulpin,
                            'revenue' => $revenue,
                            'local_tax' => $local_tax,
                            'new_patta_no' => $new_patta_no,
                            'new_dag_no' => $new_dag_no,
                            'old_revenue' => $old_revenue,
                            'old_local_tax' => $old_local_tax,
                            'old_land_class_code' => $old_land_class_code,
                            'new_bigha' => $new_bigha,
                            'new_katha' => $new_katha,
                            'new_lessa' => $new_lessa,
                            'new_ganda' => $new_ganda
                        );

                        $chain_send_data = $this->blockchainutilityclass->getUpdateChainArrayN((object)$update_params);

                        ///////////////////////////////// call chain update api ///////////////////////////////

                        $save_chain_data = $this->PropChainModel->save_chain_data(json_encode($chain_send_data), $case_no);
                    }
                }
                if($save_chain_data)
                {
                    $update_array = [
                                        'applId' => $pet_basic->applid,
                                        'application_ref_no' => $pet_basic->application_ref_no,
                                        'msg' => "Delivered",
                                        'status' => "D",
                                    ];
                    $url = RTPS_LINK."/mutation/mutation_response.php";

                    $this->db->trans_commit();
                    
                    $result = sendCurlRequest($url, 'POST', $update_array);
                    $this->session->set_flashdata(array('message' => "Order Passed for Case # $case_no"));
                    $this->session->set_flashdata(array('message2' => "Chitha Updated for Case # $case_no\ and Dag # (" . implode(', ', $dag_no) . ")."));

                        ////////
                    $this->DashboardDataFinal($case_no);
                    $basundhara = $this->basundharamodel->checkExistBasundhar($case_no);
                    if($basundhara){
                        $rmk='Final Order Passed';
                        $status='F';
                        $task='CO';
                        $pen='NA';
                        $case=$case_no;
                        $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
                    }
                        ////////////////////////////////////
                        /////////for jb////////////
                    $pa_no=$t_chitha_rmk_infavor_of['patta_no'];
                    $pt_code=$t_chitha_rmk_infavor_of['patta_type_code'];
                        /////////////////////
                    $location = array(
                        'd'=> $dist_code,
                        's' => $subdiv_code,
                        'c' => $cir_code,
                        'm' => $mouza_pargona_code,
                        'l' => $lot_no,
                        'v' => $vill_townprt_code,
                    );
                        //var_dump($location);
                    $this->session->set_userdata('case_no',$case_no); 
                    $this->session->set_userdata('patta_no',$pa_no);
                    $this->session->set_userdata('patta_type_code',$pt_code);
                    $this->session->set_userdata(array('loc' => $location));
                    if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                    {
                        if($ulpinFlag == 1 && $compareFlag == 'Y')
                        {
                            log_message('error',"MB4708 : BLOCK CHAIN Insertion===============");
                            $chain_update_status = 1;
                            $chain_create_status = 2;
                            $validation = array(
                                'success' => true,
                                'redirect_url' => base_url() . 'index.php/JamaBandi/step3/' .$pa_no .'/'. $pt_code.'/'.urlencode(base64_encode($case_no))
                            );
                            echo json_encode($validation);
                            return;
                        }
                        
                    }
                    $validation=array(
                        'success'=>true,
                        'redirect_url'=>base_url().'index.php/JamaBandi/step3/' .$pa_no .'/'. $pt_code);
                    echo json_encode($validation);
                    return;

                }
                elseif (!$save_chain_data) {
                    $validation['chain_status'] = 0;
                    $this->db->trans_rollback();
                    log_message('error', "Data not saved in table prop_chain_sent_data. Error code: #CHAINSAVEERROR0001");
                    return;
                } else {
                    $validation['chain_status'] = null;
                    $this->db->trans_rollback();
                    log_message("error", "#CHAINSAVEERROR0002 : Error occured. Property Chain updation for Case No $case_no Not Successfull.");
                    echo json_encode($validation);
                    return;
                }
                    
            }
            echo json_encode($validation);
        }
    }

    private function autoUpdateOfcMultiDag($dist_code, $subdiv_code, $cir_code, $lot_no, $vill_code, $mouza_pargona_code, $petition_no, $dag_no)
    {
        // $db=  $this->session->userdata('db');
        // $this->db->trans_begin();
        $record_count = 0;

        $patta_no = "";
        $locationData = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_code,
            'mouza_pargona_code' => $mouza_pargona_code,
        );

        $q = "select max(ord_cron_no)+1 as c1,max(rmk_type_hist_no)+1 as c2 from    chitha_rmk_ordbasic where"
        . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
        . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and mouza_pargona_code='$mouza_pargona_code'";

        $ord_cron_no = $this->db->query($q)->row()->c1;
        $q = "select max(rmk_type_hist_no)+1 as c2 from    chitha_rmk_gen where"
        . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
        . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and mouza_pargona_code='$mouza_pargona_code'";
        $rmk_type_hist_no = $this->db->query($q)->row()->c2;

        if ($ord_cron_no == null) {
            $ord_cron_no = 1;
        }
        if ($rmk_type_hist_no == null) {
            $rmk_type_hist_no = 1;
        }
        $order_query = "select * from    t_chitha_rmk_ordbasic where "
        . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
        . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and ord_type_code='03' and mouza_pargona_code='$mouza_pargona_code' and dag_no='$dag_no' and iscorrected_inco is null  and petition_no=$petition_no ";
        $orders = $this->db->query($order_query);
        if ($orders == null || $orders->num_rows()<=0)
        {
            $this->db->trans_rollback();
            log_message("error"," #OMAUTO003 could not get t_chitha_rmk_ordbasic data 
             district: ".$dist_code.", petition_no: ". $petition_no);
            return false;
        }

        $orders = $orders->result();
        log_message('error', '##### orders => ' . json_encode($orders));
        $case_no = null;
        foreach ($orders as $order) {
            $case_no = $order->ord_no;
                //copy alongwith information from    transaction to chitha
            $record_count++;

            $alongwith_q = "select * from    t_chitha_rmk_alongwith where ord_no='$order->ord_no' and dag_no='$dag_no'";
            $alongwith_d = $this->db->query($alongwith_q);
            $alongwith_d_count = $alongwith_d->num_rows();
            

            $inplace_q = "select * from    t_chitha_rmk_inplace_of where ord_no='$order->ord_no' and dag_no='$dag_no'";
            $inplace_d = $this->db->query($inplace_q);
            $inplace_d_count = $inplace_d->num_rows();
            log_message('error', '##### t_chitha_rmk_inplace_of => ' . json_encode($inplace_d->result()));            

            if ($alongwith_d_count <=0 && $inplace_d_count <=0)
            {
                $this->db->trans_rollback();
                log_message("error"," #OMAUTO005 inplace/alongwih data not found 
                    district: ".$dist_code.", petition_no: ". $petition_no);
                return false;
            }
            $alongwith_d = $alongwith_d->result();
            $inplace_d= $inplace_d->result();


            foreach ($alongwith_d as $along) {
                $ord_cron_no = $ord_cron_no;
                unset($along->year_no);
                unset($along->petition_no);
                unset($along->iscorrected_inco);
                unset($along->iscorrected_inco_date);
                unset($along->iscorrected_rkg_record);
                unset($along->iscorrected_rkg_date);
                unset($along->make_mdb);
                $along->rmk_type_hist_no = $rmk_type_hist_no;
                $along->ord_cron_no = $ord_cron_no;
                $along->user_code = $this->user_code;
                $along->operation = 'E';
                $along->date_entry = date('Y-m-d G:i:s');
                //var_dump($along);
                $tstatus1 = $this->db->insert("chitha_rmk_alongwith", $along); //*****************
                if ($tstatus1 != 1)
                {
                    $this->db->trans_rollback();
                    log_message("error"," #OMAUTO004 could not insert t_chitha_rmk_alongwith
                        district: ".$dist_code.", petition_no: ". $petition_no);
                    return false;
                }
            }            

            foreach ($inplace_d as $inplace) {
                $petition_no = $inplace->petition_no;
                $ord_cron_no = $ord_cron_no;
                unset($inplace->year_no);
                unset($inplace->petition_no);
                unset($inplace->iscorrected_inco);
                unset($inplace->iscorrected_inco_date);
                unset($inplace->iscorrected_rkg_record);
                unset($inplace->iscorrected_rkg_date);
                unset($inplace->make_mdb);

                $inplace->rmk_type_hist_no = $rmk_type_hist_no;
                $inplace->ord_cron_no = $ord_cron_no;
                $inplace->user_code = $this->user_code;
                $inplace->operation = 'E';
                $inplace->date_entry = date('Y-m-d G:i:s');
                //var_dump($inplace);

                $tstatus2 = $this->db->insert("chitha_rmk_inplace_of", $inplace); //**************
                if ($tstatus2 != 1)
                {
                    $this->db->trans_rollback();
                    log_message("error"," #OMAUTO005 could not insert t_chitha_rmk_inplace_of
                        district: ".$dist_code.", petition_no: ". $petition_no);
                    return false;
                }

                  $details = $this->db->query("select * from    petition_dag_details where petition_no=$petition_no and dag_no='$dag_no' and $this->base_query")->row();

                //   $update_query = "update  chitha_dag_pattadar set p_flag='1' where "
                //   . " dist_code ='$inplace->dist_code' and subdiv_code='$inplace->subdiv_code' and "
                //   . " cir_code ='$inplace->cir_code' and mouza_pargona_code='$inplace->mouza_pargona_code' and"
                //   . " lot_no='$inplace->lot_no' and vill_townprt_code='$inplace->vill_townprt_code' and"
                //   . " TRIM(patta_no)=trim('$details->patta_no') and dag_no='$details->dag_no' and patta_type_code='$details->patta_type_code' "
                //   . " and pdar_id=$inplace->pdar_id ";
                //     //echo $update_query;;
                //   $patta_no = trim($details->patta_no);
                //   $this->db->query($update_query);
                $table = 'chitha_dag_pattadar';

                $params = [
                    'p_flag' => '1',
                ];

                $where = [
                    'dist_code'          => $inplace->dist_code,
                    'subdiv_code'        => $inplace->subdiv_code,
                    'cir_code'           => $inplace->cir_code,
                    'mouza_pargona_code' => $inplace->mouza_pargona_code,
                    'lot_no'             => $inplace->lot_no,
                    'vill_townprt_code'  => $inplace->vill_townprt_code,
                    'dag_no'             => $details->dag_no,
                    'patta_type_code'    => $details->patta_type_code,
                    'pdar_id'            => $inplace->pdar_id,
                    'patta_no'           => trim($details->patta_no),
                ];

                $result = $this->Chitha_basic_model->update_table($table, $params, $where);

                  log_message('error',$this->db->last_query());
                  if ($result <=0)
                  {
                      $this->db->trans_rollback();
                      log_message("error"," #MULOMAUTO006 could not update chitha_dag_pattadar
                         district: ".$dist_code.", petition_no: ". $petition_no);
                        log_message('error', '#MULOMAUTO006 Last query => ' . $this->db->last_query());
                      return false;
                  }
            }

            $infavour_q = "select * from  t_chitha_rmk_infavor_of where ord_no='$order->ord_no' and dag_no='$dag_no'";
            $infavour_d = $this->db->query($infavour_q);
            if ($infavour_d == null || $infavour_d->num_rows() <=0)
            {
                 $this->db->trans_rollback();
                 log_message("error"," #MULOMAUTO007 could not find data in t_chitha_rmk_infavor_of
                    district: ".$dist_code.", petition_no: ". $petition_no);
                 return false;
            }
            $infavour_d = $infavour_d->result();
            $is_pdar_id_set=FALSE;
            foreach ($infavour_d as $infavour) {
                $infavour->user_code = $this->user_code;
                $infavour->operation = 'E';
                $infavour->rmk_type_hist_no = $rmk_type_hist_no;
                $infavour->ord_cron_no = $ord_cron_no;
                $infavour->date_entry = date('Y-m-d G:i:s');
                unset($infavour->year_no);
                unset($infavour->petition_no);
                unset($infavour->iscorrected_inco);
                unset($infavour->iscorrected_inco_date);
                unset($infavour->iscorrected_rkg_record);
                unset($infavour->iscorrected_rkg_date);
                unset($infavour->make_mdb);
                unset($infavour->pdar_id);
                unset($infavour->revenue);
                unset($infavour->infavor_is_copdar);
                $new_pattadar = $infavour->new_pattadar;
                unset($infavour->new_pattadar);
                    //var_dump($infavour);
                    //save new pattadar in infavour of
                $this->db->insert("chitha_rmk_infavor_of", $infavour);

                $newObj = clone $infavour;
                $pattadar = array();
                $pattadar = array_merge($pattadar, $locationData);
                unset($pattadar['application_no']);

                $org_patta_no=$infavour->patta_no;
                $org_patta_type_code=$infavour->patta_type_code;
                if($is_pdar_id_set==FALSE){
                    $pattadars_in_chitha_pattadar = $this->db->query("select max(pdar_id::int)+1 as cp from chitha_pattadar where dist_code='$dist_code' and "
                        . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
                        . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$org_patta_type_code' and TRIM(patta_no)=trim('$org_patta_no')")->row()->cp;

                    $pattadars_in_jama_pattadar = $this->db->query("select max(pdar_id::int)+1 as jp from jama_pattadar where dist_code='$dist_code' and "
                        . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
                        . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$org_patta_type_code' and TRIM(patta_no)=trim('$org_patta_no')")->row()->jp;
                    $pattadars_in_chithaDag_pattadar = $this->db->query("select max(pdar_id::int)+1 as dp from chitha_dag_pattadar where dist_code='$dist_code' and "
                        . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and"
                        . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_type_code='$org_patta_type_code' and TRIM(patta_no)=trim('$org_patta_no') and dag_no='$dag_no'")->row()->dp;
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
                    if ($pdar_id == null) {
                        $pdar_id = 1;
                    }
                    $is_pdar_id_set=TRUE;
                }else{
                    $pdar_id = $pdar_id+1;
                }
                    // $pdar_id_query = "select max(cast(pdar_id as int))+1 as pdar_id from    chitha_pattadar  where "
                    //         . " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and"
                    //         . " lot_no='$lot_no' and vill_townprt_code='$vill_code' and mouza_pargona_code='$mouza_pargona_code' "
                    //         . " and TRIM(patta_no)=trim('$infavour->patta_no') and patta_type_code='$infavour->patta_type_code'";
                    // $pdar_id = $this->db->query($pdar_id_query)->row()->pdar_id;

                    // //echo $pdar_id_query;
                    // if ($pdar_id == null) {
                    //     $pdar_id = 1;
                    // }


                //newly added aadhaar details to chitha pattadar----10052023
                $flagAadhaar = null;
                $flagPan = null;
                if($infavour->auth_type == 'AADHAAR'){
                    $pdar_aadharno = $infavour->id_ref_no;
                    $flagAadhaar = $infavour->id_ref_no;
                    $flagPan = null;
                }else if($infavour->auth_type == 'PAN'){
                    $pdar_pan_no = $infavour->id_ref_no;
                    $flagAadhaar = null;
                    $flagPan = $infavour->id_ref_no;
                }

                $pdar_photo = $infavour->photo;
                $other_data = array(
                    'pdar_id' => $pdar_id,
                    'patta_no' => trim($infavour->patta_no),
                    'patta_type_code' => $infavour->patta_type_code,
                    'pdar_name' => $infavour->infavor_of_name,
                    'pdar_father' => $infavour->infavor_of_guardian,
                    'pdar_add1' => $infavour->infavor_of_add1,
                    'pdar_add2' => $infavour->infavor_of_add2,
                    'pdar_add3' => "",
                    'user_code' => $infavour->user_code,
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'E',
                    'jama_yn' => 'n',
                    'pdar_guard_reln' => $infavour->infav_of_guar_relation,
                    'new_pdar_name' => $new_pattadar,
                    'pdar_aadharno' => $flagAadhaar,
                    'pdar_pan_no'   => $flagPan,
                    'pdar_photo'    => $pdar_photo,
                    'pdar_name_eng' => $infavour->pdar_name_eng,
                    'pdar_guard_eng' => $infavour->pdar_guard_eng,
                );

                $details = $this->db->query("select * from    petition_dag_details where petition_no=$petition_no and dag_no='$dag_no' and $this->base_query")->row();
                $patta_no = trim($details->patta_no);
                $pattadar = array_merge($pattadar, $other_data);

                $pattadar['f1_case_no']=$case_no;

                // $tstatus4 = $this->db->insert("chitha_pattadar", $pattadar);
                $tstatus4 = $this->Chitha_basic_model->insert_table('chitha_pattadar',$pattadar);
                if ($tstatus4 != 1)
                {
                    $this->db->trans_rollback();
                    log_message("error"," #MULOMAUTO008 could not insert chitha_pattadar
                        district: ".$dist_code.", petition_no: ". $petition_no);
                    return false;
                }

                $dag_pattadar = array();
                $dag_pattadar = array_merge($dag_pattadar, $locationData);
                unset($dag_pattadar['application_no']);

                $dag_pattadar_other = array(
                    'pdar_id' => $pdar_id,
                    'patta_no' => trim($infavour->patta_no),
                    'patta_type_code' => $infavour->patta_type_code,
                    'dag_por_b' => $infavour->land_area_b,
                    'dag_por_k' => $infavour->land_area_k,
                    'dag_por_lc' => $infavour->land_area_lc,
                    'dag_por_g' => $infavour->land_area_g,
                    'dag_por_kr' => $infavour->land_area_kr,
                    'user_code' => $this->user_code,
                    'date_entry' => date('Y-m-d G:i:s'),
                    'operation' => 'E',
                    'jama_yn' => 'n',
                    'dag_no' => $infavour->dag_no,
                    'p_flag' => 0,
                );
                $dag_pattadar = array_merge($dag_pattadar, $dag_pattadar_other);
                // $tstatus5 = $this->db->insert("chitha_dag_pattadar", $dag_pattadar);
                $tstatus5 = $this->Chitha_basic_model->insert_table('chitha_dag_pattadar',$dag_pattadar);
                if ($tstatus5 != 1)
                {
                    $this->db->trans_rollback();
                    log_message("error"," #OMAUTO009 could not insert chitha_dag_pattadar
                        district: ".$dist_code.", petition_no: ". $petition_no);
                    return false;
                }

                // $q = "update  chitha_basic set jama_yn=null where dist_code='$dist_code' and subdiv_code='$subdiv_code' and "
                // . "cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and "
                // . "lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$infavour->dag_no' and TRIM(patta_no)=trim('$infavour->patta_no')";

                // $this->db->query($q);

                $table = "chitha_basic";

                $params = [
                    'jama_yn' => null
                ];

                $where = [
                    'dist_code'          => $dist_code,
                    'subdiv_code'        => $subdiv_code,
                    'cir_code'           => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no'             => $lot_no,
                    'vill_townprt_code'  => $vill_code,
                    'dag_no'             => $infavour->dag_no,
                    'patta_no'           => trim($infavour->patta_no)  // handles TRIM(patta_no)=trim(...)
                ];

                $result1 = $this->Chitha_basic_model->update_table($table, $params, $where);

                if ($result1 <=0)
                {
                    $this->db->trans_rollback();
                    log_message("error"," #OMAUTO010 could not update chitha_basic
                        district: ".$dist_code.", petition_no: ". $petition_no);
                    return false;
                }
            }

            $order->user_code = $this->user_code;
            $order->date_entry = date('Y-m-d G:i:s');
            $order->operation = 'E';
            $order->user_code = $this->user_code;
                //var_dump($order);
            unset($order->year_no);
            unset($order->petition_no);
            unset($order->year_no);
            unset($order->iscorrected_inco);
            unset($order->iscorrected_inco_date);
            unset($order->iscorrected_rkg_record);
            unset($order->iscorrected_rkg_date);
            unset($order->isdataposted_torkg_db);
            unset($order->isorder_cancelled);
            unset($order->ifyes_reason1);
            unset($order->ifyes_reason2);
            unset($order->ifyes_reason3);
            unset($order->ifyes_reason4);
            unset($order->make_mdb);
            unset($order->min_revenue);
            unset($order->make_mdb);

            $rmk_gen = array(
                'dag_no' => $dag_no,
                'rmk_type_code' => '01',
                'rmk_type_hist_no' => $rmk_type_hist_no,
                'user_code' => $this->user_code,
                'date_entry' => date('Y-m-d G:i:s'),
                'operation' => 'E',
                'jama_updated' => 'N',
                'patta_no' => trim($patta_no)
            );
            $rmk_gen = array_merge($locationData, $rmk_gen);
            unset($rmk_gen['application_no']);

            $tstatus6 = $this->db->insert("chitha_rmk_gen", $rmk_gen);
            if ($tstatus6 != 1)
            {
                $this->db->trans_rollback();
                log_message("error"," #MULOMAUTO011 could not insert chitha_rmk_gen
                    district: ".$dist_code.", petition_no: ". $petition_no);
                return false;
            }

            $order->ord_cron_no = $ord_cron_no;
            $order->rmk_type_hist_no = $rmk_type_hist_no;
                        //var_dump($rmk_gen);
            $tstatus7 = $this->db->insert("chitha_rmk_ordbasic", $order);
            if ($tstatus7 != 1)
            {
                $this->db->trans_rollback();
                log_message("error"," #MULOMAUTO012 could not insert chitha_rmk_ordbasic
                    district: ".$dist_code.", petition_no: ". $petition_no);
                return false;
            }

            $q = "update  t_chitha_rmk_ordbasic set iscorrected_inco='Y' where ord_no='$order->ord_no'";
            $this->db->query($q);
            if ($this->db->affected_rows() <=0)
            {
                $this->db->trans_rollback();
                log_message("error"," #MULOMAUTO013 could not update t_chitha_rmk_ordbasic
                    district: ".$dist_code.", petition_no: ". $petition_no);
                return false;
            }
            $rmk_type_hist_no++;
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {            
            return true;
        }
    }

    public function ViewReviveList() {
       ini_set('memory_limit', '-1');
       // $this->dbswitch();
        $proceeding_id = $this->input->get('id');
        if (!$proceeding_id) {
           $proceeding_id = 1;
       }
       $append=$this->base_query;

       if ($proceeding_id == 1) {
            $villageListNew = array();
            $villageList = $this->mutationmodel->getAllDistinctVillageList($append);
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
           // var_dump($uniqueMouzaList);die;
           //old code---------
           // $query="select distinct on (case_no) *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where fmb.status is null AND fmb.comp_serv_yn is null and fmb.not_fresh is null "
           // . "and fmb.lm_note_yn is null and fmb.mut_type='03' and ".$append." ";
           //-----------
         // $query = "select * from petition_basic where status is null and not_fresh is null "
         // . "and lm_note_yn is null and mut_type='03' and ".$append." order by date_entry desc";

       } else if ($proceeding_id == 2) {
            $villageList = $this->mutationmodel->getAllDistinctVillageListCaseSecond($append);
            $newMouzaList = array();
                foreach ($villageList as $key => $value) {
                    $newMouzaList[$key]['mouza_code'] = $value->mouza_pargona_code;
                    $newMouzaList[$key]['mouza_name'] = $this->utilityclass->getMouzaName($value->dist_code,$value->subdiv_code,$value->cir_code,$value->mouza_pargona_code);
                    $newMouzaList[$key]['lot_name'] = $this->utilityclass->getLotName($value->dist_code,$value->subdiv_code,$value->cir_code,$value->mouza_pargona_code,$value->lot_no);
                    $newMouzaList[$key]['lot_no'] = $value->lot_no;
            }
           
           $uniqueMouzaList = array_map("unserialize", array_unique(array_map("serialize", $newMouzaList)));
           $data['newMouzaList'] = $uniqueMouzaList;
            $query="select distinct on (case_no) *,ba.basundhara from petition_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where  fmb.not_fresh='Y' AND fmb.comp_serv_yn is null and "
            . " fmb.status='P' and fmb.mut_type='03' and ".$append." ";
             // $query = "select * from petition_basic where not_fresh='Y' and "
             // . " status='P' and mut_type='03' and ".$append." order by date_entry desc";
            $data['cases'] = $this->db->query($query)->result();
        }
        
        // var_dump($data['cases']);
        // exit;
             //var_dump($data);
        $data['proceeding_id'] = $proceeding_id;
        $resume_query = "SELECT * from Petition_basic WHERE  status='F' AND comp_serv_yn is null and order_passed is null and ".$append."  order by date_entry desc";
        $data['resume'] = $this->db->query($resume_query)->result();

        $data['_view'] = 'officemutation/cases_revive';
        $this->load->view('layouts/main',$data);
    }

    function reviveCaseNo(){
        $case_no = $this->input->get('case_no');
        // $data['_view'] = 'comutation/revertback';
        $data['_view'] = 'comutation/revivecaseview';
        $this->load->view('layouts/main',$data);
    }

    function reviveCaseUpdate()
    {
            
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code=$this->session->userdata('user_code');
            /////////////
        $rmk=addslashes(trim($_POST['co_order']));
        $coname=$this->utilityclass->getSelectedCOName($dist_code,$subdiv_code,$cir_code,$user_code);
        $rmk=$rmk . "  চক্র বিষয়া : " . $coname->username; 
        $case_no=$_POST['case_no'];
	$revert_back=$_POST['revert_back'];
	if($case_no != 'MET/GUW/2023-24/20240014228/OMUT')
	{
	    $this->session->set_flashdata('message',"Access Denied...");
            redirect('/home');
	}
        
        $update_petition_basic=array(
            'status' => 'P',
            'order_passed' => null,
            'date_of_order' => null,
        );
        $basundharaExist=$this->basundharamodel->checkExistBasundhar($case_no);
        if($basundharaExist){
            //proceding insertion-==============
            // $this->db->trans_begin();
            $this->basundharamodel->insertproceeding($case_no,$rmk);
            //$this->db->where('case_no',$case_no);
            //$this->db->update('petition_basic',$update_petition_basic);
            //if($this->db->affected_rows() != 1)
           // {
             //   $this->session->set_flashdata('message',"Something went wrong");
               // redirect('/home');
           // }

            //////////////POST To basundhara/////////////////////
            $application_no=$basundharaExist;
            $rmk=$rmk;
            $status='M';
            $task='CO';
            $case=$case_no;
            $this->basundharamodel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);

            $this->DashboardData($case_no,$pen,$rmk);
        }
        $this->session->set_flashdata('message',$case_no." have been Revived");
        redirect('/home');
    }

        function pushSroNgdrsOfc()
        {
            $dharitree=$this->input->get('case_no');
            $basundhara=$this->input->get('app');
            $this->db->trans_begin();
            $result=$this->mutationmodel->pushSroNgdrsApi();
            //var_dump($result);exit;
            $result = json_decode($result);
            if($result->status=='success'){
                $this->db->trans_commit();
                $this->session->set_flashdata('message',"Application Sent to SRO Office for Case no : ".$dharitree);
                redirect('coofficemutation/getPendingMutationCases?id=2');
            }else{
                $this->db->trans_rollback();
                $this->session->set_flashdata('message',"#SROPUSHERR10208 : Access unavailable. Please try after sometime");
                redirect('/home');  
            }    
        }

    
}