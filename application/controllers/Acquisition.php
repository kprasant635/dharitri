<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Acquisition extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('form_validation');
        $this->load->model('SettlementModel/SettlementCommonModel');
        $this->load->model('SettlementAcqModel');
        $this->load->model('basundhara/SettlementApiModel');
        $this->load->model('ChithaUpdateModel');
        $this->load->library('AES');
    }

    // ==========================
    // POST /api/register_case
    // ==========================
    public function register_old() {
        $data = [
            "tea_estate_name" => "Dibrugarh Tea Garden",
            "dist_code" => "07",
            "subdiv_code" => "01",
            "cir_code" => "05",
            "mouza_pargona_code" => "06",
            "lot_no" => "05",
            "vill_townprt_code" => "10003",
            "uuid" => "0958237234632",
            "case_no" => "C-1005",
            "applid" => "APL12345",
            "status" => "Pending",
            "mobile_no" => "8638111169",
            "dag_details" => [
                [
                    "dist_code" => "07",
                    "subdiv_code" => "01",
                    "cir_code" => "05",
                    "mouza_pargona_code" => "06",
                    "lot_no" => "05",
                    "vill_townprt_code" => "10003",
                    "dag_no" => "101",
                    "patta_no" => "12",
                    "bigha" => 2,
                    "katha" => 1,
                    "lessa" => 0,
                    "reservation_b" => null
                ],
                [
                    "dist_code" => "07",
                    "subdiv_code" => "01",
                    "cir_code" => "05",
                    "mouza_pargona_code" => "06",
                    "lot_no" => "05",
                    "vill_townprt_code" => "10003",
                    "dag_no" => "101",
                    "patta_no" => "12",
                    "bigha" => 2,
                    "katha" => 1,
                    "lessa" => 0,
                    "reservation_b" => null
                ],

            ]
        ];
        $input = json_decode(trim(json_encode($data)), true);
        if (!$input) {
            return $this->respond(false, 'Invalid JSON input');
        }
        // ===== APPLY FORM VALIDATION RULES =====
        // $this->form_validation->set_data($input);

        // CASE DETAILS VALIDATION RULES
        // $this->form_validation->set_rules('tea_estate_name', 'Tea Estate Name', 'trim|required');
        // $this->form_validation->set_rules('dist_code', 'District Code', 'trim|required');
        // $this->form_validation->set_rules('subdiv_code', 'Subdivision Code', 'trim|required');
        // $this->form_validation->set_rules('cir_code', 'Circle Code', 'trim|required');
        // $this->form_validation->set_rules('mouza_pargona_code', 'Mouza Pargona Code', 'trim|required');
        // $this->form_validation->set_rules('lot_no', 'Lot No', 'trim|required');
        // $this->form_validation->set_rules('vill_townprt_code', 'Village/Town Part Code', 'trim|required');
        // $this->form_validation->set_rules('case_no', 'Case Number', 'trim|required|is_unique[case_details.case_no]');
        // $this->form_validation->set_rules('applid', 'Application ID', 'trim|required');
        // $this->form_validation->set_rules('status', 'Status', 'trim|required');
        // $this->form_validation->set_rules('user_code', 'User Code', 'trim|required');

        // if ($this->form_validation->run() === FALSE) {
        //     return $this->respond(false, strip_tags(validation_errors()));
        // }

        // ===== INSERT INTO CASE DETAILS ====
        //****************generate case number********************
        $case_name=$this->genearteCaseName($input['dist_code'],$input['subdiv_code'],$input['cir_code']);
        if(empty($case_name))
        {
            $data=array(
                'error'=>"Network Issue or Session Out. Please try Again"
            );
            echo json_encode($data);
            die();
        }
        //*******generating petition_no and case_no */
        $petition_no=$this->SettlementApiModel->genearteSettlementPetitionNo();
        $case_no=$case_name.$petition_no."/"."ACQP";
        $caseData = [
            'tea_estate_name'     => $input['tea_estate_name'],
            'mobile_no'           => $input['mobile_no'],
            'dist_code'           => $input['dist_code'],
            'subdiv_code'         => $input['subdiv_code'],
            'cir_code'            => $input['cir_code'],
            'mouza_pargona_code'  => $input['mouza_pargona_code'],
            'lot_no'              => $input['lot_no'],
            'vill_townprt_code'   => $input['vill_townprt_code'],
            'uuid'                => $input['uuid'],
            'case_no'             => $case_no,
            'applid'              => $input['applid'],
            'status'              => $input['status'],
            'final_order'         => isset($input['final_order']) ? $input['final_order'] : null,
            'order_date'          => isset($input['order_date']) ? $input['order_date'] : null,
            'user_code'           => $input['user_code'],
            'created_at'          => date('Y-m-d H:i:s'),
            'updated_at'          => date('Y-m-d H:i:s'),
        ];

        $this->db->insert('acquisition_basic', $caseData);
        $case_id = $this->db->insert_id();

        if (!$case_id) {
            return $this->respond(false, 'Failed to insert case details.');
        }

        // ===== DAG DETAILS VALIDATION =====
        if (empty($input['dag_details']) || !is_array($input['dag_details'])) {
            return $this->respond(false, 'dag_details must be an array and cannot be empty.');
        }

        foreach ($input['dag_details'] as $i => $dag) {
            // For nested validation, we manually validate each item
            if (empty($dag['dag_no']) || empty($dag['patta_no'])) {
                return $this->respond(false, "Missing required fields in dag_details item #" . ($i + 1) . " (dag_no, patta_no)");
            }

            $dagData = [
                'dist_code'          => $dag['dist_code'] ?? $input['dist_code'],
                'subdiv_code'        => $dag['subdiv_code'] ?? $input['subdiv_code'],
                'cir_code'           => $dag['cir_code'] ?? $input['cir_code'],
                'mouza_pargona_code' => $dag['mouza_pargona_code'] ?? $input['mouza_pargona_code'],
                'lot_no'             => $dag['lot_no'] ?? $input['lot_no'],
                'vill_townprt_code'  => $dag['vill_townprt_code'] ?? $input['vill_townprt_code'],
                'case_no'            => $case_no,
                'dag_no'             => $dag['dag_no'],
                'patta_no'           => $dag['patta_no'],
                'bigha'              => isset($dag['bigha']) ? (float)$dag['bigha'] : 0,
                'katha'              => isset($dag['katha']) ? (float)$dag['katha'] : 0,
                'lessa'              => isset($dag['lessa']) ? (float)$dag['lessa'] : 0,
                'ganda'              => isset($dag['ganda']) ? (float)$dag['ganda'] : 0,
                'chatak'             => isset($dag['chatak']) ? (float)$dag['chatak'] : 0,
                'kranti'             => isset($dag['kranti']) ? (float)$dag['kranti'] : 0,
                'reservation_b'      => isset($dag['reservation_b']) ? $dag['reservation_b'] : null,
                'user_code'          => $dag['user_code'] ?? $input['user_code']
            ];

            $this->db->insert('acquisition_dag_details', $dagData);
        }

        return $this->respond(true, 'Case registered successfully', [
            'case_id' => $case_id,
            'case_no' => $input['case_no']
        ]);
    }

    public function register()
    {

        $raw = file_get_contents("php://input");
        $input = json_decode($raw, true);
        if ($input === null) {
            echo "JSON ERROR: " . json_last_error_msg();
            echo "\nRAW:\n" . $raw;
            exit;
        }


        if (!$input || empty($input['tea_gardens']) || !is_array($input['tea_gardens'])) {
            return $this->respond(false, "Invalid JSON or 'tea_gardens' missing.");
        }

        $this->db->trans_begin(); // START TRANSACTION

        $saved_cases = [];

        foreach ($input['tea_gardens'] as $index => $garden) {

            // ===== REQUIRED FIELD VALIDATION =====
            $required = [
                'tea_estate_name','dist_code','subdiv_code','cir_code',
                'mouza_pargona_code','lot_no','vill_townprt_code',
                'uuid','applid','status','mobile_no'
            ];

            foreach ($required as $f) {
                if (empty($garden[$f])) {
                    $this->db->trans_rollback();
                    return $this->respond(false, "$f is required in tea_gardens item #" . ($index+1));
                }
            }

            if (empty($garden['dag_details']) || !is_array($garden['dag_details'])) {
                $this->db->trans_rollback();
                return $this->respond(false, "dag_details missing in item #" . ($index+1));
            }

            // ===== GENERATE CASE NUMBER =====
            $case_name = $this->genearteCaseName($garden['dist_code'], $garden['subdiv_code'], $garden['cir_code']);
            $petition_no = $this->genearteSettlementPetitionNo();

            if (!$case_name) {
                $this->db->trans_rollback();
                return $this->respond(false, "Failed generating case number for item #" . ($index+1));
            }

            $case_no = $case_name . $petition_no . "/ACQP";

            // ===== INSERT BASIC CASE =====
            $caseData = [
                'tea_estate_name'     => $garden['tea_estate_name'],
                'mobile_no'           => $garden['mobile_no'],
                'dist_code'           => $garden['dist_code'],
                'subdiv_code'         => $garden['subdiv_code'],
                'cir_code'            => $garden['cir_code'],
                'mouza_pargona_code'  => $garden['mouza_pargona_code'],
                'lot_no'              => $garden['lot_no'],
                'vill_townprt_code'   => $garden['vill_townprt_code'],
                'uuid'                => $garden['uuid'],
                'case_no'             => $case_no,
                'applid'              => $garden['applid'],
                'status'              => $garden['status'],
                'final_order'         => $garden['final_order'] ?? null,
                'order_date'          => $garden['order_date'] ?? null,
                'user_code'           => $garden['user_code'],
                'created_at'          => date('Y-m-d H:i:s'),
                'updated_at'          => date('Y-m-d H:i:s'),
                'service_code'        => '53'
            ];

            $this->db->insert('acquisition_basic', $caseData);
            $case_id = $this->db->insert_id();

            if (!$case_id) {
                $this->db->trans_rollback();
                return $this->respond(false, "Failed inserting case for item #" . ($index+1));
            }

            // ===== INSERT DAG DETAILS =====
            foreach ($garden['dag_details'] as $d => $dag) {

                if (empty($dag['dag_no']) || empty($dag['patta_no'])) {
                    $this->db->trans_rollback();
                    return $this->respond(false, "dag_no & patta_no required in DAG item #" . ($d+1) . " of garden #" . ($index+1));
                }

                $dagData = [
                    'case_no'            => $case_no,
                    'dist_code'          => $garden['dist_code'],
                    'subdiv_code'        => $garden['subdiv_code'],
                    'cir_code'           => $garden['cir_code'],
                    'mouza_pargona_code' => $garden['mouza_pargona_code'],
                    'lot_no'             => $garden['lot_no'],
                    'vill_townprt_code'  => $garden['vill_townprt_code'],
                    'dag_no'             => $dag['dag_no'],
                    'patta_no'           => $dag['patta_no'],
                    'patta_type_code'           => $dag['patta_type_code'],
                    'bigha'              => floatval($dag['bigha'] ?? 0),
                    'katha'              => floatval($dag['katha'] ?? 0),
                    'lessa'              => floatval($dag['lessa'] ?? 0),
                    'ganda'              => floatval($dag['ganda'] ?? 0),
                    'chatak'             => floatval($dag['chatak'] ?? 0),
                    'kranti'             => floatval($dag['kranti'] ?? 0),
                    'reservation_b'      => $dag['reservation_b'] ?? null,
                    'user_code'          => null,
                ];

                $this->db->insert('acquisition_dag_details', $dagData);
            }

            // Save summary
            $saved_cases[] = [
                'case_id' => $case_id,
                'case_no' => $case_no,
                'tea_estate_name' => $garden['tea_estate_name']
            ];
        }
        // ===== COMMIT TRANSACTION =====
        if ($this->db->trans_status() === FALSE) 
        {
            $this->db->trans_rollback();
            return $this->respond(false, "Transaction failed.");
        }
        $this->db->trans_commit();
        return $this->respond(true, "All tea garden cases registered successfully.", $saved_cases);
    }


    function genearteCaseName($dist_code,$subdiv_code,$cir_code){

        $financialyeardate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('y') : date('Y') . "-" . date('y', strtotime('+1 year'));
        $q = "Select dist_abbr,cir_abbr from location where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code!='00' ";
        $abbrname = $this->db->query($q)->row();
        if($abbrname)
        {
            $cir_dist_name = $abbrname->dist_abbr . "/" . $abbrname->cir_abbr;
            $case_no = $cir_dist_name . "/" . $financialyeardate . "/" ;
            return $case_no;
        }
        return false;
    }
    function genearteSettlementPetitionNo(){
        $petition_no = $this->db->query("select nextval('seq_max_settlement') as count ")->row()->count;
        return $petition_no;
    }

    // Common JSON response
    private function respond($success, $message, $extra = []) {
        echo json_encode(array_merge([
            'success' => $success,
            'message' => $message
        ], $extra));
    }

    public function casesAcq()
    {
        $service_code = '53';
        $status = $this->input->get('s');
        $data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);
        $data['_view'] = 'acq_cases_list';
        $this->load->view('layouts/main', $data);
    }

    public function cases()
    {
        $s_code = $this->input->post('service');
        $search_term = $this->input->post('search_term');
        $remark_cat = $this->input->post('remark_cat');
        $reverted = $this->input->post('reverted');
        $user_code = $this->session->userdata('user_code');
        $payment_status = $this->input->post('payment_status');

        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $nr_cat = $this->input->post('nr_cat');
        $review_cat = $this->input->post('review_cat');

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

    

        $this->db->limit($length, $start);



        if(!empty($mouza_pargona_code))
        {
            $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
        }

        if(!empty($mouza_pargona_code) && !empty($lot_no))
        {
            $this->db->where('a.lot_no', $lot_no);
        }



        if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }

        // $this->db->select('distinct(a.case_no),a.tea_estate_name,a.status, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code,SUM(b.bigha) as bigha,SUM(b.katha) as katha,SUM(b.lessa) as lessa,a.notice_type,mobile_no,objections_claims');
        
        // $this->db->where('a.dist_code', $this->session->userdata('dist_code'));       

        // $this->db->from('acquisition_basic a');
        // $this->db->join('acquisition_dag_details b', 'a.case_no = b.case_no');
        // $query = $this->db->get();
        $this->db->select('
            a.case_no,
            a.tea_estate_name,
            a.status,
            a.applid,
            a.dist_code,
            a.subdiv_code,
            a.cir_code,
            a.mouza_pargona_code,
            a.lot_no,
            a.vill_townprt_code,
            FLOOR(SUM(b.bigha * 100 + b.katha * 20 + b.lessa) / 100) AS bigha,
            FLOOR((SUM(b.bigha * 100 + b.katha * 20 + b.lessa) % 100) / 20) AS katha,
            ((SUM(b.bigha * 100 + b.katha * 20 + b.lessa) % 100) % 20) AS lessa,
            a.notice_type,
            a.mobile_no,
            a.objections_claims
        ');

        $this->db->from('acquisition_basic a');
        $this->db->join('acquisition_dag_details b', 'a.case_no = b.case_no');
        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->group_by('
            a.case_no,
            a.tea_estate_name,
            a.status,
            a.applid,
            a.dist_code,
            a.subdiv_code,
            a.cir_code,
            a.mouza_pargona_code,
            a.lot_no,
            a.vill_townprt_code,
            a.notice_type,
            a.mobile_no,
            a.objections_claims
        ');

        $query = $this->db->get();

        log_message('error','sssssssssssss'.$this->db->last_query());

        
        $viewNotice = '';
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $lmnoteRemark = null;
                $btnAction = '';
                $noticeStatus = 'Not generated';
                if($rows->notice_type == null)
                {
                    $noticeStatus = '<b style="color:#ff681d">Not generated</b>';
                    $viewNotice = '';
                }
                else
                {
                    $noticeStatus = '<b style="color:green">Notice X generated</b>';
                    $viewNotice = '<a type="button" href="' . base_url() . 'index.php/Acquisition/viewNotice?case=' . enc_param('case', $rows->case_no, 600) . '" class="btn-sm btn btn-warning">
                    view notice</a>';
                }

                if($rows->objections_claims == 'Y')
                {
                    $claimStatus = '<b>Claimed by citizen</b>';
                }
                else if($rows->objections_claims =='N')
                {
                    $claimStatus = "<b>Not Claimed by citizen</b>";
                }
                else
                {
                    $claimStatus = "NA";
                }
                

               
                $review_stat = null;
                $area = $rows->bigha."B-".$rows->katha."K-".$rows->lessa."L";
                
                $orderPassLink = '<a type="button" href="' . base_url() . 'index.php/Acquisition/orderPass?case=' . enc_param('case', $rows->case_no, 600) . '" class="lmreportmut btn-sm btn btn-primary">
                    write report</a>';
                if($rows->status == 'F')
                {
                    $btnAction = '<b>Order Passed</b>';
                }
                else
                {
                    $btnAction = $orderPassLink. $viewNotice;
                }
                $json[] = array(
                    $rows->case_no,
                    '<span style= font-size:14px;><strong>' . $rows->tea_estate_name . ' ('.$rows->mobile_no.')</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',

                    $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                    $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    $noticeStatus,
                    $claimStatus,

                    $area,

                    $review_stat,
                    $btnAction

                    
                );

            }

            if(!empty($mouza_pargona_code))
            {
                $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
            }

            if(!empty($mouza_pargona_code) && !empty($lot_no))
            {
                $this->db->where('a.lot_no', $lot_no);
            }

            if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
                $this->db->where('a.vill_townprt_code', $is_cat);
            }

        

            $this->db->select('DISTINCT a.case_no', false);
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->join('acquisition_dag_details b', 'a.case_no = b.case_no');
            $this->db->from('acquisition_basic a');
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

    public function bulkXnoticeServe()
    {
        // generate notice starts here
        $markedApplications = $this->input->post('selectMark');
        if (count($markedApplications) == 0) {
            $json = [
                'responseType' => 3,
                'message' => '#ERRCO098001: Kindly choose case no...',
                'list' => null,
            ];
            echo json_encode($json);
            return;
        }
        if (count($markedApplications) > 2) {
            log_message("error", '#ERRCO09876: Failed to generate notice. Selection Limit 10 Only');
            $json = [
                'responseType' => 3,
                'message' => '#ERRCO09876: Failed to generate notice. Selection Limit 10 Only',
            ];
            echo json_encode($json);
            return;
        }
        $remark = $this->input->post('remark_co');
        $completedCases = array();
        $setFlag = null;
        foreach ($markedApplications as $key => $value) 
        {
            $this->db->trans_begin();
            $case_no = $value;
            $aes = new AES($case_no, ENCRYPTION_KEY);
            $enc = $aes->encrypt();
            $enc = urlencode(str_replace("/","@",$enc));
            $basic = $this->SettlementAcqModel->getBasicData($case_no);
            if($basic['notice_type'] != null)
            {
                $this->db->trans_rollback();
                log_message("error", '#ACQ001: Notice already generated !!! '.$case_no);
                $json = [
                    'responseType' => 3,
                    'message' => '#ACQ001: Notice already generated for # '.$case_no.', Now Citizen can submit the claims or objections (if any)',
                    'list' => json_encode($completedCases),
                ];
                echo json_encode($json);
                return;
            }
            $basicD = $this->SettlementAcqModel->getBasicDataObject($case_no);
            $basicDags = $this->SettlementAcqModel->getBasicDataObjectDagsArray($case_no);
            $data = [
                'case_no' => $case_no,
                'remark' => $remark,
                'get_settlement_basic' => $basicD,
                'pay_notice_date' => date('Y-m-d'),
                'dags' => $basicDags
            ];
            if(isset($basic))
            {

                $data['case_no']                = $basic['case_no'];
                $data['application_no']         = $basic['applid'];

                $data['dist_name'] = $this->utilityclass->getDistrictName($basic['dist_code']);
                $data['circle_name'] = $this->utilityclass->getCircleName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
                $data['mouza_name'] = $this->utilityclass->getMouzaName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code']);

                $data['lot_name'] = $this->utilityclass->getLotName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no']);

                $data['village_name'] = $this->utilityclass->getVillageName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no'], $basic['vill_townprt_code']);

             

                $data['date_of_sldc'] =null;
                $data['dept_order_no'] = null;
                $data['dept_order_date'] = null;
            }
            else
            {
                // $this->session->set_flashdata('message', "#ERR1917: Unable to process! Something went wrong...#".$case_no);
                // redirect(base_url().'index.php/home');
                $this->db->trans_rollback();
                log_message("error", '#NOTE1000143: Unable to process due to modification request active # '.$case_no);
                $json = [
                    'responseType' => 3,
                    'message' => '#NOTE1000143: Unable to process basic data not found for # '.$case_no,
                    'list' => json_encode($completedCases),
                ];
                echo json_encode($json);
                return;
            }

            
            $data['date'] = date('d/m/Y');

            $this->load->helper('qrcode');
            $base_64 = "iVBORw0KGgoAAAANSUhEUgAAAIwAAACMAQMAAACUDtN9AAAABlBMVEX///8AAABVwtN+AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAA/ElEQVRIidWVUQrDIBBEF/Kxx/AiglcP5CIew4/AdNZNS9O/NpOPSjD6BCXj7MTsv1sD0K0WrMYR+wuomi3d98LhMHM5Kti6o/vWR8M9iJPRbkT8ptVuQamXkX5I+D2aVztqoTin2xah2XwNdLKiCLXOQx3Tnq3L0YKRC9W4MNTIspoKJeOhh14/IvrPCrf3DWkWLWJlLgBLtL5KVIly3mDT4YdeQsQC4qSkQ6deUoQ0vRl7+DXUseHI2ZmIWpTytwiUSAM1ygRY5lPfA0aDasofYf48UYoiasP9LfQa1xH3znn+MtWIb+zhIpejNE8EIakcZekAxw2o0T+3BwGPvjKA6hujAAAAAElFTkSuQmCC";
            $data['qrcode'] = ','.$base_64;
            // echo "dd";die;
            $htmlStringUpload = $this->load->view('x_notice_for_acquisition', $data,TRUE);

            
            $new_case_no = str_replace('/', "-", $case_no);
            $timestamp = date('mdYhis', time()).uniqid();

            // creating and saving the base64 format payment notice to uploads/paymentNotice folder
            $base_64_file_path = PAYMENT_NOTICE_PATH . $new_case_no.'_'.$timestamp. ".json";
            $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
            $htmlstring_text = json_encode(base64_encode($htmlStringUpload));
            fwrite($file_to_write_base64, $htmlstring_text);
            fclose($file_to_write_base64);
           
            $remark_co = $remark;
        
            $payment_notice_gn_date = date('Y-m-d');
            
            $sql_service = "SELECT * FROM acquisition_basic WHERE case_no = ?";
            $service_details = $this->db->query($sql_service, $case_no)->row();
            $notice_no = "ACQ/X/" . date('Y') . "/TEA/" . $service_details->id;

        
            $updateArr = [
                'status' => 'N',
                'notice_no' => $notice_no,
                'notice_link' => $base_64_file_path,
                'notice_type' => 'X',
                'notice_date' => date('Y-m-d'),
            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('acquisition_basic', $updateArr);
            if ($this->db->affected_rows() != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRPN0001: Updation Failed in settlement_basic table');
                $json = [
                    'responseType' => 3,
                    'list' => json_encode($completedCases),
                    'message' => 'Something went wrong3'
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
                'office_from' => 'DC',
                'office_to' => 'DC',
                'task' => 'NoticeX'
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if ($insertProc != 1)
            {
    
                log_message('error', '#ERRPINSN0002: Insertion failed in settlement_proceeding');
                $this->db->trans_rollback();
                    $json = [
                        'responseType' => 3,
                        'list' => json_encode($completedCases),
                        'message' => 'Something went wrong4'
                    ];
                    echo json_encode($json);
                    return;
            }

            if ($this->db->trans_status() == false) {
                $this->db->trans_rollback();
                    $json = [
                        'responseType' => 3,
                        'list' => json_encode($completedCases),
                        'message' => 'Something went wrong5'
                    ];
                    echo json_encode($json);
                    return;
            } else {
                // API CALL HERE
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, API_LINK_FOR_ACQ . "uploadXNotice");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    'encoded_file'       => base64_encode($htmlStringUpload),
                    'application_no'     => $case_no,
                    'tea_garden_name'    => $basic['tea_estate_name'],
                    'type' => 'X',
                    'dist_code' => $this->session->userdata('dist_code'),
                    'mobile_no' => $basicD->mobile_no
                )));
                $result = curl_exec($curl_handle);
                log_message('error','#ACQ==='.json_encode($result));
                if (trim($result) != 'y') {
                    $this->db->trans_rollback();
                    $json = [
                        'responseType' => 3,
                        'list' => json_encode($completedCases),
                        'message' => 'Notice could not be generated...please try after sometime!!!'
                    ];
                    echo json_encode($json);
                    return;
                }
                else
                {
                    log_message('error','#ENC==='.json_encode($enc));
                    $this->db->trans_commit();
                    /////SMS TO CITIZEN///////////
                    // $enc
                    $status = "success";
                    $teaGardenName = $basicD->tea_estate_name;
                    $date = date('Y-m-d');
                    $mobile = $basicD->mobile_no;
                    $link = "https://basundhara.assam.gov.in/rtpsmb2demo/AcquisitionApi/acqLandInfo/".$enc;
                    $reason = null;
                    $t = $this->sendAadhaarSms($teaGardenName,$date,$mobile, $link, $status, $reason);
                    
                    
                }
               
            }
            $completedCases[] = $case_no;
        }

        echo json_encode([
            'responseType' => 2,
            'message' => 'Notice issued for the selected cases...Now Citizen may submit the Claim or objections(if any)',
            'list' => json_encode($completedCases),
        ]);

    }

    public function sendAadhaarSms($teaGardenName,$date,$mobile, $link, $status, $reason = '')
    {

        $url = SMS_PROD_LINK;
        if($status == "success"){
            $key = "authentication_success";
            $variables[] = $teaGardenName;
            $variables[] = date('d/m/Y H:i:s');
            $variables[] = $mobile;
            $variables[] = $link;
            // $variables = [$teaGardenName, $date, $mobile, $link];
            // $variableString = implode('|', $variables);
            // $variables = "$teaGardenName|".date('d/m/Y H:i:s')."|$mobile|$link|$teaGardenName";
        } 

        $post = [
            'key'        => $key,
            'variables'  => $variables,
            'mobilenos'  => $mobile
        ];
        // var_dump($variables);die;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $result = curl_exec($ch);
        curl_close($ch); 
        return $result;
    }

    public function viewNotice()
    {
        $_GET['case'] = dec_param($this->input->get('case'), 'case');
        $case_no = $_GET['case'];
        // getting the notice file link
        $data['print_data'] = $this->SettlementAcqModel->getBasicData($case_no);
        // reading the base64 json file and saving it to a variable
        $path = $this->SettlementCommonModel->downloadNotice($data['print_data']['notice_link']);
        if($path == false){
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

    public function getlandRevenue($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code, $dag_no) 
    {

        $query = "select sum(dag_revenue+dag_local_tax) as sum,dag_revenue,dag_local_tax,dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,patta_no,patta_type_code,land_class_code from chitha_basic where dist_code= ? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=?  and vill_townprt_code=? and  trim(dag_no)=trim(?) group by dag_revenue,dag_local_tax,dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,patta_no,patta_type_code,land_class_code  ";
        $sql = $this->db->query($query, array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code, $dag_no));

        $revenueData=$sql->num_rows();
        if($revenueData > 0)
        {
            $revenueData=$sql->row()->sum;
            return $revenueData * 50;
        }
        else
        {
            return 0;
        }
    }

    public function orderPass()
    {
        $_GET['case'] = dec_param($this->input->get('case'), 'case');
        if($_GET['case'] == null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }
        $case_no  = $this->input->get('case');
        $user_desig_code = $this->session->userdata('user_desig_code');
        // if($user_desig_code !='DC')
        // {
        //     echo json_encode('Sorry !! You are not Authorized to access the content2!!');
        //     return;
        // }
        $basicD = $this->SettlementAcqModel->getBasicDataObject($case_no);
        $basicDags = $this->SettlementAcqModel->getBasicDataObjectDagsArray($case_no);
        if (!empty($basicDags)) {
            foreach ($basicDags as $d) {
                // Ensure all required codes exist in each DAG record
                $d->revenue = $this->getlandRevenue(
                    $d->dist_code ?? null,
                    $d->subdiv_code ?? null,
                    $d->cir_code ?? null,
                    $d->mouza_pargona_code ?? null,
                    $d->lot_no ?? null,
                    $d->vill_townprt_code ?? null,
                    $d->dag_no ?? null
                );
            }
        }
        $claims = $this->SettlementAcqModel->getObjectionsClaims($case_no);
        $data['basicD'] = $basicD;
        $data['basicDags'] = $basicDags;
        $data['claims'] = $claims;
        if($basicD->notice_link != null)
        {
            $noticeLink = '<a alt="Print Notice" class="text-white btn btn-sm btn-success" target="registrationNotice" href="' . base_url() . 'index.php/Acquisition/printNotice?case=' . enc_param('case', $case_no, 600). '">Print Acquisition Notice</a>';
        }
        else
        {
            $noticeLink = "<span class='badge badge-danger'>Notice not generated</span>";
        }
        
        $data['noticeLink'] = $noticeLink;
        $data['_view'] = 'acq_order_pass';
        $this->load->view('layouts/main', $data);
    }

    public function finalOrderPass()
    {
        // --- VALIDATION RULES ---
        $this->form_validation->set_rules('case_no', 'Case No', 'required|trim');
        $this->form_validation->set_rules('acq_tenants', 'Tenant Occupancy', 'required');
        $this->form_validation->set_rules('comp_total', 'Total Compensation', 'required');
        $this->form_validation->set_rules('installments', 'Installments', 'required|integer|greater_than[0]');
        $this->form_validation->set_rules('remark_dc_note', 'Final Remarks', 'trim|max_length[1000]');
        $this->form_validation->set_rules('tenant_details', 'Tenant Details', 'trim|max_length[500]');

        // --- RUN VALIDATION ---
        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'status' => 'error',
                'message' => validation_errors('<li>', '</li>')
            ]);
            return;
        }

        // --- INPUTS ---
        $case_no          = $this->input->post('case_no');
        $acq_tenants      = $this->input->post('acq_tenants');
        $tenant_details   = $this->input->post('tenant_details');
        $remark_dc_note   = $this->input->post('remark_dc_note');
        $installments     = (int)$this->input->post('installments');

        // DAG-wise arrays
        $comp_fallow       = $this->input->post('comp_fallow');
        $comp_non_fallow   = $this->input->post('comp_non_fallow');
        $comp_building     = $this->input->post('comp_building');
        $comp_improvement  = $this->input->post('comp_improvement');
        $comp_fruit_trees  = $this->input->post('comp_fruit_trees');
        $comp_total        = $this->input->post('dag_total'); // per-DAG total

        $user_code = $this->session->userdata('user_code');
        $now = date('Y-m-d H:i:s');

        $basicD = $this->SettlementAcqModel->getBasicDataObject($case_no);
        if($basicD->notice_link == null)
        {
            echo json_encode(['status' => 'error', 'message' => 'Notice has not been generated for Case No: '.$case_no]);
            return;
        }
        if($basicD->objections_claims == null)
        {
            echo json_encode(['status' => 'error', 'message' => 'Objections/claims not submitted for Case No: '.$case_no]);
            return;
        }
        $formYClaims = $this->db->query('select * from form_y_claims where application_no=?', array($case_no))->result();
        if(empty($formYClaims))
        {
            echo json_encode(['status' => 'error', 'message' => 'Objections/claims not submitted for Case No: '.$case_no]);
            return;
        }

        $this->db->trans_begin();

        // --- INSERT EACH DAG-WISE COMPENSATION ---
        if (!empty($comp_fallow)) {
            foreach ($comp_fallow as $dag_no => $fallow) {
                $data = [
                    'case_no'            => $case_no,
                    'acq_tenants'        => $acq_tenants,
                    'tenant_details'     => $tenant_details,
                    'dag_no'             => $dag_no,
                    'comp_fallow'        => (float)$fallow,
                    'comp_non_fallow'    => isset($comp_non_fallow[$dag_no]) ? (float)$comp_non_fallow[$dag_no] : 0,
                    'comp_building'      => isset($comp_building[$dag_no]) ? (float)$comp_building[$dag_no] : 0,
                    'comp_improvement'   => isset($comp_improvement[$dag_no]) ? (float)$comp_improvement[$dag_no] : 0,
                    'comp_fruit_trees'   => isset($comp_fruit_trees[$dag_no]) ? (float)$comp_fruit_trees[$dag_no] : 0,
                    'comp_total'         => isset($comp_total[$dag_no]) ? (float)$comp_total[$dag_no] : 0,
                    'installments'       => $installments,
                    'is_final'           => 1,
                    'user_code'          => $user_code,
                    'created_at'         => $now,
                    'updated_at'         => $now,
                    'paid_status'        => 'UNPAID',
                    'no_of_installment'  => $installments
                ];

                $saved = $this->SettlementAcqModel->insert_compensation($data);
                if (!$saved) {
                    $this->db->trans_rollback();
                    echo json_encode(['status' => 'error', 'message' => 'Failed to insert DAG compensation for DAG No: '.$dag_no]);
                    return;
                }
            }
        } else {
            $this->db->trans_rollback();
            echo json_encode(['status' => 'error', 'message' => 'No DAG compensation data found.']);
            return;
        }

        // --- UPDATE FINAL ORDER STATUS IN acquisition_basic ---
        $updateArr = [
            'status'      => 'F',
            'final_order' => $remark_dc_note,
            'order_date'  => $now,
            'user_code'   => $user_code
        ];

        $this->db->where('case_no', $case_no);
        $this->db->update('acquisition_basic', $updateArr);

        if ($this->db->affected_rows() < 0) {
            log_message('error', '#ERRPN0001: Update failed in acquisition_basic for case_no: '.$case_no);
            $this->db->trans_rollback();
            echo json_encode(['status' => 'error', 'message' => 'Failed to update final order details.']);
            return;
        }

        // --- INSERT PROCEEDING ENTRY ---
        $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        if ($proceeding_id == null) {
            $proceeding_id = 1;
        }

        $insertArr = [
            'case_no'             => $case_no,
            'proceeding_id'       => $proceeding_id,
            'date_of_hearing'     => $now,
            'next_date_of_hearing'=> $now,
            'note_on_order'       => $remark_dc_note,
            'status'              => 'N',
            'user_code'           => $user_code,
            'date_entry'          => $now,
            'operation'           => 'E',
            'ip'                  => $this->utilityclass->get_client_ip(),
            'office_from'         => 'DC',
            'office_to'           => 'DC',
            'task'                => 'Final'
        ];

        if (!$this->db->insert('settlement_proceeding', $insertArr)) {
            log_message('error', '#ERRPINSN0002: Insertion failed in settlement_proceeding for case_no: '.$case_no);
            $this->db->trans_rollback();
            echo json_encode(['status' => 'error', 'message' => 'Failed to insert proceeding details.']);
            return;
        }

        // --- FINALIZE TRANSACTION ---
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(['status' => 'error', 'message' => 'Transaction failed.']);
        } else {

            $chithaArray = $this->SettlementAcqModel->chitha($case_no);
            $chithaUpdate = $this->ChithaUpdateModel->AcqChithaUpdate($chithaArray);
            if($chithaUpdate['status'] == 0)
            {
                $this->db->trans_rollback();
                echo json_encode(['status' => 'error', 'message' => 'Chitha update failed.']);
            }

            $this->db->trans_commit();
            echo json_encode(['status' => 'success', 'message' => 'Final order passed successfully.']);
        }
    }

    public function printNotice()
    {

        $_GET['case'] = dec_param($this->input->get('case'), 'case');
        if($_GET['case'] == null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }
        $case_no  = $this->input->get('case');
        // getting the notice file link
        $basicD = $this->SettlementAcqModel->getBasicDataObject($case_no);
        // reading the base64 json file and saving it to a variable
        $path = $this->SettlementCommonModel->downloadNotice($basicD->notice_link);
        if($path == false){
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

    public function acqLandInfo($enc_case_no)
    {

        $data  = array();
        $type  = 'X';
        $encId = $enc_case_no;
        $originalString = str_replace("@","/",$encId);
        $aes       = new AES($originalString, ENCRYPTION_KEY);
        $encId   = $aes->decrypt();
        $notice_data = $this->db->query('select * from x_notice_docs where application_no=? and file_details=?', array($encId,$type));
        if ($notice_data->num_rows()>0)
        {
            $notice = $notice_data->row();
            $formYClaims = $this->db->query('select * from form_y_claims where application_no=?', array($notice->case_no))->row();
            $data['formYClaims'] = $formYClaims;
            $data['notice'] = $notice;
            $this->db2 = $this->dbswitch2($notice->dist_code);
            $dagDetailsAgainstCaseno = $this->db2->query("SELECT * from acquisition_dag_details where case_no= ?  and dist_code= ?)",array($notice->case_no,$notice->dist_code))->result();
            $data['noticeDags'] = $dagDetailsAgainstCaseno;
            $this->load->view('acq_objections_claims', $data);
        }
        else
        {
            echo "Something went wrong !!!";
            die;
        }
        
    }

    public function dbswitch2($dist_code)
    {
        if ($dist_code == "02") {
            $this->db2 = $this->load->database('dhubri', TRUE);
        } else if ($dist_code == "05") {
            $this->db2 = $this->load->database('barpeta', TRUE);
        } else if ($dist_code == "10") {
            $this->db2 = $this->load->database('chirang', TRUE);
        } else if ($dist_code == "13") {
            $this->db2 = $this->load->database('bongaigaon', TRUE);
        } else if ($dist_code == "17") {
            $this->db2 = $this->load->database('dibrugarh', TRUE);
        } else if ($dist_code == "15") {
            $this->db2 = $this->load->database('jorhat', TRUE);
        } else if ($dist_code == "14") {
            $this->db2 = $this->load->database('golaghat', TRUE);
        } else if ($dist_code == "07") {
            $this->db2 = $this->load->database('kamrup', TRUE);
        } else if ($dist_code == "03") {
            $this->db2 = $this->load->database('goalpara', TRUE);
        } else if ($dist_code == "18") {
            $this->db2 = $this->load->database('tinsukia', TRUE);
        } else if ($dist_code == "12") {
            $this->db2 = $this->load->database('lakhimpur', TRUE);
        } else if ($dist_code == "24") {
            $this->db2 = $this->load->database('kamrupm', TRUE);
        } else if ($dist_code == "06") {
            $this->db2 = $this->load->database('nalbari', TRUE);
        } else if ($dist_code == "11") {
            $this->db2 = $this->load->database('sonitpur', TRUE);
        } else if ($dist_code == "16") {
            $this->db2 = $this->load->database('sibsagar', TRUE);
        } else if ($dist_code == "32") {
            $this->db2 = $this->load->database('morigaon', TRUE);
        } else if ($dist_code == "33") {
            $this->db2 = $this->load->database('nagaon', TRUE);
        } else if ($dist_code == "34") {
            $this->db2 = $this->load->database('majuli', TRUE);
        } else if ($dist_code == "21") {
            $this->db2 = $this->load->database('karimganj', TRUE);
        } else if ($dist_code == "35") {
            $this->db2 = $this->load->database('biswanath', TRUE);
        } else if ($dist_code == "36") {
            $this->db2 = $this->load->database('hojai', TRUE);
        } else if ($dist_code == "37") {
            $this->db2 = $this->load->database('charaideo', TRUE);
        } else if ($dist_code == "25") {
            $this->db2 = $this->load->database('dhemaji', TRUE);
        } else if ($dist_code == "39") {
            $this->db2 = $this->load->database('bajali', TRUE);
        } else if ($dist_code == "38") {
            $this->db2 = $this->load->database('ssalmara', TRUE);
        } else if ($dist_code == "08") {
            $this->db2 = $this->load->database('darrang', TRUE);
        } else if ($dist_code == "22") {
            $this->db2 = $this->load->database('hailakandi', TRUE);
        } else if ($dist_code == "auth") {
            $this->db2 = $this->load->database('auth', TRUE);
        }
        return $this->db2;
    }

    public function noticeView($enc)
    {
        try
        {
          $sql = "select * from x_notice_docs where enc=? and status='1'";
          $row = $this->db->query($sql,array($enc));
          if ($row==null || $row->num_rows()<=0)
          {
             echo "Notice not issued!!!";die;
          }
          $row = $row->row();
          if (!file_exists($row->path))
          {
             echo "Notice not issued!!!";die;
          }
          $json = file_get_contents($row->path);
          $data['notice'] = $json;
          $this->load->view('notice',$data);
        } catch (Exception $e) {
          log_message("error","NOTICE DISPLAY ERROR".json_encode($e->getMessage()));
          echo false;
        }
    }

    public function submitFormY() 
    {
        header('Content-Type: application/json');

        // Validate required fields
        $this->form_validation->set_rules('application_no', 'Application No', 'required');
        $this->form_validation->set_rules('dist_code', 'dist_code', 'required');
        $this->form_validation->set_rules('applicant_name', 'Applicant Name', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('interest', 'Interest Type', 'required');
        $this->form_validation->set_rules('grounds', 'Grounds', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'status' => 'error',
                'message' => validation_errors()
            ]);
            return;
        }

        // Handle file upload
        $file_name = null;
        if (!empty($_FILES['documents']['name'])) {
            $config['upload_path'] = UPLOAD_DIR_NOTICE;
            $config['allowed_types'] = 'pdf|jpg|jpeg|png';
            $config['max_size'] = 2048;
            $config['encrypt_name'] = TRUE;

            if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, TRUE);

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('documents')) {
                $upload_data = $this->upload->data();
                $file_name = $upload_data['file_name'];
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => $this->upload->display_errors()
                ]);
                return;
            }
        }

        // Insert data into database
        $data = [
            'application_no'    => $this->input->post('application_no'),
            'dist_code'         => $this->input->post('dist_code'),
            'applicant_name'    => $this->input->post('applicant_name'),
            'address'           => $this->input->post('address'),
            'interest'          => $this->input->post('interest'),
            'land_particulars'  => $this->input->post('land_particulars'),
            'grounds'           => $this->input->post('grounds'),
            'documents'         => $config['upload_path'].$file_name,
            'notice_no'         => $this->input->post('application_no'),
            'date_of_submission'=> date('Y-m-d H:i:s')
        ];

        $insSt = $this->db->insert('form_y_claims', $data);
        if($insSt != 1)
        {
            echo json_encode([
                'status' => 'error',
                'message' => '#ERR091 : Something went wrong!!!!'
            ]);
            return;
        }


        $this->db2 = $this->dbswitch2($this->input->post('dist_code'));
        $insDharSt = $this->db2->insert('form_y_claims',$data);
        if($insDharSt != 1)
        {
            echo json_encode([
                'status' => 'error',
                'message' => '#ERR092 : Something went wrong!!!'
            ]);
            return;
        }

        $updateData = array(
            'objections_claims' => 'Y'
        );

        $this->db2->where('case_no', $this->input->post('application_no'));
        $this->db2->where('dist_code', $this->input->post('dist_code'));
        $this->db2->update('acquisition_basic', $updateData);
        if($this->db2->affected_rows() != 1){
            echo json_encode([
                'status' => 'error',
                'message' => '#ERR092 : Something went wrong!!!!'
            ]);
            return;
        }


        echo json_encode([
            'status' => 'success',
            'message' => 'Your claim/objection has been submitted successfully.'
        ]);
    }

    public function sendsms()
    {

        $url = SMS_PROD_LINK;
        $key = "notice_generate";
        $variables[] = "https://basundhara.assam.gov.in";
        // $variables[] = 'Tea Garden';
        $variables[] = date('d/m/Y H:i:s');
        $variables[] = '8638111169';
        
        $post = [
            'key'        => $key,
            'variables'  => $variables,
            'mobilenos'  => '8638111169'
        ];
        // var_dump($variables);die;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $result = curl_exec($ch);
        curl_close($ch); 
        var_dump($result);
    }



}
