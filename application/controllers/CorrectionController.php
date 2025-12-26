<?php
defined('BASEPATH') or exit('No direct script access allowed');
class CorrectionController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('CorrectionModel');
        $this->load->model('mutation/mutationmodel');
        $this->load->helper(array('form', 'url', 'Language'));
        $this->load->library('form_validation');
        $this->load->model('rtps/rtpsmodel');
    }
    public function index()
    {
        $data = $this->mutationmodel->getDistricts();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $villages = $this->mutationmodel->getMouzaJSON($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no);
        $district['relation'] = $this->CorrectionModel->getMasterRelation();
        $district['caste'] = $this->CorrectionModel->getCaste();
        $district['gender'] = $this->CorrectionModel->getGender();
        $district['d'] = $dist_code;
        $district['s'] = $subdiv_code;
        $district['c'] = $cir_code;
        $district['m'] = $mouza_code;
        $district['l'] = $lot_no;
        $district['village'] = $villages;

        $district['user'] = $this->rtpsmodel->usersForOfficeMisc($dist_code, $subdiv_code, $cir_code);

        $patta_types = $this->db->query("select type_code,patta_type from    patta_code where jamabandi='y'")->result();
        $district['patta_types'] = $patta_types;
        $district['districts'] = $this->CorrectionModel->getDistricts();
        $district['_view'] = 'ldu_name/lra_entry_form';
        $this->load->view('layouts/main', $district);
    }
    public function getPattaDetails()
    {
        $patta_no = $this->input->post('patta_no');
        $patta_type = $this->input->post('patta_type');
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $mouza_code = $this->input->post('mouza_code');
        $lot_no = $this->input->post('lot_no');
        $village_code = $this->input->post('village_code');

        $data = $this->CorrectionModel->getPattaDetails($patta_type, $patta_no, $dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $village_code);

        if ($data) {
            echo json_encode(['status' => 'success', 'data' => $data]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Patta not found!']);
        }
    }
    /////////////////////////////////
    public function listCorrections($page = 0)
    {
        $this->load->library('pagination');

        $config['base_url'] = base_url('CorrectionController/listCorrections');
        $config['total_rows'] = $this->db->count_all('jama_pattadar_corrections');
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;
        $config['num_links'] = 5;
        $this->pagination->initialize($config);
        $this->db->limit($config['per_page'], $page);
        $query = $this->db->get('jama_pattadar_corrections');
        $data['corrections'] = $query->result();
        $data['pagination'] = $this->pagination->create_links();
        if ($this->input->is_ajax_request()) {
            echo json_encode($data);
        } else {
            $district['_view'] = 'ldu_name/correction_list';
            $this->load->view('layouts/main', $district);
        }
    }
    //////////////////////
    private function logAction($correction_id, $action, $remarks = '', $case_no = null)
    {
        $log_data = [
            'correction_id' => $correction_id,
            'action'        => $action,
            'performed_by'  => $this->session->userdata('user_code'),
            'remarks'       => $remarks,
            'case_no'       => $case_no
        ];
        $ins_status = $this->db->insert('correction_logs', $log_data);
        if ($ins_status == false || $ins_status === false) {
            return false;
        }
        return true;
    }

    public function reviewCorrection($id)
    {
        $status = $this->input->post('status');
        $remarks = $this->input->post('remarks');

        $this->db->where('id', $id);
        $this->db->update('jama_pattadar_corrections', [
            'status' => $status,
            'reviewed_by' => $this->session->userdata('user_id'),
            'updated_at' => date('Y-m-d H:i:s'),
            'remarks' => $remarks
        ]);
        $this->logAction($id, "Reviewed - $status", $remarks);
        echo json_encode(['status' => 'success', 'message' => 'Correction reviewed successfully!']);
    }

    public function submitCorrection()
    {
        $this->load->library('upload');
        // $config['upload_path']   = './uploads/NEWNAMEMIDIFY/';
        $config['upload_path']   = UPLOAD_GUARD_NAME_CC .'/';
        $config['allowed_types'] = 'jpg|png|pdf';
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('attachment')) {
            echo json_encode(['status' => 'error', 'message' => $this->upload->display_errors()]);
            return;
        }
        $fileData = $this->upload->data();

        $co_code = $this->input->post('official');

        if ($co_code == null or $co_code == '') {
            echo json_encode(['status' => 'false', 'message' => 'Select assigning circle officr!']);
            return;
        }

        $lra_remarks = $this->input->post('lra_remark');

        if ($lra_remarks == null or $lra_remarks == '') {
            echo json_encode(['status' => 'false', 'message' => 'Remark is missing !']);
            return;
        }

        $status = 'Pending';
        if (ENABLE_NGCOR_REL != 0) {
            $relation = $this->input->post('relation');
            $gender = $this->input->post('gender');
            $caste = $this->input->post('caste');
            $dob = $this->input->post('dob');
        } else {
            $relation = null;
            $gender = null;
            $caste = null;
            $dob = null;
        }


        $this->db->trans_begin();

        $case_name = $this->rtpsmodel->genearteCaseName();
        if (empty($case_name)) {
            $this->db->trans_rollback();
            //ERRRTPSNMECORRAST0010
            log_message('error', 'Network Issue or Session Out. Please try Again. Error: ERRRTPSNMECORRAST0010');
            $response = array(
                'responseType' => 1,
                'msg' => 'Network Issue or Session Out. Please try Again',
                'errorCode' => 'ERRRTPSNMECORRAST0010',
                'data' => array(
                    'redirectUrl' => ''
                )
            );
            echo json_encode($response);
            exit;
        }

        $seq_pet = year_no . '00';
        $petition_no = $seq_pet . $this->rtpsmodel->generateNGCorrectionPetitionNo();
        $case_no = $case_name . $petition_no . "/NG";




        $data = [
            'dist_code'        => $this->input->post('dist_code'),
            'subdiv_code'      => $this->input->post('subdiv_code'),
            'cir_code'         => $this->input->post('circle_code'),
            'mouza_pargona_code' => $this->input->post('mouza_code'),
            'lot_no'           => $this->input->post('lot_no'),
            'vill_townprt_code' => $this->input->post('vill_code'),
            'patta_type_code'  => $this->input->post('patta_type_code'),
            'patta_no'         => $this->input->post('patta_no'),
            'pdar_id'          => $this->input->post('old_pdar_name_select'),
            'old_pdar_name'    => $this->input->post('exist_pdar_name'),
            'old_pdar_father'  => $this->input->post('exist_pdar_father_name'),
            'new_pdar_name'    => $this->input->post('new_pdar_name'),
            'new_pdar_father'  => $this->input->post('new_pdar_father_name'),
            'attachment'       => $fileData['file_name'],
            'submitted_by'     => $this->session->userdata('user_code'),
            'case_no'          => $case_no,
            'status'           => 'Pending',
            'lra_remarks'      => $lra_remarks,
            'pending_with_officer' => 'CO',
            'pending_status'   => 'C',
            'co_code'          => $co_code,
            'created_at'       => date('Y-m-d H:i:s'),
            'relation'         => $relation,
            'gender'           => $gender,
            'dob'              => $dob,
            'caste'            => $caste,
            'old_relation'     => $relation,
            'old_gender'       => $gender,
            'old_dob'          => $dob,
            'old_caste'        => $caste
        ];
        $ins_status = $this->db->insert('jama_pattadar_corrections', $data);
        if ($ins_status == false || $ins_status === false) {
            log_message('error', "#NGCORO001:" . $this->db->last_query());
            $this->db->trans_rollback();
            echo json_encode(['status' => 'false', 'message' => 'Registration failed !']);
            return false;
        } else {
            $sequence_name = "jama_pattadar_corrections_id_seq"; // Usually "tablename_columnname_seq"
            $query = $this->db->query("SELECT currval('$sequence_name') AS id");
            $id = $query->row()->id;
            $log_status = $this->logAction($id, "Reviewed - $status", $lra_remarks, $case_no);
            if ($log_status == false || $log_status === false) {
                log_message('error', "#NGCORO002:" . $this->db->last_query());
                $this->db->trans_rollback();
                echo json_encode(['status' => 'false', 'message' => 'Registration failed !']);
                return false;
            }

            $this->db->trans_commit();
        }
        echo json_encode(['status' => 'success', 'message' => 'Correction request submitted successfully!', 'redirect_url' => base_url() . 'index.php/CorrectionController/index']);
    }

    public function listCOCorrections()
    {
        $user_code     = $this->session->userdata('user_code');
        $status_filter = $this->input->get('status');
        $page          = (int) $this->input->get('page'); // page offset for pagination

        $this->load->library('pagination');

        // ===== PAGINATION CONFIG =====
        $config['base_url']             = base_url() . '/index.php/CorrectionController/listCOCorrections' . '?status=' . urlencode($status_filter);
        $config['per_page']              = 5;
        $config['page_query_string']     = TRUE;
        $config['query_string_segment']  = 'page';

        // ===== COUNT TOTAL ROWS =====
        $this->db->where('co_code', $user_code);
        if (!empty($status_filter)) {
            $this->db->where('status', $status_filter);
        }
        $config['total_rows'] = $this->db->count_all_results('jama_pattadar_corrections');

        // ===== PAGINATION HTML =====
        $config['full_tag_open']   = '<ul class="tsc_pagination tsc_paginationA tsc_paginationA01">';
        $config['full_tag_close']  = '</ul>';
        $config['prev_link']       = '&lt;';
        $config['prev_tag_open']   = '<li>';
        $config['prev_tag_close']  = '</li>';
        $config['next_link']       = '&gt;';
        $config['next_tag_open']   = '<li>';
        $config['next_tag_close']  = '</li>';
        $config['cur_tag_open']    = '<li class="current"><a href="#">';
        $config['cur_tag_close']   = '</a></li>';
        $config['num_tag_open']    = '<li>';
        $config['num_tag_close']   = '</li>';
        $config['first_tag_open']  = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open']   = '<li>';
        $config['last_tag_close']  = '</li>';
        $config['first_link']      = '&lt;&lt;';
        $config['last_link']       = '&gt;&gt;';

        // ===== INIT PAGINATION =====
        $this->pagination->initialize($config);

        // ===== FETCH PAGINATED DATA =====
        $this->db->where('co_code', $user_code);
        if (!empty($status_filter)) {
            $this->db->where('status', $status_filter);
        }
        $this->db->limit($config['per_page'], $page);
        $query = $this->db->get('jama_pattadar_corrections');

        $data['corrections'] = $query->result();
        $data['pagination']  = $this->pagination->create_links();

        $data['_view'] = 'ldu_name/correction_list_co';
        $this->load->view('layouts/main', $data);
    }









    public function viewCaseDetailsbyId($id)
    {
        $id = base64_decode(urldecode($id));

        $sql = $this->db->query("select * from jama_pattadar_corrections where id=?", array($id))->row();

        $data['data'] = $details = $sql;

        $user_desig_code = $this->session->userdata('user_desig_code');

        $data['adc'] = $this->db->query("Select users.username as username, users.user_desig_code as user_desig_code, loginuser_table.user_code as user_code from    users, "
            . "loginuser_table where users.dist_code = loginuser_table.dist_code and users.user_code = loginuser_table.user_code and users.user_desig_code like 'ADC%' and "
            . "loginuser_table.dist_code='$details->dist_code' and loginuser_table.subdiv_code='00' and loginuser_table.cir_code='00' and loginuser_table.dis_enb_option = 'E' and loginuser_table.priv = 'adm'")->result();

        if ($user_desig_code == 'CO') {
            $data['_view'] = 'ldu_name/co_view_form';
            $this->load->view('layouts/main', $data);
        }

        if ($user_desig_code == 'ADC') {
            $data['_view'] = 'ldu_name/adc_view_form';
            $this->load->view('layouts/main', $data);
        }
    }


    public function updateCoCorrection()
    {
        $co_remark = $this->input->post('co_remark');
        $status = 'Forwarded';
        $case_no = $this->input->post('case_no');
        $id = $this->input->post('id');
        $adc_code = $this->input->post('adc_code');

        $this->db->trans_begin();

        if ($co_remark == null or $co_remark == '') {
            echo json_encode(['status' => 'false', 'message' => 'CO remark is mandatory!']);
            return;
        }

        if ($adc_code == null or $adc_code == '') {
            echo json_encode(['status' => 'false', 'message' => 'Selection of ADC is mandatory!']);
            return;
        } else {
            $this->db->where('id', $id);
            $this->db->where('case_no', $case_no);
            $this->db->update('jama_pattadar_corrections', [
                'reviewed_by' => $this->session->userdata('user_code'),
                'updated_at' => date('Y-m-d H:i:s'),
                'co_remarks' => $co_remark,
                'pending_with_officer' => 'ADC',
                'pending_status'   => 'A',
                'adc_code'         => $adc_code,
                'status'           => $status
            ]);

            $log_status = $this->logAction($id, "Reviewed - $status", $co_remark, $case_no);

            if ($log_status == false || $log_status === false) {
                log_message('error', "#NGCORO002:" . $this->db->last_query());
                $this->db->trans_rollback();
                echo json_encode(['status' => 'false', 'message' => 'Registration failed !']);
                return false;
            }

            $this->db->trans_commit();

            echo json_encode(['status' => 'success', 'message' => 'Correction reviewed successfully!', 'redirect_url' => base_url() . 'index.php/CorrectionController/listCOCorrections']);
        }
    }

    public function listADCCorrections($page = 0)
    {
        $user_code     = $this->session->userdata('user_code');
        $status_filter = $this->input->get('status');
        $page          = (int) $this->input->get('page'); // page offset for pagination

        $this->load->library('pagination');

        // ===== PAGINATION CONFIG =====
        $config['base_url']             = base_url() . '/index.php/CorrectionController/listADCCorrections' . '?status=' . urlencode($status_filter);
        
        $config['per_page']              = 50;
        $config['page_query_string']     = TRUE;
        $config['query_string_segment']  = 'page';

        // Add status filter to pagination links
        // if (!empty($status_filter)) {
        //     $config['suffix']    = '&status=' . urlencode($status_filter);
        //     $config['first_url'] = $config['base_url'] . '?page=0&status=' . urlencode($status_filter);
        // }

        // ===== COUNT TOTAL ROWS =====
        // $this->db->where('co_code', $user_code);
        // if (!empty($status_filter)) {
        //     $this->db->where('status', $status_filter);
        // }
        $this->db->where('pending_with_officer', 'ADC');
        $this->db->where('pending_status', 'A');
        $this->db->where('adc_code', $user_code);
        if (!empty($status_filter)) {
            $this->db->where('status', $status_filter);
        }
        $config['total_rows'] = $this->db->count_all_results('jama_pattadar_corrections');

        // ===== PAGINATION HTML =====
        $config['full_tag_open']   = '<ul class="tsc_pagination tsc_paginationA tsc_paginationA01">';
        $config['full_tag_close']  = '</ul>';
        $config['prev_link']       = '&lt;';
        $config['prev_tag_open']   = '<li>';
        $config['prev_tag_close']  = '</li>';
        $config['next_link']       = '&gt;';
        $config['next_tag_open']   = '<li>';
        $config['next_tag_close']  = '</li>';
        $config['cur_tag_open']    = '<li class="current"><a href="#">';
        $config['cur_tag_close']   = '</a></li>';
        $config['num_tag_open']    = '<li>';
        $config['num_tag_close']   = '</li>';
        $config['first_tag_open']  = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open']   = '<li>';
        $config['last_tag_close']  = '</li>';
        $config['first_link']      = '&lt;&lt;';
        $config['last_link']       = '&gt;&gt;';

        // ===== INIT PAGINATION =====
        $this->pagination->initialize($config);
        // if($status_filter=="Pending"){
        //     $status_filter="Forwarded";
        // }

        // ===== FETCH PAGINATED DATA =====
        $this->db->where('pending_with_officer', 'ADC');
        $this->db->where('pending_status', 'A');
        $this->db->where('adc_code', $user_code);
        if (!empty($status_filter)) {
            $this->db->where('status', $status_filter);
        }
        $this->db->order_by('id');
        $this->db->limit($config['per_page'], $page);
        $query = $this->db->get('jama_pattadar_corrections');

        $data['corrections'] = $query->result();//var_dump($data['corrections']);die;
        $data['pagination']  = $this->pagination->create_links();

        $data['_view'] = 'ldu_name/correction_list_co';
        $this->load->view('layouts/main', $data);
    }

    public function updateADCCorrection()
    {
        $adc_remark = $this->input->post('adc_remark');
        $status = 'Delivered';
        $case_no = $this->input->post('case_no');
        $id = $this->input->post('id');
        $this->db->trans_begin();
        if ($adc_remark == null or $adc_remark == '') {
            echo json_encode(['status' => 'false', 'message' => 'CO remark is mandatory!']);
            return;
        } else {
            $this->db->where('id', $id);
            $this->db->where('case_no', $case_no);
            $this->db->update('jama_pattadar_corrections', [
                'updated_at' => date('Y-m-d H:i:s'),
                'adc_remarks' => $adc_remark,
                'pending_with_officer' => 'NA',
                'pending_status'   => 'F',
                'status' => $status,
                'approved_by' => $this->session->userdata('user_code')
            ]);

            $log_status = $this->logAction($id, "Reviewed - $status", $adc_remark, $case_no);

            if ($log_status == false || $log_status === false) {
                log_message('error', "#NGCORO004:" . $this->db->last_query());
                $this->db->trans_rollback();
                echo json_encode(['status' => 'false', 'message' => 'Registration failed !']);
                return false;
            }
            ///////////////////////////////////
            $chitha = $this->CorrectionModel->finalChithaJamaCorrection($case_no);
            if ($chitha == false) {
                log_message('error', "#NGCORCHITHA00:" . $this->db->last_query());
                $this->db->trans_rollback();
                echo json_encode(['status' => 'false', 'message' => 'UPDATION FAILED #NGCORCHITHA00']);
                return false;
            }
            ////////////REMARKS ENTRY//////////////
            $jama = $this->CorrectionModel->remarkGenerate($case_no);
            if ($jama == false) {
                log_message('error', "#NGCORJAMA00:" . $this->db->last_query());
                $this->db->trans_rollback();
                echo json_encode(['status' => 'false', 'message' => 'UPDATION FAILED #NGCORJAMA00']);
                return false;
            }
            //////////////////////////////////////

            $this->db->trans_commit();

            echo json_encode(['status' => 'success', 'message' => 'Correction reviewed successfully!', 'redirect_url' => base_url() . 'index.php/CorrectionController/listADCCorrections']);
        }
    }


    function rejectNGCorCO()
    {
        $case_no = $this->input->post('case_no');
        $co_report = $this->input->post('co_report');
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $id = $this->input->post('id');



        $status = 'Rejected';

        $this->form_validation->set_rules('co_report', 'Remark', 'trim|required');

        if ($this->form_validation->run() == false) {
            $text = str_ireplace('<\/p>', '', validation_errors());
            $text = str_ireplace('<p>', '', $text);
            $text = str_ireplace('</p>', '', $text);
            echo json_encode(array('msg' => $text, 'st' => 0));
            return;
        } else {
            $this->db->trans_begin();
            $update_pb = array(
                'status' => $status,
                'pending_status' => 'R',
                'remarks' => $co_report,
                'created_at' => date("Y-m-d h:i:s"),
            );
            $this->db->where('dist_code', $dist_code);
            $this->db->where('case_no', $case_no);
            $this->db->where('id', $id);
            $this->db->update('jama_pattadar_corrections', $update_pb);
            if ($this->db->affected_rows() != 1) {
                $this->db->trans_rollback();
                log_message("error", " #ERRALT0000: Updation failed in jama_pattadar_corrections 
            for case no: " . $case_no);
                $this->session->set_flashdata('message', "#ERRALT0000: Final Submission failed 
            for case no : " . $case_no);
                redirect(base_url() . 'index.php/home');
                return false;
            }
            $log_status = $this->logAction($id, "Reviewed - $status", $co_report);
            if ($log_status == false || $log_status === false) {
                log_message('error', "#NGCORO002:" . $this->db->last_query());
                $this->db->trans_rollback();
                echo json_encode(['status' => 'false', 'message' => 'Registration failed !']);
                return false;
            }
            $this->db->trans_commit();
            //$this->db->trans_rollback();
            $this->session->set_flashdata('message', "Case $case_no is Rejected.");
            redirect(base_url() . 'index.php/home');
        }
    }
    function document($doc)
    {
        $file_name = $doc; // Assuming you have the file name
        $file_path = UPLOAD_GUARD_NAME_CC . '/' . $file_name;
        if (file_exists($file_path)) {
            header('Content-Type: ' . mime_content_type($file_path));
            readfile($file_path);
        } else {
            show_404();
        }
    }
}
