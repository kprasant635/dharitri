<?php
class RejectMb2Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Allowed designations
        $allowed = ['CO','DC','ADC'];
        $user_desig_code = $this->session->userdata('user_desig_code');

        // Restrict access if not in allowed list
        if ( ! in_array($user_desig_code, $allowed)) {
            echo json_encode(['error' => 'Unauthorized access']);
            exit; // or die();
        }
        $this->load->library('form_validation');
        $this->load->helper('html');
        $this->load->model('basundhara/basundharamodel');
    }
    public function getRejectModal()
    {
        $service_code = $this->input->post('service_code');

        $sql = "SELECT reject_code,remark FROM reject_master WHERE
                flag=? and service_code=?";
        $res = $this->db->query($sql, array('1', $service_code))->result();

        echo json_encode($res);
    }
    public function getRejectCat($sid)
    {
        $sql = "SELECT reject_code,remark FROM reject_master WHERE
                flag=? and service_code in ('$sid')";
        $res = $this->db->query($sql, array('1'))->result();

        echo json_encode($res);
    }
    function postRejectedReasonNoCase()
    {
        $json = null;
        $message = null;
        $all_remark = null;
        $reject_code = $this->input->post('reject_code');
        $case_no = $this->input->post('case_no');
        $remark = $this->input->post('remark');
        $desg = $this->session->userdata('user_desig_code');
        $service_code = $this->input->post('service_code');
        $user_code = $this->session->userdata('user_code');
        $validation = [
            [
                'field' => 'reject_code',
                'label' => 'Reject Remark',
                'rules' => 'required',
            ],
            [
                'field' => 'remark',
                'label' => 'Reject Reason',
                'rules' => 'trim|required|min_length[50]|callback_check_script|xss_clean',
            ],
        ];
        $this->form_validation->set_rules($validation);
        $this->form_validation->set_message('check_script', 'Invalid characters 
            entered in %s field');
        if ($this->form_validation->run('validation') == FALSE) {
            foreach ($validation as $rule) {
                if (form_error($rule['field'])) {
                    $message .= form_error($rule['field']);
                }
            }
            $json = [
                'success' => false,
                'message' => $message,
            ];
            echo json_encode($json);
            return;
        }
        $this->db->trans_begin();
        foreach ($reject_code as $r) {
            $array = [
                'service_code' => $service_code,
                'reject_code' => $r,
                'case_no' => $case_no,
                'user_code' => $user_code,
                'remark' => $this->input->post('remark'),
                'ref_no' => $this->input->post('ref_no'),
                'date_entry' => date('Y-m-d'),
                'datetime_entry' => date('Y-m-d H:i:s'),
            ];

            // var_dump('reject_code');

            //*************** Insert into rejected_remark ********* /
            $insert = $this->db->insert('rejected_remark', $array);
            if ($insert != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERREJ0002: Insertion failed in rejected_remark and query is: ' . $this->db->last_query());
                $json = [
                    'success' => false,
                    'message' => '#ERREJ0002: Unable to process',
                ];
                echo json_encode($json);
                return;
            }
            $sql2 = "select remark,service_code from reject_master where reject_code=?";
            $res2 = $this->db->query($sql2, $r)->row();
            $remarkRes2 = $res2->remark;
            $service_code = $res2->service_code;
            $all_remark .= $remarkRes2 . '. ';
            //////////POST TO BASUNDHARA//////////////
            $postArray[] = [
                'service_code' => $service_code,
                'id' => $r,
                'name' => $remarkRes2
            ];
            //////////////////////////////////////////
        }
        $rmk = $all_remark;
        $status = MB_DISMISS;
        $task = $this->session->userdata('user_desig_code');
        $pen = 'NA';
        $case = $case_no;
        //$application_no,$case,$rmk,$status,$task,$pen,$rejectedCtgs
        $api_data = $this->basundharamodel->postApiBasundharaForRejectedCase3rd($case, $case, $rmk, $status, $task, $pen, $postArray);
        if ($api_data == false || $api_data == 'false') {
            $this->db->trans_rollback();
            log_message('error', '#ERREJ0006: Basundhara MB2 API Failed.');
            $json = [
                'success' => false,
                'message' => '#ERREJ0006: Unable to process',
            ];
            echo json_encode($json);
            return;
        }
        $this->db->trans_commit();
        $this->session->set_flashdata('message', 'Case No. ' . $case_no . ' has been successfully rejected !!');
        $json = [
            'success' => true,
            'message' => 'Case has been successfully rejected !!',
            'redirect' => base_url() . 'index.php/home',
        ];
        echo json_encode($json);
        return;
    }

    // Post Rejected Reason 
    public function postRejectedReason()
    {

        $json = null;
        $message = null;
        $all_remark = null;
        $reject_code = $this->input->post('reject_code');

        //get selected reject remark is CSV Begin
        // $reject_code_str = implode(', ', $reject_code);
        // $service_code = $this->input->post('service_code');
        // $sql = " SELECT remark FROM reject_master WHERE service_code = '$service_code' AND reject_code IN ($reject_code_str)";
        // $rejected_remarks = $this->db->query($sql)->result();
        // $remarks = array_column($rejected_remarks, 'remark');
        // $remarks_csv = implode(',', $remarks);
        //get selected reject remark in CSV end

        $case_no = $this->input->post('case_no');
        $remark = $this->input->post('remark');
        $desg = $this->session->userdata('user_desig_code');
        $service_code = $this->input->post('service_code');
        $user_code = $this->session->userdata('user_code');
        $validation = [
            [
                'field' => 'reject_code',
                'label' => 'Reject Remark',
                'rules' => 'required',
            ],
            [
                'field' => 'remark',
                'label' => 'Reject Reason',
                'rules' => 'trim|required|min_length[50]|callback_check_script|xss_clean',
            ],
        ];
        $this->form_validation->set_rules($validation);
        $this->form_validation->set_message('check_script', 'Invalid characters 
            entered in %s field');
        if ($this->form_validation->run('validation') == FALSE) {
            foreach ($validation as $rule) {
                if (form_error($rule['field'])) {
                    $message .= form_error($rule['field']);
                }
            }
            $json = [
                'success' => false,
                'message' => $message,
            ];
            echo json_encode($json);
            return;
        }
        $this->db->trans_begin();
        //table update as per service
        $params = $this->rejectTableServiceWise($service_code, $case_no, $user_code);
        if ($params[1] != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERREJ0001: Updation failed in ' . $params[0] . ' and query is: ' . $this->db->last_query());
            $json = [
                'success' => false,
                'message' => '#ERREJ0001: Unable to process',
            ];
            echo json_encode($json);
            return;
        }
        foreach ($reject_code as $r) {
            $array = [
                'service_code' => $service_code,
                'reject_code' => $r,
                'case_no' => $case_no,
                'user_code' => $user_code,
                'remark' => $this->input->post('remark'),
                'ref_no' => $this->input->post('ref_no'),
                'date_entry' => date('Y-m-d'),
                'datetime_entry' => date('Y-m-d H:i:s'),
            ];

            //*************** Insert into rejected_remark ********* /
            $insert = $this->db->insert('rejected_remark', $array);
            if ($insert != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERREJ0002: Insertion failed in rejected_remark and query is: ' . $this->db->last_query());
                $json = [
                    'success' => false,
                    'message' => '#ERREJ0002: Unable to process',
                ];
                echo json_encode($json);
                return;
            }
            $sql2 = "select remark,service_code from reject_master where reject_code=?";
            $res2 = $this->db->query($sql2, $r)->row();
            $remarkRes2 = $res2->remark;
            $service_code = $res2->service_code;
            $all_remark .= $remarkRes2 . '. ';
            //////////POST TO BASUNDHARA//////////////
            $postArray[] = [
                'service_code' => $service_code,
                'id' => $r,
                'name' => $remarkRes2
            ];
            //////////////////////////////////////////
        }
        $all_remark .= $remark;
        if ($desg == 'CO' || $desg == 'AST' || $desg == 'LM' || $desg == 'SK') {
            //*************** Insert into Settlement Proceeding ********* /
            $proceeding = $this->proceedingRemark($case_no, $all_remark);
            if ($proceeding != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERREJ0003: Insertion failed in settlement_proceeding.' . $this->db->last_query());
                $json = [
                    'success' => false,
                    'message' => '#ERREJ0003: Unable to process',
                ];
                echo json_encode($json);
                return;
            }
        } else if ($desg == 'ADC' || $desg == 'DC') {
            //*************** Insert into Settlement Proceeding DC ADC ********* /
            $proceeding = $this->proceedingDCADCRemark($case_no, $all_remark);
            if ($proceeding != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERREJ0004: Insertion failed in settlement_proceeding.');
                $json = [
                    'success' => false,
                    'message' => '#ERREJ0004: Unable to process',
                ];
                echo json_encode($json);
                return;
            }
        }

        // $basundharaExist = $this->basundharamodel->checkExistBasundhar($case_no);
        // if ($basundharaExist) {
        //     $rmk = $all_remark;
        //     $status = MB_DISMISS;
        //     $task = $this->session->userdata('user_desig_code');
        //     $pen = 'NA';
        //     $case = $case_no;
        //     $api_data = $this->basundharamodel->postApiBasundharaForRejectedCase1st($case, $rmk, $status, $task, $pen, $postArray);
        //     if ($api_data == false || $api_data == 'false') {
        //         $this->db->trans_rollback();
        //         log_message('error', '#ERREJ0007: Basundhara MB2 API Failed.');
        //         $json = [
        //             'success' => false,
        //             'message' => '#ERREJ0007: Unable to process',
        //         ];
        //         echo json_encode($json);
        //         return;
        //     }
        // }
        //////////////Send Reject status to RTPS Server////////////////////
        // $sql = "Select application_ref_no,applid,mut_type from petition_basic where case_no=? ";
        // $application_ref_no = $this->db->query($sql, array($case_no));
        // if ($application_ref_no->num_rows() == 1) {
        //     $refno = $application_ref_no->row();
        //     $curl_handle = curl_init();
        //     if ($refno->mut_type == '03') {
        //         curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK . "mutation/mutation_response.php");
        //     } else if ($refno->mut_type == '04') {
        //         curl_setopt($curl_handle, CURLOPT_URL, RTPS_LINK . "partition/partition_co_order.php");
        //     }
        //     curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        //     curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        //     curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        //     curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(array(
        //         'applId' => $refno->applid,
        //         'application_ref_no' => $refno->application_ref_no,
        //         'msg' => $rmk == null ? "Rejected" : $rmk,
        //         'status' => "D",
        //     )));
        //     $result = curl_exec($curl_handle);
        //     log_message('error', "Response from RTPS:" . $case_no . "####" . json_decode($result));
        // }
        //////////////////END////////////////////////////
        $this->db->trans_commit();
        $this->session->set_flashdata('message', 'Case No. ' . $case_no . ' has been successfully rejected !!');
        $json = [
            'success' => true,
            'message' => 'Case has been successfully rejected !!',
            'redirect' => base_url() . 'index.php/home',
        ];
        echo json_encode($json);
        return;
    }
    public function proceedingRemark($case_no, $remark)
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $sql = "select MAX(proceeding_id) as id from settlement_proceeding where
               case_no=? and dist_code=? and subdiv_code=? and cir_code=?";
        $res = $this->db->query($sql, array($case_no, $dist_code, $subdiv_code, $cir_code));
        if ($res->num_rows() > 0) {
            $proceeding_id = $res->row()->id + 1;
        } else {
            $proceeding_id = 1;
        }
        $values = array(
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'co_order' => $remark,
            'status' => 'Rejected',
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d G:i:s'),
            'operation' => 'E',
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code
        );
        return $this->db->insert("settlement_proceeding", $values);
    }
    public function proceedingDCADCRemark($case_no, $remark)
    {

        $sql = "select MAX(proceeding_id) as id from settlement_proceeding where
               case_no=? ";
        $res = $this->db->query($sql, array($case_no));
        if ($res->num_rows() > 0) {
            $proceeding_id = $res->row()->id + 1;
        } else {
            $proceeding_id = 1;
        }
        $values = array(
            'case_no' => $case_no,
            'proceeding_id' => $proceeding_id,
            'date_of_hearing' => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'status' => MB_DISMISS,
            'user_code' => $this->session->userdata('user_code'),
            'date_entry' => date('Y-m-d G:i:s'),
            'operation' => 'E',
            'note_on_order' => $remark,
            'ip' => $this->utilityclass->get_client_ip(),
            'office_from' => MB_DEPUTY_COMM,
            'office_to'   => '',
            'task'        => 'Rejected by DC.',
            // 'note_type' => $remarks_csv
        );
        return $this->db->insert("settlement_proceeding", $values);
    }

    public function rejectTableServiceWise($service_code, $case_no, $user_code)
    {
        $table = array();
        if ($this->session->userdata('user_desig_code') == 'CO') {
            $name = $this->utilityclass->getSelectedCOName($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'), $this->session->userdata('cir_code'), $user_code);
            $RejectedOfficerName = $name->username;
        }
        if ($this->session->userdata('user_desig_code') == 'ADC' || $this->session->userdata('user_desig_code') == 'DC') {
            $name = $this->utilityclass->dcname($this->session->userdata('dist_code'), $user_code);
            $RejectedOfficerName = $name;
        }

        //Basundhara MB2
        // if ($service_code == SETTLEMENT_KHAS_LAND_ID || $service_code == SETTLEMENT_AP_TRANSFER_ID) {
        $petition_no = $this->db->query("SELECT petition_no FROM settlement_basic WHERE 
                case_no=?", $case_no)->row()->petition_no;
        $array = [
            // // 'is_dispose' => 'Y',
            // // 'order_passed' => 'Y',
            // 'if_dispose_date' => date("Y-m-d h:i:s"),
            'dispose_reason' => $case_no . ' has successfully rejected by ' . $RejectedOfficerName,
            'user_code' => $user_code,
            'dc_code'         => $user_code,
            'status' => MB_DISMISS,
            'pending_office' => '',
            'pending_officer' => '',
            'from_office' => MB_DEPUTY_COMM,
            'dc_proceeding'   => 0,

        ];
        $this->db->where(['case_no' => $case_no, 'petition_no' => $petition_no]);
        $this->db->update('settlement_basic', $array);
        $table[] = 'settlement_basic';
        // }


        $table[] = $this->db->affected_rows();
        return $table;
    }
    //this method will be used for checking script in the post fields
    function check_script($str)
    {
        if (strpos(trim(strtolower($str)), '<') !== false) {
            return FALSE;
        }
        if (strpos(trim(strtolower($str)), '>') !== false) {
            return FALSE;
        }
        if (strpos(trim(strtolower($str)), '<script>') !== false) {
            return FALSE;
        }
        if (strpos(trim(strtolower($str)), '</script>') !== false) {
            return FALSE;
        }
        return TRUE;
    }

    function CaseSearchForBasundhara($case)
    {
        $sql = "Select trans_code from petition_basic where case_no='$case'
        union
        Select trans_code from field_mut_basic where case_no='$case'
         ";

        return $this->db->query($sql)->row()->trans_code;
    }
}
