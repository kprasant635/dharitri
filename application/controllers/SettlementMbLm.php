<?php



class SettlementMbLm extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
            // Allowed designations
        $allowed = ['LM'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }
        $this->load->model('basundhara/SettlementApiModel');
        $this->load->model('SettlementModel/SettlementKhasModel');
        $this->load->model('UtilsModel');

        $location = $this->utilityclass->getLocationFromSession();
        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];
        $define_date = define_date;
        $year_no = year_no;
        // $this->dbswitch();
        $this->append = " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and date_entry>='$define_date'";
        $this->base_query = " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";

        $this->user_code = $this->session->userdata('user_code');
        $this->load->helper(array('form', 'url', 'Language'));
        $this->load->library('form_validation');
        $this->load->model('basundhara/SettlementApiModel');

        $method = $this->router->fetch_method();

        if(!in_array($method, VERIFICATION_MODULE_METHODS))
        {
            if(HOLD_All_MB2_CASES_STATUS == 1)
            {
                if(strtotime(HOLD_All_MB2_CASES_DATE) < strtotime(date('Y-m-d H:i:s')))
                {
                    $this->session->set_flashdata('message', " Processing of settlement MB 2.0 Cases has been stopped !");
                    redirect(base_url() . "index.php/Home/index");
                }
            }
        }


        
    }

    public function dbswitch()
    {
        //$CI=&get_instance();
        if ($this->session->userdata('dist_code') == "02") {
            $this->db = $this->load->database('dha3', true);
        } else if ($this->session->userdata('dist_code') == "05") {
            $this->db = $this->load->database('dha1', true);
        } else if ($this->session->userdata('dist_code') == "10") {
            $this->db = $this->load->database('dha24', true);
        } else if ($this->session->userdata('dist_code') == "13") {
            $this->db = $this->load->database('dha2', true);
        } else if ($this->session->userdata('dist_code') == "17") {
            $this->db = $this->load->database('dha4', true);
        } else if ($this->session->userdata('dist_code') == "15") {
            $this->db = $this->load->database('dha5', true);
        } else if ($this->session->userdata('dist_code') == "14") {
            $this->db = $this->load->database('dha6', true);
        } else if ($this->session->userdata('dist_code') == "07") {
            $this->db = $this->load->database('dha7', true);
        } else if ($this->session->userdata('dist_code') == "03") {
            $this->db = $this->load->database('dha8', true);
        } else if ($this->session->userdata('dist_code') == "18") {
            $this->db = $this->load->database('dha9', true);
        } else if ($this->session->userdata('dist_code') == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($this->session->userdata('dist_code') == "24") {
            $this->db = $this->load->database('dha10', true);
        } else if ($this->session->userdata('dist_code') == "06") {
            $this->db = $this->load->database('dha11', true);
        } else if ($this->session->userdata('dist_code') == "11") {
            $this->db = $this->load->database('dha12', true);
        } else if ($this->session->userdata('dist_code') == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($this->session->userdata('dist_code') == "16") {
            $this->db = $this->load->database('dha14', true);
        } else if ($this->session->userdata('dist_code') == "32") {
            $this->db = $this->load->database('dha15', true);
        } else if ($this->session->userdata('dist_code') == "33") {
            $this->db = $this->load->database('dha16', true);
        } else if ($this->session->userdata('dist_code') == "34") {
            $this->db = $this->load->database('dha17', true);
        } else if ($this->session->userdata('dist_code') == "21") {
            $this->db = $this->load->database('dha18', true);
        } else if ($this->session->userdata('dist_code') == "08") {
            $this->db = $this->load->database('dha19', true);
        } else if ($this->session->userdata('dist_code') == "35") {
            $this->db = $this->load->database('dha20', true);
        } else if ($this->session->userdata('dist_code') == "36") {
            $this->db = $this->load->database('dha21', true);
        } else if ($this->session->userdata('dist_code') == "37") {
            $this->db = $this->load->database('dha22', true);
        } else if ($this->session->userdata('dist_code') == "25") {
            $this->db = $this->load->database('dha23', true);
        } else if ($this->session->userdata('dist_code') == "39") {
            $this->db = $this->load->database('dha39', true);
        } else if ($this->session->userdata('dist_code') == "38") {
            $this->db = $this->load->database('dha25', true);
        }
    }


    function revertedCases()
    {
        $service_code=$this->input->get('service');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $define_date = define_date;
        $user_code = $this->session->userdata('user_code');
        $cases['cases'] = $this->db->query("select *,ba.basundhara from settlement_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='R' and from_office='CO' and pending_officer='LM'  and date_entry >= '$define_date'")->result();
        
        // var_dump($cases['cases']); die();
        if (!empty($cases['cases'])){
            if($cases['cases'][0]->service_code=="13"){
                $cases['service_controller']="SettlementTenant";
            }else if($cases['cases'][0]->service_code=="14"){
                $cases['service_controller']="SettlementAp";
            }else if($cases['cases'][0]->service_code=="15"){
                $cases['service_controller']="SettlementTribal";
            }else if($cases['cases'][0]->service_code=="16"){
                $cases['service_controller']="SettlementKhasLand";
            }else if($cases['cases'][0]->service_code=="17"){
                $cases['service_controller']="SettlementVgr";
            }else if($cases['cases'][0]->service_code=="18"){
                $cases['service_controller']="SettlementCultivator";
            }else if($cases['cases'][0]->service_code=="42"){
                $cases['service_controller']="SettlementTenantUrban";
            }
        }
        
        
        
        $cases['_view'] = 'LmSettlementMb/revertedcases_mb_lm';
        $this->load->view('layouts/main', $cases);
    }

    function forwardedCasesByCo()
    {
        $service_code=$this->input->get('service');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $define_date = define_date;
        $user_code = $this->session->userdata('user_code');
        $cases['cases'] = $this->db->query("select *,ba.basundhara from settlement_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='Z' and from_office='CO' and pending_officer='LM'  and date_entry >= '$define_date'")->result();
        
        $cases['service_controller']="SettlementTenantUrban";
     
        $cases['_view'] = 'LmSettlementMb/forwarded_by_co_tenant_urban';
        $this->load->view('layouts/main', $cases);
    }

    function revertedCasesReview()
    {
        $service_code=$this->input->get('service');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $define_date = define_date;
        $user_code = $this->session->userdata('user_code');
        $cases['cases'] = $this->db->query("SELECT sb.* 
                                                FROM settlement_basic sb 
                                                JOIN (
                                                    SELECT MAX(review_flag) AS max_review_flag, case_no 
                                                    FROM settlement_basic 
                                                    GROUP BY case_no
                                                ) sbi 
                                                ON sb.case_no = sbi.case_no AND sb.review_flag = sbi.max_review_flag 
                                                WHERE sb.status = 'RA' 
                                                    AND sb.dist_code = '$dist_code' 
                                                    AND sb.subdiv_code = '$subdiv_code' 
                                                    AND sb.cir_code = '$cir_code' 
                                                    AND sb.mouza_pargona_code = '$mouza_pargona_code' 
                                                    AND sb.lot_no = '$lot_no' 
                                                    AND sb.service_code = '$service_code' 
                                                    AND sb.from_office = 'CO' 
                                                    AND sb.pending_officer = 'LM' 
                                                    AND sb.date_entry >= '$define_date'")->result();
        
        // var_dump($cases['cases']); die();
        if (!empty($cases['cases'])){
            if($cases['cases'][0]->service_code=="13"){
                $cases['service_controller']="SettlementTenant";
                $cases['service_method']="settlementTenantRegistration";

            }else if($cases['cases'][0]->service_code=="14"){
                $cases['service_controller']="SettlementAp";
                $cases['service_method']="settlementApplication";

            }else if($cases['cases'][0]->service_code=="15"){
                $cases['service_controller']="SettlementTribal";
                $cases['service_method']="TribalApplicationRegistration";

            }else if($cases['cases'][0]->service_code=="16"){
                $cases['service_controller']="SettlementKhasLand";
                $cases['service_method']="applicationKhaslandRegistration";

            }else if($cases['cases'][0]->service_code=="17"){
                $cases['service_controller']="SettlementVgr";
                $cases['service_method']="applicationVgrRegistration";

            }else if($cases['cases'][0]->service_code=="18"){
                $cases['service_controller']="SettlementCultivator";
                $cases['service_method']="settlementApplication";
            }
        }
        
        $cases['_view'] = 'LmSettlementMb/revertedcases_mb_lm_review';
        $this->load->view('layouts/main', $cases);
    }

    function nrCases()
    {
        $service_code=$this->input->get('service');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $define_date = define_date;
        $user_code = $this->session->userdata('user_code');
        $cases['cases'] = $this->db->query("select *,ba.basundhara from settlement_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='G' and (from_office='DPT' or from_office='DC')  and pending_officer='LM'  and date_entry >= '$define_date'")->result();
        // var_dump($cases['cases'][0]); die();
        if (!empty($cases['cases'])){
            if($cases['cases'][0]->service_code=="13"){
                $cases['service_controller']="SettlementTenant";
            }else if($cases['cases'][0]->service_code=="14"){
                $cases['service_controller']="SettlementAp";
            }else if($cases['cases'][0]->service_code=="15"){
                $cases['service_controller']="SettlementTribal";
            }else if($cases['cases'][0]->service_code=="16"){
                $cases['service_controller']="SettlementKhasLand";
            }else if($cases['cases'][0]->service_code=="17"){
                $cases['service_controller']="SettlementVgr";
            }else if($cases['cases'][0]->service_code=="18"){
                $cases['service_controller']="SettlementCultivator";
            }
        }
        
        
        
        $cases['_view'] = 'LmSettlementMb/nrcases_mb_lm';
        $this->load->view('layouts/main', $cases);
    }

    function apNoticeGeneratedCaseForLmReport()
    {
        $service_code=$this->input->get('service');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $define_date = define_date;
        $user_code = $this->session->userdata('user_code');
        $cases['cases'] = $this->db->query("select *,ba.basundhara from settlement_basic fmb left join basundhar_application ba on fmb.case_no=ba.dharitree where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and service_code='$service_code' and status='V' and from_office='CO' and pending_officer='LM'  and date_entry >= '$define_date'")->result();
        // var_dump($cases['cases'][0]); die();
        $cases['type'] ="LMREPORT";
        
        if (!empty($cases['cases'])){
            if($cases['cases'][0]->service_code=="14"){
                $cases['service_controller']="SettlementAp";
            }
        }
        
        $cases['_view'] = 'LmSettlementMb/nrcases_mb_lm';
        $this->load->view('layouts/main', $cases);
    }

    public function dbswitchmb2($district)
    {
        //$CI=&get_instance();
        if ($district == "02") {
            $this->db = $this->load->database('dha3', true);
        } else if ($district == "05") {
            $this->db = $this->load->database('dha1', true);
        } else if ($district == "10") {
            $this->db = $this->load->database('dha24', true);
        } else if ($district == "13") {
            $this->db = $this->load->database('dha2', true);
        } else if ($district == "17") {
            $this->db = $this->load->database('dha4', true);
        } else if ($district == "15") {
            $this->db = $this->load->database('dha5', true);
        } else if ($district == "14") {
            $this->db = $this->load->database('dha6', true);
        } else if ($district == "07") {
            $this->db = $this->load->database('dha7', true);
        } else if ($district == "03") {
            $this->db = $this->load->database('dha8', true);
        } else if ($district == "18") {
            $this->db = $this->load->database('dha9', true);
        } else if ($district == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($district == "24") {
            $this->db = $this->load->database('dha10', true);
        } else if ($district == "06") {
            $this->db = $this->load->database('dha11', true);
        } else if ($district == "11") {
            $this->db = $this->load->database('dha12', true);
        } else if ($district == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($district == "16") {
            $this->db = $this->load->database('dha14', true);
        } else if ($district == "32") {
            $this->db = $this->load->database('dha15', true);
        } else if ($district == "33") {
            $this->db = $this->load->database('dha16', true);
        } else if ($district == "34") {
            $this->db = $this->load->database('dha17', true);
        } else if ($district == "21") {
            $this->db = $this->load->database('dha18', true);
        } else if ($district == "08") {
            $this->db = $this->load->database('dha19', true);
        } else if ($district == "35") {
            $this->db = $this->load->database('dha20', true);
        } else if ($district == "36") {
            $this->db = $this->load->database('dha21', true);
        } else if ($district == "37") {
            $this->db = $this->load->database('dha22', true);
        } else if ($district == "25") {
            $this->db = $this->load->database('dha23', true);
        }
    }

    public function noticeGeneratedCases()
    {
        $data['service'] = $_GET['service'];

        $dist_code = $this->session->userdata('dist_code'); 
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');

        $getVillages = $this->db->query('select distinct on (dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no) * from settlement_basic where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ?', array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no));

        if($getVillages->num_rows() <= 0)
        {
            $villResult = false;
        }
        else
        {
            $villResult = $getVillages->result();
        }

        $data['selectList'] = $villResult;

        $data['_view'] = 'LmSettlementMb/final_verification_before_patta';
        $this->load->view('layouts/main', $data);
    }

    public function finalVerificationPagination()
    {
        $service = $this->input->post('service');

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');

        $searchByCol_0 = trim($this->input->post('columns')[0]['search']['value']);
        $searchByCol_1 = trim($this->input->post('columns')[1]['search']['value']);
        $searchByCol_2 = trim($this->input->post('columns')[2]['search']['value']);
        $searchByCol_3 = trim($this->input->post('columns')[3]['search']['value']);

        if (!empty($searchByCol_0)) 
        {
            $this->db->like('UPPER(applid)', $searchByCol_0);
        }

        if (!empty($searchByCol_1)) 
        {
            $this->db->like('UPPER(case_no)', $searchByCol_1);
        }

        if (!empty($searchByCol_2)) 
        {
            $this->db->where('vill_townprt_code', $searchByCol_2);
        }

        if (!empty($searchByCol_3)) 
        {
            $this->db->where('chitha_processing_details', $searchByCol_3);
        }

        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('mouza_pargona_code', $mouza_pargona_code);
        $this->db->where('lot_no', $lot_no);
        $this->db->where('status', 'N');
        $this->db->where('chitha_processing_details', 0);
        $this->db->where('service_code', $service);
        $this->db->limit($length, $start);
        $this->db->from('settlement_basic');
        $query = $this->db->get();

        $results = $query->result();

        if ($query->num_rows() > 0) 
        {
            foreach($results as $rows) 
            {

                if($rows->chitha_processing_details == 1)
                {
                    $verification_status = '<span class="text-success"><strong><small>Verified</small></strong></span>';
                    $verify_report_button = '';
                }
                else
                {
                    $verification_status = '<span class="text-danger"><strong><small>Not Verified</small></strong></span>';
                    $verify_report_button = '&nbsp;<button type="button" onclick="finalVerificationModal(\''.$rows->case_no.'\')" class="btn btn-sm btn-danger">Write Report</button>';
                }


                $view_link = '<a alt="View Application" class="text-white btn btn-sm btn-success" target="Application View" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>';

                $json[] = array(
                    '<span class="px-3"><strong>' . $rows->applid . '</strong></span>',
                    '<span class="px-3"><strong>' . $rows->case_no . '</strong></span>',

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    $verification_status,

                    $view_link.$verify_report_button,
                );
            }

            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('mouza_pargona_code', $mouza_pargona_code);
            $this->db->where('lot_no', $lot_no);
            $this->db->where('status', 'N');
            $this->db->where('chitha_processing_details', 0);
            $this->db->where('service_code', $service);
            $total_records = $this->db->count_all_results('settlement_basic');

            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json,
            );
            echo json_encode($response);

        } 
        else 
        {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }

    public function getSubdiv($district)
    {
        $this->dbswitchmb2($district);
        $subdiv = $this->db->query("select subdiv_code,cir_code,loc_name,locname_eng
        from location where dist_code='$district' and subdiv_code != '00' and cir_code='00' and  mouza_pargona_code='00' and
        vill_townprt_code='00000' and lot_no='00' order by loc_name ");

        $data = $subdiv->result();
        $json = array();
        foreach ($data as $object) {
            /*if (!(($district=='07' && $object->cir_code == '05' && $object->subdiv_code=='01')
            ||($district=='07' && $object->cir_code == '01' && $object->subdiv_code=='01')
            ||($district=='21' && $object->cir_code == '05' && $object->subdiv_code=='01')
            ))
            {
            continue;
            }*/
            $json[] = array('subdiv_code' => trim($object->subdiv_code), 'loc_name' => trim($object->loc_name), 'locname_eng' => trim($object->locname_eng));
        }
        //var_dump($json);
        echo json_encode($json);
        //$this->dbswitch();
    }


    public function getCircle($district, $subdiv)
    {
        $this->dbswitchmb2($district);
        $circle = $this->db->query("select subdiv_code,cir_code,loc_name,locname_eng
        from location where dist_code='$district' and subdiv_code = '$subdiv' and cir_code!='00' and  mouza_pargona_code='00' and
        vill_townprt_code='00000' and lot_no='00' order by loc_name ");

        $data = $circle->result();
        $json = array();
        foreach ($data as $object) {
            /*if (!(($district=='07' && $object->cir_code == '05' && $object->subdiv_code=='01')
            ||($district=='07' && $object->cir_code == '01' && $object->subdiv_code=='01')
            ||($district=='21' && $object->cir_code == '05' && $object->subdiv_code=='01')
            ))
            {
            continue;
            }*/
            $json[] = array('cir_code' => trim($object->cir_code), 'loc_name' => trim($object->loc_name), 'locname_eng' => trim($object->locname_eng));
        }
        //var_dump($json);
        echo json_encode($json);
        //$this->dbswitch();
    }

    public function getMouza($district, $subdiv, $circle)
    {
        $this->dbswitchmb2($district);
        $mouza = $this->db->query("select subdiv_code,cir_code, mouza_pargona_code, lot_no, vill_townprt_code, loc_name,locname_eng
        from location where dist_code='$district' and subdiv_code = '$subdiv' and cir_code='$circle' and  mouza_pargona_code!='00' and
        vill_townprt_code='00000' and lot_no='00' order by loc_name ");

        $data = $mouza->result();
        $json = array();
        foreach ($data as $object) {
            /*if (!(($district=='07' && $object->cir_code == '05' && $object->subdiv_code=='01')
            ||($district=='07' && $object->cir_code == '01' && $object->subdiv_code=='01')
            ||($district=='21' && $object->cir_code == '05' && $object->subdiv_code=='01')
            ))
            {
            continue;
            }*/
            $json[] = array('mouza_pargona_code' => trim($object->mouza_pargona_code), 'loc_name' => trim($object->loc_name), 'locname_eng' => trim($object->locname_eng));
        }
        //var_dump($json);
        echo json_encode($json);
        //$this->dbswitch();
    }

    public function getLot($district, $subdiv, $circle, $mouza)
    {
        $this->dbswitchmb2($district);
        $lot = $this->db->query("select subdiv_code,cir_code, mouza_pargona_code, lot_no, vill_townprt_code, loc_name,locname_eng
        from location where dist_code='$district' and subdiv_code = '$subdiv' and cir_code='$circle' and  mouza_pargona_code='$mouza' and vill_townprt_code='00000' and lot_no!='00' order by loc_name ");

        $data = $lot->result();
        $json = array();
        foreach ($data as $object) {
            /*if (!(($district=='07' && $object->cir_code == '05' && $object->subdiv_code=='01')
            ||($district=='07' && $object->cir_code == '01' && $object->subdiv_code=='01')
            ||($district=='21' && $object->cir_code == '05' && $object->subdiv_code=='01')
            ))
            {
            continue;
            }*/
            $json[] = array('lot_no' => trim($object->lot_no), 'loc_name' => trim($object->loc_name), 'locname_eng' => trim($object->locname_eng));
        }
        //var_dump($json);
        echo json_encode($json);
        //$this->dbswitch();
    }

    public function getVillage($district, $subdiv, $circle, $mouza, $lot)
    {
        $this->dbswitchmb2($district);
        $village = $this->db->query("select subdiv_code,cir_code, mouza_pargona_code, lot_no, vill_townprt_code, loc_name,locname_eng
        from location where dist_code='$district' and subdiv_code = '$subdiv' and cir_code='$circle' and  mouza_pargona_code='$mouza' and vill_townprt_code!='00000' and lot_no='$lot' order by loc_name ");

        $data = $village->result();
        $json = array();
        foreach ($data as $object) {
            /*if (!(($district=='07' && $object->cir_code == '05' && $object->subdiv_code=='01')
            ||($district=='07' && $object->cir_code == '01' && $object->subdiv_code=='01')
            ||($district=='21' && $object->cir_code == '05' && $object->subdiv_code=='01')
            ))
            {
            continue;
            }*/
            $json[] = array('vill_townprt_code' => trim($object->vill_townprt_code), 'loc_name' => trim($object->loc_name), 'locname_eng' => trim($object->locname_eng));
        }
        //var_dump($json);
        echo json_encode($json);
        //$this->dbswitch();
    }

    public function getAllDags($district, $subdiv, $circle, $mouza, $lot, $village)
    {

        $this->dbswitchmb2($district);

        $dag = $this->db->query("Select dag_no,dag_no_int from   chitha_Basic where "
            . "Dist_code='$district' and subdiv_code='$subdiv' and  cir_code='$circle'
        and mouza_Pargona_code='$mouza' and lot_No='$lot' "
            . "and vill_townprt_code='$village' order by dag_no_int");

        $data = $dag->result();
        $json = array();
        foreach ($data as $object) {
            $json[] = array(
                'dag_no' => trim($object->dag_no),
                'dag_no_int' => trim($object->dag_no_int),
            );
        }
        echo json_encode($json);
        //$this->dbswitch();
    }

    public function getFinalVerificationData()
    {
        $case_no = $this->input->post('case_no');
        $basicSql = $this->db->query('select * from settlement_basic where case_no = ?', array($case_no));

        if($basicSql->num_rows() <= 0)
        {
            log_message('error', '#ERR10263: No case number found!'. $this->db->last_query());
            echo json_encode([
                'responseType'  => 0,
                'msg'           => '#ERR10263: No case number found!'
            ]);
            return false;
        }

        $data['basicRow'] = $basicSql->row();

        if($data['basicRow']->chitha_processing_details == 1)
        {
            // log_message('error', '#ERR10273: No case number found!'. $this->db->last_query());
            echo json_encode([
                'responseType'  => 0,
                'msg'           => '#ERR10273: Verification report already submitted!'
            ]);
            return false;
        }

        $getDagsSql = $this->db->query('select * from settlement_dag_details where case_no = ?', array($case_no));

        if($getDagsSql->num_rows() <= 0)
        {
            log_message('error', '#ERR10285: Case not found in settlemnet_dag_details'. $this->db->last_query());
            echo json_encode([
                'responseType'  => 0,
                'msg'           => '#ERR10285: Dag details not found!'
            ]);
            return false;
        }

        $data['dagResult'] = $getDagsSql->result();

        foreach($data['dagResult'] as $dagRow)
        { 
            $dagRow->old_dag = $dagRow->dag_no;

            if($data['basicRow']->service_code == 14)
            {
                if(empty($dagRow->new_dag_no) || $dagRow->new_dag_no == null || $dagRow->new_dag_no == '')
                {
                    echo json_encode([
                        'responseType'  => 0,
                        'msg'           => '#ERR573: New Dag not found for NR case!'
                    ]);
                    return false;
                }

                $dagRow->dag_no = $dagRow->new_dag_no;
                $dagRow->patta_no = $dagRow->new_patta_no;
                $dagRow->patta_type_code = $dagRow->new_patta_type_code;
            }

            $landclass=$this->utilityclass->classCodeFromChitha($dagRow->dist_code,$dagRow->subdiv_code,$dagRow->cir_code,$dagRow->mouza_pargona_code,$dagRow->lot_no,$dagRow->vill_townprt_code,$dagRow->dag_no);
            if($landclass)
            {
                $className=$this->utilityclass->getLandClassCode($landclass);
            }

            $dagRow->old_class_name = $className;


            $premium_data_sql = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ? and dag_no = ?', array($case_no, '1', $dagRow->old_dag));

            if($premium_data_sql->num_rows() <= 0)
            {
                log_message('error', '#ERR10313: Case not found in settlement_premium'. $this->db->last_query());
                echo json_encode([
                    'responseType'  => 0,
                    'msg'           => '#ERR10313: Premium data not found!'
                ]);
                return false;
            }

            $premiumRow = $premium_data_sql->row();
            
            if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) 
            {
                $total_settlement_area = $this->utilityclass->Total_Bigha_Katha_Lessa2($premiumRow->total_lessa);

                $dagRow->final_settlement_area = 'B: '.$total_settlement_area[0].' K: '.$total_settlement_area[1].' C: '.$total_settlement_area[2]. ' G: '.$total_settlement_area[3];
            }
            else
            {
                $total_settlement_area = $this->utilityclass->Total_Bigha_Katha_Lessa($premiumRow->total_lessa);

                $dagRow->final_settlement_area = 'B: '.$total_settlement_area[0].' K: '.$total_settlement_area[1].' L: '.$total_settlement_area[2];
            }

            $landmark = json_decode($dagRow->landmark);

            $dagRow->landmark_entered = 'East - '. $landmark->east. ', West - ' .$landmark->west. ', North - '.$landmark->north. ', South - '.$landmark->south;

            //******reservation area details */
            $reservation = $this->db->query('select * from settlement_reservation where case_no = ? and type = ? and dag_no = ?', array($case_no, 'R', $dagRow->old_dag));

            if($reservation->num_rows() <= 0)
            {
                $dagRow->road_side_reservation = false;
            }
            else
            {
                $reservation = $reservation->result();

                foreach($reservation as $reservationRow)
                {
                    if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) 
                    {
                        $dagRow->road_side_reservation = 'B: '.$reservationRow->bigha.' K: '.$reservationRow->katha.' C: '.$reservationRow->lessa.' G: '.$reservationRow->ganda;
                    }
                    else
                    {
                        $dagRow->road_side_reservation = 'B: '.$reservationRow->bigha.' K: '.$reservationRow->katha.' L: '.$reservationRow->lessa;
                    }
                }
            }

            //********find out agri or home dag */

            $landType = 0;

            $home_b = $dagRow->home_b;  
            $home_k = $dagRow->home_k;  
            $home_lc = $dagRow->home_lc;  
            $home_g = $dagRow->home_g;

            $homestead = $home_b + $home_k + $home_lc + $home_g;

            if($homestead > 0)
            {
               $landType = 1; 
            }

            $agri_b = $dagRow->agri_b; 
            $agri_k = $dagRow->agri_k; 
            $agri_lc = $dagRow->agri_lc;
            $agri_g = $dagRow->agri_g;

            $agriculture = $agri_b + $agri_k + $agri_lc + $agri_g;

            if($agriculture > 0)
            {
               $landType = 2; 
            }

            if($homestead > 0 && $agriculture > 0)
            {
                $landType = 3; 
            }

            $dagRow->landTypeFinal = $landType;

        }

        $data['dist_array'] = [
            ['dist_code' => '24', 'dist_name' => 'কামৰূপ মহানগৰ ( Kamrup Metro )'],
            ['dist_code' => '12', 'dist_name' => 'লক্ষীমপূৰ ( Lakhimpur )'],
            ['dist_code' => '16', 'dist_name' => 'শিৱসাগৰ ( Sibsagar )'],
            ['dist_code' => '18', 'dist_name' => 'তিনিচুকীয়া ( Tinsukia )'],
            ['dist_code' => '34', 'dist_name' => 'মাজুলী ( Majuli )'],
            ['dist_code' => '37', 'dist_name' => 'চৰাইদেউ ( Charaideo )'],
            ['dist_code' => '11', 'dist_name' => 'শোণিতপুৰ ( Sonitpur )'],
            ['dist_code' => '25', 'dist_name' => 'ধেমাজি ( Dhemaji )'],
            ['dist_code' => '35', 'dist_name' => 'বিশ্বনাথ ( Biswanath )'],
            ['dist_code' => '03', 'dist_name' => 'গোৱালপাৰা ( Goalpara )'],
            ['dist_code' => '14', 'dist_name' => 'গোলাঘাট ( Golaghat )'],
            ['dist_code' => '13', 'dist_name' => 'বঙাইগাঁও ( Bongaigaon )'],
            ['dist_code' => '08', 'dist_name' => 'দৰং ( Darrang )'],
            ['dist_code' => '17', 'dist_name' => 'ডিব্ৰুগড় ( Dibrugarh )'],
            ['dist_code' => '36', 'dist_name' => 'হোজাই ( Hojai )'],
            ['dist_code' => '32', 'dist_name' => 'মৰিগাওঁ ( Morigaon )'],
            ['dist_code' => '39', 'dist_name' => 'বজালী ( Bajali )'],
            ['dist_code' => '15', 'dist_name' => 'যোৰহাট ( Jorhat )'],
            ['dist_code' => '21', 'dist_name' => 'করিমগঞ্জ ( Karimganj )'],
            ['dist_code' => '10', 'dist_name' => 'ছিৰাং ( Chirang )'],
            ['dist_code' => '22', 'dist_name' => 'Hailakandi'],
            ['dist_code' => '23', 'dist_name' => 'Cachar'],
            ['dist_code' => '38', 'dist_name' => 'দক্ষিণ শালমাৰা ( South Salmara )'],
            ['dist_code' => '02', 'dist_name' => 'ধুবুৰী ( Dhubri )'],
            ['dist_code' => '05', 'dist_name' => 'বৰপেটা  ( Barpeta )'],
            ['dist_code' => '27', 'dist_name' => 'Udalguri'],
            ['dist_code' => '33', 'dist_name' => 'নগাওঁ ( Nagaon )'],
            ['dist_code' => '06', 'dist_name' => 'নলবাৰী ( Nalbari )'],
            ['dist_code' => '07', 'dist_name' => 'কামৰূপ ( Kamrup )'],
            ['dist_code' => '01', 'dist_name' => 'কোকৰাঝাৰ (Kokrajhar)'],
        ];

        $data['user_data'] = [
            'user_dist_code' => $this->session->userdata('dist_code'),
            'user_subdiv_code' => $this->session->userdata('subdiv_code'),
            'user_cir_code' => $this->session->userdata('cir_code'),
            'user_mouza_pargona_code' => $this->session->userdata('mouza_pargona_code'),
            'user_lot_no' => $this->session->userdata('lot_no'),
        ];

        $data['land_class_code'] = $this->db->query("Select * from landclass_code")->result();
        $data['patta_details'] = $this->db->query("SELECT type_code, patta_type FROM patta_code where (settlement = ? OR spcl_cultivation = ?)", array('y', 'y'))->result();


        $application_no = $this->utilityclass->getApplidFromCaseNo($case_no);

        $nominee = $this->db->query('SELECT * FROM settlement_nominee WHERE case_no = ? AND id NOT IN (SELECT delete_id FROM settlement_nominee_transaction where case_no = ?)', array($case_no, $case_no));
        
        if($nominee->num_rows() <= 0)
        {
            $nominee = $this->db->query('SELECT * FROM settlement_nominee WHERE case_no = ? AND id NOT IN (SELECT delete_id FROM settlement_nominee_transaction where case_no = ?)', array($application_no, $application_no));
        }

        if($nominee->num_rows() <= 0)
        {
            $data['nominee'] = false;
        }
        else
        {
            $data['nominee'] = $nominee->result();

            foreach($data['nominee'] as $nomRow)
            {
                $nomRow->relation_decoded = $this->utilityclass->getrelationByID($nomRow->relation);
            }
        }

        $addededNomSql = $this->db->query('select * from settlement_nominee_transaction where case_no = ?', array($case_no));
        
        if($addededNomSql->num_rows() <= 0)
        {
            $data['transactionNom'] = false;
        }
        else
        {
            $data['transactionNom'] = $addededNomSql->result();

            foreach($data['transactionNom'] as $nomTranRow)
            {
                $nomTranRow->relation_decoded = $this->utilityclass->getrelationByID($nomTranRow->relation);
            }

        }

        echo json_encode($data);

    }

    public function getGuardianRelation()
    {
        // for guardian relation
        $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";

        $relation_executation = $this->db->query($query_for_guar_rel);
        $row = $relation_executation->num_rows();
        if ($row != 0) 
        {
            $data['guar_rel'] = $relation_executation->result();
        }
        else
        {
            $data['guar_rel'] = false;
        }

        echo json_encode($data);
    }


    //****add settlement_nominee*** */
    public function addFamilyDetails()
    {
        $this->dbswitch();

        $this->db->trans_begin();
        $case_no = $this->input->post('case_no');

        //******backend validation */
        //***delimiter for not returning <p> tag */
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('nominee_name', 'Name', 'trim|required');
        $this->form_validation->set_rules('case_no', 'Case no', 'trim|required');
        $this->form_validation->set_rules('relation', 'Relation', 'trim|required');
        $this->form_validation->set_rules('mobile_no', 'Mobile No.', 'trim|required|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('address', 'Address', 'trim|required|min_length[3]|max_length[200]');

        if ($this->form_validation->run() == false) {
            $data = array(
                'responseType' => 0,
                'msg' => "#SETTLAPPBACK00028:" . validation_errors() . "#case_no : " . $case_no,
            );
            echo json_encode($data);
            return false;
        }

        $familyDetailsArr = [
            'case_no' => $this->input->post('case_no'),
            'nominee_name' => $this->input->post('nominee_name'),
            'address' => $this->input->post('address'),
            'relation' => $this->input->post('relation'),
            'mobile_no' => $this->input->post('mobile_no'),
        ];

        $insFamily = $this->db->insert('settlement_nominee_transaction', $familyDetailsArr);
        $id = $this->db->insert_id();
        $familyDetailsArr['relation_name'] = $this->utilityclass->appRelationbyIDMB2($this->input->post('relation'));
        $familyDetailsArr['id'] = $id;

        if ($insFamily != 1) {
            $this->db->trans_rollback();
            log_message('error', '#SETTLNOM0001: Insert fail in settlement_nominee ' . $case_no);
            $data = array(
                'responseType' => 0,
                'msg' => "#SETTLNOM0001: Update Insert in settlement_nominee : " . $case_no,
            );
            echo json_encode($data);
            return false;
        }

        //**** if data intserted successfully*/
        $this->db->trans_commit();
        $data = array(
            'responseType' => 2,
            'appnData' => $familyDetailsArr,
            'msg' => "Family data added successfully...",
        );
        echo json_encode($data);

    }

    // Delete family newly inserted 
    public function delFamilyDetails()
    {
        $this->dbswitch();
        $this->db->trans_begin();
        $id = $this->input->post('id');
        $case_no = $this->input->post('case_no');

        //if condition if no id fond or already deleted
        $sql = "delete from settlement_nominee_transaction where id='$id' and case_no='$case_no'";
        $result = $this->db->query($sql);
        if ($this->db->affected_rows() != 1) {
            $this->db->trans_rollback();
            $response['status'] = 0;
            echo json_encode(['status' => 0]);
            log_message("error", "#PROP0002 Failed to delete family: " . $id);
            return;
        } else {
            $this->db->trans_commit();

            $response['status'] = 200;
            echo json_encode(['status' => 200]);
            return;
        }
    }

    // Delete existing family 
    public function delFamilyDetailsExisted()
    {
        $this->dbswitch();

        $this->db->trans_begin();
        $id = $this->input->post('id');
        $case_no = $this->input->post('case_no');

        $sqlGetNominee = $this->db->query('select * from settlement_nominee where case_no = ? and id = ?', array($case_no, $id));

        if($sqlGetNominee->num_rows() <= 0)
        {
            // $response['status'] = 0;
            echo json_encode(['status' => 0]);
            log_message("error", "#PROP761 Failed to delete family: " . $case_no);
            return;
        }

        $getFamRow = $sqlGetNominee->row();

        $insertArr = [
            'case_no' => $case_no,
            'nominee_name' => $getFamRow->nominee_name,
            'address' => $getFamRow->address,
            'relation' => $getFamRow->relation,
            'mobile_no' => $getFamRow->mobile_no,
            'delete_id' => $id,
        ];

        $insFamily = $this->db->insert('settlement_nominee_transaction', $insertArr);

        if ($insFamily != 1) 
        {
            $this->db->tran_rollback();
            log_message('error', '#SETTLNOM784: Failed to delete family ' . $case_no);
            echo json_encode(['status' => 0]);
            return;
        }

        $this->db->trans_commit();
        echo json_encode(['status' => 200]);
        return;
        
    }


    public function chithaProcessingDetails()
    {

        $case_no = $this->input->post('case_no');
        if(empty($case_no))
        {
            echo json_encode([
                'responseType'  => 0,
                'msg'           => '#ERR805: Case number not found!',
            ]);
            return false;
        }

        $getDagsSql = $this->db->query('select * from settlement_dag_details where case_no = ?', array($case_no));

        if($getDagsSql->num_rows() <= 0)
        {
            log_message('error', '#ERR10285: Case not found in settlemnet_dag_details'. $this->db->last_query());
            echo json_encode([
                'responseType'  => 0,
                'msg'           => '#ERR10285: Dag details not found!'
            ]);
            return false;
        }

        $data['dagResult'] = $getDagsSql->result();

        $new_patta_type = $this->input->post('new_patta_type');
        $possession_from = $this->input->post('possession_from');

        if(empty($new_patta_type) || empty($possession_from))
        {
            echo json_encode([
                'responseType'  => 0,
                'msg'           => '#ERR831: Please enter all required fields!',
            ]);
            return false;
        }

        //****get basic data  */
        $getBasicSql = $this->db->query('select * from settlement_basic where case_no = ?', array($case_no))->row();

        $batch_array = array();

        foreach($data['dagResult'] as $dagRow)
        {
            if($getBasicSql->service_code == '14')
            {

                if(empty($dagRow->new_dag_no) || $dagRow->new_dag_no == null || $dagRow->new_dag_no == '')
                {
                    echo json_encode([
                        'responseType'  => 0,
                        'msg'           => '#ERR952: New Dag not found for NR case!'
                    ]);
                    return false;
                }

                $dagRow->dag_no = $dagRow->new_dag_no;
            }

            $landmark_dist_east = $this->input->post('landmark_dist_east'.$dagRow->dag_no);
            $landmark_subdiv_east = $this->input->post('landmark_subdiv_east'.$dagRow->dag_no);
            $landmark_cir_east = $this->input->post('landmark_cir_east'.$dagRow->dag_no);
            $landmark_mouza_east = $this->input->post('landmark_mouza_east'.$dagRow->dag_no);
            $landmark_lot_east = $this->input->post('landmark_lot_east'.$dagRow->dag_no);
            $landmark_village_east = $this->input->post('landmark_village_east'.$dagRow->dag_no);
            $landmark_dag_no_east = $this->input->post('landmark_dag_no_east'.$dagRow->dag_no);

            $landmark_dist_west = $this->input->post('landmark_dist_west'.$dagRow->dag_no);
            $landmark_subdiv_west = $this->input->post('landmark_subdiv_west'.$dagRow->dag_no);
            $landmark_cir_west = $this->input->post('landmark_cir_west'.$dagRow->dag_no);
            $landmark_mouza_west = $this->input->post('landmark_mouza_west'.$dagRow->dag_no);
            $landmark_lot_west = $this->input->post('landmark_lot_west'.$dagRow->dag_no);
            $landmark_village_west = $this->input->post('landmark_village_west'.$dagRow->dag_no);
            $landmark_dag_no_west = $this->input->post('landmark_dag_no_west'.$dagRow->dag_no);
            
            $landmark_dist_north = $this->input->post('landmark_dist_north'.$dagRow->dag_no);
            $landmark_subdiv_north = $this->input->post('landmark_subdiv_north'.$dagRow->dag_no);
            $landmark_cir_north = $this->input->post('landmark_cir_north'.$dagRow->dag_no);
            $landmark_mouza_north = $this->input->post('landmark_mouza_north'.$dagRow->dag_no);
            $landmark_lot_north = $this->input->post('landmark_lot_north'.$dagRow->dag_no);
            $landmark_village_north = $this->input->post('landmark_village_north'.$dagRow->dag_no);
            $landmark_dag_no_north = $this->input->post('landmark_dag_no_north'.$dagRow->dag_no);
            
            $landmark_dist_south = $this->input->post('landmark_dist_south'.$dagRow->dag_no);
            $landmark_subdiv_south = $this->input->post('landmark_subdiv_south'.$dagRow->dag_no);
            $landmark_cir_south = $this->input->post('landmark_cir_south'.$dagRow->dag_no);
            $landmark_mouza_south = $this->input->post('landmark_mouza_south'.$dagRow->dag_no);
            $landmark_lot_south = $this->input->post('landmark_lot_south'.$dagRow->dag_no);
            $landmark_village_south = $this->input->post('landmark_village_south'.$dagRow->dag_no);
            $landmark_dag_no_south = $this->input->post('landmark_dag_no_south'.$dagRow->dag_no);

            $land_class_code_homestead = $this->input->post('land_class_code_homestead'.$dagRow->dag_no);
            $land_class_code_agriculture = $this->input->post('land_class_code_agriculture'.$dagRow->dag_no);


            $revenue_home = $this->input->post('revenue_home'.$dagRow->dag_no);
            $local_tax_home = $this->input->post('local_tax_home'.$dagRow->dag_no);
            $revenue_agri = $this->input->post('revenue_agri'.$dagRow->dag_no);
            $local_tax_agri = $this->input->post('local_tax_agri'.$dagRow->dag_no);


            $landType = 0;

            $home_b = $dagRow->home_b;  
            $home_k = $dagRow->home_k;  
            $home_lc = $dagRow->home_lc;  
            $home_g = $dagRow->home_g;

            $homestead = $home_b + $home_k + $home_lc + $home_g;

            if($homestead > 0)
            {
               $landType = 1; 
            }

            $agri_b = $dagRow->agri_b; 
            $agri_k = $dagRow->agri_k; 
            $agri_lc = $dagRow->agri_lc;
            $agri_g = $dagRow->agri_g;

            $agriculture = $agri_b + $agri_k + $agri_lc + $agri_g;

            if($agriculture > 0)
            {
               $landType = 2; 
            }

            if($homestead > 0 && $agriculture > 0)
            {
                $landType = 3; 
            }

            if($landType != 3){
                if(empty($land_class_code_homestead) && empty($land_class_code_agriculture))
                {
                    echo json_encode([
                        'responseType'  => 0,
                        'msg'           => '#ERR4912: Please Enter landclass...',
                    ]);
                    return false;
                }
            }
            else{
                if(empty($land_class_code_homestead) || empty($land_class_code_agriculture))
                {
                    echo json_encode([
                        'responseType'  => 0,
                        'msg'           => '#ERR7912: Please Enter landclass...',
                    ]);
                    return false;
                }
            }

            if(empty($revenue_home) && empty($revenue_agri))
            {
                echo json_encode([
                    'responseType'  => 0,
                    'msg'           => '#ERR1050: Please Enter revenue details...',
                ]);
                return false;
            }

            if(!empty($revenue_home))
            {
                if(empty($local_tax_home))
                {
                    echo json_encode([
                        'responseType'  => 0,
                        'msg'           => '#ERR1061: Please Enter Local tax details...',
                    ]);
                    return false;
                }
            }

            if(!empty($revenue_agri))
            {
                if(empty($local_tax_agri))
                {
                    echo json_encode([
                        'responseType'  => 0,
                        'msg'           => '#ERR1073: Please Enter Local tax details...',
                    ]);
                    return false;
                }
            }

            $revenue_home       = $this->UtilsModel->defaultValue($revenue_home, 0);
            $local_tax_home     = $this->UtilsModel->defaultValue($local_tax_home, 0);
            $revenue_agri       = $this->UtilsModel->defaultValue($revenue_agri, 0);
            $local_tax_agri     = $this->UtilsModel->defaultValue($local_tax_agri, 0);


            if(empty($landmark_dist_east) || empty($landmark_subdiv_east) || empty($landmark_cir_east) || empty($landmark_mouza_east) || empty($landmark_lot_east) || empty($landmark_village_east) || empty($landmark_dag_no_east) || empty($landmark_dist_west) || empty($landmark_subdiv_west) || empty($landmark_cir_west) || empty($landmark_mouza_west) || empty($landmark_lot_west) || empty($landmark_village_west) || empty($landmark_dag_no_west) || empty($landmark_dist_north) || empty($landmark_subdiv_north) || empty($landmark_cir_north) || empty($landmark_mouza_north) || empty($landmark_lot_north) || empty($landmark_village_north) || empty($landmark_dag_no_north) || empty($landmark_dist_south) || empty($landmark_subdiv_south) || empty($landmark_cir_south) || empty($landmark_mouza_south) || empty($landmark_lot_south) || empty($landmark_village_south) || empty($landmark_dag_no_south))
            {
                echo json_encode([
                    'responseType'  => 0,
                    'msg'           => '#ERR870: Please enter all landmark details!',
                ]);
                return false;
            }


            $landmark_dist_east_name = $this->utilityclass->getDistrictName($landmark_dist_east);
            $landmark_subdiv_east_name = $this->utilityclass->getSubDivName($landmark_dist_east, $landmark_subdiv_east);
            $landmark_cir_east_name = $this->utilityclass->getCircleName($landmark_dist_east, $landmark_subdiv_east, $landmark_cir_east);
            $landmark_mouza_east_name = $this->utilityclass->getMouzaName($landmark_dist_east, $landmark_subdiv_east, $landmark_cir_east, $landmark_mouza_east);
            $landmark_lot_east_name = $this->utilityclass->getLotName($landmark_dist_east, $landmark_subdiv_east, $landmark_cir_east, $landmark_mouza_east, $landmark_lot_east);
            $landmark_village_east_name = $this->utilityclass->getVillageName($landmark_dist_east, $landmark_subdiv_east, $landmark_cir_east, $landmark_mouza_east, $landmark_lot_east, $landmark_village_east);

            $landmark_dist_west_name = $this->utilityclass->getDistrictName($landmark_dist_west);
            $landmark_subdiv_west_name = $this->utilityclass->getSubDivName($landmark_dist_west, $landmark_subdiv_west);
            $landmark_cir_west_name = $this->utilityclass->getCircleName($landmark_dist_west, $landmark_subdiv_west, $landmark_cir_west);
            $landmark_mouza_west_name = $this->utilityclass->getMouzaName($landmark_dist_west, $landmark_subdiv_west, $landmark_cir_west, $landmark_mouza_west);
            $landmark_lot_west_name = $this->utilityclass->getLotName($landmark_dist_west, $landmark_subdiv_west, $landmark_cir_west, $landmark_mouza_west, $landmark_lot_west);
            $landmark_village_west_name = $this->utilityclass->getVillageName($landmark_dist_west, $landmark_subdiv_west, $landmark_cir_west, $landmark_mouza_west, $landmark_lot_west, $landmark_village_west);

            $landmark_dist_north_name = $this->utilityclass->getDistrictName($landmark_dist_north);
            $landmark_subdiv_north_name = $this->utilityclass->getSubDivName($landmark_dist_north, $landmark_subdiv_north);
            $landmark_cir_north_name = $this->utilityclass->getCircleName($landmark_dist_north, $landmark_subdiv_north, $landmark_cir_north);
            $landmark_mouza_north_name = $this->utilityclass->getMouzaName($landmark_dist_north, $landmark_subdiv_north, $landmark_cir_north, $landmark_mouza_north);
            $landmark_lot_north_name = $this->utilityclass->getLotName($landmark_dist_north, $landmark_subdiv_north, $landmark_cir_north, $landmark_mouza_north, $landmark_lot_north);
            $landmark_village_north_name = $this->utilityclass->getVillageName($landmark_dist_north, $landmark_subdiv_north, $landmark_cir_north, $landmark_mouza_north, $landmark_lot_north, $landmark_village_north);
            
            $landmark_dist_south_name = $this->utilityclass->getDistrictName($landmark_dist_south);
            $landmark_subdiv_south_name = $this->utilityclass->getSubDivName($landmark_dist_south, $landmark_subdiv_south);
            $landmark_cir_south_name = $this->utilityclass->getCircleName($landmark_dist_south, $landmark_subdiv_south, $landmark_cir_south);
            $landmark_mouza_south_name = $this->utilityclass->getMouzaName($landmark_dist_south, $landmark_subdiv_south, $landmark_cir_south, $landmark_mouza_south);
            $landmark_lot_south_name = $this->utilityclass->getLotName($landmark_dist_south, $landmark_subdiv_south, $landmark_cir_south, $landmark_mouza_south, $landmark_lot_south);
            $landmark_village_south_name = $this->utilityclass->getVillageName($landmark_dist_south, $landmark_subdiv_south, $landmark_cir_south, $landmark_mouza_south, $landmark_lot_south, $landmark_village_south);

            
            $landmark_name = [
                'east' => $landmark_dist_east_name.', '. $landmark_subdiv_east_name.', '.$landmark_cir_east_name.', '.$landmark_mouza_east_name.', '.$landmark_lot_east_name.', '.$landmark_village_east_name.', '.$landmark_dag_no_east,
                
                'west' => $landmark_dist_west_name.', '. $landmark_subdiv_west_name.', '.$landmark_cir_west_name.', '.$landmark_mouza_west_name.', '.$landmark_lot_west_name.', '.$landmark_village_west_name.', '.$landmark_dag_no_west,
                
                'north' => $landmark_dist_north_name.', '. $landmark_subdiv_north_name.', '.$landmark_cir_north_name.', '.$landmark_mouza_north_name.', '.$landmark_lot_north_name.', '.$landmark_village_north_name.', '.$landmark_dag_no_north,

                'south' => $landmark_dist_south_name.', '. $landmark_subdiv_south_name.', '.$landmark_cir_south_name.', '.$landmark_mouza_south_name.', '.$landmark_lot_south_name.', '.$landmark_village_south_name.', '.$landmark_dag_no_south,
            ];

            $landmark_with_code = [
                'east' => [
                        'dist_code'             => $landmark_dist_east,
                        'subdiv_code'           => $landmark_subdiv_east,
                        'cir_code'              => $landmark_cir_east,
                        'mouza_pargona_code'    => $landmark_mouza_east,
                        'lot_no'                => $landmark_lot_east,
                        'vill_townprt_code'     => $landmark_village_east,
                        'dag_no'                => $landmark_dag_no_east,
                    ],
                
                'west' => [
                        'dist_code'             => $landmark_dist_west,
                        'subdiv_code'           => $landmark_subdiv_west,
                        'cir_code'              => $landmark_cir_west,
                        'mouza_pargona_code'    => $landmark_mouza_west,
                        'lot_no'                => $landmark_lot_west,
                        'vill_townprt_code'     => $landmark_village_west,
                        'dag_no'                => $landmark_dag_no_west,
                    ],
                    
                'north' => [
                        'dist_code'             => $landmark_dist_north,
                        'subdiv_code'           => $landmark_subdiv_north,
                        'cir_code'              => $landmark_cir_north,
                        'mouza_pargona_code'    => $landmark_mouza_north,
                        'lot_no'                => $landmark_lot_north,
                        'vill_townprt_code'     => $landmark_village_north,
                        'dag_no'                => $landmark_dag_no_north,
                    ],

                'south' => [
                        'dist_code'             => $landmark_dist_south,
                        'subdiv_code'           => $landmark_subdiv_south,
                        'cir_code'              => $landmark_cir_south,
                        'mouza_pargona_code'    => $landmark_mouza_south,
                        'lot_no'                => $landmark_lot_south,
                        'vill_townprt_code'     => $landmark_village_south,
                        'dag_no'                => $landmark_dag_no_south,
                    ],
            ];

            //****insert in settlement_approval_transaction */
            $insertArr = [
                'case_no'                   => $case_no,
                'dag_no'                    => $dagRow->dag_no,
                'patta_type_code'           => $new_patta_type,
                'possession_from'           => $possession_from,
                'landclass_home'            => $land_class_code_homestead,
                'landclass_agri'            => $land_class_code_agriculture,
                'landmark_with_code'        => json_encode($landmark_with_code),
                'landmark'                  => json_encode($landmark_name),
                'date_entry'                => date('Y-m-d H:i:s'),
               
                'new_home_land_revenue'     => $revenue_home,
                'new_agri_land_revenue'     => $revenue_agri,
                'new_home_land_local_tax'   => $local_tax_home,
                'new_agri_land_local_tax'   => $local_tax_agri,
                'new_total_revenue'         => (float)$revenue_home + (float)$revenue_agri,
                'new_total_tax'             => (float)$local_tax_home + (float)$local_tax_agri,
            ];
            $batch_array[] = $insertArr;
        }
        
        $this->dbswitch();

        $this->db->trans_begin();

        $checkIfAlreadyEnt = $this->db->query('select * from settlement_approval_transaction where case_no = ?', array($case_no));
        
        if($checkIfAlreadyEnt->num_rows() > 0)
        {
            $this->db->query('delete from settlement_approval_transaction where case_no = ?', array($case_no));

            if($this->db->affected_rows() != count($batch_array))
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType'  => 0,
                    'msg'           => '#ERR812: Something went wrong! Unable to process...',
                ]);
                return false;
            }
        }

        $insert_count = $this->db->insert_batch('settlement_approval_transaction',$batch_array);

        if(count($batch_array) != $insert_count)
        {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg' => '#JS0053: Something went wrong!'
            ]);
            return false;
        }

        //*****update settlement_basic */

        $basicArr = [
            'chitha_processing_details' => 1,
            'date_update'               => date('Y-m-d H:i:s')
        ];

        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $basicArr);

        if($this->db->affected_rows() != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERR1000: Unable to update settlement_basic!'. $this->db->last_query());
            echo json_encode([
                'responseType'  => 0,
                'msg'           => '#ERR1000: Unable to save data!',
            ]);
            return false;
        }

        //////proceeding start//////
        $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

        if ($proceeding_id == null) {
            $proceeding_id = 1;
        }

        $insPetProceed = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'note_on_order' => 'LM Re-verify report submitted',
            'status' => 'N',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d h:i:s'),
            'operation' => 'E',
            'ip' => $this->utilityclass->get_client_ip(),
            'office_from' => 'LM',
            'office_to' => 'CO',
            'task' => 'LM Re-verify report submitted',
            // 'note_type' => $this->input->post('lm_note'),
        ];
        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

        if ($insertProceeding != 1) 
        {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType'  => 0,
                'msg'           => '#ERR2403: Unable to approve report!',
            ]);
            return false;
        }


        $this->db->trans_commit();
        echo json_encode([
            'responseType'  => 2,
            'msg'           => 'success',
        ]);
        return;
    }

    public function getRevenueDetails()
    {
        $land_class_code = $this->input->post('land_class_code');
        $case_no = $this->input->post('case_no');
        $dag_no = $this->input->post('dag_no');
        $dist_code = $this->session->userdata('dist_code');

        $urbanArray = array(1,2,3,4,5,6,11,12,13,14,15,16,17);
        // $ruralArray = array(7,8,9,10,18,19,20,21,22);

        $getPremSql = $this->db->query('select * from settlement_premium where case_no = ? and dag_no = ?', array($case_no, $dag_no));

        if($getPremSql->num_rows() <= 0)
        {
            echo json_encode([
                'responseType'  => 0,
                'msg'           => '#ERR1260: Premium not found for this dag!'
            ]);
        }

        $premRow = $getPremSql->row();

        $isUrban = 'Rural';
        if(in_array($premRow->area_name, $urbanArray))
        {
            $isUrban = 'Urban';
        }

        $landSql = $this->db->query('select * from revenue_land_class_wise where class_code = ? and ruralurban = ? order by date_entry desc limit 1', array($land_class_code, $isUrban));

        if($landSql->num_rows() <= 0)
        {
            $total_revenue = 15;
        }
        else
        {
            $landRow = $landSql->row();

            $dag_revenue_perbigha = (float)$landRow->dag_revenue_perbigha;
    
            //***calculating revenue in lessa */
            if (in_array($dist_code, json_decode(BARAK_VALLEY)))
            {
                $revenue_in_lessa = $dag_revenue_perbigha/6400;
            }
            else
            {
                $revenue_in_lessa = $dag_revenue_perbigha/100;
            }
    
            //*****total_settlemnet_area in lessa */
            $total_settlement_area_in_lessa = $premRow->total_lessa;
    
            //***calculating total revenue */
            $total_revenue = $total_settlement_area_in_lessa * $revenue_in_lessa;
    
            if($total_revenue < 15)
            {
                $total_revenue = 15;
            }
        }

        //*****calculating the local tax */
        $localTax = $total_revenue/4;

        echo json_encode([
            'responseType'   => 2,
            'revenue'       => $total_revenue,
            'local_tax'     => $localTax,
        ]);
        return;
    }

    public function applicantEditCases()
    {
        $data['service'] = $_GET['service'];

        $dist_code = $this->session->userdata('dist_code'); 
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');

        $getVillages = $this->db->query('select distinct on (dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no) * from settlement_basic where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ?', array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no));

        if($getVillages->num_rows() <= 0)
        {
            $villResult = false;
        }
        else
        {
            $villResult = $getVillages->result();
        }

        $data['selectList'] = $villResult;

        $data['_view'] = 'LmSettlementMb/applicant_edit_cases';
        $this->load->view('layouts/main', $data);
    }

    public function applicantEditCasePagination()
    {
        $service = $this->input->post('service');

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');

        $searchByCol_0 = trim($this->input->post('columns')[0]['search']['value']);
        $searchByCol_1 = trim($this->input->post('columns')[1]['search']['value']);
        $searchByCol_2 = trim($this->input->post('columns')[2]['search']['value']);
        $searchByCol_3 = trim($this->input->post('columns')[3]['search']['value']);

        if (!empty($searchByCol_0)) 
        {
            $this->db->like('UPPER(applid)', $searchByCol_0);
        }

        if (!empty($searchByCol_1)) 
        {
            $this->db->like('UPPER(case_no)', $searchByCol_1);
        }

        if (!empty($searchByCol_2)) 
        {
            $this->db->where('vill_townprt_code', $searchByCol_2);
        }

        if (!empty($searchByCol_3)) 
        {
            $this->db->where('chitha_processing_details', $searchByCol_3);
        }

        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('mouza_pargona_code', $mouza_pargona_code);
        $this->db->where('lot_no', $lot_no);
        $this->db->where('status', 'N');
        $this->db->where('chitha_processing_details', 0);
        $this->db->where('service_code', $service);
        $this->db->limit($length, $start);
        $this->db->from('settlement_basic');
        $query = $this->db->get();

        $results = $query->result();

        if ($query->num_rows() > 0) 
        {
            foreach($results as $rows) 
            {

                if($rows->chitha_processing_details == 1)
                {
                    $verification_status = '<span class="text-success"><strong><small>Verified</small></strong></span>';
                    $verify_report_button = '';
                }
                else
                {
                    $verification_status = '<span class="text-danger"><strong><small>Not Verified</small></strong></span>';
                    $verify_report_button = '<a type="button" href="' . base_url() . 'index.php/SettlementApplicantLm/applicationView?case=' . $rows->case_no . '" class="btn-sm btn btn-primary">
                    write report</a>';
                }


                $view_link = '<a alt="View Application" class="text-white btn btn-sm btn-success" target="Application View" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>';

                $json[] = array(
                    '<span class="px-3"><strong>' . $rows->applid . '</strong></span>',
                    '<span class="px-3"><strong>' . $rows->case_no . '</strong></span>',

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    $verification_status,

                    $view_link.$verify_report_button,
                );
            }

            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('mouza_pargona_code', $mouza_pargona_code);
            $this->db->where('lot_no', $lot_no);
            $this->db->where('status', 'N');
            $this->db->where('chitha_processing_details', 0);
            $this->db->where('service_code', $service);
            $total_records = $this->db->count_all_results('settlement_basic');

            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json,
            );
            echo json_encode($response);

        } 
        else 
        {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }


}

