<?php
class SettlementInstitutionCo extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
            // Allowed designations
        $allowed = ['CO'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }

        $this->load->model('patta/pattamodel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->model('basundhara/SettlementApiModel');
        $this->load->model('rtps/rtpsmodel');
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('SettlementModel/SettlementInsModel');
        $this->load->model('SettlementModel/SettlementVgrModel');
        $this->load->model('SettlementModel/SettlementCommonModel');
        $this->load->library('AES');
        $this->load->model('SettlementModel/SettlementNRCFileUploadModel');
        $this->load->model('SettlementModel/SettlementAutoRegistrationModel');
        $this->load->model('UtilsModel');
        $this->load->model('SettlementMb/SettlementCommonDcModel');
        $this->load->model('SettlementMb/SettlementMbModel');
        $this->load->model('NcModel/NcCommonModel');
        $this->load->model('basundhara/basundhara3Model');
        // $this->load->model('AllotmentCertificateModel');

        // $this->dbswitch();
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


    public function index()
    {
        // echo "sadfghjk"; die;
        $service_code = $this->input->get('service');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');
        $year_no = year_no;
        $define_date = define_date;
        // var_dump($this->session->all_userdata()); die;
        $user_desig_code = $this->session->userdata('user_desig_code');
        if ($user_desig_code != 'CO' && $user_desig_code != 'SK') {
            $this->session->set_flashdata('message', "#HOMEC1503303 : Unauthorized access");
            redirect(base_url() . "index.php/home");
        }

        $counts['user_desig_code'] = $user_desig_code;

        if (LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO') {
            $lot_string = $this->caseListUnderMappingLot();
        }

        $lot_bifurcate = '';
        $lot_bifurcate_sb = '';

        if (LOT_BIFURCATE == 1) {
            if (isset($lot_string) && $lot_string != null) {
                $lot_bifurcate = "and mouza_pargona_code ||'_' || lot_no in ($lot_string)";
                $lot_bifurcate_sb = "and sb.mouza_pargona_code ||'_' || sb.lot_no in ($lot_string)";
            }
        }

        $url = API_LINK_MB3."instituteCoLandingCount/$dist_code/$subdiv_code/$cir_code" ;
        $ch  = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);

        $counts['new_reg_count'] = $output[0]->count;


        $counts['sk_first'] = $this->db->query("select count(*) as c from settlement_basic left join settlement_ap_lmnote on settlement_basic.case_no=settlement_ap_lmnote.case_no where  lm_note ='1' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and settlement_basic.status='W' and from_office='LM' and (pending_officer='SK' OR pending_officer='CO') and service_code='$service_code'  and settlement_basic.date_entry >= '$define_date' ")->row()->c;

        $counts['re_report_lm_sk'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='X' and (from_office='LM' OR from_office='DC') and pending_officer='SK' and service_code='$service_code'  and date_entry >= '$define_date' ")->row()->c;

        $counts['first'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='W' and from_office in ('LM','SK','CO','ADC','SDO') and (pending_officer='CO' or pending_officer='SK') and service_code='$service_code'   and date_entry >= '$define_date' $lot_bifurcate")->row()->c;
        // $counts['_view'] = 'settlement_mb/settlement_mb_co';

        $counts['re_report_lm'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='X' and (from_office='LM' OR from_office='SK' OR from_office='DC') and (pending_officer='CO' or pending_officer='SK') and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['reverted_by_dc'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and (from_office='DC' or from_office='ADC' or from_office='SDO') and pending_officer='CO'  and service_code='$service_code'  and date_entry >= '$define_date' $lot_bifurcate")->row()->c;

        $counts['chitha'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='C' and from_office='DC' and pending_officer='CO' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['payment_notice'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='M' and (from_office='DPT' or from_office='DC') and pending_officer='CO' and service_code='$service_code' and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['payment_confirm'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='N' and from_office='CO' and pending_officer='CO' and allotment_settlement_transfer is not null and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['ooa_oos_issue'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='N' and from_office='CO' and pending_officer='CO' and allotment_settlement_transfer is not null and offer_of_allot_settlement='YES' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['reverted_by_co'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='R' and from_office='CO'  and pending_officer='LM' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['forwarded_to_adc'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_officer not in('LM','SK','CO') and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['rejected_by_co'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and pending_officer='CO' and status='D' and service_code='$service_code'  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['revival_flag_list'] = $this->db->query("select count(*) as c from settlement_revival_flag where  req_by='CO' and  req_by = 'CO' and service_code='$service_code'  and (user_code='$user_code')")->row()->c;

        $counts['bulk_approve_lm_report'] = $this->db->query("select count(*) as c from settlement_basic where  dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='N' and from_office='CO' and pending_officer='CO' and service_code='$service_code' and chitha_processing_details = 1  and date_entry >= '$define_date'  $lot_bifurcate")->row()->c;

        $counts['bulk_chitha_update'] = $this->db->query("select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no where sb.status = ? and sb.chitha_processing_details = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is not null and DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND sb.order_passed is null AND sb.co_chitha_corrected_yn is null " . $lot_bifurcate_sb, array('N', 2, $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', SLIJE_ID, 1))->row()->c;


        $counts['bulk_chitha_update_partial'] = $this->db->query("
        SELECT
            count(distinct(sb.case_no)) as C
            FROM settlement_basic sb
            JOIN
            (
                SELECT
                    sh.case_no
                FROM
                    settlement_emi_history sh
                JOIN
                    (
                        SELECT
                            case_no,
                            MAX(id) AS max_id
                        FROM
                            settlement_emi_history
                        GROUP BY
                            case_no
                        HAVING
                            COUNT(*) > 1
                    ) max_ids
                ON
                    sh.case_no = max_ids.case_no
                AND
                    sh.id = max_ids.max_id AND paid_no_of_installment != chitha_update_status
            ) AS seh
            ON sb.case_no = seh.case_no
            where sb.status = ?
            and sb.chitha_processing_details = ?
            and sb.dist_code = ?
            and sb.subdiv_code = ?
            and sb.cir_code = ?
            and sb.from_office = ?
            and sb.pending_officer = ?
            and sb.service_code = ?
            AND DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND DATE_PART('day', now()::timestamp- sb.ppp_issue_date::timestamp)>15 AND sb.order_passed is NOT NULL AND sb.co_chitha_corrected_yn is NOT NULL " . $lot_bifurcate_sb, array('N', 2, $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', SLIJE_ID))->row()->c;

        $counts['re_generate_premium_notice'] = $this->db->query('select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no join settlement_notice sn on sb.case_no = sn.case_no where sb.status = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is null and sn.notice_type=?' . $lot_bifurcate . '', array('N', $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', SLIJE_ID, 1, 'PN'))->row()->c;


        $counts['remain_amt_prem_notice'] = $this->db->query('select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no where sb.status = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is not null and sp.due_amount > sp.paid_amount and sb.case_no NOT IN (SELECT DISTINCT(case_no) FROM settlement_notice WHERE case_no = sb.case_no AND notice_type = ?) ' . $lot_bifurcate . '', array('N', $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', SLIJE_ID, 1, 'PNP1'))->row()->c;

        $counts['print_partial_notice'] = $this->db->query('select count(distinct(sb.case_no)) as c from settlement_basic sb join settlement_premium sp on sb.case_no = sp.case_no where sb.status = ? and sb.dist_code = ? and sb.subdiv_code = ? and sb.cir_code = ? and sb.from_office = ? and sb.pending_officer = ? and sb.service_code = ? and sp.is_final = ? and sp.grn_no is not null and sp.due_amount > sp.paid_amount and sb.case_no IN (SELECT DISTINCT(case_no) FROM settlement_notice WHERE case_no = sb.case_no AND notice_type = ?) ' . $lot_bifurcate . '', array('N', $dist_code, $subdiv_code, $cir_code, 'CO', 'CO', SLIJE_ID, 1, 'PNP1'))->row()->c;


        // echo $this->db->last_query();
        // var_dump($counts['print_partial_notice']); die;

        // $counts['bulk_chitha_update'] =0;
        // echo $this->db->last_query();
        // var_dump($counts['payment_notice']); die();
        $counts['service_code'] = $service_code;

        $counts['_view'] = 'settlement_mb/settlement_mb_co_ins';
        $this->load->view('layouts/main', $counts);
    }

    public function initLanding(){
        $service_code=$this->input->get('service');
        $status = $this->input->get('s');
        // $data['select_range'] = $select_offset = $this->input->post('select_range');
        //$data['getFirstProceeding'] = $this->SettlementMbModel->getSettlementCoFirstPending( $service_code);
        
        $data['select_data'] = $this->SettlementCommonModel->locationSelectAll();

        $data['_view'] = 'settlement_mb/first_proceeding_co_landing_ins';
        $this->load->view('layouts/main', $data);
    }

    public function paginationCoFirstBulk()
    {
        if(LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO'){
            $lot_string = $this->caseListUnderMappingLot();
        }
        $s_code = $this->input->post('service');
        $search_term = $this->input->post('search_term');
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

        $search = $this->input->post('search');
        $search = $search['value'];

        $searchByCol_0 = $this->input->post('columns')[1]['search']['value'];

        $is_cat = $this->input->post('is_category');


        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "coServicewiseRecords/$s_code/$dist_code/$subdiv_code/$cir_code");

        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'start'                 => $start,
            'length'                => $length,
            'order'                 => $order,
            'application_no'        => $searchByCol_0,
            'mouza_pargona_code'    => $mouza_pargona_code,
            'lot_no'                => $lot_no,
            'vill_townprt_code'     => $is_cat
        )));
        $result  = curl_exec($curl_handle);
        $results = json_decode($result);

        if (isset($results)) 
        {         
            foreach ($results->data_results as $rows) {

                $ins_link = '<a type="button" href="' . base_url() . 'index.php/SettlementInstitutionCo/initRegistration?app='. $this->utilityclass->encryptJwtCase($rows->application_no).'" class="lmreportmut btn-sm btn btn-primary">
                    write report</a>';
         
        
                $json[] = array(
                    $rows->application_no,
                    '<span class="px-3"><strong>' . $rows->application_no . '</strong></span>',

                    $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_code),

                    $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_code, $rows->lot_no),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_code, $rows->lot_no, $rows->village_code),
            
                    $rows->date_submission,
            
                    (($s_code == SLIJE_ID) ? $ins_link : ''),
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
            // $this->output
            //  ->set_content_type('application/json')
            //  ->set_output(json_encode($response));
        } 
        else 
        {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
            // $this->output
            //      ->set_content_type('application/json')
            //      ->set_output(json_encode($response));
        }
    }

    public function decodeBase64($encoded_string){
        $file_data= base64_decode($encoded_string);
        $file = finfo_open();
        $mime_type = finfo_buffer($file, $file_data, FILEINFO_MIME_TYPE);
        $file_type = explode('/', $mime_type)[0];
        $extension = explode('/', $mime_type)[1];
        log_message("error","No error occured".json_encode($mime_type));
        return $mime_type;
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
        } else if ($this->session->userdata('dist_code') == "38") {
            $this->db = $this->load->database('dha25', true);
        } else if ($this->session->userdata('dist_code') == "22") {
            $this->db = $this->load->database('dha41', true);
        }
    }


    public function initRegistration($review_flag = false){
        $this->db=$this->load->database('db2', TRUE);
        $lmdata['district_all'] = $this->db->query("Select * from district_details")->result();

        $this->dbswitch();

        $application_no = $this->input->get('app');

        $application_no = $this->utilityclass->decryptJwtCase($application_no);

        $geo_date_query = $this->db->query("Select date_entry from supportive_document where applid='$application_no'")->row();
        $geo_date = isset($geo_date_query->date_entry)? $geo_date_query->date_entry : '.....';

        // $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE applid = ? AND file_name = ? ", array($application_no, GEO_TAG_PHOTO) );
        $supportive_document_sql = $this->db->query("SELECT * FROM supportive_document WHERE id in (select max(id) from supportive_document where applid=? and dag_no is not null and file_name=? group by applid, dag_no)", array($application_no, GEO_TAG_PHOTO));

        if($supportive_document_sql->num_rows() > 0){
            $lmdata['geo_tag_doc'] = $supportive_document_sql->result();
        }else{
            $lmdata['geo_tag_doc_empty'] = "<span class='text-danger alert-danger'><b>Geo tag photo yet to be uploaded.</b></span>";
        }

        //********************case registration from API start ********* */
        //********************check and insert if case not registered */
        $recordExist=$this->SettlementApiModel->checkExistDharitree($application_no);

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
        //********************case registration from API end********* */
        //************************************************************************************** */
        ////******* case data fetch from db for Lm start */

        $startTime = microtime(true);
        try{
            $lmdata['review_flag'] = false;

            if($review_flag){
                $sql = $this->db->query('select * from settlement_basic where applid = ? and review_flag = ?', array($application_no, $review_flag));

                if($sql->num_rows() > 0){
                    $case_no = $sql->row()->case_no;
                }
                else{
                    $data = array(
                        'error' => 'Something went wrong! please contact administration!' .$application_no,
                    );
                    echo json_encode($data);
                    return false;
                }
                $lmdata['review_flag'] = true;

            }else{
                $sql = $this->db->query('SELECT dharitree FROM basundhar_application WHERE basundhara = ?', array($application_no));

                if($sql->num_rows() > 0){
                    $case_no = $sql->row()->dharitree;
                }
                else{
                    $data = array(
                        'error' => 'Something went wrong! please contact administration!' .$application_no,
                    );
                    echo json_encode($data);
                    return false;
                }
            }

            //*****LM view auth for this case */
            // $this->utilityclass->lmAuthBasic($case_no);
            // $this->utilityclass->lmAuthFirstProceeding($case_no);
            //  row_array
            $basic   = $this->SettlementInsModel->getSettlementBasic($case_no);
            //  result
            $applicants_buyers = $this->SettlementInsModel->getAllApplicantBuyers($case_no);
            $applicants_owners = $this->SettlementInsModel->getAllApplicantOwners($case_no);
            $applicants_encroacher = $this->SettlementInsModel->getAllApplicantEncroacher($case_no);
            $applicants_riotee_nok = $this->SettlementInsModel->getAllApplicantRioteeNok($case_no);

            $dags = $this->SettlementInsModel->getSettlementDag($case_no);
            if(empty($dags) || $dags == null)
            {
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
                $applicantss=$output->applicants;
                $ap_applied_area_b = $applicantss[0]->mbigha;
                $ap_applied_area_k = $applicantss[0]->mkatha;
                $ap_applied_area_lc = $applicantss[0]->mlessa;
                $ap_applied_area_gn = $applicantss[0]->mganda;
                $ap_applied_area_kr = $applicantss[0]->mkranti;
                $lmdata['ap_area'] = $ap_applied_area_b."B-".$ap_applied_area_k."K-".$ap_applied_area_lc."L";

            }
            else
            {
                $lmdata['ap_area'] = null;
            }

            


            $lmnotes = $this->SettlementInsModel->getSettlementTenantLmNote($case_no);
            $proceedings = $this->SettlementInsModel->getSettlementProceeding($case_no);
            $dhardocuments = $this->SettlementInsModel->getDocuments($case_no);
            $nominee = $this->SettlementInsModel->getAllNomineeDetail($case_no);

            /// premium
            $lmdata['s_area'] = $this->SettlementCommonModel->getPremiumArea();
            // new premium addition
            // $lmdata['area_category'] = $this->SettlementCommonModel->getPremiumCategory();


            $premiumData = $this->db->query("Select * from settlement_premium where case_no='$case_no' and is_final=1")->row();
            $lmdata['premiumData'] = $premiumData;
            /// premium end

            $lmdata['basic']=$basic;
            $lmdata['geo_date']=$geo_date;
            $lmdata['applicants_buyers']=$applicants_buyers;
            $lmdata['applicants_owners']=$applicants_owners;
            $lmdata['applicants_encroacher']=$applicants_encroacher;
            $lmdata['applicants_riotee_nok']=$applicants_riotee_nok;

            $lmdata['reservation'] = $this->SettlementVgrModel->getSettlementReservation($case_no);


            $lmdata['dags']=$dags;
            $lmdata['lmnotes']=$lmnotes;
            $lmdata['proceedings']=$proceedings;
            $lmdata['dhardocuments']=$dhardocuments;
            $lmdata['nominee']=$nominee;

            //for dag not eligible
            $lmdata['dag_count']=count($dags);

            //for encroacher not eligible
            // $lmdata['dag_count']=count($dags);

            $d=$basic["dist_code"];
            $s=$basic["subdiv_code"];
            $c=$basic["cir_code"];
            $m=$basic["mouza_pargona_code"];
            $l=$basic["lot_no"];
            $v=$basic["vill_townprt_code"];
            $lmdata['mouza_name'] = $this->utilityclass->getMouzaName($basic['dist_code'], 
                              $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code']);

            $lmdata['vill_name'] = $this->utilityclass->getVillageName($basic['dist_code'], 
                              $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], 
                                $basic['lot_no'], $basic['vill_townprt_code']);

            //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
            $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($case_no);
            $deletedEncArray = array();
            foreach($deletedEnc as $encroacherDeleted_data)
            {
                $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
            }
            $lmdata['deleted_encroacher'] = $deletedEncArray;

            //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
            $deletedDags=$this->SettlementCommonModel->getDeletedDags($case_no);
            $deletedData = array();
            foreach($deletedDags as $deleteDag){
                $deletedData[] = json_decode($deleteDag->table_data);
            }
            $lmdata['deleted_dags'] = $deletedData;


            if(isset($applicants_encroacher)):
                foreach($applicants_encroacher as $settl_vlb_add_check):
                    $sqlVlbEntryQuery = $this->db->query("SELECT * FROM settlement_land_bank_details WHERE application_no = ? AND dag_no = ? AND uuid = ?", array($application_no, $settl_vlb_add_check->dag_no, $lmdata['basic']['uuid']));

                    if($sqlVlbEntryQuery->num_rows() > 0){
                        $settlement_land_bank_details[] = $sqlVlbEntryQuery->row();

                        $vlb_encroacher_added_check[] = $sqlVlbEntryQuery->row()->dag_no;

                        $sql = $this->db->query("SELECT dag_no, status FROM land_bank_details WHERE id = ?", array($sqlVlbEntryQuery->row()->land_bank_details_id));

                        $land_bank_status[] =  $sql->row();

                    }else{
                        $settlement_land_bank_details[] = false;
                        $vlb_encroacher_added_check[] = false;
                        $land_bank_status[] = false;
                    }
                endforeach;
                if(isset($vlb_encroacher_added_check)):
                    if($vlb_encroacher_added_check):
                        $lmdata['settlement_vlb_encroacher_check'] = $vlb_encroacher_added_check;
                    endif;
                endif;
                if(isset($land_bank_status)):
                    $lmdata['land_bank_status'] = $land_bank_status;
                endif;
                if(isset($settlement_land_bank_details)):
                    $lmdata['settlement_land_bank_details'] = $settlement_land_bank_details;
                endif;
            endif;

            foreach($applicants_encroacher as $encroacher_prem){
                $revenue[] = $this->db->query("Select dag_revenue,dag_area_b,dag_area_k,dag_area_lc,dag_area_g,dag_area_kr,dag_no from  chitha_basic where dist_code='$d' and "
                    . "subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$m' and lot_no='$l' and vill_townprt_code='$v' and dag_no='$encroacher_prem->dag_no'")->result();
                $lmdata['revenue']=$revenue;

            }

            //   calling API for self declaration data

            $sql = "Select basundhara from basundhar_application where dharitree='$case_no' ";
            $basundhara = $this->db->query($sql)->row();
            $token = $this->utilityclass->createTokenJwt();
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."getAppDetails");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application_no' => $basundhara->basundhara,
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

            $lmdata['document']=$output->documents;
            $lmdata['query']=$output->query;
            $lmdata['property']=$output->property;
            $lmdata['aadhar']=$output->aadhar;
            $lmdata['nextKin']=$output->nextKin;
            $lmdata['selfDeclarationDetails'] = null;
            if(!empty($output->selfDeclaration))
            {
                foreach($output->selfDeclaration as $selfDec){
                    $lmdata['selfDeclarationDetails']=json_decode($selfDec->dec_details);
                }
            }
            

            foreach($lmdata['applicants_buyers'] as $adhar_photo):
                if($adhar_photo->is_applicant == 1):
                    if (trim($adhar_photo->identity_type) == 'AADHAAR'):
                        $adhar_photo_link = $adhar_photo->identity_doc_link;

                        if(!file_exists($adhar_photo_link))
                        {
                            $url = API_LINK_MB3."getApplicantPhoto";
                            $arrayData =array(
                                'application_no' => $application_no,
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
                        //**********reopening the updated file */
                        $open_adhar_file = fopen($adhar_photo_link, "r") or die("Unable to open file!");
                        $read_adhar_file = fread($open_adhar_file, filesize($adhar_photo_link));
                        fclose($open_adhar_file);
                        // decoding the base64 encoding file variable
                        $lmdata['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($read_adhar_file).";base64,".$read_adhar_file." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
                    endif;
                endif;
            endforeach;

            // for guardian relation
            $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";

            $relation_executation = $this->db->query($query_for_guar_rel);
            $row = $relation_executation->num_rows();

            if ($row != 0) {
                $lmdata['guar_rel'] = $relation_executation->result();
            }

            /// vlb data 
            $vlb_newly_added = array();
            if(isset($dags)){
                foreach($dags as $vlb_dag){
                    $sqlvlbcheck = $this->db->query("SELECT * FROM settlement_land_bank_details WHERE application_no = ? AND dag_no = ?", array($application_no, $vlb_dag->dag_no));

                    if($sqlvlbcheck->num_rows() > 0){
                        $vlb_newly_added[] = $sqlvlbcheck->row()->dag_no;
                    }
                    else{
                        $vlb_newly_added[] = false;
                    }
                }
                $lmdata['vlb_newly_added'] = $vlb_newly_added;
            }


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
                    $lmdata['total_aditional_area']= $this->utilityclass->Total_Bigha_Katha_Lessa($totallesaa);
                }
                if(!empty($totalganda)){
                    $lmdata['total_aditional_area_g']= $this->utilityclass->Total_Bigha_Katha_Lessa2($totalganda);
                }
                $lmdata['additional_property']=$additional_property->result();
                //var_dump($lmdata['additional_property']); die;
            }

            $lmdata['case_no'] = $case_no;

            $rejected_data = $this->SettlementCommonModel->getRejectModal(SLIJE_ID);
            if($rejected_data == 'n')
            {
                $lmdata['rejected_list'] = false;
            }
            else
            {
                $lmdata['rejected_list'] = $rejected_data;
            }

        }
        catch (Exception $e)
        {
            log_message('ERROR#LM_DATA_FETCH', 'Lm application data fetch...####'. $e);
        }
        finally
        {
            $endTime = microtime(true);
            $timeDiff = $endTime - $startTime;

            if($timeDiff > (float)2){
                log_message('EXECUTION_TIME', $this->router->fetch_class().'->'.$this->router->fetch_method().' # The execution time is : '.$timeDiff);
            }
        }

        //****getting tribe cat and under tribal belt data from backup */
        $getJsonBackup = $this->SettlementInsModel->getJsonDataFromBackup($case_no);
        if(isset($getJsonBackup))
        {
            if($getJsonBackup)
            {
                $json_settlement =  json_decode($getJsonBackup->data);

                foreach($json_settlement->settlements as $jsonSettle)
                {
                    if($jsonSettle->is_applicant == 1)
                    {
                        $lmdata['backup_tribe_category'] = $jsonSettle->tribe_category;
                        $lmdata['backup_under_tribe_belts'] = $jsonSettle->under_tribe_belts;
                    }
                }

            }
        }
        //************check if SK is available*/
        $lmdata['sk_name']= $this->SettlementCommonModel->getSkName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);

        if($lmdata['sk_name'] == 'n')
        {
            //************if SK is not available then load CO */
            $lmdata['sk_availability'] = 'n';

            $lmdata['co_name']= $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
        }
        else
        {
            $lmdata['sk_availability'] = 'y';
        }

        $lmdata['co_name']= $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
        $lmdata['co_name_reject']= $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
        $lmdata['dagFlagCheckChitha'] = $this->SettlementCommonModel->getChithaFlaggedRemarks($dags, $lmdata['rejected_list']);


        // initial khasland view through API
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            // SettlementInstitutionCoLanding
            $lmdata['_view'] = 'SettlementView/SettlementInstitutionCoLanding';
            $this->load->view('layouts/main', $lmdata);
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="error alert-danger">', '</div>');
            $this->form_validation->set_rules('co_remark', 'Co remark', 'trim|required');
            // $this->form_validation->set_rules('hearing_date_co', 'Hearing Date', 'trim'); 
            $this->form_validation->set_rules('application_type_state_central', 'Application Type', 'trim|required');
            $this->form_validation->set_rules('name_ins_co', 'Name of the institution', 'trim|required');              
            $this->form_validation->set_rules('name_ins_co_ass', 'Name of the institution(Assamese)', 'trim|required');
            $this->form_validation->set_rules('purpose_co', 'Land allotment Purpose', 'trim|required');

            if(in_array($this->input->post('application_type_state_central'),array(8,9,10,11)))
            {
                $this->form_validation->set_rules('dept_name_co', 'Name of the department(English)', 'trim|required');          
                $this->form_validation->set_rules('dept_name_ass_co', 'Name of the department(Assamese)', 'trim|required');
                $this->form_validation->set_rules('transferred_for_commercial_purposes_reclassification_govt', 'Is the  land applied for, is or will be used or  transferred for commercial purposes', 'trim|required');
            }
            if(in_array($this->input->post('application_type_state_central'),array(10,11)))
            {
                $this->form_validation->set_rules('ministry_department_name_change', 'Name of the ministry', 'trim|required');            
            }

            if(in_array($this->input->post('application_type_state_central'),array(9,11)))
            {
                $this->form_validation->set_rules('state_dept_undertaking_name', 'Name of the undertaking board', 'trim|required');            
            }
            if(in_array($this->input->post('application_type_state_central'),array(12)))
            {
                $this->form_validation->set_rules('religious_or_charitable_purposes_reclassification', 'Is the Land applied for used for religious or charitable', 'trim|required');
                $this->form_validation->set_rules('under_ngo_trust_localbodies_primary_info', 'Does the Institution fall under category of NGOs, Trusts, Local Bodies, Associations, Societies ?', 'trim|required');  
                if($this->input->post('under_ngo_trust_localbodies_primary_info') == 'YES')  
                {
                    
                    $this->form_validation->set_rules('under_charter_activities_primary_info', 'Is the charter of activities are such that the institution considered as educational,religious and socioculture institution?', 'trim|required');  
                }  
                             
            }

            if(in_array($this->input->post('application_type_state_central'),array(12)) && $this->input->post('purpose_co') == 'education')
            {
              
                $this->form_validation->set_rules('under_venture_school_primary_info', 'Is the educational institution is venture school ?', 'trim|required');  
                if($this->input->post('under_venture_school_primary_info') == 'NO') 
                {
                    $this->form_validation->set_rules('non_govt_profit_making_yes_no', 'Is the Non Govt. Educational Institution of public nature which is devoted to public purposes', 'trim|required'); 
                }
                           
            }


            if(in_array($this->input->post('application_type_state_central'),array(9)))
            {
                $this->form_validation->set_rules('state_warehousing_corporation', 'Is the Project/Infrastructure under State Government Undertakings/Statutory Bodies/Parastatals', 'trim|required');            
            }
            if(in_array($this->input->post('application_type_state_central'),array(10)))
            {
                $this->form_validation->set_rules('central_health_education_skill_sector', 'Is the Project/Infrastructure under Central Govt. Ministries/Departments related to Health,Education and Skill Development', 'trim|required');            
            }
            if(in_array($this->input->post('application_type_state_central'),array(11)))
            {
                $this->form_validation->set_rules('central_cwc_sector', 'Is the Project/Infrastructure under Central Govt. Undertakings/Statutory Bodies/Parastatals', 'trim|required');            
            }

            if ($this->form_validation->run() == false)
            {

                $lmdata['all_errors'] = validation_errors();
                if(isset($fileCount)){
                    $lmdata['fileCount'] = $fileCount;
                }
                $lmdata['err_return'] = true;
                $lmdata['_view'] = 'SettlementView/SettlementInstitutionCoLanding';
                $this->load->view('layouts/main',$lmdata);
            }
            else
            {
                $this->db->trans_begin();

                $category = $this->input->post('application_type_state_central');
                $name_ins_co = $this->input->post('name_ins_co');
                $name_ins_co_ass = $this->input->post('name_ins_co_ass');
                $dept_name_co = $this->input->post('dept_name_co');
                $dept_name_ass_co = $this->input->post('dept_name_ass_co');
                $directorate_name_change = $this->input->post('directorate_name_change');
                $ministry_department_name_change = $this->input->post('ministry_department_name_change');
                $state_dept_undertaking_name = $this->input->post('state_dept_undertaking_name');                
                $purpose_co = $this->input->post('purpose_co');
                $other_details_co = $this->input->post('other_details_co');
                $other_subtype_details_co = $this->input->post('other_subtype_details_co');
                $commercial_religious_purpose_non_govt = null;
                $commercial_religious_purpose_govt = null;
                if($category == 12)
                {
                    $commercial_religious_purpose_non_govt = $this->input->post('religious_or_charitable_purposes_reclassification');
                }
                else
                {
                    $commercial_religious_purpose_govt = $this->input->post('transferred_for_commercial_purposes_reclassification_govt');
                }
                $state_warehousing_corporation = null;
                $central_health_education_skill_sector = null;
                $central_cwc_sector = null;
                $non_govt_profit_making_yes_no = null;
                $underNgoTrust = null;
                $charterActivities = null;
                $under_venture_school_primary_info = null;
                $unrecognised_venture_primary_info = null;
                $govt_aided_venture_primary_info = null;

                if($category == 9)
                {
                    $state_warehousing_corporation = $this->input->post('state_warehousing_corporation');
                }
                if($category == 10)
                {
                    $central_health_education_skill_sector = $this->input->post('central_health_education_skill_sector');
                }
                if($category == 11)
                {
                    $central_cwc_sector = $this->input->post('central_cwc_sector');
                }
                if($category == 12)
                {
                    $non_govt_profit_making_yes_no = $this->input->post('non_govt_profit_making_yes_no');
                }

                if($category == 12)
                {
                    $non_govt_profit_making_yes_no = $this->input->post('non_govt_profit_making_yes_no');

                    if($purpose_co =='education')
                    {
                        $under_venture_school_primary_info = $this->input->post('under_venture_school_primary_info');
                        if($under_venture_school_primary_info == 'YES')
                        {
                            $unrecognised_venture_primary_info = $this->input->post('unrecognised_venture_primary_info');
                            $govt_aided_venture_primary_info = $this->input->post('govt_aided_venture_primary_info');
                            if($unrecognised_venture_primary_info == null && $govt_aided_venture_primary_info == null)
                            {
                                log_message('error', '#ERRORVAL0523200: Updation failed in settlement_basic RTPS Case No '.$application_no);
                                $data = array(
                                    'error'=>"#ERRORVAL0523200: Choose type of venture school...Registration of Settlement failed for case no : ".$application_no
                                );
                                echo json_encode($data);
                                return false;
                            }

                        }
                    }
                    
                    // Check if purpose is education, religious, or socioculture
                    if (in_array($purpose_co, ['education', 'religious', 'socioculture'])) {
                        $underNgoTrust = $this->input->post('under_ngo_trust_localbodies_primary_info');

                        if ($underNgoTrust === 'YES') {
                            $charterActivities = $this->input->post('under_charter_activities_primary_info');

                            if (empty($charterActivities)) {
                                $errorMessage = "#ERRORVAL052: Choose type of charter activity...Registration of Settlement failed for case no: {$application_no}";
                                log_message('error', $errorMessage);
                                echo json_encode(['error' => $errorMessage]);
                                return false;
                            }
                        }
                    }
                    
                }

                if($category==9 && $state_dept_undertaking_name == null)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRORVAL052: Updation failed in settlement_basic RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRORVAL052: Field Selection Missing...Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
                

                if($category==9 && ($state_warehousing_corporation==null || $state_warehousing_corporation==''))
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRORVAL052: Updation failed in settlement_basic RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRORVAL052: Field Selection Missing...Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }

                if($category==10 && ($central_health_education_skill_sector==null || $central_health_education_skill_sector==''))
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRORVAL0521: Updation failed in settlement_basic RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRORVAL0521: Field Selection Missing...Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
                if($category==11 && ($central_cwc_sector==null || $central_cwc_sector==''))
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRORVAL0523: Updation failed in settlement_basic RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRORVAL0523: Field Selection Missing...Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }

                if($category==12 && ($purpose_co == 'socioculture' || $purpose_co == 'religious') && $other_subtype_details_co == null)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRORVAL0524: Updation failed in settlement_basic RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRORVAL0524: Field Selection Missing...Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }  

                $insBasicDataCO = [
                    'ins_cat_type_co'=> $category,
                    'ins_name_co' => $name_ins_co,
                    'ins_name_assamese' => $name_ins_co_ass,
                    'ministry_of_co' => $ministry_department_name_change,
                    'dept_of_co' => $dept_name_co,
                    'dept_of_co_assamese' => $dept_name_ass_co,
                    'directorate_name' => $directorate_name_change,
                    'undertaking_board_co' => $state_dept_undertaking_name,
                    'purpose_land_allot_co' => $purpose_co,
                    'other_purpose_land_allot_co' => $other_details_co,
                    'other_subtype_details_co' => $other_subtype_details_co,
                    'state_warehousing_corporation' => $state_warehousing_corporation,
                    'central_health_education_skill_sector' => $central_health_education_skill_sector,
                    'central_cwc_sector' => $central_cwc_sector,
                    'non_govt_profit_making_yes_no' => $non_govt_profit_making_yes_no,
                    'commercial_purpose_non_govt' => $commercial_religious_purpose_non_govt,
                    'commercial_purpose_govt' => $commercial_religious_purpose_govt,
                    'under_venture_school' => $under_venture_school_primary_info,
                    'venture_type' => $unrecognised_venture_primary_info != null ? $unrecognised_venture_primary_info : $govt_aided_venture_primary_info,
                    'under_ngo_trust_localbodies' => $underNgoTrust,
                    'under_charter_activities'    => $charterActivities,


                ];

                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_institution_details', $insBasicDataCO);

                if($this->db->affected_rows() != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROR001648: Updation failed in settlement_basic RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERROR001648: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }
                
                $hearing_date = date('Y-m-d',strtotime($this->input->post('hearing_date_co')));
                $basicData = [
                    'status'          => 'W',
                    // 'lm_code'      => $this->session->userdata('user_code'),
                    'submission_date' => date('Y-m-d H:i:s'),
                    'from_office'     => 'CO',
                    'pending_officer' => 'LM',
                    'pending_office'  => 'CO',
                    'co_code'         => $this->session->userdata('user_code'),
                ];
                if($hearing_date != null)
                {
                    $basicData['ast_notice_hearing_date'] = $hearing_date;
                }

                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_basic', $basicData);
                if($this->db->affected_rows() != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERROR0011: Updation failed in settlement_basic RTPS Case No '.$application_no);
                    log_message('error', '#ERROR0011: Updation failed in settlement_basic RTPS Case No '.$this->db->last_query());
                    $data = array(
                        'error'=>"#ERROR0011: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }

                //////proceeding start//////
                $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

                if ($proceeding_id==null) {
                    $proceeding_id=1;
                }

                $insPetProceed = [
                    'case_no' => $case_no,
                    'proceeding_id' => $proceeding_id,
                    'date_of_hearing' => date('Y-m-d H:i:s'),
                    'next_date_of_hearing' => date('Y-m-d H:i:s'),
                    'note_on_order' => $this->input->post('co_remark'),
                    'status' => 'W',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d H:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'office_from' => 'CO',
                    'office_to' => 'LM',
                    'task' => 'CO First proceeding submitted'
                ];
                $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

                // echo $this->db->last_query(); die();
                if ($insertProceeding != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :'. $case_no);
                    $json = [
                        'errorMessage'=>"#ERRORPP: Failed to forward the case for Case No : ".$case_no
                    ];
                    echo json_encode($json);
                    return false;
                }
                //////proceeding end//////

                ////settlement Khas LM Report insert end

                if ($this->db->trans_status()==false) {
                    $this->db->trans_rollback();
                    $data=array(
                        'error'=>"Error in submitting. Please try Again"
                    );
                } else {
                    //////////////POST To basundhara/////////////////////
                    $rmk='Forwarded to LM';
                    $status='M';
                    $task='CO';
                    $pen='LM';
                    // $pen=$pending_officer;
                    $case=$case_no;
                    $rtps_status=$this->SettlementApiModel->postApiBasundharaMb3($application_no, $case, $rmk, $status, $task, $pen);
                    $rtps_status=json_decode($rtps_status);
                    if (trim($rtps_status)!="y") {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRAPI0011: Settlement Application not submitted case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    } else {
                        $this->db->trans_commit();
                    }

                    $this->session->set_flashdata('message', "Application Successfully Forwarded to LRA With Case No # ".$case_no);
                    redirect(base_url() . "index.php/home");
                }

            }
        }
    }


    function getInstitutionDetails(){
        $case_no = $this->input->post('case_no');
        $sql = $this->db->query('select sid.*,imc.category_name from settlement_institution_details sid join ins_master_category imc on sid.ins_cat_type::int = imc.id  where case_no = ?', array($case_no));

        if($sql->num_rows() <= 0){
            $data['ins_data'] = null;
        }else{
            $data['ins_data'] = $sql->result();
        }

        $this->load->view('SettlementView/include/institution_details', $data);

    }

    public function getProjectDetails()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $result = $this->db->query("SELECT * FROM ins_master_category WHERE type=?",
                array($_POST['checkVal']));
        $json = [
            'result' => $result->result(),
        ];
        echo json_encode($json);
        return;
    }

    public function SecondProcess()
    {
        $service_code = $this->input->get('service');

        $status = $this->input->get('s');
        $data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);

        // $data['getFirstProceeding'] = $this->SettlementMbModel->getSettlementCoFirstPending($service_code);

        if(trim($status) == 'W')
        {
            $data['_view'] = 'settlement_mb/second_proceeding_co_bulk_ins';
        }
        else
        {
            $data['_view'] = 'settlement_mb/first_proceeding_co';
        }

        $this->load->view('layouts/main', $data);
    }

    public function paginationCoSecondBulk()
    {

        if(LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO'){
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

        if(!empty($remark_cat))
        {  //settlement_ap_lmnote, lm_note
            $this->db->where('b.lm_note', $remark_cat);
        }

        if(!empty($mouza_pargona_code))
        {
            $this->db->where('a.mouza_pargona_code', $mouza_pargona_code);
        }

        if(!empty($mouza_pargona_code) && !empty($lot_no))
        {
            $this->db->where('a.lot_no', $lot_no);
        }

        if($review_cat == '1')
        {
            $this->db->where('a.old_case_no is null');
            $review_stat = 'Normal Case';
        }else{
            $this->db->where('a.old_case_no is not null');
            $review_stat = 'Review Case';
        }

        if (!empty($lot_no) && !empty($mouza_pargona_code) && !empty($is_cat)) {
            $this->db->where('a.vill_townprt_code', $is_cat);
        }

        if (trim($reverted) == 'LM'){
            $this->db->where('a.pending_officer', MB_LOT_MONDOL);

        }
        else if (trim($reverted) == 'ADC'){
            $this->db->where_not_in('a.pending_officer',array(MB_LOT_MONDOL,MB_SUPERVISOR_KANANGU,MB_CIRCLE_OFFICER));
        }
        else{
            $this->db->where_in('a.pending_officer', array(MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU));
        }
        if ($this->session->userdata('user_desig_code') == 'CO'){
            if(LOT_BIFURCATE ==1 && empty($mouza_pargona_code) && empty($lot_no)){
                if(isset($lot_string) && $lot_string != null)
                {
                    $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                }
            }
        }
        if ($this->session->userdata('user_desig_code') == 'SK') {
            $this->db->where('b.lm_note', '1');
            $this->db->where('a.from_office', 'LM');
        }

        if(trim($reverted) == 'LM' and $status =='V'){
            $this->db->select("distinct(a.case_no),a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, a.chitha_processing_details");
            $this->db->select('(select \'0\') as lm_note');
        }else{
            $this->db->select('distinct(a.case_no), a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note, a.chitha_processing_details');
        }

        if (trim($reverted) != 'ADC'){
            $this->db->where('a.status', $status);
        }
        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

        // $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
        if(trim($reverted) == 'LM' and $status =='V'){
            $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no', 'left');
        }else{
            $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
        }

        if($s_code == 14 && ($status !='R' && $status !='X' && $status !='M' && $status !='N' && $status !='D'))
        {
            if (trim($reverted) != 'ADC'){
                if (($this->session->userdata('user_desig_code') == 'SK' and $status =='W') || trim($reverted) == 'LM' and $status =='V')
                {

                }
                else
                {
                    $this->db->where('a.notice_generated_yn', NULL);
                }
            }
        }

        $this->db->from('settlement_basic a');
        $query = $this->db->get();
        log_message('error','sssssssssssss'.$this->db->last_query());

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {

                if(trim($rows->lm_note) == 1)
                {
                    $lmnoteRemark = 'Recommended';
                }
                else
                {
                    $lmnoteRemark = 'Not Recommended';
                }

                
                $ins_second_link = '<a type="button" href="' . base_url() . 'index.php/SettlementInstitutionCo/settlementInsCo?case=' . enc_param('case', $rows->case_no, 600) . '" class="lmreportmut btn-sm btn btn-primary">
                    write report</a>';


                $json[] = array(
                    $rows->case_no,
                    '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                    '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                    $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                    $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                    $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                    date("Y-m-d", strtotime($rows->date_entry)),

                    $lmnoteRemark,

                    $review_stat,

                    $ins_second_link,
                );

            }

            $this->db->where('a.service_code', $s_code);

            if(!empty($remark_cat))
            {
                $this->db->where('b.lm_note', $remark_cat);
            }

            if (trim($reverted) == 'LM'){
                $this->db->where('a.pending_officer', MB_LOT_MONDOL);

            }
            else if (trim($reverted) == 'ADC'){
                $this->db->where_not_in('a.pending_officer',array(MB_LOT_MONDOL,MB_SUPERVISOR_KANANGU,MB_CIRCLE_OFFICER));
            }
            else{
                $this->db->where_in('a.pending_officer', array(MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU));
            }

            if ($this->session->userdata('user_desig_code') == 'CO'){
                // $this->db->where('a.co_code', $user_code);
                // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
                if(LOT_BIFURCATE ==1 && empty($mouza_pargona_code) && empty($lot_no)){

                    if(isset($lot_string) && $lot_string != null)
                    {
                        $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                    }
                }
            }

            if ($this->session->userdata('user_desig_code') == 'SK') {
                $this->db->where('b.lm_note', '1');
                $this->db->where('a.from_office', 'LM');
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

            if(trim($reverted) == 'LM' and $status =='V'){
                $this->db->select('a.case_no, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry');
                $this->db->select('(select \'0\') as lm_note');
            }else{
                $this->db->select('a.case_no, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note');
            }

            if (trim($reverted) != 'ADC'){
                $this->db->where('a.status', $status);
            }
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

            if(trim($reverted) == 'LM' and $status =='V'){
                $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no', 'left');
            }else{
                $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
            }

            if($s_code == 14 && ($status !='R' && $status !='X' && $status !='M' && $status !='N' && $status !='D'))
            {
                if (trim($reverted) != 'ADC'){
                    if (($this->session->userdata('user_desig_code') == 'SK' and $status =='W') || trim($reverted) == 'LM' and $status =='V') {

                    }

                    else{
                        $this->db->where('a.notice_generated_yn', NULL);
                    }
                }
            }

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


        // Settlement Khas CO view starts here -md-
    public function settlementInsCo()
    {
        $_GET['case'] = dec_param($this->input->get('case'), 'case');
        if($_GET['case'] == null)
        {
            echo json_encode('Sorry !! You are not Authorized to access the content!!');
            return;
        }
        $application_no  = $this->input->get('case');
        $user_desig_code = $this->session->userdata('user_desig_code');
      
        if($user_desig_code == 'SK')
        {
            $this->utilityclass->authCheckCoSk($application_no, 'SK');
            $this->utilityclass->checkUserAuthForCaseForSk($application_no);
        }
        else if ($user_desig_code == 'CO')
        {
            $this->utilityclass->authCheckCoSk($application_no, 'CO');
            $this->utilityclass->checkUserAuthForCaseForCo($application_no);
        }
        else
        {
            $this->session->set_flashdata('message', "#ERR290: error occured! Contact admin...");
            redirect(base_url() . "index.php/home");
            return false;
        }

        $basic = $this->SettlementInsModel->getSettlementBasic($application_no);
        $applicants_buyers = $this->SettlementInsModel->getAllApplicantBuyers($application_no);
        $applicants_owners = $this->SettlementInsModel->getAllApplicantOwners($application_no);
        $applicants_encroacher = $this->SettlementInsModel->getAllApplicantEncroacher($application_no);
        $lmdata = [];
        $dags = $this->SettlementInsModel->getSettlementDag($application_no);
        $lmnotes = $this->SettlementInsModel->getSettlementTenantLmNote($application_no);
        $proceedings = $this->SettlementInsModel->getSettlementProceeding($application_no);
        $dhardocuments = $this->SettlementInsModel->getDocuments($application_no);
        $nominee = $this->SettlementInsModel->getAllNomineeDetail($application_no);

        $lmdata['basic'] = $basic;
        $lmdata['nominee'] = $nominee;
        $lmdata['applicants_buyers'] = $applicants_buyers;
        $lmdata['applicants_owners'] = $applicants_owners;
        $lmdata['applicants_encroacher'] = $applicants_encroacher;

        $lmdata['checkAdditionalProperty'] = $this->SettlementCommonModel->activeAdditionalPropertyDetailByCase($application_no)->result();

        // if (isset($applicants_buyers)) {
        //     if ($applicants_buyers) {
        //         foreach ($applicants_buyers as $adhar_photo) {
        //             if ($adhar_photo->is_applicant == 1) {
        //                 if (trim($adhar_photo->identity_type) == 'AADHAAR') {
        //                     $adhar_photo_link = $adhar_photo->identity_doc_link;

        //                     $open_adhar_file = fopen($adhar_photo_link, "r") or die("Unable to open file!");
        //                     $read_adhar_file = fread($open_adhar_file, filesize($adhar_photo_link));
        //                     fclose($open_adhar_file);
        //                     // decoding the base64 encoding file variable

        //                     $lmdata['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($read_adhar_file).";base64,".$read_adhar_file." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
        //                 }
        //             }
        //         }
        //     }
        // }

        $applid = $this->utilityclass->getApplidFromCaseNo($application_no);

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
        $getJsonBackup = $this->SettlementInsModel->getJsonDataFromBackup($application_no);
        if(isset($getJsonBackup))
        {
            if($getJsonBackup)
            {
                $json_settlement =  json_decode($getJsonBackup->data);

                foreach($json_settlement->settlements as $jsonSettle)
                {
                    if($jsonSettle->is_applicant == 1)
                    {
                        $lmdata['backup_tribe_category'] = $jsonSettle->tribe_category;
                        $lmdata['backup_under_tribe_belts'] = $jsonSettle->under_tribe_belts;
                    }
                }

            }
        }

        $lmdata['dags'] = $dags;
        $lmdata['lmnotes'] = $lmnotes;
        $lmdata['proceedings'] = $proceedings;
        $lmdata['dhardocuments'] = $dhardocuments;
        // $premium_data = $this->db->query("SELECT sp.*,spa.area,spl.land_type,spr.house_type,spr.rate_type as ratetype FROM settlement_premium sp inner join settlement_premium_area spa on spa.paid=sp.area_name inner join settlement_premium_land_type spl on spl.plid=sp.land_type inner join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no='$application_no' and is_final=1")->result();

        $premium_data = $this->db->query("SELECT sp.* FROM settlement_premium sp where case_no='$application_no' and is_final=1")->result();


        $lmdata['premium_data'] = $premium_data;

        // $sql = "Select basundhara from basundhar_application where dharitree='$application_no' ";
        // $basundhara = $this->db->query($sql)->row();
        // $token = $this->utilityclass->createTokenJwt();
        // $curl_handle = curl_init();
        // curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2."getAppDetails");
        // curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        // curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        // curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
        //     'application_no' => $basundhara->basundhara,
        //     'api_key' => API_KEY,
        //     'token' => $token
        // )));
        // $output = curl_exec($curl_handle);
        // if(isset(json_decode($output)->responseType)){
        //     if(json_decode($output)->responseType == 3){
        //         echo json_decode($output)->data." - Unauthorized access!";
        //         return false;
        //     }
        // }
        // curl_close($curl_handle);
        // $output = json_decode($output);
        // $lmdata['document']=$output->documents;
        // $lmdata['query']=$output->query;
        // $lmdata['property']=$output->property;
        // $lmdata['aadhar']=$output->aadhar;
        // $lmdata['nextKin']=$output->nextKin;
        // foreach($output->selfDeclaration as $selfDec){
        //     $lmdata['selfDeclarationDetails']=json_decode($selfDec->dec_details);
        // }
        $lmdata['premium'] = $this->SettlementCommonModel->getPremium($application_no);
        $lmdata['reservation'] = $this->SettlementVgrModel->getSettlementReservation($application_no);
        $lmdata['additional_property'] = $this->SettlementInsModel->getAdditionalProperty($application_no);

        foreach($lmdata['applicants_encroacher'] as $applicant_enc){
            $enc_check = $this->db->query("SELECT * FROM settlement_land_bank_details WHERE application_no =? AND dag_no =?", array($this->utilityclass->getApplidFromCaseNo($application_no), $applicant_enc->dag_no));

            if($enc_check->num_rows() > 0){
                $added_enc_data[] = $enc_check->row();
            }
        }
        if(isset($added_enc_data)){
            $lmdata['new_added_enc_data'] = $added_enc_data;
        }

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

        $checkAreaDetails = $this->chithaAreaCheckWithCaseNo($application_no);

        $lmdata['chithaArea']   = $checkAreaDetails['chithaArea'];
        $lmdata['reservedArea'] = $checkAreaDetails['reservedArea'];
        $lmdata['areaCheck']    = $checkAreaDetails['areaCheck'];
        $lmdata['appliedDags']  = $checkAreaDetails['appliedDags'];
        $lmdata['lmProcessArea']= $checkAreaDetails['lmProcessArea'];

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

        $rejected_data = $this->SettlementCommonModel->getRejectModal(SLIJE_ID);
        if($rejected_data == 'n')
        {
            $lmdata['rejected_list'] = false;
        }
        else
        {
            $lmdata['rejected_list'] = $rejected_data;
        }


        foreach(json_decode(VALIDATION_BYPASS) as $val_bypas)
        {
            if($val_bypas->SERVICE_CODE == SLIJE_ID)
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
                        $lmdata['reject_list_type'] = 'new';
                    }
                    else
                    {
                        $lmdata['reject_list_type'] = 'old';
                    }
                }
            }
        }
        $sql = $this->db->query('select sid.*,imc.category_name from settlement_institution_details sid join ins_master_category imc on sid.ins_cat_type::int = imc.id  where case_no = ?', array($application_no));

        $lmdata['ins_data'] = $sql->result();
        $lmdata['instituteDetails'] = $this->SettlementInsModel->getInstitutionDetails($application_no);
        $lmdata['land_class_groups'] = $this->SettlementInsModel->getLandGroups();

        //listed ADC///////////
        $lmdata['adcUsers'] = $this->UtilsModel->adcSelect($basic['dist_code']);
        ///END///////////////

        $lmdata['_view'] = 'SettlementView/Co/Ins/SettlementInsCoView';
        $this->load->view('layouts/main', $lmdata);
    }

    // New area check By Masud Reza
    public function chithaAreaCheckWithCaseNo($application_no)
    {

        $dags = $this->SettlementApModel->getSettlementDag($application_no);

        $totalAreaInChitha[] = 0;
        $appAreaInApplication = 0;
        $areaCheck = 0;
        $chithaDagArray = [];
        $lmProcessArea = [];
        $allApplicationDagArray = [];
        $appliedDags = $this->SettlementCommonDcModel->getAppliedSettlementDag($application_no);
        $basic = $this->SettlementCommonDcModel->getSettlementBasicData($application_no);

        foreach ($dags as $dag)
        {
            $totalAreaInApplication = 0;
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

            //  all lm processing application but  SDO/ADC/DC not proceeded
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

                // processing application
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

                // processing application
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

            $lmProcessArea[]          = $allLmProcess;
            $chithaDagArray[]         = $chithaDag;
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
    function handleMissingFieldError($applicationNo) {
        $errorMessage = "#ERRORVAL052: Field Selection Missing...Registration of Settlement failed for case no: {$applicationNo}";
        log_message('error', "#ERRORVAL052: Updation failed in settlement_basic RTPS Case No {$applicationNo}");
        echo json_encode(['error' => $errorMessage]);
        return false;
    }

    public function generateNoticeCo()
    {
        // generate notice starts here
        if (isset($_POST['generate_notice'])) {
            // var_dump("m here"); die();
            $hearing_date = $this->input->post('hearing_date');
            $case_no = $this->input->post('case_no');
            $remark_co = $this->input->post('remark_co');
            $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
            $get_dag_details = $this->SettlementApModel->getSettlementDagDetails($case_no);
            $get_settlement_applicant = $this->SettlementApModel->getAllApplicant($case_no);

            $data = [
                'hearing_date' => $hearing_date,
                'case_no' => $case_no,
                'remark_co' => $remark_co,
                'get_settlement_basic' => $get_settlement_basic,
                'get_dag_details' => $get_dag_details,
                'get_settlement_applicant' => $get_settlement_applicant,

            ];

            $this->load->view('SettlementView/Co/Tenant/SettlementNotice', $data);
        }
        // to print notice
        if (isset($_POST['print_notice'])) {
            $case_no = $this->input->post('case_no');
            // getting the notice file link
            $data['print_data'] = $this->SettlementApModel->getSettlementBasic($case_no);

            $path = $this->SettlementCommonModel->downloadNotice($data['print_data']['co_app_notice_link']);
            if($path == false){
                echo 'No data found!';
                return;
            }

            // reading the base64 json file and saving it to a variable
            $open_notice_file = fopen($path, "r") or die("Unable to open file!");
            $read_notice_file = fread($open_notice_file, filesize($path));
            fclose($open_notice_file);
            // decoding the base64 encoding file variable
            $base64decoded_notice_file = base64_decode(json_decode($read_notice_file));
            $data = [
                'base64_decoded_notice_file' => $base64decoded_notice_file,
            ];
            $data['_view'] = 'SettlementView/Co/Tenant/PrintNotice';
            $this->load->view('layouts/main', $data);

        }

        //******disagree and revert to LM */
        if(isset($_POST['co_rejection_disagree']))
        {
            if($_POST['co_rejection_disagree'] == 'co_rejection_disagree')
            {
                $case_no = $this->input->post('case_no');
                $remark_co = 'Re-verify this case';
                $remark_co_type = '3';
    
                $this->db->trans_begin();
    
                $updateArr = [
                    'status' => 'R',
                    'co_code' => $this->session->userdata('user_code'),
                    'date_update' => date('Y-m-d h:i:s'),
                    'from_office' => 'CO',
                    'pending_officer' => 'LM',
                    'pending_office' => 'CO',
    
                ];
                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_basic', $updateArr);
    
                if ($this->db->affected_rows() == 0) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO0001: Falied to revert back to LM');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCO0001: Falied to revert back to LM. Kindly contact system administrator',
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
                    'note_type' => $remark_co_type,
                    'note_on_order' => $remark_co,
                    'status' => 'W',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'office_from' => 'CO',
                    'office_to' => 'LM',
                    'task' => 'Reverted Back to LM',
                ];
                $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
                if ($insertProc != 1) 
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO0002: Insertion failed in settlement_proceeding');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCO0002: Failed to generate notice. Kindly contact System Administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }
                if ($this->db->trans_status() == false) 
                {
                    $this->db->trans_rollback();
                    $data = array(
                        'error' => "Error in submitting. Please try Again",
                    );
                    return $data;
                    exit;
                } 
                else 
                {
                    //////////////POST To basundhara////////////////////
                    $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
    
                    $rmk='Reverted to LM';
                    $status='M';
                    $task='CO';
                    $pen='LM';
                    $case=$case_no;
                    $rtps_status=$this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
                    $rtps_status=json_decode($rtps_status);
                    //var_dump($rtps_status);
                    if(trim($rtps_status) != "y")
                    {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRAPP003211: Revert to LM failed case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    }
                    else
                    {
                        $this->db->trans_commit();
                        $this->session->set_flashdata('message', "Case no # $case_no reverted back to LM");
                        redirect(base_url() . "index.php/home");
                        // redirect(base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $case_no);
                    }
                }
            }
        }

        // Revert back to LM stats here
        if (isset($_POST['revert_to_lm'])) {
            $case_no   = $this->input->post('case_no');
            $remark_co = $this->input->post('remark_co');
            $remark_co_type = $this->input->post('remark_co_type');
            $district  = $this->input->post('district');
            $sub_division = $this->input->post('sub_division');
            $circle    = $this->input->post('circle');
            $lot_no    = $this->input->post('lot_no');
            $mouza     = $this->input->post('mouza');
            $village   = $this->input->post('village');
            $petitioner_name = $this->input->post('petitioner_name');
            $g_name    = $this->input->post('g_name');
            $dag_name  = $this->input->post('dag_name');

            $checkValLRA = $this->input->post('change_primary_yes_no');
            if($checkValLRA == 'YES')
            {
                $validations = $this->validateCoSecProc();
                if($validations)
                {
                    log_message('error', '#ERRORVAL052: Validation Error'.json_encode($validations));
                    $data = array(
                        // 'error'=>"#ERRORVAL052: Some Entry Field Missing...Revert to LRA failed for case no : ".$case_no,
                        'msg' => json_encode($validations)
                    );
                    echo json_encode($data);
                    return false;
                }
                $category = $this->input->post('application_type_state_central');
                $name_ins_co = $this->input->post('name_ins_co');
                $name_ins_co_ass = $this->input->post('name_ins_co_ass');
                $dept_name_co = $this->input->post('dept_name_co');
                $dept_name_ass_co = $this->input->post('dept_name_ass_co');
                $directorate_name_change = $this->input->post('directorate_name_change');
                $ministry_department_name_change = $this->input->post('ministry_department_name_change');
                $state_dept_undertaking_name = $this->input->post('state_dept_undertaking_name');
                $state_warehousing_corporation = $this->input->post('state_warehousing_corporation');
                $central_health_education_skill_sector = $this->input->post('central_health_education_skill_sector');
                $central_cwc_sector = $this->input->post('central_cwc_sector');
                $non_govt_profit_making_yes_no = $this->input->post('non_govt_profit_making_yes_no');
                $purpose_co = $this->input->post('purpose_co');
                $other_details_co = $this->input->post('other_details_co');
                $other_subtype_details_co = $this->input->post('other_subtype_details_co');




                $commercial_religious_purpose_non_govt = null;
                $commercial_religious_purpose_govt = null;
                if($category == 12)
                {
                    $commercial_religious_purpose_non_govt = $this->input->post('religious_or_charitable_purposes_reclassification');
                }
                else
                {
                    $commercial_religious_purpose_govt = $this->input->post('transferred_for_commercial_purposes_reclassification_govt');
                }
                $state_warehousing_corporation = null;
                $central_health_education_skill_sector = null;
                $central_cwc_sector = null;
                $non_govt_profit_making_yes_no = null;
                $under_venture_school_primary_info = null;
                $underNgoTrust = null;
                $charterActivities = null;

                if($category == 9)
                {
                    $state_warehousing_corporation = $this->input->post('state_warehousing_corporation');
                }
                if($category == 10)
                {
                    $central_health_education_skill_sector = $this->input->post('central_health_education_skill_sector');
                }
                if($category == 11)
                {
                    $central_cwc_sector = $this->input->post('central_cwc_sector');
                }
                if($category == 12)
                {
                    $non_govt_profit_making_yes_no = $this->input->post('non_govt_profit_making_yes_no');

                    if($purpose_co =='education')
                    {
                        $under_venture_school_primary_info = $this->input->post('under_venture_school_primary_info');
                        if($under_venture_school_primary_info == 'YES')
                        {
                            $unrecognised_venture_primary_info = $this->input->post('unrecognised_venture_primary_info');
                            $govt_aided_venture_primary_info = $this->input->post('govt_aided_venture_primary_info');
                            if($unrecognised_venture_primary_info == null && $govt_aided_venture_primary_info == null)
                            {
                                log_message('error', '#ERRORVAL0523200: Updation failed in settlement_basic RTPS Case No '.$application_no);
                                $data = array(
                                    'error'=>"#ERRORVAL0523200: Choose type of venture school...Registration of Settlement failed for case no : ".$application_no
                                );
                                echo json_encode($data);
                                return false;
                            }

                        }
                    }
                    
                    // Check if purpose is education, religious, or socioculture
                    if (in_array($purpose_co, ['education', 'religious', 'socioculture'])) {
                        $underNgoTrust = $this->input->post('under_ngo_trust_localbodies_primary_info');

                        if ($underNgoTrust === 'YES') {
                            $charterActivities = $this->input->post('under_charter_activities_primary_info');

                            if (empty($charterActivities)) {
                                $errorMessage = "#ERRORVAL052: Choose type of charter activity...Registration of Settlement failed for case no: {$application_no}";
                                log_message('error', $errorMessage);
                                echo json_encode(['error' => $errorMessage]);
                                return false;
                            }
                        }
                    }
                    
                }

                // if($category==9 && $state_dept_undertaking_name == null && ($state_warehousing_corporation==null || $state_warehousing_corporation==''))
                // {
                    
                //     log_message('error', '#ERRORVAL052: Updation failed in settlement_basic RTPS Case No '.$application_no);
                //     $data = array(
                //         'error'=>"#ERRORVAL052: Field Selection Missing...Registration of Settlement failed for case no : ".$application_no
                //     );
                //     echo json_encode($data);
                //     return false;
                // }

                // if($category==10 && $ministry_department_name_change==null  && ($central_health_education_skill_sector==null || $central_health_education_skill_sector==''))
                // {
                    
                //     log_message('error', '#ERRORVAL052: Updation failed in settlement_basic RTPS Case No '.$application_no);
                //     $data = array(
                //         'error'=>"#ERRORVAL052: Field Selection Missing...Registration of Settlement failed for case no : ".$application_no
                //     );
                //     echo json_encode($data);
                //     return false;
                // }
                // if($category==11 && $state_dept_undertaking_name == null  && ($central_cwc_sector==null || $central_cwc_sector==''))
                // {
                    
                //     log_message('error', '#ERRORVAL052: Updation failed in settlement_basic RTPS Case No '.$application_no);
                //     $data = array(
                //         'error'=>"#ERRORVAL052: Field Selection Missing...Registration of Settlement failed for case no : ".$application_no
                //     );
                //     echo json_encode($data);
                //     return false;
                // }
                // if($category==12 && ($purpose_co =='religious' || $purpose_co == 'socioculture') &&  $other_subtype_details_co == null && ($non_govt_profit_making_yes_no==null || $non_govt_profit_making_yes_no==''))
                // {
                    
                //     log_message('error', '#ERRORVAL052: Updation failed in settlement_basic RTPS Case No '.$application_no);
                //     $data = array(
                //         'error'=>"#ERRORVAL052: Field Selection Missing...Registration of Settlement failed for case no : ".$application_no
                //     );
                //     echo json_encode($data);
                //     return false;
                // }


                // Validation based on category
                if ($category == 9 && empty($state_dept_undertaking_name) && empty($state_warehousing_corporation)) {
                    return handleMissingFieldError($application_no);
                }

                if ($category == 10 && empty($ministry_department_name_change) && empty($central_health_education_skill_sector)) {
                    return handleMissingFieldError($application_no);
                }

                if ($category == 11 && empty($state_dept_undertaking_name) && empty($central_cwc_sector)) {
                    return handleMissingFieldError($application_no);
                }

                if ($category == 12 && in_array($purpose_co, ['religious', 'socioculture']) && empty($other_subtype_details_co) && empty($non_govt_profit_making_yes_no)) 
                {
                    return handleMissingFieldError($application_no);
                }

            }
        

            $this->db->trans_begin();

            if($checkValLRA == 'YES')
            {

                $sql = $this->db->query('select * from settlement_institution_details where case_no = ?', array($case_no));
                if($sql->num_rows() <= 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCOPRIMARY3226: Insertion failed in settlement_institution_details_co_history RTPS Case No '.$case_no);
                    $data = array(
                        'error'=>"#ERRCOPRIMARY3226: Registration of Settlement failed for case no : ".$case_no
                    );
                    echo json_encode($data);
                    return false;
                }
                else
                {
                    $insCoData = $sql->row();
                }


                $historyDataCoPrimaryInfo = [
                    'case_no' => $insCoData->case_no,
                    'ins_name_co' => $insCoData->ins_name_co,
                    'ins_cat_type_co' => $insCoData->ins_cat_type_co,
                    'purpose_land_allot_co' => $insCoData->purpose_land_allot_co,
                    'other_purpose_land_allot_co' => $insCoData->other_purpose_land_allot_co,
                    'ins_name_assamese' => $insCoData->ins_name_assamese,
                    'state_warehousing_corporation' => $insCoData->state_warehousing_corporation,
                    'central_health_education_skill_sector' => $insCoData->central_health_education_skill_sector,
                    'central_cwc_sector' => $insCoData->central_cwc_sector,
                    'non_govt_profit_making_yes_no' => $insCoData->non_govt_profit_making_yes_no,
                    'directorate_name' => $insCoData->directorate_name,
                    'other_subtype_details_co' => $insCoData->other_subtype_details_co,
                    'lm_request_change_yes_no_lm' => $insCoData->lm_request_change_yes_no_lm,
                    'lm_request_change_on_co_remark_lm' => $insCoData->lm_request_change_on_co_remark_lm,
                    'ministry_of_co' => $insCoData->ministry_of_co,
                    'dept_of_co' => $insCoData->dept_of_co,
                    'dept_of_co_assamese' => $insCoData->dept_of_co_assamese,
                    'undertaking_board_co' => $insCoData->undertaking_board_co,
                    'co_change_on_lm_recomd' => $insCoData->co_change_on_lm_recomd,
                    'commercial_purpose_non_govt' => $insCoData->commercial_purpose_non_govt,
                    'commercial_purpose_govt' => $insCoData->commercial_purpose_govt,
                    'under_ngo_trust_localbodies' => $insCoData->under_ngo_trust_localbodies,
                    'under_venture_school'        => $insCoData->under_venture_school,
                    'under_charter_activities'    => $insCoData->under_charter_activities,
                    'venture_type'                => $insCoData->venture_type,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                $this->db->insert('settlement_institution_details_co_history', $historyDataCoPrimaryInfo);

                if($this->db->affected_rows() != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRUPCOP3107154: Insertion failed in settlement_institution_details_co_history RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRUPCOP3107154: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
                    return false;
                }

                $insBasicDataCO = [
                    'ins_cat_type_co'=> $category,
                    'ins_name_co' => $name_ins_co,
                    'ins_name_assamese' => $name_ins_co_ass,
                    'ministry_of_co' => $ministry_department_name_change,
                    'dept_of_co' => $dept_name_co,
                    'dept_of_co_assamese' => $dept_name_ass_co,
                    'directorate_name' => $directorate_name_change,
                    'undertaking_board_co' => $state_dept_undertaking_name,
                    'purpose_land_allot_co' => $purpose_co,
                    'other_purpose_land_allot_co' => $other_details_co,
                    'other_subtype_details_co' => $other_subtype_details_co,
                    'state_warehousing_corporation' => $state_warehousing_corporation,
                    'central_health_education_skill_sector' => $central_health_education_skill_sector,
                    'central_cwc_sector' => $central_cwc_sector,
                    'non_govt_profit_making_yes_no' => $non_govt_profit_making_yes_no,
                    'co_change_on_lm_recomd' => 'Y',
                    'commercial_purpose_non_govt' => $commercial_religious_purpose_non_govt,
                    'commercial_purpose_govt' => $commercial_religious_purpose_govt,
                    'under_venture_school' => $under_venture_school_primary_info,
                    'venture_type' => $unrecognised_venture_primary_info != null ? $unrecognised_venture_primary_info : $govt_aided_venture_primary_info,
                    'under_ngo_trust_localbodies' => $underNgoTrust,
                    'under_charter_activities'    => $charterActivities,
                ];

                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_institution_details', $insBasicDataCO);

                if($this->db->affected_rows() != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRUPCOP3107: Updation failed in settlement_basic RTPS Case No '.$application_no);
                    $data = array(
                        'error'=>"#ERRUPCOP3107: Registration of Settlement failed for case no : ".$application_no
                    );
                    echo json_encode($data);
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
                    'note_type' => $remark_co_type,
                    'note_on_order' => "CO primary information changed by CO",
                    'status' => 'W',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'office_from' => 'CO',
                    'office_to' => 'LM',
                    'task' => 'Reverted Back to LRA',
                ];
                $insertProcCO = $this->db->insert('settlement_proceeding', $insertArr);
                if ($insertProcCO != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO2931: Insertion failed in settlement_proceeding');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCO2931: Something went wrong. Kindly contact System Administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }
            }

            $updateArr = [
                'status' => 'R',
                'co_code' => $this->session->userdata('user_code'),
                'date_update' => date('Y-m-d h:i:s'),
                'from_office' => 'CO',
                'pending_officer' => 'LM',
                'pending_office' => 'CO',

            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $updateArr);

            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCO2897: Falied to revert back to LM');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO2897: Falied to revert back to LRA. Kindly contact system administrator',
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
                'note_type' => $remark_co_type,
                'note_on_order' => $remark_co,
                'status' => 'W',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => 'LM',
                'task' => 'Reverted Back to LRA',
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if ($insertProc != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCO2931: Insertion failed in settlement_proceeding');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO2931: Something went wrong. Kindly contact System Administrator',
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

                //////////////POST To basundhara////////////////////
                $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;

                $rmk='Reverted to LM';
                $status='M';
                $task='CO';
                $pen='LM';
                $case=$case_no;
                $rtps_status=$this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
                $rtps_status=json_decode($rtps_status);
                //var_dump($rtps_status);
                if(trim($rtps_status)!="y"){
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRAPP003211: Revert to LRA failed case no # $case_no");
                    redirect(base_url() . "index.php/home");
                }else{
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message', "Case no # $case_no reverted back to LRA");
                    redirect(base_url() . "index.php/home");
                    // redirect(base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $case_no);
                }
            }

        }

        if(isset($_POST['sk_forward_co']))
        {
            $case_no = $this->input->post('case_no');
            $remark_co = $this->input->post('remark_co_type');
            $remark_co_text = $this->input->post('remark_co_note');

            $basic_status = $this->SettlementCommonModel->getCurrentBasicStatus($case_no);

            if($basic_status == 'X')
            {
                $status = 'X';
            }
            else
            {
                $status = 'W';
            }

            $co_code = $this->input->post('co_code');

            $this->db->trans_begin();

            $updateArr = [
                'status' => $status,
                'date_update' => date('Y-m-d h:i:s'),
                'from_office' => 'SK',
                'pending_officer' => 'CO',
                'pending_office' => 'CO',
                'sk_code' => $this->session->userdata('user_code'),
            ];

            if($status == 'W')
            {
                $updateArr['co_code'] = $this->input->post('co_code');
            }

            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $updateArr);

            if($this->db->affected_rows() == 0 ){
                $this->db->trans_rollback();
                log_message('error', '#ERRCO003303: Falied to forward to CO');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO003303: Falied to forward to CO. Kindly contact system administrator',
                ];
                echo json_encode($json);
                return false;
            }

            //////proceeding start//////
            $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
            if($proceeding_id==null){
                $proceeding_id=1;
            }

            $insertArr = [
                'case_no' => $case_no,
                'proceeding_id' => $proceeding_id,
                'date_of_hearing' => date('Y-m-d h:i:s'),
                'next_date_of_hearing' => date('Y-m-d h:i:s'),
                'note_type' => $remark_co,
                'note_on_order' => $remark_co_text,
                'status' => $status,
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'SK',
                'office_to' => 'CO',
                'task' => 'Forwarded to CO'
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if($insertProc != 1){
                $this->db->trans_rollback();
                log_message('error', '#ERRCO0004: Insertion failed in settlement_proceeding');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0004: Failed to foward to DC. Kindly contact System Administrator',
                ];
                echo json_encode($json);
                return false;
            }
            if($this->db->trans_status()==FALSE){
                $this->db->trans_rollback();
                $data=array(
                    'error'=>"Error in submitting. Please try Again"
                );
                echo json_encode($data);
                return false;
            }else{

                //////////////POST To basundhara////////////////////
                $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;

                $rmk='Forwarded to CO';
                $status='M';
                $task='SK';
                $pen='CO';
                $case=$case_no;
                $rtps_status=$this->SettlementApiModel->postApiBasundhara($application_no,$case,$rmk,$status,$task,$pen);
                $rtps_status=json_decode($rtps_status);
                //var_dump($rtps_status);
                if(trim($rtps_status)!="y"){
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRAPP0011: Forward to DC failed case no # $case_no");
                    redirect(base_url() . "index.php/home");
                }else{
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message', "Case no # $case_no forwarded to CO");
                    redirect(base_url() . "index.php/home");
                    // redirect(base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $case_no);
                }
                // $this->load->view('SettlementView/Co/SettlementApTransferred');
            }
        }

        //forward to DC starts here
        if (isset($_POST['forward_to_dc'])) {
            $case_no = $this->input->post('case_no');
            $remark_co = $this->input->post('remark_co');
            $remark_co_type = $this->input->post('remark_co_type');
            $district = $this->input->post('district');
            $sub_division = $this->input->post('sub_division');
            $under_charter_activities = '';
            $adc_code = $this->input->post('adc_code');
            if($adc_code == '' || $adc_code == null || $adc_code == '-1')
            {
                log_message('error', '#ERRORINS98530: ADC selection is required !!!');
                $this->session->set_flashdata('message', "WARNING-INS98530: Please select ADC");
                redirect(base_url() . "index.php/home");
            }
            if($this->input->post('change_primary_yes_no') == false)
            {
                log_message('error', '#ERRORCOPRIMARY3566879: If primary information changed by you, you can not forwarded to ADC/DC');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRORCOPRIMARY3566879UI: Please select primary information changes or not ? ',
                ];
                echo json_encode($json);
                return false;
            }


            /////////////NGOTRUST///VENTURESCHOOL/////// CHECKING////////////////
            $under_ngo_trust_localbodies = null;
            $under_venture_school = null;
            $land_purpose_co_forward_to_dc = $this->input->post('land_purpose_co_forward_to_dc');
            if($land_purpose_co_forward_to_dc == null || $land_purpose_co_forward_to_dc == '')
            {
                log_message('error', '#ERRLANDPURPOSR3589: Land Purpose Missing, you can not forwarded to ADC/DC');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRLANDPURPOSR3589: Land Purpose Missing, please update CO primary information and revert to LRA for re-report',
                ];
                echo json_encode($json);
                return false;
            }


            $ins_cat_type_co_forward_to_dc = $this->input->post('ins_cat_type_co_forward_to_dc');
            if($ins_cat_type_co_forward_to_dc == null || $ins_cat_type_co_forward_to_dc == '')
            {
                log_message('error', '#ERRLANDPURPOSR3589: category is  Missing, you can not forwarded to ADC/DC');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRLANDPURPOSR3589: category is Missing, please update CO primary information and revert to LRA for re-report',
                ];
                echo json_encode($json);
                return false;
            }


            
            //if perifery area should be revert to LRA for re-report==========(Only LRA recomended cases will be considered...)
            $Lmnote = $this->db->query('select * from settlement_ap_lmnote where case_no = ? order by id desc limit 1', array($case_no))->row();



            if(empty($Lmnote))
            {
                log_message('error', '#ERRLMNOTENULL3761: category is  Missing, you can not forwarded to ADC/DC');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRLMNOTENULL3761: LRA report missing...revert to LRA for re-report and re-premium Calculation...',
                ];
                echo json_encode($json);
                return false;
            }
            if(trim($Lmnote->lm_note) != '2')
            {
                // echo "dd";die;
                $chithaFlag = $this->SettlementInsModel->checkChithaFlagUpdatePremiumAreaExceptSocioCultureEdu($case_no);
                if($chithaFlag['response'] == 1)
                {
                    log_message('error', '#ERRCHITHAFLAG3622: checkChithaFlagUpdatePremiumAreaExceptNonGovtEdu====='.json_encode($chithaFlag));
                    $json = [
                        'responseType' => 3,
                        'message' => $chithaFlag['msg'],
                    ];
                    echo json_encode($json);
                    return false;
                }
            }
            // echo "dd1";die;
            //////////////////landslide////rivererosion/////////
            if(trim($Lmnote->landslide) == 'YES' || trim($Lmnote->erosion) == 'YES' || trim($Lmnote->wetland_area) == 'YES')
            {
                if(trim($remark_co_type) == '1' || $remark_co_type == 1)
                {
                    log_message('error', '#ERRLMNOTERCIL3764541: Tribal belt/Landslide area/Wetland area........');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRLMNOTERCIL3764541: The institution under landslide,erosion and wetland area..........please check the LRA report',
                    ];
                    echo json_encode($json);
                    return false;
                }
                
            }
            
            

            if($ins_cat_type_co_forward_to_dc == 12 && (trim($land_purpose_co_forward_to_dc) == 'socioculture' || trim($land_purpose_co_forward_to_dc) == 'education' || trim($land_purpose_co_forward_to_dc) == 'religious'))
            {
                $under_ngo_trust_localbodies = $this->input->post('under_ngo_trust_localbodies');
                if($this->input->post('under_ngo_trust_localbodies') == false)
                {
                    log_message('error', '#ERRNGOTRUST3589: NGO TRUST Missing, you can not forwarded to ADC/DC');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRNGOTRUST3589: Please select Is the Institution falls under category of NGOs, Trusts, Local Bodies, Associations, Societies ? ',
                    ];
                    echo json_encode($json);
                    return false;
                }
                if($under_ngo_trust_localbodies == 'YES')
                {
                    $under_charter_activities = $this->input->post('under_charter_activities');
                    if($this->input->post('under_charter_activities') == false)
                    {
                        log_message('error', '#ERRNGOTRUST3651: Charter of activitiy is Missing, you can not forwarded to ADC/DC');
                        $json = [
                            'responseType' => 3,
                            'message' => '#ERRNGOTRUST3651: Please select Charter of activitiy ? ',
                        ];
                        echo json_encode($json);
                        return false;
                    }
                    if($under_charter_activities == 'NO')
                    {
                        log_message('error', '#ERRNGOTRUST3660: You can not forwarded to ADC/DC');
                        $json = [
                            'responseType' => 3,
                            'message' => '#ERRNGOTRUST3660:You can not forwarded to ADC/DC as the application does not considered as the charter of activities are such that the institution considered as educational,religious and socioculture institution.',
                        ];
                        echo json_encode($json);
                        return false;
                    }
                }
            }


            if($ins_cat_type_co_forward_to_dc == 12 && trim($land_purpose_co_forward_to_dc) == 'education')
            {
                $under_venture_school = $this->input->post('under_venture_school');
                if($this->input->post('under_venture_school') == false)
                {
                    log_message('error', '#ERRVENTURESCH3589: Venture School is missing, you can not forwarded to ADC/DC');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRVENTURESCH3589: Is the educational institution non provincialised venture school ? ',
                    ];
                    echo json_encode($json);
                    return false;
                }
                
                $insDetailsCheck = $this->SettlementInsModel->getInstitutionDetails($case_no);
                if($under_venture_school == 'YES' && $insDetailsCheck->venture_type == null)
                {
                    log_message('error', '#ERRVENTURESCH3611: You can not forwarded to ADC/DC');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRVENTURESCH3611:The application cannot be forwarded to ADC/DC at this stage. Please update the co-primary information and revert it to LRA for re-reporting and premium recalculation. Only after these steps can the application be forwarded to ADC/DC.',
                    ];
                    echo json_encode($json);
                    return false;
                }
            }
            

            $checkValLRA = $this->input->post('change_primary_yes_no');

            if($checkValLRA == 'YES')
            {
                log_message('error', '#ERRORCOPRIMARY3566: If primary information changed by you, you can not forwarded to ADC/DC');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0003488UI: If you modify the primary information, forwarding to ADC/DC will not be possible.Should be revert to LRA for re-report and re-premium Calculation then only you able to Forward to ADC/DC',
                ];
                echo json_encode($json);
                return false;
            }

            ////////CHECK VGR/PGR/UNRESERVED/PATTALAND/TEAPERODIC PATTA/////////////
            $checkGovtOrOthers = $this->SettlementInsModel->checkDagPgrVgrUnreservedTea($case_no);
            log_message('error','checkDagPgrVgrUnreservedTea=='.json_encode($checkGovtOrOthers));
            if($checkGovtOrOthers['response'] == 1)
            {
                $reserve_application = [
                    'reserve_application' => 'Y',
                ];
                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_basic', $reserve_application);
                if ($this->db->affected_rows() != 1)
                {
                    log_message('error', '#ERRCO0003488UI: Failed to forward to DC');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCO0003488UI: Failed to forward to DC',
                    ];
                    echo json_encode($json);
                    return false;
                }
                log_message('error', '#ERRDAGNOTGOVT3480: Dag not under govt...Failed to forward to DC, Application has been under reserverd');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRDAGNOTGOVT3480:"Failed to forward to the DC as the DAG is not classified under GOVT-LAND therefore, the application has been placed under reservation."',
                ];
                echo json_encode($json);
                return false;
            }

            $this->db->trans_begin();


            if($ins_cat_type_co_forward_to_dc == 12 && (trim($land_purpose_co_forward_to_dc) == 'socioculture' || trim($land_purpose_co_forward_to_dc) == 'education' || trim($land_purpose_co_forward_to_dc) == 'religious'))
            {
                $ngo_trust = [
                    'under_ngo_trust_localbodies' => $under_ngo_trust_localbodies,
                    'under_charter_activities'    => $under_charter_activities
                ];
                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_institution_details', $ngo_trust);
                if ($this->db->affected_rows() != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO0003984UI: Failed to forward to DC, please select NGO TRUST Options');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCO0003984UI: Failed to forward to DC, please select NGO TRUST Options',
                    ];
                    echo json_encode($json);
                    return false;
                }
            }


            if($ins_cat_type_co_forward_to_dc == 12 &&  trim($land_purpose_co_forward_to_dc) == 'education')
            {
                $under_venture = [
                    'under_venture_school' => $under_venture_school,
                ];
                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_institution_details', $under_venture);
                if ($this->db->affected_rows() != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO0003984UI: Failed to forward to DC, please select NGO TRUST Options');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCO0003984UI: Failed to forward to DC, please select NGO TRUST Options',
                    ];
                    echo json_encode($json);
                    return false;
                }
            }
           
            $sql = $this->db->query("SELECT * FROM settlement_proposal_cases WHERE case_no = ? AND status = ?",
                array($case_no, PRO_CASE_STATUS_REVERTED));
            if($sql->num_rows() > 0)
            {

                // update basic data
                $updateArrBasic = [
                    'co_code' => $this->session->userdata('user_code'),
                    'co_note_yn' => $remark_co_type,
                    'date_update' => date('Y-m-d h:i:s'),
                    'status'          => MB_SEND_TO_SDLAC,
                    'pending_office'  => MB_SDLAC,
                    'pending_officer' => MB_DEPUTY_COMM,
                    'from_office'     => MB_DEPUTY_COMM,
                    'dc_proceeding'   => 1,
                    'adc_code'        => $adc_code
                ];
                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_basic', $updateArrBasic);
                if ($this->db->affected_rows() != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO3122: Failed to forward to DC');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCO3122: Failed to forward to DC. Kindly contact system administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }

                // update proposal case details
                $updatePro = [
                    'status' => PRO_CASE_STATUS_PENDING,
                    'co_submit' => 1
                ];
                $this->db->where('case_no', $case_no);
                $this->db->where('status', PRO_CASE_STATUS_REVERTED);
                $this->db->update('settlement_proposal_cases', $updatePro);

                // echo $this->db->last_query();
                // die;

                if ($this->db->affected_rows() == 0)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO3146: Failed to forward to DC');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCO3146: Failed to forward to DC. Kindly contact system administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }

                //////proceeding for CO//////
                $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                if ($proceeding_id == null)
                {
                    $proceeding_id = 1;
                }

                $insertArr = [
                    'case_no' => $case_no,
                    'proceeding_id' => $proceeding_id,
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'note_type' => $remark_co_type,
                    'note_on_order' => $remark_co,
                    'status' => 'W',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'office_from' => 'CO',
                    'office_to' => 'DC',
                    'task' => 'Forwarded to DC',
                ];
                $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
                if ($insertProc != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO3182: Insertion failed in settlement_proceeding');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCO3182: Failed to forward to DC. Kindly contact System Administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }


                //////proceeding for DC//////
                $proceeding_id_dc = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                if ($proceeding_id_dc == null)
                {
                    $proceeding_id_dc = 1;
                }

                $insertArrDc = [
                    'case_no' => $case_no,
                    'proceeding_id' => $proceeding_id_dc,
                    'date_of_hearing' => date('Y-m-d h:i:s'),
                    'next_date_of_hearing' => date('Y-m-d h:i:s'),
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'status' => MB_SEND_TO_SDLAC,
                    'note_on_order' => 'Send to SDLAC',
                    'office_from' => MB_DEPUTY_COMM,
                    'office_to'   => MB_DEPUTY_COMM,
                    'task' => 'Send to SDLAC'
                ];
                $insertProDC = $this->db->insert('settlement_proceeding', $insertArrDc);
                if ($insertProDC != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCO3218: Insertion failed in settlement_proceeding');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCO3218: Failed to forward to DC. Kindly contact System Administrator',
                    ];
                    echo json_encode($json);
                    return false;
                }

                if ($this->db->trans_status() == false)
                {
                    $this->db->trans_rollback();
                    $data = array(
                        'error' => "Error in submitting. Please try Again",
                    );
                    echo json_encode($data);
                    return false;
                }
                else
                {
                    //////////////POST To basundhara////////////////////
                    $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;

                    $rmk='Send to SDLAC';
                    $status='M';
                    $task=MB_DEPUTY_COMM;
                    $pen=MB_DEPUTY_COMM;
                    $case=$case_no;
                    $rtps_status=$this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
                    $rtps_status=json_decode($rtps_status);
                    //var_dump($rtps_status);
                    if(trim($rtps_status)!="y"){
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', "Error #ERRINS3251: Forward to DC failed case no # $case_no");
                        redirect(base_url() . "index.php/home");
                    }else{
                        $this->db->trans_commit();
                        $this->session->set_flashdata('message', "Case no # $case_no forwarded to DC");
                        redirect(base_url() . "index.php/home");
                        // redirect(base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $case_no);
                    }
                    // $this->load->view('SettlementView/Co/SettlementApTransferred');
                }
            }
            

            $get_settlement_basic2 = $this->SettlementApModel->getSettlementBasicCo($case_no);
            $from_office_check = $get_settlement_basic2->from_office;


            $reserve_application_new = $get_settlement_basic2->reserve_application_new;
            if($reserve_application_new == '1')
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRCOALT365443: Failed to forward to DC');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRRESERVE0921: The forwarding to the ADC could not be completed, as the application under reserverd!!!',
                ];
                echo json_encode($json);
                return false;
            }

            //check whether the case is under already alloted under category 1.
            $insDetails = $this->SettlementInsModel->getInstitutionDetails($case_no);
            $apLmnoteDetails = $this->db->query('select * from settlement_ap_lmnote where case_no = ? order by id desc limit 1', array($case_no))->row();
            if(isset($insDetails) && !empty($insDetails))
            {
                if($insDetails->ins_cat_type_co == 8)
                {
                    if(isset($apLmnoteDetails->already_alloted) && $apLmnoteDetails->already_alloted !=null && trim($apLmnoteDetails->already_alloted) == 'Y')
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRCOALT3654: Failed to forward to DC');
                        $json = [
                            'responseType' => 3,
                            'message' => '#ERRCOALT3654: The forwarding to the ADC could not be completed, as the LRA has indicated in his report that the institution has already been allotted land. However, the category is recorded as Allotment of Government Land for Infrastructure Projects under Departments of the Government of Assam. To ensure accuracy and alignment with official records, please verify the details and confirm at the earliest.',
                        ];
                        echo json_encode($json);
                        return false;
                    }
                    
                }
            }
            //end/////////
            if(isset($insDetails) && !empty($insDetails) && trim($apLmnoteDetails->lm_note) != '2')
            {
                $premiumDataIns = $this->db->query("Select * from settlement_premium where case_no='$case_no' and is_final=1")->row();

                if($insDetails->ins_cat_type_co == 9 && ($premiumDataIns->undertaking_premium_update == null || $premiumDataIns->undertaking_premium_update == '' || $premiumDataIns->undertaking_premium_update == 'NO'))
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRCOALT365443: Failed to forward to DC');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCOALT365443: The forwarding to the ADC could not be completed due to premium issues, please revert back to LRA for re-reporting with re-premium Calculation',
                    ];
                    echo json_encode($json);
                    return false;
                }

                //check premium exist or not===========
                if($insDetails->ins_cat_type_co == 9 && $apLmnoteDetails->already_alloted == 'Y')
                {
                    $premiumData = $this->db->query("Select * from settlement_premium where case_no='$case_no' and is_final=1")->row();
                    if(empty($premiumData) || $premiumData == null)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRNOPREM3841: Failed to forward to DC');
                        $json = [
                            'responseType' => 3,
                            'message' => '#ERRNOPREM3841: Premium data is missing. Kindly verify its availability. If the data is not present, please proceed with re-reporting via LRA',
                        ];
                        echo json_encode($json);
                        return false;
                    }
                    if($premiumData)
                    {
                        if($premiumData->final_amount == 0 || $premiumData->final_amount == '0.00' || $premiumData->final_amount == '0')
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRNOPREM3842: Failed to forward to DC');
                            $json = [
                                'responseType' => 3,
                                'message' => '#ERRNOPREM3842: Premium data is missing. Kindly verify its availability. If the data is not present, please proceed with re-reporting via LRA',
                            ];
                            echo json_encode($json);
                            return false;
                        }
                    }
                }
                if($insDetails->ins_cat_type_co == 10 || $insDetails->ins_cat_type_co == 11)
                {
                    $premiumData = $this->db->query("Select * from settlement_premium where case_no='$case_no' and is_final=1")->row();
                    if(empty($premiumData) || $premiumData == null)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRNOPREM3843: Failed to forward to DC');
                        $json = [
                            'responseType' => 3,
                            'message' => '#ERRNOPREM3841: Premium data is missing. Kindly verify its availability. If the data is not present, please proceed with re-reporting via LRA',
                        ];
                        echo json_encode($json);
                        return false;
                    }
                    if($premiumData)
                    {
                        if($premiumData->final_amount == 0 || $premiumData->final_amount == '0.00' || $premiumData->final_amount == '0')
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRNOPREM3844: Failed to forward to DC');
                            $json = [
                                'responseType' => 3,
                                'message' => '#ERRNOPREM3844: Premium data is missing. Kindly verify its availability. If the data is not present, please proceed with re-reporting via LRA',
                            ];
                            echo json_encode($json);
                            return false;
                        }
                        if($premiumData->land_revenue_years == '0' || $premiumData->land_revenue_years == 0 || $premiumData->land_revenue_years == null || $premiumData->land_revenue_years == '0.00')
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRNOPREM3844: Failed to forward to DC');
                            $json = [
                                'responseType' => 3,
                                'message' => '#ERRNOPREM3844: Land revenue is missing. Kindly verify its availability. If the data is not present, please proceed with re-reporting via LRA',
                            ];
                            echo json_encode($json);
                            return false;
                        }
                    }
                    
                }
                if($insDetails->ins_cat_type_co == 12)
                {
                    $premiumData = $this->db->query("Select * from settlement_premium where case_no='$case_no' and is_final=1")->row();
                    if(empty($premiumData) || $premiumData == null)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRNOPREM3845: Failed to forward to DC');
                        $json = [
                            'responseType' => 3,
                            'message' => '#ERRNOPREM3845: Premium data is missing. Kindly verify its availability. If the data is not present, please proceed with re-reporting via LRA',
                        ];
                        echo json_encode($json);
                        return false;
                    }
                    if($premiumData)
                    {
                        if($premiumData->final_amount == 0 || $premiumData->final_amount == '0.00' || $premiumData->final_amount == '0')
                        {
                            $this->db->trans_rollback();
                            log_message('error', '#ERRNOPREM3846: Failed to forward to DC');
                            $json = [
                                'responseType' => 3,
                                'message' => '#ERRNOPREM3846: Premium data is missing. Kindly verify its availability. If the data is not present, please proceed with re-reporting via LRA',
                            ];
                            echo json_encode($json);
                            return false;
                        }
                    }
                    
                }

            }



            $headQtrCheck = $this->SettlementCommonModel->headquarterCheck($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'));


            if(trim($headQtrCheck) == 'Y'){
                $pending_officer = 'ADC';
                $pending_office = 'DC';
            }else{
                $pending_officer = 'SDO';
                $pending_office = 'DC';
            }


            //////proceeding if sk report not submitted//////
            if($from_office_check == 'LM'){

                $proceeding_sk_check = $this->db->query("Select * from settlement_proceeding where case_no='$case_no' and office_from='SK' and office_to='CO'");

                if($proceeding_sk_check->num_rows() <= 0) {

                    $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
                    if ($proceeding_id == null) {
                        $proceeding_id = 1;
                    }

                    $insertArr = [
                        'case_no' => $case_no,
                        'proceeding_id' => $proceeding_id,
                        'date_of_hearing' => date('Y-m-d h:i:s'),
                        'next_date_of_hearing' => date('Y-m-d h:i:s'),
                        'note_type' => '',
                        'note_on_order' => 'SK Report not submitted',
                        'status' => 'W',
                        'user_code' => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d h:i:s'),
                        'operation' => 'E',
                        'ip' => $this->utilityclass->get_client_ip(),
                        'office_from' => 'CO',
                        'office_to' => 'CO',
                        'task' => 'SK Report not submitted.',
                    ];
                    $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
                    if ($insertProc != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERRCO3311: Insertion failed in settlement_proceeding');
                        $json = [
                            'responseType' => 3,
                            'message' => '#ERRCO3311: Failed to forward to DC. Kindly contact System Administrator',
                        ];
                        echo json_encode($json);
                        return false;
                    }
                }

            }
            //////proceeding if sk report not submitted end//////



            $updateArr = [
                'status' => 'W',
                'co_code' => $this->session->userdata('user_code'),
                'co_note_yn' => $remark_co_type,
                'date_update' => date('Y-m-d h:i:s'),
                'from_office' => 'CO',
                'pending_officer' => $pending_officer,
                'pending_office' => $pending_office,
                'adc_code'        => $adc_code
            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $updateArr);

            if ($this->db->affected_rows() != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCO00034343: Failed to forward to DC');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO00034343: Failed to forward to DC. Kindly contact system administrator',
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
                'note_type' => $remark_co_type,
                'note_on_order' => $remark_co,
                'status' => 'W',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => $pending_officer,
                'task' => 'Forwarded to '.$pending_officer,
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if ($insertProc != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRCO0004: Insertion failed in settlement_proceeding');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0004: Failed to forward to DC. Kindly contact System Administrator',
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

                //////////////POST To basundhara////////////////////

                $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
                // $this->db->trans_rollback();

                $rmk='Forwarded to '.$pending_officer;
                $status='M';
                $task='CO';
                $pen=$pending_officer;
                $case=$case_no;
                $rtps_status=$this->SettlementApiModel->postApiBasundharaMb3($application_no,$case,$rmk,$status,$task,$pen);
                $rtps_status=json_decode($rtps_status);
                if(trim($rtps_status)!="y"){
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "Error #ERRAPP0011: Forward to DC failed case no # $case_no");
                    redirect(base_url() . "index.php/home");
                }else{
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message', "Case no # $case_no forwarded to ".$pending_officer);
                    redirect(base_url() . "index.php/home");
                    // redirect(base_url() . 'index.php/SettlementKhasCo/settlementKhasCo?case=' . $case_no);
                }
                // $this->load->view('SettlementView/Co/SettlementApTransferred');
            }
        }
    }

    public function coReSubmitLmCases()
    {
        $service_code = $this->input->get('service');
        $status = $this->input->get('s');

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $chitha_data['cases'] = $this->db->query("
            SELECT * FROM settlement_basic WHERE dist_code='$dist_code'AND subdiv_code='$subdiv_code'AND cir_code='$cir_code'AND status='X'AND lm_code is not null and service_code = '45'")->result();

        $chitha_data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);
        $chitha_data['service_code'] = $service_code;
        $chitha_data['_view'] = 'settlement_mb/co_resubmit_lm_cases_ins';

        $this->load->view('layouts/main', $chitha_data);
    }

    public function pagination()
    {

        if(LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO'){
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

        $pagination = $this->input->post('pagination');


        $final_verification_report = $this->input->post('final_verification_report');
        $co_approved = $this->input->post('co_approved');

        $allotment_settlement = $this->input->post('allotment_settlement');

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

        if(!empty($remark_cat))
        {  //settlement_ap_lmnote, lm_note
            $this->db->where('b.lm_note', $remark_cat);
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

        if (trim($reverted) == 'LM'){
            $this->db->where('a.pending_officer', MB_LOT_MONDOL);

        }
        else if (trim($reverted) == 'ADC'){
            $this->db->where_not_in('a.pending_officer',array(MB_LOT_MONDOL,MB_SUPERVISOR_KANANGU,MB_CIRCLE_OFFICER));
        }
        else{

            $this->db->where_in('a.pending_officer', array(MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU));
        }
        if ($this->session->userdata('user_desig_code') == 'CO'){
            // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
            if(LOT_BIFURCATE ==1 && empty($mouza_pargona_code) && empty($lot_no)){
                if(isset($lot_string) && $lot_string != null)
                {
                    $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                }
            }

            // $this->db->orWhere('a.co_code', null);
        }
        if ($this->session->userdata('user_desig_code') == 'SK') {
            $this->db->where('b.lm_note', '1');
            $this->db->where('a.from_office', 'LM');
        }

        if(trim($reverted) == 'LM' and $status =='V'){
            $this->db->select("distinct(a.case_no),a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, a.chitha_processing_details");
            $this->db->select('(select \'0\') as lm_note');
        }else{
            if($status == MB_PAYMENT_NOTICE)
            {
                $this->db->select('distinct(a.case_no), a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note, a.chitha_processing_details,sid.ins_cat_type_co');
            }
            else
            {
                $this->db->select('distinct(a.case_no), a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note, a.chitha_processing_details');
            }
        }
        //}

        if (trim($reverted) != 'ADC'){
            $this->db->where('a.status', $status);
        }
        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

        // $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
        if(trim($reverted) == 'LM' and $status =='V'){
            $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no', 'left');
        }else{
            $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
        }

        if($s_code == 14 && ($status !='R' && $status !='X' && $status !='M' && $status !='N' && $status !='D'))
        {
            if (trim($reverted) != 'ADC'){
                if (($this->session->userdata('user_desig_code') == 'SK' and $status =='W') || trim($reverted) == 'LM' and $status =='V') {

                }

                else{
                    $this->db->where('a.notice_generated_yn', NULL);
                }
            }
        }


        $this->db->from('settlement_basic a');

        if($status == MB_PAYMENT_NOTICE)
        {
            $this->db->join('settlement_institution_details sid', 'a.case_no = sid.case_no');
            if(!empty($allotment_settlement))
            {
                if($allotment_settlement == '8')
                {
                    $this->db->where_in('sid.ins_cat_type_co', array('8'));
                }
                else if($allotment_settlement == '9')
                {
                    $this->db->where_in('sid.ins_cat_type_co', array('9'));
                }
                else if($allotment_settlement == '10')
                {
                    $this->db->where_in('sid.ins_cat_type_co', array('10'));
                }
                else if($allotment_settlement == '11')
                {
                    $this->db->where_in('sid.ins_cat_type_co', array('11'));
                }
                else if($allotment_settlement == '12')
                {
                    $this->db->where_in('sid.ins_cat_type_co', array('12'));
                }
            }
            else
            {
                $this->db->where_in('sid.ins_cat_type_co', array('8','9','10','11','12'));
            }
            

            $this->db->join('settlement_premium c', 'a.case_no = c.case_no');
            $this->db->where('c.is_final', 1);

            if(!empty($payment_status))
            {
                if(trim($payment_status) == 'paid')
                {
                    $this->db->where('c.grn_no is not null');
                }
                elseif(trim($payment_status) == 'unpaid')
                {
                    $this->db->where('c.grn_no is null');
                }
            }

            if(!empty($final_verification_report))
            {
                if($final_verification_report == 'Yes')
                {
                    $this->db->where_in('a.chitha_processing_details', array(1,2));
                }
                else if($final_verification_report == 'No')
                {
                    $this->db->where('a.chitha_processing_details', 0);
                }
                elseif(trim($final_verification_report) == 'land_class_issue'){
                    // $this->db->join('settlement_dag_details sd', 'sd.case_no = a.case_no');     
                    // $this->db->where("(sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = '' OR sd.new_land_class_agri = '')", NULL, FALSE); 
                    
                    $this->db->where('EXISTS (SELECT 1 FROM settlement_dag_details sd WHERE sd.case_no = a.case_no AND ((sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = \'\' OR sd.new_land_class_agri = \'\')))', NULL, FALSE);

                }
            }


            if(!empty($co_approved))
            {
                if($co_approved == 'Yes')
                {
                    $this->db->where('a.chitha_processing_details', 2);
                }
                else if($co_approved == 'No')
                {
                    $this->db->where_in('a.chitha_processing_details', array(1,0));
                }
            }
        }

        $query = $this->db->get();

        // echo $this->db->last_query();die;

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {

                

                $revialSql = $this->db->query('select * from settlement_revival_flag where case_no = ? and revival_status = ?', array($rows->case_no, 1));

                if($revialSql->num_rows() > 0)
                {
                    $revival_flg_button = '';
                }
                else
                {
                    $revival_flg_button = '<button type="button" onclick="caseRevivalList(\''.$rows->case_no.'\',\''.$rows->service_code.'\');" class="btn btn-sm btn-warning">Flag for Revival</button>';
                }

                $download_rejected_cases = '<br><a class="mt-2 btn btn-sm btn-dark" target= "RejectedCases" href="'.base_url().'index.php/SettlementCommon/downloadRejectedCases/?service='.$s_code.'">Download Reject Cases</a>';

                if(trim($rows->lm_note) == 1)
                {
                    $lmnoteRemark = 'Recommended';
                }
                else
                {
                    $lmnoteRemark = 'Not Recommended';
                }

                if ($status == MB_PAYMENT_REQUEST) {
                    

                    $khas_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . enc_param('case', $rows->case_no, 600) . '">
                        <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementInstitutionCo/generatePaymentNoticeCo?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary mt-1">
                        Payment Notice</a>';

                    

                } elseif ($status == MB_PAYMENT_NOTICE) {


                    if($rows->chitha_processing_details == 1)
                    {
                        $lm_chitha_report = 'Yes';
                    }
                    elseif($rows->chitha_processing_details == 2)
                    {
                        $lm_chitha_report = 'Yes';
                    }
                    elseif($rows->chitha_processing_details == 0)
                    {
                        $lm_chitha_report = 'No';
                    }


                    if($rows->chitha_processing_details == 2)
                    {
                        $co_approved_status = 'Yes';
                    }
                    elseif($rows->chitha_processing_details == 1)
                    {
                        $co_approved_status = 'No';
                    }
                    elseif($rows->chitha_processing_details == 0)
                    {
                        $co_approved_status = 'No';
                    }

               

                    $registrationCert = '';
                    $paymentNoticeLinkIns = '';
                    if($rows->ins_cat_type_co == '12')
                    {
                        $registrationCert = '<a alt="Print Notice" class="text-white btn btn-sm btn-success mt-1" target="registrationNotice" href="' . base_url() . 'index.php/SettlementInstitutionCo/printNoticeRegistration?case_no=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Registration Notice</a>';
                    }

                    if($rows->ins_cat_type_co != '8')
                    {
                        $paymentNoticeLinkIns = '<a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="' . base_url() . 'index.php/SettlementCommon/printPaymentNotice?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Payment Notice</a>';
                    }

                    

                    

                    $khas_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . enc_param('case', $rows->case_no, 600) . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>

                        <br>
                        '.$paymentNoticeLinkIns.'

                        <br>
                        '.$registrationCert.'
                        

                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementInstitutionCo/confirmPaymentCo?case=' . $rows->case_no . '" class="mt-1 lmreportmut btn-sm btn btn-primary">
                        write report</a>';

                    

                    
                } else if ($status == MB_ORDER_FOR_CHITHA_UPDATE) {
                    
                }
                else if (trim($reverted) == 'ADC' or trim($reverted) == 'LM'){
                    
                    $khas_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>';
                    


                }
                else if($status == MB_DISMISS)
                {
                    
                    $khas_link = '<a type="button" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=' . $rows->case_no . '" class="lmreportmut btn-sm btn btn-primary">
                    view</a>  '.$revival_flg_button.$download_rejected_cases;
                    
                }
                else
                {
                    
                    $khas_link = '<a type="button" href="' . base_url() . 'index.php/SettlementInstitutionCo/settlementInsCo?case=' . enc_param('case', $rows->case_no, 600) . '" class="lmreportmut btn-sm btn btn-primary">
                        write report</a>';
                    

                }

                if($status == MB_PAYMENT_NOTICE)
                {
                    $insCategory = '';
                    if($rows->ins_cat_type_co == '8')
                    {
                        $insCategory = "<span style='color:#0cc10c;font-weight:bold'>State govt.</span>";
                    }
                    else if($rows->ins_cat_type_co == '9')
                    {
                        $insCategory = "<span style='color:#242472;font-weight:bold'>State govt Undertakings</span>";
                    }
                    else if($rows->ins_cat_type_co == '10')
                    {
                        $insCategory = "<span style='color:#ffb81d;font-weight:bold'>Central govt</span>";
                    }
                    else if($rows->ins_cat_type_co == '11')
                    {
                        $insCategory = "<span style='color:#ff681d;font-weight:bold'>Central govt Undertakings</span>";
                    }
                    else if($rows->ins_cat_type_co == '12')
                    {
                        $insCategory = "<span style='color:#9d2b2b;font-weight:bold'>Non Govt.(Education/Socio/Religious)</span>";
                    }
                    $sqlgrn = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ?', array($rows->case_no, 1));

                    if($sqlgrn->num_rows() <= 0)
                    {
                        $grn_status = '<strong class="text-danger">NOT PAID</strong>';
                    }
                    else
                    {
                        if(isset($sqlgrn->row()->grn_no))
                        {
                            if($sqlgrn->row()->grn_no == null || $sqlgrn->row()->grn_no == '')
                            {
                                $grn_status = '<strong class="text-danger">NOT PAID</strong>';
                            }
                            else
                            {
                                $grn_status = '<strong class="text-success">PAID</strong>';
                            }
                        }
                        else
                        {
                            $grn_status = '<strong class="text-danger">NOT PAID</strong>';
                        }
                    }

                    $json[] = array(
                        '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                        '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                        $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                        $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                        $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                        // $nr_status,

                        // $rows->date_entry,
                        // date("Y-m-d", strtotime($rows->date_entry)),

                        // $lmnoteRemark,

                        $grn_status,
                        $lm_chitha_report,
                        $co_approved_status,
                        $insCategory,
                        $khas_link,
                    );

                }
                else
                {
                    $json[] = array(
                        '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                        '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                        $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                        $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                        $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                        // $nr_status,

                        // $rows->date_entry,
                        date("Y-m-d", strtotime($rows->date_entry)),

                        $lmnoteRemark,
                        $khas_link,
                    );
                }

            }

            $this->db->where('a.service_code', $s_code);

            if(!empty($remark_cat))
            {  //settlement_ap_lmnote, lm_note
                $this->db->where('b.lm_note', $remark_cat);
            }

            if (trim($reverted) == 'LM'){
                $this->db->where('a.pending_officer', MB_LOT_MONDOL);

            }
            else if (trim($reverted) == 'ADC'){
                $this->db->where_not_in('a.pending_officer',array(MB_LOT_MONDOL,MB_SUPERVISOR_KANANGU,MB_CIRCLE_OFFICER));
            }
            else{


                // if ($this->session->userdata('user_desig_code') == 'SK')
                // {
                //     $this->db->where('a.pending_officer', MB_SUPERVISOR_KANANGU);
                // }
                // else
                // {
                //     $this->db->where_in('a.pending_officer', array(MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU));
                //     // $this->db->or_where('pending_officer', MB_SUPERVISOR_KANANGU);
                // }
                $this->db->where_in('a.pending_officer', array(MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU));
            }

            if ($this->session->userdata('user_desig_code') == 'CO'){
                // $this->db->where('a.co_code', $user_code);
                // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
                if(LOT_BIFURCATE ==1 && empty($mouza_pargona_code) && empty($lot_no)){

                    if(isset($lot_string) && $lot_string != null)
                    {
                        $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                    }
                }
            }

            if ($this->session->userdata('user_desig_code') == 'SK') {
                $this->db->where('b.lm_note', '1');
                $this->db->where('a.from_office', 'LM');
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

            


            if(trim($reverted) == 'LM' and $status =='V'){
                $this->db->select('distinct(a.case_no)');
                $this->db->select('(select \'0\') as lm_note');
            }else{
                $this->db->select('distinct(a.case_no)');
            }

            //}


            if (trim($reverted) != 'ADC'){
                $this->db->where('a.status', $status);
            }
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

            // $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
            if(trim($reverted) == 'LM' and $status =='V'){
                $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no', 'left');
            }else{
                $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
            }

            if($s_code == 14 && ($status !='R' && $status !='X' && $status !='M' && $status !='N' && $status !='D'))
            {
                if (trim($reverted) != 'ADC'){
                    if (($this->session->userdata('user_desig_code') == 'SK' and $status =='W') || trim($reverted) == 'LM' and $status =='V') {

                    }

                    else{
                        $this->db->where('a.notice_generated_yn', NULL);
                    }
                }
            }

            if($status == MB_PAYMENT_NOTICE)
            {
                $this->db->join('settlement_institution_details sid', 'a.case_no = sid.case_no');
                // $this->db->where_in('sid.ins_cat_type_co', array('8','9','10','11','12'));
                if(!empty($allotment_settlement))
                {
                    if($allotment_settlement == '8')
                    {
                        $this->db->where_in('sid.ins_cat_type_co', array('8'));
                    }
                    else if($allotment_settlement == '9')
                    {
                        $this->db->where_in('sid.ins_cat_type_co', array('9'));
                    }
                    else if($allotment_settlement == '10')
                    {
                        $this->db->where_in('sid.ins_cat_type_co', array('10'));
                    }
                    else if($allotment_settlement == '11')
                    {
                        $this->db->where_in('sid.ins_cat_type_co', array('11'));
                    }
                    else if($allotment_settlement == '12')
                    {
                        $this->db->where_in('sid.ins_cat_type_co', array('12'));
                    }
                }
                else
                {
                    $this->db->where_in('sid.ins_cat_type_co', array('8','9','10','11','12'));
                }
                $this->db->join('settlement_premium c', 'a.case_no = c.case_no');
                $this->db->where('c.is_final', 1);

                if(!empty($payment_status))
                {
                    if(trim($payment_status) == 'paid')
                    {
                        $this->db->where('c.grn_no is not null');
                    }
                    elseif(trim($payment_status) == 'unpaid')
                    {
                        $this->db->where('c.grn_no is null');
                    }
                    
                }


                if(!empty($final_verification_report))
                {
                    if($final_verification_report == 'Yes')
                    {
                        $this->db->where_in('a.chitha_processing_details', array(1,2));
                    }
                    else if($final_verification_report == 'No')
                    {
                        $this->db->where('a.chitha_processing_details', 0);
                    }
                    elseif(trim($final_verification_report) == 'land_class_issue'){
                        // $this->db->join('settlement_dag_details sd', 'sd.case_no = a.case_no');     
                        // $this->db->where("(sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = '' OR sd.new_land_class_agri = '')", NULL, FALSE); 
                        $this->db->where('EXISTS (SELECT 1 FROM settlement_dag_details sd WHERE sd.case_no = a.case_no AND ((sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = \'\' OR sd.new_land_class_agri = \'\')))', NULL, FALSE);

                    }
                }


                if(!empty($co_approved))
                {
                    if($co_approved == 'Yes')
                    {
                        $this->db->where('a.chitha_processing_details', 2);
                    }
                    else if($co_approved == 'No')
                    {
                        $this->db->where_in('a.chitha_processing_details', array(1,0));
                    }
                }
            }



            // $total_records = $this->db->count_all_results('settlement_basic a');
            $data=$this->db->get('settlement_basic a');
            $total_records = $data->num_rows();
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
    public function validateCoSecProc()
    {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('application_type_state_central', 'Application Type', 'trim|required');
        $this->form_validation->set_rules('name_ins_co', 'Name of the institution', 'trim|required');              
        $this->form_validation->set_rules('name_ins_co_ass', 'Name of the institution(Assamese)', 'trim|required');
        $this->form_validation->set_rules('purpose_co', 'Land allotment Purpose', 'trim|required');
        if(in_array($this->input->post('application_type_state_central'),array(8,9,10,11)))
        {
            $this->form_validation->set_rules('dept_name_co', 'Name of the department(English)', 'trim|required');            
            $this->form_validation->set_rules('dept_name_ass_co', 'Name of the department(Assamese)', 'trim|required');
            $this->form_validation->set_rules('transferred_for_commercial_purposes_reclassification_govt', 'Is the  land applied for, is or will be used or  transferred for commercial purposes', 'trim|required');
        }
        if(in_array($this->input->post('application_type_state_central'),array(10,11)))
        {
            $this->form_validation->set_rules('ministry_department_name_change', 'Name of the ministry', 'trim|required');            
        }

        if(in_array($this->input->post('application_type_state_central'),array(12)))
        {
            $this->form_validation->set_rules('religious_or_charitable_purposes_reclassification', 'Is the Land applied for used for religious or charitable', 'trim|required');
            $this->form_validation->set_rules('under_ngo_trust_localbodies_primary_info', 'Does the Institution fall under category of NGOs, Trusts, Local Bodies, Associations, Societies ?', 'trim|required');  
            if($this->input->post('under_ngo_trust_localbodies_primary_info') == 'YES')  
            {
                
                $this->form_validation->set_rules('under_charter_activities_primary_info', 'Is the charter of activities are such that the institution considered as educational,religious and socioculture institution?', 'trim|required');  
            }       
        }

        if(in_array($this->input->post('application_type_state_central'),array(9,11)))
        {
            $this->form_validation->set_rules('state_dept_undertaking_name', 'Name of the undertaking board', 'trim|required');            
        }


        if(in_array($this->input->post('application_type_state_central'),array(12)) && $this->input->post('purpose_co') == 'education')
        {
          
            $this->form_validation->set_rules('under_venture_school_primary_info', 'Is the educational institution is venture school ?', 'trim|required');  
            if($this->input->post('under_venture_school_primary_info') == 'NO') 
            {
                $this->form_validation->set_rules('non_govt_profit_making_yes_no', 'Is the Non Govt. Educational Institution of public nature which is devoted to public purposes', 'trim|required'); 
            }
                       
        }


        if(in_array($this->input->post('application_type_state_central'),array(9)))
        {
            $this->form_validation->set_rules('state_warehousing_corporation', 'Is the Project/Infrastructure under State Government Undertakings/Statutory Bodies/Parastatals', 'trim|required');            
        }
        if(in_array($this->input->post('application_type_state_central'),array(10)))
        {
            $this->form_validation->set_rules('central_health_education_skill_sector', 'Is the Project/Infrastructure under Central Govt. Ministries/Departments related to Health,Education and Skill Development', 'trim|required');            
        }
        if(in_array($this->input->post('application_type_state_central'),array(11)))
        {
            $this->form_validation->set_rules('central_cwc_sector', 'Is the Project/Infrastructure under Central Govt. Undertakings/Statutory Bodies/Parastatals', 'trim|required');            
        }

        if ($this->form_validation->run() == FALSE) {
          $this->form_validation->set_error_delimiters('', '');
          $validation = [];
          if (form_error('application_type_state_central')) {
            $validation[] = array('field' => 'application_type_state_central', 'message' => form_error('application_type_state_central'));
          }
          if (form_error('name_ins_co')) {
            $validation[] = array('field' => 'name_ins_co', 'message' => form_error('name_ins_co'));
          }
          if (form_error('name_ins_co_ass')) {
            $validation[] = array('field' => 'name_ins_co_ass', 'message' => form_error('name_ins_co_ass'));
          }
          if (form_error('purpose_co')) {
            $validation[] = array('field' => 'purpose_co', 'message' => form_error('purpose_co'));
          }
          if (form_error('dept_name_co')) {
            $validation[] = array('field' => 'dept_name_co', 'message' => form_error('dept_name_co'));
          }
          if (form_error('dept_name_ass_co')) {
            $validation[] = array('field' => 'dept_name_ass_co', 'message' => form_error('dept_name_ass_co'));
          }
          if (form_error('ministry_department_name_change')) {
            $validation[] = array('field' => 'ministry_department_name_change', 'message' => form_error('ministry_department_name_change'));
          }
          if (form_error('transferred_for_commercial_purposes_reclassification_govt')) {
            $validation[] = array('field' => 'transferred_for_commercial_purposes_reclassification_govt', 'message' => form_error('transferred_for_commercial_purposes_reclassification_govt'));
          }
          if (form_error('religious_or_charitable_purposes_reclassification')) {
            $validation[] = array('field' => 'religious_or_charitable_purposes_reclassification', 'message' => form_error('religious_or_charitable_purposes_reclassification'));
          }
          if (form_error('state_dept_undertaking_name')) {
            $validation[] = array('field' => 'state_dept_undertaking_name', 'message' => form_error('state_dept_undertaking_name'));
          }
          if (form_error('non_govt_profit_making_yes_no')) {
            $validation[] = array('field' => 'non_govt_profit_making_yes_no', 'message' => form_error('non_govt_profit_making_yes_no'));
          }
          if (form_error('state_warehousing_corporation')) {
            $validation[] = array('field' => 'state_warehousing_corporation', 'message' => form_error('state_warehousing_corporation'));
          }
          if (form_error('central_health_education_skill_sector')) {
            $validation[] = array('field' => 'central_health_education_skill_sector', 'message' => form_error('central_health_education_skill_sector'));
          }
          if (form_error('central_cwc_sector')) {
            $validation[] = array('field' => 'central_cwc_sector', 'message' => form_error('central_cwc_sector'));
          }
          if (form_error('under_venture_school_primary_info')) {
            $validation[] = array('field' => 'under_venture_school_primary_info', 'message' => form_error('under_venture_school_primary_info'));
          }
          if (form_error('under_ngo_trust_localbodies_primary_info')) {
            $validation[] = array('field' => 'under_ngo_trust_localbodies_primary_info', 'message' => form_error('under_ngo_trust_localbodies_primary_info'));
          }
          if (form_error('under_charter_activities_primary_info')) {
            $validation[] = array('field' => 'under_charter_activities_primary_info', 'message' => form_error('under_charter_activities_primary_info'));
          }

          return $validation;
        }
        else
        {
            return null;
        }
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

        // $data['_view'] = 'settlement_mb/dc_revert_cases_new';
        $this->load->view('layouts/main', $data);
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




    public function editAreaNotMoreThenAppliedCheck()
    {
      return false;
    }

    public function totalAppliedAreaZeroCheck()
    {
      return false;
    }

    public function appAreaMoreThanDagA()
    {
      return false;
    }

    public function teaGrantMaxAppliedWithAddPro()
    {
      return false;
    }

    public function totalAppliedAreaInUrban()
    {
      return false;
    }

    public function cultivationMaxApplied()
    {
      return false;
    }

    public function totalAppliedAdditionalArea()
    {
      return false;
    }



    public function selectDagArea()
    {
      //****getting the data  */
      $case_no = $this->input->post('case_no');
      $id      = $this->input->post('id');
      $dag_no  = $this->input->post('dag_no');

      $this->db->trans_begin();

      $this->db->select('*');
      $this->db->from('settlement_dag_details');
      $this->db->where('case_no', $case_no);
      $this->db->where('dag_no', $dag_no);
      $this->db->where('id', $id);
      $query = $this->db->get();

      // echo $this->db->last_query(); 

      if ($query->num_rows() > 0) {

        $data = $query->result_array();

        foreach ($data as $row) {

          $areaUpdateArr = [

            //****total dag area */
            'dag_area_b'    => $row['dag_area_b'],
            'dag_area_k'    => $row['dag_area_k'],
            'dag_area_lc'   => $row['dag_area_lc'],
            'dag_area_g'    => $row['dag_area_g'],
            'dag_area_kr'   => $row['dag_area_kr'],          

            's_dag_area_b'  => $row['s_dag_area_b'],
            's_dag_area_k'  => $row['s_dag_area_k'],
            's_dag_area_lc' => $row['s_dag_area_lc'],
            's_dag_area_g'  => $row['s_dag_area_g'],
            's_dag_area_kr' => $row['s_dag_area_kr'],
            
            'is_urban'      => $row['is_urban'],
          ];
        }
      }

      $data = array(
        'responseType' => 2,
        'appnData'     => $areaUpdateArr,
      );
      echo json_encode($data);
    }

    public function updateAreaDetails()
    {
      //****getting the data  */
      $case_no        = $this->input->post('area_update_case_no');
      $distCode       = $this->session->userdata('dist_code');
      $service_code   = SLIJE_ID;
      $checkUrbanCon  = $this->input->post('area_update_urban_check');
      $land_area_type = $this->input->post('land_area_type');
      $id             = $this->input->post('area_update_id');
      $dag_no         = $this->input->post('area_update_dag_no');

      $justification_area_change = $this->input->post('justification_area_change');

      // echo "<pre>"; var_dump($_POST); die;

      $mbLandNullArea = array(7, 8, 9, 10, 18, 20, 22);

      $totalHomeAreaLessaValidation = 0;
      $totalAgrAreaLessaValidation  = 0;
      $totalDagAreaLessaValidation  = 0;
      $totalDagAreaAppliedLessa     = 0;
      $appAreaMoreThanDagA          = 0;

      $sb = $this->db->query("Select * from settlement_basic where case_no='$case_no'")->row();


      $dag_details = $this->db->query("Select * from settlement_dag_details where case_no='$case_no' and dag_no='$dag_no'")->result();
      foreach ($dag_details as $dagone) {
        $area_name = $this->utilityclass->getAreaCategory($dagone->dist_code, $dagone->subdiv_code, $dagone->cir_code, $dagone->mouza_pargona_code, $dagone->lot_no, $dagone->vill_townprt_code, $dagone->dag_no);
      }

      //******backend validation */
      //***delimiter for not returning <p> tag */
      $this->form_validation->set_error_delimiters('', '');

      $singleAdditionalProToLessa = 0;
      $totalAdditionalProToLessa  = 0;

      $application_no        = $this->ncutility->getApplidFromCaseNo($case_no,$dag_no);
      $additional_properties = $this->db->query("Select * from settlement_additional_property where applid='$application_no'")->result();
      $appliedDags           = $this->NcCommonModel->getAllAppliedDagsByApplicant($case_no,$dag_no);

      // var_dump($appliedDags); die;

      if (in_array($distCode, json_decode(BARAK_VALLEY)))
      {
        foreach ($additional_properties as $singleProperty) {
          $bighaAdditionalPro = $this->NcCommonModel->defaultValue($singleProperty->bigha, 0);
          $kathaAdditionalPro = $this->NcCommonModel->defaultValue($singleProperty->katha, 0);
          $lessaAdditionalPro = $this->NcCommonModel->defaultValue($singleProperty->lessa, 0);
          $gandaAdditionalPro = $this->NcCommonModel->defaultValue($singleProperty->ganda, 0);

          $singleAdditionalProToLessa = ($bighaAdditionalPro * 6400) + ($kathaAdditionalPro * 320) + ($lessaAdditionalPro * 20) + $gandaAdditionalPro;
          $totalAdditionalProToLessa += $singleAdditionalProToLessa;
        }

        foreach ($appliedDags as $appliedDag)
        {
          $appliedBighaAgri = 0;
          $appliedKathaAgri = 0;
          $appliedLessaAgri = 0;
          $appliedGandaAgri = 0;

          $appliedBighaHome = 0;
          $appliedKathaHome = 0;
          $appliedLessaHome = 0;
          $appliedGandaHome = 0;

          $singleAppliedAreaToLessaAgri = 0;
          $singleAppliedAreaToLessaHome = 0;

          $appliedBighaHome = $this->NcCommonModel->defaultValue($appliedDag->applied_area_home_bigha, 0);
          $appliedKathaHome = $this->NcCommonModel->defaultValue($appliedDag->applied_area_home_katha, 0);
          $appliedLessaHome = $this->NcCommonModel->defaultValue($appliedDag->applied_area_home_lessa, 0);
          $appliedGandaHome = $this->NcCommonModel->defaultValue($appliedDag->applied_area_home_ganda, 0);

          $singleAppliedAreaToLessaAgri = ($appliedBighaAgri * 6400) + ($appliedKathaAgri * 320) + ($appliedLessaAgri * 20) + $appliedGandaAgri;
          $singleAppliedAreaToLessaHome = ($appliedBighaHome * 6400) + ($appliedKathaHome * 320) + ($appliedLessaHome * 20) + $appliedGandaHome;

          $totalDagAreaAppliedLessa += ($singleAppliedAreaToLessaAgri + $singleAppliedAreaToLessaHome);
        }
      }
      else
      {
        foreach ($additional_properties as $singleProperty) {
          $bighaAdditionalPro = $this->NcCommonModel->defaultValue($singleProperty->bigha, 0);
          $kathaAdditionalPro = $this->NcCommonModel->defaultValue($singleProperty->katha, 0);
          $lessaAdditionalPro = $this->NcCommonModel->defaultValue($singleProperty->lessa, 0);

          $singleAdditionalProToLessa = ($bighaAdditionalPro * 100) + ($kathaAdditionalPro * 20) + $lessaAdditionalPro;
          $totalAdditionalProToLessa += $singleAdditionalProToLessa;
        }

        // echo "<pre>";
        // var_dump($appliedDags); die;

        foreach ($appliedDags as $appliedDag)
        {
          $appliedBighaHome = 0;
          $appliedKathaHome = 0;
          $appliedLessaHome = 0;

          $singleAppliedAreaToLessaAgri = 0;
          $singleAppliedAreaToLessaHome = 0;

          $appliedBighaHome = $this->NcCommonModel->defaultValue($appliedDag->applied_area_home_bigha, 0);
          $appliedKathaHome = $this->NcCommonModel->defaultValue($appliedDag->applied_area_home_katha, 0);
          $appliedLessaHome = $this->NcCommonModel->defaultValue($appliedDag->applied_area_home_lessa, 0);

          $singleAppliedAreaToLessaHome = ($appliedBighaHome * 100) + ($appliedKathaHome * 20) + $appliedLessaHome;
          $totalDagAreaAppliedLessa += $singleAppliedAreaToLessaHome;
        }
      }

      if (in_array($distCode, json_decode(BARAK_VALLEY)))
      {
          $this->form_validation->set_rules('total_bigha_in_dag', 'Total Land Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
          $this->form_validation->set_rules('total_katha_in_dag', 'Total Land Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
          $this->form_validation->set_rules('total_lessa_in_dag', 'Total Land Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
          $this->form_validation->set_rules('total_ganda_in_dag', 'Total Land Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
          $this->form_validation->set_rules('total_kranti_in_dag', 'Total Land Area (Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

          $this->form_validation->set_rules('enc_bigha_home', 'Applied Land Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
          $this->form_validation->set_rules('enc_katha_home', 'Applied Land Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[20]|xss_clean');
          $this->form_validation->set_rules('enc_lessa_home', 'Applied Land Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[16]|xss_clean');
          $this->form_validation->set_rules('enc_ganda_home', 'Applied Land Area (Ganda)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');
          $this->form_validation->set_rules('enc_kranti_home', 'Applied Land Area  Homestead(Kranti)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

          $bighaValidation = $this->NcCommonModel->defaultValue($this->input->post('total_bigha_in_dag'), 0);
          $kathaValidation = $this->NcCommonModel->defaultValue($this->input->post('total_katha_in_dag'), 0);
          $lessaValidation = $this->NcCommonModel->defaultValue($this->input->post('total_lessa_in_dag'), 0);
          $gandaValidation = $this->NcCommonModel->defaultValue($this->input->post('total_ganda_in_dag'), 0);

          $bighaValidationHome = $this->NcCommonModel->defaultValue($this->input->post('enc_bigha_home'), 0);
          $kathaValidationHome = $this->NcCommonModel->defaultValue($this->input->post('enc_katha_home'), 0);
          $lessaValidationHome = $this->NcCommonModel->defaultValue($this->input->post('enc_lessa_home'), 0);
          $gandaValidationHome = $this->NcCommonModel->defaultValue($this->input->post('enc_ganda_home'), 0);

          $dagAreaLessaValidation  = ($bighaValidation * 6400) + ($kathaValidation * 320) + ($lessaValidation * 20) + $gandaValidation;
          $homeAreaLessaValidation = ($bighaValidationHome * 6400) + ($kathaValidationHome * 320) + ($lessaValidationHome * 20) + $gandaValidationHome;

          if ($dagAreaLessaValidation < $homeAreaLessaValidation) {
              $appAreaMoreThanDagA = 1;
          }

          $totalDagAreaLessaValidation += $dagAreaLessaValidation;
          $totalHomeAreaLessaValidation += $homeAreaLessaValidation;
      }
      else
      {
          $this->form_validation->set_rules('total_bigha_in_dag', 'Total Land Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
          $this->form_validation->set_rules('total_katha_in_dag', 'Total Land Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
          $this->form_validation->set_rules('total_lessa_in_dag', 'Total Land Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

          $this->form_validation->set_rules('enc_bigha_home', 'Applied Land Area (Bigha)', 'trim|required|is_natural|greater_than[-1]|xss_clean');
          $this->form_validation->set_rules('enc_katha_home', 'Applied Land Area (Katha)', 'trim|required|is_natural|greater_than[-1]|less_than[5]|xss_clean');
          $this->form_validation->set_rules('enc_lessa_home', 'Applied Land Area (Lessa)', 'trim|required|numeric|greater_than[-1]|less_than[20]|xss_clean');

          $bighaValidation = $this->NcCommonModel->defaultValue($this->input->post('total_bigha_in_dag'), 0);
          $kathaValidation = $this->NcCommonModel->defaultValue($this->input->post('total_katha_in_dag'), 0);
          $lessaValidation = $this->NcCommonModel->defaultValue($this->input->post('total_lessa_in_dag'), 0);

          $bighaValidationHome = $this->NcCommonModel->defaultValue($this->input->post('enc_bigha_home'), 0);
          $kathaValidationHome = $this->NcCommonModel->defaultValue($this->input->post('enc_katha_home'), 0);
          $lessaValidationHome = $this->NcCommonModel->defaultValue($this->input->post('enc_lessa_home'), 0);

          $dagAreaLessaValidation  = ($bighaValidation * 100) + ($kathaValidation * 20) + $lessaValidation;
          $homeAreaLessaValidation = ($bighaValidationHome * 100) + ($kathaValidationHome * 20) + $lessaValidationHome;

          if ($dagAreaLessaValidation < $homeAreaLessaValidation) {
              $appAreaMoreThanDagA = 1;
          }

          $totalDagAreaLessaValidation += $dagAreaLessaValidation;
          $totalHomeAreaLessaValidation += $homeAreaLessaValidation;
      }

      $totalEditArea = $totalHomeAreaLessaValidation;

      $editAreaNotMoreThenApplied = 0;
      if($totalEditArea > $totalDagAreaAppliedLessa)
      {
          $editAreaNotMoreThenApplied = 1;
      }

      //////////////increased area applicable in institution except non-government//////////// 
        if($sb->service_code == SLIJE_ID)
        {
            $sInstitutionDetails = $this->db->query("Select * from settlement_institution_details where case_no='$case_no'")->row();
            $allowedCatTypes = ['12', '10', '11', '9'];
            if (in_array($sInstitutionDetails->ins_cat_type_co, $allowedCatTypes)) 
            {
                if (EDIT_AREA_NOT_MORE_THEN_APPLIED_AREA == 1 && $editAreaNotMoreThenApplied == 1) 
                {
                    $this->form_validation->set_rules(
                        'editAreaNotMoreThenAppliedCheck',
                        'Total edit area should not be more than total applied area!',
                        'required|callback_editAreaNotMoreThenAppliedCheck'
                    );
                }
            }
        }
        else
        {
            if(EDIT_AREA_NOT_MORE_THEN_APPLIED_AREA == 1)
            {
                if ($editAreaNotMoreThenApplied == 1)
                {
                    $this->form_validation->set_rules('editAreaNotMoreThenAppliedCheck', 'Total edit area should not more then total applied area !', 'required|callback_editAreaNotMoreThenAppliedCheck');
                }
            }
        }

      

      if ($totalHomeAreaLessaValidation == 0)
      {
        $this->form_validation->set_rules('totalAppliedAreaZeroCheck', 'Total applied area should not be Zero !', 'required|callback_totalAppliedAreaZeroCheck');
      }
      if ($appAreaMoreThanDagA == 1)
      {
        $this->form_validation->set_rules('appAreaMoreThanDagA', 'Total applied area should not be more than total Dag Area !', 'required|callback_appAreaMoreThanDagA');
      }

      

      if (in_array($distCode, json_decode(BARAK_VALLEY)))
      {
        if (KHAS_MAX_HOMESTEAD_INSTITUTE * 6400 < $totalHomeAreaLessaValidation) {

          $this->form_validation->set_rules('cultivationMaxApplied', 'Total applied area should not be more than ' . KHAS_MAX_HOMESTEAD_INSTITUTE . ' Bigha !', 'required|callback_cultivationMaxApplied');
        }
        if ((KHAS_MAX_HOMESTEAD_INSTITUTE ) * 6400 < ($totalHomeAreaLessaValidation + $totalAdditionalProToLessa)) {
          $this->form_validation->set_rules('totalAppliedAdditionalArea', 'Total Land Area (Applied Area + Additional Area)  cannot exceed  more than ' . (KHAS_MAX_HOMESTEAD_INSTITUTE) . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
        }
      }
      else
      {
        if (KHAS_MAX_HOMESTEAD_INSTITUTE * 100 < $totalHomeAreaLessaValidation) {
          $this->form_validation->set_rules('cultivationMaxApplied', 'Total applied area should not be more than ' . KHAS_MAX_HOMESTEAD_INSTITUTE . ' Bigha !', 'required|callback_cultivationMaxApplied');
        }
        if ((KHAS_MAX_HOMESTEAD_INSTITUTE) * 100 < ($totalHomeAreaLessaValidation + $totalAdditionalProToLessa)) {
          $this->form_validation->set_rules('totalAppliedAdditionalArea', 'Total Land Area (Applied Area + Additional Area)  cannot exceed  more than ' . (KHAS_MAX_HOMESTEAD_INSTITUTE) . ' Bigha !', 'required|callback_totalAppliedAdditionalArea');
        }
      }


      if ($this->form_validation->run() == false) {
        $data = array(
          'responseType' => 0,
          'msg'          => "#AREAUPDT0001:" . validation_errors() . "#case_no : " . $case_no,
        );
        echo json_encode($data);
        return false;
      }

      $this->db->trans_begin();

      //****landType update HOMESTEAD/AGRICULTURE/BOTH */
      $homesteadLandExist = (float)$this->input->post('enc_bigha_home') + (float)$this->input->post('enc_katha_home') + (float)$this->input->post('enc_lessa_home') + (float)$this->input->post('enc_ganda_home') + (float)$this->input->post('enc_kranti_home');

      $landTypeUpdate = 0;
      if ($homesteadLandExist > 0) {
        $landTypeUpdate = 1;
      }

      if (in_array($distCode, json_decode(BARAK_VALLEY))) {
          //***********actual Applied area ***************
          $actual_encroachment_area_home_ganda = $this->ncutility->Total_ganda($this->input->post('enc_bigha_home'), $this->input->post('enc_katha_home'), $this->input->post('enc_lessa_home'), $this->input->post('enc_ganda_home'));

          //***********total Actual Applied area*****************
          $total_actual_encroachment_area_ganda = (float)$actual_encroachment_area_home_ganda;
          $totalEncroachmentAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa2($total_actual_encroachment_area_ganda);
          // **********************************************

          //***********Settlement area that applicant will get settlement on***********
          $total_settlement_ganda_home = $this->ncutility->Total_ganda($this->input->post('enc_bigha_home'), $this->input->post('enc_katha_home'), $this->input->post('enc_lessa_home'), $this->input->post('enc_ganda_home'));

          //*****total Settlement area *************/
          $total_settlement_ganda = (float)$total_settlement_ganda_home;
          $totalSettlementAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa2($total_settlement_ganda);

          //*************leftout area homestead**************
          $leftOutAreaHomeGanda = (float)$actual_encroachment_area_home_ganda - (float)$total_settlement_ganda_home;
          $leftOutAreaHomeArr = $this->ncutility->Total_Bigha_Katha_Lessa2($leftOutAreaHomeGanda);

          //**********Total left out area***************
          $totalLeftOutAreaGanda = (float)$total_actual_encroachment_area_ganda - (float)$total_settlement_ganda;
          $totalLeftOutAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa2($totalLeftOutAreaGanda);
      } else {
          //********actual Applied area**********
          $actual_encroachment_area_home_lessa = $this->ncutility->Total_Lessa($this->input->post('enc_bigha_home'), $this->input->post('enc_katha_home'), $this->input->post('enc_lessa_home'));

          //***********total Actual Applied area*****************
          $total_actual_encroachment_area_lessa = (float)$actual_encroachment_area_home_lessa ;
          $totalEncroachmentAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa($total_actual_encroachment_area_lessa);
          // **********************************************

          //*******Settlement area that applicant will get settlement on**********
          $total_settlement_lessa_home = $this->ncutility->Total_Lessa($this->input->post('enc_bigha_home'), $this->input->post('enc_katha_home'), $this->input->post('enc_lessa_home'));

          //*************Total settlement area */
          $total_settlement_lessa = (float)$total_settlement_lessa_home;
          $totalSettlementAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa($total_settlement_lessa);

          //****************leftout area homestead**************
          $leftOutAreaHomeLessa = (float)$actual_encroachment_area_home_lessa - (float)$total_settlement_lessa_home;
          $leftOutAreaHomeArr = $this->ncutility->Total_Bigha_Katha_Lessa($leftOutAreaHomeLessa);

          //**********Total left out area***************
          $totalLeftOutArealessa = (float)$total_actual_encroachment_area_lessa - (float)$total_settlement_lessa;
          $totalLeftOutAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa($totalLeftOutArealessa);
      }

      // var_dump($total_settlement_lessa_home); die;
      //***Applied area update*/
      $encroachment_area = [
        'homestead' => [
          'bigha'   => $this->input->post('enc_bigha_home'),
          'katha'   => $this->input->post('enc_katha_home'),
          'lessa'   => $this->input->post('enc_lessa_home'),
          'ganda'   => $this->input->post('enc_ganda_home'),
          'kranti'  => $this->input->post('enc_kranti_home'),
        ],
      ];

      $areaUpdateArr = [
        //****total dag area */
        'dag_area_b'    => $this->input->post('total_bigha_in_dag'),
        'dag_area_k'    => $this->input->post('total_katha_in_dag'),
        'dag_area_lc'   => $this->input->post('total_lessa_in_dag'),
        'dag_area_g'    => $this->NcCommonModel->defaultValue($this->input->post('total_ganda_in_dag'), 0),
        'dag_area_kr'   => $this->NcCommonModel->defaultValue($this->input->post('total_kranti_in_dag'), 0),

        //*****Applied area */
        'encroachement_area'  => json_encode($encroachment_area),

        //*****settlement area */
        'home_b'        => $this->input->post('enc_bigha_home'),
        'home_k'        => $this->input->post('enc_katha_home'),
        'home_lc'       => $this->input->post('enc_lessa_home'),
        'home_g'        => $this->NcCommonModel->defaultValue($this->input->post('enc_ganda_home'), 0),
        'home_kr'       => $this->NcCommonModel->defaultValue($this->input->post('enc_kranti_home'), 0),
        'agri_b'        => 0,
        'agri_k'        => 0,
        'agri_lc'       => 0,
        'agri_g'        => 0,
        'agri_kr'       => 0,

        'applied_b'     => 0,
        'applied_k'     => 0,
        'applied_lc'    => 0,
        'applied_g'     => 0,
        'applied_kr'    => 0,

        's_dag_area_b'  => $totalSettlementAreaArr[0],
        's_dag_area_k'  => $totalSettlementAreaArr[1],
        's_dag_area_lc' => $totalSettlementAreaArr[2],
        's_dag_area_g'  => $totalSettlementAreaArr[3],
        's_dag_area_kr' => 0,

        //****user info update */
        'user_code'     => $this->session->userdata('user_code'),
        'year_no'       => date('Y'),
        'date_entry'    => date('Y-m-d'),
        'land_type'     => $landTypeUpdate,
      ];

      $this->db->where('case_no', $case_no);
      $this->db->where('id', $id);
      $this->db->where('dag_no', $dag_no);
      $this->db->update('settlement_dag_details', $areaUpdateArr);

      //*******check if data updated */
      if ($this->db->affected_rows() != 1) {
        $this->db->trans_rollback();
        log_message('error', '#UPDTAREDTLS3658: Update fail in settlement_dag_details ' . $case_no);
        $data = array(
          'responseType' => 0,
          'msg'          => "#UPDTAREDTLS3658: Update fail in settlement_dag_details : " . $case_no,
        );
        echo json_encode($data);
        return false;
      }


      //checking settlement--reservation or not=====
      $total_settlement_reservation = 0;
      $reservation = $this->db->query("Select * from settlement_reservation where case_no='$case_no' and dag_no='$dag_no' and is_deleted =0")->row();
      if(!empty($reservation))
      {
        if (in_array($distCode, json_decode(BARAK_VALLEY))) {
            $total_settlement_ganda_home = $this->ncutility->Total_ganda($reservation->bigha, $reservation->katha, $reservation->lessa, $reservation->ganda);
              $total_settlement_reservation = (float)$total_settlement_ganda_home;

        } else {

            $total_settlement_lessa_home = $this->ncutility->Total_Lessa($reservation->bigha, $reservation->katha, $reservation->lessa);
              //*************Total settlement area */
              $total_settlement_reservation = (float)$total_settlement_lessa_home;
              
        }
      }
      if(in_array($distCode, json_decode(BARAK_VALLEY))) {
        $total_settlement_lessa = $total_settlement_ganda;
      }else{
        $total_settlement_lessa = $total_settlement_lessa;
      }


      $total_settlement_lessa = $total_settlement_lessa - $total_settlement_reservation;
      if($total_settlement_lessa <= 0)
      {
        $this->db->trans_rollback();
        log_message('error', '#UPDTAREDTLS5461: Update fail in settlement_dag_details ' . $case_no);
        $data = array(
          'responseType' => 0,
          'msg'          => "#UPDTAREDTLS5461: Please verify the area details before proceed for the : " . $case_no,
        );
        echo json_encode($data);
        return false;
      }
      /////////end reservation check////////



      //////////////proceeding for justification in area change///////////
      //////proceeding start//////
        $proceeding_id=$this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

        if ($proceeding_id==null) {
            $proceeding_id=1;
        }
        if($justification_area_change == null || $justification_area_change == '')
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRUPDTAREA318531: justification_area_change field missing for case no :'. $case_no);
            $json = [
                'errorMessage'=>"#ERRUPDTAREA318531: Area update failed for Case No : ".$case_no
            ];
            echo json_encode($json);
            return false;
        }
        $insPetProceed = [
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'note_on_order' => $justification_area_change,
            'status' => 'W',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d h:i:s'),
            'operation' => 'E',
            'ip' => $this->utilityclass->get_client_ip(),
            'office_from' => 'CO',
            'office_to' => 'CO',
            'task' => 'Area change justification'
        ];
        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);
        if ($insertProceeding != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRUPDTAREA3185: Insertion failed in settlement_proceeding for case no :'. $case_no);
            $json = [
                'errorMessage'=>"#ERRUPDTAREA3185: Area update failed for Case No : ".$case_no
            ];
            echo json_encode($json);
            return false;
        }






      //******* premium update start**************
      $this->db->select('*');
      $this->db->from('settlement_premium');
      $this->db->where('is_final', 1);
      $this->db->where('case_no', $case_no);
      $this->db->where('dag_no', $dag_no);
      $query = $this->db->get();

      if ($query->num_rows() > 0) 
      {
        $data = $query->result_array();

        foreach ($data as $row)
        {

          $this->db->set('is_final', 0);
          $this->db->where('is_final', 1);
          $this->db->where('case_no', $case_no);
          $this->db->where('dag_no', $dag_no);
          $this->db->update('settlement_premium');

          if ($this->db->affected_rows() != 1)
          {
            $this->db->trans_rollback();
            log_message('error', '#ERRSET5000311: Premium Updation failed for Case No '.$case_no);
            $data = array(
              'error'=>"#ERRSET5000311: Updation Settlement failed for case no : ".$case_no
            );
            echo json_encode($data);
            return false;
          }
          //reclassification amount calculation///////
          $recls_dag_amount =0;
          $ins_reclass_amount =0;
          if($row['reclassification_amount_used_or_not'] == null || $row['reclassification_amount_used_or_not'] == '')
          {
            $this->db->trans_rollback();
            log_message('error', '#ERRSETRCLSNOTFOND5000311: Premium Updation failed for Case No '.$case_no);
            $data = array(
              'error'=>"#ERRSETRCLSNOTFOND5000311: Calculation wrong from LRA end for case no : ".$case_no
            );
            echo json_encode($data);
            return false;
          }
          if($row['reclassification_amount_used_or_not']=='Y')
          {
            $ins_reclass_amount  = $row['ins_reclass_amount'];
            $recls_dag_amount    = ($row['ins_reclass_amount'] / $row['total_lessa']) * $total_settlement_lessa;
          }
          log_message('error','land revenue'. ceil($row['land_revenue_years']));
          $originalDagAmount   = ($row['amount_dag'] - $row['ins_reclass_amount'] - ceil($row['land_revenue_years']));
          $dag_amount_orig     = ($originalDagAmount / $row['total_lessa']) * $total_settlement_lessa;
          $dag_amount          = $dag_amount_orig + $recls_dag_amount + ceil($row['land_revenue_years']);
          $tot_dag_amount      = $dag_amount;
          $final_amount        = ($row['final_amount'] - $row['amount_dag']) + $tot_dag_amount;
          $row['amount_dag']   = $dag_amount;
          $row['final_amount'] = $final_amount;
          $row['due_amount']   = $final_amount;
          $row['total_lessa']  = $total_settlement_lessa;
          $row['ins_reclass_amount']   = $recls_dag_amount;
          $row['user_code']    = $this->session->userdata('user_code');
          $row['date_entry']   = date('Y-m-d h:i:s');
          unset($row['pid']);
          $this->db->insert('settlement_premium', $row);

          // echo $this->db->last_query(); die;

          if ($this->db->affected_rows() == 0)
          {
            $this->db->trans_rollback();
            log_message('error', '#ERRSET6000312: Premium Updation failed for Case No '.$case_no);
            $data = array(
              'error'=>"#ERRSET6000312: Updation Settlement failed for case no : ".$case_no
            );
            echo json_encode($data);
            return false;
          }

          $this->db->set('final_amount', $final_amount);
          $this->db->set('due_amount', $final_amount);
          $this->db->where('is_final', 1);
          $this->db->where('case_no', $case_no);
          // $this->db->where('dag_no', $dag_no);
          $this->db->update('settlement_premium');

          // var_dump($this->db->affected_rows()); die;

          if ($this->db->affected_rows() == 0)
          {
            $this->db->trans_rollback();
            log_message('error', '#ERRSET7000313: Premium Updation failed for Case No '.$case_no);
            $data = array(
              'error'=>"#ERRSET7000313: Updation Settlement failed for case no : ".$case_no
            );
            echo json_encode($data);
            return false;
          }
        }


        // if ($this->db->affected_rows() == 0)
        // {
        //   $this->db->trans_rollback();
        //   log_message('error', '#ERRSET9000311: Premium Updation failed for Case No '.$case_no);
        //   $data = array(
        //     'error'=>"#ERRSET9000311: Updation Settlement failed for case no : ".$case_no
        //   );
        //   echo json_encode($data);
        //   return false;
        // }
      }

      //******* premium update end**************

      //*******insertion in settlement_area_history**************

      $settlementAreaHistoryArr = [
        'created_at'                            => date('Y-m-d'),
        //****Applied area */
        'actual_encroachment_area_home_bigha'   => $this->input->post('enc_bigha_home'),
        'actual_encroachment_area_home_katha'   => $this->input->post('enc_katha_home'),
        'actual_encroachment_area_home_lessa'   => $this->input->post('enc_lessa_home'),
        'actual_encroachment_area_home_ganda'   => $this->NcCommonModel->defaultValue($this->input->post('enc_ganda_home'), 0),
        'actual_encroachment_area_home_kranti'  => $this->NcCommonModel->defaultValue($this->input->post('enc_kranti_home'), 0),

        'actual_encroachment_area_agri_bigha'   => 0,
        'actual_encroachment_area_agri_katha'   => 0,
        'actual_encroachment_area_agri_lessa'   => 0,
        'actual_encroachment_area_agri_ganda'   => 0,
        'actual_encroachment_area_agri_kranti'  => 0,

        //*****total Applied area */
        'total_actual_encroachment_area_bigha'  => $totalEncroachmentAreaArr[0],
        'total_actual_encroachment_area_katha'  => $totalEncroachmentAreaArr[1],
        'total_actual_encroachment_area_lessa'  => $totalEncroachmentAreaArr[2],
        'total_actual_encroachment_area_ganda'  => $totalEncroachmentAreaArr[3],
        'total_actual_encroachment_area_kranti' => 0,
        //*******setttlement_area */
        'settlement_area_home_bigha'            => $this->input->post('enc_bigha_home'),
        'settlement_area_home_katha'            => $this->input->post('enc_katha_home'),
        'settlement_area_home_lessa'            => $this->input->post('enc_lessa_home'),
        'settlement_area_home_ganda'            => $this->NcCommonModel->defaultValue($this->input->post('enc_ganda_home'), 0),
        'settlement_area_home_kranti'           => $this->NcCommonModel->defaultValue($this->input->post('enc_kranti_home'), 0),

        'settlement_area_agri_bigha'            => 0,
        'settlement_area_agri_katha'            => 0,
        'settlement_area_agri_lessa'            => 0,
        'settlement_area_agri_ganda'            => 0,
        'settlement_area_agri_kranti'           => 0,

        //*****total settlement_area */
        'total_settlement_area_bigha'           => $totalSettlementAreaArr[0],
        'total_settlement_area_katha'           => $totalSettlementAreaArr[1],
        'total_settlement_area_lessa'           => $totalSettlementAreaArr[2],
        'total_settlement_area_ganda'           => $totalSettlementAreaArr[3],
        'total_settlement_area_kranti'          => 0,
        //******leftout area */
        'leftout_area_home_bigha'               => $leftOutAreaHomeArr[0],
        'leftout_area_home_katha'               => $leftOutAreaHomeArr[1],
        'leftout_area_home_lessa'               => $leftOutAreaHomeArr[2],
        'leftout_area_home_ganda'               => $leftOutAreaHomeArr[3],
        'leftout_area_home_kranti'              => 0,
        'leftout_area_agri_bigha'               => 0,
        'leftout_area_agri_katha'               => 0,
        'leftout_area_agri_lessa'               => 0,
        'leftout_area_agri_ganda'               => 0,
        'leftout_area_agri_kranti'              => 0,
        //****total leftout area */
        'total_leftout_area_bigha'              => $totalLeftOutAreaArr[0],
        'total_leftout_area_katha'              => $totalLeftOutAreaArr[1],
        'total_leftout_area_lessa'              => $totalLeftOutAreaArr[2],
        'total_leftout_area_ganda'              => $totalLeftOutAreaArr[3],
        'total_leftout_area_kranti'             => 0,
      ];

      $this->db->where('case_no', $case_no);
      $this->db->where('application_no', $application_no);
      $this->db->where('dag_no', $dag_no);
      $this->db->update('settlement_area_history', $settlementAreaHistoryArr);

      //*******check if data updated */
      if ($this->db->affected_rows() == 0) {
        $this->db->trans_rollback();
        log_message('error', '#UPDTAREDTLS3821: Update fail in settlement_area_history ' . $case_no);
        $data = array(
          'responseType' => 0,
          'msg'          => "#UPDTAREDTLS3821: Update fail in settlement_area_history : " . $case_no,
        );
        echo json_encode($data);
        return false;
      }

      //////proceeding start//////
      $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;

      if ($proceeding_id == null) {
        $proceeding_id = 1;
      }

      $insPetProceed = [
        'case_no'              => $case_no,
        'proceeding_id'        => $proceeding_id,
        'date_of_hearing'      => date('Y-m-d h:i:s'),
        'next_date_of_hearing' => date('Y-m-d h:i:s'),
        'note_on_order'        => 'Area Updated',
        'status'               => 'W',
        'user_code'            => $this->session->userdata('user_code'),
        'date_entry'           => date('Y-m-d h:i:s'),
        'operation'            => 'E',
        'ip'                   => $this->utilityclass->get_client_ip(),
        'office_from'          => 'CO',
        'office_to'            => 'CO',
        'task'                 => 'CO has changed the Area',
        'note_type'            => null,
      ];
      $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

      // echo $this->db->last_query(); die();
      if ($insertProceeding != 1) {
        $this->db->trans_rollback();
        log_message('error', '#ERRORPP: Insertion failed in settlement_proceeding for case no :' . $case_no);
        $json = [
          'errorMessage' => "#ERRORPP: Failed to forward the case for Case No : " . $case_no,
        ];
        echo json_encode($json);
        return false;
      }
      //////proceeding end//////

      $this->db->trans_commit();

      //*****getting the total applied area from db to check if it exceeds any area conditions*/
      $sql = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ?", array($case_no));

      if ($sql->num_rows() <= 0) {
        $this->db->trans_rollback();
        $data = array(
          'responseType' => 0,
          'msg'          => "#FETCH0001: Error in fetching data from settlement_dag_details ! . $case_no",
        );
        echo json_encode($data);
        return false;
      }

      $fresh_area_details = $sql->result();

      $total_settlement_home_lessa = 0;
      $total_settlement_home_ganda = 0;
      $total_settlement_agri_ganda = 0;
      $total_settlement_agri_lessa = 0;

      foreach ($fresh_area_details as $fresh_area) {

        $settlement_area_home_bigha = (float)$fresh_area->applied_b;
        $settlement_area_home_kahta = (float)$fresh_area->applied_k;
        $settlement_area_home_lessa = (float)$fresh_area->applied_lc;
        $settlement_area_home_ganda = (float)$fresh_area->applied_g;

        if (in_array($distCode, json_decode(BARAK_VALLEY))) {
          //****total settlement area in all dags */
          $total_settlement_home_ganda = $total_settlement_home_ganda + $this->ncutility->Total_ganda($settlement_area_home_bigha, $settlement_area_home_kahta, $settlement_area_home_lessa, $settlement_area_home_ganda);
        } else {
          //****total settlement area in all dags */
          $total_settlement_home_lessa = $total_settlement_home_lessa + $this->ncutility->Total_Lessa($settlement_area_home_bigha, $settlement_area_home_kahta, $settlement_area_home_lessa);
        }
      }

      if (in_array($distCode, json_decode(BARAK_VALLEY))) {
        $total_settlement_area_home_formated = $this->ncutility->Total_Bigha_Katha_Lessa2($total_settlement_home_ganda);
      } else {
        $total_settlement_area_home_formated = $this->ncutility->Total_Bigha_Katha_Lessa($total_settlement_home_lessa);
      }

      //**** if data intserted successfully*/
      $data = array(
        'responseType'            => 2,
        'totalSettlementAreaHome' => $total_settlement_area_home_formated,
        'totalSettlementAreaAgri' => 0,
        'appnData'                => $areaUpdateArr,
        'msg'                     => "Area updated successfully...",
      );
      echo json_encode($data);
    }


    public function paymentNoticeCo()
    {
        $status = $this->input->get('s');
        $service_code = $this->input->get("service");
        $data['getPaymentNoticeCo'] = $this->SettlementMbModel->getPaymentNoticeCo($service_code);
        $data['select_data'] = $this->SettlementCommonModel->locationSelect($service_code, $status);
        $dist_code = $this->session->userdata('dist_code');
        if ($service_code == 45) {
            if (in_array($dist_code, json_decode(PAYMENT_NOTICE_BULK_REQUEST_DIST))) {
                return $this->paymentNoticeCoNew();
            }
        }

        $data['_view'] = 'settlement_mb/payment_notice_co';
        $this->load->view('layouts/main', $data);
    }

    public function paymentNoticeCoNew()
    {
        // exit;
        $status = $this->input->get('s');
        $service_code = $this->input->get("service");
        $data['getPaymentNoticeCo'] = $this->SettlementMbModel->getPaymentNoticeCo($service_code);
        $data['select_data'] = $this->SettlementInsModel->locationSelectIns($service_code, $status);
        if($this->session->userdata('user_desig_code') != 'CO')
        {
            log_message('error', '#ERROR99003987656: Undefined User... '. $case_no);
           
            $this->session->set_flashdata('message',"#ERR6776: User not authenticated. Payment notice can only be generated by the Circle Officer.");
            redirect(base_url() . 'index.php/home/index');
        }
        $data['_view'] = 'settlement_mb/payment_notice_co_new_ins';
        $this->load->view('layouts/main', $data);
    }

    /// NEW LIST FOR RE_GEOTAG ----------------27022025
    public function reGeoTagCaseList()
    {
        // exit;
        $service_code = $this->input->get('service');
        $status = 'Z'; // in query it is checked as not equal to Z status/////
        $data['select_data'] = $this->SettlementCommonModel->locationSelectReGeotag($service_code, $status);
        $data['_view'] = 'settlement_mb/settlement_mb_re_geotag_ins';
        $this->load->view('layouts/main', $data);
    }

    public function checkWhetherGeoTagorNot()
    {
        $case_no = $this->input->post('case_no');
        $applid = $this->input->post('applid');

        if($case_no == null && $applid == null){
            echo json_encode([
                'responseType' => 3,
                'msg' => '#ERRREGEO0002: Enable Re-geotag cancelled...!case no missing',
            ]);
            return false;
        }
        $url = API_LINK_MB3."requestRegeo";

        $arrayData =array(
            'application' => $applid,
        );
        log_message("error","MB001: CALLING URL=======".$url."===PARAMETER===".json_encode($arrayData));
        //*****API call again for geotag available */
        $getAvailable = $this->utilityclass->curlPost($url, $arrayData);


        if(isset($getAvailable) && !empty(json_decode($getAvailable)) && trim(json_decode($getAvailable)->status) == 'y'){
             //*****update in settlement_basic */
            $basicArray = [
                're_geotag_status'   => 1
            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $basicArray);
            if($this->db->affected_rows() !=1)
            {
                log_message('error', '#ERRREGEOINS0001: Updating failed in settlement_basic and query is: ' . $this->db->last_query());
                echo json_encode([
                    'responseType' => 3,
                    'msg' => '#ERRREGEOINS0001: Enable Re-geotag cancelled...!',
                ]);
                return false;
            }
            if($this->db->affected_rows() == 1 && trim(json_decode($getAvailable)->status) == 'y') {
                echo json_encode([
                    'responseType' => 2,
                    'msg' => 'Requested for Re-geotag for the case no --'.$case_no,
                ]);
                return false;
            }


        }else{
            log_message('error', '#ERRREGEOINS0003: Fetching data error');
            echo json_encode([
                'responseType' => 3,
                'msg' => '#ERRREGEOINS0003: Fetching data error',
            ]);
            return false;
        }

    }

    public function coRejectCases()
    {

        $service_code = $this->input->get('service');
        $status = $this->input->get('s');
        $data['select_data'] = $this->SettlementCommonModel->locationSelectCoRejectCases($service_code, $status);
        $data['_view'] = 'settlement_mb/co_reject_cases_ins';

        $this->load->view('layouts/main', $data);
    }

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

        $this->db->select('distinct(a.case_no), a.applid, a.service_code, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry,b.lm_note,sid.ins_cat_type_co,b.already_alloted');
        $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
        $this->db->join('settlement_premium p', 'a.case_no = p.case_no');
        $this->db->join('settlement_institution_details sid', 'a.case_no = sid.case_no');
        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
        $this->db->where('a.status', $status);
        $this->db->where('p.is_final', 1);
        $this->db->where('a.pending_officer', MB_CIRCLE_OFFICER);
        //for urban case------------
        if ($urban_rural == 'U') {
            $this->db->where('a.approve_by', 'GOVT');
        } else if ($urban_rural == 'R') {
            $this->db->where('a.approve_by', 'DC');
        } else {
            // $this->db->where('a.approve_by', 'GOVT');
        }

        $this->db->from('settlement_basic a');

        $query = $this->db->get();

        log_message('error','------------'.$this->db->last_query());

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {

                

                if (trim($rows->lm_note) == 1) {
                    $lmnoteRemark = 'Recommended';
                } else {
                    $lmnoteRemark = 'Not Recommended';
                }


                if($rows->ins_cat_type_co == 8)
                {
                    $paymentNoticeLink = '<a type="button" href="' . base_url() . 'index.php/SettlementInstitutionCo/generatePaymentNoticeCo?case=' . enc_param('case', $rows->case_no, 600) . '" class="lmreportmut btn-sm btn btn-danger mt-1">
                        Forward for Chitha Update</a>';
                }
                else
                {
                    $paymentNoticeLink = '<a type="button" href="' . base_url() . 'index.php/SettlementInstitutionCo/generatePaymentNoticeCo?case=' . enc_param('case', $rows->case_no, 600) . '" class="lmreportmut btn-sm btn btn-primary mt-1">Payment Notice</a>';
                }
                

                

                if ($status == MB_PAYMENT_REQUEST) {
                    

                    $ins_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . enc_param('case', $rows->case_no, 600) . '">
                        <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>
                        <br>
                        ' . $paymentNoticeLink;

                
                }
                $ruralYesNo = "---";
                $case_type = $this->checkDepartmentDC($rows->case_no);
                $allotment_settlement = $this->checkAllotmentOrSettlement($rows->case_no);
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
                    $allotment_settlement,
                    $ins_link

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

            if ($urban_rural == 'U') {
                $this->db->where('a.approve_by', 'GOVT');
            } else if ($urban_rural == 'R') {
                $this->db->where('a.approve_by', 'DC');
            } else {
                // $this->db->where('sb.approve_by', 'GOVT');
            }

            //for urban case------------
            $this->db->select('distinct(a.case_no), a.applid, a.service_code, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry,b.lm_note,sid.ins_cat_type_co,b.already_alloted');
            
            $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
            $this->db->join('settlement_premium p', 'a.case_no = p.case_no');
            $this->db->join('settlement_institution_details sid', 'a.case_no = sid.case_no');
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));
            $this->db->where('a.status', $status);
            $this->db->where('a.pending_officer', MB_CIRCLE_OFFICER);
            $this->db->where('p.is_final', 1);
            $this->db->from('settlement_basic a');
            $query = $this->db->get();
            // $total_records = $this->db->count_all_results('settlement_basic a');
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

    public function paymentNoticeCofirmationCases()
    {
        $service_code = $this->input->get('service');
        $status = $this->input->get('s');
        $data['getPaymentConfirmationCo'] = $this->SettlementInsModel->getPaymentConfirmationCo($service_code);
        $data['select_data'] = $this->SettlementInsModel->locationSelectIns($service_code, $status);
        $data['_view'] = 'settlement_mb/paymentConfirmationCasesIns';
        $this->load->view('layouts/main', $data);
    }

    public function checkAllotmentOrSettlement($case_no)
    {
        $sql = $this->db->query('select already_alloted,ins_cat_type_co from settlement_institution_details sin join settlement_ap_lmnote sal on sin.case_no = sal.case_no where sin.case_no = ?', array($case_no));
        $alltRow = $sql->row();
        if(!empty($alltRow))
        {
            $ins_cat_type_co = $alltRow->ins_cat_type_co;
            $already_alloted = $alltRow->already_alloted;
            if($ins_cat_type_co == 8)
            {
                $type = 'Allotment';
            }
            else if(($ins_cat_type_co == 9 || $ins_cat_type_co == 12) && $already_alloted == 'N')
            {
                $type = 'Allotment';
            }
            else if(($ins_cat_type_co == 8 || $ins_cat_type_co == 9 || $ins_cat_type_co == 12) && $already_alloted == 'Y')
            {
                $type = 'Settlement';
            }
            else if($ins_cat_type_co == 10  || $ins_cat_type_co == 11)
            {
                $type = 'Transfer';
            }
            return $type;
        }
        else
        {
            return null;
        }
    }

    public function checkDepartmentDC($case_no)
    {
        $sql = $this->db->query('select settlement_institution_details.ins_cat_type_co,settlement_dag_details.is_urban,settlement_institution_details.central_health_education_skill_sector,settlement_institution_details.state_warehousing_corporation,settlement_institution_details.central_cwc_sector from settlement_institution_details join settlement_dag_details on settlement_institution_details.case_no =settlement_dag_details.case_no where settlement_institution_details.case_no = ?', array($case_no));
        $alltRow = $sql->row();
        if(!empty($alltRow))
        {
            if($alltRow->ins_cat_type_co == 8 && strtoupper($alltRow->is_urban) == 'N')
            {
                $finalApprovedBy = 'DC';
            }
            else if($alltRow->ins_cat_type_co == 9 && strtoupper($alltRow->is_urban) == 'N' && $alltRow->state_warehousing_corporation == 'Y' && $already_alloted == 'N')
            {
                $finalApprovedBy = 'DC'; //dc
            }
            else if($alltRow->ins_cat_type_co == 10 && strtoupper($alltRow->is_urban) == 'N' && $alltRow->central_health_education_skill_sector == 'Y')
            {
                $finalApprovedBy = 'DC'; //dc
            }
            else if($alltRow->ins_cat_type_co == 11 && strtoupper($alltRow->is_urban) == 'N' && $ins_basic->central_cwc_sector == 'Y')
            {
                $finalApprovedBy = 'DC'; //dc
            }
            else
            {
                $finalApprovedBy = 'DEPARTMENT'; //dc
            }
            return $finalApprovedBy;
        }
        else
        {
            return null;
        }
    }

    public function generatePaymentNoticeCo()
    {
        if(isset($_GET['case'])){
            $_GET['case'] = dec_param($this->input->get('case'), 'case');
            if($_GET['case'] == null)
            {
                echo json_encode('Sorry !! You are not Authorized to access the content!!');
                return;
            }
            $case_no = $_GET['case'];
            $case_under_wetland = $this->SettlementCommonModel->caseUnderDeptOrDCByWetLand($case_no);

            $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);

            // if($case_under_wetland == 1 && $get_settlement_basic->is_wed_land == 1 && $get_settlement_basic->from_office == 'DPT')
            // {
            //     log_message('error', '#ERROR1460: Dag no. wetland flag modified kindly do modification request for case no '. $case_no. 'and query is '.$this->db->last_query());
            //     $error_msg_new = array('status'=>1,'message'=>'#ERROR1460: Dag no. found as wetland area please check chitha dag flag for case no'.$case_no);
            //     $this->session->set_flashdata('message',"--".$error_msg_new['message']);
            //     redirect(base_url() . 'index.php/home/index');
            // }

            // if($case_under_wetland == 1 && $get_settlement_basic->is_wed_land == 0 && $get_settlement_basic->from_office == 'DPT')
            // {
            //     log_message('error', '#ERROR1460: Dag no. wetland flag modified kindly do modification request for case no '. $case_no. 'and query is '.$this->db->last_query());
            //     $error_msg_new = array('status'=>1,'message'=>'#ERROR1460: Dag no.found as wetland area please check chitha dag flag for case no'.$case_no);
            //     $this->session->set_flashdata('message',"--".$error_msg_new['message']);
            //     redirect(base_url() . 'index.php/home/index');
            // }

            // if($case_under_wetland == 0 && $get_settlement_basic->is_wed_land == 1 && $get_settlement_basic->from_office == 'DPT')
            // {
            //     //   ********** update basic wetland******* and insert into proceeding
            //     $this->db->trans_begin();

            //     $basicUpdateArr = [
            //         'is_wed_land' => 0,
            //         'date_update' => date('Y-m-d H:i:s'),
            //     ];

            //     $this->db->where('case_no', $case_no);
            //     $this->db->update('settlement_basic', $basicUpdateArr);

            //     if($this->db->affected_rows() != 1)
            //     {
            //         $this->db->trans_rollback();
            //         log_message('error', '#ERROR1490: Unable to update settlement_basic '. $case_no. 'and query is '.$this->db->last_query());
            //         $error_msg_new = array('status'=>1,'message'=>'#ERROR1490: Unable to process for case no'.$case_no);
            //         $this->session->set_flashdata('message',"--".$error_msg_new['message']);
            //         redirect(base_url() . 'index.php/home/index');
            //     }

            //     //*****insert into proceeding */
            //     //////proceeding start//////
            //     $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
            //     if ($proceeding_id == null) {
            //         $proceeding_id = 1;
            //     }

            //     $insertArr = [
            //         'case_no' => $case_no,
            //         'proceeding_id' => $proceeding_id,
            //         'date_of_hearing' => date('Y-m-d h:i:s'),
            //         'next_date_of_hearing' => date('Y-m-d h:i:s'),
            //         'note_type' => 'Wetland flag updated',
            //         'note_on_order' => 'Wetland flag updated',
            //         'status' => 'W',
            //         'user_code' => $this->session->userdata('user_code'),
            //         'date_entry' => date('Y-m-d h:i:s'),
            //         'operation' => 'E',
            //         'ip' => $this->utilityclass->get_client_ip(),
            //         'office_from' => 'CO',
            //         'office_to' => 'CO',
            //         'task' => 'Wetland flag updated',
            //     ];

            //     $insertProc = $this->db->insert('settlement_proceeding', $insertArr);

            //     if ($insertProc != 1)
            //     {
            //         $this->db->trans_rollback();
            //         log_message('error', '#ERROR1523: Unable to update settlement_proceeding '. $case_no. 'and query is '.$this->db->last_query());

            //         $error_msg_new = array('status'=>1,'message'=>'#ERROR1523: Unable to process for case no'.$case_no);
            //         $this->session->set_flashdata('message',"--".$error_msg_new['message']);
            //         redirect(base_url() . 'index.php/home/index');
            //     }

            //     $this->db->trans_commit();
            // }

            // //check whether dag in wetland--------------
            // if($case_under_wetland == 1){
            //     // $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
            //     if($get_settlement_basic->from_office != 'DPT'){
            //         log_message('error', '#ERROR990039876: Dag no. under wetland area and not approved by Dept Case No '. $case_no);
            //         $error_msg_new = array('status'=>1,'message'=>'#ERROR990039876: Dag no. under wetland area and not approved 
            //         by Department for case no'.$case_no);
            //         $this->session->set_flashdata('message',"--".$error_msg_new['message']);
            //         redirect(base_url() . 'index.php/home/index');
            //     }

            // }
            $finalAreaCheck = $this->SettlementCommonModel->finalAreaCheck($case_no);

            if($finalAreaCheck['responseType'] != 2)
            {
                log_message('error','finalAreaCheck========='.json_encode($finalAreaCheck));
                $this->session->set_flashdata('message',"--".$finalAreaCheck['msg']);
                redirect(base_url() . 'index.php/home/index');
            }

            $recalculatePremiumCheck = $this->SettlementInsModel->premiumReCalculationForIns($case_no);

            if($recalculatePremiumCheck!=null && $recalculatePremiumCheck['status'] == 1)
            {
                log_message('error', '#ERRORRECALC99003: Unable to re calculate premium. Response===='.json_encode($recalculatePremiumCheck));
                $this->session->set_flashdata('message',"--".$recalculatePremiumCheck['message']);
                redirect(base_url() . 'index.php/home/index');

            }

            $premium_data = $this->db->query("SELECT * from settlement_premium where case_no='$case_no' and is_final=1")->result();
            $data['premium_data'] = $premium_data;

            $data['basic'] = $this->SettlementApModel->getSettlementBasicCo($case_no);
            $data['dags'] = $this->db->query("select sd.*,sr.bigha,sr.katha,sr.lessa,sr.ganda,sr.is_deleted,sp.total_lessa from settlement_dag_details sd 
            left join (select * from settlement_reservation where is_deleted=0) sr 
            on sd.case_no = sr.case_no and sr.dag_no = sd.dag_no
            join (select total_lessa,case_no,dag_no from settlement_premium where is_final=1) sp on sp.case_no=sd.case_no and sp.dag_no=sd.dag_no 
            where sd.case_no='$case_no'")->result();

            //*******general caste or reserve caste check */

            // $data['caste'] = $get_settlement_basic->caste;
            $data['applid'] = $get_settlement_basic->applid;

            $applicants_buyers   = $this->SettlementInsModel->getAllApplicantBuyers($case_no);

            foreach($applicants_buyers as $applicant)
            {
                if($applicant->is_applicant == 1)
                {
                    $data['if_widow'] = $applicant->marital_status;
                }
            }



            $data['concessionCheck'] = false;
            $concenSql = $this->db->query('select concession from settlement_premium where case_no = ? and is_final = ? limit 1', array($case_no, 1));


            $sql = $this->db->query('select sid.*,imc.category_name from settlement_institution_details sid join ins_master_category imc on sid.ins_cat_type::int = imc.id  where case_no = ?', array($case_no));

            $data['ins_data'] = $sql->result();
            $data['instituteDetails'] = $this->SettlementInsModel->getInstitutionDetails($case_no);
            $data['old_dag_flag_message'] = false;
            $data['land_class_groups'] = $this->SettlementInsModel->getLandGroups();

            $apLmnoteDetails = $this->db->query('select * from settlement_ap_lmnote where case_no = ? order by id desc limit 1', array($case_no))->row();
            $data['apLmnoteDetails'] = $apLmnoteDetails;

            $registration_document = $this->db->query("Select * from supportive_document where case_no='$case_no' and file_name='Registrationdocument'")->row();
            $data['registration_document'] = $registration_document;

            if($this->session->userdata('user_desig_code') != 'CO')
            {
                log_message('error', '#ERROR99003987656: Undefined User... '. $case_no);
               
                $this->session->set_flashdata('message',"#ERR6776 : User not Authenticated !!!Payment notice only CO can generate");
                redirect(base_url() . 'index.php/home/index');
            }
            $data['_view'] = 'SettlementView/Co/Ins/generateNoticeViewNew';
            $this->load->view('layouts/main', $data);
        }

    }
    

    public function generatePaymentNoticeCoSave()
    {
        $case_no = $this->input->post('case_no');
        $remark = $this->input->post('remark_co');
        $insCatTypeCo = $this->input->post('ins_cat_type');

        ///registration_acknowledge
        $registration_info = null;

        // if(NIJE_OFFER_OF_ALLOTMENT_SETTLEMENT ==1 && NIJE_OFFER_OF_ALLOTMENT_SETTLEMENT_DATE <= date('Y-m-d'))
        // {
        //     if($insCatTypeCo==12)
        //     {
        //         $registration_info = $this->input->post('registration_info');
        //         if(empty($registration_info))
        //         {
        //             $this->session->set_flashdata('message', "#NOTE1000122: Registration status (Yes/No) is missing for the case no # ".$case_no);
        //             redirect(base_url() . "index.php/SettlementInstitutionCo/generatePaymentNoticeCo?case=".enc_param('case', $case_no, 600));
        //             return;
        //         }
        //     }
            
        //     // if($registration_info == 'YES')
        //     // {
        //     //     $acknowledgment_no = $this->input->post('acknowledgment_no');
        //     //     if(empty($acknowledgment_no))
        //     //     {
        //     //         $this->session->set_flashdata('message', "#NOTE1000122: acknowledgment details missing for the case no # ".$case_no);
        //     //         redirect(base_url() . "index.php/home");
        //     //         return;
        //     //     }
        //     // }
        // }
        



        $applicant_buyer = $this->SettlementInsModel->getAllApplicantBuyers($case_no);
        $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
        $insDetails = $this->SettlementInsModel->getInstitutionDetails($case_no);
        $apLmnoteDetails = $this->db->query('select * from settlement_ap_lmnote where case_no = ? order by id desc limit 1', array($case_no))->row();
        $data['instituteDetails'] = $insDetails;

        $registrationData = $this->db->query("Select * from supportive_document where case_no='$case_no' and file_name='Registrationdocument'")->row();

        if($insDetails->ins_cat_type_co != $insCatTypeCo)
        {
            $this->session->set_flashdata('message', "#NOTE10001: Unable to process due to category mis match request active # ".$case_no);
            redirect(base_url() . "index.php/home");
            return;
        }

        if($insDetails->ins_cat_type_co == '8')
        {
            // $this->session->set_flashdata('message', "#NOTE1000145: For State Government Entity Coming soon!!! # ".$case_no);
            // redirect(base_url() . "index.php/home");
            // return;


            $this->db->trans_begin();
            $updateArr = [
                'status' => 'N',
                'co_code' => $this->session->userdata('user_code'),
                'user_code' => $this->session->userdata('user_code'),
                'pay_notice_gen_yn' => 'Y',
                'pay_notice_gn_date' => date('Y-m-d h:i:s'),
                'date_update' => date('Y-m-d h:i:s'),
                'from_office' => 'CO',
                'pending_officer' => 'CO',
                'pending_office' => 'CO',
                'co_notice_link' => null,
                // 'chitha_processing_details' => 2
            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $updateArr);
            if ($this->db->affected_rows() != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRNOPN0001: Updation Failed in settlement_basic table');
                $this->session->set_flashdata('message', "#KHASPAYAPI0015 Payment notice  could not be generated...");
                redirect(base_url() . 'index.php/SettlementInstitutionCo/generatePaymentNoticeCo?case=' . enc_param('case', $case_no, 600));
                return false;
            }

            
            $premData = [
                'grn_no' => 'NA',
                'is_full_pay' => 'Y',
                'total_premium' => 0,
                'paid_amount' => 0,
                'remaining_amount' => 0,
                'tenure' => 0,
                'installment_amount' => 0,
                'payment_date' => date('Y-m-d'),
                'grn_no' => 'NA',
                'premium_required' => 'N'
            ];
            $this->db->where('case_no', $case_no);
            $this->db->where('is_final', 1);
            $this->db->update('settlement_premium', $premData);
            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                log_message('error', '#ERRNOPN00056: Updation Failed in settlement_basic table');
                $this->session->set_flashdata('message', "#ERRNOPN00056 No applicable premium has not been completed...");
                redirect(base_url() . 'index.php/SettlementInstitutionCo/generatePaymentNoticeCo?case=' . enc_param('case', $case_no, 600));
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
                'note_on_order' => $remark,
                'status' => 'N',
                'user_code' => $this->session->userdata('user_code'),
                'date_entry' => date('Y-m-d h:i:s'),
                'operation' => 'E',
                'ip' => $this->utilityclass->get_client_ip(),
                'office_from' => 'CO',
                'office_to' => 'CO',
                'task' => 'Forwarded for Chitha Correction,No premium Required',
                'old_file_link' =>null,
            ];
            $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
            if ($insertProc != 1)
            {
                $this->db->trans_rollback();
                log_message('error', '#ERRNOPNINSN0002: Insertion failed in settlement_proceeding');
                $this->session->set_flashdata('message', "#ERRNOPNINSN0002 Something went wrong !!!...");
                redirect(base_url() . 'index.php/SettlementInstitutionCo/generatePaymentNoticeCo?case=' . enc_param('case', $case_no, 600));
                return false;
            }

            $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
            if(!$application_no)
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error #ERRAPI0011: Application No. not found for case no # $case_no");
                redirect(base_url() . "index.php/home");
            }
            $rmk='Forwarded to CO';
            $status='F';
            $task='CO';
            $pen='NA';
            $case=$case_no;
            $rtps_status=$this->SettlementApiModel->postApiBasundharaMb3($application_no, $case, $rmk, $status, $task, $pen);
            $rtps_status=json_decode($rtps_status);
            if (trim($rtps_status)!="y") 
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "Error #ERRAPI0011: Settlement Application not submitted case no # $case_no");
                redirect(base_url() . "index.php/home");
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Successfully forwarded to LRA. However, State Government Entity Applications Chitha correction will be done by CO, only after LRA verification is completed, please check in LRA login ");
                redirect(base_url() . 'index.php/Home/');
                return false;
            }
            

        }


        if($insCatTypeCo == '12' && empty($registrationData) )
        {

            if(NIJE_OFFER_OF_ALLOTMENT_SETTLEMENT ==1 && NIJE_OFFER_OF_ALLOTMENT_SETTLEMENT_DATE <= date('Y-m-d'))
            {
                if($insCatTypeCo==12)
                {
                    $registration_info = $this->input->post('registration_info');
                    if(empty($registration_info))
                    {
                        $this->session->set_flashdata('message', "#NOTE1000122: Registration status (Yes/No) is missing for the case no # ".$case_no);
                        redirect(base_url() . "index.php/SettlementInstitutionCo/generatePaymentNoticeCo?case=".enc_param('case', $case_no, 600));
                        return;
                    }
                }
                
                // if($registration_info == 'YES')
                // {
                //     $acknowledgment_no = $this->input->post('acknowledgment_no');
                //     if(empty($acknowledgment_no))
                //     {
                //         $this->session->set_flashdata('message', "#NOTE1000122: acknowledgment details missing for the case no # ".$case_no);
                //         redirect(base_url() . "index.php/home");
                //         return;
                //     }
                // }
            }

            if(NIJE_OFFER_OF_ALLOTMENT_SETTLEMENT == 1 && NIJE_OFFER_OF_ALLOTMENT_SETTLEMENT_DATE <= date('Y-m-d'))
            {
               
                $co_operative_registered = $this->input->post('co_operative_registered');
                $registration_no = $this->input->post('registration_no');
                $registration_date = $this->input->post('registration_date');
                $registration_date = date('Y-m-d', strtotime($registration_date));
                $registration_document = $_FILES['registration_document']['name'];
                $checkValRegistration = 'NO';
                if($co_operative_registered == 'Y')
                {
                    $checkValRegistration = 'YES';
                }
                if($registration_info != $checkValRegistration)
                {
                    $this->session->set_flashdata('message', "#ERR-REGISTRATION092145: Check Registration information available or not for case # {$case_no}");
                    redirect(base_url("index.php/home"));
                    return;
                }
                
                if($registration_info  == 'YES')
                {
                    if (!$this->isRegistrationDataValid($co_operative_registered, $registration_no, $registration_date,$registration_document,$case_no)) {
                        $this->session->set_flashdata('message', "#ERR-REGISTRATION0921: Invalid or missing registration information for case # {$case_no}");
                        redirect(base_url("index.php/home"));
                        return;
                    }
                }
                
            }
            else
            {
                $co_operative_registered = $this->input->post('co_operative_registered');
                $registration_no = $this->input->post('registration_no');
                $registration_date = $this->input->post('registration_date');
                $registration_date = date('Y-m-d', strtotime($registration_date));
                $registration_document = $_FILES['registration_document']['name'];
                if (!$this->isRegistrationDataValid($co_operative_registered, $registration_no, $registration_date,$registration_document,$case_no)) {
                    $this->session->set_flashdata('message', "#ERR-REGISTRATION0921: Invalid or missing registration information for case # {$case_no}");
                    redirect(base_url("index.php/home"));
                    return;
                }
                
            }
            
            
            
            
        }
           

        $data = [
            'case_no' => $case_no,
            'remark' => $remark,
            'get_settlement_basic' => $get_settlement_basic,
            'pay_notice_date' => date('Y-m-d'),
        ];

        if($get_settlement_basic->pull_request == '1')
        {
            $this->session->set_flashdata('message', "#NOTE10001: Unable to process due to modification request active # ".$case_no);
            redirect(base_url() . "index.php/home");
            return;
        }

        if(isset($applicant_buyer))
        {
            foreach($applicant_buyer as $applicant)
            {
                if($applicant->is_applicant == 1)
                {
                    $data['applicant_name'] = $applicant->pdar_name;
                    $data['guardian_name'] = $applicant->pdar_guardian;
                    $marital_status = $applicant->marital_status;
                }
            }
        }


        $basic = $this->SettlementInsModel->getSettlementBasic($case_no);

        if(isset($basic))
        {

            $data['case_no']                = $basic['case_no'];
            $data['application_no']         = $basic['applid'];

            $data['dist_name'] = $this->utilityclass->getDistrictName($basic['dist_code']);
            $data['circle_name'] = $this->utilityclass->getCircleName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
            $data['mouza_name'] = $this->utilityclass->getMouzaName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code']);

            $data['lot_name'] = $this->utilityclass->getLotName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no']);

            $data['village_name'] = $this->utilityclass->getVillageName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no'], $basic['vill_townprt_code']);

            if($basic['sdlac_date'] == null || $basic['sdlac_date'] == '' || empty($basic['sdlac_date']))
            {
                $this->session->set_flashdata('message', "#ERR203934: Unable to process! Something went wrong...#".$case_no);
                redirect(base_url().'index.php/home');
            }

            $data['date_of_sldc'] = date('d/m/Y', strtotime($basic['sdlac_date']));
            $data['dept_order_no'] = $basic['dept_order_no'];
            $data['dept_order_date'] = date('d/m/Y', strtotime($basic['dept_order_date']));
            $data['instituteDetails'] = $insDetails;
        }
        else
        {
            $this->session->set_flashdata('message', "#ERR1917: Unable to process! Something went wrong...#".$case_no);
            redirect(base_url().'index.php/home');
        }

        $dags = $this->SettlementInsModel->getSettlementDag($case_no);

        

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."getApplicationDate");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application_no' => $data['application_no'],
        )));
        $output = curl_exec($curl_handle);
        if(isset(json_decode($output)->responseType)){
            if(json_decode($output)->responseType != 'y'){
                echo json_decode($output)->data." - Unauthorized access!";
                return false;
            }
        }
        curl_close($curl_handle);
        $res = json_decode($output);


        $data['date_of_application'] = date('d/m/Y', strtotime($res->submission_date));
        $data['date'] = date('d/m/Y', strtotime(date('Y-m-d')));
        $data['payment_date'] = date('d/m/Y', strtotime($data['date']. ' + 15 days'));
        $data['actual_govt_notification_no'] = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
        $data['mission_govt_notification_no'] = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';


        $this->load->helper('qrcode');
        $base_64 = "iVBORw0KGgoAAAANSUhEUgAAAIwAAACMAQMAAACUDtN9AAAABlBMVEX///8AAABVwtN+AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAA/ElEQVRIidWVUQrDIBBEF/Kxx/AiglcP5CIew4/AdNZNS9O/NpOPSjD6BCXj7MTsv1sD0K0WrMYR+wuomi3d98LhMHM5Kti6o/vWR8M9iJPRbkT8ptVuQamXkX5I+D2aVztqoTin2xah2XwNdLKiCLXOQx3Tnq3L0YKRC9W4MNTIspoKJeOhh14/IvrPCrf3DWkWLWJlLgBLtL5KVIly3mDT4YdeQsQC4qSkQ6deUoQ0vRl7+DXUseHI2ZmIWpTytwiUSAM1ygRY5lPfA0aDasofYf48UYoiasP9LfQa1xH3znn+MtWIb+zhIpejNE8EIakcZekAxw2o0T+3BwGPvjKA6hujAAAAAElFTkSuQmCC";
        $data['qrcode'] = ','.$base_64;
        // echo "dd";die;

        if($insDetails->ins_cat_type_co == '12' && empty($registrationData))
        {

            /////////$regFileInsertFlag-THIS FLAG IS USE FOR GENERATING NOTICE WITHOUT REGISTRATION FROM THE 19-09-2025
            $regFileInsertFlag = false;
            if(NIJE_OFFER_OF_ALLOTMENT_SETTLEMENT == 1 && NIJE_OFFER_OF_ALLOTMENT_SETTLEMENT_DATE <= date('Y-m-d'))
            {
                if($registration_info == 'YES')
                {
                    $regFileInsertFlag = true;
                } 
            }
            else
            {
                $regFileInsertFlag = true;
            }

            if($regFileInsertFlag == true)
            {
                ////////////uploading registration details////////////
                $this->db->trans_begin();
                $registration_document_file = $_FILES['registration_document'];
                $timestamp = date('mdYhis', time()).uniqid();        
                $registration_file_name = 'field_report'.$timestamp;          
                $newFileNameFieldReport = preg_replace('/\s+/', '_', $registration_document_file['name']);
                $registration_doc_path = UPLOAD_DIR.$timestamp.$newFileNameFieldReport;
                $document= array(
                    'case_no'         => $case_no,
                    'file_name'       => 'Registrationdocument',
                    'user_code'       => $this->session->userdata('user_code'),
                    'fetch_file_name' => $registration_document_file['name'],
                    'file_type'       => $registration_document_file['type'],
                    'file_path'       => $registration_doc_path,
                    'date_entry'      => date('Y-m-d h:i:s'),
                    'mut_type'        => SLIJE_ID,
                    'api_doc_id'      => null,
                );

                $insert_supportive_doc= $this->db->insert('supportive_document', $document);
                if ($insert_supportive_doc != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRORREGPAY7152: Insertion failed in supportive_document for case no :'. $case_no);
                    $json = [
                        'errorMessage'=>"#ERRORREGPAY7152: Failed to upload document case for Case No : ".$case_no
                    ];
                    echo json_encode($json);
                    return false;
                }
                $config2['file_name']     = $registration_file_name;
                $config2['upload_path']   = UPLOAD_DIR;
                $config2['allowed_types'] = UPLOAD_ALLOW_TYPE;
                $config2['max_size']      = 2000;

                $this->load->library('upload', $config2);
                $this->upload->initialize($config2);

                if(!move_uploaded_file($registration_document_file['tmp_name'], $registration_doc_path)){
                    log_message('error', 'Unable to move field report file for case no '.$case_no);
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', "#ERRADDDOC000331: Only PDF and Image files area allowed : ".$application_no);
                    redirect(base_url() . "index.php/home");
                }
                
                $updateRegAr = [
                    'co_operative_registered' => $co_operative_registered,
                    'registration_no' => $registration_no,
                    'registration_date' => $registration_date,
                    // 'registration_acknowledge' => $registration_acknowledge,
                ];
                $this->db->where('case_no', $case_no);
                $this->db->update('settlement_ap_lmnote', $updateRegAr);
                if ($this->db->affected_rows() != 1) {
                    $this->db->trans_rollback();
                    log_message('error', '#ERR7136: Updation Failed in settlement_ap_lmnote table');
                    $this->session->set_flashdata('message', "#ERR7136 Payment notice  could not be generated...");
                    redirect(base_url() . 'index.php/SettlementInstitutionCo/generatePaymentNoticeCo?case=' . enc_param('case', $case_no, 600));
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
                    'note_on_order' => 'Registration information entered by CO',
                    'status' => 'N',
                    'user_code' => $this->session->userdata('user_code'),
                    'date_entry' => date('Y-m-d h:i:s'),
                    'operation' => 'E',
                    'ip' => $this->utilityclass->get_client_ip(),
                    'office_from' => 'CO',
                    'office_to' => 'CO',
                    'task' => 'Registration information verified',
                    'old_file_link' =>null,
                ];
                $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
                if ($insertProc != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERRNOPNINSN0002: Insertion failed in settlement_proceeding');
                    $this->session->set_flashdata('message', "#ERRNOPNINSN0002 Something went wrong !!!...");
                    redirect(base_url() . 'index.php/SettlementInstitutionCo/generatePaymentNoticeCo?case=' .enc_param('case', $case_no, 600));
                    return false;
                }
                $this->db->trans_commit();
            }

            $this->db->trans_begin();
            $updateRegAr = [
                    'co_operative_registered_yes_no' => $registration_info,
                    'co_operative_registered_yes_no_date' => date('Y-m-d H:i:s')
            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_ap_lmnote', $updateRegAr);
            if ($this->db->affected_rows() != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERR7136543: Updation Failed in settlement_ap_lmnote table');
                $this->session->set_flashdata('message', "#ERR7136543 Payment notice could not be generated...");
                redirect(base_url() . 'index.php/SettlementInstitutionCo/generatePaymentNoticeCo?case=' . enc_param('case', $case_no, 600));
                return false;
            }
            $this->db->trans_commit();
            
            

            
        }

        // if($insDetails->ins_cat_type_co == '12' && empty($registrationData) && $registration_acknowledge == 'ack')
        // {
        //     if(empty($acknowledgment_no))
        //     {
        //         log_message('error', '#ERR71r323: Acknowledgment_no not found !!!');
        //         $this->session->set_flashdata('message', "#ERR71r323 Payment notice  could not be generated...");
        //         redirect(base_url() . 'index.php/SettlementInstitutionCo/generatePaymentNoticeCo?case=' . $case_no);
        //         return false;
        //     }

        //     ////////////uploading registration details////////////
        //     $this->db->trans_begin();
        //     $updateAckAr = [
        //         'acknowledgment_no' => $acknowledgment_no,
        //         'registration_acknowledge' => $registration_acknowledge,
        //     ];
        //     $this->db->where('case_no', $case_no);
        //     $this->db->update('settlement_ap_lmnote', $updateAckAr);
        //     if ($this->db->affected_rows() != 1) {
        //         $this->db->trans_rollback();
        //         log_message('error', '#ERR7136342: Updation Failed in settlement_ap_lmnote table');
        //         $this->session->set_flashdata('message', "#ERR7136342 Payment notice  could not be generated...");
        //         redirect(base_url() . 'index.php/SettlementInstitutionCo/generatePaymentNoticeCo?case=' . $case_no);
        //         return false;
        //     }
        //     //////proceeding start//////
        //     $proceeding_id = $this->db->query("Select max(proceeding_id)+1 as c from settlement_proceeding where case_no='$case_no' ")->row()->c;
        //     if ($proceeding_id == null) {
        //         $proceeding_id = 1;
        //     }
        //     $insertArr = [
        //         'case_no' => $case_no,
        //         'proceeding_id' => $proceeding_id,
        //         'date_of_hearing' => date('Y-m-d h:i:s'),
        //         'next_date_of_hearing' => date('Y-m-d h:i:s'),
        //         'note_on_order' => 'Acknowledgment information entered by CO',
        //         'status' => 'M',
        //         'user_code' => $this->session->userdata('user_code'),
        //         'date_entry' => date('Y-m-d h:i:s'),
        //         'operation' => 'E',
        //         'ip' => $this->utilityclass->get_client_ip(),
        //         'office_from' => 'CO',
        //         'office_to' => 'CO',
        //         'task' => 'Acknowledgment information verified',
        //         'old_file_link' =>null,
        //     ];
        //     $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        //     if ($insertProc != 1)
        //     {
        //         $this->db->trans_rollback();
        //         log_message('error', '#ERRNOPNINSN004322: Insertion failed in settlement_proceeding');
        //         $this->session->set_flashdata('message', "#ERRNOPNINSN004322 Something went wrong !!!...");
        //         redirect(base_url() . 'index.php/SettlementInstitutionCo/generatePaymentNoticeCo?case=' . $case_no);
        //         return false;
        //     }
        //     $this->db->trans_commit();
        // }




        if($insDetails->ins_cat_type_co == '12' && $apLmnoteDetails->already_alloted == 'N' && ($insDetails->purpose_land_allot_co == 'religious' || $insDetails->purpose_land_allot_co == 'socioculture'))
        {
            $data['service_name_pre'] = 'Digitalized Allotment/Settlement of land to Non individual Juridical entities-Allotment_to Religious/ Socio cultural institution';

            $data['service_name'] = 'Digitalized Allotment/Settlement of land to Non individual Juridical entities';

            $premium_data = $this->db->query("SELECT * from settlement_premium where case_no=? and is_final=?", array($case_no, 1));
            if($premium_data->num_rows() > 0)
            {
                
                $premium_data_row = $premium_data->row();
                $premium_data_arr = $premium_data->result();

                if(!isset($dags))
                {
                    //****show error */
                    $this->session->set_flashdata('message', "#ERR2018: Something went wrong!...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                foreach($dags as $dag_item)
                {
                    $premiumSql = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $dag_item->dag_no, 1));
            
                    if($premiumSql->num_rows() <= 0)
                    {
                        //****show error */
                        $this->session->set_flashdata('message', "#ERR2029: Something went wrong!...#".$case_no);
                        redirect(base_url().'index.php/home');
                    }

                }


                if(($data['dept_order_no'] == null || $data['dept_order_no'] == '' || empty($data['dept_order_no'])) || ($data['dept_order_date'] == null || $data['dept_order_date'] == '' || empty($data['dept_order_date'])))
                {
                    $this->session->set_flashdata('message', "#ERR1913: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                if($data['date_of_sldc'] == null || $data['date_of_sldc'] == '' || empty($data['date_of_sldc']))
                {
                    $this->session->set_flashdata('message', "#ERR2039: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                if($basic['dept_order_date'] == null || $basic['dept_order_date'] == '' || empty($basic['dept_order_date']))
                {
                    $this->session->set_flashdata('message', "#ERR203935: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                $trArr = '';
                $area_all = array();
                $dag_arr = array();
                $data['actual_premium'] = 0;
                $settlement_amount      = 0;
                $final_reclass_amount   = 0;
                $final_land_revenue_years    = 0;
                $reclass_amount = 0;
                $land_revenue_years = 0;

                $sl_counter = 1;

                foreach($premium_data_arr as $premium)
                {
                    
                    $dag_no = $premium->dag_no;
                    $SingleDagCheck = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ? and dag_no = ?", array($case_no, $dag_no))->row();


                    $premium_per_bigha = $premium->zonal_valuation;
                    
                    $dag_arr[] = $premium->dag_no;
                    $total_lessa = $premium->total_lessa;
                    if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                    {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa);
                        $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                    }
                    else
                    {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                        // $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                        $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                    }

                    $data['first_area'] = implode ( ", ", $area_all );
                    $data['first_dag_no'] = implode ( ", ", $dag_arr );
                    $total_amount = ceil($premium->amount_dag);
                    $total_amount = $total_amount;
                    $net_premium_payable = ceil($premium->final_amount);


                    $reclass_amount += $premium->ins_reclass_amount;
                    $land_revenue_years += $premium->land_revenue_years;
                    $settlement_amount += $total_amount;


                    $mandolikPremium = null;
                    if($SingleDagCheck->is_urban == 'N' && $premium->area_name == 10)
                    {
                        $mandolikPremium = "Rs 500-Rural Area";
                    }
                    else
                    {
                        $mandolikPremium = "Rs 50000-Urban Area";
                    }
                    $loloCounter = 1;
                    $trArr .= '<tr>
                                <td rowspan="'.$loloCounter.'" class="text-center">'.$sl_counter++.'</td>
                                <td>
                                   ৰেহাই মূল্যত বন্দৱস্তী প্ৰিমিয়াম 
                                </td>
                                <td>'.$mandolikPremium.'</td>
                                <td>'.$dag_no.'</td>
                                <td style="white-space: nowrap;">'.$area.'</td>
                                <td style="white-space: nowrap;" class="text-right pr-2">+₹ '.($total_amount * 2).'</td>
                            </tr>';
                           
                    
                }

                $final_reclass_amount = $reclass_amount;
                $final_land_revenue_years = $land_revenue_years;
                $total_reclass_revenue = $reclass_amount;
                $final_settlement_amount = ($settlement_amount - ceil($total_reclass_revenue));

                $trArr .= '<tr>
                                <td colspan="5" class="text-center"><b>আবণ্টনৰ বাবে দিবলগীয়া প্ৰিমিয়াম (বন্দৱস্তী প্ৰিমিয়ামৰ ৫০ শতাংশ)</b></td>
                                <td class="text-right pr-2"><b>₹ '.$net_premium_payable.'</b></td>
                            </tr>';

                $trArr .= '<tr>
                                <td colspan="5" class="text-center"><b>মুঠ প্ৰিমিয়াম</b></td>
                                <td class="text-right pr-2"><b>₹ '.$net_premium_payable.'</b></td>
                            </tr>';

                $data['net_premium_payable']       = $net_premium_payable;
                $data['final_settlement_amount']   = $final_settlement_amount;
                $data['final_reclass_amount']      = ceil($final_reclass_amount);
                $data['final_land_revenue_amount'] = ceil($final_land_revenue_years);
                $data['tbody'] = $trArr;

                
            }
            else
            {
                $this->session->set_flashdata('message', "#ERR2533: Unable to process! Something went wrong...#".$case_no);
                redirect(base_url().'index.php/home');
            }


            $this->load->view('SettlementView/include/juridical_premium_notice_allotment_non_govt_religious_socioculture', $data);
        }
        else if($insDetails->ins_cat_type_co == '12' && $apLmnoteDetails->already_alloted == 'N' && $insDetails->purpose_land_allot_co == 'education' && ($insDetails->under_venture_school == 'NO' || $insDetails->under_venture_school == '' || $insDetails->under_venture_school == null))
        {
            $data['service_name_pre'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities-Allotment to Non Govt educational institution';

            $data['service_name'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities';


            $premium_data = $this->db->query("SELECT * from settlement_premium where case_no=? and is_final=?", array($case_no, 1));
            if($premium_data->num_rows() > 0)
            {
                
                $premium_data_row = $premium_data->row();
                $premium_data_arr = $premium_data->result();

                if(!isset($dags))
                {
                    //****show error */
                    $this->session->set_flashdata('message', "#ERR2018: Something went wrong!...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                foreach($dags as $dag_item)
                {
                    $premiumSql = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $dag_item->dag_no, 1));
            
                    if($premiumSql->num_rows() <= 0)
                    {
                        //****show error */
                        $this->session->set_flashdata('message', "#ERR2029: Something went wrong!...#".$case_no);
                        redirect(base_url().'index.php/home');
                    }

                }


                if(($data['dept_order_no'] == null || $data['dept_order_no'] == '' || empty($data['dept_order_no'])) || ($data['dept_order_date'] == null || $data['dept_order_date'] == '' || empty($data['dept_order_date'])))
                {
                    $this->session->set_flashdata('message', "#ERR1913: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                if($data['date_of_sldc'] == null || $data['date_of_sldc'] == '' || empty($data['date_of_sldc']))
                {
                    $this->session->set_flashdata('message', "#ERR2039: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                if($basic['dept_order_date'] == null || $basic['dept_order_date'] == '' || empty($basic['dept_order_date']))
                {
                    $this->session->set_flashdata('message', "#ERR203935: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                $trArr = '';
                $area_all = array();
                $dag_arr = array();
                $data['actual_premium'] = 0;
                $settlement_amount      = 0;
                $final_reclass_amount   = 0;
                $final_land_revenue_years    = 0;
                $reclass_amount = 0;
                $land_revenue_years = 0;

                $sl_counter = 1;

                foreach($premium_data_arr as $premium)
                {
                    
                
                    $premium_per_bigha = $premium->zonal_valuation;
                    $dag_no = $premium->dag_no;
                    $dag_arr[] = $premium->dag_no;
                    $total_lessa = $premium->total_lessa;
                    if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                    {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa);
                        $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                    }
                    else
                    {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                        // $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                        $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                    }

                    $data['first_area'] = implode ( ", ", $area_all );
                    $data['first_dag_no'] = implode ( ", ", $dag_arr );


                    $total_amount = ceil($premium->amount_dag);
                    $total_amount = $total_amount;
                    $net_premium_payable = ceil($premium->final_amount);


                    $reclass_amount += $premium->ins_reclass_amount;
                    $land_revenue_years += $premium->land_revenue_years;
                    $settlement_amount += $total_amount;


                    $mandolikPremium = null;
                    if($insDetails->non_govt_profit_making_yes_no == 'N')
                    {
                        $mandolikPremium = "মাণ্ডলিক মূল্যৰ ১০০%";
                    }
                    else
                    {
                        $mandolikPremium = "মাণ্ডলিক মূল্যৰ ৩০%";
                    }
                    $loloCounter = 1;
                    $trArr .= '<tr>
                                <td rowspan="'.$loloCounter.'" class="text-center">'.$sl_counter++.'</td>
                                <td>
                                   বন্দৱস্তী প্ৰিমিয়াম মূল্য<br>'.$mandolikPremium.'
                                </td>
                                <td>'.$premium_per_bigha.'</td>
                                <td>'.$dag_no.'</td>
                                <td style="white-space: nowrap;">'.$area.'</td>
                                <td style="white-space: nowrap;" class="text-right pr-2">+₹ '.($total_amount *2).'</td>
                            </tr>';
                           
                    
                }

                $final_reclass_amount = $reclass_amount;
                $final_land_revenue_years = $land_revenue_years;
                $total_reclass_revenue = $reclass_amount;
                $final_settlement_amount = ($settlement_amount - ceil($total_reclass_revenue));

                // $trArr .= '<tr>
                //                 <td colspan="5" class="text-center"><b>মুঠ দিবলগীয়া প্ৰিমিয়াম</b></td>
                //                 <td class="text-right pr-2"><b>₹ '.($net_premium_payable * 2).'</b></td>
                //             </tr>';

                $trArr .= '<tr>
                                <td colspan="5" class="text-center"><b>আবণ্টনৰ বাবে দিবলগীয়া প্ৰিমিয়াম (মুঠ বন্দৱস্তী প্ৰিমিয়ামৰ ৫০ শতাংশ)</b></td>
                                <td class="text-right pr-2"><b>₹ '.$net_premium_payable.'</b></td>
                            </tr>';


                $data['net_premium_payable'] = $net_premium_payable;
                $data['final_reclass_amount'] = $reclass_amount;
                $data['final_land_revenue_years'] = $land_revenue_years;
                $data['final_settlement_amount'] = ($settlement_amount - ceil($total_reclass_revenue));

                $data['tbody'] = $trArr;

                
            }
            else
            {
                $this->session->set_flashdata('message', "#ERR2533: Unable to process! Something went wrong...#".$case_no);
                redirect(base_url().'index.php/home');
            }
            $this->load->view('SettlementView/include/juridical_premium_notice_allotment_non_govt_education', $data);
        }
        else if($insDetails->ins_cat_type_co == '12' && $apLmnoteDetails->already_alloted == 'N' && $insDetails->purpose_land_allot_co == 'education' && $insDetails->under_venture_school == 'YES' && $insDetails->venture_type =='unrecognised_venture')
        {
            $data['service_name_pre'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities-Allotment to Non Govt educational institution';

            $data['service_name'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities';


            $premium_data = $this->db->query("SELECT * from settlement_premium where case_no=? and is_final=?", array($case_no, 1));
            if($premium_data->num_rows() > 0)
            {
                
                $premium_data_row = $premium_data->row();
                $premium_data_arr = $premium_data->result();

                if(!isset($dags))
                {
                    //****show error */
                    $this->session->set_flashdata('message', "#ERR2018: Something went wrong!...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                foreach($dags as $dag_item)
                {
                    $premiumSql = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $dag_item->dag_no, 1));
            
                    if($premiumSql->num_rows() <= 0)
                    {
                        //****show error */
                        $this->session->set_flashdata('message', "#ERR2029: Something went wrong!...#".$case_no);
                        redirect(base_url().'index.php/home');
                    }

                }


                if(($data['dept_order_no'] == null || $data['dept_order_no'] == '' || empty($data['dept_order_no'])) || ($data['dept_order_date'] == null || $data['dept_order_date'] == '' || empty($data['dept_order_date'])))
                {
                    $this->session->set_flashdata('message', "#ERR1913: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                if($data['date_of_sldc'] == null || $data['date_of_sldc'] == '' || empty($data['date_of_sldc']))
                {
                    $this->session->set_flashdata('message', "#ERR2039: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                if($basic['dept_order_date'] == null || $basic['dept_order_date'] == '' || empty($basic['dept_order_date']))
                {
                    $this->session->set_flashdata('message', "#ERR203935: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                $trArr = '';
                $area_all = array();
                $dag_arr = array();
                $data['actual_premium'] = 0;

                $settlement_amount      = 0;
                $final_reclass_amount   = 0;
                $final_land_revenue_years    = 0;
                $reclass_amount = 0;
                $land_revenue_years = 0;

                $sl_counter = 1;

                foreach($premium_data_arr as $premium)
                {
                    
                
                    $premium_per_bigha = $premium->zonal_valuation;
                    $dag_no = $premium->dag_no;
                    $dag_arr[] = $premium->dag_no;
                    $total_lessa = $premium->total_lessa;
                    if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                    {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa);
                        $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                    }
                    else
                    {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                        // $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                        $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                    }

                    $data['first_area'] = implode ( ", ", $area_all );
                    $data['first_dag_no'] = implode ( ", ", $dag_arr );


                    $total_amount = ceil($premium->amount_dag);
                    $total_amount = $total_amount;
                    $net_premium_payable = ceil($premium->final_amount);

                    $reclass_amount += $premium->ins_reclass_amount;
                    $land_revenue_years += $premium->land_revenue_years;
                    $settlement_amount += $total_amount;


                    $mandolikPremium = null;
                    // if($insDetails->non_govt_profit_making_yes_no == 'N')
                    // {
                        // $mandolikPremium = "মাণ্ডলিক মূল্যৰ ১০০%";
                    // }
                    // else
                    // {
                    //     $mandolikPremium = "মাণ্ডলিক মূল্যৰ ৩০%";
                    // }
                    $loloCounter = 1;
                    $trArr .= '<tr>
                                <td rowspan="'.$loloCounter.'" class="text-center">'.$sl_counter++.'</td>
                                <td>
                                   বন্দৱস্তী প্ৰিমিয়াম মূল্য<br>'.$mandolikPremium.'
                                </td>
                                <td>'.$premium_per_bigha.'</td>
                                <td>'.$dag_no.'</td>
                                <td style="white-space: nowrap;">'.$area.'</td>
                                <td style="white-space: nowrap;" class="text-right pr-2">+₹ '.($total_amount *2).'</td>
                            </tr>';
                           
                    
                }

                $final_reclass_amount = $reclass_amount;
                $final_land_revenue_years = $land_revenue_years;
                $total_reclass_revenue = $reclass_amount;
                $final_settlement_amount = ($settlement_amount - ceil($total_reclass_revenue));

                // $trArr .= '<tr>
                //                 <td colspan="5" class="text-center"><b>মুঠ দিবলগীয়া প্ৰিমিয়াম</b></td>
                //                 <td class="text-right pr-2"><b>₹ '.($net_premium_payable * 2).'</b></td>
                //             </tr>';

                $trArr .= '<tr>
                                <td colspan="5" class="text-center"><b>আবণ্টনৰ বাবে দিবলগীয়া প্ৰিমিয়াম (মুঠ বন্দৱস্তী প্ৰিমিয়ামৰ ৫০ শতাংশ)</b></td>
                                <td class="text-right pr-2"><b>₹ '.$net_premium_payable.'</b></td>
                            </tr>';


                $data['net_premium_payable'] = $net_premium_payable;

                $data['final_reclass_amount'] = $reclass_amount;
                $data['final_land_revenue_years'] = $land_revenue_years;
                $data['final_settlement_amount'] = ($settlement_amount - ceil($total_reclass_revenue));

                $data['tbody'] = $trArr;

                
            }
            else
            {
                $this->session->set_flashdata('message', "#ERR2533: Unable to process! Something went wrong...#".$case_no);
                redirect(base_url().'index.php/home');
            }
            $this->load->view('SettlementView/include/juridical_premium_notice_allotment_non_govt_education', $data);
        }
        else if($insDetails->ins_cat_type_co == '12' && $apLmnoteDetails->already_alloted == 'Y' && ($insDetails->purpose_land_allot_co == 'religious' || $insDetails->purpose_land_allot_co == 'socioculture'))
        {


            $data['service_name_pre'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities-Direct Settlement_to Religious/ Socio cultural institution';

            $data['service_name'] ='Digitalized Settlement of land to Non individual Juridical entities';
            $premium_data = $this->db->query("SELECT * from settlement_premium where case_no=? and is_final=?", array($case_no, 1));
            if($premium_data->num_rows() > 0)
            {
               $premium_data_row = $premium_data->row();
                $premium_data_arr = $premium_data->result();

                if(!isset($dags))
                {
                    //****show error */
                    $this->session->set_flashdata('message', "#ERR2018: Something went wrong!...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                foreach($dags as $dag_item)
                {
                    $premiumSql = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $dag_item->dag_no, 1));
            
                    if($premiumSql->num_rows() <= 0)
                    {
                        //****show error */
                        $this->session->set_flashdata('message', "#ERR2029: Something went wrong!...#".$case_no);
                        redirect(base_url().'index.php/home');
                    }

                }


                if(($data['dept_order_no'] == null || $data['dept_order_no'] == '' || empty($data['dept_order_no'])) || ($data['dept_order_date'] == null || $data['dept_order_date'] == '' || empty($data['dept_order_date'])))
                {
                    $this->session->set_flashdata('message', "#ERR1913: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                if($data['date_of_sldc'] == null || $data['date_of_sldc'] == '' || empty($data['date_of_sldc']))
                {
                    $this->session->set_flashdata('message', "#ERR2039: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                if($basic['dept_order_date'] == null || $basic['dept_order_date'] == '' || empty($basic['dept_order_date']))
                {
                    $this->session->set_flashdata('message', "#ERR203935: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                $trArr = '';
                $area_all = array();
                $dag_arr = array();
                $data['actual_premium'] = 0;
                $settlement_amount      = 0;
                $final_reclass_amount   = 0;
                $final_land_revenue_years    = 0;
                $reclass_amount = 0;
                $land_revenue_years = 0;

                $sl_counter = 1;

                foreach($premium_data_arr as $premium)
                {
                    
                    $dag_no = $premium->dag_no;
                    $SingleDagCheck = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ? and dag_no = ?", array($case_no, $dag_no))->row();

                    $premium_per_bigha = $premium->zonal_valuation;
                    
                    $dag_arr[] = $premium->dag_no;
                    $total_lessa = $premium->total_lessa;
                    if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                    {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa);
                        $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                    }
                    else
                    {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                        // $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                        $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                    }

                    $data['first_area'] = implode ( ", ", $area_all );
                    $data['first_dag_no'] = implode ( ", ", $dag_arr );
                    $total_amount = ceil($premium->amount_dag);
                    $total_amount = $total_amount;
                    $net_premium_payable = ceil($premium->final_amount);
                    $org_reclass_amount = ceil($premium->ins_reclass_amount);


                    $reclass_amount += $premium->ins_reclass_amount;
                    $land_revenue_years += $premium->land_revenue_years;
                    $settlement_amount += $total_amount;


                    $mandolikPremium = null;
                    if($SingleDagCheck->is_urban == 'N' && $premium->area_name == 10)
                    {
                        $mandolikPremium = "Rs 500-Rural Area";
                    }
                    else
                    {
                        $mandolikPremium = "Rs 50000-Urban Area";
                    }
                    $loloCounter = 1;
                    $trArr .= '<tr>
                                <td rowspan="'.$loloCounter.'" class="text-center">'.$sl_counter++.'</td>
                                <td>
                                  ৰেহাই মূল্যত বন্দৱস্তী প্ৰিমিয়াম
                                </td>
                                <td>'.$mandolikPremium.'</td>
                                <td>'.$dag_no.'</td>
                                <td style="white-space: nowrap;">'.$area.'</td>
                                <td style="white-space: nowrap;" class="text-right pr-2">+₹ '.($total_amount - $org_reclass_amount).'</td>
                            </tr>';
                            $trArr .= '<tr>
                                <td colspan="5" class="text-center"><b> শ্ৰেণী পৰিৱৰ্তন ও হস্তান্তৰ প্ৰিমিয়াম মূল্য(যদি প্ৰযোজ্য)</b></td>
                                <td class="text-right pr-2"><b>₹ '.$org_reclass_amount.'</b></td>
                            </tr>';
                           
                    
                }

                $final_reclass_amount = $reclass_amount;
                $final_land_revenue_years = $land_revenue_years;
                $total_reclass_revenue = $reclass_amount;
                $final_settlement_amount = ($settlement_amount - ceil($total_reclass_revenue));
                

                $trArr .= '<tr>
                                <td colspan="5" class="text-center"><b>মুঠ দিবলগীয়া প্ৰিমিয়াম</b></td>
                                <td class="text-right pr-2"><b>₹ '.$net_premium_payable.'</b></td>
                            </tr>';

                $data['net_premium_payable'] = $net_premium_payable;
                $data['final_reclass_amount'] = $reclass_amount;
                $data['final_land_revenue_years'] = $land_revenue_years;
                $data['final_settlement_amount'] = ($settlement_amount - ceil($total_reclass_revenue));

                $data['tbody'] = $trArr;


                
            }
            else
            {
                $this->session->set_flashdata('message', "#ERR2533: Unable to process! Something went wrong...#".$case_no);
                redirect(base_url().'index.php/home');
            }
            
            $this->load->view('SettlementView/include/juridical_premium_notice_settlement_non_govt_religious_socioculture', $data);
        }
        else if($insDetails->ins_cat_type_co == '12' && $apLmnoteDetails->already_alloted == 'Y' && $insDetails->purpose_land_allot_co == 'education' && ($insDetails->under_venture_school == 'NO' || $insDetails->under_venture_school == '' || $insDetails->under_venture_school == null))
        {

            $data['service_name_pre'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities-Direct Settlement to Non Govt Educational institution';


            $data['service_name'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities';


            $premium_data = $this->db->query("SELECT * from settlement_premium where case_no=? and is_final=?", array($case_no, 1));
            if($premium_data->num_rows() > 0)
            {
                
                $premium_data_row = $premium_data->row();
                $premium_data_arr = $premium_data->result();

                if(!isset($dags))
                {
                    //****show error */
                    $this->session->set_flashdata('message', "#ERR2018: Something went wrong!...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                foreach($dags as $dag_item)
                {
                    $premiumSql = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $dag_item->dag_no, 1));
            
                    if($premiumSql->num_rows() <= 0)
                    {
                        //****show error */
                        $this->session->set_flashdata('message', "#ERR2029: Something went wrong!...#".$case_no);
                        redirect(base_url().'index.php/home');
                    }

                }


                if(($data['dept_order_no'] == null || $data['dept_order_no'] == '' || empty($data['dept_order_no'])) || ($data['dept_order_date'] == null || $data['dept_order_date'] == '' || empty($data['dept_order_date'])))
                {
                    $this->session->set_flashdata('message', "#ERR1913: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                if($data['date_of_sldc'] == null || $data['date_of_sldc'] == '' || empty($data['date_of_sldc']))
                {
                    $this->session->set_flashdata('message', "#ERR2039: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                if($basic['dept_order_date'] == null || $basic['dept_order_date'] == '' || empty($basic['dept_order_date']))
                {
                    $this->session->set_flashdata('message', "#ERR203935: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                $trArr = '';
                $area_all = array();
                $dag_arr = array();
                $data['actual_premium'] = 0;
                $settlement_amount      = 0;
                $final_reclass_amount   = 0;
                $final_land_revenue_years    = 0;
                $reclass_amount = 0;
                $land_revenue_years = 0;


                $sl_counter = 1;

                foreach($premium_data_arr as $premium)
                {
                    $premium_per_bigha = $premium->zonal_valuation;
                    $dag_no = $premium->dag_no;
                    $dag_arr[] = $premium->dag_no;
                    $total_lessa = $premium->total_lessa;
                    if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                    {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa);
                        $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                    }
                    else
                    {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                        // $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                        $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                    }

                    $data['first_area'] = implode ( ", ", $area_all );
                    $data['first_dag_no'] = implode ( ", ", $dag_arr );
                    $total_amount = ceil($premium->amount_dag);
                    $net_premium_payable = ceil($premium->final_amount);
                    $org_reclass_amount = ceil($premium->ins_reclass_amount);


                    $reclass_amount += $premium->ins_reclass_amount;
                    $land_revenue_years += $premium->land_revenue_years;
                    $settlement_amount += $total_amount;

                    $mandolikPremium = null;
                    if($insDetails->non_govt_profit_making_yes_no == 'N')
                    {
                        $mandolikPremium = "মাণ্ডলিক মূল্যৰ ১০০%";
                    }
                    else if($insDetails->non_govt_profit_making_yes_no == 'Y')
                    {
                        $mandolikPremium = "মাণ্ডলিক মূল্যৰ ৩০%";
                    }
                    else
                    {
                        $mandolikPremium = '';
                    }
                    $loloCounter = 1;
                    $trArr .= '<tr>
                                <td rowspan="'.$loloCounter.'" class="text-center">'.$sl_counter++.'</td>
                                <td>
                                    বন্দৱস্তী প্ৰিমিয়াম মূল্য<br>'.$mandolikPremium.'
                                </td>
                                <td>'.$premium_per_bigha.'</td>
                                <td>'.$dag_no.'</td>
                                <td style="white-space: nowrap;">'.$area.'</td>
                                <td style="white-space: nowrap;" class="text-right pr-2">+₹ '.($total_amount - $org_reclass_amount).'</td>
                            </tr>';
                    $trArr .= '<tr>
                                <td colspan="5" class="text-center"><b>শ্ৰেণী পৰিৱৰ্তন ও হস্তান্তৰ প্ৰিমিয়াম মূল্য (যদি প্ৰযোজ্য)</b></td>
                                <td class="text-right pr-2"><b>₹ '.$org_reclass_amount.'</b></td>
                            </tr>';
                           
                    
                }

                $final_reclass_amount = $reclass_amount;
                $final_land_revenue_years = $land_revenue_years;
                $total_reclass_revenue = $reclass_amount;
                $final_settlement_amount = ($settlement_amount - ceil($total_reclass_revenue));


                $trArr .= '<tr>
                                <td colspan="5" class="text-center"><b>মুঠ দিবলগীয়া প্ৰিমিয়াম</b></td>
                                <td class="text-right pr-2"><b>₹ '.$net_premium_payable.'</b></td>
                            </tr>';


                $data['net_premium_payable'] = $net_premium_payable;

                $data['final_reclass_amount'] = $reclass_amount;
                $data['final_land_revenue_years'] = $land_revenue_years;
                $data['final_settlement_amount'] = ($settlement_amount - ceil($total_reclass_revenue));


                $data['tbody'] = $trArr;

                
            }
            else
            {
                $this->session->set_flashdata('message', "#ERR2533: Unable to process! Something went wrong...#".$case_no);
                redirect(base_url().'index.php/home');
            }

            $this->load->view('SettlementView/include/juridical_premium_notice_settlement_non_govt_education', $data);
        }
        else if($insDetails->ins_cat_type_co == '12' && $apLmnoteDetails->already_alloted == 'Y' && $insDetails->purpose_land_allot_co == 'education' && $insDetails->under_venture_school == 'YES' && $insDetails->venture_type == 'unrecognised_venture')
        {

            $data['service_name_pre'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities-Direct Settlement to Non Govt Educational institution';


            $data['service_name'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities';


            $premium_data = $this->db->query("SELECT * from settlement_premium where case_no=? and is_final=?", array($case_no, 1));
            if($premium_data->num_rows() > 0)
            {
                
                $premium_data_row = $premium_data->row();
                $premium_data_arr = $premium_data->result();

                if(!isset($dags))
                {
                    //****show error */
                    $this->session->set_flashdata('message', "#ERR2018: Something went wrong!...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                foreach($dags as $dag_item)
                {
                    $premiumSql = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $dag_item->dag_no, 1));
            
                    if($premiumSql->num_rows() <= 0)
                    {
                        //****show error */
                        $this->session->set_flashdata('message', "#ERR2029: Something went wrong!...#".$case_no);
                        redirect(base_url().'index.php/home');
                    }

                }


                if(($data['dept_order_no'] == null || $data['dept_order_no'] == '' || empty($data['dept_order_no'])) || ($data['dept_order_date'] == null || $data['dept_order_date'] == '' || empty($data['dept_order_date'])))
                {
                    $this->session->set_flashdata('message', "#ERR1913: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                if($data['date_of_sldc'] == null || $data['date_of_sldc'] == '' || empty($data['date_of_sldc']))
                {
                    $this->session->set_flashdata('message', "#ERR2039: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                if($basic['dept_order_date'] == null || $basic['dept_order_date'] == '' || empty($basic['dept_order_date']))
                {
                    $this->session->set_flashdata('message', "#ERR203935: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                $trArr = '';
                $area_all = array();
                $dag_arr = array();
                $data['actual_premium'] = 0;
                $settlement_amount      = 0;
                $final_reclass_amount   = 0;
                $final_land_revenue_years    = 0;
                $reclass_amount = 0;
                $land_revenue_years = 0;

                $sl_counter = 1;

                foreach($premium_data_arr as $premium)
                {
                    
                
                    $premium_per_bigha = $premium->zonal_valuation;
                    $dag_no = $premium->dag_no;
                    $dag_arr[] = $premium->dag_no;
                    $total_lessa = $premium->total_lessa;
                    if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                    {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa);
                        $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                    }
                    else
                    {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                        // $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                        $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                    }

                    $data['first_area'] = implode ( ", ", $area_all );
                    $data['first_dag_no'] = implode ( ", ", $dag_arr );
                    $total_amount = ceil($premium->amount_dag);
                    $net_premium_payable = ceil($premium->final_amount);
                    $org_reclass_amount = ceil($premium->ins_reclass_amount);


                    $reclass_amount += $premium->ins_reclass_amount;
                    $land_revenue_years += $premium->land_revenue_years;
                    $settlement_amount += $total_amount;



                    $mandolikPremium = null;
                    // if($insDetails->non_govt_profit_making_yes_no == 'N')
                    // {
                    //     $mandolikPremium = "মাণ্ডলিক মূল্যৰ ১০০%";
                    // }
                    // else
                    // {
                    //     $mandolikPremium = "মাণ্ডলিক মূল্যৰ ৩০%";
                    // }
                    $loloCounter = 1;
                    $trArr .= '<tr>
                                <td rowspan="'.$loloCounter.'" class="text-center">'.$sl_counter++.'</td>
                                <td>
                                    বন্দৱস্তী প্ৰিমিয়াম মূল্য<br>'.$mandolikPremium.'
                                </td>
                                <td>'.$premium_per_bigha.'</td>
                                <td>'.$dag_no.'</td>
                                <td style="white-space: nowrap;">'.$area.'</td>
                                <td style="white-space: nowrap;" class="text-right pr-2">+₹ '.($total_amount - $org_reclass_amount).'</td>
                            </tr>';
                    $trArr .= '<tr>
                                <td colspan="5" class="text-center"><b>শ্ৰেণী পৰিৱৰ্তন ও হস্তান্তৰ প্ৰিমিয়াম মূল্য (যদি প্ৰযোজ্য)</b></td>
                                <td class="text-right pr-2"><b>₹ '.$org_reclass_amount.'</b></td>
                            </tr>';
                           
                    
                }

                $final_reclass_amount = $reclass_amount;
                $final_land_revenue_years = $land_revenue_years;
                $total_reclass_revenue = $reclass_amount ;
                $final_settlement_amount = ($settlement_amount - ceil($total_reclass_revenue));

                

                $trArr .= '<tr>
                                <td colspan="5" class="text-center"><b>মুঠ দিবলগীয়া প্ৰিমিয়াম</b></td>
                                <td class="text-right pr-2"><b>₹ '.$net_premium_payable.'</b></td>
                            </tr>';


                $data['net_premium_payable'] = $net_premium_payable;

                $data['final_reclass_amount'] = $reclass_amount;
                $data['final_land_revenue_years'] = $land_revenue_years;
                $data['final_settlement_amount'] = ($settlement_amount - ceil($total_reclass_revenue));
                $data['tbody'] = $trArr;

                
            }
            else
            {
                $this->session->set_flashdata('message', "#ERR2533: Unable to process! Something went wrong...#".$case_no);
                redirect(base_url().'index.php/home');
            }

            $this->load->view('SettlementView/include/juridical_premium_notice_settlement_non_govt_education', $data);
        }
        else if($insDetails->ins_cat_type_co == '10')
        {

            $data['service_name_pre'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities-Land Transfer/ Settlement to Central Govt Department/Central Govt Undertakings';


            $data['service_name'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities';

            $premium_data = $this->db->query("SELECT * from settlement_premium where case_no=? and is_final=?", array($case_no, 1));
            if($premium_data->num_rows() > 0)
            {
                
                $premium_data_row = $premium_data->row();
                $premium_data_arr = $premium_data->result();

                if(!isset($dags))
                {
                    //****show error */
                    $this->session->set_flashdata('message', "#ERR2018: Something went wrong!...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                foreach($dags as $dag_item)
                {
                    $premiumSql = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $dag_item->dag_no, 1));
            
                    if($premiumSql->num_rows() <= 0)
                    {
                        //****show error */
                        $this->session->set_flashdata('message', "#ERR2029: Something went wrong!...#".$case_no);
                        redirect(base_url().'index.php/home');
                    }

                }


                // if(($data['dept_order_no'] == null || $data['dept_order_no'] == '' || empty($data['dept_order_no'])) || ($data['dept_order_date'] == null || $data['dept_order_date'] == '' || empty($data['dept_order_date'])))
                // {
                //     $this->session->set_flashdata('message', "#ERR1913: Unable to process! Something went wrong...#".$case_no);
                //     redirect(base_url().'index.php/home');
                // }

                if($data['date_of_sldc'] == null || $data['date_of_sldc'] == '' || empty($data['date_of_sldc']))
                {
                    $this->session->set_flashdata('message', "#ERR2039: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                // if($basic['dept_order_date'] == null || $basic['dept_order_date'] == '' || empty($basic['dept_order_date']))
                // {
                //     $this->session->set_flashdata('message', "#ERR203935: Unable to process! Something went wrong...#".$case_no);
                //     redirect(base_url().'index.php/home');
                // }

                $trArr = '';
                $area_all = array();
                $dag_arr = array();
                $data['actual_premium'] = 0;
                $reclass_amount = 0;
                $land_revenue_years = 0;
                $settlement_amount = 0;

                $sl_counter = 1;

                foreach($premium_data_arr as $premium)
                {
                    
                
                    $premium_per_bigha = $premium->zonal_valuation;
                    $dag_no = $premium->dag_no;
                    $dag_arr[] = $premium->dag_no;
                    $total_lessa = $premium->total_lessa;
                    if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                    {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa);
                        $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                    }
                    else
                    {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                        // $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                        $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                    }

                    $data['first_area'] = implode ( ", ", $area_all );
                    $data['first_dag_no'] = implode ( ", ", $dag_arr );
                    $total_amount = ceil($premium->amount_dag);
                    $net_premium_payable = ceil($premium->final_amount);
                    $org_reclass_amount = ceil($premium->ins_reclass_amount);
                    $org_land_revenue_years = ceil($premium->land_revenue_years);

                    $reclass_amount += $premium->ins_reclass_amount;
                    $land_revenue_years += $premium->land_revenue_years;
                    $settlement_amount += $total_amount;
                    
                    $mandolikPremium = "মাণ্ডলিক মূল্যৰ ১০০%";
                    
                    
                    $loloCounter = 1;
                    $trArr .= '<tr>
                                <td rowspan="'.$loloCounter.'" class="text-center">'.$sl_counter++.'</td>
                                <td>
                                    ভূমিৰ বন্দৱস্তী/হস্তান্তৰ প্ৰিমিয়াম মূল্য<br>'.$mandolikPremium.'
                                </td>
                                <td>'.$premium_per_bigha.'</td>
                                <td>'.$org_land_revenue_years.'</td>
                                <td>'.$dag_no.'</td>
                                <td style="white-space: nowrap;">'.$area.'</td>
                                <td style="white-space: nowrap;" class="text-right pr-2">+₹ '.($total_amount - $org_reclass_amount - $org_land_revenue_years).'</td>
                            </tr>';

                    $trArr .= '<tr>
                                <td colspan="6" class="text-center"><b>২৫ বছৰৰ মূলধনীকৃত ভূমি ৰাজহ</b></td>
                                <td class="text-right pr-2"><b>₹ '.$org_land_revenue_years.'</b></td>
                            </tr>';
                    $trArr .= '<tr>
                                <td colspan="6" class="text-center"><b>শ্ৰেণী পৰিৱৰ্তন ও স্থানান্তৰ প্ৰিমিয়াম মূল্য (যদি প্ৰযোজ্য)</b></td>
                                <td class="text-right pr-2"><b>₹ '.$org_reclass_amount.'</b></td>
                            </tr>';
                           
                    
                }

                $final_reclass_amount = $reclass_amount;
                $final_land_revenue_years = $land_revenue_years;
                $total_reclass_revenue = $reclass_amount;
                $final_settlement_amount = ($settlement_amount - ceil($total_reclass_revenue));

                

                $trArr .= '<tr>
                                <td colspan="6" class="text-center"><b>মুঠ দিবলগীয়া প্ৰিমিয়াম</b></td>
                                <td class="text-right pr-2"><b>₹ '.$net_premium_payable.'</b></td>
                            </tr>';


                $data['net_premium_payable'] = $net_premium_payable;
                $data['final_reclass_amount'] = $reclass_amount;
                $data['final_land_revenue_years'] = ceil($final_land_revenue_years);
                $data['final_settlement_amount'] = ($settlement_amount - ceil($total_reclass_revenue));


                $data['tbody'] = $trArr;

                
            }
            else
            {
                $this->session->set_flashdata('message', "#ERR2533: Unable to process! Something went wrong...#".$case_no);
                redirect(base_url().'index.php/home');
            }
            $this->load->view('SettlementView/include/juridical_premium_notice_central_govt', $data);
        }
        else if($insDetails->ins_cat_type_co == '11')
        {

            $data['service_name_pre'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities-Land Transfer/ Settlement to Central Govt Department/Central Govt Undertakings';


            $data['service_name'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities';

            $premium_data = $this->db->query("SELECT * from settlement_premium where case_no=? and is_final=?", array($case_no, 1));
            if($premium_data->num_rows() > 0)
            {
                
                $premium_data_row = $premium_data->row();
                $premium_data_arr = $premium_data->result();

                if(!isset($dags))
                {
                    //****show error */
                    $this->session->set_flashdata('message', "#ERR2018: Something went wrong!...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                foreach($dags as $dag_item)
                {
                    $premiumSql = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $dag_item->dag_no, 1));
            
                    if($premiumSql->num_rows() <= 0)
                    {
                        //****show error */
                        $this->session->set_flashdata('message', "#ERR2029: Something went wrong!...#".$case_no);
                        redirect(base_url().'index.php/home');
                    }

                }


                // if(($data['dept_order_no'] == null || $data['dept_order_no'] == '' || empty($data['dept_order_no'])) || ($data['dept_order_date'] == null || $data['dept_order_date'] == '' || empty($data['dept_order_date'])))
                // {
                //     $this->session->set_flashdata('message', "#ERR1913: Unable to process! Something went wrong...#".$case_no);
                //     redirect(base_url().'index.php/home');
                // }

                if($data['date_of_sldc'] == null || $data['date_of_sldc'] == '' || empty($data['date_of_sldc']))
                {
                    $this->session->set_flashdata('message', "#ERR2039: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                // if($basic['dept_order_date'] == null || $basic['dept_order_date'] == '' || empty($basic['dept_order_date']))
                // {
                //     $this->session->set_flashdata('message', "#ERR203935: Unable to process! Something went wrong...#".$case_no);
                //     redirect(base_url().'index.php/home');
                // }

                $trArr = '';
                $area_all = array();
                $dag_arr = array();
                $data['actual_premium'] = 0;
                $reclass_amount = 0;
                $land_revenue_years = 0;
                $settlement_amount = 0;

                $sl_counter = 1;

                foreach($premium_data_arr as $premium)
                {
                    
                
                    $premium_per_bigha = $premium->zonal_valuation;
                    $dag_no = $premium->dag_no;
                    $dag_arr[] = $premium->dag_no;
                    $total_lessa = $premium->total_lessa;
                    if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                    {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa);
                        $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                    }
                    else
                    {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                        // $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                        $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                    }

                    $data['first_area'] = implode ( ", ", $area_all );
                    $data['first_dag_no'] = implode ( ", ", $dag_arr );
                    $total_amount = ceil($premium->amount_dag);
                    $net_premium_payable = ceil($premium->final_amount);
                    $org_reclass_amount = ceil($premium->ins_reclass_amount);
                    $org_land_revenue_years = ceil($premium->land_revenue_years);

                    $reclass_amount += $premium->ins_reclass_amount;
                    $land_revenue_years += $premium->land_revenue_years;
                    $settlement_amount += $total_amount;
                    
                    $mandolikPremium = "মাণ্ডলিক মূল্যৰ ১০০%";
                    
                    
                    $loloCounter = 1;
                    $trArr .= '<tr>
                                <td rowspan="'.$loloCounter.'" class="text-center">'.$sl_counter++.'</td>
                                <td>
                                    ভূমিৰ বন্দৱস্তী/হস্তান্তৰ প্ৰিমিয়াম মূল্য<br>'.$mandolikPremium.'
                                </td>
                                <td>'.$premium_per_bigha.'</td>
                                <td>'.$org_land_revenue_years.'</td>
                                <td>'.$dag_no.'</td>
                                <td style="white-space: nowrap;">'.$area.'</td>
                                <td style="white-space: nowrap;" class="text-right pr-2">+₹ '.($total_amount - $org_reclass_amount - $org_land_revenue_years).'</td>
                            </tr>';

                    $trArr .= '<tr>
                                <td colspan="6" class="text-center"><b>২৫ বছৰৰ মূলধনীকৃত ভূমি ৰাজহ</b></td>
                                <td class="text-right pr-2"><b>₹ '.$org_land_revenue_years.'</b></td>
                            </tr>';
                    $trArr .= '<tr>
                                <td colspan="6" class="text-center"><b>শ্ৰেণী পৰিৱৰ্তন ও স্থানান্তৰ প্ৰিমিয়াম মূল্য (যদি প্ৰযোজ্য)</b></td>
                                <td class="text-right pr-2"><b>₹ '.$org_reclass_amount.'</b></td>
                            </tr>';
                           
                    
                }

                $final_reclass_amount = $reclass_amount;
                $final_land_revenue_years = $land_revenue_years;
                $total_reclass_revenue = $reclass_amount;
                $final_settlement_amount = ($settlement_amount - ceil($total_reclass_revenue));

                

                $trArr .= '<tr>
                                <td colspan="6" class="text-center"><b>মুঠ দিবলগীয়া প্ৰিমিয়াম</b></td>
                                <td class="text-right pr-2"><b>₹ '.$net_premium_payable.'</b></td>
                            </tr>';


                $data['net_premium_payable'] = $net_premium_payable;
                $data['final_reclass_amount'] = $reclass_amount;
                $data['final_land_revenue_years'] = ceil($final_land_revenue_years);
                $data['final_settlement_amount'] = ($settlement_amount - ceil($total_reclass_revenue));


                $data['tbody'] = $trArr;

                
            }
            else
            {
                $this->session->set_flashdata('message', "#ERR2533: Unable to process! Something went wrong...#".$case_no);
                redirect(base_url().'index.php/home');
            }
            $this->load->view('SettlementView/include/juridical_premium_notice_central_govt_settlement', $data);
        }
        else if($insDetails->ins_cat_type_co == '9' && $apLmnoteDetails->already_alloted == 'Y')
        {

            $data['service_name_pre'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities- Settlement_State Govt Undertakings';

            $data['service_name'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities';


            $premium_data = $this->db->query("SELECT * from settlement_premium where case_no=? and is_final=?", array($case_no, 1));
            if($premium_data->num_rows() > 0)
            {
                
                $premium_data_row = $premium_data->row();
                $premium_data_arr = $premium_data->result();

                if(!isset($dags))
                {
                    //****show error */
                    $this->session->set_flashdata('message', "#ERR2018: Something went wrong!...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                foreach($dags as $dag_item)
                {
                    $premiumSql = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $dag_item->dag_no, 1));
            
                    if($premiumSql->num_rows() <= 0)
                    {
                        //****show error */
                        $this->session->set_flashdata('message', "#ERR2029: Something went wrong!...#".$case_no);
                        redirect(base_url().'index.php/home');
                    }

                }


                if(($data['dept_order_no'] == null || $data['dept_order_no'] == '' || empty($data['dept_order_no'])) || ($data['dept_order_date'] == null || $data['dept_order_date'] == '' || empty($data['dept_order_date'])))
                {
                    $this->session->set_flashdata('message', "#ERR1913: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                if($data['date_of_sldc'] == null || $data['date_of_sldc'] == '' || empty($data['date_of_sldc']))
                {
                    $this->session->set_flashdata('message', "#ERR2039: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                if($basic['dept_order_date'] == null || $basic['dept_order_date'] == '' || empty($basic['dept_order_date']))
                {
                    $this->session->set_flashdata('message', "#ERR203935: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                $trArr = '';
                $area_all = array();
                $dag_arr = array();
                $data['actual_premium'] = 0;
                $reclass_amount = 0;
                $land_revenue_years = 0;
                $settlement_amount = 0;
                $sl_counter = 1;

                foreach($premium_data_arr as $premium)
                {
                    
                
                    $premium_per_bigha = $premium->zonal_valuation;
                    $dag_no = $premium->dag_no;
                    $dag_arr[] = $premium->dag_no;
                    $total_lessa = $premium->total_lessa;
                    if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                    {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa);
                        $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                    }
                    else
                    {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                        // $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                        $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                    }

                    $data['first_area'] = implode ( ", ", $area_all );
                    $data['first_dag_no'] = implode ( ", ", $dag_arr );
                    $total_amount = ceil($premium->amount_dag);
                    $net_premium_payable = ceil($premium->final_amount);
                    $org_reclass_amount = ceil($premium->ins_reclass_amount);
                    $org_land_revenue_years = ceil($premium->land_revenue_years);


                    $reclass_amount += $premium->ins_reclass_amount;
                    $land_revenue_years += $premium->land_revenue_years;
                    $settlement_amount += $total_amount;
                   
                    
                    $mandolikPremium = "মাণ্ডলিক মূল্যৰ ১০০%";
                    
                    
                    $loloCounter = 1;
                    $trArr .= '<tr>
                                <td rowspan="'.$loloCounter.'" class="text-center">'.$sl_counter++.'</td>
                                <td>
                                    বন্দৱস্তীৰ প্ৰিমিয়াম মূল্য <br> '.$mandolikPremium.'
                                </td>
                                <td>'.$premium_per_bigha.'</td>
                                <td>'.$dag_no.'</td>
                                <td style="white-space: nowrap;">'.$area.'</td>
                                <td style="white-space: nowrap;" class="text-right pr-2">+₹ '.($total_amount - $org_reclass_amount).'</td>
                            </tr>';

                    
                    $trArr .= '<tr>
                                <td colspan="5" class="text-center"><b>শ্ৰেণী পৰিৱৰ্তন ও স্থানান্তৰ প্ৰিমিয়াম মূল্য (যদি প্ৰযোজ্য)</b></td>
                                <td class="text-right pr-2"><b>₹ '.$org_reclass_amount.'</b></td>
                            </tr>';
                           
                    
                }

                $final_reclass_amount = $reclass_amount;
                $final_land_revenue_years = $land_revenue_years;
                $total_reclass_revenue = $reclass_amount;
                $final_settlement_amount = ($settlement_amount - ceil($total_reclass_revenue));

                

                $trArr .= '<tr>
                                <td colspan="5" class="text-center"><b>মুঠ দিবলগীয়া প্ৰিমিয়াম</b></td>
                                <td class="text-right pr-2"><b>₹ '.$net_premium_payable.'</b></td>
                            </tr>';


                $data['net_premium_payable'] = $net_premium_payable;
                $data['final_reclass_amount'] = $reclass_amount;
                $data['final_land_revenue_years'] = $land_revenue_years;
                $data['final_settlement_amount'] = ($settlement_amount - ceil($total_reclass_revenue));


                $data['tbody'] = $trArr;

                
            }
            else
            {
                $this->session->set_flashdata('message', "#ERR2533: Unable to process! Something went wrong...#".$case_no);
                redirect(base_url().'index.php/home');
            }
            $this->load->view('SettlementView/include/juridical_premium_notice_settlement_state_govt_undertakings', $data);
        }
        else if($insDetails->ins_cat_type_co == '9' && $apLmnoteDetails->already_alloted == 'N')
        {
            $data['service_name_pre'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities- Allotment to State Govt Undertakings';
            $data['service_name'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities';
            $premium_data = $this->db->query("SELECT * from settlement_premium where case_no=? and is_final=?", array($case_no, 1));
            if($premium_data->num_rows() > 0)
            {
                
                $premium_data_row = $premium_data->row();
                $premium_data_arr = $premium_data->result();

                if(!isset($dags))
                {
                    //****show error */
                    $this->session->set_flashdata('message', "#ERR2018: Something went wrong!...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                foreach($dags as $dag_item)
                {
                    $premiumSql = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $dag_item->dag_no, 1));
            
                    if($premiumSql->num_rows() <= 0)
                    {
                        //****show error */
                        $this->session->set_flashdata('message', "#ERR2029: Something went wrong!...#".$case_no);
                        redirect(base_url().'index.php/home');
                    }

                }


                // if(($data['dept_order_no'] == null || $data['dept_order_no'] == '' || empty($data['dept_order_no'])) || ($data['dept_order_date'] == null || $data['dept_order_date'] == '' || empty($data['dept_order_date'])))
                // {
                //     $this->session->set_flashdata('message', "#ERR1913: Unable to process! Something went wrong...#".$case_no);
                //     redirect(base_url().'index.php/home');
                // }

                if($data['date_of_sldc'] == null || $data['date_of_sldc'] == '' || empty($data['date_of_sldc']))
                {
                    $this->session->set_flashdata('message', "#ERR2039: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                // if($basic['dept_order_date'] == null || $basic['dept_order_date'] == '' || empty($basic['dept_order_date']))
                // {
                //     $this->session->set_flashdata('message', "#ERR203935: Unable to process! Something went wrong...#".$case_no);
                //     redirect(base_url().'index.php/home');
                // }

                $trArr = '';
                $area_all = array();
                $dag_arr = array();
                $data['actual_premium'] = 0;
                $reclass_amount = 0;
                $settlement_amount = 0;
                $land_revenue_years = 0;
                $sl_counter = 1;

                foreach($premium_data_arr as $premium)
                {
                    
                
                    $premium_per_bigha = $premium->zonal_valuation;
                    $dag_no = $premium->dag_no;
                    $dag_arr[] = $premium->dag_no;
                    $total_lessa = $premium->total_lessa;
                    if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                    {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa);
                        $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                    }
                    else
                    {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                        // $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                        $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                    }

                    $data['first_area'] = implode ( ", ", $area_all );
                    $data['first_dag_no'] = implode ( ", ", $dag_arr );
                    $total_amount = ceil($premium->amount_dag);
                    $net_premium_payable = ceil($premium->final_amount);
                    $org_reclass_amount = ceil($premium->ins_reclass_amount);
                    $org_land_revenue_years = ceil($premium->land_revenue_years);

                    $reclass_amount += $premium->ins_reclass_amount;
                    $land_revenue_years += $premium->land_revenue_years;
                    $settlement_amount += $total_amount;



                    $mandolikPremium = null;
                    
                    $mandolikPremium = "মাণ্ডলিক মূল্যৰ ১০০%";
                    
                    $loloCounter = 1;
                    $trArr .= '<tr>
                                <td rowspan="'.$loloCounter.'" class="text-center">'.$sl_counter++.'</td>
                                <td>
                                    বন্দৱস্তী প্ৰিমিয়াম মূল্য <br>'.$mandolikPremium.'
                                </td>
                                <td>'.$premium_per_bigha.'</td>
                                <td>'.$dag_no.'</td>
                                <td style="white-space: nowrap;">'.$area.'</td>
                                <td style="white-space: nowrap;" class="text-right pr-2">+₹ '.($total_amount * 2).'</td>
                            </tr>';
                           
                    
                }
                $final_reclass_amount = $reclass_amount;
                $final_land_revenue_years = $land_revenue_years;
                $total_reclass_revenue = $reclass_amount;
                $final_settlement_amount = ($settlement_amount - ceil($total_reclass_revenue));


                // $trArr .= '<tr>
                //                 <td colspan="5" class="text-center"><b>মুঠ দিবলগীয়া প্ৰিমিয়াম</b></td>
                //                 <td class="text-right pr-2"><b>₹ '.($net_premium_payable * 2).'</b></td>
                //             </tr>';

                $trArr .= '<tr>
                                <td colspan="5" class="text-center"><b>আবণ্টনৰ বাবে দিবলগীয়া প্ৰিমিয়াম (মুঠ বন্দৱস্তী প্ৰিমিয়ামৰ ৫০ শতাংশ)</b></td>
                                <td class="text-right pr-2"><b>₹ '.$net_premium_payable.'</b></td>
                            </tr>';


                $data['net_premium_payable'] = $net_premium_payable;

                $data['final_reclass_amount'] = $reclass_amount;
                $data['final_land_revenue_years'] = $land_revenue_years;
                $data['final_settlement_amount'] = ($settlement_amount - ceil($total_reclass_revenue));


                $data['tbody'] = $trArr;

                
            }
            else
            {
                $this->session->set_flashdata('message', "#ERR2533: Unable to process! Something went wrong...#".$case_no);
                redirect(base_url().'index.php/home');
            }
            $this->load->view('SettlementView/include/juridical_premium_notice_allotment_state_govt_undertakings', $data);
        }
        else if($insDetails->ins_cat_type_co == '12' && $apLmnoteDetails->already_alloted == 'N' && $insDetails->purpose_land_allot_co == 'education' && $insDetails->under_venture_school == 'YES' && $insDetails->venture_type =='govt_aided_venture')
        {
            $data['service_name_pre'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities-Allotment to Govt Aided Venture School';

            $data['service_name'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities';
            $premium_data = $this->db->query("SELECT * from settlement_premium where case_no=? and is_final=?", array($case_no, 1));
            if($premium_data->num_rows() > 0)
            {
                
                $premium_data_row = $premium_data->row();
                $premium_data_arr = $premium_data->result();

                if(!isset($dags))
                {
                    //****show error */
                    $this->session->set_flashdata('message', "#ERR2018: Something went wrong!...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                foreach($dags as $dag_item)
                {
                    $premiumSql = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $dag_item->dag_no, 1));
            
                    if($premiumSql->num_rows() <= 0)
                    {
                        //****show error */
                        $this->session->set_flashdata('message', "#ERR2029: Something went wrong!...#".$case_no);
                        redirect(base_url().'index.php/home');
                    }

                }


                if(($data['dept_order_no'] == null || $data['dept_order_no'] == '' || empty($data['dept_order_no'])) || ($data['dept_order_date'] == null || $data['dept_order_date'] == '' || empty($data['dept_order_date'])))
                {
                    $this->session->set_flashdata('message', "#ERR1913: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                if($data['date_of_sldc'] == null || $data['date_of_sldc'] == '' || empty($data['date_of_sldc']))
                {
                    $this->session->set_flashdata('message', "#ERR2039: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                if($basic['dept_order_date'] == null || $basic['dept_order_date'] == '' || empty($basic['dept_order_date']))
                {
                    $this->session->set_flashdata('message', "#ERR203935: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                $trArr = '';
                $area_all = array();
                $dag_arr = array();
                $data['actual_premium'] = 0;
                $reclass_amount = 0;
                $land_revenue_years = 0;
                $settlement_amount=0;

                $sl_counter = 1;

                foreach($premium_data_arr as $premium)
                {
                    
                    $dag_no = $premium->dag_no;
                    $SingleDagCheck = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ? and dag_no = ?", array($case_no, $dag_no))->row();


                    $premium_per_bigha = $premium->zonal_valuation;
                    
                    $dag_arr[] = $premium->dag_no;
                    $total_lessa = $premium->total_lessa;
                    if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                    {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa);
                        $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                    }
                    else
                    {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                        // $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                        $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                    }

                    $data['first_area'] = implode ( ", ", $area_all );
                    $data['first_dag_no'] = implode ( ", ", $dag_arr );
                    $total_amount = ceil($premium->amount_dag);
                    // $total_amount = $total_amount * 2;
                    $net_premium_payable = ceil($premium->final_amount);

                    $reclass_amount += $premium->ins_reclass_amount;
                    $land_revenue_years += $premium->land_revenue_years;
                    $settlement_amount += $total_amount;


                    $mandolikPremium = null;
                    if($SingleDagCheck->is_urban == 'N' && $premium->area_name == 10)
                    {
                        $mandolikPremium = "Rs 250-Rural Area";
                    }
                    else
                    {
                        $mandolikPremium = "Rs 25000-Urban Area";
                    }
                    $loloCounter = 1;
                    $trArr .= '<tr>
                                <td rowspan="'.$loloCounter.'" class="text-center">'.$sl_counter++.'</td>
                                <td>
                                   আবণ্টন প্ৰিমিয়াম মূল্য 
                                </td>
                                <td>'.$mandolikPremium.'</td>
                                <td>'.$dag_no.'</td>
                                <td style="white-space: nowrap;">'.$area.'</td>
                                <td style="white-space: nowrap;" class="text-right pr-2">+₹ '.$total_amount.'</td>
                            </tr>';
                           
                    
                }


                $trArr .= '<tr>
                                <td colspan="5" class="text-center"><b>মুঠ প্ৰিমিয়াম </b></td>
                                <td class="text-right pr-2"><b>₹ '.$net_premium_payable.'</b></td>
                            </tr>';


                $data['net_premium_payable'] = $net_premium_payable;
                $data['final_reclass_amount'] = $reclass_amount;
                $data['final_land_revenue_years'] = $land_revenue_years;
                $total_reclass_revenue = $reclass_amount;
                $data['final_settlement_amount'] = ($settlement_amount - ceil($total_reclass_revenue));
                $data['tbody'] = $trArr;

                
            }
            else
            {
                $this->session->set_flashdata('message', "#ERR2533: Unable to process! Something went wrong...#".$case_no);
                redirect(base_url().'index.php/home');
            }
            $this->load->view('SettlementView/include/juridical_premium_notice_settlement_non_govt_education_govt_aided', $data);
        }
    }

    public function savePaymentNotice()
    {
        $case_no = $this->input->post('case_no'); 

        $this->db->trans_begin();

        $noticeAlreadyGeneratedCheck = $this->db->query('select * from settlement_notice where case_no = ? and notice_type = ?', array($case_no, 'PN'));

        $old_notice_link = false;
        
        if($noticeAlreadyGeneratedCheck->num_rows() > 0)
        {
         
            //******re-generate premium notice first check if payment already done for this case_no */
            $paymentStatusCheck = $this->basundhara3Model->paymentStatusCheck($case_no);
            // var_dump($case_no);die;

            if($paymentStatusCheck['responseType'] != 2)
            {
                $this->session->set_flashdata('message', "#ERRINS18435896: Payment already made by citizen for this application # ".$case_no);
                redirect(base_url() . "index.php/home");
            }

            //***getting the old notice link before deleting it */
            $old_notice_link = $noticeAlreadyGeneratedCheck->row()->notice_link;

            //***delete the notice */

            $this->db->query('delete from settlement_notice where case_no = ? and notice_type = ?', array($case_no, 'PN'));

            if($this->db->affected_rows() != 1)
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#ERRINS1843444: Unable to process! Something went wrong... # ".$case_no);
                redirect(base_url() . "index.php/home");
            }

            // $this->session->set_flashdata('message', "#ERR1843: Premium notice already generated # ".$case_no);
            // redirect(base_url() . "index.php/home");
        }



        // replacing file case number to savable format
        $new_case_no = str_replace('/', "-", $case_no);
        $timestamp = date('mdYhis', time()).uniqid();

        // creating and saving the base64 format payment notice to uploads/paymentNotice folder
        $base_64_file_path = PAYMENT_NOTICE_PATH . $new_case_no.'_'.$timestamp. ".json";
        $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
        $htmlstring_text = json_encode($this->input->post('htmlstring_text'));
        fwrite($file_to_write_base64, $htmlstring_text);
        fclose($file_to_write_base64);
        $amount = $this->input->post('amount');
        $settlement_amount = $this->input->post('settlement_amount');
        $reclass_amount = $this->input->post('reclass_amount');
        $land_revenue_amount = $this->input->post('land_revenue_amount');
        $ins_cat_type_co = $this->input->post('ins_cat_type_co');
        $remark_co = $this->input->post('remark');
        $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);

        $case_user_case = $get_settlement_basic->co_code;


        // var_dump($noticeAlreadyGeneratedCheck->num_rows());die;
        if($this->session->userdata('user_desig_code') != 'CO')
        {
            $this->session->set_flashdata('message', "#ERR2046: Session timeout! Please login and try again # ".$case_no);
            redirect(base_url() . "index.php/home");
        }



        $get_dag_details = $this->SettlementApModel->getSettlementDagDetails($case_no);
        $get_settlement_applicant = $this->SettlementApModel->getAllApplicant($case_no);
        $instituteDetails = $this->SettlementInsModel->getInstitutionDetails($case_no);
        $lmNote = $this->db->query("select * from settlement_ap_lmnote where case_no = ?",array($case_no))->row();

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
                    'INS_NAME'      => $instituteDetails->ins_name_co,
                    'INS_ASS_NAME'  => $instituteDetails->ins_name_assamese,
                    'DEPARTMENT_NAME' => $instituteDetails->dept_of_co,
                    'DEPARTMENT_NAME_ASS' => $instituteDetails->dept_of_co_assamese,
                    'MINISTRY'      => $instituteDetails->ministry_of_co
                ];
        }

        $controller = '';

        if($get_settlement_basic->service_code == SLIJE_ID)
        {
            $notice_no = "MB3/PN/" . date('Y') . "/SLIJE/" . $service_details->petition_no;
            $controller = 'SettlementInstitutionCo';
        }
        $ooa_oos = null;
        $task = 'Payment notice generated';
        if(NIJE_OFFER_OF_ALLOTMENT_SETTLEMENT == 1 && NIJE_OFFER_OF_ALLOTMENT_SETTLEMENT_DATE <= date('Y-m-d'))
        {
            $ooa_oos = 'YES';
            $task = 'OOA/OOS Generated';
        }
        

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
            'settlement_amount'=>$settlement_amount,
            'reclass_amount' => $reclass_amount,
            'land_revenue_amount' => $land_revenue_amount,
            'ins_cat_type_co' => $ins_cat_type_co,
            'offer_of_allot_settlement' => $ooa_oos
        ];
        $insertIntoSettlementNotice = $this->db->insert('settlement_notice', $insertIntoSettlementNotice);
        if ($insertIntoSettlementNotice != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRPN00678: Insertion failed in settlement_notice');
            $this->session->set_flashdata('message', "#INSPAYAPI0016 Payment notice  could not be generated...");
            redirect(base_url() . 'index.php/SettlementInstitutionCo/generatePaymentNoticeCo?case=' . enc_param('case', $case_no, 600));
            return false;
        }



        $insertIntoSettlementNoticeHistory = [
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
            'settlement_amount'=>$settlement_amount,
            'reclass_amount' => $reclass_amount,
            'land_revenue_amount' => $land_revenue_amount,
            'ins_cat_type_co' => $ins_cat_type_co,
            'offer_of_allot_settlement' => $ooa_oos
        ];
        $insertIntoSettlementNoticeHistory = $this->db->insert('settlement_notice_ins_history', $insertIntoSettlementNoticeHistory);
        if ($insertIntoSettlementNoticeHistory != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRPN00678: Insertion failed in settlement_notice');
            $this->session->set_flashdata('message', "#INSPAYAPI0016 Payment notice  could not be generated...");
            redirect(base_url() . 'index.php/SettlementInstitutionCo/generatePaymentNoticeCo?case=' . enc_param('case', $case_no, 600));
            return false;
        }


        $landType = null;
        $chitha_processing_details = 0;
        if($instituteDetails->ins_cat_type_co == '12' && $lmNote->already_alloted == 'N')
        {
            $landType = '12_allotment';
            // $chitha_processing_details = 2;
        }
        else if($instituteDetails->ins_cat_type_co == '12' && $lmNote->already_alloted == 'Y')
        {
            // $this->session->set_flashdata('message', "#ERR2046: Session timeout! Please login and try again # ".$case_no);
            // redirect(base_url() . "index.php/home");
            $landType = '12_settlement';
            // $chitha_processing_details = 0;
        }
        else if(($instituteDetails->ins_cat_type_co == '10' || $instituteDetails->ins_cat_type_co == '11'))
        {
            // $this->session->set_flashdata('message', "#ERR2046: Session timeout! Please login and try again # ".$case_no);
            // redirect(base_url() . "index.php/home");
            $landType = '10_transfer';
            // $chitha_processing_details = 0;
        }
        else if(($instituteDetails->ins_cat_type_co == '9' && $lmNote->already_alloted == 'Y'))
        {
            // $this->session->set_flashdata('message', "#ERR2046: Session timeout! Please login and try again # ".$case_no);
            // redirect(base_url() . "index.php/home");
            $landType = '9_settlement';
            // $chitha_processing_details = 0;
        }
        else if(($instituteDetails->ins_cat_type_co == '9' && $lmNote->already_alloted == 'N'))
        {
            $landType = '9_allotment';
            // $chitha_processing_details = 2;
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
            // 'chitha_processing_details' => $chitha_processing_details,
            'allotment_settlement_transfer' => $landType,
            'offer_of_allot_settlement' => $ooa_oos
        ];
        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $updateArr);
        // var_dump($this->db->affected_rows());die;
        if ($this->db->affected_rows() != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRPN0001: Updation Failed in settlement_basic table');
            $this->session->set_flashdata('message', "#KHASPAYAPI0015 Payment notice  could not be generated...");
            redirect(base_url() . 'index.php/SettlementInstitutionCo/generatePaymentNoticeCo?case=' . enc_param('case', $case_no, 600));
            return false;
        }
        // var_dump($noticeAlreadyGeneratedCheck->num_rows());die;

        

        //******check if CO aggreed with concession even after caste is general */
        $data['caste'] = $get_settlement_basic->caste;
        $applicants_buyers   = $this->SettlementInsModel->getAllApplicantBuyers($case_no);

        foreach($applicants_buyers as $applicant)
        {
            if($applicant->is_applicant == 1)
            {
                $data['if_widow'] = $applicant->marital_status;
            }
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
            'task' => $task,
            'old_file_link' => $old_notice_link == false ? null:$old_notice_link,
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if ($insertProc != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRPINSN0002: Insertion failed in settlement_proceeding');
            $this->session->set_flashdata('message', "#ERRINSPN0002 Payment notice  could not be generated...");
            redirect(base_url() . 'index.php/SettlementInstitutionCo/generatePaymentNoticeCo?case=' . enc_param('case', $case_no, 600));
            return false;
        }

        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#ERRINSPNAPI0002 Payment notice  could be generated...");
            redirect(base_url() . 'index.php/SettlementInstitutionCo/generatePaymentNoticeCo?case=' . enc_param('case', $case_no, 600));
            exit;
        } else {
            // API CALL HERE
            $rtps_case_no = $get_settlement_basic->applid;

            /// check full pay
            $is_full_pay ='Y';
            // upload notice API
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "uploadNotice");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(

                'encoded_file'       => json_decode($htmlstring_text),
                'application_no'     => $rtps_case_no,
                'type'               => 'PN',
                'amount'             => $amount,
                'reclass_amount'     => $reclass_amount,
                'land_revenue_years' => $land_revenue_amount,
                'settlement_amount'  => $settlement_amount,
                'ins_cat_type_co'    => $ins_cat_type_co,
                'is_full_pay'        => $is_full_pay
            )));
            $result = curl_exec($curl_handle);

            if (trim($result) != 'y') {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#INSPAYAPI0011  Payment notice  could not be generated...Please try again");
                redirect(base_url() . 'index.php/SettlementInstitutionCo/generatePaymentNoticeCo?case=' . enc_param('case', $case_no, 600));
                exit;
            }
            else
            {
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Payment notice successfully saved...");
                redirect(base_url() . 'index.php/SettlementInstitutionCo/generatePaymentNoticeCo?case=' . enc_param('case', $case_no, 600));
            }
           
        }
    }

    public function printNotice()
    {
        $case_no = $this->input->get('case_no');
        // getting the notice file link
        $data['print_data'] = $this->SettlementApModel->getSettlementBasic($case_no);
        // reading the base64 json file and saving it to a variable
        $path = $this->SettlementCommonModel->downloadNotice($data['print_data']['co_notice_link']);
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

    public function confirmPaymentCo()
    {

        $case_no = $this->input->get('case');
        $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
        // var_dump($get_settlement_basic); die();
        $case_no_rtps = $get_settlement_basic->applid;

        $instituteDetails = $this->SettlementInsModel->getInstitutionDetails($case_no);

        $lmNote = $this->db->query('select * from settlement_ap_lmnote where case_no = ? order by id desc limit 1', array($case_no))->row();
        $data = array();
        $landType = null;
        $chitha_processing_details = 0;
        $lraVerificationUsed = true;
        if($instituteDetails->ins_cat_type_co == '12' && $lmNote->already_alloted == 'N')
        {
            $landType = '12_allotment';
            // $chitha_processing_details = 2;
        }
        else if($instituteDetails->ins_cat_type_co == '12' && $lmNote->already_alloted == 'Y')
        {
            $landType = '12_settlement';
            // $chitha_processing_details = 0;
            $lraVerificationUsed =true;
        }
        else if(($instituteDetails->ins_cat_type_co == '10' || $instituteDetails->ins_cat_type_co == '11'))
        {
            $landType = '10_transfer';
            // $chitha_processing_details = 0;
            $lraVerificationUsed = true;
        }
        else if(($instituteDetails->ins_cat_type_co == '9' && $lmNote->already_alloted == 'Y'))
        {
            $landType = '9_settlement';
            // $chitha_processing_details = 0;
            $lraVerificationUsed=true;
        }
        else if(($instituteDetails->ins_cat_type_co == '9' && $lmNote->already_alloted == 'N'))
        {
            $landType = '9_allotment';
            // $chitha_processing_details = 2;
        }
        

        // payment status check thourgh API
        $payment_status_check = $this->basundhara3Model->paymentConfirmation($case_no_rtps);

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




        $PaymentFlagConsider = false;
        if(in_array($instituteDetails->ins_cat_type_co,array('9','10','11','12')))
        {
     
            $PaymentFlagConsider = true;
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
        }
        else
        {

            $sqlCheck = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ? and grn_no is not null limit 1', array($case_no, 1));

            if ($sqlCheck->num_rows() > 0) {
                $preData = $sqlCheck->row();

                $data = [
                    'case_no' => $case_no,
                    'payment_status' => 'y',
                    'payment_date' => $preData->payment_date,
                    'case_no_rtps' => $case_no_rtps,
                    'total_premium' => $preData->total_premium,
                    'paid_amount' => $preData->paid_amount,
                    'remaining_amount' => $preData->remaining_amount,
                    'tenure' =>$preData->tenure,
                    'installment_amount' => $preData->installment_amount,
                    'percentage' => 100
                ];
            }
        }

        if (strtoupper($pay_status) == 'Y' && $PaymentFlagConsider == true) 
        {
            $sqlCheck = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ? and grn_no is null limit 1', array($case_no, 1));

            if ($sqlCheck->num_rows() > 0) {
                $this->db->trans_begin();

                $dagsResult = $this->SettlementInsModel->getSettlementDag($case_no);
                $isFullPay = 'YES';

                // if ($payment_status_check->total_premium != $payment_status_check->paid_amount) {
                //     $isFullPay = 'NO';
                // }

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
        $data['nomTrans'] = false;
        $data['nomReal'] = false;
        $data['lraVerificationUsed'] = $lraVerificationUsed;
        $data['PaymentFlagConsider'] = $PaymentFlagConsider;

        $data['land_purpose_allot_co'] = $instituteDetails->purpose_land_allot_co;


        if ($get_settlement_basic->service_code == SLIJE_ID) {
            $pattasqll = "SELECT type_code, patta_type FROM patta_code where settlement='y' order by type_code asc";
            $data['_view'] = 'settlement_mb/confirmPaymentViewIns';
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
            // if ($get_settlement_basic->service_code == '14') {
            //     $getAppTransSql = $this->db->query('select * from settlement_approval_transaction where case_no = ? and dag_no = ?', array($case_no, $dagRow->new_dag_no));
            // } else {
            $getAppTransSql = $this->db->query('select * from settlement_approval_transaction where case_no = ? and dag_no = ?', array($case_no, $dagRow->dag_no));
            // }

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
                $dagRow->land_purpose = $appRow->land_purpose;
                $dagRow->new_existing_land_type = $appRow->existing_land_type;
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

    public function coApproveLmReport()
    {
        $case_no = $this->input->post('case_no');
        $getBasicSql = $this->db->query('select * from settlement_basic where case_no = ?', array($case_no))->row();

        $this->db->trans_begin();

        //****insert nominee OR delete nominee if AVAIL*/
        $sqlNominee = $this->db->query('select * from settlement_nominee_transaction where case_no = ?', array($case_no));

        $nomineeCount = 0;

        

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

            // if ($getBasicSql->service_code != '18') {
                // if (trim($approvRow->patta_type_code) == '0203') {
                //     $this->db->trans_rollback();
                //     echo json_encode([
                //         'responseType' => 0,
                //         'msg' => '#ERR36456: বিশেষ ম্যাদী patta type is only allowed in Special Cultivation!',
                //     ]);
                //     return false;
                // }
            // }

            // if ($getBasicSql->service_code == '14') {
            //     $getDagsSql = $this->db->query('select * from settlement_dag_details where case_no = ? and new_dag_no = ?', array($case_no, $approvRow->dag_no));
            // } else {
            $getDagsSql = $this->db->query('select * from settlement_dag_details where case_no = ? and dag_no = ?', array($case_no, $approvRow->dag_no));
            // }

            if ($getDagsSql->num_rows() <= 0) {
                log_message('error', '#ERR7710285: Case not found in settlement_dag_details' . $this->db->last_query());
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
                'new_existing_land_type' => $approvRow->existing_land_type,
                'new_other_purpose' => $approvRow->other_land_purpose
            ];

            $this->db->where('case_no', $case_no);
            $this->db->where('dag_no', $approvRow->dag_no);

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

        $approvSqlD = $this->db->query('select * from settlement_approval_transaction where case_no = ?', array($case_no));
        $approvResultD = $approvSqlD->row();
        $land_purpose_approved = $approvResultD->land_purpose;

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

        //****udpate basic status */

        ///only other purpose will be updated/////////////
        $InsSql = $this->db->query('select * from settlement_institution_details where case_no = ?', array($case_no));
        $InsSqlData = $InsSql->row();
        $oldPurpose = $InsSqlData->purpose_land_allot_co;
        if(trim($oldPurpose) == 'other')
        {
            
            // $InsArr = [
            //     'purpose_land_allot_co' => $land_purpose_approved
            // ];

            // $this->db->where('case_no', $case_no);
            // $this->db->update('settlement_institution_details', $InsArr);
            // if ($this->db->affected_rows() != 1) {
            //     $this->db->trans_rollback();
            //     echo json_encode([
            //         'responseType' => 0,
            //         'msg' => '#ERR2341890: Unable to approve report!',
            //     ]);
            //     return false;
            // }
        }
        

        //*****delete from transaction table */
        // $this->db->query('delete from settlement_approval_transaction where case_no = ?', array($case_no));
        // if ($this->db->affected_rows() != $approvalCount) {
        //     $this->db->trans_rollback();
        //     echo json_encode([
        //         'responseType' => 0,
        //         'msg' => '#ERR2353: Unable to approve report!',
        //     ]);
        //     return false;
        // }


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
            'task' => 'LRA Verification report approved',
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

        // if ($getPremiumStatus->num_rows() > 0) {
        //     $premiumDate = $getPremiumStatus->row()->payment_date;

        //     $token = $this->utilityclass->createTokenJwt();
        //     //******send premium date */
        //     $curl_handle = curl_init();
        //     curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB2 . "insertSwikritiIssueDate");
        //     curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        //     curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        //     curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        //     curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
        //         'appl_no' => $this->utilityclass->getApplidFromCaseNo($case_no),
        //         'co_approve_date' => date('Y-m-d H:i:s'),
        //         'ip' => $this->utilityclass->get_client_ip(),
        //         'api_key' => API_KEY,
        //         'token' => $token,
        //     )));
        //     $result = curl_exec($curl_handle);

        //     $result = json_decode($result);

        //     if (trim($result->responseType) != 'y') {
        //         $this->db->trans_rollback();
        //         echo json_encode([
        //             'responseType' => 0,
        //             'msg' => '#ERR2701: Unable to approve report!',
        //         ]);
        //         return false;
        //     }
        // }

        $this->db->trans_commit();
        echo json_encode([
            'responseType' => 2,
            'msg' => 'Report successfully approved...',
        ]);

    }

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
        $due_amount = ceil($result[0]->due_amount);
        $remaining_amount = (float) $due_amount - (float) $_POST['amount'];
        if ($remaining_amount > 0) {
            echo json_encode(['result' => 'FAILED', 'msg' => 'Partial payment for institution is not allowed..!']);
            exit;
            // $is_full_pay = 'NO';
            // $percentage = '30';
            // //***************************************************************************/
            // //Rural Urban Checking
            // $sqlRU = "select area_name from settlement_premium where case_no=? and is_final=1";
            // $queryRU = $this->db->query($sqlRU, array($_POST['case_no']));
            // $resultRU = $queryRU->result();
            // foreach ($resultRU as $rowRU) {
            //     $area_name = trim((string) $rowRU->area_name);
            //     if ($area_name == '7' || $area_name == '8' || $area_name == '9' || $area_name == '10' || $area_name == '18' || $area_name == '19' || $area_name == '20' || $area_name == '21' || $area_name == '22') {
            //         echo json_encode(['result' => 'FAILED', 'msg' => 'Partial payment for rural area is not allowed..!']);
            //         exit;
            //     }
            // }
            //***************************************************************************/
        } else {
            $is_full_pay = 'YES';
            $percentage = '100';
        }
        //***************************************************************** */
        //file moving section
        $file_new_name = "ins_echallan" . trim($_POST['grn_no']);
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
            'grn_no' => $_POST['grn_no'],
            'payment_date' => $_POST['payment_date'],
            'is_full_pay' => $is_full_pay,
            'total_premium' => $due_amount,
            'paid_amount' => $_POST['amount'],
            'remaining_amount' => $remaining_amount,
            'tenure' => '5',
            'installment_amount' => $remaining_amount/5,
            'manual_challan_upload_dir' => $manual_challan_upload_dir,
            'manual_challan_details' => json_encode($_POST),
            'is_manual_challan' => 'Y',
        ];
        
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
                CURLOPT_URL => API_LINK_MB3 . 'updateManualPaymentDetails',
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
                    'installment_amount' => $remaining_amount/5,
                    'percentage' => $percentage,
                ),
            ));
            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            if ($httpcode == 200) {
                $resp = json_decode($response);
                log_message('error','#updateManualPaymentDetails======='.json_encode($resp));
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

    public function chithaBulkList()
    {
        $service_code = $this->input->get('service');
        $status = $this->input->get('s');
        // $data['getPaymentConfirmationCo'] = $this->SettlementMbModel->getLmVerificationCases($service_code);
        $data['select_data'] = $this->SettlementInsModel->locationSelectIns($service_code, $status);
        $data['_view'] = 'settlement_mb/bulk_chitha_update_ins';
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
        $allotment_settlement = $this->input->post('allotment_settlement');

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

        // if (!in_array($s_code, [SETTLEMENT_TENANT_ID, SETTLEMENT_TENANT_URBAN_ID])) {
        //     $this->db->where('chitha_processing_details', 2);
        //     $this->db->where('status', 'N');
        // }else{
        //     $this->db->where('status', 'VN');
        // }

        $this->db->where('chitha_processing_details', 2);
        $this->db->where('status', 'N');
        $this->db->join('settlement_premium sp', 'sp.case_no = a.case_no');
        $this->db->join('settlement_institution_details sid', 'a.case_no = sid.case_no');
        if(!empty($allotment_settlement))
        {
            if($allotment_settlement == '8')
            {
                $this->db->where_in('sid.ins_cat_type_co', array('8'));
            }
            else if($allotment_settlement == '9')
            {
                $this->db->where_in('sid.ins_cat_type_co', array('9'));
            }
            else if($allotment_settlement == '10')
            {
                $this->db->where_in('sid.ins_cat_type_co', array('10'));
            }
            else if($allotment_settlement == '11')
            {
                $this->db->where_in('sid.ins_cat_type_co', array('11'));
            }
            else if($allotment_settlement == '12')
            {
                $this->db->where_in('sid.ins_cat_type_co', array('12'));
            }
        }
        else
        {
            $this->db->where_in('sid.ins_cat_type_co', array('8','9','10','11','12'));
        }
        $this->db->where('sp.is_final', 1);
        $this->db->where('sp.grn_no is not null');
        $this->db->where('a.pending_officer', 'CO');
        $this->db->where('a.from_office', 'CO');
        // if (!in_array($s_code, [SETTLEMENT_TENANT_ID, SETTLEMENT_TENANT_URBAN_ID])) {
        //     $this->db->where('a.from_office', 'CO');
        // } else {
        //     $this->db->where('a.from_office', 'DC');
        // }

        $this->db->where('a.order_passed is null', null, false);
        $this->db->where('a.co_chitha_corrected_yn is null', null, false);
        $this->db->from('settlement_basic a');
        $this->db->select('distinct(a.case_no), a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry,sid.ins_cat_type_co');

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

        // $this->db->join('settlement_dag_details sd', 'sd.case_no = a.case_no');
        // $this->db->where('NOT EXISTS (SELECT 1 FROM settlement_dag_details sd WHERE sd.case_no = a.case_no AND ((sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = \'\' OR sd.new_land_class_agri = \'\')))', NULL, FALSE);

        $query = $this->db->get();
        // echo $this->db->last_query();die;    

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {


                $ins_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>';




                //*****getting the payment made type */
                $getPType = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ?', array($rows->case_no, 1))->row();

                if ($getPType->paid_amount < $getPType->due_amount) {
                    $pTypeText = 'Partial Payment';
                } else if ($getPType->paid_amount >= $getPType->due_amount) {
                    $pTypeText = 'Full Payment';
                } else {
                    $pTypeText = '';
                }

                $insCategory = '';
                $regLink = '';
                if($rows->ins_cat_type_co == '8')
                {
                    $insCategory = "<span style='color:#0cc10c;font-weight:bold'>State govt.</span>";
                }
                else if($rows->ins_cat_type_co == '9')
                {
                    $insCategory = "<span style='color:#242472;font-weight:bold'>State govt Undertakings</span>";
                }
                else if($rows->ins_cat_type_co == '10')
                {
                    $insCategory = "<span style='color:#ffb81d;font-weight:bold'>Central govt</span>";
                }
                else if($rows->ins_cat_type_co == '11')
                {
                    $insCategory = "<span style='color:#ff681d;font-weight:bold'>Central govt Undertakings</span>";
                }
                else if($rows->ins_cat_type_co == '12')
                {
                    $insCategory = "<span style='color:#9d2b2b;font-weight:bold'>Non Govt.(Education/Socio/Religious)</span>";
                    $regLink = '<a type="button" href="' . base_url() . 'index.php/SettlementInstitutionCo/registrationData?case=' . enc_param('case', $rows->case_no, 600) . '" class="lmreportmut btn-sm btn btn-primary mt-1">Enter Registration Info</a>';
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
                    $insCategory,
                    $ins_link."<br>".$regLink

                );

            }

            $this->db->where('a.service_code', $s_code);
            $this->db->where('a.pending_officer', MB_CIRCLE_OFFICER);
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

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

            $this->db->select('distinct(a.case_no), a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry');

            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

            $this->db->where('a.notice_generated_yn', null);
            $this->db->where('status', 'N');

            // if (!in_array($s_code, [SETTLEMENT_TENANT_ID, SETTLEMENT_TENANT_URBAN_ID])) {
            //     $this->db->where('chitha_processing_details', 2);
            //     $this->db->where('status', 'N');
            // }else{
            //     $this->db->where('status', 'VN');
            // }
            $this->db->where('chitha_processing_details', 2);
            $this->db->where('status', 'N');

            $this->db->join('settlement_premium sp', 'sp.case_no = a.case_no');
            $this->db->where('sp.is_final', 1);
            $this->db->where('sp.grn_no is not null');
            $this->db->where('a.from_office', 'CO');
            $this->db->where('a.pending_officer', 'CO');
            // if (!in_array($s_code, [SETTLEMENT_TENANT_ID, SETTLEMENT_TENANT_URBAN_ID])) {
            //     $this->db->where('a.from_office', 'CO');
            // } else {
            //     $this->db->where('a.from_office', 'DC');
            // }

            $this->db->where('a.order_passed is null', null, false);
            $this->db->where('a.co_chitha_corrected_yn is null', null, false);
            // if($this->session->userdata('dist_code') != '24'){
            // if (!in_array($s_code, [SETTLEMENT_TENANT_ID, SETTLEMENT_TENANT_URBAN_ID])) {
            //     $this->db->where("DATE_PART('day', now()::timestamp- a.ppp_issue_date::timestamp)>15");
            // }
            // }

            // $this->db->join('settlement_dag_details sd', 'sd.case_no = a.case_no');
            // $this->db->where('NOT EXISTS (SELECT 1 FROM settlement_dag_details sd WHERE sd.case_no = a.case_no AND ((sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = \'\' OR sd.new_land_class_agri = \'\')))', NULL, FALSE);

            if (!empty($l_mis)) {
                if ($l_mis == 'l_miss') {
                    // $this->db->join('settlement_dag_details sd', 'sd.case_no = a.case_no');
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
        $this->load->model('AllotmentCertificateModel');
        $final = $passedcases = array();
        if (empty($_POST['selectMark']))
        {
            echo json_encode(array('responseType' => 2, 'msg' => 'Please Select Case No'));
            return;
        }
        $this->load->model('ChithaUpdateModel');
        $dist_code = $this->session->userdata('dist_code');
        foreach ($_POST['selectMark'] as $key => $value)
        {
            $case_no = $value;
            $this->db->trans_begin();
            $response = $this->AllotmentCertificateModel->genArrayForCithaUpdate($case_no);
            $result=json_decode($response);
            if($result->responseType==2){
                $this->db->trans_commit();
                $passedcases[] = array($case_no);
            }else{
                $this->db->trans_rollback();
                $final[] = array($case_no);
                log_message('error', '#ERRINS008888##'.json_encode($result->error));
            }
        }
        echo json_encode(array('responseType' => 2, 'msg' => 'Successfully order Passed', 'failed' => json_encode($final), 'passed' => json_encode($passedcases)));
        return;
    }

    private function isRegistrationDataValid($co_operative_registered, $registration_no, $registration_date,$registration_document, $case_no)
    {
        if (empty($registration_document)) {
            log_message('error', "Validation failed: Missing registration_document for case #{$case_no}");
            return false;
        }
        if (empty($co_operative_registered)) {
            log_message('error', "Validation failed: Missing co_operative_registered for case #{$case_no}");
            return false;
        }
        if (empty($registration_no)) {
            log_message('error', "Validation failed: Missing registration_no for case #{$case_no}");
            return false;
        }

        if (empty($registration_date)) {
            log_message('error', "Validation failed: Missing registration_date for case #{$case_no}");
            return false;
        }

        // if (!preg_match('/^[a-zA-Z0-9\-\/]+$/', $registration_no)) {
        //     log_message('error', "Validation failed: Invalid format for registration_no '{$registration_no}' in case #{$case_no}");
        //     return false;
        // }

        $date = DateTime::createFromFormat('Y-m-d', $registration_date);
        if (!$date || $date->format('Y-m-d') !== $registration_date) {
            log_message('error', "Validation failed: Invalid registration_date format '{$registration_date}' in case #{$case_no}");
            return false;
        }

        return true;
    }

    public function registrationCertificateNotice()
    {
        $case_no = $this->input->get('case'); 
        $applicant_buyer = $this->SettlementInsModel->getAllApplicantBuyers($case_no);
        $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
        $insDetails = $this->SettlementInsModel->getInstitutionDetails($case_no);
        $apLmnoteDetails = $this->db->query('select * from settlement_ap_lmnote where case_no = ? order by id desc limit 1', array($case_no))->row();
        $data['instituteDetails'] = $insDetails;
        $data = [
            'case_no' => $case_no,
            'remark' => null,
            'get_settlement_basic' => $get_settlement_basic,
            'pay_notice_date' => date('Y-m-d'),
        ];

        if(isset($applicant_buyer))
        {
            foreach($applicant_buyer as $applicant)
            {
                if($applicant->is_applicant == 1)
                {
                    $data['applicant_name'] = $applicant->pdar_name;
                    $data['guardian_name'] = $applicant->pdar_guardian;
                    $marital_status = $applicant->marital_status;
                }
            }
        }

        $basic = $this->SettlementInsModel->getSettlementBasic($case_no);

        if(isset($basic))
        {

            $data['case_no']                = $basic['case_no'];
            $data['application_no']         = $basic['applid'];

            $data['dist_name'] = $this->utilityclass->getDistrictName($basic['dist_code']);
            $data['circle_name'] = $this->utilityclass->getCircleName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
            $data['mouza_name'] = $this->utilityclass->getMouzaName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code']);

            $data['lot_name'] = $this->utilityclass->getLotName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no']);

            $data['village_name'] = $this->utilityclass->getVillageName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no'], $basic['vill_townprt_code']);

            if($basic['sdlac_date'] == null || $basic['sdlac_date'] == '' || empty($basic['sdlac_date']))
            {
                $this->session->set_flashdata('message', "#ERR203934: Unable to process! Something went wrong...#".$case_no);
                redirect(base_url().'index.php/home');
            }

            $data['date_of_sldc'] = date('d/m/Y', strtotime($basic['sdlac_date']));

            $data['dept_order_no'] = $basic['dept_order_no'];
            $data['dept_order_date'] = date('d/m/Y', strtotime($basic['dept_order_date']));
            $data['instituteDetails'] = $insDetails;
        }
        else
        {
            $this->session->set_flashdata('message', "#ERR1917: Unable to process! Something went wrong...#".$case_no);
            redirect(base_url().'index.php/home');
        }

        $dags = $this->SettlementInsModel->getSettlementDag($case_no);

        $premium_data = $this->db->query("SELECT * from settlement_premium where case_no=? and is_final=?", array($case_no, 1));
        $caseUrban ='Y';
        if($premium_data->num_rows() > 0)
        {
            
            $premium_data_row = $premium_data->row();
            $premium_data_arr = $premium_data->result();


            if(!isset($dags))
            {
                //****show error */
                $this->session->set_flashdata('message', "#ERR2018: Something went wrong!...#".$case_no);
                redirect(base_url().'index.php/home');
            }

            foreach($dags as $dag_item)
            {
                $premiumSql = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $dag_item->dag_no, 1));
        
                if($premiumSql->num_rows() <= 0)
                {
                    //****show error */
                    $this->session->set_flashdata('message', "#ERR2029: Something went wrong!...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

            }

            //*******for rural case *

            //*****for urban case */
            // if(trim($data['isUrban']) == 'Y' || (trim($data['isUrban']) == 'N' && $urbanByLm->falls_und_gmc == YES))
            if($caseUrban =='Y') /////consider as urban case
            {
       


                if(($data['dept_order_no'] == null || $data['dept_order_no'] == '' || empty($data['dept_order_no'])) || ($data['dept_order_date'] == null || $data['dept_order_date'] == '' || empty($data['dept_order_date'])))
                {
                    $this->session->set_flashdata('message', "#ERR1913: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                if($data['date_of_sldc'] == null || $data['date_of_sldc'] == '' || empty($data['date_of_sldc']))
                {
                    $this->session->set_flashdata('message', "#ERR2039: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                if($basic['dept_order_date'] == null || $basic['dept_order_date'] == '' || empty($basic['dept_order_date']))
                {
                    $this->session->set_flashdata('message', "#ERR203935: Unable to process! Something went wrong...#".$case_no);
                    redirect(base_url().'index.php/home');
                }

                $trArr = '';
                $area_all = array();
                // $area_all_barak = array();
                $dag_arr = array();
                $data['actual_premium'] = 0;

                $sl_counter = 1;

                foreach($premium_data_arr as $premium)
                {
                    
                    


                    $premium_per_bigha = $premium->zonal_valuation;

                    //$premium_per_bigha = $premium->zonal_valuation;// old zonal value-----------
                    $dag_no = $premium->dag_no;

                    $dag_arr[] = $premium->dag_no;

                    $total_lessa = $premium->total_lessa;

                    if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                    {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa);
                        $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        

                        $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                    }
                    else
                    {
                        $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                        // $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];

                        $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                    }

                    $data['first_area'] = implode ( ", ", $area_all );
                    $data['first_dag_no'] = implode ( ", ", $dag_arr );


                    $total_amount = $premium->amount_dag;

                    $mbAreaLimit = null;//$premium->mb_land;
                    $maxLand = null;//$premium->max_land;



                    //****getting the zonal value in lessa */
                    if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                    {
                        $zonalValue = $premium_per_bigha / 6400;
                    }
                    else
                    {
                        $zonalValue = $premium_per_bigha / 100;
                    }

                    $exceed_area = false;
                    $exceed_premium_per_bigha = false;
                    $exceedPremium = false;

                    
                    $type_of_concession = false;
                    $concession_amount = false;
                    $concession_mission_govt_notification_no = false;
                    

                    $net_premium_payable = $premium->final_amount;

                    $loloCounter = 1;

                    $exceed_pre = '';
                   

                    $consc = '';
                    

                    

                    
                }

                $trArr= '';


                $data['net_premium_payable'] = $net_premium_payable;

                $data['tbody'] = $trArr;

            }
        }
        else
        {
            $this->session->set_flashdata('message', "#ERR2533: Unable to process! Something went wrong...#".$case_no);
            redirect(base_url().'index.php/home');
        }

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."getApplicationDate");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
            'application_no' => $data['application_no'],
        )));
        $output = curl_exec($curl_handle);
        if(isset(json_decode($output)->responseType)){
            if(json_decode($output)->responseType != 'y'){
                echo json_decode($output)->data." - Unauthorized access!";
                return false;
            }
        }
        curl_close($curl_handle);
        $res = json_decode($output);


        $data['date_of_application'] = date('d/m/Y', strtotime($res->submission_date));
        $data['date'] = date('d/m/Y', strtotime(date('Y-m-d')));
        $data['payment_date'] = date('d/m/Y', strtotime($data['date']. ' + 15 days'));
        $data['actual_govt_notification_no'] = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
        $data['mission_govt_notification_no'] = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';

        // $this->load->helper('qrcode');
        // $base_64 = printQR('https://sewasetu.assam.gov.in/');
        // $data['qrcode'] = $base_64;
        $this->load->helper('qrcode');
        $base_64 = "iVBORw0KGgoAAAANSUhEUgAAAIwAAACMAQMAAACUDtN9AAAABlBMVEX///8AAABVwtN+AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAA/ElEQVRIidWVUQrDIBBEF/Kxx/AiglcP5CIew4/AdNZNS9O/NpOPSjD6BCXj7MTsv1sD0K0WrMYR+wuomi3d98LhMHM5Kti6o/vWR8M9iJPRbkT8ptVuQamXkX5I+D2aVztqoTin2xah2XwNdLKiCLXOQx3Tnq3L0YKRC9W4MNTIspoKJeOhh14/IvrPCrf3DWkWLWJlLgBLtL5KVIly3mDT4YdeQsQC4qSkQ6deUoQ0vRl7+DXUseHI2ZmIWpTytwiUSAM1ygRY5lPfA0aDasofYf48UYoiasP9LfQa1xH3znn+MtWIb+zhIpejNE8EIakcZekAxw2o0T+3BwGPvjKA6hujAAAAAElFTkSuQmCC";
        $data['qrcode'] = ','.$base_64;
        // echo "dd";die;
        

        if($insDetails->ins_cat_type_co == '12' && $apLmnoteDetails->already_alloted == 'N' && ($insDetails->purpose_land_allot_co == 'religious' || $insDetails->purpose_land_allot_co == 'socioculture' || $insDetails->purpose_land_allot_co == 'education') && $insDetails->venture_type !='govt_aided_venture')
        { 
            $data['service_name'] = 'Digitalized Allotment/Settlement of land to Non Govt Non individual Juridical entities-Allotment cases- Registration certificate Notice';
            $this->load->view('SettlementView/include/registration_certificate_notice_non_govt_allotment', $data);
        }
        else if($insDetails->ins_cat_type_co == '12' && $apLmnoteDetails->already_alloted == 'Y' && ($insDetails->purpose_land_allot_co == 'religious' || $insDetails->purpose_land_allot_co == 'socioculture' || $insDetails->purpose_land_allot_co == 'education') && $insDetails->venture_type !='govt_aided_venture')
        {
            $data['service_name'] ='Digitalized Allotment/Settlement of land to Non Govt Non individual Juridical entities-Settlement cases- Registration certificate Notice';
            $this->load->view('SettlementView/include/registration_certificate_notice_non_govt_settlement', $data);
        }
        else if($insDetails->ins_cat_type_co == '12' && $apLmnoteDetails->already_alloted == 'N' && $insDetails->purpose_land_allot_co == 'education' && $insDetails->under_venture_school == 'YES' && $insDetails->venture_type =='govt_aided_venture')
        {
            $data['service_name'] ='Digitalized Allotment/Settlement of land to Non Govt Non individual Juridical entities-Govt Aided Venture School-Allotment cases- Registration certificate Notice';
            $this->load->view('SettlementView/include/registration_certificate_notice_govt_aided_venture', $data);
        }
        
    }

    public function saveRegistrationNotice()
    {
        $case_no = $this->input->post('case_no'); 

        $this->db->trans_begin();

        $noticeAlreadyGeneratedCheck = $this->db->query('select * from settlement_notice where case_no = ? and notice_type = ?', array($case_no, 'RN'));

        $old_notice_link = false;
        
        if($noticeAlreadyGeneratedCheck->num_rows() > 0)
        {
            $old_notice_link = $noticeAlreadyGeneratedCheck->row()->notice_link;
        }


        // replacing file case number to savable format
        $new_case_no = str_replace('/', "-", $case_no);
        $timestamp = date('mdYhis', time()).uniqid();

        // creating and saving the base64 format payment notice to uploads/paymentNotice folder
        $base_64_file_path = PAYMENT_NOTICE_PATH . $new_case_no.'_'.$timestamp. ".json";
        $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
        $htmlstring_text = json_encode($this->input->post('htmlstring_text'));
        fwrite($file_to_write_base64, $htmlstring_text);
        fclose($file_to_write_base64);
        $amount = $this->input->post('amount');
        $remark_co = $this->input->post('remark');
        $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);

        $case_user_case = $get_settlement_basic->co_code;


        if($this->session->userdata('user_desig_code') != 'CO')
        {
            $this->session->set_flashdata('message', "#ERR2046: Session timeout! Please login and try again # ".$case_no);
            redirect(base_url() . "index.php/home");
        }


        $get_dag_details = $this->SettlementApModel->getSettlementDagDetails($case_no);
        $get_settlement_applicant = $this->SettlementApModel->getAllApplicant($case_no);
        $instituteDetails = $this->SettlementInsModel->getInstitutionDetails($case_no);
        $lmNote = $this->db->query("select * from settlement_ap_lmnote where case_no = ?",array($case_no))->row();

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
                    'INS_NAME'      => $instituteDetails->ins_name_co,
                    'INS_ASS_NAME'  => $instituteDetails->ins_name_assamese,
                    'DEPARTMENT_NAME' => $instituteDetails->dept_of_co,
                    'DEPARTMENT_NAME_ASS' => $instituteDetails->dept_of_co_assamese,
                    'MINISTRY'      => $instituteDetails->ministry_of_co
                ];
        }

        $controller = '';

        if($get_settlement_basic->service_code == SLIJE_ID)
        {
            $notice_no = "MB3/RN/" . date('Y') . "/SLIJE/" . $service_details->petition_no;
            $controller = 'SettlementInstitutionCo';
        }
        

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
            'notice_type' => 'RN',
        ];
        $insertIntoSettlementNotice = $this->db->insert('settlement_notice', $insertIntoSettlementNotice);
        if ($insertIntoSettlementNotice != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRPN00678: Insertion failed in settlement_notice');
            $this->session->set_flashdata('message', "#INSREGAPI0016 Registration notice  could not be generated...");
            redirect(base_url() . 'index.php/SettlementInstitutionCo/generatePaymentNoticeCo?case=' . enc_param('case', $case_no, 600));
            return false;
        }
        $landType = null;
        $chitha_processing_details = 0;
        if($instituteDetails->ins_cat_type_co == '12' && $lmNote->already_alloted == 'N')
        {
            $landType = '12_allotment';
            $chitha_processing_details = 2;
        }
        else if($instituteDetails->ins_cat_type_co == '12' && $lmNote->already_alloted == 'Y')
        {
            $landType = '12_settlement';
            $chitha_processing_details = 0;
        }
        else if(($instituteDetails->ins_cat_type_co == '10' || $instituteDetails->ins_cat_type_co == '11'))
        {
            $landType = '10_transfer';
            $chitha_processing_details = 0;
        }
        else if(($instituteDetails->ins_cat_type_co == '9' && $lmNote->already_alloted == 'Y'))
        {
            $landType = '9_settlement';
            $chitha_processing_details = 0;
        }
        else if(($instituteDetails->ins_cat_type_co == '9' && $lmNote->already_alloted == 'N'))
        {
            $landType = '9_allotment';
            $chitha_processing_details = 0;
        }

        $updateArr = [
            'registration_certificate_notice' => 'Y',///Serve already
        ];
        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_institution_details', $updateArr);
        if ($this->db->affected_rows() != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRPN0001: Updation Failed in settlement_basic table');
            $this->session->set_flashdata('message', "#INSREGAPI00178 Registration notice  could not be generated...");
            redirect(base_url() . 'index.php/SettlementInstitutionCo/generatePaymentNoticeCo?case=' . enc_param('case', $case_no, 600));
            return false;
        }

        

        //******check if CO aggreed with concession even after caste is general */
        $data['caste'] = $get_settlement_basic->caste;
        $applicants_buyers   = $this->SettlementInsModel->getAllApplicantBuyers($case_no);

        foreach($applicants_buyers as $applicant)
        {
            if($applicant->is_applicant == 1)
            {
                $data['if_widow'] = $applicant->marital_status;
            }
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
            'task' => 'Registration Notice Generated',
            'old_file_link' => $old_notice_link == false ? null:$old_notice_link,
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if ($insertProc != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRPINSN0002: Insertion failed in settlement_proceeding');
            $this->session->set_flashdata('message', "#ERRINSPN0002 Payment notice  could not be generated...");
            redirect(base_url() . 'index.php/SettlementInstitutionCo/generatePaymentNoticeCo?case=' . enc_param('case', $case_no, 600));
            return false;
        }

        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#INSREGAPI001398 Payment notice  could be generated...");
            redirect(base_url() . 'index.php/SettlementInstitutionCo/generatePaymentNoticeCo?case=' . enc_param('case', $case_no, 600));
            exit;
        } else {
            // API CALL HERE
            $rtps_case_no = $get_settlement_basic->applid;
            /// check full pay
            $is_full_pay ='Y';
            // upload notice API
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "uploadNotice");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'encoded_file' => json_decode($htmlstring_text),
                'application_no' => $rtps_case_no,
                'type' => 'RN',
                'amount' => $amount,
                'is_full_pay' => $is_full_pay
            )));
            $result = curl_exec($curl_handle);

            if (trim($result) != 'y') {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', "#INSREGAPI0011  Registration notice  could not be generated...Please try again");
                redirect(base_url() . 'index.php/SettlementInstitutionCo/generatePaymentNoticeCo?case=' . enc_param('case', $case_no, 600));
                exit;
            }
            else
            {
                $this->db->trans_commit();
                $this->session->set_flashdata('message', "Registration notice successfully saved...");
                redirect(base_url() . 'index.php/SettlementInstitutionCo/generatePaymentNoticeCo?case=' . enc_param('case', $case_no, 600));
            }
    
        }
    }

    public function printNoticeRegistration()
    {
        $case_no = $this->input->get('case_no');
        // getting the notice file link
        // $data['print_data'] = $this->SettlementApModel->getSettlementBasic($case_no);
        $notice_link = $this->db->query("select notice_link from settlement_notice where case_no = ? and notice_type = 'RN'",array($case_no))->row();

        // reading the base64 json file and saving it to a variable
        $path = $this->SettlementCommonModel->downloadNotice($notice_link->notice_link);
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

        $land_purpose = null;
        $instituteDetails = $this->SettlementInsModel->getInstitutionDetails($case_no);
        if($instituteDetails->ins_cat_type_co == '12')
        {
            $data['land_purpose'] = NON_GOVT_PURPOSE;
        }
        else if($instituteDetails->ins_cat_type_co == '10' || $instituteDetails->ins_cat_type_co == '11')
        {
            $data['land_purpose'] = CENTRAL_PURPOSE;
        }
        else
        {
            $data['land_purpose'] = STATE_PURPOSE;
        }

        $data['other_land_purpose'] = OTHER_LAND_PURPOSE;

        $data['land_type_existing'] = LAND_TYPES;

        $data['insDetails'] = $instituteDetails;

        $data['dagResult'] = $getDagsSql->result();

        foreach ($data['dagResult'] as $dagRow) 
        {
            //*****Get data if inserted */
            // if ($data['basicRow']->service_code == '14') {
            //     $getDagTransSql = $this->db->query('select * from settlement_approval_transaction where case_no = ? and dag_no = ?', array($case_no, $dagRow->new_dag_no));
            // } else {
            $getDagTransSql = $this->db->query('select * from settlement_approval_transaction where case_no = ? and dag_no = ?', array($case_no, $dagRow->dag_no));
            // }

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

                /////newly added--
                $data['basicRow']->land_purpose = $appRowData->land_purpose;
                $data['basicRow']->other_land_purpose = $appRowData->other_land_purpose;
                $data['basicRow']->existing_land_type = $appRowData->existing_land_type;


                $dagRow->new_inserted_landclass_home = $appRowData->landclass_home;
                $dagRow->new_inserted_landclass_agri = $appRowData->landclass_agri;

                $dagRow->new_agri_land_revenue = $appRowData->new_agri_land_revenue;
                $dagRow->new_home_land_revenue = $appRowData->new_home_land_revenue;
                $dagRow->new_agri_land_local_tax = $appRowData->new_agri_land_local_tax;
                $dagRow->new_home_land_local_tax = $appRowData->new_home_land_local_tax;

                $dagRow->existing_land_type = $appRowData->existing_land_type;

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

        // $data['land_class_code'] = $this->db->query("Select * from landclass_code")->result();

        $data['land_class_code'] = $this->SettlementInsModel->getLandGroups(); 
        // $data['patta_details'] = $this->db->query("SELECT type_code, patta_type FROM patta_code where settlement = ?", 'y')->result();
        // $data['patta_details'] = $this->db->query("SELECT type_code, patta_type FROM patta_code where (settlement = ? OR spcl_cultivation = ?)", array('y', 'y'))->result();


        $data['patta_details'] = $this->db->query("SELECT id, name FROM patta_code_groups where id in (1,2,6)")->result();

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
        $instituteDetails = $this->SettlementInsModel->getInstitutionDetails($case_no);
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

        $new_patta_type = null; //$this->input->post('new_patta_type');
        $possession_from = $this->input->post('possession_from');
        $land_purpose = trim($this->input->post('land_purpose'));
        $other_details = null;

        // if (empty($new_patta_type) || empty($possession_from)) {
        //     echo json_encode([
        //         'responseType' => 0,
        //         'msg' => '#ERR831: Please enter all required fields!',
        //     ]);
        //     return false;
        // }
        if(empty($possession_from))
        {
            echo json_encode([
                'responseType'  => 0,
                'msg'           => '#ERR-LRA-VER-REPORT831: Please enter all required fields!',
            ]);
            return false;
        }

        $apLmNote = $this->db->query('select * from settlement_ap_lmnote where case_no = ?', array($case_no))->row();
        $allotment = true;
        if($apLmNote->already_alloted == 'Y')
        {
            $allotment = false;
        }

        // if($instituteDetails->ins_cat_type_co == 8)
        // {
        //     echo json_encode([
        //         'responseType'  => 0,
        //         'msg'           => '#ERR-LRA-VER-REPORT6926: Something went wrong!!!',
        //     ]);
        //     return false;
        // }
        // $restrictedInstitutionTypes = [9, 12];
        // if (in_array($instituteDetails->ins_cat_type_co, $restrictedInstitutionTypes) && $apLmNote->already_alloted === 'N' && $new_patta_type != 1) 
        // {
        //     echo json_encode([
        //         'responseType' => 0,
        //         'msg' => '#ERR-LRA-VER-REPORT6926: You can only choose Axom Sarkar (Sarkari) Patta for this institution type.',
        //     ]);
        //     return false;
        // }

        if($land_purpose == 'other')
        {
            $other_details = trim($this->input->post('other_details'));
            if(empty($other_details))
            {
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR-LRA-VER-REPORT6926: Please mention other details, please contact to system administrator',
                ]);
                return false;
            }

        }

        if($instituteDetails->ins_cat_type_co == '12')
        {
            if(trim($instituteDetails->purpose_land_allot_co) != $land_purpose)
            {
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR-LRA-VER-REPORT692656: The land purpose must match the land purpose reported by the LRA',
                ]);
                return false;
            }

            $getPremium = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ?', array($case_no,1));
            if ($getPremium->num_rows() <= 0) {
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR-LRA-VER-REPORT695898: The land purpose must match the land purpose reported by the LRA',
                ]);
                return false;
            }
            $premiumData = $getPremium->row();
            log_message('error','isEligibleCulturalInstitution==='.$possession_from."--".$premiumData->area_name);
            $checkPos = $this->isEligibleCulturalInstitution($possession_from, $premiumData->area_name);
            if(!$checkPos) 
            {
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR-LRA-VER-REPORT7874: Institutions with possession of 3 years or more in rural areas and 10 years or more in urban areas before October 1, 2021.',
                ]);
                return false;
            }

        }

        if (in_array($instituteDetails->ins_cat_type_co, ['9','10','11','12']))
        {
            if(trim($instituteDetails->purpose_land_allot_co) != $land_purpose)
            {
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR-CO-VER-REPORT6926:You cannot change the land purpose. It must match the land purpose reported by the LRA',
                ]);
                return false;
            }
        }

        //****get basic data  */
        $purpose_land_allot_co = null;
        $getBasicSql = $this->db->query('select * from settlement_basic where case_no = ?', array($case_no))->row();

        ///*****checking if co is changing the patta type from what lm has given (not allowed) */
        $approvRow = $checkIfAlreadyEnt->row();


        $batch_array = array();

        foreach ($data['dagResult'] as $dagRow) {


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


            $existing_land_type = $this->input->post('existing_land_type'.$dagRow->dag_no);
            if(empty($existing_land_type))
            {
                echo json_encode([
                    'responseType'  => 0,
                    'msg'           => '#ERR-LRA-VER-REPORT7038: Please Enter existing land type details...',
                ]);
                return false;
            }

            if(empty($land_class_code_homestead))
            {
                echo json_encode([
                    'responseType'  => 0,
                    'msg'           => '#ERR-LRA-VER-REPORT7038: Please Enter proposed land type details...',
                ]);
                return false;
            }

            if($land_class_code_homestead !=  $dagRow->ins_proposed_land_class)
            {
                echo json_encode([
                    'responseType'  => 0,
                    'msg'           => '#ERR-CO-VER-REPORT6987: The proposed class must match the class reported by the LRA',
                ]);
                return false;
            }

            $premium_data_sql = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ? and dag_no = ?', array($case_no, '1', $dagRow->dag_no));
            if ($premium_data_sql->num_rows() <= 0) {
                log_message('error', '#ERR10313: Case not found in settlement_premium' . $this->db->last_query());
                echo json_encode([
                    'responseType' => 0,
                    'msg' => '#ERR10313: Premium data not found!',
                ]);
                return false;
            }
            $premiumRow = $premium_data_sql->row();
            if($allotment == false && ($premiumRow->rate_type !=  $existing_land_type))
            {
                echo json_encode([
                    'responseType'  => 0,
                    'msg'           => '#ERR-CO-VER-REPORT7051: The land type class must match the class reported by the LRA as it is under settlement case',
                ]);
                return false;
            }


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

            // if (!empty($revenue_agri)) {
            //     if (empty($local_tax_agri)) {
            //         echo json_encode([
            //             'responseType' => 0,
            //             'msg' => '#ERR1073: Please Enter Local tax details...',
            //         ]);
            //         return false;
            //     }
            // }

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
                'land_purpose'              => $land_purpose,
                'existing_land_type'        => $existing_land_type,
                'other_land_purpose'        => $other_details
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

    public function reserveApp()
    {
        $case_no = $this->input->post('case_no_reserve');
        $service_code = $this->input->post('service_code_reserve_post');
        $reason_for_reserve = $this->input->post('reason_for_reserve');
        if(empty($case_no))
        {
            echo json_encode([
                'responseType'  => 0,
                'msg'           => '#ERR-RES-01: Case number not found!',
            ]);
            return false;
        }
        if(empty($service_code))
        {
            echo json_encode([
                'responseType'  => 0,
                'msg'           => '#ERR-RES-02: Service not found!',
            ]);
            return false;
        }
        if(empty($reason_for_reserve))
        {
            echo json_encode([
                'responseType'  => 0,
                'msg'           => '#ERR-RES-03: Reason not found!',
            ]);
            return false;
        }

        $reserveCheck = $this->db->query('select * from settlement_basic where case_no = ?', array($case_no))->row();
        if($reserveCheck->reserve_application_new  == '1')
        {
            log_message('error', '#ERR-RES-043: Unable to update reserve_application_new!'. $this->db->last_query());
            echo json_encode([
                'responseType'  => 0,
                'msg'           => '#ERR-RES-043: Already reserved...!',
            ]);
            return false;
        }

        $this->db->trans_begin();
        $basicArr = [
            'reserve_application_new' => 1,
            'date_update'               => date('Y-m-d H:i:s')
        ];

        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $basicArr);

        if($this->db->affected_rows() != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERR-RES-04: Unable to update settlement_basic!'. $this->db->last_query());
            echo json_encode([
                'responseType'  => 0,
                'msg'           => '#ERR-RES-04: Unable to save data!',
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
            'note_on_order' => $reason_for_reserve,
            'status' => 'N',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d h:i:s'),
            'operation' => 'E',
            'ip' => $this->utilityclass->get_client_ip(),
            'office_from' => 'CO',
            'office_to' => 'CO',
            'task' => 'Reservation done',
            // 'note_type' => $this->input->post('lm_note'),
        ];
        
        $insertProceeding = $this->db->insert('settlement_proceeding', $insPetProceed);

        if ($insertProceeding != 1) 
        {
            $this->db->trans_rollback();
            echo json_encode([
                'responseType'  => 0,
                'msg'           => '#ERR-LRA-VER-REPORT2403: Unable to approve the report!',
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

    function isEligibleCulturalInstitution($possessionDate, $areaType) {
        // Possession cutoff date
        $cutoffDate = new DateTime('2021-10-01');
        $possessionDateObj = new DateTime($possessionDate);

        // Check if possession is before the cutoff date
        if ($possessionDateObj > $cutoffDate) {
            return false; // Not eligible if possession is after cutoff
        }

        // Calculate the difference in years
        $interval = $possessionDateObj->diff($cutoffDate);
        $yearsOfPossession = $interval->y;

        // Validation based on area type
        if ($areaType === '10' && $yearsOfPossession >= 3) {
            return true;
        } elseif ($areaType !='10' && $yearsOfPossession >= 10) {
            return true;
        }

        return false;
    }

    public function premiumReCalculateForApproveCases()
    {

        $case_no = $this->input->post('case_no');
        if(empty($case_no))
        {
           log_message('error', '#premiumReCalculateForApproveCases : case_no not found');
            echo json_encode(
                array('responseType'=> 1,'msg' => 'User not Authenticated for re-calculate the approve premium')
            ); 
        }
        $reason_for_recalculate = $this->input->post('reason_for_recalculate');
        if(empty($reason_for_recalculate))
        {
           log_message('error', '#premiumReCalculateForApproveCases : reason_for_recalculate not found');
            echo json_encode(
                array('responseType'=> 1,'msg' => 'Please specify the reason for recalculation !')
            ); 
        }

        if($this->session->userdata('user_desig_code') != 'CO')
        {
            log_message('error', '#ERROR99003987656: Undefined User... '. $case_no);
            echo json_encode(
                array('responseType'=> 1,'msg' => 'User not authenticated for re-calculate the approve premium')
            );
        }
        $this->db->trans_begin();

        $recalculatePremiumCheck = $this->SettlementInsModel->premiumReCalculationForInsApprovePremCases($case_no,$reason_for_recalculate);
        log_message('error','premiumReCalculateForApproveCases======='.json_encode($recalculatePremiumCheck));
        if($recalculatePremiumCheck!=null && $recalculatePremiumCheck['status'] == 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRORRECALC99003: Unable to re calculate premium. Response===='.json_encode($recalculatePremiumCheck));
            echo json_encode(
                array('responseType'=> 1,'msg' => 'Premium re-calculation could not be completed, please try again !!!')
            );

        }
        else
        {
            $this->db->trans_commit();
            echo json_encode(
                array('responseType'=> 2,'msg' => 'Premium re-calculation done!!!')
            );

        }
    }


    public function paymentConfirmation()
    {

        if(LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO'){
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

        $pagination = $this->input->post('pagination');


        $final_verification_report = $this->input->post('final_verification_report');
        $co_approved = $this->input->post('co_approved');

        $allotment_settlement = $this->input->post('allotment_settlement');

        $col = 0;
        $dir = "";
        $search = $this->input->post('search');
        $search = $search['value'];

        $searchByCol_0 = $this->input->post('columns')[1]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[2]['search']['value'];
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

        if(!empty($remark_cat))
        {  //settlement_ap_lmnote, lm_note
            $this->db->where('b.lm_note', $remark_cat);
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

        if (trim($reverted) == 'LM'){
            $this->db->where('a.pending_officer', MB_LOT_MONDOL);

        }
        else if (trim($reverted) == 'ADC'){
            $this->db->where_not_in('a.pending_officer',array(MB_LOT_MONDOL,MB_SUPERVISOR_KANANGU,MB_CIRCLE_OFFICER));
        }
        else{

            $this->db->where_in('a.pending_officer', array(MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU));
        }
        if ($this->session->userdata('user_desig_code') == 'CO'){
            // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
            if(LOT_BIFURCATE ==1 && empty($mouza_pargona_code) && empty($lot_no)){
                if(isset($lot_string) && $lot_string != null)
                {
                    $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                }
            }

            // $this->db->orWhere('a.co_code', null);
        }
        if ($this->session->userdata('user_desig_code') == 'SK') {
            $this->db->where('b.lm_note', '1');
            $this->db->where('a.from_office', 'LM');
        }

        if(trim($reverted) == 'LM' and $status =='V'){
            $this->db->select("distinct(a.case_no),a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, a.chitha_processing_details");
            $this->db->select('(select \'0\') as lm_note');
        }else{
            if($status == MB_PAYMENT_NOTICE)
            {
                $this->db->select('distinct(a.case_no), a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note, a.chitha_processing_details,sid.ins_cat_type_co');
            }
            else
            {
                $this->db->select('distinct(a.case_no), a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note, a.chitha_processing_details');
            }
        }
        //}

        if (trim($reverted) != 'ADC'){
            $this->db->where('a.status', $status);
        }
        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

        // $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
        if(trim($reverted) == 'LM' and $status =='V'){
            $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no', 'left');
        }else{
            $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
        }

        if($s_code == 14 && ($status !='R' && $status !='X' && $status !='M' && $status !='N' && $status !='D'))
        {
            if (trim($reverted) != 'ADC'){
                if (($this->session->userdata('user_desig_code') == 'SK' and $status =='W') || trim($reverted) == 'LM' and $status =='V') {

                }
                else
                {
                    $this->db->where('a.notice_generated_yn', NULL);
                }
            }
        }


        $this->db->from('settlement_basic a');

        if($status == MB_PAYMENT_NOTICE)
        {
            $this->db->join('settlement_institution_details sid', 'a.case_no = sid.case_no');
            if(!empty($allotment_settlement))
            {
                if($allotment_settlement == '8')
                {
                    $this->db->where_in('sid.ins_cat_type_co', array('8'));
                }
                else if($allotment_settlement == '9')
                {
                    $this->db->where_in('sid.ins_cat_type_co', array('9'));
                }
                else if($allotment_settlement == '10')
                {
                    $this->db->where_in('sid.ins_cat_type_co', array('10'));
                }
                else if($allotment_settlement == '11')
                {
                    $this->db->where_in('sid.ins_cat_type_co', array('11'));
                }
                else if($allotment_settlement == '12')
                {
                    $this->db->where_in('sid.ins_cat_type_co', array('12'));
                }
            }
            else
            {
                $this->db->where_in('sid.ins_cat_type_co', array('8','9','10','11','12'));
            }
            

            $this->db->join('settlement_premium c', 'a.case_no = c.case_no');
            $this->db->where('c.is_final', 1);

            if(!empty($payment_status))
            {
                if(trim($payment_status) == 'paid')
                {
                    $this->db->where('c.grn_no is not null');
                }
                elseif(trim($payment_status) == 'unpaid')
                {
                    $this->db->where('c.grn_no is null');
                }
            }

            if(!empty($final_verification_report))
            {
                if($final_verification_report == 'Yes')
                {
                    $this->db->where_in('a.chitha_processing_details', array(1,2));
                }
                else if($final_verification_report == 'No')
                {
                    $this->db->where('a.chitha_processing_details', 0);
                }
                elseif(trim($final_verification_report) == 'land_class_issue'){
                    // $this->db->join('settlement_dag_details sd', 'sd.case_no = a.case_no');     
                    // $this->db->where("(sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = '' OR sd.new_land_class_agri = '')", NULL, FALSE); 
                    
                    $this->db->where('EXISTS (SELECT 1 FROM settlement_dag_details sd WHERE sd.case_no = a.case_no AND ((sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = \'\' OR sd.new_land_class_agri = \'\')))', NULL, FALSE);

                }
            }


            if(!empty($co_approved))
            {
                if($co_approved == 'Yes')
                {
                    $this->db->where('a.chitha_processing_details', 2);
                }
                else if($co_approved == 'No')
                {
                    $this->db->where_in('a.chitha_processing_details', array(1,0));
                }
            }
        }

        $query = $this->db->get();

        // echo $this->db->last_query();die;

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {

                

                $revialSql = $this->db->query('select * from settlement_revival_flag where case_no = ? and revival_status = ?', array($rows->case_no, 1));

                if($revialSql->num_rows() > 0)
                {
                    $revival_flg_button = '';
                }
                else
                {
                    $revival_flg_button = '<button type="button" onclick="caseRevivalList(\''.$rows->case_no.'\',\''.$rows->service_code.'\');" class="btn btn-sm btn-warning">Flag for Revival</button>';
                }

                $download_rejected_cases = '<br><a class="mt-2 btn btn-sm btn-dark" target= "RejectedCases" href="'.base_url().'index.php/SettlementCommon/downloadRejectedCases/?service='.$s_code.'">Download Reject Cases</a>';

                if(trim($rows->lm_note) == 1)
                {
                    $lmnoteRemark = 'Recommended';
                }
                else
                {
                    $lmnoteRemark = 'Not Recommended';
                }

                if ($status == MB_PAYMENT_NOTICE) {


                    if($rows->chitha_processing_details == 1)
                    {
                        $lm_chitha_report = 'Yes';
                    }
                    elseif($rows->chitha_processing_details == 2)
                    {
                        $lm_chitha_report = 'Yes';
                    }
                    elseif($rows->chitha_processing_details == 0)
                    {
                        $lm_chitha_report = 'No';
                    }


                    if($rows->chitha_processing_details == 2)
                    {
                        $co_approved_status = 'Yes';
                    }
                    elseif($rows->chitha_processing_details == 1)
                    {
                        $co_approved_status = 'No';
                    }
                    elseif($rows->chitha_processing_details == 0)
                    {
                        $co_approved_status = 'No';
                    }

               

                    $registrationCert = '';
                    $paymentNoticeLinkIns = '';
                    if($rows->ins_cat_type_co == '12')
                    {
                        $registrationCert = '<a alt="Print Notice" class="text-white btn btn-sm btn-success mt-1" target="registrationNotice" href="' . base_url() . 'index.php/SettlementInstitutionCo/printNoticeRegistration?case_no=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Registration Notice</a>';
                    }

                    if($rows->ins_cat_type_co != '8')
                    {
                        $paymentNoticeLinkIns = '<a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="' . base_url() . 'index.php/SettlementCommon/printPaymentNotice?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Payment Notice</a>';
                    }

                    

                    

                    $khas_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . enc_param('case', $rows->case_no, 600) . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>

                        <br>
                        '.$paymentNoticeLinkIns.'

                        <br>
                        '.$registrationCert.'
                        

                        <br>
                        <a type="button" href="' . base_url() . 'index.php/SettlementInstitutionCo/confirmPaymentCo?case=' . $rows->case_no . '" class="mt-1 lmreportmut btn-sm btn btn-primary">
                        write report</a>';

                    

                    
                } 
               
                

                if($status == MB_PAYMENT_NOTICE)
                {
                    $insCategory = '';
                    if($rows->ins_cat_type_co == '8')
                    {
                        $insCategory = "<span style='color:#0cc10c;font-weight:bold'>State govt.</span>";
                    }
                    else if($rows->ins_cat_type_co == '9')
                    {
                        $insCategory = "<span style='color:#242472;font-weight:bold'>State govt Undertakings</span>";
                    }
                    else if($rows->ins_cat_type_co == '10')
                    {
                        $insCategory = "<span style='color:#ffb81d;font-weight:bold'>Central govt</span>";
                    }
                    else if($rows->ins_cat_type_co == '11')
                    {
                        $insCategory = "<span style='color:#ff681d;font-weight:bold'>Central govt Undertakings</span>";
                    }
                    else if($rows->ins_cat_type_co == '12')
                    {
                        $insCategory = "<span style='color:#9d2b2b;font-weight:bold'>Non Govt.(Education/Socio/Religious)</span>";
                    }
                    $sqlgrn = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ?', array($rows->case_no, 1));

                    if($sqlgrn->num_rows() <= 0)
                    {
                        $grn_status = '<strong class="text-danger">NOT PAID</strong>';
                    }
                    else
                    {
                        if(isset($sqlgrn->row()->grn_no))
                        {
                            if($sqlgrn->row()->grn_no == null || $sqlgrn->row()->grn_no == '')
                            {
                                $grn_status = '<strong class="text-danger">NOT PAID</strong>';
                            }
                            else
                            {
                                $grn_status = '<strong class="text-success">PAID</strong>';
                            }
                        }
                        else
                        {
                            $grn_status = '<strong class="text-danger">NOT PAID</strong>';
                        }
                    }
                    $ruralYesNo= "---";
                    $json[] = array(
                        $rows->case_no,
                        '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                        '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                        $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                        $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                        $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                        // $nr_status,

                        // $rows->date_entry,
                        // date("Y-m-d", strtotime($rows->date_entry)),

                        // $lmnoteRemark,

                        $grn_status,
                        $lm_chitha_report,
                        $co_approved_status,
                        $insCategory,
                        $khas_link,
                    );
                }

            }

            $this->db->where('a.service_code', $s_code);

            if(!empty($remark_cat))
            {  //settlement_ap_lmnote, lm_note
                $this->db->where('b.lm_note', $remark_cat);
            }

            if (trim($reverted) == 'LM'){
                $this->db->where('a.pending_officer', MB_LOT_MONDOL);

            }
            else if (trim($reverted) == 'ADC'){
                $this->db->where_not_in('a.pending_officer',array(MB_LOT_MONDOL,MB_SUPERVISOR_KANANGU,MB_CIRCLE_OFFICER));
            }
            else{


                // if ($this->session->userdata('user_desig_code') == 'SK')
                // {
                //     $this->db->where('a.pending_officer', MB_SUPERVISOR_KANANGU);
                // }
                // else
                // {
                //     $this->db->where_in('a.pending_officer', array(MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU));
                //     // $this->db->or_where('pending_officer', MB_SUPERVISOR_KANANGU);
                // }
                $this->db->where_in('a.pending_officer', array(MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU));
            }

            if ($this->session->userdata('user_desig_code') == 'CO'){
                // $this->db->where('a.co_code', $user_code);
                // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
                if(LOT_BIFURCATE ==1 && empty($mouza_pargona_code) && empty($lot_no)){

                    if(isset($lot_string) && $lot_string != null)
                    {
                        $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                    }
                }
            }

            if ($this->session->userdata('user_desig_code') == 'SK') {
                $this->db->where('b.lm_note', '1');
                $this->db->where('a.from_office', 'LM');
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

            


            if(trim($reverted) == 'LM' and $status =='V'){
                $this->db->select('distinct(a.case_no)');
                $this->db->select('(select \'0\') as lm_note');
            }else{
                $this->db->select('distinct(a.case_no)');
            }

            //}


            if (trim($reverted) != 'ADC'){
                $this->db->where('a.status', $status);
            }
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

            // $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
            if(trim($reverted) == 'LM' and $status =='V'){
                $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no', 'left');
            }else{
                $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
            }

            if($s_code == 14 && ($status !='R' && $status !='X' && $status !='M' && $status !='N' && $status !='D'))
            {
                if (trim($reverted) != 'ADC'){
                    if (($this->session->userdata('user_desig_code') == 'SK' and $status =='W') || trim($reverted) == 'LM' and $status =='V') {

                    }

                    else{
                        $this->db->where('a.notice_generated_yn', NULL);
                    }
                }
            }

            if($status == MB_PAYMENT_NOTICE)
            {
                $this->db->join('settlement_institution_details sid', 'a.case_no = sid.case_no');
                // $this->db->where_in('sid.ins_cat_type_co', array('8','9','10','11','12'));
                if(!empty($allotment_settlement))
                {
                    if($allotment_settlement == '8')
                    {
                        $this->db->where_in('sid.ins_cat_type_co', array('8'));
                    }
                    else if($allotment_settlement == '9')
                    {
                        $this->db->where_in('sid.ins_cat_type_co', array('9'));
                    }
                    else if($allotment_settlement == '10')
                    {
                        $this->db->where_in('sid.ins_cat_type_co', array('10'));
                    }
                    else if($allotment_settlement == '11')
                    {
                        $this->db->where_in('sid.ins_cat_type_co', array('11'));
                    }
                    else if($allotment_settlement == '12')
                    {
                        $this->db->where_in('sid.ins_cat_type_co', array('12'));
                    }
                }
                else
                {
                    $this->db->where_in('sid.ins_cat_type_co', array('8','9','10','11','12'));
                }
                $this->db->join('settlement_premium c', 'a.case_no = c.case_no');
                $this->db->where('c.is_final', 1);

                if(!empty($payment_status))
                {
                    if(trim($payment_status) == 'paid')
                    {
                        $this->db->where('c.grn_no is not null');
                    }
                    elseif(trim($payment_status) == 'unpaid')
                    {
                        $this->db->where('c.grn_no is null');
                    }
                    
                }


                if(!empty($final_verification_report))
                {
                    if($final_verification_report == 'Yes')
                    {
                        $this->db->where_in('a.chitha_processing_details', array(1,2));
                    }
                    else if($final_verification_report == 'No')
                    {
                        $this->db->where('a.chitha_processing_details', 0);
                    }
                    elseif(trim($final_verification_report) == 'land_class_issue'){
                        // $this->db->join('settlement_dag_details sd', 'sd.case_no = a.case_no');     
                        // $this->db->where("(sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = '' OR sd.new_land_class_agri = '')", NULL, FALSE); 
                        $this->db->where('EXISTS (SELECT 1 FROM settlement_dag_details sd WHERE sd.case_no = a.case_no AND ((sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = \'\' OR sd.new_land_class_agri = \'\')))', NULL, FALSE);

                    }
                }


                if(!empty($co_approved))
                {
                    if($co_approved == 'Yes')
                    {
                        $this->db->where('a.chitha_processing_details', 2);
                    }
                    else if($co_approved == 'No')
                    {
                        $this->db->where_in('a.chitha_processing_details', array(1,0));
                    }
                }
            }



            // $total_records = $this->db->count_all_results('settlement_basic a');
            $data=$this->db->get('settlement_basic a');
            $total_records = $data->num_rows();
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

    public function coBulkPaymentNoticeGenerateAndSave()
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
        if (count($markedApplications) > 10) {
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
            $insDetails = $this->SettlementInsModel->getInstitutionDetails($case_no);
            if($setFlag== null)
            {
                $setFlag = $insDetails->ins_cat_type_co;

            }
            elseif($setFlag !== $insDetails->ins_cat_type_co) 
            {
                log_message('error', '#coBulkPaymentNoticeGenerateAndSaveERRSameCat: Unable to generate offer of allotment/settlement. Response===='.json_encode($setFlag));
                $this->db->trans_rollback();

                $json = [
                    'responseType' => 3,
                    'message' => '#ERRST092 : Unable to generate offer of allotment/settlement as all applications must belong to the same category',
                    'list' => json_encode($completedCases),
                ];
                echo json_encode($json);
                return;
            }
            


            $finalAreaCheck = $this->SettlementCommonModel->finalAreaCheck($case_no);
            if($finalAreaCheck['responseType'] != 2)
            {
                log_message('error', '#coBulkPaymentNoticeGenerateAndSaveERRArea: Unable to generate offer of allotment/settlement. Response===='.json_encode($finalAreaCheck));
                $this->db->trans_rollback();
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRST092 : State Government Entity does not require offer of allotment/settlement, please choose other category',
                    'list' => json_encode($completedCases),
                ];
                echo json_encode($json);
                return;
            }

            $recalculatePremiumCheck = $this->SettlementInsModel->premiumReCalculationForIns($case_no);
            if($recalculatePremiumCheck!=null && $recalculatePremiumCheck['status'] == 1)
            {
                log_message('error', '#ERRORRECALC99003432: Unable to re calculate premium. Response===='.json_encode($recalculatePremiumCheck));
                $this->db->trans_rollback();
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRORRECALC99003432 : Something went wrong!!!',
                    'list' => json_encode($completedCases),
                ];
                echo json_encode($json);
                return;

            }


            //step1: first check state govt or others, direct chitha update
            
            $applicant_buyer = $this->SettlementInsModel->getAllApplicantBuyers($case_no);
            $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
            
            $apLmnoteDetails = $this->db->query('select * from settlement_ap_lmnote where case_no = ? order by id desc limit 1', array($case_no))->row();
            $instituteDetails = $insDetails;
            $data['instituteDetails'] = $insDetails;


            if($instituteDetails->ins_cat_type_co == '8')
            {
                $this->db->trans_rollback();
                log_message("error", '#ERRST092 : State Government Entity does not require notice');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRST092 : State Government Entity does not require offer of allotment/settlement, please choose other category',
                    'list' => json_encode($completedCases),
                ];
                echo json_encode($json);
                return;
            }



            $lmNote = $this->db->query('select * from settlement_ap_lmnote where case_no = ? order by id desc limit 1', array($case_no))->row();
            // payment status check thourgh API

            //step2: check payment done or nor if done then could not generate the payment notice he has to update the chitha
            $payment_status_check = $this->basundhara3Model->paymentConfirmation($get_settlement_basic->applid);
            if(!empty($payment_status_check))
            {
                // $this->db->trans_rollback();
                // log_message("error", '#ERRST092 : Payment status updated, so not recommend');
                // $json = [
                //     'responseType' => 3,
                //     'message' => '#ERRST092321 : Payment already done, kindly update the chitha',
                //     'list' => json_encode($completedCases),
                // ];
                // echo json_encode($json);
                // return;
                $pay_status = $payment_status_check->payment_status;
                if (strtoupper($pay_status) == 'Y') {
                    $this->db->trans_rollback();
                    log_message("error", '#ERRST092 : Payment status updated, so not recommend');
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRST092322 : Payment already done, kindly update the chitha',
                        'list' => json_encode($completedCases),
                    ];
                    echo json_encode($json);
                    return; 
                }
            }

        
            
            //step3: if not done then generate offer of allotment/settlement
            $data = [
                'case_no' => $case_no,
                'remark' => $remark,
                'get_settlement_basic' => $get_settlement_basic,
                'pay_notice_date' => date('Y-m-d'),
            ];

            if($get_settlement_basic->pull_request == '1')
            {
                $this->session->set_flashdata('message', "#NOTE10001: Unable to process due to modification request active # ".$case_no);
                $this->db->trans_rollback();
                log_message("error", '#NOTE10001: Unable to process due to modification request active # '.$case_no);
                $json = [
                    'responseType' => 3,
                    'message' => '#NOTE10001: Unable to process due to modification request active # '.$case_no,
                    'list' => json_encode($completedCases),
                ];
                echo json_encode($json);
                return; 
            }

            if(isset($applicant_buyer))
            {
                foreach($applicant_buyer as $applicant)
                {
                    if($applicant->is_applicant == 1)
                    {
                        $data['applicant_name'] = $applicant->pdar_name;
                        $data['guardian_name'] = $applicant->pdar_guardian;
                        $marital_status = $applicant->marital_status;
                    }
                }
            }


            $basic = $this->SettlementInsModel->getSettlementBasic($case_no);

            if(isset($basic))
            {

                $data['case_no']                = $basic['case_no'];
                $data['application_no']         = $basic['applid'];

                $data['dist_name'] = $this->utilityclass->getDistrictName($basic['dist_code']);
                $data['circle_name'] = $this->utilityclass->getCircleName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);
                $data['mouza_name'] = $this->utilityclass->getMouzaName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code']);

                $data['lot_name'] = $this->utilityclass->getLotName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no']);

                $data['village_name'] = $this->utilityclass->getVillageName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code'], $basic['mouza_pargona_code'], $basic['lot_no'], $basic['vill_townprt_code']);

                if($basic['sdlac_date'] == null || $basic['sdlac_date'] == '' || empty($basic['sdlac_date']))
                {
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

                $data['date_of_sldc'] = date('d/m/Y', strtotime($basic['sdlac_date']));
                $data['dept_order_no'] = $basic['dept_order_no'];
                $data['dept_order_date'] = date('d/m/Y', strtotime($basic['dept_order_date']));
                $data['instituteDetails'] = $insDetails;
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

            $dags = $this->SettlementInsModel->getSettlementDag($case_no);

            

            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3."getApplicationDate");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
                'application_no' => $data['application_no'],
            )));
            $output = curl_exec($curl_handle);
            if(isset(json_decode($output)->responseType)){
                if(json_decode($output)->responseType != 'y'){
                    $this->db->trans_rollback();
                    log_message("error", '#NOTE100014332323: Unable to process due to modification request active # '.$case_no);
                    $json = [
                        'responseType' => 3,
                        'message' => '#NOTE100014332323: Unable to get getApplicationDate data not found for # '.$case_no,
                        'list' => json_encode($completedCases),
                    ];
                    echo json_encode($json);
                    return;
                }
            }
            curl_close($curl_handle);
            $res = json_decode($output);


            $data['date_of_application'] = date('d/m/Y', strtotime($res->submission_date));
            $data['date'] = date('d/m/Y', strtotime(date('Y-m-d')));
            $data['payment_date'] = date('d/m/Y', strtotime($data['date']. ' + 15 days'));
            $data['actual_govt_notification_no'] = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';
            $data['mission_govt_notification_no'] = 'No. RDM-12011(17)/5/2022-LR-REV-R&DM/94 (e-file no: 234314)';


            $this->load->helper('qrcode');
            $base_64 = "iVBORw0KGgoAAAANSUhEUgAAAIwAAACMAQMAAACUDtN9AAAABlBMVEX///8AAABVwtN+AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAA/ElEQVRIidWVUQrDIBBEF/Kxx/AiglcP5CIew4/AdNZNS9O/NpOPSjD6BCXj7MTsv1sD0K0WrMYR+wuomi3d98LhMHM5Kti6o/vWR8M9iJPRbkT8ptVuQamXkX5I+D2aVztqoTin2xah2XwNdLKiCLXOQx3Tnq3L0YKRC9W4MNTIspoKJeOhh14/IvrPCrf3DWkWLWJlLgBLtL5KVIly3mDT4YdeQsQC4qSkQ6deUoQ0vRl7+DXUseHI2ZmIWpTytwiUSAM1ygRY5lPfA0aDasofYf48UYoiasP9LfQa1xH3znn+MtWIb+zhIpejNE8EIakcZekAxw2o0T+3BwGPvjKA6hujAAAAAElFTkSuQmCC";
            $data['qrcode'] = ','.$base_64;
            // echo "dd";die;


            if($insDetails->ins_cat_type_co == '12' && $apLmnoteDetails->already_alloted == 'N' && ($insDetails->purpose_land_allot_co == 'religious' || $insDetails->purpose_land_allot_co == 'socioculture'))
            {
                $data['service_name_pre'] = 'Digitalized Allotment/Settlement of land to Non individual Juridical entities-Allotment_to Religious/ Socio cultural institution';

                $data['service_name'] = 'Digitalized Allotment/Settlement of land to Non individual Juridical entities';
                $premium_data = $this->db->query("SELECT * from settlement_premium where case_no=? and is_final=?", array($case_no, 1));
                if($premium_data->num_rows() > 0)
                {
                    
                    $premium_data_row = $premium_data->row();
                    $premium_data_arr = $premium_data->result();

                    if(!isset($dags))
                    {
                        //****show error */
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE10r23424: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE10r23424: Unable to get dags data not found for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    foreach($dags as $dag_item)
                    {
                        $premiumSql = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $dag_item->dag_no, 1));
                
                        if($premiumSql->num_rows() <= 0)
                        {
                            //****show error */
                            $this->db->trans_rollback();
                            log_message("error", '#NOTE10r23424: Unable to process due to not dags # '.$case_no);
                            $json = [
                                'responseType' => 3,
                                'message' => '#NOTE10r23424: Unable to get premium data not found for # '.$case_no,
                                'list' => json_encode($completedCases),
                            ];
                            echo json_encode($json);
                            return;
                        }

                    }


                    if(($data['dept_order_no'] == null || $data['dept_order_no'] == '' || empty($data['dept_order_no'])) || ($data['dept_order_date'] == null || $data['dept_order_date'] == '' || empty($data['dept_order_date'])))
                    {
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE10r2342444: something went wrong # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE10r23424: something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    if($data['date_of_sldc'] == null || $data['date_of_sldc'] == '' || empty($data['date_of_sldc']))
                    {
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE10r234244431: something went wrong # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE10r234244431: something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    if($basic['dept_order_date'] == null || $basic['dept_order_date'] == '' || empty($basic['dept_order_date']))
                    {
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE10r23424443321: something went wrong # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE10r23424443321: something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    $trArr = '';
                    $area_all = array();
                    $dag_arr = array();
                    $data['actual_premium'] = 0;
                    $settlement_amount      = 0;
                    $final_reclass_amount   = 0;
                    $final_land_revenue_years    = 0;
                    $reclass_amount = 0;
                    $land_revenue_years = 0;

                    $sl_counter = 1;

                    foreach($premium_data_arr as $premium)
                    {
                        
                        $dag_no = $premium->dag_no;
                        $SingleDagCheck = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ? and dag_no = ?", array($case_no, $dag_no))->row();


                        $premium_per_bigha = $premium->zonal_valuation;
                        
                        $dag_arr[] = $premium->dag_no;
                        $total_lessa = $premium->total_lessa;
                        if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                        {
                            $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa);
                            $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                            $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        }
                        else
                        {
                            $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                            // $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                            $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                            $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                        }

                        $data['first_area'] = implode ( ", ", $area_all );
                        $data['first_dag_no'] = implode ( ", ", $dag_arr );
                        $total_amount = ceil($premium->amount_dag);
                        $total_amount = $total_amount;
                        $net_premium_payable = ceil($premium->final_amount);


                        $reclass_amount += $premium->ins_reclass_amount;
                        $land_revenue_years += $premium->land_revenue_years;
                        $settlement_amount += $total_amount;


                        $mandolikPremium = null;
                        if($SingleDagCheck->is_urban == 'N' && $premium->area_name == 10)
                        {
                            $mandolikPremium = "Rs 500-Rural Area";
                        }
                        else
                        {
                            $mandolikPremium = "Rs 50000-Urban Area";
                        }
                        $loloCounter = 1;
                        $trArr .= '<tr>
                                    <td rowspan="'.$loloCounter.'" class="text-center">'.$sl_counter++.'</td>
                                    <td>
                                       ৰেহাই মূল্যত বন্দৱস্তী প্ৰিমিয়াম 
                                    </td>
                                    <td>'.$mandolikPremium.'</td>
                                    <td>'.$dag_no.'</td>
                                    <td style="white-space: nowrap;">'.$area.'</td>
                                    <td style="white-space: nowrap;" class="text-right pr-2">+₹ '.($total_amount * 2).'</td>
                                </tr>';
                               
                        
                    }

                    $final_reclass_amount = $reclass_amount;
                    $final_land_revenue_years = $land_revenue_years;
                    $total_reclass_revenue = $reclass_amount;
                    $final_settlement_amount = ($settlement_amount - ceil($total_reclass_revenue));

                    $trArr .= '<tr>
                                    <td colspan="5" class="text-center"><b>আবণ্টনৰ বাবে দিবলগীয়া প্ৰিমিয়াম (বন্দৱস্তী প্ৰিমিয়ামৰ ৫০ শতাংশ)</b></td>
                                    <td class="text-right pr-2"><b>₹ '.$net_premium_payable.'</b></td>
                                </tr>';

                    $trArr .= '<tr>
                                    <td colspan="5" class="text-center"><b>মুঠ প্ৰিমিয়াম</b></td>
                                    <td class="text-right pr-2"><b>₹ '.$net_premium_payable.'</b></td>
                                </tr>';

                    $data['net_premium_payable']       = $net_premium_payable;
                    $data['final_settlement_amount']   = $final_settlement_amount;
                    $data['final_reclass_amount']      = ceil($final_reclass_amount);
                    // $data['final_land_revenue_amount'] = ceil($final_land_revenue_years);
                    
                    $data['final_land_revenue_years'] = ceil($final_land_revenue_years);
                    $data['tbody'] = $trArr;

                    
                }
                else
                {

                    $this->db->trans_rollback();
                    log_message("error", '#ERRCAT1: Premium data not found # '.$case_no);
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCAT1: Premium data not found # '.$case_no,
                        'list' => json_encode($completedCases),
                    ];
                    echo json_encode($json);
                    return;
                }


                $htmlStringUpload = $this->load->view('SettlementView/include/juridical_premium_notice_allotment_non_govt_religious_socioculture_1', $data,TRUE);
            }
            else if($insDetails->ins_cat_type_co == '12' && $apLmnoteDetails->already_alloted == 'N' && $insDetails->purpose_land_allot_co == 'education' && ($insDetails->under_venture_school == 'NO' || $insDetails->under_venture_school == '' || $insDetails->under_venture_school == null))
            {
                $data['service_name_pre'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities-Allotment to Non Govt educational institution';

                $data['service_name'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities';


                $premium_data = $this->db->query("SELECT * from settlement_premium where case_no=? and is_final=?", array($case_no, 1));
                if($premium_data->num_rows() > 0)
                {
                    
                    $premium_data_row = $premium_data->row();
                    $premium_data_arr = $premium_data->result();

                    if(!isset($dags))
                    {
                        //****show error */
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE10r23424K21: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE10r23424K21: Unable to get dags data not found for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    foreach($dags as $dag_item)
                    {
                        $premiumSql = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $dag_item->dag_no, 1));
                
                        if($premiumSql->num_rows() <= 0)
                        {
                            //****show error */
                            $this->db->trans_rollback();
                            log_message("error", '#NOTE10r23424K212: Unable to process due to not dags # '.$case_no);
                            $json = [
                                'responseType' => 3,
                                'message' => '#NOTE10r23424K212: Unable to get dags data not found for # '.$case_no,
                                'list' => json_encode($completedCases),
                            ];
                            echo json_encode($json);
                            return;
                        }

                    }


                    if(($data['dept_order_no'] == null || $data['dept_order_no'] == '' || empty($data['dept_order_no'])) || ($data['dept_order_date'] == null || $data['dept_order_date'] == '' || empty($data['dept_order_date'])))
                    {
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE10r23424K213: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE10r23424K213: Unable to get dags data not found for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    if($data['date_of_sldc'] == null || $data['date_of_sldc'] == '' || empty($data['date_of_sldc']))
                    {
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE10r23424K214: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE10r23424K214: Unable to get dags data not found for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    if($basic['dept_order_date'] == null || $basic['dept_order_date'] == '' || empty($basic['dept_order_date']))
                    {
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE10r23424K215: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE10r23424K215: Unable to get dags data not found for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    $trArr = '';
                    $area_all = array();
                    $dag_arr = array();
                    $data['actual_premium'] = 0;
                    $settlement_amount      = 0;
                    $final_reclass_amount   = 0;
                    $final_land_revenue_years    = 0;
                    $reclass_amount = 0;
                    $land_revenue_years = 0;

                    $sl_counter = 1;

                    foreach($premium_data_arr as $premium)
                    {
                        
                    
                        $premium_per_bigha = $premium->zonal_valuation;
                        $dag_no = $premium->dag_no;
                        $dag_arr[] = $premium->dag_no;
                        $total_lessa = $premium->total_lessa;
                        if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                        {
                            $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa);
                            $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                            $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        }
                        else
                        {
                            $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                            // $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                            $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                            $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                        }

                        $data['first_area'] = implode ( ", ", $area_all );
                        $data['first_dag_no'] = implode ( ", ", $dag_arr );


                        $total_amount = ceil($premium->amount_dag);
                        $total_amount = $total_amount;
                        $net_premium_payable = ceil($premium->final_amount);


                        $reclass_amount += $premium->ins_reclass_amount;
                        $land_revenue_years += $premium->land_revenue_years;
                        $settlement_amount += $total_amount;


                        $mandolikPremium = null;
                        if($insDetails->non_govt_profit_making_yes_no == 'N')
                        {
                            $mandolikPremium = "মাণ্ডলিক মূল্যৰ ১০০%";
                        }
                        else
                        {
                            $mandolikPremium = "মাণ্ডলিক মূল্যৰ ৩০%";
                        }
                        $loloCounter = 1;
                        $trArr .= '<tr>
                                    <td rowspan="'.$loloCounter.'" class="text-center">'.$sl_counter++.'</td>
                                    <td>
                                       বন্দৱস্তী প্ৰিমিয়াম মূল্য<br>'.$mandolikPremium.'
                                    </td>
                                    <td>'.$premium_per_bigha.'</td>
                                    <td>'.$dag_no.'</td>
                                    <td style="white-space: nowrap;">'.$area.'</td>
                                    <td style="white-space: nowrap;" class="text-right pr-2">+₹ '.($total_amount *2).'</td>
                                </tr>';
                               
                        
                    }

                    $final_reclass_amount = $reclass_amount;
                    $final_land_revenue_years = $land_revenue_years;
                    $total_reclass_revenue = $reclass_amount;
                    $final_settlement_amount = ($settlement_amount - ceil($total_reclass_revenue));

                    // $trArr .= '<tr>
                    //                 <td colspan="5" class="text-center"><b>মুঠ দিবলগীয়া প্ৰিমিয়াম</b></td>
                    //                 <td class="text-right pr-2"><b>₹ '.($net_premium_payable * 2).'</b></td>
                    //             </tr>';

                    $trArr .= '<tr>
                                    <td colspan="5" class="text-center"><b>আবণ্টনৰ বাবে দিবলগীয়া প্ৰিমিয়াম (মুঠ বন্দৱস্তী প্ৰিমিয়ামৰ ৫০ শতাংশ)</b></td>
                                    <td class="text-right pr-2"><b>₹ '.$net_premium_payable.'</b></td>
                                </tr>';


                    $data['net_premium_payable'] = $net_premium_payable;
                    $data['final_reclass_amount'] = $reclass_amount;
                    $data['final_land_revenue_years'] = $land_revenue_years;
                    $data['final_settlement_amount'] = ($settlement_amount - ceil($total_reclass_revenue));

                    $data['tbody'] = $trArr;

                    
                }
                else
                {

                    $this->db->trans_rollback();
                    log_message("error", '#ERRCAT2: Premium data not found # '.$case_no);
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCAT2: Premium data not found # '.$case_no,
                        'list' => json_encode($completedCases),
                    ];
                    echo json_encode($json);
                    return;
                }
                $htmlStringUpload = $this->load->view('SettlementView/include/juridical_premium_notice_allotment_non_govt_education_1', $data,TRUE);
            }
            else if($insDetails->ins_cat_type_co == '12' && $apLmnoteDetails->already_alloted == 'N' && $insDetails->purpose_land_allot_co == 'education' && $insDetails->under_venture_school == 'YES' && $insDetails->venture_type =='unrecognised_venture')
            {
                $data['service_name_pre'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities-Allotment to Non Govt educational institution';

                $data['service_name'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities';
                $premium_data = $this->db->query("SELECT * from settlement_premium where case_no=? and is_final=?", array($case_no, 1));
                if($premium_data->num_rows() > 0)
                {
                    
                    $premium_data_row = $premium_data->row();
                    $premium_data_arr = $premium_data->result();

                    if(!isset($dags))
                    {
                        //****show error */
                        //****show error */
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE3424P211: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE3424P211: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    foreach($dags as $dag_item)
                    {
                        $premiumSql = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $dag_item->dag_no, 1));
                
                        if($premiumSql->num_rows() <= 0)
                        {
                            //****show error */
                            $this->db->trans_rollback();
                            log_message("error", '#NOTE3424P212: Unable to process due to not dags # '.$case_no);
                            $json = [
                                'responseType' => 3,
                                'message' => '#NOTE3424P212: Something went wrong for # '.$case_no,
                                'list' => json_encode($completedCases),
                            ];
                            echo json_encode($json);
                            return;
                        }

                    }


                    if(($data['dept_order_no'] == null || $data['dept_order_no'] == '' || empty($data['dept_order_no'])) || ($data['dept_order_date'] == null || $data['dept_order_date'] == '' || empty($data['dept_order_date'])))
                    {
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE3424P213: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE3424P213: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    if($data['date_of_sldc'] == null || $data['date_of_sldc'] == '' || empty($data['date_of_sldc']))
                    {
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE3424P214: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE3424P214: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    if($basic['dept_order_date'] == null || $basic['dept_order_date'] == '' || empty($basic['dept_order_date']))
                    {
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE3424P215: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE3424P215: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    $trArr = '';
                    $area_all = array();
                    $dag_arr = array();
                    $data['actual_premium'] = 0;

                    $settlement_amount      = 0;
                    $final_reclass_amount   = 0;
                    $final_land_revenue_years    = 0;
                    $reclass_amount = 0;
                    $land_revenue_years = 0;

                    $sl_counter = 1;

                    foreach($premium_data_arr as $premium)
                    {
                        
                    
                        $premium_per_bigha = $premium->zonal_valuation;
                        $dag_no = $premium->dag_no;
                        $dag_arr[] = $premium->dag_no;
                        $total_lessa = $premium->total_lessa;
                        if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                        {
                            $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa);
                            $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                            $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        }
                        else
                        {
                            $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                            // $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                            $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                            $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                        }

                        $data['first_area'] = implode ( ", ", $area_all );
                        $data['first_dag_no'] = implode ( ", ", $dag_arr );


                        $total_amount = ceil($premium->amount_dag);
                        $total_amount = $total_amount;
                        $net_premium_payable = ceil($premium->final_amount);

                        $reclass_amount += $premium->ins_reclass_amount;
                        $land_revenue_years += $premium->land_revenue_years;
                        $settlement_amount += $total_amount;


                        $mandolikPremium = null;
                        // if($insDetails->non_govt_profit_making_yes_no == 'N')
                        // {
                            // $mandolikPremium = "মাণ্ডলিক মূল্যৰ ১০০%";
                        // }
                        // else
                        // {
                        //     $mandolikPremium = "মাণ্ডলিক মূল্যৰ ৩০%";
                        // }
                        $loloCounter = 1;
                        $trArr .= '<tr>
                                    <td rowspan="'.$loloCounter.'" class="text-center">'.$sl_counter++.'</td>
                                    <td>
                                       বন্দৱস্তী প্ৰিমিয়াম মূল্য<br>'.$mandolikPremium.'
                                    </td>
                                    <td>'.$premium_per_bigha.'</td>
                                    <td>'.$dag_no.'</td>
                                    <td style="white-space: nowrap;">'.$area.'</td>
                                    <td style="white-space: nowrap;" class="text-right pr-2">+₹ '.($total_amount *2).'</td>
                                </tr>';
                               
                        
                    }

                    $final_reclass_amount = $reclass_amount;
                    $final_land_revenue_years = $land_revenue_years;
                    $total_reclass_revenue = $reclass_amount;
                    $final_settlement_amount = ($settlement_amount - ceil($total_reclass_revenue));

                    // $trArr .= '<tr>
                    //                 <td colspan="5" class="text-center"><b>মুঠ দিবলগীয়া প্ৰিমিয়াম</b></td>
                    //                 <td class="text-right pr-2"><b>₹ '.($net_premium_payable * 2).'</b></td>
                    //             </tr>';

                    $trArr .= '<tr>
                                    <td colspan="5" class="text-center"><b>আবণ্টনৰ বাবে দিবলগীয়া প্ৰিমিয়াম (মুঠ বন্দৱস্তী প্ৰিমিয়ামৰ ৫০ শতাংশ)</b></td>
                                    <td class="text-right pr-2"><b>₹ '.$net_premium_payable.'</b></td>
                                </tr>';


                    $data['net_premium_payable'] = $net_premium_payable;

                    $data['final_reclass_amount'] = $reclass_amount;
                    $data['final_land_revenue_years'] = $land_revenue_years;
                    $data['final_settlement_amount'] = ($settlement_amount - ceil($total_reclass_revenue));

                    $data['tbody'] = $trArr;

                    
                }
                else
                {
                    $this->db->trans_rollback();
                    log_message("error", '#ERRCAT3: Premium data not found # '.$case_no);
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCAT3: Premium data not found # '.$case_no,
                        'list' => json_encode($completedCases),
                    ];
                    echo json_encode($json);
                    return;
                }
                $htmlStringUpload = $this->load->view('SettlementView/include/juridical_premium_notice_allotment_non_govt_education_1', $data,TRUE);
            }
            else if($insDetails->ins_cat_type_co == '12' && $apLmnoteDetails->already_alloted == 'Y' && ($insDetails->purpose_land_allot_co == 'religious' || $insDetails->purpose_land_allot_co == 'socioculture'))
            {


                $data['service_name_pre'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities-Direct Settlement_to Religious/ Socio cultural institution';

                $data['service_name'] ='Digitalized Settlement of land to Non individual Juridical entities';
                $premium_data = $this->db->query("SELECT * from settlement_premium where case_no=? and is_final=?", array($case_no, 1));
                if($premium_data->num_rows() > 0)
                {
                   $premium_data_row = $premium_data->row();
                    $premium_data_arr = $premium_data->result();

                    if(!isset($dags))
                    {
                        //****show error */
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE3424L211: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE3424L211: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    foreach($dags as $dag_item)
                    {
                        $premiumSql = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $dag_item->dag_no, 1));
                
                        if($premiumSql->num_rows() <= 0)
                        {
                            //****show error */
                            $this->db->trans_rollback();
                            log_message("error", '#NOTE3424L212: Unable to process due to not dags # '.$case_no);
                            $json = [
                                'responseType' => 3,
                                'message' => '#NOTE3424L212: Something went wrong for # '.$case_no,
                                'list' => json_encode($completedCases),
                            ];
                            echo json_encode($json);
                            return;
                        }

                    }


                    if(($data['dept_order_no'] == null || $data['dept_order_no'] == '' || empty($data['dept_order_no'])) || ($data['dept_order_date'] == null || $data['dept_order_date'] == '' || empty($data['dept_order_date'])))
                    {
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE3424L213: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE3424L213: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    if($data['date_of_sldc'] == null || $data['date_of_sldc'] == '' || empty($data['date_of_sldc']))
                    {
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE3424L214: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE3424L214: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    if($basic['dept_order_date'] == null || $basic['dept_order_date'] == '' || empty($basic['dept_order_date']))
                    {
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE3424L215: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE3424L215: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    $trArr = '';
                    $area_all = array();
                    $dag_arr = array();
                    $data['actual_premium'] = 0;
                    $settlement_amount      = 0;
                    $final_reclass_amount   = 0;
                    $final_land_revenue_years    = 0;
                    $reclass_amount = 0;
                    $land_revenue_years = 0;

                    $sl_counter = 1;

                    foreach($premium_data_arr as $premium)
                    {
                        
                        $dag_no = $premium->dag_no;
                        $SingleDagCheck = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ? and dag_no = ?", array($case_no, $dag_no))->row();

                        $premium_per_bigha = $premium->zonal_valuation;
                        
                        $dag_arr[] = $premium->dag_no;
                        $total_lessa = $premium->total_lessa;
                        if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                        {
                            $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa);
                            $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                            $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        }
                        else
                        {
                            $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                            // $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                            $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                            $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                        }

                        $data['first_area'] = implode ( ", ", $area_all );
                        $data['first_dag_no'] = implode ( ", ", $dag_arr );
                        $total_amount = ceil($premium->amount_dag);
                        $total_amount = $total_amount;
                        $net_premium_payable = ceil($premium->final_amount);
                        $org_reclass_amount = ceil($premium->ins_reclass_amount);


                        $reclass_amount += $premium->ins_reclass_amount;
                        $land_revenue_years += $premium->land_revenue_years;
                        $settlement_amount += $total_amount;


                        $mandolikPremium = null;
                        if($SingleDagCheck->is_urban == 'N' && $premium->area_name == 10)
                        {
                            $mandolikPremium = "Rs 500-Rural Area";
                        }
                        else
                        {
                            $mandolikPremium = "Rs 50000-Urban Area";
                        }
                        $loloCounter = 1;
                        $trArr .= '<tr>
                                    <td rowspan="'.$loloCounter.'" class="text-center">'.$sl_counter++.'</td>
                                    <td>
                                      ৰেহাই মূল্যত বন্দৱস্তী প্ৰিমিয়াম
                                    </td>
                                    <td>'.$mandolikPremium.'</td>
                                    <td>'.$dag_no.'</td>
                                    <td style="white-space: nowrap;">'.$area.'</td>
                                    <td style="white-space: nowrap;" class="text-right pr-2">+₹ '.($total_amount - $org_reclass_amount).'</td>
                                </tr>';
                                $trArr .= '<tr>
                                    <td colspan="5" class="text-center"><b> শ্ৰেণী পৰিৱৰ্তন ও হস্তান্তৰ প্ৰিমিয়াম মূল্য(যদি প্ৰযোজ্য)</b></td>
                                    <td class="text-right pr-2"><b>₹ '.$org_reclass_amount.'</b></td>
                                </tr>';
                               
                        
                    }

                    $final_reclass_amount = $reclass_amount;
                    $final_land_revenue_years = $land_revenue_years;
                    $total_reclass_revenue = $reclass_amount;
                    $final_settlement_amount = ($settlement_amount - ceil($total_reclass_revenue));
                    

                    $trArr .= '<tr>
                                    <td colspan="5" class="text-center"><b>মুঠ দিবলগীয়া প্ৰিমিয়াম</b></td>
                                    <td class="text-right pr-2"><b>₹ '.$net_premium_payable.'</b></td>
                                </tr>';

                    $data['net_premium_payable'] = $net_premium_payable;
                    $data['final_reclass_amount'] = $reclass_amount;
                    $data['final_land_revenue_years'] = $land_revenue_years;
                    $data['final_settlement_amount'] = ($settlement_amount - ceil($total_reclass_revenue));

                    $data['tbody'] = $trArr;


                    
                }
                else
                {
                    $this->db->trans_rollback();
                    log_message("error", '#ERRCAT3: Premium data not found # '.$case_no);
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCAT3: Premium data not found # '.$case_no,
                        'list' => json_encode($completedCases),
                    ];
                    echo json_encode($json);
                    return;
                }
                
                $htmlStringUpload = $this->load->view('SettlementView/include/juridical_premium_notice_settlement_non_govt_religious_socioculture_1', $data,TRUE);
            }
            else if($insDetails->ins_cat_type_co == '12' && $apLmnoteDetails->already_alloted == 'Y' && $insDetails->purpose_land_allot_co == 'education' && ($insDetails->under_venture_school == 'NO' || $insDetails->under_venture_school == '' || $insDetails->under_venture_school == null))
            {

                $data['service_name_pre'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities-Direct Settlement to Non Govt Educational institution';


                $data['service_name'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities';


                $premium_data = $this->db->query("SELECT * from settlement_premium where case_no=? and is_final=?", array($case_no, 1));
                if($premium_data->num_rows() > 0)
                {
                    
                    $premium_data_row = $premium_data->row();
                    $premium_data_arr = $premium_data->result();

                    if(!isset($dags))
                    {
                        //****show error */
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE3424G211: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE3424G211: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    foreach($dags as $dag_item)
                    {
                        $premiumSql = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $dag_item->dag_no, 1));
                
                        if($premiumSql->num_rows() <= 0)
                        {
                            //****show error */
                            $this->db->trans_rollback();
                        log_message("error", '#NOTE3424G212: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE3424G212: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                        }

                    }


                    if(($data['dept_order_no'] == null || $data['dept_order_no'] == '' || empty($data['dept_order_no'])) || ($data['dept_order_date'] == null || $data['dept_order_date'] == '' || empty($data['dept_order_date'])))
                    {
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE3424G213: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE3424G213: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    if($data['date_of_sldc'] == null || $data['date_of_sldc'] == '' || empty($data['date_of_sldc']))
                    {
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE3424G214: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE3424G214: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    if($basic['dept_order_date'] == null || $basic['dept_order_date'] == '' || empty($basic['dept_order_date']))
                    {
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE3424G215: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE3424G215: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    $trArr = '';
                    $area_all = array();
                    $dag_arr = array();
                    $data['actual_premium'] = 0;
                    $settlement_amount      = 0;
                    $final_reclass_amount   = 0;
                    $final_land_revenue_years    = 0;
                    $reclass_amount = 0;
                    $land_revenue_years = 0;


                    $sl_counter = 1;

                    foreach($premium_data_arr as $premium)
                    {
                        $premium_per_bigha = $premium->zonal_valuation;
                        $dag_no = $premium->dag_no;
                        $dag_arr[] = $premium->dag_no;
                        $total_lessa = $premium->total_lessa;
                        if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                        {
                            $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa);
                            $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                            $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        }
                        else
                        {
                            $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                            // $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                            $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                            $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                        }

                        $data['first_area'] = implode ( ", ", $area_all );
                        $data['first_dag_no'] = implode ( ", ", $dag_arr );
                        $total_amount = ceil($premium->amount_dag);
                        $net_premium_payable = ceil($premium->final_amount);
                        $org_reclass_amount = ceil($premium->ins_reclass_amount);


                        $reclass_amount += $premium->ins_reclass_amount;
                        $land_revenue_years += $premium->land_revenue_years;
                        $settlement_amount += $total_amount;

                        $mandolikPremium = null;
                        if($insDetails->non_govt_profit_making_yes_no == 'N')
                        {
                            $mandolikPremium = "মাণ্ডলিক মূল্যৰ ১০০%";
                        }
                        else if($insDetails->non_govt_profit_making_yes_no == 'Y')
                        {
                            $mandolikPremium = "মাণ্ডলিক মূল্যৰ ৩০%";
                        }
                        else
                        {
                            $mandolikPremium = '';
                        }
                        $loloCounter = 1;
                        $trArr .= '<tr>
                                    <td rowspan="'.$loloCounter.'" class="text-center">'.$sl_counter++.'</td>
                                    <td>
                                        বন্দৱস্তী প্ৰিমিয়াম মূল্য<br>'.$mandolikPremium.'
                                    </td>
                                    <td>'.$premium_per_bigha.'</td>
                                    <td>'.$dag_no.'</td>
                                    <td style="white-space: nowrap;">'.$area.'</td>
                                    <td style="white-space: nowrap;" class="text-right pr-2">+₹ '.($total_amount - $org_reclass_amount).'</td>
                                </tr>';
                        $trArr .= '<tr>
                                    <td colspan="5" class="text-center"><b>শ্ৰেণী পৰিৱৰ্তন ও হস্তান্তৰ প্ৰিমিয়াম মূল্য (যদি প্ৰযোজ্য)</b></td>
                                    <td class="text-right pr-2"><b>₹ '.$org_reclass_amount.'</b></td>
                                </tr>';
                               
                        
                    }

                    $final_reclass_amount = $reclass_amount;
                    $final_land_revenue_years = $land_revenue_years;
                    $total_reclass_revenue = $reclass_amount;
                    $final_settlement_amount = ($settlement_amount - ceil($total_reclass_revenue));


                    $trArr .= '<tr>
                                    <td colspan="5" class="text-center"><b>মুঠ দিবলগীয়া প্ৰিমিয়াম</b></td>
                                    <td class="text-right pr-2"><b>₹ '.$net_premium_payable.'</b></td>
                                </tr>';


                    $data['net_premium_payable'] = $net_premium_payable;

                    $data['final_reclass_amount'] = $reclass_amount;
                    $data['final_land_revenue_years'] = $land_revenue_years;
                    $data['final_settlement_amount'] = ($settlement_amount - ceil($total_reclass_revenue));


                    $data['tbody'] = $trArr;

                    
                }
                else
                {
                    $this->db->trans_rollback();
                    log_message("error", '#ERRCAT4: Premium data not found # '.$case_no);
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCAT4: Premium data not found # '.$case_no,
                        'list' => json_encode($completedCases),
                    ];
                    echo json_encode($json);
                    return;
                }

                $htmlStringUpload = $this->load->view('SettlementView/include/juridical_premium_notice_settlement_non_govt_education_1', $data,TRUE);
            }
            else if($insDetails->ins_cat_type_co == '12' && $apLmnoteDetails->already_alloted == 'Y' && $insDetails->purpose_land_allot_co == 'education' && $insDetails->under_venture_school == 'YES' && $insDetails->venture_type == 'unrecognised_venture')
            {

                $data['service_name_pre'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities-Direct Settlement to Non Govt Educational institution';


                $data['service_name'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities';


                $premium_data = $this->db->query("SELECT * from settlement_premium where case_no=? and is_final=?", array($case_no, 1));
                if($premium_data->num_rows() > 0)
                {
                    
                    $premium_data_row = $premium_data->row();
                    $premium_data_arr = $premium_data->result();

                    if(!isset($dags))
                    {
                        //****show error */
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE3424R211: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE3424R211: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    foreach($dags as $dag_item)
                    {
                        $premiumSql = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $dag_item->dag_no, 1));
                
                        if($premiumSql->num_rows() <= 0)
                        {
                            //****show error */
                            $this->db->trans_rollback();
                        log_message("error", '#NOTE3424R212: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE3424R212: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                        }

                    }


                    if(($data['dept_order_no'] == null || $data['dept_order_no'] == '' || empty($data['dept_order_no'])) || ($data['dept_order_date'] == null || $data['dept_order_date'] == '' || empty($data['dept_order_date'])))
                    {
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE3424R213: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE3424R213: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    if($data['date_of_sldc'] == null || $data['date_of_sldc'] == '' || empty($data['date_of_sldc']))
                    {
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE3424R214: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE3424R214: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    if($basic['dept_order_date'] == null || $basic['dept_order_date'] == '' || empty($basic['dept_order_date']))
                    {
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE3424R215: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE3424R215: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    $trArr = '';
                    $area_all = array();
                    $dag_arr = array();
                    $data['actual_premium'] = 0;
                    $settlement_amount      = 0;
                    $final_reclass_amount   = 0;
                    $final_land_revenue_years    = 0;
                    $reclass_amount = 0;
                    $land_revenue_years = 0;

                    $sl_counter = 1;

                    foreach($premium_data_arr as $premium)
                    {
                        
                    
                        $premium_per_bigha = $premium->zonal_valuation;
                        $dag_no = $premium->dag_no;
                        $dag_arr[] = $premium->dag_no;
                        $total_lessa = $premium->total_lessa;
                        if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                        {
                            $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa);
                            $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                            $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        }
                        else
                        {
                            $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                            // $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                            $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                            $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                        }

                        $data['first_area'] = implode ( ", ", $area_all );
                        $data['first_dag_no'] = implode ( ", ", $dag_arr );
                        $total_amount = ceil($premium->amount_dag);
                        $net_premium_payable = ceil($premium->final_amount);
                        $org_reclass_amount = ceil($premium->ins_reclass_amount);


                        $reclass_amount += $premium->ins_reclass_amount;
                        $land_revenue_years += $premium->land_revenue_years;
                        $settlement_amount += $total_amount;



                        $mandolikPremium = null;
                        // if($insDetails->non_govt_profit_making_yes_no == 'N')
                        // {
                        //     $mandolikPremium = "মাণ্ডলিক মূল্যৰ ১০০%";
                        // }
                        // else
                        // {
                        //     $mandolikPremium = "মাণ্ডলিক মূল্যৰ ৩০%";
                        // }
                        $loloCounter = 1;
                        $trArr .= '<tr>
                                    <td rowspan="'.$loloCounter.'" class="text-center">'.$sl_counter++.'</td>
                                    <td>
                                        বন্দৱস্তী প্ৰিমিয়াম মূল্য<br>'.$mandolikPremium.'
                                    </td>
                                    <td>'.$premium_per_bigha.'</td>
                                    <td>'.$dag_no.'</td>
                                    <td style="white-space: nowrap;">'.$area.'</td>
                                    <td style="white-space: nowrap;" class="text-right pr-2">+₹ '.($total_amount - $org_reclass_amount).'</td>
                                </tr>';
                        $trArr .= '<tr>
                                    <td colspan="5" class="text-center"><b>শ্ৰেণী পৰিৱৰ্তন ও হস্তান্তৰ প্ৰিমিয়াম মূল্য (যদি প্ৰযোজ্য)</b></td>
                                    <td class="text-right pr-2"><b>₹ '.$org_reclass_amount.'</b></td>
                                </tr>';
                               
                        
                    }

                    $final_reclass_amount = $reclass_amount;
                    $final_land_revenue_years = $land_revenue_years;
                    $total_reclass_revenue = $reclass_amount ;
                    $final_settlement_amount = ($settlement_amount - ceil($total_reclass_revenue));

                    

                    $trArr .= '<tr>
                                    <td colspan="5" class="text-center"><b>মুঠ দিবলগীয়া প্ৰিমিয়াম</b></td>
                                    <td class="text-right pr-2"><b>₹ '.$net_premium_payable.'</b></td>
                                </tr>';


                    $data['net_premium_payable'] = $net_premium_payable;

                    $data['final_reclass_amount'] = $reclass_amount;
                    $data['final_land_revenue_years'] = $land_revenue_years;
                    $data['final_settlement_amount'] = ($settlement_amount - ceil($total_reclass_revenue));
                    $data['tbody'] = $trArr;

                    
                }
                else
                {
                    $this->db->trans_rollback();
                    log_message("error", '#ERRCAT5: Premium data not found # '.$case_no);
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCAT5: Premium data not found # '.$case_no,
                        'list' => json_encode($completedCases),
                    ];
                    echo json_encode($json);
                    return;
                }

                $htmlStringUpload = $this->load->view('SettlementView/include/juridical_premium_notice_settlement_non_govt_education_1', $data,TRUE);
            }
            else if($insDetails->ins_cat_type_co == '10')
            {

                $data['service_name_pre'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities-Land Transfer/ Settlement to Central Govt Department/Central Govt Undertakings';


                $data['service_name'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities';

                $premium_data = $this->db->query("SELECT * from settlement_premium where case_no=? and is_final=?", array($case_no, 1));
                if($premium_data->num_rows() > 0)
                {
                    
                    $premium_data_row = $premium_data->row();
                    $premium_data_arr = $premium_data->result();

                    if(!isset($dags))
                    {
                        //****show error */
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE3424C211: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE3424C211: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    foreach($dags as $dag_item)
                    {
                        $premiumSql = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $dag_item->dag_no, 1));
                
                        if($premiumSql->num_rows() <= 0)
                        {
                            //****show error */
                            $this->db->trans_rollback();
                        log_message("error", '#NOTE3424C212: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE3424C212: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                        }

                    }


                    // if(($data['dept_order_no'] == null || $data['dept_order_no'] == '' || empty($data['dept_order_no'])) || ($data['dept_order_date'] == null || $data['dept_order_date'] == '' || empty($data['dept_order_date'])))
                    // {
                    //     $this->session->set_flashdata('message', "#ERR1913: Unable to process! Something went wrong...#".$case_no);
                    //     redirect(base_url().'index.php/home');
                    // }

                    if($data['date_of_sldc'] == null || $data['date_of_sldc'] == '' || empty($data['date_of_sldc']))
                    {
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE3424C212: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE3424C212: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    // if($basic['dept_order_date'] == null || $basic['dept_order_date'] == '' || empty($basic['dept_order_date']))
                    // {
                    //     $this->session->set_flashdata('message', "#ERR203935: Unable to process! Something went wrong...#".$case_no);
                    //     redirect(base_url().'index.php/home');
                    // }

                    $trArr = '';
                    $area_all = array();
                    $dag_arr = array();
                    $data['actual_premium'] = 0;
                    $reclass_amount = 0;
                    $land_revenue_years = 0;
                    $settlement_amount = 0;

                    $sl_counter = 1;

                    foreach($premium_data_arr as $premium)
                    {
                        
                    
                        $premium_per_bigha = $premium->zonal_valuation;
                        $dag_no = $premium->dag_no;
                        $dag_arr[] = $premium->dag_no;
                        $total_lessa = $premium->total_lessa;
                        if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                        {
                            $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa);
                            $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                            $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        }
                        else
                        {
                            $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                            // $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                            $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                            $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                        }

                        $data['first_area'] = implode ( ", ", $area_all );
                        $data['first_dag_no'] = implode ( ", ", $dag_arr );
                        $total_amount = ceil($premium->amount_dag);
                        $net_premium_payable = ceil($premium->final_amount);
                        $org_reclass_amount = ceil($premium->ins_reclass_amount);
                        $org_land_revenue_years = ceil($premium->land_revenue_years);

                        $reclass_amount += $premium->ins_reclass_amount;
                        $land_revenue_years += $premium->land_revenue_years;
                        $settlement_amount += $total_amount;
                        
                        $mandolikPremium = "মাণ্ডলিক মূল্যৰ ১০০%";
                        
                        
                        $loloCounter = 1;
                        $trArr .= '<tr>
                                    <td rowspan="'.$loloCounter.'" class="text-center">'.$sl_counter++.'</td>
                                    <td>
                                        ভূমিৰ বন্দৱস্তী/হস্তান্তৰ প্ৰিমিয়াম মূল্য<br>'.$mandolikPremium.'
                                    </td>
                                    <td>'.$premium_per_bigha.'</td>
                                    <td>'.$org_land_revenue_years.'</td>
                                    <td>'.$dag_no.'</td>
                                    <td style="white-space: nowrap;">'.$area.'</td>
                                    <td style="white-space: nowrap;" class="text-right pr-2">+₹ '.($total_amount - $org_reclass_amount - $org_land_revenue_years).'</td>
                                </tr>';

                        $trArr .= '<tr>
                                    <td colspan="6" class="text-center"><b>২৫ বছৰৰ মূলধনীকৃত ভূমি ৰাজহ</b></td>
                                    <td class="text-right pr-2"><b>₹ '.$org_land_revenue_years.'</b></td>
                                </tr>';
                        $trArr .= '<tr>
                                    <td colspan="6" class="text-center"><b>শ্ৰেণী পৰিৱৰ্তন ও স্থানান্তৰ প্ৰিমিয়াম মূল্য (যদি প্ৰযোজ্য)</b></td>
                                    <td class="text-right pr-2"><b>₹ '.$org_reclass_amount.'</b></td>
                                </tr>';
                               
                        
                    }

                    $final_reclass_amount = $reclass_amount;
                    $final_land_revenue_years = $land_revenue_years;
                    $total_reclass_revenue = $reclass_amount;
                    $final_settlement_amount = ($settlement_amount - ceil($total_reclass_revenue));

                    

                    $trArr .= '<tr>
                                    <td colspan="6" class="text-center"><b>মুঠ দিবলগীয়া প্ৰিমিয়াম</b></td>
                                    <td class="text-right pr-2"><b>₹ '.$net_premium_payable.'</b></td>
                                </tr>';


                    $data['net_premium_payable'] = $net_premium_payable;
                    $data['final_reclass_amount'] = $reclass_amount;
                    $data['final_land_revenue_years'] = ceil($final_land_revenue_years);
                    $data['final_settlement_amount'] = ($settlement_amount - ceil($total_reclass_revenue));


                    $data['tbody'] = $trArr;

                    
                }
                else
                {
                    $this->db->trans_rollback();
                    log_message("error", '#ERRCAT5: Premium data not found # '.$case_no);
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCAT5: Premium data not found # '.$case_no,
                        'list' => json_encode($completedCases),
                    ];
                    echo json_encode($json);
                    return;
                }
                $htmlStringUpload  = $this->load->view('SettlementView/include/juridical_premium_notice_central_govt_1', $data,TRUE);
            }
            else if($insDetails->ins_cat_type_co == '11')
            {

                $data['service_name_pre'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities-Land Transfer/ Settlement to Central Govt Department/Central Govt Undertakings';


                $data['service_name'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities';

                $premium_data = $this->db->query("SELECT * from settlement_premium where case_no=? and is_final=?", array($case_no, 1));
                if($premium_data->num_rows() > 0)
                {
                    
                    $premium_data_row = $premium_data->row();
                    $premium_data_arr = $premium_data->result();

                    if(!isset($dags))
                    {
                        //****show error */
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE3424T211: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE3424T211: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    foreach($dags as $dag_item)
                    {
                        $premiumSql = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $dag_item->dag_no, 1));
                
                        if($premiumSql->num_rows() <= 0)
                        {
                            //****show error */
                            $this->db->trans_rollback();
                        log_message("error", '#NOTE3424T212: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE3424T212: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                        }

                    }


                    // if(($data['dept_order_no'] == null || $data['dept_order_no'] == '' || empty($data['dept_order_no'])) || ($data['dept_order_date'] == null || $data['dept_order_date'] == '' || empty($data['dept_order_date'])))
                    // {
                    //     $this->session->set_flashdata('message', "#ERR1913: Unable to process! Something went wrong...#".$case_no);
                    //     redirect(base_url().'index.php/home');
                    // }

                    if($data['date_of_sldc'] == null || $data['date_of_sldc'] == '' || empty($data['date_of_sldc']))
                    {
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE3424T213: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE3424T213: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    // if($basic['dept_order_date'] == null || $basic['dept_order_date'] == '' || empty($basic['dept_order_date']))
                    // {
                    //     $this->session->set_flashdata('message', "#ERR203935: Unable to process! Something went wrong...#".$case_no);
                    //     redirect(base_url().'index.php/home');
                    // }

                    $trArr = '';
                    $area_all = array();
                    $dag_arr = array();
                    $data['actual_premium'] = 0;
                    $reclass_amount = 0;
                    $land_revenue_years = 0;
                    $settlement_amount = 0;

                    $sl_counter = 1;

                    foreach($premium_data_arr as $premium)
                    {
                        
                    
                        $premium_per_bigha = $premium->zonal_valuation;
                        $dag_no = $premium->dag_no;
                        $dag_arr[] = $premium->dag_no;
                        $total_lessa = $premium->total_lessa;
                        if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                        {
                            $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa);
                            $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                            $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        }
                        else
                        {
                            $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                            // $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                            $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                            $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                        }

                        $data['first_area'] = implode ( ", ", $area_all );
                        $data['first_dag_no'] = implode ( ", ", $dag_arr );
                        $total_amount = ceil($premium->amount_dag);
                        $net_premium_payable = ceil($premium->final_amount);
                        $org_reclass_amount = ceil($premium->ins_reclass_amount);
                        $org_land_revenue_years = ceil($premium->land_revenue_years);

                        $reclass_amount += $premium->ins_reclass_amount;
                        $land_revenue_years += $premium->land_revenue_years;
                        $settlement_amount += $total_amount;
                        
                        $mandolikPremium = "মাণ্ডলিক মূল্যৰ ১০০%";
                        
                        
                        $loloCounter = 1;
                        $trArr .= '<tr>
                                    <td rowspan="'.$loloCounter.'" class="text-center">'.$sl_counter++.'</td>
                                    <td>
                                        ভূমিৰ বন্দৱস্তী/হস্তান্তৰ প্ৰিমিয়াম মূল্য<br>'.$mandolikPremium.'
                                    </td>
                                    <td>'.$premium_per_bigha.'</td>
                                    <td>'.$org_land_revenue_years.'</td>
                                    <td>'.$dag_no.'</td>
                                    <td style="white-space: nowrap;">'.$area.'</td>
                                    <td style="white-space: nowrap;" class="text-right pr-2">+₹ '.($total_amount - $org_reclass_amount - $org_land_revenue_years).'</td>
                                </tr>';

                        $trArr .= '<tr>
                                    <td colspan="6" class="text-center"><b>২৫ বছৰৰ মূলধনীকৃত ভূমি ৰাজহ</b></td>
                                    <td class="text-right pr-2"><b>₹ '.$org_land_revenue_years.'</b></td>
                                </tr>';
                        $trArr .= '<tr>
                                    <td colspan="6" class="text-center"><b>শ্ৰেণী পৰিৱৰ্তন ও স্থানান্তৰ প্ৰিমিয়াম মূল্য (যদি প্ৰযোজ্য)</b></td>
                                    <td class="text-right pr-2"><b>₹ '.$org_reclass_amount.'</b></td>
                                </tr>';
                               
                        
                    }

                    $final_reclass_amount = $reclass_amount;
                    $final_land_revenue_years = $land_revenue_years;
                    $total_reclass_revenue = $reclass_amount;
                    $final_settlement_amount = ($settlement_amount - ceil($total_reclass_revenue));

                    

                    $trArr .= '<tr>
                                    <td colspan="6" class="text-center"><b>মুঠ দিবলগীয়া প্ৰিমিয়াম</b></td>
                                    <td class="text-right pr-2"><b>₹ '.$net_premium_payable.'</b></td>
                                </tr>';


                    $data['net_premium_payable'] = $net_premium_payable;
                    $data['final_reclass_amount'] = $reclass_amount;
                    $data['final_land_revenue_years'] = ceil($final_land_revenue_years);
                    $data['final_settlement_amount'] = ($settlement_amount - ceil($total_reclass_revenue));


                    $data['tbody'] = $trArr;

                    
                }
                else
                {
                    $this->db->trans_rollback();
                    log_message("error", '#ERRCAT5: Premium data not found # '.$case_no);
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCAT5: Premium data not found # '.$case_no,
                        'list' => json_encode($completedCases),
                    ];
                    echo json_encode($json);
                    return;
                }
                $htmlStringUpload  = $this->load->view('SettlementView/include/juridical_premium_notice_central_govt_settlement_1', $data,TRUE);
            }
            else if($insDetails->ins_cat_type_co == '9' && $apLmnoteDetails->already_alloted == 'Y')
            {

                $data['service_name_pre'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities- Settlement_State Govt Undertakings';

                $data['service_name'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities';


                $premium_data = $this->db->query("SELECT * from settlement_premium where case_no=? and is_final=?", array($case_no, 1));
                if($premium_data->num_rows() > 0)
                {
                    
                    $premium_data_row = $premium_data->row();
                    $premium_data_arr = $premium_data->result();

                    if(!isset($dags))
                    {
                        //****show error */
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE3424T214: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE3424T214: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    foreach($dags as $dag_item)
                    {
                        $premiumSql = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $dag_item->dag_no, 1));
                
                        if($premiumSql->num_rows() <= 0)
                        {
                            //****show error */
                            $this->db->trans_rollback();
                            log_message("error", '#NOTE3424T212: Unable to process due to not dags # '.$case_no);
                            $json = [
                                'responseType' => 3,
                                'message' => '#NOTE3424T212: Something went wrong for # '.$case_no,
                                'list' => json_encode($completedCases),
                            ];
                            echo json_encode($json);
                            return;
                        }

                    }


                    if(($data['dept_order_no'] == null || $data['dept_order_no'] == '' || empty($data['dept_order_no'])) || ($data['dept_order_date'] == null || $data['dept_order_date'] == '' || empty($data['dept_order_date'])))
                    {
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE3424T217: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE3424T217: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    if($data['date_of_sldc'] == null || $data['date_of_sldc'] == '' || empty($data['date_of_sldc']))
                    {
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE3424T218: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE3424T218: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    if($basic['dept_order_date'] == null || $basic['dept_order_date'] == '' || empty($basic['dept_order_date']))
                    {
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE3424T219: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE3424T219: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    $trArr = '';
                    $area_all = array();
                    $dag_arr = array();
                    $data['actual_premium'] = 0;
                    $reclass_amount = 0;
                    $land_revenue_years = 0;
                    $settlement_amount = 0;
                    $sl_counter = 1;

                    foreach($premium_data_arr as $premium)
                    {
                        
                    
                        $premium_per_bigha = $premium->zonal_valuation;
                        $dag_no = $premium->dag_no;
                        $dag_arr[] = $premium->dag_no;
                        $total_lessa = $premium->total_lessa;
                        if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                        {
                            $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa);
                            $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                            $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        }
                        else
                        {
                            $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                            // $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                            $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                            $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                        }

                        $data['first_area'] = implode ( ", ", $area_all );
                        $data['first_dag_no'] = implode ( ", ", $dag_arr );
                        $total_amount = ceil($premium->amount_dag);
                        $net_premium_payable = ceil($premium->final_amount);
                        $org_reclass_amount = ceil($premium->ins_reclass_amount);
                        $org_land_revenue_years = ceil($premium->land_revenue_years);


                        $reclass_amount += $premium->ins_reclass_amount;
                        $land_revenue_years += $premium->land_revenue_years;
                        $settlement_amount += $total_amount;
                       
                        
                        $mandolikPremium = "মাণ্ডলিক মূল্যৰ ১০০%";
                        
                        
                        $loloCounter = 1;
                        $trArr .= '<tr>
                                    <td rowspan="'.$loloCounter.'" class="text-center">'.$sl_counter++.'</td>
                                    <td>
                                        বন্দৱস্তীৰ প্ৰিমিয়াম মূল্য <br> '.$mandolikPremium.'
                                    </td>
                                    <td>'.$premium_per_bigha.'</td>
                                    <td>'.$dag_no.'</td>
                                    <td style="white-space: nowrap;">'.$area.'</td>
                                    <td style="white-space: nowrap;" class="text-right pr-2">+₹ '.($total_amount - $org_reclass_amount).'</td>
                                </tr>';

                        
                        $trArr .= '<tr>
                                    <td colspan="5" class="text-center"><b>শ্ৰেণী পৰিৱৰ্তন ও স্থানান্তৰ প্ৰিমিয়াম মূল্য (যদি প্ৰযোজ্য)</b></td>
                                    <td class="text-right pr-2"><b>₹ '.$org_reclass_amount.'</b></td>
                                </tr>';
                               
                        
                    }

                    $final_reclass_amount = $reclass_amount;
                    $final_land_revenue_years = $land_revenue_years;
                    $total_reclass_revenue = $reclass_amount;
                    $final_settlement_amount = ($settlement_amount - ceil($total_reclass_revenue));

                    

                    $trArr .= '<tr>
                                    <td colspan="5" class="text-center"><b>মুঠ দিবলগীয়া প্ৰিমিয়াম</b></td>
                                    <td class="text-right pr-2"><b>₹ '.$net_premium_payable.'</b></td>
                                </tr>';


                    $data['net_premium_payable'] = $net_premium_payable;
                    $data['final_reclass_amount'] = $reclass_amount;
                    $data['final_land_revenue_years'] = $land_revenue_years;
                    $data['final_settlement_amount'] = ($settlement_amount - ceil($total_reclass_revenue));


                    $data['tbody'] = $trArr;

                    
                }
                else
                {
                    $this->db->trans_rollback();
                    log_message("error", '#ERRCAT6: Premium data not found # '.$case_no);
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCAT6: Premium data not found # '.$case_no,
                        'list' => json_encode($completedCases),
                    ];
                    echo json_encode($json);
                    return;
                }
                $htmlStringUpload  = $this->load->view('SettlementView/include/juridical_premium_notice_settlement_state_govt_undertakings_1', $data,TRUE);
            }
            else if($insDetails->ins_cat_type_co == '9' && $apLmnoteDetails->already_alloted == 'N')
            {
                $data['service_name_pre'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities- Allotment to State Govt Undertakings';
                $data['service_name'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities';
                $premium_data = $this->db->query("SELECT * from settlement_premium where case_no=? and is_final=?", array($case_no, 1));
                if($premium_data->num_rows() > 0)
                {
                    
                    $premium_data_row = $premium_data->row();
                    $premium_data_arr = $premium_data->result();

                    if(!isset($dags))
                    {
                        //****show error */
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE3424T311: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE3424T311: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    foreach($dags as $dag_item)
                    {
                        $premiumSql = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $dag_item->dag_no, 1));
                
                        if($premiumSql->num_rows() <= 0)
                        {
                            //****show error */
                            $this->db->trans_rollback();
                            log_message("error", '#NOTE3424T312: Unable to process due to not dags # '.$case_no);
                            $json = [
                                'responseType' => 3,
                                'message' => '#NOTE3424T312: Something went wrong for # '.$case_no,
                                'list' => json_encode($completedCases),
                            ];
                            echo json_encode($json);
                            return;
                        }

                    }


                    // if(($data['dept_order_no'] == null || $data['dept_order_no'] == '' || empty($data['dept_order_no'])) || ($data['dept_order_date'] == null || $data['dept_order_date'] == '' || empty($data['dept_order_date'])))
                    // {
                    //     $this->session->set_flashdata('message', "#ERR1913: Unable to process! Something went wrong...#".$case_no);
                    //     redirect(base_url().'index.php/home');
                    // }

                    if($data['date_of_sldc'] == null || $data['date_of_sldc'] == '' || empty($data['date_of_sldc']))
                    {
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE3424T313: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE3424T313: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    // if($basic['dept_order_date'] == null || $basic['dept_order_date'] == '' || empty($basic['dept_order_date']))
                    // {
                    //     $this->session->set_flashdata('message', "#ERR203935: Unable to process! Something went wrong...#".$case_no);
                    //     redirect(base_url().'index.php/home');
                    // }

                    $trArr = '';
                    $area_all = array();
                    $dag_arr = array();
                    $data['actual_premium'] = 0;
                    $reclass_amount = 0;
                    $settlement_amount = 0;
                    $land_revenue_years = 0;
                    $sl_counter = 1;

                    foreach($premium_data_arr as $premium)
                    {
                        
                    
                        $premium_per_bigha = $premium->zonal_valuation;
                        $dag_no = $premium->dag_no;
                        $dag_arr[] = $premium->dag_no;
                        $total_lessa = $premium->total_lessa;
                        if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                        {
                            $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa);
                            $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                            $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        }
                        else
                        {
                            $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                            // $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                            $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                            $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                        }

                        $data['first_area'] = implode ( ", ", $area_all );
                        $data['first_dag_no'] = implode ( ", ", $dag_arr );
                        $total_amount = ceil($premium->amount_dag);
                        $net_premium_payable = ceil($premium->final_amount);
                        $org_reclass_amount = ceil($premium->ins_reclass_amount);
                        $org_land_revenue_years = ceil($premium->land_revenue_years);

                        $reclass_amount += $premium->ins_reclass_amount;
                        $land_revenue_years += $premium->land_revenue_years;
                        $settlement_amount += $total_amount;



                        $mandolikPremium = null;
                        
                        $mandolikPremium = "মাণ্ডলিক মূল্যৰ ১০০%";
                        
                        $loloCounter = 1;
                        $trArr .= '<tr>
                                    <td rowspan="'.$loloCounter.'" class="text-center">'.$sl_counter++.'</td>
                                    <td>
                                        বন্দৱস্তী প্ৰিমিয়াম মূল্য <br>'.$mandolikPremium.'
                                    </td>
                                    <td>'.$premium_per_bigha.'</td>
                                    <td>'.$dag_no.'</td>
                                    <td style="white-space: nowrap;">'.$area.'</td>
                                    <td style="white-space: nowrap;" class="text-right pr-2">+₹ '.($total_amount * 2).'</td>
                                </tr>';
                               
                        
                    }
                    $final_reclass_amount = $reclass_amount;
                    $final_land_revenue_years = $land_revenue_years;
                    $total_reclass_revenue = $reclass_amount;
                    $final_settlement_amount = ($settlement_amount - ceil($total_reclass_revenue));


                    // $trArr .= '<tr>
                    //                 <td colspan="5" class="text-center"><b>মুঠ দিবলগীয়া প্ৰিমিয়াম</b></td>
                    //                 <td class="text-right pr-2"><b>₹ '.($net_premium_payable * 2).'</b></td>
                    //             </tr>';

                    $trArr .= '<tr>
                                    <td colspan="5" class="text-center"><b>আবণ্টনৰ বাবে দিবলগীয়া প্ৰিমিয়াম (মুঠ বন্দৱস্তী প্ৰিমিয়ামৰ ৫০ শতাংশ)</b></td>
                                    <td class="text-right pr-2"><b>₹ '.$net_premium_payable.'</b></td>
                                </tr>';


                    $data['net_premium_payable'] = $net_premium_payable;

                    $data['final_reclass_amount'] = $reclass_amount;
                    $data['final_land_revenue_years'] = $land_revenue_years;
                    $data['final_settlement_amount'] = ($settlement_amount - ceil($total_reclass_revenue));


                    $data['tbody'] = $trArr;

                    
                }
                else
                {
                    $this->db->trans_rollback();
                    log_message("error", '#ERRCAT7: Premium data not found # '.$case_no);
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCAT7: Premium data not found # '.$case_no,
                        'list' => json_encode($completedCases),
                    ];
                    echo json_encode($json);
                    return;
                }
                $htmlStringUpload  = $this->load->view('SettlementView/include/juridical_premium_notice_allotment_state_govt_undertakings_1', $data,TRUE);
            }
            else if($insDetails->ins_cat_type_co == '12' && $apLmnoteDetails->already_alloted == 'N' && $insDetails->purpose_land_allot_co == 'education' && $insDetails->under_venture_school == 'YES' && $insDetails->venture_type =='govt_aided_venture')
            {
                $data['service_name_pre'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities-Allotment to Govt Aided Venture School';

                $data['service_name'] ='Digitalized Allotment/Settlement of land to Non individual Juridical entities';
                $premium_data = $this->db->query("SELECT * from settlement_premium where case_no=? and is_final=?", array($case_no, 1));
                if($premium_data->num_rows() > 0)
                {
                    
                    $premium_data_row = $premium_data->row();
                    $premium_data_arr = $premium_data->result();

                    if(!isset($dags))
                    {
                        //****show error */
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE3424T316: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE3424T316: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    foreach($dags as $dag_item)
                    {
                        $premiumSql = $this->db->query("SELECT * FROM settlement_premium WHERE case_no = ? and dag_no= ? and is_final =?", array($case_no, $dag_item->dag_no, 1));
                
                        if($premiumSql->num_rows() <= 0)
                        {
                            //****show error */
                            $this->db->trans_rollback();
                            log_message("error", '#NOTE3424T310: Unable to process due to not dags # '.$case_no);
                            $json = [
                                'responseType' => 3,
                                'message' => '#NOTE3424T310: Something went wrong for # '.$case_no,
                                'list' => json_encode($completedCases),
                            ];
                            echo json_encode($json);
                            return;
                        }

                    }


                    if(($data['dept_order_no'] == null || $data['dept_order_no'] == '' || empty($data['dept_order_no'])) || ($data['dept_order_date'] == null || $data['dept_order_date'] == '' || empty($data['dept_order_date'])))
                    {
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE3424T318: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE3424T318: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    if($data['date_of_sldc'] == null || $data['date_of_sldc'] == '' || empty($data['date_of_sldc']))
                    {
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE34265T318: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE34265T318: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    if($basic['dept_order_date'] == null || $basic['dept_order_date'] == '' || empty($basic['dept_order_date']))
                    {
                        $this->db->trans_rollback();
                        log_message("error", '#NOTE344265T318: Unable to process due to not dags # '.$case_no);
                        $json = [
                            'responseType' => 3,
                            'message' => '#NOTE344265T318: Something went wrong for # '.$case_no,
                            'list' => json_encode($completedCases),
                        ];
                        echo json_encode($json);
                        return;
                    }

                    $trArr = '';
                    $area_all = array();
                    $dag_arr = array();
                    $data['actual_premium'] = 0;
                    $reclass_amount = 0;
                    $land_revenue_years = 0;
                    $settlement_amount=0;

                    $sl_counter = 1;

                    foreach($premium_data_arr as $premium)
                    {
                        
                        $dag_no = $premium->dag_no;
                        $SingleDagCheck = $this->db->query("SELECT * FROM settlement_dag_details WHERE case_no = ? and dag_no = ?", array($case_no, $dag_no))->row();


                        $premium_per_bigha = $premium->zonal_valuation;
                        
                        $dag_arr[] = $premium->dag_no;
                        $total_lessa = $premium->total_lessa;
                        if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))
                        {
                            $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa2($total_lessa);
                            $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                            $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                        }
                        else
                        {
                            $bklArr = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lessa);
                            // $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' চ: '.$bklArr[2]. ' গ: '.$bklArr[3]. ' ক্ৰা: 0';
                            $area =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                            $area_all[] =  'বি: '.$bklArr[0]. ' ক: '.$bklArr[1].' লে: '.$bklArr[2];
                        }

                        $data['first_area'] = implode ( ", ", $area_all );
                        $data['first_dag_no'] = implode ( ", ", $dag_arr );
                        $total_amount = ceil($premium->amount_dag);
                        // $total_amount = $total_amount * 2;
                        $net_premium_payable = ceil($premium->final_amount);

                        $reclass_amount += $premium->ins_reclass_amount;
                        $land_revenue_years += $premium->land_revenue_years;
                        $settlement_amount += $total_amount;


                        $mandolikPremium = null;
                        if($SingleDagCheck->is_urban == 'N' && $premium->area_name == 10)
                        {
                            $mandolikPremium = "Rs 250-Rural Area";
                        }
                        else
                        {
                            $mandolikPremium = "Rs 25000-Urban Area";
                        }
                        $loloCounter = 1;
                        $trArr .= '<tr>
                                    <td rowspan="'.$loloCounter.'" class="text-center">'.$sl_counter++.'</td>
                                    <td>
                                       আবণ্টন প্ৰিমিয়াম মূল্য 
                                    </td>
                                    <td>'.$mandolikPremium.'</td>
                                    <td>'.$dag_no.'</td>
                                    <td style="white-space: nowrap;">'.$area.'</td>
                                    <td style="white-space: nowrap;" class="text-right pr-2">+₹ '.$total_amount.'</td>
                                </tr>';
                               
                        
                    }


                    $trArr .= '<tr>
                                    <td colspan="5" class="text-center"><b>মুঠ প্ৰিমিয়াম </b></td>
                                    <td class="text-right pr-2"><b>₹ '.$net_premium_payable.'</b></td>
                                </tr>';


                    $data['net_premium_payable'] = $net_premium_payable;
                    $data['final_reclass_amount'] = $reclass_amount;
                    $data['final_land_revenue_years'] = $land_revenue_years;
                    $total_reclass_revenue = $reclass_amount;
                    $data['final_settlement_amount'] = ($settlement_amount - ceil($total_reclass_revenue));
                    $data['tbody'] = $trArr;

                    
                }
                else
                {
                    $this->db->trans_rollback();
                    log_message("error", '#ERRCAT8: Premium data not found # '.$case_no);
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRCAT8: Premium data not found # '.$case_no,
                        'list' => json_encode($completedCases),
                    ];
                    echo json_encode($json);
                    return;
                }
                $htmlStringUpload  = $this->load->view('SettlementView/include/juridical_premium_notice_settlement_non_govt_education_govt_aided_1', $data,TRUE);
            }


            // var_dump($htmlStringUpload);
            // die;
            ///////////////save payment notice///////////////////

            $noticeAlreadyGeneratedCheck = $this->db->query('select * from settlement_notice where case_no = ? and notice_type = ?', array($case_no, 'PN'));
            $old_notice_link = false;
            if($noticeAlreadyGeneratedCheck->num_rows() > 0)
            {
                //******re-generate premium notice first check if payment already done for this case_no */
                $paymentStatusCheck = $this->basundhara3Model->paymentStatusCheck($case_no);
                // var_dump($case_no);die;
                if($paymentStatusCheck['responseType'] != 2)
                {
                    $this->db->trans_rollback();
                    $json = [
                        'responseType' => 3,
                        'list' => json_encode($completedCases),
                        'message' => 'Payment already been done, please select another case no.'

                    ];
                    echo json_encode($json);
                    return;
                }

                //***getting the old notice link before deleting it */
                $old_notice_link = $noticeAlreadyGeneratedCheck->row()->notice_link;
                //***delete the notice */
                $this->db->query('delete from settlement_notice where case_no = ? and notice_type = ?', array($case_no, 'PN'));

                if($this->db->affected_rows() != 1)
                {
                    $this->db->trans_rollback();
                    $json = [
                        'responseType' => 3,
                        'list' => json_encode($completedCases),
                        'message' => 'Could not be updated!!!'
                    ];
                    echo json_encode($json);
                    return;
                }
            }


            // var_dump($htmlStringUpload);
            // die;
            // replacing file case number to savable format
            $new_case_no = str_replace('/', "-", $case_no);
            $timestamp = date('mdYhis', time()).uniqid();

            // creating and saving the base64 format payment notice to uploads/paymentNotice folder
            $base_64_file_path = PAYMENT_NOTICE_PATH . $new_case_no.'_'.$timestamp. ".json";
            $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
            $htmlstring_text = json_encode(base64_encode($htmlStringUpload));
            fwrite($file_to_write_base64, $htmlstring_text);
            fclose($file_to_write_base64);
            $amount = $data['net_premium_payable'];
            $settlement_amount = $data['final_settlement_amount'];
            $reclass_amount = $data['final_reclass_amount'];
            $land_revenue_amount = $data['final_land_revenue_years'];
            $ins_cat_type_co = $insDetails->ins_cat_type_co;
            $remark_co = $remark;
            $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
            $case_user_case = $get_settlement_basic->co_code;
            // var_dump($noticeAlreadyGeneratedCheck->num_rows());die;
            if($this->session->userdata('user_desig_code') != 'CO')
            {
                $this->db->trans_rollback();
                log_message("error", '#ERRCAT9: Session data not found # '.$case_no);
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCAT9: Session data not found # '.$case_no,
                    'list' => json_encode($completedCases),
                ];
                echo json_encode($json);
                return;
            }

            $get_dag_details = $this->SettlementApModel->getSettlementDagDetails($case_no);
            $get_settlement_applicant = $this->SettlementApModel->getAllApplicant($case_no);
            $instituteDetails = $this->SettlementInsModel->getInstitutionDetails($case_no);
            $lmNote = $this->db->query("select * from settlement_ap_lmnote where case_no = ?",array($case_no))->row();

            // $district = $this->input->post('district');
            // $sub_division = $this->input->post('sub_division');
            // $circle = $this->input->post('circle');
            // $lot_no = $this->input->post('lot_no');
            // $mouza = $this->input->post('mouza');
            // $village = $this->input->post('village');




            // $petitioner_name = $this->input->post('petitioner_name');
            // $g_name = $this->input->post('g_name');
            // $dag_name = $this->input->post('dag_name');
            $payment_notice_gn_date = date('Y-m-d');
            // $data = [
            //    'case_no' => $case_no,
            //    'remark' => $remark,
            //    'get_settlement_basic' => $get_settlement_basic,
            //    'get_dag_details' => $get_dag_details,
            //    'get_settlement_applicant' => $get_settlement_applicant,
            // ];
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
                        'INS_NAME'      => $instituteDetails->ins_name_co,
                        'INS_ASS_NAME'  => $instituteDetails->ins_name_assamese,
                        'DEPARTMENT_NAME' => $instituteDetails->dept_of_co,
                        'DEPARTMENT_NAME_ASS' => $instituteDetails->dept_of_co_assamese,
                        'MINISTRY'      => $instituteDetails->ministry_of_co
                    ];
            }

            $controller = '';

            if($get_settlement_basic->service_code == SLIJE_ID)
            {
                $notice_no = "MB3/PN/" . date('Y') . "/SLIJE/" . $service_details->petition_no;
                $controller = 'SettlementInstitutionCo';
            }
            $ooa_oos = null;
            $task = 'Payment notice generated';
            if(NIJE_OFFER_OF_ALLOTMENT_SETTLEMENT == 1 && NIJE_OFFER_OF_ALLOTMENT_SETTLEMENT_DATE <= date('Y-m-d'))
            {
                $ooa_oos = 'YES';
                $task = 'OOA/OOS Generated';
            }
            

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
                'settlement_amount'=>$settlement_amount,
                'reclass_amount' => $reclass_amount,
                'land_revenue_amount' => $land_revenue_amount,
                'ins_cat_type_co' => $ins_cat_type_co,
                'offer_of_allot_settlement' => $ooa_oos
            ];
            $insertIntoSettlementNotice = $this->db->insert('settlement_notice', $insertIntoSettlementNotice);
            if ($insertIntoSettlementNotice != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRPN00678: Insertion failed in settlement_notice');
                $json = [
                    'responseType' => 3,
                    'list' => json_encode($completedCases),
                    'message' => 'Something went wrong'
                ];
                echo json_encode($json);
                return;
            }



            $insertIntoSettlementNoticeHistory = [
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
                'settlement_amount'=>$settlement_amount,
                'reclass_amount' => $reclass_amount,
                'land_revenue_amount' => $land_revenue_amount,
                'ins_cat_type_co' => $ins_cat_type_co,
                'offer_of_allot_settlement' => $ooa_oos
            ];
            $insertIntoSettlementNoticeHistory = $this->db->insert('settlement_notice_ins_history', $insertIntoSettlementNoticeHistory);
            if ($insertIntoSettlementNoticeHistory != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERRPN00678: Insertion failed in settlement_notice');
                $json = [
                        'responseType' => 3,
                        'list' => json_encode($completedCases),
                        'message' => 'Something went wrong2'
                    ];
                    echo json_encode($json);
                    return;
            }


            $landType = null;
            $chitha_processing_details = 0;
            if($instituteDetails->ins_cat_type_co == '12' && $lmNote->already_alloted == 'N')
            {
                $landType = '12_allotment';
                // $chitha_processing_details = 2;
            }
            else if($instituteDetails->ins_cat_type_co == '12' && $lmNote->already_alloted == 'Y')
            {
                // $this->session->set_flashdata('message', "#ERR2046: Session timeout! Please login and try again # ".$case_no);
                // redirect(base_url() . "index.php/home");
                $landType = '12_settlement';
                // $chitha_processing_details = 0;
            }
            else if(($instituteDetails->ins_cat_type_co == '10' || $instituteDetails->ins_cat_type_co == '11'))
            {
                // $this->session->set_flashdata('message', "#ERR2046: Session timeout! Please login and try again # ".$case_no);
                // redirect(base_url() . "index.php/home");
                $landType = '10_transfer';
                // $chitha_processing_details = 0;
            }
            else if(($instituteDetails->ins_cat_type_co == '9' && $lmNote->already_alloted == 'Y'))
            {
                // $this->session->set_flashdata('message', "#ERR2046: Session timeout! Please login and try again # ".$case_no);
                // redirect(base_url() . "index.php/home");
                $landType = '9_settlement';
                // $chitha_processing_details = 0;
            }
            else if(($instituteDetails->ins_cat_type_co == '9' && $lmNote->already_alloted == 'N'))
            {
                $landType = '9_allotment';
                // $chitha_processing_details = 2;
            }

            $updateArr = [
                'status' => 'N',
                'co_code' => $this->session->userdata('user_code'),
                'user_code' => $this->session->userdata('user_code'),
                'pay_notice_gen_yn' => 'Y',
                'date_update' => date('Y-m-d h:i:s'),
                'from_office' => 'CO',
                'pending_officer' => 'CO',
                'pending_office' => 'CO',
                'co_notice_link' => $base_64_file_path,
                'allotment_settlement_transfer' => $landType,
                'offer_of_allot_settlement' => $ooa_oos,
                'offer_of_allot_settlement_date' => date('Y-m-d'),
            ];
            $this->db->where('case_no', $case_no);
            $this->db->update('settlement_basic', $updateArr);
            // var_dump($this->db->affected_rows());die;
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

            // var_dump($noticeAlreadyGeneratedCheck->num_rows());die;
            //******check if CO aggreed with concession even after caste is general */
            $data['caste'] = $get_settlement_basic->caste;
            $applicants_buyers   = $this->SettlementInsModel->getAllApplicantBuyers($case_no);

            foreach($applicants_buyers as $applicant)
            {
                if($applicant->is_applicant == 1)
                {
                    $data['if_widow'] = $applicant->marital_status;
                }
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
                'task' => $task,
                'old_file_link' => $old_notice_link == false ? null:$old_notice_link,
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
                // var_dump($htmlStringUpload);die;
                // var_dump(base64_encode($htmlStringUpload));
                // die;
                $rtps_case_no = $get_settlement_basic->applid;

                /// check full pay
                $is_full_pay ='Y';
                // upload notice API
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, API_LINK_MB3 . "uploadNotice");
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(

                    'encoded_file'       => base64_encode($htmlStringUpload),
                    'application_no'     => $rtps_case_no,
                    'type'               => 'PN',
                    'amount'             => $amount,
                    'reclass_amount'     => $reclass_amount,
                    'land_revenue_years' => $land_revenue_amount,
                    'settlement_amount'  => $settlement_amount,
                    'ins_cat_type_co'    => $ins_cat_type_co,
                    'is_full_pay'        => $is_full_pay
                )));
                log_message('error','#OOA==='.$case_no.'==RTPS=='.$rtps_case_no."--TOTAL==".$amount."--RECLASS==".$reclass_amount."--REVENUE==".$land_revenue_amount."--SETTELEMEN==".$settlement_amount."--INSCAT==".$ins_cat_type_co."--".$is_full_pay);

                $result = curl_exec($curl_handle);
                log_message('error','#OOA==='.json_encode($result));
                if (trim($result) != 'y') {
                    $this->db->trans_rollback();
                    $json = [
                        'responseType' => 3,
                        'list' => json_encode($completedCases),
                        'message' => 'Something went wrong6'
                    ];
                    echo json_encode($json);
                    return;
                }
                else
                {
                    $this->db->trans_commit();
                    // $json = [
                    //     'responseType' => 2,
                    //     'list' => json_encode($completedCases),
                    //     'message' => 'Something went wrong7'
                    // ];
                    // echo json_encode($json);
                    // return;
                }
               
            }
            $completedCases[] = $case_no;
        }

        echo json_encode([
            'responseType' => 2,
            'message' => 'Offer of alloment/Settlement successfully generated for the selected cases...please go to Offer of Allotment & Settlement (Issued Cases) for printing',
            'list' => json_encode($completedCases),
        ]);

    }

    

    public function offerLetterIssued()
    {
        $service_code = $this->input->get('service');
        $status = $this->input->get('s');
        $data['getPaymentConfirmationCo'] = $this->SettlementInsModel->getPaymentConfirmationCo($service_code);
        $data['select_data'] = $this->SettlementInsModel->locationSelectIns($service_code, $status);
        $data['_view'] = 'settlement_mb/offerLetterIssued';
        $this->load->view('layouts/main', $data);
    }

    public function offerLetterListCases()
    {

        if(LOT_BIFURCATE == 1 && $this->session->userdata('user_desig_code') == 'CO'){
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

        $pagination = $this->input->post('pagination');


        $final_verification_report = $this->input->post('final_verification_report');
        $co_approved = $this->input->post('co_approved');

        $allotment_settlement = $this->input->post('allotment_settlement');

        $col = 0;
        $dir = "";
        $search = $this->input->post('search');
        $search = $search['value'];

        $searchByCol_0 = $this->input->post('columns')[1]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[2]['search']['value'];
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

        if(!empty($remark_cat))
        {  //settlement_ap_lmnote, lm_note
            $this->db->where('b.lm_note', $remark_cat);
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

        if (trim($reverted) == 'LM'){
            $this->db->where('a.pending_officer', MB_LOT_MONDOL);

        }
        else if (trim($reverted) == 'ADC'){
            $this->db->where_not_in('a.pending_officer',array(MB_LOT_MONDOL,MB_SUPERVISOR_KANANGU,MB_CIRCLE_OFFICER));
        }
        else{

            $this->db->where_in('a.pending_officer', array(MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU));
        }
        if ($this->session->userdata('user_desig_code') == 'CO'){
            // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
            if(LOT_BIFURCATE ==1 && empty($mouza_pargona_code) && empty($lot_no)){
                if(isset($lot_string) && $lot_string != null)
                {
                    $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                }
            }

            // $this->db->orWhere('a.co_code', null);
        }
        if ($this->session->userdata('user_desig_code') == 'SK') {
            $this->db->where('b.lm_note', '1');
            $this->db->where('a.from_office', 'LM');
        }

        if(trim($reverted) == 'LM' and $status =='V'){
            $this->db->select("distinct(a.case_no),a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, a.chitha_processing_details");
            $this->db->select('(select \'0\') as lm_note');
        }else{
            if($status == MB_PAYMENT_NOTICE)
            {
                $this->db->select('distinct(a.case_no), a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note, a.chitha_processing_details,sid.ins_cat_type_co');
            }
            else
            {
                $this->db->select('distinct(a.case_no), a.service_code, a.applid, a.dist_code, a.subdiv_code, a.cir_code, a.mouza_pargona_code, a.lot_no, a.vill_townprt_code, a.date_entry, b.lm_note, a.chitha_processing_details');
            }
        }
        //}

        if (trim($reverted) != 'ADC'){
            $this->db->where('a.status', $status);
        }
        $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
        $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

        // $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
        if(trim($reverted) == 'LM' and $status =='V'){
            $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no', 'left');
        }else{
            $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
        }

        if($s_code == 14 && ($status !='R' && $status !='X' && $status !='M' && $status !='N' && $status !='D'))
        {
            if (trim($reverted) != 'ADC'){
                if (($this->session->userdata('user_desig_code') == 'SK' and $status =='W') || trim($reverted) == 'LM' and $status =='V') {

                }
                else
                {
                    $this->db->where('a.notice_generated_yn', NULL);
                }
            }
        }
        $this->db->where('a.offer_of_allot_settlement', 'YES');
        $this->db->from('settlement_basic a');

        if($status == MB_PAYMENT_NOTICE)
        {
            $this->db->join('settlement_institution_details sid', 'a.case_no = sid.case_no');
            if(!empty($allotment_settlement))
            {
                if($allotment_settlement == '8')
                {
                    $this->db->where_in('sid.ins_cat_type_co', array('8'));
                }
                else if($allotment_settlement == '9')
                {
                    $this->db->where_in('sid.ins_cat_type_co', array('9'));
                }
                else if($allotment_settlement == '10')
                {
                    $this->db->where_in('sid.ins_cat_type_co', array('10'));
                }
                else if($allotment_settlement == '11')
                {
                    $this->db->where_in('sid.ins_cat_type_co', array('11'));
                }
                else if($allotment_settlement == '12')
                {
                    $this->db->where_in('sid.ins_cat_type_co', array('12'));
                }
            }
            else
            {
                $this->db->where_in('sid.ins_cat_type_co', array('8','9','10','11','12'));
            }
            

            $this->db->join('settlement_premium c', 'a.case_no = c.case_no');
            $this->db->where('c.is_final', 1);

            if(!empty($payment_status))
            {
                if(trim($payment_status) == 'paid')
                {
                    $this->db->where('c.grn_no is not null');
                }
                elseif(trim($payment_status) == 'unpaid')
                {
                    $this->db->where('c.grn_no is null');
                }
            }

            if(!empty($final_verification_report))
            {
                if($final_verification_report == 'Yes')
                {
                    $this->db->where_in('a.chitha_processing_details', array(1,2));
                }
                else if($final_verification_report == 'No')
                {
                    $this->db->where('a.chitha_processing_details', 0);
                }
                elseif(trim($final_verification_report) == 'land_class_issue'){
                    // $this->db->join('settlement_dag_details sd', 'sd.case_no = a.case_no');     
                    // $this->db->where("(sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = '' OR sd.new_land_class_agri = '')", NULL, FALSE); 
                    
                    $this->db->where('EXISTS (SELECT 1 FROM settlement_dag_details sd WHERE sd.case_no = a.case_no AND ((sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = \'\' OR sd.new_land_class_agri = \'\')))', NULL, FALSE);

                }
            }


            if(!empty($co_approved))
            {
                if($co_approved == 'Yes')
                {
                    $this->db->where('a.chitha_processing_details', 2);
                }
                else if($co_approved == 'No')
                {
                    $this->db->where_in('a.chitha_processing_details', array(1,0));
                }
            }
        }

        $query = $this->db->get();

        // echo $this->db->last_query();die;

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {

                

                $revialSql = $this->db->query('select * from settlement_revival_flag where case_no = ? and revival_status = ?', array($rows->case_no, 1));

                if($revialSql->num_rows() > 0)
                {
                    $revival_flg_button = '';
                }
                else
                {
                    $revival_flg_button = '<button type="button" onclick="caseRevivalList(\''.$rows->case_no.'\',\''.$rows->service_code.'\');" class="btn btn-sm btn-warning">Flag for Revival</button>';
                }

                $download_rejected_cases = '<br><a class="mt-2 btn btn-sm btn-dark" target= "RejectedCases" href="'.base_url().'index.php/SettlementCommon/downloadRejectedCases/?service='.$s_code.'">Download Reject Cases</a>';

                if(trim($rows->lm_note) == 1)
                {
                    $lmnoteRemark = 'Recommended';
                }
                else
                {
                    $lmnoteRemark = 'Not Recommended';
                }

                if ($status == MB_PAYMENT_NOTICE) {


                    if($rows->chitha_processing_details == 1)
                    {
                        $lm_chitha_report = 'Yes';
                    }
                    elseif($rows->chitha_processing_details == 2)
                    {
                        $lm_chitha_report = 'Yes';
                    }
                    elseif($rows->chitha_processing_details == 0)
                    {
                        $lm_chitha_report = 'No';
                    }


                    if($rows->chitha_processing_details == 2)
                    {
                        $co_approved_status = 'Yes';
                    }
                    elseif($rows->chitha_processing_details == 1)
                    {
                        $co_approved_status = 'No';
                    }
                    elseif($rows->chitha_processing_details == 0)
                    {
                        $co_approved_status = 'No';
                    }

               

                    $registrationCert = '';
                    $paymentNoticeLinkIns = '';
                    if($rows->ins_cat_type_co == '12')
                    {
                        $registrationCert = '<a alt="Print Notice" class="text-white btn btn-sm btn-success mt-1" target="registrationNotice" href="' . base_url() . 'index.php/SettlementInstitutionCo/printNoticeRegistration?case_no=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Registration Notice</a>';
                    }

                    if($rows->ins_cat_type_co != '8')
                    {
                        $paymentNoticeLinkIns = '<a alt="Print Notice" class="text-white btn btn-sm btn-warning mt-1" target="PaymentNotice" href="' . base_url() . 'index.php/SettlementCommon/printPaymentNotice?case=' . $rows->case_no . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> View Payment Notice</a>';
                    }

                    

                    

                    $khas_link = '<a alt="View application" class="text-white btn btn-sm btn-success" target="Application" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . enc_param('case', $rows->case_no, 600) . '"><i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>

                        <br>
                        '.$paymentNoticeLinkIns.'

                        <br>
                        '.$registrationCert;

                    

                    
                } 
               
                

                if($status == MB_PAYMENT_NOTICE)
                {
                    $insCategory = '';
                    if($rows->ins_cat_type_co == '8')
                    {
                        $insCategory = "<span style='color:#0cc10c;font-weight:bold'>State govt.</span>";
                    }
                    else if($rows->ins_cat_type_co == '9')
                    {
                        $insCategory = "<span style='color:#242472;font-weight:bold'>State govt Undertakings</span>";
                    }
                    else if($rows->ins_cat_type_co == '10')
                    {
                        $insCategory = "<span style='color:#ffb81d;font-weight:bold'>Central govt</span>";
                    }
                    else if($rows->ins_cat_type_co == '11')
                    {
                        $insCategory = "<span style='color:#ff681d;font-weight:bold'>Central govt Undertakings</span>";
                    }
                    else if($rows->ins_cat_type_co == '12')
                    {
                        $insCategory = "<span style='color:#9d2b2b;font-weight:bold'>Non Govt.(Education/Socio/Religious)</span>";
                    }
                    $sqlgrn = $this->db->query('select * from settlement_premium where case_no = ? and is_final = ?', array($rows->case_no, 1));

                    if($sqlgrn->num_rows() <= 0)
                    {
                        $grn_status = '<strong class="text-danger">NOT PAID</strong>';
                    }
                    else
                    {
                        if(isset($sqlgrn->row()->grn_no))
                        {
                            if($sqlgrn->row()->grn_no == null || $sqlgrn->row()->grn_no == '')
                            {
                                $grn_status = '<strong class="text-danger">NOT PAID</strong>';
                            }
                            else
                            {
                                $grn_status = '<strong class="text-success">PAID</strong>';
                            }
                        }
                        else
                        {
                            $grn_status = '<strong class="text-danger">NOT PAID</strong>';
                        }
                    }
                    $ruralYesNo= "---";
                    $json[] = array(
                        $rows->case_no,
                        '<span style= font-size:14px;><strong>' . $rows->case_no . '</strong></span>',
                        '<span style= font-size:14px;><strong>' . $rows->applid . '</strong></span>',

                        $this->utilityclass->getMouzaName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code),

                        $this->utilityclass->getLotName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no),

                        $this->utilityclass->getVillageName($rows->dist_code, $rows->subdiv_code, $rows->cir_code, $rows->mouza_pargona_code, $rows->lot_no, $rows->vill_townprt_code),

                        // $nr_status,

                        // $rows->date_entry,
                        // date("Y-m-d", strtotime($rows->date_entry)),

                        // $lmnoteRemark,

                        $grn_status,
                        $lm_chitha_report,
                        $co_approved_status,
                        $insCategory,
                        $khas_link,
                    );
                }

            }

            $this->db->where('a.service_code', $s_code);
            $this->db->where('a.offer_of_allot_settlement', 'YES');
            if(!empty($remark_cat))
            {  //settlement_ap_lmnote, lm_note
                $this->db->where('b.lm_note', $remark_cat);
            }

            if (trim($reverted) == 'LM'){
                $this->db->where('a.pending_officer', MB_LOT_MONDOL);

            }
            else if (trim($reverted) == 'ADC'){
                $this->db->where_not_in('a.pending_officer',array(MB_LOT_MONDOL,MB_SUPERVISOR_KANANGU,MB_CIRCLE_OFFICER));
            }
            else{


                // if ($this->session->userdata('user_desig_code') == 'SK')
                // {
                //     $this->db->where('a.pending_officer', MB_SUPERVISOR_KANANGU);
                // }
                // else
                // {
                //     $this->db->where_in('a.pending_officer', array(MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU));
                //     // $this->db->or_where('pending_officer', MB_SUPERVISOR_KANANGU);
                // }
                $this->db->where_in('a.pending_officer', array(MB_CIRCLE_OFFICER, MB_SUPERVISOR_KANANGU));
            }

            if ($this->session->userdata('user_desig_code') == 'CO'){
                // $this->db->where('a.co_code', $user_code);
                // $this->db->where("(a.co_code = '".$user_code."' or a.co_code is null)");
                if(LOT_BIFURCATE ==1 && empty($mouza_pargona_code) && empty($lot_no)){

                    if(isset($lot_string) && $lot_string != null)
                    {
                        $this->db->where("a.mouza_pargona_code ||'_' || a.lot_no in ($lot_string)");
                    }
                }
            }

            if ($this->session->userdata('user_desig_code') == 'SK') {
                $this->db->where('b.lm_note', '1');
                $this->db->where('a.from_office', 'LM');
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

            


            if(trim($reverted) == 'LM' and $status =='V'){
                $this->db->select('distinct(a.case_no)');
                $this->db->select('(select \'0\') as lm_note');
            }else{
                $this->db->select('distinct(a.case_no)');
            }

            //}


            if (trim($reverted) != 'ADC'){
                $this->db->where('a.status', $status);
            }
            $this->db->where('a.dist_code', $this->session->userdata('dist_code'));
            $this->db->where('a.subdiv_code', $this->session->userdata('subdiv_code'));
            $this->db->where('a.cir_code', $this->session->userdata('cir_code'));

            // $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
            if(trim($reverted) == 'LM' and $status =='V'){
                $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no', 'left');
            }else{
                $this->db->join('settlement_ap_lmnote b', 'a.case_no = b.case_no');
            }

            if($s_code == 14 && ($status !='R' && $status !='X' && $status !='M' && $status !='N' && $status !='D'))
            {
                if (trim($reverted) != 'ADC'){
                    if (($this->session->userdata('user_desig_code') == 'SK' and $status =='W') || trim($reverted) == 'LM' and $status =='V') {

                    }

                    else{
                        $this->db->where('a.notice_generated_yn', NULL);
                    }
                }
            }

            if($status == MB_PAYMENT_NOTICE)
            {
                $this->db->join('settlement_institution_details sid', 'a.case_no = sid.case_no');
                // $this->db->where_in('sid.ins_cat_type_co', array('8','9','10','11','12'));
                if(!empty($allotment_settlement))
                {
                    if($allotment_settlement == '8')
                    {
                        $this->db->where_in('sid.ins_cat_type_co', array('8'));
                    }
                    else if($allotment_settlement == '9')
                    {
                        $this->db->where_in('sid.ins_cat_type_co', array('9'));
                    }
                    else if($allotment_settlement == '10')
                    {
                        $this->db->where_in('sid.ins_cat_type_co', array('10'));
                    }
                    else if($allotment_settlement == '11')
                    {
                        $this->db->where_in('sid.ins_cat_type_co', array('11'));
                    }
                    else if($allotment_settlement == '12')
                    {
                        $this->db->where_in('sid.ins_cat_type_co', array('12'));
                    }
                }
                else
                {
                    $this->db->where_in('sid.ins_cat_type_co', array('8','9','10','11','12'));
                }
                $this->db->join('settlement_premium c', 'a.case_no = c.case_no');
                $this->db->where('c.is_final', 1);

                if(!empty($payment_status))
                {
                    if(trim($payment_status) == 'paid')
                    {
                        $this->db->where('c.grn_no is not null');
                    }
                    elseif(trim($payment_status) == 'unpaid')
                    {
                        $this->db->where('c.grn_no is null');
                    }
                    
                }


                if(!empty($final_verification_report))
                {
                    if($final_verification_report == 'Yes')
                    {
                        $this->db->where_in('a.chitha_processing_details', array(1,2));
                    }
                    else if($final_verification_report == 'No')
                    {
                        $this->db->where('a.chitha_processing_details', 0);
                    }
                    elseif(trim($final_verification_report) == 'land_class_issue'){
                        // $this->db->join('settlement_dag_details sd', 'sd.case_no = a.case_no');     
                        // $this->db->where("(sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = '' OR sd.new_land_class_agri = '')", NULL, FALSE); 
                        $this->db->where('EXISTS (SELECT 1 FROM settlement_dag_details sd WHERE sd.case_no = a.case_no AND ((sd.home_b + sd.home_k + sd.home_lc + sd.home_g) > 0 AND (sd.agri_b + sd.agri_k + sd.agri_lc + sd.agri_g) > 0 AND (sd.new_land_class_home = \'\' OR sd.new_land_class_agri = \'\')))', NULL, FALSE);

                    }
                }


                if(!empty($co_approved))
                {
                    if($co_approved == 'Yes')
                    {
                        $this->db->where('a.chitha_processing_details', 2);
                    }
                    else if($co_approved == 'No')
                    {
                        $this->db->where_in('a.chitha_processing_details', array(1,0));
                    }
                }
            }



            // $total_records = $this->db->count_all_results('settlement_basic a');
            $data=$this->db->get('settlement_basic a');
            $total_records = $data->num_rows();
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

    public function bulkPrintPaymentNoticeInstitution()
    {
        // generate print offer letter starts here
        $markedApplications = $this->input->post('selectMark');
        if (count($markedApplications) == 0) {
            $json = [
                'responseType' => 3,
                'message' => '#ERROOACO098001: Kindly choose case no...',
            ];
            echo json_encode($json);
            return;
        }

        if (count($markedApplications) > 10) {
            log_message("error", '#ERRCO09876: Failed to generate notice. Selection Limit 10 Only');
            $json = [
                'responseType' => 3,
                'message' => '#ERROOACO09876: Failed to generate notice. Selection Limit 10 Only',
            ];
            echo json_encode($json);
            return;
        }

        $completedCases = array();
        foreach ($markedApplications as $key => $value) 
        {
            $sql = $this->db->query('select * from settlement_notice where case_no = ? and notice_type = ? order by id desc limit 1', [$value, 'PN']);
            if ($sql->num_rows() <= 0) {
                $base64decoded_notice_file = false;
            } else 
            {
                $row = $sql->row();
                $path = $this->SettlementCommonModel->downloadNotice($row->notice_link);
                if ($path == false) {
                    echo 'No data found!';
                    return;
                }

                $open_notice_file = fopen($path, "r") or die("Unable to open file!");
                $read_notice_file = fread($open_notice_file, filesize($path));
                fclose($open_notice_file);
                // decoding the base64 encoding file variable
                $completedCases[]= "<div style='page-break-before: always;'></div>".base64_decode(json_decode($read_notice_file));
            }
        }
        echo json_encode([
            'responseType' => 2,
            'list' => json_encode($completedCases),
        ]);

    }

    public function registrationData()
    {
        if(isset($_GET['case'])){
            $_GET['case'] = dec_param($this->input->get('case'), 'case');
            if($_GET['case'] == null)
            {
                echo json_encode('Sorry !! You are not Authorized to access the content!!');
                return;
            }
            $case_no = $_GET['case'];
            $case_under_wetland = $this->SettlementCommonModel->caseUnderDeptOrDCByWetLand($case_no);

            $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);

            
            

            $premium_data = $this->db->query("SELECT * from settlement_premium where case_no='$case_no' and is_final=1")->result();
            $data['premium_data'] = $premium_data;

            $data['basic'] = $this->SettlementApModel->getSettlementBasicCo($case_no);
            $data['dags'] = $this->db->query("select sd.*,sr.bigha,sr.katha,sr.lessa,sr.ganda,sr.is_deleted,sp.total_lessa from settlement_dag_details sd 
            left join (select * from settlement_reservation where is_deleted=0) sr 
            on sd.case_no = sr.case_no and sr.dag_no = sd.dag_no
            join (select total_lessa,case_no,dag_no from settlement_premium where is_final=1) sp on sp.case_no=sd.case_no and sp.dag_no=sd.dag_no 
            where sd.case_no='$case_no'")->result();

            //*******general caste or reserve caste check */

            // $data['caste'] = $get_settlement_basic->caste;
            $data['applid'] = $get_settlement_basic->applid;

            $applicants_buyers   = $this->SettlementInsModel->getAllApplicantBuyers($case_no);

            foreach($applicants_buyers as $applicant)
            {
                if($applicant->is_applicant == 1)
                {
                    $data['if_widow'] = $applicant->marital_status;
                }
            }



            $data['concessionCheck'] = false;
            $concenSql = $this->db->query('select concession from settlement_premium where case_no = ? and is_final = ? limit 1', array($case_no, 1));


            $sql = $this->db->query('select sid.*,imc.category_name from settlement_institution_details sid join ins_master_category imc on sid.ins_cat_type::int = imc.id  where case_no = ?', array($case_no));

            $data['ins_data'] = $sql->result();
            $data['instituteDetails'] = $this->SettlementInsModel->getInstitutionDetails($case_no);
            $data['old_dag_flag_message'] = false;
            $data['land_class_groups'] = $this->SettlementInsModel->getLandGroups();

            $apLmnoteDetails = $this->db->query('select * from settlement_ap_lmnote where case_no = ? order by id desc limit 1', array($case_no))->row();
            $data['apLmnoteDetails'] = $apLmnoteDetails;

            $registration_document = $this->db->query("Select * from supportive_document where case_no='$case_no' and file_name='Registrationdocument'")->row();
            $data['registration_document'] = $registration_document;
            // var_dump($data['registration_document']);
            // die;

            if($this->session->userdata('user_desig_code') != 'CO')
            {
                log_message('error', '#ERROR99003987656: Undefined User... '. $case_no);
               
                $this->session->set_flashdata('message',"#ERR6776 : User not Authenticated !!!");
                redirect(base_url() . 'index.php/home/index');
            }
            $data['_view'] = 'SettlementView/Co/Ins/registration_info_page';
            $this->load->view('layouts/main', $data);
        }

    }

    public function saveRegistrationData()
    {
        $case_no = $this->input->post('case_no');
        $remark = $this->input->post('remark_co');
        $insCatTypeCo = $this->input->post('ins_cat_type');
        $applicant_buyer = $this->SettlementInsModel->getAllApplicantBuyers($case_no);
        $get_settlement_basic = $this->SettlementApModel->getSettlementBasicCo($case_no);
        $insDetails = $this->SettlementInsModel->getInstitutionDetails($case_no);
        $apLmnoteDetails = $this->db->query('select * from settlement_ap_lmnote where case_no = ? order by id desc limit 1', array($case_no))->row();
        $data['instituteDetails'] = $insDetails;

        $registrationData = $this->db->query("Select * from supportive_document where case_no='$case_no' and file_name='Registrationdocument'")->row();

        if($insDetails->ins_cat_type_co != $insCatTypeCo)
        {
            $this->session->set_flashdata('message', "#NOTE10001INFO: Unable to process due to category mis match request active # ".$case_no);
            redirect(base_url() . "index.php/home");
            return;
        }
        if($insDetails->ins_cat_type_co != '12')
        {
            $this->session->set_flashdata('message', "#NOTE10001INFO1: Unable to process due to category mis match request active # ".$case_no);
            redirect(base_url() . "index.php/home");
            return;
        }

        $co_operative_registered = $this->input->post('co_operative_registered');
        $registration_no = $this->input->post('registration_no');
        $registration_date = $this->input->post('registration_date');
        $registration_date = date('Y-m-d', strtotime($registration_date));
        $registration_document = $_FILES['registration_document']['name'];
        
        if (!$this->isRegistrationDataValid($co_operative_registered, $registration_no, $registration_date,$registration_document,$case_no)) {
            $this->session->set_flashdata('message', "#ERR-REGISTRATION0921INFO: Invalid or missing registration information for case # {$case_no}");
            redirect(base_url("index.php/home"));
            return;
        }

        /////////$regFileInsertFlag-THIS FLAG IS USE FOR GENERATING NOTICE WITHOUT REGISTRATION FROM THE 19-09-2025
        
            ////////////uploading registration details////////////
        $this->db->trans_begin();
        $registration_document_file = $_FILES['registration_document'];
        $timestamp = date('mdYhis', time()).uniqid();        
        $registration_file_name = 'field_report'.$timestamp;          
        $newFileNameFieldReport = preg_replace('/\s+/', '_', $registration_document_file['name']);
        $registration_doc_path = UPLOAD_DIR.$timestamp.$newFileNameFieldReport;
        $document= array(
            'case_no'         => $case_no,
            'file_name'       => 'Registrationdocument',
            'user_code'       => $this->session->userdata('user_code'),
            'fetch_file_name' => $registration_document_file['name'],
            'file_type'       => $registration_document_file['type'],
            'file_path'       => $registration_doc_path,
            'date_entry'      => date('Y-m-d h:i:s'),
            'mut_type'        => SLIJE_ID,
            'api_doc_id'      => null,
        );

        $insert_supportive_doc= $this->db->insert('supportive_document', $document);
        if ($insert_supportive_doc != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERRORREGPAY7152INFO: Insertion failed in supportive_document for case no :'. $case_no);
            $json = [
                'errorMessage'=>"#ERRORREGPAY7152INFO: Failed to upload document case for Case No : ".$case_no
            ];
            echo json_encode($json);
            return false;
        }
        $config2['file_name']     = $registration_file_name;
        $config2['upload_path']   = UPLOAD_DIR;
        $config2['allowed_types'] = UPLOAD_ALLOW_TYPE;
        $config2['max_size']      = 2000;

        $this->load->library('upload', $config2);
        $this->upload->initialize($config2);

        if(!move_uploaded_file($registration_document_file['tmp_name'], $registration_doc_path)){
            log_message('error', 'Unable to move field report file for case no '.$case_no);
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', "#ERRADDDOC000331INFO: Only PDF and Image files area allowed : ".$application_no);
            redirect(base_url() . "index.php/home");
        }
        
        $updateRegAr = [
            'co_operative_registered' => $co_operative_registered,
            'registration_no' => $registration_no,
            'registration_date' => $registration_date,
            // 'registration_acknowledge' => $registration_acknowledge,
        ];
        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_ap_lmnote', $updateRegAr);
        if ($this->db->affected_rows() != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERR7136: Updation Failed in settlement_ap_lmnote table');
            $this->session->set_flashdata('message', "#ERR7136INFO Registration information could not be save...");
            redirect(base_url() . "index.php/home");
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
            'note_on_order' => 'Registration information entered by CO',
            'status' => 'N',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d h:i:s'),
            'operation' => 'E',
            'ip' => $this->utilityclass->get_client_ip(),
            'office_from' => 'CO',
            'office_to' => 'CO',
            'task' => 'Registration information verified',
            'old_file_link' =>null,
        ];
        $insertProc = $this->db->insert('settlement_proceeding', $insertArr);
        if ($insertProc != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERRNOPNINSN0002INFO: Insertion failed in settlement_proceeding');
            $this->session->set_flashdata('message', "#ERR7136INFO Registration information could not be save...");
            redirect(base_url() . "index.php/home");
            return false;
        }


        $this->db->trans_commit();
        $this->session->set_flashdata('message', "#Registration information successfully saved...");
        redirect(base_url() . "index.php/home");
        
    }




}