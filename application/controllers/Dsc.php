<?php
class Dsc extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // $this->load->model('dsc_registration_model', 'dsc_registration');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
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
        }
    }

    public function DtH($number, $bytes)
    {
        $string = strtoupper(str_pad(dechex($number), $bytes, "0", STR_PAD_LEFT));
        $string = substr($string, -$bytes);
        return $string;
    }

    public function otp_check()
    {
        if ($this->session->userdata('user_role')) :
            date_default_timezone_set("Asia/kolkata");
            $data = array();
            $data['msg'] = '';
            $data['reset'] = '';

            $this->load->view('templates/header');
            $this->load->view('otp_check', $data);
            $this->load->view('templates/footer');
        endif;
    }


    public function register_dsc()
    {
        date_default_timezone_set("Asia/kolkata");
        $data = array();
        $this->form_validation->set_rules('cname', 'Full name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('serialNum', 'Certificate Number', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('validFrom', 'Valid From', 'trim|required');
        $this->form_validation->set_rules('validTo', 'Valid To', 'trim');
        if ($this->form_validation->run() === FALSE)
        {
            $data['_view'] = 'dsc_reg';

        }
        else
        {

            //=======check whether the dsc is already registerd or not ?----
            $tablename = "dsc_registration_details";
            $cert = $this->input->post('cert');
            $beginpem = "-----BEGIN CERTIFICATE-----\n";
            $endpem = "-----END CERTIFICATE-----\n";
            $pemdata = $beginpem . $cert . "\n" . $endpem;
            $sha1_hash = @strtoupper(openssl_x509_fingerprint($pemdata)); // sha1 hash
            if ($sha1_hash == false)
            {
                $fileContent = preg_replace('#-.*-|\r|\n#', '', $cert);
                $bin = base64_decode($fileContent);
                $sha1_hash = strtoupper(hash('sha1', $bin));
            }
            $cert_data = openssl_x509_parse($pemdata);
            $hexvalues = array(
                '0', '1', '2', '3', '4', '5', '6', '7',
                '8', '9', 'A', 'B', 'C', 'D', 'E', 'F'
            );
            $hexval = '';
            $number = $cert_data['serialNumberHex'];
            // if ($number == NULL) :
            //     include(FCPATH . 'File\X509.php');
            //     $x509 = new File_X509();
            //     $certt = $x509->loadX509($pemdata);
            //     $number = strtoupper($certt['tbsCertificate']['serialNumber']->toHex());
            // endif;
            $this->db->trans_begin();
            $data = array(
                'dist_code'   => $this->session->userdata('dist_code'),
                'subdiv_code' => $this->session->userdata('subdiv_code'),
                'cir_code'    => $this->session->userdata('cir_code'),
                'mouza_pargona_code' => $this->session->userdata('mouza_pargona_code'),
                'lot_no'             => $this->session->userdata('lot_no'),
                'vill_townprt_code'  => $this->session->userdata('vill_townprt_code'),
                'user_code' => $this->session->userdata('user_desig_code'),
                'dsc_enroll_id' => $number,
                'cert' => $this->input->post('cert'),
                'finger_print' => $sha1_hash,
                'c_name' => $this->input->post('cname'),
                'issuer_name' => $this->input->post('issuer_name'),
                'valid_from' => $this->input->post('validFrom'),
                'valid_to' => $this->input->post('validTo'),
                'creation_date_time' => date('Y-m-d H:i:s'),
                'updation_date_time' => date('Y-m-d H:i:s'),
                'status' => $this->input->post('sts')
            );

            $insertStatus = $this->db->insert('dsc_registration_details',$data);
            if($insertStatus != 1){
                $this->db->trans_rollback();
                log_message('error',"#ERROR2589 : Insertion error in dsc_registration_details table " . $this->db->last_query());
            }
            if ($this->db->trans_status() == FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Something went wrong!!!');
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('success', 'DSC Enrolled Successfully Done ...');
                redirect(base_url() . 'index.php/SettlementMeetingControllerDc/meetingLandPage');
            }
        }
        $this->load->view('layouts/main',$data);
    }


    /* Generate Fingerprint 17-09-2019 */
    public function sha1_thumbprint($file_content)
    {
        $fileContent = preg_replace('#-.*-|\r|\n#', '', $file_content);
        $bin = base64_decode($fileContent);
        return hash('sha1', $bin);
    }


    public function view_profile()
    {
        if (ctype_alnum($this->uri->segment(3))) {
            $id = $this->uri->segment(3);
            $id = substr($id, 20);
            $serialnumber = substr($id, 0, -10);
            // $data['user_id'] = $serialnumber;

            $data['msg'] = "";
            $tablename = "dsc_registration_details";
            $where = array(
                'dsc_enroll_id' => $serialnumber
            );
            $data['dsc_details'] = $this->common->get_all_records_condition($tablename, $where);

            // var_dump($data['dsc_details']);
            $this->load->view('templates/header');
            $this->load->view('Pfms/view_profile', $data);
            $this->load->view('templates/footer');
        }
    }

    public function dsc_profile()
    {
        if (isset($_SESSION['user_role']) && ($_SESSION['user_role'] == 30 || $_SESSION['user_role'] == 9 || $_SESSION['user_role'] == 32)) :
            $userID = $this->session->userdata('user_id');
            $data = array();
            $data['msg'] = "";
            $ExpiredDate = $this->common->find_name_against_id('dsc_registration_details', 'valid_to', 'userid', $userID);
            $dateEx = date('Y-m-d');
            $expiredFlag = 0;
            if ($dateEx > $ExpiredDate) {
                $expiredFlag = 1;
            } else {
                $expiredFlag = 0;
            }
            $data['expiredFlag'] = $expiredFlag;
            $tablename = "dsc_registration_details";
            $where = array(
                'userid' => $userID,
                'roleid' => $_SESSION['user_role']
            );
            $data['dsc_details'] = $this->common->get_all_records_condition($tablename, $where);

            $this->load->view('templates/header');
            $this->load->view('Pfms/view_profile', $data);
            $this->load->view('templates/footer');
        else :
            $this->session->set_flashdata('msg', 'Something Went Wrong...');
            redirect(base_url() . 'index.php/home');
        endif;
    }

    public function dsc_profile_new()
    {

        $data = array();
        $userID = $this->session->userdata('user_id');
        $data['msg'] = "";
        $tablename = "dsc_registration_details";
        $where = array(
            'userid' => $userID
        );
        $data['dsc_list'] = $this->dsc_registration->cluster_wise_dsc_list($where);
        $data['randstring1'] = $this->common->randomstring1();
        $data['randstring2'] = $this->common->randomstring2();
        $data['_view'] = 'dsc_profile_new';
        $this->load->view('layouts/main',$data);

    }

    public function unregister()
    {
        $data = array();
        $userID = $this->session->userdata('user_id');
        $data['msg'] = "";
        $tablename = "dsc_registration_details";
        $where = array(
            'userid' => $userID
        );
        $data['dsc_details'] = $this->common->get_all_records_condition($tablename, $where);
        if (empty($data['dsc_details'])) :
            $data['dsc_details'] = $this->common->get_all_records_condition($tablename, $where);
        else :
            $data['dsc_details'] = $this->common->get_all_records_condition($tablename, $where);
            $where1 = array('dsc_approve_sign.unique_message_id' => $data['dsc_details'][0]['unique_m_id']);
            $data['dsc_signing_details'] = $this->dsc_signing->get_signing_records_dsc($where1);
        endif;

        $this->load->view('templates/header');
        $this->load->view('Pfms/unregister', $data);
        $this->load->view('templates/footer');
    }

    public function unregister_dsc_self()
    {
        if (isset($_SESSION['user_role']) && ($_SESSION['user_role'] == 30 || $_SESSION['user_role'] == 9 || $_SESSION['user_role'] == 32)) :
            $dscID = $this->input->post('dscID');
            $data = array();
            if ($dscID != '') {
                date_default_timezone_set("Asia/Kolkata");
                $tablename = 'dsc_registration_details';
                $where = array(
                    'dsc_enroll_id' => $dscID
                );
                $data = array(
                    'unregister_status' => "Unregistered"
                );
                $this->db->trans_begin();
                $this->common->update_approval_dsc($tablename, $where, $data);
                $data['exist_dsc'] = $this->common->get_all_records_condition($tablename, $where);
                foreach ($data['exist_dsc'] as $key) {
                    $this->history_dsc->userid = $key['userid'];
                    $this->history_dsc->unregister_userid = $this->session->userdata('user_id');
                    $this->history_dsc->district_code = $key['district_code'];
                    $this->history_dsc->dsc_enroll_id = $key['dsc_enroll_id'];
                    $this->history_dsc->district_code = $key['district_code'];
                    $this->history_dsc->cluster_code = $key['cluster_code'];
                    $this->history_dsc->common_name = $key['common_name'];
                    $this->history_dsc->issuer_name = $key['issuer_name'];
                    // $this->history_dsc->aadhar_no = $key['aadhar_no'];
                    $this->history_dsc->pan_no = $key['pan_no'];
                    $this->history_dsc->designation = $key['designation'];
                    $this->history_dsc->department = $key['department'];
                    $this->history_dsc->sub_department = $key['sub_department'];
                    $this->history_dsc->street_name = $key['street_name'];
                    $this->history_dsc->buliding_no = $key['buliding_no'];
                    $this->history_dsc->postal_code = $key['postal_code'];
                    $this->history_dsc->town_name = $key['town_name'];
                    $this->history_dsc->district_census_code = $key['district_census_code'];
                    $this->history_dsc->state_census_code = $key['state_census_code'];
                    $this->history_dsc->phone_no = $key['phone_no'];
                    $this->history_dsc->email = $key['email'];
                    $this->history_dsc->max_amount_for_debit = $key['max_amount_for_debit'];
                    $this->history_dsc->min_amount_for_debit = $key['min_amount_for_debit'];
                    $this->history_dsc->signatory_type = $key['signatory_type'];
                    $this->history_dsc->valid_from = $key['valid_from'];
                    $this->history_dsc->valid_to = $key['valid_to'];
                    $this->history_dsc->status = $key['status'];
                    $this->history_dsc->reason = $key['reason'];
                    $this->history_dsc->statecode = $key['statecode'];
                    $this->history_dsc->creation_datetime = $key['creation_datetime'];
                    $this->history_dsc->level_id = $key['level_id'];
                    $this->history_dsc->roleid = $key['roleid'];
                    $this->history_dsc->approve_reject = $key['approve_reject'];
                    $this->history_dsc->approve_time = $key['approve_time'];
                    $this->history_dsc->unregister_status = $key['unregister_status'];
                    $this->history_dsc->unregister_time = date('Y-m-d H:i:s');
                    $this->history_dsc->sent_to_pfms = null;
                    $this->history_dsc->unique_m_id = null;
                    $this->history_dsc->mobile_no = $key['mobile_no'];
                    $this->history_dsc->thumbprint = $key['thumbprint'];
                    $this->history_dsc->cert = $key['cert'];
                    $this->history_dsc->regenerate_status = null;
                    $this->history_dsc->response_file_name = null;
                    $this->history_dsc->previous_regenerate_status = $key['regenerate_status'];
                    $this->history_dsc->previous_response_file_name = $key['response_file_name'];
                    $insertEnd = $this->history_dsc->insert($this->history_dsc);
                    if ($insertEnd) :
                        $this->dsc_signing->delete($where);
                    endif;
                }
                if ($this->db->trans_status() == FALSE) {
                    $data['msg'] = "Something Went Wrong.";
                    $this->db->trans_rollback();
                } else {
                    $data['status'] = 1;
                    $data['msg'] = 'DSC Unregistered Successfully!';
                    $this->db->trans_commit();
                }
            } else {
                $data['status'] = 0;
                $data['msg'] = 'Something Went Wrong...';
            }
        else :
            $data['status'] = 0;
            $data['msg'] = 'Something Went Wrong...';
        endif;
        echo json_encode($data);
    }



    public function email_validate($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->form_validation->set_message('email_validate', 'Invalid Email...');
            return FALSE;
        } else {
            return true;
        }
    }




    public function getIP()
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            return $ip;
        }
        if (isset($this->utilityclass->get_client_ip())) {
            $ip = $this->utilityclass->get_client_ip();
            return $ip;
        }
        return "0.0.0.0";
    }

    public function dSignDetails(){
        $data = array();
        $data['_view'] = 'dsc_information';
        $this->load->view('layouts/main',$data);
    }










    public function dscSign(){
        $data = array();
        $data['base64PDFData']  = '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IDExIDAgUiBdCi9Db3VudCA1Ci9NZWRpYUJveCBbMCAwIDU5NS4yODAgODQxLjg5MF0KPj4KZW5kb2JqCjEzIDAgb2JqCjw8L1R5cGUgL0V4dEdTdGF0ZQovQk0gL05vcm1hbAovY2EgMQovQ0EgMQo+PgplbmRvYmoKMTQgMCBvYmoKPDwvVHlwZSAvRm9udAovU3VidHlwZSAvVHlwZTAKL0Jhc2VGb250IC9NUERGQUErRGVqYVZ1U2VyaWZDb25kZW5zZWQKL0VuY29kaW5nIC9JZGVudGl0eS1ICi9EZXNjZW5kYW50Rm9udHMgWzE1IDAgUl0KL1RvVW5pY29kZSAxNiAwIFIKPj4KZW5kb2JqCjE1IDAgb2JqCjw8L1R5cGUgL0ZvbnQKL1N1YnR5cGUgL0NJREZvbnRUeXBlMgovQmFzZUZvbnQgL01QREZBQStEZWphVnVTZXJpZkNvbmRlbnNlZAovQ0lEU3lzdGVtSW5mbyAxNyAwIFIKL0ZvbnREZXNjcmlwdG9yIDE4IDAgUgovRFcgNTQwCi9XIFsgMzIgWyAyODYgMzYxIDQxNCA3NTQgNTcyIDg1NSA4MDEgMjQ3IDM1MSAzNTEgNDUwIDc1NCAyODYgMzA0IDI4NiAzMDMgXQogNDggNTcgNTcyIDU4IDU5IDMwMyA2MCA2MiA3NTQgNjMgWyA0ODIgOTAwIDY1MCA2NjEgNjg4IDcyMSA2NTcgNjI0IDcxOSA3ODUgMzU1IDM2MCA2NzIgNTk4IDkyMSA3ODcgNzM4IDYwNSA3MzggNjc3IDYxNiA2MDAgNzU4IDY1MCA5MjUgNjQxIDU5NCA2MjUgMzUxIDMwMyAzNTEgNzU0IDQ1MCA0NTAgNTM2IDU3NiA1MDQgNTc2IDUzMiAzMzMgNTc2IDU4MCAyODggMjc5IDU0NSAyODggODUzIDU4MCA1NDIgNTc2IDU3NiA0MzAgNDYxIDM2MSA1ODAgNTA4IDc3MCA1MDcgNTA4IDQ3NCA1NzIgMzAzIDU3MiA3NTQgXQogMTYwIFsgMjg2IDM2MSBdCiAxNjIgMTY1IDU3MiAxNjYgWyAzMDMgNDUwIDQ1MCA5MDAgNDI3IDU1MCA3NTQgMzA0IDkwMCA0NTAgNDUwIDc1NCAzNjAgMzYwIDQ1MCA1ODQgNTcyIDI4NiA0NTAgMzYwIDQyMyA1NTAgXQogMTg4IDE5MCA4NzIgMTkxIDE5MSA0ODIgMTkyIDE5NyA2NTAgMTk4IFsgOTAxIDY4OCBdCiAyMDAgMjAzIDY1NyAyMDQgMjA3IDM1NSAyMDggWyA3MjYgNzg3IF0KIDIxMCAyMTQgNzM4IDIxNSBbIDc1NCA3MzggXQogMjE3IDIyMCA3NTggMjIxIFsgNTk0IDYwOCA2MDEgXQogMjI0IDIyOSA1MzYgMjMwIFsgODQ2IDUwNCBdCiAyMzIgMjM1IDUzMiAyMzYgMjM5IDI4OCAyNDAgWyA1NDIgNTgwIDU0MiA1NDIgNTQyIDU0MiA1NDIgXQogMjQ3IFsgNzU0IDU0MiBdCiAyNDkgMjUyIDU4MCAyNTMgWyA1MDggNTc2IDUwOCBdCiA4MjE3IDgyMTcgMjg2IDgyMzAgODIzMCA5MDAgXQovQ0lEVG9HSURNYXAgMTkgMCBSCj4+CmVuZG9iagoxNiAwIG9iago8PC9MZW5ndGggMzQ2Pj4Kc3RyZWFtCi9DSURJbml0IC9Qcm9jU2V0IGZpbmRyZXNvdXJjZSBiZWdpbgoxMiBkaWN0IGJlZ2luCmJlZ2luY21hcAovQ0lEU3lzdGVtSW5mbwo8PC9SZWdpc3RyeSAoQWRvYmUpCi9PcmRlcmluZyAoVUNTKQovU3VwcGxlbWVudCAwCj4+IGRlZgovQ01hcE5hbWUgL0Fkb2JlLUlkZW50aXR5LVVDUyBkZWYKL0NNYXBUeXBlIDIgZGVmCjEgYmVnaW5jb2Rlc3BhY2VyYW5nZQo8MDAwMD4gPEZGRkY+CmVuZGNvZGVzcGFjZXJhbmdlCjEgYmVnaW5iZnJhbmdlCjwwMDAwPiA8RkZGRj4gPDAwMDA+CmVuZGJmcmFuZ2UKZW5kY21hcApDTWFwTmFtZSBjdXJyZW50ZGljdCAvQ01hcCBkZWZpbmVyZXNvdXJjZSBwb3AKZW5kCmVuZAoKZW5kc3RyZWFtCmVuZG9iagoxNyAwIG9iago8PC9SZWdpc3RyeSAoQWRvYmUpCi9PcmRlcmluZyAoVUNTKQovU3VwcGxlbWVudCAwCj4+CmVuZG9iagoxOCAwIG9iago8PC9UeXBlIC9Gb250RGVzY3JpcHRvcgovRm9udE5hbWUgL01QREZBQStEZWphVnVTZXJpZkNvbmRl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IDc4NSA2OTggMTAxMSA2OTggNjQyIDY1NyA0MjYgMzI5IDQyNiA3NTQgNDUwIDQ1MCA1ODMgNjI5IDU0OCA2MjkgNTcyIDM4NyA2MjkgNjU0IDM0MiAzMjUgNjI0IDM0MiA5NTIgNjU0IDYwMCA2MjkgNjI5IDQ3NCA1MDYgNDE2IDY1NCA1MjMgNzc0IDUzNiA1MjMgNTExIDU3OSAzMjcgNTc5IDc1NCBdCiBdCi9DSURUb0dJRE1hcCAyNiAwIFIKPj4KZW5kb2JqCjIzIDAgb2JqCjw8L0xlbmd0aCAzNDY+PgpzdHJlYW0KL0NJREluaXQgL1Byb2NTZXQgZmluZHJlc291cmNlIGJlZ2luCjEyIGRpY3QgYmVnaW4KYmVnaW5jbWFwCi9DSURTeXN0ZW1JbmZvCjw8L1JlZ2lzdHJ5IChBZG9iZSkKL09yZGVyaW5nIChVQ1MpCi9TdXBwbGVtZW50IDAKPj4gZGVmCi9DTWFwTmFtZSAvQWRvYmUtSWRlbnRpdHktVUNTIGRlZgovQ01hcFR5cGUgMiBkZWYKMSBiZWdpbmNvZGVzcGFjZXJhbmdlCjwwMDAwPiA8RkZGRj4KZW5kY29kZXNwYWNlcmFuZ2UKMSBiZWdpbmJmcmFuZ2UKPDAwMDA+IDxGRkZGPiA8MDAwMD4KZW5kYmZyYW5nZQplbmRjbWFwCkNNYXBOYW1lIGN1cnJlbnRkaWN0IC9DTWFwIGRlZmluZXJlc291cmNlIHBvcAplbmQKZW5kCgplbmRzdHJlYW0KZW5kb2JqCjI0IDAgb2JqCjw8L1JlZ2lzdHJ5IChBZG9iZSkKL09yZGVyaW5nIChVQ1MpCi9TdXBwbGVtZW50IDAKPj4KZW5kb2JqCjI1IDAgb2JqCjw8L1R5cGUgL0ZvbnREZXNjcmlwdG9yCi9Gb250TmFtZSAvTVBERkFBK0RlamFWdVNlcmlmQ29uZGVuc2VkLUJvbGQKIC9DYXBIZWlnaHQgNzI5CiAvWEhlaWdodCA1MTkKIC9Gb250QkJveCBbLTc1MiAtMzg5IDE2MTcgMTE0NV0KIC9GbGFncyAyNjIxNDgKIC9Bc2NlbnQgOTM5CiAvRGVzY2VudCAtMjM2CiAvTGVhZGluZyAwCiAvSXRhbGljQW5nbGUgMAogL1N0ZW1WIDE2NQogL01pc3Np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AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAASWFuIEJhY2sAAAAB6hwABwAACAwAAAhmAAAAABzqAAAACAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABJAGEAbgAgAEIAYQBjAGsAAAD/4QphaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49J++7vycgaWQ9J1c1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCc/Pg0KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyI+PHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj48cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0idXVpZDpmYWY1YmRkNS1iYTNkLTExZGEtYWQzMS1kMzNkNzUxODJmMWIiIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIvPjxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSJ1dWlkOmZhZjViZGQ1LWJhM2QtMTFkYS1hZDMxLWQzM2Q3NTE4MmYxYiIgeG1sbnM6ZGM9Imh0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvIj48ZGM6Y3JlYXRvcj48cmRmOlNlcSB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPjxyZGY6bGk+SWFuIEJhY2s8L3JkZjpsaT48L3JkZjpTZXE+DQoJCQk8L2RjOmNyZWF0b3I+PC9yZGY6RGVzY3JpcHRpb24+PC9yZGY6UkRGPjwveDp4bXBtZXRhPg0KICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8P3hwYWNrZXQgZW5kPSd3Jz8+/9sAQwABAQEBAQEBAQEBAQEBAQECAgEBAQEDAgICAgMDBAQDAwMDBAQGBQQEBQQDAwUHBQUGBgYGBgQFBwcHBgcGBgYG/9sAQwEBAQEBAQEDAgIDBgQDBAYGBgYGBgYGBgYGBgYGBgYGBgYGBgYGBgYGBgYGBgYGBgYGBgYGBgYGBgYGBgYGBgYG/8AAEQgAEAAOAwEiAAIRAQMRAf/EAB8AAAEFAQEBAQEBAAAAAAAAAAABAgMEBQYHCAkKC//EALUQAAIBAwMCBAMFBQQEAAABfQECAwAEEQUSITFBBhNRYQcicRQygZGhCCNCscEVUtHwJDNicoIJChYXGBkaJSYnKCkqNDU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6g4SFhoeIiYqSk5SVlpeYmZqio6Slpqeoqaqys7S1tre4ubrCw8TFxsfIycrS09TV1tfY2drh4uPk5ebn6Onq8fLz9PX29/j5+v/EAB8BAAMBAQEBAQEBAQEAAAAAAAABAgMEBQYHCAkKC//EALURAAIBAgQEAwQHBQQEAAECdwABAgMRBAUhMQYSQVEHYXETIjKBCBRCkaGxwQkjM1LwFWJy0QoWJDThJfEXGBkaJicoKSo1Njc4OTpDREVGR0hJSlNUVVZXWFlaY2RlZmdoaWpzdHV2d3h5eoKDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uLj5OXm5+jp6vLz9PX29/j5+v/aAAwDAQACEQMRAD8A/ppl1n9i/wDZm/ZY/Zc+Kvx//Zn8L3fgDxf8K/Di/ET47aZ8AtO8Q6f4c1CbSIJILjXxDG9+Fvrl/IjuIra4T7TIiTvCZYi/8/8A/wAHSXiDT/h5/wAE4P2Qvjb8AvhJ4s/Yu8XfEr9o+3TV9F0vw7ZeCfGMWlSaHqkkVpqw0mdtgfyrec2skpeM7FmSKZHjT9efC37eX/BEb4sfAn9lLQf2jP2wv2NvHOofBf4ZaL9j+H/jz48WV3oVtrR0SOyuXv8ARGujY308KNcRxPdwzNbl5GgMbOzH+en/AIOef2nv+CfXxG/4Jwfsl/s+/sQ/tMfB/wCMGm/B79pC0az8CeCvjsfGWq6RoQ0PVY4iz3F3Pdm0ieWOBNztHAhhhXYgiQeRhqeeLPJyqOP1W3urXm5tL3921t7a3WrblzJU/wBGzDE+GU/DnCUsLRrrPFUft5yS+ruleryqn+9clU1hzydNRmlGMI0nSqTxf//ZCmVuZHN0cmVhbQplbmRvYmoKMiAwIG9iago8PC9Qcm9jU2V0IFsvUERGIC9UZXh0IC9JbWFnZUIgL0ltYWdlQyAvSW1hZ2VJXQovRm9udCA8PAovRjEgMTQgMCBSCi9GMiAyMSAwIFIKPj4KL0V4dEdTdGF0ZSA8PAovR1MxIDEzIDAgUgo+PgovWE9iamVjdCA8PAovSTEgMjggMCBSCj4+Cj4+CmVuZG9iagoyOSAwIG9iago8PAovUHJvZHVjZXIgKP7/AG0AUABEAEYAIAA4AC4AMQAuADIpCi9DcmVhdGlvbkRhdGUgKEQ6MjAyMzA1MTIxNjQ5NTkrMDUnMzAnKQovTW9kRGF0ZSAoRDoyMDIzMDUxMjE2NDk1OSswNSczMCcpCj4+CmVuZG9iagozMCAwIG9iago8PAovVHlwZSAvQ2F0YWxvZwovUGFnZXMgMSAwIFIKL09wZW5BY3Rpb24gWzMgMCBSIC9YWVogbnVsbCBudWxsIDFdCi9QYWdlTGF5b3V0IC9PbmVDb2x1bW4KPj4KZW5kb2JqCnhyZWYKMCAzMQowMDAwMDAwMDAwIDY1NTM1IGYgCjAwMDAwMTM0NDMgMDAwMDAgbiAKMDAwMDA0ODc2NCAwMDAwMCBuIAowMDAwMDAwMDE1IDAwMDAwIG4gCjAwMDAwMDAyMjMgMDAwMDAgbiAKMDAwMDAwNDA1NCAwMDAwMCBuIAowMDAwMDA0MjYyIDAwMDAwIG4gCjAwMDAwMDg3MjggMDAwMDAgbiAKMDAwMDAwODkzNiAwMDAwMCBuIAowMDAwMDExNzYyIDAwMDAwIG4gCjAwMDAwMTE5NzEgMDAwMDAgbiAKMDAwMDAxMjYzMCAwMDAwMCBuIAowMDAwMDEyODQwIDAwMDAwIG4gCjAwMDAwMTM1NTcgMDAwMDAgbiAKMDAwMDAxMzYxOSAwMDAwMCBuIAowMDAwMDEzNzczIDAwMDAwIG4gCjAwMDAwMTQ3NjQgMDAwMDAgbiAKMDAwMDAxNTE2MCAwMDAwMCBuIAowMDAwMDE1MjI5IDAwMDAwIG4gCjAwMDAwMTU1MzcgMDAwMDAgbiAKMDAwMDAxNTkyNyAwMDAwMCBuIAowMDAwMDI3Mzk1IDAwMDAwIG4gCjAwMDAwMjc1NTQgMDAwMDAgbiAKMDAwMDAyODEwMSAwMDAwMCBuIAowMDAwMDI4NDk3IDAwMDAwIG4gCjAwMDAwMjg1NjYgMDAwMDAgbiAKMDAwMDAyODg4NSAwMDAwMCBuIAowMDAwMDI5MjYxIDAwMDAwIG4gCjAwMDAwNDA3MTEgMDAwMDAgbiAKMDAwMDA0ODkxOSAwMDAwMCBuIAowMDAwMDQ5MDUxIDAwMDAwIG4gCnRyYWlsZXIKPDwKL1NpemUgMzEKL1Jvb3QgMzAgMCBSCi9JbmZvIDI5IDAgUgovSUQgWzxhM2MxZGQzNzMzZDNlMDk1ZGUyMWYxNGI3ZTY3NDEzMj4gPGEzYzFkZDM3MzNkM2UwOTVkZTIxZjE0YjdlNjc0MTMyPl0KPj4Kc3RhcnR4cmVmCjQ5MTYxCiUlRU9G';
        $data['_view'] = 'dsc_signing';
        $this->load->view('layouts/main',$data);
    }

    public function saveDataPDF(){
        $inputData = json_decode(file_get_contents("php://input"), true);
        $base64PDFData = $inputData['pdfData'];
        $uploadpath   = SIGNPDF_UPLOAD_DIR;
        file_put_contents($uploadpath.date('dmyhis').".json", base64_decode($base64PDFData));
        $signDateTime = date('Y-m-d H:i:s');
        $updateData = array(
            'encodepdf_dir_path' => SIGNPDF_UPLOAD_DIR,
            'digital_sign_date'=> $signDateTime,
            'digital_sign_status' => 2 //SUCCESS 2 or FAILED 1
        );
        $this->db->update('proposal_meeting_list',$updateData);
        if($this->db->affected_rows() != 1){
            log_message('error', '#ERRORMB0212: DSC Signing error for update query' . $this->db->last_query());
            echo  json_encode(array('status' => 1));
        }else{
            echo  json_encode(array('status' => 2));
        }
    }
}