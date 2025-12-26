<?php
class SettlementMbCo extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Allowed designations
        $allowed = ['CO', 'DC'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }
        //ob_start();
        $this->load->model('basundhara/SettlementApiModel');
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
        $this->load->model('SettlementMb/SettlementMbModel');
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('SettlementModel/SettlementCommonModel');
        $this->load->model('SettlementModel/SettlementKhasModel');
        $this->load->model('DataBaseSwitchModel');


        $method = $this->router->fetch_method();

        if (!in_array($method, VERIFICATION_MODULE_METHODS)) {
            if (HOLD_All_MB2_CASES_STATUS == 1) {
                if (strtotime(HOLD_All_MB2_CASES_DATE) < strtotime(date('Y-m-d H:i:s'))) {
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

    public function FirstProceeding()
    {

        // $data['select_range'] = $select_offset = $this->input->post('select_range');

        $data['getFirstProceeding'] = $this->SettlementMbModel->get_settlementTenantPending();

        $data['_view'] = 'settlement_mb/first_proceeding_co';

        $this->load->view('layouts/main', $data);
    }

    public function PaymentNotice()
    {
        $data['getPaymentNotice'] = $this->SettlementMbModel->get_paymentNotice();

        $data['_view'] = 'settlement_mb/payment_notice_co';

        $this->load->view('layouts/main', $data);
    }

    // -js- final chitha update 30-08-2022
    public function coFinalPendingCases()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $chitha_data['cases'] = $this->db->query("
            SELECT * FROM settlement_basic WHERE dist_code='$dist_code'AND subdiv_code='$subdiv_code'AND cir_code='$cir_code'AND status='C'AND dc_code is not null AND co_chitha_corrected_yn is null AND lm_code is not null")->result();
        $chitha_data['_view'] = 'settlement_mb/co_final_pending_cases';
        $this->load->view('layouts/main', $chitha_data);
    }

    public function coReSubmitLmCases()
    {
        $service_code = $this->input->get('service');
        $status = $this->input->get('s');

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $chitha_data['cases'] = $this->db->query("
            SELECT * FROM settlement_basic WHERE dist_code='$dist_code'AND subdiv_code='$subdiv_code'AND cir_code='$cir_code'AND status='X'AND lm_code is not null")->result();

        $chitha_data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);
        $chitha_data['service_code'] = $service_code;
        $chitha_data['_view'] = 'settlement_mb/co_resubmit_lm_cases';

        $this->load->view('layouts/main', $chitha_data);
    }

    public function dcRevertedCasesExceptAp()
    {

        $data['getFirstProceeding'] = $this->SettlementMbModel->getDcRevertedCases();

        $service_code = $this->input->get('service');
        $status = $this->input->get('s');
        $data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);

        $data['_view'] = 'settlement_mb/first_proceeding_co';

        $this->load->view('layouts/main', $data);
    }

    // -js- co edit and check dag and patta update 30-08-2022
    public function coFinalOrderUpdate()
    {
        $case_no = $this->input->get('case_no');
        $dist_code = $this->input->get('dist_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');
        $q = "Select * from settlement_basic where dist_code='$dist_code' and case_no='$case_no'"; // and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill'";
        $data['alm'] = $alm = $this->db->query($q)->row();

        $subdiv_code = $alm->subdiv_code;
        $cir_code = $alm->cir_code;
        //var_dump($data);
        $mouza = $alm->mouza_pargona_code;
        $lot_no = $alm->lot_no; //$this->input->get('lot_no');
        $vill = $alm->vill_townprt_code; //$this->input->get('vill_townprt_code');
        //$patta_type = $alm->patta_type_code;
        $data['dagDetails'] = $patta_type_code = $this->db->query("
                SELECT * FROM settlement_dag_details
                WHERE dist_code = '$dist_code' AND subdiv_code = '$subdiv_code'
                AND cir_code = '$cir_code' AND  mouza_pargona_code = '$mouza'
                AND lot_no = '$lot_no' AND vill_townprt_code = '$vill' AND case_no = '$case_no'")->result();
        //echo $this->db->last_query();
        //echo "<pre>";
        //$data['old_dag']=$patta_type_code->dag_no;
        //$patta_type = $patta_type_code->patta_type_code;
        //$data['selectedPattaType']=$patta_type;
        //$pattasql = "Select type_code from  patta_code where mutation='a' ";
        $data['class_code'] = $patta_type_code[0]->new_land_class_code;
        $pattasqll = "SELECT type_code, patta_type FROM patta_code";
        $data['mutpatta'] = $this->db->query($pattasqll)->result();
        $data['newdag'] = $this->utilityclass->maxdag($dist_code, $subdiv_code, $cir_code, $mouza, $lot_no, $vill);
        $data['newpatta'] = 0;
        // $data['newpatta'] = $this->utilityclass->maxpatta($dist_code, $subdiv_code, $cir_code, $mouza, $lot_no, $vill, $patta_type);
        //var_dump($data);
        $q = "SELECT dag_no,patta_no,dag_no_int AS new_dag FROM chitha_basic WHERE dist_code='$dist_code'AND subdiv_code='$subdiv_code'AND cir_code='$cir_code'AND mouza_pargona_code='$mouza'AND lot_no='$lot_no'AND vill_townprt_code='$vill'ORDER BY dag_no_int";
        $data['dag_patta'] = $this->db->query($q)->result();
        $data['dcnote'] = 'Manipulate text';
        $data['land_class_code'] = $this->db->query("Select * from landclass_code")->result();
        ////////////Settlement Applicant Tenant//////////////
        $sql = "select inplace_alongwith from public.settlement_applicant where case_no=? and pdar_type='O' and inplace_alongwith='a' ";
        $data['alongwithOwner'] = $this->db->query($sql, $case_no)->num_rows();
        $sql = "select inplace_alongwith from public.settlement_applicant where case_no=? and pdar_type='O' and inplace_alongwith='a' ";
        $data['alongwithOwner'] = $this->db->query($sql, $case_no)->num_rows();
        ///////////////////////////
        //echo $this->db->last_query();
        if ($alm->service_code == '16') {
            $data['_view'] = 'settlement_mb/coFinalOrderUpdate';
        } else if ($alm->service_code == '13') {
            $data['_view'] = 'settlement_mb/coFinalOrderUpdateAPTenant';
        } else if ($alm->service_code == '14') {
            $data['_view'] = 'settlement_mb/coFinalOrderUpdateAP';
        }
        $this->load->view('layouts/main', $data);
    }
    // public function coFinalOrderUpdate(){
    //     $case_no = $this->input->get('case_no');
    //     $dist_code = $this->input->get('dist_code');
    //     $subdiv_code = $this->input->get('subdiv_code');
    //     $cir_code = $this->input->get('cir_code');
    //     $q = "Select * from settlement_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and case_no='$case_no'";// and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill'";
    //     $data['alm'] = $alm = $this->db->query($q)->row();
    //     $mouza=$alm->mouza_pargona_code;
    //     $lot_no=$alm->lot_no;//$this->input->get('lot_no');
    //     $vill=$alm->vill_townprt_code;//$this->input->get('vill_townprt_code');
    //     //$patta_type = $alm->patta_type_code;
    //     $patta_type_code = $this->db->query("
    //         SELECT patta_type_code,dag_no,new_land_class_code FROM settlement_dag_details WHERE dist_code = '$dist_code'AND subdiv_code = '$subdiv_code'AND cir_code = '$cir_code'AND mouza_pargona_code = '$mouza'AND lot_no = '$lot_no'AND vill_townprt_code = '$vill'AND case_no = '$case_no'")->row();
    //     $data['old_dag']=$patta_type_code->dag_no;
    //     $data['class_code']=$patta_type_code->new_land_class_code;
    //     $patta_type = $patta_type_code->patta_type_code;
    //     $data['selectedPattaType']=$patta_type;
    //     //$pattasql = "Select type_code from  patta_code where mutation='a' ";
    //     $pattasqll = "SELECT type_code, patta_type FROM patta_code";
    //     $data['mutpatta'] = $this->db->query($pattasqll)->result();
    //     $data['newdag'] = $this->utilityclass->maxdag($dist_code, $subdiv_code, $cir_code, $mouza, $lot_no, $vill);
    //     $data['newpatta'] = $this->utilityclass->maxpatta($dist_code, $subdiv_code, $cir_code, $mouza, $lot_no, $vill, $patta_type);
    //     //var_dump($data);
    //     $q = "SELECT dag_no,patta_no,dag_no_int AS new_dag FROM chitha_basic WHERE dist_code='$dist_code'AND subdiv_code='$subdiv_code'AND cir_code='$cir_code'AND mouza_pargona_code='$mouza'AND lot_no='$lot_no'AND vill_townprt_code='$vill'ORDER BY dag_no_int";
    //     $data['dag_patta'] = $this->db->query($q)->result();

    //     $data['dcnote']='Manipulate text';
    //     $data['land_class_code']=$this->db->query("Select * from landclass_code")->result();
    //     //echo $this->db->last_query();
    //     if($alm->service_code=='16'){
    //         $data['_view'] = 'settlement_mb/coFinalOrderUpdate';
    //     }else if($alm->service_code=='13'){
    //         $data['_view'] = 'settlement_mb/coFinalOrderUpdateAPTenant';
    //     }
    //     $this->load->view('layouts/main',$data);
    // }

    public function dagSelectOnPattachange()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        //$mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        //$lot_no = $this->session->userdata('lot_no');
        $case_no = $this->input->post('case_no');
        $pattacode = $this->input->post('pattacode');
        $cb = $this->db->query("SELECT subdiv_code,cir_code,vill_townprt_code, mouza_pargona_code, lot_no FROM settlement_basic WHERE  case_no='$case_no'")->row();
        //echo $this->db->last_query();
        $sql = "Select distinct cast(patta_no as varchar) as patta_no from    chitha_basic where dist_code='$dist_code' and subdiv_code='$cb->subdiv_code' and cir_code='$cb->cir_code' and mouza_pargona_code='$cb->mouza_pargona_code'"
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

    // -js- view proceeding 30-08-22
    public function viewProceeding()
    {
        $case_no = $this->input->get('case_no');
        $q = "SELECT * FROM settlement_basic WHERE case_no='$case_no'";
        $data['pb'] = $this->db->query($q)->row();
        $q = "SELECT * FROM settlement_proceeding WHERE case_no='$case_no'ORDER BY proceeding_id ";
        $data['pd'] = $this->db->query($q)->result();
        $c = "SELECT * FROM settlement_proceeding WHERE case_no='$case_no'AND office_from = 'CO'ORDER BY proceeding_id ";
        $data['co_order'] = $this->db->query($c)->result();
        $this->load->view('settlement_mb/settlementmb_proceeding', $data);
    }

    public function chithaUpdate()
    {
        $this->load->helper('url');
        // var_dump($_POST);
        // die;
        $data = $this->SettlementMbModel->updateChitha();
        if ($data) {
            if ($data == 1) {
                redirect(base_url() . 'index.php/SettlementMbCo/redirectForPatta?case_no=' . $this->input->post('case_no'));
            } else {
                $application_no = $this->input->post('case_no');
                $case = $this->input->post('case_no');
                $rmk = 'Final order given but could not generate PATTA/ORDER copy';
                $status = 'F';
                $task = 'CO';
                $pen = 'NA';
                $rtps_status = $this->SettlementApiModel->postApiBasundhara($application_no, $case, $rmk, $status, $task, $pen);
                $rtps_status = json_decode($rtps_status);
                if (trim($rtps_status) != "y") {
                    $this->session->set_flashdata('message', "Final order given but could not generate PATTA/ORDER copy.There is an error in API Calling");
                    redirect('/home');
                }
                $this->session->set_flashdata('message', "Final order given but could not generate PATTA/ORDER copy");
                redirect('/home');
            }

        } else {
            redirect(base_url() . 'index.php/SettlementMbCo/coFinalPendingCases');
        }
    }

    public function chithaUpdateTenant()
    {

        $data = $this->SettlementMbModel->updateChithaTenant();
        if ($data === true) {
            redirect(base_url() . 'index.php/SettlementMbCo/redirectForTenant?case_no=' . $this->input->post('case_no'));
        } else {
            redirect(base_url() . 'index.php/SettlementMbCo/coFinalPendingCases');
        }
    }

    public function updateChithaAP()
    {
        $data = $this->SettlementMbModel->updateChithaAP();
        if ($data === true) {
            $this->session->set_flashdata('message', 'Final order passed successfully. Please check chitha');
            redirect('/home');
        } else {
            redirect(base_url() . 'index.php/SettlementMbCo/coFinalPendingCases');
        }
    }

    public function updateChithaAPNR()
    {
        $data = $this->SettlementMbModel->updateChithaAPNR();
        if ($data === true) {
            redirect(base_url() . 'index.php/SettlementMbCo/redirectForAPNR?case_no=' . $this->input->post('case_no'));
            redirect('/home');
        } else {
            redirect(base_url() . 'index.php/SettlementMbCo/coFinalPendingCases');
        }
    }
    // -js- 31-08-2022
    public function paymentNoticeCo()
    {
        $status = $this->input->get('s');
        $service_code = $this->input->get("service");
        $data['getPaymentNoticeCo'] = $this->SettlementMbModel->getPaymentNoticeCo($service_code);
        $data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);
        $dist_code = $this->session->userdata('dist_code');
        // if ($service_code == 16 || $service_code == 14 || $service_code == 15 || $service_code == 17) {
        //     if (in_array($dist_code, json_decode(PAYMENT_NOTICE_BULK_REQUEST_DIST))) {
        //         return $this->paymentNoticeCoNew();
        //     }
        // }

        $data['_view'] = 'settlement_mb/payment_notice_co';
        $this->load->view('layouts/main', $data);
    }
    public function paymentNoticeCoNew()
    {
        $status = $this->input->get('s');
        $service_code = $this->input->get("service");
        $data['getPaymentNoticeCo'] = $this->SettlementMbModel->getPaymentNoticeCo($service_code);
        $data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);
        $data['_view'] = 'settlement_mb/payment_notice_co_new';
        $this->load->view('layouts/main', $data);
    }
    //   -js- 31-08-2022
    //   public function paymentNoticeCofirmationCases(){
    //     $data['getPaymentConfirmationCo'] = $this->SettlementMbModel->getPaymentConfirmationCo();
    //     $data['_view'] = 'settlement_mb/paymentConfirmationCases';
    //     $this->load->view('layouts/main', $data);
    //   }

    public function generatePaymentNoticeCo()
    {
        if (isset($_POST['generate_notice'])) {
            $payment_amount = $this->input->post('payment_amount');
            $case_no = $this->input->post('case_no');
            $remark = $this->input->post('remark_co');
            $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
            // $get_dag_details = $this->SettlementApModel->getSettlementDagDetails($case_no);
            $get_settlement_applicant = $this->SettlementApModel->getAllApplicant($case_no);
            $get_owners = $this->SettlementApModel->getOwners($case_no);
            $get_buyers = $this->SettlementApModel->getBuyers($case_no);
            $get_dag_details = $this->SettlementApModel->getDags($case_no);
            $data = [
                'payment_amount' => $payment_amount,
                'case_no' => $case_no,
                'get_settlement_basic' => $get_settlement_basic,
                'get_dag_details' => $get_dag_details,
                'get_settlement_applicant' => $get_settlement_applicant,
                'remark' => $remark,
                'get_owners' => $get_owners,
                'get_buyers' => $get_buyers,
                'pay_notice_date' => date('Y-m-d'),
            ];
            $this->load->view('settlement_mb/paymentNotice', $data);
        } else {
            $case_no = $this->input->get('case');
            $data['basic'] = $this->SettlementApModel->getSettlementBasicCo($case_no);
            $data['_view'] = 'settlement_mb/generateNoticeView';
            $this->load->view('layouts/main', $data);
        }
    }

    public function printNotice()
    {
        $case_no = $this->input->get('case_no');
        // getting the notice file link
        $data['print_data'] = $this->SettlementApModel->getSettlementBasic($case_no);
        // reading the base64 json file and saving it to a variable
        $path = $this->SettlementCommonModel->downloadNotice($data['print_data']['co_notice_link']);
        if ($path == false) {
            echo 'No data found!';
            return;
        }

        $open_notice_file = fopen($path, "r") or die("Unable to open file!");
        $read_notice_file = fread($open_notice_file, filesize($path));
        fclose($open_notice_file);
        // decoding the base64 encoding file variable
        $base64decoded_notice_file = base64_decode(json_decode($read_notice_file));
        $data = [
            'base64_decoded_notice_file' => $base64decoded_notice_file,
        ];
        $data['_view'] = 'SettlementView/Co/PrintNotice';
        $this->load->view('layouts/main', $data);
    }

    public function saveNotice()
    {
        $case_no = $this->input->post('case_no');
        // replacing file case number to savable format
        $new_case_no = str_replace('/', "-", $case_no);
        // creating and saving the base64 format payment notice to uploads/paymentNotice folder
        $base_64_file_path = PAYMENT_NOTICE_PATH . $new_case_no . ".json";
        $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
        $htmlstring_text = json_encode($this->input->post('htmlstring_text'));
        fwrite($file_to_write_base64, $htmlstring_text);
        fclose($file_to_write_base64);
        $amount = $this->input->post('amount');
        $remark_co = $this->input->post('remark');
        $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
        $get_dag_details = $this->SettlementApModel->getSettlementDagDetails($case_no);
        $get_settlement_applicant = $this->SettlementApModel->getAllApplicant($case_no);
        $district = $this->input->post('district');
        $sub_division = $this->input->post('sub_division');
        $circle = $this->input->post('circle');
        $lot_no = $this->input->post('lot_no');
        $mouza = $this->input->post('mouza');
        $village = $this->input->post('village');
        // $petitioner_name = $this->input->post('petitioner_name');
        // $g_name = $this->input->post('g_name');
        // $dag_name = $this->input->post('dag_name');
        $payment_notice_gn_date = $this->input->post('pay_notice_gn_date');
        // $data = [
        //    'case_no' => $case_no,
        //    'remark' => $remark,
        //    'get_settlement_basic' => $get_settlement_basic,
        //    'get_dag_details' => $get_dag_details,
        //    'get_settlement_applicant' => $get_settlement_applicant,
        // ];
        $this->db->trans_begin();
        $updateArr = [
            'status' => 'N',
            'co_code' => $this->session->userdata('user_code'),
            'user_code' => $this->session->userdata('user_code'),
            'pay_notice_gen_yn' => 'Y',
            //  'notice_generated_date' => date('Y-m-d h:i:s'),
            'pay_notice_gn_date' => $payment_notice_gn_date,
            'date_update' => date('Y-m-d h:i:s'),
            'from_office' => 'CO',
            'pending_officer' => 'CO',
            'pending_office' => 'CO',
            'co_notice_link' => $base_64_file_path,
        ];
        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $updateArr);
        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            log_message('error', '#ERRPN0001: Updation Failed in settlement_basic table');
            $json = [
                'responseType' => 3,
                'message' => '#ERRPN0001: Failed to generate notice. Kindly contact system administrator',
            ];
            echo json_encode($json);
            return false;
        }
        //////proceeding start//////
        $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        if ($proceeding_id == null) {
            $proceeding_id = 1;
        }
        $insertArr = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'note_on_order' => $remark_co,
            'status' => 'N',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d h:i:s'),
            'operation' => 'E',
            'ip' => $this->utilityclass->get_client_ip(),
            'office_from' => 'CO',
            'office_to' => 'CO',
            'task' => 'Payment Notice Generated',
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if ($insertProc != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRPN0002: Insertion failed in settlement_proceeding');
            $json = [
                'responseType' => 3,
                'message' => '#ERRPN0002: Failed to generate notice. Kindly contact System Administrator',
            ];
            echo json_encode($json);
            return false;
        }
        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            $data = array(
                'error' => "Error in submitting. Please try Again",
            );
            return $data;
            exit;
        } else {
            // API CALL HERE
            $rtps_case_no = $get_settlement_basic->applid;
            //   payment request API
            $status = $this->SettlementMbModel->paymentRequest($rtps_case_no, $amount);
            //   USER END STATUS API CALLING
            //   $user_status_api = $this->SettlementApiModel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
            if ($status === false || $status === 0) {
                $this->db->trans_rollback();
                $data = array(
                    'error' => "Error in submitting. Please try Again $case_no",
                );
                return $data;
                exit;
            }
            //   API CALL END HERE
            $sql = "Select basundhara from basundhar_application where dharitree='$case_no' ";
            $basundhara = $this->db->query($sql)->row();
            // call api to upload notice
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2 . "uploadNotice");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'encoded_file' => json_decode($htmlstring_text),
                'application_no' => $basundhara->basundhara,
                'type' => 'PN',
            )));
            $result = curl_exec($curl_handle);
            if (!$result) {
                $this->db->trans_rollback();
                $data = array(
                    'error' => "Error in submitting. Please try Again",
                );
                return $data;
                exit;
            } else {

                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Payment notice successfully saved...");
                redirect(base_url() . 'index.php/SettlementMbCo/generatePaymentNoticeCo?case=' . $case_no);
            }
        }
    }

    public function paymentNoticeCofirmationCases()
    {
        $service_code = $this->input->get('service');
        $status = $this->input->get('s');
        $data['getPaymentConfirmationCo'] = $this->SettlementMbModel->getPaymentConfirmationCo($service_code);
        $data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);
        $data['_view'] = 'settlement_mb/paymentConfirmationCases';
        $this->load->view('layouts/main', $data);
    }

    public function bulkLmVerificationReportApprove()
    {
        $service_code = $this->input->get('service');
        $status = $this->input->get('s');
        $data['getPaymentConfirmationCo'] = $this->SettlementMbModel->getLmVerificationCases($service_code);
        $data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);

        $data['_view'] = 'settlement_mb/bulk_lm_report_approve_co';

        $this->load->view('layouts/main', $data);
    }

    public function paginationCoFirstBulkApprove()
    {

        if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
            $lot_string = $this->caseListUnderMappingLot();
        }

        $s_code = $this->input->post('service');
        $search_term = $this->input->post('search_term');
        $remark_cat = $this->input->post('remark_cat');
        $reverted = $this->input->post('reverted');
        $user_code = $this->session->userdata('user_code');
        $payment_status = $this->input->post('payment_status');

        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $nr_cat = $this->input->post('nr_cat');

        $status = $this->input->post('status');
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');

        $col = 0;
        $dir = "";
        $search = $this->input->post('search');
        $search = $search['value'];

        $searchByCol_0 = $this->input->post('columns')[1]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[2]['search']['value'];
        $searchByCol_3 = $this->input->post('columns')[4]['search']['value'];

        $is_cat = $this->input->post('is_category');

        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'asc';
        }

        $valid_columns = array(
            0 => 'date_entry',
        );

        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        if ($order != null) {
            $this->db->order_by($order, $dir);
        }

        if (!empty($searchByCol_0)) {

            $this->db->like('a.case_no', strtoupper($searchByCol_0));
        }

        if (!empty($searchByCol_1)) {

            $this->db->like('a.applid', strtoupper($searchByCol_1));
        }

        if (!empty($searchByCol_3)) {
            $this->db->like('TO_CHAR(a.date_entry,\'yyyy-mm-dd\')', $searchByCol_3);
            //$this->db->like('date_entry', $searchByCol_2);
        }

        $this->db->limit($length, $start);

        $this->db->where('a.service_code', $s_code);

        if (!empty($remark_cat)) { //settlement_ap_lmnote, lm_note
            $this->db->where('b.lm_note', $remark_cat);
        }

        if (!empty($mouza_pargona_code)) {
            $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
        }

        if (!empty($mouza_pargona_code) && !empty($lot_no)) {
            $this->db->where('a.lot_no', $lot_no);
        }

        if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }

        if ($this->session->userdata('user_desig_code') == 'CO') {
            // $this->db->where('a.co_code', $user_code);
            // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
            if (LOT_BIFURCATE == 1 && empty($mouza_pargona_code) && empty($lot_no)) {

                if (isset($lot_string) && $lot_string != null) {
                    $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                }
            }
        }

        $this->db->where('status', $status);
        $this->db->where('chitha_processing_details', 1);

        $this->db->from('settlement_basic a');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {

                // $tenant_link = '<a type="button" href="' . base_url() . 'index.php/SettlementTenantCo/settlementTenantCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                //     write report</a>';
                // $tribal_link = '<a type="button" href="' . base_url() . 'index.php/SettlementTribalCo/settlementTribalCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                //     write report</a>';
                // $ap_link = '<a type="button" href="' . base_url() . 'index.php/SettlementApCo/settlementApCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                //     write report</a>';
                // $khas_link = '<a type="button" href="' . base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                //     write report</a>';
                // $vgr_link = '<a type="button" href="' . base_url() . 'index.php/SettlementVgrCo/settlementVgrCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                //     write report</a>';
                // $tea_link = '<a type="button" href="' . base_url() . 'index.php/SettlementTeaCo/settlementTeaCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                //     write report</a>';

                $tenant_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>

                    <br>
                    <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                    write report</a>';

                $tribal_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>

                    <br>

                    <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                    write report</a>';

                $ap_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                    <br>

                    <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                    write report</a>';

                $khas_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>


                    <br>
                    <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="mt-1 lmreportmut btn-sm btn btn-primary">
                    write report</a>';

                $vgr_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                    <br>

                    <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="mt-1 lmreportmut btn-sm btn btn-primary">
                    write report</a>';

                $tea_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                    <br>

                    <a type="button" href="' . base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case=' . $rows->case_no . '" class="mt-1 lmreportmut btn-sm btn btn-primary">
                    write report</a>';

                $json[] = array(
                    $rows->case_no,
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                    $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                    $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    date("Y-m-d", strtotime($rows->date_entry)),

                    // $lmnoteRemark,

                    (($s_code == SETTLEMENT_TENANT_ID) ? $tenant_link : (($s_code == SETTLEMENT_AP_TRANSFER_ID) ? $ap_link : (($s_code == SETTLEMENT_TRIBAL_COMMUNITY_ID) ? $tribal_link : (($s_code == SETTLEMENT_KHAS_LAND_ID) ? $khas_link : (($s_code == SETTLEMENT_PGR_VGR_LAND_ID) ? $vgr_link : (($s_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID) ? $tea_link : '')))))),
                );

            }

            $this->db->where('a.service_code', $s_code);
            $this->db->where('a.pending_officer', MB_CIRCLE_OFFICER);

            if ($this->session->userdata('user_desig_code') == 'CO') {
                // $this->db->where('a.co_code', $user_code);
                // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
                if (LOT_BIFURCATE == 1 && empty($mouza_pargona_code) && empty($lot_no)) {

                    if (isset($lot_string) && $lot_string != null) {
                        $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                    }
                }
            }

            if (!empty($mouza_pargona_code)) {
                $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
            }

            if (!empty($mouza_pargona_code) && !empty($lot_no)) {
                $this->db->where('a.lot_no', $lot_no);
            }

            if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
                $this->db->where('a.vill_townprt_code', $is_cat);
            }

            $this->db->select('a.case_no, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry');

            $this->db->where('a.status', $status);

            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

            $this->db->where('a.notice_generated_yn', null);

            $total_records = $this->db->count_all_results('settlement_basic a');

            // echo $this->db->last_query();die;
            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json,
            );

            echo json_encode($response);

        } else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }

    public function coBulkApproveLmReVerificationReport()
    {
        $casesArray = $this->input->post('selectMark');

        if (!$casesArray) {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#JSMRRC001: No cases selected!',
            ]);
            return false;
        }

        $this->db->trans_begin();

        foreach ($casesArray as $case_no) {
            $getBasicSql = $this->db->query('select * from settlement_basic where case_no = ?', array($case_no))->row();
            //****insert nominee OR delete nominee if AVAIL*/
            $sqlNominee = $this->db->query('select * from settlement_nominee_transaction where case_no = ?', array($case_no));

            $nomineeCount = 0;

            if ($sqlNominee->num_rows() > 0) {
                $nomineeResult = $sqlNominee->result();

                $nomineeCount = count($nomineeResult);

                foreach ($nomineeResult as $nomRow) {
                    //****insert nominee */
                    if ($nomRow->delete_id == 0) {
                        $nomARR = [
                            'case_no' => $nomRow->case_no,
                            'nominee_name' => $nomRow->nominee_name,
                            'address' => $nomRow->address,
                            'relation' => $nomRow->relation,
                            'mobile_no' => $nomRow->mobile_no,
                        ];

                        $nomIns = $this->db->insert('settlement_nominee', $nomARR);

                        if ($nomIns != 1) {
                            $this->db->trans_rollback();
                            echo json_encode([
                                'responseType' => 0,
                                'msg' => '#ERR2260: Unable to approve report!',
                            ]);
                            return false;
                        }

                    } else {
                        //*****delete nominee */
                        $this->db->query('delete from settlement_nominee where case_no = ? and id = ?', array($nomRow->case_no, $nomRow->delete_id));

                        if ($this->db->affected_rows() != 1) {
                            $this->db->trans_rollback();
                            echo json_encode([
                                'responseType' => 0,
                                'msg' => '#ERR2277: Unable to approve report!',
                            ]);
                            return false;
                        }
                    }
                }
            }

            //****insert dag related DATA */
            $approvSql = $this->db->query('select * from settlement_approval_transaction where case_no = ?', array($case_no));

            if ($approvSql->num_rows() <= 0) {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR2293: Unable to approve report!',
                ]);
                return false;
            }

            $approvResult = $approvSql->result();

            $approvalCount = count($approvResult);

            foreach ($approvResult as $approvRow) {
                $updateDagArr = [
                    'new_patta_type' => $approvRow->patta_type_code,
                    'new_possession' => $approvRow->possession_from,
                    'new_land_class_home' => $approvRow->landclass_home,
                    'new_land_class_agri' => $approvRow->landclass_agri,
                    'landmark' => $approvRow->landmark,
                    'landmark_with_code' => $approvRow->landmark_with_code,

                    'new_home_land_revenue' => $approvRow->new_home_land_revenue,
                    'new_agri_land_revenue' => $approvRow->new_agri_land_revenue,
                    'new_home_land_local_tax' => $approvRow->new_home_land_local_tax,
                    'new_agri_land_local_tax' => $approvRow->new_agri_land_local_tax,
                    'new_total_revenue' => $approvRow->new_total_revenue,
                    'new_total_tax' => $approvRow->new_total_tax,
                ];

                $this->db->where('case_no', $case_no);

                if ($getBasicSql->service_code == '14') {
                    $this->db->where('new_dag_no', $approvRow->dag_no);
                } else {
                    $this->db->where('dag_no', $approvRow->dag_no);
                }

                $this->db->update('settlement_dag_details', $updateDagArr);
                if ($this->db->affected_rows() != 1) {
                    // echo $this->db->last_query();
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 0,
                        'msg' => '#ERR2320: Unable to approve report!',
                    ]);
                    return false;
                }
            }

            //****udpate basic status */
            $basicArr = [
                'chitha_processing_details' => 2,
                'date_update' => date('Y-m-d H:i:s'),
            ];

            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $basicArr);

            if ($this->db->affected_rows() != 1) {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR2341: Unable to approve report!',
                ]);
                return false;
            }

            //*****delete from transaction table */
            $this->db->query('delete from settlement_approval_transaction where case_no = ?', array($case_no));
            if ($this->db->affected_rows() != $approvalCount) {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR2353: Unable to approve report!',
                ]);
                return false;
            }

            $this->db->query('delete from settlement_nominee_transaction where case_no = ?', array($case_no));
            if ($this->db->affected_rows() != $nomineeCount) {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR2363: Unable to approve report!',
                ]);
                return false;
            }

            //*****insert into proceeding */
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
                'note_on_order' => 'Verification report approved',
                'status' => 'N',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => 'CO',
                'task' => 'Verification report approved',
                // 'note_type' => $this->input->post('lm_note'),
            ];
            $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

            if ($insertProceeding != 1) {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR2403: Unable to approve report!',
                ]);
                return false;
            }

            $getPremiumStatus = $this->db->query('select payment_date from settlement_premium where case_no = ? and is_final = 1 and grn_no is not null', array($case_no, 1));

            if ($getPremiumStatus->num_rows() > 0) {
                $premiumDate = $getPremiumStatus->row()->payment_date;

                $token = $this->utilityclass->createTokenJwt();
                //******send premium date */
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2 . "insertSwikritiIssueDate");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    'appl_no' => $this->utilityclass->getApplidFromCaseNo($case_no),
                    'co_approve_date' => date('Y-m-d H:i:s'),
                    'ip' => $this->utilityclass->get_client_ip(),
                    'api_key' => API_KEY,
                    'token' => $token,
                )));
                $result = curl_exec($curl_handle);

                $result = json_decode($result);

                if (trim($result->responseType) != 'y') {
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 0,
                        'msg' => '#ERR2701: Unable to approve report!',
                    ]);
                    return false;
                }
            }
        }

        $this->db->trans_commit();
        echo json_encode([
            'responseType' => 2,
            'msg' => 'Report successfully approved...',
        ]);
    }

    public function confirmPaymentCo()
    {

        $case_no = $this->input->get('case');
        $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
        // var_dump($get_settlement_basic); die();
        $case_no_rtps = $get_settlement_basic->applid;
        // payment status check thourgh API
        $payment_status_check = $this->SettlementMbModel->paymentConfirmation($case_no_rtps);
        //var_dump($payment_status_check);
        if ($payment_status_check == null || (
            !isset($payment_status_check->payment_status)
            && !isset($payment_status_check->total_premium)
            && !isset($payment_status_check->paid_amount)
            && !isset($payment_status_check->remaining_amount)
            && !isset($payment_status_check->tenure)
            && !isset($payment_status_check->installment_amount)
        )) {
            $total_premium = 0;
            $paid_amount = 0;
            $remaining_amount = 0;
            $tenure = 0;
            $installment_amount = 0;
            $percentage = 0;
            $pay_date = null;
        }

        $pay_status = $payment_status_check->payment_status;
        if (strtoupper($pay_status) == 'Y') {
            $total_premium = $payment_status_check->total_premium;
            $paid_amount = $payment_status_check->paid_amount;
            $remaining_amount = $payment_status_check->remaining_amount;
            $tenure = $payment_status_check->tenure;
            $installment_amount = $payment_status_check->installment_amount;
            $percentage = $payment_status_check->percentage;
            $pay_date = $payment_status_check->payment_date;
        } else {
            $total_premium = 0;
            $paid_amount = 0;
            $remaining_amount = 0;
            $tenure = 0;
            $installment_amount = 0;
            $percentage = 0;
            $pay_date = null;
        }

        $data = [
            'case_no' => $case_no,
            'payment_status' => strtolower($pay_status),
            'payment_date' => $pay_date,
            'case_no_rtps' => $case_no_rtps,
            'total_premium' => $total_premium,
            'paid_amount' => $paid_amount,
            'remaining_amount' => $remaining_amount,
            'tenure' => $tenure,
            'installment_amount' => $installment_amount,
            'percentage' => $percentage,
            //'_view' => 'settlement_mb/confirmPaymentView'
        ];

        if (strtoupper($pay_status) == 'Y') {
            $sqlCheck = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ? and grn_no is null limit 1', array($case_no, 1));

            if ($sqlCheck->num_rows() > 0) {
                $this->db->trans_begin();

                $dagsResult = $this->SettlementKhasModel->getSettlementDag($case_no);
                $isFullPay = 'YES';

                if ($payment_status_check->total_premium != $payment_status_check->paid_amount) {
                    $isFullPay = 'NO';
                }

                $insertArr = [
                    'is_full_pay' => $isFullPay,
                    'total_premium' => $payment_status_check->total_premium,
                    'paid_amount' => $payment_status_check->paid_amount,
                    'remaining_amount' => $payment_status_check->remaining_amount,
                    'tenure' => $payment_status_check->tenure,
                    'installment_amount' => $payment_status_check->installment_amount,
                    'payment_date' => $payment_status_check->payment_date,
                    'grn_no' => $payment_status_check->grn_no,
                ];

                $this->db->where('case_no', $case_no);
                $this->db->where('is_final', 1);
                $this->db->update('settlement_premium', $insertArr);

                if ($this->db->affected_rows() != count($dagsResult)) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "#ERR737: Something went wrong! Unable to process...");
                    redirect(base_url() . "index.php/Home/index");
                }
                $this->db->trans_commit();
            }
        }

        $getNomTrasSql = $this->db->query('select * from settlement_nominee_transaction where case_no = ?', array($case_no));
        if ($getNomTrasSql->num_rows() <= 0) {
            $data['nomTrans'] = false;
        } else {
            $data['nomTrans'] = $getNomTrasSql->result();
        }

        $getNomTrasSql = $this->db->query('select * from settlement_nominee where case_no = ?', array($case_no));
        if ($getNomTrasSql->num_rows() <= 0) {
            $data['nomReal'] = false;
        } else {
            $data['nomReal'] = $getNomTrasSql->result();
        }

        if ($get_settlement_basic->service_code == SETTLEMENT_KHAS_LAND_ID || $get_settlement_basic->service_code == SETTLEMENT_TRIBAL_COMMUNITY_ID || $get_settlement_basic->service_code == SETTLEMENT_PGR_VGR_LAND_ID ||
            $get_settlement_basic->service_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID || $get_settlement_basic->service_code == SETTLEMENT_AP_TRANSFER_ID || $get_settlement_basic->service_code == SETTLEMENT_TENANT_ID) {
            $pattasqll = "SELECT type_code, patta_type FROM patta_code where settlement='y' order by type_code asc";
            $data['_view'] = 'settlement_mb/confirmPaymentView';
        }

        $dist_code = $get_settlement_basic->dist_code;
        $subdiv_code = $get_settlement_basic->subdiv_code;
        $cir_code = $get_settlement_basic->cir_code;
        $q = "Select * from settlement_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and case_no='$case_no'"; // and mouza_pargona_code='$mouza' and lot_no='$lot_no' and vill_townprt_code='$vill'";
        $data['alm'] = $alm = $this->db->query($q)->row();
        $mouza = $get_settlement_basic->mouza_pargona_code;
        $lot_no = $get_settlement_basic->lot_no;
        $vill = $get_settlement_basic->vill_townprt_code;
        //$patta_type = $alm->patta_type_code;
        $data['dagDetails'] = $patta_type_code = $this->db->query("
                SELECT * FROM settlement_dag_details
                WHERE dist_code = '$dist_code' AND subdiv_code = '$subdiv_code'
                AND cir_code = '$cir_code' AND  mouza_pargona_code = '$mouza'
                AND lot_no = '$lot_no' AND vill_townprt_code = '$vill' AND case_no = '$case_no'")->result();

        $data['update_land_class'] = false;

        foreach ($data['dagDetails'] as $dagRow) {
            $getPremSql = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ? and dag_no = ?', array($case_no, '1', $dagRow->dag_no));

            if ($getPremSql->num_rows() <= 0) {
                $dagRow->final_settlement_area = false;
            } else {
                $premiumRow = $getPremSql->row();
                if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                    $total_settlement_area = $this->utilityclass->Total_Bigha_Katha_Lessa2($premiumRow->total_lessa);

                    $dagRow->final_settlement_area = 'B: ' . $total_settlement_area[0] . ' K: ' . $total_settlement_area[1] . ' C: ' . $total_settlement_area[2] . ' G: ' . $total_settlement_area[3];
                } else {
                    $total_settlement_area = $this->utilityclass->Total_Bigha_Katha_Lessa($premiumRow->total_lessa);

                    $dagRow->final_settlement_area = 'B: ' . $total_settlement_area[0] . ' K: ' . $total_settlement_area[1] . ' L: ' . $total_settlement_area[2];
                }
            }

            //****getting the roadside reservation area */
            $reservation = $this->db->query('select * from settlement_reservation where case_no = ? and type = ? and dag_no = ?', array($case_no, 'R', $dagRow->dag_no));

            if ($reservation->num_rows() <= 0) {
                $dagRow->road_side_reservation = false;
            } else {
                $reservation = $reservation->result();

                foreach ($reservation as $reservationRow) {
                    if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                        $dagRow->road_side_reservation = 'B: ' . $reservationRow->bigha . ' K: ' . $reservationRow->katha . ' C: ' . $reservationRow->lessa . ' G: ' . $reservationRow->ganda;
                    } else {
                        $dagRow->road_side_reservation = 'B: ' . $reservationRow->bigha . ' K: ' . $reservationRow->katha . ' L: ' . $reservationRow->lessa;
                    }
                }
            }

            //*****getting the approval report */

            //******getting the final settlement area */
            if ($get_settlement_basic->service_code == '14') {
                $getAppTransSql = $this->db->query('select * from settlement_approval_transaction where case_no = ? and dag_no = ?', array($case_no, $dagRow->new_dag_no));
            } else {
                $getAppTransSql = $this->db->query('select * from settlement_approval_transaction where case_no = ? and dag_no = ?', array($case_no, $dagRow->dag_no));
            }

            if ($getAppTransSql->num_rows() <= 0) {
                $data['approvalRow'] = false;
            } else {
                $appRow = $getAppTransSql->row();

                $dagRow->new_patta_type_code = $appRow->patta_type_code;
                $dagRow->new_possession_from = $appRow->possession_from;
                $dagRow->new_landclass_home = $appRow->landclass_home;
                $dagRow->new_landclass_agri = $appRow->landclass_agri;

                $dagRow->newHomeRevenue = $appRow->new_home_land_revenue;
                $dagRow->newAgriRevenue = $appRow->new_agri_land_revenue;

                $dagRow->newHomeLocalTax = $appRow->new_home_land_local_tax;
                $dagRow->newAgrilocalTax = $appRow->new_agri_land_local_tax;

                $dagRow->new_landmark = json_decode($appRow->landmark);
            }

            $dagRow->landmark = json_decode($dagRow->landmark);

            if ($data['alm']->chitha_processing_details == 2 && (empty($data['alm']->order_passed) || $data['alm']->order_passed == null || $data['alm']->order_passed == '')) {
                $landType = 0;
                $home_b = $dagRow->home_b;
                $home_k = $dagRow->home_k;
                $home_lc = $dagRow->home_lc;
                $home_g = $dagRow->home_g;
                $homestead = $home_b + $home_k + $home_lc + $home_g;
                if ($homestead > 0) {
                    $landType = 1;
                }
                $agri_b = $dagRow->agri_b;
                $agri_k = $dagRow->agri_k;
                $agri_lc = $dagRow->agri_lc;
                $agri_g = $dagRow->agri_g;
                $agriculture = $agri_b + $agri_k + $agri_lc + $agri_g;
                if ($agriculture > 0) {
                    $landType = 2;
                }
                if ($homestead > 0 && $agriculture > 0) {
                    $landType = 3;
                }

                if ($landType == 3) {
                    if (empty($dagRow->new_land_class_home) || empty($dagRow->new_land_class_agri)) {
                        if ($data['update_land_class'] != true) {
                            $data['update_land_class'] = true;
                        }
                    }
                }
            }
        }

        $data['class_code'] = $patta_type_code[0]->new_land_class_code;

        $data['mutpatta'] = $this->db->query($pattasqll)->result();
        $data['newdag'] = $this->utilityclass->maxdag($dist_code, $subdiv_code, $cir_code, $mouza, $lot_no, $vill);
        $data['newpatta'] = 0;
        // $data['newpatta'] = $this->utilityclass->maxpatta($dist_code, $subdiv_code, $cir_code, $mouza, $lot_no, $vill, $patta_type);
        //var_dump($data);
        $q = "SELECT dag_no,patta_no,dag_no_int AS new_dag FROM chitha_basic WHERE dist_code='$dist_code'AND subdiv_code='$subdiv_code'AND cir_code='$cir_code'AND mouza_pargona_code='$mouza'AND lot_no='$lot_no'AND vill_townprt_code='$vill'ORDER BY dag_no_int";
        $data['dag_patta'] = $this->db->query($q)->result();
        $data['dcnote'] = 'Manipulate text';
        $data['land_class_code'] = $this->db->query("Select * from landclass_code")->result();

        //var_dump($data['newdag']);

        $this->load->view('layouts/main', $data);

        // if(isset($_POST['payment_confirmed'])){
        //     $case_no = $this->input->post('case_no');
        //     $this->db->trans_begin();
        //     $updateArr = [
        //         'status' => 'P',
        //         'co_code' => $this->session->userdata('user_code'),
        //         'user_code' => $this->session->userdata('user_code'),
        //         'date_update' => date('Y-m-d h:i:s'),
        //         'from_office' => 'CO',
        //         'pending_officer' => 'DC',
        //         'pending_office' => 'DC',
        //     ];
        //     $this->db->where('case_no', $case_no);
        //     $this->db->update('settlement_basic', $updateArr);
        //     if($this->db->affected_rows() == 0 ){
        //         $this->db->trans_rollback();
        //         log_message('error', '#ERRPN0003: Payment confirmation updation failed in settlement_basic table');
        //         $json = [
        //             'responseType' => 3,
        //             'message' => '#ERRPN0003: Payment confirmation updation failed. Kindly contact system administrator',
        //         ];
        //         echo json_encode($json);
        //         return false;
        //     }
        //     //////proceeding start//////
        //     $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        //     if($proceeding_id==null){
        //         $proceeding_id=1;
        //     }
        //     $insertArr = [
        //         'case_no' => $case_no,
        //         'proceeding_id' => $proceeding_id,
        //         'date_of_hearing' => date('Y-m-d h:i:s'),
        //         'next_date_of_hearing' => date('Y-m-d h:i:s'),
        //         'note_on_order' => 'Payment Cofirmed',
        //         'status' => 'P',
        //         'user_code' => $this->session->userdata('user_code'),
        //         'date_entry' => date('Y-m-d h:i:s'),
        //         'operation' => 'E',
        //         'ip' => $this->utilityclass->get_client_ip(),
        //         'office_from' => 'CO',
        //         'office_to' => 'DC',
        //         'task' => 'Payment Confirmed'
        //     ];
        //     $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        //     if($insertProc != 1){
        //         $this->db->trans_rollback();
        //         log_message('error', '#ERRPN0004: Insertion failed in settlement_proceeding on payment confirmed');
        //         $json = [
        //             'responseType' => 3,
        //             'message' => '#ERRPN0004: Failed to update payment status. Kindly contact System Administrator',
        //         ];
        //         echo json_encode($json);
        //         return false;
        //     }
        //     if($this->db->trans_status()==FALSE){
        //         $this->db->trans_rollback();
        //         $data=array(
        //             'error'=>"Error in submitting. Please try Again"
        //         );
        //         return $data;
        //         exit;
        //     }else{
        //         $this->db->trans_commit();
        //         $this->session->set_flashdata('message', "Payment status updated to confirmed...");
        //         redirect(base_url() . 'index.php/SettlementMbCo/confirmPaymentCo?case='.$case_no);
        //     }
        // }
    }

    public function coReSubmitLmTenantCases()
    {
        $service_code = $this->input->get('service');
        $status = $this->input->get('s');

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $chitha_data['cases'] = $this->db->query("
            SELECT * FROM settlement_basic WHERE dist_code='$dist_code'AND subdiv_code='$subdiv_code'AND cir_code='$cir_code'AND status='X'AND lm_code is not null")->result();
        $chitha_data['_view'] = 'SettlementView/Co/Tenant/coResubmitLmCases';
        $chitha_data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);
        $this->load->view('layouts/main', $chitha_data);
    }

    public function redirectForAPNR()
    {
        $case = $this->input->get('case_no');
        $this->load->helper('qrcode');
        $base_64 = printQR('https://basundhara.assam.gov.in/vo/id=' . $case);
        $data['qrcode'] = $base_64;
        $data['case_no'] = $case;
        //$this->load->view('khaspattamb/khaspatta');
        $sql = "Select * from settlement_basic where case_no=? and status='F' ";
        $caseDetails = $this->db->query($sql, array($case))->row_array();
        $data['distName'] = $this->utilityclass->getDistrictName($caseDetails['dist_code']);
        $data['cirName'] = $this->utilityclass->getCircleName($caseDetails['dist_code'], $caseDetails['subdiv_code'], $caseDetails['cir_code']);
        $data['mouName'] = $this->utilityclass->getMouzaName($caseDetails['dist_code'], $caseDetails['subdiv_code'], $caseDetails['cir_code'], $caseDetails['mouza_pargona_code']);
        $data['villName'] = $this->utilityclass->getVillageName($caseDetails['dist_code'], $caseDetails['subdiv_code'], $caseDetails['cir_code'], $caseDetails['mouza_pargona_code'], $caseDetails['lot_no'], $caseDetails['vill_townprt_code']);
        $sql1 = "select * from settlement_notice WHERE case_no =  ? ";
        $data['notice'] = $this->db->query($sql1, array($case))->row_array();
        $sql2 = "select array_to_string(ARRAY_AGG (pdar_name),',') as applicant_name,
        array_to_string(ARRAY_AGG (pdar_guardian),',') as father_name from settlement_applicant
        WHERE case_no =  ? and pdar_type='B'";
        $data['applicant'] = $this->db->query($sql2, array($case))->row_array();
        //////////////
        $sql3 = "select array_to_string(ARRAY_AGG (new_dag_no),',') as dags,
                sum(home_b+agri_b) as bigha,sum(home_k+agri_k) as katha,sum(home_lc+agri_lc) as lessa,
                array_to_string(ARRAY_AGG (land_type),',') as types
                from settlement_dag_details
                where case_no=?";
        $data['dags'] = $this->db->query($sql3, array($case))->row_array();
        $sql3 = "select dag_no,patta_no,new_dag_no,new_patta_no,new_dag_revenue,new_local_tax,new_land_class_code,
            s_dag_area_b as bigha,s_dag_area_k as katha,
            s_dag_area_lc as lessa
                from settlement_dag_details
                where case_no=?";
        $data['patta'] = $this->db->query($sql3, array($case))->row_array();
        $sql4 = "Select * from settlement_notice where case_no=?";
        $data['notice'] = $this->db->query($sql4, array($case))->row_array();
        //////////////
        $data['_view'] = 'khaspattamb/apnrorder';
        $this->load->view('layouts/main', $data);
    }

    public function redirectForPatta()
    {
        $case = $this->input->get('case_no');
        $this->load->helper('qrcode');
        $base_64 = printQR('https://basundhara.assam.gov.in/vo/id=' . $case);
        $data['qrcode'] = $base_64;
        $data['case_no'] = $case;
        //$this->load->view('khaspattamb/khaspatta');
        $sql = "Select * from settlement_basic where case_no=? and status='F' ";
        $data['basic'] = $caseDetails = $this->db->query($sql, array($case))->row_array();
        $data['distName'] = $this->utilityclass->getDistrictName($caseDetails['dist_code']);
        $data['cirName'] = $this->utilityclass->getCircleName($caseDetails['dist_code'], $caseDetails['subdiv_code'], $caseDetails['cir_code']);
        $data['mouName'] = $this->utilityclass->getMouzaName($caseDetails['dist_code'], $caseDetails['subdiv_code'], $caseDetails['cir_code'], $caseDetails['mouza_pargona_code']);
        $data['villName'] = $this->utilityclass->getVillageName($caseDetails['dist_code'], $caseDetails['subdiv_code'], $caseDetails['cir_code'], $caseDetails['mouza_pargona_code'], $caseDetails['lot_no'], $caseDetails['vill_townprt_code']);
        $sql1 = "select * from settlement_notice WHERE case_no =  ? ";
        $data['notice'] = $this->db->query($sql1, array($case))->row_array();
        $sql2 = "select array_to_string(ARRAY_AGG (pdar_name),',') as applicant_name,
        array_to_string(ARRAY_AGG (pdar_guardian),',') as father_name from settlement_applicant
        WHERE case_no =  ? and pdar_type='B'";
        $data['applicant'] = $this->db->query($sql2, array($case))->row_array();
        //////////////
        $sql3 = "select array_to_string(ARRAY_AGG (new_dag_no),',') as dags,
                sum(home_b+agri_b) as bigha,sum(home_k+agri_k) as katha,sum(home_lc+agri_lc) as lessa,
                array_to_string(ARRAY_AGG (land_type),',') as types,string_agg(distinct(is_urban),',') as rural_urban
                from settlement_dag_details
                where case_no=?";
        $data['dags'] = $this->db->query($sql3, array($case))->row_array();
        $sql3 = "select new_dag_no,new_patta_no,new_dag_revenue,new_local_tax,new_land_class_code,
            home_b+agri_b as bigha,home_k+agri_k as katha,
            home_lc+agri_lc as lessa,is_urban
                from settlement_dag_details
                where case_no=?";
        $data['patta'] = $this->db->query($sql3, array($case))->result_array();
        //////////////
        $data['_view'] = 'khaspattamb/khaspatta';
        $this->load->view('layouts/main', $data);
    }

    public function redirectForTenant()
    {
        $case = $this->input->get('case_no');
        $this->load->helper('qrcode');
        $base_64 = printQR('https://basundhara.assam.gov.in/vo/id=' . $case);
        $data['qrcode'] = $base_64;
        $data['case_no'] = $case;
        $sql = "Select * from settlement_basic where case_no=? and status='F' ";
        $caseDetails = $this->db->query($sql, array($case))->row_array();
        $data['distName'] = $this->utilityclass->getDistrictName($caseDetails['dist_code']);
        $data['cirName'] = $this->utilityclass->getCircleName($caseDetails['dist_code'], $caseDetails['subdiv_code'], $caseDetails['cir_code']);
        $data['mouName'] = $this->utilityclass->getMouzaName($caseDetails['dist_code'], $caseDetails['subdiv_code'], $caseDetails['cir_code'], $caseDetails['mouza_pargona_code']);
        $data['villName'] = $this->utilityclass->getVillageName($caseDetails['dist_code'], $caseDetails['subdiv_code'], $caseDetails['cir_code'], $caseDetails['mouza_pargona_code'], $caseDetails['lot_no'], $caseDetails['vill_townprt_code']);
        $data['lotName'] = $this->utilityclass->getLotLocationName($caseDetails['dist_code'], $caseDetails['subdiv_code'], $caseDetails['cir_code'], $caseDetails['mouza_pargona_code'], $caseDetails['lot_no']);
        $sql2 = "select array_to_string(ARRAY_AGG (pdar_name),',') as applicant_name,
        array_to_string(ARRAY_AGG (pdar_guardian),',') as father_name from settlement_applicant
        WHERE case_no =  ? and pdar_type='B'";
        $data['applicant'] = $this->db->query($sql2, array($case))->row_array();
        $sql2 = "select array_to_string(ARRAY_AGG (pdar_name),',') as applicant_name,
        array_to_string(ARRAY_AGG (pdar_guardian),',') as father_name from settlement_applicant
        WHERE case_no =  ? and pdar_type='O'";
        $data['owner'] = $this->db->query($sql2, array($case))->row_array();
        $sql3 = "Select * from settlement_dag_details where case_no=?";
        $data['dag'] = $this->db->query($sql3, array($case))->row_array();
        //$this->load->view('khaspattamb/khaspatta');
        $data['_view'] = 'khaspattamb/tenantpatta';
        $this->load->view('layouts/main', $data);
    }

    public function autosubmit()
    {
        //echo $this->input->post('htmlstring_text');
        $data = $this->convertHtmlToPDF($this->input->post('htmlstring_text'));
        //echo "<br><br><br><br><br>-----------------";
        $data_Patta = $this->convertHtmlToPDF($this->input->post('htmlstring_text_patta'));
        // echo "<br>-----------------";
        // die;
        //log_message('error',$data_Patta);
        $case_no = $this->input->post('case_no');
        ///////////File Write////////////////
        $new_case_no = str_replace('/', "-", $case_no);
        if (is_dir(UPLOAD_BASE . 'delivery') === false) {
            mkdir(UPLOAD_BASE . 'delivery', 0777, true);
        }
        $location = DELIVERY_DOCS . $new_case_no;
        if (is_dir($location) === false) {
            mkdir($location, 0777);
        }
        $base_64_file_path = $location . "/" . $new_case_no . "-order.json";
        $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
        $htmlstring_text = json_encode($this->input->post('htmlstring_text'));
        fwrite($file_to_write_base64, $htmlstring_text);
        /////////////////////////
        $base_64_file_path = $location . "/" . $new_case_no . "-patta.json";
        $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
        $htmlstring_text = json_encode($this->input->post('htmlstring_text_patta'));
        fwrite($file_to_write_base64, $htmlstring_text);
        fclose($file_to_write_base64);
        /////////////End File/////////////////
        $sql = "Select * from settlement_basic where case_no=?  ";
        $main = $this->db->query($sql, array($case_no))->row_array();
        if (empty($main)) {
            redirect('/home');
        }

        $rtps_no = $main['applid'];
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2 . "uploadDeliveryDocs");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'encoded_file_patta' => $data_Patta,
            'encoded_file_order' => $data,
            'user_code' => $this->session->userdata('user_code'),
            'remark' => "Auto Update for PATTA/ORDER",
            'dharitree_case' => $case_no,
            'application_no' => $rtps_no,
            'pending_with_officer' => 'NA',
            'status' => 'F',
        )));
        $response = curl_exec($curl_handle);
        // $response=json_decode($response);
        curl_close($curl_handle);
        log_message('error', "API-RESPONSE##" . $case_no . "######" . $response);
        if (trim($response) == 'y' || trim($response) === true || trim($response) == 'true' || trim($response) == 1) {
            $this->session->set_flashdata('message', "<p>##$case_no## Order has been Passed successfully </p>
                <p>Settlement Order and Patta has been delivered to Citizen</p>");
            redirect('/home');
        } else {
            show_error('error');
        }
    }

    public function convertHtmlToPDF($base64)
    {
        include 'vendor\mpdf\vendor\autoload.php';
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetWatermarkText('MISSION BASUNDHARA 3.0');
        $mpdf->showWatermarkText = true;
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $html .= '<html ng-app="myApp">
        <title>MISSION BASUNDHARA 3.0</title>
        <style>
        @page {
            border:1px solid black;
        }
        html{
            border:1px solid black;
        }
        body {
            font-family: serif;
            font-size: 13px;
            border:1px solid;
        }
        h4,h3{
            font-size: 32px;
            text-align:center;
        }
        p {
            font-family: serif;
            font-size: 13px;
        }
        h5 {
            font-family: serif;
            font-size: 13pt;
        }
        th {
            text-align: center;
        }
        .centrar{
            margin-right:auto;
            margin-left:auto;
            width: 80%;
            text-align:center;
        }
        @media print {
        h4,h3{
            font-size: 8pt;
            text-align:center;
        }
        .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
          float: none;
        }
        .col-sm-12 {
          width: 100%;
        }
        .col-sm-11 {
          width: 91.66666666666666%;
        }
        .col-sm-10 {
          width: 83.33333333333334%;
        }
        .col-sm-9 {
          width: 75%;
        }
        .col-sm-8 {
          width: 66.66666666666666%;
        }
        .col-sm-7 {
          width: 58.333333333333336%;
        }
        .col-sm-6 {
          width: 50%;
        }
        .col-sm-5 {
          width: 41.66666666666667%;
        }
        .col-sm-4 {
          width: 33.33333333333333%;
         }
         .col-sm-3 {
           width: 25%;
         }
         .col-sm-2 {
           width: 16.666666666666664%;
         }
         .col-sm-1 {
          width: 8.333333333333332%;
         }

        }
        </style>
        <body class="view" style="border:2px solid #000000;">
        <div class="container" id="exportthis" ng-controller="Ctrl">
        <div class="border">';
        $html .= base64_decode($base64);
        $html .= '</div></div></body></html>';
        //echo $html;
        $mpdf->writeHTML($html);
        ob_clean();
        //echo $mpdf->Output('','I');
        return $b64Doc = chunk_split(base64_encode($mpdf->Output('', 'S')));
    }

    public function coRevertedCases()
    {

        $data['getFirstProceeding'] = $this->SettlementMbModel->getCoRevertedCases();

        $service_code = $this->input->get('service');
        $status = $this->input->get('s');
        $data['select_data'] = $this->SettlementCommonModel->locationSelectCoRevertCases($service_code, $status);
        $data['_view'] = 'settlement_mb/co_reverted_cases';

        $this->load->view('layouts/main', $data);
    }

    public function coForwardedCases()
    {

        $service_code = $this->input->get('service');
        $status = $this->input->get('s');
        $data['select_data'] = $this->SettlementCommonModel->locationSelectCoForwardCases($service_code, $status);
        $data['_view'] = 'settlement_mb/co_forwarded_cases';

        $this->load->view('layouts/main', $data);
    }

    public function coRejectCases()
    {

        $service_code = $this->input->get('service');
        $status = $this->input->get('s');
        $data['select_data'] = $this->SettlementCommonModel->locationSelectCoRejectCases($service_code, $status);
        $data['_view'] = 'settlement_mb/co_reject_cases';

        $this->load->view('layouts/main', $data);
    }

    public function coRevivalCases()
    {

        $service_code = $this->input->get('service');
        $status = $this->input->get('s');
        $data['select_data'] = $this->SettlementCommonModel->locationSelectCoRejectCases($service_code, $status);

        $stringRejectList = "'" . implode("','", REVIVAL_REJECT_CODE) . "'";

        $sql = $this->db->query("select distinct(b.reject_code), b.remark from rejected_remark a join reject_master b on a.reject_code::varchar = b.reject_code::varchar where a.reject_code in ($stringRejectList) and b.service_code = ? and b.remark_head is not null", array($service_code));

        if ($sql->num_rows() <= 0) {
            $data['rejected_array'] = array();
        } else {
            $data['rejected_array'] = $sql->result();
        }

        $data['_view'] = 'settlement_mb/co_revival_cases';

        $this->load->view('layouts/main', $data);
    }

    public function apNoticeGenertaedCases()
    {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $chitha_data['cases'] = $this->db->query("
            SELECT * FROM settlement_basic WHERE dist_code='$dist_code'AND subdiv_code='$subdiv_code'AND cir_code='$cir_code' AND service_code = '14' AND (pending_officer = 'CO' or pending_officer = 'LM')")->result();

        $chitha_data['select_data'] = $this->SettlementCommonModel->apNoticeCases();

        // echo $this->db->last_query();
        $chitha_data['_view'] = 'settlement_mb/co_print_notice_cases';

        $this->load->view('layouts/main', $chitha_data);
    }

    //MB: -----------------------NEWLY ADDED WITH BULK FORWARD---12102023
    public function dcRevertedCases()
    {

        $data['getFirstProceeding'] = $this->SettlementMbModel->getDcRevertedCases();

        $service_code = $this->input->get('service');
        if ($service_code != '14') {
            return $this->dcRevertedCasesExceptAp();
        }
        $status = $this->input->get('s');
        $data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);

        // $data['_view'] = 'settlement_mb/first_proceeding_co';

        $data['_view'] = 'settlement_mb/dc_revert_cases_new';
        $this->load->view('layouts/main', $data);
    }

    public function disposedCases()
    {
        $service_code = $this->input->get('service');
        $status = $this->input->get('s');

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $chitha_data['cases'] = $this->db->query("
            SELECT * FROM settlement_basic WHERE dist_code='$dist_code'AND subdiv_code='$subdiv_code'AND cir_code='$cir_code'AND status='F'")->result();

        $chitha_data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);
        $chitha_data['_view'] = 'settlement_mb/disposed_cases';

        $this->load->view('layouts/main', $chitha_data);
    }
    // Pagination for co end 11-10-2023 -js-
    public function getListofPaymentNoticeCases()
    {

        if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
            $lot_string = $this->caseListUnderMappingLot();
        }

        $s_code = $this->input->post('service');
        $search_term = $this->input->post('search_term');
        $remark_cat = $this->input->post('remark_cat');
        $user_code = $this->session->userdata('user_code');

        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $urban_rural = $this->input->post('urban_rural');
        $status = $this->input->post('status');
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        $col = 0;
        $dir = "";
        $search = $this->input->post('search');
        $search = $search['value'];

        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];
        $searchByCol_3 = $this->input->post('columns')[3]['search']['value'];

        $is_cat = $this->input->post('is_category');

        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'asc';
        }

        $valid_columns = array(
            0 => 'date_entry',
            // 1   => 'applid',
        );

        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        if ($order != null) {
            $this->db->order_by($order, $dir);
        }

        // if(!empty($search)){
        //     // $this->db->like($s_terms, $search);
        //     $this->db->like('case_no', $search);
        // }

        if (!empty($searchByCol_0)) {

            $this->db->like('a.case_no', strtoupper($searchByCol_0));
        }

        if (!empty($searchByCol_1)) {

            $this->db->like('a.applid', strtoupper($searchByCol_1));
        }

        if (!empty($searchByCol_3)) {
            $this->db->like('TO_CHAR(a.date_entry,\'yyyy-mm-dd\')', $searchByCol_3);
            //$this->db->like('date_entry', $searchByCol_2);
        }

        $this->db->limit($length, $start);

        $this->db->where('a.service_code', $s_code);

        if (!empty($remark_cat)) { //settlement_ap_lmnote, lm_note
            $this->db->where('b.lm_note', $remark_cat);
        }

        if (!empty($mouza_pargona_code)) {
            $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
        }

        if (!empty($mouza_pargona_code) && !empty($lot_no)) {
            $this->db->where('a.lot_no', $lot_no);
        }

        if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }
        // and (from_office='DC' OR from_office='ADC' OR from_office='SDO') and pending_officer='CO'

        if ($this->session->userdata('user_desig_code') == 'CO') {
            // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
            if (LOT_BIFURCATE == 1 && empty($mouza_pargona_code) && empty($lot_no)) {
                if (isset($lot_string) && $lot_string != null) {
                    $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                }
            }

            // $this->db->orWhere('a.co_code', null);
        }

        //$premPercentage = array(1,2,3,4,5,6,11,12,13,14,15,16,17);
        //$premRupees = array(7,8,9,10,18,19,20,21,22);

        $this->db->select('distinct(a.case_no), a.applid, a.service_code, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry,b.lm_note');

        $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
        $this->db->join('settlement_premium p', 'a.case_no = p.case_no');
        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
        $this->db->where('a.status', $status);
        $this->db->where('p.is_final', 1);
        $this->db->where('a.pending_officer', MB_CIRCLE_OFFICER);
        //for urban case------------
        if ($urban_rural == 'U') {
            $checkArea = array(1, 2, 3, 4, 5, 6, 11, 12, 13, 14, 15, 16, 17);
            $this->db->where_in('p.area_name', $checkArea);

        } else if ($urban_rural == 'R') {
            $checkArea = array(7, 8, 9, 10, 18, 19, 20, 21, 22);
            $this->db->where_in('p.area_name', $checkArea);
        } else {
            $checkArea = array(1, 2, 3, 4, 5, 6, 11, 12, 13, 14, 15, 16, 17, 7, 8, 9, 10, 18, 19, 20, 21, 22);
            $this->db->where_in('p.area_name', $checkArea);
        }

        $this->db->from('settlement_basic a');

        $query = $this->db->get();

        // log_message('error','------------'.$this->db->last_query());

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {

                if ($urban_rural == 'U') {
                    $ruralYesNo = 'N';
                    $case_type = 'DEPARTMENT';
                } else if ($urban_rural == 'R') {
                    $ruralYesNo = $rows->case_no;
                    $case_type = 'DC';
                } else {
                    $area_name = $this->getDepartmentDC($rows->case_no);
                    if (in_array($area_name, array(1, 2, 3, 4, 5, 6, 11, 12, 13, 14, 15, 16, 17))) {
                        $ruralYesNo = 'N';
                        $case_type = 'DEPARTMENT';
                    } else if (in_array($area_name, array(7, 8, 9, 10, 18, 19, 20, 21, 22))) {
                        $ruralYesNo = $rows->case_no;
                        $case_type = 'DC';
                    }
                }

                if (trim($rows->lm_note) == 1) {
                    $lmnoteRemark = 'Recommended';
                } else {
                    $lmnoteRemark = 'Not Recommended';
                }

                $urbanLink = '<a type="button" href="' . base_url() . 'index.php/SettlementCommon/verifyLandClassZone?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">Payment Notice</a>';

                if ($rows->service_code == '13') {
                    $ruralController = 'SettlementTenantCo';
                } else if ($rows->service_code == '14') {
                    $ruralController = 'SettlementApCo';
                } else if ($rows->service_code == '15') {
                    $ruralController = 'SettlementTribalCo';
                } else if ($rows->service_code == '16') {
                    $ruralController = 'SettlementKhasCo';
                } else if ($rows->service_code == '17') {
                    $ruralController = 'SettlementVgrCo';
                } else if ($rows->service_code == '18') {
                    $ruralController = 'SettlementTeaCo';
                }

                $ruralLink = '<a type="button" href="' . base_url() . 'index.php/' . $ruralController . '/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                Payment Notice</a>';

                $area_name = $this->getDepartmentDC($rows->case_no);

                $paymentNoticeLink = 'NA';

                if ($ruralYesNo == 'N' && $case_type == 'DEPARTMENT' && in_array($area_name, array(1, 2, 3, 4, 5, 6, 11, 12, 13, 14, 15, 16, 17))) {
                    $paymentNoticeLink = $urbanLink;
                } else {
                    $paymentNoticeLink = $ruralLink;
                }

                if ($status == MB_PAYMENT_REQUEST) {
                    $tenant_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                        <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementTenantCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                        Generate Payment Notice</a>';

                    $tribal_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                        <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        ' . $paymentNoticeLink;

                    $ap_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                        <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        ' . $paymentNoticeLink;

                    $khas_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                        <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        ' . $paymentNoticeLink;

                    $vgr_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                        <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        ' . $paymentNoticeLink;

                    $tea_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '">
                        <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementTeaCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                        Generate Payment Notice</a>';

                }

                $json[] = array(
                    $ruralYesNo,
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                    $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                    $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    // $rows->date_entry,
                    date("Y-m-d", strtotime($rows->date_entry)),
                    $lmnoteRemark,
                    $case_type,
                    (($s_code == SETTLEMENT_TENANT_ID) ? $tenant_link : (($s_code == SETTLEMENT_AP_TRANSFER_ID) ? $ap_link : (($s_code == SETTLEMENT_TRIBAL_COMMUNITY_ID) ? $tribal_link : (($s_code == SETTLEMENT_KHAS_LAND_ID) ? $khas_link : (($s_code == SETTLEMENT_PGR_VGR_LAND_ID) ? $vgr_link : (($s_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID) ? $tea_link : '')))))),

                );
            }

            $this->db->where('a.service_code', $s_code);
            if (!empty($remark_cat)) { //settlement_ap_lmnote, lm_note
                $this->db->where('b.lm_note', $remark_cat);
            }
            if ($this->session->userdata('user_desig_code') == 'CO') {
                // $this->db->where('a.co_code', $user_code);
                // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
                if (LOT_BIFURCATE == 1 && empty($mouza_pargona_code) && empty($lot_no)) {

                    if (isset($lot_string) && $lot_string != null) {
                        $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                    }
                }
            }

            if (!empty($mouza_pargona_code)) {
                $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
            }

            if (!empty($mouza_pargona_code) && !empty($lot_no)) {
                $this->db->where('a.lot_no', $lot_no);
            }

            if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
                $this->db->where('a.vill_townprt_code', $is_cat);
            }

            //for urban case------------
            if ($urban_rural == 'U') {
                $checkArea = array(1, 2, 3, 4, 5, 6, 11, 12, 13, 14, 15, 16, 17);
                $this->db->where_in('p.area_name', $checkArea);

            } else if ($urban_rural == 'R') {
                $checkArea = array(7, 8, 9, 10, 18, 19, 20, 21, 22);
                $this->db->where_in('p.area_name', $checkArea);
            } else {
                $checkArea = array(1, 2, 3, 4, 5, 6, 11, 12, 13, 14, 15, 16, 17, 7, 8, 9, 10, 18, 19, 20, 21, 22);
                $this->db->where_in('p.area_name', $checkArea);
            }

            $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
            $this->db->join('settlement_premium p', 'a.case_no = p.case_no');
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
            $this->db->where('a.status', $status);
            $this->db->where('a.pending_officer', MB_CIRCLE_OFFICER);
            $this->db->where('p.is_final', 1);

            $total_records = $this->db->count_all_results('settlement_basic a');
            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json,
            );

            echo json_encode($response);

        } else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }
    public function getDepartmentDC($caseNo)
    {
        $sql = 'select area_name from settlement_premium where  case_no = ? and is_final = ?';
        $area_name = $this->db->query($sql, array($caseNo, 1))->row();
        if (isset($area_name) && $area_name != null) {
            return $area_name->area_name;
        } else {
            return null;
        }
    }

    public function convertLiteral($array)
    {
        $index = 0;
        $final_str = '';
        foreach ($array as $a) {
            if ($index == 0) {
                $final_str = "'" . $a . "'";
            } else {
                $final_str = $final_str . ",'" . $a . "'";
            }

            $index++;
        }
        return $final_str;
    }

    public function caseListUnderMappingLot()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        //////////////////MARKING FOR CIRCLE WISE LOT MAPPING===========
        $sql = "Select user_code from loginuser_table where dist_code=? and subdiv_code=? and cir_code=? and dis_enb_option='E' and user_code like 'CO%'";
        $data = $this->db->query($sql, array($dist_code, $subdiv_code, $cir_code));
        $lot_array = array();
        if ($data->num_rows() > 1) {
            $sql1 = "Select * from user_attached_mapping where dist_code=? and subdiv_code=? and cir_code=? and user_code=? ";
            $data1 = $this->db->query($sql1, array($dist_code, $subdiv_code, $cir_code, $user_code));

            foreach ($data1->result() as $key => $value) {
                $lot_array[] = $value->mouza_pargona_code . '_' . $value->lot_no;
            }
            //////////////////
        }
        $lot_string = null;
        if (!empty($lot_array) && $lot_array != null) {
            $lot_string = $this->convertLiteral($lot_array);
        }
        log_message("error", "MB: LOT STRING====FOR CIRCLE==D" . $dist_code . "S" . $subdiv_code . "C" . $cir_code . "==" . json_encode($lot_string));
        return $lot_string;
    }

    public function coBulkPaymentNoticeGenerateAndSave()
    {
        // generate notice starts here

        $markedApplications = $this->input->post('selectMark');

        if (count($markedApplications) == 0) {
            $json = [
                'responseType' => 3,
                'message' => '#ERRCO098001: Kindly choose case no...',
            ];
            echo json_encode($json);
            return;
        }

        if (count($markedApplications) > 10) {
            log_message("error", '#ERRCO09876: Failed to generate notice. Selection Limit 10 Only');
            $json = [
                'responseType' => 3,
                'message' => '#ERRCO09876: Failed to generate notice. Selection Limit 10 Only',
            ];
            echo json_encode($json);
            return;
        }
        $remark_co = $this->input->post('remark_co');
        $completedCases = array();
        foreach ($markedApplications as $key => $value) {

            $case_no = $value;

            $case_under_wetland = $this->SettlementCommonModel->caseUnderDeptOrDCByWetLand($case_no);
            //check whether dag in wetland--------------
            if ($case_under_wetland == 1) {
                $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
                if ($get_settlement_basic->from_office != 'DPT') {
                    log_message('error', '#ERROR990030987: Unable to re calculate premium. Case No ' . $case_no . 'and query is ' . $this->db->last_query());
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERROR990030987: Dag no. under wetland area and not approved by Department this case' . $case_no,
                        'list' => json_encode($completedCases),
                    ];
                    echo json_encode($json);
                    return;
                }

            }
            $dataPrint = $this->getPremiumNoticeDetailsByCaseNo($case_no);
            if ($dataPrint['pull_request_active'] == 1) {
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0987654: Modification request enabled for this case' . $case_no,
                    'list' => json_encode($completedCases),
                ];
                echo json_encode($json);
                return;
            }
            $dataPrint['co_remarks'] = $remark_co;
            if ($dataPrint['isUrban'] == 'Y') {
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO09877: Urban Case premium notice will be available soon',
                    'list' => json_encode($completedCases),
                ];
                echo json_encode($json);
                return;
            }
            $PayloadString = json_encode($dataPrint);

            $htmlString = $this->getPremiumNoticeGenerationString($PayloadString);

            if (isset($htmlString) && $htmlString != null && $htmlString != '') {

                $this->db->trans_begin();

                $this->savePaymentNoticeBulkByCO($case_no, $htmlString, $PayloadString, $completedCases);

                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    log_message('error', 'Something went wrong...transaction failed for case_no==' . $case_no);

                    return false;
                } else {
                    $this->db->trans_commit();
                    $completedCases[] = $case_no;

                }
            } else {
                log_message('error', "#ERRCO09877: Failed to generate htmlString for the case_no==" . $case_no);
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO09877: Failed to generate htmlString for the case_no==' . $case_no,
                    'list' => json_encode($completedCases),
                ];
                echo json_encode($json);
                return;

            }
        }

        echo json_encode([
            'responseType' => 2,
            'message' => 'Payment Notice successfully generated for the selected cases...',
            'list' => json_encode($completedCases),
        ]);

    }

    public function getPremiumNoticeDetailsByCaseNo($case_no)
    {
        $applicant_buyer = $this->SettlementKhasModel->getAllApplicantBuyers($case_no);
        $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);

        $data = [
            'case_no' => $case_no,
            // 'remark' => $remark,
            'get_settlement_basic' => $get_settlement_basic,
            'pay_notice_date' => date('Y-m-d'),
        ];

        if (isset($applicant_buyer)) {
            foreach ($applicant_buyer as $applicant) {
                if ($applicant->is_applicant == 1) {
                    $data['applicant_name'] = $applicant->pdar_name;
                    $data['guardian_name'] = $applicant->pdar_guardian;
                }
            }
        }

        $basic = $this->SettlementKhasModel->getSettlementBasic($case_no);

        $data['pull_request_active'] = $basic['pull_request'];

        if (isset($basic)) {
            if ($basic['service_code'] == SETTLEMENT_TENANT_ID) {
                $data['service_name'] = 'Settlement Occupency Tenant';
            } elseif ($basic['service_code'] == SETTLEMENT_AP_TRANSFER_ID) {
                $data['service_name'] = 'Settlement AP';
            } elseif ($basic['service_code'] == SETTLEMENT_TRIBAL_COMMUNITY_ID) {
                $data['service_name'] = 'Settlement Tribal Community';
            } elseif ($basic['service_code'] == SETTLEMENT_KHAS_LAND_ID) {
                $data['service_name'] = 'Settlement Khasland';
            } elseif ($basic['service_code'] == SETTLEMENT_PGR_VGR_LAND_ID) {
                $data['service_name'] = 'Settlement PGR/VGR land';
            } elseif ($basic['service_code'] == SETTLEMENT_SPECIAL_CULTIVATORS_ID) {
                $data['service_name'] = 'Settlement Special Cultivators';
            }

            $data['case_no'] = $basic['case_no'];
            $data['application_no'] = $basic['applid'];

            $data['dist_name'] = $this->utilityclass->getDistrictName($basic['dist_code']);
            $data['circle_name'] = $this->utilityclass->getCircleName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
            $data['mouza_name'] = $this->utilityclass->getMouzaName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code']);

            $data['lot_name'] = $this->utilityclass->getLotName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no']);

            $data['village_name'] = $this->utilityclass->getVillageName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no'], $basic['vill_townprt_code']);

            $data['date_of_sldc'] = date('d/m/Y', strtotime($basic['sdlac_date']));

        }

        $dags = $this->SettlementKhasModel->getSettlementDag($case_no);
        if (isset($dags)) {
            foreach ($dags as $dag_item) {
                $data['isUrban'] = $dag_item->is_urban;
            }
        }

        $this->load->model('SettlementMb/SettlementCommonDcModel');

        $urbanByLm = $this->SettlementCommonDcModel->getLandFallsUnderUrban($case_no);

        $premium_data = $this->db->query("SELECT sp.*,spa.area,spl.land_type,spr.house_type FROM settlement_premium sp inner join settlement_premium_area spa on spa.paid=sp.area_name inner join settlement_premium_land_type spl on spl.plid=sp.land_type inner join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no=? and is_final=?", array($case_no, 1));

        if ($premium_data->num_rows() > 0) {

            $caseUrban = null;
            $premium_data_row = $premium_data->row();
            $premium_data_arr = $premium_data->result();

            if (trim($basic['approve_by'] == '') || empty(trim($basic['approve_by']))) {
                if (trim($data['isUrban']) == 'N' && $urbanByLm->falls_und_gmc != YES) {
                    $caseUrban = "N";
                } else if (trim($data['isUrban']) == 'Y' || (trim($data['isUrban']) == 'N' && $urbanByLm->falls_und_gmc == YES)) {
                    $caseUrban = "Y";
                }

            } else {
                if (trim($basic['approve_by'] == 'DC')) { /////consider as rural case
                    $caseUrban = "N";
                } else if (trim($basic['approve_by'] == 'GOVT')) {
                    $caseUrban = "Y";
                }

            }

            if (isset($basic['is_wed_land']) && $basic['is_wed_land'] == 1) {
                $caseUrban = "N";
            }
            //*******for rural case */
            if ($caseUrban == 'N') {
                $area_all = array();
                $area_all_barak = array();
                $dag_arr = array();
                $data['actual_premium'] = 0;
                foreach ($premium_data_arr as $premium) {

                    $dag_arr[] = $premium->dag_no;

                    $data['net_premium_payable'] = $premium->final_amount;
                    $data['mission_cocession_rate'] = $premium->rate;

                    if (trim($premium->concession) == 'YES') {
                        $data['type_of_concession'] = 'ST/SC/Widows/Person with disabilities';
                        // $data['premium_payable_without_concession'] = $data['net_premium_payable'] + ($data['net_premium_payable'] * 25/100);
                        $data['premium_payable_without_concession'] = ceil($data['net_premium_payable'] / 0.75);
                        $data['concession_amount'] = ceil($data['premium_payable_without_concession'] * 0.25);
                        $data['concession_mission_govt_notification_no'] = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
                        $data['actual_premium'] = (float) $data['premium_payable_without_concession'] * 5;
                    } else {
                        $data['type_of_concession'] = '-';
                        $data['concession_mission_govt_notification_no'] = '-';
                        $data['concession_amount'] = '-';
                        $data['premium_payable_without_concession'] = $data['net_premium_payable'];
                        $data['actual_premium'] += (float) $premium->amount_dag * 5;
                    }

                    // $data['actual_premium'] += (float)$premium->amount_dag * 5;

                    $total_lessa = $premium->total_lessa;

                    if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY))) {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa);
                    } else {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                    }

                    $area_all[] = 'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' লে: ' . $bklArr[2];
                    $area_all_barak[] = 'বি: ' . $bklArr[0] . ' ক: ' . $bklArr[1] . ' চ: ' . $bklArr[2] . ' গ: ' . $bklArr[3] . ' ক্ৰা: 0';
                }

                $data['area'] = implode(", ", $area_all);
                $data['area_barak'] = implode(", ", $area_all_barak);
                $data['dag_no'] = implode(", ", $dag_arr);

                if ($data['type_of_concession'] == '-') {
                    $data['concession_area'] = '-';
                    $data['concession_dag_no'] = '-';
                } else {
                    $data['concession_area'] = $data['area'];
                    $data['concession_dag_no'] = $data['dag_no'];
                }

                $data['premium_per_bigha'] = '500';
                $data['mission_per_bigha'] = '100';
            }

            //*****for urban case */
            // if(trim($data['isUrban']) == 'Y' || (trim($data['isUrban']) == 'N' && $urbanByLm->falls_und_gmc == YES))
            if ($caseUrban == 'Y') /////consider as urban case
            {

            }
        }

        $data['isUrban'] = $caseUrban;

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2 . "getApplicationDate");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application_no' => $data['application_no'],
        )));
        $output = curl_exec($curl_handle);
        if (isset(json_decode($output)->responseType)) {
            if (json_decode($output)->responseType != 'y') {
                echo json_decode($output)->data . " - Unauthorized access!";
                return false;
            }
        }
        curl_close($curl_handle);
        $res = json_decode($output);

        $data['date_of_application'] = date('d/m/Y', strtotime($res->submission_date));

        $data['date'] = date('d/m/Y', strtotime(date('Y-m-d')));
        $data['payment_date'] = date('d/m/Y', strtotime($data['date'] . ' + 15 days'));
        $data['actual_govt_notification_no'] = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
        $data['mission_govt_notification_no'] = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';

        $this->load->helper('qrcode');
        $base_64 = printQR('https://sewasetu.assam.gov.in/');
        $data['qrcode'] = $base_64;
        return $data;
    }

    public function getPremiumNoticeGenerationString($PayloadString)
    {
        $data = json_decode($PayloadString);
        // echo "<pre>";
        // var_dump($data->get_settlement_basic->dist_code);
        // die;
        $html = "";

        $html .= '<div id="printableArea">

           <div class="container bg-white shadow" id="print_direct">
           <style>
            table {
                  width: 100%;
                  max-width: 100%;
                  margin-bottom: 1rem;
            }

            table th,
            table td {
            padding: 0.40rem;
            /* vertical-align: top; */
            border: 1px solid #191919;
            }

         </style>
               <div style="position: absolute; margin-right:100px; right:10px; margin-top: 15px;">';?>
        <?php

        $dataqr = explode(",", $data->qrcode);
        $dataqr = $dataqr[1];
        $html .= '<img class="img-fluid" src="data:image/png;base64,' . $dataqr . '" />';
        ?>



        <?php $html .= '</div>
              <div class="row mt-5 text-center">
                 <div class="col-12 text-center" style="font-size: 18px; font-weight:bold;">
                    অসম চৰকাৰ
                    <br>
                    চক্ৰ বিষয়াৰ কাৰ্যালয়,' . $data->circle_name . ' ৰাজহ চক্ৰ
                    <br>
                    জিলা- ' . $data->dist_name . '
                    <br>
                    <br>
                    জাননী
                    <br>
                    ' . $data->date . '
                 </div>



              </div>

              <div class="row mt-4">
                 <div class="col-12 text-justify p-5">
                    প্ৰতি: <b>' . $data->applicant_name . '</b> পিতা/ স্বামী <b>' . $data->guardian_name . '</b>
                    <br>
                    <br>
                    ইয়াৰ দ্বাৰা আপোনাক জনোৱা হয় যে মিছন বসুন্ধৰা ২.০ ৰ অধীনৰ <b>' . $data->service_name . '</b> সেৱাৰ বাবে আপুনি নিম্নোক্ত তপচিলভূক্ত ভূমিৰ বাবে <b><?=$date_of_application?></b> তাৰিখে আৱেদন নং  <b>' . $data->application_no . '</b>. দাখিল কৰিছে।
                    <table class="mt-4 mb-4">
                        <thead>
                            <tr>
                                <th>জিলা</th>
                                <th>ৰাজহ চক্ৰ</th>
                                <th>মৌজা</th>
                                <th>লাট নং</th>
                                <th>গাওঁ</th>
                                <th>দাগ</th>
                                <th>কালি</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>' . $data->dist_name . '</td>
                                <td>' . $data->circle_name . '</td>
                                <td>' . $data->mouza_name . '</td>
                                <td>' . $data->lot_name . '</td>
                                <td>' . $data->village_name . '</td>
                                <td>' . $data->dag_no . '</td>
                                <td>' . $data->area . '</td>
                            </tr>
                        </tbody>
                    </table>
                    আৱেদন পৰীক্ষাৰ অন্তত  <b>' . $data->date_of_sldc . '</b> তাৰিখৰ ভূমি উপদেষ্টা সমিতিৰ বৈঠকৰ সিদ্ধান্ত অনুসৰি চৰকাৰী মাটিৰ পট্টনৰ বাবে আবেদন প্ৰস্তাৱত অনুমোদন জনোৱা হৈছে। সেয়েহে অসম ভূমি ও ৰাজহ অধিনিয়ম ১৮৮৬ অন্তর্গত ৩২(১) ধাৰা অনুসৰি ওপৰত উল্লেখ কৰা দাগত আপোনাৰ দখলত থকা ভূমিৰ পট্টনৰ বাবে এই জাননীযোগে জনোৱা হ\'ল
                    আৰু আপুনি উক্ত পট্টন গ্ৰহন কৰিবলৈ সন্মত হলে তলত উল্লেখিত ধৰনে প্ৰিমিয়াম আদায় দিবলৈ জনোৱা হল ।
                    <br><br>
                    সেই অনুসৰি উক্ত ভূমিৰ প্ৰিমিয়াম আদায় ক্ৰমে আপোনাৰ নামত পট্টনৰ বাবে কতৃপক্ষই বিবেচনা কৰিছে।
                    <br><br>
                    আপুনি আদায় দিবলগীয়া প্ৰিমিয়ামৰ মূল্য তলত দিয়া ধৰণৰ-

                    <table class="mt-4 mb-4">
                        <thead>
                            <tr>
                                <th></th>
                                <th>বৰ্ণনা</th>
                                <th>প্ৰিমিয়াম (per bigha)</th>
                                <th>দাগ</th>
                                <th>কালি</th>
                                <th>মুঠ মূল্য</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>১</td>
                                <td><b>প্ৰকৃত  প্ৰিমিয়াম</b></td>
                                <td>' . $data->premium_per_bigha . '</td>
                                <td>' . $data->dag_no . '</td>
                                <td>' . $data->area . '</td>
                                <td>' . $data->actual_premium . '</td>
                            </tr>
                            <tr>
                                <td>২</td>
                                <td><b>মিছন বসুন্ধৰা ৰেহাই মূল্য</b></td>
                                <td>' . $data->mission_per_bigha . '</td>
                                <td>' . $data->dag_no . '</td>
                                <td>' . $data->area . '</td>
                                <td>' . $data->premium_payable_without_concession . '</td>
                            </tr>
                            <tr>
                                <td>৩</td>
                                <td><b>বিশেষ ৰেহাই (২৫%)</b></td>
                                <td>' . $data->type_of_concession . '</td>
                                <td>' . $data->concession_dag_no . '</td>
                                <td>' . $data->concession_area . '</td>
                                <td>' . $data->concession_amount . '</td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-center"><b>শুদ্ধ/চূড়ান্ত দিবলগীয়া প্ৰিমিয়াম</b></td>
                                <td><b>' . $data->net_premium_payable . '</b></td>
                            </tr>
                        </tbody>
                    </table>
                    সেইমৰ্মে আপোনাক সৰ্বমুঠ <b>' . $data->net_premium_payable . '</b> টকাৰ  প্ৰিমিয়াম অহা   ৩১ ডিচেম্বৰ ২০২৩ ইং তাৰিখৰ ভিতৰত পৰিশোধ কৰিবলৈ জনোৱা হ’ল।
                    <br>
                    <br>
                    <u>প্ৰযোজ্য চৰ্তাৱলী</u>
                    <br>
                    ক) দিবলগীয়া মুঠ প্ৰিমিয়াম আদায় কৰাৰ পাছতহে আৱেদনকাৰীক ভূমিৰ পট্টা প্ৰদান কৰা হ’ব।
                    <br>

                    খ) আবেদনকাৰীয়ে দিবলগীয়া প্ৰিমিয়াম আদায় দিলে লগে লগে পট্টন দিয়া হ’ব। <br>
                    গ) আবেদকাৰীয়ে যদি প্ৰিমিয়াম কিস্তি হিচাপে আদায় দিব বিচাৰে তোনেক্ষেত্ৰত প্ৰথমতে ৩০ শতাংশ আৰু বাকী প্ৰিমিয়ামৰ ধনখিনি ৫ বছৰৰ ভিতৰত আদায় দিব লাগিব। <br>
                    ঘ) কিস্তি হিচাপে আদায় দিব বিচৰা আবেদনকাৰীৰ ক্ষেত্ৰত প্ৰথম ৩০ শতাংশ আদায় দিয়াৰ পাছত ৫ বছৰৰ ভিতৰত যদি আবেদনকাৰীৰ মৃত্যু ঘটে তেন্তে বাকী প্ৰিমিয়ামৰ ধনখিনি আবেদনকাৰীৰ উত্তৰাধিকাৰীয়ে আদায় দিব লাগিব। <br>

                 </div>
              </div>
              <div class="row mt-4">
              <div class="col-12 text-justify p-5 fw-bold">
                <u>চৰকাৰী অধিসূচনা</u> <br>
                ১) No. RSR.9/88/Pt.II/64 Dtd. 25-May-1999 <br>
                   No. RSS.532/2011/Pt/152    Dtd. 21-Feb-2014 <br>
                ২) No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)  <br>
                ৩) No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)
              </div>
              </div>

              <div class="row mt-4">
              <div class="col-12 text-justify p-5 fw-bold">
              <b>ওপৰত উল্লেখ কৰা প্ৰিমিয়াম আপোনাৰ স্ব-ঘোষণাৰ লগতে সংশ্লিষ্ট চক্ৰ বিষয়াই কৰা  (সম্ভাব্য) মূল্যায়নৰ ওপৰত নিৰ্ধাৰণ কৰি আপোনাৰ দখল/অধীনত থকা মাটিৰ ওপৰত নিৰ্ণয় কৰা হৈছে। আধুনিক পদ্ধতিৰে জৰীপৰ পিছত দখল/অধীনত থকা প্ৰকৃত মাটিৰ পৰিমাণ সাল-সলনি হ’লে আদায় দিবলগীয়া ভূমিৰ প্ৰিমিয়াম সংশোধন কৰা হ’ব পাৰে। </b>
               <br><br>
               <b>*পৰিৱৰ্তিত প্ৰিমিয়াম দখল অনুসৰি সংশোধনযোগ্য হ’ব।  </b>
              </div>
              </div>

              <div class="row mt-5 justify-content-end mb-5">
                 <div class="col-2 text-center"><b>' . $this->utilityclass->getSelectedCOName($data->get_settlement_basic->dist_code, $data->get_settlement_basic->subdiv_code, $data->get_settlement_basic->cir_code, $this->session->userdata('user_code'))->username . '</b><br>
                     চক্ৰ বিষয়া <br>' . $this->utilityclass->getCircleName($data->get_settlement_basic->dist_code, $data->get_settlement_basic->subdiv_code, $data->get_settlement_basic->cir_code) . '
                 </div>
              </div>
              <br>

           </div>
        </div>';

        return base64_encode($html);

    }

    public function savePaymentNoticeBulkByCO($case_no, $htmlString, $PayloadString, $completedCases)
    {

        $PayloadString = json_decode($PayloadString);

        // replacing file case number to savable format
        $new_case_no = str_replace('/', "-", $case_no);
        // creating and saving the base64 format payment notice to uploads/paymentNotice folder
        if (is_dir(PAYMENT_NOTICE_PATH) === false) {
            mkdir(PAYMENT_NOTICE_PATH, 0777);
        }
        $base_64_file_path = PAYMENT_NOTICE_PATH . $new_case_no . ".json";
        $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
        // base64 file
        $htmlstring_text = json_encode($htmlString);
        fwrite($file_to_write_base64, $htmlstring_text);
        fclose($file_to_write_base64);

        $amount = $PayloadString->net_premium_payable;
        $payment_notice_gn_date = $PayloadString->pay_notice_date;
        $remark_co = $PayloadString->co_remarks;
        $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);

        $case_user_case = $get_settlement_basic->co_code;

        if ($this->session->userdata('user_desig_code') != 'CO') {
            $json = [
                'responseType' => 3,
                'message' => '#ERRCO098770932: Session Time out------ Try Again',
                'list' => json_encode($completedCases),
            ];
            echo json_encode($json);
            return;
        }

        $get_dag_details = $this->SettlementApModel->getSettlementDagDetails($case_no);
        $get_settlement_applicant = $this->SettlementApModel->getAllApplicant($case_no);

        // $this->db->trans_begin();
        // settlement_notice table insertaion
        $sql_service = "SELECT * FROM
                           settlement_basic
                           WHERE
                              case_no = ?";
        $service_details = $this->db->query($sql_service, $case_no)->row();
        $sql_buyers = "SELECT * FROM settlement_applicant
                        WHERE
                           case_no = ?
                        AND
                           pdar_type = 'B'";
        $applicant_buyers = $this->db->query($sql_buyers, $case_no)->result();
        foreach ($applicant_buyers as $buyers) {
            $applicant_buyers_json[] =
                [
                'APPLICANT_ID' => $buyers->id,
                'APPLICANT_NAME_BUYER' => $buyers->pdar_name,
                'GUARDIAN_NAME' => $buyers->pdar_guardian,
            ];
        }
        $notice_no = "MB2/PN/" . date('Y') . "/SKCSL/" . $service_details->petition_no;
        $insertIntoSettlementNotice = [
            'case_no' => $case_no,
            'service_code' => $service_details->service_code,
            'case_registration_date' => $service_details->submission_date,
            'payment_notice_date' => date('Y-m-d'),
            'total_amount' => $amount,
            'sdlac_proposal_id' => $service_details->sdlace_proposal_no,
            'sdlac_proposal_date' => $service_details->sdlac_date,
            'applicant_details' => json_encode($applicant_buyers_json),
            'payment_completed_date' => date('Y-m-d'),
            'notice_no' => $notice_no,
            'notice_link' => $base_64_file_path,
            'notice_type' => 'PN',
        ];
        $insertIntoSettlementNotice = $this->db->insert('settlement_notice', $insertIntoSettlementNotice);
        if ($insertIntoSettlementNotice != 1) {
            $this->db->trans_rollback();

            log_message('error', '#ERRPN0067809: Insertion failed in settlement_notice');
            $json = [
                'responseType' => 3,
                'message' => '#KHASPAYAPI001609 Payment notice  could not be generated...',
                'list' => json_encode($completedCases),
            ];
            echo json_encode($json);
            return;
        }

        $updateArr = [
            'status' => 'N',
            'co_code' => $this->session->userdata('user_code'),
            'user_code' => $this->session->userdata('user_code'),
            'pay_notice_gen_yn' => 'Y',
            'pay_notice_gn_date' => $payment_notice_gn_date,
            'date_update' => date('Y-m-d h:i:s'),
            'from_office' => 'CO',
            'pending_officer' => 'CO',
            'pending_office' => 'CO',
            'co_notice_link' => $base_64_file_path,
        ];
        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $updateArr);
        if ($this->db->affected_rows() != 1) {
            $this->db->trans_rollback();

            log_message('error', '#ERRPN000109: Updation Failed in settlement_basic table');
            $json = [
                'responseType' => 3,
                'message' => '#KHASPAYAPI001509 Payment notice  could not be generated...',
                'list' => json_encode($completedCases),
            ];
            echo json_encode($json);
            return;
        }
        //////proceeding start//////
        $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        if ($proceeding_id == null) {
            $proceeding_id = 1;
        }
        $insertArr = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'note_on_order' => $remark_co,
            'status' => 'N',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d h:i:s'),
            'operation' => 'E',
            'ip' => $this->utilityclass->get_client_ip(),
            'office_from' => 'CO',
            'office_to' => 'CO',
            'task' => 'Payment Notice Generated',
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if ($insertProc != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRPN000209: Insertion failed in settlement_proceeding');
            $json = [
                'responseType' => 3,
                'message' => '#KHASPAYAPI001409 Payment notice  could not be generated...',
                'list' => json_encode($completedCases),
            ];
            echo json_encode($json);
            return;

        }

        // API CALL HERE
        $rtps_case_no = $get_settlement_basic->applid;

        /// check full pay
        $is_full_pay = 'N';
        $premium_tot_data = $this->db->query("select area_name from settlement_premium where case_no='$case_no'");
        if ($premium_tot_data->num_rows() > 0) {
            foreach ($premium_tot_data->result() as $prem_records) {

                if ($prem_records->area_name == '7' || $prem_records->area_name == '8' || $prem_records->area_name == '9' || $prem_records->area_name == '10') {
                    $is_full_pay = 'N'; //// from now all cases partial payment option available
                }

            }
        } else {

            log_message('error', '#BACKUP003277: Premium payment type not found. Case No ' . $case_no);
            $json = [
                'responseType' => 3,
                'message' => '#BACKUP00327709 Payment notice  could not be generated...',
                'list' => json_encode($completedCases),
            ];
            echo json_encode($json);
            return;
        }
        /// check full pay end

        //upload notice API
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2 . "uploadNotice");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'encoded_file' => json_decode($htmlstring_text),
            'application_no' => $rtps_case_no,
            'type' => 'PN',
            'amount' => $amount,
            'is_full_pay' => $is_full_pay,
        )));
        $result = curl_exec($curl_handle);

        if (trim($result) != 'y') {
            $this->db->trans_rollback();

            log_message('error', '#KHASPAYAPI001109: Premium payment type not found. Case No ' . $case_no);
            $json = [
                'responseType' => 3,
                'message' => '#KHASPAYAPI001109 Payment notice  could not be generated...',
                'list' => json_encode($completedCases),
            ];
            echo json_encode($json);
            return;
        }

    }

    public function coApproveLmReport()
    {
        $case_no = $this->input->post('case_no');
        $getBasicSql = $this->db->query('select * from settlement_basic where case_no = ?', array($case_no))->row();

        $this->db->trans_begin();

        //****insert nominee OR delete nominee if AVAIL*/
        $sqlNominee = $this->db->query('select * from settlement_nominee_transaction where case_no = ?', array($case_no));

        $nomineeCount = 0;

        if ($sqlNominee->num_rows() > 0) {
            $nomineeResult = $sqlNominee->result();

            $nomineeCount = count($nomineeResult);

            foreach ($nomineeResult as $nomRow) {
                //****insert nominee */
                if ($nomRow->delete_id == 0) {
                    $nomARR = [
                        'case_no' => $nomRow->case_no,
                        'nominee_name' => $nomRow->nominee_name,
                        'address' => $nomRow->address,
                        'relation' => $nomRow->relation,
                        'mobile_no' => $nomRow->mobile_no,
                    ];

                    $nomIns = $this->db->insert('settlement_nominee', $nomARR);

                    if ($nomIns != 1) {
                        $this->db->trans_rollback();
                        echo json_encode([
                            'responseType' => 0,
                            'msg' => '#ERR2260: Unable to approve report!',
                        ]);
                        return false;
                    }

                } else {
                    //*****delete nominee */
                    $this->db->query('delete from settlement_nominee where case_no = ? and id = ?', array($nomRow->case_no, $nomRow->delete_id));

                    if ($this->db->affected_rows() != 1) {
                        $this->db->trans_rollback();
                        echo json_encode([
                            'responseType' => 0,
                            'msg' => '#ERR2277: Unable to approve report!',
                        ]);
                        return false;
                    }
                }
            }
        }

        //****insert dag related DATA */
        $approvSql = $this->db->query('select * from settlement_approval_transaction where case_no = ?', array($case_no));

        if ($approvSql->num_rows() <= 0) {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR2293: Unable to approve report!',
            ]);
            return false;
        }

        $approvResult = $approvSql->result();

        $approvalCount = count($approvResult);

        foreach ($approvResult as $approvRow) {

            if ($getBasicSql->service_code != '18') {
                if (trim($approvRow->patta_type_code) == '0203') {
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 0,
                        'msg' => '#ERR36456: বিশেষ ম্যাদী patta type is only allowed in Special Cultivation!',
                    ]);
                    return false;
                }
            }

            if ($getBasicSql->service_code == '14') {
                $getDagsSql = $this->db->query('select * from settlement_dag_details where case_no = ? and new_dag_no = ?', array($case_no, $approvRow->dag_no));
            } else {
                $getDagsSql = $this->db->query('select * from settlement_dag_details where case_no = ? and dag_no = ?', array($case_no, $approvRow->dag_no));
            }

            if ($getDagsSql->num_rows() <= 0) {
                log_message('error', '#ERR7710285: Case not found in settlemnet_dag_details' . $this->db->last_query());
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR7710285: Dag details not found!',
                ]);
                return false;
            }

            $dagRow = $getDagsSql->row();
            $landType = 0;

            $home_b = $dagRow->home_b;
            $home_k = $dagRow->home_k;
            $home_lc = $dagRow->home_lc;
            $home_g = $dagRow->home_g;

            $homestead = $home_b + $home_k + $home_lc + $home_g;

            if ($homestead > 0) {
                $landType = 1;
            }

            $agri_b = $dagRow->agri_b;
            $agri_k = $dagRow->agri_k;
            $agri_lc = $dagRow->agri_lc;
            $agri_g = $dagRow->agri_g;

            $agriculture = $agri_b + $agri_k + $agri_lc + $agri_g;

            if ($agriculture > 0) {
                $landType = 2;
            }

            if ($homestead > 0 && $agriculture > 0) {
                $landType = 3;
            }

            if ($landType != 3) {
                if (empty($approvRow->landclass_home) && empty($approvRow->landclass_agri)) {
                    echo json_encode([
                        'responseType' => 0,
                        'msg' => '#ERR774912: Please Enter landclass...',
                    ]);
                    return false;
                }
            } else {
                if (empty($approvRow->landclass_home) || empty($approvRow->landclass_agri)) {
                    echo json_encode([
                        'responseType' => 0,
                        'msg' => '#ERR997912: Please Enter both landclass...',
                    ]);
                    return false;
                }
            }

            $updateDagArr = [
                'new_patta_type' => $approvRow->patta_type_code,
                'new_possession' => $approvRow->possession_from,
                'new_land_class_home' => $approvRow->landclass_home,
                'new_land_class_agri' => $approvRow->landclass_agri,
                'landmark' => $approvRow->landmark,
                'landmark_with_code' => $approvRow->landmark_with_code,

                'new_home_land_revenue' => $approvRow->new_home_land_revenue,
                'new_agri_land_revenue' => $approvRow->new_agri_land_revenue,
                'new_home_land_local_tax' => $approvRow->new_home_land_local_tax,
                'new_agri_land_local_tax' => $approvRow->new_agri_land_local_tax,
                'new_total_revenue' => $approvRow->new_total_revenue,
                'new_total_tax' => $approvRow->new_total_tax,
            ];

            $this->db->where('case_no', $case_no);

            if ($getBasicSql->service_code == '14') {
                $this->db->where('new_dag_no', $approvRow->dag_no);
            } else {
                $this->db->where('dag_no', $approvRow->dag_no);
            }

            $this->db->update('settlement_dag_details', $updateDagArr);
            if ($this->db->affected_rows() != 1) {
                // echo $this->db->last_query();
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR2320: Unable to approve report!',
                ]);
                return false;
            }
        }

        //****udpate basic status */
        $basicArr = [
            'chitha_processing_details' => 2,
            'date_update' => date('Y-m-d H:i:s'),
        ];

        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $basicArr);

        if ($this->db->affected_rows() != 1) {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR2341: Unable to approve report!',
            ]);
            return false;
        }

        //*****delete from transaction table */
        $this->db->query('delete from settlement_approval_transaction where case_no = ?', array($case_no));
        if ($this->db->affected_rows() != $approvalCount) {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR2353: Unable to approve report!',
            ]);
            return false;
        }

        $this->db->query('delete from settlement_nominee_transaction where case_no = ?', array($case_no));
        if ($this->db->affected_rows() != $nomineeCount) {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR2363: Unable to approve report!',
            ]);
            return false;
        }

        //*****insert into proceeding */
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
            'note_on_order' => 'Verification report approved',
            'status' => 'N',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d h:i:s'),
            'operation' => 'E',
            'ip' => $this->utilityclass->get_client_ip(),
            'office_from' => 'CO',
            'office_to' => 'CO',
            'task' => 'Verification report approved',
            // 'note_type' => $this->input->post('lm_note'),
        ];
        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

        if ($insertProceeding != 1) {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR2403: Unable to approve report!',
            ]);
            return false;
        }

        $getPremiumStatus = $this->db->query('select payment_date from settlement_premium where case_no = ? and is_final = 1 and grn_no is not null', array($case_no, 1));

        if ($getPremiumStatus->num_rows() > 0) {
            $premiumDate = $getPremiumStatus->row()->payment_date;

            $token = $this->utilityclass->createTokenJwt();
            //******send premium date */
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2 . "insertSwikritiIssueDate");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'appl_no' => $this->utilityclass->getApplidFromCaseNo($case_no),
                'co_approve_date' => date('Y-m-d H:i:s'),
                'ip' => $this->utilityclass->get_client_ip(),
                'api_key' => API_KEY,
                'token' => $token,
            )));
            $result = curl_exec($curl_handle);

            $result = json_decode($result);

            if (trim($result->responseType) != 'y') {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR2701: Unable to approve report!',
                ]);
                return false;
            }
        }

        $this->db->trans_commit();
        echo json_encode([
            'responseType' => 2,
            'msg' => 'Report successfully approved...',
        ]);

    }

    public function getFinalVerificationData()
    {
        $case_no = $this->input->post('case_no');
        $basicSql = $this->db->query('select * from settlement_basic where case_no = ?', array($case_no));

        if ($basicSql->num_rows() <= 0) {
            log_message('error', '#ERR10263: No case number found!' . $this->db->last_query());
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR10263: No case number found!',
            ]);
            return false;
        }

        $data['basicRow'] = $basicSql->row();

        if ($this->session->userdata('user_desig_code') != 'CO') {
            if ($data['basicRow']->chitha_processing_details == 1) {
                // log_message('error', '#ERR10273: No case number found!'. $this->db->last_query());
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR10273: Verification report already submitted!',
                ]);
                return false;
            }
        }

        $getDagsSql = $this->db->query('select * from settlement_dag_details where case_no = ?', array($case_no));

        if ($getDagsSql->num_rows() <= 0) {
            log_message('error', '#ERR10285: Case not found in settlemnet_dag_details' . $this->db->last_query());
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR10285: Dag details not found!',
            ]);
            return false;
        }

        $data['dagResult'] = $getDagsSql->result();

        foreach ($data['dagResult'] as $dagRow) {
            //*****Get data if inserted */
            if ($data['basicRow']->service_code == '14') {
                $getDagTransSql = $this->db->query('select * from settlement_approval_transaction where case_no = ? and dag_no = ?', array($case_no, $dagRow->new_dag_no));
            } else {
                $getDagTransSql = $this->db->query('select * from settlement_approval_transaction where case_no = ? and dag_no = ?', array($case_no, $dagRow->dag_no));
            }

            if ($getDagTransSql->num_rows() <= 0) {
                $data['basicRow']->new_inserted_patta_type_code = false;
                $data['basicRow']->new_inserted_possession_from = false;
                $dagRow->new_inserted_landclass_home = false;
                $dagRow->new_inserted_landclass_agri = false;
                $dagRow->new_inserted_land_mark_with_code = false;

                $dagRow->new_agri_land_revenue = false;
                $dagRow->new_home_land_revenue = false;
                $dagRow->new_agri_land_local_tax = false;
                $dagRow->new_home_land_local_tax = false;
            } else {
                $appRowData = $getDagTransSql->row();

                $data['basicRow']->new_inserted_patta_type_code = $appRowData->patta_type_code;
                $data['basicRow']->new_inserted_possession_from = $appRowData->possession_from;
                $dagRow->new_inserted_landclass_home = $appRowData->landclass_home;
                $dagRow->new_inserted_landclass_agri = $appRowData->landclass_agri;

                $dagRow->new_agri_land_revenue = $appRowData->new_agri_land_revenue;
                $dagRow->new_home_land_revenue = $appRowData->new_home_land_revenue;
                $dagRow->new_agri_land_local_tax = $appRowData->new_agri_land_local_tax;
                $dagRow->new_home_land_local_tax = $appRowData->new_home_land_local_tax;

                $land_mark_ent = json_decode($appRowData->landmark_with_code);

                $dagRow->landmark_dist_east = $land_mark_ent->east->dist_code;
                $dagRow->landmark_subdiv_east = $land_mark_ent->east->subdiv_code;
                $dagRow->landmark_cir_east = $land_mark_ent->east->cir_code;
                $dagRow->landmark_mouza_east = $land_mark_ent->east->mouza_pargona_code;
                $dagRow->landmark_lot_east = $land_mark_ent->east->lot_no;
                $dagRow->landmark_village_east = $land_mark_ent->east->vill_townprt_code;
                $dagRow->landmark_dag_east = $land_mark_ent->east->dag_no;

                $dagRow->landmark_dist_west = $land_mark_ent->west->dist_code;
                $dagRow->landmark_subdiv_west = $land_mark_ent->west->subdiv_code;
                $dagRow->landmark_cir_west = $land_mark_ent->west->cir_code;
                $dagRow->landmark_mouza_west = $land_mark_ent->west->mouza_pargona_code;
                $dagRow->landmark_lot_west = $land_mark_ent->west->lot_no;
                $dagRow->landmark_village_west = $land_mark_ent->west->vill_townprt_code;
                $dagRow->landmark_dag_west = $land_mark_ent->west->dag_no;

                $dagRow->landmark_dist_north = $land_mark_ent->north->dist_code;
                $dagRow->landmark_subdiv_north = $land_mark_ent->north->subdiv_code;
                $dagRow->landmark_cir_north = $land_mark_ent->north->cir_code;
                $dagRow->landmark_mouza_north = $land_mark_ent->north->mouza_pargona_code;
                $dagRow->landmark_lot_north = $land_mark_ent->north->lot_no;
                $dagRow->landmark_village_north = $land_mark_ent->north->vill_townprt_code;
                $dagRow->landmark_dag_north = $land_mark_ent->north->dag_no;

                $dagRow->landmark_dist_south = $land_mark_ent->south->dist_code;
                $dagRow->landmark_subdiv_south = $land_mark_ent->south->subdiv_code;
                $dagRow->landmark_cir_south = $land_mark_ent->south->cir_code;
                $dagRow->landmark_mouza_south = $land_mark_ent->south->mouza_pargona_code;
                $dagRow->landmark_lot_south = $land_mark_ent->south->lot_no;
                $dagRow->landmark_village_south = $land_mark_ent->south->vill_townprt_code;
                $dagRow->landmark_dag_south = $land_mark_ent->south->dag_no;
            }

            // $old_dag = $dagRow->dag_no;
            $dagRow->old_dag = $dagRow->dag_no;

            if ($data['basicRow']->service_code == 14) {
                if (empty($dagRow->new_dag_no) || $dagRow->new_dag_no == null || $dagRow->new_dag_no == '') {
                    echo json_encode([
                        'responseType' => 0,
                        'msg' => '#ERR952: New Dag not found for NR case!',
                    ]);
                    return false;
                }

                $dagRow->dag_no = $dagRow->new_dag_no;
                $dagRow->patta_no = $dagRow->new_patta_no;
                $dagRow->patta_type_code = $dagRow->new_patta_type_code;
            }

            $landclass = $this->utilityclass->classCodeFromChitha($dagRow->dist_code, $dagRow->subdiv_code, $dagRow->cir_code, $dagRow->mouza_pargona_code, $dagRow->lot_no, $dagRow->vill_townprt_code, $dagRow->dag_no);
            if ($landclass) {
                $className = $this->utilityclass->getLandClassCode($landclass);
            }

            $dagRow->old_class_name = $className;

            $premium_data_sql = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ? and dag_no = ?', array($case_no, '1', $dagRow->old_dag));

            if ($premium_data_sql->num_rows() <= 0) {
                log_message('error', '#ERR10313: Case not found in settlement_premium' . $this->db->last_query());
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR10313: Premium data not found!',
                ]);
                return false;
            }

            $premiumRow = $premium_data_sql->row();

            if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                $total_settlement_area = $this->utilityclass->Total_Bigha_Katha_Lessa2($premiumRow->total_lessa);

                $dagRow->final_settlement_area = 'B: ' . $total_settlement_area[0] . ' K: ' . $total_settlement_area[1] . ' C: ' . $total_settlement_area[2] . ' G: ' . $total_settlement_area[3];
            } else {
                $total_settlement_area = $this->utilityclass->Total_Bigha_Katha_Lessa($premiumRow->total_lessa);

                $dagRow->final_settlement_area = 'B: ' . $total_settlement_area[0] . ' K: ' . $total_settlement_area[1] . ' L: ' . $total_settlement_area[2];
            }

            $landmark = json_decode($dagRow->landmark);

            $dagRow->landmark_entered = 'East - ' . $landmark->east . ', West - ' . $landmark->west . ', North - ' . $landmark->north . ', South - ' . $landmark->south;

            //******reservation area details */
            $reservation = $this->db->query('select * from settlement_reservation where case_no = ? and type = ? and dag_no = ?', array($case_no, 'R', $dagRow->old_dag));

            if ($reservation->num_rows() <= 0) {
                $dagRow->road_side_reservation = false;
            } else {
                $reservation = $reservation->result();

                foreach ($reservation as $reservationRow) {
                    if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                        $dagRow->road_side_reservation = 'B: ' . $reservationRow->bigha . ' K: ' . $reservationRow->katha . ' C: ' . $reservationRow->lessa . ' G: ' . $reservationRow->ganda;
                    } else {
                        $dagRow->road_side_reservation = 'B: ' . $reservationRow->bigha . ' K: ' . $reservationRow->katha . ' L: ' . $reservationRow->lessa;
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

            if ($homestead > 0) {
                $landType = 1;
            }

            $agri_b = $dagRow->agri_b;
            $agri_k = $dagRow->agri_k;
            $agri_lc = $dagRow->agri_lc;
            $agri_g = $dagRow->agri_g;

            $agriculture = $agri_b + $agri_k + $agri_lc + $agri_g;

            if ($agriculture > 0) {
                $landType = 2;
            }

            if ($homestead > 0 && $agriculture > 0) {
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
        // $data['patta_details'] = $this->db->query("SELECT type_code, patta_type FROM patta_code where settlement = ?", 'y')->result();
        $data['patta_details'] = $this->db->query("SELECT type_code, patta_type FROM patta_code where (settlement = ? OR spcl_cultivation = ?)", array('y', 'y'))->result();

        $application_no = $this->utilityclass->getApplidFromCaseNo($case_no);

        $nominee = $this->db->query('SELECT * FROM settlement_nominee WHERE case_no = ? AND id NOT IN (SELECT delete_id FROM settlement_nominee_transaction where case_no = ?)', array($case_no, $case_no));

        if ($nominee->num_rows() <= 0) {
            $nominee = $this->db->query('SELECT * FROM settlement_nominee WHERE case_no = ? AND id NOT IN (SELECT delete_id FROM settlement_nominee_transaction where case_no = ?)', array($application_no, $application_no));
        }

        if ($nominee->num_rows() <= 0) {
            $data['nominee'] = false;
        } else {
            $data['nominee'] = $nominee->result();

            foreach ($data['nominee'] as $nomRow) {
                $nomRow->relation_decoded = $this->utilityclass->getrelationByID($nomRow->relation);
            }
        }

        $addededNomSql = $this->db->query('select * from settlement_nominee_transaction where case_no = ?', array($case_no));

        if ($addededNomSql->num_rows() <= 0) {
            $data['transactionNom'] = false;
        } else {
            $data['transactionNom'] = $addededNomSql->result();

            foreach ($data['transactionNom'] as $nomTranRow) {
                $nomTranRow->relation_decoded = $this->utilityclass->getrelationByID($nomTranRow->relation);
            }

        }

        echo json_encode($data);

    }

    public function chithaProcessingDetails()
    {
        $case_no = $this->input->post('case_no');

        if (empty($case_no)) {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR805: Case number not found!',
            ]);
            return false;
        }

        $checkIfAlreadyEnt = $this->db->query('select * from settlement_approval_transaction where case_no = ?', array($case_no));

        if ($checkIfAlreadyEnt->num_rows() <= 0) {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR812: Something went wrong!',
            ]);
            return false;
        }

        $getDagsSql = $this->db->query('select * from settlement_dag_details where case_no = ?', array($case_no));

        if ($getDagsSql->num_rows() <= 0) {
            log_message('error', '#ERR10285: Case not found in settlemnet_dag_details' . $this->db->last_query());
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR10285: Dag details not found!',
            ]);
            return false;
        }

        $data['dagResult'] = $getDagsSql->result();

        $new_patta_type = $this->input->post('new_patta_type');
        $possession_from = $this->input->post('possession_from');

        if (empty($new_patta_type) || empty($possession_from)) {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR831: Please enter all required fields!',
            ]);
            return false;
        }

        //****get basic data  */
        $getBasicSql = $this->db->query('select * from settlement_basic where case_no = ?', array($case_no))->row();

        ///*****checking if co is changing the patta type from what lm has given (not allowed) */
        $approvRow = $checkIfAlreadyEnt->row();
        // if(trim($approvRow->patta_type_code) != trim($new_patta_type))
        // {
        //     echo json_encode([
        //         'responseType'  => 0,
        //         'msg'           => '#ERR3648: Patta type change is not allowed!',
        //     ]);
        //     return false;
        // }

        if ($getBasicSql->service_code != 18) {
            if (trim($new_patta_type) == '0203') {
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR36454: বিশেষ ম্যাদী patta type is only allowed in Special Cultivation!',
                ]);
                return false;
            }
        }

        $batch_array = array();

        foreach ($data['dagResult'] as $dagRow) {
            if ($getBasicSql->service_code == '14') {
                if (empty($dagRow->new_dag_no) || $dagRow->new_dag_no == null || $dagRow->new_dag_no == '') {
                    echo json_encode([
                        'responseType' => 0,
                        'msg' => '#ERR2911: New Dag not found for NR case!',
                    ]);
                    return false;
                }

                $dagRow->dag_no = $dagRow->new_dag_no;
            }

            $landmark_dist_east = $this->input->post('landmark_dist_east' . $dagRow->dag_no);
            $landmark_subdiv_east = $this->input->post('landmark_subdiv_east' . $dagRow->dag_no);
            $landmark_cir_east = $this->input->post('landmark_cir_east' . $dagRow->dag_no);
            $landmark_mouza_east = $this->input->post('landmark_mouza_east' . $dagRow->dag_no);
            $landmark_lot_east = $this->input->post('landmark_lot_east' . $dagRow->dag_no);
            $landmark_village_east = $this->input->post('landmark_village_east' . $dagRow->dag_no);
            $landmark_dag_no_east = $this->input->post('landmark_dag_no_east' . $dagRow->dag_no);

            $landmark_dist_west = $this->input->post('landmark_dist_west' . $dagRow->dag_no);
            $landmark_subdiv_west = $this->input->post('landmark_subdiv_west' . $dagRow->dag_no);
            $landmark_cir_west = $this->input->post('landmark_cir_west' . $dagRow->dag_no);
            $landmark_mouza_west = $this->input->post('landmark_mouza_west' . $dagRow->dag_no);
            $landmark_lot_west = $this->input->post('landmark_lot_west' . $dagRow->dag_no);
            $landmark_village_west = $this->input->post('landmark_village_west' . $dagRow->dag_no);
            $landmark_dag_no_west = $this->input->post('landmark_dag_no_west' . $dagRow->dag_no);

            $landmark_dist_north = $this->input->post('landmark_dist_north' . $dagRow->dag_no);
            $landmark_subdiv_north = $this->input->post('landmark_subdiv_north' . $dagRow->dag_no);
            $landmark_cir_north = $this->input->post('landmark_cir_north' . $dagRow->dag_no);
            $landmark_mouza_north = $this->input->post('landmark_mouza_north' . $dagRow->dag_no);
            $landmark_lot_north = $this->input->post('landmark_lot_north' . $dagRow->dag_no);
            $landmark_village_north = $this->input->post('landmark_village_north' . $dagRow->dag_no);
            $landmark_dag_no_north = $this->input->post('landmark_dag_no_north' . $dagRow->dag_no);

            $landmark_dist_south = $this->input->post('landmark_dist_south' . $dagRow->dag_no);
            $landmark_subdiv_south = $this->input->post('landmark_subdiv_south' . $dagRow->dag_no);
            $landmark_cir_south = $this->input->post('landmark_cir_south' . $dagRow->dag_no);
            $landmark_mouza_south = $this->input->post('landmark_mouza_south' . $dagRow->dag_no);
            $landmark_lot_south = $this->input->post('landmark_lot_south' . $dagRow->dag_no);
            $landmark_village_south = $this->input->post('landmark_village_south' . $dagRow->dag_no);
            $landmark_dag_no_south = $this->input->post('landmark_dag_no_south' . $dagRow->dag_no);

            $land_class_code_homestead = $this->input->post('land_class_code_homestead' . $dagRow->dag_no);
            $land_class_code_agriculture = $this->input->post('land_class_code_agriculture' . $dagRow->dag_no);

            // if(empty($land_class_code_homestead) && empty($land_class_code_agriculture))
            // {
            //     echo json_encode([
            //         'responseType'  => 0,
            //         'msg'           => '#ERR912: Please Enter landclass...',
            //     ]);
            //     return false;
            // }

            $revenue_home = $this->input->post('revenue_home' . $dagRow->dag_no);
            $local_tax_home = $this->input->post('local_tax_home' . $dagRow->dag_no);
            $revenue_agri = $this->input->post('revenue_agri' . $dagRow->dag_no);
            $local_tax_agri = $this->input->post('local_tax_agri' . $dagRow->dag_no);

            $landType = 0;

            $home_b = $dagRow->home_b;
            $home_k = $dagRow->home_k;
            $home_lc = $dagRow->home_lc;
            $home_g = $dagRow->home_g;

            $homestead = $home_b + $home_k + $home_lc + $home_g;

            if ($homestead > 0) {
                $landType = 1;
            }

            $agri_b = $dagRow->agri_b;
            $agri_k = $dagRow->agri_k;
            $agri_lc = $dagRow->agri_lc;
            $agri_g = $dagRow->agri_g;

            $agriculture = $agri_b + $agri_k + $agri_lc + $agri_g;

            if ($agriculture > 0) {
                $landType = 2;
            }

            if ($homestead > 0 && $agriculture > 0) {
                $landType = 3;
            }

            if ($landType != 3) {
                if (empty($land_class_code_homestead) && empty($land_class_code_agriculture)) {
                    echo json_encode([
                        'responseType' => 0,
                        'msg' => '#ERR4912: Please Enter landclass...',
                    ]);
                    return false;
                }
            } else {
                if (empty($land_class_code_homestead) || empty($land_class_code_agriculture)) {
                    echo json_encode([
                        'responseType' => 0,
                        'msg' => '#ERR7912: Please Enter landclass...',
                    ]);
                    return false;
                }
            }

            // if(empty($land_class_code_homestead) && empty($land_class_code_agriculture))
            // {
            //     echo json_encode([
            //         'responseType'  => 0,
            //         'msg'           => '#ERR912: Please Enter landclass...',
            //     ]);
            //     return false;
            // }

            if (empty($revenue_home) && empty($revenue_agri)) {
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR1050: Please Enter revenue details...',
                ]);
                return false;
            }

            if (!empty($revenue_home)) {
                if (empty($local_tax_home)) {
                    echo json_encode([
                        'responseType' => 0,
                        'msg' => '#ERR1061: Please Enter Local tax details...',
                    ]);
                    return false;
                }
            }

            if (!empty($revenue_agri)) {
                if (empty($local_tax_agri)) {
                    echo json_encode([
                        'responseType' => 0,
                        'msg' => '#ERR1073: Please Enter Local tax details...',
                    ]);
                    return false;
                }
            }

            $revenue_home = $this->UtilsModel->defaultValue($revenue_home, 0);
            $local_tax_home = $this->UtilsModel->defaultValue($local_tax_home, 0);
            $revenue_agri = $this->UtilsModel->defaultValue($revenue_agri, 0);
            $local_tax_agri = $this->UtilsModel->defaultValue($local_tax_agri, 0);

            if (empty($landmark_dist_east) || empty($landmark_subdiv_east) || empty($landmark_cir_east) || empty($landmark_mouza_east) || empty($landmark_lot_east) || empty($landmark_village_east) || empty($landmark_dag_no_east) || empty($landmark_dist_west) || empty($landmark_subdiv_west) || empty($landmark_cir_west) || empty($landmark_mouza_west) || empty($landmark_lot_west) || empty($landmark_village_west) || empty($landmark_dag_no_west) || empty($landmark_dist_north) || empty($landmark_subdiv_north) || empty($landmark_cir_north) || empty($landmark_mouza_north) || empty($landmark_lot_north) || empty($landmark_village_north) || empty($landmark_dag_no_north) || empty($landmark_dist_south) || empty($landmark_subdiv_south) || empty($landmark_cir_south) || empty($landmark_mouza_south) || empty($landmark_lot_south) || empty($landmark_village_south) || empty($landmark_dag_no_south)) {
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR870: Please enter all landmark details!',
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
                'east' => $landmark_dist_east_name . ', ' . $landmark_subdiv_east_name . ', ' . $landmark_cir_east_name . ', ' . $landmark_mouza_east_name . ', ' . $landmark_lot_east_name . ', ' . $landmark_village_east_name . ', ' . $landmark_dag_no_east,

                'west' => $landmark_dist_west_name . ', ' . $landmark_subdiv_west_name . ', ' . $landmark_cir_west_name . ', ' . $landmark_mouza_west_name . ', ' . $landmark_lot_west_name . ', ' . $landmark_village_west_name . ', ' . $landmark_dag_no_west,

                'north' => $landmark_dist_north_name . ', ' . $landmark_subdiv_north_name . ', ' . $landmark_cir_north_name . ', ' . $landmark_mouza_north_name . ', ' . $landmark_lot_north_name . ', ' . $landmark_village_north_name . ', ' . $landmark_dag_no_north,

                'south' => $landmark_dist_south_name . ', ' . $landmark_subdiv_south_name . ', ' . $landmark_cir_south_name . ', ' . $landmark_mouza_south_name . ', ' . $landmark_lot_south_name . ', ' . $landmark_village_south_name . ', ' . $landmark_dag_no_south,
            ];

            $landmark_with_code = [
                'east' => [
                    'dist_code' => $landmark_dist_east,
                    'subdiv_code' => $landmark_subdiv_east,
                    'cir_code' => $landmark_cir_east,
                    'mouza_pargona_code' => $landmark_mouza_east,
                    'lot_no' => $landmark_lot_east,
                    'vill_townprt_code' => $landmark_village_east,
                    'dag_no' => $landmark_dag_no_east,
                ],

                'west' => [
                    'dist_code' => $landmark_dist_west,
                    'subdiv_code' => $landmark_subdiv_west,
                    'cir_code' => $landmark_cir_west,
                    'mouza_pargona_code' => $landmark_mouza_west,
                    'lot_no' => $landmark_lot_west,
                    'vill_townprt_code' => $landmark_village_west,
                    'dag_no' => $landmark_dag_no_west,
                ],

                'north' => [
                    'dist_code' => $landmark_dist_north,
                    'subdiv_code' => $landmark_subdiv_north,
                    'cir_code' => $landmark_cir_north,
                    'mouza_pargona_code' => $landmark_mouza_north,
                    'lot_no' => $landmark_lot_north,
                    'vill_townprt_code' => $landmark_village_north,
                    'dag_no' => $landmark_dag_no_north,
                ],

                'south' => [
                    'dist_code' => $landmark_dist_south,
                    'subdiv_code' => $landmark_subdiv_south,
                    'cir_code' => $landmark_cir_south,
                    'mouza_pargona_code' => $landmark_mouza_south,
                    'lot_no' => $landmark_lot_south,
                    'vill_townprt_code' => $landmark_village_south,
                    'dag_no' => $landmark_dag_no_south,
                ],
            ];

            //****insert in settlement_approval_transaction */
            $insertArr = [
                'case_no' => $case_no,
                'dag_no' => $dagRow->dag_no,
                'patta_type_code' => $new_patta_type,
                'possession_from' => $possession_from,
                'landclass_home' => $land_class_code_homestead,
                'landclass_agri' => $land_class_code_agriculture,
                'landmark_with_code' => json_encode($landmark_with_code),
                'landmark' => json_encode($landmark_name),
                'date_update' => date('Y-m-d H:i:s'),

                'new_home_land_revenue' => $revenue_home,
                'new_agri_land_revenue' => $revenue_agri,
                'new_home_land_local_tax' => $local_tax_home,
                'new_agri_land_local_tax' => $local_tax_agri,
                'new_total_revenue' => (float) $revenue_home + (float) $revenue_agri,
                'new_total_tax' => (float) $local_tax_home + (float) $local_tax_agri,
            ];

            $batch_array[] = $insertArr;

        }

        $this->dbswitch();
        $this->db->trans_begin();

        foreach ($data['dagResult'] as $dagRow) {
            foreach ($batch_array as $bFrr) {
                if ($bFrr['dag_no'] == $dagRow->dag_no) {
                    $this->db->where('case_no', $case_no);
                    $this->db->where('dag_no', $bFrr['dag_no']);
                    $this->db->update('settlement_approval_transaction', $bFrr);

                    if ($this->db->affected_rows() != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERR10003: Unable to update settlement_approval_transaction!' . $this->db->last_query());
                        echo json_encode([
                            'responseType' => 0,
                            'msg' => '#ERR10003: Unable to update data!',
                        ]);
                        return false;
                    }
                }
            }
        }

        //*****update settlement_basic */
        $basicArr = [
            'chitha_processing_details' => 1,
            'date_update' => date('Y-m-d H:i:s'),
        ];

        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $basicArr);

        if ($this->db->affected_rows() != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERR1000: Unable to update settlement_basic!' . $this->db->last_query());
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR1000: Unable to update data!',
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
            'note_on_order' => 'CO updated verification report',
            'status' => 'N',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d h:i:s'),
            'operation' => 'E',
            'ip' => $this->utilityclass->get_client_ip(),
            'office_from' => 'CO',
            'office_to' => 'CO',
            'task' => 'CO updated verification report',
            // 'note_type' => $this->input->post('lm_note'),
        ];
        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

        if ($insertProceeding != 1) {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR2403: Unable to update report!',
            ]);
            return false;
        }

        $this->db->trans_commit();
        echo json_encode([
            'responseType' => 2,
            'msg' => 'success',
        ]);
        return;
    }

    // public function chithaUpdateDetails()
    // {
    //     $case_no = $this->input->post('case_no');

    //     //******getting the basic data */
    //     $basicRow = $this->SettlementApModel->getSettlementBasicCo($case_no);

    //     $formGroup = '';
    //     $barak_Nr = '';

    //     $dagResult = $this->SettlementKhasModel->getSettlementDag($case_no);

    //     //****this is for other services */
    //     foreach($dagResult as $dagRow)
    //     {
    //         $formGroup .= '<h5 class="text-danger"><b>DAG NO '.$dagRow->dag_no.'</b></h5><hr>';

    //         if (in_array($basicRow->dist_code, json_decode(BARAK_VALLEY)))
    //         {
    //             $formGroup .= '<div class="row mt-1">
    //                                 <div class="col-4">
    //                                     <label></label><br>
    //                                 </div>
    //                                 <div class="col-2">
    //                                     <label>Bigha</label>
    //                                 </div>
    //                                 <div class="col-2">
    //                                     <label>Katha</label>
    //                                 </div>
    //                                 <div class="col-2">
    //                                     <label>Chatak</label>
    //                                 </div>
    //                                 <div class="col-2">
    //                                     <label>Ganda</label>
    //                                 </div>
    //                             </div>';

    //         }
    //         else
    //         {
    //             $formGroup .= '<div class="row mt-1">
    //                                 <div class="col-3">
    //                                     <label></label><br>
    //                                 </div>
    //                                 <div class="col-3">
    //                                     <label>Bigha</label>
    //                                 </div>
    //                                 <div class="col-3">
    //                                     <label>Katha</label>
    //                                 </div>
    //                                 <div class="col-3">
    //                                     <label>Lessa</label>
    //                                 </div>
    //                             </div>';

    //         }

    //         $getReservationSql = $this->db->query('select * from settlement_reservation where case_no = ? and dag_no = ? and type = ?', array($case_no, $dagRow->dag_no, 'R'));

    //         $roadsideReservation = '';

    //         if($getReservationSql->num_rows() > 0)
    //         {
    //             $reservationRow = $getReservationSql->row();

    //             if (in_array($basicRow->dist_code, json_decode(BARAK_VALLEY)))
    //             {
    //                 $roadsideReservation = '<div class="row mt-2">
    //                                             <div class="col-4">
    //                                                 Roadside Reservation Area
    //                                             </div>
    //                                             <div class="col-2">
    //                                                 <input type="number" class="form-control text-center" readonly value="'.$reservationRow->bigha.'">
    //                                             </div>
    //                                             <div class="col-2">
    //                                                 <input type="number" class="form-control text-center" readonly value="'.$reservationRow->katha.'">
    //                                             </div>
    //                                             <div class="col-2">
    //                                                 <input type="number" class="form-control text-center" readonly value="'.$reservationRow->lessa.'">
    //                                             </div>
    //                                             <div class="col-2">
    //                                                 <input type="number" class="form-control text-center" readonly value="'.$reservationRow->ganda.'">
    //                                             </div>
    //                                         </div>';
    //             }
    //             else
    //             {
    //                 $roadsideReservation = '<div class="row mt-2">
    //                                         <div class="col-3">
    //                                             Roadside Reservation Area
    //                                         </div>
    //                                         <div class="col-3">
    //                                             <input type="number" class="form-control text-center" readonly value="'.$reservationRow->bigha.'">
    //                                         </div>
    //                                         <div class="col-3">
    //                                             <input type="number" class="form-control text-center" readonly value="'.$reservationRow->katha.'">
    //                                         </div>
    //                                         <div class="col-3">
    //                                             <input type="number" class="form-control text-center" readonly value="'.$reservationRow->lessa.'">
    //                                         </div>
    //                                     </div>';
    //             }
    //         }

    //         $getPremSql = $this->db->query('select * from settlement_premium where case_no = ? and dag_no = ? and is_final = ?', array($case_no, $dagRow->dag_no, 1));

    //         if($getPremSql->num_rows() <= 0)
    //         {
    //             echo json_encode([
    //                 'responseType'  => 0,
    //                 'msg'           => '#ERR3380: Premium data not found!',
    //             ]);
    //             return false;
    //         }

    //         $premRow = $getPremSql->row();

    //         //*****this is for NR area */
    //         //*****this is for AP */
    //         if($basicRow->service_code == '14')
    //         {
    //             //*****this is for NR area */
    //             if (in_array($basicRow->dist_code, json_decode(BARAK_VALLEY)))
    //             {
    //                 //****this is for NR area */
    //                 $barak_Nr = '<div class="row">
    //                                 <div class="col-4">
    //                                     NR Area
    //                                 </div>
    //                                 <div class="col-2">
    //                                     <input type="number" name="nr_bigha'.$dagRow->dag_no.'" id="nr_bigha'.$dagRow->dag_no.'" class="form-control text-center" value="'.$dagRow->nr_bigha.'">
    //                                 </div>
    //                                 <div class="col-2">
    //                                     <input type="number" name="nr_katha'.$dagRow->dag_no.'" id="nr_katha'.$dagRow->dag_no.'" class="form-control text-center" value="'.$dagRow->nr_katha.'">
    //                                 </div>
    //                                 <div class="col-2">
    //                                     <input type="number" name="nr_lessa'.$dagRow->dag_no.'" id="nr_lessa'.$dagRow->dag_no.'" class="form-control text-center" value="'.$dagRow->nr_lessa.'">
    //                                 </div>
    //                                 <div class="col-2">
    //                                     <input type="number" name="nr_ganda'.$dagRow->dag_no.'" id="nr_ganda'.$dagRow->dag_no.'" class="form-control text-center" value="'.$dagRow->nr_ganda.'">
    //                                 </div>
    //                             </div>';

    //             }
    //             else
    //             {
    //                 //*******this is for NR area */
    //                 $barak_Nr = '<div class="row">
    //                                 <div class="col-3">
    //                                     NR Area
    //                                 </div>
    //                                 <div class="col-3">
    //                                     <input type="number" name="nr_bigha'.$dagRow->dag_no.'" id="nr_bigha'.$dagRow->dag_no.'" class="form-control text-center" value="'.$dagRow->nr_bigha.'">
    //                                 </div>
    //                                 <div class="col-3">
    //                                     <input type="number" name="nr_katha'.$dagRow->dag_no.'" id="nr_katha'.$dagRow->dag_no.'" class="form-control text-center" value="'.$dagRow->nr_katha.'">
    //                                 </div>
    //                                 <div class="col-3">
    //                                     <input type="number" name="nr_lessa'.$dagRow->dag_no.'" id="nr_lessa'.$dagRow->dag_no.'" class="form-control text-center" value="'.$dagRow->nr_lessa.'">
    //                                 </div>
    //                             </div>';
    //             }
    //         }

    //         //********find out agri or home dag */

    //         $landType = 0;

    //         $home_b = $dagRow->home_b;
    //         $home_k = $dagRow->home_k;
    //         $home_lc = $dagRow->home_lc;
    //         $home_g = $dagRow->home_g;

    //         $homestead = $home_b + $home_k + $home_lc + $home_g;

    //         if($homestead > 0)
    //         {
    //            $landType = 1;
    //         }

    //         $agri_b = $dagRow->agri_b;
    //         $agri_k = $dagRow->agri_k;
    //         $agri_lc = $dagRow->agri_lc;
    //         $agri_g = $dagRow->agri_g;

    //         $agriculture = $agri_b + $agri_k + $agri_lc + $agri_g;

    //         if($agriculture > 0)
    //         {
    //            $landType = 2;
    //         }

    //         if($homestead > 0 && $agriculture > 0)
    //         {
    //             $landType = 3;
    //         }

    //         $settle_home = '';
    //         $settle_agri = '';

    //         if (in_array($basicRow->dist_code, json_decode(BARAK_VALLEY)))
    //         {
    //             //*******this is for settlement area */

    //             if($landType == 3 || $landType == 1)
    //             {
    //                 $settle_home = '<div class="row mt-2">
    //                                     <div class="col-4">
    //                                         Homestead Area
    //                                     </div>
    //                                     <div class="col-2">
    //                                         <input type="number" name="home_b'.$dagRow->dag_no.'" id="home_b'.$dagRow->dag_no.'" class="form-control text-center" value="'.$dagRow->home_b.'" readonly>
    //                                     </div>
    //                                     <div class="col-2">
    //                                         <input type="number" name="home_k'.$dagRow->dag_no.'" id="home_k'.$dagRow->dag_no.'" class="form-control text-center" value="'.$dagRow->home_k.'" readonly>
    //                                     </div>
    //                                     <div class="col-2">
    //                                         <input type="number" name="home_lc'.$dagRow->dag_no.'" id="home_lc'.$dagRow->dag_no.'" class="form-control text-center" value="'.$dagRow->home_lc.'" readonly>
    //                                     </div>
    //                                     <div class="col-2">
    //                                         <input type="number" name="home_g'.$dagRow->dag_no.'" id="home_g'.$dagRow->dag_no.'" class="form-control text-center" value="'.$dagRow->home_g.'" readonly>
    //                                     </div>
    //                                 </div>';
    //             }

    //             if($landType == 3 || $landType == 2)
    //             {
    //                 $settle_agri = '<div class="row mt-2">
    //                                     <div class="col-4">
    //                                         Agriculture Area
    //                                     </div>
    //                                     <div class="col-2">
    //                                         <input type="number" name="agri_b'.$dagRow->dag_no.'" id="agri_b'.$dagRow->dag_no.'" class="form-control text-center" value="'.$dagRow->agri_b.'" readonly>
    //                                     </div>
    //                                     <div class="col-2">
    //                                         <input type="number" name="agri_k'.$dagRow->dag_no.'" id="agri_k'.$dagRow->dag_no.'" class="form-control text-center" value="'.$dagRow->agri_k.'" readonly>
    //                                     </div>
    //                                     <div class="col-2">
    //                                         <input type="number" name="agri_lc'.$dagRow->dag_no.'" id="agri_lc'.$dagRow->dag_no.'" class="form-control text-center" value="'.$dagRow->agri_lc.'" readonly>
    //                                     </div>
    //                                     <div class="col-2">
    //                                         <input type="number" name="agri_g'.$dagRow->dag_no.'" id="agri_g'.$dagRow->dag_no.'" class="form-control text-center" value="'.$dagRow->agri_g.'" readonly>
    //                                     </div>
    //                                 </div>';
    //             }

    //             $barak_settle = '<div class="row mt-2">
    //                                     <div class="col-4">
    //                                         Total Settlement Area
    //                                     </div>
    //                                     <div class="col-2">
    //                                         <input type="number" name="s_dag_area_b'.$dagRow->dag_no.'" id="s_dag_area_b'.$dagRow->dag_no.'" class="form-control text-center" value="'.$dagRow->s_dag_area_b.'" readonly>
    //                                     </div>
    //                                     <div class="col-2">
    //                                         <input type="number" name="s_dag_area_k'.$dagRow->dag_no.'" id="s_dag_area_k'.$dagRow->dag_no.'" class="form-control text-center" value="'.$dagRow->s_dag_area_k.'" readonly>
    //                                     </div>
    //                                     <div class="col-2">
    //                                         <input type="number" name="s_dag_area_lc'.$dagRow->dag_no.'" id="s_dag_area_lc'.$dagRow->dag_no.'" class="form-control text-center" value="'.$dagRow->s_dag_area_lc.'" readonly>
    //                                     </div>
    //                                     <div class="col-2">
    //                                         <input type="number" name="s_dag_area_g'.$dagRow->dag_no.'" id="s_dag_area_g'.$dagRow->dag_no.'" class="form-control text-center" value="'.$dagRow->s_dag_area_g.'" readonly>
    //                                     </div>
    //                                 </div>';

    //             //*****this is for final settlement area */
    //             $bkl = $this->utilityclass->Total_Bigha_Katha_Lessa2($premRow->total_lessa);

    //             $barak_final_settle = '<div class="row mt-2">
    //                                         <div class="col-3">
    //                                             Final Settlement Area
    //                                         </div>
    //                                         <div class="col-2">
    //                                             <input type="number" class="form-control text-center" value="'.$bkl[0].'" readonly>
    //                                         </div>
    //                                         <div class="col-2">
    //                                             <input type="number" class="form-control text-center" value="'.$bkl[1].'" readonly>
    //                                         </div>
    //                                         <div class="col-2">
    //                                             <input type="number" class="form-control text-center" value="'.$bkl[2].'" readonly>
    //                                         </div>
    //                                         <div class="col-2">
    //                                             <input type="number" class="form-control text-center" value="'.$bkl[3].'" readonly>
    //                                         </div>
    //                                     </div>';

    //             if($landType != 3)
    //             {
    //                 $coSeperationInputHome =  '<div class="row mt-2">
    //                                                 <div class="col-4">
    //                                                     Area bifurcation Homestead
    //                                                 </div>
    //                                                 <div class="col-2">
    //                                                     <input type="number" name="bifurcated_home_bigha'.$dagRow->dag_no.'" id="bifurcated_bigha'.$dagRow->dag_no.'" class="form-control text-center" placeholder="Please enter area" value="'.$bkl[0].'" readonly>
    //                                                 </div>
    //                                                 <div class="col-2">
    //                                                     <input type="number" name="bifurcated_home_katha'.$dagRow->dag_no.'" id="bifurcated_katha'.$dagRow->dag_no.'" class="form-control text-center" placeholder="Please enter area" value="'.$bkl[1].'" readonly>
    //                                                 </div>
    //                                                 <div class="col-2">
    //                                                     <input type="number" name="bifurcated_home_lessa'.$dagRow->dag_no.'" id="bifurcated_lessa'.$dagRow->dag_no.'" class="form-control text-center" placeholder="Please enter area" value="'.$bkl[2].'" readonly>
    //                                                 </div>
    //                                                 <div class="col-2">
    //                                                     <input type="number" name="bifurcated_home_ganda'.$dagRow->dag_no.'" id="bifurcated_ganda'.$dagRow->dag_no.'" class="form-control text-center" placeholder="Please enter area" value="'.$bkl[3].'" readonly>
    //                                                 </div>
    //                                             </div>';

    //                 $coSeperationInputAgri =  '<div class="row mt-2">
    //                                                 <div class="col-4">
    //                                                     Area bifurcation Agriculture
    //                                                 </div>
    //                                                 <div class="col-2">
    //                                                     <input type="number" name="bifurcated_agri_bigha'.$dagRow->dag_no.'" id="bifurcated_bigha'.$dagRow->dag_no.'" class="form-control text-center" placeholder="Please enter area" value="'.$bkl[0].'" readonly>
    //                                                 </div>
    //                                                 <div class="col-2">
    //                                                     <input type="number" name="bifurcated_agri_katha'.$dagRow->dag_no.'" id="bifurcated_katha'.$dagRow->dag_no.'" class="form-control text-center" placeholder="Please enter area" value="'.$bkl[1].'" readonly>
    //                                                 </div>
    //                                                 <div class="col-2">
    //                                                     <input type="number" name="bifurcated_agri_lessa'.$dagRow->dag_no.'" id="bifurcated_lessa'.$dagRow->dag_no.'" class="form-control text-center" placeholder="Please enter area" value="'.$bkl[2].'" readonly>
    //                                                 </div>
    //                                                 <div class="col-2">
    //                                                     <input type="number" name="bifurcated_agri_ganda'.$dagRow->dag_no.'" id="bifurcated_ganda'.$dagRow->dag_no.'" class="form-control text-center" placeholder="Please enter area" value="'.$bkl[3].'" readonly>
    //                                                 </div>
    //                                             </div>';
    //             }
    //             else
    //             {
    //                 $coSeperationInputHome =  '<div class="row mt-2">
    //                                                 <div class="col-4">
    //                                                     Area bifurcation Homestead
    //                                                 </div>
    //                                                 <div class="col-2">
    //                                                     <input type="number" name="bifurcated_home_bigha'.$dagRow->dag_no.'" id="bifurcated_bigha'.$dagRow->dag_no.'" class="form-control text-center" placeholder="Please enter area">
    //                                                 </div>
    //                                                 <div class="col-2">
    //                                                     <input type="number" name="bifurcated_home_katha'.$dagRow->dag_no.'" id="bifurcated_katha'.$dagRow->dag_no.'" class="form-control text-center" placeholder="Please enter area">
    //                                                 </div>
    //                                                 <div class="col-2">
    //                                                     <input type="number" name="bifurcated_home_lessa'.$dagRow->dag_no.'" id="bifurcated_lessa'.$dagRow->dag_no.'" class="form-control text-center" placeholder="Please enter area">
    //                                                 </div>
    //                                                 <div class="col-2">
    //                                                     <input type="number" name="bifurcated_home_ganda'.$dagRow->dag_no.'" id="bifurcated_ganda'.$dagRow->dag_no.'" class="form-control text-center" placeholder="Please enter area">
    //                                                 </div>
    //                                             </div>';

    //                 $coSeperationInputAgri =  '<div class="row mt-2">
    //                                                 <div class="col-4">
    //                                                     Area bifurcation Agriculture
    //                                                 </div>
    //                                                 <div class="col-2">
    //                                                     <input type="number" name="bifurcated_agri_bigha'.$dagRow->dag_no.'" id="bifurcated_bigha'.$dagRow->dag_no.'" class="form-control text-center" placeholder="Please enter area">
    //                                                 </div>
    //                                                 <div class="col-2">
    //                                                     <input type="number" name="bifurcated_agri_katha'.$dagRow->dag_no.'" id="bifurcated_katha'.$dagRow->dag_no.'" class="form-control text-center" placeholder="Please enter area">
    //                                                 </div>
    //                                                 <div class="col-2">
    //                                                     <input type="number" name="bifurcated_agri_lessa'.$dagRow->dag_no.'" id="bifurcated_lessa'.$dagRow->dag_no.'" class="form-control text-center" placeholder="Please enter area">
    //                                                 </div>
    //                                                 <div class="col-2">
    //                                                     <input type="number" name="bifurcated_agri_ganda'.$dagRow->dag_no.'" id="bifurcated_ganda'.$dagRow->dag_no.'" class="form-control text-center" placeholder="Please enter area">
    //                                                 </div>
    //                                             </div>';

    //             }
    //         }
    //         else
    //         {

    //             if($landType == 3 || $landType == 1)
    //             {
    //                 $settle_home = '<div class="row mt-2">
    //                                     <div class="col-3">
    //                                         Homestead Area
    //                                     </div>
    //                                     <div class="col-3">
    //                                         <input type="number" name="home_b'.$dagRow->dag_no.'" id="home_b'.$dagRow->dag_no.'" class="form-control text-center" value="'.$dagRow->home_b.'" readonly>
    //                                     </div>
    //                                     <div class="col-3">
    //                                         <input type="number" name="home_k'.$dagRow->dag_no.'" id="home_k'.$dagRow->dag_no.'" class="form-control text-center" value="'.$dagRow->home_k.'" readonly>
    //                                     </div>
    //                                     <div class="col-3">
    //                                         <input type="number" name="home_lc'.$dagRow->dag_no.'" id="home_lc'.$dagRow->dag_no.'" class="form-control text-center" value="'.$dagRow->home_lc.'" readonly>
    //                                     </div>
    //                                 </div>';
    //             }

    //             if($landType == 3 || $landType == 2)
    //             {
    //                 $settle_agri = '<div class="row mt-2">
    //                                     <div class="col-3">
    //                                         Agriculture Area
    //                                     </div>
    //                                     <div class="col-3">
    //                                         <input type="number" name="agri_b'.$dagRow->dag_no.'" id="agri_b'.$dagRow->dag_no.'" class="form-control text-center" value="'.$dagRow->agri_b.'" readonly>
    //                                     </div>
    //                                     <div class="col-3">
    //                                         <input type="number" name="agri_k'.$dagRow->dag_no.'" id="agri_k'.$dagRow->dag_no.'" class="form-control text-center" value="'.$dagRow->agri_k.'" readonly>
    //                                     </div>
    //                                     <div class="col-3">
    //                                         <input type="number" name="agri_lc'.$dagRow->dag_no.'" id="agri_lc'.$dagRow->dag_no.'" class="form-control text-center" value="'.$dagRow->agri_lc.'" readonly>
    //                                     </div>
    //                                 </div>';
    //             }

    //             //******this is for settlement area */
    //             $barak_settle = '<div class="row mt-2">
    //                                 <div class="col-3">
    //                                     Total Settlement Area
    //                                 </div>
    //                                 <div class="col-3">
    //                                     <input type="number" name="s_dag_area_b'.$dagRow->dag_no.'" id="s_dag_area_b'.$dagRow->dag_no.'" class="form-control text-center" value="'.$dagRow->s_dag_area_b.'" readonly>
    //                                 </div>
    //                                 <div class="col-3">
    //                                     <input type="number" name="s_dag_area_k'.$dagRow->dag_no.'" id="s_dag_area_k'.$dagRow->dag_no.'" class="form-control text-center" value="'.$dagRow->s_dag_area_k.'" readonly>
    //                                 </div>
    //                                 <div class="col-3">
    //                                     <input type="number" name="s_dag_area_lc'.$dagRow->dag_no.'" id="s_dag_area_lc'.$dagRow->dag_no.'" class="form-control text-center" value="'.$dagRow->s_dag_area_lc.'" readonly>
    //                                 </div>
    //                             </div>';

    //             //*******this is for final settlement area */
    //             $bkl = $this->utilityclass->Total_Bigha_Katha_Lessa($premRow->total_lessa);

    //             $barak_final_settle = '<div class="row mt-2">
    //                                         <div class="col-3">
    //                                             Final Settlement Area
    //                                         </div>
    //                                         <div class="col-3">
    //                                             <input type="number" class="form-control text-center" value="'.$bkl[0].'" readonly>
    //                                         </div>
    //                                         <div class="col-3">
    //                                             <input type="number" class="form-control text-center" value="'.$bkl[1].'" readonly>
    //                                         </div>
    //                                         <div class="col-3">
    //                                             <input type="number" class="form-control text-center" value="'.$bkl[2].'" readonly>
    //                                         </div>
    //                                     </div>';

    //             if($landType != 3)
    //             {
    //                 $coSeperationInputHome =  '<div class="row mt-2">
    //                                                 <div class="col-3">
    //                                                     Area bifurcation Homestead
    //                                                 </div>
    //                                                 <div class="col-3">
    //                                                     <input type="number" name="bifurcated_home_bigha'.$dagRow->dag_no.'" id="bifurcated_bigha'.$dagRow->dag_no.'" class="form-control text-center" placeholder="Please enter area" value="'.$bkl[0].'" readonly>
    //                                                 </div>
    //                                                 <div class="col-3">
    //                                                     <input type="number" name="bifurcated_home_katha'.$dagRow->dag_no.'" id="bifurcated_katha'.$dagRow->dag_no.'" class="form-control text-center" placeholder="Please enter area" value="'.$bkl[1].'" readonly>
    //                                                 </div>
    //                                                 <div class="col-3">
    //                                                     <input type="number" name="bifurcated_home_lessa'.$dagRow->dag_no.'" id="bifurcated_lessa'.$dagRow->dag_no.'" class="form-control text-center" placeholder="Please enter area" value="'.$bkl[2].'" readonly>
    //                                                 </div>
    //                                             </div>';

    //                 $coSeperationInputAgri =  '<div class="row mt-2">
    //                                                 <div class="col-3">
    //                                                     Area bifurcation Agriculture
    //                                                 </div>
    //                                                 <div class="col-3">
    //                                                     <input type="number" name="bifurcated_agri_bigha'.$dagRow->dag_no.'" id="bifurcated_bigha'.$dagRow->dag_no.'" class="form-control text-center" placeholder="Please enter area" value="'.$bkl[0].'" readonly>
    //                                                 </div>
    //                                                 <div class="col-3">
    //                                                     <input type="number" name="bifurcated_agri_katha'.$dagRow->dag_no.'" id="bifurcated_katha'.$dagRow->dag_no.'" class="form-control text-center" placeholder="Please enter area" value="'.$bkl[1].'" readonly>
    //                                                 </div>
    //                                                 <div class="col-3">
    //                                                     <input type="number" name="bifurcated_agri_lessa'.$dagRow->dag_no.'" id="bifurcated_lessa'.$dagRow->dag_no.'" class="form-control text-center" placeholder="Please enter area" value="'.$bkl[2].'" readonly>
    //                                                 </div>
    //                                             </div>';
    //             }
    //             else
    //             {
    //                 $coSeperationInputHome =  '<div class="row mt-2">
    //                                                 <div class="col-3">
    //                                                     Area bifurcation Homestead
    //                                                 </div>
    //                                                 <div class="col-3">
    //                                                     <input type="hidden" name="case_no" id="case_no" value="'.$case_no.'">
    //                                                     <input type="number" name="bifurcated_home_bigha'.$dagRow->dag_no.'" id="bifurcated_home_bigha'.$dagRow->dag_no.'" class="form-control text-center" placeholder="Please enter area">
    //                                                 </div>
    //                                                 <div class="col-3">
    //                                                     <input type="number" name="bifurcated_home_katha'.$dagRow->dag_no.'" id="bifurcated_home_katha'.$dagRow->dag_no.'" class="form-control text-center" placeholder="Please enter area">
    //                                                 </div>
    //                                                 <div class="col-3">
    //                                                     <input type="number" name="bifurcated_home_lessa'.$dagRow->dag_no.'" id="bifurcated_home_lessa'.$dagRow->dag_no.'" class="form-control text-center" placeholder="Please enter area">
    //                                                 </div>
    //                                             </div>';

    //                 $coSeperationInputAgri =  '<div class="row mt-2">
    //                                                 <div class="col-3">
    //                                                     Area bifurcation Agriculture
    //                                                 </div>
    //                                                 <div class="col-3">
    //                                                     <input type="number" name="bifurcated_agri_bigha'.$dagRow->dag_no.'" id="bifurcated_agri_bigha'.$dagRow->dag_no.'" class="form-control text-center" placeholder="Please enter area">
    //                                                 </div>
    //                                                 <div class="col-3">
    //                                                     <input type="number" name="bifurcated_agri_katha'.$dagRow->dag_no.'" id="bifurcated_agri_katha'.$dagRow->dag_no.'" class="form-control text-center" placeholder="Please enter area">
    //                                                 </div>
    //                                                 <div class="col-3">
    //                                                     <input type="number" name="bifurcated_agri_lessa'.$dagRow->dag_no.'" id="bifurcated_agri_lessa'.$dagRow->dag_no.'" class="form-control text-center" placeholder="Please enter area">
    //                                                 </div>
    //                                             </div>';
    //             }

    //         }

    //         if($landType != 3)
    //         {
    //             if($landType != 1)
    //             {
    //                 $coSeperationInputHome = '';
    //             }
    //             else if($landType != 2)
    //             {
    //                 $coSeperationInputAgri = '';
    //             }
    //         }

    //         $formGroup .= $barak_Nr.$settle_home.$settle_agri.$barak_settle.$roadsideReservation.$barak_final_settle.$coSeperationInputHome.$coSeperationInputAgri.'<br>';

    //     }

    //     echo json_encode([
    //         'responseType' => 2,
    //         'content' => $formGroup
    //     ]);
    // }

    public function chithaUpdateDetails()
    {
        $case_no = $this->input->post('case_no');

        $chithaDetailsMod = $this->SettlementCommonModel->getChithaUpdateDetails($case_no);

        $newEnc = $this->SettlementCommonModel->isEncNewlyAdded($case_no);
        if ($newEnc->num_rows() > 0) {
            $encNewAdd = '<span class="text-warning">(Encroacher will be added to VLB)</span>';
        } else {
            $encNewAdd = '';
        }

        if ($chithaDetailsMod['responseType'] != 2) {
            echo json_encode([
                'responseType' => 0,
                'msg' => $chithaDetailsMod['msg'],
            ]);
            return false;
        }

        //*****getting the pattadar_informations */
        $pattadar_info = '';
        $primaryApplicantArr = '';

        //***getting the applicant */
        foreach ($chithaDetailsMod['applicantArray'] as $main_applicant) {
            if (($main_applicant['is_applicant'] == 1) && $main_applicant['pdar_type'] == 'B') {
                foreach (json_decode(GENDER_NEW_APPL) as $gender) {
                    if ($gender->CODE == $main_applicant['gender']) {
                        $genderText = $gender->NAME;
                    }
                }

                $primaryApplicantArr .=
                    '
                <tr class="border">
                    <th colspan="4" class="p-1"><span class="bg-info p-2 shadow">Applicant ' . $encNewAdd . '</span></th>
                </tr>
                <tr>
                    <th>
                        Pattadar Name:
                    </th>
                    <td colspan="4">
                        ' . $main_applicant['applicant_assamese_name'] . ' /<small>' . $genderText . '</small>
                    </td>
                </tr>
                <tr>
                    <th>
                        Pattadar Guardian:
                    </th>
                    <td colspan="4">
                        ' . $main_applicant['guardian_assamese_name'] . '
                    </td>
                </tr>
                <tr>
                    <th>
                        Identity verified by:
                    </th>
                    <td>
                        ' . $main_applicant['identity_type'] . '
                    </td>
                    <th>
                        Mobile:
                    </th>
                    <td>
                        ' . $main_applicant['mobile'] . '
                    </td>
                </tr>
                <tr>
                    <th>
                        Present Address:
                    </th>
                    <td>
                        ' . $main_applicant['present_address'] . '
                    </td>
                    <th>
                        Parment Address:
                    </th>
                    <td>
                        ' . $main_applicant['permanent_address'] . '
                    </td>
                </tr>
                ';
            }
        }

        $pattadar_info .= '<table class="table custom-table">' . $primaryApplicantArr . '</table>';

        //******Join applicant */
        $app_sl_count = 1;
        $app_head_count = 1;
        $joint_applicant = '';
        foreach ($chithaDetailsMod['applicantArray'] as $main_applicant) {
            if (($main_applicant['is_applicant'] != 1 || $main_applicant['is_applicant'] == null) && $main_applicant['pdar_type'] == 'B') {
                if ($app_head_count == 1) {
                    $joint_applicant .=
                        '<tr>
                        <th colspan="5" class="p-1"><span class="bg-info p-2 shadow">Joint Applicant</span></th>
                    </tr>';

                    $app_head_count++;
                }

                $joint_applicant .=
                '
                <tr>
                    <th rowspan="4" style="vertical-align:middle">' . $app_sl_count++ . '</th>
                    <th>
                        Pattadar Name:
                    </th>
                    <td colspan="3">
                        ' . $main_applicant['applicant_assamese_name'] . '
                    </td>
                </tr>
                <tr>
                    <th>
                        Pattadar Guardian:
                    </th>
                    <td colspan="3">
                        ' . $main_applicant['guardian_assamese_name'] . '
                    </td>
                </tr>
                <tr>
                    <th>
                        Identity verified by:
                    </th>
                    <td>
                        ' . $main_applicant['identity_type'] . '
                    </td>
                    <th>
                        Mobile:
                    </th>
                    <td>
                        ' . $main_applicant['mobile'] . '
                    </td>
                </tr>
                <tr>
                    <th>
                        Present Address:
                    </th>
                    <td>
                        ' . $main_applicant['present_address'] . '
                    </td>
                    <th>
                        Parment Address:
                    </th>
                    <td>
                        ' . $main_applicant['permanent_address'] . '
                    </td>
                </tr>
                ';
            }
        }

        $pattadar_info .= '<table class="table custom-table">' . $joint_applicant . '</table>';

        //****area of settlement */

        $dag_area = '';

        foreach ($chithaDetailsMod['dagArray'] as $area_det) {
            ///***rural/urban check */
            if ($area_det['homestead_details']['is_urban'] == 0) {
                $ru_detail = 'Rural';
            } else {
                $ru_detail = 'Urban';
            }

            $dag_area .= '
            <tr class="border">
                <th colspan="5" class="p-1">
                    <span class="bg-info p-2 shadow">Settlement area details [Dag No: ' . $area_det['homestead_details']['old_dag_no'] . '] [' . $ru_detail . ']</span>
                </th>
            </tr>';

            //***homestead */
            if ($area_det['land_type'] == 1 || $area_det['land_type'] == 3) {
                //*****settlement area */
                if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                    $s_area = 'B: ' . $area_det['homestead_details']['settlement_bigha'] . ' K: ' . $area_det['homestead_details']['settlement_katha'] . ' C: ' . $area_det['homestead_details']['settlement_lessa'] . ' G: ' . $area_det['homestead_details']['settlement_ganda'];
                } else {
                    $s_area = 'B: ' . $area_det['homestead_details']['settlement_bigha'] . ' K: ' . $area_det['homestead_details']['settlement_katha'] . ' L: ' . $area_det['homestead_details']['settlement_lessa'];
                }

                //*****roadside reservation */
                if ($area_det['homestead_details']['is_reservation'] == 1) {
                    if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                        $r_area = 'B: ' . $area_det['homestead_details']['road_side_reservation_bigha'] . ' K: ' . $area_det['homestead_details']['road_side_reservation_katha'] . ' C: ' . $area_det['homestead_details']['road_side_reservation_lessa'] . ' G: ' . $area_det['homestead_details']['road_side_reservation_ganda'];
                    } else {
                        $r_area = 'B: ' . $area_det['homestead_details']['road_side_reservation_bigha'] . ' K: ' . $area_det['homestead_details']['road_side_reservation_katha'] . ' L: ' . $area_det['homestead_details']['road_side_reservation_lessa'];
                    }
                } else {
                    $r_area = '';
                }

                $landmark = json_decode($area_det['homestead_details']['landmark']);

                $lndmrk = 'East: ' . $landmark->east . '<br>';
                $lndmrk .= 'West: ' . $landmark->west . '<br>';
                $lndmrk .= 'North: ' . $landmark->north . '<br>';
                $lndmrk .= 'South: ' . $landmark->south . '<br>';

                $dag_area .= '
                <tr>
                    <th rowspan="6" style="vertical-align : middle;" width="5px">
                        <span class="vertical">Homestead</span>
                    </th>
                    <th>
                        Applied Dag no:
                    </th>
                    <td>
                        ' . $area_det['homestead_details']['old_dag_no'] . '
                    </td>
                    <th>
                        Proposed Dag No for Homestead:
                    </th>
                    <td>
                        ' . $area_det['homestead_details']['new_dag_no'] . '
                    </td>
                </tr>
                <tr>
                    <th>
                        Proposed Patta No:
                    </th>
                    <td>
                        ' . $area_det['homestead_details']['new_patta_no'] . '
                    </td>
                    <th>
                        Proposed Patta Type:
                    </th>
                    <td>
                        ' . $area_det['homestead_details']['new_patta_type'] . '
                    </td>
                </tr>
                <tr>
                    <th>
                        Proposed Landclass:
                    </th>
                    <td>
                        ' . $area_det['homestead_details']['new_land_class'] . '
                    </td>
                    <th>
                        Possession from:
                    </th>
                    <td>
                        ' . $area_det['homestead_details']['possession_from'] . '
                    </td>
                </tr>

                <tr>
                    <th>
                        Land Revenue:
                    </th>
                    <td>
                        ' . $area_det['homestead_details']['new_land_revenue'] . '
                    </td>
                    <th>
                        Local tax:
                    </th>
                    <td>
                        ' . $area_det['homestead_details']['new_land_local_tax'] . '
                    </td>
                </tr>

                <tr>
                    <th>
                        Area of Settlement:
                    </th>
                    <td>
                        ' . $s_area . '
                    </td>
                    <th>
                        Roadside/Riverside Reservation:
                    </th>
                    <td>
                        ' . $r_area . '
                    </td>
                </tr>

                <tr>
                    <th>
                        Landmark of the Dag:
                    </th>
                    <td colspan="3">
                        ' . $lndmrk . '
                    </td>
                </tr>

                ';
            }

            if ($area_det['land_type'] == 2 || $area_det['land_type'] == 3) {

                //*****settlement area */
                if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                    $s_area = 'B: ' . $area_det['homestead_details']['settlement_bigha'] . ' K: ' . $area_det['homestead_details']['settlement_katha'] . ' C: ' . $area_det['homestead_details']['settlement_lessa'] . ' G: ' . $area_det['homestead_details']['settlement_ganda'];
                } else {
                    $s_area = 'B: ' . $area_det['homestead_details']['settlement_bigha'] . ' K: ' . $area_det['homestead_details']['settlement_katha'] . ' L: ' . $area_det['homestead_details']['settlement_lessa'];
                }

                //*****roadside reservation */
                if ($area_det['homestead_details']['is_reservation'] == 1) {
                    if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                        $r_area = 'B: ' . $area_det['homestead_details']['road_side_reservation_bigha'] . ' K: ' . $area_det['homestead_details']['road_side_reservation_katha'] . ' C: ' . $area_det['homestead_details']['road_side_reservation_lessa'] . ' G: ' . $area_det['homestead_details']['road_side_reservation_ganda'];
                    } else {
                        $r_area = 'B: ' . $area_det['homestead_details']['road_side_reservation_bigha'] . ' K: ' . $area_det['homestead_details']['road_side_reservation_katha'] . ' L: ' . $area_det['homestead_details']['road_side_reservation_lessa'];
                    }
                } else {
                    $r_area = '';
                }

                $landmark = json_decode($area_det['agriculture_details']['landmark']);

                $lndmrk = 'East: ' . $landmark->east . '<br>';
                $lndmrk .= 'West: ' . $landmark->west . '<br>';
                $lndmrk .= 'North: ' . $landmark->north . '<br>';
                $lndmrk .= 'South: ' . $landmark->south . '<br>';

                $dag_area .= '
                <tr>
                    <th rowspan="6" style="vertical-align : middle;" width="5px">
                        <span class="vertical">Agriculture</span>
                    </th>

                    <th>
                        Applied Dag no:
                    </th>
                    <td>
                        ' . $area_det['agriculture_details']['old_dag_no'] . '
                    </td>
                    <th>
                        Proposed Dag No for Agriculture:
                    </th>
                    <td>
                        ' . $area_det['agriculture_details']['new_dag_no'] . '
                    </td>
                </tr>
                <tr>
                    <th>
                        Proposed Patta No:
                    </th>
                    <td>
                        ' . $area_det['agriculture_details']['new_patta_no'] . '
                    </td>
                    <th>
                        Proposed Patta Type:
                    </th>
                    <td>
                        ' . $area_det['agriculture_details']['new_patta_type'] . '
                    </td>
                </tr>
                <tr>
                    <th>
                        Proposed Landclass:
                    </th>
                    <td>
                        ' . $area_det['agriculture_details']['new_land_class'] . '
                    </td>
                    <th>
                        Possession from:
                    </th>
                    <td>
                        ' . $area_det['agriculture_details']['possession_from'] . '
                    </td>
                </tr>

                <tr>
                    <th>
                        Land Revenue:
                    </th>
                    <td>
                        ' . $area_det['agriculture_details']['new_land_revenue'] . '
                    </td>
                    <th>
                        Local tax:
                    </th>
                    <td>
                        ' . $area_det['agriculture_details']['new_land_local_tax'] . '
                    </td>
                </tr>
                <tr>
                    <th>
                        Area of Settlement:
                    </th>
                    <td>
                        ' . $s_area . '
                    </td>
                    <th>
                        Roadside/Riverside Reservation:
                    </th>
                    <td>
                        ' . $r_area . '
                    </td>
                </tr>
                <tr>
                    <th>
                        Landmark of the Dag:
                    </th>
                    <td colspan="3">
                        ' . $lndmrk . '
                    </td>
                </tr>

                ';
            }
        }

        $pattadar_info .= '<table class="table custom-table">' . $dag_area . '</table>';

        //******payment details and dept order  */
        $payment_details = '';
        foreach ($chithaDetailsMod['dagArray'] as $area_det) {
            $payment_details .= '
                                <tr class="border">
                                    <th colspan="6" class="p-1">
                                        <span class="bg-info p-2 shadow">Premium Details</span>
                                    </th>
                                </tr>';

            if ($area_det['homestead_details']['is_fully_paid'] == 1) {
                $full_paid = 'Fully Paid';
            } else {
                $full_paid = 'Installment';
            }

            $payment_details .= '
                <tr>
                    <th>
                        Premium Amount:
                    </th>
                    <td>
                        ' . $area_det['homestead_details']['final_premium_amount'] . '
                    </td>
                    <th>
                        Paid Amount:
                    </th>
                    <td>
                        ' . $area_det['homestead_details']['paid_amount'] . '
                    </td>
                    <th>
                        Payment Status:
                    </th>
                    <td>
                        ' . $full_paid . '
                    </td>
                </tr>

                <tr>
                    <th>
                        GRN NO:
                    </th>
                    <td>
                        ' . $area_det['homestead_details']['grn_no'] . '
                    </td>
                    <th>
                        Department Order No:
                    </th>
                    <td>
                        ' . $area_det['homestead_details']['dept_order_no'] . '
                    </td>
                    <th>
                        Department Order Date:
                    </th>
                    <td>
                        ' . $area_det['homestead_details']['dept_order_date'] . '
                    </td>
                </tr>
            ';
            break;
        }

        $pattadar_info .= '<table class="table custom-table">' . $payment_details . '</table>';

        $f_content = $pattadar_info;

        echo json_encode([
            'responseType' => 2,
            'content' => $f_content,
        ]);
    }

    public function checkIfBifurcateAreaExceed()
    {
        $case_no = $this->input->post('case_no');
        // $dag_no = $this->input->post('dag_no');

        $getPremSql = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ?', array($case_no, 1));

        if ($getPremSql->num_rows() <= 0) {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR3871: Area not found!',
            ]);
            return false;
        }

        $premResult = $getPremSql->result();

        $totalLessa = 0;
        $totalHomeAgri = 0;

        foreach ($premResult as $premRow) {
            $bifurcated_home_bigha = $this->UtilsModel->defaultValue($this->input->post('bifurcated_home_bigha' . $premRow->dag_no), 0);
            $bifurcated_home_katha = $this->UtilsModel->defaultValue($this->input->post('bifurcated_home_katha' . $premRow->dag_no), 0);
            $bifurcated_home_lessa = $this->UtilsModel->defaultValue($this->input->post('bifurcated_home_lessa' . $premRow->dag_no), 0);
            $bifurcated_home_ganda = $this->UtilsModel->defaultValue($this->input->post('bifurcated_home_ganda' . $premRow->dag_no), 0);

            $bifurcated_agri_bigha = $this->UtilsModel->defaultValue($this->input->post('bifurcated_agri_bigha' . $premRow->dag_no), 0);
            $bifurcated_agri_katha = $this->UtilsModel->defaultValue($this->input->post('bifurcated_agri_katha' . $premRow->dag_no), 0);
            $bifurcated_agri_lessa = $this->UtilsModel->defaultValue($this->input->post('bifurcated_agri_lessa' . $premRow->dag_no), 0);
            $bifurcated_agri_ganda = $this->UtilsModel->defaultValue($this->input->post('bifurcated_agri_ganda' . $premRow->dag_no), 0);

            $totalLessa += $premRow->total_lessa;

            if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                $totalAppHome = $this->utilityclass->Total_ganda($bifurcated_home_bigha, $bifurcated_home_katha, $bifurcated_home_lessa, $bifurcated_home_ganda);
                $totalAppAgri = $this->utilityclass->Total_ganda($bifurcated_agri_bigha, $bifurcated_agri_katha, $bifurcated_agri_lessa, $bifurcated_agri_ganda);
            } else {
                $totalAppHome = $this->utilityclass->Total_Lessa($bifurcated_home_bigha, $bifurcated_home_katha, $bifurcated_home_lessa);
                $totalAppAgri = $this->utilityclass->Total_Lessa($bifurcated_agri_bigha, $bifurcated_agri_katha, $bifurcated_agri_lessa);
            }

            $totalHomeAgri += $totalAppHome + $totalAppAgri;
        }

        if ($totalHomeAgri != $totalLessa) {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR3921: Area should be equal to Final Settlement Area!',
            ]);
            return false;
        }

        echo json_encode([
            'responseType' => 2,
            'msg' => 'Success',
        ]);

    }

    //script-validation-callback
    public function check_script($str)
    {

        if (strpos(trim(strtolower($str)), '<') !== false) {
            return false;
        }

        if (strpos(trim(strtolower($str)), '>') !== false) {
            return false;
        }

        if (strpos(trim(strtolower($str)), '<script>') !== false) {
            return false;
        }
        if (strpos(trim(strtolower($str)), '</script>') !== false) {
            return false;
        }
        return true;
    }

    //date-validation-callback
    public function date_valid($date)
    {
        if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date)) {
            return false;
        }

        $day = (int) substr($date, 8, 2);
        $month = (int) substr($date, 5, 2);
        $year = (int) substr($date, 0, 4);
        return checkdate($month, $day, $year);
    }

    //manual payment update handle
    public function manualPaymentDetailsSubmitHandle()
    {
        //***********************************************************************/
        // file validation
        if (isset($_FILES['manual_chalan']['name'])) {
            if ($_FILES['manual_chalan']['name'] && $_FILES['manual_chalan']['size'] && $_FILES['manual_chalan']['tmp_name']) {
                $name = $_FILES['manual_chalan']['name'];
                $size = $_FILES['manual_chalan']['size'];
                $mime = mime_content_type($_FILES['manual_chalan']['tmp_name']);
                $exp = explode("/", $mime);
                $ext = $exp[1];
                if ($name != null) {
                    if ($ext == null) {
                        echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Invalid Challan, Please Upload Correctly, ERR-#SMCPF001']);
                        exit;

                    }
                    if ($ext != 'pdf') {
                        echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Invalid Challan, Please Upload Pdf Only, ERR-#SMCPF002']);
                        exit;
                    }
                    if ($size > UPLOAD_MAX_SIZE) {
                        echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Invalid Challan, Please Upload Challan Less Than 5mb, ERR-#SMCPF003']);
                        exit;
                    }
                } else {
                    echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Please Upload The Challan, ERR-#SMCPF004']);
                    exit;
                }
            } else {
                echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Please Upload The Challan, ERR-#SMCPF005']);
                exit;
            }
        } else {
            echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Please Upload The Challan, ERR-#SMCPF006']);
            exit;
        }
        //***********************************************************************/
        // post field validation
        $error_msg = array();
        $manual_challan_validation_arr = [
            [
                'field' => 'grn_no',
                'label' => 'GRN-NO',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[45]',
            ],
            [
                'field' => 'amount',
                'label' => 'Amount',
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric',
            ],
            [
                'field' => 'payment_date',
                'label' => 'Payment-Date',
                'rules' => 'required|callback_check_script|trim|xss_clean|callback_date_valid',
            ],
            [
                'field' => 'case_no',
                'label' => 'Case-No',
                'rules' => 'required|callback_check_script|trim|xss_clean',
            ],

        ];
        $this->form_validation->set_rules($manual_challan_validation_arr);
        $this->form_validation->set_message('check_script', 'Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid', 'Please Fill The %s Correctly!');
        if ($this->form_validation->run() == false) {
            foreach ($manual_challan_validation_arr as $rule) {
                if (form_error($rule['field'])) {
                    array_push($error_msg, form_error($rule['field']));
                }
            }
        }
        if (count($error_msg) != 0) {
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => $error_msg]);
            exit;
        }
        //***********************************************************************/
        $sql = "select applid from settlement_basic sb where case_no=?";
        $query = $this->db->query($sql, array($_POST['case_no']));
        if ($query->num_rows() != 1) {
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => 'Some error occured, Error-Code : #smcu0045']);
            exit;
        }

        $paymentDate = $_POST['payment_date'];
        if (date('Y-m-d H:i:s', strtotime(MANUAL_MAX_PAYMENT_DATE)) < date('Y-m-d H:i:s', strtotime($paymentDate))) {
            echo json_encode(['result' => 'FAILED', 'msg' => 'Payment date cannot be greater then ' . MANUAL_MAX_PAYMENT_DATE_SHOW]);
            exit;
        }

        $application_no = $query->row()->applid;
        $sql = "select pid,due_amount from settlement_premium where case_no=? and is_final=1";
        $query = $this->db->query($sql, array($_POST['case_no']));
        $result = $query->result();
        $sp_row_count = count($result);
        //***********************************************************************/
        if ($sp_row_count == 0) {
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => 'Some error occured, Error-Code : #smcu003']);
            exit;
        }
        //***********************************************************************/
        $due_amount = $result[0]->due_amount;
        $remaining_amount = (float) $due_amount - (float) $_POST['amount'];
        if ($remaining_amount > 0) {
            $is_full_pay = 'NO';
            $percentage = '30';
            //***************************************************************************/
            //Rural Urban Checking
            $sqlRU = "select area_name from settlement_premium where case_no=? and is_final=1";
            $queryRU = $this->db->query($sqlRU, array($_POST['case_no']));
            $resultRU = $queryRU->result();
            foreach ($resultRU as $rowRU) {
                $area_name = trim((string) $rowRU->area_name);
                if ($area_name == '7' || $area_name == '8' || $area_name == '9' || $area_name == '10' || $area_name == '18' || $area_name == '19' || $area_name == '20' || $area_name == '21' || $area_name == '22') {
                    echo json_encode(['result' => 'FAILED', 'msg' => 'Partial payment for rural area is not allowed..!']);
                    exit;
                }
            }
            //***************************************************************************/
        } else {
            $is_full_pay = 'YES';
            $percentage = '100';
        }
        //***************************************************************** */
        //file moving section
        $file_new_name = "echallan" . $_POST['grn_no'];
        $manual_challan_upload_dir = UPLOAD_MANUAL_CHALAN_DIR . $file_new_name;
        $file_full_path = UPLOAD_MANUAL_CHALAN_DIR . $file_new_name . ".pdf";
        move_uploaded_file($_FILES['manual_chalan']['tmp_name'], $file_full_path);
        if (!file_exists($file_full_path)) {
            log_message("error", "#smcuuf001, Error in moving file for the case_no " . $_POST['case_no']);
            echo json_encode(['result' => 'FAILED', 'msg' => 'Some error occured, Error-Code : #smcuuf001']);
            exit;
        }
        //******************************************************************/
        $sp_update_data = [
            'grn_no' => $_POST['grn_no'],
            'payment_date' => $_POST['payment_date'],
            'is_full_pay' => $is_full_pay,
            'total_premium' => $due_amount,
            'paid_amount' => $_POST['amount'],
            'remaining_amount' => $remaining_amount,
            'tenure' => '5',
            'installment_amount' => $remaining_amount / 5,
            'manual_challan_upload_dir' => $manual_challan_upload_dir,
            'manual_challan_details' => json_encode($_POST),
            'is_manual_challan' => 'Y',
        ];
        $this->db->trans_begin();
        $this->db->where('case_no', $_POST['case_no'])
            ->where('is_final', 1)
            ->update('settlement_premium', $sp_update_data);

        if ($this->db->affected_rows() != $sp_row_count) {
            //if no updation made
            $this->db->trans_rollback();
            log_message("error", "#smcu001, Error in update, table 'settlement_premium' with query :" . $this->db->last_query());
            echo json_encode(['result' => 'FAILED', 'msg' => 'Some error occured, Error-Code : #smcu001']);
            exit;
        }

        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            log_message("error", "#smcu002, Transaction Status Error In manual challan update, settlement_premium tables for case_no " . $_POST['case_no']);
            echo json_encode(['result' => 'FAILED', 'msg' => 'Some error occured, Error-Code : #smcu002']);
            exit;
        } else {

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => API_LINK_MB2 . 'updateManualPaymentDetails',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'application_no' => $application_no,
                    'grn_no' => $_POST['grn_no'],
                    'due_amount' => $due_amount,
                    'ip_address' => $this->utilityclass->get_client_ip(),
                    'payment_date' => $_POST['payment_date'],
                    'paid_amount' => $_POST['amount'],
                    'remaining_amount' => $remaining_amount,
                    'installment_amount' => $remaining_amount / 5,
                    'percentage' => $percentage,
                ),
            ));
            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            if ($httpcode == 200) {
                $resp = json_decode($response);
                if ($resp->result == 'SUCCESS') {
                    $this->db->trans_commit();
                    echo json_encode(['result' => 'SUCCESS', 'msg' => 'Challan Details Updated Successfully..!']);
                    exit;
                } else {
                    echo json_encode(['result' => 'FAILED', 'msg' => 'Interal Server Error, Error-Code : #smcu0034']);
                    exit;
                }

            } else {
                echo json_encode(['result' => 'FAILED', 'msg' => 'Interal Server Error, Error-Code : #smcu0035']);
                exit;
            }
        }
    }

    // view list  prastavit pattan patra by Masud 08/01/2024
    public function viewListPrastavitPattanPatra()
    {
        $user_desig_code = $this->session->userdata('user_desig_code');
        if ($user_desig_code != 'AST') {
            $this->session->set_flashdata('message', "#HOMEC250773 : Unauthorized access");
            redirect(base_url() . "index.php/home");
        }
        $service_code = $this->input->get('service');
        $status = $this->input->get('s');
        $data['getPaymentConfirmationCo'] = $this->SettlementMbModel->getPaymentConfirmationCo($service_code);
        $data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);

        $data['_view'] = 'settlement_mb/paymentConfirmationCasesAsst';
        $this->load->view('layouts/main', $data);
    }

    public function chithaBulkList()
    {
        $service_code = $this->input->get('service');
        $status = $this->input->get('s');
        // $data['getPaymentConfirmationCo'] = $this->SettlementMbModel->getLmVerificationCases($service_code);
        $data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);

        $data['_view'] = 'settlement_mb/bulk_chitha_update';

        $this->load->view('layouts/main', $data);
    }

    public function paginationBulkChitaUpdate()
    {
        if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
            $lot_string = $this->caseListUnderMappingLot();
        }

        $s_code = $this->input->post('service');
        $search_term = $this->input->post('search_term');
        $remark_cat = $this->input->post('remark_cat');
        $reverted = $this->input->post('reverted');
        $user_code = $this->session->userdata('user_code');
        $l_mis = $this->input->post('l_mis');
        // $payment_status = $this->input->post('payment_status');

        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        // $nr_cat = $this->input->post('nr_cat');

        // $status = $this->input->post('status');
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        $p_type = $this->input->post('p_type');

        $col = 0;
        $dir = "";
        $search = $this->input->post('search');
        $search = $search['value'];

        $searchByCol_0 = $this->input->post('columns')[1]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[2]['search']['value'];
        $searchByCol_3 = $this->input->post('columns')[4]['search']['value'];

        $is_cat = $this->input->post('is_category');

        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'asc';
        }

        // $valid_columns = array(
        //     0 => 'a.date_entry',
        // );

        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        if ($order != null) {
            $this->db->order_by($order, $dir);
        }

        if (!empty($searchByCol_0)) {

            $this->db->like('a.case_no', strtoupper($searchByCol_0));
        }

        if (!empty($searchByCol_1)) {

            $this->db->like('a.applid', strtoupper($searchByCol_1));
        }

        if (!empty($searchByCol_3)) {
            $this->db->like('TO_CHAR(a.date_entry,\'yyyy-mm-dd\')', $searchByCol_3);
            //$this->db->like('date_entry', $searchByCol_2);
        }

        $this->db->limit($length, $start);

        $this->db->where('a.service_code', $s_code);

        if (!empty($remark_cat)) { //settlement_ap_lmnote, lm_note
            $this->db->where('b.lm_note', $remark_cat);
        }

        if (!empty($mouza_pargona_code)) {
            $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
        }

        if (!empty($mouza_pargona_code) && !empty($lot_no)) {
            $this->db->where('a.lot_no', $lot_no);
        }

        if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }

        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

        if ($this->session->userdata('user_desig_code') == 'CO') {
            // $this->db->where('a.co_code', $user_code);
            // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
            if (LOT_BIFURCATE == 1 && empty($mouza_pargona_code) && empty($lot_no)) {

                if (isset($lot_string) && $lot_string != null) {
                    $this->db->where("CONCAT(a.mouza_pargona_code, '_', a.lot_no) in ($lot_string)");
                }
            }
        }

        if (!empty($p_type)) {
            if ($p_type == 'f') {
                $this->db->where('sp.due_amount <= sp.paid_amount');
            }

            if ($p_type == 'p') {
                $this->db->where('sp.due_amount > sp.paid_amount');
            }
        }

        if (!in_array($s_code, [SETTLEMENT_TENANT_ID, SETTLEMENT_TENANT_URBAN_ID])) {
            $this->db->where('chitha_processing_details', 2);
            $this->db->where('status', 'N');
        }else{
            $this->db->where('status', 'VN');
        }


        $this->db->join('settlement_premium sp', 'sp.case_no = a.case_no');
        $this->db->where('sp.is_final', 1);
        $this->db->where('sp.grn_no is not null');
        $this->db->where('a.pending_officer', 'CO');
        if (!in_array($s_code, [SETTLEMENT_TENANT_ID, SETTLEMENT_TENANT_URBAN_ID])) {
            $this->db->where('a.from_office', 'CO');
        } else {
            $this->db->where('a.from_office', 'DC');
        }

        $this->db->where('a.order_passed is null', null, false);
        $this->db->where('a.co_chitha_corrected_yn is null', null, false);
        // if($this->session->userdata('dist_code') != '24'){
        if (!in_array($s_code, [SETTLEMENT_TENANT_ID, SETTLEMENT_TENANT_URBAN_ID]) && !in_array($s_code,MB3_SERVICES)) {
            $this->db->where("DATE_PART('day', now()::timestamp- a.ppp_issue_date::timestamp)>15");
        }
        // }
        $this->db->from('settlement_basic a');
        $this->db->select('distinct(a.case_no), a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry');

        $landcc = '';

        if (!empty($l_mis)) {
            if ($l_mis == 'l_miss') {
                // $this->db->join('settlement_dag_details sd', 'sd.case_no = a.case_no');
                $this->db->where('EXISTS (SELECT 1 FROM settlement_dag_details sd WHERE sd.case_no = a.case_no AND ((sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = \'\' OR sd.new_land_class_agri = \'\')))', null, false);

                $landcc = 'Landclass missing';
            }
            if ($l_mis == 'l_not_mis') {
                $this->db->where('NOT EXISTS (SELECT 1 FROM settlement_dag_details sd WHERE sd.case_no = a.case_no AND ((sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = \'\' OR sd.new_land_class_agri = \'\')))', null, false);

                $landcc = 'Landclass not missing';

            }
        }

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {

                $tenant_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>';
                $tribal_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>';
                $ap_link     = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>';
                $khas_link   = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>';
                $nc_link     = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>';
                $vgr_link    = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>';
                $tea_link    = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>';
                $tenant_urban_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>';

                //*****getting the payment made type */
                $getPType = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ?', array($rows->case_no, 1))->row();

                if ($getPType->paid_amount < $getPType->due_amount) {
                    $pTypeText = 'Partial Payment';
                } else if ($getPType->paid_amount >= $getPType->due_amount) {
                    $pTypeText = 'Full Payment';
                } else {
                    $pTypeText = '';
                }

                $json[] = array(
                    $rows->case_no,
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                    $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                    $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    date("Y-m-d", strtotime($rows->date_entry)),

                    // $lmnoteRemark,
                    $pTypeText,
                    $landcc,

                    (($s_code == SETTLEMENT_TENANT_ID) ? $tenant_link :
                        (($s_code == SETTLEMENT_AP_TRANSFER_ID) ? $ap_link :
                        (($s_code == SETTLEMENT_TRIBAL_COMMUNITY_ID) ? $tribal_link :
                        (($s_code == SETTLEMENT_KHAS_LAND_ID) ? $khas_link :
                        (($s_code == NC_KHAS_LAND_ID) ? $nc_link :
                        (($s_code == SETTLEMENT_PGR_VGR_LAND_ID) ? $vgr_link :
                        (($s_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID) ? $tea_link :
                        (($s_code == SETTLEMENT_TENANT_URBAN_ID) ? $tenant_urban_link : ''))))))))
                );

            }

            $this->db->where('a.service_code', $s_code);
            $this->db->where('a.pending_officer', MB_CIRCLE_OFFICER);
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

            if ($this->session->userdata('user_desig_code') == 'CO') {
                if (LOT_BIFURCATE == 1 && empty($mouza_pargona_code) && empty($lot_no)) {

                    if (isset($lot_string) && $lot_string != null) {
                        $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                    }
                }
            }

            if (!empty($mouza_pargona_code)) {
                $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
            }

            if (!empty($mouza_pargona_code) && !empty($lot_no)) {
                $this->db->where('a.lot_no', $lot_no);
            }

            if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
                $this->db->where('a.vill_townprt_code', $is_cat);
            }

            $this->db->select('distinct(a.case_no), a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry');
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
            $this->db->where('a.notice_generated_yn', null);
            $this->db->where('status', 'N');

            if (!in_array($s_code, [SETTLEMENT_TENANT_ID, SETTLEMENT_TENANT_URBAN_ID])) {
                $this->db->where('chitha_processing_details', 2);
                $this->db->where('status', 'N');
            }else{
                $this->db->where('status', 'VN');
            }

            $this->db->join('settlement_premium sp', 'sp.case_no = a.case_no');
            $this->db->where('sp.is_final', 1);
            $this->db->where('sp.grn_no is not null');
            $this->db->where('a.pending_officer', 'CO');
            if (!in_array($s_code, [SETTLEMENT_TENANT_ID, SETTLEMENT_TENANT_URBAN_ID])) {
                $this->db->where('a.from_office', 'CO');
            } else {
                $this->db->where('a.from_office', 'DC');
            }

            $this->db->where('a.order_passed is null', null, false);
            $this->db->where('a.co_chitha_corrected_yn is null', null, false);
            if (!in_array($s_code, [SETTLEMENT_TENANT_ID, SETTLEMENT_TENANT_URBAN_ID])) {
                $this->db->where("DATE_PART('day', now()::timestamp- a.ppp_issue_date::timestamp)>15");
            }

            if (!empty($l_mis)) {
                if ($l_mis == 'l_miss') {
                    $this->db->where('EXISTS (SELECT 1 FROM settlement_dag_details sd WHERE sd.case_no = a.case_no AND ((sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = \'\' OR sd.new_land_class_agri = \'\')))', null, false);
                }

                if ($l_mis == 'l_not_mis') {
                    $this->db->where('NOT EXISTS (SELECT 1 FROM settlement_dag_details sd WHERE sd.case_no = a.case_no AND ((sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = \'\' OR sd.new_land_class_agri = \'\')))', null, false);
                }
            }

            if (!empty($p_type)) {
                if ($p_type == 'f') {
                    $this->db->where('sp.due_amount <= sp.paid_amount');
                }

                if ($p_type == 'p') {
                    $this->db->where('sp.due_amount > sp.paid_amount');
                }
            }

            $this->db->from('settlement_basic a');

            $qu = $this->db->get();

            $total_records = $qu->num_rows();

            // echo $this->db->last_query();die;
            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json,
            );

            echo json_encode($response);

        } else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }

    public function bulkChithaUpdate()
    {
        // var_dump($_POST['selectMark']);
        // echo json_encode(array('responseType'=>2,'msg'=>'Opening Soon !!'));
        // return;
        $final = $passedcases = array();
        if (empty($_POST['selectMark'])) {
            echo json_encode(array('responseType' => 2, 'msg' => 'Please Select Case No'));
            return;
        }
        $this->load->model('ChithaUpdateModel');

        $dist_code = $this->session->userdata('dist_code');

        foreach ($_POST['selectMark'] as $key => $value) {
            $case_no = $value;
            $replica_db = $this->DataBaseSwitchModel->dharReplDbSwitch($dist_code);
            $chithaDetailsMod = $this->SettlementCommonModel->getChithaUpdateDetails($case_no, $replica_db);
            if ($chithaDetailsMod['responseType'] != 2) {
                log_message('error', '#ERR356564114'.json_encode($chithaDetailsMod));
            }

            $this->db->trans_begin();
            $status = $this->ChithaUpdateModel->caseDetails($case_no, $chithaDetailsMod);

            if ($status == true || $status === true) {
                // $this->db->trans_rollback();
                $this->db->trans_commit();
                $msg = "Transaction SUCCESS";
                $passedcases[] = array($case_no);
                // echo "Transaction SUCCESS";
            } else {
                log_message('error', '#ERR56564114'.json_encode($status));
                $this->db->trans_rollback();
                $final[] = array($case_no);
                $msg = "Transaction FAILED";
            }
        }
        echo json_encode(array('responseType' => 2, 'msg' => 'Successfully order Passed', 'failed' => json_encode($final), 'passed' => json_encode($passedcases)));
        return;
    }

    public function partialPaymentConfirmationList()
    {
        $service_code = $this->input->get('service');
        $status = $this->input->get('s');
        // $data['getPaymentConfirmationCo'] = $this->SettlementMbModel->getLmVerificationCases($service_code);
        $data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);

        $data['_view'] = 'settlement_mb/partial_payment_list';
        $this->load->view('layouts/main', $data);
    }

    public function chithaBulkListPartial()
    {
        $service_code = $this->input->get('service');
        $status = $this->input->get('s');
        $data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);
        $data['_view'] = 'settlement_mb/bulk_chitha_update_partial';
        $this->load->view('layouts/main', $data);
    }
    public function paginationBulkChitaUpdatePartial()
    {
        if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
            $lot_string = $this->caseListUnderMappingLot();
        }

        $s_code = $this->input->post('service');
        $search_term = $this->input->post('search_term');
        $remark_cat = $this->input->post('remark_cat');
        $reverted = $this->input->post('reverted');
        $user_code = $this->session->userdata('user_code');
        $l_mis = $this->input->post('l_mis');
        // $payment_status = $this->input->post('payment_status');

        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        // $nr_cat = $this->input->post('nr_cat');

        // $status = $this->input->post('status');
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        $p_type = $this->input->post('p_type');

        $col = 0;
        $dir = "";
        $search = $this->input->post('search');
        $search = $search['value'];

        $searchByCol_0 = $this->input->post('columns')[1]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[2]['search']['value'];
        $searchByCol_3 = $this->input->post('columns')[4]['search']['value'];
        $is_cat = $this->input->post('is_category');

        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'asc';
        }

        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        if ($order != null) {
            $this->db->order_by($order, $dir);
        }
        if (!empty($searchByCol_0)) {
            $this->db->like('a.case_no', strtoupper($searchByCol_0));
        }
        if (!empty($searchByCol_1)) {
            $this->db->like('a.applid', strtoupper($searchByCol_1));
        }

        if (!empty($searchByCol_3)) {
            $this->db->like('TO_CHAR(a.date_entry,\'yyyy-mm-dd\')', $searchByCol_3);
        }
        $this->db->limit($length, $start);
        $this->db->where('a.service_code', $s_code);
        if (!empty($remark_cat)) { //settlement_ap_lmnote, lm_note
            $this->db->where('b.lm_note', $remark_cat);
        }
        if (!empty($mouza_pargona_code)) {
            $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
        }

        if (!empty($mouza_pargona_code) && !empty($lot_no)) {
            $this->db->where('a.lot_no', $lot_no);
        }

        if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }
        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
        if ($this->session->userdata('user_desig_code') == 'CO') {
            if (LOT_BIFURCATE == 1 && empty($mouza_pargona_code) && empty($lot_no)) {
                if (isset($lot_string) && $lot_string != null) {
                    $this->db->where("CONCAT(a.mouza_pargona_code, '_', a.lot_no) in ($lot_string)");
                }
            }
        }
        $this->db->where('status', 'N');
        $this->db->where('chitha_processing_details', 2);
        $this->db->where('a.pending_officer', 'CO');
        $this->db->where('a.from_office', 'CO');
        $this->db->from('settlement_basic a');
        $this->db->select('distinct(a.case_no), a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry');

        $this->db->join('(SELECT DISTINCT(case_no) FROM settlement_premium WHERE is_final = 1 AND grn_no IS NOT NULL AND due_amount > paid_amount) AS sp', 'sp.case_no = a.case_no');
        $this->db->join('(SELECT
                                sh.case_no,
                                sh.is_full_paid
                            FROM
                                settlement_emi_history sh
                            JOIN
                                (
                                    SELECT
                                        case_no,
                                        MAX(id) AS max_id
                                    FROM
                                        settlement_emi_history
                                    WHERE 
                                        chitha_update_status < 5
                                    GROUP BY
                                        case_no
                                    HAVING
                                        COUNT(*) > 1
                                ) max_ids
                            ON
                                sh.case_no = max_ids.case_no
                            AND
                                sh.id = max_ids.max_id) AS emh', 'emh.case_no = a.case_no');

        $this->db->where('a.order_passed IS NOT NULL');
        $this->db->where('emh.is_full_paid = 1');
        $this->db->where('a.co_chitha_corrected_yn IS NOT NULL');
        $this->db->where("DATE_PART('day', now()::timestamp- a.ppp_issue_date::timestamp) > 15");
        if (!empty($p_type)) {
            if ($p_type == 'f') {
                $this->db->where('emh.is_full_paid', 1);
            }
            if ($p_type == 'p') {
                // $this->db->where('emh.is_full_paid', 0);
                $this->db->where('emh.is_full_paid', 1);
            }
        }
        $landcc = '';
        if (!empty($l_mis)) {
            if ($l_mis == 'l_miss') {
                // $this->db->join('settlement_dag_details sd', 'sd.case_no = a.case_no');
                $this->db->where('EXISTS (SELECT 1 FROM settlement_dag_details sd WHERE sd.case_no = a.case_no AND ((sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = \'\' OR sd.new_land_class_agri = \'\')))', null, false);

                $landcc = 'Landclass missing';
            }
            if ($l_mis == 'l_not_mis') {
                $this->db->where('NOT EXISTS (SELECT 1 FROM settlement_dag_details sd WHERE sd.case_no = a.case_no AND ((sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = \'\' OR sd.new_land_class_agri = \'\')))', null, false);

                $landcc = 'Landclass not missing';

            }
        }
        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $tenant_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>';
                $tribal_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>';
                $ap_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>';
                $khas_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>';
                $vgr_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>';
                $tea_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>';
                //*****getting the payment made type */
                $getPType = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ?', array($rows->case_no, 1))->row();

                if ($getPType->paid_amount < $getPType->due_amount) {
                    $pTypeText = 'Partial Payment';
                } else if ($getPType->paid_amount >= $getPType->due_amount) {
                    $pTypeText = 'Full Payment';
                } else {
                    $pTypeText = '';
                }
                $json[] = array(
                    $rows->case_no,
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',
                    $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),
                    $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),
                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),
                    date("Y-m-d", strtotime($rows->date_entry)),
                    $pTypeText,
                    $landcc,
                    (($s_code == SETTLEMENT_TENANT_ID) ? $tenant_link : (($s_code == SETTLEMENT_AP_TRANSFER_ID) ? $ap_link : (($s_code == SETTLEMENT_TRIBAL_COMMUNITY_ID) ? $tribal_link : (($s_code == SETTLEMENT_KHAS_LAND_ID) ? $khas_link : (($s_code == SETTLEMENT_PGR_VGR_LAND_ID) ? $vgr_link : (($s_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID) ? $tea_link : '')))))),
                );

            }
            if ($this->session->userdata('user_desig_code') == 'CO') {
                if (LOT_BIFURCATE == 1 && empty($mouza_pargona_code) && empty($lot_no)) {
                    if (isset($lot_string) && $lot_string != null) {
                        $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                    }
                }
            }
            if (!empty($mouza_pargona_code)) {
                $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
            }
            if (!empty($mouza_pargona_code) && !empty($lot_no)) {
                $this->db->where('a.lot_no', $lot_no);
            }
            if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
                $this->db->where('a.vill_townprt_code', $is_cat);
            }
            $this->db->where('a.service_code', $s_code);
            $this->db->where('a.pending_officer', MB_CIRCLE_OFFICER);
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
            $this->db->where('a.notice_generated_yn', null);
            $this->db->where('status', 'N');
            $this->db->where('chitha_processing_details', 2);
            $this->db->where('a.pending_officer', 'CO');
            $this->db->where('a.from_office', 'CO');
            $this->db->select('distinct(a.case_no), a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry');
            $this->db->join('(SELECT DISTINCT(case_no) FROM settlement_premium WHERE is_final = 1 AND grn_no IS NOT NULL AND due_amount > paid_amount) AS sp', 'sp.case_no = a.case_no');
            $this->db->join('(SELECT
                                    sh.case_no,
                                    sh.is_full_paid
                                FROM
                                    settlement_emi_history sh
                                JOIN
                                    (
                                        SELECT
                                            case_no,
                                            MAX(id) AS max_id
                                        FROM
                                            settlement_emi_history
                                        WHERE 
                                            chitha_update_status < 5
                                        GROUP BY
                                            case_no
                                        HAVING
                                            COUNT(*) > 1
                                    ) max_ids
                                ON
                                    sh.case_no = max_ids.case_no
                                AND
                                    sh.id = max_ids.max_id) AS emh', 'emh.case_no = a.case_no');

            $this->db->where('a.order_passed IS NOT NULL');
            $this->db->where('emh.is_full_paid = 1');
            $this->db->where('a.co_chitha_corrected_yn IS NOT NULL');
            $this->db->where("DATE_PART('day', now()::timestamp- a.ppp_issue_date::timestamp) > 15");
            if (!empty($l_mis)) {
                if ($l_mis == 'l_miss') {
                    $this->db->where('EXISTS (SELECT 1 FROM settlement_dag_details sd WHERE sd.case_no = a.case_no AND ((sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = \'\' OR sd.new_land_class_agri = \'\')))', null, false);
                }
                if ($l_mis == 'l_not_mis') {
                    $this->db->where('NOT EXISTS (SELECT 1 FROM settlement_dag_details sd WHERE sd.case_no = a.case_no AND ((sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = \'\' OR sd.new_land_class_agri = \'\')))', null, false);
                }
            }
            if (!empty($p_type)) {
                if ($p_type == 'f') {
                    $this->db->where('emh.is_full_paid', 1);
                }
                if ($p_type == 'p') {
                    $this->db->where('emh.is_full_paid', 0);
                }
            }
            $this->db->from('settlement_basic a');
            $qu = $this->db->get();
            $total_records = $qu->num_rows();

            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json,
            );
            echo json_encode($response);

        } else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }
    public function bulkChithaUpdatePartial()
    {
        log_message('error', '#BULKCHITHA======');
        $final = $passedcases = array();
        if (empty($_POST['selectMark'])) {
            echo json_encode(array('responseType' => 2, 'msg' => 'Please Select Case No'));
            return;
        }
        $this->load->model('ChithaUpdateModel');
        $dist_code = $this->session->userdata('dist_code');
        foreach ($_POST['selectMark'] as $key => $value) {
            $case_no = $value;
            $replica_db = $this->DataBaseSwitchModel->dharReplDbSwitch($dist_code);

            $chithaDetailsMod = $this->SettlementCommonModel->getChithaUpdateDetailsPartial($case_no, $replica_db);
            if (isset($chithaDetailsMod['responseType'])) {
                if ($chithaDetailsMod['responseType'] != 2) {
                    echo json_encode($chithaDetailsMod);
                    return false;
                }
            }
            $this->db->trans_begin();
            log_message('error', '#BULKCHITHA===' . json_encode($chithaDetailsMod));
            // update partial payment with case update chitha and order in case of payment fully not paid...
            $status = $this->ChithaUpdateModel->caseDetailsPartialPayment($case_no, $chithaDetailsMod);
            log_message('error', '#BULKCHITHA===' . json_encode($status));
            if ($status['responseType'] == 2) {
                // $this->db->trans_rollback();
                $this->db->trans_commit();
                $msg = "Transaction SUCCESS";
                $passedcases[] = array($case_no);
                // echo "Transaction SUCCESS";
            } else {
                $this->db->trans_rollback();
                $final[] = array($case_no);
                $msg = "Transaction FAILED";
            }
        }
        echo json_encode(array('responseType' => 2, 'msg' => 'Successfully order Passed', 'failed' => json_encode($final), 'passed' => json_encode($passedcases)));
        return;
    }

    public function paginationPartialPaymentList()
    {
        if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
            $lot_string = $this->caseListUnderMappingLot();
        }

        $s_code = $this->input->post('service');
        $search_term = $this->input->post('search_term');
        $remark_cat = $this->input->post('remark_cat');
        $reverted = $this->input->post('reverted');
        $user_code = $this->session->userdata('user_code');
        // $payment_status = $this->input->post('payment_status');

        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        // $nr_cat = $this->input->post('nr_cat');

        // $status = $this->input->post('status');
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        // $p_type = $this->input->post('p_type');

        $col = 0;
        $dir = "";
        $search = $this->input->post('search');
        $search = $search['value'];

        $searchByCol_0 = $this->input->post('columns')[1]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[2]['search']['value'];
        $searchByCol_3 = $this->input->post('columns')[4]['search']['value'];

        $is_cat = $this->input->post('is_category');

        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'asc';
        }

        // $valid_columns = array(
        //     0 => 'a.date_entry',
        // );

        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        if ($order != null) {
            $this->db->order_by($order, $dir);
        }

        if (!empty($searchByCol_0)) {

            $this->db->like('a.case_no', strtoupper($searchByCol_0));
        }

        if (!empty($searchByCol_1)) {

            $this->db->like('a.applid', strtoupper($searchByCol_1));
        }

        if (!empty($searchByCol_3)) {
            $this->db->like('TO_CHAR(a.date_entry,\'yyyy-mm-dd\')', $searchByCol_3);
            //$this->db->like('date_entry', $searchByCol_2);
        }

        $this->db->limit($length, $start);

        $this->db->where('a.service_code', $s_code);

        if (!empty($remark_cat)) { //settlement_ap_lmnote, lm_note
            $this->db->where('b.lm_note', $remark_cat);
        }

        if (!empty($mouza_pargona_code)) {
            $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
        }

        if (!empty($mouza_pargona_code) && !empty($lot_no)) {
            $this->db->where('a.lot_no', $lot_no);
        }

        if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }

        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

        if ($this->session->userdata('user_desig_code') == 'CO') {
            if (LOT_BIFURCATE == 1 && empty($mouza_pargona_code) && empty($lot_no)) {

                if (isset($lot_string) && $lot_string != null) {
                    $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                }
            }
        }

        $this->db->select('distinct(a.case_no), a.applid, a.date_entry, seh.is_full_paid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code');
        $this->db->from('settlement_premium sp');
        $this->db->join('(SELECT * FROM settlement_emi_history ORDER BY id DESC limit 1) seh', 'sp.case_no = seh.case_no', 'left');
        $this->db->join('settlement_basic a', 'sp.case_no = a.case_no');
        $this->db->where('sp.is_final', 1);
        $this->db->where('sp.grn_no is not null');
        $this->db->where('sp.due_amount > sp.paid_amount');
        $this->db->where('a.pending_officer', 'CO');
        $this->db->where('a.from_office', 'CO');
        $this->db->where('a.status', 'N');
        $this->db->where('(seh.case_no IS NULL OR seh.is_full_paid != 1)');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {

                $tribal_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>';

                $ap_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>';

                $khas_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>

                <a alt="View application" class="mt-2 text-white btn btn-sm btn-danger" href="' . base_url() . 'index.php/SettlementMbCo/updateInstallPaymentView?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Update Payment Status</a>';

                $vgr_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>';

                $tea_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>';

                $json[] = array(
                    // $rows->case_no,
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                    $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                    $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    date("Y-m-d", strtotime($rows->date_entry)),

                    (($s_code == SETTLEMENT_AP_TRANSFER_ID) ? $ap_link : (($s_code == SETTLEMENT_TRIBAL_COMMUNITY_ID) ? $tribal_link : (($s_code == SETTLEMENT_KHAS_LAND_ID) ? $khas_link : (($s_code == SETTLEMENT_PGR_VGR_LAND_ID) ? $vgr_link : (($s_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID) ? $tea_link : ''))))),
                );
            }

            if ($this->session->userdata('user_desig_code') == 'CO') {
                // $this->db->where('a.co_code', $user_code);
                // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
                if (LOT_BIFURCATE == 1 && empty($mouza_pargona_code) && empty($lot_no)) {

                    if (isset($lot_string) && $lot_string != null) {
                        $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                    }
                }
            }

            if (!empty($mouza_pargona_code)) {
                $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
            }

            if (!empty($mouza_pargona_code) && !empty($lot_no)) {
                $this->db->where('a.lot_no', $lot_no);
            }

            if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
                $this->db->where('a.vill_townprt_code', $is_cat);
            }

            $this->db->where('a.service_code', $s_code);
            $this->db->where('a.pending_officer', MB_CIRCLE_OFFICER);
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

            $this->db->select('distinct(a.case_no), a.applid, a.date_entry, seh.is_full_paid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code');
            $this->db->from('settlement_premium sp');
            $this->db->join('(SELECT * FROM settlement_emi_history ORDER BY id DESC limit 1) seh', 'sp.case_no = seh.case_no', 'left');
            $this->db->join('settlement_basic a', 'sp.case_no = a.case_no');
            $this->db->where('sp.is_final', 1);
            $this->db->where('sp.grn_no is not null');
            $this->db->where('sp.due_amount > sp.paid_amount');
            $this->db->where('a.pending_officer', 'CO');
            $this->db->where('a.from_office', 'CO');
            $this->db->where('a.status', 'N');
            $this->db->where('(seh.case_no IS NULL OR seh.is_full_paid != 1)');

            $query = $this->db->get();
            $total_records = $query->num_rows();

            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json,
            );

            echo json_encode($response);

        } else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }

    public function updateInstallPaymentView()
    {
        $case_no = $this->input->get('case');

        $emi_his = false;

        $sqlEMI = $this->db->query('select * from settlement_emi_history where case_no = ? and grn_no is not null order by id asc', array($case_no));

        if ($sqlEMI->num_rows() <= 0) {
            $sqlSPrem = $this->db->query('select * from settlement_premium sp join settlement_basic sb on sp.case_no = sb.case_no where sb.case_no = ? and sp.is_final = ? and sp.grn_no is not null and sb.status = ?', array($case_no, 1, 'N'));

            $premRow = $sqlSPrem->row();
            $emi_his = false;
        } else {
            $emiResult = $sqlEMI->result();
            $emi_his = true;
        }

        $installmentArray = false;

        if ($emi_his == true) {
            foreach ($emiResult as $emRow) {
                $installmentArray[] = [
                    'case_no' => $case_no,
                    'case_no_rtps' => $emRow->application_no,
                    'payment_date' => $emRow->payment_date,
                    'total_premium' => $emRow->final_amount,
                    'paid_amount' => $emRow->paid_amount,
                    'remaining_amount' => $emRow->remaining_amount,
                    'grn_no' => $emRow->grn_no,
                ];
            }
        } else {
            $installmentArray[] = [
                'case_no' => $case_no,
                'case_no_rtps' => $this->utilityclass->getApplidFromCaseNo($premRow->case_no),
                'payment_date' => $premRow->payment_date,
                'total_premium' => $premRow->final_amount,
                'paid_amount' => $premRow->paid_amount,
                'remaining_amount' => $premRow->remaining_amount,
                'grn_no' => $premRow->grn_no,
            ];
        }

        $data['case_no'] = $case_no;
        $data['installmentArray'] = $installmentArray;

        $data['_view'] = 'settlement_mb/update_installment_payment';
        $this->load->view('layouts/main', $data);
    }

    public function updateChallenManualPayment()
    {
        //***********************************************************************/
        // file validation
        if (isset($_FILES['manual_chalan']['name'])) {
            if ($_FILES['manual_chalan']['name'] && $_FILES['manual_chalan']['size'] && $_FILES['manual_chalan']['tmp_name']) {
                $name = $_FILES['manual_chalan']['name'];
                $size = $_FILES['manual_chalan']['size'];
                $mime = mime_content_type($_FILES['manual_chalan']['tmp_name']);
                $exp = explode("/", $mime);
                $ext = $exp[1];
                if ($name != null) {
                    if ($ext == null) {
                        echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Invalid Challan, Please Upload Correctly, ERR-#SMCPF001']);
                        exit;

                    }
                    if ($ext != 'pdf') {
                        echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Invalid Challan, Please Upload Pdf Only, ERR-#SMCPF002']);
                        exit;
                    }
                    if ($size > UPLOAD_MAX_SIZE) {
                        echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Invalid Challan, Please Upload Challan Less Than 5mb, ERR-#SMCPF003']);
                        exit;
                    }
                } else {
                    echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Please Upload The Challan, ERR-#SMCPF004']);
                    exit;
                }
            } else {
                echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Please Upload The Challan, ERR-#SMCPF005']);
                exit;
            }
        } else {
            echo json_encode(['result' => 'FILE-VALIDATION-ERROR', 'msg' => 'Please Upload The Challan, ERR-#SMCPF006']);
            exit;
        }
        //***********************************************************************/
        // post field validation
        $error_msg = array();
        $manual_challan_validation_arr = [
            [
                'field' => 'grn_no',
                'label' => 'GRN-NO',
                'rules' => 'required|callback_check_script|trim|xss_clean|max_length[45]',
            ],
            [
                'field' => 'amount',
                'label' => 'Amount',
                'rules' => 'required|callback_check_script|trim|xss_clean|numeric',
            ],
            [
                'field' => 'payment_date',
                'label' => 'Payment-Date',
                'rules' => 'required|callback_check_script|trim|xss_clean|callback_date_valid',
            ],
            [
                'field' => 'case_no',
                'label' => 'Case-No',
                'rules' => 'required|callback_check_script|trim|xss_clean',
            ],

        ];
        $this->form_validation->set_rules($manual_challan_validation_arr);
        $this->form_validation->set_message('check_script', 'Please Fill The %s Correctly!');
        $this->form_validation->set_message('date_valid', 'Please Fill The %s Correctly!');
        if ($this->form_validation->run() == false) {
            foreach ($manual_challan_validation_arr as $rule) {
                if (form_error($rule['field'])) {
                    array_push($error_msg, form_error($rule['field']));
                }
            }
        }
        if (count($error_msg) != 0) {
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => $error_msg]);
            exit;
        }
        //***********************************************************************/
        $sql = "select applid from settlement_basic sb where case_no=?";
        $query = $this->db->query($sql, array($_POST['case_no']));
        if ($query->num_rows() != 1) {
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => 'Some error occured, Error-Code : #smcu0045']);
            exit;
        }

        $sql_getRem = $this->db->query('select * from settlement_emi_history where case_no = ? and grn_no is not null order by id desc limit 1', array($_POST['case_no']));

        if ($sql_getRem->num_rows() <= 0) {
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => 'Some error occured, Error-Code : #smcu00455']);
            exit;
        }

        $insPremRow = $sql_getRem->row();
        // $remaining_amount = $insPremRow->remaining_amount;

        if ($_POST['amount'] < $insPremRow->installment_amount) {
            echo json_encode(['result' => 'VALIDATION-ERROR', 'msg' => 'Amount should not be less than minimum installment amount, Error-Code : #smcu004556']);
            exit;
        }

        $paid_amount = $_POST['amount'] + $insPremRow->paid_amount;

        $remaining_amount = 0;

        $is_fully_paid = 0;
        if ($paid_amount >= $insPremRow->final_amount) {
            $is_fully_paid = 1;
        } else {
            $remaining_amount = $insPremRow->final_amount - $paid_amount;
        }

        //***************************************************************** */
        //file moving section
        $file_new_name = "echallan" . $_POST['grn_no'];
        $manual_challan_upload_dir = UPLOAD_MANUAL_CHALAN_DIR . $file_new_name;
        $file_full_path = UPLOAD_MANUAL_CHALAN_DIR . $file_new_name . ".pdf";
        move_uploaded_file($_FILES['manual_chalan']['tmp_name'], $file_full_path);
        if (!file_exists($file_full_path)) {
            log_message("error", "#smcuuf001, Error in moving file for the case_no " . $_POST['case_no']);
            echo json_encode(['result' => 'FAILED', 'msg' => 'Some error occured, Error-Code : #smcuuf001']);
            exit;
        }
        //******************************************************************/
        $this->db->trans_begin();

        $sp_update_data = [
            'case_no' => $_POST['case_no'],
            'application_no' => $this->utilityclass->getApplidFromCaseNo($_POST['case_no']),
            'final_amount' => $insPremRow->final_amount,
            'paid_amount' => $paid_amount,
            'remaining_amount' => $remaining_amount,
            'tenure' => 5,
            'installment_amount' => $insPremRow->installment_amount,
            'payment_date' => $_POST['payment_date'],
            'grn_no' => $_POST['grn_no'],
            'challen_link' => $manual_challan_upload_dir,
            'old_dag_no' => $insPremRow->old_dag_no,
            'settlement_dag_no' => $insPremRow->settlement_dag_no,
            'ekhajana_application_no' => $insPremRow->ekhajana_application_no,
            'is_full_paid' => $is_fully_paid,
            'date_entry' => date('Y-m-d G:i:s'),
        ];

        $ins = $this->db->insert('settlement_emi_history', $sp_update_data);

        if ($ins != 1) {
            //if no updation made
            $this->db->trans_rollback();
            log_message("error", "#smcu001, Error in update, table 'settlement_premium' with query :" . $this->db->last_query());
            echo json_encode(['result' => 'FAILED', 'msg' => 'Some error occured, Error-Code : #smcu001']);
            exit;
        }

        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            log_message("error", "#smcu002, Transaction Status Error In manual challan update, settlement_premium tables for case_no " . $_POST['case_no']);
            echo json_encode(['result' => 'FAILED', 'msg' => 'Some error occured, Error-Code : #smcu002']);
            exit;
        } else {
            $this->db->trans_commit();
            echo json_encode(['result' => 'SUCCESS', 'msg' => 'Challan Details Updated Successfully..!']);
            exit;
        }
    }

    public function premiumNoticeRegenList()
    {
        $service_code = $this->input->get('service');
        $status = $this->input->get('s');
        // $data['getPaymentConfirmationCo'] = $this->SettlementMbModel->getLmVerificationCases($service_code);
        $data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);

        $data['_view'] = 'settlement_mb/premium_notice_regenerate';
        $this->load->view('layouts/main', $data);
    }

    public function paginationPremiumNoticeRegenerateList()
    {

        if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
            $lot_string = $this->caseListUnderMappingLot();
        }

        $s_code = $this->input->post('service');
        $search_term = $this->input->post('search_term');
        $remark_cat = $this->input->post('remark_cat');
        $reverted = $this->input->post('reverted');
        $user_code = $this->session->userdata('user_code');

        $status = $this->input->post('status');
        $service_code = $this->input->post('service');
        // $payment_status = $this->input->post('payment_status');

        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        // $nr_cat = $this->input->post('nr_cat');

        // $status = $this->input->post('status');
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        // $p_type = $this->input->post('p_type');

        $col = 0;
        $dir = "";
        $search = $this->input->post('search');
        $search = $search['value'];

        $searchByCol_0 = $this->input->post('columns')[1]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[2]['search']['value'];
        $searchByCol_3 = $this->input->post('columns')[4]['search']['value'];

        $is_cat = $this->input->post('is_category');

        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'asc';
        }

        // $valid_columns = array(
        //     0 => 'a.date_entry',
        // );

        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }

        if ($order != null) {
            $this->db->order_by($order, $dir);
        }

        if (!empty($searchByCol_0)) {

            $this->db->like('a.case_no', strtoupper($searchByCol_0));
        }

        if (!empty($searchByCol_1)) {

            $this->db->like('a.applid', strtoupper($searchByCol_1));
        }

        if (!empty($searchByCol_3)) {
            $this->db->like('TO_CHAR(a.date_entry,\'yyyy-mm-dd\')', $searchByCol_3);
            //$this->db->like('date_entry', $searchByCol_2);
        }

        if (!empty($remark_cat)) { //settlement_ap_lmnote, lm_note
            $this->db->where('b.lm_note', $remark_cat);
        }

        if (!empty($mouza_pargona_code)) {
            $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
        }

        if (!empty($mouza_pargona_code) && !empty($lot_no)) {
            $this->db->where('a.lot_no', $lot_no);
        }

        if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }

        if ($this->session->userdata('user_desig_code') == 'CO') {
            if (LOT_BIFURCATE == 1 && empty($mouza_pargona_code) && empty($lot_no)) {

                if (isset($lot_string) && $lot_string != null) {
                    $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                }
            }
        }

        $this->db->select('distinct(a.case_no), a.applid, a.date_entry, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code');
        $this->db->from('settlement_basic a');
        $this->db->join('settlement_premium sp', 'a.case_no = sp.case_no');
        $this->db->join('settlement_notice sn', 'a.case_no = sn.case_no');
        $this->db->where('sn.notice_type', 'PN');
        $this->db->where('a.status', $status);
        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
        $this->db->where('a.from_office', 'CO');
        $this->db->where('a.pending_officer', 'CO');
        $this->db->where('a.service_code', $service_code);
        $this->db->where('sp.is_final', 1);
        $this->db->where('sp.grn_no IS NULL');
        $this->db->limit($length, $start);
        $this->db->where('a.service_code', $s_code);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {

                $tribal_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>';

                $ap_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>';

                $khas_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>

                <a alt="View application" class="mt-2 text-white btn btn-sm btn-danger" href="' . base_url() . 'index.php/SettlementCommon/verifyLandClassZone?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Re-Generate Premium Notice</a>';

                $vgr_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>';

                $tea_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>';

                $json[] = array(
                    // $rows->case_no,
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                    $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                    $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    date("Y-m-d", strtotime($rows->date_entry)),

                    (($s_code == SETTLEMENT_AP_TRANSFER_ID) ? $ap_link : (($s_code == SETTLEMENT_TRIBAL_COMMUNITY_ID) ? $tribal_link : (($s_code == SETTLEMENT_KHAS_LAND_ID) ? $khas_link : (($s_code == SETTLEMENT_PGR_VGR_LAND_ID) ? $vgr_link : (($s_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID) ? $tea_link : ''))))),
                );
            }

            if ($this->session->userdata('user_desig_code') == 'CO') {
                // $this->db->where('a.co_code', $user_code);
                // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
                if (LOT_BIFURCATE == 1 && empty($mouza_pargona_code) && empty($lot_no)) {

                    if (isset($lot_string) && $lot_string != null) {
                        $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                    }
                }
            }

            if (!empty($mouza_pargona_code)) {
                $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
            }

            if (!empty($mouza_pargona_code) && !empty($lot_no)) {
                $this->db->where('a.lot_no', $lot_no);
            }

            if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
                $this->db->where('a.vill_townprt_code', $is_cat);
            }

            $this->db->select('distinct(a.case_no), a.applid, a.date_entry, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code');
            $this->db->from('settlement_basic a');
            $this->db->join('settlement_premium sp', 'a.case_no = sp.case_no');
            $this->db->join('settlement_notice sn', 'a.case_no = sn.case_no');
            $this->db->where('sn.notice_type', 'PN');
            $this->db->where('a.status', $status);
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
            $this->db->where('a.from_office', 'CO');
            $this->db->where('a.pending_officer', 'CO');
            $this->db->where('a.service_code', $service_code);
            $this->db->where('sp.is_final', 1);
            $this->db->where('sp.grn_no IS NULL');
            $this->db->limit($length, $start);
            $this->db->where('a.service_code', $s_code);

            $query = $this->db->get();
            $total_records = $query->num_rows();

            $response = array(
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records,
                'data' => $json,
            );

            echo json_encode($response);

        } else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }

    public function choosePattaType()
    {
        $case_no = $this->input->post('case_no');

        $patta_details = $this->db->query("SELECT type_code, patta_type FROM patta_code where (settlement = ? OR spcl_cultivation = ?)", array('y', 'y'));

        if ($patta_details->num_rows() <= 0) {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR1202224355: No patta details found!',
            ]);
            return false;
        }

        echo json_encode([
            'responseType' => 2,
            'case_no' => $case_no,
            'data' => $patta_details->result(),
        ]);
    }

    public function updatePattaType()
    {
        $case_no = $this->input->post('case_no');
        $new_patta_type = $this->input->post('patta_type_code_new');

        $dags = $this->SettlementKhasModel->getSettlementDag($case_no);

        $this->db->trans_begin();

        $updateArr = [
            'new_patta_type' => $new_patta_type,
        ];

        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_dag_details', $updateArr);

        if ($this->db->affected_rows() != count($dags)) {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR33241414: Unable to update patta type',
            ]);
            return false;
        }

        $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        if ($proceeding_id == null) {
            $proceeding_id = 1;
        }
        $insertArr = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'note_on_order' => 'CO updated patta type',
            'status' => 'N',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d h:i:s'),
            'operation' => 'E',
            'ip' => $this->utilityclass->get_client_ip(),
            'office_from' => 'CO',
            'office_to' => 'CO',
            'task' => 'CO updated patta type',
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if ($insertProc != 1) {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR332413414: Unable to update patta type',
            ]);
            return false;
        }

        $this->db->trans_commit();
        echo json_encode([
            'responseType' => 2,
            'msg' => 'Successfully updated patta type...',
        ]);
    }

    public function updateLandClass()
    {
        $case_no = $this->input->post('case_no_det');

        $basicRow = $this->db->query('select * from settlement_basic where case_no = ?', array($case_no))->row();

        $getDagsSql = $this->db->query('select * from settlement_dag_details where case_no = ? and ((home_b + home_k + home_lc + home_g) > 0 AND (agri_b + agri_k + agri_lc + agri_g) > 0 AND (new_land_class_home = \'\' OR new_land_class_agri = \'\'))', array($case_no));

        if ($getDagsSql->num_rows() <= 0) {
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERRJS100951: Unable to update landclass',
            ]);
            return false;
        }

        $dagRes = $getDagsSql->result();

        $this->db->trans_begin();

        foreach ($dagRes as $dagRow) {

            if ($basicRow->service_code == '14') {
                $dagRow->dag_no = $dagRow->new_dag_no;
            }

            $land_class_code_homestead = $this->input->post('land_class_code_homestead' . $dagRow->dag_no);
            $revenue_home = $this->input->post('revenue_home' . $dagRow->dag_no);
            $local_tax_home = $this->input->post('local_tax_home' . $dagRow->dag_no);

            $land_class_code_agriculture = $this->input->post('land_class_code_agriculture' . $dagRow->dag_no);
            $revenue_agri = $this->input->post('revenue_agri' . $dagRow->dag_no);
            $local_tax_agri = $this->input->post('local_tax_agri' . $dagRow->dag_no);

            if (empty($land_class_code_homestead) || empty($land_class_code_agriculture)) {
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERRJS400951: Please select both landclass!',
                ]);
                return false;
            }

            if (empty($revenue_home) || empty($local_tax_home) || empty($revenue_agri) || empty($local_tax_agri)) {
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERRJS500951: Revenue or local tax cannot be empty!',
                ]);
                return false;
            }

            $updateArr = [
                'new_land_class_home' => $land_class_code_homestead,
                'new_land_class_agri' => $land_class_code_agriculture,
                'new_home_land_revenue' => $revenue_home,
                'new_agri_land_revenue' => $revenue_agri,
                'new_home_land_local_tax' => $local_tax_home,
                'new_agri_land_local_tax' => $local_tax_agri,
                'new_total_revenue' => $revenue_home + $revenue_agri,
                'new_total_tax' => $local_tax_home + $local_tax_agri,
            ];

            $this->db->where('case_no', $case_no);

            if ($basicRow->service_code == '14') {
                $this->db->where('new_dag_no', $dagRow->dag_no);
            } else {
                $this->db->where('dag_no', $dagRow->dag_no);
            }
            $this->db->update('settlement_dag_details', $updateArr);
        }

        if ($this->db->affected_rows() != count($dagRes)) {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERRJS900951: Unable to update landclass',
            ]);
            return false;
        }

        $this->db->trans_commit();
        echo json_encode([
            'responseType' => 2,
            'msg' => 'Successfully updated landclass...',
        ]);
    }

    public function grnUpdateList(){

        $service_code = $_GET['service'];

        $case_no = 'MET/GUW/2023-24/37630/SKHAS';

        $sql = $this->db->query('select sb.case_no , sb.applid from settlement_basic sb join (select distinct(case_no) from settlement_premium where is_final = ? and is_manual_challan is not null) sp on sb.case_no = sp.case_no and sb.service_code = ? and sb.case_no = ?', array('1', $service_code, $case_no));

        $data['cases_list'] = $sql->result();

        $data['_view'] = 'settlement_mb/update_grn';
        $this->load->view('layouts/main', $data);
    }

    public function updateGRN() {
        $case_no = $this->input->post('case_no');
        $grn_no = $this->input->post('grn_no');
        $payment_date = $this->input->post('payment_date');
        $amount = $this->input->post('amount');
        $file = $this->input->post('challen');

        $validation_array = array(
            array(
                'field' => 'case_no',
                'label' => 'Case No',
                'rules' => 'required', 
            ),
            array(
                'field' => 'grn_no',
                'label' => 'Grn No',
                'rules' => 'required', 
            ),
            array(
                'field' => 'payment_date',
                'label' => 'Payment date',
                'rules' => 'required|callback_date_validation', 
            ),
            array(
                'field' => 'amount',
                'label' => 'Amount',
                'rules' => 'required!callback_amount_validation', 
            ),
            array(
                'field' => 'challen',
                'label' => 'Challen Copy',
                'rules' => 'callback_files_check', 
            ),                
        );

        $this->form_validation->set_rules($validation_array);
        if ($this->form_validation->run() === FALSE) {
            $this->form_validation->set_error_delimiters('', '');
            foreach ($validation_array as $rule) {
                if (form_error($rule['field'])) {
                    echo json_encode([
                        'responseType' => 0,
                        'msg' => form_error($rule['field'])
                    ]);
                    return false;
                }
            }
            return;
        }

        // Process form data
        $sql = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ?', array($case_no , 1));
        if($sql->num_rows() <= 0 ){
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR012542: Premium data not found!'
            ]);
            return false;
        }

        $due_amount = $sql->row()->due_amount;
        $dag_count = count($sql->result());

        $premium_row = $sql->row();

        $old_grn_no = $premium_row->grn_no;
        $old_paid_amount = $premium_row->paid_amount;
        $old_remaining_amount = $premium_row->remaining_amount;
        $old_payment_date = $premium_row->payment_date;
        $old_manual_challan_upload_dir = $premium_row->manual_challan_upload_dir;

        $challan_details = [
            'grn_no' => $grn_no,
            'amount' => $amount,
            'payment_date' => $payment_date,
            'case_no' => $case_no
        ];

        $remaining_amount =  $due_amount - $amount;


        $_FILES['file']['name'] = $_FILES['challen']['name'];
        $_FILES['file']['type'] = $_FILES['challen']['type'];
        $_FILES['file']['tmp_name'] = $_FILES['challen']['tmp_name'];
        $_FILES['file']['error'] = $_FILES['challen']['error'];
        $_FILES['file']['size'] = $_FILES['challen']['size'];

        $mime = mime_content_type($_FILES['challen']['tmp_name']);
        $exp  = explode("/",$mime);
        $onlyExtension  = $exp[1];

        $fileRename =  $this->UUID4() . '.' . $onlyExtension;

        $config['upload_path']   = UPLOAD_BASE.'challan'.UPLOAD_SEPARATOR;
        $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
        $config['max_size']  = UPLOAD_MAX_SIZE;
        $config['file_name'] = $fileRename;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        $this->db->trans_begin();

        if ($this->upload->do_upload('challen'))
        {
            $update_arr = [
                'paid_amount' => $amount,
                'remaining_amount' =>  $remaining_amount,
                'installment_amount' => $remaining_amount/5,
                'payment_date' => $payment_date,
                'grn_no' => $grn_no,
                'manual_challan_upload_dir' => $config['upload_path'] . $fileRename,
                'manual_challan_details' => json_encode($challan_details)
            ];

            // save data in attachment file
            $this->db->where('case_no', $case_no);
            $this->db->where('is_final', 1);
            $this->db->update('settlement_premium', $update_arr);

            if($this->db->affected_rows() != $dag_count)
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR06939: Unable to update grn!'
                ]);
                return false;
            }

            //udpate in settlement_emi_history
            $emi_array = [
                'paid_amount' => $amount,
                'remaining_amount' => $remaining_amount,
                'installment_amount' => $remaining_amount/5,
                'payment_date' => $payment_date,
                'grn_no' => $grn_no,
                'challen_link' => $config['upload_path'] . $fileRename,
            ];

            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_emi_history', $emi_array);

            if($this->db->affected_rows() != 1){
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR4459: Unable to update grn!'
                ]);
                return false;
            }

        }
        else
        {
            log_message('error', '#ERR69870011: '. $this->upload->display_errors());
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR06948: Unable to update grn!'
            ]);
            return false;
        }

        $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

        if ($proceeding_id==null) {
            $proceeding_id=1;
        }
 
        $insPetProceed = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => date('Y-m-d H:i:s'),
            'next_date_of_hearing' => date('Y-m-d H:i:s'),
            'note_on_order' => 'Old GRN No - ' .$old_grn_no. ', Payment Date -'.$old_payment_date.', Paid Amount - '.$old_paid_amount .', Remaining Amount - '. $old_remaining_amount. ' updated to GRN No - '.$grn_no. ', Payment Date -'.$payment_date.', Paid Amount - '.$amount. ', Remaining Amount - '.$remaining_amount,
            'status' => 'N',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d H:i:s'),
            'operation' => 'E',
            'ip' => $this->utilityclass->get_client_ip(),
            'office_from' => 'CO',
            'office_to' => 'CO',
            'task' => 'GRN/Challan updated',
            'old_file_link' => $old_manual_challan_upload_dir
        ];
        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
        if ($insertProceeding != 1) {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR069858: Unable to update grn!'
            ]);
            return false;
        }

        //update in chitha_settlement_allottee 
        $chitha_settlement_array = [
            'payment_date' => $payment_date,
            'grn_no' => $grn_no,
            'paid_amount' =>$amount,
        ];

        $this->db->where('ord_no', $case_no);
        $this->db->update('chitha_settlement_allottee', $chitha_settlement_array);

        if($this->db->affected_rows() <= 0){
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR48941651651: Unable to update grn!'
            ]);
            return false;
        }

        //update in backlog_orders

        $sql_dag_details = $this->db->query('select * from settlement_dag_details where case_no = ?', array($case_no));
        if($sql_dag_details->num_rows() <= 0){
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR78941651651: Unable to update grn!'
            ]);
            return false;
        }
        $dag_result = $sql_dag_details->result();

        // for old dag
        foreach($dag_result as $dag_row){

            $old_backlog = [
                'dist_code' => $dag_row->dist_code, 
                'subdiv_code' => $dag_row->subdiv_code, 
                'cir_code' => $dag_row->cir_code, 
                'mouza_pargona_code' => $dag_row->mouza_pargona_code, 
                'lot_no' => $dag_row->lot_no, 
                'vill_townprt_code' => $dag_row->vill_townprt_code, 
                'patta_no' => $dag_row->patta_no,
                'patta_type_code' => $dag_row->patta_type_code,
                'dag_no' => $dag_row->dag_no,
                'dag_no_int' => $dag_row->dag_no . '00',
                'remark' => 'Old GRN No - ' .$old_grn_no. ', Payment Date -'.$old_payment_date.', Paid Amount - '.$old_paid_amount .', Remaining Amount - '. $old_remaining_amount. ' updated to New GRN No - '.$grn_no. ', Payment Date -'.$payment_date.', Paid Amount - '.$amount. ', Remaining Amount - '.$remaining_amount,
                'category' => 2,
                'date_entry' => date('Y-m-d'),
                'user_code' => $this->session->userdata('user_code'),
            ];

            $oldback_insert = $this->db->insert('backlog_orders', $old_backlog);

            if($oldback_insert != 1){
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR99941651651: Unable to update grn!'
                ]);
                return false;
            }
        }

        $allote_sql = $this->db->query('select dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, dag_no from chitha_settlement_allottee where ord_no = ? group by dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, dag_no', array($case_no));

        if($allote_sql->num_rows() <= 0){
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR19941651651: Unable to update grn!'
            ]);
            return false;
        }

        $allotee_result = $allote_sql->result();

        foreach($allotee_result as $allt_row){

            $chitha_basic_sql = $this->db->query('select * from chitha_basic where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and dag_no = ?', array($allt_row->dist_code, $allt_row->subdiv_code, $allt_row->cir_code, $allt_row->mouza_pargona_code, $allt_row->lot_no, $allt_row->vill_townprt_code, $allt_row->dag_no));

            if($chitha_basic_sql->num_rows() <= 0){
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR715441651651: Unable to update grn!'
                ]);
                return false;
            }

            $chitha_result = $chitha_basic_sql->result();

            foreach($chitha_result as $chitha_row){
                $new_backlog = [
                    'dist_code' => $chitha_row->dist_code, 
                    'subdiv_code' => $chitha_row->subdiv_code, 
                    'cir_code' => $chitha_row->cir_code, 
                    'mouza_pargona_code' => $chitha_row->mouza_pargona_code, 
                    'lot_no' => $chitha_row->lot_no, 
                    'vill_townprt_code' => $chitha_row->vill_townprt_code, 
                    'patta_no' => $chitha_row->patta_no,
                    'patta_type_code' => $chitha_row->patta_type_code,
                    'dag_no' => $chitha_row->dag_no,
                    'dag_no_int' => $chitha_row->dag_no . '00',
                    'remark' => 'Old GRN No - ' .$old_grn_no. ', Payment Date -'.$old_payment_date.', Paid Amount - '.$old_paid_amount .', Remaining Amount - '. $old_remaining_amount. ' updated to New GRN No - '.$grn_no. ', Payment Date -'.$payment_date.', Paid Amount - '.$amount. ', Remaining Amount - '.$remaining_amount,
                    'category' => 2,
                    'date_entry' => date('Y-m-d'),
                    'user_code' => $this->session->userdata('user_code'),
                ];
    
                $newback_insert = $this->db->insert('backlog_orders', $new_backlog);
    
                if($newback_insert != 1){
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 0,
                        'msg' => '#ERR5655941651651: Unable to update grn!'
                    ]);
                    return false;
                }
            }
        }


        $this->db->trans_commit();

        echo json_encode([
            'responseType' => 2,
            'msg' => 'Grn/Challan successfully updated...'
        ]);

    }

    private function UUID4()
    {
        $bytes = random_bytes(16);
        $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
        $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
    }

    public function date_validation($date) {

        $dateTime = DateTime::createFromFormat('Y-m-d', $date);
        $cutoffDate = DateTime::createFromFormat('Y-m-d', '2024-01-31');

        if ($dateTime === false) {
            $this->form_validation->set_message('date_validation', 'The payment date format is invalid.');
            return false;
        }

        if ($dateTime > $cutoffDate) {
            $this->form_validation->set_message('date_validation', 'The payment date cannot be greather than 31/01/2024.');
            return false;
        }
        
        return true;
    }

    
    public function files_check() {

        if (empty($_FILES['challen']['name'][0])) {
            $this->form_validation->set_message('files_check', 'The Supporting Document field is required.');
            return false;
        }

        // $fileCount = count($_FILES['challen']['name']);
        $allowed_types = ['jpg', 'jpeg', 'png', 'pdf'];
        $max_size = 2 * 1024 * 1024; // 2MB

        // for ($i = 0; $i < $fileCount; $i++) {
        $name = $_FILES['challen']['name'];
        $size = $_FILES['challen']['size'];
        $tmp_name = $_FILES['challen']['tmp_name'];

        if ($name && $size && $tmp_name) {
            $mime = mime_content_type($tmp_name);
            $ext = pathinfo($name, PATHINFO_EXTENSION);

            if (!in_array($ext, $allowed_types)) {
                $this->form_validation->set_message('files_check', 'Only JPG/PNG/PDF files are allowed.');
                return false;
            }

            if ($size > $max_size) {
                $this->form_validation->set_message('files_check', 'Each file must be less than 2MB.');
                return false;
            }
        } else {
            $this->form_validation->set_message('files_check', 'The Supporting Document field is required.');
            return false;
        }
        // }

        return true;
    }

    public function notPaidAlreadyGeneratedPN()
    {
        $status                     = $this->input->get('s');
        $service_code               = $this->input->get("service");
        $data['getPaymentNoticeCo'] = $this->SettlementMbModel->getPaymentNoticeCo($service_code);
        $data['select_data']        = $this->SettlementCommonModel->locationSelect($service_code, $status);
        $dist_code                  = $this->session->userdata('dist_code');
        $data['_view']              = 'settlement_mb/not_paid_urban_already_generated_pn';        
        $this->load->view('layouts/main', $data);
    }

    public function notPaidAlreadyGeneratedPNRural()
    {
        $status                     = $this->input->get('s');
        $service_code               = $this->input->get("service");
        $data['getPaymentNoticeCo'] = $this->SettlementMbModel->getPaymentNoticeCo($service_code);
        $data['select_data']        = $this->SettlementCommonModel->locationSelect($service_code, $status);
        $dist_code                  = $this->session->userdata('dist_code');
        $data['_view']              = 'settlement_mb/not_paid_urban_already_generated_pn_rural';        
        $this->load->view('layouts/main', $data);
    }

}

