<?php
class NcModification extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('NcModel/NcCommonSdoModel');
        $this->load->model('NcModel/NcCommonSdoAdcDcModel');
        $this->load->model('NcModel/NcCommonModel');
        $this->load->model('NcModel/NcPullModel');
        $this->load->model('NcModel/NcApiModel');
        $this->load->model('UtilsModel');


    }


    // NC code by Masud Reza (05/02/2024)

    //////////////// *************** **************** ////////////////

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

    public function decodeBase64($encoded_string)
    {
        $file_data= base64_decode($encoded_string);
        $file = finfo_open();
        $mime_type = finfo_buffer($file, $file_data, FILEINFO_MIME_TYPE);
        $file_type = explode('/', $mime_type)[0];
        $extension = explode('/', $mime_type)[1];
        log_message("error","No error occured".json_encode($mime_type));
        return $mime_type;
    }






    /// ************* CO *************************


    // get all case list for modification // CO
    public function caseListForPullRequest()
    {
        $service_code = $this->input->get('service');

        if ($this->session->userdata('user_desig_code') == 'CO')
        {
            // in query it is checked as not equal to Z status
            $status = 'Z';
            $data['select_data'] = $this->NcPullModel->locationSelectPullRequest($service_code, $status);

            $data['_view'] = 'NcVillageService/NcPullRequest/nc_mb_pull_request_co';
            $this->load->view('layouts/main', $data);
        }
        else
        {
            $this->session->set_flashdata('message', " You are not Authorized for modification Request ");
            redirect(base_url() . "index.php/home");
        }
    }


    // paginate for modification case list // CO
    public function paginationForPullRequest()
    {

        if(LOT_BIFURCATE_PULL == 1 && $this->session->userdata('user_desig_code') == 'CO')
        {
            $lot_string = $this->caseListUnderMappingLot();
        }

        $s_code = $this->input->post('service');
        $search_term = $this->input->post('search_term');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $status = $this->input->post('status');
        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order  = $this->input->post('order');
        $col = 0;
        $dir = "";
        $search = $this->input->post('search');
        $search = $search['value'];
        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];

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

        $this->db->limit($length, $start);
        $this->db->where('a.service_code', $s_code);


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
        if(LOT_BIFURCATE ==1 && empty($mouza_pargona_code) && empty($lot_no))
        {
            if(isset($lot_string) && $lot_string != null)
            {
                $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
            }
        }

        $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
        $this->db->select('distinct(a.case_no), a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry,a.pull_request,a.status,a.pending_officer');
        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->where("((a.pending_officer in ('DPT','DC','ADC','SDO') and a.status in ('W','R','T','L','Q','O','J','G')) OR  (a.pending_officer in ('CO') and a.status in ('M','N'))) ");
        $this->db->where('a.pull_request',0);
        $this->db->where_in('a.service_code',NC_MODIFICATION_REQUEST_SERVICE_CODE);
        $this->db->where_not_in('a.status',[MB_DISMISS,MB_FINAL]);
        $this->db->from('settlement_basic a');
        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $rows)
            {
                if($this->session->userdata('user_desig_code') == 'CO')
                {

                    $tribal_link = '<a  type="button" href="#" onclick="openModalForFlag(\''.$rows->case_no.'\',\''.$rows->applid.'\')" class="btn-sm btn btn-primary">
                        <i class="fa fa-arrow-right" aria-hidden="true"></i> Modification Request</a>
                        <a type="button" href="' . base_url() . 'index.php/NcCommonController/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class=" btn-sm btn btn-success">
                        <i class="fa fa-eye" aria-hidden="true"></i> View</a>';

                    $khas_link = '<a  type="button" href="#" onclick="openModalForFlag(\''.$rows->case_no.'\',\''.$rows->applid.'\')" class="btn-sm btn btn-primary">
                        <i class="fa fa-arrow-right" aria-hidden="true"></i> Modification Request</a>
                        <a type="button" href="' . base_url() . 'index.php/NcCommonController/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class=" btn-sm btn btn-success">
                        <i class="fa fa-eye" aria-hidden="true"></i> View</a>';

                    $tea_link = '<a  type="button" href="#" onclick="openModalForFlag(\''.$rows->case_no.'\',\''.$rows->applid.'\')" class="btn-sm btn btn-primary">
                        <i class="fa fa-arrow-right" aria-hidden="true"></i> Modification Request</a>
                        <a type="button" href="' . base_url() . 'index.php/NcCommonController/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class=" btn-sm btn btn-primary">
                        <i class="fa fa-eye" aria-hidden="true"></i> View</a>';

                }

                $json[] = array(
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                    $this->ncutility->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                    $this->ncutility->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                    $this->ncutility->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    // $rows->date_entry,

                    $rows->pending_officer,
                    (($s_code == NC_TRIBAL_ID) ? $tribal_link : (($s_code == NC_KHAS_LAND_ID) ? $khas_link : (($s_code == NC_CULTIVATOR_ID) ? $tea_link : ''))),
                );
            }

            $this->db->where('a.service_code', $s_code);
            if(LOT_BIFURCATE ==1 && empty($mouza_pargona_code) && empty($lot_no)){

                if(isset($lot_string) && $lot_string != null)
                {
                    $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                }
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
            $this->db->select('a.case_no');
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
            $this->db->where("((a.pending_officer in ('DPT','DC','ADC','SDO') and a.status in ('W','R','T','L','Q','O','J','G')) OR  (a.pending_officer in ('CO') and a.status in ('M','N'))) ");
            $this->db->where('a.pull_request',0);
            $this->db->where_in('a.service_code',NC_MODIFICATION_REQUEST_SERVICE_CODE);
            $this->db->where_not_in('a.status',[MB_DISMISS,MB_FINAL]);
            $this->db->group_by('a.case_no');
            $this->db->from('settlement_basic a');
            $query = $this->db->get();
            $total_records =$query->num_rows();
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


    // modification requested by co modal yes // CO
    public function checkWhetherPullRequestByCO()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('case_no',    'Case Number', 'trim|required');
        $this->form_validation->set_rules('applid',     'Application Number', 'trim|required');
        $this->form_validation->set_rules('co_remarks', 'Remarks', 'trim|required|min_length[3]|max_length[4000]');

        if ($this->form_validation->run() == FALSE)
        {
            $error = validation_errors();
            echo json_encode(array(
                'responseType' => 1,
                'message' => 'Validation error',
            ));
            return;
        }

        $case_no      = trim($this->input->post('case_no'));
        $applid       = trim($this->input->post('applid'));
        $co_remarks   = trim($this->input->post('co_remarks'));
        $co_user_code = trim($this->session->userdata('user_code'));
        $service_code = trim($this->input->post('service_code'));
        $dist_code    = trim($this->session->userdata('dist_code'));
        $subdiv_code  = trim($this->session->userdata('subdiv_code'));
        $cir_code     = trim($this->session->userdata('cir_code'));
        $CoAllowCon   = ['M','N'];

        if($case_no == null || $applid == null || $co_remarks == null)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL000357: Modification request cancelled...!case no missing/No Remarks ',
            ]);
            return false;
        }

        //*****update in settlement_basic */

        $sql = "SELECT * FROM settlement_basic WHERE dist_code =  ? AND subdiv_code =  ?
                        AND cir_code =  ? and case_no = ? and applid = ? ";

        $rowdata = $this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,$case_no,$applid));
        if($rowdata->num_rows() == 0){
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL000357: Pull request cancelled...! case not found',
            ]);
            return false;
        }

        $caseDetails  = $rowdata->row();
        $pullReqCheck = $this->NcPullModel->checkModificationRequestAlreadyExist($case_no,$dist_code);
        if(trim($pullReqCheck) != 0)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL000380: Pull request cancelled...! Case already requested for modification',
            ]);
            return false;
        }
        if(! in_array($caseDetails->service_code, NC_MODIFICATION_REQUEST_SERVICE_CODE))
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL000380: Pull request cancelled...! You are not authorized for this Application',
            ]);
            return false;
        }
        if(trim($caseDetails->pull_request) != 0)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL000382: Pull request cancelled...! Case already requested for modification',
            ]);
            return false;
        }
        if(trim($caseDetails->pending_officer) == 'CO' && (!in_array(trim($caseDetails->status),$CoAllowCon)))
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL000391: Pull request cancelled...! Case assigned to CO',
            ]);
            return false;
        }

        $inStatus      = ['W','R','T','L','Q','O','J','M','N','G'];
        $inPendingWith = ['DPT','DC','ADC','SDO','CO'];
        if(!in_array(trim($caseDetails->status),$inStatus))
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL000402: Pull request cancelled...! Case already processed',
            ]);
            return false;
        }
        if(!in_array(trim($caseDetails->pending_officer),$inPendingWith))
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL000402: Pull request cancelled...! Case assigned to '.$caseDetails->pending_officer,
            ]);
            return false;
        }

        $headQtrCheck = $this->NcCommonSdoAdcDcModel->headquarterCheck($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'));
        if(trim($headQtrCheck) == 'Y')
        {
            $pending_officer = 'ADC';
        }
        else
        {
            $pending_officer = 'SDO';
        }

        $this->db->trans_begin();

        $InsertedData = [
            'dist_code'           => trim($caseDetails->dist_code),
            'subdiv_code'         => trim($caseDetails->subdiv_code),
            'cir_code'            => trim($caseDetails->cir_code),
            'mouza_pargona_code'  => trim($caseDetails->mouza_pargona_code),
            'lot_no'              => trim($caseDetails->lot_no),
            'vill_townprt_code'   => trim($caseDetails->vill_townprt_code),
            'case_no'             => trim($caseDetails->case_no),
            'applid'              => trim($caseDetails->applid),
            'service_code'        => trim($caseDetails->service_code),
            'co_user_code'        => $co_user_code,
            'co_remarks'          => $co_remarks,
            'final_status'        => MODIFICATION_REQUEST_PENDING,
            'nc'                  => 1,
            'created_at'          => date('Y-m-d H:i:s'),
            'pull_req_by'         => $co_user_code,
            'date_of_pull'        => date('Y-m-d H:i:s'),
            'old_pending_officer' => trim($caseDetails->pending_officer),
            'old_from_office'     => trim($caseDetails->from_office),
            'old_status'          => trim($caseDetails->status),
            'pending_request_officer' => trim($pending_officer),
        ];

        $insertStatus = $this->db->insert('settlement_pull_request',$InsertedData);
        if($insertStatus != 1){
            log_message('error', '#MRPULL000456: Insertion failed in settlement_pull_request and query is: ' . $this->db->last_query());
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL000456: Enable pull request cancelled ! Kindly contact system administrator',
            ]);
            return false;
        }

        $basicArray = [
            'pull_request' => 1
        ];
        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $basicArray);
        if($this->db->affected_rows() !=1)
        {
            log_message('error', '#MRPULL000472: Updating failed in settlement_basic and query is: ' . $this->db->last_query());
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL000472: Enable pull request cancelled ! Kindly contact system administrator',
            ]);
            return false;
        }


        //////proceeding start//////
        $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        if ($proceeding_id==null) {
            $proceeding_id=1;
        }

        $insPetProceed = [
            'case_no'         => $case_no,
            'proceeding_id'   => $proceeding_id,
            'date_of_hearing' => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'note_on_order' => $this->input->post('co_remarks'),
            'status'        => 'MR',
            'user_code'     => $this->session->userdata('user_code'),
            'date_entry'    => date('Y-m-d h:i:s'),
            'operation'     => 'E',
            'ip'            => $this->utilityclass->get_client_ip(),
            'office_from'   => 'CO',
            'office_to'     => trim($pending_officer),
            'task'          => 'Modification Requested by CO'
        ];
        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

        if ($insertProceeding != 1) {
            $this->db->trans_rollback();
            log_message('error', '#MRPULL000506: Insertion failed in settlement_proceeding for case no :'. $case_no);
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL000506: Enable pull request cancelled ! Kindly contact system administrator',
            ]);
            return false;
        }
        //////proceeding end//////


        if($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL000357: Something went wrong ! Kindly contact system administrator',
            ]);
            return false;
        }
        else
        {
            if(trim($caseDetails->pending_officer) == 'CO' && trim($caseDetails->status == 'N'))
            {
                $applicationNoForApi = trim($caseDetails->applid);
                $apiStatus = 'PC'; // Payment Cancelled

                // API calling for cab memo list
//                $curl_handle = curl_init();
//                curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."cancelGeneratePaymentLink");
//                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
//                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
//                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
//                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
//                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
//                    'application_no' => $applicationNoForApi,
//                    'api_status'     => $apiStatus
//                )));
//
//                $output = curl_exec($curl_handle);
//                curl_close($curl_handle);
//                if(trim($output)!= "y")
//                {
//                    $this->db->trans_rollback();
//                    log_message('error', '#MRAPIPULL0552: API failed in payment cancellation for case no :'. $case_no);
//                    echo json_encode([
//                        'responseType' => 1,
//                        'message' => '#MRAPIPULL0552: Could not process Modification Request.
//                                                      The citizen might have already processed the payment',
//                    ]);
//                    return false;
//                }

                $insPetProceed = [
                    'case_no'         => $case_no,
                    'proceeding_id'   => $proceeding_id + 1,
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'note_on_order' => 'Payment cannot be processed as due to policy change your case is under review with circle office',
                    'status'      => 'PC',
                    'user_code'   => $this->session->userdata('user_code'),
                    'date_entry'  => date('Y-m-d h:i:s'),
                    'operation'   => 'E',
                    'ip'          => $this->utilityclass->get_client_ip(),
                    'office_from' => 'CO',
                    'office_to'   => trim($pending_officer),
                    'task'        => 'Payment Notice Cancelled',
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                if ($insertProceeding != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#MRPULL000580: Insertion failed in settlement_proceeding for case no :'. $case_no);
                    echo json_encode([
                        'responseType' => 1,
                        'message' => '#MRPULL000580: Enable pull request cancelled ! Kindly contact system administrator',
                    ]);
                    return false;
                }
            }

            $this->db->trans_commit();
            echo json_encode([
                'responseType' => 2,
                'message' => 'Modification request successfully submitted to '.$pending_officer,
            ]);
            return false;
        }
    }


    // get all case list for modification // CO
    public function caseListForModificationRequestedByCo()
    {
        $service_code = $this->input->get('service');

        if ($this->session->userdata('user_desig_code') == 'CO')
        {
            // in query it is checked as not equal to Z status
            $status = 'Z';
            $data['select_data'] = $this->NcPullModel->locationSelectPullRequest($service_code, $status);

            $data['_view'] = 'NcVillageService/NcPullRequest/all_pull_requested_cases_by_co';
            $this->load->view('layouts/main', $data);
        }
        else
        {
            $this->session->set_flashdata('message', " You are not Authorized for modification Request ");
            redirect(base_url() . "index.php/home");
        }
    }


    // paginate for modification case list // CO
    public function paginationForModificationRequestedByCo()
    {

        if(LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO')
        {
            $lot_string = $this->caseListUnderMappingLot();
        }

        $s_code = $this->input->post('service');
        $search_term = $this->input->post('search_term');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $status = $this->input->post('status');
        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order  = $this->input->post('order');
        $col = 0;
        $dir = "";
        $search = $this->input->post('search');
        $search = $search['value'];
        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];

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

        $this->db->limit($length, $start);
        $this->db->where('a.service_code', $s_code);


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
        if(LOT_BIFURCATE ==1 && empty($mouza_pargona_code) && empty($lot_no))
        {
            if(isset($lot_string) && $lot_string != null)
            {
                $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
            }
        }

        $this->db->select('distinct(a.case_no), a.applid, a.dist_code, a.subdiv_code, 
        a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code,
        a.date_entry,a.pull_request,a.status,a.pending_officer,
        settlement_pull_request.final_status,settlement_pull_request.pending_request_officer');
        $this->db->from('settlement_basic a');
        $this->db->join('settlement_pull_request', 'a.case_no = settlement_pull_request.case_no');
        $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->where('a.service_code',$s_code);
        $this->db->where('settlement_pull_request.nc',1);
        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $rows)
            {
                if($this->session->userdata('user_desig_code') == 'CO')
                {
                    $tribal_link = '<a style="margin-top: 5px" type="button" href="' . base_url() . 'index.php/NcCommonController/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class=" btn-sm btn btn-success">
                        <i class="fa fa-eye" aria-hidden="true"></i> View Case</a>';

                    $khas_link = '<a style="margin-top: 5px" type="button" href="' . base_url() . 'index.php/NcCommonController/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class=" btn-sm btn btn-success">
                        <i class="fa fa-eye" aria-hidden="true"></i> View Case</a>';

                    $tea_link = '<a style="margin-top: 5px" type="button" href="' . base_url() . 'index.php/NcCommonController/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class=" btn-sm btn btn-primary">
                        <i class="fa fa-eye" aria-hidden="true"></i> View Case</a>';

                }

                $requestStatus = '';
                if(trim($rows->final_status) == MODIFICATION_REQUEST_APPROVED)
                {
                    $requestStatus = '<span style= color:#2E7D32;><strong>Approved</strong></span>';
                }
                else if(trim($rows->final_status) == MODIFICATION_REQUEST_REJECTED)
                {
                    $requestStatus = '<span style= color:#D32F2F;><strong>Rejected</strong></span>';
                }
                else if(trim($rows->final_status) == MODIFICATION_REQUEST_PENDING)
                {
                    $requestStatus = '<span><strong>Pending</strong></span>';
                }

                $requestPendingOfficer = '';
                if(trim($rows->pending_request_officer) == 'DPT')
                {
                    $requestPendingOfficer = 'Department';
                }
                else
                {
                    $requestPendingOfficer = trim($rows->pending_request_officer);
                }

                $json[] = array(
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                    $this->ncutility->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                    $this->ncutility->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                    $this->ncutility->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    $rows->pending_officer,
                    $requestStatus,
                    $requestPendingOfficer,

                    (($s_code == NC_TRIBAL_ID) ? $tribal_link : (($s_code == NC_KHAS_LAND_ID) ? $khas_link : (($s_code == NC_CULTIVATOR_ID) ? $tea_link : ''))),
                );
            }

            $this->db->where('a.service_code', $s_code);
            if(LOT_BIFURCATE ==1 && empty($mouza_pargona_code) && empty($lot_no)){

                if(isset($lot_string) && $lot_string != null)
                {
                    $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                }
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

            $this->db->select('a.case_no');
            $this->db->from('settlement_basic a');
            $this->db->join('settlement_pull_request', 'a.case_no = settlement_pull_request.case_no');
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('settlement_pull_request.nc',1);
            $query = $this->db->get();
            $total_records =$query->num_rows();
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


    /// ************* END CO *************************






    /// ************* SDO *************************

    // get all modification requested case list by CO for SDO
    public function getAllModificationRequestApplicationByCoForSdo()
    {
        $dist_code    = $this->session->userdata('dist_code');
        $subdiv_code  = $this->session->userdata('subdiv_code');
        $service_code = trim($this->input->get('service'));

        if($service_code == '' OR $service_code == NULL)
        {
            $data['select_data'] = '';
            $data['serviceCode'] = '';
            $data['application'] = 0;
        }
        else
        {
            $data['select_data'] = $this->NcPullModel->locationSelectPullRequestWithOutStatusSDO($service_code);
            $data['application'] = 1;
            if($service_code == NC_KHAS_LAND_ID)
            {
                $data['service_name'] = $this->lang->line('ncKhasLandTitle');
            }
            elseif($service_code == NC_CULTIVATOR_ID)
            {
                $data['service_name'] = $this->lang->line('ncCultivatorTitle');
            }
            elseif($service_code == NC_TRIBAL_ID)
            {
                $data['service_name'] = $this->lang->line('ncTribalTitle');
            }
        }

        $data['_view'] = 'NcVillageService/NcPullRequest/modification_requested_by_co_list_for_sdo';
        $this->load->view('layouts/main', $data);

    }


    // Pagination for get all rejected application by CO for SDO
    public function paginationForModificationRequestApplicationByCoForSdo()
    {
        $s_code       = trim($this->input->post('service'));
        $search_term  = trim($this->input->post('search_term'));
        $dist_code    = $this->session->userdata('dist_code');
        $subdiv_code  = $this->session->userdata('subdiv_code');
        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order  = $this->input->post('order');
        $col = 0;
        $dir = "";
        $search = $this->input->post('search');

        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];

        $is_cat = $this->input->post('is_category');

        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }

        $valid_columns = array(
            0 => 'case_no',
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

        if (!empty($is_cat)) {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }

        $this->db->limit($length, $start);

        $this->db->where('a.service_code', $s_code);
        $this->db->where('a.dist_code', $dist_code);
        $this->db->where('a.subdiv_code', $subdiv_code);
        $this->db->where('a.service_code', $s_code);
        $this->db->where('a.pull_request',1);
        $this->db->where_not_in('a.status',[MB_DISMISS,MB_FINAL]);
        $this->db->where('settlement_pull_request.service_code', $s_code);
        $this->db->where('settlement_pull_request.nc', 1);
        $this->db->where('settlement_pull_request.service_code', $s_code);
        $this->db->where('settlement_pull_request.final_status', MODIFICATION_REQUEST_PENDING);
        $this->db->where('settlement_pull_request.pending_request_officer', MB_SUB_DIV_COMM);
        $this->db->select('distinct(a.case_no), a.applid, a.dist_code, a.subdiv_code, 
        a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code,
        a.date_entry,a.pull_request,a.status,a.pending_officer,
        settlement_pull_request.final_status,settlement_pull_request.pending_request_officer');
        $this->db->from('settlement_basic a');
        $this->db->join('settlement_pull_request', 'a.case_no = settlement_pull_request.case_no');

        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $rows)
            {
                $tribal_link = '<a type="button" target="_blank" href="' . base_url() . 'index.php/NcCommonController/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn btn-primary">
                        <i class="fa fa-eye"></i> View Case</a>
                        
                        <a type="button" target="_blank" href="' . base_url() . 'index.php/NcModification/getModificationRequestApplicationDetailsForSdo/?case=' . $rows->case_no . '" class="lmreportmut btn btn-success">
                        <i class="fa fa-step-forward"></i> Process</a>
                        ';
                $khas_link = '<a type="button" target=_blank href="' . base_url() . 'index.php/NcCommonController/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn btn-primary">
                        <i class="fa fa-eye"></i> View Case</a>
                        
                        <a type="button" target="_blank" href="' . base_url() . 'index.php/NcModification/getModificationRequestApplicationDetailsForSdo/?case=' . $rows->case_no . '" class="lmreportmut btn btn-success">
                        <i class="fa fa-step-forward"></i> Process</a>
                        ';
                $tea_link = '<a type="button" target=_blank href="' . base_url() . 'index.php/NcCommonController/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn btn-primary">
                        <i class="fa fa-eye"></i> View Case</a>
                        
                        <a type="button" target="_blank" href="' . base_url() . 'index.php/NcModification/getModificationRequestApplicationDetailsForSdo/?case=' . $rows->case_no . '" class="lmreportmut btn btn-success">
                        <i class="fa fa-step-forward"></i> Process</a>
                        ';


                $json[] = array(
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                    '<p><span style="font-size:14px;"><strong>Mouza :</strong> ' . $this->ncutility->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code) . ',
                         <strong>Lot :</strong> ' . $this->ncutility->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no) . ',
                        </p><p style="line-height: 1px; font-size:14px;"><strong>Village :</strong> ' . $this->ncutility->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code) . '</span></p>',

                    (($s_code == NC_TRIBAL_ID) ? $tribal_link : (($s_code == NC_KHAS_LAND_ID) ? $khas_link : (($s_code == NC_CULTIVATOR_ID) ? $tea_link : ''))),

                );
            }

            $this->db->select('distinct(a.case_no), a.applid, a.dist_code, a.subdiv_code, 
            a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code,
            a.date_entry,a.pull_request,a.status,a.pending_officer,
            settlement_pull_request.final_status,settlement_pull_request.pending_request_officer');
            $this->db->join('settlement_pull_request', 'a.case_no = settlement_pull_request.case_no');
            $this->db->where('a.dist_code', $dist_code);
            $this->db->where('a.subdiv_code', $subdiv_code);
            $this->db->where('a.service_code', $s_code);
            $this->db->where('a.pull_request',1);
            $this->db->where_not_in('a.status',[MB_DISMISS,MB_FINAL]);
            $this->db->where('settlement_pull_request.service_code', $s_code);
            $this->db->where('settlement_pull_request.nc', 1);
            $this->db->where('settlement_pull_request.final_status', MODIFICATION_REQUEST_PENDING);
            $this->db->where('settlement_pull_request.pending_request_officer', MB_SUB_DIV_COMM);

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


    // get modification requested case status details SDO
    public function getModificationRequestApplicationDetailsForSdo()
    {
        $dist_code       = $this->session->userdata('dist_code');
        $subdiv_code     = $this->session->userdata('subdiv_code');
        $user_code       = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');

        $case_no = trim($this->input->get('case'));
        if($case_no == '')
        {
            $this->session->set_flashdata('message', " Case Number not found ! ");
            redirect(base_url() . 'index.php/Home/index');
        }
        $caseCount = $this->NcCommonModel->countSettlementAppDetailsByCaseNo($case_no);
        if($caseCount == 0)
        {
            $this->session->set_flashdata('message', " Case not found ! ");
            redirect(base_url() . 'index.php/Home/index');
        }
        else
        {
            $caseDetails = $this->NcCommonModel->getSettlementAppDetailsByCaseNo($case_no);
            $service_code = trim($caseDetails->service_code);
            if(trim($caseDetails->pull_request) != 1)
            {
                $this->session->set_userdata('message', "Modification request already processed ! ");
                redirect(base_url().'index.php/NcModification/getAllModificationRequestApplicationByCoForSdo?service='.$service_code);
            }
            if(! in_array($caseDetails->service_code, NC_MODIFICATION_REQUEST_SERVICE_CODE))
            {
                $this->session->set_userdata('message', "You are not authorized for this Application ! ");
                redirect(base_url().'index.php/NcModification/getAllModificationRequestApplicationByCoForSdo?service='.$service_code);
            }
            $requested = $this->NcPullModel->getModificationRequestCaseDetailsForSdo($dist_code,$subdiv_code,$service_code,$case_no);
            if($requested->num_rows() == 0)
            {
                $this->session->set_flashdata('message', " Case not found ! ");
                redirect(base_url() . 'index.php/Home/index');
            }

            $caseInProposal  = 0;
            $caseInMeeting   = 0;
            $getProposalID   = '';
            $proposalDetails = '';
            $meetingDetails  = '';
            $caseIdSdlacProposal = $this->NcCommonModel->countSettlementApplicationByCaseNoInSdlacProList($case_no);
            if($caseIdSdlacProposal != 0)
            {
                $caseInProposal  = 1;
                $getProposalID   = $this->NcPullModel->getSettlementProposalCaseDetailsByCaseNoPull($case_no);
                $proposalDetails = $this->NcPullModel->getProposalDetailsByProIdPull(trim($getProposalID->proposal_id));
                if(trim($proposalDetails->proposal_meeting_id) != '')
                {
                    $caseInMeeting   = $this->NcPullModel->countMeetingDetailByMeetingIDPull(trim($proposalDetails->proposal_meeting_id));
                    if($caseInMeeting != 0)
                    {
                        $caseInMeeting = 1;
                        $meetingDetails  = $this->NcPullModel->getMeetingDetailByMeetingIDPull(trim($proposalDetails->proposal_meeting_id));
                    }
                }
            }

            $rejectButtAccess  = 0;
            $forwardButtAccess = 0;
            $acceptButtAccess  = 0;
            $userAccess = [MB_DEPUTY_COMM,MB_ADD_DEPUTY_COMM,MB_SUB_DIV_COMM];
            if(in_array($user_desig_code,$userAccess))
            {
                $rejectButtAccess = 1;

                if($caseInProposal == 0 && $caseInMeeting == 0)
                {
                    if(trim($caseDetails->pending_officer) == $user_desig_code)
                    {
                        $acceptButtAccess = 1;
                    }
                }
                elseif($caseInProposal == 1 && $caseInMeeting == 0)
                {
                    if(trim($caseDetails->pending_officer) == $user_desig_code)
                    {
                        $acceptButtAccess = 1;
                    }
                }
                else
                {
                    $forwardButtAccess = 1;
                }
            }


            if($service_code == NC_KHAS_LAND_ID)
            {
                $data['service_name'] = $this->lang->line('ncKhasLandTitle');
            }
            elseif($service_code == NC_CULTIVATOR_ID)
            {
                $data['service_name'] = $this->lang->line('ncCultivatorTitle');
            }
            elseif($service_code == NC_TRIBAL_ID)
            {
                $data['service_name'] = $this->lang->line('ncTribalTitle');
            }

            $data['requestedDetails']  = $requested->row();
            $data['basic']             = $caseDetails;
            $data['caseInProposal']    = $caseInProposal;
            $data['caseInMeeting']     = $caseInMeeting;
            $data['proposalDetails']   = $proposalDetails;
            $data['proposalCaseD']     = $getProposalID;
            $data['meetingDetails']    = $meetingDetails;
            $data['rejectButtAccess']  = $rejectButtAccess;
            $data['forwardButtAccess'] = $forwardButtAccess;
            $data['acceptButtAccess']  = $acceptButtAccess;

            $data['_view'] = 'NcVillageService/NcPullRequest/modification_requested_case_details_for_sdo';
            $this->load->view('layouts/main', $data);

        }
    }

    /// ************* SDO *************************




    /// ************* ADC *************************

    // get all modification requested case list by CO for Adc
    public function getAllModificationRequestApplicationByCoForAdc()
    {
        $dist_code    = $this->session->userdata('dist_code');
        $subdiv_code  = $this->session->userdata('subdiv_code');
        $service_code = trim($this->input->get('service'));

        if($service_code == '' OR $service_code == NULL)
        {
            $data['select_data'] = '';
            $data['serviceCode'] = '';
            $data['application'] = 0;
        }
        else
        {
            $data['select_data'] = $this->NcPullModel->locationSelectPullRequestWithOutStatusADC($service_code);
            $data['application'] = 1;
            if($service_code == NC_KHAS_LAND_ID)
            {
                $data['service_name'] = $this->lang->line('ncKhasLandTitle');
            }
            elseif($service_code == NC_CULTIVATOR_ID)
            {
                $data['service_name'] = $this->lang->line('ncCultivatorTitle');
            }
            elseif($service_code == NC_TRIBAL_ID)
            {
                $data['service_name'] = $this->lang->line('ncTribalTitle');
            }
        }

        $data['_view'] = 'NcVillageService/NcPullRequest/modification_requested_by_co_list_for_adc';
        $this->load->view('layouts/main', $data);

    }


    // Pagination for get all rejected application by CO for Adc
    public function paginationForModificationRequestApplicationByCoForAdc()
    {
        $s_code       = trim($this->input->post('service'));
        $dist_code    = $this->session->userdata('dist_code');
        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order  = $this->input->post('order');
        $col = 0;
        $dir = "";
        $search = $this->input->post('search');

        $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];

        $is_cat = $this->input->post('is_category');

        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }

        $valid_columns = array(
            0 => 'case_no',
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

        if (!empty($is_cat)) {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }

        $this->db->limit($length, $start);

        $this->db->where('a.service_code', $s_code);
        $this->db->where('a.dist_code', $dist_code);
        $this->db->where('a.service_code', $s_code);
        $this->db->where('a.pull_request',1);
        $this->db->where_not_in('a.status',[MB_DISMISS,MB_FINAL]);
        $this->db->where('settlement_pull_request.service_code', $s_code);
        $this->db->where('settlement_pull_request.nc', 1);
        $this->db->where('settlement_pull_request.final_status', MODIFICATION_REQUEST_PENDING);
        $this->db->where('settlement_pull_request.pending_request_officer', MB_ADD_DEPUTY_COMM);
        $this->db->select('distinct(a.case_no), a.applid, a.dist_code, a.subdiv_code, 
        a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code,
        a.date_entry,a.pull_request,a.status,a.pending_officer,
        settlement_pull_request.final_status,settlement_pull_request.pending_request_officer');
        $this->db->from('settlement_basic a');
        $this->db->join('settlement_pull_request', 'a.case_no = settlement_pull_request.case_no');

        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $rows)
            {
                $tribal_link = '<a type="button" target="_blank" href="' . base_url() . 'index.php/NcCommonController/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn btn-primary">
                        <i class="fa fa-eye"></i> View Case</a>
                        
                        <a type="button" target="_blank" href="' . base_url() . 'index.php/NcModification/getModificationRequestApplicationDetailsForAdc/?case=' . $rows->case_no . '" class="lmreportmut btn btn-success">
                        <i class="fa fa-step-forward"></i> Process</a>
                        ';
                $khas_link = '<a type="button" target=_blank href="' . base_url() . 'index.php/NcCommonController/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn btn-primary">
                        <i class="fa fa-eye"></i> View Case</a>
                        
                        <a type="button" target="_blank" href="' . base_url() . 'index.php/NcModification/getModificationRequestApplicationDetailsForAdc/?case=' . $rows->case_no . '" class="lmreportmut btn btn-success">
                        <i class="fa fa-step-forward"></i> Process</a>
                        ';
                $tea_link = '<a type="button" target=_blank href="' . base_url() . 'index.php/NcCommonController/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn btn-primary">
                        <i class="fa fa-eye"></i> View Case</a>
                        
                        <a type="button" target="_blank" href="' . base_url() . 'index.php/NcModification/getModificationRequestApplicationDetailsForAdc/?case=' . $rows->case_no . '" class="lmreportmut btn btn-success">
                        <i class="fa fa-step-forward"></i> Process</a>
                        ';


                $json[] = array(
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                    '<p><span style="font-size:14px;"><strong>Mouza :</strong> ' . $this->ncutility->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code) . ',
                         <strong>Lot :</strong> ' . $this->ncutility->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no) . ',
                        </p><p style="line-height: 1px; font-size:14px;"><strong>Village :</strong> ' . $this->ncutility->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code) . '</span></p>',


                    (($s_code == NC_TRIBAL_ID) ? $tribal_link : (($s_code == NC_KHAS_LAND_ID) ? $khas_link : (($s_code == NC_CULTIVATOR_ID) ? $tea_link : ''))),
                );
            }

            $this->db->select('distinct(a.case_no), a.applid, a.dist_code, a.subdiv_code, 
            a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code,
            a.date_entry,a.pull_request,a.status,a.pending_officer,
            settlement_pull_request.final_status,settlement_pull_request.pending_request_officer');
            $this->db->join('settlement_pull_request', 'a.case_no = settlement_pull_request.case_no');
            $this->db->where('a.dist_code', $dist_code);
            $this->db->where('a.service_code', $s_code);
            $this->db->where('a.pull_request',1);
            $this->db->where_not_in('a.status',[MB_DISMISS,MB_FINAL]);
            $this->db->where('settlement_pull_request.service_code', $s_code);
            $this->db->where('settlement_pull_request.nc', 1);
            $this->db->where('settlement_pull_request.final_status', MODIFICATION_REQUEST_PENDING);
            $this->db->where('settlement_pull_request.pending_request_officer', MB_ADD_DEPUTY_COMM);

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


    // get modification requested case status details Adc
    public function getModificationRequestApplicationDetailsForAdc()
    {
        $dist_code       = $this->session->userdata('dist_code');
        $subdiv_code     = $this->session->userdata('subdiv_code');
        $user_code       = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');

        $case_no = trim($this->input->get('case'));
        if($case_no == '')
        {
            $this->session->set_flashdata('message', " Case Number not found ! ");
            redirect(base_url() . 'index.php/Home/index');
        }
        $caseCount = $this->NcCommonModel->countSettlementAppDetailsByCaseNo($case_no);
        if($caseCount == 0)
        {
            $this->session->set_flashdata('message', " Case not found ! ");
            redirect(base_url() . 'index.php/Home/index');
        }
        else
        {
            $caseDetails = $this->NcCommonModel->getSettlementAppDetailsByCaseNo($case_no);
            $service_code = trim($caseDetails->service_code);
            if(trim($caseDetails->pull_request) != 1)
            {
                $this->session->set_userdata('message', "Modification request already processed ! ");
                redirect(base_url().'index.php/NcModification/getAllModificationRequestApplicationByCoForAdc?service='.$service_code);
            }
            if(! in_array($service_code, NC_MODIFICATION_REQUEST_SERVICE_CODE))
            {
                $this->session->set_userdata('message', "You are not authorized for this Application ! ");
                redirect(base_url().'index.php/NcModification/getAllModificationRequestApplicationByCoForAdc?service='.$service_code);
            }
            $requested = $this->NcPullModel->getModificationRequestCaseDetailsForAdc($dist_code,$service_code,$case_no);
            if($requested->num_rows() == 0)
            {
                $this->session->set_flashdata('message', " Case not found ! ");
                redirect(base_url() . 'index.php/Home/index');
            }

            $caseInProposal  = 0;
            $caseInMeeting   = 0;
            $getProposalID   = '';
            $proposalDetails = '';
            $meetingDetails  = '';
            $caseIdSdlacProposal = $this->NcCommonModel->countSettlementApplicationByCaseNoInSdlacProList($case_no);
            if($caseIdSdlacProposal != 0)
            {
                $caseInProposal  = 1;
                $getProposalID   = $this->NcPullModel->getSettlementProposalCaseDetailsByCaseNoPull($case_no);
                $proposalDetails = $this->NcPullModel->getProposalDetailsByProIdPull(trim($getProposalID->proposal_id));
                if(trim($proposalDetails->proposal_meeting_id) != '')
                {
                    $caseInMeeting   = $this->NcPullModel->countMeetingDetailByMeetingIDPull(trim($proposalDetails->proposal_meeting_id));
                    if($caseInMeeting != 0)
                    {
                        $caseInMeeting = 1;
                        $meetingDetails  = $this->NcPullModel->getMeetingDetailByMeetingIDPull(trim($proposalDetails->proposal_meeting_id));
                    }
                }
            }

            $rejectButtAccess  = 0;
            $forwardButtAccess = 0;
            $acceptButtAccess  = 0;
            $userAccess = [MB_DEPUTY_COMM,MB_ADD_DEPUTY_COMM,MB_SUB_DIV_COMM];
            if(in_array($user_desig_code,$userAccess))
            {
                $rejectButtAccess = 1;

                if($caseInProposal == 0 && $caseInMeeting == 0)
                {
                    if(trim($caseDetails->pending_officer) == $user_desig_code)
                    {
                        $acceptButtAccess = 1;
                    }
                }
                elseif($caseInProposal == 1 && $caseInMeeting == 0)
                {
                    if(trim($caseDetails->pending_officer) == $user_desig_code)
                    {
                        $acceptButtAccess = 1;
                    }
                }
                else
                {
                    $forwardButtAccess = 1;
                }
            }


            if($service_code == NC_KHAS_LAND_ID)
            {
                $data['service_name'] = $this->lang->line('ncKhasLandTitle');
            }
            elseif($service_code == NC_CULTIVATOR_ID)
            {
                $data['service_name'] = $this->lang->line('ncCultivatorTitle');
            }
            elseif($service_code == NC_TRIBAL_ID)
            {
                $data['service_name'] = $this->lang->line('ncTribalTitle');
            }

            $data['requestedDetails']  = $requested->row();
            $data['basic']             = $caseDetails;
            $data['caseInProposal']    = $caseInProposal;
            $data['caseInMeeting']     = $caseInMeeting;
            $data['proposalDetails']   = $proposalDetails;
            $data['proposalCaseD']     = $getProposalID;
            $data['meetingDetails']    = $meetingDetails;
            $data['rejectButtAccess']  = $rejectButtAccess;
            $data['forwardButtAccess'] = $forwardButtAccess;
            $data['acceptButtAccess']  = $acceptButtAccess;

            $data['_view'] = 'NcVillageService/NcPullRequest/modification_requested_case_details_for_adc';
            $this->load->view('layouts/main', $data);

        }
    }


    /// ************* ADC *************************








    // common for ADC/SDO Forward/Reject/Accept
    //----------------------------------------------------

    // Reject modification request
    public function modificationRequestReject()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[2]|max_length[3000]');
        $this->form_validation->set_rules('caseNo',   'Case No', 'trim|required');
        $this->form_validation->set_rules('requestId', 'Request details', 'trim|required|is_natural_no_zero');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL0001133: Rejected request cancelled...! case no missing/No Remarks ',
            ]);
            return false;
        }

        $dist_code       = $this->session->userdata('dist_code');
        $user_code       = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $case_no         = trim($this->input->post('caseNo'));
        $req_id          = trim($this->input->post('requestId'));
        $remark          = trim($this->input->post('remarks'));
        $userAccess      = [MB_DEPUTY_COMM,MB_ADD_DEPUTY_COMM,MB_SUB_DIV_COMM];
        if(!in_array($user_desig_code,$userAccess))
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL0001149: You are not authorized for this process.! ',
            ]);
            return false;
        }
        if($case_no == NULL OR $req_id == NULL OR $remark == NULL)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL0001157: Rejected request cancelled...! case no missing/No Remarks ',
            ]);
            return false;
        }
        $caseDetails  = $this->NcCommonModel->getSettlementAppDetailsByCaseNo($case_no);
        $service_code = trim($caseDetails->service_code);
        if(trim($caseDetails->pull_request) != 1)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL0001165: Modification request already processed ',
            ]);
            return false;
        }
        if(! in_array($caseDetails->service_code, NC_MODIFICATION_REQUEST_SERVICE_CODE))
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL0001165: You are not authorized for this Application  ',
            ]);
            return false;
        }
        if(in_array($caseDetails->status,[MB_DISMISS,MB_FINAL]))
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL0001167: Case already processed ',
            ]);
            return false;
        }
        $requested = $this->NcPullModel->getModificationRequestCaseDetailsForCommon($req_id,$dist_code,$service_code,$case_no,$user_desig_code);
        if($requested->num_rows() == 0)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL0001177: Case not found ! ',
            ]);
            return false;
        }

        $this->db->trans_begin();
        $updateReq = [
            'final_status'            => MODIFICATION_REQUEST_REJECTED,
            'approved_by'             => $user_desig_code,
            'approved_by_uc'          => $user_code,
            'approve_date'            => date('Y-m-d H:i:s'),
            'approved_remarks'        => $remark,
            'pending_request_officer' => '',
        ];

        $this->db->where('id',$req_id);
        $this->db->where('nc',1);
        $this->db->update('settlement_pull_request',$updateReq);
        if($this->db->affected_rows() !=1){
            log_message('error', '#MRPULL001196: updating  failed in settlement_pull_request and query is: ' . $this->db->last_query());
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL001196: Rejected request cancelled ! Kindly contact system administrator',
            ]);
            return false;
        }


        $basicArray = [
            'pull_request' => 0
        ];
        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $basicArray);
        if($this->db->affected_rows() !=1)
        {
            log_message('error', '#MRPULL0001215: Updating failed in settlement_basic and query is: ' . $this->db->last_query());
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL0001215: Rejected request cancelled ! Kindly contact system administrator',
            ]);
            return false;
        }


        //////proceeding start//////
        $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        if ($proceeding_id==null) {
            $proceeding_id=1;
        }

        $insPetProceed = [
            'case_no'              => $case_no,
            'proceeding_id'        => $proceeding_id,
            'date_of_hearing'      => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'note_on_order'        => $remark,
            'status'               => 'MR',
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d h:i:s'),
            'operation'            => 'E',
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => $user_desig_code,
            'office_to'            => 'CO',
            'task'                 => 'Modification Request Rejected'
        ];
        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

        if ($insertProceeding != 1) {
            $this->db->trans_rollback();
            log_message('error', '#MRPULL0001249: Insertion failed in settlement_proceeding for case no :'. $case_no);
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL0001249: Rejected request cancelled ! Kindly contact system administrator',
            ]);
            return false;
        }
        //////proceeding end//////


        if($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL0001262: Something went wrong ! Kindly contact system administrator',
            ]);
            return false;
        }
        else
        {

            if(trim($caseDetails->pending_officer) == 'CO' && trim($caseDetails->status == 'N'))
            {
                $applicationNoForApi = trim($caseDetails->applid);
                $apiStatus = 'PR'; // Payment Cancelled Request Rejected

                // API calling for cab memo list
//                $curl_handle = curl_init();
//                curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."cancelGeneratePaymentLink");
//                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
//                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
//                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
//                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
//                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
//                    'application_no' => $applicationNoForApi,
//                    'api_status'     => $apiStatus
//                )));
//
//                $output = curl_exec($curl_handle);
//                curl_close($curl_handle);
//                if(trim($output)!= "y")
//                {
//                    $this->db->trans_rollback();
//                    log_message('error', '#MRAPIPULL0552: API failed in payment cancellation for case no :'. $case_no);
//                    echo json_encode([
//                        'responseType' => 1,
//                        'message' => '#MRAPIPULL0552: Enable pull request cancelled ! Kindly contact system administrator',
//                    ]);
//                    return false;
//                }

                $insPetProceed = [
                    'case_no'         => $case_no,
                    'proceeding_id'   => $proceeding_id + 1,
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'note_on_order' => $remark,
                    'status'        => 'PR', // Payment Cancelled Request Rejected
                    'user_code'     => $this->session->userdata('user_code'),
                    'date_entry'    => date('Y-m-d h:i:s'),
                    'operation'     => 'E',
                    'ip'            => $this->utilityclass->get_client_ip(),
                    'office_from'   => $user_desig_code,
                    'office_to'     => 'CO',
                    'task'          => 'Payment Notice Cancel Request Rejected',
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                if ($insertProceeding != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#MRPULL000580: Insertion failed in settlement_proceeding for case no :'. $case_no);
                    echo json_encode([
                        'responseType' => 1,
                        'message' => '#MRPULL000580: Enable pull request cancelled ! Kindly contact system administrator',
                    ]);
                    return false;
                }
            }

            $this->db->trans_commit();
            echo json_encode([
                'responseType' => 2,
                'message' => 'Modification request successfully rejected',
            ]);
            return false;
        }
    }


    // Forward modification request to DC
    public function modificationRequestForwardToDC()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[2]|max_length[3000]');
        $this->form_validation->set_rules('caseNo',   'Case No', 'trim|required');
        $this->form_validation->set_rules('requestId', 'Request details', 'trim|required|is_natural_no_zero');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL0001292: Forwarded request cancelled...! case no missing/No Remarks ',
            ]);
            return false;
        }
        $dist_code       = $this->session->userdata('dist_code');
        $user_code       = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $case_no         = trim($this->input->post('caseNo'));
        $req_id          = trim($this->input->post('requestId'));
        $remark          = trim($this->input->post('remarks'));
        if($case_no == NULL OR $req_id == NULL OR $remark == NULL)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL0001305: Forwarded request cancelled...! case no missing/No Remarks ',
            ]);
            return false;
        }
        $userAccess = [MB_ADD_DEPUTY_COMM,MB_SUB_DIV_COMM];
        if(!in_array($user_desig_code,$userAccess))
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL0001315: You are not authorized for this process.! ',
            ]);
            return false;
        }
        $caseDetails  = $this->NcCommonModel->getSettlementAppDetailsByCaseNo($case_no);
        $service_code = trim($caseDetails->service_code);
        if(trim($caseDetails->pull_request) != 1)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL0001325: Modification request already processed ',
            ]);
            return false;
        }
        if(! in_array($caseDetails->service_code, NC_MODIFICATION_REQUEST_SERVICE_CODE))
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL0001325: You are not authorized for this Application ',
            ]);
            return false;
        }
        if(in_array($caseDetails->status,[MB_DISMISS,MB_FINAL]))
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL0001130: Case already processed ',
            ]);
            return false;
        }
        $requested = $this->NcPullModel->getModificationRequestCaseDetailsForCommon
        ($req_id,$dist_code,$service_code,$case_no,$user_desig_code);
        if($requested->num_rows() == 0)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL0001336: Case not found ! ',
            ]);
            return false;
        }

        $this->db->trans_begin();
        if($user_desig_code == MB_ADD_DEPUTY_COMM)
        {
            $updateReq = [
                'adc_user_code' => $user_code,
                'adc_remarks'   => $remark,
                'pending_request_officer' => MB_DEPUTY_COMM,
            ];
        }
        if($user_desig_code == MB_SUB_DIV_COMM)
        {
            $updateReq = [
                'adc_user_code' => $user_code,
                'adc_remarks'   => $remark,
                'pending_request_officer' => MB_DEPUTY_COMM,
            ];
        }

        $this->db->where('id',$req_id);
        $this->db->where('nc',1);
        $this->db->update('settlement_pull_request',$updateReq);
        if($this->db->affected_rows() !=1){
            log_message('error', '#MRPULL001365: updating  failed in settlement_pull_request and query is: ' . $this->db->last_query());
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL001365: Forwarded request cancelled ! Kindly contact system administrator',
            ]);
            return false;
        }


        //////proceeding start//////
        $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        if ($proceeding_id==null) {
            $proceeding_id=1;
        }

        $insPetProceed = [
            'case_no'              => $case_no,
            'proceeding_id'        => $proceeding_id,
            'date_of_hearing'      => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'note_on_order'        => $remark,
            'status'               => 'MR',
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d h:i:s'),
            'operation'            => 'E',
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => $user_desig_code,
            'office_to'            => MB_DEPUTY_COMM,
            'task'                 => 'Modification Request Forwarded To DC'
        ];
        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
        if ($insertProceeding != 1) {
            $this->db->trans_rollback();
            log_message('error', '#MRPULL0001400: Insertion failed in settlement_proceeding for case no :'. $case_no);
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL0001400: Forwarded request cancelled ! Kindly contact system administrator',
            ]);
            return false;
        }
        //////proceeding end//////


        if($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL0001413: Something went wrong ! Kindly contact system administrator',
            ]);
            return false;
        }
        else
        {
            $this->db->trans_commit();
            echo json_encode([
                'responseType' => 2,
                'message' => 'Modification request successfully Forwarded',
            ]);
            return false;
        }

    }


    // modification request accept by SDO/ADC only
    public function modificationRequestAcceptByAdcSdo()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[2]|max_length[3000]');
        $this->form_validation->set_rules('caseNo',   'Case No', 'trim|required');
        $this->form_validation->set_rules('requestId', 'Request details', 'trim|required|is_natural_no_zero');

        if ($this->form_validation->run() == FALSE)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL0001443: Accept request cancelled...! case no missing/No Remarks',
            ]);
            return false;
        }

        $dist_code       = $this->session->userdata('dist_code');
        $user_code       = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');
        $case_no         = trim($this->input->post('caseNo'));
        $req_id          = trim($this->input->post('requestId'));
        $remark          = trim($this->input->post('remarks'));

        if($case_no == NULL OR $req_id == NULL OR $remark == NULL)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL0001461: Accept request cancelled...! case no missing/No Remarks ',
            ]);
            return false;
        }

        $caseDetails  = $this->NcCommonModel->getSettlementAppDetailsByCaseNo($case_no);
        $service_code = trim($caseDetails->service_code);
        if(trim($caseDetails->pull_request) != 1)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL0001471: Modification request already processed ',
            ]);
            return false;
        }
        if(in_array($caseDetails->status,[MB_DISMISS,MB_FINAL]))
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL0001175: Case already processed ',
            ]);
            return false;
        }
        if(! in_array($caseDetails->service_code, NC_MODIFICATION_REQUEST_SERVICE_CODE))
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL0001325: You are not authorized for this Application ',
            ]);
            return false;
        }
        $requested = $this->NcPullModel->getModificationRequestCaseDetailsForCommon($req_id,$dist_code,$service_code,$case_no,$user_desig_code);
        if($requested->num_rows() == 0)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL0001482: Case not found ! ',
            ]);
            return false;
        }
        $getProposalID    = '';
        $acceptButtAccess = 0;
        $deleteProCase    = 0;
        $userAccess = [MB_ADD_DEPUTY_COMM,MB_SUB_DIV_COMM];

        if($user_desig_code == MB_DEPUTY_COMM)
        {
            $this->acceptModificationRequestForDcOnly($case_no,$req_id,$remark);
        }
        elseif(in_array($user_desig_code,$userAccess))
        {
            $caseIdSdlacProposal = $this->NcCommonModel->countSettlementApplicationByCaseNoInSdlacProList($case_no);
            if($caseIdSdlacProposal != 0)
            {
                if(trim($caseDetails->pending_officer) == $user_desig_code)
                {
                    $getProposalID   = $this->NcPullModel->getSettlementProposalCaseDetailsByCaseNoPull($case_no);
                    $proposalDetails = $this->NcPullModel->getProposalDetailsByProIdPull(trim($getProposalID->proposal_id));
                    if(trim($proposalDetails->proposal_meeting_id) != '')
                    {
                        $caseInMeeting = $this->NcPullModel->countMeetingDetailByMeetingIDPull(trim($proposalDetails->proposal_meeting_id));
                        if($caseInMeeting != 0)
                        {
                            $acceptButtAccess = 0;
                        }
                        else
                        {
                            $acceptButtAccess = 1;
                            $deleteProCase    = 1;
                        }
                    }
                    else
                    {
                        $acceptButtAccess = 1;
                        $deleteProCase    = 1;
                    }
                }
            }
            else
            {
                $acceptButtAccess = 1;
                $deleteProCase    = 0;
            }
            if($acceptButtAccess == 0)
            {
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRPULL0001508: Case already map with meeting ! Only DC can accept this request',
                ]);
                return false;
            }
            if(trim($caseDetails->pending_officer) == 'CO' && trim($caseDetails->status == 'N'))
            {
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRPULL0001700: You are not authorized for this process! ',
                ]);
                return false;
            }

            $this->db->trans_begin();

            $updateReq = [
                'final_status'     => MODIFICATION_REQUEST_APPROVED,
                'approved_by'      => $user_desig_code,
                'approved_by_uc'   => $user_code,
                'approve_date'     => date('Y-m-d H:i:s'),
                'approved_remarks' => $remark,
                'pending_request_officer' => '',
            ];

            $this->db->where('id',$req_id);
            $this->db->where('nc',1);
            $this->db->update('settlement_pull_request',$updateReq);
            if($this->db->affected_rows() !=1){
                log_message('error', '#MRPULL001531: updating  failed in settlement_pull_request and query is: ' . $this->db->last_query());
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRPULL001531: Accept request cancelled ! Kindly contact system administrator',
                ]);
                return false;
            }

            // delete proposal cases from settlement_proposal_cases table
            if($deleteProCase == 1)
            {
                $deleteCase = $this->NcPullModel->getSettlementProposalCaseDetailsByCaseNo($case_no);
                if($deleteCase->id != $getProposalID->id)
                {
                    echo json_encode([
                        'responseType' => 1,
                        'message' => '#MRPULL0001605: Proposal case no. not match ! Kindly contact system administrator',
                    ]);
                    return false;
                }
                $insertIntoDeletedTable = array(
                    'proposal_id' => trim($getProposalID->proposal_id),
                    'case_no'     => $deleteCase->case_no,
                    'status'      => $deleteCase->status,
                    'ip'          => $deleteCase->ip,
                    'created_at'  => $deleteCase->created_at,
                    'updated_at'  => $deleteCase->updated_at,
                    'co_submit'   => $deleteCase->co_submit,
                    'deleted_by'  => $this->session->userdata('user_code'),
                );

                $insertDeleteData = $this->db->insert('settlement_proposal_cases_deleted', $insertIntoDeletedTable);
                if($insertDeleteData != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERMR001633: Insertion failed in settlement_proposal_cases_deleted for case no :'. $case_no);
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#ERMR001633: Application unable to Revert ! Kindly contact system administrator',

                    ));
                    return false;
                }
                $deleteProCase = $this->NcCommonModel->deleteSettlementProposalCaseDetailsById($deleteCase->id);
                if($deleteProCase != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERMR001645: Deletion failed in settlement_proposal_cases for case no :'. $case_no);
                    echo json_encode(array(
                        'responseType' => 1,
                        'message'  => '#ERMR001645: Accept request cancelled ! Kindly contact system administrator',

                    ));
                    return false;
                }
            }

            $basicArray = [
                'pull_request'    => 0,
                'status'          => MB_REVERT,
                'pending_office'  => MB_CIRCLE_OFFICER,
                'pending_officer' => MB_CIRCLE_OFFICER,
                'from_office'     => $user_desig_code,
                'dc_proceeding'   => 0,
                'dept_vgr_revert' => 0,
            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $basicArray);
            if($this->db->affected_rows() !=1)
            {
                log_message('error', '#MRPULL0001552: Updating failed in settlement_basic and query is: ' . $this->db->last_query());
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRPULL0001552: Accept request cancelled ! Kindly contact system administrator',
                ]);
                return false;
            }


            //////proceeding start//////
            $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
            if ($proceeding_id==null) {
                $proceeding_id=1;
            }

            $insPetProceed = [
                'case_no'              => $case_no,
                'proceeding_id'        => $proceeding_id,
                'date_of_hearing'      => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_on_order'        => $remark,
                'status'               => 'MR',
                'user_code'            => $this->session->userdata('user_code'),
                'date_entry'           => date('Y-m-d h:i:s'),
                'operation'            => 'E',
                'ip'                   => $this->utilityclass->get_client_ip(),
                'office_from'          => $user_desig_code,
                'office_to'            => MB_CIRCLE_OFFICER,
                'task'                 => 'Modification Request Accepted'

            ];
            $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

            if ($insertProceeding != 1) {
                $this->db->trans_rollback();
                log_message('error', '#MRPULL0001587: Insertion failed in settlement_proceeding for case no :'. $case_no);
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRPULL0001587: Accept request cancelled ! Kindly contact system administrator',
                ]);
                return false;
            }

            $insPetProceed2 = [
                'case_no'              => $case_no,
                'proceeding_id'        => $proceeding_id + 1,
                'date_of_hearing'      => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_on_order'        => $remark,
                'status'               => MB_REVERT,
                'user_code'            => $this->session->userdata('user_code'),
                'date_entry'           => date('Y-m-d h:i:s'),
                'operation'            => 'E',
                'ip'                   => $this->utilityclass->get_client_ip(),
                'office_from'          => $user_desig_code,
                'office_to'            => MB_CIRCLE_OFFICER,
                'task'                 => 'Reverted to CO'

            ];
            $insertProceeding2 = $this->db->insert('settlement_proceeding', $insPetProceed2);

            if ($insertProceeding2 != 1) {
                $this->db->trans_rollback();
                log_message('error', '#MRPULL0001615: Insertion failed in settlement_proceeding for case no :'. $case_no);
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRPULL0001615: Accept request cancelled ! Kindly contact system administrator',
                ]);
                return false;
            }
            //////proceeding end//////

            // API Calling
            $application_no = trim($caseDetails->applid);
            $rmk    = 'Reverted by '.$user_desig_code;
            $status = 'M';
            $task   = $user_desig_code;
            $pen    = MB_CIRCLE_OFFICER;
            $case   = $case_no;
            $rtps_status=$this->NcApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);$rtps_status=json_decode($rtps_status);
            if(trim($rtps_status)!="y")
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error #MRAPI0001633: Accept Modification Request & Reverted by ADC/SDO failed case no # $case_no");
                redirect(base_url() . "index.php/home");
            }

            if($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRPULL0001642: Something went wrong ! Kindly contact system administrator',
                ]);
                return false;
            }
            else
            {
                $this->db->trans_commit();
                echo json_encode([
                    'responseType' => 2,
                    'message' => 'Modification request successfully Accepted',
                ]);
                return false;
            }
        }
        else
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL0001660: You are not authorized for this process! ',
            ]);
            return false;
        }
    }


    // ------------ common -------------------------








    // Modification Request For DC
    //----------------------------------------------------


    // get all modification requested case list by CO for Dc
    public function getAllModificationRequestApplicationByCoForDc()
    {

        $data['select_data'] = $this->NcPullModel->locationSelectPullRequestWithOutStatusDC();
        $data['application'] = 1;

        $data['_view'] = 'NcVillageService/NcPullRequest/modification_requested_by_co_list_for_dc';
        $this->load->view('layouts/main', $data);

    }


    // Pagination for get all rejected application by CO for Dc
    public function paginationForModificationRequestApplicationByCoForDc()
    {
        $dist_code = $this->session->userdata('dist_code');
        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order  = $this->input->post('order');
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
            $dir = 'desc';
        }

        $valid_columns = array(
            0 => 'case_no',
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

        if (!empty($is_cat)) {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }

        $this->db->limit($length, $start);

        $this->db->where('a.dist_code', $dist_code);
        $this->db->where('a.pull_request',1);
        $this->db->where_not_in('a.status',[MB_DISMISS,MB_FINAL]);
        $this->db->where('settlement_pull_request.final_status', MODIFICATION_REQUEST_PENDING);
        $this->db->where('settlement_pull_request.pending_request_officer', MB_DEPUTY_COMM);
        $this->db->where('settlement_pull_request.nc', 1);
        $this->db->select('distinct(a.case_no), a.applid, a.dist_code, a.subdiv_code, 
        a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code,
        a.date_entry,a.pull_request,a.status,a.pending_officer,
        settlement_pull_request.final_status,settlement_pull_request.pending_request_officer');
        $this->db->from('settlement_basic a');
        $this->db->join('settlement_pull_request', 'a.case_no = settlement_pull_request.case_no');

        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $rows)
            {
                $link = '<a type="button" target="_blank" href="' . base_url() . 'index.php/NcCommonController/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn btn-primary">
                        <i class="fa fa-eye"></i> View Case</a>
                        
                        <a type="button" target="_blank" href="' . base_url() . 'index.php/NcModification/getModificationRequestApplicationDetailsForDc/?case=' . $rows->case_no . '" class="lmreportmut btn btn-success">
                        <i class="fa fa-step-forward"></i> Process</a>
               ';


                $json[] = array(
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                    '<p><span style="font-size:14px;"><strong>Mouza :</strong> ' . $this->ncutility->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code) . ',
                         <strong>Lot :</strong> ' . $this->ncutility->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no) . ',
                        </p><p style="line-height: 1px; font-size:14px;"><strong>Village :</strong> ' . $this->ncutility->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code) . '</span></p>',


                    ($link),

                );
            }

            $this->db->select('distinct(a.case_no), a.applid, a.dist_code, a.subdiv_code, 
            a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code,
            a.date_entry,a.pull_request,a.status,a.pending_officer,
            settlement_pull_request.final_status,settlement_pull_request.pending_request_officer');
            $this->db->join('settlement_pull_request', 'a.case_no = settlement_pull_request.case_no');
            $this->db->where('a.dist_code', $dist_code);
            $this->db->where('a.pull_request',1);
            $this->db->where_not_in('a.status',[MB_DISMISS,MB_FINAL]);
            $this->db->where('settlement_pull_request.final_status', MODIFICATION_REQUEST_PENDING);
            $this->db->where('settlement_pull_request.pending_request_officer', MB_DEPUTY_COMM);
            $this->db->where('settlement_pull_request.nc', 1);

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


    // get modification requested case status details Dc
    public function getModificationRequestApplicationDetailsForDc()
    {
        $dist_code       = $this->session->userdata('dist_code');
        $user_code       = $this->session->userdata('user_code');
        $user_desig_code = $this->session->userdata('user_desig_code');

        $case_no = trim($this->input->get('case'));
        if($case_no == '')
        {
            $this->session->set_flashdata('message', " Case Number not found ! ");
            redirect(base_url() . 'index.php/Home/index');
        }
        $caseCount = $this->NcCommonModel->countSettlementAppDetailsByCaseNo($case_no);
        if($caseCount == 0)
        {
            $this->session->set_flashdata('message', " Case not found ! ");
            redirect(base_url() . 'index.php/Home/index');
        }
        else
        {
            $caseDetails = $this->NcCommonModel->getSettlementAppDetailsByCaseNo($case_no);
            $service_code = trim($caseDetails->service_code);
            if(trim($caseDetails->pull_request) != 1)
            {
                $this->session->set_userdata('message', "Modification request already processed ! ");
                redirect(base_url().'index.php/NcModification/getAllModificationRequestApplicationByCoForDc?service='.$service_code);
            }

            $requested = $this->NcPullModel->getModificationRequestCaseDetailsForDc($dist_code,$service_code,$case_no);
            if($requested->num_rows() == 0)
            {
                $this->session->set_flashdata('message', " Case not found ! ");
                redirect(base_url() . 'index.php/Home/index');
            }

            $caseInProposal  = 0;
            $caseInMeeting   = 0;
            $getProposalID   = '';
            $proposalDetails = '';
            $meetingDetails  = '';
            $caseIdSdlacProposal = $this->NcCommonModel->countSettlementApplicationByCaseNoInSdlacProList($case_no);
            if($caseIdSdlacProposal != 0)
            {
                $caseInProposal  = 1;
                $getProposalID   = $this->NcPullModel->getSettlementProposalCaseDetailsByCaseNoPull($case_no);
                $proposalDetails = $this->NcPullModel->getProposalDetailsByProIdPull(trim($getProposalID->proposal_id));
                if(trim($proposalDetails->proposal_meeting_id) != '')
                {
                    $caseInMeeting   = $this->NcPullModel->countMeetingDetailByMeetingIDPull(trim($proposalDetails->proposal_meeting_id));
                    if($caseInMeeting != 0)
                    {
                        $caseInMeeting = 1;
                        $meetingDetails  = $this->NcPullModel->getMeetingDetailByMeetingIDPull(trim($proposalDetails->proposal_meeting_id));
                    }
                }
            }

            if($service_code == NC_KHAS_LAND_ID)
            {
                $data['service_name'] = $this->lang->line('ncKhasLandTitle');
            }
            elseif($service_code == NC_CULTIVATOR_ID)
            {
                $data['service_name'] = $this->lang->line('ncCultivatorTitle');
            }
            elseif($service_code == NC_TRIBAL_ID)
            {
                $data['service_name'] = $this->lang->line('ncTribalTitle');
            }

            $data['requestedDetails']  = $requested->row();
            $data['basic']             = $caseDetails;
            $data['caseInProposal']    = $caseInProposal;
            $data['caseInMeeting']     = $caseInMeeting;
            $data['proposalDetails']   = $proposalDetails;
            $data['proposalCaseD']     = $getProposalID;
            $data['meetingDetails']    = $meetingDetails;

            $data['_view'] = 'NcVillageService/NcPullRequest/modification_requested_case_details_for_dc';
            $this->load->view('layouts/main', $data);
        }
    }


    // Accept modification request by DC only
    public function acceptModificationRequestForDcOnly($case_no,$req_id,$remark)
    {
        $case_no = trim($case_no);
        $req_id  = trim($req_id);
        $remark  = trim($remark);
        if($case_no == '' OR $req_id == '' OR $remark == '')
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL0002396: Accept request cancelled...! case no missing/No Remarks ',
            ]);
            return false;
        }

        $dist_code       = $this->session->userdata('dist_code');
        $user_code       = $this->session->userdata('user_code');
        $process         = 1;
        $user_desig_code = $this->session->userdata('user_desig_code');
        $caseDetails     = $this->NcCommonModel->getSettlementAppDetailsByCaseNo($case_no);
        $service_code    = trim($caseDetails->service_code);
        if(trim($caseDetails->pull_request) != 1)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL0002417: Modification request already processed ',
            ]);
            return false;
        }
        if(! in_array($service_code, NC_MODIFICATION_REQUEST_SERVICE_CODE))
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL0001325: You are not authorized for this Application ',
            ]);
            return false;
        }
        if(in_array($caseDetails->status,[MB_DISMISS,MB_FINAL]))
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL0002418: Case already processed ',
            ]);
            return false;
        }
        $requested = $this->NcPullModel->getModificationRequestCaseDetailsForCommon($req_id,$dist_code,$service_code,$case_no,$user_desig_code);
        if($requested->num_rows() == 0)
        {
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL0002443: Case not found ! Kindly contact system administrator',
            ]);
            return false;
        }

        $insertInProCnN = 0;
        $this->db->trans_begin();

        $caseIdSdlacProposal = $this->NcCommonModel->countSettlementApplicationByCaseNoInSdlacProList($case_no);
        if($caseIdSdlacProposal != 0)
        {
            $getProposalID   = $this->NcPullModel->getSettlementProposalCaseDetailsByCaseNoPull($case_no);
            $proposalDetails = $this->NcPullModel->getProposalDetailsByProIdPull(trim($getProposalID->proposal_id));
            if(trim($proposalDetails->proposal_meeting_id) != '')
            {
                $caseInMeeting = $this->NcPullModel->countMeetingDetailByMeetingIDPull(trim($proposalDetails->proposal_meeting_id));
                if($caseInMeeting == 0)
                {
                    echo json_encode([
                        'responseType' => 1,
                        'message' => '#MRPULL0002425: Accept request cancelled...! Case pending with'.$caseDetails->pending_office,
                    ]);
                    return false;
                }
                else
                {
                    $meetingDetails  = $this->NcPullModel->getMeetingDetailByMeetingIDPull(trim($proposalDetails->proposal_meeting_id));
                    if($meetingDetails->digital_sign_status == 0)
                    {
                        if(trim($caseDetails->pending_officer) == 'CO' && (trim($caseDetails->status == 'N') || trim($caseDetails->status == 'M')))
                        {
                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#MRPULL0002595: Accept request cancelled ! Digital Sign not done yet ! ',
                            ]);
                            return false;
                        }
                        if(trim($caseDetails->pending_officer) == 'DPT')
                        {
                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#MRPULL0002604: Accept request cancelled ! Digital Sign not done yet ! ',
                            ]);
                            return false;
                        }

                        $updateReq = [
                            'final_status'     => MODIFICATION_REQUEST_APPROVED,
                            'approved_by'      => $user_desig_code,
                            'approved_by_uc'   => $user_code,
                            'approve_date'     => date('Y-m-d H:i:s'),
                            'approved_remarks' => $remark,
                            'pending_request_officer' => '',
                        ];

                        $this->db->where('id',$req_id);
                        $this->db->where('nc',1);
                        $this->db->update('settlement_pull_request',$updateReq);
                        if($this->db->affected_rows() !=1){
                            log_message('error', '#MRPULL002472: updating  failed in settlement_pull_request and query is: ' . $this->db->last_query());
                            $this->db->trans_rollback();
                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#MRPULL002472: Accept request cancelled ! Kindly contact system administrator',
                            ]);
                            return false;
                        }

                        $basicArray = [
                            'pull_request'    => 0,
                            'status'          => MB_REVERT,
                            'pending_office'  => MB_CIRCLE_OFFICER,
                            'pending_officer' => MB_CIRCLE_OFFICER,
                            'from_office'     => $user_desig_code,
                            'dc_proceeding'   => 0,
                            'dept_vgr_revert' => 0,
                        ];

                        $this->db->where('case_no', $case_no);
                        $this->db->update('settlement_basic', $basicArray);
                        if($this->db->affected_rows() !=1)
                        {
                            log_message('error', '#MRPULL0002493: Updating failed in settlement_basic and query is: ' . $this->db->last_query());
                            $this->db->trans_rollback();
                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#MRPULL0002493: Accept request cancelled ! Kindly contact system administrator',
                            ]);
                            return false;
                        }

                        // delete proposal cases from settlement_proposal_cases table
                        $deleteCase = $this->NcCommonModel->getSettlementProposalCaseDetailsByCaseNoModification($case_no);
                        if($deleteCase->id != $getProposalID->id)
                        {
                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#MRPULL0002505: Proposal case no. not match ! Kindly contact system administrator',
                            ]);
                            return false;
                        }
                        $insertIntoDeletedTable = array(
                            'proposal_id' => trim($getProposalID->proposal_id),
                            'case_no'     => $deleteCase->case_no,
                            'status'      => $deleteCase->status,
                            'ip'          => $deleteCase->ip,
                            'created_at'  => $deleteCase->created_at,
                            'updated_at'  => $deleteCase->updated_at,
                            'co_submit'   => $deleteCase->co_submit,
                            'deleted_by'  => $this->session->userdata('user_code'),
                        );

                        $insertDeleteData = $this->db->insert('settlement_proposal_cases_deleted', $insertIntoDeletedTable);
                        if($insertDeleteData != 1)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#ERMR002526: Insertion failed in settlement_proposal_cases_deleted for case no :'. $case_no);
                            echo json_encode(array(
                                'responseType' => 1,
                                'message'  => '#ERMR002526: Application unable to Revert ! Kindly contact system administrator',
                            ));
                            return false;
                        }
                        $deleteProCase = $this->NcCommonModel->deleteSettlementProposalCaseDetailsById($deleteCase->id);
                        if($deleteProCase != 1)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#ERMR002537: Deletion failed in settlement_proposal_cases for case no :'. $case_no);
                            echo json_encode(array(
                                'responseType' => 1,
                                'message'  => '#ERMR002537: Accept request cancelled ! Kindly contact system administrator',
                            ));
                            return false;
                        }

                        //////proceeding start//////
                        $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                        if ($proceeding_id==null)
                        {
                            $proceeding_id=1;
                        }
                        $insPetProceed = [
                            'case_no'              => $case_no,
                            'proceeding_id'        => $proceeding_id,
                            'date_of_hearing'      => date('Y-m-d h:i:s'),
                            'next_date_of_hearing' => date('Y-m-d h:i:s'),
                            'note_on_order'        => $remark,
                            'status'               => 'MR',
                            'user_code'            => $this->session->userdata('user_code'),
                            'date_entry'           => date('Y-m-d h:i:s'),
                            'operation'            => 'E',
                            'ip'                   => $this->utilityclass->get_client_ip(),
                            'office_from'          => $user_desig_code,
                            'office_to'            => MB_CIRCLE_OFFICER,
                            'task'                 => 'Modification Request Accepted'

                        ];
                        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                        if ($insertProceeding != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#MRPULL0002571: Insertion failed in settlement_proceeding for case no :'. $case_no);
                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#MRPULL0002571: Accept request cancelled ! Kindly contact system administrator',
                            ]);
                            return false;
                        }

                        $insPetProceed2 = [
                            'case_no'              => $case_no,
                            'proceeding_id'        => $proceeding_id + 1,
                            'date_of_hearing'      => date('Y-m-d h:i:s'),
                            'next_date_of_hearing' => date('Y-m-d h:i:s'),
                            'note_on_order'        => $remark,
                            'status'               => MB_REVERT,
                            'user_code'            => $this->session->userdata('user_code'),
                            'date_entry'           => date('Y-m-d h:i:s'),
                            'operation'            => 'E',
                            'ip'                   => $this->utilityclass->get_client_ip(),
                            'office_from'          => $user_desig_code,
                            'office_to'            => MB_CIRCLE_OFFICER,
                            'task'                 => 'Reverted to CO'

                        ];
                        $insertProceeding2 = $this->db->insert('settlement_proceeding', $insPetProceed2);
                        if ($insertProceeding2 != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#MRPULL0002599: Insertion failed in settlement_proceeding for case no :'. $case_no);
                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#MRPULL0002599: Accept request cancelled ! Kindly contact system administrator',
                            ]);
                            return false;
                        }
                        //////proceeding end//////

                        // API Calling
                        $application_no = trim($caseDetails->applid);
                        $rmk    = 'Reverted by '.$user_desig_code;
                        $status = 'M';
                        $task   = $user_desig_code;
                        $pen    = MB_CIRCLE_OFFICER;
                        $case   = $case_no;
                        $rtps_status=$this->NcApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);$rtps_status=json_decode($rtps_status);
                        if(trim($rtps_status)!="y")
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #MRAPI0002617: Accept Modification Request & Reverted by ADC/SDO failed case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        }
                        if($this->db->trans_status() === FALSE)
                        {
                            $this->db->trans_rollback();
                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#MRPULL0002625: Something went wrong ! Kindly contact system administrator',
                            ]);
                            return false;
                        }
                        else
                        {
                            $process = 1;
                        }
                    }
                    elseif($meetingDetails->digital_sign_status == 1)
                    {
                        //  if(trim($caseDetails->pending_office) == 'CO' AND trim($caseDetails->from_office) == 'DPT')
                        //  {
                        //      echo json_encode([
                        //          'responseType' => 1,
                        //          'message' => '#MRPULL0002648: Accept request cancelled ! Case Approved by Department ',
                        //      ]);
                        //      return false;
                        //  }
                        //  if(trim($caseDetails->dept_approval) == 'Y')
                        //  {
                        //      echo json_encode([
                        //          'responseType' => 1,
                        //          'message' => '#MRPULL0002650: Accept request cancelled ! Case Approved by Department ',
                        //      ]);
                        //      return false;
                        //  }

                        if(trim($caseDetails->pending_office) == 'DPT')
                        {
                            // API calling for cab memo list
//                            $curl_handle = curl_init();
//                            curl_setopt($curl_handle, CURLOPT_URL, 'https://basundhara.assam.gov.in/ilrms/index.php/DepartmentApi/pullRequestUpdateIlrms');
//                            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
//                            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
//                            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
//                            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
//                            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
//                                'dist_code' => $dist_code,
//                                'case_no'   => $case_no,
//                            )));
//                            $output = curl_exec($curl_handle);
//                            if(isset(json_decode($output)->responseType)){
//                                if(json_decode($output)->responseType == 3){
//                                    echo json_decode($output)->data." - Unauthorized access!";
//                                    return false;
//                                }
//                            }
//                            curl_close($curl_handle);
//                            $ilrms_status = json_decode($output);
//
//                            if(trim($ilrms_status->result)!= "Y")
//                            {
//                                $this->db->trans_rollback();
//                                echo json_encode([
//                                    'responseType' => 1,
//                                    'message' => '#MRPULL0002680: Accept request cancelled ! Case Approved by Department',
//                                ]);
//                                return false;
//                            }
                        }

                        $updateReq = [
                            'final_status'     => MODIFICATION_REQUEST_APPROVED,
                            'approved_by'      => $user_desig_code,
                            'approved_by_uc'   => $user_code,
                            'approve_date'     => date('Y-m-d H:i:s'),
                            'approved_remarks' => $remark,
                            'pending_request_officer' => '',
                        ];

                        $this->db->where('id',$req_id);
                        $this->db->where('nc',1);
                        $this->db->update('settlement_pull_request',$updateReq);
                        if($this->db->affected_rows() != 1){
                            log_message('error', '#MRPULL002702: updating  failed in settlement_pull_request and query is: ' . $this->db->last_query());
                            $this->db->trans_rollback();
                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#MRPULL002702: Accept request cancelled ! Kindly contact system administrator',
                            ]);
                            return false;
                        }
                        if(trim($caseDetails->pending_officer) == 'CO' && trim($caseDetails->status == 'N'))
                        {
                            // update settlement notice table
                            $updateCaseNo = $case_no.'_1';
                            $updateSettNoticeArr = [
                                'case_no' => $updateCaseNo,
                            ];
                            $this->db->where('case_no', $case_no);
                            $this->db->where('notice_type', 'PN');
                            $this->db->update('settlement_notice', $updateSettNoticeArr);
                            if($this->db->affected_rows() !=1)
                            {
                                log_message('error', '#MRPULLN02629: Updating failed in settlement_notice and query is: ' . $this->db->last_query());
                                $this->db->trans_rollback();
                                echo json_encode([
                                    'responseType' => 1,
                                    'message' => '#MRPULLN02629: Accept request cancelled ! Kindly contact system administrator',
                                ]);
                                return false;
                            }

                            $basicArray = [
                                'pull_request'      => 0,
                                'pay_notice_gen_yn' => NULL,
                                'co_notice_link'    => NULL,
                                'status'            => MB_REVERT,
                                'pending_office'    => MB_CIRCLE_OFFICER,
                                'pending_officer'   => MB_CIRCLE_OFFICER,
                                'from_office'       => $user_desig_code,
                                'dc_proceeding'     => 0,
                            ];
                        }
                        else
                        {
                            $basicArray = [
                                'pull_request'    => 0,
                                'status'          => MB_REVERT,
                                'pending_office'  => MB_CIRCLE_OFFICER,
                                'pending_officer' => MB_CIRCLE_OFFICER,
                                'from_office'     => $user_desig_code,
                                'dc_proceeding'   => 0,
                            ];
                        }

                        $this->db->where('case_no', $case_no);
                        $this->db->update('settlement_basic', $basicArray);
                        if($this->db->affected_rows() !=1)
                        {
                            log_message('error', '#MRPULL0002723: Updating failed in settlement_basic and query is: ' . $this->db->last_query());
                            $this->db->trans_rollback();
                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#MRPULL0002723: Accept request cancelled ! Kindly contact system administrator',
                            ]);
                            return false;
                        }

                        // delete proposal cases from settlement_proposal_cases table
                        $deleteCase = $this->NcCommonModel->getSettlementProposalCaseDetailsByCaseNoModification($case_no);
                        if($deleteCase->id != $getProposalID->id)
                        {
                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#MRPULL0002734: Proposal case no. not match ! Kindly contact system administrator',
                            ]);
                            return false;
                        }
                        $insertIntoDeletedTable = array(
                            'proposal_id' => trim($getProposalID->proposal_id),
                            'case_no'     => $deleteCase->case_no,
                            'status'      => $deleteCase->status,
                            'ip'          => $deleteCase->ip,
                            'created_at'  => $deleteCase->created_at,
                            'updated_at'  => $deleteCase->updated_at,
                            'co_submit'   => $deleteCase->co_submit,
                            'deleted_by'  => $this->session->userdata('user_code'),
                        );

                        $insertDeleteData = $this->db->insert('settlement_proposal_cases_deleted', $insertIntoDeletedTable);
                        if($insertDeleteData != 1)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#ERMR002756: Insertion failed in settlement_proposal_cases_deleted for case no :'. $case_no);
                            echo json_encode(array(
                                'responseType' => 1,
                                'message'  => '#ERMR002756: Application unable to Revert ! Kindly contact system administrator',
                            ));
                            return false;
                        }
                        $deleteProCase = $this->NcCommonModel->deleteSettlementProposalCaseDetailsById($deleteCase->id);
                        if($deleteProCase != 1)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#ERMR002767: Deletion failed in settlement_proposal_cases for case no :'. $case_no);
                            echo json_encode(array(
                                'responseType' => 1,
                                'message'  => '#ERMR002767: Accept request cancelled ! Kindly contact system administrator',
                            ));
                            return false;
                        }

                        $updateMeetingID = array(
                            'digital_sign_update_status' => 1,
                        );
                        $this->db->where(['id' => $meetingDetails->id, 'dist_code' => $dist_code]);
                        $this->db->update('proposal_meeting_list', $updateMeetingID);
                        if($this->db->affected_rows() <=  0)
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#MRPULL002781: Updation failed in proposal_meeting_list '.
                                $this->db->last_query());
                            echo json_encode(array(
                                'responseType' => 1,
                                'message'      => '#MRPULL002781: Unable to update status for Resigning. 
                                        Kindly contact system administrator !!!!',
                            ));
                            return;
                        }

                        //////proceeding start//////
                        $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                        if ($proceeding_id==null)
                        {
                            $proceeding_id=1;
                        }
                        $insPetProceed = [
                            'case_no'              => $case_no,
                            'proceeding_id'        => $proceeding_id,
                            'date_of_hearing'      => date('Y-m-d h:i:s'),
                            'next_date_of_hearing' => date('Y-m-d h:i:s'),
                            'note_on_order'        => $remark,
                            'status'               => 'MR',
                            'user_code'            => $this->session->userdata('user_code'),
                            'date_entry'           => date('Y-m-d h:i:s'),
                            'operation'            => 'E',
                            'ip'                   => $this->utilityclass->get_client_ip(),
                            'office_from'          => $user_desig_code,
                            'office_to'            => MB_CIRCLE_OFFICER,
                            'task'                 => 'Modification Request Accepted'

                        ];
                        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                        if ($insertProceeding != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#MRPULL0002819: Insertion failed in settlement_proceeding for case no :'. $case_no);
                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#MRPULL0002819: Accept request cancelled ! Kindly contact system administrator',
                            ]);
                            return false;
                        }

                        $insPetProceed2 = [
                            'case_no'              => $case_no,
                            'proceeding_id'        => $proceeding_id + 1,
                            'date_of_hearing'      => date('Y-m-d h:i:s'),
                            'next_date_of_hearing' => date('Y-m-d h:i:s'),
                            'note_on_order'        => $remark,
                            'status'               => MB_REVERT,
                            'user_code'            => $this->session->userdata('user_code'),
                            'date_entry'           => date('Y-m-d h:i:s'),
                            'operation'            => 'E',
                            'ip'                   => $this->utilityclass->get_client_ip(),
                            'office_from'          => $user_desig_code,
                            'office_to'            => MB_CIRCLE_OFFICER,
                            'task'                 => 'Reverted to CO'

                        ];
                        $insertProceeding2 = $this->db->insert('settlement_proceeding', $insPetProceed2);

                        if ($insertProceeding2 != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#MRPULL0002844: Insertion failed in settlement_proceeding for case no :'. $case_no);
                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#MRPULL0002844: Accept request cancelled ! Kindly contact system administrator',
                            ]);
                            return false;
                        }
                        //////proceeding end//////

                        // API Calling
                        $application_no = trim($caseDetails->applid);
                        $rmk    = 'MODIFICATION_REQUEST: Reverted by '.$user_desig_code;
                        $status = 'M';
                        $task   = $user_desig_code;
                        $pen    = MB_CIRCLE_OFFICER;
                        $case   = $case_no;
                        $rtps_status=$this->NcApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);$rtps_status=json_decode($rtps_status);
                        if(trim($rtps_status)!="y")
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('message', "Error #MRAPI0002873: Accept Modification Request & Reverted by ADC/SDO failed case no # $case_no");
                            redirect(base_url() . "index.php/home");
                        }
                        if($this->db->trans_status() === FALSE)
                        {
                            $this->db->trans_rollback();
                            echo json_encode([
                                'responseType' => 1,
                                'message' => '#MRPULL0002873: Something went wrong ! Kindly contact system administrator',
                            ]);
                            return false;
                        }

                        $process = 1;
                    }
                    else
                    {
                        $process = 0;
                        echo json_encode([
                            'responseType' => 1,
                            'message' => '#MRPULL0002885: ---- Coming Soon ----- ',
                        ]);
                        return false;
                    }
                }
            }
        }
        else
        {
            if(trim($caseDetails->service_code) == 14)
            {
                if(trim($caseDetails->pending_office) != MB_DEPUTY_COMM)
                {
                    echo json_encode([
                        'responseType' => 1,
                        'message' => '#MRPULL0002900: Accept request cancelled...! Case pending with'.$caseDetails->pending_office,
                    ]);
                    return false;
                }

                $updateReq = [
                    'final_status'     => MODIFICATION_REQUEST_APPROVED,
                    'approved_by'      => $user_desig_code,
                    'approved_by_uc'   => $user_code,
                    'approve_date'     => date('Y-m-d H:i:s'),
                    'approved_remarks' => $remark,
                    'pending_request_officer' => '',
                ];

                $this->db->where('id',$req_id);
                $this->db->where('nc',1);
                $this->db->update('settlement_pull_request',$updateReq);
                if($this->db->affected_rows() !=1){
                    log_message('error', '#MRPULL002921: updating  failed in settlement_pull_request and query is: ' . $this->db->last_query());
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 1,
                        'message' => '#MRPULL002921: Accept request cancelled ! Kindly contact system administrator',
                    ]);
                    return false;
                }

                $basicArray = [
                    'pull_request'    => 0,
                    'status'          => MB_REVERT,
                    'pending_office'  => MB_CIRCLE_OFFICER,
                    'pending_officer' => MB_CIRCLE_OFFICER,
                    'from_office'     => $user_desig_code,
                    'dc_proceeding'   => 0,
                ];
                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_basic', $basicArray);
                if($this->db->affected_rows() !=1)
                {
                    log_message('error', '#MRPULL0002942: Updating failed in settlement_basic and query is: ' . $this->db->last_query());
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 1,
                        'message' => '#MRPULL0002942: Accept request cancelled ! Kindly contact system administrator',
                    ]);
                    return false;
                }

                //////proceeding start//////
                $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                if ($proceeding_id==null)
                {
                    $proceeding_id=1;
                }
                $insPetProceed = [
                    'case_no'              => $case_no,
                    'proceeding_id'        => $proceeding_id,
                    'date_of_hearing'      => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'note_on_order'        => $remark,
                    'status'               => 'MR',
                    'user_code'            => $this->session->userdata('user_code'),
                    'date_entry'           => date('Y-m-d h:i:s'),
                    'operation'            => 'E',
                    'ip'                   => $this->utilityclass->get_client_ip(),
                    'office_from'          => $user_desig_code,
                    'office_to'            => MB_CIRCLE_OFFICER,
                    'task'                 => 'Modification Request Accepted'

                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
                if ($insertProceeding != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#MRPULL0002976: Insertion failed in settlement_proceeding for case no :'. $case_no);
                    echo json_encode([
                        'responseType' => 1,
                        'message' => '#MRPULL0002976: Accept request cancelled ! Kindly contact system administrator',
                    ]);
                    return false;
                }

                $insPetProceed2 = [
                    'case_no'              => $case_no,
                    'proceeding_id'        => $proceeding_id + 1,
                    'date_of_hearing'      => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'note_on_order'        => $remark,
                    'status'               => MB_REVERT,
                    'user_code'            => $this->session->userdata('user_code'),
                    'date_entry'           => date('Y-m-d h:i:s'),
                    'operation'            => 'E',
                    'ip'                   => $this->utilityclass->get_client_ip(),
                    'office_from'          => $user_desig_code,
                    'office_to'            => MB_CIRCLE_OFFICER,
                    'task'                 => 'Reverted to CO'

                ];
                $insertProceeding2 = $this->db->insert('settlement_proceeding', $insPetProceed2);
                if ($insertProceeding2 != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#MRPULL0003004: Insertion failed in settlement_proceeding for case no :'. $case_no);
                    echo json_encode([
                        'responseType' => 1,
                        'message' => '#MRPULL0003004: Accept request cancelled ! Kindly contact system administrator',
                    ]);
                    return false;
                }
                //////proceeding end//////

                // API Calling
                $application_no = trim($caseDetails->applid);
                $rmk    = 'Reverted by '.$user_desig_code;
                $status = 'M';
                $task   = $user_desig_code;
                $pen    = MB_CIRCLE_OFFICER;
                $case   = $case_no;
                $rtps_status=$this->NcApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);$rtps_status=json_decode($rtps_status);
                if(trim($rtps_status)!="y")
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #MRAPI0003022: Accept Modification Request & Reverted by ADC/SDO failed case no # $case_no");
                    redirect(base_url() . "index.php/home");
                }
                if($this->db->trans_status() === FALSE)
                {
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 1,
                        'message' => '#MRPULL0003030: Something went wrong ! Kindly contact system administrator',
                    ]);
                    return false;
                }
                else
                {
                    $process = 1;
                }
            }
            else
            {
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRPULL0003043: There is some problem ! Kindly contact system administrator',
                ]);
                return false;
            }
        }

        if($process == 1)
        {
            $this->db->trans_commit();
            echo json_encode([
                'responseType' => 2,
                'message' => 'Modification request successfully Accepted',
            ]);
            return false;
        }
        else
        {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType' => 1,
                'message' => '#MRPULL0003063: Something went wrong ! Kindly contact system administrator',
            ]);
            return false;
        }

    }






    public function caseListUnderMappingLot()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        //////////////////MARKING FOR CIRCLE WISE LOT MAPPING===========
        $sql="Select user_code from loginuser_table where dist_code=? and subdiv_code=? and cir_code=? and dis_enb_option='E' and user_code like 'CO%'";
        $data=$this->db->query($sql,array($dist_code,$subdiv_code,$cir_code));
        $lot_array = array();
        if($data->num_rows()> 1){
            $sql1="Select * from user_attached_mapping where dist_code=? and subdiv_code=? and cir_code=? and user_code=? ";
            $data1=$this->db->query($sql1,array($dist_code,$subdiv_code,$cir_code,$user_code));

            foreach ($data1->result() as $key => $value) {
                $lot_array[] = $value->mouza_pargona_code.'_'.$value->lot_no;
            }
            //////////////////
        }
        $lot_string = null;
        if(!empty($lot_array) && $lot_array!=null){
            $lot_string = $this->convertLiteral($lot_array);
        }
        //log_message("error","MB: LOT STRING====FOR CIRCLE==D".$dist_code."S".$subdiv_code."C".$cir_code."==".json_encode($lot_string));
        return $lot_string;
    }



    public function convertLiteral($array) {
        $index = 0;
        $final_str = '';
        foreach($array as $a)
        {
            if ($index == 0)
                $final_str = "'".$a."'";
            else
                $final_str = $final_str.",'". $a."'";
            $index++;
        }
        return $final_str;
    }

}
