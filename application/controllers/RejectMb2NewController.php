<?php

class RejectMb2NewController extends CI_Controller
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
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('basundhara/SettlementApiModel');
        $this->load->model('SettlementMb/SettlementCommonDcModel');
        $this->load->model('SettlementModel/SettlementKhasModel');
        $this->load->model('SettlementMb/SettlementPullModel');

        if(HOLD_All_MB2_CASES_STATUS == 1)
        {
            if(strtotime(HOLD_All_MB2_CASES_DATE) < strtotime(date('Y-m-d H:i:s')))
            {
                $this->session->set_flashdata('message', " Processing of settlement MB 2.0 Cases has been stopped !");
                redirect(base_url() . "index.php/Home/index");
            }
        }
    }


    //////////////// Reject MB2 Cases by Masud //////////////////////



    public function getRejectModal()
    {
        $service_code = $this->input->post('service_code');
        $case_no = trim($this->input->post('case_no'));

        if($service_code != SETTLEMENT_SPECIAL_CULTIVATORS_ID)
        {
            $decrypted = dec_param($case_no, 'case_no');
            $case_no   = !is_null($decrypted) ? trim($decrypted) : $case_no;
        }

        $lm_rej_remark1 =array();

        $sql_lm_reject_remark = $this->db->query("SELECT lm_rejected_remarks FROM settlement_ap_lmnote WHERE case_no = ?", array($case_no));

        $masterArray =array();
        if($sql_lm_reject_remark->num_rows() > 0)
        {
            $lm_reject_remark_json = $sql_lm_reject_remark->row()->lm_rejected_remarks;

            if($lm_reject_remark_json != null || $lm_reject_remark_json != '')
            {

                // $dag_no_arr = array();

                $lm_rej_remark = json_decode($lm_reject_remark_json);

                if($lm_rej_remark)
                {
                    foreach($lm_rej_remark as $val)
                    {

                        if(isset($val->reject_code))
                        {
                            $lm_rej_remark1[] = $val->reject_code;

                            $ddgVal = '';
                            if(isset($val->dag_no))
                            {
                                $ddgVal = $val->dag_no;
                            }

                            $masterArray[] =  $val->reject_code.$ddgVal;
                        }
                        else
                        {
                            $ddgVal = '';
                            if(isset($val->dag_no))
                            {
                                $ddgVal = $val->dag_no;
                            }

                            $masterArray[] =  $val.$ddgVal;
                        }

                    }
                }
                else
                {
                    $lm_rej_remark1 = 'n';
                }
            }
            else
            {
                $lm_rej_remark1 = 'n';
            }
        }

        $sql = "SELECT chitha_flag, reject_code,remark, remark_head FROM reject_master WHERE flag=? and service_code=? and remark_head is not null";
        $res = $this->db->query($sql, array('1', $service_code))->result();

        $sql = $this->db->query("SELECT reject_code FROM rejected_remark WHERE case_no=?", array($case_no));

        $reject_code = array();

        if($sql->num_rows() > 0)
        {
            $reject_code_array = $sql->result();

            foreach($reject_code_array as $rej_code)
            {
                $reject_code[] = $rej_code->reject_code;
            }

        }

        $finArray = array();

        $dags = $this->SettlementKhasModel->getSettlementDag($case_no);

        foreach(json_decode(REJECTED_REMARK_HEAD) as $reject)
        {
            foreach($res as $key => $code)
            {
                if($reject->CODE == $code->remark_head)
                {
                    $code->head = $reject->NAME;
                    $finArray[] =  $code;
                }
            }

        }

        $data = array(
            'responseType' => 2,
            'data' => $finArray,
            'res' => $res,
            'lm_rejected_remark' => $lm_rej_remark1,
            // 'dag_no_array' => $dag_no_arr,
            'dagsArray' => $dags,
            'masterArray' => $masterArray,
            'head' => json_decode(REJECTED_REMARK_HEAD)
        );
        echo json_encode($data);
    }


    // show rejected category in modal
    public function getRejectCat($sid)
    {
        $sql = "SELECT reject_code,remark FROM reject_master WHERE
                flag=? and service_code in ('$sid')";
        $res = $this->db->query($sql, array('1'))->result();

        echo json_encode($res);
    }


    // Post Rejected with Reason for SDLAC
    public function postRejectedReason()
    {

        $json         = null;
        $message      = null;
        $all_remark   = null;
        $reject_code  = $this->input->post('reject_code');
        $case_no      = trim($this->input->post('case_no'));
        $ref_no       = $this->input->post('ref_no');
        $remark       = $this->input->post('remark');
        $desg         = $this->session->userdata('user_desig_code');
        $service_code = trim($this->input->post('service_code'));
        $user_code    = $this->session->userdata('user_code');
        $serialId     = $this->input->post('serialId');
        $sub_rejected_remark = $this->input->post('sub_rejected_reasons');

        $decrypted = dec_param($case_no, 'case_no');
        $case_no   = !is_null($decrypted) ? trim($decrypted) : $case_no;

        if(isset($sub_rejected_remark))
        {
            if($sub_rejected_remark)
            {
                $sub_rejected_remark = $sub_rejected_remark;

                $sub_rejected_reasons = $_POST['sub_rejected_reasons'];
                foreach ($sub_rejected_reasons as $single_sub_rejected_reasons => $value)
                {
                    if(trim($value)== NULL OR trim($value)== '')
                    {
                        $errorSubRemarks[] =  $single_sub_rejected_reasons;
                    }
                }
            }
            else
            {
                $sub_rejected_remark = array();
            }
        }
        else
        {
            $sub_rejected_remark = array();
        }

        if(isset($errorSubRemarks) && sizeof($errorSubRemarks) > 0 )
        {
            $json = [
                'success' => false,
                'message' => 'Remarks for some of the selected category is empty. Please verify properly each selected category',
            ];
            echo json_encode($json);
            return;
        }

        $validation = [
            [
                'field' => 'reject_code',
                'label' => 'Reject Remark',
                'rules' => 'required',
            ],
            [
//                'field' => 'remark',
//                'label' => 'Reject Reason',
//                'rules' => 'trim|required|min_length[50]|callback_check_script|xss_clean',
            ],
        ];

        $this->form_validation->set_rules($validation);
        $this->form_validation->set_message('check_script', 'Invalid characters 
            entered in %s field');

        if ($this->form_validation->run('validation') == FALSE)
        {
            foreach ($validation as $rule)
            {
                if (form_error($rule['field']))
                {
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

        $countCaseInProposal = $this->SettlementCommonDcModel->countSettlementProposalPendingCaseByCaseNo($case_no);
        if($countCaseInProposal == 0)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERMR00232: This Case not found in SDLAC proposal' );
            $json = [
                'success' => false,
                'message' => '#ERMR00232: This Case not found in SDLAC proposal',
            ];
            echo json_encode($json);
            return;

        }

        //*******Delete from rejected_remark if exist */
        $delelte_remark = $this->db->query('DELETE FROM rejected_remark WHERE case_no =? AND service_code = ? AND user_code = ?', array($case_no, $service_code, $user_code));
        if($delelte_remark != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERMR00251: Delete failed in rejected_remark: ' . $this->db->last_query());
            $json = [
                'success' => false,
                'message' => '#ERMR00251: Unable to process',
            ];
            echo json_encode($json);
            return;
        }


        if($service_code != RECLASS_ID)
        {
            // check pull request from here
            $basic = $this->SettlementPullModel->getSettlementBasicDetails($case_no);
            if ($basic->pull_request == 1) {
                $dist_code = $this->session->userdata('dist_code');
                $requested = $this->SettlementPullModel->getModificationRequestCaseDetailsForRevertCase($case_no, $dist_code, $basic->service_code);
                if ($requested->num_rows() == 0) {
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 1,
                        'message' => '#MRPEJ000877: Case not found in Modification Request  ! Kindly contact system administrator',
                    ]);
                    return false;
                }

                $updateReq = [
                    'final_status' => MODIFICATION_REQUEST_REJECTED,
                    'approved_by' => trim($this->session->userdata('user_desig_code')),
                    'approved_by_uc' => $user_code,
                    'approve_date' => date('Y-m-d H:i:s'),
                    'approved_remarks' => $remark,
                    'pending_request_officer' => '',
                ];

                $this->db->where('id', $requested->id);
                $this->db->update('settlement_pull_request', $updateReq);
                if ($this->db->affected_rows() != 1) {
                    log_message('error', '#MRPEJ000898: updating  failed in settlement_pull_request and query is: ' . $this->db->last_query());
                    $this->db->trans_rollback();
                    echo json_encode([
                        'responseType' => 1,
                        'message' => '#MRPEJ000898: Rejected request cancelled ! Kindly contact system administrator',
                    ]);
                    return false;
                }
            }

        }


        //table update as per service
        $params = $this->rejectTableServiceWise($case_no, $user_code,$service_code);
        if ($params[1] != 1) {
            $this->db->trans_rollback();
            log_message('error', '#ERREJ0001: Updating failed in ' . $params[0] . ' and query is: ' . $this->db->last_query());
            $json = [
                'success' => false,
                'message' => '#ERREJ0001: Unable to process',
            ];
            echo json_encode($json);
            return;
        }

        //*****update in settlement_proposal_cases in case of rejected case */
        $updateArr2 = [
            'rejected_flag' => 1,
            'case_status'   => 2,
            'template_remarks'   => 'Not Recommended',

        ];

        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_proposal_cases', $updateArr2);

        if($this->db->affected_rows() <= 0)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERMR00286: Unable to update settlement_proposal_cases: ' . $this->db->last_query());
            $json = [
                'success' => false,
                'message' => '#ERMR00286: Unable to process',
            ];
            echo json_encode($json);
            return;
        }
        // _______________________________

        $getRemarkList = [];
        $rejectCodeArray = array();


        $firstArray = array();
        foreach($reject_code as $r_code)
        {
            $firstArray[] = $r_code;
        }

        $secondArray = array();
        foreach($sub_rejected_remark as $s_key => $s_val)
        {
            $secondArray[] = $s_key;
        }

        $diffArray = array_diff($firstArray, $secondArray);

        $final_array = array();

        foreach ($reject_code as $rej_code)
        {
            foreach($sub_rejected_remark as $sub_key => $sub_val)
            {
                if($sub_key == $rej_code)
                {
                    $final_array[] = $rej_code;

                    $rd_codeA = explode('_', $rej_code);

                    $array = [
                        'service_code'   => $service_code,
                        'reject_code'    => $rd_codeA[0],
                        'case_no'        => $case_no,
                        'user_code'      => $user_code,
                        'remark'         => $remark,
                        'sub_remark'     => $sub_val,
                        'ref_no'         => $ref_no,
                        'date_entry'     => date('Y-m-d'),
                        'datetime_entry' => date('Y-m-d H:i:s'),
                    ];


                    //*************** Insert into Reject Remarks Table********* /
                    $insert = $this->db->insert('rejected_remark', $array);
                    if ($insert != 1) {
                        $this->db->trans_rollback();
                        log_message('error', '#ERMR00343: Insertion failed in rejected_remark and query is: ' . $this->db->last_query());
                        $json = [
                            'success' => false,
                            'message' => '#ERMR00343: Unable to process',
                        ];
                        echo json_encode($json);
                        return;
                    }


                    $sql = $this->db->query("SELECT * FROM reject_master WHERE reject_code = ?", array($rd_codeA[0]));

                    $getRemarkList[] = $sql->row()->remark.':'.$sub_val;

                    $rejectCodeArray[] = [
                        'service_code' => $sql->row()->service_code,
                        'id'  => $sql->row()->reject_code,
                        'name' => $sql->row()->remark.': '.$sub_val,
                    ];

                }
            }
        }

        foreach($diffArray as $difAr)
        {
            $final_array[] = $difAr;
            $rd_codeAr = explode('_', $difAr);


            $array2 = [
                'service_code'   => $service_code,
                'reject_code'    => $rd_codeAr[0],
                'case_no'        => $case_no,
                'user_code'      => $user_code,
                // 'remark'         => $remark,
                // 'sub_remark'     => $sub_val,
                'ref_no'         => $ref_no,
                'date_entry'     => date('Y-m-d'),
                'datetime_entry' => date('Y-m-d H:i:s'),
            ];

            //*************** Insert into Reject Remarks Table********* /
            $insert = $this->db->insert('rejected_remark', $array2);
            if ($insert != 1) {
                $this->db->trans_rollback();
                log_message('error', '#ERMR00389: Insertion failed in rejected_remark and query is: ' . $this->db->last_query());
                $json = [
                    'success' => false,
                    'message' => '#ERMR00389: Unable to process',
                ];
                echo json_encode($json);
                return;
            }

            $sql = $this->db->query("SELECT * FROM reject_master WHERE reject_code = ?", array($rd_codeAr[0]));

            $getRemarkList[] = $sql->row()->remark;
            $rejectCodeArray[] = [
                'service_code' => $sql->row()->service_code,
                'id'  => $sql->row()->reject_code,
                'name' => $sql->row()->remark
            ];
        }

        $rejectedReasonList = implode ( ", ", $getRemarkList );

        //*****chitha flag work by JS */

        //*****getting dag_details */
        $dags = $this->SettlementKhasModel->getSettlementDag($case_no);

        foreach ($dags as $chitha_dag)
        {
            foreach($reject_code as $rDag)
            {
                $rDagF = explode('_', $rDag);

                if(isset($rDagF[1]))
                {
                    if($chitha_dag->dag_no == $rDagF[1])
                    {
                        $chitha_dist_code = $chitha_dag->dist_code;
                        $chitha_subdiv_code = $chitha_dag->subdiv_code;
                        $chitha_cir_code = $chitha_dag->cir_code;
                        $chitha_mouza_pargona_code = $chitha_dag->mouza_pargona_code;
                        $chitha_lot_no = $chitha_dag->lot_no;
                        $chitha_vill_townprt_code = $chitha_dag->vill_townprt_code;

                        $vil_uuid = $this->utilityclass->getVillageUUID($chitha_dist_code, $chitha_subdiv_code, $chitha_cir_code, $chitha_mouza_pargona_code, $chitha_lot_no, $chitha_vill_townprt_code);

                        $checkDagExistSql = $this->db->query('SELECT COUNT(*) AS count FROM chitha_dag WHERE uuid = ? AND dag_no = ?', array($vil_uuid, $chitha_dag->dag_no));

                        if($checkDagExistSql->row()->count <= 0)
                        {
                            //******insert into chitha_dag if not already exist */
                            $ifInsertDag = 0;

                            foreach($final_array as $r_cct)
                            {
                                $rfC = explode('_', $r_cct);

                                $getChithaFlagIdFirst = $this->db->query('SELECT chitha_flag FROM reject_master WHERE reject_code = ?', array($rfC[0]));

                                if($getChithaFlagIdFirst->num_rows() <= 0)
                                {
                                    continue;
                                }
                                else
                                {
                                    $chitha_flag_first = $getChithaFlagIdFirst->row()->chitha_flag;
                                    if($chitha_flag_first != 0)
                                    {
                                        $ifInsertDag = 1;
                                        break;
                                    }
                                }
                            }

                            if($ifInsertDag == 1)
                            {
                                $insertChitaDagArr = [
                                    'dist_code' => $chitha_dist_code,
                                    'subdiv_code' => $chitha_subdiv_code,
                                    'cir_code' => $chitha_cir_code,
                                    'mouza_pargona_code' => $chitha_mouza_pargona_code,
                                    'lot_no' => $chitha_lot_no,
                                    'vill_townprt_code' => $chitha_vill_townprt_code,
                                    'uuid' => $vil_uuid,
                                    'dag_no' => $chitha_dag->dag_no,
                                    'created_at' => date('Y-m-d H:i:s')
                                ];

                                $chithaDagInsert = $this->db->insert('chitha_dag', $insertChitaDagArr);

                                if($chithaDagInsert != 1)
                                {
                                    $this->db->trans_rollback();
                                    $json = [
                                        'success' => false,
                                        'message' => '#ERRR2662: Unable to process',
                                    ];
                                    echo json_encode($json);
                                    return false;
                                }
                            }

                        }

                        //****getting the dag_id  */

                        $getDagIdFromchitha_dagSql = $this->db->query('SELECT dag_id, dag_no FROM chitha_dag WHERE uuid = ? AND dag_no = ?', array($vil_uuid, $chitha_dag->dag_no));

                        if($getDagIdFromchitha_dagSql->num_rows() > 0)
                        {
                            $dag_id = $getDagIdFromchitha_dagSql->row()->dag_id;
                            $dag_no_f = $getDagIdFromchitha_dagSql->row()->dag_no;

                            //******itering through selected remarks with db chitha_flag */
                            foreach($final_array as $r_cc)
                            {
                                $rfF = explode('_', $r_cc);

                                if(isset($rfF[1]))
                                {
                                    $a_dag_no = $rfF[1];
                                }
                                else
                                {
                                    $a_dag_no = '';
                                }

                                if($dag_no_f == $a_dag_no)
                                {
                                    $getChithaFlagId = $this->db->query('SELECT chitha_flag FROM reject_master WHERE reject_code = ?', array($rfF[0]));

                                    if($getChithaFlagId->num_rows() <= 0)
                                    {
                                        continue;
                                    }
                                    else
                                    {
                                        $chitha_flag = $getChithaFlagId->row()->chitha_flag;

                                        if($chitha_flag != 0)
                                        {
                                            //****inserting into dagwise_flag if already not inserted */
                                            $checkIndagwise_flagSql = $this->db->query('SELECT * FROM dagwise_flag WHERE dag_id = ? AND dag_flag_master_id = ?', array($dag_id, $chitha_flag));

                                            if($checkIndagwise_flagSql->num_rows() <= 0)
                                            {
                                                //******insert into dagwise_flag */
                                                $dagwiseFlagArr = [
                                                    'dag_id' => $dag_id,
                                                    'dag_flag_master_id' => $chitha_flag,
                                                    'created_at' => date('Y-m-d H:i:s'),
                                                    'user_code' => $user_code,
                                                ];

                                                $insertDagFlag = $this->db->insert('dagwise_flag', $dagwiseFlagArr);

                                                if($insertDagFlag != 1)
                                                {
                                                    $this->db->trans_rollback();
                                                    $json = [
                                                        'success' => false,
                                                        'message' => '#ERRR266246: Unable to process',
                                                    ];
                                                    echo json_encode($json);
                                                    return false;
                                                }
                                            }
                                            else
                                            {
                                                //*******do nothing */
                                            }
                                        }
                                    }
                                }

                            }
                        }
                    }
                }
            }
        }

        //*****End chitha flag work by JS */

        $this->db->trans_commit();
        $this->session->set_flashdata('message', 'Case No. ' . $case_no . ' has been successfully rejected !!');
        $json = [
            'success' => true,
            'serial_id' => $serialId,
            'remark_list' => $rejectedReasonList,
            'message' => 'Case has been successfully Rejected !!',
            // 'redirect' => $_SERVER["HTTP_REFERER"],
        ];
        echo json_encode($json);
        return;
    }


    // insert proceeding
    public function proceedingDCADCRemark($case_no,$rejectedReasonList)
    {
        $case_no = trim($case_no);

        $decrypted = dec_param($case_no, 'case_no');
        $case_no   = !is_null($decrypted) ? trim($decrypted) : $case_no;

        $sql = "select MAX(proceeding_id) as id from settlement_proceeding where
               case_no=? ";
        $res = $this->db->query($sql, array($case_no));
        if ($res->num_rows() > 0) {
            $proceeding_id = $res->row()->id + 1;
        } else {
            $proceeding_id = 1;
        }

        $values = array(
            'case_no'              => $case_no,
            'proceeding_id'        => $proceeding_id,
            'date_of_hearing'      => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'status'               => MB_DISMISS,
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d h:i:s'),
            'operation'            => 'E',
            'note_on_order'        => 'Rejected for: '.$rejectedReasonList,
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => $this->session->userdata('user_desig_code'),
            'office_to'            => '',
            'task'                 => 'Rejected by ' . trim($this->session->userdata('user_desig_code')),
        );
        return $this->db->insert("settlement_proceeding", $values);
    }


    // insert proceeding direct rejected
    public function proceedingDCADCSDODirectRemark($case_no,$rejectedReasonList,$remark)
    {
        $case_no = trim($case_no);

        $decrypted = dec_param($case_no, 'case_no');
        $case_no   = !is_null($decrypted) ? trim($decrypted) : $case_no;

        $sql = "select MAX(proceeding_id) as id from settlement_proceeding where
               case_no=? ";
        $res = $this->db->query($sql, array($case_no));
        if ($res->num_rows() > 0) {
            $proceeding_id = $res->row()->id + 1;
        } else {
            $proceeding_id = 1;
        }

        $values = array(
            'case_no'              => $case_no,
            'proceeding_id'        => $proceeding_id,
            'date_of_hearing'      => date('Y-m-d h:i:s'),
            'next_date_of_hearing' => date('Y-m-d h:i:s'),
            'status'               => MB_DISMISS,
            'user_code'            => $this->session->userdata('user_code'),
            'date_entry'           => date('Y-m-d h:i:s'),
            'operation'            => 'E',
            'note_type'            => $remark,
            'note_on_order'        => 'Rejected for: '.$rejectedReasonList,
            'ip'                   => $this->utilityclass->get_client_ip(),
            'office_from'          => $this->session->userdata('user_desig_code'),
            'office_to'            => '',
            'task'                 => 'Rejected by ' . trim($this->session->userdata('user_desig_code')),
        );
        return $this->db->insert("settlement_proceeding", $values);
    }


    // update on settlement basic table for direct reject
    public function rejectDirectTableServiceWise($case_no, $user_code)
    {
        $case_no = trim($case_no);

        $decrypted = dec_param($case_no, 'case_no');
        $case_no   = !is_null($decrypted) ? trim($decrypted) : $case_no;

        $table = array();
        if ($this->session->userdata('user_desig_code') == MB_DEPUTY_COMM || $this->session->userdata('user_desig_code') == MB_ADD_DEPUTY_COMM || $this->session->userdata('user_desig_code') == MB_SUB_DIV_COMM)
        {
            $name = $this->utilityclass->dcname($this->session->userdata('dist_code'), $user_code);
            $RejectedOfficerName = $name;
        }

        $array = [
            'user_code'       => $user_code,
            'dc_code'         => $user_code,
            'status'          => MB_DISMISS,
            'pending_office'  => trim($this->session->userdata('user_desig_code')),
            'pending_officer' => trim($this->session->userdata('user_desig_code')),
            'from_office'     => trim($this->session->userdata('user_desig_code')),
            'dc_proceeding'   => 0,
            'rejected_flag'   => 1,
            'pull_request'    => 0,
            'vgr_revival_flag'=> 0,

        ];
        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $array);
        $table[] = 'settlement_basic';
        $table[] = $this->db->affected_rows();
        return $table;
    }



    // update on settlement basic table
    public function rejectTableServiceWise($case_no, $user_code,$service_code)
    {
        $case_no = trim($case_no);

        $decrypted = dec_param($case_no, 'case_no');
        $case_no   = !is_null($decrypted) ? trim($decrypted) : $case_no;

        $service_code = trim($service_code);

        $table = array();
        if ($this->session->userdata('user_desig_code') == MB_DEPUTY_COMM || $this->session->userdata('user_desig_code') == MB_ADD_DEPUTY_COMM || $this->session->userdata('user_desig_code') == MB_SUB_DIV_COMM)
        {
            $name = $this->utilityclass->dcname($this->session->userdata('dist_code'), $user_code);
            $RejectedOfficerName = $name;
        }

        $array = [
            'user_code'       => $user_code,
            'final_status'  => MB_DISMISS,
            'rejected_flag' => 1,
            'pull_request'  => 0,

        ];
        $this->db->where('case_no', $case_no);
        if($service_code == RECLASS_ID)
        {
            $this->db->update('reclass_suite_basic', $array);
            $table[] = 'reclass_suite_basic';
        }
        else
        {
            $this->db->update('settlement_basic', $array);
            $table[] = 'settlement_basic';
        }

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


    // Post Rejected with Reason Direct by SDO/ADC/DC/CO
    public function postRejectedDirectReason()
    {
        $json         = null;
        $message      = null;
        $all_remark   = null;
        $reject_code  = $this->input->post('reject_code');
        $case_no      = trim($this->input->post('case_no'));
        $ref_no       = $this->input->post('ref_no');
        $remark       = $this->input->post('remark');
        $desg         = $this->session->userdata('user_desig_code');
        $service_code = trim($this->input->post('service_code'));
        $user_code    = $this->session->userdata('user_code');
        $serialId     = $this->input->post('serialId');
        $dist_code    = $this->session->userdata('dist_code');
        $sub_rejected_remark = $this->input->post('sub_rejected_reasons');

        $decrypted = dec_param($case_no, 'case_no');
        $case_no   = !is_null($decrypted) ? trim($decrypted) : $case_no;

        if(!in_array($desg, [MB_DEPUTY_COMM, MB_ADD_DEPUTY_COMM, MB_SUB_DIV_COMM, MB_CIRCLE_OFFICER]))
        {
            $json = [
                'success' => false,
                'message' => 'Session time out! Please login and try again',
            ];
            echo json_encode($json);
            return;
        }

        //        $errorSubRemarks[] = '';
        if(isset($sub_rejected_remark))
        {
            if($sub_rejected_remark)
            {
                $sub_rejected_remark = $sub_rejected_remark;

                $sub_rejected_reasons = $_POST['sub_rejected_reasons'];
                foreach ($sub_rejected_reasons as $single_sub_rejected_reasons => $value)
                {
                    if(trim($value)== NULL OR trim($value)== '')
                    {
                        $errorSubRemarks[] =  $single_sub_rejected_reasons;
                    }
                }
            }
            else
            {
                $sub_rejected_remark = array();
            }
        }
        else
        {
            $sub_rejected_remark = array();
        }

        if(isset($errorSubRemarks) && sizeof($errorSubRemarks) > 0 )
        {

            $json = [
                'success' => false,
                'message' => 'Remarks for some of the selected category is empty. Please verify properly each selected category',
            ];
            echo json_encode($json);
            return;
        }

        $validation = [
            [
                'field' => 'reject_code',
                'label' => 'Reject Remark',
                'rules' => 'required',
            ],
            [
//                'field' => 'remark',
//                'label' => 'Reject Reason',
//                'rules' => 'trim|required|min_length[50]|callback_check_script|xss_clean',
            ],
        ];

        $this->form_validation->set_rules($validation);
        $this->form_validation->set_message('check_script', 'Invalid characters 
            entered in %s field');

        if ($this->form_validation->run('validation') == FALSE)
        {
            foreach ($validation as $rule)
            {
                if (form_error($rule['field']))
                {
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

        $countCaseInProposal = $this->SettlementCommonDcModel->countSettlementProposalPendingCaseByCaseNo($case_no);
        if($countCaseInProposal != 0)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERREJM001: This Case Already Forwarded to SDLAC' );
            $json = [
                'success' => false,
                'message' => '#ERREJM001: This Case Already Forwarded to SDLAC',
            ];
            echo json_encode($json);
            return;

        }

        //*******Delete from rejected_remark if exist */
        $delelte_remark = $this->db->query('DELETE FROM rejected_remark WHERE case_no =? AND service_code = ? AND user_code = ?', array($case_no, $service_code, $user_code));
        if($delelte_remark != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERREJ0001334: Delete failed in rejected_remark: ' . $this->db->last_query());
            $json = [
                'success' => false,
                'message' => '#ERREJ0001334: Unable to process',
            ];
            echo json_encode($json);
            return;
        }


        // check pull request from here
        $basic = $this->SettlementPullModel->getSettlementBasicDetails($case_no);
        if($basic->pull_request == 1)
        {
            $dist_code = $this->session->userdata('dist_code');
            $requested = $this->SettlementPullModel->getModificationRequestCaseDetailsForRevertCase($case_no,$dist_code,$basic->service_code);
            if($requested->num_rows() == 0)
            {
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRPEJ000877: Case not found in Modification Request  ! Kindly contact system administrator',
                ]);
                return false;
            }

            $updateReq = [
                'final_status'   => MODIFICATION_REQUEST_REJECTED,
                'approved_by'    => trim($this->session->userdata('user_desig_code')),
                'approved_by_uc' => $user_code,
                'approve_date'   => date('Y-m-d H:i:s'),
                'approved_remarks'        => $remark,
                'pending_request_officer' => '',
            ];

            $this->db->where('id',$requested->id);
            $this->db->update('settlement_pull_request',$updateReq);
            if($this->db->affected_rows() !=1){
                log_message('error', '#MRPEJ000898: updating  failed in settlement_pull_request and query is: ' . $this->db->last_query());
                $this->db->trans_rollback();
                echo json_encode([
                    'responseType' => 1,
                    'message' => '#MRPEJ000898: Rejected request cancelled ! Kindly contact system administrator',
                ]);
                return false;
            }
        }


        //table update as per service in settlement basic
        $params = $this->rejectDirectTableServiceWise($case_no, $user_code);
        if ($params[1] != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERREJ0001: Updating failed in ' . $params[0] . ' and query is: ' . $this->db->last_query());
            $json = [
                'success' => false,
                'message' => '#ERREJ0001: Unable to process',
            ];
            echo json_encode($json);
            return;
        }


        $getRemarkList = [];
        $rejectCodeArray = array();


        $firstArray = array();
        foreach($reject_code as $r_code)
        {
            $firstArray[] = $r_code;
        }

        $secondArray = array();
        foreach($sub_rejected_remark as $s_key => $s_val)
        {
            $secondArray[] = $s_key;
        }

        $diffArray = array_diff($firstArray, $secondArray);

        $final_array = array();
        foreach ($reject_code as $rej_code)
        {
            foreach($sub_rejected_remark as $sub_key => $sub_val)
            {
                if($sub_key == $rej_code)
                {
                    $final_array[] = $rej_code;

                    $rd_codeA = explode('_', $rej_code);

                    $array = [
                        'service_code'   => $service_code,
                        'reject_code'    => $rd_codeA[0],
                        'case_no'        => $case_no,
                        'user_code'      => $user_code,
                        // 'remark'         => $remark,
                        'sub_remark'     => $sub_val,
                        'ref_no'         => $ref_no,
                        'date_entry'     => date('Y-m-d'),
                        'datetime_entry' => date('Y-m-d H:i:s'),
                    ];

                    //*************** Insert into Reject Remarks Table********* /
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


                    $sql = $this->db->query("SELECT * FROM reject_master WHERE reject_code = ?", array($rd_codeA[0]));

                    $getRemarkList[] = $sql->row()->remark.':'.$sub_val;

                    $rejectCodeArray[] = [
                        'service_code' => $sql->row()->service_code,
                        'id'  => $sql->row()->reject_code,
                        'name' => $sql->row()->remark.': '.$sub_val,
                    ];

                }
            }
        }

        foreach($diffArray as $difAr)
        {

            $final_array[] = $difAr;

            $rd_codeAr = explode('_', $difAr);

            $array2 = [
                'service_code'   => $service_code,
                'reject_code'    => $rd_codeAr[0],
                'case_no'        => $case_no,
                'user_code'      => $user_code,
                // 'remark'         => $remark,
                // 'sub_remark'     => $sub_val,
                'ref_no'         => $ref_no,
                'date_entry'     => date('Y-m-d'),
                'datetime_entry' => date('Y-m-d H:i:s'),
            ];

            //*************** Insert into Reject Remarks Table********* /
            $insert = $this->db->insert('rejected_remark', $array2);
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


            $sql = $this->db->query("SELECT * FROM reject_master WHERE reject_code = ?", array($rd_codeAr[0]));

            $getRemarkList[] = $sql->row()->remark;

            $rejectCodeArray[] = [
                'service_code' => $sql->row()->service_code,
                'id'  => $sql->row()->reject_code,
                'name' => $sql->row()->remark
            ];
        }


        $rejectedReasonList = implode ( ", ", $getRemarkList );

        // if ($desg == MB_DEPUTY_COMM || $desg == MB_ADD_DEPUTY_COMM || $desg == MB_SUB_DIV_COMM || $desg == MB_CIRCLE_OFFICER)
        // {
        //*************** Insert into Settlement Proceeding DC ADC ********* /
        $proceeding = $this->proceedingDCADCSDODirectRemark($case_no, $rejectedReasonList,$remark);
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
        // }


        //==========================================================================================
        //*****chitha flag work */

        //*****getting dag_details */
        $dags = $this->SettlementKhasModel->getSettlementDag($case_no);

        foreach ($dags as $chitha_dag)
        {
            foreach($reject_code as $rDag)
            {
                $rDagF = explode('_', $rDag);

                if(isset($rDagF[1]))
                {
                    if($chitha_dag->dag_no == $rDagF[1])
                    {
                        $chitha_dist_code = $chitha_dag->dist_code;
                        $chitha_subdiv_code = $chitha_dag->subdiv_code;
                        $chitha_cir_code = $chitha_dag->cir_code;
                        $chitha_mouza_pargona_code = $chitha_dag->mouza_pargona_code;
                        $chitha_lot_no = $chitha_dag->lot_no;
                        $chitha_vill_townprt_code = $chitha_dag->vill_townprt_code;

                        $vil_uuid = $this->utilityclass->getVillageUUID($chitha_dist_code, $chitha_subdiv_code, $chitha_cir_code, $chitha_mouza_pargona_code, $chitha_lot_no, $chitha_vill_townprt_code);

                        $checkDagExistSql = $this->db->query('SELECT COUNT(*) AS count FROM chitha_dag WHERE uuid = ? AND dag_no = ?', array($vil_uuid, $chitha_dag->dag_no));

                        if($checkDagExistSql->row()->count <= 0)
                        {
                            //******insert into chitha_dag if not already exist */
                            $ifInsertDag = 0;

                            foreach($final_array as $r_cct)
                            {
                                $rfC = explode('_', $r_cct);

                                $getChithaFlagIdFirst = $this->db->query('SELECT chitha_flag FROM reject_master WHERE reject_code = ?', array($rfC[0]));

                                if($getChithaFlagIdFirst->num_rows() <= 0)
                                {
                                    continue;
                                }
                                else
                                {
                                    $chitha_flag_first = $getChithaFlagIdFirst->row()->chitha_flag;
                                    if($chitha_flag_first != 0)
                                    {
                                        $ifInsertDag = 1;
                                        break;
                                    }
                                }
                            }

                            if($ifInsertDag == 1)
                            {
                                $insertChitaDagArr = [
                                    'dist_code' => $chitha_dist_code,
                                    'subdiv_code' => $chitha_subdiv_code,
                                    'cir_code' => $chitha_cir_code,
                                    'mouza_pargona_code' => $chitha_mouza_pargona_code,
                                    'lot_no' => $chitha_lot_no,
                                    'vill_townprt_code' => $chitha_vill_townprt_code,
                                    'uuid' => $vil_uuid,
                                    'dag_no' => $chitha_dag->dag_no,
                                    'created_at' => date('Y-m-d H:i:s')
                                ];

                                $chithaDagInsert = $this->db->insert('chitha_dag', $insertChitaDagArr);

                                if($chithaDagInsert != 1)
                                {
                                    $this->db->trans_rollback();
                                    $json = [
                                        'success' => false,
                                        'message' => '#ERRR2662: Unable to process',
                                    ];
                                    echo json_encode($json);
                                    return false;
                                }
                            }

                        }

                        //****getting the dag_id  */

                        $getDagIdFromchitha_dagSql = $this->db->query('SELECT dag_id, dag_no FROM chitha_dag WHERE uuid = ? AND dag_no = ?', array($vil_uuid, $chitha_dag->dag_no));

                        if($getDagIdFromchitha_dagSql->num_rows() > 0)
                        {
                            $dag_id = $getDagIdFromchitha_dagSql->row()->dag_id;
                            $dag_no_f = $getDagIdFromchitha_dagSql->row()->dag_no;

                            //******itering through selected remarks with db chitha_flag */
                            foreach($final_array as $r_cc)
                            {
                                $rfF = explode('_', $r_cc);

                                if(isset($rfF[1]))
                                {
                                    $a_dag_no = $rfF[1];
                                }
                                else
                                {
                                    $a_dag_no = '';
                                }

                                if($dag_no_f == $a_dag_no)
                                {
                                    $getChithaFlagId = $this->db->query('SELECT chitha_flag FROM reject_master WHERE reject_code = ?', array($rfF[0]));

                                    if($getChithaFlagId->num_rows() <= 0)
                                    {
                                        continue;
                                    }
                                    else
                                    {
                                        $chitha_flag = $getChithaFlagId->row()->chitha_flag;

                                        if($chitha_flag != 0)
                                        {
                                            //****inserting into dagwise_flag if already not inserted */
                                            $checkIndagwise_flagSql = $this->db->query('SELECT * FROM dagwise_flag WHERE dag_id = ? AND dag_flag_master_id = ?', array($dag_id, $chitha_flag));

                                            if($checkIndagwise_flagSql->num_rows() <= 0)
                                            {
                                                //******insert into dagwise_flag */
                                                $dagwiseFlagArr = [
                                                    'dag_id' => $dag_id,
                                                    'dag_flag_master_id' => $chitha_flag,
                                                    'created_at' => date('Y-m-d H:i:s'),
                                                    'user_code' => $user_code,
                                                ];

                                                $insertDagFlag = $this->db->insert('dagwise_flag', $dagwiseFlagArr);

                                                if($insertDagFlag != 1)
                                                {
                                                    $this->db->trans_rollback();
                                                    $json = [
                                                        'success' => false,
                                                        'message' => '#ERRR266246: Unable to process',
                                                    ];
                                                    echo json_encode($json);
                                                    return false;
                                                }
                                            }
                                            else
                                            {
                                                //*******do nothing */
                                            }
                                        }
                                    }
                                }

                            }
                        }
                    }
                }
            }
        }

        //*********VGR/PGR reverted cases work */

        // basic_pending_office
        // basic_pending_officer
        // basic_status
        // basic_from_office

        if($service_code == SETTLEMENT_PGR_VGR_LAND_ID)
        {

            $dist_code = $this->session->userdata('dist_code');
            $getCaseRevertedVgrSql = $this->db->query('select * from settlement_vgr_pgr_revert_cases where case_no = ? and status = ?', array($case_no, 1));

            if($getCaseRevertedVgrSql->num_rows() > 0)
            {
                //*******if this falls under the reverted conditions then only execute this */
                //*******update settlement_vgr_pgr_revert_cases table */
                $revertVgrTArr = [
                    'user_code' => $this->session->userdata('user_code'),
                    'status' => 0,
                    'approve_status' => MB_DISMISS,
                    'from_office' => 'CO',
                    'to_office' => 'CO',
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                $this->db->where('case_no', $case_no);
                $this->db->where('status', 1);
                $this->db->update('settlement_vgr_pgr_revert_cases', $revertVgrTArr);

                if($this->db->affected_rows() != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERREJ1280: Updation failed in settlement_vgr_pgr_revert_cases and query is: ' . $this->db->last_query());
                    $json = [
                        'success' => false,
                        'message' => '#ERREJ1280: Unable to process',
                    ];
                    echo json_encode($json);
                    return;
                }

                // ***************delete proposal cases from settlement_proposal_cases table*******
                $revertedTableRow = $getCaseRevertedVgrSql->row();
                $revertedTableProposalID = $revertedTableRow->proposal_id;
                $revertedTableMeetingID = $revertedTableRow->meeting_id;
                // $revertedTableCaseNo = $revertedTableRow->case_no;

                $deleteCase = $this->SettlementCommonDcModel->getSettlementProposalCaseDetailsByCaseNoModificationCo($case_no);
                if($deleteCase->num_rows() != 1)
                {
                    echo json_encode([
                        'responseType' => 1,
                        'message' => '#MRVGRRR0002505: Proposal case no. not match ! Kindly contact system administrator',
                    ]);
                    return false;
                }
                $deleteCase = $deleteCase->row();
                $insertIntoDeletedTable = array(
                    'proposal_id' => trim($deleteCase->proposal_id),
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
                    log_message('error', '#ERMR001323: Insertion failed in settlement_proposal_cases_deleted for case no :'. $case_no);
                    $json = [
                        'success' => false,
                        'message' => '#ERMR001323: Unable to process',
                    ];
                    echo json_encode($json);
                    return;
                }

                $deleteProCase = $this->SettlementCommonDcModel->deleteSettlementProposalCaseDetailsById($deleteCase->id);
                if($deleteProCase != 1)
                {
                    $this->db->trans_rollback();
                    log_message('error', '#ERMR1338: Deletion failed in settlement_proposal_cases for case no :'. $case_no);
                    $json = [
                        'success' => false,
                        'message' => '#ERMR1338: Unable to process',
                    ];
                    echo json_encode($json);
                    return;
                }

                //*************proposal_meeting_list update if only one case left in  settlement_vgr_pgr_revert_cases*/
                $propML = $this->db->query('select * from settlement_vgr_pgr_revert_cases where status = ? and meeting_id = ?', array(1, $revertedTableMeetingID));

                if($propML->num_rows() <= 0)
                {
                    $updateMeeting = array(
                        'vgr_pgr_revert_status' => 0
                    );

                    $this->db->where('id', $revertedTableMeetingID);
                    $this->db->where('dist_code', $dist_code);
                    $this->db->update('proposal_meeting_list', $updateMeeting);

                    if($this->db->affected_rows() != 1)
                    {
                        $this->db->trans_rollback();
                        log_message('error', '#MRVGRR005093: Updation failed in proposal_meeting_list for meeting no : '.$revertedTableMeetingID. ' and query is '. $this->db->last_query());

                        $json = [
                            // 'responseType' => 1,
                            // 'message' => '#MRVGRR005093: Case can not be reverted. Kindly contact system administrator',
                            'success' => false,
                            'message' => '#MRVGRR005093: Case can not be rejected. Kindly contact system administrator',
                        ];
                        echo json_encode($json);
                        return false;
                    }
                }

            }
        }

        ////////////// POST Reject status To basundhara ////////////////////
        $application_no = $this->SettlementApModel->getSettlementBasicCo($case_no)->applid;
        $rmk = 'Rejected by ' . $desg.': '.$rejectedReasonList;
        $status = 'R';
        $task = $desg;
        $pen  = 'NA';
        $task = trim($this->session->userdata('user_desig_code'));
        $rtps_status = $this->SettlementApiModel->postApiBasundharaForRejectedCase2nd($application_no, $case_no, $rmk, $status, $task, $pen, $rejectCodeArray);
        if ($rtps_status != "y")
        {
            $this->db->trans_rollback();
            log_message('error', '#ERREJ0005: API failed.');
            $json = [
                'success' => false,
                'message' => '#ERREJ0005: Unable to process',
            ];
            echo json_encode($json);
            return;
        }

        //////POST to Basundhara End

        $this->db->trans_commit();
        $this->session->set_flashdata('message', 'Case No. ' . $case_no . ' has been successfully rejected !!');
        $json = [
            'success' => true,
            'serial_id' => $serialId,
            'remark_list' => implode ( ', ', $getRemarkList ),
            'message' => 'Case has been successfully Rejected !!',
            'user_desig_code' => $this->session->userdata('user_desig_code'),
            // 'redirect' => $_SERVER["HTTP_REFERER"],
        ];
        echo json_encode($json);
        return;
    }


    // ///  Masud's code end here // ///







    function CaseSearchForBasundhara($case)
    {
        $case = trim($case);

        $decrypted = dec_param($case, 'case_no');
        $case   = !is_null($decrypted) ? trim($decrypted) : $case;

        $sql = "Select trans_code from petition_basic where case_no='$case'
        union
        Select trans_code from field_mut_basic where case_no='$case'
         ";

        return $this->db->query($sql)->row()->trans_code;
    }


    public function proceedingRemark($case_no, $remark)
    {
        $case_no = trim($case_no);

        $decrypted = dec_param($case_no, 'case_no');
        $case_no   = !is_null($decrypted) ? trim($decrypted) : $case_no;

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
            'date_entry' => date('Y-m-d h:i:s'),
            'operation' => 'E',
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code
        );
        return $this->db->insert("settlement_proceeding", $values);
    }


    public function deleteRejectRemarkOnConfirm()
    {
        $case_no = $this->input->post('case_no');
        $user_code = $this->session->userdata('user_code');
        $service_code = $this->input->post('service_code');
        //*******Delete from rejected_remark if exist */

        $decrypted = dec_param($case_no, 'case_no');
        $case_no   = !is_null($decrypted) ? trim($decrypted) : $case_no;

        $this->db->trans_begin();

        $updateArr = [
            'rejected_flag' => 0,
            'final_status'  => 'J',
        ];

        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_basic', $updateArr);

        if($this->db->affected_rows() <= 0)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERREJ00013333433: Unable to update settlement_basic: ' . $this->db->last_query());
            $json = [
                'response' => 0,
                'message' => '#ERREJ00013333433: Unable to process! Contact admin...',
            ];
            echo json_encode($json);
            return;
        }

        $updateArr2 = [
            'rejected_flag' => 0,
            'case_status'   => 1,
            'template_remarks' => 'Recommended',

        ];

        $this->db->where('case_no', $case_no);
        $this->db->update('settlement_proposal_cases', $updateArr2);

        if($this->db->affected_rows() <= 0)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERREJ000133333: Unable to update settlement_proposal_cases: ' . $this->db->last_query());
            $json = [
                'response' => 0,
                'message' => '#ERREJ000133333: Unable to process! Contact admin...',
            ];
            echo json_encode($json);
            return;
        }

        $delelte_remark = $this->db->query('DELETE FROM rejected_remark WHERE case_no =? AND user_code = ?', array($case_no, $user_code));

        if($delelte_remark != 1)
        {
            $this->db->trans_rollback();
            log_message('error', '#ERREJ000133433: Unable to delete rejected_remark: ' . $this->db->last_query());
            $json = [
                'response' => 0,
                'message' => '#ERREJ000133433: Unable to process! Contact admin...',
            ];
            echo json_encode($json);
            return;
        }
        else
        {
            $this->db->trans_commit();

            $json = [
                'response' => 2,
                'message' => 'All rejected remarks those has been selected by ADC/SDO are removed ...',
            ];
            echo json_encode($json);
        }
    }


    // direct reject
    public function checkIfRejectedDirectResonInserted()
    {
        $case_no = $this->input->post('case_no');
        $decrypted = dec_param($case_no, 'case_no');
        $case_no   = !is_null($decrypted) ? trim($decrypted) : $case_no;

        $sql = $this->db->query('SELECT * FROM rejected_remark WHERE case_no = ?', array($case_no));

        if($sql->num_rows() > 0)
        {
            echo json_encode([
                'responseType' => 2,
            ]);
            return false;
        }
        else
        {
            echo json_encode([
                'responseType' => 0,
            ]);
            return false;
        }

    }

    // reject under proposal
    public function checkIfRejectedResonInserted()
    {
        $case_no = $this->input->post('case_no');
        $decrypted = dec_param($case_no, 'case_no');
        $case_no   = !is_null($decrypted) ? trim($decrypted) : $case_no;

        $sql = $this->db->query('SELECT * FROM rejected_remark WHERE case_no = ?', array($case_no));

        if($sql->num_rows() > 0)
        {
            echo json_encode([
                'responseType' => 2,
            ]);
            return false;
        }
        else
        {
            echo json_encode([
                'responseType' => 0,
            ]);
            return false;
        }

    }


}
