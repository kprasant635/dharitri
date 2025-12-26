<?php
class SettlementMB3Common extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('patta/pattamodel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->model('basundhara/SettlementApiModel');
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('SettlementModel/SettlementTenantModel');
        $this->load->model('rtps/rtpsmodel');
        $this->load->model('SettlementModel/SettlementVgrModel');
        $this->load->model('SettlementModel/SettlementCommonModel');
        $this->load->model('SettlementModel/SettlementKhasModel');
        $this->load->model('SettlementMb/SettlementCommonDcModel');
        $this->load->model('SettlementMb/SettlementMbModel');
        $this->load->model('UtilsModel');
        $this->load->model('basundhara/basundhara3Model');
        $this->load->model('basundhara3/reclassModel');
        $this->load->model('TeaGrant/LM/TeaGrantModel');
        $this->load->model('TeaGrant/ADC/TeaGrantAdcModel');
        $this->load->model('SettlementModel/SettlementInsModel');
        $this->load->model('NcModel/NcApiModel');
        $this->load->model('NcModel/NcCommonModel');
        $this->dbswitch();
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

    // pagination basundhara end with API -js-
    public function paginationAPI()
    {
        $service            = $this->input->post('service');
        $draw               = intval($this->input->post('draw'));
        $start              = intval($this->input->post('start'));
        $length             = intval($this->input->post('length'));
        $order              = $this->input->post('order');
        $occupation         = trim($this->input->post('occupation'));
        $searchByCol_0      = trim($this->input->post('columns')[0]['search']['value']);
        $searchByCol_1      = trim($this->input->post('columns')[1]['search']['value']);
        $is_cat             = $this->input->post('is_category');
        $is_rural           = $this->input->post('rural');

        $dist_code          = $this->session->userdata('dist_code');
        $subdiv_code        = $this->session->userdata('subdiv_code');
        $cir_code           = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no             = $this->session->userdata('lot_no');
        $ru                 = $this->session->userdata('user_desig_code');

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "lmServicewiseRecords/$service/$dist_code/$subdiv_code/$cir_code/$mouza_pargona_code/$lot_no");

        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'start'         => $start,
            'length'        => $length,
            'order'         => $order,
            'searchByCol_0' => $searchByCol_0,
            'searchByCol_1' => $searchByCol_1,
            'is_cat'        => $is_cat,
            'is_rural'      => $is_rural,
            'occupation'    => $occupation
        )));
        $result  = curl_exec($curl_handle);
        $results = json_decode($result);

        if (isset($results))
        {
            $rejected_data = $this->SettlementCommonModel->getRejectModal($service);
            $rejected_list = ($rejected_data == 'n') ? false : $rejected_data;
            $data_rows     = $results->data_results;

            foreach ($data_rows as $rows) {

                if($service == RECLASS_ID)
                {
                    $case_no = $this->utilityclass->getCaseNoByApplIdReclass((string)$dist_code, (string)$rows->application_no);
                }

                if($service == BHODDAN_SERVICE_CODE)
                {
                    $case_no = $this->utilityclass->getCaseNoByApplIdBhoodan((string)$dist_code, (string)$rows->application_no);
                }

                // $dags = $this->SettlementKhasModel->getSettlementDag($case_no);

                $chithaRemarks = 'true';
                if($chithaRemarks == true)
                {
                    $chithaFlag = '<span class="text-danger alert-danger">Yes</span>';
                }
                else
                {
                    $chithaFlag = 'No';
                }

                $reclass_link = '<a type="button" href="' . base_url() . 'index.php/ReclassSuite/reclassSuiteRegistration?app='. $this->utilityclass->encryptJwtCase($rows->application_no).'" class="lmreportmut btn-sm btn btn-primary">
              write report</a>';

                $bhoodan_link = '<a type="button" href="' . base_url() . 'index.php/BhoodanController/applicationBhoodanRegistration?app='. $this->utilityclass->encryptJwtCase($rows->application_no).'" class="lmreportmut btn-sm btn btn-primary">Write Report</a>';

                $labour_link = '<a type="button" href="' . base_url() . 'index.php/LabourLineController/applicationLabourLineLandRegistration?app='. $this->utilityclass->encryptJwtCase($rows->application_no).'" class="lmreportmut btn-sm btn btn-primary">Write Report</a>';

                $json[] = array(
                    '<span class="px-3"><strong>' . $rows->application_no . '</strong></span>',
                    $rows->date_submission,
                    $rows->applicant_occupation,
                    $rows->type,
                    '<b>'.$chithaFlag.'</b>',
                    $rows->rurban,

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_code, $rows->lot_no, $rows->village_code),

                    ($service == RECLASS_ID) ? $reclass_link : ($service == BHODDAN_SERVICE_CODE ? $bhoodan_link : ($service == SETTLEMENT_LABOUR_LAND ? $labour_link : '')),

                );
            }

            $total_records = $results->total_records;
            $response = array(
                'draw'            => $draw,
                'recordsTotal'    => $total_records,
                'recordsFiltered' => $total_records,
                'data'            => $json,
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


    public function paginationAPIforAllCasesCO()
    {
        $service            = $this->input->post('service');
        $draw               = intval($this->input->post('draw'));
        $start              = intval($this->input->post('start'));
        $length             = intval($this->input->post('length'));
        $order              = $this->input->post('order');
        $occupation         = trim($this->input->post('occupation'));
        $searchByCol_0      = trim($this->input->post('columns')[0]['search']['value']);
        $searchByCol_1      = trim($this->input->post('columns')[1]['search']['value']);
        $is_cat             = $this->input->post('is_category');
        $is_rural           = $this->input->post('rural');

        $dist_code          = $this->session->userdata('dist_code');
        $subdiv_code        = $this->session->userdata('subdiv_code');
        $cir_code           = $this->session->userdata('cir_code');
        $ru                 = $this->session->userdata('user_desig_code');

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "coAllServicewiseRecords/$service/$dist_code/$subdiv_code/$cir_code");

        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'start'         => $start,
            'length'        => $length,
            'order'         => $order,
            'searchByCol_0' => $searchByCol_0,
            'searchByCol_1' => $searchByCol_1,
            'is_cat'        => $is_cat,
            'is_rural'      => $is_rural,
            'occupation'    => $occupation
        )));
        $result  = curl_exec($curl_handle);
        $results = json_decode($result);

        if (isset($results))
        {
            $rejected_data = $this->SettlementCommonModel->getRejectModal($service);
            $rejected_list = ($rejected_data == 'n') ? false : $rejected_data;
            $data_rows     = $results->data_results;

            foreach ($data_rows as $rows) {

                if($service == RECLASS_ID)
                {
                    $case_no = $this->utilityclass->getCaseNoByApplIdReclass((string)$dist_code, (string)$rows->application_no);
                }

                else if($service == SERVICE_CONVERSION_MB3)
                {
                    $case_no = $this->utilityclass->getCaseNoByApplIdAptoPp((string)$dist_code, (string)$rows->application_no);
                }

                else
                {
                    $case_no = $this->utilityclass->getCaseNoByApplIdBhoodan((string)$dist_code, (string)$rows->application_no);
                }

                // $dags = $this->SettlementKhasModel->getSettlementDag($case_no);

                $chithaRemarks = 'true';
                if($chithaRemarks == true)
                {
                    $chithaFlag = '<span class="text-danger alert-danger">Yes</span>';
                }
                else
                {
                    $chithaFlag = 'No';
                }


                if (($rows->pending_with_officer=='NA' || $rows->pending_with_officer=='Approved' || $rows->pending_with_officer=='F') && $rows->status=='F')
                {
                    $status = 'Delivered';
                }
                else if ($rows->pending_with_officer =='NA' && $rows->status='R')
                {
                    $status = 'Rejected';
                }
                else if($rows->status=='Q'){
                    $status = 'Query Sent';
                }
                else if ($rows->pending_with_officer =='LM')
                {
                    $status = 'Pending - LRA';
                }
                else if ($rows->pending_with_officer =='CO')
                {
                    $status = 'Pending - CO';
                }
                else if ($rows->pending_with_officer =='ADC')
                {
                    $status = 'Pending - ADC';
                }
                else if ($rows->pending_with_officer =='DC')
                {
                    $status = 'Pending - DC';
                }
                else if ($rows->pending_with_officer =='JDS')
                {
                    $status = 'Pending - JDS';
                }
                else {
                    $status = 'Pending';
                }



                $reclass_link = '<a type="button" href="' . base_url() . 'index.php/SettlementMB3Common/reclassSuiteRegistrationforCaseview?app='. $this->utilityclass->encryptJwtCase($rows->application_no).'" class="lmreportmut btn-sm btn btn-primary">
              View Application</a>';

                $bhoodan_link = '<a type="button" href="' . base_url() . 'index.php/SettlementMB3Common/applicationViewCumRegistrationforAllcases?app=' .
                    $this->utilityclass->encryptJwtCase($rows->application_no) . '&service_code=' . $rows->service_code .
                    '" class="lmreportmut btn-sm btn btn-primary">View Application</a>';

                $nckhas_link = '<a type="button" href="' . base_url() . 'index.php/SettlementMB3Common/applicationViewCumRegistrationforAllcases?app=' .
                    $this->utilityclass->encryptJwtCase($rows->application_no) . '&service_code=' . $rows->service_code .
                    '" class="lmreportmut btn-sm btn btn-primary">View Application</a>';

                $aptopp_link = '<a type="button" href="' . base_url() . 'index.php/BhoodanController/applicationBhoodanRegistration?app='. $this->utilityclass->encryptJwtCase($rows->application_no).'" class="lmreportmut btn-sm btn btn-primary">Write Report</a>';

                $inst_link = '<a type="button" href="' . base_url() . 'index.php/SettlementMB3Common/applicationViewCumRegistrationforAllcases?app=' .
                    $this->utilityclass->encryptJwtCase($rows->application_no) . '&service_code=' . $rows->service_code .
                    '" class="lmreportmut btn-sm btn btn-primary">View Application</a>';

                $tea_grant_link = '<a type="button" href="' . base_url() . 'index.php/SettlementMB3Common/applicationViewCumRegistrationforAllcases?app=' .
                    $this->utilityclass->encryptJwtCase($rows->application_no) . '&service_code=' . $rows->service_code .
                    '" class="lmreportmut btn-sm btn btn-primary">View Application</a>';


                // $tenant_link = '<a type="button" href="' . base_url() . 'index.php/SettlementMB3Common/applicationViewCumRegistrationforAllcases?app='. $this->utilityclass->encryptJwtCase($rows->application_no).'" class="lmreportmut btn-sm btn btn-primary">View Application</a>';

                $tenant_link = '<a type="button" href="' . base_url() . 'index.php/SettlementMB3Common/applicationViewCumRegistrationforAllcases?app=' .
                    $this->utilityclass->encryptJwtCase($rows->application_no) . '&service_code=' . $rows->service_code .
                    '" class="lmreportmut btn-sm btn btn-primary">View Application</a>';



                $links = [
                    RECLASS_ID => $reclass_link,
                    BHODDAN_SERVICE_CODE => $bhoodan_link,
                    NC_KHAS_LAND_ID => $nckhas_link,
                    SLIJE_ID => $inst_link,
                    SERVICE_CONVERSION_MB3 => $aptopp_link,
                    TEA_SERVICE_CODE => $tea_grant_link,
                    SETTLEMENT_TENANT_URBAN_ID => $tenant_link,
                ];

                if($service == TEA_SERVICE_CODE)
                {
                    $rows->type = null;
                    $rows->applicant_occupation = null;
                }



                $json[] = array(
                    '<span class="px-3"><strong>' . $rows->application_no . '</strong></span>',
                    $rows->date_submission,
                    $rows->applicant_occupation,
                    $rows->type,
                    '<b>'.$chithaFlag.'</b>',
                    $rows->rurban,
                    '<span class="px-3"><strong>' .$status. '</strong></span>',

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_code, $rows->lot_no, $rows->village_code),

                    // (($service == RECLASS_ID) ? $reclass_link : (($service == BHODDAN_SERVICE_CODE) ? $bhoodan_link : '')),

                    $links[$service] ?? '',

                );
            }

            $total_records = $results->total_records;
            $response = array(
                'draw'            => $draw,
                'recordsTotal'    => $total_records,
                'recordsFiltered' => $total_records,
                'data'            => $json,
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




    // view Application details
    public function viewApplicationDetailsOnlyforMb3cases()
    {
        $case_no = trim($this->input->get('case'));
        $application_no = $this->input->get('case');

        $caseCount = $this->SettlementCommonDcModel->countSettlementAppDetailsByCaseNo($case_no);
        if($caseCount == 0)
        {
            $this->getCaseSearchCommon();
        }
        else
        {
            $caseDetails = $this->SettlementCommonDcModel->getSettlementAppDetailsByCaseNo($case_no);

            // khas land
            if($caseDetails->service_code == SETTLEMENT_KHAS_LAND_ID)
            {
                $proceedings = $this->SettlementCommonDcModel->getSettlementProceeding($case_no);
                $basic = $this->SettlementKhasModel->getSettlementBasic($application_no);
                $applicants_buyers = $this->SettlementKhasModel->getAllApplicantBuyers($application_no);
                $applicants_owners = $this->SettlementKhasModel->getAllApplicantOwners($application_no);
                $applicants_encroacher = $this->SettlementKhasModel->getAllApplicantEncroacher($application_no);
                $applicants_riotee_nok = $this->SettlementKhasModel->getAllApplicantRioteeNok($application_no);

                $dags = $this->SettlementKhasModel->getSettlementDag($application_no);
                $lmnotes = $this->SettlementKhasModel->getSettlementTenantLmNote($application_no);
                $dhardocuments = $this->SettlementKhasModel->getDocuments($application_no);

                $lmdata=[];
                foreach($applicants_encroacher as $encroacher)
                {
                    // getting the encroacher details
                    $query="select * from c_land_bank_encroacher_details where id=$encroacher->enc_id";
                    $encdata=$this->db->query($query)->result();
                    $lmdata[] = $encdata;

                }
                $data['encdata']=$lmdata;

                $data['basic']=$basic;

                $reservation = $this->SettlementMbModel->getSettlementReservation($application_no);
                $data['reservation']=$reservation;
                $data['applicants_buyers']=$applicants_buyers;
                $data['applicants_owners']=$applicants_owners;
                $data['applicants_encroacher']=$applicants_encroacher;
                $data['applicants_riotee_nok']=$applicants_riotee_nok;

                $data['dags']=$dags;
                $data['lmnotes']=$lmnotes;
                $data['dhardocuments']=$dhardocuments;

                // for guardian relation
                $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
                $relation_executation = $this->db->query($query_for_guar_rel);
                $row = $relation_executation->num_rows;
                if ($row != 0) {
                    $data['guar_rel'] = $relation_executation->result();
                }
                $premium_data = $this->db->query("SELECT sp.*,spa.area,spl.land_type,spr.house_type,spr.rate_type as ratetype FROM settlement_premium sp left outer join settlement_premium_area spa on spa.paid=sp.area_name left outer join settlement_premium_land_type spl on spl.plid=sp.land_type left outer join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no='$application_no' and is_final=1")->result();
                $data['premium_data'] = $premium_data;
                $data['premium'] = $this->SettlementCommonModel->getPremium($application_no);
                $data['caseCount']   = $caseCount;
                $data['caseDetails'] = $caseDetails;
                $data['proceedings'] = $proceedings;

                //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
                $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($case_no);
                $deletedEncArray = array();
                foreach($deletedEnc as $encroacherDeleted_data)
                {
                    $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
                }
                $data['deleted_encroacher'] = $deletedEncArray;


                //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
                $deletedDags=$this->SettlementCommonModel->getDeletedDags($case_no);
                $deletedData = array();
                foreach($deletedDags as $deleteDag){
                    $deletedData[] = json_decode($deleteDag->table_data);
                }
                $data['deleted_dags'] = $deletedData;
                $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_KHAS_LAND_ID);
                if($rejected_data == 'n')
                {
                    $data['rejected_list'] = false;
                }
                else
                {
                    $data['rejected_list'] = $rejected_data;
                }

                //**************new */
                foreach(json_decode(VALIDATION_BYPASS) as $val_bypas)
                {
                    if($val_bypas->SERVICE_CODE == SETTLEMENT_KHAS_LAND_ID)
                    {
                        $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
                    }
                }
                $data['validation_bypass'] = 0;

                foreach($data['lmnotes'] as $lm_rr)
                {
                    $decoded_r = json_decode($lm_rr->lm_rejected_remarks);

                    if($decoded_r){
                        foreach($decoded_r as  $lm_rejected_code)
                        {
                            if(isset($lm_rejected_code->reject_code))
                            {
                                if(in_array($lm_rejected_code->reject_code, $const_bypass_arr_code)){
                                    $data['validation_bypass'] = 1;
                                }
                            }
                            else
                            {
                                if(in_array($lm_rejected_code, $const_bypass_arr_code)){
                                    $data['validation_bypass'] = 1;
                                }
                            }

                        }
                    }

                }

                $data['reject_list_type'] = '';

                foreach($lmnotes as $r_remark)
                {
                    $rejected_list_json = json_decode($r_remark->lm_rejected_remarks);

                    if($rejected_list_json)
                    {
                        foreach ($rejected_list_json as $re_list) {

                            if(isset($re_list->reject_code))
                            {
                                $r_code = $re_list->reject_code;
                            }
                            else
                            {
                                $r_code = $re_list;
                            }

                            $sql = $this->db->query("select remark_head from reject_master where reject_code = ?", array($r_code));

                            if($sql->row()->remark_head != null)
                            {
                                $data['reject_list_type'] = 'new';
                            }
                            else
                            {
                                $data['reject_list_type'] = 'old';
                            }
                        }
                    }
                }

                $newDagCount = $this->db->query("SELECT old_dag, new_dag FROM chitha_settlement_allottee WHERE ord_no = ? 
                               GROUP BY old_dag, new_dag", array($application_no));

                if($newDagCount->num_rows()!= 0)
                {
                    $data['newDagCount'] = 1;
                    $data['newDags']     = $newDagCount->result();
                }
                else
                {
                    $data['newDagCount'] = 0;
                    $data['newDags']     = '';
                }


                $data['_view'] = 'reclass_suite/Common/application_details_common_reclass';
                $this->load->view('layouts/main', $data);
            }
        }
    }




    public function reclassSuiteRegistrationforCaseview()
    {
        $appli = $this->input->get('app'); // get rtps application no
        $application_no = $this->utilityclass->decryptJwtCase($appli);


        // get AADHAAR PHOTO (API CALL)
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "getApplicantPhoto");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application_no' => $application_no,
        )));
        $get_aadhaar_photo = curl_exec($curl_handle);
        curl_close($curl_handle);
        if ($get_aadhaar_photo != 'n') {
            $district['aadhaar_b64_decoded'] = "<img src = data:" . $this->decodeBase64($get_aadhaar_photo) . ";base64," . $get_aadhaar_photo . " class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
        }

        // check if case already registered
        $recordExist = $this->basundhara3Model->checkExistDharitree($application_no);


        if (!$recordExist) {

            // get data from basundhara end (API call)
            $token = $this->utilityclass->createTokenJwt();
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "getAppDetails");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application_no' => $application_no,
                // 'api_key' => API_KEY,
                // 'token' => $token,
            )));
            $output = curl_exec($curl_handle);
            if (isset(json_decode($output)->responseType)) {
                if (json_decode($output)->responseType == 3) {
                    echo json_decode($output)->data . " - Unauthorized access!";
                    return false;
                }
            }
            curl_close($curl_handle);
            $backup = $output;
            $output = json_decode($output);
            // echo "<pre>";
            // var_dump($output);exit;

            $app = $output->application;
            $d = $app->dist_code;
            $s = $app->subdiv_code;
            $c = $app->cir_code;
            $m = $app->mouza_code;
            $l = $app->lot_no;
            $v = $app->village_code;
            $dag = $app->dag_no;

            $case_name = $this->basundhara3Model->genearteCaseName(); // generate case name

            if (empty($case_name)) {
                log_message('error', '#ERROR0002: Case name can not be generated for application no ' . $application_no);
                $this->session->set_flashdata('error_data', "#ERROR0002: Network Issue or Session Out. Please try Again!");
                $data = array(
                    'error' => "#ERROR0002: Registration of Reclassification failed for case no : " . $application_no,
                );
                echo json_encode($data);
                exit;
            }

            //generate case no
            $case_no['petition_no'] = $petition_no = $this->basundhara3Model->geneartemb3PetitionNoReclass();
            $case_no['case_no'] = $case_name . $petition_no . "/" . RECLASS_SUITE;


            $this->db->trans_begin(); // transaction begins here

            //insert into SETTLEMENT BASIC, status=Z means very first initial insertion by LM


            $reclass_basic = [
                'dist_code' => $d,
                'subdiv_code' => $s,
                'cir_code' => $c,
                'mouza_pargona_code' => $m,
                'lot_no' => $l,
                'vill_townprt_code' => $v,
                'service_code' => RECLASS_ID,
                'ref_no' => $output->application->ref_no,
                'case_no' => $case_no['case_no'],
                'trans_code' => 'F',
                'petition_no' => $case_no['petition_no'],
                'year_no' => date('Y'),
                'date_entry' => date('Y-m-d G:i:s'),
                'status' => 'Z',
                'submission_date' => date('Y-m-d G:i:s'),
                'applid' => $application_no,
                'caste' => $output->settlements[0]->caste_category,
                'uuid' => $output->application->uuid,
                'user_code' => $this->session->userdata('user_code'),
                'pending_officer' => 'LM',
                'occupation_applicant'=>$output->settlements[0]->applicant_occupation
            ];
            $reclass_basic_insertion = $this->db->insert('reclass_suite_basic', $reclass_basic);

            if ($reclass_basic_insertion != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERROR0003: Insertion failed in reclass_basic for RTPS Case No ' . $application_no . 'and query is ' . $this->db->last_query());
                $this->session->set_flashdata('error_data', "#ERROR0003: Registration of Reclassification failed for RTPS application no : " . $application_no);
                $data = array(
                    'error' => "#ERROR0003: Registration of Reclassification failed for case no : " . $application_no,
                );
                echo json_encode($data);
                return false;
            }


            //insert into RECLASS DAG DETAILS
            if (!empty($output->settlements)) {
                foreach ($output->settlements as $dag) {

                    if($dag->is_applicant == 1)
                    {
                        $new_land_class = $this->utilityclass->getPattaTypeNo($d, $s, $c, $m, $l, $v, $dag->dag_no);

                        $prop_lc_cat_id = $this->db->query("select landclass_category_id from land_class_groups 
                        where id=?",array($dag->new_classification))->row();
                        $prop_lc_category_id = $prop_lc_cat_id->landclass_category_id;

                        // var_dump($dag->new_classification);exit;

                        $insSettlementDagDetails = [

                            'dist_code' => $d,
                            'subdiv_code' => $s,
                            'cir_code' => $c,
                            'mouza_pargona_code' => $m,
                            'lot_no' => $l,
                            'vill_townprt_code' => $v,
                            'user_code' => $this->session->userdata('user_code'),
                            'date_entry' => date('Y-m-d'),
                            'case_no' => $case_no['case_no'],
                            'petition_no' => $case_no['petition_no'],
                            'year_no' => date('Y'),
                            'operation' => 'E',
                            'proposed_land_class_code' => $dag->new_classification,
                            'land_class_code' => $new_land_class->land_class_code,
                            'dag_no' => $dag->dag_no,
                            'patta_no' => $dag->patta_no,
                            'patta_type_code' => $dag->patta_code,
                            'dag_area_b' => $dag->applied_bigha,
                            'dag_area_k' => $dag->applied_katha,
                            'dag_area_lc' => $dag->applied_lessa,
                            'dag_area_g' => $dag->applied_ganda,
                            'dag_area_kr' => $dag->applied_kranti,
                            's_dag_area_b' => $dag->mbigha,
                            's_dag_area_k' => $dag->mkatha,
                            's_dag_area_lc' => $dag->mlessa,
                            's_dag_area_g' => $dag->mganda,
                            's_dag_area_kr' => $dag->mkranti,
                            'revenue' => 0,
                            'is_urban' => $app->is_urban,
                            'is_full_partial' => $dag->is_full_partial,
                            'proposed_land_class_name' =>$dag->new_classification_name,
                            'exist_land_class_name' =>$dag->old_classification_name,
                            'prop_lc_cat_id' =>$prop_lc_category_id
                        ];
                        $reclass_dag_details = $this->db->insert('reclass_dag_details', $insSettlementDagDetails);

                        if ($reclass_dag_details != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#ERROR0005: Insertion failed in reclass_dag_details for RTPS Case No ' . $application_no . 'and query is ' . $this->db->last_query());
                            $this->session->set_flashdata('error_data', "#ERROR0005: Registration of Settlement failed for RTPS application no : " . $application_no);
                            $data = array(
                                'error' => "#ERROR0005: Registration of Settlement failed for case no : " . $application_no,
                            );
                            echo json_encode($data);
                            return false;
                        }

                        $base = array(
                            'caste' => $dag->caste_category,
                            'occupation_applicant'=>$dag->applicant_occupation
                        );

                        $this->db->where('case_no', $case_no['case_no']);
                        $this->db->update('reclass_suite_basic', $base);
                        if ($this->db->affected_rows() == 0) {
                            log_message("error", "##ERROR0005. Unable to 
                            update data into reclass_suite_basic for Case No: " . $case_no['case_no']);

                            $array = array(
                                "error" => true,
                                "msg" => "Error: [##ERROR0005].Unable to update data into reclass_suite_basic",
                            );
                            return $array;
                        }

                    }
                }
            }

            //insert into SETTLEMENT APPLICANT, main applicant/encrochers details

            if (!empty($output->settlements)) {
                foreach ($output->settlements as $appl) {

                    if ($appl->dag_no == 0 || $appl->dag_no == null || $appl->dag_no == '') {
                        $dag_no = 0;
                        $patta_no = 0;
                        $patta_type_code = 0;
                    } else {
                        $dag_no = $appl->dag_no;
                        $patta_no = $appl->patta_no;
                        $patta_type_code = $appl->patta_code;
                    }

                    if ($appl->is_applicant == 1) { // main applicant, for identity authentication
                        if ($get_aadhaar_photo != 'n') {
                            $timestamp = date('mdYhis', time()) . uniqid();
                            $identity_doc_unique_name = str_replace('/', "-", $application_no . '_' . $timestamp);
                            // creating and saving the base64 format payment notice to uploads/paymentNotice folder
                            $aadhar_path = AADHAAR_PHOTO . $identity_doc_unique_name . ".json";
                            $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file!");
                            $aadhaar_encoded_file = $get_aadhaar_photo;
                            fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                            fclose($aadhaar_file_to_write_base64);
                        } else {
                            $aadhar_path = '';
                        }
                        if ($output->aadhar->type == 'AADHAAR') {
                            $identity_ref_no = $output->aadhar->aadhaar_no;
                        } else {
                            $identity_ref_no = $output->aadhar->pan_no;
                        }
                        $identity_type = $output->aadhar->type;
                        $identity_doc_link = $aadhar_path;
                    } else {
                        $identity_ref_no = '';
                        $identity_type = '';
                        $identity_doc_link = '';
                    }

                    if($appl->gurdian_relation_id == null)
                    {
                        $pdar_rel_guar = 0;
                    }
                    else
                    {
                        $pdar_rel_guar = $appl->gurdian_relation_id;
                    }

                    $insApplicant = [
                        'dist_code' => $d,
                        'subdiv_code' => $s,
                        'cir_code' => $c,
                        'mouza_pargona_code' => $m,
                        'lot_no' => $l,
                        'vill_townprt_code' => $v,
                        'user_code' => $this->session->userdata('user_code'),
                        'case_no' => $case_no['case_no'],
                        'petition_no' => $case_no['petition_no'],
                        'operation' => 'E',
                        'dag_no' => $dag_no,
                        'patta_no' => $patta_no,
                        'patta_type_code' => $patta_type_code,
                        'year_no' => date('Y'),
                        'date_entry' => date('Y-m-d'),
                        'pdar_id' => $appl->pdar_id,
                        //'pdar_cron_no' => $cron_no,
                        'pdar_name' => $appl->name_ass,
                        'pdar_guardian' => $appl->gurdian_name_ass,
                        'pdar_rel_guar' => $appl->gurdian_relation_id,
                        'pdar_gender' => $appl->gender,
                        'pdar_add1' => $appl->per_add,
                        'pdar_add2' => $appl->pre_add,
                        'pdar_mobile' => $appl->mobile,
                        'pdar_type' => $appl->pdar_type,
                        'is_applicant' => $appl->is_applicant,
                        'marital_status' => $appl->marital_status,
                        'dob' => $appl->dob,
                        'eng_pdar_name' => $appl->name_eng,
                        'eng_pdar_guardian' => $appl->gurdian_name_eng,
                        'identity_ref_no' => $identity_ref_no,
                        'identity_type' => $identity_type,
                        'identity_doc_link' => $identity_doc_link,
                        'is_full_partial' => $appl->is_full_partial
                    ];
                    $applicantDetail = $this->db->insert('reclass_applicant', $insApplicant);

                    if ($applicantDetail != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERROR0006: Insertion failed in reclass_applicant for RTPS Case No ' . $application_no . 'and query is ' . $this->db->last_query());
                        $this->session->set_flashdata('error_data', "#ERROR0006: Registration of Settlement failed for RTPS application no : " . $application_no);

                        $data = array(
                            'error' => "#ERROR0006: Registration of Settlement failed for case no : " . $application_no,
                        );
                        echo json_encode($data);
                        return false;
                    }
                }
            }


            //insert into BASUNDHAR APPLICATION
            $basundhara = [
                'dharitree' => $case_no['case_no'],
                'basundhara' => $application_no,
                'date_reg' => date('Y-m-d'),
                'reg_by' => $this->session->userdata('user_code'),
                'app_status' => 'M',
                'pending_with' => 'LM',
            ];
            $basundhar_app = $this->db->insert('basundhar_application', $basundhara);
            if ($basundhar_app != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERROR0008: Insertion failed in Basundhara Application for RTPS Case No ' . $application_no . 'and query is ' . $this->db->last_query());
                $this->session->set_flashdata('error_data', "#ERROR0008: Registration of Settlement failed for RTPS application no : " . $application_no);
                return false;
            }

            //insert into back up file
            $backup_array = [
                'applid' => $application_no,
                'case_no' => $case_no['case_no'],
                'status' => 'I',
                'data' => $backup,
            ];
            $backup_insertion = $this->db->insert('settlement_backup_json', $backup_array);
            if ($backup_insertion != 1) {
                $this->db->trans_rollback();
                log_message('error', '#BACKUP001: Insertion failed in settlement_backup_json RTPS Case No ' . $application_no);

                $this->session->set_flashdata('error_data', "#BACKUP001: Registration of Settlement failed for case no : " . $application_no);
                redirect(base_url() . "index.php/home");
                return false;
            }


            $this->db->trans_commit(); // transaction ends here

        }


        $sql = "Select case_no from reclass_suite_basic where applid='$application_no' ";
        $case = $this->db->query($sql)->row();
        $application_no = $case->case_no;


        $basic                 = $this->reclassModel->getSettlementBasic($application_no);
        $applicants_buyers     = $this->reclassModel->getAllApplicantBuyers($application_no);
        $applicants_owners     = $this->reclassModel->getAllApplicantOwners($application_no);

        $applicants_dag_details= $this->reclassModel->getAllApplicantDagDetails($application_no);

        $lmdata        = [];

        $dags          = $this->reclassModel->getSettlementDag($application_no);
        $lmnotes       = $this->reclassModel->getSettlementTenantLmNote($application_no);
        $proceedings   = $this->reclassModel->getSettlementProceeding($application_no);
        $dhardocuments = $this->reclassModel->getDocuments($application_no);
        $nominee       = $this->reclassModel->getAllNomineeDetail($application_no);
        $existing_pattadar = $this->reclassModel->getAllExistingPattadar($application_no);
        $deed_applicant= '';//$this->reclassModel->getAllDeedPattadar($application_no);
        $family_tree   = '';//$this->reclassModel->getAllFamilyTree($application_no);

        $penalty_dags          = $this->reclassModel->getSettlementDagPenalty($application_no);

        $lmdata['basic']             = $basic;
        $lmdata['nominee']           = $nominee;
        $lmdata['applicants_buyers'] = $applicants_buyers;
        $lmdata['applicants_owners'] = $applicants_owners;

        $lmdata['existing_pattadar'] = $existing_pattadar;
        $lmdata['deed_applicant']    = $deed_applicant;
        $lmdata['family_tree']       = $family_tree;
        $lmdata['applicants_dag_details'] = $applicants_dag_details;

        $lmdata['checkAdditionalProperty'] = '';//$this->SettlementCommonModel->activeAdditionalPropertyDetailByCase($application_no)->result();

        $applid = $this->utilityclass->getApplidFromCaseNoReclass($application_no);

        foreach($lmdata['applicants_buyers'] as $adhar_photo):
            if($adhar_photo->is_applicant == 1):
                if (trim($adhar_photo->identity_type) == 'AADHAAR'):
                    $adhar_photo_link = $adhar_photo->identity_doc_link;
                    if(!file_exists($adhar_photo_link))
                    {
                        //****Directory Change */
                        $parts = explode("uploads/", $adhar_photo_link, 2);
                        if (count($parts) > 1) {
                            $path = BACKUP_DIR."uploads/" . $parts[1];
                        }
                        else
                        {
                            $path = $adhar_photo_link;
                        }

                        if(!file_exists($path))
                        {
                            $url = API_LINK_MB2."getApplicantPhoto";
                            $arrayData =array(
                                'application_no' => $applid,
                            );
                            //*****API call again for aadhar photo missing */
                            $aadhaarPhotoReCall = $this->utilityclass->curlPost($url, $arrayData);

                            if($aadhaarPhotoReCall == true)
                            {
                                $aadhar_path = $adhar_photo_link;
                                $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file!");
                                $aadhaar_encoded_file = $aadhaarPhotoReCall;
                                fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                                fclose($aadhaar_file_to_write_base64);
                            }
                            else
                            {
                                echo json_encode(array('ERROR885784: API Response fail!'));
                                return false;
                            }
                        }
                        else
                        {
                            $adhar_photo_link = $path;
                        }
                    }
                    //**********reopening the updated file */
                    $open_adhar_file = fopen($adhar_photo_link, "r") or die("Unable to open file!");
                    $read_adhar_file = fread($open_adhar_file, filesize($adhar_photo_link));
                    fclose($open_adhar_file);
                    // decoding the base64 encoding file variable
                    $lmdata['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($read_adhar_file).";base64,".$read_adhar_file." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
                endif;
            endif;
        endforeach;


        //****getting tribe cat and under tribal belt data from backup */
        $getJsonBackup = $this->reclassModel->getJsonDataFromBackup($application_no);
        // if(isset($getJsonBackup))
        // {
        //   if($getJsonBackup)
        //   {
        //     $json_settlement =  json_decode($getJsonBackup->data);

        //     foreach($json_settlement->settlements as $jsonSettle)
        //     {
        //       if($jsonSettle->is_applicant == 1)
        //       {
        //         $lmdata['backup_tribe_category'] = $jsonSettle->tribe_category;
        //         $lmdata['backup_under_tribe_belts'] = $jsonSettle->under_tribe_belts;
        //       }
        //     }
        //   }
        // }

        $lmdata['dags']          = $dags;
        $lmdata['penalty_dags']  = $penalty_dags;
        $lmdata['lmnotes']       = $lmnotes;
        $lmdata['proceedings']   = $proceedings;
        $lmdata['dhardocuments'] = $dhardocuments;

        // $premium_data = $this->db->query("SELECT * FROM settlement_premium sp where case_no='$application_no' and is_final=1")->result();

        $premium_data = $this->db->query("SELECT sp.*,spa.* FROM settlement_premium sp inner join reclass_dag_details spa on spa.dag_no=sp.dag_no and spa.case_no=sp.case_no where sp.case_no='$application_no' and is_final=1")->result();
        $lmdata['premium_data'] = $premium_data;

        $premium_data_lm = $this->db->query("SELECT * FROM settlement_premium where case_no='$application_no' and user_code like 'M%' ")->row();
        $lmdata['premium_data_lm'] = $premium_data_lm;


        $lmdata['premium']     = $this->SettlementCommonModel->getPremium($application_no);
        $lmdata['reservation'] = $this->SettlementVgrModel->getSettlementReservation($application_no);
        $lmdata['additional_property'] = $this->reclassModel->getAdditionalProperty($application_no);

        //********check if SDO exist for that area */
        $headQtrCheck = $this->SettlementCommonModel->headquarterCheck($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'));
        if(trim($headQtrCheck) != 'Y'){

            $sdoCheckResult = $this->SettlementCommonModel->userCheckSDO($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'));

            if(trim($sdoCheckResult) == 'y'){
                $lmdata['sdo_user_check'] = trim($sdoCheckResult);
            }
            else
            {
                $lmdata['sdo_user_check'] = 'No SDO created for this location...';
            }
        }
        else
        {
            $lmdata['sdo_user_check'] = 'y';
        }

        $areaModificationCheck = $this->SettlementCommonModel->checkIfAreaModified($application_no);

        if(isset($areaModificationCheck)){
            if($areaModificationCheck){
                foreach($areaModificationCheck as $areaHis){
                    $applied_area_home_bigha = $areaHis->applied_area_home_bigha;
                    $applied_area_home_katha = $areaHis->applied_area_home_katha;
                    $applied_area_home_lessa = $areaHis->applied_area_home_lessa;
                    $applied_area_home_ganda = $areaHis->applied_area_home_ganda;
                    $applied_area_home_kranti = $areaHis->applied_area_home_kranti;

                    $applied_area_agri_bigha = $areaHis->applied_area_agri_bigha;
                    $applied_area_agri_katha = $areaHis->applied_area_agri_katha;
                    $applied_area_agri_lessa = $areaHis->applied_area_agri_lessa;
                    $applied_area_agri_ganda = $areaHis->applied_area_agri_ganda;
                    $applied_area_agri_kranti = $areaHis->applied_area_agri_kranti;


                    $settlement_area_home_bigha = $areaHis->settlement_area_home_bigha;
                    $settlement_area_home_katha = $areaHis->settlement_area_home_katha;
                    $settlement_area_home_lessa = $areaHis->settlement_area_home_lessa;
                    $settlement_area_home_ganda = $areaHis->settlement_area_home_ganda;
                    $settlement_area_home_kranti = $areaHis->settlement_area_home_kranti;

                    $settlement_area_agri_bigha = $areaHis->settlement_area_agri_bigha;
                    $settlement_area_agri_katha = $areaHis->settlement_area_agri_katha;
                    $settlement_area_agri_lessa = $areaHis->settlement_area_agri_lessa;
                    $settlement_area_agri_ganda = $areaHis->settlement_area_agri_ganda;
                    $settlement_area_agri_kranti = $areaHis->settlement_area_agri_kranti;


                    if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {

                        $total_applied_area_home_in_ganda = $this->utilityclass->Total_ganda($applied_area_home_bigha, $applied_area_home_katha, $applied_area_home_lessa, $applied_area_home_ganda);
                        $total_applied_area_agri_in_ganda = $this->utilityclass->Total_ganda($applied_area_agri_bigha, $applied_area_agri_katha, $applied_area_agri_lessa, $applied_area_agri_ganda);
                        $total_settlement_area_home_in_ganda = $this->utilityclass->Total_ganda($settlement_area_home_bigha, $settlement_area_home_katha, $settlement_area_home_lessa, $settlement_area_home_ganda);
                        $total_settlement_area_agri_in_ganda = $this->utilityclass->Total_ganda($settlement_area_agri_bigha, $settlement_area_agri_katha, $settlement_area_agri_lessa, $settlement_area_agri_ganda);

                        if(($total_applied_area_home_in_ganda != $total_settlement_area_home_in_ganda) || ($total_applied_area_agri_in_ganda != $total_settlement_area_agri_in_ganda)){

                            $lmdata['area_modified'] = $areaModificationCheck;
                        }

                    }
                    else
                    {
                        $total_applied_area_home_in_lessa = $this->utilityclass->Total_Lessa($applied_area_home_bigha, $applied_area_home_katha, $applied_area_home_lessa);
                        $total_applied_area_agri_in_lessa = $this->utilityclass->Total_Lessa($applied_area_agri_bigha, $applied_area_agri_katha, $applied_area_agri_lessa);
                        $total_settlement_area_home_in_lessa = $this->utilityclass->Total_Lessa($settlement_area_home_bigha, $settlement_area_home_katha, $settlement_area_home_lessa);
                        $total_settlement_area_agri_in_lessa = $this->utilityclass->Total_Lessa($settlement_area_agri_bigha, $settlement_area_agri_katha, $settlement_area_agri_lessa);
                        //check if area modified
                        if(($total_applied_area_home_in_lessa != $total_settlement_area_home_in_lessa) || ($total_applied_area_agri_in_lessa != $total_settlement_area_agri_in_lessa)){

                            $lmdata['area_modified'] = $areaModificationCheck;
                        }
                    }
                }
            }
        }

        $checkAreaDetails = '';//$this->chithaAreaCheckWithCaseNo($application_no);

        $lmdata['chithaArea']   = '';//$checkAreaDetails['chithaArea'];
        $lmdata['reservedArea'] = '';//$checkAreaDetails['reservedArea'];
        $lmdata['areaCheck']    = '';//$checkAreaDetails['areaCheck'];
        $lmdata['appliedDags']  = '';//$checkAreaDetails['appliedDags'];
        $lmdata['lmProcessArea']= '';//$checkAreaDetails['lmProcessArea'];

        // for guardian relation
        $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
        $relation_executation = $this->db->query($query_for_guar_rel);
        $row = $relation_executation->num_rows;
        if ($row != 0) {
            $lmdata['guar_rel'] = $relation_executation->result();
        }

        $lmdata['basic_status'] = $this->SettlementCommonModel->getCurrentBasicStatus($application_no);

        $lmdata['user_desig_code'] = $this->session->userdata('user_desig_code');
        $lmdata['co_name']= $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);

        //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
        $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($application_no);
        $deletedEncArray = array();
        foreach($deletedEnc as $encroacherDeleted_data)
        {
            $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
        }
        $lmdata['deleted_encroacher'] = $deletedEncArray;

        //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
        $deletedDags=$this->SettlementCommonModel->getDeletedDags($application_no);
        $deletedData = array();
        foreach($deletedDags as $deleteDag){
            $deletedData[] = json_decode($deleteDag->table_data);
        }
        $lmdata['deleted_dags'] = $deletedData;

        $rejected_data = $this->SettlementCommonModel->getRejectModal(RECLASS_ID);
        if($rejected_data == 'n')
        {
            $lmdata['rejected_list'] = false;
        }
        else
        {
            $lmdata['rejected_list'] = $rejected_data;
        }


        foreach(json_decode(VALIDATION_BYPASS_RECLASS) as $val_bypas)
        {
            if($val_bypas->SERVICE_CODE == RECLASS_ID)
            {
                $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
            }
        }

        $lmdata['validation_bypass'] = 0;

        foreach($lmdata['lmnotes'] as $lm_rr)
        {
            $decoded_r = json_decode($lm_rr->lm_rejected_remarks);

            if($decoded_r){
                foreach($decoded_r as  $lm_rejected_code)
                {
                    if(isset($lm_rejected_code->reject_code))
                    {
                        if(in_array($lm_rejected_code->reject_code, $const_bypass_arr_code)){
                            $lmdata['validation_bypass'] = 1;
                        }
                    }
                    else
                    {
                        if(in_array($lm_rejected_code, $const_bypass_arr_code)){
                            $lmdata['validation_bypass'] = 1;
                        }
                    }
                }
            }
        }

        $lmdata['reject_list_type'] = '';

        foreach($lmnotes as $r_remark)
        {
            $rejected_list_json = json_decode($r_remark->lm_rejected_remarks);

            if($rejected_list_json)
            {
                foreach ($rejected_list_json as $re_list)
                {
                    if(isset($re_list->reject_code))
                    {
                        $r_code = $re_list->reject_code;
                    }
                    else
                    {
                        $r_code = $re_list;
                    }

                    $sql = $this->db->query("select remark_head from reject_master where reject_code = ?", array($r_code));

                    if($sql->row()->remark_head != null)
                    {
                        $lmdata['reject_list_type'] = 'new';
                    }
                    else
                    {
                        $lmdata['reject_list_type'] = 'old';
                    }
                }
            }
        }


        //$lmdata['_view'] = 'reclass_suite/reclassSuiteView';
        $lmdata['_view'] = 'reclass_suite/Common/application_details_common_reclass';
        $this->load->view('layouts/main', $lmdata);
    }

    public function decodeBase64($encoded_string)
    {
        $file_data = base64_decode($encoded_string);
        $file = finfo_open();
        $mime_type = finfo_buffer($file, $file_data, FILEINFO_MIME_TYPE);
        $file_type = explode('/', $mime_type)[0];
        $extension = explode('/', $mime_type)[1];
        log_message("error", "No error occured" . json_encode($mime_type));
        return $mime_type;
    }


    public function applicationViewCumRegistrationforAllcases()
    {
        $application_no_encrypted = $this->input->get('app');
        $service_code = $this->input->get('service_code');
        $application_no = $this->utilityclass->decryptJwtCase($application_no_encrypted);

        // get AADHAAR PHOTO (API CALL)
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "getApplicantPhoto");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application_no' => $application_no,
        )));
        $get_aadhaar_photo = curl_exec($curl_handle);
        curl_close($curl_handle);
        if ($get_aadhaar_photo != 'n') {
            $district['aadhaar_b64_decoded'] = "<img src = data:" . $this->decodeBase64($get_aadhaar_photo) . ";base64," . $get_aadhaar_photo . " class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
        }

        // check if case already registered
        $recordExist = $this->SettlementApiModel->checkExistDharitree($application_no);

        if($service_code == SETTLEMENT_TENANT_URBAN_ID)
        {
            if (!$recordExist) {

                // get data from basundhara end (API call)
                $token = $this->utilityclass->createTokenJwt();
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "getAppDetails");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    'application_no' => $application_no,
                    'api_key' => API_KEY,
                    'token' => $token,
                )));
                $output = curl_exec($curl_handle);
                if (isset(json_decode($output)->responseType)) {
                    if (json_decode($output)->responseType == 3) {
                        echo json_decode($output)->data . " - Unauthorized access!";
                        return false;
                    }
                }
                curl_close($curl_handle);
                $backup = $output;
                $output = json_decode($output);

                $app = $output->application;
                $d = $app->dist_code;
                $s = $app->subdiv_code;
                $c = $app->cir_code;
                $m = $app->mouza_code;
                $l = $app->lot_no;
                $v = $app->village_code;
                $dag = $app->dag_no;

                $case_name = $this->SettlementApiModel->genearteCaseName(); // generate case name

                if (empty($case_name)) {
                    log_message('error', '#ERROR0002: Case name can not be generated for application no ' . $application_no);
                    $this->session->set_flashdata('error_data', "#ERROR0002: Network Issue or Session Out. Please try Again!");
                    $data = array(
                        'error' => "#ERROR0002: Registration of Settlement failed for case no : " . $application_no,
                    );
                    echo json_encode($data);
                    exit;
                }

                //generate case no
                $case_no['petition_no'] = $petition_no = $this->SettlementApiModel->genearteSettlementPetitionNo();
                $case_no['case_no'] = $case_name . $petition_no . "/" . SETTLEMENT_TENANT_URBAN;

                //check for tribal belt
                if ($output->applicants['0']->tribe_category == 1) {
                    $tribal_belt = 'YES';
                } else if ($output->applicants['0']->tribe_category == 0) {
                    $tribal_belt = 'NO';
                } else {
                    $tribal_belt = '';
                }

                //check for bhumiputra certificate starts here
                if (!empty($output->bhumi['0'])) {

                    if ($output->bhumi['0']->bhumi_cert_available == 1) { //if bhumiputra available
                        $bhumiputra_confirmation = 'YES';
                        $bhumiputra_certificate_no = $output->bhumi['0']->bhumi_ack_no;
                        $bhumiputra_certificate_type = 'CERT';
                    } else if ($output->bhumi['0']->is_bhumi_applied == 1) { //if applied in bhumiputra
                        $bhumiputra_confirmation = 'YES';
                        $bhumiputra_certificate_no = $output->bhumi['0']->bhumi_ack_no;
                        $bhumiputra_certificate_type = 'ACK';
                    } else {
                        $bhumiputra_confirmation = '0';
                        $bhumiputra_certificate_no = '0';
                        $bhumiputra_certificate_type = '0';
                    }
                } else {
                    $bhumiputra_confirmation = '0';
                    $bhumiputra_certificate_no = '0';
                    $bhumiputra_certificate_type = '0';
                }

                $this->db->trans_begin(); // transaction begins here

                //insert into SETTLEMENT BASIC, status=Z means very first initial insertion by LM
                $settlement_basic = [
                    'dist_code' => $d,
                    'subdiv_code' => $s,
                    'cir_code' => $c,
                    'mouza_pargona_code' => $m,
                    'lot_no' => $l,
                    'vill_townprt_code' => $v,
                    'service_code' => SETTLEMENT_TENANT_URBAN_ID,
                    'ref_no' => $output->applicants['0']->ref_no,
                    'case_no' => $case_no['case_no'],
                    'trans_code' => 'F',
                    'petition_no' => $case_no['petition_no'],
                    'year_no' => date('Y'),
                    'date_entry' => date('Y-m-d G:i:s'),
                    'status' => 'ZC',
                    'submission_date' => date('Y-m-d G:i:s'),
                    'period_possession' => date('Y-m-d'),
                    'occupation_applicant' => $output->applicants['0']->applicant_occupation,
                    'applid' => $application_no,
                    'caste' => $output->applicants['0']->caste_category,
                    'uuid' => $output->applicants['0']->uuid,
                    'tribal_belt' => $tribal_belt,
                    'bhumiputra_confirmation' => $bhumiputra_confirmation,
                    'bhumiputra_certificate_no' => $bhumiputra_certificate_no,
                    'bhumiputra_certificate_type' => $bhumiputra_certificate_type,
                    'user_code' => $this->session->userdata('user_code'),
                    'pending_officer' => 'CO',
                    'pending_office' => 'CO',
                    'from_office' => 'API'
                ];
                $settlement_basic_insertion = $this->db->insert('settlement_basic', $settlement_basic);

                if ($settlement_basic_insertion != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROR0003: Insertion failed in settlement_basic for RTPS Case No ' . $application_no . 'and query is ' . $this->db->last_query());
                    $this->session->set_flashdata('error_data', "#ERROR0003: Registration of Settlement failed for RTPS application no : " . $application_no);
                    $data = array(
                        'error' => "#ERROR0003: Registration of Settlement failed for case no : " . $application_no,
                    );
                    echo json_encode($data);
                    return false;
                }

                //insert into ADDITIONAL PROPERTY
                $checkAdditionalProperty = $this->SettlementCommonModel->getAdditionalPropertyDetail($application_no);

                if ($checkAdditionalProperty->num_rows() == 0) {
                    if (isset($output->property)) {
                        foreach ($output->property as $value) {
                            $add_property = [
                                'case_no' => $case_no['case_no'],
                                'dist_code' => $value->dist_code,
                                'subdiv_code' => $value->subdiv_code,
                                'cir_code' => $value->cir_code,
                                'mouza_pargona_code' => $value->mouza_pargona_code,
                                'lot_no' => $value->lot_no,
                                'vill_townprt_code' => $value->vill_townprt_code,
                                'bigha' => $value->bigha,
                                'katha' => $value->katha,
                                'lessa' => $value->lessa,
                                'chatak' => $value->lessa,
                                'ganda' => $value->ganda,
                                'kranti' => $value->kranti,
                                'entry_date' => date('Y-m-d h:i:s'),
                                'is_rural' => $value->is_rural,
                                'dag_no' => $value->dag_no,
                                'patta_no' => $value->patta_no,
                                'service_id' => SETTLEMENT_TENANT_URBAN_ID,
                                'applied_flag' => CITIZEN,
                                'dist_name' => trim($value->dist_name),
                                'cir_name' => trim($value->cir_name),
                                'vill_name' => trim($value->vill_name),
                                'applid' => $application_no,
                            ];
                            $insAddProperty = $this->db->insert('settlement_additional_property', $add_property);

                            if ($insAddProperty != 1) {
                                log_message('error', '#ERROR0004: Insertion failed in settlement_additional_property RTPS Case No ' . $application_no . ' and query is ' . $this->db->last_qery());
                                $data = array(
                                    'error' => "#ERROR0004: Registration of Settlement failed for case no : " . $application_no,
                                );
                                echo json_encode($data);
                                return false;
                            }
                        }
                    }
                }

                //insert into SETTLEMENT DAG DETAILS
                if (!empty($output->settlements)) {
                    foreach ($output->settlements as $dag) {
                        if ($dag->is_applicant == 1) {

                            $new_land_class = $this->utilityclass->getPattaTypeNo($d, $s, $c, $m, $l, $v, $dag->dag_no);

                            $insSettlementDagDetails = [

                                'dist_code' => $d,
                                'subdiv_code' => $s,
                                'cir_code' => $c,
                                'mouza_pargona_code' => $m,
                                'lot_no' => $l,
                                'vill_townprt_code' => $v,
                                'user_code' => $this->session->userdata('user_code'),
                                'date_entry' => date('Y-m-d'),
                                'case_no' => $case_no['case_no'],
                                'petition_no' => $case_no['petition_no'],
                                'year_no' => date('Y'),
                                'operation' => 'E',
                                'new_land_class_code' => $new_land_class->land_class_code,
                                'dag_no' => $dag->dag_no,
                                'patta_no' => $dag->patta_no,
                                'patta_type_code' => $dag->patta_code,
                                'dag_area_b' => $dag->applied_bigha,
                                'dag_area_k' => $dag->applied_katha,
                                'dag_area_lc' => $dag->applied_lessa,
                                'dag_area_g' => $dag->applied_ganda,
                                'dag_area_kr' => $dag->applied_kranti,
                                's_dag_area_b' => $dag->mbigha,
                                's_dag_area_k' => $dag->mkatha,
                                's_dag_area_lc' => $dag->mlessa,
                                's_dag_area_g' => $dag->mganda,
                                's_dag_area_kr' => $dag->mkranti,
                                'revenue' => 0,
                                'is_urban' => $app->is_urban
                            ];
                            $settlement_dag_details = $this->db->insert('settlement_dag_details', $insSettlementDagDetails);

                            if ($settlement_dag_details != 1) {
                                $this->db->trans_rollback();
                                log_message('error', '#ERROR0005: Insertion failed in settlement_dag_details for RTPS Case No ' . $application_no . 'and query is ' . $this->db->last_query());
                                $this->session->set_flashdata('error_data', "#ERROR0005: Registration of Settlement failed for RTPS application no : " . $application_no);
                                $data = array(
                                    'error' => "#ERROR0005: Registration of Settlement failed for case no : " . $application_no,
                                );
                                echo json_encode($data);
                                return false;
                            }

                            //*******insertion in settlement_area_history**************
                            if (in_array($d, json_decode(BARAK_VALLEY))){
                                //***********actual Encroachment area ***************
                                $actual_encroachment_area_home_ganda = $this->utilityclass->Total_ganda($dag->mbigha, $dag->mkatha, $dag->mlessa, $dag->mganda);

                                //***********Settlement area that applicant will get settlement on***********
                                $total_settlement_ganda_home = $this->utilityclass->Total_ganda($dag->mbigha, $dag->mkatha, $dag->mlessa, $dag->mganda);

                                $totalSettlementAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_settlement_ganda_home);

                                //*************leftout area homestead**************
                                $leftOutAreaHomeGanda = (float)$actual_encroachment_area_home_ganda - (float)$total_settlement_ganda_home;

                                $leftOutAreaHomeArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($leftOutAreaHomeGanda);


                                $totalLeftOutAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($leftOutAreaHomeGanda);
                            }
                            else
                            {
                                //********actual Encroachment area**********
                                $actual_encroachment_area_home_lessa = $this->utilityclass->Total_Lessa($dag->mbigha, $dag->mkatha, $dag->mlessa);

                                //*******Settlement area that applicant will get settlement on**********
                                $total_settlement_lessa_home = $this->utilityclass->Total_Lessa($dag->mbigha, $dag->mkatha, $dag->mlessa);

                                //*************Total settlement area */
                                $totalSettlementAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_settlement_lessa_home);

                                //****************leftout area homestead**************
                                $leftOutAreaHomeLessa = (float)$actual_encroachment_area_home_lessa - (float)$total_settlement_lessa_home;

                                $leftOutAreaHomeArr = $this->utilityclass->Total_Bigha_Katha_Lessa($leftOutAreaHomeLessa);

                                //**********Total left out area***************

                                $totalLeftOutAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($leftOutAreaHomeLessa);
                            }

                            $settlementAreaHistoryArr = [
                                'application_no' => $application_no,
                                'case_no' => $case_no['case_no'],
                                'dag_no' => $dag->dag_no,
                                'uuid' => $dag->uuid,
                                'created_at' => date('Y-m-d'),
                                'applied_area_home_bigha' => $dag->mbigha,
                                'applied_area_home_katha' => $dag->mkatha,
                                'applied_area_home_lessa' => $dag->mlessa,
                                'applied_area_home_ganda' => $dag->mganda,
                                'applied_area_home_kranti' => $dag->mkranti,

                                'settlement_area_home_bigha' => $dag->mbigha,
                                'settlement_area_home_katha' => $dag->mkatha,
                                'settlement_area_home_lessa' => $dag->mlessa,
                                'settlement_area_home_ganda' => $dag->mganda,
                                'settlement_area_home_kranti' => $dag->mkranti,

                                'total_settlement_area_bigha' => $totalSettlementAreaArr[0],
                                'total_settlement_area_katha' => $totalSettlementAreaArr[1],
                                'total_settlement_area_lessa' => $totalSettlementAreaArr[2],
                                'total_settlement_area_ganda' => $totalSettlementAreaArr[3],
                                'total_settlement_area_kranti' => 0,

                                'leftout_area_home_bigha' => $leftOutAreaHomeArr[0],
                                'leftout_area_home_katha' => $leftOutAreaHomeArr[1],
                                'leftout_area_home_lessa' => $leftOutAreaHomeArr[2],
                                'leftout_area_home_ganda' => $leftOutAreaHomeArr[3],
                                'leftout_area_home_kranti' => 0,

                                'total_leftout_area_bigha' => $totalLeftOutAreaArr[0],
                                'total_leftout_area_katha' => $totalLeftOutAreaArr[1],
                                'total_leftout_area_lessa' => $totalLeftOutAreaArr[2],
                                'total_leftout_area_ganda' => $totalLeftOutAreaArr[3],
                                'total_leftout_area_kranti' => 0,
                            ];

                            $insertSetlArea = $this->db->insert('settlement_area_history', $settlementAreaHistoryArr);

                            if ($insertSetlArea != 1) {
                                $this->db->trans_rollback();
                                log_message('error', '#SETLARRHIS0001: Insertion failed in settlement_area_history RTPS Case No '.$application_no);
                                $data = array(
                                    'error'=>"#SETLARRHIS0001: Registration of Settlement failed for case no : ".$application_no
                                );
                                echo json_encode($data);
                                return false;
                            }

                        }
                    }
                }

                //insert into SETTLEMENT APPLICANT, main applicant/encrochers details

                if (!empty($output->settlements)) {
                    foreach ($output->settlements as $appl) {

                        if ($appl->dag_no == 0 || $appl->dag_no == null || $appl->dag_no == '') {
                            $dag_no = 0;
                            $patta_no = 0;
                            $patta_type_code = 0;
                        } else {
                            $dag_no = $appl->dag_no;
                            $patta_no = $appl->patta_no;
                            $patta_type_code = $appl->patta_code;
                        }

                        if ($appl->is_applicant == 1) { // main applicant, for identity authentication
                            if ($get_aadhaar_photo != 'n') {
                                $timestamp = date('mdYhis', time()) . uniqid();
                                $identity_doc_unique_name = str_replace('/', "-", $application_no . '_' . $timestamp);
                                // creating and saving the base64 format payment notice to uploads/paymentNotice folder
                                $aadhar_path = AADHAAR_PHOTO . $identity_doc_unique_name . ".json";
                                $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file!");
                                $aadhaar_encoded_file = $get_aadhaar_photo;
                                fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                                fclose($aadhaar_file_to_write_base64);
                            } else {
                                $aadhar_path = '';
                            }
                            if ($output->aadhar->type == 'AADHAAR') {
                                $identity_ref_no = $output->aadhar->aadhaar_no;
                            } else {
                                $identity_ref_no = $output->aadhar->pan_no;
                            }
                            $identity_type = $output->aadhar->type;
                            $identity_doc_link = $aadhar_path;
                        } else {
                            $identity_ref_no = '';
                            $identity_type = '';
                            $identity_doc_link = '';
                        }

                        if($appl->gurdian_relation_id == null)
                        {
                            $pdar_rel_guar = 0;
                        }
                        else
                        {
                            $pdar_rel_guar = $appl->gurdian_relation_id;
                        }

                        if ($appl->pdar_type == 'EN')
                        {
                            //************this to  be edited */
                            if(isset($appl->khatian_no))
                            {
                                if(trim($appl->khatian_no) == '' || trim($appl->khatian_no) == NULL || trim($appl->khatian_no) == -1)
                                {
                                    $get_pdar_name = 'NA';
                                    $get_pdar_guardian = 'NA';
                                    $get_pdar_add1 = '';
                                    $get_pdar_add2 = '';
                                }
                                else
                                {
                                    $getRiotee = $this->db->query("SELECT * FROM chitha_tenant WHERE subdiv_code=? AND cir_code=? AND lot_no=? AND mouza_pargona_code=? AND vill_townprt_code=? AND dag_no=? AND khatian_no=? AND tenant_id=?", array($s, $c, $l, $m, $v, $appl->dag_no, $appl->khatian_no, $appl->encroacher_id));

                                    // echo $this->db->last_query();

                                    if($getRiotee->num_rows() <= 0)
                                    {
                                        // $get_pdar_name = '';
                                        // $get_pdar_guardian = '';
                                        // $get_pdar_add1 = '';
                                        // $get_pdar_add2 = '';

                                        //show err here

                                        $this->db->trans_rollback();
                                        log_message('error', '#ERROR012006: Tenant not found in chitha_tenant for RTPS Case No ' . $application_no . 'and query is ' . $this->db->last_query());
                                        $data = array(
                                            'error' => "#ERROR012006: Registration of Settlement failed for case no : " . $application_no,
                                        );
                                        echo json_encode($data);
                                        return false;
                                    }
                                    else
                                    {
                                        $riotee_details = $getRiotee->row();

                                        $get_pdar_name = $riotee_details->tenant_name;
                                        $get_pdar_guardian = $riotee_details->tenants_father;
                                        $get_pdar_add1 = $riotee_details->tenants_add1;
                                        $get_pdar_add2 = $riotee_details->tenants_add2;
                                    }
                                }
                            }

                            $riotee_id = $appl->encroacher_id;
                            $khatian_no = $appl->khatian_no;
                        }
                        else
                        {
                            $riotee_id = '-1';
                            $khatian_no = '-1';

                            $get_pdar_name = isset($appl->name_ass) ? $appl->name_ass : 'NA';
                            $get_pdar_guardian = isset($appl->gurdian_name_ass) ? $appl->gurdian_name_ass : 'NA';
                            $get_pdar_add1 = $appl->pre_add;
                            $get_pdar_add2 = $appl->per_add;
                        }

                        if($appl->chitha_pdar_id == null){
                            $chitha_pdar_id = '-1';
                        }
                        else
                        {
                            $chitha_pdar_id = $appl->chitha_pdar_id;
                        }

                        //pdar_cron_no
                        $cron_no = $this->SettlementCommonModel->getPdarCronNo($case_no['case_no']);

                        $insApplicant = [
                            'dist_code' => $d,
                            'subdiv_code' => $s,
                            'cir_code' => $c,
                            'mouza_pargona_code' => $m,
                            'lot_no' => $l,
                            'vill_townprt_code' => $v,
                            'user_code' => $this->session->userdata('user_code'),
                            'case_no' => $case_no['case_no'],
                            'petition_no' => $case_no['petition_no'],
                            'operation' => 'E',
                            'dag_no' => $dag_no,
                            'patta_no' => $patta_no,
                            'patta_type_code' => $patta_type_code,
                            'year_no' => date('Y'),
                            'date_entry' => date('Y-m-d'),
                            'pdar_id' => $chitha_pdar_id,
                            'pdar_cron_no' => $cron_no,
                            'pdar_name' => $get_pdar_name,
                            'pdar_guardian' => $get_pdar_guardian,
                            'pdar_rel_guar' => $pdar_rel_guar,
                            'pdar_gender' => $appl->gender,
                            'pdar_add1' => $get_pdar_add1,
                            'pdar_add2' => $get_pdar_add2,
                            'pdar_mobile' => $appl->mobile,
                            'pdar_type' => $appl->pdar_type,
                            'is_applicant' => $appl->is_applicant,
                            'marital_status' => $appl->marital_status,
                            'dob' => $appl->dob,
                            'eng_pdar_name' => $appl->name_eng,
                            'eng_pdar_guardian' => $appl->gurdian_name_eng,
                            'identity_ref_no' => $identity_ref_no,
                            'identity_type' => $identity_type,
                            'identity_doc_link' => $identity_doc_link,
                            'period_possession' => $appl->possession_date,
                            'riotee_id' => $riotee_id,
                            'khatian_no' => $khatian_no,
                        ];
                        $applicantDetail = $this->db->insert('settlement_applicant', $insApplicant);

                        if ($applicantDetail != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#ERROR0006: Insertion failed in settlement_applicant for RTPS Case No ' . $application_no . 'and query is ' . $this->db->last_query());
                            $this->session->set_flashdata('error_data', "#ERROR0006: Registration of Settlement failed for RTPS application no : " . $application_no);

                            $data = array(
                                'error' => "#ERROR0006: Registration of Settlement failed for case no : " . $application_no,
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }
                }

                // insert into settlement_nominee, NEXT OF KIN
                if (!empty($output->nextKin)) {
                    foreach ($output->nextKin as $nok) {
                        $nominee_data = [
                            'case_no' => $case_no['case_no'],
                            'nominee_name' => $nok->next_of_kin_name,
                            'address' => $nok->address,
                            'mobile_no' => $nok->mobile_no,
                            'relation' => $nok->relation_with_kin,
                        ];
                        $insNominee = $this->db->insert('settlement_nominee', $nominee_data);

                        if ($insNominee != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#ERROR0007: Insertion failed in settlement_nominee for RTPS Case No ' . $application_no . 'and query is ' . $this->db->last_query());
                            $this->session->set_flashdata('error_data', "#ERROR0007: Registration of Settlement failed for RTPS application no : " . $application_no);
                            return false;
                        }
                    }
                }

                //insert into BASUNDHAR APPLICATION
                $basundhara = [
                    'dharitree' => $case_no['case_no'],
                    'basundhara' => $application_no,
                    'date_reg' => date('Y-m-d'),
                    'reg_by' => $this->session->userdata('user_code'),
                    'app_status' => 'M',
                    'pending_with' => 'CO',
                ];
                $basundhar_app = $this->db->insert('basundhar_application', $basundhara);
                if ($basundhar_app != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROR0008: Insertion failed in Basundhara Application for RTPS Case No ' . $application_no . 'and query is ' . $this->db->last_query());
                    $this->session->set_flashdata('error_data', "#ERROR0008: Registration of Settlement failed for RTPS application no : " . $application_no);
                    return false;
                }

                //insert into back up file
                $backup_array = [
                    'applid' => $application_no,
                    'case_no' => $case_no['case_no'],
                    'status' => 'I',
                    'data' => $backup,
                ];
                $backup_insertion = $this->db->insert('settlement_backup_json', $backup_array);
                if ($backup_insertion != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#BACKUP001: Insertion failed in settlement_backup_json RTPS Case No ' . $application_no);

                    $this->session->set_flashdata('error_data', "#BACKUP001: Registration of Settlement failed for case no : " . $application_no);
                    redirect(base_url() . "index.php/home");
                    return false;
                }
                $this->db->trans_commit(); // transaction ends here

            }

            $sql = "Select case_no from settlement_basic where applid='$application_no' ";
            $case = $this->db->query($sql)->row();
            $application_no = $case->case_no;

            $basic   = $this->SettlementTenantModel->getSettlementBasic($application_no);
            //  result
            $applicants_buyers = $this->SettlementTenantModel->getAllApplicantBuyers($application_no);
            $applicants_owners   = $this->SettlementTenantModel->getAllApplicantOwners($application_no);
            $applicants_encroacher   = $this->SettlementTenantModel->getAllApplicantEncroacher($application_no);
            $applicants_riotee_nok   = $this->SettlementTenantModel->getAllApplicantRioteeNok($application_no);

            $dags   = $this->SettlementTenantModel->getSettlementDag($application_no);
            $lmnotes   = $this->SettlementTenantModel->getSettlementTenantLmNote($application_no);
            $proceedings   = $this->SettlementTenantModel->getSettlementProceeding($application_no);
            $dhardocuments   = $this->SettlementTenantModel->getDocuments($application_no);

            $data['basic']=$basic;
            $data['applicants_buyers']=$applicants_buyers;
            $data['applicants_owners']=$applicants_owners;
            $data['applicants_encroacher']=$applicants_encroacher;
            $data['applicants_riotee_nok']=$applicants_riotee_nok;
            $data['dags']=$dags;
            $data['lmnotes']=$lmnotes;
            $data['proceedings']=$proceedings;
            $data['dhardocuments']=$dhardocuments;

            $data['pattaNo']=$this->utilityclass->getPattaTypeNo($data['basic']["dist_code"],$data['basic']["subdiv_code"],$data['basic']["cir_code"],$data['basic']["mouza_pargona_code"],$data['basic']["lot_no"],$data['basic']["vill_townprt_code"],$data['dags']["dag_no"]);
            $sql = "Select basundhara from basundhar_application where dharitree='$application_no' ";
            $basundhara = $this->db->query($sql)->row();
            $url = API_LINK_MB3."serviceResponseBasu?application_no=" . $basundhara->basundhara ;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
            $output = curl_exec($ch);
            curl_close($ch);
            $output = json_decode($output);

            $data['document']=$output->documents;
            $data['query']=$output->query;
            $data['property']=$output->property;
            $data['aadhar']=$output->aadhar;
            $data['nextKin']=$output->nextKin;
            foreach($output->selfDeclaration as $selfDec){
                $data['selfDeclarationDetails']=json_decode($selfDec->dec_details);
            }
            // for guardian relation
            $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
            $relation_executation = $this->db->query($query_for_guar_rel);
            $row = $relation_executation->num_rows;
            if ($row != 0) {
                $data['guar_rel'] = $relation_executation->result();
            }
            $data['premium_data'] = $this->SettlementCommonModel->getPremium($application_no);

            // $data['caseCount']   = $caseCount;
            // $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;

            //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
            $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($application_no);
            $deletedEncArray = array();
            foreach($deletedEnc as $encroacherDeleted_data)
            {
                $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
            }
            $data['deleted_encroacher'] = $deletedEncArray;
            //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
            $deletedDags=$this->SettlementCommonModel->getDeletedDags($application_no);
            $deletedData = array();
            foreach($deletedDags as $deleteDag){
                $deletedData[] = json_decode($deleteDag->table_data);
            }
            $data['deleted_dags'] = $deletedData;
            $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_TENANT_ID);
            if($rejected_data == 'n')
            {
                $data['rejected_list'] = false;
            }
            else
            {
                $data['rejected_list'] = $rejected_data;
            }


            foreach(json_decode(VALIDATION_BYPASS) as $val_bypas)
            {
                if($val_bypas->SERVICE_CODE == SETTLEMENT_AP_TRANSFER_ID)
                {
                    $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
                }
            }

            $data['validation_bypass'] = 0;

            foreach($data['lmnotes'] as $lm_rr)
            {
                $decoded_r = json_decode($lm_rr->lm_rejected_remarks);

                if($decoded_r){
                    foreach($decoded_r as  $lm_rejected_code)
                    {
                        if(isset($lm_rejected_code->reject_code))
                        {
                            if(in_array($lm_rejected_code->reject_code, $const_bypass_arr_code)){
                                $data['validation_bypass'] = 1;
                            }
                        }
                        else
                        {
                            if(in_array($lm_rejected_code, $const_bypass_arr_code)){
                                $data['validation_bypass'] = 1;
                            }
                        }

                    }
                }

            }

            $data['reject_list_type'] = '';

            foreach($lmnotes as $r_remark)
            {
                $rejected_list_json = json_decode($r_remark->lm_rejected_remarks);

                if($rejected_list_json)
                {
                    foreach ($rejected_list_json as $re_list) {

                        if(isset($re_list->reject_code))
                        {
                            $r_code = $re_list->reject_code;
                        }
                        else
                        {
                            $r_code = $re_list;
                        }

                        $sql = $this->db->query("select remark_head from reject_master where reject_code = ?", array($r_code));

                        if($sql->row()->remark_head != null)
                        {
                            $data['reject_list_type'] = 'new';
                        }
                        else
                        {
                            $data['reject_list_type'] = 'old';
                        }
                    }
                }
            }


            $newDagCount = $this->db->query("SELECT old_dag, new_dag FROM chitha_settlement_allottee WHERE ord_no = ? 
                               GROUP BY old_dag, new_dag", array($application_no));

            if($newDagCount->num_rows()!= 0)
            {
                $data['newDagCount'] = 1;
                $data['newDags']     = $newDagCount->result();
            }
            else
            {
                $data['newDagCount'] = 0;
                $data['newDags']     = '';

            }

            $data['_view'] = 'settlementView/Dc/Common/application_details_common_tenant_urban';
            $this->load->view('layouts/main', $data);
        }

        if($service_code == BHODDAN_SERVICE_CODE)
        {
            // echo 'HHH';

            $geo_date_query = $this->db->query("Select date_entry from supportive_document where applid='$application_no'")->row();
            $geo_date = isset($geo_date_query->date_entry)? $geo_date_query->date_entry : '.....';

            $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE id in (select max(id) from supportive_document where applid=? and dag_no is not null and file_name=? group by applid, dag_no)", array($application_no, GEO_TAG_PHOTO));

            if($supportive_document_sql->num_rows() > 0){
                $lmdata['geo_tag_doc'] = $supportive_document_sql->result();
            }else{
                $lmdata['geo_tag_doc_empty'] = "<span class='text-danger alert-danger'><b>Geo tag photo yet to be uploaded.</b></span>";
            }

            if(!$recordExist)
            {
                /// additional property for LM note
                $additional_property = $this->db->query("Select * from settlement_additional_property where applid='$application_no'");
                if($additional_property->num_rows() > 0){
                    $totallesaa=0;
                    $totalganda=0;
                    foreach($additional_property->result() as $addprop){
                        if(in_array($addprop->dist_code, json_decode(BARAK_VALLEY))){
                            $total_g=$this->utilityclass->Total_ganda($addprop->bigha,$addprop->katha,$addprop->lessa,$addprop->ganda);
                            $totalganda = $totalganda+$total_g;
                        }else{
                            $total_l=$this->utilityclass->Total_Lessa($addprop->bigha,$addprop->katha,$addprop->lessa);
                            $totallesaa = $totallesaa+$total_l;
                        }

                    }
                    if(!empty($totallesaa)){
                        $district['total_aditional_area']= $this->utilityclass->Total_Bigha_Katha_Lessa($totallesaa);
                    }
                    if(!empty($totalganda)){
                        $district['total_aditional_area_g']= $this->utilityclass->Total_Bigha_Katha_Lessa2($totalganda);
                    }
                    $district['additional_property']=$additional_property->result();
                }

                $token = $this->utilityclass->createTokenJwt();
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."getAppDetails");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    'application_no' => $application_no,
                    'api_key'        => API_KEY,
                    'token'          => $token
                )));

                $output = curl_exec($curl_handle);
                if(isset(json_decode($output)->responseType)){
                    if(json_decode($output)->responseType == 3){
                        echo json_decode($output)->data." - Unauthorized access!";
                        return false;
                    }
                }
                curl_close($curl_handle);
                $backup = $output;

                $output = json_decode($output);

                //****************generate case number********************
                $case_name=$this->SettlementApiModel->genearteCaseName();
                if(empty($case_name))
                {
                    $data=array(
                        'error'=>"Network Issue or Session Out. Please try Again"
                    );
                    echo json_encode($data);
                    die();
                }
                //*******generating petition_no and case_no */
                $case_no['petition_no']  = $petition_no=$this->SettlementApiModel->genearteSettlementPetitionNo();
                $case_no['case_no']      = $case_name.$petition_no."/".BHODDAN_PREFIX;

                $district['geo_date']    = $geo_date;
                $district['app']         = $output->application;
                $district['pattaNo']     = $this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$district['app']->dag_no);

                $district['applicants']  = $output->applicants;

                $district['document']    = $output->documents;
                $district['query']       = $output->query;
                $district['property']    = $output->property;
                $district['settlements'] = $output->settlements;
                $district['encroachers'] = $output->encroachers;
                $district['owners']      = $output->owners;
                $district['riotee_noks'] = $output->riotee_noks;
                $district['aadhar']      = $output->aadhar;

                $district['nextKin']   = $output->nextKin;
                $d = $district['app']->dist_code;
                $s = $district['app']->subdiv_code;
                $c = $district['app']->cir_code;
                $m = $district['app']->mouza_code;
                $l = $district['app']->lot_no;
                $v = $district['app']->village_code;
                $dag = $district['app']->dag_no;

                $district['co_name']   = $this->SettlementCommonModel->getCoName($d, $s, $c);
                $district['s_area']    = $this->SettlementCommonModel->getPremiumArea();

                $district['bhumi']     = $output->bhumi;

                // for guardian relation
                $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";

                $relation_executation = $this->db->query($query_for_guar_rel);
                $row = $relation_executation->num_rows();

                if ($row != 0) {
                    $district['guar_rel'] = $relation_executation->result();
                }

                // if($this->utilityclass->checkUserAuthForCaseForLm($d,$s,$c,$m,$l) == false){
                //   $this->session->set_flashdata('message', "Unauthorized access for case no # ".$application_no);
                //   redirect(base_url() . "index.php/home");
                // }

                // $district['selfDeclarationDetails'] = $output->selfDeclaration;
                foreach($output->selfDeclaration as $selfDec){
                    $district['selfDeclarationDetails']=json_decode($selfDec->dec_details);
                }

                $vlb_encc=[];
                if($output->encroachers == true){
                    $district['riotee'] = $output->encroachers;
                    foreach($output->encroachers as $encroacher){
                        $vlb_encroacher = $this->SettlementApModel->getEncroacherDetails($d, $s, $c, $m, $l, $v, $encroacher->dag_no);

                        $district['vlb_enc'] = $vlb_encroacher;

                        if($vlb_encroacher == true){
                            // getting the encroacher details
                            $vlb_encroacher_in_dag = $this->SettlementApModel->getEncroacherInDag($vlb_encroacher->id);
                            $vlb_encc[] = $vlb_encroacher_in_dag;
                        }else{
                            $district['empty_err'] = "No Land Bank Details found!!";
                        }
                    }
                    $district['vlb_enc_details']=$vlb_encc;
                }

                // aadhaar photo api
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."getApplicantPhoto");

                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    'application_no'             => $application_no,

                )));
                $get_aadhaar_photo = curl_exec($curl_handle);
                curl_close($curl_handle);


                if($get_aadhaar_photo != 'n'){
                    $district['aadhaar_b64_decoded'] = "<img src = data:".$this->decodeBase64($get_aadhaar_photo).";base64,".$get_aadhaar_photo." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
                }

                $this->db->trans_begin();

                // insertion in backup table (lm)
                $backup_array = [
                    'applid'  => $application_no,
                    'case_no' => $case_no['case_no'],
                    'status'  => 'I',
                    'data'    => $backup
                ];

                $backup_insertion = $this->db->insert('settlement_backup_json', $backup_array);

                if($backup_insertion != 1){
                    $this->db->trans_rollback();
                    log_message('error', '#BACKUP450: Insertion failed in settlement_backup_json RTPS Case No '.$application_no);

                    $this->session->set_flashdata('message', "#BACKUP450: Registration of Settlement failed for case no : ".$application_no);
                    redirect(base_url() . "index.php/home");
                    return false;
                }

                ///////// additional property starts here
                $checkAdditionalProperty = $this->db->query("SELECT * FROM settlement_additional_property 
            WHERE applid=?", array($application_no));

                if($checkAdditionalProperty->num_rows() == 0){
                    if(isset($output->property)) {
                        foreach($output->property as $value) {
                            $add_property = array(
                                'case_no'            => $case_no['case_no'],
                                'dist_code'          => $value->dist_code,
                                'subdiv_code'        => $value->subdiv_code,
                                'cir_code'           => $value->cir_code,
                                'mouza_pargona_code' => $value->mouza_pargona_code,
                                'lot_no'             => $value->lot_no,
                                'vill_townprt_code'  => $value->vill_townprt_code,
                                'bigha'              => $value->bigha,
                                'katha'              => $value->katha,
                                'lessa'              => $value->lessa,
                                'chatak'             => $value->lessa,
                                'ganda'              => $value->ganda,
                                'kranti'             => $value->kranti,
                                'entry_date'         => date('Y-m-d h:i:s'),
                                'is_rural'           => $value->is_rural,
                                'dag_no'             => $value->dag_no,
                                'patta_no'           => $value->patta_no,
                                'service_id'         => BHODDAN_SERVICE_CODE,
                                'applied_flag'       => CITIZEN,
                                'dist_name'          => trim($value->dist_name),
                                'cir_name'           => trim($value->cir_name),
                                'vill_name'          => trim($value->vill_name),
                                'applid'             => $application_no,
                            );
                            $insAddProperty = $this->db->insert('settlement_additional_property', $add_property);

                            if ($insAddProperty != 1) {
                                $this->db->trans_rollback();
                                log_message('error', '#ERR490: Insertion failed in settlement_additional_property RTPS Case No '.$application_no);
                                $data = array(
                                    'error'=>"#ERR490: Registration of Settlement failed for case no : ".$application_no
                                );
                                echo json_encode($data);
                                return false;
                            }
                        }
                    }
                }
                ///////// additional property ends here

                $pro_class = $this->input->post('protected_class');
                $protected_class_vr = ($pro_class==null || $pro_class=='' || $pro_class==0) ? 0 : $this->input->post('protected_class');

                //********settlement_basic insertation */
                $basic=array(
                    'dist_code'           => $district['app']->dist_code,
                    'subdiv_code'         => $district['app']->subdiv_code,
                    'cir_code'            => $district['app']->cir_code,
                    'mouza_pargona_code'  => $district['app']->mouza_code,
                    'lot_no'              => $district['app']->lot_no,
                    'vill_townprt_code'   => $district['app']->village_code,
                    'service_code'        => $district['app']->service_code,
                    'ref_no'              => $district['app']->ref_no,
                    'case_no'             => $case_no['case_no'],
                    'trans_code'          => 'F',/////////full
                    'petition_no'         => $case_no['petition_no'],
                    'year_no'             => date('Y'),
                    'date_entry'          =>  date('Y-m-d G:i:s'),
                    'status'              => 'Z',
                    'user_code'           => $this->session->userdata('user_code'),
                    // 'lm_code'             =>  $this->session->userdata('user_code'),
                    'submission_date'     =>  date('Y-m-d G:i:s'),
                    'from_office'         =>  'API',
                    'pending_officer'     =>  'LM',
                    'pending_office'      =>  'CO',
                    'occupation_applicant'=> $district['applicants'][0]->applicant_occupation,
                    'applid'              => $district['app']->application_no,
                    'caste'               => $district['applicants'][0]->caste_category,
                    'uuid'                =>  $district['app']->uuid,
                    'protected_class'     =>  $protected_class_vr,
                    // 'co_code' => $this->input->post('co_code')
                );

                $insSetBasic = $this->db->insert('settlement_basic', $basic);
                // echo $this->db->last_query(); die();

                if ($insSetBasic != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERR540: Insertion failed in settlement_basic RTPS Case No '.$application_no);

                    $data = array(
                        'error'=>"#ERR540: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }

                ////settlement_dag_details insert start
                if ($district['encroachers'] == false || empty($district['encroachers']) || $district['encroachers'] == '')
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERR554: Insertion failed settlement_dag details empty RTPS Case No '.$application_no);

                    $data = array(
                        'error'=>"#ERR554: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }

                foreach ($district['encroachers'] as $dags)
                {
                    $district['class']=$this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code, $dags->dag_no);

                    $enc_home_bigha  = $dags->mbigha;
                    $enc_home_katha  = $dags->mkatha;
                    $enc_home_lessa  = $dags->mlessa;
                    $enc_home_ganda  = $dags->mganda;
                    $enc_home_kranti = $dags->mkranti;

                    $enc_agri_bigha  = $dags->agri_bigha;
                    $enc_agri_katha  = $dags->agri_katha;
                    $enc_agri_lessa  = $dags->agri_lessa;
                    $enc_agri_ganda  = $dags->agri_ganda;
                    $enc_agri_kranti = $dags->agri_kranti;

                    $encroachment_area = [
                        'homestead' => [
                            'bigha'  => $enc_home_bigha,
                            'katha'  => $enc_home_katha,
                            'lessa'  => $enc_home_lessa,
                            'ganda'  => $enc_home_ganda,
                            'kranti' => $enc_home_kranti,
                        ],
                        'agriculture' => [
                            'bigha'  => $enc_agri_bigha,
                            'katha'  => $enc_agri_katha,
                            'lessa'  => $enc_agri_lessa,
                            'ganda'  => $enc_agri_ganda,
                            'kranti' => $enc_agri_kranti,
                        ],
                    ];

                    $fmd=array(
                        'dist_code'           => $district['app']->dist_code,
                        'subdiv_code'         => $district['app']->subdiv_code,
                        'cir_code'            => $district['app']->cir_code,
                        'mouza_pargona_code'  => $district['app']->mouza_code,
                        'lot_no'              => $district['app']->lot_no,
                        'vill_townprt_code'   => $district['app']->village_code,
                        'user_code'           => $this->session->userdata('user_code'),
                        'date_entry'          => date('Y-m-d'),
                        'case_no'             => $case_no['case_no'],
                        'petition_no'         => $case_no['petition_no'],
                        'year_no'             => date('Y'),
                        'new_land_class_code' => $district['class']->land_class_code,
                        'dag_no'              => $dags->dag_no,
                        'patta_no'            => $dags->patta_no,
                        'patta_type_code'     => $dags->patta_code,
                        'is_urban'            => $district['app']->is_urban,
                        'land_type'           => $dags->land_type,
                        'revenue'             => 0,
                        'operation'           => 'E',
                        'encroachement_area'  => json_encode($encroachment_area)
                    );

                    $fmd['dag_area_b']  = $dags->applied_bigha;
                    $fmd['dag_area_k']  = $dags->applied_katha;
                    $fmd['dag_area_lc'] = $dags->applied_lessa;
                    $fmd['dag_area_g']  = $dags->applied_ganda;
                    $fmd['dag_area_kr'] = $dags->applied_kranti;

                    $fmd['home_b']      = $dags->mbigha;
                    $fmd['home_k']      = $dags->mkatha;
                    $fmd['home_lc']     = $dags->mlessa;
                    $fmd['home_g']      = $dags->mganda;
                    $fmd['home_kr']     = $dags->mkranti;

                    $fmd['agri_b']      = $dags->agri_bigha;
                    $fmd['agri_k']      = $dags->agri_katha;
                    $fmd['agri_lc']     = $dags->agri_lessa;
                    $fmd['agri_g']      = $dags->agri_ganda;
                    $fmd['agri_kr']     = $dags->agri_kranti;


                    //************Total Area Calculation -js- ******************
                    if (in_array($district['app']->dist_code, json_decode(BARAK_VALLEY))){
                        //******for Barak valley */
                        $areaHomeLessa = $this->utilityclass->Total_ganda($fmd['home_b'],$fmd['home_k'],$fmd['home_lc'],$fmd['home_g'],$fmd['home_kr']);
                        $areaAgriLessa = $this->utilityclass->Total_ganda($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc'],$fmd['agri_g'],$fmd['agri_kr']);

                        $totalAreaGanda = (float)$areaHomeLessa + (float)$areaAgriLessa;

                        $totalAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalAreaGanda);
                    }
                    else
                    {
                        $areaHomeLessa = $this->utilityclass->Total_Lessa($fmd['home_b'],$fmd['home_k'],$fmd['home_lc']);
                        $areaAgriLessa = $this->utilityclass->Total_Lessa($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc']);

                        $totalAreaLessa = (float)$areaHomeLessa + (float)$areaAgriLessa;

                        $totalAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($totalAreaLessa);
                    }

                    $fmd['s_dag_area_b']  = $totalAreaArr[0];
                    $fmd['s_dag_area_k']  = $totalAreaArr[1];
                    $fmd['s_dag_area_lc'] = $totalAreaArr[2];
                    $fmd['s_dag_area_g']  = $totalAreaArr[3];
                    $fmd['s_dag_area_kr'] = 0;

                    $rezaHome = $fmd['home_b'] + $fmd['home_k'] + $fmd['home_lc'] + $fmd['home_g'] + $fmd['home_kr'];
                    $rezaAgri = $fmd['agri_b'] + $fmd['agri_k'] + $fmd['agri_lc'] + $fmd['agri_g'] + $fmd['agri_kr'];

                    $landTypeUpdate = 0;
                    if($rezaHome > 0 && $rezaAgri > 0)
                    {
                        $landTypeUpdate = 3;
                    }
                    else if($rezaHome > 0  )
                    {
                        $landTypeUpdate = 1;
                    }
                    else if($rezaAgri > 0)
                    {
                        $landTypeUpdate = 2;
                    }

                    $insSetDag = $this->db->insert('settlement_dag_details', $fmd);
                    if ($insSetDag != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERR683: Insertion failed in settlement_dag_details RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#ERR683: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }

                    //*******insertion in settlement_area_history**************
                    if (in_array($district['app']->dist_code, json_decode(BARAK_VALLEY)))
                    {
                        //***********actual Encroachment area ***************
                        $actual_encroachment_area_home_ganda = $this->utilityclass->Total_ganda($enc_home_bigha,$enc_home_katha,$enc_home_lessa,$enc_home_ganda);
                        $actual_encroachment_area_agri_ganda = $this->utilityclass->Total_ganda($enc_agri_bigha,$enc_agri_katha,$enc_agri_lessa,$enc_agri_ganda);

                        //***********total Actual Encroachment area*****************
                        $total_actual_encroachment_area_ganda = (float)$actual_encroachment_area_home_ganda + (float)$actual_encroachment_area_agri_ganda;
                        $totalEncroachmentAreaArr             = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_actual_encroachment_area_ganda);
                        // **********************************************

                        //***********Settlement area that applicant will get settlement on***********
                        $total_settlement_ganda_home = $this->utilityclass->Total_ganda($fmd['home_b'],$fmd['home_k'],$fmd['home_lc'],$fmd['home_g']);
                        $total_settlement_ganda_agri = $this->utilityclass->Total_ganda($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc'],$fmd['agri_g']);

                        //*****total Settlement area *************/
                        $total_settlement_ganda = (float)$total_settlement_ganda_home + (float)$total_settlement_ganda_agri;
                        $totalSettlementAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_settlement_ganda);

                        //*************leftout area homestead**************
                        $leftOutAreaHomeGanda = (float)$actual_encroachment_area_home_ganda - (float)$total_settlement_ganda_home;
                        $leftOutAreaHomeArr   = $this->utilityclass->Total_Bigha_Katha_Lessa2($leftOutAreaHomeGanda);

                        //**********Ileftout area agriculture**************
                        $leftOutAreaAgriGanda = (float)$actual_encroachment_area_agri_ganda - (float)$total_settlement_ganda_agri;
                        $leftOutAreaAgriArr   = $this->utilityclass->Total_Bigha_Katha_Lessa2($leftOutAreaAgriGanda);

                        //**********Total left out area***************
                        $totalLeftOutAreaGanda = (float)$total_actual_encroachment_area_ganda - (float)$total_settlement_ganda;
                        $totalLeftOutAreaArr   = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalLeftOutAreaGanda);
                    }
                    else
                    {
                        //********actual Encroachment area**********
                        $actual_encroachment_area_home_lessa = $this->utilityclass->Total_Lessa($enc_home_bigha,$enc_home_katha,$enc_home_lessa);
                        $actual_encroachment_area_agri_lessa = $this->utilityclass->Total_Lessa($enc_agri_bigha,$enc_agri_katha,$enc_agri_lessa);

                        //***********total Actual Encroachment area*****************
                        $total_actual_encroachment_area_lessa = (float)$actual_encroachment_area_home_lessa + (float)$actual_encroachment_area_agri_lessa;
                        $totalEncroachmentAreaArr             = $this->utilityclass->Total_Bigha_Katha_Lessa($total_actual_encroachment_area_lessa);
                        // **********************************************

                        //*******Settlement area that applicant will get settlement on**********
                        $total_settlement_lessa_home = $this->utilityclass->Total_Lessa($fmd['home_b'],$fmd['home_k'],$fmd['home_lc']);
                        $total_settlement_lessa_agri = $this->utilityclass->Total_Lessa($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc']);

                        //*************Total settlement area */
                        $total_settlement_lessa = (float)$total_settlement_lessa_home + (float)$total_settlement_lessa_agri;
                        $totalSettlementAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_settlement_lessa);

                        //****************leftout area homestead**************
                        $leftOutAreaHomeLessa = (float)$actual_encroachment_area_home_lessa - (float)$total_settlement_lessa_home;
                        $leftOutAreaHomeArr   = $this->utilityclass->Total_Bigha_Katha_Lessa($leftOutAreaHomeLessa);

                        //*************leftout area agriculture*****************
                        $leftOutAreaAgriLessa = (float)$actual_encroachment_area_agri_lessa - (float)$total_settlement_lessa_agri;
                        $leftOutAreaAgriArr   = $this->utilityclass->Total_Bigha_Katha_Lessa($leftOutAreaAgriLessa);

                        //**********Total left out area***************
                        $totalLeftOutArealessa = (float)$total_actual_encroachment_area_lessa - (float)$total_settlement_lessa;
                        $totalLeftOutAreaArr   = $this->utilityclass->Total_Bigha_Katha_Lessa($totalLeftOutArealessa);
                    }

                    $settlementAreaHistoryArr = [
                        'application_no'                        => $application_no,
                        'case_no'                               => $case_no['case_no'],
                        'dag_no'                                => $dags->dag_no,
                        'uuid'                                  => $district['app']->uuid,
                        'created_at'                            => date('Y-m-d'),
                        'applied_area_home_bigha'               => $dags->mbigha,
                        'applied_area_home_katha'               => $dags->mkatha,
                        'applied_area_home_lessa'               => $dags->mlessa,
                        'applied_area_home_ganda'               => $dags->mganda,
                        'applied_area_home_kranti'              => $dags->mkranti,
                        'applied_area_agri_bigha'               => $dags->agri_bigha,
                        'applied_area_agri_katha'               => $dags->agri_katha,
                        'applied_area_agri_lessa'               => $dags->agri_lessa,
                        'applied_area_agri_ganda'               => $dags->agri_ganda,
                        'applied_area_agri_kranti'              => $dags->agri_kranti,
                        'actual_encroachment_area_home_bigha'   => $enc_home_bigha,
                        'actual_encroachment_area_home_katha'   => $enc_home_katha,
                        'actual_encroachment_area_home_lessa'   => $enc_home_lessa,
                        'actual_encroachment_area_home_ganda'   => $enc_home_ganda,
                        'actual_encroachment_area_home_kranti'  => $enc_home_kranti,
                        'actual_encroachment_area_agri_bigha'   => $enc_agri_bigha,
                        'actual_encroachment_area_agri_katha'   => $enc_agri_katha,
                        'actual_encroachment_area_agri_lessa'   => $enc_agri_lessa,
                        'actual_encroachment_area_agri_ganda'   => $enc_agri_ganda,
                        'actual_encroachment_area_agri_kranti'  => $enc_agri_kranti,
                        'total_actual_encroachment_area_bigha'  => $totalEncroachmentAreaArr[0],
                        'total_actual_encroachment_area_katha'  => $totalEncroachmentAreaArr[1],
                        'total_actual_encroachment_area_lessa'  => $totalEncroachmentAreaArr[2],
                        'total_actual_encroachment_area_ganda'  => $totalEncroachmentAreaArr[3],
                        'total_actual_encroachment_area_kranti' => 0,
                        'settlement_area_home_bigha'            => $fmd['home_b'],
                        'settlement_area_home_katha'            => $fmd['home_k'],
                        'settlement_area_home_lessa'            => $fmd['home_lc'],
                        'settlement_area_home_ganda'            => $fmd['home_g'],
                        'settlement_area_home_kranti'           => $fmd['home_kr'],
                        'settlement_area_agri_bigha'            => $fmd['agri_b'],
                        'settlement_area_agri_katha'            => $fmd['agri_k'],
                        'settlement_area_agri_lessa'            => $fmd['agri_lc'],
                        'settlement_area_agri_ganda'            => $fmd['agri_g'],
                        'settlement_area_agri_kranti'           => $fmd['agri_kr'],
                        'total_settlement_area_bigha'           => $totalSettlementAreaArr[0],
                        'total_settlement_area_katha'           => $totalSettlementAreaArr[1],
                        'total_settlement_area_lessa'           => $totalSettlementAreaArr[2],
                        'total_settlement_area_ganda'           => $totalSettlementAreaArr[3],
                        'total_settlement_area_kranti'          => 0,
                        'leftout_area_home_bigha'               => $leftOutAreaHomeArr[0],
                        'leftout_area_home_katha'               => $leftOutAreaHomeArr[1],
                        'leftout_area_home_lessa'               => $leftOutAreaHomeArr[2],
                        'leftout_area_home_ganda'               => $leftOutAreaHomeArr[3],
                        'leftout_area_home_kranti'              => 0,
                        'leftout_area_agri_bigha'               => $leftOutAreaAgriArr[0],
                        'leftout_area_agri_katha'               => $leftOutAreaAgriArr[1],
                        'leftout_area_agri_lessa'               => $leftOutAreaAgriArr[2],
                        'leftout_area_agri_ganda'               => $leftOutAreaAgriArr[3],
                        'leftout_area_agri_kranti'              => 0,
                        'total_leftout_area_bigha'              => $totalLeftOutAreaArr[0],
                        'total_leftout_area_katha'              => $totalLeftOutAreaArr[1],
                        'total_leftout_area_lessa'              => $totalLeftOutAreaArr[2],
                        'total_leftout_area_ganda'              => $totalLeftOutAreaArr[3],
                        'total_leftout_area_kranti'             => 0,
                    ];

                    $insertSetlArea = $this->db->insert('settlement_area_history', $settlementAreaHistoryArr);

                    if ($insertSetlArea != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#SETLARRHIS0001: Insertion failed in settlement_area_history RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#SETLARRHIS0001: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }

                //*******pdar_cron number generation */
                $sql = "SELECT pdar_cron_no FROM settlement_applicant WHERE case_no = '".$case_no['case_no']."'";
                $result = $this->db->query($sql);
                if($result->num_rows() > 0){
                    $cron_no = (int)$result->row()->pdar_cron_no + 1;
                }else{
                    $cron_no = 1;
                }

                //*********settlement_applicant insertion */
                foreach ($district['applicants'] as $setl)
                {
                    if ($get_aadhaar_photo != 'n' && $setl->is_applicant == '1')
                    {
                        $timestamp = date('mdYhis', time()).uniqid();
                        $identity_doc_unique_name = str_replace('/', "-", $application_no.'_'.$timestamp);
                        // creating and saving the base64 format payment notice to uploads/paymentNotice folder
                        $aadhar_path = AADHAAR_PHOTO . $identity_doc_unique_name . ".json";
                        $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file!");
                        $aadhaar_encoded_file = $get_aadhaar_photo;
                        fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                        fclose($aadhaar_file_to_write_base64);
                    }else{
                        $aadhar_path = '';
                    }

                    if($district['aadhar']->type == 'AADHAAR'){
                        $identity_ref_no = $district['aadhar']->aadhaar_no;
                    }else{
                        $identity_ref_no = $district['aadhar']->pan_no;
                    }

                    $applicant=array(
                        'dist_code'          => $district['app']->dist_code,
                        'subdiv_code'        => $district['app']->subdiv_code,
                        'cir_code'           => $district['app']->cir_code,
                        'mouza_pargona_code' => $district['app']->mouza_code,
                        'lot_no'             => $district['app']->lot_no,
                        'vill_townprt_code'  => $district['app']->village_code,
                        'user_code'          => $this->session->userdata('user_code'),
                        'case_no'            => $case_no['case_no'],
                        'petition_no'        => $case_no['petition_no'],
                        'operation'          =>'E',
                        'dag_no'             => 0,
                        'patta_no'           => 0,
                        'patta_type_code'    => 0,
                        'year_no'            => date('Y'),
                        'date_entry'         => date('Y-m-d'),
                        'pdar_id'            => '-1',
                        'pdar_cron_no'       => (int) $cron_no++,
                        'pdar_name'          => $setl->name_ass,
                        'pdar_guardian'      => $setl->gurdian_name_ass,
                        'eng_pdar_name'      => $setl->name_eng,
                        'eng_pdar_guardian'  => $setl->gurdian_name_eng,
                        'pdar_rel_guar'      => $setl->gurdian_relation_id,
                        'pdar_gender'        => $setl->gender,
                        'pdar_add1'          => $setl->pre_add,
                        'pdar_add2'          => $setl->per_add,
                        'pdar_mobile'        => $setl->mobile,
                        'pdar_type'          => $setl->pdar_type,
                        'is_applicant'       => $setl->is_applicant,
                        'identity_ref_no'    => $identity_ref_no,
                        'identity_type'      => $district['aadhar']->type,
                        'identity_doc_link'  => $aadhar_path,
                        'marital_status'     => $setl->marital_status,
                        'dob'                => $setl->dob,
                    );

                    $insSetApplicant = $this->db->insert('settlement_applicant', $applicant);

                    if ($insSetApplicant != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERR903: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#ERR903: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }

                //*********encroachers insert in applicant table */
                if($output->encroachers == true)
                {
                    foreach($output->encroachers as $enc_applicant){
                        $encroacher_app = array(
                            'dist_code'             => $district['app']->dist_code,
                            'subdiv_code'           => $district['app']->subdiv_code,
                            'cir_code'              => $district['app']->cir_code,
                            'mouza_pargona_code'    => $district['app']->mouza_code,
                            'lot_no'                => $district['app']->lot_no,
                            'vill_townprt_code'     => $district['app']->village_code,
                            'user_code'             => $this->session->userdata('user_code'),
                            'case_no'               => $case_no['case_no'],
                            'petition_no'           => $case_no['petition_no'],
                            'operation'             => 'E',
                            'dag_no'                => $enc_applicant->dag_no,
                            'patta_no'              => $enc_applicant->patta_no,
                            'patta_type_code'       => $enc_applicant->patta_code,
                            'period_possession'     => $enc_applicant->possession_date,
                            'year_no'               => date('Y'),
                            'date_entry'            => date('Y-m-d'),
                            'pdar_name'             => $enc_applicant->name_ass,
                            'pdar_guardian'         => $enc_applicant->gurdian_name_ass,
                            'pdar_rel_guar'         => '0',
                            'pdar_cron_no'          => (int) $cron_no++,
                            'pdar_id'               => -1,
                            'pdar_type'             => 'EN',
                            'enc_id'                => $enc_applicant->encroacher_id,
                        );
                        $insSetEncroacher = $this->db->insert('settlement_applicant',$encroacher_app);

                        if ($insSetEncroacher != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#ERR949: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                            $data = array(
                                'error'=>"#ERR949: Registration of Settlement failed for case no : ".$application_no
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }
                }

                ///// nominee add start /////
                if ($output->nextKin == true) {
                    foreach ($output->nextKin as $nex_of_kin) {
                        $nominee_data=array(
                            'case_no'      => $case_no['case_no'],
                            'nominee_name' => $nex_of_kin->next_of_kin_name,
                            'address'      => $nex_of_kin->address,
                            'mobile_no'    => $nex_of_kin->mobile_no,
                            'relation'     => $nex_of_kin->relation_with_kin
                        );
                        $insNominee = $this->db->insert('settlement_nominee', $nominee_data);
                        if ($insNominee != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#ERR972: Insertion failed in settlement_nominee RTPS Case No '.$application_no);
                            $data = array(
                                'error'=>"#ERR972: Registration of Settlement failed for case no : ".$application_no
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }
                }
                ///// nominee end //////

                //********basundhar_application insertation */
                $basundhara=array(
                    'dharitree'   => $case_no['case_no'],
                    'basundhara'  => $application_no,
                    'date_reg'    => date('Y-m-d'),
                    'reg_by'      => $this->session->userdata('user_code'),
                    'app_status'  => 'M',
                    'pending_with'=> 'LM'
                );
                $basundhar_app = $this->db->insert('basundhar_application',$basundhara);

                if ($basundhar_app != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERR992: Insertion failed in basundhar_application RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERR992: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }else{
                    $this->db->trans_commit();
                }
            }

            $sql = "Select case_no from settlement_basic where applid='$application_no' ";
            $case = $this->db->query($sql)->row();
            $application_no = $case_no = $case->case_no;

            $proceedings = $this->SettlementCommonDcModel->getSettlementProceeding($case_no);
            $basic = $this->SettlementKhasModel->getSettlementBasic($application_no);
            $applicants_buyers = $this->SettlementKhasModel->getAllApplicantBuyers($application_no);
            $applicants_owners = $this->SettlementKhasModel->getAllApplicantOwners($application_no);
            $applicants_encroacher = $this->SettlementKhasModel->getAllApplicantEncroacher($application_no);
            $applicants_riotee_nok = $this->SettlementKhasModel->getAllApplicantRioteeNok($application_no);

            $dags = $this->SettlementKhasModel->getSettlementDag($application_no);
            $lmnotes = $this->SettlementKhasModel->getSettlementTenantLmNote($application_no);
            $dhardocuments = $this->SettlementKhasModel->getDocuments($application_no);

            $lmdata=[];
            foreach($applicants_encroacher as $encroacher)
            {
                // getting the encroacher details
                $query="select * from c_land_bank_encroacher_details where id=$encroacher->enc_id";
                $encdata=$this->db->query($query)->result();
                $lmdata[] = $encdata;

            }
            $data['encdata']=$lmdata;

            $data['basic']=$basic;

            $reservation = $this->SettlementMbModel->getSettlementReservation($application_no);
            $data['reservation']=$reservation;
            $data['applicants_buyers']=$applicants_buyers;
            $data['applicants_owners']=$applicants_owners;
            $data['applicants_encroacher']=$applicants_encroacher;
            $data['applicants_riotee_nok']=$applicants_riotee_nok;

            $data['dags']=$dags;
            $data['lmnotes']=$lmnotes;
            $data['dhardocuments']=$dhardocuments;

            // for guardian relation
            $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
            $relation_executation = $this->db->query($query_for_guar_rel);
            $row = $relation_executation->num_rows;
            if ($row != 0) {
                $data['guar_rel'] = $relation_executation->result();
            }
            $premium_data = $this->db->query("SELECT * from settlement_premium where case_no='$application_no' and is_final=1")->result();
            $data['premium_data'] = $premium_data;
            $data['premium'] = $this->db->query("SELECT *  from settlement_premium where case_no='$application_no' and is_final=1")->result();
            //$data['caseCount']   = $caseCount;
            //$data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;

            //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
            $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($case_no);
            $deletedEncArray = array();
            foreach($deletedEnc as $encroacherDeleted_data)
            {
                $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
            }
            $data['deleted_encroacher'] = $deletedEncArray;


            //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
            $deletedDags=$this->SettlementCommonModel->getDeletedDags($case_no);
            $deletedData = array();
            foreach($deletedDags as $deleteDag){
                $deletedData[] = json_decode($deleteDag->table_data);
            }
            $data['deleted_dags'] = $deletedData;
            $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_KHAS_LAND_ID);
            if($rejected_data == 'n')
            {
                $data['rejected_list'] = false;
            }
            else
            {
                $data['rejected_list'] = $rejected_data;
            }

            //**************new */
            foreach(json_decode(VALIDATION_BYPASS) as $val_bypas)
            {
                if($val_bypas->SERVICE_CODE == SLIJE_ID)
                {
                    $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
                }
            }
            $data['validation_bypass'] = 0;

            foreach($data['lmnotes'] as $lm_rr)
            {
                $decoded_r = json_decode($lm_rr->lm_rejected_remarks);

                if($decoded_r){
                    foreach($decoded_r as  $lm_rejected_code)
                    {
                        if(isset($lm_rejected_code->reject_code))
                        {
                            if(in_array($lm_rejected_code->reject_code, $const_bypass_arr_code)){
                                $data['validation_bypass'] = 1;
                            }
                        }
                        else
                        {
                            if(in_array($lm_rejected_code, $const_bypass_arr_code)){
                                $data['validation_bypass'] = 1;
                            }
                        }

                    }
                }

            }

            $data['reject_list_type'] = '';

            foreach($lmnotes as $r_remark)
            {
                $rejected_list_json = json_decode($r_remark->lm_rejected_remarks);

                if($rejected_list_json)
                {
                    foreach ($rejected_list_json as $re_list) {

                        if(isset($re_list->reject_code))
                        {
                            $r_code = $re_list->reject_code;
                        }
                        else
                        {
                            $r_code = $re_list;
                        }

                        $sql = $this->db->query("select remark_head from reject_master where reject_code = ?", array($r_code));

                        if($sql->row()->remark_head != null)
                        {
                            $data['reject_list_type'] = 'new';
                        }
                        else
                        {
                            $data['reject_list_type'] = 'old';
                        }
                    }
                }
            }

            $newDagCount = $this->db->query("SELECT old_dag, new_dag FROM chitha_settlement_allottee WHERE ord_no = ? 
                               GROUP BY old_dag, new_dag", array($application_no));

            if($newDagCount->num_rows()!= 0)
            {
                $data['newDagCount'] = 1;
                $data['newDags']     = $newDagCount->result();
            }
            else
            {
                $data['newDagCount'] = 0;
                $data['newDags']     = '';
            }
            $sql = $this->db->query('select sid.*,imc.category_name from settlement_institution_details sid join ins_master_category imc on sid.ins_cat_type::int = imc.id  where case_no = ?', array($application_no));

            $data['ins_data'] = $sql->result();
            $data['instituteDetails'] = $this->SettlementInsModel->getInstitutionDetails($application_no);


            $data['_view'] = 'settlementView/Dc/Common/application_details_common_bhoodan_allcases';
            $this->load->view('layouts/main', $data);


        }

        if($service_code == TEA_SERVICE_CODE)
        {

            $geo_date_query = $this->db->query("SELECT date_entry FROM supportive_document WHERE applid='$application_no'")->row();
            $geo_date = isset($geo_date_query->date_entry)? $geo_date_query->date_entry : '.....';

            // $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE applid = ? AND file_name = ? ", array($application_no, GEO_TAG_PHOTO) );
            $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE id in (SELECT max(id) FROM supportive_document WHERE applid=? and dag_no is not null and file_name=? GROUP BY applid, dag_no)", array($application_no, GEO_TAG_PHOTO));

            if($supportive_document_sql->num_rows() > 0)
            {
                $codata['geo_tag_doc'] = $supportive_document_sql->result();
            }
            else
            {
                $codata['geo_tag_doc_empty'] = "<span class='text-danger alert-danger'><b>Geo tag photo yet to be uploaded.</b></span>";
            }

            if(!$recordExist)
            {
                /// additional property for LM note
                $additional_property = $this->db->query("SELECT * FROM      settlement_additional_property WHERE applid='$application_no'");
                if($additional_property->num_rows() > 0){
                    $totallesaa=0;
                    $totalganda=0;
                    foreach($additional_property->result() as $addprop){
                        if(in_array($addprop->dist_code, json_decode(BARAK_VALLEY))){
                            $total_g=$this->utilityclass->Total_ganda($addprop->bigha,$addprop->katha,$addprop->lessa,$addprop->ganda);
                            $totalganda = $totalganda+$total_g;
                        }else{
                            $total_l=$this->utilityclass->Total_Lessa($addprop->bigha,$addprop->katha,$addprop->lessa);
                            $totallesaa = $totallesaa+$total_l;
                        }

                    }
                    if(!empty($totallesaa)){
                        $district['total_aditional_area']= $this->utilityclass->Total_Bigha_Katha_Lessa($totallesaa);
                    }
                    if(!empty($totalganda)){
                        $district['total_aditional_area_g']= $this->utilityclass->Total_Bigha_Katha_Lessa2($totalganda);
                    }
                    $district['additional_property']=$additional_property->result();
                    //var_dump($district['additional_property']); die;
                }

                $token = $this->utilityclass->createTokenJwt();
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."getAppDetails");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    'application_no' => $application_no,
                    'api_key'        => API_KEY,
                    'token'          => $token
                )));

                $output = curl_exec($curl_handle);
                if(isset(json_decode($output)->responseType)){
                    if(json_decode($output)->responseType == 3){
                        echo json_decode($output)->data." - Unauthorized access!";
                        return false;
                    }
                }
                curl_close($curl_handle);
                $backup = $output;
                $output = json_decode($output);

                // echo "<pre>";var_dump($backup); die;

                //****************generate case number********************
                $case_name=$this->SettlementApiModel->genearteCaseName();
                if(empty($case_name))
                {
                    $data = array(
                        'error' => "Network Issue or Session Out. Please try Again"
                    );
                    echo json_encode($data);
                    die();
                }
                //*******generating petition_no and case_no */
                $case_no['petition_no'] = $petition_no=$this->SettlementApiModel->genearteSettlementPetitionNo();
                $case_no['case_no']     = $case_name.$petition_no."/".TEA_PREFIX;
                $district['geo_date']   = $geo_date;
                $district['app']        = $output->application;
                $district['pattaNo']    = $this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$district['app']->dag_no);

                $district['applicants']   = $output->applicants;
                $district['document']     = $output->documents;
                $district['query']        = $output->query;
                $district['property']     = $output->property;
                $district['settlements']  = $output->settlements;
                $district['owners']       = $output->owners;
                $district['aadhar']       = $output->aadhar;
                $district['nextKin']      = $output->nextKin;
                $district['teaDagDetail'] = $output->teadags;

                // get khatian number
                $d   = $district['app']->dist_code;
                $s   = $district['app']->subdiv_code;
                $c   = $district['app']->cir_code;
                $m   = $district['app']->mouza_code;
                $l   = $district['app']->lot_no;
                $v   = $district['app']->village_code;
                $dag = $district['app']->dag_no;

                $district['co_name']= $this->SettlementCommonModel->getCoName($d, $s, $c);
                $district['s_area'] = $this->SettlementCommonModel->getPremiumArea();

                $district['bhumi']  = $output->bhumi;

                // for guardian relation
                $query_for_guar_rel = "SELECT * FROM master_guard_rel WHERE id NOT IN ('5','6')";

                $relation_executation = $this->db->query($query_for_guar_rel);
                $row = $relation_executation->num_rows();

                if ($row != 0) {
                    $district['guar_rel'] = $relation_executation->result();
                }

                // $district['selfDeclarationDetails'] = $output->selfDeclaration;
                foreach($output->selfDeclaration as $selfDec){
                    $district['selfDeclarationDetails']=json_decode($selfDec->dec_details);
                }

                // aadhaar photo api
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."getApplicantPhoto");

                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    'application_no' => $application_no,
                )));
                $get_aadhaar_photo = curl_exec($curl_handle);
                curl_close($curl_handle);

                if($get_aadhaar_photo != 'n'){
                    $district['aadhaar_b64_decoded'] = "<img src = data:".$this->decodeBase64($get_aadhaar_photo).";base64,".$get_aadhaar_photo." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
                }

                $this->db->trans_begin();

                // insertion in backup table (lm)
                $backup_array = [
                    'applid'  => $application_no,
                    'case_no' => $case_no['case_no'],
                    'status'  => 'I',
                    'data'    => $backup
                ];

                $backup_insertion = $this->db->insert('settlement_backup_json', $backup_array);

                if($backup_insertion != 1){
                    $this->db->trans_rollback();
                    log_message('error', '#BACKUP001: Insertion failed in settlement_backup_json RTPS Case No '.$application_no);

                    $this->session->set_flashdata('message', "#BACKUP001: Registration of Settlement failed for case no : ".$application_no);
                    redirect(base_url() . "index.php/home");
                    return false;
                }

                ///////// additional property starts here
                $checkAdditionalProperty = $this->db->query("SELECT * FROM 
                                            settlement_additional_property 
                                              WHERE applid=?", array($application_no));

                if($checkAdditionalProperty->num_rows() == 0) {
                    if(isset($output->property)) {
                        foreach($output->property as $value) {
                            $add_property = array(
                                'case_no'            => $case_no['case_no'],
                                'dist_code'          => $value->dist_code,
                                'subdiv_code'        => $value->subdiv_code,
                                'cir_code'           => $value->cir_code,
                                'mouza_pargona_code' => $value->mouza_pargona_code,
                                'lot_no'             => $value->lot_no,
                                'vill_townprt_code'  => $value->vill_townprt_code,
                                'bigha'              => $value->bigha,
                                'katha'              => $value->katha,
                                'lessa'              => $value->lessa,
                                'chatak'             => $value->lessa,
                                'ganda'              => $value->ganda,
                                'kranti'             => $value->kranti,
                                'entry_date'         => date('Y-m-d h:i:s'),
                                'is_rural'           => $value->is_rural,
                                'dag_no'             => $value->dag_no,
                                'patta_no'           => $value->patta_no,
                                'service_id'         => TEA_SERVICE_CODE,
                                'applied_flag'       => CITIZEN,
                                'dist_name'          => trim($value->dist_name),
                                'cir_name'           => trim($value->cir_name),
                                'vill_name'          => trim($value->vill_name),
                                'applid'             => $application_no,
                            );
                            $insAddProperty = $this->db->insert('settlement_additional_property', $add_property);

                            if($insAddProperty != 1) {
                                $this->db->trans_rollback();
                                log_message('error', '#ERROR393: Insertion failed in settlement_additional_property RTPS Case No '.$application_no);
                                $data = array(
                                    'error'=>"#ERROR393: Registration of Settlement failed for case no : ".$application_no
                                );
                                echo json_encode($data);
                                return false;
                            }
                        }
                    }
                }
                ///////// additional property ends here

                $pro_class          = $this->input->post('protected_class');
                $protected_class_vr = ($pro_class==null || $pro_class=='' || $pro_class==0) ? 0 : $this->input->post('protected_class');

                //****bhumiputra condition prepare for insertation */
                // if(!empty($output->bhumi['0'])) {
                //   if($output->bhumi['0']->bhumi_cert_available == 1){ //if bhumiputra available
                //     $bhumiputra_confirmation     = 'YES';
                //     $bhumiputra_certificate_no   = $output->bhumi['0']->bhumi_ack_no;
                //     $bhumiputra_certificate_type = 'CERT';
                //   }
                //   else if($output->bhumi['0']->is_bhumi_applied == 1){ //if applied in bhumiputra
                //     $bhumiputra_confirmation     = 'YES';
                //     $bhumiputra_certificate_no   = $output->bhumi['0']->bhumi_ack_no;
                //     $bhumiputra_certificate_type = 'ACK';
                //   }
                //   else {
                //     $bhumiputra_confirmation     = '0';
                //     $bhumiputra_certificate_no   = '0';
                //     $bhumiputra_certificate_type = '0';
                //   }
                // }
                // else {
                //   $bhumiputra_confirmation     = '0';
                //   $bhumiputra_certificate_no   = '0';
                //   $bhumiputra_certificate_type = '0';
                // }

                //********settlement_basic insertation */
                $basic=array(
                    'dist_code'                   => $district['app']->dist_code,
                    'subdiv_code'                 => $district['app']->subdiv_code,
                    'cir_code'                    => $district['app']->cir_code,
                    'mouza_pargona_code'          => $district['app']->mouza_code,
                    'lot_no'                      => $district['app']->lot_no,
                    'vill_townprt_code'           => $district['app']->village_code,
                    'service_code'                => $district['app']->service_code,
                    'ref_no'                      => $district['app']->ref_no,
                    'case_no'                     => $case_no['case_no'],
                    'trans_code'                  => 'F',/////////full
                    'petition_no'                 => $case_no['petition_no'],
                    'year_no'                     => date('Y'),
                    'date_entry'                  => date('Y-m-d G:i:s'),
                    'status'                      => 'ZC',
                    'user_code'                   => $this->session->userdata('user_code'),
                    'submission_date'             => date('Y-m-d G:i:s'),
                    'from_office'                 => 'API',
                    'pending_officer'             => 'CO',
                    'pending_office'              => 'CO',
                    'occupation_applicant'        => $district['applicants'][0]->occupation,
                    'applid'                      => $district['app']->application_no,
                    'caste'                       => $district['applicants'][0]->caste,
                    'uuid'                        => $district['app']->uuid,
                    'protected_class'             => $protected_class_vr,
                    // 'applicant_applied_on'        => $district['app']->applicant_applied_on,
                    // 'bhumiputra_confirmation'     => $bhumiputra_confirmation,
                    // 'bhumiputra_certificate_no'   => $bhumiputra_certificate_no,
                    // 'bhumiputra_certificate_type' => $bhumiputra_certificate_type,
                );

                $insSetBasic = $this->db->insert('settlement_basic', $basic);
                // echo $this->db->last_query(); die();

                if ($insSetBasic != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET00011: Insertion failed in settlement_basic RTPS Case No '.$application_no);

                    $data = array(
                        'error'=>"#ERRSET00011: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }

                // echo "<pre>"; var_dump($district['teaDagDetail']); die;

                ////settlement_dag_details insert start
                if ($district['teaDagDetail'] == false || empty($district['teaDagDetail']) || $district['teaDagDetail'] == '') {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET00443: Insertion failed settlement_dag details empty RTPS Case No '.$application_no);

                    $data = array(
                        'error'=>"#ERRSET00443: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
                foreach ($district['teaDagDetail'] as $dags) {

                    // var_dump($dags); die;

                    $district['class']=$this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code, $dags->dag_no);

                    // var_dump($district['class']); die;

                    $applied_bigha  = $dags->bigha;
                    $applied_katha  = $dags->katha;
                    $applied_lessa  = $dags->lessa;
                    $applied_ganda  = $dags->ganda;
                    $applied_kranti = $dags->kranti;

                    $applied_area = [
                        'applied_bigha'  => $dags->bigha,
                        'applied_katha'  => $dags->katha,
                        'applied_lessa'  => $dags->lessa,
                        'applied_ganda'  => $dags->ganda,
                        'applied_kranti' => $dags->kranti,
                    ];

                    // echo "<pre>"; var_dump($dags); die;

                    $fmd = array(
                        'dist_code'           => $district['app']->dist_code,
                        'subdiv_code'         => $district['app']->subdiv_code,
                        'cir_code'            => $district['app']->cir_code,
                        'mouza_pargona_code'  => $district['app']->mouza_code,
                        'lot_no'              => $district['app']->lot_no,
                        'vill_townprt_code'   => $district['app']->village_code,
                        'user_code'           => $this->session->userdata('user_code'),
                        'date_entry'          => date('Y-m-d'),
                        'case_no'             => $case_no['case_no'],
                        'petition_no'         => $case_no['petition_no'],
                        'year_no'             => date('Y'),
                        'new_land_class_code' => $district['class']->land_class_code,
                        'dag_no'              => $dags->dag_no,
                        'patta_no'            => $dags->patta_no,
                        'patta_type_code'     => $dags->patta_type_code,
                        'is_urban'            => $district['app']->is_urban,
                        'land_type'           => 0,
                        'revenue'             => 0,
                        'operation'           => 'E',
                        'encroachement_area'  => json_encode($applied_area),
                    );

                    $fmd['dag_area_b']  = $dags->chitha_bigha;
                    $fmd['dag_area_k']  = $dags->chitha_katha;
                    $fmd['dag_area_lc'] = $dags->chitha_lessa;
                    $fmd['dag_area_g']  = $dags->chitha_ganda;
                    $fmd['dag_area_kr'] = $dags->chitha_kranti;

                    $fmd['applied_b']   = $dags->bigha;
                    $fmd['applied_k']   = $dags->katha;
                    $fmd['applied_lc']  = $dags->lessa;
                    $fmd['applied_g']   = $dags->ganda;
                    $fmd['applied_kr']  = $dags->kranti;

                    //************Total Area Calculation -js- ******************
                    if(in_array($district['app']->dist_code, json_decode(BARAK_VALLEY)))
                    {
                        //******for Barak valley */
                        $appliedArea    = $this->utilityclass->Total_ganda($fmd['applied_b'],$fmd['applied_k'],$fmd['applied_lc'],$fmd['applied_g'],$fmd['applied_kr']);
                        $totalAreaGanda = (float)$appliedArea;
                        $totalAreaArr   = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalAreaGanda);
                    }
                    else
                    {
                        $appliedArea    = $this->utilityclass->Total_Lessa($fmd['applied_b'],$fmd['applied_k'],$fmd['applied_lc']);
                        $totalAreaLessa = (float)$appliedArea;
                        $totalAreaArr   = $this->utilityclass->Total_Bigha_Katha_Lessa($totalAreaLessa);
                    }

                    $fmd['s_dag_area_b']  = $totalAreaArr[0];
                    $fmd['s_dag_area_k']  = $totalAreaArr[1];
                    $fmd['s_dag_area_lc'] = $totalAreaArr[2];
                    $fmd['s_dag_area_g']  = $totalAreaArr[3];
                    $fmd['s_dag_area_kr'] = 0;

                    $landTypeUpdate = 0;

                    $insSetDag = $this->db->insert('settlement_dag_details', $fmd);
                    // echo $this->db->last_query();die;
                    // log_message('error',$this->db->last_query());

                    if ($insSetDag != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET0002: Insertion failed in settlement_dag_details RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#ERRSET0002: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }

                    //*******insertion in settlement_area_history**************
                    if (in_array($district['app']->dist_code, json_decode(BARAK_VALLEY)))
                    {
                        //***********actual Encroachment area ***************
                        $actual_applied_area_ganda = $this->utilityclass->Total_ganda($applied_bigha,$applied_katha,$applied_lessa,$applied_ganda);

                        //***********total Actual Encroachment area*****************
                        $total_actual_applied_area_ganda = (float)$actual_applied_area_ganda;
                        $totalAppliedAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_actual_applied_area_ganda);
                        // **********************************************


                        //***********Settlement area that applicant will get settlement on***********
                        $total_settlement_ganda_tea_grant = $this->utilityclass->Total_ganda($applied_bigha,$applied_katha,$applied_lessa,$applied_ganda);

                        //*****total Settlement area *************/
                        $total_settlement_ganda = (float)$total_settlement_ganda_tea_grant;
                        $totalSettlementAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_settlement_ganda);

                        //*************leftout area **************
                        $leftOutAreaTeaGrantGanda = (float)$actual_applied_area_ganda - (float)$total_actual_applied_area_ganda;
                        $leftOutAreaTeaGrantArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($leftOutAreaTeaGrantGanda);

                        //**********Total left out area***************
                        $totalLeftOutAreaGanda = (float)$total_actual_applied_area_ganda - (float)$total_settlement_ganda;
                        $totalLeftOutAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalLeftOutAreaGanda);
                    }
                    else
                    {
                        //***********actual Encroachment area ***************
                        $actual_applied_area_lessa = $this->utilityclass->Total_Lessa($applied_bigha,$applied_katha,$applied_lessa);

                        //***********total Actual Encroachment area*****************
                        $total_actual_applied_area_lessa = (float)$actual_applied_area_lessa;
                        $totalAppliedAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_actual_applied_area_lessa);
                        // **********************************************


                        //***********Settlement area that applicant will get settlement on***********
                        $total_settlement_lessa_tea_grant = $this->utilityclass->Total_Lessa($applied_bigha,$applied_katha,$applied_lessa);

                        //*************Total settlement area */
                        $total_settlement_lessa = (float)$total_settlement_lessa_tea_grant;
                        $totalSettlementAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_settlement_lessa);

                        //****************leftout area homestead**************
                        $leftOutAreaTeaGrantLessa = (float)$actual_applied_area_lessa - (float)$total_settlement_lessa_tea_grant;
                        $leftOutAreaTeaGrantArr = $this->utilityclass->Total_Bigha_Katha_Lessa($leftOutAreaTeaGrantLessa);

                        //**********Total left out area***************
                        $totalLeftOutArealessa = (float)$total_actual_applied_area_lessa - (float)$total_settlement_lessa;
                        $totalLeftOutAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($totalLeftOutArealessa);
                    }

                    $settlementAreaHistoryArr = [
                        'application_no'                        => $application_no,
                        'case_no'                               => $case_no['case_no'],
                        'dag_no'                                => $dags->dag_no,
                        'uuid'                                  => $district['app']->uuid,
                        'created_at'                            => date('Y-m-d'),
                        'applied_area_home_bigha'               => $dags->bigha,
                        'applied_area_home_katha'               => $dags->katha,
                        'applied_area_home_lessa'               => $dags->lessa,
                        'applied_area_home_ganda'               => $dags->ganda,
                        'applied_area_home_kranti'              => $dags->kranti,
                        'applied_area_agri_bigha'               => 0,
                        'applied_area_agri_katha'               => 0,
                        'applied_area_agri_lessa'               => 0,
                        'applied_area_agri_ganda'               => 0,
                        'applied_area_agri_kranti'              => 0,
                        'actual_encroachment_area_home_bigha'   => $dags->bigha,
                        'actual_encroachment_area_home_katha'   => $dags->katha,
                        'actual_encroachment_area_home_lessa'   => $dags->lessa,
                        'actual_encroachment_area_home_ganda'   => $dags->ganda,
                        'actual_encroachment_area_home_kranti'  => $dags->kranti,
                        'actual_encroachment_area_agri_bigha'   => 0,
                        'actual_encroachment_area_agri_katha'   => 0,
                        'actual_encroachment_area_agri_lessa'   => 0,
                        'actual_encroachment_area_agri_ganda'   => 0,
                        'actual_encroachment_area_agri_kranti'  => 0,
                        'total_actual_encroachment_area_bigha'  => $totalAppliedAreaArr[0],
                        'total_actual_encroachment_area_katha'  => $totalAppliedAreaArr[1],
                        'total_actual_encroachment_area_lessa'  => $totalAppliedAreaArr[2],
                        'total_actual_encroachment_area_ganda'  => $totalAppliedAreaArr[3],
                        'total_actual_encroachment_area_kranti' => 0,
                        'settlement_area_home_bigha'            => $dags->bigha,
                        'settlement_area_home_katha'            => $dags->katha,
                        'settlement_area_home_lessa'            => $dags->lessa,
                        'settlement_area_home_ganda'            => $dags->ganda,
                        'settlement_area_home_kranti'           => $dags->kranti,
                        'settlement_area_agri_bigha'            => 0,
                        'settlement_area_agri_katha'            => 0,
                        'settlement_area_agri_lessa'            => 0,
                        'settlement_area_agri_ganda'            => 0,
                        'settlement_area_agri_kranti'           => 0,
                        'total_settlement_area_bigha'           => $totalSettlementAreaArr[0],
                        'total_settlement_area_katha'           => $totalSettlementAreaArr[1],
                        'total_settlement_area_lessa'           => $totalSettlementAreaArr[2],
                        'total_settlement_area_ganda'           => $totalSettlementAreaArr[3],
                        'total_settlement_area_kranti'          => 0,
                        'leftout_area_home_bigha'               => $leftOutAreaTeaGrantArr[0],
                        'leftout_area_home_katha'               => $leftOutAreaTeaGrantArr[1],
                        'leftout_area_home_lessa'               => $leftOutAreaTeaGrantArr[2],
                        'leftout_area_home_ganda'               => $leftOutAreaTeaGrantArr[3],
                        'leftout_area_home_kranti'              => 0,
                        'leftout_area_agri_bigha'               => 0,
                        'leftout_area_agri_katha'               => 0,
                        'leftout_area_agri_lessa'               => 0,
                        'leftout_area_agri_ganda'               => 0,
                        'leftout_area_agri_kranti'              => 0,
                        'total_leftout_area_bigha'              => $totalLeftOutAreaArr[0],
                        'total_leftout_area_katha'              => $totalLeftOutAreaArr[1],
                        'total_leftout_area_lessa'              => $totalLeftOutAreaArr[2],
                        'total_leftout_area_ganda'              => $totalLeftOutAreaArr[3],
                        'total_leftout_area_kranti'             => 0,
                    ];

                    $insertSetlArea = $this->db->insert('settlement_area_history', $settlementAreaHistoryArr);

                    if ($insertSetlArea != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#SETLARRHIS0001: Insertion failed in settlement_area_history RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#SETLARRHIS0001: Registration of Settlement failed for case no : ".$application_no,
                        );
                        echo json_encode($data);
                        return false;
                    }
                    //**************end of settlement_area_history********************
                }

                //*******pdar_cron number generation */
                $sql = "SELECT pdar_cron_no FROM settlement_applicant WHERE case_no = '".$case_no['case_no']."'";
                $result = $this->db->query($sql);
                if($result->num_rows() > 0){
                    $cron_no = (int)$result->row()->pdar_cron_no + 1;
                }else{
                    $cron_no = 1;
                }



                //*********settlement_applicant insertion */
                foreach ($district['applicants'] as $setl)
                {
                    if($setl->is_applicant == 1)
                    {
                        $present_add   = $setl->entered_add1;
                        $permanent_add = $setl->entered_add2;
                        $mobile_no     = $setl->mobile_no;
                    }
                }
                foreach ($district['applicants'] as $setl)
                {
                    if ($get_aadhaar_photo != 'n' && $setl->is_applicant == '1')
                    {
                        $timestamp = date('mdYhis', time()).uniqid();
                        $identity_doc_unique_name = str_replace('/', "-", $application_no.'_'.$timestamp);
                        // creating and saving the base64 format payment notice to uploads/paymentNotice folder
                        $aadhar_path = AADHAAR_PHOTO . $identity_doc_unique_name . ".json";
                        $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file!");
                        $aadhaar_encoded_file = $get_aadhaar_photo;
                        fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                        fclose($aadhaar_file_to_write_base64);
                    }
                    else{
                        $aadhar_path = '';
                    }

                    if($district['aadhar']->type == 'AADHAAR'){
                        $identity_ref_no = $district['aadhar']->aadhaar_no;
                    }else{
                        $identity_ref_no = $district['aadhar']->pan_no;
                    }

                    if($setl->pdar_type == 'B')
                    {
                        $applicant=array(
                            'dist_code'           => $district['app']->dist_code,
                            'subdiv_code'         => $district['app']->subdiv_code,
                            'cir_code'            => $district['app']->cir_code,
                            'mouza_pargona_code'  => $district['app']->mouza_code,
                            'lot_no'              => $district['app']->lot_no,
                            'vill_townprt_code'   => $district['app']->village_code,
                            'user_code'           => $this->session->userdata('user_code'),
                            'case_no'             => $case_no['case_no'],
                            'petition_no'         => $case_no['petition_no'],
                            'operation'           => 'E',
                            'dag_no'              => 0,
                            'patta_no'            => 0,
                            'patta_type_code'     => 0,
                            'year_no'             => date('Y'),
                            'date_entry'          => date('Y-m-d'),
                            'pdar_id'             => '-1',
                            'pdar_cron_no'        => (int) $cron_no++,
                            'pdar_name'           => $setl->pdar_name,
                            'pdar_guardian'       => $setl->pdar_father,
                            'eng_pdar_name'       => $setl->pdar_name_eng,
                            'eng_pdar_guardian'   => $setl->pdar_father_eng,
                            'pdar_rel_guar'       => $setl->relation,
                            'pdar_gender'         => $setl->pdar_gender,
                            'pdar_add1'           => $present_add,
                            'pdar_add2'           => $permanent_add,
                            'pdar_mobile'         => $mobile_no,
                            'pdar_type'           => $setl->pdar_type,
                            'is_applicant'        => $setl->is_applicant,
                            'identity_ref_no'     => $identity_ref_no,
                            'identity_type'       => $district['aadhar']->type,
                            'identity_doc_link'   => $aadhar_path,
                            'marital_status'      => $setl->marital_status,
                            'dob'                 => $setl->dob,
                            'period_possession'   => $setl->is_applicant == 1 ? $setl->possession_from: null,
                        );
                    }

                    $insSetApplicant = $this->db->insert('settlement_applicant', $applicant);
                    // echo $this->db->last_query(); die();

                    if ($insSetApplicant != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET0003: Insertion failed in settlement_applicant RTPS Case No '.$application_no.' and query: '.$this->db->last_query());
                        $data = array(
                            'error'=>"#ERRSET0003: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }

                // insert other pdar type
                // foreach ($district['settlements'] as $setl)
                // {
                //   if($setl->pdar_type != 'B')
                //   {
                //     $otherApplicant=array(
                //       'dist_code'           => $district['app']->dist_code,
                //       'subdiv_code'         => $district['app']->subdiv_code,
                //       'cir_code'            => $district['app']->cir_code,
                //       'mouza_pargona_code'  => $district['app']->mouza_code,
                //       'lot_no'              => $district['app']->lot_no,
                //       'vill_townprt_code'   => $district['app']->village_code,
                //       'user_code'           => $this->session->userdata('user_code'),
                //       'case_no'             => $case_no['case_no'],
                //       'petition_no'         => $case_no['petition_no'],
                //       'operation'           => 'E',
                //       'dag_no'              => empty($setl->dag_no) ? null : $setl->dag_no,
                //       'patta_no'            => empty($setl->patta_no) ? null : $setl->patta_no,
                //       'patta_type_code'     => empty($setl->patta_type_code) ? null : $setl->patta_type_code,
                //       'year_no'             => date('Y'),
                //       'date_entry'          => date('Y-m-d H:i:s'),
                //       'pdar_id'             => '-1',
                //       'pdar_cron_no'        => (int) $cron_no++,
                //       'pdar_name'           => $setl->pdar_name,
                //       'pdar_guardian'       => $setl->pdar_father,
                //       'eng_pdar_name'       => $setl->pdar_name_eng,
                //       'eng_pdar_guardian'   => $setl->pdar_father_eng,
                //       'pdar_rel_guar'       => 0,
                //       'pdar_gender'         => 0,
                //       'pdar_add1'           => $present_add,
                //       'pdar_add2'           => $permanent_add,
                //       'pdar_mobile'         => $mobile_no,
                //       'pdar_type'           => $setl->pdar_type,
                //       'is_applicant'        => $setl->is_applicant,
                //       'identity_ref_no'     => $identity_ref_no,
                //       'identity_type'       => $district['aadhar']->type,
                //       'identity_doc_link'   => '',
                //       'marital_status'      => $setl->marital_status,
                //       'dob'                 => isset($setl->dob) ? $setl->dob : null,
                //     );

                //     $insOtherApplicant = $this->db->insert('settlement_applicant', $otherApplicant);
                //     // echo $this->db->last_query();

                //     if($insOtherApplicant != 1) {
                //       $this->db->trans_rollback();
                //       log_message('error', '#ERRSET2869: Insertion failed in settlement_applicant RTPS Case No '.$application_no.' and query :'.$this->db->last_query());
                //       $data = array(
                //         'error'=>"#ERRSET2869: Registration of Settlement failed for case no : ".$application_no
                //       );
                //       echo json_encode($data);
                //       return false;
                //     }
                //   }
                // }

                if($setl->pdar_type != 'B')
                {
                    $otherApplicant=array(
                        'dist_code'           => $district['app']->dist_code,
                        'subdiv_code'         => $district['app']->subdiv_code,
                        'cir_code'            => $district['app']->cir_code,
                        'mouza_pargona_code'  => $district['app']->mouza_code,
                        'lot_no'              => $district['app']->lot_no,
                        'vill_townprt_code'   => $district['app']->village_code,
                        'user_code'           => $this->session->userdata('user_code'),
                        'case_no'             => $case_no['case_no'],
                        'petition_no'         => $case_no['petition_no'],
                        'operation'           => 'E',
                        'dag_no'              => empty($setl->dag_no) ? '' : $setl->dag_no,
                        'patta_no'            => empty($setl->patta_no) ? '' : $setl->patta_no,
                        'patta_type_code'     => empty($setl->patta_type_code) ? '' : $setl->patta_type_code,
                        'year_no'             => date('Y'),
                        'date_entry'          => date('Y-m-d H:i:s'),
                        'pdar_id'             => '-1',
                        'pdar_cron_no'        => (int) $cron_no++,
                        'pdar_name'           => $setl->pdar_name,
                        'pdar_guardian'       => $setl->pdar_father,
                        'eng_pdar_name'       => $setl->pdar_name_eng,
                        'eng_pdar_guardian'   => $setl->pdar_father_eng,
                        'pdar_rel_guar'       => 0,
                        'pdar_gender'         => 0,
                        'pdar_add1'           => $present_add,
                        'pdar_add2'           => $permanent_add,
                        'pdar_mobile'         => $mobile_no,
                        'pdar_type'           => $setl->pdar_type,
                        'is_applicant'        => $setl->is_applicant,
                        'identity_ref_no'     => $identity_ref_no,
                        'identity_type'       => $district['aadhar']->type,
                        'identity_doc_link'   => '',
                        'marital_status'      => $setl->marital_status,
                        'dob'                 => isset($setl->dob) ? $setl->dob : null,
                    );

                    $insOtherApplicant = $this->db->insert('settlement_applicant', $otherApplicant);
                    // echo $this->db->last_query();

                    if($insOtherApplicant != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET2869: Insertion failed in settlement_applicant RTPS Case No '.$application_no.' and query :'.$this->db->last_query());
                        $data = array(
                            'error'=>"#ERRSET2869: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }

                ///// nominee add start /////
                if ($output->nextKin == true) {
                    // foreach ($_POST['kin_name'] as $key =>$value) {
                    foreach ($output->nextKin as $nex_of_kin) {
                        $nominee_data=array(
                            'case_no'       => $case_no['case_no'],
                            'nominee_name'  => $nex_of_kin->next_of_kin_name,
                            'address'       => $nex_of_kin->address,
                            'mobile_no'     => $nex_of_kin->mobile_no,
                            'relation'      => $nex_of_kin->relation_with_kin
                        );
                        $insNominee = $this->db->insert('settlement_nominee', $nominee_data);

                        if ($insNominee != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRSET00032: Insertion failed in settlement_nominee RTPS Case No '.$application_no);
                            $data = array(
                                'error'=>"#ERRSET00032: Registration of Settlement failed for case no : ".$application_no
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }
                }
                ///// nominee end //////

                //********basundhar_application insertation */
                $basundhara=array(
                    'dharitree'    => $case_no['case_no'],
                    'basundhara'   => $application_no,
                    'date_reg'     => date('Y-m-d'),
                    'reg_by'       => $this->session->userdata('user_code'),
                    'app_status'   => 'M',
                    'pending_with' => 'CO'
                );
                $basundhar_app = $this->db->insert('basundhar_application',$basundhara);

                if ($basundhar_app != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET0003202: Insertion failed in basundhar_application RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRSET0003202: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
                else {
                    $this->db->trans_commit();
                }
            }

            $sql = "Select case_no from settlement_basic where applid='$application_no' ";
            $case = $this->db->query($sql)->row();
            $application_no = $case_no = $case->case_no;
            $dist_code      = $this->session->userdata('dist_code');

            $basic                 = $this->TeaGrantModel->getSettlementBasic($application_no);
            $applicants_buyers     = $this->TeaGrantModel->getAllApplicantBuyers($application_no);
            $applicants_owners     = $this->TeaGrantModel->getAllApplicantOwners($application_no);

            $applicants_dag_details= $this->TeaGrantModel->getAllApplicantDagDetails($application_no);

            $adcdata           = [];
            $dags              = $this->TeaGrantModel->getSettlementDag($application_no);
            $lmnotes           = $this->TeaGrantModel->getSettlementTenantLmNote($application_no);
            $proceedings       = $this->TeaGrantModel->getSettlementProceeding($application_no);
            $dhardocuments     = $this->TeaGrantModel->getDocuments($application_no);
            $nominee           = $this->TeaGrantModel->getAllNomineeDetail($application_no);
            $existing_pattadar = $this->TeaGrantModel->getAllExistingPattadar($application_no);
            $deed_applicant    = $this->TeaGrantModel->getAllDeedPattadar($application_no);
            $family_tree       = $this->TeaGrantModel->getAllFamilyTree($application_no);

            $applier           = $this->TeaGrantModel->getApplierDetail($application_no);

            // for guardian relation
            $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
            $relation_executation = $this->db->query($query_for_guar_rel);
            $row = $relation_executation->num_rows;
            if ($row != 0) {
                $data['guar_rel'] = $relation_executation->result();
            }

            $premium_data                   = $this->SettlementCommonModel->getPremium($application_no);
            $data['premium_data']           = $premium_data;
            $data['premium']                = $premium_data;

            $data['encdata']                = $adcdata;
            $data['basic']                  = $basic;
            $data['applicants_buyers']      = $applicants_buyers;
            $data['applicants_owners']      = $applicants_owners;
            $data['applicants_dag_details'] = $applicants_dag_details;
            $data['dags']                   = $dags;
            $data['lmnotes']                = $lmnotes;
            $data['proceedings']            = $proceedings;
            $data['dhardocuments']          = $dhardocuments;
            $data['nominee']                = $nominee;
            $data['deleted_dags']           = $this->SettlementCommonModel->getDeletedDags($application_no);

            $data['existing_pattadar']      = $existing_pattadar;
            $data['deed_applicant']         = $deed_applicant;
            $data['family_tree']            = $family_tree;

            // $caseCount = $this->TeaGrantAdcModel->countSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
            // if($caseCount == 0)
            // {
            //   //$this->teaGrantAdc();
            // }
            // else
            // {
            $checkAreaDetails = $this->chithaAreaCheckWithCaseNo($case_no);

            $data['chithaArea']    = $checkAreaDetails['chithaArea'];
            $data['reservedArea']  = $checkAreaDetails['reservedArea'];
            $data['areaCheck']     = $checkAreaDetails['areaCheck'];
            $data['appliedDags']   = $checkAreaDetails['appliedDags'];
            $data['lmProcessArea'] = $checkAreaDetails['lmProcessArea'];

            $caseDetails = $this->TeaGrantAdcModel->getSettlementApplicationDetailsByCaseNo($case_no,$dist_code);
            $proceedings         = $this->TeaGrantAdcModel->getSettlementProceeding($case_no);
            // $data['caseCount']   = $caseCount;
            // $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;
            $data['reservation'] = $this->SettlementVgrModel->getSettlementReservation($application_no);
            $data['additional_property'] = $this->TeaGrantModel->getAdditionalProperty($application_no);

            $areaModificationCheck = $this->SettlementCommonModel->checkIfAreaModified($application_no);

            if(isset($areaModificationCheck)){
                if($areaModificationCheck){
                    foreach($areaModificationCheck as $areaHis){
                        $applied_area_home_bigha = $areaHis->applied_area_home_bigha;
                        $applied_area_home_katha = $areaHis->applied_area_home_katha;
                        $applied_area_home_lessa = $areaHis->applied_area_home_lessa;
                        $applied_area_home_ganda = $areaHis->applied_area_home_ganda;
                        $applied_area_home_kranti = $areaHis->applied_area_home_kranti;

                        $applied_area_agri_bigha = $areaHis->applied_area_agri_bigha;
                        $applied_area_agri_katha = $areaHis->applied_area_agri_katha;
                        $applied_area_agri_lessa = $areaHis->applied_area_agri_lessa;
                        $applied_area_agri_ganda = $areaHis->applied_area_agri_ganda;
                        $applied_area_agri_kranti = $areaHis->applied_area_agri_kranti;


                        $settlement_area_home_bigha = $areaHis->settlement_area_home_bigha;
                        $settlement_area_home_katha = $areaHis->settlement_area_home_katha;
                        $settlement_area_home_lessa = $areaHis->settlement_area_home_lessa;
                        $settlement_area_home_ganda = $areaHis->settlement_area_home_ganda;
                        $settlement_area_home_kranti = $areaHis->settlement_area_home_kranti;

                        $settlement_area_agri_bigha = $areaHis->settlement_area_agri_bigha;
                        $settlement_area_agri_katha = $areaHis->settlement_area_agri_katha;
                        $settlement_area_agri_lessa = $areaHis->settlement_area_agri_lessa;
                        $settlement_area_agri_ganda = $areaHis->settlement_area_agri_ganda;
                        $settlement_area_agri_kranti = $areaHis->settlement_area_agri_kranti;


                        if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {

                            $total_applied_area_home_in_ganda = $this->utilityclass->Total_ganda($applied_area_home_bigha, $applied_area_home_katha, $applied_area_home_lessa, $applied_area_home_ganda);
                            $total_applied_area_agri_in_ganda = $this->utilityclass->Total_ganda($applied_area_agri_bigha, $applied_area_agri_katha, $applied_area_agri_lessa, $applied_area_agri_ganda);
                            $total_settlement_area_home_in_ganda = $this->utilityclass->Total_ganda($settlement_area_home_bigha, $settlement_area_home_katha, $settlement_area_home_lessa, $settlement_area_home_ganda);
                            $total_settlement_area_agri_in_ganda = $this->utilityclass->Total_ganda($settlement_area_agri_bigha, $settlement_area_agri_katha, $settlement_area_agri_lessa, $settlement_area_agri_ganda);

                            if(($total_applied_area_home_in_ganda != $total_settlement_area_home_in_ganda) || ($total_applied_area_agri_in_ganda != $total_settlement_area_agri_in_ganda)){

                                $data['area_modified'] = $areaModificationCheck;
                            }

                        }
                        else
                        {
                            $total_applied_area_home_in_lessa = $this->utilityclass->Total_Lessa($applied_area_home_bigha, $applied_area_home_katha, $applied_area_home_lessa);
                            $total_applied_area_agri_in_lessa = $this->utilityclass->Total_Lessa($applied_area_agri_bigha, $applied_area_agri_katha, $applied_area_agri_lessa);
                            $total_settlement_area_home_in_lessa = $this->utilityclass->Total_Lessa($settlement_area_home_bigha, $settlement_area_home_katha, $settlement_area_home_lessa);
                            $total_settlement_area_agri_in_lessa = $this->utilityclass->Total_Lessa($settlement_area_agri_bigha, $settlement_area_agri_katha, $settlement_area_agri_lessa);
                            //check if area modified
                            if(($total_applied_area_home_in_lessa != $total_settlement_area_home_in_lessa) || ($total_applied_area_agri_in_lessa != $total_settlement_area_agri_in_lessa)){

                                $data['area_modified'] = $areaModificationCheck;
                            }
                        }
                        //}
                    }
                }

                //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
                $deletedDags=$this->SettlementCommonModel->getDeletedDags($application_no);
                $deletedData = array();
                foreach($deletedDags as $deleteDag){
                    $deletedData[] = json_decode($deleteDag->table_data);
                }
                $data['deleted_dags'] = $deletedData;

                $rejected_data = $this->SettlementCommonModel->getRejectModal(TEA_SERVICE_CODE);
                if($rejected_data == 'n')
                {
                    $data['rejected_list'] = false;
                }
                else
                {
                    $data['rejected_list'] = $rejected_data;
                }

                //**************new */
                foreach(json_decode(VALIDATION_BYPASS_TEA_GRANT) as $val_bypas)
                {
                    if($val_bypas->SERVICE_CODE == TEA_SERVICE_CODE)
                    {
                        $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
                    }
                }


                $checkArea                   = 0;
                $totalLandArea               = 0;
                $totalDagAreaLessaValidation = 0;
                $totalAdditionalProToLessa   = 0;

                //******for Barak valley */
                if (in_array($dist_code, json_decode(BARAK_VALLEY)))
                {
                    foreach ($data['dags'] as $singleDag)
                    {
                        $dagAreaLessa = 0;
                        $dagAreaLessa = $this->utilityclass->Total_ganda(
                            $singleDag->s_dag_area_b,
                            $singleDag->s_dag_area_k,
                            $singleDag->s_dag_area_lc,
                            $singleDag->s_dag_area_g
                        );

                        $totalDagAreaLessaValidation += $dagAreaLessa;
                    }
                    foreach ($data['additional_property'] as $singleAdditionalDag)
                    {
                        $additionalAreaLessa = 0;
                        $additionalAreaLessa = $this->utilityclass->Total_ganda(
                            $singleAdditionalDag->bigha,
                            $singleAdditionalDag->katha,
                            $singleAdditionalDag->lessa,
                            $singleAdditionalDag->ganda

                        );
                        $totalAdditionalProToLessa += $additionalAreaLessa;
                    }

                    $totalLandArea = $totalDagAreaLessaValidation + $totalAdditionalProToLessa;
                    if((MAX_APPLIED_ADDITIONAL_AREA) * 6400 < $totalLandArea)
                    {
                        $checkArea = 1;
                    }
                }
                else
                {
                    foreach ($data['dags'] as $singleDag)
                    {
                        $dagAreaLessa = 0;
                        $dagAreaLessa = $this->utilityclass->Total_Lessa(
                            $singleDag->s_dag_area_b,
                            $singleDag->s_dag_area_k,
                            $singleDag->s_dag_area_lc
                        );
                        $totalDagAreaLessaValidation += $dagAreaLessa;
                    }
                    foreach ($data['additional_property'] as $singleAdditionalDag)
                    {
                        $additionalAreaLessa = 0;
                        $additionalAreaLessa = $this->utilityclass->Total_Lessa(
                            $singleAdditionalDag->bigha,
                            $singleAdditionalDag->katha,
                            $singleAdditionalDag->lessa
                        );
                        $totalAdditionalProToLessa += $additionalAreaLessa;
                    }

                    $totalLandArea = $totalDagAreaLessaValidation + $totalAdditionalProToLessa;
                    if((MAX_APPLIED_ADDITIONAL_AREA) * 100 < $totalLandArea)
                    {
                        $checkArea = 1;
                    }
                }

                $data['validation_bypass'] = 0;

                foreach($data['lmnotes'] as $lm_rr)
                {
                    $decoded_r = json_decode($lm_rr->lm_rejected_remarks);

                    if($decoded_r){
                        foreach($decoded_r as  $lm_rejected_code)
                        {
                            if(isset($lm_rejected_code->reject_code))
                            {
                                if(in_array($lm_rejected_code->reject_code, $const_bypass_arr_code)){
                                    $data['validation_bypass'] = 1;
                                }
                            }
                            else
                            {
                                if(in_array($lm_rejected_code, $const_bypass_arr_code)){
                                    $data['validation_bypass'] = 1;
                                }
                            }
                        }
                    }
                }

                $data['reject_list_type'] = '';

                foreach($lmnotes as $r_remark)
                {
                    $rejected_list_json = json_decode($r_remark->lm_rejected_remarks);
                    if($rejected_list_json)
                    {
                        foreach ($rejected_list_json as $re_list)
                        {
                            if(isset($re_list->reject_code))
                            {
                                $r_code = $re_list->reject_code;
                            }
                            else
                            {
                                $r_code = $re_list;
                            }

                            $sql = $this->db->query("select remark_head from reject_master where reject_code = ?", array($r_code));

                            if($sql->row()->remark_head != null)
                            {
                                $data['reject_list_type'] = 'new';
                            }
                            else
                            {
                                $data['reject_list_type'] = 'old';
                            }
                        }
                    }
                }

                $data['checkAppliedArea'] = $checkArea;
                $data['_view'] = 'TeaGrant/ADC/TeaGrantFirstProceedingAdcViewforAllcase';
                $this->load->view('layouts/main', $data);
            }
        }

        if($service_code == SLIJE_ID)
        {
            $geo_date_query = $this->db->query("Select date_entry from supportive_document where applid='$application_no'")->row();
            $geo_date = isset($geo_date_query->date_entry)? $geo_date_query->date_entry : '.....';

            // $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE applid = ? AND file_name = ? ", array($application_no, GEO_TAG_PHOTO) );
            $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE id in (select max(id) from supportive_document where applid=? and dag_no is not null and file_name=? group by applid, dag_no)", array($application_no, GEO_TAG_PHOTO));

            if($supportive_document_sql->num_rows() > 0){
                $lmdata['geo_tag_doc'] = $supportive_document_sql->result();
            }else{
                $lmdata['geo_tag_doc_empty'] = "<span class='text-danger alert-danger'><b>Geo tag photo yet to be uploaded.</b></span>";
            }


            if(!$recordExist)
            {

                /// additional property for LM note
                // $additional_property = $this->db->query("Select * from settlement_additional_property where applid='$application_no'");
                // if($additional_property->num_rows() > 0){
                //     $totallesaa=0;
                //     $totalganda=0;
                //     foreach($additional_property->result() as $addprop){
                //         if(in_array($addprop->dist_code, json_decode(BARAK_VALLEY))){
                //             $total_g=$this->utilityclass->Total_ganda($addprop->bigha,$addprop->katha,$addprop->lessa,$addprop->ganda);
                //             $totalganda = $totalganda+$total_g;
                //         }else{
                //             $total_l=$this->utilityclass->Total_Lessa($addprop->bigha,$addprop->katha,$addprop->lessa);
                //             $totallesaa = $totallesaa+$total_l;
                //         }

                //     }
                //     if(!empty($totallesaa)){
                //         $district['total_aditional_area']= $this->utilityclass->Total_Bigha_Katha_Lessa($totallesaa);
                //     }
                //     if(!empty($totalganda)){
                //         $district['total_aditional_area_g']= $this->utilityclass->Total_Bigha_Katha_Lessa2($totalganda);
                //     }
                //     $district['additional_property']=$additional_property->result();
                //     //var_dump($district['additional_property']); die;
                // }



                $token = $this->utilityclass->createTokenJwt();
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."getAppDetails");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    'application_no' => $application_no,
                    'api_key' => API_KEY,
                    'token' => $token
                )));

                $output = curl_exec($curl_handle);
                if(isset(json_decode($output)->responseType)){
                    if(json_decode($output)->responseType == 3){
                        echo json_decode($output)->data." - Unauthorized access!";
                        return false;
                    }
                }
                curl_close($curl_handle);
                $backup = $output;

                $output = json_decode($output);
                if(empty($output) || $output == null || $output == NULL)
                {
                    $data=array(
                        'error'=>"Something went wrong...Connection failed!!!"
                    );
                    echo json_encode($data);
                    die();
                }

                //****************generate case number********************
                $case_name=$this->SettlementApiModel->genearteCaseName();
                if(empty($case_name))
                {
                    $data=array(
                        'error'=>"Network Issue or Session Out. Please try Again"
                    );
                    echo json_encode($data);
                    die();
                }
                //*******generating petition_no and case_no */
                $case_no['petition_no']=$petition_no=$this->SettlementApiModel->genearteSettlementPetitionNo();
                $case_no['case_no']=$case_name.$petition_no."/".SLIJE_ANNOTATION;

                $district['geo_date']=$geo_date;
                $district['app']=$output->application;
                $district['pattaNo']=$this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$district['app']->dag_no);

                $district['applicants']=$output->applicants;

                $district['document']=$output->documents;
                $district['query']=$output->query;
                $district['property']=$output->property;
                $district['settlements']=$output->settlements;
                $district['encroachers'] = $output->encroachers;
                $district['owners'] = $output->owners;
                $district['riotee_noks'] = $output->riotee_noks;
                $district['aadhar']=$output->aadhar;

                $district['nextKin'] = $output->nextKin;
                // get khatian number
                $d=$district['app']->dist_code;
                $s=$district['app']->subdiv_code;
                $c=$district['app']->cir_code;
                $m=$district['app']->mouza_code;
                $l=$district['app']->lot_no;
                $v=$district['app']->village_code;
                // $pno=$district['pattaNo']->patta_no;
                // $pc=$district['pattaNo']->patta_type_code;
                $dag = $district['app']->dag_no;

                $district['co_name']= $this->SettlementCommonModel->getCoName($d, $s, $c);
                $district['s_area'] = $this->SettlementCommonModel->getPremiumArea();

                $district['bhumi'] = $output->bhumi;

                // for guardian relation
                $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";

                $relation_executation = $this->db->query($query_for_guar_rel);
                $row = $relation_executation->num_rows();

                if ($row != 0) {
                    $district['guar_rel'] = $relation_executation->result();
                }


                // if($this->utilityclass->checkUserAuthForCaseForLm($d,$s,$c,$m,$l) == false){
                //     $this->session->set_flashdata('message', "Unauthorized access for case no # ".$application_no);
                //     redirect(base_url() . "index.php/home");
                // }


                // fetch riotee noks -js- 05-09-2022
                if($output->riotee_noks == true){
                    $district['riotee_nok'] = $output->riotee_noks;
                }
                // $district['selfDeclarationDetails'] = $output->selfDeclaration;
                foreach($output->selfDeclaration as $selfDec){
                    $district['selfDeclarationDetails']=json_decode($selfDec->dec_details);
                }

                $vlb_encc=[];
                if($output->encroachers == true){
                    $district['riotee'] = $output->encroachers;
                    foreach($output->encroachers as $encroacher){
                        $vlb_encroacher = $this->SettlementApModel->getEncroacherDetails($d, $s, $c, $m, $l, $v, $encroacher->dag_no);

                        $district['vlb_enc'] = $vlb_encroacher;

                        if($vlb_encroacher == true){
                            // getting the encroacher details
                            $vlb_encroacher_in_dag = $this->SettlementApModel->getEncroacherInDag($vlb_encroacher->id);
                            $vlb_encc[] = $vlb_encroacher_in_dag;
                        }else{
                            $district['empty_err'] = "No Land Bank Details found!!";
                        }
                    }
                    $district['vlb_enc_details']=$vlb_encc;
                }

                // aadhaar photo api
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."getApplicantPhoto");

                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    'application_no'             => $application_no,

                )));
                $get_aadhaar_photo = curl_exec($curl_handle);
                curl_close($curl_handle);
                if($get_aadhaar_photo != 'n'){
                    $district['aadhaar_b64_decoded'] = "<img src = data:".$this->decodeBase64($get_aadhaar_photo).";base64,".$get_aadhaar_photo." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
                }

                $this->db->trans_begin();

                // insertion in backup table (lm)
                $backup_array = [
                    'applid' => $application_no,
                    'case_no' => $case_no['case_no'],
                    // 'from_office' => '',
                    // 'to_office' => '',
                    'status' => 'I',
                    // 'phase' => '',
                    'data' => $backup
                ];

                $backup_insertion = $this->db->insert('settlement_backup_json', $backup_array);

                if($backup_insertion != 1){
                    $this->db->trans_rollback();
                    log_message('error', '#BACKUP001: Insertion failed in settlement_backup_json RTPS Case No '.$application_no);

                    $this->session->set_flashdata('message', "#BACKUP001: Registration of Settlement failed for case no : ".$application_no);
                    redirect(base_url() . "index.php/home");
                    return false;
                }

                ///////// additional property starts here
                // $checkAdditionalProperty = $this->db->query("SELECT * FROM settlement_additional_property
                // WHERE applid=?", array($application_no));

                // if($checkAdditionalProperty->num_rows() == 0){
                //     if(isset($output->property)) {
                //         foreach($output->property as $value) {
                //             $add_property = array(
                //                 'case_no'             => $case_no['case_no'],
                //                 'dist_code'           => $value->dist_code,
                //                 'subdiv_code'         => $value->subdiv_code,
                //                 'cir_code'            => $value->cir_code,
                //                 'mouza_pargona_code'  => $value->mouza_pargona_code,
                //                 'lot_no'              => $value->lot_no,
                //                 'vill_townprt_code'   => $value->vill_townprt_code,
                //                 'bigha'               => $value->bigha,
                //                 'katha'               => $value->katha,
                //                 'lessa'               => $value->lessa,
                //                 'chatak'              => $value->lessa,
                //                 'ganda'               => $value->ganda,
                //                 'kranti'              => $value->kranti,
                //                 'entry_date'          => date('Y-m-d h:i:s'),
                //                 'is_rural'            => $value->is_rural,
                //                 'dag_no'              => $value->dag_no,
                //                 'patta_no'            => $value->patta_no,
                //                 'service_id'          => SLIJE_ID,
                //                 'applied_flag'        => CITIZEN,
                //                 'dist_name'           => trim($value->dist_name),
                //                 'cir_name'            => trim($value->cir_name),
                //                 'vill_name'           => trim($value->vill_name),
                //                 'applid'              => $application_no,
                //             );
                //             $insAddProperty = $this->db->insert('settlement_additional_property', $add_property);

                //             if ($insAddProperty != 1) {
                //                 $this->db->trans_rollback();
                //                 log_message('error', '#ERROR393: Insertion failed in settlement_additional_property RTPS Case No '.$application_no);
                //                 $data = array(
                //                     'error'=>"#ERROR393: Registration of Settlement failed for case no : ".$application_no
                //                 );
                //                 echo json_encode($data);
                //                 return false;
                //             }
                //         }
                //     }
                // }
                ///////// additional property ends here


                $pro_class = $this->input->post('protected_class');
                $protected_class_vr = ($pro_class==null || $pro_class=='' || $pro_class==0) ? 0 : $this->input->post('protected_class');

                //****bhumiputra condition prepare for insertation */
                if(!empty($output->bhumi['0']))
                {
                    if($output->bhumi['0']->bhumi_cert_available == 1){ //if bhumiputra available
                        $bhumiputra_confirmation     = 'YES';
                        $bhumiputra_certificate_no   = $output->bhumi['0']->bhumi_ack_no;
                        $bhumiputra_certificate_type = 'CERT';
                    }
                    else if($output->bhumi['0']->is_bhumi_applied == 1){ //if applied in bhumiputra
                        $bhumiputra_confirmation     = 'YES';
                        $bhumiputra_certificate_no   = $output->bhumi['0']->bhumi_ack_no;
                        $bhumiputra_certificate_type = 'ACK';
                    }
                    else {
                        $bhumiputra_confirmation     = '0';
                        $bhumiputra_certificate_no   = '0';
                        $bhumiputra_certificate_type = '0';
                    }
                }
                else {
                    $bhumiputra_confirmation     = '0';
                    $bhumiputra_certificate_no   = '0';
                    $bhumiputra_certificate_type = '0';
                }


                //********settlement_basic insertation */

                $basic=array(
                    'dist_code'=>$district['app']->dist_code,
                    'subdiv_code'=>$district['app']->subdiv_code,
                    'cir_code'=>$district['app']->cir_code,
                    'mouza_pargona_code'=>$district['app']->mouza_code,
                    'lot_no'=>$district['app']->lot_no,
                    'vill_townprt_code'=>$district['app']->village_code,
                    'service_code'=>$district['app']->service_code,
                    'ref_no'=>$district['app']->ref_no,
                    'case_no'=>$case_no['case_no'],
                    'trans_code'=>'F',/////////full
                    'petition_no'=>$case_no['petition_no'],
                    'year_no'=>date('Y'),
                    'date_entry' => date('Y-m-d G:i:s'),
                    'status'=>'ZC',
                    'user_code'=>$this->session->userdata('user_code'),
                    // 'lm_code' => $this->session->userdata('user_code'),
                    'submission_date' => date('Y-m-d G:i:s'),
                    'from_office' => 'API',
                    'pending_officer' => 'CO',
                    'pending_office' => 'CO',
                    'occupation_applicant'=>$district['applicants'][0]->applicant_occupation,
                    'applid'=>$district['app']->application_no,
                    'caste'=>$district['applicants'][0]->caste_category,
                    'uuid'=> $district['app']->uuid,
                    'protected_class' => $protected_class_vr,
                    'bhumiputra_confirmation'       => $bhumiputra_confirmation,
                    'bhumiputra_certificate_no'     => $bhumiputra_certificate_no,
                    'bhumiputra_certificate_type'   => $bhumiputra_certificate_type,
                    // 'co_code' => $this->input->post('co_code')
                );

                $insSetBasic = $this->db->insert('settlement_basic', $basic);
                // echo $this->db->last_query(); die();

                if ($insSetBasic != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET00011: Insertion failed in settlement_basic RTPS Case No '.$application_no);

                    $data = array(
                        'error'=>"#ERRSET00011: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }

                // AS DAG IS NOT FOUND
                // //settlement_dag_details insert start
                // if ($district['encroachers'] == false || empty($district['encroachers']) || $district['encroachers'] == '') {
                //     $this->db->trans_rollback();
                //     log_message('error', '#ERRSET004545: Insertion failed settlement_dag details empty RTPS Case No '.$application_no);

                //     $data = array(
                //         'error'=>"#ERRSET004545: Registration of Settlement failed for case no : ".$application_no
                //     );
                //     echo json_encode($data);
                //     return false;
                // }
                foreach ($district['encroachers'] as $dags)
                {
                    $district['class']=$this->utilityclass->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code, $dags->dag_no);

                    $enc_home_bigha = $dags->mbigha;
                    $enc_home_katha = $dags->mkatha;
                    $enc_home_lessa = $dags->mlessa;
                    $enc_home_ganda = $dags->mganda;
                    $enc_home_kranti = $dags->mkranti;

                    $enc_agri_bigha = $dags->agri_bigha;
                    $enc_agri_katha = $dags->agri_katha;
                    $enc_agri_lessa = $dags->agri_lessa;
                    $enc_agri_ganda = $dags->agri_ganda;
                    $enc_agri_kranti = $dags->agri_kranti;

                    $encroachment_area = [
                        'homestead' => [
                            'bigha' => $enc_home_bigha,
                            'katha' => $enc_home_katha,
                            'lessa' => $enc_home_lessa,
                            'ganda' => $enc_home_ganda,
                            'kranti' => $enc_home_kranti,
                        ],

                        'agriculture' => [
                            'bigha' => $enc_agri_bigha,
                            'katha' => $enc_agri_katha,
                            'lessa' => $enc_agri_lessa,
                            'ganda' => $enc_agri_ganda,
                            'kranti' => $enc_agri_kranti,
                        ],
                    ];


                    $fmd=array(
                        'dist_code'=>$district['app']->dist_code,
                        'subdiv_code'=>$district['app']->subdiv_code,
                        'cir_code'=>$district['app']->cir_code,
                        'mouza_pargona_code'=>$district['app']->mouza_code,
                        'lot_no'=>$district['app']->lot_no,
                        'vill_townprt_code'=>$district['app']->village_code,
                        'user_code'=>$this->session->userdata('user_code'),
                        'date_entry'=>date('Y-m-d'),
                        'case_no'=>$case_no['case_no'],
                        'petition_no'=>$case_no['petition_no'],
                        'year_no'=>date('Y'),
                        'new_land_class_code' => $district['class']->land_class_code,
                        'dag_no' => $dags->dag_no,
                        'patta_no' => $dags->patta_no,
                        'patta_type_code' => $dags->patta_code,
                        'is_urban' => $district['app']->is_urban,
                        'land_type' => $dags->land_type,
                        'revenue' => 0,
                        'operation' => 'E',
                        // 'landmark' => json_encode($landmark),
                        'encroachement_area' => json_encode($encroachment_area)
                    );

                    $fmd['dag_area_b']=$dags->applied_bigha;
                    $fmd['dag_area_k']=$dags->applied_katha;
                    $fmd['dag_area_lc']=$dags->applied_lessa;
                    $fmd['dag_area_g']=$dags->applied_ganda;
                    $fmd['dag_area_kr']=$dags->applied_kranti;

                    $fmd['home_b']=$dags->mbigha;
                    $fmd['home_k']=$dags->mkatha;
                    $fmd['home_lc']=$dags->mlessa;
                    $fmd['home_g']=$dags->mganda;
                    $fmd['home_kr']=$dags->mkranti;

                    $fmd['agri_b']=$dags->agri_bigha;
                    $fmd['agri_k']=$dags->agri_katha;
                    $fmd['agri_lc']=$dags->agri_lessa;
                    $fmd['agri_g']=$dags->agri_ganda;
                    $fmd['agri_kr']=$dags->agri_kranti;


                    //************Total Area Calculation -js- ******************
                    if (in_array($district['app']->dist_code, json_decode(BARAK_VALLEY))){
                        //******for Barak valley */
                        $areaHomeLessa = $this->utilityclass->Total_ganda($fmd['home_b'],$fmd['home_k'],$fmd['home_lc'],$fmd['home_g'],$fmd['home_kr']);
                        $areaAgriLessa = $this->utilityclass->Total_ganda($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc'],$fmd['agri_g'],$fmd['agri_kr']);

                        $totalAreaGanda = (float)$areaHomeLessa + (float)$areaAgriLessa;

                        $totalAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalAreaGanda);
                    }
                    else
                    {
                        $areaHomeLessa = $this->utilityclass->Total_Lessa($fmd['home_b'],$fmd['home_k'],$fmd['home_lc']);
                        $areaAgriLessa = $this->utilityclass->Total_Lessa($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc']);

                        $totalAreaLessa = (float)$areaHomeLessa + (float)$areaAgriLessa;

                        $totalAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($totalAreaLessa);
                    }

                    $fmd['s_dag_area_b'] = $totalAreaArr[0];
                    $fmd['s_dag_area_k'] = $totalAreaArr[1];
                    $fmd['s_dag_area_lc'] = $totalAreaArr[2];
                    $fmd['s_dag_area_g'] = $totalAreaArr[3];
                    $fmd['s_dag_area_kr'] = 0;

                    $rezaHome = $fmd['home_b'] + $fmd['home_k'] + $fmd['home_lc'] + $fmd['home_g'] + $fmd['home_kr'];
                    $rezaAgri = $fmd['agri_b'] + $fmd['agri_k'] + $fmd['agri_lc'] + $fmd['agri_g'] + $fmd['agri_kr'];

                    $landTypeUpdate = 0;
                    if($rezaHome > 0 && $rezaAgri > 0)
                    {
                        $landTypeUpdate = 3;
                    }
                    else if($rezaHome > 0  )
                    {
                        $landTypeUpdate = 1;
                    }
                    else if($rezaAgri > 0)
                    {
                        $landTypeUpdate = 2;
                    }


                    $insSetDag = $this->db->insert('settlement_dag_details', $fmd);
                    log_message('error',$this->db->last_query());
                    if ($insSetDag != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET0002: Insertion failed in settlement_dag_details RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#ERRSET0002: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }

                    //*******insertion in settlement_area_history**************
                    if (in_array($district['app']->dist_code, json_decode(BARAK_VALLEY)))
                    {
                        //***********actual Encroachment area ***************
                        $actual_encroachment_area_home_ganda = $this->utilityclass->Total_ganda($enc_home_bigha,$enc_home_katha,$enc_home_lessa,$enc_home_ganda);
                        $actual_encroachment_area_agri_ganda = $this->utilityclass->Total_ganda($enc_agri_bigha,$enc_agri_katha,$enc_agri_lessa,$enc_agri_ganda);

                        //***********total Actual Encroachment area*****************
                        $total_actual_encroachment_area_ganda = (float)$actual_encroachment_area_home_ganda + (float)$actual_encroachment_area_agri_ganda;
                        $totalEncroachmentAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_actual_encroachment_area_ganda);
                        // **********************************************


                        //***********Settlement area that applicant will get settlement on***********
                        $total_settlement_ganda_home = $this->utilityclass->Total_ganda($fmd['home_b'],$fmd['home_k'],$fmd['home_lc'],$fmd['home_g']);
                        $total_settlement_ganda_agri = $this->utilityclass->Total_ganda($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc'],$fmd['agri_g']);

                        //*****total Settlement area *************/
                        $total_settlement_ganda = (float)$total_settlement_ganda_home + (float)$total_settlement_ganda_agri;
                        $totalSettlementAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_settlement_ganda);

                        //*************leftout area homestead**************
                        $leftOutAreaHomeGanda = (float)$actual_encroachment_area_home_ganda - (float)$total_settlement_ganda_home;
                        $leftOutAreaHomeArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($leftOutAreaHomeGanda);

                        //**********Ileftout area agriculture**************
                        $leftOutAreaAgriGanda = (float)$actual_encroachment_area_agri_ganda - (float)$total_settlement_ganda_agri;
                        $leftOutAreaAgriArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($leftOutAreaAgriGanda);

                        //**********Total left out area***************
                        $totalLeftOutAreaGanda = (float)$total_actual_encroachment_area_ganda - (float)$total_settlement_ganda;
                        $totalLeftOutAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalLeftOutAreaGanda);

                    }
                    else
                    {
                        //********actual Encroachment area**********
                        $actual_encroachment_area_home_lessa = $this->utilityclass->Total_Lessa($enc_home_bigha,$enc_home_katha,$enc_home_lessa);
                        $actual_encroachment_area_agri_lessa = $this->utilityclass->Total_Lessa($enc_agri_bigha,$enc_agri_katha,$enc_agri_lessa);

                        //***********total Actual Encroachment area*****************
                        $total_actual_encroachment_area_lessa = (float)$actual_encroachment_area_home_lessa + (float)$actual_encroachment_area_agri_lessa;
                        $totalEncroachmentAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_actual_encroachment_area_lessa);
                        // **********************************************

                        //*******Settlement area that applicant will get settlement on**********
                        $total_settlement_lessa_home = $this->utilityclass->Total_Lessa($fmd['home_b'],$fmd['home_k'],$fmd['home_lc']);
                        $total_settlement_lessa_agri = $this->utilityclass->Total_Lessa($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc']);

                        //*************Total settlement area */
                        $total_settlement_lessa = (float)$total_settlement_lessa_home + (float)$total_settlement_lessa_agri;
                        $totalSettlementAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_settlement_lessa);

                        //****************leftout area homestead**************
                        $leftOutAreaHomeLessa = (float)$actual_encroachment_area_home_lessa - (float)$total_settlement_lessa_home;
                        $leftOutAreaHomeArr = $this->utilityclass->Total_Bigha_Katha_Lessa($leftOutAreaHomeLessa);

                        //*************leftout area agriculture*****************
                        $leftOutAreaAgriLessa = (float)$actual_encroachment_area_agri_lessa - (float)$total_settlement_lessa_agri;
                        $leftOutAreaAgriArr = $this->utilityclass->Total_Bigha_Katha_Lessa($leftOutAreaAgriLessa);

                        //**********Total left out area***************
                        $totalLeftOutArealessa = (float)$total_actual_encroachment_area_lessa - (float)$total_settlement_lessa;
                        $totalLeftOutAreaArr = $this->utilityclass->Total_Bigha_Katha_Lessa($totalLeftOutArealessa);
                    }

                    $settlementAreaHistoryArr = [
                        'application_no' => $application_no,
                        'case_no' => $case_no['case_no'],
                        'dag_no' => $dags->dag_no,
                        'uuid' => $district['app']->uuid,
                        'created_at' => date('Y-m-d'),
                        'applied_area_home_bigha' => $dags->mbigha,
                        'applied_area_home_katha' => $dags->mkatha,
                        'applied_area_home_lessa' => $dags->mlessa,
                        'applied_area_home_ganda' => $dags->mganda,
                        'applied_area_home_kranti' => $dags->mkranti,
                        'applied_area_agri_bigha' => $dags->agri_bigha,
                        'applied_area_agri_katha' => $dags->agri_katha,
                        'applied_area_agri_lessa' => $dags->agri_lessa,
                        'applied_area_agri_ganda' => $dags->agri_ganda,
                        'applied_area_agri_kranti' => $dags->agri_kranti,
                        'actual_encroachment_area_home_bigha' => $enc_home_bigha,
                        'actual_encroachment_area_home_katha' => $enc_home_katha,
                        'actual_encroachment_area_home_lessa' => $enc_home_lessa,
                        'actual_encroachment_area_home_ganda' => $enc_home_ganda,
                        'actual_encroachment_area_home_kranti' => $enc_home_kranti,
                        'actual_encroachment_area_agri_bigha' => $enc_agri_bigha,
                        'actual_encroachment_area_agri_katha' => $enc_agri_katha,
                        'actual_encroachment_area_agri_lessa' => $enc_agri_lessa,
                        'actual_encroachment_area_agri_ganda' => $enc_agri_ganda,
                        'actual_encroachment_area_agri_kranti' => $enc_agri_kranti,
                        'total_actual_encroachment_area_bigha' => $totalEncroachmentAreaArr[0],
                        'total_actual_encroachment_area_katha' => $totalEncroachmentAreaArr[1],
                        'total_actual_encroachment_area_lessa' => $totalEncroachmentAreaArr[2],
                        'total_actual_encroachment_area_ganda' => $totalEncroachmentAreaArr[3],
                        'total_actual_encroachment_area_kranti' => 0,
                        'settlement_area_home_bigha' => $fmd['home_b'],
                        'settlement_area_home_katha' => $fmd['home_k'],
                        'settlement_area_home_lessa' => $fmd['home_lc'],
                        'settlement_area_home_ganda' => $fmd['home_g'],
                        'settlement_area_home_kranti' => $fmd['home_kr'],
                        'settlement_area_agri_bigha' => $fmd['agri_b'],
                        'settlement_area_agri_katha' => $fmd['agri_k'],
                        'settlement_area_agri_lessa' => $fmd['agri_lc'],
                        'settlement_area_agri_ganda' => $fmd['agri_g'],
                        'settlement_area_agri_kranti' => $fmd['agri_kr'],
                        'total_settlement_area_bigha' => $totalSettlementAreaArr[0],
                        'total_settlement_area_katha' => $totalSettlementAreaArr[1],
                        'total_settlement_area_lessa' => $totalSettlementAreaArr[2],
                        'total_settlement_area_ganda' => $totalSettlementAreaArr[3],
                        'total_settlement_area_kranti' => 0,
                        'leftout_area_home_bigha' => $leftOutAreaHomeArr[0],
                        'leftout_area_home_katha' => $leftOutAreaHomeArr[1],
                        'leftout_area_home_lessa' => $leftOutAreaHomeArr[2],
                        'leftout_area_home_ganda' => $leftOutAreaHomeArr[3],
                        'leftout_area_home_kranti' => 0,
                        'leftout_area_agri_bigha' => $leftOutAreaAgriArr[0],
                        'leftout_area_agri_katha' => $leftOutAreaAgriArr[1],
                        'leftout_area_agri_lessa' => $leftOutAreaAgriArr[2],
                        'leftout_area_agri_ganda' => $leftOutAreaAgriArr[3],
                        'leftout_area_agri_kranti' => 0,
                        'total_leftout_area_bigha' => $totalLeftOutAreaArr[0],
                        'total_leftout_area_katha' => $totalLeftOutAreaArr[1],
                        'total_leftout_area_lessa' => $totalLeftOutAreaArr[2],
                        'total_leftout_area_ganda' => $totalLeftOutAreaArr[3],
                        'total_leftout_area_kranti' => 0,
                    ];

                    $insertSetlArea = $this->db->insert('settlement_area_history', $settlementAreaHistoryArr);

                    if ($insertSetlArea != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#SETLARRHIS0001: Insertion failed in settlement_area_history RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#SETLARRHIS0001: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }

                    //**************end of settlement_area_history********************
                }


                //*******pdar_cron number generation */
                $sql = "SELECT pdar_cron_no FROM settlement_applicant WHERE case_no = '".$case_no['case_no']."'";
                $result = $this->db->query($sql);
                if($result->num_rows() > 0){
                    $cron_no = (int)$result->row()->pdar_cron_no + 1;
                }else{
                    $cron_no = 1;
                }

                //*********settlement_applicant insertion */
                // echo "<pre>";

                // //settlement_dag_details insert start
                if ($district['applicants'] == false || empty($district['applicants']) || $district['applicants'] == '') {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET004545APPLICANT: Insertion failed settlement_applicant details empty RTPS Case No '.$application_no);

                    $data = array(
                        'error'=>"#ERRSET004545APPLICANT: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }

                foreach ($district['applicants'] as $setl)
                {

                    if ($get_aadhaar_photo != 'n' && $setl->is_applicant == '1') {
                        $timestamp = date('mdYhis', time()).uniqid();
                        $identity_doc_unique_name = str_replace('/', "-", $application_no.'_'.$timestamp);
                        // creating and saving the base64 format payment notice to uploads/paymentNotice folder
                        $aadhar_path = AADHAAR_PHOTO . $identity_doc_unique_name . ".json";
                        $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file44!");
                        $aadhaar_encoded_file = $get_aadhaar_photo;
                        fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                        fclose($aadhaar_file_to_write_base64);

                    }else{
                        $aadhar_path = '';
                    }

                    if($district['aadhar']->type == 'AADHAAR'){
                        $identity_ref_no = $district['aadhar']->aadhaar_no;
                    }else{
                        $identity_ref_no = $district['aadhar']->pan_no;
                    }

                    $applicant=array(
                        'dist_code'=>$district['app']->dist_code,
                        'subdiv_code'=>$district['app']->subdiv_code,
                        'cir_code'=>$district['app']->cir_code,
                        'mouza_pargona_code'=>$district['app']->mouza_code,
                        'lot_no'=>$district['app']->lot_no,
                        'vill_townprt_code'=>$district['app']->village_code,
                        'user_code'=>$this->session->userdata('user_code'),
                        'case_no'=>$case_no['case_no'],
                        'petition_no'=>$case_no['petition_no'],
                        'operation'=>'E',
                        'dag_no' => 0,
                        'patta_no' => 0,
                        'patta_type_code' => 0,
                        'year_no'=>date('Y'),
                        'date_entry'=>date('Y-m-d'),
                        'pdar_id' => '-1',
                        'pdar_cron_no'=>(int) $cron_no++,
                        'pdar_name' =>$setl->name_ass,
                        'pdar_guardian' =>$setl->gurdian_name_ass == null ? 'NA' : $setl->gurdian_name_ass,
                        'eng_pdar_name' => $setl->name_eng,
                        'eng_pdar_guardian' => $setl->gurdian_name_eng,
                        'pdar_rel_guar' =>$setl->gurdian_relation_id == null ? '' : $setl->gurdian_relation_id,
                        'pdar_gender'=>$setl->gender,
                        'pdar_add1' => $setl->pre_add,
                        'pdar_add2' => $setl->per_add,
                        'pdar_mobile' => $setl->mobile,

                        'pdar_type' => $setl->pdar_type,
                        'is_applicant' => $setl->is_applicant,
                        'identity_ref_no' => $identity_ref_no,
                        'identity_type' => $district['aadhar']->type,
                        'identity_doc_link' => $aadhar_path,
                        'marital_status' => $setl->marital_status,
                        'dob' => $setl->dob,
                    );

                    $insSetApplicant = $this->db->insert('settlement_applicant', $applicant);
                    // echo $this->db->last_query(); die();

                    if ($insSetApplicant != 1) {
                        // var_dump($insSetApplicant);
                        // echo $this->db->last_query(); die();
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET0003: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#ERRSET0003: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }

                //*********encroachers insert in applicant table */
                if($output->encroachers == true){

                    foreach($output->encroachers as $enc_applicant){
                        $encroacher_app=array(
                            'dist_code' => $district['app']->dist_code,
                            'subdiv_code' => $district['app']->subdiv_code,
                            'cir_code' => $district['app']->cir_code,
                            'mouza_pargona_code' => $district['app']->mouza_code,
                            'lot_no' => $district['app']->lot_no,
                            'vill_townprt_code' => $district['app']->village_code,

                            'user_code'=>$this->session->userdata('user_code'),
                            'case_no'=>$case_no['case_no'],
                            'petition_no'=>$case_no['petition_no'],
                            'operation'=>'E',

                            'dag_no' => $enc_applicant->dag_no,
                            'patta_no' => $enc_applicant->patta_no,
                            'patta_type_code' => $enc_applicant->patta_code,
                            'period_possession' => $enc_applicant->possession_date,

                            'year_no'=>date('Y'),
                            'date_entry'=>date('Y-m-d'),

                            'pdar_name' => $enc_applicant->name_ass,
                            'pdar_guardian' => $enc_applicant->gurdian_name_ass,
                            'pdar_rel_guar' => '0',
                            'pdar_cron_no'=> (int) $cron_no++,
                            'pdar_id' => -1,
                            'pdar_type' => 'EN',
                            'enc_id' => $enc_applicant->encroacher_id,
                        );
                        $insSetEncroacher = $this->db->insert('settlement_applicant',$encroacher_app);
                        // echo $this->db->last_query();
                        // var_dump($insSetEncroacher); die;

                        if ($insSetEncroacher != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRSET000309: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                            $data = array(
                                'error'=>"#ERRSET000309: Registration of Settlement failed for case no : ".$application_no
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }
                }

                ///// nominee add start /////
                // if ($output->nextKin == true) {
                //     // foreach ($_POST['kin_name'] as $key =>$value) {
                //     foreach ($output->nextKin as $nex_of_kin) {
                //         $nominee_data=array(
                //             'case_no'=> $case_no['case_no'],
                //             'nominee_name' => $nex_of_kin->next_of_kin_name,
                //             'address' => $nex_of_kin->address,
                //             'mobile_no' => $nex_of_kin->mobile_no,
                //             'relation' => $nex_of_kin->relation_with_kin
                //         );
                //         $insNominee = $this->db->insert('settlement_nominee', $nominee_data);
                //         // echo $this->db->last_query();
                //         // var_dump($insSetEncroacher); die();

                //         if ($insNominee != 1) {
                //             $this->db->trans_rollback();
                //             log_message('error', '#ERRSET00032: Insertion failed in settlement_nominee RTPS Case No '.$application_no);
                //             $data = array(
                //                 'error'=>"#ERRSET00032: Registration of Settlement failed for case no : ".$application_no
                //             );
                //             echo json_encode($data);
                //             return false;
                //         }
                //     }
                // }
                ///// nominee end //////
                if(empty($output->project) || $output->project == null || $output->project == NULL || $output->project == false)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSETNODATA1187: Insertion failed in basundhar_application RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRSETNODATA1187: Registration of Institution failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
                foreach($output->project as $project_row){
                    $settl_ins_array = [
                        'case_no'                           => $case_no['case_no'],
                        'application_no'                    => $application_no,
                        'applicant_id'                      => $project_row->applicant_id,
                        'service_code'                      => $project_row->service_code,
                        'ins_name'                          => $project_row->ins_name,
                        'ins_cat_type'                      => $project_row->ins_cat_type,
                        'authorised_applicant_name'         => $project_row->authorised_applicant_name,
                        'authorised_applicant_desig'        => $project_row->authorised_applicant_desig,
                        'authorised_applicant_phone_no'     => $project_row->authorised_applicant_phone_no,
                        'authorised_applicant_emailid'      => $project_row->authorised_applicant_emailid,
                        'justification_land_area'           => $project_row->justification_land_area,
                        'outcomes_of_project'               => $project_row->outcomes_of_project,
                        'when_why'                          => $project_row->when_why,
                        'type_of_entity'                    => $project_row->type_of_entity,
                        'purpose_land_allot'                => $project_row->purpose_land_allot,
                        'time_frame'                        => $project_row->time_frame,
                        'source_funding'                    => $project_row->source_funding,
                        'activity_three_years'              => $project_row->activity_three_years,
                        'profit_making'                     => $project_row->profit_making,
                        'scarcer_land'                      => $project_row->scarcer_land,
                        'board_of_members'                  => $project_row->board_of_members,
                        'created_at'                        => $project_row->created_at,
                        'updated_at'                        => $project_row->updated_at,
                        'justification_land_area_required'  => $project_row->justification_land_area_required,
                        'is_central_state'                  => $project_row->is_central_state,
                        'dept_of'                           => $project_row->dept_of,
                        'director_of'                       => $project_row->director_of,
                        'undertaking_board'                 => $project_row->undertaking_board,
                        'undertaking_board_address'         => $project_row->undertaking_board_address,
                        'is_under_state'                    => $project_row->is_under_state,
                        'is_under_central_undertaking'      => $project_row->is_under_central_undertaking,
                        'ekyc_name'                         => $project_row->ekyc_name,
                        'pan_ref_no'                        => $project_row->pan_ref_no,
                        'auth_type'                         => $project_row->auth_type,
                        'pre_add'                           => $project_row->pre_add,
                        'pre_dist_code'                     => $project_row->pre_dist_code,
                        'pre_city'                          => $project_row->pre_city,
                        'pre_pin'                           => $project_row->pre_pin,
                        'other_purpose_land_allot'          => $project_row->other_purpose_land_allot,
                        'ministry_of'                       => $project_row->ministry_of,
                        'type_of_entity_description'        => $project_row->type_of_entity_description,
                        'purpose_description'               => $project_row->purpose_description,
                        'govt_funded'                       => $project_row->govt_funded,
                    ];

                    $insert_ins = $this->db->insert('settlement_institution_details', $settl_ins_array);

                    if($insert_ins != 1){
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET3330003202: Insertion failed in basundhar_application RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#ERRSET3330003202: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }

                //********basundhar_application insertation */
                $basundhara=array(
                    'dharitree'=>$case_no['case_no'],
                    'basundhara'=>$application_no,
                    'date_reg'=>date('Y-m-d'),
                    'reg_by'=>$this->session->userdata('user_code'),
                    'app_status'=>'M',
                    'pending_with'=>'CO'
                );
                $basundhar_app = $this->db->insert('basundhar_application',$basundhara);

                if ($basundhar_app != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET0003202: Insertion failed in basundhar_application RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRSET0003202: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }else{
                    //******commit if no errors */
                    $this->db->trans_commit();
                }

            }

            $sql = "Select case_no from settlement_basic where applid='$application_no' ";
            $case = $this->db->query($sql)->row();
            $application_no = $case_no = $case->case_no;

            $proceedings = $this->SettlementCommonDcModel->getSettlementProceeding($case_no);
            $basic = $this->SettlementKhasModel->getSettlementBasic($application_no);
            $applicants_buyers = $this->SettlementKhasModel->getAllApplicantBuyers($application_no);
            $applicants_owners = $this->SettlementKhasModel->getAllApplicantOwners($application_no);
            $applicants_encroacher = $this->SettlementKhasModel->getAllApplicantEncroacher($application_no);
            $applicants_riotee_nok = $this->SettlementKhasModel->getAllApplicantRioteeNok($application_no);

            $dags = $this->SettlementKhasModel->getSettlementDag($application_no);
            $lmnotes = $this->SettlementKhasModel->getSettlementTenantLmNote($application_no);
            $dhardocuments = $this->SettlementKhasModel->getDocuments($application_no);

            $lmdata=[];
            foreach($applicants_encroacher as $encroacher)
            {
                // getting the encroacher details
                $query="select * from c_land_bank_encroacher_details where id=$encroacher->enc_id";
                $encdata=$this->db->query($query)->result();
                $lmdata[] = $encdata;

            }
            $data['encdata']=$lmdata;

            $data['basic']=$basic;

            $reservation = $this->SettlementMbModel->getSettlementReservation($application_no);
            $data['reservation']=$reservation;
            $data['applicants_buyers']=$applicants_buyers;
            $data['applicants_owners']=$applicants_owners;
            $data['applicants_encroacher']=$applicants_encroacher;
            $data['applicants_riotee_nok']=$applicants_riotee_nok;

            $data['dags']=$dags;
            $data['lmnotes']=$lmnotes;
            $data['dhardocuments']=$dhardocuments;

            // for guardian relation
            $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
            $relation_executation = $this->db->query($query_for_guar_rel);
            $row = $relation_executation->num_rows;
            if ($row != 0) {
                $data['guar_rel'] = $relation_executation->result();
            }
            $premium_data = $this->db->query("SELECT * from settlement_premium where case_no='$application_no' and is_final=1")->result();
            $data['premium_data'] = $premium_data;
            $data['premium'] = $this->db->query("SELECT *  from settlement_premium where case_no='$application_no' and is_final=1")->result();
            //$data['caseCount']   = $caseCount;
            //$data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;

            //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
            $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($case_no);
            $deletedEncArray = array();
            foreach($deletedEnc as $encroacherDeleted_data)
            {
                $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
            }
            $data['deleted_encroacher'] = $deletedEncArray;


            //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
            $deletedDags=$this->SettlementCommonModel->getDeletedDags($case_no);
            $deletedData = array();
            foreach($deletedDags as $deleteDag){
                $deletedData[] = json_decode($deleteDag->table_data);
            }
            $data['deleted_dags'] = $deletedData;
            $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_KHAS_LAND_ID);
            if($rejected_data == 'n')
            {
                $data['rejected_list'] = false;
            }
            else
            {
                $data['rejected_list'] = $rejected_data;
            }

            //**************new */
            foreach(json_decode(VALIDATION_BYPASS) as $val_bypas)
            {
                if($val_bypas->SERVICE_CODE == SLIJE_ID)
                {
                    $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
                }
            }
            $data['validation_bypass'] = 0;

            foreach($data['lmnotes'] as $lm_rr)
            {
                $decoded_r = json_decode($lm_rr->lm_rejected_remarks);

                if($decoded_r){
                    foreach($decoded_r as  $lm_rejected_code)
                    {
                        if(isset($lm_rejected_code->reject_code))
                        {
                            if(in_array($lm_rejected_code->reject_code, $const_bypass_arr_code)){
                                $data['validation_bypass'] = 1;
                            }
                        }
                        else
                        {
                            if(in_array($lm_rejected_code, $const_bypass_arr_code)){
                                $data['validation_bypass'] = 1;
                            }
                        }

                    }
                }

            }

            $data['reject_list_type'] = '';

            foreach($lmnotes as $r_remark)
            {
                $rejected_list_json = json_decode($r_remark->lm_rejected_remarks);

                if($rejected_list_json)
                {
                    foreach ($rejected_list_json as $re_list) {

                        if(isset($re_list->reject_code))
                        {
                            $r_code = $re_list->reject_code;
                        }
                        else
                        {
                            $r_code = $re_list;
                        }

                        $sql = $this->db->query("select remark_head from reject_master where reject_code = ?", array($r_code));

                        if($sql->row()->remark_head != null)
                        {
                            $data['reject_list_type'] = 'new';
                        }
                        else
                        {
                            $data['reject_list_type'] = 'old';
                        }
                    }
                }
            }

            $newDagCount = $this->db->query("SELECT old_dag, new_dag FROM chitha_settlement_allottee WHERE ord_no = ? 
                               GROUP BY old_dag, new_dag", array($application_no));

            if($newDagCount->num_rows()!= 0)
            {
                $data['newDagCount'] = 1;
                $data['newDags']     = $newDagCount->result();
            }
            else
            {
                $data['newDagCount'] = 0;
                $data['newDags']     = '';
            }
            $sql = $this->db->query('select sid.*,imc.category_name from settlement_institution_details sid join ins_master_category imc on sid.ins_cat_type::int = imc.id  where case_no = ?', array($application_no));

            $data['ins_data'] = $sql->result();
            $data['instituteDetails'] = $this->SettlementInsModel->getInstitutionDetails($application_no);


            $data['_view'] = 'settlementView/Dc/Common/application_details_common_ins_allcases';
            $this->load->view('layouts/main', $data);

        }

        if($service_code == NC_KHAS_LAND_ID)
        {

            $geo_date_query = $this->db->query("Select date_entry from supportive_document where applid='$application_no'")->row();
            $geo_date = isset($geo_date_query->date_entry)? $geo_date_query->date_entry : '.....';

            // $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE applid = ? AND file_name = ? ", array($application_no, GEO_TAG_PHOTO) );
            $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE id in (select max(id) from supportive_document where applid=? and dag_no is not null and file_name=? group by applid, dag_no)", array($application_no, GEO_TAG_PHOTO));

            if($supportive_document_sql->num_rows() > 0)
            {
                $lmdata['geo_tag_doc'] = $supportive_document_sql->result();
            }
            else
            {
                $lmdata['geo_tag_doc_empty'] = "<span class='text-danger alert-danger'><b>Geo tag photo yet to be uploaded.</b></span>";
            }

            if(!$recordExist)
            {
                /// additional property for LM note
                $additional_property = $this->db->query("Select * from settlement_additional_property where applid='$application_no'");
                if($additional_property->num_rows() > 0){
                    $totallesaa=0;
                    $totalganda=0;
                    foreach($additional_property->result() as $addprop){
                        if(in_array($addprop->dist_code, json_decode(BARAK_VALLEY))){
                            $total_g=$this->ncutility->Total_ganda($addprop->bigha,$addprop->katha,$addprop->lessa,$addprop->ganda);
                            $totalganda = $totalganda+$total_g;
                        }else{
                            $total_l=$this->ncutility->Total_Lessa($addprop->bigha,$addprop->katha,$addprop->lessa);
                            $totallesaa = $totallesaa+$total_l;
                        }

                    }
                    if(!empty($totallesaa)){
                        $district['total_aditional_area']= $this->ncutility->Total_Bigha_Katha_Lessa($totallesaa);
                    }
                    if(!empty($totalganda)){
                        $district['total_aditional_area_g']= $this->ncutility->Total_Bigha_Katha_Lessa2($totalganda);
                    }
                    $district['additional_property']=$additional_property->result();
                    //var_dump($district['additional_property']); die;
                }



                $token = $this->ncutility->createTokenJwt();
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, API_LINK_NC."getAppDetails");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    'application_no' => $application_no,
                    'api_key' => API_KEY,
                    'token' => $token
                )));

                $output = curl_exec($curl_handle);

                // var_dump($output);
                // die;
                if(isset(json_decode($output)->responseType)){
                    if(json_decode($output)->responseType == 3){
                        echo json_decode($output)->data." - Unauthorized access!";
                        return false;
                    }
                }
                curl_close($curl_handle);
                $backup = $output;

                $output = json_decode($output);

                //****************generate case number********************
                $case_name=$this->NcApiModel->genearteCaseName();
                if(empty($case_name))
                {
                    $data=array(
                        'error'=>"Network Issue or Session Out. Please try Again"
                    );
                    echo json_encode($data);
                    die();
                }
                //*******generating petition_no and case_no */
                $case_no['petition_no']=$petition_no=$this->NcApiModel->genearteSettlementPetitionNo();
                $case_no['case_no']=$case_name.$petition_no."/".NC_KHAS_LAND;

                $district['geo_date']=$geo_date;
                $district['app']=$output->application;
                $district['pattaNo']=$this->ncutility->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code,$district['app']->dag_no);

                $district['applicants']=$output->applicants;

                $district['document']=$output->documents;
                $district['query']=$output->query;
                $district['property']=$output->property;
                $district['settlements']=$output->settlements;
                $district['encroachers'] = $output->encroachers;
                $district['owners'] = $output->owners;
                $district['riotee_noks'] = $output->riotee_noks;
                $district['aadhar']=$output->aadhar;

                $district['nextKin'] = $output->nextKin;
                // get khatian number
                $d=$district['app']->dist_code;
                $s=$district['app']->subdiv_code;
                $c=$district['app']->cir_code;
                $m=$district['app']->mouza_code;
                $l=$district['app']->lot_no;
                $v=$district['app']->village_code;
                // $pno=$district['pattaNo']->patta_no;
                // $pc=$district['pattaNo']->patta_type_code;
                $dag = $district['app']->dag_no;

                $district['co_name']= $this->NcCommonModel->getCoName($d, $s, $c);
                $district['s_area'] = $this->NcCommonModel->getPremiumArea();

                $district['bhumi'] = $output->bhumi;

                // for guardian relation
                $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";

                $relation_executation = $this->db->query($query_for_guar_rel);
                $row = $relation_executation->num_rows();

                if ($row != 0) {
                    $district['guar_rel'] = $relation_executation->result();
                }


                // if($this->ncutility->checkUserAuthForCaseForLm($d,$s,$c,$m,$l) == false){
                //     $this->session->set_flashdata('message', "Unauthorized access for case no # ".$application_no);
                //     redirect(base_url() . "index.php/home");
                // }


                // fetch riotee noks -js- 05-09-2022
                if($output->riotee_noks == true){
                    $district['riotee_nok'] = $output->riotee_noks;
                }
                // $district['selfDeclarationDetails'] = $output->selfDeclaration;
                foreach($output->selfDeclaration as $selfDec){
                    $district['selfDeclarationDetails']=json_decode($selfDec->dec_details);
                }

                $vlb_encc=[];
                if($output->encroachers == true){
                    $district['riotee'] = $output->encroachers;
                    foreach($output->encroachers as $encroacher){
                        $vlb_encroacher = $this->NcServiceModel->getEncroacherDetails($d, $s, $c, $m, $l, $v, $encroacher->dag_no);

                        $district['vlb_enc'] = $vlb_encroacher;

                        if($vlb_encroacher == true){
                            // getting the encroacher details
                            $vlb_encroacher_in_dag = $this->NcServiceModel->getEncroacherInDag($vlb_encroacher->id);
                            $vlb_encc[] = $vlb_encroacher_in_dag;
                        }else{
                            $district['empty_err'] = "No Land Bank Details found!!";
                        }
                    }
                    $district['vlb_enc_details']=$vlb_encc;
                }

                // aadhaar photo api
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, API_LINK_NC."getApplicantPhoto");

                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                    'application_no'             => $application_no,

                )));
                $get_aadhaar_photo = curl_exec($curl_handle);
                curl_close($curl_handle);


                if($get_aadhaar_photo != 'n'){
                    $district['aadhaar_b64_decoded'] = "<img src = data:".$this->decodeBase64($get_aadhaar_photo).";base64,".$get_aadhaar_photo." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
                }

                $this->db->trans_begin();

                // insertion in backup table (lm)
                $backup_array = [
                    'applid' => $application_no,
                    'case_no' => $case_no['case_no'],
                    // 'from_office' => '',
                    // 'to_office' => '',
                    'status' => 'I',
                    // 'phase' => '',
                    'data' => $backup
                ];

                $backup_insertion = $this->db->insert('settlement_backup_json', $backup_array);

                if($backup_insertion != 1){
                    $this->db->trans_rollback();
                    log_message('error', '#BACKUP001: Insertion failed in settlement_backup_json RTPS Case No '.$application_no);

                    $this->session->set_flashdata('message', "#BACKUP001: Registration of Settlement failed for case no : ".$application_no);
                    redirect(base_url() . "index.php/home");
                    return false;
                }

                ///////// additional property starts here
                $checkAdditionalProperty = $this->db->query("SELECT * FROM settlement_additional_property
            WHERE applid=?", array($application_no));

                if($checkAdditionalProperty->num_rows() == 0){
                    if(isset($output->property)) {
                        foreach($output->property as $value) {
                            $add_property = array(
                                'case_no'             => $case_no['case_no'],
                                'dist_code'           => $value->dist_code,
                                'subdiv_code'         => $value->subdiv_code,
                                'cir_code'            => $value->cir_code,
                                'mouza_pargona_code'  => $value->mouza_pargona_code,
                                'lot_no'              => $value->lot_no,
                                'vill_townprt_code'   => $value->vill_townprt_code,
                                'bigha'               => $value->bigha,
                                'katha'               => $value->katha,
                                'lessa'               => $value->lessa,
                                'chatak'              => $value->lessa,
                                'ganda'               => $value->ganda,
                                'kranti'              => $value->kranti,
                                'entry_date'          => date('Y-m-d h:i:s'),
                                'is_rural'            => $value->is_rural,
                                'dag_no'              => $value->dag_no,
                                'patta_no'            => $value->patta_no,
                                'service_id'          => NC_KHAS_LAND_ID,
                                'applied_flag'        => CITIZEN,
                                'dist_name'           => trim($value->dist_name),
                                'cir_name'            => trim($value->cir_name),
                                'vill_name'           => trim($value->vill_name),
                                'applid'              => $application_no,
                            );
                            $insAddProperty = $this->db->insert('settlement_additional_property', $add_property);

                            if ($insAddProperty != 1) {
                                $this->db->trans_rollback();
                                log_message('error', '#ERROR393: Insertion failed in settlement_additional_property RTPS Case No '.$application_no);
                                $data = array(
                                    'error'=>"#ERROR393: Registration of Settlement failed for case no : ".$application_no
                                );
                                echo json_encode($data);
                                return false;
                            }
                        }
                    }
                }
                ///////// additional property ends here


                $pro_class = $this->input->post('protected_class');
                $protected_class_vr = ($pro_class==null || $pro_class=='' || $pro_class==0) ? 0 : $this->input->post('protected_class');

                //****bhumiputra condition prepare for insertation */
                if(!empty($output->bhumi['0'])) {
                    if($output->bhumi['0']->bhumi_cert_available == 1){ //if bhumiputra available
                        $bhumiputra_confirmation     = 'YES';
                        $bhumiputra_certificate_no   = $output->bhumi['0']->bhumi_ack_no;
                        $bhumiputra_certificate_type = 'CERT';
                    }
                    else if($output->bhumi['0']->is_bhumi_applied == 1){ //if applied in bhumiputra
                        $bhumiputra_confirmation     = 'YES';
                        $bhumiputra_certificate_no   = $output->bhumi['0']->bhumi_ack_no;
                        $bhumiputra_certificate_type = 'ACK';
                    }
                    else {
                        $bhumiputra_confirmation     = '0';
                        $bhumiputra_certificate_no   = '0';
                        $bhumiputra_certificate_type = '0';
                    }
                }
                else {
                    $bhumiputra_confirmation     = '0';
                    $bhumiputra_certificate_no   = '0';
                    $bhumiputra_certificate_type = '0';
                }


                //********settlement_basic insertation */

                $basic=array(
                    'dist_code'=>$district['app']->dist_code,
                    'subdiv_code'=>$district['app']->subdiv_code,
                    'cir_code'=>$district['app']->cir_code,
                    'mouza_pargona_code'=>$district['app']->mouza_code,
                    'lot_no'=>$district['app']->lot_no,
                    'vill_townprt_code'=>$district['app']->village_code,
                    'service_code'=>$district['app']->service_code,
                    'ref_no'=>$district['app']->ref_no,
                    'case_no'=>$case_no['case_no'],
                    'trans_code'=>'F',/////////full
                    'petition_no'=>$case_no['petition_no'],
                    'year_no'=>date('Y'),
                    'date_entry' => date('Y-m-d G:i:s'),
                    'status'=>'Z',
                    'user_code'=>$this->session->userdata('user_code'),
                    // 'lm_code' => $this->session->userdata('user_code'),
                    'submission_date' => date('Y-m-d G:i:s'),
                    'from_office' => 'API',
                    'pending_officer' => 'LM',
                    'pending_office' => 'CO',
                    'occupation_applicant'=>$district['applicants'][0]->applicant_occupation,
                    'applid'=>$district['app']->application_no,
                    'caste'=>$district['applicants'][0]->caste_category,
                    'uuid'=> $district['app']->uuid,
                    'protected_class' => $protected_class_vr,
                    'bhumiputra_confirmation'       => $bhumiputra_confirmation,
                    'bhumiputra_certificate_no'     => $bhumiputra_certificate_no,
                    'bhumiputra_certificate_type'   => $bhumiputra_certificate_type,
                    // 'co_code' => $this->input->post('co_code')
                    'is_tribal' => ($district['app']->service_applied_for == 'NC_KHAS') ? 0 : 1,
                );

                $insSetBasic = $this->db->insert('settlement_basic', $basic);
                // echo $this->db->last_query(); die();

                if ($insSetBasic != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET00011: Insertion failed in settlement_basic RTPS Case No '.$application_no);

                    $data = array(
                        'error'=>"#ERRSET00011: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }


                ////settlement_dag_details insert start
                if ($district['encroachers'] == false || empty($district['encroachers']) || $district['encroachers'] == '') {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET004545: Insertion failed settlement_dag details empty RTPS Case No '.$application_no);

                    $data = array(
                        'error'=>"#ERRSET004545: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
                foreach ($district['encroachers'] as $dags) {
                    $district['class']=$this->ncutility->getPattaTypeNo($district['app']->dist_code,$district['app']->subdiv_code,$district['app']->cir_code,$district['app']->mouza_code,$district['app']->lot_no,$district['app']->village_code, $dags->dag_no);

                    $enc_home_bigha = $dags->mbigha;
                    $enc_home_katha = $dags->mkatha;
                    $enc_home_lessa = $dags->mlessa;
                    $enc_home_ganda = $dags->mganda;
                    $enc_home_kranti = $dags->mkranti;

                    $enc_agri_bigha = $dags->agri_bigha;
                    $enc_agri_katha = $dags->agri_katha;
                    $enc_agri_lessa = $dags->agri_lessa;
                    $enc_agri_ganda = $dags->agri_ganda;
                    $enc_agri_kranti = $dags->agri_kranti;

                    $encroachment_area = [
                        'homestead' => [
                            'bigha' => $enc_home_bigha,
                            'katha' => $enc_home_katha,
                            'lessa' => $enc_home_lessa,
                            'ganda' => $enc_home_ganda,
                            'kranti' => $enc_home_kranti,
                        ],

                        'agriculture' => [
                            'bigha' => $enc_agri_bigha,
                            'katha' => $enc_agri_katha,
                            'lessa' => $enc_agri_lessa,
                            'ganda' => $enc_agri_ganda,
                            'kranti' => $enc_agri_kranti,
                        ],
                    ];


                    $fmd=array(
                        'dist_code'=>$district['app']->dist_code,
                        'subdiv_code'=>$district['app']->subdiv_code,
                        'cir_code'=>$district['app']->cir_code,
                        'mouza_pargona_code'=>$district['app']->mouza_code,
                        'lot_no'=>$district['app']->lot_no,
                        'vill_townprt_code'=>$district['app']->village_code,
                        'user_code'=>$this->session->userdata('user_code'),
                        'date_entry'=>date('Y-m-d'),
                        'case_no'=>$case_no['case_no'],
                        'petition_no'=>$case_no['petition_no'],
                        'year_no'=>date('Y'),
                        'new_land_class_code' => $district['class']->land_class_code,
                        'dag_no' => $dags->dag_no,
                        'patta_no' => $dags->patta_no,
                        'patta_type_code' => $dags->patta_code,
                        'is_urban' => $district['app']->is_urban,
                        'land_type' => $dags->land_type,
                        'revenue' => 0,
                        'operation' => 'E',
                        // 'landmark' => json_encode($landmark),
                        'encroachement_area' => json_encode($encroachment_area)
                    );

                    $fmd['dag_area_b']=$dags->applied_bigha;
                    $fmd['dag_area_k']=$dags->applied_katha;
                    $fmd['dag_area_lc']=$dags->applied_lessa;
                    $fmd['dag_area_g']=$dags->applied_ganda;
                    $fmd['dag_area_kr']=$dags->applied_kranti;

                    $fmd['home_b']=$dags->mbigha;
                    $fmd['home_k']=$dags->mkatha;
                    $fmd['home_lc']=$dags->mlessa;
                    $fmd['home_g']=$dags->mganda;
                    $fmd['home_kr']=$dags->mkranti;

                    $fmd['agri_b']=$dags->agri_bigha;
                    $fmd['agri_k']=$dags->agri_katha;
                    $fmd['agri_lc']=$dags->agri_lessa;
                    $fmd['agri_g']=$dags->agri_ganda;
                    $fmd['agri_kr']=$dags->agri_kranti;


                    //************Total Area Calculation -js- ******************
                    if (in_array($district['app']->dist_code, json_decode(BARAK_VALLEY))){
                        //******for Barak valley */
                        $areaHomeLessa = $this->ncutility->Total_ganda($fmd['home_b'],$fmd['home_k'],$fmd['home_lc'],$fmd['home_g'],$fmd['home_kr']);
                        $areaAgriLessa = $this->ncutility->Total_ganda($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc'],$fmd['agri_g'],$fmd['agri_kr']);

                        $totalAreaGanda = (float)$areaHomeLessa + (float)$areaAgriLessa;

                        $totalAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa2($totalAreaGanda);
                    }
                    else
                    {
                        $areaHomeLessa = $this->ncutility->Total_Lessa($fmd['home_b'],$fmd['home_k'],$fmd['home_lc']);
                        $areaAgriLessa = $this->ncutility->Total_Lessa($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc']);

                        $totalAreaLessa = (float)$areaHomeLessa + (float)$areaAgriLessa;

                        $totalAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa($totalAreaLessa);
                    }

                    $fmd['s_dag_area_b'] = $totalAreaArr[0];
                    $fmd['s_dag_area_k'] = $totalAreaArr[1];
                    $fmd['s_dag_area_lc'] = $totalAreaArr[2];
                    $fmd['s_dag_area_g'] = $totalAreaArr[3];
                    $fmd['s_dag_area_kr'] = 0;

                    $rezaHome = $fmd['home_b'] + $fmd['home_k'] + $fmd['home_lc'] + $fmd['home_g'] + $fmd['home_kr'];
                    $rezaAgri = $fmd['agri_b'] + $fmd['agri_k'] + $fmd['agri_lc'] + $fmd['agri_g'] + $fmd['agri_kr'];

                    $landTypeUpdate = 0;
                    if($rezaHome > 0 && $rezaAgri > 0)
                    {
                        $landTypeUpdate = 3;
                    }
                    else if($rezaHome > 0  )
                    {
                        $landTypeUpdate = 1;
                    }
                    else if($rezaAgri > 0)
                    {
                        $landTypeUpdate = 2;
                    }


                    $insSetDag = $this->db->insert('settlement_dag_details', $fmd);
                    // log_message('error',$this->db->last_query());
                    if ($insSetDag != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET0002: Insertion failed in settlement_dag_details RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#ERRSET0002: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }

                    //*******insertion in settlement_area_history**************
                    if (in_array($district['app']->dist_code, json_decode(BARAK_VALLEY))){
                        //***********actual Encroachment area ***************
                        $actual_encroachment_area_home_ganda = $this->ncutility->Total_ganda($enc_home_bigha,$enc_home_katha,$enc_home_lessa,$enc_home_ganda);
                        $actual_encroachment_area_agri_ganda = $this->ncutility->Total_ganda($enc_agri_bigha,$enc_agri_katha,$enc_agri_lessa,$enc_agri_ganda);

                        //***********total Actual Encroachment area*****************
                        $total_actual_encroachment_area_ganda = (float)$actual_encroachment_area_home_ganda + (float)$actual_encroachment_area_agri_ganda;
                        $totalEncroachmentAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa2($total_actual_encroachment_area_ganda);
                        // **********************************************


                        //***********Settlement area that applicant will get settlement on***********
                        $total_settlement_ganda_home = $this->ncutility->Total_ganda($fmd['home_b'],$fmd['home_k'],$fmd['home_lc'],$fmd['home_g']);
                        $total_settlement_ganda_agri = $this->ncutility->Total_ganda($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc'],$fmd['agri_g']);

                        //*****total Settlement area *************/
                        $total_settlement_ganda = (float)$total_settlement_ganda_home + (float)$total_settlement_ganda_agri;
                        $totalSettlementAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa2($total_settlement_ganda);

                        //*************leftout area homestead**************
                        $leftOutAreaHomeGanda = (float)$actual_encroachment_area_home_ganda - (float)$total_settlement_ganda_home;
                        $leftOutAreaHomeArr = $this->ncutility->Total_Bigha_Katha_Lessa2($leftOutAreaHomeGanda);

                        //**********Ileftout area agriculture**************
                        $leftOutAreaAgriGanda = (float)$actual_encroachment_area_agri_ganda - (float)$total_settlement_ganda_agri;
                        $leftOutAreaAgriArr = $this->ncutility->Total_Bigha_Katha_Lessa2($leftOutAreaAgriGanda);

                        //**********Total left out area***************
                        $totalLeftOutAreaGanda = (float)$total_actual_encroachment_area_ganda - (float)$total_settlement_ganda;
                        $totalLeftOutAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa2($totalLeftOutAreaGanda);

                    }
                    else
                    {
                        //********actual Encroachment area**********
                        $actual_encroachment_area_home_lessa = $this->ncutility->Total_Lessa($enc_home_bigha,$enc_home_katha,$enc_home_lessa);
                        $actual_encroachment_area_agri_lessa = $this->ncutility->Total_Lessa($enc_agri_bigha,$enc_agri_katha,$enc_agri_lessa);

                        //***********total Actual Encroachment area*****************
                        $total_actual_encroachment_area_lessa = (float)$actual_encroachment_area_home_lessa + (float)$actual_encroachment_area_agri_lessa;
                        $totalEncroachmentAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa($total_actual_encroachment_area_lessa);
                        // **********************************************

                        //*******Settlement area that applicant will get settlement on**********
                        $total_settlement_lessa_home = $this->ncutility->Total_Lessa($fmd['home_b'],$fmd['home_k'],$fmd['home_lc']);
                        $total_settlement_lessa_agri = $this->ncutility->Total_Lessa($fmd['agri_b'],$fmd['agri_k'],$fmd['agri_lc']);

                        //*************Total settlement area */
                        $total_settlement_lessa = (float)$total_settlement_lessa_home + (float)$total_settlement_lessa_agri;
                        $totalSettlementAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa($total_settlement_lessa);

                        //****************leftout area homestead**************
                        $leftOutAreaHomeLessa = (float)$actual_encroachment_area_home_lessa - (float)$total_settlement_lessa_home;
                        $leftOutAreaHomeArr = $this->ncutility->Total_Bigha_Katha_Lessa($leftOutAreaHomeLessa);

                        //*************leftout area agriculture*****************
                        $leftOutAreaAgriLessa = (float)$actual_encroachment_area_agri_lessa - (float)$total_settlement_lessa_agri;
                        $leftOutAreaAgriArr = $this->ncutility->Total_Bigha_Katha_Lessa($leftOutAreaAgriLessa);

                        //**********Total left out area***************
                        $totalLeftOutArealessa = (float)$total_actual_encroachment_area_lessa - (float)$total_settlement_lessa;
                        $totalLeftOutAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa($totalLeftOutArealessa);
                    }

                    $settlementAreaHistoryArr = [
                        'application_no' => $application_no,
                        'case_no' => $case_no['case_no'],
                        'dag_no' => $dags->dag_no,
                        'uuid' => $district['app']->uuid,
                        'created_at' => date('Y-m-d'),
                        'applied_area_home_bigha' => $dags->mbigha,
                        'applied_area_home_katha' => $dags->mkatha,
                        'applied_area_home_lessa' => $dags->mlessa,
                        'applied_area_home_ganda' => $dags->mganda,
                        'applied_area_home_kranti' => $dags->mkranti,
                        'applied_area_agri_bigha' => $dags->agri_bigha,
                        'applied_area_agri_katha' => $dags->agri_katha,
                        'applied_area_agri_lessa' => $dags->agri_lessa,
                        'applied_area_agri_ganda' => $dags->agri_ganda,
                        'applied_area_agri_kranti' => $dags->agri_kranti,
                        'actual_encroachment_area_home_bigha' => $enc_home_bigha,
                        'actual_encroachment_area_home_katha' => $enc_home_katha,
                        'actual_encroachment_area_home_lessa' => $enc_home_lessa,
                        'actual_encroachment_area_home_ganda' => $enc_home_ganda,
                        'actual_encroachment_area_home_kranti' => $enc_home_kranti,
                        'actual_encroachment_area_agri_bigha' => $enc_agri_bigha,
                        'actual_encroachment_area_agri_katha' => $enc_agri_katha,
                        'actual_encroachment_area_agri_lessa' => $enc_agri_lessa,
                        'actual_encroachment_area_agri_ganda' => $enc_agri_ganda,
                        'actual_encroachment_area_agri_kranti' => $enc_agri_kranti,
                        'total_actual_encroachment_area_bigha' => $totalEncroachmentAreaArr[0],
                        'total_actual_encroachment_area_katha' => $totalEncroachmentAreaArr[1],
                        'total_actual_encroachment_area_lessa' => $totalEncroachmentAreaArr[2],
                        'total_actual_encroachment_area_ganda' => $totalEncroachmentAreaArr[3],
                        'total_actual_encroachment_area_kranti' => 0,
                        'settlement_area_home_bigha' => $fmd['home_b'],
                        'settlement_area_home_katha' => $fmd['home_k'],
                        'settlement_area_home_lessa' => $fmd['home_lc'],
                        'settlement_area_home_ganda' => $fmd['home_g'],
                        'settlement_area_home_kranti' => $fmd['home_kr'],
                        'settlement_area_agri_bigha' => $fmd['agri_b'],
                        'settlement_area_agri_katha' => $fmd['agri_k'],
                        'settlement_area_agri_lessa' => $fmd['agri_lc'],
                        'settlement_area_agri_ganda' => $fmd['agri_g'],
                        'settlement_area_agri_kranti' => $fmd['agri_kr'],
                        'total_settlement_area_bigha' => $totalSettlementAreaArr[0],
                        'total_settlement_area_katha' => $totalSettlementAreaArr[1],
                        'total_settlement_area_lessa' => $totalSettlementAreaArr[2],
                        'total_settlement_area_ganda' => $totalSettlementAreaArr[3],
                        'total_settlement_area_kranti' => 0,
                        'leftout_area_home_bigha' => $leftOutAreaHomeArr[0],
                        'leftout_area_home_katha' => $leftOutAreaHomeArr[1],
                        'leftout_area_home_lessa' => $leftOutAreaHomeArr[2],
                        'leftout_area_home_ganda' => $leftOutAreaHomeArr[3],
                        'leftout_area_home_kranti' => 0,
                        'leftout_area_agri_bigha' => $leftOutAreaAgriArr[0],
                        'leftout_area_agri_katha' => $leftOutAreaAgriArr[1],
                        'leftout_area_agri_lessa' => $leftOutAreaAgriArr[2],
                        'leftout_area_agri_ganda' => $leftOutAreaAgriArr[3],
                        'leftout_area_agri_kranti' => 0,
                        'total_leftout_area_bigha' => $totalLeftOutAreaArr[0],
                        'total_leftout_area_katha' => $totalLeftOutAreaArr[1],
                        'total_leftout_area_lessa' => $totalLeftOutAreaArr[2],
                        'total_leftout_area_ganda' => $totalLeftOutAreaArr[3],
                        'total_leftout_area_kranti' => 0,
                    ];

                    $insertSetlArea = $this->db->insert('settlement_area_history', $settlementAreaHistoryArr);

                    if ($insertSetlArea != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#SETLARRHIS0001: Insertion failed in settlement_area_history RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#SETLARRHIS0001: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }

                    //**************end of settlement_area_history********************
                }


                //*******pdar_cron number generation */
                $sql = "SELECT pdar_cron_no FROM settlement_applicant WHERE case_no = '".$case_no['case_no']."'";
                $result = $this->db->query($sql);
                if($result->num_rows() > 0){
                    $cron_no = (int)$result->row()->pdar_cron_no + 1;
                }else{
                    $cron_no = 1;
                }

                //*********settlement_applicant insertion */
                foreach ($district['applicants'] as $setl) {

                    if ($get_aadhaar_photo != 'n' && $setl->is_applicant == '1') {
                        $timestamp = date('mdYhis', time()).uniqid();
                        $identity_doc_unique_name = str_replace('/', "-", $application_no.'_'.$timestamp);
                        // creating and saving the base64 format payment notice to uploads/paymentNotice folder
                        $aadhar_path = AADHAAR_PHOTO . $identity_doc_unique_name . ".json";
                        $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file!");
                        $aadhaar_encoded_file = $get_aadhaar_photo;
                        fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
                        fclose($aadhaar_file_to_write_base64);
                    }else{
                        $aadhar_path = '';
                    }

                    if($district['aadhar']->type == 'AADHAAR'){
                        $identity_ref_no = $district['aadhar']->aadhaar_no;
                    }else{
                        $identity_ref_no = $district['aadhar']->pan_no;
                    }

                    $applicant=array(
                        'dist_code'=>$district['app']->dist_code,
                        'subdiv_code'=>$district['app']->subdiv_code,
                        'cir_code'=>$district['app']->cir_code,
                        'mouza_pargona_code'=>$district['app']->mouza_code,
                        'lot_no'=>$district['app']->lot_no,
                        'vill_townprt_code'=>$district['app']->village_code,
                        'user_code'=>$this->session->userdata('user_code'),
                        'case_no'=>$case_no['case_no'],
                        'petition_no'=>$case_no['petition_no'],
                        'operation'=>'E',
                        'dag_no' => 0,
                        'patta_no' => 0,
                        'patta_type_code' => 0,
                        'year_no'=>date('Y'),
                        'date_entry'=>date('Y-m-d'),
                        'pdar_id' => '-1',
                        'pdar_cron_no'=>(int) $cron_no++,
                        'pdar_name' =>$setl->name_ass,
                        'pdar_guardian' =>$setl->gurdian_name_ass,
                        'eng_pdar_name' => $setl->name_eng,
                        'eng_pdar_guardian' => $setl->gurdian_name_eng,
                        'pdar_rel_guar' =>$setl->gurdian_relation_id,
                        'pdar_gender'=>$setl->gender,
                        'pdar_add1' => $setl->pre_add,
                        'pdar_add2' => $setl->per_add,
                        'pdar_mobile' => $setl->mobile,

                        'pdar_type' => $setl->pdar_type,
                        'is_applicant' => $setl->is_applicant,
                        'identity_ref_no' => $identity_ref_no,
                        'identity_type' => $district['aadhar']->type,
                        'identity_doc_link' => $aadhar_path,
                        'marital_status' => $setl->marital_status,
                        'dob' => $setl->dob,
                    );

                    $insSetApplicant = $this->db->insert('settlement_applicant', $applicant);
                    // echo $this->db->last_query(); die();

                    if ($insSetApplicant != 1) {
                        // var_dump($insSetApplicant);
                        // echo $this->db->last_query(); die();
                        $this->db->trans_rollback();
                        log_message('error', '#ERRSET0003: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                        $data = array(
                            'error'=>"#ERRSET0003: Registration of Settlement failed for case no : ".$application_no
                        );
                        echo json_encode($data);
                        return false;
                    }
                }

                //*********encroachers insert in applicant table */
                if($output->encroachers == true){

                    foreach($output->encroachers as $enc_applicant){
                        $encroacher_app=array(
                            'dist_code' => $district['app']->dist_code,
                            'subdiv_code' => $district['app']->subdiv_code,
                            'cir_code' => $district['app']->cir_code,
                            'mouza_pargona_code' => $district['app']->mouza_code,
                            'lot_no' => $district['app']->lot_no,
                            'vill_townprt_code' => $district['app']->village_code,

                            'user_code'=>$this->session->userdata('user_code'),
                            'case_no'=>$case_no['case_no'],
                            'petition_no'=>$case_no['petition_no'],
                            'operation'=>'E',

                            'dag_no' => $enc_applicant->dag_no,
                            'patta_no' => $enc_applicant->patta_no,
                            'patta_type_code' => $enc_applicant->patta_code,
                            'period_possession' => $enc_applicant->possession_date,

                            'year_no'=>date('Y'),
                            'date_entry'=>date('Y-m-d'),

                            'pdar_name' => $enc_applicant->name_ass,
                            'pdar_guardian' => $enc_applicant->gurdian_name_ass,
                            'pdar_rel_guar' => '0',
                            'pdar_cron_no'=> (int) $cron_no++,
                            'pdar_id' => -1,
                            'pdar_type' => 'EN',
                            'enc_id' => $enc_applicant->encroacher_id,
                        );
                        $insSetEncroacher = $this->db->insert('settlement_applicant',$encroacher_app);
                        // echo $this->db->last_query();
                        // var_dump($insSetEncroacher); die;

                        if ($insSetEncroacher != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRSET000309: Insertion failed in settlement_applicant RTPS Case No '.$application_no);
                            $data = array(
                                'error'=>"#ERRSET000309: Registration of Settlement failed for case no : ".$application_no
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }
                }

                ///// nominee add start /////
                if ($output->nextKin == true) {
                    // foreach ($_POST['kin_name'] as $key =>$value) {
                    foreach ($output->nextKin as $nex_of_kin) {
                        $nominee_data=array(
                            'case_no'=> $case_no['case_no'],
                            'nominee_name' => $nex_of_kin->next_of_kin_name,
                            'address' => $nex_of_kin->address,
                            'mobile_no' => $nex_of_kin->mobile_no,
                            'relation' => $nex_of_kin->relation_with_kin
                        );
                        $insNominee = $this->db->insert('settlement_nominee', $nominee_data);
                        // echo $this->db->last_query();
                        // var_dump($insSetEncroacher); die();

                        if ($insNominee != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRSET00032: Insertion failed in settlement_nominee RTPS Case No '.$application_no);
                            $data = array(
                                'error'=>"#ERRSET00032: Registration of Settlement failed for case no : ".$application_no
                            );
                            echo json_encode($data);
                            return false;
                        }
                    }
                }
                ///// nominee end //////

                //********basundhar_application insertation */
                $basundhara=array(
                    'dharitree'=>$case_no['case_no'],
                    'basundhara'=>$application_no,
                    'date_reg'=>date('Y-m-d'),
                    'reg_by'=>$this->session->userdata('user_code'),
                    'app_status'=>'M',
                    'pending_with'=>'LM'
                );
                $basundhar_app = $this->db->insert('basundhar_application',$basundhara);

                if ($basundhar_app != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRSET0003202: Insertion failed in basundhar_application RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRSET0003202: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }else{
                    //
                    //
                    //******commit if no errors */
                    $this->db->trans_commit();
                }

            }
            $sql = "Select case_no from settlement_basic where applid='$application_no' ";
            $case = $this->db->query($sql)->row();
            $application_no = $case_no = $case->case_no;

            $proceedings = $this->SettlementCommonDcModel->getSettlementProceeding($case_no);
            $basic = $this->SettlementKhasModel->getSettlementBasic($application_no);
            $applicants_buyers = $this->SettlementKhasModel->getAllApplicantBuyers($application_no);
            $applicants_owners = $this->SettlementKhasModel->getAllApplicantOwners($application_no);
            $applicants_encroacher = $this->SettlementKhasModel->getAllApplicantEncroacher($application_no);
            $applicants_riotee_nok = $this->SettlementKhasModel->getAllApplicantRioteeNok($application_no);

            $dags = $this->SettlementKhasModel->getSettlementDag($application_no);
            $lmnotes = $this->SettlementKhasModel->getSettlementTenantLmNote($application_no);
            $dhardocuments = $this->SettlementKhasModel->getDocuments($application_no);

            $lmdata=[];
            foreach($applicants_encroacher as $encroacher)
            {
                // getting the encroacher details
                $query="select * from c_land_bank_encroacher_details where id=$encroacher->enc_id";
                $encdata=$this->db->query($query)->result();
                $lmdata[] = $encdata;

            }
            $data['encdata']=$lmdata;

            $data['basic']=$basic;

            $reservation = $this->SettlementMbModel->getSettlementReservation($application_no);
            $data['reservation']=$reservation;
            $data['applicants_buyers']=$applicants_buyers;
            $data['applicants_owners']=$applicants_owners;
            $data['applicants_encroacher']=$applicants_encroacher;
            $data['applicants_riotee_nok']=$applicants_riotee_nok;

            $data['dags']=$dags;
            $data['lmnotes']=$lmnotes;
            $data['dhardocuments']=$dhardocuments;

            // for guardian relation
            $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
            $relation_executation = $this->db->query($query_for_guar_rel);
            $row = $relation_executation->num_rows;
            if ($row != 0) {
                $data['guar_rel'] = $relation_executation->result();
            }
            $premium_data = $this->db->query("SELECT sp.*,spa.area,spl.land_type,spr.house_type,spr.rate_type as ratetype FROM settlement_premium sp left outer join settlement_premium_area spa on spa.paid=sp.area_name left outer join settlement_premium_land_type spl on spl.plid=sp.land_type left outer join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no='$application_no' and is_final=1")->result();
            $data['premium_data'] = $premium_data;
            $data['premium'] = $this->SettlementCommonModel->getPremium($application_no);
            // $data['caseCount']   = $caseCount;
            // $data['caseDetails'] = $caseDetails;
            $data['proceedings'] = $proceedings;

            //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
            $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($case_no);
            $deletedEncArray = array();
            foreach($deletedEnc as $encroacherDeleted_data)
            {
                $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
            }
            $data['deleted_encroacher'] = $deletedEncArray;


            //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
            $deletedDags=$this->SettlementCommonModel->getDeletedDags($case_no);
            $deletedData = array();
            foreach($deletedDags as $deleteDag){
                $deletedData[] = json_decode($deleteDag->table_data);
            }
            $data['deleted_dags'] = $deletedData;
            $rejected_data = $this->SettlementCommonModel->getRejectModal(SETTLEMENT_KHAS_LAND_ID);
            if($rejected_data == 'n')
            {
                $data['rejected_list'] = false;
            }
            else
            {
                $data['rejected_list'] = $rejected_data;
            }

            //**************new */
            foreach(json_decode(VALIDATION_BYPASS) as $val_bypas)
            {
                if($val_bypas->SERVICE_CODE == SETTLEMENT_KHAS_LAND_ID)
                {
                    $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
                }
            }
            $data['validation_bypass'] = 0;

            foreach($data['lmnotes'] as $lm_rr)
            {
                $decoded_r = json_decode($lm_rr->lm_rejected_remarks);

                if($decoded_r){
                    foreach($decoded_r as  $lm_rejected_code)
                    {
                        if(isset($lm_rejected_code->reject_code))
                        {
                            if(in_array($lm_rejected_code->reject_code, $const_bypass_arr_code)){
                                $data['validation_bypass'] = 1;
                            }
                        }
                        else
                        {
                            if(in_array($lm_rejected_code, $const_bypass_arr_code)){
                                $data['validation_bypass'] = 1;
                            }
                        }

                    }
                }

            }

            $data['reject_list_type'] = '';

            foreach($lmnotes as $r_remark)
            {
                $rejected_list_json = json_decode($r_remark->lm_rejected_remarks);

                if($rejected_list_json)
                {
                    foreach ($rejected_list_json as $re_list) {

                        if(isset($re_list->reject_code))
                        {
                            $r_code = $re_list->reject_code;
                        }
                        else
                        {
                            $r_code = $re_list;
                        }

                        $sql = $this->db->query("select remark_head from reject_master where reject_code = ?", array($r_code));

                        if($sql->row()->remark_head != null)
                        {
                            $data['reject_list_type'] = 'new';
                        }
                        else
                        {
                            $data['reject_list_type'] = 'old';
                        }
                    }
                }
            }

            $newDagCount = $this->db->query("SELECT old_dag, new_dag FROM chitha_settlement_allottee WHERE ord_no = ? 
                               GROUP BY old_dag, new_dag", array($application_no));

            if($newDagCount->num_rows()!= 0)
            {
                $data['newDagCount'] = 1;
                $data['newDags']     = $newDagCount->result();
            }
            else
            {
                $data['newDagCount'] = 0;
                $data['newDags']     = '';
            }


            $data['_view'] = 'settlementView/Dc/Common/application_details_common_bhoodan_allcases';
            $this->load->view('layouts/main', $data);
        }


    }

    // New area check
    public function chithaAreaCheckWithCaseNo($application_no)
    {

        $dags = $this->SettlementApModel->getSettlementDag($application_no);

        $totalAreaInChitha[]  = 0;
        $appAreaInApplication = 0;
        $areaCheck = 0;
        $chithaDagArray = [];
        $lmProcessArea = [];
        $allApplicationDagArray = [];
        $appliedDags = $this->SettlementCommonDcModel->getAppliedSettlementDag($application_no);
        $basic = $this->SettlementCommonDcModel->getSettlementBasicData($application_no);

        foreach ($dags as $dag)
        {
            $totalAreaInApplication   = 0;
            $totalAreaInLMApplication = 0;
            $totalAppliedAreaInApplication = 0;

            $appDistrict  = $dag->dist_code;
            $appSubDiv    = $dag->subdiv_code;
            $appCircle    = $dag->cir_code;
            $appMouza     = $dag->mouza_pargona_code;
            $appLot       = $dag->lot_no;
            $appVillage   = $dag->vill_townprt_code;
            $appDag       = $dag->dag_no;
            $appPattaType = $dag->patta_type_code;
            $appPatta     = $dag->patta_no;

            $chithaDag = $this->SettlementCommonDcModel->getChithaDagAreaDetails(
                $appDistrict, $appSubDiv, $appCircle, $appMouza, $appLot, $appVillage, $appDag, $appPattaType, $appPatta);

            $allApplicationDags = $this->SettlementCommonDcModel->getAllDagAreaDetailsByLocation(
                $appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta);

            $allLmProcess = $this->SettlementCommonDcModel->getAllDagAreaDetailsByLocationNotSubmit(
                $appDistrict,$appSubDiv,$appCircle,$appMouza,$appLot,$appVillage,$appDag,$appPattaType,$appPatta,$application_no);

            if (in_array($appDistrict, json_decode(BARAK_VALLEY)))
            {
                // chitha
                $bighaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_b, 0);
                $kathaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_k, 0);
                $lessaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_lc, 0);
                $gandaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_g, 0);
                $totalAreaInChitha = ($bighaChitha * 6400) + ($kathaChitha * 320) + ($lessaChitha * 20) + $gandaChitha;

                // SOD/ADC processing application
                foreach ($allApplicationDags as $singleApp)
                {
                    $bighaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_b, 0);
                    $kathaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_k, 0);
                    $lessaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_lc, 0);
                    $gandaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_g, 0);
                    $areaInApplication = ($bighaApp * 6400) + ($kathaApp * 320) + ($lessaApp * 20) + $gandaApp;

                    $totalAreaInApplication += $areaInApplication;
                }

                // LM processing application
                foreach ($allLmProcess as $singleLMApp)
                {
                    $bighaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_b, 0);
                    $kathaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_k, 0);
                    $lessaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_lc, 0);
                    $gandaLMApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_g, 0);

                    $areaInLMApplication = ($bighaLmApp * 6400) + ($kathaLmApp * 320) + ($lessaLmApp * 20) + $gandaLMApp;

                    $totalAreaInLMApplication += $areaInLMApplication;
                }

                if($basic->dc_proceeding == 0)
                {
                    // application area
                    foreach ($appliedDags as $singleAppArea)
                    {
                        if($chithaDag->dag_no == $singleAppArea->dag_no)
                        {
                            $bighaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_b, 0);
                            $kathaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_k, 0);
                            $lessaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_lc, 0);
                            $gandaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_g, 0);
                            $appAreaInApplication = ($bighaAppArea * 6400) + ($kathaAppArea * 320) + ($lessaAppArea * 20) + $gandaAppArea;

                            $totalAppliedAreaInApplication += $appAreaInApplication;
                        }
                    }
                }

                if($totalAreaInChitha == 0)
                {
                    $areaCheck = 1;
                }
                if(($totalAreaInApplication + $totalAppliedAreaInApplication) == 0)
                {
                    $areaCheck = 1;
                }
                if($totalAreaInChitha < $totalAreaInApplication + $totalAreaInLMApplication)
                {
                    $areaCheck = 1;
                }

            }
            else
            {
                // chitha
                $bighaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_b, 0);
                $kathaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_k, 0);
                $lessaChitha = $this->UtilsModel->defaultValue($chithaDag->dag_area_lc, 0);
                $totalAreaInChitha = ($bighaChitha * 100) + ($kathaChitha * 20) + $lessaChitha;

                // SOD/ADC processing application
                foreach ($allApplicationDags as $singleApp)
                {
                    $bighaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_b, 0);
                    $kathaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_k, 0);
                    $lessaApp = $this->UtilsModel->defaultValue($singleApp->s_dag_area_lc, 0);
                    $areaInApplication = ($bighaApp * 100) + ($kathaApp * 20) + $lessaApp;

                    $totalAreaInApplication += $areaInApplication;
                }

                // LM processing application
                foreach ($allLmProcess as $singleLMApp)
                {
                    $bighaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_b, 0);
                    $kathaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_k, 0);
                    $lessaLmApp = $this->UtilsModel->defaultValue($singleLMApp->s_dag_area_lc, 0);
                    $areaInLMApplication = ($bighaLmApp * 100) + ($kathaLmApp * 20) + $lessaLmApp;

                    $totalAreaInLMApplication += $areaInLMApplication;
                }

                if($basic->dc_proceeding == 0)
                {
                    // application area
                    foreach ($appliedDags as $singleAppArea)
                    {
                        if($chithaDag->dag_no == $singleAppArea->dag_no)
                        {
                            $bighaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_b, 0);
                            $kathaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_k, 0);
                            $lessaAppArea = $this->UtilsModel->defaultValue($singleAppArea->s_dag_area_lc, 0);
                            $appAreaInApplication = ($bighaAppArea * 100) + ($kathaAppArea * 20) + $lessaAppArea;

                            $totalAppliedAreaInApplication += $appAreaInApplication;
                        }
                    }
                }

                if($totalAreaInChitha == 0)
                {
                    $areaCheck = 1;
                }
                if(($totalAreaInApplication + $totalAppliedAreaInApplication) == 0)
                {
                    $areaCheck = 1;
                }
                if($totalAreaInChitha < $totalAreaInApplication + $totalAreaInLMApplication)
                {
                    $areaCheck = 1;
                }
            }
            $chithaDagArray[]         = $chithaDag;
            $lmProcessArea[]          = $allLmProcess;
            $allApplicationDagArray[] = $allApplicationDags;
        }

        $checkAreaDetail = array(
            'chithaArea'    => $chithaDagArray,
            'reservedArea'  => $allApplicationDagArray,
            'lmProcessArea' => $lmProcessArea,
            'appliedDags'   => $appliedDags,
            'areaCheck'     => $areaCheck,
        );

        return $checkAreaDetail;
    }

    public function apiAadharWiseApplication()
    {

        $application_no = $this->input->get('app');
        $postRequest = array(
            'application_no'   => $application_no
        );

        $cURL = curl_init();
        curl_setopt($cURL, CURLOPT_URL, AADHAR_APPLICATION_API_LINK_MB3);
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURL, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($cURL, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($cURL, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($cURL, CURLOPT_POSTFIELDS, $postRequest);

        $output = curl_exec($cURL);


        $httpcode = curl_getinfo($cURL, CURLINFO_HTTP_CODE);
        curl_close($cURL);
        if($httpcode != 200)
        {
            return false;
        }
        $output = json_decode($output);

        if(isset($output))
        {
            $lmdata['applicationsCount'] = 1;
            $lmdata['applications'] = $output->appiledDetails;
        }
        else
        {
            $lmdata['applicationsCount'] = 0;
            $lmdata['applications'] = '';
        }

        // log_message('error', 'AADHAAR_DATA: ' . json_encode($output->appiledDetails));


        $lmdata['_view'] = 'SettlementView/include/AadharWiseApplicationtView';
        $this->load->view('layouts/main', $lmdata);

    }

    public function apiDagWiseApplication()
    {

        $application_no = $this->input->get('app');
        $dag_no = $this->input->get('dag');

        $token = $this->ncutility->createTokenJwt();

        $postRequest = array(
            'application_no' => $application_no,
            'api_key' => API_KEY,
            'token' => $token,
        );

        $cURL = curl_init();
        curl_setopt($cURL, CURLOPT_URL, API_LINK_MB3 . "getAppDetails");
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURL, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($cURL, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($cURL, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($cURL, CURLOPT_POSTFIELDS, $postRequest);

        $output = curl_exec($cURL);

        if (isset(json_decode($output)->responseType)) {
            if (json_decode($output)->responseType == 3) {
                echo json_decode($output)->data . " - Unauthorized access!";
                return false;
            }
        }


        $httpcode = curl_getinfo($cURL, CURLINFO_HTTP_CODE);
        curl_close($cURL);
        if($httpcode != 200) {
            return false;
        }


        // $curl_handle = curl_init();
        // curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "getAppDetails");
        // curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        // curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
        // curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
        //     'application_no' => $application_no,
        //     'api_key' => API_KEY,
        //     'token' => $token,
        // )));
        // $output = curl_exec($curl_handle);
        // if (isset(json_decode($output)->responseType)) {
        //     if (json_decode($output)->responseType == 3) {
        //         echo json_decode($output)->data . " - Unauthorized access!";
        //         return false;
        //     }
        // }
        // curl_close($curl_handle);

        $output = json_decode($output);
        $district['app'] = $output->application;

        $dist_code = $district['app']->dist_code;
        $subdiv_code = $district['app']->subdiv_code;
        $cir_code = $district['app']->cir_code;
        $mouza_code = $district['app']->mouza_code;
        $lot_no = $district['app']->lot_no;
        $village_code = $district['app']->village_code;
        $dag_no = $dag_no;
        // var_dump($district['app']); die();

        // $dist_code      = '07';
        // $subdiv_code    = '01';
        // $cir_code       = '01';
        // $mouza_code     = '02';
        // $lot_no         = '06';
        // $village_code   = '10002';
        // $dag_no         = '693';

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => API_LINK_MB3 . 'applicantAppliedForSettlementServicesByDagNo',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'mouza_code' => $mouza_code,
                'lot_no' => $lot_no,
                'village_code' => $village_code,
                'dag_no' => $dag_no,
            ),
        ));

        $output = curl_exec($curl);
        curl_close($curl);
        $output = json_decode($output);

        // var_dump($output); die();
        $chithaDag = $this->NcCommonModel->getChithaDagAreaDetailsByDagNo
        ($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $village_code, $dag_no);


        if ($output->appiledDetails == "" || $output->appiledDetails == null) {
            $this->session->set_flashdata('message', "Data not found!!");
            redirect(base_url() . "index.php/home");

        } else {
            $lmdata['applications'] = $output->appiledDetails;
            $lmdata['service_code'] = $district['app']->service_code;
            $lmdata['chithaArea'] = $chithaDag;
            $lmdata['dag_no'] = $dag_no;
            $lmdata['dist_code'] = $dist_code;
            $lmdata['subdiv_code'] = $subdiv_code;
            $lmdata['cir_code'] = $cir_code;
            $lmdata['mouza_code'] = $mouza_code;
            $lmdata['lot_no'] = $lot_no;
            $lmdata['vill_code'] = $village_code;
        }
        // var_dump($lmdata['service_code']); die();

        // var_dump($lmdata['applications']); die();

        // $lmdata['_view'] = 'NcVillageService/Common/Includes/DagWiseApplicationtView';

        $lmdata['_view'] = 'NcVillageService/Common/DagWiseApplicationtViewNew';
        $this->load->view('layouts/main', $lmdata);

    }


}
