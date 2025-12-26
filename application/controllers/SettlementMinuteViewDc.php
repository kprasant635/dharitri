<?php



class SettlementMinuteViewDc extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('basundhara/SettlementApiModel');
        $location = $this->utilityclass->getLocationFromSession();
        $dist_code = $location['dist_code'];
        $subdiv_code = $location['subdiv_code'];
        $cir_code = $location['cir_code'];
        $define_date = define_date;
        $year_no = year_no;
        // $this->dbswitch();
        $this->append = " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and date_entry>='$define_date'";
        $this->base_query = " dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";

        $this->user_code = $this->session->userdata('user_code');
        $this->load->helper(array('form', 'url', 'Language'));
        $this->load->library('form_validation');

        $this->load->model('SettlementMb/SettlementMeetingDcModel');
        $this->load->model('SettlementModel/SettlementKhasModel');
        $this->load->model('SettlementModel/SettlementTenantModel');
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('SettlementModel/SettlementTribalModel');
        $this->load->model('SettlementModel/SettlementVgrModel');
        $this->load->model('SettlementMb/SettlementMbModel');
        $this->load->model('SettlementModel/SettlementCommonModel');
        $this->load->model('SettlementMb/SettlementCommonDcModel');
        $this->load->model('SettlementMb/SettlementMbDcModel');
        $this->load->model('UtilsModel');
        $this->load->model('SettlementMb/SettlementPullModel');
        $this->load->model('ProgressModel');

        $allowed = ['DC','ADC'];
        $user_desig_code = $this->session->userdata('user_desig_code');
        if(! in_array($user_desig_code, $allowed))
        {
            $this->session->set_flashdata('message', "#MRNC001 : Unauthorized access");
            redirect(base_url() . "index.php/home");
        }
        

    }



    // all approved meeting list
    public function meetingApprovedLandPageViewOnly()
    {
        $dist_code = $this->session->userdata('dist_code');

        $this->db->select('*');
        $this->db->where('proposal_meeting_list.dist_code', $dist_code);
        $this->db->where('proposal_meeting_list.adc_forward_to_dc_status', 1);
        $this->db->where('proposal_meeting_list.digital_sign_status', 1);
        $this->db->where('proposal_meeting_list.digital_sign_update_status', 0);
        $this->db->where('proposal_meeting_list.dc_approve_status', 1);
        $this->db->where_in('proposal_meeting_list.created_by', [MB_ADD_DEPUTY_COMM, MB_SUB_DIV_COMM]);
        $this->db->order_by('proposal_meeting_list.id', 'asc');
        $query1 = $this->db->get('proposal_meeting_list');

        $total_records = $query1->num_rows();
        $meetings      = $query1->result();


        $data['meetingCount'] = $total_records;
        $data['meetings'] = $meetings;

        $data['_view'] = 'SettlementView/Dc/view_minute_only';
        $this->load->view('layouts/main', $data);
    }


    // decode for showing file
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




    // view Digital Minutes
    public function getDigitalMinutesOnlyView()
    {
        $meetingId = trim($this->input->get('meetingId'));

        $meetingDetails = $this->db->select()
            ->where('id', $meetingId)
            ->get('proposal_meeting_list')
            ->row();

        if($meetingDetails->encode_pdf_dir_path == '')
        {
            die("Unable to open file !");
        }
        else
        {
            if(!file_exists($meetingDetails->encode_pdf_dir_path))
            {
                $parts = explode("uploads".UPLOAD_SEPARATOR, $meetingDetails->encode_pdf_dir_path, 2);
                if (count($parts) > 1)
                {
                    $path = BACKUP_DIR_34."uploads".UPLOAD_SEPARATOR . $parts[1];
                }
                else
                {
                    $path = $meetingDetails->encode_pdf_dir_path;
                }

                if(!file_exists($path))
                {
                    $path = BACKUP_DIR_35."uploads".UPLOAD_SEPARATOR . $parts[1];
                }
                if(!file_exists($path))
                {
                    $path = BACKUP_DIR_35."uploads_back_feb224/uploads".UPLOAD_SEPARATOR . $parts[1];
                }
                if(!file_exists($path))
                {
                    $path = BACKUP_DIR_34."uploads_back_feb224/uploads".UPLOAD_SEPARATOR . $parts[1];
                }
                else
                {
                    echo "No Data Found..";
                    return;
                }
            }
            else
            {
                $path = $meetingDetails->encode_pdf_dir_path;
            }

            $mainfile = file_get_contents($path);
            $conType  = mime_content_type($path);
            $mainfile = base64_encode($mainfile);

            if ($conType == 'jpeg' || $conType == 'png' || $conType == 'jpg' || $conType == 'image/jpeg' || $conType == 'image/png' || $conType == 'image/jpg')
            {
                echo "<img src = data:" . $this->decodeBase64($mainfile) . ";base64," . $mainfile . ">";
            }
            else
            {
                header("Content-type: ".$conType);
                echo base64_decode($mainfile);
            }
        }
    }



}
