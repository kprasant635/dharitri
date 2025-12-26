
<?php
class SettlementReviewController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('SettlementModel/SettlementCommonModel');
        $this->load->model('SettlementModel/SettlementKhasModel');
        $this->load->model('SettlementModel/SettlementAutoRegistrationModel');
    }

    public function reviewCaseList(){
        $data['service'] = $_GET['service'];

        $data['_view'] = 'settlementReview/reviewList';
        $this->load->view('layouts/main', $data);
    }


    public function paginationAPIBulk()
    {
        $service = $this->input->post('service');
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        $occupation = trim($this->input->post('occupation'));

        // $search = $this->input->post('search');
        // $search = $search['value'];

        $searchByCol_0 = trim($this->input->post('columns')[0]['search']['value']);
        $searchByCol_1 = trim($this->input->post('columns')[1]['search']['value']);

        $is_cat = $this->input->post('is_category');

        $is_rural = $this->input->post('rural');

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $ru = $this->session->userdata('user_desig_code');

        $curl_handle = curl_init();
        //curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."lmServicewiseRecords/$service/$dist_code/$subdiv_code/$cir_code/$mouza_pargona_code/$lot_no");

        //this api should be changed to the new one for reivew only cases
        // curl_setopt($curl_handle, CURLOPT_URL, "http://localhost/mb3/Api/lmServicewiseRecordsReview/$service/$dist_code/$subdiv_code/$cir_code/$mouza_pargona_code/$lot_no");

        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2 . "lmServicewiseRecordsReview/$service/$dist_code/$subdiv_code/$cir_code/$mouza_pargona_code/$lot_no");

        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'start' => $start,
            'length' => $length,
            'order' => $order,
            'searchByCol_0' => $searchByCol_0,
            'searchByCol_1' => $searchByCol_1,
            'is_cat' => $is_cat,
            'is_rural' => $is_rural,
            'occupation' => $occupation
        )));
        $result = curl_exec($curl_handle);

        $results = json_decode($result);

        if (isset($results)) {
            //==============getting the reject_list
            $rejected_data = $this->SettlementCommonModel->getRejectModal($service);
            if($rejected_data == 'n')
            {
                $rejected_list = false;
            }
            else
            {
                $rejected_list = $rejected_data;
            }

            $data_rows = $results->data_results;

            foreach ($data_rows as $rows) {

                $case_no = $this->utilityclass->getCaseNoByApplId((string)$dist_code, (string)$rows->application_no);

                $dags = $this->SettlementKhasModel->getSettlementDag($case_no);

                $chithaRemarks = $this->SettlementCommonModel->getChithaFlaggedRemarks($dags, $rejected_list);

                if($chithaRemarks == true)
                {
                    $chithaFlag = '<span class="text-danger alert-danger">Yes</span>';
                }
                else
                {
                    $chithaFlag = 'No';
                }

                $case_no = $this->utilityclass->getCaseNoByApplId($this->session->userdata('dist_code'), $rows->application_no);

                // $khas_link = '<a type="button" href="' . base_url() . 'index.php/SettlementKhasLand/applicationKhaslandRegistration?app=' . $this->utilityclass->encryptJwtCase($rows->application_no) . '" class="lmreportmut btn-sm btn btn-primary">write report</a>';
                $khas_link = '
                <button type="button" onclick="viewModifiedData(\'' . $this->utilityclass->encryptJwtCase($rows->application_no) . '\')" class="btn btn-sm btn-info font-weight-bold">
                    View Modified Data
                </button>
                <br>
                <a alt="View application" class="mt-1 text-white btn btn-sm btn-success" target="Application" href="' . base_url('index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $case_no) . '">
                    <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Application
                </a>
                ';

                // $tenant_link = '<a type="button" href="' . base_url() . 'index.php/SettlementTenant/settlementTenantRegistration?app=' . $this->utilityclass->encryptJwtCase($rows->application_no) . '" class="lmreportmut btn-sm btn btn-primary">
                //     write report</a>';
                // $tribal_link = '<a type="button" href="' . base_url() . 'index.php/SettlementTribal/TribalApplicationRegistration?app=' . $this->utilityclass->encryptJwtCase($rows->application_no) . '" class="lmreportmut btn-sm btn btn-primary">
                //     write report</a>';
                // $ap_link = '<a type="button" href="' . base_url() . 'index.php/SettlementAp/settlementApplication?app=' . $rows->application_no . '" class="lmreportmut btn-sm btn btn-primary">
                //     write report</a>';
             
                // $vgr_link = '<a type="button" href="' . base_url() . 'index.php/SettlementVgr/applicationVgrRegistration?app=' . $this->utilityclass->encryptJwtCase($rows->application_no) . '" class="lmreportmut btn-sm btn btn-primary">
                //     write report</a>';
                // $tea_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCultivator/settlementApplication?app=' . $this->utilityclass->encryptJwtCase($rows->application_no) . '" class="lmreportmut btn-sm btn btn-primary">
                //     write report</a>';

                $tenant_link = '';
                $tribal_link = '';
                $ap_link = '';
                $vgr_link = '';
                $tea_link = '';

                $json[] = array(
                    $rows->application_no,
                    '<span class="px-3"><strong>' . $rows->application_no . '</strong></span>',
                    $rows->date_submission,
                    $rows->applicant_occupation,
                    $rows->type,
                    '<b>'.$chithaFlag.'</b>',
                    $rows->rurban,

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_code, $rows->lot_no, $rows->village_code),

                    (($service == SETTLEMENT_TENANT_ID) ? $tenant_link : (($service == SETTLEMENT_AP_TRANSFER_ID) ? $ap_link : (($service == SETTLEMENT_TRIBAL_COMMUNITY_ID) ? $tribal_link : (($service == SETTLEMENT_KHAS_LAND_ID) ? $khas_link : (($service == SETTLEMENT_PGR_VGR_LAND_ID) ? $vgr_link : (($service == SETTLEMENT_SPECIAL_CULTIVATORS_ID) ? $tea_link : '')))))),
                );
            }

            $total_records = $results->total_records;
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


    public function getModifiedReviewData(){
        $encrypted_application_no = $this->input->post('application_no');
        $application_no = $this->utilityclass->decryptJwtCase($encrypted_application_no);

        $token = $this->utilityclass->createTokenJwt();
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getAppDetails");
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
        $output = json_decode($output);

        if(empty($output)){
            echo json_encode([
                'responseType' => 0,
                'msg' => 'Someting went wrong! Please contact admin...'
            ]);
            return false;
        }

        $en_changed = false;
        $joint_applicant_changed = false;
        foreach($output->settlements as $row){
            if($row->pdar_type == 'EN' && $row->is_changed == 'Y'){
                $en_changed = true;
                break;
            }

            if($row->pdar_type == 'B' && $row->is_applicant != 1 && $row->is_changed == 'Y'){
                $joint_applicant_changed = true;
                break;
            }
        }

        $output->en_changed = $en_changed;
        $output->joint_applicant_changed = $joint_applicant_changed;

        // ***************************
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getModifiedData");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application_no' => $application_no,
        )));

        $output2 = curl_exec($curl_handle);
        curl_close($curl_handle);
        $output2 = json_decode($output2);


        $modified_new_dag[] = '';
        $modified_old_dag[] = '';
        $join_applicant_new = false;
        $is_new_document = false;

        $doc_data = array();

        if (!empty($output2)) {
            foreach ($output2->entered_data as $ent) {
                if ($ent->modification_of == 'DAG_MODIFIED') {
                    $modified_new_dag[] = $ent->dag_no;
                    $modified_old_dag[] = $ent->old_dag;
                }

                if ($join_applicant_new == false && $ent->modification_of == 'JOINT_APPL_ADDED') {
                    $join_applicant_new = true;
                }

                if ($is_new_document == false && $ent->modification_of == 'DOCUMENT_UPLOADED') {
                    $is_new_document = true;
                }

                if($ent->modification_of == 'DOCUMENT_UPLOADED'){
                    $doc_data[] = json_decode($ent->modified_json_data);
                }
            }
        }

        // var_dump($output2->remark_row->review_reason);
        

        $output->modified_data = (object)[
            'modified_new_dag' => $modified_new_dag,
            'modified_old_dag' => $modified_old_dag,
            'join_applicant_new' => $join_applicant_new,
            'is_new_document' => $is_new_document,
            'docs' => $doc_data,
            'remark' => isset($output2->remark_row) && isset($output2->remark_row->review_reason) ? $output2->remark_row->review_reason : null
        ];


        $this->load->view('settlementReview/load_modified_data', $output);
    }

    public function bulkForwardSubmit(){
        $applications_array = $this->input->post('selected_applications');
        $remark = $this->input->post('remark');
        $service_code = $this->input->post('service_code');

        // $applications_array = ['RTPS/SHLTC/2024/26402'];

        // $remark = 'test remark';
        // $service_code = 15;

        //register the case 
        foreach($applications_array as $application_no){

            if($service_code == SETTLEMENT_KHAS_LAND_ID){
                $reg_response = $this->SettlementAutoRegistrationModel->autoRegKhasland($application_no, true, $remark);
            }elseif($service_code == SETTLEMENT_TRIBAL_COMMUNITY_ID){
                $reg_response = $this->SettlementAutoRegistrationModel->autoRegTribal($application_no, true, $remark);
            }elseif($service_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID){
                $reg_response = $this->SettlementAutoRegistrationModel->autoRegCultivation($application_no, true, $remark);
            }elseif($service_code == SETTLEMENT_TENANT_ID){
                $reg_response = $this->SettlementAutoRegistrationModel->autoRegTenant($application_no, true, $remark);
            }elseif($service_code == SETTLEMENT_AP_TRANSFER_ID){
                $reg_response = $this->SettlementAutoRegistrationModel->autoRegAp($application_no, true, $remark);
            }elseif($service_code == SETTLEMENT_PGR_VGR_LAND_ID){
                $reg_response = $this->SettlementAutoRegistrationModel->autoRegVgr($application_no, true, $remark);
            }else{
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR301: Unable to register case! Something went wrong...'
                ]);
                return false;
            }


            if($reg_response['responseType'] != 2){
                $err_application_array[] = $reg_response['message'].':'.$application_no;
                continue;
            }else{
                $success_application_array[] = $application_no;
            }
        }

        if(!empty($err_application_array)){

            $err_app_str = implode(', ',$err_application_array);

            echo json_encode([
                'responseType' => 0,
                'msg' => '#ERR238: Unable to register case for application no(s) '. $err_app_str
            ]);
            return false;
        }

        echo json_encode([
            'responseType' => 2,
            'msg' => 'Case(s) successfully registed and reverted to LM for report...'
        ]);


    }


    public function decodeBase64($encoded_string){
        $file_data= base64_decode($encoded_string);
        $file = finfo_open();
        $mime_type = finfo_buffer($file, $file_data, FILEINFO_MIME_TYPE);
        $file_type = explode('/', $mime_type)[0];
        $extension = explode('/', $mime_type)[1];
        /*$acceptable_mimetypes = [
          'application/pdf',
          'image/jpg',
        ];*/
        $acceptable_mimetypes = [
          'text/plain',
          'text/html',
          'application/pdf',
          'image/jpg',
          'image/jpeg',
          'image/png',
        ];
        if (!in_array($mime_type, $acceptable_mimetypes)) {
          log_message("error","error occured".json_encode($mime_type));
          throw new \Exception('File mime type not acceptable');
        }
        log_message("error","No error occured".json_encode($mime_type));
        return array('content_type'=>$mime_type,'extension'=>$extension);
      
      }
    












    public function fullPartialPaid(){

        $direct_direct_full_pay_sql = $this->db->query("SELECT sum(sp.paid_amount) as paid_amount_direct_full, count(sb.case_no) as direct_full_app_count from settlement_basic sb join (
            
                select distinct(case_no), paid_amount from settlement_premium where is_final = 1 and grn_no is not null and due_amount <= paid_amount and area_name in (1, 2, 3, 4, 5, 6, 11, 12, 13, 14, 15, 16, 17)) AS sp on sb.case_no = sp.case_no and sb.status in ('N', 'VN')"
            
            );

        $f_direct_row = $direct_direct_full_pay_sql->row();

        $paid_amount_direct_full = $f_direct_row->paid_amount_direct_full;
        $direct_full_count = $f_direct_row->direct_full_app_count;

        $indirect_full__sql = $this->db->query("SELECT sum(sp.paid_amount) as paid_amount_indirect_full, count(sb.case_no) as indirect_full_app_count from settlement_basic sb join (
                select distinct(seh.case_no), seh.final_amount as paid_amount from settlement_premium spi join settlement_emi_history seh on spi.case_no = seh.case_no where spi.is_final = 1 and spi.grn_no is not null and spi.due_amount > spi.paid_amount and seh.remaining_amount = 0 and spi.area_name in (1, 2, 3, 4, 5, 6, 11, 12, 13, 14, 15, 16, 17)
                ) AS sp on sb.case_no = sp.case_no and sb.status in ('N', 'VN')"
            
            );

        $f_indirect_row = $indirect_full__sql->row();

        $paid_amount_indirect_full = $f_indirect_row->paid_amount_indirect_full;
        $indirect_full_count = $f_indirect_row->indirect_full_app_count;

        $fully_paid = $paid_amount_direct_full + $paid_amount_indirect_full;

        $full_cnt = $direct_full_count + $indirect_full_count;


        $direct_partial = $this->db->query("
                    SELECT SUM(sp.paid_amount) AS direct_partial, count(sb.case_no) as partial_direct_cnt
                    FROM settlement_basic sb
                    JOIN (
                        SELECT DISTINCT sp.case_no, sp.paid_amount 
                        FROM settlement_premium sp
                        WHERE sp.is_final = 1 
                        AND sp.grn_no IS NOT NULL 
                        AND sp.due_amount > sp.paid_amount 
                        AND sp.area_name IN (1, 2, 3, 4, 5, 6, 11, 12, 13, 14, 15, 16, 17)
                    ) AS sp ON sb.case_no = sp.case_no
                    WHERE sb.status IN ('N', 'VN')
                    AND NOT EXISTS (
                        SELECT 1 
                        FROM settlement_emi_history seh
                        WHERE seh.case_no = sp.case_no
                    )
                ");
    

        $d_partial_row = $direct_partial->row();

        $direct_partial = $d_partial_row->direct_partial;
        $partial_direct_cnt = $d_partial_row->partial_direct_cnt;


        $indirect_partial = $this->db->query("SELECT SUM(sp.paid_amount) as indirect_partial, count(sb.case_no) as partial_indirect_cnt  from settlement_basic sb join (
            SELECT seh.case_no, (seh.final_amount - seh.remaining_amount) paid_amount from settlement_premium spi join settlement_emi_history seh on spi.case_no = seh.case_no where spi.is_final = 1 and spi.grn_no is not null and spi.due_amount > spi.paid_amount and seh.remaining_amount != 0 and spi.area_name in (1, 2, 3, 4, 5, 6, 11, 12, 13, 14, 15, 16, 17) order by id desc limit 1
            ) AS sp on sb.case_no = sp.case_no and sb.status in ('N', 'VN')"
        
        );

        $ind_partial_row = $indirect_partial->row();

        $indirect_partial = $ind_partial_row->indirect_partial;
        $partial_indirect_cnt = $ind_partial_row->partial_indirect_cnt;


        $partial = $direct_partial + $indirect_partial;

        $partial_cnt = $partial_direct_cnt + $partial_indirect_cnt;

        echo 'full_count - '.$full_cnt.'<br>';
        echo 'full - '.$fully_paid.'<br>';
        echo 'partial_count - '.$partial_cnt.'<br>';
        echo 'partial - '.$partial.'<br>';
    } 





}