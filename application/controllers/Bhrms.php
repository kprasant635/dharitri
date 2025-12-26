<?php
class Bhrms extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('BhrmsModel');
        $this->load->model('UtilsModel');
    }

    public function index()
    {
        $data['dist_code'] = $this->session->userdata('dist_code');
        $data['subdiv_code'] = $this->session->userdata('subdiv_code');
        $data['cir_code'] = $this->session->userdata('cir_code');

        $mouzas = $this->BhrmsModel->getMouzas($data['dist_code'], $data['subdiv_code'], $data['cir_code']);
        if ($mouzas->num_rows() <= 0) {
            echo json_encode(array(
                'responseType' => 0,
                'msg' => '#ERR19: Unable to process! Something went wrong...',
            ));
            return false;
        }
        $data['mouza_result'] = $mouzas->result();

        $data['_view'] = 'Bhrms/bhrms_index';
        $this->load->view('layouts/main', $data);
    }

    public function save()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('mouza_pargona_code', 'Mouza Name', 'trim|required');
        $this->form_validation->set_rules('lot_no', 'Lot name', 'trim|required');
        $this->form_validation->set_rules('vill_townprt_code', 'Village name', 'trim|required');
        $this->form_validation->set_rules('pradhan_name', 'Pradhan name', 'trim|required');
        $this->form_validation->set_rules('dob', 'Date of birth', 'trim|required');
        $this->form_validation->set_rules('date_of_eng', 'Date of engagement', 'trim|required');
        $this->form_validation->set_rules('date_of_retirement', 'Date of retirement', 'trim|required');
        $this->form_validation->set_rules('edu_qualification', 'Education qualification', 'trim|required');
        $this->form_validation->set_rules('phone_no', 'Phone No', 'trim|required|min_length[10]|max_length[12]|is_natural');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required');
        if ($this->form_validation->run() == false) {
            $error_msg = strip_tags(validation_errors());
            echo json_encode(array(
                'responseType' => 0,
                'msg' => "#ERR56:" . $error_msg,
            ));
            return false;
        }

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->input->post('mouza_pargona_code');
        $lot_no = $this->input->post('lot_no');
        $vill_townprt_code = $this->input->post('vill_townprt_code');
        $pradhan_name = $this->input->post('pradhan_name');
        $dob = $this->input->post('dob');
        $date_of_eng = $this->input->post('date_of_eng');
        $date_of_retirement = $this->input->post('date_of_retirement');
        $edu_qualification = $this->input->post('edu_qualification');
        $phone_no = $this->input->post('phone_no');
        $remarks = $this->input->post('remarks');

        // file upload
        if (!isset($_FILES['file_upload']) || $_FILES['file_upload']['error'] != UPLOAD_ERR_OK) {
            echo json_encode(array(
                'responseType' => 0,
                'msg' => '#ERR932: Please upload file',
            ));
            return false;
        }

        $mime = mime_content_type($_FILES['file_upload']['tmp_name']);
        $exp = explode("/", $mime);
        $onlyExtension = $exp[1];

        $fileRename = $this->UUID4() . '.' . $onlyExtension;

        $config['upload_path'] = UPLOAD_BASE . 'ehrms/';
        if (is_dir($config['upload_path']) === false) {
            mkdir($config['upload_path']);
        }

        $config['allowed_types'] = UPLOAD_ALLOW_TYPE;
        $config['max_size'] = UPLOAD_MAX_SIZE;
        $config['file_name'] = $fileRename;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file_upload')) {
            echo json_encode(array(
                'responseType' => 0,
                'msg' => '#ERR92: Something went wrong! Unable to upload file...' . $this->upload->display_errors(),
            ));
            return false;
        }

        if (!file_exists($config['upload_path'] . $fileRename)) {
            echo json_encode(array(
                'responseType' => 0,
                'msg' => '#ERR104: Something went wrong! Unable to upload file...',
            ));
            return false;
        }

        $inser_array = [
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_code' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'name_of_pradhan' => $pradhan_name,
            'dob' => $dob,
            'date_of_engagement' => $date_of_eng,
            'date_of_retirement' => $date_of_retirement,
            'education_qualification' => $edu_qualification,
            'phone_no' => $phone_no,
            'remarks' => $remarks,
            'document_link' => $config['upload_path'] . $fileRename,
        ];

        $insert = $this->db->insert('bhrms', $inser_array);
        if ($insert != true) {
            echo json_encode(array(
                'responseType' => 0,
                'msg' => '#ERR83: Something went wrong! Unable to process',
            ));
            return false;
        }

        echo json_encode(array(
            'responseType' => 2,
            'msg' => 'Data successfully saved...',
        ));
    }

    private function UUID4()
    {
        $bytes = random_bytes(16);
        $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
        $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
    }

    public function viewList()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $data['has_list'] = false;
        $list = $this->BhrmsModel->getList($dist_code, $subdiv_code, $cir_code);
        if ($list->num_rows() > 0) {
            $data['has_list'] = true;
            $data['list_result'] = $list->result();
        }
        $data['_view'] = 'Bhrms/bhrms_list';
        $this->load->view('layouts/main', $data);
    }

    public function delete()
    {
        $id = $this->input->post('id');
        $delete = $this->BhrmsModel->deleteById($id);
        if ($this->db->affected_rows() != 1) {
            echo json_encode(array(
                'responseType' => 0,
                'msg' => '#ERR116: Something went wrong! Unable to process',
            ));
            return false;
        }
        echo json_encode(array(
            'responseType' => 2,
            'msg' => 'Data successfully deleted...',
        ));
    }

    public function downloadExcel()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $list = $this->BhrmsModel->getList($dist_code, $subdiv_code, $cir_code);
        $result_array = $list->result_array();
        $sl_no = 1;
        foreach ($result_array as $raw_array) {
            $finale_array[] = [
                'name_of_circle' => $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code),
                'sl_no' => $sl_no++,
                'name_of_gaon_pradhan' => $raw_array['name_of_pradhan'],
                'date_of_birth' => $raw_array['dob'],
                'date_of_engagement' => $raw_array['date_of_engagement'],
                'date_of_retirement' => $raw_array['date_of_retirement'],
                'education_qualification' => $raw_array['education_qualification'],
                'phone_no' => $raw_array['phone_no'],
                'remarks' => $raw_array['remarks'],
            ];
        }
        $file_name = $dist_code . '_' . $subdiv_code . '_' . $cir_code . '.xlsx';
        $this->UtilsModel->downloadExcelReport($file_name, $finale_array);
    }

    public function view()
    {
        $id = isset($_GET['doc_id']) ? $_GET['doc_id'] : null;

        $query = $this->db->query('select * from bhrms where id = ?', array($id));
        if ($query->num_rows() <= 0) {
            echo json_encode(['No file found!']);
            return false;
        }

        $file_row = $query->row();
        $file = $file_row->document_link;

        $this->load->helper('file');
        $mime = get_mime_by_extension($file);

        header('Content-Type: ' . $mime);
        readfile($file);
    }

}
