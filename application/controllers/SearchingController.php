<?php

class SearchingController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->user_code = $this->session->userdata('user_code');
        $this->load->helper(array('form', 'url', 'Language'));
        $this->load->library('form_validation');
        $this->load->model('UtilsModel');
        $this->load->model('SearchingModel');
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
        } else if($this->session->userdata('dist_code') == "39"){
            $this->db=$this->load->database('dha39', TRUE);
        } else if($this->session->userdata('dist_code') == "38"){
            $this->db=$this->load->database('dha25', TRUE);
        }
    }

    // case search page
    public function loadSearchingViewPage()
    {
        $dist_code = $this->session->userdata('dist_code');
        $circle = $this->db->query("select subdiv_code,cir_code,loc_name,locname_eng 
    from location where dist_code=? and cir_code!=? and  mouza_pargona_code=? and  
    vill_townprt_code=? and lot_no=? order by loc_name",
            array($dist_code, '00', '00', '00000', '00'));
        // echo $this->db->last_query();

        $data['circles']    = $circle->result();

        $data['cases']      = '';
        $data['casesCount'] = 0;
        $data['_view'] = 'search_data_to_get_details';
        $this->load->view('layouts/main', $data);
    }

    public function getSearchedDataDetail()
    {
        $json          = null;
        $caseNo        = trim($this->input->post('caseNo'));
        $applicationNo = trim($this->input->post('applicationNo'));
        $serviceName   = trim($this->input->post('serviceName'));
        $appStatus     = trim($this->input->post('appStatus'));
        $pendingOffice = trim($this->input->post('pendingOffice'));
        $fromDate      = trim($this->input->post('fromDate'));
        $toDate        = trim($this->input->post('toDate'));
        $selectCircle  = trim($this->input->post('selectCircle'));
        $dist_code     = $this->session->userdata('dist_code');

        $draw          = intval($this->input->post('draw'));
        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $start         = intval($this->input->post('start'));
        $length        = intval($this->input->post('length'));
        $order         = $this->input->post('order');

        $resultData    = '';
        $totalRecords = 0;

        // if no data select
        if ($caseNo == '' && $applicationNo == '' && $serviceName == '' && $appStatus == '' && $pendingOffice == '' && $fromDate == '' && $toDate == '' && $selectCircle == '')
        {
            $resultData   = '';
            $totalRecords = 0;
        }

        //search by dharitree case number
        else if(($caseNo != null || $caseNo != '') && ($serviceName != '' || $serviceName == null))
        {
            $caseType = json_decode($this->SearchingModel->getCaseTypeFromCaseNo($caseNo));

            //get table by selected service
            $service = json_decode($this->SearchingModel->getTableByService($serviceName));
            // log_message('error', '#ERR132: '.$this->db->last_query());

            // var_dump($service);

            // for full case no
            if($caseType->response == 1)
            {
                $cases = $this->SearchingModel->getCasesByCaseNo($service->table, $caseNo);
                // echo $this->db->last_query();
            }

            // both petition no and service selects
            else if($caseType->response == 2 && ($serviceName != '' || $serviceName != null))
            {
                //get searched data detail
                $cases = $this->SearchingModel->getDetailsByPetitionNo($service->table, $caseNo, $service->like);
                // log_message('error', '#ERR136: '.$this->db->last_query());
            }

            $resultData   = $cases->result();
            $totalRecords = $cases->num_rows();
        }

        //search by basundhara application number
        else if(($applicationNo != null || $applicationNo != '') && ($serviceName != '' || $serviceName != null))
        {
            //get dharitree case no
            $caseNo = $this->SearchingModel->getDharitreeCaseNoByRtpsNo($applicationNo);
            // log_message('error', '#ERR151: '.$this->db->last_query());

            $caseType = json_decode($this->SearchingModel->getCaseTypeFromCaseNo($caseNo));

            //get table by selected service
            $service = json_decode($this->SearchingModel->getTableByService($serviceName));
            // log_message('error', '#ERR132: '.$this->db->last_query());

            $cases = $this->SearchingModel->getCasesByCaseNo($service->table, $caseNo);

            $resultData   = $cases->result();
            $totalRecords = $cases->num_rows();
        }

        //search by service name
        else if(($serviceName != null || $serviceName != '') && ($caseNo == '' && $applicationNo == '' && $appStatus == '' && $pendingOffice == '' && $fromDate == '' && $toDate == '' && $selectCircle == ''))
        {
            //get table by selected service
            $service = json_decode($this->SearchingModel->getTableByService($serviceName));
            // log_message('error', '#ERR172: '.$this->db->last_query());

            //get searched data detail
            $cases = json_decode($this->SearchingModel->getDetailsByServiceName($service->table, $service->like, $length, $start));
            // log_message('error', '#ERR176: '.$this->db->last_query());

            $resultData   = $cases->fetchedData;
            $totalRecords = $cases->total_records;
        }

        // get cases between dates
        else if(($fromDate != null || $fromDate != '') && ($toDate != null || $toDate != '') && $pendingOffice == null) {

            $cases = json_decode($this->SearchingModel->getFetchedDataBetweenDates($serviceName,$appStatus,$pendingOffice,$selectCircle,$fromDate,$toDate, $length, $start));
            // log_message('error', '#ERR189 : '.$this->db->last_query());

            $resultData   = $cases->fetchedData;
            $totalRecords = $cases->total_records;
        }

        //get cases by application status
        else if(($appStatus != null || $appStatus != '') && ($serviceName != null || $serviceName != '')) {

            //get table by selected service
            $service = json_decode($this->SearchingModel->getTableByService($serviceName));
            // log_message('error', '#ERR220: '.$this->db->last_query());

            $cases = json_decode($this->SearchingModel->getSearchedDataByApplicationStatus($appStatus, $selectCircle, $fromDate, $toDate, $length, $start, $service->table, $service->type, $service->like));

            $resultData   = $cases->fetchedData;
            $totalRecords = $cases->total_records;
        }

        //get cases by pending officer
        else if(($pendingOffice !=null || $pendingOffice != '') && ($serviceName != null || $serviceName != '')) {

            //get table by selected service
            $service = json_decode($this->SearchingModel->getTableByService($serviceName));
            // log_message('error', '#ERR220: '.$this->db->last_query());

            $cases = json_decode($this->SearchingModel->getDataByPendingOfficer($service->table, $service->type, $pendingOffice, $selectCircle, $fromDate, $toDate, $length, $start, $service->like));

            $resultData   = $cases->fetchedData;
            $totalRecords = $cases->total_records;
        }

        else if(($selectCircle != null || $selectCircle != null) && ($caseNo == null && $applicationNo == null && $appStatus == null && $pendingOffice == null))
        {
            //get table by selected service
            $service = json_decode($this->SearchingModel->getTableByService($serviceName));

            $cases = json_decode($this->SearchingModel->getDataByCircleSelect($selectCircle, $service->table, $fromDate, $toDate, $service->like, $length, $start));

            // var_dump($cases);

            $resultData   = $cases->fetchedData;
            $totalRecords = $cases->total_records;
        }

        if(isset($resultData)){

            if($totalRecords > 0) {

                $i = 1;

                foreach($resultData as $rows) {

                    if($rows->case_no != null || $rows->case_no != ''){
                        $arr = explode('/', $rows->case_no);
                        $type = isset($arr['4']) ? $arr['4'] : null;

                        if($type == null) { continue; }

                        $case_no = enc_param('case_no', $rows->case_no, 600);

                        $submission_date = '<i class="fa fa-calendar" aria-hidden="true"></i> '.date ("j F, Y",strtotime($rows->submission_date)).'</p>';

                        if($type == 'SKHAS' || $type == 'SAPNR' || $type == 'SCULT' || $type == 'SVGR' || $type == 'STRIB' || $type == 'STENT')
                        {
                            $link = base_url() . "index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=".$case_no;
                            $button = "<a target='_blank' class='rezaButt' href=".$link."><i class='fa fa-eye'></i> View</a>";
                        }


                        // MB3
                        else if($type == 'NCKHAS' || $type == 'SBGL' || $type == 'RECLS' || $type == 'SOTU' || $type == 'TGPP' || $type == 'APPP' || $type == 'SLIJE')
                        {
//                            $link = base_url() . "index.php/SettlementCommonDc/viewApplicationDetailsForMb3Only?case=".$case_no;
                            $link = base_url() . "index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=".$case_no;
                            $button = "<a target='_blank' class='rezaButt' href=".$link."><i class='fa fa-eye'></i> View</a>";
                        }

                        else
                        {
                            $link = base_url() . "index.php/CaseView/caseDetails?case_no=".$case_no;
                            if($type != 'CONV' || $type != 'ACPP')
                            {
                                $button = "<a target='_blank' class='rezaButt' href=".$link."><i class='fa fa-eye'></i> View</a>";
                            }
                        }

                        $json[] = array(

                            $i,
                            $rows->case_no."<br><span class='small font-italic red'>".$this->utilityclass->getBasuApplIdFromCaseNo($rows->case_no)."</span>",
                            $submission_date,
                            $button
                        );
                        $i++;
                    }
                }
            }
            else {
                $json = "";
            }

            $response = array(
                'draw'              => $draw,
                'recordsTotal'      => $totalRecords,
                'recordsFiltered'   => $totalRecords,
                'data'              => $json
            );
            // echo "<pre>";
            // var_dump($response);die;
            echo json_encode($response);
        }
        else {
            $response = array();
            $response['sEcho']=0;
            $response['iTotalRecords']=0;
            $response['iTotalDisplayRecords']=0;
            $response['aaData']=[];
            echo json_encode($response);
        }
    }


}
