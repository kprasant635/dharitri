<?php
class BasundharaReview extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->model('review/ReviewModel');
        $this->load->model('basundhara/basundharamodel');    }
    public function index()
    {
        $user_code = $this->session->userdata('user_code');
        $designation = $this->session->userdata('designation');
        $data = array();
        $newMouzaList = $this->ReviewModel->locationSelect();
        $uniqueMouzaList = array_map("unserialize", array_unique(array_map("serialize", $newMouzaList)));
        $data['select_data'] = $uniqueMouzaList;
        $data['_view'] = 'review/review_application_list';
        $this->load->view('layouts/main', $data);
    }
    public function caseList()
    {
        $dist_code   = $this->input->post('dist_code');
        $data = array();
        $data['dist_code'] =$dist_code;
        $data['dist_name'] = $this->utilclass->getDistrictName($dist_code);
        // $data['conversionCaseList'] = $this->DeptConversionModel->getconversionCaseList($this->db2,$dist_code);
        $this->load->view('review/review_applications',$data);
    }
    
    public function getPendingList() 
    {
        $json = null;
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');
        $order = $this->input->post('order');
        $dist_code = $this->session->userdata('dist_code');
        $curl_handle = curl_init();
        $searchByCol_1 = strtoupper(trim($this->input->post('columns')[1]['search']['value']));
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."mb2ReviewApplications/$dist_code");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'start' => $start,
            'length' => $length,
            'order' => $order,
            'searchByCol_0' => $searchByCol_1,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code
        )));
        $result = curl_exec($curl_handle);
        $results = json_decode($result);
        if (isset($results)) 
        {
            $data_rows = $results->data_results;
            if(count($data_rows) >  0)
            {    
                foreach($data_rows as $rows) 
                {
                    $case_no = $this->ReviewModel->getSettlementAppDetailsByCaseNo($rows->application_no);
                    $s_code = $rows->service_code;
                    $tenant_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $case_no->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>';
                    $tribal_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $case_no->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>';
                    $ap_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $case_no->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>';
                    $khas_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $case_no->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>  ';
                    $vgr_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $case_no->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a> ';
                    $tea_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $case_no->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>';

                    $json[] = array(
                        $rows->application_no,
                        '<span style= font-size:14px;><strong>' . $rows->application_no . '</strong></span>',

                        $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_code),

                        $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_code, $rows->lot_no),

                        $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_code, $rows->lot_no, $rows->village_code),

                        // $rows->date_entry,
                        date("Y-m-d", strtotime($rows->date_submission)),

                        (($s_code == SETTLEMENT_TENANT_ID) ? $tenant_link : (($s_code == SETTLEMENT_AP_TRANSFER_ID) ? $ap_link : (($s_code == SETTLEMENT_TRIBAL_COMMUNITY_ID) ? $tribal_link : (($s_code == SETTLEMENT_KHAS_LAND_ID) ? $khas_link : (($s_code == SETTLEMENT_PGR_VGR_LAND_ID) ? $vgr_link : (($s_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID) ? $tea_link : '')))))),
                        );
                }
            }
            else 
            {
                $json = "";
            }      
            $total_records = $results->total_records;
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


    public function forwardCasesToDLR()
    {
        $response = array('responseType' => 2,'msg'=>null);
        $response = $this->ReviewModel->forwardCasesToDLR($_POST);
        log_message('error','#DLRRES=============='.json_encode($response));
        echo json_encode($response);
    }

    public function RejectCasesbyDC()
    {
        $response = array('responseType' => 2,'msg'=>null);
        $response = $this->ReviewModel->rejectCases($_POST);
        log_message('error','#DLRRESREJECT=============='.json_encode($response));
        echo json_encode($response);
    }
}