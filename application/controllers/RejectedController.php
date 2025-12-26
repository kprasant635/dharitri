<?php

class RejectedController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->user_code = $this->session->userdata('user_code');
        $this->load->helper(array('form', 'url', 'Language'));
        $this->load->library('form_validation');
        $this->load->model('UtilsModel');
        $this->load->model('RejectedDataModel');
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
    public function rejectedData()
    {
        $dist_code = $this->session->userdata('dist_code');
        $circle = $this->db->query("select subdiv_code,cir_code,loc_name,locname_eng from location where dist_code=? and cir_code!=? and  mouza_pargona_code=? and  vill_townprt_code=? and lot_no=? order by loc_name",
            array($dist_code, '00', '00', '00000', '00'));
        // echo $this->db->last_query();

        $data['circles']    = $circle->result();

        $data['cases']      = '';
        $data['casesCount'] = 0;
        $data['_view'] = 'search_data_to_get_details_rejected';
        $this->load->view('layouts/main', $data);
    }

    public function getSearchedDataDetail()
    {
        $json          = null;

        $serviceName   = trim($this->input->post('serviceName'));
        $appStatus     = trim($this->input->post('appStatus'));
        $dist_code     = $this->session->userdata('dist_code');
        $draw          = intval($this->input->post('draw'));
        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $start         = intval($this->input->post('start'));
        $length        = intval($this->input->post('length'));
        $order         = $this->input->post('order');
        $fromDate      = trim($this->input->post('fromDate'));
        $toDate        = trim($this->input->post('toDate'));
        $resultData    = '';
        $totalRecords = 0;

        // if no data select
        if ($serviceName == '' || $serviceName == null)
        {
            $resultData   = '';
            $totalRecords = 0;
        }

        if(($appStatus != null || $appStatus != '') && ($serviceName != null || $serviceName != '')) {

            //get table by selected service
            $service = json_decode($this->RejectedDataModel->getTableByService($serviceName));
            // log_message('error', '#ERR220: '.$this->db->last_query());

            $cases = json_decode($this->RejectedDataModel->getSearchedDataByApplicationStatus($appStatus,$fromDate, $toDate, $length, $start, $service->table, $service->type));

            log_message('error','***********'.json_encode($cases));

            $resultData   = $cases->fetchedData;
            $totalRecords = $cases->total_records;
        }

        

        if(isset($resultData)){

            if($totalRecords > 0) {

                $i = 1;

                foreach($resultData as $rows) {
                    log_message('error','))))))))))'.json_encode($rows));
                    if($rows->case_no != null || $rows->case_no != ''){
                        $arr = explode('/', $rows->case_no);
                        $type = isset($arr['4']) ? $arr['4'] : null;

                        if($type == null) { continue; }

                        $submission_date = '<i class="fa fa-calendar" aria-hidden="true"></i> '.date ("j F, Y",strtotime($rows->submission_date)).'</p>';

                        
                        $link = base_url() . "index.php/CaseView/caseDetails?case_no=".$rows->case_no;
                        if($type != 'CONV' || $type != 'ACPP')
                        {
                            $button = "<a target='_blank' class='rezaButt' href=".$link."><i class='fa fa-eye'></i> View</a>";
                        }

                        $json[] = array(

                            $i,
                            $rows->case_no."<br><span class='small font-italic red'>".$this->utilityclass->getBasuApplIdFromCaseNo($rows->case_no)."</span>",
                            $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),
                            $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),
                            $this->RejectedDataModel->getRejectedRemarkByCaseNo($rows->case_no).'  ( Rejected On '.$rows->rejected.')',

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
